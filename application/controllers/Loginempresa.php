<?php

#controlador de Loginempresa

defined('BASEPATH') OR exit('No direct script access allowed');

class Loginempresa extends CI_Controller {

	public function __construct() {
        parent::__construct();

        $this->load->model(array('Loginempresa_model', 'Basico_model', 'Associado_model', 'Cliente_model', 'Usuario_model', 'Empresa_model'));
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('basico', 'form_validation', 'user_agent', 'email'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerloginempresa');
        $this->load->view('basico/nav_principal_site');

        if ($this->agent->is_browser()) {

            if (
                    (preg_match("/(chrome|Firefox)/i", $this->agent->browser()) && $this->agent->version() < 30) ||
                    (preg_match("/(safari)/i", $this->agent->browser()) && $this->agent->version() < 6) ||
                    (preg_match("/(opera)/i", $this->agent->browser()) && $this->agent->version() < 12) ||
                    (preg_match("/(internet explorer)/i", $this->agent->browser()) && $this->agent->version() < 9 )
            ) {
                $msg = '<h2><strong>Navegador não suportado.</strong></h2>';

                echo $this->basico->erro($msg);
                exit();
            }
        }
    }

    public function index() {

        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        ###################################################
        #só pra eu saber quando estou no banco de testes ou de produção
        #$CI = & get_instance();
        #$CI->load->database();
        /*
		#if ($CI->db->database != 'sishuap')
        #echo $CI->db->database;
		*/
        ###################################################
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #Get GET or POST data
        $celular = $this->input->get_post('CelularAdmin');
		$empresa = $this->input->get_post('idSis_Empresa');
        $senha = md5($this->input->get_post('Senha'));

        #set validation rules
        /*
		$this->form_validation->set_rules('CelularAdmin', 'Celular do Admin', 'required|trim|callback_valid_celular');
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim|callback_valid_empresa[' . $celular . ']');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $celular . ']');
		*/
		$this->form_validation->set_rules('CelularAdmin', 'Celular do Admin', 'required|trim');
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5');

		$data['select']['idSis_Empresa'] = $this->Loginempresa_model->select_empresa();
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o loginempresa novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o loginempresa para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
            $this->load->view('loginempresa/form_loginempresa', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('UsuarioEmpresa');
            #$senha = md5($this->input->get_post('Senha'));
            /*
             
             */
            //$query = $this->Loginempresa_model->check_dados_celular($senha, $celular, TRUE);
			//$query = $this->Loginempresa_model->check_dados_empresa($empresa, $celular, TRUE);
			$query = $this->Loginempresa_model->check_dados_empresa($empresa, $celular, $senha, TRUE);
			#$_SESSION['log']['Agenda'] = $this->Loginempresa_model->get_agenda_padrao($query['idSis_Empresa']);

            #echo "<pre>".print_r($query)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usuário</strong> inexistente.";
                #$this->basico->erro($msg);
				$data['msg'] = $this->basico->msg('<strong>Empresa, Celular ou Senha</strong> incorretos.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('form_loginempresa', $data);

            } else {
                #initialize session
                $this->load->driver('session');

				$_SESSION['AdminEmpresa']  = $this->Empresa_model->get_empresa($empresa, TRUE);
		
                #$_SESSION['log']['UsuarioEmpresa'] = $query['UsuarioEmpresa'];
                //se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
				$_SESSION['log']['UsuarioEmpresa'] = (strlen($query['UsuarioEmpresa']) > 13) ? substr($query['UsuarioEmpresa'], 0, 13) : $query['UsuarioEmpresa'];
                $_SESSION['log']['Nome'] = $query['NomeAdmin'];
				$_SESSION['log']['Nome2'] = (strlen($query['NomeAdmin']) > 6) ? substr($query['NomeAdmin'], 0, 6) : $query['NomeAdmin'];
				$_SESSION['log']['CpfAdmin'] = $query['CpfAdmin'];
				$_SESSION['log']['CelularAdmin'] = $query['CelularAdmin'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 15) ? substr($query['NomeEmpresa'], 0, 15) : $query['NomeEmpresa'];
				$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
				$_SESSION['log']['PermissaoEmpresa'] = $query['PermissaoEmp'];
				$_SESSION['log']['NivelEmpresa'] = $query['NivelEmpresa'];
				$_SESSION['log']['TabelasEmpresa'] = $query['TabelasEmpresa'];
				$_SESSION['log']['DataCriacao'] = $query['DataCriacao'];
				$_SESSION['log']['DataDeValidade'] = $query['DataDeValidade'];
				$_SESSION['log']['Site'] = $query['Site'];

                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Loginempresa_model->set_acesso($_SESSION['log']['idSis_Empresa'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('form_loginempresa');
                } else {
					redirect('acessoempresa');
					#redirect('agenda');
					#redirect('cliente');
                }
            }
        }

        #load footer view
        #$this->load->view('basico/footerloginempresa');
        $this->load->view('basico/footer');
    }

    public function registrar() {
	
        $this->load->view('basico/logologin');
		
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            #'UsuarioEmpresa',
			'NomeEmpresa',
            'EnderecoEmpresa',
            'NumeroEmpresa',
            'ComplementoEmpresa',
            'BairroEmpresa',
            'MunicipioEmpresa',
            'EstadoEmpresa',
            'CepEmpresa',
            'NomeAdmin',
			'DataNascimento',
			'Sexo',
            //'CpfAdmin',
            'CelularAdmin',
            'ConfirmaCelular',
            'Email',
            'ConfirmaEmail',
			'Senha',
            'Confirma',
			'DataCriacao',
			'DataDeValidade',
			'NumUsuarios',
			'Site',
		), TRUE);
		
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

		$nomeadmin1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['NomeAdmin'], $caracteres_sem_acento));		
				
		(!$data['query']['DataCriacao']) ? $data['query']['DataCriacao'] = date('d/m/Y', time()) : FALSE;
		
		$data['Ano'] = date('Y', time());
		$data['Mes'] = date('m', time());
		$data['Dia'] = date('d', time());

		if($data['Dia'] <= 28){
			$data['Diaref'] = $data['Dia'];
			$data['Qtd'] = "1";
		}elseif($data['Dia'] == 29){
			$data['Diaref'] = "01";
			$data['Qtd'] = "2";
		}elseif($data['Dia'] == 30){
			$data['Diaref'] = "02";
			$data['Qtd'] = "2";
		}elseif($data['Dia'] == 31){
			$data['Diaref'] = "03";
			$data['Qtd'] = "2";
		}
		
		$data['DataRef'] = date($data['Ano']. '-'.$data['Mes'].'-'.$data['Diaref']);
		//$data['DataValidade'] = date('d/m/Y', strtotime('+1 month',strtotime($data['DataRef'])));
		
		$data['DataValidade'] = date('d/m/Y', strtotime('+'.$data['Qtd']. ' month',strtotime($data['DataRef'])));	
		
		//(!$data['query']['DataDeValidade']) ? $data['query']['DataDeValidade'] = date('d/m/Y', strtotime('+1 month')) : FALSE;
		(!$data['query']['DataDeValidade']) ? $data['query']['DataDeValidade'] = $data['DataValidade'] : FALSE;

		if (isset($data['query']['Site'])) {
			$data['query']['Site'] = $this->basico->url_amigavel($data['query']['Site']);
		}

		$data['select']['NumUsuarios'] = $this->Basico_model->select_numusuarios();
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();		
		
		$this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');
		$this->form_validation->set_rules('Site', 'Nome do Site', 'required|trim|is_unique_site[Sis_Empresa.Site]');		
		$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim|is_unique[Sis_Empresa.NomeEmpresa]');
		#$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim');	
		#$this->form_validation->set_rules('CpfAdmin', 'Cpf', 'required|trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[Sis_Empresa.CpfAdmin.NomeEmpresa.' . $data['query']['NomeEmpresa'] . ']');
        #$this->form_validation->set_rules('UsuarioEmpresa', 'Usuário', 'required|trim|is_unique[Sis_Empresa.UsuarioEmpresa]');
		$this->form_validation->set_rules('EnderecoEmpresa', 'Endereço', 'required|trim');
		$this->form_validation->set_rules('NumeroEmpresa', 'Número', 'required|trim');
		$this->form_validation->set_rules('ComplementoEmpresa', 'Complemento', 'trim');
		$this->form_validation->set_rules('BairroEmpresa', 'Bairro', 'required|trim');
		$this->form_validation->set_rules('MunicipioEmpresa', 'Cidade', 'required|trim');
		$this->form_validation->set_rules('EstadoEmpresa', 'Estado', 'required|trim');
		$this->form_validation->set_rules('CepEmpresa', 'CEP', 'required|trim');
		$this->form_validation->set_rules('NomeAdmin', 'Nome do Administrador', 'required|trim');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
		$this->form_validation->set_rules('CelularAdmin', 'Celular', 'required|trim|is_unique[Sis_Empresa.CelularAdmin]|valid_celular');
		$this->form_validation->set_rules('ConfirmaCelular', 'Confirmar Celular', 'required|trim|matches[CelularAdmin]');
		$this->form_validation->set_rules('Email', 'E-mail', 'required|trim|valid_email');
        $this->form_validation->set_rules('ConfirmaEmail', 'Confirmar Email', 'required|trim|matches[Email]');
		//$this->form_validation->set_rules('CelularAdmin', 'Celular', 'required|trim|alpha_numeric_spaces|is_unique_duplo[Sis_Empresa.CelularAdmin.NomeEmpresa.' . $data['query']['NomeEmpresa'] . ']');
		#$this->form_validation->set_rules('CelularAdmin', 'CelularAdmin', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');			
		#$this->form_validation->set_rules('NumUsuarios', 'Número de Usuários', 'required|trim');

		#run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
			$this->load->view('loginempresa/form_registrar', $data);
		} else {
			$data['query']['NomeEmpresa'] = trim(mb_strtoupper($data['query']['NomeEmpresa'], 'ISO-8859-1'));
			$data['query']['EnderecoEmpresa'] = trim(mb_strtoupper($data['query']['EnderecoEmpresa'], 'ISO-8859-1'));
			$data['query']['NumeroEmpresa'] = trim(mb_strtoupper($data['query']['NumeroEmpresa'], 'ISO-8859-1'));
			$data['query']['ComplementoEmpresa'] = trim(mb_strtoupper($data['query']['ComplementoEmpresa'], 'ISO-8859-1'));
			$data['query']['BairroEmpresa'] = trim(mb_strtoupper($data['query']['BairroEmpresa'], 'ISO-8859-1'));
			$data['query']['MunicipioEmpresa'] = trim(mb_strtoupper($data['query']['MunicipioEmpresa'], 'ISO-8859-1'));
			$data['query']['EstadoEmpresa'] = trim(mb_strtoupper($data['query']['EstadoEmpresa'], 'ISO-8859-1'));
			$data['query']['CepEmpresa'] = trim(mb_strtoupper($data['query']['CepEmpresa'], 'ISO-8859-1'));
			$data['query']['NomeAdmin'] = trim(mb_strtoupper($nomeadmin1, 'ISO-8859-1'));
			//$data['query']['Site'] = trim(mb_strtoupper($data['query']['Site'], 'UTF-8'));
			$data['query']['idSis_EmpresaMatriz'] = 2;
			$data['query']['Associado'] = 2;
			$data['query']['PermissaoEmpresa'] = 1;
			$data['query']['NivelEmpresa'] = 4;
			$data['query']['idTab_Modulo'] = 1;
			$data['query']['NumUsuarios'] = 1;
			$data['query']['Telefone'] = $data['query']['CelularAdmin'];
			$data['query']['UsuarioEmpresa'] = $data['query']['CelularAdmin'];
			$data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'mysql');
			$data['query']['DataDeValidade'] = $this->basico->mascara_data($data['query']['DataDeValidade'], 'mysql');
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            if(!isset($data['query']['DataNascimento']) || empty($data['query']['DataNascimento'])){
				$data['query']['DataNascimento'] = "0000-00-00";
			}
			$data['query']['Senha'] = md5($data['query']['Senha']);
			//$data['query']['Senha'] = password_hash($data['query']['Senha'], PASSWORD_DEFAULT);
			$data['query']['Codigo'] = md5(uniqid(time() . rand()));
			#$data['query']['Site'] = "sitedaempresa";
			#$data['query']['Inativo'] = 1;
			//ACESSO LIBERADO PRA QUEM REALIZAR O CADASTRO
			$data['query']['Inativo'] = 0;
			/*
			echo "<br>";
			echo "<pre>";
			echo "<br>";
			print_r($data['query']);
			echo "</pre>";			
			exit();
			*/
			unset($data['query']['Confirma']);
			unset($data['query']['ConfirmaCelular']);
			unset($data['query']['ConfirmaEmail']);

		
			$data['associado'] = $this->Loginempresa_model->get_associado($data['query']['CelularAdmin']);
			

			if(!isset($data['associado']) || $data['associado'] === FALSE){

				$data['associado']['Nome'] = $data['query']['NomeAdmin'];
				$data['associado']['Email'] = $data['query']['Email'];
				//$data['associado']['CpfAssociado'] = $data['query']['CpfAdmin'];
				$data['associado']['idSis_Empresa'] = 5;
				$data['associado']['idTab_Modulo'] = 1;
				$data['associado']['DataNascimento'] = $data['query']['DataNascimento'];
				$data['associado']['DataCriacao'] = $data['query']['DataCriacao'];
				$data['associado']['Inativo'] = 0;
				$data['associado']['CelularAssociado'] = $data['query']['CelularAdmin'];
				$data['associado']['Associado'] = $data['query']['CelularAdmin'];
				$data['associado']['Senha'] = $data['query']['Senha'];
				$data['associado']['Codigo'] = $data['query']['Codigo'];
				
				$data['anterior'] = array();
				$data['campos'] = array_keys($data['associado']);

				$data['associado']['idSis_Associado'] = $this->Associado_model->set_associado($data['associado']);

				if ($data['associado']['idSis_Associado'] === FALSE) {
					$data['msg'] = '?m=2';
					$this->load->view('loginempresa/form_registrar', $data);
				} else {				
							
					$data['agenda'] = array(
						'NomeAgenda' => 'Associado',
						'idSis_Associado' => $data['associado']['idSis_Associado']
					);
					$data['campos'] = array_keys($data['agenda']);

					$data['idApp_Agenda'] = $this->Loginempresa_model->set_agenda($data['agenda']);
					/*
					echo "<br>";
					echo "<pre>";
					echo "<br>";
					print_r('Associado Cadastrado = '.$data['associado']['idSis_Associado']);
					echo "</pre>";
					*/
				}
				
			}else{

				#### Sis_Associado ####
				$data['update']['associado']['alterar']['Senha'] = $data['query']['Senha'];
				$data['update']['associado']['alterar']['Codigo'] = $data['query']['Codigo'];
				
				$data['update']['associado']['bd'] = $this->Associado_model->update_associado($data['update']['associado']['alterar'], $data['associado']['idSis_Associado']);

				#### App_Cliente ####
				$data['update']['cliente']['alterar'] = $this->Cliente_model->get_cliente_associado($data['associado']['idSis_Associado']);
				
				if (isset($data['update']['cliente']['alterar'])){

					$max_cliente = count($data['update']['cliente']['alterar']);

					for($j=0;$j<$max_cliente;$j++) {
					
						$data['update']['cliente']['alterar'][$j]['senha'] 	= $data['query']['Senha'];
						$data['update']['cliente']['alterar'][$j]['Codigo'] = $data['query']['Codigo'];

						$data['update']['cliente']['bd'][$j] = $this->Cliente_model->update_cliente($data['update']['cliente']['alterar'][$j], $data['update']['cliente']['alterar'][$j]['idApp_Cliente']);
							
					}
				}				
				
				
				#### Sis_Usuario ####
				$data['update']['usuario']['alterar'] = $this->Usuario_model->get_usuario_associado($data['associado']['idSis_Associado']);
				
				if (isset($data['update']['usuario']['alterar'])){

					$max_usuario = count($data['update']['usuario']['alterar']);

					for($j=0;$j<$max_usuario;$j++) {
					
						$data['update']['usuario']['alterar'][$j]['Senha'] 	= $data['query']['Senha'];
						$data['update']['usuario']['alterar'][$j]['Codigo'] = $data['query']['Codigo'];

						$data['update']['usuario']['bd'][$j] = $this->Cliente_model->update_usuario($data['update']['usuario']['alterar'][$j], $data['update']['usuario']['alterar'][$j]['idSis_Usuario']);
							
					}
				}
				
				
				#### Sis_Empresa ####
				$data['update']['empresa']['alterar'] = $this->Empresa_model->get_empresa_associado($data['associado']['idSis_Associado']);

				if (isset($data['update']['empresa']['alterar'])){

					$max_empresa = count($data['update']['empresa']['alterar']);

					for($j=0;$j<$max_empresa;$j++) {
					
						$data['update']['empresa']['alterar'][$j]['Senha'] 	= $data['query']['Senha'];
						$data['update']['empresa']['alterar'][$j]['Codigo'] = $data['query']['Codigo'];

						$data['update']['empresa']['bd'][$j] = $this->Empresa_model->update_empresa($data['update']['empresa']['alterar'][$j], $data['update']['empresa']['alterar'][$j]['idSis_Empresa']);
							
					}
				}
			}

			if(!isset($data['associado']['idSis_Associado']) || $data['associado']['idSis_Associado'] === FALSE){
				$data['msg'] = '?m=2';
				$this->load->view('loginempresa/form_registrar', $data);				
			}else{
				
				$data['query']['idSis_Associado'] = $data['associado']['idSis_Associado'];
				/*
				echo "<br>";
				echo "<pre>";
				echo "<br>";
				print_r('Associado Nº = '.$data['associado']['idSis_Associado']);
				echo "</pre>";
				*/
			
				$data['anterior'] = array();
				$data['campos'] = array_keys($data['query']);

				$data['idSis_Empresa'] = $this->Loginempresa_model->set_empresa($data['query']);
				$_SESSION['log']['idSis_Empresa'] = 1;

				if ($data['idSis_Empresa'] === FALSE) {
					$data['msg'] = '?m=2';
					$this->load->view('loginempresa/form_registrar', $data);
				} else {
					
					$data['atendimento']['1']['Dia_Semana'] = "SEGUNDA";
					$data['atendimento']['2']['Dia_Semana'] = "TERCA";
					$data['atendimento']['3']['Dia_Semana'] = "QUARTA";
					$data['atendimento']['4']['Dia_Semana'] = "QUINTA";
					$data['atendimento']['5']['Dia_Semana'] = "SEXTA";
					$data['atendimento']['6']['Dia_Semana'] = "SABADO";
					$data['atendimento']['7']['Dia_Semana'] = "DOMINGO";
					
					for($j=1; $j<=7; $j++) {
						$data['atendimento'][$j] = array(
							'idSis_Empresa' => $data['idSis_Empresa'],
							'id_Dia' => $j,
							'Dia_Semana' => $data['atendimento'][$j]['Dia_Semana'],
							'Aberto' => "S",
							'Hora_Abre' => "00:00:00",
							'Hora_Fecha' => "23:59:59"
						);
						$data['campos'] = array_keys($data['atendimento'][$j]);
						$data['idApp_Atendimento'] = $this->Loginempresa_model->set_atendimento($data['atendimento'][$j]);
					}
					
					$data['funcao'] = array(
						'idSis_Empresa' => $data['idSis_Empresa'],
						'idSis_Usuario' => "0",
						'idTab_Modulo' => "1",
						'Funcao' => "ADMINISTRADOR",
						'Abrev' => "ADM"
					);
					$data['campos'] = array_keys($data['funcao']);

					$data['idTab_Funcao'] = $this->Loginempresa_model->set_funcao($data['funcao']);
					$_SESSION['log']['idSis_Empresa'] = 1;
					
					if ($data['idTab_Funcao'] === FALSE) {
						$data['msg'] = '?m=2';
						$this->load->view('loginempresa/form_registrar', $data);
					} else {	
						
						$data['usuario'] = array(
							'idSis_Associado' => $data['associado']['idSis_Associado'],
							'idSis_Empresa' => $data['idSis_Empresa'],
							'Funcao' => $data['idTab_Funcao'],
							'NomeEmpresa' => $data['query']['NomeEmpresa'],
							'Nome' => $data['query']['NomeAdmin'],
							'CelularUsuario' => $data['query']['CelularAdmin'],
							'Usuario' => $data['query']['CelularAdmin'],
							'DataCriacao' => $data['query']['DataCriacao'],
							'DataNascimento' => $data['query']['DataNascimento'],
							'Sexo' => $data['query']['Sexo'],
							'Senha' => $data['query']['Senha'],
							'Codigo' => $data['query']['Codigo'],
							//'CpfUsuario' => $data['query']['CpfAdmin'],
							'Cad_Orcam' => "S",
							'Ver_Orcam' => "S",
							'Edit_Orcam' => "S",
							'Delet_Orcam' => "S",
							'Cad_Prd' => "S",
							'Ver_Prd' => "S",
							'Edit_Prd' => "S",
							'Delet_Prd' => "S",
							'Rel_Orc' => "S",
							'Rel_Pag' => "S",
							'Rel_Prd' => "S",
							'Rel_Prc' => "S",
							'Rel_Com' => "S",
							'Rel_Est' => "S",
							'Bx_Orc' => "S",
							'Bx_Pag' => "S",
							'Bx_Prd' => "S",
							'Bx_Prc' => "S",
							'Cad_Agend' => "S",
							'Ver_Agend' => "S",
							'Edit_Agend' => "S",
							'Delet_Agend' => "S",
							'Permissao_Agend' => "2",
							'Permissao_Orcam' => "2",
							'Permissao_Comissao' => "3",
							'Inativo' => "0",
							'idTab_Modulo' => "1",
							'Permissao' => "3"
						);
						$data['campos'] = array_keys($data['usuario']);

						$data['idSis_Usuario'] = $this->Loginempresa_model->set_usuario($data['usuario']);
						$_SESSION['log']['idSis_Empresa'] = 1;

						if ($data['idSis_Usuario'] === FALSE) {
							$data['msg'] = '?m=2';
							$this->load->view('loginempresa/form_registrar', $data);
						} else {

							/*
							  echo $this->db->last_query();
							  echo "<pre>";
							  print_r($data);
							  echo "</pre>";
							  exit();
							 */
							/* 
							$data['agenda'] = array(
								'NomeAgenda' => 'Usuario',
								'idSis_Usuario' => $data['idSis_Usuario'],
								'idSis_Empresa' => $data['idSis_Empresa']
							);
							$data['campos'] = array_keys($data['agenda']);

							$data['idApp_Agenda'] = $this->Loginempresa_model->set_agenda($data['agenda']);
							*/
							
							$data['cliente'] = array(
								'NomeCliente' => 'CLIENTE DESCONHECIDO',
								'DataCadastroCliente'=> date('Y-m-d', time()),
								'idTab_Modulo' => "1",
								'idSis_Usuario' => $data['idSis_Usuario'],
								'idSis_Empresa' => $data['idSis_Empresa']
							);
							$data['campos'] = array_keys($data['cliente']);

							$data['idApp_Cliente'] = $this->Loginempresa_model->set_cliente($data['cliente']);
							
							$data['fornecedor'] = array(
								'NomeFornecedor' => 'FORNECEDOR DESCONHECIDO',
								'DataCadastroFornecedor'=> date('Y-m-d', time()),
								'idTab_Modulo' => "1",
								'idSis_Usuario' => $data['idSis_Usuario'],
								'idSis_Empresa' => $data['idSis_Empresa']
							);
							$data['campos'] = array_keys($data['fornecedor']);

							$data['idApp_Fornecedor'] = $this->Loginempresa_model->set_fornecedor($data['fornecedor']);
							
							$data['slide'] = array(
								'Slide1' => 'slide.jpg',
								'idSis_Usuario' => $data['idSis_Usuario'],
								'idSis_Empresa' => $data['idSis_Empresa']
							);
							$data['campos'] = array_keys($data['slide']);
							$data['idApp_Slides'] = $this->Loginempresa_model->set_slide($data['slide']);					

							
							$data['documentos'] = array(
								'idSis_Usuario' => $data['idSis_Usuario'],					
								'idSis_Empresa' => $data['idSis_Empresa']
							);
							$data['campos'] = array_keys($data['documentos']);
							$data['idApp_Documentos'] = $this->Loginempresa_model->set_documentos($data['documentos']);

							$data['catprod'] = array(
								'Catprod' => 'PRODUTOS DE TESTES',
								'idTab_Modulo' => "1",
								'idSis_Usuario' => $data['idSis_Usuario'],
								'idSis_Empresa' => $data['idSis_Empresa']
							);
							$data['campos'] = array_keys($data['catprod']);
							$data['idTab_Catprod'] = $this->Loginempresa_model->set_catprod($data['catprod']);					

							if ($data['idTab_Catprod'] === FALSE) {
								$data['msg'] = '?m=2';
								$this->load->view('loginempresa/form_registrar', $data);
							} else {
							
								$data['produto'] = array(
									'Produtos' => 'PRODUTO TESTE',
									'idTab_Modulo' => "1",
									'VendaSite' => "S",
									'idTab_Catprod' => $data['idTab_Catprod'],
									'idSis_Usuario' => $data['idSis_Usuario'],
									'idSis_Empresa' => $data['idSis_Empresa']
								);
								$data['campos'] = array_keys($data['produto']);
								$data['idTab_Produto'] = $this->Loginempresa_model->set_produto($data['produto']);					

								if ($data['idTab_Produto'] === FALSE) {
									$data['msg'] = '?m=2';
									$this->load->view('loginempresa/form_registrar', $data);
								} else {
										
									$data['produtos'] = array(
										'idSis_Usuario' => $data['idSis_Usuario'],
										'idSis_Empresa' => $data['idSis_Empresa'],
										'idTab_Modulo' => "1",
										'idTab_Catprod' => $data['idTab_Catprod'],
										'idTab_Produto' => $data['idTab_Produto'],
										'Opcao_Atributo_1' => "0",
										'Opcao_Atributo_2' => "0",
										'Nome_Prod' => $data['produto']['Produtos'],
										'Cod_Prod' => $data['idTab_Catprod'] . ':' . $data['idTab_Produto'] . ':0:0',
										'VendaSite' => "S"
									);
									$data['campos'] = array_keys($data['produtos']);
									$data['idTab_Produtos'] = $this->Loginempresa_model->set_produtos($data['produtos']);

									if ($data['idTab_Produtos'] === FALSE) {
										$data['msg'] = '?m=2';
										$this->load->view('loginempresa/form_registrar', $data);
									} else {
									
										$data['valor'] = array(
											'idSis_Usuario' => $data['idSis_Usuario'],
											'idSis_Empresa' => $data['idSis_Empresa'],
											'idTab_Modulo' => "1",
											'idTab_Promocao' => "1",
											'Item_Promocao' => "1",
											'idTab_Produtos' => $data['idTab_Produtos'],
											'idTab_Catprod' => $data['idTab_Catprod'],
											'idTab_Produto' => $data['idTab_Produto'],
											'ValorProduto' => '1.00',
											'Desconto' => "1",
											'QtdProdutoDesconto' => "1",
											'QtdProdutoIncremento' => "1"
										);
										$data['campos'] = array_keys($data['valor']);
										$data['idTab_Valor'] = $this->Loginempresa_model->set_valor($data['valor']);
											
										if ($data['idTab_Valor'] === FALSE) {
											$data['msg'] = '?m=2';
											$this->load->view('loginempresa/form_registrar', $data);
										} else {
												
											//início da criação o site da Empresa///
											//este é o NOME do site escolhido na hora da criação da empresa!!
											
											$pasta = '../' .$data['query']['Site']. '';

											// checar se a pasta existe
											if (!is_dir($pasta)){
												//cria a pasta
												mkdir($pasta, 0777);
											
												//este é o TAMPLATE do site escolhido na hora da criação da empresa!!
												$tamplate = '../site2';				
												if (is_dir($tamplate)){
													foreach(scandir($tamplate) as $arquivo){
														$caminho_arquivo = "$tamplate/$arquivo";
														if(is_file($caminho_arquivo)){
															//echo $caminho_arquivo . PHP_EOL;
															/////copy($caminho_arquivo, "../nomedosite/$arquivo");
															copy($caminho_arquivo, "../" .$data['query']['Site']. "/$arquivo");
														}
													}
												}

												/////$nome_arquivo = "../nomedosite/configuracao.php";
												$nome_arquivo = "../" .$data['query']['Site']. "/configuracao.php";
												//echo $nome_arquivo;
												$arquivo = fopen($nome_arquivo, 'r+');
												fwrite($arquivo, '<?php' . PHP_EOL);
												fwrite($arquivo, '//Dados da Empresa' . PHP_EOL);
												fwrite($arquivo, '$idSis_Empresa = ' . $data['idSis_Empresa'] . ';'  . PHP_EOL);
												fwrite($arquivo, 'define("IDSIS_EMPRESA", "'. $data['idSis_Empresa'] .'");');
												fclose($arquivo);
											}
											//Fim da criação do site da empresa///
									
											$pasta1 = $_UP['pasta'] = '../'.$data['query']['Site'].'/'.$data['idSis_Empresa'].'/';
											mkdir($pasta1, 0777);
											
											$pasta2 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/';
											mkdir($pasta2, 0777);
											
											$pasta21 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/original/';
											mkdir($pasta21, 0777);
															
											$pasta22 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/';
											mkdir($pasta22, 0777);				
											
											$arquivo_origem21 = 'arquivos/imagens/empresas/1/documentos/miniatura/SuaLogo.jpg';
											$arquivo_destino21 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/SuaLogo.jpg';
											copy($arquivo_origem21, $arquivo_destino21);
											
											$arquivo_origem22 = 'arquivos/imagens/empresas/1/documentos/miniatura/icone.ico';
											$arquivo_destino22 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/icone.ico';
											copy($arquivo_origem22, $arquivo_destino22);
											
											$arquivo_origem23 = 'arquivos/imagens/empresas/1/documentos/miniatura/logo_nav.png';
											$arquivo_destino23 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/logo_nav.png';
											copy($arquivo_origem23, $arquivo_destino23);
											
											$arquivo_origem24 = 'arquivos/imagens/empresas/1/documentos/miniatura/slide.jpg';
											$arquivo_destino24 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/slide.jpg';
											copy($arquivo_origem24, $arquivo_destino24);				
											
											$pasta3 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/';
											mkdir($pasta3, 0777);
											
											$pasta31 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/original/';
											mkdir($pasta31, 0777);
											
											$pasta32 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/miniatura/';
											mkdir($pasta32, 0777);				

											$arquivo_origem3 = 'arquivos/imagens/empresas/1/usuarios/miniatura/SuaFoto.jpg';
											$arquivo_destino3 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/miniatura/SuaFoto.jpg';
											
											copy($arquivo_origem3, $arquivo_destino3);				
											
											$pasta4 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/clientes/';
											mkdir($pasta4, 0777);
											
											$pasta41 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/clientes/original/';
											mkdir($pasta41, 0777);
											
											$pasta42 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/clientes/miniatura/';
											mkdir($pasta42, 0777);				
											
											$arquivo_origem4 = 'arquivos/imagens/empresas/1/clientes/miniatura/Foto.jpg';
											$arquivo_destino4 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/clientes/miniatura/Foto.jpg';
											
											copy($arquivo_origem4, $arquivo_destino4);
											
											$arquivo_origem4pet = 'arquivos/imagens/empresas/1/clientes/miniatura/pata.png';
											$arquivo_destino4pet = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/clientes/miniatura/pata.png';
											
											copy($arquivo_origem4pet, $arquivo_destino4pet);
											
											$pasta5 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/produtos/';
											mkdir($pasta5, 0777);
											
											$pasta51 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/produtos/original/';
											mkdir($pasta51, 0777);
											
											$pasta52 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/produtos/miniatura/';
											mkdir($pasta52, 0777);				
											
											$arquivo_origem5 = 'arquivos/imagens/empresas/1/produtos/miniatura/fotoproduto.jpg';
											$arquivo_destino5 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/produtos/miniatura/fotoproduto.jpg';
											
											copy($arquivo_origem5, $arquivo_destino5);
											
											
											$pasta6 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/promocao/';
											mkdir($pasta6, 0777);
											
											$pasta61 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/promocao/original/';
											mkdir($pasta61, 0777);
											
											$pasta62 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/promocao/miniatura/';
											mkdir($pasta62, 0777);				
											
											$arquivo_origem6 = 'arquivos/imagens/empresas/1/promocao/miniatura/fotopromocao.jpg';
											$arquivo_destino6 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/promocao/miniatura/fotopromocao.jpg';
											
											copy($arquivo_origem6, $arquivo_destino6);
												
										}
											
									}
								}		
							}			
						}
						#$this->load->library('email');

						
						//DADOS PARA ENVIO DE E-MAIL DE CONFIRMAÇÃO DE INSCRIÇÃO
						$config['protocol'] = 'smtp';
						$config['mailpath'] = "/usr/sbin/sendmail";
						$config['smtp_host'] = 'smtp.zoho.com';
						$config['smtp_user'] = 'contato@enkontraki.com.br';
						$config['smtp_pass'] = '#20ContatoKtraca21!';
						$config['charset'] = 'iso-8859-1';
						$config['mailtype'] = 'html';
						$config['wrapchars'] = '50';
						$config['smtp_port'] = '587';
						$config['smtp_crypto'] = 'tls';
						$config['newline'] = "\r\n";

						$this->email->initialize($config);

						$this->email->from('contato@enkontraki.com.br', 'Enkontraki');
						$this->email->to($data['query']['Email']);

						$this->email->subject('[Enkontraki] Criação da Empresa : ' . $data['query']['NomeEmpresa']);
						$this->email->message('Olá ' . $data['query']['NomeAdmin'] . '! Seja muito bem vindo à Enkontraki!');

						$this->email->send();						

						#$this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
						#$this->email->to($data['query']['Email']);

						#$this->email->subject('[KTRACA] Confirmação de registro - Usuário: ' . $data['query']['UsuarioEmpresa']);
						/*
						  $this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
						  . 'http://www.romati.com.br/app/loginempresa/confirmar/' . $data['query']['Codigo']);

						  $this->email->send();

						  $data['aviso'] = ''
						  . '
						  <div class="alert alert-success" role="alert">
						  <h4>
						  <p><b>Usuário cadastrado com sucesso!</b></p>
						  <p>O link para ativação foi enviado para seu e-mail cadastrado.</p>
						  <p>Caso o e-mail com o link não esteja na sua caixa de entrada <b>verifique também sua caixa de SPAM</b>.</p>
						  </h4>
						  </div> '
						  . '';
						 */

						#$this->email->message('Sua conta foi ativada com sucesso! Aproveite e teste todas as funcionalidades do sistema.'
								#. 'Qualquer sugestão ou crítica será bem vinda. ');

						#$this->email->send();

						$data['aviso'] = ''
								. '
						  <div class="alert alert-success" role="alert">
						  <h4>
						  <p><b>Empresa cadastrado com sucesso! "' . $data['query']['NomeEmpresa'] . '" Nº ' . $data['idSis_Empresa'] . '</b></p>
						  <p>Clique no botão abaixo e retorne para a tela de Login do Usuário.<br>
						  Para entrar no sistema, insira o número da empresa, informado acima,<br>
						  o celular cadastrado como login e a senha cadastrada.</p>
						  </h4>
						  <br>
						 
						  </div> '
								. '';

						$this->load->view('loginempresa/tela_msg', $data);
						#redirect(base_url() . 'loginempresa' . $data['msg']);
						#exit();
					}
				}
			}
		}

        #$this->load->view('basico/footerloginempresa');
        #$this->load->view('basico/baselogin');
        $this->load->view('basico/footer');
    }

    public function registrar2() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'Email',
            #'UsuarioEmpresa',
			'NomeEmpresa',
            'EnderecoEmpresa',
            'NumeroEmpresa',
            'ComplementoEmpresa',
            'BairroEmpresa',
            'MunicipioEmpresa',
            'EstadoEmpresa',
            'CepEmpresa',
            'NomeAdmin',
			'DataNascimento',
			'Sexo',
            'CpfAdmin',
			'Senha',
            'Confirma',
            'CelularAdmin',
			'DataCriacao',
			'DataDeValidade',
			'NumUsuarios',
			'Associado',
			'Site',
		), TRUE);

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

		$nomeadmin1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['NomeAdmin'], $caracteres_sem_acento));		
		
		(!$data['query']['DataCriacao']) ? $data['query']['DataCriacao'] = date('d/m/Y', time()) : FALSE;
		
		$data['Ano'] = date('Y', time());
		$data['Mes'] = date('m', time());
		$data['Dia'] = date('d', time());
		
		if($data['Dia'] <= 28){
			$data['Diaref'] = $data['Dia'];
			$data['Qtd'] = "1";
		}elseif($data['Dia'] == 29){
			$data['Diaref'] = "01";
			$data['Qtd'] = "2";
		}elseif($data['Dia'] == 30){
			$data['Diaref'] = "02";
			$data['Qtd'] = "2";
		}elseif($data['Dia'] == 31){
			$data['Diaref'] = "03";
			$data['Qtd'] = "2";
		}
		
		$data['DataRef'] = date($data['Ano']. '-'.$data['Mes'].'-'.$data['Diaref']);
		//$data['DataValidade'] = date('d/m/Y', strtotime('+1 month',strtotime($data['DataRef'])));
		
		$data['DataValidade'] = date('d/m/Y', strtotime('+'.$data['Qtd']. ' month',strtotime($data['DataRef'])));	
		
		//(!$data['query']['DataDeValidade']) ? $data['query']['DataDeValidade'] = date('d/m/Y', strtotime('+1 month')) : FALSE;
		(!$data['query']['DataDeValidade']) ? $data['query']['DataDeValidade'] = $data['DataValidade'] : FALSE;

		if (isset($data['query']['Site'])) {
			$data['query']['Site'] = $this->basico->url_amigavel($data['query']['Site']);
		}		
		
		$this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');
		$this->form_validation->set_rules('Site', 'Nome do Site', 'required|trim|is_unique_site[Sis_Empresa.Site]');		
		$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim|is_unique[Sis_Empresa.NomeEmpresa]');
		#$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim');
		#$this->form_validation->set_rules('CpfAdmin', 'Cpf', 'required|trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[Sis_Empresa.CpfAdmin.NomeEmpresa.' . $data['query']['NomeEmpresa'] . ']');
		$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');		
        #$this->form_validation->set_rules('UsuarioEmpresa', 'Usuário', 'required|trim|is_unique[Sis_Empresa.UsuarioEmpresa]');
		$this->form_validation->set_rules('EnderecoEmpresa', 'Endereço', 'required|trim');
		$this->form_validation->set_rules('NumeroEmpresa', 'Número', 'required|trim');
		$this->form_validation->set_rules('ComplementoEmpresa', 'Complemento', 'trim');
		$this->form_validation->set_rules('BairroEmpresa', 'Bairro', 'required|trim');
		$this->form_validation->set_rules('MunicipioEmpresa', 'Cidade', 'required|trim');
		$this->form_validation->set_rules('EstadoEmpresa', 'Estado', 'required|trim');
		$this->form_validation->set_rules('CepEmpresa', 'CEP', 'required|trim');
		$this->form_validation->set_rules('NomeAdmin', 'Nome do Administrador', 'required|trim');      	
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
		$this->form_validation->set_rules('CelularAdmin', 'CelularAdmin', 'required|trim|alpha_numeric_spaces|is_unique_duplo[Sis_Empresa.CelularAdmin.NomeEmpresa.' . $data['query']['NomeEmpresa'] . ']');
		#$this->form_validation->set_rules('CelularAdmin', 'CelularAdmin', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');		
		#$this->form_validation->set_rules('NumUsuarios', 'Número de Usuários', 'required|trim');
		
		$data['select']['NumUsuarios'] = $this->Basico_model->select_numusuarios();
        $data['select']['Associado'] = $this->Basico_model->select_empresa3();
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
		
		#run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
            $this->load->view('loginempresa/form_registrar2', $data);
        } else {
			
			$data['query']['NomeEmpresa'] = trim(mb_strtoupper($data['query']['NomeEmpresa'], 'ISO-8859-1'));
			$data['query']['EnderecoEmpresa'] = trim(mb_strtoupper($data['query']['EnderecoEmpresa'], 'ISO-8859-1'));
			$data['query']['NumeroEmpresa'] = trim(mb_strtoupper($data['query']['NumeroEmpresa'], 'ISO-8859-1'));
			$data['query']['ComplementoEmpresa'] = trim(mb_strtoupper($data['query']['ComplementoEmpresa'], 'ISO-8859-1'));
			$data['query']['BairroEmpresa'] = trim(mb_strtoupper($data['query']['BairroEmpresa'], 'ISO-8859-1'));
			$data['query']['MunicipioEmpresa'] = trim(mb_strtoupper($data['query']['MunicipioEmpresa'], 'ISO-8859-1'));
			$data['query']['EstadoEmpresa'] = trim(mb_strtoupper($data['query']['EstadoEmpresa'], 'ISO-8859-1'));
			$data['query']['CepEmpresa'] = trim(mb_strtoupper($data['query']['CepEmpresa'], 'ISO-8859-1'));
			$data['query']['NomeAdmin'] = trim(mb_strtoupper($nomeadmin1, 'ISO-8859-1'));			
			$data['query']['idSis_EmpresaMatriz'] = 2;
			$data['query']['Associado'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['PermissaoEmpresa'] = 1;
			$data['query']['NivelEmpresa'] = 4;
			$data['query']['idTab_Modulo'] = 1;
			$data['query']['NumUsuarios'] = 1;
            $data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'mysql');
			$data['query']['DataDeValidade'] = $this->basico->mascara_data($data['query']['DataDeValidade'], 'mysql');
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');			
			$data['query']['Senha'] = md5($data['query']['Senha']);
            //$data['query']['Senha'] = password_hash($data['query']['Senha'], PASSWORD_DEFAULT);
            $data['query']['Codigo'] = md5(uniqid(time() . rand()));
			#$data['query']['Site'] = "sitedaempresa";
            #$data['query']['Inativo'] = 1;
            //ACESSO LIBERADO PRA QUEM REALIZAR O CADASTRO
            $data['query']['Inativo'] = 0;
            unset($data['query']['Confirma']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            $data['idSis_Empresa'] = $this->Loginempresa_model->set_empresa($data['query']);
            $_SESSION['log']['idSis_Empresa'] = 1;

            if ($data['idSis_Empresa'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('loginempresa/form_registrar2', $data);
            } else {

				$data['atendimento']['1']['Dia_Semana'] = "SEGUNDA";
                $data['atendimento']['2']['Dia_Semana'] = "TERCA";
                $data['atendimento']['3']['Dia_Semana'] = "QUARTA";
                $data['atendimento']['4']['Dia_Semana'] = "QUINTA";
                $data['atendimento']['5']['Dia_Semana'] = "SEXTA";
                $data['atendimento']['6']['Dia_Semana'] = "SABADO";
                $data['atendimento']['7']['Dia_Semana'] = "DOMINGO";
				
				for($j=1; $j<=7; $j++) {
					$data['atendimento'][$j] = array(
						'idSis_Empresa' => $data['idSis_Empresa'],
						'id_Dia' => $j,
						'Dia_Semana' => $data['atendimento'][$j]['Dia_Semana'],
						'Aberto' => "S",
						'Hora_Abre' => "00:00:00",
						'Hora_Fecha' => "23:59:59"
					);
					$data['campos'] = array_keys($data['atendimento'][$j]);
					$data['idApp_Atendimento'] = $this->Loginempresa_model->set_atendimento($data['atendimento'][$j]);
				}
				
				$data['funcao'] = array(
					'idSis_Empresa' => $data['idSis_Empresa'],
					'idSis_Usuario' => "0",
					'idTab_Modulo' => "1",
					'Funcao' => "ADMINISTRADOR",
					'Abrev' => "ADM"
				);
				$data['campos'] = array_keys($data['funcao']);

				$data['idTab_Funcao'] = $this->Loginempresa_model->set_funcao($data['funcao']);
				$_SESSION['log']['idSis_Empresa'] = 1;
				
				if ($data['idTab_Funcao'] === FALSE) {
					$data['msg'] = '?m=2';
					$this->load->view('loginempresa/form_registrar2', $data);
				} else {	
					
					$data['usuario'] = array(

						'idSis_Empresa' => $data['idSis_Empresa'],
						'Funcao' => $data['idTab_Funcao'],
						'NomeEmpresa' => $data['query']['NomeEmpresa'],
						'Nome' => $data['query']['NomeAdmin'],
						'CelularUsuario' => $data['query']['CelularAdmin'],
						'DataCriacao' => $data['query']['DataCriacao'],
						'DataNascimento' => $data['query']['DataNascimento'],
						'Sexo' => $data['query']['Sexo'],
						'Senha' => $data['query']['Senha'],
						'Codigo' => $data['query']['Codigo'],
						'CpfUsuario' => $data['query']['CpfAdmin'],
						'Inativo' => "0",
						'idTab_Modulo' => "1",
						'Permissao' => "3"
					);
					$data['campos'] = array_keys($data['usuario']);

					$data['idSis_Usuario'] = $this->Loginempresa_model->set_usuario($data['usuario']);
					$_SESSION['log']['idSis_Empresa'] = 1;

					if ($data['idSis_Usuario'] === FALSE) {
						$data['msg'] = '?m=2';
						$this->load->view('loginempresa/form_registrar2', $data);
					} else {

						/*
						  echo $this->db->last_query();
						  echo "<pre>";
						  print_r($data);
						  echo "</pre>";
						  exit();
						 */
						$data['agenda'] = array(
							'NomeAgenda' => 'Usuario',
							'idSis_Usuario' => $data['idSis_Usuario'],
							'idSis_Empresa' => $data['idSis_Empresa']
						);
						$data['campos'] = array_keys($data['agenda']);

						$data['idApp_Agenda'] = $this->Loginempresa_model->set_agenda($data['agenda']);

						$data['cliente'] = array(
							'NomeCliente' => 'CLIENTE DESCONHECIDO',
							'DataCadastroCliente'=> date('Y-m-d', time()),
							'idTab_Modulo' => "1",
							'idSis_Usuario' => $data['idSis_Usuario'],
							'idSis_Empresa' => $data['idSis_Empresa']
						);
						$data['campos'] = array_keys($data['cliente']);

						$data['idApp_Cliente'] = $this->Loginempresa_model->set_cliente($data['cliente']);

						$data['fornecedor'] = array(
							'NomeFornecedor' => 'FORNECEDOR DESCONHECIDO',
							'DataCadastroFornecedor'=> date('Y-m-d', time()),
							'idTab_Modulo' => "1",
							'idSis_Usuario' => $data['idSis_Usuario'],
							'idSis_Empresa' => $data['idSis_Empresa']
						);
						$data['campos'] = array_keys($data['fornecedor']);

						$data['idApp_Fornecedor'] = $this->Loginempresa_model->set_fornecedor($data['fornecedor']);
						
						$data['slide'] = array(
							'Slide1' => 'slide.jpg',
							'idSis_Usuario' => $data['idSis_Usuario'],
							'idSis_Empresa' => $data['idSis_Empresa']
						);
						$data['campos'] = array_keys($data['slide']);
						$data['idApp_Slides'] = $this->Loginempresa_model->set_slide($data['slide']);					

						
						$data['documentos'] = array(
							'idSis_Usuario' => $data['idSis_Usuario'],					
							'idSis_Empresa' => $data['idSis_Empresa']
						);
						$data['campos'] = array_keys($data['documentos']);
						$data['idApp_Documentos'] = $this->Loginempresa_model->set_documentos($data['documentos']);

						$data['catprod'] = array(
							'Catprod' => 'PRODUTOS DE TESTES',
							'idTab_Modulo' => "1",
							'idSis_Usuario' => $data['idSis_Usuario'],
							'idSis_Empresa' => $data['idSis_Empresa']
						);
						$data['campos'] = array_keys($data['catprod']);
						$data['idTab_Catprod'] = $this->Loginempresa_model->set_catprod($data['catprod']);					

						if ($data['idTab_Catprod'] === FALSE) {
							$data['msg'] = '?m=2';
							$this->load->view('loginempresa/form_registrar2', $data);
						} else {
						
							$data['produto'] = array(
								'Produtos' => 'PRODUTO TESTE',
								'idTab_Modulo' => "1",
								'VendaSite' => "S",
								'idTab_Catprod' => $data['idTab_Catprod'],
								'idSis_Usuario' => $data['idSis_Usuario'],
								'idSis_Empresa' => $data['idSis_Empresa']
							);
							$data['campos'] = array_keys($data['produto']);
							$data['idTab_Produto'] = $this->Loginempresa_model->set_produto($data['produto']);					

							if ($data['idTab_Produto'] === FALSE) {
								$data['msg'] = '?m=2';
								$this->load->view('loginempresa/form_registrar2', $data);
							} else {
									
								$data['produtos'] = array(
									'idSis_Usuario' => $data['idSis_Usuario'],
									'idSis_Empresa' => $data['idSis_Empresa'],
									'idTab_Modulo' => "1",
									'idTab_Catprod' => $data['idTab_Catprod'],
									'idTab_Produto' => $data['idTab_Produto'],
									'Opcao_Atributo_1' => "0",
									'Opcao_Atributo_2' => "0",
									'Nome_Prod' => $data['produto']['Produtos'],
									'Cod_Prod' => $data['idTab_Catprod'] . ':' . $data['idTab_Produto'] . ':0:0',
									'VendaSite' => "S"
								);
								$data['campos'] = array_keys($data['produtos']);
								$data['idTab_Produtos'] = $this->Loginempresa_model->set_produtos($data['produtos']);

								if ($data['idTab_Produtos'] === FALSE) {
									$data['msg'] = '?m=2';
									$this->load->view('loginempresa/form_registrar2', $data);
								} else {	
									
									$data['valor'] = array(
										'idSis_Usuario' => $data['idSis_Usuario'],
										'idSis_Empresa' => $data['idSis_Empresa'],
										'idTab_Modulo' => "1",
										'idTab_Promocao' => "1",
										'Item_Promocao' => "1",
										'idTab_Produtos' => $data['idTab_Produtos'],
										'idTab_Catprod' => $data['idTab_Catprod'],
										'idTab_Produto' => $data['idTab_Produto'],
										'ValorProduto' => '1.00',
										'Desconto' => "1",
										'QtdProdutoDesconto' => "1",
										'QtdProdutoIncremento' => "1"
									);
									$data['campos'] = array_keys($data['valor']);
									$data['idTab_Valor'] = $this->Loginempresa_model->set_valor($data['valor']);
										
									if ($data['idTab_Valor'] === FALSE) {
										$data['msg'] = '?m=2';
										$this->load->view('loginempresa/form_registrar2', $data);
									} else {
											
										//início da criação o site da Empresa///
										//este é o NOME do site escolhido na hora da criação da empresa!!
										
										$pasta = '../' .$data['query']['Site']. '';

										// checar se a pasta existe
										if (!is_dir($pasta)){
											//cria a pasta
											mkdir($pasta, 0777);
										
											//este é o TAMPLATE do site escolhido na hora da criação da empresa!!
											$tamplate = '../site2';				
											if (is_dir($tamplate)){
												foreach(scandir($tamplate) as $arquivo){
													$caminho_arquivo = "$tamplate/$arquivo";
													if(is_file($caminho_arquivo)){
														//echo $caminho_arquivo . PHP_EOL;
														/////copy($caminho_arquivo, "../nomedosite/$arquivo");
														copy($caminho_arquivo, "../" .$data['query']['Site']. "/$arquivo");
													}
												}
											}

											/////$nome_arquivo = "../nomedosite/configuracao.php";
											$nome_arquivo = "../" .$data['query']['Site']. "/configuracao.php";
											//echo $nome_arquivo;
											$arquivo = fopen($nome_arquivo, 'r+');
											fwrite($arquivo, '<?php' . PHP_EOL);
											fwrite($arquivo, '//Dados da Empresa' . PHP_EOL);
											fwrite($arquivo, '$idSis_Empresa = ' . $data['idSis_Empresa'] . ';'  . PHP_EOL);
											fwrite($arquivo, 'define("IDSIS_EMPRESA", "'. $data['idSis_Empresa'] .'");');
											fclose($arquivo);
										}
										//Fim da criação do site da empresa///
								
										$pasta1 = $_UP['pasta'] = '../'.$data['query']['Site'].'/'.$data['idSis_Empresa'].'/';
										mkdir($pasta1, 0777);
										
										$pasta2 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/';
										mkdir($pasta2, 0777);
										
										$pasta21 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/original/';
										mkdir($pasta21, 0777);
														
										$pasta22 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/';
										mkdir($pasta22, 0777);				
										
										$arquivo_origem21 = 'arquivos/imagens/empresas/1/documentos/miniatura/SuaLogo.jpg';
										$arquivo_destino21 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/SuaLogo.jpg';
										copy($arquivo_origem21, $arquivo_destino21);
										
										$arquivo_origem22 = 'arquivos/imagens/empresas/1/documentos/miniatura/icone.ico';
										$arquivo_destino22 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/icone.ico';
										copy($arquivo_origem22, $arquivo_destino22);
										
										$arquivo_origem23 = 'arquivos/imagens/empresas/1/documentos/miniatura/logo_nav.png';
										$arquivo_destino23 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/logo_nav.png';
										copy($arquivo_origem23, $arquivo_destino23);
										
										$arquivo_origem24 = 'arquivos/imagens/empresas/1/documentos/miniatura/slide.jpg';
										$arquivo_destino24 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/slide.jpg';
										copy($arquivo_origem24, $arquivo_destino24);				
										
										$pasta3 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/';
										mkdir($pasta3, 0777);
										
										$pasta31 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/original/';
										mkdir($pasta31, 0777);
										
										$pasta32 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/miniatura/';
										mkdir($pasta32, 0777);				

										$arquivo_origem3 = 'arquivos/imagens/empresas/1/usuarios/miniatura/SuaFoto.jpg';
										$arquivo_destino3 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/miniatura/SuaFoto.jpg';
										
										copy($arquivo_origem3, $arquivo_destino3);				
										
										$pasta4 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/clientes/';
										mkdir($pasta4, 0777);
										
										$pasta41 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/clientes/original/';
										mkdir($pasta41, 0777);
										
										$pasta42 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/clientes/miniatura/';
										mkdir($pasta42, 0777);				
										
										$arquivo_origem4 = 'arquivos/imagens/empresas/1/clientes/miniatura/Foto.jpg';
										$arquivo_destino4 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/clientes/miniatura/Foto.jpg';
										
										copy($arquivo_origem4, $arquivo_destino4);
										
										$arquivo_origem4pet = 'arquivos/imagens/empresas/1/clientes/miniatura/pata.png';
										$arquivo_destino4pet = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/clientes/miniatura/pata.png';
										
										copy($arquivo_origem4pet, $arquivo_destino4pet);
										
										$pasta5 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/produtos/';
										mkdir($pasta5, 0777);
										
										$pasta51 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/produtos/original/';
										mkdir($pasta51, 0777);
										
										$pasta52 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/produtos/miniatura/';
										mkdir($pasta52, 0777);				
										
										$arquivo_origem5 = 'arquivos/imagens/empresas/1/produtos/miniatura/fotoproduto.jpg';
										$arquivo_destino5 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/produtos/miniatura/fotoproduto.jpg';
										
										copy($arquivo_origem5, $arquivo_destino5);
										
										
										$pasta6 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/promocao/';
										mkdir($pasta6, 0777);
										
										$pasta61 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/promocao/original/';
										mkdir($pasta61, 0777);
										
										$pasta62 = $_UP['pasta'] = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/promocao/miniatura/';
										mkdir($pasta62, 0777);				
										
										$arquivo_origem6 = 'arquivos/imagens/empresas/1/promocao/miniatura/fotopromocao.jpg';
										$arquivo_destino6 = '../'.$data['query']['Site'].'/' .$data['idSis_Empresa'].'/promocao/miniatura/fotopromocao.jpg';
										
										copy($arquivo_origem6, $arquivo_destino6);
											
									}
										
								}
							}		
						}			
					}
				}	
			
                 /*          
                $this->load->library('email');

                $this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                $this->email->to($data['query']['Email']);

                $this->email->subject('[KTRACA] Confirmação de registro - Usuário: ' . $data['query']['UsuarioEmpresa']);
               
                  $this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                  . 'http://www.romati.com.br/app/loginempresa/confirmar/' . $data['query']['Codigo']);

                  $this->email->send();

                  $data['aviso'] = ''
                  . '
                  <div class="alert alert-success" role="alert">
                  <h4>
                  <p><b>Usuário cadastrado com sucesso!</b></p>
                  <p>O link para ativação foi enviado para seu e-mail cadastrado.</p>
                  <p>Caso o e-mail com o link não esteja na sua caixa de entrada <b>verifique também sua caixa de SPAM</b>.</p>
                  </h4>
                  </div> '
                  . '';
                 

                $this->email->message('Sua conta foi ativada com sucesso! Aproveite e teste todas as funcionalidades do sistema.'
                        . 'Qualquer sugestão ou crítica será bem vinda. ');

                $this->email->send();
				*/
                $data['aviso'] = ''
                        . '
                  <div class="alert alert-success" role="alert">
                  <h4>
                  <p><b>Empresa cadastrado com sucesso! "' . $data['query']['NomeEmpresa'] . '" Nº ' . $data['idSis_Empresa'] . '</b></p>
                  <p>Clique no botão abaixo e retorne para a tela de Login do Administrador.<br>
				  Para entrar no sistema, insira o número da empresa, informado acima,<br>
				  o celular cadastrado como login e a senha cadastrada.</p>
                  </h4>
                  <br>
                  </div> '
                        . '';

                $this->load->view('loginempresa/tela_msg', $data);
                #redirect(base_url() . 'loginempresa' . $data['msg']);
                #exit();
            }
        }

        #$this->load->view('basico/footerloginempresa');
        $this->load->view('basico/footer');
    }
	
    public function confirmar($codigo) {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;


        $data['anterior'] = array(
            'Inativo' => '1',
            'Codigo' => $codigo
        );

        $data['confirmar'] = array(
            'Inativo' => '0',
            'Codigo' => 'NULL'
        );

        $data['campos'] = array_keys($data['confirmar']);
        $id = $this->Loginempresa_model->get_data_by_codigo($codigo);

        if ($this->Loginempresa_model->ativa_usuario($codigo, $data['confirmar']) === TRUE) {

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idSis_Empresa'], TRUE);
            $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem'], $id['idSis_Empresa']);

            $data['msg'] = '?m=4';
            redirect(base_url() . 'loginempresa/' . $data['msg']);
        } else {
            $data['msg'] = '?m=5';
            redirect(base_url() . 'loginempresa/' . $data['msg']);
        }
    }

    public function recuperar() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'UsuarioEmpresa',
                ), TRUE);

        if (isset($_GET['usuario']))
            $data['query']['UsuarioEmpresa'] = $_GET['usuario'];

        $this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

        $this->form_validation->set_rules('UsuarioEmpresa', 'UsuarioEmpresa', 'required|trim|callback_valid_usuario');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
            $this->load->view('loginempresa/form_recuperar', $data);
        } else {

            $data['query']['Codigo'] = md5(uniqid(time() . rand()));

            $id = $this->Loginempresa_model->get_data_by_usuario($data['query']['UsuarioEmpresa']);

            if ($this->Loginempresa_model->troca_senha($id['idSis_Empresa'], array('Codigo' => $data['query']['Codigo'])) === FALSE) {

                $data['anterior'] = array(
                    'Codigo' => 'NULL'
                );

                $data['confirmar'] = array(
                    'Codigo' => $data['query']['Codigo']
                );

                $data['campos'] = array_keys($data['confirmar']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idSis_Empresa'], TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem'], $id['idSis_Empresa']);

                $this->load->library('email');

                $this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                $this->email->to($id['Email']);

                $this->email->subject('[KTRACA] Alteração de Senha - Usuário: ' . $data['query']['UsuarioEmpresa']);
                $this->email->message('Por favor, clique no link a seguir para alterar sua senha: '
                        //. 'http://www.romati.com.br/app/loginempresa/trocar_senha/' . $data['query']['Codigo']);
                        . base_url() . 'loginempresa/trocar_senha/' . $data['query']['Codigo']);

                $this->email->send();

                $data['aviso'] = ''
                        . '
                    <div class="alert alert-success" role="alert">
                        <h4>
                            <p><b>Link enviado com sucesso!</b></p>
                            <p>O link para alterar senha foi enviado para seu e-mail.</p>
                            <p>Caso o e-mail com o link não esteja na sua caixa de entrada <b>verifique também sua caixa de SPAM</b>.</p>
                        </h4>
                    </div> '
                        . '';

                #$data['msg'] = '?m=4';
                $this->load->view('loginempresa/tela_msg', $data);
            } else {
                $data['msg'] = '?m=5';
                redirect(base_url() . 'loginempresa/' . $data['msg']);
            }
        }
    }

    public function trocar_senha($codigo = NULL) {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idSis_Empresa',
            'Email',
            'UsuarioEmpresa',
            'Codigo',
                ), TRUE);

        if ($codigo) {
            $data['query'] = $this->Loginempresa_model->get_data_by_codigo($codigo);
            $data['query']['Codigo'] = $codigo;
        } else {
            $data['query']['Codigo'] = $this->input->post('Codigo', TRUE);
        }

        $data['query']['Senha'] = $this->input->post('Senha', TRUE);
        $data['query']['Confirma'] = $this->input->post('Confirma', TRUE);

        $this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        #$this->form_validation->set_rules('Codigo', 'Código', 'required|trim');
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
            $this->load->view('loginempresa/form_troca_senha', $data);
        } else {

            ###não está registrando a auditoria do trocar senha. tenho que ver isso
            ###ver também o link para troca, quando expirado avisar
            #$id = $data['query']['Senha']
            $data['query']['Senha'] = md5($data['query']['Senha']);
            $data['query']['Codigo'] = NULL;
            unset($data['query']['Confirma']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            if ($this->Loginempresa_model->troca_senha($data['query']['idSis_Empresa'], $data['query']) === TRUE) {
                $data['msg'] = '?m=2';
                $this->load->view('loginempresa/form_troca_senha', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem'], $data['query']['idSis_Empresa']);
                /*
                  echo $this->db->last_query();
                  echo "<pre>";
                  print_r($data);
                  echo "</pre>";
                  exit();
                 */
                $data['msg'] = '?m=1';
                redirect(base_url() . 'loginempresa' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footerloginempresa');
        $this->load->view('basico/footer');
    }

    public function sair($m = TRUE) {
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #set logout in database
        if ($_SESSION['log']['idSis_Empresa'] && $m === TRUE) {
            $this->Loginempresa_model->set_acesso($_SESSION['log']['idSis_Empresa'], 'LOGOUT');
        } else {
            if (!isset($_SESSION['log']['idSis_Empresa'])) {
                $_SESSION['log']['idSis_Empresa'] = 1;
            }
            $this->Loginempresa_model->set_acesso($_SESSION['log']['idSis_Empresa'], 'TIMEOUT');
            $data['msg'] = '?m=3';
        }

        #clear de session data
        $this->session->unset_userdata('log');
		
        foreach ($_SESSION as $key => $value) {

			if ($key != 'Site_Back') {

				unset($_SESSION[$key]);
				
			}
		}
		
		//desliguei,abaixo, todas as funções que apagam todas as sessões 
		/*
		session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
		*/

        /*
          #load header view
          $this->load->view('basico/headerloginempresa');

          $msg = "<strong>Você saiu do sistema.</strong>";

          $this->basico->alerta($msg);
          $this->load->view('loginempresa');
          $this->load->view('basico/footer');
         *
         */

        //redirect(base_url() . 'login/' . $data['msg']);
        redirect(base_url() . '../enkontraki/');
        #redirect('loginempresa');
    }

	function valid_celular($celular) {

        if ($this->Loginempresa_model->check_celular($celular) == 1) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> não existe.');
            return FALSE;
        } else if ($this->Loginempresa_model->check_celular($celular) == 2) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> inativo! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	function valid_empresa($empresa, $celular) {

        if ($this->Loginempresa_model->check_dados_empresa($empresa, $celular) == FALSE) {
            $this->form_validation->set_message('valid_empresa', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function valid_senha($senha, $celular) {

        if ($this->Loginempresa_model->check_dados_celular($senha, $celular) == FALSE) {
            $this->form_validation->set_message('valid_senha', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
