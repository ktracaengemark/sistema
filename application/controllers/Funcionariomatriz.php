<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionariomatriz extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Funcionariomatriz_model'));
        #$this->load->model(array('Basico_model', 'Funcionariomatriz_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresamatriz');

        #$this->load->view('funcionariomatriz/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('funcionariomatriz/tela_index', $data);

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

        $data['query'] = quotes_to_entities($this->input->post(array(
			'idSis_UsuarioMatriz',
			'UsuarioMatriz',
            'Nome',
			'Senha',
			'Confirma',
            'DataNascimento',
            'Celular',
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

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		#$this->form_validation->set_rules('Email', 'E-mail', 'required|trim|valid_email|is_unique[Sis_UsuarioMatriz.Email]');
        $this->form_validation->set_rules('CpfUsuario', 'Cpf do Usuário', 'required|trim|is_unique_emp[Sis_UsuarioMatriz.CpfUsuario.idSis_EmpresaMatriz:idSis_EmpresaMatriz]');
		$this->form_validation->set_rules('UsuarioMatriz', 'Nome do Func./ Usuário', 'required|trim|is_unique[Sis_UsuarioMatriz.UsuarioMatriz]');
		$this->form_validation->set_rules('Nome', 'Nome do Usuário', 'required|trim');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
        #$this->form_validation->set_rules('Celular', 'Celular', 'required|trim');
		$this->form_validation->set_rules('Permissao', 'Acesso Às Agendas', 'required|trim');
		$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');

        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		#$data['select']['Funcionariomatriz'] = $this->Basico_model->select_status_sn();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
		$data['select']['Permissao'] = $this->Basico_model->select_permissao();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
		$data['select']['CompAgenda'] = $this->Basico_model->select_status_sn();
		#$data['select']['idSis_EmpresaMatriz'] = $this->Basico_model->select_empresa_matriz();
		
        $data['titulo'] = 'Cadastrar Usuário';
        $data['form_open_path'] = 'funcionariomatriz/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('funcionariomatriz/form_funcionariomatriz', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('funcionariomatriz/form_funcionariomatriz', $data);
        } else {


			$data['query']['QuemCad'] = $_SESSION['log']['idSis_UsuarioMatriz'];
			$data['query']['idSis_EmpresaMatriz'] = $_SESSION['log']['idSis_EmpresaMatriz'];
			$data['query']['NomeEmpresa'] = $_SESSION['log']['NomeEmpresa'];
            $data['query']['Senha'] = md5($data['query']['Senha']);
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
            $data['query']['Codigo'] = md5(uniqid(time() . rand()));
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['query']['Inativo'] = 0;
			$data['query']['Nivel'] = 6;
			$data['query']['Permissao'] = 3;
			#$data['query']['Funcao'] = 1;            
			unset($data['query']['Confirma']);


            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idSis_UsuarioMatriz'] = $this->Funcionariomatriz_model->set_funcionariomatriz($data['query']);

            if ($data['idSis_UsuarioMatriz'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('funcionariomatriz/form_funcionariomatriz', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_UsuarioMatriz'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoriaempresamatriz($data['auditoriaitem'], 'Sis_UsuarioMatriz', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				$data['agenda'] = array(
                    'NomeAgenda' => 'Matriz',
					'idSis_EmpresaMatriz' => $_SESSION['log']['idSis_EmpresaMatriz'],
                    'idSis_UsuarioMatriz' => $data['idSis_UsuarioMatriz']
                );
                $data['campos'] = array_keys($data['agenda']);

                $data['idApp_Agenda'] = $this->Funcionariomatriz_model->set_agenda($data['agenda']);
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['agenda'], $data['campos'], $data['idSis_UsuarioMatriz']);
                $data['auditoria'] = $this->Basico_model->set_auditoriaempresamatriz($data['auditoriaitem'], 'App_Agenda', 'CREATE', $data['auditoriaitem'], $data['idSis_UsuarioMatriz']);
				
                redirect(base_url() . 'funcionariomatriz/prontuario/' . $data['idSis_UsuarioMatriz'] . $data['msg']);
				#redirect(base_url() . 'relatorio/funcionariomatriz/' .  $data['msg']);
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

        $data['query'] = $this->input->post(array(

			'idSis_UsuarioMatriz',
			#'UsuarioMatriz',
            'Nome',
            'DataNascimento',
            'Celular',
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
            $data['query'] = $this->Funcionariomatriz_model->get_funcionariomatriz($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim|is_unique_duplo[Sis_UsuarioMatriz.Nome.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
		$this->form_validation->set_rules('Celular', 'Celular', 'required|trim');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('Permissao', 'Nível', 'required|trim');
		$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		#$data['select']['Funcionariomatriz'] = $this->Basico_model->select_status_sn();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
		$data['select']['Permissao'] = $this->Basico_model->select_permissao();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
		$data['select']['CompAgenda'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Editar Usuário';
        $data['form_open_path'] = 'funcionariomatriz/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;



        $data['nav_secundario'] = $this->load->view('funcionariomatriz/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('funcionariomatriz/form_funcionariomatrizalterar', $data);
        } else {

            $data['query']['Nome'] = trim(mb_strtoupper($data['query']['Nome'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
            #$data['query']['Obs'] = nl2br($data['query']['Obs']);
            #$data['query']['Funcionariomatriz'] = $_SESSION['log']['idSis_UsuarioMatriz'];

            $data['anterior'] = $this->Funcionariomatriz_model->get_funcionariomatriz($data['query']['idSis_UsuarioMatriz']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_UsuarioMatriz'], TRUE);

            if ($data['auditoriaitem'] && $this->Funcionariomatriz_model->update_funcionariomatriz($data['query'], $data['query']['idSis_UsuarioMatriz']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'funcionariomatriz/form_funcionariomatrizalterar/' . $data['query']['idSis_UsuarioMatriz'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_UsuarioMatriz', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'funcionariomatriz/prontuario/' . $data['query']['idSis_UsuarioMatriz'] . $data['msg']);
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

        $this->Funcionariomatriz_model->delete_funcionariomatriz($id);

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

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_funcionariomatriz');

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);
        }

        $data['titulo'] = "Pesquisar Funcionariomatriz";

        $data['Pesquisa'] = $this->input->post('Pesquisa');
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Funcionariomatriz_model->lista_funcionariomatriz($data['Pesquisa'], FALSE) === TRUE) {

            $data['query'] = $this->Funcionariomatriz_model->lista_funcionariomatriz($data['Pesquisa'], TRUE);

            if ($data['query']->num_rows() == 1) {
                $info = $data['query']->result_array();

                if ($_SESSION['agenda'])
                    redirect('consulta/cadastrar/' . $info[0]['idSis_UsuarioMatriz'] );
                else
                    redirect('funcionariomatriz/prontuario/' . $info[0]['idSis_UsuarioMatriz'] );

                exit();
            } else {
                $data['list'] = $this->load->view('funcionariomatriz/list_funcionariomatriz', $data, TRUE);
            }

        }

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('funcionariomatriz/pesq_funcionariomatriz', $data);

        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Funcionariomatriz'] = $data['query'] = $this->Funcionariomatriz_model->get_funcionariomatriz($id, TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' . $data['query']['Nome'];
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

        $_SESSION['log']['idSis_UsuarioMatriz'] = $data['resumo']['idSis_UsuarioMatriz'] = $data['query']['idSis_UsuarioMatriz'];
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
		$data['query']['Empresa'] = $this->Basico_model->get_empresa($data['query']['Empresa']);
		#$data['query']['Funcionariomatriz'] = $data['query']['Funcionariomatriz'];
		$data['query']['CompAgenda'] = $this->Basico_model->get_compagenda($data['query']['CompAgenda']);
        $data['query']['Telefone'] = $data['query']['Celular'];
		$data['query']['CpfUsuario'] = $data['query']['CpfUsuario'];

        $data['contatofuncionariomatriz'] = $this->Funcionariomatriz_model->lista_contatofuncionariomatriz($id, TRUE);
        /*
          echo "<pre>";
          print_r($data['contatofuncionariomatriz']);
          echo "</pre>";
          exit();
          */
        if (!$data['contatofuncionariomatriz'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('funcionariomatriz/list_contatofuncionariomatriz', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('funcionariomatriz/nav_secundario', $data, TRUE);
        $this->load->view('funcionariomatriz/tela_funcionariomatriz', $data);

        $this->load->view('basico/footer');
    }

    function get_funcionariomatriz($data) {

        if ($this->Funcionariomatriz_model->lista_funcionariomatriz($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_funcionariomatriz', '<strong>Funcionariomatriz</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
