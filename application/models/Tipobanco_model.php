<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Tipobanco_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_tipobanco($data) {

        $query = $this->db->insert('Tab_TipoBanco', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_tipobanco($data) {
        $query = $this->db->query('SELECT * FROM Tab_TipoBanco WHERE idTab_TipoBanco = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_tipobanco($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_TipoBanco', $data, array('idTab_TipoBanco' => $id));
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
		
	public function delete_tipobanco($data) {        
		$query = $this->db->delete('Tab_TipoBanco', array('idTab_TipoBanco' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_tipobanco($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_TipoBanco '
                . 'WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY TipoBanco ASC ');

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
	
	public function select_tipobanco1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_TipoBanco, '
                    . 'TipoBanco, '
                    #. 'ValorVenda '
                    . 'FROM '
                    . 'Tab_TipoBanco '
                    . 'ORDER BY TipoBanco ASC ');
					#. 'WHERE '
                    #. 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                   # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] );
        } else {
            #$query = $this->db->query('SELECT idTab_TipoBanco, TipoBanco FROM Tab_TipoBanco WHERE idSis_Usuario = ' . $_SESSION['log']['id']);
			$query = $this->db->query('SELECT idTab_TipoBanco, TipoBanco FROM Tab_TipoBanco ORDER BY TipoBanco ASC ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoBanco] = $row->TipoBanco;
            }
        }

        return $array;
    }
	
	public function select_tipobanco($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_TipoBanco, '
                    . 'TipoBanco, '
                    . 'FROM '
                    . 'Tab_TipoBanco '

					. 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] );
				   
				   
        } else {
            $query = $this->db->query('SELECT idTab_TipoBanco, TipoBanco FROM Tab_TipoBanco WHERE idSis_Usuario = ' . $_SESSION['log']['id']);
			#$query = $this->db->query('SELECT idTab_TipoBanco, TipoBanco FROM Tab_TipoBanco ORDER BY TipoBanco ASC ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoBanco] = $row->TipoBanco;
            }
        }

        return $array;
    }

}
