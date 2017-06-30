<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Convenio_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_convenio($data) {

        $query = $this->db->insert('Tab_Convenio', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_convenio($data) {
        $query = $this->db->query('SELECT * FROM Tab_Convenio WHERE idTab_Convenio = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_convenio($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Convenio', $data, array('idTab_Convenio' => $id));
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
	
	public function delete_convenio($data) {        
		$query = $this->db->delete('Tab_Convenio', array('idTab_Convenio' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_convenio($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_Convenio '
                . 'WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY Convenio DESC ');

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
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function select_convenio2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Convenio, '
                    . 'Convenio, '
					. 'Abrev, '
                    . 'FROM '
                    . 'Tab_Convenio '
					. 'ORDER BY idTab_Convenio ASC ');
					#. 'WHERE '
                   # . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                   # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] ) . ' '
					
        } else {
            #$query = $this->db->query('SELECT idTab_Convenio, Convenio, Abrev FROM Tab_Convenio WHERE idSis_Usuario = ' . $_SESSION['log']['id']);
			$query = $this->db->query('SELECT idTab_Convenio FROM Tab_Convenio ORDER BY Convenio ASC ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Convenio] = $row->Convenio;
            }
        }

        return $array;
    }
	
	public function select_convenio($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Convenio,
				Convenio,
				Abrev
            FROM
                Tab_Convenio
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY Convenio DESC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Convenio,
				Convenio,
				Abrev
            FROM
                Tab_Convenio
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY Convenio DESC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Convenio] = $row->Convenio;
            }
        }

        return $array;
    }

}
