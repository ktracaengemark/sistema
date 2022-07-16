<?php
	
#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_pag_print extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Relatorio_model', 'Relatoriocomissoes_model', 'Empresa_model', 'Loginempresa_model'));
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

	public function receitas_pag() {

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
			'idApp_OrcaTrata',
			'idSis_Usuario',
			'DataVencimentoOrca',
			'NomeUsuario',
			'NomeEmpresa',
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
			'HoraInicio5',
            'HoraFim5',
			'TipoFinanceiro',
			'idTab_TipoRD',
			'Ordenamento',
            'Campo',
            'AprovadoOrca',
			'CombinadoFrete',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'Quitado',
			'Modalidade',
			'AVAP',
			'Tipo_Orca',
			'FormaPagamento',
			'TipoFrete',
			'Produtos',
			'Parcelas',
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
		$data['form_open_path'] = 'relatorio_pag_print/receitas_pag';
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
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/receitas/';
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        
		if ($this->form_validation->run() !== TRUE) {

			$config['total_rows'] = $_SESSION['FiltroReceitas']['total_rows'];
			
			$config['base_url'] = base_url() . 'relatorio_pag_print/receitas_pag/';
			$config['per_page'] = 19;
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
			
			$data['linha'] = $page * $config['per_page'];
		
			$_SESSION['FiltroReceitas']['Limit'] = $data['per_page'];
			$_SESSION['FiltroReceitas']['Start'] = $data['linha'];

			$data['report'] = $this->Relatorio_model->list_receitas(FALSE, TRUE, FALSE, $config['per_page'], $data['linha']);
						
			$data['pagination'] = $this->pagination->create_links();

            $data['list1'] = $this->load->view('relatorio_print/list_receitas', $data, TRUE);
        }		

        $this->load->view('relatorio_print/tela_receitas', $data);

        $this->load->view('basico/footer');

    }

	public function despesas_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Fornecedor_Auto',
			'NomeFornecedorAuto',
			'Whatsapp',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'Orcamento',
			'Fornecedor',
			'idApp_Fornecedor',
			'idApp_OrcaTrata',
			'NomeAssociado',
			'idSis_Usuario',
			'DataVencimentoOrca',
			'NomeUsuario',
			'NomeEmpresa',
			'NomeFornecedor',
			'DiaAniv',
			'MesAniv',
			'AnoAniv',
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
			'HoraInicio5',
            'HoraFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'TipoFinanceiro',
			'idTab_TipoRD',
			'Ordenamento',
            'Campo',
            'AprovadoOrca',
			'CombinadoFrete',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'Quitado',
			'Modalidade',
			'AVAP',
			'Tipo_Orca',
			'FormaPagamento',
			'TipoFrete',
			'Produtos',
			'Parcelas',
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
			'nomedoFornecedor',
			'idFornecedor',
			'numerodopedido',
			'site',
        ), TRUE));

        $data['titulo'] = 'Despesas';
		$data['form_open_path'] = 'relatorio_pag_print/despesas_pag';
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
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistadesp/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirrecibodesp/';
		$data['edit'] = 'Orcatrata/alterardesp/';
		$data['alterarparc'] = 'Orcatrata/alterarparceladesp/';	
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/despesas/';		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {


			$config['total_rows'] = $_SESSION['FiltroDespesas']['total_rows'];

			$config['base_url'] = base_url() . 'relatorio_pag_print/despesas_pag/';
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
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            
			$data['pagina'] = $page;
			
			$data['per_page'] = $config['per_page'];
				
			$data['linha'] = $page * $config['per_page'];
		
			$_SESSION['FiltroDespesas']['Limit'] = $data['per_page'];
			$_SESSION['FiltroDespesas']['Start'] = $data['linha'];

			$data['report'] = $this->Relatorio_model->list_despesas(FALSE, TRUE, FALSE, $config['per_page'], $data['linha']);			
			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list1'] = $this->load->view('relatorio_print/list_despesas', $data, TRUE);
        }		

        $this->load->view('relatorio_print/tela_despesas', $data);

        $this->load->view('basico/footer');

    }

	public function alterarreceitas_pag() {

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
			'idApp_OrcaTrata',
			'idSis_Usuario',
			'DataVencimentoOrca',
			'NomeUsuario',
			'NomeEmpresa',
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
			'HoraInicio5',
            'HoraFim5',
			'TipoFinanceiro',
			'idTab_TipoRD',
			'Ordenamento',
            'Campo',
            'AprovadoOrca',
			'CombinadoFrete',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'Quitado',
			'Modalidade',
			'AVAP',
			'Tipo_Orca',
			'FormaPagamento',
			'TipoFrete',
			'Produtos',
			'Parcelas',
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
		$data['form_open_path'] = 'relatorio_pag_print/alterarreceitas_pag';
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
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/alterarreceitas/';
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        
		if ($this->form_validation->run() !== TRUE) {

			$config['total_rows'] = $_SESSION['FiltroReceitas']['total_rows'];
			
			$config['base_url'] = base_url() . 'relatorio_pag_print/alterarreceitas_pag/';
			$config['per_page'] = 19;
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
			
			$data['linha'] = $page * $config['per_page'];
		
			$_SESSION['FiltroReceitas']['Limit'] = $data['per_page'];
			$_SESSION['FiltroReceitas']['Start'] = $data['linha'];

			$data['report'] = $this->Relatorio_model->list_receitas(FALSE, TRUE, FALSE, $config['per_page'], $data['linha']);
						
			$data['pagination'] = $this->pagination->create_links();

            $data['list1'] = $this->load->view('relatorio_print/list_alterarreceitas', $data, TRUE);
        }		

        $this->load->view('relatorio_print/tela_alterarreceitas', $data);

        $this->load->view('basico/footer');

    }
	
}