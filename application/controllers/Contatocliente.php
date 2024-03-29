<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Contatocliente extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Contatocliente_model', 'Relacao_model', 'Relacom_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('contatocliente/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('contatocliente/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			//'idApp_ContatoCliente',
			'idSis_Usuario',
			'NomeContatoCliente',
			'StatusVida',
			'DataNascimento',
			'Ativo',
			'Sexo',
			'Relacao',
			//'RelaCom',
			'Telefone1',
			'Obs',
			'idApp_Cliente',
		), TRUE));

		#### Carrega os dados do cliente nas variáves de sessão ####
		if($idApp_Cliente){
			
			$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			
			if($data['cliente'] === FALSE){
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} 
		}
  
		if(!$_SESSION['Cliente']){

			unset($_SESSION['Cliente']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {

			//echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVida']='V';

			$data['select']['Sexo'] = $this->Basico_model->select_sexo();
			$data['select']['StatusVida'] = $this->Contatocliente_model->select_status_vida();
			$data['select']['Relacao'] = $this->Relacao_model->select_relacao();
			//$data['select']['RelaCom'] = $this->Relacom_model->select_relacom();
			$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
			
			$data['titulo'] = 'Contatos e Responsáveis';
			$data['form_open_path'] = 'contatocliente/cadastrar';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 1;
			
			$data['cor_cli'] 	= 'warning';
			$data['cor_cons'] 	= 'default';
			$data['cor_orca'] 	= 'default';
			$data['cor_sac'] 	= 'default';
			$data['cor_mark'] 	= 'default';

			$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('NomeContatoCliente', 'Nome do Contato', 'required|trim');
			$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
			$this->form_validation->set_rules('Telefone1', 'Telefone Principal', 'required|trim');
			$this->form_validation->set_rules('Relacao', 'Relacao', 'required|trim');
			#$this->form_validation->set_rules('RelaCom', 'RelaCom', 'required|trim');
			
			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('contatocliente/form_contatocliente', $data);
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {

					$data['query']['NomeContatoCliente'] = trim(mb_strtoupper($data['query']['NomeContatoCliente'], 'ISO-8859-1'));
					if(!isset($data['query']['DataNascimento']) || $data['query']['DataNascimento'] == ''){
						$data['query']['DataNascimento'] = "0000-00-00";
					}else{
						$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
					}
					$data['query']['Obs'] = nl2br($data['query']['Obs']);
					$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['campos'] = array_keys($data['query']);
					$data['anterior'] = array();

					$data['query']['idApp_ContatoCliente'] = $this->Contatocliente_model->set_contatocliente($data['query']);

					if ($data['query']['idApp_ContatoCliente'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('contatocliente/form_contatocliente', $data);
					} else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ContatoCliente'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoCliente', 'CREATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';

						redirect(base_url() . 'contatocliente/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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
			'idApp_ContatoCliente',

			'NomeContatoCliente',
			'StatusVida',
			'DataNascimento',
			'Sexo',
			'idSis_Usuario',
			'Obs',
			'idApp_Cliente',
			'Relacao',
			//'RelaCom',
			'Telefone1',
			'Ativo',
		), TRUE);

		if ($id) {
			
			$_SESSION['ContatoCliente'] = $data['query'] = $this->Contatocliente_model->get_contatocliente($id);

			if($data['query'] === FALSE){
				unset($_SESSION['ContatoCliente']);
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {				
				$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			}
		}
			
		if(!$data['query']['idApp_ContatoCliente'] || !$_SESSION['ContatoCliente']){
			unset($_SESSION['ContatoCliente']);
			unset($_SESSION['Cliente']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($_SESSION['ContatoCliente']['idApp_Cliente'], TRUE);
		
			if($data['cliente'] === FALSE){
				
				unset($_SESSION['ContatoCliente']);
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {

				$data['select']['Sexo'] = $this->Basico_model->select_sexo();
				$data['select']['StatusVida'] = $this->Contatocliente_model->select_status_vida();
				$data['select']['Relacao'] = $this->Relacao_model->select_relacao();
				$data['select']['RelaCom'] = $this->Relacom_model->select_relacom();       
				$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
				
				$data['titulo'] = 'Editar Dados';
				$data['form_open_path'] = 'contatocliente/alterar';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;
				
				$data['cor_cli'] 	= 'warning';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'default';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';

				$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				$this->form_validation->set_rules('NomeContatoCliente', 'Nome do Responsável', 'required|trim');
				$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
				$this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
				$this->form_validation->set_rules('Relacao', 'Relacao', 'required|trim');
				#$this->form_validation->set_rules('RelaCom', 'RelaCom', 'required|trim');
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('contatocliente/form_contatocliente', $data);
				} else {
		
					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {

						$data['query']['NomeContatoCliente'] = trim(mb_strtoupper($data['query']['NomeContatoCliente'], 'ISO-8859-1'));
						if(!isset($data['query']['DataNascimento']) || $data['query']['DataNascimento'] == ''){
							$data['query']['DataNascimento'] = "0000-00-00";
						}else{
							$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
						}
						$data['query']['Obs'] = nl2br($data['query']['Obs']);
						$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						//$data['query']['idApp_ContatoCliente'] = $_SESSION['log']['idApp_ContatoCliente'];

						$data['anterior'] = $this->Contatocliente_model->get_contatocliente($data['query']['idApp_ContatoCliente']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ContatoCliente'], TRUE);

						if ($data['auditoriaitem'] && $this->Contatocliente_model->update_contatocliente($data['query'], $data['query']['idApp_ContatoCliente']) === FALSE) {
							$data['msg'] = '?m=1';
							redirect(base_url() . 'contatocliente/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoCliente', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'contatocliente/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
							exit();
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

		if (!$id) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($id, TRUE);

			if($data['cliente'] === FALSE){
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {

				if ($this->input->get('start') && $this->input->get('end')) {
					//$data['start'] = substr($this->input->get('start'),0,-3);
					//$data['end'] = substr($this->input->get('end'),0,-3);
					$_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'), 0, -3);
					$_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'), 0, -3);
				}
			
				//$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];

				$data['query'] = $this->Contatocliente_model->lista_contatocliente($id, TRUE);
				/*
				  echo "<pre>";
				  print_r($data['query']);
				  echo "</pre>";
				  exit();
				 */
				if (!$data['query'])
					$data['list'] = FALSE;
				else
					$data['list'] = $this->load->view('contatocliente/list_contatocliente', $data, TRUE);
				
				$data['cor_cli'] 	= 'warning';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'default';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';

				$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

				$this->load->view('contatocliente/tela_contatocliente', $data);
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
			
			$_SESSION['ContatoCliente'] = $data['query'] = $this->Contatocliente_model->get_contatocliente($id);
			
			if($data['query'] === FALSE){
				unset($_SESSION['ContatoCliente']);
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($_SESSION['ContatoCliente']['idApp_Cliente'], TRUE);
			
				if($data['cliente'] === FALSE){
					
					unset($_SESSION['ContatoCliente']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
		
					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {

						$this->Contatocliente_model->delete_contatocliente($id);
						
						unset($_SESSION['ContatoCliente']);

						$data['msg'] = '?m=1';

						redirect(base_url() . 'contatocliente/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
						exit();
					}
				}
			}
		}
		
        $this->load->view('basico/footer');
    }
	
}
