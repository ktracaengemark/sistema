<?php
#controlador de Login
defined('BASEPATH') OR exit('No direct script access allowed');
class Tratamentos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Tratamentos_model', 'Cliente_model'));
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
        $this->load->view('tratamentos/tela_index', $data);
        #load footer view
        $this->load->view('basico/footer');
    }
    public function cadastrar($idApp_Cliente = NULL, $idApp_ContatoCliente = NULL) {
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Tratamentos',
            'idApp_Agenda',
            'idApp_Cliente',
            'Data',
            'HoraInicio',
            'HoraFim',
            'Paciente',
            'idTab_TipoTratamentos',
            'idApp_ContatoCliente',
            'idApp_Profissional',
            'Procedimento',
            'Obs',
                ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.


        $data['servico'] = quotes_to_entities($this->input->post(array(
            'SCount',
            'idTab_Servico1',
            'ValorServVenda1',
        ), TRUE));


        $data['servico'] = array();

        $data['produto'] = quotes_to_entities($this->input->post(array(
            'PCount',
            'idTab_Produto1',
            'ValorProdVenda1',
            'Quantidade1',
        ), TRUE));

		$data['produto'] = array();

        $data['orcamento']['OrcamentoTotal'] = $this->input->post('OrcamentoTotal');
        (!$this->input->post('SCount')) ? $data['servico']['SCount'] = 1 : $data['servico']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['produto']['PCount'] = 1 : $data['produto']['PCount'] = $this->input->post('PCount');

        //$data['lista']['Servicos'] = $this->Tratamentos_model->lista_servicos();
        //$data['lista']['Produtos'] = $this->Tratamentos_model->lista_produtos();

        /*
        echo $data['lista']['Servicos']['1'];
              echo '<br>';
              echo "<pre>";
              print_r($data['lista']['Servicos']);
              echo "</pre>";
              exit();
         */
        $sq = '';
        if ($data['servico']['SCount']>1) {

            $j=1;
            for($i=1;$i<=$data['servico']['SCount'];$i++) {

                if ($this->input->post('idTab_Servico'.$i)) {
                    $data['servico']['idTab_Servico'.$j] = $this->input->post('idTab_Servico'.$i);
                    //$data['servico']['ValorServVenda'.$j] = $data['lista']['Servicos'][$this->input->post('idTab_Servico'.$i)];
                    $data['servico']['ValorServVenda'.$j] = $this->input->post('ValorServVenda'.$i);

                    $sq = $sq . '("' . $this->input->post('idTab_Servico'.$i) . '", ';
                    //$sq = $sq . '\'' . $this->input->post('ValorServVenda'.$i) . '\'), ';
                    $sq = $sq . '"0.00"), ';

                    $j++;
                }

            }
            $data['servico']['SCount'] = $j-1;

        }
        else {

            $data['servico']['idTab_Servico1'] = $this->input->post('idTab_Servico1');
            $data['servico']['ValorServVenda1'] = $this->input->post('ValorServVenda1');
            $sq = $sq . '("' . $this->input->post('idTab_Servico1') . '", ';
            //$sq = $sq . '\'' . $this->input->post('ValorServVenda1') . '\'), ';
            $sq = $sq . '"0.00"), ';
            //$j=1;
            $data['servico']['SCount'] = 1;
        }
        $sq = substr($sq, 0, strlen($sq)-2);

        /*
              echo '<br>';
              echo "<pre>";
              print_r($data['servico']);
              echo "</pre>";
              exit();
          */
        $pq = '';
        if ($data['produto']['PCount']>1) {

            $j=1;
            for($i=0;$i<=$data['produto']['PCount'];$i++) {

                if ($this->input->post('idTab_Produto'.$i)) {
                    $data['produto']['idTab_Produto'.$j] = $this->input->post('idTab_Produto'.$i);
                    $data['produto']['ValorProdVenda'.$j] = $this->input->post('ValorProdVenda'.$i);
                    $data['produto']['Quantidade'.$j] = $this->input->post('Quantidade'.$i);
                    $data['produto']['SubtotalProduto'.$j] = $this->input->post('SubtotalProduto'.$i);

                    $pq = $pq . '(\'' . $this->input->post('idTab_Produto'.$i) . '\', ';
                    //$pq = $pq . '\'' . $this->input->post('ValorProdVenda'.$i) . '\', ';
                    $pq = $pq . '\'0.00\', ';
                    $pq = $pq . '\'' . $this->input->post('Quantidade'.$i) . '\'), ';

                    $j++;

                }

            }
            $data['produto']['PCount'] = $j-1;
            //echo '<br>';
            //exit();

        }
        else {

            $data['produto']['idTab_Produto1'] = $this->input->post('idTab_Produto1');
            $data['produto']['ValorProdVenda1'] = $this->input->post('ValorProdVenda1');
            $data['produto']['Quantidade1'] = $this->input->post('Quantidade1');
            $data['produto']['SubtotalProduto1'] = $this->input->post('SubtotalProduto1');
            $pq = $pq . '(\'' . $this->input->post('idTab_Produto1') . '\', ';
            //$pq = $pq . '\'' . $this->input->post('ValorProdVenda1') . '\', ';
            $pq = $pq . '\'0.00\', ';
            $pq = $pq . '\'' . $this->input->post('Quantidade1') . '\'), ';

            $data['produto']['PCount'] = 1;
        }
        $pq = substr($pq, 0, strlen($pq)-2);

        /*
              echo '<br>';
              echo "<pre>";
              print_r($data['produto']);
              echo "</pre>";
              exit();
        */

        //Fim do trecho de código que dá pra melhorar

        if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
        }

        if ($idApp_ContatoCliente) {
            $data['query']['idApp_ContatoCliente'] = $idApp_ContatoCliente;
            $data['query']['Paciente'] = 'D';
        }

        if (isset($_SESSION['agenda'])) {
            $data['query']['Data'] = date('d/m/Y', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraInicio'] = date('H:i', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraFim'] = date('H:i', $_SESSION['agenda']['HoraFim']);
        }
        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
        $this->form_validation->set_rules('idTab_Servico1', 'Produto', 'required|trim');
        $this->form_validation->set_rules('idTab_Produto1', 'Serviço', 'required|trim');
        $this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');
        $data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
        $data['select']['TipoTratamentos'] = $this->Basico_model->select_tipo_tratamentos();
        $data['select']['Profissional'] = $this->Basico_model->select_profissional();
        $data['select']['Servico'] = $this->Basico_model->select_servico();
        $data['select']['Produto'] = $this->Basico_model->select_produto();
        $data['select']['ContatoCliente'] = $this->Tratamentos_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );

        $data['titulo'] = 'Orçamento/Plano de Tratamento';
        $data['form_open_path'] = 'tratamentos/cadastrar';
        $data['panel'] = 'primary';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['metodo'] = 1;
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);



		if ($data['query']['Obs'])
            $data['collapse'] = '';

        else
            $data['collapse'] = 'class="collapse"';

        #$data['sidebar'] = 'col-sm-3 col-md-2';
        #$data['main'] = 'col-sm-7 col-md-8';





        #run form validation
        if ($this->form_validation->run() === FALSE) {
        //if (1==1) {
            $this->load->view('tratamentos/form_tratamentos', $data);
        } else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            $data['query']['idTab_Status'] = 1;
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            /*
             * FALTA FAZER UM ESQUEMA PARA ARMAZENAR NO LOG OS DADOS DOS CAMPOS ADICIONADOS DINAMICAMENTE
             */

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            $data['idApp_Tratamentos'] = $this->Tratamentos_model->set_tratamentos($data['query']);
            unset($_SESSION['Agenda']);

            if ($data['idApp_Tratamentos'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                $this->basico->erro($msg);
                $this->load->view('tratamentos/form_tratamentos', $data);
            } else {

                $this->Tratamentos_model->set_dados_dinamicos('App_Servico','idTab_Servico, ValorServVenda',$sq);
                $this->Tratamentos_model->set_dados_dinamicos('App_Produto','idTab_Produto, ValorProdVenda, Quantidade',$pq);
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Tratamentos'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Tratamentos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';
                //redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }
        $this->load->view('basico/footer');
    }
    public function alterar($idApp_Cliente = FALSE, $idApp_Tratamentos = FALSE) {
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
        $data['query'] = $this->input->post(array(
            'idApp_Tratamentos',
            'idApp_Agenda',
            'idApp_Cliente',
            'Data',
            'HoraInicio',
            'HoraFim',
            'idTab_Status',
            'Paciente',
            'idApp_ContatoCliente',
            'idApp_Profissional',
            'Procedimento',
            'Obs',
                ), TRUE);
        if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
        }

        if ($idApp_Tratamentos) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $data['query'] = $this->Tratamentos_model->get_tratamentos($idApp_Tratamentos);
            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);
            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
        }
        else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
        }

        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            $data['readonly'] = 'readonly';
            $data['datepicker'] = '';
            $data['timepicker'] = '';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }
        #echo $data['query']['DataInicio'];
        #$data['query']['idApp_Agenda'] = 1;
        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
        #$this->form_validation->set_rules('idTab_TipoTratamentos', 'Tipo de Tratamentos', 'required|trim');
        $this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');
        $data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoTratamentos'] = $this->Basico_model->select_tipo_tratamentos();
        $data['select']['Profissional'] = $this->Basico_model->select_profissional();
        $data['select']['ContatoCliente'] = $this->Tratamentos_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );

        $data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
        //echo '<br><br><br><br>================================== '.$data['query']['idTab_Status'];

        $data['titulo'] = 'Editar Sessão';
        $data['form_open_path'] = 'tratamentos/alterar';
        #$data['readonly'] = '';
        #$data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		if ($data['query']['Obs'])
            $data['collapse'] = '';

        else
            $data['collapse'] = 'class="collapse"';


        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('tratamentos/form_tratamentos', $data);
        } else {

            #echo '<br><br><br><br>================================== '.$data['query']['idTab_Status'];
            #exit();

            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            //exit();
            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
            $data['anterior'] = $this->Tratamentos_model->get_tratamentos($data['query']['idApp_Tratamentos']);
            $data['campos'] = array_keys($data['query']);
            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Tratamentos'], TRUE);
            unset($_SESSION['Agenda']);

            if ($data['auditoriaitem'] && $this->Tratamentos_model->update_tratamentos($data['query'], $data['query']['idApp_Tratamentos']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'tratamentos/listar/' . $data['query']['idApp_Tratamentos'] . $data['msg']);
                exit();
            } else {
                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Tratamentos', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
                //redirect(base_url() . 'tratamentos/listar/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }
        $this->load->view('basico/footer');
    }
    public function listar($idApp_Cliente = NULL) {
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
        if ($idApp_Cliente) {
            $data['resumo'] = $this->Cliente_model->get_cliente($idApp_Cliente);
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
        }

        $data['titulo'] = 'Listar Sessões';
        $data['panel'] = 'primary';
        $data['novo'] = '';
        $data['metodo'] = 4;
        $data['query'] = array();
        $data['proxima'] = $this->Tratamentos_model->lista_tratamentos_proxima($idApp_Cliente);
        $data['anterior'] = $this->Tratamentos_model->lista_tratamentos_anterior($idApp_Cliente);
        #$data['tela'] = $this->load->view('tratamentos/list_tratamentos', $data, TRUE);
        #$data['resumo'] = $this->Cliente_model->get_cliente($data['Cliente']['idApp_Cliente']);
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        $this->load->view('tratamentos/list_tratamentos', $data);
        $this->load->view('basico/footer');
    }
    /*
     * Cadastrar/Alterar Eventos
     */
    public function cadastrar_evento($idApp_Cliente = NULL, $idApp_Agenda = NULL) {
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
        $data['query'] = quotes_to_entities($this->input->post(array(
                    'idApp_Tratamentos',
                    'idApp_Agenda',
                    'Data',
                    'HoraInicio',
                    'HoraFim',
                    'Evento',
                    'Obs',
                        ), TRUE));
        if ($this->input->get('start') && $this->input->get('end')) {
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
        $data['titulo'] = 'Agendar Evento';
        $data['form_open_path'] = 'tratamentos/cadastrar_evento';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['evento'] = 1;
        $data['readonly'] = '';
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('tratamentos/form_evento', $data);
        } else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            $data['idApp_Tratamentos'] = $this->Tratamentos_model->set_tratamentos($data['query']);
            if ($data['idApp_Tratamentos'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                $this->basico->erro($msg);
                $this->load->view('tratamentos/form_tratamentos', $data);
            } else {
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Tratamentos'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Tratamentos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';
                //redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }
        $this->load->view('basico/footer');
    }
    public function alterar_evento($idApp_Tratamentos = FALSE) {
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
        $data['query'] = $this->input->post(array(
            'idApp_Tratamentos',
            'idApp_Agenda',
            'Data',
            'HoraInicio',
            'HoraFim',
            'Evento',
            'Obs',
                ), TRUE);
        if ($idApp_Tratamentos) {
            $data['query'] = $this->Tratamentos_model->get_tratamentos($idApp_Tratamentos);
            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);
            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
        }
        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            $data['readonly'] = 'readonly';
            $data['datepicker'] = '';
            $data['timepicker'] = '';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
        $data['titulo'] = 'Agendar Evento';
        $data['form_open_path'] = 'tratamentos/alterar_evento';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['evento'] = 1;
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('tratamentos/form_evento', $data);
        } else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            //exit();
            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
            $data['anterior'] = $this->Tratamentos_model->get_tratamentos($data['query']['idApp_Tratamentos']);
            $data['campos'] = array_keys($data['query']);
            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Tratamentos'], TRUE);
            if ($data['auditoriaitem'] && $this->Tratamentos_model->update_tratamentos($data['query'], $data['query']['idApp_Tratamentos']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'tratamentos/listar/' . $data['query']['idApp_Tratamentos'] . $data['msg']);
                exit();
            } else {
                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Tratamentos', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
                //redirect(base_url() . 'tratamentos/listar/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }
        $this->load->view('basico/footer');
    }
}
