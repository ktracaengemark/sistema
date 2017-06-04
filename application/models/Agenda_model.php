<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function resumo_estatisticas($data) {

        $query = $this->db->query('SELECT 
                C.idTab_Status, 
                COUNT(*) AS Total 
            FROM
                app.App_Agenda AS A, 
                app.App_Consulta AS C 
            WHERE 
                YEAR(DataInicio) = ' . date('Y', time()) . ' AND MONTH(DataInicio) = ' . date('m', time()) . ' AND
                C.Evento IS NULL AND 
                C.idTab_Modulo = 1 AND 
                A.idSis_Usuario = ' . $data . ' AND 
                A.idApp_Agenda = C.idApp_Agenda 
            GROUP BY C.idTab_Status
            ORDER BY C.idTab_Status ASC');
        //$query = $query->result_array();
        if ($query->num_rows() !== 0) {

            foreach ($query->result() as $row) {
                $array[$row->idTab_Status] = $row->Total;
            }
            return $array;
        } else
            return FALSE;
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($array);
          echo "</pre>";
          exit ();
         */

        //if ($array->num_rows() === 0)
        //    return FALSE;
        //else
    }

    public function cliente_aniversariantes($data) {

        $query = $this->db->query('
            SELECT 
                idApp_Cliente, 
                NomeCliente,
                DataNascimento
            FROM 
                app.App_Cliente
            WHERE 
                idSis_Usuario = ' . $data . ' AND 
                (DAY(DataNascimento) = ' . date('d', time()) . ' AND MONTH(DataNascimento) = ' . date('m', time()) . ')
            ORDER BY NomeCliente ASC');

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
        else {

            foreach ($query->result() as $row) {
                $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
            }            
            return $query;
        }
        
    }

    public function contatocliente_aniversariantes($data) {

        $query = $this->db->query('
            SELECT 
                D.idApp_Cliente, 
                D.idApp_ContatoCliente,
                D.NomeContatoCliente,
                D.DataNascimento
            FROM 
                app.App_ContatoCliente AS D,
                app.App_Cliente AS R
            WHERE 
                R.idSis_Usuario = ' . $data . ' AND 
                (DAY(D.DataNascimento) =  ' . date('d', time()) . '  AND MONTH(D.DataNascimento) = ' . date('m', time()) . ') AND
                R.idApp_Cliente = D.idApp_Cliente            
            ORDER BY D.NomeContatoCliente ASC');

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
        else {

            foreach ($query->result() as $row) {
                $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
            }
            return $query;
        }
    }
	
	public function profissional_aniversariantes($data) {

        $query = $this->db->query('
            SELECT 
                idApp_Profissional, 
                NomeProfissional,
                DataNascimento
            FROM 
                app.App_Profissional
            WHERE 
                idSis_Usuario = ' . $data . ' AND 
                (DAY(DataNascimento) = ' . date('d', time()) . ' AND MONTH(DataNascimento) = ' . date('m', time()) . ')
            ORDER BY NomeProfissional ASC');

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
        else {

            foreach ($query->result() as $row) {
                $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
            }            
            return $query;
        }
        
    }
	
	public function contatoprof_aniversariantes($data) {

        $query = $this->db->query('
            SELECT 
                D.idApp_Profissional, 
                D.idApp_ContatoProf,
                D.NomeContatoProf,
                D.DataNascimento
            FROM 
                app.App_ContatoProf AS D,
                app.App_Profissional AS R
            WHERE 
                R.idSis_Usuario = ' . $data . ' AND 
                (DAY(D.DataNascimento) =  ' . date('d', time()) . '  AND MONTH(D.DataNascimento) = ' . date('m', time()) . ') AND
                R.idApp_Profissional = D.idApp_Profissional            
            ORDER BY D.NomeContatoProf ASC');

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
        else {

            foreach ($query->result() as $row) {
                $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
            }
            return $query;
        }
    }

}
