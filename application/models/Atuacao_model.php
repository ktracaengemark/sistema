<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Atuacao_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_atuacao($data) {

        $query = $this->db->insert('App_Atuacao', $data);

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
	
    public function get_atuacao($data) {
        $query = $this->db->query('SELECT * FROM App_Atuacao WHERE idApp_Atuacao = ' . $data);
        $query = $query->result_array();

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query[0];
    }
	
    public function update_atuacao($data, $id) {

        unset($data['idApp_Atuacao']);
        $query = $this->db->update('App_Atuacao', $data, array('idApp_Atuacao' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_atuacao($id) {

        $query = $this->db->delete('App_Atuacao', array('idApp_Atuacao' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
}
