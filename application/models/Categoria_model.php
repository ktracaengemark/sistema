<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_categoria($data) {

        $query = $this->db->insert('Tab_Categoria', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_categoria($data) {

		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
		}else{
			if($_SESSION['Usuario']['Nivel'] == 2){
				$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
			}else{
				$permissao = 'C.NivelCategoria = "1" AND';
			}
		}
		
		$query = $this->db->query(
			'SELECT
				C.* 
			FROM 
				Tab_Categoria AS C
			WHERE 
                ' . $permissao . '
				C.idTab_Categoria = ' . $data . ' AND
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        /*
		$query = $query->result_array();
        return $query[0];
		*/
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }

    }

    public function update_categoria($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Categoria', $data, array('idTab_Categoria' => $id));
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
	
	public function delete_categoria($data) {        
		$query = $this->db->delete('Tab_Categoria', array('idTab_Categoria' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_categoria($x) {
		//$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
		}else{
			if($_SESSION['Usuario']['Nivel'] == 2){
				$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
			}else{
				$permissao = 'C.NivelCategoria = "1" AND';
			}
		}

		$query = $this->db->query('
            SELECT
                C.idTab_Categoria,
                C.Categoria
            FROM
                Tab_Categoria AS C
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = C.idSis_Usuario
            WHERE
				' . $permissao . '
				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                C.Categoria ASC 
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

    public function select_categoria3($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Categoria, '
                    . 'Categoria, '
					. 'Abrev, '
                    . 'FROM '
                    . 'Tab_Categoria '
					. 'ORDER BY idTab_Categoria ASC ');
					#. 'WHERE '
                   # . 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                   # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] ) . ' '
					
        } else {
            #$query = $this->db->query('SELECT idTab_Categoria, Categoria, Abrev FROM Tab_Categoria WHERE idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario']);
			$query = $this->db->query('SELECT idTab_Categoria FROM Tab_Categoria ORDER BY Categoria ASC ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Categoria] = $row->Categoria;
            }
        }

        return $array;
    }
	
	public function select_categoria1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Categoria,
				Categoria,
				Abrev
            FROM
                Tab_Categoria
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY Categoria ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Categoria,
				Categoria,
				Abrev
            FROM
                Tab_Categoria
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY Categoria ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Categoria] = $row->Categoria;
            }
        }

        return $array;
    }
	
	public function select_categoria($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Categoria,
				CONCAT(Categoria, " - " , idTab_Categoria) AS Categoria,
				Abrev
            FROM
                Tab_Categoria
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Categoria ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Categoria,
				CONCAT(Categoria, " - " , idTab_Categoria) AS Categoria,
				Abrev
            FROM
                Tab_Categoria
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Categoria ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Categoria] = $row->Categoria;
            }
        }

        return $array;
    }

}
