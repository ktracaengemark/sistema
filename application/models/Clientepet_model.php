<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientepet_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_clientepet($data) {

        $query = $this->db->insert('App_ClientePet', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_arquivo($data) {

        $query = $this->db->insert('Sis_Arquivo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }

    public function get_clientepet($data) {
        $query = $this->db->query('SELECT * FROM App_ClientePet WHERE idApp_ClientePet = ' . $data);
        /*
          $query = $this->db->query(
          . 'SELECT '
          . 'P.NomePaciente, '
          . 'P.DataNascimentoPet, '
          . 'P.Telefone, '
          . 'S.SexoPet, '
          . 'P.Endereco, '
          . 'P.Bairro, '
          . 'M.NomeMunicipio AS Municipio, '
          . 'M.Uf, '
          . 'P.ObsPet, '
          . 'P.Email '
          . 'FROM '
          . 'App_ClientePet AS P, '
          . 'Tab_SexoPet AS S, '
          . 'Tab_Municipio AS M '
          . 'WHERE '
          . 'P.idApp_ClientePet = ' . $data . ' AND '
          . 'P.SexoPet = S.idTab_SexoPet AND '
          . 'P.Municipio = M.idTab_Municipio'
          );
         *
         */
        $query = $query->result_array();

        return $query[0];
    }

    public function update_clientepet($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_ClientePet', $data, array('idApp_ClientePet' => $id));
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

    public function delete_clientepet($data) {
        $query = $this->db->delete('App_ClientePet', array('idApp_ClientePet' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_clientepet($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_ClientePet WHERE '
                . 'idApp_Cliente = ' . $_SESSION['Cliente']['idApp_Cliente'] . ' '
                . 'ORDER BY NomeClientePet ASC ');
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
                    //$row->Idade = $this->basico->calcula_idade($row->DataNascimentoPet);
                    //$row->DataNascimentoPet = $this->basico->mascara_data($row->DataNascimentoPet, 'barras');
                    //$row->SexoPet = $this->Basico_model->get_sexo($row->SexoPet);
					//$row->RelaCom = $this->Basico_model->get_relacom($row->RelaCom);
					//$row->Relacao = $this->Basico_model->get_relacao($row->Relacao);
                }

                return $query;
            }
        }
    }
    
	public function list_racapet($x) {
		
        $query = $this->db->query('
			SELECT 
				TA.*,
				TOP.idApp_ClientePet
			FROM 
				Tab_RacaPet AS TA
					LEFT JOIN App_ClientePet AS TOP ON TOP.RacaPet = TA.idTab_RacaPet
			WHERE 
                TA.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			GROUP BY
				TA.idTab_RacaPet
			ORDER BY  
				TA.RacaPet ASC 
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
		  echo "<br>";
          print_r($data);
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
					
					if($row->idApp_ClientePet){
						$row->VariacaoUsada = "S";
					}else{
						$row->VariacaoUsada = "N";
					}
					
				
				#    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                }
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function select_status_vida($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusVida');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusVida');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->StatusVida;
            }
        }

        return $array;
    }

}
