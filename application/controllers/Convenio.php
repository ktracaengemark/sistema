<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Convenio extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Convenio_model', 'Contatocliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

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
            'idSis_Usuario',
			'idTab_Convenio',
            'Convenio',
			'Abrev',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Convenio', 'Nome do Convênio', 'required|trim');
		$this->form_validation->set_rules('Abrev', 'Abreviação', 'required|trim');

        $data['titulo'] = 'Cadastrar Convênio';
        $data['form_open_path'] = 'convenio/cadastrar';
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

        $data['q'] = $this->Convenio_model->lista_convenio(TRUE);
        $data['list'] = $this->load->view('convenio/list_convenio', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('convenio/pesq_convenio', $data);
        } else {

            $data['query']['Convenio'] = trim(mb_strtoupper($data['query']['Convenio'], 'ISO-8859-1'));
			$data['query']['Abrev'] = trim(mb_strtoupper($data['query']['Abrev'], 'ISO-8859-1'));
           # $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idTab_Convenio'] = $this->Convenio_model->set_convenio($data['query']);

            if ($data['idTab_Convenio'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('convenio/cadastrar', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Convenio'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Convenio', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'convenio/cadastrar' . $data['msg']);
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

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idTab_Convenio',
            'Convenio',
            'Abrev',
                ), TRUE));


        if ($id)
            $data['query'] = $this->Convenio_model->get_convenio($id);


        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Convenio', 'Nome do Convênio', 'required|trim');
		$this->form_validation->set_rules('Abrev', 'Abreviação', 'required|trim');
       # $this->form_validation->set_rules('ValorVenda', 'Valor do Convênio', 'required|trim');

        $data['titulo'] = 'Editar Convênio';
        $data['form_open_path'] = 'convenio/alterar';
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

        $data['q'] = $this->Convenio_model->lista_convenio(TRUE);
        $data['list'] = $this->load->view('convenio/list_convenio', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('convenio/pesq_convenio', $data);
        } else {

            $data['query']['Convenio'] = trim(mb_strtoupper($data['query']['Convenio'], 'ISO-8859-1'));
			$data['query']['Abrev'] = trim(mb_strtoupper($data['query']['Abrev'], 'ISO-8859-1'));
           # $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Convenio_model->get_convenio($data['query']['idTab_Convenio']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Convenio'], TRUE);

            if ($data['auditoriaitem'] && $this->Convenio_model->update_convenio($data['query'], $data['query']['idTab_Convenio']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'convenio/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Convenio', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'convenio/cadastrar/' . $data['msg']);
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

        $data['query'] = $this->input->post(array(
            'idTab_Convenio',
            'Convenio',
                ), TRUE);

        if ($id)
            $data['query'] = $this->Convenio_model->get_convenio($id);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Convenio', 'Nome do Convenio', 'required|trim');

        $data['titulo'] = 'Editar Convenio';
        $data['form_open_path'] = 'convenio/alterar';
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

        $data['q'] = $this->Convenio_model->lista_convenio(TRUE);
        $data['list'] = $this->load->view('convenio/list_convenio', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('convenio/pesq_convenio', $data);
        } else {

            $data['query']['Convenio'] = trim(mb_strtoupper($data['query']['Convenio'], 'ISO-8859-1'));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Convenio_model->get_convenio($data['query']['idTab_Convenio']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Convenio'], TRUE);

            if ($data['auditoriaitem'] && $this->Convenio_model->update_convenio($data['query'], $data['query']['idTab_Convenio']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'convenio/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Convenio', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'convenio/cadastrar/convenio/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }


}
