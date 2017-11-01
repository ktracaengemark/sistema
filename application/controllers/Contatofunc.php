<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Contatofunc extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Contatofunc_model', 'Relapes_model', 'Funcionario_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

        #$this->load->view('contatofunc/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('contatofunc/tela_index', $data);

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
            'idApp_ContatoFunc',
            'idSis_EmpresaFilial',			
            'NomeContatoFunc',
            'StatusVida',
			'Ativo',
            'DataNascimento',
            'Sexo',
			'RelaPes',
			'TelefoneContatoFunc',
            'Obs',
            'idSis_Usuario',
                        ), TRUE));

        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVida']='V';
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContatoFunc', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContatoFunc', 'TelefoneContatoFunc', 'required|trim');
        $this->form_validation->set_rules('RelaPes', 'RelaPes', 'required|trim');
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contatofunc_model->select_status_vida();
		$data['select']['RelaPes'] = $this->Relapes_model->select_relapes();
        $data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Cadastrar Contatofunc';
        $data['form_open_path'] = 'contatofunc/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['nav_secundario'] = $this->load->view('funcionario/nav_secundario', $data, TRUE);
        
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatofunc/form_contatofunc', $data);
        } else {

            $data['query']['NomeContatoFunc'] = trim(mb_strtoupper($data['query']['NomeContatoFunc'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['idSis_EmpresaFilial'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_ContatoFunc'] = $this->Contatofunc_model->set_contatofunc($data['query']);

            if ($data['idApp_ContatoFunc'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('contatofunc/form_contatofunc', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_ContatoFunc'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoFunc', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'contatofunc/pesquisar/' . $_SESSION['Funcionario']['idSis_Usuario'] . $data['msg']);
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
            'idApp_ContatoFunc',
            'idSis_EmpresaFilial',
            'NomeContatoFunc',
            'StatusVida',
            'DataNascimento',
            'Sexo',
			'RelaPes',
            'TelefoneContatoFunc',
            'Obs',
            'idSis_Usuario',
			'Ativo',
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Contatofunc_model->get_contatofunc($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $_SESSION['log']['idApp_ContatoFunc'] = $id;
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContatoFunc', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContatoFunc', 'TelefoneContatoFunc', 'required|trim');
        $this->form_validation->set_rules('RelaPes', 'RelaPes', 'required|trim');
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contatofunc_model->select_status_vida();
        $data['select']['RelaPes'] = $this->Relapes_model->select_relapes();
        $data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'contatofunc/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['nav_secundario'] = $this->load->view('funcionario/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatofunc/form_contatofunc', $data);
        } else {

            $data['query']['NomeContatoFunc'] = trim(mb_strtoupper($data['query']['NomeContatoFunc'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
            $data['query']['idSis_EmpresaFilial'] = $_SESSION['log']['id']; 
			$data['query']['idApp_ContatoFunc'] = $_SESSION['log']['idApp_ContatoFunc'];

            $data['anterior'] = $this->Contatofunc_model->get_contatofunc($data['query']['idApp_ContatoFunc']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ContatoFunc'], TRUE);

            if ($data['auditoriaitem'] && $this->Contatofunc_model->update_contatofunc($data['query'], $data['query']['idApp_ContatoFunc']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'contatofunc/form_contatofunc/' . $data['query']['idApp_ContatoFunc'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoFunc', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'contatofunc/pesquisar/' . $_SESSION['Funcionario']['idSis_Usuario'] . $data['msg']);
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
            'idApp_ContatoFunc',
            'submit'
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Contatofunc_model->get_contatofunc($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $data['query']['ContatofuncDataNascimento'] = $this->basico->mascara_data($data['query']['ContatofuncDataNascimento'], 'barras');
        }

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        $data['titulo'] = 'Tem certeza que deseja excluir o registro abaixo?';
        $data['form_open_path'] = 'contatofunc/excluir';
        $data['readonly'] = 'readonly';
        $data['disabled'] = 'disabled';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;

        $data['tela'] = $this->load->view('contatofunc/form_contatofunc', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatofunc/tela_contatofunc', $data);
        } else {

            if ($data['query']['idApp_ContatoFunc'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('contatofunc/form_contatofunc', $data);
            } else {

                $data['anterior'] = $this->Contatofunc_model->get_contatofunc($data['query']['idApp_ContatoFunc']);
                $data['campos'] = array_keys($data['anterior']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idApp_ContatoFunc'], FALSE, TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoFunc', 'DELETE', $data['auditoriaitem']);

                $this->Contatofunc_model->delete_contatofunc($data['query']['idApp_ContatoFunc']);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'contatofunc' . $data['msg']);
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

                $this->Contatofunc_model->delete_contatofunc($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'contatofunc/pesquisar/' . $_SESSION['Funcionario']['idSis_Usuario'] . $data['msg']);
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

        $_SESSION['Funcionario'] = $this->Funcionario_model->get_funcionario($id, TRUE);
        
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        $data['query'] = $this->Contatofunc_model->lista_contatofunc(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('contatofunc/list_contatofunc', $data, TRUE);
        
        $data['nav_secundario'] = $this->load->view('funcionario/nav_secundario', $data, TRUE);

        $this->load->view('contatofunc/tela_contatofunc', $data);

        $this->load->view('basico/footer');
    }

}
