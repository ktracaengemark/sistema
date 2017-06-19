<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Consumo extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Servico_model', 'Produto_model', 'Consumo_model', 'Profissional_model', 'Formapag_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('consumo/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('consumo/tela_index', $data);

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
        $data['consumo'] = quotes_to_entities($this->input->post(array(
            #### App_Consumo ####
            'idApp_Consumo',
            #'Consumo',
            'DataConsumo',
			#'TipoConsumo',
			'ProfissionalConsumo',           
            'ObsConsumo',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        #(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');


        //Data de hoje como default
        (!$data['consumo']['DataConsumo']) ? $data['consumo']['DataConsumo'] = date('d/m/Y', time()) : FALSE;
/*
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
                $data['servico'][$j]['ValorConsumoServico'] = $this->input->post('ValorConsumoServico' . $i);
                $data['servico'][$j]['QtdConsumoServico'] = $this->input->post('QtdConsumoServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;
*/
        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i)) {
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                $data['produto'][$j]['ValorConsumoProduto'] = $this->input->post('ValorConsumoProduto' . $i);
                $data['produto'][$j]['QtdConsumoProduto'] = $this->input->post('QtdConsumoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
                $j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

        
/*
        if ($data['consumo']['QtdParcelasConsumo'] > 0) {

            for ($i = 1; $i <= $data['consumo']['QtdParcelasConsumo']; $i++) {

                $data['parcelaspag'][$i]['ParcelaPagaveis'] = $this->input->post('ParcelaPagaveis' . $i);
                $data['parcelaspag'][$i]['ValorParcelaPagaveis'] = $this->input->post('ValorParcelaPagaveis' . $i);
                $data['parcelaspag'][$i]['DataVencimentoPagaveis'] = $this->input->post('DataVencimentoPagaveis' . $i);
                $data['parcelaspag'][$i]['ValorPagoPagaveis'] = $this->input->post('ValorPagoPagaveis' . $i);
                $data['parcelaspag'][$i]['DataPagoPagaveis'] = $this->input->post('DataPagoPagaveis' . $i);
                $data['parcelaspag'][$i]['QuitadoPagaveis'] = $this->input->post('QuitadoPagaveis' . $i);

            }

        }
*/
        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Consumo ####
        $this->form_validation->set_rules('DataConsumo', 'Data do Consumo', 'required|trim|valid_date');
        #$this->form_validation->set_rules('Consumo', 'Consumo', 'required|trim');
        #$this->form_validation->set_rules('TipoConsumo', 'Tipo de Consumo', 'required|trim');
        $this->form_validation->set_rules('ProfissionalConsumo', 'Profissional', 'required|trim');

		#$data['select']['TipoConsumo'] = $this->Tipoconsumo_model->select_tipoconsumo();



		$data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        #$data['select']['Servico'] = $this->Servico_model->select_servico();
        $data['select']['Produto'] = $this->Produto_model->select_produto();

        $data['titulo'] = 'Cadastar Consumo';
        $data['form_open_path'] = 'consumo/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
/*
        if ($data['consumo']['ValorConsumo'] || $data['consumo']['ValorEntradaConsumo'] || $data['consumo']['ValorRestanteConsumo'])
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['consumo']['FormaPagamentoConsumo'] || $data['consumo']['QtdParcelasConsumo'] || $data['consumo']['DataVencimentoConsumo'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';

*/    
/*

        #Ver uma solução melhor para este campo
        (!$data['consumo']['AprovadoConsumo']) ? $data['consumo']['AprovadoConsumo'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoConsumo' => $this->basico->radio_checked($data['consumo']['AprovadoConsumo'], 'Consumo Quitada', 'NS'),
        );

        ($data['consumo']['AprovadoConsumo'] == 'S') ?
            $data['div']['AprovadoConsumo'] = '' : $data['div']['AprovadoConsumo'] = 'style="display: none;"';
			
			
		(!$data['consumo']['QuitadoConsumo']) ? $data['consumo']['QuitadoConsumo'] = 'N' : FALSE;

        $data['radio'] = array(
            'QuitadoConsumo' => $this->basico->radio_checked($data['consumo']['QuitadoConsumo'], 'Consumo Quitada', 'NS'),
        );

        ($data['consumo']['QuitadoConsumo'] == 'S') ?
            $data['div']['QuitadoConsumo'] = '' : $data['div']['QuitadoConsumo'] = 'style="display: none;"';
*/

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
            $this->load->view('consumo/form_consumo', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Consumo ####
            $data['consumo']['DataConsumo'] = $this->basico->mascara_data($data['consumo']['DataConsumo'], 'mysql');
			#$data['consumo']['Consumo'] = $data['consumo']['Consumo'];
			$data['consumo']['TipoConsumo'] = $data['consumo']['TipoConsumo'];
			

            $data['consumo']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['consumo']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['consumo']['idApp_Consumo'] = $this->Consumo_model->set_consumo($data['consumo']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */
/*
            #### App_ServicoConsumo ####
            if (isset($data['servico'])) {
                $max = count($data['servico']);
                for($j=1;$j<=$max;$j++) {
                    $data['servico'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['servico'][$j]['idApp_Consumo'] = $data['consumo']['idApp_Consumo'];

                    $data['servico'][$j]['ValorConsumoServico'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorConsumoServico']));
                    unset($data['servico'][$j]['SubtotalServico']);
                }
                $data['servico']['idApp_ServicoConsumo'] = $this->Consumo_model->set_servico_consumo($data['servico']);
            }
*/
            #### App_ProdutoConsumo ####
            if (isset($data['produto'])) {
                $max = count($data['produto']);
                for($j=1;$j<=$max;$j++) {
                    $data['produto'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['produto'][$j]['idApp_Consumo'] = $data['consumo']['idApp_Consumo'];

                    $data['produto'][$j]['ValorConsumoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorConsumoProduto']));
                    unset($data['produto'][$j]['SubtotalProduto']);
                }
                $data['produto']['idApp_ProdutoConsumo'] = $this->Consumo_model->set_produto_consumo($data['produto']);
            }
/*
            #### App_ParcelasRec ####
            if (isset($data['parcelaspag'])) {
                $max = count($data['parcelaspag']);
                for($j=1;$j<=$max;$j++) {
                    $data['parcelaspag'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['parcelaspag'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['parcelaspag'][$j]['idApp_Consumo'] = $data['consumo']['idApp_Consumo'];
                    $data['parcelaspag'][$j]['ValorParcelaPagaveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelaspag'][$j]['ValorParcelaPagaveis']));
                    $data['parcelaspag'][$j]['DataVencimentoPagaveis'] = $this->basico->mascara_data($data['parcelaspag'][$j]['DataVencimentoPagaveis'], 'mysql');
                    $data['parcelaspag'][$j]['ValorPagoPagaveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelaspag'][$j]['ValorPagoPagaveis']));
                    $data['parcelaspag'][$j]['DataPagoPagaveis'] = $this->basico->mascara_data($data['parcelaspag'][$j]['DataPagoPagaveis'], 'mysql');

                }
                $data['parcelaspag']['idApp_ParcelasPagaveis'] = $this->Consumo_model->set_parcelaspag($data['parcelaspag']);
            }

*/

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_Consumo'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consumo/form_consumo', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consumo'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consumo', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'relatorio/consumo/'  . $data['msg']);
				
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
        $data['consumo'] = quotes_to_entities($this->input->post(array(
            #### App_Consumo ####
            'idApp_Consumo',
            #Não há a necessidade de atualizar o valor do campo a seguir
            #'idApp_Cliente',
            'DataConsumo',
			'Consumo',
			'TipoConsumo',
			'ProfissionalConsumo',
            'ObsConsumo',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        #(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
/*

        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_ServicoConsumo'] = $this->input->post('idApp_ServicoConsumo' . $i);
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
                $data['servico'][$j]['ValorConsumoServico'] = $this->input->post('ValorConsumoServico' . $i);
                $data['servico'][$j]['QtdConsumoServico'] = $this->input->post('QtdConsumoServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;
*/
        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i)) {
                $data['produto'][$j]['idApp_ProdutoConsumo'] = $this->input->post('idApp_ProdutoConsumo' . $i);
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                $data['produto'][$j]['ValorConsumoProduto'] = $this->input->post('ValorConsumoProduto' . $i);
                $data['produto'][$j]['QtdConsumoProduto'] = $this->input->post('QtdConsumoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
                $j++;
            }
        }
        $data['count']['PCount'] = $j - 1;
      
/*
        if ($data['consumo']['QtdParcelasConsumo'] > 0) {

            for ($i = 1; $i <= $data['consumo']['QtdParcelasConsumo']; $i++) {

                $data['parcelaspag'][$i]['idApp_ParcelasPagaveis'] = $this->input->post('idApp_ParcelasPagaveis' . $i);
                $data['parcelaspag'][$i]['ParcelaPagaveis'] = $this->input->post('ParcelaPagaveis' . $i);
                $data['parcelaspag'][$i]['ValorParcelaPagaveis'] = $this->input->post('ValorParcelaPagaveis' . $i);
                $data['parcelaspag'][$i]['DataVencimentoPagaveis'] = $this->input->post('DataVencimentoPagaveis' . $i);
                $data['parcelaspag'][$i]['ValorPagoPagaveis'] = $this->input->post('ValorPagoPagaveis' . $i);
                $data['parcelaspag'][$i]['DataPagoPagaveis'] = $this->input->post('DataPagoPagaveis' . $i);
                $data['parcelaspag'][$i]['QuitadoPagaveis'] = $this->input->post('QuitadoPagaveis' . $i);

            }

        }
*/
        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_Consumo ####
            $data['consumo'] = $this->Consumo_model->get_consumo($id);
            $data['consumo']['DataConsumo'] = $this->basico->mascara_data($data['consumo']['DataConsumo'], 'barras');
			#$data['consumo']['Consumo'] = $data['consumo']['Consumo'];
			$data['consumo']['TipoConsumo'] = $data['consumo']['TipoConsumo'];			


            #### Carrega os dados do cliente nas variáves de sessão ####
           # $this->load->model('Cliente_model');
           # $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['consumo']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];
/*
            #### App_ServicoConsumo ####
            $data['servico'] = $this->Consumo_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++)
                        $data['servico'][$j]['SubtotalServico'] = number_format(($data['servico'][$j]['ValorConsumoServico'] * $data['servico'][$j]['QtdConsumoServico']), 2, ',', '.');
                }
            }
*/
            #### App_ProdutoConsumo ####
            $data['produto'] = $this->Consumo_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++)
                        $data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorConsumoProduto'] * $data['produto'][$j]['QtdConsumoProduto']), 2, ',', '.');
                }
            }
/*
            #### App_ParcelasPagaveis ####
            $data['parcelaspag'] = $this->Consumo_model->get_parcelaspag($id);
            if (count($data['parcelaspag']) > 0) {
                $data['parcelaspag'] = array_combine(range(1, count($data['parcelaspag'])), array_values($data['parcelaspag']));

                if (isset($data['parcelaspag'])) {

                    for($j=1; $j <= $data['consumo']['QtdParcelasConsumo']; $j++) {
                        $data['parcelaspag'][$j]['DataVencimentoPagaveis'] = $this->basico->mascara_data($data['parcelaspag'][$j]['DataVencimentoPagaveis'], 'barras');
                        $data['parcelaspag'][$j]['DataPagoPagaveis'] = $this->basico->mascara_data($data['parcelaspag'][$j]['DataPagoPagaveis'], 'barras');
                    }

                }
            }
*/           
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Consumo ####
        $this->form_validation->set_rules('DataConsumo', 'Data do Consumo', 'required|trim|valid_date');
        #$this->form_validation->set_rules('Consumo', 'Consumo', 'required|trim');
        #$this->form_validation->set_rules('TipoConsumo', 'Tipo de Consumo', 'required|trim');
        $this->form_validation->set_rules('ProfissionalConsumo', 'Profissional', 'required|trim');

		
		#$data['select']['TipoConsumo'] = $this->Tipoconsumo_model->select_tipoconsumo();
		$data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        #$data['select']['Servico'] = $this->Servico_model->select_servico();
        $data['select']['Produto'] = $this->Produto_model->select_produto();

        $data['titulo'] = 'Editar Consumo';
        $data['form_open_path'] = 'consumo/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
/*
        //if ($data['consumo']['ValorConsumo'] || $data['consumo']['ValorEntradaConsumo'] || $data['consumo']['ValorRestanteConsumo'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['consumo']['FormaPagamentoConsumo'] || $data['consumo']['QtdParcelasConsumo'] || $data['consumo']['DataVencimentoConsumo'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';



        #Ver uma solução melhor para este campo
        (!$data['consumo']['AprovadoConsumo']) ? $data['consumo']['AprovadoConsumo'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoConsumo' => $this->basico->radio_checked($data['consumo']['AprovadoConsumo'], 'Consumo Quitada', 'NS'),
        );

        ($data['consumo']['AprovadoConsumo'] == 'S') ?
            $data['div']['AprovadoConsumo'] = '' : $data['div']['AprovadoConsumo'] = 'style="display: none;"';
			
			
		 (!$data['consumo']['QuitadoConsumo']) ? $data['consumo']['QuitadoConsumo'] = 'N' : FALSE;

        $data['radio'] = array(
            'QuitadoConsumo' => $this->basico->radio_checked($data['consumo']['QuitadoConsumo'], 'Consumo Quitada', 'NS'),
        );

        ($data['consumo']['QuitadoConsumo'] == 'S') ?
            $data['div']['QuitadoConsumo'] = '' : $data['div']['QuitadoConsumo'] = 'style="display: none;"';
*/

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
            $this->load->view('consumo/form_consumo', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Consumo ####
            $data['consumo']['DataConsumo'] = $this->basico->mascara_data($data['consumo']['DataConsumo'], 'mysql');
			#$data['consumo']['Consumo'] = $data['consumo']['Consumo'];
			$data['consumo']['TipoConsumo'] = $data['consumo']['TipoConsumo'];			

            $data['consumo']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['consumo']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['consumo']['anterior'] = $this->Consumo_model->get_consumo($data['consumo']['idApp_Consumo']);
            $data['update']['consumo']['campos'] = array_keys($data['consumo']);
            $data['update']['consumo']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['consumo']['anterior'],
                $data['consumo'],
                $data['update']['consumo']['campos'],
                $data['consumo']['idApp_Consumo'], TRUE);
            $data['update']['consumo']['bd'] = $this->Consumo_model->update_consumo($data['consumo'], $data['consumo']['idApp_Consumo']);
/*
            #### App_ServicoConsumo ####
            $data['update']['servico']['anterior'] = $this->Consumo_model->get_servico($data['consumo']['idApp_Consumo']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_ServicoConsumo');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {

                    $data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['servico']['inserir'][$j]['idApp_Consumo'] = $data['consumo']['idApp_Consumo'];

                    $data['update']['servico']['inserir'][$j]['ValorConsumoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorConsumoServico']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalServico']);
                }

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['ValorConsumoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorConsumoServico']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalServico']);
                }

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Consumo_model->set_servico_consumo($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] = $this->Consumo_model->update_servico_consumo($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Consumo_model->delete_servico_consumo($data['update']['servico']['excluir']);
            }
*/
            #### App_ProdutoConsumo ####
            $data['update']['produto']['anterior'] = $this->Consumo_model->get_produto($data['consumo']['idApp_Consumo']);
            if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

                if (isset($data['produto']))
                    $data['produto'] = array_values($data['produto']);
                else
                    $data['produto'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_ProdutoConsumo');

                $max = count($data['update']['produto']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['produto']['inserir'][$j]['idApp_Consumo'] = $data['consumo']['idApp_Consumo'];

                    $data['update']['produto']['inserir'][$j]['ValorConsumoProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorConsumoProduto']));
                    unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
                }

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['alterar'][$j]['ValorConsumoProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorConsumoProduto']));
                    unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
                }

                if (count($data['update']['produto']['inserir']))
                    $data['update']['produto']['bd']['inserir'] = $this->Consumo_model->set_produto_consumo($data['update']['produto']['inserir']);

                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Consumo_model->update_produto_consumo($data['update']['produto']['alterar']);

                if (count($data['update']['produto']['excluir']))
                    $data['update']['produto']['bd']['excluir'] = $this->Consumo_model->delete_produto_consumo($data['update']['produto']['excluir']);

            }
/*
            #### App_ParcelasRec ####
            $data['update']['parcelaspag']['anterior'] = $this->Consumo_model->get_parcelaspag($data['consumo']['idApp_Consumo']);
            if (isset($data['parcelaspag']) || (!isset($data['parcelaspag']) && isset($data['update']['parcelaspag']['anterior']) ) ) {

                if (isset($data['parcelaspag']))
                    $data['parcelaspag'] = array_values($data['parcelaspag']);
                else
                    $data['parcelaspag'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['parcelaspag'] = $this->basico->tratamento_array_multidimensional($data['parcelaspag'], $data['update']['parcelaspag']['anterior'], 'idApp_ParcelasPagaveis');

                $max = count($data['update']['parcelaspag']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelaspag']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['update']['parcelaspag']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelaspag']['inserir'][$j]['idApp_Consumo'] = $data['consumo']['idApp_Consumo'];
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
                    $data['update']['parcelaspag']['bd']['inserir'] = $this->Consumo_model->set_parcelaspag($data['update']['parcelaspag']['inserir']);

                if (count($data['update']['parcelaspag']['alterar']))
                    $data['update']['parcelaspag']['bd']['alterar'] =  $this->Consumo_model->update_parcelaspag($data['update']['parcelaspag']['alterar']);

                if (count($data['update']['parcelaspag']['excluir']))
                    $data['update']['parcelaspag']['bd']['excluir'] = $this->Consumo_model->delete_parcelaspag($data['update']['parcelaspag']['excluir']);

            }
*/          

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_Consumo'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['consumo']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consumo/form_consumo', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consumo'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consumo', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'relatorio/consumo/' . $data['msg']);
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

                $this->Consumo_model->delete_consumo($id);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'relatorio/consumo/' . $data['msg']);
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


        //$_SESSION['Consumo'] = $this->Consumo_model->get_cliente($id, TRUE);
        //$_SESSION['Consumo']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Consumo_model->list_consumo($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Consumo_model->list_consumo($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('consumo/list_consumo', $data, TRUE);
        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('consumo/tela_consumo', $data);

        $this->load->view('basico/footer');
    }

    public function listarBKP($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Consumo'] = $this->Consumo_model->get_cliente($id, TRUE);
        $_SESSION['Consumo']['idApp_Cliente'] = $id;
        $data['query'] = $this->Consumo_model->list_consumo(TRUE, TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('consumo/list_consumo', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('consumo/tela_consumo', $data);

        $this->load->view('basico/footer');
    }

}
