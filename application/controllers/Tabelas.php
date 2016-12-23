<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Tabelas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Tabelas_model', 'Contatocliente_model'));
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

    public function profissional($tabela = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Profissional',
            'NomeProfissional',
			'DataNascimento',

            'Telefone1',
            'Telefone2',
            'Telefone3',

            'Sexo',
            'Endereco',
            'Bairro',
            'Municipio',

            'Obs',
			'Email',
			'idSis_Usuario',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeProfissional', 'Nome do Profissional', 'required|trim');
		$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        $data['titulo'] = 'Cadastrar Profissional';
        $data['form_open_path'] = 'tabelas/profissional/profissional';
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

		if ($data['query']['Sexo'] || $data['query']['Endereco'] || $data['query']['Bairro'] ||
                $data['query']['Municipio'] || $data['query']['Obs'] || $data['query']['Email'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        #$data['q'] = $this->Tabelas_model->lista_profissional(TRUE);
        #$data['list'] = $this->load->view('tabelas/list_tabelas', $data, TRUE);

		$data['tela'] = $this->load->view('cliente/form_cliente', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('tabelas/pesq_tabelas', $data);
        } else {

            $data['query']['NomeProfissional'] = trim(mb_strtoupper($data['query']['NomeProfissional'], 'ISO-8859-1'));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Profissional'] = $this->Tabelas_model->set_profissional($data['query']);

            if ($data['idApp_Profissional'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('tabelas/profissional/profissional', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Tabelas'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Profissional', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'tabelas/profissional/profissional' . $data['msg']);
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
            'idApp_Profissional',
            'NomeProfissional',
			'DataNascimento',

            'Telefone1',
            'Telefone2',
            'Telefone3',

            'Sexo',
            'Endereco',
            'Bairro',
            'Municipio',

            'Obs',
			'Email',
			'idSis_Usuario',
                ), TRUE);

        if ($id)
            $data['query'] = $this->Tabelas_model->get_profissional($id);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeProfissional', 'Nome do Profissional', 'required|trim');

        $data['titulo'] = 'Editar Profissional';
        $data['form_open_path'] = 'tabelas/alterar';
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

        $data['q'] = $this->Tabelas_model->lista_profissional(TRUE);
        $data['list'] = $this->load->view('tabelas/list_tabelas', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('tabelas/pesq_tabelas', $data);
        } else {

            $data['query']['NomeProfissional'] = trim(mb_strtoupper($data['query']['NomeProfissional'], 'ISO-8859-1'));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Tabelas_model->get_profissional($data['query']['idApp_Profissional']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Profissional'], TRUE);

            if ($data['auditoriaitem'] && $this->Tabelas_model->update_profissional($data['query'], $data['query']['idApp_Profissional']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'tabelas/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Profissional', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'tabelas/profissional/profissional/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function servico($tabela = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idTab_Servico',
            'NomeServico',
            'ValorVenda',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeServico', 'Nome do Serviço', 'required|trim');
        $this->form_validation->set_rules('ValorVenda', 'Valor do Serviço', 'required|trim');

        $data['titulo'] = 'Cadastrar Serviço';
        $data['form_open_path'] = 'tabelas/servico';
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

        $data['q'] = $this->Tabelas_model->lista_servico(TRUE);
        $data['list'] = $this->load->view('tabelas/list_servico', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('tabelas/pesq_servico', $data);
        } else {

            $data['query']['NomeServico'] = trim(mb_strtoupper($data['query']['NomeServico'], 'ISO-8859-1'));
            $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idTab_Servico'] = $this->Tabelas_model->set_servico($data['query']);

            if ($data['idTab_Servico'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('tabelas/servico', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Tabelas'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Servico', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'tabelas/servico' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }


    public function alterar_servico($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idTab_Servico',
            'NomeServico',
            'ValorVenda',
                ), TRUE));


        if ($id)
            $data['query'] = $this->Tabelas_model->get_servico($id);


        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeServico', 'Nome do Serviço', 'required|trim');
        $this->form_validation->set_rules('ValorVenda', 'Valor do Serviço', 'required|trim');

        $data['titulo'] = 'Editar Serviço';
        $data['form_open_path'] = 'tabelas/alterar_servico';
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

        $data['q'] = $this->Tabelas_model->lista_servico(TRUE);
        $data['list'] = $this->load->view('tabelas/list_servico', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('tabelas/pesq_servico', $data);
        } else {

            $data['query']['NomeServico'] = trim(mb_strtoupper($data['query']['NomeServico'], 'ISO-8859-1'));
            $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Tabelas_model->get_servico($data['query']['idTab_Servico']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Servico'], TRUE);

            if ($data['auditoriaitem'] && $this->Tabelas_model->update_servico($data['query'], $data['query']['idTab_Servico']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'tabelas/alterar_servico/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Servico', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'tabelas/servico/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function produto($tabela = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idTab_Produto',
            'NomeProduto',
            'QuantidadeCompra',
            'Unidade',
            'ValorCompra',
            'ValorVenda',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeProduto', 'Nome do Produto', 'required|trim');
        $this->form_validation->set_rules('ValorVenda', 'Valor de Venda', 'required|trim');

        $data['titulo'] = 'Cadastrar Produto';
        $data['form_open_path'] = 'tabelas/produto';
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

        $data['q'] = $this->Tabelas_model->lista_produto(TRUE);
        $data['list'] = $this->load->view('tabelas/list_produto', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('tabelas/pesq_produto', $data);
        } else {

            $data['query']['NomeProduto'] = trim(mb_strtoupper($data['query']['NomeProduto'], 'ISO-8859-1'));
            $data['query']['QuantidadeCompra'] = str_replace(',','.',str_replace('.','',$data['query']['QuantidadeCompra']));
            $data['query']['ValorCompra'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompra']));
            $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idTab_Produto'] = $this->Tabelas_model->set_produto($data['query']);

            if ($data['idTab_Produto'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('tabelas/produto', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Tabelas'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'tabelas/produto' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar_produto($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idTab_Produto',
            'NomeProduto',
            'QuantidadeCompra',
            'Unidade',
            'ValorCompra',
            'ValorVenda',
                ), TRUE));

        if ($id)
            $data['query'] = $this->Tabelas_model->get_produto($id);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeProduto', 'Nome do Produto', 'required|trim');
        $this->form_validation->set_rules('ValorVenda', 'Valor de Venda', 'required|trim');

        $data['titulo'] = 'Editar Produto';
        $data['form_open_path'] = 'tabelas/alterar_produto';
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

        $data['q'] = $this->Tabelas_model->lista_produto(TRUE);
        $data['list'] = $this->load->view('tabelas/list_produto', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('tabelas/pesq_produto', $data);
        } else {

            $data['query']['NomeProduto'] = trim(mb_strtoupper($data['query']['NomeProduto'], 'ISO-8859-1'));
            $data['query']['QuantidadeCompra'] = str_replace(',','.',str_replace('.','',$data['query']['QuantidadeCompra']));
            $data['query']['ValorCompra'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompra']));
            $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Tabelas_model->get_produto($data['query']['idTab_Produto']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Produto'], TRUE);

            if ($data['auditoriaitem'] && $this->Tabelas_model->update_produto($data['query'], $data['query']['idTab_Produto']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'tabelas/alterar_produto/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'tabelas/produto/' . $data['msg']);
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
            'idApp_Profissional',
            'NomeProfissional',
                ), TRUE);

        if ($id)
            $data['query'] = $this->Tabelas_model->get_profissional($id);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeProfissional', 'Nome do Profissional', 'required|trim');

        $data['titulo'] = 'Editar Profissional';
        $data['form_open_path'] = 'tabelas/alterar';
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

        $data['q'] = $this->Tabelas_model->lista_profissional(TRUE);
        $data['list'] = $this->load->view('tabelas/list_tabelas', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('tabelas/pesq_tabelas', $data);
        } else {

            $data['query']['NomeProfissional'] = trim(mb_strtoupper($data['query']['NomeProfissional'], 'ISO-8859-1'));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Tabelas_model->get_profissional($data['query']['idApp_Profissional']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Profissional'], TRUE);

            if ($data['auditoriaitem'] && $this->Tabelas_model->update_profissional($data['query'], $data['query']['idApp_Profissional']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'tabelas/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Profissional', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'tabelas/cadastrar/profissional/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }


}
