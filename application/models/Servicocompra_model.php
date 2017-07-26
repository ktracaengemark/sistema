<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Servicocompra_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
       
    public function set_servicocompra($data) {

        $query = $this->db->insert('Tab_ServicoCompra', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }    
    
    public function get_servicocompra($data) {
        $query = $this->db->query('SELECT * FROM Tab_ServicoCompra WHERE idTab_ServicoCompra = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }
    
    public function update_servicocompra($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_ServicoCompra', $data, array('idTab_ServicoCompra' => $id));
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
	
	public function delete_servicocompra($data) {        
		$query = $this->db->delete('Tab_ServicoCompra', array('idTab_ServicoCompra' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	public function lista_servicocompra($x) {

        $query = $this->db->query('
            SELECT
                D.idTab_ServicoCompra,
				SB.ServicoBase,
				TTP.TipoProduto,
				E.NomeEmpresa,
				D.CodFornec,
				D.ValorCompraServico			            
            FROM
                Tab_ServicoCompra AS D
                LEFT JOIN Tab_ServicoBase AS SB ON SB.idTab_ServicoBase = D.ServicoBase    
				LEFT JOIN App_Empresa AS E ON E.idApp_Empresa = D.Empresa
				LEFT JOIN Tab_TipoProduto AS TTP ON TTP.Abrev = SB.TipoServicoBase
			WHERE
                D.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                D.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
				SB.TipoServicoBase DESC,
				E.NomeEmpresa,
				SB.ServicoBase ASC
				
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
	
	public function select_servicocompra1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_ServicoCompra,
				CONCAT(ServicoBase) AS NomeServico				
            FROM
                Tab_ServicoCompra
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
                ORDER BY TipoServico DESC, Convenio DESC, NomeServico ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_ServicoCompra,
				CONCAT(TipoServico, " --- ", Convenio, " --- ", ServicoBase, " --- ", NomeServico, " --- R$", ValorCompraServico) AS NomeServico				
            FROM
                Tab_ServicoCompra
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
                ORDER BY TipoServico DESC, Convenio DESC, NomeServico ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_ServicoCompra] = $row->NomeServico;
            }
        }

        return $array;
    }
	
	public function select_servicocompra($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				TSC.idTab_ServicoCompra,				
				CONCAT(TSB.TipoServicoBase, " --- ", TSB.ServicoBase, " --- ", TE.NomeEmpresa, " --- R$ ", TSC.ValorCompraServico) AS ServicoBase
            FROM
                Tab_ServicoCompra AS TSC
					LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSC.ServicoBase
					LEFT JOIN App_Empresa AS TE ON TE.idApp_Empresa = TSC.Empresa					
            WHERE
                TSC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSC.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				TSB.TipoServicoBase = "V"
				OR
				TSC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSC.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				TSB.TipoServicoBase = "C&V"
			ORDER BY 
				TSC.idTab_ServicoCompra DESC,
				TSB.TipoServicoBase DESC,
				TE.NomeEmpresa ASC,
				TSB.ServicoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				TSC.idTab_ServicoCompra,				
				CONCAT(TSB.TipoServicoBase, " --- ", TSB.ServicoBase, " --- ", TE.NomeEmpresa, " --- R$ ", TSC.ValorCompraServico) AS ServicoBase
            FROM
                Tab_ServicoCompra AS TSC
					LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSC.ServicoBase
					LEFT JOIN App_Empresa AS TE ON TE.idApp_Empresa = TSC.Empresa					
            WHERE
                TSC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSC.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				TSB.TipoServicoBase = "V"
				OR
				TSC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSC.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				TSB.TipoServicoBase = "C&V"
			ORDER BY 
				TSC.idTab_ServicoCompra DESC,
				TSB.TipoServicoBase DESC,
				TE.NomeEmpresa ASC,
				TSB.ServicoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_ServicoCompra] = $row->ServicoBase;
            }
        }

        return $array;
    }
	
	public function select_servicocompra2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				TSC.idTab_ServicoCompra,				
				CONCAT(TSB.TipoServicoBase, " -- ", TE.NomeEmpresa, " --- ", TSB.ServicoBase) AS ServicoBase
            FROM
                Tab_ServicoCompra AS TSC
					LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSC.ServicoBase
					LEFT JOIN App_Empresa AS TE ON TE.idApp_Empresa = TSC.Empresa
					
            WHERE
                TSC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSC.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TSB.TipoServicoBase DESC,
				TE.NomeEmpresa,
				TSB.ServicoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				TSC.idTab_ServicoCompra,				
				CONCAT(TSB.TipoServicoBase, " -- ", TE.NomeEmpresa, " --- ", TSB.ServicoBase) AS ServicoBase
            FROM
                Tab_ServicoCompra AS TSC
					LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSC.ServicoBase
					LEFT JOIN App_Empresa AS TE ON TE.idApp_Empresa = TSC.Empresa
					
            WHERE
                TSC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSC.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TSB.TipoServicoBase DESC,
				TE.NomeEmpresa,
				TSB.ServicoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_ServicoCompra] = $row->ServicoBase;
            }
        }

        return $array;
    }
    
}
