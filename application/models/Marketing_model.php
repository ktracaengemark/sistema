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

    public function get_marketing2($data) {
        $query = $this->db->query('
			SELECT 
				PC.*,
				USC.Nome AS NomeCadastrou
			FROM 
				App_Marketing PC
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Marketing = ' . $data . '
		');

        $query = $query->result_array();

        return $query[0];
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
	
    public function get_marketing_empresa($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		$date_inicio_prc = ($_SESSION['FiltroMarketing']['DataInicio9']) ? 'PRC.DataMarketing >= "' . $_SESSION['FiltroMarketing']['DataInicio9'] . '" AND ' : FALSE;
		$date_fim_prc = ($_SESSION['FiltroMarketing']['DataFim9']) ? 'PRC.DataMarketing <= "' . $_SESSION['FiltroMarketing']['DataFim9'] . '" AND ' : FALSE;

		$date_inicio_sub_prc = ($_SESSION['FiltroMarketing']['DataInicio10']) ? 'SPRC.DataSubMarketing >= "' . $_SESSION['FiltroMarketing']['DataInicio10'] . '" AND ' : FALSE;
		$date_fim_sub_prc = ($_SESSION['FiltroMarketing']['DataFim10']) ? 'SPRC.DataSubMarketing <= "' . $_SESSION['FiltroMarketing']['DataFim10'] . '" AND ' : FALSE;

		$hora_inicio_prc = ($_SESSION['FiltroMarketing']['HoraInicio9']) ? 'PRC.HoraMarketing >= "' . $_SESSION['FiltroMarketing']['HoraInicio9'] . '" AND ' : FALSE;
		$hora_fim_prc = ($_SESSION['FiltroMarketing']['HoraFim9']) ? 'PRC.HoraMarketing <= "' . $_SESSION['FiltroMarketing']['HoraFim9'] . '" AND ' : FALSE;
		
		$hora_inicio_sub_prc = ($_SESSION['FiltroMarketing']['HoraInicio10']) ? 'SPRC.HoraSubMarketing >= "' . $_SESSION['FiltroMarketing']['HoraInicio10'] . '" AND ' : FALSE;
		$hora_fim_sub_prc = ($_SESSION['FiltroMarketing']['HoraFim10']) ? 'SPRC.HoraSubMarketing <= "' . $_SESSION['FiltroMarketing']['HoraFim10'] . '" AND ' : FALSE;		
		
		$data['TipoMarketing'] = $data['TipoMarketing'];
		$data['idApp_Marketing'] = ($_SESSION['FiltroMarketing']['idApp_Marketing'] != "" ) ? ' AND PRC.idApp_Marketing = ' . $_SESSION['FiltroMarketing']['idApp_Marketing'] . '  ': FALSE;
		//$data['Marketing'] = ($_SESSION['FiltroMarketing']['Marketing'] != "0" ) ? ' AND PRC.Marketing = ' . $_SESSION['FiltroMarketing']['Marketing'] . '  ': FALSE;
		$data['CategoriaMarketing'] = ($_SESSION['FiltroMarketing']['CategoriaMarketing'] != "0" ) ? ' AND PRC.CategoriaMarketing = ' . $_SESSION['FiltroMarketing']['CategoriaMarketing'] . '  ': FALSE;
		$data['Cliente'] = ($_SESSION['FiltroMarketing']['idApp_Cliente']  ) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroMarketing']['idApp_Cliente'] . '  ': FALSE;
		$data['Fornecedor'] = ($_SESSION['FiltroMarketing']['idApp_Fornecedor']  ) ? ' AND PRC.idApp_Fornecedor = ' . $_SESSION['FiltroMarketing']['idApp_Fornecedor'] . '  ': FALSE;
		$data['NomeUsuario'] = ($_SESSION['FiltroMarketing']['NomeUsuario']  ) ? ' AND PRC.idSis_Usuario = ' . $_SESSION['FiltroMarketing']['NomeUsuario'] . '  ': FALSE;
		$data['Compartilhar'] = ($_SESSION['FiltroMarketing']['Compartilhar']  ) ? ' AND PRC.Compartilhar = ' . $_SESSION['FiltroMarketing']['Compartilhar'] . '  ': FALSE;
		$data['ConcluidoMarketing'] = ($_SESSION['FiltroMarketing']['ConcluidoMarketing'] != "#" ) ? ' AND PRC.ConcluidoMarketing = "' . $_SESSION['FiltroMarketing']['ConcluidoMarketing'] . '"  ': FALSE;
		$data['Agrupar'] = ($_SESSION['FiltroMarketing']['Agrupar'] == "0") ? 'PRC.idApp_Marketing': 'PRC.' . $_SESSION['FiltroMarketing']['Agrupar'];
		$data['Campo'] = (!$_SESSION['FiltroMarketing']['Campo']) ? 'PRC.DataMarketing' : $_SESSION['FiltroMarketing']['Campo'];
        $data['Ordenamento'] = (!$_SESSION['FiltroMarketing']['Ordenamento']) ? 'DESC' : $_SESSION['FiltroMarketing']['Ordenamento'];
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
				LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = PRC.idApp_Fornecedor
				LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
				LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
				LEFT JOIN App_SubMarketing AS SPRC ON SPRC.idApp_Marketing = PRC.idApp_Marketing
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
				PRC.TipoMarketing = ' . $data['TipoMarketing'] . '
				' . $data['idApp_Marketing'] . '
				' . $data['CategoriaMarketing'] . '
				' . $data['Cliente'] . '
				' . $data['Fornecedor'] . '
				' . $data['NomeUsuario'] . '
				' . $data['Compartilhar'] . '
				' . $data['ConcluidoMarketing'] . '
			GROUP BY
				idApp_Marketing
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
       // exit ();
       */
	   
        return $query;
    }

    public function get_submarketing_empresa($data) {
		$query = $this->db->query('SELECT * FROM App_SubMarketing WHERE idSis_Empresa = ' . $data['idSis_Empresa']);
        $query = $query->result_array();

        return $query;
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
