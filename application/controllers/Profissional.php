<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Profissional extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Profissional_model', 'Funcao_model', 'Contatoprof_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('profissional/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Fale com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('profissional/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Fale com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Profissional',
            'NomeProfissional',
            'DataNascimento',
            'Funcao',
            'Telefone1',
            'Telefone2',
            'Telefone3',

            'Sexo',
            'Endereco',
            'Bairro',
            'Municipio',

            'Obs',
			'Email',
            'idSis_Usuario',

            'Cnpj',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeProfissional', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Profissional.NomeProfissional.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('NomeProfissional', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();

        $data['titulo'] = 'Cadastrar Funcionários';
        $data['form_open_path'] = 'profissional/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        if ($data['query']['Sexo'] || $data['query']['Endereco'] || $data['query']['Bairro'] ||
                $data['query']['Municipio'] || $data['query']['Obs'] || $data['query']['Email'] || $data['query']['Cnpj'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('profissional/form_profissional', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('profissional/form_profissional', $data);

        } else {

            $data['query']['NomeProfissional'] = trim(mb_strtoupper($data['query']['NomeProfissional'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Profissional'] = $this->Profissional_model->set_profissional($data['query']);

            if ($data['idApp_Profissional'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Fale com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('profissional/form_profissional', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Profissional'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Profissional', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'profissional/prontuario/' . $data['idApp_Profissional'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Fale com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_Profissional',
            'NomeProfissional',
            'DataNascimento',
            'Funcao',
            'Telefone1',
            'Telefone2',
            'Telefone3',

            'Sexo',
            'Endereco',
            'Bairro',
            'Municipio',

            'Obs',
            'idSis_Usuario',
            'Email',
            'Cnpj',
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Profissional_model->get_profissional($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeProfissional', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Profissional.NomeProfissional.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('NomeProfissional', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
        $this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();

        $data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'profissional/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        if ($data['query']['Sexo'] || $data['query']['Endereco'] || $data['query']['Bairro'] ||
                $data['query']['Municipio'] || $data['query']['Obs'] || $data['query']['Email'] || $data['query']['Cnpj'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('profissional/form_profissional', $data);

        } else {

            $data['query']['NomeProfissional'] = trim(mb_strtoupper($data['query']['NomeProfissional'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Profissional_model->get_profissional($data['query']['idApp_Profissional']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Profissional'], TRUE);

            if ($data['auditoriaitem'] && $this->Profissional_model->update_profissional($data['query'], $data['query']['idApp_Profissional']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'profissional/form_profissional/' . $data['query']['idApp_Profissional'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Profissional', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'profissional/prontuario/' . $data['query']['idApp_Profissional'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function excluir2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Fale com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_Profissional',
            'submit'
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Profissional_model->get_profissional($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $data['query']['ProfissionalDataNascimento'] = $this->basico->mascara_data($data['query']['ProfissionalDataNascimento'], 'barras');
        }

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        $data['titulo'] = 'Tem certeza que deseja excluir o registro abaixo?';
        $data['form_open_path'] = 'profissional/excluir';
        $data['readonly'] = 'readonly';
        $data['disabled'] = 'disabled';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;

        $data['tela'] = $this->load->view('profissional/form_profissional', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('profissional/tela_profissional', $data);
        } else {

            if ($data['query']['idApp_Profissional'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('profissional/form_profissional', $data);
            } else {

                $data['anterior'] = $this->Profissional_model->get_profissional($data['query']['idApp_Profissional']);
                $data['campos'] = array_keys($data['anterior']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idApp_Profissional'], FALSE, TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Profissional', 'DELETE', $data['auditoriaitem']);

                $this->Profissional_model->delete_profissional($data['query']['idApp_Profissional']);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'profissional' . $data['msg']);
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

                $this->Profissional_model->delete_profissional($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }
	
    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Fale com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_profissional');

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);
        }

        $data['titulo'] = "Pesquisar Funcionário";

        $data['Pesquisa'] = $this->input->post('Pesquisa');
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Profissional_model->lista_profissional($data['Pesquisa'], FALSE) === TRUE) {

            $data['query'] = $this->Profissional_model->lista_profissional($data['Pesquisa'], TRUE);

            if ($data['query']->num_rows() == 1) {
                $info = $data['query']->result_array();

                if ($_SESSION['agenda'])
                    redirect('consulta/cadastrar/' . $info[0]['idApp_Profissional'] );
                else
                    redirect('profissional/prontuario/' . $info[0]['idApp_Profissional'] );

                exit();
            } else {
                $data['list'] = $this->load->view('profissional/list_profissional', $data, TRUE);
            }

        }

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('profissional/pesq_profissional', $data);

        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Fale com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Profissional'] = $data['query'] = $this->Profissional_model->get_profissional($id, TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' . $data['query']['NomeProfissional'];
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

        $_SESSION['log']['idApp_Profissional'] = $data['resumo']['idApp_Profissional'] = $data['query']['idApp_Profissional'];
        $data['resumo']['NomeProfissional'] = $data['query']['NomeProfissional'];

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

        $data['query']['Telefone'] = $data['query']['Telefone1'];
        ($data['query']['Telefone2']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone2'] : FALSE;
        ($data['query']['Telefone3']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone3'] : FALSE;


        if ($data['query']['Municipio']) {
            $mun = $this->Basico_model->get_municipio($data['query']['Municipio']);
            $data['query']['Municipio'] = $mun['NomeMunicipio'] . '/' . $mun['Uf'];
        } else {
            $data['query']['Municipio'] = $data['query']['Uf'] = $mun['Uf'] = '';
        }

        $data['contatoprof'] = $this->Contatoprof_model->lista_contatoprof(TRUE);
        /*
          echo "<pre>";
          print_r($data['contatoprof']);
          echo "</pre>";
          exit();
        */
        if (!$data['contatoprof'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('contatoprof/list_contatoprof', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        $this->load->view('profissional/tela_profissional', $data);

        $this->load->view('basico/footer');
    }

    function get_profissional($data) {

        if ($this->Profissional_model->lista_profissional($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_profissional', '<strong>Funcionário</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
