<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Produtocompra_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
   
    public function set_produtocompra($data) {

        $query = $this->db->insert('Tab_ProdutoCompra', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }   
    
    public function get_produtocompra($data) {
        $query = $this->db->query('SELECT * FROM Tab_ProdutoCompra WHERE idTab_ProdutoCompra = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }    
    
    public function update_produtocompra($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_ProdutoCompra', $data, array('idTab_ProdutoCompra' => $id));
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

	public function delete_produtocompra($data) {        
		$query = $this->db->delete('Tab_ProdutoCompra', array('idTab_ProdutoCompra' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function lista_produtocompra1($x) {

        $query = $this->db->query(
                'SELECT '
                    . 'idTab_ProdutoCompra, '
					. 'ProdutoBase, '
                    . 'ValorCompraProduto '
                    . 'FROM '
                    . 'Tab_ProdutoCompra '
                    . 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' ' 
					. 'ORDER BY Produtobase ASC ');
        
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

	public function lista_produtocompra($x) {

        $query = $this->db->query('
            SELECT
                D.idTab_ProdutoCompra,
				PB.ProdutoBase,
				PB.UnidadeProdutoBase,
				E.NomeEmpresa,
				D.CodFornec,
				D.ValorCompraProduto          
            FROM
                Tab_ProdutoCompra AS D
				LEFT JOIN Tab_ProdutoBase AS PB ON PB.idTab_ProdutoBase = D.ProdutoBase
				LEFT JOIN App_Empresa AS E ON E.idApp_Empresa = D.Empresa				
            WHERE
                D.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                D.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' 
            ORDER BY
				PB.ProdutoBase ASC,
				E.NomeEmpresa ASC												
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
	   		
	public function select_produtocompra($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				TPC.idTab_ProdutoCompra,				
				CONCAT(TPB.ProdutoBase, " --- ", TPB.UnidadeProdutoBase, " --- ", TE.NomeEmpresa, " --- R$ ", TPC.ValorCompraProduto) AS ProdutoBase
            FROM
                Tab_ProdutoCompra AS TPC
					LEFT JOIN Tab_ProdutoBase AS TPB ON TPB.idTab_ProdutoBase = TPC.ProdutoBase
					LEFT JOIN App_Empresa AS TE ON TE.idApp_Empresa = TPC.Empresa
					
            WHERE
                TPC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TPC.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TPB.ProdutoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				TPC.idTab_ProdutoCompra,				
				CONCAT(TPB.ProdutoBase, " --- ", TPB.UnidadeProdutoBase, " --- ", TE.NomeEmpresa, " --- R$ ", TPC.ValorCompraProduto) AS ProdutoBase
            FROM
                Tab_ProdutoCompra AS TPC
					LEFT JOIN Tab_ProdutoBase AS TPB ON TPB.idTab_ProdutoBase = TPC.ProdutoBase
					LEFT JOIN App_Empresa AS TE ON TE.idApp_Empresa = TPC.Empresa
					
            WHERE
                TPC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TPC.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TPB.ProdutoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_ProdutoCompra] = $row->ProdutoBase;
            }
        }

        return $array;
    }
	
	public function select_produtocompra2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				TPC.idTab_ProdutoCompra,				
				CONCAT(TE.NomeEmpresa, "---", TPB.ProdutoBase, " --- ", TPB.UnidadeProdutoBase) AS ProdutoBase
            FROM
                Tab_ProdutoCompra AS TPC
					LEFT JOIN Tab_ProdutoBase AS TPB ON TPB.idTab_ProdutoBase = TPC.ProdutoBase
					LEFT JOIN App_Empresa AS TE ON TE.idApp_Empresa = TPC.Empresa
					
            WHERE
                TPC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TPC.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TE.NomeEmpresa,
				TPB.ProdutoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				TPC.idTab_ProdutoCompra,				
				CONCAT(TE.NomeEmpresa, "---", TPB.ProdutoBase, " --- ", TPB.UnidadeProdutoBase) AS ProdutoBase
            FROM
                Tab_ProdutoCompra AS TPC
					LEFT JOIN Tab_ProdutoBase AS TPB ON TPB.idTab_ProdutoBase = TPC.ProdutoBase
					LEFT JOIN App_Empresa AS TE ON TE.idApp_Empresa = TPC.Empresa
					
            WHERE
                TPC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TPC.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TE.NomeEmpresa,
				TPB.ProdutoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_ProdutoCompra] = $row->ProdutoBase;
            }
        }

        return $array;
    }
}
