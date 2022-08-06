<?php
	
#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_pag extends CI_Controller {

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

	public function agendamentos_pag() {

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
            'idApp_Consulta',
			'NomeUsuario',
			'idApp_Cliente',
			'idApp_ClientePet',
			'idApp_ClientePet2',
			'idApp_ClienteDep',
			'idApp_ClienteDep2',
            'DataInicio',
            'DataFim',		
            'Ordenamento',
            'Campo',
			'Recorrencia',
			'Tipo',
			'Agrupar',
			'Repeticao',
        ), TRUE));

		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Lista de Agendamentos';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio_pag/agendamentos_pag';
		$data['panel'] = 'info';
		$data['Data'] = 'Data';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'ConsultaPrint/imprimirlista/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Consulta/alterar/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/agendamentos/';	

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {

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
			$config['total_rows'] = $this->Relatorio_model->list_agendamentos(FALSE, TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_agendamentos(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list1'] = $this->load->view('relatorio/list_agendamentos', $data, TRUE);
        }

        $this->load->view('relatorio/tela_agendamentos', $data);

        $this->load->view('basico/footer');

    }

	public function ultimopedido_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
			'Whatsapp',
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
			'DiaAniv',
			'MesAniv',
			'AnoAniv',
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
			'Texto1',
			'Texto2',
			'Texto3',
			'Texto4',
			'nomedoCliente',
			'idCliente',
			'numerodopedido',
			'site',
        ), TRUE));

        $data['titulo'] = 'Receitas';
		$data['form_open_path'] = 'relatorio_pag/ultimopedido_pag';
		$data['baixatodas'] = 'Orcatrata/baixadasreceitas/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio/receitas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistacliente/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/ultimopedido/';
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        
		if ($this->form_validation->run() !== TRUE) {

			//$this->load->library('pagination');
			$data['pesquisa_query'] = $this->Relatorio_model->list_ultimopedido(FALSE,TRUE, TRUE);
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			//$config['total_rows'] = $this->Relatorio_model->list_ultimopedido(FALSE,TRUE, TRUE);
			$config['base_url'] = base_url() . 'relatorio_pag/ultimopedido_pag/';
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
			
			$data['report'] = $this->Relatorio_model->list_ultimopedido(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();

            $data['list1'] = $this->load->view('relatorio/list_ultimopedido', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_ultimopedido', $data);

        $this->load->view('basico/footer');

    }

	public function vendidos_pag() {

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
            'Orcamento',
            'Cliente',
			'idApp_Cliente',
			'NomeClientePet',
			'NomeClienteDep',
			'idApp_Cliente',
			'idApp_ClientePet',
			'idApp_ClientePet2',
			'idApp_ClienteDep',
			'idApp_ClienteDep2',
			'Fornecedor',
			'idApp_Fornecedor',
			'Produtos',
			'Parcelas',
			'Categoria',
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
			'DataInicio5',
            'DataFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'DataInicio8',
            'DataFim8',
			'HoraInicio8',
            'HoraFim8',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'CombinadoFrete',
			'ConcluidoProduto',
			'Modalidade',
			'Orcarec',
			'Orcades',
			'FormaPagamento',
			'TipoFrete',
			'Prod_Serv_Produto',
			'Agrupar',
			'Ultimo',
			'nome',
        ), TRUE));

		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Vendidos';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio_pag/vendidos_pag';
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 2;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Relatorio_print/cobrancas_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadaprodutorec/';
		$data['alterarprod'] = 'Orcatrata/alterarprodutorec/';
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/vendidos/';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			//$data['report'] = $this->Relatorio_model->list_produtoseservicos($data['bd'],TRUE);

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
			
			$config['base_url'] = base_url() . 'relatorio_pag/vendidos_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_produtoseservicos(FALSE, TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_produtoseservicos(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();

            $data['list1'] = $this->load->view('relatorio/list_produtoseservicos', $data, TRUE);
        }

        $this->load->view('relatorio/tela_produtoseservicos', $data);

        $this->load->view('basico/footer');

    }

    public function proc_receitas_pag() {

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

		$data['query']['TipoProcedimento'] = 2;
		$data['query']['Sac'] = 0;
		$data['query']['Marketing'] = 0;
        $data['titulo1'] = 'Receita';
		$data['tipoproc'] = 2;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio_pag/proc_receitas_pag';
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 0;
		$data['print'] = 0;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Relatorio_print/cobrancas_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/proc_receitas/';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
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
			$config['total_rows'] = $this->Relatorio_model->list_procedimentos(FALSE, TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_procedimentos(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('relatorio/list_procedimentos', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_procedimentos', $data);

        $this->load->view('basico/footer');

    }

    public function proc_despesas_pag() {

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

		$data['query']['TipoProcedimento'] = 1;
		$data['query']['Sac'] = 0;
		$data['query']['Marketing'] = 0;
        $data['titulo1'] = 'Despesa';
		$data['tipoproc'] = 1;
		$data['metodo'] = 1;
		$data['form_open_path'] = 'relatorio_pag/proc_despesas_pag';
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['editar'] = 0;
		$data['print'] = 0;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Relatorio_print/cobrancas_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';
		$data['caminho'] = 'relatorio/proc_despesas/';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

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
			$config['total_rows'] = $this->Relatorio_model->list_procedimentos(FALSE, TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_procedimentos(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();

            $data['list'] = $this->load->view('relatorio/list_procedimentos', $data, TRUE);
        }

        $this->load->view('relatorio/tela_procedimentos', $data);

        $this->load->view('basico/footer');

    }

    public function proc_Sac_pag_original() {

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

		$data['query']['TipoProcedimento'] = 3;
		$data['query']['Marketing'] = 0;
		$data['query']['Fornecedor'] = 0;		
        $data['titulo1'] = 'Sac';
		$data['tipoproc'] = 3;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio_pag/proc_Sac_pag';
		$data['panel'] = 'warning';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 0;
        $data['nome'] = 'Cliente';
		$data['editar'] = 0;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Procedimento/imprimir_lista_Sac/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/proc_Sac/';
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
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
			$config['total_rows'] = $this->Relatorio_model->list_procedimentos(FALSE, TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_procedimentos(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('relatorio/list_procedimentos', $data, TRUE);
        }

        $this->load->view('relatorio/tela_procedimentos', $data);

        $this->load->view('basico/footer');

    }

    public function proc_Marketing_pag_original() {

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

		$data['query']['TipoProcedimento'] = 4;
		$data['query']['Sac'] = 0;
		$data['query']['Fornecedor'] = 0;		
        $data['titulo1'] = 'Marketing';
		$data['tipoproc'] = 4;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio_pag/proc_Marketing_pag';
		$data['panel'] = 'success';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 0;
        $data['nome'] = 'Cliente';
		$data['editar'] = 0;
		$data['print'] = 1;
		$data['imprimir'] = 'Procedimento/imprimir/';
		$data['imprimirlista'] = 'Procedimento/imprimir_lista_Marketing/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/proc_Marketing/';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

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
			$config['total_rows'] = $this->Relatorio_model->list_procedimentos(FALSE, TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_procedimentos(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('relatorio/list_procedimentos', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_procedimentos', $data);

        $this->load->view('basico/footer');

    }

    public function sac_pag() {

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
            'idApp_Sac',
            'CategoriaSac',
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
			'ConcluidoSac',
            'Ordenamento',
            'Campo',
            'TipoSac',
			'Agrupar',
        ), TRUE));		

		$data['query']['TipoSac'] = 3;
		$data['query']['Marketing'] = 0;
		$data['query']['Fornecedor'] = 0;		
        $data['titulo1'] = 'Sac';
		$data['tipoproc'] = 3;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio_pag/sac_pag';
		$data['panel'] = 'warning';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 0;
        $data['nome'] = 'Cliente';
		$data['editar'] = 0;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Sac/imprimir_lista_Sac/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/sac/';
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
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
			
			$config['base_url'] = base_url() . 'relatorio_pag/sac_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_sac(FALSE, TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_sac(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('relatorio/list_sac', $data, TRUE);
        }

        $this->load->view('relatorio/tela_sac', $data);

        $this->load->view('basico/footer');

    }

    public function marketing_pag() {

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
            'idApp_Marketing',
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
			'ConcluidoMarketing',
            'Ordenamento',
            'Campo',
            'TipoMarketing',
			'Agrupar',
        ), TRUE));		

		$data['query']['TipoMarketing'] = 4;
		$data['query']['Sac'] = 0;
		$data['query']['Fornecedor'] = 0;		
        $data['titulo1'] = 'Marketing';
		$data['tipoproc'] = 4;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio_pag/marketing_pag';
		$data['panel'] = 'success';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 0;
        $data['nome'] = 'Cliente';
		$data['editar'] = 0;
		$data['print'] = 1;
		$data['imprimir'] = 'Marketing/imprimir/';
		$data['imprimirlista'] = 'Marketing/imprimir_lista_Marketing/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/marketing/';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

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
			
			$config['base_url'] = base_url() . 'relatorio_pag/marketing_pag/';
			$config['total_rows'] = $this->Relatorio_model->list_marketing(FALSE, TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_marketing(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('relatorio/list_marketing', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_marketing', $data);

        $this->load->view('basico/footer');

    }

	public function rankingvendas_pag() {

		if ($this->input->get('m') == 1)
			$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
		elseif ($this->input->get('m') == 2)
			$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
		else
			$data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
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
				'DataInicio3',
				'DataFim3',
				'Ordenamento',
				'Campo',
				'Pedidos_de',
				'Pedidos_ate',
				'Valor_de',
				'Valor_ate',
				'Valor_cash_de',
				'Valor_cash_ate',
				'Ultimo',
				'Texto1',
				'Texto2',
				'Texto3',
				'Texto4',
				'nomedoCliente',
				'idCliente',
				'numerodopedido',
				'site',
			), TRUE));

			$data['titulo'] = 'Ranking de Vendas';
			$data['form_open_path'] = 'relatorio_pag/rankingvendas_pag';	
			$data['paginacao'] = 'S';
			$data['caminho'] = 'relatorio/rankingvendas/';
			$data['nome'] = 'Cliente';
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			#run form validation
			if ($this->form_validation->run() !== TRUE) {

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
				$config['total_rows'] = $this->Relatorio_model->list_rankingvendas(FALSE, TRUE, TRUE);
			   
				if($config['total_rows'] >= 1){
					$data['total_rows'] = $config['total_rows'];
				}else{
					$data['total_rows'] = 0;
				}
				
				$this->pagination->initialize($config);
				
				$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
				$data['pagina'] = $page;
				$data['per_page'] = $config['per_page'];
				$data['report'] = $this->Relatorio_model->list_rankingvendas(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
				$data['pagination'] = $this->pagination->create_links();
				
				$data['list'] = $this->load->view('relatorio/list_rankingvendas', $data, TRUE);
				//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
			}

			$this->load->view('relatorio/tela_rankingvendas', $data);
		}
		$this->load->view('basico/footer');

	}
	
}