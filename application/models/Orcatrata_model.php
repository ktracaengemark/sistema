<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrata_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_orcatrata($data) {

        $query = $this->db->insert('App_OrcaTrata', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_servico_venda($data) {

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        //exit ();
        */

        $query = $this->db->insert_batch('App_ServicoVenda', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_produto_venda($data) {

        $query = $this->db->insert_batch('App_ProdutoVenda', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_parcelasrec_venda($data) {

        $query = $this->db->insert_batch('App_ParcelasRecebiveis', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_procedimento($data) {

        $query = $this->db->insert('App_Procedimento', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

	public function set_parcelasrec($data) {

        $query = $this->db->insert('App_ParcelasRec', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_orcatrata($data) {
        $query = $this->db->query('SELECT * FROM App_OrcaTrata WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

	public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

	public function get_parcelasrec($data) {
		$query = $this->db->query('SELECT * FROM App_ParcelasRec WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_orcatrata($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_OrcaTrata', $data, array('idApp_OrcaTrata' => $id));
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

	public function update_procedimento($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Procedimento', $data, array('idApp_Procedimento' => $id));
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

	public function update_parcelasrec($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_ParcelasRec', $data, array('idApp_ParcelasRec' => $id));
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

    public function delete_orcatrata($data) {
        $query = $this->db->delete('App_OrcaTrata', array('idApp_OrcaTrata' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

	public function delete_procedimento($data) {
        $query = $this->db->delete('App_Procedimento', array('idApp_Procedimento' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

	public function delete_parcelasrec($data) {
        $query = $this->db->delete('App_ParcelasRec', array('idApp_ParcelasRec' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_orcatrata($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_OrcaTrata WHERE '
                . 'idApp_Cliente = ' . $_SESSION['Cliente']['idApp_Cliente'] . ' '
                #. 'ORDER BY idApp_OrcaTrata DESC ');
				. 'ORDER BY DataOrca DESC ');
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
                    #$row->Idade = $this->basico->calcula_idade($row->DataOrca);
                    $row->DataVenc = $this->basico->mascara_data($row->DataVencOrca, 'barras');
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataRet = $this->basico->mascara_data($row->DataRet, 'barras');
					$row->DataConcl = $this->basico->mascara_data($row->DataConcl, 'barras');
                   # $row->Sexo = $this->Basico_model->get_sexo($row->Sexo);
                }

                return $query;
            }
        }
    }

   /* public function select_status_vida($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusOrca');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusOrca');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->StatusOrca;
            }
        }

        return $array;
    }*/

	public function select_status_orca($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusOrca');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusOrca');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->StatusOrca;
            }
        }

        return $array;
    }

}
