<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Associado extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Cliente_model', 'Usuario_model', 'Associado_model', 'Empresa_model'));
        #$this->load->model(array('Basico_model', 'Associado_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('associado/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('associado/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso_associado' . $data['msg']);
			exit();
			
		}else{		
			
			$data['query'] = $this->Associado_model->get_associado_verificacao($id, TRUE);
		
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso_associado' . $data['msg']);
				exit();
				
			} else {
				
				$data['titulo'] = 'Prontuário ' . $data['query']['Nome'];
				$data['panel'] = 'primary';
				$data['metodo'] = 4;

				$data['query']['Idade'] = $this->basico->calcula_idade($data['query']['DataNascimento']);
				$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');

				$data['query']['profile'] = ($data['query']['Sexo']) ? strtolower($data['query']['Sexo']) : 'o';

				$data['query']['Sexo'] = $this->Basico_model->get_sexo($data['query']['Sexo']);
				$data['query']['Inativo'] = $this->Basico_model->get_inativo($data['query']['Inativo']);
				$data['query']['idSis_Empresa'] = $this->Basico_model->get_empresa($data['query']['idSis_Empresa']);
				$data['query']['Telefone'] = $data['query']['CelularAssociado'];
				$data['query']['CpfAssociado'] = $data['query']['CpfAssociado'];

				$this->load->view('associado/tela_associado', $data);
			}
		}
        $this->load->view('basico/footer');
    }

    public function associadoalterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
       
		$data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idSis_Associado',
            'Nome',
            'DataNascimento',
            'Email',
			'Sexo',
			'Inativo',
			'CpfAssociado',
			'RgAssociado',
			'OrgaoExpAssociado',
			'EstadoEmAssociado',
			'DataEmAssociado',
			'EnderecoAssociado',
			'BairroAssociado',
			'MunicipioAssociado',
			'EstadoAssociado',
			'CepAssociado',
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Associado_model->get_associado_verificacao($id);
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso_associado' . $data['msg']);
				exit();
				
			} else {
				$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
				$data['query']['DataEmAssociado'] = $this->basico->mascara_data($data['query']['DataEmAssociado'], 'barras');
			}
		}
	
		if(!$data['query']['idSis_Associado']){
			
			unset($_SESSION['Query']);
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

			$nomeassociado1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['Nome'], $caracteres_sem_acento));		

			$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
			$data['select']['Municipio'] = $this->Basico_model->select_municipio();
			$data['select']['Sexo'] = $this->Basico_model->select_sexo();
			$data['select']['Inativo'] = $this->Basico_model->select_inativo();
			
			$data['titulo'] = 'Editar Associado';
			$data['form_open_path'] = 'associado/associadoalterar';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 2;

			if ($data['query']['EnderecoAssociado'] || $data['query']['BairroAssociado'] ||
				$data['query']['MunicipioAssociado'] || $data['query']['CepAssociado'] || $data['query']['RgAssociado']  || 
				$data['query']['OrgaoExpAssociado'] || $data['query']['EstadoEmAssociado']  || $data['query']['DataEmAssociado'])
				$data['collapse'] = '';
			else
				$data['collapse'] = 'class="collapse"';

			$data['nav_secundario'] = $this->load->view('associado/nav_secundario', $data, TRUE);

			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
			
			$data['radio'] = array(
				'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
			);
			($data['cadastrar']['Cadastrar'] == 'N') ?
				$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';

			$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
			$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('Nome', 'Nome do Associado', 'required|trim');
			$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
			$this->form_validation->set_rules('DataEmAssociado', 'Data de Emissão', 'trim|valid_date');
			$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');	

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('associado/form_associadoalterar', $data);
			} else {
			
			
				$data['query']['Nome'] = trim(mb_strtoupper($nomeassociado1, 'ISO-8859-1'));
				$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
				$data['query']['DataEmAssociado'] = $this->basico->mascara_data($data['query']['DataEmAssociado'], 'mysql');
				if(!isset($data['query']['DataNascimento']) || empty($data['query']['DataNascimento'])){
					$data['query']['DataNascimento'] = "0000-00-00";
				}
				if(!isset($data['query']['DataEmAssociado']) || empty($data['query']['DataEmAssociado'])){
					$data['query']['DataEmAssociado'] = "0000-00-00";
				}
				
				#$data['query']['Obs'] = nl2br($data['query']['Obs']);
				/*
				echo '<br>';
				echo "<pre>";
				print_r($data['query']);
				echo '<br>';
				print_r($data['query']['DataNascimento']);
				echo '<br>';
				print_r($data['query']['DataEmAssociado']);
				echo '<br>';
				echo "</pre>";
				exit ();
				*/

				$data['anterior'] = $this->Associado_model->get_associado($data['query']['idSis_Associado']);
				$data['campos'] = array_keys($data['query']);

				$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Associado'], TRUE);

				if ($data['auditoriaitem'] && $this->Associado_model->update_associado($data['query'], $data['query']['idSis_Associado']) === FALSE) {
					$data['msg'] = '?m=1';
					
					redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
					exit();
				} else {

					if ($data['auditoriaitem'] === FALSE) {
						$data['msg'] = '';
					} else {
						$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Associado', 'UPDATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';
					}
					
					redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
					exit();
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function alterarcelular($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Este Celular já está sendo usado como Login.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idSis_Associado',
        ), TRUE);
		
        $data['confirma'] = $this->input->post(array(
            'CelularAssociado',
            'ConfirmaCelular',
        ), TRUE);		

        if ($id) {
            $_SESSION['Query'] = $data['query'] = $this->Associado_model->get_associado_verificacao($id);
			if($data['query'] === FALSE){
				
				unset($_SESSION['Query']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso_associado' . $data['msg']);
				exit();
				
			}
		}
	
		if(!$data['query']['idSis_Associado'] || !$_SESSION['Query']){
			
			unset($_SESSION['Query']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			$data['titulo'] = 'Editar Celular';
			$data['form_open_path'] = 'associado/alterarcelular';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 2;

			if ($data['confirma']['CelularAssociado'])
				$data['collapse'] = '';
			else
				$data['collapse'] = 'class="collapse"';

			$data['nav_secundario'] = $this->load->view('associado/nav_secundario', $data, TRUE);

			$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
			$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('CelularAssociado', 'Celular do Associado', 'required|trim|is_unique_by_id_empresa[Sis_Associado.CelularAssociado.' . $data['query']['idSis_Associado'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']|valid_celular');
			$this->form_validation->set_rules('ConfirmaCelular', 'Confirmar Celular', 'required|trim|matches[CelularAssociado]');	

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('associado/form_associadocelular', $data);
			} else {

				
				if($_SESSION['Query']['CelularAssociado'] != $data['confirma']['CelularAssociado']){
					//trocou o celular 
					//pesquiso se existe algum associado cadastrado com o novo número informado 
					$data['associado'] = $this->Associado_model->get_associado_celular($data['confirma']['CelularAssociado']);

					if($data['associado'] != FALSE){
						//existe um associado usando este login
						$data['msg'] = '?m=3';	
						redirect(base_url() . 'associado/alterarcelular/' . $data['query']['idSis_Associado'] . $data['msg']);
						exit();					
						
					}else{
						//não existe associado usando este login
						$data['query']['CelularAssociado'] = $data['confirma']['CelularAssociado'];
						$data['query']['Associado'] = $data['confirma']['CelularAssociado'];
						$data['query']['Codigo'] 	= md5(uniqid(time() . rand()));	

						$data['anterior'] = $this->Associado_model->get_associado($data['query']['idSis_Associado']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Associado'], TRUE);

						$data['update']['associado'] = $this->Associado_model->update_associado($data['query'], $data['query']['idSis_Associado']);
						
						if ($data['auditoriaitem'] && $data['update']['associado'] === FALSE) {
							
							
							$data['msg'] = '?m=1';				

							redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Associado', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}
							
							#### App_Cliente ####
							$data['update']['cliente']['alterar'] = $this->Cliente_model->get_cliente_associado($data['query']['idSis_Associado']);
							if (isset($data['update']['cliente']['alterar'])){

								$max = count($data['update']['cliente']['alterar']);
								for($j=0;$j<$max;$j++) {
								
									$data['update']['cliente']['alterar'][$j]['CelularCliente'] = $data['confirma']['CelularAssociado'];
									$data['update']['cliente']['alterar'][$j]['usuario'] 		= $data['confirma']['CelularAssociado'];
									$data['update']['cliente']['alterar'][$j]['Codigo'] 		= $data['query']['Codigo'];

									$data['update']['cliente']['bd'][$j] = $this->Cliente_model->update_cliente($data['update']['cliente']['alterar'][$j], $data['update']['cliente']['alterar'][$j]['idApp_Cliente']);
								
								}
							}				
							
							#### Sis_Usuario ####
							$data['update']['usuario']['alterar'] = $this->Usuario_model->get_usuario_associado($data['query']['idSis_Associado']);
							
							if (isset($data['update']['usuario']['alterar'])){

								$max_usuario = count($data['update']['usuario']['alterar']);

								for($j=0;$j<$max_usuario;$j++) {
								
									$data['update']['usuario']['alterar'][$j]['CelularUsuario'] = $data['confirma']['CelularAssociado'];
									$data['update']['usuario']['alterar'][$j]['Usuario'] 		= $data['confirma']['CelularAssociado'];
									$data['update']['usuario']['alterar'][$j]['Codigo'] 		= $data['query']['Codigo'];

									$data['update']['usuario']['bd'][$j] = $this->Usuario_model->update_usuario($data['update']['usuario']['alterar'][$j], $data['update']['usuario']['alterar'][$j]['idSis_Usuario']);
										
								}
							}
							
							#### Sis_Empresa ####
							$data['update']['empresa']['alterar'] = $this->Empresa_model->get_empresa_associado($data['query']['idSis_Associado']);
							
							if (isset($data['update']['empresa']['alterar'])){

								$max_empresa = count($data['update']['empresa']['alterar']);

								for($j=0;$j<$max_empresa;$j++) {
								
									$data['update']['empresa']['alterar'][$j]['CelularAdmin'] 	= $data['confirma']['CelularAssociado'];
									$data['update']['empresa']['alterar'][$j]['UsuarioEmpresa'] = $data['confirma']['CelularAssociado'];
									$data['update']['empresa']['alterar'][$j]['Codigo'] 		= $data['query']['Codigo'];

									$data['update']['empresa']['bd'][$j] = $this->Empresa_model->update_empresa($data['update']['empresa']['alterar'][$j], $data['update']['empresa']['alterar'][$j]['idSis_Empresa']);
										
								}
							}
							unset($data['confirma']['CelularAssociado']);
							unset($data['confirma']['ConfirmaCelular']);
							unset($_SESSION['Query']);
							redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
							exit();
						}				
					
					}
				}else{
					unset($data['confirma']['CelularAssociado']);
					unset($data['confirma']['ConfirmaCelular']);
					unset($_SESSION['Query']);
					redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
					exit();	
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function alterarsenha($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Este Celular já está sendo usado como Login.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idSis_Associado',
		), TRUE);
		
		$data['confirma'] = $this->input->post(array(
			'Senha',
			'Confirma',
		), TRUE);		

        if ($id) {
            $data['query'] = $this->Associado_model->get_associado_verificacao($id);
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso_associado' . $data['msg']);
				exit();
				
			}
		}
	
		if(!$data['query']['idSis_Associado']){
			
			unset($_SESSION['Query']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			$data['titulo'] = 'Editar Senha';
			$data['form_open_path'] = 'associado/alterarsenha';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 2;

			if ($data['confirma']['Senha'])
				$data['collapse'] = '';
			else
				$data['collapse'] = 'class="collapse"';

			$data['nav_secundario'] = $this->load->view('associado/nav_secundario', $data, TRUE);

			$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
			$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
			$this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');		

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('associado/form_associadosenha', $data);
			} else {

				unset($data['confirma']['Confirma']);

				$data['query']['Senha'] = md5($data['confirma']['Senha']);
				$data['query']['Codigo'] = md5(uniqid(time() . rand()));	


				$data['anterior'] = $this->Associado_model->get_associado($data['query']['idSis_Associado']);
				$data['campos'] = array_keys($data['query']);

				$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Associado'], TRUE);

				$data['update']['associado'] = $this->Associado_model->update_associado($data['query'], $data['query']['idSis_Associado']);
				
				if ($data['auditoriaitem'] && $data['update']['associado'] === FALSE) {
					$data['msg'] = '?m=1';
					
					redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
					exit();
				} else {

					if ($data['auditoriaitem'] === FALSE) {
						$data['msg'] = '';
					} else {
						$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Associado', 'UPDATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';
					}
					
					#### App_Cliente ####
					$data['update']['cliente']['alterar'] = $this->Cliente_model->get_cliente_associado($data['query']['idSis_Associado']);
					if (isset($data['update']['cliente']['alterar'])){

						$max = count($data['update']['cliente']['alterar']);
						for($j=0;$j<$max;$j++) {
						
							$data['update']['cliente']['alterar'][$j]['senha'] 	= $data['query']['Senha'];
							$data['update']['cliente']['alterar'][$j]['Codigo'] = $data['query']['Codigo'];

							$data['update']['cliente']['bd'][$j] = $this->Cliente_model->update_cliente($data['update']['cliente']['alterar'][$j], $data['update']['cliente']['alterar'][$j]['idApp_Cliente']);
						
						}
					}				
					
					#### Sis_Usuario ####
					$data['update']['usuario']['alterar'] = $this->Usuario_model->get_usuario_associado($data['query']['idSis_Associado']);
					
					if (isset($data['update']['usuario']['alterar'])){

						$max_usuario = count($data['update']['usuario']['alterar']);

						for($j=0;$j<$max_usuario;$j++) {
						
							$data['update']['usuario']['alterar'][$j]['Senha'] 	= $data['query']['Senha'];
							$data['update']['usuario']['alterar'][$j]['Codigo'] = $data['query']['Codigo'];

							$data['update']['usuario']['bd'][$j] = $this->Usuario_model->update_usuario($data['update']['usuario']['alterar'][$j], $data['update']['usuario']['alterar'][$j]['idSis_Usuario']);
								
						}
					}
					
					#### Sis_Empresa ####
					$data['update']['empresa']['alterar'] = $this->Empresa_model->get_empresa_associado($data['query']['idSis_Associado']);

					if (isset($data['update']['empresa']['alterar'])){

						$max_empresa = count($data['update']['empresa']['alterar']);

						for($j=0;$j<$max_empresa;$j++) {
						
							$data['update']['empresa']['alterar'][$j]['Senha'] 			= $data['query']['Senha'];
							$data['update']['empresa']['alterar'][$j]['Codigo'] 		= $data['query']['Codigo'];

							$data['update']['empresa']['bd'][$j] = $this->Empresa_model->update_empresa($data['update']['empresa']['alterar'][$j], $data['update']['empresa']['alterar'][$j]['idSis_Empresa']);
								
						}
					}
									
					redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
					exit();
				}
				
			}
		}
        $this->load->view('basico/footer');
    }

    public function alterarconta($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idSis_Associado',
            'Banco',
            'Agencia',
            'Conta',
        ), TRUE);

        if ($id) {
            $_SESSION['Query'] = $data['query'] = $this->Associado_model->get_associado_verificacao($id);
			if($data['query'] === FALSE){
				
				unset($_SESSION['Query']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso_associado' . $data['msg']);
				exit();
				
			}
		}
	
		if(!$data['query']['idSis_Associado'] || !$_SESSION['Query']){
			
			unset($_SESSION['Query']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			$data['titulo'] = 'Editar Conta';
			$data['form_open_path'] = 'associado/alterarconta';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 2;

			if ($data['query']['Agencia'] || $data['query']['Conta'])
				$data['collapse'] = '';
			else
				$data['collapse'] = 'class="collapse"';

			$data['nav_secundario'] = $this->load->view('associado/nav_secundario', $data, TRUE);

			$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
			$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			$this->form_validation->set_rules('Conta', 'Chave Pix / Conta', 'required|trim');

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('associado/form_associadoconta', $data);
			} else {

				$data['anterior'] = $this->Associado_model->get_associado($data['query']['idSis_Associado']);
				$data['campos'] = array_keys($data['query']);

				$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Associado'], TRUE);

				if ($data['auditoriaitem'] && $this->Associado_model->update_associado($data['query'], $data['query']['idSis_Associado']) === FALSE) {
					$data['msg'] = '?m=1';
					
					redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
					exit();
				} else {

					if ($data['auditoriaitem'] === FALSE) {
						$data['msg'] = '';
					} else {
						$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Associado', 'UPDATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';
					}
					
					redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
					exit();
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

		$data['query'] = $this->input->post(array(
			'idSis_Associado',
		), TRUE);
		
		$data['file'] = $this->input->post(array(
			'idSis_Associado',
			'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Query'] = $data['query'] = $this->Associado_model->get_associado_verificacao($id);
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso_associado' . $data['msg']);
				exit();
				
			} else {
				$data['file']['idSis_Associado'] = $id;
			}
		}
	
		if(!$data['query']['idSis_Associado']){
			
			unset($_SESSION['Query']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
				
				$data['file']['Arquivo'] = $this->basico->renomeiaassociado($_FILES['Arquivo']['name']);
				$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
			} else {
				$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
			}

			$data['titulo'] = 'Alterar Foto';
			$data['form_open_path'] = 'associado/alterarlogo';
			$data['readonly'] = 'readonly';
			$data['panel'] = 'primary';
			$data['metodo'] = 2;

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				#load login view
				$this->load->view('associado/form_perfil2', $data);
			} else {


				$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/';
				$config['max_size'] = 1000;
				$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
				$config['file_name'] = $data['file']['Arquivo'];

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('Arquivo')) {
					$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
					$this->load->view('associado/form_perfil2', $data);
				} else {

					$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/';		
					$foto = $data['file']['Arquivo'];
					$diretorio = $dir.$foto;					
					$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/';

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

						case 'image/png';
						case 'image/x-png';
							
							list($width, $height) = getimagesize($diretorio);
							$newwidth = 200;
							$newheight = 200;

							$thumb = imagecreatetruecolor($newwidth, $newheight);
							imagealphablending($thumb, false);
							imagesavealpha($thumb, true);
							$source = imagecreatefrompng($diretorio);
							imagealphablending($source, true);
							imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
							imagepng($thumb, $dir2 . $foto);
							imagedestroy($thumb);
							imagedestroy($source);				      
						
						break;
						
					endswitch;
					
					$data['camposfile'] = array_keys($data['file']);
					$data['idSis_Arquivo'] = $this->Associado_model->set_arquivo($data['file']);

					if ($data['idSis_Arquivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
						$this->basico->erro($msg);
						$this->load->view('associado/form_perfil2', $data);
					} else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
						
						$data['query']['Arquivo'] = $data['file']['Arquivo'];
						$data['anterior'] = $this->Associado_model->get_associado($data['query']['idSis_Associado']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Associado'], TRUE);

						if ($data['auditoriaitem'] && $this->Associado_model->update_associado($data['query'], $data['query']['idSis_Associado']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'associado/form_perfil2/' . $data['query']['idSis_Associado'] . $data['msg']);
							exit();
						} else {

							if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/' . $_SESSION['Usuario']['Arquivo'] . ''))
								&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/' . $_SESSION['Usuario']['Arquivo'] . '')
								!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/SuaFoto.jpg'))){
								unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/' . $_SESSION['Usuario']['Arquivo'] . '');						
							}
							if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['Usuario']['Arquivo'] . ''))
								&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['Usuario']['Arquivo'] . '')
								!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/SuaFoto.jpg'))){
								unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['Usuario']['Arquivo'] . '');						
							}						
							
							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Associado', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}
							
							unset($_SESSION['Query']);
							redirect(base_url() . 'associado/prontuario/' . $data['file']['idSis_Associado'] . $data['msg']);
							exit();
						}				
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }

    function get_associado($data) {

        if ($this->Associado_model->lista_associado($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_associado', '<strong>Associado</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
