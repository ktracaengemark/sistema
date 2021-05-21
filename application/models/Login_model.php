<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');

    }

    public function check_dados_celular($senha, $celular, $retorna = FALSE) {

        $query = $this->db->query('SELECT * FROM Sis_Usuario WHERE '
                . '(CelularUsuario = "' . $celular . '" AND '
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
	
	public function check_dados_empresa($empresa, $celular, $retorna = FALSE) {

        $query = $this->db->query('SELECT * FROM Sis_Usuario WHERE '
                . '(CelularUsuario = "' . $celular . '" AND '
                . 'idSis_Empresa = "' . $empresa . '")'

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
	
	public function check_documentos_log($empresa, $retorna = FALSE) {

        $query2 = $this->db->query('SELECT * FROM App_Documentos WHERE '
                . 'idSis_Empresa = "' . $empresa . '"'
        );
        #$query2 = $this->db->get_where('Sis_Usuario', $data);
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query2);
          echo "</pre>";
          exit();
         */
        if ($query2->num_rows() === 0) {
            return FALSE;
        }
        else {
            if ($retorna === FALSE) {
                return TRUE;
            }
            else {
                $query2 = $query2->result_array();
                return $query2[0];
            }
        }

    }
	
	public function dados_empresa_log($empresa) {

        $query3 = $this->db->query('SELECT * FROM Sis_Empresa WHERE '
                . 'idSis_Empresa = "' . $empresa . '"'
        );
        #$query3 = $this->db->get_where('Sis_Usuario', $data);
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query3);
          echo "</pre>";
          exit();
         */

		$query3 = $query3->result_array();
		return $query3[0];

    }	
	
	public function check_dados_senha($empresa, $senha, $retorna = FALSE) {

        $query = $this->db->query('SELECT * FROM Sis_Usuario WHERE '
                . '(Senha = "' . $senha . '" AND '
                . 'idSis_Empresa = "' . $empresa . '")'

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

        $query = $this->db->query('SELECT * FROM Sis_Usuario WHERE '
                . '(CelularUsuario = "' . $celular . '" ) '
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

        #$query = $this->db->get_where('Sis_Usuario', $data);
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */

    }
	
	public function check_empresa($data) {

        $query = $this->db->query('SELECT * FROM Sis_Empresa WHERE idSis_Empresa = "' . $data . '"');
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

        #$query = $this->db->get_where('Sis_Usuario', $data);
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
            'idSis_Usuario' => $celular,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
            'SessionId' => session_id(),
        );

        $query = $this->db->insert('Sis_AuditoriaAcesso', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            return TRUE;
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

    public function ativa_usuario($id, $data) {

        $query = $this->db->query('SELECT * FROM Sis_Usuario WHERE Codigo = "' . $id . '"');
        if ($query->num_rows() === 0) {
            return FALSE;
        }
        else {
            $query = $this->db->update('Sis_Usuario', $data, array('Codigo' => $id));
			
			echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();

            if ($this->db->affected_rows() === 0)
                return FALSE;
            else
                return TRUE;
        }

    }

    public function get_data_by_usuario($data) {

        $query = $this->db->query('SELECT idSis_Usuario, Usuario, Email FROM Sis_Usuario WHERE '
                . 'Usuario = "' . $data . '" OR Email = "' . $data . '"');
        $query = $query->result_array();
        return $query[0];

    }

    /*
    public function get_data_by_codigo($data) {

        $query = $this->db->query('SELECT idSis_Usuario, Usuario, Email FROM Sis_Usuario WHERE Codigo = "' . $data . '"');
        $query = $query->result_array();
        #return $query[0]['idSis_Usuario'];
        return $query[0];

    }
    */

    public function get_data_by_codigo($data) {

        $query = $this->db->query('SELECT idSis_Usuario, Usuario, Email FROM Sis_Usuario WHERE Codigo = "' . $data . '"');
        if ($query->num_rows() === 0) {
            return FALSE;
        }
        else {

            $query = $query->result_array();
            return $query[0];
        }

    }

    public function troca_senha($id, $data) {

        $query = $this->db->update('Sis_Usuario', $data, array('idSis_Usuario' => $id));

        if ($this->db->affected_rows() === 0)
            return TRUE;
        else
            return FALSE;

    }

    public function get_agenda_padrao($data) {

        $query = $this->db->query('SELECT idApp_Agenda FROM App_Agenda WHERE idSis_Usuario = ' . $data . ' ORDER BY idApp_Agenda ASC LIMIT 1');
        $query = $query->result_array();
        #return $query[0]['idSis_Usuario'];
        return $query[0]['idApp_Agenda'];

    }
	
    public function get_empresa0($data) {

        $query = $this->db->query('
			SELECT*
				 
			FROM 
				Sis_Usuario AS U 
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = U.idSis_Empresa 
			WHERE 
				U.idSis_Usuario = ' . $data . ' 
			ORDER BY 
				E.NivelEmpresa ASC 
			');
        $query = $query->result_array();
        return $query[0]['idSis_Empresa'];
        #return $query[0]['NivelEmpresa'];

    }
    
	public function get_empresa($data) {

        $query = $this->db->query('
			SELECT 
				U.idSis_Empresa,
				E.NivelEmpresa 
			FROM 
				Sis_Usuario AS U 
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = U.idSis_Empresa 
			WHERE 
				U.idSis_Usuario = ' . $data . ' 
			ORDER BY 
				E.NivelEmpresa ASC 
			');
        $query = $query->result_array();
        #return $query[0]['idSis_Usuario'];
        return $query[0]['NivelEmpresa'];

    }
	
    public function get_empresa1($data) {

        $query = $this->db->query('
			SELECT 
				U.idSis_Empresa,
				E.TabelasEmpresa 
			FROM 
				Sis_Usuario AS U 
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = U.idSis_Empresa 
			WHERE 
				U.idSis_Usuario = ' . $data . ' 
			ORDER BY 
				E.TabelasEmpresa ASC 
			');
        $query = $query->result_array();
        #return $query[0]['idSis_Usuario'];
        return $query[0]['TabelasEmpresa'];

    }	
	
    public function get_empresa2($data) {

        $query = $this->db->query('
			SELECT 
				U.idSis_Empresa,
				E.DataDeValidade 
			FROM 
				Sis_Usuario AS U 
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = U.idSis_Empresa 
			WHERE 
				U.idSis_Usuario = ' . $data . ' 
			ORDER BY 
				E.DataDeValidade ASC 
			');
        $query = $query->result_array();
        #return $query[0]['idSis_Usuario'];
        return $query[0]['DataDeValidade'];

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
				idSis_Empresa != "1"
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
				idSis_Empresa != "1"
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

	public function select_empresa1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Empresa,
				NomeEmpresa				
            FROM
                Sis_Empresa
			WHERE
				idSis_Empresa = "5"
			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Empresa,
				NomeEmpresa			
            FROM
                Sis_Empresa					
			WHERE
				idSis_Empresa = "5"
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

	public function select_empresa2($data = FALSE) {

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

	public function select_empresa3($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Empresa,
				CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa				
            FROM
                Sis_Empresa					
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Empresa,
				CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa					
            FROM
                Sis_Empresa					
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
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

	public function select_empresa4($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
					idSis_Empresa,
					CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa				
				FROM
					Sis_Empresa					
				WHERE
					idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . '
				ORDER BY 
					NomeEmpresa ASC'
			);
					
        } else {
            $query = $this->db->query(
                'SELECT                
					idSis_Empresa,
					CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa					
				FROM
					Sis_Empresa					
				WHERE
					idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . ' 
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
	
	public function select_empresa5($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
					idSis_Empresa,
					CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa				
				FROM
					Sis_Empresa					
				WHERE
					idSis_Empresa = ' . $_SESSION['Acesso']['idSis_Empresa'] . '
				ORDER BY 
					NomeEmpresa ASC'
			);
					
        } else {
            $query = $this->db->query(
                'SELECT                
					idSis_Empresa,
					CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa					
				FROM
					Sis_Empresa					
				WHERE
					idSis_Empresa = ' . $_SESSION['Acesso']['idSis_Empresa'] . '
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
	
}
