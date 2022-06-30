<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario2 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Cliente_model', 'Usuario_model'));
        #$this->load->model(array('Basico_model', 'Usuario_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('usuario/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('usuario/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function associadoalterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
       
		$data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idSis_Usuario',
			#'Usuario',
            'Nome',
            'DataNascimento',
            //'CelularUsuario',
            'Email',
			'Sexo',
			//'Permissao',
			//'Funcao',
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
        ), TRUE);

        if ($id) {
            $_SESSION['Query'] = $data['query'] = $this->Usuario_model->get_usuario($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'barras');
        }

		$caracteres_sem_acento = array(
			'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
			'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
			'�'=>'I', '�'=>'N', 'N'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
			'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
			'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
			'�'=>'i', '�'=>'o', '�'=>'n', 'n'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
			'�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f',
			'a'=>'a', '�'=>'i', '�'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', '�'=>'I', '�'=>'A', '?'=>'S', '?'=>'T',
		);

		$nomeusuario1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['Nome'], $caracteres_sem_acento));		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
		//$data['select']['Permissao'] = $this->Basico_model->select_permissao();
		//$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
		$data['select']['CompAgenda'] = $this->Basico_model->select_status_sn();
		//$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa2();
		
        $data['titulo'] = 'Editar Usu�rio';
        $data['form_open_path'] = 'usuario2/associadoalterar';
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

        $data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Nome', 'Nome do Respons�vel', 'required|trim|is_unique_duplo[Sis_Usuario.Nome.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('Nome', 'Nome do Usu�rio', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataEmUsuario', 'Data de Emiss�o', 'trim|valid_date');
		//$this->form_validation->set_rules('CelularUsuario', 'CelularUsuario', 'required|trim');
		//$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuario', 'required|trim|is_unique_by_id_empresa[Sis_Usuario.CelularUsuario.' . $data['query']['idSis_Usuario'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		//$this->form_validation->set_rules('Permissao', 'N�vel', 'required|trim');
		//$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');
		//$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi�ao "Sim"', 'trim|valid_aprovado');		

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_associadoalterar', $data);
        } else {

            $data['query']['Nome'] = trim(mb_strtoupper(nomeusuario1, 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
            #$data['query']['Obs'] = nl2br($data['query']['Obs']);


            $data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

            if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'usuario2/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'usuario2/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterarsenha($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idSis_Usuario',
            'Nome',
            'CelularUsuario',
            'Senha',
        ), TRUE);

        if ($id) {
			$data['query'] = $this->Usuario_model->get_usuario($id);
		}

		$caracteres_sem_acento = array(
			'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
			'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
			'�'=>'I', '�'=>'N', 'N'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
			'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
			'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
			'�'=>'i', '�'=>'o', '�'=>'n', 'n'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
			'�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f',
			'a'=>'a', '�'=>'i', '�'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', '�'=>'I', '�'=>'A', '?'=>'S', '?'=>'T',
		);

		$nomeusuario1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['Nome'], $caracteres_sem_acento));		

        $data['titulo'] = 'Editar Senha';
        $data['form_open_path'] = 'usuario2/alterarsenha';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        if ($data['query']['Nome'] || $data['query']['CelularUsuario'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Nome', 'Nome do Respons�vel', 'required|trim');
        $this->form_validation->set_rules('CelularUsuario', 'Celular do Usuario', 'required|trim|is_unique_by_id_empresa[Sis_Usuario.CelularUsuario.' . $data['query']['idSis_Usuario'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');		

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_usuariosenha', $data);
        } else {

            $data['query']['Nome'] = trim(mb_strtoupper($nomeusuario1, 'ISO-8859-1'));
            $data['query']['Senha'] = md5($data['query']['Senha']);
			$data['query']['Codigo'] = md5(uniqid(time() . rand()));	


            $data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

			$data['update']['associado'] = $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']);
			
            if ($data['auditoriaitem'] && $data['update']['associado'] === FALSE) {
                $data['msg'] = '?m=1';				

                redirect(base_url() . 'usuario2/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
				
				#### App_Cliente ####
				$data['update']['cliente']['alterar'] = $this->Cliente_model->get_cliente_associado($data['query']['idSis_Usuario']);
				if (isset($data['update']['cliente']['alterar'])){

					$max = count($data['update']['cliente']['alterar']);
					for($j=0;$j<$max;$j++) {
					
						$data['update']['cliente']['alterar'][$j]['senha'] 	= $data['query']['Senha'];
						$data['update']['cliente']['alterar'][$j]['Codigo'] = $data['query']['Codigo'];

						$data['update']['cliente']['bd'][$j] = $this->Cliente_model->update_cliente($data['update']['cliente']['alterar'][$j], $data['update']['cliente']['alterar'][$j]['idApp_Cliente']);
					
					}
				}				

				
                redirect(base_url() . 'usuario2/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterarconta($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idSis_Usuario',
			//'Nome',
			'Banco',
			'Agencia',
			'Conta',
		), TRUE);

		if ($id) {
			$data['query'] = $this->Usuario_model->get_usuario_verificacao($id);
	
			if($data['query'] === FALSE){
				
				unset($_SESSION['Query']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}
		}
	
		if(!$data['query']['idSis_Usuario']){
			
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {

			$caracteres_sem_acento = array(
				'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
				'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
				'�'=>'I', '�'=>'N', 'N'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
				'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
				'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
				'�'=>'i', '�'=>'o', '�'=>'n', 'n'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
				'�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f',
				'a'=>'a', '�'=>'i', '�'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', '�'=>'I', '�'=>'A', '?'=>'S', '?'=>'T',
			);

			//$nomeusuario1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['Nome'], $caracteres_sem_acento));		

			$data['titulo'] = 'Editar Conta';
			$data['form_open_path'] = 'usuario2/alterarconta';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 2;

			if ($data['query']['Agencia'] || $data['query']['Conta'])
				$data['collapse'] = '';
			else
				$data['collapse'] = 'class="collapse"';

			$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

			$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
			$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			//$this->form_validation->set_rules('Nome', 'Nome do Usu�rio', 'required|trim');
			$this->form_validation->set_rules('Conta', 'Chave Pix / Conta', 'trim');

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('usuario/form_usuarioconta', $data);
			} else {

				//$data['query']['Nome'] = trim(mb_strtoupper($nomeusuario1, 'ISO-8859-1'));


				$data['anterior'] = $this->Usuario_model->get_usuario_verificacao($data['query']['idSis_Usuario']);
				$data['campos'] = array_keys($data['query']);

				$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

				if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
					$data['msg'] = '?m=1';
					
					redirect(base_url() . 'usuario2/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
					exit();
				} else {

					if ($data['auditoriaitem'] === FALSE) {
						$data['msg'] = '';
					} else {
						$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';
					}

					redirect(base_url() . 'usuario2/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
					exit();
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function alterarlogo1($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Usuario',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Usuario',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Usuario'] = $data['query'] = $this->Usuario_model->get_usuario($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Usuario'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->limpa_nome_arquivo($_FILES['Arquivo']['name']);
			$data['file']['Arquivo'] = $this->basico->renomeiausuario($data['file']['Arquivo'], '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/');
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'usuario2/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('usuario/form_perfil2', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg', 'jpeg', 'gif', 'png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('usuario/form_perfil2', $data);
            }
            else {

                $data['camposfile'] = array_keys($data['file']);
				$data['idSis_Arquivo'] = $this->Usuario_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('usuario/form_perfil2', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

					if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'usuario/form_perfil2/' . $data['query']['idSis_Usuario'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'usuario2/prontuario/' . $data['file']['idSis_Usuario'] . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterarlogo($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Usuario',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Usuario',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Query'] = $data['query'] = $this->Usuario_model->get_usuario_verificacao($id, TRUE);
	
			if($data['query'] === FALSE){
				
				unset($_SESSION['Query']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				$data['file']['idSis_Usuario'] = $id;
			}
		}
	
		if(!$data['query']['idSis_Usuario'] || !$_SESSION['Query']){
			
			unset($_SESSION['Query']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {

			$data['titulo'] = 'Alterar Foto';
			$data['form_open_path'] = 'usuario2/alterarlogo';
			$data['readonly'] = 'readonly';
			$data['panel'] = 'primary';
			$data['metodo'] = 2;

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
				$this->load->view('usuario/form_perfil2', $data);
			} else {
				
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {
					
					$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/';
					$config['max_size'] = 1000;
					$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
					$config['file_name'] = $data['file']['Arquivo'];

					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('Arquivo')) {
						$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
						$this->load->view('usuario/form_perfil2', $data);
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
						$data['idSis_Arquivo'] = $this->Usuario_model->set_arquivo($data['file']);

						if ($data['idSis_Arquivo'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
							$this->basico->erro($msg);
							$this->load->view('usuario/form_perfil2', $data);
						} else {

							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
							
							$data['query']['Arquivo'] = $data['file']['Arquivo'];
							$data['anterior'] = $this->Usuario_model->get_usuario_verificacao($data['query']['idSis_Usuario']);
							$data['campos'] = array_keys($data['query']);

							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

							if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
								$data['msg'] = '?m=2';
								redirect(base_url() . 'usuario/form_perfil2/' . $data['query']['idSis_Usuario'] . $data['msg']);
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
									$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
									$data['msg'] = '?m=1';
								}
								
								unset($_SESSION['Query']);
								redirect(base_url() . 'usuario2/prontuario/' . $data['file']['idSis_Usuario'] . $data['msg']);
								exit();
							}				
						}
					}
				}	
			}
		}
        $this->load->view('basico/footer');
    }

    public function permissoes($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
       
		$data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idSis_Usuario',
			'DataEmUsuario',
			'Cad_Orcam',
			'Ver_Orcam',
			'Edit_Orcam',
			'Delet_Orcam',
			'Rel_Pag',
			'Bx_Pag',
			'Rel_Com',
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Usuario_model->get_usuario($id);
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataEmUsuario', 'Data de Emiss�o', 'trim|valid_date');	

        $data['select']['Cad_Orcam'] = $this->Basico_model->select_status_sn();
        $data['select']['Ver_Orcam'] = $this->Basico_model->select_status_sn();
        $data['select']['Edit_Orcam'] = $this->Basico_model->select_status_sn();
        $data['select']['Delet_Orcam'] = $this->Basico_model->select_status_sn();
        $data['select']['Rel_Pag'] = $this->Basico_model->select_status_sn();
        $data['select']['Rel_Com'] = $this->Basico_model->select_status_sn();
        $data['select']['Bx_Pag'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Permiss�es do Usu�rio';
        $data['form_open_path'] = 'usuario2/permissoes';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        if ($data['query']['Cad_Orcam'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_permissoes2', $data);
        } else {


            $data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

            if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'usuario2/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'usuario2/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_usuario');

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);
        }

        $data['titulo'] = "Pesquisar Usuario";

        $data['Pesquisa'] = $this->input->post('Pesquisa');
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Usuario_model->lista_usuario($data['Pesquisa'], FALSE) === TRUE) {

            $data['query'] = $this->Usuario_model->lista_usuario($data['Pesquisa'], TRUE);

            if ($data['query']->num_rows() == 1) {
                $info = $data['query']->result_array();

                if ($_SESSION['agenda'])
                    redirect('consulta/cadastrar/' . $info[0]['idSis_Usuario'] );
                else
                    redirect('usuario/prontuario/' . $info[0]['idSis_Usuario'] );

                exit();
            } else {
                $data['list'] = $this->load->view('usuario/list_usuario', $data, TRUE);
            }

        }

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('usuario/pesq_usuario', $data);

        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{		
			
			$data['query'] = $this->Usuario_model->get_usuario_verificacao($id, TRUE);
		
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {

				$data['titulo'] = 'Prontu�rio ' . $data['query']['Nome'];
				$data['panel'] = 'primary';
				$data['metodo'] = 4;

				$_SESSION['log']['idSis_Usuario'] = $data['resumo']['idSis_Usuario'] = $data['query']['idSis_Usuario'];
				$data['resumo']['Nome'] = $data['query']['Nome'];

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
				$this->load->view('usuario/tela_usuario2', $data);
			}
		}
		
        $this->load->view('basico/footer');
    }

    function get_usuario($data) {

        if ($this->Usuario_model->lista_usuario($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_usuario', '<strong>Usuario</strong> n�o encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
