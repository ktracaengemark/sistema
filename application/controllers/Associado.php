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
        $this->load->model(array('Basico_model', 'Funcao_model', 'Cliente_model', 'Usuario_model', 'Associado_model', 'Associado_model'));
        #$this->load->model(array('Basico_model', 'Associado_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('associado/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('associado/tela_index', $data);

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
			'idSis_Associado',
            'Nome',
            'DataNascimento',
            //'CelularAssociado',
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
            $_SESSION['Query'] = $data['query'] = $this->Associado_model->get_associado($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			$data['query']['DataEmAssociado'] = $this->basico->mascara_data($data['query']['DataEmAssociado'], 'barras');
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

        #$this->form_validation->set_rules('Nome', 'Nome do Respons�vel', 'required|trim|is_unique_duplo[Sis_Associado.Nome.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('Nome', 'Nome do Associado', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataEmAssociado', 'Data de Emiss�o', 'trim|valid_date');
		//$this->form_validation->set_rules('CelularAssociado', 'CelularAssociado', 'required|trim');
		//$this->form_validation->set_rules('CelularAssociado', 'Celular do Associado', 'required|trim|is_unique_by_id_empresa[Sis_Associado.CelularAssociado.' . $data['query']['idSis_Associado'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');	

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('associado/form_associadoalterar', $data);
        } else {

            $data['query']['Nome'] = trim(mb_strtoupper($nomeassociado1, 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataEmAssociado'] = $this->basico->mascara_data($data['query']['DataEmAssociado'], 'mysql');
            #$data['query']['Obs'] = nl2br($data['query']['Obs']);


            $data['anterior'] = $this->Associado_model->get_associado($data['query']['idSis_Associado']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Associado'], TRUE);

            if ($data['auditoriaitem'] && $this->Associado_model->update_associado($data['query'], $data['query']['idSis_Associado']) === FALSE) {
                $data['msg'] = '?m=1';
				unset($_SESSION['Query']);
				redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Associado', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
				unset($_SESSION['Query']);
                redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
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
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Este Celular j� est� sendo usado como Login.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idSis_Associado',
            'Nome',
            'CelularAssociado',
            'Senha',
        ), TRUE);

        if ($id) {
			$_SESSION['Query'] = $data['query'] = $this->Associado_model->get_associado($id);
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

		$nomeassociado1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['Nome'], $caracteres_sem_acento));		

        $data['titulo'] = 'Editar Senha';
        $data['form_open_path'] = 'associado/alterarsenha';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        if ($data['query']['Nome'] || $data['query']['CelularAssociado'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('associado/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Nome', 'Nome do Respons�vel', 'required|trim');
        $this->form_validation->set_rules('CelularAssociado', 'Celular do Associado', 'required|trim|is_unique_by_id_empresa[Sis_Associado.CelularAssociado.' . $data['query']['idSis_Associado'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');		

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('associado/form_associadosenha', $data);
        } else {

        
			if($_SESSION['Query']['CelularAssociado'] != $data['query']['CelularAssociado']){
				//trocou o celular 
				//pesquiso se existe algum associado neste n�mero 
				$data['associado'] = $this->Associado_model->get_associado_celular($data['query']['CelularAssociado']);

				if($data['associado'] != FALSE){
					//existe um associado usando este login
					$data['msg'] = '?m=3';	
					redirect(base_url() . 'associado/alterarsenha/' . $data['query']['idSis_Associado'] . $data['msg']);
					exit();					
					
				}else{
					//n�o existe associado usando este login
					$data['query']['Nome'] 		= trim(mb_strtoupper($nomeassociado1, 'ISO-8859-1'));
					$data['query']['Senha'] 	= md5($data['query']['Senha']);
					$data['query']['Codigo'] 	= md5(uniqid(time() . rand()));	
					$data['query']['Associado'] = $data['query']['CelularAssociado'];

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
							
								$data['update']['cliente']['alterar'][$j]['CelularCliente'] = $data['query']['CelularAssociado'];
								$data['update']['cliente']['alterar'][$j]['usuario'] 		= $data['query']['CelularAssociado'];
								$data['update']['cliente']['alterar'][$j]['senha'] 			= $data['query']['Senha'];
								$data['update']['cliente']['alterar'][$j]['Codigo'] 		= $data['query']['Codigo'];

								$data['update']['cliente']['bd'][$j] = $this->Cliente_model->update_cliente($data['update']['cliente']['alterar'][$j], $data['update']['cliente']['alterar'][$j]['idApp_Cliente']);
							
							}
						}				
						
						#### Sis_Usuario ####
						$data['update']['usuario']['alterar'] = $this->Usuario_model->get_usuario_associado($data['query']['idSis_Associado']);
						
						if (isset($data['update']['usuario']['alterar'])){

							$max_usuario = count($data['update']['usuario']['alterar']);

							for($j=0;$j<$max_usuario;$j++) {
							
								$data['update']['usuario']['alterar'][$j]['CelularUsuario'] = $data['query']['CelularAssociado'];
								$data['update']['usuario']['alterar'][$j]['Usuario'] 		= $data['query']['CelularAssociado'];
								$data['update']['usuario']['alterar'][$j]['Senha'] 			= $data['query']['Senha'];
								$data['update']['usuario']['alterar'][$j]['Codigo'] 		= $data['query']['Codigo'];

								$data['update']['usuario']['bd'][$j] = $this->Usuario_model->update_usuario($data['update']['usuario']['alterar'][$j], $data['update']['usuario']['alterar'][$j]['idSis_Usuario']);
									
							}
						}
						
						redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
						exit();
					}				
				
				}
			}else{

				$data['query']['Nome'] = trim(mb_strtoupper($nomeassociado1, 'ISO-8859-1'));
				$data['query']['Senha'] = md5($data['query']['Senha']);
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
					
					redirect(base_url() . 'associado/prontuario/' . $data['query']['idSis_Associado'] . $data['msg']);
					exit();
				}
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
			'idSis_Associado',
            'Nome',
            'Banco',
            'Agencia',
            'Conta',
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Associado_model->get_associado($id);
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

		$nomeassociado1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['Nome'], $caracteres_sem_acento));		

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

        $this->form_validation->set_rules('Nome', 'Nome do Usu�rio', 'required|trim');
        $this->form_validation->set_rules('Conta', 'Chave Pix / Conta', 'required|trim');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('associado/form_associadoconta', $data);
        } else {

            $data['query']['Nome'] = trim(mb_strtoupper($nomeassociado1, 'ISO-8859-1'));


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
			'idSis_Associado',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Associado',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Usuario'] = $data['query'] = $this->Associado_model->get_associado($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Associado'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->limpa_nome_arquivo($_FILES['Arquivo']['name']);
			$data['file']['Arquivo'] = $this->basico->renomeiaassociado($data['file']['Arquivo'], '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/');
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
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
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg', 'jpeg', 'gif', 'png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('associado/form_perfil2', $data);
            }
            else {

                $data['camposfile'] = array_keys($data['file']);
				$data['idSis_Arquivo'] = $this->Associado_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('associado/form_perfil2', $data);
                }
				else {

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

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Associado', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'associado/prontuario/' . $data['file']['idSis_Associado'] . $data['msg']);
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
			'idSis_Associado',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Associado',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Usuario'] = $data['query'] = $this->Associado_model->get_associado($id, TRUE);
			$data['file']['idSis_Associado'] = $id;
		}
		/*
        if ($id)
            $data['file']['idSis_Associado'] = $id;
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeiaassociado($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
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
        }
        else {


            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('associado/form_perfil2', $data);
            }
            else {

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
                }
				else {

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

						redirect(base_url() . 'associado/prontuario/' . $data['file']['idSis_Associado'] . $data['msg']);
						exit();
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
			'idSis_Associado',
			'DataEmAssociado',
			'Cad_Orcam',
			'Ver_Orcam',
			'Edit_Orcam',
			'Delet_Orcam',
			'Rel_Pag',
			'Bx_Pag',
			'Rel_Com',
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Associado_model->get_associado($id);
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataEmAssociado', 'Data de Emiss�o', 'trim|valid_date');	

        $data['select']['Cad_Orcam'] = $this->Basico_model->select_status_sn();
        $data['select']['Ver_Orcam'] = $this->Basico_model->select_status_sn();
        $data['select']['Edit_Orcam'] = $this->Basico_model->select_status_sn();
        $data['select']['Delet_Orcam'] = $this->Basico_model->select_status_sn();
        $data['select']['Rel_Pag'] = $this->Basico_model->select_status_sn();
        $data['select']['Rel_Com'] = $this->Basico_model->select_status_sn();
        $data['select']['Bx_Pag'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Permiss�es do Usu�rio';
        $data['form_open_path'] = 'associado/permissoes';
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
            $this->load->view('associado/form_permissoes2', $data);
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

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_associado');

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);
        }

        $data['titulo'] = "Pesquisar Associado";

        $data['Pesquisa'] = $this->input->post('Pesquisa');
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Associado_model->lista_associado($data['Pesquisa'], FALSE) === TRUE) {

            $data['query'] = $this->Associado_model->lista_associado($data['Pesquisa'], TRUE);

            if ($data['query']->num_rows() == 1) {
                $info = $data['query']->result_array();

                if ($_SESSION['agenda'])
                    redirect('consulta/cadastrar/' . $info[0]['idSis_Associado'] );
                else
                    redirect('associado/prontuario/' . $info[0]['idSis_Associado'] );

                exit();
            } else {
                $data['list'] = $this->load->view('associado/list_associado', $data, TRUE);
            }

        }

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('associado/pesq_associado', $data);

        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Usuario'] = $data['query'] = $this->Associado_model->get_associado($id, TRUE);
        /*
		echo "<pre>";
		print_r($data['query']);
		echo "</pre>";
		exit();		
		*/
		
        $data['titulo'] = 'Prontu�rio ' . $data['query']['Nome'];
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

        $this->load->view('basico/footer');
    }

    function get_associado($data) {

        if ($this->Associado_model->lista_associado($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_associado', '<strong>Associado</strong> n�o encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
