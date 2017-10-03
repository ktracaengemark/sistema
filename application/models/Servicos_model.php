<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Servicos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_servicos($data) {

        $query = $this->db->insert('App_Servicos', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_valor($data) {

        $query = $this->db->insert_batch('App_ValorServ', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_servicos($data) {
        $query = $this->db->query('SELECT * FROM App_Servicos WHERE idApp_Servicos = ' . $data);
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

    public function get_valor($data) {
		$query = $this->db->query('SELECT * FROM App_ValorServ WHERE idApp_Servicos = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function list_servicos($id, $aprovado, $completo) {

        $query = $this->db->query('
            SELECT
                TF.idApp_Servicos,
                TF.TipoProduto,
                TF.Servicos
            FROM
                App_Servicos AS TF
            WHERE
                TF.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
            ORDER BY
                TF.TipoProduto ASC
				
        ');
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
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {

                    $row->TipoProduto = $this->get_tipoproduto($row->TipoProduto);
                }
                return $query;
            }
        }
    }

    public function update_servicos($data, $id) {

        unset($data['idApp_Servicos']);
        $query = $this->db->update('App_Servicos', $data, array('idApp_Servicos' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_valor($data) {

        $query = $this->db->update_batch('App_ValorServ', $data, 'idApp_ValorServ');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_valor($data) {

        $this->db->where_in('idApp_ValorServ', $data);
        $this->db->delete('App_ValorServ');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_servicos($id) {


        $query = $this->db->delete('App_ValorServ', array('idApp_Servicos' => $id));
        $query = $this->db->delete('App_Servicos', array('idApp_Servicos' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_tipoproduto($data) {
		$query = $this->db->query('SELECT TipoProduto FROM Tab_TipoProduto WHERE idTab_TipoProduto = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['TipoProduto'])) ? $query[0]['TipoProduto'] : FALSE;
    }

}
