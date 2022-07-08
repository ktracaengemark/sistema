<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Revendedor extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Relacao_model', 'Usuario_model', 'Associado_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('contatousuario/nav_secundario');
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

    public function cadastrar($idSis_Usuario = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['Empresa']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
				
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'Cadastrar',
			), TRUE));
			
			$data['query'] = quotes_to_entities($this->input->post(array(
				'Nome',
				'Senha',
				'Confirma',
				'DataNascimento',
				'CelularUsuario',
				'Email',
				'Sexo',
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
			), TRUE));


			if ($idSis_Usuario) {
				$_SESSION['Funcionario'] = $data['funcionario'] = $this->Usuario_model->get_funcionario_verificacao($idSis_Usuario, TRUE);
		
				if($data['funcionario'] === FALSE){
					
					unset($_SESSION['Funcionario']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
					
				}
			}
		
			if(!$_SESSION['Funcionario']){
				
				unset($_SESSION['Funcionario']);
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

				$nomeusuario1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['Nome'], $caracteres_sem_acento));		
				
				$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['EnderecoUsuario'], $caracteres_sem_acento));

				$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['query']['CepUsuario'], $caracteres_sem_acento));

				$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['BairroUsuario'], $caracteres_sem_acento));

				$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['MunicipioUsuario'], $caracteres_sem_acento));

				$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['EstadoUsuario'], $caracteres_sem_acento));

							
				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
				$data['select']['Sexo'] = $this->Basico_model->select_sexo();
				$data['select']['Inativo'] = $this->Basico_model->select_inativo();
				$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
				$data['select']['CompAgenda'] = $this->Basico_model->select_status_sn();
				$data['titulo'] = 'Cadastrar Usuário';
				$data['form_open_path'] = 'revendedor/cadastrar';
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

				$data['tela'] = $this->load->view('usuario/form_usuario2', $data, TRUE);
				
				$data['q3'] = $this->Usuario_model->list_funcao(TRUE);
				$data['list3'] = $this->load->view('usuario/list_funcao', $data, TRUE);

				$data['nav_secundario'] = $this->load->view('usuario/nav_secundario2', $data, TRUE);
					
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				$this->form_validation->set_rules('Nome', 'Nome do Usuário', 'required|trim');
				$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuário', 'required|trim|is_unique_duplo[Sis_Usuario.CelularUsuario.idSis_Empresa.' . $_SESSION['log']['idSis_Empresa'] . ']');
				$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');			
				$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
				$this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');		
				$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email|is_unique_duplo[Sis_Usuario.Email.idSis_Empresa.' . $_SESSION['log']['idSis_Empresa'] . ']');
				$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
				$this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
				$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posiçao "Sim"', 'trim|valid_aprovado');
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('usuario/form_usuario2', $data);
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
						
						$data['associado']['Nome'] = trim(mb_strtoupper($nomeusuario1, 'ISO-8859-1'));
						$data['associado']['idSis_Empresa'] = 5;
						$data['associado']['NomeEmpresa'] = "CONTA PESSOAL";
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
							$this->load->view('usuario/form_usuario2', $data);
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
							$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
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
							$data['query']['Permissao'] = 3;
							$data['query']['Nivel'] = 2;
							$data['query']['Comissao'] = 0;
							
							$data['query']['Cad_Agend'] = "S";
							$data['query']['Ver_Agend'] = "S";
							$data['query']['Edit_Agend'] = "S";
							$data['query']['Delet_Agend'] = "S";
							$data['query']['Permissao_Agend'] = 1;
							
							$data['query']['Cad_Orcam'] = "S";
							$data['query']['Ver_Orcam'] = "S";
							$data['query']['Permissao_Orcam'] = 1;
							
							$data['query']['Ver_Prd'] = "S";
							
							$data['query']['Rel_Orc'] = "S";
							$data['query']['Rel_Pag'] = "S";
							$data['query']['Rel_Prd'] = "S";
							$data['query']['Rel_Prc'] = "S";
							$data['query']['Rel_Com'] = "S";
							$data['query']['Permissao_Comissao'] = 1;

							unset($data['query']['Confirma']);

							$data['campos'] = array_keys($data['query']);
							$data['anterior'] = array();

							$data['query']['idSis_Usuario'] = $this->Usuario_model->set_usuario($data['query']);

							if ($data['query']['idSis_Usuario'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

								$this->basico->erro($msg);
								$this->load->view('usuario/form_usuario2', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'CREATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
								
								redirect(base_url() . 'revendedor/pesquisar/' . $data['query']['QuemCad'] . $data['msg']);
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
						$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
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
						$data['query']['Permissao'] = 3;
						$data['query']['Nivel'] = 2;
						$data['query']['Comissao'] = 0;
							
						$data['query']['Cad_Agend'] = "S";
						$data['query']['Ver_Agend'] = "S";
						$data['query']['Edit_Agend'] = "S";
						$data['query']['Delet_Agend'] = "S";
						$data['query']['Permissao_Agend'] = 1;
						
						$data['query']['Cad_Orcam'] = "S";
						$data['query']['Ver_Orcam'] = "S";
						$data['query']['Permissao_Orcam'] = 1;
						
						$data['query']['Ver_Prd'] = "S";
						
						$data['query']['Rel_Orc'] = "S";
						$data['query']['Rel_Pag'] = "S";
						$data['query']['Rel_Prd'] = "S";
						$data['query']['Rel_Prc'] = "S";
						$data['query']['Rel_Com'] = "S";
						$data['query']['Permissao_Comissao'] = 1;

						unset($data['query']['Confirma']);

						$data['campos'] = array_keys($data['query']);
						$data['anterior'] = array();

						$data['query']['idSis_Usuario'] = $this->Usuario_model->set_usuario($data['query']);

						if ($data['query']['idSis_Usuario'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('usuario/form_usuario2', $data);
						} else {

							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], FALSE);
							$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
							
							redirect(base_url() . 'revendedor/pesquisar/' . $data['query']['QuemCad'] . $data['msg']);
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
		
		if ($_SESSION['Empresa']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
				
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'Cadastrar',
			), TRUE));
		   
			$data['query'] = $this->input->post(array(
				'idSis_Usuario',
				'Nome',
				'DataNascimento',
				'Email',
				'Sexo',
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
			), TRUE);

			if ($id) {
				
				$_SESSION['Revendedor'] = $data['query'] = $this->Usuario_model->get_revendedor($id);

				if($data['query'] === FALSE){
					
					unset($_SESSION['Revendedor']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
					$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
					$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'barras');
				}
			}

			if(!$data['query']['idSis_Usuario'] || !$_SESSION['Revendedor']){
				
				unset($_SESSION['Revendedor']);
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

				$nomeusuario1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['Nome'], $caracteres_sem_acento));		
				
				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
				$data['select']['Municipio'] = $this->Basico_model->select_municipio();
				$data['select']['Sexo'] = $this->Basico_model->select_sexo();
				$data['select']['Inativo'] = $this->Basico_model->select_inativo();
				$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
				$data['titulo'] = 'Editar Revendedor';
				$data['form_open_path'] = 'revendedor/alterar';
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

				$data['nav_secundario'] = $this->load->view('usuario/nav_secundario2', $data, TRUE);

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				$this->form_validation->set_rules('Nome', 'Nome do Usuario', 'required|trim');
				$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
				$this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
				$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
				$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');
				$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posiçao "Sim"', 'trim|valid_aprovado');		

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('usuario/form_usuarioalterar2', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
					} else {

						$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

						$data['query']['Nome'] = trim(mb_strtoupper($nomeusuario1, 'ISO-8859-1'));
						$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
						$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
						
						$data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
						
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

						if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
							$data['msg'] = '?m=1';
							redirect(base_url() . 'revendedor/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'revendedor/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
							exit();
						}
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
		
		if ($_SESSION['Empresa']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
			
			if (!$id) {
					
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}else{		
				
				$data['query'] = $this->Usuario_model->get_revendedor($id, TRUE);
			
				if($data['query'] === FALSE){
					
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {

					$data['titulo'] = 'Revendedor: ' . $data['query']['Nome'];
					$data['panel'] = 'primary';
					$data['metodo'] = 4;

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

					$data['contatorevendedor'] = $this->Usuario_model->lista_contatousuario($id, TRUE);
					/*
					  echo "<pre>";
					  print_r($data['contatorevendedor']);
					  echo "</pre>";
					  exit();
					  */
					if (!$data['contatorevendedor'])
						$data['list'] = FALSE;
					else
						$data['list'] = $this->load->view('usuario/list_contatorevendedor', $data, TRUE);

					$data['nav_secundario'] = $this->load->view('usuario/nav_secundario2', $data, TRUE);
					
					$this->load->view('usuario/tela_revendedor', $data);
				}
			}
			
		}
        $this->load->view('basico/footer');
    }

}
