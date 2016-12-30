<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Produto extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Produto_model', 'Contatocliente_model'));
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
            'idTab_Produto',
            'NomeProduto',
            #'Quantidade',
            'UnidadeProduto',
            #'ValorCompra',
            'ValorVendaProduto',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeProduto', 'Nome do Produto', 'required|trim');
        $this->form_validation->set_rules('ValorVendaProduto', 'Valor de Venda', 'required|trim');

        $data['titulo'] = 'Cadastrar Produto';
        $data['form_open_path'] = 'produto/cadastrar';
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

        $data['q'] = $this->Produto_model->lista_produto(TRUE);
        $data['list'] = $this->load->view('produto/list_produto', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produto/pesq_produto', $data);
        } else {

            $data['query']['NomeProduto'] = trim(mb_strtoupper($data['query']['NomeProduto'], 'ISO-8859-1'));
            #$data['query']['Quantidade'] = str_replace(',','.',str_replace('.','',$data['query']['Quantidade']));
            #$data['query']['ValorCompra'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompra']));
            $data['query']['ValorVendaProduto'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVendaProduto']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idTab_Produto'] = $this->Produto_model->set_produto($data['query']);

            if ($data['idTab_Produto'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produto/cadastrar', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'produto/cadastrar' . $data['msg']);
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
            'idTab_Produto',
            'NomeProduto',
            #'Quantidade',
            'UnidadeProduto',
            #'ValorCompra',
            'ValorVendaProduto',
                ), TRUE));

        if ($id)
            $data['query'] = $this->Produto_model->get_produto($id);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeProduto', 'Nome do Produto', 'required|trim');
        $this->form_validation->set_rules('ValorVendaProduto', 'Valor de Venda', 'required|trim');

        $data['titulo'] = 'Editar Produto';
        $data['form_open_path'] = 'produto/alterar';
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

        $data['q'] = $this->Produto_model->lista_produto(TRUE);
        $data['list'] = $this->load->view('produto/list_produto', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produto/pesq_produto', $data);
        } else {

            $data['query']['NomeProduto'] = trim(mb_strtoupper($data['query']['NomeProduto'], 'ISO-8859-1'));
            #$data['query']['Quantidade'] = str_replace(',','.',str_replace('.','',$data['query']['Quantidade']));
            #$data['query']['ValorCompra'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompra']));
            $data['query']['ValorVendaProduto'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVendaProduto']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Produto_model->get_produto($data['query']['idTab_Produto']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Produto'], TRUE);

            if ($data['auditoriaitem'] && $this->Produto_model->update_produto($data['query'], $data['query']['idTab_Produto']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'produto/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'produto/cadastrar/' . $data['msg']);
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
            'idTab_Produto',
            'NomeProduto',
                ), TRUE);

        if ($id)
            $data['query'] = $this->Produto_model->get_produto($id);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeProduto', 'Nome do Produto', 'required|trim');

        $data['titulo'] = 'Editar Produto';
        $data['form_open_path'] = 'produto/alterar';
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

        $data['q'] = $this->Produto_model->lista_produto(TRUE);
        $data['list'] = $this->load->view('produto/list_produto', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produto/pesq_produto', $data);
        } else {

            $data['query']['NomeProduto'] = trim(mb_strtoupper($data['query']['NomeProduto'], 'ISO-8859-1'));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Produto_model->get_produto($data['query']['idTab_Produto']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Produto'], TRUE);

            if ($data['auditoriaitem'] && $this->Produto_model->update_produto($data['query'], $data['query']['idTab_Produto']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'produto/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'produto/cadastrar/produto/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }


}
