<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Funcao extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Contatocliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresamatriz');
        $this->load->view('basico/nav_principalempresamatriz');

        #$this->load->view('cliente/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('cliente/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($tabela = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idTab_Funcao',
            'Funcao',
			'Abrev',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Funcao', 'Nome do Funcao', 'required|trim');
		$this->form_validation->set_rules('Abrev', 'Abreviação', 'required|trim');
		
        $data['titulo'] = 'Cadastrar Funcao';
        $data['form_open_path'] = 'funcao/cadastrar/funcao';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['button'] =
                '
                <button class="btn btn-sm btn-primary" name="pesquisar" value="0" type="submit">
                    <span class="glyphicon glyphicon-plus"></span> Cadastrar
                </button>
        ';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['q'] = $this->Funcao_model->lista_funcao(TRUE);
        $data['list'] = $this->load->view('funcao/list_funcao', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('funcao/pesq_funcao', $data);
        } else {

            $data['query']['Funcao'] = trim(mb_strtoupper($data['query']['Funcao'], 'ISO-8859-1'));
			$data['query']['Abrev'] = trim(mb_strtoupper($data['query']['Abrev'], 'ISO-8859-1'));
			$data['query']['Empresa'] = $_SESSION['log']['id'];
			$data['query']['idSis_EmpresaFilial'] = $_SESSION['log']['id'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idTab_Funcao'] = $this->Funcao_model->set_funcao($data['query']);

            if ($data['idTab_Funcao'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('funcao/cadastrar/funcao', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Funcao'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Funcao', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'funcao/cadastrar/funcao' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idTab_Funcao',
            'Funcao',
			'Abrev',
                ), TRUE);

        if ($id)
            $data['query'] = $this->Funcao_model->get_funcao($id);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Funcao', 'Nome do Funcao', 'required|trim');
		$this->form_validation->set_rules('Abrev', 'Abreviação', 'required|trim');
		
        $data['titulo'] = 'Editar Funcao';
        $data['form_open_path'] = 'funcao/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['button'] =
                '
                <button class="btn btn-sm btn-warning" name="pesquisar" value="0" type="submit">
                    <span class="glyphicon glyphicon-edit"></span> Salvar Alteração
                </button>
        ';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['q'] = $this->Funcao_model->lista_funcao(TRUE);
        $data['list'] = $this->load->view('funcao/list_funcao', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('funcao/pesq_funcao', $data);
        } else {

            $data['query']['Funcao'] = trim(mb_strtoupper($data['query']['Funcao'], 'ISO-8859-1'));
            $data['query']['Abrev'] = trim(mb_strtoupper($data['query']['Abrev'], 'ISO-8859-1'));
			$data['query']['idSis_EmpresaFilial'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Funcao_model->get_funcao($data['query']['idTab_Funcao']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Funcao'], TRUE);

            if ($data['auditoriaitem'] && $this->Funcao_model->update_funcao($data['query'], $data['query']['idTab_Funcao']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'funcao/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Funcao', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'funcao/cadastrar/funcao/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

                $this->Funcao_model->delete_funcao($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'funcao/cadastrar/' . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }	

}
