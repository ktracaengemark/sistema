<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array('Basico_model', 'Marketing_model', 'Usuario_model', 'Relatorio_model', 'Formapag_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('marketing/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('marketing/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar_Marketing($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
			#### App_Marketing ####
			//'idApp_Marketing',
			'idSis_Usuario',
			'idApp_Cliente',
			'DataMarketing',
			'HoraMarketing',
			'DataConcluidoMarketing',
			'HoraConcluidoMarketing',
			'Marketing',
			'ConcluidoMarketing',
			'CategoriaMarketing',
			'Compartilhar',

		), TRUE));

		#### Carrega os dados do cliente nas vari�ves de sess�o ####
		if($idApp_Cliente){
			
			$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			
			if($data['cliente'] === FALSE){
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} 
		}

		if(!$_SESSION['Cliente']){
			unset($_SESSION['Cliente']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
		
			(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
			//Data de hoje como default
			(!$data['orcatrata']['DataMarketing']) ? $data['orcatrata']['DataMarketing'] = date('d/m/Y H:i:s', time()) : FALSE;
			(!$data['orcatrata']['HoraMarketing']) ? $data['orcatrata']['HoraMarketing'] = date('H:i:s', time()) : FALSE;
			(!$data['orcatrata']['Compartilhar']) ? $data['orcatrata']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'] : FALSE;
			$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

				if ($this->input->post('DataConcluidoSubMarketing' . $i) || $this->input->post('SubMarketing' . $i)) {
					$data['procedtarefa'][$j]['DataSubMarketing'] = $this->input->post('DataSubMarketing' . $i);
					$data['procedtarefa'][$j]['HoraSubMarketing'] = $this->input->post('HoraSubMarketing' . $i);
					$data['procedtarefa'][$j]['DataConcluidoSubMarketing'] = $this->input->post('DataConcluidoSubMarketing' . $i);
					$data['procedtarefa'][$j]['HoraConcluidoSubMarketing'] = $this->input->post('HoraConcluidoSubMarketing' . $i);
					//$data['procedtarefa'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
					//$data['procedtarefa'][$j]['Statussubtarefa'] = $this->input->post('Statussubtarefa' . $i);
					$data['procedtarefa'][$j]['SubMarketing'] = $this->input->post('SubMarketing' . $i);
					$data['procedtarefa'][$j]['ConcluidoSubMarketing'] = $this->input->post('ConcluidoSubMarketing' . $i);
					$data['procedtarefa'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					
					(!$data['procedtarefa'][$j]['ConcluidoSubMarketing']) ? $data['procedtarefa'][$j]['ConcluidoSubMarketing'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoSubMarketing' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubMarketing'], 'ConcluidoSubMarketing' . $j, 'NS'),
					);
					($data['procedtarefa'][$j]['ConcluidoSubMarketing'] == 'S') ? $data['div']['ConcluidoSubMarketing' . $j] = '' : $data['div']['ConcluidoSubMarketing' . $j] = 'style="display: none;"';
					$j++;
				}

			}
			$data['count']['PTCount'] = $j - 1;		

			$data['select']['ConcluidoMarketing'] = $this->Basico_model->select_status_sn();
			$data['select']['ConcluidoSubMarketing'] = $this->Basico_model->select_status_sn();
			$data['select']['Compartilhar'] = $this->Marketing_model->select_compartilhar();
			$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
			$data['select']['CategoriaMarketing'] = array (
				'1' => 'Atualiza��o',
				'2' => 'Pesquisa',
				'3' => 'Retorno',
				'4' => 'Promo��es',
				'5' => 'Felicita��es',
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
			$data['form_open_path'] = 'marketing/cadastrar_Marketing';
			$data['readproc'] = '';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['panel2'] = 'success';
			$data['botao_Marketing'] = 'warning';
			$data['botao_Sac'] = 'default';
			$data['metodo'] = 3;

			(!$data['orcatrata']['ConcluidoMarketing']) ? $data['orcatrata']['ConcluidoMarketing'] = 'N' : FALSE;		
			$data['radio'] = array(
				'ConcluidoMarketing' => $this->basico->radio_checked($data['orcatrata']['ConcluidoMarketing'], 'Marketing Concluido', 'NS'),
			);
			($data['orcatrata']['ConcluidoMarketing'] == 'S') ?
				$data['div']['ConcluidoMarketing'] = '' : $data['div']['ConcluidoMarketing'] = 'style="display: none;"';

			$data['collapse'] = '';	

			$data['collapse1'] = 'class="collapse"';	

			$data['sidebar'] = 'col-sm-3 col-md-2';
			$data['main'] = 'col-sm-7 col-md-8';

			$data['datepicker'] = 'DatePicker';
			$data['timepicker'] = 'TimePicker';

			$data['cor_cli'] 	= 'default';
			$data['cor_cons'] 	= 'default';
			$data['cor_orca'] 	= 'default';
			$data['cor_sac'] 	= 'default';
			$data['cor_mark'] 	= 'warning';
			
			$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data);
			  echo "</pre>";
			  exit ();
			  */

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			#### App_Marketing ####
			$this->form_validation->set_rules('Marketing', 'Marketing', 'required|trim');
			$this->form_validation->set_rules('CategoriaMarketing', 'Tipo', 'required|trim');
			$this->form_validation->set_rules('Compartilhar', 'Quem Fazer', 'required|trim');
			if($data['orcatrata']['ConcluidoMarketing'] == "S"){
				$this->form_validation->set_rules('DataConcluidoMarketing', 'Conclu�do em:', 'required|trim|valid_date');
			}else{
				$data['orcatrata']['DataConcluidoMarketing'] = "0000-00-00";
				//$data['orcatrata']['DataConcluidoMarketing'] = "00/00/0000";
				$data['orcatrata']['HoraConcluidoMarketing'] = "00:00:00";		
			}
			
			#run form validation
			if ($this->form_validation->run() === FALSE) {
				//if (1 == 1) {
				$this->load->view('marketing/form_marketing', $data);
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {
							
					////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
					#### App_Marketing ####
					/*
					if($data['orcatrata']['ConcluidoMarketing'] == "N"){
						$data['orcatrata']['DataConcluidoMarketing'] = "0000-00-00";
						//$data['orcatrata']['DataConcluidoMarketing'] = "00/00/0000";
						$data['orcatrata']['HoraConcluidoMarketing'] = "00:00:00";
					}
					*/
					$data['orcatrata']['DataMarketing'] = $this->basico->mascara_data($data['orcatrata']['DataMarketing'], 'mysql');
					$data['orcatrata']['DataConcluidoMarketing'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoMarketing'], 'mysql');
					$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['orcatrata']['TipoMarketing'] = 4;
					$data['orcatrata']['NivelMarketing'] = $_SESSION['Usuario']['Nivel'];
					$data['orcatrata']['idApp_Marketing'] = $this->Marketing_model->set_orcatrata($data['orcatrata']);
					
					if ($data['orcatrata']['idApp_Marketing'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('marketing/form_marketing', $data);
						
					} else {
					
						#### App_SubMarketing ####
						if (isset($data['procedtarefa'])) {
							$max = count($data['procedtarefa']);
							for($j=1;$j<=$max;$j++) {
								$data['procedtarefa'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['procedtarefa'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['procedtarefa'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['procedtarefa'][$j]['TipoSubMarketing'] = 4;
								$data['procedtarefa'][$j]['NivelSubMarketing'] = $_SESSION['Usuario']['Nivel'];
								$data['procedtarefa'][$j]['idApp_Marketing'] = $data['orcatrata']['idApp_Marketing'];
								$data['procedtarefa'][$j]['DataSubMarketing'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubMarketing'], 'mysql');

								if(!$data['procedtarefa'][$j]['DataConcluidoSubMarketing']){
									$data['procedtarefa'][$j]['DataConcluidoSubMarketing'] = "0000-00-00";
								}else{
									$data['procedtarefa'][$j]['DataConcluidoSubMarketing'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataConcluidoSubMarketing'], 'mysql');
								}
							
							}
							$data['procedtarefa']['idApp_SubMarketing'] = $this->Marketing_model->set_procedtarefa($data['procedtarefa']);
						}			

						/*
						/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
									$data['campos'] = array_keys($data['query']);
									$data['anterior'] = array();
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
						//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
						*/



						//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Marketing'], FALSE);
						//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Marketing', 'CREATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';

						//redirect(base_url() . 'marketing/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
						redirect(base_url() . 'Marketing/tela_Marketing/' . $data['orcatrata']['idApp_Marketing'] . $data['msg']);

						exit();
					}
				}
			}
		}
	
        $this->load->view('basico/footer');
    }
	
    public function alterar_Marketing($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
			#### App_Marketing ####
			'idApp_Marketing',
			'idSis_Usuario',
			#N�o h� a necessidade de atualizar o valor do campo a seguir
			#'idApp_Cliente',
			'DataMarketing',
			'DataConcluidoMarketing',
			'HoraMarketing',
			'HoraConcluidoMarketing',
			'Marketing',
			'ConcluidoMarketing',
			'CategoriaMarketing',
			'Compartilhar',

		), TRUE));

		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$data['orcatrata']['Compartilhar']) ? $data['orcatrata']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'] : FALSE;
		

		$j = 1;
		for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

			if ($this->input->post('DataSubMarketing' . $i) || $this->input->post('DataConcluidoSubMarketing' . $i) || $this->input->post('SubMarketing' . $i)) {
				//$data['procedtarefa'][$j]['idApp_SubMarketing'] = $this->input->post('idApp_SubMarketing' . $i);
				$data['procedtarefa'][$j]['DataSubMarketing'] = $this->input->post('DataSubMarketing' . $i);
				$data['procedtarefa'][$j]['DataConcluidoSubMarketing'] = $this->input->post('DataConcluidoSubMarketing' . $i);
				$data['procedtarefa'][$j]['HoraSubMarketing'] = $this->input->post('HoraSubMarketing' . $i);
				$data['procedtarefa'][$j]['HoraConcluidoSubMarketing'] = $this->input->post('HoraConcluidoSubMarketing' . $i);
				//$data['procedtarefa'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
				//$data['procedtarefa'][$j]['Statussubtarefa'] = $this->input->post('Statussubtarefa' . $i);
				$data['procedtarefa'][$j]['SubMarketing'] = $this->input->post('SubMarketing' . $i);
				$data['procedtarefa'][$j]['ConcluidoSubMarketing'] = $this->input->post('ConcluidoSubMarketing' . $i);
				$data['procedtarefa'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				
				(!$data['procedtarefa'][$j]['ConcluidoSubMarketing']) ? $data['procedtarefa'][$j]['ConcluidoSubMarketing'] = 'N' : FALSE;
				$data['radio'] = array(
					'ConcluidoSubMarketing' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubMarketing'], 'ConcluidoSubMarketing' . $j, 'NS'),
				);
				($data['procedtarefa'][$j]['ConcluidoSubMarketing'] == 'S') ? $data['div']['ConcluidoSubMarketing' . $j] = '' : $data['div']['ConcluidoSubMarketing' . $j] = 'style="display: none;"';
				$j++;
			}

		}
		$data['count']['PTCount'] = $j - 1;
		
		
		if ($id) {
			#### App_Marketing ####
			$_SESSION['Marketing'] = $data['orcatrata'] = $this->Marketing_model->get_marketing2($id);
		
			if($data['orcatrata'] === FALSE){
				
				unset($_SESSION['Marketing']);
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {			
					
				$data['orcatrata']['DataMarketing'] = $this->basico->mascara_data($data['orcatrata']['DataMarketing'], 'barras');
				$data['orcatrata']['DataConcluidoMarketing'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoMarketing'], 'barras');

				#### App_SubMarketing ####
				$_SESSION['Procedtarefa'] = $data['procedtarefa'] = $this->Marketing_model->get_procedtarefa($id);
				if (count($data['procedtarefa']) > 0) {
					$data['procedtarefa'] = array_combine(range(1, count($data['procedtarefa'])), array_values($data['procedtarefa']));
					$data['count']['PTCount'] = count($data['procedtarefa']);

					if (isset($data['procedtarefa'])) {

						for($j=1; $j <= $data['count']['PTCount']; $j++) {
							$data['procedtarefa'][$j]['DataSubMarketing'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubMarketing'], 'barras');
							$data['procedtarefa'][$j]['DataConcluidoSubMarketing'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataConcluidoSubMarketing'], 'barras');
							$_SESSION['Procedtarefa'][$j]['NomeCadastrou'] = $data['procedtarefa'][$j]['NomeCadastrou'];				
							
							$data['radio'] = array(
								'ConcluidoSubMarketing' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubMarketing'], 'ConcluidoSubMarketing' . $j, 'NS'),
							);
							($data['procedtarefa'][$j]['ConcluidoSubMarketing'] == 'S') ? $data['div']['ConcluidoSubMarketing' . $j] = '' : $data['div']['ConcluidoSubMarketing' . $j] = 'style="display: none;"';
						}
					}
				}
			}	
		}
		
		if(!$data['orcatrata']['idApp_Marketing'] || !$_SESSION['Marketing']){
			
			unset($_SESSION['Marketing']);
			unset($_SESSION['Cliente']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			#### Carrega os dados do cliente nas vari�ves de sess�o ####
			$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($_SESSION['Marketing']['idApp_Cliente'], TRUE);

			if($data['query'] === FALSE){
				
				unset($_SESSION['Marketing']);
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];

				/*
				echo '<br>';
				echo "<pre>";
				print_r($_SESSION['Marketing']);
				echo "</pre>";
				//exit ();
				*/
				$data['select']['ConcluidoMarketing'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoSubMarketing'] = $this->Basico_model->select_status_sn();
				$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
				$data['select']['Compartilhar'] = $this->Marketing_model->select_compartilhar();
				$data['select']['CategoriaMarketing'] = array (
					'1' => 'Atualiza��o',
					'2' => 'Pesquisa',
					'3' => 'Retorno',
					'4' => 'Promo��es',
					'5' => 'Felicita��es',
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
				$data['form_open_path'] = 'marketing/alterar_Marketing';
				$data['readproc'] = 'readonly=""';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['panel2'] = 'success';
				$data['botao_Marketing'] = 'warning';
				$data['botao_Sac'] = 'default';
				$data['metodo'] = 4;
				$data['alterar'] = 'Marketing';
				$data['imprimir'] = 'Marketing';
				
				(!$data['orcatrata']['ConcluidoMarketing']) ? $data['orcatrata']['ConcluidoMarketing'] = 'N' : FALSE;		
				$data['radio'] = array(
					'ConcluidoMarketing' => $this->basico->radio_checked($data['orcatrata']['ConcluidoMarketing'], 'Marketing Concluido', 'NS'),
				);
				($data['orcatrata']['ConcluidoMarketing'] == 'S') ?
					$data['div']['ConcluidoMarketing'] = '' : $data['div']['ConcluidoMarketing'] = 'style="display: none;"';		

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
				#Ver uma solu��o melhor para este campo
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;

				$data['radio'] = array(
					'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
				);

				($data['orcatrata']['AprovadoOrca'] == 'S') ?
					$data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
				*/

				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';

				$data['cor_cli'] 	= 'default';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'default';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'warning';
				
				$data['nav_mark'] 			= 'S';
				$data['nav_mark_editar'] 	= 'N';
				
				$data['nav_mark_imprimir'] 	= 'N';
				$data['nav_mark_inteiro'] 	= 'S';
				$data['nav_mark_resumido'] 	= 'S';

				$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data);
				  echo "</pre>";
				  exit ();
				*/
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				#### App_Marketing ####
				$this->form_validation->set_rules('Marketing', 'Marketing', 'required|trim');
				$this->form_validation->set_rules('CategoriaMarketing', 'Tipo', 'required|trim');
				$this->form_validation->set_rules('Compartilhar', 'Quem Fazer', 'required|trim');
				if($data['orcatrata']['ConcluidoMarketing'] == "S"){
					$this->form_validation->set_rules('DataConcluidoMarketing', 'Conclu�do em:', 'required|trim|valid_date');
				}else{
					$data['orcatrata']['DataConcluidoMarketing'] = "0000-00-00";
				}
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('marketing/form_marketing', $data);
				} else {
		
					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
							
						////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
						#### App_Marketing ####
						$data['orcatrata']['DataMarketing'] = $this->basico->mascara_data($data['orcatrata']['DataMarketing'], 'mysql');
						$data['orcatrata']['DataConcluidoMarketing'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoMarketing'], 'mysql');
						#$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
						#$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						#$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

						$data['update']['orcatrata']['anterior'] = $this->Marketing_model->get_marketing2($data['orcatrata']['idApp_Marketing']);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$data['orcatrata']['idApp_Marketing'], TRUE);
						$data['update']['orcatrata']['bd'] = $this->Marketing_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_Marketing']);

						#### App_SubMarketing ####
						$data['update']['procedtarefa']['anterior'] = $this->Marketing_model->get_procedtarefa($data['orcatrata']['idApp_Marketing']);
						if (isset($data['procedtarefa']) || (!isset($data['procedtarefa']) && isset($data['update']['procedtarefa']['anterior']) ) ) {

							if (isset($data['procedtarefa']))
								$data['procedtarefa'] = array_values($data['procedtarefa']);
							else
								$data['procedtarefa'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['procedtarefa'] = $this->basico->tratamento_array_multidimensional($data['procedtarefa'], $data['update']['procedtarefa']['anterior'], 'idApp_SubMarketing');

							$max = count($data['update']['procedtarefa']['inserir']);
							for($j=0;$j<$max;$j++) {
								$data['update']['procedtarefa']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['update']['procedtarefa']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['procedtarefa']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['procedtarefa']['inserir'][$j]['TipoSubMarketing'] = 4;
								$data['update']['procedtarefa']['inserir'][$j]['NivelSubMarketing'] = $_SESSION['Marketing']['NivelMarketing'];
								$data['update']['procedtarefa']['inserir'][$j]['idApp_Marketing'] = $data['orcatrata']['idApp_Marketing'];
								
								$data['update']['procedtarefa']['inserir'][$j]['DataSubMarketing'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataSubMarketing'], 'mysql');
								
								if(!$data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubMarketing']){
									$data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubMarketing'] = "0000-00-00";
								}else{
									$data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubMarketing'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubMarketing'], 'mysql');
								}
							
							}

							$max = count($data['update']['procedtarefa']['alterar']);
							for($j=0;$j<$max;$j++) {
								
								$data['update']['procedtarefa']['alterar'][$j]['DataSubMarketing'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataSubMarketing'], 'mysql');
								
								if(!$data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubMarketing']){
									$data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubMarketing'] = "0000-00-00";
								}else{
									$data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubMarketing'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubMarketing'], 'mysql');
								}
							}

							if (count($data['update']['procedtarefa']['inserir']))
								$data['update']['procedtarefa']['bd']['inserir'] = $this->Marketing_model->set_procedtarefa($data['update']['procedtarefa']['inserir']);

							if (count($data['update']['procedtarefa']['alterar']))
								$data['update']['procedtarefa']['bd']['alterar'] =  $this->Marketing_model->update_procedtarefa($data['update']['procedtarefa']['alterar']);

							if (count($data['update']['procedtarefa']['excluir']))
								$data['update']['procedtarefa']['bd']['excluir'] = $this->Marketing_model->delete_procedtarefa($data['update']['procedtarefa']['excluir']);

						}
						
						//if ($data['idApp_Marketing'] === FALSE) {
						//if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
						if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('marketing/form_marketing', $data);
						} else {

							//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Marketing'], FALSE);
							//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Marketing', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
							
							unset($_SESSION['Marketing'], $_SESSION['Procedtarefa']);
							//redirect(base_url() . 'marketing/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
							//redirect(base_url() . 'Marketing/tela_Marketing/' . $data['orcatrata']['idApp_Marketing'] . $data['msg']);
							redirect(base_url() . 'marketing/marketing/' . $data['msg']);

							exit();
						}
					}
				}
			}	
		}	
		
        $this->load->view('basico/footer');

    }

    public function listar_Marketing($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($id, TRUE);

			if($_SESSION['Cliente'] === FALSE){
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				$data['atualizacao_concl'] = $this->Marketing_model->list_atualizacao($id, 'S', TRUE);
				$data['atualizacao_nao_concl'] = $this->Marketing_model->list_atualizacao($id, 'N', TRUE);
				$data['pesquisa_concl'] = $this->Marketing_model->list_pesquisa($id, 'S', TRUE);
				$data['pesquisa_nao_concl'] = $this->Marketing_model->list_pesquisa($id, 'N', TRUE);
				$data['retorno_concl'] = $this->Marketing_model->list_retorno($id, 'S', TRUE);
				$data['retorno_nao_concl'] = $this->Marketing_model->list_retorno($id, 'N', TRUE);
				$data['promocao_concl'] = $this->Marketing_model->list_promocao($id, 'S', TRUE);
				$data['promocao_nao_concl'] = $this->Marketing_model->list_promocao($id, 'N', TRUE);
				$data['felicitacao_concl'] = $this->Marketing_model->list_felicitacao($id, 'S', TRUE);
				$data['felicitacao_nao_concl'] = $this->Marketing_model->list_felicitacao($id, 'N', TRUE);		
				
				$data['titulo'] = 'Marketing';
				//$data['aprovado'] = array();
				//$data['naoaprovado'] = array();
				/*
				  echo "<pre>";
				  print_r($data['query']);
				  echo "</pre>";
				  exit();
				 */

				$data['list'] = $this->load->view('marketing/list_marketing', $data, TRUE);
				
				$data['cor_cli'] 	= 'default';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'default';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'warning';

				$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

				$this->load->view('marketing/list_marketing', $data);
			}
			
		}
			
        $this->load->view('basico/footer');
    }
     
	public function tela_Marketing($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{

			#### App_OrcaTrata ####
			$_SESSION['Marketing'] = $data['marketing'] = $this->Marketing_model->get_marketing2($id);
		
			if($data['marketing'] === FALSE){
				
				unset($_SESSION['Marketing']);
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {			
				
				#### Carrega os dados do cliente nas vari�ves de sess�o ####

				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['marketing']['idApp_Cliente'], TRUE);

				if($data['cliente'] === FALSE){
					
					unset($_SESSION['Marketing']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
						
					$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];

					$data['marketing']['DataMarketing'] = $this->basico->mascara_data($data['marketing']['DataMarketing'], 'barras');
					if($data['marketing']['CategoriaMarketing'] == 1){
						$data['marketing']['CategoriaMarketing'] = 'Atualiza��o';
					}elseif($data['marketing']['CategoriaMarketing'] == 2){
						$data['marketing']['CategoriaMarketing'] = 'Pesquisa';
					}elseif($data['marketing']['CategoriaMarketing'] == 3){
						$data['marketing']['CategoriaMarketing'] = 'Retorno';
					}elseif($data['marketing']['CategoriaMarketing'] == 4){
						$data['marketing']['CategoriaMarketing'] = 'Promo��es';
					}elseif($data['marketing']['CategoriaMarketing'] == 5){
						$data['marketing']['CategoriaMarketing'] = 'Felicita��es';
					}			
					
					#### Carrega os dados do cliente nas vari�ves de sess�o ####
					$this->load->model('Cliente_model');
					if($data['marketing']['idApp_Cliente'] != 0 && $data['marketing']['idApp_Cliente'] != 1){
						//$data['cliente'] = $this->Cliente_model->get_cliente($data['marketing']['idApp_Cliente'], TRUE);
						$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['marketing']['idApp_Cliente'], TRUE);
						$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
					}
					
					//$data['usuario'] = $this->Usuario_model->get_usuario($data['marketing']['idSis_Usuario'], TRUE);
					//$data['orcatrata'] = $this->Marketing_model->get_marketing($data['marketing']['idApp_Marketing'], TRUE);

					#### App_Marketing ####
					$data['submarketing'] = $this->Marketing_model->get_submarketing($id);
					if (count($data['submarketing']) > 0) {
						$data['submarketing'] = array_combine(range(1, count($data['submarketing'])), array_values($data['submarketing']));
						$data['count']['PMCount'] = count($data['submarketing']);

						if (isset($data['submarketing'])) {

							for($j=1; $j <= $data['count']['PMCount']; $j++)
								$data['submarketing'][$j]['DataSubMarketing'] = $this->basico->mascara_data($data['submarketing'][$j]['DataSubMarketing'], 'barras');


						}
					}
				
					$data['titulo'] = 'Marketing';
					$data['form_open_path'] = 'Marketing/tela_Marketing';
					$data['panel2'] = 'success';
					$data['metodo'] = 1;
					$data['alterar'] = 'Marketing';
					$data['imprimir'] = 'Marketing';
					$data['cor_Marketing'] = 'warning';
					$data['cor_Sac'] = 'default';			

					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$data['cor_cli'] 	= 'default';
					$data['cor_cons'] 	= 'default';
					$data['cor_orca'] 	= 'default';
					$data['cor_sac'] 	= 'default';
					$data['cor_mark'] 	= 'warning';
					
					$data['nav_mark'] 			= 'S';
					$data['nav_mark_editar'] 	= 'S';
					
					$data['nav_mark_imprimir'] 	= 'S';
					$data['nav_mark_inteiro'] 	= 'N';
					$data['nav_mark_resumido'] 	= 'S';

					$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

					$this->load->view('marketing/tela_marketing', $data);
				}
			}
		}
        $this->load->view('basico/footer');

    }
     
	public function imprimir_Marketing($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{

			#### App_OrcaTrata ####
			$_SESSION['Marketing'] = $data['marketing'] = $this->Marketing_model->get_marketing2($id);
		
			if($data['marketing'] === FALSE){
				
				unset($_SESSION['Marketing']);
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {			
								
				#### Carrega os dados do cliente nas vari�ves de sess�o ####

				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['marketing']['idApp_Cliente'], TRUE);

				if($data['cliente'] === FALSE){
					
					unset($_SESSION['Marketing']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
						
					$data['marketing']['DataMarketing'] = $this->basico->mascara_data($data['marketing']['DataMarketing'], 'barras');
					if($data['marketing']['CategoriaMarketing'] == 1){
						$data['marketing']['CategoriaMarketing'] = 'Atualiza��o';
					}elseif($data['marketing']['CategoriaMarketing'] == 2){
						$data['marketing']['CategoriaMarketing'] = 'Pesquisa';
					}elseif($data['marketing']['CategoriaMarketing'] == 3){
						$data['marketing']['CategoriaMarketing'] = 'Retorno';
					}elseif($data['marketing']['CategoriaMarketing'] == 4){
						$data['marketing']['CategoriaMarketing'] = 'Promo��es';
					}elseif($data['marketing']['CategoriaMarketing'] == 5){
						$data['marketing']['CategoriaMarketing'] = 'Felicita��es';
					}			

					#### Carrega os dados do cliente nas vari�ves de sess�o ####
					$this->load->model('Cliente_model');
					if($data['marketing']['idApp_Cliente'] != 0 && $data['marketing']['idApp_Cliente'] != 1){
						//$data['cliente'] = $this->Cliente_model->get_cliente($data['marketing']['idApp_Cliente'], TRUE);
						$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['marketing']['idApp_Cliente'], TRUE);
						$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
					}
					
					//$data['usuario'] = $this->Usuario_model->get_usuario($data['marketing']['idSis_Usuario'], TRUE);
					//$data['orcatrata'] = $this->Marketing_model->get_marketing($data['marketing']['idApp_Marketing'], TRUE);

					#### App_Marketing ####
					$data['submarketing'] = $this->Marketing_model->get_submarketing($id);
					if (count($data['submarketing']) > 0) {
						$data['submarketing'] = array_combine(range(1, count($data['submarketing'])), array_values($data['submarketing']));
						$data['count']['PMCount'] = count($data['submarketing']);

						if (isset($data['submarketing'])) {

							for($j=1; $j <= $data['count']['PMCount']; $j++)
								$data['submarketing'][$j]['DataSubMarketing'] = $this->basico->mascara_data($data['submarketing'][$j]['DataSubMarketing'], 'barras');


						}
					}

					$data['titulo'] = 'Marketing';
					$data['form_open_path'] = 'Marketing/imprimir_Marketing';
					$data['panel2'] = 'success';
					$data['metodo'] = 2;
					$data['alterar'] = 'Marketing';
					$data['imprimir'] = 'Marketing';	
					$data['cor_Marketing'] = 'warning';
					$data['cor_Sac'] = 'default';		

					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$data['cor_cli'] 	= 'default';
					$data['cor_cons'] 	= 'default';
					$data['cor_orca'] 	= 'default';
					$data['cor_sac'] 	= 'default';
					$data['cor_mark'] 	= 'warning';
					
					$data['nav_mark'] 			= 'S';
					$data['nav_mark_editar'] 	= 'S';
					
					$data['nav_mark_imprimir'] 	= 'S';
					$data['nav_mark_inteiro'] 	= 'S';
					$data['nav_mark_resumido'] 	= 'N';

					$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

					$this->load->view('marketing/print_marketing', $data);
				}
			}
		}
        $this->load->view('basico/footer');

    }
	
    public function excluirproc($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if (!$id) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$_SESSION['Marketing'] = $data['marketing'] = $this->Marketing_model->get_marketing2($id);
			
			if($data['marketing'] === FALSE){
				unset($_SESSION['Marketing']);
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($_SESSION['Marketing']['idApp_Cliente'], TRUE);
			
				if($data['cliente'] === FALSE){
					
					unset($_SESSION['Marketing']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
		
					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
							
						/*
						#$this->Marketing_model->delete_orcatrata($id);
						#$data['msg'] = '?m=1';
						#redirect(base_url() . 'marketing/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
						*/
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						exit();
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function marketing() {
		
		unset($_SESSION['FiltroMarketing']);

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Registro N�o Encontrada.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa est� muito grande, ela excedeu 15000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'id_Cliente_Auto',
			'NomeClienteAuto',
        ), TRUE));	

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Marketing',
            'Sac',
            'CategoriaMarketing',
            'Orcamento',
			'idTab_TipoRD',
            'Cliente',
			'idApp_Cliente',
			'NomeUsuario',
			'Compartilhar',
			'DataInicio9',
            'DataFim9',
			'DataInicio10',
            'DataFim10',
			'HoraInicio9',
            'HoraFim9',
			'HoraInicio10',
            'HoraFim10',
			'ConcluidoMarketing',
            'Ordenamento',
            'Campo',
            'TipoMarketing',
			'Agrupar',
        ), TRUE));		

        $data['select']['ConcluidoMarketing'] = array(
			'#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['Sac'] = array (
            '0' => 'Todos',
            '1' => 'Solicita��o',
            '2' => 'Elogio',
			'3' => 'Reclama��o',
        );
		
		$data['select']['CategoriaMarketing'] = array (
            '0' => 'Todos',
            '1' => 'Atualiza��o',
            '2' => 'Pesquisa',
			'3' => 'Retorno',
            '4' => 'Promo��es',
			'5' => 'Felicita��es',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',
			'idApp_Marketing' => 'Campanha',
			'idApp_Cliente' => 'Cliente',
        );
		
		$data['select']['Campo'] = array(
			'PRC.DataMarketing' => 'Data',
            'PRC.idApp_Marketing' => 'id',
			'PRC.ConcluidoMarketing' => 'Concl.',
			'PRC.idSis_Usuario' => 'Quem Cadastrou',
			'PRC.Compartilhar' => 'Quem Fazer',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        $data['select']['NomeUsuario'] = $this->Relatorio_model->select_usuario();
		$data['select']['Compartilhar'] = $this->Relatorio_model->select_compartilhar();

		$data['query']['TipoMarketing'] = 4;
		$data['query']['Sac'] = 0;	
        $data['titulo1'] = 'Marketing';
		$data['tipoproc'] = 4;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'marketing/marketing';
		$data['panel'] = 'success';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 0;
        $data['nome'] = 'Cliente';
		$data['editar'] = 0;
		$data['print'] = 1;
		$data['imprimir'] = 'Marketing/imprimir/';
		$data['imprimirlista'] = 'Marketing/marketing_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'N';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		$this->form_validation->set_rules('DataInicio9', 'Data In�cio do Marketing', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim9', 'Data Fim do Marketing', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio10', 'Data In�cio do SubMarketing', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim10', 'Data Fim do SubMarketing', 'trim|valid_date');
		$this->form_validation->set_rules('HoraInicio9', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim9', 'Hora Final', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraInicio10', 'Hora Inicial', 'trim|valid_hour');
		$this->form_validation->set_rules('HoraFim10', 'Hora Final', 'trim|valid_hour');

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

			$_SESSION['FiltroMarketing']['idApp_Marketing'] = $data['query']['idApp_Marketing'];
			$_SESSION['FiltroMarketing']['Sac'] = $data['query']['Sac'];
			$_SESSION['FiltroMarketing']['CategoriaMarketing'] = $data['query']['CategoriaMarketing'];
			$_SESSION['FiltroMarketing']['Orcamento'] = $data['query']['Orcamento'];
			$_SESSION['FiltroMarketing']['idTab_TipoRD'] = $data['query']['idTab_TipoRD'];
			$_SESSION['FiltroMarketing']['Cliente'] = $data['query']['Cliente'];
			$_SESSION['FiltroMarketing']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$_SESSION['FiltroMarketing']['NomeUsuario'] = $data['query']['NomeUsuario'];
			$_SESSION['FiltroMarketing']['Compartilhar'] = $data['query']['Compartilhar'];
			$_SESSION['FiltroMarketing']['TipoMarketing'] = $data['query']['TipoMarketing'];
			$_SESSION['FiltroMarketing']['ConcluidoMarketing'] = $data['query']['ConcluidoMarketing'];
			$_SESSION['FiltroMarketing']['DataInicio9'] = $this->basico->mascara_data($data['query']['DataInicio9'], 'mysql');
			$_SESSION['FiltroMarketing']['DataFim9'] = $this->basico->mascara_data($data['query']['DataFim9'], 'mysql');
			$_SESSION['FiltroMarketing']['DataInicio10'] = $this->basico->mascara_data($data['query']['DataInicio10'], 'mysql');
			$_SESSION['FiltroMarketing']['DataFim10'] = $this->basico->mascara_data($data['query']['DataFim10'], 'mysql');
			$_SESSION['FiltroMarketing']['HoraInicio9'] = $data['query']['HoraInicio9'];
			$_SESSION['FiltroMarketing']['HoraFim9'] = $data['query']['HoraFim9'];
			$_SESSION['FiltroMarketing']['HoraInicio10'] = $data['query']['HoraInicio10'];
			$_SESSION['FiltroMarketing']['HoraFim10'] = $data['query']['HoraFim10'];
			$_SESSION['FiltroMarketing']['Agrupar'] = $data['query']['Agrupar'];
			$_SESSION['FiltroMarketing']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroMarketing']['Ordenamento'] = $data['query']['Ordenamento'];

			$data['pesquisa_query'] = $this->Marketing_model->listar_marketing($_SESSION['FiltroMarketing'], FALSE, TRUE, FALSE, FALSE, FALSE);
			
			if($data['pesquisa_query'] === FALSE){
				$data['msg'] = '?m=4';
				redirect(base_url() . 'Marketing/marketing' . $data['msg']);
				exit();
			}else{

				$config['base_url'] = base_url() . 'marketing/marketing_pag/';
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

				$config['total_rows'] = $data['pesquisa_query']->num_rows();

				if($config['total_rows'] >= 1){
					$data['total_rows'] = $config['total_rows'];
				}else{
					$data['total_rows'] = 0;
				}
				
				$this->pagination->initialize($config);
				
				$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
				$data['pagina'] = $page;
				$data['per_page'] = $config['per_page'];
				$data['report'] = $this->Marketing_model->listar_marketing($_SESSION['FiltroMarketing'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']), FALSE);			
				$data['pagination'] = $this->pagination->create_links();
				
				$data['list'] = $this->load->view('marketing/list_marketing2', $data, TRUE);
				//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
			}
		}	

        $this->load->view('marketing/tela_marketing2', $data);

        $this->load->view('basico/footer');

    }

    public function marketing_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query']['TipoMarketing'] = 4;
		$data['query']['Sac'] = 0;
		$data['query']['Fornecedor'] = 0;		
        $data['titulo1'] = 'Marketing';
		$data['tipoproc'] = 4;
		$data['metodo'] = 2;
		$data['form_open_path'] = 'marketing/marketing_pag';
		$data['panel'] = 'success';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 0;
        $data['nome'] = 'Cliente';
		$data['editar'] = 0;
		$data['print'] = 1;
		$data['imprimir'] = 'Marketing/imprimir/';
		$data['imprimirlista'] = 'Marketing/marketing_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'Orcatrata/baixadacobranca/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		$data['paginacao'] = 'S';
		$data['caminho'] = 'marketing/marketing/';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$data['pesquisa_query'] = $this->Marketing_model->listar_marketing($_SESSION['FiltroMarketing'], FALSE, TRUE, FALSE, FALSE, FALSE);
		
		if($data['pesquisa_query'] === FALSE){
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Marketing/marketing' . $data['msg']);
			exit();
		}else{

			$config['base_url'] = base_url() . 'marketing/marketing_pag/';
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
			
			$config['total_rows'] = $data['pesquisa_query']->num_rows();
           
			if($config['total_rows'] >= 1){
				$data['total_rows'] = $config['total_rows'];
			}else{
				$data['total_rows'] = 0;
			}
			
            $this->pagination->initialize($config);
            
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
            $data['pagina'] = $page;
			$data['per_page'] = $config['per_page'];
			$data['report'] = $this->Marketing_model->listar_marketing($_SESSION['FiltroMarketing'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']), FALSE);			
			$data['pagination'] = $this->pagination->create_links();
			
            $data['list'] = $this->load->view('marketing/list_marketing2', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('marketing/tela_marketing2', $data);

        $this->load->view('basico/footer');

    }

    public function marketing_lista($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		
		
		if (!$id) {
			
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			if($_SESSION['log']['idSis_Empresa'] !== $id){
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
					
			}else{

				$data['titulo'] = 'Marketing';
				$data['form_open_path'] = 'Marketing/marketing_lista';
				$data['panel'] = 'warning';
				$data['metodo'] = 4;
				$data['editar'] = 1;
				$data['print'] = 1;
				$data['imprimir'] = 'Marketing/imprimir/';
				$data['imprimirlista'] = 'Marketing/marketing_lista/';
				$data['imprimirrecibo'] = 'Marketing/imprimirreciborec/';
				$data['caminho'] = 'marketing/marketing_pag/';		


				$data['pesquisa_query'] = $this->Marketing_model->listar_marketing($_SESSION['FiltroMarketing'], FALSE, TRUE, FALSE, FALSE, FALSE);
		
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'Sac/sac' . $data['msg']);
					exit();
				}else{

					$config['base_url'] = base_url() . 'Marketing/marketing_lista/' . $id . '/';
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

					$config['total_rows'] = $data['pesquisa_query']->num_rows();
					
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
				
					#### App_Marketing ####
					$data['marketing'] = $this->Marketing_model->listar_marketing($_SESSION['FiltroMarketing'], FALSE, FALSE, $config['per_page'], ($page * $config['per_page']),TRUE);

					if (count($data['marketing']) > 0) {
						$data['marketing'] = array_combine(range(1, count($data['marketing'])), array_values($data['marketing']));
						$data['count']['POCount'] = count($data['marketing']);           

						if (isset($data['marketing'])) {

							for($j=1;$j<=$data['count']['POCount'];$j++) {
								$data['marketing'][$j]['DataMarketing'] = $this->basico->mascara_data($data['marketing'][$j]['DataMarketing'], 'barras');
								$data['marketing'][$j]['ConcluidoMarketing'] = $this->basico->mascara_palavra_completa($data['marketing'][$j]['ConcluidoMarketing'], 'NS');
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['marketing'][$j]['CategoriaMarketing']);
								echo "</pre>";
								*/
								if($data['marketing'][$j]['CategoriaMarketing'] == 1){
									$data['marketing'][$j]['CategoriaMarketing'] = 'Atualiza��o';
								}elseif($data['marketing'][$j]['CategoriaMarketing'] == 2){
									$data['marketing'][$j]['CategoriaMarketing'] = 'Pesquisa';
								}elseif($data['marketing'][$j]['CategoriaMarketing'] == 3){
									$data['marketing'][$j]['CategoriaMarketing'] = 'Retorno';
								}elseif($data['marketing'][$j]['CategoriaMarketing'] == 4){
									$data['marketing'][$j]['CategoriaMarketing'] = 'Promo��es';
								}elseif($data['marketing'][$j]['CategoriaMarketing'] == 5){
									$data['marketing'][$j]['CategoriaMarketing'] = 'Felicita��es';
								}else{
									$data['marketing'][$j]['CategoriaMarketing'] = 'indeterminado';
								}
								

								#### App_SubMarketing ####
								$data['submarketing'][$j] = $this->Marketing_model->listar_submarketing($data['marketing'][$j]['idApp_Marketing']);
	 
								if (count($data['submarketing'][$j]) > 0) {
									
									$data['submarketing'][$j] = array_combine(range(1, count($data['submarketing'][$j])), array_values($data['submarketing'][$j]));
									
									$data['count']['PMCount'][$j] = count($data['submarketing'][$j]);

									if (isset($data['submarketing'][$j])) {

										for($k=1; $k<=$data['count']['PMCount'][$j]; $k++){
											
											$data['submarketing'][$j][$k]['DataSubMarketing'] 		= $this->basico->mascara_data($data['submarketing'][$j][$k]['DataSubMarketing'], 'barras');	
											$data['submarketing'][$j][$k]['ConcluidoSubMarketing'] 	= $this->basico->mascara_palavra_completa($data['submarketing'][$j][$k]['ConcluidoSubMarketing'], 'NS');					
										
										}
									}
								}
							}
						}	
					}
				}
				$this->load->view('marketing/print_lista', $data);
			}
		}
        $this->load->view('basico/footer');

    }
	
}
