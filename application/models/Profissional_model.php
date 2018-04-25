<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Profissional_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
      
    public function set_profissional($data) {

        $query = $this->db->insert('App_Profissional', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_profissional($data) {
        $query = $this->db->query('SELECT * FROM App_Profissional WHERE idApp_Profissional = ' . $data);       
        $query = $query->result_array();

        return $query[0];
    }

    public function update_profissional($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Profissional', $data, array('idApp_Profissional' => $id));
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

    public function delete_profissional2($data) {
        $query = $this->db->delete('App_Profissional', array('idApp_Profissional' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	public function delete_profissional($id) {
        $query = $this->db->delete('App_ContatoProf', array('idApp_Profissional' => $id));
		$query = $this->db->delete('App_Profissional', array('idApp_Profissional' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_profissionalORIG($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Profissional WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = 1 AND '
                . '(NomeProfissional like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'NomeProfissional like "%' . $data . '%" OR '
                
				. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Telefone1 like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY NomeProfissional ASC ');
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
	
	public function lista_profissional($data, $x) {

        $query = $this->db->query('
            SELECT
                E.idApp_Profissional,
                E.NomeProfissional,
				TA.Funcao,
                E.DataNascimento,
                E.Telefone1,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.Endereco,
                E.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                E.Email,
				CE.NomeContatoProf,
				CE.RelaPes,
				CE.Sexo
            FROM
                App_Profissional AS E
                    LEFT JOIN Tab_Municipio AS M ON M.idTab_Municipio = E.Municipio
					LEFT JOIN App_ContatoProf AS CE ON CE.idApp_Profissional = E.idApp_Profissional
					LEFT JOIN Tab_Funcao AS TA ON TA.idTab_Funcao = E.Funcao

            WHERE
                E.idSis_Usuario = ' . $_SESSION['log']['id'] . '
			ORDER BY
                E.NomeProfissional ASC
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
	
	public function select_profissional2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional				
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY F.Abrev ASC, P.NomeProfissional ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional				
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY F.Abrev ASC, P.NomeProfissional ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Profissional] = $row->NomeProfissional;
            }
        }

        return $array;
    }

	public function select_profissional($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "3"
  
			ORDER BY P.Nome ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "3"
 
			ORDER BY P.Nome ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }

}
