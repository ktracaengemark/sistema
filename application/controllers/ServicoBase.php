<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class ServicoBase extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Convenio_model', 'Servicobase_model', 'Contatocliente_model'));
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
			'idTab_ServicoBase',
            'ServicoBase',
			#'ValorCompraServicoBase',
			'TipoServicoBase',
			'CodServ',
                ), TRUE));
				
		(!$data['query']['TipoServicoBase']) ? $data['query']['TipoServicoBase'] = 'V' : FALSE;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('ServicoBase', 'Nome do Serviço', 'required|trim');
		
		$data['select']['TipoServicoBase'] = $this->Basico_model->select_tipoproduto(); 
		
        $data['titulo'] = 'Cadastrar Serviço';
        $data['form_open_path'] = 'servicobase/cadastrar';
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

        $data['q'] = $this->Servicobase_model->lista_servicobase(TRUE);
        $data['list'] = $this->load->view('servicobase/list_servicobase', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('servicobase/pesq_servicobase', $data);
        } else {

            #$data['query']['CodServ'] = trim(mb_strtoupper($data['query']['CodServ'], 'ISO-8859-1'));
			$data['query']['ServicoBase'] = trim(mb_strtoupper($data['query']['ServicoBase'], 'ISO-8859-1'));
            #$data['query']['ValorCompraServicoBase'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompraServicoBase']));
			$data['query']['TipoServicoBase'] = $data['query']['TipoServicoBase'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idTab_ServicoBase'] = $this->Servicobase_model->set_servicobase($data['query']);

			
            if ($data['idTab_ServicoBase'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('servicobase/cadastrar', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_ServicoBase'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_ServicoBase', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'servicobase/cadastrar' . $data['msg']);
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
			'idTab_ServicoBase',
            'ServicoBase',
			#'ValorCompraServicoBase',
			'TipoServicoBase',
			'CodServ',
                ), TRUE));

		(!$data['query']['TipoServicoBase']) ? $data['query']['TipoServicoBase'] = 'V' : FALSE;
		
        if ($id)
            $data['query'] = $this->Servicobase_model->get_servicobase($id);


        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('ServicoBase', 'Nome do Serviço', 'required|trim');

		$data['select']['TipoServicoBase'] = $this->Basico_model->select_tipoproduto(); 
		
        $data['titulo'] = 'Editar Serviço';
        $data['form_open_path'] = 'servicobase/alterar';
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

        $data['q'] = $this->Servicobase_model->lista_servicobase(TRUE);
        $data['list'] = $this->load->view('servicobase/list_servicobase', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('servicobase/pesq_servicobase', $data);
        } else {

            #$data['query']['CodServ'] = trim(mb_strtoupper($data['query']['CodServ'], 'ISO-8859-1'));
			$data['query']['ServicoBase'] = trim(mb_strtoupper($data['query']['ServicoBase'], 'ISO-8859-1'));
           #$data['query']['ValorCompraServicoBase'] = str_replace(',','.',str_replace('.','',$data['query']['ValorCompraServicoBase']));
			$data['query']['TipoServicoBase'] = $data['query']['TipoServicoBase'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Servicobase_model->get_servicobase($data['query']['idTab_ServicoBase']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_ServicoBase'], TRUE);

            if ($data['auditoriaitem'] && $this->Servicobase_model->update_servicobase($data['query'], $data['query']['idTab_ServicoBase']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'servicobase/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_ServicoBase', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'servicobase/cadastrar/' . $data['msg']);
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

                $this->Servicobase_model->delete_servicobase($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'servicobase/cadastrar/' . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

}
