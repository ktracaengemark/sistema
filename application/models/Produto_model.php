<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Produto_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
   
    public function set_produto($data) {

        $query = $this->db->insert('Tab_Produto', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }   
    
    public function get_produto($data) {
        $query = $this->db->query('SELECT * FROM Tab_Produto WHERE idTab_Produto = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }    
    
    public function update_produto($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Produto', $data, array('idTab_Produto' => $id));
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

	public function delete_produto($data) {        
		$query = $this->db->delete('Tab_Produto', array('idTab_Produto' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function lista_produto1($x) {

        $query = $this->db->query(
                'SELECT '
                    . 'idTab_Produto, '
                    . 'NomeProduto, '
                    . 'TipoProduto, '
					. 'Convenio, '
					. 'ProdutoBase, '
                    . 'UnidadeProduto, '
                    . 'ValorCompraProduto, '
                    . 'ValorVendaProduto '
                    . 'FROM '
                    . 'Tab_Produto '
                    . 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' ' 
					. 'ORDER BY TipoProduto ASC, NomeProduto ASC ');
        
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

	public function lista_produto($x) {

        $query = $this->db->query('
            SELECT
                D.idTab_Produto,
                CO.Convenio,
				CONCAT(PB.TipoProdutoBase, " --- ", PB.ProdutoBase, " --- ", PB.UnidadeProdutoBase, " --- R$ ", PB.ValorCompraProdutoBase) AS ProdutoBase,
				D.ValorVendaProduto
            
            FROM
                Tab_Produto AS D
				LEFT JOIN Tab_ProdutoBase AS PB ON PB.idTab_ProdutoBase = D.ProdutoBase
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = D.Convenio
				
            WHERE
                D.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                D.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' 

            ORDER BY
				D.Convenio DESC,
				PB.ProdutoBase ASC
				
				
        ');

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
                $query = $query->result_array();
                return $query;
            }
        }
    }
	   		
	public function select_produto($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Produto,				
				CONCAT(TipoProduto, " --- ", NomeProduto, " --- ", ProdutoBase, " --- ", UnidadeProduto, " --- R$", ValorCompraProduto) AS NomeProduto				
            FROM
                Tab_Produto
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY TipoProduto DESC, NomeProduto ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Produto,
				CONCAT(TipoProduto, " --- ", NomeProduto, " --- ", ProdutoBase, " --- ", UnidadeProduto, " --- R$", ValorCompraProduto) AS NomeProduto				
            FROM
                Tab_Produto
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY TipoProduto DESC, NomeProduto ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->NomeProduto;
            }
        }

        return $array;
    }
}
