<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Produtobase_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
   
    public function set_produtobase($data) {

        $query = $this->db->insert('Tab_ProdutoBase', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }   
    
    public function get_produtobase($data) {
        $query = $this->db->query('SELECT * FROM Tab_ProdutoBase WHERE idTab_ProdutoBase = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }    
    
    public function update_produtobase($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_ProdutoBase', $data, array('idTab_ProdutoBase' => $id));
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

	public function delete_produtobase($data) {        
		$query = $this->db->delete('Tab_ProdutoBase', array('idTab_ProdutoBase' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function lista_produtobase1($x) {

        $query = $this->db->query(
                'SELECT '
                    . 'idTab_ProdutoBase, '
                    . 'ProdutoBase, '
                    . 'TipoProdutoBase, '
                    . 'UnidadeProdutoBase, '
                    . 'ValorCompraProdutoBase '
                    . 'FROM '
                    . 'Tab_ProdutoBase '
                    . 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' ' 
					. 'ORDER BY TipoProdutoBase ASC, ProdutoBase ASC ');
        
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

	public function lista_produtobase($x) {

        $query = $this->db->query('
            SELECT
                D.idTab_ProdutoBase,
                D.ProdutoBase,
				TTP.TipoProduto,
				D.UnidadeProdutoBase, 
                D.ValorCompraProdutoBase          
            FROM
                Tab_ProdutoBase AS D
				LEFT JOIN Tab_TipoProduto AS TTP ON TTP.Abrev = D.TipoProdutoBase

            WHERE
                D.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                D.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '

            ORDER BY
				D.TipoProdutoBase DESC,
				D.ProdutoBase ASC
				
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
	
	public function select_produtobase($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_ProdutoBase,				
				CONCAT(ProdutoBase, " --- ", UnidadeProdutoBase) AS ProdutoBase				
            FROM
                Tab_ProdutoBase
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY TipoProdutoBase DESC, ProdutoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_ProdutoBase,
				CONCAT(ProdutoBase, " --- ", UnidadeProdutoBase) AS ProdutoBase				
            FROM
                Tab_ProdutoBase
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY TipoProdutoBase DESC, ProdutoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_ProdutoBase] = $row->ProdutoBase;
            }
        }

        return $array;
    }
	
	public function select_produtobase2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_ProdutoBase,				
				CONCAT(ProdutoBase, " --- ", UnidadeProdutoBase) AS ProdutoBase				
            FROM
                Tab_ProdutoBase
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
			ORDER BY TipoProdutoBase DESC, ProdutoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_ProdutoBase,
				CONCAT(ProdutoBase, " --- ", UnidadeProdutoBase) AS ProdutoBase				
            FROM
                Tab_ProdutoBase
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
			ORDER BY TipoProdutoBase DESC, ProdutoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_ProdutoBase] = $row->ProdutoBase;
            }
        }

        return $array;
    }
}
