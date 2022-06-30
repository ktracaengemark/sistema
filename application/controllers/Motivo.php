<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Motivo extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Motivo_model', 'Contatocliente_model'));
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
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$data['query'] = quotes_to_entities($this->input->post(array(
				'Motivo',
				'Desc_Motivo',
			), TRUE));

			$data['titulo'] = 'Cadastrar Motivo';
			$data['form_open_path'] = 'motivo/cadastrar';
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

			$data['q'] = $this->Motivo_model->lista_motivo(TRUE);
			$data['list'] = $this->load->view('motivo/list_motivo', $data, TRUE);

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('Motivo', 'Nome do Convênio', 'required|trim');
			$this->form_validation->set_rules('Desc_Motivo', 'Descrição', 'required|trim');

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('motivo/pesq_motivo', $data);
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {
						
					$data['query']['Motivo'] = trim(mb_strtoupper($data['query']['Motivo'], 'ISO-8859-1'));
					$data['query']['Desc_Motivo'] = trim(mb_strtoupper($data['query']['Desc_Motivo'], 'ISO-8859-1'));
					$data['query']['Data_Cad_Motivo'] = date('Y-m-d H:i:s', time());
					$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

					$data['campos'] = array_keys($data['query']);
					$data['anterior'] = array();

					$data['idTab_Motivo'] = $this->Motivo_model->set_motivo($data['query']);

					if ($data['idTab_Motivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('motivo/cadastrar', $data);
					} else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Motivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Motivo', 'CREATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';

						redirect(base_url() . 'motivo/cadastrar' . $data['msg']);
						exit();
					}
				}
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
			'idTab_Motivo',
            'Motivo',
            'Desc_Motivo',
		), TRUE));

        if ($id){
            $data['query'] = $this->Motivo_model->get_motivo($id);
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}
		}
		
		if(!$data['query']['idTab_Motivo']){
			
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			$data['titulo'] = 'Editar Motivo';
			$data['form_open_path'] = 'motivo/alterar';
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

			$data['q'] = $this->Motivo_model->lista_motivo(TRUE);
			$data['list'] = $this->load->view('motivo/list_motivo', $data, TRUE);

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('Motivo', 'Nome do Convênio', 'required|trim');
			$this->form_validation->set_rules('Desc_Motivo', 'Descrição', 'required|trim');

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('motivo/pesq_motivo', $data);
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {
					

					$data['query']['Motivo'] = trim(mb_strtoupper($data['query']['Motivo'], 'ISO-8859-1'));
					$data['query']['Desc_Motivo'] = trim(mb_strtoupper($data['query']['Desc_Motivo'], 'ISO-8859-1'));

					$data['anterior'] = $this->Motivo_model->get_motivo($data['query']['idTab_Motivo']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Motivo'], TRUE);

					if ($data['auditoriaitem'] && $this->Motivo_model->update_motivo($data['query'], $data['query']['idTab_Motivo']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'motivo/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Motivo', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'motivo/cadastrar/' . $data['msg']);
						exit();
					}
				}
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

		if (!$id) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
            $data['query'] = $this->Motivo_model->get_motivo($id);
			
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
				} else {
					
					$this->Motivo_model->delete_motivo($id);

					$data['msg'] = '?m=1';

					redirect(base_url() . 'motivo/cadastrar/' . $data['msg']);
					exit();
				}
			}
		}
        $this->load->view('basico/footer');
    }

}
