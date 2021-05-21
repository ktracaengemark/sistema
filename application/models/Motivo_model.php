<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Motivo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_motivo($data) {

        $query = $this->db->insert('Tab_Motivo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_motivo($data) {
        $query = $this->db->query('SELECT * FROM Tab_Motivo WHERE idTab_Motivo = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_motivo($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Motivo', $data, array('idTab_Motivo' => $id));
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
	
	public function delete_motivo($data) {        
		$query = $this->db->delete('Tab_Motivo', array('idTab_Motivo' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_motivo($x) {

        $query = $this->db->query('
            SELECT
                *
            FROM
                Tab_Motivo
            WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                Motivo ASC 
		');

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

    public function select_motivo3($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Motivo, '
                    . 'Motivo, '
					. 'Desc_Motivo, '
                    . 'FROM '
                    . 'Tab_Motivo '
					. 'ORDER BY idTab_Motivo ASC ');
					#. 'WHERE '
                   # . 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                   # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] ) . ' '
					
        } else {
            #$query = $this->db->query('SELECT idTab_Motivo, Motivo, Desc_Motivo FROM Tab_Motivo WHERE idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario']);
			$query = $this->db->query('SELECT idTab_Motivo FROM Tab_Motivo ORDER BY Motivo ASC ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Motivo] = $row->Motivo;
            }
        }

        return $array;
    }
	
	public function select_motivo1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Motivo,
				Motivo,
				Desc_Motivo
            FROM
                Tab_Motivo
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY Motivo ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Motivo,
				Motivo,
				Desc_Motivo
            FROM
                Tab_Motivo
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY Motivo ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Motivo] = $row->Motivo;
            }
        }

        return $array;
    }
	
	public function select_motivo($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Motivo,
				CONCAT(Motivo, " - " , idTab_Motivo) AS Motivo,
				Desc_Motivo
            FROM
                Tab_Motivo
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Motivo ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Motivo,
				CONCAT(Motivo, " - " , idTab_Motivo) AS Motivo,
				Desc_Motivo
            FROM
                Tab_Motivo
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Motivo ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Motivo] = $row->Motivo;
            }
        }

        return $array;
    }

}
