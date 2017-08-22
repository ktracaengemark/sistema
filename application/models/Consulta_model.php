<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Consulta_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_consulta($data) {

        $query = $this->db->insert('App_Consulta', $data);

        if ($this->db->affected_rows() === 0)
            return FALSE;
        else
            return $this->db->insert_id();
    }

    public function get_consulta($data) {
        $query = $this->db->query('SELECT * FROM App_Consulta WHERE idApp_Consulta = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_consulta($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Consulta', $data, array('idApp_Consulta' => $id));
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */
        if ($this->db->affected_rows() === 0)
            return FALSE;
        else
            return TRUE;
    }

    public function delete_consulta($data) {
        $query = $this->db->delete('App_Consulta', array('idApp_Consulta' => $data));

        if ($this->db->affected_rows() === 0)
            return FALSE;
        else
            return TRUE;
    }

    public function lista_consulta_proxima($data) {

        $query = $this->db->query('SELECT '
                . 'C.idApp_Consulta, '
                . 'C.idApp_Agenda, '
                . 'C.idApp_Cliente, '
                . 'C.DataInicio, '
                . 'C.DataFim, '
                . 'S.idTab_Status, '
                . 'S.Status, '
                . 'D.NomeContatoCliente, '
                . 'V.Nome, '
                . 'C.Procedimento, '
                . 'C.Paciente, '
                . 'C.Obs '
            . 'FROM '
                . 'App_Consulta AS C '
                    . 'LEFT JOIN app.App_ContatoCliente AS D ON C.idApp_ContatoCliente = D.idApp_ContatoCliente, '
                . 'Tab_Status AS S, '                
                . 'Sis_Usuario AS V '
            . 'WHERE '
                . 'C.idApp_Cliente = ' . $data . ' AND '
                . '(C.DataInicio >= "' . date('Y-m-d H:i:s', time()) . '" OR ('
                . 'C.DataInicio < "' . date('Y-m-d H:i:s', time()) . '" AND '
                . 'C.DataFim >= "' . date('Y-m-d H:i:s', time()) . '") ) AND '
                . 'C.idTab_Status = S.idTab_Status AND '
                . 'V.idSis_Usuario = C.idSis_Usuario '
            . 'ORDER BY C.DataInicio ASC ');
        
        if ($query->num_rows() === 0)
            return FALSE;
        else
            return $query;
    }

    public function lista_consulta_anterior($data) {

        $query = $this->db->query('SELECT '
                . 'C.idApp_Consulta, '
                . 'C.idApp_Agenda, '
                . 'C.idApp_Cliente, '
                . 'C.DataInicio, '
                . 'C.DataFim, '
                . 'S.idTab_Status, '
                . 'S.Status, '
                . 'D.NomeContatoCliente, '
                . 'V.Nome, '
                . 'C.Procedimento, '
                . 'C.Paciente, '
                . 'C.Obs '
            . 'FROM '
                . 'App_Consulta AS C '
                    . 'LEFT JOIN app.App_ContatoCliente AS D ON C.idApp_ContatoCliente = D.idApp_ContatoCliente, '
                . 'Tab_Status AS S, '
                . 'Sis_Usuario AS V '
            . 'WHERE '
                . 'C.idApp_Cliente = ' . $data . ' AND '
                . 'C.DataFim < "' . date('Y-m-d H:i:s', time()) . '" AND '
                . 'C.idTab_Status = S.idTab_Status AND '
                . 'V.idSis_Usuario = C.idSis_Usuario '
            . 'ORDER BY C.DataInicio ASC ');
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
        */
        
        if ($query->num_rows() === 0)
            return FALSE;
        else
            return $query;
    }

    public function select_contatocliente_cliente($data) {

        $q = 'SELECT '
                . 'idApp_ContatoCliente, '
                . 'NomeContatoCliente '
                . 'FROM '
                . 'App_ContatoCliente '
                . 'WHERE '
                . 'idApp_Cliente = ' . $data . ' '
                . 'ORDER BY NomeContatoCliente ASC ';
        
        if ($data === TRUE) {
            $array = $this->db->query($q);
        } else {
            $query = $this->db->query($q);
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_ContatoCliente] = $row->NomeContatoCliente;
            }
        }

        return $array;
    }            
            
}
