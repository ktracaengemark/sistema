<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Fornecedor extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Fornecedor_model', 'Atividade_model', 'Contatofornec_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('fornecedor/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('fornecedor/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'Cadastrar',
			), TRUE));
				
			$data['query'] = quotes_to_entities($this->input->post(array(
				//'idApp_Fornecedor',
				'NomeFornecedor',
				//'DataNascimento',
				'DataCadastroFornecedor',
				'Atividade',
				'CelularFornecedor',
				'Telefone1',
				'Telefone2',
				'Telefone3',
				'Ativo',
				'Sexo',
				'CepFornecedor',
				'EnderecoFornecedor',
				'NumeroFornecedor',
				'ComplementoFornecedor',
				'BairroFornecedor',
				'CidadeFornecedor',
				'EstadoFornecedor',
				'ReferenciaFornecedor',
				//'MunicipioFornecedor',
				'Obs',
				'Email',
				'idSis_Usuario',
				'Cnpj',
				'TipoFornec',
				'VendaFornec',
			), TRUE));

			$caracteres_sem_acento = array(
				'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
				'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
				'Ï'=>'I', 'Ñ'=>'N', 'N'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
				'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
				'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
				'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'n'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
				'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
				'a'=>'a', 'î'=>'i', 'â'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', 'Î'=>'I', 'Â'=>'A', '?'=>'S', '?'=>'T',
			);

			$fornecedor1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['NomeFornecedor'], $caracteres_sem_acento));		
				
			(!$data['query']['DataCadastroFornecedor']) ? $data['query']['DataCadastroFornecedor'] = date('d/m/Y', time()) : FALSE;
			(!$data['query']['TipoFornec']) ? $data['query']['TipoFornec'] = 'P' : FALSE;
			(!$data['query']['VendaFornec']) ? $data['query']['VendaFornec'] = 'S' : FALSE;
				
			$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();		
			//$data['select']['MunicipioFornecedor'] = $this->Basico_model->select_municipio();
			$data['select']['Sexo'] = $this->Basico_model->select_sexo();
			$data['select']['Atividade'] = $this->Atividade_model->select_atividade();
			$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
			$data['select']['VendaFornec'] = $this->Basico_model->select_status_sn();
			$data['select']['TipoFornec'] = $this->Basico_model->select_tipofornec();
			
			
			$data['titulo'] = 'Cadastrar Fornecedor';
			$data['form_open_path'] = 'fornecedor/cadastrar';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 1;

			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
			$data['radio'] = array(
				'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
			);
			($data['cadastrar']['Cadastrar'] == 'N') ?
				$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
			
			if ($data['query']['Sexo'] || $data['query']['EnderecoFornecedor'] || $data['query']['BairroFornecedor'] || 
				$data['query']['Obs'] || $data['query']['Email'] || $data['query']['Cnpj'])
				$data['collapse'] = '';
			else 
				$data['collapse'] = 'class="collapse"';            
			
			$data['sidebar'] = 'col-sm-3 col-md-2';
			$data['main'] = 'col-sm-7 col-md-8';        

			$data['tela'] = $this->load->view('fornecedor/form_fornecedor', $data, TRUE);

			$data['q_atividade'] = $this->Fornecedor_model->list_atividade($_SESSION['log'], TRUE);
			$data['list_atividade'] = $this->load->view('fornecedor/list_atividade', $data, TRUE);
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			#$this->form_validation->set_rules('NomeFornecedor', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Fornecedor.NomeFornecedor.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
			$this->form_validation->set_rules('NomeFornecedor', 'Fornecedor', 'required|trim');
			//$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
			#$this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
			#$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
			#$this->form_validation->set_rules('Atividade', 'Atividade', 'required|trim');
			$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posiçao "Sim"', 'trim|valid_aprovado');	
			
			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('fornecedor/form_fornecedor', $data);        
			} else {
			
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {

					$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

					$data['query']['NomeFornecedor'] = trim(mb_strtoupper($fornecedor1, 'ISO-8859-1'));
					$data['query']['EnderecoFornecedor'] = trim(mb_strtoupper($data['query']['EnderecoFornecedor'], 'ISO-8859-1'));
					$data['query']['NumeroFornecedor'] = trim(mb_strtoupper($data['query']['NumeroFornecedor'], 'ISO-8859-1'));
					$data['query']['ComplementoFornecedor'] = trim(mb_strtoupper($data['query']['ComplementoFornecedor'], 'ISO-8859-1'));
					$data['query']['BairroFornecedor'] = trim(mb_strtoupper($data['query']['BairroFornecedor'], 'ISO-8859-1'));
					$data['query']['CidadeFornecedor'] = trim(mb_strtoupper($data['query']['CidadeFornecedor'], 'ISO-8859-1'));
					$data['query']['EstadoFornecedor'] = trim(mb_strtoupper($data['query']['EstadoFornecedor'], 'ISO-8859-1'));
					$data['query']['ReferenciaFornecedor'] = trim(mb_strtoupper($data['query']['ReferenciaFornecedor'], 'ISO-8859-1'));
					/*
					if(!isset($data['query']['DataNascimento']) || $data['query']['DataNascimento'] == ''){
						$data['query']['DataNascimento'] = "0000-00-00";
					}else{
						$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
					}
					*/
					$data['query']['DataCadastroFornecedor'] = $this->basico->mascara_data($data['query']['DataCadastroFornecedor'], 'mysql');
					$data['query']['Obs'] = nl2br($data['query']['Obs']);
					#$data['query']['TipoFornec'] = $data['query']['TipoFornec'];
					$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['campos'] = array_keys($data['query']);
					$data['anterior'] = array();

					$data['query']['idApp_Fornecedor'] = $this->Fornecedor_model->set_fornecedor($data['query']);

					if ($data['query']['idApp_Fornecedor'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('fornecedor/form_fornecedor', $data);
					} else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Fornecedor'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Fornecedor', 'CREATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';

						redirect(base_url() . 'fornecedor/prontuario/' . $data['query']['idApp_Fornecedor'] . $data['msg']);
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
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));

        $data['query'] = $this->input->post(array(
            'idApp_Fornecedor',
            'NomeFornecedor',
            //'DataNascimento',
			#'DataCadastroFornecedor',
            'Atividade',
            'CelularFornecedor',
            'Telefone1',
            'Telefone2',
            'Telefone3',
            'Ativo',
            'Sexo',
            'CepFornecedor',
            'EnderecoFornecedor',
            'NumeroFornecedor',
            'ComplementoFornecedor',
            'BairroFornecedor',
            'CidadeFornecedor',
            'EstadoFornecedor',
            'ReferenciaFornecedor',
            //'MunicipioFornecedor',
            'Obs',
            'idSis_Usuario',
            'Email',
            'Cnpj',
			#'TipoFornec',
			#'VendaFornec',
        ), TRUE);

        if ($id) {
            $_SESSION['Fornecedor'] = $data['query'] = $this->Fornecedor_model->get_fornecedor($id);
		
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				//$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
				#$data['query']['DataCadastroFornecedor'] = $this->basico->mascara_data($data['query']['DataCadastroFornecedor'], 'barras');
			}
		}
		
		if(!$data['query']['idApp_Fornecedor'] || !$_SESSION['Fornecedor']){
			
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			$caracteres_sem_acento = array(
				'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
				'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
				'Ï'=>'I', 'Ñ'=>'N', 'N'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
				'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
				'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
				'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'n'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
				'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
				'a'=>'a', 'î'=>'i', 'â'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', 'Î'=>'I', 'Â'=>'A', '?'=>'S', '?'=>'T',
			);

			$fornecedor1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['NomeFornecedor'], $caracteres_sem_acento));		
			
			#(!$data['query']['DataCadastroFornecedor']) ? $data['query']['DataCadastroFornecedor'] = date('d/m/Y', time()) : FALSE;
			#(!$data['query']['TipoFornec']) ? $data['query']['TipoFornec'] = 'P' : FALSE;
			#(!$data['query']['VendaFornec']) ? $data['query']['VendaFornec'] = 'S' : FALSE;

			$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();		
			//$data['select']['MunicipioFornecedor'] = $this->Basico_model->select_municipio();
			$data['select']['Sexo'] = $this->Basico_model->select_sexo();
			$data['select']['Atividade'] = $this->Atividade_model->select_atividade();
			$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
			$data['select']['VendaFornec'] = $this->Basico_model->select_status_sn();
			$data['select']['TipoFornec'] = $this->Basico_model->select_tipofornec();
			
			$data['titulo'] = 'Editar Dados';
			$data['form_open_path'] = 'fornecedor/alterar';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 2;
			
			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
			$data['radio'] = array(
				'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
			);
			($data['cadastrar']['Cadastrar'] == 'N') ?
				$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
			if ($data['query']['Sexo'] || $data['query']['EnderecoFornecedor'] || $data['query']['BairroFornecedor'] || 
				$data['query']['Obs'] || $data['query']['Email'] || $data['query']['Cnpj'])
				$data['collapse'] = '';
			else 
				$data['collapse'] = 'class="collapse"';        

			$data['nav_secundario'] = $this->load->view('fornecedor/nav_secundario', $data, TRUE);

			$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
			$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

			$data['q_atividade'] = $this->Fornecedor_model->list_atividade($_SESSION['log'], TRUE);
			$data['list_atividade'] = $this->load->view('fornecedor/list_atividade', $data, TRUE);
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('NomeFornecedor', 'Fornecedor', 'required|trim');
			#$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
			#$this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
			#$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
			#$this->form_validation->set_rules('Atividade', 'Atividade', 'required|trim'); 
			$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posiçao "Sim"', 'trim|valid_aprovado');		
			
			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('fornecedor/form_fornecedor', $data);
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {

					$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

					$data['query']['NomeFornecedor'] = trim(mb_strtoupper($fornecedor1, 'ISO-8859-1'));
					$data['query']['EnderecoFornecedor'] = trim(mb_strtoupper($data['query']['EnderecoFornecedor'], 'ISO-8859-1'));
					$data['query']['NumeroFornecedor'] = trim(mb_strtoupper($data['query']['NumeroFornecedor'], 'ISO-8859-1'));
					$data['query']['ComplementoFornecedor'] = trim(mb_strtoupper($data['query']['ComplementoFornecedor'], 'ISO-8859-1'));
					$data['query']['BairroFornecedor'] = trim(mb_strtoupper($data['query']['BairroFornecedor'], 'ISO-8859-1'));
					$data['query']['CidadeFornecedor'] = trim(mb_strtoupper($data['query']['CidadeFornecedor'], 'ISO-8859-1'));
					$data['query']['EstadoFornecedor'] = trim(mb_strtoupper($data['query']['EstadoFornecedor'], 'ISO-8859-1'));
					$data['query']['ReferenciaFornecedor'] = trim(mb_strtoupper($data['query']['ReferenciaFornecedor'], 'ISO-8859-1'));
					//$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
					#$data['query']['DataCadastroFornecedor'] = $this->basico->mascara_data($data['query']['DataCadastroFornecedor'], 'mysql');
					$data['query']['Obs'] = nl2br($data['query']['Obs']);
					#$data['query']['TipoFornec'] = $data['query']['TipoFornec'];
					$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];          

					$data['anterior'] = $this->Fornecedor_model->get_fornecedor($data['query']['idApp_Fornecedor']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Fornecedor'], TRUE);

					if ($data['auditoriaitem'] && $this->Fornecedor_model->update_fornecedor($data['query'], $data['query']['idApp_Fornecedor']) === FALSE) {
						$data['msg'] = '?m=1';
						redirect(base_url() . 'fornecedor/prontuario/' . $data['query']['idApp_Fornecedor'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Fornecedor', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'fornecedor/prontuario/' . $data['query']['idApp_Fornecedor'] . $data['msg']);
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
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{		
			
			$data['query'] = $this->Fornecedor_model->get_fornecedor($id, TRUE);
		
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {

					$this->Fornecedor_model->delete_fornecedor($data['query']['idApp_Fornecedor']);
					unset($_SESSION['Fornecedor']);
					$data['msg'] = '?m=1';
					redirect(base_url() . 'relatorio/fornecedor');
					exit();
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_fornecedor');
			
			if ($this->input->get('start') && $this->input->get('end')) {
				//$data['start'] = substr($this->input->get('start'),0,-3);
				//$data['end'] = substr($this->input->get('end'),0,-3);
				$_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
				$_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);            
			}
			
			$data['titulo'] = "Pesquisar Fornecedor";
			
			$data['Pesquisa'] = $this->input->post('Pesquisa');
			//echo date('d/m/Y H:i:s', $data['start'],0,-3));
			
			#run form validation
			if ($this->form_validation->run() !== FALSE && $this->Fornecedor_model->lista_fornecedor($data['Pesquisa'], FALSE) === TRUE) {

				$data['query'] = $this->Fornecedor_model->lista_fornecedor($data['Pesquisa'], TRUE);
				
				if ($data['query']->num_rows() == 1) {
					$info = $data['query']->result_array();
					
					if ($_SESSION['agenda']) 
						redirect('consulta/cadastrar/' . $info[0]['idApp_Fornecedor'] );
					else
						redirect('fornecedor/prontuario/' . $info[0]['idApp_Fornecedor'] );
					
					exit();
				} else {
					$data['list'] = $this->load->view('fornecedor/list_fornecedor', $data, TRUE);
				}
			   
			}
		   
			($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

			$this->load->view('fornecedor/pesq_fornecedor', $data);
		}
        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{		
			
			$_SESSION['Fornecedor'] = $data['query'] = $this->Fornecedor_model->get_fornecedor($id, TRUE);
		
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {

				$data['titulo'] = 'Prontuário ' . $data['query']['NomeFornecedor'];
				$data['panel'] = 'primary';
				$data['metodo'] = 4;
				
				$_SESSION['log']['idApp_Fornecedor'] = $data['resumo']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
				$data['resumo']['NomeFornecedor'] = $data['query']['NomeFornecedor'];

				$data['query']['Idade'] = $this->basico->calcula_idade($data['query']['DataNascimento']);
				$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
				
				if ($data['query']['Sexo'] == 1)
					$data['query']['profile'] = 'm';
				elseif ($data['query']['Sexo'] == 2)
					$data['query']['profile'] = 'f';
				else
					$data['query']['profile'] = 'o';
				
				$data['query']['Sexo'] = $this->Basico_model->get_sexo($data['query']['Sexo']);
				
				$data['query']['Atividade'] = $this->Basico_model->get_atividade($data['query']['Atividade']);
				$data['query']['TipoFornec'] = $this->Basico_model->get_tipofornec($data['query']['TipoFornec']);
				$data['query']['VendaFornec'] = $this->Basico_model->get_vendafornec($data['query']['VendaFornec']);
				$data['query']['Ativo'] = $this->Basico_model->get_ativo($data['query']['Ativo']);
				
				$data['query']['Telefone'] = $data['query']['Telefone1'];
				($data['query']['Telefone2']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone2'] : FALSE;
				($data['query']['Telefone3']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone3'] : FALSE;
				
				
				if ($data['query']['MunicipioFornecedor']) {
					$mun = $this->Basico_model->get_municipio($data['query']['MunicipioFornecedor']);
					$data['query']['MunicipioFornecedor'] = $mun['NomeMunicipio'] . '/' . $mun['Uf'];
				} else {
					$data['query']['MunicipioFornecedor'] = $data['query']['UfFornecedor'] = $mun['Uf'] = '';
				}

				$data['contatofornec'] = $this->Contatofornec_model->lista_contatofornec($id, TRUE);
				/*
				  echo "<pre>";
				  print_r($data['contatofornec']);
				  echo "</pre>";
				  exit();
				*/
				if (!$data['contatofornec'])
					$data['list'] = FALSE;
				else
					$data['list'] = $this->load->view('contatofornec/list_contatofornec', $data, TRUE);
				
				$data['nav_secundario'] = $this->load->view('fornecedor/nav_secundario', $data, TRUE);     
				$this->load->view('fornecedor/tela_fornecedor', $data);
			}
		}
        $this->load->view('basico/footer');
    }

    function get_fornecedor($data) {

        if ($this->Fornecedor_model->lista_fornecedor($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_fornecedor', '<strong>Fornecedor</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
