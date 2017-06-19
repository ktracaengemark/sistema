<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Consumo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_consumo($data) {

        $query = $this->db->insert('App_Consumo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_servico_consumo($data) {

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        //exit ();
        */

        $query = $this->db->insert_batch('App_ServicoConsumo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_produto_consumo($data) {

        $query = $this->db->insert_batch('App_ProdutoConsumo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_parcelaspag($data) {

        $query = $this->db->insert_batch('App_ParcelasPagaveis', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_procedimento($data) {

        $query = $this->db->insert_batch('App_Procedimento', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_consumo($data) {
        $query = $this->db->query('SELECT * FROM App_Consumo WHERE idApp_Consumo = ' . $data);
        $query = $query->result_array();

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query[0];
    }

	public function get_servico($data) {
		$query = $this->db->query('SELECT * FROM App_ServicoConsumo WHERE idApp_Consumo = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_produto($data) {
		$query = $this->db->query('SELECT * FROM App_ProdutoConsumo WHERE idApp_Consumo = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_parcelaspag($data) {
		$query = $this->db->query('SELECT * FROM App_ParcelasPagaveis WHERE idApp_Consumo = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_Consumo = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function list_consumo($id, $aprovado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_Consumo, '
            . 'OT.DataConsumo, '

            . 'OT.ProfissionalConsumo, '
            . 'OT.AprovadoConsumo, '
            . 'OT.ObsConsumo '
            . 'FROM '
            . 'App_Consumo AS OT '
            . 'WHERE '
            . 'OT.idApp_Cliente = ' . $id . ' AND '
            . 'OT.AprovadoConsumo = "' . $aprovado . '" '
            . 'ORDER BY OT.DataConsumo DESC ');
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
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataConsumo = $this->basico->mascara_data($row->DataConsumo, 'barras');

                    $row->AprovadoConsumo = $this->basico->mascara_palavra_completa($row->AprovadoConsumo, 'NS');
                    $row->ProfissionalConsumo = $this->get_profissional($row->ProfissionalConsumo);
                }
                return $query;
            }
        }
    }

    public function list_consumoBKP($x) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_Consumo, '
            . 'OT.DataConsumo, '

            . 'OT.ProfissionalConsumo, '
            . 'OT.AprovadoConsumo, '
            . 'OT.ObsConsumo '
            . 'FROM '
            . 'App_Consumo AS OT '
            . 'WHERE '
            . 'OT.idApp_Cliente = ' . $_SESSION['Consumo']['idApp_Cliente'] . ' '
            . 'ORDER BY OT.DataConsumo DESC ');
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
					$row->DataConsumo = $this->basico->mascara_data($row->DataConsumo, 'barras');
               
					$row->AprovadoConsumo = $this->basico->mascara_palavra_completa($row->AprovadoConsumo, 'NS');
                    $row->ProfissionalConsumo = $this->get_profissional($row->ProfissionalConsumo);
                }

                return $query;
            }
        }
    }

    public function update_consumo($data, $id) {

        unset($data['idApp_Consumo']);
        $query = $this->db->update('App_Consumo', $data, array('idApp_Consumo' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_servico_consumo($data) {

        $query = $this->db->update_batch('App_ServicoConsumo', $data, 'idApp_ServicoConsumo');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produto_consumo($data) {

        $query = $this->db->update_batch('App_ProdutoConsumo', $data, 'idApp_ProdutoConsumo');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_parcelaspag($data) {

        $query = $this->db->update_batch('App_ParcelasPagaveis', $data, 'idApp_ParcelasPagaveis');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_procedimento($data) {

        $query = $this->db->update_batch('App_Procedimento', $data, 'idApp_Procedimento');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_servico_consumo($data) {

        $this->db->where_in('idApp_ServicoConsumo', $data);
        $this->db->delete('App_ServicoConsumo');

        //$query = $this->db->delete('App_ServicoConsumo', array('idApp_ServicoConsumo' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_produto_consumo($data) {

        $this->db->where_in('idApp_ProdutoConsumo', $data);
        $this->db->delete('App_ProdutoConsumo');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_parcelaspag($data) {

        $this->db->where_in('idApp_ParcelasPagaveis', $data);
        $this->db->delete('App_ParcelasPagaveis');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_procedimento($data) {

        $this->db->where_in('idApp_Procedimento', $data);
        $this->db->delete('App_Procedimento');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_consumo($id) {

        /*
        $tables = array('App_ServicoConsumo', 'App_ProdutoConsumo', 'App_ParcelasPagaveis', 'App_Procedimento', 'App_Consumo');
        $this->db->where('idApp_Consumo', $id);
        $this->db->delete($tables);
        */

        #$query = $this->db->delete('App_ServicoConsumo', array('idApp_Consumo' => $id));
        $query = $this->db->delete('App_ProdutoConsumo', array('idApp_Consumo' => $id));
       # $query = $this->db->delete('App_ParcelasPagaveis', array('idApp_Consumo' => $id));
        $query = $this->db->delete('App_Consumo', array('idApp_Consumo' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_profissional($data) {
		$query = $this->db->query('SELECT NomeProfissional FROM App_Profissional WHERE idApp_Profissional = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['NomeProfissional'])) ? $query[0]['NomeProfissional'] : FALSE;
    }

}
