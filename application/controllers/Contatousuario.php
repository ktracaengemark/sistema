<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Contatousuario extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Contatousuario_model', 'Relacao_model', 'Usuario_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

        #$this->load->view('contatousuario/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('contatousuario/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($idSis_Usuario = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$_SESSION['AdminEmpresa']['idSis_Empresa']) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
				
			$data['query'] = quotes_to_entities($this->input->post(array(
				//'idApp_ContatoUsuario',
				//'idSis_Empresa',			
				'NomeContatoUsuario',
				'StatusVida',
				'Ativo',
				'DataNascimento',
				'Sexo',
				'Relacao',
				'TelefoneContatoUsuario',
				'Obs',
				//'idSis_Usuario',
				'QuemCad',
			), TRUE));

			if ($idSis_Usuario) {
				
				$_SESSION['QueryUsuario'] = $data['usuario'] = $this->Usuario_model->get_usuario_verificacao_admin($idSis_Usuario);

				if($data['usuario'] === FALSE){
					
					unset($_SESSION['QueryUsuario']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				}
			}

			if(!$_SESSION['QueryUsuario']){
				
				unset($_SESSION['QueryUsuario']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			} else {

				//echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVida']='V';

				$data['select']['Sexo'] = $this->Basico_model->select_sexo();
				$data['select']['StatusVida'] = $this->Contatousuario_model->select_status_vida();
				$data['select']['Relacao'] = $this->Relacao_model->select_relacao();
				$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
				
				$data['titulo'] = 'Cadastrar Contato';
				$data['form_open_path'] = 'contatousuario/cadastrar';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 1;

				$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				$this->form_validation->set_rules('NomeContatoUsuario', 'Nome do Contato', 'required|trim');
				$this->form_validation->set_rules('Obs', 'Obs', 'trim');
				$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
				$this->form_validation->set_rules('TelefoneContatoUsuario', 'Telefone Principal', 'required|trim');
				$this->form_validation->set_rules('Relacao', 'Relacao', 'required|trim'); 
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('contatousuario/form_contatousuario', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
					} else {

						$data['query']['NomeContatoUsuario'] = trim(mb_strtoupper($data['query']['NomeContatoUsuario'], 'ISO-8859-1'));
						if(!isset($data['query']['DataNascimento']) || $data['query']['DataNascimento'] == ''){
							$data['query']['DataNascimento'] = "0000-00-00";
						}else{
							$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
						}
						$data['query']['Obs'] = nl2br($data['query']['Obs']);
						$data['query']['idSis_Empresa'] = $_SESSION['AdminEmpresa']['idSis_Empresa'];
						$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
						$data['query']['QuemCad'] = $_SESSION['log']['idSis_Usuario'];
						$data['query']['idSis_Usuario'] = $_SESSION['QueryUsuario']['idSis_Usuario'];
						$data['campos'] = array_keys($data['query']);
						$data['anterior'] = array();

						$data['query']['idApp_ContatoUsuario'] = $this->Contatousuario_model->set_contatousuario($data['query']);

						if ($data['query']['idApp_ContatoUsuario'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('contatousuario/form_contatousuario', $data);
						} else {

							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ContatoUsuario'], FALSE);
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoUsuario', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';

							redirect(base_url() . 'contatousuario/pesquisar/' . $_SESSION['QueryUsuario']['idSis_Usuario'] . $data['msg']);
							#redirect(base_url() . 'usuario/prontuario/' . $_SESSION['QueryUsuario']['idSis_Usuario'] . $data['msg']);
							exit();
						}
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

		if (!$_SESSION['AdminEmpresa']['idSis_Empresa']) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
			
			$data['query'] = $this->input->post(array(
				'idApp_ContatoUsuario',
				//'idSis_Empresa',
				'NomeContatoUsuario',
				'StatusVida',
				'DataNascimento',
				'Sexo',
				'Relacao',
				'TelefoneContatoUsuario',
				'Obs',
				//'idSis_Usuario',
				'Ativo',
					), TRUE);

			if ($id) {
				
				$_SESSION['ContatoUsuario'] = $data['query'] = $this->Contatousuario_model->get_contatousuario($id);
				
				if($data['query'] === FALSE){
					
					unset($_SESSION['ContatoUsuario']);
					unset($_SESSION['QueryUsuario']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {				
					$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
				}
			}
			
			if(!$data['query']['idApp_ContatoUsuario'] || !$_SESSION['ContatoUsuario']){
				
				unset($_SESSION['ContatoUsuario']);
				unset($_SESSION['QueryUsuario']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			} else {
				
				$_SESSION['QueryUsuario'] = $data['usuario'] = $this->Usuario_model->get_usuario_verificacao_admin($_SESSION['ContatoUsuario']['idSis_Usuario']);

				if($data['usuario'] === FALSE){
					
					unset($_SESSION['ContatoUsuario']);
					unset($_SESSION['QueryUsuario']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				}else{
					
					$data['select']['Sexo'] = $this->Basico_model->select_sexo();
					$data['select']['StatusVida'] = $this->Contatousuario_model->select_status_vida();
					$data['select']['Relacao'] = $this->Relacao_model->select_relacao();
					$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
					
					$data['titulo'] = 'Editar Dados';
					$data['form_open_path'] = 'contatousuario/alterar';
					$data['readonly'] = '';
					$data['disabled'] = '';
					$data['panel'] = 'primary';
					$data['metodo'] = 2;

					$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

					$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

					$this->form_validation->set_rules('NomeContatoUsuario', 'Nome do Contato', 'required|trim');
					$this->form_validation->set_rules('Obs', 'Obs', 'trim');
					$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
					$this->form_validation->set_rules('TelefoneContatoUsuario', 'Telefone Principal', 'required|trim');
					$this->form_validation->set_rules('Relacao', 'Relacao', 'required|trim');
					
					#run form validation
					if ($this->form_validation->run() === FALSE) {
						$this->load->view('contatousuario/form_contatousuario', $data);
					} else {

						if($this->Basico_model->get_dt_validade() === FALSE){
							$data['msg'] = '?m=3';
							redirect(base_url() . 'acessoempresa' . $data['msg']);
						} else {

							$data['query']['NomeContatoUsuario'] = trim(mb_strtoupper($data['query']['NomeContatoUsuario'], 'ISO-8859-1'));
							$data['query']['Obs'] = nl2br($data['query']['Obs']);
							
							if(!isset($data['query']['DataNascimento']) || $data['query']['DataNascimento'] == ''){
								$data['query']['DataNascimento'] = "0000-00-00";
							}else{
								$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
							}

							$data['anterior'] = $this->Contatousuario_model->get_contatousuario($data['query']['idApp_ContatoUsuario']);
							$data['campos'] = array_keys($data['query']);

							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ContatoUsuario'], TRUE);

							if ($data['auditoriaitem'] && $this->Contatousuario_model->update_contatousuario($data['query'], $data['query']['idApp_ContatoUsuario']) === FALSE) {
								$data['msg'] = '?m=1';
								redirect(base_url() . 'usuario/prontuario/' . $_SESSION['QueryUsuario']['idSis_Usuario'] . $data['msg']);
								exit();
							} else {

								if ($data['auditoriaitem'] === FALSE) {
									$data['msg'] = '';
								} else {
									$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoUsuario', 'UPDATE', $data['auditoriaitem']);
									$data['msg'] = '?m=1';
								}

								redirect(base_url() . 'contatousuario/pesquisar/' . $_SESSION['QueryUsuario']['idSis_Usuario'] . $data['msg']);
								exit();
							}
						}
					}
				}
			}	
		}
        $this->load->view('basico/footer');
    }
	
    public function pesquisar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$_SESSION['AdminEmpresa']['idSis_Empresa']) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
						
			if (!$id) {
					
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			}else{		
				
				$_SESSION['QueryUsuario'] = $data['query'] = $this->Usuario_model->get_usuario_verificacao_admin($id, TRUE);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryUsuario']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {

					$data['contatousuario'] = $this->Contatousuario_model->lista_contatousuario($id, TRUE);
					/*
					  echo "<pre>";
					  print_r($data['contatousuario']);
					  echo "</pre>";
					  exit();
					 */
					if (!$data['contatousuario'])
						$data['list'] = FALSE;
					else
						$data['list'] = $this->load->view('contatousuario/list_contatousuario', $data, TRUE);
					
					
					$data['titulo'] = 'Contatos';
					
					$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

					$this->load->view('contatousuario/tela_contatousuario', $data);
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

		if (!$_SESSION['AdminEmpresa']['idSis_Empresa']) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
						
			if (!$id) {
					
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			}else{		

				$_SESSION['ContatoUsuario'] = $data['query'] = $this->Contatousuario_model->get_contatousuario($id);
				
				if($data['query'] === FALSE){
					
					unset($_SESSION['ContatoUsuario']);
					unset($_SESSION['QueryUsuario']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {				

					$_SESSION['QueryUsuario'] = $data['usuario'] = $this->Usuario_model->get_usuario_verificacao_admin($_SESSION['ContatoUsuario']['idSis_Usuario']);

					if($data['usuario'] === FALSE){
						
						unset($_SESSION['ContatoUsuario']);
						unset($_SESSION['QueryUsuario']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
						exit();
						
					}else{

						if($this->Basico_model->get_dt_validade() === FALSE){
							$data['msg'] = '?m=3';
							redirect(base_url() . 'acessoempresa' . $data['msg']);
						} else {

							$this->Contatousuario_model->delete_contatousuario($id);
							
							unset($_SESSION['ContatoUsuario']);
							$data['msg'] = '?m=1';

							redirect(base_url() . 'contatousuario/pesquisar/' . $_SESSION['QueryUsuario']['idSis_Usuario'] . $data['msg']);
							exit();
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }

}
