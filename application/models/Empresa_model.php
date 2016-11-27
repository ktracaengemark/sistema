<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
   
    
    public function set_empresa($data) {

        $query = $this->db->insert('App_Empresa', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_empresa($data) {
        $query = $this->db->query('SELECT * FROM App_Empresa WHERE idApp_Empresa = ' . $data);       
        $query = $query->result_array();

        return $query[0];
    }

    public function update_empresa($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Empresa', $data, array('idApp_Empresa' => $id));
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

    public function delete_empresa($data) {
        $query = $this->db->delete('App_Empresa', array('idApp_Empresa' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_empresa($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Empresa WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = 1 AND '
                . '(NomeEmpresa like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'NomeEmpresa like "%' . $data . '%" OR '
                
				. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Telefone1 like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY NomeEmpresa ASC ');
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
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                }

                return $query;
            }
        }
    }
	
	public function select_empresa($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idApp_Empresa, '
                    . 'NomeEmpresa '
                    . 'FROM '
                    . 'App_Empresa '
                    . 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] );
        } else {
            $query = $this->db->query('SELECT idApp_Empresa, NomeEmpresa FROM App_Empresa WHERE idSis_Usuario = ' . $_SESSION['log']['id']);
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }
    
}
