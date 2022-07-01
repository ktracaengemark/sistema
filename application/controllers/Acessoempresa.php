<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Acessoempresa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Agenda_model', 'Empresa_model', 'Relatorio_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

        unset($_SESSION['acessoempresa']);

    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Registro Não Encontrado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
     
		if (!isset($_SESSION['AdminEmpresa']) || !$_SESSION['AdminEmpresa']['idSis_Empresa']) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{	
			
			$this->load->view('acessoempresa/tela_acessoempresa', $data);
		
		}
        $this->load->view('basico/footer');
    }

}
