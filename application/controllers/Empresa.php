<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Empresa_model'));
        #$this->load->model(array('Basico_model', 'Empresa_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

        #$this->load->view('empresa/nav_secundario');
    }

    public function index() {

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
			
			$this->load->view('empresa/tela_index', $data);
		}
       
        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

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
				
				$_SESSION['QueryEmpresa'] = $data['query'] = $this->Empresa_model->get_empresa_verificacao($id, TRUE);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryEmpresa']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {
					
					$data['titulo'] = $_SESSION['AdminEmpresa']['NomeEmpresa'] ;
					$data['panel'] = 'primary';
					$data['metodo'] = 4;

					$_SESSION['log']['idSis_Empresa'] = $data['resumo']['idSis_Empresa'] = $data['query']['idSis_Empresa'];
					$data['resumo']['NomeAdmin'] = $data['query']['NomeAdmin'];

					$data['query']['Idade'] = $this->basico->calcula_idade($data['query']['DataCriacao']);
					$data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'barras');


					$data['query']['Inativo'] = $this->Basico_model->get_inativo($data['query']['Inativo']);
					$data['query']['Empresa'] = $this->Basico_model->get_empresa($data['query']['NomeEmpresa']);
					$data['query']['CategoriaEmpresa'] = $this->Basico_model->get_categoriaempresa($data['query']['CategoriaEmpresa']);


					$data['query']['Telefone'] = $data['query']['CelularAdmin'];

					$data['contatoempresa'] = $this->Empresa_model->lista_contatoempresa($id, TRUE);
					/*
					  echo "<pre>";
					  print_r($data['contatoempresa']);
					  echo "</pre>";
					  exit();
					  */
					if (!$data['contatoempresa'])
						$data['list'] = FALSE;
					else
						$data['list'] = $this->load->view('empresa/list_contatoempresa', $data, TRUE);
			
					$data['cor_cli'] 	= 'warning';
					$data['cor_cons'] 	= 'default';
					$data['cor_orca'] 	= 'default';
					$data['cor_sac'] 	= 'default';
					$data['cor_mark'] 	= 'default';
				
					$data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);
					
					$this->load->view('empresa/tela_empresa', $data);
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

				'idSis_Empresa',
				#'UsuarioEmpresa',
				'NomeEmpresa',
				'NomeAdmin',
				'DataNascimento',
				#'CelularAdmin',
				'Email',
				'Cnpj',
				'InscEstadual',
				'EnderecoEmpresa',
				'NumeroEmpresa',
				'ComplementoEmpresa',
				'BairroEmpresa',
				'MunicipioEmpresa',
				'EstadoEmpresa',
				'CepEmpresa',
				'Telefone',
				'Atuacao',
				#'Sexo',
				#'Inativo',
				'CategoriaEmpresa',
				#'Site',
				#'Senha',
				'EComerce',
				'RetirarLoja',
				'MotoBoy',
				'Correios',
				'NaLoja',
				'NaEntrega',
				'OnLine',
				'Boleto',
				'Debito',
				'Cartao',
				#'Atendimento',
				#'SobreNos',
				'ValorMinimo',
				'TaxaEntrega',
				'CadastrarPet',
				'CadastrarDep',
				'TipoBoleto',
				'BancoEmpresa',
				'AgenciaEmpresa',
				'ContaEmpresa',
				'PixEmpresa',
				'AssociadoAtivo',
				'CashBackAtivo',
				'PrazoCashBackEmpresa',
			), TRUE);

			if ($id) {
				
				$_SESSION['QueryEmpresa'] = $data['query'] = $this->Empresa_model->get_empresa_verificacao($id, TRUE);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryEmpresa']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {
					$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
				}
			}
			
			if(!$data['query']['idSis_Empresa'] || !$_SESSION['QueryEmpresa']){
				
				unset($_SESSION['QueryEmpresa']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			} else {

				$data['select']['MunicipioEmpresa'] = $this->Basico_model->select_municipio();
				$data['select']['CategoriaEmpresa'] = $this->Basico_model->select_categoriaempresa();
				$data['select']['EComerce'] = $this->Basico_model->select_status_sn();
				$data['select']['RetirarLoja'] = $this->Basico_model->select_status_sn();
				$data['select']['MotoBoy'] = $this->Basico_model->select_status_sn();
				$data['select']['Correios'] = $this->Basico_model->select_status_sn();
				$data['select']['CadastrarPet'] = $this->Basico_model->select_status_sn();
				$data['select']['CadastrarDep'] = $this->Basico_model->select_status_sn();
				$data['select']['TipoBoleto'] = array(
					'L' => 'Da Loja',
					'P' => 'Pag Seguro',
				);
				$data['select']['NaLoja'] = $this->Basico_model->select_status_sn();
				$data['select']['NaEntrega'] = $this->Basico_model->select_status_sn();
				$data['select']['OnLine'] = $this->Basico_model->select_status_sn();
				
				$data['select']['Boleto'] = $this->Basico_model->select_status_sn();
				$data['select']['Debito'] = $this->Basico_model->select_status_sn();
				$data['select']['Cartao'] = $this->Basico_model->select_status_sn();
				
				$data['select']['CashBackAtivo'] = $this->Basico_model->select_status_sn();
				$data['select']['AssociadoAtivo'] = $this->Basico_model->select_status_sn();
				#$data['select']['Sexo'] = $this->Basico_model->select_sexo();
				#$data['select']['Empresa'] = $this->Basico_model->select_status_sn();
				#$data['select']['Inativo'] = $this->Basico_model->select_inativo();

				$data['titulo'] = 'Editar Empresa';
				$data['form_open_path'] = 'empresa/alterar';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				if ($data['query']['EnderecoEmpresa'] || $data['query']['BairroEmpresa'] ||
					$data['query']['MunicipioEmpresa'] || $data['query']['CepEmpresa'])
					$data['collapse'] = '';
				else
					$data['collapse'] = 'class="collapse"';

				(!$data['query']['CadastrarPet']) ? $data['query']['CadastrarPet'] = 'N' : FALSE;
				$data['radio'] = array(
					'CadastrarPet' => $this->basico->radio_checked($data['query']['CadastrarPet'], 'E-Comerce', 'NS'),
				);
				($data['query']['CadastrarPet'] == 'N') ?
					$data['div']['CadastrarPet'] = '' : $data['div']['CadastrarPet'] = 'style="display: none;"';

				(!$data['query']['CadastrarDep']) ? $data['query']['CadastrarDep'] = 'N' : FALSE;
				$data['radio'] = array(
					'CadastrarDep' => $this->basico->radio_checked($data['query']['CadastrarDep'], 'E-Comerce', 'NS'),
				);
				($data['query']['CadastrarDep'] == 'N') ?
					$data['div']['CadastrarDep'] = '' : $data['div']['CadastrarDep'] = 'style="display: none;"';
					
				(!$data['query']['EComerce']) ? $data['query']['EComerce'] = 'S' : FALSE;
				$data['radio'] = array(
					'EComerce' => $this->basico->radio_checked($data['query']['EComerce'], 'E-Comerce', 'NS'),
				);
				($data['query']['EComerce'] == 'S') ?
					$data['div']['EComerce'] = '' : $data['div']['EComerce'] = 'style="display: none;"';
					
				(!$data['query']['OnLine']) ? $data['query']['OnLine'] = 'S' : FALSE;
				$data['radio'] = array(
					'OnLine' => $this->basico->radio_checked($data['query']['OnLine'], 'OnLine', 'NS'),
				);
				($data['query']['OnLine'] == 'S') ?
					$data['div']['OnLine'] = '' : $data['div']['OnLine'] = 'style="display: none;"';			
				
				(!$data['query']['Boleto']) ? $data['query']['Boleto'] = 'S' : FALSE;
				$data['radio'] = array(
					'Boleto' => $this->basico->radio_checked($data['query']['Boleto'], 'Boleto', 'NS'),
				);
				($data['query']['Boleto'] == 'S') ?
					$data['div']['Boleto'] = '' : $data['div']['Boleto'] = 'style="display: none;"';		
				
					
				(!$data['query']['AssociadoAtivo']) ? $data['query']['AssociadoAtivo'] = 'N' : FALSE;
				$data['radio'] = array(
					'AssociadoAtivo' => $this->basico->radio_checked($data['query']['AssociadoAtivo'], 'E-Comerce', 'NS'),
				);
				($data['query']['AssociadoAtivo'] == 'S') ?
					$data['div']['AssociadoAtivo'] = '' : $data['div']['AssociadoAtivo'] = 'style="display: none;"';
					
					
				(!$data['query']['CashBackAtivo']) ? $data['query']['CashBackAtivo'] = 'N' : FALSE;
				$data['radio'] = array(
					'CashBackAtivo' => $this->basico->radio_checked($data['query']['CashBackAtivo'], 'E-Comerce', 'NS'),
				);
				($data['query']['CashBackAtivo'] == 'S') ?
					$data['div']['CashBackAtivo'] = '' : $data['div']['CashBackAtivo'] = 'style="display: none;"';
					
					
				$data['cor_cli'] 	= 'warning';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'default';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';

				$data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

				$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
				$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				#$this->form_validation->set_rules('NomeAdmin', 'NomeAdmin do Responsável', 'required|trim|is_unique_duplo[Sis_Empresa.NomeAdmin.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
				$this->form_validation->set_rules('NomeEmpresa', 'Nome da Empresa', 'required|trim');
				$this->form_validation->set_rules('NomeAdmin', 'NomeAdmin do Responsável', 'required|trim');
				#$this->form_validation->set_rules('Site', 'Site', 'trim|is_unique[Sis_Empresa.Site]');
				$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
				#$this->form_validation->set_rules('CelularAdmin', 'Celular', 'required|trim');
				//$this->form_validation->set_rules('CelularAdmin', 'Celular do Admin', 'required|trim|is_unique_by_id_empresa[Sis_Empresa.CelularAdmin.' . $data['query']['idSis_Empresa'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
				$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
				#$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
				#$this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
				$this->form_validation->set_rules('CategoriaEmpresa', 'CategoriaEmpresa', 'required|trim');		
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('empresa/form_empresa', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
					} else {

						if($data['query']['CadastrarPet'] == 'S'){
							$data['query']['CadastrarDep'] = 'N';
						}
						$data['query']['NomeEmpresa'] = trim(mb_strtoupper($data['query']['NomeEmpresa'], 'ISO-8859-1'));
						$data['query']['NomeAdmin'] = trim(mb_strtoupper($data['query']['NomeAdmin'], 'ISO-8859-1'));
						#$data['query']['Senha'] = md5($data['query']['Senha']);            
						$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
						if(!isset($data['query']['DataNascimento']) || empty($data['query']['DataNascimento'])){
							$data['query']['DataNascimento'] = "0000-00-00";
						}
						$data['query']['ValorMinimo'] = str_replace(',', '.', str_replace('.', '', $data['query']['ValorMinimo']));
						$data['query']['TaxaEntrega'] = str_replace(',', '.', str_replace('.', '', $data['query']['TaxaEntrega']));
						#$data['query']['Obs'] = nl2br($data['query']['Obs']);
						#$data['query']['Empresa'] = $_SESSION['log']['idSis_Empresa'];

						$data['anterior'] = $this->Empresa_model->get_empresa($data['query']['idSis_Empresa']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

						if ($data['auditoriaitem'] && $this->Empresa_model->update_empresa($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'empresa/form_empresa/' . $data['query']['idSis_Empresa'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'empresa/prontuario/' . $data['query']['idSis_Empresa'] . $data['msg']);
							exit();
						}
					}	
				}
			}
			
		}
		$this->load->view('basico/footer');
    }
	
    public function alterarlogo($id = FALSE) {

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
				'idSis_Empresa',
			), TRUE);
			
			$data['file'] = $this->input->post(array(
				'idSis_Empresa',
				'Arquivo',
			), TRUE);

			if ($id) {
				
				$_SESSION['QueryEmpresa'] = $data['query'] = $this->Empresa_model->get_empresa_verificacao($id, TRUE);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryEmpresa']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {
					#$data['file']['idSis_Empresa'] = $id;
				}
			}
			
			if(!$data['query']['idSis_Empresa'] || !$_SESSION['QueryEmpresa']){
				
				unset($_SESSION['QueryEmpresa']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			} else {

				$data['file']['idSis_Empresa'] = $data['query']['idSis_Empresa'];
			
				$data['titulo'] = 'Alterar Logo';
				$data['form_open_path'] = 'empresa/alterarlogo';
				$data['readonly'] = 'readonly';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;
					
				$data['cor_cli'] 	= 'warning';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'default';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';

				$data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
					
					$data['file']['Arquivo'] = $this->basico->renomeiaempresa($_FILES['Arquivo']['name']);
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
				} else {
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
				}

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					#load login view
					$this->load->view('empresa/form_logo', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
					} else {

						$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/original/';
						$config['max_size'] = 1000;
						$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
						$config['file_name'] = $data['file']['Arquivo'];

						$this->load->library('upload', $config);
						
						if (!$this->upload->do_upload('Arquivo')) {
							$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
							$this->load->view('empresa/form_logo', $data);
						} else {

							//$diretorio = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/miniatura/';
							$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/original/';		
							$foto = $data['file']['Arquivo'];
							$diretorio = $dir.$foto;					
							$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/miniatura/';

							switch($_FILES['Arquivo']['type']):
								case 'image/jpg';
								case 'image/jpeg';
								case 'image/pjpeg';
							
									list($largura, $altura, $tipo) = getimagesize($diretorio);
									
									$img = imagecreatefromjpeg($diretorio);

									$thumb = imagecreatetruecolor(200, 200);
									
									imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 200, $largura, $altura);
									
									imagejpeg($thumb, $dir2 . $foto);
									imagedestroy($img);
									imagedestroy($thumb);				      
								
								break;					

								case 'image/png':
								case 'image/x-png';
									
									list($largura, $altura, $tipo) = getimagesize($diretorio);
									
									$img = imagecreatefrompng($diretorio);

									$thumb = imagecreatetruecolor(200, 200);
									
									imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 200, $largura, $altura);
									
									imagejpeg($thumb, $dir2 . $foto);
									imagedestroy($img);
									imagedestroy($thumb);				      
								
								break;
								
							endswitch;                
							
							$data['camposfile'] = array_keys($data['file']);
							$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

							if ($data['idSis_Arquivo'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
								$this->basico->erro($msg);
								$this->load->view('empresa/form_logo', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
								
								$data['query']['Arquivo'] = $data['file']['Arquivo'];
								$data['anterior'] = $this->Empresa_model->get_empresa($data['query']['idSis_Empresa']);
								$data['campos'] = array_keys($data['query']);

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

								if ($data['auditoriaitem'] && $this->Empresa_model->update_empresa($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
									$data['msg'] = '?m=2';
									redirect(base_url() . 'empresa/form_logo/' . $data['query']['idSis_Empresa'] . $data['msg']);
									exit();
								} else {

									if(null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['QueryEmpresa']['Arquivo'] . '')){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['QueryEmpresa']['Arquivo'] . '');						
									}
									if(null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['QueryEmpresa']['Arquivo'] . '')){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['QueryEmpresa']['Arquivo'] . '');						
									}					
								
									if ($data['auditoriaitem'] === FALSE) {
										$data['msg'] = '';
									} else {
										$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
										$data['msg'] = '?m=1';
									}

									redirect(base_url() . 'empresa/prontuario/' . $data['query']['idSis_Empresa'] . $data['msg']);
									exit();
								}				
							}
						}
					}
				}
			}
			
		}
		$this->load->view('basico/footer');
    }

    public function atendimento($id = FALSE) {
		
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
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['empresa'] = quotes_to_entities($this->input->post(array(
				#### Sis_Empresa ####
				'idSis_Empresa',
				
			), TRUE));

			(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');

			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				if ($this->input->post('Aberto' . $i) || $this->input->post('Hora_Abre' . $i) || $this->input->post('Hora_Fecha' . $i) || 
					$this->input->post('Aberto_Atend' . $i) || $this->input->post('Hora_Abre_Atend' . $i) || $this->input->post('Hora_Fecha_Atend' . $i)) {
					$data['atendimento'][$j]['idApp_Atendimento'] = $this->input->post('idApp_Atendimento' . $i);
					$data['atendimento'][$j]['id_Dia'] = $this->input->post('id_Dia' . $i);
					$data['atendimento'][$j]['Dia_Semana'] = $this->input->post('Dia_Semana' . $i);
					$data['atendimento'][$j]['Aberto'] = $this->input->post('Aberto' . $i);
					$data['atendimento'][$j]['Hora_Abre'] = $this->input->post('Hora_Abre' . $i);
					$data['atendimento'][$j]['Hora_Fecha'] = $this->input->post('Hora_Fecha' . $i);
					$data['atendimento'][$j]['Aberto_Atend'] = $this->input->post('Aberto_Atend' . $i);
					$data['atendimento'][$j]['Hora_Abre_Atend'] = $this->input->post('Hora_Abre_Atend' . $i);
					$data['atendimento'][$j]['Hora_Fecha_Atend'] = $this->input->post('Hora_Fecha_Atend' . $i);
					$j++;
				}
			}
			$data['count']['PRCount'] = $j - 1;

			if ($id) {
				
				$_SESSION['QueryEmpresa'] = $data['empresa'] = $this->Empresa_model->get_empresa_verificacao($id, TRUE);

				if($data['empresa'] === FALSE){
					
					unset($_SESSION['QueryEmpresa']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {
					#### Atendimento ####
					$_SESSION['Atendimento'] = $data['atendimento'] = $this->Empresa_model->get_atendimento($id);
					if (count($data['atendimento']) > 0) {
						$data['atendimento'] = array_combine(range(1, count($data['atendimento'])), array_values($data['atendimento']));
						$data['count']['PRCount'] = count($data['atendimento']);
						
						if (isset($data['atendimento'])) {

							for($j=1; $j <= $data['count']['PRCount']; $j++) {
								//$data['atendimento'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['atendimento'][$j]['DataVencimentoOrca'], 'barras');
							}

						}
					}
				}
			}
			
			if(!$data['empresa']['idSis_Empresa'] || !$_SESSION['QueryEmpresa']){
				
				unset($_SESSION['QueryEmpresa']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			} else {

				$data['select']['Aberto'] = $this->Basico_model->select_status_sn();
				$data['select']['Aberto_Atend'] = $this->Basico_model->select_status_sn();		
				
				$data['titulo'] = 'Atendimento';
				$data['form_open_path'] = 'empresa/atendimento';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				$data['collapse'] = '';	
				$data['collapse1'] = 'class="collapse"';		
				
				if ($data['count']['PRCount'] > 0 )
					$data['parcelasin'] = 'in';
				else
					$data['parcelasin'] = '';


				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';

				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data);
				  echo "</pre>";
				  exit ();
				*/
					
				$data['cor_cli'] 	= 'warning';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'default';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';

				$data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				#### Sis_Empresa ####
				$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('empresa/form_atendimento', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
					} else {

						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						#### Sis_Empresa ####

						$data['empresa']['DataOrca'] = $this->basico->mascara_data($data['empresa']['DataOrca'], 'mysql');


						$data['update']['empresa']['anterior'] = $this->Empresa_model->get_empresa($data['empresa']['idSis_Empresa']);
						$data['update']['empresa']['campos'] = array_keys($data['empresa']);
						$data['update']['empresa']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['empresa']['anterior'],
							$data['empresa'],
							$data['update']['empresa']['campos'],
							$data['empresa']['idSis_Empresa'], TRUE);
						$data['update']['empresa']['bd'] = $this->Empresa_model->update_empresa($data['empresa'], $data['empresa']['idSis_Empresa']);


						#### App_ParcelasRec ####
						$data['update']['atendimento']['anterior'] = $this->Empresa_model->get_atendimento($data['empresa']['idSis_Empresa']);
						if (isset($data['atendimento']) || (!isset($data['atendimento']) && isset($data['update']['atendimento']['anterior']) ) ) {

							if (isset($data['atendimento']))
								$data['atendimento'] = array_values($data['atendimento']);
							else
								$data['atendimento'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['atendimento'] = $this->basico->tratamento_array_multidimensional($data['atendimento'], $data['update']['atendimento']['anterior'], 'idApp_Atendimento');

							$max = count($data['update']['atendimento']['alterar']);
							for($j=0;$j<$max;$j++) {
								//$data['update']['atendimento']['alterar'][$j]['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['update']['atendimento']['alterar'][$j]['ValorRestanteOrca']));
								//$data['update']['atendimento']['alterar'][$j]['ValorComissao'] = str_replace(',', '.', str_replace('.', '', $data['update']['atendimento']['alterar'][$j]['ValorComissao']));
								//$data['update']['atendimento']['alterar'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['update']['atendimento']['alterar'][$j]['DataVencimentoOrca'], 'mysql');
								
							}

							if (count($data['update']['atendimento']['alterar']))
								$data['update']['atendimento']['bd']['alterar'] =  $this->Empresa_model->update_atendimento($data['update']['atendimento']['alterar']);

						}


						if ($data['auditoriaitem'] && !$data['update']['empresa']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('empresa/form_atendimento', $data);
						} else {

							//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
							//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';

							//redirect(base_url() . 'relatorio/comissao/' . $data['msg']);
							redirect(base_url() . 'empresa/prontuario/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

							exit();
						}
					}
				}
			}
			
		}
		$this->load->view('basico/footer');

    }

    public function pagseguro($id) {

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
				
				$_SESSION['QueryEmpresa'] = $data['query'] = $this->Empresa_model->get_empresa_verificacao($id, TRUE);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryEmpresa']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {
					
					$_SESSION['PagSeguro'] = $data['pagseguro'] = $this->Empresa_model->get_pagseguro($id, TRUE);

					if($data['pagseguro'] === FALSE){
						
						unset($_SESSION['PagSeguro']);
						unset($_SESSION['QueryEmpresa']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
						exit();
						
					} else {
						
						$data['titulo'] = 'Pag Seguro ' ;
						$data['panel'] = 'primary';
						$data['metodo'] = 4;
							
						$data['cor_cli'] 	= 'warning';
						$data['cor_cons'] 	= 'default';
						$data['cor_orca'] 	= 'default';
						$data['cor_sac'] 	= 'default';
						$data['cor_mark'] 	= 'default';

						$data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

						$this->load->view('empresa/tela_pagseguro', $data);
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function alterarpagseguro($id = FALSE) {

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
				
			$data['pagseguro'] = $this->input->post(array(
				'idSis_Empresa',
				'idApp_Documentos',
				'Token_Sandbox',
				'Token_Producao',
				'Email_Pagseguro',
				'Email_Loja',
				'Ativo_Pagseguro',
				'Prod_PagSeguro',
			), TRUE);

			if ($id) {
				
				$_SESSION['QueryEmpresa'] = $data['query'] = $this->Empresa_model->get_empresa_verificacao($id, TRUE);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryEmpresa']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {
					
					$_SESSION['PagSeguro'] = $data['pagseguro'] = $this->Empresa_model->get_pagseguro($id, TRUE);

					if($data['pagseguro'] === FALSE){
						
						unset($_SESSION['PagSeguro']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
						exit();
						
					}
				}
			}

			if(!$data['pagseguro']['idSis_Empresa'] || !$data['pagseguro']['idApp_Documentos'] || !$_SESSION['PagSeguro'] || !$_SESSION['QueryEmpresa']){
				
				unset($_SESSION['PagSeguro']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			} else {
				
				$data['select']['Ativo_Pagseguro'] = $this->Basico_model->select_status_sn();
				$data['select']['Prod_PagSeguro'] = $this->Basico_model->select_status_sn();

				(!$data['pagseguro']['Ativo_Pagseguro']) ? $data['pagseguro']['Ativo_Pagseguro'] = 'N' : FALSE;
				$data['radio'] = array(
					'Ativo_Pagseguro' => $this->basico->radio_checked($data['pagseguro']['Ativo_Pagseguro'], 'Ativo_Pagseguro', 'NS'),
				);
				($data['pagseguro']['Ativo_Pagseguro'] == 'S') ?
					$data['div']['Ativo_Pagseguro'] = '' : $data['div']['Ativo_Pagseguro'] = 'style="display: none;"';		
			
				(!$data['pagseguro']['Prod_PagSeguro']) ? $data['pagseguro']['Prod_PagSeguro'] = 'N' : FALSE;
				$data['radio'] = array(
					'Prod_PagSeguro' => $this->basico->radio_checked($data['pagseguro']['Prod_PagSeguro'], 'Prod. PagSeguro', 'NS'),
				);
				($data['pagseguro']['Prod_PagSeguro'] == 'S') ?
					$data['div']['Prod_PagSeguro'] = '' : $data['div']['Prod_PagSeguro'] = 'style="display: none;"';		
				
				$data['titulo'] = 'Editar Pag Seguro';
				$data['form_open_path'] = 'empresa/alterarpagseguro';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
				$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';
					
				$data['cor_cli'] 	= 'warning';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'default';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';

				$data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				if($data['pagseguro']['Ativo_Pagseguro'] == "S"){
					$this->form_validation->set_rules('Email_Pagseguro', 'E-mail do PagSeguro', 'required|trim|valid_email');
					$this->form_validation->set_rules('Email_Loja', 'E-mail da Loja', 'required|trim|valid_email');
					$this->form_validation->set_rules('Token_Sandbox', 'Token_Sandbox', 'required|trim');
					if($data['pagseguro']['Prod_PagSeguro'] == "S"){
						$this->form_validation->set_rules('Token_Producao', 'Token_Producao', 'required|trim');
					}else{
						$this->form_validation->set_rules('Token_Producao', 'Token_Producao', 'trim');
					}
				}else{
					$this->form_validation->set_rules('Email_Pagseguro', 'E-mail do PagSeguro', 'trim|valid_email');
					$this->form_validation->set_rules('Email_Loja', 'E-mail da Loja', 'trim|valid_email');
					$this->form_validation->set_rules('Token_Sandbox', 'Token_Sandbox', 'trim');
					$this->form_validation->set_rules('Token_Producao', 'Token_Producao', 'trim');
				}
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('empresa/form_pagseguro', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
					} else {

						//$data['pagseguro']['NomeEmpresa'] = trim(mb_strtoupper($data['pagseguro']['NomeEmpresa'], 'ISO-8859-1'));
						//$data['pagseguro']['NomeAdmin'] = trim(mb_strtoupper($data['pagseguro']['NomeAdmin'], 'ISO-8859-1'));

						$data['anterior'] = $this->Empresa_model->get_pagseguro($data['pagseguro']['idSis_Empresa']);
						$data['campos'] = array_keys($data['pagseguro']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['pagseguro'], $data['campos'], $data['pagseguro']['idSis_Empresa'], TRUE);

						if ($data['auditoriaitem'] && $this->Empresa_model->update_pagseguro($data['pagseguro'], $data['pagseguro']['idSis_Empresa']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'empresa/form_pagseguro/' . $data['pagseguro']['idSis_Empresa'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'empresa/pagseguro/' . $data['pagseguro']['idSis_Empresa'] . $data['msg']);
							exit();
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function saudacao($id) {

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
				
				$_SESSION['QueryEmpresa'] = $data['query'] = $this->Empresa_model->get_empresa_verificacao($id, TRUE);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryEmpresa']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {
					
					$_SESSION['Saudacao'] = $data['saudacao'] = $this->Empresa_model->get_saudacao($id, TRUE);

					if($data['saudacao'] === FALSE){
						
						unset($_SESSION['Saudacao']);
						unset($_SESSION['QueryEmpresa']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
						exit();
						
					} else {
						
						$data['titulo'] = 'Saudacoes ' ;
						$data['panel'] = 'primary';
						$data['metodo'] = 4;
							
						$data['cor_cli'] 	= 'warning';
						$data['cor_cons'] 	= 'default';
						$data['cor_orca'] 	= 'default';
						$data['cor_sac'] 	= 'default';
						$data['cor_mark'] 	= 'default';

						$data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

						$this->load->view('empresa/tela_saudacao', $data);
					}
				}
			}
		}

        $this->load->view('basico/footer');
    }

    public function alterarsaudacao($id = FALSE) {

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
				
			$data['saudacao'] = $this->input->post(array(
				'idSis_Empresa',
				'idApp_Documentos',
				'TextoPedido_1',
				'TextoPedido_2',
				'TextoPedido_3',
				'TextoPedido_4',
				'ClientePedido',
				'idClientePedido',
				'idPedido',
				'SitePedido',
				'TextoAgenda_1',
				'TextoAgenda_2',
				'TextoAgenda_3',
				'TextoAgenda_4',
				'ClienteAgenda',
				'ProfAgenda',
				'DataAgenda',
				'SiteAgenda',
			), TRUE);

			if ($id) {
				
				$_SESSION['QueryEmpresa'] = $data['query'] = $this->Empresa_model->get_empresa_verificacao($id, TRUE);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryEmpresa']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {
					
					$_SESSION['Saudacao'] = $data['saudacao'] = $this->Empresa_model->get_saudacao($id, TRUE);

					if($data['saudacao'] === FALSE){
						
						unset($_SESSION['Saudacao']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
						exit();
						
					}
				}
			}

			if(!$data['saudacao']['idSis_Empresa'] || !$data['saudacao']['idApp_Documentos'] || !$_SESSION['Saudacao'] || !$_SESSION['QueryEmpresa']){
				
				unset($_SESSION['Saudacao']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			} else {
					
				$data['select']['ClientePedido'] = $this->Basico_model->select_status_sn();
				$data['select']['idClientePedido'] = $this->Basico_model->select_status_sn();
				$data['select']['idPedido'] = $this->Basico_model->select_status_sn();
				$data['select']['SitePedido'] = $this->Basico_model->select_status_sn();
				$data['select']['ClienteAgenda'] = $this->Basico_model->select_status_sn();
				$data['select']['ProfAgenda'] = $this->Basico_model->select_status_sn();
				$data['select']['DataAgenda'] = $this->Basico_model->select_status_sn();
				$data['select']['SiteAgenda'] = $this->Basico_model->select_status_sn();

				(!$data['saudacao']['ClientePedido']) ? $data['saudacao']['ClientePedido'] = 'N' : FALSE;
				$data['radio'] = array(
					'ClientePedido' => $this->basico->radio_checked($data['saudacao']['ClientePedido'], 'ClientePedido', 'NS'),
				);
				($data['saudacao']['ClientePedido'] == 'S') ?
					$data['div']['ClientePedido'] = '' : $data['div']['ClientePedido'] = 'style="display: none;"';		
			
				(!$data['saudacao']['idClientePedido']) ? $data['saudacao']['idClientePedido'] = 'N' : FALSE;
				$data['radio'] = array(
					'idClientePedido' => $this->basico->radio_checked($data['saudacao']['idClientePedido'], 'idClientePedido', 'NS'),
				);
				($data['saudacao']['idClientePedido'] == 'S') ?
					$data['div']['idClientePedido'] = '' : $data['div']['idClientePedido'] = 'style="display: none;"';		
			
				(!$data['saudacao']['idPedido']) ? $data['saudacao']['idPedido'] = 'N' : FALSE;
				$data['radio'] = array(
					'idPedido' => $this->basico->radio_checked($data['saudacao']['idPedido'], 'idPedido', 'NS'),
				);
				($data['saudacao']['idPedido'] == 'S') ?
					$data['div']['idPedido'] = '' : $data['div']['idPedido'] = 'style="display: none;"';		
			
				(!$data['saudacao']['SitePedido']) ? $data['saudacao']['SitePedido'] = 'N' : FALSE;
				$data['radio'] = array(
					'SitePedido' => $this->basico->radio_checked($data['saudacao']['SitePedido'], 'SitePedido', 'NS'),
				);
				($data['saudacao']['SitePedido'] == 'S') ?
					$data['div']['SitePedido'] = '' : $data['div']['SitePedido'] = 'style="display: none;"';		
			
				(!$data['saudacao']['ClienteAgenda']) ? $data['saudacao']['ClienteAgenda'] = 'N' : FALSE;
				$data['radio'] = array(
					'ClienteAgenda' => $this->basico->radio_checked($data['saudacao']['ClienteAgenda'], 'ClienteAgenda', 'NS'),
				);
				($data['saudacao']['ClienteAgenda'] == 'S') ?
					$data['div']['ClienteAgenda'] = '' : $data['div']['ClienteAgenda'] = 'style="display: none;"';		
			
				(!$data['saudacao']['ProfAgenda']) ? $data['saudacao']['ProfAgenda'] = 'N' : FALSE;
				$data['radio'] = array(
					'ProfAgenda' => $this->basico->radio_checked($data['saudacao']['ProfAgenda'], 'ProfAgenda', 'NS'),
				);
				($data['saudacao']['ProfAgenda'] == 'S') ?
					$data['div']['ProfAgenda'] = '' : $data['div']['ProfAgenda'] = 'style="display: none;"';		
			
				(!$data['saudacao']['DataAgenda']) ? $data['saudacao']['DataAgenda'] = 'N' : FALSE;
				$data['radio'] = array(
					'DataAgenda' => $this->basico->radio_checked($data['saudacao']['DataAgenda'], 'DataAgenda', 'NS'),
				);
				($data['saudacao']['DataAgenda'] == 'S') ?
					$data['div']['DataAgenda'] = '' : $data['div']['DataAgenda'] = 'style="display: none;"';		
			
				(!$data['saudacao']['SiteAgenda']) ? $data['saudacao']['SiteAgenda'] = 'N' : FALSE;
				$data['radio'] = array(
					'SiteAgenda' => $this->basico->radio_checked($data['saudacao']['SiteAgenda'], 'SiteAgenda', 'NS'),
				);
				($data['saudacao']['SiteAgenda'] == 'S') ?
					$data['div']['SiteAgenda'] = '' : $data['div']['SiteAgenda'] = 'style="display: none;"';		
																	
				$data['titulo'] = 'Editar Saudacoes';
				$data['form_open_path'] = 'empresa/alterarsaudacao';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
				$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';
					
				$data['cor_cli'] 	= 'warning';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'default';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';

				$data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				$this->form_validation->set_rules('TextoPedido_1', 'TextoPedido_1', 'trim');
				$this->form_validation->set_rules('TextoPedido_2', 'TextoPedido_2', 'trim');
				$this->form_validation->set_rules('TextoPedido_3', 'TextoPedido_3', 'trim');
				$this->form_validation->set_rules('TextoPedido_4', 'TextoPedido_4', 'trim');
				
				$this->form_validation->set_rules('TextoAgenda_1', 'TextoAgenda_1', 'trim');
				$this->form_validation->set_rules('TextoAgenda_2', 'TextoAgenda_2', 'trim');
				$this->form_validation->set_rules('TextoAgenda_3', 'TextoAgenda_3', 'trim');
				$this->form_validation->set_rules('TextoAgenda_4', 'TextoAgenda_4', 'trim');

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('empresa/form_saudacao', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
					} else {

						$data['anterior'] = $this->Empresa_model->get_saudacao($data['saudacao']['idSis_Empresa']);
						$data['campos'] = array_keys($data['saudacao']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['saudacao'], $data['campos'], $data['saudacao']['idSis_Empresa'], TRUE);

						if ($data['auditoriaitem'] && $this->Empresa_model->update_saudacao($data['saudacao'], $data['saudacao']['idSis_Empresa']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'empresa/form_saudacao/' . $data['saudacao']['idSis_Empresa'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'empresa/saudacao/' . $data['saudacao']['idSis_Empresa'] . $data['msg']);
							exit();
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }
	
}
