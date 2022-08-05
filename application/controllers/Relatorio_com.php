<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_com extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array(	'Basico_model', 'Cliente_model', 'Relatorio_model', 'Relatorio_model_list', 'Orcatrata_model', 'Empresa_model', 
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

        $this->load->view('relatorio_com/tela_index', $data);

        #load footer view
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
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa está muito grande, ela excedeu 15000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Um Vendedor deve ser Selecionado. Refaça o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
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
			'id_Comissao',
        ), TRUE));

		
        $data['select']['Recibo'] = array(
			'0' => '::TODOS::',
			'OT.id_Comissao != 0 ' => 'C/ Recibo',
			'OT.id_Comissao = 0 ' => 'S/ Recibo',
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
            'S' => 'Paga',
            'N' => 'NãoPaga',
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
			'US.Nome' => 'Nome do Vendedor',
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
		$data['titulo'] = 'Comissão Vendedor';
		$data['form_open_path'] = 'relatorio_com/comissao';
		$data['baixatodas'] = 'Relatorio_com/comissao_baixa/';
		$data['editartodas'] = 'relatorio_rec/receitas/';
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
		$data['imprimirlista'] = 'Relatorio_com/comissao_lista/';
		$data['imprimirrecibo'] = 'Relatorio_com/comissao_recibo/';
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
			$_SESSION['FiltroComissao']['id_Comissao'] = $data['query']['id_Comissao'];
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

			$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissao($_SESSION['FiltroComissao'], FALSE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio_com/comissao' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();			
				
				$config['base_url'] = base_url() . 'relatorio_com/comissao_pag/';
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

				$data['report'] = $this->Relatorio_model_list->list_comissao($_SESSION['FiltroComissao'], FALSE, FALSE, $config['per_page'], $data['linha']);		

				$_SESSION['FiltroComissao']['Limit'] = $data['per_page'];
				$_SESSION['FiltroComissao']['Start'] = $data['linha'];

				$data['pagination'] = $this->pagination->create_links();
				
				$data['list1'] = $this->load->view('relatorio_com/list_comissao', $data, TRUE);
			}	
        }		

        $this->load->view('relatorio_com/tela_comissao', $data);

        $this->load->view('basico/footer');

    }

	public function comissao_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Um Colaborador deve ser Selecionado. Refaça o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 6)
            $data['msg'] = $this->basico->msg('<strong>A quantidade de Receitas deve ser maior ou igual a 1. Refaça o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		//$data['query']['nome'] = 'Cliente';
		$data['titulo'] = 'Comissão Colaborador';
		$data['form_open_path'] = 'relatorio_com/comissao_pag';
		$data['baixatodas'] = 'Relatorio_com/comissao_baixa/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
		$data['nomeusuario'] = 'NomeColaborador';
		$data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio_com/comissao/';
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
		$data['imprimirlista'] = 'Relatorio_com/comissao_lista/';
		$data['imprimirrecibo'] = 'Relatorio_com/comissao_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio_com/comissao/';

		$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissao($_SESSION['FiltroComissao'],FALSE, TRUE);
		
		if($data['pesquisa_query'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio_com/comissao' . $data['msg']);
			exit();
		}else{

			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			
			$config['base_url'] = base_url() . 'relatorio_com/comissao_pag/';
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
		
			$_SESSION['FiltroComissao']['Limit'] = $data['per_page'];
			$_SESSION['FiltroComissao']['Start'] = $data['linha'];

			$data['report'] = $this->Relatorio_model_list->list_comissao($_SESSION['FiltroComissao'], FALSE, FALSE, $config['per_page'], $data['linha']);
						
			$data['pagination'] = $this->pagination->create_links();

			$data['list1'] = $this->load->view('relatorio_com/list_comissao', $data, TRUE);
		}
        $this->load->view('relatorio_com/tela_comissao', $data);

        $this->load->view('basico/footer');

    }

	public function comissao_lista() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		//$data['query']['nome'] = 'Cliente';
		$data['titulo'] = 'Comissão Colaborador';
		$data['form_open_path'] = 'relatorio_com/comissao_pag';
		$data['baixatodas'] = 'Relatorio_com/comissao_baixa/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
		$data['nomeusuario'] = 'NomeColaborador';
		$data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio_com/comissao/';
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
		$data['imprimirlista'] = 'Relatorio_com/comissao_lista/';
		$data['imprimirrecibo'] = 'Relatorio_com/comissao_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio_com/comissao/';

		$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissao($_SESSION['FiltroComissao'],FALSE, TRUE);
		
		if($data['pesquisa_query'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio_com/comissao' . $data['msg']);
			exit();
		}else{

			$config['total_rows'] = $data['pesquisa_query']->num_rows();

			$config['base_url'] = base_url() . 'relatorio_com/comissao_lista/';

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
			
			$data['report'] = $this->Relatorio_model_list->list_comissao($_SESSION['FiltroComissao'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list1'] = $this->load->view('Relatorio_com/list_comissao_lista', $data, TRUE);
		}
        $this->load->view('relatorio_com/tela_comissao', $data);

        $this->load->view('basico/footer');

    }

	public function comissao_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Comissao Sem Filtros';
				$data['metodo'] = $id;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroComissao'])){
					$dados = $_SESSION['FiltroComissao'];
					$data['titulo'] = 'Comissao Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Comissao Sem Filtros';
					$data['metodo'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Comissao Sem Filtros';
				$data['metodo'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Comissao Sem Filtros';
			$data['metodo'] = 1;
		}

        $data['nome'] = 'Cliente';

		$data['report'] = $this->Relatorio_model_list->list_comissao($dados, FALSE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio_com/comissao' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Relatorio_com/list_comissao_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }
	
    public function comissao_baixa($id = FALSE) {

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
				'DataPagoComissãoPadrao',
			), TRUE));
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['empresa'] = quotes_to_entities($this->input->post(array(
				#### Sis_Empresa ####
				'idSis_Empresa',
				
			), TRUE));

			(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				if ($this->input->post('idApp_OrcaTrata' . $i)) {
					$data['orcamento'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
					$data['orcamento'][$j]['ValorComissao'] = $this->input->post('ValorComissao' . $i);
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
					
					if($_SESSION['FiltroComissao']['NomeUsuario'] == 0){
						
						$data['msg'] = '?m=5';
						redirect(base_url() . 'relatorio_com/comissao' . $data['msg']);
						exit();
						
					}else{

						$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissao($_SESSION['FiltroComissao'], TRUE, TRUE, FALSE, FALSE, FALSE);

						if($data['pesquisa_query'] === FALSE){
							$data['msg'] = '?m=4';
							redirect(base_url() . 'relatorio_com/comissao' . $data['msg']);
							exit();
						}else{

							$_SESSION['FiltroComissao']['FinalTotal'] = $data['pesquisa_query']->soma2->somafinal2;

							$_SESSION['FiltroComissao']['ComissaoTotal'] = $data['pesquisa_query']->soma2->somacomissao2;						
							
							$_SESSION['FiltroComissao']['TotalRows'] = $config['total_rows'] = $data['pesquisa_query']->num_rows();

							if($config['total_rows'] < 1){
								$data['msg'] = '?m=6';
								redirect(base_url() . 'relatorio_com/comissao' . $data['msg']);
								exit();
							}else{
								
								$config['base_url'] = base_url() . 'Relatorio_com/comissao_baixa/' . $id . '/';
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
									$_SESSION['FiltroComissao']['Total_Rows'] = $data['total_rows'] = $config['total_rows'];
								}else{
									$_SESSION['FiltroComissao']['Total_Rows'] = $data['total_rows'] = 0;
								}
								
								$this->pagination->initialize($config);
								
								$_SESSION['FiltroComissao']['Pagina'] = $data['pagina'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
								
								$_SESSION['FiltroComissao']['Pagina_atual'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"])) : 0;
								
								$_SESSION['FiltroComissao']['Per_Page'] = $data['per_page'] = $config['per_page'];
								
								$_SESSION['FiltroComissao']['Pagination'] = $data['pagination'] = $this->pagination->create_links();		

								#### App_Parcelas ####
								$data['orcamento'] = $this->Relatorio_model_list->list_comissao($_SESSION['FiltroComissao'], TRUE, FALSE, $_SESSION['FiltroComissao']['Per_Page'], ($_SESSION['FiltroComissao']['Pagina'] * $_SESSION['FiltroComissao']['Per_Page']), TRUE);

								if (count($data['orcamento']) > 0) {
									$data['orcamento'] = array_combine(range(1, count($data['orcamento'])), array_values($data['orcamento']));
									$_SESSION['FiltroComissao']['Contagem'] = $data['count']['PRCount'] = count($data['orcamento']);
									
									if (isset($data['orcamento'])) {

										$data['somatotal'] = 0;
										
										for($j=1; $j <= $data['count']['PRCount']; $j++) {
											
											$data['somatotal'] += $data['orcamento'][$j]['ValorComissao'];
											
											$_SESSION['Orcamento'][$j]['DataOrca'] 				= $this->basico->mascara_data($data['orcamento'][$j]['DataOrca'], 'barras');
											$_SESSION['Orcamento'][$j]['DataPagoComissaoOrca'] 	= $this->basico->mascara_data($data['orcamento'][$j]['DataPagoComissaoOrca'], 'barras');
											$_SESSION['Orcamento'][$j]['ValorRestanteOrca'] 	= $data['orcamento'][$j]['ValorRestanteOrca'];
											$_SESSION['Orcamento'][$j]['Tipo_Orca'] 			= $data['orcamento'][$j]['Tipo_Orca'];
											$_SESSION['Orcamento'][$j]['NomeColaborador'] 		= $data['orcamento'][$j]['NomeColaborador'];
											
											if($data['orcamento'][$j]['Tipo_Orca'] == "O") {
												$tipo_orca = 'On Line';
											} elseif($data['orcamento'][$j]['Tipo_Orca'] == "B"){
												$tipo_orca = 'Na Loja';
											}else{
												$tipo_orca = 'Outros';
											}
											$_SESSION['Orcamento'][$j]['Tipo_Orca'] 	= $tipo_orca;
											
											if($data['orcamento'][$j]['StatusComissaoOrca'] == "S"){
												$statuscomissao = 'Sim';
											}else{
												$statuscomissao = 'Não';
											}
											$_SESSION['Orcamento'][$j]['StatusComissaoOrca'] = $statuscomissao;
											
										}
										
										$_SESSION['FiltroComissao']['SomaTotal'] = number_format($data['somatotal'],2,",",".");
									}
								}else{
									$_SESSION['FiltroComissao']['Contagem'] = 0;
									$_SESSION['FiltroComissao']['SomaTotal'] = 0;
								}
							}	
						}
					}
				}
			}
			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['somatotal']);
			  echo "</pre>";
			  exit ();
			*/
				
			if(!$data['empresa']['idSis_Empresa'] || $data['empresa']['idSis_Empresa'] !== $_SESSION['log']['idSis_Empresa']){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}else{
				
				$data['select']['QuitadoComissao'] = $this->Basico_model->select_status_sn();

				$data['titulo'] = 'Comissao';
				$data['form_open_path'] = 'Relatorio_com/comissao_baixa';
				$data['relatorio'] = 'relatorio_com/comissao_pag/';
				$data['imprimir'] = 'Relatorio_com/comissao_lista/';
				$data['nomeusuario'] = 'NomeColaborador';
				$data['statuscomissao'] = 'StatusComissaoOrca';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'info';
				$data['metodo'] = 1;

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
				
				(!$data['query']['QuitadoComissao']) ? $data['query']['QuitadoComissao'] = 'N' : FALSE;
				$data['radio'] = array(
					'QuitadoComissao' => $this->basico->radio_checked($data['query']['QuitadoComissao'], 'Quitar Comissao', 'NS'),
				);
				($data['query']['QuitadoComissao'] == 'S') ?
					$data['div']['QuitadoComissao'] = '' : $data['div']['QuitadoComissao'] = 'style="display: none;"';
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				#### Sis_Empresa ####
				$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');
				if($data['query']['QuitadoComissao'] == 'S'){
					$this->form_validation->set_rules('DataPagoComissãoPadrao', 'Data do Pagamento', 'required|trim|valid_date');
				}

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('Relatorio_com/form_comissao_baixa', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {

						$data['bd']['QuitadoComissao'] = $data['query']['QuitadoComissao'];
						$data['bd']['DataPagoComissãoPadrao'] = $data['query']['DataPagoComissãoPadrao'];
						
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						
						$data['query']['DataPagoComissãoPadrao'] = $this->basico->mascara_data($data['query']['DataPagoComissãoPadrao'], 'mysql');            
						
						if($data['query']['QuitadoComissao'] == 'N'){
							
							#### App_ParcelasRec ####
							$data['update']['orcamento']['anterior'] = $this->Relatorio_model_list->list_comissao($_SESSION['FiltroComissao'], TRUE, FALSE, $_SESSION['FiltroComissao']['Per_Page'], ($_SESSION['FiltroComissao']['Pagina'] * $_SESSION['FiltroComissao']['Per_Page']), TRUE);

							if (isset($data['orcamento']) || (!isset($data['orcamento']) && isset($data['update']['orcamento']['anterior']) ) ) {

								if (isset($data['orcamento']))
									$data['orcamento'] = array_values($data['orcamento']);
								else
									$data['orcamento'] = array();

								//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
								$data['update']['orcamento'] = $this->basico->tratamento_array_multidimensional($data['orcamento'], $data['update']['orcamento']['anterior'], 'idApp_OrcaTrata');

								$max = count($data['update']['orcamento']['alterar']);
								for($j=0;$j<$max;$j++) {
									
									if(empty($data['update']['orcamento']['alterar'][$j]['ValorComissao'])){
										$data['update']['orcamento']['alterar'][$j]['ValorComissao'] = "0.00"; 
									}else{
										$data['update']['orcamento']['alterar'][$j]['ValorComissao'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['ValorComissao']));
									}
									
								}

								if (count($data['update']['orcamento']['alterar']))
									$data['update']['orcamento']['bd']['alterar'] =  $this->Orcatrata_model->update_comissao($data['update']['orcamento']['alterar']);

							}

							$data['msg'] = '?m=1';
		
							redirect(base_url() . 'Relatorio_com/comissao_baixa/' . $_SESSION['log']['idSis_Empresa'] . '/' . $_SESSION['FiltroComissao']['Pagina_atual'] . $data['msg']);
						
						}elseif($data['query']['QuitadoComissao'] == 'S'){

							//////// vou gerar uma despesa e pegar o id . Posso os dados da despesa com uma linha de parcela

							$data['nivel_comissionado'] = $this->Usuario_model->get_usuario($_SESSION['FiltroComissao']['NomeUsuario'])['Nivel'];
							if($data['nivel_comissionado'] == 0){
								$nivel_orca	= 1;
							}else{
								$nivel_orca		= $data['nivel_comissionado'];
							}
							$data['recibo']['NivelOrca']			= $nivel_orca;
							$data['recibo']['DataOrca'] 			= $data['query']['DataPagoComissãoPadrao'];
							$data['recibo']['HoraOrca'] 			= date('H:i:s', time());
							$data['recibo']['idTab_TipoRD']			= 1;
							$data['recibo']['idTab_Modulo']			= 1;
							$data['recibo']['idSis_Empresa'] 		= $_SESSION['log']['idSis_Empresa'];
							$data['recibo']['idSis_Usuario'] 		= $_SESSION['log']['idSis_Usuario'];
							$data['recibo']['id_Funcionario'] 		= $_SESSION['FiltroComissao']['NomeUsuario'];
							$data['recibo']['id_Associado']			= 0;
							
							$data['recibo']['TipoFinanceiro']		= 66;
							$data['recibo']['Cli_Forn_Orca']		= "N";
							$data['recibo']['Func_Orca']			= "S";
							$data['recibo']['Prd_Srv_Orca']			= "N";
							$data['recibo']['Entrega_Orca']			= "N";
							
							$data['recibo']['AVAP']					= "V";
							$data['recibo']['FormaPagamento']		= 7;
							$data['recibo']['QtdParcelasOrca']		= 1;
							$data['recibo']['DataVencimentoOrca'] 	= $data['query']['DataPagoComissãoPadrao'];
							$data['recibo']['Modalidade']			= "P";
							
							$data['recibo']['ValorExtraOrca'] 		= str_replace(',', '.', str_replace('.', '', $_SESSION['FiltroComissao']['ComissaoTotal']));
							$data['recibo']['ValorTotalOrca'] 		= $data['recibo']['ValorExtraOrca'];
							$data['recibo']['SubValorFinal'] 		= $data['recibo']['ValorExtraOrca'];
							$data['recibo']['ValorFinalOrca'] 		= $data['recibo']['ValorExtraOrca'];
							if(isset($data['recibo']['ValorExtraOrca']) && $data['recibo']['ValorExtraOrca'] > 0){
								$data['recibo']['BrindeOrca'] 		= "N";
								$data['recibo']['QuitadoOrca'] 		= "N";
								$data['recibo']['FinalizadoOrca'] 	= "N";
							}else{
								$data['recibo']['BrindeOrca'] 		= "S";
								$data['recibo']['QuitadoOrca'] 		= "S";
								$data['recibo']['FinalizadoOrca'] 	= "S";
							}
							$data['recibo']['CombinadoFrete'] 		= "S";
							$data['recibo']['AprovadoOrca'] 		= "S";
							$data['recibo']['ProntoOrca'] 			= "S";
							$data['recibo']['EnviadoOrca'] 			= "S";
							$data['recibo']['ConcluidoOrca'] 		= "S";
							
							$data['recibo']['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['recibo']);
						
							if ($data['recibo']['idApp_OrcaTrata'] === FALSE) {
								
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

								$this->basico->erro($msg);
								$this->load->view('Relatorio_com/form_comissao_baixa', $data);
							
							} else {
								
								#### App_ParcelasRec ####
								if(isset($data['recibo']['ValorExtraOrca']) && $data['recibo']['ValorExtraOrca'] > 0){	
									$max = 1;
									for($j=1;$j<=$max;$j++) {
										$data['parcelasrec'][$j]['idApp_OrcaTrata'] 		= $data['recibo']['idApp_OrcaTrata'];
										$data['parcelasrec'][$j]['idSis_Usuario'] 			= $_SESSION['log']['idSis_Usuario'];
										$data['parcelasrec'][$j]['idSis_Empresa'] 			= $_SESSION['log']['idSis_Empresa'];
										$data['parcelasrec'][$j]['idTab_Modulo'] 			= $_SESSION['log']['idTab_Modulo'];
										$data['parcelasrec'][$j]['idApp_Fornecedor'] 		= 0;					
										$data['parcelasrec'][$j]['idTab_TipoRD'] 			= "1";
										$data['parcelasrec'][$j]['NivelParcela'] 			= $nivel_orca;
										
										$data['parcelasrec'][$j]['Parcela'] 				= "1/1";
										$data['parcelasrec'][$j]['ValorParcela'] 			= $data['recibo']['ValorExtraOrca'];
										$data['parcelasrec'][$j]['FormaPagamentoParcela'] 	= $data['recibo']['FormaPagamento'];									
										$data['parcelasrec'][$j]['DataVencimento'] 			= $data['query']['DataPagoComissãoPadrao'];
										$data['parcelasrec'][$j]['Quitado'] 				= 'N';
										$data['parcelasrec'][$j]['DataPago'] 				= "0000-00-00";
										$data['parcelasrec'][$j]['DataLanc'] 				= "0000-00-00";
										
									}
									$data['parcelasrec']['idApp_Parcelas'] = $this->Orcatrata_model->set_parcelas($data['parcelasrec']);
								}
								/////// Corro a lista com o filtro da sessão colocando o id_Comissao em cada orcamento
								$data['update']['orcamentos'] = $this->Relatorio_model_list->list_comissao($_SESSION['FiltroComissao'], TRUE, TRUE, FALSE, FALSE, TRUE);

								$max = count($data['update']['orcamentos']);
								
								if(isset($max) && $max > 0){
									
									for($j=0;$j<$max;$j++) {
										$data['update']['orcamentos'][$j]['id_Comissao'] 				= $data['recibo']['idApp_OrcaTrata'];
										$data['update']['orcamentos'][$j]['StatusComissaoOrca'] 	= 'S';
										$data['update']['orcamentos'][$j]['DataPagoComissaoOrca'] 	= $data['query']['DataPagoComissãoPadrao'];
										
										$data['update']['orcamentos']['bd'][$j] = $this->Orcatrata_model->update_orcatrata($data['update']['orcamentos'][$j], $data['update']['orcamentos'][$j]['idApp_OrcaTrata']);
										
										//desliguei a passagem de status informações para os produtos
										/*
										$data['update']['produto']['posterior'][$j] = $this->Orcatrata_model->get_produto_comissao_pedido($data['update']['orcamentos'][$j]['idApp_OrcaTrata']);
										
										if (isset($data['update']['produto']['posterior'][$j])){
											$max_produto = count($data['update']['produto']['posterior'][$j]);
											for($k=0;$k<$max_produto;$k++) {
												$data['update']['produto']['posterior'][$j][$k]['StatusComissaoPedido'] 	= 'S';
												$data['update']['produto']['posterior'][$j][$k]['DataPagoComissaoPedido'] 	= $data['query']['DataPagoComissãoPadrao'];
											}
											if (count($data['update']['produto']['posterior'][$j]))
												$data['update']['produto']['bd']['posterior'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['posterior'][$j]);
										}
										*/
									}
								}
								
								/////// Ao terminar abro a despesa/Recibo criado
								$data['msg'] = '?m=1';
								redirect(base_url() . 'OrcatrataPrint/imprimirdesp/' . $data['recibo']['idApp_OrcaTrata'] . $data['msg']);
							}
						}else{
								
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('Relatorio_com/form_comissao_baixa', $data);
							
						}	
						exit();
					}					
				}
			}
		}
        $this->load->view('basico/footer');

    }

	public function comissaoass() {
		
		unset($_SESSION['FiltroComissaoAss']);
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Receita Não Encontrada.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa está muito grande, ela excedeu 12000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Um Associado deve ser Selecionado. Refaça o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
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
			'DataVencimentoOrca',
			'NomeAssociado',
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
			'id_Comissao',
        ), TRUE));

		
        $data['select']['Recibo'] = array(
			'0' => '::TODOS::',
			'OT.id_Comissao != 0 ' => 'C/ Recibo',
			'OT.id_Comissao = 0 ' => 'S/ Recibo',
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
            'S' => 'Paga',
            'N' => 'NãoPaga',
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

		$data['select']['NomeAssociado'] = $this->Relatorio_model->select_cliente_associado();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();

		$data['query']['nome'] = 'Cliente';
		$data['titulo'] = 'Comissão Associado';
		$data['form_open_path'] = 'relatorio_com/comissaoass';
		$data['baixatodas'] = 'Relatorio_com/comissaoass_baixa/';
		$data['editartodas'] = 'relatorio_rec/receitas/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
		$data['nomeusuario'] = 'NomeAssociado';
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
		$data['imprimirlista'] = 'Relatorio_com/comissaoass_lista/';
		$data['imprimirrecibo'] = 'Relatorio_com/comissaoass_recibo/';
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
			
			$_SESSION['FiltroComissaoAss']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$_SESSION['FiltroComissaoAss']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$_SESSION['FiltroComissaoAss']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$_SESSION['FiltroComissaoAss']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$_SESSION['FiltroComissaoAss']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
			$_SESSION['FiltroComissaoAss']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$_SESSION['FiltroComissaoAss']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
			$_SESSION['FiltroComissaoAss']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$_SESSION['FiltroComissaoAss']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
			$_SESSION['FiltroComissaoAss']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');

			$_SESSION['FiltroComissaoAss']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
			$_SESSION['FiltroComissaoAss']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$_SESSION['FiltroComissaoAss']['HoraInicio5'] = $data['query']['HoraInicio5'];
			$_SESSION['FiltroComissaoAss']['HoraFim5'] = $data['query']['HoraFim5'];
			$_SESSION['FiltroComissaoAss']['Produtos'] = $data['query']['Produtos'];
			$_SESSION['FiltroComissaoAss']['Parcelas'] = $data['query']['Parcelas'];
			$_SESSION['FiltroComissaoAss']['Recibo'] = $data['query']['Recibo'];
			$_SESSION['FiltroComissaoAss']['id_Comissao'] = $data['query']['id_Comissao'];
			$_SESSION['FiltroComissaoAss']['NomeAssociado'] = $data['query']['NomeAssociado'];
			$_SESSION['FiltroComissaoAss']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$_SESSION['FiltroComissaoAss']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$_SESSION['FiltroComissaoAss']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$_SESSION['FiltroComissaoAss']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$_SESSION['FiltroComissaoAss']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$_SESSION['FiltroComissaoAss']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$_SESSION['FiltroComissaoAss']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$_SESSION['FiltroComissaoAss']['Quitado'] = $data['query']['Quitado'];
			$_SESSION['FiltroComissaoAss']['StatusComissaoOrca'] = $data['query']['StatusComissaoOrca'];
			$_SESSION['FiltroComissaoAss']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$_SESSION['FiltroComissaoAss']['AVAP'] = $data['query']['AVAP'];
			$_SESSION['FiltroComissaoAss']['TipoFrete'] = $data['query']['TipoFrete'];
			$_SESSION['FiltroComissaoAss']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$_SESSION['FiltroComissaoAss']['Orcamento'] = $data['query']['Orcamento'];
			$_SESSION['FiltroComissaoAss']['Cliente'] = $data['query']['Cliente'];
			$_SESSION['FiltroComissaoAss']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$_SESSION['FiltroComissaoAss']['Modalidade'] = $data['query']['Modalidade'];
			$_SESSION['FiltroComissaoAss']['nome'] = $data['query']['nome'];
			$_SESSION['FiltroComissaoAss']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroComissaoAss']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['FiltroComissaoAss']['metodo'] = $data['metodo'];
			$_SESSION['FiltroComissaoAss']['idTab_TipoRD'] = $data['TipoRD'];

			$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissaoass($_SESSION['FiltroComissaoAss'],FALSE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio_com/comissaoass' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();			
				
				$config['base_url'] = base_url() . 'relatorio_com/comissaoass_pag/';
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

				$data['report'] = $this->Relatorio_model_list->list_comissaoass($_SESSION['FiltroComissaoAss'], FALSE, FALSE, $config['per_page'], $data['linha']);		

				$_SESSION['FiltroComissaoAss']['Limit'] = $data['per_page'];
				$_SESSION['FiltroComissaoAss']['Start'] = $data['linha'];

				$data['pagination'] = $this->pagination->create_links();
				
				$data['list1'] = $this->load->view('relatorio_com/list_comissaoass', $data, TRUE);
			}	
        }		

        $this->load->view('relatorio_com/tela_comissaoass', $data);

        $this->load->view('basico/footer');

    }

	public function comissaoass_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Um Colaborador deve ser Selecionado. Refaça o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 6)
            $data['msg'] = $this->basico->msg('<strong>A quantidade de Receitas deve ser maior ou igual a 1. Refaça o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		//$data['query']['nome'] = 'Cliente';
		$data['titulo'] = 'Comissão Associado';
		$data['form_open_path'] = 'relatorio_com/comissaoass_pag';
		$data['baixatodas'] = 'Relatorio_com/comissaoass_baixa/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
		$data['nomeusuario'] = 'NomeAssociado';
		$data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio_com/comissaoass/';
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
		$data['imprimirlista'] = 'Relatorio_com/comissaoass_lista/';
		$data['imprimirrecibo'] = 'Relatorio_com/comissaoass_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio_com/comissaoass/';

		$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissaoass($_SESSION['FiltroComissaoAss'],FALSE, TRUE);
		
		if($data['pesquisa_query'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio_com/comissaoass' . $data['msg']);
			exit();
		}else{

			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			
			$config['base_url'] = base_url() . 'relatorio_com/comissaoass_pag/';
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
		
			$_SESSION['FiltroComissaoAss']['Limit'] = $data['per_page'];
			$_SESSION['FiltroComissaoAss']['Start'] = $data['linha'];

			$data['report'] = $this->Relatorio_model_list->list_comissaoass($_SESSION['FiltroComissaoAss'], FALSE, FALSE, $config['per_page'], $data['linha']);
						
			$data['pagination'] = $this->pagination->create_links();

			$data['list1'] = $this->load->view('relatorio_com/list_comissaoass', $data, TRUE);
		}
        $this->load->view('relatorio_com/tela_comissaoass', $data);

        $this->load->view('basico/footer');

    }

	public function comissaoass_lista() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		//$data['query']['nome'] = 'Cliente';
		$data['titulo'] = 'Comissão Colaborador';
		$data['form_open_path'] = 'relatorio_com/comissaoass_pag';
		$data['baixatodas'] = 'Relatorio_com/comissaoass_baixa/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
		$data['nomeusuario'] = 'NomeColaborador';
		$data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio_com/comissaoass/';
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
		$data['imprimirlista'] = 'Relatorio_com/comissaoass_lista/';
		$data['imprimirrecibo'] = 'Relatorio_com/comissaoass_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio_com/comissaoass/';

		$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissaoass($_SESSION['FiltroComissaoAss'],FALSE, TRUE);
		
		if($data['pesquisa_query'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio_com/comissaoass' . $data['msg']);
			exit();
		}else{

			$config['total_rows'] = $data['pesquisa_query']->num_rows();

			$config['base_url'] = base_url() . 'relatorio_com/comissaoass_lista/';

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
			
			$data['report'] = $this->Relatorio_model_list->list_comissaoass($_SESSION['FiltroComissaoAss'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list1'] = $this->load->view('Relatorio_com/list_comissaoass_lista', $data, TRUE);
		}
        $this->load->view('relatorio_com/tela_comissaoass', $data);

        $this->load->view('basico/footer');

    }

	public function comissaoass_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Comissao Sem Filtros';
				$data['metodo'] = $id;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroComissaoAss'])){
					$dados = $_SESSION['FiltroComissaoAss'];
					$data['titulo'] = 'Comissao Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Comissao Sem Filtros';
					$data['metodo'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Comissao Sem Filtros';
				$data['metodo'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Comissao Sem Filtros';
			$data['metodo'] = 1;
		}

        $data['nome'] = 'Cliente';

		$data['report'] = $this->Relatorio_model_list->list_comissaoass($dados, FALSE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio_com/comissaoass' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Relatorio_com/list_comissaoass_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }
	
    public function comissaoass_baixa($id = FALSE) {

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
				'DataPagoComissãoPadrao',
			), TRUE));
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['empresa'] = quotes_to_entities($this->input->post(array(
				#### Sis_Empresa ####
				'idSis_Empresa',
				
			), TRUE));

			(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				if ($this->input->post('idApp_OrcaTrata' . $i)) {
					$data['orcamento'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
					$data['orcamento'][$j]['ValorComissaoAssoc'] = $this->input->post('ValorComissaoAssoc' . $i);
					$j++;
				}
			}
			
			$data['count']['PRCount'] = $j - 1;

			//$this->load->library('pagination');

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
					
					if($_SESSION['FiltroComissaoAss']['NomeAssociado'] == 0){
						
						$data['msg'] = '?m=5';
						redirect(base_url() . 'relatorio_com/comissaoass' . $data['msg']);
						exit();
						
					}else{
						
						//$data['pesquisa_query'] = $this->Orcatrata_model->get_baixadacomissaoass($_SESSION['FiltroComissaoAss'], TRUE, FALSE, FALSE, FALSE);
						$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissaoass($_SESSION['FiltroComissaoAss'], TRUE, TRUE, FALSE, FALSE, FALSE);
					
						if($data['pesquisa_query'] === FALSE){
							$data['msg'] = '?m=4';
							redirect(base_url() . 'relatorio_com/comissaoass' . $data['msg']);
							exit();
						}else{

							$_SESSION['FiltroComissaoAss']['FinalTotal'] = $data['pesquisa_query']->soma2->somafinal2;

							$_SESSION['FiltroComissaoAss']['ComissaoTotal'] = $data['pesquisa_query']->soma2->somacomissaoass2;						
							
							$_SESSION['FiltroComissaoAss']['TotalRows'] = $config['total_rows'] = $data['pesquisa_query']->num_rows();

							if($config['total_rows'] < 1){
								$data['msg'] = '?m=6';
								redirect(base_url() . 'relatorio_com/comissaoass' . $data['msg']);
								exit();
							}else{
								
								$config['base_url'] = base_url() . 'Relatorio_com/comissaoass_baixa/' . $id . '/';
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
									$_SESSION['FiltroComissaoAss']['Total_Rows'] = $data['total_rows'] = $config['total_rows'];
								}else{
									$_SESSION['FiltroComissaoAss']['Total_Rows'] = $data['total_rows'] = 0;
								}
								
								$this->pagination->initialize($config);
								
								$_SESSION['FiltroComissaoAss']['Pagina'] = $data['pagina'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
								
								$_SESSION['FiltroComissaoAss']['Pagina_atual'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"])) : 0;
								
								$_SESSION['FiltroComissaoAss']['Per_Page'] = $data['per_page'] = $config['per_page'];
								
								$_SESSION['FiltroComissaoAss']['Pagination'] = $data['pagination'] = $this->pagination->create_links();		

								#### App_Parcelas ####
								//$data['orcamento'] = $this->Orcatrata_model->get_baixadacomissaoass($_SESSION['FiltroComissaoAss'], FALSE, $_SESSION['FiltroComissaoAss']['Per_Page'], ($_SESSION['FiltroComissaoAss']['Pagina'] * $_SESSION['FiltroComissaoAss']['Per_Page']), FALSE);
								$data['orcamento'] = $this->Relatorio_model_list->list_comissaoass($_SESSION['FiltroComissaoAss'], TRUE, FALSE, $_SESSION['FiltroComissaoAss']['Per_Page'], ($_SESSION['FiltroComissaoAss']['Pagina'] * $_SESSION['FiltroComissaoAss']['Per_Page']), TRUE);
								
								if (count($data['orcamento']) > 0) {
									$data['orcamento'] = array_combine(range(1, count($data['orcamento'])), array_values($data['orcamento']));
									$_SESSION['FiltroComissaoAss']['Contagem'] = $data['count']['PRCount'] = count($data['orcamento']);
									
									if (isset($data['orcamento'])) {

										$data['somatotal'] = 0;
										
										for($j=1; $j <= $data['count']['PRCount']; $j++) {
											
											$data['somatotal'] += $data['orcamento'][$j]['ValorComissaoAssoc'];
											
											$_SESSION['Orcamento'][$j]['DataOrca'] 				= $this->basico->mascara_data($data['orcamento'][$j]['DataOrca'], 'barras');
											$_SESSION['Orcamento'][$j]['DataPagoComissaoOrca'] 	= $this->basico->mascara_data($data['orcamento'][$j]['DataPagoComissaoOrca'], 'barras');
											$_SESSION['Orcamento'][$j]['ValorRestanteOrca'] 	= $data['orcamento'][$j]['ValorRestanteOrca'];
											$_SESSION['Orcamento'][$j]['Tipo_Orca'] 			= $data['orcamento'][$j]['Tipo_Orca'];
											$_SESSION['Orcamento'][$j]['NomeAssociado'] 		= $data['orcamento'][$j]['NomeAssociado'];
											
											if($data['orcamento'][$j]['Tipo_Orca'] == "O") {
												$tipo_orca = 'On Line';
											} elseif($data['orcamento'][$j]['Tipo_Orca'] == "B"){
												$tipo_orca = 'Na Loja';
											}else{
												$tipo_orca = 'Outros';
											}
											$_SESSION['Orcamento'][$j]['Tipo_Orca'] 	= $tipo_orca;
											
											if($data['orcamento'][$j]['StatusComissaoOrca'] == "S"){
												$statuscomissaoass = 'Sim';
											}else{
												$statuscomissaoass = 'Não';
											}
											$_SESSION['Orcamento'][$j]['StatusComissaoOrca'] = $statuscomissaoass;
											
										}
										
										$_SESSION['FiltroComissaoAss']['SomaTotal'] = number_format($data['somatotal'],2,",",".");
									}
								}else{
									$_SESSION['FiltroComissaoAss']['Contagem'] = 0;
									$_SESSION['FiltroComissaoAss']['SomaTotal'] = 0;
								}
							}	
						}
					}
				}
			}
			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['somatotal']);
			  echo "</pre>";
			  exit ();
			*/
				
			if(!$data['empresa']['idSis_Empresa'] || $data['empresa']['idSis_Empresa'] !== $_SESSION['log']['idSis_Empresa']){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}else{
				
				$data['select']['QuitadoComissao'] = $this->Basico_model->select_status_sn();
				//$data['select']['StatusComissaoOrca'] = $this->Basico_model->select_status_sn();	
				
				$data['titulo'] = 'Comissao Associado';
				$data['form_open_path'] = 'Relatorio_com/comissaoass_baixa';
				$data['relatorio'] = 'relatorio_com/comissaoass_pag/';
				$data['imprimir'] = 'Relatorio_com/comissaoass_lista/';
				$data['nomeusuario'] = 'NomeAssociado';
				$data['statuscomissao'] = 'StatusComissaoOrca';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'info';
				$data['metodo'] = 1;

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
				
				(!$data['query']['QuitadoComissao']) ? $data['query']['QuitadoComissao'] = 'N' : FALSE;
				$data['radio'] = array(
					'QuitadoComissao' => $this->basico->radio_checked($data['query']['QuitadoComissao'], 'Quitar Comissao', 'NS'),
				);
				($data['query']['QuitadoComissao'] == 'S') ?
					$data['div']['QuitadoComissao'] = '' : $data['div']['QuitadoComissao'] = 'style="display: none;"';
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				#### Sis_Empresa ####
				$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');
				if($data['query']['QuitadoComissao'] == 'S'){
					$this->form_validation->set_rules('DataPagoComissãoPadrao', 'Data do Pagamento', 'required|trim|valid_date');
				}

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('Relatorio_com/form_comissaoass_baixa', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {

						$data['bd']['QuitadoComissao'] = $data['query']['QuitadoComissao'];
						$data['bd']['DataPagoComissãoPadrao'] = $data['query']['DataPagoComissãoPadrao'];
						
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						
						$data['query']['DataPagoComissãoPadrao'] = $this->basico->mascara_data($data['query']['DataPagoComissãoPadrao'], 'mysql');            
						
						if($data['query']['QuitadoComissao'] == 'N'){
							
							#### App_ParcelasRec ####
							//$data['update']['orcamento']['anterior'] = $this->Orcatrata_model->get_baixadacomissaoass($_SESSION['FiltroComissaoAss'], FALSE, $_SESSION['FiltroComissaoAss']['Per_Page'], ($_SESSION['FiltroComissaoAss']['Pagina'] * $_SESSION['FiltroComissaoAss']['Per_Page']), FALSE);
							$data['update']['orcamento']['anterior'] = $this->Relatorio_model_list->list_comissaoass($_SESSION['FiltroComissaoAss'], TRUE, FALSE, $_SESSION['FiltroComissaoAss']['Per_Page'], ($_SESSION['FiltroComissaoAss']['Pagina'] * $_SESSION['FiltroComissaoAss']['Per_Page']), TRUE);

							
							if (isset($data['orcamento']) || (!isset($data['orcamento']) && isset($data['update']['orcamento']['anterior']) ) ) {

								if (isset($data['orcamento']))
									$data['orcamento'] = array_values($data['orcamento']);
								else
									$data['orcamento'] = array();

								//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
								$data['update']['orcamento'] = $this->basico->tratamento_array_multidimensional($data['orcamento'], $data['update']['orcamento']['anterior'], 'idApp_OrcaTrata');

								$max = count($data['update']['orcamento']['alterar']);
								for($j=0;$j<$max;$j++) {
									
									if(empty($data['update']['orcamento']['alterar'][$j]['ValorComissaoAssoc'])){
										$data['update']['orcamento']['alterar'][$j]['ValorComissaoAssoc'] = "0.00"; 
									}else{
										$data['update']['orcamento']['alterar'][$j]['ValorComissaoAssoc'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['ValorComissaoAssoc']));
									}
									
								}

								if (count($data['update']['orcamento']['alterar']))
									$data['update']['orcamento']['bd']['alterar'] =  $this->Orcatrata_model->update_comissao($data['update']['orcamento']['alterar']);

							}

							$data['msg'] = '?m=1';
		
							redirect(base_url() . 'Relatorio_com/comissaoass_baixa/' . $_SESSION['log']['idSis_Empresa'] . '/' . $_SESSION['FiltroComissaoAss']['Pagina_atual'] . $data['msg']);
						
						}elseif($data['query']['QuitadoComissao'] == 'S'){

							//////// vou gerar uma despesa e pegar o id . Posso os dados da despesa com uma linha de parcela

							$data['recibo']['NivelOrca']			= 3;
							$data['recibo']['DataOrca'] 			= $data['query']['DataPagoComissãoPadrao'];
							$data['recibo']['HoraOrca'] 			= date('H:i:s', time());
							$data['recibo']['idTab_TipoRD']			= 1;
							$data['recibo']['idTab_Modulo']			= 1;
							$data['recibo']['idSis_Empresa'] 		= $_SESSION['log']['idSis_Empresa'];
							$data['recibo']['idSis_Usuario'] 		= $_SESSION['log']['idSis_Usuario'];
							$data['recibo']['id_Funcionario'] 		= 0;
							$data['recibo']['id_Associado'] 		= $_SESSION['FiltroComissaoAss']['NomeAssociado'];
							
							$data['recibo']['TipoFinanceiro']		= 68;
							$data['recibo']['Cli_Forn_Orca']		= "N";
							$data['recibo']['Func_Orca']			= "N";
							$data['recibo']['Prd_Srv_Orca']			= "N";
							$data['recibo']['Entrega_Orca']			= "N";
							
							$data['recibo']['AVAP']					= "V";
							$data['recibo']['FormaPagamento']		= 7;
							$data['recibo']['QtdParcelasOrca']		= 1;
							$data['recibo']['DataVencimentoOrca'] 	= $data['query']['DataPagoComissãoPadrao'];
							$data['recibo']['Modalidade']			= "P";
							
							$data['recibo']['ValorExtraOrca'] 		= str_replace(',', '.', str_replace('.', '', $_SESSION['FiltroComissaoAss']['ComissaoTotal']));
							$data['recibo']['ValorTotalOrca'] 		= $data['recibo']['ValorExtraOrca'];
							$data['recibo']['SubValorFinal'] 		= $data['recibo']['ValorExtraOrca'];
							$data['recibo']['ValorFinalOrca'] 		= $data['recibo']['ValorExtraOrca'];
							if(isset($data['recibo']['ValorExtraOrca']) && $data['recibo']['ValorExtraOrca'] > 0){
								$data['recibo']['BrindeOrca'] 		= "N";
								$data['recibo']['QuitadoOrca'] 		= "N";
								$data['recibo']['FinalizadoOrca'] 	= "N";
							}else{
								$data['recibo']['BrindeOrca'] 		= "S";
								$data['recibo']['QuitadoOrca'] 		= "S";
								$data['recibo']['FinalizadoOrca'] 	= "S";
							}
							$data['recibo']['CombinadoFrete'] 		= "S";
							$data['recibo']['AprovadoOrca'] 		= "S";
							$data['recibo']['ProntoOrca'] 			= "S";
							$data['recibo']['EnviadoOrca'] 			= "S";
							$data['recibo']['ConcluidoOrca'] 		= "S";
							
							$data['recibo']['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['recibo']);
						
							if ($data['recibo']['idApp_OrcaTrata'] === FALSE) {
								
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

								$this->basico->erro($msg);
								$this->load->view('Relatorio_com/form_comissaoass_baixa', $data);
							
							} else {	

								#### App_ParcelasRec ####
								if(isset($data['recibo']['ValorExtraOrca']) && $data['recibo']['ValorExtraOrca'] > 0){
									$max = 1;
									for($j=1;$j<=$max;$j++) {
										$data['parcelasrec'][$j]['idApp_OrcaTrata'] 		= $data['recibo']['idApp_OrcaTrata'];
										$data['parcelasrec'][$j]['idSis_Usuario'] 			= $_SESSION['log']['idSis_Usuario'];
										$data['parcelasrec'][$j]['idSis_Empresa'] 			= $_SESSION['log']['idSis_Empresa'];
										$data['parcelasrec'][$j]['idTab_Modulo'] 			= $_SESSION['log']['idTab_Modulo'];
										$data['parcelasrec'][$j]['idApp_Fornecedor'] 		= 0;					
										$data['parcelasrec'][$j]['idTab_TipoRD'] 			= "1";
										$data['parcelasrec'][$j]['NivelParcela'] 			= 3;
										
										$data['parcelasrec'][$j]['Parcela'] 				= "1/1";
										$data['parcelasrec'][$j]['ValorParcela'] 			= $data['recibo']['ValorExtraOrca'];
										$data['parcelasrec'][$j]['FormaPagamentoParcela'] 	= $data['recibo']['FormaPagamento'];									
										$data['parcelasrec'][$j]['DataVencimento'] 			= $data['query']['DataPagoComissãoPadrao'];
										$data['parcelasrec'][$j]['Quitado'] 				= 'N';
										$data['parcelasrec'][$j]['DataPago'] 				= "0000-00-00";
										$data['parcelasrec'][$j]['DataLanc'] 				= "0000-00-00";
										
									}
									$data['parcelasrec']['idApp_Parcelas'] = $this->Orcatrata_model->set_parcelas($data['parcelasrec']);
								}
								
								/////// Corro a lista com o filtro da sessão colocando o id_Comissao em cada orcamento
								
								//$data['update']['orcamentos'] = $this->Orcatrata_model->get_baixadacomissaoass($_SESSION['FiltroComissaoAss'], FALSE, FALSE, FALSE, TRUE);// pega as OS que tem essa repeticao			
								$data['update']['orcamentos'] = $this->Relatorio_model_list->list_comissaoass($_SESSION['FiltroComissaoAss'], TRUE, TRUE, FALSE, FALSE, TRUE);
								
								$max = count($data['update']['orcamentos']);
								
								if(isset($max) && $max > 0){
									
									for($j=0;$j<$max;$j++) {
										$data['update']['orcamentos'][$j]['id_Comissao'] 				= $data['recibo']['idApp_OrcaTrata'];
										$data['update']['orcamentos'][$j]['StatusComissaoOrca'] 	= 'S';
										$data['update']['orcamentos'][$j]['DataPagoComissaoOrca'] 	= $data['query']['DataPagoComissãoPadrao'];
										
										$data['update']['orcamentos']['bd'][$j] = $this->Orcatrata_model->update_orcatrata($data['update']['orcamentos'][$j], $data['update']['orcamentos'][$j]['idApp_OrcaTrata']);
										/*
										$data['update']['produto']['posterior'][$j] = $this->Orcatrata_model->get_produto_comissao_pedido($data['update']['orcamentos'][$j]['idApp_OrcaTrata']);
										
										if (isset($data['update']['produto']['posterior'][$j])){
											$max_produto = count($data['update']['produto']['posterior'][$j]);
											for($k=0;$k<$max_produto;$k++) {
												$data['update']['produto']['posterior'][$j][$k]['StatusComissaoPedido'] 	= 'S';
												$data['update']['produto']['posterior'][$j][$k]['DataPagoComissaoPedido'] 	= $data['query']['DataPagoComissãoPadrao'];
											}
											if (count($data['update']['produto']['posterior'][$j]))
												$data['update']['produto']['bd']['posterior'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['posterior'][$j]);
										}
										*/
									}
								}
								
								/////// Ao terminar abro a despesa/Recibo criado
								$data['msg'] = '?m=1';
								redirect(base_url() . 'OrcatrataPrint/imprimirdesp/' . $data['recibo']['idApp_OrcaTrata'] . $data['msg']);
							}
						}else{
								
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('Relatorio_com/form_comissaoass_baixa', $data);
							
						}	
						exit();
					}					
				}
			}
		}
        $this->load->view('basico/footer');
    }

	public function comissaofunc() {
		
		unset($_SESSION['FiltroComissaoFunc']);
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Receita Não Encontrada.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa está muito grande, ela excedeu 12000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Um Vendedor deve ser Selecionado. Refaça o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
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
			'StatusComissaoFunc',
			'Modalidade',
			'AVAP',
			'Tipo_Orca',
			'FormaPagamento',
			'TipoFrete',
			'Produtos',
			'Parcelas',
			'nome',
			'Recibo',
			'id_ComissaoFunc',
        ), TRUE));

		
        $data['select']['Recibo'] = array(
			'0' => '::TODOS::',
			'OT.id_ComissaoFunc != 0 ' => 'C/ Recibo',
			'OT.id_ComissaoFunc = 0 ' => 'S/ Recibo',
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
		
		$data['select']['StatusComissaoFunc'] = array(
            '0' => 'TODOS',
            'S' => 'Paga',
            'N' => 'NãoPaga',
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
			'US.Nome' => 'Nome do Vendedor',
			'OT.DataPagoComissaoFunc' => 'Data Pago Comissão',
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

		$data['select']['NomeUsuario'] = $this->Relatorio_model->select_funcionario();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();

		$data['query']['nome'] = 'Cliente';
		$data['titulo'] = 'Comissão Funcionario';
		$data['form_open_path'] = 'relatorio_com/comissaofunc';
		$data['baixatodas'] = 'Relatorio_com/comissaofunc_baixa/';
		$data['editartodas'] = 'relatorio_rec/receitas/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
		$data['nomeusuario'] = 'NomeColaborador';
		$data['status'] = 'StatusComissaoFunc';
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
		$data['imprimirlista'] = 'Relatorio_com/comissaofunc_lista/';
		$data['imprimirrecibo'] = 'Relatorio_com/comissaofunc_recibo/';
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
			
			$_SESSION['FiltroComissaoFunc']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$_SESSION['FiltroComissaoFunc']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$_SESSION['FiltroComissaoFunc']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$_SESSION['FiltroComissaoFunc']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$_SESSION['FiltroComissaoFunc']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
			$_SESSION['FiltroComissaoFunc']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$_SESSION['FiltroComissaoFunc']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
			$_SESSION['FiltroComissaoFunc']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$_SESSION['FiltroComissaoFunc']['DataInicio5'] = $this->basico->mascara_data($data['query']['DataInicio5'], 'mysql');
			$_SESSION['FiltroComissaoFunc']['DataFim5'] = $this->basico->mascara_data($data['query']['DataFim5'], 'mysql');

			$_SESSION['FiltroComissaoFunc']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
			$_SESSION['FiltroComissaoFunc']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$_SESSION['FiltroComissaoFunc']['HoraInicio5'] = $data['query']['HoraInicio5'];
			$_SESSION['FiltroComissaoFunc']['HoraFim5'] = $data['query']['HoraFim5'];
			$_SESSION['FiltroComissaoFunc']['Produtos'] = $data['query']['Produtos'];
			$_SESSION['FiltroComissaoFunc']['Parcelas'] = $data['query']['Parcelas'];
			$_SESSION['FiltroComissaoFunc']['Recibo'] = $data['query']['Recibo'];
			$_SESSION['FiltroComissaoFunc']['id_ComissaoFunc'] = $data['query']['id_ComissaoFunc'];
			$_SESSION['FiltroComissaoFunc']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$_SESSION['FiltroComissaoFunc']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$_SESSION['FiltroComissaoFunc']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$_SESSION['FiltroComissaoFunc']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$_SESSION['FiltroComissaoFunc']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$_SESSION['FiltroComissaoFunc']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$_SESSION['FiltroComissaoFunc']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$_SESSION['FiltroComissaoFunc']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$_SESSION['FiltroComissaoFunc']['Quitado'] = $data['query']['Quitado'];
			$_SESSION['FiltroComissaoFunc']['StatusComissaoFunc'] = $data['query']['StatusComissaoFunc'];
			$_SESSION['FiltroComissaoFunc']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$_SESSION['FiltroComissaoFunc']['AVAP'] = $data['query']['AVAP'];
			$_SESSION['FiltroComissaoFunc']['TipoFrete'] = $data['query']['TipoFrete'];
			$_SESSION['FiltroComissaoFunc']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$_SESSION['FiltroComissaoFunc']['Orcamento'] = $data['query']['Orcamento'];
			$_SESSION['FiltroComissaoFunc']['Cliente'] = $data['query']['Cliente'];
			$_SESSION['FiltroComissaoFunc']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$_SESSION['FiltroComissaoFunc']['Modalidade'] = $data['query']['Modalidade'];
			$_SESSION['FiltroComissaoFunc']['nome'] = $data['query']['nome'];
			$_SESSION['FiltroComissaoFunc']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroComissaoFunc']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['FiltroComissaoFunc']['metodo'] = $data['metodo'];
			$_SESSION['FiltroComissaoFunc']['idTab_TipoRD'] = $data['TipoRD'];

			$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissaofunc($_SESSION['FiltroComissaoFunc'],FALSE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio_com/comissaofunc' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();			
				
				$config['base_url'] = base_url() . 'relatorio_com/comissaofunc_pag/';
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

				$data['report'] = $this->Relatorio_model_list->list_comissaofunc($_SESSION['FiltroComissaoFunc'], FALSE, FALSE, $config['per_page'], $data['linha']);		

				$_SESSION['FiltroComissaoFunc']['Limit'] = $data['per_page'];
				$_SESSION['FiltroComissaoFunc']['Start'] = $data['linha'];

				$data['pagination'] = $this->pagination->create_links();
				
				$data['list1'] = $this->load->view('relatorio_com/list_comissaofunc', $data, TRUE);
			}	
        }		

        $this->load->view('relatorio_com/tela_comissaofunc', $data);

        $this->load->view('basico/footer');

    }

	public function comissaofunc_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Um Colaborador deve ser Selecionado. Refaça o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 6)
            $data['msg'] = $this->basico->msg('<strong>A quantidade de Receitas deve ser maior ou igual a 1. Refaça o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		//$data['query']['nome'] = 'Cliente';
		$data['titulo'] = 'Comissão Funcionario';
		$data['form_open_path'] = 'relatorio_com/comissaofunc_pag';
		$data['baixatodas'] = 'Relatorio_com/comissaofunc_baixa/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
		$data['nomeusuario'] = 'NomeColaborador';
		$data['status'] = 'StatusComissaoFunc';
		$data['alterar'] = 'relatorio_com/comissaofunc/';
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
		$data['imprimirlista'] = 'Relatorio_com/comissaofunc_lista/';
		$data['imprimirrecibo'] = 'Relatorio_com/comissaofunc_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio_com/comissaofunc/';

		$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissaofunc($_SESSION['FiltroComissaoFunc'],FALSE, TRUE);
		
		if($data['pesquisa_query'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio_com/comissaofunc' . $data['msg']);
			exit();
		}else{

			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			
			$config['base_url'] = base_url() . 'relatorio_com/comissaofunc_pag/';
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
		
			$_SESSION['FiltroComissaoFunc']['Limit'] = $data['per_page'];
			$_SESSION['FiltroComissaoFunc']['Start'] = $data['linha'];

			$data['report'] = $this->Relatorio_model_list->list_comissaofunc($_SESSION['FiltroComissaoFunc'], FALSE, FALSE, $config['per_page'], $data['linha']);
						
			$data['pagination'] = $this->pagination->create_links();

			$data['list1'] = $this->load->view('relatorio_com/list_comissaofunc', $data, TRUE);
		}
        $this->load->view('relatorio_com/tela_comissaofunc', $data);

        $this->load->view('basico/footer');

    }
	
    public function comissaofunc_baixa($id = FALSE) {

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
				'DataPagoComissãoPadrao',
			), TRUE));
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['empresa'] = quotes_to_entities($this->input->post(array(
				#### Sis_Empresa ####
				'idSis_Empresa',
				
			), TRUE));

			(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				if ($this->input->post('idApp_OrcaTrata' . $i)) {
					$data['orcamento'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
					$data['orcamento'][$j]['ValorComissaoFunc'] = $this->input->post('ValorComissaoFunc' . $i);
					$j++;
				}
			}
			
			$data['count']['PRCount'] = $j - 1;

			//$this->load->library('pagination');

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
					
					if($_SESSION['FiltroComissaoFunc']['NomeUsuario'] == 0){
						
						$data['msg'] = '?m=5';
						redirect(base_url() . 'relatorio_com/comissaofunc' . $data['msg']);
						exit();
						
					}else{
						
						$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissaofunc($_SESSION['FiltroComissaoFunc'], TRUE, TRUE, FALSE, FALSE, FALSE);

				
						if($data['pesquisa_query'] === FALSE){
							$data['msg'] = '?m=4';
							redirect(base_url() . 'relatorio_com/comissaofunc' . $data['msg']);
							exit();
						}else{

							$_SESSION['FiltroComissaoFunc']['FinalTotal'] = $data['pesquisa_query']->soma2->somafinal2;

							$_SESSION['FiltroComissaoFunc']['ComissaoTotal'] = $data['pesquisa_query']->soma2->somacomissaofunc2;						
							
							$_SESSION['FiltroComissaoFunc']['TotalRows'] = $config['total_rows'] = $data['pesquisa_query']->num_rows();

							if($config['total_rows'] < 1){
								$data['msg'] = '?m=6';
								redirect(base_url() . 'relatorio_com/comissaofunc' . $data['msg']);
								exit();
							}else{
								
								$config['base_url'] = base_url() . 'Relatorio_com/comissaofunc_baixa/' . $id . '/';
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
									$_SESSION['FiltroComissaoFunc']['Total_Rows'] = $data['total_rows'] = $config['total_rows'];
								}else{
									$_SESSION['FiltroComissaoFunc']['Total_Rows'] = $data['total_rows'] = 0;
								}
								
								$this->pagination->initialize($config);
								
								$_SESSION['FiltroComissaoFunc']['Pagina'] = $data['pagina'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
								
								$_SESSION['FiltroComissaoFunc']['Pagina_atual'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"])) : 0;
								
								$_SESSION['FiltroComissaoFunc']['Per_Page'] = $data['per_page'] = $config['per_page'];
								
								$_SESSION['FiltroComissaoFunc']['Pagination'] = $data['pagination'] = $this->pagination->create_links();		

								#### App_Parcelas ####
								//$data['orcamento'] = $this->Orcatrata_model->get_baixadacomissaofunc($_SESSION['FiltroComissaoFunc'], FALSE, $_SESSION['FiltroComissaoFunc']['Per_Page'], ($_SESSION['FiltroComissaoFunc']['Pagina'] * $_SESSION['FiltroComissaoFunc']['Per_Page']), FALSE);
								$data['orcamento'] = $this->Relatorio_model_list->list_comissaofunc($_SESSION['FiltroComissaoFunc'], TRUE, FALSE, $_SESSION['FiltroComissaoFunc']['Per_Page'], ($_SESSION['FiltroComissaoFunc']['Pagina'] * $_SESSION['FiltroComissaoFunc']['Per_Page']), TRUE);

								if (count($data['orcamento']) > 0) {
									$data['orcamento'] = array_combine(range(1, count($data['orcamento'])), array_values($data['orcamento']));
									$_SESSION['FiltroComissaoFunc']['Contagem'] = $data['count']['PRCount'] = count($data['orcamento']);
									
									if (isset($data['orcamento'])) {

										$data['somatotal'] = 0;
										
										for($j=1; $j <= $data['count']['PRCount']; $j++) {
											
											$data['somatotal'] += $data['orcamento'][$j]['ValorComissaoFunc'];
											
											$_SESSION['Orcamento'][$j]['DataOrca'] 				= $this->basico->mascara_data($data['orcamento'][$j]['DataOrca'], 'barras');
											$_SESSION['Orcamento'][$j]['DataPagoComissaoFunc'] 	= $this->basico->mascara_data($data['orcamento'][$j]['DataPagoComissaoFunc'], 'barras');
											$_SESSION['Orcamento'][$j]['ValorRestanteOrca'] 	= $data['orcamento'][$j]['ValorRestanteOrca'];
											$_SESSION['Orcamento'][$j]['Tipo_Orca'] 			= $data['orcamento'][$j]['Tipo_Orca'];
											$_SESSION['Orcamento'][$j]['NomeColaborador'] 		= $data['orcamento'][$j]['NomeColaborador'];
											
											if($data['orcamento'][$j]['Tipo_Orca'] == "O") {
												$tipo_orca = 'On Line';
											} elseif($data['orcamento'][$j]['Tipo_Orca'] == "B"){
												$tipo_orca = 'Na Loja';
											}else{
												$tipo_orca = 'Outros';
											}
											$_SESSION['Orcamento'][$j]['Tipo_Orca'] 	= $tipo_orca;
											
											if($data['orcamento'][$j]['StatusComissaoFunc'] == "S"){
												$statuscomissaofunc = 'Sim';
											}else{
												$statuscomissaofunc = 'Não';
											}
											$_SESSION['Orcamento'][$j]['StatusComissaoFunc'] = $statuscomissaofunc;
											
										}
										
										$_SESSION['FiltroComissaoFunc']['SomaTotal'] = number_format($data['somatotal'],2,",",".");
									}
								}else{
									$_SESSION['FiltroComissaoFunc']['Contagem'] = 0;
									$_SESSION['FiltroComissaoFunc']['SomaTotal'] = 0;
								}
							}	
						}
					}
				}
			}
			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['somatotal']);
			  echo "</pre>";
			  exit ();
			*/
				
			if(!$data['empresa']['idSis_Empresa'] || $data['empresa']['idSis_Empresa'] !== $_SESSION['log']['idSis_Empresa']){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}else{
				
				$data['select']['QuitadoComissao'] = $this->Basico_model->select_status_sn();	
				
				$data['titulo'] = 'Comissao Vend./Super.';
				$data['form_open_path'] = 'Relatorio_com/comissaofunc_baixa';
				$data['relatorio'] = 'relatorio_com/comissaofunc_pag/';
				$data['imprimir'] = 'Relatorio_com/comissaofunc_lista/';
				$data['nomeusuario'] = 'NomeColaborador';
				$data['statuscomissaofunc'] = 'StatusComissaoFunc';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'info';
				$data['metodo'] = 1;

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
				
				(!$data['query']['QuitadoComissao']) ? $data['query']['QuitadoComissao'] = 'N' : FALSE;
				$data['radio'] = array(
					'QuitadoComissao' => $this->basico->radio_checked($data['query']['QuitadoComissao'], 'Quitar Comissao', 'NS'),
				);
				($data['query']['QuitadoComissao'] == 'S') ?
					$data['div']['QuitadoComissao'] = '' : $data['div']['QuitadoComissao'] = 'style="display: none;"';
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				#### Sis_Empresa ####
				$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');
				if($data['query']['QuitadoComissao'] == 'S'){
					$this->form_validation->set_rules('DataPagoComissãoPadrao', 'Data do Pagamento', 'required|trim|valid_date');
				}

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('Relatorio_com/form_comissaofunc_baixa', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {

						$data['bd']['QuitadoComissao'] = $data['query']['QuitadoComissao'];
						$data['bd']['DataPagoComissãoPadrao'] = $data['query']['DataPagoComissãoPadrao'];
						
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						
						$data['query']['DataPagoComissãoPadrao'] = $this->basico->mascara_data($data['query']['DataPagoComissãoPadrao'], 'mysql');            
						
						if($data['query']['QuitadoComissao'] == 'N'){
							
							#### App_ParcelasRec ####
							//$data['update']['orcamento']['anterior'] = $this->Orcatrata_model->get_baixadacomissaofunc($_SESSION['FiltroComissaoFunc'], FALSE, $_SESSION['FiltroComissaoFunc']['Per_Page'], ($_SESSION['FiltroComissaoFunc']['Pagina'] * $_SESSION['FiltroComissaoFunc']['Per_Page']), FALSE);
							$data['update']['orcamento']['anterior'] = $this->Relatorio_model_list->list_comissaofunc($_SESSION['FiltroComissaoFunc'], TRUE, FALSE, $_SESSION['FiltroComissaoFunc']['Per_Page'], ($_SESSION['FiltroComissaoFunc']['Pagina'] * $_SESSION['FiltroComissaoFunc']['Per_Page']), TRUE);

							if (isset($data['orcamento']) || (!isset($data['orcamento']) && isset($data['update']['orcamento']['anterior']) ) ) {

								if (isset($data['orcamento']))
									$data['orcamento'] = array_values($data['orcamento']);
								else
									$data['orcamento'] = array();

								//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
								$data['update']['orcamento'] = $this->basico->tratamento_array_multidimensional($data['orcamento'], $data['update']['orcamento']['anterior'], 'idApp_OrcaTrata');

								$max = count($data['update']['orcamento']['alterar']);
								for($j=0;$j<$max;$j++) {
									
									if(empty($data['update']['orcamento']['alterar'][$j]['ValorComissaoFunc'])){
										$data['update']['orcamento']['alterar'][$j]['ValorComissaoFunc'] = "0.00"; 
									}else{
										$data['update']['orcamento']['alterar'][$j]['ValorComissaoFunc'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['ValorComissaoFunc']));
									}
									
								}

								if (count($data['update']['orcamento']['alterar']))
									$data['update']['orcamento']['bd']['alterar'] =  $this->Orcatrata_model->update_comissao($data['update']['orcamento']['alterar']);

							}

							$data['msg'] = '?m=1';
		
							redirect(base_url() . 'Relatorio_com/comissaofunc_baixa/' . $_SESSION['log']['idSis_Empresa'] . '/' . $_SESSION['FiltroComissaoFunc']['Pagina_atual'] . $data['msg']);
						
						}elseif($data['query']['QuitadoComissao'] == 'S'){

							//////// vou gerar uma despesa e pegar o id . Posso os dados da despesa com uma linha de parcela

							$data['recibo']['NivelOrca']			= 1;
							$data['recibo']['DataOrca'] 			= $data['query']['DataPagoComissãoPadrao'];
							$data['recibo']['HoraOrca'] 			= date('H:i:s', time());
							$data['recibo']['idTab_TipoRD']			= 1;
							$data['recibo']['idTab_Modulo']			= 1;
							$data['recibo']['idSis_Empresa'] 		= $_SESSION['log']['idSis_Empresa'];
							$data['recibo']['idSis_Usuario'] 		= $_SESSION['log']['idSis_Usuario'];
							$data['recibo']['id_Funcionario'] 		= $_SESSION['FiltroComissaoFunc']['NomeUsuario'];
							$data['recibo']['id_Associado'] 		= 0;
							
							$data['recibo']['TipoFinanceiro']		= 67;
							$data['recibo']['Cli_Forn_Orca']		= "N";
							$data['recibo']['Func_Orca']			= "S";
							$data['recibo']['Prd_Srv_Orca']			= "N";
							$data['recibo']['Entrega_Orca']			= "N";
							
							$data['recibo']['AVAP']					= "V";
							$data['recibo']['FormaPagamento']		= 7;
							$data['recibo']['QtdParcelasOrca']		= 1;
							$data['recibo']['DataVencimentoOrca'] 	= $data['query']['DataPagoComissãoPadrao'];
							$data['recibo']['Modalidade']			= "P";
							
							$data['recibo']['ValorExtraOrca'] 		= str_replace(',', '.', str_replace('.', '', $_SESSION['FiltroComissaoFunc']['ComissaoTotal']));
							$data['recibo']['ValorTotalOrca'] 		= $data['recibo']['ValorExtraOrca'];
							$data['recibo']['SubValorFinal'] 		= $data['recibo']['ValorExtraOrca'];
							$data['recibo']['ValorFinalOrca'] 		= $data['recibo']['ValorExtraOrca'];
							if(isset($data['recibo']['ValorExtraOrca']) && $data['recibo']['ValorExtraOrca'] > 0){
								$data['recibo']['BrindeOrca'] 		= "N";
								$data['recibo']['QuitadoOrca'] 		= "N";
								$data['recibo']['FinalizadoOrca'] 	= "N";
							}else{
								$data['recibo']['BrindeOrca'] 		= "S";
								$data['recibo']['QuitadoOrca'] 		= "S";
								$data['recibo']['FinalizadoOrca'] 	= "S";
							}
							$data['recibo']['CombinadoFrete'] 		= "S";
							$data['recibo']['AprovadoOrca'] 		= "S";
							$data['recibo']['ProntoOrca'] 			= "S";
							$data['recibo']['EnviadoOrca'] 			= "S";
							$data['recibo']['ConcluidoOrca'] 		= "S";
							
							$data['recibo']['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['recibo']);
						
							if ($data['recibo']['idApp_OrcaTrata'] === FALSE) {
								
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

								$this->basico->erro($msg);
								$this->load->view('Relatorio_com/form_comissaofunc_baixa', $data);
							
							} else {
								
								#### App_ParcelasRec ####
								if(isset($data['recibo']['ValorExtraOrca']) && $data['recibo']['ValorExtraOrca'] > 0){	
									$max = 1;
									for($j=1;$j<=$max;$j++) {
										$data['parcelasrec'][$j]['idApp_OrcaTrata'] 		= $data['recibo']['idApp_OrcaTrata'];
										$data['parcelasrec'][$j]['idSis_Usuario'] 			= $_SESSION['log']['idSis_Usuario'];
										$data['parcelasrec'][$j]['idSis_Empresa'] 			= $_SESSION['log']['idSis_Empresa'];
										$data['parcelasrec'][$j]['idTab_Modulo'] 			= $_SESSION['log']['idTab_Modulo'];
										$data['parcelasrec'][$j]['idApp_Fornecedor'] 		= 0;					
										$data['parcelasrec'][$j]['idTab_TipoRD'] 			= "1";
										$data['parcelasrec'][$j]['NivelParcela'] 			= 1;
										
										$data['parcelasrec'][$j]['Parcela'] 				= "1/1";
										$data['parcelasrec'][$j]['ValorParcela'] 			= $data['recibo']['ValorExtraOrca'];
										$data['parcelasrec'][$j]['FormaPagamentoParcela'] 	= $data['recibo']['FormaPagamento'];									
										$data['parcelasrec'][$j]['DataVencimento'] 			= $data['query']['DataPagoComissãoPadrao'];
										$data['parcelasrec'][$j]['Quitado'] 				= 'N';
										$data['parcelasrec'][$j]['DataPago'] 				= "0000-00-00";
										$data['parcelasrec'][$j]['DataLanc'] 				= "0000-00-00";
										
									}
									$data['parcelasrec']['idApp_Parcelas'] = $this->Orcatrata_model->set_parcelas($data['parcelasrec']);
								}
								/////// Corro a lista com o filtro da sessão colocando o id_Comissao em cada orcamento
								
								//$data['update']['orcamentos'] = $this->Orcatrata_model->get_baixadacomissaofunc($_SESSION['FiltroComissaoFunc'], FALSE, FALSE, FALSE, TRUE);// pega as OS que tem essa repeticao			
								$data['update']['orcamentos'] = $this->Relatorio_model_list->list_comissaofunc($_SESSION['FiltroComissaoFunc'], TRUE, TRUE, FALSE, FALSE, TRUE);

								$max = count($data['update']['orcamentos']);
								
								if(isset($max) && $max > 0){
									
									for($j=0;$j<$max;$j++) {
										$data['update']['orcamentos'][$j]['id_ComissaoFunc'] 		= $data['recibo']['idApp_OrcaTrata'];
										$data['update']['orcamentos'][$j]['StatusComissaoFunc'] 	= 'S';
										$data['update']['orcamentos'][$j]['DataPagoComissaoFunc'] 	= $data['query']['DataPagoComissãoPadrao'];
										
										$data['update']['orcamentos']['bd'][$j] = $this->Orcatrata_model->update_orcatrata($data['update']['orcamentos'][$j], $data['update']['orcamentos'][$j]['idApp_OrcaTrata']);
										/*
										$data['update']['produto']['posterior'][$j] = $this->Orcatrata_model->get_produto_comissao_pedido($data['update']['orcamentos'][$j]['idApp_OrcaTrata']);
										
										if (isset($data['update']['produto']['posterior'][$j])){
											$max_produto = count($data['update']['produto']['posterior'][$j]);
											for($k=0;$k<$max_produto;$k++) {
												$data['update']['produto']['posterior'][$j][$k]['StatusComissaoFuncionario'] 	= 'S';
												$data['update']['produto']['posterior'][$j][$k]['DataPagoComissaoFuncionario'] 	= $data['query']['DataPagoComissãoPadrao'];
											}
											if (count($data['update']['produto']['posterior'][$j]))
												$data['update']['produto']['bd']['posterior'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['posterior'][$j]);
										}
										*/
									}
								}
								
								/////// Ao terminar abro a despesa/Recibo criado
								$data['msg'] = '?m=1';
								redirect(base_url() . 'OrcatrataPrint/imprimirdesp/' . $data['recibo']['idApp_OrcaTrata'] . $data['msg']);
							}
						}else{
								
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('Relatorio_com/form_comissaofunc_baixa', $data);
							
						}	
						exit();
					}					
				}
			}
		}
        $this->load->view('basico/footer');

    }

	public function comissaoserv() {
		
		unset($_SESSION['Filtro_Porservicos']);
		/*				
		echo '<br>';
		echo "<pre>";
		if(isset($_SESSION['Filtro_Porservicos'])){
			print_r($_SESSION['Filtro_Porservicos']);
		}else{
			print_r('limpo');
		}
		echo "</pre>";
		*/
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
			'idApp_ClientePet',
			'idApp_ClientePet2',
			'idApp_ClienteDep',
			'idApp_ClienteDep2',
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
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'CombinadoFrete',
			'ConcluidoProduto',
			'StatusComissaoServico',
			'Modalidade',
			'FormaPagamento',
			'TipoFrete',
			'Agrupar',
			'Ultimo',
			'nome',
			'RecorrenciaOrca',
        ), TRUE));
		/*
		if (!$data['query']['DataInicio8'])
           $data['query']['DataInicio8'] = date("d/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		
		if (!$data['query']['DataFim8'])
           $data['query']['DataFim8'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
					
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

		$data['select']['Funcionario'] = $this->Relatorio_model->select_funcionario();
		
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Categoria'] = $this->Relatorio_model->select_catprod();
		$data['select']['Receitas'] = $this->Relatorio_model->select_tipofinanceiroR();	
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
		
		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Vendidos';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio_com/comissaoserv';
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
		$data['baixacomissao'] = 'Relatorio_com/comissaoserv_baixa/';
		$data['paginacao'] = 'N';
		
		/*				
		echo '<br>';
		echo "<pre>";
		if(isset($_SESSION['Filtro_Porservicos'])){
			print_r($_SESSION['Filtro_Porservicos']);
		}else{
			print_r('limpo');
		}
		echo "</pre>";
		*/
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

			$_SESSION['Filtro_Porservicos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$_SESSION['Filtro_Porservicos']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$_SESSION['Filtro_Porservicos']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$_SESSION['Filtro_Porservicos']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$_SESSION['Filtro_Porservicos']['DataInicio7'] = $this->basico->mascara_data($data['query']['DataInicio7'], 'mysql');
			$_SESSION['Filtro_Porservicos']['DataFim7'] = $this->basico->mascara_data($data['query']['DataFim7'], 'mysql');
			$_SESSION['Filtro_Porservicos']['DataInicio8'] = $this->basico->mascara_data($data['query']['DataInicio8'], 'mysql');
			$_SESSION['Filtro_Porservicos']['DataFim8'] = $this->basico->mascara_data($data['query']['DataFim8'], 'mysql');
			$_SESSION['Filtro_Porservicos']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
			$_SESSION['Filtro_Porservicos']['StatusComissaoServico'] = $data['query']['StatusComissaoServico'];
			$_SESSION['Filtro_Porservicos']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$_SESSION['Filtro_Porservicos']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$_SESSION['Filtro_Porservicos']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$_SESSION['Filtro_Porservicos']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$_SESSION['Filtro_Porservicos']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$_SESSION['Filtro_Porservicos']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$_SESSION['Filtro_Porservicos']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$_SESSION['Filtro_Porservicos']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$_SESSION['Filtro_Porservicos']['AVAP'] = $data['query']['AVAP'];
			$_SESSION['Filtro_Porservicos']['TipoFrete'] = $data['query']['TipoFrete'];
			$_SESSION['Filtro_Porservicos']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$_SESSION['Filtro_Porservicos']['Orcamento'] = $data['query']['Orcamento'];
			$_SESSION['Filtro_Porservicos']['Cliente'] = $data['query']['Cliente'];
			$_SESSION['Filtro_Porservicos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$_SESSION['Filtro_Porservicos']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
			$_SESSION['Filtro_Porservicos']['idApp_ClientePet2'] = $data['query']['idApp_ClientePet2'];
			$_SESSION['Filtro_Porservicos']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
			$_SESSION['Filtro_Porservicos']['idApp_ClienteDep2'] = $data['query']['idApp_ClienteDep2'];
			$_SESSION['Filtro_Porservicos']['Funcionario'] = $data['query']['Funcionario'];
			$_SESSION['Filtro_Porservicos']['Modalidade'] = $data['query']['Modalidade'];
			$_SESSION['Filtro_Porservicos']['Produtos'] = $data['query']['Produtos'];
			$_SESSION['Filtro_Porservicos']['Categoria'] = $data['query']['Categoria'];
			$_SESSION['Filtro_Porservicos']['Campo'] = $data['query']['Campo'];
			$_SESSION['Filtro_Porservicos']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['Filtro_Porservicos']['nome'] = $data['query']['nome'];
			$_SESSION['Filtro_Porservicos']['Agrupar'] = $data['query']['Agrupar'];
			$_SESSION['Filtro_Porservicos']['Ultimo'] = $data['query']['Ultimo'];
			$_SESSION['Filtro_Porservicos']['metodo'] = $data['metodo'];
			$_SESSION['Filtro_Porservicos']['idTab_TipoRD'] = $data['TipoRD'];
			$_SESSION['Filtro_Porservicos']['RecorrenciaOrca'] = $data['query']['RecorrenciaOrca'];
				
			$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissaoserv($_SESSION['Filtro_Porservicos'],FALSE, TRUE, FALSE, FALSE, FALSE);
			
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			
			$config['base_url'] = base_url() . 'relatorio_com/comissaoserv_pag/';

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
			$data['report'] = $this->Relatorio_model_list->list_comissaoserv($_SESSION['Filtro_Porservicos'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']), FALSE);			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list1'] = $this->load->view('relatorio_com/list_comissaoserv', $data, TRUE);
        }

        $this->load->view('relatorio_com/tela_comissaoserv', $data);

        $this->load->view('basico/footer');

    }

	public function comissaoserv_pag() {
		/*				
		echo '<br>';
		echo "<pre>";
		if(isset($_SESSION['Filtro_Porservicos'])){
			print_r($_SESSION['Filtro_Porservicos']);
		}else{
			print_r('limpo');
		}
		echo "</pre>";
		*/
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query']['nome'] = 'Cliente';
        $data['titulo1'] = 'Vendidos';
		$data['metodo'] = 2;
		$data['form_open_path'] = 'relatorio_com/comissaoserv_pag';
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['editar'] = 2;
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Relatorio_print/cobrancas_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['baixacomissao'] = 'Relatorio_com/comissaoserv_baixa/';
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio_com/comissaoserv/';
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissaoserv($_SESSION['Filtro_Porservicos'],FALSE, TRUE, FALSE, FALSE, FALSE);
			
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			
			$config['base_url'] = base_url() . 'relatorio_com/comissaoserv_pag/';
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
			$data['report'] = $this->Relatorio_model_list->list_comissaoserv($_SESSION['Filtro_Porservicos'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']), FALSE);			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list1'] = $this->load->view('relatorio_com/list_comissaoserv', $data, TRUE);
        }

        $this->load->view('relatorio_com/tela_comissaoserv', $data);

        $this->load->view('basico/footer');

    }
	
    public function comissaoserv_baixa($id = FALSE) {

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
				'Dia',
				'Mesvenc',
				'Ano',
				'Orcarec',
				'NomeCliente',
				'QuitadoParcelas',
				'MostrarDataPagamento',
				'DataPagamento',
				'UltimaDataPagamento',
				'AprovadoOrca',
				'ConcluidoOrca',
				'QuitadoOrca',
			), TRUE));
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['empresa'] = quotes_to_entities($this->input->post(array(
				#### Sis_Empresa ####
				'idSis_Empresa',
			), TRUE));

			($_SESSION['Usuario']['Bx_Pag'] == "S") ? $data['div']['Prof_comissao'] = '' : $data['div']['Prof_comissao'] = 'style="display: none;"';		

			(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
			
			$datadehoje = date('Y-m-d', time());
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				if ($this->input->post('DataPagoComissaoServico' . $i) || $this->input->post('StatusComissaoServico' . $i)) {
					//$data['produto'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
					//$data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
					//$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
					//$data['produto'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoProduto' . $i);
					$data['produto'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoProduto' . $i);
					$data['produto'][$j]['idApp_Produto'] = $this->input->post('idApp_Produto' . $i);
					$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
					$data['produto'][$j]['ValorComissaoServico'] = $this->input->post('ValorComissaoServico' . $i);
					$data['produto'][$j]['DataPagoComissaoServico'] = $this->input->post('DataPagoComissaoServico' . $i);
					$data['produto'][$j]['StatusComissaoServico'] = $this->input->post('StatusComissaoServico' . $i);
					
					(!$data['produto'][$j]['StatusComissaoServico']) ? $data['produto'][$j]['StatusComissaoServico'] = 'N' : FALSE;
					$data['radio'] = array(
						'StatusComissaoServico' . $j => $this->basico->radio_checked($data['produto'][$j]['StatusComissaoServico'], 'StatusComissaoServico' . $j, 'NS'),
					);
					($data['produto'][$j]['StatusComissaoServico'] == 'S') ? $data['div']['StatusComissaoServico' . $j] = '' : $data['div']['StatusComissaoServico' . $j] = 'style="display: none;"';				
					
					$data['produto'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalProduto_1' . $i);
					$data['produto'][$j]['ProfissionalProduto_2'] = $this->input->post('ProfissionalProduto_2' . $i);
					$data['produto'][$j]['ProfissionalProduto_3'] = $this->input->post('ProfissionalProduto_3' . $i);
					$data['produto'][$j]['ProfissionalProduto_4'] = $this->input->post('ProfissionalProduto_4' . $i);
					$data['produto'][$j]['ProfissionalProduto_5'] = $this->input->post('ProfissionalProduto_5' . $i);
					$data['produto'][$j]['ProfissionalProduto_6'] = $this->input->post('ProfissionalProduto_6' . $i);
		
					$data['select'][$j]['ProfissionalProduto_1'] = $this->Usuario_model->select_usuario_servicos($data['produto'][$j]['ProfissionalProduto_1']);
					$data['select'][$j]['ProfissionalProduto_2'] = $this->Usuario_model->select_usuario_servicos($data['produto'][$j]['ProfissionalProduto_2']);
					$data['select'][$j]['ProfissionalProduto_3'] = $this->Usuario_model->select_usuario_servicos($data['produto'][$j]['ProfissionalProduto_3']);
					$data['select'][$j]['ProfissionalProduto_4'] = $this->Usuario_model->select_usuario_servicos($data['produto'][$j]['ProfissionalProduto_4']);
					$data['select'][$j]['ProfissionalProduto_5'] = $this->Usuario_model->select_usuario_servicos($data['produto'][$j]['ProfissionalProduto_5']);
					$data['select'][$j]['ProfissionalProduto_6'] = $this->Usuario_model->select_usuario_servicos($data['produto'][$j]['ProfissionalProduto_6']);
					
					if(!$data['produto'][$j]['ProfissionalProduto_1'] || $data['produto'][$j]['ProfissionalProduto_1'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
					}
					if(!$data['produto'][$j]['ProfissionalProduto_2'] || $data['produto'][$j]['ProfissionalProduto_2'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
					}
					if(!$data['produto'][$j]['ProfissionalProduto_3'] || $data['produto'][$j]['ProfissionalProduto_3'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
					}
					if(!$data['produto'][$j]['ProfissionalProduto_4'] || $data['produto'][$j]['ProfissionalProduto_4'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
					}
					if(!$data['produto'][$j]['ProfissionalProduto_5'] || $data['produto'][$j]['ProfissionalProduto_5'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
					}
					if(!$data['produto'][$j]['ProfissionalProduto_6'] || $data['produto'][$j]['ProfissionalProduto_6'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
					}
									
					$data['produto'][$j]['idTFProf_1'] = $this->input->post('idTFProf_Servico_1' . $i);
					$data['produto'][$j]['ComFunProf_1'] = $this->input->post('ComFunProf_Servico_1' . $i);
					$data['produto'][$j]['ValorComProf_1'] = $this->input->post('ValorComProf_Servico_1' . $i);
					
					$data['produto'][$j]['idTFProf_2'] = $this->input->post('idTFProf_Servico_2' . $i);
					$data['produto'][$j]['ComFunProf_2'] = $this->input->post('ComFunProf_Servico_2' . $i);
					$data['produto'][$j]['ValorComProf_2'] = $this->input->post('ValorComProf_Servico_2' . $i);
					
					$data['produto'][$j]['idTFProf_3'] = $this->input->post('idTFProf_Servico_3' . $i);
					$data['produto'][$j]['ComFunProf_3'] = $this->input->post('ComFunProf_Servico_3' . $i);
					$data['produto'][$j]['ValorComProf_3'] = $this->input->post('ValorComProf_Servico_3' . $i);
					
					$data['produto'][$j]['idTFProf_4'] = $this->input->post('idTFProf_Servico_4' . $i);
					$data['produto'][$j]['ComFunProf_4'] = $this->input->post('ComFunProf_Servico_4' . $i);
					$data['produto'][$j]['ValorComProf_4'] = $this->input->post('ValorComProf_Servico_4' . $i);
					
					$data['produto'][$j]['idTFProf_5'] = $this->input->post('idTFProf_Servico_5' . $i);
					$data['produto'][$j]['ComFunProf_5'] = $this->input->post('ComFunProf_Servico_5' . $i);
					$data['produto'][$j]['ValorComProf_5'] = $this->input->post('ValorComProf_Servico_5' . $i);
					
					$data['produto'][$j]['idTFProf_6'] = $this->input->post('idTFProf_Servico_6' . $i);
					$data['produto'][$j]['ComFunProf_6'] = $this->input->post('ComFunProf_Servico_6' . $i);
					$data['produto'][$j]['ValorComProf_6'] = $this->input->post('ValorComProf_Servico_6' . $i);
					
					$j++;
				}
			}
			$data['count']['PRCount'] = $j - 1;
			
			//$this->load->library('pagination');
			$config['per_page'] = 10;
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
			$data['Pesquisa'] = '';
			
			if ($id) {
				
				#### Sis_Empresa ####
				$data['empresa'] = $this->Orcatrata_model->get_orcatrataalterar($id);
			
				if($data['empresa'] === FALSE){
					
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}else{

					$data['pesquisa_query'] = $this->Relatorio_model_list->list_comissaoserv($_SESSION['Filtro_Porservicos'], TRUE, TRUE, FALSE, FALSE, FALSE);
			
					if($data['pesquisa_query'] === FALSE){
						$data['msg'] = '?m=4';
						redirect(base_url() . 'relatorio_com/comissaoserv' . $data['msg']);
						exit();
					}else{

						$config['base_url'] = base_url() . 'Relatorio_com/comissaoserv_baixa/' . $id . '/';
						
						$config['total_rows'] = $data['pesquisa_query']->num_rows();					   
						
						if($config['total_rows'] >= 1){
							$_SESSION['Filtro_Porservicos']['Total_Rows'] = $data['total_rows'] = $config['total_rows'];
						}else{
							$_SESSION['Filtro_Porservicos']['Total_Rows'] = $data['total_rows'] = 0;
						}
						
						$this->pagination->initialize($config);
						
						$_SESSION['Filtro_Porservicos']['Pagina'] = $data['pagina'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
						$_SESSION['Filtro_Porservicos']['Per_Page'] = $data['per_page'] = $config['per_page'];
						
						$_SESSION['Filtro_Porservicos']['Pagination'] = $data['pagination'] = $this->pagination->create_links();		

						#### App_Produto ####
						
						//$_SESSION['Produto'] = $data['produto'] = $this->Orcatrata_model->get_baixadacomissaoservico($id, FALSE, $_SESSION['Filtro_Porservicos']['Per_Page'], ($_SESSION['Filtro_Porservicos']['Pagina'] * $_SESSION['Filtro_Porservicos']['Per_Page']));
						$_SESSION['Produto'] = $data['produto'] = $this->Relatorio_model_list->list_comissaoserv($_SESSION['Filtro_Porservicos'], TRUE, FALSE, $_SESSION['Filtro_Porservicos']['Per_Page'], ($_SESSION['Filtro_Porservicos']['Pagina'] * $_SESSION['Filtro_Porservicos']['Per_Page']), TRUE);
						
						if (count($data['produto']) > 0) {
							$_SESSION['Produto'] = $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
							$data['count']['PRCount'] = count($data['produto']);
							
							if (isset($data['produto'])) {

								for($j=1; $j <= $data['count']['PRCount']; $j++) {
									
									$_SESSION['Produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
									$data['produto'][$j]['ValorComissaoServico'] = number_format(($data['produto'][$j]['ValorComissaoServico']), 2, ',', '.');
									$data['produto'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataConcluidoProduto'], 'barras');
									
									$data['produto'][$j]['DataPagoComissaoServico'] = $this->basico->mascara_data($data['produto'][$j]['DataPagoComissaoServico'], 'barras');
									
									$_SESSION['Produto'][$j]['Receita'] = $data['produto'][$j]['Receita'];
									//$_SESSION['Produto'][$j]['Valor'] = $data['produto'][$j]['Valor'];
									
									$data['radio'] = array(
										'StatusComissaoServico' . $j => $this->basico->radio_checked($data['produto'][$j]['StatusComissaoServico'], 'StatusComissaoServico' . $j, 'NS'),
									);
									($data['produto'][$j]['StatusComissaoServico'] == 'S') ? $data['div']['StatusComissaoServico' . $j] = '' : $data['div']['StatusComissaoServico' . $j] = 'style="display: none;"';

									$data['produto'][$j]['ValorComProf_1'] = number_format(($data['produto'][$j]['ValorComProf_1']), 2, ',', '.');
									$data['produto'][$j]['ValorComProf_2'] = number_format(($data['produto'][$j]['ValorComProf_2']), 2, ',', '.');
									$data['produto'][$j]['ValorComProf_3'] = number_format(($data['produto'][$j]['ValorComProf_3']), 2, ',', '.');
									$data['produto'][$j]['ValorComProf_4'] = number_format(($data['produto'][$j]['ValorComProf_4']), 2, ',', '.');
									$data['produto'][$j]['ValorComProf_5'] = number_format(($data['produto'][$j]['ValorComProf_5']), 2, ',', '.');
									$data['produto'][$j]['ValorComProf_6'] = number_format(($data['produto'][$j]['ValorComProf_6']), 2, ',', '.');
														
									$data['select'][$j]['ProfissionalProduto_1'] = $this->Usuario_model->select_usuario_servicos();
									$data['select'][$j]['ProfissionalProduto_2'] = $this->Usuario_model->select_usuario_servicos();
									$data['select'][$j]['ProfissionalProduto_3'] = $this->Usuario_model->select_usuario_servicos();
									$data['select'][$j]['ProfissionalProduto_4'] = $this->Usuario_model->select_usuario_servicos();
									$data['select'][$j]['ProfissionalProduto_5'] = $this->Usuario_model->select_usuario_servicos();	
									$data['select'][$j]['ProfissionalProduto_6'] = $this->Usuario_model->select_usuario_servicos();	
									
									if(!$data['produto'][$j]['ProfissionalProduto_1'] || $data['produto'][$j]['ProfissionalProduto_1'] == 0){
										$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
									}else{
										$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
									}
									if(!$data['produto'][$j]['ProfissionalProduto_2'] || $data['produto'][$j]['ProfissionalProduto_2'] == 0){
										$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
									}else{
										$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
									}
									if(!$data['produto'][$j]['ProfissionalProduto_3'] || $data['produto'][$j]['ProfissionalProduto_3'] == 0){
										$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
									}else{
										$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
									}
									if(!$data['produto'][$j]['ProfissionalProduto_4'] || $data['produto'][$j]['ProfissionalProduto_4'] == 0){
										$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
									}else{
										$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
									}
									if(!$data['produto'][$j]['ProfissionalProduto_5'] || $data['produto'][$j]['ProfissionalProduto_5'] == 0){
										$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
									}else{
										$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
									}
									if(!$data['produto'][$j]['ProfissionalProduto_6'] || $data['produto'][$j]['ProfissionalProduto_6'] == 0){
										$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
									}else{
										$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
									}						
									
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
				$data['select']['StatusComissaoServico'] = $this->Basico_model->select_status_sn();
				$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['Dia'] = $this->Basico_model->select_dia();
				$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
				$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
				$data['select']['NomeCliente'] = $this->Basico_model->select_cliente();		
				
				$data['titulo'] = 'Servicos';
				$data['form_open_path'] = 'Relatorio_com/comissaoserv_baixa';
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
					$this->load->view('Relatorio_com/form_comissaoserv_baixa', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
							
						$data['bd']['Dia'] = $data['query']['Dia'];
						$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
						$data['bd']['Ano'] = $data['query']['Ano'];
						$data['bd']['Orcarec'] = $data['query']['Orcarec'];
						$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
						$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
						$data['bd']['MostrarDataPagamento'] = $data['query']['MostrarDataPagamento'];
						$data['bd']['DataPagamento'] = $data['query']['DataPagamento'];
						$data['bd']['UltimaDataPagamento'] = $data['query']['UltimaDataPagamento'];
						$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
						$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
						$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
						
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						
						$data['query']['DataPagamento'] = $this->basico->mascara_data($data['query']['DataPagamento'], 'mysql');  

						#### App_Produto ####
						//$data['update']['produto']['anterior'] = $this->Orcatrata_model->get_baixadacomissaoservico($data['empresa']['idSis_Empresa'], FALSE, $_SESSION['Filtro_Porservicos']['Per_Page'], ($_SESSION['Filtro_Porservicos']['Pagina'] * $_SESSION['Filtro_Porservicos']['Per_Page']));
						$data['update']['produto']['anterior'] = $this->Relatorio_model_list->list_comissaoserv($_SESSION['Filtro_Porservicos'], TRUE, FALSE, $_SESSION['Filtro_Porservicos']['Per_Page'], ($_SESSION['Filtro_Porservicos']['Pagina'] * $_SESSION['Filtro_Porservicos']['Per_Page']), TRUE);

						if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

							if (isset($data['produto']))
								$data['produto'] = array_values($data['produto']);
							else
								$data['produto'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_Produto');

							$max = count($data['update']['produto']['alterar']);
							for($j=0; $j<$max; $j++) {
								//$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
								
								$data['update']['produto']['alterar'][$j]['ObsProduto'] = trim(mb_strtoupper($data['update']['produto']['alterar'][$j]['ObsProduto'], 'ISO-8859-1'));
								
								$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataConcluidoProduto'], 'mysql');
								
								//$data['update']['produto']['alterar'][$j]['idApp_OrcaTrata'] = $data['update']['produto']['alterar'][$j]['idApp_OrcaTrata'];
								
								$data['update']['produto']['alterar'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorComissaoServico']));
								
								$data['update']['produto']['alterar'][$j]['DataPagoComissaoServico'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataPagoComissaoServico'], 'mysql');
							
								if(!$data['update']['produto']['alterar'][$j]['ProfissionalProduto_1']){
									$data['update']['produto']['alterar'][$j]['ProfissionalProduto_1'] = 0;
								}
								if(!$data['update']['produto']['alterar'][$j]['ProfissionalProduto_2']){
									$data['update']['produto']['alterar'][$j]['ProfissionalProduto_2'] = 0;
								}
								if(!$data['update']['produto']['alterar'][$j]['ProfissionalProduto_3']){
									$data['update']['produto']['alterar'][$j]['ProfissionalProduto_3'] = 0;
								}
								if(!$data['update']['produto']['alterar'][$j]['ProfissionalProduto_4']){
									$data['update']['produto']['alterar'][$j]['ProfissionalProduto_4'] = 0;
								}
								if(!$data['update']['produto']['alterar'][$j]['ProfissionalProduto_5']){
									$data['update']['produto']['alterar'][$j]['ProfissionalProduto_5'] = 0;
								}
								if(!$data['update']['produto']['alterar'][$j]['ProfissionalProduto_6']){
									$data['update']['produto']['alterar'][$j]['ProfissionalProduto_6'] = 0;
								}

								if(empty($data['update']['produto']['alterar'][$j]['ValorComProf_1'])){
									$data['update']['produto']['alterar'][$j]['ValorComProf_1'] = "0.00";
								}else{
									$data['update']['produto']['alterar'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorComProf_1']));
								}

								if(empty($data['update']['produto']['alterar'][$j]['ValorComProf_2'])){
									$data['update']['produto']['alterar'][$j]['ValorComProf_2'] = "0.00";
								}else{
									$data['update']['produto']['alterar'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorComProf_2']));
								}

								if(empty($data['update']['produto']['alterar'][$j]['ValorComProf_3'])){
									$data['update']['produto']['alterar'][$j]['ValorComProf_3'] = "0.00";
								}else{
									$data['update']['produto']['alterar'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorComProf_3']));
								}

								if(empty($data['update']['produto']['alterar'][$j]['ValorComProf_4'])){
									$data['update']['produto']['alterar'][$j]['ValorComProf_4'] = "0.00";
								}else{
									$data['update']['produto']['alterar'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorComProf_4']));
								}

								if(empty($data['update']['produto']['alterar'][$j]['ValorComProf_5'])){
									$data['update']['produto']['alterar'][$j]['ValorComProf_5'] = "0.00";
								}else{
									$data['update']['produto']['alterar'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorComProf_5']));
								}

								if(empty($data['update']['produto']['alterar'][$j]['ValorComProf_6'])){
									$data['update']['produto']['alterar'][$j]['ValorComProf_6'] = "0.00";
								}else{
									$data['update']['produto']['alterar'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorComProf_6']));
								}

								if ($data['query']['QuitadoParcelas'] == 'S') $data['update']['produto']['alterar'][$j]['StatusComissaoServico'] = 'S';
								
								if ($data['update']['produto']['alterar'][$j]['StatusComissaoServico'] == 'S'){
									if(!$data['update']['produto']['alterar'][$j]['DataPagoComissaoServico'] || $data['update']['produto']['alterar'][$j]['DataPagoComissaoServico'] == "0000-00-00"){
										if($data['query']['MostrarDataPagamento'] == 'N'){
											$data['update']['produto']['alterar'][$j]['DataPagoComissaoServico'] = $datadehoje;
										}else{
											$data['update']['produto']['alterar'][$j]['DataPagoComissaoServico'] = $data['query']['DataPagamento'];
										}
									}else{
										$data['update']['produto']['alterar'][$j]['DataPagoComissaoServico'] = $data['update']['produto']['alterar'][$j]['DataPagoComissaoServico'];
									}
								} else {
									$data['update']['produto']['alterar'][$j]['DataPagoComissaoServico'] = "0000-00-00";
								}
								
								$data['update']['produto']['bd'] = $this->Orcatrata_model->update_produto_id($data['update']['produto']['alterar'][$j], $data['update']['produto']['alterar'][$j]['idApp_Produto']);

							}
						}
						
						$data['msg'] = '?m=1';

						redirect(base_url() . 'Relatorio_com/comissaoserv_baixa/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

						exit();
					}	
				}
			}
		}
		$this->load->view('basico/footer');

    }
	
}