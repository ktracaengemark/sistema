<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Sac extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array('Basico_model', 'Sac_model', 'Sac_model', 'Usuario_model', 'Relatorio_model', 'Formapag_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('sac/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('sac/tela_index', $data);

        #load footer view
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
            #### App_Sac ####
            //'idApp_Sac',
            'idSis_Usuario',
			'idApp_Cliente',
            'DataSac',
            'HoraSac',
			'DataConcluidoSac',
			'HoraConcluidoSac',
			'Sac',
			'ConcluidoSac',
			'CategoriaSac',
			'Compartilhar',

        ), TRUE));

        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
        //Data de hoje como default
        (!$data['orcatrata']['DataSac']) ? $data['orcatrata']['DataSac'] = date('d/m/Y H:i:s', time()) : FALSE;
        (!$data['orcatrata']['HoraSac']) ? $data['orcatrata']['HoraSac'] = date('H:i:s', time()) : FALSE;
		(!$data['orcatrata']['Compartilhar']) ? $data['orcatrata']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'] : FALSE;
		$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('DataConcluidoSubSac' . $i) || $this->input->post('SubSac' . $i)) {
                $data['procedtarefa'][$j]['DataSubSac'] = $this->input->post('DataSubSac' . $i);
                $data['procedtarefa'][$j]['HoraSubSac'] = $this->input->post('HoraSubSac' . $i);
                $data['procedtarefa'][$j]['DataConcluidoSubSac'] = $this->input->post('DataConcluidoSubSac' . $i);
                $data['procedtarefa'][$j]['HoraConcluidoSubSac'] = $this->input->post('HoraConcluidoSubSac' . $i);
				//$data['procedtarefa'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
                //$data['procedtarefa'][$j]['Statussubtarefa'] = $this->input->post('Statussubtarefa' . $i);
				$data['procedtarefa'][$j]['SubSac'] = $this->input->post('SubSac' . $i);
				$data['procedtarefa'][$j]['ConcluidoSubSac'] = $this->input->post('ConcluidoSubSac' . $i);
                $data['procedtarefa'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				
				(!$data['procedtarefa'][$j]['ConcluidoSubSac']) ? $data['procedtarefa'][$j]['ConcluidoSubSac'] = 'N' : FALSE;
				$data['radio'] = array(
					'ConcluidoSubSac' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubSac'], 'ConcluidoSubSac' . $j, 'NS'),
				);
				($data['procedtarefa'][$j]['ConcluidoSubSac'] == 'S') ? $data['div']['ConcluidoSubSac' . $j] = '' : $data['div']['ConcluidoSubSac' . $j] = 'style="display: none;"';
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;		

        $data['select']['ConcluidoSac'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoSubSac'] = $this->Basico_model->select_status_sn();
        $data['select']['Compartilhar'] = $this->Sac_model->select_compartilhar();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['CategoriaSac'] = array (
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
        $data['form_open_path'] = 'sac/cadastrar_Sac';
        $data['readproc'] = '';
		$data['readonly'] = '';
		$data['disabled'] = '';
		$data['panel'] = 'primary';
        $data['panel2'] = 'warning';
        $data['botao_Sac'] = 'warning';
        $data['botao_mark'] = 'default';
        $data['metodo'] = 1;

		(!$data['orcatrata']['ConcluidoSac']) ? $data['orcatrata']['ConcluidoSac'] = 'N' : FALSE;		
		$data['radio'] = array(
            'ConcluidoSac' => $this->basico->radio_checked($data['orcatrata']['ConcluidoSac'], 'Sac Concluido', 'NS'),
        );
        ($data['orcatrata']['ConcluidoSac'] == 'S') ?
            $data['div']['ConcluidoSac'] = '' : $data['div']['ConcluidoSac'] = 'style="display: none;"';
		
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
		
        $data['cor_cli'] 	= 'default';
        $data['cor_cons'] 	= 'default';
        $data['cor_orca'] 	= 'default';
        $data['cor_sac'] 	= 'warning';
        $data['cor_mark'] 	= 'default';

		$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Sac ####
        $this->form_validation->set_rules('Sac', 'Sac', 'required|trim');
        $this->form_validation->set_rules('CategoriaSac', 'Tipo', 'required|trim');
        $this->form_validation->set_rules('Compartilhar', 'Quem Fazer', 'required|trim');
		if($data['orcatrata']['ConcluidoSac'] == "S"){
			$this->form_validation->set_rules('DataConcluidoSac', 'Concluído em:', 'required|trim|valid_date');
		}else{
			$data['orcatrata']['DataConcluidoSac'] = "0000-00-00";
			//$data['orcatrata']['DataConcluidoSac'] = "00/00/0000";
			$data['orcatrata']['HoraConcluidoSac'] = "00:00:00";		
		}
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('sac/form_sac', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Sac ####
			/*
			if($data['orcatrata']['ConcluidoSac'] == "N"){
				$data['orcatrata']['DataConcluidoSac'] = "0000-00-00";
				//$data['orcatrata']['DataConcluidoSac'] = "00/00/0000";
				$data['orcatrata']['HoraConcluidoSac'] = "00:00:00";
			}
			*/
            $data['orcatrata']['DataSac'] = $this->basico->mascara_data($data['orcatrata']['DataSac'], 'mysql');
			$data['orcatrata']['DataConcluidoSac'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoSac'], 'mysql');
			$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['orcatrata']['TipoSac'] = 3;
            $data['orcatrata']['idApp_Sac'] = $this->Sac_model->set_orcatrata($data['orcatrata']);
            
			if ($data['orcatrata']['idApp_Sac'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('sac/form_sac', $data);
				
            } else {
			
				#### App_SubSac ####
				if (isset($data['procedtarefa'])) {
					$max = count($data['procedtarefa']);
					for($j=1;$j<=$max;$j++) {
						$data['procedtarefa'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						$data['procedtarefa'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
						$data['procedtarefa'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
						$data['procedtarefa'][$j]['TipoSubSac'] = 3;
						$data['procedtarefa'][$j]['idApp_Sac'] = $data['orcatrata']['idApp_Sac'];
						$data['procedtarefa'][$j]['DataSubSac'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubSac'], 'mysql');

						if(!$data['procedtarefa'][$j]['DataConcluidoSubSac']){
							$data['procedtarefa'][$j]['DataConcluidoSubSac'] = "0000-00-00";
						}else{
							$data['procedtarefa'][$j]['DataConcluidoSubSac'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataConcluidoSubSac'], 'mysql');
						}
					
					}
					$data['procedtarefa']['idApp_SubSac'] = $this->Sac_model->set_procedtarefa($data['procedtarefa']);
				}			

				/*
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
							$data['campos'] = array_keys($data['query']);
							$data['anterior'] = array();
							//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
				//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
				*/



                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Sac'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Sac', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'sac/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                redirect(base_url() . 'Sac/tela_Sac/' . $data['orcatrata']['idApp_Sac'] . $data['msg']);

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
            #### App_Sac ####
			'idApp_Sac',
            'idSis_Usuario',
            #Não há a necessidade de atualizar o valor do campo a seguir
            #'idApp_Cliente',
            'DataSac',
			'DataConcluidoSac',
            'HoraSac',
			'HoraConcluidoSac',
			'Sac',
			'ConcluidoSac',
			'CategoriaSac',
			'Compartilhar',

        ), TRUE));

        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$data['orcatrata']['Compartilhar']) ? $data['orcatrata']['Compartilhar'] = $_SESSION['log']['idSis_Usuario'] : FALSE;
		

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('DataSubSac' . $i) || $this->input->post('DataConcluidoSubSac' . $i) || $this->input->post('SubSac' . $i)) {
                //$data['procedtarefa'][$j]['idApp_SubSac'] = $this->input->post('idApp_SubSac' . $i);
                $data['procedtarefa'][$j]['DataSubSac'] = $this->input->post('DataSubSac' . $i);
                $data['procedtarefa'][$j]['DataConcluidoSubSac'] = $this->input->post('DataConcluidoSubSac' . $i);
                $data['procedtarefa'][$j]['HoraSubSac'] = $this->input->post('HoraSubSac' . $i);
                $data['procedtarefa'][$j]['HoraConcluidoSubSac'] = $this->input->post('HoraConcluidoSubSac' . $i);
				//$data['procedtarefa'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
                //$data['procedtarefa'][$j]['Statussubtarefa'] = $this->input->post('Statussubtarefa' . $i);
				$data['procedtarefa'][$j]['SubSac'] = $this->input->post('SubSac' . $i);
				$data['procedtarefa'][$j]['ConcluidoSubSac'] = $this->input->post('ConcluidoSubSac' . $i);
                $data['procedtarefa'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				
				(!$data['procedtarefa'][$j]['ConcluidoSubSac']) ? $data['procedtarefa'][$j]['ConcluidoSubSac'] = 'N' : FALSE;
				$data['radio'] = array(
					'ConcluidoSubSac' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubSac'], 'ConcluidoSubSac' . $j, 'NS'),
				);
				($data['procedtarefa'][$j]['ConcluidoSubSac'] == 'S') ? $data['div']['ConcluidoSubSac' . $j] = '' : $data['div']['ConcluidoSubSac' . $j] = 'style="display: none;"';
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;
		
		
        if ($id) {
            #### App_Sac ####
            $_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Sac_model->get_sac2($id);
            $data['orcatrata']['DataSac'] = $this->basico->mascara_data($data['orcatrata']['DataSac'], 'barras');
			$data['orcatrata']['DataConcluidoSac'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoSac'], 'barras');
			#### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
            $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
            $_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
			#$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_SubSac ####
            $_SESSION['Procedtarefa'] = $data['procedtarefa'] = $this->Sac_model->get_procedtarefa($id);
            if (count($data['procedtarefa']) > 0) {
                $data['procedtarefa'] = array_combine(range(1, count($data['procedtarefa'])), array_values($data['procedtarefa']));
                $data['count']['PTCount'] = count($data['procedtarefa']);

                if (isset($data['procedtarefa'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++) {
                        $data['procedtarefa'][$j]['DataSubSac'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataSubSac'], 'barras');
						$data['procedtarefa'][$j]['DataConcluidoSubSac'] = $this->basico->mascara_data($data['procedtarefa'][$j]['DataConcluidoSubSac'], 'barras');
						$_SESSION['Procedtarefa'][$j]['NomeCadastrou'] = $data['procedtarefa'][$j]['NomeCadastrou'];				
						
						$data['radio'] = array(
							'ConcluidoSubSac' . $j => $this->basico->radio_checked($data['procedtarefa'][$j]['ConcluidoSubSac'], 'ConcluidoSubSac' . $j, 'NS'),
						);
						($data['procedtarefa'][$j]['ConcluidoSubSac'] == 'S') ? $data['div']['ConcluidoSubSac' . $j] = '' : $data['div']['ConcluidoSubSac' . $j] = 'style="display: none;"';
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
        $data['select']['ConcluidoSac'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoSubSac'] = $this->Basico_model->select_status_sn();
        $data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
        $data['select']['Compartilhar'] = $this->Sac_model->select_compartilhar();
		$data['select']['CategoriaSac'] = array (
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
        $data['form_open_path'] = 'sac/alterar_Sac';
        $data['readproc'] = 'readonly=""';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['panel2'] = 'warning';
        $data['botao_Sac'] = 'warning';
        $data['botao_mark'] = 'default';
        $data['metodo'] = 2;
        $data['alterar'] = 'Sac';
        $data['imprimir'] = 'Sac';	
		
		(!$data['orcatrata']['ConcluidoSac']) ? $data['orcatrata']['ConcluidoSac'] = 'N' : FALSE;		
		$data['radio'] = array(
            'ConcluidoSac' => $this->basico->radio_checked($data['orcatrata']['ConcluidoSac'], 'Sac Concluido', 'NS'),
        );
        ($data['orcatrata']['ConcluidoSac'] == 'S') ?
            $data['div']['ConcluidoSac'] = '' : $data['div']['ConcluidoSac'] = 'style="display: none;"';		

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

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		
        $data['cor_cli'] 	= 'default';
        $data['cor_cons'] 	= 'default';
        $data['cor_orca'] 	= 'default';
        $data['cor_sac'] 	= 'warning';
        $data['cor_mark'] 	= 'default';
		
        $data['nav_sac'] 			= 'S';
        $data['nav_sac_editar'] 	= 'N';
		
        $data['nav_sac_imprimir'] 	= 'N';
        $data['nav_sac_inteiro'] 	= 'S';
        $data['nav_sac_resumido'] 	= 'S';

		$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Sac ####
        $this->form_validation->set_rules('Sac', 'Sac', 'required|trim');
        $this->form_validation->set_rules('CategoriaSac', 'Tipo', 'required|trim');
        $this->form_validation->set_rules('Compartilhar', 'Quem Fazer', 'required|trim');
		if($data['orcatrata']['ConcluidoSac'] == "S"){
			$this->form_validation->set_rules('DataConcluidoSac', 'Concluído em:', 'required|trim|valid_date');
		}else{
			$data['orcatrata']['DataConcluidoSac'] = "0000-00-00";
		}
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('sac/form_sac', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Sac ####
            $data['orcatrata']['DataSac'] = $this->basico->mascara_data($data['orcatrata']['DataSac'], 'mysql');
			$data['orcatrata']['DataConcluidoSac'] = $this->basico->mascara_data($data['orcatrata']['DataConcluidoSac'], 'mysql');
			#$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            #$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            #$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['orcatrata']['anterior'] = $this->Sac_model->get_sac2($data['orcatrata']['idApp_Sac']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_Sac'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Sac_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_Sac']);

            #### App_SubSac ####
            $data['update']['procedtarefa']['anterior'] = $this->Sac_model->get_procedtarefa($data['orcatrata']['idApp_Sac']);
            if (isset($data['procedtarefa']) || (!isset($data['procedtarefa']) && isset($data['update']['procedtarefa']['anterior']) ) ) {

                if (isset($data['procedtarefa']))
                    $data['procedtarefa'] = array_values($data['procedtarefa']);
                else
                    $data['procedtarefa'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['procedtarefa'] = $this->basico->tratamento_array_multidimensional($data['procedtarefa'], $data['update']['procedtarefa']['anterior'], 'idApp_SubSac');

                $max = count($data['update']['procedtarefa']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedtarefa']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['procedtarefa']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['procedtarefa']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['procedtarefa']['inserir'][$j]['TipoSubSac'] = 3;
                    $data['update']['procedtarefa']['inserir'][$j]['idApp_Sac'] = $data['orcatrata']['idApp_Sac'];
                    
					$data['update']['procedtarefa']['inserir'][$j]['DataSubSac'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataSubSac'], 'mysql');
					
					if(!$data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubSac']){
						$data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubSac'] = "0000-00-00";
					}else{
						$data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubSac'] = $this->basico->mascara_data($data['update']['procedtarefa']['inserir'][$j]['DataConcluidoSubSac'], 'mysql');
					}
                
				}

                $max = count($data['update']['procedtarefa']['alterar']);
                for($j=0;$j<$max;$j++) {
                    
					$data['update']['procedtarefa']['alterar'][$j]['DataSubSac'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataSubSac'], 'mysql');
					
					if(!$data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubSac']){
						$data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubSac'] = "0000-00-00";
					}else{
						$data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubSac'] = $this->basico->mascara_data($data['update']['procedtarefa']['alterar'][$j]['DataConcluidoSubSac'], 'mysql');
					}
				}

                if (count($data['update']['procedtarefa']['inserir']))
                    $data['update']['procedtarefa']['bd']['inserir'] = $this->Sac_model->set_procedtarefa($data['update']['procedtarefa']['inserir']);

                if (count($data['update']['procedtarefa']['alterar']))
                    $data['update']['procedtarefa']['bd']['alterar'] =  $this->Sac_model->update_procedtarefa($data['update']['procedtarefa']['alterar']);

                if (count($data['update']['procedtarefa']['excluir']))
                    $data['update']['procedtarefa']['bd']['excluir'] = $this->Sac_model->delete_procedtarefa($data['update']['procedtarefa']['excluir']);

            }
			
            //if ($data['idApp_Sac'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('sac/form_sac', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Sac'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Sac', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';
				
				unset($_SESSION['Orcatrata'], $_SESSION['Procedtarefa']);
                //redirect(base_url() . 'sac/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                //redirect(base_url() . 'Sac/tela_Sac/' . $data['orcatrata']['idApp_Sac'] . $data['msg']);
                redirect(base_url() . 'relatorio/sac/' . $data['msg']);

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
		
        //$_SESSION['OrcaTrata'] = $this->Sac_model->get_cliente($id, TRUE);
        //$_SESSION['OrcaTrata']['idApp_Cliente'] = $id;
        $data['informacao_concl'] = $this->Sac_model->list_informacao($id, 'S', TRUE);
        $data['informacao_nao_concl'] = $this->Sac_model->list_informacao($id, 'N', TRUE);
        $data['elogio_concl'] = $this->Sac_model->list_elogio($id, 'S', TRUE);
        $data['elogio_nao_concl'] = $this->Sac_model->list_elogio($id, 'N', TRUE);
        $data['reclamacao_concl'] = $this->Sac_model->list_reclamacao($id, 'S', TRUE);
        $data['reclamacao_nao_concl'] = $this->Sac_model->list_reclamacao($id, 'N', TRUE);
		
		$data['titulo'] = 'Sac';
        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('sac/list_sac', $data, TRUE);
		
        $data['cor_cli'] 	= 'default';
        $data['cor_cons'] 	= 'default';
        $data['cor_orca'] 	= 'default';
        $data['cor_sac'] 	= 'warning';
        $data['cor_mark'] 	= 'default';

		$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('sac/list_sac', $data);

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
            $data['sac'] = $this->Sac_model->get_sac($id);
            $data['sac']['DataSac'] = $this->basico->mascara_data($data['sac']['DataSac'], 'barras');
			if($data['sac']['CategoriaSac'] == 1){
				$data['sac']['CategoriaSac'] = 'Solicitação';
			}elseif($data['sac']['CategoriaSac'] == 2){
				$data['sac']['CategoriaSac'] = 'Elogio';
			}elseif($data['sac']['CategoriaSac'] == 3){
				$data['sac']['CategoriaSac'] = 'Reclamação';
			}
            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
			if($data['sac']['idApp_Cliente'] != 0 && $data['sac']['idApp_Cliente'] != 1){
				//$data['cliente'] = $this->Cliente_model->get_cliente($data['sac']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['sac']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
			}
			
			//$data['usuario'] = $this->Usuario_model->get_usuario($data['sac']['idSis_Usuario'], TRUE);
			$data['orcatrata'] = $this->Sac_model->get_sac($data['sac']['idApp_Sac'], TRUE);

            #### App_Sac ####
            $data['subsac'] = $this->Sac_model->get_subsac($id);
            if (count($data['subsac']) > 0) {
                $data['subsac'] = array_combine(range(1, count($data['subsac'])), array_values($data['subsac']));
                $data['count']['PMCount'] = count($data['subsac']);

                if (isset($data['subsac'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
                        $data['subsac'][$j]['DataSubSac'] = $this->basico->mascara_data($data['subsac'][$j]['DataSubSac'], 'barras');


                }
            }

        }
		
        $data['titulo'] = 'Sac';
        $data['form_open_path'] = 'Sac/tela_Sac';
        $data['panel2'] = 'warning';
        $data['metodo'] = 1;
        $data['alterar'] = 'Sac';
        $data['imprimir'] = 'Sac';	
        $data['cor_Sac'] = 'warning';
        $data['cor_Marketing'] = 'default';		

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
        $data['cor_sac'] 	= 'warning';
        $data['cor_mark'] 	= 'default';
		
        $data['nav_sac'] 			= 'S';
        $data['nav_sac_editar'] 	= 'S';
		
        $data['nav_sac_imprimir'] 	= 'S';
        $data['nav_sac_inteiro'] 	= 'N';
        $data['nav_sac_resumido'] 	= 'S';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('sac/tela_sac', $data);

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
            $data['sac'] = $this->Sac_model->get_sac($id);
            $data['sac']['DataSac'] = $this->basico->mascara_data($data['sac']['DataSac'], 'barras');
			if($data['sac']['CategoriaSac'] == 1){
				$data['sac']['CategoriaSac'] = 'Solicitação';
			}elseif($data['sac']['CategoriaSac'] == 2){
				$data['sac']['CategoriaSac'] = 'Elogio';
			}elseif($data['sac']['CategoriaSac'] == 3){
				$data['sac']['CategoriaSac'] = 'Reclamação';
			}
            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
			if($data['sac']['idApp_Cliente'] != 0 && $data['sac']['idApp_Cliente'] != 1){
				//$data['cliente'] = $this->Cliente_model->get_cliente($data['sac']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($data['sac']['idApp_Cliente'], TRUE);
				$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
			}
			
			//$data['usuario'] = $this->Usuario_model->get_usuario($data['sac']['idSis_Usuario'], TRUE);
			$data['orcatrata'] = $this->Sac_model->get_sac($data['sac']['idApp_Sac'], TRUE);

            #### App_Sac ####
            $data['subsac'] = $this->Sac_model->get_subsac($id);
            if (count($data['subsac']) > 0) {
                $data['subsac'] = array_combine(range(1, count($data['subsac'])), array_values($data['subsac']));
                $data['count']['PMCount'] = count($data['subsac']);

                if (isset($data['subsac'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
                        $data['subsac'][$j]['DataSubSac'] = $this->basico->mascara_data($data['subsac'][$j]['DataSubSac'], 'barras');


                }
            }

        }
		
        $data['titulo'] = 'Sac';
        $data['form_open_path'] = 'Sac/imprimir_Sac';
        $data['panel2'] = 'warning';
        $data['metodo'] = 2;
        $data['alterar'] = 'Sac';
        $data['imprimir'] = 'Sac';		
        $data['cor_Sac'] = 'warning';
        $data['cor_Marketing'] = 'default';	

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
        $data['cor_sac'] 	= 'warning';
        $data['cor_mark'] 	= 'default';
		
        $data['nav_sac'] 			= 'S';
        $data['nav_sac_editar'] 	= 'S';
		
        $data['nav_sac_imprimir'] 	= 'S';
        $data['nav_sac_inteiro'] 	= 'S';
        $data['nav_sac_resumido'] 	= 'N';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('sac/print_sac', $data);

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
		$data['bd']['TipoSac'] = 3;
		
        $data['titulo'] = 'Sac';
        $data['form_open_path'] = 'Sac/imprimir_lista_Sac';
        $data['panel'] = 'warning';
		$data['metodo'] = 3;
		$data['editar'] = 1;
		$data['print'] = 1;
		$data['imprimir'] = 'Sac/imprimir/';
		$data['imprimirlista'] = 'Sac/imprimir_lista_Sac/';
		$data['imprimirrecibo'] = 'Sac/imprimirreciborec/';
		$data['caminho'] = 'relatorio/sac/';
		
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

			$config['base_url'] = base_url() . 'Sac/imprimir_lista_Sac/' . $id . '/';
			$config['total_rows'] = $this->Sac_model->get_sac_empresa($data['bd'], TRUE);
		   
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
		
            #### App_Sac ####
            $data['sac'] = $this->Sac_model->get_sac_empresa($data['bd'], FALSE, $config['per_page'], ($page * $config['per_page']));
			if (count($data['sac']) > 0) {
                $data['sac'] = array_combine(range(1, count($data['sac'])), array_values($data['sac']));
                $data['count']['POCount'] = count($data['sac']);           

				if (isset($data['sac'])) {

                    for($j=1;$j<=$data['count']['POCount'];$j++) {
						$data['sac'][$j]['DataSac'] = $this->basico->mascara_data($data['sac'][$j]['DataSac'], 'barras');
						$data['sac'][$j]['ConcluidoSac'] = $this->basico->mascara_palavra_completa($data['sac'][$j]['ConcluidoSac'], 'NS');
						if($data['sac'][$j]['CategoriaSac'] == 1){
							$data['sac'][$j]['CategoriaSac'] = 'Solicitação';
						}elseif($data['sac'][$j]['CategoriaSac'] == 2){
							$data['sac'][$j]['CategoriaSac'] = 'Elogio';
						}elseif($data['sac'][$j]['CategoriaSac'] == 3){
							$data['sac'][$j]['CategoriaSac'] = 'Reclamação';
						}
					}
				}	
			}
			
			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['sac']);
			  echo "</pre>";
			  exit ();
			  */
			
            #### App_Sac ####
            $data['subsac'] = $this->Sac_model->get_subsac_empresa($data['bd'],TRUE);
            
			if (count($data['subsac']) > 0) {
                $data['subsac'] = array_combine(range(1, count($data['subsac'])), array_values($data['subsac']));
                $data['count']['PMCount'] = count($data['subsac']);

                if (isset($data['subsac'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++){
                        $data['subsac'][$j]['DataSubSac'] = $this->basico->mascara_data($data['subsac'][$j]['DataSubSac'], 'barras');	
						$data['subsac'][$j]['ConcluidoSubSac'] = $this->basico->mascara_palavra_completa($data['subsac'][$j]['ConcluidoSubSac'], 'NS');					
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

        $this->load->view('sac/print_lista', $data);

        $this->load->view('basico/footer');

    }
	
    public function excluirproc($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

                $this->Sac_model->delete_orcatrata($id);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'sac/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'sac/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/orcamento/' . $data['msg']);
                exit();

        $this->load->view('basico/footer');
    }
	
}
