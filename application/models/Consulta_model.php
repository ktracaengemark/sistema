<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Consulta_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_consulta($data) {

        $query = $this->db->insert('App_Consulta', $data);

        if ($this->db->affected_rows() === 0)
            return FALSE;
        else
            return $this->db->insert_id();
    }

    public function get_consulta($data) {
        $query = $this->db->query('
			SELECT * 
			FROM 
				App_Consulta AS C
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = C.idSis_Empresa
			WHERE 
				C.idApp_Consulta = ' . $data
		);
		
        $query = $query->result_array();

        return $query[0];
    }

    public function get_consulta_orca($data) {
        $query = $this->db->query('
			SELECT * 
			FROM 
				App_Consulta
			WHERE 
				idApp_OrcaTrata = ' . $data
		);
		
        $query = $query->result_array();

        return $query[0];
    }

    public function get_consulta_repeticao($id, $repeticao, $quais, $dataini) {

		if($quais == 4){
			$query = $this->db->query('
				SELECT idApp_Consulta, Repeticao, idApp_OrcaTrata
				FROM App_Consulta WHERE Repeticao = ' . $repeticao . '	
			');
		}elseif($quais == 3){
			$query = $this->db->query('
				SELECT idApp_Consulta, Repeticao, idApp_OrcaTrata 
				FROM App_Consulta WHERE Repeticao = ' . $repeticao . '	AND DataInicio >= "' . $dataini . '"	
			');
		}elseif($quais == 2){
			$query = $this->db->query('
				SELECT idApp_Consulta, Repeticao, idApp_OrcaTrata 
				FROM App_Consulta WHERE Repeticao = ' . $repeticao . '	AND DataInicio <= "' . $dataini . '"	
			');
		}else{
			$query = $this->db->query('
				SELECT idApp_Consulta, Repeticao, idApp_OrcaTrata 
				FROM App_Consulta WHERE idApp_Consulta = ' . $id . '	
			');
		}
        $query = $query->result_array();

        return $query;
    }
	
    public function get_consultas_orca($data) {
        $query = $this->db->query('
			SELECT * 
			FROM 
				App_Consulta
			WHERE 
				idApp_OrcaTrata = ' . $data
		);
		
        $query = $query->result_array();

        return $query;
    }
	
    public function get_consultas_zero($data) {
        $query = $this->db->query('
			SELECT * 
			FROM 
				App_Consulta
			WHERE 
				idApp_OrcaTrata = ' . $data . ' AND
				idApp_OrcaTrata != 0 
		');
		
        $query = $query->result_array();

        return $query;
    }
	
    public function get_consultas($data) {
        $query = $this->db->query('
			SELECT * 
			FROM 
				App_Consulta
			WHERE 
				Repeticao = ' . $data . '
			ORDER BY
				idApp_Consulta ASC
		');
		
        $query = $query->result_array();

        return $query;
    }
	
    public function get_consulta_datatermino($data) {
        $query = $this->db->query('
			SELECT 
				idApp_Consulta,
				DataInicio
			FROM 
				App_Consulta
			WHERE 
				Repeticao = ' . $data . '
			ORDER BY
				DataInicio DESC
			LIMIT 1
		');
		
        $query = $query->result_array();

        return $query[0];
    }
	
    public function get_repeticao_cos($data) {
        $query = $this->db->query('
			SELECT
				CO.idApp_Consulta,
				CO.idApp_Cliente,
				CO.Recorrencia,
				CO.idApp_OrcaTrata,
				DATE_FORMAT(CO.DataInicio, "%d/%m/%Y") AS DataInicio,
				DATE_FORMAT(CO.DataInicio, "%H:%i") AS HoraInicio,
				DATE_FORMAT(CO.DataFim, "%Y-%m-%d") AS DataFim,
				DATE_FORMAT(CO.DataFim, "%H:%i") AS HoraFim
			FROM 
				App_Consulta AS CO
			WHERE 
				CO.Repeticao = ' . $data . ' 
			ORDER BY
				CO.DataInicio ASC
		');
		
        $query = $query->result_array();

        return $query;
    }
	
    public function get_produto($data) {
		$query = $this->db->query('
			SELECT  
				OT.idApp_OrcaTrata,
				OT.DataEntregaOrca,
				PV.idApp_Produto,
				PV.QtdProduto,
				PV.QtdIncrementoProduto,
				(PV.QtdProduto * PV.QtdIncrementoProduto) AS Qtd_Prod,
				PV.DataConcluidoProduto,
				PV.HoraConcluidoProduto,
				PV.ConcluidoProduto,
				PV.ValorProduto,
				PV.NomeProduto,
				PV.ObsProduto,
				TPS.Nome_Prod
			FROM 				
				App_OrcaTrata AS OT
					LEFT JOIN App_Produto AS PV ON PV.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = PV.idTab_Produtos_Produto
			WHERE 
				OT.idApp_OrcaTrata = ' . $data . ' 
			ORDER BY
            	OT.DataEntregaOrca ASC				
		
		');
        $query = $query->result_array();
		
		/*
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        */		
		
        return $query;
    }
	
    public function get_consultas_repet($data) {
        $query = $this->db->query('
			SELECT * 
			FROM 
				App_Consulta
			WHERE 
				Repeticao = ' . $data . ' AND
				idApp_OrcaTrata = 0
			ORDER BY
				idApp_Consulta ASC
		');
		
        $query = $query->result_array();

        return $query;
    }
	
    public function get_horarios($data) {
        $query = $this->db->query('
			SELECT * 
			FROM 
				App_Consulta
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				DataInicio = "' . $data . '"
			ORDER BY
				idApp_Consulta ASC
		');
		
        $query = $query->result_array();

        return $query;
    }
	
    public function get_recorrencia() {
        $query = $this->db->query('
			SELECT 
				idApp_Consulta,
				Recorrencias,
				Recorrencia
			FROM 
				App_Consulta
		');
		
        $query = $query->result_array();

        return $query;
    }
	
    public function get_consulta_posterior($id, $repeticao, $quais, $dia) {
		
		if($quais == 1){
			$filtro = 'idApp_Consulta = ' . $id . '';
		}elseif($quais == 2){
			$filtro = 'idApp_Consulta = ' . $id . ' OR (Repeticao = ' . $repeticao . ' AND DataInicio <= "' . $dia . '")';
		}elseif($quais == 3){
			$filtro = 'idApp_Consulta = ' . $id . ' OR (Repeticao = ' . $repeticao . ' AND DataInicio >= "' . $dia . '")';
		}elseif($quais == 4){
			$filtro = 'idApp_Consulta = ' . $id . ' OR Repeticao = ' . $repeticao . '';
		}
		
		$query = $this->db->query('
			SELECT 
				*
			FROM 
			App_Consulta
			WHERE
				' . $filtro . '
		');
		
        /*
			echo $this->db->last_query();
          
		  echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
		  
        $query = $query->result_array();

        return $query;
    }	
    
	public function get_orcatrata($data) {
        $query = $this->db->query('
			SELECT * 
			FROM 
				App_OrcaTrata
			WHERE 
				idApp_OrcaTrata = ' . $data
		);
		
        $query = $query->result_array();

        return $query[0];
    }
	
    public function update_procedimento($data) {

        $query = $this->db->update_batch('App_Consulta', $data, 'idApp_Consulta');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_consulta($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Consulta', $data, array('idApp_Consulta' => $id));
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */
        if ($this->db->affected_rows() === 0)
            return FALSE;
        else
            return TRUE;
    }

    public function delete_consulta($id, $repeticao, $quais, $dataini) {
		if($quais == 4){
			$this->db->delete('App_Consulta', array('Repeticao' => $repeticao));
		}elseif($quais == 3){
			$this->db->delete('App_Consulta', array('Repeticao' => $repeticao, 'DataInicio >=' => $dataini));
		}elseif($quais == 2){
			$this->db->delete('App_Consulta', array('Repeticao' => $repeticao, 'DataInicio <=' => $dataini));
		}else{
			$this->db->delete('App_Consulta', array('idApp_Consulta' => $id));
		}
        if ($this->db->affected_rows() === 0)
            return FALSE;
        else
            return TRUE;
    }

    public function lista_consulta_proxima($data) {

        $query = $this->db->query('SELECT '
                . 'C.idApp_Consulta, '
                . 'C.idApp_Agenda, '
                . 'C.idApp_Cliente, '
                . 'C.DataInicio, '
                . 'C.DataFim, '
                . 'S.idTab_Status, '
                . 'S.Status, '
                . 'D.NomeContatoCliente, '
                . 'V.Nome, '
                . 'C.Procedimento, '
                . 'C.Paciente, '
                . 'C.Obs '
            . 'FROM '
                . 'App_Consulta AS C '
                    . 'LEFT JOIN App_ContatoCliente AS D ON C.idApp_ContatoCliente = D.idApp_ContatoCliente, '
                . 'Tab_Status AS S, '                
                . 'Sis_Usuario AS V '
            . 'WHERE '
                . 'C.idApp_Cliente = ' . $data . ' AND '
                . '(C.DataInicio >= "' . date('Y-m-d H:i:s', time()) . '" OR ('
                . 'C.DataInicio < "' . date('Y-m-d H:i:s', time()) . '" AND '
                . 'C.DataFim >= "' . date('Y-m-d H:i:s', time()) . '") ) AND '
                . 'C.idTab_Status = S.idTab_Status AND '
                . 'V.idSis_Usuario = C.idSis_Usuario '
            . 'ORDER BY C.DataInicio ASC ');
        
        if ($query->num_rows() === 0)
            return FALSE;
        else
            return $query;
    }

    public function lista_consulta_anterior($data) {

        $query = $this->db->query('SELECT '
                . 'C.idApp_Consulta, '
                . 'C.idApp_Agenda, '
                . 'C.idApp_Cliente, '
                . 'C.DataInicio, '
                . 'C.DataFim, '
                . 'S.idTab_Status, '
                . 'S.Status, '
                . 'D.NomeContatoCliente, '
                . 'V.Nome, '
                . 'C.Procedimento, '
                . 'C.Paciente, '
                . 'C.Obs '
            . 'FROM '
                . 'App_Consulta AS C '
                    . 'LEFT JOIN App_ContatoCliente AS D ON C.idApp_ContatoCliente = D.idApp_ContatoCliente, '
                . 'Tab_Status AS S, '
                . 'Sis_Usuario AS V '
            . 'WHERE '
                . 'C.idApp_Cliente = ' . $data . ' AND '
                . 'C.DataFim < "' . date('Y-m-d H:i:s', time()) . '" AND '
                . 'C.idTab_Status = S.idTab_Status AND '
                . 'V.idSis_Usuario = C.idSis_Usuario '
            . 'ORDER BY C.DataInicio ASC ');
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
        else
            return $query;
    }

    public function select_contatocliente_cliente($data) {

        $q = 'SELECT '
                . 'idApp_ContatoCliente, '
                . 'NomeContatoCliente '
                . 'FROM '
                . 'App_ContatoCliente '
                . 'WHERE '
                . 'idApp_Cliente = ' . $data . ' '
                . 'ORDER BY NomeContatoCliente ASC ';
        
        if ($data === TRUE) {
            $array = $this->db->query($q);
        } else {
            $query = $this->db->query($q);
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_ContatoCliente] = $row->NomeContatoCliente;
            }
        }

        return $array;
    }            
            
}
