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
        $this->load->model(array('Basico_model', 'Funcao_model', 'Empresa_model', 'Usuario_model'));
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

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'idSis_Empresa',
			'idSis_Usuario',
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
        ), TRUE));

		#$this->load->model('Empresa_model');
		#$_SESSION['Empresa'] = $this->Empresa_model->get_empresa($idSis_Empresa, TRUE);
		#$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);

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
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
		$data['select']['Permissao'] = $this->Basico_model->select_permissao();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
		$data['select']['CompAgenda'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa2();
		
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
		$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuário', 'required|trim|is_unique_duplo[Sis_Usuario.CelularUsuario.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');		
		$this->form_validation->set_rules('Permissao', 'Acesso Ás Agendas', 'required|trim');		
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');		
		$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email|is_unique_duplo[Sis_Usuario.Email.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posiçao "Sim"', 'trim|valid_aprovado');
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_usuario', $data);
        } else {

			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

			$data['query']['Nome'] = trim(mb_strtoupper($nomeusuario1, 'ISO-8859-1'));
			$data['query']['QuemCad'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['NomeEmpresa'] = $_SESSION['log']['NomeEmpresa'];
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['query']['Inativo'] = 0;
			$data['query']['Codigo'] = md5(uniqid(time() . rand()));
			$data['query']['Senha'] = md5($data['query']['Senha']);
			unset($data['query']['Confirma']);


            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idSis_Usuario'] = $this->Usuario_model->set_usuario($data['query']);

            if ($data['idSis_Usuario'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('usuario/form_usuario', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Usuario'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				$data['agenda'] = array(
                    'NomeAgenda' => 'Usuario',
					'idSis_Empresa' => $_SESSION['log']['idSis_Empresa'],
                    'idSis_Usuario' => $data['idSis_Usuario']
                );
                $data['campos'] = array_keys($data['agenda']);

                $data['idApp_Agenda'] = $this->Usuario_model->set_agenda($data['agenda']);
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['agenda'], $data['campos'], $data['idSis_Usuario']);
                $data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'App_Agenda', 'CREATE', $data['auditoriaitem'], $data['idSis_Usuario']);
				
                #redirect(base_url() . 'empresa/prontuario/' . $data['msg']);
				redirect(base_url() . 'usuario/prontuario/' . $data['idSis_Usuario'] . $data['msg']);
				#redirect(base_url() . 'relatorio/usuario/' .  $data['msg']);
                exit();
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

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
       
		$data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idSis_Usuario',
			#'Usuario',
            'Nome',
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
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Usuario_model->get_usuario($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'barras');
        }

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
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa2();
		
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

        $data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

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
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim|is_unique_duplo[Sis_Usuario.Nome.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
		//$this->form_validation->set_rules('CelularUsuario', 'CelularUsuario', 'required|trim');
		$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuario', 'required|trim|is_unique_by_id_empresa[Sis_Usuario.CelularUsuario.' . $data['query']['idSis_Usuario'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('Permissao', 'Nível', 'required|trim');
		$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posiçao "Sim"', 'trim|valid_aprovado');		

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_usuarioalterar', $data);
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

        $this->load->view('basico/footer');
    }

    public function alteraronline($id = FALSE) {

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
			
			'idSis_Usuario_Online',
			'Inativo',

        ), TRUE);

        if ($id) {
            $data['query'] = $this->Usuario_model->get_usuario_online($id);
			$data['online']['Nome'] = $this->Basico_model->get_usuario_online($data['query']['idSis_Usuario'], TRUE);
		}

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim|is_unique_duplo[Sis_Usuario.Nome.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('Inativo', 'Ativo', 'required|trim');
		
		$data['select']['Inativo'] = $this->Basico_model->select_inativo2();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa2();
		
        $data['titulo'] = 'Editar Colaborador';
        $data['form_open_path'] = 'usuario/alteraronline';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        if ($data['query']['Inativo'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_usuarioalteraronline', $data);
        } else {

            $data['anterior'] = $this->Usuario_model->get_usuario_online($data['query']['idSis_Usuario_Online']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario_Online'], TRUE);

            if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario_online($data['query'], $data['query']['idSis_Usuario_Online']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'relatorioempresa/colaboradoronline/' . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    //$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario_Online', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'relatorioempresa/colaboradoronline/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function alterar2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idSis_Usuario',
			#'Usuario',
            'Nome',
            #'DataNascimento',
            'CelularUsuario',
            #'Email',
			#'Sexo',
			#'Permissao',
			#'Funcao',
			#'Inativo',
			#'CpfUsuario',
			'Senha',
			'Confirma',			
			#'RgUsuario',
			#'OrgaoExpUsuario',
			#'EstadoEmUsuario',
			#'DataEmUsuario',
			#'EnderecoUsuario',
			#'BairroUsuario',
			#'MunicipioUsuario',
			#'EstadoUsuario',
			#'CepUsuario',
			#'CompAgenda',
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Usuario_model->get_usuario($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'barras');
        }

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

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
		$data['select']['Permissao'] = $this->Basico_model->select_permissao();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
		$data['select']['CompAgenda'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa2();
		
        $data['titulo'] = 'Editar Usuário';
        $data['form_open_path'] = 'usuario/alterar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
/*
        if ($data['query']['EnderecoUsuario'] || $data['query']['BairroUsuario'] ||
			$data['query']['MunicipioUsuario'] || $data['query']['CepUsuario'] || $data['query']['RgUsuario']  || 
			$data['query']['OrgaoExpUsuario'] || $data['query']['EstadoEmUsuario']  || $data['query']['DataEmUsuario'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';
*/		
        $data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim|is_unique_duplo[Sis_Usuario.Nome.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
		//$this->form_validation->set_rules('CelularUsuario', 'CelularUsuario', 'required|trim');
		$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuario', 'required|trim|is_unique_by_id_empresa[Sis_Usuario.CelularUsuario.' . $data['query']['idSis_Usuario'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		#$this->form_validation->set_rules('Permissao', 'Nível', 'required|trim');
		#$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_usuarioalterar2', $data);
        } else {

            $data['query']['Nome'] = trim(mb_strtoupper($nomeusuario1, 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
            #$data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['Codigo'] = md5(uniqid(time() . rand()));
			$data['query']['Senha'] = md5($data['query']['Senha']);
			unset($data['query']['Confirma']);

            $data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

            if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'usuario/form_usuarioalterar2/' . $data['query']['idSis_Usuario'] . $data['msg']);
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

        $this->load->view('basico/footer');
    }

    public function alterarlogo1($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
        $data['form_open_path'] = 'usuario/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('usuario/form_perfil', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg', 'jpeg', 'gif', 'png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('usuario/form_perfil', $data);
            }
            else {

                $data['camposfile'] = array_keys($data['file']);
				$data['idSis_Arquivo'] = $this->Usuario_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('usuario/form_perfil', $data);
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
						redirect(base_url() . 'usuario/form_perfil/' . $data['query']['idSis_Usuario'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'usuario/prontuario/' . $data['file']['idSis_Usuario'] . $data['msg']);
						exit();
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
            
			$data['file']['Arquivo'] = $this->basico->renomeiausuario($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'usuario/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('usuario/form_perfil', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('usuario/form_perfil', $data);
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
				$data['idSis_Arquivo'] = $this->Usuario_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('usuario/form_perfil', $data);
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
						redirect(base_url() . 'usuario/form_perfil/' . $data['query']['idSis_Usuario'] . $data['msg']);
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

						redirect(base_url() . 'usuario/prontuario/' . $data['file']['idSis_Usuario'] . $data['msg']);
						exit();
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
       
		$data['query'] = $this->input->post(array(
			'idSis_Empresa',
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
                //$data['funcao'][$j]['DataConcluidoFuncao'] = $this->input->post('DataConcluidoFuncao' . $i);
                //$data['funcao'][$j]['HoraConcluidoFuncao'] = $this->input->post('HoraConcluidoFuncao' . $i);
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
            $_SESSION['Query'] = $data['query'] = $this->Usuario_model->get_usuario($id);
        
			
            #### App_Funcao ####
            $_SESSION['Funcao'] = $data['funcao'] = $this->Usuario_model->get_funcao($id);
            if (count($data['funcao']) > 0) {
                $data['funcao'] = array_combine(range(1, count($data['funcao'])), array_values($data['funcao']));
                $data['count']['PTCount'] = count($data['funcao']);

                if (isset($data['funcao'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++) {
                        /*
						$data['funcao'][$j]['DataFuncao'] = $this->basico->mascara_data($data['funcao'][$j]['DataFuncao'], 'barras');
						$data['funcao'][$j]['DataConcluidoFuncao'] = $this->basico->mascara_data($data['funcao'][$j]['DataConcluidoFuncao'], 'barras');
						$_SESSION['Funcao'][$j]['NomeCadastrou'] = $data['funcao'][$j]['NomeCadastrou'];				
						*/
						
						$data['radio'] = array(
							'Ativo_Funcao' . $j => $this->basico->radio_checked($data['funcao'][$j]['Ativo_Funcao'], 'Ativo_Funcao' . $j, 'NS'),
						);
						($data['funcao'][$j]['Ativo_Funcao'] == 'S') ? $data['div']['Ativo_Funcao' . $j] = '' : $data['div']['Ativo_Funcao' . $j] = 'style="display: none;"';
						
					}
                }
            }		
			
		}

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


        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_atuacoes', $data);
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
                    $data['update']['funcao']['inserir'][$j]['idSis_Empresa'] = $_SESSION['Query']['idSis_Empresa'];
                    $data['update']['funcao']['inserir'][$j]['idSis_Usuario'] = $data['query']['idSis_Usuario'];
					
					$data['update']['funcao']['inserir'][$j]['Comissao_Funcao'] = str_replace(',', '.', str_replace('.', '', $data['update']['funcao']['inserir'][$j]['Comissao_Funcao']));
                    //$data['update']['funcao']['inserir'][$j]['DataFuncao'] = $this->basico->mascara_data($data['update']['funcao']['inserir'][$j]['DataFuncao'], 'mysql');
					//$data['update']['funcao']['inserir'][$j]['DataConcluidoFuncao'] = $this->basico->mascara_data($data['update']['funcao']['inserir'][$j]['DataConcluidoFuncao'], 'mysql');
                }

                $max = count($data['update']['funcao']['alterar']);
                for($j=0;$j<$max;$j++) {
					
					$data['update']['funcao']['alterar'][$j]['Comissao_Funcao'] = str_replace(',', '.', str_replace('.', '', $data['update']['funcao']['alterar'][$j]['Comissao_Funcao']));
                    //$data['update']['funcao']['alterar'][$j]['DataFuncao'] = $this->basico->mascara_data($data['update']['funcao']['alterar'][$j]['DataFuncao'], 'mysql');
					//$data['update']['funcao']['alterar'][$j]['DataConcluidoFuncao'] = $this->basico->mascara_data($data['update']['funcao']['alterar'][$j]['DataConcluidoFuncao'], 'mysql');
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

        $this->load->view('basico/footer');
    }

    public function permissoes($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
			'Permissao_Comissao',
        ), TRUE);

		(!$data['query']['Rel_Com']) ? $data['query']['Rel_Com'] = 'N' : FALSE;
		
        if ($id) {
            $data['query'] = $this->Usuario_model->get_usuario($id);
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');	
		if($data['query']['Rel_Com'] == "S"){
			$this->form_validation->set_rules('Permissao_Comissao', 'Permissão da Comissão', 'required|trim');
		}
        $data['select']['Cad_Orcam'] = $this->Basico_model->select_status_sn();
        $data['select']['Ver_Orcam'] = $this->Basico_model->select_status_sn();
        $data['select']['Edit_Orcam'] = $this->Basico_model->select_status_sn();
        $data['select']['Delet_Orcam'] = $this->Basico_model->select_status_sn();
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
		$data['select']['Permissao_Comissao'] = array (
            '1' => '1-Retrita à Própria',
            '2' => '2-Irrestrita s/Edição',
			'3' => '3-Irrestrita c/Edição',
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

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_permissoes', $data);
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

        $this->load->view('basico/footer');
    }
	
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

    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Usuario'] = $data['query'] = $this->Usuario_model->get_usuario($id, TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' . $data['query']['Nome'];
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
        $this->load->view('usuario/tela_usuario', $data);

        $this->load->view('basico/footer');
    }

    function get_usuario($data) {

        if ($this->Usuario_model->lista_usuario($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_usuario', '<strong>Usuario</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
