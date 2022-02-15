<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
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
		
		#### Carrega os dados da Agenda nas vari�ves de sess�o do Whatsapp ####
		if ($_SESSION['log']['idSis_Empresa'] != 5){
			if(isset($_SESSION['bd_consulta']['Whatsapp']) && $_SESSION['bd_consulta']['Whatsapp'] == "S"){
				if(isset($_SESSION['Empresa']['ClienteAgenda']) && $_SESSION['Empresa']['ClienteAgenda'] == "S") {
					$nomecliente = '*'.$_SESSION['bd_consulta']['NomeCliente'].'*';
				}else{
					$nomecliente = FALSE;
				}
				if(isset($_SESSION['Empresa']['ProfAgenda']) && $_SESSION['Empresa']['ProfAgenda'] == "S") {
					$nomeprof = '*'.$_SESSION['bd_consulta']['Profissional'].'*';
				}else{
					$nomeprof = FALSE;
				}
				if(isset($_SESSION['Empresa']['DataAgenda']) && $_SESSION['Empresa']['DataAgenda'] == "S") {
					$dataagenda = '*'.$_SESSION['bd_consulta']['DataInicio'].' as '.$_SESSION['bd_consulta']['HoraInicio'].'*';
				}else{
					$dataagenda = FALSE;
				}
				if(isset($_SESSION['Empresa']['SiteAgenda']) && $_SESSION['Empresa']['SiteAgenda'] == "S") {
					$siteagenda = "https://enkontraki.com.br/".$_SESSION['Empresa']['Site'];
				}else{
					$siteagenda = FALSE;
				}
				$data['whatsapp_agenda'] = utf8_encode($_SESSION['Empresa']['TextoAgenda_1'].' '.$nomecliente. ' ' .$_SESSION['Empresa']['TextoAgenda_2']. ' ' . $nomeprof . ' ' .$_SESSION['Empresa']['TextoAgenda_3']. ' ' . $dataagenda . ' ' .$_SESSION['Empresa']['TextoAgenda_4']. ' ' . $siteagenda);
			}
		}
		
		$data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
			'id_ClientePet_Auto',
			'NomeClientePetAuto',
			'id_ClienteDep_Auto',
			'NomeClienteDepAuto',
        ), TRUE));		
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'NomeProfissional',
			'NomeUsuario',
			'NomeCliente',
			'NomeClientePet',
			'NomeClienteDep',
			'idApp_Cliente',
			'idApp_ClientePet',
			'idApp_ClientePet2',
			'idApp_ClienteDep',
			'idApp_ClienteDep2',
			'NomeEmpresa',
			'NomeEmpresaCli',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'Dia',
			'Mesvenc',
			'Ano',
			'Texto1',
			'Texto2',
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
			'Recorrencia',
			
        ), TRUE));
		/*
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
		*/
		
        $_SESSION['Filtro_Agenda']['Dia'] = $data['query']['Dia'];
        $_SESSION['Filtro_Agenda']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['Filtro_Agenda']['Ano'] = $data['query']['Ano'];
        $_SESSION['Filtro_Agenda']['Texto1'] = utf8_encode($data['query']['Texto1']);
        $_SESSION['Filtro_Agenda']['Texto2'] = utf8_encode($data['query']['Texto2']);
		$_SESSION['Filtro_Agenda']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
		$_SESSION['Filtro_Agenda']['ConcluidoSubProcedimento'] = $data['query']['ConcluidoSubProcedimento'];
        $_SESSION['Filtro_Agenda']['Prioridade'] = $data['query']['Prioridade'];
		$_SESSION['Filtro_Agenda']['Statustarefa'] = $data['query']['Statustarefa'];
		$_SESSION['Filtro_Agenda']['Statussubtarefa'] = $data['query']['Statussubtarefa'];
		$_SESSION['Filtro_Agenda']['SubPrioridade'] = $data['query']['SubPrioridade'];
		$_SESSION['Filtro_Agenda']['Categoria'] = $data['query']['Categoria'];
		$_SESSION['Filtro_Agenda']['Procedimento'] = $data['query']['Procedimento'];
		$_SESSION['Filtro_Agenda']['Diacli'] = $data['query']['Diacli'];
        $_SESSION['Filtro_Agenda']['Mesvenccli'] = $data['query']['Mesvenccli'];
        $_SESSION['Filtro_Agenda']['Anocli'] = $data['query']['Anocli'];		
		$_SESSION['Filtro_Agenda']['Concluidocli'] = $data['query']['Concluidocli'];
		$_SESSION['Filtro_Agenda']['NomeCliente'] = $data['query']['NomeCliente'];
		$_SESSION['Filtro_Agenda']['NomeClientePet'] = $data['query']['NomeClientePet'];
		$_SESSION['Filtro_Agenda']['NomeClienteDep'] = $data['query']['NomeClienteDep'];
		$_SESSION['Filtro_Agenda']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$_SESSION['Filtro_Agenda']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
		$_SESSION['Filtro_Agenda']['idApp_ClientePet2'] = $data['query']['idApp_ClientePet2'];
		$_SESSION['Filtro_Agenda']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
		$_SESSION['Filtro_Agenda']['idApp_ClienteDep2'] = $data['query']['idApp_ClienteDep2'];				
        $_SESSION['Filtro_Agenda']['Diaemp'] = $data['query']['Diaemp'];
        $_SESSION['Filtro_Agenda']['Mesvencemp'] = $data['query']['Mesvencemp'];
        $_SESSION['Filtro_Agenda']['Anoemp'] = $data['query']['Anoemp'];		
		$_SESSION['Filtro_Agenda']['Concluidoemp'] = $data['query']['Concluidoemp'];			
		$_SESSION['Filtro_Agenda']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
		$_SESSION['Filtro_Agenda']['NomeEmpresaCli'] = $data['query']['NomeEmpresaCli'];
		$_SESSION['Filtro_Agenda']['NomeUsuario'] = $data['query']['NomeUsuario'];
		$_SESSION['Filtro_Agenda']['Recorrencia'] = $data['query']['Recorrencia'];
        //$_SESSION['log']['NomeUsuario'] = ($data['query']['NomeUsuario']) ? $data['query']['NomeUsuario'] : FALSE;
        $_SESSION['log']['NomeProfissional'] = ($data['query']['NomeProfissional']) ? $data['query']['NomeProfissional'] : FALSE;
        $_SESSION['log']['Compartilhar'] = ($data['query']['Compartilhar']) ? $data['query']['Compartilhar'] : FALSE;

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
		//$data['select']['NomeCliente'] = $this->Agenda_model->select_cliente();
		//$data['select']['NomeClientePet'] = $this->Agenda_model->select_clientepet();
		//$data['select']['NomeClienteDep'] = $this->Agenda_model->select_clientedep();		
		//$data['select']['idApp_Cliente'] = $this->Agenda_model->select_cliente();
		//$data['select']['idApp_ClientePet'] = $this->Agenda_model->select_clientepet();
		//$data['select']['idApp_ClienteDep'] = $this->Agenda_model->select_clientedep();
		$data['select']['NomeEmpresa'] = $this->Agenda_model->select_empresarec();
		$data['select']['NomeEmpresaCli'] = $this->Agenda_model->select_empresaenv();
        //$data['select']['NomeUsuario'] = $this->Agenda_model->select_usuario();
        $data['select']['NomeUsuario'] = $this->Agenda_model->select_associado();
        //$data['select']['NomeProfissional'] = $this->Agenda_model->select_usuario();
        $data['select']['NomeProfissional'] = $this->Agenda_model->select_associado();
		$data['select']['Procedimento'] = $this->Agenda_model->select_tarefa();
		$data['select']['Categoria'] = $this->Agenda_model->select_categoria();
		$data['select']['Compartilhar'] = $this->Agenda_model->select_compartilhar();
		
        $data['titulo1'] = 'Aniversariantes';
		
		$data['form_open_path'] = 'agenda';
		
		$data['paginacao'] = 'N';

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		
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
			//$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			//$data['bd']['NomeClienteDep'] = $data['query']['NomeClienteDep'];
			//$data['bd']['NomeClientePet'] = $data['query']['NomeClientePet'];
			$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$data['bd']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
			$data['bd']['idApp_ClientePet2'] = $data['query']['idApp_ClientePet2'];
			$data['bd']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
			$data['bd']['idApp_ClienteDep2'] = $data['query']['idApp_ClienteDep2'];
			$data['bd']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');

			$config['per_page'] = 10;
			$config["uri_segment"] = 3;
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
			
            #$data['report'] = $this->Agenda_model->cliente_aniversariantes($data['bd'],TRUE);
            #$data['report'] = $this->Agenda_model->list1_procedimento($data['bd'],TRUE);
			/*
			$_SESSION['Tarefas'] = $data['report']->num_rows();
			echo "<pre>";
			print_r($_SESSION['Tarefas']);
			echo "</pre>";
			exit();
			*/
			$config['base_url'] = base_url() . 'agenda/aniversariantes_pag/';
			$config['total_rows'] = $this->Agenda_model->cliente_aniversariantes($data['bd'],TRUE, TRUE);
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Agenda_model->cliente_aniversariantes($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('agenda/list_aniversariantes', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }
		/*
		$data['query']['procedimento'] = $this->Agenda_model->procedimento($_SESSION['log']['idSis_Usuario']);
        $data['query']['estatisticas'] = $this->Agenda_model->resumo_estatisticas($_SESSION['log']['idSis_Usuario']);
        $data['query']['cliente_aniversariantes'] = $this->Agenda_model->cliente_aniversariantes($_SESSION['log']['idSis_Usuario']);
        $data['query']['contatocliente_aniversariantes'] = $this->Agenda_model->contatocliente_aniversariantes($_SESSION['log']['idSis_Usuario']);
        #$data['query']['profissional_aniversariantes'] = $this->Agenda_model->profissional_aniversariantes($_SESSION['log']['idSis_Usuario']);
		#$data['query']['contatoprof_aniversariantes'] = $this->Agenda_model->contatoprof_aniversariantes($_SESSION['log']['idSis_Usuario']);
		$data['query']['procedempresa'] = $this->Agenda_model->procedempresa($_SESSION['log']['idSis_Usuario']);
		$data['query']['procedimentorec'] = $this->Agenda_model->procedimentorec($_SESSION['log']['idSis_Usuario']);
		*/
			
		
		$this->load->view('agenda/tela_agenda', $data);

        #load footer view
        $this->load->view('basico/footer');
    
	}
	
    public function aniversariantes_pag() {

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
			'Texto1',
			'Texto2',
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

		$data['select']['NomeProfissional'] = $this->Agenda_model->select_usuario();
		$data['select']['Compartilhar'] = $this->Agenda_model->select_compartilhar(); 
		
		$data['titulo1'] = 'Aniversariantes';
		
		$data['paginacao'] = 'S';
		
		$data['form_open_path'] = 'agenda/aniversariantes_pag';
		
		$data['caminho'] = 'agenda';

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #run form validation
        if ($this->form_validation->run() !== TRUE) {


			$config['per_page'] = 10;
			$config["uri_segment"] = 3;
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
			$config['base_url'] = base_url() . 'agenda/aniversariantes_pag/';		
			$config['total_rows'] = $this->Agenda_model->cliente_aniversariantes(FALSE, TRUE, TRUE);
			
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Agenda_model->cliente_aniversariantes(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('agenda/list_aniversariantes', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }
		
		$this->load->view('agenda/tela_agenda', $data);

        $this->load->view('basico/footer');
    
    }
	
}
