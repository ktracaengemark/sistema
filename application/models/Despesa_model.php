<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Despesa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_despesa($data) {

        $query = $this->db->insert('App_Despesa', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

	public function set_parcelasdesp($data) {

        $query = $this->db->insert('App_ParcelasDesp', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_despesa($data) {
        $query = $this->db->query('SELECT * FROM App_Despesa WHERE idApp_Despesa = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

	public function get_parcelasdesp($data) {
        $query = $this->db->query('SELECT * FROM App_ParcelasDesp WHERE idApp_Despesa = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_despesa($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Despesa', $data, array('idApp_Despesa' => $id));
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

	public function update_parcelasdesp($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_ParcelasDesp', $data, array('idApp_ParcelasDesp' => $id));
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

    public function lista_despesa($x) {

        $query = $this->db->query('
            SELECT
                D.idApp_Despesa,
                D.Despesa,
                TD.TipoDespesa,
                D.ValorDesp,
                D.DataDesp,
                FP.FormaPag,
                D.DataVencDesp,
                E.NomeEmpresa AS Empresa

            FROM
                App_Despesa AS D
                    LEFT JOIN Tab_TipoDespesa AS TD ON TD.idTab_TipoDespesa = D.TipoDespesa
                    LEFT JOIN Tab_FormaPag    AS FP ON FP.idTab_FormaPag    = D.FormaPag
                    LEFT JOIN App_Empresa     AS E  ON E.idApp_Empresa      = D.Empresa
            WHERE
                D.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                D.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '

            ORDER BY
                D.DataDesp ASC
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
                #    $row->idTab_FormaPag = $row->idTab_FormaPag;
                #    $row->FormaPag = $row->FormaPag;
					#$row->DataVenc = $this->basico->mascara_data($row->DataVenc, 'barras');
					#$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

	public function select_despesa($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT * '
                    . 'idApp_Despesa, '
                    . 'Despesa, '
                    . 'QtdParc, '
                    #. 'Unidade, '
                    . 'ValorTotal, '
                    . 'ValorParc '
                    . 'FROM '
                    . 'App_Despesa '
					#. 'ORDER BY TipoDespesa');
                    . 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] );
        } else {
            $query = $this->db->query(
                'SELECT * '
                    . 'idApp_Despesa, '
                    . 'Despesa, '
                     . 'QtdParc, '
                    #. 'Unidade, '
                     . 'ValorTotal, '
                    . 'ValorParc '
                    . 'FROM '
                    . 'App_Despesa '
					#. 'ORDER BY TipoDespesa');
                    . 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id']);

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Despesa] = $row->Despesa;
            }
        }

        return $array;
    }
}
