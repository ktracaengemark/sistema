<?php

#controlador de Loginempresafilial

defined('BASEPATH') OR exit('No direct script access allowed');

class Loginempresafilial extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model(array('Loginempresafilial_model', 'Basico_model'));
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('basico', 'form_validation', 'user_agent'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerloginempresafilial');

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
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'ktraca';
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
        $usuario = $this->input->get_post('UsuarioEmpresaFilial');
		#$nomeempresa = $this->input->get_post('NomeEmpresa');
        $senha = md5($this->input->get_post('Senha'));

        #set validation rules
        $this->form_validation->set_rules('UsuarioEmpresaFilial', 'Usuário', 'required|trim|callback_valid_usuario');
		#$this->form_validation->set_rules('NomeEmpresa', 'Nome da Empresa', 'required|trim|callback_valid_nomeempresa[' . $usuario . ']');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $usuario . ']');

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o loginempresafilial novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o loginempresafilial para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresafilial view
            $this->load->view('loginempresafilial/form_loginempresafilial', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('UsuarioEmpresaFilial');
            #$senha = md5($this->input->get_post('Senha'));
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */
            $query = $this->Loginempresafilial_model->check_dados_usuario($senha, $usuario, TRUE);
            #$_SESSION['log']['Agenda'] = $this->Loginempresafilial_model->get_agenda_padrao($query['idSis_EmpresaFilial']);

            #echo "<pre>".print_r($query)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usuário</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('form_loginempresafilial', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['UsuarioEmpresaFilial'] = $query['UsuarioEmpresaFilial'];
                //se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
                $_SESSION['log']['UsuarioEmpresaFilial'] = (strlen($query['UsuarioEmpresaFilial']) > 15) ? substr($query['UsuarioEmpresaFilial'], 0, 15) : $query['UsuarioEmpresaFilial'];
                #$_SESSION['log']['Nome'] = (strlen($query['Nome']) > 10) ? substr($query['Nome'], 0, 10) : $query['Nome'];
				$_SESSION['log']['Nome'] = $query['Nome'];
				#$_SESSION['log']['id'] = $query['idSis_EmpresaMatriz'];
				$_SESSION['log']['idSis_EmpresaFilial'] = $query['id'];
				$_SESSION['log']['idSis_Usuario'] = $query['idSis_Usuario'];
				$_SESSION['log']['Empresa'] = $query['Empresa'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				#$_SESSION['log']['idSis_EmpresaFilial'] = $query['idSis_EmpresaFilial'];
				$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
				#$_SESSION['log']['Permissao'] = $query['Permissao'];
				
                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Loginempresafilial_model->set_acesso($_SESSION['log']['id'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('form_loginempresafilial');
                } else {
					redirect('acessoempresa');
					#redirect('agenda');
					#redirect('cliente');
                }

            }
        }

        #load footer view
        $this->load->view('basico/footerloginempresafilial');
        $this->load->view('basico/footer');
    }

    public function registrar() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'ktraca';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'Email',
            'UsuarioEmpresaFilial',
			'NomeEmpresa',
            'Nome',
            'Senha',
            'Confirma',
            'Celular',
			'DataCriacao',
			'NumUsuarios',			
                ), TRUE);

                (!$data['query']['DataCriacao']) ? $data['query']['DataCriacao'] = date('d/m/Y', time()) : FALSE;
		
		$this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');
	
		#$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim|is_unique[Sis_EmpresaFilial.NomeEmpresa]');
        #$this->form_validation->set_rules('Email', 'E-mail', 'required|trim|valid_email|is_unique[Sis_EmpresaFilial.Email]');		
        $this->form_validation->set_rules('UsuarioEmpresaFilial', 'Usuário', 'required|trim|is_unique[Sis_EmpresaFilial.UsuarioEmpresaFilial]');
		$this->form_validation->set_rules('Nome', 'Nome do Usuário', 'required|trim');      	
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
		$this->form_validation->set_rules('Celular', 'Telefone', 'required|trim');
		#$this->form_validation->set_rules('NumUsuarios', 'Número de Usuários', 'required|trim');
		
		$data['select']['NumUsuarios'] = $this->Basico_model->select_numusuarios();
        
		#run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresafilial view
            $this->load->view('loginempresafilial/form_registrarempresafilial', $data);
        } else {
			
			$data['query']['Empresa'] = $_SESSION['log']['id'];
			$data['query']['idSis_EmpresaMatriz'] = $_SESSION['log']['id'];
			$data['query']['NomeEmpresa'] = $_SESSION['log']['NomeEmpresa'];
			#$data['query']['Associado'] = 33;
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'mysql');
			$data['query']['Senha'] = md5($data['query']['Senha']);
            $data['query']['Codigo'] = md5(uniqid(time() . rand()));
            #$data['query']['Inativo'] = 1;
            //ACESSO LIBERADO PRA QUEM REALIZAR O CADASTRO
            $data['query']['Inativo'] = 0;
            unset($data['query']['Confirma']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            $data['idSis_EmpresaFilial'] = $this->Loginempresafilial_model->set_usuario($data['query']);
            $_SESSION['log']['id'] = 1;

            if ($data['idSis_EmpresaFilial'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('loginempresafilial/form_loginempresafilial', $data);
            } else {

                          
                $this->load->library('email');

                $this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                $this->email->to($data['query']['Email']);

                $this->email->subject('[KTRACA] Confirmação de registro - Usuário: ' . $data['query']['UsuarioEmpresaFilial']);
                /*
                  $this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                  . 'http://www.romati.com.br/app/loginempresafilial/confirmar/' . $data['query']['Codigo']);

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

                $this->email->message('Sua conta foi ativada com sucesso! Aproveite e teste todas as funcionalidades do sistema.'
                        . 'Qualquer sugestão ou crítica será bem vinda. ');

                $this->email->send();

                $data['aviso'] = ''
                        . '
                  <div class="alert alert-success" role="alert">
                  <h4>
                  <p><b>Usuário cadastrado com sucesso!</b></p>
                  <p>Clique no botão abaixo e retorne para a tela de login, para entrar no sistema.</p>
                  </h4>
                  <br>
                  <a class="btn btn-primary" href="' . base_url() . '" role="button">Acessar o aplicativo</a>
                  </div> '
                        . '';

                $this->load->view('loginempresafilial/tela_msg', $data);
                #redirect(base_url() . 'loginempresafilial' . $data['msg']);
                #exit();
            }
        }

        $this->load->view('basico/footerloginempresafilial');
        $this->load->view('basico/footer');
    }

    public function confirmar($codigo) {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'ktraca';
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
        $id = $this->Loginempresafilial_model->get_data_by_codigo($codigo);

        if ($this->Loginempresafilial_model->ativa_usuario($codigo, $data['confirmar']) === TRUE) {

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idSis_EmpresaFilial'], TRUE);
            $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_EmpresaFilial', 'UPDATE', $data['auditoriaitem'], $id['idSis_EmpresaFilial']);

            $data['msg'] = '?m=4';
            redirect(base_url() . 'loginempresafilial/' . $data['msg']);
        } else {
            $data['msg'] = '?m=5';
            redirect(base_url() . 'loginempresafilial/' . $data['msg']);
        }
    }

    public function recuperar() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'ktraca';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'UsuarioEmpresaFilial',
                ), TRUE);

        if (isset($_GET['usuario']))
            $data['query']['UsuarioEmpresaFilial'] = $_GET['usuario'];

        $this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

        $this->form_validation->set_rules('UsuarioEmpresaFilial', 'UsuarioEmpresaFilial', 'required|trim|callback_valid_usuario');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresafilial view
            $this->load->view('loginempresafilial/form_recuperar', $data);
        } else {

            $data['query']['Codigo'] = md5(uniqid(time() . rand()));

            $id = $this->Loginempresafilial_model->get_data_by_usuario($data['query']['UsuarioEmpresaFilial']);

            if ($this->Loginempresafilial_model->troca_senha($id['idSis_EmpresaFilial'], array('Codigo' => $data['query']['Codigo'])) === FALSE) {

                $data['anterior'] = array(
                    'Codigo' => 'NULL'
                );

                $data['confirmar'] = array(
                    'Codigo' => $data['query']['Codigo']
                );

                $data['campos'] = array_keys($data['confirmar']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idSis_EmpresaFilial'], TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_EmpresaFilial', 'UPDATE', $data['auditoriaitem'], $id['idSis_EmpresaFilial']);

                $this->load->library('email');

                $this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                $this->email->to($id['Email']);

                $this->email->subject('[KTRACA] Alteração de Senha - Usuário: ' . $data['query']['UsuarioEmpresaFilial']);
                $this->email->message('Por favor, clique no link a seguir para alterar sua senha: '
                        //. 'http://www.romati.com.br/app/loginempresafilial/trocar_senha/' . $data['query']['Codigo']);
                        . base_url() . 'loginempresafilial/trocar_senha/' . $data['query']['Codigo']);

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
                $this->load->view('loginempresafilial/tela_msg', $data);
            } else {
                $data['msg'] = '?m=5';
                redirect(base_url() . 'loginempresafilial/' . $data['msg']);
            }
        }
    }

    public function trocar_senha($codigo = NULL) {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'ktraca';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idSis_EmpresaFilial',
            'Email',
            'UsuarioEmpresaFilial',
            'Codigo',
                ), TRUE);

        if ($codigo) {
            $data['query'] = $this->Loginempresafilial_model->get_data_by_codigo($codigo);
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
            #load loginempresafilial view
            $this->load->view('loginempresafilial/form_troca_senha', $data);
        } else {

            ###não está registrando a auditoria do trocar senha. tenho que ver isso
            ###ver também o link para troca, quando expirado avisar
            #$id = $data['query']['Senha']
            $data['query']['Senha'] = md5($data['query']['Senha']);
            $data['query']['Codigo'] = NULL;
            unset($data['query']['Confirma']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            if ($this->Loginempresafilial_model->troca_senha($data['query']['idSis_EmpresaFilial'], $data['query']) === TRUE) {
                $data['msg'] = '?m=2';
                $this->load->view('loginempresafilial/form_troca_senha', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_EmpresaFilial'], TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_EmpresaFilial', 'UPDATE', $data['auditoriaitem'], $data['query']['idSis_EmpresaFilial']);
                /*
                  echo $this->db->last_query();
                  echo "<pre>";
                  print_r($data);
                  echo "</pre>";
                  exit();
                 */
                $data['msg'] = '?m=1';
                redirect(base_url() . 'loginempresafilial' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footerloginempresafilial');
        $this->load->view('basico/footer');
    }

    public function sair($m = TRUE) {
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #set logout in database
        if ($_SESSION['log'] && $m === TRUE) {
            $this->Loginempresafilial_model->set_acesso($_SESSION['log']['id'], 'LOGOUT');
        } else {
            if (!isset($_SESSION['log']['id'])) {
                $_SESSION['log']['id'] = 1;
            }
            $this->Loginempresafilial_model->set_acesso($_SESSION['log']['id'], 'TIMEOUT');
            $data['msg'] = '?m=2';
        }

        #clear de session data
        $this->session->unset_userdata('log');
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage

        /*
          #load header view
          $this->load->view('basico/headerloginempresafilial');

          $msg = "<strong>Você saiu do sistema.</strong>";

          $this->basico->alerta($msg);
          $this->load->view('loginempresafilial');
          $this->load->view('basico/footer');
         *
         */

        redirect(base_url() . 'loginempresafilial/' . $data['msg']);
        #redirect('loginempresafilial');
    }

    function valid_usuario($data) {

        if ($this->Loginempresafilial_model->check_usuario($data) == 1) {
            $this->form_validation->set_message('valid_usuario', '<strong>%s</strong> não existe.');
            return FALSE;
        } else if ($this->Loginempresafilial_model->check_usuario($data) == 2) {
            $this->form_validation->set_message('valid_usuario', '<strong>%s</strong> inativo! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	


    function valid_senha($senha, $usuario) {

        if ($this->Loginempresafilial_model->check_dados_usuario($senha, $usuario) == FALSE) {
            $this->form_validation->set_message('valid_senha', '<strong>%s</strong> incorreta! Ou este não é o Módulo do seu Sistema.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	

}
