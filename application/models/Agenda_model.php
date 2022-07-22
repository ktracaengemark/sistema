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
