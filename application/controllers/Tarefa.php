<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Tarefa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Procedimento_model', 'Tarefa_model', 'Formapag_model'));
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


		$data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'NomeProfissional',
			'NomeUsuario',
			'NomeCliente',
			'NomeEmpresa',
			'NomeEmpresaCli',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'Dia',
			'Mesvenc',
			'Ano',
			'Diacli',
			'Mesvenccli',
			'Anocli',
			'Diaemp',
			'Mesvencemp',
			'Anoemp',			
			'ConcluidoProcedimento',
			'ConcluidoSubProcedimento',
			'Concluidocli',
			'Concluidoemp',			
            'Ordenamento',
            'Campo',
			'Prioridade',
			'Statustarefa',
			'Statussubtarefa',
			'Procedimento',
			'Compartilhar',
			'Categoria',
			'SubPrioridade',
			
        ), TRUE));

        $_SESSION['FiltroAlteraProcedimento']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraProcedimento']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraProcedimento']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
		$_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] = $data['query']['ConcluidoSubProcedimento'];
        $_SESSION['FiltroAlteraProcedimento']['Prioridade'] = $data['query']['Prioridade'];
		$_SESSION['FiltroAlteraProcedimento']['Statustarefa'] = $data['query']['Statustarefa'];
		$_SESSION['FiltroAlteraProcedimento']['Statussubtarefa'] = $data['query']['Statussubtarefa'];
		$_SESSION['FiltroAlteraProcedimento']['SubPrioridade'] = $data['query']['SubPrioridade'];
		$_SESSION['FiltroAlteraProcedimento']['Categoria'] = $data['query']['Categoria'];
		$_SESSION['FiltroAlteraProcedimento']['Procedimento'] = $data['query']['Procedimento'];
		$_SESSION['FiltroAlteraProcedimento']['Diacli'] = $data['query']['Diacli'];
        $_SESSION['FiltroAlteraProcedimento']['Mesvenccli'] = $data['query']['Mesvenccli'];
        $_SESSION['FiltroAlteraProcedimento']['Anocli'] = $data['query']['Anocli'];		
		$_SESSION['FiltroAlteraProcedimento']['Concluidocli'] = $data['query']['Concluidocli'];
		$_SESSION['FiltroAlteraProcedimento']['NomeCliente'] = $data['query']['NomeCliente'];		
        $_SESSION['FiltroAlteraProcedimento']['Diaemp'] = $data['query']['Diaemp'];
        $_SESSION['FiltroAlteraProcedimento']['Mesvencemp'] = $data['query']['Mesvencemp'];
        $_SESSION['FiltroAlteraProcedimento']['Anoemp'] = $data['query']['Anoemp'];		
		$_SESSION['FiltroAlteraProcedimento']['Concluidoemp'] = $data['query']['Concluidoemp'];			
		$_SESSION['FiltroAlteraProcedimento']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
		$_SESSION['FiltroAlteraProcedimento']['NomeEmpresaCli'] = $data['query']['NomeEmpresaCli'];
        $_SESSION['log']['NomeUsuario'] = ($data['query']['NomeUsuario']) ? $data['query']['NomeUsuario'] : FALSE;
        $_SESSION['log']['NomeProfissional'] = ($data['query']['NomeProfissional']) ? $data['query']['NomeProfissional'] : FALSE;
        $_SESSION['log']['Compartilhar'] = ($data['query']['Compartilhar']) ? $data['query']['Compartilhar'] : FALSE;
        
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['ConcluidoProcedimento'] = array(
			'0' => '::Todos::',
			'S' => 'Sim',
			'N' => 'Não',
        );
		
        $data['select']['ConcluidoSubProcedimento'] = array(
			'0' => '::Todos::',
			'S' => 'Sim',
			'N' => 'Não',
        );		
		
        $data['select']['Concluidocli'] = array(
			'0' => 'TODOS',
			'S' => 'Sim',
			'N' => 'Não',
        );

        $data['select']['Concluidoemp'] = array(
			'0' => 'TODOS',
			'S' => 'Sim',
			'N' => 'Não',
        );		

		$data['select']['Campo'] = array(
			'P.DataProcedimento' => 'Data do Inicio',
			'P.DataProcedimentoLimite' => 'Data da Concl.',
			'P.Compartilhar' => 'Quem Fazer',
			'P.idSis_Usuario' => 'Quem Cadastrou',			
			'P.ConcluidoProcedimento' => 'Concluido',
			'P.Categoria' => 'Categoria',
        );

        $data['select']['Ordenamento'] = array(
			'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );
		
        $data['select']['Prioridade'] = array (
            '0' => '::Todos::',
			'1' => 'Alta',
			'2' => 'Media',
			'3' => 'Baixa',
        );
		
        $data['select']['Statustarefa'] = array (
            '0' => '::Todos::',
			'1' => 'A Fazer',
			'2' => 'Fazendo',
			'3' => 'Feito',
        );		
		
        $data['select']['SubPrioridade'] = array (
            '0' => '::Todos::',
			'1' => 'Alta',
			'2' => 'Media',
			'3' => 'Baixa',
        );

        $data['select']['Statussubtarefa'] = array (
            '0' => '::Todos::',
			'1' => 'A Fazer',
			'2' => 'Fazendo',
			'3' => 'Feito',
        );		
		        
		$data['select']['Dia'] = $this->Tarefa_model->select_dia();
		$data['select']['Mesvenc'] = $this->Tarefa_model->select_mes();
		$data['select']['Diacli'] = $this->Tarefa_model->select_dia();
		$data['select']['Mesvenccli'] = $this->Tarefa_model->select_mes();
		$data['select']['Diaemp'] = $this->Tarefa_model->select_dia();
		$data['select']['Mesvencemp'] = $this->Tarefa_model->select_mes();		
		$data['select']['NomeCliente'] = $this->Tarefa_model->select_cliente();
		$data['select']['NomeEmpresa'] = $this->Tarefa_model->select_empresarec();
		$data['select']['NomeEmpresaCli'] = $this->Tarefa_model->select_empresaenv();
        $data['select']['NomeUsuario'] = $this->Tarefa_model->select_usuario();
        $data['select']['NomeProfissional'] = $this->Tarefa_model->select_usuario();
		$data['select']['Procedimento'] = $this->Tarefa_model->select_tarefa();
		$data['select']['Categoria'] = $this->Tarefa_model->select_categoria2();
		$data['select']['Compartilhar'] = $this->Tarefa_model->select_compartilhar();
		
        $data['titulo1'] = 'Tarefas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['ConcluidoSubProcedimento'] = $data['query']['ConcluidoSubProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['Prioridade'] = $data['query']['Prioridade'];
			$data['bd']['Statustarefa'] = $data['query']['Statustarefa'];
			$data['bd']['Statussubtarefa'] = $data['query']['Statussubtarefa'];
			$data['bd']['SubPrioridade'] = $data['query']['SubPrioridade'];			
			$data['bd']['Procedimento'] = $data['query']['Procedimento'];
			$data['bd']['Compartilhar'] = $data['query']['Compartilhar'];
			$data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			
            $data['report'] = $this->Tarefa_model->list1_procedimento($data['bd'],TRUE);
			/*
			$_SESSION['Tarefas'] = $data['report']->num_rows();
			echo "<pre>";
			print_r($_SESSION['Tarefas']);
			echo "</pre>";
			exit();
			*/

            $data['list1'] = $this->load->view('tarefa/list1_procedimento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }		

		$this->load->view('tarefa/tela_tarefa', $data);        
		//$this->load->view('tarefa/tela_index', $data);

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

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['tarefa'] = quotes_to_entities($this->input->post(array(
            #### App_Procedimento ####
            'idApp_Procedimento',           
            'Procedimento',
			'DataProcedimento',
			'DataProcedimentoLimite',
            'ConcluidoProcedimento',
			'Prioridade',
			'Statustarefa',
			'Compartilhar',
			'Categoria',
			#'ProfissionalProcedimento',
            #'Rotina',
            #'DataConclusao',
            #'DataRetorno',           
            
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

       
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

        //Data de hoje como default
        (!$data['tarefa']['DataProcedimento']) ? $data['tarefa']['DataProcedimento'] = date('d/m/Y', time()) : FALSE;
		#(!$data['tarefa']['DataProcedimentoLimite']) ? $data['tarefa']['DataProcedimentoLimite'] = date('d/m/Y', time()) : FALSE;
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$data['tarefa']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'];
		}else{
			if(!$data['tarefa']['Compartilhar']){
				$data['tarefa']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'];
			}else{
				FALSE;
			}
		}
			//($_SESSION['log']['idSis_Empresa'] == 5) ? $data['tarefa']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'] : FALSE;
			
			//(!$data['tarefa']['Compartilhar']) ? $data['tarefa']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'] : FALSE;

		
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('DataSubProcedimento' . $i) || $this->input->post('DataSubProcedimentoLimite' . $i) ||
				$this->input->post('Prioridade' . $i) || $this->input->post('Statussubtarefa' . $i) || $this->input->post('SubProcedimento' . $i)) {
                $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->input->post('DataSubProcedimento' . $i);
                $data['procedtarefa'][$j]['DataSubProcedimentoLimite'] = $this->input->post('DataSubProcedimentoLimite' . $i);
				$data['procedtarefa'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
                $data['procedtarefa'][$j]['Statussubtarefa'] = $this->input->post('Statussubtarefa' . $i);
				$data['procedtarefa'][$j]['SubProcedimento'] = $this->input->post('SubProcedimento' . $i);
				$data['procedtarefa'][$j]['ConcluidoSubProcedimento'] = $this->input->post('ConcluidoSubProcedimento' . $i);
                $data['procedtarefa'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
        #$data['select']['Rotina'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoSubProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['Compartilhar'] = $this->Procedimento_model->select_compartilhar();
		$data['select']['Categoria'] = $this->Tarefa_model->select_categoria();
		$data['select']['Prioridade'] = array (
            '1' => 'Alta',
            '2' => 'Media',
			'3' => 'Baixa',
        );
		$data['select']['Statustarefa'] = array (
            '1' => 'A Fazer',
            '2' => 'Fazendo',
			'3' => 'Feito',
        );
		$data['select']['Statussubtarefa'] = array (
            '1' => 'A Fazer',
            '2' => 'Fazendo',
			'3' => 'Feito',
        );		
        #$data['select']['Profissional'] = $this->Profissional_model->select_profissional();

        $data['titulo'] = 'Cadastar Tarefa';
        $data['form_open_path'] = 'tarefa/cadastrar';
        $data['readonly'] = '';
		$data['display'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['procedtarefa'][0]['DataSubProcedimento'] || $data['procedtarefa'][0]['Profissional'])
        if (isset($data['procedtarefa']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;

		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
        #Ver uma solução melhor para este campo
        (!$data['tarefa']['ConcluidoProcedimento']) ? $data['tarefa']['ConcluidoProcedimento'] = 'N' : FALSE;

        $data['radio'] = array(
            'ConcluidoProcedimento' => $this->basico->radio_checked($data['tarefa']['ConcluidoProcedimento'], 'Procedimento Aprovado', 'NS'),
        );

        ($data['tarefa']['ConcluidoProcedimento'] == 'S') ?
            $data['div']['ConcluidoProcedimento'] = '' : $data['div']['ConcluidoProcedimento'] = 'style="display: none;"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

		$data['q_categoria'] = $this->Tarefa_model->list_categoria($_SESSION['log'], TRUE);
		$data['list_categoria'] = $this->load->view('tarefa/list_categoria', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Procedimento ####
        $this->form_validation->set_rules('Procedimento', 'Tarefa', 'required|trim');
		$this->form_validation->set_rules('DataProcedimento', 'Iniciar em', 'trim|valid_date');
        $this->form_validation->set_rules('DataProcedimentoLimite', 'Concluir em', 'trim|valid_date');
        $this->form_validation->set_rules('Categoria', 'Categoria', 'required|trim');
		if($_SESSION['log']['idSis_Empresa'] != 5){
			$this->form_validation->set_rules('Compartilhar', 'Quem Fazer', 'required|trim');
		}	
		//$this->form_validation->set_rules('Prioridade', 'Prioridade', 'required|trim');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
		
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
            #### App_Procedimento ####
            $data['tarefa']['DataProcedimento'] = $this->basico->mascara_data($data['tarefa']['DataProcedimento'], 'mysql');
            $data['tarefa']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['tarefa']['DataProcedimentoLimite'], 'mysql');
			#$data['tarefa']['DataConclusao'] = $this->basico->mascara_data($data['tarefa']['DataConclusao'], 'mysql');
            #$data['tarefa']['DataRetorno'] = $this->basico->mascara_data($data['tarefa']['DataRetorno'], 'mysql');
			$data['tarefa']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
			$data['tarefa']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['tarefa']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['tarefa']['TipoProcedimento'] = 5;
            $data['tarefa']['idApp_Procedimento'] = $this->Tarefa_model->set_tarefa($data['tarefa']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### App_SubProcedimento ####
            if (isset($data['procedtarefa'])) {
                $max = count($data['procedtarefa']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedtarefa'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['procedtarefa'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['procedtarefa'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedtarefa'][$j]['TipoSubProcedimento'] = 5;
                    $data['procedtarefa'][$j]['idApp_Procedimento'] = $data['tarefa']['idApp_Procedimento'];
                    $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubProcedimento'], 'mysql');
					$data['procedtarefa'][$j]['DataSubProcedimentoLimite'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubProcedimentoLimite'], 'mysql');
                }
                $data['procedtarefa']['idApp_SubProcedimento'] = $this->Tarefa_model->set_procedtarefa($data['procedtarefa']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_Procedimento'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('tarefa/form_tarefa', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'tarefa/listar/' . $data['msg']);
				redirect(base_url() . 'tarefa' . $data['msg']);
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

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if ($_SESSION['log']['idSis_Empresa'] != 5)
			$data['tarefa'] = quotes_to_entities($this->input->post(array(
				#### App_Procedimento ####
				'idApp_Procedimento',			
				'Procedimento',
				'DataProcedimento',
				'DataProcedimentoLimite',
				'ConcluidoProcedimento',
				'Prioridade',
				'Statustarefa',
				'Categoria',
				'Compartilhar',
				#'ProfissionalProcedimento',
				#'Rotina',
				#'DataConclusao',
				#'DataRetorno',            
			), TRUE));
		else
			$data['tarefa'] = quotes_to_entities($this->input->post(array(
				#### App_Procedimento ####
				'idApp_Procedimento',			
				'Procedimento',
				'DataProcedimento',
				'DataProcedimentoLimite',
				'ConcluidoProcedimento',
				'Prioridade',
				'Statustarefa',
				'Categoria',
				#'ProfissionalProcedimento',
				#'Rotina',
				#'DataConclusao',
				#'DataRetorno',            
			), TRUE));			

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('DataSubProcedimento' . $i) || $this->input->post('DataSubProcedimentoLimite' . $i) ||
                    $this->input->post('Prioridade' . $i) || $this->input->post('Statussubtarefa' . $i) || $this->input->post('SubProcedimento' . $i)) {
                $data['procedtarefa'][$j]['idApp_SubProcedimento'] = $this->input->post('idApp_SubProcedimento' . $i);
                $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->input->post('DataSubProcedimento' . $i);
                $data['procedtarefa'][$j]['DataSubProcedimentoLimite'] = $this->input->post('DataSubProcedimentoLimite' . $i);
				$data['procedtarefa'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
                $data['procedtarefa'][$j]['Statussubtarefa'] = $this->input->post('Statussubtarefa' . $i);
				$data['procedtarefa'][$j]['SubProcedimento'] = $this->input->post('SubProcedimento' . $i);
				$data['procedtarefa'][$j]['ConcluidoSubProcedimento'] = $this->input->post('ConcluidoSubProcedimento' . $i);
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_Procedimento ####
            $_SESSION['Tarefa'] = $data['tarefa'] = $this->Tarefa_model->get_tarefa($id);
			$data['tarefa']['DataProcedimento'] = $this->basico->mascara_data($data['tarefa']['DataProcedimento'], 'barras');
            $data['tarefa']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['tarefa']['DataProcedimentoLimite'], 'barras');
			//$data['tarefa']['NomeCategoria'] = $data['tarefa']['NomeCategoria'];
			#$data['tarefa']['Prioridade'] = $this->basico->prioridade($data['tarefa']['Prioridade'], '123');
            #$data['tarefa']['DataRetorno'] = $this->basico->mascara_data($data['tarefa']['DataRetorno'], 'barras');
		/*
		echo '<br>';
        echo "<pre>";
        echo '<br>';
        print_r($data['tarefa']);
        echo '<br>';
        print_r($data['tarefa']['idCompartilhar']);
        echo '<br>';
        print_r($data['tarefa']['NomeCompartilhar']);
        echo '<br>';
        print_r($_SESSION['Tarefa']['idCompartilhar']);
        echo '<br>';
        print_r($_SESSION['Tarefa']['NomeCompartilhar']);
        echo "</pre>";
        exit ();            
		*/
            #### Carrega os dados do cliente nas variáves de sessão ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['tarefa']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_SubProcedimento ####
            $_SESSION['Procedtarefa'] = $data['procedtarefa'] = $this->Tarefa_model->get_procedtarefa($id);
            if (count($data['procedtarefa']) > 0) {
                $data['procedtarefa'] = array_combine(range(1, count($data['procedtarefa'])), array_values($data['procedtarefa']));
                $data['count']['PTCount'] = count($data['procedtarefa']);
                if (isset($data['procedtarefa'])) {
                    for($j=1; $j <= $data['count']['PTCount']; $j++) {
                        $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubProcedimento'], 'barras');
						$data['procedtarefa'][$j]['DataSubProcedimentoLimite'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubProcedimentoLimite'], 'barras');
						$_SESSION['Procedtarefa'][$j]['NomeCadastrou'] = $data['procedtarefa'][$j]['NomeCadastrou'];
					}
                }
            }
			
        }

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();        
        #$data['select']['Rotina'] = $this->Basico_model->select_status_sn();        
        $data['select']['ConcluidoSubProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['Compartilhar'] = $this->Procedimento_model->select_compartilhar();
		$data['select']['Categoria'] = $this->Tarefa_model->select_categoria();
		$data['select']['Prioridade'] = array (
            '1' => 'Alta',
            '2' => 'Media',
			'3' => 'Baixa',
        );
		$data['select']['Statustarefa'] = array (
            '1' => 'A Fazer',
            '2' => 'Fazendo',
			'3' => 'Feito',
        );
		$data['select']['Statussubtarefa'] = array (
            '1' => 'A Fazer',
            '2' => 'Fazendo',
			'3' => 'Feito',
        );		
        #$data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        

        $data['titulo'] = 'Editar Tarefa';
        $data['form_open_path'] = 'tarefa/alterar';
        $data['readonly'] = 'readonly=""';
        if($_SESSION['Tarefa']['idSis_Usuario'] == $_SESSION['log']['idSis_Usuario'] || $_SESSION['Tarefa']['CelularCadastrou'] == $_SESSION['log']['CelularUsuario']){
			$data['display'] = '';
		}else{
			$data['display'] = 'display:none';
		}
		$data['disabled'] = '';
		$data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['procedtarefa']) && ($data['procedtarefa'][0]['DataSubProcedimento'] || $data['procedtarefa'][0]['Profissional']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
        #Ver uma solução melhor para este campo
        (!$data['tarefa']['ConcluidoProcedimento']) ? $data['tarefa']['ConcluidoProcedimento'] = 'N' : FALSE;

        $data['radio'] = array(
            'ConcluidoProcedimento' => $this->basico->radio_checked($data['tarefa']['ConcluidoProcedimento'], 'Procedimento Aprovado', 'NS'),
        );

        ($data['tarefa']['ConcluidoProcedimento'] == 'S') ?
            $data['div']['ConcluidoProcedimento'] = '' : $data['div']['ConcluidoProcedimento'] = 'style="display: none;"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

		$data['q_categoria'] = $this->Tarefa_model->list_categoria($_SESSION['log'], TRUE);
		$data['list_categoria'] = $this->load->view('tarefa/list_categoria', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Procedimento ####
        $this->form_validation->set_rules('Procedimento', 'Tarefa', 'required|trim');
		$this->form_validation->set_rules('DataProcedimento', 'Iniciar em', 'trim|valid_date');        
		$this->form_validation->set_rules('DataProcedimentoLimite', 'Concluir em', 'trim|valid_date');
        $this->form_validation->set_rules('Categoria', 'Categoria', 'required|trim');
		if($_SESSION['log']['idSis_Empresa'] != 5){
			$this->form_validation->set_rules('Compartilhar', 'Quem Fazer', 'required|trim');
		}
		//$this->form_validation->set_rules('Prioridade', 'Prioridade', 'required|trim');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
        
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

			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Procedimento ####
            $data['tarefa']['DataProcedimento'] = $this->basico->mascara_data($data['tarefa']['DataProcedimento'], 'mysql');
            $data['tarefa']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['tarefa']['DataProcedimentoLimite'], 'mysql');
			#$data['tarefa']['DataConclusao'] = $this->basico->mascara_data($data['tarefa']['DataConclusao'], 'mysql');
            #$data['tarefa']['DataRetorno'] = $this->basico->mascara_data($data['tarefa']['DataRetorno'], 'mysql');
			#$data['tarefa']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            #$data['tarefa']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            #$data['tarefa']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['tarefa']['anterior'] = $this->Tarefa_model->get_tarefa($data['tarefa']['idApp_Procedimento']);
            $data['update']['tarefa']['campos'] = array_keys($data['tarefa']);
            $data['update']['tarefa']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['tarefa']['anterior'],
                $data['tarefa'],
                $data['update']['tarefa']['campos'],
                $data['tarefa']['idApp_Procedimento'], TRUE);
            $data['update']['tarefa']['bd'] = $this->Tarefa_model->update_tarefa($data['tarefa'], $data['tarefa']['idApp_Procedimento']);

            #### App_SubProcedimento ####
            $data['update']['procedtarefa']['anterior'] = $this->Tarefa_model->get_procedtarefa($data['tarefa']['idApp_Procedimento']);
            if (isset($data['procedtarefa']) || (!isset($data['procedtarefa']) && isset($data['update']['procedtarefa']['anterior']) ) ) {

                if (isset($data['procedtarefa']))
                    $data['procedtarefa'] = array_values($data['procedtarefa']);
                else
                    $data['procedtarefa'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['procedtarefa'] = $this->basico->tratamento_array_multidimensional($data['procedtarefa'], $data['update']['procedtarefa']['anterior'], 'idApp_SubProcedimento');

                $max = count($data['update']['procedtarefa']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedtarefa']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['procedtarefa']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['procedtarefa']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['procedtarefa']['inserir'][$j]['TipoSubProcedimento'] = 5;
                    $data['update']['procedtarefa']['inserir'][$j]['idApp_Procedimento'] = $data['tarefa']['idApp_Procedimento'];
                    $data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimento'], 'mysql');
					$data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimentoLimite'], 'mysql');
                }

                $max = count($data['update']['procedtarefa']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimento'], 'mysql');
					$data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimentoLimite'], 'mysql');
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

            //if ($data['idApp_Procedimento'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['tarefa']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('tarefa/form_tarefa', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'tarefa/listar/' . $data['msg']);
				
				unset($_SESSION['Tarefa'], $_SESSION['Procedtarefa']);
				redirect(base_url() . 'tarefa' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function baixadatarefa($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));


            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Procedimento ####
            $data['tarefa']['ConcluidoProcedimento'] = "S";
            $data['tarefa']['DataProcedimentoLimite'] = date('Y-m-d', time());
            $data['tarefa']['HoraProcedimentoLimite'] = date('H:i:s', time());

            $data['update']['tarefa']['anterior'] = $this->Tarefa_model->get_tarefa($id);
            $data['update']['tarefa']['campos'] = array_keys($data['tarefa']);
            $data['update']['tarefa']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['tarefa']['anterior'],
                $data['tarefa'],
                $data['update']['tarefa']['campos'],
                $id, TRUE);
            $data['update']['tarefa']['bd'] = $this->Tarefa_model->update_tarefa($data['tarefa'], $id);
			
            #### App_SubProcedimento ####
            $data['update']['procedtarefa']['alterar'] = $this->Tarefa_model->get_procedtarefa_posterior($id);
			
           
		   
		   if (isset($data['update']['procedtarefa']['alterar'])){

				$max = count($data['update']['procedtarefa']['alterar']);
				/*
				echo '<br>';
				echo "<pre>";
				echo '<br>';
				print_r($max);
				echo '<br>';
				print_r($data['update']['procedtarefa']['alterar']);
				echo "</pre>";
				exit (); 			
				*/
			                
				
				
				
				for($j=0;$j<$max;$j++) {
                    $data['update']['procedtarefa']['alterar'][$j]['ConcluidoSubProcedimento'] = "S";
                    $data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimentoLimite'] = date('Y-m-d', time());
                    $data['update']['procedtarefa']['alterar'][$j]['HoraSubProcedimentoLimite'] = date('H:i:s', time());
                }
                if (count($data['update']['procedtarefa']['alterar']))
                    $data['update']['procedtarefa']['bd']['alterar'] =  $this->Tarefa_model->update_procedtarefa($data['update']['procedtarefa']['alterar']);
            }
			
            if ($data['auditoriaitem'] && !$data['update']['tarefa']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('tarefa/form_tarefa', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'tarefa/listar/' . $data['msg']);
				redirect(base_url() . 'tarefa' . $data['msg']);
                exit();
            }
      

        $this->load->view('basico/footer');

    }

    public function alterar2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if ($_SESSION['log']['idSis_Empresa'] != 5)
			$data['tarefa'] = quotes_to_entities($this->input->post(array(
				#### App_Procedimento ####
				'idApp_Procedimento',			
				'Procedimento',
				'DataProcedimento',
				'DataProcedimentoLimite',
				'ConcluidoProcedimento',
				'Prioridade',
				'Statustarefa',
				'Categoria',
				'Compartilhar',
				#'ProfissionalProcedimento',
				#'Rotina',
				#'DataConclusao',
				#'DataRetorno',            
			), TRUE));
		else
			$data['tarefa'] = quotes_to_entities($this->input->post(array(
				#### App_Procedimento ####
				'idApp_Procedimento',			
				'Procedimento',
				'DataProcedimento',
				'DataProcedimentoLimite',
				'ConcluidoProcedimento',
				'Prioridade',
				'Statustarefa',
				'Categoria',
				#'ProfissionalProcedimento',
				#'Rotina',
				#'DataConclusao',
				#'DataRetorno',            
			), TRUE));			

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('DataSubProcedimento' . $i) || $this->input->post('DataSubProcedimentoLimite' . $i) ||
                    $this->input->post('Prioridade' . $i) || $this->input->post('Statussubtarefa' . $i) || $this->input->post('SubProcedimento' . $i)) {
                $data['procedtarefa'][$j]['idApp_SubProcedimento'] = $this->input->post('idApp_SubProcedimento' . $i);
                $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->input->post('DataSubProcedimento' . $i);
                $data['procedtarefa'][$j]['DataSubProcedimentoLimite'] = $this->input->post('DataSubProcedimentoLimite' . $i);
				$data['procedtarefa'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
                $data['procedtarefa'][$j]['Statussubtarefa'] = $this->input->post('Statussubtarefa' . $i);
				$data['procedtarefa'][$j]['SubProcedimento'] = $this->input->post('SubProcedimento' . $i);
				#$data['procedtarefa'][$j]['ConcluidoSubProcedimento'] = $this->input->post('ConcluidoSubProcedimento' . $i);
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_Procedimento ####
            $data['tarefa'] = $this->Tarefa_model->get_tarefa($id);
            $data['tarefa']['DataProcedimento'] = $this->basico->mascara_data($data['tarefa']['DataProcedimento'], 'barras');
            $data['tarefa']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['tarefa']['DataProcedimentoLimite'], 'barras');
			#$data['tarefa']['Prioridade'] = $this->basico->prioridade($data['tarefa']['Prioridade'], '123');
            #$data['tarefa']['DataRetorno'] = $this->basico->mascara_data($data['tarefa']['DataRetorno'], 'barras');
            

            #### Carrega os dados do cliente nas variáves de sessão ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['tarefa']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_SubProcedimento ####
            $data['procedtarefa'] = $this->Tarefa_model->get_procedtarefa($id);
            if (count($data['procedtarefa']) > 0) {
                $data['procedtarefa'] = array_combine(range(1, count($data['procedtarefa'])), array_values($data['procedtarefa']));
                $data['count']['PTCount'] = count($data['procedtarefa']);

                if (isset($data['procedtarefa'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++) {
                        $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubProcedimento'], 'barras');
						$data['procedtarefa'][$j]['DataSubProcedimentoLimite'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubProcedimentoLimite'], 'barras');
					}
                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Procedimento ####
        $this->form_validation->set_rules('Procedimento', 'Tarefa', 'required|trim');
		$this->form_validation->set_rules('DataProcedimento', 'Iniciar em', 'trim|valid_date');        
		$this->form_validation->set_rules('DataProcedimentoLimite', 'Concluir em', 'trim|valid_date');      
        $this->form_validation->set_rules('Categoria', 'Categoria', 'required|trim');
		if($_SESSION['log']['idSis_Empresa'] != 5){
			$this->form_validation->set_rules('Compartilhar', 'Quem Fazer', 'required|trim');
		}
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();        
        #$data['select']['Rotina'] = $this->Basico_model->select_status_sn();        
        #$data['select']['ConcluidoSubProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['Compartilhar'] = $this->Procedimento_model->select_compartilhar();
		$data['select']['Categoria'] = $this->Tarefa_model->select_categoria();
		$data['select']['Prioridade'] = array (
            '1' => 'Alta',
            '2' => 'Media',
			'3' => 'Baixa',
        );
		$data['select']['Statustarefa'] = array (
            '1' => 'A Fazer',
            '2' => 'Fazendo',
			'3' => 'Feito',
        );
		$data['select']['Statussubtarefa'] = array (
            '1' => 'A Fazer',
            '2' => 'Fazendo',
			'3' => 'Feito',
        );		
        #$data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        

        $data['titulo'] = 'Editar Tarefa';
        $data['form_open_path'] = 'tarefa/alterar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['procedtarefa']) && ($data['procedtarefa'][0]['DataSubProcedimento'] || $data['procedtarefa'][0]['Profissional']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
        #Ver uma solução melhor para este campo
        (!$data['tarefa']['ConcluidoProcedimento']) ? $data['tarefa']['ConcluidoProcedimento'] = 'N' : FALSE;

        $data['radio'] = array(
            'ConcluidoProcedimento' => $this->basico->radio_checked($data['tarefa']['ConcluidoProcedimento'], 'Procedimento Aprovado', 'NS'),
        );

        ($data['tarefa']['ConcluidoProcedimento'] == 'S') ?
            $data['div']['ConcluidoProcedimento'] = '' : $data['div']['ConcluidoProcedimento'] = 'style="display: none;"';


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
            $this->load->view('tarefa/form_tarefa2', $data);
        } else {

			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Procedimento ####
            $data['tarefa']['DataProcedimento'] = $this->basico->mascara_data($data['tarefa']['DataProcedimento'], 'mysql');
            $data['tarefa']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['tarefa']['DataProcedimentoLimite'], 'mysql');
			#$data['tarefa']['DataConclusao'] = $this->basico->mascara_data($data['tarefa']['DataConclusao'], 'mysql');
            #$data['tarefa']['DataRetorno'] = $this->basico->mascara_data($data['tarefa']['DataRetorno'], 'mysql');
			#$data['tarefa']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            #$data['tarefa']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            #$data['tarefa']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['tarefa']['anterior'] = $this->Tarefa_model->get_tarefa($data['tarefa']['idApp_Procedimento']);
            $data['update']['tarefa']['campos'] = array_keys($data['tarefa']);
            $data['update']['tarefa']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['tarefa']['anterior'],
                $data['tarefa'],
                $data['update']['tarefa']['campos'],
                $data['tarefa']['idApp_Procedimento'], TRUE);
            $data['update']['tarefa']['bd'] = $this->Tarefa_model->update_tarefa($data['tarefa'], $data['tarefa']['idApp_Procedimento']);

            #### App_SubProcedimento ####
            $data['update']['procedtarefa']['anterior'] = $this->Tarefa_model->get_procedtarefa($data['tarefa']['idApp_Procedimento']);
            if (isset($data['procedtarefa']) || (!isset($data['procedtarefa']) && isset($data['update']['procedtarefa']['anterior']) ) ) {

                if (isset($data['procedtarefa']))
                    $data['procedtarefa'] = array_values($data['procedtarefa']);
                else
                    $data['procedtarefa'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['procedtarefa'] = $this->basico->tratamento_array_multidimensional($data['procedtarefa'], $data['update']['procedtarefa']['anterior'], 'idApp_SubProcedimento');

                $max = count($data['update']['procedtarefa']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedtarefa']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['procedtarefa']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['procedtarefa']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['procedtarefa']['inserir'][$j]['TipoSubProcedimento'] = 5;
                    $data['update']['procedtarefa']['inserir'][$j]['idApp_Procedimento'] = $data['tarefa']['idApp_Procedimento'];
                    $data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimento'], 'mysql');
					$data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimentoLimite'], 'mysql');
                }

                $max = count($data['update']['procedtarefa']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimento'], 'mysql');
					$data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimentoLimite'], 'mysql');
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

            //if ($data['idApp_Procedimento'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['tarefa']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('tarefa/form_tarefa2', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'tarefa/listar/' . $data['msg']);
				#redirect(base_url() . 'agenda' . $data['msg']);
				redirect(base_url() . 'relatorio/tarefa' . $data['msg']);
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
				redirect(base_url() . 'tarefa/' . $data['msg']);
                exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

    public function excluir2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
        
                $this->Tarefa_model->delete_tarefa($id);

                $data['msg'] = '?m=1';

                #redirect(base_url() . 'tarefa/listar/' . $data['msg']);
				#redirect(base_url() . 'agenda/' . $data['msg']);
				redirect(base_url() . 'relatorio/tarefa' . $data['msg']);
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


        //$_SESSION['Procedimento'] = $this->Tarefa_model->get_cliente($id, TRUE);
        //$_SESSION['Procedimento']['idApp_Cliente'] = $id;
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


        //$_SESSION['Procedimento'] = $this->Tarefa_model->get_cliente($id, TRUE);
        #$_SESSION['Procedimento']['idApp_Cliente'] = $id;
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
