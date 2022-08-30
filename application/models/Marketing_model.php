<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_marketing($data) {

        $query = $this->db->insert('App_Marketing', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_procedtarefa($data) {

        $query = $this->db->insert_batch('App_SubMarketing', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_orcatrata($data) {

        $query = $this->db->insert('App_Marketing', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_marketing($data) {
        $query = $this->db->query('SELECT * FROM App_Marketing WHERE idApp_Marketing = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_marketing2_verificacao($data) {
		
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
				App_Marketing PC
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Marketing = ' . $data . ' AND
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

    public function get_marketing2($data) {
		
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
				App_Marketing PC
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Marketing = ' . $data . ' AND
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

    public function get_submarketing($data) {
        $query = $this->db->query('SELECT * FROM App_SubMarketing WHERE idApp_Marketing = ' . $data);

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
				App_SubMarketing AS PC
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Marketing = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_orcatrata_original($data) {
        $query = $this->db->query('
			SELECT 
				* 
			FROM 
				App_Marketing 
			WHERE 
				idApp_Marketing = ' . $data . '
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
				App_Marketing AS PC
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = PC.Categoria
					LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = PC.Compartilhar
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Marketing = ' . $data . '
		');
		
		foreach ($query->result_array() as $row) {
			//$row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
			//$row->DataMarketingLimite = $this->basico->mascara_data($row->DataMarketingLimite, 'barras');
			//$row->ConcluidoMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoMarketing, 'NS');
			//$row->ConcluidoSubMarketing = $this->basico->mascara_palavra_completa2($row->ConcluidoSubMarketing, 'NS');
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
	
    public function update_marketing($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Marketing', $data, array('idApp_Marketing' => $id));
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

        $query = $this->db->update_batch('App_SubMarketing', $data, 'idApp_SubMarketing');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
			
    public function update_orcatrata($data, $id) {

        unset($data['idApp_Marketing']);
        $query = $this->db->update('App_Marketing', $data, array('idApp_Marketing' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function lista_marketing($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Marketing WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
				. 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND '
                . '(Marketing like "%' . $data . '%" OR '
                #. 'DataMarketing = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'Marketing like "%' . $data . '%" OR '
                . 'DataMarketing = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
				. 'DataConcluidoMarketing = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Telefone1 like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY Marketing ASC ');
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
                    $row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
					$row->DataConcluidoMarketing = $this->basico->mascara_data($row->DataConcluidoMarketing, 'barras');
                }

                return $query;
            }
        }
    }

    public function list_atualizacao($id, $concluido, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(PRC.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Marketing, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataMarketing, '
			. 'PRC.DataConcluidoMarketing, '
			. 'PRC.ConcluidoMarketing, '
            . 'PRC.CategoriaMarketing '
            . 'FROM '
            . 'App_Marketing AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
			. $revendedor 
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.CategoriaMarketing = 1 AND '
            . 'PRC.ConcluidoMarketing = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoMarketing ASC, '
			. 'PRC.DataMarketing DESC ');
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
					$row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
					$row->DataConcluidoMarketing = $this->basico->mascara_data($row->DataConcluidoMarketing, 'barras');
					$row->ConcluidoMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoMarketing, 'NS');
                }
                return $query;
            }
        
    }

    public function list_pesquisa($id, $concluido, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(PRC.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Marketing, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataMarketing, '
			. 'PRC.DataConcluidoMarketing, '
			. 'PRC.ConcluidoMarketing, '
            . 'PRC.CategoriaMarketing '
            . 'FROM '
            . 'App_Marketing AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
			. $revendedor 
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.CategoriaMarketing = 2 AND '
            . 'PRC.ConcluidoMarketing = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoMarketing ASC, '
			. 'PRC.DataMarketing DESC ');
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
					$row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
					$row->DataConcluidoMarketing = $this->basico->mascara_data($row->DataConcluidoMarketing, 'barras');
					$row->ConcluidoMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoMarketing, 'NS');
                }
                return $query;
            }
        
    }
	
    public function list_retorno($id, $concluido, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(PRC.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Marketing, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataMarketing, '
			. 'PRC.DataConcluidoMarketing, '
			. 'PRC.ConcluidoMarketing, '
            . 'PRC.CategoriaMarketing '
            . 'FROM '
            . 'App_Marketing AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
			. $revendedor
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.CategoriaMarketing = 3 AND '
            . 'PRC.ConcluidoMarketing = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoMarketing ASC, '
			. 'PRC.DataMarketing DESC ');
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
					$row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
					$row->DataConcluidoMarketing = $this->basico->mascara_data($row->DataConcluidoMarketing, 'barras');
					$row->ConcluidoMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoMarketing, 'NS');
                }
                return $query;
            }
        
    }
	
    public function list_promocao($id, $concluido, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(PRC.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Marketing, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataMarketing, '
			. 'PRC.DataConcluidoMarketing, '
			. 'PRC.ConcluidoMarketing, '
            . 'PRC.CategoriaMarketing '
            . 'FROM '
            . 'App_Marketing AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
			. $revendedor
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.CategoriaMarketing = 4 AND '
            . 'PRC.ConcluidoMarketing = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoMarketing ASC, '
			. 'PRC.DataMarketing DESC ');
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
					$row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
					$row->DataConcluidoMarketing = $this->basico->mascara_data($row->DataConcluidoMarketing, 'barras');
					$row->ConcluidoMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoMarketing, 'NS');
                }
                return $query;
            }
        
    }
	
    public function list_felicitacao($id, $concluido, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(PRC.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Marketing, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataMarketing, '
			. 'PRC.DataConcluidoMarketing, '
			. 'PRC.ConcluidoMarketing, '
            . 'PRC.CategoriaMarketing '
            . 'FROM '
            . 'App_Marketing AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
			. $revendedor
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.CategoriaMarketing = 5 AND '
            . 'PRC.ConcluidoMarketing = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoMarketing ASC, '
			. 'PRC.DataMarketing DESC ');
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
					$row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
					$row->DataConcluidoMarketing = $this->basico->mascara_data($row->DataConcluidoMarketing, 'barras');
					$row->ConcluidoMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoMarketing, 'NS');
                }
                return $query;
            }
        
    }
	
    public function list_marketing($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Marketing, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataMarketing, '
			. 'PRC.DataConcluidoMarketing, '
			. 'PRC.ConcluidoMarketing, '
			. 'PRC.Marketing, '
			. 'PRC.Marketing, '
            . 'PRC.Marketing '
            . 'FROM '
            . 'App_Marketing AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 0 AND '
            . '(PRC.Marketing = 0 OR PRC.Marketing = 1) AND '
            . 'PRC.ConcluidoMarketing = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoMarketing ASC, '
			. 'PRC.DataMarketing DESC ');
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
					$row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
					$row->DataConcluidoMarketing = $this->basico->mascara_data($row->DataConcluidoMarketing, 'barras');
					$row->ConcluidoMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoMarketing, 'NS');
                }
                return $query;
            }
        }
    }
			
    public function list_marketing_orc($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Marketing, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataMarketing, '
			. 'PRC.DataConcluidoMarketing, '
			. 'PRC.ConcluidoMarketing, '
            . 'PRC.Marketing '
            . 'FROM '
            . 'App_Marketing AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata != 0 AND '
            . 'PRC.Marketing = 0 AND '
            . 'PRC.ConcluidoMarketing = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoMarketing ASC, '
			. 'PRC.DataMarketing DESC ');
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
					$row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
					$row->DataConcluidoMarketing = $this->basico->mascara_data($row->DataConcluidoMarketing, 'barras');
					$row->ConcluidoMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoMarketing, 'NS');
                }
                return $query;
            }
       
    }
	
    public function list_orcamento($id, $aprovado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_Marketing, '
			. 'OT.idApp_OrcaTrata, '
            . 'OT.DataMarketing, '
			. 'OT.DataConcluidoMarketing, '
			. 'OT.ConcluidoMarketing, '
            . 'OT.Marketing '
            . 'FROM '
            . 'App_Marketing AS OT '
            . 'WHERE '
            . 'OT.idApp_Cliente = ' . $id . ' AND '
            . 'OT.ConcluidoMarketing = "' . $aprovado . '" '
            . 'ORDER BY '
			. 'OT.ConcluidoMarketing ASC, '
			. 'OT.DataMarketing DESC ');
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
					$row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
					$row->DataConcluidoMarketing = $this->basico->mascara_data($row->DataConcluidoMarketing, 'barras');
					$row->ConcluidoMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoMarketing, 'NS');
                }
                return $query;
            }
        }
    }

	public function listar_marketing($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		$date_inicio_prc = ($data['DataInicio9']) ? 'PRC.DataMarketing >= "' . $data['DataInicio9'] . '" AND ' : FALSE;
		$date_fim_prc = ($data['DataFim9']) ? 'PRC.DataMarketing <= "' . $data['DataFim9'] . '" AND ' : FALSE;
		
		$date_inicio_sub_prc = ($data['DataInicio10']) ? 'SPRC.DataSubMarketing >= "' . $data['DataInicio10'] . '" AND ' : FALSE;
		$date_fim_sub_prc = ($data['DataFim10']) ? 'SPRC.DataSubMarketing <= "' . $data['DataFim10'] . '" AND ' : FALSE;

		$hora_inicio_prc = ($data['HoraInicio9']) ? 'PRC.HoraMarketing >= "' . $data['HoraInicio9'] . '" AND ' : FALSE;
		$hora_fim_prc = ($data['HoraFim9']) ? 'PRC.HoraMarketing <= "' . $data['HoraFim9'] . '" AND ' : FALSE;
		
		$hora_inicio_sub_prc = ($data['HoraInicio10']) ? 'SPRC.HoraSubMarketing >= "' . $data['HoraInicio10'] . '" AND ' : FALSE;
		$hora_fim_sub_prc = ($data['HoraFim10']) ? 'SPRC.HoraSubMarketing <= "' . $data['HoraFim10'] . '" AND ' : FALSE;
		
		$campo = (!$data['Campo']) ? 'PRC.DataMarketing' : $data['Campo'];
		$ordenamento = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		
		$filtro10 = ($data['ConcluidoMarketing'] != '#') ? 'PRC.ConcluidoMarketing = "' . $data['ConcluidoMarketing'] . '" AND ' : FALSE;
		
		$filtro22 = ($data['idTab_TipoRD'] == 2) ? 'AND (OT.idTab_TipoRD = "2" OR C.idApp_Cliente = PRC.idApp_Cliente)' : FALSE;
		
		$id_marketing = ($data['idApp_Marketing']) ? ' AND PRC.idApp_Marketing = ' . $data['idApp_Marketing'] . '  ': FALSE;		
		$sac = ($data['Sac']) ? ' AND PRC.Sac = ' . $data['Sac'] . '  ': FALSE;		
		$categoria_mark = ($data['CategoriaMarketing']) ? ' AND PRC.CategoriaMarketing = ' . $data['CategoriaMarketing'] . '  ': FALSE;
		$orcamento = ($data['Orcamento']) ? ' AND PRC.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
		$cliente = ($data['Cliente']) ? ' AND PRC.idApp_Cliente = ' . $data['Cliente'] . '' : FALSE;
		$id_cliente = ($data['idApp_Cliente']) ? ' AND PRC.idApp_Cliente = ' . $data['idApp_Cliente'] . '' : FALSE;       
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
				PRC.Sac = 0 AND 
				PRC.CategoriaMarketing != 0 
				' . $filtro22 . '
				' . $id_marketing . '
				' . $sac . '
				' . $categoria_mark . '
				' . $orcamento . '
				' . $cliente . '
				' . $id_cliente . '
			' . $groupby . '
			ORDER BY
				' . $campo . ' 
				' . $ordenamento . '
			' . $querylimit . '
		';

        ####################################################################
        #Contagem Dos MARKs e Soma total Para todas as listas e baixas
		if($total == TRUE && $date == FALSE) {
			
			$query = $this->db->query(
				'SELECT
					PRC.idApp_Marketing
				FROM
					App_Marketing AS PRC
						LEFT JOIN App_SubMarketing AS SPRC ON SPRC.idApp_Marketing = PRC.idApp_Marketing
						LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PRC.idApp_OrcaTrata
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
						LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
						LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = SPRC.idSis_Usuario
				WHERE
					' . $filtro_base . ''
			);
			
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
        # Relatório/Excel Campos para exibição DOs MARKs	
		if($total == FALSE && $date == FALSE) {
			$query = $this->db->query(
				'SELECT
					PRC.idSis_Empresa,
					PRC.idApp_Marketing,
					PRC.Marketing,
					PRC.DataMarketing,
					PRC.HoraMarketing,
					PRC.ConcluidoMarketing,
					PRC.idApp_Cliente,
					PRC.idApp_OrcaTrata,
					PRC.Compartilhar,
					PRC.Sac,
					PRC.CategoriaMarketing,
					SPRC.SubMarketing,
					SPRC.ConcluidoSubMarketing,
					SPRC.DataSubMarketing,
					SPRC.HoraSubMarketing,
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
					App_Marketing AS PRC
						LEFT JOIN App_SubMarketing AS SPRC ON SPRC.idApp_Marketing = PRC.idApp_Marketing
						LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PRC.idApp_OrcaTrata
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
						LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
						LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = SPRC.idSis_Usuario
				WHERE
					' . $filtro_base . ''
			);

            foreach ($query->result() as $row) {
				$row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
				$row->ConcluidoMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoMarketing, 'NS');
				$row->DataSubMarketing = $this->basico->mascara_data($row->DataSubMarketing, 'barras');
				$row->ConcluidoSubMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoSubMarketing, 'NS');
				
				if($row->Compartilhar == "0"){
					$row->NomeCompartilhar = 'Todos';
				}

				if($row->CategoriaMarketing == 1){
					$row->CategoriaMarketing = 'Atualização';
				}elseif($row->CategoriaMarketing == 2){
					$row->CategoriaMarketing = 'Pesquisa';
				}elseif($row->CategoriaMarketing == 3){
					$row->CategoriaMarketing = 'Retorno';
				}elseif($row->CategoriaMarketing == 4){
					$row->CategoriaMarketing = 'Promoções';
				}elseif($row->CategoriaMarketing == 5){
					$row->CategoriaMarketing = 'Felicitações';
				}
				
            }
            return $query;
        }
		

        ####################################################################
        # Lista/Campos para Impressão
		if($total == FALSE && $date == TRUE) {
		
			$query = $this->db->query('
				SELECT
					PRC.idApp_Marketing,
					PRC.CategoriaMarketing,
					PRC.Marketing,
					PRC.DataMarketing,
					PRC.HoraMarketing,
					PRC.ConcluidoMarketing,
					PRC.idSis_Usuario,
					PRC.Compartilhar,
					C.idApp_Cliente,
					C.NomeCliente,
					U.idSis_Usuario,
					U.Nome AS NomeUsuario,
					AU.idSis_Usuario,
					AU.Nome AS NomeCompartilhar
				FROM 
					App_Marketing AS PRC
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
					LEFT JOIN App_SubMarketing AS SPRC ON SPRC.idApp_Marketing = PRC.idApp_Marketing
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

    public function listar_submarketing($data) {
		$query = $this->db->query('SELECT * FROM App_SubMarketing WHERE idApp_Marketing = ' . $data);
        $query = $query->result_array();

        return $query;
    }	

    public function delete_marketing($data) {

        $query = $this->db->query('SELECT* FROM App_Marketing WHERE idApp_Marketing = ' . $data);
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

        $this->db->delete('App_Marketing', array('idApp_Marketing' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_procedtarefa($data) {

        $this->db->where_in('idApp_SubMarketing', $data);
        $this->db->delete('App_SubMarketing');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_orcatrata($id) {

        $query = $this->db->delete('App_Marketing', array('idApp_Marketing' => $id));
        $query = $this->db->delete('App_SubMarketing', array('idApp_Marketing' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	public function select_marketing($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Marketing,
				CONCAT(IFNULL(Marketing, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As Marketing				
            FROM
                App_Marketing					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY 
				Marketing ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Marketing,
				CONCAT(IFNULL(Marketing, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As Marketing				
            FROM
                App_Marketing					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY 
				Marketing ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Marketing] = $row->Marketing;
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

	public function select_Marketing_nula() {
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
