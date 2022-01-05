<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Campanha extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Campanha_model', 'Campanha_model', 'Formapag_model'));
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
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',		
			'AtivoCampanha',		
            'Ordenamento',
            'Campo',
			'Campanha',
			'DescCampanha',
			'TipoCampanha',
			'TipoDescCampanha',
            'ValorDesconto',
            'ValorMinimo',
            'Ganhador',
        ), TRUE));

		$_SESSION['FiltroAlteraCampanha']['AtivoCampanha'] = $data['query']['AtivoCampanha'];
		$_SESSION['FiltroAlteraCampanha']['TipoCampanha'] = $data['query']['TipoCampanha'];
		$_SESSION['FiltroAlteraCampanha']['TipoDescCampanha'] = $data['query']['TipoDescCampanha'];
		$_SESSION['FiltroAlteraCampanha']['Campanha'] = $data['query']['Campanha'];
		$_SESSION['FiltroAlteraCampanha']['DescCampanha'] = $data['query']['DescCampanha'];		
        
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['AtivoCampanha'] = array(
			'0' => '::Todos::',
			'S' => 'Sim',
			'N' => 'Não',
        );
		$data['select']['Campo'] = array(
			'P.idApp_Campanha' => 'Codigo',
			'P.TipoCampanha' => 'Tipo',
			'P.DataCampanha' => 'Data do Inicio',
			'P.DataCampanhaLimite' => 'Data da Termino.',			
			'P.AtivoCampanha' => 'Ativa',
        );

        $data['select']['Ordenamento'] = array(
			'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        $data['select']['TipoCampanha'] = array (
            '0' => '::Todos::',
			'1' => 'Sorteio',
			'2' => 'Cupom',
        );
		
        $data['select']['TipoDescCampanha'] = array (
            '0' => '::Todos::',
			'V' => 'R$',
			'P' => '.%',
        );		

        $data['titulo1'] = 'Campanhas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {


			$data['bd']['AtivoCampanha'] = $data['query']['AtivoCampanha'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['Campanha'] = $data['query']['Campanha'];
			$data['bd']['DescCampanha'] = $data['query']['DescCampanha'];
			$data['bd']['TipoCampanha'] = $data['query']['TipoCampanha'];
			$data['bd']['TipoDescCampanha'] = $data['query']['TipoDescCampanha'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			
            $data['report'] = $this->Campanha_model->list1_campanha($data['bd'],TRUE);
			/*
			$_SESSION['Campanhas'] = $data['report']->num_rows();
			echo "<pre>";
			print_r($_SESSION['Campanhas']);
			echo "</pre>";
			exit();
			*/

            $data['list1'] = $this->load->view('campanha/list1_campanha', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }		

		$this->load->view('campanha/tela_campanha', $data);

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
        $data['campanha'] = quotes_to_entities($this->input->post(array(
            #### App_Campanha ####
            //'idApp_Campanha',
            'Campanha',
            'DescCampanha',
			'DataCampanha',
			'DataCampanhaLimite',
            'AtivoCampanha',
			'TipoCampanha',
			'TipoDescCampanha',
            'ValorDesconto',
            'ValorMinimo',
            'Ganhador',
        ), TRUE));

		//(!$data['campanha']['ValorDesconto']) ? $data['campanha']['ValorDesconto'] = '0.00' : FALSE;
		//(!$data['campanha']['ValorMinimo']) ? $data['campanha']['ValorMinimo'] = '0.00' : FALSE;
		(!$data['campanha']['Ganhador']) ? $data['campanha']['Ganhador'] = '0' : FALSE;

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['AtivoCampanha'] = $this->Basico_model->select_status_sn();
		
		$data['select']['TipoCampanha'] = array (
            '1' => 'Sorteio',
            '2' => 'Cupom',
        );
		
		$data['select']['TipoDescCampanha'] = array (
            'V' => 'R$',
            'P' => '.%',
        );
				
        $data['titulo'] = 'Cadastar Campanha';
        $data['form_open_path'] = 'campanha/cadastrar';
        $data['readonly'] = '';
		$data['display'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;

		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
        (!$data['campanha']['AtivoCampanha']) ? $data['campanha']['AtivoCampanha'] = 'N' : FALSE;
        $data['radio'] = array(
            'AtivoCampanha' => $this->basico->radio_checked($data['campanha']['AtivoCampanha'], 'Campanha Ativa', 'NS'),
        );
        ($data['campanha']['AtivoCampanha'] == 'S') ?
            $data['div']['AtivoCampanha'] = '' : $data['div']['AtivoCampanha'] = 'style="display: none;"';

        (!$data['campanha']['TipoCampanha']) ? $data['campanha']['TipoCampanha'] = '1' : FALSE;
        $data['radio'] = array(
            'TipoCampanha' => $this->basico->radio_checked($data['campanha']['TipoCampanha'], 'Tipo da Campanha', '12'),
        );
        ($data['campanha']['TipoCampanha'] == '2') ?
            $data['div']['TipoCampanha'] = '' : $data['div']['TipoCampanha'] = 'style="display: none;"';

        (!$data['campanha']['TipoDescCampanha']) ? $data['campanha']['TipoDescCampanha'] = 'V' : FALSE;
        $data['radio'] = array(
            'TipoDescCampanha' => $this->basico->radio_checked($data['campanha']['TipoDescCampanha'], 'Tipo de Desc', 'VP'),
        );
        ($data['campanha']['TipoDescCampanha'] == 'P') ?
            $data['div']['TipoDescCampanha'] = '' : $data['div']['TipoDescCampanha'] = 'style="display: none;"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

		#$data['q_categoria'] = $this->Campanha_model->list_categoria($_SESSION['log'], TRUE);
		#$data['list_categoria'] = $this->load->view('campanha/list_categoria', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Campanha ####
        $this->form_validation->set_rules('Campanha', 'Campanha', 'required|trim');
        $this->form_validation->set_rules('DescCampanha', 'Premio/Regras', 'required|trim');
		$this->form_validation->set_rules('DataCampanha', 'Inicia em', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataCampanhaLimite', 'Termina em', 'required|trim|valid_date');
        $this->form_validation->set_rules('TipoCampanha', 'Tipo', 'required|trim');
		if($data['campanha']['TipoCampanha'] == 2){
			$this->form_validation->set_rules('TipoDescCampanha', 'Tipo de Desc', 'required|trim');
			$this->form_validation->set_rules('ValorDesconto', 'Valor Desconto', 'required|trim');
			$this->form_validation->set_rules('ValorMinimo', 'Valor Minimo', 'required|trim');
		}
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
            $this->load->view('campanha/form_campanha', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Campanha ####
            $data['campanha']['DataCampanha'] = $this->basico->mascara_data($data['campanha']['DataCampanha'], 'mysql');
            $data['campanha']['DataCampanhaLimite'] = $this->basico->mascara_data($data['campanha']['DataCampanhaLimite'], 'mysql');
			
			if(!$data['campanha']['DataCampanha'] || empty($data['campanha']['DataCampanha'])){
				$data['campanha']['DataCampanha'] = "0000-00-00";
			}			
			if(!$data['campanha']['DataCampanhaLimite'] || empty($data['campanha']['DataCampanhaLimite'])){
				$data['campanha']['DataCampanhaLimite'] = "0000-00-00";
			}
			if($data['campanha']['TipoCampanha'] == 1){
				$data['campanha']['ValorDesconto'] = '0.00';
				$data['campanha']['ValorMinimo'] = '0.00';;
			}else{
				$data['campanha']['ValorDesconto'] = str_replace(',', '.', str_replace('.', '', $data['campanha']['ValorDesconto']));
				$data['campanha']['ValorMinimo'] = str_replace(',', '.', str_replace('.', '', $data['campanha']['ValorMinimo']));
			}
			
			$data['campanha']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
			$data['campanha']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['campanha']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['campanha']['idApp_Campanha'] = $this->Campanha_model->set_campanha($data['campanha']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */
            if ($data['campanha']['idApp_Campanha'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('campanha/form_campanha', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Campanha'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Campanha', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'campanha/listar/' . $data['msg']);
				redirect(base_url() . 'campanha' . $data['msg']);
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

		$data['campanha'] = quotes_to_entities($this->input->post(array(
			#### App_Campanha ####
			'idApp_Campanha',
			'Campanha',
			'DescCampanha',
			'DataCampanha',
			'DataCampanhaLimite',
			'AtivoCampanha',
			'TipoCampanha',
			'TipoDescCampanha',
            'ValorDesconto',
            'ValorMinimo',
            'Ganhador',           
		), TRUE));

        //Data de hoje como default
		//(!$data['campanha']['ValorDesconto']) ? $data['campanha']['ValorDesconto'] = '0.00' : FALSE;
		//(!$data['campanha']['ValorMinimo']) ? $data['campanha']['ValorMinimo'] = '0.00' : FALSE;
		(!$data['campanha']['Ganhador']) ? $data['campanha']['Ganhador'] = '0' : FALSE;
		
        if ($id) {
            #### App_Campanha ####
            $data['campanha'] = $this->Campanha_model->get_campanha($id);
			$data['campanha']['DataCampanha'] = $this->basico->mascara_data($data['campanha']['DataCampanha'], 'barras');
            $data['campanha']['DataCampanhaLimite'] = $this->basico->mascara_data($data['campanha']['DataCampanhaLimite'], 'barras');
			if($data['campanha']['TipoCampanha'] == 1){
				$data['Tipo'] = 'Sorteio';
			}else{
				$data['Tipo'] = 'Cupom';
			}
			if($data['campanha']['TipoDescCampanha'] == 'V'){
				$data['TipoDesc'] = 'R$';
			}else{
				$data['TipoDesc'] = '.%';
			}
		/*
		echo '<br>';
        echo "<pre>";
        echo '<br>';
        print_r($data['campanha']);
        echo '<br>';
        print_r($data['campanha']['idCompartilhar']);
        echo '<br>';
        print_r($data['campanha']['NomeCompartilhar']);
        echo '<br>';
        print_r($_SESSION['Campanha']['idCompartilhar']);
        echo '<br>';
        print_r($_SESSION['Campanha']['NomeCompartilhar']);
        echo "</pre>";
        exit ();            
		*/

			
        }
		
		if($data['campanha']['TipoCampanha'] == 1){
			$data['Tipo'] = 'Sorteio';
		}else{
			$data['Tipo'] = 'Cupom';
		}
		
		if($data['campanha']['TipoDescCampanha'] == 'V'){
			$data['TipoDesc'] = 'R$';
		}else{
			$data['TipoDesc'] = '.%';
		}
				
        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['AtivoCampanha'] = $this->Basico_model->select_status_sn();

        $data['select']['TipoCampanha'] = array (
			'1' => 'Sorteio',
			'2' => 'Cupom',
        );		

        $data['select']['TipoDescCampanha'] = array (
			'V' => 'R$',
			'P' => '.%',
        );		

        $data['titulo'] = 'Editar Campanha';
        $data['form_open_path'] = 'campanha/alterar';
        //$data['readonly'] = 'readonly=""';
        $data['readonly'] = '';
		$data['disabled'] = '';
		$data['panel'] = 'primary';
        $data['metodo'] = 2;

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
        (!$data['campanha']['AtivoCampanha']) ? $data['campanha']['AtivoCampanha'] = 'N' : FALSE;
        $data['radio'] = array(
            'AtivoCampanha' => $this->basico->radio_checked($data['campanha']['AtivoCampanha'], 'Campanha Ativa', 'NS'),
        );
        ($data['campanha']['AtivoCampanha'] == 'S') ?
            $data['div']['AtivoCampanha'] = '' : $data['div']['AtivoCampanha'] = 'style="display: none;"';

        (!$data['campanha']['TipoCampanha']) ? $data['campanha']['TipoCampanha'] = '1' : FALSE;
        $data['radio'] = array(
            'TipoCampanha' => $this->basico->radio_checked($data['campanha']['TipoCampanha'], 'Tipo de Campanha', '12'),
        );
        ($data['campanha']['TipoCampanha'] == '2') ?
            $data['div']['TipoCampanha'] = '' : $data['div']['TipoCampanha'] = 'style="display: none;"';

        (!$data['campanha']['TipoDescCampanha']) ? $data['campanha']['TipoDescCampanha'] = 'V' : FALSE;
        $data['radio'] = array(
            'TipoDescCampanha' => $this->basico->radio_checked($data['campanha']['TipoDescCampanha'], 'Tipo de Desc', 'VP'),
        );
        ($data['campanha']['TipoDescCampanha'] == 'P') ?
            $data['div']['TipoDescCampanha'] = '' : $data['div']['TipoDescCampanha'] = 'style="display: none;"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

		#$data['q_categoria'] = $this->Campanha_model->list_categoria($_SESSION['log'], TRUE);
		#$data['list_categoria'] = $this->load->view('campanha/list_categoria', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Campanha ####
        $this->form_validation->set_rules('Campanha', 'Campanha', 'required|trim');
        $this->form_validation->set_rules('DescCampanha', 'Premio/Regras', 'required|trim');
		$this->form_validation->set_rules('DataCampanha', 'Inicia em', 'required|trim|valid_date');        
		$this->form_validation->set_rules('DataCampanhaLimite', 'Termina em', 'required|trim|valid_date');
        $this->form_validation->set_rules('TipoCampanha', 'Tipo', 'required|trim');
		if($data['campanha']['TipoCampanha'] == 2){
			$this->form_validation->set_rules('TipoDescCampanha', 'Tipo de Desc', 'required|trim');
			$this->form_validation->set_rules('ValorDesconto', 'Valor Desconto', 'required|trim');
			$this->form_validation->set_rules('ValorMinimo', 'Valor Minimo', 'required|trim');
		}
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
            $this->load->view('campanha/form_campanha', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Campanha ####
            $data['campanha']['DataCampanha'] = $this->basico->mascara_data($data['campanha']['DataCampanha'], 'mysql');
            $data['campanha']['DataCampanhaLimite'] = $this->basico->mascara_data($data['campanha']['DataCampanhaLimite'], 'mysql');
			if(!$data['campanha']['DataCampanha'] || empty($data['campanha']['DataCampanha'])){
				$data['campanha']['DataCampanha'] = "0000-00-00";
			}
			if(!$data['campanha']['DataCampanhaLimite'] || empty($data['campanha']['DataCampanhaLimite'])){
				$data['campanha']['DataCampanhaLimite'] = "0000-00-00";
			}			
			if($data['campanha']['TipoCampanha'] == 1){
				$data['campanha']['ValorDesconto'] = '0.00';
				$data['campanha']['ValorMinimo'] = '0.00';;
			}else{
				$data['campanha']['ValorDesconto'] = str_replace(',', '.', str_replace('.', '', $data['campanha']['ValorDesconto']));
				$data['campanha']['ValorMinimo'] = str_replace(',', '.', str_replace('.', '', $data['campanha']['ValorMinimo']));
			}

            $data['update']['campanha']['anterior'] = $this->Campanha_model->get_campanha($data['campanha']['idApp_Campanha']);
            $data['update']['campanha']['campos'] = array_keys($data['campanha']);
            $data['update']['campanha']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['campanha']['anterior'],
                $data['campanha'],
                $data['update']['campanha']['campos'],
                $data['campanha']['idApp_Campanha'], TRUE);
            $data['update']['campanha']['bd'] = $this->Campanha_model->update_campanha($data['campanha'], $data['campanha']['idApp_Campanha']);

            if ($data['auditoriaitem'] && !$data['update']['campanha']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('campanha/form_campanha', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Campanha'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Campanha', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				redirect(base_url() . 'campanha' . $data['msg']);
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
        
                $this->Campanha_model->delete_campanha($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'campanha/' . $data['msg']);
                exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

}
