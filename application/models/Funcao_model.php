<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Funcao_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
   
    public function set_funcao($data) {

        $query = $this->db->insert('Tab_Funcao', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_funcao($data) {
        $query = $this->db->query('SELECT * FROM Tab_Funcao WHERE idTab_Funcao = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_funcao($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Funcao', $data, array('idTab_Funcao' => $id));
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
	
	public function delete_funcao($data) {        
		$query = $this->db->delete('Tab_Funcao', array('idTab_Funcao' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }	

    public function lista_funcao($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_Funcao '
                . 'WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY Funcao ASC ');
        
        /*
          echo $this->db->last_query();
          $query = $query->result_array();
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
                #foreach ($query->result_array() as $row) {
                #    $row->idTab_Funcao = $row->idTab_Funcao;
                #    $row->Funcao = $row->Funcao;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function lista_funcao3($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_Funcao '
                . 'WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY Funcao ASC ');
        
        /*
          echo $this->db->last_query();
          $query = $query->result_array();
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
                #foreach ($query->result_array() as $row) {
                #    $row->idTab_Funcao = $row->idTab_Funcao;
                #    $row->Funcao = $row->Funcao;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }
	
	public function select_funcao($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Funcao, '
                    . 'Funcao '
                    . 'FROM '
                    . 'Tab_Funcao '					
					. 'WHERE '
                    . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' '

					. 'ORDER BY Funcao ASC ');		
					
        } else {
            $query = $this->db->query(
				'SELECT '
                    . 'idTab_Funcao, '
                    . 'Funcao '
                    . 'FROM '
                    . 'Tab_Funcao '					
					. 'WHERE '
                    . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' '

					. 'ORDER BY Funcao ASC ');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Funcao] = $row->Funcao;
				#$array[$row->Funcao] = $row->Funcao;
            }
        }

        return $array;
    }
	
	public function select_funcao2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT 
                    idTab_Funcao, 
                    CONCAT(Abrev, " --- ", Funcao) AS Funcao,
					Abrev
				FROM 
                    Tab_Funcao 					
				WHERE  
                    idTab_Modulo = "10" 
				ORDER BY idTab_Funcao ASC 
			');		
					
        } else {
            $query = $this->db->query('
				SELECT 
                    idTab_Funcao, 
                    CONCAT(Abrev, " --- ", Funcao) AS Funcao,
					Abrev 
				FROM 
                    Tab_Funcao 					
				WHERE 
                    idTab_Modulo = "10" 
				ORDER BY idTab_Funcao ASC 
			');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Funcao] = $row->Funcao;
				#$array[$row->Funcao] = $row->Funcao;
            }
        }

        return $array;
    }
	
    
}
