<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Contatofornec extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Contatofornec_model', 'Relacao_model', 'Fornecedor_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('contatofornec/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('contatofornec/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Contatofornec',
            'idSis_Usuario',
            'NomeContatofornec',
            'StatusVida',
			'Ativo',
            'DataNascimento',
            'Sexo',
			'Relacao',
			'TelefoneContatofornec',
            'Obs',
            'idApp_Fornecedor',
                        ), TRUE));

        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVida']='V';
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContatofornec', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContatofornec', 'TelefoneContatofornec', 'required|trim');
        $this->form_validation->set_rules('Relacao', 'Relacao', 'required|trim');
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contatofornec_model->select_status_vida();
		$data['select']['Relacao'] = $this->Relacao_model->select_relacao();
        $data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Cadastrar Contatofornec';
        $data['form_open_path'] = 'contatofornec/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['nav_secundario'] = $this->load->view('fornecedor/nav_secundario', $data, TRUE);
        
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatofornec/form_contatofornec', $data);
        } else {

            $data['query']['NomeContatofornec'] = trim(mb_strtoupper($data['query']['NomeContatofornec'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Contatofornec'] = $this->Contatofornec_model->set_contatofornec($data['query']);

            if ($data['idApp_Contatofornec'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('contatofornec/form_contatofornec', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Contatofornec'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Contatofornec', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'contatofornec/pesquisar/' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_Contatofornec',
            'idSis_Usuario',
            'NomeContatofornec',
            'StatusVida',
            'DataNascimento',
            'Sexo',
			'Relacao',
			'Ativo',
            'TelefoneContatofornec',
            'Obs',
            'idApp_Fornecedor',
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Contatofornec_model->get_contatofornec($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $_SESSION['log']['idApp_Contatofornec'] = $id;
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContatofornec', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContatofornec', 'TelefoneContatofornec', 'required|trim');
        $this->form_validation->set_rules('Relacao', 'Relacao', 'required|trim');
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contatofornec_model->select_status_vida();
        $data['select']['Relacao'] = $this->Relacao_model->select_relacao();       
        $data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'contatofornec/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['nav_secundario'] = $this->load->view('fornecedor/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatofornec/form_contatofornec', $data);
        } else {

            $data['query']['NomeContatofornec'] = trim(mb_strtoupper($data['query']['NomeContatofornec'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario']; 
			$data['query']['idApp_Contatofornec'] = $_SESSION['log']['idApp_Contatofornec'];

            $data['anterior'] = $this->Contatofornec_model->get_contatofornec($data['query']['idApp_Contatofornec']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Contatofornec'], TRUE);

            if ($data['auditoriaitem'] && $this->Contatofornec_model->update_contatofornec($data['query'], $data['query']['idApp_Contatofornec']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'contatofornec/pesquisar/' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Contatofornec', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'contatofornec/pesquisar/' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

                $this->Contatofornec_model->delete_contatofornec($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'contatofornec/pesquisar/' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

    
    public function pesquisar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'), 0, -3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'), 0, -3);
        }

        $_SESSION['Fornecedor'] = $this->Fornecedor_model->get_fornecedor($id, TRUE);
        
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        $data['query'] = $this->Contatofornec_model->lista_contatofornec(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('contatofornec/list_contatofornec', $data, TRUE);
        
        $data['nav_secundario'] = $this->load->view('fornecedor/nav_secundario', $data, TRUE);

        $this->load->view('contatofornec/tela_contatofornec', $data);

        $this->load->view('basico/footer');
    }

}
