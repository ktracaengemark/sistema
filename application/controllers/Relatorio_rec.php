<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_rec extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array( 	'Basico_model', 'Cliente_model', 'Relatorio_model', 'Relatorio_model_list', 'Orcatrata_model', 'Empresa_model', 
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

	public function receitas() {
		
		unset($_SESSION['FiltroReceitas']);
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Receita Não Encontrada.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa está muito grande, ela excedeu 15000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
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

        $data['select']['Agrupar'] = array(
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Cliente' => 'Cliente',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',			
			#'1' => 'Último Pedido',
        );		

        $data['select']['Campo'] = array(
			'OT.idApp_OrcaTrata' => 'id do Pedido',
			'OT.DataOrca' => 'Data do Pedido',
			'PRDS.DataConcluidoProduto' => 'Data da Entrega',
			'PRDS.HoraConcluidoProduto' => 'Hora da Entrega',
			'C.idApp_Cliente' => 'id do Cliente',
			'C.NomeCliente' => 'Nome do Cliente',
			'C.DataCadastroCliente' => 'Data do Cadastro',
        );

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

		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['DiaAniv'] = $this->Relatorio_model->select_dia();
		$data['select']['MesAniv'] = $this->Relatorio_model->select_mes();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		
        $data['select']['nomedoCliente'] = $this->Basico_model->select_status_sn();
        $data['select']['idCliente'] = $this->Basico_model->select_status_sn();
        $data['select']['numerodopedido'] = $this->Basico_model->select_status_sn();
        $data['select']['site'] = $this->Basico_model->select_status_sn();
		
 		(!$data['query']['nomedoCliente']) ? $data['query']['nomedoCliente'] = 'N' : FALSE;
		$data['radio'] = array(
            'nomedoCliente' => $this->basico->radio_checked($data['query']['nomedoCliente'], 'nomedoCliente', 'NS'),
        );
        ($data['query']['nomedoCliente'] == 'S') ?
            $data['div']['nomedoCliente'] = '' : $data['div']['nomedoCliente'] = 'style="display: none;"';		

 		(!$data['query']['idCliente']) ? $data['query']['idCliente'] = 'N' : FALSE;
		$data['radio'] = array(
            'idCliente' => $this->basico->radio_checked($data['query']['idCliente'], 'idCliente', 'NS'),
        );
        ($data['query']['idCliente'] == 'S') ?
            $data['div']['idCliente'] = '' : $data['div']['idCliente'] = 'style="display: none;"';
			
 		(!$data['query']['numerodopedido']) ? $data['query']['numerodopedido'] = 'N' : FALSE;
		$data['radio'] = array(
            'numerodopedido' => $this->basico->radio_checked($data['query']['numerodopedido'], 'numerodopedido', 'NS'),
        );
        ($data['query']['numerodopedido'] == 'S') ?
            $data['div']['numerodopedido'] = '' : $data['div']['numerodopedido'] = 'style="display: none;"';		

 		(!$data['query']['site']) ? $data['query']['site'] = 'N' : FALSE;
		$data['radio'] = array(
            'site' => $this->basico->radio_checked($data['query']['site'], 'site', 'NS'),
        );
        ($data['query']['site'] == 'S') ?
            $data['div']['site'] = '' : $data['div']['site'] = 'style="display: none;"';		

		$data['query']['nome'] = 'Cliente';
        $data['titulo'] = 'Receitas';
		$data['form_open_path'] = 'relatorio_rec/receitas';
		$data['baixatodas'] = 'Relatorio_rec/receitas_baixa/';
		$data['editartodas'] = 'relatorio_rec/receitas/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio_rec/baixadasreceitas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistacliente/';
		$data['imprimirrecibo'] = 'Relatorio_cob/cobrancas_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';	
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
		$this->form_validation->set_rules('HoraInicio5', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim5', 'Hora Final', 'trim|valid_hour');
				
        #run form validation
        if ($this->form_validation->run() !== FALSE) {
			
			$_SESSION['FiltroReceitas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$_SESSION['FiltroReceitas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$_SESSION['FiltroReceitas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$_SESSION['FiltroReceitas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$_SESSION['FiltroReceitas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
			$_SESSION['FiltroReceitas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$_SESSION['FiltroReceitas']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
			$_SESSION['FiltroReceitas']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$_SESSION['FiltroReceitas']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
			$_SESSION['FiltroReceitas']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$_SESSION['FiltroReceitas']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
			$_SESSION['FiltroReceitas']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$_SESSION['FiltroReceitas']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
			$_SESSION['FiltroReceitas']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$_SESSION['FiltroReceitas']['HoraInicio5'] = $data['query']['HoraInicio5'];
			$_SESSION['FiltroReceitas']['HoraFim5'] = $data['query']['HoraFim5'];
			$_SESSION['FiltroReceitas']['Produtos'] = $data['query']['Produtos'];
			$_SESSION['FiltroReceitas']['Parcelas'] = $data['query']['Parcelas'];
			$_SESSION['FiltroReceitas']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$_SESSION['FiltroReceitas']['DiaAniv'] = $data['query']['DiaAniv'];
			$_SESSION['FiltroReceitas']['MesAniv'] = $data['query']['MesAniv'];
			$_SESSION['FiltroReceitas']['AnoAniv'] = $data['query']['AnoAniv'];
			$_SESSION['FiltroReceitas']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$_SESSION['FiltroReceitas']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$_SESSION['FiltroReceitas']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$_SESSION['FiltroReceitas']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$_SESSION['FiltroReceitas']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$_SESSION['FiltroReceitas']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$_SESSION['FiltroReceitas']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$_SESSION['FiltroReceitas']['Quitado'] = $data['query']['Quitado'];
			$_SESSION['FiltroReceitas']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$_SESSION['FiltroReceitas']['AVAP'] = $data['query']['AVAP'];
			$_SESSION['FiltroReceitas']['TipoFrete'] = $data['query']['TipoFrete'];
			$_SESSION['FiltroReceitas']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$_SESSION['FiltroReceitas']['Orcamento'] = $data['query']['Orcamento'];
			$_SESSION['FiltroReceitas']['Cliente'] = $data['query']['Cliente'];
			$_SESSION['FiltroReceitas']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$_SESSION['FiltroReceitas']['Modalidade'] = $data['query']['Modalidade'];
			$_SESSION['FiltroReceitas']['Agrupar'] = $data['query']['Agrupar'];
			$_SESSION['FiltroReceitas']['Ultimo'] = $data['query']['Ultimo'];
			$_SESSION['FiltroReceitas']['nome'] = $data['query']['nome'];
			$_SESSION['FiltroReceitas']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroReceitas']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['FiltroReceitas']['metodo'] = $data['metodo'];
			$_SESSION['FiltroReceitas']['idTab_TipoRD'] = $data['TipoRD'];

			$data['pesquisa_query'] = $this->Relatorio_model_list->list_receitas($_SESSION['FiltroReceitas'],TRUE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio_rec/receitas' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();			
				
				$config['base_url'] = base_url() . 'relatorio_rec/receitas_pag/';
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

				$data['report'] = $this->Relatorio_model_list->list_receitas($_SESSION['FiltroReceitas'], TRUE, FALSE, $config['per_page'], $data['linha']);		

				$_SESSION['FiltroReceitas']['Limit'] = $data['per_page'];
				$_SESSION['FiltroReceitas']['Start'] = $data['linha'];
				$_SESSION['FiltroReceitas']['Texto1'] = utf8_encode($data['query']['Texto1']);
				$_SESSION['FiltroReceitas']['Texto2'] = utf8_encode($data['query']['Texto2']);
				$_SESSION['FiltroReceitas']['Texto3'] = utf8_encode($data['query']['Texto3']);
				$_SESSION['FiltroReceitas']['Texto4'] = utf8_encode($data['query']['Texto4']);
				$_SESSION['FiltroReceitas']['nomedoCliente'] = $data['query']['nomedoCliente'];
				$_SESSION['FiltroReceitas']['idCliente'] = $data['query']['idCliente'];
				$_SESSION['FiltroReceitas']['numerodopedido'] = $data['query']['numerodopedido'];
				$_SESSION['FiltroReceitas']['site'] = $data['query']['site'];

				$data['pagination'] = $this->pagination->create_links();
				
				$data['list1'] = $this->load->view('relatorio_rec/list_receitas', $data, TRUE);
			}	
        }		

        $this->load->view('relatorio_rec/tela_receitas', $data);

        $this->load->view('basico/footer');

    }

	public function receitas_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
	
        $data['titulo'] = 'Receitas';
		$data['form_open_path'] = 'relatorio_rec/receitas_pag';
		$data['baixatodas'] = 'Relatorio_rec/receitas_baixa/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio_rec/receitas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistacliente/';
		$data['imprimirrecibo'] = 'Relatorio_cob/cobrancas_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio_rec/receitas/';
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation

			$data['pesquisa_query'] = $this->Relatorio_model_list->list_receitas($_SESSION['FiltroReceitas'],TRUE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio_rec/receitas' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();
				
				$config['base_url'] = base_url() . 'relatorio_rec/receitas_pag/';
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

				$data['report'] = $this->Relatorio_model_list->list_receitas($_SESSION['FiltroReceitas'], TRUE, FALSE, $config['per_page'], $data['linha']);
							
				$data['pagination'] = $this->pagination->create_links();

				$data['list1'] = $this->load->view('relatorio_rec/list_receitas', $data, TRUE);
			}
       		

        $this->load->view('relatorio_rec/tela_receitas', $data);

        $this->load->view('basico/footer');

    }

	public function receitas_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Receitas Sem Filtros';
				$data['metodo'] = $id;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroReceitas'])){
					$dados = $_SESSION['FiltroReceitas'];
					$data['titulo'] = 'Receitas Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Receitas Sem Filtros';
					$data['metodo'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Receitas Sem Filtros';
				$data['metodo'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Receitas Sem Filtros';
			$data['metodo'] = 1;
		}

        $data['nome'] = 'Cliente';

		$data['report'] = $this->Relatorio_model_list->list_receitas($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio_rec/receitas' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Relatorio_rec/list_receitas_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

	public function receitas_lista() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
        $data['titulo'] = 'Receitas';
		$data['form_open_path'] = 'Relatorio_rec/receitas_lista';
		$data['baixatodas'] = 'Relatorio_rec/receitas_baixa/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio_rec/receitas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistacliente/';
		$data['imprimirrecibo'] = 'Relatorio_cob/cobrancas_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio_rec/receitas/';
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation

			$data['pesquisa_query'] = $this->Relatorio_model_list->list_receitas($_SESSION['FiltroReceitas'],TRUE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio_rec/receitas' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();
				
				$config['base_url'] = base_url() . 'Relatorio_rec/receitas_lista/';
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

				$data['report'] = $this->Relatorio_model_list->list_receitas($_SESSION['FiltroReceitas'], TRUE, FALSE, $config['per_page'], $data['linha']);
							
				$data['pagination'] = $this->pagination->create_links();

				$data['list1'] = $this->load->view('Relatorio_rec/list_receitas_lista', $data, TRUE);
			}
        		

        $this->load->view('relatorio_rec/tela_receitas', $data);

        $this->load->view('basico/footer');

    }
	
    public function receitas_baixa($id = FALSE) {
		
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
				'QuitadoComissao',
				'Cadastrar',
			), TRUE));

			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['empresa'] = quotes_to_entities($this->input->post(array(
				#### Sis_Empresa ####
				'idSis_Empresa',
				
			), TRUE));

			(!$data['query']['Cadastrar']) ? $data['query']['Cadastrar'] = 'S' : FALSE;
			
			(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				if ($this->input->post('idApp_OrcaTrata' . $i)) {
					$data['orcamento'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
					$data['orcamento'][$j]['FinalizadoOrca'] = $this->input->post('FinalizadoOrca' . $i);
					$j++;
				}
			}
			
			$data['count']['PRCount'] = $j - 1;

			$data['Pesquisa'] = '';

			$data['somatotal'] = 0;
			if ($id) {
			
				#### Sis_Empresa ####
				$data['empresa'] = $this->Orcatrata_model->get_orcatrataalterar($id);
			
				if($data['empresa'] === FALSE){
					
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}else{

					$data['pesquisa_query'] = $this->Relatorio_model_list->list_receitas($_SESSION['FiltroReceitas'], FALSE, TRUE, FALSE, FALSE, FALSE);
			
					if($data['pesquisa_query'] === FALSE){
						
						$data['msg'] = '?m=4';
						redirect(base_url() . 'relatorio_rec/receitas' . $data['msg']);
						exit();
					}else{

						$_SESSION['FiltroReceitas']['FinalTotal'] = $data['pesquisa_query']->soma2->somafinal2;
						
						$_SESSION['FiltroReceitas']['TotalRows'] = $config['total_rows'] = $data['pesquisa_query']->num_rows();
						
						$config['base_url'] = base_url() . 'Relatorio_rec/receitas_baixa/' . $id . '/';	
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
						
						$_SESSION['FiltroReceitas']['Pagina'] = $data['pagina'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
								
						$_SESSION['FiltroReceitas']['Pagina_atual'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"])) : 0;
								
						$_SESSION['FiltroReceitas']['Per_Page'] = $data['per_page'] = $config['per_page'];
						
						$_SESSION['FiltroReceitas']['Pagination'] = $data['pagination'] = $this->pagination->create_links();		
						
						#### App_OrcaTrata ####
						$data['orcamento'] = $this->Relatorio_model_list->list_receitas($_SESSION['FiltroReceitas'], FALSE, TRUE, $_SESSION['FiltroReceitas']['Per_Page'], ($_SESSION['FiltroReceitas']['Pagina'] * $_SESSION['FiltroReceitas']['Per_Page']), TRUE);
						
						if (count($data['orcamento']) > 0) {
							$data['orcamento'] = array_combine(range(1, count($data['orcamento'])), array_values($data['orcamento']));
							$_SESSION['FiltroReceitas']['Contagem'] = $data['count']['PRCount'] = count($data['orcamento']);
							
							if (isset($data['orcamento'])) {
								
								for($j=1; $j <= $data['count']['PRCount']; $j++) {
									
									$data['somatotal'] += $data['orcamento'][$j]['ValorFinalOrca'];
									
									$_SESSION['Orcamento'][$j]['DataOrca'] = $this->basico->mascara_data($data['orcamento'][$j]['DataOrca'], 'barras');
									$_SESSION['Orcamento'][$j]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcamento'][$j]['DataEntregaOrca'], 'barras');
									$_SESSION['Orcamento'][$j]['HoraEntregaOrca'] = $data['orcamento'][$j]['HoraEntregaOrca'];
									$_SESSION['Orcamento'][$j]['ValorFinalOrca'] = $data['orcamento'][$j]['ValorFinalOrca'];
									$_SESSION['Orcamento'][$j]['Tipo_Orca'] = $data['orcamento'][$j]['Tipo_Orca'];
									$_SESSION['Orcamento'][$j]['NomeColaborador'] = $data['orcamento'][$j]['NomeColaborador'];
									$_SESSION['Orcamento'][$j]['idApp_Cliente'] = $data['orcamento'][$j]['idApp_Cliente'];
									$_SESSION['Orcamento'][$j]['NomeCliente'] = $data['orcamento'][$j]['NomeCliente'];
									
									$_SESSION['Orcamento'][$j]['CombinadoFrete'] = $data['orcamento'][$j]['CombinadoFrete'];
									$_SESSION['Orcamento'][$j]['AprovadoOrca'] = $data['orcamento'][$j]['AprovadoOrca'];
									$_SESSION['Orcamento'][$j]['ConcluidoOrca'] = $data['orcamento'][$j]['NomeCliente'];
									$_SESSION['Orcamento'][$j]['QuitadoOrca'] = $data['orcamento'][$j]['NomeCliente'];
									$_SESSION['Orcamento'][$j]['CanceladoOrca'] = $data['orcamento'][$j]['CanceladoOrca'];
									/*
									echo '<br>';
									echo "<pre>";
									print_r($data['orcamento'][$j]['HoraEntregaOrca']);
									echo "</pre>";
									*/
								}
								
								$_SESSION['FiltroReceitas']['SomaTotal'] = $data['somatotal'] = number_format($data['somatotal'],2,",",".");
							}
						}else{
							$_SESSION['FiltroReceitas']['Contagem'] = 0;
							$_SESSION['FiltroReceitas']['SomaTotal'] = 0;
						}
						
					}
				}
			}
			
			if(!$data['empresa']['idSis_Empresa'] || $data['empresa']['idSis_Empresa'] !== $_SESSION['log']['idSis_Empresa']){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
			}else{				
				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($_SESSION['Orcamento']);
				  echo "</pre>";
				 // exit ();
				*/

				$data['select']['QuitadoComissao'] = $this->Basico_model->select_status_sn();
				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
				$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
				
				$data['titulo'] = 'Baixa das Receitas';
				$data['form_open_path'] = 'relatorio_rec/receitas_baixa';
				$data['relatorio'] = 'relatorio_rec/receitas_pag/';
				$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
				$data['nomeusuario'] = 'NomeColaborador';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'info';
				$data['metodo'] = 3;
				$data['TipoFinanceiro'] = 'Receitas';
				$data['TipoRD'] = 2;
				$data['nome'] = 'Cliente';
				$data['imprimir'] = 'OrcatrataPrint/imprimir/';
				$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
				$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
				$data['edit'] = 'orcatrata/alterarstatus/';
				$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';

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
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');
				//$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					
					$this->load->view('relatorio_rec/form_receitas_baixa', $data);
					
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {

						$data['bd']['QuitadoComissao'] = $data['query']['QuitadoComissao'];		
						
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						#### App_OrcaTrata ####
						$data['update']['orcamento']['anterior'] = $this->Relatorio_model_list->list_receitas($_SESSION['FiltroReceitas'], FALSE, TRUE, $_SESSION['FiltroReceitas']['Per_Page'], ($_SESSION['FiltroReceitas']['Pagina'] * $_SESSION['FiltroReceitas']['Per_Page']), TRUE);
						
						if (isset($data['orcamento']) || (!isset($data['orcamento']) && isset($data['update']['orcamento']['anterior']) ) ) {

							if (isset($data['orcamento']))
								$data['orcamento'] = array_values($data['orcamento']);
							else
								$data['orcamento'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['orcamento'] = $this->basico->tratamento_array_multidimensional($data['orcamento'], $data['update']['orcamento']['anterior'], 'idApp_OrcaTrata');
							
							$max = count($data['update']['orcamento']['alterar']);
							for($j=0;$j<$max;$j++) {

								if ($data['query']['QuitadoComissao'] == 'S') $data['update']['orcamento']['alterar'][$j]['FinalizadoOrca'] = 'S';
								
								if ($data['update']['orcamento']['alterar'][$j]['FinalizadoOrca'] == 'S') {

									$somacashback_produtos[$j] = 0;
									$data['update']['produto']['posterior'][$j] = $this->Orcatrata_model->get_produto_posterior($data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);
									if (isset($data['update']['produto']['posterior'][$j])){
										$max_produto = count($data['update']['produto']['posterior'][$j]);
										
										for($k=0;$k<$max_produto;$k++) {
											
											$somacashback_produtos[$j] += $data['update']['produto']['posterior'][$j][$k]['ValorComissaoCashBack'];
											
											$data['update']['produto']['posterior'][$j][$k]['ConcluidoProduto'] = 'S';
											if(!$data['update']['produto']['posterior'][$j][$k]['DataConcluidoProduto'] || $data['update']['produto']['posterior'][$j][$k]['DataConcluidoProduto'] == "0000-00-00"){
												$data['update']['produto']['posterior'][$j][$k]['DataConcluidoProduto'] = $this->basico->mascara_data($_SESSION['Orcamento'][$j]['DataEntregaOrca'], 'mysql');
											}
											if(!$data['update']['produto']['posterior'][$j][$k]['HoraConcluidoProduto'] || $data['update']['produto']['posterior'][$j][$k]['HoraConcluidoProduto'] == "00:00:00"){
												$data['update']['produto']['posterior'][$j][$k]['HoraConcluidoProduto'] = $_SESSION['Orcamento'][$j]['HoraEntregaOrca'];
											}
											
											$data['update']['produto']['bd'][$j] = $this->Orcatrata_model->update_produto_id($data['update']['produto']['posterior'][$j][$k], $data['update']['produto']['posterior'][$j][$k]['idApp_Produto']);
											////inicio do desconto do estoque////
											if(($_SESSION['Orcamento'][$j]['CombinadoFrete'] == "N" || $_SESSION['Orcamento'][$j]['AprovadoOrca'] == "N")  && $_SESSION['Orcamento'][$j]['CanceladoOrca'] == "N"){
												
												$data['get']['produto'][$j][$k] = $this->Orcatrata_model->get_tab_produtos($data['update']['produto']['posterior'][$j][$k]['idTab_Produtos_Produto']);
												if($data['get']['produto'][$j][$k]['ContarEstoque'] == "S"){
													$qtd_anterior[$j][$k]	= ($data['update']['produto']['posterior'][$j][$k]['QtdProduto'] * $data['update']['produto']['posterior'][$j][$k]['QtdIncrementoProduto']);
													$diff_estoque[$j][$k] 	= ($data['get']['produto'][$j][$k]['Estoque'] - $qtd_anterior[$j][$k]);
													if($diff_estoque[$j][$k] <= 0){
														$estoque[$j][$k] = 0; 
													}else{
														$estoque[$j][$k] = $diff_estoque[$j][$k]; 
													}
													
													$data['update']['produto'][$j][$k]['Estoque'] = $estoque[$j][$k];
													$data['update']['produto']['bd'][$j] = $this->Orcatrata_model->update_tab_produtos_id($data['update']['produto'][$j][$k], $data['update']['produto']['posterior'][$j][$k]['idTab_Produtos_Produto']);

													unset($qtd_anterior[$j][$k]);
													unset($diff_estoque[$j][$k]);
													unset($estoque[$j][$k]);
												}	
																			
											}
										}
										
									}
									
									if($_SESSION['Orcamento'][$j]['QuitadoOrca'] == "N" && $_SESSION['Orcamento'][$j]['CanceladoOrca'] == "N"){
										if(isset($_SESSION['Orcamento'][$j]['idApp_Cliente']) && $_SESSION['Orcamento'][$j]['idApp_Cliente'] !=0 && $_SESSION['Orcamento'][$j]['idApp_Cliente'] != ""){
											$data['cashback']['id_cliente'][$j] = $this->Orcatrata_model->get_cliente($_SESSION['Orcamento'][$j]['idApp_Cliente']);
											
											$cashback_anterior_cliente[$j] = $data['cashback']['id_cliente'][$j]['CashBackCliente'];
											
											$cashback_anterior_cliente[$j] = floatval ($cashback_anterior_cliente[$j]);
											$somacashback_produtos[$j] = floatval ($somacashback_produtos[$j]);
											
											$data['update']['id_cliente'][$j]['CashBackCliente'] = $cashback_anterior_cliente[$j] + $somacashback_produtos[$j];
											$data['update']['id_cliente'][$j]['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
											
											$data['update']['id_cliente']['bd'][$j] = $this->Cliente_model->update_cliente($data['update']['id_cliente'][$j], $_SESSION['Orcamento'][$j]['idApp_Cliente']);
											
											unset($cashback_anterior_cliente[$j]);
											unset($somacashback_produtos[$j]);
										}	
									}
									
									$data['update']['parcelasrec']['posterior'][$j] = $this->Orcatrata_model->get_parcelas_posterior($data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);
									if (isset($data['update']['parcelasrec']['posterior'][$j])){
										$max_parcela = count($data['update']['parcelasrec']['posterior'][$j]);
										
										for($k=0;$k<$max_parcela;$k++) {
											
											$data['update']['parcelasrec']['posterior'][$j][$k]['Quitado'] = 'S';
											if(!$data['update']['parcelasrec']['posterior'][$j][$k]['DataPago'] || empty($data['update']['parcelasrec']['posterior'][$j][$k]['DataPago']) || $data['update']['parcelasrec']['posterior'][$j][$k]['DataPago'] == "0000-00-00" ){
												$data['update']['parcelasrec']['posterior'][$j][$k]['DataPago'] = $data['update']['parcelasrec']['posterior'][$j][$k]['DataVencimento'];
											}
											
											if(!$data['update']['parcelasrec']['posterior'][$j][$k]['DataLanc'] || empty($data['update']['parcelasrec']['posterior'][$j][$k]['DataLanc']) || $data['update']['parcelasrec']['posterior'][$j][$k]['DataLanc'] == "0000-00-00" ){
												$data['update']['parcelasrec']['posterior'][$j][$k]['DataLanc'] = date('Y-m-d', time());
											}
											
											$data['update']['parcelasrec']['bd'][$j] = $this->Orcatrata_model->update_parcelas_id($data['update']['parcelasrec']['posterior'][$j][$k], $data['update']['parcelasrec']['posterior'][$j][$k]['idApp_Parcelas']);
										
										}
									}
									
									$data['update']['procedimento']['posterior'][$j] = $this->Orcatrata_model->get_procedimento_posterior($data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);
									if (isset($data['update']['procedimento']['posterior'][$j])){
										$max_parcela = count($data['update']['procedimento']['posterior'][$j]);
										
										for($k=0;$k<$max_parcela;$k++) {
											
											$data['update']['procedimento']['posterior'][$j][$k]['ConcluidoProcedimento'] = 'S';
										
											$data['update']['procedimento']['bd'][$j] = $this->Orcatrata_model->update_procedimento_id($data['update']['procedimento']['posterior'][$j][$k], $data['update']['procedimento']['posterior'][$j][$k]['idApp_Procedimento']);
										
										}
									}
									
									$data['update']['orcamento']['alterar'][$j]['CombinadoFrete'] = 'S';
									$data['update']['orcamento']['alterar'][$j]['AprovadoOrca'] = 'S';
									$data['update']['orcamento']['alterar'][$j]['ProntoOrca'] = 'S';
									$data['update']['orcamento']['alterar'][$j]['EnviadoOrca'] = 'S';
									$data['update']['orcamento']['alterar'][$j]['ConcluidoOrca'] = 'S';
									$data['update']['orcamento']['alterar'][$j]['QuitadoOrca'] = 'S';
										
								}
								
								$data['update']['orcamento']['bd'] = $this->Orcatrata_model->update_orcatrata($data['update']['orcamento']['alterar'][$j], $data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);

							}
						}

						$data['msg'] = '?m=1';
						
						unset($_SESSION['FiltroReceitas']['SomaTotal']);

						redirect(base_url() . 'relatorio_rec/receitas_baixa/' . $_SESSION['log']['idSis_Empresa'] . '/' . $_SESSION['FiltroReceitas']['Pagina_atual'] . $data['msg']);

						exit();	
					}
				}
			}
		}	
        $this->load->view('basico/footer');

    }
	
}