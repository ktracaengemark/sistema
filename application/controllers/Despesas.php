<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Despesas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array(	'Basico_model', 'Cliente_model', 'Relatorio_model', 'Despesas_model', 'Orcatrata_model', 'Empresa_model', 
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

        $this->load->view('Despesas/tela_index', $data);

        #load footer view
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
			'id_Funcionario',
			'id_Associado',
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
		$data['select']['id_Funcionario'] = $this->Relatorio_model->select_usuario();
		$data['select']['id_Associado'] = $this->Relatorio_model->select_cliente_associado();
		
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
		$data['form_open_path'] = 'Despesas/despesas';
		$data['baixatodas'] = 'Despesas/despesas_baixa/';
		$data['editartodas'] = 'Despesas/despesas/';
		$data['baixa'] = 'Despesas/despesa_baixa/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'Despesas/despesas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'Relatorio_deb/debitos_lista/';
		$data['imprimirrecibo'] = 'Relatorio_deb/debitos_recibo/';
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
			$_SESSION['FiltroDespesas']['id_Funcionario'] = $data['query']['id_Funcionario'];
			$_SESSION['FiltroDespesas']['id_Associado'] = $data['query']['id_Associado'];
			$_SESSION['FiltroDespesas']['Modalidade'] = $data['query']['Modalidade'];
			$_SESSION['FiltroDespesas']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroDespesas']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['FiltroDespesas']['metodo'] = $data['metodo'];
			$_SESSION['FiltroDespesas']['idTab_TipoRD'] = $data['TipoRD'];
			$_SESSION['FiltroDespesas']['Agrupar'] = $data['query']['Agrupar'];
			$_SESSION['FiltroDespesas']['Ultimo'] = $data['query']['Ultimo'];
			$_SESSION['FiltroDespesas']['nome'] = $data['query']['nome'];

			$data['pesquisa_query'] = $this->Despesas_model->list_despesas($_SESSION['FiltroDespesas'], FALSE, TRUE, FALSE, FALSE, FALSE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'Despesas/despesas' . $data['msg']);
				exit();
			}else{

				$_SESSION['FiltroDespesas']['total_valor'] = $data['pesquisa_query']->soma2->somafinal2;
				
				$_SESSION['FiltroDespesas']['total_rows'] = $config['total_rows'] = $data['pesquisa_query']->num_rows();			

				$config['base_url'] = base_url() . 'Despesas/despesas_pag/';

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
			
				$data['report'] = $this->Despesas_model->list_despesas($_SESSION['FiltroDespesas'], FALSE, FALSE, $config['per_page'], $data['linha'], FALSE);
			
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

				$data['list1'] = $this->load->view('Despesas/list_despesas', $data, TRUE);
			}	
        }		

        $this->load->view('Despesas/tela_despesas', $data);

        $this->load->view('basico/footer');

    }

	public function despesas_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
        $data['titulo'] = 'Despesas';
		$data['form_open_path'] = 'Despesas/despesas_pag';
		$data['baixatodas'] = 'Despesas/despesas_baixa/';
		$data['baixa'] = 'Despesas/despesa_baixa/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'Despesas/despesas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'Relatorio_deb/debitos_lista/';
		$data['imprimirrecibo'] = 'Relatorio_deb/debitos_recibo/';
		$data['edit'] = 'Orcatrata/alterardesp/';
		$data['alterarparc'] = 'Orcatrata/alterarparceladesp/';	
		$data['paginacao'] = 'S';
		$data['caminho'] = 'Despesas/despesas/';		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation

			$data['pesquisa_query'] = $this->Despesas_model->list_despesas($_SESSION['FiltroDespesas'], FALSE, TRUE, FALSE, FALSE, FALSE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'Despesas/despesas/' . $data['msg']);
				exit();
			}else{

				$_SESSION['FiltroDespesas']['total_valor'] = $data['pesquisa_query']->soma2->somafinal2;
				
				$_SESSION['FiltroDespesas']['total_rows'] = $config['total_rows'] = $data['pesquisa_query']->num_rows();			

				$config['base_url'] = base_url() . 'Despesas/despesas_pag/';
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
			
				$_SESSION['FiltroDespesas']['Limit'] = $data['per_page'];
				$_SESSION['FiltroDespesas']['Start'] = $data['linha'];

				$data['report'] = $this->Despesas_model->list_despesas($_SESSION['FiltroDespesas'], FALSE, FALSE, $config['per_page'], $data['linha'], FALSE);			
				
				$data['pagination'] = $this->pagination->create_links();
				
				$data['list1'] = $this->load->view('Despesas/list_despesas', $data, TRUE);
			}
       		

        $this->load->view('Despesas/tela_despesas', $data);

        $this->load->view('basico/footer');

    }

	public function despesas_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Despesas Sem Filtros';
				$data['metodo'] = $id;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroDespesas'])){
					$dados = $_SESSION['FiltroDespesas'];
					$data['titulo'] = 'Despesas Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Despesas Sem Filtros';
					$data['metodo'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Despesas Sem Filtros';
				$data['metodo'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Despesas Sem Filtros';
			$data['metodo'] = 1;
		}

        $data['nome'] = 'Fornecedor';

		$data['report'] = $this->Despesas_model->list_despesas($dados, FALSE, FALSE, FALSE, FALSE, FALSE);

		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Despesas/despesas' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Despesas/list_despesas_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

	public function despesas_lista() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
        $data['titulo'] = 'Despesas';
		$data['form_open_path'] = 'Despesas/despesas_lista';
		$data['baixatodas'] = 'Despesas/despesas_baixa/';
		$data['baixa'] = 'Despesas/despesa_baixa/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'Despesas/despesas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'Relatorio_deb/debitos_lista/';
		$data['imprimirrecibo'] = 'Relatorio_deb/debitos_recibo/';
		$data['edit'] = 'Orcatrata/alterardesp/';
		$data['alterarparc'] = 'Orcatrata/alterarparceladesp/';	
		$data['paginacao'] = 'S';
		$data['caminho'] = 'Despesas/despesas/';		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        

			$data['pesquisa_query'] = $this->Despesas_model->list_despesas($_SESSION['FiltroDespesas'], FALSE, TRUE, FALSE, FALSE, FALSE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'Despesas/despesas/' . $data['msg']);
				exit();
			}else{

				$_SESSION['FiltroDespesas']['total_valor'] = $data['pesquisa_query']->soma2->somafinal2;
				
				$_SESSION['FiltroDespesas']['total_rows'] = $config['total_rows'] = $data['pesquisa_query']->num_rows();			

				//$config['total_rows'] = $_SESSION['FiltroDespesas']['total_rows'];

				$config['base_url'] = base_url() . 'Despesas/despesas_lista/';
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
			
				$_SESSION['FiltroDespesas']['Limit'] = $data['per_page'];
				$_SESSION['FiltroDespesas']['Start'] = $data['linha'];

				$data['report'] = $this->Despesas_model->list_despesas($_SESSION['FiltroDespesas'], FALSE, FALSE, $config['per_page'], $data['linha'], FALSE);			
				
				$data['pagination'] = $this->pagination->create_links();
				
				$data['list1'] = $this->load->view('Despesas/list_despesas_lista', $data, TRUE);
			}
       		

        $this->load->view('Despesas/tela_despesas', $data);

        $this->load->view('basico/footer');

    }

    public function despesas_baixa($id = FALSE) {
		
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
						
					$data['pesquisa_query'] = $this->Despesas_model->list_despesas($_SESSION['FiltroDespesas'], TRUE, TRUE, FALSE, FALSE, FALSE);
			
					if($data['pesquisa_query'] === FALSE){
						
						$data['msg'] = '?m=4';
						redirect(base_url() . 'relatorio/despesas' . $data['msg']);
						exit();
					}else{
						
						$_SESSION['FiltroDespesas']['FinalTotal'] = $data['pesquisa_query']->soma2->somafinal2;
						
						$_SESSION['FiltroDespesas']['TotalRows'] = $config['total_rows'] = $data['pesquisa_query']->num_rows();
						
						$config['base_url'] = base_url() . 'Despesas/despesas_baixa/' . $id . '/';
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
						
						$_SESSION['FiltroDespesas']['Pagina'] = $data['pagina'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
						
						$_SESSION['FiltroDespesas']['Per_Page'] = $data['per_page'] = $config['per_page'];
						
						$_SESSION['FiltroDespesas']['Pagination'] = $data['pagination'] = $this->pagination->create_links();		

						#### App_OrcaTrata ####
						$data['orcamento'] = $this->Despesas_model->list_despesas($_SESSION['FiltroDespesas'], TRUE, TRUE, $_SESSION['FiltroDespesas']['Per_Page'], ($_SESSION['FiltroDespesas']['Pagina'] * $_SESSION['FiltroDespesas']['Per_Page']), TRUE);
						
						if (count($data['orcamento']) > 0) {
							$data['orcamento'] = array_combine(range(1, count($data['orcamento'])), array_values($data['orcamento']));
							$_SESSION['FiltroDespesas']['Contagem'] = $data['count']['PRCount'] = count($data['orcamento']);
							
							if (isset($data['orcamento'])) {
								for($j=1; $j <= $data['count']['PRCount']; $j++) {
									
									$data['somatotal'] += $data['orcamento'][$j]['ValorFinalOrca'];
									
									$_SESSION['Orcamento'][$j]['DataOrca'] = $this->basico->mascara_data($data['orcamento'][$j]['DataOrca'], 'barras');
									$_SESSION['Orcamento'][$j]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcamento'][$j]['DataEntregaOrca'], 'barras');
									$_SESSION['Orcamento'][$j]['HoraEntregaOrca'] = $data['orcamento'][$j]['HoraEntregaOrca'];
									$_SESSION['Orcamento'][$j]['ValorFinalOrca'] = $data['orcamento'][$j]['ValorFinalOrca'];
									$_SESSION['Orcamento'][$j]['Tipo_Orca'] = $data['orcamento'][$j]['Tipo_Orca'];
									$_SESSION['Orcamento'][$j]['NomeColaborador'] = $data['orcamento'][$j]['NomeColaborador'];
									$_SESSION['Orcamento'][$j]['idApp_Fornecedor'] = $data['orcamento'][$j]['idApp_Fornecedor'];
									$_SESSION['Orcamento'][$j]['NomeFornecedor'] = $data['orcamento'][$j]['NomeFornecedor'];
									
									$_SESSION['Orcamento'][$j]['CombinadoFrete'] = $data['orcamento'][$j]['CombinadoFrete'];
									$_SESSION['Orcamento'][$j]['AprovadoOrca'] = $data['orcamento'][$j]['AprovadoOrca'];
									$_SESSION['Orcamento'][$j]['ConcluidoOrca'] = $data['orcamento'][$j]['ConcluidoOrca'];
									$_SESSION['Orcamento'][$j]['QuitadoOrca'] = $data['orcamento'][$j]['QuitadoOrca'];
									$_SESSION['Orcamento'][$j]['CanceladoOrca'] = $data['orcamento'][$j]['CanceladoOrca'];
									
								}
								$_SESSION['FiltroDespesas']['SomaTotal'] = $data['somatotal'] = number_format($data['somatotal'],2,",",".");
							}
						}else{
							$_SESSION['FiltroDespesas']['Contagem'] = 0;
							$_SESSION['FiltroDespesas']['SomaTotal'] = 0;
						}
					}	
				}
			}
			
			if(!$data['empresa']['idSis_Empresa'] || $data['empresa']['idSis_Empresa'] !== $_SESSION['log']['idSis_Empresa'] ){
				
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
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				#### Sis_Empresa ####
				$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');
				//$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');

				$data['select']['QuitadoComissao'] = $this->Basico_model->select_status_sn();
				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
				$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();	
				
				$data['titulo'] = 'Baixa das Despesas';
				$data['form_open_path'] = 'Despesas/despesas_baixa';
				$data['relatorio'] = 'Despesas/despesas_pag/';
				$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
				$data['nomeusuario'] = 'NomeColaborador';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'danger';
				$data['metodo'] = 3;
				$data['TipoFinanceiro'] = 'Despesas';
				$data['TipoRD'] = 1;
				$data['nome'] = 'Fornecedor';
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

				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data);
				  echo "</pre>";
				  exit ();
				*/

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('Despesas/form_despesas_baixa', $data);
					} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
							
						$data['bd']['QuitadoComissao'] = $data['query']['QuitadoComissao'];
						
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////

						#### App_OrcaTrata ####
						$data['update']['orcamento']['anterior'] = $this->Despesas_model->list_despesas($_SESSION['FiltroDespesas'], TRUE, TRUE, $_SESSION['FiltroDespesas']['Per_Page'], ($_SESSION['FiltroDespesas']['Pagina'] * $_SESSION['FiltroDespesas']['Per_Page']), TRUE);
						if (isset($data['orcamento']) || (!isset($data['orcamento']) && isset($data['update']['orcamento']['anterior']) ) ) {

							if (isset($data['orcamento']))
								$data['orcamento'] = array_values($data['orcamento']);
							else
								$data['orcamento'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['orcamento'] = $this->basico->tratamento_array_multidimensional($data['orcamento'], $data['update']['orcamento']['anterior'], 'idApp_OrcaTrata');

							$max = count($data['update']['orcamento']['alterar']);
							for($j=0;$j<$max;$j++) {
								
								$data['Orcamento_baixa'][$j] = $this->Orcatrata_model->get_orcamento_baixa($data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);

								if ($data['query']['QuitadoComissao'] == 'S') $data['update']['orcamento']['alterar'][$j]['FinalizadoOrca'] = 'S';
								
								if ($data['update']['orcamento']['alterar'][$j]['FinalizadoOrca'] == 'S') {
									
									$data['update']['produto']['posterior'][$j] = $this->Orcatrata_model->get_produto_posterior($data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);
									if (isset($data['update']['produto']['posterior'][$j])){
										$max_produto = count($data['update']['produto']['posterior'][$j]);
										for($k=0;$k<$max_produto;$k++) {
											
											$data['update']['produto']['posterior'][$j][$k]['ConcluidoProduto'] = 'S';
											if(!$data['update']['produto']['posterior'][$j][$k]['DataConcluidoProduto'] || $data['update']['produto']['posterior'][$j][$k]['DataConcluidoProduto'] == "0000-00-00"){
												$data['update']['produto']['posterior'][$j][$k]['DataConcluidoProduto'] = $data['Orcamento_baixa'][$j]['DataEntregaOrca'];
											}
											if(!$data['update']['produto']['posterior'][$j][$k]['HoraConcluidoProduto'] || $data['update']['produto']['posterior'][$j][$k]['HoraConcluidoProduto'] == "00:00:00"){
												$data['update']['produto']['posterior'][$j][$k]['HoraConcluidoProduto'] = $data['Orcamento_baixa'][$j]['HoraEntregaOrca'];
											}
											$data['update']['produto']['bd'][$j] = $this->Orcatrata_model->update_produto_id($data['update']['produto']['posterior'][$j][$k], $data['update']['produto']['posterior'][$j][$k]['idApp_Produto']);
										
											////inicio do desconto do estoque////
											if($data['Orcamento_baixa'][$j]['CombinadoFrete'] == "N" && $data['Orcamento_baixa'][$j]['CanceladoOrca'] == "N"){	
												$data['get']['produto'][$j][$k] = $this->Orcatrata_model->get_tab_produtos($data['update']['produto']['posterior'][$j][$k]['idTab_Produtos_Produto']);
												if($data['get']['produto'][$j][$k]['ContarEstoque'] == "S"){
													$qtd_anterior[$j][$k]	= ($data['update']['produto']['posterior'][$j][$k]['QtdProduto'] * $data['update']['produto']['posterior'][$j][$k]['QtdIncrementoProduto']);
													$diff_estoque[$j][$k] 	= ($data['get']['produto'][$j][$k]['Estoque'] + $qtd_anterior[$j][$k]);
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
											////fim do desconto do estoque////	
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
						
						redirect(base_url() . 'Despesas/despesas_baixa/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

						exit();	
					}
				}
			}	
		}	
		$this->load->view('basico/footer');

    }

    public function despesa_baixa($id = FALSE) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
		}else{

			if (!$id) {
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}else{
			
				if ($this->input->get('m') == 1)
					$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
				elseif ($this->input->get('m') == 2)
					$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
				else
					$data['msg'] = '';
			
				#### App_OrcaTrata ####
				//$_SESSION['Orcatrata'] = $data['baixaorca'] = $this->Orcatrata_model->get_orcatrata($id);
				$data['baixaorca'] = $this->Orcatrata_model->get_orcamento_baixa($id);
				
				if ($data['baixaorca'] === FALSE || $data['baixaorca']['idTab_TipoRD'] != 1 || $data['baixaorca']['FinalizadoOrca'] == "S") {
					
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}else{

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
							
						$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

						#### App_OrcaTrata ####
						
						$data['titulo'] = 'Baixa da Despesa';
						$data['form_open_path'] = 'Despesas/despesa_baixa';
						$data['readonly'] = '';
						$data['disabled'] = '';
						$data['panel'] = 'danger';
						$data['metodo'] = 1;

						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						#### App_OrcaTrata ####
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";

						$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata_baixa($id);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$id, 
						TRUE);
						
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $id);

						#### App_Produto ####
						$data['update']['produto']['alterar'] = $this->Orcatrata_model->get_produto_posterior($id);
						if (isset($data['update']['produto']['alterar'])){

							$max = count($data['update']['produto']['alterar']);
							for($j=0;$j<$max;$j++) {
								
								$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
								
								if(!$data['update']['orcatrata']['anterior']['DataEntregaOrca'] || empty($data['update']['orcatrata']['anterior']['DataEntregaOrca'])){
									$data['update']['orcatrata']['anterior']['DataEntregaOrca'] = "0000-00-00";
								}

								if(!$data['update']['orcatrata']['anterior']['HoraEntregaOrca'] || empty($data['update']['orcatrata']['anterior']['HoraEntregaOrca'])){
									$data['update']['orcatrata']['anterior']['HoraEntregaOrca'] = "00:00:00";
								}
								
								if(!$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] == "0000-00-00"){
									$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $data['update']['orcatrata']['anterior']['DataEntregaOrca'];
								}
								
								if(!$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] == "00:00:00"){
									$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] = $data['update']['orcatrata']['anterior']['HoraEntregaOrca'];
								}
								
								/*
								////inicio do desconto do estoque////
								$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto']);
								if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
									$qtd_anterior[$j]	= ($data['update']['produto']['alterar'][$j]['QtdProduto'] * $data['update']['produto']['alterar'][$j]['QtdIncrementoProduto']);
									$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] + $qtd_anterior[$j]);
									if($diff_estoque[$j] <= 0){
										$estoque[$j] = 0; 
									}else{
										$estoque[$j] = $diff_estoque[$j]; 
									}
									
									$data['update']['produto'][$j]['Estoque'] = $estoque[$j];
									$data['update']['produto']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['update']['produto'][$j], $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto']);

									unset($qtd_anterior[$j]);
									unset($diff_estoque[$j]);
									unset($estoque[$j]);
								}	
								////fim do desconto do estoque////
								*/
							}
							if (count($data['update']['produto']['alterar']))
								$data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

						}

						#### App_ParcelasRec ####
						$data['update']['parcelasrec']['alterar'] = $this->Orcatrata_model->get_parcelas_posterior($id);
						if (isset($data['update']['parcelasrec']['alterar'])){
						
							$max = count($data['update']['parcelasrec']['alterar']);
							for($j=0;$j<$max;$j++) {
								
								$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';				
								
								if(!$data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] || empty($data['update']['parcelasrec']['alterar'][$j]['DataVencimento']) || $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] == "0000-00-00"){
									$data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $data['baixaorca']['DataOrca'];
								}
								
								if(!$data['update']['parcelasrec']['alterar'][$j]['DataPago'] || empty($data['update']['parcelasrec']['alterar'][$j]['DataPago']) || $data['update']['parcelasrec']['alterar'][$j]['DataPago'] == "0000-00-00"){
									$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'];
								}
								
								if(!$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] || empty($data['update']['parcelasrec']['alterar'][$j]['DataLanc'])  || $data['update']['parcelasrec']['alterar'][$j]['DataLanc'] == "0000-00-00"){
									$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = date('Y-m-d', time());
								}
								
							}
							if (count($data['update']['parcelasrec']['alterar']))
								$data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

						}

						#### App_Procedimento ####
						$data['update']['procedimento']['alterar'] = $this->Orcatrata_model->get_procedimento_posterior($id);
						if (isset($data['update']['procedimento']['alterar'])){
						
							$max = count($data['update']['procedimento']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['procedimento']['alterar'][$j]['ConcluidoProcedimento'] = 'S';				
							}
							if (count($data['update']['procedimento']['alterar']))
								$data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

						}

						#### Estoque_Produto_posterior ####
						if ($data['baixaorca']['CombinadoFrete'] == 'N' && $data['baixaorca']['CanceladoOrca'] == 'N') {
							
							$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($id);
							
							if (count($data['busca']['estoque']['posterior']) > 0) {
								
								$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
								$max_estoque = count($data['busca']['estoque']['posterior']);
								
								if (isset($data['busca']['estoque']['posterior'])){
									
									for($j=1;$j<=$max_estoque;$j++) {
										
										$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
										
										if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
											
											$qtd_produto[$j]	= ($data['busca']['estoque']['posterior'][$j]['QtdProduto'] * $data['busca']['estoque']['posterior'][$j]['QtdIncrementoProduto']);
											
											$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] + $qtd_produto[$j]);
											
											if($diff_estoque[$j] <= 0){
												$estoque[$j] = 0; 
											}else{
												$estoque[$j] = $diff_estoque[$j]; 
											}
											
											$data['alterar']['produto']['posterior'][$j]['Estoque'] = $estoque[$j];
											$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$j], $data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
											
											unset($qtd_produto[$j]);
											unset($diff_estoque[$j]);
											unset($estoque[$j]);
										}
										
									}
									
								}
								
							}
							
						}
					
						$data['msg'] = '?m=1';

						redirect(base_url() . 'Despesas/despesas/' . $data['msg']);
						exit();
					}					
				}				
			}
		}	
		$this->load->view('basico/footer');

    }
	
}