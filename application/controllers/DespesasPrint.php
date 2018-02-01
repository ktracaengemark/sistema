<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class DespesasPrint extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Despesas_model', 'DespesasPrint_model', 'Profissional_model', 'Relatorio_model', 'Formapag_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        #$this->load->view('basico/nav_principal');

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

    public function imprimir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($id) {
            #### App_OrcaTrata ####
            $data['despesas'] = $this->DespesasPrint_model->get_despesas($id);
            $data['despesas']['DataDespesas'] = $this->basico->mascara_data($data['despesas']['DataDespesas'], 'barras');
            #$data['despesas']['DataPrazo'] = $this->basico->mascara_data($data['despesas']['DataPrazo'], 'barras');
			$data['despesas']['DataConclusaoDespesas'] = $this->basico->mascara_data($data['despesas']['DataConclusaoDespesas'], 'barras');
            $data['despesas']['DataRetornoDespesas'] = $this->basico->mascara_data($data['despesas']['DataRetornoDespesas'], 'barras');
            $data['despesas']['DataEntradaDespesas'] = $this->basico->mascara_data($data['despesas']['DataEntradaDespesas'], 'barras');
            $data['despesas']['DataVencimentoDespesas'] = $this->basico->mascara_data($data['despesas']['DataVencimentoDespesas'], 'barras');

            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['despesas']['idApp_Cliente'], TRUE);
			$_SESSION['Despesas'] = $this->Despesas_model->get_despesas($data['despesas']['idApp_Despesas'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            /*
            #### App_ServicoVenda ####
            $data['servico'] = $this->DespesasPrint_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++)
                        $data['servico'][$j]['SubtotalServico'] = number_format(($data['servico'][$j]['ValorVendaServico'] * $data['servico'][$j]['QtdVendaServico']), 2, ',', '.');
                }
            }
            */

            #### App_ProdutoVenda ####
            $data['produto'] = $this->DespesasPrint_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorCompraProduto'] * $data['produto'][$j]['QtdCompraProduto']), 2, ',', '.');
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
					}

                }
            }

            #### App_ParcelasRecebiveis ####
            $data['parcelaspag'] = $this->DespesasPrint_model->get_parcelaspag($id);
            if (count($data['parcelaspag']) > 0) {
                $data['parcelaspag'] = array_combine(range(1, count($data['parcelaspag'])), array_values($data['parcelaspag']));

                if (isset($data['parcelaspag'])) {

                    for($j=1; $j <= $data['despesas']['QtdParcelasDespesas']; $j++) {
                        $data['parcelaspag'][$j]['DataVencimentoPagaveis'] = $this->basico->mascara_data($data['parcelaspag'][$j]['DataVencimentoPagaveis'], 'barras');
                        $data['parcelaspag'][$j]['DataPagoPagaveis'] = $this->basico->mascara_data($data['parcelaspag'][$j]['DataPagoPagaveis'], 'barras');
                    }

                }
            }
/*
            #### App_Procedimento ####
            $data['procedimento'] = $this->DespesasPrint_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');


                }
            }
*/
        }

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('despesas/print_despesas', $data);

        $this->load->view('basico/footer');

    }

}
