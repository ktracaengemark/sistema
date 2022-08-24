<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendidos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array(	'Basico_model', 'Cliente_model', 'Vendidos_model', 'Orcatrata_model', 'Relatorio_model', 'Empresa_model', 
									'Loginempresa_model', 'Associado_model', 'Usuario_model', 'Agenda_model'
								));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

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

        $this->load->view('vendidos/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

	public function vendidos() {	
		
		unset($_SESSION['Filtro_Vendidos']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Registro Não Encontrada.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa está muito grande, ela excedeu 15000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
			
		if ($_SESSION['Usuario']['Usu_Rec'] == "N") {

			$data['msg'] = '?m=4';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
				
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
				'idApp_ClientePet',
				'idApp_ClientePet2',
				'idApp_ClienteDep',
				'idApp_ClienteDep2',
				'Produto',
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
				'HoraInicio8',
				'HoraFim8',
				'Ordenamento',
				'Campo',
				'AprovadoOrca',
				'QuitadoOrca',
				'ConcluidoOrca',
				'FinalizadoOrca',
				'CanceladoOrca',
				'CombinadoFrete',
				'ConcluidoProduto',
				'Quitado',
				'Modalidade',
				'FormaPagamento',
				'TipoFrete',
				'Prod_Serv_Produto',
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

			$data['select']['ConcluidoProduto'] = array(
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

			$data['select']['Prod_Serv_Produto'] = array(
				'0' => '::TODOS::',			
				'P' => 'Produtos',
				'S' => 'Servicos',
			);
			
			$data['select']['Ultimo'] = array(
				'0' => '::Nenhum::',			
				#'1' => 'Último Pedido',			
				#'2' => 'Última Parcela',
			);
			
			if($_SESSION['Empresa']['CadastrarPet'] == "S"){
				$data['select']['Agrupar'] = array(
					'PRDS.idApp_Produto' => 'Produto',
					'OT.idApp_OrcaTrata' => 'Orçamento',
					'OT.idApp_ClientePet' => 'Pet',
					'OT.idApp_Cliente' => 'Cliente',
				);
				
				$data['select']['Campo'] = array(
					'TCAT.Catprod' => 'Categoria',
					'PRDS.DataConcluidoProduto' => 'Data da Entr Prd',
					'PRDS.HoraConcluidoProduto' => 'Hora da Entr Prd',
					'PRDS.idApp_Produto' => 'Produto',
					'OT.idApp_OrcaTrata' => 'Orçamento',
					'OT.idApp_ClientePet' => 'Pet',
					'OT.idApp_Cliente' => 'Cliente',
				);
			}elseif($_SESSION['Empresa']['CadastrarDep'] == "S"){
				$data['select']['Agrupar'] = array(
					'PRDS.idApp_Produto' => 'Produto',
					'OT.idApp_OrcaTrata' => 'Orçamento',
					'OT.idApp_ClienteDep' => 'Dependente',
					'OT.idApp_Cliente' => 'Cliente',
				);
				
				$data['select']['Campo'] = array(
					'TCAT.Catprod' => 'Categoria',
					'PRDS.DataConcluidoProduto' => 'Data da Entr Prd',
					'PRDS.HoraConcluidoProduto' => 'Hora da Entr Prd',
					'PRDS.idApp_Produto' => 'Produto',
					'OT.idApp_OrcaTrata' => 'Orçamento',
					'OT.idApp_ClienteDep' => 'Dependente',
					'OT.idApp_Cliente' => 'Cliente',
				);
			}else{
				$data['select']['Agrupar'] = array(			
					'PRDS.idApp_Produto' => 'Produto',
					'OT.idApp_OrcaTrata' => 'Orçamento',
					'OT.idApp_Cliente' => 'Cliente',
				);
				
				$data['select']['Campo'] = array(
					'TCAT.Catprod' => 'Categoria',
					'PRDS.DataConcluidoProduto' => 'Data da Entr Prd',
					'PRDS.HoraConcluidoProduto' => 'Hora da Entr Prd',
					'PRDS.idApp_Produto' => 'Produto',
					'OT.idApp_OrcaTrata' => 'Orçamento',
					'OT.idApp_Cliente' => 'Cliente',
				);
			}

			$data['select']['Ordenamento'] = array(
				'ASC' => 'Crescente',
				'DESC' => 'Decrescente',
			);
			
			$data['select']['Produtos'] = array(
				'0' => '::TODOS::',
				' = ' . $_SESSION['log']['idSis_Empresa'] . '' => 'C/ Prd & Srv',
				'IS NULL' => 'S/ Prd & Srv',
			);

			$data['select']['Parcelas'] = array(
				'0' => '::TODOS::',
				' = ' . $_SESSION['log']['idSis_Empresa'] . '' => 'C/ Parcelas',
				'IS NULL' => 'S/ Parcelas',
			);

			$data['select']['Produto'] = $this->Relatorio_model->select_produtos();
			$data['select']['Categoria'] = $this->Relatorio_model->select_catprod();
			$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
			$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
			$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
			
			$data['query']['nome'] = 'Cliente';
			$data['titulo1'] = 'Vendidos';
			$data['metodo'] = 2;
			$data['form_open_path'] = 'Vendidos/vendidos';
			$data['panel'] = 'info';
			$data['TipoFinanceiro'] = 'Receitas';
			$data['TipoRD'] = 2;
			$data['nome'] = 'Cliente';
			$data['editar'] = 2;
			$data['print'] = 1;
			$data['imprimir'] = 'OrcatrataPrint/imprimir/';
			$data['imprimirlista'] = 'Relatorio_print/cobrancas_lista/';
			$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
			$data['edit'] = 'Vendidos/vendido_baixa/';
			$data['alterarprod'] = 'Vendidos/vendidos_baixa/';
			$data['paginacao'] = 'N';

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
			$this->form_validation->set_rules('DataInicio', 'Data Início do Pedido', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio3', 'Data Início do Vencimento', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio4', 'Data Início do Vencimento', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim4', 'Data Fim do Vencimento', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio5', 'Data Início do Pag Comissao', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio6', 'Data Início do Cadastro', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio8', 'Data Início Entregue Prod', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim8', 'Data Fim Entregue Prod', 'trim|valid_date');		
			$this->form_validation->set_rules('HoraInicio8', 'Hora Inicial', 'trim|valid_hour');		
			$this->form_validation->set_rules('HoraFim8', 'Hora Fim', 'trim|valid_hour');
			
			#run form validation
			if ($this->form_validation->run() !== FALSE) {

				$_SESSION['Filtro_Vendidos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');	
				$_SESSION['Filtro_Vendidos']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataInicio8'] = $this->basico->mascara_data($data['query']['DataInicio8'], 'mysql');
				$_SESSION['Filtro_Vendidos']['DataFim8'] = $this->basico->mascara_data($data['query']['DataFim8'], 'mysql');
				$_SESSION['Filtro_Vendidos']['HoraInicio8'] = $data['query']['HoraInicio8'];
				$_SESSION['Filtro_Vendidos']['HoraFim8'] 	= $data['query']['HoraFim8'];
				$_SESSION['Filtro_Vendidos']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
				$_SESSION['Filtro_Vendidos']['Quitado'] = $data['query']['Quitado'];
				$_SESSION['Filtro_Vendidos']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
				$_SESSION['Filtro_Vendidos']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
				$_SESSION['Filtro_Vendidos']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
				$_SESSION['Filtro_Vendidos']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
				$_SESSION['Filtro_Vendidos']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
				$_SESSION['Filtro_Vendidos']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
				$_SESSION['Filtro_Vendidos']['FormaPagamento'] = $data['query']['FormaPagamento'];
				$_SESSION['Filtro_Vendidos']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
				$_SESSION['Filtro_Vendidos']['AVAP'] = $data['query']['AVAP'];
				$_SESSION['Filtro_Vendidos']['TipoFrete'] = $data['query']['TipoFrete'];
				$_SESSION['Filtro_Vendidos']['Prod_Serv_Produto'] = $data['query']['Prod_Serv_Produto'];
				$_SESSION['Filtro_Vendidos']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
				$_SESSION['Filtro_Vendidos']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
				$_SESSION['Filtro_Vendidos']['Orcamento'] = $data['query']['Orcamento'];
				$_SESSION['Filtro_Vendidos']['Cliente'] = $data['query']['Cliente'];
				$_SESSION['Filtro_Vendidos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
				$_SESSION['Filtro_Vendidos']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
				$_SESSION['Filtro_Vendidos']['idApp_ClientePet2'] = $data['query']['idApp_ClientePet2'];
				$_SESSION['Filtro_Vendidos']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
				$_SESSION['Filtro_Vendidos']['idApp_ClienteDep2'] = $data['query']['idApp_ClienteDep2'];
				$_SESSION['Filtro_Vendidos']['Modalidade'] = $data['query']['Modalidade'];
				$_SESSION['Filtro_Vendidos']['Campo'] = $data['query']['Campo'];
				$_SESSION['Filtro_Vendidos']['Ordenamento'] = $data['query']['Ordenamento'];
				$_SESSION['Filtro_Vendidos']['Produto'] = $data['query']['Produto'];
				$_SESSION['Filtro_Vendidos']['Produtos'] = $data['query']['Produtos'];
				$_SESSION['Filtro_Vendidos']['Parcelas'] = $data['query']['Parcelas'];
				$_SESSION['Filtro_Vendidos']['Categoria'] = $data['query']['Categoria'];
				$_SESSION['Filtro_Vendidos']['Agrupar'] = $data['query']['Agrupar'];
				
				$data['pesquisa_query'] = $this->Vendidos_model->list_vendidos($_SESSION['Filtro_Vendidos'],FALSE , TRUE, FALSE ,FALSE ,FALSE );
				
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'Vendidos/vendidos' . $data['msg']);
					exit();
				}else{

					//$config['total_rows'] = $this->Vendidos_model->list_vendidos($_SESSION['Filtro_Vendidos'],TRUE, TRUE);

					$config['total_rows'] = $data['pesquisa_query']->num_rows();
					$config['base_url'] = base_url() . 'Vendidos/vendidos_pag/';
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
					$data['report'] = $this->Vendidos_model->list_vendidos($_SESSION['Filtro_Vendidos'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']), FALSE);			
					$data['pagination'] = $this->pagination->create_links();

					$data['list1'] = $this->load->view('vendidos/list_vendidos', $data, TRUE);
				}
			}
		}
		$this->load->view('vendidos/tela_vendidos', $data);

        $this->load->view('basico/footer');

    }

	public function vendidos_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Vendidos';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'Vendidos/vendidos_pag';
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 2;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Relatorio_print/cobrancas_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Vendidos/vendido_baixa/';
		$data['alterarprod'] = 'Vendidos/vendidos_baixa/';
		$data['paginacao'] = 'S';
		$data['caminho'] = 'Vendidos/vendidos/';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			
			$data['pesquisa_query'] = $this->Vendidos_model->list_vendidos($_SESSION['Filtro_Vendidos'],FALSE , TRUE, FALSE ,FALSE ,FALSE );
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'Vendidos/vendidos' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();
				$config['base_url'] = base_url() . 'Vendidos/vendidos_pag/';
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
				$data['report'] = $this->Vendidos_model->list_vendidos($_SESSION['Filtro_Vendidos'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']), FALSE);			
				$data['pagination'] = $this->pagination->create_links();

				$data['list1'] = $this->load->view('vendidos/list_vendidos', $data, TRUE);
			}
		}

        $this->load->view('vendidos/tela_vendidos', $data);

        $this->load->view('basico/footer');

    }

    public function vendidos_baixa($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
		}else{

			$data['query'] = quotes_to_entities($this->input->post(array(
				'NomeCliente',			
				'Entregues',
				'Devolvidos',
				'Cadastrar',
			), TRUE));

			$data['empresa'] = quotes_to_entities($this->input->post(array(
				'idSis_Empresa',
			), TRUE));

			(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');

			$j = 1;
			for ($i = 1; $i <= $data['count']['PCount']; $i++) {

				if ($this->input->post('idApp_Produto' . $i)) {
					$data['produto'][$j]['idApp_Produto'] = $this->input->post('idApp_Produto' . $i);
					$data['produto'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
					$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
					$data['produto'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoProduto' . $i);
					
					(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
					);
					($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';
					
					$j++;
				}
			}
			$data['count']['PCount'] = $j - 1;

			if ($id) {
				
				#### Sis_Empresa ####
				$data['empresa'] = $this->Orcatrata_model->get_orcatrataalterar($id);
			
				if($data['empresa'] === FALSE){
					
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}else{

					$data['pesquisa_query'] = $this->Vendidos_model->list_vendidos($_SESSION['Filtro_Vendidos'], TRUE, TRUE, FALSE, FALSE, FALSE);

					if($data['pesquisa_query'] === FALSE){
						
						$data['msg'] = '?m=4';
						redirect(base_url() . 'Vendidos/vendidos' . $data['msg']);
						exit();
					}else{
						
						//$config['total_rows'] = $this->Vendidos_model->get_alterarproduto($id, TRUE);
						
						$config['total_rows'] = $data['pesquisa_query']->num_rows();
						
						$config['base_url'] = base_url() . 'Vendidos/vendidos_baixa/' . $id . '/';

						$config['per_page'] = 12;
						$config["uri_segment"] = 4;
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
						
						if($config['total_rows'] >= 1){
							$_SESSION['Filtro_Vendidos']['Total_Rows'] = $data['total_rows'] = $config['total_rows'];
						}else{
							$_SESSION['Filtro_Vendidos']['Total_Rows'] = $data['total_rows'] = 0;
						}
						
						$this->pagination->initialize($config);
						
						$_SESSION['Filtro_Vendidos']['Pagina'] = $data['pagina'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
						
						$_SESSION['Filtro_Vendidos']['Per_Page'] = $data['per_page'] = $config['per_page'];
						
						$_SESSION['Filtro_Vendidos']['Pagination'] = $data['pagination'] = $this->pagination->create_links();		

						#### App_Produto ####
						$data['produto'] = $this->Vendidos_model->list_vendidos($_SESSION['Filtro_Vendidos'], TRUE, TRUE, $_SESSION['Filtro_Vendidos']['Per_Page'], ($_SESSION['Filtro_Vendidos']['Pagina'] * $_SESSION['Filtro_Vendidos']['Per_Page']), TRUE);
						 /*
						 echo "<pre>";
						  echo '<br>';
						  print_r($data['produto']);
						  echo "</pre>";
						  exit ();
						  */
						if (count($data['produto']) > 0) {
							$_SESSION['Produto'] = $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
							$data['count']['PCount'] = count($data['produto']);

							if (isset($data['produto'])) {

								for($j=1;$j<=$data['count']['PCount'];$j++) {
									$_SESSION['Produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
									$_SESSION['Produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
									$_SESSION['Produto'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataConcluidoProduto'], 'barras');
									$_SESSION['Produto'][$j]['NomeCliente'] = (strlen($data['produto'][$j]['NomeCliente']) > 12) ? substr($data['produto'][$j]['NomeCliente'], 0, 12) : $data['produto'][$j]['NomeCliente'];

									(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
									$data['radio'] = array(
										'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
									);
									($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';
									
								}
							}
						}
					}	
				}
			}

			if(!$data['empresa']['idSis_Empresa'] || $data['empresa']['idSis_Empresa'] !== $_SESSION['log']['idSis_Empresa']){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}else{

				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
				//$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['Entregues'] = $this->Basico_model->select_status_sn();
				$data['select']['Devolvidos'] = $this->Basico_model->select_status_sn();
				
				$data['titulo'] = 'Vendas';
				$data['form_open_path'] = 'Vendidos/vendidos_baixa';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'info';
				$data['metodo'] = 2;

				$data['collapse'] = '';	
				$data['collapse1'] = 'class="collapse"';		

				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';

				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data);
				  echo "</pre>";
				  exit ();
				*/

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('vendidos/form_vendidos_baixa', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {

						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////

						#### App_Produto ####
						//$data['update']['produto']['anterior'] = $this->Vendidos_model->get_alterarproduto($data['empresa']['idSis_Empresa'], FALSE, $_SESSION['Filtro_Vendidos']['Per_Page'], ($_SESSION['Filtro_Vendidos']['Pagina'] * $_SESSION['Filtro_Vendidos']['Per_Page']));
						$data['update']['produto']['anterior'] = $this->Vendidos_model->list_vendidos($_SESSION['Filtro_Vendidos'], TRUE, TRUE, $_SESSION['Filtro_Vendidos']['Per_Page'], ($_SESSION['Filtro_Vendidos']['Pagina'] * $_SESSION['Filtro_Vendidos']['Per_Page']), TRUE);
						
						if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

							if (isset($data['produto']))
								$data['produto'] = array_values($data['produto']);
							else
								$data['produto'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_Produto');

							$max = count($data['update']['produto']['alterar']);
							for($j=0;$j<$max;$j++) {

								$data['orcatrata_baixa'] = $this->Orcatrata_model->get_orcamento_baixa_produto($data['update']['produto']['alterar'][$j]['idApp_OrcaTrata']);

								$data['update']['produto']['alterar'][$j]['ObsProduto'] = trim(mb_strtoupper($data['update']['produto']['alterar'][$j]['ObsProduto'], 'ISO-8859-1'));
								
								if ($data['query']['Entregues'] == 'S') $data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';

								if ($data['update']['produto']['alterar'][$j]['ConcluidoProduto'] == 'S'){

									$data['orcatrata']['CombinadoFrete'] = "S";
									
									if($data['orcatrata_baixa']['CombinadoFrete'] == "N" && $data['orcatrata_baixa']['CanceladoOrca'] == 'N'){
										$baixa[$j] = 'Dar Baixa';
							
										$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($data['update']['produto']['alterar'][$j]['idApp_OrcaTrata']);
										/*
										echo "<pre>";
										echo '<br>';
										print_r($data['busca']['estoque']['posterior']);
										echo "</pre>";
										*/
										
										if (isset($data['busca']['estoque']['posterior']) && count($data['busca']['estoque']['posterior']) > 0) {
											
											$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
											$max_estoque = count($data['busca']['estoque']['posterior']);
											
											if (isset($data['busca']['estoque']['posterior'])){
												
												for($k=1;$k<=$max_estoque;$k++) {
													
													$data['get']['produto'][$k] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$k]['idTab_Produtos_Produto']);
													
													if($data['get']['produto'][$k]['ContarEstoque'] == "S"){
														
														$qtd_produto[$k]	= ($data['busca']['estoque']['posterior'][$k]['QtdProduto'] * $data['busca']['estoque']['posterior'][$k]['QtdIncrementoProduto']);
														
														$diff_estoque[$k] 	= ($data['get']['produto'][$k]['Estoque'] - $qtd_produto[$k]);
														
														if($diff_estoque[$k] <= 0){
															$estoque[$k] = 0; 
														}else{
															$estoque[$k] = $diff_estoque[$k]; 
														}
														
														$data['alterar']['produto']['posterior'][$k]['Estoque'] = $estoque[$k];
														$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$k], $data['busca']['estoque']['posterior'][$k]['idTab_Produtos_Produto']);
														
														unset($qtd_produto[$k]);
														unset($diff_estoque[$k]);
														unset($estoque[$k]);
													}
													
												}
												
											}
											
										}
										
									}else{
										$baixa[$j] = 'NÃO Dar Baixa';
									}					
								}

								$data['update']['produto']['bd'] = $this->Orcatrata_model->update_produto_id($data['update']['produto']['alterar'][$j], $data['update']['produto']['alterar'][$j]['idApp_Produto']);

								$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['update']['produto']['alterar'][$j]['idApp_OrcaTrata']);

								if (isset($data['update']['produto']['posterior'])){
									
									$max_produto = count($data['update']['produto']['posterior']);
									
									if($max_produto == 0){
										$data['orcatrata']['ConcluidoOrca'] = "S";
										
									}else{
										$data['orcatrata']['ConcluidoOrca'] = "N";
									}
				
								}

								if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata_baixa']['QuitadoOrca'] == 'S'){
									$data['orcatrata']['ProntoOrca'] = "S";
									$data['orcatrata']['EnviadoOrca'] = "S";
									$data['orcatrata']['FinalizadoOrca'] = "S";
								}else{
									$data['orcatrata']['FinalizadoOrca'] = "N";
								}
								
								$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['update']['produto']['alterar'][$j]['idApp_OrcaTrata']);					
								
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['update']['produto']['alterar'][$j]['idApp_Produto']);
								echo '<br>';
								print_r($data['update']['produto']['alterar'][$j]['idApp_OrcaTrata']);
								echo '<br>';
								print_r($max_produto);
								echo '<br>';
								//print_r($baixa[$j]);
								echo '<br>';
								print_r($data['orcatrata']['CombinadoFrete']);
								echo '<br>';
								//print_r($data['orcatrata']['AprovadoOrca']);
								echo '<br>';
								//print_r($data['orcatrata']['ProntoOrca']);
								echo '<br>';
								//print_r($data['orcatrata']['EnviadoOrca']);
								echo '<br>';
								//print_r($data['orcatrata']['QuitadoOrca']);
								echo '<br>';
								print_r($data['orcatrata']['ConcluidoOrca']);
								echo '<br>';
								print_r($data['orcatrata']['FinalizadoOrca']);
								echo '<br>';
								echo "</pre>";
								echo '<br>';
								
								echo "<pre>";
								echo '<br>';
								print_r($data['update']['produto']['posterior']);
								echo "</pre>";
								*/
							
							}
							//exit();
							/*
							if (count($data['update']['produto']['alterar']))
								$data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);
							*/
						}

							$data['msg'] = '?m=1';

							redirect(base_url() . 'Vendidos/vendidos_baixa/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);
							exit();
					}
				}
			}
		}
		$this->load->view('basico/footer');

    }

    public function vendido_baixa($id = FALSE) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
		}else{

			if (!$id) {
				
				$data['msg'] = '?m=2';
				$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

				//$this->basico->erro($msg);
				
				redirect(base_url() . 'Vendidos/vendidos/' . $data['msg']);
				exit();
				
			}else{
			
				if ($this->input->get('m') == 1)
					$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
				elseif ($this->input->get('m') == 2)
					$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
				else
					$data['msg'] = '';
					
				$data['update']['produto']['anterior'] = $this->Orcatrata_model->get_produtos($id);
				
				if ($data['update']['produto']['anterior'] === FALSE || $data['update']['produto']['anterior']['idTab_TipoRD'] != 2 || $data['update']['produto']['anterior']['ConcluidoProduto'] == "S") {
					
					$data['msg'] = '?m=2';
					$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

					//$this->basico->erro($msg);
					
					redirect(base_url() . 'Vendidos/vendidos/' . $data['msg']);
					exit();
					
				}else{
					
					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
							
						$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

						#### App_OrcaTrata ####
						
						$data['titulo'] = 'Baixa do Produto';
						$data['form_open_path'] = 'Vendidos/vendido_baixa';
						$data['readonly'] = '';
						$data['disabled'] = '';
						$data['panel'] = 'info';
						$data['metodo'] = 2;
						
						#run form validation
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						
						#### App_Produto ####

						$data['orcatrata_baixa'] = $this->Orcatrata_model->get_orcamento_baixa_produto($data['update']['produto']['anterior']['idApp_OrcaTrata']);			

						//$data['produto']['DataLanc'] = date('Y-m-d', time());
						$data['produto']['ConcluidoProduto'] = "S";
						
						$data['update']['produto']['campos'] = array_keys($data['produto']);
						
						$data['update']['produto']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['produto']['anterior'],
							$data['produto'],
							$data['update']['produto']['campos'],
							$id, 
						TRUE);
						
						/*
						echo '<br>';
						echo "<pre>";
						print_r($data['update']['produto']['anterior']['idApp_OrcaTrata']);
						echo '<br>';
						print_r($data['orcatrata']);
						echo '<br>';
						print_r($data['produto']);
						echo "</pre>";			
						exit();
						*/
						
						$data['update']['produto']['bd'] = $this->Orcatrata_model->update_produto_id($data['produto'], $id);
						
						$data['orcatrata']['CombinadoFrete'] = "S";
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['update']['produto']['anterior']['idApp_OrcaTrata']);
						
						if (isset($data['update']['produto']['posterior'])){
							
							$max_produto = count($data['update']['produto']['posterior']);
							
							if($max_produto == 0){
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
								$data['orcatrata']['ConcluidoOrca'] = "S";
							}else{
								$data['orcatrata']['ConcluidoOrca'] = "N";
							}	
						}
						
						if($data['orcatrata_baixa']['CombinadoFrete'] == "N" && $data['orcatrata_baixa']['CanceladoOrca'] == "N"){
						
							$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($data['update']['produto']['anterior']['idApp_OrcaTrata']);
							/*
							echo "<pre>";
							echo '<br>';
							print_r($data['busca']['estoque']['posterior']);
							echo "</pre>";
							*/
							
							if (isset($data['busca']['estoque']['posterior']) && count($data['busca']['estoque']['posterior']) > 0) {
								
								$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
								$max_estoque = count($data['busca']['estoque']['posterior']);
								
								if (isset($data['busca']['estoque']['posterior'])){
									
									for($k=1;$k<=$max_estoque;$k++) {
										
										$data['get']['produto'][$k] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$k]['idTab_Produtos_Produto']);
										
										if($data['get']['produto'][$k]['ContarEstoque'] == "S"){
											
											$qtd_produto[$k]	= ($data['busca']['estoque']['posterior'][$k]['QtdProduto'] * $data['busca']['estoque']['posterior'][$k]['QtdIncrementoProduto']);
											
											$diff_estoque[$k] 	= ($data['get']['produto'][$k]['Estoque'] - $qtd_produto[$k]);
											
											if($diff_estoque[$k] <= 0){
												$estoque[$k] = 0; 
											}else{
												$estoque[$k] = $diff_estoque[$k]; 
											}
											
											$data['alterar']['produto']['posterior'][$k]['Estoque'] = $estoque[$k];
											$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$k], $data['busca']['estoque']['posterior'][$k]['idTab_Produtos_Produto']);
											
											unset($qtd_produto[$k]);
											unset($diff_estoque[$k]);
											unset($estoque[$k]);
										}
									}
								}
							}
						}			

						if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata_baixa']['QuitadoOrca'] == 'S'){
							
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
							$data['orcatrata']['FinalizadoOrca'] = "S";
						
							#### App_Procedimento ####
							$data['update']['procedimento']['alterar'] = $this->Orcatrata_model->get_procedimento_posterior($data['update']['produto']['anterior']['idApp_OrcaTrata']);
							if (isset($data['update']['procedimento']['alterar'])){
							
								$max = count($data['update']['procedimento']['alterar']);
								for($j=0;$j<$max;$j++) {
									$data['update']['procedimento']['alterar'][$j]['ConcluidoProcedimento'] = 'S';				
								}
								if (count($data['update']['procedimento']['alterar']))
									$data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

							}
						
						}else{
							$data['orcatrata']['FinalizadoOrca'] = "N";
						}			
						
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['update']['produto']['anterior']['idApp_OrcaTrata']);			

						$data['msg'] = '?m=1';

						redirect(base_url() . 'Vendidos/vendidos/' . $data['msg']);
						exit();
					}
				}
			}
        }
		$this->load->view('basico/footer');

    }
	
}