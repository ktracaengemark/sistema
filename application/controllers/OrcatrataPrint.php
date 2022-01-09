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
        $this->load->model(array(
									'Basico_model', 'Orcatrata_model', 'Orcatrataprint_model', 'Orcatrataprintcobranca_model', 
									'Orcatrataprintcomissao_model', 'Relatorio_model', 'Formapag_model' , 'Usuario_model' , 
									'Cliente_model' , 'Fornecedor_model', 'Associado_model', 'Campanha_model'
								));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
		#$this->load->view('basico/header_refresh_print');
        $this->load->view('basico/nav_principal');
        #$this->load->view('basico/nav_impressao');
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

        if ($id) {
            #### App_OrcaTrata ####
            $data['orcatrata'] = $this->Orcatrataprint_model->get_orcatrata($id);
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
            $this->load->model('Cliente_model');
			if($data['orcatrata']['idApp_Cliente'] != 0 && $data['orcatrata']['idApp_Cliente'] != 1){
				//$data['cliente'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
				
				#### Carrega os dados do Pedido nas variáves de sessão do Whatsapp ####
				if(isset($data['orcatrata']['CombinadoFrete']) && $data['orcatrata']['CombinadoFrete'] == "S"){
					if(isset($data['orcatrata']['AprovadoOrca']) && $data['orcatrata']['AprovadoOrca'] == "S"){
						if(isset($data['orcatrata']['ConcluidoOrca']) && $data['orcatrata']['ConcluidoOrca'] == "S"){
							$data['whatsapp'] = utf8_encode('Olá '.$data['cliente']['NomeCliente'].'. Foi um prazer entregar o seu Pedido *' . $id . '* . Esperamos que fique totalmente satisfeito! Aproveite e visite o nosso site. https://enkontraki.com.br/'.$_SESSION['Empresa']['Site'].'');
						}else{
							$data['whatsapp'] = utf8_encode('Olá '.$data['cliente']['NomeCliente'].'. Estamos preparando o seu Pedido *' . $id . '* . Esperamos que fique totalmente satisfeito! Aproveite e visite o nosso site. https://enkontraki.com.br/'.$_SESSION['Empresa']['Site'].'');
						}
					}
				}	
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
		
        $data['titulo'] = 'Versão Entrega';
        $data['form_open_path'] = 'OrcatrataPrint/imprimir';
        $data['panel'] = 'info';
        $data['metodo'] = 1;		

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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($id) {
            #### App_OrcaTrata ####
            $data['orcatrata'] = $this->Orcatrataprint_model->get_orcatrata($id);
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

        $this->load->view('basico/footer');

    }

    public function imprimirlistacliente($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		
		
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
				
        if ($id) {
			
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

        }

        $data['titulo'] = 'Lista Clientes';
        $data['form_open_path'] = 'OrcatrataPrint/imprimirlistacliente';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistacliente/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		
        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('orcatrata/print_orcatratacliente_lista', $data);

        $this->load->view('basico/footer');

    }

    public function imprimircobranca($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($id) {
            #### App_OrcaTrata ####
            $_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrataprint_model->get_orcatrata($id);
            $data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
			$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'barras');
            $data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'barras');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'barras');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'barras');
			$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'barras');
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'barras');
            $data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'barras');

			#### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
			if($data['orcatrata']['idApp_Cliente'] != 0 && $data['orcatrata']['idApp_Cliente'] != 1){
				//$data['cliente'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
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

    public function imprimirreciborec_orig($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio4'], 'barras');
		$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim4'], 'barras');

		//$this->load->library('pagination');

		$data['Pesquisa'] = '';
				
        if ($id) {
            
			$config['base_url'] = base_url() . 'OrcatrataPrint/imprimirreciborec/' . $id . '/';
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

                    for($j=1;$j<=$data['count']['POCount'];$j++) {
						
						$data['orcatrata'][$j]['idApp_OrcaTrata'] = $data['orcatrata'][$j]['idApp_OrcaTrata'];
						$data['orcatrata'][$j]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataOrca'], 'barras');
						$data['orcatrata'][$j]['DataPrazo'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataPrazo'], 'barras');
						$data['orcatrata'][$j]['DataConclusao'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataConclusao'], 'barras');
						$data['orcatrata'][$j]['DataRetorno'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataRetorno'], 'barras');
						$data['orcatrata'][$j]['DataQuitado'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataQuitado'], 'barras');
						$data['orcatrata'][$j]['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntradaOrca'], 'barras');
						$data['orcatrata'][$j]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntregaOrca'], 'barras');
						$data['orcatrata'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataVencimentoOrca'], 'barras');
						$data['orcatrata'][$j]['ValorTotalOrca'] = number_format(($data['orcatrata'][$j]['ValorTotalOrca']), 2, ',', '.');
						$data['orcatrata'][$j]['ValorFinalOrca'] = number_format(($data['orcatrata'][$j]['ValorFinalOrca']), 2, ',', '.');
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
			  exit ();
			  */

            #### App_ProdutoVenda ####
            $data['produto'] = $this->Orcatrataprintcobranca_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						$data['produto'][$j]['ValorProduto'] = number_format(($data['produto'][$j]['ValorProduto']), 2, ',', '.');
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						$data['produto'][$j]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['ConcluidoProduto'], 'NS');
						$data['produto'][$j]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['DevolvidoProduto'], 'NS');
					}
                }
            }
			
            #### App_Parcelas####
            $data['parcelasrec'] = $this->Orcatrataprintcobranca_model->get_parcelasrec($id);
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
            $data['procedimento'] = $this->Orcatrataprintcobranca_model->get_procedimento($id);
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
		
        $data['titulo'] = 'Versão Recibo Cobrança';
        $data['form_open_path'] = 'OrcatrataPrint/imprimirreciborec';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';		
		

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('orcatrata/print_orcatratacobranca', $data);

        $this->load->view('basico/footer');

    }

    public function imprimirreciborec($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio4'], 'barras');
		$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim4'], 'barras');

		//$this->load->library('pagination');

		$data['Pesquisa'] = '';
				
        if ($id) {
            
			$config['base_url'] = base_url() . 'OrcatrataPrint/imprimirreciborec/' . $id . '/';
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
						$data['orcatrata'][$i]['ValorFinalOrca'] = number_format(($data['orcatrata'][$i]['ValorFinalOrca']), 2, ',', '.');
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
			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['orcatrata']);
			  echo "</pre>";
			  exit ();
			  */
			/*
            #### App_ProdutoVenda ####
            $data['produto'] = $this->Orcatrataprintcobranca_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						$data['produto'][$j]['ValorProduto'] = number_format(($data['produto'][$j]['ValorProduto']), 2, ',', '.');
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						$data['produto'][$j]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['ConcluidoProduto'], 'NS');
						$data['produto'][$j]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['DevolvidoProduto'], 'NS');
					}
                }
            }
			*/
			/*
            #### App_Parcelas####
            $data['parcelasrec'] = $this->Orcatrataprintcobranca_model->get_parcelasrec($id);
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
			*/
			/*
            #### App_Procedimento ####
            $data['procedimento'] = $this->Orcatrataprintcobranca_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++){
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');						
					}
                }
            }
			*/
        }
		
        $data['titulo'] = 'Versão Recibo Cobrança';
        $data['form_open_path'] = 'OrcatrataPrint/imprimirreciborec';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';		
		

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('orcatrata/print_orcatratacobranca', $data);

        $this->load->view('basico/footer');

    }

    public function imprimirlistarec($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		
		
		$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio4'], 'barras');
		$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim4'], 'barras');

		//$this->load->library('pagination');

		$data['Pesquisa'] = '';
		
        if ($id) {
		
			$config['base_url'] = base_url() . 'OrcatrataPrint/imprimirlistarec/' . $id . '/';
			$config['total_rows'] = $this->Orcatrataprintcobranca_model->get_orcatrata($id, TRUE);
			
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
            $data['orcatrata'] = $this->Orcatrataprintcobranca_model->get_orcatrata($id, FALSE, $config['per_page'], ($page * $config['per_page']));
            if (count($data['orcatrata']) > 0) {
                $data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
                $data['count']['POCount'] = count($data['orcatrata']);           

				if (isset($data['orcatrata'])) {

                    for($j=1;$j<=$data['count']['POCount'];$j++) {
						
						$data['orcatrata'][$j]['idApp_OrcaTrata'] = $data['orcatrata'][$j]['idApp_OrcaTrata'];
						$data['orcatrata'][$j]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataOrca'], 'barras');
						$data['orcatrata'][$j]['DataPrazo'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataPrazo'], 'barras');
						$data['orcatrata'][$j]['DataConclusao'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataConclusao'], 'barras');
						$data['orcatrata'][$j]['DataRetorno'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataRetorno'], 'barras');
						$data['orcatrata'][$j]['DataQuitado'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataQuitado'], 'barras');
						$data['orcatrata'][$j]['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntradaOrca'], 'barras');
						$data['orcatrata'][$j]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntregaOrca'], 'barras');
						$data['orcatrata'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataVencimentoOrca'], 'barras');
						$data['orcatrata'][$j]['ValorTotalOrca'] = number_format(($data['orcatrata'][$j]['ValorTotalOrca']), 2, ',', '.');
						$data['orcatrata'][$j]['ValorFinalOrca'] = number_format(($data['orcatrata'][$j]['ValorFinalOrca']), 2, ',', '.');
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
			  exit ();
			  */

            #### App_ProdutoVenda ####
            $data['produto'] = $this->Orcatrataprintcobranca_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						$data['produto'][$j]['ValorProduto'] = number_format(($data['produto'][$j]['ValorProduto']), 2, ',', '.');
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						$data['produto'][$j]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['ConcluidoProduto'], 'NS');
						$data['produto'][$j]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['DevolvidoProduto'], 'NS');
					}
                }
            }
			
            #### App_Parcelas####
            $data['parcelasrec'] = $this->Orcatrataprintcobranca_model->get_parcelasrec($id);
            if (count($data['parcelasrec']) > 0) {
                $data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
				$data['count']['PRCount'] = count($data['parcelasrec']);
                if (isset($data['parcelasrec'])) {

                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
                        $data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
                        $data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
                        $data['parcelasrec'][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataLanc'], 'barras');
                    }
                }
            }
			
            #### App_Procedimento ####
            $data['procedimento'] = $this->Orcatrataprintcobranca_model->get_procedimento($id);
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

        $data['titulo'] = 'Versão Lista Cobrança';
        $data['form_open_path'] = 'OrcatrataPrint/imprimirlistarec';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		
        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('orcatrata/print_orcatratacobranca_lista', $data);

        $this->load->view('basico/footer');

    }

    public function imprimirrecibodesp($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio4'], 'barras');
		$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim4'], 'barras');

		//$this->load->library('pagination');

		$data['Pesquisa'] = '';
						
        if ($id) {
            
			$config['base_url'] = base_url() . 'OrcatrataPrint/imprimirreciborec/' . $id . '/';
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
			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['orcatrata']);
			  echo "</pre>";
			  exit ();
			  */
			/*
            #### App_ProdutoVenda ####
            $data['produto'] = $this->Orcatrataprintcobranca_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						$data['produto'][$j]['ValorProduto'] = number_format(($data['produto'][$j]['ValorProduto']), 2, ',', '.');
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						$data['produto'][$j]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['ConcluidoProduto'], 'NS');
						$data['produto'][$j]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['DevolvidoProduto'], 'NS');
					}
                }
            }
			
            #### App_Parcelas####
            $data['parcelasrec'] = $this->Orcatrataprintcobranca_model->get_parcelasrec($id);
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
            $data['procedimento'] = $this->Orcatrataprintcobranca_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++){
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');						
					}
                }
            }
			*/
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

        $this->load->view('basico/footer');

    }

    public function imprimirlistadesp($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		
		
		$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio4'], 'barras');
		$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim4'], 'barras');

		//$this->load->library('pagination');

		$data['Pesquisa'] = '';
				
        if ($id) {
		
			$config['base_url'] = base_url() . 'OrcatrataPrint/imprimirlistadesp/' . $id . '/';
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

                    for($j=1;$j<=$data['count']['POCount'];$j++) {
						
						$data['orcatrata'][$j]['idApp_OrcaTrata'] = $data['orcatrata'][$j]['idApp_OrcaTrata'];
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
			  exit ();
			  */

            #### App_ProdutoVenda ####
            $data['produto'] = $this->Orcatrataprintcobranca_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						$data['produto'][$j]['ValorProduto'] = number_format(($data['produto'][$j]['ValorProduto']), 2, ',', '.');
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						$data['produto'][$j]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['ConcluidoProduto'], 'NS');
						$data['produto'][$j]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$j]['DevolvidoProduto'], 'NS');
					}
                }
            }
			
            #### App_Parcelas####
            $data['parcelasrec'] = $this->Orcatrataprintcobranca_model->get_parcelasrec($id);
            if (count($data['parcelasrec']) > 0) {
                $data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
				$data['count']['PRCount'] = count($data['parcelasrec']);
                if (isset($data['parcelasrec'])) {

                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
                        $data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
                        $data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
                        $data['parcelasrec'][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataLanc'], 'barras');
                    }
                }
            }
			
            #### App_Procedimento ####
            $data['procedimento'] = $this->Orcatrataprintcobranca_model->get_procedimento($id);
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

        $data['titulo'] = 'Versão Lista Débitos';
        $data['form_open_path'] = 'OrcatrataPrint/imprimirlistadesp';
        $data['panel'] = 'danger';
        $data['metodo'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistadesp/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirrecibodesp/';
		
        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('orcatrata/print_orcatratacobranca_lista', $data);

        $this->load->view('basico/footer');

    }

    public function imprimircomissao($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		//$this->load->library('pagination');

		$data['Pesquisa'] = '';
					
		$data['somatotal'] = 0;
        if ($id) {
			
			$data['pesquisa_query'] = $this->Orcatrataprintcomissao_model->get_orcatrata($id, TRUE);
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			
			//$config['total_rows'] = $this->Orcatrataprintcomissao_model->get_orcatrata($id, TRUE);

			$config['base_url'] = base_url() . 'OrcatrataPrint/imprimircomissao/' . $id . '/';			
			$config['per_page'] = 50;
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
            $data['orcatrata'] = $this->Orcatrataprintcomissao_model->get_orcatrata($id, FALSE, $config['per_page'], ($page * $config['per_page']));
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
						$data['orcatrata'][$j]['DataPagoComissaoOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataPagoComissaoOrca'], 'barras');
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
			/*
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
			*/
        }

        $data['titulo'] = 'Comissao Colaborador';
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

    public function imprimircomissao_online($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		
		
		//$this->load->library('pagination');

		$data['Pesquisa'] = '';
					
		$data['somatotal'] = 0;
        if ($id) {
			
			$data['pesquisa_query'] = $this->Orcatrataprintcomissao_model->get_orcatrata($id, TRUE);
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
			
			//$config['total_rows'] = $this->Orcatrataprintcomissao_model->get_orcatrata($id, TRUE);

			$config['base_url'] = base_url() . 'OrcatrataPrint/imprimircomissao_online/' . $id . '/';			
			$config['per_page'] = 50;
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
            $data['orcatrata'] = $this->Orcatrataprintcomissao_model->get_orcatrata($id, FALSE, $config['per_page'], ($page * $config['per_page']));
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

        $data['titulo'] = 'Comissao Associado';
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
