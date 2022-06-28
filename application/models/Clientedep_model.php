<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientedep_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_clientedep($data) {

        $query = $this->db->insert('App_ClienteDep', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_arquivo($data) {

        $query = $this->db->insert('Sis_Arquivo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }

    public function get_clientedep_verificacao($data) {
        $query = $this->db->query(
			'SELECT 
				idApp_ClienteDep 
			FROM 
				App_ClienteDep 
			WHERE 
				idApp_ClienteDep = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);

        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }

    public function get_clientedep($data) {
        $query = $this->db->query(
			'SELECT 
				* 
			FROM 
				App_ClienteDep 
			WHERE 
				idApp_ClienteDep = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
    }

    public function update_clientedep($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_ClienteDep', $data, array('idApp_ClienteDep' => $id));
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

    public function delete_clientedep($data) {
        $query = $this->db->delete('App_ClienteDep', array('idApp_ClienteDep' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_clientedep($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_ClienteDep WHERE '
                . 'idApp_Cliente = ' . $_SESSION['Cliente']['idApp_Cliente'] . ' '
                . 'ORDER BY NomeClienteDep ASC ');
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
                    //$row->Idade = $this->basico->calcula_idade($row->DataNascimentoDep);
                    //$row->DataNascimentoDep = $this->basico->mascara_data($row->DataNascimentoDep, 'barras');
                    //$row->SexoDep = $this->Basico_model->get_sexo($row->SexoDep);
					//$row->RelaCom = $this->Basico_model->get_relacom($row->RelaCom);
					//$row->Relacao = $this->Basico_model->get_relacao($row->Relacao);
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
