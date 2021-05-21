<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Agendacli extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Agendacli_model', 'Relatorio_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principalcli');

        unset($_SESSION['agenda']);

    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['select']['NomeUsuario'] = $this->Agendacli_model->select_usuario();

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeUsuario',
        ), TRUE));

        $_SESSION['log']['NomeUsuario'] = ($data['query']['NomeUsuario']) ?
            $data['query']['NomeUsuario'] : FALSE;

        #$data['query']['estatisticas'] = $this->Agendacli_model->resumo_estatisticas($_SESSION['log']['idSis_UsuarioCli']);
        #$data['query']['cliente_aniversariantes'] = $this->Agendacli_model->cliente_aniversariantes($_SESSION['log']['idSis_UsuarioCli']);
        #$data['query']['contatocliente_aniversariantes'] = $this->Agendacli_model->contatocliente_aniversariantes($_SESSION['log']['idSis_UsuarioCli']);
        #$data['query']['profissional_aniversariantes'] = $this->Agendacli_model->profissional_aniversariantes($_SESSION['log']['idSis_UsuarioCli']);
		#$data['query']['contatoprof_aniversariantes'] = $this->Agendacli_model->contatoprof_aniversariantes($_SESSION['log']['idSis_UsuarioCli']);
		$data['query']['procedimentouscli'] = $this->Agendacli_model->procedimentouscli($_SESSION['log']['idSis_UsuarioCli']);
		#$data['query']['procedimentocli'] = $this->Agendacli_model->procedimentocli($_SESSION['log']['idSis_UsuarioCli']);
		#$data['query']['procedimentoorc'] = $this->Agendacli_model->procedimentoorc($_SESSION['log']['idSis_UsuarioCli']);
		
		$this->load->view('agendacli/tela_agendacli', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

}
