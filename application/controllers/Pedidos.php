<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Pedidos_model', 'Relatorio_model', 'Empresa_model', 'Loginempresa_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header_refresh_pedido');
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

    public function pedidos() {

		unset($_SESSION['FiltroPedidos']);
		
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
			'Campo',
			'Ordenamento',
            'Cliente',
            'idApp_Cliente',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
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
			'selecione',
        ), TRUE));

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
			'S' => 'Aprovado',
            'N' => 'Não Aprovado',
        );

		$data['select']['Quitado'] = array(
			'0' => '::TODOS::',			
			'S' => 'Quitada',
			'N' => 'NÃO Quitada',
        );

		$data['select']['ConcluidoProduto'] = array(
			'0' => '::TODOS::',			
			'S' => 'Entregue',
			'N' => 'NÃO Entregue',
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

		$data['select']['Campo'] = array(
            'OT.idApp_OrcaTrata' => 'Orçamento',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['TipoFinanceiroR'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['TipoFinanceiroD'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();		
		
        $data['titulo'] = 'Dinâmico';
        $data['form_open_path'] = 'Pedidos/pedidos';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['paginacao'] = 'N';
        $data['pedidos'] = 'Pedidos';

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
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
			//$data['bd']['selecione'] = $data['query']['selecione'];

			if(isset($data['bd']['Orcamento']) && $data['bd']['Orcamento'] !=""){
				
				$data['pesquisar'] = $this->Pedidos_model->list_pedidos_pesquisar($data['bd'],TRUE);
				
				if ($data['pesquisar']->num_rows() == 1) {
					
					$info = $data['pesquisar']->result_array();
					
					redirect('orcatrata/alterarstatus/' . $info[0]['idApp_OrcaTrata'] );

					exit();
				}else{
					
					$data['report_combinar'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'],TRUE, TRUE);
					$data['report_aprovar'] = $this->Pedidos_model->list_pedidos_aprovar($data['bd'],TRUE, TRUE);
					$data['report_producao'] = $this->Pedidos_model->list_pedidos_producao($data['bd'],TRUE, TRUE);
					$data['report_envio'] = $this->Pedidos_model->list_pedidos_envio($data['bd'],TRUE, TRUE);
					$data['report_entrega'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'],TRUE, TRUE);
					$data['report_pagamento'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'],TRUE, TRUE);
				}				
			}else{
				
				$data['report_combinar'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'],TRUE, TRUE);
				$data['report_aprovar'] = $this->Pedidos_model->list_pedidos_aprovar($data['bd'],TRUE, TRUE);
				$data['report_producao'] = $this->Pedidos_model->list_pedidos_producao($data['bd'],TRUE, TRUE);
				$data['report_envio'] = $this->Pedidos_model->list_pedidos_envio($data['bd'],TRUE, TRUE);
				$data['report_entrega'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'],TRUE, TRUE);
				$data['report_pagamento'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'],TRUE, TRUE);
			}
            /*
			$data['report_pagonline'] = $this->Pedidos_model->list_pedidos_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('pedidos/tela_pedidos', $data);

        $this->load->view('basico/footer');
    }

    public function pedidos_combinar() {
		
		unset($_SESSION['FiltroPedidos']);

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
			'Campo',
			'Ordenamento',
            'Cliente',
            'idApp_Cliente',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
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
			'selecione',
        ), TRUE));

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
			'S' => 'Aprovado',
            'N' => 'Não Aprovado',
        );

		$data['select']['Quitado'] = array(
			'0' => '::TODOS::',			
			'S' => 'Quitada',
			'N' => 'NÃO Quitada',
        );
		
		$data['select']['ConcluidoProduto'] = array(
			'0' => '::TODOS::',			
			'S' => 'Entregue',
			'N' => 'NÃO Entregue',
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

		$data['select']['Campo'] = array(
            'OT.idApp_OrcaTrata' => 'Orçamento',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['TipoFinanceiroR'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['TipoFinanceiroD'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();		
		
        $data['titulo'] = 'Dinâmico';
        $data['form_open_path'] = 'Pedidos/pedidos_combinar';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['pedidos'] = 'Pedidos';

        $_SESSION['FiltroPedidos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
		$_SESSION['FiltroPedidos']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroPedidos']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroPedidos']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroPedidos']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroPedidos']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroPedidos']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroPedidos']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroPedidos']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroPedidos']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroPedidos']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroPedidos']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroPedidos']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroPedidos']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroPedidos']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroPedidos']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroPedidos']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroPedidos']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroPedidos']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroPedidos']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroPedidos']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroPedidos']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroPedidos']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroPedidos']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroPedidos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroPedidos']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroPedidos']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroPedidos']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroPedidos']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
		$_SESSION['FiltroPedidos']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
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
			//$data['bd']['selecione'] = $data['query']['selecione'];

			//$data['pesquisa_query'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'Pedidos_pag/pedidos_combinar_pag/';
			$config['per_page'] = 5;
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
	
			$data['report_combinar'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_combinar'] = $this->load->view('pedidos/list_pedidos_combinar', $data, TRUE);			

			$data['report_aprovar'] = $this->Pedidos_model->list_pedidos_aprovar($data['bd'],TRUE, TRUE);
            $data['report_producao'] = $this->Pedidos_model->list_pedidos_producao($data['bd'],TRUE, TRUE);
            $data['report_envio'] = $this->Pedidos_model->list_pedidos_envio($data['bd'],TRUE, TRUE);
            $data['report_entrega'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'],TRUE, TRUE);
            $data['report_pagamento'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'],TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Pedidos_model->list_pedidos_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('pedidos/tela_pedidos_combinar', $data);

        $this->load->view('basico/footer');
    }

    public function pedidos_aprovar() {
		
		unset($_SESSION['FiltroPedidos']);

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
			'Campo',
			'Ordenamento',
            'Cliente',
            'idApp_Cliente',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
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
			'selecione',
        ), TRUE));

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
			'S' => 'Aprovado',
            'N' => 'Não Aprovado',
        );

		$data['select']['Quitado'] = array(
			'0' => '::TODOS::',			
			'S' => 'Quitada',
			'N' => 'NÃO Quitada',
        );
		
		$data['select']['ConcluidoProduto'] = array(
			'0' => '::TODOS::',			
			'S' => 'Entregue',
			'N' => 'NÃO Entregue',
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

		$data['select']['Campo'] = array(
            'OT.idApp_OrcaTrata' => 'Orçamento',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );
		
		
		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['TipoFinanceiroR'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['TipoFinanceiroD'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();		
		
        $data['titulo'] = 'Dinâmico';
        $data['form_open_path'] = 'Pedidos/pedidos_aprovar';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['pedidos'] = 'Pedidos';

        $_SESSION['FiltroPedidos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
		$_SESSION['FiltroPedidos']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroPedidos']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroPedidos']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroPedidos']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroPedidos']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroPedidos']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroPedidos']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroPedidos']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroPedidos']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroPedidos']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroPedidos']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroPedidos']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroPedidos']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroPedidos']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroPedidos']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroPedidos']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroPedidos']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroPedidos']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroPedidos']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroPedidos']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroPedidos']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroPedidos']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroPedidos']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroPedidos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroPedidos']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroPedidos']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroPedidos']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroPedidos']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
		$_SESSION['FiltroPedidos']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
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
			//$data['bd']['selecione'] = $data['query']['selecione'];

			//$data['pesquisa_query'] = $this->Pedidos_model->list_pedidos_aprovar($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			
			$config['total_rows'] = $this->Pedidos_model->list_pedidos_aprovar($data['bd'], TRUE, TRUE);
			$config['base_url'] = base_url() . 'Pedidos_pag/pedidos_aprovar_pag/';
			$config['per_page'] = 5;
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
				
			$data['report_aprovar'] = $this->Pedidos_model->list_pedidos_aprovar($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_aprovar'] = $this->load->view('pedidos/list_pedidos_aprovar', $data, TRUE);			

			$data['report_combinar'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'],TRUE, TRUE);
            $data['report_producao'] = $this->Pedidos_model->list_pedidos_producao($data['bd'],TRUE, TRUE);
            $data['report_envio'] = $this->Pedidos_model->list_pedidos_envio($data['bd'],TRUE, TRUE);
            $data['report_entrega'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'],TRUE, TRUE);
            $data['report_pagamento'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'],TRUE, TRUE);
			/*
			$data['report_pagonline'] = $this->Pedidos_model->list_pedidos_pagonline($data['bd'],TRUE);
			*/
        }

        $this->load->view('pedidos/tela_pedidos_aprovar', $data);

        $this->load->view('basico/footer');
    }

    public function pedidos_producao() {
		
		unset($_SESSION['FiltroPedidos']);

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
			'Campo',
			'Ordenamento',
            'Cliente',
            'idApp_Cliente',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
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
			'selecione',
        ), TRUE));

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
			'S' => 'Aprovado',
            'N' => 'Não Aprovado',
        );

		$data['select']['Quitado'] = array(
			'0' => '::TODOS::',			
			'S' => 'Quitada',
			'N' => 'NÃO Quitada',
        );
		
		$data['select']['ConcluidoProduto'] = array(
			'0' => '::TODOS::',			
			'S' => 'Entregue',
			'N' => 'NÃO Entregue',
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

		$data['select']['Campo'] = array(
            'OT.idApp_OrcaTrata' => 'Orçamento',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['TipoFinanceiroR'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['TipoFinanceiroD'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();		
		
        $data['titulo'] = 'Dinâmico';
        $data['form_open_path'] = 'Pedidos/pedidos_producao';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['pedidos'] = 'Pedidos';

        $_SESSION['FiltroPedidos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
		$_SESSION['FiltroPedidos']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroPedidos']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroPedidos']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroPedidos']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroPedidos']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroPedidos']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroPedidos']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroPedidos']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroPedidos']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroPedidos']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroPedidos']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroPedidos']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroPedidos']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroPedidos']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroPedidos']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroPedidos']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroPedidos']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroPedidos']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroPedidos']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroPedidos']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroPedidos']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroPedidos']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroPedidos']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroPedidos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroPedidos']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroPedidos']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroPedidos']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroPedidos']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
		$_SESSION['FiltroPedidos']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
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
			//$data['bd']['selecione'] = $data['query']['selecione'];

			//$data['pesquisa_query'] = $this->Pedidos_model->list_pedidos_producao($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Pedidos_model->list_pedidos_producao($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'Pedidos_pag/pedidos_producao_pag/';
			$config['per_page'] = 5;
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
	
			$data['report_producao'] = $this->Pedidos_model->list_pedidos_producao($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_producao'] = $this->load->view('pedidos/list_pedidos_producao', $data, TRUE);			

			$data['report_aprovar'] = $this->Pedidos_model->list_pedidos_aprovar($data['bd'],TRUE, TRUE);
            $data['report_combinar'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'],TRUE, TRUE);
            $data['report_envio'] = $this->Pedidos_model->list_pedidos_envio($data['bd'],TRUE, TRUE);
            $data['report_entrega'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'],TRUE, TRUE);
            $data['report_pagamento'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'],TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Pedidos_model->list_pedidos_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('pedidos/tela_pedidos_producao', $data);

        $this->load->view('basico/footer');
    }

    public function pedidos_envio() {
		
		unset($_SESSION['FiltroPedidos']);

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
			'Campo',
			'Ordenamento',
            'Cliente',
            'idApp_Cliente',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
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
			'selecione',
        ), TRUE));

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
			'S' => 'Aprovado',
            'N' => 'Não Aprovado',
        );

		$data['select']['Quitado'] = array(
			'0' => '::TODOS::',			
			'S' => 'Quitada',
			'N' => 'NÃO Quitada',
        );
		
		$data['select']['ConcluidoProduto'] = array(
			'0' => '::TODOS::',			
			'S' => 'Entregue',
			'N' => 'NÃO Entregue',
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

		$data['select']['Campo'] = array(
            'OT.idApp_OrcaTrata' => 'Orçamento',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['TipoFinanceiroR'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['TipoFinanceiroD'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();		
		
        $data['titulo'] = 'Dinâmico';
        $data['form_open_path'] = 'Pedidos/pedidos_envio';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['pedidos'] = 'Pedidos';

        $_SESSION['FiltroPedidos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
		$_SESSION['FiltroPedidos']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroPedidos']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroPedidos']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroPedidos']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroPedidos']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroPedidos']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroPedidos']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroPedidos']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroPedidos']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroPedidos']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroPedidos']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroPedidos']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroPedidos']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroPedidos']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroPedidos']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroPedidos']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroPedidos']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroPedidos']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroPedidos']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroPedidos']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroPedidos']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroPedidos']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroPedidos']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroPedidos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroPedidos']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroPedidos']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroPedidos']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroPedidos']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
		$_SESSION['FiltroPedidos']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
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
			//$data['bd']['selecione'] = $data['query']['selecione'];

			//$data['pesquisa_query'] = $this->Pedidos_model->list_pedidos_envio($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Pedidos_model->list_pedidos_envio($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'Pedidos_pag/pedidos_envio_pag/';
			$config['per_page'] = 5;
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
	
			$data['report_envio'] = $this->Pedidos_model->list_pedidos_envio($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_envio'] = $this->load->view('pedidos/list_pedidos_envio', $data, TRUE);			

			$data['report_aprovar'] = $this->Pedidos_model->list_pedidos_aprovar($data['bd'],TRUE, TRUE);
            $data['report_combinar'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'],TRUE, TRUE);
            $data['report_producao'] = $this->Pedidos_model->list_pedidos_producao($data['bd'],TRUE, TRUE);
            $data['report_entrega'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'],TRUE, TRUE);
            $data['report_pagamento'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'],TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Pedidos_model->list_pedidos_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('pedidos/tela_pedidos_envio', $data);

        $this->load->view('basico/footer');
    }

    public function pedidos_entrega() {
		
		unset($_SESSION['FiltroPedidos']);

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
			'Campo',
			'Ordenamento',
            'Cliente',
            'idApp_Cliente',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
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
			'selecione',
        ), TRUE));

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
			'S' => 'Aprovado',
            'N' => 'Não Aprovado',
        );

		$data['select']['Quitado'] = array(
			'0' => '::TODOS::',			
			'S' => 'Quitada',
			'N' => 'NÃO Quitada',
        );
		
		$data['select']['ConcluidoProduto'] = array(
			'0' => '::TODOS::',			
			'S' => 'Entregue',
			'N' => 'NÃO Entregue',
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

		$data['select']['Campo'] = array(
            'OT.idApp_OrcaTrata' => 'Orçamento',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['TipoFinanceiroR'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['TipoFinanceiroD'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();		
		
        $data['titulo'] = 'Dinâmico';
        $data['form_open_path'] = 'Pedidos/pedidos_entrega';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['pedidos'] = 'Pedidos';

        $_SESSION['FiltroPedidos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
		$_SESSION['FiltroPedidos']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroPedidos']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroPedidos']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroPedidos']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroPedidos']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroPedidos']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroPedidos']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroPedidos']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroPedidos']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroPedidos']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroPedidos']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroPedidos']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroPedidos']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroPedidos']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroPedidos']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroPedidos']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroPedidos']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroPedidos']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroPedidos']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroPedidos']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroPedidos']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroPedidos']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroPedidos']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroPedidos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroPedidos']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroPedidos']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroPedidos']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroPedidos']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
		$_SESSION['FiltroPedidos']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
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
			//$data['bd']['selecione'] = $data['query']['selecione'];

			//$data['pesquisa_query'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'Pedidos_pag/pedidos_entrega_pag/';
			$config['per_page'] = 5;
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
	
			$data['report_entrega'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_entrega'] = $this->load->view('pedidos/list_pedidos_entrega', $data, TRUE);			

            $data['report_combinar'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'],TRUE, TRUE);
			$data['report_aprovar'] = $this->Pedidos_model->list_pedidos_aprovar($data['bd'],TRUE, TRUE);
            $data['report_producao'] = $this->Pedidos_model->list_pedidos_producao($data['bd'],TRUE, TRUE);
            $data['report_envio'] = $this->Pedidos_model->list_pedidos_envio($data['bd'],TRUE, TRUE);
            $data['report_pagamento'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'],TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Pedidos_model->list_pedidos_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('pedidos/tela_pedidos_entrega', $data);

        $this->load->view('basico/footer');
    }

    public function pedidos_pagamento() {
		
		unset($_SESSION['FiltroPedidos']);

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
			'Campo',
			'Ordenamento',
            'Cliente',
            'idApp_Cliente',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
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
			'selecione',
        ), TRUE));

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
			'S' => 'Aprovado',
            'N' => 'Não Aprovado',
        );

		$data['select']['Quitado'] = array(
			'0' => '::TODOS::',			
			'S' => 'Quitada',
			'N' => 'NÃO Quitada',
        );
		
		$data['select']['ConcluidoProduto'] = array(
			'0' => '::TODOS::',			
			'S' => 'Entregue',
			'N' => 'NÃO Entregue',
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

		$data['select']['Campo'] = array(
            'OT.idApp_OrcaTrata' => 'Orçamento',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['TipoFinanceiroR'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['TipoFinanceiroD'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();		
		
        $data['titulo'] = 'Dinâmico';
        $data['form_open_path'] = 'Pedidos/pedidos_pagamento';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['pedidos'] = 'Pedidos';

        $_SESSION['FiltroPedidos']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroPedidos']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroPedidos']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
		$_SESSION['FiltroPedidos']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroPedidos']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroPedidos']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroPedidos']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroPedidos']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroPedidos']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroPedidos']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroPedidos']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroPedidos']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroPedidos']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
		$_SESSION['FiltroPedidos']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
		$_SESSION['FiltroPedidos']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
		$_SESSION['FiltroPedidos']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
		$_SESSION['FiltroPedidos']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
		$_SESSION['FiltroPedidos']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
		$_SESSION['FiltroPedidos']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
		$_SESSION['FiltroPedidos']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
		$_SESSION['FiltroPedidos']['FormaPagamento'] = $data['query']['FormaPagamento'];
		$_SESSION['FiltroPedidos']['AVAP'] = $data['query']['AVAP'];
		$_SESSION['FiltroPedidos']['TipoFrete'] = $data['query']['TipoFrete'];
		$_SESSION['FiltroPedidos']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroPedidos']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroPedidos']['Cliente'] = $data['query']['Cliente'];
		$_SESSION['FiltroPedidos']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroPedidos']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroPedidos']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroPedidos']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroPedidos']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
		$_SESSION['FiltroPedidos']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
            $data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
            $data['bd']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
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
			//$data['bd']['selecione'] = $data['query']['selecione'];

			//$data['pesquisa_query'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'Pedidos_pag/pedidos_pagamento_pag/';
			$config['per_page'] = 5;
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
	
			$data['report_pagamento'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_pagamento'] = $this->load->view('pedidos/list_pedidos_pagamento', $data, TRUE);			

            $data['report_combinar'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'],TRUE, TRUE);
			$data['report_aprovar'] = $this->Pedidos_model->list_pedidos_aprovar($data['bd'],TRUE, TRUE);
            $data['report_producao'] = $this->Pedidos_model->list_pedidos_producao($data['bd'],TRUE, TRUE);
            $data['report_envio'] = $this->Pedidos_model->list_pedidos_envio($data['bd'],TRUE, TRUE);
            $data['report_entrega'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'],TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Pedidos_model->list_pedidos_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('pedidos/tela_pedidos_pagamento', $data);

        $this->load->view('basico/footer');
    }

}