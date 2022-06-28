<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Fornecedor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
    
    public function set_fornecedor($data) {

        $query = $this->db->insert('App_Fornecedor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function get_fornecedor($data) {
        $query = $this->db->query(
			'SELECT
				* 
			FROM 
				App_Fornecedor 
			WHERE 
				idApp_Fornecedor = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);       

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
    }
	/*
    public function get_fornecedor($data) {
        $query = $this->db->query('SELECT * FROM App_Fornecedor WHERE idApp_Fornecedor = ' . $data);       
        $query = $query->result_array();

        return $query[0];
    }
	*/
    public function update_fornecedor($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Fornecedor', $data, array('idApp_Fornecedor' => $id));
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

    public function delete_fornecedor2($data) {
        $query = $this->db->delete('App_Fornecedor', array('idApp_Fornecedor' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	public function delete_fornecedor($id) {
        $query = $this->db->delete('App_Contatofornec', array('idApp_Fornecedor' => $id));
		$query = $this->db->delete('App_Fornecedor', array('idApp_Fornecedor' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
	public function list_atividade($data, $x) {
		
		$data['idSis_Empresa'] = ($data['idSis_Empresa'] != 0) ? ' AND TA.idSis_Empresa = ' . $data['idSis_Empresa'] : FALSE;

        $query = $this->db->query('
			SELECT 
				TA.*
			FROM 
				App_Atividade AS TA
			WHERE 
                TA.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
                
			ORDER BY  
				TA.Atividade ASC 
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
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function lista_fornecedorORIG($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Fornecedor WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                . 'idTab_Modulo = 1 AND '
                . '(NomeFornecedor like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'NomeFornecedor like "%' . $data . '%" OR '
                
				. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Telefone1 like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY NomeFornecedor ASC ');
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

	public function lista_fornecedor($data, $x) {

        $query = $this->db->query('
            SELECT
                E.idApp_Fornecedor,
                E.NomeFornecedor,
				TF.TipoFornec,
				TS.StatusSN,
				TA.Atividade,
                E.DataNascimento,
                E.Telefone1,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.EnderecoFornecedor,
                E.BairroFornecedor,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS MunicipioFornecedor,
                E.Email,
				CE.NomeContatofornec,
				CE.RelaCom,
				CE.Sexo
            FROM
                App_Fornecedor AS E
                    LEFT JOIN Tab_Municipio AS M ON E.MunicipioFornecedor = M.idTab_Municipio
					LEFT JOIN App_Contatofornec AS CE ON E.idApp_Fornecedor = CE.idApp_Fornecedor
					LEFT JOIN Tab_TipoFornec AS TF ON TF.Abrev = E.TipoFornec
					LEFT JOIN Tab_StatusSN AS TS ON TS.Abrev = E.VendaFornec
					LEFT JOIN App_Atividade AS TA ON TA.idApp_Atividade = E.Atividade
            WHERE
                E.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				E.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
			ORDER BY
                E.NomeFornecedor ASC
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
	
	public function lista_fornecedor2($data, $x) {

        $query = $this->db->query('
            SELECT
                E.idApp_Fornecedor,
                E.NomeFornecedor,
				TF.TipoFornec,
				TS.StatusSN,
				E.VendaFornec,
				E.Atividade,
                E.DataNascimento,
                E.Telefone1,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.EnderecoFornecedor,
                E.BairroFornecedor,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS MunicipioFornecedor,
                E.Email,
				CE.NomeContatofornec,
				CE.RelaCom,
				CE.Sexo
            FROM
                App_Fornecedor AS E
                    LEFT JOIN Tab_Municipio AS M ON E.MunicipioFornecedor = M.idTab_Municipio
					LEFT JOIN App_Contatofornec AS CE ON E.idApp_Fornecedor = CE.idApp_Fornecedor
					LEFT JOIN Tab_TipoFornec AS TF ON TF.Abrev = E.TipoFornec
					LEFT JOIN Tab_StatusSN AS TS ON TS.Abrev = E.VendaFornec
            WHERE
                E.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY
                E.NomeFornecedor ASC
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
			
	public function select_fornecedor($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Fornecedor,
				CONCAT(NomeFornecedor) AS NomeFornecedor				
            FROM
                App_Fornecedor
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' 
			ORDER BY NomeFornecedor ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Fornecedor,
				CONCAT(NomeFornecedor) AS NomeFornecedor				
            FROM
                App_Fornecedor
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY NomeFornecedor ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Fornecedor] = $row->NomeFornecedor;
            }
        }

        return $array;
    }
	
	public function select_fornecedor1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Fornecedor,
				CONCAT(TipoFornec, " --- ", NomeFornecedor) AS NomeFornecedor				
            FROM
                App_Fornecedor
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P" OR
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P&S"
			ORDER BY NomeFornecedor ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Fornecedor,
				CONCAT(TipoFornec, " --- ", NomeFornecedor) AS NomeFornecedor				
            FROM
                App_Fornecedor
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P" OR
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P&S"
			ORDER BY NomeFornecedor ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Fornecedor] = $row->NomeFornecedor;
            }
        }

        return $array;
    }
	
	public function select_fornecedor2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Fornecedor,
				CONCAT(TipoFornec, " --- ", NomeFornecedor) AS NomeFornecedor				
            FROM
                App_Fornecedor
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "S" OR
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P&S"
			ORDER BY NomeFornecedor ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Fornecedor,
				CONCAT(TipoFornec, " --- ", NomeFornecedor) AS NomeFornecedor				
            FROM
                App_Fornecedor
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "S" OR
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				VendaFornec = "S" AND
				TipoFornec = "P&S"
			ORDER BY NomeFornecedor ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Fornecedor] = $row->NomeFornecedor;
            }
        }

        return $array;
    }
    
}
