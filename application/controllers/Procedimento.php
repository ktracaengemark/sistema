<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Procedimento extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array('Basico_model', 'Procedimento_model', 'Tarefa_model', 'Usuario_model', 'Relatorio_model', 'Formapag_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('procedimento/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('procedimento/tela_index', $data);

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

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idApp_Procedimento',
			'Procedimento',
            'DataProcedimento',
			'DataConcluidoProcedimento',
			'ConcluidoProcedimento',
			'Prioridade',
			'Compartilhar',

        ), TRUE));

		(!$data['query']['DataProcedimento']) ? $data['query']['DataProcedimento'] = date('d/m/Y H:i:s', time()) : FALSE;
		(!$data['query']['Compartilhar']) ? $data['query']['Compartilhar'] = '50' : FALSE;
		#(!$data['query']['DataConcluidoProcedimento']) ? $data['query']['DataConcluidoProcedimento'] = date('d/m/Y', time()) : FALSE;
		
	   $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Procedimento', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Procedimento.Procedimento.DataProcedimento.' . $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql') . ']');
		$this->form_validation->set_rules('Procedimento', 'Tarefa', 'required|trim');
        #$this->form_validation->set_rules('DataProcedimento', 'Data do Procedimento', 'trim|valid_date');

		$data['select']['Compartilhar'] = $this->Procedimento_model->select_compartilhar();
		$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['Prioridade'] = array (
            '1' => 'Alta',
            '2' => 'Média',
			'3' => 'Baixa',
        );		

        #$data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

		
        $data['titulo'] = 'Tarefa';
        $data['form_open_path'] = 'procedimento/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';			

		$data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('procedimento/form_procedimento', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimento/form_procedimento', $data);
        } else {

			

            $data['query']['DataProcedimento'] = $this->basico->mascara_data2($data['query']['DataProcedimento'], 'mysql');            
			$data['query']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['query']['DataConcluidoProcedimento'], 'mysql');
			$data['query']['Procedimento'] = nl2br($data['query']['Procedimento']);
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idApp_Cliente'] = 0;
			$data['query']['idApp_OrcaTrata'] = 0;
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Procedimento'] = $this->Procedimento_model->set_procedimento($data['query']);

            if ($data['idApp_Procedimento'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('procedimento/form_procedimento', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'agenda' . $data['msg']);
				#redirect(base_url() . 'relatorio/procedimento/' . $data['msg']);
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

        if ($_SESSION['log']['idSis_Empresa'] != 5)
		$data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Procedimento',
			'Procedimento',
            #'DataProcedimento',
			'DataConcluidoProcedimento',
			'ConcluidoProcedimento',
			'Prioridade',
			'Compartilhar', 
        ), TRUE);
		 else
        $data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Procedimento',
			'Procedimento',
            #'DataProcedimento',
			'DataConcluidoProcedimento',
			'ConcluidoProcedimento',
			'Prioridade',
        ), TRUE);		

        if ($id) {
            $data['query'] = $this->Procedimento_model->get_procedimento($id);
            $data['query']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'barras');
			$data['query']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['query']['DataConcluidoProcedimento'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Procedimento', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Procedimento.Procedimento.DataProcedimento.' . $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql') . ']');

        $this->form_validation->set_rules('Procedimento', 'Tarefa', 'required|trim');
        #$this->form_validation->set_rules('DataProcedimento', 'Data do Procedimento', 'trim|valid_date');

		$data['select']['Compartilhar'] = $this->Procedimento_model->select_compartilhar();
		$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['Prioridade'] = array (
            '1' => 'Alta',
            '2' => 'Média',
			'3' => 'Baixa',
        );		
		
        $data['titulo'] = 'Editar Tarefa';
        $data['form_open_path'] = 'procedimento/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';			

		$data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('procedimento/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimento/form_procedimento2', $data);
        } else {


            #$data['query']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');
            $data['query']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['query']['DataConcluidoProcedimento'], 'mysql');
			$data['query']['Procedimento'] = nl2br($data['query']['Procedimento']);
			#$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];						
            $data['anterior'] = $this->Procedimento_model->get_procedimento($data['query']['idApp_Procedimento']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Procedimento'], TRUE);


			
            if ($data['auditoriaitem'] && $this->Procedimento_model->update_procedimento($data['query'], $data['query']['idApp_Procedimento']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'agenda');
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                #redirect(base_url() . 'relatorio/procedimento' . $data['msg']);
				#redirect(base_url() . 'agenda' . $data['msg']);
				redirect(base_url() . 'relatorio/admin' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function cadastrarcli() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idApp_Cliente',
			'idApp_Procedimento',
			'Procedimento',
            'DataProcedimento',
			'DataConcluidoProcedimento',
			'ConcluidoProcedimento',

        ), TRUE));

		(!$data['query']['DataProcedimento']) ? $data['query']['DataProcedimento'] = date('d/m/Y H:i:s', time()) : FALSE;
		#(!$data['query']['DataConcluidoProcedimento']) ? $data['query']['DataConcluidoProcedimento'] = date('d/m/Y', time()) : FALSE;
		
	   $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Procedimento', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Procedimento.Procedimento.DataProcedimento.' . $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql') . ']');
		$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
        $this->form_validation->set_rules('Procedimento', 'Procedimento', 'required|trim');

		
		$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();		
		
        $data['titulo'] = 'Cadastrar Procedimento';
        $data['form_open_path'] = 'procedimento/cadastrarcli';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';		

		$data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('procedimento/form_procedimentocli', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimento/form_procedimentocli', $data);
        } else {

            $data['query']['DataProcedimento'] = $this->basico->mascara_data2($data['query']['DataProcedimento'], 'mysql');            
			$data['query']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['query']['DataConcluidoProcedimento'], 'mysql');
			$data['query']['Procedimento'] = nl2br($data['query']['Procedimento']);
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			#$data['query']['idApp_Cliente'] = 0;
			$data['query']['idApp_OrcaTrata'] = 0;
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Procedimento'] = $this->Procedimento_model->set_procedimento($data['query']);

            if ($data['idApp_Procedimento'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('procedimento/form_procedimentocli', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'agenda' . $data['msg']);
				#redirect(base_url() . 'relatorio/procedimento/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterarcli($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Cliente',
			'idApp_Procedimento',
			'Procedimento',
            'DataProcedimento',
			'DataConcluidoProcedimento',
			'ConcluidoProcedimento',

        ), TRUE);

        if ($id) {
            $data['query'] = $this->Procedimento_model->get_procedimento($id);
            $data['query']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'barras');
			$data['query']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['query']['DataConcluidoProcedimento'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Procedimento', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Procedimento.Procedimento.DataProcedimento.' . $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql') . ']');

        $this->form_validation->set_rules('DataProcedimento', 'Data do Procedimento', 'trim|valid_date');


		$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();		
		
        $data['titulo'] = 'Editar Procedimento';
        $data['form_open_path'] = 'procedimento/alterarcli';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		
		$data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('procedimento/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimento/form_procedimentocli', $data);
        } else {


            $data['query']['DataProcedimento'] = $this->basico->mascara_data2($data['query']['DataProcedimento'], 'mysql');
            $data['query']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['query']['DataConcluidoProcedimento'], 'mysql');
			$data['query']['Procedimento'] = nl2br($data['query']['Procedimento']);
			#$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						
            $data['anterior'] = $this->Procedimento_model->get_procedimento($data['query']['idApp_Procedimento']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Procedimento'], TRUE);

            if ($data['auditoriaitem'] && $this->Procedimento_model->update_procedimento($data['query'], $data['query']['idApp_Procedimento']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'procedimento/form_procedimentocli/' . $data['query']['idApp_Procedimento'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                #redirect(base_url() . 'relatorio/procedimento' . $data['msg']);
				redirect(base_url() . 'agenda' . $data['msg']);
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

        $this->Procedimento_model->delete_procedimento($id);

        $data['msg'] = '?m=1';

		redirect(base_url() . 'agenda' . $data['msg']);
		#redirect(base_url() . 'relatorio/procedimento' . $data['msg']);
		exit();

        $this->load->view('basico/footer');
    }

    public function cadastrar_Sac($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_Procedimento ####
            'idApp_Procedimento',
            'idSis_Usuario',
			'idApp_Cliente',
            'DataProcedimento',
            'HoraProcedimento',
			'DataConcluidoProcedimento',
			'HoraConcluidoProcedimento',
			'Procedimento',
			'ConcluidoProcedimento',
			'Sac',
			'Compartilhar',

        ), TRUE));

        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
        //Data de hoje como default
        (!$data['orcatrata']['DataProcedimento']) ? $data['orcatrata']['DataProcedimento'] = date('d/m/Y H:i:s', time()) : FALSE;
        (!$data['orcatrata']['HoraProcedimento']) ? $data['orcatrata']['HoraProcedimento'] = date('H:i:s', time()) : FALSE;
		(!$data['orcatrata']['Compartilhar']) ? $data['orcatrata']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'] : FALSE;
		$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('DataConcluidoSubProcedimento' . $i) || $this->input->post('SubProcedimento' . $i)) {
                $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->input->post('DataSubProcedimento' . $i);
                $data['procedtarefa'][$j]['HoraSubProcedimento'] = $this->input->post('HoraSubProcedimento' . $i);
                $data['procedtarefa'][$j]['DataConcluidoSubProcedimento'] = $this->input->post('DataConcluidoSubProcedimento' . $i);
                $data['procedtarefa'][$j]['HoraConcluidoSubProcedimento'] = $this->input->post('HoraConcluidoSubProcedimento' . $i);
				//$data['procedtarefa'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
                //$data['procedtarefa'][$j]['Statussubtarefa'] = $this->input->post('Statussubtarefa' . $i);
				$data['procedtarefa'][$j]['SubProcedimento'] = $this->input->post('SubProcedimento' . $i);
				$data['procedtarefa'][$j]['ConcluidoSubProcedimento'] = $this->input->post('ConcluidoSubProcedimento' . $i);
                $data['procedtarefa'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				
				(!$data['procedtarefa'][$j]['ConcluidoSubProcedimento']) ? $data['procedtarefa'][$j]['ConcluidoSubProcedimento'] = 'N' : FALSE;
				$data['radio'] = array(
					'ConcluidoSubProcedimento' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubProcedimento'], 'ConcluidoSubProcedimento' . $j, 'NS'),
				);
				($data['procedtarefa'][$j]['ConcluidoSubProcedimento'] == 'S') ? $data['div']['ConcluidoSubProcedimento' . $j] = '' : $data['div']['ConcluidoSubProcedimento' . $j] = 'style="display: none;"';
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;		

        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoSubProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['Compartilhar'] = $this->Procedimento_model->select_compartilhar();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['Sac'] = array (
            '1' => 'Solicitação',
            '2' => 'Elogio',
			'3' => 'Reclamação',
        );
		/*
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
		*/
        $data['titulo'] = 'Sac';
        $data['form_open_path'] = 'procedimento/cadastrar_Sac';
        $data['readproc'] = '';
		$data['readonly'] = '';
		$data['disabled'] = '';
		$data['panel'] = 'primary';
        $data['panel2'] = 'warning';
        $data['botao_Sac'] = 'warning';
        $data['botao_mark'] = 'default';
        $data['metodo'] = 1;

		(!$data['orcatrata']['ConcluidoProcedimento']) ? $data['orcatrata']['ConcluidoProcedimento'] = 'N' : FALSE;		
		$data['radio'] = array(
            'ConcluidoProcedimento' => $this->basico->radio_checked($data['orcatrata']['ConcluidoProcedimento'], 'Procedimento Concluido', 'NS'),
        );
        ($data['orcatrata']['ConcluidoProcedimento'] == 'S') ?
            $data['div']['ConcluidoProcedimento'] = '' : $data['div']['ConcluidoProcedimento'] = 'style="display: none;"';
		
		/*
        if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

		*/
		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';	
		
	/*
        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
		
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';

	*/
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

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Procedimento ####
        $this->form_validation->set_rules('Procedimento', 'Procedimento', 'required|trim');
        $this->form_validation->set_rules('Sac', 'Sac', 'required|trim');
        $this->form_validation->set_rules('Compartilhar', 'Quem Fazer', 'required|trim');
		if($data['orcatrata']['ConcluidoProcedimento'] == "S"){
			$this->form_validation->set_rules('DataConcluidoProcedimento', 'Concluído em:', 'required|trim|valid_date');
		}
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('procedimento/form_procedcli', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Procedimento ####
			if($data['orcatrata']['ConcluidoProcedimento'] == "N"){
				$data['orcatrata']['DataConcluidoProcedimento'] = "00/00/0000";
				$data['orcatrata']['HoraConcluidoProcedimento'] = "00:00:00";
			}
            $data['orcatrata']['DataProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimento'], 'mysql');
			$data['orcatrata']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoProcedimento'], 'mysql');
			$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['orcatrata']['TipoProcedimento'] = 3;
            $data['orcatrata']['idApp_Procedimento'] = $this->Procedimento_model->set_orcatrata($data['orcatrata']);
			
            #### App_SubProcedimento ####
            if (isset($data['procedtarefa'])) {
                $max = count($data['procedtarefa']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedtarefa'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['procedtarefa'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['procedtarefa'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedtarefa'][$j]['TipoSubProcedimento'] = 3;
                    $data['procedtarefa'][$j]['idApp_Procedimento'] = $data['orcatrata']['idApp_Procedimento'];
                    $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubProcedimento'], 'mysql');
					$data['procedtarefa'][$j]['DataConcluidoSubProcedimento'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataConcluidoSubProcedimento'], 'mysql');
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
                $this->load->view('procedimento/form_procedcli', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'procedimento/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                redirect(base_url() . 'Procedimento/tela_Sac/' . $data['orcatrata']['idApp_Procedimento'] . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function alterar_Sac($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_Procedimento ####
			'idApp_Procedimento',
            'idSis_Usuario',
            #Não há a necessidade de atualizar o valor do campo a seguir
            #'idApp_Cliente',
            'DataProcedimento',
			'DataConcluidoProcedimento',
            'HoraProcedimento',
			'HoraConcluidoProcedimento',
			'Procedimento',
			'ConcluidoProcedimento',
			'Sac',
			'Compartilhar',

        ), TRUE));

        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$data['orcatrata']['Compartilhar']) ? $data['orcatrata']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'] : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('DataSubProcedimento' . $i) || $this->input->post('DataConcluidoSubProcedimento' . $i) || $this->input->post('SubProcedimento' . $i)) {
                $data['procedtarefa'][$j]['idApp_SubProcedimento'] = $this->input->post('idApp_SubProcedimento' . $i);
                $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->input->post('DataSubProcedimento' . $i);
                $data['procedtarefa'][$j]['DataConcluidoSubProcedimento'] = $this->input->post('DataConcluidoSubProcedimento' . $i);
                $data['procedtarefa'][$j]['HoraSubProcedimento'] = $this->input->post('HoraSubProcedimento' . $i);
                $data['procedtarefa'][$j]['HoraConcluidoSubProcedimento'] = $this->input->post('HoraConcluidoSubProcedimento' . $i);
				//$data['procedtarefa'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
                //$data['procedtarefa'][$j]['Statussubtarefa'] = $this->input->post('Statussubtarefa' . $i);
				$data['procedtarefa'][$j]['SubProcedimento'] = $this->input->post('SubProcedimento' . $i);
				$data['procedtarefa'][$j]['ConcluidoSubProcedimento'] = $this->input->post('ConcluidoSubProcedimento' . $i);
                $data['procedtarefa'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				
				(!$data['procedtarefa'][$j]['ConcluidoSubProcedimento']) ? $data['procedtarefa'][$j]['ConcluidoSubProcedimento'] = 'N' : FALSE;
				$data['radio'] = array(
					'ConcluidoSubProcedimento' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubProcedimento'], 'ConcluidoSubProcedimento' . $j, 'NS'),
				);
				($data['procedtarefa'][$j]['ConcluidoSubProcedimento'] == 'S') ? $data['div']['ConcluidoSubProcedimento' . $j] = '' : $data['div']['ConcluidoSubProcedimento' . $j] = 'style="display: none;"';
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;
		
		
        if ($id) {
            #### App_Procedimento ####
            $_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Procedimento_model->get_procedimento2($id);
            $data['orcatrata']['DataProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimento'], 'barras');
			$data['orcatrata']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoProcedimento'], 'barras');
			#### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
            $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
            $_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
			#$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_SubProcedimento ####
            $_SESSION['Procedtarefa'] = $data['procedtarefa'] = $this->Tarefa_model->get_procedtarefa($id);
            if (count($data['procedtarefa']) > 0) {
                $data['procedtarefa'] = array_combine(range(1, count($data['procedtarefa'])), array_values($data['procedtarefa']));
                $data['count']['PTCount'] = count($data['procedtarefa']);

                if (isset($data['procedtarefa'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++) {
                        $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubProcedimento'], 'barras');
						$data['procedtarefa'][$j]['DataConcluidoSubProcedimento'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataConcluidoSubProcedimento'], 'barras');
						$_SESSION['Procedtarefa'][$j]['NomeCadastrou'] = $data['procedtarefa'][$j]['NomeCadastrou'];				
						
						$data['radio'] = array(
							'ConcluidoSubProcedimento' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubProcedimento'], 'ConcluidoSubProcedimento' . $j, 'NS'),
						);
						($data['procedtarefa'][$j]['ConcluidoSubProcedimento'] == 'S') ? $data['div']['ConcluidoSubProcedimento' . $j] = '' : $data['div']['ConcluidoSubProcedimento' . $j] = 'style="display: none;"';
					}
                }
            }
		}
			/*
			echo '<br>';
			echo "<pre>";
			print_r($_SESSION['Orcatrata']);
			echo "</pre>";
			//exit ();
			*/
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoSubProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
        $data['select']['Compartilhar'] = $this->Procedimento_model->select_compartilhar();
		$data['select']['Sac'] = array (
            '1' => 'Solicitação',
            '2' => 'Elogio',
			'3' => 'Reclamação',
        );
		/*
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
		*/
        $data['titulo'] = 'Sac';
        $data['form_open_path'] = 'procedimento/alterar_Sac';
        $data['readproc'] = 'readonly=""';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['panel2'] = 'warning';
        $data['botao_Sac'] = 'warning';
        $data['botao_mark'] = 'default';
        $data['metodo'] = 2;
		
		(!$data['orcatrata']['ConcluidoProcedimento']) ? $data['orcatrata']['ConcluidoProcedimento'] = 'N' : FALSE;		
		$data['radio'] = array(
            'ConcluidoProcedimento' => $this->basico->radio_checked($data['orcatrata']['ConcluidoProcedimento'], 'Procedimento Concluido', 'NS'),
        );
        ($data['orcatrata']['ConcluidoProcedimento'] == 'S') ?
            $data['div']['ConcluidoProcedimento'] = '' : $data['div']['ConcluidoProcedimento'] = 'style="display: none;"';		

    /*
		//if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

	*/
		$data['collapse'] = '';
	
		$data['collapse1'] = 'class="collapse"';
	/*	
        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
	*/

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
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Procedimento ####
        $this->form_validation->set_rules('Procedimento', 'Procedimento', 'required|trim');
        $this->form_validation->set_rules('Sac', 'Sac', 'required|trim');
        $this->form_validation->set_rules('Compartilhar', 'Quem Fazer', 'required|trim');
		if($data['orcatrata']['ConcluidoProcedimento'] == "S"){
			$this->form_validation->set_rules('DataConcluidoProcedimento', 'Concluído em:', 'required|trim|valid_date');
		}else{
			$data['orcatrata']['DataConcluidoProcedimento'] = "00/00/0000";
		}
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimento/form_procedcli', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Procedimento ####
            $data['orcatrata']['DataProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimento'], 'mysql');
			$data['orcatrata']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoProcedimento'], 'mysql');
			#$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            #$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            #$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['orcatrata']['anterior'] = $this->Procedimento_model->get_procedimento2($data['orcatrata']['idApp_Procedimento']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_Procedimento'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Procedimento_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_Procedimento']);

            #### App_SubProcedimento ####
            $data['update']['procedtarefa']['anterior'] = $this->Tarefa_model->get_procedtarefa($data['orcatrata']['idApp_Procedimento']);
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
                    $data['update']['procedtarefa']['inserir'][$j]['TipoSubProcedimento'] = 3;
                    $data['update']['procedtarefa']['inserir'][$j]['idApp_Procedimento'] = $data['orcatrata']['idApp_Procedimento'];
                    $data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimento'], 'mysql');
					$data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubProcedimento'], 'mysql');
                }

                $max = count($data['update']['procedtarefa']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimento'], 'mysql');
					$data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubProcedimento'], 'mysql');
				}

                if (count($data['update']['procedtarefa']['inserir']))
                    $data['update']['procedtarefa']['bd']['inserir'] = $this->Tarefa_model->set_procedtarefa($data['update']['procedtarefa']['inserir']);

                if (count($data['update']['procedtarefa']['alterar']))
                    $data['update']['procedtarefa']['bd']['alterar'] =  $this->Tarefa_model->update_procedtarefa($data['update']['procedtarefa']['alterar']);

                if (count($data['update']['procedtarefa']['excluir']))
                    $data['update']['procedtarefa']['bd']['excluir'] = $this->Tarefa_model->delete_procedtarefa($data['update']['procedtarefa']['excluir']);

            }
			
            //if ($data['idApp_Procedimento'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('procedimento/form_procedcli', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';
				
				unset($_SESSION['Orcatrata'], $_SESSION['Procedtarefa']);
                //redirect(base_url() . 'procedimento/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                redirect(base_url() . 'Procedimento/tela_Sac/' . $data['orcatrata']['idApp_Procedimento'] . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function listar_Sac($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$this->load->model('Cliente_model');
		
		if ($id) {
            $data['cliente']['idApp_Cliente'] = $id;
			$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($id, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($id);
			$_SESSION['Cliente']['NomeCompleto'] = $data['resumo']['NomeCliente'];
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
		}
		
        //$_SESSION['OrcaTrata'] = $this->Procedimento_model->get_cliente($id, TRUE);
        //$_SESSION['OrcaTrata']['idApp_Cliente'] = $id;
        $data['informacao_concl'] = $this->Procedimento_model->list_informacao($id, 'S', TRUE);
        $data['informacao_nao_concl'] = $this->Procedimento_model->list_informacao($id, 'N', TRUE);
        $data['elogio_concl'] = $this->Procedimento_model->list_elogio($id, 'S', TRUE);
        $data['elogio_nao_concl'] = $this->Procedimento_model->list_elogio($id, 'N', TRUE);
        $data['reclamacao_concl'] = $this->Procedimento_model->list_reclamacao($id, 'S', TRUE);
        $data['reclamacao_nao_concl'] = $this->Procedimento_model->list_reclamacao($id, 'N', TRUE);
		
		$data['titulo'] = 'Sac';
        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('procedimento/list_Sac', $data, TRUE);
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('procedimento/list_Sac', $data);

        $this->load->view('basico/footer');
    }
     
	public function tela_Sac($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($id) {
            #### App_OrcaTrata ####
            $data['procedimento'] = $this->Procedimento_model->get_procedimento($id);
            $data['procedimento']['DataProcedimento'] = $this->basico->mascara_data($data['procedimento']['DataProcedimento'], 'barras');
			if($data['procedimento']['Sac'] == 1){
				$data['procedimento']['Sac'] = 'Solicitação';
			}elseif($data['procedimento']['Sac'] == 2){
				$data['procedimento']['Sac'] = 'Elogio';
			}elseif($data['procedimento']['Sac'] == 3){
				$data['procedimento']['Sac'] = 'Reclamação';
			}
            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
			if($data['procedimento']['idApp_Cliente'] != 0 && $data['procedimento']['idApp_Cliente'] != 1){
				//$data['cliente'] = $this->Cliente_model->get_cliente($data['procedimento']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['procedimento']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
			}
			
			//$data['usuario'] = $this->Usuario_model->get_usuario($data['procedimento']['idSis_Usuario'], TRUE);
			$data['query'] = $this->Procedimento_model->get_procedimento($data['procedimento']['idApp_Procedimento'], TRUE);

            #### App_Procedimento ####
            $data['subprocedimento'] = $this->Procedimento_model->get_subprocedimento($id);
            if (count($data['subprocedimento']) > 0) {
                $data['subprocedimento'] = array_combine(range(1, count($data['subprocedimento'])), array_values($data['subprocedimento']));
                $data['count']['PMCount'] = count($data['subprocedimento']);

                if (isset($data['subprocedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
                        $data['subprocedimento'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['subprocedimento'][$j]['DataSubProcedimento'], 'barras');


                }
            }

        }
		
        $data['titulo'] = 'Sac';
        $data['form_open_path'] = 'Procedimento/tela_Sac';
        $data['panel2'] = 'warning';
        $data['metodo'] = 1;
        $data['alterar'] = 'Sac';
        $data['cor_Sac'] = 'warning';
        $data['cor_Marketing'] = 'default';
        $data['imprimir'] = 'Sac';			

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('procedimento/tela_procedimento', $data);

        $this->load->view('basico/footer');

    }
     
	public function imprimir_Sac($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($id) {
            #### App_OrcaTrata ####
            $data['procedimento'] = $this->Procedimento_model->get_procedimento($id);
            $data['procedimento']['DataProcedimento'] = $this->basico->mascara_data($data['procedimento']['DataProcedimento'], 'barras');
			if($data['procedimento']['Sac'] == 1){
				$data['procedimento']['Sac'] = 'Solicitação';
			}elseif($data['procedimento']['Sac'] == 2){
				$data['procedimento']['Sac'] = 'Elogio';
			}elseif($data['procedimento']['Sac'] == 3){
				$data['procedimento']['Sac'] = 'Reclamação';
			}
            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
			if($data['procedimento']['idApp_Cliente'] != 0 && $data['procedimento']['idApp_Cliente'] != 1){
				//$data['cliente'] = $this->Cliente_model->get_cliente($data['procedimento']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['procedimento']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
			}
			
			//$data['usuario'] = $this->Usuario_model->get_usuario($data['procedimento']['idSis_Usuario'], TRUE);
			$data['query'] = $this->Procedimento_model->get_procedimento($data['procedimento']['idApp_Procedimento'], TRUE);

            #### App_Procedimento ####
            $data['subprocedimento'] = $this->Procedimento_model->get_subprocedimento($id);
            if (count($data['subprocedimento']) > 0) {
                $data['subprocedimento'] = array_combine(range(1, count($data['subprocedimento'])), array_values($data['subprocedimento']));
                $data['count']['PMCount'] = count($data['subprocedimento']);

                if (isset($data['subprocedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
                        $data['subprocedimento'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['subprocedimento'][$j]['DataSubProcedimento'], 'barras');


                }
            }

        }
		
        $data['titulo'] = 'Sac';
        $data['form_open_path'] = 'Procedimento/imprimir_Sac';
        $data['panel2'] = 'warning';
        $data['metodo'] = 2;
        $data['alterar'] = 'Sac';
        $data['cor_Sac'] = 'warning';
        $data['cor_Marketing'] = 'default';
        $data['imprimir'] = 'Sac';			

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('procedimento/print_procedimento', $data);

        $this->load->view('basico/footer');

    }

    public function imprimir_lista_Sac($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		
		
		$data['bd']['idSis_Empresa'] = $id;
		$data['bd']['TipoProcedimento'] = 3;
		
        $data['titulo'] = 'Sac';
        $data['form_open_path'] = 'Procedimento/imprimir_lista_Sac';
        $data['panel'] = 'warning';
		$data['metodo'] = 3;
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'Procedimento/imprimir/';
		$data['imprimirlista'] = 'Procedimento/imprimir_lista_Sac/';
		$data['imprimirrecibo'] = 'Procedimento/imprimirreciborec/';
		$data['caminho'] = 'relatorio/proc_Sac/';		
		
		//$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio4'], 'barras');
		//$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim4'], 'barras');


		//$this->load->library('pagination');
		$config['per_page'] = 10;
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
		$data['Pesquisa'] = '';
		
        if ($id) {

			$config['base_url'] = base_url() . 'Procedimento/imprimir_lista_Sac/' . $id . '/';
			$config['total_rows'] = $this->Procedimento_model->get_procedimento_empresa($data['bd'], TRUE);
		   
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
		
            #### App_Procedimento ####
            $data['procedimento'] = $this->Procedimento_model->get_procedimento_empresa($data['bd'], FALSE, $config['per_page'], ($page * $config['per_page']));
			if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['POCount'] = count($data['procedimento']);           

				if (isset($data['procedimento'])) {

                    for($j=1;$j<=$data['count']['POCount'];$j++) {
						$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');
						$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->basico->mascara_palavra_completa($data['procedimento'][$j]['ConcluidoProcedimento'], 'NS');
						if($data['procedimento'][$j]['Sac'] == 1){
							$data['procedimento'][$j]['Sac'] = 'Solicitação';
						}elseif($data['procedimento'][$j]['Sac'] == 2){
							$data['procedimento'][$j]['Sac'] = 'Elogio';
						}elseif($data['procedimento'][$j]['Sac'] == 3){
							$data['procedimento'][$j]['Sac'] = 'Reclamação';
						}
					}
				}	
			}
			
			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['procedimento']);
			  echo "</pre>";
			  exit ();
			  */
			
            #### App_Procedimento ####
            $data['subprocedimento'] = $this->Procedimento_model->get_subprocedimento_empresa($data['bd'],TRUE);
            
			if (count($data['subprocedimento']) > 0) {
                $data['subprocedimento'] = array_combine(range(1, count($data['subprocedimento'])), array_values($data['subprocedimento']));
                $data['count']['PMCount'] = count($data['subprocedimento']);

                if (isset($data['subprocedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++){
                        $data['subprocedimento'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['subprocedimento'][$j]['DataSubProcedimento'], 'barras');	
						$data['subprocedimento'][$j]['ConcluidoSubProcedimento'] = $this->basico->mascara_palavra_completa($data['subprocedimento'][$j]['ConcluidoSubProcedimento'], 'NS');					
					}
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

        //$this->load->view('orcatrata/print_orcatratacobranca_lista', $data);
        $this->load->view('procedimento/print_lista', $data);

        $this->load->view('basico/footer');

    }
 
    public function cadastrar_Marketing($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_Procedimento ####
            'idApp_Procedimento',
            'idSis_Usuario',
            'idApp_Cliente',
            'DataProcedimento',
			'DataConcluidoProcedimento',
            'HoraProcedimento',
			'HoraConcluidoProcedimento',
			'Procedimento',
			'ConcluidoProcedimento',
			'Marketing',
			'Compartilhar',

        ), TRUE));

        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
        //Data de hoje como default
        (!$data['orcatrata']['DataProcedimento']) ? $data['orcatrata']['DataProcedimento'] = date('d/m/Y H:i:s', time()) : FALSE;
        (!$data['orcatrata']['HoraProcedimento']) ? $data['orcatrata']['HoraProcedimento'] = date('H:i:s', time()) : FALSE;
		(!$data['orcatrata']['Compartilhar']) ? $data['orcatrata']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'] : FALSE;
		$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('DataConcluidoSubProcedimento' . $i) || $this->input->post('SubProcedimento' . $i)) {
                $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->input->post('DataSubProcedimento' . $i);
                $data['procedtarefa'][$j]['DataConcluidoSubProcedimento'] = $this->input->post('DataConcluidoSubProcedimento' . $i);
                $data['procedtarefa'][$j]['HoraSubProcedimento'] = $this->input->post('HoraSubProcedimento' . $i);
                $data['procedtarefa'][$j]['HoraConcluidoSubProcedimento'] = $this->input->post('HoraConcluidoSubProcedimento' . $i);
				//$data['procedtarefa'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
                //$data['procedtarefa'][$j]['Statussubtarefa'] = $this->input->post('Statussubtarefa' . $i);
				$data['procedtarefa'][$j]['SubProcedimento'] = $this->input->post('SubProcedimento' . $i);
				$data['procedtarefa'][$j]['ConcluidoSubProcedimento'] = $this->input->post('ConcluidoSubProcedimento' . $i);
                $data['procedtarefa'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				
				(!$data['procedtarefa'][$j]['ConcluidoSubProcedimento']) ? $data['procedtarefa'][$j]['ConcluidoSubProcedimento'] = 'N' : FALSE;
				$data['radio'] = array(
					'ConcluidoSubProcedimento' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubProcedimento'], 'ConcluidoSubProcedimento' . $j, 'NS'),
				);
				($data['procedtarefa'][$j]['ConcluidoSubProcedimento'] == 'S') ? $data['div']['ConcluidoSubProcedimento' . $j] = '' : $data['div']['ConcluidoSubProcedimento' . $j] = 'style="display: none;"';
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;		

        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoSubProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
        $data['select']['Compartilhar'] = $this->Procedimento_model->select_compartilhar();
		//$data['select']['Marketing'] = $this->Procedimento_model->select_Marketing();
		$data['select']['Marketing'] = array (
            '1' => 'Atualização',
            '2' => 'Pesquisa',
			'3' => 'Retorno',
            '4' => 'Promoções',
			'5' => 'Felicitações',
        );
		/*
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
		*/
        $data['titulo'] = 'Marketing';
        $data['form_open_path'] = 'procedimento/cadastrar_Marketing';
        $data['readproc'] = '';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['panel2'] = 'success';
        $data['botao_Sac'] = 'default';
        $data['botao_mark'] = 'warning';
        $data['metodo'] = 3;

		(!$data['orcatrata']['ConcluidoProcedimento']) ? $data['orcatrata']['ConcluidoProcedimento'] = 'N' : FALSE;		
		$data['radio'] = array(
            'ConcluidoProcedimento' => $this->basico->radio_checked($data['orcatrata']['ConcluidoProcedimento'], 'Procedimento Concluido', 'NS'),
        );
        ($data['orcatrata']['ConcluidoProcedimento'] == 'S') ?
            $data['div']['ConcluidoProcedimento'] = '' : $data['div']['ConcluidoProcedimento'] = 'style="display: none;"';
		
		/*
        if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

		*/
		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';	
		
	/*
        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
		
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';

	*/
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

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Procedimento ####
        //$this->form_validation->set_rules('Procedimento', 'Procedimento', 'required|trim');
        $this->form_validation->set_rules('Marketing', 'Marketing', 'required|trim');
        $this->form_validation->set_rules('Compartilhar', 'Quem Fazer', 'required|trim');
		if($data['orcatrata']['ConcluidoProcedimento'] == "S"){
			$this->form_validation->set_rules('DataConcluidoProcedimento', 'Concluído em:', 'required|trim|valid_date');
		}else{
			$data['orcatrata']['DataConcluidoProcedimento'] = "00/00/0000";
		}

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('procedimento/form_procedcli', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Procedimento ####
            $data['orcatrata']['DataProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimento'], 'mysql');
			$data['orcatrata']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoProcedimento'], 'mysql');
			$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['orcatrata']['TipoProcedimento'] = 4;
            $data['orcatrata']['idApp_Procedimento'] = $this->Procedimento_model->set_orcatrata($data['orcatrata']);
			
            #### App_SubProcedimento ####
            if (isset($data['procedtarefa'])) {
                $max = count($data['procedtarefa']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedtarefa'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['procedtarefa'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['procedtarefa'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedtarefa'][$j]['TipoSubProcedimento'] = 4;
                    $data['procedtarefa'][$j]['idApp_Procedimento'] = $data['orcatrata']['idApp_Procedimento'];
                    $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubProcedimento'], 'mysql');
					$data['procedtarefa'][$j]['DataConcluidoSubProcedimento'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataConcluidoSubProcedimento'], 'mysql');
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
                $this->load->view('procedimento/form_procedcli', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'procedimento/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                redirect(base_url() . 'Procedimento/tela_Marketing/' . $data['orcatrata']['idApp_Procedimento'] . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function alterar_Marketing($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_Procedimento ####
			'idApp_Procedimento',
            'idSis_Usuario',
            #Não há a necessidade de atualizar o valor do campo a seguir
            #'idApp_Cliente',
            'DataProcedimento',
			'DataConcluidoProcedimento',
            'HoraProcedimento',
			'HoraConcluidoProcedimento',
			'Procedimento',
			'ConcluidoProcedimento',
			'Marketing',
			'Compartilhar',

        ), TRUE));

        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$data['orcatrata']['Compartilhar']) ? $data['orcatrata']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'] : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('DataSubProcedimento' . $i) || $this->input->post('DataConcluidoSubProcedimento' . $i) || $this->input->post('SubProcedimento' . $i)) {
                $data['procedtarefa'][$j]['idApp_SubProcedimento'] = $this->input->post('idApp_SubProcedimento' . $i);
                $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->input->post('DataSubProcedimento' . $i);
                $data['procedtarefa'][$j]['DataConcluidoSubProcedimento'] = $this->input->post('DataConcluidoSubProcedimento' . $i);
                $data['procedtarefa'][$j]['HoraSubProcedimento'] = $this->input->post('HoraSubProcedimento' . $i);
                $data['procedtarefa'][$j]['HoraConcluidoSubProcedimento'] = $this->input->post('HoraConcluidoSubProcedimento' . $i);
				//$data['procedtarefa'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
                //$data['procedtarefa'][$j]['Statussubtarefa'] = $this->input->post('Statussubtarefa' . $i);
				$data['procedtarefa'][$j]['SubProcedimento'] = $this->input->post('SubProcedimento' . $i);
				$data['procedtarefa'][$j]['ConcluidoSubProcedimento'] = $this->input->post('ConcluidoSubProcedimento' . $i);
                $data['procedtarefa'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				
				(!$data['procedtarefa'][$j]['ConcluidoSubProcedimento']) ? $data['procedtarefa'][$j]['ConcluidoSubProcedimento'] = 'N' : FALSE;
				$data['radio'] = array(
					'ConcluidoSubProcedimento' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubProcedimento'], 'ConcluidoSubProcedimento' . $j, 'NS'),
				);
				($data['procedtarefa'][$j]['ConcluidoSubProcedimento'] == 'S') ? $data['div']['ConcluidoSubProcedimento' . $j] = '' : $data['div']['ConcluidoSubProcedimento' . $j] = 'style="display: none;"';
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;
		
		
        if ($id) {
            #### App_Procedimento ####
            $_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Procedimento_model->get_procedimento2($id);
            $data['orcatrata']['DataProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimento'], 'barras');
			$data['orcatrata']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoProcedimento'], 'barras');
            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
            $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
            $_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
			#$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_SubProcedimento ####
            $_SESSION['Procedtarefa'] = $data['procedtarefa'] = $this->Tarefa_model->get_procedtarefa($id);
            if (count($data['procedtarefa']) > 0) {
                $data['procedtarefa'] = array_combine(range(1, count($data['procedtarefa'])), array_values($data['procedtarefa']));
                $data['count']['PTCount'] = count($data['procedtarefa']);

                if (isset($data['procedtarefa'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++) {
                        $data['procedtarefa'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubProcedimento'], 'barras');
						$data['procedtarefa'][$j]['DataConcluidoSubProcedimento'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataConcluidoSubProcedimento'], 'barras');
						$_SESSION['Procedtarefa'][$j]['NomeCadastrou'] = $data['procedtarefa'][$j]['NomeCadastrou'];

						$data['radio'] = array(
							'ConcluidoSubProcedimento' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubProcedimento'], 'ConcluidoSubProcedimento' . $j, 'NS'),
						);
						($data['procedtarefa'][$j]['ConcluidoSubProcedimento'] == 'S') ? $data['div']['ConcluidoSubProcedimento' . $j] = '' : $data['div']['ConcluidoSubProcedimento' . $j] = 'style="display: none;"';
					}
                }
            }
		}

        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoSubProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
        $data['select']['Compartilhar'] = $this->Procedimento_model->select_compartilhar();
		//$data['select']['Marketing'] = $this->Procedimento_model->select_Marketing();
		$data['select']['Marketing'] = array (
            '1' => 'Atualização',
            '2' => 'Pesquisa',
			'3' => 'Retorno',
            '4' => 'Promoções',
			'5' => 'Felicitações',
        );
		/*
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
		*/
        $data['titulo'] = 'Marketing';
        $data['form_open_path'] = 'procedimento/alterar_Marketing';
        $data['readproc'] = 'readonly=""';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['panel2'] = 'success';
        $data['botao_Sac'] = 'default';
        $data['botao_mark'] = 'warning';
        $data['metodo'] = 4;
		
		(!$data['orcatrata']['ConcluidoProcedimento']) ? $data['orcatrata']['ConcluidoProcedimento'] = 'N' : FALSE;		
		$data['radio'] = array(
            'ConcluidoProcedimento' => $this->basico->radio_checked($data['orcatrata']['ConcluidoProcedimento'], 'Procedimento Concluido', 'NS'),
        );
        ($data['orcatrata']['ConcluidoProcedimento'] == 'S') ?
            $data['div']['ConcluidoProcedimento'] = '' : $data['div']['ConcluidoProcedimento'] = 'style="display: none;"';		

    /*
		//if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

	*/
		$data['collapse'] = '';
	
		$data['collapse1'] = 'class="collapse"';
	/*	
        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
	*/

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

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Procedimento ####
        //$this->form_validation->set_rules('Procedimento', 'Procedimento', 'required|trim');
        $this->form_validation->set_rules('Marketing', 'Marketing', 'required|trim');
        $this->form_validation->set_rules('Compartilhar', 'Quem Fazer', 'required|trim');
		if($data['orcatrata']['ConcluidoProcedimento'] == "S"){
			$this->form_validation->set_rules('DataConcluidoProcedimento', 'Concluído em:', 'required|trim|valid_date');
		}else{
			$data['orcatrata']['DataConcluidoProcedimento'] = "00/00/0000";
		}

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimento/form_procedcli', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Procedimento ####
            $data['orcatrata']['DataProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimento'], 'mysql');
			$data['orcatrata']['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoProcedimento'], 'mysql');
			#$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            #$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            #$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['orcatrata']['anterior'] = $this->Procedimento_model->get_procedimento2($data['orcatrata']['idApp_Procedimento']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_Procedimento'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Procedimento_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_Procedimento']);

            #### App_SubProcedimento ####
            $data['update']['procedtarefa']['anterior'] = $this->Tarefa_model->get_procedtarefa($data['orcatrata']['idApp_Procedimento']);
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
					$data['update']['procedtarefa']['inserir'][$j]['TipoSubProcedimento'] = 4;
                    $data['update']['procedtarefa']['inserir'][$j]['idApp_Procedimento'] = $data['orcatrata']['idApp_Procedimento'];
                    $data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataSubProcedimento'], 'mysql');
					$data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubProcedimento'], 'mysql');
                }

                $max = count($data['update']['procedtarefa']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataSubProcedimento'], 'mysql');
					$data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubProcedimento'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubProcedimento'], 'mysql');
                }

                if (count($data['update']['procedtarefa']['inserir']))
                    $data['update']['procedtarefa']['bd']['inserir'] = $this->Tarefa_model->set_procedtarefa($data['update']['procedtarefa']['inserir']);

                if (count($data['update']['procedtarefa']['alterar']))
                    $data['update']['procedtarefa']['bd']['alterar'] =  $this->Tarefa_model->update_procedtarefa($data['update']['procedtarefa']['alterar']);

                if (count($data['update']['procedtarefa']['excluir']))
                    $data['update']['procedtarefa']['bd']['excluir'] = $this->Tarefa_model->delete_procedtarefa($data['update']['procedtarefa']['excluir']);

            }
			
            //if ($data['idApp_Procedimento'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('procedimento/form_procedcli', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				unset($_SESSION['Orcatrata'], $_SESSION['Procedtarefa']);
                //redirect(base_url() . 'procedimento/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                redirect(base_url() . 'Procedimento/tela_Marketing/' . $data['orcatrata']['idApp_Procedimento'] . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function listar_Marketing($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$this->load->model('Cliente_model');
		
		if ($id) {
            $data['cliente']['idApp_Cliente'] = $id;
			$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($id, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($id);
			$_SESSION['Cliente']['NomeCompleto'] = $data['resumo']['NomeCliente'];
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
		}
		
        //$_SESSION['OrcaTrata'] = $this->Procedimento_model->get_cliente($id, TRUE);
        //$_SESSION['OrcaTrata']['idApp_Cliente'] = $id;
        $data['atualizacao_concl'] = $this->Procedimento_model->list_atualizacao($id, 'S', TRUE);
        $data['atualizacao_nao_concl'] = $this->Procedimento_model->list_atualizacao($id, 'N', TRUE);
        $data['pesquisa_concl'] = $this->Procedimento_model->list_pesquisa($id, 'S', TRUE);
        $data['pesquisa_nao_concl'] = $this->Procedimento_model->list_pesquisa($id, 'N', TRUE);
        $data['retorno_concl'] = $this->Procedimento_model->list_retorno($id, 'S', TRUE);
        $data['retorno_nao_concl'] = $this->Procedimento_model->list_retorno($id, 'N', TRUE);
        $data['promocao_concl'] = $this->Procedimento_model->list_promocao($id, 'S', TRUE);
        $data['promocao_nao_concl'] = $this->Procedimento_model->list_promocao($id, 'N', TRUE);
        $data['felicitacao_concl'] = $this->Procedimento_model->list_felicitacao($id, 'S', TRUE);
        $data['felicitacao_nao_concl'] = $this->Procedimento_model->list_felicitacao($id, 'N', TRUE);
		
		$data['titulo'] = 'Marketing';

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('procedimento/list_Marketing', $data, TRUE);
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('procedimento/list_Marketing', $data);

        $this->load->view('basico/footer');
    }
  
	public function tela_Marketing($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($id) {
            #### App_OrcaTrata ####
            $data['procedimento'] = $this->Procedimento_model->get_procedimento($id);
            $data['procedimento']['DataProcedimento'] = $this->basico->mascara_data($data['procedimento']['DataProcedimento'], 'barras');
			if($data['procedimento']['Marketing'] == 1){
				$data['procedimento']['Marketing'] = 'Atualização';
			}elseif($data['procedimento']['Marketing'] == 2){
				$data['procedimento']['Marketing'] = 'Pesquisa';
			}elseif($data['procedimento']['Marketing'] == 3){
				$data['procedimento']['Marketing'] = 'Retorno';
			}elseif($data['procedimento']['Marketing'] == 4){
				$data['procedimento']['Marketing'] = 'Promoções';
			}elseif($data['procedimento']['Marketing'] == 5){
				$data['procedimento']['Marketing'] = 'Felicitações';
			}
            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
			if($data['procedimento']['idApp_Cliente'] != 0 && $data['procedimento']['idApp_Cliente'] != 1){
				//$data['cliente'] = $this->Cliente_model->get_cliente($data['procedimento']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['procedimento']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
			}
			
			//$data['usuario'] = $this->Usuario_model->get_usuario($data['procedimento']['idSis_Usuario'], TRUE);
			$data['query'] = $this->Procedimento_model->get_procedimento($data['procedimento']['idApp_Procedimento'], TRUE);

            #### App_Procedimento ####
            $data['subprocedimento'] = $this->Procedimento_model->get_subprocedimento($id);
            if (count($data['subprocedimento']) > 0) {
                $data['subprocedimento'] = array_combine(range(1, count($data['subprocedimento'])), array_values($data['subprocedimento']));
                $data['count']['PMCount'] = count($data['subprocedimento']);

                if (isset($data['subprocedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
                        $data['subprocedimento'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['subprocedimento'][$j]['DataSubProcedimento'], 'barras');


                }
            }

        }
		
        $data['titulo'] = 'Marketing';
        $data['form_open_path'] = 'Procedimento/tela_Marketing';
        $data['panel2'] = 'success';
        $data['metodo'] = 3;
        $data['alterar'] = 'Marketing';
        $data['cor_Sac'] = 'default';
        $data['cor_Marketing'] = 'warning';
        $data['imprimir'] = 'Marketing';			

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('procedimento/tela_procedimento', $data);

        $this->load->view('basico/footer');

    }
   
	public function imprimir_Marketing($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($id) {
            #### App_OrcaTrata ####
            $data['procedimento'] = $this->Procedimento_model->get_procedimento($id);
            $data['procedimento']['DataProcedimento'] = $this->basico->mascara_data($data['procedimento']['DataProcedimento'], 'barras');
			if($data['procedimento']['Marketing'] == 1){
				$data['procedimento']['Marketing'] = 'Atualização';
			}elseif($data['procedimento']['Marketing'] == 2){
				$data['procedimento']['Marketing'] = 'Pesquisa';
			}elseif($data['procedimento']['Marketing'] == 3){
				$data['procedimento']['Marketing'] = 'Retorno';
			}elseif($data['procedimento']['Marketing'] == 4){
				$data['procedimento']['Marketing'] = 'Promoções';
			}elseif($data['procedimento']['Marketing'] == 5){
				$data['procedimento']['Marketing'] = 'Felicitações';
			}
            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
			if($data['procedimento']['idApp_Cliente'] != 0 && $data['procedimento']['idApp_Cliente'] != 1){
				//$data['cliente'] = $this->Cliente_model->get_cliente($data['procedimento']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['procedimento']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
			}
			
			//$data['usuario'] = $this->Usuario_model->get_usuario($data['procedimento']['idSis_Usuario'], TRUE);
			$data['query'] = $this->Procedimento_model->get_procedimento($data['procedimento']['idApp_Procedimento'], TRUE);

            #### App_Procedimento ####
            $data['subprocedimento'] = $this->Procedimento_model->get_subprocedimento($id);
            if (count($data['subprocedimento']) > 0) {
                $data['subprocedimento'] = array_combine(range(1, count($data['subprocedimento'])), array_values($data['subprocedimento']));
                $data['count']['PMCount'] = count($data['subprocedimento']);

                if (isset($data['subprocedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
                        $data['subprocedimento'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['subprocedimento'][$j]['DataSubProcedimento'], 'barras');


                }
            }

        }
		
        $data['titulo'] = 'Marketing';
        $data['form_open_path'] = 'Procedimento/imprimir_Marketing';
        $data['panel2'] = 'success';
        $data['metodo'] = 4;
        $data['alterar'] = 'Marketing';
        $data['cor_Sac'] = 'default';
        $data['cor_Marketing'] = 'warning';
        $data['imprimir'] = 'Marketing';			

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('procedimento/print_procedimento', $data);

        $this->load->view('basico/footer');

    }

    public function imprimir_lista_Marketing($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		
		
		$data['bd']['idSis_Empresa'] = $id;
		$data['bd']['TipoProcedimento'] = 4;
		
        $data['titulo'] = 'Marketing';
        $data['form_open_path'] = 'Procedimento/imprimir_lista_Marketing';
        $data['panel'] = 'success';
		$data['metodo'] = 4;
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'Procedimento/imprimir_Marketing/';
		$data['imprimirlista'] = 'Procedimento/imprimir_lista_Marketing/';
		$data['imprimirrecibo'] = 'Procedimento/imprimirreciborec/';
		$data['caminho'] = 'relatorio/proc_Marketing/';			
		
		//$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio4'], 'barras');
		//$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim4'], 'barras');

		//$this->load->library('pagination');
		$config['per_page'] = 10;
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
		$data['Pesquisa'] = '';
		
        if ($id) {

			$config['base_url'] = base_url() . 'Procedimento/imprimir_lista_Marketing/' . $id . '/';
			$config['total_rows'] = $this->Procedimento_model->get_procedimento_empresa($data['bd'], TRUE);
		   
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
				
            #### App_Procedimento ####
            $data['procedimento'] = $this->Procedimento_model->get_procedimento_empresa($data['bd'], FALSE, $config['per_page'], ($page * $config['per_page']));
			if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['POCount'] = count($data['procedimento']);           

				if (isset($data['procedimento'])) {

                    for($j=1;$j<=$data['count']['POCount'];$j++) {
						$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');
						$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->basico->mascara_palavra_completa($data['procedimento'][$j]['ConcluidoProcedimento'], 'NS');
						if($data['procedimento'][$j]['Marketing'] == 1){
							$data['procedimento'][$j]['Marketing'] = 'Atualização';
						}elseif($data['procedimento'][$j]['Marketing'] == 2){
							$data['procedimento'][$j]['Marketing'] = 'Pesquisa';
						}elseif($data['procedimento'][$j]['Marketing'] == 3){
							$data['procedimento'][$j]['Marketing'] = 'Retorno';
						}elseif($data['procedimento'][$j]['Marketing'] == 4){
							$data['procedimento'][$j]['Marketing'] = 'Promoções';
						}elseif($data['procedimento'][$j]['Marketing'] == 5){
							$data['procedimento'][$j]['Marketing'] = 'Felicitações';
						}
					}
				}	
			}
			
			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['procedimento']);
			  echo "</pre>";
			  exit ();
			  */
			
            #### App_Procedimento ####
            $data['subprocedimento'] = $this->Procedimento_model->get_subprocedimento_empresa($data['bd'],TRUE);
            
			if (count($data['subprocedimento']) > 0) {
                $data['subprocedimento'] = array_combine(range(1, count($data['subprocedimento'])), array_values($data['subprocedimento']));
                $data['count']['PMCount'] = count($data['subprocedimento']);

                if (isset($data['subprocedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++){
                        $data['subprocedimento'][$j]['DataSubProcedimento'] = $this->basico->mascara_data($data['subprocedimento'][$j]['DataSubProcedimento'], 'barras');	
						$data['subprocedimento'][$j]['ConcluidoSubProcedimento'] = $this->basico->mascara_palavra_completa($data['subprocedimento'][$j]['ConcluidoSubProcedimento'], 'NS');					
					}
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

        //$this->load->view('orcatrata/print_orcatratacobranca_lista', $data);
        $this->load->view('procedimento/print_lista', $data);

        $this->load->view('basico/footer');

    }
	
    public function excluirproc($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

                $this->Procedimento_model->delete_orcatrata($id);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'procedimento/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'procedimento/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/orcamento/' . $data['msg']);
                exit();

        $this->load->view('basico/footer');
    }
	
}
