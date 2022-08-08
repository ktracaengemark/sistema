<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Cobrancas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array(	'Basico_model', 'Cliente_model', 'Relatorio_model', 'Base_model', 'Orcatrata_model', 'Empresa_model', 
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

        $this->load->view('Cobrancas/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

	public function cobrancas() {
		
		unset($_SESSION['FiltroCobrancas']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Registro N�o Encontrada.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa est� muito grande, ela excedeu 15000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
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
			'nomedoCliente',
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
            'N' => 'N�o',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'N�o',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'N�o',
        );

		$data['select']['FinalizadoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'N�o',
        );

		$data['select']['CanceladoOrca'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'N�o',
        );

		$data['select']['CombinadoFrete'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'N�o',
        );

		$data['select']['Quitado'] = array(
            '0' => '::TODOS::',
            'S' => 'Sim',
            'N' => 'N�o',
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
            'N' => 'N�o',
        );
				
        $data['select']['Agrupar'] = array(
			'PR.idApp_Parcelas' => 'Parcelas',			
			'OT.idApp_OrcaTrata' => 'Or�amentos',
			'OT.idApp_Cliente' => 'Clientes',
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
			#'1' => '�ltimo Pedido',			
			#'2' => '�ltima Parcela',
        );

		if($_SESSION['log']['idSis_Empresa'] != 5){
			$data['select']['Campo'] = array(
				'OT.idApp_OrcaTrata' => 'id do Or�amento',
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
				'C.idApp_Cliente' => 'id do Cliente',
				'C.NomeCliente' => 'Nome do Cliente',	
				
			);
		}else{
			$data['select']['Campo'] = array(
				'OT.idApp_OrcaTrata' => 'id do Or�amento',
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

		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		
        $data['select']['nomedoCliente'] = $this->Basico_model->select_status_sn();
        $data['select']['numerodopedido'] = $this->Basico_model->select_status_sn();
		
 		(!$data['query']['nomedoCliente']) ? $data['query']['nomedoCliente'] = 'N' : FALSE;
		$data['radio'] = array(
            'nomedoCliente' => $this->basico->radio_checked($data['query']['nomedoCliente'], 'nomedoCliente', 'NS'),
        );
        ($data['query']['nomedoCliente'] == 'S') ?
            $data['div']['nomedoCliente'] = '' : $data['div']['nomedoCliente'] = 'style="display: none;"';		

 		(!$data['query']['numerodopedido']) ? $data['query']['numerodopedido'] = 'N' : FALSE;
		$data['radio'] = array(
            'numerodopedido' => $this->basico->radio_checked($data['query']['numerodopedido'], 'numerodopedido', 'NS'),
        );
        ($data['query']['numerodopedido'] == 'S') ?
            $data['div']['numerodopedido'] = '' : $data['div']['numerodopedido'] = 'style="display: none;"';		
		
		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Receitas';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'Cobrancas/cobrancas';
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Cobrancas/cobrancas_lista/';
		$data['imprimirrecibo'] = 'Cobrancas/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['alterarparc'] = 'Cobrancas/cobrancas_baixa/';	
		$data['paginacao'] = 'N';	

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio do Pedido', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Pedido', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data In�cio do Vnc da Prc', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Vnc da Prc', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio5', 'Data In�cio do Pag Comissao', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim5', 'Data Fim do Pag Comissao', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio6', 'Data In�cio do Cadastro', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim6', 'Data Fim do Cadastro', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio8', 'Data Lanc Com. In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim8', 'Data Lanc Com.Fim', 'trim|valid_date');
		$this->form_validation->set_rules('HoraInicio5', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim5', 'Hora Final', 'trim|valid_hour');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

			$_SESSION['FiltroCobrancas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataInicio8'] = $this->basico->mascara_data($data['query']['DataInicio8'], 'mysql');
			$_SESSION['FiltroCobrancas']['DataFim8'] = $this->basico->mascara_data($data['query']['DataFim8'], 'mysql');
			$_SESSION['FiltroCobrancas']['HoraInicio5'] = $data['query']['HoraInicio5'];
			$_SESSION['FiltroCobrancas']['HoraFim5'] = $data['query']['HoraFim5'];
			$_SESSION['FiltroCobrancas']['Quitado'] = $data['query']['Quitado'];
			$_SESSION['FiltroCobrancas']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$_SESSION['FiltroCobrancas']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$_SESSION['FiltroCobrancas']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$_SESSION['FiltroCobrancas']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$_SESSION['FiltroCobrancas']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$_SESSION['FiltroCobrancas']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$_SESSION['FiltroCobrancas']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$_SESSION['FiltroCobrancas']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$_SESSION['FiltroCobrancas']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$_SESSION['FiltroCobrancas']['AVAP'] = $data['query']['AVAP'];
			$_SESSION['FiltroCobrancas']['TipoFrete'] = $data['query']['TipoFrete'];
			$_SESSION['FiltroCobrancas']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$_SESSION['FiltroCobrancas']['Orcamento'] = $data['query']['Orcamento'];
			$_SESSION['FiltroCobrancas']['Cliente'] = $data['query']['Cliente'];
			$_SESSION['FiltroCobrancas']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$_SESSION['FiltroCobrancas']['Modalidade'] = $data['query']['Modalidade'];
			$_SESSION['FiltroCobrancas']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroCobrancas']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['FiltroCobrancas']['metodo'] = $data['metodo'];
			$_SESSION['FiltroCobrancas']['idTab_TipoRD'] = $data['TipoRD'];
			$_SESSION['FiltroCobrancas']['nome'] = $data['query']['nome'];
			$_SESSION['FiltroCobrancas']['Ultimo'] = $data['query']['Ultimo'];
			$_SESSION['FiltroCobrancas']['Agrupar'] = $data['query']['Agrupar'];
			$_SESSION['FiltroCobrancas']['Produtos'] = $data['query']['Produtos'];
			$_SESSION['FiltroCobrancas']['Parcelas'] = $data['query']['Parcelas'];
			
			$data['pesquisa_query'] = $this->Base_model->list_cobrancas($_SESSION['FiltroCobrancas'],FALSE , TRUE, FALSE ,FALSE ,FALSE );
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'Cobrancas/cobrancas' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();

				$config['base_url'] = base_url() . 'Cobrancas/cobrancas_pag/';

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

				$data['report'] = $this->Base_model->list_cobrancas($_SESSION['FiltroCobrancas'], FALSE, FALSE, $config['per_page'], $data['linha']);			
				
				$_SESSION['FiltroCobrancas']['Texto1'] = utf8_encode($data['query']['Texto1']);
				$_SESSION['FiltroCobrancas']['Texto2'] = utf8_encode($data['query']['Texto2']);
				$_SESSION['FiltroCobrancas']['Texto3'] = utf8_encode($data['query']['Texto3']);
				$_SESSION['FiltroCobrancas']['Texto4'] = utf8_encode($data['query']['Texto4']);
				$_SESSION['FiltroCobrancas']['nomedoCliente'] = $data['query']['nomedoCliente'];
				$_SESSION['FiltroCobrancas']['numerodopedido'] = $data['query']['numerodopedido'];

				$data['pagination'] = $this->pagination->create_links();

				$data['list1'] = $this->load->view('Cobrancas/list_cobrancas', $data, TRUE);
			}
        }

        $this->load->view('Cobrancas/tela_cobrancas', $data);

        $this->load->view('basico/footer');

    }
	
	public function cobrancas_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
        $data['titulo1'] = 'Parcelas das Receitas';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'Cobrancas/cobrancas_pag';
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Cobrancas/cobrancas_lista/';
		$data['imprimirrecibo'] = 'Cobrancas/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['alterarparc'] = 'Cobrancas/cobrancas_baixa/';	
		$data['paginacao'] = 'S';
		$data['caminho'] = 'Cobrancas/cobrancas/';
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #run form validation

		$data['pesquisa_query'] = $this->Base_model->list_cobrancas($_SESSION['FiltroCobrancas'],FALSE, TRUE);
		
		if($data['pesquisa_query'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Cobrancas/cobrancas' . $data['msg']);
			exit();
		}else{

			$config['base_url'] = base_url() . 'Cobrancas/cobrancas_pag/';
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
			
			$data['report'] = $this->Base_model->list_cobrancas($_SESSION['FiltroCobrancas'], FALSE, FALSE, $config['per_page'], $data['linha']);			
			
			$data['pagination'] = $this->pagination->create_links();

            $data['list1'] = $this->load->view('Cobrancas/list_cobrancas', $data, TRUE);
       
		}
        $this->load->view('Cobrancas/tela_cobrancas', $data);

        $this->load->view('basico/footer');

    }

	public function cobrancas_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Cobrancas Sem Filtros';
				$data['metodo'] = $id;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroCobrancas'])){
					$dados = $_SESSION['FiltroCobrancas'];
					$data['titulo'] = 'Cobrancas Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Cobrancas Sem Filtros';
					$data['metodo'] = 1;
				}
			}elseif($id == 3){
				if(isset($_SESSION['FiltroCobrancas'])){
					$dados = $_SESSION['FiltroCobrancas'];
					$data['titulo'] = 'Cobrancas Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Cobrancas Sem Filtros';
					$data['metodo'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Cobrancas Sem Filtros';
				$data['metodo'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Cobrancas Sem Filtros';
			$data['metodo'] = 1;
		}

        $data['nome'] = 'Cliente';

		$data['report'] = $this->Base_model->list_cobrancas($dados, FALSE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Cobrancas/cobrancas' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Cobrancas/list_cobrancas_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

    public function cobrancas_lista($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
				
				$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroCobrancas']['DataInicio4'], 'barras');
				$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroCobrancas']['DataFim4'], 'barras');
		
				//$data['pesquisa_query'] = $this->Relatorio_print_model->get_cobrancas($_SESSION['FiltroCobrancas'], TRUE);
				$data['pesquisa_query'] = $this->Base_model->list_cobrancas($_SESSION['FiltroCobrancas'], FALSE, TRUE, FALSE, FALSE, FALSE);
				
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'Cobrancas/cobrancas' . $data['msg']);
					exit();
				}else{
					
					//$config['total_rows'] = $data['pesquisa_query'];
					
					$config['total_rows'] = $data['pesquisa_query']->num_rows();
					$config['base_url'] = base_url() . 'Cobrancas/cobrancas_lista/' . $id . '/';
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
					$data['orcatrata'] = $this->Base_model->list_cobrancas($_SESSION['FiltroCobrancas'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']), TRUE);
					/*
					echo '<br>';
					echo "<pre>";
					print_r($data['orcatrata']);
					echo "</pre>";
					exit ();
					*/
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
								$data['produto'][$i] = $this->Relatorio_model->get_produto($data['orcatrata'][$i]['idApp_OrcaTrata']);
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
								$data['parcelasrec'][$i] = $this->Relatorio_model->get_parcelasrec($data['orcatrata'][$i]['idApp_OrcaTrata']);
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
								$data['procedimento'][$i] = $this->Relatorio_model->get_procedimento($data['orcatrata'][$i]['idApp_OrcaTrata']);
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

					$data['titulo'] = 'Vers�o Lista Cobran�a';
					$data['form_open_path'] = 'Cobrancas/cobrancas_lista';
					$data['panel'] = 'info';
					$data['metodo'] = 1;
					$data['imprimir'] = 'OrcatrataPrint/imprimir/';
					$data['imprimirlista'] = 'Cobrancas/cobrancas_lista/';
					$data['imprimirrecibo'] = 'Cobrancas/cobrancas_recibo/';
					
					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$this->load->view('Cobrancas/list_cobrancas_lista', $data);
				}
			}	
		}
        $this->load->view('basico/footer');

    }

    public function cobrancas_recibo($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
						
				$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroCobrancas']['DataInicio4'], 'barras');
				$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroCobrancas']['DataFim4'], 'barras');
				
				$data['pesquisa_query'] = $this->Base_model->list_cobrancas($_SESSION['FiltroCobrancas'], FALSE, TRUE, FALSE, FALSE, FALSE);
				
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'Cobrancas/cobrancas' . $data['msg']);
					exit();
				}else{

					//$config['total_rows'] = $data['pesquisa_query'];
					$config['total_rows'] = $data['pesquisa_query']->num_rows();
					$config['base_url'] = base_url() . 'Cobrancas/cobrancas_recibo/' . $id . '/';
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
					$data['orcatrata'] = $this->Base_model->list_cobrancas($_SESSION['FiltroCobrancas'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']), TRUE);
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
								$data['produto'][$i] = $this->Relatorio_model->get_produto($data['orcatrata'][$i]['idApp_OrcaTrata']);
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
								$data['parcelasrec'][$i] = $this->Relatorio_model->get_parcelasrec($data['orcatrata'][$i]['idApp_OrcaTrata']);
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
								$data['procedimento'][$i] = $this->Relatorio_model->get_procedimento($data['orcatrata'][$i]['idApp_OrcaTrata']);
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

					$data['titulo'] = 'Vers�o Recibo Cobran�a';
					$data['form_open_path'] = 'Cobrancas/cobrancas_recibo';
					$data['panel'] = 'info';
					$data['metodo'] = 1;
					$data['imprimir'] = 'OrcatrataPrint/imprimir/';
					$data['imprimirlista'] = 'Cobrancas/cobrancas_lista/';
					$data['imprimirrecibo'] = 'Cobrancas/cobrancas_recibo/';		
					

					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$this->load->view('Cobrancas/list_cobrancas_recibo', $data);			
				}
			}
		}
        $this->load->view('basico/footer');

    }
	
    public function cobrancas_baixa($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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

			if ($id) {
				
				#### Sis_Empresa ####
				$data['empresa'] = $this->Orcatrata_model->get_orcatrataalterar($id);
			
				if($data['empresa'] === FALSE){
					
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}else{

					$data['pesquisa_query'] = $this->Base_model->list_cobrancas($_SESSION['FiltroCobrancas'], TRUE, TRUE, FALSE, FALSE, FALSE);
					
					if($data['pesquisa_query'] === FALSE){
						
						$data['msg'] = '?m=4';
						redirect(base_url() . 'Cobrancas/cobrancas' . $data['msg']);
						exit();
					}else{

						$config['total_rows'] = $data['pesquisa_query']->num_rows();
						$config['base_url'] = base_url() . 'Cobrancas/cobrancas_baixa/' . $id . '/';
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
							$_SESSION['FiltroCobrancas']['Total_Rows'] = $data['total_rows'] = $config['total_rows'];
						}else{
							$_SESSION['FiltroCobrancas']['Total_Rows'] = $data['total_rows'] = 0;
						}
						
						$this->pagination->initialize($config);
						
						$_SESSION['FiltroCobrancas']['Pagina'] = $data['pagina'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
								
						$_SESSION['FiltroCobrancas']['Pagina_atual'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"])) : 0;
								
						$_SESSION['FiltroCobrancas']['Per_Page'] = $data['per_page'] = $config['per_page'];
						
						$_SESSION['FiltroCobrancas']['Pagination'] = $data['pagination'] = $this->pagination->create_links();		

						#### App_Parcelas ####
						$data['parcelasrec'] = $this->Base_model->list_cobrancas($_SESSION['FiltroCobrancas'], TRUE, TRUE, $_SESSION['FiltroCobrancas']['Per_Page'], ($_SESSION['FiltroCobrancas']['Pagina'] * $_SESSION['FiltroCobrancas']['Per_Page']), TRUE);
						
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
									
									$_SESSION['Parcelasrec'][$j]['Receita'] = $data['parcelasrec'][$j]['Receita'];
									
									$_SESSION['Parcelasrec'][$j]['Parcela'] = $data['parcelasrec'][$j]['Parcela'];
									$_SESSION['Parcelasrec'][$j]['FormaPagamento'] = $data['parcelasrec'][$j]['FormaPagamento'];
									
									$data['radio'] = array(
										'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
									);
									($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';
										
								}
								//exit ();
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
				
				$data['titulo'] = 'Receitas';
				$data['form_open_path'] = 'Cobrancas/cobrancas_baixa';
				$data['readonly'] = 'readonly=""';
				$data['disabled'] = '';
				$data['panel'] = 'info';
				$data['metodo'] = 2;
				$data['TipoFinanceiro'] = 'Receitas';
				$data['TipoRD'] = 2;
				$data['nome'] = 'Cliente';		

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

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				#### Sis_Empresa ####
				$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');
				if($data['query']['MostrarDataPagamento'] == 'S'){
					$this->form_validation->set_rules('DataPagamento', 'Data do Pagamento', 'required|trim|valid_date');
				}
						
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('Cobrancas/form_cobrancas_baixa', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {

						$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
						$data['bd']['MostrarDataPagamento'] = $data['query']['MostrarDataPagamento'];
						$data['bd']['DataPagamento'] = $data['query']['DataPagamento'];
						
						////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////

						$data['query']['DataPagamento'] = $this->basico->mascara_data($data['query']['DataPagamento'], 'mysql');  

						#### App_ParcelasRec ####
						$data['update']['parcelasrec']['anterior'] = $this->Base_model->list_cobrancas($_SESSION['FiltroCobrancas'], TRUE, TRUE, $_SESSION['FiltroCobrancas']['Per_Page'], ($_SESSION['FiltroCobrancas']['Pagina'] * $_SESSION['FiltroCobrancas']['Per_Page']), TRUE);
						
						if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

							if (isset($data['parcelasrec']))
								$data['parcelasrec'] = array_values($data['parcelasrec']);
							else
								$data['parcelasrec'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

							$max = count($data['update']['parcelasrec']['alterar']);
							
							for($j=0; $j<$max; $j++) {

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
										
										$data['ID_Orcamento'][$j] = $this->Orcatrata_model->get_orcamento_baixa_parcela($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);

										if($data['ID_Orcamento'][$j]['QuitadoOrca'] == "N" && $data['ID_Orcamento'][$j]['CanceladoOrca'] == "N"){
											
											if(isset($data['ID_Orcamento'][$j]['idApp_Cliente']) && $data['ID_Orcamento'][$j]['idApp_Cliente'] !=0 && $data['ID_Orcamento'][$j]['idApp_Cliente'] != ""){
												
												$data['dados']['id_cliente'][$j] = $this->Orcatrata_model->get_cliente($data['ID_Orcamento'][$j]['idApp_Cliente']);
												
												$cashback_antigo_cliente[$j] = $data['dados']['id_cliente'][$j]['CashBackCliente'];
												$cashback_antigo_cliente[$j] = floatval ($cashback_antigo_cliente[$j]);
												
												$cashback_produtos[$j] = 0;
												$data['produtos']['parcela'][$j] = $this->Orcatrata_model->get_produto_baixa_parcela($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);
												if (isset($data['produtos']['parcela'][$j])){
													
													$max_produtos_parcela[$j] = count($data['produtos']['parcela'][$j]);
													
													if($max_produtos_parcela[$j] > 0){
														
														for($k=0;$k<$max_produtos_parcela[$j];$k++) {
															$cashback_produtos[$j] += $data['produtos']['parcela'][$j][$k]['ValorComissaoCashBack'];
															$cashback_produtos[$j] = floatval ($cashback_produtos[$j]);
														}
													
													}
													
												}
												$data['update_cashback']['id_cliente'][$j]['CashBackCliente'] = $cashback_antigo_cliente[$j] + $cashback_produtos[$j];
												$data['update_cashback']['id_cliente'][$j]['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
												
												$data['update_cashback']['id_cliente']['bd'][$j] = $this->Cliente_model->update_cliente($data['update_cashback']['id_cliente'][$j], $data['ID_Orcamento'][$j]['idApp_Cliente']);
												
												unset($cashback_antigo_cliente[$j]);
												unset($cashback_produtos[$j]);
											
											}
										}
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
						
						redirect(base_url() . 'Cobrancas/cobrancas_baixa/' . $_SESSION['log']['idSis_Empresa'] . '/' . $_SESSION['FiltroCobrancas']['Pagina_atual'] . $data['msg']);
						exit();
						
					}
				}	
			}
		}
		$this->load->view('basico/footer');

    }
	
}