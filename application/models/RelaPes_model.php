<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class RelaPes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
   
    public function set_relapes($data) {

        $query = $this->db->insert('Tab_RelaPes', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_relapes($data) {
        $query = $this->db->query('SELECT * FROM Tab_RelaPes WHERE idTab_RelaPes = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_relapes($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_RelaPes', $data, array('idTab_RelaPes' => $id));
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

    public function lista_relapes($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_RelaPes '
                #. 'WHERE '
                #. 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                #. 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY RelaPes ASC ');
        
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
                #    $row->idTab_RelaPes = $row->idTab_RelaPes;
                #    $row->RelaPes = $row->RelaPes;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }
	
	public function select_relapes($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT * '
                    . 'idTab_RelaPes, '
                    . 'RelaPes '
                    . 'FROM '
                    . 'Tab_RelaPes '					
					#. 'WHERE '
                   # . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                   # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo']);
					. 'ORDER BY RelaPes ASC ');		
					
        } else {
            #$query = $this->db->query('SELECT  idTab_RelaPes, RelaPes FROM Tab_RelaPes  WHERE idSis_Usuario = ' . $_SESSION['log']['id']);
			$query = $this->db->query('SELECT  idTab_RelaPes, RelaPes FROM Tab_RelaPes ORDER BY RelaPes ASC ');
            
            $array = array();
            foreach ($query->result() as $row) {
                #$array[$row->idTab_RelaPes] = $row->RelaPes;
				$array[$row->RelaPes] = $row->RelaPes;
            }
        }

        return $array;
    }
	
	/*public function select_relapes($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_RelaPes ORDER BY RelaPes ASC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_RelaPes ORDER BY RelaPes ASC');

            $array = array();
            #$array[0] = ':: SELECIONE ::';
            foreach ($query->result() as $row) {
                #$array[$row->idTab_Municipio] = $row->NomeMunicipio;
				$array[$row->RelaPes] = $row->RelaPes;
            }
        }

        return $array;
    }*/
    
}
