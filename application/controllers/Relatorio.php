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

	public function admin() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
        if($_SESSION['log']['idSis_Empresa'] == 5){
			$data['query'] = $this->Associado_model->get_associado($_SESSION['log']['idSis_Usuario'], TRUE);
		}else{
			$data['query'] = $this->Usuario_model->get_usuario($_SESSION['log']['idSis_Usuario'], TRUE);
		}

		$data['titulo1'] = 'Cadastrar';
		$data['titulo2'] = 'Finanças & Estoque';
		$data['titulo3'] = 'Relatório 3';
		$data['titulo4'] = 'Comissão';
		
		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorio/tela_admin', $data);

        $this->load->view('basico/footer');

    }

	public function agendamentos() {

		unset($_SESSION['Agendamentos']);

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
			'Texto1',
			'Texto2',
			'Texto3',
			'Texto4',
			'Texto5',
			'nomedoCliente',
			'idCliente',
			'numerodopedido',
			'datahora',
			'site',
        ), TRUE));

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';

        $data['select']['Tipo'] = array (
            '0' => '::Todos::',
			'2' => 'C/Cliente',
			'1' => 'S/Cliente',
        );
		
		$data['select']['Agrupar'] = array(	
			'1' => 'Agenda',
			'2' => 'Produto',
		);		
		 		
		$data['select']['Campo'] = array(
			'CO.DataInicio' => 'Data',
			'CO.idApp_Consulta' => 'id do Agendamento',
		);		
		
        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeUsuario'] = $this->Agenda_model->select_associado();
		
        $data['select']['nomedoCliente'] = $this->Basico_model->select_status_sn();
        $data['select']['idCliente'] = $this->Basico_model->select_status_sn();
        $data['select']['numerodopedido'] = $this->Basico_model->select_status_sn();
        $data['select']['datahora'] = $this->Basico_model->select_status_sn();
        $data['select']['site'] = $this->Basico_model->select_status_sn();
		
		$data['radio'] = array(
            'nomedoCliente' => $this->basico->radio_checked($data['query']['nomedoCliente'], 'nomedoCliente', 'NS'),
        );
        ($data['query']['nomedoCliente'] == 'S') ?
            $data['div']['nomedoCliente'] = '' : $data['div']['nomedoCliente'] = 'style="display: none;"';		
		
		$data['radio'] = array(
            'idCliente' => $this->basico->radio_checked($data['query']['idCliente'], 'idCliente', 'NS'),
        );
        ($data['query']['idCliente'] == 'S') ?
            $data['div']['idCliente'] = '' : $data['div']['idCliente'] = 'style="display: none;"';		
		
		$data['radio'] = array(
            'numerodopedido' => $this->basico->radio_checked($data['query']['numerodopedido'], 'numerodopedido', 'NS'),
        );
        ($data['query']['numerodopedido'] == 'S') ?
            $data['div']['numerodopedido'] = '' : $data['div']['numerodopedido'] = 'style="display: none;"';		
				
		$data['radio'] = array(
            'datahora' => $this->basico->radio_checked($data['query']['datahora'], 'datahora', 'NS'),
        );
        ($data['query']['datahora'] == 'S') ?
            $data['div']['datahora'] = '' : $data['div']['datahora'] = 'style="display: none;"';		
		
		$data['radio'] = array(
            'site' => $this->basico->radio_checked($data['query']['site'], 'site', 'NS'),
        );
        ($data['query']['site'] == 'S') ?
            $data['div']['site'] = '' : $data['div']['site'] = 'style="display: none;"';		
									
		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Lista de Agendamentos';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/agendamentos';
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
		$data['paginacao'] = 'N';	

        $_SESSION['Agendamentos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['Agendamentos']['DataFim'] 	= $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$_SESSION['Agendamentos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['Agendamentos']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
		$_SESSION['Agendamentos']['idApp_ClientePet2'] = $data['query']['idApp_ClientePet2'];
		$_SESSION['Agendamentos']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
		$_SESSION['Agendamentos']['idApp_ClienteDep2'] = $data['query']['idApp_ClienteDep2'];
		$_SESSION['Agendamentos']['Campo'] = $data['query']['Campo'];
		$_SESSION['Agendamentos']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['Agendamentos']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['Agendamentos']['Recorrencia'] = $data['query']['Recorrencia'];
		$_SESSION['Agendamentos']['Tipo'] = $data['query']['Tipo'];
		$_SESSION['Agendamentos']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['Agendamentos']['Repeticao'] = $data['query']['Repeticao'];	
		
		$_SESSION['Agendamentos']['Texto1'] = utf8_encode($data['query']['Texto1']);
        $_SESSION['Agendamentos']['Texto2'] = utf8_encode($data['query']['Texto2']);
        $_SESSION['Agendamentos']['Texto3'] = utf8_encode($data['query']['Texto3']);
        $_SESSION['Agendamentos']['Texto4'] = utf8_encode($data['query']['Texto4']);
        $_SESSION['Agendamentos']['Texto5'] = utf8_encode($data['query']['Texto5']);
        $_SESSION['Agendamentos']['nomedoCliente'] = $data['query']['nomedoCliente'];
        $_SESSION['Agendamentos']['idCliente'] = $data['query']['idCliente'];
        $_SESSION['Agendamentos']['numerodopedido'] = $data['query']['numerodopedido'];
        $_SESSION['Agendamentos']['datahora'] = $data['query']['datahora'];
        $_SESSION['Agendamentos']['site'] = $data['query']['site'];	

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
        $this->form_validation->set_rules('Texto1', 'Texto1', 'trim');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$data['bd']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
			$data['bd']['idApp_ClientePet2'] = $data['query']['idApp_ClientePet2'];
			$data['bd']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
			$data['bd']['idApp_ClienteDep2'] = $data['query']['idApp_ClienteDep2'];
			$data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['Recorrencia'] = $data['query']['Recorrencia'];
			$data['bd']['Tipo'] = $data['query']['Tipo'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['Repeticao'] = $data['query']['Repeticao'];
			
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

	public function ultimopedido() {
		
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
			#'1' => 'Último Pedido',
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
		$data['select']['DiaAniv'] = $this->Relatorio_model->select_dia();
		$data['select']['MesAniv'] = $this->Relatorio_model->select_mes();
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
		$data['form_open_path'] = 'relatorio/ultimopedido';
		$data['baixatodas'] = 'Orcatrata/baixadasreceitas/';
		$data['editartodas'] = 'relatorio/receitas/';
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
		$_SESSION['FiltroAlteraParcela']['DiaAniv'] = $data['query']['DiaAniv'];
        $_SESSION['FiltroAlteraParcela']['MesAniv'] = $data['query']['MesAniv'];
        $_SESSION['FiltroAlteraParcela']['AnoAniv'] = $data['query']['AnoAniv'];
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
		
		$_SESSION['FiltroAlteraParcela']['Texto1'] = utf8_encode($data['query']['Texto1']);
        $_SESSION['FiltroAlteraParcela']['Texto2'] = utf8_encode($data['query']['Texto2']);
        $_SESSION['FiltroAlteraParcela']['Texto3'] = utf8_encode($data['query']['Texto3']);
        $_SESSION['FiltroAlteraParcela']['Texto4'] = utf8_encode($data['query']['Texto4']);
        $_SESSION['FiltroAlteraParcela']['nomedoCliente'] = $data['query']['nomedoCliente'];
        $_SESSION['FiltroAlteraParcela']['idCliente'] = $data['query']['idCliente'];
        $_SESSION['FiltroAlteraParcela']['numerodopedido'] = $data['query']['numerodopedido'];
        $_SESSION['FiltroAlteraParcela']['site'] = $data['query']['site'];
		
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
			$data['bd']['DiaAniv'] = $data['query']['DiaAniv'];
			$data['bd']['MesAniv'] = $data['query']['MesAniv'];
			$data['bd']['AnoAniv'] = $data['query']['AnoAniv'];
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
			
			#$data['report'] = $this->Relatorio_model->list_ultimopedido($data['bd'],TRUE);
			$data['pesquisa_query'] = $this->Relatorio_model->list_ultimopedido($data['bd'],TRUE, TRUE);
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			//$config['total_rows'] = $this->Relatorio_model->list_ultimopedido($data['bd'],TRUE, TRUE);			
			$config['base_url'] = base_url() . 'relatorio_pag/ultimopedido_pag/';
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
			$data['report'] = $this->Relatorio_model->list_ultimopedido($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list1'] = $this->load->view('relatorio/list_ultimopedido', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_ultimopedido', $data);

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
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa está muito grande, ela excedeu 12000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
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
		$data['form_open_path'] = 'relatorio/receitas';
		$data['baixatodas'] = 'Orcatrata/baixadasreceitas/';
		$data['editartodas'] = 'relatorio/receitas/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio/baixadasreceitas/';
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

			$data['pesquisa_query'] = $this->Relatorio_model->list_receitas($_SESSION['FiltroReceitas'],TRUE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio/receitas' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();			
				
				$config['base_url'] = base_url() . 'relatorio_pag/receitas_pag/';
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

				$data['report'] = $this->Relatorio_model->list_receitas($_SESSION['FiltroReceitas'], TRUE, FALSE, $config['per_page'], $data['linha']);		

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
				
				$data['list1'] = $this->load->view('relatorio/list_receitas', $data, TRUE);
			}	
        }		

        $this->load->view('relatorio/tela_receitas', $data);

        $this->load->view('basico/footer');

    }
	
	public function despesas() {
		
		unset($_SESSION['FiltroDespesas']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Despesa Não Encontrada.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa está muito grande, ela excedeu 12000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
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
		
        $data['select']['Agrupar'] = array(
			'idApp_OrcaTrata' => 'Orçamento',
			'idApp_Fornecedor' => 'Fornecedor',
        );
		
        $data['select']['Ultimo'] = array(
			'0' => '::Nenhum::',	
        );
		
        $data['select']['Campo'] = array(
			'OT.idApp_OrcaTrata' => 'id do Pedido',
			'OT.DataOrca' => 'Data do Pedido',
			'PRDS.DataConcluidoProduto' => 'Data da Entrega',
			'PRDS.HoraConcluidoProduto' => 'Hora da Entrega',
			'F.idApp_Fornecedor' => 'id do Fornecedor',
			'F.NomeFornecedor' => 'Nome do Fornecedor',
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

		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();	
		$data['select']['DiaAniv'] = $this->Relatorio_model->select_dia();
		$data['select']['MesAniv'] = $this->Relatorio_model->select_mes();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		
        $data['select']['nomedoFornecedor'] = $this->Basico_model->select_status_sn();
        $data['select']['idFornecedor'] = $this->Basico_model->select_status_sn();
        $data['select']['numerodopedido'] = $this->Basico_model->select_status_sn();
        $data['select']['site'] = $this->Basico_model->select_status_sn();
		
 		(!$data['query']['nomedoFornecedor']) ? $data['query']['nomedoFornecedor'] = 'N' : FALSE;
		$data['radio'] = array(
            'nomedoFornecedor' => $this->basico->radio_checked($data['query']['nomedoFornecedor'], 'nomedoFornecedor', 'NS'),
        );
        ($data['query']['nomedoFornecedor'] == 'S') ?
            $data['div']['nomedoFornecedor'] = '' : $data['div']['nomedoFornecedor'] = 'style="display: none;"';		

 		(!$data['query']['idFornecedor']) ? $data['query']['idFornecedor'] = 'N' : FALSE;
		$data['radio'] = array(
            'idFornecedor' => $this->basico->radio_checked($data['query']['idFornecedor'], 'idFornecedor', 'NS'),
        );
        ($data['query']['idFornecedor'] == 'S') ?
            $data['div']['idFornecedor'] = '' : $data['div']['idFornecedor'] = 'style="display: none;"';
			
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
		
		$data['query']['nome'] = 'Fornecedor';
        $data['titulo'] = 'Despesas';
		$data['form_open_path'] = 'relatorio/despesas';
		$data['baixatodas'] = 'Orcatrata/baixadasdespesas/';
		$data['editartodas'] = 'relatorio/despesas/';
		$data['baixa'] = 'Orcatrata/baixadadespesa/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio/despesas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'Relatorio_print/debitos_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/debitos_recibo/';
		$data['edit'] = 'Orcatrata/alterardesp/';
		$data['alterarparc'] = 'Orcatrata/alterarparceladesp/';	
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

			$_SESSION['FiltroDespesas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$_SESSION['FiltroDespesas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$_SESSION['FiltroDespesas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$_SESSION['FiltroDespesas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$_SESSION['FiltroDespesas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
			$_SESSION['FiltroDespesas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$_SESSION['FiltroDespesas']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
			$_SESSION['FiltroDespesas']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$_SESSION['FiltroDespesas']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
			$_SESSION['FiltroDespesas']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');
			$_SESSION['FiltroDespesas']['DataInicio6'] = $this->basico->mascara_data($data['query']['DataInicio6'], 'mysql');
			$_SESSION['FiltroDespesas']['DataFim6'] = $this->basico->mascara_data($data['query']['DataFim6'], 'mysql');
			$_SESSION['FiltroDespesas']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
			$_SESSION['FiltroDespesas']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$_SESSION['FiltroDespesas']['HoraInicio5'] = $data['query']['HoraInicio5'];
			$_SESSION['FiltroDespesas']['HoraFim5'] = $data['query']['HoraFim5'];
			$_SESSION['FiltroDespesas']['Produtos'] = $data['query']['Produtos'];
			$_SESSION['FiltroDespesas']['Parcelas'] = $data['query']['Parcelas'];
			$_SESSION['FiltroDespesas']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$_SESSION['FiltroDespesas']['NomeAssociado'] = $data['query']['NomeAssociado'];
			$_SESSION['FiltroDespesas']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
			$_SESSION['FiltroDespesas']['DiaAniv'] = $data['query']['DiaAniv'];
			$_SESSION['FiltroDespesas']['MesAniv'] = $data['query']['MesAniv'];
			$_SESSION['FiltroDespesas']['AnoAniv'] = $data['query']['AnoAniv'];
			$_SESSION['FiltroDespesas']['Quitado'] = $data['query']['Quitado'];
			$_SESSION['FiltroDespesas']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$_SESSION['FiltroDespesas']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$_SESSION['FiltroDespesas']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$_SESSION['FiltroDespesas']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$_SESSION['FiltroDespesas']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$_SESSION['FiltroDespesas']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$_SESSION['FiltroDespesas']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$_SESSION['FiltroDespesas']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$_SESSION['FiltroDespesas']['AVAP'] = $data['query']['AVAP'];
			$_SESSION['FiltroDespesas']['TipoFrete'] = $data['query']['TipoFrete'];
			$_SESSION['FiltroDespesas']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$_SESSION['FiltroDespesas']['DevolvidoProduto'] = $data['query']['DevolvidoProduto'];
			$_SESSION['FiltroDespesas']['ConcluidoServico'] = $data['query']['ConcluidoServico'];
			$_SESSION['FiltroDespesas']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$_SESSION['FiltroDespesas']['Orcamento'] = $data['query']['Orcamento'];
			$_SESSION['FiltroDespesas']['Fornecedor'] = $data['query']['Fornecedor'];
			$_SESSION['FiltroDespesas']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
			$_SESSION['FiltroDespesas']['Modalidade'] = $data['query']['Modalidade'];
			$_SESSION['FiltroDespesas']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroDespesas']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['FiltroDespesas']['metodo'] = $data['metodo'];
			$_SESSION['FiltroDespesas']['idTab_TipoRD'] = $data['TipoRD'];
			$_SESSION['FiltroDespesas']['Agrupar'] = $data['query']['Agrupar'];
			$_SESSION['FiltroDespesas']['Ultimo'] = $data['query']['Ultimo'];
			$_SESSION['FiltroDespesas']['nome'] = $data['query']['nome'];

			$data['pesquisa_query'] = $this->Relatorio_model->list_despesas($_SESSION['FiltroDespesas'],TRUE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio/despesas' . $data['msg']);
				exit();
			}else{

				$_SESSION['FiltroDespesas']['total_valor'] = $data['pesquisa_query']->soma2->somafinal2;
				
				$_SESSION['FiltroDespesas']['total_rows'] = $config['total_rows'] = $data['pesquisa_query']->num_rows();			

				$config['base_url'] = base_url() . 'relatorio_pag/despesas_pag/';

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
			
				$data['report'] = $this->Relatorio_model->list_despesas($_SESSION['FiltroDespesas'], TRUE, FALSE, $config['per_page'], $data['linha']);
			
				$_SESSION['FiltroDespesas']['Limit'] = $data['per_page'];
				$_SESSION['FiltroDespesas']['Start'] = $data['linha'];
				$_SESSION['FiltroDespesas']['Texto1'] = utf8_encode($data['query']['Texto1']);
				$_SESSION['FiltroDespesas']['Texto2'] = utf8_encode($data['query']['Texto2']);
				$_SESSION['FiltroDespesas']['Texto3'] = utf8_encode($data['query']['Texto3']);
				$_SESSION['FiltroDespesas']['Texto4'] = utf8_encode($data['query']['Texto4']);
				$_SESSION['FiltroDespesas']['nomedoFornecedor'] = $data['query']['nomedoFornecedor'];
				$_SESSION['FiltroDespesas']['idFornecedor'] = $data['query']['idFornecedor'];
				$_SESSION['FiltroDespesas']['numerodopedido'] = $data['query']['numerodopedido'];
				$_SESSION['FiltroDespesas']['site'] = $data['query']['site'];

				$data['pagination'] = $this->pagination->create_links();

				$data['list1'] = $this->load->view('relatorio/list_despesas', $data, TRUE);
			}	
        }		

        $this->load->view('relatorio/tela_despesas', $data);

        $this->load->view('basico/footer');

    }

	public function comissao() {
		
		unset($_SESSION['FiltroComissao']);
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Receita Não Encontrada.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa está muito grande, ela excedeu 12000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Um Colaborador deve ser Selecionado. Refaça o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 6)
            $data['msg'] = $this->basico->msg('<strong>A quantidade de Receitas deve ser maior ou igual a 1. Refaça o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
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
			'StatusComissaoOrca',
			'Modalidade',
			'AVAP',
			'Tipo_Orca',
			'FormaPagamento',
			'TipoFrete',
			'Produtos',
			'Parcelas',
			'nome',
			'Recibo',
			'id_Recibo',
        ), TRUE));

		
        $data['select']['Recibo'] = array(
			'0' => '::TODOS::',
			'OT.id_Recibo != 0 ' => 'C/ Recibo',
			'OT.id_Recibo = 0 ' => 'S/ Recibo',
        );

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
		
		$data['select']['StatusComissaoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'NãoPaga',
            'S' => 'Paga',
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

        $data['select']['Campo'] = array(
			'OT.idApp_OrcaTrata' => 'id do Pedido',
			'OT.DataOrca' => 'Data do Pedido',
			'PRDS.DataConcluidoProduto' => 'Data da Entrega',
			'PRDS.HoraConcluidoProduto' => 'Hora da Entrega',
			'C.idApp_Cliente' => 'id do Cliente',
			'C.NomeCliente' => 'Nome do Cliente',
			'US.Nome' => 'Nome do Colaborador',
			'OT.DataPagoComissaoOrca' => 'Data Pago Comissão',
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

		$data['select']['NomeUsuario'] = $this->Relatorio_model->select_usuario();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();

		$data['query']['nome'] = 'Cliente';
		$data['titulo'] = 'Comissão Colaborador';
		$data['form_open_path'] = 'relatorio/comissao';
		$data['baixatodas'] = 'Orcatrata/baixadacomissao/';
		$data['recibo'] = 'Orcatrata/recibodacomissao/';
		$data['editartodas'] = 'relatorio/receitas/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
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
		$data['imprimirlista'] = 'Relatorio_print/comissao_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/comissao_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';
		$data['Associado'] = 0;
		$data['Vendedor'] = 1;

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

		$this->form_validation->set_rules('DataInicio7', 'Data Pago Com. Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim7', 'Data Pago Com.Fim', 'trim|valid_date');
		$this->form_validation->set_rules('HoraInicio5', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim5', 'Hora Final', 'trim|valid_hour');
				
        #run form validation
        if ($this->form_validation->run() !== FALSE) {
			
			$_SESSION['FiltroComissao']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$_SESSION['FiltroComissao']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$_SESSION['FiltroComissao']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$_SESSION['FiltroComissao']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$_SESSION['FiltroComissao']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
			$_SESSION['FiltroComissao']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$_SESSION['FiltroComissao']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
			$_SESSION['FiltroComissao']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$_SESSION['FiltroComissao']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
			$_SESSION['FiltroComissao']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');

			$_SESSION['FiltroComissao']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
			$_SESSION['FiltroComissao']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$_SESSION['FiltroComissao']['HoraInicio5'] = $data['query']['HoraInicio5'];
			$_SESSION['FiltroComissao']['HoraFim5'] = $data['query']['HoraFim5'];
			$_SESSION['FiltroComissao']['Produtos'] = $data['query']['Produtos'];
			$_SESSION['FiltroComissao']['Parcelas'] = $data['query']['Parcelas'];
			$_SESSION['FiltroComissao']['Recibo'] = $data['query']['Recibo'];
			$_SESSION['FiltroComissao']['id_Recibo'] = $data['query']['id_Recibo'];
			$_SESSION['FiltroComissao']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$_SESSION['FiltroComissao']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$_SESSION['FiltroComissao']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$_SESSION['FiltroComissao']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$_SESSION['FiltroComissao']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$_SESSION['FiltroComissao']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$_SESSION['FiltroComissao']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$_SESSION['FiltroComissao']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$_SESSION['FiltroComissao']['Quitado'] = $data['query']['Quitado'];
			$_SESSION['FiltroComissao']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
			$_SESSION['FiltroComissao']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$_SESSION['FiltroComissao']['AVAP'] = $data['query']['AVAP'];
			$_SESSION['FiltroComissao']['TipoFrete'] = $data['query']['TipoFrete'];
			$_SESSION['FiltroComissao']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$_SESSION['FiltroComissao']['Orcamento'] = $data['query']['Orcamento'];
			$_SESSION['FiltroComissao']['Cliente'] = $data['query']['Cliente'];
			$_SESSION['FiltroComissao']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$_SESSION['FiltroComissao']['Modalidade'] = $data['query']['Modalidade'];
			$_SESSION['FiltroComissao']['nome'] = $data['query']['nome'];
			$_SESSION['FiltroComissao']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroComissao']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['FiltroComissao']['metodo'] = $data['metodo'];
			$_SESSION['FiltroComissao']['idTab_TipoRD'] = $data['TipoRD'];

			$data['pesquisa_query'] = $this->Relatorio_model->list_comissao($_SESSION['FiltroComissao'],TRUE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio/comissao' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();			
				
				$config['base_url'] = base_url() . 'relatorio_pag/comissao_pag/';
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

				$data['report'] = $this->Relatorio_model->list_comissao($_SESSION['FiltroComissao'], TRUE, FALSE, $config['per_page'], $data['linha']);		

				$_SESSION['FiltroComissao']['Limit'] = $data['per_page'];
				$_SESSION['FiltroComissao']['Start'] = $data['linha'];

				$data['pagination'] = $this->pagination->create_links();
				
				$data['list1'] = $this->load->view('relatorio/list_comissao', $data, TRUE);
			}	
        }		

        $this->load->view('relatorio/tela_comissao', $data);

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
			'Parcelas',
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
			#'1' => 'Último Pedido',			
			#'2' => 'Última Parcela',
        );	

        $data['select']['Campo'] = array(
			'OT.DataOrca' => 'Data do Pedido',
			'OT.DataEntregaOrca' => 'Data da Entrega',
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

		$data['select']['NomeUsuario'] = $this->Relatorio_model->select_usuario();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Despesas'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['DiaAniv'] = $this->Relatorio_model->select_dia();
		$data['select']['MesAniv'] = $this->Relatorio_model->select_mes();		
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		//$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		$data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresa();
		
		$data['query']['nome'] = 'Cliente';
		$data['form_open_path'] = 'relatorio/comissao_online';
		$data['baixatodas'] = 'Orcatrata/baixadacomissao_online/';
		$data['editartodas'] = 'relatorio/receitas/';
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
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
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
        $_SESSION['FiltroAlteraParcela']['HoraInicio5'] = $data['query']['HoraInicio5'];
		$_SESSION['FiltroAlteraParcela']['HoraFim5'] = $data['query']['HoraFim5'];
		$_SESSION['FiltroAlteraParcela']['Produtos'] = $data['query']['Produtos'];
		$_SESSION['FiltroAlteraParcela']['Parcelas'] = $data['query']['Parcelas'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		//$_SESSION['FiltroAlteraParcela']['NomeCliente'] = $data['query']['NomeCliente'];
		$_SESSION['FiltroAlteraParcela']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroAlteraParcela']['NomeAssociado'] = $data['query']['NomeAssociado'];
		$_SESSION['FiltroAlteraParcela']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroAlteraParcela']['DiaAniv'] = $data['query']['DiaAniv'];
        $_SESSION['FiltroAlteraParcela']['MesAniv'] = $data['query']['MesAniv'];
        $_SESSION['FiltroAlteraParcela']['AnoAniv'] = $data['query']['AnoAniv'];		
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
		$this->form_validation->set_rules('HoraInicio5', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim5', 'Hora Final', 'trim|valid_hour');
		
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
			$data['bd']['DiaAniv'] = $data['query']['DiaAniv'];
			$data['bd']['MesAniv'] = $data['query']['MesAniv'];
			$data['bd']['AnoAniv'] = $data['query']['AnoAniv'];
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
			$data['bd']['Parcelas'] = $data['query']['Parcelas'];
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
			$data['bd']['HoraInicio5'] = $this->basico->mascara_data($data['query']['HoraInicio5'], 'mysql');
            $data['bd']['HoraFim5'] = $this->basico->mascara_data($data['query']['HoraFim5'], 'mysql');
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
		
		unset($_SESSION['FiltroCobrancas']);

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
			'OT.idApp_Cliente' => 'Clientes',
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
		$data['form_open_path'] = 'relatorio/cobrancas';
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Relatorio_print/cobrancas_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['alterarparc'] = 'Orcatrata/baixadascobrancas/';	
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
			
			$data['pesquisa_query'] = $this->Relatorio_model->list_cobrancas($_SESSION['FiltroCobrancas'],TRUE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio/cobrancas' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();

				$config['base_url'] = base_url() . 'relatorio_pag/cobrancas_pag/';

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

				$data['report'] = $this->Relatorio_model->list_cobrancas($_SESSION['FiltroCobrancas'], TRUE, FALSE, $config['per_page'], $data['linha']);			
				
				$_SESSION['FiltroCobrancas']['Texto1'] = utf8_encode($data['query']['Texto1']);
				$_SESSION['FiltroCobrancas']['Texto2'] = utf8_encode($data['query']['Texto2']);
				$_SESSION['FiltroCobrancas']['Texto3'] = utf8_encode($data['query']['Texto3']);
				$_SESSION['FiltroCobrancas']['Texto4'] = utf8_encode($data['query']['Texto4']);
				$_SESSION['FiltroCobrancas']['nomedoCliente'] = $data['query']['nomedoCliente'];
				$_SESSION['FiltroCobrancas']['numerodopedido'] = $data['query']['numerodopedido'];

				$data['pagination'] = $this->pagination->create_links();

				$data['list1'] = $this->load->view('relatorio/list_cobrancas', $data, TRUE);
			}
        }

        $this->load->view('relatorio/tela_cobrancas', $data);

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

	public function vendidos() {	
		
		unset($_SESSION['Filtro_Vendidos']);

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
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'CombinadoFrete',
			'ConcluidoProduto',
			'Quitado',
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
				'OT.idApp_Cliente' => 'Cliente',
				'OT.idApp_ClientePet' => 'Animal',
			);
			
			$data['select']['Campo'] = array(
				'TCAT.Catprod' => 'Categoria',
				'PRDS.DataConcluidoProduto' => 'Data da Entr Prd',
				'PRDS.HoraConcluidoProduto' => 'Hora da Entr Prd',
				'PRDS.idApp_Produto' => 'Produto',
				'OT.idApp_OrcaTrata' => 'Orçamento',
				'OT.idApp_Cliente' => 'Cliente',
				'OT.idApp_ClientePet' => 'Animal',
			);
		}elseif($_SESSION['Empresa']['CadastrarDep'] == "S"){
			$data['select']['Agrupar'] = array(
				'PRDS.idApp_Produto' => 'Produto',
				'OT.idApp_OrcaTrata' => 'Orçamento',
				'OT.idApp_Cliente' => 'Cliente',
				'OT.idApp_ClienteDep' => 'Dependente',
			);
			
			$data['select']['Campo'] = array(
				'TCAT.Catprod' => 'Categoria',
				'PRDS.DataConcluidoProduto' => 'Data da Entr Prd',
				'PRDS.HoraConcluidoProduto' => 'Hora da Entr Prd',
				'PRDS.idApp_Produto' => 'Produto',
				'OT.idApp_OrcaTrata' => 'Orçamento',
				'OT.idApp_Cliente' => 'Cliente',
				'OT.idApp_ClienteDep' => 'Dependente',
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
		
        $data['select']['Parcelas'] = array(
			'0' => '::TODOS::',
			' = ' . $_SESSION['log']['idSis_Empresa'] . '' => 'C/ Parcelas',
			'IS NULL' => 'S/ Parcelas',
        );

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
        $data['titulo1'] = 'Receitas';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/vendidos';
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
		$data['paginacao'] = 'N';

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
		$_SESSION['Filtro_Vendidos']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['Filtro_Vendidos']['Orcades'] = $data['query']['Orcades'];
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
		$_SESSION['Filtro_Vendidos']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['Filtro_Vendidos']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['Filtro_Vendidos']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['Filtro_Vendidos']['Campo'] = $data['query']['Campo'];
		$_SESSION['Filtro_Vendidos']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['Filtro_Vendidos']['Produtos'] = $data['query']['Produtos'];
		$_SESSION['Filtro_Vendidos']['Parcelas'] = $data['query']['Parcelas'];
		$_SESSION['Filtro_Vendidos']['Categoria'] = $data['query']['Categoria'];
		$_SESSION['Filtro_Vendidos']['Agrupar'] = $data['query']['Agrupar'];

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

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$data['bd']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
			$data['bd']['idApp_ClientePet2'] = $data['query']['idApp_ClientePet2'];
			$data['bd']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
			$data['bd']['idApp_ClienteDep2'] = $data['query']['idApp_ClienteDep2'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Parcelas'] = $data['query']['Parcelas'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
            $data['bd']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];		
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
			$data['bd']['HoraInicio8'] = $this->basico->mascara_data($data['query']['HoraInicio8'], 'mysql');
            $data['bd']['HoraFim8'] = $this->basico->mascara_data($data['query']['HoraFim8'], 'mysql');
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
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Prod_Serv_Produto'] = $data['query']['Prod_Serv_Produto'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			
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
			$config['total_rows'] = $this->Relatorio_model->list_produtoseservicos($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_produtoseservicos($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();

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
			#'1' => 'Último Pedido',			
			#'2' => 'Última Parcela',
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
		$data['imprimirlista'] = 'Relatorio_print/debitos_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/debitos_recibo/';
		$data['edit'] = 'Orcatrata/baixadodebito/';
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
		$data['imprimirlista'] = 'Relatorio_print/cobrancas_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
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
		$data['imprimirlista'] = 'Relatorio_print/cobrancas_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
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

    public function sac() {
		
		unset($_SESSION['FiltroSac']);

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

        $data['select']['ConcluidoSac'] = array(
			'#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['CategoriaSac'] = array (
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
			'idApp_Sac' => 'Chamada',
			'idApp_Cliente' => 'Cliente',
        );
		
		$data['select']['Campo'] = array(
			'PRC.DataSac' => 'Data',
            'PRC.idApp_Sac' => 'id',
			'PRC.ConcluidoSac' => 'Concl.',
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
		
		$data['query']['TipoSac'] = 3;
		$data['query']['Marketing'] = 0;
		$data['query']['Fornecedor'] = 0;		
        $data['titulo1'] = 'Sac';
		$data['tipoproc'] = 3;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/sac';
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
		$data['paginacao'] = 'N';

		$_SESSION['FiltroSac']['idApp_Sac'] = $data['query']['idApp_Sac'];
		$_SESSION['FiltroSac']['CategoriaSac'] = $data['query']['CategoriaSac'];
		$_SESSION['FiltroSac']['Marketing'] = $data['query']['Marketing'];
		$_SESSION['FiltroSac']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroSac']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroSac']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroSac']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroSac']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroSac']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroSac']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroSac']['Compartilhar'] = $data['query']['Compartilhar'];
		$_SESSION['FiltroSac']['TipoSac'] = $data['query']['TipoSac'];
		$_SESSION['FiltroSac']['ConcluidoSac'] = $data['query']['ConcluidoSac'];
        $_SESSION['FiltroSac']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
		$_SESSION['FiltroSac']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
        $_SESSION['FiltroSac']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
		$_SESSION['FiltroSac']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
        $_SESSION['FiltroSac']['HoraInicio9'] = $data['query']['HoraInicio9'];
		$_SESSION['FiltroSac']['HoraFim9'] = $data['query']['HoraFim9'];
        $_SESSION['FiltroSac']['HoraInicio10'] = $data['query']['HoraInicio10'];
		$_SESSION['FiltroSac']['HoraFim10'] = $data['query']['HoraFim10'];
		$_SESSION['FiltroSac']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['FiltroSac']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroSac']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroSac']['Dia'] = $data['query']['Dia'];
		$_SESSION['FiltroSac']['Mesvenc'] = $data['query']['Mesvenc'];
		$_SESSION['FiltroSac']['Ano'] = $data['query']['Ano'];			
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		$this->form_validation->set_rules('DataInicio9', 'Data Início do Sac', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim9', 'Data Fim do Sac', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio10', 'Data Início do SubSac', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim10', 'Data Fim do SubSac', 'trim|valid_date');
		$this->form_validation->set_rules('HoraInicio9', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim9', 'Hora Final', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraInicio10', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim10', 'Hora Final', 'trim|valid_hour');

        #run form validation
        if ($this->form_validation->run() !== FALSE) {
            
			$data['bd']['idApp_Sac'] = $data['query']['idApp_Sac'];
			$data['bd']['CategoriaSac'] = $data['query']['CategoriaSac'];
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
			$data['bd']['ConcluidoSac'] = $data['query']['ConcluidoSac'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['TipoSac'] = $data['query']['TipoSac'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
            $data['bd']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
			$data['bd']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
            $data['bd']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
			$data['bd']['HoraInicio9'] = $this->basico->mascara_data($data['query']['HoraInicio9'], 'mysql');
            $data['bd']['HoraFim9'] = $this->basico->mascara_data($data['query']['HoraFim9'], 'mysql');
			$data['bd']['HoraInicio10'] = $this->basico->mascara_data($data['query']['HoraInicio10'], 'mysql');
            $data['bd']['HoraFim10'] = $this->basico->mascara_data($data['query']['HoraFim10'], 'mysql');

            //$data['report'] = $this->Relatorio_model->list_sac($data['bd'],TRUE);

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
			$config['total_rows'] = $this->Relatorio_model->list_sac($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_sac($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('relatorio/list_sac', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_sac', $data);

        $this->load->view('basico/footer');

    }

    public function marketing() {
		
		unset($_SESSION['FiltroMarketing']);

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
            'CategoriaMarketing',
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

        $data['select']['ConcluidoMarketing'] = array(
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
		
		$data['select']['CategoriaMarketing'] = array (
            '0' => 'Todos',
            '1' => 'Atualização',
            '2' => 'Pesquisa',
			'3' => 'Retorno',
            '4' => 'Promoções',
			'5' => 'Felicitações',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',
			'idApp_Marketing' => 'Campanha',
			'idApp_Cliente' => 'Cliente',
        );
		
		$data['select']['Campo'] = array(
			'PRC.DataMarketing' => 'Data',
            'PRC.idApp_Marketing' => 'id',
			'PRC.ConcluidoMarketing' => 'Concl.',
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

		$data['query']['TipoMarketing'] = 4;
		$data['query']['Sac'] = 0;
		$data['query']['Fornecedor'] = 0;		
        $data['titulo1'] = 'Marketing';
		$data['tipoproc'] = 4;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio/marketing';
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
		$data['paginacao'] = 'N';

		$_SESSION['FiltroMarketing']['idApp_Marketing'] = $data['query']['idApp_Marketing'];
		$_SESSION['FiltroMarketing']['Sac'] = $data['query']['Sac'];
		$_SESSION['FiltroMarketing']['CategoriaMarketing'] = $data['query']['CategoriaMarketing'];
		$_SESSION['FiltroMarketing']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroMarketing']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
		$_SESSION['FiltroMarketing']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroMarketing']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroMarketing']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroMarketing']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroMarketing']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['FiltroMarketing']['Compartilhar'] = $data['query']['Compartilhar'];
		$_SESSION['FiltroMarketing']['TipoMarketing'] = $data['query']['TipoMarketing'];
		$_SESSION['FiltroMarketing']['ConcluidoMarketing'] = $data['query']['ConcluidoMarketing'];
        $_SESSION['FiltroMarketing']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
		$_SESSION['FiltroMarketing']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
        $_SESSION['FiltroMarketing']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
		$_SESSION['FiltroMarketing']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
        $_SESSION['FiltroMarketing']['HoraInicio9'] = $data['query']['HoraInicio9'];
		$_SESSION['FiltroMarketing']['HoraFim9'] = $data['query']['HoraFim9'];
        $_SESSION['FiltroMarketing']['HoraInicio10'] = $data['query']['HoraInicio10'];
		$_SESSION['FiltroMarketing']['HoraFim10'] = $data['query']['HoraFim10'];
		$_SESSION['FiltroMarketing']['Agrupar'] = $data['query']['Agrupar'];
		$_SESSION['FiltroMarketing']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroMarketing']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroMarketing']['Dia'] = $data['query']['Dia'];
		$_SESSION['FiltroMarketing']['Mesvenc'] = $data['query']['Mesvenc'];
		$_SESSION['FiltroMarketing']['Ano'] = $data['query']['Ano'];		
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		$this->form_validation->set_rules('DataInicio9', 'Data Início do Marketing', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim9', 'Data Fim do Marketing', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio10', 'Data Início do SubMarketing', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim10', 'Data Fim do SubMarketing', 'trim|valid_date');
		$this->form_validation->set_rules('HoraInicio9', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim9', 'Hora Final', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraInicio10', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim10', 'Hora Final', 'trim|valid_hour');

        #run form validation
        if ($this->form_validation->run() !== FALSE) {
            
			$data['bd']['idApp_Marketing'] = $data['query']['idApp_Marketing'];
			$data['bd']['Sac'] = $data['query']['Sac'];
			$data['bd']['CategoriaMarketing'] = $data['query']['CategoriaMarketing'];
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
			$data['bd']['ConcluidoMarketing'] = $data['query']['ConcluidoMarketing'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['TipoMarketing'] = $data['query']['TipoMarketing'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
			$data['bd']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
            $data['bd']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
			$data['bd']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
            $data['bd']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
			$data['bd']['HoraInicio9'] = $this->basico->mascara_data($data['query']['HoraInicio9'], 'mysql');
            $data['bd']['HoraFim9'] = $this->basico->mascara_data($data['query']['HoraFim9'], 'mysql');
			$data['bd']['HoraInicio10'] = $this->basico->mascara_data($data['query']['HoraInicio10'], 'mysql');
            $data['bd']['HoraFim10'] = $this->basico->mascara_data($data['query']['HoraFim10'], 'mysql');

            //$data['report'] = $this->Relatorio_model->list_marketing($data['bd'],TRUE);

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
			$config['total_rows'] = $this->Relatorio_model->list_marketing($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Relatorio_model->list_marketing($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('relatorio/list_marketing', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_marketing', $data);

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
            'CombinadoFrete',
            'QuitadoOrca',
			'ConcluidoOrca',
			'Quitado',
			'Modalidade',
        ), TRUE));
		
		$_SESSION['FiltroBalanco']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroBalanco']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroBalanco']['Quitado'] = $data['query']['Quitado'];
        $_SESSION['FiltroBalanco']['Diavenc'] = $data['query']['Diavenc'];
        $_SESSION['FiltroBalanco']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroBalanco']['Ano'] = $data['query']['Ano'];
		
        $data['select']['AprovadoOrca'] = array(
			'0' => 'TODOS',
            'S' => 'Aprovado',
			'N' => 'Não Aprovado',
        );
		
        $data['select']['CombinadoFrete'] = array(
			'0' => 'TODOS',
            'S' => 'Aprovado',
			'N' => 'Não Aprovado',
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
            $data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
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
            $data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
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
		
		unset($_SESSION['FiltroRankingVendas']);

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

			$data['select']['Campo'] = array(
				'Valor' => 'Valor Pedido',
				'F.CashBackCliente' => 'Valor CashBach',
				'ContPedidos' => 'Pedidos',
				'F.NomeCliente' => 'Cliente',
				'F.idApp_Cliente' => 'Id',
				'F.UltimoPedido' => 'Ultimo Pedido',
			);

			$data['select']['Ordenamento'] = array(
				'DESC' => 'Decrescente',
				'ASC' => 'Crescente',
			);
			
			$data['select']['Ultimo'] = array(
				'0' => '::Nenhum::',			
				#'1' => 'Último Pedido',
			);		

			$data['titulo'] = 'Ranking de Vendas';
			$data['form_open_path'] = 'relatorio/rankingvendas';	
			$data['paginacao'] = 'N';
			$data['nome'] = 'Cliente';
			
			$_SESSION['FiltroRankingVendas']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$_SESSION['FiltroRankingVendas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$_SESSION['FiltroRankingVendas']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['FiltroRankingVendas']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroRankingVendas']['Pedidos_de'] = $data['query']['Pedidos_de'];
			$_SESSION['FiltroRankingVendas']['Pedidos_ate'] = $data['query']['Pedidos_ate'];
			$_SESSION['FiltroRankingVendas']['Valor_de'] = $data['query']['Valor_de'];
			$_SESSION['FiltroRankingVendas']['Valor_ate'] = $data['query']['Valor_ate'];
			$_SESSION['FiltroRankingVendas']['Valor_cash_de'] = $data['query']['Valor_cash_de'];
			$_SESSION['FiltroRankingVendas']['Valor_cash_ate'] = $data['query']['Valor_cash_ate'];
			$_SESSION['FiltroRankingVendas']['Ultimo'] = $data['query']['Ultimo'];
			
			$_SESSION['FiltroRankingVendas']['Texto1'] = utf8_encode($data['query']['Texto1']);
			$_SESSION['FiltroRankingVendas']['Texto2'] = utf8_encode($data['query']['Texto2']);
			$_SESSION['FiltroRankingVendas']['Texto3'] = utf8_encode($data['query']['Texto3']);
			$_SESSION['FiltroRankingVendas']['Texto4'] = utf8_encode($data['query']['Texto4']);	
			$_SESSION['FiltroRankingVendas']['nomedoCliente'] = $data['query']['nomedoCliente'];
			$_SESSION['FiltroRankingVendas']['idCliente'] = $data['query']['idCliente'];
			$_SESSION['FiltroRankingVendas']['numerodopedido'] = $data['query']['numerodopedido'];
			$_SESSION['FiltroRankingVendas']['site'] = $data['query']['site'];	
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
			#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
			$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio2', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim2', 'Data Fim', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio3', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim3', 'Data Fim', 'trim|valid_date');

			#run form validation
			if ($this->form_validation->run() !== FALSE) {

				$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
				$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
				$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
				$data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
				$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
				$data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
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
		}
		$this->load->view('basico/footer');

	}

    public function clientes() {
		
		unset($_SESSION['FiltroClientes']);
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Cliente Não Encontrado.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa está muito grande, ela excedeu 30000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
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
				'idApp_ClientePet2',
				'idApp_ClienteDep2',
				'Ativo',
				'Motivo',
				'Ordenamento',
				'Campo',
				'DataInicio',
				'DataFim',
				'DataInicio2',
				'DataFim2',
				'DataInicio3',
				'DataFim3',
				'Dia',
				'Mes',
				'Ano',
				'Texto1',
				'Texto2',
				'Texto3',
				'Texto4',
				'Agrupar',
				'Pedidos',
				'Sexo',
				'Pesquisa',
			), TRUE));

			$data['select']['Ativo'] = array(
				'#' => 'TODOS',
				'N' => 'Não',
				'S' => 'Sim',
			);
			
			$data['select']['Sexo'] = array(
				'0' => 'Todos',
				'1' => 'Masculino',
				'2' => 'Feminino',
				'3' => 'Outros',
			);
			
			if($_SESSION['Empresa']['CadastrarPet'] == "S"){
				$data['select']['Agrupar'] = array(
					'0' => 'Cliente/Pet',
					'idApp_Cliente' => 'Cliente',
				);
			}else{
				if($_SESSION['Empresa']['CadastrarDep'] == "S"){
					$data['select']['Agrupar'] = array(
						'0' => 'Cliente/Det',
						'idApp_Cliente' => 'Cliente',
					);
				}else{
					$data['select']['Agrupar'] = array(
						'idApp_Cliente' => 'Cliente',
					);
				}
			}	
				
			$data['select']['Pedidos'] = array(
				'0' => 'Todos',
				'1' => 'Clientes S/Pedidos',
				'2' => 'Clientes C/Pedidos',
			);
					
			$data['select']['Campo'] = array(
				'C.idApp_Cliente' => 'nº Cliente',
				'C.NomeCliente' => 'Nome do Cliente',
				'C.Ativo' => 'Ativo',
				'C.DataNascimento' => 'Data de Nascimento',
				'C.DataCadastroCliente' => 'Data do Cadastro',
				'C.Sexo' => 'Sexo',
				'C.BairroCliente' => 'Bairro',
				'C.MunicipioCliente' => 'Município',
				'C.Email' => 'E-mail',
				'CC.NomeContatoCliente' => 'Contato do Cliente',
				'TCC.RelaPes' => 'Rel. Pes.',
				'TCC.RelaCom' => 'Rel. Com.',
				'CC.Sexo' => 'Sexo',
				'C.UltimoPedido' => 'Ultimo Pedido',
				'C.ValidadeCashBack' => 'Validade CashBack',

			);

			$data['select']['Ordenamento'] = array(
				'ASC' => 'Crescente',
				'DESC' => 'Decrescente',
			);

			//$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
			$data['select']['Dia'] = $this->Relatorio_model->select_dia();
			$data['select']['Mes'] = $this->Relatorio_model->select_mes();
			$data['select']['Motivo'] = $this->Relatorio_model->select_motivo();
			
			$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

			$data['titulo'] = 'Clientes';
			$data['form_open_path'] = 'relatorio/clientes';
			
			$data['paginacao'] = 'N';

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
			$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'trim');
			$this->form_validation->set_rules('DataInicio', 'Data Início do Cadastro', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim', 'Data Fim do Cadastro', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio2', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim2', 'Data Fim', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio3', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim3', 'Data Fim', 'trim|valid_date');

			#run form validation
			if ($this->form_validation->run() !== FALSE) {

				$_SESSION['FiltroClientes']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
				$_SESSION['FiltroClientes']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
				$_SESSION['FiltroClientes']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
				$_SESSION['FiltroClientes']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
				$_SESSION['FiltroClientes']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
				$_SESSION['FiltroClientes']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');        
				$_SESSION['FiltroClientes']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
				$_SESSION['FiltroClientes']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
				$_SESSION['FiltroClientes']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
				$_SESSION['FiltroClientes']['idApp_ClientePet2'] = $data['query']['idApp_ClientePet2'];
				$_SESSION['FiltroClientes']['idApp_ClienteDep2'] = $data['query']['idApp_ClienteDep2'];
				$_SESSION['FiltroClientes']['Ativo'] = $data['query']['Ativo'];
				$_SESSION['FiltroClientes']['Motivo'] = $data['query']['Motivo'];
				$_SESSION['FiltroClientes']['Campo'] = $data['query']['Campo'];
				$_SESSION['FiltroClientes']['Ordenamento'] = $data['query']['Ordenamento'];
				$_SESSION['FiltroClientes']['Dia'] = $data['query']['Dia'];
				$_SESSION['FiltroClientes']['Mes'] = $data['query']['Mes'];
				$_SESSION['FiltroClientes']['Ano'] = $data['query']['Ano'];
				$_SESSION['FiltroClientes']['Agrupar'] = $data['query']['Agrupar'];
				$_SESSION['FiltroClientes']['Pedidos'] = $data['query']['Pedidos'];
				$_SESSION['FiltroClientes']['Sexo'] = $data['query']['Sexo'];
				$_SESSION['FiltroClientes']['Pesquisa'] = $data['query']['Pesquisa'];
					
				if(isset($_SESSION['FiltroClientes']['Agrupar']) && $_SESSION['FiltroClientes']['Agrupar'] != "0"){
					$_SESSION['FiltroClientes']['Aparecer'] = 0;
					$data['aparecer'] = 0;
				}else{
					$_SESSION['FiltroClientes']['Aparecer'] = 1;
					$data['aparecer'] = 1;
				}
					
				$data['pesquisa_query'] = $this->Relatorio_model->list_clientes($_SESSION['FiltroClientes'],TRUE, TRUE);

				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'relatorio/clientes' . $data['msg']);
					exit();
				}else{

					$config['total_rows'] = $data['pesquisa_query'];
					
					$config['base_url'] = base_url() . 'relatorio_pag/clientes_pag/';					
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

					if($config['total_rows'] >= 1){
						$data['total_rows'] = $config['total_rows'];
					}else{
						$data['total_rows'] = 0;
					}
					
					$this->pagination->initialize($config);
					
					$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
					$data['pagina'] = $page;
					$data['per_page'] = $config['per_page'];

					$data['report'] = $this->Relatorio_model->list_clientes($_SESSION['FiltroClientes'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
					
					$_SESSION['FiltroClientes']['Texto1'] = utf8_encode($data['query']['Texto1']);
					$_SESSION['FiltroClientes']['Texto2'] = utf8_encode($data['query']['Texto2']);
					$_SESSION['FiltroClientes']['Texto3'] = utf8_encode($data['query']['Texto3']);
					$_SESSION['FiltroClientes']['Texto4'] = utf8_encode($data['query']['Texto4']);					

					$data['pagination'] = $this->pagination->create_links();

					if($data['query']['idApp_Cliente']){
						if ($data['report']->num_rows() >= 1) {
							$info = $data['report']->result_array();
							redirect('cliente/prontuario/' . $info[0]['idApp_Cliente'] );
							exit();
						} else {
							$data['list'] = $this->load->view('relatorio/list_clientes', $data, TRUE);
						}				
					}else{
						$data['list'] = $this->load->view('relatorio/list_clientes', $data, TRUE);
					}
				}	
			}

			$this->load->view('relatorio/tela_clientes', $data);
		}
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
            'ConcluidoTarefa',
            'Prioridade',
			'idTab_Categoria',
			#'Rotina',
			'ConcluidoSubTarefa',
			'Tarefa',
			'SubTarefa',
			'SubPrioridade',
			'Statustarefa',
			'Statussubtarefa',
			'Agrupar',
        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
		
		$_SESSION['FiltroAlteraTarefa']['idTab_Categoria'] = $data['query']['idTab_Categoria'];
		$_SESSION['FiltroAlteraTarefa']['ConcluidoTarefa'] = $data['query']['ConcluidoTarefa'];
		$_SESSION['FiltroAlteraTarefa']['Prioridade'] = $data['query']['Prioridade'];
		$_SESSION['FiltroAlteraTarefa']['ConcluidoSubTarefa'] = $data['query']['ConcluidoSubTarefa'];
		$_SESSION['FiltroAlteraTarefa']['SubPrioridade'] = $data['query']['SubPrioridade'];
		$_SESSION['FiltroAlteraTarefa']['Statustarefa'] = $data['query']['Statustarefa'];
		$_SESSION['FiltroAlteraTarefa']['Statussubtarefa'] = $data['query']['Statussubtarefa'];
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['ConcluidoTarefa'] = array(
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
		$data['select']['ConcluidoSubTarefa'] = array(
            '0' => '::Todos::',
			'S' => 'Sim',
			'N' => 'Não',
			'M' => 'Com SubTarefa',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',			
			'idApp_Tarefa' => 'Tarefa',
        );

        $data['select']['Campo'] = array(
			'P.DataTarefa' => 'Data do Inicio',
			'P.DataTarefaLimite' => 'Data da Concl.',	
			'P.Compartilhar' => 'Quem Fazer',
			'P.idSis_Usuario' => 'Quem Cadastrou',		
			'P.ConcluidoTarefa' => 'Concluido',
			'P.idTab_Categoria' => 'Categoria',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

		$data['select']['idTab_Categoria'] = $this->Relatorio_model->select_categoria();
        #$data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional3();
		#$data['select']['Profissional'] = $this->Relatorio_model->select_profissional2();
		//$data['select']['Tarefa'] = $this->Relatorio_model->select_tarefa();
		//$data['select']['SubTarefa'] = $this->Relatorio_model->select_procedtarefa();

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
            $data['bd']['ConcluidoTarefa'] = $data['query']['ConcluidoTarefa'];
            $data['bd']['Prioridade'] = $data['query']['Prioridade'];
			$data['bd']['idTab_Categoria'] = $data['query']['idTab_Categoria'];
			#$data['bd']['Rotina'] = $data['query']['Rotina'];
			$data['bd']['ConcluidoSubTarefa'] = $data['query']['ConcluidoSubTarefa'];
			$data['bd']['Tarefa'] = $data['query']['Tarefa'];
			$data['bd']['SubTarefa'] = $data['query']['SubTarefa'];
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

	public function depoimento() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Depoimento',
			'Arquivo_Depoimento',
			'Texto_Depoimento',
			'Ativo_Depoimento',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['titulo'] = 'Depoimento';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['idApp_Depoimento'] = $data['query']['idApp_Depoimento'];
			$data['bd']['Arquivo_Depoimento'] = $data['query']['Arquivo_Depoimento'];
			$data['bd']['Texto_Depoimento'] = $data['query']['Texto_Depoimento'];
			$data['bd']['Ativo_Depoimento'] = $data['query']['Ativo_Depoimento'];

            $data['report'] = $this->Relatorio_model->list_depoimento($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_depoimento', $data, TRUE);

        }

        $this->load->view('relatorio/tela_depoimento', $data);

        $this->load->view('basico/footer');

    }

	public function atuacao() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Atuacao',
			'Arquivo_Atuacao',
			'Texto_Atuacao',
			'Ativo_Atuacao',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['titulo'] = 'Atuacao';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['idApp_Atuacao'] = $data['query']['idApp_Atuacao'];
			$data['bd']['Arquivo_Atuacao'] = $data['query']['Arquivo_Atuacao'];
			$data['bd']['Texto_Atuacao'] = $data['query']['Texto_Atuacao'];
			$data['bd']['Ativo_Atuacao'] = $data['query']['Ativo_Atuacao'];

            $data['report'] = $this->Relatorio_model->list_atuacao($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_atuacao', $data, TRUE);

        }

        $this->load->view('relatorio/tela_atuacao', $data);

        $this->load->view('basico/footer');

    }

	public function colaborador() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Colaborador',
			'Arquivo_Colaborador',
			'Texto_Colaborador',
			'Ativo_Colaborador',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['titulo'] = 'Colaborador';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['idApp_Colaborador'] = $data['query']['idApp_Colaborador'];
			$data['bd']['Arquivo_Colaborador'] = $data['query']['Arquivo_Colaborador'];
			$data['bd']['Texto_Colaborador'] = $data['query']['Texto_Colaborador'];
			$data['bd']['Ativo_Colaborador'] = $data['query']['Ativo_Colaborador'];

            $data['report'] = $this->Relatorio_model->list_colaborador($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_colaborador', $data, TRUE);

        }

        $this->load->view('relatorio/tela_colaborador', $data);

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
		$data['colab'] = $this->Relatorio_model->list5_colaboradores(TRUE);
		$data['depoim'] = $this->Relatorio_model->list6_depoimentos(TRUE);
		$data['atuacao'] = $this->Relatorio_model->list7_atuacao(TRUE);
		
		$data['list1'] = $this->load->view('relatorio/list1_produtos', $data, TRUE);
		$data['list2'] = $this->load->view('relatorio/list2_slides', $data, TRUE);		
		$data['list3'] = $this->load->view('relatorio/list3_logo_nav', $data, TRUE);
		$data['list4'] = $this->load->view('relatorio/list4_icone', $data, TRUE);
		$data['list5'] = $this->load->view('relatorio/list5_colaboradores', $data, TRUE);
		$data['list6'] = $this->load->view('relatorio/list6_depoimentos', $data, TRUE);
		$data['list7'] = $this->load->view('relatorio/list7_atuacao', $data, TRUE);
		
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
		
		if ($_SESSION['Empresa']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
				
			$_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
			$_SESSION['log']['idTab_Modulo'] = 1;

			#change error delimiter view
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			#Get GET or POST data
			$celular = $this->input->get_post('CelularAdmin');
			$empresa = $this->input->get_post('idSis_Empresa');
			$senha = md5($this->input->get_post('Senha'));

			#set validation rules

			$this->form_validation->set_rules('CelularAdmin', 'Celular do Admin', 'required|trim');
			$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
			$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5');
			
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

				$_SESSION['AdminUsuario'] = $query = $this->Loginempresa_model->check_dados_admin($empresa, $celular, $senha, TRUE);

				if ($query === FALSE) {
					
					unset($_SESSION['AdminUsuario']);
					
					$data['msg'] = $this->basico->msg('<strong>Celular ou Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);

					$this->load->view('relatorio/form_loginempresa', $data);

				} else {
					#initialize session
					$this->load->driver('session');

					$_SESSION['AdminEmpresa']  = $query2 = $this->Empresa_model->get_empresa($empresa, TRUE);
					
					if ($query2 === FALSE) {
						
						unset($_SESSION['AdminUsuario'], $_SESSION['AdminEmpresa']);
						
						$data['msg'] = $this->basico->msg('<strong>Celular ou Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);

						$this->load->view('relatorio/form_loginempresa', $data);

					} else {
						
						unset($_SESSION['log']);
						
						$_SESSION['log']['Nome'] = $query['Nome'];
						$_SESSION['log']['Nome2'] = (strlen($query['Nome']) > 6) ? substr($query['Nome'], 0, 6) : $query['Nome'];
						$_SESSION['log']['CpfAdmin'] = $query['CpfUsuario'];
						$_SESSION['log']['CelularAdmin'] = $query['CelularUsuario'];
						$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
						$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 15) ? substr($query['NomeEmpresa'], 0, 15) : $query['NomeEmpresa'];
						$_SESSION['log']['idSis_Usuario'] = $query['idSis_Usuario'];
						$_SESSION['log']['idTab_Modulo'] = $query['idTab_Modulo'];
						$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
						$_SESSION['log']['UsuarioEmpresa'] = $query2['UsuarioEmpresa'];
						$_SESSION['log']['PermissaoEmpresa'] = $query2['PermissaoEmp'];
						$_SESSION['log']['NivelEmpresa'] = $query2['NivelEmpresa'];
						$_SESSION['log']['DataCriacao'] = $query2['DataCriacao'];
						$_SESSION['log']['DataDeValidade'] = $query2['DataDeValidade'];
						$_SESSION['log']['Site'] = $query2['Site'];

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
							
							unset($_SESSION['Empresa']);
							unset($_SESSION['Usuario']);
							redirect('acessoempresa');
						}
					}	
				}
			}
		}
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