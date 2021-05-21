<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Formapag_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_formapag($data) {

        $query = $this->db->insert('Tab_FormaPag', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_formapag($data) {
        $query = $this->db->query('SELECT * FROM Tab_FormaPag WHERE idTab_FormaPag = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_formapag($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_FormaPag', $data, array('idTab_FormaPag' => $id));
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

   /* public function lista_formapag($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_FormaPag '
                . 'WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY FormaPag ASC ');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();

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
    }*/
	
	public function lista_formapag($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_FormaPag '
                . 'WHERE '
                . 'Empresa = ' . $_SESSION['log']['Empresa'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY idTab_FormaPag ASC ');

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

    public function select_formapag2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_FormaPag, '
                    . 'FormaPag, '
                    #. 'ValorVenda '
                    . 'FROM '
                    . 'Tab_FormaPag '
                    . 'WHERE '
                    #. 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ''
					. 'ORDER BY idTab_FormaPag ASC ');
        } else {
            $query = $this->db->query('SELECT idTab_FormaPag, FormaPag FROM Tab_FormaPag WHERE idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo']);
            #$query = $this->db->query('SELECT idTab_FormaPag, FormaPag FROM Tab_FormaPag ORDER BY idTab_FormaPag ASC ');
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_FormaPag] = $row->FormaPag;
            }
        }

        return $array;
    }
	
	public function select_formapag($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_FormaPag, '
                    . 'FormaPag '
                    . 'FROM '
                    . 'Tab_FormaPag '
                    . 'WHERE '
                    
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo']. ' '
					. 'ORDER BY FormaPag DESC ');		
					
        } else {
            $query = $this->db->query(
                'SELECT '
                    . 'idTab_FormaPag, '
                    . 'FormaPag '
                    . 'FROM '
                    . 'Tab_FormaPag '
                    . 'WHERE '
                    
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo']. ' '
					. 'ORDER BY FormaPag DESC ');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_FormaPag] = $row->FormaPag;
            }
        }

        return $array;
    }

}
