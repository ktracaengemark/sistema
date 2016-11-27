<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Servico_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
       
    public function set_servico($data) {

        $query = $this->db->insert('Tab_Servico', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }    
    
    public function get_servico($data) {
        $query = $this->db->query('SELECT * FROM Tab_Servico WHERE idTab_Servico = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }
    
    public function update_servico($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Servico', $data, array('idTab_Servico' => $id));
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
 
    public function lista_servico($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_Servico '
                . 'WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY NomeServico ASC ');
        
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

    public function select_servico($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Servico, '
                    . 'NomeServico, '
                    . 'ValorServVenda '
                    . 'FROM '
                    . 'Tab_Servico '
                    . 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] );
        } else {
            $query = $this->db->query('SELECT idTab_Servico, NomeServico, ValorServVenda FROM Tab_Servico WHERE idSis_Usuario = ' . $_SESSION['log']['id']);
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->NomeServico;
            }
        }

        return $array;
    }    
    
}
