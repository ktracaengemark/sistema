<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Despesas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Servico_model', 'Produto_model', 'Despesas_model', 'Tipodespesa_model', 'Profissional_model', 'Formapag_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('despesas/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('despesas/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['despesas'] = quotes_to_entities($this->input->post(array(
            #### App_Despesas ####
            'idApp_Despesas',
            'Despesa',
            'DataDespesas',
			'TipoDespesa',
			'ProfissionalDespesas',
            'AprovadoDespesas',
			'ServicoConcluidoDespesas',
            'QuitadoDespesas',
            'DataConclusaoDespesas',
            'DataRetornoDespesas',
            'ValorDespesas',
            'ValorEntradaDespesas',
            'DataEntradaDespesas',
            'ValorRestanteDespesas',
            'FormaPagamentoDespesas',
            'QtdParcelasDespesas',
            'DataVencimentoDespesas',
            'ObsDespesas',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');


        //Data de hoje como default
        (!$data['despesas']['DataDespesas']) ? $data['despesas']['DataDespesas'] = date('d/m/Y', time()) : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
                $data['servico'][$j]['ValorCompraServico'] = $this->input->post('ValorCompraServico' . $i);
                $data['servico'][$j]['QtdCompraServico'] = $this->input->post('QtdCompraServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i)) {
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                $data['produto'][$j]['ValorCompraProduto'] = $this->input->post('ValorCompraProduto' . $i);
                $data['produto'][$j]['QtdCompraProduto'] = $this->input->post('QtdCompraProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
                $j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

        

        if ($data['despesas']['QtdParcelasDespesas'] > 0) {

            for ($i = 1; $i <= $data['despesas']['QtdParcelasDespesas']; $i++) {

                $data['parcelaspag'][$i]['ParcelaPagaveis'] = $this->input->post('ParcelaPagaveis' . $i);
                $data['parcelaspag'][$i]['ValorParcelaPagaveis'] = $this->input->post('ValorParcelaPagaveis' . $i);
                $data['parcelaspag'][$i]['DataVencimentoPagaveis'] = $this->input->post('DataVencimentoPagaveis' . $i);
                $data['parcelaspag'][$i]['ValorPagoPagaveis'] = $this->input->post('ValorPagoPagaveis' . $i);
                $data['parcelaspag'][$i]['DataPagoPagaveis'] = $this->input->post('DataPagoPagaveis' . $i);
                $data['parcelaspag'][$i]['QuitadoPagaveis'] = $this->input->post('QuitadoPagaveis' . $i);

            }

        }

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Despesas ####
        $this->form_validation->set_rules('DataDespesas', 'Data da Despesa', 'required|trim|valid_date');
        $this->form_validation->set_rules('Despesa', 'Despesa', 'required|trim');
        $this->form_validation->set_rules('TipoDespesa', 'Tipo de Despesa', 'required|trim');
        $this->form_validation->set_rules('ProfissionalDespesas', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('FormaPagamentoDespesas', 'Forma de Pagamento', 'required|trim');
		$this->form_validation->set_rules('QtdParcelasDespesas', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoDespesas', 'Data do 1ºVenc.', 'required|trim|valid_date');
		$data['select']['TipoDespesa'] = $this->Tipodespesa_model->select_tipodespesa();
        $data['select']['AprovadoDespesas'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamentoDespesas'] = $this->Formapag_model->select_formapag();
		$data['select']['ServicoConcluidoDespesas'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();

		$data['select']['QuitadoDespesas'] = $this->Basico_model->select_status_sn();
        $data['select']['QuitadoPagaveis'] = $this->Basico_model->select_status_sn();
		$data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        $data['select']['Servico'] = $this->Servico_model->select_servico();
        $data['select']['Produto'] = $this->Produto_model->select_produto();

        $data['titulo'] = 'Cadastar Despesas';
        $data['form_open_path'] = 'despesas/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        if ($data['despesas']['ValorDespesas'] || $data['despesas']['ValorEntradaDespesas'] || $data['despesas']['ValorRestanteDespesas'])
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['despesas']['FormaPagamentoDespesas'] || $data['despesas']['QtdParcelasDespesas'] || $data['despesas']['DataVencimentoDespesas'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';

      


        #Ver uma solução melhor para este campo
        (!$data['despesas']['AprovadoDespesas']) ? $data['despesas']['AprovadoDespesas'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoDespesas' => $this->basico->radio_checked($data['despesas']['AprovadoDespesas'], 'Despesa Quitada', 'NS'),
        );

        ($data['despesas']['AprovadoDespesas'] == 'S') ?
            $data['div']['AprovadoDespesas'] = '' : $data['div']['AprovadoDespesas'] = 'style="display: none;"';
			
			
		(!$data['despesas']['QuitadoDespesas']) ? $data['despesas']['QuitadoDespesas'] = 'N' : FALSE;

        $data['radio'] = array(
            'QuitadoDespesas' => $this->basico->radio_checked($data['despesas']['QuitadoDespesas'], 'Despesa Quitada', 'NS'),
        );

        ($data['despesas']['QuitadoDespesas'] == 'S') ?
            $data['div']['QuitadoDespesas'] = '' : $data['div']['QuitadoDespesas'] = 'style="display: none;"';


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
            //if (1 == 1) {
            $this->load->view('despesas/form_despesas', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Despesas ####
            $data['despesas']['DataDespesas'] = $this->basico->mascara_data($data['despesas']['DataDespesas'], 'mysql');
			$data['despesas']['Despesa'] = $data['despesas']['Despesa'];
			$data['despesas']['TipoDespesa'] = $data['despesas']['TipoDespesa'];
			$data['despesas']['DataConclusaoDespesas'] = $this->basico->mascara_data($data['despesas']['DataConclusaoDespesas'], 'mysql');
            $data['despesas']['DataRetornoDespesas'] = $this->basico->mascara_data($data['despesas']['DataRetornoDespesas'], 'mysql');
            $data['despesas']['DataVencimentoDespesas'] = $this->basico->mascara_data($data['despesas']['DataVencimentoDespesas'], 'mysql');
            $data['despesas']['ValorDespesas'] = str_replace(',', '.', str_replace('.', '', $data['despesas']['ValorDespesas']));
            $data['despesas']['ValorEntradaDespesas'] = str_replace(',', '.', str_replace('.', '', $data['despesas']['ValorEntradaDespesas']));
            $data['despesas']['DataEntradaDespesas'] = $this->basico->mascara_data($data['despesas']['DataEntradaDespesas'], 'mysql');
            $data['despesas']['ValorRestanteDespesas'] = str_replace(',', '.', str_replace('.', '', $data['despesas']['ValorRestanteDespesas']));
			

            $data['despesas']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['despesas']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['despesas']['idApp_Despesas'] = $this->Despesas_model->set_despesas($data['despesas']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### App_ServicoCompra ####
            if (isset($data['servico'])) {
                $max = count($data['servico']);
                for($j=1;$j<=$max;$j++) {
                    $data['servico'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['servico'][$j]['idApp_Despesas'] = $data['despesas']['idApp_Despesas'];

                    $data['servico'][$j]['ValorCompraServico'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorCompraServico']));
                    unset($data['servico'][$j]['SubtotalServico']);
                }
                $data['servico']['idApp_ServicoCompra'] = $this->Despesas_model->set_servico_compra($data['servico']);
            }

            #### App_ProdutoCompra ####
            if (isset($data['produto'])) {
                $max = count($data['produto']);
                for($j=1;$j<=$max;$j++) {
                    $data['produto'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['produto'][$j]['idApp_Despesas'] = $data['despesas']['idApp_Despesas'];

                    $data['produto'][$j]['ValorCompraProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorCompraProduto']));
                    unset($data['produto'][$j]['SubtotalProduto']);
                }
                $data['produto']['idApp_ProdutoCompra'] = $this->Despesas_model->set_produto_compra($data['produto']);
            }

            #### App_ParcelasRec ####
            if (isset($data['parcelaspag'])) {
                $max = count($data['parcelaspag']);
                for($j=1;$j<=$max;$j++) {
                    $data['parcelaspag'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['parcelaspag'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['parcelaspag'][$j]['idApp_Despesas'] = $data['despesas']['idApp_Despesas'];
                    $data['parcelaspag'][$j]['ValorParcelaPagaveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelaspag'][$j]['ValorParcelaPagaveis']));
                    $data['parcelaspag'][$j]['DataVencimentoPagaveis'] = $this->basico->mascara_data($data['parcelaspag'][$j]['DataVencimentoPagaveis'], 'mysql');
                    $data['parcelaspag'][$j]['ValorPagoPagaveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelaspag'][$j]['ValorPagoPagaveis']));
                    $data['parcelaspag'][$j]['DataPagoPagaveis'] = $this->basico->mascara_data($data['parcelaspag'][$j]['DataPagoPagaveis'], 'mysql');

                }
                $data['parcelaspag']['idApp_ParcelasPagaveis'] = $this->Despesas_model->set_parcelaspag($data['parcelaspag']);
            }

 

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_Despesas'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('despesas/form_despesas', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Despesas'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Despesas', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'relatorio/despesas/'  . $data['msg']);
				
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['despesas'] = quotes_to_entities($this->input->post(array(
            #### App_Despesas ####
            'idApp_Despesas',
            #Não há a necessidade de atualizar o valor do campo a seguir
            #'idApp_Cliente',
            'DataDespesas',
			'Despesa',
			'TipoDespesa',
			'ProfissionalDespesas',
            'AprovadoDespesas',
            'ServicoConcluidoDespesas',
            'QuitadoDespesas',
            'DataConclusaoDespesas',
            'DataRetornoDespesas',
            'ValorDespesas',
            'ValorEntradaDespesas',
            'DataEntradaDespesas',
            'ValorRestanteDespesas',
            'FormaPagamentoDespesas',
            'QtdParcelasDespesas',
            'DataVencimentoDespesas',
            'ObsDespesas',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');


        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_ServicoCompra'] = $this->input->post('idApp_ServicoCompra' . $i);
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
                $data['servico'][$j]['ValorCompraServico'] = $this->input->post('ValorCompraServico' . $i);
                $data['servico'][$j]['QtdCompraServico'] = $this->input->post('QtdCompraServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i)) {
                $data['produto'][$j]['idApp_ProdutoCompra'] = $this->input->post('idApp_ProdutoCompra' . $i);
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                $data['produto'][$j]['ValorCompraProduto'] = $this->input->post('ValorCompraProduto' . $i);
                $data['produto'][$j]['QtdCompraProduto'] = $this->input->post('QtdCompraProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
                $j++;
            }
        }
        $data['count']['PCount'] = $j - 1;
      

        if ($data['despesas']['QtdParcelasDespesas'] > 0) {

            for ($i = 1; $i <= $data['despesas']['QtdParcelasDespesas']; $i++) {

                $data['parcelaspag'][$i]['idApp_ParcelasPagaveis'] = $this->input->post('idApp_ParcelasPagaveis' . $i);
                $data['parcelaspag'][$i]['ParcelaPagaveis'] = $this->input->post('ParcelaPagaveis' . $i);
                $data['parcelaspag'][$i]['ValorParcelaPagaveis'] = $this->input->post('ValorParcelaPagaveis' . $i);
                $data['parcelaspag'][$i]['DataVencimentoPagaveis'] = $this->input->post('DataVencimentoPagaveis' . $i);
                $data['parcelaspag'][$i]['ValorPagoPagaveis'] = $this->input->post('ValorPagoPagaveis' . $i);
                $data['parcelaspag'][$i]['DataPagoPagaveis'] = $this->input->post('DataPagoPagaveis' . $i);
                $data['parcelaspag'][$i]['QuitadoPagaveis'] = $this->input->post('QuitadoPagaveis' . $i);

            }

        }

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_Despesas ####
            $data['despesas'] = $this->Despesas_model->get_despesas($id);
            $data['despesas']['DataDespesas'] = $this->basico->mascara_data($data['despesas']['DataDespesas'], 'barras');
			$data['despesas']['Despesa'] = $data['despesas']['Despesa'];
			$data['despesas']['TipoDespesa'] = $data['despesas']['TipoDespesa'];			
			$data['despesas']['DataConclusaoDespesas'] = $this->basico->mascara_data($data['despesas']['DataConclusaoDespesas'], 'barras');
            $data['despesas']['DataRetornoDespesas'] = $this->basico->mascara_data($data['despesas']['DataRetornoDespesas'], 'barras');
            $data['despesas']['DataEntradaDespesas'] = $this->basico->mascara_data($data['despesas']['DataEntradaDespesas'], 'barras');
            $data['despesas']['DataVencimentoDespesas'] = $this->basico->mascara_data($data['despesas']['DataVencimentoDespesas'], 'barras');

            #### Carrega os dados do cliente nas variáves de sessão ####
           # $this->load->model('Cliente_model');
           # $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['despesas']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_ServicoCompra ####
            $data['servico'] = $this->Despesas_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++)
                        $data['servico'][$j]['SubtotalServico'] = number_format(($data['servico'][$j]['ValorCompraServico'] * $data['servico'][$j]['QtdCompraServico']), 2, ',', '.');
                }
            }

            #### App_ProdutoCompra ####
            $data['produto'] = $this->Despesas_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++)
                        $data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorCompraProduto'] * $data['produto'][$j]['QtdCompraProduto']), 2, ',', '.');
                }
            }

            #### App_ParcelasPagaveis ####
            $data['parcelaspag'] = $this->Despesas_model->get_parcelaspag($id);
            if (count($data['parcelaspag']) > 0) {
                $data['parcelaspag'] = array_combine(range(1, count($data['parcelaspag'])), array_values($data['parcelaspag']));

                if (isset($data['parcelaspag'])) {

                    for($j=1; $j <= $data['despesas']['QtdParcelasDespesas']; $j++) {
                        $data['parcelaspag'][$j]['DataVencimentoPagaveis'] = $this->basico->mascara_data($data['parcelaspag'][$j]['DataVencimentoPagaveis'], 'barras');
                        $data['parcelaspag'][$j]['DataPagoPagaveis'] = $this->basico->mascara_data($data['parcelaspag'][$j]['DataPagoPagaveis'], 'barras');
                    }

                }
            }
           
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Despesas ####
        $this->form_validation->set_rules('DataDespesas', 'Data da Despesa', 'required|trim|valid_date');
        $this->form_validation->set_rules('Despesa', 'Despesa', 'required|trim');
        $this->form_validation->set_rules('TipoDespesa', 'Tipo de Despesa', 'required|trim');
        $this->form_validation->set_rules('ProfissionalDespesas', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('FormaPagamentoDespesas', 'Forma de Pagamento', 'required|trim');
		$this->form_validation->set_rules('QtdParcelasDespesas', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoDespesas', 'Data do 1ºVenc.', 'required|trim|valid_date');
		
		$data['select']['TipoDespesa'] = $this->Tipodespesa_model->select_tipodespesa();
        $data['select']['AprovadoDespesas'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamentoDespesas'] = $this->Formapag_model->select_formapag();
        $data['select']['ServicoConcluidoDespesas'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['QuitadoDespesas'] = $this->Basico_model->select_status_sn();
        $data['select']['QuitadoPagaveis'] = $this->Basico_model->select_status_sn();
		$data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        $data['select']['Servico'] = $this->Servico_model->select_servico();
        $data['select']['Produto'] = $this->Produto_model->select_produto();

        $data['titulo'] = 'Editar Despesas';
        $data['form_open_path'] = 'despesas/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if ($data['despesas']['ValorDespesas'] || $data['despesas']['ValorEntradaDespesas'] || $data['despesas']['ValorRestanteDespesas'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['despesas']['FormaPagamentoDespesas'] || $data['despesas']['QtdParcelasDespesas'] || $data['despesas']['DataVencimentoDespesas'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';



        #Ver uma solução melhor para este campo
        (!$data['despesas']['AprovadoDespesas']) ? $data['despesas']['AprovadoDespesas'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoDespesas' => $this->basico->radio_checked($data['despesas']['AprovadoDespesas'], 'Despesa Quitada', 'NS'),
        );

        ($data['despesas']['AprovadoDespesas'] == 'S') ?
            $data['div']['AprovadoDespesas'] = '' : $data['div']['AprovadoDespesas'] = 'style="display: none;"';
			
			
		 (!$data['despesas']['QuitadoDespesas']) ? $data['despesas']['QuitadoDespesas'] = 'N' : FALSE;

        $data['radio'] = array(
            'QuitadoDespesas' => $this->basico->radio_checked($data['despesas']['QuitadoDespesas'], 'Despesa Quitada', 'NS'),
        );

        ($data['despesas']['QuitadoDespesas'] == 'S') ?
            $data['div']['QuitadoDespesas'] = '' : $data['div']['QuitadoDespesas'] = 'style="display: none;"';


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
            $this->load->view('despesas/form_despesas', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Despesas ####
            $data['despesas']['DataDespesas'] = $this->basico->mascara_data($data['despesas']['DataDespesas'], 'mysql');
			$data['despesas']['Despesa'] = $data['despesas']['Despesa'];
			$data['despesas']['TipoDespesa'] = $data['despesas']['TipoDespesa'];			
			$data['despesas']['DataConclusaoDespesas'] = $this->basico->mascara_data($data['despesas']['DataConclusaoDespesas'], 'mysql');
            $data['despesas']['DataRetornoDespesas'] = $this->basico->mascara_data($data['despesas']['DataRetornoDespesas'], 'mysql');
            $data['despesas']['DataVencimentoDespesas'] = $this->basico->mascara_data($data['despesas']['DataVencimentoDespesas'], 'mysql');
            $data['despesas']['ValorDespesas'] = str_replace(',', '.', str_replace('.', '', $data['despesas']['ValorDespesas']));
            $data['despesas']['ValorEntradaDespesas'] = str_replace(',', '.', str_replace('.', '', $data['despesas']['ValorEntradaDespesas']));
            $data['despesas']['DataEntradaDespesas'] = $this->basico->mascara_data($data['despesas']['DataEntradaDespesas'], 'mysql');
            $data['despesas']['ValorRestanteDespesas'] = str_replace(',', '.', str_replace('.', '', $data['despesas']['ValorRestanteDespesas']));

            $data['despesas']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['despesas']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['despesas']['anterior'] = $this->Despesas_model->get_despesas($data['despesas']['idApp_Despesas']);
            $data['update']['despesas']['campos'] = array_keys($data['despesas']);
            $data['update']['despesas']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['despesas']['anterior'],
                $data['despesas'],
                $data['update']['despesas']['campos'],
                $data['despesas']['idApp_Despesas'], TRUE);
            $data['update']['despesas']['bd'] = $this->Despesas_model->update_despesas($data['despesas'], $data['despesas']['idApp_Despesas']);

            #### App_ServicoCompra ####
            $data['update']['servico']['anterior'] = $this->Despesas_model->get_servico($data['despesas']['idApp_Despesas']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_ServicoCompra');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {

                    $data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['servico']['inserir'][$j]['idApp_Despesas'] = $data['despesas']['idApp_Despesas'];

                    $data['update']['servico']['inserir'][$j]['ValorCompraServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorCompraServico']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalServico']);
                }

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['ValorCompraServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorCompraServico']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalServico']);
                }

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Despesas_model->set_servico_compra($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] = $this->Despesas_model->update_servico_compra($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Despesas_model->delete_servico_compra($data['update']['servico']['excluir']);
            }

            #### App_ProdutoCompra ####
            $data['update']['produto']['anterior'] = $this->Despesas_model->get_produto($data['despesas']['idApp_Despesas']);
            if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

                if (isset($data['produto']))
                    $data['produto'] = array_values($data['produto']);
                else
                    $data['produto'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_ProdutoCompra');

                $max = count($data['update']['produto']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['produto']['inserir'][$j]['idApp_Despesas'] = $data['despesas']['idApp_Despesas'];

                    $data['update']['produto']['inserir'][$j]['ValorCompraProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorCompraProduto']));
                    unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
                }

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['alterar'][$j]['ValorCompraProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorCompraProduto']));
                    unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
                }

                if (count($data['update']['produto']['inserir']))
                    $data['update']['produto']['bd']['inserir'] = $this->Despesas_model->set_produto_compra($data['update']['produto']['inserir']);

                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Despesas_model->update_produto_compra($data['update']['produto']['alterar']);

                if (count($data['update']['produto']['excluir']))
                    $data['update']['produto']['bd']['excluir'] = $this->Despesas_model->delete_produto_compra($data['update']['produto']['excluir']);

            }

            #### App_ParcelasRec ####
            $data['update']['parcelaspag']['anterior'] = $this->Despesas_model->get_parcelaspag($data['despesas']['idApp_Despesas']);
            if (isset($data['parcelaspag']) || (!isset($data['parcelaspag']) && isset($data['update']['parcelaspag']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['parcelaspag'] = array_values($data['parcelaspag']);
                else
                    $data['parcelaspag'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['parcelaspag'] = $this->basico->tratamento_array_multidimensional($data['parcelaspag'], $data['update']['parcelaspag']['anterior'], 'idApp_ParcelasPagaveis');

                $max = count($data['update']['parcelaspag']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelaspag']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['update']['parcelaspag']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelaspag']['inserir'][$j]['idApp_Despesas'] = $data['despesas']['idApp_Despesas'];
                    $data['update']['parcelaspag']['inserir'][$j]['ValorParcelaPagaveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelaspag']['inserir'][$j]['ValorParcelaPagaveis']));
                    $data['update']['parcelaspag']['inserir'][$j]['DataVencimentoPagaveis'] = $this->basico->mascara_data($data['update']['parcelaspag']['inserir'][$j]['DataVencimentoPagaveis'], 'mysql');
                    $data['update']['parcelaspag']['inserir'][$j]['ValorPagoPagaveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelaspag']['inserir'][$j]['ValorPagoPagaveis']));
                    $data['update']['parcelaspag']['inserir'][$j]['DataPagoPagaveis'] = $this->basico->mascara_data($data['update']['parcelaspag']['inserir'][$j]['DataPagoPagaveis'], 'mysql');

                }

                $max = count($data['update']['parcelaspag']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelaspag']['alterar'][$j]['ValorParcelaPagaveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelaspag']['alterar'][$j]['ValorParcelaPagaveis']));
                    $data['update']['parcelaspag']['alterar'][$j]['DataVencimentoPagaveis'] = $this->basico->mascara_data($data['update']['parcelaspag']['alterar'][$j]['DataVencimentoPagaveis'], 'mysql');
                    $data['update']['parcelaspag']['alterar'][$j]['ValorPagoPagaveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelaspag']['alterar'][$j]['ValorPagoPagaveis']));
                    $data['update']['parcelaspag']['alterar'][$j]['DataPagoPagaveis'] = $this->basico->mascara_data($data['update']['parcelaspag']['alterar'][$j]['DataPagoPagaveis'], 'mysql');
                }

                if (count($data['update']['parcelaspag']['inserir']))
                    $data['update']['parcelaspag']['bd']['inserir'] = $this->Despesas_model->set_parcelaspag($data['update']['parcelaspag']['inserir']);

                if (count($data['update']['parcelaspag']['alterar']))
                    $data['update']['parcelaspag']['bd']['alterar'] =  $this->Despesas_model->update_parcelaspag($data['update']['parcelaspag']['alterar']);

                if (count($data['update']['parcelaspag']['excluir']))
                    $data['update']['parcelaspag']['bd']['excluir'] = $this->Despesas_model->delete_parcelaspag($data['update']['parcelaspag']['excluir']);

            }
           

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_Despesas'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['despesas']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('despesas/form_despesas', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Despesas'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Despesas', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'relatorio/despesas/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

                $this->Despesas_model->delete_despesas($id);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'relatorio/despesas/' . $data['msg']);
                exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

    public function listar($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Despesas'] = $this->Despesas_model->get_cliente($id, TRUE);
        //$_SESSION['Despesas']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Despesas_model->list_despesas($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Despesas_model->list_despesas($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('despesas/list_despesas', $data, TRUE);
        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('despesas/tela_despesas', $data);

        $this->load->view('basico/footer');
    }

    public function listarBKP($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Despesas'] = $this->Despesas_model->get_cliente($id, TRUE);
        $_SESSION['Despesas']['idApp_Cliente'] = $id;
        $data['query'] = $this->Despesas_model->list_despesas(TRUE, TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('despesas/list_despesas', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('despesas/tela_despesas', $data);

        $this->load->view('basico/footer');
    }

}
