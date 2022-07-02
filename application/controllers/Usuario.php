<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Empresa_model', 'Usuario_model', 'Associado_model'));
        #$this->load->model(array('Basico_model', 'Usuario_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

        #$this->load->view('usuario/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('usuario/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

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
				
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'Cadastrar',
			), TRUE));
			
			$data['query'] = quotes_to_entities($this->input->post(array(
				//'idSis_Empresa',
				//'idSis_Usuario',
				'Usuario',
				'Nome',
				'Senha',
				'Confirma',
				'DataNascimento',
				'CelularUsuario',
				'Email',
				'Sexo',
				'Permissao',
				'Funcao',
				'Inativo',
				'CpfUsuario',
				'RgUsuario',
				'OrgaoExpUsuario',
				'EstadoEmUsuario',
				'DataEmUsuario',
				'EnderecoUsuario',
				'BairroUsuario',
				'MunicipioUsuario',
				'EstadoUsuario',
				'CepUsuario',
				'CompAgenda',
				'Nivel',
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

			$nomeusuario1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['Nome'], $caracteres_sem_acento));		
			
			$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['EnderecoUsuario'], $caracteres_sem_acento));

			$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['query']['CepUsuario'], $caracteres_sem_acento));

			$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['BairroUsuario'], $caracteres_sem_acento));

			$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['MunicipioUsuario'], $caracteres_sem_acento));

			$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['EstadoUsuario'], $caracteres_sem_acento));

						
			$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
			$data['select']['Sexo'] = $this->Basico_model->select_sexo();
			$data['select']['Inativo'] = $this->Basico_model->select_inativo();
			$data['select']['Permissao'] = $this->Basico_model->select_permissao();
			$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
			$data['select']['CompAgenda'] = $this->Basico_model->select_status_sn();
			#$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa2();
			$data['select']['Nivel'] = array(
				'1' => '1 - Funcionario',
				'2' => '2 - Revendedor',
			);		
			$data['titulo'] = 'Cadastrar Usuário';
			$data['form_open_path'] = 'usuario/cadastrar';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 1;

			if ($data['query']['EnderecoUsuario'] || $data['query']['BairroUsuario'] ||
				$data['query']['MunicipioUsuario'] || $data['query']['CepUsuario'] || $data['query']['CpfUsuario'] || 
				$data['query']['RgUsuario']  || $data['query']['OrgaoExpUsuario'] || $data['query']['EstadoEmUsuario']  || $data['query']['DataEmUsuario'])
				$data['collapse'] = '';
			else
				$data['collapse'] = 'class="collapse"';

			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
			
			$data['radio'] = array(
				'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
			);
			($data['cadastrar']['Cadastrar'] == 'N') ?
				$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
			$data['sidebar'] = 'col-sm-3 col-md-2';
			$data['main'] = 'col-sm-7 col-md-8';

			$data['tela'] = $this->load->view('usuario/form_usuario', $data, TRUE);
			
			$data['q3'] = $this->Usuario_model->list_funcao(TRUE);
			$data['list3'] = $this->load->view('usuario/list_funcao', $data, TRUE);
						
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			#$this->form_validation->set_rules('CpfUsuario', 'Cpf', 'required|trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[Sis_Usuario.CpfUsuario.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
			#$this->form_validation->set_rules('Usuario', 'Usuario', 'required|trim|is_unique_duplo[Sis_Usuario.Usuario.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
			$this->form_validation->set_rules('Nome', 'Nome do Usuário', 'required|trim');
			//$this->form_validation->set_rules('CelularUsuario', 'CelularUsuario', 'required|trim');
			$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuário', 'required|trim|is_unique_duplo[Sis_Usuario.CelularUsuario.idSis_Empresa.' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . ']');
			$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');		
			$this->form_validation->set_rules('Permissao', 'Acesso Ás Agendas', 'required|trim');		
			$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
			$this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');		
			$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email|is_unique_duplo[Sis_Usuario.Email.idSis_Empresa.' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . ']');
			$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
			$this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
			$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posiçao "Sim"', 'trim|valid_aprovado');
			
			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('usuario/form_usuario', $data);
			} else {

				$data['associado'] = $this->Usuario_model->get_associado($data['query']['CelularUsuario']);
				/*
				echo "<br>";
				echo "<pre>";
				echo "<br>";
				print_r($data['associado']);
				echo "</pre>";			
				exit();
				*/	
				if (!isset($data['associado']) || $data['associado'] == FALSE){
					
					//$data['associado']['Nome'] = trim(mb_strtoupper($data['query']['Nome'], 'ISO-8859-1'));
					$data['associado']['Nome'] = trim(mb_strtoupper($nomeusuario1, 'ISO-8859-1'));
					$data['associado']['idSis_Empresa'] = 5;
					$data['associado']['NomeEmpresa'] = "CONTA PESSOAL";
					//$data['associado']['Permissao'] = 3;
					$data['associado']['idTab_Modulo'] = 1;
					if(!isset($data['query']['DataNascimento']) || $data['query']['DataNascimento'] == ''){
						$data['associado']['DataNascimento'] = "0000-00-00";
					}else{
						$data['associado']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
					}
					$data['associado']['DataCriacao'] = date('Y-m-d', time());
					$data['associado']['Codigo'] = md5(uniqid(time() . rand()));
					$data['associado']['Inativo'] = 0;
					$data['associado']['CelularAssociado'] = $data['query']['CelularUsuario'];
					$data['associado']['Associado'] = $data['query']['CelularUsuario'];
					$data['associado']['Senha'] = md5($data['query']['Senha']);
					
					$data['anterior'] = array();
					$data['campos'] = array_keys($data['associado']);

					$data['associado']['idSis_Associado'] = $this->Associado_model->set_associado($data['associado']);

					if ($data['associado']['idSis_Associado'] === FALSE) {
						$data['msg'] = '?m=2';
						$this->load->view('usuario/form_usuario', $data);
					} else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['associado'], $data['campos'], $data['associado']['idSis_Associado']);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Associado', 'CREATE', $data['auditoriaitem'], $data['associado']['idSis_Associado']);
						/*
						  echo $this->db->last_query();
						  echo "<pre>";
						  print_r($data);
						  echo "</pre>";
						  exit();
						 */
						$data['agenda'] = array(
							'NomeAgenda' => 'Associado',
							'idSis_Associado' => $data['associado']['idSis_Associado'],
							'idSis_Empresa' => "5"
						);
						$data['campos'] = array_keys($data['agenda']);

						$data['idApp_Agenda'] = $this->Usuario_model->set_agenda($data['agenda']);
						if(isset($data['idApp_Agenda'])){
							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['agenda'], $data['campos'], $data['associado']['idSis_Associado']);
							$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'App_Agenda', 'CREATE', $data['auditoriaitem'], $data['associado']['idSis_Associado']);
						}
						
						$data['query']['idSis_Associado'] = $data['associado']['idSis_Associado'];
						$data['query']['Nome'] = trim(mb_strtoupper($nomeusuario1, 'ISO-8859-1'));
						$data['query']['EnderecoUsuario'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
						$data['query']['BairroUsuario'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
						$data['query']['MunicipioUsuario'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
						$data['query']['EstadoUsuario'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));				
						$data['query']['QuemCad'] = $_SESSION['log']['idSis_Usuario'];
						$data['query']['idSis_Empresa'] = $_SESSION['AdminEmpresa']['idSis_Empresa'];
						$data['query']['NomeEmpresa'] = $_SESSION['log']['NomeEmpresa'];
						if(!isset($data['query']['DataNascimento']) || $data['query']['DataNascimento'] == ''){
							$data['query']['DataNascimento'] = "0000-00-00";
						}else{
							$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
						}
						if(!isset($data['query']['DataEmUsuario']) || $data['query']['DataEmUsuario'] == ''){
							$data['query']['DataEmUsuario'] = "0000-00-00";
						}else{
							$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
						}
						$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
						$data['query']['Inativo'] = 0;
						$data['query']['Usuario'] = $data['query']['CelularUsuario'];
						$data['query']['Senha'] = $data['associado']['Senha'];
						$data['query']['Codigo'] = $data['associado']['Codigo'];
						$data['query']['DataCriacao'] = $data['associado']['DataCriacao'];
						unset($data['query']['Confirma']);

						$data['campos'] = array_keys($data['query']);
						$data['anterior'] = array();

						$data['query']['idSis_Usuario'] = $this->Usuario_model->set_usuario($data['query']);

						if ($data['query']['idSis_Usuario'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('usuario/form_usuario', $data);
						} else {

							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], FALSE);
							$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';

							redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
							exit();
						}
					}
				} else {
						
					$data['query']['idSis_Associado'] = $data['associado']['idSis_Associado'];
					$data['query']['Nome'] = trim(mb_strtoupper($nomeusuario1, 'ISO-8859-1'));
					$data['query']['EnderecoUsuario'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
					$data['query']['BairroUsuario'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
					$data['query']['MunicipioUsuario'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
					$data['query']['EstadoUsuario'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));				
					$data['query']['QuemCad'] = $_SESSION['log']['idSis_Usuario'];
					$data['query']['idSis_Empresa'] = $_SESSION['AdminEmpresa']['idSis_Empresa'];
					$data['query']['NomeEmpresa'] = $_SESSION['log']['NomeEmpresa'];
					if(!isset($data['query']['DataNascimento']) || $data['query']['DataNascimento'] == ''){
						$data['query']['DataNascimento'] = "0000-00-00";
					}else{
						$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
					}
					if(!isset($data['query']['DataEmUsuario']) || $data['query']['DataEmUsuario'] == ''){
						$data['query']['DataEmUsuario'] = "0000-00-00";
					}else{
						$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
					}
					$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['query']['Inativo'] = 0;
					$data['query']['Usuario'] = $data['query']['CelularUsuario'];
					$data['query']['Senha'] = $data['associado']['Senha'];
					$data['query']['Codigo'] = $data['associado']['Codigo'];
					$data['query']['DataCriacao'] = date('Y-m-d', time());
					unset($data['query']['Confirma']);

					$data['campos'] = array_keys($data['query']);
					$data['anterior'] = array();

					$data['query']['idSis_Usuario'] = $this->Usuario_model->set_usuario($data['query']);

					if ($data['query']['idSis_Usuario'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('usuario/form_usuario', $data);
					} else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'CREATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';

						redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
						exit();
					}
					
				}			

			}
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
				
				$_SESSION['QueryUsuario'] = $data['query'] = $this->Usuario_model->get_usuario_verificacao_admin($id, TRUE);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryUsuario']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {

					$data['titulo'] = 'Colaborador ';
					$data['panel'] = 'primary';
					$data['metodo'] = 4;

					//$_SESSION['log']['idSis_Usuario'] = $data['resumo']['idSis_Usuario'] = $data['query']['idSis_Usuario'];
					//$data['resumo']['Nome'] = $data['query']['Nome'];

					$data['query']['Idade'] = $this->basico->calcula_idade($data['query']['DataNascimento']);
					$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');

					/*
					if ($data['query']['Sexo'] == 1)
						$data['query']['profile'] = 'm';
					elseif ($data['query']['Sexo'] == 2)
						$data['query']['profile'] = 'f';
					else
						$data['query']['profile'] = 'o';
					*/
					$data['query']['profile'] = ($data['query']['Sexo']) ? strtolower($data['query']['Sexo']) : 'o';

					$data['query']['Sexo'] = $this->Basico_model->get_sexo($data['query']['Sexo']);
					$data['query']['Inativo'] = $this->Basico_model->get_inativo($data['query']['Inativo']);
					$data['query']['Funcao'] = $this->Basico_model->get_funcao($data['query']['Funcao']);
					$data['query']['Permissao'] = $this->Basico_model->get_permissao($data['query']['Permissao']);
					$data['query']['idSis_Empresa'] = $this->Basico_model->get_empresa($data['query']['idSis_Empresa']);
					#$data['query']['Usuario'] = $data['query']['Usuario'];
					$data['query']['CompAgenda'] = $this->Basico_model->get_compagenda($data['query']['CompAgenda']);
					$data['query']['Telefone'] = $data['query']['CelularUsuario'];
					$data['query']['CpfUsuario'] = $data['query']['CpfUsuario'];

					$data['contatousuario'] = $this->Usuario_model->lista_contatousuario($id, TRUE);
					/*
					  echo "<pre>";
					  print_r($data['contatousuario']);
					  echo "</pre>";
					  exit();
					  */
					if (!$data['contatousuario'])
						$data['list'] = FALSE;
					else
						$data['list'] = $this->load->view('usuario/list_contatousuario', $data, TRUE);

					$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);
					
					$this->load->view('usuario/tela_usuario', $data);
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
				
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'Cadastrar',
			), TRUE));
		   
			$data['query'] = $this->input->post(array(
				#'idSis_Empresa',
				'idSis_Usuario',
				#'Usuario',
				'Nome',
				'DataNascimento',
				//'CelularUsuario',
				'Email',
				'Sexo',
				'Permissao',
				'Funcao',
				'Inativo',
				'CpfUsuario',
				'RgUsuario',
				'OrgaoExpUsuario',
				'EstadoEmUsuario',
				'DataEmUsuario',
				'EnderecoUsuario',
				'BairroUsuario',
				'MunicipioUsuario',
				'EstadoUsuario',
				'CepUsuario',
				'CompAgenda',
				'Nivel',
			), TRUE);

			if ($id) {
				$_SESSION['QueryUsuario'] = $data['query'] = $this->Usuario_model->get_usuario_verificacao_admin($id);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryUsuario']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {
					$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
					$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'barras');
				}
			}

			
			if(!$data['query']['idSis_Usuario'] || !$_SESSION['QueryUsuario']){
				
				unset($_SESSION['QueryUsuario']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
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

				$nomeusuario1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['Nome'], $caracteres_sem_acento));		
				
				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
				$data['select']['Municipio'] = $this->Basico_model->select_municipio();
				$data['select']['Sexo'] = $this->Basico_model->select_sexo();
				$data['select']['Inativo'] = $this->Basico_model->select_inativo();
				$data['select']['Permissao'] = $this->Basico_model->select_permissao();
				$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
				$data['select']['CompAgenda'] = $this->Basico_model->select_status_sn();
				#$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa2();
				$data['select']['Nivel'] = array(
					'1' => '1 - Funcionario',
					'2' => '2 - Revendedor',
				);
				
				$data['titulo'] = 'Editar Usuário';
				$data['form_open_path'] = 'usuario/alterar';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				if ($data['query']['EnderecoUsuario'] || $data['query']['BairroUsuario'] ||
					$data['query']['MunicipioUsuario'] || $data['query']['CepUsuario'] || $data['query']['RgUsuario']  || 
					$data['query']['OrgaoExpUsuario'] || $data['query']['EstadoEmUsuario']  || $data['query']['DataEmUsuario'])
					$data['collapse'] = '';
				else
					$data['collapse'] = 'class="collapse"';

				(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
				
				$data['radio'] = array(
					'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
				);
				($data['cadastrar']['Cadastrar'] == 'N') ?
					$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';

				$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
				$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';
				
				$data['q3'] = $this->Usuario_model->list_funcao(TRUE);
				$data['list3'] = $this->load->view('usuario/list_funcao', $data, TRUE);

				$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				#$this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim|is_unique_duplo[Sis_Usuario.Nome.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
				$this->form_validation->set_rules('Nome', 'Nome do Usuario', 'required|trim');
				$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
				$this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
				//$this->form_validation->set_rules('CelularUsuario', 'CelularUsuario', 'required|trim');
				//$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuario', 'required|trim|is_unique_by_id_empresa[Sis_Usuario.CelularUsuario.' . $data['query']['idSis_Usuario'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
				$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
				$this->form_validation->set_rules('Permissao', 'Acesso as Agendas', 'required|trim');
				$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');
				$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posiçao "Sim"', 'trim|valid_aprovado');		

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('usuario/form_usuarioalterar', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
					} else {

						$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

						$data['query']['Nome'] = trim(mb_strtoupper($nomeusuario1, 'ISO-8859-1'));
						$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
						$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
						#$data['query']['Obs'] = nl2br($data['query']['Obs']);

						$data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

						if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
							$data['msg'] = '?m=1';
							redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
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
				'idSis_Usuario',
			), TRUE);
			
			$data['file'] = $this->input->post(array(
				//'idSis_Usuario',
				'Arquivo',
			), TRUE);

			if ($id) {
				$_SESSION['QueryUsuario'] = $data['query'] = $this->Usuario_model->get_usuario_verificacao_admin($id);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryUsuario']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {
					$data['file']['idSis_Usuario'] = $id;
				}
			}

			if(!$data['query']['idSis_Usuario'] || !$_SESSION['QueryUsuario']){
				
				unset($_SESSION['QueryUsuario']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			} else {
				
				$data['file']['idSis_Usuario'] = $data['query']['idSis_Usuario'];
				
				$data['titulo'] = 'Alterar Foto';
				$data['form_open_path'] = 'usuario/alterarlogo';
				$data['readonly'] = 'readonly';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
					
					$data['file']['Arquivo'] = $this->basico->renomeiausuario($_FILES['Arquivo']['name']);
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
				} else {
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
				}

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					#load login view
					$this->load->view('usuario/form_perfil', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
					} else {

						$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/usuarios/original/';
						$config['max_size'] = 1000;
						$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
						$config['file_name'] = $data['file']['Arquivo'];

						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('Arquivo')) {
							$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
							$this->load->view('usuario/form_perfil', $data);
						} else {
						
							$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/usuarios/original/';		
							$foto = $data['file']['Arquivo'];
							$diretorio = $dir.$foto;					
							$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/usuarios/miniatura/';

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
							$data['idSis_Arquivo'] = $this->Usuario_model->set_arquivo($data['file']);

							if ($data['idSis_Arquivo'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
								$this->basico->erro($msg);
								$this->load->view('usuario/form_perfil', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
								
								$data['query']['Arquivo'] = $data['file']['Arquivo'];
								$data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
								$data['campos'] = array_keys($data['query']);

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

								if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
									$data['msg'] = '?m=2';
									redirect(base_url() . 'usuario/form_perfil/' . $data['query']['idSis_Usuario'] . $data['msg']);
									exit();
								} else {
									
									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/usuarios/original/' . $_SESSION['QueryUsuario']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/usuarios/original/' . $_SESSION['QueryUsuario']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/usuarios/original/SuaFoto.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/usuarios/original/' . $_SESSION['QueryUsuario']['Arquivo'] . '');						
									}
									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['QueryUsuario']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['QueryUsuario']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/usuarios/miniatura/SuaFoto.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['QueryUsuario']['Arquivo'] . '');						
									}						
									
									if ($data['auditoriaitem'] === FALSE) {
										$data['msg'] = '';
									} else {
										$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
										$data['msg'] = '?m=1';
									}

									redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
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

    public function atuacoes($id = FALSE) {

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
				//'idSis_Empresa',
				'idSis_Usuario',
				'DataEmUsuario',
				'Agenda',
				'Vendas',
				'Servicos',
				'Entregas',
				'Sac',
				'Marketing',
				'Procedimentos',
				'Tarefas',
			), TRUE);

			(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

			$j = 1;
			for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

				if ($this->input->post('idTab_Funcao' . $i) || $this->input->post('Comissao_Funcao' . $i)) {
					
					$data['funcao'][$j]['idApp_Funcao'] = $this->input->post('idApp_Funcao' . $i);
					$data['funcao'][$j]['idTab_Funcao'] = $this->input->post('idTab_Funcao' . $i);
					$data['funcao'][$j]['Comissao_Funcao'] = $this->input->post('Comissao_Funcao' . $i);
					$data['funcao'][$j]['Ativo_Funcao'] = $this->input->post('Ativo_Funcao' . $i);
					(!$data['funcao'][$j]['Ativo_Funcao']) ? $data['funcao'][$j]['Ativo_Funcao'] = 'S' : FALSE;
					$data['radio'] = array(
						'Ativo_Funcao' . $j => $this->basico->radio_checked($data['funcao'][$j]['Ativo_Funcao'], 'Ativo_Funcao' . $j, 'NS'),
					);
					($data['funcao'][$j]['Ativo_Funcao'] == 'S') ? $data['div']['Ativo_Funcao' . $j] = '' : $data['div']['Ativo_Funcao' . $j] = 'style="display: none;"';
					
					$j++;
				}

			}
			$data['count']['PTCount'] = $j - 1;
					
			(!$data['query']['Agenda']) ? $data['query']['Agenda'] = 'N' : FALSE;
			(!$data['query']['Vendas']) ? $data['query']['Vendas'] = 'N' : FALSE;
			(!$data['query']['Servicos']) ? $data['query']['Servicos'] = 'N' : FALSE;
			(!$data['query']['Entregas']) ? $data['query']['Entregas'] = 'N' : FALSE;
			(!$data['query']['Sac']) ? $data['query']['Sac'] = 'N' : FALSE;
			(!$data['query']['Marketing']) ? $data['query']['Marketing'] = 'N' : FALSE;
			(!$data['query']['Procedimentos']) ? $data['query']['Procedimentos'] = 'N' : FALSE;
			(!$data['query']['Tarefas']) ? $data['query']['Tarefas'] = 'N' : FALSE;

			if ($id) {
				$_SESSION['QueryUsuario'] = $data['query'] = $this->Usuario_model->get_usuario_verificacao_admin($id);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryUsuario']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {				
					#### App_Funcao ####
					$_SESSION['Funcao'] = $data['funcao'] = $this->Usuario_model->get_funcao($id);
					if (count($data['funcao']) > 0) {
						$data['funcao'] = array_combine(range(1, count($data['funcao'])), array_values($data['funcao']));
						$data['count']['PTCount'] = count($data['funcao']);

						if (isset($data['funcao'])) {

							for($j=1; $j <= $data['count']['PTCount']; $j++) {
								
								$data['radio'] = array(
									'Ativo_Funcao' . $j => $this->basico->radio_checked($data['funcao'][$j]['Ativo_Funcao'], 'Ativo_Funcao' . $j, 'NS'),
								);
								($data['funcao'][$j]['Ativo_Funcao'] == 'S') ? $data['div']['Ativo_Funcao' . $j] = '' : $data['div']['Ativo_Funcao' . $j] = 'style="display: none;"';
								
							}
						}
					}
				}
			}

			if(!$data['query']['idSis_Usuario'] || !$_SESSION['QueryUsuario']){
				
				unset($_SESSION['QueryUsuario']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			} else {
				
				$data['select']['Agenda'] = $this->Basico_model->select_status_sn();
				$data['select']['Vendas'] = $this->Basico_model->select_status_sn();
				$data['select']['Servicos'] = $this->Basico_model->select_status_sn();
				$data['select']['Entregas'] = $this->Basico_model->select_status_sn();
				$data['select']['Sac'] = $this->Basico_model->select_status_sn();
				$data['select']['Marketing'] = $this->Basico_model->select_status_sn();
				$data['select']['Procedimentos'] = $this->Basico_model->select_status_sn();
				$data['select']['Tarefas'] = $this->Basico_model->select_status_sn();
				$data['select']['Ativo_Funcao'] = $this->Basico_model->select_status_sn();
				$data['select']['idTab_Funcao'] = $this->Funcao_model->select_funcao();
				
				$data['titulo'] = 'Atuações do Usuário';
				$data['form_open_path'] = 'usuario/atuacoes';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				if ($data['query']['Agenda'])
					$data['collapse'] = '';
				else
					$data['collapse'] = 'class="collapse"';

				$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
				$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

				$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				
				$this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('usuario/form_atuacoes', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
					} else {

						$data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

						$data['update']['query']['bd']  = $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']);

						
						#### App_Funcao ####
						$data['update']['funcao']['anterior'] = $this->Usuario_model->get_funcao($data['query']['idSis_Usuario']);
						if (isset($data['funcao']) || (!isset($data['funcao']) && isset($data['update']['funcao']['anterior']) ) ) {

							if (isset($data['funcao']))
								$data['funcao'] = array_values($data['funcao']);
							else
								$data['funcao'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['funcao'] = $this->basico->tratamento_array_multidimensional($data['funcao'], $data['update']['funcao']['anterior'], 'idApp_Funcao');

							$max = count($data['update']['funcao']['inserir']);
							for($j=0;$j<$max;$j++) {
								$data['update']['funcao']['inserir'][$j]['idSis_Empresa'] = $_SESSION['AdminEmpresa']['idSis_Empresa'];
								$data['update']['funcao']['inserir'][$j]['idSis_Usuario'] = $data['query']['idSis_Usuario'];
								
								$data['update']['funcao']['inserir'][$j]['Comissao_Funcao'] = str_replace(',', '.', str_replace('.', '', $data['update']['funcao']['inserir'][$j]['Comissao_Funcao']));
							}

							$max = count($data['update']['funcao']['alterar']);
							for($j=0;$j<$max;$j++) {
								
								$data['update']['funcao']['alterar'][$j]['Comissao_Funcao'] = str_replace(',', '.', str_replace('.', '', $data['update']['funcao']['alterar'][$j]['Comissao_Funcao']));
							}

							if (count($data['update']['funcao']['inserir']))
								$data['update']['funcao']['bd']['inserir'] = $this->Usuario_model->set_funcao($data['update']['funcao']['inserir']);

							if (count($data['update']['funcao']['alterar']))
								$data['update']['funcao']['bd']['alterar'] =  $this->Usuario_model->update_funcao($data['update']['funcao']['alterar']);

							if (count($data['update']['funcao']['excluir']))
								$data['update']['funcao']['bd']['excluir'] = $this->Usuario_model->delete_funcao($data['update']['funcao']['excluir']);

						}

						if ($data['auditoriaitem'] && $data['update']['query']['bd'] === FALSE) {
							$data['msg'] = '?m=1';
							redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
							exit();
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function permissoes($id = FALSE) {

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
				//'idSis_Empresa',
				'idSis_Usuario',
				'DataEmUsuario',
				'Cad_Orcam',
				'Ver_Orcam',
				'Edit_Orcam',
				'Delet_Orcam',
				'Cad_Agend',
				'Ver_Agend',
				'Edit_Agend',
				'Delet_Agend',
				'Cad_Prd',
				'Ver_Prd',
				'Edit_Prd',
				'Delet_Prd',
				'Rel_Orc',
				'Rel_Pag',
				'Rel_Prd',
				'Rel_Prc',
				'Rel_Com',
				'Rel_Est',
				'Bx_Orc',
				'Bx_Pag',
				'Bx_Prd',
				'Bx_Prc',
				'Permissao_Orcam',
				'Permissao_Agend',
				'Permissao_Comissao',
				'Horario_Atend',
			), TRUE);

			if ($id) {
				$_SESSION['QueryUsuario'] = $data['query'] = $this->Usuario_model->get_usuario_verificacao_admin($id);

				if($data['query'] === FALSE){
					
					unset($_SESSION['QueryUsuario']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acessoempresa' . $data['msg']);
					exit();
					
				} else {
				}
			}

			if(!$data['query']['idSis_Usuario'] || !$_SESSION['QueryUsuario']){
				
				unset($_SESSION['QueryUsuario']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acessoempresa' . $data['msg']);
				exit();
				
			} else {

				(!$data['query']['Rel_Com']) ? $data['query']['Rel_Com'] = 'N' : FALSE;
				
				$data['select']['Cad_Orcam'] = $this->Basico_model->select_status_sn();
				$data['select']['Ver_Orcam'] = $this->Basico_model->select_status_sn();
				$data['select']['Edit_Orcam'] = $this->Basico_model->select_status_sn();
				$data['select']['Delet_Orcam'] = $this->Basico_model->select_status_sn();
				$data['select']['Cad_Agend'] = $this->Basico_model->select_status_sn();
				$data['select']['Ver_Agend'] = $this->Basico_model->select_status_sn();
				$data['select']['Edit_Agend'] = $this->Basico_model->select_status_sn();
				$data['select']['Delet_Agend'] = $this->Basico_model->select_status_sn();
				$data['select']['Cad_Prd'] = $this->Basico_model->select_status_sn();
				$data['select']['Ver_Prd'] = $this->Basico_model->select_status_sn();
				$data['select']['Edit_Prd'] = $this->Basico_model->select_status_sn();
				$data['select']['Delet_Prd'] = $this->Basico_model->select_status_sn();
				$data['select']['Rel_Orc'] = $this->Basico_model->select_status_sn();
				$data['select']['Rel_Pag'] = $this->Basico_model->select_status_sn();
				$data['select']['Rel_Prd'] = $this->Basico_model->select_status_sn();
				$data['select']['Rel_Prc'] = $this->Basico_model->select_status_sn();
				$data['select']['Rel_Com'] = $this->Basico_model->select_status_sn();
				$data['select']['Rel_Est'] = $this->Basico_model->select_status_sn();
				$data['select']['Bx_Orc'] = $this->Basico_model->select_status_sn();
				$data['select']['Bx_Pag'] = $this->Basico_model->select_status_sn();
				$data['select']['Bx_Prd'] = $this->Basico_model->select_status_sn();
				$data['select']['Bx_Prc'] = $this->Basico_model->select_status_sn();
				$data['select']['Horario_Atend'] = $this->Basico_model->select_status_sn();
				$data['select']['Permissao_Orcam'] = array (
					'1' => '1-Retrito',
					'2' => '2-Irrestrito',
				);
				$data['select']['Permissao_Agend'] = array (
					'1' => '1-Retrito',
					'2' => '2-Irrestrito',
				);
				$data['select']['Permissao_Comissao'] = array (
					'1' => '1-Retrito à Própria',
					'2' => '2-Irrestrito s/Edição',
					'3' => '3-Irrestrito c/Edição',
				);
				
				$data['titulo'] = 'Permissões do Usuário';
				$data['form_open_path'] = 'usuario/permissoes';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				if ($data['query']['Cad_Orcam'])
					$data['collapse'] = '';
				else
					$data['collapse'] = 'class="collapse"';

						
				$data['radio'] = array(
					'Rel_Com' => $this->basico->radio_checked($data['query']['Rel_Com'], 'Comissão', 'NS'),
				);
				
				($data['query']['Rel_Com'] == 'S') ?
					$data['div']['Rel_Com'] = '' : $data['div']['Rel_Com'] = 'style="display: none;"';
					
				
				$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
				$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

				$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				$this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
				$this->form_validation->set_rules('Permissao_Orcam', 'Acesso Orcam.', 'required|trim');	
				$this->form_validation->set_rules('Permissao_Agend', 'Acesso Agend.', 'required|trim');	
				if($data['query']['Rel_Com'] == "S"){
					$this->form_validation->set_rules('Permissao_Comissao', 'Permissão da Comissão', 'required|trim');
				}
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('usuario/form_permissoes', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acessoempresa' . $data['msg']);
					} else {

						$data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

						if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
							$data['msg'] = '?m=1';
							redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
							exit();
						}
					}
				}
			}	
		}
        $this->load->view('basico/footer');
    }
/*	
    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->Usuario_model->delete_usuario($id);

        $data['msg'] = '?m=1';

		redirect(base_url() . 'agenda' . $data['msg']);
		exit();

        $this->load->view('basico/footer');
    }
*/
    function get_usuario($data) {

        if ($this->Usuario_model->lista_usuario($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_usuario', '<strong>Usuario</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
