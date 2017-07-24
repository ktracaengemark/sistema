<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Produtocompra extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Convenio_model', 'Produtocompra_model', 'Produtobase_model', 'Empresa_model', 'Contatocliente_model'));
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
            'idTab_ProdutoCompra',         
			'ValorCompraProduto',
			'ProdutoBase',
			'Empresa',
			'CodFornec',
			
                ), TRUE));

				
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('ProdutoBase', 'Produto', 'required|trim');
		$data['select']['ProdutoBase'] = $this->Produtobase_model->select_produtobase2(); 
		$data['select']['Empresa'] = $this->Empresa_model->select_empresa1(); 
		
        $data['titulo'] = 'Cadastrar Fornec. e Preço de Compra dos Produtos';
        $data['form_open_path'] = 'produtocompra/cadastrar';
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

        $data['q'] = $this->Produtocompra_model->lista_produtocompra(TRUE);
        $data['list'] = $this->load->view('produtocompra/list_produtocompra', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produtocompra/pesq_produtocompra', $data);
        } else {

            $data['query']['CodFornec'] = trim(mb_strtoupper($data['query']['CodFornec'], 'ISO-8859-1'));
			$data['query']['ValorCompraProduto'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompraProduto']));
			$data['query']['ProdutoBase'] = $data['query']['ProdutoBase'];
			$data['query']['Empresa'] = $data['query']['Empresa'];			
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idTab_ProdutoCompra'] = $this->Produtocompra_model->set_produtocompra($data['query']);

            if ($data['idTab_ProdutoCompra'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtocompra/cadastrar', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_ProdutoCompra'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_ProdutoCompra', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'produtocompra/cadastrar' . $data['msg']);
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
            'idTab_ProdutoCompra',
			'ValorCompraProduto',
			'ProdutoBase',
			'Empresa',
			'CodFornec',
                ), TRUE));

        if ($id)
            $data['query'] = $this->Produtocompra_model->get_produtocompra($id);

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('ProdutoBase', 'Produto', 'required|trim');
		$data['select']['ProdutoBase'] = $this->Produtobase_model->select_produtobase2(); 
		$data['select']['Empresa'] = $this->Empresa_model->select_empresa1();
		
        $data['titulo'] = 'Editar Fornec. e Preço de Compra dos Produtos';
        $data['form_open_path'] = 'produtocompra/alterar';
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

        $data['q'] = $this->Produtocompra_model->lista_produtocompra(TRUE);
        $data['list'] = $this->load->view('produtocompra/list_produtocompra', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produtocompra/pesq_produtocompra', $data);
        } else {
			
			$data['query']['CodFornec'] = trim(mb_strtoupper($data['query']['CodFornec'], 'ISO-8859-1'));
            $data['query']['ValorCompraProduto'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompraProduto']));
			$data['query']['ProdutoBase'] = $data['query']['ProdutoBase'];			
			$data['query']['Empresa'] = $data['query']['Empresa'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Produtocompra_model->get_produtocompra($data['query']['idTab_ProdutoCompra']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_ProdutoCompra'], TRUE);

            if ($data['auditoriaitem'] && $this->Produtocompra_model->update_produtocompra($data['query'], $data['query']['idTab_ProdutoCompra']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'produtocompra/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_ProdutoCompra', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'produtocompra/cadastrar/' . $data['msg']);
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

                $this->Produtocompra_model->delete_produtocompra($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'produtocompra/cadastrar/' . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }
}
