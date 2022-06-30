<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Atividade extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Atividade_model', 'Contatocliente_model'));
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
				#'idApp_Atividade',
				'Atividade',
			), TRUE));

			$data['titulo'] = 'Cadastrar Atividade';
			$data['form_open_path'] = 'atividade/cadastrar/atividade';
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

			$data['q'] = $this->Atividade_model->lista_atividade(TRUE);
			$data['list'] = $this->load->view('atividade/list_atividade', $data, TRUE);

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('Atividade', 'Nome do Atividade', 'required|trim');

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('atividade/pesq_atividade', $data);
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {
						
					$data['query']['Atividade'] = trim(mb_strtoupper($data['query']['Atividade'], 'ISO-8859-1'));
					$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['query']['Data_Cad_Atividade'] = date('Y-m-d H:i:s', time());
					
					$data['campos'] = array_keys($data['query']);
					$data['anterior'] = array();

					$data['idApp_Atividade'] = $this->Atividade_model->set_atividade($data['query']);

					if ($data['idApp_Atividade'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('atividade/cadastrar/atividade', $data);
					} else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Atividade'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Atividade', 'CREATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';

						redirect(base_url() . 'atividade/cadastrar/atividade' . $data['msg']);
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

        $data['query'] = $this->input->post(array(
            'idApp_Atividade',
            'Atividade',
		), TRUE);

        if ($id){
            $data['query'] = $this->Atividade_model->get_atividade($id);
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}
		}
		
		if(!$data['query']['idApp_Atividade']){
			
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
		
			$data['titulo'] = 'Editar Atividade';
			$data['form_open_path'] = 'atividade/alterar';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 2;
			$data['button'] =
							'
								<div class="col-md-6 ">
									<button class="btn btn-sm btn-warning btn-block" name="pesquisar" value="0" type="submit">
										<span class="glyphicon glyphicon-edit"></span> Salvar Alteração
									</button>
								</div>	
								<div class="col-md-6 ">
									<a class="btn btn-sm btn-success btn-block" href="../cadastrar/" role="button">
										<span class="glyphicon glyphicon-pencil"></span> Nova Atividade
									</a>
								</div>
							';

			$data['sidebar'] = 'col-sm-3 col-md-2';
			$data['main'] = 'col-sm-7 col-md-8';

			$data['q'] = $this->Atividade_model->lista_atividade(TRUE);
			$data['list'] = $this->load->view('atividade/list_atividade', $data, TRUE);

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('Atividade', 'Nome do Atividade', 'required|trim');

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('atividade/pesq_atividade', $data);
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {
					
					$data['query']['Atividade'] = trim(mb_strtoupper($data['query']['Atividade'], 'ISO-8859-1'));

					$data['anterior'] = $this->Atividade_model->get_atividade($data['query']['idApp_Atividade']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Atividade'], TRUE);

					if ($data['auditoriaitem'] && $this->Atividade_model->update_atividade($data['query'], $data['query']['idApp_Atividade']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'atividade/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Atividade', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'atividade/cadastrar/atividade/' . $data['msg']);
						exit();
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }

}
