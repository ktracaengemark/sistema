<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_deb extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array(
									'Basico_model', 'Cliente_model', 'Relatorio_model', 'Empresa_model', 
									'Loginempresa_model', 'Associado_model', 'Usuario_model', 'Agenda_model'
								));
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
        $data['titulo1'] = 'Despesas';
		$data['metodo'] = 1;
		$data['form_open_path'] = 'relatorio/debitos';
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'Relatorio_print/debitos_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/debitos_recibo/';
		$data['edit'] = 'Orcatrata/baixadodebito/';
		$data['alterarparc'] = 'Orcatrata/baixadosdebitos/';	
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
			
			$data['pesquisa_query'] = $this->Relatorio_model->list_debitos($_SESSION['FiltroDebitos'],TRUE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio/debitos' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();

				$config['base_url'] = base_url() . 'relatorio_pag/debitos_pag/';

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

				$data['report'] = $this->Relatorio_model->list_debitos($_SESSION['FiltroDebitos'], TRUE, FALSE, $config['per_page'], $data['linha']);			
				
				$_SESSION['FiltroDebitos']['Texto1'] = utf8_encode($data['query']['Texto1']);
				$_SESSION['FiltroDebitos']['Texto2'] = utf8_encode($data['query']['Texto2']);
				$_SESSION['FiltroDebitos']['Texto3'] = utf8_encode($data['query']['Texto3']);
				$_SESSION['FiltroDebitos']['Texto4'] = utf8_encode($data['query']['Texto4']);
				$_SESSION['FiltroDebitos']['nomedoFornecedor'] = $data['query']['nomedoFornecedor'];
				$_SESSION['FiltroDebitos']['numerodopedido'] = $data['query']['numerodopedido'];

				$data['pagination'] = $this->pagination->create_links();

				$data['list1'] = $this->load->view('relatorio/list_debitos', $data, TRUE);
			}
        }

        $this->load->view('relatorio/tela_debitos', $data);

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
		$data['form_open_path'] = 'relatorio_pag/debitos_pag';
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'Relatorio_print/debitos_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/debitos_recibo/';
		$data['edit'] = 'Orcatrata/baixadodebito/';
		$data['alterarparc'] = 'Orcatrata/baixadosdebitos/';	
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/debitos/';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #run form validation

		$data['pesquisa_query'] = $this->Relatorio_model->list_debitos($_SESSION['FiltroDebitos'],TRUE, TRUE);
		
		if($data['pesquisa_query'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio/debitos' . $data['msg']);
			exit();
		}else{

			$config['base_url'] = base_url() . 'relatorio_pag/debitos_pag/';
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
			
			$data['report'] = $this->Relatorio_model->list_debitos($_SESSION['FiltroDebitos'], TRUE, FALSE, $config['per_page'], $data['linha']);			
			
			$data['pagination'] = $this->pagination->create_links();

            $data['list1'] = $this->load->view('relatorio/list_debitos', $data, TRUE);
       
		}
        $this->load->view('relatorio/tela_debitos', $data);

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

		$data['report'] = $this->Relatorio_model->list_debitos($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio/debitos' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Relatorio_print/list_debitos_excel', $data, TRUE);
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
		
				$data['pesquisa_query'] = $this->Relatorio_print_model->get_debitos($_SESSION['FiltroDebitos'], TRUE);
				
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'relatorio/debitos' . $data['msg']);
					exit();
				}else{

					$config['base_url'] = base_url() . 'Relatorio_print/debitos_lista/' . $id . '/';
					$config['total_rows'] = $data['pesquisa_query'];
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
					$data['orcatrata'] = $this->Relatorio_print_model->get_debitos($_SESSION['FiltroDebitos'], FALSE, $config['per_page'], ($page * $config['per_page']));
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
								$data['produto'][$i] = $this->Relatorio_print_model->get_produto($data['orcatrata'][$i]['idApp_OrcaTrata']);
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
								$data['parcelasrec'][$i] = $this->Relatorio_print_model->get_parcelasrec($data['orcatrata'][$i]['idApp_OrcaTrata']);
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
								$data['procedimento'][$i] = $this->Relatorio_print_model->get_procedimento($data['orcatrata'][$i]['idApp_OrcaTrata']);
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

					$data['titulo'] = 'Versão Lista Cobrança';
					$data['form_open_path'] = 'Relatorio_print/debitos_lista';
					$data['panel'] = 'danger';
					$data['metodo'] = 1;
					$data['imprimir'] = 'OrcatrataPrint/imprimir/';
					$data['imprimirlista'] = 'Relatorio_print/debitos_lista/';
					$data['imprimirrecibo'] = 'Relatorio_print/debitos_recibo/';
					
					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$this->load->view('Relatorio_print/print_debitos_lista', $data);
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
				
				$data['pesquisa_query'] = $this->Relatorio_print_model->get_debitos($_SESSION['FiltroDebitos'], TRUE);
				
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'relatorio/debitos' . $data['msg']);
					exit();
				}else{

					$config['base_url'] = base_url() . 'Relatorio_print/debitos_recibo/' . $id . '/';
					$config['total_rows'] = $data['pesquisa_query'];
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
					$data['orcatrata'] = $this->Relatorio_print_model->get_debitos($_SESSION['FiltroDebitos'], FALSE, $config['per_page'], ($page * $config['per_page']));
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
								$data['produto'][$i] = $this->Relatorio_print_model->get_produto($data['orcatrata'][$i]['idApp_OrcaTrata']);
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
								$data['parcelasrec'][$i] = $this->Relatorio_print_model->get_parcelasrec($data['orcatrata'][$i]['idApp_OrcaTrata']);
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
								$data['procedimento'][$i] = $this->Relatorio_print_model->get_procedimento($data['orcatrata'][$i]['idApp_OrcaTrata']);
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
					$data['form_open_path'] = 'Relatorio_print/debitos_recibo';
					$data['panel'] = 'danger';
					$data['metodo'] = 1;
					$data['imprimir'] = 'OrcatrataPrint/imprimir/';
					$data['imprimirlista'] = 'Relatorio_print/debitos_lista/';
					$data['imprimirrecibo'] = 'Relatorio_print/debitos_recibo/';		
					

					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$this->load->view('Relatorio_print/print_debitos_recibo', $data);			
				}
			}
		}
        $this->load->view('basico/footer');

    }
	
}