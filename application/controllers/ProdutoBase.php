<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class ProdutoBase extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Convenio_model', 'ProdutoBase_model', 'Contatocliente_model'));
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
            'idTab_ProdutoBase',
            'ProdutoBase',
            'UnidadeProdutoBase',          
			'ValorCompraProdutoBase',
			'TipoProdutoBase',
                ), TRUE));

		(!$data['query']['TipoProdutoBase']) ? $data['query']['TipoProdutoBase'] = 'V' : FALSE;
				
        #$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('ProdutoBase', 'Nome do Produto', 'required|trim');
		#$this->form_validation->set_rules('ValorCompraProdutoBase', 'Valor de Compra', 'required|trim');
		
		$data['select']['TipoProdutoBase'] = $this->Basico_model->select_tipoproduto();      

		
        $data['titulo'] = 'Cadastrar Produto';
        $data['form_open_path'] = 'produtobase/cadastrar';
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

        $data['q'] = $this->ProdutoBase_model->lista_produtobase(TRUE);
        $data['list'] = $this->load->view('produtobase/list_produtobase', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produtobase/pesq_produtobase', $data);
        } else {

            $data['query']['ProdutoBase'] = trim(mb_strtoupper($data['query']['ProdutoBase'], 'ISO-8859-1'));
			$data['query']['ValorCompraProdutoBase'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompraProdutoBase']));
            $data['query']['TipoProdutoBase'] = $data['query']['TipoProdutoBase'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idTab_ProdutoBase'] = $this->ProdutoBase_model->set_produtobase($data['query']);

            if ($data['idTab_ProdutoBase'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtobase/cadastrar', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_ProdutoBase'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_ProdutoBase', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'produtobase/cadastrar' . $data['msg']);
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
            'idTab_ProdutoBase',
            'ProdutoBase',
            'UnidadeProdutoBase',
			'ValorCompraProdutoBase',
			'TipoProdutoBase',		
                ), TRUE));

        if ($id)
            $data['query'] = $this->ProdutoBase_model->get_produtobase($id);

		#(!$data['query']['TipoProdutoBase']) ? $data['query']['TipoProdutoBase'] = 'V' : FALSE;
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('ProdutoBase', 'Nome do ProdutoBase', 'required|trim');
		#$this->form_validation->set_rules('ValorCompraProdutoBase', 'Valor de Compra', 'required|trim');
		
		$data['select']['TipoProdutoBase'] = $this->Basico_model->select_tipoproduto();
		
        $data['titulo'] = 'Editar Produto';
        $data['form_open_path'] = 'produtobase/alterar';
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

        $data['q'] = $this->ProdutoBase_model->lista_produtobase(TRUE);
        $data['list'] = $this->load->view('produtobase/list_produtobase', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produtobase/pesq_produtobase', $data);
        } else {

            $data['query']['ProdutoBase'] = trim(mb_strtoupper($data['query']['ProdutoBase'], 'ISO-8859-1'));
            $data['query']['ValorCompraProdutoBase'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompraProdutoBase']));
			$data['query']['TipoProdutoBase'] = $data['query']['TipoProdutoBase'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->ProdutoBase_model->get_produtobase($data['query']['idTab_ProdutoBase']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_ProdutoBase'], TRUE);

            if ($data['auditoriaitem'] && $this->ProdutoBase_model->update_produtobase($data['query'], $data['query']['idTab_ProdutoBase']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'produtobase/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_ProdutoBase', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'produtobase/cadastrar/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function excluir2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idTab_ProdutoBase',
            'ProdutoBase',
                ), TRUE);

        if ($id)
            $data['query'] = $this->ProdutoBase_model->get_produtobase($id);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('ProdutoBase', 'Nome do ProdutoBase', 'required|trim');

        $data['titulo'] = 'Editar ProdutoBase';
        $data['form_open_path'] = 'produtobase/alterar';
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

        $data['q'] = $this->ProdutoBase_model->lista_produtobase(TRUE);
        $data['list'] = $this->load->view('produtobase/list_produtobase', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produtobase/pesq_produtobase', $data);
        } else {

            $data['query']['ProdutoBase'] = trim(mb_strtoupper($data['query']['ProdutoBase'], 'ISO-8859-1'));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->ProdutoBase_model->get_produtobase($data['query']['idTab_ProdutoBase']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_ProdutoBase'], TRUE);

            if ($data['auditoriaitem'] && $this->ProdutoBase_model->update_produtobase($data['query'], $data['query']['idTab_ProdutoBase']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'produtobase/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_ProdutoBase', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'produtobase/cadastrar/produtobase/' . $data['msg']);
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

                $this->ProdutoBase_model->delete_produtobase($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'produtobase/cadastrar/' . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }
}
