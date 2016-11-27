<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Atividade_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
   
    public function set_atividade($data) {

        $query = $this->db->insert('App_Atividade', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_atividade($data) {
        $query = $this->db->query('SELECT * FROM App_Atividade WHERE idApp_Atividade = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_atividade($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Atividade', $data, array('idApp_Atividade' => $id));
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

    public function lista_atividade($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Atividade '
                . 'WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY Atividade ASC ');
        
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
                #    $row->idApp_Atividade = $row->idApp_Atividade;
                #    $row->Atividade = $row->Atividade;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }
	
	public function select_atividade($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT * '
                    . 'idApp_Atividade, '
                    . 'Atividade '
                    . 'FROM '
                    . 'App_Atividade '					
					. 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo']);
							
					
        } else {
            $query = $this->db->query('SELECT  idApp_Atividade, Atividade FROM App_Atividade  WHERE idSis_Usuario = ' . $_SESSION['log']['id']);
            
            $array = array();
            foreach ($query->result() as $row) {
                #$array[$row->idApp_Atividade] = $row->Atividade;
				$array[$row->Atividade] = $row->Atividade;
            }
        }

        return $array;
    }
	
	/*public function select_atividade($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM App_Atividade ORDER BY Atividade ASC');
        } else {
            $query = $this->db->query('SELECT * FROM App_Atividade ORDER BY Atividade ASC');

            $array = array();
            #$array[0] = ':: SELECIONE ::';
            foreach ($query->result() as $row) {
                #$array[$row->idTab_Municipio] = $row->NomeMunicipio;
				$array[$row->Atividade] = $row->Atividade;
            }
        }

        return $array;
    }*/
    
}
