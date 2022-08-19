<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class OrcatrataPrint extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array( 	'Basico_model', 'Orcatrata_model', 'Orcatrataprint_model',
									'Relatorio_model', 'Formapag_model' , 'Usuario_model' , 
									'Cliente_model' , 'Clientepet_model', 'Clientedep_model', 
									'Fornecedor_model', 'Associado_model', 'Campanha_model'
								));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');
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

		if (!$id) {

			unset($_SESSION['Orcatrata']);
			unset($_SESSION['Cliente']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {

				#### App_OrcaTrata ####
				$_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrataprint_model->get_orcatrata($id);
			
				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 2){
					
					unset($_SESSION['Orcatrata']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {			
									
					$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
					$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'barras');
					$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'barras');
					$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'barras');
					$data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'barras');
					$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'barras');
					$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'barras');
					$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'barras');
					
					#### Carrega os dados da Campanha nas variáves de sessão ####
					
					if(isset($data['orcatrata']['Cupom']) && $data['orcatrata']['Cupom'] != 0 && $data['orcatrata']['UsarCupom'] == "S"){
						$data['Campanha'] = $this->Campanha_model->get_campanha_cupom($data['orcatrata']['Cupom']);				
					}	

					#### Carrega os dados do cliente nas variáves de sessão ####
					
					if($data['orcatrata']['idApp_Cliente'] != 0 && $data['orcatrata']['idApp_Cliente'] != 1){
						
						$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
							
						if($data['cliente'] === FALSE){
							
							unset($_SESSION['Orcatrata']);
							unset($_SESSION['Cliente']);
							$data['msg'] = '?m=3';
							redirect(base_url() . 'acesso' . $data['msg']);
							exit();
							
						} else {
						
							$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
				
							if(!empty($data['orcatrata']['idApp_ClientePet']) && $data['orcatrata']['idApp_ClientePet'] != 0){
								//$this->load->model('Clientepet_model');
								$_SESSION['ClientePet'] = $data['clientepet'] = $this->Clientepet_model->get_clientepet($data['orcatrata']['idApp_ClientePet'], TRUE);
								$_SESSION['ClientePet']['NomeClientePet'] = (strlen($data['clientepet']['NomeClientePet']) > 20) ? substr($data['clientepet']['NomeClientePet'], 0, 20) : $data['clientepet']['NomeClientePet'];
							}

							if(!empty($data['orcatrata']['idApp_ClienteDep']) && $data['orcatrata']['idApp_ClienteDep'] != 0){
								//$this->load->model('Clientedep_model');
								$_SESSION['ClienteDep'] = $data['clientedep'] = $this->Clientedep_model->get_clientedep($data['orcatrata']['idApp_ClienteDep'], TRUE);
								$_SESSION['ClienteDep']['NomeClienteDep'] = (strlen($data['clientedep']['NomeClienteDep']) > 20) ? substr($data['clientedep']['NomeClienteDep'], 0, 20) : $data['clientedep']['NomeClienteDep'];
							}

							#### Carrega os dados do Pedido nas variáves de sessão do Whatsapp ####	
							if(isset($_SESSION['bd_orcamento']['Whatsapp']) && $_SESSION['bd_orcamento']['Whatsapp'] == "S"){
								if(isset($_SESSION['Empresa']['ClientePedido']) && $_SESSION['Empresa']['ClientePedido'] == "S") {
									$nomecliente = '*'.$data['cliente']['NomeCliente'].'*';
								}else{
									$nomecliente = FALSE;
								}						
								if(isset($_SESSION['Empresa']['idClientePedido']) && $_SESSION['Empresa']['idClientePedido'] == "S") {
									$idcliente = '*'.$data['orcatrata']['idApp_Cliente'].'*';
								}else{
									$idcliente = FALSE;
								}
								if(isset($_SESSION['Empresa']['idPedido']) && $_SESSION['Empresa']['idPedido'] == "S") {
									$idpedido = '*'.$id.'*';
								}else{
									$idpedido = FALSE;
								}											
								if(isset($_SESSION['Empresa']['SitePedido']) && $_SESSION['Empresa']['SitePedido'] == "S") {
									$sitepedido = "https://enkontraki.com.br/".$_SESSION['Empresa']['Site'];
								}else{
									$sitepedido = FALSE;
								}
								$data['whatsapp'] = utf8_encode($_SESSION['Empresa']['TextoPedido_1'].' '.$nomecliente. ' ' .$_SESSION['Empresa']['TextoPedido_2']. ' ' . $idcliente . ' ' .$_SESSION['Empresa']['TextoPedido_3']. ' ' . $idpedido . ' ' .$_SESSION['Empresa']['TextoPedido_4']. ' ' . $sitepedido);
							}
						}	
						
					}else{
						unset($_SESSION['Cliente']);
					}
					
					#### Carrega os dados do Usuario ou Associado nas variáves de sessão ####
					if(isset($data['orcatrata']['idSis_Usuario']) && $data['orcatrata']['idSis_Usuario'] != 0){
						if($_SESSION['log']['idSis_Empresa'] == 5){
							$data['usuario'] = $this->Associado_model->get_associado($data['orcatrata']['idSis_Usuario'], TRUE);
						}else{
							$data['usuario'] = $this->Usuario_model->get_usuario($data['orcatrata']['idSis_Usuario'], TRUE);
						}
					}
					
					$data['query'] = $this->Orcatrataprint_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata'], TRUE);


					#### App_ServicoVenda ####
					$data['servico'] = $this->Orcatrataprint_model->get_servico($id);
					if (count($data['servico']) > 0) {
						$data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
						$data['count']['SCount'] = count($data['servico']);

						if (isset($data['servico'])) {

							for($j=1;$j<=$data['count']['SCount'];$j++) {
								$data['servico'][$j]['SubtotalProduto'] = number_format(($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto']), 2, ',', '.');
								$data['servico'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataConcluidoProduto'], 'barras');
								$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'barras');
								$data['servico'][$j]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['servico'][$j]['ConcluidoProduto'], 'NS');
							}
						}
					}
					

					#### App_ProdutoVenda ####
					$data['produto'] = $this->Orcatrataprint_model->get_produto($id);
					if (count($data['produto']) > 0) {
						$data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
						$data['count']['PCount'] = count($data['produto']);

						if (isset($data['produto'])) {

							for($j=1;$j<=$data['count']['PCount'];$j++) {
								$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
								$data['produto'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataConcluidoProduto'], 'barras');
								$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
								$data['produto'][$j]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['ConcluidoProduto'], 'NS');
								$data['produto'][$j]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['DevolvidoProduto'], 'NS');
							}

						}
					}

					#### App_Parcelas####
					$data['parcelasrec'] = $this->Orcatrataprint_model->get_parcelasrec($id);
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
					$data['procedimento'] = $this->Orcatrataprint_model->get_procedimento($id);
					if (count($data['procedimento']) > 0) {
						$data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
						$data['count']['PMCount'] = count($data['procedimento']);

						if (isset($data['procedimento'])) {

							for($j=1; $j <= $data['count']['PMCount']; $j++)
								$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');


						}
					}
				}
			
			
			$data['titulo'] = 'Versão Entrega';
			$data['form_open_path'] = 'OrcatrataPrint/imprimir';
			$data['panel'] = 'info';
			$data['metodo'] = 1;		
			
			$data['cor_cli'] 	= 'default';
			$data['cor_cons'] 	= 'default';
			$data['cor_orca'] 	= 'warning';
			$data['cor_sac'] 	= 'default';
			$data['cor_mark'] 	= 'default';
			
			$data['nav_orca'] 		= 'S';
			$data['nav_status'] 	= 'S';
			$data['nav_alterar'] 	= 'N';
			
			$data['nav_imprimir'] 	= 'S';
			$data['nav_entrega'] 	= 'N';
			$data['nav_cobranca'] 	= 'S';

			$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data);
			  echo "</pre>";
			  #exit ();
			 */

			$this->load->view('orcatrata/print_orcatrata', $data);
		}
        $this->load->view('basico/footer');

    }

    public function imprimircobranca($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {

			unset($_SESSION['Orcatrata']);
			unset($_SESSION['Cliente']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
				#### App_OrcaTrata ####
				
				$_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrataprint_model->get_orcatrata($id);
			
				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 2){
					
					unset($_SESSION['Orcatrata']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {			
					
					$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
					$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'barras');
					$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'barras');
					$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'barras');
					$data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'barras');
					$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'barras');
					$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'barras');
					$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'barras');

					#### Carrega os dados do cliente nas variáves de sessão ####
					
					if($data['orcatrata']['idApp_Cliente'] != 0 && $data['orcatrata']['idApp_Cliente'] != 1){
						
						$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
							
						if($data['cliente'] === FALSE){
							
							unset($_SESSION['Orcatrata']);
							unset($_SESSION['Cliente']);
							$data['msg'] = '?m=3';
							redirect(base_url() . 'acesso' . $data['msg']);
							exit();
							
						} else {
						
							$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
						}
					}else{
						unset($_SESSION['Cliente']);
					}
					
					if(isset($data['orcatrata']['idSis_Usuario']) && $data['orcatrata']['idSis_Usuario'] != 0){
						if($_SESSION['log']['idSis_Empresa'] == 5){
							$data['usuario'] = $this->Associado_model->get_associado($data['orcatrata']['idSis_Usuario'], TRUE);
						}else{
							$data['usuario'] = $this->Usuario_model->get_usuario($data['orcatrata']['idSis_Usuario'], TRUE);
						}
					}

					$data['query'] = $this->Orcatrataprint_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata'], TRUE);

					#### App_ServicoVenda ####
					$data['servico'] = $this->Orcatrataprint_model->get_servico($id);
					if (count($data['servico']) > 0) {
						$data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
						$data['count']['SCount'] = count($data['servico']);

						if (isset($data['servico'])) {

							for($j=1;$j<=$data['count']['SCount'];$j++) {
								$data['servico'][$j]['SubtotalProduto'] = number_format(($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto']), 2, ',', '.');
								$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'barras');
								$data['servico'][$j]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['servico'][$j]['ConcluidoProduto'], 'NS');
							}
						}
					}
					

					#### App_ProdutoVenda ####
					$data['produto'] = $this->Orcatrataprint_model->get_produto($id);
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
					$data['parcelasrec'] = $this->Orcatrataprint_model->get_parcelasrec($id);
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
					$data['procedimento'] = $this->Orcatrataprint_model->get_procedimento($id);
					if (count($data['procedimento']) > 0) {
						$data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
						$data['count']['PMCount'] = count($data['procedimento']);

						if (isset($data['procedimento'])) {

							for($j=1; $j <= $data['count']['PMCount']; $j++)
								$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');


						}
					}
				}
			
			
			$data['titulo'] = 'Versão Cobrança';
			$data['form_open_path'] = 'OrcatrataPrint/imprimircobranca';
			$data['panel'] = 'info';
			$data['metodo'] = 2;		
			
			$data['cor_cli'] 	= 'default';
			$data['cor_cons'] 	= 'default';
			$data['cor_orca'] 	= 'warning';
			$data['cor_sac'] 	= 'default';
			$data['cor_mark'] 	= 'default';
			
			$data['nav_orca'] 		= 'S';
			$data['nav_status'] 	= 'S';
			$data['nav_alterar'] 	= 'N';
			
			$data['nav_imprimir'] 	= 'S';
			$data['nav_entrega'] 	= 'S';
			$data['nav_cobranca'] 	= 'N';

			$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data);
			  echo "</pre>";
			  #exit ();
			 */

			$this->load->view('orcatrata/print_orcatrata', $data);
		}
        $this->load->view('basico/footer');

    }

    public function imprimirdesp($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {

			unset($_SESSION['Orcatrata']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {

				#### App_OrcaTrata ####
				$_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrataprint_model->get_orcatrata($id);
			
				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 1){
					unset($_SESSION['Orcatrata']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {			
					
					$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
					$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'barras');
					$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'barras');
					$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'barras');
					$data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'barras');
					$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'barras');
					$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'barras');
					$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'barras');


					#### Carrega os dados do fornrcedor nas variáves de sessão ####
					$this->load->model('Fornecedor_model');
					if($data['orcatrata']['idApp_Fornecedor'] != 0){
						$data['fornecedor'] = $this->Fornecedor_model->get_fornecedor($data['orcatrata']['idApp_Fornecedor'], TRUE);
					}
					
					if(isset($data['orcatrata']['idSis_Usuario']) && $data['orcatrata']['idSis_Usuario'] != 0){
						if($_SESSION['log']['idSis_Empresa'] == 5){
							$data['usuario'] = $this->Associado_model->get_associado($data['orcatrata']['idSis_Usuario'], TRUE);
						}else{
							$data['usuario'] = $this->Usuario_model->get_usuario($data['orcatrata']['idSis_Usuario'], TRUE);
						}
					}

					if(isset($data['orcatrata']['id_Funcionario']) && $data['orcatrata']['id_Funcionario'] != 0){
						if($_SESSION['log']['idSis_Empresa'] != 5){
							$data['funcionario'] = $this->Usuario_model->get_usuario($data['orcatrata']['id_Funcionario'], TRUE);
						}
					}

					if(isset($data['orcatrata']['id_Associado']) && $data['orcatrata']['id_Associado'] != 0){
						if($_SESSION['log']['idSis_Empresa'] != 5){
							$data['associado'] = $this->Associado_model->get_associado($data['orcatrata']['id_Associado'], TRUE);
						}
					}
					
					$data['query'] = $this->Orcatrataprint_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata'], TRUE);	
					
					#### App_ServicoVenda ####
					$data['servico'] = $this->Orcatrataprint_model->get_servico_desp($id);
					if (count($data['servico']) > 0) {
						$data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
						$data['count']['SCount'] = count($data['servico']);

						if (isset($data['servico'])) {

							for($j=1;$j<=$data['count']['SCount'];$j++) {
								$data['servico'][$j]['SubtotalProduto'] = number_format(($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto']), 2, ',', '.');
								$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'barras');
							}
						}
					}
					
					#### App_ProdutoVenda ####
					$data['produto'] = $this->Orcatrataprint_model->get_produto_desp($id);
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
					$data['parcelasrec'] = $this->Orcatrataprint_model->get_parcelasrec($id);
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
					$data['procedimento'] = $this->Orcatrataprint_model->get_procedimento($id);
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
		}
        $this->load->view('basico/footer');

    }

    public function imprimirgrupo($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {

			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {

			#### App_OrcaTrata ####
			$data['orcatrata'] = $this->Orcatrataprint_model->get_orcatrata($id);
		
			if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 4){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {			
				
				$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');

				if(isset($data['orcatrata']['idSis_Usuario']) && $data['orcatrata']['idSis_Usuario'] != 0){
					if($_SESSION['log']['idSis_Empresa'] == 5){
						$data['usuario'] = $this->Associado_model->get_associado($data['orcatrata']['idSis_Usuario'], TRUE);
					}else{
						$data['usuario'] = $this->Usuario_model->get_usuario($data['orcatrata']['idSis_Usuario'], TRUE);
					}
				}
			}
			$this->load->view('orcatrata/print_grupo', $data);
		}
        $this->load->view('basico/footer');

    }

    public function imprimirrecibodesp($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {
			
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			if($_SESSION['log']['idSis_Empresa'] !== $id){
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
					
			}else{			
				
				$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio4'], 'barras');
				$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim4'], 'barras');

				$data['Pesquisa'] = '';

				$config['base_url'] = base_url() . 'Relatorio_print/cobrancas_recibo/' . $id . '/';
				$config['total_rows'] = $this->Orcatrataprintcobranca_model->get_orcatrata($id, TRUE);
				
				$config['per_page'] = 12;
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
				
				$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
				$data['pagina'] = $page;
				$data['per_page'] = $config['per_page'];
				
				$data['pagination'] = $this->pagination->create_links();
			
				#### App_OrcaTrata ####
				$data['orcatrata'] = $this->Orcatrataprintcobranca_model->get_orcatrata($id, FALSE, $config['per_page'], ($page * $config['per_page']));
				if (count($data['orcatrata']) > 0) {
					$data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
					$data['count']['POCount'] = count($data['orcatrata']);           

					if (isset($data['orcatrata'])) {

						for($i=1;$i<=$data['count']['POCount'];$i++) {
							
							$data['orcatrata'][$i]['idApp_OrcaTrata'] = $data['orcatrata'][$i]['idApp_OrcaTrata'];
							$data['orcatrata'][$i]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataOrca'], 'barras');
							$data['orcatrata'][$i]['DataPrazo'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataPrazo'], 'barras');
							$data['orcatrata'][$i]['DataConclusao'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataConclusao'], 'barras');
							$data['orcatrata'][$i]['DataRetorno'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataRetorno'], 'barras');
							$data['orcatrata'][$i]['DataQuitado'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataQuitado'], 'barras');
							$data['orcatrata'][$i]['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataEntradaOrca'], 'barras');
							$data['orcatrata'][$i]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataEntregaOrca'], 'barras');
							$data['orcatrata'][$i]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataVencimentoOrca'], 'barras');
							$data['orcatrata'][$i]['ValorTotalOrca'] = number_format(($data['orcatrata'][$i]['ValorTotalOrca']), 2, ',', '.');
							$data['orcatrata'][$i]['ConcluidoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['ConcluidoOrca'], 'NS');
							$data['orcatrata'][$i]['QuitadoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['QuitadoOrca'], 'NS');
							/*
							echo '<br>';
							echo "<pre>";
							print_r($data['orcatrata'][$i]);
							echo "</pre>";
							*/
							#### App_ProdutoVenda ####
							$data['produto'][$i] = $this->Orcatrataprintcobranca_model->get_produto($data['orcatrata'][$i]['idApp_OrcaTrata']);
							if (count($data['produto'][$i]) > 0) {
								$data['produto'][$i] = array_combine(range(1, count($data['produto'][$i])), array_values($data['produto'][$i]));
								$data['count']['PCount'][$i] = count($data['produto'][$i]);

								if (isset($data['produto'][$i])) {

									for($k=1;$k<=$data['count']['PCount'][$i];$k++) {
										$data['produto'][$i][$k]['SubtotalProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto'] * $data['produto'][$i][$k]['QtdProduto']), 2, ',', '.');
										$data['produto'][$i][$k]['ValorProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto']), 2, ',', '.');
										$data['produto'][$i][$k]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$i][$k]['DataValidadeProduto'], 'barras');
										$data['produto'][$i][$k]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['ConcluidoProduto'], 'NS');
										$data['produto'][$i][$k]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['DevolvidoProduto'], 'NS');
									}
								}
							}
							/*
							echo '<br>';
							echo "<pre>";
							print_r($data['produto'][$i]);
							echo "</pre>";
							*/		
							#### App_Parcelas####
							$data['parcelasrec'][$i] = $this->Orcatrataprintcobranca_model->get_parcelasrec($data['orcatrata'][$i]['idApp_OrcaTrata']);
							if (count($data['parcelasrec'][$i]) > 0) {
								$data['parcelasrec'][$i] = array_combine(range(1, count($data['parcelasrec'][$i])), array_values($data['parcelasrec'][$i]));
								$data['count']['PRCount'][$i] = count($data['parcelasrec'][$i]);
								
								if (isset($data['parcelasrec'][$i])) {

									for($j=1; $j <= $data['count']['PRCount'][$i]; $j++) {
										$data['parcelasrec'][$i][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataVencimento'], 'barras');
										$data['parcelasrec'][$i][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataPago'], 'barras');
										$data['parcelasrec'][$i][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataLanc'], 'barras');
									}
								}
							}
							/*
							echo '<br>';
							echo "<pre>";
							print_r($data['parcelasrec'][$i]);
							echo "</pre>";
							*/
							#### App_Procedimento ####
							$data['procedimento'][$i] = $this->Orcatrataprintcobranca_model->get_procedimento($data['orcatrata'][$i]['idApp_OrcaTrata']);
							if (count($data['procedimento'][$i]) > 0) {
								$data['procedimento'][$i] = array_combine(range(1, count($data['procedimento'][$i])), array_values($data['procedimento'][$i]));
								$data['count']['PMCount'][$i] = count($data['procedimento'][$i]);

								if (isset($data['procedimento'][$i])) {

									for($j=1; $j <= $data['count']['PMCount'][$i]; $j++){
										$data['procedimento'][$i][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$i][$j]['DataProcedimento'], 'barras');						
									}
								}
							}
						}
					}	
				}

				$data['titulo'] = 'Versão Recibo Debito';
				$data['form_open_path'] = 'OrcatrataPrint/imprimirrecibodesp';
				$data['panel'] = 'danger';
				$data['metodo'] = 1;
				$data['imprimir'] = 'OrcatrataPrint/imprimir/';
				$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistadesp/';
				$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirrecibodesp/';		
				

				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data);
				  echo "</pre>";
				  #exit ();
				 */

				$this->load->view('orcatrata/print_orcatratacobranca', $data);
				
			}
		}
        $this->load->view('basico/footer');

    }

    public function imprimirlistacliente($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		

		if (!$id) {

			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			if($_SESSION['log']['idSis_Empresa'] !== $id){
					
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}else{
				
				$data['Imprimir']['DataInicio'] = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio'], 'barras') : FALSE;
				$data['Imprimir']['DataFim'] = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim'], 'barras') : FALSE;
				$data['Imprimir']['DataInicio6'] = ($_SESSION['FiltroAlteraParcela']['DataInicio6']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio6'], 'barras') : FALSE;
				$data['Imprimir']['DataFim6'] = ($_SESSION['FiltroAlteraParcela']['DataFim6']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim6'], 'barras') : FALSE;
				
				//$_SESSION['DataInicio'] = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio'], 'barras') : FALSE;
				$_SESSION['DataInicio'] = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? $_SESSION['FiltroAlteraParcela']['DataInicio'] : FALSE;
				
				/*
				echo '<br>';
				echo "<pre>";
				print_r($data['Imprimir']['DataInicio']);
				echo "</pre>";
				exit ();
				*/

				//$this->load->library('pagination');

				$data['Pesquisa'] = '';

				$data['pesquisa_query'] = $this->Orcatrataprint_model->get_orcatrata_cliente($id, TRUE);
				$config['total_rows'] = $data['pesquisa_query']->num_rows();
				
				//$config['total_rows'] = $this->Orcatrataprint_model->get_orcatrata_cliente($id, TRUE);
				
				$config['base_url'] = base_url() . 'OrcatrataPrint/imprimirlistacliente/' . $id . '/';
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
				
				$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
				$data['pagina'] = $page;
				$data['per_page'] = $config['per_page'];
				
				$data['pagination'] = $this->pagination->create_links();		

				#### App_OrcaTrata ####
				//$data['orcatrata'] = $this->Orcatrataprintcobranca_model->get_orcatrata_cliente($id);
				$data['orcatrata'] = $this->Orcatrataprint_model->get_orcatrata_cliente($id, FALSE, $config['per_page'], ($page * $config['per_page']));
				if (count($data['orcatrata']) > 0) {
					$data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
					$data['count']['POCount'] = count($data['orcatrata']);           

					if (isset($data['orcatrata'])) {

						for($j=1;$j<=$data['count']['POCount'];$j++) {
							
							$data['orcatrata'][$j]['idApp_OrcaTrata'] = $data['orcatrata'][$j]['idApp_OrcaTrata'];
							$data['orcatrata'][$j]['DataCadastroCliente'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataCadastroCliente'], 'barras');
							$data['orcatrata'][$j]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataOrca'], 'barras');
							$data['orcatrata'][$j]['DataPrazo'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataPrazo'], 'barras');
							$data['orcatrata'][$j]['DataConclusao'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataConclusao'], 'barras');
							$data['orcatrata'][$j]['DataRetorno'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataRetorno'], 'barras');
							$data['orcatrata'][$j]['DataQuitado'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataQuitado'], 'barras');
							$data['orcatrata'][$j]['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntradaOrca'], 'barras');
							$data['orcatrata'][$j]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntregaOrca'], 'barras');
							$data['orcatrata'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataVencimentoOrca'], 'barras');
							$data['orcatrata'][$j]['ValorTotalOrca'] = number_format(($data['orcatrata'][$j]['ValorTotalOrca']), 2, ',', '.');
							$data['orcatrata'][$j]['ConcluidoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$j]['ConcluidoOrca'], 'NS');
							$data['orcatrata'][$j]['QuitadoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$j]['QuitadoOrca'], 'NS');

						}
					}	
				}
				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data['orcatrata']);
				  echo "</pre>";
				  //exit ();
				*/ 


				$data['titulo'] = 'Lista Clientes';
				$data['form_open_path'] = 'OrcatrataPrint/imprimirlistacliente';
				$data['panel'] = 'info';
				$data['metodo'] = 1;
				$data['imprimir'] = 'OrcatrataPrint/imprimir/';
				$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistacliente/';
				$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
				
				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data);
				  echo "</pre>";
				  #exit ();
				 */

				$this->load->view('orcatrata/print_orcatratacliente_lista', $data);
			}
		}
        $this->load->view('basico/footer');

    }
	
}
