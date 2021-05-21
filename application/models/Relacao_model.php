<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Relacao_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_relacao($data) {

        $query = $this->db->insert('Tab_Relacao', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_relacao($data) {
        $query = $this->db->query('SELECT * FROM Tab_Relacao WHERE idTab_Relacao = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_relacao($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Relacao', $data, array('idTab_Relacao' => $id));
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

    public function lista_relacao($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_Relacao '
                #. 'WHERE '
                #. 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
               # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY Relacao ASC ');

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
                #    $row->idTab_Relacao = $row->idTab_Relacao;
                #    $row->Relacao = $row->Relacao;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

	public function select_relacao($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT 
                    TR.idTab_Relacao,
                    CONCAT(IFNULL(TR.Tipo,""), " - ", IFNULL(TR.Relacao,"")) AS Relacao
				FROM
                    Tab_Relacao AS TR
				ORDER BY 
					TR.Tipo DESC,
					TR.Relacao ASC
			');

        } else {
            #$query = $this->db->query('SELECT  idTab_Relacao, Relacao FROM Tab_Relacao  WHERE idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario']);
            $query = $this->db->query('
                SELECT 
                    TR.idTab_Relacao,
                    CONCAT(IFNULL(TR.Tipo,""), " - ", IFNULL(TR.Relacao,"")) AS Relacao
				FROM
                    Tab_Relacao AS TR
				ORDER BY 
					TR.Tipo DESC,
					TR.Relacao ASC
			');
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Relacao] = $row->Relacao;
				#$array[$row->Relacao] = $row->Relacao;
            }
        }

        return $array;
    }

	/*public function select_relacao($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Relacao ORDER BY Relacao ASC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Relacao ORDER BY Relacao ASC');

            $array = array();
            #$array[0] = ':: SELECIONE ::';
            foreach ($query->result() as $row) {
                #$array[$row->idTab_Municipio] = $row->NomeMunicipio;
				$array[$row->Relacao] = $row->Relacao;
            }
        }

        return $array;
    }*/

}
