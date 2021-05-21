<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresacli2 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Empresacli_model', 'Cliente_model', 'Procedimento_model', 'Usuario_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

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

        $this->load->view('empresacli/tela_empresacli2', $data);

        $this->load->view('basico/footer');
    }

    public function cadastrarproc2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'idSis_Empresa',
			'idApp_Procedimento',
			'ProcedimentoCli',
			'DataProcedimentoCli',
			'ConcluidoProcedimentoCli',
			'ConcluidoProcedimento',

        ), TRUE));

		(!$data['query']['DataProcedimentoCli']) ? $data['query']['DataProcedimentoCli'] = date('d/m/Y', time()) : FALSE;
		
	   $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Procedimento', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Procedimento.Procedimento.DataProcedimento.' . $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql') . ']');

        $this->form_validation->set_rules('ProcedimentoCli', 'Mensagem', 'required|trim');
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
		
		$data['select']['ConcluidoProcedimentoCli'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa1();
		
        $data['titulo'] = 'Mensagem';
        $data['form_open_path'] = 'empresacli/cadastrarproc2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;


		$data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('empresacli/form_procedcli2', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('empresacli/form_procedcli2', $data);
        } else {

            $data['query']['DataProcedimentoCli'] = $this->basico->mascara_data($data['query']['DataProcedimentoCli'], 'mysql');            
			$data['query']['ProcedimentoCli'] = nl2br($data['query']['ProcedimentoCli']);
			$data['query']['idSis_EmpresaCli'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idSis_UsuarioCli'] = $_SESSION['log']['idSis_UsuarioCli'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['query']['ConcluidoProcedimentoCli'] = "S";
			$data['query']['ConcluidoProcedimento'] = "N";

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Procedimento'] = $this->Procedimento_model->set_procedimento($data['query']);

            if ($data['idApp_Procedimento'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('empresacli/form_procedcli2', $data);
            } else {

                #$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                #$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'agenda' . $data['msg']);

                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function cadastrarproc($idSis_Empresa = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_Procedimento ####
            'idApp_Procedimento',
            'idSis_Empresa',
			'ProcedimentoCli',
			'DataProcedimentoCli',
			'ConcluidoProcedimentoCli',
			'ConcluidoProcedimento',

        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        //Data de hoje como default
        (!$data['orcatrata']['DataProcedimentoCli']) ? $data['orcatrata']['DataProcedimentoCli'] = date('d/m/Y', time()) : FALSE;

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Procedimento ####
        $this->form_validation->set_rules('ProcedimentoCli', 'Mensagem', 'required|trim');


        $data['select']['ConcluidoProcedimentoCli'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();

        $data['titulo'] = 'Mensagem';
        $data['form_open_path'] = 'empresacli/cadastrarproc';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';	
		
        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('empresacli/form_procedcli', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Procedimento ####
            $data['orcatrata']['DataProcedimentoCli'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimentoCli'], 'mysql');
			$data['orcatrata']['idSis_EmpresaCli'] = $_SESSION['log']['idSis_Empresa'];
            $data['orcatrata']['idSis_UsuarioCli'] = $_SESSION['log']['idSis_UsuarioCli'];
            $data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['orcatrata']['ConcluidoProcedimentoCli'] = "S";
			$data['orcatrata']['ConcluidoProcedimento'] = "N";
            $data['orcatrata']['idApp_Procedimento'] = $this->Procedimento_model->set_orcatrata($data['orcatrata']);

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_Procedimento'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('empresacli/form_procedcli', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'agenda' . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function alterarproc($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_Procedimento ####
            #'idSis_UsuarioCli',
			'idApp_Procedimento',
            #Não há a necessidade de atualizar o valor do campo a seguir
            #'idSis_Empresa',
            'DataProcedimentoCli',
			'ProcedimentoCli',
			'ConcluidoProcedimentoCli',

        ), TRUE));


        if ($id) {
            #### App_Procedimento ####
            $data['orcatrata'] = $this->Procedimento_model->get_orcatrata($id);
            $data['orcatrata']['DataProcedimentoCli'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimentoCli'], 'barras');

            #### Carrega os dados da empresa nas variáves de sessão ####
            $this->load->model('Empresacli_model');
            $_SESSION['Empresa'] = $data['query'] = $this->Empresacli_model->get_empresa($data['orcatrata']['idSis_Empresa'], TRUE);
            $_SESSION['Empresa']['NomeEmpresa'] = (strlen($data['query']['NomeEmpresa']) > 12) ? substr($data['query']['NomeEmpresa'], 0, 12) : $data['query']['NomeEmpresa'];
			#$_SESSION['log']['idSis_Empresa'] = $_SESSION['Empresa']['idSis_Empresa'];

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Procedimento ####
        $this->form_validation->set_rules('DataProcedimentoCli', 'Data do Procedimento', 'required|trim|valid_date');

        $data['select']['ConcluidoProcedimentoCli'] = $this->Basico_model->select_status_sn();
        $data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();

        $data['titulo'] = 'Editar Procedimento com Empresa';
        $data['form_open_path'] = 'empresacli/alterarproc';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		$data['collapse'] = '';
	
		$data['collapse1'] = 'class="collapse"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('empresacli/form_procedcli', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Procedimento ####
            $data['orcatrata']['DataProcedimentoCli'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimentoCli'], 'mysql');
			#$data['orcatrata']['idSis_EmpresaCli'] = $_SESSION['log']['idSis_Empresa'];
            #$data['orcatrata']['idSis_UsuarioCli'] = $_SESSION['log']['idSis_UsuarioCli'];
            #$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['orcatrata']['anterior'] = $this->Procedimento_model->get_orcatrata($data['orcatrata']['idApp_Procedimento']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_Procedimento'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Procedimento_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_Procedimento']);


/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_Procedimento'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('empresacli/form_procedcli', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'agenda' . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function excluirproc($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

                $this->Procedimento_model->delete_procedimento($id);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'agenda' . $data['msg']);
                exit();

        $this->load->view('basico/footer');
    }

    public function listarproc($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['OrcaTrata'] = $this->Procedimento_model->get_cliente($id, TRUE);
        //$_SESSION['OrcaTrata']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Procedimento_model->list_orcamento($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Procedimento_model->list_orcamento($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('procedimento/list_procedcli', $data, TRUE);
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('procedimento/list_procedcli', $data);

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
				$data['list'] = $this->load->view('empresacli/list_empresa2', $data, TRUE);			

        }

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('empresacli/pesq_empresa2', $data);

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
