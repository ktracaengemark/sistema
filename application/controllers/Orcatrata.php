<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrata extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Orcatrata_model', 'Profissional_model', 'Formapag_model', 'Cliente_model'));
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

    public function cadastrar($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            'idApp_Cliente',
            'DataOrca',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ServicoConcluido',
            'DataConclusao',
            'DataRetorno',
            'ValorOrca',
            'ValorEntradaOrca',
            'ValorRestanteOrca',
            'FormaPagamento',
            'QtdParcelasOrca',
            'DataVencimentoOrca',
            'ObsOrca',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');

        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
                $data['servico'][$j]['ValorVendaServico'] = $this->input->post('ValorVendaServico' . $i);
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
                $data['produto'][$j]['ValorVendaProduto'] = $this->input->post('ValorVendaProduto' . $i);
                $data['produto'][$j]['QtdVendaProduto'] = $this->input->post('QtdVendaProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
                $j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('DataProcedimento' . $i) || $this->input->post('Profissional' . $i) ||
                    $this->input->post('Procedimento' . $i)) {
                $data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
                $data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;

        /*
        if ($data['count']['SCount'] >= 1) {

            $j = 0;
            for ($i = 0; $i <= $data['count']['SCount']; $i++) {

                if ($this->input->post('idTab_Servico' . $i)) {
                    $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
                    $data['servico'][$j]['ValorVendaServico'] = $this->input->post('ValorVendaServico' . $i);
                    $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
                    $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
                    echo $j++;
                }
            }
            $data['count']['SCount'] = $j - 1;

        } else {

            $data['servico'][0]['idTab_Servico'] = $this->input->post('idTab_Servico0');
            $data['servico'][0]['ValorVendaServico'] = $this->input->post('ValorVendaServico0');
            $data['servico'][0]['ObsServico'] = $this->input->post('ObsServico0');
            $data['servico'][0]['ConcluidoServico'] = $this->input->post('ConcluidoServico0');

        }
        /*
        echo '<br>';
        echo "<pre>";
        print_r($data['servico']);
        echo "</pre>";
        //exit ();
        */

        /*
        if ($data['count']['PCount'] >= 1) {

            $j = 0;
            for ($i = 0; $i <= $data['count']['PCount']; $i++) {

                if ($this->input->post('idTab_Produto' . $i)) {
                    $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                    $data['produto'][$j]['ValorVendaProduto'] = $this->input->post('ValorVendaProduto' . $i);
                    $data['produto'][$j]['QtdVendaProduto'] = $this->input->post('QtdVendaProduto' . $i);
                    $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
                    $j++;
                }
            }
            $data['count']['PCount'] = $j - 1;

        } else {

            $data['produto'][0]['idTab_Produto'] = $this->input->post('idTab_Produto0');
            $data['produto'][0]['ValorVendaProduto'] = $this->input->post('ValorVendaProduto0');
            $data['produto'][0]['QtdVendaProduto'] = $this->input->post('QtdVendaProduto0');
            $data['produto'][0]['SubtotalProduto'] = $this->input->post('SubtotalProduto0');

        }
        */
        if ($data['orcatrata']['QtdParcelasOrca'] > 0) {

            for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

                $data['parcelasrec'][$i]['ParcelaRecebiveis'] = $this->input->post('ParcelaRecebiveis' . $i);
                $data['parcelasrec'][$i]['ValorParcelaRecebiveis'] = $this->input->post('ValorParcelaRecebiveis' . $i);
                $data['parcelasrec'][$i]['DataVencimentoRecebiveis'] = $this->input->post('DataVencimentoRecebiveis' . $i);
                $data['parcelasrec'][$i]['ValorPagoRecebiveis'] = $this->input->post('ValorPagoRecebiveis' . $i);
                $data['parcelasrec'][$i]['DataPagoRecebiveis'] = $this->input->post('DataPagoRecebiveis' . $i);
                $data['parcelasrec'][$i]['QuitadoRecebiveis'] = $this->input->post('QuitadoRecebiveis' . $i);

            }

        }

        /*
        if ($data['count']['PMCount'] >= 1) {

            $j = 0;
            for ($i = 0; $i <= $data['count']['PMCount']; $i++) {

                if ($this->input->post('DataProcedimento' . $i) || $this->input->post('Profissional' . $i) ||
                        $this->input->post('Procedimento' . $i)) {
                    $data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
                    $data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                    $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
                    $j++;
                }

            }
            $data['count']['PMCount'] = $j - 1;

        } else {

            $data['procedimento'][0]['DataProcedimento'] = $this->input->post('DataProcedimento0');
            $data['procedimento'][0]['Profissional'] = $this->input->post('Profissional0');
            $data['procedimento'][0]['Procedimento'] = $this->input->post('Procedimento0');

        }
        */
        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
        $this->form_validation->set_rules('DataOrca', 'Data do Orçamento', 'required|trim|valid_date');
        #$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
        #$this->form_validation->set_rules('ParcelaRecebiveis', 'ParcelaRecebiveis', 'required|trim');
        #$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');

        $data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ServicoConcluido'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
        $data['select']['QuitadoRecebiveis'] = $this->Basico_model->select_status_sn();
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        $data['select']['Servico'] = $this->Basico_model->select_servico();
        $data['select']['Produto'] = $this->Basico_model->select_produto();

        $data['titulo'] = 'Cadastar Orçamento';
        $data['form_open_path'] = 'orcatrata/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';

        //if ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional'])
        if (isset($data['procedimento']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

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
            $this->load->view('orcatrata/form_orcatrata', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
            $data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
            $data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
            $data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
            $data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));

            $data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['orcatrata']['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['orcatrata']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### App_ServicoVenda ####
            if (isset($data['servico'])) {
                $max = count($data['servico']);
                for($j=1;$j<=$max;$j++) {
                    $data['servico'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['servico'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];

                    $data['servico'][$j]['ValorVendaServico'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorVendaServico']));
                }
                $data['servico']['idApp_ServicoVenda'] = $this->Orcatrata_model->set_servico_venda($data['servico']);
            }

            #### App_ProdutoVenda ####
            if (isset($data['produto'])) {
                $max = count($data['produto']);
                for($j=1;$j<=$max;$j++) {
                    $data['produto'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['produto'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];

                    $data['produto'][$j]['ValorVendaProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorVendaProduto']));
                    unset($data['produto'][$j]['SubtotalProduto']);
                }
                $data['produto']['idApp_ProdutoVenda'] = $this->Orcatrata_model->set_produto_venda($data['produto']);
            }

            #### App_ParcelasRec ####
            if (isset($data['parcelasrec'])) {
                $max = count($data['parcelasrec']);
                for($j=1;$j<=$max;$j++) {
                    $data['parcelasrec'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['parcelasrec'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['parcelasrec'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];

                    $data['parcelasrec'][$j]['ValorParcelaRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorParcelaRecebiveis']));
                    $data['parcelasrec'][$j]['DataVencimentoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimentoRecebiveis'], 'mysql');
                    $data['parcelasrec'][$j]['ValorPagoRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorPagoRecebiveis']));
                    $data['parcelasrec'][$j]['DataPagoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPagoRecebiveis'], 'mysql');

                }
                $data['parcelasrec']['idApp_ParcelasRecebiveis'] = $this->Orcatrata_model->set_parcelasrec($data['parcelasrec']);
            }

            #### App_Procedimento ####
            if (isset($data['procedimento'])) {
                $max = count($data['procedimento']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedimento'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedimento'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];

                    $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'mysql');

                }
                $data['procedimento']['idApp_Procedimento'] = $this->Orcatrata_model->set_procedimento($data['procedimento']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_OrcaTrata'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_orcatrata', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            'idApp_Cliente',
            'DataOrca',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ServicoConcluido',
            'DataConclusao',
            'DataRetorno',
            'ValorOrca',
            'ValorEntradaOrca',
            'ValorRestanteOrca',
            'FormaPagamento',
            'QtdParcelasOrca',
            'DataVencimentoOrca',
            'ObsOrca',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');


                $j = 1;
                for ($i = 1; $i <= $data['count']['SCount']; $i++) {

                    if ($this->input->post('idTab_Servico' . $i)) {
                        $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
                        $data['servico'][$j]['ValorVendaServico'] = $this->input->post('ValorVendaServico' . $i);
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
                        $data['produto'][$j]['ValorVendaProduto'] = $this->input->post('ValorVendaProduto' . $i);
                        $data['produto'][$j]['QtdVendaProduto'] = $this->input->post('QtdVendaProduto' . $i);
                        $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
                        $j++;
                    }
                }
                $data['count']['PCount'] = $j - 1;

                $j = 1;
                for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

                    if ($this->input->post('DataProcedimento' . $i) || $this->input->post('Profissional' . $i) ||
                            $this->input->post('Procedimento' . $i)) {
                        $data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
                        $data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                        $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
                        $j++;
                    }

                }
                $data['count']['PMCount'] = $j - 1;

        if ($data['orcatrata']['QtdParcelasOrca'] > 0) {

            for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

                $data['parcelasrec'][$i]['ParcelaRecebiveis'] = $this->input->post('ParcelaRecebiveis' . $i);
                $data['parcelasrec'][$i]['ValorParcelaRecebiveis'] = $this->input->post('ValorParcelaRecebiveis' . $i);
                $data['parcelasrec'][$i]['DataVencimentoRecebiveis'] = $this->input->post('DataVencimentoRecebiveis' . $i);
                $data['parcelasrec'][$i]['ValorPagoRecebiveis'] = $this->input->post('ValorPagoRecebiveis' . $i);
                $data['parcelasrec'][$i]['DataPagoRecebiveis'] = $this->input->post('DataPagoRecebiveis' . $i);
                $data['parcelasrec'][$i]['QuitadoRecebiveis'] = $this->input->post('QuitadoRecebiveis' . $i);

            }

        }

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data['parcelasrec']);
          echo "</pre>";
          //exit();
        */

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_OrcaTrata ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
            $data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
            $data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'barras');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'barras');
            $data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'barras');

            #### App_ServicoVenda ####
            $data['servico'] = $this->Orcatrata_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                echo $data['count']['SCount'] = count($data['servico']);
            }

            /*
            echo $data['count']['SCount'];
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";

            $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));

            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";

            exit();
            */

            #### App_ProdutoVenda ####
            $data['produto'] = $this->Orcatrata_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++)
                        $data['produto'][$j]['SubtotalProduto'] = $data['produto'][$j]['ValorVendaProduto'] * $data['produto'][$j]['QtdVendaProduto'];

                }
            }

            #### App_ParcelasRecebiveis ####
            $data['parcelasrec'] = $this->Orcatrata_model->get_parcelasrec($id);
            if (count($data['parcelasrec']) > 0) {
                $data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));

                if (isset($data['parcelasrec'])) {

                    for($j=1; $j <= $data['orcatrata']['QtdParcelasOrca']; $j++) {
                        $data['parcelasrec'][$j]['DataVencimentoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimentoRecebiveis'], 'barras');
                        $data['parcelasrec'][$j]['DataPagoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPagoRecebiveis'], 'barras');
                    }

                }
            }

            #### App_Procedimento ####
            $data['procedimento'] = $this->Orcatrata_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');

                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
        $this->form_validation->set_rules('DataOrca', 'Data do Orçamento', 'required|trim|valid_date');
        #$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
        #$this->form_validation->set_rules('ParcelaRecebiveis', 'ParcelaRecebiveis', 'required|trim');
        #$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');

        $data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ServicoConcluido'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
        $data['select']['QuitadoRecebiveis'] = $this->Basico_model->select_status_sn();
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        $data['select']['Servico'] = $this->Basico_model->select_servico();
        $data['select']['Produto'] = $this->Basico_model->select_produto();

        $data['titulo'] = 'Editar Orçamento';
        $data['form_open_path'] = 'orcatrata/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';
        /*
            echo $data['count']['PCount'];
            echo '<br>';
            echo "<pre>";
            print_r($data['produto']);
            echo "</pre>";
            exit ();
        */
        //if (isset($data['procedimento']) && ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional']))
        if ($data['count']['PMCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_orcatrata', $data);
        } else {

            ///////////////////////////////// Preparar dados para inserção novamente set Ex. Datas "mysql" ///////////////////////////////////////////////////////////////
            #### App_OrcaTrata ####
            $data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
            $data['orcatrata']['DataConcl'] = $this->basico->mascara_data($data['orcatrata']['DataConcl'], 'mysql');
            $data['orcatrata']['DataRet'] = $this->basico->mascara_data($data['orcatrata']['DataRet'], 'mysql');
            $data['orcatrata']['ObsOrca'] = nl2br($data['orcatrata']['ObsOrca']);
            $data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
            $data['orcatrata']['QtdParcelasOrca'] = $data['orcatrata']['QtdParcelasOrca'];
            $data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');

            #### App_Procedimento ####
            $data['procedimento']['DataProcedimento'] = $this->basico->mascara_data($data['procedimento']['DataProcedimento'], 'mysql');
            $data['procedimento']['Procedimento'] = nl2br($data['procedimento']['Procedimento']);

            ### App_ParcelasRec #####
            $data['parcelasrec']['ValorParcelaRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec']['ValorParcelaRecebiveis']));
            $data['parcelasrec']['ValorPagoRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec']['ValorPagoRecebiveis']));
            $data['parcelasrec']['DataVencimentoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec']['DataVencimentoRecebiveis'], 'mysql');
            $data['parcelasrec']['DataPagoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec']['DataPagoRecebiveis'], 'mysql');
            $data['parcelasrec']['QuitadoRecebiveis'] = $data['parcelasrec']['QuitadoRecebiveis'];

////////////////////////////////////////////////////  FIM   //////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['anterior1'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
            $data['anterior2'] = $this->Orcatrata_model->get_procedimento($data['orcatrata']['idApp_OrcaTrata']);
            $data['anterior3'] = $this->Orcatrata_model->get_parcelasrec($data['orcatrata']['idApp_OrcaTrata']);
            $data['campos1'] = array_keys($data['orcatrata']);
            $data['campos2'] = array_keys($data['procedimento']);
            $data['campos3'] = array_keys($data['parcelasrec']);
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['auditoriaitem1'] = $this->basico->set_log($data['anterior1'], $data['orcatrata'], $data['campos1'], $data['orcatrata']['idApp_OrcaTrata'], TRUE);
            $data['auditoriaitem2'] = $this->basico->set_log($data['anterior2'], $data['procedimento'], $data['campos2'], $data['procedimento']['idApp_Procedimento'], TRUE);
            $data['auditoriaitem3'] = $this->basico->set_log($data['anterior3'], $data['parcelasrec'], $data['campos3'], $data['parcelasrec']['idApp_ParcelasRec'], TRUE);
            /*
              echo '<br>';
              echo "<pre>";
              print_r($data);
              echo "</pre>";
              exit ();
             */
            if (
                    $data['auditoriaitem1'] && $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']) === FALSE
            //$data['auditoriaitem2'] && $this->Orcatrata_model->update_procedimento($data['procedimento'], $data['procedimento']['idApp_Procedimento']) === FALSE &&
            //$data['auditoriaitem3'] && $this->Orcatrata_model->update_parcelasrec($data['parcelasrec'], $data['parcelasrec']['idApp_ParcelasRec']) === FALSE
            ) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'orcatrata/form_orcatrata/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem1'] === FALSE || $data['auditoriaitem2'] === FALSE || $data['auditoriaitem3'] === FALSE) {
                    $data['msg'] = '';
                } else {

                    //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                $this->Orcatrata_model->update_procedimento($data['procedimento'], $data['procedimento']['idApp_Procedimento']);
                $this->Orcatrata_model->update_parcelasrec($data['parcelasrec'], $data['parcelasrec']['idApp_ParcelasRec']);
                redirect(base_url() . 'orcatrata/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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

        $data['query'] = $this->input->post(array(
            'idApp_OrcaTrata',
            'submit'
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Orcatrata_model->get_orcatrata($id);
            $data['query']['DataConcl'] = $this->basico->mascara_data($data['query']['DataConcl'], 'barras');
            $data['query']['OrcaTrataDataConcl'] = $this->basico->mascara_data($data['query']['OrcaTrataDataConcl'], 'barras');
            $data['query']['DataRet'] = $this->basico->mascara_data($data['query']['DataRet'], 'barras');
            $data['query']['OrcaTrataDataRet'] = $this->basico->mascara_data($data['query']['OrcaTrataDataRet'], 'barras');
            $data['query']['DataVenc'] = $this->basico->mascara_data($data['query']['DataVenc'], 'barras');
            $data['query']['OrcaTrataDataVenc'] = $this->basico->mascara_data($data['query']['OrcaTrataDataVenc'], 'barras');
            $data['query']['DataOrca'] = $this->basico->mascara_data($data['query']['DataOrca'], 'barras');
            $data['query']['OrcaTrataDataOrca'] = $this->basico->mascara_data($data['query']['OrcaTrataDataOrca'], 'barras');
        }

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        # $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        $data['titulo'] = 'Tem certeza que deseja excluir o registro abaixo?';
        $data['form_open_path'] = 'orcatrata/excluir';
        $data['readonly'] = 'readonly';
        $data['disabled'] = 'disabled';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;

        if ($data['orcatrata']['FormaPagamento'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['tela'] = $this->load->view('orcatrata/form_orcatrata', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';



        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/tela_orcatrata', $data);
        } else {

            if ($data['query']['idApp_OrcaTrata'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('orcatrata/form_orcatrata', $data);
            } else {

                $data['anterior'] = $this->Orcatrata_model->get_orcatrata($data['query']['idApp_OrcaTrata']);
                $data['campos'] = array_keys($data['anterior']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idApp_OrcaTrata'], FALSE, TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'DELETE', $data['auditoriaitem']);

                $this->Orcatrata_model->delete_orcatrata($data['query']['idApp_OrcaTrata']);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'orcatrata' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function listar($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['OrcaTrata'] = $this->Orcatrata_model->get_cliente($id, TRUE);
        $_SESSION['OrcaTrata']['idApp_Cliente'] = $id;
        $data['query'] = $this->Orcatrata_model->list_orcatrata(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('orcatrata/list_orcatrata', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('orcatrata/tela_orcatrata', $data);

        $this->load->view('basico/footer');
    }

}
