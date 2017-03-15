<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Contato_model', 'Relacom_model', 'Empresa_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('contato/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('contato/tela_index', $data);

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
            'idApp_Contato',
            'idSis_Usuario',
            'NomeContato',
            'StatusVida',
            'DataNascimento',
            'Sexo',
			'RelaCom',
			'TelefoneContato',
            'Obs',
            'idApp_Empresa',
                        ), TRUE));

        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVida']='V';
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContato', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContato', 'TelefoneContato', 'required|trim');
        $this->form_validation->set_rules('RelaCom', 'RelaCom', 'required|trim');
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contato_model->select_status_vida();
		$data['select']['RelaCom'] = $this->Relacom_model->select_relacom();
        $data['titulo'] = 'Cadastrar Contato';
        $data['form_open_path'] = 'contato/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);
        
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contato/form_contato', $data);
        } else {

            $data['query']['NomeContato'] = trim(mb_strtoupper($data['query']['NomeContato'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Contato'] = $this->Contato_model->set_contato($data['query']);

            if ($data['idApp_Contato'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('contato/form_contato', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Contato'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Contato', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'contato/pesquisar/' . $_SESSION['Empresa']['idApp_Empresa'] . $data['msg']);
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
            'idApp_Contato',
            'idSis_Usuario',
            'NomeContato',
            'StatusVida',
            'DataNascimento',
            'Sexo',
			'RelaCom',
            'TelefoneContato',
            'Obs',
            'idApp_Empresa',
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Contato_model->get_contato($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $_SESSION['log']['idApp_Contato'] = $id;
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContato', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContato', 'TelefoneContato', 'required|trim');
        $this->form_validation->set_rules('RelaCom', 'RelaCom', 'required|trim');
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contato_model->select_status_vida();
        $data['select']['RelaCom'] = $this->Relacom_model->select_relacom();       
        $data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'contato/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contato/form_contato', $data);
        } else {

            $data['query']['NomeContato'] = trim(mb_strtoupper($data['query']['NomeContato'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id']; 
			$data['query']['idApp_Contato'] = $_SESSION['log']['idApp_Contato'];

            $data['anterior'] = $this->Contato_model->get_contato($data['query']['idApp_Contato']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Contato'], TRUE);

            if ($data['auditoriaitem'] && $this->Contato_model->update_contato($data['query'], $data['query']['idApp_Contato']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'contato/form_contato/' . $data['query']['idApp_Contato'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Contato', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'contato/pesquisar/' . $_SESSION['Empresa']['idApp_Empresa'] . $data['msg']);
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

        $data['query'] = $this->input->post(array(
            'idApp_Contato',
            'submit'
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Contato_model->get_contato($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $data['query']['ContatoDataNascimento'] = $this->basico->mascara_data($data['query']['ContatoDataNascimento'], 'barras');
        }

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        $data['titulo'] = 'Tem certeza que deseja excluir o registro abaixo?';
        $data['form_open_path'] = 'contato/excluir';
        $data['readonly'] = 'readonly';
        $data['disabled'] = 'disabled';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;

        $data['tela'] = $this->load->view('contato/form_contato', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contato/tela_contato', $data);
        } else {

            if ($data['query']['idApp_Contato'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('contato/form_contato', $data);
            } else {

                $data['anterior'] = $this->Contato_model->get_contato($data['query']['idApp_Contato']);
                $data['campos'] = array_keys($data['anterior']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idApp_Contato'], FALSE, TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Contato', 'DELETE', $data['auditoriaitem']);

                $this->Contato_model->delete_contato($data['query']['idApp_Contato']);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'contato' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function pesquisar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'), 0, -3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'), 0, -3);
        }

        $_SESSION['Empresa'] = $this->Empresa_model->get_empresa($id, TRUE);
        
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        $data['query'] = $this->Contato_model->lista_contato(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('contato/list_contato', $data, TRUE);
        
        $data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

        $this->load->view('contato/tela_contato', $data);

        $this->load->view('basico/footer');
    }

}
