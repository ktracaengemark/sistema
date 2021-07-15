<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model(array('Login_model', 'Basico_model'));
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('basico', 'form_validation', 'user_agent', 'email'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerlogin');
        //$this->load->view('basico/nav_principal_site');

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
        #if ($CI->db->database != 'sishuap')
        #echo $CI->db->database;
        ###################################################
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #Get GET or POST data
        
		$celular = $this->input->get_post('CelularUsuario');
        $empresa = $this->input->get_post('idSis_Empresa');
		$senha = md5($this->input->get_post('Senha'));

        #set validation rules
        
		$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuário', 'required|trim|callback_valid_celular');
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim|callback_check_empresa|callback_valid_empresa[' . $celular . ']');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $celular . ']');

        $data['select']['idSis_Empresa'] = $this->Login_model->select_empresa1();
		
		if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o login novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o login para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 6)
            $data['msg'] = $this->basico->msg('<strong>Faça Login, para acessar o sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('login/form_login1', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('Usuario');
            #$senha = md5($this->input->get_post('Senha'));
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */
            
			$query = $this->Login_model->check_dados_celular($senha, $celular, TRUE);
			$query = $this->Login_model->check_dados_empresa($empresa, $celular, TRUE);
            $_SESSION['log']['Agenda'] = $this->Login_model->get_agenda_padrao($query['idSis_Usuario']);

            
			#### Carrega os dados da Empresa nas vari?ves de sess?o ####

			$query2 = $this->Login_model->check_documentos_log($empresa, TRUE);			
			$_SESSION['log']['Icone'] = $query2['Icone'];
            
			$query3 = $this->Login_model->dados_empresa_log($empresa);			
			$_SESSION['log']['NivelEmpresa'] = $query3['NivelEmpresa'];
			$_SESSION['log']['TabelasEmpresa'] = $query3['TabelasEmpresa'];
			$_SESSION['log']['DataDeValidade'] = $query3['DataDeValidade'];
			$_SESSION['log']['Site'] = $query3['Site'];
			$_SESSION['log']['Arquivo_Empresa'] = $query3['Arquivo'];
			
			/*  
			  echo "<pre>";
              print_r($_SESSION['log']['NivelEmpresa']);
              echo "</pre>";
			  echo "<pre>";
			  print_r($_SESSION['log']['TabelasEmpresa']);
              echo "</pre>";
			  echo "<pre>";
			  print_r($_SESSION['log']['DataDeValidade']);
              echo "</pre>";
              exit();
			
			$_SESSION['log']['NivelEmpresa'] = $this->Login_model->get_empresa($query['idSis_Usuario']);
			$_SESSION['log']['TabelasEmpresa'] = $this->Login_model->get_empresa1($query['idSis_Usuario']);
			$_SESSION['log']['DataDeValidade'] = $this->Login_model->get_empresa2($query['idSis_Usuario']);
			*/
			#echo "<pre>".print_r($query2)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usuário</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('form_login1', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['Usuario'] = $query['Usuario'];
                //se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
                $_SESSION['log']['Usuario'] = (strlen($query['Usuario']) > 13) ? substr($query['Usuario'], 0, 13) : $query['Usuario'];
				$_SESSION['log']['Nome'] = $query['Nome'];
				$_SESSION['log']['Nome2'] = (strlen($query['Nome']) > 6) ? substr($query['Nome'], 0, 6) : $query['Nome'];
				$_SESSION['log']['CpfUsuario'] = $query['CpfUsuario'];
				$_SESSION['log']['CelularUsuario'] = $query['CelularUsuario'];
				$_SESSION['log']['idSis_Usuario'] = $query['idSis_Usuario'];
				$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
				#$_SESSION['log']['NivelEmpresa'] = $query['NivelEmpresa'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 6) ? substr($query['NomeEmpresa'], 0, 6) : $query['NomeEmpresa'];
				$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
				$_SESSION['log']['idTab_Modulo'] = $query['idTab_Modulo'];
				$_SESSION['log']['Permissao'] = $query['Permissao'];
				$_SESSION['log']['Arquivo'] = $query['Arquivo'];

				
                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Login_model->set_acesso($_SESSION['log']['idSis_Usuario'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('form_login1');
                } else {
					redirect('acesso');
					#redirect('agenda');
					#redirect('cliente');
                }
            }
        }

        #load footer view
        #$this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }	

    public function index1() {

        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        ###################################################
        #só pra eu saber quando estou no banco de testes ou de produção
        #$CI = & get_instance();
        #$CI->load->database();
        #if ($CI->db->database != 'sishuap')
        #echo $CI->db->database;
        ###################################################
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #Get GET or POST data
        
		$celular = $this->input->get_post('CelularUsuario');
        $empresa = $this->input->get_post('idSis_Empresa');
		$senha = md5($this->input->get_post('Senha'));

        #set validation rules
        
		$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuário', 'required|trim|callback_valid_celular');
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim|callback_check_empresa|callback_valid_empresa[' . $celular . ']');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $celular . ']');

        $data['select']['idSis_Empresa'] = $this->Login_model->select_empresa1();
		
		if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o login novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o login para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('login/form_login1', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('Usuario');
            #$senha = md5($this->input->get_post('Senha'));
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */
            
			$query = $this->Login_model->check_dados_celular($senha, $celular, TRUE);
			$query = $this->Login_model->check_dados_empresa($empresa, $celular, TRUE);
            $_SESSION['log']['Agenda'] = $this->Login_model->get_agenda_padrao($query['idSis_Usuario']);

            
			#### Carrega os dados da Empresa nas vari?ves de sess?o ####
			
			$query2 = $this->Login_model->check_documentos_log($empresa, TRUE);
			$_SESSION['log']['Icone'] = $query2['Icone'];
			
			$query3 = $this->Login_model->dados_empresa_log($empresa);			
			$_SESSION['log']['NivelEmpresa'] = $query3['NivelEmpresa'];
			$_SESSION['log']['TabelasEmpresa'] = $query3['TabelasEmpresa'];
			$_SESSION['log']['DataDeValidade'] = $query3['DataDeValidade'];
			$_SESSION['log']['Site'] = $query3['Site'];
			$_SESSION['log']['Arquivo_Empresa'] = $query3['Arquivo'];
			/*  
			  echo "<pre>";
              print_r($_SESSION['log']['NivelEmpresa']);
              echo "</pre>";
			  echo "<pre>";
			  print_r($_SESSION['log']['TabelasEmpresa']);
              echo "</pre>";
			  echo "<pre>";
			  print_r($_SESSION['log']['DataDeValidade']);
              echo "</pre>";
              exit();
			
			$_SESSION['log']['NivelEmpresa'] = $this->Login_model->get_empresa($query['idSis_Usuario']);
			$_SESSION['log']['TabelasEmpresa'] = $this->Login_model->get_empresa1($query['idSis_Usuario']);
			$_SESSION['log']['DataDeValidade'] = $this->Login_model->get_empresa2($query['idSis_Usuario']);
			*/
			#echo "<pre>".print_r($query)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usuário</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('form_login', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['Usuario'] = $query['Usuario'];
                //se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
                $_SESSION['log']['Usuario'] = (strlen($query['Usuario']) > 13) ? substr($query['Usuario'], 0, 13) : $query['Usuario'];
				$_SESSION['log']['Nome'] = $query['Nome'];
				$_SESSION['log']['Nome2'] = (strlen($query['Nome']) > 6) ? substr($query['Nome'], 0, 6) : $query['Nome'];
				$_SESSION['log']['CpfUsuario'] = $query['CpfUsuario'];
				$_SESSION['log']['CelularUsuario'] = $query['CelularUsuario'];
				$_SESSION['log']['idSis_Usuario'] = $query['idSis_Usuario'];
				$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
				#$_SESSION['log']['NivelEmpresa'] = $query['NivelEmpresa'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 6) ? substr($query['NomeEmpresa'], 0, 6) : $query['NomeEmpresa'];
				$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
				$_SESSION['log']['idTab_Modulo'] = $query['idTab_Modulo'];
				$_SESSION['log']['Permissao'] = $query['Permissao'];
				$_SESSION['log']['Arquivo'] = $query['Arquivo'];

				
                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Login_model->set_acesso($_SESSION['log']['idSis_Usuario'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('form_login1');
                } else {
					redirect('acesso');
					#redirect('agenda');
					#redirect('cliente');
                }
            }
        }

        #load footer view
        #$this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }

    public function index2() {
		
        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        ###################################################
        #só pra eu saber quando estou no banco de testes ou de produção
        #$CI = & get_instance();
        #$CI->load->database();
        #if ($CI->db->database != 'sishuap')
        #echo $CI->db->database;
        ###################################################
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #Get GET or POST data
        
		$celular = $this->input->get_post('CelularUsuario');
        $empresa = $this->input->get_post('idSis_Empresa');
		$senha = md5($this->input->get_post('Senha'));

        #set validation rules
        
		$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuário', 'required|trim|callback_valid_celular');
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim|callback_check_empresa|callback_valid_empresa[' . $celular . ']');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $celular . ']');

        $data['select']['idSis_Empresa'] = $this->Login_model->select_empresa2();
		
		if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o login novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o login para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('login/form_login2', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('Usuario');
            #$senha = md5($this->input->get_post('Senha'));
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */
            
			$query = $this->Login_model->check_dados_celular($senha, $celular, TRUE);
			$query = $this->Login_model->check_dados_empresa($empresa, $celular, TRUE);
            $_SESSION['log']['Agenda'] = $this->Login_model->get_agenda_padrao($query['idSis_Usuario']);

            
			#### Carrega os dados da Empresa nas vari?ves de sess?o ####
			
			$query2 = $this->Login_model->check_documentos_log($empresa, TRUE);
			$_SESSION['log']['Icone'] = $query2['Icone'];

			$query3 = $this->Login_model->dados_empresa_log($empresa);			
			$_SESSION['log']['NivelEmpresa'] = $query3['NivelEmpresa'];
			$_SESSION['log']['TabelasEmpresa'] = $query3['TabelasEmpresa'];
			$_SESSION['log']['DataDeValidade'] = $query3['DataDeValidade'];
			$_SESSION['log']['Site'] = $query3['Site'];
			$_SESSION['log']['Arquivo_Empresa'] = $query3['Arquivo'];
			/*  
			  echo "<pre>";
              print_r($_SESSION['log']['NivelEmpresa']);
              echo "</pre>";
			  echo "<pre>";
			  print_r($_SESSION['log']['TabelasEmpresa']);
              echo "</pre>";
			  echo "<pre>";
			  print_r($_SESSION['log']['DataDeValidade']);
              echo "</pre>";
              exit();
						
			$_SESSION['log']['NivelEmpresa'] = $this->Login_model->get_empresa($query['idSis_Usuario']);
			$_SESSION['log']['TabelasEmpresa'] = $this->Login_model->get_empresa1($query['idSis_Usuario']);
			$_SESSION['log']['DataDeValidade'] = $this->Login_model->get_empresa2($query['idSis_Usuario']);			
			*/
			#echo "<pre>".print_r($query)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usuário</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('form_login', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['Usuario'] = $query['Usuario'];
                //se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
                $_SESSION['log']['Usuario'] = (strlen($query['Usuario']) > 13) ? substr($query['Usuario'], 0, 13) : $query['Usuario'];
				$_SESSION['log']['Nome'] = $query['Nome'];
				$_SESSION['log']['Nome2'] = (strlen($query['Nome']) > 6) ? substr($query['Nome'], 0, 6) : $query['Nome'];
				$_SESSION['log']['CpfUsuario'] = $query['CpfUsuario'];
				$_SESSION['log']['CelularUsuario'] = $query['CelularUsuario'];
				$_SESSION['log']['idSis_Usuario'] = $query['idSis_Usuario'];
				$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
				#$_SESSION['log']['NivelEmpresa'] = $query['NivelEmpresa'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 6) ? substr($query['NomeEmpresa'], 0, 6) : $query['NomeEmpresa'];
				$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
				$_SESSION['log']['idTab_Modulo'] = $query['idTab_Modulo'];
				$_SESSION['log']['Permissao'] = $query['Permissao'];
				$_SESSION['log']['Arquivo'] = $query['Arquivo'];

				
                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Login_model->set_acesso($_SESSION['log']['idSis_Usuario'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('form_login2');
                } else {
					redirect('acesso');
					#redirect('agenda');
					#redirect('cliente');
                }
            }
        }

        #load footer view
        #$this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }
	
    public function index3() {

        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        ###################################################
        #só pra eu saber quando estou no banco de testes ou de produção
        #$CI = & get_instance();
        #$CI->load->database();
        #if ($CI->db->database != 'sishuap')
        #echo $CI->db->database;
        ###################################################
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #Get GET or POST data
        
		$celular = $this->input->get_post('CelularUsuario');
        $empresa = $this->input->get_post('idSis_Empresa');
		$senha = md5($this->input->get_post('Senha'));

        #set validation rules
        
		$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuário', 'required|trim|callback_valid_celular');
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim|callback_check_empresa|callback_valid_empresa[' . $celular . ']');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $celular . ']');

        $data['select']['idSis_Empresa'] = $this->Login_model->select_empresa();
		
		if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o login novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o login para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('login/form_login3', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('Usuario');
            #$senha = md5($this->input->get_post('Senha'));
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */
            
			$query = $this->Login_model->check_dados_celular($senha, $celular, TRUE);
			$query = $this->Login_model->check_dados_empresa($empresa, $celular, TRUE);
            $_SESSION['log']['Agenda'] = $this->Login_model->get_agenda_padrao($query['idSis_Usuario']);

            
			#### Carrega os dados da Empresa nas vari?ves de sess?o ####

			$query2 = $this->Login_model->check_documentos_log($empresa, TRUE);
			$_SESSION['log']['Icone'] = $query2['Icone'];
		
			$query3 = $this->Login_model->dados_empresa_log($empresa);			
			$_SESSION['log']['NivelEmpresa'] = $query3['NivelEmpresa'];
			$_SESSION['log']['TabelasEmpresa'] = $query3['TabelasEmpresa'];
			$_SESSION['log']['DataDeValidade'] = $query3['DataDeValidade'];
			$_SESSION['log']['Site'] = $query3['Site'];
			$_SESSION['log']['Arquivo_Empresa'] = $query3['Arquivo'];
			/*  
			  echo "<pre>";
              print_r($_SESSION['log']['NivelEmpresa']);
              echo "</pre>";
			  echo "<pre>";
			  print_r($_SESSION['log']['TabelasEmpresa']);
              echo "</pre>";
			  echo "<pre>";
			  print_r($_SESSION['log']['DataDeValidade']);
              echo "</pre>";
              exit();
						
			$_SESSION['log']['NivelEmpresa'] = $this->Login_model->get_empresa($query['idSis_Usuario']);
			$_SESSION['log']['TabelasEmpresa'] = $this->Login_model->get_empresa1($query['idSis_Usuario']);
			$_SESSION['log']['DataDeValidade'] = $this->Login_model->get_empresa2($query['idSis_Usuario']);
			*/
			#echo "<pre>".print_r($query)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usuário</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('form_login3', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['Usuario'] = $query['Usuario'];
                //se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
                $_SESSION['log']['Usuario'] = (strlen($query['Usuario']) > 13) ? substr($query['Usuario'], 0, 13) : $query['Usuario'];
				$_SESSION['log']['Nome'] = $query['Nome'];
				$_SESSION['log']['Nome2'] = (strlen($query['Nome']) > 6) ? substr($query['Nome'], 0, 6) : $query['Nome'];
				$_SESSION['log']['CpfUsuario'] = $query['CpfUsuario'];
				$_SESSION['log']['CelularUsuario'] = $query['CelularUsuario'];
				$_SESSION['log']['idSis_Usuario'] = $query['idSis_Usuario'];
				$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
				#$_SESSION['log']['NivelEmpresa'] = $query['NivelEmpresa'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 6) ? substr($query['NomeEmpresa'], 0, 6) : $query['NomeEmpresa'];
				$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
				$_SESSION['log']['idTab_Modulo'] = $query['idTab_Modulo'];
				$_SESSION['log']['Permissao'] = $query['Permissao'];
				$_SESSION['log']['Arquivo'] = $query['Arquivo'];

				
                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Login_model->set_acesso($_SESSION['log']['idSis_Usuario'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('form_login3');
                } else {
					redirect('acesso');
					#redirect('agenda');
					#redirect('cliente');
                }
            }
        }

        #load footer view
        #$this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }	

    public function index4() {

        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        ###################################################
        #só pra eu saber quando estou no banco de testes ou de produção
        #$CI = & get_instance();
        #$CI->load->database();
        #if ($CI->db->database != 'sishuap')
        #echo $CI->db->database;
        ###################################################
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #Get GET or POST data
        
		$celular = $this->input->get_post('CelularUsuario');
        $empresa = $this->input->get_post('idSis_Empresa');
		$senha = md5($this->input->get_post('Senha'));

        #set validation rules
        
		$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuário', 'required|trim|callback_valid_celular');
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim|callback_check_empresa|callback_valid_empresa[' . $celular . ']');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $celular . ']');

        $data['select']['idSis_Empresa'] = $this->Login_model->select_empresa4();
		
		if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o login novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o login para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('login/form_login4', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('Usuario');
            #$senha = md5($this->input->get_post('Senha'));
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */
            
			$query = $this->Login_model->check_dados_celular($senha, $celular, TRUE);
			$query = $this->Login_model->check_dados_empresa($empresa, $celular, TRUE);
            $_SESSION['log']['Agenda'] = $this->Login_model->get_agenda_padrao($query['idSis_Usuario']);

            
			#### Carrega os dados da Empresa nas vari?ves de sess?o ####
			
			$query2 = $this->Login_model->check_documentos_log($empresa, TRUE);	
			$_SESSION['log']['Icone'] = $query2['Icone'];
		
			$query3 = $this->Login_model->dados_empresa_log($empresa);			
			$_SESSION['log']['NivelEmpresa'] = $query3['NivelEmpresa'];
			$_SESSION['log']['TabelasEmpresa'] = $query3['TabelasEmpresa'];
			$_SESSION['log']['DataDeValidade'] = $query3['DataDeValidade'];
			$_SESSION['log']['Site'] = $query3['Site'];
			$_SESSION['log']['Arquivo_Empresa'] = $query3['Arquivo'];
			$_SESSION['log']['Empresa'] = $query3['idSis_Empresa'];
			/*  
			  echo "<pre>";
              print_r($_SESSION['log']['NivelEmpresa']);
              echo "</pre>";
			  echo "<pre>";
			  print_r($_SESSION['log']['TabelasEmpresa']);
              echo "</pre>";
			  echo "<pre>";
			  print_r($_SESSION['log']['DataDeValidade']);
              echo "</pre>";
			  echo "<pre>";
			  print_r($_SESSION['log']['Empresa']);
              echo "</pre>";			  
              exit();
						
			$_SESSION['log']['Empresa'] = $this->Login_model->get_empresa0($query['idSis_Usuario']);
			$_SESSION['log']['NivelEmpresa'] = $this->Login_model->get_empresa($query['idSis_Usuario']);
			$_SESSION['log']['TabelasEmpresa'] = $this->Login_model->get_empresa1($query['idSis_Usuario']);
			$_SESSION['log']['DataDeValidade'] = $this->Login_model->get_empresa2($query['idSis_Usuario']);			
			*/
			#echo "<pre>".print_r($query)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usuário</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('form_login4', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['Usuario'] = $query['Usuario'];
                //se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
                $_SESSION['log']['Usuario'] = (strlen($query['Usuario']) > 13) ? substr($query['Usuario'], 0, 13) : $query['Usuario'];
				$_SESSION['log']['Nome'] = $query['Nome'];
				$_SESSION['log']['Nome2'] = (strlen($query['Nome']) > 6) ? substr($query['Nome'], 0, 6) : $query['Nome'];
				$_SESSION['log']['CpfUsuario'] = $query['CpfUsuario'];
				$_SESSION['log']['CelularUsuario'] = $query['CelularUsuario'];
				$_SESSION['log']['idSis_Usuario'] = $query['idSis_Usuario'];
				$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
				#$_SESSION['log']['NivelEmpresa'] = $query['NivelEmpresa'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 6) ? substr($query['NomeEmpresa'], 0, 6) : $query['NomeEmpresa'];
				$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
				$_SESSION['log']['idTab_Modulo'] = $query['idTab_Modulo'];
				$_SESSION['log']['Permissao'] = $query['Permissao'];
				$_SESSION['log']['Arquivo'] = $query['Arquivo'];

				
                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Login_model->set_acesso($_SESSION['log']['idSis_Usuario'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('form_login4');
                } else {
					redirect('acesso');
					#redirect('agenda');
					#redirect('cliente');
                }
            }
        }

        #load footer view
        #$this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }
	
    public function index5() {

        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        ###################################################
        #só pra eu saber quando estou no banco de testes ou de produção
        #$CI = & get_instance();
        #$CI->load->database();
        #if ($CI->db->database != 'sishuap')
        #echo $CI->db->database;
        ###################################################
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #Get GET or POST data
        
		$celular = $this->input->get_post('CelularUsuario');
        $empresa = $this->input->get_post('idSis_Empresa');
		$senha = md5($this->input->get_post('Senha'));

        #set validation rules
        
		$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuário', 'required|trim|callback_valid_celular');
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim|callback_check_empresa|callback_valid_empresa[' . $celular . ']');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $celular . ']');

        if($_SESSION['Acesso']['idSis_Empresa']){
				
			$data['select']['idSis_Empresa'] = $this->Login_model->select_empresa5();
			
			
			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 3)
				$data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o login novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 4)
				$data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o login para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 5)
				$data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
				$data['msg'] = '';

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				#load login view
				if($_SESSION['Acesso']['idSis_Empresa']){
					$this->load->view('login/form_login5', $data);
				}else{
					$this->load->view('login/form_login2', $data);
				}
			} else {

				session_regenerate_id(true);

				#Get GET or POST data
				#$usuario = $this->input->get_post('Usuario');
				#$senha = md5($this->input->get_post('Senha'));
				/*
				  echo "<pre>";
				  print_r($query);
				  echo "</pre>";
				  exit();
				 */
				
				$query = $this->Login_model->check_dados_celular($senha, $celular, TRUE);
				$query = $this->Login_model->check_dados_empresa($empresa, $celular, TRUE);
				$_SESSION['log']['Agenda'] = $this->Login_model->get_agenda_padrao($query['idSis_Usuario']);

				
				#### Carrega os dados da Empresa nas vari?ves de sess?o ####
				
				$query2 = $this->Login_model->check_documentos_log($empresa, TRUE);	
				$_SESSION['log']['Icone'] = $query2['Icone'];
			
				$query3 = $this->Login_model->dados_empresa_log($empresa);			
				$_SESSION['log']['NivelEmpresa'] = $query3['NivelEmpresa'];
				$_SESSION['log']['TabelasEmpresa'] = $query3['TabelasEmpresa'];
				$_SESSION['log']['DataDeValidade'] = $query3['DataDeValidade'];
				$_SESSION['log']['Site'] = $query3['Site'];
				$_SESSION['log']['Arquivo_Empresa'] = $query3['Arquivo'];
				$_SESSION['log']['Empresa'] = $query3['idSis_Empresa'];
				/*  
				  echo "<pre>";
				  print_r($_SESSION['log']['NivelEmpresa']);
				  echo "</pre>";
				  echo "<pre>";
				  print_r($_SESSION['log']['TabelasEmpresa']);
				  echo "</pre>";
				  echo "<pre>";
				  print_r($_SESSION['log']['DataDeValidade']);
				  echo "</pre>";
				  echo "<pre>";
				  print_r($_SESSION['log']['Empresa']);
				  echo "</pre>";			  
				  exit();
							
				$_SESSION['log']['Empresa'] = $this->Login_model->get_empresa0($query['idSis_Usuario']);
				$_SESSION['log']['NivelEmpresa'] = $this->Login_model->get_empresa($query['idSis_Usuario']);
				$_SESSION['log']['TabelasEmpresa'] = $this->Login_model->get_empresa1($query['idSis_Usuario']);
				$_SESSION['log']['DataDeValidade'] = $this->Login_model->get_empresa2($query['idSis_Usuario']);			
				*/
				#echo "<pre>".print_r($query)."</pre>";
				#exit();

				if ($query === FALSE) {
					#$msg = "<strong>Senha</strong> incorreta ou <strong>usuário</strong> inexistente.";
					#$this->basico->erro($msg);
					$data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
					#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
					if($_SESSION['Acesso']['idSis_Empresa']){
						$this->load->view('login/form_login5', $data);
					}else{
						$this->load->view('login/form_login2', $data);
					}

				} else {
					#initialize session
					$this->load->driver('session');

					#$_SESSION['log']['Usuario'] = $query['Usuario'];
					//se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
					$_SESSION['log']['Usuario'] = (strlen($query['Usuario']) > 13) ? substr($query['Usuario'], 0, 13) : $query['Usuario'];
					$_SESSION['log']['Nome'] = $query['Nome'];
					$_SESSION['log']['Nome2'] = (strlen($query['Nome']) > 6) ? substr($query['Nome'], 0, 6) : $query['Nome'];
					$_SESSION['log']['CpfUsuario'] = $query['CpfUsuario'];
					$_SESSION['log']['CelularUsuario'] = $query['CelularUsuario'];
					$_SESSION['log']['idSis_Usuario'] = $query['idSis_Usuario'];
					$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
					#$_SESSION['log']['NivelEmpresa'] = $query['NivelEmpresa'];
					$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
					$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 6) ? substr($query['NomeEmpresa'], 0, 6) : $query['NomeEmpresa'];
					$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
					$_SESSION['log']['idTab_Modulo'] = $query['idTab_Modulo'];
					$_SESSION['log']['Permissao'] = $query['Permissao'];
					$_SESSION['log']['Arquivo'] = $query['Arquivo'];

					
					$this->load->database();
					$_SESSION['db']['hostname'] = $this->db->hostname;
					$_SESSION['db']['username'] = $this->db->username;
					$_SESSION['db']['password'] = $this->db->password;
					$_SESSION['db']['database'] = $this->db->database;

					if ($this->Login_model->set_acesso($_SESSION['log']['idSis_Usuario'], 'LOGIN') === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

						$this->basico->erro($msg);
						if($_SESSION['Acesso']['idSis_Empresa']){
							$this->load->view('login/form_login5', $data);
						}else{
							$this->load->view('login/form_login2', $data);
						}
					} else {
						redirect('acesso');
						#redirect('agenda');
						#redirect('cliente');
					}
				}
			}
		}else{
			redirect(base_url() . 'login/index2' . $data['msg']);
		}
        #load footer view
        #$this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }	
	
    public function registrar1() {

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
            'ConfirmarEmail',
            'Usuario',
			'NomeEmpresa',
            'Nome',
            'Senha',
            'Confirma',
            'DataNascimento',
            'CelularUsuario',
            'Sexo',
			'Funcao',
			'TipoProfissional',
			'DataCriacao',
			'NumUsuarios',


                ), TRUE);

        (!$data['query']['DataCriacao']) ? $data['query']['DataCriacao'] = date('d/m/Y', time()) : FALSE;

		$this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

		$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim|is_unique[Sis_Usuario.NomeEmpresa]');
        $this->form_validation->set_rules('Email', 'E-mail', 'required|trim|valid_email|is_unique[Sis_Usuario.Email]');
        $this->form_validation->set_rules('ConfirmarEmail', 'Confirmar E-mail', 'required|trim|valid_email|matches[Email]');
        $this->form_validation->set_rules('Usuario', 'Usuário', 'required|trim|is_unique[Sis_Usuario.Usuario]');
		$this->form_validation->set_rules('Nome', 'Nome do Usuário', 'required|trim');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('CelularUsuario', 'CelularUsuario', 'required|trim');
		//$this->form_validation->set_rules('CelularCliente', 'CelularCliente', 'required|trim|is_unique_duplo[App_Cliente.CelularCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('NumUsuarios', 'Nº de Usuários', 'required|trim');

		$data['select']['TipoProfissional'] = $this->Basico_model->select_tipoprofissional();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('login/form_registrar', $data);
        } else {

			#$data['query']['Empresa'] = 0;
			$data['query']['NomeEmpresa'] = trim(mb_strtoupper($data['query']['NomeEmpresa'], 'ISO-8859-1'));
			$data['query']['Nome'] = trim(mb_strtoupper($data['query']['Nome'], 'ISO-8859-1'));
			$data['query']['Funcao'] = 95;
			$data['query']['UsuarioEmpresa'] = 1;
			$data['query']['idSis_EmpresaFilial'] = 33;
			$data['query']['Associado'] = 33;
			$data['query']['Permissao'] = 1;
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['query']['Senha'] = md5($data['query']['Senha']);
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'mysql');
            $data['query']['Codigo'] = md5(uniqid(time() . rand()));
            $data['query']['Inativo'] = 1;
            //ACESSO LIBERADO PRA QUEM REALIZAR O CADASTRO
            //$data['query']['Inativo'] = 0;
            unset($data['query']['Confirma'], $data['query']['ConfirmarEmail']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            $data['idSis_Usuario'] = $this->Login_model->set_usuario($data['query']);
            $_SESSION['log']['idSis_Usuario'] = 1;

            if ($data['idSis_Usuario'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('login/form_login', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Usuario']);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'CREATE', $data['auditoriaitem'], $data['idSis_Usuario']);
                /*
                  echo $this->db->last_query();
                  echo "<pre>";
                  print_r($data);
                  echo "</pre>";
                  exit();
                 */
                $data['agenda'] = array(
                    'NomeAgenda' => 'Padrão',
                    'idSis_Usuario' => $data['idSis_Usuario']
                );
                $data['campos'] = array_keys($data['agenda']);

                $data['idApp_Agenda'] = $this->Login_model->set_agenda($data['agenda']);
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['agenda'], $data['campos'], $data['idSis_Usuario']);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Agenda', 'CREATE', $data['auditoriaitem'], $data['idSis_Usuario']);

                #$this->load->library('email');

                //DADOS PARA ENVIO DE E-MAIL DE CONFIRMAÇÃO DE INSCRIÇÃO
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'smtplw.com.br';
                $config['smtp_user'] = 'trial';
                $config['smtp_pass'] = 'XzGyjtXI2256';
                $config['charset'] = 'iso-8859-1';
                $config['mailtype'] = 'html';
                $config['wrapchars'] = '50';
                $config['smtp_port'] = '587';
                $config['smtp_crypto'] = 'tls';
                $config['newline'] = "\r\n";

                $this->email->initialize($config);

                $this->email->from('contato@ktracaengenharia.com.br', 'KTRACA Engenharia');
                $this->email->to($data['query']['Email']);

                $this->email->subject('[KTRACA] Confirmação de registro - Usuário: ' . $data['query']['Usuario']);

                #$this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                #. 'http://www.romati.com.br/app/login/confirmar/' . $data['query']['Codigo']);
                $this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                    . base_url() . 'login/confirmar/' . $data['query']['Codigo']);

                $this->email->send();
                #echo ($this->email->send(FALSE)) ? "sim" : "não";
                #echo $this->email->print_debugger(array('headers'));

                $data['aviso'] = ''
                    . '
                    <div class="alert alert-success" role="alert">
                    <h4>

                        <p><b>Usuário cadastrado com sucesso!</b></p>
                        <p>Entretanto, ele ainda encontra-se inativo no sistema. Um link de ativação foi gerado e enviado para
                            o e-mail <b>' . $data['query']['Email'] . '</b></p>
                        <p>Entre em sua caixa de e-mail e clique no link de ativação para habilitar seu acesso ao sistema.</p>
                        <p>Caso o e-mail com o link não esteja na sua caixa de entrada <b>verifique também sua caixa de SPAM</b>.</p>

                    </h4>
                    <br>
                    <a class="btn btn-primary" href="' . base_url() . '" role="button">Acessar o aplicativo</a>
                    </div> '
                . '';

                /*
                $this->email->message('Sua conta foi ativada com sucesso! Aproveite e teste todas as funcionalidades do sistema.'
                        . 'Qualquer sugestão ou crítica será bem vinda. ');

                $this->email->send();
                */

                $this->load->view('login/tela_msg', $data);
                #redirect(base_url() . 'login' . $data['msg']);
                #exit();
            }
        }

        #$this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }

    public function registrar() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            #'idSis_Empresa',
			#'Email',
            #'ConfirmarEmail',
            #'Usuario',
            'Nome',
			'CpfUsuario',
            'Senha',
            'Confirma',
            'DataNascimento',
            'CelularUsuario',
            'Sexo',
			'Funcao',
			'TipoProfissional',
			'DataCriacao',
			
                ), TRUE);

        (!$data['query']['DataCriacao']) ? $data['query']['DataCriacao'] = date('d/m/Y', time()) : FALSE;

		$this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

		#$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim|is_unique[Sis_Usuario.NomeEmpresa]');
        #$this->form_validation->set_rules('CpfUsuario', 'Cpf do Usuário', 'required|trim|alpha_numeric_spaces|is_unique_duplo[Sis_Usuario.CpfUsuario.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		#$this->form_validation->set_rules('Email', 'E-mail', 'required|trim|valid_email|is_unique_duplo[Sis_Usuario.Email.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
        #$this->form_validation->set_rules('ConfirmarEmail', 'Confirmar E-mail', 'required|trim|valid_email|matches[Email]');
        #$this->form_validation->set_rules('Usuario', 'Usuário', 'required|trim|is_unique_duplo[Sis_Usuario.Usuario.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Nome', 'Nome do Usuário', 'required|trim');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('CelularUsuario', 'Celular da Pessoa', 'required|trim|alpha_numeric_spaces|is_unique_duplo[Sis_Usuario.CelularUsuario.idSis_Empresa.5]');
		#$this->form_validation->set_rules('CelularUsuario', 'Celular da Pessoa', 'required|trim|alpha_numeric_spaces|is_unique_duplo[Sis_Usuario.CelularUsuario.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		#$this->form_validation->set_rules('CelularUsuario', 'CelularUsuario', 'required|trim');
		#$this->form_validation->set_rules('NumUsuarios', 'Nº de Usuários', 'required|trim');

		$data['select']['idSis_Empresa'] = $this->Login_model->select_empresa1();
		$data['select']['TipoProfissional'] = $this->Basico_model->select_tipoprofissional();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('login/form_registrar', $data);
        } else {

			$data['query']['Nome'] = trim(mb_strtoupper($data['query']['Nome'], 'ISO-8859-1'));
			$data['query']['idSis_Empresa'] = 5;
			$data['query']['NomeEmpresa'] = "CONTA PESSOAL";
			$data['query']['Permissao'] = 3;
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['query']['Senha'] = md5($data['query']['Senha']);
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'mysql');
            $data['query']['Codigo'] = md5(uniqid(time() . rand()));
            //$data['query']['Inativo'] = 1;
            //ACESSO LIBERADO PRA QUEM REALIZAR O CADASTRO
            $data['query']['Inativo'] = 0;
            unset($data['query']['Confirma'], $data['query']['ConfirmarEmail']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            $data['idSis_Usuario'] = $this->Login_model->set_usuario($data['query']);
            $_SESSION['log']['idSis_Usuario'] = 1;

            if ($data['idSis_Usuario'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('login/form_login', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Usuario']);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'CREATE', $data['auditoriaitem'], $data['idSis_Usuario']);
                /*
                  echo $this->db->last_query();
                  echo "<pre>";
                  print_r($data);
                  echo "</pre>";
                  exit();
                 */
                $data['agenda'] = array(
                    'NomeAgenda' => 'Cliente',
                    'idSis_Usuario' => $data['idSis_Usuario'],
					'idSis_Empresa' => "5"
                );
                $data['campos'] = array_keys($data['agenda']);

                $data['idApp_Agenda'] = $this->Login_model->set_agenda($data['agenda']);
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['agenda'], $data['campos'], $data['idSis_Usuario']);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Agenda', 'CREATE', $data['auditoriaitem'], $data['idSis_Usuario']);

                #$this->load->library('email');

                //DADOS PARA ENVIO DE E-MAIL DE CONFIRMAÇÃO DE INSCRIÇÃO
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'smtplw.com.br';
                $config['smtp_user'] = 'trial';
                $config['smtp_pass'] = 'XzGyjtXI2256';
                $config['charset'] = 'iso-8859-1';
                $config['mailtype'] = 'html';
                $config['wrapchars'] = '50';
                $config['smtp_port'] = '587';
                $config['smtp_crypto'] = 'tls';
                $config['newline'] = "\r\n";

                #$this->email->initialize($config);

                #$this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                #$this->email->to($data['query']['Email']);

                #$this->email->subject('[KTRACA] Confirmação de registro - Usuário: ' . $data['query']['Usuario']);

                #$this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                #. 'http://www.romati.com.br/app/login/confirmar/' . $data['query']['Codigo']);
                $this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                    . base_url() . 'login/confirmar/' . $data['query']['Codigo']);

                #$this->email->send();
                #echo ($this->email->send(FALSE)) ? "sim" : "não";
                #echo $this->email->print_debugger(array('headers'));

                $data['aviso'] = ''
                    . '
                    <div class="alert alert-success" role="alert">
                    <h4>

                        <p><b>Usuário cadastrado com sucesso!</b></p>
                        <p>Entretanto, ele ainda encontra-se inativo no sistema. Um link de ativação foi gerado e enviado para
						
                            o Celular <b>' . $data['query']['CelularUsuario'] . '</b></p>
							
                        <p>Entre em sua caixa de Mensagens e clique no link de ativação para habilitar seu acesso ao sistema.</p>
                        

                    </h4>
                    <br>

                    </div> '
                . '';

                /*
                $this->email->message('Sua conta foi ativada com sucesso! Aproveite e teste todas as funcionalidades do sistema.'
                        . 'Qualquer sugestão ou crítica será bem vinda. ');

                $this->email->send();
                */

                $this->load->view('login/tela_msg', $data);
                #redirect(base_url() . 'login' . $data['msg']);
                #exit();
            }
        }

        #$this->load->view('basico/footerlogin');
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
            #'idSis_Empresa',
			#'Email',
            #'ConfirmarEmail',
            #'Usuario',
            'Nome',
			'CpfUsuario',
            'Senha',
            'Confirma',
            'DataNascimento',
            'CelularUsuario',
            'Sexo',
			'Funcao',
			'TipoProfissional',
			'DataCriacao',
			#'Associado',
                ), TRUE);

        (!$data['query']['DataCriacao']) ? $data['query']['DataCriacao'] = date('d/m/Y', time()) : FALSE;
		
		$this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

		#$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim|is_unique[Sis_Usuario.NomeEmpresa]');
        #$this->form_validation->set_rules('CpfUsuario', 'Cpf do Usuário', 'required|trim|alpha_numeric_spaces|is_unique_duplo[Sis_Usuario.CpfUsuario.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		#$this->form_validation->set_rules('Email', 'E-mail', 'required|trim|valid_email|is_unique_duplo[Sis_Usuario.Email.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
        #$this->form_validation->set_rules('ConfirmarEmail', 'Confirmar E-mail', 'required|trim|valid_email|matches[Email]');
        #$this->form_validation->set_rules('Usuario', 'Usuário', 'required|trim|is_unique_duplo[Sis_Usuario.Usuario.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Nome', 'Nome do Usuário', 'required|trim');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('CelularUsuario', 'Celular da Pessoa', 'required|trim|alpha_numeric_spaces|is_unique_duplo[Sis_Usuario.CelularUsuario.idSis_Empresa.5]');
		#$this->form_validation->set_rules('CelularUsuario', 'Celular da Pessoa', 'required|trim|alpha_numeric_spaces|is_unique_duplo[Sis_Usuario.CelularUsuario.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');		
		#$this->form_validation->set_rules('CelularUsuario', 'CelularUsuario', 'required|trim');
		#$this->form_validation->set_rules('NumUsuarios', 'Nº de Usuários', 'required|trim');

		$data['select']['idSis_Empresa'] = $this->Login_model->select_empresa1();
		$data['select']['Associado'] = $this->Login_model->select_empresa3();
		$data['select']['TipoProfissional'] = $this->Basico_model->select_tipoprofissional();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('login/form_registrar2', $data);
        } else {

			$data['query']['Nome'] = trim(mb_strtoupper($data['query']['Nome'], 'ISO-8859-1'));
			$data['query']['idSis_Empresa'] = 5;
			$data['query']['Associado'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['NomeEmpresa'] = "CONTA PESSOAL";
			$data['query']['Permissao'] = 3;
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['query']['Senha'] = md5($data['query']['Senha']);
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'mysql');
            $data['query']['Codigo'] = md5(uniqid(time() . rand()));
            //$data['query']['Inativo'] = 1;
            //ACESSO LIBERADO PRA QUEM REALIZAR O CADASTRO
            $data['query']['Inativo'] = 0;
            unset($data['query']['Confirma'], $data['query']['ConfirmarEmail']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            $data['idSis_Usuario'] = $this->Login_model->set_usuario($data['query']);
            $_SESSION['log']['idSis_Usuario'] = 1;

            if ($data['idSis_Usuario'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('login/form_login', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Usuario']);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'CREATE', $data['auditoriaitem'], $data['idSis_Usuario']);
                /*
                  echo $this->db->last_query();
                  echo "<pre>";
                  print_r($data);
                  echo "</pre>";
                  exit();
                 */
                $data['agenda'] = array(
                    'NomeAgenda' => 'Cliente',
                    'idSis_Usuario' => $data['idSis_Usuario'],
					'idSis_Empresa' => "5"
                );
                $data['campos'] = array_keys($data['agenda']);

                $data['idApp_Agenda'] = $this->Login_model->set_agenda($data['agenda']);
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['agenda'], $data['campos'], $data['idSis_Usuario']);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Agenda', 'CREATE', $data['auditoriaitem'], $data['idSis_Usuario']);

                #$this->load->library('email');

                //DADOS PARA ENVIO DE E-MAIL DE CONFIRMAÇÃO DE INSCRIÇÃO
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'smtplw.com.br';
                $config['smtp_user'] = 'trial';
                $config['smtp_pass'] = 'XzGyjtXI2256';
                $config['charset'] = 'iso-8859-1';
                $config['mailtype'] = 'html';
                $config['wrapchars'] = '50';
                $config['smtp_port'] = '587';
                $config['smtp_crypto'] = 'tls';
                $config['newline'] = "\r\n";

                #$this->email->initialize($config);

                #$this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                #$this->email->to($data['query']['Email']);

                #$this->email->subject('[KTRACA] Confirmação de registro - Usuário: ' . $data['query']['Usuario']);

                #$this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                #. 'http://www.romati.com.br/app/login/confirmar/' . $data['query']['Codigo']);
                $this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                    . base_url() . 'login/confirmar/' . $data['query']['Codigo']);

                #$this->email->send();
                #echo ($this->email->send(FALSE)) ? "sim" : "não";
                #echo $this->email->print_debugger(array('headers'));

                $data['aviso'] = ''
                    . '
                    <div class="alert alert-success" role="alert">
                    <h4>

                        <p><b>Usuário cadastrado com sucesso!</b></p>
                        <p>Entretanto, ele ainda encontra-se inativo no sistema. Um link de ativação foi gerado e enviado para
						
                            o Celular <b>' . $data['query']['CelularUsuario'] . '</b></p>
							
                        <p>Entre em sua caixa de Mensagens e clique no link de ativação para habilitar seu acesso ao sistema.</p>
                        

                    </h4>
                    <br>

                    </div> '
                . '';

                /*
                $this->email->message('Sua conta foi ativada com sucesso! Aproveite e teste todas as funcionalidades do sistema.'
                        . 'Qualquer sugestão ou crítica será bem vinda. ');

                $this->email->send();
                */

                $this->load->view('login/tela_msg', $data);
                #redirect(base_url() . 'login' . $data['msg']);
                #exit();
            }
        }

        #$this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }
	
    public function confirmar($codigo) {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;


        $data['anterior'] = array(
            'Inativo' => '1',
            'Codigo' => $codigo,
			'Empresa' => $id
        );

        $data['confirmar'] = array(
            'Inativo' => '0',
            'Codigo' => 'NULL',
			'Empresa' => $id
        );

        $data['campos'] = array_keys($data['confirmar']);
        $id = $this->Login_model->get_data_by_codigo($codigo);

        if ($this->Login_model->ativa_usuario($codigo, $data['confirmar']) === TRUE) {

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idSis_Usuario'], TRUE);
            $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem'], $id['idSis_Usuario']);

            $data['msg'] = '?m=4';
            redirect(base_url() . 'login/' . $data['msg']);
        } else {
            $data['msg'] = '?m=5';
            redirect(base_url() . 'login/' . $data['msg']);
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
            'Usuario',
                ), TRUE);

        if (isset($_GET['usuario']))
            $data['query']['Usuario'] = $_GET['usuario'];

        $this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

        $this->form_validation->set_rules('Usuario', 'Usuario', 'required|trim|callback_valid_usuario');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('login/form_recuperar', $data);
        } else {

            $data['query']['Codigo'] = md5(uniqid(time() . rand()));

            $id = $this->Login_model->get_data_by_usuario($data['query']['Usuario']);

            if ($this->Login_model->troca_senha($id['idSis_Usuario'], array('Codigo' => $data['query']['Codigo'])) === FALSE) {

                $data['anterior'] = array(
                    'Codigo' => 'NULL'
                );

                $data['confirmar'] = array(
                    'Codigo' => $data['query']['Codigo']
                );

                $data['campos'] = array_keys($data['confirmar']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idSis_Usuario'], TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem'], $id['idSis_Usuario']);

                #$this->load->library('email');

                //DADOS PARA ENVIO DE E-MAIL DE CONFIRMAÇÃO DE INSCRIÇÃO
                $config['protocol'] = 'smtp';
                $config['mailpath'] = "/usr/sbin/sendmail";
                $config['smtp_host'] = 'smtp.zoho.com';
                $config['smtp_user'] = 'contato@ktracaengemark.com.br';
                $config['smtp_pass'] = '20KtracaEngeMark17!';
                $config['charset'] = 'iso-8859-1';
                $config['mailtype'] = 'html';
                $config['wrapchars'] = '50';
                $config['smtp_port'] = '587';
                $config['smtp_crypto'] = 'tls';
                $config['newline'] = "\r\n";

                $this->email->initialize($config);

                $this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                $this->email->to($id['Email']);

                $this->email->subject('[KTRACA] Alteração de Senha - Usuário: ' . $data['query']['Usuario']);
                $this->email->message('Por favor, clique no link a seguir para alterar sua senha: '
                        //. 'http://www.romati.com.br/app/login/trocar_senha/' . $data['query']['Codigo']);
                    . base_url() . 'login/trocar_senha/' . $data['query']['Codigo']);

                $this->email->send();
                #echo ($this->email->send(FALSE)) ? "sim" : "não";
                #echo $this->email->print_debugger(array('headers'));

                $data['aviso'] = ''
                        . '
                    <div class="alert alert-success" role="alert">
                        <h4>
                            <p><b>Link enviado com sucesso!</b></p>
                            <p>O link para alterar senha foi enviado para o e-mail <b>' . $id['Email'] . '</b></p>
                            <p>Caso o e-mail com o link não esteja na sua caixa de entrada <b>verifique também sua caixa de SPAM</b>.</p>
                        </h4>
                    </div> '
                        . '';

                #$data['msg'] = '?m=4';
                $this->load->view('login/tela_msg', $data);
            } else {
                $data['msg'] = '?m=5';
                redirect(base_url() . 'login/' . $data['msg']);
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
            'idSis_Usuario',
            'Email',
            'Usuario',
            'Codigo',
                ), TRUE);

        if ($codigo) {
            $data['query'] = $this->Login_model->get_data_by_codigo($codigo);
            $data['query']['Codigo'] = $codigo;
        } else {
            $data['query']['Codigo'] = $this->input->post('Codigo', TRUE);
        }

        if (!$this->Login_model->get_data_by_codigo($data['query']['Codigo']))
            exit("Link expirado. Tente recuperar a senha novamente.");

        $data['query']['Senha'] = $this->input->post('Senha', TRUE);
        $data['query']['Confirma'] = $this->input->post('Confirma', TRUE);

        $this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        #$this->form_validation->set_rules('Codigo', 'Código', 'required|trim');
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('login/form_troca_senha', $data);
        } else {

            ###não está registrando a auditoria do trocar senha. tenho que ver isso
            ###ver também o link para troca, quando expirado avisar
            #$id = $data['query']['Senha']
            $data['query']['Senha'] = md5($data['query']['Senha']);
            $data['query']['Codigo'] = NULL;
            unset($data['query']['Confirma']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            if ($this->Login_model->troca_senha($data['query']['idSis_Usuario'], $data['query']) === TRUE) {
                $data['msg'] = '?m=2';
                $this->load->view('login/form_troca_senha', $data);
            } else {

                ##### AUDITORIA DESABILITADA! TENHO QUE VER ISSO! ##########

                #$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);
                #$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem'], $data['query']['idSis_Usuario']);
                /*
                  echo $this->db->last_query();
                  echo "<pre>";
                  print_r($data);
                  echo "</pre>";
                  exit();
                 */
                $data['msg'] = '?m=1';
                redirect(base_url() . 'login' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }

    public function sair($m = TRUE) {
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #set logout in database
        if ($_SESSION['log']['idSis_Usuario'] && $m === TRUE) {
            $this->Login_model->set_acesso($_SESSION['log']['idSis_Usuario'], 'LOGOUT');
        } else {
            if (!isset($_SESSION['log']['idSis_Usuario'])) {
                $_SESSION['log']['idSis_Usuario'] = 1;
            }
            $this->Login_model->set_acesso($_SESSION['log']['idSis_Usuario'], 'TIMEOUT');
            $data['msg'] = '?m=3';
        }

        #clear de session data
        $this->session->unset_userdata('log');
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage

        /*
          #load header view
          $this->load->view('basico/headerlogin');

          $msg = "<strong>Você saiu do sistema.</strong>";

          $this->basico->alerta($msg);
          $this->load->view('login');
          $this->load->view('basico/footer');
         *
         */

        //redirect(base_url() . 'login/' . $data['msg']);
        redirect(base_url() . '../enkontraki/');
        #redirect('login');
    }

    function valid_celular($celular) {

        if ($this->Login_model->check_celular($celular) == 1) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> não existe.');
            return FALSE;
        } else if ($this->Login_model->check_celular($celular) == 2) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> inativo! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    function check_empresa($data) {

        if ($this->Login_model->check_empresa($data) == 1) {
            $this->form_validation->set_message('check_empresa', '<strong>%s</strong> não existe.');
            return FALSE;
        } else if ($this->Login_model->check_empresa($data) == 2) {
            $this->form_validation->set_message('check_empresa', '<strong>%s</strong> inativa! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }	
	
	function valid_empresa($empresa, $celular) {

        if ($this->Login_model->check_dados_empresa($empresa, $celular) == FALSE) {
            $this->form_validation->set_message('valid_empresa', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    function valid_senha($senha, $celular) {

        if ($this->Login_model->check_dados_celular($senha, $celular) == FALSE) {
            $this->form_validation->set_message('valid_senha', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}