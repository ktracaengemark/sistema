<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    
    ##############
    #RESPONSÁVEL
    ##############    
    
    public function set_pessoa($data) {

        $query = $this->db->insert('App_Pessoa', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_pessoa($data) {
        $query = $this->db->query('SELECT * FROM App_Pessoa WHERE idApp_Pessoa = ' . $data);
        /*
          $query = $this->db->query(
          . 'SELECT '
          . 'P.NomePaciente, '
          . 'P.DataNascimento, '
          . 'P.Telefone, '
          . 'S.Sexo, '
          . 'P.Endereco, '
          . 'P.Bairro, '
          . 'M.NomeMunicipio AS Municipio, '
          . 'M.Uf, '
          . 'P.Obs, '
          . 'P.Email '
          . 'FROM '
          . 'App_Pessoa AS P, '
          . 'Tab_Sexo AS S, '
          . 'Tab_Municipio AS M '
          . 'WHERE '
          . 'P.idApp_Pessoa = ' . $data . ' AND '
          . 'P.Sexo = S.idTab_Sexo AND '
          . 'P.Municipio = M.idTab_Municipio'
          );
         * 
         */
        $query = $query->result_array();

        return $query[0];
    }

    public function update_pessoa($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Pessoa', $data, array('idApp_Pessoa' => $id));
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

    public function delete_pessoa($data) {
        $query = $this->db->delete('App_Pessoa', array('idApp_Pessoa' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_pessoa($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Pessoa WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = 1 AND '
                . '(NomePessoa like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'NomePessoa like "%' . $data . '%" OR '
                . 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Telefone1 like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY NomePessoa ASC ');
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
    
	public function select_pessoa($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idApp_Pessoa, '
                    . 'NomePessoa '
                    . 'FROM '
                    . 'App_Pessoa '
                    . 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] );
        } else {
            $query = $this->db->query('SELECT idApp_Pessoa, NomePessoa FROM App_Pessoa WHERE idSis_Usuario = ' . $_SESSION['log']['id']);
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Pessoa] = $row->NomePessoa;
            }
        }

        return $array;
    }
}
