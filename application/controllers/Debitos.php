<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Debitos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array( 	'Basico_model', 'Cliente_model', 'Relatorio_model', 'Debitos_model', 'Orcatrata_model',  'Empresa_model', 
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

        $this->load->view('Debitos/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

	public function debitos() {
		
		unset($_SESSION['FiltroDebitos']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Registro Não Encontrada.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa está muito grande, ela excedeu 12000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Fornecedor_Auto',
			'NomeFornecedorAuto',
        ), TRUE));	
		
        $data['query'] = quotes_to_entities($this->input->post(array(
            'Orcamento',
            'Fornecedor',
            'idApp_Fornecedor',
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
			'HoraInicio5',
            'HoraFim5',
			'DataInicio6',
            'DataFim6',
			'DataInicio7',
            'DataFim7',
			'DataInicio8',
            'DataFim8',
			'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'CombinadoFrete',
			'Quitado',
			'ConcluidoProduto',
			'Modalidade',
			'FormaPagamento',
			'TipoFrete',
			'Agrupar',
			'Produtos',
			'Parcelas',
			'Ultimo',
			'nome',
			'Texto1',
			'Texto2',
			'Texto3',
			'Texto4',
			'nomedoFornecedor',
			'numerodopedido',
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

		$data['select']['ConcluidoProduto'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'Não',
        );
				
        $data['select']['Agrupar'] = array(
			'PR.idApp_Parcelas' => 'Parcelas',			
			'OT.idApp_OrcaTrata' => 'Orçamentos',
			'OT.idApp_Fornecedor' => 'Fornecedors',
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

        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			#'1' => 'Último Pedido',			
			#'2' => 'Última Parcela',
        );

		if($_SESSION['log']['idSis_Empresa'] != 5){
			$data['select']['Campo'] = array(
				'OT.idApp_OrcaTrata' => 'id do Orçamento',
				'OT.DataOrca' => 'Data do Orcamento',
				'OT.DataEntregaOrca' => 'Data da Entrega',
				'PR.Quitado' => 'Parc.Quit.',
				'PR.DataVencimento' => 'Data do Venc.',
				'PR.DataPago' => 'Data do Pag.',
				'PR.DataLanc' => 'Data do Lanc.',
				'OT.Modalidade' => 'Modalidade',
				'OT.ValorOrca' => 'Valor',
				'OT.TipoFinanceiro' => 'Tipo',
				'OT.Tipo_Orca' => 'Compra',
				'OT.TipoFrete' => 'Entrega',
				'C.idApp_Fornecedor' => 'id do Fornecedor',
				'C.NomeFornecedor' => 'Nome do Fornecedor',	
				
			);
		}else{
			$data['select']['Campo'] = array(
				'OT.idApp_OrcaTrata' => 'id do Orçamento',
				'OT.DataOrca' => 'Data do Orcamento',
				'OT.DataEntregaOrca' => 'Data da Entrega',
				'PR.Quitado' => 'Parc.Quit.',
				'PR.DataVencimento' => 'Data do Venc.',
				'PR.DataPago' => 'Data do Pag.',
				'PR.DataLanc' => 'Data do Lanc.',
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

		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		
        $data['select']['nomedoFornecedor'] = $this->Basico_model->select_status_sn();
        $data['select']['numerodopedido'] = $this->Basico_model->select_status_sn();
		
 		(!$data['query']['nomedoFornecedor']) ? $data['query']['nomedoFornecedor'] = 'N' : FALSE;
		$data['radio'] = array(
            'nomedoFornecedor' => $this->basico->radio_checked($data['query']['nomedoFornecedor'], 'nomedoFornecedor', 'NS'),
        );
        ($data['query']['nomedoFornecedor'] == 'S') ?
            $data['div']['nomedoFornecedor'] = '' : $data['div']['nomedoFornecedor'] = 'style="display: none;"';		

 		(!$data['query']['numerodopedido']) ? $data['query']['numerodopedido'] = 'N' : FALSE;
		$data['radio'] = array(
            'numerodopedido' => $this->basico->radio_checked($data['query']['numerodopedido'], 'numerodopedido', 'NS'),
        );
        ($data['query']['numerodopedido'] == 'S') ?
            $data['div']['numerodopedido'] = '' : $data['div']['numerodopedido'] = 'style="display: none;"';		
		
		$data['query']['nome'] = 'Fornecedor';
        $data['titulo1'] = 'Parcelas';
		$data['metodo'] = 1;
		$data['form_open_path'] = 'Debitos/debitos';
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'Debitos/debitos_lista/';
		$data['imprimirrecibo'] = 'Debitos/debitos_recibo/';
		$data['edit'] = 'Debitos/debito_baixa/';
		$data['alterarparc'] = 'Debitos/debitos_baixa/';	
		$data['paginacao'] = 'N';	

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
		$this->form_validation->set_rules('DataInicio8', 'Data Lanc Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim8', 'Data Lanc Com.Fim', 'trim|valid_date');
		$this->form_validation->set_rules('HoraInicio5', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim5', 'Hora Final', 'trim|valid_hour');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

			$_SESSION['FiltroDebitos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$_SESSION['FiltroDebitos']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$_SESSION['FiltroDebitos']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$_SESSION['FiltroDebitos']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$_SESSION['FiltroDebitos']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
			$_SESSION['FiltroDebitos']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$_SESSION['FiltroDebitos']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
			$_SESSION['FiltroDebitos']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$_SESSION['FiltroDebitos']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
			$_SESSION['FiltroDebitos']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$_SESSION['FiltroDebitos']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
			$_SESSION['FiltroDebitos']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$_SESSION['FiltroDebitos']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
			$_SESSION['FiltroDebitos']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$_SESSION['FiltroDebitos']['DataInicio8'] = $this->basico->mascara_data($data['query']['DataInicio8'], 'mysql');
			$_SESSION['FiltroDebitos']['DataFim8'] = $this->basico->mascara_data($data['query']['DataFim8'], 'mysql');
			$_SESSION['FiltroDebitos']['HoraInicio5'] = $data['query']['HoraInicio5'];
			$_SESSION['FiltroDebitos']['HoraFim5'] = $data['query']['HoraFim5'];
			$_SESSION['FiltroDebitos']['Quitado'] = $data['query']['Quitado'];
			$_SESSION['FiltroDebitos']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$_SESSION['FiltroDebitos']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$_SESSION['FiltroDebitos']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$_SESSION['FiltroDebitos']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$_SESSION['FiltroDebitos']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$_SESSION['FiltroDebitos']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$_SESSION['FiltroDebitos']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$_SESSION['FiltroDebitos']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$_SESSION['FiltroDebitos']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$_SESSION['FiltroDebitos']['AVAP'] = $data['query']['AVAP'];
			$_SESSION['FiltroDebitos']['TipoFrete'] = $data['query']['TipoFrete'];
			$_SESSION['FiltroDebitos']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$_SESSION['FiltroDebitos']['Orcamento'] = $data['query']['Orcamento'];
			$_SESSION['FiltroDebitos']['Fornecedor'] = $data['query']['Fornecedor'];
			$_SESSION['FiltroDebitos']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
			$_SESSION['FiltroDebitos']['Modalidade'] = $data['query']['Modalidade'];
			$_SESSION['FiltroDebitos']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroDebitos']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['FiltroDebitos']['metodo'] = $data['metodo'];
			$_SESSION['FiltroDebitos']['idTab_TipoRD'] = $data['TipoRD'];
			$_SESSION['FiltroDebitos']['nome'] = $data['query']['nome'];
			$_SESSION['FiltroDebitos']['Ultimo'] = $data['query']['Ultimo'];
			$_SESSION['FiltroDebitos']['Agrupar'] = $data['query']['Agrupar'];
			$_SESSION['FiltroDebitos']['Produtos'] = $data['query']['Produtos'];
			$_SESSION['FiltroDebitos']['Parcelas'] = $data['query']['Parcelas'];
			
			$data['pesquisa_query'] = $this->Debitos_model->list_debitos($_SESSION['FiltroDebitos'],FALSE, TRUE, FALSE, FALSE, FALSE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'Debitos/debitos' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();

				$config['base_url'] = base_url() . 'Debitos/debitos_pag/';

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

				$data['report'] = $this->Debitos_model->list_debitos($_SESSION['FiltroDebitos'], FALSE, FALSE, $config['per_page'], $data['linha'], FALSE);			
				
				$_SESSION['FiltroDebitos']['Texto1'] = utf8_encode($data['query']['Texto1']);
				$_SESSION['FiltroDebitos']['Texto2'] = utf8_encode($data['query']['Texto2']);
				$_SESSION['FiltroDebitos']['Texto3'] = utf8_encode($data['query']['Texto3']);
				$_SESSION['FiltroDebitos']['Texto4'] = utf8_encode($data['query']['Texto4']);
				$_SESSION['FiltroDebitos']['nomedoFornecedor'] = $data['query']['nomedoFornecedor'];
				$_SESSION['FiltroDebitos']['numerodopedido'] = $data['query']['numerodopedido'];

				$data['pagination'] = $this->pagination->create_links();

				$data['list1'] = $this->load->view('Debitos/list_debitos', $data, TRUE);
			}
        }

        $this->load->view('Debitos/tela_debitos', $data);

        $this->load->view('basico/footer');

    }
	
	public function debitos_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
        $data['titulo1'] = 'Parcelas das Despesas';
		$data['metodo'] = 1;
		$data['form_open_path'] = 'Debitos/debitos_pag';
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'Debitos/debitos_lista/';
		$data['imprimirrecibo'] = 'Debitos/debitos_recibo/';
		$data['edit'] = 'Debitos/debito_baixa/';
		$data['alterarparc'] = 'Debitos/debitos_baixa/';	
		$data['paginacao'] = 'S';
		$data['caminho'] = 'Debitos/debitos/';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #run form validation

		$data['pesquisa_query'] = $this->Debitos_model->list_debitos($_SESSION['FiltroDebitos'],FALSE, TRUE, FALSE, FALSE, FALSE);
		
		if($data['pesquisa_query'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Debitos/debitos' . $data['msg']);
			exit();
		}else{

			$config['base_url'] = base_url() . 'Debitos/debitos_pag/';
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
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
			
			$data['report'] = $this->Debitos_model->list_debitos($_SESSION['FiltroDebitos'], FALSE, FALSE, $config['per_page'], $data['linha'], FALSE);			
			
			$data['pagination'] = $this->pagination->create_links();

            $data['list1'] = $this->load->view('Debitos/list_debitos', $data, TRUE);
       
		}
        $this->load->view('Debitos/tela_debitos', $data);

        $this->load->view('basico/footer');

    }

	public function debitos_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Debitos Sem Filtros';
				$data['metodo'] = $id;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroDebitos'])){
					$dados = $_SESSION['FiltroDebitos'];
					$data['titulo'] = 'Debitos Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Debitos Sem Filtros';
					$data['metodo'] = 1;
				}
			}elseif($id == 3){
				if(isset($_SESSION['FiltroDebitos'])){
					$dados = $_SESSION['FiltroDebitos'];
					$data['titulo'] = 'Debitos Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Debitos Sem Filtros';
					$data['metodo'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Debitos Sem Filtros';
				$data['metodo'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Debitos Sem Filtros';
			$data['metodo'] = 1;
		}

        $data['nome'] = 'Fornecedor';

		$data['report'] = $this->Debitos_model->list_debitos($dados, FALSE, FALSE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Debitos/debitos' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Debitos/list_debitos_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

    public function debitos_lista($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		

		if (!$id) {
			
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			if($_SESSION['log']['idSis_Empresa'] !== $id){
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
					
			}else{			
				
				$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroDebitos']['DataInicio4'], 'barras');
				$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroDebitos']['DataFim4'], 'barras');
		
				$data['pesquisa_query'] = $this->Debitos_model->list_debitos($_SESSION['FiltroDebitos'], FALSE, TRUE, FALSE, FALSE, FALSE);
				
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'Debitos/debitos' . $data['msg']);
					exit();
				}else{

					$config['base_url'] = base_url() . 'Debitos/debitos_lista/' . $id . '/';
					$config['total_rows'] = $data['pesquisa_query']->num_rows();
					$config['per_page'] = 19;
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
						$data['total_rows'] = $config['total_rows'];
					}else{
						$data['total_rows'] = 0;
					}
					
					$this->pagination->initialize($config);
					
					$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
					
					$data['pagina'] = $page;
					
					$data['per_page'] = $config['per_page'];
					
					$data['pagination'] = $this->pagination->create_links();		
						
					#### App_OrcaTrata ####
					$data['orcatrata'] = $this->Debitos_model->list_debitos($_SESSION['FiltroDebitos'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']), TRUE);
					if (count($data['orcatrata']) > 0) {
						$data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
						$data['count']['POCount'] = count($data['orcatrata']);           

						if (isset($data['orcatrata'])) {

							for($i=1;$i<=$data['count']['POCount'];$i++) {

								$data['orcatrata'][$i]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataOrca'], 'barras');
								$data['orcatrata'][$i]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataEntregaOrca'], 'barras');
								$data['orcatrata'][$i]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataVencimentoOrca'], 'barras');
								$data['orcatrata'][$i]['ValorFinalOrca'] = number_format(($data['orcatrata'][$i]['ValorFinalOrca']), 2, ',', '.');
								$data['orcatrata'][$i]['ConcluidoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['ConcluidoOrca'], 'NS');
								$data['orcatrata'][$i]['QuitadoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['QuitadoOrca'], 'NS');
													
								if($data['orcatrata'][$i]['AVAP'] == "V"){
									$data['orcatrata'][$i]['AVAP'] = "NaLoja";
								}elseif($data['orcatrata'][$i]['AVAP'] == "O"){
									$data['orcatrata'][$i]['AVAP'] = "OnLine";
								}elseif($data['orcatrata'][$i]['AVAP'] == "P"){
									$data['orcatrata'][$i]['AVAP'] = "NaEntr";
								}else{
									$data['orcatrata'][$i]['AVAP'] = "Outros";
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['orcatrata'][$i]);
								echo "</pre>";
								*/
								#### App_ProdutoVenda ####
								$data['produto'][$i] = $this->Debitos_model->get_produto($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['produto'][$i]) > 0) {
									$data['produto'][$i] = array_combine(range(1, count($data['produto'][$i])), array_values($data['produto'][$i]));
									$data['count']['PCount'][$i] = count($data['produto'][$i]);

									if (isset($data['produto'][$i])) {

										for($k=1;$k<=$data['count']['PCount'][$i];$k++) {
											$data['produto'][$i][$k]['SubtotalProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto'] * $data['produto'][$i][$k]['QtdProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['ValorProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$i][$k]['DataValidadeProduto'], 'barras');
											$data['produto'][$i][$k]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['ConcluidoProduto'], 'NS');
											$data['produto'][$i][$k]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['DevolvidoProduto'], 'NS');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['produto'][$i]);
								echo "</pre>";
								*/		
								#### App_Parcelas####
								$data['parcelasrec'][$i] = $this->Debitos_model->get_parcelasrec($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['parcelasrec'][$i]) > 0) {
									$data['parcelasrec'][$i] = array_combine(range(1, count($data['parcelasrec'][$i])), array_values($data['parcelasrec'][$i]));
									$data['count']['PRCount'][$i] = count($data['parcelasrec'][$i]);
									
									if (isset($data['parcelasrec'][$i])) {

										for($j=1; $j <= $data['count']['PRCount'][$i]; $j++) {
											$data['parcelasrec'][$i][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataVencimento'], 'barras');
											$data['parcelasrec'][$i][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataPago'], 'barras');
											$data['parcelasrec'][$i][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataLanc'], 'barras');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['parcelasrec'][$i]);
								echo "</pre>";
								*/
								#### App_Procedimento ####
								$data['procedimento'][$i] = $this->Debitos_model->get_procedimento($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['procedimento'][$i]) > 0) {
									$data['procedimento'][$i] = array_combine(range(1, count($data['procedimento'][$i])), array_values($data['procedimento'][$i]));
									$data['count']['PMCount'][$i] = count($data['procedimento'][$i]);

									if (isset($data['procedimento'][$i])) {

										for($j=1; $j <= $data['count']['PMCount'][$i]; $j++){
											$data['procedimento'][$i][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$i][$j]['DataProcedimento'], 'barras');						
										}
									}
								}					
							}
						}	
					}

					$data['titulo'] = 'Versão Lista Débitos';
					$data['form_open_path'] = 'Debitos/debitos_lista';
					$data['panel'] = 'danger';
					$data['metodo'] = 1;
					$data['imprimir'] = 'OrcatrataPrint/imprimir/';
					$data['imprimirlista'] = 'Debitos/debitos_lista/';
					$data['imprimirrecibo'] = 'Debitos/debitos_recibo/';
					
					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$this->load->view('Debitos/print_debitos_lista', $data);
				}
			}	
		}
        $this->load->view('basico/footer');

    }

    public function debitos_recibo($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {
			
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			if($_SESSION['log']['idSis_Empresa'] !== $id){
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
					
			}else{			
						
				$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroDebitos']['DataInicio4'], 'barras');
				$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroDebitos']['DataFim4'], 'barras');
				
				$data['pesquisa_query'] = $this->Debitos_model->list_debitos($_SESSION['FiltroDebitos'], FALSE, TRUE, FALSE, FALSE, FALSE);
				
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'Debitos/debitos' . $data['msg']);
					exit();
				}else{

					$config['base_url'] = base_url() . 'Debitos/debitos_recibo/' . $id . '/';
					$config['total_rows'] = $data['pesquisa_query']->num_rows();
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
						$data['total_rows'] = $config['total_rows'];
					}else{
						$data['total_rows'] = 0;
					}
					
					$this->pagination->initialize($config);
					
					$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
					
					$data['pagina'] = $page;
					
					$data['per_page'] = $config['per_page'];
					
					$data['pagination'] = $this->pagination->create_links();		

					#### App_OrcaTrata ####
					$data['orcatrata'] = $this->Debitos_model->list_debitos($_SESSION['FiltroDebitos'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']), TRUE);
					if (count($data['orcatrata']) > 0) {
						$data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
						$data['count']['POCount'] = count($data['orcatrata']);           

						if (isset($data['orcatrata'])) {

							for($i=1;$i<=$data['count']['POCount'];$i++) {

								$data['orcatrata'][$i]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataOrca'], 'barras');
								$data['orcatrata'][$i]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataEntregaOrca'], 'barras');
								$data['orcatrata'][$i]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataVencimentoOrca'], 'barras');
								$data['orcatrata'][$i]['ValorFinalOrca'] = number_format(($data['orcatrata'][$i]['ValorFinalOrca']), 2, ',', '.');
								$data['orcatrata'][$i]['ConcluidoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['ConcluidoOrca'], 'NS');
								$data['orcatrata'][$i]['QuitadoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['QuitadoOrca'], 'NS');
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['orcatrata'][$i]);
								echo "</pre>";
								*/
								#### App_ProdutoVenda ####
								$data['produto'][$i] = $this->Debitos_model->get_produto($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['produto'][$i]) > 0) {
									$data['produto'][$i] = array_combine(range(1, count($data['produto'][$i])), array_values($data['produto'][$i]));
									$data['count']['PCount'][$i] = count($data['produto'][$i]);

									if (isset($data['produto'][$i])) {

										for($k=1;$k<=$data['count']['PCount'][$i];$k++) {
											$data['produto'][$i][$k]['SubtotalProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto'] * $data['produto'][$i][$k]['QtdProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['ValorProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$i][$k]['DataValidadeProduto'], 'barras');
											$data['produto'][$i][$k]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['ConcluidoProduto'], 'NS');
											$data['produto'][$i][$k]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['DevolvidoProduto'], 'NS');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['produto'][$i]);
								echo "</pre>";
								*/		
								#### App_Parcelas####
								$data['parcelasrec'][$i] = $this->Debitos_model->get_parcelasrec($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['parcelasrec'][$i]) > 0) {
									$data['parcelasrec'][$i] = array_combine(range(1, count($data['parcelasrec'][$i])), array_values($data['parcelasrec'][$i]));
									$data['count']['PRCount'][$i] = count($data['parcelasrec'][$i]);
									
									if (isset($data['parcelasrec'][$i])) {

										for($j=1; $j <= $data['count']['PRCount'][$i]; $j++) {
											$data['parcelasrec'][$i][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataVencimento'], 'barras');
											$data['parcelasrec'][$i][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataPago'], 'barras');
											$data['parcelasrec'][$i][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataLanc'], 'barras');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['parcelasrec'][$i]);
								echo "</pre>";
								*/
								#### App_Procedimento ####
								$data['procedimento'][$i] = $this->Debitos_model->get_procedimento($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['procedimento'][$i]) > 0) {
									$data['procedimento'][$i] = array_combine(range(1, count($data['procedimento'][$i])), array_values($data['procedimento'][$i]));
									$data['count']['PMCount'][$i] = count($data['procedimento'][$i]);

									if (isset($data['procedimento'][$i])) {

										for($j=1; $j <= $data['count']['PMCount'][$i]; $j++){
											$data['procedimento'][$i][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$i][$j]['DataProcedimento'], 'barras');						
										}
									}
								}						
								
							}
						}	
					}

					$data['titulo'] = 'Versão Recibo Debito';
					$data['form_open_path'] = 'Debitos/debitos_recibo';
					$data['panel'] = 'danger';
					$data['metodo'] = 1;
					$data['imprimir'] = 'OrcatrataPrint/imprimir/';
					$data['imprimirlista'] = 'Debitos/debitos_lista/';
					$data['imprimirrecibo'] = 'Debitos/debitos_recibo/';		
					

					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$this->load->view('Debitos/print_debitos_recibo', $data);			
				}
			}
		}
        $this->load->view('basico/footer');

    }
	
    public function debitos_baixa($id = FALSE) {

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
				'QuitadoParcelas',
				'MostrarDataPagamento',
				'DataPagamento',
			), TRUE));
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['empresa'] = quotes_to_entities($this->input->post(array(
				#### Sis_Empresa ####
				'idSis_Empresa',
				
			), TRUE));

			//(!$data['query']['DataPagamento']) ? $data['query']['DataPagamento'] = date('d/m/Y', time()) : FALSE;
			(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');

			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				if ($this->input->post('idApp_Parcelas' . $i)) {
					$data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
					$data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					$data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
					$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
					$data['parcelasrec'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
					
					(!$data['parcelasrec'][$j]['Quitado']) ? $data['parcelasrec'][$j]['Quitado'] = 'N' : FALSE;
					$data['radio'] = array(
						'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
					);
					($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';				

					$j++;
				}
			}
			$data['count']['PRCount'] = $j - 1;

			$data['Pesquisa'] = '';		

			if ($id) {
				
				#### Sis_Empresa ####
				$data['empresa'] = $this->Orcatrata_model->get_orcatrataalterar($id);
			
				if($data['empresa'] === FALSE){
					
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}else{
						
					$data['pesquisa_query'] = $this->Debitos_model->list_debitos($_SESSION['FiltroDebitos'], TRUE, TRUE, FALSE, FALSE, FALSE);
					
					if($data['pesquisa_query'] === FALSE){
						
						$data['msg'] = '?m=4';
						redirect(base_url() . 'debitos/debitos' . $data['msg']);
						exit();
					}else{

						
						$config['base_url'] = base_url() . 'Debitos/debitos_baixa/' . $id . '/';
						$config['total_rows'] = $data['pesquisa_query']->num_rows();
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
							$_SESSION['Total_Rows'] = $data['total_rows'] = $config['total_rows'];
						}else{
							$_SESSION['Total_Rows'] = $data['total_rows'] = 0;
						}
						
						$this->pagination->initialize($config);
						
						$_SESSION['Pagina'] = $data['pagina'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
						$_SESSION['Per_Page'] = $data['per_page'] = $config['per_page'];
						
						$_SESSION['Pagination'] = $data['pagination'] = $this->pagination->create_links();		

						#### App_Parcelas ####
						$_SESSION['Parcelasrec'] = $data['parcelasrec'] = $this->Debitos_model->list_debitos($_SESSION['FiltroDebitos'], TRUE, TRUE, $_SESSION['Per_Page'], ($_SESSION['Pagina'] * $_SESSION['Per_Page']), TRUE);
						if (count($data['parcelasrec']) > 0) {
							$data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
							$data['count']['PRCount'] = count($data['parcelasrec']);
							
							if (isset($data['parcelasrec'])) {

								for($j=1; $j <= $data['count']['PRCount']; $j++) {
									
									$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
									$data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
									
									if($data['parcelasrec'][$j]['Modalidade'] == "P"){
										$_SESSION['Parcelasrec'][$j]['Tipo'] = 'Dividido';
										$_SESSION['Parcelasrec'][$j]['readonly'] = 'readonly=""';
									}elseif($data['parcelasrec'][$j]['Modalidade'] == "M"){
										$_SESSION['Parcelasrec'][$j]['Tipo'] = 'Mensal';
										$_SESSION['Parcelasrec'][$j]['readonly'] = '';
									}

									$_SESSION['Parcelasrec'][$j]['Despesa'] = $data['parcelasrec'][$j]['Despesa'];
									
									$_SESSION['Parcelasrec'][$j]['Parcela'] = $data['parcelasrec'][$j]['Parcela'];
									$_SESSION['Parcelasrec'][$j]['FormaPagamento'] = $data['parcelasrec'][$j]['FormaPagamento'];

									$data['radio'] = array(
										'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
									);
									($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';
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

				$data['select']['QuitadoParcelas'] = $this->Basico_model->select_status_sn();
				$data['select']['MostrarDataPagamento'] = $this->Basico_model->select_status_sn();
				$data['select']['Quitado'] = $this->Basico_model->select_status_sn();		
				
				$data['titulo'] = 'Despesas';
				$data['form_open_path'] = 'Debitos/debitos_baixa';
				$data['readonly'] = 'readonly=""';
				$data['disabled'] = '';
				$data['panel'] = 'danger';
				$data['metodo'] = 1;
				$data['TipoFinanceiro'] = 'Despesas';
				$data['TipoRD'] = 1;
				$data['nome'] = 'Fornecedor';	
				
				$data['collapse'] = '';	
				$data['collapse1'] = 'class="collapse"';		
				
				if ($data['count']['PRCount'] > 0 )
					$data['parcelasin'] = 'in';
				else
					$data['parcelasin'] = '';


				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';

				(!$data['query']['QuitadoParcelas']) ? $data['query']['QuitadoParcelas'] = 'N' : FALSE;
				$data['radio'] = array(
					'QuitadoParcelas' => $this->basico->radio_checked($data['query']['QuitadoParcelas'], 'Quitar Parcelas', 'NS'),
				);
				($data['query']['QuitadoParcelas'] == 'S') ?
					$data['div']['QuitadoParcelas'] = '' : $data['div']['QuitadoParcelas'] = 'style="display: none;"';
				
				(!$data['query']['MostrarDataPagamento']) ? $data['query']['MostrarDataPagamento'] = 'N' : FALSE;
				$data['radio'] = array(
					'MostrarDataPagamento' => $this->basico->radio_checked($data['query']['MostrarDataPagamento'], 'Quitar Parcelas', 'NS'),
				);
				($data['query']['MostrarDataPagamento'] == 'S') ?
					$data['div']['MostrarDataPagamento'] = '' : $data['div']['MostrarDataPagamento'] = 'style="display: none;"';
					
				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data);
				  echo "</pre>";
				  exit ();
				*/
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				#### Sis_Empresa ####
				$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');
				if($data['query']['MostrarDataPagamento'] == 'S'){
					$this->form_validation->set_rules('DataPagamento', 'Data do Pagamento', 'required|trim|valid_date');
				}
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('Debitos/form_debitos_baixa', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
							
						$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
						$data['bd']['MostrarDataPagamento'] = $data['query']['MostrarDataPagamento'];
						$data['bd']['DataPagamento'] = $data['query']['DataPagamento'];
						
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						$_SESSION['Query']['UltimaDataPagamento'] = $data['query']['DataPagamento'];			
						$data['query']['DataPagamento'] = $this->basico->mascara_data($data['query']['DataPagamento'], 'mysql');

						#### App_ParcelasRec ####
						$data['update']['parcelasrec']['anterior'] = $this->Debitos_model->list_debitos($_SESSION['FiltroDebitos'], TRUE, TRUE, $_SESSION['Per_Page'], ($_SESSION['Pagina'] * $_SESSION['Per_Page']), TRUE);
						if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

							if (isset($data['parcelasrec']))
								$data['parcelasrec'] = array_values($data['parcelasrec']);
							else
								$data['parcelasrec'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');
							
							$max = count($data['update']['parcelasrec']['alterar']);
							for($j=0; $j<$max; $j++) {

								//$data['orcatrata'] = $this->Orcatrata_model->get_orcatrata_baixa($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);
								
								if(!$data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'] || $data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'] == "0" || empty($data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'])){
									$data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'] = $_SESSION['Parcelasrec'][$j]['FormaPagamento'];
								}

								if(!$data['update']['parcelasrec']['alterar'][$j]['ValorParcela']  ||  empty($data['update']['parcelasrec']['alterar'][$j]['ValorParcela'])){
									$data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = "0.00";
								}else{
									$data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
								}
								
								if(!$data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] || $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] == "00/00/0000" ||  empty($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'])){
									$data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = "0000-00-00";
								}else{
									$data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
								}                    

								if(!$data['update']['parcelasrec']['alterar'][$j]['DataPago'] || $data['update']['parcelasrec']['alterar'][$j]['DataPago'] == "00/00/0000" ||  empty($data['update']['parcelasrec']['alterar'][$j]['DataPago'])){
									$data['update']['parcelasrec']['alterar'][$j]['DataPago'] == "0000-00-00";
								}else{
									$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
								}                   

								if ($data['query']['QuitadoParcelas'] == 'S') $data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
								
								if ($data['update']['parcelasrec']['alterar'][$j]['Quitado'] == 'S'){
									if(!$data['update']['parcelasrec']['alterar'][$j]['DataPago'] || $data['update']['parcelasrec']['alterar'][$j]['DataPago'] == "0000-00-00"){
										if($data['query']['MostrarDataPagamento'] == 'N'){
											$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'];
										}else{
											$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['query']['DataPagamento'];
										}
									}else{
										$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataPago'];
									}
									$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = date('Y-m-d', time());
								} else {
									$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = "0000-00-00";
									$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = "0000-00-00";
								}
								
								$data['update']['parcelasrec']['bd'] = $this->Orcatrata_model->update_parcelas_id($data['update']['parcelasrec']['alterar'][$j], $data['update']['parcelasrec']['alterar'][$j]['idApp_Parcelas']);

								$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);
								if (isset($data['update']['parcelasrec']['posterior'])){
									$max_parcela = count($data['update']['parcelasrec']['posterior']);
									if($max_parcela == 0){
										$data['orcatrata']['QuitadoOrca'] = "S";
										$data['orcatrata']['AprovadoOrca'] = "S";				
									}else{
										$data['orcatrata']['QuitadoOrca'] = "N";
									}
								}
								
								$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);
								if (isset($data['update']['produto']['posterior'])){
									$max_produto = count($data['update']['produto']['posterior']);
									if($max_produto == 0){
										$data['orcatrata']['CombinadoFrete'] = "S";
										$data['orcatrata']['ProntoOrca'] = "S";
										$data['orcatrata']['EnviadoOrca'] = "S";
										$data['orcatrata']['ConcluidoOrca'] = "S";
									}else{
										$data['orcatrata']['ConcluidoOrca'] = "N";
									}
								}
								
								if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
									$data['orcatrata']['AprovadoOrca'] = "S";
									$data['orcatrata']['FinalizadoOrca'] = "S";
									$data['orcatrata']['CombinadoFrete'] = "S";
									$data['orcatrata']['ProntoOrca'] = "S";
									$data['orcatrata']['EnviadoOrca'] = "S";
								}else{
									$data['orcatrata']['FinalizadoOrca'] = "N";
								}					
								
								$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);					
								
							}	
							
						}
						
						$data['msg'] = '?m=1';
						redirect(base_url() . 'Debitos/debitos_baixa/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

						exit();
					}
				}
			}
		}
        $this->load->view('basico/footer');

    }

    public function debito_baixa($id = FALSE) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
		}else{

			if (!$id) {
				
				$data['msg'] = '?m=2';
				$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

				//$this->basico->erro($msg);
				
				redirect(base_url() . 'relatorio/debitos/' . $data['msg']);
				exit();
				
			}else{
			
				if ($this->input->get('m') == 1)
					$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
				elseif ($this->input->get('m') == 2)
					$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
				else
					$data['msg'] = '';
				
				$data['update']['parcela']['anterior'] = $this->Orcatrata_model->get_parcela($id);
				
				if ($data['update']['parcela']['anterior'] === FALSE || $data['update']['parcela']['anterior']['idTab_TipoRD'] != 1 || $data['update']['parcela']['anterior']['Quitado'] == "S") {
					
					$data['msg'] = '?m=2';
					$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

					//$this->basico->erro($msg);
					
					redirect(base_url() . 'relatorio/debitos/' . $data['msg']);
					exit();
					
				}else{

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
							
						$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

						#### App_OrcaTrata ####
						
						$data['titulo'] = 'Baixa da Receita';
						$data['form_open_path'] = 'Debitos/debito_baixa';
						$data['readonly'] = '';
						$data['disabled'] = '';
						$data['panel'] = 'info';
						$data['metodo'] = 2;


						$data['id_orcatrata'] = $data['update']['parcela']['anterior']['idApp_OrcaTrata'];
						
						$data['ID_Orcamento'] = $this->Orcatrata_model->get_orcamento_baixa_parcela($data['id_orcatrata']);			
						
						if(!$data['update']['parcela']['anterior']['FormaPagamentoParcela'] || $data['update']['parcela']['anterior']['FormaPagamentoParcela'] == "0" || empty($data['update']['parcela']['anterior']['FormaPagamentoParcela'])){
							$data['parcela']['FormaPagamentoParcela'] = $data['ID_Orcamento']['FormaPagamento'];
						}			
									
						if(!$data['update']['parcela']['anterior']['DataPago'] || $data['update']['parcela']['anterior']['DataPago'] == "0000-00-00" ){
							$data['parcela']['DataPago'] = $data['update']['parcela']['anterior']['DataVencimento'];
						}else{
							$data['parcela']['DataPago'] = $data['update']['parcela']['anterior']['DataPago'];
						}
						$data['parcela']['DataLanc'] = date('Y-m-d', time());
						$data['parcela']['Quitado'] = "S";			

						$data['update']['parcela']['campos'] = array_keys($data['parcela']);
						$data['update']['parcela']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['parcela']['anterior'],
							$data['parcela'],
							$data['update']['parcela']['campos'],
							$id, 
						TRUE);
						/*
						echo '<br>';
						echo "<pre>";
						print_r($data['parcela']);
						echo "</pre>";
						exit();	
						*/
						
						$data['update']['parcela']['bd'] = $this->Orcatrata_model->update_parcela($data['parcela'], $id);			

						$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['id_orcatrata']);
						if (isset($data['update']['parcelasrec']['posterior'])){
							$max_parcela = count($data['update']['parcelasrec']['posterior']);
							if($max_parcela == 0){
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['QuitadoOrca'] = "S";				
							}else{
								$data['orcatrata']['QuitadoOrca'] = "N";
							}	
						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['id_orcatrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto == 0){
								$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
								$data['orcatrata']['ConcluidoOrca'] = "S";
							}else{
								$data['orcatrata']['ConcluidoOrca'] = "N";
							}
						}
						
						if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['FinalizadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
						
							#### App_Procedimento ####
							$data['update']['procedimento']['alterar'] = $this->Orcatrata_model->get_procedimento_posterior($data['id_orcatrata']);
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

						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['id_orcatrata']);

						redirect(base_url() . 'Debitos/debitos/' . $data['msg']);
						exit();
					}
				}
			}
		}	
		$this->load->view('basico/footer');

    }
	
}