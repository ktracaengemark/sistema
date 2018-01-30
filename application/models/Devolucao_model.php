<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Devolucao_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_despesas($data) {

        $query = $this->db->insert('App_Despesas', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_servico_compra($data) {

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        //exit ();
        */

        $query = $this->db->insert_batch('App_ServicoCompra', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_produto_compra($data) {

        $query = $this->db->insert_batch('App_ProdutoCompra', $data);

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

    public function get_despesas($data) {
        $query = $this->db->query('SELECT * FROM App_Despesas WHERE idApp_Despesas = ' . $data);
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
		$query = $this->db->query('SELECT * FROM App_ServicoCompra WHERE idApp_Despesas = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_produto($data) {
		$query = $this->db->query('SELECT * FROM App_ProdutoCompra WHERE idApp_Despesas = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_parcelaspag($data) {
		$query = $this->db->query('SELECT * FROM App_ParcelasPagaveis WHERE idApp_Despesas = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_Despesas = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function list_despesas($id, $aprovado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_Despesas, '
            . 'OT.DataDespesas, '

            . 'OT.ProfissionalDespesas, '
            . 'OT.AprovadoDespesas, '
            . 'OT.ObsDespesas '
            . 'FROM '
            . 'App_Despesas AS OT '
            . 'WHERE '
            . 'OT.idApp_Cliente = ' . $id . ' AND '
            . 'OT.AprovadoDespesas = "' . $aprovado . '" '
            . 'ORDER BY OT.DataDespesas DESC ');
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
					$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');

                    $row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
                    $row->ProfissionalDespesas = $this->get_profissional($row->ProfissionalDespesas);
                }
                return $query;
            }
        }
    }

    public function list_despesasBKP($x) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_Despesas, '
            . 'OT.DataDespesas, '

            . 'OT.ProfissionalDespesas, '
            . 'OT.AprovadoDespesas, '
            . 'OT.ObsDespesas '
            . 'FROM '
            . 'App_Despesas AS OT '
            . 'WHERE '
            . 'OT.idApp_Cliente = ' . $_SESSION['Despesas']['idApp_Cliente'] . ' '
            . 'ORDER BY OT.DataDespesas DESC ');
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
					$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');
               
					$row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
                    $row->ProfissionalDespesas = $this->get_profissional($row->ProfissionalDespesas);
                }

                return $query;
            }
        }
    }

    public function update_despesas($data, $id) {

        unset($data['idApp_Despesas']);
        $query = $this->db->update('App_Despesas', $data, array('idApp_Despesas' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_servico_compra($data) {

        $query = $this->db->update_batch('App_ServicoCompra', $data, 'idApp_ServicoCompra');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produto_compra($data) {

        $query = $this->db->update_batch('App_ProdutoCompra', $data, 'idApp_ProdutoCompra');
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

    public function delete_servico_compra($data) {

        $this->db->where_in('idApp_ServicoCompra', $data);
        $this->db->delete('App_ServicoCompra');

        //$query = $this->db->delete('App_ServicoCompra', array('idApp_ServicoCompra' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_produto_compra($data) {

        $this->db->where_in('idApp_ProdutoCompra', $data);
        $this->db->delete('App_ProdutoCompra');

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

    public function delete_despesas($id) {

        /*
        $tables = array('App_ServicoCompra', 'App_ProdutoCompra', 'App_ParcelasPagaveis', 'App_Procedimento', 'App_Despesas');
        $this->db->where('idApp_Despesas', $id);
        $this->db->delete($tables);
        */

        $query = $this->db->delete('App_ServicoCompra', array('idApp_Despesas' => $id));
        $query = $this->db->delete('App_ProdutoCompra', array('idApp_Despesas' => $id));
        $query = $this->db->delete('App_ParcelasPagaveis', array('idApp_Despesas' => $id));
        $query = $this->db->delete('App_Despesas', array('idApp_Despesas' => $id));

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
