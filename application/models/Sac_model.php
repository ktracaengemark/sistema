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
	
    public function get_sac_empresa($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		$date_inicio_prc = ($_SESSION['FiltroSac']['DataInicio9']) ? 'PRC.DataSac >= "' . $_SESSION['FiltroSac']['DataInicio9'] . '" AND ' : FALSE;
		$date_fim_prc = ($_SESSION['FiltroSac']['DataFim9']) ? 'PRC.DataSac <= "' . $_SESSION['FiltroSac']['DataFim9'] . '" AND ' : FALSE;

		$date_inicio_sub_prc = ($_SESSION['FiltroSac']['DataInicio10']) ? 'SPRC.DataSubSac >= "' . $_SESSION['FiltroSac']['DataInicio10'] . '" AND ' : FALSE;
		$date_fim_sub_prc = ($_SESSION['FiltroSac']['DataFim10']) ? 'SPRC.DataSubSac <= "' . $_SESSION['FiltroSac']['DataFim10'] . '" AND ' : FALSE;

		$hora_inicio_prc = ($_SESSION['FiltroSac']['HoraInicio9']) ? 'PRC.HoraSac >= "' . $_SESSION['FiltroSac']['HoraInicio9'] . '" AND ' : FALSE;
		$hora_fim_prc = ($_SESSION['FiltroSac']['HoraFim9']) ? 'PRC.HoraSac <= "' . $_SESSION['FiltroSac']['HoraFim9'] . '" AND ' : FALSE;
		
		$hora_inicio_sub_prc = ($_SESSION['FiltroSac']['HoraInicio10']) ? 'SPRC.HoraSubSac >= "' . $_SESSION['FiltroSac']['HoraInicio10'] . '" AND ' : FALSE;
		$hora_fim_sub_prc = ($_SESSION['FiltroSac']['HoraFim10']) ? 'SPRC.HoraSubSac <= "' . $_SESSION['FiltroSac']['HoraFim10'] . '" AND ' : FALSE;		
		
		$data['TipoSac'] = $data['TipoSac'];
		$data['idApp_Sac'] = ($_SESSION['FiltroSac']['idApp_Sac'] != "" ) ? ' AND PRC.idApp_Sac = ' . $_SESSION['FiltroSac']['idApp_Sac'] . '  ': FALSE;
		$data['CategoriaSac'] = ($_SESSION['FiltroSac']['CategoriaSac'] != "0" ) ? ' AND PRC.CategoriaSac = ' . $_SESSION['FiltroSac']['CategoriaSac'] . '  ': FALSE;
		//$data['Marketing'] = ($_SESSION['FiltroSac']['Marketing'] != "0" ) ? ' AND PRC.Marketing = ' . $_SESSION['FiltroSac']['Marketing'] . '  ': FALSE;
		$data['Cliente'] = ($_SESSION['FiltroSac']['idApp_Cliente']  ) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroSac']['idApp_Cliente'] . '  ': FALSE;
		$data['Fornecedor'] = ($_SESSION['FiltroSac']['idApp_Fornecedor']  ) ? ' AND PRC.idApp_Fornecedor = ' . $_SESSION['FiltroSac']['idApp_Fornecedor'] . '  ': FALSE;
		$data['NomeUsuario'] = ($_SESSION['FiltroSac']['NomeUsuario']  ) ? ' AND PRC.idSis_Usuario = ' . $_SESSION['FiltroSac']['NomeUsuario'] . '  ': FALSE;
		$data['Compartilhar'] = ($_SESSION['FiltroSac']['Compartilhar']  ) ? ' AND PRC.Compartilhar = ' . $_SESSION['FiltroSac']['Compartilhar'] . '  ': FALSE;
		$data['ConcluidoSac'] = ($_SESSION['FiltroSac']['ConcluidoSac'] != "#" ) ? ' AND PRC.ConcluidoSac = "' . $_SESSION['FiltroSac']['ConcluidoSac'] . '"  ': FALSE;
		$data['Agrupar'] = ($_SESSION['FiltroSac']['Agrupar'] == "0") ? 'PRC.idApp_Sac': 'PRC.' . $_SESSION['FiltroSac']['Agrupar'];
		$data['Campo'] = (!$_SESSION['FiltroSac']['Campo']) ? 'PRC.DataSac' : $_SESSION['FiltroSac']['Campo'];
        $data['Ordenamento'] = (!$_SESSION['FiltroSac']['Ordenamento']) ? 'DESC' : $_SESSION['FiltroSac']['Ordenamento'];
		/*
        echo '<br>';
        echo "<pre>";
        //print_r($data['idSis_Empresa']);
		echo '<br>';
        print_r($data['Agrupar']);
        echo "</pre>";
        exit ();
       	*/

        if ($limit){
			$querylimit = 'LIMIT ' . $start . ', ' . $limit;
		}else{
			$querylimit = '';
		}
				
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
                ' . $date_inicio_prc . '
                ' . $date_fim_prc . '
                ' . $date_inicio_sub_prc . '
                ' . $date_fim_sub_prc . '
                ' . $hora_inicio_prc . '
                ' . $hora_fim_prc . '
                ' . $hora_inicio_sub_prc . '
                ' . $hora_fim_sub_prc . '
				PRC.idSis_Empresa = ' . $data['idSis_Empresa'] . ' AND
				PRC.TipoSac = ' . $data['TipoSac'] . '
				' . $data['idApp_Sac'] . '
				' . $data['CategoriaSac'] . '
				' . $data['Cliente'] . '
				' . $data['Fornecedor'] . '
				' . $data['NomeUsuario'] . '
				' . $data['Compartilhar'] . '
				' . $data['ConcluidoSac'] . '
			GROUP BY
				idApp_Sac
			ORDER BY
				' . $data['Campo'] . '
				' . $data['Ordenamento'] . '	
			' . $querylimit . ' 		
        ');
	
		if($total == TRUE) {
			return $query->num_rows();
		}

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

    public function get_subsac_empresa($data) {
		$query = $this->db->query('SELECT * FROM App_SubSac WHERE idSis_Empresa = ' . $data['idSis_Empresa']);
        $query = $query->result_array();

        return $query;
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
