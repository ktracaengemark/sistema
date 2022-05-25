<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Despesas_statico_pag extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array('Basico_model', 'Fornecedor_model', 'Despesas_model', 'Relatorio_model', 'Empresa_model', 'Loginempresa_model'));
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
                $msg = '<h2><strong>Navegador n�o suportado.</strong></h2>';

                echo $this->basico->erro($msg);
                exit();
            }
        }		
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('relatorio/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function despesas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'HoraInicio5',
            'HoraFim5',
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
			'selecione',
        ), TRUE));

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';

        $data['titulo'] = 'Est�tico';
        $data['form_open_path'] = 'Despesas_statico_pag/despesas';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['paginacao'] = 'S';
        $data['despesas'] = 'Despesas_statico';
        
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			$data['report_combinar'] = $this->Despesas_model->list_despesas_combinar(FALSE,TRUE, TRUE);
			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar(FALSE,TRUE, TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao(FALSE,TRUE, TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio(FALSE,TRUE, TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega(FALSE,TRUE, TRUE);
			$data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento(FALSE,TRUE, TRUE);
			
            /*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline(FALSE,TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_combinar_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'HoraInicio5',
            'HoraFim5',
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
			'selecione',
        ), TRUE));

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';

        $data['titulo'] = 'Est�tico';
        $data['form_open_path'] = 'Despesas_statico_pag/despesas_combinar_pag';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['paginacao'] = 'S';
        $data['despesas'] = 'Despesas_statico';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_combinar(FALSE,TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Despesas_model->list_despesas_combinar(FALSE,TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_combinar_pag/';
			$config['per_page'] = 5;
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
	
			$data['report_combinar'] = $this->Despesas_model->list_despesas_combinar(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_combinar'] = $this->load->view('despesas/list_despesas_combinar', $data, TRUE);			

			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar(FALSE,TRUE, TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao(FALSE,TRUE, TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio(FALSE,TRUE, TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega(FALSE,TRUE, TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento(FALSE,TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline(FALSE,TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas_combinar', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_aprovar_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'HoraInicio5',
            'HoraFim5',
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
			'selecione',
        ), TRUE));

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';

        $data['titulo'] = 'Est�tico';
        $data['form_open_path'] = 'Despesas_statico_pag/despesas_aprovar_pag';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['paginacao'] = 'S';
        $data['despesas'] = 'Despesas_statico';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_aprovar(FALSE,TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			
			$config['total_rows'] = $this->Despesas_model->list_despesas_aprovar(FALSE, TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_aprovar_pag/';
			$config['per_page'] = 5;
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
				
			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_aprovar'] = $this->load->view('despesas/list_despesas_aprovar', $data, TRUE);			

			$data['report_combinar'] = $this->Despesas_model->list_despesas_combinar(FALSE,TRUE, TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao(FALSE,TRUE, TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio(FALSE,TRUE, TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega(FALSE,TRUE, TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento(FALSE,TRUE, TRUE);
			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline(FALSE,TRUE);
			*/
        }

        $this->load->view('despesas/tela_despesas_aprovar', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_producao_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'HoraInicio5',
            'HoraFim5',
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
			'selecione',
        ), TRUE));

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';

        $data['titulo'] = 'Est�tico';
        $data['form_open_path'] = 'Despesas_statico_pag/despesas_producao_pag';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['paginacao'] = 'S';
        $data['despesas'] = 'Despesas_statico';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_producao(FALSE,TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Despesas_model->list_despesas_producao(FALSE,TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_producao_pag/';
			$config['per_page'] = 5;
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
	
			$data['report_producao'] = $this->Despesas_model->list_despesas_producao(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_producao'] = $this->load->view('despesas/list_despesas_producao', $data, TRUE);			

			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar(FALSE,TRUE, TRUE);
            $data['report_combinar'] = $this->Despesas_model->list_despesas_combinar(FALSE,TRUE, TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio(FALSE,TRUE, TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega(FALSE,TRUE, TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento(FALSE,TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline(FALSE,TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas_producao', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_envio_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'HoraInicio5',
            'HoraFim5',
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
			'selecione',
        ), TRUE));

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';

        $data['titulo'] = 'Est�tico';
        $data['form_open_path'] = 'Despesas_statico_pag/despesas_envio_pag';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['paginacao'] = 'S';
        $data['despesas'] = 'Despesas_statico';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_envio(FALSE,TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Despesas_model->list_despesas_envio(FALSE,TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_envio_pag/';
			$config['per_page'] = 5;
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
	
			$data['report_envio'] = $this->Despesas_model->list_despesas_envio(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_envio'] = $this->load->view('despesas/list_despesas_envio', $data, TRUE);			

			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar(FALSE,TRUE, TRUE);
            $data['report_combinar'] = $this->Despesas_model->list_despesas_combinar(FALSE,TRUE, TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao(FALSE,TRUE, TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega(FALSE,TRUE, TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento(FALSE,TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline(FALSE,TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas_envio', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_entrega_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'HoraInicio5',
            'HoraFim5',
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
			'selecione',
        ), TRUE));

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';

        $data['titulo'] = 'Est�tico';
        $data['form_open_path'] = 'Despesas_statico_pag/despesas_entrega_pag';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['paginacao'] = 'S';
        $data['despesas'] = 'Despesas_statico';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_entrega(FALSE,TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Despesas_model->list_despesas_entrega(FALSE,TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_entrega_pag/';
			$config['per_page'] = 5;
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
	
			$data['report_entrega'] = $this->Despesas_model->list_despesas_entrega(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_entrega'] = $this->load->view('despesas/list_despesas_entrega', $data, TRUE);			

            $data['report_combinar'] = $this->Despesas_model->list_despesas_combinar(FALSE,TRUE, TRUE);
			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar(FALSE,TRUE, TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao(FALSE,TRUE, TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio(FALSE,TRUE, TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento(FALSE,TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline(FALSE,TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas_entrega', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_pagamento_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'HoraInicio5',
            'HoraFim5',
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
			'selecione',
        ), TRUE));

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';

        $data['titulo'] = 'Est�tico';
        $data['form_open_path'] = 'Despesas_statico_pag/despesas_pagamento_pag';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['paginacao'] = 'S';
        $data['despesas'] = 'Despesas_statico';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_pagamento(FALSE,TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Despesas_model->list_despesas_pagamento(FALSE,TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_pagamento_pag/';
			$config['per_page'] = 5;
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
	
			$data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_pagamento'] = $this->load->view('despesas/list_despesas_pagamento', $data, TRUE);			

            $data['report_combinar'] = $this->Despesas_model->list_despesas_combinar(FALSE,TRUE, TRUE);
			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar(FALSE,TRUE, TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao(FALSE,TRUE, TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio(FALSE,TRUE, TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega(FALSE,TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline(FALSE,TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas_pagamento', $data);

        $this->load->view('basico/footer');
    }

}