<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_produtos($data) {

        $query = $this->db->insert('App_Produtos', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_valor($data) {

        $query = $this->db->insert_batch('App_Valor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_produtos($data) {
        $query = $this->db->query('SELECT * FROM App_Produtos WHERE idApp_Produtos = ' . $data);
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
		$query = $this->db->query('SELECT * FROM App_Valor WHERE idApp_Produtos = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function list_produtos($id, $aprovado, $completo) {

        $query = $this->db->query('
            SELECT
                TF.idApp_Produtos,
                TF.TipoProduto,
                TF.Produtos
            FROM
                App_Produtos AS TF
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

    public function update_produtos($data, $id) {

        unset($data['idApp_Produtos']);
        $query = $this->db->update('App_Produtos', $data, array('idApp_Produtos' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_valor($data) {

        $query = $this->db->update_batch('App_Valor', $data, 'idApp_Valor');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_valor($data) {

        $this->db->where_in('idApp_Valor', $data);
        $this->db->delete('App_Valor');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_produtos($id) {


        $query = $this->db->delete('App_Valor', array('idApp_Produtos' => $id));
        $query = $this->db->delete('App_Produtos', array('idApp_Produtos' => $id));

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
