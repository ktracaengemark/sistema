<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Despesas_statico extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array('Basico_model', 'Fornecedor_model', 'Despesas_model', 'Relatorio_model', 'Empresa_model', 'Loginempresa_model'));
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

    public function despesas() {
		
		unset($_SESSION['FiltroDespesas']);

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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
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
			'HoraInicio5',
            'HoraFim5',
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
		
        $data['titulo'] = 'Estático';
        $data['form_open_path'] = 'Despesas_statico/despesas';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterardesp/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['paginacao'] = 'N';
        $data['despesas'] = 'Despesas_statico';

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
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
			$data['bd']['HoraInicio5'] = $this->basico->mascara_data($data['query']['HoraInicio5'], 'mysql');
            $data['bd']['HoraFim5'] = $this->basico->mascara_data($data['query']['HoraFim5'], 'mysql');
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
				
				$data['pesquisar'] = $this->Despesas_model->list_despesas_pesquisar($data['bd'],TRUE);
				
				if ($data['pesquisar']->num_rows() == 1) {
					
					$info = $data['pesquisar']->result_array();
					
					redirect('orcatrata/alterardesp/' . $info[0]['idApp_OrcaTrata'] );

					exit();
				}else{	
				
					$data['report_combinar'] = $this->Despesas_model->list_despesas_combinar($data['bd'],TRUE, TRUE);
					$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar($data['bd'],TRUE, TRUE);
					$data['report_producao'] = $this->Despesas_model->list_despesas_producao($data['bd'],TRUE, TRUE);
					$data['report_envio'] = $this->Despesas_model->list_despesas_envio($data['bd'],TRUE, TRUE);
					$data['report_entrega'] = $this->Despesas_model->list_despesas_entrega($data['bd'],TRUE, TRUE);
					$data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento($data['bd'],TRUE, TRUE);
				}
			}else{
				
				$data['report_combinar'] = $this->Despesas_model->list_despesas_combinar($data['bd'],TRUE, TRUE);
				$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar($data['bd'],TRUE, TRUE);
				$data['report_producao'] = $this->Despesas_model->list_despesas_producao($data['bd'],TRUE, TRUE);
				$data['report_envio'] = $this->Despesas_model->list_despesas_envio($data['bd'],TRUE, TRUE);
				$data['report_entrega'] = $this->Despesas_model->list_despesas_entrega($data['bd'],TRUE, TRUE);
				$data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento($data['bd'],TRUE, TRUE);
			}
            /*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_combinar() {
		
		unset($_SESSION['FiltroDespesas']);

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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
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
			'HoraInicio5',
            'HoraFim5',
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
		
        $data['titulo'] = 'Estático';
        $data['form_open_path'] = 'Despesas_statico/despesas_combinar';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterardesp/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['despesas'] = 'Despesas_statico';

        $_SESSION['FiltroDespesas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroDespesas']['HoraInicio5'] = $data['query']['HoraInicio5'];
		$_SESSION['FiltroDespesas']['HoraFim5'] = $data['query']['HoraFim5'];
		$_SESSION['FiltroDespesas']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroDespesas']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroDespesas']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroDespesas']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroDespesas']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroDespesas']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroDespesas']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroDespesas']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroDespesas']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroDespesas']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
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
		$_SESSION['FiltroDespesas']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroDespesas']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroDespesas']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroDespesas']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroDespesas']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroDespesas']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroDespesas']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroDespesas']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
		$_SESSION['FiltroDespesas']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
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
			$data['bd']['HoraInicio5'] = $this->basico->mascara_data($data['query']['HoraInicio5'], 'mysql');
            $data['bd']['HoraFim5'] = $this->basico->mascara_data($data['query']['HoraFim5'], 'mysql');
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

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_combinar($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Despesas_model->list_despesas_combinar($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_combinar_pag/';
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
	
			$data['report_combinar'] = $this->Despesas_model->list_despesas_combinar($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_combinar'] = $this->load->view('despesas/list_despesas_combinar', $data, TRUE);			

			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar($data['bd'],TRUE, TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao($data['bd'],TRUE, TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio($data['bd'],TRUE, TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega($data['bd'],TRUE, TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento($data['bd'],TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas_combinar', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_aprovar() {
		
		unset($_SESSION['FiltroDespesas']);

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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
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
			'HoraInicio5',
            'HoraFim5',
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
		
        $data['titulo'] = 'Estático';
        $data['form_open_path'] = 'Despesas_statico/despesas_aprovar';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterardesp/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['despesas'] = 'Despesas_statico';

        $_SESSION['FiltroDespesas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroDespesas']['HoraInicio5'] = $data['query']['HoraInicio5'];
		$_SESSION['FiltroDespesas']['HoraFim5'] = $data['query']['HoraFim5'];
		$_SESSION['FiltroDespesas']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroDespesas']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroDespesas']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroDespesas']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroDespesas']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroDespesas']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroDespesas']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroDespesas']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroDespesas']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroDespesas']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
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
		$_SESSION['FiltroDespesas']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroDespesas']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroDespesas']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroDespesas']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroDespesas']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroDespesas']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroDespesas']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroDespesas']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
		$_SESSION['FiltroDespesas']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
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
			$data['bd']['HoraInicio5'] = $this->basico->mascara_data($data['query']['HoraInicio5'], 'mysql');
            $data['bd']['HoraFim5'] = $this->basico->mascara_data($data['query']['HoraFim5'], 'mysql');
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

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_aprovar($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			
			$config['total_rows'] = $this->Despesas_model->list_despesas_aprovar($data['bd'], TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_aprovar_pag/';
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
				
			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_aprovar'] = $this->load->view('despesas/list_despesas_aprovar', $data, TRUE);			

			$data['report_combinar'] = $this->Despesas_model->list_despesas_combinar($data['bd'],TRUE, TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao($data['bd'],TRUE, TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio($data['bd'],TRUE, TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega($data['bd'],TRUE, TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento($data['bd'],TRUE, TRUE);
			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline($data['bd'],TRUE);
			*/
        }

        $this->load->view('despesas/tela_despesas_aprovar', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_producao() {
		
		unset($_SESSION['FiltroDespesas']);

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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
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
			'HoraInicio5',
            'HoraFim5',
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
		
        $data['titulo'] = 'Estático';
        $data['form_open_path'] = 'Despesas_statico/despesas_producao';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterardesp/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['despesas'] = 'Despesas_statico';

        $_SESSION['FiltroDespesas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroDespesas']['HoraInicio5'] = $data['query']['HoraInicio5'];
		$_SESSION['FiltroDespesas']['HoraFim5'] = $data['query']['HoraFim5'];
		$_SESSION['FiltroDespesas']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroDespesas']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroDespesas']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroDespesas']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroDespesas']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroDespesas']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroDespesas']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroDespesas']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroDespesas']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroDespesas']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
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
		$_SESSION['FiltroDespesas']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroDespesas']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroDespesas']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroDespesas']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroDespesas']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroDespesas']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroDespesas']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroDespesas']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
		$_SESSION['FiltroDespesas']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
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
			$data['bd']['HoraInicio5'] = $this->basico->mascara_data($data['query']['HoraInicio5'], 'mysql');
            $data['bd']['HoraFim5'] = $this->basico->mascara_data($data['query']['HoraFim5'], 'mysql');
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

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_producao($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Despesas_model->list_despesas_producao($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_producao_pag/';
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
	
			$data['report_producao'] = $this->Despesas_model->list_despesas_producao($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_producao'] = $this->load->view('despesas/list_despesas_producao', $data, TRUE);			

			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar($data['bd'],TRUE, TRUE);
            $data['report_combinar'] = $this->Despesas_model->list_despesas_combinar($data['bd'],TRUE, TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio($data['bd'],TRUE, TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega($data['bd'],TRUE, TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento($data['bd'],TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas_producao', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_envio() {
		
		unset($_SESSION['FiltroDespesas']);

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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
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
			'HoraInicio5',
            'HoraFim5',
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
		
        $data['titulo'] = 'Estático';
        $data['form_open_path'] = 'Despesas_statico/despesas_envio';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterardesp/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['despesas'] = 'Despesas_statico';

        $_SESSION['FiltroDespesas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroDespesas']['HoraInicio5'] = $data['query']['HoraInicio5'];
		$_SESSION['FiltroDespesas']['HoraFim5'] = $data['query']['HoraFim5'];
		$_SESSION['FiltroDespesas']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroDespesas']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroDespesas']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroDespesas']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroDespesas']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroDespesas']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroDespesas']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroDespesas']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroDespesas']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroDespesas']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
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
		$_SESSION['FiltroDespesas']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroDespesas']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroDespesas']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroDespesas']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroDespesas']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroDespesas']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroDespesas']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroDespesas']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
		$_SESSION['FiltroDespesas']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
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
			$data['bd']['HoraInicio5'] = $this->basico->mascara_data($data['query']['HoraInicio5'], 'mysql');
            $data['bd']['HoraFim5'] = $this->basico->mascara_data($data['query']['HoraFim5'], 'mysql');
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

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_envio($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Despesas_model->list_despesas_envio($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_envio_pag/';
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
	
			$data['report_envio'] = $this->Despesas_model->list_despesas_envio($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_envio'] = $this->load->view('despesas/list_despesas_envio', $data, TRUE);			

			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar($data['bd'],TRUE, TRUE);
            $data['report_combinar'] = $this->Despesas_model->list_despesas_combinar($data['bd'],TRUE, TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao($data['bd'],TRUE, TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega($data['bd'],TRUE, TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento($data['bd'],TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas_envio', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_entrega() {
		
		unset($_SESSION['FiltroDespesas']);

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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
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
			'HoraInicio5',
            'HoraFim5',
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
		
        $data['titulo'] = 'Estático';
        $data['form_open_path'] = 'Despesas_statico/despesas_entrega';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterardesp/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['despesas'] = 'Despesas_statico';

        $_SESSION['FiltroDespesas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroDespesas']['HoraInicio5'] = $data['query']['HoraInicio5'];
		$_SESSION['FiltroDespesas']['HoraFim5'] = $data['query']['HoraFim5'];
		$_SESSION['FiltroDespesas']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroDespesas']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroDespesas']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroDespesas']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroDespesas']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroDespesas']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroDespesas']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroDespesas']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroDespesas']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroDespesas']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
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
		$_SESSION['FiltroDespesas']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroDespesas']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroDespesas']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroDespesas']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroDespesas']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroDespesas']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroDespesas']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroDespesas']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
		$_SESSION['FiltroDespesas']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
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
			$data['bd']['HoraInicio5'] = $this->basico->mascara_data($data['query']['HoraInicio5'], 'mysql');
            $data['bd']['HoraFim5'] = $this->basico->mascara_data($data['query']['HoraFim5'], 'mysql');
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

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_entrega($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Despesas_model->list_despesas_entrega($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_entrega_pag/';
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
	
			$data['report_entrega'] = $this->Despesas_model->list_despesas_entrega($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_entrega'] = $this->load->view('despesas/list_despesas_entrega', $data, TRUE);			

            $data['report_combinar'] = $this->Despesas_model->list_despesas_combinar($data['bd'],TRUE, TRUE);
			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar($data['bd'],TRUE, TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao($data['bd'],TRUE, TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio($data['bd'],TRUE, TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento($data['bd'],TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas_entrega', $data);

        $this->load->view('basico/footer');
    }

    public function despesas_pagamento() {
		
		unset($_SESSION['FiltroDespesas']);

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
			'Campo',
			'Ordenamento',
            'Fornecedor',
            'idApp_Fornecedor',
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
			'HoraInicio5',
            'HoraFim5',
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
		
        $data['titulo'] = 'Estático';
        $data['form_open_path'] = 'Despesas_statico/despesas_pagamento';
		$data['comissao'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterardesp/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;	
		$data['paginacao'] = 'N';
        $data['despesas'] = 'Despesas_statico';

        $_SESSION['FiltroDespesas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
        $_SESSION['FiltroDespesas']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
		$_SESSION['FiltroDespesas']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
        $_SESSION['FiltroDespesas']['HoraInicio5'] = $data['query']['HoraInicio5'];
		$_SESSION['FiltroDespesas']['HoraFim5'] = $data['query']['HoraFim5'];
		$_SESSION['FiltroDespesas']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroDespesas']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroDespesas']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
		$_SESSION['FiltroDespesas']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroDespesas']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroDespesas']['Mespag'] = $data['query']['Mespag'];
        $_SESSION['FiltroDespesas']['ObsOrca'] = $data['query']['ObsOrca'];
        $_SESSION['FiltroDespesas']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroDespesas']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroDespesas']['ConcluidoProduto'] = $data['query']['ConcluidoProduto'];
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
		$_SESSION['FiltroDespesas']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
		$_SESSION['FiltroDespesas']['Orcamento'] = $data['query']['Orcamento'];
		$_SESSION['FiltroDespesas']['Fornecedor'] = $data['query']['Fornecedor'];
		$_SESSION['FiltroDespesas']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
		$_SESSION['FiltroDespesas']['Modalidade'] = $data['query']['Modalidade'];
		$_SESSION['FiltroDespesas']['Campo'] = $data['query']['Campo'];
		$_SESSION['FiltroDespesas']['Ordenamento'] = $data['query']['Ordenamento'];
		$_SESSION['FiltroDespesas']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
		$_SESSION['FiltroDespesas']['metodo'] = $data['metodo'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
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
			$data['bd']['HoraInicio5'] = $this->basico->mascara_data($data['query']['HoraInicio5'], 'mysql');
            $data['bd']['HoraFim5'] = $this->basico->mascara_data($data['query']['HoraFim5'], 'mysql');
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

			//$data['pesquisa_query'] = $this->Despesas_model->list_despesas_pagamento($data['bd'],TRUE, TRUE);
			//$config['total_rows'] = $data['pesquisa_query']->num_rows();
			$config['total_rows'] = $this->Despesas_model->list_despesas_pagamento($data['bd'],TRUE, TRUE);
			$config['base_url'] = base_url() . 'Despesas_statico_pag/despesas_pagamento_pag/';
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
	
			$data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));		
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list_pagamento'] = $this->load->view('despesas/list_despesas_pagamento', $data, TRUE);			

            $data['report_combinar'] = $this->Despesas_model->list_despesas_combinar($data['bd'],TRUE, TRUE);
			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar($data['bd'],TRUE, TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao($data['bd'],TRUE, TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio($data['bd'],TRUE, TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega($data['bd'],TRUE, TRUE);

			/*
			$data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline($data['bd'],TRUE);
			*/

        }

        $this->load->view('despesas/tela_despesas_pagamento', $data);

        $this->load->view('basico/footer');
    }

}