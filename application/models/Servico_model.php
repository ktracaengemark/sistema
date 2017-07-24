<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Servico_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
       
    public function set_servico($data) {

        $query = $this->db->insert('Tab_Servico', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }    
    
    public function get_servico($data) {
        $query = $this->db->query('SELECT * FROM Tab_Servico WHERE idTab_Servico = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }
    
    public function update_servico($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Servico', $data, array('idTab_Servico' => $id));
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
	
	public function delete_servico($data) {        
		$query = $this->db->delete('Tab_Servico', array('idTab_Servico' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	public function lista_servico1($x) {

        $query = $this->db->query('
            SELECT
                D.idTab_Servico,
                CO.Convenio,
				SB.ServicoBase,
				E.NomeEmpresa,
				D.ValorCompraServico,
				D.ValorVendaServico				            
            FROM
                Tab_Servico AS D
                LEFT JOIN Tab_ServicoBase AS SB ON SB.idTab_ServicoBase = D.ServicoBase    
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = D.Convenio
				LEFT JOIN App_Empresa AS E ON E.idApp_Empresa = D.Empresa            
			WHERE
                D.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                D.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                SB.ServicoBase ASC,
				CO.Convenio DESC								
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

	public function lista_servico($x) {

        $query = $this->db->query('
            SELECT
                TSV.idTab_Servico,
				TPB.ServicoBase,
				TCO.Convenio,
				TEM.NomeEmpresa,
				TSC.ValorCompraServico,
				TSV.ValorVendaServico           
            FROM
                Tab_Servico AS TSV				
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TSV.Convenio				
				LEFT JOIN Tab_ServicoCompra AS TSC ON TSC.idTab_ServicoCompra = TSV.ServicoBase				
				LEFT JOIN App_Empresa AS TEM ON TEM.idApp_Empresa = TSC.Empresa				
				LEFT JOIN Tab_ServicoBase AS TPB ON TPB.idTab_ServicoBase= TSC.ServicoBase				
            WHERE
                TSV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' 
            ORDER BY
				TCO.Convenio ASC,
				TPB.ServicoBase,
				TEM.NomeEmpresa								
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

	public function lista_servico2($x) {

        $query = $this->db->query('
            SELECT
                D.idTab_Servico,
				TPB.ServicoBase,
				TC.Convenio,
				TE.NomeEmpresa,
				TPC.ValorCompraServico,
				D.ValorVendaServico           
            FROM
                Tab_Servico AS D				
				LEFT JOIN Tab_Convenio AS TC ON TC.idTab_Convenio = D.Convenio				
				LEFT JOIN Tab_ServicoCompra AS TPC ON TPC.idTab_ServicoCompra = D.ServicoBase				
				LEFT JOIN App_Empresa AS TE ON TE.idApp_Empresa = TPC.Empresa				
				LEFT JOIN Tab_ServicoBase AS TPB ON TPB.idTab_ServicoBase= TPC.ServicoBase				
            WHERE
                D.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                D.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' 
            ORDER BY
				TE.NomeEmpresa ASC											
        ');

        /*
		
		LEFT JOIN Tab_ServicoBase AS PB ON PB.idTab_ServicoBase = TPC.ServicoBase
		
		
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
	
	public function select_servico($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Servico,
				CONCAT(ServicoBase) AS NomeServico				
            FROM
                Tab_Servico
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
                ORDER BY TipoServico DESC, Convenio DESC, NomeServico ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Servico,
				CONCAT(TipoServico, " --- ", Convenio, " --- ", ServicoBase, " --- ", NomeServico, " --- R$", ValorCompraServico) AS NomeServico				
            FROM
                Tab_Servico
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
                ORDER BY TipoServico DESC, Convenio DESC, NomeServico ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->NomeServico;
            }
        }

        return $array;
    }
	
	
    
}
