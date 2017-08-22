<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Tarefa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Tarefa_model', 'Profissional_model', 'Formapag_model'));
        $this->load->driver('session');

        
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

        $this->load->view('tarefa/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['tarefa'] = quotes_to_entities($this->input->post(array(
            #### App_Tarefa ####
            'idApp_Tarefa',           
            'DataTarefa',
			'DataPrazoTarefa',
            'ProfissionalTarefa',
            'TarefaConcluida',
            'Rotina',
            'Prioridade',
            'DataConclusao',
            'DataRetorno',           
            'ObsTarefa',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

       
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

        //Data de hoje como default
        (!$data['tarefa']['DataTarefa']) ? $data['tarefa']['DataTarefa'] = date('d/m/Y', time()) : FALSE;
		(!$data['tarefa']['DataPrazoTarefa']) ? $data['tarefa']['DataPrazoTarefa'] = date('d/m/Y', time()) : FALSE;
		
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('DataProcedtarefa' . $i) || $this->input->post('Profissional' . $i) ||
                    $this->input->post('Procedtarefa' . $i) || $this->input->post('ConcluidoProcedtarefa' . $i)) {
                $data['procedtarefa'][$j]['DataProcedtarefa'] = $this->input->post('DataProcedtarefa' . $i);
                $data['procedtarefa'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                $data['procedtarefa'][$j]['Procedtarefa'] = $this->input->post('Procedtarefa' . $i);
				$data['procedtarefa'][$j]['ConcluidoProcedtarefa'] = $this->input->post('ConcluidoProcedtarefa' . $i);
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Tarefa ####
        $this->form_validation->set_rules('DataTarefa', 'Tarefa Criada em', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataPrazoTarefa', 'Prazo para Conclusão', 'required|trim');
        #$this->form_validation->set_rules('ProfissionalTarefa', 'Profissional', 'required|trim');

        $data['select']['TarefaConcluida'] = $this->Basico_model->select_status_sn();
        $data['select']['Rotina'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedtarefa'] = $this->Basico_model->select_status_sn();
		$data['select']['Prioridade'] = $this->Basico_model->select_status_sn();
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional();

        $data['titulo'] = 'Cadastar Tarefa';
        $data['form_open_path'] = 'tarefa/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['procedtarefa'][0]['DataProcedtarefa'] || $data['procedtarefa'][0]['Profissional'])
        if (isset($data['procedtarefa']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo
        (!$data['tarefa']['TarefaConcluida']) ? $data['tarefa']['TarefaConcluida'] = 'N' : FALSE;

        $data['radio'] = array(
            'TarefaConcluida' => $this->basico->radio_checked($data['tarefa']['TarefaConcluida'], 'Tarefa Aprovado', 'NS'),
        );

        ($data['tarefa']['TarefaConcluida'] == 'S') ?
            $data['div']['TarefaConcluida'] = '' : $data['div']['TarefaConcluida'] = 'style="display: none;"';


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
            $this->load->view('tarefa/form_tarefa', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Tarefa ####
            $data['tarefa']['DataTarefa'] = $this->basico->mascara_data($data['tarefa']['DataTarefa'], 'mysql');
            $data['tarefa']['DataPrazoTarefa'] = $this->basico->mascara_data($data['tarefa']['DataPrazoTarefa'], 'mysql');
			$data['tarefa']['DataConclusao'] = $this->basico->mascara_data($data['tarefa']['DataConclusao'], 'mysql');
            $data['tarefa']['DataRetorno'] = $this->basico->mascara_data($data['tarefa']['DataRetorno'], 'mysql');
			$data['tarefa']['Empresa'] = $_SESSION['log']['Empresa'];            
            $data['tarefa']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['tarefa']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['tarefa']['idApp_Tarefa'] = $this->Tarefa_model->set_tarefa($data['tarefa']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### App_Procedtarefa ####
            if (isset($data['procedtarefa'])) {
                $max = count($data['procedtarefa']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedtarefa'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['procedtarefa'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedtarefa'][$j]['idApp_Tarefa'] = $data['tarefa']['idApp_Tarefa'];

                    $data['procedtarefa'][$j]['DataProcedtarefa'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataProcedtarefa'], 'mysql');
					

                }
                $data['procedtarefa']['idApp_Procedtarefa'] = $this->Tarefa_model->set_procedtarefa($data['procedtarefa']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_Tarefa'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('tarefa/form_tarefa', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Tarefa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Tarefa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'tarefa/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/tarefa/' . $data['msg']);
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
        $data['tarefa'] = quotes_to_entities($this->input->post(array(
            #### App_Tarefa ####
            'idApp_Tarefa',			
            'DataTarefa',
			'DataPrazoTarefa',
            'ProfissionalTarefa',
            'TarefaConcluida',
            'Rotina',
            'Prioridade',
            'DataConclusao',
            'DataRetorno',            
            'ObsTarefa',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('DataProcedtarefa' . $i) || $this->input->post('Profissional' . $i) ||
                    $this->input->post('Procedtarefa' . $i) || $this->input->post('ConcluidoProcedtarefa' . $i)) {
                $data['procedtarefa'][$j]['idApp_Procedtarefa'] = $this->input->post('idApp_Procedtarefa' . $i);
                $data['procedtarefa'][$j]['DataProcedtarefa'] = $this->input->post('DataProcedtarefa' . $i);
                $data['procedtarefa'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                $data['procedtarefa'][$j]['Procedtarefa'] = $this->input->post('Procedtarefa' . $i);
				$data['procedtarefa'][$j]['ConcluidoProcedtarefa'] = $this->input->post('ConcluidoProcedtarefa' . $i);
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_Tarefa ####
            $data['tarefa'] = $this->Tarefa_model->get_tarefa($id);
            $data['tarefa']['DataTarefa'] = $this->basico->mascara_data($data['tarefa']['DataTarefa'], 'barras');
            $data['tarefa']['DataPrazoTarefa'] = $this->basico->mascara_data($data['tarefa']['DataPrazoTarefa'], 'barras');
			$data['tarefa']['DataConclusao'] = $this->basico->mascara_data($data['tarefa']['DataConclusao'], 'barras');
            $data['tarefa']['DataRetorno'] = $this->basico->mascara_data($data['tarefa']['DataRetorno'], 'barras');
            

            #### Carrega os dados do cliente nas variáves de sessão ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['tarefa']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_Procedtarefa ####
            $data['procedtarefa'] = $this->Tarefa_model->get_procedtarefa($id);
            if (count($data['procedtarefa']) > 0) {
                $data['procedtarefa'] = array_combine(range(1, count($data['procedtarefa'])), array_values($data['procedtarefa']));
                $data['count']['PTCount'] = count($data['procedtarefa']);

                if (isset($data['procedtarefa'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
                        $data['procedtarefa'][$j]['DataProcedtarefa'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataProcedtarefa'], 'barras');
						

                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Tarefa ####
        $this->form_validation->set_rules('DataTarefa', 'Tarefa Criada em', 'required|trim|valid_date');        
		$this->form_validation->set_rules('DataPrazoTarefa', 'Prazo para Conclusão', 'required|trim');      
        #$this->form_validation->set_rules('ProfissionalTarefa', 'Profissional', 'required|trim');

        $data['select']['TarefaConcluida'] = $this->Basico_model->select_status_sn();        
        $data['select']['Rotina'] = $this->Basico_model->select_status_sn();        
        $data['select']['ConcluidoProcedtarefa'] = $this->Basico_model->select_status_sn();
		$data['select']['Prioridade'] = $this->Basico_model->select_status_sn();       
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        

        $data['titulo'] = 'Editar Tarefa';
        $data['form_open_path'] = 'tarefa/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['procedtarefa']) && ($data['procedtarefa'][0]['DataProcedtarefa'] || $data['procedtarefa'][0]['Profissional']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo
        (!$data['tarefa']['TarefaConcluida']) ? $data['tarefa']['TarefaConcluida'] = 'N' : FALSE;

        $data['radio'] = array(
            'TarefaConcluida' => $this->basico->radio_checked($data['tarefa']['TarefaConcluida'], 'Tarefa Aprovado', 'NS'),
        );

        ($data['tarefa']['TarefaConcluida'] == 'S') ?
            $data['div']['TarefaConcluida'] = '' : $data['div']['TarefaConcluida'] = 'style="display: none;"';


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
            $this->load->view('tarefa/form_tarefa', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Tarefa ####
            $data['tarefa']['DataTarefa'] = $this->basico->mascara_data($data['tarefa']['DataTarefa'], 'mysql');
            $data['tarefa']['DataPrazoTarefa'] = $this->basico->mascara_data($data['tarefa']['DataPrazoTarefa'], 'mysql');
			$data['tarefa']['DataConclusao'] = $this->basico->mascara_data($data['tarefa']['DataConclusao'], 'mysql');
            $data['tarefa']['DataRetorno'] = $this->basico->mascara_data($data['tarefa']['DataRetorno'], 'mysql');
			$data['tarefa']['Empresa'] = $_SESSION['log']['Empresa'];             

            $data['tarefa']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['tarefa']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['tarefa']['anterior'] = $this->Tarefa_model->get_tarefa($data['tarefa']['idApp_Tarefa']);
            $data['update']['tarefa']['campos'] = array_keys($data['tarefa']);
            $data['update']['tarefa']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['tarefa']['anterior'],
                $data['tarefa'],
                $data['update']['tarefa']['campos'],
                $data['tarefa']['idApp_Tarefa'], TRUE);
            $data['update']['tarefa']['bd'] = $this->Tarefa_model->update_tarefa($data['tarefa'], $data['tarefa']['idApp_Tarefa']);

            #### App_Procedtarefa ####
            $data['update']['procedtarefa']['anterior'] = $this->Tarefa_model->get_procedtarefa($data['tarefa']['idApp_Tarefa']);
            if (isset($data['procedtarefa']) || (!isset($data['procedtarefa']) && isset($data['update']['procedtarefa']['anterior']) ) ) {

                if (isset($data['procedtarefa']))
                    $data['procedtarefa'] = array_values($data['procedtarefa']);
                else
                    $data['procedtarefa'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['procedtarefa'] = $this->basico->tratamento_array_multidimensional($data['procedtarefa'], $data['update']['procedtarefa']['anterior'], 'idApp_Procedtarefa');

                $max = count($data['update']['procedtarefa']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedtarefa']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['update']['procedtarefa']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['procedtarefa']['inserir'][$j]['idApp_Tarefa'] = $data['tarefa']['idApp_Tarefa'];

                    $data['update']['procedtarefa']['inserir'][$j]['DataProcedtarefa'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataProcedtarefa'], 'mysql');
					
                }

                $max = count($data['update']['procedtarefa']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedtarefa']['alterar'][$j]['DataProcedtarefa'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataProcedtarefa'], 'mysql');

                }

                if (count($data['update']['procedtarefa']['inserir']))
                    $data['update']['procedtarefa']['bd']['inserir'] = $this->Tarefa_model->set_procedtarefa($data['update']['procedtarefa']['inserir']);

                if (count($data['update']['procedtarefa']['alterar']))
                    $data['update']['procedtarefa']['bd']['alterar'] =  $this->Tarefa_model->update_procedtarefa($data['update']['procedtarefa']['alterar']);

                if (count($data['update']['procedtarefa']['excluir']))
                    $data['update']['procedtarefa']['bd']['excluir'] = $this->Tarefa_model->delete_procedtarefa($data['update']['procedtarefa']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_Tarefa'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['tarefa']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('tarefa/form_tarefa', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Tarefa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Tarefa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'tarefa/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/tarefa/' . $data['msg']);
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
        
                $this->Tarefa_model->delete_tarefa($id);

                $data['msg'] = '?m=1';

                #redirect(base_url() . 'tarefa/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/tarefa/' . $data['msg']);
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


        //$_SESSION['Tarefa'] = $this->Tarefa_model->get_cliente($id, TRUE);
        //$_SESSION['Tarefa']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Tarefa_model->list_tarefa($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Tarefa_model->list_tarefa($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('tarefa/list_tarefa', $data, TRUE);
       # $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('tarefa/tela_tarefa', $data);

        $this->load->view('basico/footer');
    }

    public function listarBKP($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Tarefa'] = $this->Tarefa_model->get_cliente($id, TRUE);
        #$_SESSION['Tarefa']['idApp_Cliente'] = $id;
        $data['query'] = $this->Tarefa_model->list_tarefa(TRUE, TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('tarefa/list_tarefa', $data, TRUE);

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('tarefa/tela_tarefa', $data);

        $this->load->view('basico/footer');
    }

}
