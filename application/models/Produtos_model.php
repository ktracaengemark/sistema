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

        $query = $this->db->insert('Tab_Produtos', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_valor($data) {

        $query = $this->db->insert_batch('Tab_Valor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_produtos($data) {
        $query = $this->db->query('SELECT * FROM Tab_Produtos WHERE idTab_Produtos = ' . $data);
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
		$query = $this->db->query('SELECT * FROM Tab_Valor WHERE idTab_Produtos = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function list_produtos($id, $aprovado, $completo) {

        $query = $this->db->query('
            SELECT
                TF.idTab_Produtos,
                TF.TipoProduto,
                TF.Produtos
            FROM
                Tab_Produtos AS TF
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

        unset($data['idTab_Produtos']);
        $query = $this->db->update('Tab_Produtos', $data, array('idTab_Produtos' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_valor($data) {

        $query = $this->db->update_batch('Tab_Valor', $data, 'idTab_Valor');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_valor($data) {

        $this->db->where_in('idTab_Valor', $data);
        $this->db->delete('Tab_Valor');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_produtos($id) {


        $query = $this->db->delete('Tab_Valor', array('idTab_Produtos' => $id));
        $query = $this->db->delete('Tab_Produtos', array('idTab_Produtos' => $id));

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
	
	public function select_produtos($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
            'SELECT
                TPV.idTab_Produtos,
				CONCAT(IFNULL(TPV.Produtos,""), " --- ", IFNULL(TFO.NomeFornecedor,""), " --- ", IFNULL(TPV.CodProd,""), " --- ", IFNULL(TPV.UnidadeProduto,"")) AS NomeProduto,
				TPV.ValorCompraProduto,
				TPV.Categoria
            FROM
                Tab_Produtos AS TPV																	
            WHERE
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TPV.Empresa = ' . $_SESSION['log']['Empresa'] . '
			ORDER BY  
				TPV.Categoria ASC,
				TPV.Produtos ASC 
    ');
        } else {
            $query = $this->db->query(
            'SELECT
                TPV.idTab_Produtos,
				CONCAT(IFNULL(TPV.Produtos,""), " --- ", IFNULL(TFO.NomeFornecedor,""), " --- ", IFNULL(TPV.CodProd,""), " --- ", IFNULL(TPV.UnidadeProduto,"")) AS NomeProduto,
				TPV.ValorCompraProduto,
				TPV.Categoria
            FROM
                Tab_Produtos AS TPV
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = TPV.Fornecedor																	
            WHERE
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TPV.Empresa = ' . $_SESSION['log']['Empresa'] . '
			ORDER BY  
				TPV.Categoria ASC,
				TPV.Produtos ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produtos] = $row->NomeProduto;
            }
        }

        return $array;
    }	

}
