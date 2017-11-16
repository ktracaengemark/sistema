<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Prodaux3_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_prodaux3($data) {

        $query = $this->db->insert('Tab_Prodaux3', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_prodaux3($data) {
        $query = $this->db->query('SELECT * FROM Tab_Prodaux3 WHERE idTab_Prodaux3 = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_prodaux3($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Prodaux3', $data, array('idTab_Prodaux3' => $id));
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
	
	public function delete_prodaux3($data) {        
		$query = $this->db->delete('Tab_Prodaux3', array('idTab_Prodaux3' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_prodaux3($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_Prodaux3 '
                . 'WHERE '
                . 'Empresa = ' . $_SESSION['log']['Empresa'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY Abrev3 ASC ');

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

    public function select_prodaux33($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Prodaux3, '
                    . 'Prodaux3, '
					. 'Abrev3, '
                    . 'FROM '
                    . 'Tab_Prodaux3 '
					. 'ORDER BY idTab_Prodaux3 ASC ');
					#. 'WHERE '
                   # . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                   # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] ) . ' '
					
        } else {
            #$query = $this->db->query('SELECT idTab_Prodaux3, Prodaux3, Abrev3 FROM Tab_Prodaux3 WHERE idSis_Usuario = ' . $_SESSION['log']['id']);
			$query = $this->db->query('SELECT idTab_Prodaux3 FROM Tab_Prodaux3 ORDER BY Prodaux3 ASC ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux3] = $row->Prodaux3;
            }
        }

        return $array;
    }
	
	public function select_prodaux31($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Prodaux3,
				Prodaux3,
				Abrev3
            FROM
                Tab_Prodaux3
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY Prodaux3 ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Prodaux3,
				Prodaux3,
				Abrev3
            FROM
                Tab_Prodaux3
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY Prodaux3 ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Prodaux3] = $row->Prodaux3;
            }
        }

        return $array;
    }
	
	public function select_prodaux3($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Prodaux3,
				CONCAT(Abrev3, " - " , Prodaux3) AS Prodaux3,
				Abrev3
            FROM
                Tab_Prodaux3
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                Empresa = ' . $_SESSION['log']['Empresa'] . '
                ORDER BY Prodaux3 ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Prodaux3,
				CONCAT(Abrev3, " - " , Prodaux3) AS Prodaux3,
				Abrev3
            FROM
                Tab_Prodaux3
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                Empresa = ' . $_SESSION['log']['Empresa'] . '
                ORDER BY Prodaux3 ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux3] = $row->Prodaux3;
            }
        }

        return $array;
    }

}
