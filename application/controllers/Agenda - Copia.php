<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Agenda_model', 'Relatorio_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        unset($_SESSION['agenda']);

    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional3();

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeProfissional',
        ), TRUE));

        $_SESSION['log']['NomeProfissional'] = ($data['query']['NomeProfissional']) ?
            $data['query']['NomeProfissional'] : FALSE;

        $data['query']['estatisticas'] = $this->Agenda_model->resumo_estatisticas($_SESSION['log']['id']);
        $data['query']['cliente_aniversariantes'] = $this->Agenda_model->cliente_aniversariantes($_SESSION['log']['id']);
        $data['query']['contatocliente_aniversariantes'] = $this->Agenda_model->contatocliente_aniversariantes($_SESSION['log']['id']);
        $data['query']['profissional_aniversariantes'] = $this->Agenda_model->profissional_aniversariantes($_SESSION['log']['id']);
		$data['query']['contatoprof_aniversariantes'] = $this->Agenda_model->contatoprof_aniversariantes($_SESSION['log']['id']);
		$this->load->view('agenda/tela_agenda', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

}
