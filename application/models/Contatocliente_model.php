<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Contatocliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_contatocliente($data) {

        $query = $this->db->insert('App_ContatoCliente', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_contatocliente_verificacao($data) {
        $query = $this->db->query(
			'SELECT
				idApp_ContatoCliente 
			FROM 
				App_ContatoCliente 
			WHERE
				idApp_ContatoCliente = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        
		$query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }

    public function get_contatocliente($data) {
        $query = $this->db->query(
			'SELECT
				* 
			FROM 
				App_ContatoCliente 
			WHERE
				idApp_ContatoCliente = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
    }

    public function update_contatocliente($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_ContatoCliente', $data, array('idApp_ContatoCliente' => $id));
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

    public function delete_contatocliente($data) {
        $query = $this->db->delete('App_ContatoCliente', array('idApp_ContatoCliente' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_contatocliente($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_ContatoCliente WHERE '
                . 'idApp_Cliente = ' . $data . ' '
                . 'ORDER BY NomeContatoCliente ASC ');
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
					$row->Relacao = $this->Basico_model->get_relacao($row->Relacao);
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
