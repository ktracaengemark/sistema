<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Agenda_model', 'Relatorio_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        unset($_SESSION['agenda']);

    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));		
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'NomeProfissional',
			'NomeUsuario',
			'NomeCliente',
			'NomeClientePet',
			'NomeClienteDep',
			'idApp_Cliente',
			'idApp_ClientePet',
			'idApp_ClienteDep',
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
		$_SESSION['FiltroAlteraProcedimento']['NomeClientePet'] = $data['query']['NomeClientePet'];
		$_SESSION['FiltroAlteraProcedimento']['NomeClienteDep'] = $data['query']['NomeClienteDep'];
		$_SESSION['FiltroAlteraProcedimento']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['FiltroAlteraProcedimento']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
		$_SESSION['FiltroAlteraProcedimento']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];			
        $_SESSION['FiltroAlteraProcedimento']['Diaemp'] = $data['query']['Diaemp'];
        $_SESSION['FiltroAlteraProcedimento']['Mesvencemp'] = $data['query']['Mesvencemp'];
        $_SESSION['FiltroAlteraProcedimento']['Anoemp'] = $data['query']['Anoemp'];		
		$_SESSION['FiltroAlteraProcedimento']['Concluidoemp'] = $data['query']['Concluidoemp'];			
		$_SESSION['FiltroAlteraProcedimento']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
		$_SESSION['FiltroAlteraProcedimento']['NomeEmpresaCli'] = $data['query']['NomeEmpresaCli'];
		$_SESSION['FiltroAlteraProcedimento']['NomeUsuario'] = $data['query']['NomeUsuario'];
        //$_SESSION['log']['NomeUsuario'] = ($data['query']['NomeUsuario']) ? $data['query']['NomeUsuario'] : FALSE;
        $_SESSION['log']['NomeProfissional'] = ($data['query']['NomeProfissional']) ? $data['query']['NomeProfissional'] : FALSE;
        $_SESSION['log']['Compartilhar'] = ($data['query']['Compartilhar']) ? $data['query']['Compartilhar'] : FALSE;
        
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['ConcluidoProcedimento'] = array(
			'0' => '::Todos::',
			'S' => 'Sim',
			'N' => 'N�o',
        );
		
        $data['select']['ConcluidoSubProcedimento'] = array(
			'0' => '::Todos::',
			'S' => 'Sim',
			'N' => 'N�o',
        );		
		
        $data['select']['Concluidocli'] = array(
			'0' => 'TODOS',
			'S' => 'Sim',
			'N' => 'N�o',
        );

        $data['select']['Concluidoemp'] = array(
			'0' => 'TODOS',
			'S' => 'Sim',
			'N' => 'N�o',
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
		        
		$data['select']['Dia'] = $this->Agenda_model->select_dia();
		$data['select']['Mesvenc'] = $this->Agenda_model->select_mes();
		$data['select']['Diacli'] = $this->Agenda_model->select_dia();
		$data['select']['Mesvenccli'] = $this->Agenda_model->select_mes();
		$data['select']['Diaemp'] = $this->Agenda_model->select_dia();
		$data['select']['Mesvencemp'] = $this->Agenda_model->select_mes();		
		$data['select']['NomeCliente'] = $this->Agenda_model->select_cliente();
		$data['select']['NomeClientePet'] = $this->Agenda_model->select_clientepet();
		$data['select']['NomeClienteDep'] = $this->Agenda_model->select_clientedep();		
		$data['select']['idApp_Cliente'] = $this->Agenda_model->select_cliente();
		$data['select']['idApp_ClientePet'] = $this->Agenda_model->select_clientepet();
		$data['select']['idApp_ClienteDep'] = $this->Agenda_model->select_clientedep();
		$data['select']['NomeEmpresa'] = $this->Agenda_model->select_empresarec();
		$data['select']['NomeEmpresaCli'] = $this->Agenda_model->select_empresaenv();
        $data['select']['NomeUsuario'] = $this->Agenda_model->select_usuario();
        $data['select']['NomeProfissional'] = $this->Agenda_model->select_usuario();
		$data['select']['Procedimento'] = $this->Agenda_model->select_tarefa();
		$data['select']['Categoria'] = $this->Agenda_model->select_categoria();
		$data['select']['Compartilhar'] = $this->Agenda_model->select_compartilhar();
		
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
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['NomeClienteDep'] = $data['query']['NomeClienteDep'];
			$data['bd']['NomeClientePet'] = $data['query']['NomeClientePet'];
			$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$data['bd']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
			$data['bd']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
			$data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			
            $data['report'] = $this->Agenda_model->list1_procedimento($data['bd'],TRUE);
			/*
			$_SESSION['Tarefas'] = $data['report']->num_rows();
			echo "<pre>";
			print_r($_SESSION['Tarefas']);
			echo "</pre>";
			exit();
			*/

            $data['list1'] = $this->load->view('agenda/list1_procedimento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }
		
		$data['titulo2'] = 'Clientes';

        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Diacli'] = $data['query']['Diacli'];
			$data['bd']['Mesvenccli'] = $data['query']['Mesvenccli'];
			$data['bd']['Anocli'] = $data['query']['Anocli'];
			$data['bd']['Concluidocli'] = $data['query']['Concluidocli'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Agenda_model->list2_procedimentocli($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list2'] = $this->load->view('agenda/list2_procedimentocli', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }
		
		$data['titulo3'] = 'Mens. Env.';

        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['NomeEmpresaCli'] = $data['query']['NomeEmpresaCli'];
			$data['bd']['Diaemp'] = $data['query']['Diaemp'];
			$data['bd']['Mesvencemp'] = $data['query']['Mesvencemp'];
			$data['bd']['Anoemp'] = $data['query']['Ano'];
			$data['bd']['Concluidoemp'] = $data['query']['Concluidoemp'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Agenda_model->list3_mensagemenv($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list3'] = $this->load->view('agenda/list3_mensagemenv', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

		$data['titulo4'] = 'Mens. Rec.';

        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['NomeEmpresaCli'] = $data['query']['NomeEmpresaCli'];
			$data['bd']['Diaemp'] = $data['query']['Diaemp'];
			$data['bd']['Mesvencemp'] = $data['query']['Mesvencemp'];
			$data['bd']['Anoemp'] = $data['query']['Ano'];
			$data['bd']['Concluidoemp'] = $data['query']['Concluidoemp'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Agenda_model->list4_mensagemrec($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list4'] = $this->load->view('agenda/list4_mensagemrec', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }		
		

        $data['query']['estatisticas'] = $this->Agenda_model->resumo_estatisticas($_SESSION['log']['idSis_Usuario']);
        $data['query']['cliente_aniversariantes'] = $this->Agenda_model->cliente_aniversariantes($_SESSION['log']['idSis_Usuario']);
        $data['query']['contatocliente_aniversariantes'] = $this->Agenda_model->contatocliente_aniversariantes($_SESSION['log']['idSis_Usuario']);
        #$data['query']['profissional_aniversariantes'] = $this->Agenda_model->profissional_aniversariantes($_SESSION['log']['idSis_Usuario']);
		#$data['query']['contatoprof_aniversariantes'] = $this->Agenda_model->contatoprof_aniversariantes($_SESSION['log']['idSis_Usuario']);
		$data['query']['procedimento'] = $this->Agenda_model->procedimento($_SESSION['log']['idSis_Usuario']);
		$data['query']['procedempresa'] = $this->Agenda_model->procedempresa($_SESSION['log']['idSis_Usuario']);
		$data['query']['procedimentorec'] = $this->Agenda_model->procedimentorec($_SESSION['log']['idSis_Usuario']);	
	
		$this->load->view('agenda/tela_agenda', $data);

        #load footer view
        $this->load->view('basico/footer');
    
	}

}
