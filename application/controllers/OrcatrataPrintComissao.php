<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OrcatrataPrintComissao extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Orcatrata_model', 'Orcatrataprintcomissao_model', 'Relatorio_model', 'Formapag_model' , 'Usuario_model' , 'Cliente_model' , 'Fornecedor_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');
        #$this->load->view('orcatrata/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		
		
		$data['somatotal'] = 0;
        if ($id) {
            #### App_OrcaTrata ####
            $data['orcatrata'] = $this->Orcatrataprintcomissao_model->get_orcatrata($id);
            if (count($data['orcatrata']) > 0) {
                $data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
                $data['count']['POCount'] = count($data['orcatrata']);           

				if (isset($data['orcatrata'])) {

                    for($j=1;$j<=$data['count']['POCount'];$j++) {
						
						$data['somatotal'] += $data['orcatrata'][$j]['ValorComissao'];
						
						$data['orcatrata'][$j]['idApp_OrcaTrata'] = $data['orcatrata'][$j]['idApp_OrcaTrata'];
						$data['orcatrata'][$j]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataOrca'], 'barras');
						$data['orcatrata'][$j]['DataPrazo'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataPrazo'], 'barras');
						$data['orcatrata'][$j]['DataConclusao'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataConclusao'], 'barras');
						$data['orcatrata'][$j]['DataRetorno'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataRetorno'], 'barras');
						$data['orcatrata'][$j]['DataQuitado'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataQuitado'], 'barras');
						$data['orcatrata'][$j]['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntradaOrca'], 'barras');
						$data['orcatrata'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataVencimentoOrca'], 'barras');
						$data['orcatrata'][$j]['ValorTotalOrca'] = number_format(($data['orcatrata'][$j]['ValorTotalOrca']), 2, ',', '.');
						$data['orcatrata'][$j]['ValorRestanteOrca'] = number_format(($data['orcatrata'][$j]['ValorRestanteOrca']), 2, ',', '.');
						$data['orcatrata'][$j]['ValorComissao'] = number_format(($data['orcatrata'][$j]['ValorComissao']), 2, ',', '.');
						
						if($data['orcatrata'][$j]['Tipo_Orca'] == "O"){
							$data['orcatrata'][$j]['Tipo_Orca'] = "On Line";
						}elseif($data['orcatrata'][$j]['Tipo_Orca'] == "B"){
							$data['orcatrata'][$j]['Tipo_Orca'] = "Na Loja";
						}else{
							$data['orcatrata'][$j]['Tipo_Orca'] = "Outros";
						}
						
					}
				}	
			}
			$data['somatotal'] = number_format($data['somatotal'],2,",",".");
			  /*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['somatotal']);
			  echo "</pre>";
			  exit ();
			 */

            #### App_ProdutoVenda ####
            $data['produto'] = $this->Orcatrataprintcomissao_model->get_produto($id);
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
            $data['parcelasrec'] = $this->Orcatrataprintcomissao_model->get_parcelasrec($id);
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
            $data['procedimento'] = $this->Orcatrataprintcomissao_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++){
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');						
					}
                }
            }

        }

        $data['titulo'] = 'Baixa da Comissao NaLoja';
        $data['form_open_path'] = 'orcatrata/baixadacomissao/';
		$data['comissao'] = 'relatorio/comissao/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nome'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;		
        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('orcatrata/print_orcatratacomissao', $data);

        $this->load->view('basico/footer');

    }

    public function imprimir_online($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		
		
		$data['somatotal'] = 0;
        if ($id) {
            #### App_OrcaTrata ####
            $data['orcatrata'] = $this->Orcatrataprintcomissao_model->get_orcatrata($id);
            if (count($data['orcatrata']) > 0) {
                $data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
                $data['count']['POCount'] = count($data['orcatrata']);           

				if (isset($data['orcatrata'])) {

                    for($j=1;$j<=$data['count']['POCount'];$j++) {
						
						$data['somatotal'] += $data['orcatrata'][$j]['ValorComissao'];
						
						$data['orcatrata'][$j]['idApp_OrcaTrata'] = $data['orcatrata'][$j]['idApp_OrcaTrata'];
						$data['orcatrata'][$j]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataOrca'], 'barras');
						$data['orcatrata'][$j]['DataPrazo'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataPrazo'], 'barras');
						$data['orcatrata'][$j]['DataConclusao'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataConclusao'], 'barras');
						$data['orcatrata'][$j]['DataRetorno'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataRetorno'], 'barras');
						$data['orcatrata'][$j]['DataQuitado'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataQuitado'], 'barras');
						$data['orcatrata'][$j]['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntradaOrca'], 'barras');
						$data['orcatrata'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataVencimentoOrca'], 'barras');
						$data['orcatrata'][$j]['ValorTotalOrca'] = number_format(($data['orcatrata'][$j]['ValorTotalOrca']), 2, ',', '.');
						$data['orcatrata'][$j]['ValorRestanteOrca'] = number_format(($data['orcatrata'][$j]['ValorRestanteOrca']), 2, ',', '.');
						$data['orcatrata'][$j]['ValorComissao'] = number_format(($data['orcatrata'][$j]['ValorComissao']), 2, ',', '.');
						
						if($data['orcatrata'][$j]['Tipo_Orca'] == "O"){
							$data['orcatrata'][$j]['Tipo_Orca'] = "On Line";
						}elseif($data['orcatrata'][$j]['Tipo_Orca'] == "B"){
							$data['orcatrata'][$j]['Tipo_Orca'] = "Na Loja";
						}else{
							$data['orcatrata'][$j]['Tipo_Orca'] = "Outros";
						}
						
					}
				}	
			}
			$data['somatotal'] = number_format($data['somatotal'],2,",",".");
			  /*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['somatotal']);
			  echo "</pre>";
			  exit ();
			 */

            #### App_ProdutoVenda ####
            $data['produto'] = $this->Orcatrataprintcomissao_model->get_produto($id);
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
            $data['parcelasrec'] = $this->Orcatrataprintcomissao_model->get_parcelasrec($id);
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
            $data['procedimento'] = $this->Orcatrataprintcomissao_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++){
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');						
					}
                }
            }

        }

        $data['titulo'] = 'Baixa da Comissao OnLine';
        $data['form_open_path'] = 'orcatrata/baixadacomissao_online/';
		$data['comissao'] = 'relatorio/comissao_online/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir_online/';
        $data['nome'] = 'NomeAssociado';
        $data['status'] = 'StatusComissaoOrca_Online';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 2;		
        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('orcatrata/print_orcatratacomissao', $data);

        $this->load->view('basico/footer');

    }

}
