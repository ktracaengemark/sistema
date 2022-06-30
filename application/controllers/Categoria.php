<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Categoria_model', 'Contatocliente_model'));
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
			#'idTab_Categoria',
            'idSis_Usuario',
            'Categoria',
			#'Abrev',
			'idSis_Empresa',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Categoria', 'Categoria', 'required|trim');
		#$this->form_validation->set_rules('Abrev', 'Abreviação', 'required|trim');

        $data['titulo'] = 'Cadastrar Categoria';
        $data['form_open_path'] = 'categoria/cadastrar';
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

        $data['q'] = $this->Categoria_model->lista_categoria(TRUE);
        $data['list'] = $this->load->view('categoria/list_categoria', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('categoria/pesq_categoria', $data);
		} else {
		
			if($this->Basico_model->get_dt_validade() === FALSE){
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				
			} else {
							
				$data['query']['Categoria'] = trim(mb_strtoupper($data['query']['Categoria'], 'ISO-8859-1'));
				#$data['query']['Abrev'] = trim(mb_strtoupper($data['query']['Abrev'], 'ISO-8859-1'));
				$data['query']['Data_Cad_Categoria'] = date('Y-m-d H:i:s', time());
				$data['query']['NivelCategoria'] = $_SESSION['Usuario']['Nivel'];
				$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
				$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
				$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

				$data['campos'] = array_keys($data['query']);
				$data['anterior'] = array();

				$data['idTab_Categoria'] = $this->Categoria_model->set_categoria($data['query']);

				if ($data['idTab_Categoria'] === FALSE) {
					$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

					$this->basico->erro($msg);
					$this->load->view('categoria/cadastrar', $data);
				} else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Categoria'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Categoria', 'CREATE', $data['auditoriaitem']);
					$data['msg'] = '?m=1';

					redirect(base_url() . 'categoria/cadastrar' . $data['msg']);
					exit();
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
			'idTab_Categoria',
            'Categoria',
		), TRUE));


        if ($id){
            $data['query'] = $this->Categoria_model->get_categoria($id);
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}
		}
		
		if(!$data['query']['idTab_Categoria']){
			
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			$data['titulo'] = 'Editar Categoria';
			$data['form_open_path'] = 'categoria/alterar';
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

			$data['q'] = $this->Categoria_model->lista_categoria(TRUE);
			$data['list'] = $this->load->view('categoria/list_categoria', $data, TRUE);

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('Categoria', 'Categoria', 'required|trim');

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('categoria/pesq_categoria', $data);
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {
							
					$data['query']['Categoria'] = trim(mb_strtoupper($data['query']['Categoria'], 'ISO-8859-1'));

					$data['anterior'] = $this->Categoria_model->get_categoria($data['query']['idTab_Categoria']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Categoria'], TRUE);

					if ($data['auditoriaitem'] && $this->Categoria_model->update_categoria($data['query'], $data['query']['idTab_Categoria']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'categoria/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Categoria', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'categoria/cadastrar/' . $data['msg']);
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
			
            $data['query'] = $this->Categoria_model->get_categoria($id);
			
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
				} else {
					
					$this->Categoria_model->delete_categoria($id);

					$data['msg'] = '?m=1';

					redirect(base_url() . 'categoria/cadastrar/' . $data['msg']);
					exit();
				}
			}
		}
        $this->load->view('basico/footer');
    }

}
