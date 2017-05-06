<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Contatoprof extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Contatoprof_model', 'Relapes_model', 'Profissional_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('contatoprof/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('contatoprof/tela_index', $data);

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
            'idApp_ContatoProf',
            'idSis_Usuario',
            'NomeContatoProf',
            'StatusVida',
            'DataNascimento',
            'Sexo',
			'RelaPes',
			'TelefoneContatoProf',
            'Obs',
            'idApp_Profissional',
                        ), TRUE));

        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVida']='V';
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContatoProf', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContatoProf', 'TelefoneContatoProf', 'required|trim');
        $this->form_validation->set_rules('RelaPes', 'RelaPes', 'required|trim');
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contatoprof_model->select_status_vida();
		$data['select']['RelaPes'] = $this->Relapes_model->select_relapes();
        $data['titulo'] = 'Cadastrar Contatoprof';
        $data['form_open_path'] = 'contatoprof/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatoprof/form_contatoprof', $data);
        } else {

            $data['query']['NomeContatoProf'] = trim(mb_strtoupper($data['query']['NomeContatoProf'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_ContatoProf'] = $this->Contatoprof_model->set_contatoprof($data['query']);

            if ($data['idApp_ContatoProf'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('contatoprof/form_contatoprof', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_ContatoProf'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoProf', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'contatoprof/pesquisar/' . $_SESSION['Profissional']['idApp_Profissional'] . $data['msg']);
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
            'idApp_ContatoProf',
            'idSis_Usuario',
            'NomeContatoProf',
            'StatusVida',
            'DataNascimento',
            'Sexo',
			'RelaPes',
            'TelefoneContatoProf',
            'Obs',
            'idApp_Profissional',
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Contatoprof_model->get_contatoprof($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $_SESSION['log']['idApp_ContatoProf'] = $id;
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContatoProf', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContatoProf', 'TelefoneContatoProf', 'required|trim');
        $this->form_validation->set_rules('RelaPes', 'RelaPes', 'required|trim');
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contatoprof_model->select_status_vida();
        $data['select']['RelaPes'] = $this->Relapes_model->select_relapes();
        $data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'contatoprof/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatoprof/form_contatoprof', $data);
        } else {

            $data['query']['NomeContatoProf'] = trim(mb_strtoupper($data['query']['NomeContatoProf'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id']; 
			$data['query']['idApp_ContatoProf'] = $_SESSION['log']['idApp_ContatoProf'];

            $data['anterior'] = $this->Contatoprof_model->get_contatoprof($data['query']['idApp_ContatoProf']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ContatoProf'], TRUE);

            if ($data['auditoriaitem'] && $this->Contatoprof_model->update_contatoprof($data['query'], $data['query']['idApp_ContatoProf']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'contatoprof/form_contatoprof/' . $data['query']['idApp_ContatoProf'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoProf', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'contatoprof/pesquisar/' . $_SESSION['Profissional']['idApp_Profissional'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function excluir2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_ContatoProf',
            'submit'
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Contatoprof_model->get_contatoprof($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $data['query']['ContatoprofDataNascimento'] = $this->basico->mascara_data($data['query']['ContatoprofDataNascimento'], 'barras');
        }

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        $data['titulo'] = 'Tem certeza que deseja excluir o registro abaixo?';
        $data['form_open_path'] = 'contatoprof/excluir';
        $data['readonly'] = 'readonly';
        $data['disabled'] = 'disabled';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;

        $data['tela'] = $this->load->view('contatoprof/form_contatoprof', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatoprof/tela_contatoprof', $data);
        } else {

            if ($data['query']['idApp_ContatoProf'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('contatoprof/form_contatoprof', $data);
            } else {

                $data['anterior'] = $this->Contatoprof_model->get_contatoprof($data['query']['idApp_ContatoProf']);
                $data['campos'] = array_keys($data['anterior']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idApp_ContatoProf'], FALSE, TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoProf', 'DELETE', $data['auditoriaitem']);

                $this->Contatoprof_model->delete_contatoprof($data['query']['idApp_ContatoProf']);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'contatoprof' . $data['msg']);
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

                $this->Contatoprof_model->delete_contatoprof($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'contatoprof/pesquisar/' . $_SESSION['Profissional']['idApp_Profissional'] . $data['msg']);
				exit();
            //}
        //}

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

        $_SESSION['Profissional'] = $this->Profissional_model->get_profissional($id, TRUE);
        
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        $data['query'] = $this->Contatoprof_model->lista_contatoprof(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('contatoprof/list_contatoprof', $data, TRUE);
        
        $data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);

        $this->load->view('contatoprof/tela_contatoprof', $data);

        $this->load->view('basico/footer');
    }

}
