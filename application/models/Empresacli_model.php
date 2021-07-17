<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresacli_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }


    ##############
    #RESPONSÁVEL
    ##############

    public function set_empresa($data) {

        $query = $this->db->insert('Sis_Empresa', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_empresa($data) {
        $query = $this->db->query('SELECT * FROM Sis_Empresa WHERE idSis_Empresa = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function update_empresa($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Sis_Empresa', $data, array('idSis_Empresa' => $id));
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

	public function delete_empresa($data) {

        $query = $this->db->query('SELECT idApp_OrcaTrata FROM App_OrcaTrata WHERE idSis_Empresa = ' . $data);
        $query = $query->result_array();

        /*
        echo $this->db->last_query();
        #$query = $query->result();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";


        foreach ($query as $key) {
            /*
            echo $key['idApp_OrcaTrata'];
            echo '<br />';
            #echo $value;
            echo '<br />';
        }

        exit();

        */

        $this->db->delete('App_Consulta', array('idSis_Empresa' => $data));
        $this->db->delete('App_ContatoEmpresa', array('idSis_Empresa' => $data));

        foreach ($query as $key) {
            $query = $this->db->delete('App_ProdutoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ServicoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ParcelasRecebiveis', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_Procedimento', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
        }

        $this->db->delete('App_OrcaTrata', array('idSis_Empresa' => $data));
        $this->db->delete('Sis_Empresa', array('idSis_Empresa' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_empresa($data, $x) {

        $query = $this->db->query('
			SELECT 
				E.idSis_Empresa,
				E.NomeEmpresa,
				E.Atuacao,
				E.Arquivo,
				E.DataCriacao,
				E.Site,
				CE.CategoriaEmpresa
			FROM 
				Sis_Empresa AS E
					LEFT JOIN Tab_CategoriaEmpresa AS CE ON CE.idTab_CategoriaEmpresa = E.CategoriaEmpresa
			WHERE 
                E.idSis_Empresa != "1" AND 
				E.idSis_Empresa != "5" AND 
                (E.NomeEmpresa like "%' . $data . '%" OR 
				E.Atuacao like "%' . $data . '%" OR 
				CE.CategoriaEmpresa like "%' . $data . '%")
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
                    $row->DataCriacao = $this->basico->mascara_data($row->DataCriacao, 'barras');
                }

                return $query;
            }
        }
    }

    public function lista_contatoempresa($id, $bool) {

        $query = $this->db->query(
            'SELECT * '
                . 'FROM Sis_Usuario WHERE '
                . 'idSis_Empresa = ' . $id . ' '
            . 'ORDER BY Nome ASC ');
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
            if ($bool === FALSE) {
                return TRUE;
            } else {
                foreach ($query->result() as $row) {
                    $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                    $row->Sexo = $this->Basico_model->get_sexo($row->Sexo);

                }

                return $query;
            }
        }
    }

}
