<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Prodaux1_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_prodaux1($data) {

        $query = $this->db->insert('Tab_Prodaux1', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_prodaux1($data) {
        $query = $this->db->query('SELECT * FROM Tab_Prodaux1 WHERE idTab_Prodaux1 = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_prodaux1($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Prodaux1', $data, array('idTab_Prodaux1' => $id));
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
	
	public function delete_prodaux1($data) {        
		$query = $this->db->delete('Tab_Prodaux1', array('idTab_Prodaux1' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_prodaux1($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_Prodaux1 '
                . 'WHERE '
                . 'Empresa = ' . $_SESSION['log']['Empresa'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY Abrev1 ASC ');

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

    public function select_prodaux13($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Prodaux1, '
                    . 'Prodaux1, '
					. 'Abrev1, '
                    . 'FROM '
                    . 'Tab_Prodaux1 '
					. 'ORDER BY idTab_Prodaux1 ASC ');
					#. 'WHERE '
                   # . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                   # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] ) . ' '
					
        } else {
            #$query = $this->db->query('SELECT idTab_Prodaux1, Prodaux1, Abrev1 FROM Tab_Prodaux1 WHERE idSis_Usuario = ' . $_SESSION['log']['id']);
			$query = $this->db->query('SELECT idTab_Prodaux1 FROM Tab_Prodaux1 ORDER BY Prodaux1 ASC ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux1] = $row->Prodaux1;
            }
        }

        return $array;
    }
	
	public function select_prodaux11($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Prodaux1,
				Prodaux1,
				Abrev1
            FROM
                Tab_Prodaux1
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY Prodaux1 ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Prodaux1,
				Prodaux1,
				Abrev1
            FROM
                Tab_Prodaux1
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY Prodaux1 ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Prodaux1] = $row->Prodaux1;
            }
        }

        return $array;
    }
	
	public function select_prodaux1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Prodaux1,
				CONCAT(Abrev1, " - " , Prodaux1) AS Prodaux1,
				Abrev1
            FROM
                Tab_Prodaux1
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                Empresa = ' . $_SESSION['log']['Empresa'] . '
                ORDER BY Prodaux1 ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Prodaux1,
				CONCAT(Abrev1, " - " , Prodaux1) AS Prodaux1,
				Abrev1
            FROM
                Tab_Prodaux1
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                Empresa = ' . $_SESSION['log']['Empresa'] . '
                ORDER BY Prodaux1 ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux1] = $row->Prodaux1;
            }
        }

        return $array;
    }

}
