<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
		$this->load->model(array('Basico_model'));
    }

    public function resumo_estatisticas($data) {

        $query = $this->db->query('SELECT 
                C.idTab_Status, 
                COUNT(*) AS Total 
            FROM
                App_Agenda AS A, 
                App_Consulta AS C 
            WHERE 
                YEAR(DataInicio) = ' . date('Y', time()) . ' AND MONTH(DataInicio) = ' . date('m', time()) . ' AND
                C.Evento IS NULL AND 
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND 
                A.idSis_Usuario = ' . $data . ' AND 
                A.idApp_Agenda = C.idApp_Agenda 
            GROUP BY C.idTab_Status
            ORDER BY C.idTab_Status ASC');
        //$query = $query->result_array();
        if ($query->num_rows() !== 0) {

            foreach ($query->result() as $row) {
                $array[$row->idTab_Status] = $row->Total;
            }
            return $array;
        } else
            return FALSE;
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($array);
          echo "</pre>";
          exit ();
         */

        //if ($array->num_rows() === 0)
        //    return FALSE;
        //else
    }

    public function cliente_aniversariantes($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		if($data != FALSE){
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(DataNascimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(DataNascimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(DataNascimento) = ' . $data['Ano'] : FALSE;	
			$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;	
		}else{
			$data['Dia'] = ($_SESSION['Agendamentos']['Dia']) ? ' AND DAY(DataNascimento) = ' . $_SESSION['Agendamentos']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['Agendamentos']['Mesvenc']) ? ' AND MONTH(DataNascimento) = ' . $_SESSION['Agendamentos']['Mesvenc'] : FALSE;
			$data['Ano'] = ($_SESSION['Agendamentos']['Ano']) ? ' AND YEAR(DataNascimento) = ' . $_SESSION['Agendamentos']['Ano'] : FALSE;
			$data['idApp_Cliente'] = ($_SESSION['Agendamentos']['idApp_Cliente']) ? ' AND idApp_Cliente = ' . $_SESSION['Agendamentos']['idApp_Cliente'] : FALSE;	
		}
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
        $query = $this->db->query('
            SELECT 
                idApp_Cliente, 
                NomeCliente,
                DataNascimento,
				CelularCliente				
            FROM 
                App_Cliente
            WHERE 
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				' . $data['idApp_Cliente'] . '
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . '
				' . $data['Ano'] . '
            ORDER BY 
				DAY(DataNascimento) ASC,
				NomeCliente ASC
			' . $querylimit . '
		');

		if($total == TRUE) {
			return $query->num_rows();
		}
		
        /*
		
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */

        if ($completo === FALSE)
            return FALSE;
        else {

            foreach ($query->result() as $row) {
				$row->Idade = $this->basico->calcula_idade($row->DataNascimento);
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
            }            
            return $query;
        }
    }

    public function contatocliente_aniversariantes($data) {

        $query = $this->db->query('
            SELECT 
                D.idApp_Cliente, 
                D.idApp_ContatoCliente,
                D.NomeContatoCliente,
                D.DataNascimento,
				D.Telefone1
            FROM 
                App_ContatoCliente AS D,
                App_Cliente AS R
            WHERE               
				R.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (MONTH(D.DataNascimento) = ' . date('m', time()) . ') AND
                R.idApp_Cliente = D.idApp_Cliente            
            ORDER BY 
				NomeContatoCliente ASC');

        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */

        if ($query->num_rows() === 0)
            return FALSE;
        else {

            foreach ($query->result() as $row) {
                $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
            }
            return $query;
        }
    }

    public function get_agenda($data) {
        $query = $this->db->query('
			SELECT 
				U.Nome,
				E.NomeEmpresa
			FROM 
				App_Agenda AS A
					LEFT JOIN Sis_Associado AS U ON U.idSis_Associado = A.idSis_Associado
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = A.idSis_Empresa
			WHERE 
				A.idApp_Agenda = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

	public function list_agendamentos($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		$tipo = (isset($data['Tipo'])) ? $data['Tipo'] : '0';		
		if(isset($tipo)){
			if($tipo == 2){
				$tipoevento	= 'AND CO.Tipo = 2';	
			}elseif($tipo == 1){
				$tipoevento	= 'AND CO.Tipo = 1';
			}else{
				$tipoevento	= FALSE;
			}
		}else{
			$tipoevento	= FALSE;
		}
		
		$cliente = ($data['idApp_Cliente'] && isset($data['idApp_Cliente'])) ? 'AND CO.idApp_Cliente = ' . $data['idApp_Cliente'] . '  ' : FALSE;
		$clientepet = ($data['idApp_ClientePet'] && isset($data['idApp_ClientePet'])) ? 'AND CO.idApp_ClientePet = ' . $data['idApp_ClientePet'] . '  ' : FALSE;
		$clientepet2 = ($data['idApp_ClientePet2'] && isset($data['idApp_ClientePet2'])) ? 'AND CO.idApp_ClientePet = ' . $data['idApp_ClientePet2'] . '  ' : FALSE;
		$clientedep = ($data['idApp_ClienteDep'] && isset($data['idApp_ClienteDep'])) ? 'AND CO.idApp_ClienteDep = ' . $data['idApp_ClienteDep'] . '  ' : FALSE;
		$clientedep2 = ($data['idApp_ClienteDep2'] && isset($data['idApp_ClienteDep2'])) ? 'AND CO.idApp_ClienteDep = ' . $data['idApp_ClienteDep2'] . '  ' : FALSE;		
		$usuario 	= ($data['NomeUsuario']) ? ' AND ASS.idSis_Associado = ' . $data['NomeUsuario'] : FALSE;
		$recorrencia = ($data['Recorrencia'] && isset($data['Recorrencia'])) ? 'AND CO.Recorrencia = "' . $data['Recorrencia'] . '"  ' : FALSE;		
		$repeticao = ($data['Repeticao'] && isset($data['Repeticao'])) ? 'AND CO.Repeticao = "' . $data['Repeticao'] . '"  ' : FALSE;
		
		($data['DataInicio']) ? $date_inicio = $data['DataInicio'] : FALSE;
		($data['DataFim']) ? $date_fim = date('Y-m-d', strtotime('+1 days', strtotime($data['DataFim']))) : FALSE;

		$date_inicio_orca 	= ($data['DataInicio']) ? 'DataInicio >= "' . $date_inicio . '" AND ' : FALSE;
		$date_fim_orca 		= ($data['DataFim']) ? 'DataInicio <= "' . $date_fim . '" AND ' : FALSE;

		if(isset($data['Agrupar'])){
			if($data['Agrupar'] == 1){
				$agrupar = 'CO.idApp_Consulta';
			}elseif($data['Agrupar'] == 2){
				$agrupar = 'P.idApp_Produto';
			}else{
				$agrupar = 'CO.idApp_Consulta';
			}
		}else{
			$agrupar = 'CO.idApp_Consulta';
		}
		
		$campo 			= (!$data['Campo']) ? 'CO.DataInicio' : $data['Campo'];
		$ordenamento 	= (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

		$groupby = (isset($agrupar)) ? 'GROUP BY ' . $agrupar . '' : 'GROUP BY CO.idApp_Consulta';
					
		$permissao_agenda = ($_SESSION['log']['idSis_Empresa'] == 5) ? 'CO.idApp_Agenda = ' . $_SESSION['log']['Agenda'] . ' AND ' : FALSE;
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		if($completo == FALSE){
			$complemento = FALSE;
		}else{
			$complemento = ' AND OT.CanceladoOrca = "N" AND PR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND PR.Quitado = "N"';
		}

		$filtro_base = '
					' . $date_inicio_orca . '
					' . $date_fim_orca . '
					' . $permissao_agenda . '
					CO.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
					' . $tipoevento . '
					' . $cliente . '
					' . $clientepet . '
					' . $clientepet2 . '
					' . $clientedep . '
					' . $clientedep2 . '
					' . $recorrencia . '
					' . $repeticao . '
					' . $usuario . '
				' . $groupby . '
				ORDER BY
					' . $campo . '
					' . $ordenamento . '
				' . $querylimit . '
		';

        ####################################################################
        #Contagem DAS Parcelas e Soma total Para todas as listas e baixas
		if($total == TRUE && $date == FALSE) {
		   $query = $this->db->query('
				SELECT
					CO.idApp_Consulta,
					P.idApp_Produto
				FROM
					App_Consulta AS CO
						LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = CO.idApp_OrcaTrata
						LEFT JOIN App_Produto AS P ON P.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . '
			');
		
			$count = $query->num_rows();
			
			if(!isset($count)){
				return FALSE;
			}else{
				if($count >= 15001){
					return FALSE;
				}else{
					return $query;
				}
			}
		}

        ####################################################################
        # Relatório/Excel Campos para exibição DAS Parcelas
		if($total == FALSE && $date == FALSE) {
			$query = $this->db->query('
				SELECT
					CO.*,
					CO.idSis_Empresa AS Empresa,
					DATE_FORMAT(CO.DataInicio, "%Y-%m-%d") AS DataInicio,
					DATE_FORMAT(CO.DataInicio, "%H:%i") AS HoraInicio,
					DATE_FORMAT(CO.DataFim, "%Y-%m-%d") AS DataFim,
					DATE_FORMAT(CO.DataFim, "%H:%i") AS HoraFim,
					P.idApp_Produto,
					P.NomeProduto,
					P.QtdProduto,
					P.ValorProduto,
					CONCAT(IFNULL(P.ObsProduto,"")) AS ObsProduto,
					(P.QtdProduto*P.ValorProduto) AS SubTotalProduto,
					DATE_FORMAT(P.DataConcluidoProduto, "%Y-%m-%d") AS DataProduto,
					DATE_FORMAT(P.HoraConcluidoProduto, "%H:%i") AS HoraProduto,
					CONCAT(IFNULL(TCAT.Catprod,"")) AS Catprod,
					C.idApp_Cliente AS id_Cliente,
					C.CelularCliente,
					CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
					CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente2,
					CP.*,
					CONCAT(IFNULL(CP.NomeClientePet,"")) AS NomeClientePet,
					RP.RacaPet,

					CD.*,
					CONCAT(IFNULL(CD.NomeClienteDep,"")) AS NomeClienteDep,
					ASS.Nome
				FROM
					App_Consulta AS CO
						LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = CO.idApp_OrcaTrata
						LEFT JOIN App_Produto AS P ON P.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = P.idTab_Produtos_Produto
						LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
						LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
						LEFT JOIN App_Agenda AS A ON A.idApp_Agenda = CO.idApp_Agenda
						LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = A.idSis_Associado
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CO.idApp_Cliente
						LEFT JOIN App_ClientePet AS CP ON CP.idApp_ClientePet = CO.idApp_ClientePet
						LEFT JOIN Tab_RacaPet AS RP ON RP.idTab_RacaPet = CP.RacaPet
						LEFT JOIN App_ClienteDep AS CD ON CD.idApp_ClienteDep = CO.idApp_ClienteDep
				WHERE
					' . $filtro_base . '
			');


		
			/*
			  echo $this->db->last_query();
			  echo "<pre>";
			  print_r($query);
			  echo "</pre>";
			  exit();
			  */


            $somareceber=0;
            foreach ($query->result() as $row) {
				$row->DataInicio = $this->basico->mascara_data($row->DataInicio, 'barras');
				$row->DataFim = $this->basico->mascara_data($row->DataFim, 'barras');
				//$row->HoraInicio = $this->basico->mascara_hora($row->DataInicio, 'hora');
				//$row->HoraFim = $this->basico->mascara_hora($row->DataFim, 'hora');
				$row->DataProduto = $this->basico->mascara_data($row->DataProduto, 'barras');
                $row->AlergicoPet = $this->basico->mascara_palavra_completa($row->AlergicoPet, 'NS');
				
				if($row->PeloPet == 1){
					$row->PeloPet = "CURTO";
				}elseif($row->PeloPet == 2){
					$row->PeloPet = "MEDIO";
				}elseif($row->PeloPet == 3){
					$row->PeloPet = "LONGO";
				}elseif($row->PeloPet == 4){
					$row->PeloPet = "CACHEADO";
				}else{
					$row->PeloPet = "N.I.";
				}
				
				if($row->PortePet == 1){
					$row->PortePet = "MINI";
				}elseif($row->PortePet == 2){
					$row->PortePet = "PEQUENO";
				}elseif($row->PortePet == 3){
					$row->PortePet = "MEDIO";
				}elseif($row->PortePet == 4){
					$row->PortePet = "GRANDE";
				}elseif($row->PortePet == 5){
					$row->PortePet = "GIGANTE";
				}else{
					$row->PortePet = "N.I.";
				}
								
				if($row->EspeciePet == 1){
					$row->EspeciePet = "CAO";
				}elseif($row->EspeciePet == 2){
					$row->EspeciePet = "GATO";
				}elseif($row->EspeciePet == 3){
					$row->EspeciePet = "AVE";
				}else{
					$row->EspeciePet = "N.I.";
				}
								
				if($row->SexoPet == "M"){
					$row->SexoPet = "MACHO";
				}elseif($row->SexoPet == "F"){
					$row->SexoPet = "FEMEA";
				}elseif($row->SexoPet == "O"){
					$row->SexoPet = "OUT";
				}else{
					$row->SexoPet = "N.I.";
				}				
				
				/*
				$data = DateTime::createFromFormat('d/m/Y H:i:s', $data);
				$data = $data->format('Y-m-d H:i:s');
				format('Y-m-d H:i:s');
				*/
				/*
				  echo $this->db->last_query();
				  echo "<pre>";
				  print_r($somaentrada);          
				  echo "</pre>";
				  exit();
				*/	
		  
            }	
			/*
			echo $this->db->last_query();
			echo "<pre>";
			print_r($balanco);
			echo "</pre>";
			exit();			
			*/
			
            $query->soma = new stdClass();
            //$query->soma->somareceber = number_format($somareceber, 2, ',', '.');
			
            return $query;
		}

    }
	
	public function select_usuario() {
		
        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				P.CpfUsuario,
				P.CelularUsuario,
				CONCAT(IFNULL(P.Nome,"")) AS NomeUsuario
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND 
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				P.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }
		/*
		echo '<br>';
		echo "<pre>";
		print_r($array[$row->idSis_Usuario]);
		echo "</pre>";
		*/
        return $array;
		
    }
	
	public function select_associado() {
		
		if($_SESSION['Usuario']['Nivel'] == 0 || $_SESSION['Usuario']['Nivel'] == 1){
			$nivel = 'AND (U.Nivel = 0 OR U.Nivel = 1 )';
		}elseif($_SESSION['Usuario']['Nivel'] == 2){
			$nivel = 'AND U.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '';
		}else{
			$nivel = FALSE;
		}
		
        $query = $this->db->query('
            SELECT
				U.idSis_Usuario,
				U.CpfUsuario,
				U.CelularUsuario,
				ASS.idSis_Associado,
				A.idApp_Agenda,
				CONCAT(IFNULL(ASS.Nome,"")) AS NomeAssociado
            FROM
                Sis_Usuario AS U
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = U.Funcao
					LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = U.idSis_Associado
					LEFT JOIN App_Agenda AS A ON A.idSis_Associado = ASS.idSis_Associado
            WHERE
				U.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				' . $nivel . '
			ORDER BY 
				ASS.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            //$array[$row->idSis_Usuario] = $row->NomeUsuario;
            $array[$row->idSis_Associado] = $row->NomeAssociado;
        }

        return $array;
    }

	public function select_compartilhar() {

        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS NomeUsuario
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				P.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        //$array[50] = ':: O Próprio ::';
        //$array[51] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }

        return $array;
    }
	
	public function select_usuario1() {
		
        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				P.CpfUsuario,
				P.CelularUsuario,
				CONCAT(IFNULL(F.Abrev,""), " --- ", IFNULL(P.Nome,"")) AS NomeUsuario
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND 
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				F.Abrev ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->CpfUsuario] = $row->NomeUsuario;
        }

        return $array;
    }	
	
    public function select_status_sn2($data = FALSE) {

        $query = $this->db->query('
            SELECT
                idTab_StatusSN,
                StatusSN,
				Abrev
            FROM
                Tab_StatusSN 

            ORDER BY
                StatusSN DESC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->Abrev] = $row->StatusSN;
        }

        return $array;
    }
	
	public function select_status_sn($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN');

            $array = array();
			$array[0] = 'TODOS';
			foreach ($query->result() as $row) {
			$array[$row->Abrev] = $row->StatusSN;
			
            }
        }

        return $array;
    }

	public function select_dia() {

        $query = $this->db->query('
            SELECT
				D.idTab_Dia,
				D.Dia				
			FROM
				Tab_Dia AS D
			ORDER BY
				D.Dia
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Dia] = $row->Dia;
        }

        return $array;
    }	
	
	public function select_mes() {

        $query = $this->db->query('
            SELECT
				M.idTab_Mes,
				M.Mesdesc,
				CONCAT(M.Mes, " - ", M.Mesdesc) AS Mes
			FROM
				Tab_Mes AS M

			ORDER BY
				M.Mes
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Mes] = $row->Mes;
        }

        return $array;
    }	

    public function select_cliente() {

        $query = $this->db->query('
            SELECT
                C.idApp_Cliente,
                CONCAT(IFNULL(C.NomeCliente, ""), " | ", IFNULL(C.CelularCliente, ""), " || ", IFNULL(C.Telefone2, ""), " ||| ", IFNULL(C.Telefone3, "")) As NomeCliente
            FROM
                App_Cliente AS C

            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                C.NomeCliente ASC
        ');

        $array = array();
        $array[0] = '::Todos::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Cliente] = $row->NomeCliente;
        }

        return $array;
    }

    public function select_clientepet() {

        $query = $this->db->query('
            SELECT
                C.idApp_ClientePet,
                CONCAT(IFNULL(C.NomeClientePet, ""), " | ", IFNULL(C.EspeciePet, "")) As NomeClientePet
            FROM
                App_ClientePet AS C

            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                C.NomeClientePet ASC
        ');

        $array = array();
        $array[0] = '::Todos::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_ClientePet] = $row->NomeClientePet;
        }

        return $array;
    }

    public function select_clientedep() {

        $query = $this->db->query('
            SELECT
                C.idApp_ClienteDep,
                CONCAT(IFNULL(C.NomeClienteDep, "")) As NomeClienteDep
            FROM
                App_ClienteDep AS C

            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                C.NomeClienteDep ASC
        ');

        $array = array();
        $array[0] = '::Todos::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_ClienteDep] = $row->NomeClienteDep;
        }

        return $array;
    }
		
    public function select_categoria() {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        
		$query = $this->db->query('
            SELECT
                C.idTab_Categoria,
                C.Categoria
            FROM
                Tab_Categoria AS C
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = C.idSis_Usuario
            WHERE
				U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				(C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' )
            ORDER BY
                C.Categoria ASC
        ');

        $array = array();
		$array[0] = '::Todos::';
        foreach ($query->result() as $row) {
			$array[$row->idTab_Categoria] = $row->Categoria;
        }

        return $array;
    }

    public function select_empresarec() {

        $query = $this->db->query('
            SELECT
                ER.idSis_Empresa,
                ER.NomeEmpresa
            FROM
                Sis_Empresa AS ER

            WHERE
                ER.idSis_Empresa != "1"
			ORDER BY	
                ER.NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresa;
        }

        return $array;
    }

    public function select_empresaenv() {

        $query = $this->db->query('
            SELECT
                EE.idSis_Empresa,
                EE.NomeEmpresa AS NomeEmpresaCli
            FROM
                Sis_Empresa AS EE

            WHERE
                EE.idSis_Empresa != "1"
			ORDER BY	
                EE.NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresaCli;
        }

        return $array;
    }	

    public function select_procedimento() {

        $query = $this->db->query('
            SELECT
                P.idApp_Procedimento,
                P.Procedimento
            FROM
                App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" AND
				P.idSis_EmpresaCli = "0" AND
				U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' 
            ORDER BY
                P.idApp_Procedimento ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Procedimento] = $row->Procedimento;
        }

        return $array;
    }

	public function select_tarefa() {

		$permissao1 = (($_SESSION['Agendamentos']['Categoria'] != "0" ) && ($_SESSION['Agendamentos']['Categoria'] != '' )) ? 'P.Categoria = "' . $_SESSION['Agendamentos']['Categoria'] . '" AND ' : FALSE;
		$permissao2 = (($_SESSION['Agendamentos']['ConcluidoProcedimento'] != "0" ) && ($_SESSION['Agendamentos']['ConcluidoProcedimento'] != '' )) ? 'P.ConcluidoProcedimento = "' . $_SESSION['Agendamentos']['ConcluidoProcedimento'] . '" AND ' : FALSE;
		$permissao3 = (($_SESSION['Agendamentos']['Prioridade'] != "0" ) && ($_SESSION['Agendamentos']['Prioridade'] != '' )) ? 'P.Prioridade = "' . $_SESSION['Agendamentos']['Prioridade'] . '" AND ' : FALSE;
		$permissao6 = (($_SESSION['Agendamentos']['Statustarefa'] != "0" ) && ($_SESSION['Agendamentos']['Statustarefa'] != '' )) ? 'P.Statustarefa = "' . $_SESSION['Agendamentos']['Statustarefa'] . '" AND ' : FALSE;
		$permissao7 = (($_SESSION['Agendamentos']['Statussubtarefa'] != "0" ) && ($_SESSION['Agendamentos']['Statussubtarefa'] != '' )) ? 'SP.Statussubtarefa = "' . $_SESSION['Agendamentos']['Statussubtarefa'] . '" AND ' : FALSE;
		$permissao8 = (($_SESSION['Agendamentos']['SubPrioridade'] != "0" ) && ($_SESSION['Agendamentos']['SubPrioridade'] != '' )) ? 'SP.SubPrioridade = "' . $_SESSION['Agendamentos']['SubPrioridade'] . '" AND ' : FALSE;
		$permissao4 = ((($_SESSION['Agendamentos']['ConcluidoSubProcedimento'] != "0")&& ($_SESSION['Agendamentos']['ConcluidoSubProcedimento'] != 'M') ) && ($_SESSION['Agendamentos']['ConcluidoSubProcedimento'] != '' )) ? 'SP.ConcluidoSubProcedimento = "' . $_SESSION['Agendamentos']['ConcluidoSubProcedimento'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['Agendamentos']['ConcluidoSubProcedimento'] == 'M') && ($_SESSION['Agendamentos']['ConcluidoSubProcedimento'] != '' )) ? '((SP.ConcluidoSubProcedimento = "S") OR (SP.ConcluidoSubProcedimento = "N")) AND ' : FALSE;		
		
		$query = $this->db->query('
            SELECT
                P.idApp_Procedimento,
                P.Procedimento
            FROM
				App_Procedimento AS P
					LEFT JOIN App_SubProcedimento AS SP ON SP.idApp_Procedimento = P.idApp_Procedimento
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoProcedimento
					LEFT JOIN Tab_Prioridade AS PR ON PR.idTab_Prioridade = P.Prioridade
            WHERE
				' . $permissao1 . '
				' . $permissao3 . '
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao8 . '
				(U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				AU.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				P.Compartilhar = ' . $_SESSION['log']['idSis_Usuario'] . ' OR
				(P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') OR
				(P.Compartilhar = 51 AND P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '))
            ORDER BY
                P.Procedimento ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Procedimento] = $row->Procedimento;
        }

        return $array;
    }

}
