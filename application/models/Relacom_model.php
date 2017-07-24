<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Relacom_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_relacom($data) {

        $query = $this->db->insert('Tab_RelaCom', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_relacom($data) {
        $query = $this->db->query('SELECT * FROM Tab_RelaCom WHERE idTab_RelaCom = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_relacom($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_RelaCom', $data, array('idTab_RelaCom' => $id));
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

    public function lista_relacom($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_RelaCom '
                #. 'WHERE '
                #. 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
               # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY RelaCom ASC ');

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
                #    $row->idTab_RelaCom = $row->idTab_RelaCom;
                #    $row->RelaCom = $row->RelaCom;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

	public function select_relacom($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT * '
                    . 'idTab_RelaCom, '
                    . 'RelaCom '
                    . 'FROM '
                    . 'Tab_RelaCom '
					#. 'WHERE '
                    #. 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                    #. 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo']);
					. 'ORDER BY RelaCom ASC ');

        } else {
            #$query = $this->db->query('SELECT  idTab_RelaCom, RelaCom FROM Tab_RelaCom  WHERE idSis_Usuario = ' . $_SESSION['log']['id']);
            $query = $this->db->query('SELECT  idTab_RelaCom, RelaCom FROM Tab_RelaCom  ORDER BY RelaCom ASC ');
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_RelaCom] = $row->RelaCom;
				#$array[$row->RelaCom] = $row->RelaCom;
            }
        }

        return $array;
    }

	/*public function select_relacom($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_RelaCom ORDER BY RelaCom ASC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_RelaCom ORDER BY RelaCom ASC');

            $array = array();
            #$array[0] = ':: SELECIONE ::';
            foreach ($query->result() as $row) {
                #$array[$row->idTab_Municipio] = $row->NomeMunicipio;
				$array[$row->RelaCom] = $row->RelaCom;
            }
        }

        return $array;
    }*/

}
