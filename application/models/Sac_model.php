<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Sac_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_sac($data) {

        $query = $this->db->insert('App_Sac', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_procedtarefa($data) {

        $query = $this->db->insert_batch('App_SubSac', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_orcatrata($data) {

        $query = $this->db->insert('App_Sac', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_sac($data) {
        $query = $this->db->query('SELECT * FROM App_Sac WHERE idApp_Sac = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_sac2_verificacao($data) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(PC.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query(
			'SELECT 
				PC.*,
				USC.Nome AS NomeCadastrou
			FROM 
				App_Sac PC
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Sac = ' . $data . ' AND
				' . $revendedor . '
				PC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);

        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }

    public function get_sac2($data) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(PC.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query(
			'SELECT 
				PC.*,
				USC.Nome AS NomeCadastrou
			FROM 
				App_Sac PC
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Sac = ' . $data . ' AND
				' . $revendedor . '
				PC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
    }

    public function get_subsac($data) {
        $query = $this->db->query('SELECT * FROM App_SubSac WHERE idApp_Sac = ' . $data);

        $query = $query->result_array();

        return $query;
    }

    public function get_procedtarefa($data) {
		$query = $this->db->query('
			SELECT 
				PC.*,
				PC.idSis_Usuario,
				USC.*,
				USC.idSis_Usuario AS idSis_Usuario,
				USC.CelularUsuario AS CelularCadastrou,
				USC.Nome AS NomeCadastrou
				
			FROM 
				App_SubSac AS PC
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Sac = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_orcatrata_original($data) {
        $query = $this->db->query('
			SELECT 
				* 
			FROM 
				App_Sac 
			WHERE 
				idApp_Sac = ' . $data . '
			');
        $query = $query->result_array();

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query[0];
    }
	
    public function get_orcatrata($data) {
        $query = $this->db->query('
			SELECT
				PC.*,
				PC.Compartilhar AS idCompartilhar,
				CT.*,
				CT.idTab_Categoria AS Categoria,
				CT.Categoria AS NomeCategoria,
				US.*,
				US.idSis_Usuario AS Compartilhar,
				US.CelularUsuario AS CelularCompartilhou,
				US.Nome AS NomeCompartilhar,
				USC.*,
				USC.idSis_Usuario AS idSis_Usuario,
				USC.CelularUsuario AS CelularCadastrou,
				USC.Nome AS NomeCadastrou
			FROM 
				App_Sac AS PC
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = PC.Categoria
					LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = PC.Compartilhar
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Sac = ' . $data . '
		');
		
		foreach ($query->result_array() as $row) {
			//$row->DataSac = $this->basico->mascara_data($row->DataSac, 'barras');
			//$row->DataSacLimite = $this->basico->mascara_data($row->DataSacLimite, 'barras');
			//$row->ConcluidoSac = $this->basico->mascara_palavra_completa($row->ConcluidoSac, 'NS');
			//$row->ConcluidoSubSac = $this->basico->mascara_palavra_completa2($row->ConcluidoSubSac, 'NS');
			//$row->Prioridade = $this->basico->prioridade($row->Prioridade, '123');
			//$row->SubPrioridade = $this->basico->prioridade($row->SubPrioridade, '123');
			//$row->Statustarefa = $this->basico->statustrf($row->Statustarefa, '123');
			//$row->Statussubtarefa = $this->basico->statustrf($row->Statussubtarefa, '123');
			
			if($row['Compartilhar'] == 0){
				$row['NomeCompartilhar'] = 'TODOS';
			}
			
		}
		
		//$query = $query->result_array();		
		
		/*
        echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($row);
        echo '<br>';
        print_r($row['Compartilhar']);
        echo '<br>';
        print_r($row['NomeCompartilhar']);
        echo "</pre>";
        exit ();
       */

		return $row;
        //return $query[0];
    }	

    public function get_profissional($data) {
		$query = $this->db->query('SELECT NomeProfissional FROM App_Profissional WHERE idApp_Profissional = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['NomeProfissional'])) ? $query[0]['NomeProfissional'] : FALSE;
    }
	
    public function update_sac($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Sac', $data, array('idApp_Sac' => $id));
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function update_procedtarefa($data) {

        $query = $this->db->update_batch('App_SubSac', $data, 'idApp_SubSac');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
			
    public function update_orcatrata($data, $id) {

        unset($data['idApp_Sac']);
        $query = $this->db->update('App_Sac', $data, array('idApp_Sac' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function lista_sac($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Sac WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
				. 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND '
                . '(Sac like "%' . $data . '%" OR '
                #. 'DataSac = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'Sac like "%' . $data . '%" OR '
                . 'DataSac = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
				. 'DataConcluidoSac = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Telefone1 like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY Sac ASC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                foreach ($query->result() as $row) {
                    $row->DataSac = $this->basico->mascara_data($row->DataSac, 'barras');
					$row->DataConcluidoSac = $this->basico->mascara_data($row->DataConcluidoSac, 'barras');
                }

                return $query;
            }
        }
    }

	public function listar_sac($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
	
		$date_inicio_prc = ($data['DataInicio9']) ? 'PRC.DataSac >= "' . $data['DataInicio9'] . '" AND ' : FALSE;
		$date_fim_prc = ($data['DataFim9']) ? 'PRC.DataSac <= "' . $data['DataFim9'] . '" AND ' : FALSE;
		
		$date_inicio_sub_prc = ($data['DataInicio10']) ? 'SPRC.DataSubSac >= "' . $data['DataInicio10'] . '" AND ' : FALSE;
		$date_fim_sub_prc = ($data['DataFim10']) ? 'SPRC.DataSubSac <= "' . $data['DataFim10'] . '" AND ' : FALSE;

		$hora_inicio_prc = ($data['HoraInicio9']) ? 'PRC.HoraSac >= "' . $data['HoraInicio9'] . '" AND ' : FALSE;
		$hora_fim_prc = ($data['HoraFim9']) ? 'PRC.HoraSac <= "' . $data['HoraFim9'] . '" AND ' : FALSE;
		
		$hora_inicio_sub_prc = ($data['HoraInicio10']) ? 'SPRC.HoraSubSac >= "' . $data['HoraInicio10'] . '" AND ' : FALSE;
		$hora_fim_sub_prc = ($data['HoraFim10']) ? 'SPRC.HoraSubSac <= "' . $data['HoraFim10'] . '" AND ' : FALSE;

		$Campo = (!$data['Campo']) ? 'PRC.DataSac' : $data['Campo'];
		$Ordenamento = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		
		$filtro10 = ($data['ConcluidoSac'] != '#') ? 'PRC.ConcluidoSac = "' . $data['ConcluidoSac'] . '" AND ' : FALSE;
		
		$filtro22 = ($data['idTab_TipoRD'] == 2) ? 'AND (OT.idTab_TipoRD = "2" OR C.idApp_Cliente = PRC.idApp_Cliente)' : FALSE;
		
		$idApp_Sac = ($data['idApp_Sac']) ? ' AND PRC.idApp_Sac = ' . $data['idApp_Sac'] . '  ': FALSE;		
		$CategoriaSac = ($data['CategoriaSac']) ? ' AND PRC.CategoriaSac = ' . $data['CategoriaSac'] . '  ': FALSE;		
		$Marketing = ($data['Marketing']) ? ' AND PRC.Marketing = ' . $data['Marketing'] . '  ': FALSE;
		$Orcamento = ($data['Orcamento']) ? ' AND PRC.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
		$Cliente = ($data['Cliente']) ? ' AND PRC.idApp_Cliente = ' . $data['Cliente'] . '' : FALSE;
		$idApp_Cliente = ($data['idApp_Cliente']) ? ' AND PRC.idApp_Cliente = ' . $data['idApp_Cliente'] . '' : FALSE;      
		$filtro17 = ($data['NomeUsuario']) ? 'PRC.idSis_Usuario = "' . $data['NomeUsuario'] . '" AND ' : FALSE;        
		$filtro18 = ($data['Compartilhar']) ? 'PRC.Compartilhar = "' . $data['Compartilhar'] . '" AND ' : FALSE;		

		$groupby = ($data['Agrupar'] && $data['Agrupar'] != "0") ? 'GROUP BY PRC.' . $data['Agrupar'] . '' : FALSE;
		
			
		/*
		echo $this->db->last_query();
		echo "<pre>";
		print_r($groupby);
		echo "</pre>";
		exit();
        */ 
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
		if($completo == FALSE){
			$complemento = FALSE;
		}else{
			$complemento = ' AND OT.CanceladoOrca = "N"';
		}

		$filtro_base = '
				' . $date_inicio_prc . '
				' . $date_fim_prc . '
				' . $date_inicio_sub_prc . '
				' . $date_fim_sub_prc . '
				' . $hora_inicio_prc . '
				' . $hora_fim_prc . '
				' . $hora_inicio_sub_prc . '
				' . $hora_fim_sub_prc . '
				' . $filtro10 . '
				' . $filtro17 . '
				' . $filtro18 . '
				PRC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
				PRC.idApp_OrcaTrata = 0 AND 
				PRC.idApp_Cliente != 0 AND 
				PRC.CategoriaSac != 0 AND 
				PRC.Marketing = 0
				' . $filtro22 . '
				' . $idApp_Sac . '
				' . $CategoriaSac . '
				' . $Marketing . '
				' . $Orcamento . '
				' . $Cliente . '
				' . $idApp_Cliente . '
			' . $groupby . '
			ORDER BY
				' . $Campo . ' 
				' . $Ordenamento . '
			' . $querylimit . '
		';
		
        ####################################################################
        #Contagem Dos SACs e Soma total Para todas as listas e baixas
		if($total == TRUE && $date == FALSE) {
			
			$query = $this->db->query(
				'SELECT
					PRC.idApp_Sac
				FROM
					App_Sac AS PRC
						LEFT JOIN App_SubSac AS SPRC ON SPRC.idApp_Sac = PRC.idApp_Sac
						LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PRC.idApp_OrcaTrata
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
						LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
						LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = SPRC.idSis_Usuario
				WHERE
					' . $filtro_base . ''
			);
			
			//return $query->num_rows();
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
        # Relatório/Excel Campos para exibição DOs Sacs	
		if($total == FALSE && $date == FALSE) {
			
			$query = $this->db->query(
				'SELECT
					PRC.idSis_Empresa,
					PRC.idApp_Sac,
					PRC.Sac,
					PRC.DataSac,
					PRC.HoraSac,
					PRC.ConcluidoSac,
					PRC.idApp_Cliente,
					PRC.idApp_OrcaTrata,
					PRC.Compartilhar,
					PRC.CategoriaSac,
					PRC.Marketing,
					SPRC.SubSac,
					SPRC.ConcluidoSubSac,
					SPRC.DataSubSac,
					SPRC.HoraSubSac,
					OT.idTab_TipoRD,
					CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
					U.idSis_Usuario,
					U.CpfUsuario,
					U.Nome AS NomeUsuario,
					SU.idSis_Usuario,
					SU.Nome AS NomeSubUsuario,
					AU.idSis_Usuario,
					AU.Nome AS NomeCompartilhar
				FROM
					App_Sac AS PRC
						LEFT JOIN App_SubSac AS SPRC ON SPRC.idApp_Sac = PRC.idApp_Sac
						LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PRC.idApp_OrcaTrata
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
						LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
						LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = SPRC.idSis_Usuario
				WHERE
					' . $filtro_base . ''
			);

			foreach ($query->result() as $row) {
				$row->DataSac = $this->basico->mascara_data($row->DataSac, 'barras');
				$row->ConcluidoSac = $this->basico->mascara_palavra_completa($row->ConcluidoSac, 'NS');
				$row->DataSubSac = $this->basico->mascara_data($row->DataSubSac, 'barras');
				$row->ConcluidoSubSac = $this->basico->mascara_palavra_completa($row->ConcluidoSubSac, 'NS');
				
				if($row->Compartilhar == "0"){
					$row->NomeCompartilhar = 'Todos';
				}
				
				if($row->CategoriaSac == 1){
					$row->CategoriaSac = 'Solicitação';
				}elseif($row->CategoriaSac == 2){
					$row->CategoriaSac = 'Elogio';
				}elseif($row->CategoriaSac == 3){
					$row->CategoriaSac = 'Reclamação';
				}

			}
		  /*
		  //echo $this->db->last_query();
		  echo "<br>";
		  echo "<pre>";
		  print_r($query);
		  echo "</pre>";
		  exit();
		  */
			return $query;
		}	

        ####################################################################
        # Lista/Campos para Impressão
		if($total == FALSE && $date == TRUE) {
		
			$query = $this->db->query('
				SELECT
					PRC.idApp_Sac,
					PRC.CategoriaSac,
					PRC.Sac,
					PRC.DataSac,
					PRC.HoraSac,
					PRC.ConcluidoSac,
					PRC.idSis_Usuario,
					PRC.Compartilhar,
					C.idApp_Cliente,
					C.NomeCliente,
					U.idSis_Usuario,
					U.Nome AS NomeUsuario,
					AU.idSis_Usuario,
					AU.Nome AS NomeCompartilhar
				FROM 
					App_Sac AS PRC
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = PRC.idApp_Fornecedor
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
					LEFT JOIN App_SubSac AS SPRC ON SPRC.idApp_Sac = PRC.idApp_Sac
				WHERE
					' . $filtro_base . ' 		
			');

			$query = $query->result_array();
		   /*
			//echo $this->db->last_query();
			echo '<br>';
			echo "<pre>";
			print_r($query);
			echo "</pre>";
			//exit ();
		   */
			return $query;
		}		
		
    }

    public function listar_subsac($data) {
		$query = $this->db->query('SELECT * FROM App_SubSac WHERE idApp_Sac = ' . $data);
        $query = $query->result_array();

        return $query;
    }	
	
    public function list_sac($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Sac, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataSac, '
			. 'PRC.DataConcluidoSac, '
			. 'PRC.ConcluidoSac, '
			. 'PRC.Marketing, '
			. 'PRC.Sac, '
            . 'PRC.Sac '
            . 'FROM '
            . 'App_Sac AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 0 AND '
            . '(PRC.Sac = 0 OR PRC.Sac = 1) AND '
            . 'PRC.ConcluidoSac = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoSac ASC, '
			. 'PRC.DataSac DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataSac = $this->basico->mascara_data($row->DataSac, 'barras');
					$row->DataConcluidoSac = $this->basico->mascara_data($row->DataConcluidoSac, 'barras');
					$row->ConcluidoSac = $this->basico->mascara_palavra_completa($row->ConcluidoSac, 'NS');
                }
                return $query;
            }
        }
    }

    public function list_informacao($id, $concluido, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(PRC.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Sac, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataSac, '
			. 'PRC.DataConcluidoSac, '
			. 'PRC.ConcluidoSac, '
			. 'PRC.Marketing, '
			. 'PRC.Sac, '
            . 'PRC.CategoriaSac '
            . 'FROM '
            . 'App_Sac AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
			. $revendedor 
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 0 AND '
            . 'PRC.CategoriaSac = 1 AND '
            . 'PRC.ConcluidoSac = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoSac ASC, '
			. 'PRC.DataSac DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataSac = $this->basico->mascara_data($row->DataSac, 'barras');
					$row->DataConcluidoSac = $this->basico->mascara_data($row->DataConcluidoSac, 'barras');
					$row->ConcluidoSac = $this->basico->mascara_palavra_completa($row->ConcluidoSac, 'NS');
                }
				
                return $query;
            }
        
    }

    public function list_elogio($id, $concluido, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(PRC.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Sac, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataSac, '
			. 'PRC.DataConcluidoSac, '
			. 'PRC.ConcluidoSac, '
			. 'PRC.Sac, '
            . 'PRC.CategoriaSac '
            . 'FROM '
            . 'App_Sac AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
			. $revendedor 
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.CategoriaSac = 2 AND '
            . 'PRC.ConcluidoSac = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoSac ASC, '
			. 'PRC.DataSac DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataSac = $this->basico->mascara_data($row->DataSac, 'barras');
					$row->DataConcluidoSac = $this->basico->mascara_data($row->DataConcluidoSac, 'barras');
					$row->ConcluidoSac = $this->basico->mascara_palavra_completa($row->ConcluidoSac, 'NS');
                }
                return $query;
            }
        
    }

    public function list_reclamacao($id, $concluido, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(PRC.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Sac, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataSac, '
			. 'PRC.DataConcluidoSac, '
			. 'PRC.ConcluidoSac, '
			. 'PRC.Sac, '
            . 'PRC.CategoriaSac '
            . 'FROM '
            . 'App_Sac AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
			. $revendedor 
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.CategoriaSac = 3 AND '
            . 'PRC.ConcluidoSac = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoSac ASC, '
			. 'PRC.DataSac DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataSac = $this->basico->mascara_data($row->DataSac, 'barras');
					$row->DataConcluidoSac = $this->basico->mascara_data($row->DataConcluidoSac, 'barras');
					$row->ConcluidoSac = $this->basico->mascara_palavra_completa($row->ConcluidoSac, 'NS');
                }
                return $query;
            }
       
    }
			
    public function list_sac_orc($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Sac, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataSac, '
			. 'PRC.DataConcluidoSac, '
			. 'PRC.ConcluidoSac, '
            . 'PRC.Sac '
            . 'FROM '
            . 'App_Sac AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata != 0 AND '
            . 'PRC.Marketing = 0 AND '
            . 'PRC.ConcluidoSac = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoSac ASC, '
			. 'PRC.DataSac DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
       
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataSac = $this->basico->mascara_data($row->DataSac, 'barras');
					$row->DataConcluidoSac = $this->basico->mascara_data($row->DataConcluidoSac, 'barras');
					$row->ConcluidoSac = $this->basico->mascara_palavra_completa($row->ConcluidoSac, 'NS');
                }
                return $query;
            }
       
    }
	
    public function list_orcamento($id, $aprovado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_Sac, '
			. 'OT.idApp_OrcaTrata, '
            . 'OT.DataSac, '
			. 'OT.DataConcluidoSac, '
			. 'OT.ConcluidoSac, '
            . 'OT.Sac '
            . 'FROM '
            . 'App_Sac AS OT '
            . 'WHERE '
            . 'OT.idApp_Cliente = ' . $id . ' AND '
            . 'OT.ConcluidoSac = "' . $aprovado . '" '
            . 'ORDER BY '
			. 'OT.ConcluidoSac ASC, '
			. 'OT.DataSac DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataSac = $this->basico->mascara_data($row->DataSac, 'barras');
					$row->DataConcluidoSac = $this->basico->mascara_data($row->DataConcluidoSac, 'barras');
					$row->ConcluidoSac = $this->basico->mascara_palavra_completa($row->ConcluidoSac, 'NS');
                }
                return $query;
            }
        }
    }

    public function delete_sac($data) {

        $query = $this->db->query('SELECT* FROM App_Sac WHERE idApp_Sac = ' . $data);
        $query = $query->result_array();

        /*
        echo $this->db->last_query();
        #$query = $query->result();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";


        foreach ($query as $key) {
            /*
            echo $key['idApp_OrcaTrata'];
            echo '<br />';
            #echo $value;
            echo '<br />';
        }

        exit();

        */

        $this->db->delete('App_Sac', array('idApp_Sac' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_procedtarefa($data) {

        $this->db->where_in('idApp_SubSac', $data);
        $this->db->delete('App_SubSac');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_orcatrata($id) {

        $query = $this->db->delete('App_Sac', array('idApp_Sac' => $id));
        $query = $this->db->delete('App_SubSac', array('idApp_Sac' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	public function select_sac($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Sac,
				CONCAT(IFNULL(Sac, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As Sac				
            FROM
                App_Sac					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY 
				Sac ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Sac,
				CONCAT(IFNULL(Sac, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As Sac				
            FROM
                App_Sac					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY 
				Sac ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Sac] = $row->Sac;
            }
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
				F.Abrev ASC
        ');

        $array = array();
        //$array[50] = ':: O Próprio ::';
        //$array[51] = ':: Todos ::';
		$array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }

        return $array;
    }

	public function select_Marketing() {
		$query = $this->db->query('
            SELECT
                C.idTab_Marketing,
                C.Marketing
            FROM
                Tab_Marketing AS C
            ORDER BY
                C.idTab_Marketing ASC
        ');

        $array = array();	
        foreach ($query->result() as $row) {
            $array[$row->idTab_Marketing] = $row->Marketing;
        }

        return $array;
    }

	public function select_titulo() {
		$query = $this->db->query('
            SELECT
                C.idTab_Titulo,
                C.Titulo
            FROM
                Tab_Titulo AS C
            WHERE
				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
            ORDER BY
                C.Titulo ASC
        ');

        $array = array();	
        foreach ($query->result() as $row) {
            $array[$row->idTab_Titulo] = $row->Titulo;
        }

        return $array;
    }
		
}
