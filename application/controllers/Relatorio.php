<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Relatorio_model', 'Empresa_model', 'Loginempresa_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('relatorio/nav_secundario');
        if ($this->agent->is_browser()) {

            if (
                    (preg_match("/(chrome|Firefox)/i", $this->agent->browser()) && $this->agent->version() < 30) ||
                    (preg_match("/(safari)/i", $this->agent->browser()) && $this->agent->version() < 6) ||
                    (preg_match("/(opera)/i", $this->agent->browser()) && $this->agent->version() < 12) ||
                    (preg_match("/(internet explorer)/i", $this->agent->browser()) && $this->agent->version() < 9 )
            ) {
                $msg = '<h2><strong>Navegador não suportado.</strong></h2>';

                echo $this->basico->erro($msg);
                exit();
            }
        }		
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('relatorio/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

	public function admin() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Cadastrar';
		$data['titulo2'] = 'Finanças & Estoque';
		$data['titulo3'] = 'Relatório 3';
		$data['titulo4'] = 'Comissão';
		
		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorio/tela_admin', $data);

        $this->load->view('basico/footer');

    }

	public function adminempresa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Cadastrar';
		$data['titulo2'] = 'Relatórios';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorio/tela_adminempresa', $data);

        $this->load->view('basico/footer');

    }

	public function evento_cli() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Consulta',
			'idApp_Cliente',
			'idApp_ClientePet',
			'idApp_ClienteDep',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
        ), TRUE));

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';
		
		$data['select']['Campo'] = array(
			'CO.DataInicio' => 'Data',
			'CO.idApp_Consulta' => 'id do Agendamento',
		);		
		
        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		//$data['select']['idApp_Cliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['idApp_ClientePet'] = $this->Relatorio_model->select_clientepet();
		$data['select']['idApp_ClienteDep'] = $this->Relatorio_model->select_clientedep();

		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Lista de Agendamentos';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/evento_cli';
		$data['panel'] = 'info';
		$data['Data'] = 'Data';
		$data['TipoRD'] = 2;
		$data['TipoEvento'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'ConsultaPrint/imprimirlista/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'Consulta/alterar/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';	

        $_SESSION['Agendamentos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['Agendamentos']['DataFim'] 	= $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$_SESSION['Agendamentos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['Agendamentos']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
		$_SESSION['Agendamentos']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
		$_SESSION['Agendamentos']['Campo'] = $data['query']['Campo'];
		$_SESSION['Agendamentos']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['Agendamentos']['TipoEvento'] = $data['TipoEvento'];	

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$data['bd']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
			$data['bd']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['TipoEvento'] = $data['TipoEvento'];
			
			//$data['report'] = $this->Relatorio_model->list_agendamentos($data['bd'],TRUE);

			//$this->load->library('pagination');
			$config['per_page'] = 10;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';
			
			$config['base_url'] = base_url() . 'relatorio_pag/evento_cli_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_agendamentos($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_agendamentos($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list1'] = $this->load->view('relatorio/list_agendamentos', $data, TRUE);
        }

        $this->load->view('relatorio/tela_agendamentos', $data);

        $this->load->view('basico/footer');

    }

	public function evento() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Consulta',
			'idApp_Cliente',
			'idApp_ClientePet',
			'idApp_ClienteDep',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
        ), TRUE));

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';
		
		$data['select']['Campo'] = array(
			'CO.DataInicio' => 'Data',
			'CO.idApp_Consulta' => 'id do Agendamento',
		);		
		
        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		//$data['select']['idApp_Cliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['idApp_ClientePet'] = $this->Relatorio_model->select_clientepet();
		$data['select']['idApp_ClienteDep'] = $this->Relatorio_model->select_clientedep();

		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Lista de Agendamentos';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/evento';
		$data['panel'] = 'info';
		$data['Data'] = 'Data';
		$data['TipoRD'] = 2;
		$data['TipoEvento'] = 1;
        $data['nome'] = 'Cliente';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'ConsultaPrint/imprimirlista/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'Consulta/alterar/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';	

        $_SESSION['Agendamentos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['Agendamentos']['DataFim'] 	= $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$_SESSION['Agendamentos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['Agendamentos']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
		$_SESSION['Agendamentos']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
		$_SESSION['Agendamentos']['Campo'] = $data['query']['Campo'];
		$_SESSION['Agendamentos']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['Agendamentos']['TipoEvento'] = $data['TipoEvento'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$data['bd']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
			$data['bd']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['TipoEvento'] = $data['TipoEvento'];
			
			//$data['report'] = $this->Relatorio_model->list_agendamentos($data['bd'],TRUE);

			//$this->load->library('pagination');
			$config['per_page'] = 10;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';
			
			$config['base_url'] = base_url() . 'relatorio_pag/evento_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_agendamentos($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_agendamentos($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list1'] = $this->load->view('relatorio/list_agendamentos', $data, TRUE);
        }

        $this->load->view('relatorio/tela_agendamentos', $data);

        $this->load->view('basico/footer');

    }

	public function list_agendamentos() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Consulta',
			'idApp_Cliente',
			'idApp_ClientePet',
			'idApp_ClienteDep',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
        ), TRUE));

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';
		
		$data['select']['Campo'] = array(
			'CO.DataInicio' => 'Data',
			'CO.idApp_Consulta' => 'id do Agendamento',
		);		
		
        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		//$data['select']['idApp_Cliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['idApp_ClientePet'] = $this->Relatorio_model->select_clientepet();
		$data['select']['idApp_ClienteDep'] = $this->Relatorio_model->select_clientedep();

		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Lista de Agendamentos';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/list_agendamentos';
		$data['panel'] = 'info';
		$data['Data'] = 'Data';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'ConsultaPrint/imprimirlista/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'Consulta/alterar/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';	

        $_SESSION['Agendamentos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['Agendamentos']['DataFim'] 	= $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$_SESSION['Agendamentos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['Agendamentos']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
		$_SESSION['Agendamentos']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
		$_SESSION['Agendamentos']['Campo'] = $data['query']['Campo'];
		$_SESSION['Agendamentos']['Ordenamento'] = $data['query']['Ordenamento'];	

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$data['bd']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
			$data['bd']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			
			//$data['report'] = $this->Relatorio_model->list_agendamentos($data['bd'],TRUE);

			//$this->load->library('pagination');
			$config['per_page'] = 10;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';
			
			$config['base_url'] = base_url() . 'relatorio_pag/agendamentos_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_agendamentos($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_agendamentos($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list1'] = $this->load->view('relatorio/list_agendamentos', $data, TRUE);
        }

        $this->load->view('relatorio/tela_agendamentos', $data);

        $this->load->view('basico/footer');

    }

	public function receitas() {
		
		unset($_SESSION['FiltroAlteraParcela']);
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'Orcamento',
			'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'idApp_OrcaTrata',
			'NomeAssociado',
			'idSis_Usuario',
			'DataVencimentoOrca',
			//'NomeCliente',
			'NomeUsuario',
			'NomeEmpresa',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'TipoFinanceiro',
			'idTab_TipoRD',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
			'CombinadoFrete',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'StatusComissaoOrca',
			'StatusComissaoOrca_Online',
			'Quitado',
			'Modalidade',
			'AVAP',
			'Tipo_Orca',
			'FormaPagamento',
			'TipoFrete',
			'Orcarec',
			'Orcades',
			'Produtos',
			'idTab_Catprod',
			'DataValidadeProduto',
			'ConcluidoProduto',
			'DevolvidoProduto',
			'ConcluidoServico',
			'Agrupar',
			'Ultimo',
			'nome',
        ), TRUE));

		/*		   
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));
   
	   if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
		*/
		//$_SESSION['DataInicio'] = $data['query']['DataInicio'];
	
		
		/*
		if (!$data['query']['DataInicio'])
			$data['query']['DataInicio'] = "01/01/2021";
		*/
		/*
			if($_SESSION['DataInicio']){
			$data['query']['DataInicio'] = $_SESSION['DataInicio'];
		} 
		
		echo "<br>";
		echo "<pre>";
		print_r($_SESSION['DataInicio']);
		echo "</pre>";
		exit();		
		*/

		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
        $data['select']['AprovadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['CombinadoFrete'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['FinalizadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CanceladoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['Quitado'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['DevolvidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['ConcluidoServico'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => 'TODOS',
            'V' => 'Na Loja',
			'O' => 'On Line',
            'P' => 'Na Entrega',
        );
		
		$data['select']['Tipo_Orca'] = array(
            '0' => 'TODOS',
            'B' => 'Na Loja',
            'O' => 'On Line',
        );
		
		$data['select']['StatusComissaoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
		$data['select']['StatusComissaoOrca_Online'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
        $data['select']['Agrupar'] = array(
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Cliente' => 'Cliente',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			'1' => 'Último Pedido',
        );		

        $data['select']['Campo'] = array(
			'OT.idApp_OrcaTrata' => 'id do Pedido',
			'OT.DataOrca' => 'Data do Pedido',
			'OT.DataEntregaOrca' => 'Data da Entrega',
			'C.idApp_Cliente' => 'id do Cliente',
			'C.NomeCliente' => 'Nome do Cliente',
			'C.DataCadastroCliente' => 'Data do Cadastro',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );


		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();		
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		$data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresa();
		
		$data['query']['nome'] = 'Cliente';
        $data['titulo'] = 'Receitas';
		$data['form_open_path'] = 'relatorio/receitas';
		$data['baixatodas'] = 'Orcatrata/alterarreceitas/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio/alterarreceitas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistacliente/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';	
		$data['paginacao'] = 'N';	

        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['Produtos'] = $data['query']['Produtos'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		//$_SESSION['FiltroAlteraParcela']['NomeCliente'] = $data['query']['NomeCliente'];
		$_SESSION['FiltroAlteraParcela']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroAlteraParcela']['NomeAssociado'] = $data['query']['NomeAssociado'];
		$_SESSION['FiltroAlteraParcela']['NomeFornecedor'] = $data['query']['NomeFornecedor'];		
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroAlteraParcela']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroAlteraParcela']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroAlteraParcela']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroAlteraParcela']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroAlteraParcela']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroAlteraParcela']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroAlteraParcela']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroAlteraParcela']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
		$_SESSION['FiltroAlteraParcela']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
		//$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['FiltroAlteraParcela']['Ultimo'] = $data['query']['Ultimo'];
		$_SESSION['FiltroAlteraParcela']['nome'] = $data['query']['nome'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
		$_SESSION['FiltroAlteraParcela']['metodo'] = $data['metodo'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['TipoRD'];
		$_SESSION['Imprimir']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        
		$this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Vnc da Prc', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Vnc da Prc', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio5', 'Data Início do Pag Comissao', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio6', 'Data Início do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');
				
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

			#$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
            //$data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
            $data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['NomeAssociado'] = $data['query']['NomeAssociado'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$data['bd']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$data['bd']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
			$data['bd']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
			$data['bd']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
			$data['bd']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$data['bd']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
            $data['bd']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$data['bd']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
            $data['bd']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$data['bd']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
            $data['bd']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['Ultimo'] = $data['query']['Ultimo'];
			$data['bd']['nome'] = $data['query']['nome']; 
			$data['bd']['metodo'] = $data['metodo'];
            $data['bd']['idTab_TipoRD'] = $data['TipoRD'];              
			
			#$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE);
			$data['pesquisa_query'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			//$config['total_rows'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);			
			$config['base_url'] = base_url() . 'relatorio_pag/receitas_pag/';
			//$this->load->library('pagination');
			$config['per_page'] = 50;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';

			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list1'] = $this->load->view('relatorio/list_orcamento', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_orcamento', $data);

        $this->load->view('basico/footer');

    }

	public function despesas() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Fornecedor_Auto',
			'NomeFornecedorAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'Orcamento',
			'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'idApp_OrcaTrata',
			'NomeAssociado',
			'idSis_Usuario',
			'DataVencimentoOrca',
			//'NomeCliente',
			'NomeUsuario',
			'NomeEmpresa',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'TipoFinanceiro',
			'idTab_TipoRD',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
			'CombinadoFrete',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'StatusComissaoOrca',
			'StatusComissaoOrca_Online',
			'Quitado',
			'Modalidade',
			'AVAP',
			'Tipo_Orca',
			'FormaPagamento',
			'TipoFrete',
			'Orcarec',
			'Orcades',
			'Produtos',
			'idTab_Catprod',
			'DataValidadeProduto',
			'ConcluidoProduto',
			'DevolvidoProduto',
			'ConcluidoServico',
			'Agrupar',
			'Ultimo',
			'nome',
        ), TRUE));

/*		   
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));
   
	   if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/

		
		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
		
        $data['select']['AprovadoOrca'] = array(
            '0' => 'TODOS',
			'N' => 'Não Aprovado',
			'S' => 'Aprovado',
        );

        $data['select']['CombinadoFrete'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não Pago',
            'S' => 'Pago',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não Entregue',
            'S' => 'Entregue',
        );

		$data['select']['FinalizadoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não Finalizado',
            'S' => 'Finalizado',
        );

		$data['select']['CanceladoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não Cancelado',
            'S' => 'Cancelado',
        );

		$data['select']['Quitado'] = array(
			'0' => 'TODOS',
			'N' => 'Não Quitado',
            'S' => 'Quitado',
        );

		$data['select']['ConcluidoProduto'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['DevolvidoProduto'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
		
		$data['select']['ConcluidoServico'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => 'TODOS',
            'V' => 'Na Loja',
			'O' => 'On Line',
            'P' => 'Na Entrega',
        );
		
		$data['select']['Tipo_Orca'] = array(
            '0' => 'TODOS',
            'B' => 'Na Loja',
            'O' => 'On Line',
        );
		
		$data['select']['StatusComissaoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
		$data['select']['StatusComissaoOrca_Online'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
        $data['select']['Agrupar'] = array(
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Fornecedor' => 'Fornecedor',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			'1' => 'Último Pedido',
        );
		
        $data['select']['Campo'] = array(
			'OT.idApp_OrcaTrata' => 'id do Pedido',
			'OT.DataOrca' => 'Data do Pedido',
			'OT.DataEntregaOrca' => 'Data da Entrega',
			'F.idApp_Fornecedor' => 'id do Fornecedor',
			'F.NomeFornecedor' => 'Nome do Fornecedor',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );


		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();		
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		$data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresa();
		
		$data['query']['nome'] = 'Fornecedor';
        $data['titulo'] = 'Despesas';
		$data['form_open_path'] = 'relatorio/despesas';
		$data['baixatodas'] = 'Orcatrata/alterardespesas/';
		$data['baixa'] = 'Orcatrata/baixadadespesa/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio/alterardespesas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['print'] = 2;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistadesp/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirrecibodesp/';
		$data['edit'] = 'Orcatrata/alterardesp/';
		$data['alterarparc'] = 'Orcatrata/alterarparceladesp/';	
		$data['paginacao'] = 'N';		

        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['Produtos'] = $data['query']['Produtos'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		//$_SESSION['FiltroAlteraParcela']['NomeCliente'] = $data['query']['NomeCliente'];
		$_SESSION['FiltroAlteraParcela']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroAlteraParcela']['NomeAssociado'] = $data['query']['NomeAssociado'];
		$_SESSION['FiltroAlteraParcela']['NomeFornecedor'] = $data['query']['NomeFornecedor'];		
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroAlteraParcela']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroAlteraParcela']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroAlteraParcela']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroAlteraParcela']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroAlteraParcela']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroAlteraParcela']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroAlteraParcela']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroAlteraParcela']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
		$_SESSION['FiltroAlteraParcela']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
		//$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
		$_SESSION['FiltroAlteraParcela']['metodo'] = $data['metodo'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['TipoRD'];
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['FiltroAlteraParcela']['Ultimo'] = $data['query']['Ultimo'];
		$_SESSION['FiltroAlteraParcela']['nome'] = $data['query']['nome'];
		$_SESSION['Imprimir']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];		
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Vnc da Prc', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Vnc da Prc', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio5', 'Data Início do Pag Comissao', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio6', 'Data Início do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');		
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
            //$data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
            $data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['NomeAssociado'] = $data['query']['NomeAssociado'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$data['bd']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$data['bd']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
			$data['bd']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
			$data['bd']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
			$data['bd']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$data['bd']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
            $data['bd']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$data['bd']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
            $data['bd']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$data['bd']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
            $data['bd']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['Ultimo'] = $data['query']['Ultimo'];
			$data['bd']['nome'] = $data['query']['nome'];
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa']; 
			$data['bd']['metodo'] = $data['metodo'];
            $data['bd']['idTab_TipoRD'] = $data['TipoRD'];              
			
			//$data['report'] = $this->Relatorio_model->list1_comissao($data['bd'],TRUE);
			//$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE);
			$data['pesquisa_query'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			//$config['total_rows'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'relatorio_pag/despesas_pag/';

			//$this->load->library('pagination');
			$config['per_page'] = 50;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			
			$data['Pesquisa'] = '';
			
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            /*
              echo "<pre>";
              print_r($data['query']['Produtos']);
              echo "</pre>";
              exit();
              */

            //$data['list1'] = $this->load->view('relatorio/list1_comissao', $data, TRUE);
            $data['list1'] = $this->load->view('relatorio/list_orcamento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }		

        //$this->load->view('relatorio/tela_comissao', $data);
        $this->load->view('relatorio/tela_orcamento', $data);

        $this->load->view('basico/footer');

    }

	public function alterarreceitas() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'Orcamento',
			'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'idApp_OrcaTrata',
			'NomeAssociado',
			'idSis_Usuario',
			'DataVencimentoOrca',
			//'NomeCliente',
			'NomeUsuario',
			'NomeEmpresa',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'TipoFinanceiro',
			'idTab_TipoRD',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
			'CombinadoFrete',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'StatusComissaoOrca',
			'StatusComissaoOrca_Online',
			'Quitado',
			'Modalidade',
			'AVAP',
			'Tipo_Orca',
			'FormaPagamento',
			'TipoFrete',
			'Orcarec',
			'Orcades',
			'Produtos',
			'idTab_Catprod',
			'DataValidadeProduto',
			'ConcluidoProduto',
			'DevolvidoProduto',
			'ConcluidoServico',
			'Agrupar',
			'Ultimo',
			'nome',
        ), TRUE));

/*		   
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));
   
	   if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/

		
		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
		
        $data['select']['AprovadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['CombinadoFrete'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['FinalizadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CanceladoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['Quitado'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['DevolvidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['ConcluidoServico'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => 'TODOS',
            'V' => 'Na Loja',
			'O' => 'On Line',
            'P' => 'Na Entrega',
        );
		
		$data['select']['Tipo_Orca'] = array(
            '0' => 'TODOS',
            'B' => 'Na Loja',
            'O' => 'On Line',
        );
		
		$data['select']['StatusComissaoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
		$data['select']['StatusComissaoOrca_Online'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
        $data['select']['Agrupar'] = array(		
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Cliente' => 'Cliente',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			'1' => 'Último Pedido',
        );			

        $data['select']['Campo'] = array(
			'OT.idApp_OrcaTrata' => 'id do Pedido',
			'OT.DataOrca' => 'Data do Pedido',
			'OT.DataEntregaOrca' => 'Data da Entrega',
			'C.idApp_Cliente' => 'id do Cliente',
			'C.NomeCliente' => 'Nome do Cliente',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );


		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();		
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		$data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresa();
		
		$data['query']['nome'] = 'Cliente';
        $data['titulo'] = 'Baixa das Receitas';
		$data['form_open_path'] = 'relatorio/alterarreceitas';
		$data['baixatodas'] = 'Orcatrata/alterarreceitas/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio/alterarreceitas/';
		$data['editar'] = 1;
		$data['metodo'] = 3;
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['print'] = 2;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		
		$data['paginacao'] = 'N';
		
        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['Produtos'] = $data['query']['Produtos'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		//$_SESSION['FiltroAlteraParcela']['NomeCliente'] = $data['query']['NomeCliente'];
		$_SESSION['FiltroAlteraParcela']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroAlteraParcela']['NomeAssociado'] = $data['query']['NomeAssociado'];
		$_SESSION['FiltroAlteraParcela']['NomeFornecedor'] = $data['query']['NomeFornecedor'];		
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroAlteraParcela']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroAlteraParcela']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroAlteraParcela']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroAlteraParcela']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroAlteraParcela']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroAlteraParcela']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroAlteraParcela']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroAlteraParcela']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
		$_SESSION['FiltroAlteraParcela']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
		//$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
		$_SESSION['FiltroAlteraParcela']['nome'] = $data['query']['nome'];
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['FiltroAlteraParcela']['Ultimo'] = $data['query']['Ultimo'];
		$_SESSION['FiltroAlteraParcela']['metodo'] = $data['metodo'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['TipoRD'];
		
		$_SESSION['Imprimir']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Vnc da Prc', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Vnc da Prc', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio5', 'Data Início do Pag Comissao', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio6', 'Data Início do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
            //$data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
            $data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['NomeAssociado'] = $data['query']['NomeAssociado'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$data['bd']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$data['bd']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
			$data['bd']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
			$data['bd']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
			$data['bd']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$data['bd']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
            $data['bd']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$data['bd']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
            $data['bd']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$data['bd']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
            $data['bd']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['Ultimo'] = $data['query']['Ultimo'];
			$data['bd']['nome'] = $data['query']['nome'];
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			
			$data['bd']['metodo'] = $data['metodo'];
            $data['bd']['idTab_TipoRD'] = $data['TipoRD'];  
			
			//$data['report'] = $this->Relatorio_model->list1_comissao($data['bd'],TRUE);
			//$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE);
			
			$data['pesquisa_query'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			//$config['total_rows'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);
			
			//$this->load->library('pagination');
			$config['base_url'] = base_url() . 'relatorio_pag/alterarreceitas_pag/';
			$config['per_page'] = 50;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			
			$data['Pesquisa'] = '';
			
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            /*
              echo "<pre>";
              print_r($data['query']['Produtos']);
              echo "</pre>";
              exit();
              */

            $data['list1'] = $this->load->view('relatorio/list_orcamento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_orcamento', $data);

        $this->load->view('basico/footer');

    }

	public function alterardespesas() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Fornecedor_Auto',
			'NomeFornecedorAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'Orcamento',
			'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'idApp_OrcaTrata',
			'NomeAssociado',
			'idSis_Usuario',
			'DataVencimentoOrca',
			//'NomeCliente',
			'NomeUsuario',
			'NomeEmpresa',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'TipoFinanceiro',
			'idTab_TipoRD',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
			'CombinadoFrete',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'StatusComissaoOrca',
			'StatusComissaoOrca_Online',
			'Quitado',
			'Modalidade',
			'AVAP',
			'Tipo_Orca',
			'FormaPagamento',
			'TipoFrete',
			'Orcarec',
			'Orcades',
			'Produtos',
			'idTab_Catprod',
			'DataValidadeProduto',
			'ConcluidoProduto',
			'DevolvidoProduto',
			'ConcluidoServico',
			'Agrupar',
			'Ultimo',
			'nome',
        ), TRUE));

/*		   
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));
   
	   if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/
		
		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
		
        $data['select']['AprovadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['CombinadoFrete'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['FinalizadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CanceladoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['Quitado'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['DevolvidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['ConcluidoServico'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => 'TODOS',
            'V' => 'Na Loja',
			'O' => 'On Line',
            'P' => 'Na Entrega',
        );
		
		$data['select']['Tipo_Orca'] = array(
            '0' => 'TODOS',
            'B' => 'Na Loja',
            'O' => 'On Line',
        );
		
		$data['select']['StatusComissaoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
		$data['select']['StatusComissaoOrca_Online'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
        $data['select']['Agrupar'] = array(	
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Fornecedor' => 'Fornecedor',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			'1' => 'Último Pedido',
        );			

        $data['select']['Campo'] = array(
			'OT.idApp_OrcaTrata' => 'id do Pedido',
			'OT.DataOrca' => 'Data do Pedido',
			'OT.DataEntregaOrca' => 'Data da Entrega',
			'F.idApp_Fornecedor' => 'id do Fornecedor',
			'F.NomeFornecedor' => 'Nome do Fornecedor',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();		
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		$data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresa();
		
		$data['query']['nome'] = 'Fornecedor';
        $data['titulo'] = 'Baixa das Despesas';
		$data['form_open_path'] = 'relatorio/alterardespesas';
		$data['baixatodas'] = 'Orcatrata/alterardespesas/';
		$data['baixa'] = 'Orcatrata/baixadadespesa/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio/alterardespesas/';
		$data['editar'] = 1;
		$data['metodo'] = 3;
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['print'] = 2;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistadesp/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirrecibodesp/';
		$data['edit'] = 'Orcatrata/alterardesp/';
		$data['alterarparc'] = 'Orcatrata/alterarparceladesp/';
		
		$data['paginacao'] = 'N';
		
        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['Produtos'] = $data['query']['Produtos'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		//$_SESSION['FiltroAlteraParcela']['NomeCliente'] = $data['query']['NomeCliente'];
		$_SESSION['FiltroAlteraParcela']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroAlteraParcela']['NomeAssociado'] = $data['query']['NomeAssociado'];
		$_SESSION['FiltroAlteraParcela']['NomeFornecedor'] = $data['query']['NomeFornecedor'];		
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroAlteraParcela']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroAlteraParcela']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroAlteraParcela']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroAlteraParcela']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroAlteraParcela']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroAlteraParcela']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroAlteraParcela']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroAlteraParcela']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
		$_SESSION['FiltroAlteraParcela']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
		//$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
		$_SESSION['FiltroAlteraParcela']['nome'] = $data['query']['nome'];
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['FiltroAlteraParcela']['Ultimo'] = $data['query']['Ultimo'];
		$_SESSION['FiltroAlteraParcela']['metodo'] = $data['metodo'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['TipoRD'];
		$_SESSION['Imprimir']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];		
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Vnc da Prc', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Vnc da Prc', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio5', 'Data Início do Pag Comissao', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio6', 'Data Início do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
            //$data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
            $data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['NomeAssociado'] = $data['query']['NomeAssociado'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$data['bd']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$data['bd']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
			$data['bd']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
			$data['bd']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
			$data['bd']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$data['bd']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
            $data['bd']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$data['bd']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
            $data['bd']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$data['bd']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
            $data['bd']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['Ultimo'] = $data['query']['Ultimo'];
			$data['bd']['nome'] = $data['query']['nome'];
			$data['bd']['metodo'] = $data['metodo'];
			$data['bd']['idTab_TipoRD'] = $data['TipoRD'];
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			
			//$data['report'] = $this->Relatorio_model->list1_comissao($data['bd'],TRUE);
			//$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE);

			//$this->load->library('pagination');
						
			$data['pesquisa_query'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			
			//$config['total_rows'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);
			
			$config['base_url'] = base_url() . 'relatorio_pag/alterardespesas_pag/';
			$config['per_page'] = 50;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			
			$data['Pesquisa'] = '';
			
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();

            $data['list1'] = $this->load->view('relatorio/list_orcamento', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_orcamento', $data);

        $this->load->view('basico/footer');

    }

	public function comissao() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'Orcamento',
			'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'idApp_OrcaTrata',
			'NomeAssociado',
			'idSis_Usuario',
			'DataVencimentoOrca',
			//'NomeCliente',
			'NomeUsuario',
			'NomeEmpresa',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'TipoFinanceiro',
			'idTab_TipoRD',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
			'CombinadoFrete',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'StatusComissaoOrca',
			'StatusComissaoOrca_Online',
			'Quitado',
			'Modalidade',
			'AVAP',
			'Tipo_Orca',
			'FormaPagamento',
			'TipoFrete',
			'Orcarec',
			'Orcades',
			'Produtos',
			'idTab_Catprod',
			'DataValidadeProduto',
			'ConcluidoProduto',
			'DevolvidoProduto',
			'ConcluidoServico',
			'Agrupar',
			'Ultimo',
			'nome',
        ), TRUE));

/*		   
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));
   
	   if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/

		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
		
        $data['select']['AprovadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['CombinadoFrete'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['FinalizadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CanceladoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['Quitado'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['DevolvidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['ConcluidoServico'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => 'TODOS',
            'V' => 'Na Loja',
			'O' => 'On Line',
            'P' => 'Na Entrega',
        );
		
		$data['select']['Tipo_Orca'] = array(
            '0' => '::TODOS::',
            'B' => 'Na Loja',
            'O' => 'On Line',
        );
		
		$data['select']['StatusComissaoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
		$data['select']['StatusComissaoOrca_Online'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',			
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Cliente' => 'Cliente',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			'1' => 'Último Pedido',			
			'2' => 'Última Parcela',
        );	

        $data['select']['Campo'] = array(
			'OT.DataOrca' => 'Data do Pedido',
			'OT.DataEntregaOrca' => 'Data da Entrega',
			'OT.DataPagoComissaoOrca' => 'Data Pago Comissao',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		//$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['NomeUsuario'] = $this->Relatorio_model->select_usuario();
		//$data['select']['NomeAssociado'] = $this->Relatorio_model->select_usuario_associado();
		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();			
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		$data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresa();
		
		$data['query']['nome'] = 'Cliente';
		$data['form_open_path'] = 'relatorio/comissao';
		$data['baixatodas'] = 'Orcatrata/baixadacomissao/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
        $data['titulo'] = 'Comissão Colaborador';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['editar'] = 1;
		$data['metodo'] = 1;
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		if($_SESSION['Usuario']['Permissao_Comissao'] == 3){
			$data['print'] = 1;
		}else{
			$data['print'] = 0;
		}	
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimircomissao/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';
		$data['Associado'] = 0;
		$data['Vendedor'] = 1;
		
        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['Produtos'] = $data['query']['Produtos'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		//$_SESSION['FiltroAlteraParcela']['NomeCliente'] = $data['query']['NomeCliente'];
		$_SESSION['FiltroAlteraParcela']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroAlteraParcela']['NomeAssociado'] = $data['query']['NomeAssociado'];
		$_SESSION['FiltroAlteraParcela']['NomeFornecedor'] = $data['query']['NomeFornecedor'];		
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroAlteraParcela']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroAlteraParcela']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroAlteraParcela']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroAlteraParcela']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroAlteraParcela']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroAlteraParcela']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroAlteraParcela']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroAlteraParcela']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
		$_SESSION['FiltroAlteraParcela']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
		//$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
		$_SESSION['FiltroAlteraParcela']['nome'] = $data['query']['nome'];
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['FiltroAlteraParcela']['Ultimo'] = $data['query']['Ultimo'];
		$_SESSION['FiltroAlteraParcela']['metodo'] = $data['metodo'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['TipoRD'];
		$_SESSION['FiltroAlteraParcela']['Associado'] = $data['Associado'];
		$_SESSION['FiltroAlteraParcela']['Vendedor'] = $data['Vendedor'];
		$_SESSION['Imprimir']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];		
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Vnc da Prc', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Vnc da Prc', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio5', 'Data Início do Pag Comissao', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio6', 'Data Início do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            //$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
            //$data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
            $data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['NomeAssociado'] = $data['query']['NomeAssociado'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$data['bd']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$data['bd']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
			$data['bd']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
			$data['bd']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
			$data['bd']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$data['bd']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
            $data['bd']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$data['bd']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
            $data['bd']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$data['bd']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
            $data['bd']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['Ultimo'] = $data['query']['Ultimo'];
			$data['bd']['nome'] = $data['query']['nome'];
			$data['bd']['metodo'] = $data['metodo'];
            $data['bd']['idTab_TipoRD'] = $data['TipoRD'];
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['Associado'] = $data['Associado']; 
			$data['bd']['Vendedor'] = $data['Vendedor'];      
			
			//$data['report'] = $this->Relatorio_model->list1_comissao($data['bd'],TRUE);
			//$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE);
			$data['pesquisa_query'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			//$config['total_rows'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'relatorio_pag/comissao_pag/';
			//$this->load->library('pagination');
			$config['per_page'] = 50;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			
			$data['Pesquisa'] = '';
			
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();

            $data['list1'] = $this->load->view('relatorio/list_orcamento', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_orcamento', $data);

        $this->load->view('basico/footer');

    }

	public function comissao_online() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'Orcamento',
			'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'idApp_OrcaTrata',
			'NomeAssociado',
			'idSis_Usuario',
			'NomeEmpresa',
			'DataVencimentoOrca',
			//'NomeCliente',
			'NomeUsuario',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'TipoFinanceiro',
			'idTab_TipoRD',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
			'CombinadoFrete',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'StatusComissaoOrca',
			'StatusComissaoOrca_Online',
			'Quitado',
			'Modalidade',
			'AVAP',
			'Tipo_Orca',
			'FormaPagamento',
			'TipoFrete',
			'Orcarec',
			'Orcades',
			'Produtos',
			'idTab_Catprod',
			'DataValidadeProduto',
			'ConcluidoProduto',
			'DevolvidoProduto',
			'ConcluidoServico',
			'Agrupar',
			'Ultimo',
			'nome',
        ), TRUE));

/*		   
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));
   
	   if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/

		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
		
        $data['select']['AprovadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['CombinadoFrete'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['FinalizadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CanceladoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['Quitado'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['DevolvidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['ConcluidoServico'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => 'TODOS',
            'V' => 'Na Loja',
			'O' => 'On Line',
            'P' => 'Na Entrega',
        );
		
		$data['select']['Tipo_Orca'] = array(
			'0' => '::TODOS::',
			'B' => 'Na Loja',
			'O' => 'On Line',
        );
		
		$data['select']['StatusComissaoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
		$data['select']['StatusComissaoOrca_Online'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',			
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Cliente' => 'Cliente',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			'1' => 'Último Pedido',			
			'2' => 'Última Parcela',
        );	

        $data['select']['Campo'] = array(
			'OT.DataOrca' => 'Data do Pedido',
			'OT.DataEntregaOrca' => 'Data da Entrega',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeUsuario'] = $this->Relatorio_model->select_usuario();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();		
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		$data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresa();
		
		$data['query']['nome'] = 'Cliente';
		$data['form_open_path'] = 'relatorio/comissao_online';
		$data['baixatodas'] = 'Orcatrata/baixadacomissao_online/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
        $data['titulo'] = 'Comissão Associado';
        $data['nomeusuario'] = 'NomeAssociado';
        $data['status'] = 'StatusComissaoOrca_Online';
		$data['editar'] = 1;
		$data['metodo'] = 2;
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$data['print'] = 1;
		}else{
			if($_SESSION['Usuario']['Permissao_Comissao'] == 3){
				$data['print'] = 1;
			}else{
				$data['print'] = 0;
			}
		}	
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimircomissao_online/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';
		$data['Associado'] = 1;
		$data['Vendedor'] = 0;
		
        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['Produtos'] = $data['query']['Produtos'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		//$_SESSION['FiltroAlteraParcela']['NomeCliente'] = $data['query']['NomeCliente'];
		$_SESSION['FiltroAlteraParcela']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroAlteraParcela']['NomeAssociado'] = $data['query']['NomeAssociado'];
		$_SESSION['FiltroAlteraParcela']['NomeFornecedor'] = $data['query']['NomeFornecedor'];		
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroAlteraParcela']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroAlteraParcela']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroAlteraParcela']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroAlteraParcela']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroAlteraParcela']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroAlteraParcela']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroAlteraParcela']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroAlteraParcela']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
		$_SESSION['FiltroAlteraParcela']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
		$_SESSION['FiltroAlteraParcela']['nome'] = $data['query']['nome'];
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['FiltroAlteraParcela']['Ultimo'] = $data['query']['Ultimo'];
		$_SESSION['FiltroAlteraParcela']['metodo'] = $data['metodo'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['TipoRD'];
		$_SESSION['FiltroAlteraParcela']['Associado'] = $data['Associado'];
		$_SESSION['FiltroAlteraParcela']['Vendedor'] = $data['Vendedor'];
		$_SESSION['Imprimir']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];		
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Vnc da Prc', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Vnc da Prc', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio5', 'Data Início do Pag Comissao', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio6', 'Data Início do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            //$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
            //$data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
            $data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['NomeAssociado'] = $data['query']['NomeAssociado'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$data['bd']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$data['bd']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
			$data['bd']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
			$data['bd']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
			$data['bd']['StatusComissaoOrca_Online'] = $data['query']['StatusComissaoOrca_Online'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$data['bd']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
            $data['bd']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$data['bd']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
            $data['bd']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$data['bd']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
            $data['bd']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['Ultimo'] = $data['query']['Ultimo'];
			$data['bd']['nome'] = $data['query']['nome'];
			$data['bd']['metodo'] = $data['metodo'];
            $data['bd']['idTab_TipoRD'] = $data['TipoRD'];
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
            $data['bd']['Associado'] = $data['Associado'];
            $data['bd']['Vendedor'] = $data['Vendedor'];
			
			//$data['report'] = $this->Relatorio_model->list1_comissao($data['bd'],TRUE);
			//$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE);
			$data['pesquisa_query'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			//$config['total_rows'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'relatorio_pag/comissao_online_pag/';
			//$this->load->library('pagination');
			$config['per_page'] = 50;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			
			$data['Pesquisa'] = '';
			
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_orcamento($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();

            $data['list1'] = $this->load->view('relatorio/list_orcamento', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_orcamento', $data);

        $this->load->view('basico/footer');

    }

	public function cobrancas() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
            'Orcamento',
            'Cliente',
            'idApp_Cliente',
			'Fornecedor',
            'idApp_Fornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'idTab_TipoRD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'CombinadoFrete',
			'Quitado',
			'Modalidade',
			'Orcarec',
			'Orcades',
			'FormaPagamento',
			'TipoFrete',
			'Agrupar',
			'Ultimo',
			'nome',
        ), TRUE));
		
		/*
		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = date("d/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		
		if (!$data['query']['DataFim2'])
           $data['query']['DataFim2'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
					
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));
		
		if (!$data['query']['DataFim'])
          $data['query']['DataFim'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
   
	   if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
		*/


		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
        $data['select']['AprovadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['FinalizadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CanceladoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CombinadoFrete'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['Quitado'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => '::TODOS::',
            'P' => 'Dividido',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => '::TODOS::',
            'V' => 'Na Loja',
            'O' => 'On Line',
            'P' => 'Na Entrega',
        );

        $data['select']['Tipo_Orca'] = array(
			'0' => '::TODOS::',			
			'B' => 'Na Loja',
			'O' => 'On line',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',			
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Cliente' => 'Cliente',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			'1' => 'Último Pedido',			
			'2' => 'Última Parcela',
        );

		if($_SESSION['log']['idSis_Empresa'] != 5){
			$data['select']['Campo'] = array(
				'OT.idApp_OrcaTrata' => 'id do Orçamento',
				'OT.DataOrca' => 'Data do Orcamento',
				'OT.DataEntregaOrca' => 'Data da Entrega',
				'PR.Quitado' => 'Parc.Quit.',
				'PR.DataVencimento' => 'Data do Venc.',
				'OT.Modalidade' => 'Modalidade',
				'OT.ValorOrca' => 'Valor',
				'OT.TipoFinanceiro' => 'Tipo',
				'OT.Tipo_Orca' => 'Compra',
				'OT.TipoFrete' => 'Entrega',
				'C.idApp_Cliente' => 'id do Cliente',
				'C.NomeCliente' => 'Nome do Cliente',	
				
			);
		}else{
			$data['select']['Campo'] = array(
				'OT.idApp_OrcaTrata' => 'id do Orçamento',
				'OT.DataOrca' => 'Data do Orcamento',
				'OT.DataEntregaOrca' => 'Data da Entrega',
				'PR.Quitado' => 'Parc.Quit.',
				'PR.DataVencimento' => 'Data do Venc.',
				'OT.Modalidade' => 'Modalidade',
				'OT.ValorOrca' => 'Valor',
				'OT.TipoFinanceiro' => 'Tipo',
				'OT.Tipo_Orca' => 'Compra',
				'OT.TipoFrete' => 'Entrega',
			);		
		}
		
        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		
		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Parcelas das Receitas';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/cobrancas';
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'Orcatrata/baixadaparcelarec/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';	
		$data['paginacao'] = 'N';	

        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');		
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroAlteraParcela']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroAlteraParcela']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroAlteraParcela']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroAlteraParcela']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroAlteraParcela']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroAlteraParcela']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroAlteraParcela']['TipoFrete'] = $data['query']['TipoFrete'];
		//$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['metodo'] = $data['metodo'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['TipoRD'];
		$_SESSION['FiltroAlteraParcela']['nome'] = $data['query']['nome'];
		$_SESSION['FiltroAlteraParcela']['Ultimo'] = $data['query']['Ultimo'];
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];
        $_SESSION['FiltroAlteraParcela']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroAlteraParcela']['ObsOrca'] = $data['query']['ObsOrca'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Vnc da Prc', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Vnc da Prc', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio5', 'Data Início do Pag Comissao', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio6', 'Data Início do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
            //$data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$data['bd']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
            $data['bd']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$data['bd']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
            $data['bd']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$data['bd']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
            $data['bd']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['Ultimo'] = $data['query']['Ultimo'];
			$data['bd']['nome'] = $data['query']['nome'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$data['bd']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
            $data['bd']['metodo'] = $data['metodo'];
            $data['bd']['idTab_TipoRD'] = $data['TipoRD'];
			
			#$data['report'] = $this->Relatorio_model->list_parcelas($data['bd'],TRUE);

			//$this->load->library('pagination');
			$config['per_page'] = 12;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';
			
			$config['base_url'] = base_url() . 'relatorio_pag/cobrancas_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_parcelas($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_parcelas($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();

            $data['list1'] = $this->load->view('relatorio/list_parcelas', $data, TRUE);
        }

        $this->load->view('relatorio/tela_parcelas', $data);

        $this->load->view('basico/footer');

    }

	public function debitos() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Fornecedor_Auto',
			'NomeFornecedorAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
            'Orcamento',
            'Cliente',
            'idApp_Cliente',
			'Fornecedor',
            'idApp_Fornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'idTab_TipoRD',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'CombinadoFrete',
			'Quitado',
			'Modalidade',
			'Orcarec',
			'Orcades',
			'FormaPagamento',
			'TipoFrete',
			'Agrupar',
			'Ultimo',
			'nome',
        ), TRUE));
/*
		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = date("d/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		
		if (!$data['query']['DataFim2'])
           $data['query']['DataFim2'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
					
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));
		
		if (!$data['query']['DataFim'])
          $data['query']['DataFim'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
   
	   if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/

		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
        $data['select']['AprovadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['FinalizadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CanceladoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CombinadoFrete'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['Quitado'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => '::TODOS::',
            'P' => 'Dividido',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => '::TODOS::',
            'V' => 'Na Loja',
            'O' => 'On Line',
            'P' => 'Na Entrega',
        );

        $data['select']['Tipo_Orca'] = array(
			'0' => '::TODOS::',			
			'B' => 'Na Loja',
			'O' => 'On line',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',			
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Fornecedor' => 'Fornecedor',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			'1' => 'Último Pedido',			
			'2' => 'Última Parcela',
        );
		
		if($_SESSION['log']['idSis_Empresa'] != 5){
			$data['select']['Campo'] = array(
				'OT.idApp_OrcaTrata' => 'id do Orcamento',
				'OT.DataOrca' => 'Data do Orcamento',
				'OT.DataEntregaOrca' => 'Data da Entrega',
				'PR.DataVencimento' => 'Data do Venc.',
				'PR.Quitado' => 'Parc.Quit.',
				'OT.Modalidade' => 'Modalidade',
				'OT.ValorOrca' => 'Valor',
				'OT.TipoFinanceiro' => 'Tipo',
				'OT.Tipo_Orca' => 'Compra',
				'OT.TipoFrete' => 'Entrega',
				'F.idApp_Fornecedor' => 'id do Fornecedor',
				'F.NomeFornecedor' => 'Nome do Fornecedor',	
			);
		}else{
			$data['select']['Campo'] = array(
				'OT.idApp_OrcaTrata' => 'id do Orcamento',
				'OT.DataOrca' => 'Data do Orcamento',
				'OT.DataEntregaOrca' => 'Data da Entrega',
				'PR.DataVencimento' => 'Data do Venc.',
				'PR.Quitado' => 'Parc.Quit.',
				'OT.Modalidade' => 'Modalidade',
				'OT.ValorOrca' => 'Valor',
				'OT.TipoFinanceiro' => 'Tipo',
				'OT.Tipo_Orca' => 'Compra',
				'OT.TipoFrete' => 'Entrega',
			);
		
		}
		
		
        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );


		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		
		$data['query']['nome'] = 'Fornecedor';
        $data['titulo1'] = 'Parcelas das Despesas';
		$data['metodo'] = 1;
		$data['form_open_path'] = 'relatorio/debitos';
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistadesp/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirrecibodesp/';
		$data['edit'] = 'Orcatrata/baixadaparceladesp/';
		$data['alterarparc'] = 'Orcatrata/alterarparceladesp/';	
		$data['paginacao'] = 'N';
		
        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');		
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroAlteraParcela']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroAlteraParcela']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroAlteraParcela']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroAlteraParcela']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroAlteraParcela']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroAlteraParcela']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroAlteraParcela']['TipoFrete'] = $data['query']['TipoFrete'];
		//$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['metodo'] = $data['metodo'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['TipoRD'];
		$_SESSION['FiltroAlteraParcela']['nome'] = $data['query']['nome'];
		$_SESSION['FiltroAlteraParcela']['Ultimo'] = $data['query']['Ultimo'];
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];
        $_SESSION['FiltroAlteraParcela']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroAlteraParcela']['ObsOrca'] = $data['query']['ObsOrca'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Vnc da Prc', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Vnc da Prc', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio5', 'Data Início do Pag Comissao', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio6', 'Data Início do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
            //$data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$data['bd']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
            $data['bd']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$data['bd']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
            $data['bd']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$data['bd']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
            $data['bd']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['Ultimo'] = $data['query']['Ultimo'];
			$data['bd']['nome'] = $data['query']['nome'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$data['bd']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
            $data['bd']['metodo'] = $data['metodo'];
            $data['bd']['idTab_TipoRD'] = $data['TipoRD'];
			
			//$data['report'] = $this->Relatorio_model->list1_cobrancas($data['bd'],TRUE);
			//$data['report'] = $this->Relatorio_model->list_parcelas($data['bd'],TRUE);

			//$this->load->library('pagination');
			$config['per_page'] = 12;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';
			
			$config['base_url'] = base_url() . 'relatorio_pag/debitos_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_parcelas($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_parcelas($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();

            /*
              echo "<pre>";
              print_r($_SESSION['FiltroAlteraParcela']['DataFim']);
              echo "</pre>";
              exit();
             */ 

            //$data['list1'] = $this->load->view('relatorio/list1_cobrancas', $data, TRUE);
            $data['list1'] = $this->load->view('relatorio/list_parcelas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        //$this->load->view('relatorio/tela_cobrancas', $data);
        $this->load->view('relatorio/tela_parcelas', $data);

        $this->load->view('basico/footer');

    }

	public function vendidos() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
            'Orcamento',
            'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'Produtos',
			'Categoria',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'idTab_TipoRD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'DataInicio8',
            'DataFim8',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'CombinadoFrete',
			'Quitado',
			'ConcluidoProduto',
			'Modalidade',
			'Orcarec',
			'Orcades',
			'FormaPagamento',
			'TipoFrete',
			'Agrupar',
			'Ultimo',
			'nome',
        ), TRUE));
/*
		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = date("d/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		
		if (!$data['query']['DataFim2'])
           $data['query']['DataFim2'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
					
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));
		
		if (!$data['query']['DataFim'])
          $data['query']['DataFim'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
   
	   if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/
		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
        $data['select']['AprovadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['FinalizadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CanceladoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CombinadoFrete'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['Quitado'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => '::TODOS::',
            'P' => 'Dividido',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => '::TODOS::',
            'V' => 'Na Loja',
            'O' => 'On Line',
            'P' => 'Na Entrega',
        );

        $data['select']['Tipo_Orca'] = array(
			'0' => '::TODOS::',			
			'B' => 'Na Loja',
			'O' => 'On line',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',			
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Cliente' => 'Cliente',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			'1' => 'Último Pedido',			
			'2' => 'Última Parcela',
        );

		$data['select']['Campo'] = array(
			'OT.DataOrca' => 'Data do Pedido',
			'OT.DataEntregaOrca' => 'Data da Entrega',
			'PR.DataVencimento' => 'Data do Venc.',
			'PR.Quitado' => 'Parc.Quit.',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrata' => 'Orçamento',
            'OT.ValorOrca' => 'Valor',
			'OT.TipoFinanceiro' => 'Tipo',
			'OT.Tipo_Orca' => 'Compra',
			'OT.TipoFrete' => 'Entrega',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Categoria'] = $this->Relatorio_model->select_catprod();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		
		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Vendidos';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/vendidos';
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 2;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'Orcatrata/baixadaparcelarec/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';

        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');	
        $_SESSION['FiltroAlteraParcela']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio8'] = $this->basico->mascara_data($data['query']['DataInicio8'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim8'] = $this->basico->mascara_data($data['query']['DataFim8'], 'mysql');	
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroAlteraParcela']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroAlteraParcela']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroAlteraParcela']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroAlteraParcela']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroAlteraParcela']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroAlteraParcela']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroAlteraParcela']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroAlteraParcela']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['Produtos'] = $data['query']['Produtos'];
		$_SESSION['FiltroAlteraParcela']['Categoria'] = $data['query']['Categoria'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Vnc da Prc', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Vnc da Prc', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio5', 'Data Início do Pag Comissao', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio6', 'Data Início do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio8', 'Data Início Entregue Prod', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim8', 'Data Fim Entregue Prod', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
            $data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$data['bd']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
            $data['bd']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$data['bd']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
            $data['bd']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$data['bd']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
            $data['bd']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$data['bd']['DataInicio8'] = $this->basico->mascara_data($data['query']['DataInicio8'], 'mysql');
            $data['bd']['DataFim8'] = $this->basico->mascara_data($data['query']['DataFim8'], 'mysql');
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['Ultimo'] = $data['query']['Ultimo'];
			$data['bd']['nome'] = $data['query']['nome'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$data['bd']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			
			$data['report'] = $this->Relatorio_model->list_produtoseservicos($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($_SESSION['FiltroAlteraParcela']['DataFim']);
              echo "</pre>";
              exit();
             */ 

            $data['list1'] = $this->load->view('relatorio/list_produtoseservicos', $data, TRUE);
        }

        $this->load->view('relatorio/tela_produtoseservicos', $data);

        $this->load->view('basico/footer');

    }

	public function comprados() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Fornecedor_Auto',
			'NomeFornecedorAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
            'Orcamento',
            'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'Produtos',
			'Categoria',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'idTab_TipoRD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'DataInicio8',
            'DataFim8',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'CombinadoFrete',
			'Quitado',
			'ConcluidoProduto',
			'Modalidade',
			'Orcarec',
			'Orcades',
			'FormaPagamento',
			'TipoFrete',
			'Agrupar',
			'Ultimo',
			'nome',
        ), TRUE));
/*
		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = date("d/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		
		if (!$data['query']['DataFim2'])
           $data['query']['DataFim2'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
					
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = date("d/m/Y", mktime(0,0,0,date('m'),date('d'),date('Y')));
		
		if (!$data['query']['DataFim'])
          $data['query']['DataFim'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
   
	   if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/
		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
        $data['select']['AprovadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['FinalizadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CanceladoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['CombinadoFrete'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['Quitado'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );

		$data['select']['ConcluidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => '::TODOS::',
            'P' => 'Dividido',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => '::TODOS::',
            'V' => 'Na Loja',
            'O' => 'On Line',
            'P' => 'Na Entrega',
        );

        $data['select']['Tipo_Orca'] = array(
			'0' => '::TODOS::',			
			'B' => 'Na Loja',
			'O' => 'On line',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',			
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Fornecedor' => 'Fornecedor',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			'1' => 'Último Pedido',			
			'2' => 'Última Parcela',
        );	

		$data['select']['Campo'] = array(
			'OT.DataOrca' => 'Data do Pedido',
			'OT.DataEntregaOrca' => 'Data da Entrega',
			'PR.DataVencimento' => 'Data do Venc.',
			'PR.Quitado' => 'Parc.Quit.',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrata' => 'Orçamento',
            'OT.ValorOrca' => 'Valor',
			'OT.TipoFinanceiro' => 'Tipo',
			'OT.Tipo_Orca' => 'Compra',
			'OT.TipoFrete' => 'Entrega',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Categoria'] = $this->Relatorio_model->select_catprod();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		
		$data['query']['nome'] = 'Fornecedor';
        $data['titulo1'] = 'Comprados';
		$data['metodo'] = 1;
		$data['form_open_path'] = 'relatorio/comprados';
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['editar'] = 2;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistadesp/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirrecibodesp/';
		$data['edit'] = 'Orcatrata/baixadaparceladesp/';
		$data['alterarparc'] = 'Orcatrata/alterarparceladesp/';

        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio8'] = $this->basico->mascara_data($data['query']['DataInicio8'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim8'] = $this->basico->mascara_data($data['query']['DataFim8'], 'mysql');		
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroAlteraParcela']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroAlteraParcela']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroAlteraParcela']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroAlteraParcela']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroAlteraParcela']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroAlteraParcela']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroAlteraParcela']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroAlteraParcela']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['Produtos'] = $data['query']['Produtos'];
		$_SESSION['FiltroAlteraParcela']['Categoria'] = $data['query']['Categoria'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Vnc da Prc', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Vnc da Prc', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio5', 'Data Início do Pag Comissao', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio6', 'Data Início do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio8', 'Data Início Entregue Prod', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim8', 'Data Fim Entregue Prod', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
            $data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$data['bd']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
            $data['bd']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$data['bd']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
            $data['bd']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$data['bd']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
            $data['bd']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$data['bd']['DataInicio8'] = $this->basico->mascara_data($data['query']['DataInicio8'], 'mysql');
            $data['bd']['DataFim8'] = $this->basico->mascara_data($data['query']['DataFim8'], 'mysql');
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['Ultimo'] = $data['query']['Ultimo'];
			$data['bd']['nome'] = $data['query']['nome'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$data['bd']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			
			$data['report'] = $this->Relatorio_model->list_produtoseservicos($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($_SESSION['FiltroAlteraParcela']['DataFim']);
              echo "</pre>";
              exit();
             */ 

            $data['list1'] = $this->load->view('relatorio/list_produtoseservicos', $data, TRUE);
        }

        $this->load->view('relatorio/tela_produtoseservicos', $data);

        $this->load->view('basico/footer');

    }

    public function proc_receitas() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Procedimento',
            'Sac',
            'Marketing',
            'Orcamento',
			'idTab_TipoRD',
            'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'NomeUsuario',
			'Compartilhar',
			'DataInicio9',
            'DataFim9',
			'DataInicio10',
            'DataFim10',
			'HoraInicio9',
            'HoraFim9',
			'HoraInicio10',
            'HoraFim10',			
			'Dia',
			'Mesvenc',
			'Ano',
			'ConcluidoProcedimento',
            'Ordenamento',
            'Campo',
            'TipoProcedimento',
			'Agrupar',
        ), TRUE));		

        $data['select']['ConcluidoProcedimento'] = array(
			'#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Sac'] = array (
            '0' => 'Todos',
            '1' => 'Solicitação',
            '2' => 'Elogio',
			'3' => 'Reclamação',
        );
		
		$data['select']['Marketing'] = array (
            '0' => 'Todos',
            '1' => 'Atualização',
            '2' => 'Pesquisa',
			'3' => 'Retorno',
            '4' => 'Promoções',
			'5' => 'Felicitações',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',
			'idApp_Procedimento' => 'Procedimento',
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Cliente' => 'Cliente',
        );
		
		$data['select']['Campo'] = array(
			'PRC.DataProcedimento' => 'Data',
            'PRC.idApp_Procedimento' => 'id',
			'PRC.ConcluidoProcedimento' => 'Concl.',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        $data['select']['NomeUsuario'] = $this->Relatorio_model->select_usuario();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Compartilhar'] = $this->Relatorio_model->select_compartilhar();

		$data['query']['TipoProcedimento'] = 2;
		$data['query']['Sac'] = 0;
		$data['query']['Marketing'] = 0;
        $data['titulo1'] = 'Receita';
		$data['tipoproc'] = 2;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/proc_receitas';
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 0;
		$data['print'] = 0;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'Orcatrata/baixadaparcelarec/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';

        $_SESSION['FiltroAlteraParcela']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['HoraInicio9'] = $data['query']['HoraInicio9'];
		$_SESSION['FiltroAlteraParcela']['HoraFim9'] = $data['query']['HoraFim9'];
        $_SESSION['FiltroAlteraParcela']['HoraInicio10'] = $data['query']['HoraInicio10'];
		$_SESSION['FiltroAlteraParcela']['HoraFim10'] = $data['query']['HoraFim10'];
		$_SESSION['FiltroAlteraParcela']['idApp_Procedimento'] = $data['query']['idApp_Procedimento'];
		$_SESSION['FiltroAlteraParcela']['Sac'] = $data['query']['Sac'];
		$_SESSION['FiltroAlteraParcela']['Marketing'] = $data['query']['Marketing'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroAlteraParcela']['TipoProcedimento'] = $data['query']['TipoProcedimento'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];	
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];	
		$_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
		$_SESSION['FiltroAlteraParcela']['Compartilhar'] = $data['query']['Compartilhar'];	
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];	
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		$this->form_validation->set_rules('DataInicio9', 'Data Início do Procedimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim9', 'Data Fim do Procedimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio10', 'Data Início do SubProcedimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim10', 'Data Fim do SubProcedimento', 'trim|valid_date');
		$this->form_validation->set_rules('HoraInicio9', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim9', 'Hora Final', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraInicio10', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim10', 'Hora Final', 'trim|valid_hour');

        #run form validation
        if ($this->form_validation->run() !== FALSE) {
            
			$data['bd']['idApp_Procedimento'] = $data['query']['idApp_Procedimento'];
			$data['bd']['Sac'] = $data['query']['Sac'];
			$data['bd']['Marketing'] = $data['query']['Marketing'];
			$data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['Compartilhar'] = $data['query']['Compartilhar'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['TipoProcedimento'] = $data['query']['TipoProcedimento'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
            $data['bd']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
			$data['bd']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
            $data['bd']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
			$data['bd']['HoraInicio9'] = $this->basico->mascara_data($data['query']['HoraInicio9'], 'mysql');
            $data['bd']['HoraFim9'] = $this->basico->mascara_data($data['query']['HoraFim9'], 'mysql');
			$data['bd']['HoraInicio10'] = $this->basico->mascara_data($data['query']['HoraInicio10'], 'mysql');
            $data['bd']['HoraFim10'] = $this->basico->mascara_data($data['query']['HoraFim10'], 'mysql');

			//$this->load->library('pagination');
			$config['per_page'] = 10;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';
			
			$config['base_url'] = base_url() . 'relatorio_pag/proc_receitas_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_procedimentos($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_procedimentos($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('relatorio/list_procedimentos', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_procedimentos', $data);

        $this->load->view('basico/footer');

    }

    public function proc_despesas() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Fornecedor_Auto',
			'NomeFornecedorAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Procedimento',
            'Sac',
            'Marketing',
            'Orcamento',
			'idTab_TipoRD',
            'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'NomeUsuario',
			'Compartilhar',
			'DataInicio9',
            'DataFim9',
			'DataInicio10',
            'DataFim10',
			'HoraInicio9',
            'HoraFim9',
			'HoraInicio10',
            'HoraFim10',			
			'Dia',
			'Mesvenc',
			'Ano',
			'ConcluidoProcedimento',
            'Ordenamento',
            'Campo',
            'TipoProcedimento',
			'Agrupar',
        ), TRUE));			

        $data['select']['ConcluidoProcedimento'] = array(
			'#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Sac'] = array (
            '0' => 'Todos',
            '1' => 'Solicitação',
            '2' => 'Elogio',
			'3' => 'Reclamação',
        );
		
		$data['select']['Marketing'] = array (
            '0' => 'Todos',
            '1' => 'Atualização',
            '2' => 'Pesquisa',
			'3' => 'Retorno',
            '4' => 'Promoções',
			'5' => 'Felicitações',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',
			'idApp_Procedimento' => 'Procedimento',
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Fornecedor' => 'Fornecedor',
        );

		$data['select']['Campo'] = array(
			'PRC.DataProcedimento' => 'Data',
            'PRC.idApp_Procedimento' => 'id',
			'PRC.ConcluidoProcedimento' => 'Concl.',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        $data['select']['NomeUsuario'] = $this->Relatorio_model->select_usuario();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Compartilhar'] = $this->Relatorio_model->select_compartilhar();

		$data['query']['TipoProcedimento'] = 1;
		$data['query']['Sac'] = 0;
		$data['query']['Marketing'] = 0;
        $data['titulo1'] = 'Despesa';
		$data['tipoproc'] = 1;
		$data['metodo'] = 1;
		$data['form_open_path'] = 'relatorio/proc_despesas';
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['editar'] = 0;
		$data['print'] = 0;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'Orcatrata/baixadaparcelarec/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';
		
        $_SESSION['FiltroAlteraParcela']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['HoraInicio9'] = $data['query']['HoraInicio9'];
		$_SESSION['FiltroAlteraParcela']['HoraFim9'] = $data['query']['HoraFim9'];
        $_SESSION['FiltroAlteraParcela']['HoraInicio10'] = $data['query']['HoraInicio10'];
		$_SESSION['FiltroAlteraParcela']['HoraFim10'] = $data['query']['HoraFim10'];
		$_SESSION['FiltroAlteraParcela']['idApp_Procedimento'] = $data['query']['idApp_Procedimento'];
		$_SESSION['FiltroAlteraParcela']['Sac'] = $data['query']['Sac'];
		$_SESSION['FiltroAlteraParcela']['Marketing'] = $data['query']['Marketing'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroAlteraParcela']['TipoProcedimento'] = $data['query']['TipoProcedimento'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];	
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];	
		$_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
		$_SESSION['FiltroAlteraParcela']['Compartilhar'] = $data['query']['Compartilhar'];	
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];		
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		$this->form_validation->set_rules('DataInicio9', 'Data Início do Procedimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim9', 'Data Fim do Procedimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio10', 'Data Início do SubProcedimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim10', 'Data Fim do SubProcedimento', 'trim|valid_date');
		$this->form_validation->set_rules('HoraInicio9', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim9', 'Hora Final', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraInicio10', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim10', 'Hora Final', 'trim|valid_hour');

        #run form validation
        if ($this->form_validation->run() !== FALSE) {
            
			$data['bd']['idApp_Procedimento'] = $data['query']['idApp_Procedimento'];
			$data['bd']['Sac'] = $data['query']['Sac'];
			$data['bd']['Marketing'] = $data['query']['Marketing'];
			$data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['Compartilhar'] = $data['query']['Compartilhar'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['TipoProcedimento'] = $data['query']['TipoProcedimento'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
            $data['bd']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
			$data['bd']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
            $data['bd']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
			$data['bd']['HoraInicio9'] = $this->basico->mascara_data($data['query']['HoraInicio9'], 'mysql');
            $data['bd']['HoraFim9'] = $this->basico->mascara_data($data['query']['HoraFim9'], 'mysql');
			$data['bd']['HoraInicio10'] = $this->basico->mascara_data($data['query']['HoraInicio10'], 'mysql');
            $data['bd']['HoraFim10'] = $this->basico->mascara_data($data['query']['HoraFim10'], 'mysql');

			//$this->load->library('pagination');
			$config['per_page'] = 10;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';
			
			$config['base_url'] = base_url() . 'relatorio_pag/proc_despesas_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_procedimentos($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_procedimentos($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_procedimentos', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_procedimentos', $data);

        $this->load->view('basico/footer');

    }

    public function proc_Sac() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Procedimento',
            'Sac',
            'Marketing',
            'Orcamento',
			'idTab_TipoRD',
            'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'NomeUsuario',
			'Compartilhar',
			'DataInicio9',
            'DataFim9',
			'DataInicio10',
            'DataFim10',
			'HoraInicio9',
            'HoraFim9',
			'HoraInicio10',
            'HoraFim10',
			'Dia',
			'Mesvenc',
			'Ano',
			'ConcluidoProcedimento',
            'Ordenamento',
            'Campo',
            'TipoProcedimento',
			'Agrupar',
        ), TRUE));		

        $data['select']['ConcluidoProcedimento'] = array(
			'#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Sac'] = array (
            '0' => 'Todos',
            '1' => 'Solicitação',
            '2' => 'Elogio',
			'3' => 'Reclamação',
        );
		
		$data['select']['Marketing'] = array (
            '0' => 'Todos',
            '1' => 'Atualização',
            '2' => 'Pesquisa',
			'3' => 'Retorno',
            '4' => 'Promoções',
			'5' => 'Felicitações',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',
			'idApp_Procedimento' => 'Chamada',
			'idApp_Cliente' => 'Cliente',
        );
		
		$data['select']['Campo'] = array(
			'PRC.DataProcedimento' => 'Data',
            'PRC.idApp_Procedimento' => 'id',
			'PRC.ConcluidoProcedimento' => 'Concl.',
			'PRC.idSis_Usuario' => 'Quem Cadastrou',
			'PRC.Compartilhar' => 'Quem Fazer',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        $data['select']['NomeUsuario'] = $this->Relatorio_model->select_usuario();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Compartilhar'] = $this->Relatorio_model->select_compartilhar();
		
		$data['query']['TipoProcedimento'] = 3;
		$data['query']['Marketing'] = 0;
		$data['query']['Fornecedor'] = 0;		
        $data['titulo1'] = 'Sac';
		$data['tipoproc'] = 3;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/proc_Sac';
		$data['panel'] = 'warning';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 0;
        $data['nome'] = 'Cliente';
		$data['editar'] = 0;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Procedimento/imprimir_lista_Sac/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'Orcatrata/baixadaparcelarec/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';

		$_SESSION['FiltroAlteraParcela']['idApp_Procedimento'] = $data['query']['idApp_Procedimento'];
		$_SESSION['FiltroAlteraParcela']['Sac'] = $data['query']['Sac'];
		$_SESSION['FiltroAlteraParcela']['Marketing'] = $data['query']['Marketing'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroAlteraParcela']['Compartilhar'] = $data['query']['Compartilhar'];
		$_SESSION['FiltroAlteraParcela']['TipoProcedimento'] = $data['query']['TipoProcedimento'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
        $_SESSION['FiltroAlteraParcela']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['HoraInicio9'] = $data['query']['HoraInicio9'];
		$_SESSION['FiltroAlteraParcela']['HoraFim9'] = $data['query']['HoraFim9'];
        $_SESSION['FiltroAlteraParcela']['HoraInicio10'] = $data['query']['HoraInicio10'];
		$_SESSION['FiltroAlteraParcela']['HoraFim10'] = $data['query']['HoraFim10'];
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
		$_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
		$_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];			
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		$this->form_validation->set_rules('DataInicio9', 'Data Início do Procedimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim9', 'Data Fim do Procedimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio10', 'Data Início do SubProcedimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim10', 'Data Fim do SubProcedimento', 'trim|valid_date');
		$this->form_validation->set_rules('HoraInicio9', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim9', 'Hora Final', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraInicio10', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim10', 'Hora Final', 'trim|valid_hour');

        #run form validation
        if ($this->form_validation->run() !== FALSE) {
            
			$data['bd']['idApp_Procedimento'] = $data['query']['idApp_Procedimento'];
			$data['bd']['Sac'] = $data['query']['Sac'];
			$data['bd']['Marketing'] = $data['query']['Marketing'];
			$data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['Compartilhar'] = $data['query']['Compartilhar'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['TipoProcedimento'] = $data['query']['TipoProcedimento'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
            $data['bd']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
			$data['bd']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
            $data['bd']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
			$data['bd']['HoraInicio9'] = $this->basico->mascara_data($data['query']['HoraInicio9'], 'mysql');
            $data['bd']['HoraFim9'] = $this->basico->mascara_data($data['query']['HoraFim9'], 'mysql');
			$data['bd']['HoraInicio10'] = $this->basico->mascara_data($data['query']['HoraInicio10'], 'mysql');
            $data['bd']['HoraFim10'] = $this->basico->mascara_data($data['query']['HoraFim10'], 'mysql');

            //$data['report'] = $this->Relatorio_model->list_procedimentos($data['bd'],TRUE);

			//$this->load->library('pagination');
			$config['per_page'] = 10;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';
			
			$config['base_url'] = base_url() . 'relatorio_pag/proc_Sac_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_procedimentos($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_procedimentos($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('relatorio/list_procedimentos', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_procedimentos', $data);

        $this->load->view('basico/footer');

    }

    public function proc_Marketing() {
		
		unset($_SESSION['FiltroAlteraParcela']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Procedimento',
            'Sac',
            'Marketing',
            'Orcamento',
			'idTab_TipoRD',
            'Cliente',
			'idApp_Cliente',
			'Fornecedor',
			'idApp_Fornecedor',
			'NomeUsuario',
			'Compartilhar',
			'DataInicio9',
            'DataFim9',
			'DataInicio10',
            'DataFim10',
			'HoraInicio9',
            'HoraFim9',
			'HoraInicio10',
            'HoraFim10',			
			'Dia',
			'Mesvenc',
			'Ano',
			'ConcluidoProcedimento',
            'Ordenamento',
            'Campo',
            'TipoProcedimento',
			'Agrupar',
        ), TRUE));		

        $data['select']['ConcluidoProcedimento'] = array(
			'#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Sac'] = array (
            '0' => 'Todos',
            '1' => 'Solicitação',
            '2' => 'Elogio',
			'3' => 'Reclamação',
        );
		
		$data['select']['Marketing'] = array (
            '0' => 'Todos',
            '1' => 'Atualização',
            '2' => 'Pesquisa',
			'3' => 'Retorno',
            '4' => 'Promoções',
			'5' => 'Felicitações',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',
			'idApp_Procedimento' => 'Campanha',
			'idApp_Cliente' => 'Cliente',
        );
		
		$data['select']['Campo'] = array(
			'PRC.DataProcedimento' => 'Data',
            'PRC.idApp_Procedimento' => 'id',
			'PRC.ConcluidoProcedimento' => 'Concl.',
			'PRC.idSis_Usuario' => 'Quem Cadastrou',
			'PRC.Compartilhar' => 'Quem Fazer',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        $data['select']['NomeUsuario'] = $this->Relatorio_model->select_usuario();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Compartilhar'] = $this->Relatorio_model->select_compartilhar();

		$data['query']['TipoProcedimento'] = 4;
		$data['query']['Sac'] = 0;
		$data['query']['Fornecedor'] = 0;		
        $data['titulo1'] = 'Marketing';
		$data['tipoproc'] = 4;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/proc_Marketing';
		$data['panel'] = 'success';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 0;
        $data['nome'] = 'Cliente';
		$data['editar'] = 0;
		$data['print'] = 1;
		$data['imprimir'] = 'Procedimento/imprimir/';
		$data['imprimirlista'] = 'Procedimento/imprimir_lista_Marketing/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'Orcatrata/baixadaparcelarec/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';

		$_SESSION['FiltroAlteraParcela']['idApp_Procedimento'] = $data['query']['idApp_Procedimento'];
		$_SESSION['FiltroAlteraParcela']['Sac'] = $data['query']['Sac'];
		$_SESSION['FiltroAlteraParcela']['Marketing'] = $data['query']['Marketing'];
		$_SESSION['FiltroAlteraParcela']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroAlteraParcela']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroAlteraParcela']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroAlteraParcela']['Compartilhar'] = $data['query']['Compartilhar'];
		$_SESSION['FiltroAlteraParcela']['TipoProcedimento'] = $data['query']['TipoProcedimento'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
        $_SESSION['FiltroAlteraParcela']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['HoraInicio9'] = $data['query']['HoraInicio9'];
		$_SESSION['FiltroAlteraParcela']['HoraFim9'] = $data['query']['HoraFim9'];
        $_SESSION['FiltroAlteraParcela']['HoraInicio10'] = $data['query']['HoraInicio10'];
		$_SESSION['FiltroAlteraParcela']['HoraFim10'] = $data['query']['HoraFim10'];
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
		$_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
		$_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];		
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		$this->form_validation->set_rules('DataInicio9', 'Data Início do Procedimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim9', 'Data Fim do Procedimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio10', 'Data Início do SubProcedimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim10', 'Data Fim do SubProcedimento', 'trim|valid_date');
		$this->form_validation->set_rules('HoraInicio9', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim9', 'Hora Final', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraInicio10', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim10', 'Hora Final', 'trim|valid_hour');

        #run form validation
        if ($this->form_validation->run() !== FALSE) {
            
			$data['bd']['idApp_Procedimento'] = $data['query']['idApp_Procedimento'];
			$data['bd']['Sac'] = $data['query']['Sac'];
			$data['bd']['Marketing'] = $data['query']['Marketing'];
			$data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['Compartilhar'] = $data['query']['Compartilhar'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['TipoProcedimento'] = $data['query']['TipoProcedimento'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
            $data['bd']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
			$data['bd']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
            $data['bd']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
			$data['bd']['HoraInicio9'] = $this->basico->mascara_data($data['query']['HoraInicio9'], 'mysql');
            $data['bd']['HoraFim9'] = $this->basico->mascara_data($data['query']['HoraFim9'], 'mysql');
			$data['bd']['HoraInicio10'] = $this->basico->mascara_data($data['query']['HoraInicio10'], 'mysql');
            $data['bd']['HoraFim10'] = $this->basico->mascara_data($data['query']['HoraFim10'], 'mysql');

            //$data['report'] = $this->Relatorio_model->list_procedimentos($data['bd'],TRUE);

			//$this->load->library('pagination');
			$config['per_page'] = 10;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';
			
			$config['base_url'] = base_url() . 'relatorio_pag/proc_Marketing_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_procedimentos($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_procedimentos($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('relatorio/list_procedimentos', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_procedimentos', $data);

        $this->load->view('basico/footer');

    }
	
    public function balanco() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';
		
		$data['query'] = quotes_to_entities($this->input->post(array(
			'Ano',
			'Mesvenc',
			'Mespag',
			'Diavenc',
			'Diapag',
			'TipoFinanceiro',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'Quitado',
			'Modalidade',
        ), TRUE));
		
		$_SESSION['FiltroBalanco']['Quitado'] = $data['query']['Quitado'];
        $_SESSION['FiltroBalanco']['Diavenc'] = $data['query']['Diavenc'];
        $_SESSION['FiltroBalanco']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroBalanco']['Ano'] = $data['query']['Ano'];
		
        $data['select']['AprovadoOrca'] = array(
            'S' => 'Sim',
			'N' => 'Não',
			'0' => 'TODOS',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Quitado'] = array(
			'0' => 'TODAS',
			'S' => 'Pagas',
			'N' => 'Não Pagas',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );

        $data['select']['Campo'] = array(
            'PR.DataVencimento' => 'Data do Venc.',
			'PR.Quitado' => 'Quit.Parc.',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrata' => 'Número da Receita',
            'OT.ValorOrca' => 'Valor da Receita',
            'OT.ConcluidoOrca' => 'Receita Concluída?',
			'OT.TipoFinanceiro' => 'Tipo de Receita',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Diavenc'] = $this->Relatorio_model->select_dia();
		$data['select']['Diapag'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();
		/*
		if (!$data['query']['Ano'])
           $data['query']['Ano'] = '2018';
		*/
		
		if (!$data['query']['Diavenc'])
           $data['query']['Diavenc'] = date('d', time());
	   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
/*	   
		if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());	   
*/	   
		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Ano', 'Ano', 'required|trim|integer|greater_than[1900]');

        $data['titulo1'] = 'Receita';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Diavenc'] = $data['query']['Diavenc'];
			$data['bd']['Diapag'] = $data['query']['Diapag'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            
			$data['report'] = $this->Relatorio_model->list1_receitadiaria($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list1'] = $this->load->view('relatorio/list1_receitadiaria', $data, TRUE);

        }
		
        $data['titulo2'] = 'Despesa';
        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            #$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Diavenc'] = $data['query']['Diavenc'];
			$data['bd']['Diapag'] = $data['query']['Diapag'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            
			$data['report'] = $this->Relatorio_model->list2_despesadiaria($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list2'] = $this->load->view('relatorio/list2_despesadiaria', $data, TRUE);

        }		
				
        $data['titulo3'] = 'Anual';
        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['report'] = $this->Relatorio_model->list_balancoanual($data['query']);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list3'] = $this->load->view('relatorio/list_balancoanual', $data, TRUE);

        }
		

        $this->load->view('relatorio/tela_balanco', $data);

        $this->load->view('basico/footer');

    }
			
    public function estoque() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Produtos',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        #$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(

			'TP.Nome_Prod' => 'Produto',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );


        $data['select']['Produtos'] = $this->Relatorio_model->select_produtos();


        $data['titulo'] = 'Relatório de Estoque';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_estoque($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              #exit();
              #*/

            $data['list'] = $this->load->view('relatorio/list_estoque', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_estoque', $data);

        $this->load->view('basico/footer');

    }

    public function estoque2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Produtos',
            'CodProd',			
            'DataInicio',
            'DataFim',
			'idTab_Catprod',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        #$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(
			'TP.Produtos' => 'Produto',	
			'TP.idTab_Catprod' => 'Categoria',
			'TP.CodProd' => 'Código',
			'TP.TipoProduto' => 'V/C/A',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );


        $data['select']['Produtos'] = $this->Relatorio_model->select_produtos();


        $data['titulo'] = 'Relatório de Estoque';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['CodProd'] = $data['query']['CodProd'];	
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_estoque($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              #exit();
              #*/

            $data['list'] = $this->load->view('relatorio/list_estoque2', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_estoque2', $data);

        $this->load->view('basico/footer');

    }

	public function rankingformapag() {

	if ($this->input->get('m') == 1)
		$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
	elseif ($this->input->get('m') == 2)
		$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
	else
		$data['msg'] = '';

	$data['query'] = quotes_to_entities($this->input->post(array(
		'ValorOrca',
		'FormaPag',
		'idTab_FormaPag',
		'DataInicio',
		'DataFim',
		'Ordenamento',
		'Campo',
	), TRUE));

	$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
	#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
	#$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
	#$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

	$data['select']['Campo'] = array(
		'FP.FormaPag' => 'Pagamento',
		'FP.idTab_FormaPag' => 'Id',
	);

	$data['select']['Ordenamento'] = array(
		'ASC' => 'Crescente',
		'DESC' => 'Decrescente',
	);

	$data['select']['FormaPag'] = $this->Relatorio_model->select_formapag();
	$data['select']['idTab_FormaPag'] = $this->Relatorio_model->select_formapag();

	$data['titulo'] = 'Ranking de Pagamentos';

	#run form validation
	if ($this->form_validation->run() !== TRUE) {

		$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$data['bd']['FormaPag'] = $data['query']['FormaPag'];
		$data['bd']['idTab_FormaPag'] = $data['query']['idTab_FormaPag'];
		$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
		$data['bd']['Campo'] = $data['query']['Campo'];

		$data['report'] = $this->Relatorio_model->list_rankingformapag($data['bd'],TRUE);

		/*
		  echo "<pre>";
		  print_r($data['report']);
		  echo "</pre>";
		  #exit();
		  #*/

		$data['list'] = $this->load->view('relatorio/list_rankingformapag', $data, TRUE);
		//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
	}

	$this->load->view('relatorio/tela_rankingformapag', $data);

	$this->load->view('basico/footer');

}

	public function rankingformaentrega() {

	if ($this->input->get('m') == 1)
		$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
	elseif ($this->input->get('m') == 2)
		$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
	else
		$data['msg'] = '';

	$data['query'] = quotes_to_entities($this->input->post(array(
		'ValorOrca',
		'ValorFrete',
		'TipoFrete',
		'idTab_TipoFrete',
		'DataInicio',
		'DataFim',
		'Ordenamento',
		'Campo',
	), TRUE));

	$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
	#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
	#$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
	#$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

	$data['select']['Campo'] = array(
		'FP.TipoFrete' => 'Tipo de Entrega',
		'FP.idTab_TipoFrete' => 'Id',
	);

	$data['select']['Ordenamento'] = array(
		'ASC' => 'Crescente',
		'DESC' => 'Decrescente',
	);

	$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
	$data['select']['idTab_TipoFrete'] = $this->Relatorio_model->select_tipofrete();

	$data['titulo'] = 'Ranking de Entrega';

	#run form validation
	if ($this->form_validation->run() !== TRUE) {

		$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
		$data['bd']['idTab_TipoFrete'] = $data['query']['idTab_TipoFrete'];
		$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
		$data['bd']['Campo'] = $data['query']['Campo'];

		$data['report'] = $this->Relatorio_model->list_rankingformaentrega($data['bd'],TRUE);

		/*
		  echo "<pre>";
		  print_r($data['report']);
		  echo "</pre>";
		  #exit();
		  #*/

		$data['list'] = $this->load->view('relatorio/list_rankingformaentrega', $data, TRUE);
		//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
	}

	$this->load->view('relatorio/tela_rankingformaentrega', $data);

	$this->load->view('basico/footer');

}

	public function rankingvendas() {

		if ($this->input->get('m') == 1)
			$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
		elseif ($this->input->get('m') == 2)
			$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
		else
			$data['msg'] = '';
			
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
		), TRUE));	
			
		$data['query'] = quotes_to_entities($this->input->post(array(
			'ValorOrca',
			'NomeCliente',
			'idApp_Cliente',
			'DataInicio',
			'DataFim',
			'DataInicio2',
			'DataFim2',
			'Ordenamento',
			'Campo',
			'Pedidos_de',
			'Pedidos_ate',
			'Valor_de',
			'Valor_ate',
			'Valor_cash_de',
			'Valor_cash_ate',
			'Ultimo',
		), TRUE));

		$data['select']['Campo'] = array(
			'Valor' => 'Valor Pedido',
			'F.CashBackCliente' => 'Valor CashBach',
			'ContPedidos' => 'Pedidos',
			'F.NomeCliente' => 'Cliente',
			'F.idApp_Cliente' => 'Id',
		);

		$data['select']['Ordenamento'] = array(
			'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
		);
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			'1' => 'Último Pedido',
        );		

		$data['titulo'] = 'Ranking de Vendas';
		$data['form_open_path'] = 'relatorio/rankingvendas';	
		$data['paginacao'] = 'N';
		
		$_SESSION['FiltroRankingVendas']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroRankingVendas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroRankingVendas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$_SESSION['FiltroRankingVendas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroRankingVendas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
		$_SESSION['FiltroRankingVendas']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroRankingVendas']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroRankingVendas']['Pedidos_de'] = $data['query']['Pedidos_de'];
		$_SESSION['FiltroRankingVendas']['Pedidos_ate'] = $data['query']['Pedidos_ate'];
		$_SESSION['FiltroRankingVendas']['Valor_de'] = $data['query']['Valor_de'];
		$_SESSION['FiltroRankingVendas']['Valor_ate'] = $data['query']['Valor_ate'];
		$_SESSION['FiltroRankingVendas']['Valor_cash_de'] = $data['query']['Valor_cash_de'];
		$_SESSION['FiltroRankingVendas']['Valor_cash_ate'] = $data['query']['Valor_cash_ate'];
		$_SESSION['FiltroRankingVendas']['Ultimo'] = $data['query']['Ultimo'];
			
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
		$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Inicio', 'trim|valid_date');
		$this->form_validation->set_rules('DataFim2', 'Data Fim', 'trim|valid_date');

		#run form validation
		if ($this->form_validation->run() !== FALSE) {

			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
			$data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['Valor_de'] = $data['query']['Valor_de'];
			$data['bd']['Valor_ate'] = $data['query']['Valor_ate'];
			$data['bd']['Valor_cash_de'] = $data['query']['Valor_cash_de'];
			$data['bd']['Valor_cash_ate'] = $data['query']['Valor_cash_ate'];
			$data['bd']['Pedidos_de'] = $data['query']['Pedidos_de'];
			$data['bd']['Pedidos_ate'] = $data['query']['Pedidos_ate'];
			$data['bd']['Ultimo'] = $data['query']['Ultimo'];

			//$data['report'] = $this->Relatorio_model->list_rankingvendas($data['bd'],TRUE);

			//$this->load->library('pagination');
			$config['per_page'] = 10;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';
			
			$config['base_url'] = base_url() . 'relatorio_pag/rankingvendas_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_rankingvendas($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_rankingvendas($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
			$data['list'] = $this->load->view('relatorio/list_rankingvendas', $data, TRUE);
			//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		}

		$this->load->view('relatorio/tela_rankingvendas', $data);

		$this->load->view('basico/footer');

	}

	public function rankingcompras() {

	if ($this->input->get('m') == 1)
		$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
	elseif ($this->input->get('m') == 2)
		$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
	else
		$data['msg'] = '';

	$data['query'] = quotes_to_entities($this->input->post(array(
		'ValorOrca',
		'NomeFornecedor',
		'idApp_Fornecedor',
		'DataInicio',
		'DataFim',
		'Ordenamento',
		'Campo',
	), TRUE));

	$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
	#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
	#$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
	#$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

	$data['select']['Campo'] = array(

		'TC.NomeFornecedor' => 'Fornecedor',
		'TC.idApp_Fornecedor' => 'Id',

	);

	$data['select']['Ordenamento'] = array(
		'ASC' => 'Crescente',
		'DESC' => 'Decrescente',
	);



	$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
	$data['select']['idApp_Fornecedor'] = $this->Relatorio_model->select_fornecedor();


	$data['titulo'] = 'Ranking de Compras';

	#run form validation
	if ($this->form_validation->run() !== TRUE) {

		$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
		$data['bd']['Campo'] = $data['query']['Campo'];

		$data['report'] = $this->Relatorio_model->list_rankingcompras($data['bd'],TRUE);

		/*
		  echo "<pre>";
		  print_r($data['report']);
		  echo "</pre>";
		  #exit();
		  #*/

		$data['list'] = $this->load->view('relatorio/list_rankingcompras', $data, TRUE);
		//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
	}

	$this->load->view('relatorio/tela_rankingcompras', $data);

	$this->load->view('basico/footer');

}

	public function rankingreceitas() {

	if ($this->input->get('m') == 1)
		$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
	elseif ($this->input->get('m') == 2)
		$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
	else
		$data['msg'] = '';

	$data['query'] = quotes_to_entities($this->input->post(array(
		'ValorOrca',
		'TipoFinanceiro',
		'idTab_TipoFinanceiro',
		'DataInicio',
		'DataFim',
		'Ordenamento',
		'Campo',
		'Quitado',
	), TRUE));

	$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
	#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
	#$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
	#$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

	$data['select']['Campo'] = array(

		'TC.TipoFinanceiro' => 'Tipo',
		'TC.idTab_TipoFinanceiro' => 'Id',

	);

	$data['select']['Ordenamento'] = array(
		'ASC' => 'Crescente',
		'DESC' => 'Decrescente',
	);

	$data['select']['Quitado'] = array(
		'0' => ':: TODOS ::',
		'N' => 'Não',
		'S' => 'Sim',
	);

	$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiroR();
	$data['select']['idTab_TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiroR();


	$data['titulo'] = 'Ranking de Receitas';

	#run form validation
	if ($this->form_validation->run() !== TRUE) {

		$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$data['bd']['idTab_TipoFinanceiro'] = $data['query']['idTab_TipoFinanceiro'];
		$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
		$data['bd']['Campo'] = $data['query']['Campo'];
		$data['bd']['Quitado'] = $data['query']['Quitado'];

		$data['report'] = $this->Relatorio_model->list_rankingreceitas($data['bd'],TRUE);

		/*
		  echo "<pre>";
		  print_r($data['report']);
		  echo "</pre>";
		  #exit();
		  #*/

		$data['list'] = $this->load->view('relatorio/list_rankingreceitas', $data, TRUE);
		//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
	}

	$this->load->view('relatorio/tela_rankingreceitas', $data);

	$this->load->view('basico/footer');

}

	public function rankingdespesas() {

	if ($this->input->get('m') == 1)
		$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
	elseif ($this->input->get('m') == 2)
		$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
	else
		$data['msg'] = '';

	$data['query'] = quotes_to_entities($this->input->post(array(
		'ValorOrca',
		'TipoFinanceiro',
		'idTab_TipoFinanceiro',
		'DataInicio',
		'DataFim',
		'Ordenamento',
		'Campo',
		'Quitado',
	), TRUE));

	$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
	#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
	#$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
	#$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

	$data['select']['Campo'] = array(

		'TC.TipoFinanceiro' => 'Tipo',
		'TC.idTab_TipoFinanceiro' => 'Id',

	);

	$data['select']['Ordenamento'] = array(
		'ASC' => 'Crescente',
		'DESC' => 'Decrescente',
	);

	$data['select']['Quitado'] = array(
		'0' => ':: TODOS ::',
		'N' => 'Não',
		'S' => 'Sim',
	);

	$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiroD();
	$data['select']['idTab_TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiroD();


	$data['titulo'] = 'Ranking de Despesas';

	#run form validation
	if ($this->form_validation->run() !== TRUE) {

		$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$data['bd']['idTab_TipoFinanceiro'] = $data['query']['idTab_TipoFinanceiro'];
		$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
		$data['bd']['Campo'] = $data['query']['Campo'];
		$data['bd']['Quitado'] = $data['query']['Quitado'];

		$data['report'] = $this->Relatorio_model->list_rankingdespesas($data['bd'],TRUE);

		/*
		  echo "<pre>";
		  print_r($data['report']);
		  echo "</pre>";
		  #exit();
		  #*/

		$data['list'] = $this->load->view('relatorio/list_rankingdespesas', $data, TRUE);
		//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
	}

	$this->load->view('relatorio/tela_rankingdespesas', $data);

	$this->load->view('basico/footer');

}

	public function sistema() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Manuteção';
		$data['titulo2'] = 'Comissão';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorio/tela_sistema', $data);

        $this->load->view('basico/footer');

    }
	
	public function servicosprest() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'NomeProfissional',
			'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',

        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');


        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Id Orçam.',
            'OT.DataOrca' => 'Data do Orçam.',
			'OT.ProfissionalOrca' => 'Responsável',
			'PD.NomeServico' => 'Serviço',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional();

        $data['titulo'] = 'Relatório de Serviços Prestados';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_servicosprest($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_servicosprest', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_servicosprest', $data);

        $this->load->view('basico/footer');

    }

    public function clientes() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
			'id_ClientePet_Auto',
			'NomeClientePetAuto',
			'id_ClienteDep_Auto',
			'NomeClienteDepAuto',
		), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
            //'NomeCliente',
			'idApp_Cliente',
			'idApp_ClientePet',
			'idApp_ClienteDep',
			'Ativo',
			'Motivo',
            'Ordenamento',
            'Campo',
			'DataInicio',
            'DataFim',
			'Dia',
			'Mesvenc',
			'Ano',
        ), TRUE));

        $data['select']['Ativo'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Campo'] = array(
            'C.idApp_Cliente' => 'nº Cliente',
			'C.NomeCliente' => 'Nome do Cliente',
			'C.Ativo' => 'Ativo',
            'C.DataNascimento' => 'Data de Nascimento',
            'C.Sexo' => 'Sexo',
            'C.BairroCliente' => 'Bairro',
            'C.MunicipioCliente' => 'Município',
            'C.Email' => 'E-mail',
			'CC.NomeContatoCliente' => 'Contato do Cliente',
			'TCC.RelaPes' => 'Rel. Pes.',
			'TCC.RelaCom' => 'Rel. Com.',
			'CC.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        //$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Motivo'] = $this->Relatorio_model->select_motivo();
		
		$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['titulo'] = 'Clientes';
		$data['form_open_path'] = 'relatorio/clientes';
		
		$data['paginacao'] = 'N';

        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');        
		$_SESSION['FiltroAlteraParcela']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraParcela']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
		$_SESSION['FiltroAlteraParcela']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
		$_SESSION['FiltroAlteraParcela']['Ativo'] = $data['query']['Ativo'];
		$_SESSION['FiltroAlteraParcela']['Motivo'] = $data['query']['Motivo'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
		$_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
		$_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Cadastro', 'trim|valid_date');

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
            //$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$data['bd']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
			$data['bd']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
			$data['bd']['Ativo'] = $data['query']['Ativo'];
			$data['bd']['Motivo'] = $data['query']['Motivo'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];

			//$this->load->library('pagination');
			$config['per_page'] = 10;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$data['Pesquisa'] = '';
			
			$config['base_url'] = base_url() . 'relatorio_pag/clientes_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_clientes($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_clientes($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_clientes', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_clientes', $data);

        $this->load->view('basico/footer');



    }

    public function clenkontraki() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'NomeAdmin',
			'Inativo',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['Inativo'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Campo'] = array(
            'C.idSis_Empresa' => 'nº Emp.',
			'C.NomeEmpresa' => 'Empresa',
			'C.NomeAdmin' => 'Admin',
            'C.DataCriacao' => 'Criação',
			'C.DataDeValidade' => 'Validade',
			'C.NivelEmpresa' => 'Nivel',
			'C.Inativo' => 'Ativo',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_clenkontraki();
		
		$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['titulo'] = 'Clientes Enkontraki';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['Inativo'] = $data['query']['Inativo'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_clenkontraki($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_clenkontraki', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_clenkontraki', $data);

        $this->load->view('basico/footer');

    }

    public function clientes3() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'Ativo',
            'Ordenamento',
            'Campo',
			'DataInicio',
            'DataFim',
			'Dia',
			'Mesvenc',
			'Ano',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['Ativo'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Campo'] = array(
            'C.idApp_Cliente' => 'nº Cliente',
			'C.NomeCliente' => 'Nome do Cliente',
			'C.Ativo' => 'Ativo',
            'C.DataNascimento' => 'Data de Nascimento',
            'C.Sexo' => 'Sexo',
            'C.Bairro' => 'Bairro',
            'C.Municipio' => 'Município',
            'C.Email' => 'E-mail',
			'CC.NomeContatoCliente' => 'Contato do Cliente',
			'TCC.RelaPes' => 'Rel. Pes.',
			'TCC.RelaCom' => 'Rel. Com.',
			'CC.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		
		$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['titulo'] = 'Clientes';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Ativo'] = $data['query']['Ativo'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];

            $data['report'] = $this->Relatorio_model->list_clientes($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_clientes3', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_clientes3', $data);

        $this->load->view('basico/footer');



    }

	public function associado() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'CategoriaEmpresa',
			'Atuacao',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

		$data['select']['Campo'] = array(
            'C.NomeEmpresa' => 'Nome da Empresa',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_associado();
		$data['select']['CategoriaEmpresa'] = $this->Relatorio_model->select_categoriaempresa();
		$data['select']['Atuacao'] = $this->Relatorio_model->select_atuacao();		

        $data['titulo'] = 'Associados';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['CategoriaEmpresa'] = $data['query']['CategoriaEmpresa'];
			$data['bd']['Atuacao'] = $data['query']['Atuacao'];			
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_associado($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_associado', $data, TRUE);
        }

        $this->load->view('relatorio/tela_associado', $data);

        $this->load->view('basico/footer');

    }

	public function empresaassociado() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');



		$data['select']['Campo'] = array(
            'C.NomeEmpresa' => 'idSis_Empresa',
            'C.Email' => 'E-mail',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresaassociado();

        $data['titulo'] = 'Relatório de Indicações';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_empresaassociado($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_empresaassociado', $data, TRUE);
        }

        $this->load->view('relatorio/tela_empresaassociado', $data);

        $this->load->view('basico/footer');

    }

	public function profissionais() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeProfissional',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'P.NomeProfissional' => 'Nome do Profissional',
			'P.Funcao' => 'Função',
            'P.DataNascimento' => 'Data de Nascimento',
            'P.Sexo' => 'Sexo',
            'P.Bairro' => 'Bairro',
            'P.Municipio' => 'Município',
            'P.Email' => 'E-mail',
			'CP.NomeContatoProf' => 'Contato do Profissional',
			'TCP.RelaPes' => 'Relação',
			'CP.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional();

        $data['titulo'] = 'Relatório de Funcionários';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_profissionais($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_profissionais', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_profissionais', $data);

        $this->load->view('basico/footer');



    }

	public function funcionario() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'F.Nome' => 'Nome do Funcionário',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorio_model->select_funcionario();

        $data['titulo'] = 'Relatório de Funcionários';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_funcionario($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_funcionario', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_funcionario', $data);

        $this->load->view('basico/footer');



    }

	public function empresas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'CategoriaEmpresa',
			'Atuacao',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.NomeEmpresa' => 'Nome da Empresa',
			'CE.CategoriaEmpresa' => 'Categoria',
            'E.BairroEmpresa' => 'Bairro',
            'E.MunicipioEmpresa' => 'Cidade',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresas();
		$data['select']['CategoriaEmpresa'] = $this->Relatorio_model->select_categoriaempresa();
		$data['select']['Atuacao'] = $this->Relatorio_model->select_atuacao();

        $data['titulo'] = 'Empresas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['CategoriaEmpresa'] = $data['query']['CategoriaEmpresa'];
			$data['bd']['Atuacao'] = $data['query']['Atuacao'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_empresas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_empresas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_empresas', $data);

        $this->load->view('basico/footer');

    }
	
	public function empresas1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.idSis_Empresa' => 'nº idSis_Empresa',
			'E.NomeEmpresa' => 'Nome do Fornecedor',
			'E.Atividade' => 'Atividade',
            #'E.DataNascimento' => 'Data de Nascimento',
            #'E.Sexo' => 'Sexo',
            'E.BairroEmpresa' => 'Bairro',
            'E.MunicipioEmpresa' => 'Cidade',
            'E.Email' => 'E-mail',
			'CE.NomeContato' => 'Contato da idSis_Empresa',
			'TCE.RelaCom' => 'Relação',
			'CE.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresas();

        $data['titulo'] = 'Relatório de Fornecedores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_empresas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_empresas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_empresas', $data);

        $this->load->view('basico/footer');

    }

	public function fornecedor() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeFornecedor',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.idApp_Fornecedor' => 'nº Fornecedor',
			'E.NomeFornecedor' => 'Nome do Fornecedor',
			'E.Atividade' => 'Atividade',
            #'E.DataNascimento' => 'Data de Nascimento',
            #'E.Sexo' => 'Sexo',
            'E.BairroFornecedor' => 'Bairro',
            'E.MunicipioFornecedor' => 'Município',
            'E.Email' => 'E-mail',
			'CE.NomeContatofornec' => 'Contatofornec da Fornecedor',
			'TCE.RelaCom' => 'Relação',
			'CE.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();

        $data['titulo'] = 'Relatório de Fornecedores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_fornecedor($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_fornecedor', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_fornecedor', $data);

        $this->load->view('basico/footer');

    }

	public function fornecedor3() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeFornecedor',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.idApp_Fornecedor' => 'nº Fornecedor',
			'E.NomeFornecedor' => 'Nome do Fornecedor',
			'E.Atividade' => 'Atividade',
            #'E.DataNascimento' => 'Data de Nascimento',
            #'E.Sexo' => 'Sexo',
            'E.Bairro' => 'Bairro',
            'E.Municipio' => 'Município',
            'E.Email' => 'E-mail',
			'CE.NomeContatofornec' => 'Contatofornec da Fornecedor',
			'TCE.RelaCom' => 'Relação',
			'CE.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();

        $data['titulo'] = 'Relatório de Fornecedores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_fornecedor($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_fornecedor3', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_fornecedor3', $data);

        $this->load->view('basico/footer');

    }

	public function produtos() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idTab_Promocao',
            'idTab_Catprod',
            'idTab_Produto',
            'idTab_Produtos',
			'TipoProduto',
			'Ordenamento',
            'Campo',
			'Agrupar',
			'Tipo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['Campo'] = array(
			'TCP.Catprod' => 'Categoria',
			'TP.Produtos' => 'Produto Base',
			'TPS.Nome_Prod' => 'Produtos',
			'TV.idTab_Valor' => 'id_Preço',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );
		
        $data['select']['Tipo'] = array(
			'0' => '::Todos::',
			'1' => 'Preço',
			'2' => 'Promoção',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Todos::',
			'1' => 'Produtos',
			'2' => 'Produtos C/Preço',
			'3' => 'Produtos C/Promocao',
			'4' => 'Promoções',
        );		
		
		$data['select']['idTab_Catprod'] = $this->Relatorio_model->select_catprod();
		$data['select']['idTab_Produto'] = $this->Relatorio_model->select_produto();
		$data['select']['idTab_Produtos'] = $this->Relatorio_model->select_produtos();

        $data['titulo'] = 'Produtos';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
			$data['bd']['idTab_Produto'] = $data['query']['idTab_Produto'];
			$data['bd']['idTab_Produtos'] = $data['query']['idTab_Produtos'];
			$data['bd']['Tipo'] = $data['query']['Tipo'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_produtos($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_produtos', $data, TRUE);

        }

        $this->load->view('relatorio/tela_produtos', $data);

        $this->load->view('basico/footer');

    }
	
	public function produtos2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Produtos',
			'CodProd',
			'TipoProduto',
			'idTab_Catprod',
			'Categoria',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TP.Produtos' => 'Produto',			
			'TCP.Catprod' => 'Categoria',
			#'TP.Categoria' => 'Prod/Serv',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['idTab_Catprod'] = $this->Relatorio_model->select_catprod();
		$data['select']['TipoProduto'] = $this->Relatorio_model->select_tipoproduto();

        $data['titulo'] = 'Produtos';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['CodProd'] = $data['query']['CodProd'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_produtos2($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_produtos3', $data, TRUE);

        }

        $this->load->view('relatorio/tela_produtos3', $data);

        $this->load->view('basico/footer');

    }

	public function promocao() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Produtos',
			'Promocao',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TPM.Promocao' => 'Promocao',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Produtos'] = $this->Relatorio_model->select_produtos1();
		$data['select']['Promocao'] = $this->Relatorio_model->select_promocao();
		$data['select']['TipoProduto'] = $this->Relatorio_model->select_tipoproduto();

        $data['titulo'] = 'Promoçoes';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Promocao'] = $data['query']['Promocao'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_promocao($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_promocao', $data, TRUE);

        }

        $this->load->view('relatorio/tela_promocao', $data);

        $this->load->view('basico/footer');

    }

	public function precopromocao() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Produtos',
			'Promocao',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TPD.Nome_Prod' => 'Produtos',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Produtos'] = $this->Relatorio_model->select_produtos1();
		$data['select']['TipoProduto'] = $this->Relatorio_model->select_tipoproduto();

        $data['titulo'] = 'Preços das Promoçoes';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Promocao'] = $data['query']['Promocao'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_precopromocao($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_precopromocao', $data, TRUE);

        }

        $this->load->view('relatorio/tela_precopromocao', $data);

        $this->load->view('basico/footer');

    }
	
	public function catprod() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Catprod',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TPM.Catprod' => 'Categoria',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['TipoProduto'] = $this->Relatorio_model->select_tipoproduto();

        $data['titulo'] = 'Categorias';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Catprod'] = $data['query']['Catprod'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_catprod($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_catprod', $data, TRUE);

        }

        $this->load->view('relatorio/tela_catprod', $data);

        $this->load->view('basico/footer');

    }

	public function atributo() {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Atributo',
			'idTab_Catprod',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TPM.Atributo' => 'Categoria',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['idTab_Catprod'] = $this->Relatorio_model->select_catprod();
		$data['select']['TipoProduto'] = $this->Relatorio_model->select_tipoproduto();

        $data['titulo'] = 'Categorias';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
			$data['bd']['Atributo'] = $data['query']['Atributo'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_atributo($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_atributo', $data, TRUE);

        }

        $this->load->view('relatorio/tela_atributo', $data);

        $this->load->view('basico/footer');

    }	
	
	public function servicos() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Servicos',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TP.idApp_Servicos' => 'id do Serviço',
			'TP.Servicos' => 'Serviço',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Servicos'] = $this->Relatorio_model->select_servicos();

        $data['titulo'] = 'Servicos e Valores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Servicos'] = $data['query']['Servicos'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_servicos($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_servicos', $data, TRUE);

        }

        $this->load->view('relatorio/tela_servicos', $data);

        $this->load->view('basico/footer');

    }

	public function orcamentoonline() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'NomeEmpresa',
            'DataInicio',
            'DataFim',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            #'QuitadoOrca',
			'ConcluidoOrca',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
/*
        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
*/
		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'EMP.NomeEmpresa' => 'Nome da Empresa',
			'OT.idApp_OrcaTrata' => 'Número do Orçamento',
			'OT.DataOrca' => 'Data do Orçamento',
            'OT.DataVencimentoOrca' => 'Data Vencimento',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();

		$data['titulo'] = 'Orçamentos Online';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            #$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];


			#$data['bd']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');


            $data['report'] = $this->Relatorio_model->list_orcamentoonline($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_orcamentoonline', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_orcamentoonline', $data);

        $this->load->view('basico/footer');



    }

	public function orcamentoonlineempresa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'Nome',
            'DataInicio',
            'DataFim',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            #'QuitadoOrca',
			'ConcluidoOrca',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
/*
        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
*/
		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'U.Nome' => 'Nome do Associado',
			'OT.idApp_OrcaTrata' => 'Número do Orçamento',
			'OT.DataOrca' => 'Data do Orçamento',
            'OT.DataVencimentoOrca' => 'Data Vencimento',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();

		$data['titulo'] = 'Orçamentos Online';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Nome'] = $data['query']['Nome'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            #$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];


			#$data['bd']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');


            $data['report'] = $this->Relatorio_model->list_orcamentoonlineempresa($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_orcamentoonlineempresa', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_orcamentoonlineempresa', $data);

        $this->load->view('basico/footer');

}
	
	public function orcamentopc() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'NomeProfissional',
            'DataInicio',
            'DataFim',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            #'QuitadoOrca',
			'ConcluidoOrca',
			'ConcluidoProcedimento',

        ), TRUE));

		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
/*
        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
*/
		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
		$data['select']['ConcluidoProcedimento'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Número do Orçamento',
			'OT.DataOrca' => 'Data do Orçamento',
            'OT.DataPrazo' => 'Data Prazo',
			'OT.AprovadoOrca' => 'Orçamento Aprovado?',
			'OT.ValorOrca' => 'Valor do Orçamento',
            #'OT.QuitadoOrca' => 'Orçamento Quitado?',
			'OT.ConcluidoOrca' => 'Serviço Concluído?',
            'OT.DataConclusao' => 'Data de Conclusão',
            #'OT.DataRetorno' => 'Renovação',
			#'PD.QtdProduto' => 'Qtd. do Produto',
			'PD.idTab_Produto' => 'Produto',
			'PC.DataProcedimento' => 'Data do Procedimento',
			'PC.Profissional' => 'Profissional',
			'PC.Procedimento' => 'Procedimento',
			'PC.ConcluidoProcedimento' => 'Proc. Concl.?',
			'PC.DataProcedimentoLimite' => 'Data Limite',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional();

		$data['titulo'] = 'Clientes X Procedimentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            #$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];

			#$data['bd']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');


            $data['report'] = $this->Relatorio_model->list_orcamentopc($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_orcamentopc', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_orcamentopc', $data);

        $this->load->view('basico/footer');



    }

	public function tarefa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'DataInicio',
            'DataFim',
            #'NomeProfissional',
			#'Profissional',
			'Ordenamento',
            'Campo',
            'ConcluidoProcedimento',
            'Prioridade',
			'Categoria',
			#'Rotina',
			'ConcluidoSubProcedimento',
			'Procedimento',
			'SubProcedimento',
			'SubPrioridade',
			'Statustarefa',
			'Statussubtarefa',
			'Agrupar',
        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
		
		$_SESSION['FiltroAlteraProcedimento']['Categoria'] = $data['query']['Categoria'];
		$_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
		$_SESSION['FiltroAlteraProcedimento']['Prioridade'] = $data['query']['Prioridade'];
		$_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] = $data['query']['ConcluidoSubProcedimento'];
		$_SESSION['FiltroAlteraProcedimento']['SubPrioridade'] = $data['query']['SubPrioridade'];
		$_SESSION['FiltroAlteraProcedimento']['Statustarefa'] = $data['query']['Statustarefa'];
		$_SESSION['FiltroAlteraProcedimento']['Statussubtarefa'] = $data['query']['Statussubtarefa'];
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['ConcluidoProcedimento'] = array(
            '0' => '::Todos::',
			'S' => 'Sim',
			'N' => 'Não',
        );

        $data['select']['Prioridade'] = array(
            '0' => '::Todos::',
			'1' => 'Alta',
            '2' => 'Media',
            '3' => 'Baixa',
        );
		
        $data['select']['SubPrioridade'] = array(
            '0' => '::Todos::',
			'1' => 'Alta',
            '2' => 'Media',
            '3' => 'Baixa',
        );
        $data['select']['Statustarefa'] = array(
            '0' => '::Todos::',
			'1' => 'Fazer',
            '2' => 'Fazendo',
            '3' => 'Feito',
        );
        $data['select']['Statussubtarefa'] = array(
            '0' => '::Todos::',
			'1' => 'Fazer',
            '2' => 'Fazendo',
            '3' => 'Feito',
        );		
/*
		$data['select']['Rotina'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
*/
		$data['select']['ConcluidoSubProcedimento'] = array(
            '0' => '::Todos::',
			'S' => 'Sim',
			'N' => 'Não',
			'M' => 'Com SubTarefa',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',			
			'idApp_Procedimento' => 'Tarefa',
        );

        $data['select']['Campo'] = array(
			'P.DataProcedimento' => 'Data do Inicio',
			'P.DataProcedimentoLimite' => 'Data da Concl.',	
			'P.Compartilhar' => 'Quem Fazer',
			'P.idSis_Usuario' => 'Quem Cadastrou',		
			'P.ConcluidoProcedimento' => 'Concluido',
			'P.Categoria' => 'Categoria',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        #$data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional3();
		#$data['select']['Profissional'] = $this->Relatorio_model->select_profissional2();
		$data['select']['Categoria'] = $this->Relatorio_model->select_categoria();
		$data['select']['Procedimento'] = $this->Relatorio_model->select_tarefa();
		$data['select']['SubProcedimento'] = $this->Relatorio_model->select_procedtarefa();

        $data['titulo'] = 'Tarefas';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            #$data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
			#$data['bd']['Profissional'] = $data['query']['Profissional'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
            $data['bd']['Prioridade'] = $data['query']['Prioridade'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
			#$data['bd']['Rotina'] = $data['query']['Rotina'];
			$data['bd']['ConcluidoSubProcedimento'] = $data['query']['ConcluidoSubProcedimento'];
			$data['bd']['Procedimento'] = $data['query']['Procedimento'];
			$data['bd']['SubProcedimento'] = $data['query']['SubProcedimento'];
			$data['bd']['SubPrioridade'] = $data['query']['SubPrioridade'];
			$data['bd']['Statustarefa'] = $data['query']['Statustarefa'];
			$data['bd']['Statussubtarefa'] = $data['query']['Statussubtarefa'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];

            $data['report'] = $this->Relatorio_model->list_tarefa($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_tarefa', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_tarefa', $data);

        $this->load->view('basico/footer');

    }

	public function clienteprod() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Ordenamento',
            'Campo',
			'AprovadoOrca',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

		$data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
			'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Número do Orçamento',
			'OT.AprovadoOrca' => 'Aprovado?',
			'PD.QtdProduto' => 'Qtd. do Produto',
			'PD.idTab_Produto' => 'Produto',
			'PC.Procedimento' => 'Procedimento',
			'PC.ConcluidoProcedimento' => 'Proc. Concl.?',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['titulo'] = 'Relatório Clientes X Produtos X Procedimentos';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			#$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];

            $data['report'] = $this->Relatorio_model->list_clienteprod($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_clienteprod', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_clienteprod', $data);

        $this->load->view('basico/footer');



    }

	public function orcamentosv() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
            'DataInicio',
            'DataFim',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            #'QuitadoOrca',
			'ConcluidoOrca',
			'ConcluidoProcedimento',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
/*
        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
*/
		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
		$data['select']['ConcluidoProcedimento'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Número do Orçamento',
			'OT.DataOrca' => 'Data do Orçamento',
            'OT.DataPrazo' => 'Data Prazo',
			'OT.AprovadoOrca' => 'Orçamento Aprovado?',
			'OT.ValorOrca' => 'Valor do Orçamento',
            #'OT.QuitadoOrca' => 'Orçamento Quitado?',
			'OT.ConcluidoOrca' => 'Serviço Concluído?',
            'OT.DataConclusao' => 'Data de Conclusão',
            #'OT.DataRetorno' => 'Renovação',
			#'PD.QtdProduto' => 'Qtd. do Produto',
			#'PD.idTab_Produto' => 'Produto',
			'SV.idTab_Servico' => 'Servico',
			'PC.DataProcedimento' => 'Data do Procedimento',
			'PC.Profissional' => 'Profissional',
			'PC.Procedimento' => 'Procedimento',
			'PC.ConcluidoProcedimento' => 'Proc. Concl.?',
			'PC.DataProcedimentoLimite' => 'Data Limite',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();

        $data['titulo'] = 'Relatório de Orçamentos X Procedimentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            #$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];

			#$data['bd']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');


            $data['report'] = $this->Relatorio_model->list_orcamentosv($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_orcamentosv', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_orcamentosv', $data);

        $this->load->view('basico/footer');



    }

    public function procedimento() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'ConcluidoProcedimento',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['ConcluidoProcedimento'] = array(
            'N' => 'Não',
            'S' => 'Sim',
			'#' => 'TODOS',
        );

		$data['select']['Campo'] = array(
			'C.DataProcedimento' => 'Data',
			'C.ConcluidoProcedimento' => 'Concl.',
            'C.idApp_Procedimento' => 'id',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        #$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		
        $data['titulo'] = 'Tarefas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_procedimento($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_procedimento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_procedimento', $data);

        $this->load->view('basico/footer');

    }

    public function alterarprocedimento() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'ConcluidoProcedimento',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['ConcluidoProcedimento'] = array(
            '#' => 'TODOS',
			'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Campo'] = array(
			'C.DataProcedimento' => 'Data',
			'C.ConcluidoProcedimento' => 'Concl.',
            'C.idApp_Procedimento' => 'id',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        #$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		
        $data['titulo'] = 'Tarefas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_alterarprocedimento($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_alterarprocedimento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_alterarprocedimento', $data);

        $this->load->view('basico/footer');

    }

	public function slides() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Slides',
			'Slide1',
			'Texto_Slide1',
			'Ativo',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['titulo'] = 'Slides';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['idApp_Slides'] = $data['query']['idApp_Slides'];
			$data['bd']['Slide1'] = $data['query']['Slide1'];
			$data['bd']['Texto_Slide1'] = $data['query']['Texto_Slide1'];
			$data['bd']['Ativo'] = $data['query']['Ativo'];

            $data['report'] = $this->Relatorio_model->list_slides($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_slides', $data, TRUE);

        }

        $this->load->view('relatorio/tela_slides', $data);

        $this->load->view('basico/footer');

    }
	
    public function site() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($_SESSION['log']['idSis_Empresa'], TRUE);
		$_SESSION['Produtos'] = $data['produtos'] = $this->Empresa_model->get_produtos($_SESSION['log']['idSis_Empresa'], TRUE);
		$_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);

		$data['titulo'] = 'Prontuário ' ;
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

		$data['prod'] = $this->Relatorio_model->list1_produtos(TRUE);
		$data['slides'] = $this->Relatorio_model->list2_slides(TRUE);
		$data['doc'] = $this->Relatorio_model->list3_documentos(TRUE);
		
		$data['list1'] = $this->load->view('relatorio/list1_produtos', $data, TRUE);
		$data['list2'] = $this->load->view('relatorio/list2_slides', $data, TRUE);		
		$data['list3'] = $this->load->view('relatorio/list3_logo_nav', $data, TRUE);
		$data['list4'] = $this->load->view('relatorio/list4_icone', $data, TRUE);		
		
        $_SESSION['log']['idSis_Empresa'] = $data['resumo']['idSis_Empresa'] = $data['documentos']['idSis_Empresa'] = $data['query']['idSis_Empresa'];

		$data['query']['Empresa'] = $this->Basico_model->get_empresa($data['query']['NomeEmpresa']);
		$data['query']['CategoriaEmpresa'] = $this->Basico_model->get_categoriaempresa($data['query']['CategoriaEmpresa']);

        /*
          echo "<pre>";
          print_r($data['contatoempresa']);
          echo "</pre>";
          exit();
          */

        $this->load->view('relatorio/tela_site', $data);

        $this->load->view('basico/footer');
    }
	
    public function loginempresa() {

        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

		$_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
        ###################################################
        #só pra eu saber quando estou no banco de testes ou de produção
        #$CI = & get_instance();
        #$CI->load->database();
        #if ($CI->db->database != 'sishuap')
        #echo $CI->db->database;
        ###################################################
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #Get GET or POST data
        $celular = $this->input->get_post('CelularAdmin');
		$empresa = $this->input->get_post('idSis_Empresa');
        $senha = md5($this->input->get_post('Senha'));

        #set validation rules
        /*
		$this->form_validation->set_rules('CelularAdmin', 'Celular do Admin', 'required|trim|callback_valid_celular');
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim|callback_valid_empresa[' . $celular . ']');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $celular . ']');
		*/
		$this->form_validation->set_rules('CelularAdmin', 'Celular do Admin', 'required|trim');
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5');
		
		#$data['select']['idSis_Empresa'] = $this->Loginempresa_model->select_empresa();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa31();
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o loginempresa novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o loginempresa para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
            $this->load->view('relatorio/form_loginempresa', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('UsuarioEmpresa');
            #$senha = md5($this->input->get_post('Senha'));
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */
            //$query = $this->Loginempresa_model->check_dados_celular($senha, $celular, TRUE);
			//$query = $this->Loginempresa_model->check_dados_empresa($empresa, $celular, TRUE);
			
			$query = $this->Loginempresa_model->check_dados_empresa($empresa, $celular, $senha, TRUE);
            
			#$_SESSION['log']['Agenda'] = $this->Loginempresa_model->get_agenda_padrao($query['idSis_Empresa']);
			
            #echo "<pre>".print_r($query)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usuário</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Celular ou Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('relatorio/form_loginempresa', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['UsuarioEmpresa'] = $query['UsuarioEmpresa'];
                //se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
				$_SESSION['log']['UsuarioEmpresa'] = (strlen($query['UsuarioEmpresa']) > 13) ? substr($query['UsuarioEmpresa'], 0, 13) : $query['UsuarioEmpresa'];
                $_SESSION['log']['Nome'] = $query['NomeAdmin'];
				$_SESSION['log']['Nome2'] = (strlen($query['NomeAdmin']) > 6) ? substr($query['NomeAdmin'], 0, 6) : $query['NomeAdmin'];
				$_SESSION['log']['CpfAdmin'] = $query['CpfAdmin'];
				$_SESSION['log']['CelularAdmin'] = $query['CelularAdmin'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 15) ? substr($query['NomeEmpresa'], 0, 15) : $query['NomeEmpresa'];
				$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
				$_SESSION['log']['PermissaoEmpresa'] = $query['PermissaoEmp'];
				$_SESSION['log']['NivelEmpresa'] = $query['NivelEmpresa'];
				$_SESSION['log']['DataCriacao'] = $query['DataCriacao'];
				$_SESSION['log']['DataDeValidade'] = $query['DataDeValidade'];

                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Loginempresa_model->set_acesso($_SESSION['log']['idSis_Empresa'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('relatorio/form_loginempresa');
                } else {
					redirect('acessoempresa');
					#redirect('agenda');
					#redirect('cliente');
                }
            }
        }

        #load footer view
        #$this->load->view('basico/footerloginempresa');
        $this->load->view('basico/footer');
    }
	function valid_celular($celular) {

        if ($this->Loginempresa_model->check_celular($celular) == 1) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> não existe.');
            return FALSE;
        } else if ($this->Loginempresa_model->check_celular($celular) == 2) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> inativo! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	function valid_empresa($empresa, $celular) {

        if ($this->Loginempresa_model->check_dados_empresa($empresa, $celular) == FALSE) {
            $this->form_validation->set_message('valid_empresa', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function valid_senha($senha, $celular) {

        if ($this->Loginempresa_model->check_dados_celular($senha, $celular) == FALSE) {
            $this->form_validation->set_message('valid_senha', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }	
}
