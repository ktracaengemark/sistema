<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Servicocompra extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Convenio_model', 'Servicocompra_model', 'Servicobase_model', 'Empresa_model', 'Contatocliente_model'));
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
			'idTab_ServicoCompra',
			'ValorCompraServico',
			'ServicoBase',
			'Empresa',
			'CodFornec',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
		$this->form_validation->set_rules('ServicoBase', 'Serviço', 'required|trim');
		
		$data['select']['ServicoBase'] = $this->Servicobase_model->select_servicobase2(); 
		$data['select']['Empresa'] = $this->Empresa_model->select_empresa2(); 
		
        $data['titulo'] = 'Cadastrar Fornec. e Preço de Compra dos Serviços';
        $data['form_open_path'] = 'servicocompra/cadastrar';
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

        $data['q'] = $this->Servicocompra_model->lista_servicocompra(TRUE);
        $data['list'] = $this->load->view('servicocompra/list_servicocompra', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('servicocompra/pesq_servicocompra', $data);
        } else {

			$data['query']['CodFornec'] = trim(mb_strtoupper($data['query']['CodFornec'], 'ISO-8859-1'));
            $data['query']['ValorCompraServico'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompraServico']));
			$data['query']['ServicoBase'] = $data['query']['ServicoBase'];
			$data['query']['Empresa'] = $data['query']['Empresa'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idTab_ServicoCompra'] = $this->Servicocompra_model->set_servicocompra($data['query']);

			
            if ($data['idTab_ServicoCompra'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('servicocompra/cadastrar', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_ServicoCompra'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_ServicoCompra', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'servicocompra/cadastrar' . $data['msg']);
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
			'idTab_ServicoCompra',
			'ValorCompraServico',
			'ServicoBase',
			'Empresa',
			'CodFornec',
                ), TRUE));

        if ($id)
            $data['query'] = $this->Servicocompra_model->get_servicocompra($id);


        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('ServicoBase', 'Serviço', 'required|trim');
		
		$data['select']['ServicoBase'] = $this->Servicobase_model->select_servicobase2(); 
		$data['select']['Empresa'] = $this->Empresa_model->select_empresa2();
		
        $data['titulo'] = 'Editar Fornec. e Preço de Compra dos Serviços';
        $data['form_open_path'] = 'servicocompra/alterar';
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

        $data['q'] = $this->Servicocompra_model->lista_servicocompra(TRUE);
        $data['list'] = $this->load->view('servicocompra/list_servicocompra', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('servicocompra/pesq_servicocompra', $data);
        } else {
			
			$data['query']['CodFornec'] = trim(mb_strtoupper($data['query']['CodFornec'], 'ISO-8859-1'));
            $data['query']['ValorCompraServico'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompraServico']));
			$data['query']['ServicoBase'] = $data['query']['ServicoBase'];
			$data['query']['Empresa'] = $data['query']['Empresa'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Servicocompra_model->get_servicocompra($data['query']['idTab_ServicoCompra']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_ServicoCompra'], TRUE);

            if ($data['auditoriaitem'] && $this->Servicocompra_model->update_servicocompra($data['query'], $data['query']['idTab_ServicoCompra']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'servicocompra/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_ServicoCompra', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'servicocompra/cadastrar/' . $data['msg']);
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

                $this->Servicocompra_model->delete_servicocompra($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'servicocompra/cadastrar/' . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

}
