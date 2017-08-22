<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Contatofornec_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }
    
    public function set_contatofornec($data) {

        $query = $this->db->insert('App_Contatofornec', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_contatofornec($data) {
        $query = $this->db->query('SELECT * FROM App_Contatofornec WHERE idApp_Contatofornec = ' . $data);
        
        $query = $query->result_array();

        return $query[0];
    }

    public function update_contatofornec($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Contatofornec', $data, array('idApp_Contatofornec' => $id));
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

    public function delete_contatofornec($data) {        
		$query = $this->db->delete('App_Contatofornec', array('idApp_Contatofornec' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_contatofornec($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Contatofornec WHERE '
                . 'idApp_Fornecedor = ' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . ' '
                . 'ORDER BY NomeContatofornec ASC ');
        /*
          echo $this->db->last_query();
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
                foreach ($query->result() as $row) {
                    $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                    $row->Sexo = $this->Basico_model->get_sexo($row->Sexo);
					$row->RelaCom = $this->Basico_model->get_relacom($row->RelaCom);
                }

                return $query;
            }
        }
    }
    
    public function select_status_vida($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusVida');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusVida');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->StatusVida;
            }
        }

        return $array;
    }    

}
