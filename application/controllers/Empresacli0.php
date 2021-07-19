<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresacli0 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Empresacli_model', 'Cliente_model', 'Procedimento_model', 'Usuario_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header0');
        //$this->load->view('basico/nav_principal0');
        //$this->load->view('basico/headerlogin');
        $this->load->view('basico/nav_principal_site');

        #$this->load->view('empresa/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('empresa/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function prontuario($id) {
	
        $this->load->view('basico/logologin');

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Empresa'] = $data['query'] = $this->Empresacli_model->get_empresa($id, TRUE);
        
		#$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' ;
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

		$data['query']['Inativo'] = $this->Basico_model->get_inativo($data['query']['Inativo']);
		$data['query']['Empresa'] = $this->Basico_model->get_empresa($data['query']['NomeEmpresa']);

        if ($data['query']['CategoriaEmpresa'] == 1)
            $data['query']['profile'] = 'm';
        elseif ($data['query']['CategoriaEmpresa'] == 2)
            $data['query']['profile'] = 'f';
        else
            $data['query']['profile'] = 'o';
        
        $data['query']['CategoriaEmpresa'] = $this->Basico_model->get_categoriaempresa($data['query']['CategoriaEmpresa']);
		
        $data['query']['Telefone'] = $data['query']['CelularAdmin'];

        /*
          echo "<pre>";
          print_r($data['contatoempresa']);
          echo "</pre>";
          exit();
		*/

		$this->load->view('empresacli/tela_empresacli0', $data);
		
        $this->load->view('basico/baselogin');
        $this->load->view('basico/footer');
    }

    public function pesquisar() {
	
        $this->load->view('basico/logologin');

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_empresa');

        $data['titulo'] = "Pesquisar Empresa";

        $data['Pesquisa'] = $this->input->post('Pesquisa');
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Empresacli_model->lista_empresa($data['Pesquisa'], FALSE) === TRUE) {

            $data['query'] = $this->Empresacli_model->lista_empresa($data['Pesquisa'], TRUE);

			if (!$data['query'])
				$data['list'] = FALSE;
			else
				$data['list'] = $this->load->view('empresacli/list_empresa0', $data, TRUE);			

        }

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('empresacli/pesq_empresa0', $data);
		
        $this->load->view('basico/baselogin');
        $this->load->view('basico/footer');
    }

    function get_empresa($data) {

        if ($this->Empresacli_model->lista_empresa($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_empresa', '<strong>Empresa, Produto ou Serviço</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
}
