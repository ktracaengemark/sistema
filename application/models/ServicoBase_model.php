<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Servicobase_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
       
    public function set_servicobase($data) {

        $query = $this->db->insert('Tab_ServicoBase', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }    
    
    public function get_servicobase($data) {
        $query = $this->db->query('SELECT * FROM Tab_ServicoBase WHERE idTab_ServicoBase = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }
    
    public function update_servicobase($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_ServicoBase', $data, array('idTab_ServicoBase' => $id));
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
	
	public function delete_servicobase($data) {        
		$query = $this->db->delete('Tab_ServicoBase', array('idTab_ServicoBase' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	public function lista_servicobase($x) {

        $query = $this->db->query('
            SELECT
                D.idTab_ServicoBase,
                D.ServicoBase,
				TTP.TipoProduto,
                D.ValorCompraServicoBase
            
            FROM
                Tab_ServicoBase AS D
				LEFT JOIN Tab_TipoProduto AS TTP ON TTP.Abrev = D.TipoServicoBase

            WHERE
                D.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                D.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '

            ORDER BY
                D.TipoServicoBase DESC,
				D.ServicoBase ASC
				
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
	
	public function select_servicobase($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_ServicoBase,
				CONCAT(TipoServicoBase, " -- ", ServicoBase) AS ServicoBase				
            FROM
                Tab_ServicoBase
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TipoServicoBase DESC, 
				ServicoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_ServicoBase,
				CONCAT(TipoServicoBase, " -- ", ServicoBase) AS ServicoBase				
            FROM
                Tab_ServicoBase
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TipoServicoBase DESC, 
				ServicoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_ServicoBase] = $row->ServicoBase;
            }
        }

        return $array;
    }
	
	public function select_servicobase2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_ServicoBase,
				CONCAT(TipoServicoBase, " -- ", ServicoBase) AS ServicoBase				
            FROM
                Tab_ServicoBase
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '				
			ORDER BY 
				idTab_ServicoBase DESC,
				TipoServicoBase DESC, 
				ServicoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_ServicoBase,
				CONCAT(TipoServicoBase, " -- ", ServicoBase) AS ServicoBase				
            FROM
                Tab_ServicoBase
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '				
			ORDER BY 
				idTab_ServicoBase DESC,
				TipoServicoBase DESC, 
				ServicoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_ServicoBase] = $row->ServicoBase;
            }
        }

        return $array;
    }
    
}
