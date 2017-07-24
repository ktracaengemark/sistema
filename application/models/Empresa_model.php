<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
    
    public function set_empresa($data) {

        $query = $this->db->insert('App_Empresa', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_empresa($data) {
        $query = $this->db->query('SELECT * FROM App_Empresa WHERE idApp_Empresa = ' . $data);       
        $query = $query->result_array();

        return $query[0];
    }

    public function update_empresa($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Empresa', $data, array('idApp_Empresa' => $id));
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

    public function delete_empresa2($data) {
        $query = $this->db->delete('App_Empresa', array('idApp_Empresa' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	public function delete_empresa($id) {
        $query = $this->db->delete('App_Contato', array('idApp_Empresa' => $id));
		$query = $this->db->delete('App_Empresa', array('idApp_Empresa' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_empresaORIG($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Empresa WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = 1 AND '
                . '(NomeEmpresa like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'NomeEmpresa like "%' . $data . '%" OR '
                
				. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Telefone1 like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY NomeEmpresa ASC ');
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
            if ($x === FALSE) {
                return TRUE;
            } else {
                foreach ($query->result() as $row) {
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                }

                return $query;
            }
        }
    }

	public function lista_empresa($data, $x) {

        $query = $this->db->query('
            SELECT
                E.idApp_Empresa,
                E.NomeEmpresa,
				TF.TipoFornec,
				TS.StatusSN,
				TA.Atividade,
                E.DataNascimento,
                E.Telefone1,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.Endereco,
                E.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                E.Email,
				CE.NomeContato,
				CE.RelaCom,
				CE.Sexo
            FROM
                App_Empresa AS E
                    LEFT JOIN Tab_Municipio AS M ON E.Municipio = M.idTab_Municipio
					LEFT JOIN App_Contato AS CE ON E.idApp_Empresa = CE.idApp_Empresa
					LEFT JOIN Tab_TipoFornec AS TF ON TF.Abrev = E.TipoFornec
					LEFT JOIN Tab_StatusSN AS TS ON TS.Abrev = E.VendaFornec
					LEFT JOIN App_Atividade AS TA ON TA.idApp_Atividade = E.Atividade

            WHERE
                E.idSis_Usuario = ' . $_SESSION['log']['id'] . '
			ORDER BY
                E.NomeEmpresa ASC
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
            if ($x === FALSE) {
                return TRUE;
            } else {
                foreach ($query->result() as $row) {
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                }

                return $query;
            }
        }
    }	
	
	public function lista_empresa2($data, $x) {

        $query = $this->db->query('
            SELECT
                E.idApp_Empresa,
                E.NomeEmpresa,
				TF.TipoFornec,
				TS.StatusSN,
				E.VendaFornec,
				E.Atividade,
                E.DataNascimento,
                E.Telefone1,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.Endereco,
                E.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                E.Email,
				CE.NomeContato,
				CE.RelaCom,
				CE.Sexo
            FROM
                App_Empresa AS E
                    LEFT JOIN Tab_Municipio AS M ON E.Municipio = M.idTab_Municipio
					LEFT JOIN App_Contato AS CE ON E.idApp_Empresa = CE.idApp_Empresa
					LEFT JOIN Tab_TipoFornec AS TF ON TF.Abrev = E.TipoFornec
					LEFT JOIN Tab_StatusSN AS TS ON TS.Abrev = E.VendaFornec
            WHERE
                E.idSis_Usuario = ' . $_SESSION['log']['id'] . '
			ORDER BY
                E.NomeEmpresa ASC
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
            if ($x === FALSE) {
                return TRUE;
            } else {
                foreach ($query->result() as $row) {
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                }

                return $query;
            }
        }
    }
			
	public function select_empresa($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Empresa,
				CONCAT(TipoFornec, " --- ", NomeEmpresa) AS NomeEmpresa				
            FROM
                App_Empresa
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Empresa,
				CONCAT(TipoFornec, " --- ", NomeEmpresa) AS NomeEmpresa				
            FROM
                App_Empresa
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }
	
	public function select_empresa1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Empresa,
				CONCAT(TipoFornec, " --- ", NomeEmpresa) AS NomeEmpresa				
            FROM
                App_Empresa
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P" OR
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P&S"
			ORDER BY NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Empresa,
				CONCAT(TipoFornec, " --- ", NomeEmpresa) AS NomeEmpresa				
            FROM
                App_Empresa
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P" OR
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P&S"
			ORDER BY NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }
	
	public function select_empresa2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Empresa,
				CONCAT(TipoFornec, " --- ", NomeEmpresa) AS NomeEmpresa				
            FROM
                App_Empresa
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "S" OR
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P&S"
			ORDER BY NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Empresa,
				CONCAT(TipoFornec, " --- ", NomeEmpresa) AS NomeEmpresa				
            FROM
                App_Empresa
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "S" OR
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P&S"
			ORDER BY NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }
    
}
