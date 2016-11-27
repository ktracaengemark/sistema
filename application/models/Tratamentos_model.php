<?php
#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias
defined('BASEPATH') OR exit('No direct script access allowed');
class Tratamentos_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }
    public function set_tratamentos($data) {
        $query = $this->db->insert('App_Tratamentos', $data);
        if ($this->db->affected_rows() === 0)
            return FALSE;
        else
            return $this->db->insert_id();
    }
    public function set_dados_dinamicos($table, $fields, $data) {
        /*
        $i=0;
        $q='';
        while ($data['idTab_Servico'][$i]) {
            $q = $q . '("' . $this->db->escape($this->input->post('idTab_Servico'.$i)) . '", ';
            $q = $q . '"0.00"), ';            
            $i++;
        }
        echo $q = substr($q, 0, strlen($q)-2) . '<br>';
                
        //echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();   
        */
        
        $query = $this->db->query('INSERT INTO ' . $table . ' (' . $fields . ') VALUES ' . $data);
        //$query = $this->db->query('INSERT INTO App_Servico (idTab_Servico, ValorVenda) VALUES ' . $data);
        //$this->db->insert($table, $data);
                
        if ($this->db->affected_rows() === 0)
            return FALSE;
        else
            return $this->db->insert_id();
    }    
    
    public function get_tratamentos($data) {
        $query = $this->db->query('SELECT * FROM App_Tratamentos WHERE idApp_Tratamentos = ' . $data);
        $query = $query->result_array();
        return $query[0];
    }
    public function update_tratamentos($data, $id) {
        unset($data['Id']);
        $query = $this->db->update('App_Tratamentos', $data, array('idApp_Tratamentos' => $id));
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
    public function delete_tratamentos($data) {
        $query = $this->db->delete('App_Tratamentos', array('idApp_Tratamentos' => $data));
        if ($this->db->affected_rows() === 0)
            return FALSE;
        else
            return TRUE;
    }
    public function lista_tratamentos_proxima($data) {
        $query = $this->db->query('SELECT '
                . 'C.idApp_Tratamentos, '
                . 'C.idApp_Agenda, '
                . 'C.idApp_Cliente, '
                . 'C.DataInicio, '
                . 'C.DataFim, '
                . 'S.idTab_Status, '
                . 'S.Status, '
                . 'D.NomeContatoCliente, '
                . 'V.NomeProfissional, '
                . 'C.Procedimento, '
                . 'C.Paciente, '
                . 'C.Obs '
            . 'FROM '
                . 'App_Tratamentos AS C '
                    . 'LEFT JOIN app.App_ContatoCliente AS D ON C.idApp_ContatoCliente = D.idApp_ContatoCliente, '
                . 'Tab_Status AS S, '                
                . 'App_Profissional AS V '
            . 'WHERE '
                . 'C.idApp_Cliente = ' . $data . ' AND '
                . '(C.DataInicio >= "' . date('Y-m-d H:i:s', time()) . '" OR ('
                . 'C.DataInicio < "' . date('Y-m-d H:i:s', time()) . '" AND '
                . 'C.DataFim >= "' . date('Y-m-d H:i:s', time()) . '") ) AND '
                . 'C.idTab_Status = S.idTab_Status AND '
                . 'C.idApp_Profissional = V.idApp_Profissional '
            . 'ORDER BY C.DataInicio ASC ');
        
        if ($query->num_rows() === 0)
            return FALSE;
        else
            return $query;
    }
    public function lista_tratamentos_anterior($data) {
        $query = $this->db->query('SELECT '
                . 'C.idApp_Tratamentos, '
                . 'C.idApp_Agenda, '
                . 'C.idApp_Cliente, '
                . 'C.DataInicio, '
                . 'C.DataFim, '
                . 'S.idTab_Status, '
                . 'S.Status, '
                . 'D.NomeContatoCliente, '
                . 'V.NomeProfissional, '
                . 'C.Procedimento, '
                . 'C.Paciente, '
                . 'C.Obs '
            . 'FROM '
                . 'App_Tratamentos AS C '
                    . 'LEFT JOIN app.App_ContatoCliente AS D ON C.idApp_ContatoCliente = D.idApp_ContatoCliente, '
                . 'Tab_Status AS S, '
                . 'App_Profissional AS V '
            . 'WHERE '
                . 'C.idApp_Cliente = ' . $data . ' AND '
                . 'C.DataFim < "' . date('Y-m-d H:i:s', time()) . '" AND '
                . 'C.idTab_Status = S.idTab_Status AND '
                . 'C.idApp_Profissional = V.idApp_Profissional '
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
            
    public function lista_servicos() {
        $query = $this->db->query('SELECT '
                . 'idTab_Servico,'
                . 'ValorVenda '
                . 'FROM Tab_Servico WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo']);
        /*
        if ($query->num_rows() === 0)
            return FALSE;
        else
            return $query->result_array();
         * 
         */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->ValorVenda;
            }
        }
        return $array;        
    }         
    public function lista_produtos() {
        $query = $this->db->query('SELECT '
                . 'idTab_Produto,'
                . 'ValorVenda '
                . 'FROM Tab_Produto WHERE '
                . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo']);
        /*
        if ($query->num_rows() === 0)
            return FALSE;
        else
            return $query->result_array();
         * 
         */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->ValorVenda;
            }
        }
        return $array;        
    } 
    
}