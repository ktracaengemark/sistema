<?php
	
#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatoriocomissoes extends CI_Controller {

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

	public function porservicos() {
		
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
			'Funcionario',
			'Produtos',
			'Categoria',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'idTab_TipoRD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
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
			'ConcluidoProduto',
			'StatusComissaoServico',
			'Modalidade',
			'Orcarec',
			'Orcades',
			'FormaPagamento',
			'TipoFrete',
			'Agrupar',
			'Ultimo',
			'nome',
			'RecorrenciaOrca',
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
			'S' => 'Aprovado',
			'N' => 'Não Aprovado',
        );

        $data['select']['QuitadoOrca'] = array(
			'0' => '::TODOS::',            
			'S' => 'Pago',
            'N' => 'Não Pago',
        );

		$data['select']['ConcluidoOrca'] = array(
			'0' => '::TODOS::',            
			'S' => 'Entregues',
            'N' => 'Não Entregues',
        );

		$data['select']['FinalizadoOrca'] = array(
			'0' => '::TODOS::',            
			'S' => 'Finalizado',
            'N' => 'Não Finalizado',
        );

		$data['select']['CanceladoOrca'] = array(
			'0' => '::TODOS::',            
			'S' => 'Cancelado',
            'N' => 'Não Cancelado',
        );

		$data['select']['CombinadoFrete'] = array(
			'0' => '::TODOS::',            
			'S' => 'Combinado',
            'N' => 'Não Combinado',
        );

		$data['select']['ConcluidoProduto'] = array(
			'0' => '::TODOS::',			
			'S' => 'Entregue',
			'N' => 'NÃO Entregue',
        );

		$data['select']['StatusComissaoServico'] = array(
			'0' => '::TODOS::',			
			'S' => 'Paga',
			'N' => 'NÃO Paga',
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
            'OT.idApp_OrcaTrata' => 'Nº Pedido',
			'PRDS.DataConcluidoProduto' => 'Dta Entrega Serviço',
			'OT.Modalidade' => 'Modalidade',
			'OT.TipoFinanceiro' => 'Tipo',
			'OT.Tipo_Orca' => 'Compra',
			'OT.TipoFrete' => 'Tipo de Entrega',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		//$data['select']['Funcionario'] = $this->Relatoriocomissoes_model->select_funcao();
		$data['select']['Funcionario'] = $this->Relatoriocomissoes_model->select_funcionario();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Categoria'] = $this->Relatorio_model->select_catprod();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		
		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Vendidos';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatoriocomissoes/porservicos';
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
		$data['baixacomissao'] = 'Orcatrata/baixadacomissaoservico/';
		$data['paginacao'] = 'N';
		
        $_SESSION['FiltroAlteraParcela']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['DataInicio8'] = $this->basico->mascara_data($data['query']['DataInicio8'], 'mysql');
		$_SESSION['FiltroAlteraParcela']['DataFim8'] = $this->basico->mascara_data($data['query']['DataFim8'], 'mysql');
        $_SESSION['FiltroAlteraParcela']['ObsOrca'] = $data['query']['ObsOrca'];
		$_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroAlteraParcela']['StatusComissaoServico'] = $data['query']['StatusComissaoServico'];
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
		$_SESSION['FiltroAlteraParcela']['Funcionario'] = $data['query']['Funcionario'];
		$_SESSION['FiltroAlteraParcela']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroAlteraParcela']['Produtos'] = $data['query']['Produtos'];
		$_SESSION['FiltroAlteraParcela']['Categoria'] = $data['query']['Categoria'];
		$_SESSION['FiltroAlteraParcela']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroAlteraParcela']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroAlteraParcela']['nome'] = $data['query']['nome'];
		$_SESSION['FiltroAlteraParcela']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['FiltroAlteraParcela']['Ultimo'] = $data['query']['Ultimo'];
		$_SESSION['FiltroAlteraParcela']['metodo'] = $data['metodo'];
		$_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] = $data['TipoRD'];
		$_SESSION['FiltroAlteraParcela']['RecorrenciaOrca'] = $data['query']['RecorrenciaOrca'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com Ini', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com Fim', 'trim|valid_date');
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
            //$data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
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
			$data['bd']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$data['bd']['StatusComissaoServico'] = $data['query']['StatusComissaoServico'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
            $data['bd']['Funcionario'] = $data['query']['Funcionario'];
			$data['bd']['metodo'] = $data['metodo'];
            $data['bd']['idTab_TipoRD'] = $data['TipoRD'];
			$data['bd']['RecorrenciaOrca'] = $data['query']['RecorrenciaOrca'];
			
			//$data['report'] = $this->Relatoriocomissoes_model->list_porservicos($data['bd'],TRUE);
			$data['pesquisa_query'] = $this->Relatoriocomissoes_model->list_porservicos($data['bd'],TRUE, TRUE);
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			//$config['total_rows'] = $this->Relatoriocomissoes_model->list_porservicos($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'relatorio_pag/porservicos_pag/';
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
			
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatoriocomissoes_model->list_porservicos($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list1'] = $this->load->view('relatoriocomissoes/list_porservicos', $data, TRUE);
        }

        $this->load->view('relatoriocomissoes/tela_porservicos', $data);

        $this->load->view('basico/footer');

    }
		
}
