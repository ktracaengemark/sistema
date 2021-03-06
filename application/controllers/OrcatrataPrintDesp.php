<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class OrcatrataPrintDesp extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Orcatrata_model', 'OrcatrataPrint_model', 'Relatorio_model', 'Formapag_model' , 'Usuario_model' , 'Cliente_model' , 'Fornecedor_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');
        #$this->load->view('basico/nav_impressaodesp');
        #$this->load->view('orcatrata/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('orcatrata/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function imprimir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($id) {
            #### App_OrcaTrata ####
            $data['orcatrata'] = $this->OrcatrataPrint_model->get_orcatrata($id);
            $data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
            $data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'barras');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'barras');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'barras');
			$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'barras');
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'barras');
            $data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'barras');

            #### Carrega os dados do cliente nas vari�ves de sess�o ####
            $this->load->model('Cliente_model');
            
			$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
			$_SESSION['Usuario'] = $this->Usuario_model->get_usuario($data['orcatrata']['idSis_Usuario'], TRUE);
			$_SESSION['Orcatrata'] = $data['query'] = $this->OrcatrataPrint_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata'], TRUE);
			$_SESSION['Imprimir'] = $data['query'] = $this->OrcatrataPrint_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata'], TRUE);
			#$_SESSION['Orcatrata'] = $data['query'] = $this->OrcatrataPrint_model->get_orcatrata($id, TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            
            #### App_ServicoVenda ####
            $data['servico'] = $this->OrcatrataPrint_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++) {
                        $data['servico'][$j]['SubtotalServico'] = number_format(($data['servico'][$j]['ValorServico'] * $data['servico'][$j]['QtdServico']), 2, ',', '.');
						$data['servico'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeServico'], 'barras');
					}
				}
            }
            

            #### App_ProdutoVenda ####
            $data['produto'] = $this->OrcatrataPrint_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						$data['produto'][$j]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['ConcluidoProduto'], 'NS');
						$data['produto'][$j]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['DevolvidoProduto'], 'NS');
					}

                }
            }

            #### App_Parcelas####
            $data['parcelasrec'] = $this->OrcatrataPrint_model->get_parcelasrec($id);
            if (count($data['parcelasrec']) > 0) {
                $data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));

                if (isset($data['parcelasrec'])) {

                    for($j=1; $j <= $data['orcatrata']['QtdParcelasOrca']; $j++) {
                        $data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
                        $data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
                    }

                }
            }

            #### App_Procedimento ####
            $data['procedimento'] = $this->OrcatrataPrint_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');


                }
            }

        }

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('orcatrata/print_orcatrata', $data);

        $this->load->view('basico/footer');

    }

    public function imprimirdesp($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($id) {
            #### App_OrcaTrata ####
            $data['orcatrata'] = $this->OrcatrataPrint_model->get_orcatrata($id);
            $data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
            $data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'barras');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'barras');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'barras');
			$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'barras');
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'barras');
            $data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'barras');

            #### Carrega os dados do cliente nas vari�ves de sess�o ####
            $this->load->model('Fornecedor_model');
            
			#$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
			$_SESSION['Fornecedor'] = $this->Fornecedor_model->get_fornecedor($data['orcatrata']['idApp_Fornecedor'], TRUE);
			$_SESSION['Usuario'] = $this->Usuario_model->get_usuario($data['orcatrata']['idSis_Usuario'], TRUE);
			#$this->load->model('OrcatrataPrint_model');
			$_SESSION['Orcatrata'] = $data['query'] = $this->OrcatrataPrint_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata'], TRUE);
			#$_SESSION['Imprimir'] = $data['query'] = $this->OrcatrataPrint_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata'], TRUE);
			#$_SESSION['Orcatrata'] = $data['query'] = $this->OrcatrataPrint_model->get_orcatrata($id, TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            
            #### App_ServicoVenda ####
            $data['servico'] = $this->OrcatrataPrint_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++) {
                        $data['servico'][$j]['SubtotalServico'] = number_format(($data['servico'][$j]['ValorServico'] * $data['servico'][$j]['QtdServico']), 2, ',', '.');
						$data['servico'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeServico'], 'barras');
					}
				}
            }
            

            #### App_ProdutoVenda ####
            $data['produto'] = $this->OrcatrataPrint_model->get_produto_desp($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						$data['produto'][$j]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['ConcluidoProduto'], 'NS');
						$data['produto'][$j]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['DevolvidoProduto'], 'NS');					
					}

                }
            }

            #### App_Parcelas####
            $data['parcelasrec'] = $this->OrcatrataPrint_model->get_parcelasrec($id);
            if (count($data['parcelasrec']) > 0) {
                $data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
				$data['count']['PRCount'] = count($data['parcelasrec']);
                if (isset($data['parcelasrec'])) {

                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
                        $data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
                        $data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
                    }

                }
            }

            #### App_Procedimento ####
            $data['procedimento'] = $this->OrcatrataPrint_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');


                }
            }

        }

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('orcatrata/print_orcatratadesp', $data);

        $this->load->view('basico/footer');

    }
	
}
