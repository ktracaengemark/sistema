<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Loginempresa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');

    }

    public function check_dados_celular($senha, $celular, $retorna = FALSE) {

        $query = $this->db->query('SELECT * FROM Sis_Empresa WHERE '
                . '(CelularAdmin = "' . $celular . '" AND '
                . 'Senha = "' . $senha . '")'

        );
        #$query = $this->db->get_where('Sis_Empresa', $data);
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */
        if ($query->num_rows() === 0) {
            return FALSE;
        }
        else {
            if ($retorna === FALSE) {
                return TRUE;
            }
            else {
                $query = $query->result_array();
                return $query[0];
            }
        }

    }
	
	public function check_dados_empresa($empresa, $celular, $senha, $retorna = FALSE) {

        $query = $this->db->query('SELECT * FROM Sis_Empresa WHERE '
                . '(idSis_Empresa = "' . $empresa . '" AND '
                . 'CelularAdmin = "' . $celular . '" AND '
                . 'Senha = "' . $senha . '")'
        );
        #$query = $this->db->get_where('Sis_Usuario', $data);
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */
        if ($query->num_rows() === 0) {
            return FALSE;
        }
        else {
            if ($retorna === FALSE) {
                return TRUE;
            }
            else {
                $query = $query->result_array();
                return $query[0];
            }
        }

    }
	
    public function check_celular($celular) {

        $query = $this->db->query('SELECT * FROM Sis_Empresa WHERE '
                . '(CelularAdmin = "' . $celular . '" ) '
        );
        if ($query->num_rows() === 0) {
            return 1;
        }
        else {
            $query = $query->result_array();

            if ($query[0]['Inativo'] == 1)
                return 2;
            else
                return FALSE;
        }

        #$query = $this->db->get_where('Sis_Empresa', $data);
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */

    }
	
	public function check_nomeempresa($data) {

        $query = $this->db->query('SELECT * FROM Sis_Empresa WHERE NomeEmpresa = "' . $data . '"');
        if ($query->num_rows() === 0) {
            return 1;
        }
        else {
            $query = $query->result_array();

            if ($query[0]['Inativo'] == 1)
                return 2;
            else
                return FALSE;
        }

        #$query = $this->db->get_where('Sis_Empresa', $data);
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */

    }

    public function set_acesso($celular, $operacao) {

        $data = array(
            'Data' => date('Y-m-d H:i:s'),
            'Operacao' => $operacao,
            'idSis_Empresa' => $celular,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
            'SessionId' => session_id(),
        );

        $query = $this->db->insert('Sis_AuditoriaAcessoEmpresa', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            return TRUE;
        }

    }

    public function set_empresa($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('Sis_Empresa', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }

    public function set_atendimento($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('App_Atendimento', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }	
	
    public function set_funcao($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('Tab_Funcao', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }
	
    public function set_usuario($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('Sis_Usuario', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }

    public function set_documentos($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('App_Documentos', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }

    public function set_slide($data) {

        $query = $this->db->insert('App_Slides', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }
	
    public function set_agenda($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('App_Agenda', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }
	
    public function set_cliente($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('App_Cliente', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }

    public function set_fornecedor($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('App_Fornecedor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }

    public function set_catprod($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('Tab_Catprod', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }
	
    public function set_produto($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('Tab_Produto', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }
	
    public function set_produtos($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('Tab_Produtos', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }
	
    public function set_promocao($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('Tab_Promocao', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }	

    public function set_valor($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('Tab_Valor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }	
	
    public function ativa_usuario($id, $data) {

        $query = $this->db->query('SELECT * FROM Sis_Empresa WHERE Codigo = "' . $id . '"');
        if ($query->num_rows() === 0) {
            return FALSE;
        }
        else {
            $query = $this->db->update('Sis_Empresa', $data, array('Codigo' => $id));

            if ($this->db->affected_rows() === 0)
                return FALSE;
            else
                return TRUE;
        }

    }

    public function get_data_by_usuario($data) {

        $query = $this->db->query('SELECT idSis_Empresa, UsuarioEmpresa, Email FROM Sis_Empresa WHERE '
                . 'UsuarioEmpresa = "' . $data . '" OR Email = "' . $data . '"');
        $query = $query->result_array();
        return $query[0];

    }

    public function get_data_by_codigo($data) {

        $query = $this->db->query('SELECT idSis_Empresa, UsuarioEmpresa, Email FROM Sis_Empresa WHERE Codigo = "' . $data . '"');
        $query = $query->result_array();
        #return $query[0]['idSis_Empresa'];
        return $query[0];

    }
	
    public function troca_senha($id, $data) {

        $query = $this->db->update('Sis_Empresa', $data, array('idSis_Empresa' => $id));

        if ($this->db->affected_rows() === 0)
            return TRUE;
        else
            return FALSE;

    }
	
    public function get_associado($data) {
        $query = $this->db->query('SELECT * FROM Sis_Associado WHERE idSis_Empresa = "5" AND CelularAssociado = ' . $data);
        $count = $query->num_rows();
		$query = $query->result_array();
		
		if(isset($count)){
			if($count == 0){
				return FALSE;
			}else{
				return $query[0];
			}
		}else{
			return FALSE;
		}

    }

	public function select_empresa($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Empresa,
				CONCAT(NomeEmpresa, " ", "(", idSis_Empresa, ")") AS NomeEmpresa				
            FROM
                Sis_Empresa					
			WHERE
				
				idSis_Empresa != "1" AND 
				idSis_Empresa != "5"
			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Empresa,
				CONCAT(NomeEmpresa, " ", "(", idSis_Empresa, ")") AS NomeEmpresa				
            FROM
                Sis_Empresa					
			WHERE
				idSis_Empresa != "1" AND 
				idSis_Empresa != "5"
			ORDER BY 
				NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }	
	/*
    public function get_agenda_padrao($data) {

        $query = $this->db->query('SELECT idApp_Agenda FROM App_Agenda WHERE idSis_Empresa = ' . $data . ' ORDER BY idApp_Agenda ASC LIMIT 1');
        $query = $query->result_array();
        #return $query[0]['idSis_Empresa'];
        return $query[0]['idApp_Agenda'];

    }
*/
}
