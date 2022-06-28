<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Procedimento_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_procedimento($data) {

        $query = $this->db->insert('App_Procedimento', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_orcatrata($data) {

        $query = $this->db->insert('App_Procedimento', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_procedimento($data) {
        $query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_Procedimento = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_procedimento2($data) {
        $query = $this->db->query('
			SELECT 
				PC.*,
				USC.Nome AS NomeCadastrou
			FROM 
				App_Procedimento PC
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Procedimento = ' . $data . '
		');

        $query = $query->result_array();

        return $query[0];
    }

    public function get_subprocedimento($data) {
        $query = $this->db->query('SELECT * FROM App_SubProcedimento WHERE idApp_Procedimento = ' . $data);

        $query = $query->result_array();

        return $query;
    }

    public function get_orcatrata_original($data) {
        $query = $this->db->query('
			SELECT 
				* 
			FROM 
				App_Procedimento 
			WHERE 
				idApp_Procedimento = ' . $data . '
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
				App_Procedimento AS PC
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = PC.Categoria
					LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = PC.Compartilhar
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Procedimento = ' . $data . '
		');
		
		foreach ($query->result_array() as $row) {
			//$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
			//$row->DataProcedimentoLimite = $this->basico->mascara_data($row->DataProcedimentoLimite, 'barras');
			//$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
			//$row->ConcluidoSubProcedimento = $this->basico->mascara_palavra_completa2($row->ConcluidoSubProcedimento, 'NS');
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
	
    public function get_procedimento_empresa($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		$date_inicio_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio9']) ? 'PRC.DataProcedimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio9'] . '" AND ' : FALSE;
		$date_fim_prc = ($_SESSION['FiltroAlteraParcela']['DataFim9']) ? 'PRC.DataProcedimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim9'] . '" AND ' : FALSE;

		$date_inicio_sub_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio10']) ? 'SPRC.DataSubProcedimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio10'] . '" AND ' : FALSE;
		$date_fim_sub_prc = ($_SESSION['FiltroAlteraParcela']['DataFim10']) ? 'SPRC.DataSubProcedimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim10'] . '" AND ' : FALSE;

		$hora_inicio_prc = ($_SESSION['FiltroAlteraParcela']['HoraInicio9']) ? 'PRC.HoraProcedimento >= "' . $_SESSION['FiltroAlteraParcela']['HoraInicio9'] . '" AND ' : FALSE;
		$hora_fim_prc = ($_SESSION['FiltroAlteraParcela']['HoraFim9']) ? 'PRC.HoraProcedimento <= "' . $_SESSION['FiltroAlteraParcela']['HoraFim9'] . '" AND ' : FALSE;
		
		$hora_inicio_sub_prc = ($_SESSION['FiltroAlteraParcela']['HoraInicio10']) ? 'SPRC.HoraSubProcedimento >= "' . $_SESSION['FiltroAlteraParcela']['HoraInicio10'] . '" AND ' : FALSE;
		$hora_fim_sub_prc = ($_SESSION['FiltroAlteraParcela']['HoraFim10']) ? 'SPRC.HoraSubProcedimento <= "' . $_SESSION['FiltroAlteraParcela']['HoraFim10'] . '" AND ' : FALSE;		
		
		$data['TipoProcedimento'] = $data['TipoProcedimento'];
		$data['idApp_Procedimento'] = ($_SESSION['FiltroAlteraParcela']['idApp_Procedimento'] != "" ) ? ' AND PRC.idApp_Procedimento = ' . $_SESSION['FiltroAlteraParcela']['idApp_Procedimento'] . '  ': FALSE;
		$data['Sac'] = ($_SESSION['FiltroAlteraParcela']['Sac'] != "0" ) ? ' AND PRC.Sac = ' . $_SESSION['FiltroAlteraParcela']['Sac'] . '  ': FALSE;
		$data['Marketing'] = ($_SESSION['FiltroAlteraParcela']['Marketing'] != "0" ) ? ' AND PRC.Marketing = ' . $_SESSION['FiltroAlteraParcela']['Marketing'] . '  ': FALSE;
		$data['Cliente'] = ($_SESSION['FiltroAlteraParcela']['idApp_Cliente']  ) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] . '  ': FALSE;
		$data['Fornecedor'] = ($_SESSION['FiltroAlteraParcela']['idApp_Fornecedor']  ) ? ' AND PRC.idApp_Fornecedor = ' . $_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] . '  ': FALSE;
		$data['NomeUsuario'] = ($_SESSION['FiltroAlteraParcela']['NomeUsuario']  ) ? ' AND PRC.idSis_Usuario = ' . $_SESSION['FiltroAlteraParcela']['NomeUsuario'] . '  ': FALSE;
		$data['Compartilhar'] = ($_SESSION['FiltroAlteraParcela']['Compartilhar']  ) ? ' AND PRC.Compartilhar = ' . $_SESSION['FiltroAlteraParcela']['Compartilhar'] . '  ': FALSE;
		$data['ConcluidoProcedimento'] = ($_SESSION['FiltroAlteraParcela']['ConcluidoProcedimento'] != "#" ) ? ' AND PRC.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoProcedimento'] . '"  ': FALSE;
		$data['Agrupar'] = ($_SESSION['FiltroAlteraParcela']['Agrupar'] == "0") ? 'PRC.idApp_Procedimento': 'PRC.' . $_SESSION['FiltroAlteraParcela']['Agrupar'];
		$data['Campo'] = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'PRC.DataProcedimento' : $_SESSION['FiltroAlteraParcela']['Campo'];
        $data['Ordenamento'] = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'DESC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
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
				PRC.*,
				PRC.idSis_Usuario,
				PRC.Compartilhar,
				C.*,
				EMP.*,
				U.idSis_Usuario,
				U.Nome AS NomeUsuario,
				AU.idSis_Usuario,
				AU.Nome AS NomeCompartilhar
            FROM 
				App_Procedimento AS PRC
				LEFT JOIN Sis_Empresa AS EMP ON EMP.idSis_Empresa = PRC.idSis_Empresa
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
				LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = PRC.idApp_Fornecedor
				LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
				LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
				LEFT JOIN App_SubProcedimento AS SPRC ON SPRC.idApp_Procedimento = PRC.idApp_Procedimento
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
				PRC.TipoProcedimento = ' . $data['TipoProcedimento'] . '
				' . $data['idApp_Procedimento'] . '
				' . $data['Sac'] . '
				' . $data['Marketing'] . '
				' . $data['Cliente'] . '
				' . $data['Fornecedor'] . '
				' . $data['NomeUsuario'] . '
				' . $data['Compartilhar'] . '
				' . $data['ConcluidoProcedimento'] . '
			GROUP BY
				idApp_Procedimento
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
        echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
       */
        return $query;
    }

    public function get_subprocedimento_empresa($data) {
		$query = $this->db->query('SELECT * FROM App_SubProcedimento WHERE idSis_Empresa = ' . $data['idSis_Empresa']);
        $query = $query->result_array();

        return $query;
    }	

    public function get_profissional($data) {
		$query = $this->db->query('SELECT NomeProfissional FROM App_Profissional WHERE idApp_Profissional = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['NomeProfissional'])) ? $query[0]['NomeProfissional'] : FALSE;
    }
	
    public function update_procedimento($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Procedimento', $data, array('idApp_Procedimento' => $id));
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
			
    public function update_orcatrata($data, $id) {

        unset($data['idApp_Procedimento']);
        $query = $this->db->update('App_Procedimento', $data, array('idApp_Procedimento' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function lista_procedimento($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Procedimento WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
				. 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND '
                . '(Procedimento like "%' . $data . '%" OR '
                #. 'DataProcedimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'Procedimento like "%' . $data . '%" OR '
                . 'DataProcedimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
				. 'DataConcluidoProcedimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Telefone1 like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY Procedimento ASC ');
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
                    $row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
                }

                return $query;
            }
        }
    }
	
    public function list_procedimento($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
			. 'PRC.Marketing, '
			. 'PRC.Sac, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 0 AND '
            . '(PRC.Sac = 0 OR PRC.Sac = 1) AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        }
    }

    public function list_informacao($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
			. 'PRC.Marketing, '
			. 'PRC.Sac, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 0 AND '
            . '(PRC.Sac = 0 OR PRC.Sac = 1) AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
				
                return $query;
            }
        
    }

    public function list_elogio($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
			. 'PRC.Sac, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Sac = 2 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }

    public function list_reclamacao($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
			. 'PRC.Sac, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Sac = 3 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
       
    }
			
    public function list_procedimento_orc($id, $concluido, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(PRC.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata != 0 AND '
            . 'PRC.Marketing = 0 AND '
			. $revendedor 
			. 'PRC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
       
    }
	
    public function list_orcamento($id, $aprovado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_Procedimento, '
			. 'OT.idApp_OrcaTrata, '
            . 'OT.DataProcedimento, '
			. 'OT.DataConcluidoProcedimento, '
			. 'OT.ConcluidoProcedimento, '
            . 'OT.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS OT '
            . 'WHERE '
            . 'OT.idApp_Cliente = ' . $id . ' AND '
            . 'OT.ConcluidoProcedimento = "' . $aprovado . '" '
            . 'ORDER BY '
			. 'OT.ConcluidoProcedimento ASC, '
			. 'OT.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        }
    }

    public function list_atualizacao($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 1 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }

    public function list_pesquisa($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 2 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }
	
    public function list_retorno($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 3 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }
	
    public function list_promocao($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 4 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }
	
    public function list_felicitacao($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 5 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }

    public function delete_procedimento($data) {

        $query = $this->db->query('SELECT* FROM App_Procedimento WHERE idApp_Procedimento = ' . $data);
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

        $this->db->delete('App_Procedimento', array('idApp_Procedimento' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_orcatrata($id) {

        $query = $this->db->delete('App_Procedimento', array('idApp_Procedimento' => $id));
        $query = $this->db->delete('App_SubProcedimento', array('idApp_Procedimento' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	public function select_procedimento($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Procedimento,
				CONCAT(IFNULL(Procedimento, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As Procedimento				
            FROM
                App_Procedimento					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY 
				Procedimento ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Procedimento,
				CONCAT(IFNULL(Procedimento, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As Procedimento				
            FROM
                App_Procedimento					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY 
				Procedimento ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Procedimento] = $row->Procedimento;
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
