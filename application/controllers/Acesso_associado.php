<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Acesso_associado extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Agenda_model', 'Empresa_model', 'Usuario_model', 'Associado_model', 'Relatorio_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        unset($_SESSION['acesso']);

    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!isset($_SESSION['Empresa']) || $_SESSION['Empresa']['idSis_Empresa'] != 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
			
			$this->load->view('acesso_associado/tela_acesso', $data);

		}
        $this->load->view('basico/footer');
    }

}
