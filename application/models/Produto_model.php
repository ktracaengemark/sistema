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

	public function lista_produto2($x) {

        $query = $this->db->query('
            SELECT
                TPV.idTab_Produto,
				TTP.TipoProduto,
				TPB.TipoProdutoBase,
				TPB.ProdutoBase,
				TPB.UnidadeProdutoBase,
				TPB.CodProd,
				TC.Convenio,
				TPB.ValorCompraProdutoBase,
				TPV.ValorVendaProduto           
            FROM
                Tab_Produto AS TPV				
				LEFT JOIN Tab_Convenio AS TC ON TC.idTab_Convenio = TPV.Convenio										
				LEFT JOIN Tab_ProdutoBase AS TPB ON TPB.idTab_ProdutoBase= TPV.ProdutoBase
				LEFT JOIN Tab_TipoProduto AS TTP ON TTP.Abrev = TPB.TipoProdutoBase
            WHERE
                TPV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' 
            ORDER BY
				TPB.TipoProdutoBase DESC,
				TPB.ProdutoBase,
				TC.Convenio DESC
											
        ');

        /*
		
		LEFT JOIN Tab_ProdutoBase AS PB ON PB.idTab_ProdutoBase = TPC.ProdutoBase
		
		
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
	
	public function lista_produto($x) {

        $query = $this->db->query('
            SELECT
                TPV.idTab_Produto,
				TTP.TipoProduto,
				TPV.CodProd,				
				TPV.NomeProduto,
				TPV.UnidadeProduto,
				TPV.ValorVendaProduto,				
				TPV.ValorCompraProduto,
				TSU.NomeEmpresa
            FROM
				Tab_Produto AS TPV
				LEFT JOIN Tab_TipoProduto AS TTP ON TTP.Abrev = TPV.TipoProduto
				LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = TPV.idSis_Usuario
            WHERE				
				TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					(TPV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' OR
					TPV.idSis_Usuario = ' . $_SESSION['log']['Empresa'] . ' )
            ORDER BY
				TPV.TipoProduto DESC,
				TPV.NomeProduto											
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
                TPV.idTab_Produto,
				CONCAT(TPV.NomeProduto, " --- ", TPV.UnidadeProduto, " --- R$ ", TPV.ValorCompraProduto) AS NomeProduto,
				TPV.ValorCompraProduto
            FROM
                Tab_Produto AS TPV																	
            WHERE
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TPV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY  
				TPV.NomeProduto ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT
                TPV.idTab_Produto,
				CONCAT(TPV.NomeProduto, " --- ", TPV.UnidadeProduto, " --- R$ ", TPV.ValorCompraProduto) AS NomeProduto,
				TPV.ValorCompraProduto
            FROM
                Tab_Produto AS TPV																	
            WHERE
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TPV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY  
				TPV.NomeProduto ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->NomeProduto;
            }
        }

        return $array;
    }
}
