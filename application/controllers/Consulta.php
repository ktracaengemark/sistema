<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Consulta extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Consulta_model', 'Orcatrata_model', 'Empresafilial_model', 'Cliente_model', 'Clientepet_model', 'Agenda_model'));
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

        $this->load->view('consulta/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($idApp_Cliente = NULL, $idApp_ContatoCliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar o novo Agendamento.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor,<br>Entre em contato com a administração da<br>Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Whatsapp',
			'Repetir',
			'Extra',
			'Adicionar',
			'Prazo',
			'DataMinima',
			'RelacaoDep',
			'PeloPet',
			'PortePet',
			'EspeciePet',
			'RacaPet',
			'Vincular',
			'NovaOS',
			'PorConsulta',
			'id_Cliente_Auto',
			'id_ClientePet_Auto',
			'NomeClientePetAuto',
			'id_ClienteDep_Auto',
			'NomeClienteDepAuto',
			'Hidden_status',
			'Hidden_Caso',
        ), TRUE));

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			//'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
            'idApp_ClientePet',
            'idApp_ClienteDep',
			'idApp_OrcaTrata',
            'Repeticao',
			//'idSis_EmpresaFilial',
            'Data2',
			'Data',
            'HoraInicio',
            'HoraFim',
            'Paciente',
			'idTab_Status',
            'idTab_TipoConsulta',
            //'idApp_ContatoCliente',
            //'idApp_Profissional',
            'Procedimento',
            'Obs',
			'Intervalo',
			'Periodo',
			'Tempo',
			'Tempo2',
			'DataTermino',
			'Recorrencias',
			'Recorrencia',
			'OS',
		), TRUE));
		
 		(!$data['cadastrar']['Hidden_Caso']) ? $data['cadastrar']['Hidden_Caso'] = 0 : FALSE;
 		(!$data['cadastrar']['Whatsapp']) ? $data['cadastrar']['Whatsapp'] = 'S' : FALSE;
 		(!$data['cadastrar']['Repetir']) ? $data['cadastrar']['Repetir'] = 'N' : FALSE;
 		(!$data['cadastrar']['Extra']) ? $data['cadastrar']['Extra'] = 'N' : FALSE;
 		(!$data['cadastrar']['Adicionar']) ? $data['cadastrar']['Adicionar'] = 'N' : FALSE;
 		(!$data['cadastrar']['Vincular']) ? $data['cadastrar']['Vincular'] = 'S' : FALSE;
 		(!$data['cadastrar']['NovaOS']) ? $data['cadastrar']['NovaOS'] = 'S' : FALSE;
 		(!$data['cadastrar']['PorConsulta']) ? $data['cadastrar']['PorConsulta'] = 'S' : FALSE;
		//(!$data['query']['Intervalo']) ? $data['query']['Intervalo'] = '1' : FALSE;
		//(!$data['query']['Periodo']) ? $data['query']['Periodo'] = '1' : FALSE;
		(!$data['query']['Recorrencias']) ? $data['query']['Recorrencias'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo2'] = '1' : FALSE;		
		
		if($_SESSION['log']['idSis_Empresa'] != 5){
			(!$data['query']['idApp_Agenda']) ? $data['query']['idApp_Agenda'] = $_SESSION['log']['Agenda'] : FALSE;
		}

		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
			$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($idApp_Cliente);
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
		}		
		
        if ($idApp_ContatoCliente) {
            $data['query']['idApp_ContatoCliente'] = $idApp_ContatoCliente;
            $data['query']['Paciente'] = 'D';
        }
		
		//// Uso esse método para cadastrar agendamentos escolhendo clientes no pesquisa clientes////
        if (isset($_SESSION['agenda']) && !$data['query']['HoraInicio'] && !$data['query']['HoraFim']) {
            $data['query']['Data'] = date('d/m/Y', $_SESSION['agenda']['HoraInicio']);
            $data['query']['Data2'] = date('d/m/Y', $_SESSION['agenda']['HoraFim']);
			$data['query']['HoraInicio'] = date('H:i', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraFim'] = date('H:i', $_SESSION['agenda']['HoraFim']);
        }		
		
		/*
		//// Uso esse método para cadastrar agendamentos escolhendo clientes no formulário////
		if ($this->input->get('start') && $this->input->get('end')) {
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['Data2'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
			$data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }
		*/
        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

		
		$data['select']['EspeciePet'] = array (
            //'0' => '',
            '1' => 'CÃO',
            '2' => 'GATO',
			'3' => 'AVE',
        );		
		$data['select']['PeloPet'] = array (
            //'0' => '',
            '1' => 'CURTO',
            '2' => 'MÉDIO',
			'3' => 'LONGO',
			'4' => 'CACHEADO',
        );		
		$data['select']['PortePet'] = array (
            //'0' => '',
            '1' => 'MINI',
            '2' => 'PEQUENO',
			'3' => 'MÉDIO',
			'4' => 'GRANDE',
			'5' => 'GIGANTE',
        );
		$data['select']['RacaPet'] = $this->Cliente_model->select_racapet();
		$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Whatsapp'] = $this->Basico_model->select_status_sn();
		$data['select']['Repetir'] = $this->Basico_model->select_status_sn();
		$data['select']['Extra'] = $this->Basico_model->select_status_sn();
		$data['select']['Adicionar'] = $this->Basico_model->select_status_sn();
		$data['select']['Vincular'] = $this->Basico_model->select_status_sn();
		$data['select']['NovaOS'] = $this->Basico_model->select_status_sn();
		$data['select']['PorConsulta'] = $this->Basico_model->select_status_sn();         
		$data['select']['Tempo'] = array (
            '1' => 'Dia(s)',
            '2' => 'Semana(s)',
            '3' => 'Mês(s)',
			'4' => 'Ano(s)',
        );		
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		$data['select']['RelacaoDep'] = $this->Cliente_model->select_relacao();
        $data['select']['idApp_ClienteDep'] = $this->Cliente_model->select_clientedep($_SESSION['Cliente']['idApp_Cliente']);
        $data['select']['idApp_ClientePet'] = $this->Cliente_model->select_clientepet($_SESSION['Cliente']['idApp_Cliente']);
        $data['select']['idApp_OrcaTrata'] = $this->Cliente_model->select_orcatrata($_SESSION['Cliente']['idApp_Cliente']);

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['titulo'] = 'Agendamento';
        $data['form_open_path'] = 'consulta/cadastrar';
        $data['panel'] = 'primary';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['metodo'] = 1;
        $data['alterarcliente'] = 2;
        $data['caminho2'] = '';
 		$data['vincular'] = 'S';
		$data['porconsulta'] = 'S';
		
		$data['exibir_id'] = 0;
		$data['count_repet'] = 0;

 		//(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
				
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Whatsapp' => $this->basico->radio_checked($data['cadastrar']['Whatsapp'], 'Whatsapp', 'NS'),
        );
        ($data['cadastrar']['Whatsapp'] == 'N') ?
            $data['div']['Whatsapp'] = '' : $data['div']['Whatsapp'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Repetir' => $this->basico->radio_checked($data['cadastrar']['Repetir'], 'Repetir', 'NS'),
        );
        ($data['cadastrar']['Repetir'] == 'S') ?
            $data['div']['Repetir'] = '' : $data['div']['Repetir'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Extra' => $this->basico->radio_checked($data['cadastrar']['Extra'], 'Extra', 'NS'),
        );
        ($data['cadastrar']['Extra'] == 'S') ?
            $data['div']['Extra'] = '' : $data['div']['Extra'] = 'style="display: none;"';
						
		$data['radio'] = array(
            'Adicionar' => $this->basico->radio_checked($data['cadastrar']['Adicionar'], 'Adicionar', 'NS'),
        );
        ($data['cadastrar']['Adicionar'] == 'S') ?
            $data['div']['Adicionar'] = '' : $data['div']['Adicionar'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'Vincular' => $this->basico->radio_checked($data['cadastrar']['Vincular'], 'Vincular', 'NS'),
        );
        ($data['cadastrar']['Vincular'] == 'N') ?
            $data['div']['Vincular'] = '' : $data['div']['Vincular'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'NovaOS' => $this->basico->radio_checked($data['cadastrar']['NovaOS'], 'NovaOS', 'NS'),
        );
        ($data['cadastrar']['NovaOS'] == 'N') ?
            $data['div']['NovaOS'] = '' : $data['div']['NovaOS'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'PorConsulta' => $this->basico->radio_checked($data['cadastrar']['PorConsulta'], 'PorConsulta', 'NS'),
        );
        ($data['cadastrar']['PorConsulta'] == 'N') ?
            $data['div']['PorConsulta'] = '' : $data['div']['PorConsulta'] = 'style="display: none;"';
					
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		
		$data['q3'] = $this->Clientepet_model->list_racapet(TRUE);
		$data['list3'] = $this->load->view('clientepet/list_racapet', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		if ($data['cadastrar']['Extra'] == 'S') {
			$this->form_validation->set_rules('Repeticao', 'Repeticao', 'required|trim');
		}
		if ($data['cadastrar']['Repetir'] == 'S') {
			$this->form_validation->set_rules('Intervalo', 'Intervalo', 'required|trim|valid_intervalo');
			$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo');
			//$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo|valid_periodo_intervalo[' . $data['query']['Intervalo'] . ']');
			$this->form_validation->set_rules('Tempo', 'Tempo', 'required|trim');
			$this->form_validation->set_rules('Tempo', 'Tempo2', 'required|trim');
			$this->form_validation->set_rules('DataMinima', 'Data Mínima:', 'trim|valid_date');
			$this->form_validation->set_rules('DataTermino', 'Termina em:', 'required|trim|valid_date|valid_data_termino[' . $data['cadastrar']['DataMinima'] . ']|valid_data_termino2[' . $data['query']['Data'] . ']');
		}else{
			if($data['query']['Recorrencias'] > 1){
				$this->form_validation->set_rules('Repetir', 'Repetir', 'valid_repetir');
			}
		}
		if(($data['query']['OS'] > 1 && $data['cadastrar']['Adicionar'] == "S" 
			&& $data['cadastrar']['PorConsulta'] == "N" && $data['cadastrar']['NovaOS'] == "N" 
			&& $data['cadastrar']['Vincular'] == "S") 
			|| ($data['query']['OS'] == 1 && $data['cadastrar']['Adicionar'] == "S" 
			&& $data['cadastrar']['PorConsulta'] == "N" && $data['cadastrar']['Vincular'] == "S" )){
			$this->form_validation->set_rules('idApp_OrcaTrata', 'O.S.', 'required|trim');
		}		
        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data do Fim', 'required|trim|valid_date');

        $this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');

		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_consulta', $data);
        
		} else {

			$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
			$data1 = $data1->format('Y-m-d');       
			
			$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
			$data2 = $data2->format('Y-m-d');    

			$this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_periodo_data[' . $data['query']['Data'] . ']');			
			$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
			
			if(strtotime($data2) == strtotime($data1)){
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
			}else{
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
			}			
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('consulta/form_consulta', $data);

			} else {		
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
					
				} else {
				
					$dataini_cad 	= $this->basico->mascara_data($data['query']['Data'], 'mysql');
					$datafim_cad 	= $this->basico->mascara_data($data['query']['Data2'], 'mysql');
					$horaini_cad 	= $data['query']['HoraInicio'];
					$horafim_cad 	= $data['query']['HoraFim'];
					
					if ($data['cadastrar']['Repetir'] == 'N') {
						$data['query']['Intervalo'] = 0;
						$data['query']['Periodo'] = 0;
						$data['query']['Tempo'] = 0;
						$data['query']['Tempo2'] = 0;
						$data['query']['DataTermino'] = $dataini_cad;
					}else{
						
						$tipointervalo = $data['query']['Tempo'];
						if($tipointervalo == 1){
							$semana = 1;
							$ref = "day";
						}elseif($tipointervalo == 2){
							$semana = 7;
							$ref = "day";
						}elseif($tipointervalo == 3){
							$semana = 1;
							$ref = "month";
						}elseif($tipointervalo == 4){
							$semana = 1;
							$ref = "Year";
						}

						$n = $data['query']['Intervalo']; //intervalo - a cada tantos dias
						$qtd = $data['query']['Recorrencias'];
						$data['query']['DataTermino'] = $this->basico->mascara_data($data['query']['DataTermino'], 'mysql');				
						
					}
					if($_SESSION['Empresa']['CadastrarDep'] == "N"){
						$data['query']['idApp_ClienteDep'] = 0;
					}else{
						if($data['query']['idApp_ClienteDep'] == ''){
							$data['query']['idApp_ClienteDep'] = 0;
						}
					}
					if($_SESSION['Empresa']['CadastrarPet'] == "N"){
						$data['query']['idApp_ClientePet'] = 0;
						}else{
						if($data['query']['idApp_ClientePet'] == ''){
							$data['query']['idApp_ClientePet'] = 0;
						}
					}
					$data['query']['Tipo'] = 2;
					$data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
					#$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
					$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
					//$data['query']['idTab_Status'] = 1;
					$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

					if($data['cadastrar']['Extra'] == 'S'){
						
						$data['consulta'] = $this->Consulta_model->get_consulta($data['query']['Repeticao']);
						$data['update']['cons_anters'] = $this->Consulta_model->get_consultas($data['query']['Repeticao']);
						$cont_cons_anters = count($data['update']['cons_anters']);
						
						if($data['cadastrar']['Hidden_Caso'] == 0){
							
							$data['query']['Repeticao'] = 0;				
							
							if($data['cadastrar']['Adicionar'] == "S"){
								if($data['cadastrar']['PorConsulta'] == "S"){
									//Cadastro O número de Recorrências de OS  novas
									$data['query']['OS'] = $data['query']['Recorrencias'];
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['query']['Recorrencias'] > 1){
										//Abro a Opção de escolher Cadastrar  1 OS Nova, ou Selecionar 1 OS
										if($data['cadastrar']['NovaOS'] == "S"){
											//Cadastro 1 OS  nova
											$data['query']['OS'] = "1";
											$data['query']['idApp_OrcaTrata'] = "0";
										}else{
											if($data['cadastrar']['Vincular'] == "S"){
												//Seleciona 1 OS
												$data['query']['OS'] = "1";
											}else{
												//Não cadastro nenhuma OS
												$data['query']['OS'] = "0";
												$data['query']['idApp_OrcaTrata'] = "0";
											}
										}
									}else{
										//Escolher 1 OS
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}
							}else{
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 1){
							
							//N-1 ou N-N, Cadastro 1 ou N os novas
							
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['query']['OS'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//cadastro 1 OS nova
											$data['query']['OS'] = "1";
											$data['query']['idApp_OrcaTrata'] = "0";
										}else{
											if($data['cadastrar']['Vincular'] == "S"){
												//Seleciona 1 OS
												$data['query']['OS'] = "1";
											}else{
												//Não cadastro nenhuma OS
												$data['query']['OS'] = "0";
												$data['query']['idApp_OrcaTrata'] = "0";
											}
										}
									}else{
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
													
						}elseif($data['cadastrar']['Hidden_Caso'] == 2){
							
							//N-1 ou N-N, Uso a OS existente, ou Cadastro o Numero de Recorrencias de OS novas
							
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['OS'] = $data['query']['Recorrencias'];
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									//Pego a OS existente e uso para todas os agendamentos
									$data['query']['OS'] = 1;
									$data['query']['idApp_OrcaTrata'] = $data['consulta']['idApp_OrcaTrata'];
								}
							}else{
								//Não cadastro nenhuma OS
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 3){
							
							//N-1 ou N-N, Cadastro 1 ou N os novas
							
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['query']['OS'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//cadastro 1 OS nova
											$data['query']['OS'] = "1";
											$data['query']['idApp_OrcaTrata'] = "0";
										}else{
											if($data['cadastrar']['Vincular'] == "S"){
												//Seleciona 1 OS
												$data['query']['OS'] = "1";
											}else{
												//Não cadastro nenhuma OS
												$data['query']['OS'] = "0";
												$data['query']['idApp_OrcaTrata'] = "0";
											}
										}
									}else{
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 4){
							if($data['cadastrar']['Adicionar'] == "S"){
								//N-1, Pego a OS existente e uso para todas os agendamentos
								$data['query']['OS'] = 1;
								$data['query']['idApp_OrcaTrata'] = $data['consulta']['idApp_OrcaTrata'];
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
						}elseif($data['cadastrar']['Hidden_Caso'] == 5){
							if($data['cadastrar']['Adicionar'] == "S"){		
								//N-N, Cadastro o número de OS novas
								$data['query']['OS'] = $data['query']['Recorrencias'];
								$data['query']['idApp_OrcaTrata'] = "0";
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}						
						}else{

						}
										
					}else{
						$data['query']['Repeticao'] = 0;				
						
						if($data['cadastrar']['Adicionar'] == "S"){
							if($data['cadastrar']['PorConsulta'] == "S"){
								//Cadastro O número de Recorrências de OS  novas
								$data['query']['OS'] = $data['query']['Recorrencias'];
								$data['query']['idApp_OrcaTrata'] = "0";
							}else{
								if($data['query']['Recorrencias'] > 1){
									//Abro a Opção de escolher Cadastrar  1 OS Nova, ou Selecionar 1 OS
									if($data['cadastrar']['NovaOS'] == "S"){
										//Cadastro 1 OS  nova
										$data['query']['OS'] = "1";
										$data['query']['idApp_OrcaTrata'] = "0";
									}else{
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
											//$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}else{
									//Escolher 1 OS
									if($data['cadastrar']['Vincular'] == "S"){
										//Seleciona 1 OS
										$data['query']['OS'] = "1";
										//$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
									}else{
										//Não cadastro nenhuma OS
										$data['query']['OS'] = "0";
										$data['query']['idApp_OrcaTrata'] = "0";
									}
								}
							}
						}else{
							$data['query']['OS'] = "0";
							$data['query']['idApp_OrcaTrata'] = "0";
						}
					}
						
					$data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
					
					$dataini_whats 	= $data['query']['Data'];
					$horaini_whats	= $data['query']['HoraInicio'];	

					#unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
					unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
					
					$data['campos'] = array_keys($data['query']);
					$data['anterior'] = array();

					$data['query']['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

					unset($_SESSION['Agenda']);

					if ($data['query']['idApp_Consulta'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('consulta/form_consulta', $data);
					} else {
						
						#### Whatsapp ####
						if($data['cadastrar']['Whatsapp'] == 'S'){
							$data['Profissional'] 	= $this->Cliente_model->get_profissional($data['query']['idApp_Agenda'], TRUE);
							
							$_SESSION['bd_consulta']['Whatsapp'] 		= $data['cadastrar']['Whatsapp'];
							$_SESSION['bd_consulta']['NomeCliente'] 	= utf8_encode($_SESSION['Cliente']['NomeCliente']);
							$_SESSION['bd_consulta']['CelularCliente'] 	= $_SESSION['Cliente']['CelularCliente'];
							$_SESSION['bd_consulta']['Profissional'] 	= utf8_encode($data['Profissional']['Nome']);
							$_SESSION['bd_consulta']['DataInicio'] 		= $dataini_whats;
							$_SESSION['bd_consulta']['HoraInicio'] 		= $horaini_whats;
							
							unset($data['Profissional'], $dataini_whats, $horaini_whats);
						}

						if($data['cadastrar']['Extra'] == 'S'){
							if(isset($data['consulta'])){
								$data['copiar']['idApp_ClientePet'] = $data['consulta']['idApp_ClientePet'];
								$data['copiar']['idApp_ClienteDep'] = $data['consulta']['idApp_ClienteDep'];
							}else{
								$data['copiar']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
								$data['copiar']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
							}
							$data['copiar']['Repeticao'] 		= $data['query']['Repeticao'];
							$_SESSION['Copiar']['Repeticao'] 	= $data['query']['Repeticao'];
							$qtd_OS = $data['query']['OS'];
						}else{
							$data['copiar']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
							$data['copiar']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
							$data['copiar']['Repeticao'] 		= $data['query']['idApp_Consulta'];
							$_SESSION['Copiar']['Repeticao'] 	= $data['query']['idApp_Consulta'];
							$qtd_OS = $data['query']['Recorrencias'];
						}
						
						$pegouOS = false;
						if($data['cadastrar']['Adicionar'] == "S"){
							if($data['cadastrar']['PorConsulta'] == "N"){
								if($qtd_OS > 1){
									if($data['cadastrar']['NovaOS'] == "N"){
										if($data['cadastrar']['Vincular'] == "S"){
											if(isset($data['query']['idApp_OrcaTrata']) && $data['query']['idApp_OrcaTrata'] !=0){
												$pegouOS = true;
											}
										}
									}
								}else{
									if($data['cadastrar']['Vincular'] == "S"){
										if(isset($data['query']['idApp_OrcaTrata']) && $data['query']['idApp_OrcaTrata'] !=0){
											$pegouOS = true;
										}
									}
								}
							}							
						}
						
						if($pegouOS == true){	
							
							//Passo o valor da repetição para a OS selecionada

							$data['orcatrata']['RepeticaoCons'] = $data['copiar']['Repeticao'];
							$data['orcatrata']['idApp_ClientePet'] = $data['copiar']['idApp_ClientePet'];
							$data['orcatrata']['idApp_ClienteDep'] = $data['copiar']['idApp_ClienteDep'];
							
							$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['query']['idApp_OrcaTrata']);
							
							// update nos agendamento de OS = 0 
							if(isset($cont_cons_anters)){
								
								for($j=0;$j<$cont_cons_anters;$j++) {
								
									$data['update']['cons_anters'][$j]['OS'] = $data['query']['OS'];
									$data['update']['cons_anters'][$j]['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
									
									$data['update']['cons_anters']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_anters'][$j], $data['update']['cons_anters'][$j]['idApp_Consulta']);
								}
							}
						}					

						if($data['cadastrar']['Repetir'] == 'S'){
							$data['copiar']['DataTermino'] = $data['query']['DataTermino'];
							$data['copiar']['Recorrencia'] = "1/" . $qtd;
						}else{
							if($data['cadastrar']['Extra'] == 'S'){
								$data['copiar']['Recorrencia'] = "Ext";
							}else{
								$data['copiar']['Recorrencia'] = "1/1";
								//$data['copiar']['DataTermino'] = $dataini_cad;
							}
						}
						
						$data['update']['copiar']['bd'] = $this->Consulta_model->update_consulta($data['copiar'], $data['query']['idApp_Consulta']);
						
						if ($data['update']['copiar']['bd'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('consulta/form_consulta', $data);
						} else {
							if ($data['cadastrar']['Repetir'] == 'S') {
								for($j=1; $j<$qtd; $j++) {
									$data['repeticao'][$j] = array(
										'Repeticao' 			=> $data['copiar']['Repeticao'],
										'Intervalo' 			=> $data['query']['Intervalo'],
										'Periodo' 				=> $data['query']['Periodo'],
										'Tempo' 				=> $data['query']['Tempo'],
										'Tempo2' 				=> $data['query']['Tempo2'],
										'DataTermino' 			=> $data['query']['DataTermino'],
										'Recorrencias' 			=> $data['query']['Recorrencias'],
										'Recorrencia' 			=> ($j + 1) .  '/' . $data['query']['Recorrencias'],
										'OS' 					=> $data['query']['OS'],
										'idApp_Agenda' 			=> $data['query']['idApp_Agenda'],
										'idApp_Cliente' 		=> $data['query']['idApp_Cliente'],
										'idApp_ClienteDep' 		=> $data['query']['idApp_ClienteDep'],
										'idApp_ClientePet' 		=> $data['query']['idApp_ClientePet'],
										'idApp_OrcaTrata' 		=> $data['query']['idApp_OrcaTrata'],
										//'Evento' 				=> $data['query']['Evento'],
										'Obs' 					=> $data['query']['Obs'],
										'idTab_Status' 			=> $data['query']['idTab_Status'],
										'Tipo' 					=> $data['query']['Tipo'],
										'idTab_TipoConsulta' 	=> $data['query']['idTab_TipoConsulta'],
										'Paciente' 				=> $data['query']['Paciente'],
										'DataInicio' 			=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) .  $ref,strtotime($dataini_cad))) . ' ' . $horaini_cad,
										'DataFim' 				=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) . $ref,strtotime($datafim_cad))) . ' ' . $horafim_cad,
										'idSis_Usuario' 		=> $_SESSION['log']['idSis_Usuario'],
										'idSis_Empresa' 		=> $_SESSION['log']['idSis_Empresa'],
										'idTab_Modulo' 			=> $_SESSION['log']['idTab_Modulo']

									);
									$data['campos'] = array_keys($data['repeticao'][$j]);
									$data['id_Repeticao'] = $this->Consulta_model->set_consulta($data['repeticao'][$j]);
								}
						
							}
						}
						
						if($data['cadastrar']['Extra'] == 'S'){	
						
							$data['cons_datatermino'] = $this->Consulta_model->get_consulta_datatermino($data['query']['Repeticao']);
							$data['data_termino'] = $data['cons_datatermino']['DataInicio'];
							
							$data['update']['cons_posts'] = $this->Consulta_model->get_consultas($data['query']['Repeticao']);
							$cont_cons_posts = count($data['update']['cons_posts']);
							
							if(isset($cont_cons_posts)){
								
								for($j=0;$j<$cont_cons_posts;$j++) {
									$k = (1 + $j);
									$data['update']['cons_posts'][$j]['DataTermino'] = $data['data_termino'];
									$data['update']['cons_posts'][$j]['Recorrencias'] = $cont_cons_posts;
									$data['update']['cons_posts'][$j]['Recorrencia'] = $k . "/" . $cont_cons_posts;
									$data['update']['cons_posts']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_posts'][$j], $data['update']['cons_posts'][$j]['idApp_Consulta']);
								}
							}
						}
											
						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';

						if($data['cadastrar']['Extra'] == 'S'){
							
							if($data['cadastrar']['Hidden_Caso'] == 0){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										if($data['query']['Recorrencias'] > 1){
											if($data['cadastrar']['NovaOS'] == "S"){
												//Gera uma única O.S.
												redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
												exit();
											}else{
												//Não Gera O.S. 
												redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
												exit();
											}
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}

							}elseif($data['cadastrar']['Hidden_Caso'] == 1){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										if($data['query']['OS'] > 1){
											if($data['cadastrar']['NovaOS'] == "S"){
												//Gera uma única O.S.
												redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
												exit();
											}else{
												//Não Gera O.S. 
												redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
												exit();
											}
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}
								
							}elseif($data['cadastrar']['Hidden_Caso'] == 2){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										//Não Gera O.S. 
										redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
										exit();
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}
								
							}elseif($data['cadastrar']['Hidden_Caso'] == 3){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										if($data['query']['OS'] > 1){
											if($data['cadastrar']['NovaOS'] == "S"){
												//Gera uma única O.S.
												redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
												exit();
											}else{
												//Não Gera O.S. 
												redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
												exit();
											}
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}
								
							}elseif($data['cadastrar']['Hidden_Caso'] == 4){
								if($data['cadastrar']['Adicionar'] == "S"){	
									//Pega a O.S. da repetição
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}							
							}elseif($data['cadastrar']['Hidden_Caso'] == 5){
								if($data['cadastrar']['Adicionar'] == "S"){	
									//Gera O.S. Replicadas pelo número de Recorrências
									redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
									exit();
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}							
							}else{

							}							
						}else{
							if($data['cadastrar']['Adicionar'] == "S"){	
								if($data['cadastrar']['PorConsulta'] == "S"){
									//Gera O.S. Replicadas pelo número de ocorrências
									redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
									exit();
								}else{
									if($data['query']['Recorrencias'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//Gera uma única O.S.
											redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
											exit();
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}else{
										//Não Gera O.S. 
										redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
										exit();
									}
								}
							}else{
								//Não Gera O.S. 
								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
								exit();
							}						
						}
					}
				}
			}
		}

        $this->load->view('basico/footer');
    }

    public function cadastrar_extra($idApp_Cliente = NULL, $repeticao_extra = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar o novo Agendamento.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Whatsapp',
			'Repetir',
			'Extra',
			'Adicionar',
			'Prazo',
			'DataMinima',
			'RelacaoDep',
			'PeloPet',
			'PortePet',
			'EspeciePet',
			'RacaPet',
			'Vincular',
			'NovaOS',
			'PorConsulta',
			'id_Cliente_Auto',
			'id_ClientePet_Auto',
			'NomeClientePetAuto',
			'id_ClienteDep_Auto',
			'NomeClienteDepAuto',
			'Hidden_status',
			'Hidden_Caso',
        ), TRUE));

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			//'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
            'idApp_ClientePet',
            'idApp_ClienteDep',
			'idApp_OrcaTrata',
            //'Repeticao',
            'Data2',
			'Data',
            'HoraInicio',
            'HoraFim',
            'Paciente',
			'idTab_Status',
            'idTab_TipoConsulta',
            'Procedimento',
            'Obs',
			'Intervalo',
			'Periodo',
			'Tempo',
			'Tempo2',
			'DataTermino',
			'Recorrencias',
			'Recorrencia',
			'OS',
		), TRUE));
		
 		(!$data['cadastrar']['Hidden_Caso']) ? $data['cadastrar']['Hidden_Caso'] = 0 : FALSE;
 		(!$data['cadastrar']['Whatsapp']) ? $data['cadastrar']['Whatsapp'] = 'S' : FALSE;
 		(!$data['cadastrar']['Repetir']) ? $data['cadastrar']['Repetir'] = 'N' : FALSE;
 		(!$data['cadastrar']['Extra']) ? $data['cadastrar']['Extra'] = 'S' : FALSE;
 		(!$data['cadastrar']['Adicionar']) ? $data['cadastrar']['Adicionar'] = 'N' : FALSE;
 		(!$data['cadastrar']['Vincular']) ? $data['cadastrar']['Vincular'] = 'S' : FALSE;
 		(!$data['cadastrar']['NovaOS']) ? $data['cadastrar']['NovaOS'] = 'S' : FALSE;
 		(!$data['cadastrar']['PorConsulta']) ? $data['cadastrar']['PorConsulta'] = 'S' : FALSE;
		//(!$data['query']['Intervalo']) ? $data['query']['Intervalo'] = '1' : FALSE;
		//(!$data['query']['Periodo']) ? $data['query']['Periodo'] = '1' : FALSE;
		(!$data['query']['Recorrencias']) ? $data['query']['Recorrencias'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo2'] = '1' : FALSE;		
		
		if($_SESSION['log']['idSis_Empresa'] != 5){
			(!$data['query']['idApp_Agenda']) ? $data['query']['idApp_Agenda'] = $_SESSION['log']['Agenda'] : FALSE;
		}

		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
			$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($idApp_Cliente);
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
		}		
		
        if ($repeticao_extra) {
            $_SESSION['Consulta'] = $this->Consulta_model->get_repeticao($repeticao_extra); //pego os dados dessa repetição
			$_SESSION['Consulta']['DataTermino'] = $this->basico->mascara_data($_SESSION['Consulta']['DataTermino'], 'barras');
			
			$_SESSION['Repeticao_Cons'] = $this->Consulta_model->get_repeticao_cos($_SESSION['Consulta']['Repeticao']);			
					
		}
		
		$data['query']['Repeticao'] = $_SESSION['Consulta']['Repeticao'];
		
		/////////////// pego as informçãoes das OS para colocar no visor das consultas///////////////////////
		
		if (isset($_SESSION['Repeticao_Cons']) && count($_SESSION['Repeticao_Cons']) > 0) {
			$data['repeticao_cons'] = $_SESSION['Repeticao_Cons'];
			$data['repeticao_cons'] = array_combine(range(1, count($data['repeticao_cons'])), array_values($data['repeticao_cons']));
			$data['count']['POCount'] = count($data['repeticao_cons']);           
			
			if (isset($data['repeticao_cons'])) {

				for($i=1;$i<=$data['count']['POCount'];$i++) {

					//$data['repeticao_cons'][$i]['DataEntregaOrca'] = $this->basico->mascara_data($data['repeticao_cons'][$i]['DataEntregaOrca'], 'barras');
					
					#### App_ProdutoVenda ####
					$data['produto'][$i] = $this->Consulta_model->get_produto($data['repeticao_cons'][$i]['idApp_OrcaTrata']);
					if (count($data['produto'][$i]) > 0) {
						$data['produto'][$i] = array_combine(range(1, count($data['produto'][$i])), array_values($data['produto'][$i]));
						$data['count']['PCount'][$i] = count($data['produto'][$i]);

						if (isset($data['produto'][$i])) {

							for($k=1;$k<=$data['count']['PCount'][$i];$k++) {
								$data['produto'][$i][$k]['SubtotalProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto'] * $data['produto'][$i][$k]['QtdProduto']), 2, ',', '.');
								$data['produto'][$i][$k]['ValorProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto']), 2, ',', '.');
								$data['produto'][$i][$k]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$i][$k]['DataConcluidoProduto'], 'barras');
								$data['produto'][$i][$k]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['ConcluidoProduto'], 'NS');
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['produto'][$i][$k]);
								echo "</pre>";
								*/
							}
						}
					}
				}
			}
		}
		
		//////////////////////////////////////////////////////////////////
				
		//// Uso esse método para cadastrar agendamentos escolhendo clientes no pesquisa clientes////
        if (isset($_SESSION['agenda']) && !$data['query']['HoraInicio'] && !$data['query']['HoraFim']) {
            $data['query']['Data'] = date('d/m/Y', $_SESSION['agenda']['HoraInicio']);
            $data['query']['Data2'] = date('d/m/Y', $_SESSION['agenda']['HoraFim']);
			$data['query']['HoraInicio'] = date('H:i', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraFim'] = date('H:i', $_SESSION['agenda']['HoraFim']);
        }		
		
		/*
		//// Uso esse método para cadastrar agendamentos escolhendo clientes no formulário////
		if ($this->input->get('start') && $this->input->get('end')) {
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['Data2'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
			$data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }
		*/
        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

		
		$data['select']['EspeciePet'] = array (
            //'0' => '',
            '1' => 'CÃO',
            '2' => 'GATO',
			'3' => 'AVE',
        );		
		$data['select']['PeloPet'] = array (
            //'0' => '',
            '1' => 'CURTO',
            '2' => 'MÉDIO',
			'3' => 'LONGO',
			'4' => 'CACHEADO',
        );		
		$data['select']['PortePet'] = array (
            //'0' => '',
            '1' => 'MINI',
            '2' => 'PEQUENO',
			'3' => 'MÉDIO',
			'4' => 'GRANDE',
			'5' => 'GIGANTE',
        );
		$data['select']['RacaPet'] = $this->Cliente_model->select_racapet();
		$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Whatsapp'] = $this->Basico_model->select_status_sn();
		$data['select']['Repetir'] = $this->Basico_model->select_status_sn();
		$data['select']['Extra'] = $this->Basico_model->select_status_sn();
		$data['select']['Adicionar'] = $this->Basico_model->select_status_sn();
		$data['select']['Vincular'] = $this->Basico_model->select_status_sn();
		$data['select']['NovaOS'] = $this->Basico_model->select_status_sn();
		$data['select']['PorConsulta'] = $this->Basico_model->select_status_sn();         
		$data['select']['Tempo'] = array (
            '1' => 'Dia(s)',
            '2' => 'Semana(s)',
            '3' => 'Mês(s)',
			'4' => 'Ano(s)',
        );		
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		$data['select']['RelacaoDep'] = $this->Cliente_model->select_relacao();
        $data['select']['idApp_ClienteDep'] = $this->Cliente_model->select_clientedep($_SESSION['Cliente']['idApp_Cliente']);
        $data['select']['idApp_ClientePet'] = $this->Cliente_model->select_clientepet($_SESSION['Cliente']['idApp_Cliente']);
        $data['select']['idApp_OrcaTrata'] = $this->Cliente_model->select_orcatrata($_SESSION['Cliente']['idApp_Cliente']);

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['titulo'] = 'Agendamento';
        $data['form_open_path'] = 'consulta/cadastrar_extra';
        $data['panel'] = 'primary';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['metodo'] = 1;
        $data['alterarcliente'] = 2;
        $data['caminho2'] = '';
 		$data['vincular'] = 'S';
		$data['porconsulta'] = 'S';
		$data['extra'] = 'S';
		
		$data['exibir_id'] = 0;
		$data['count_repet'] = 0;

 		//(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
				
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Whatsapp' => $this->basico->radio_checked($data['cadastrar']['Whatsapp'], 'Whatsapp', 'NS'),
        );
        ($data['cadastrar']['Whatsapp'] == 'N') ?
            $data['div']['Whatsapp'] = '' : $data['div']['Whatsapp'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Repetir' => $this->basico->radio_checked($data['cadastrar']['Repetir'], 'Repetir', 'NS'),
        );
        ($data['cadastrar']['Repetir'] == 'S') ?
            $data['div']['Repetir'] = '' : $data['div']['Repetir'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Extra' => $this->basico->radio_checked($data['cadastrar']['Extra'], 'Extra', 'NS'),
        );
        ($data['cadastrar']['Extra'] == 'S') ?
            $data['div']['Extra'] = '' : $data['div']['Extra'] = 'style="display: none;"';
						
		$data['radio'] = array(
            'Adicionar' => $this->basico->radio_checked($data['cadastrar']['Adicionar'], 'Adicionar', 'NS'),
        );
        ($data['cadastrar']['Adicionar'] == 'S') ?
            $data['div']['Adicionar'] = '' : $data['div']['Adicionar'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'Vincular' => $this->basico->radio_checked($data['cadastrar']['Vincular'], 'Vincular', 'NS'),
        );
        ($data['cadastrar']['Vincular'] == 'N') ?
            $data['div']['Vincular'] = '' : $data['div']['Vincular'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'NovaOS' => $this->basico->radio_checked($data['cadastrar']['NovaOS'], 'NovaOS', 'NS'),
        );
        ($data['cadastrar']['NovaOS'] == 'N') ?
            $data['div']['NovaOS'] = '' : $data['div']['NovaOS'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'PorConsulta' => $this->basico->radio_checked($data['cadastrar']['PorConsulta'], 'PorConsulta', 'NS'),
        );
        ($data['cadastrar']['PorConsulta'] == 'N') ?
            $data['div']['PorConsulta'] = '' : $data['div']['PorConsulta'] = 'style="display: none;"';
					
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		
		$data['q3'] = $this->Clientepet_model->list_racapet(TRUE);
		$data['list3'] = $this->load->view('clientepet/list_racapet', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		if ($data['cadastrar']['Repetir'] == 'S') {
			$this->form_validation->set_rules('Intervalo', 'Intervalo', 'required|trim|valid_intervalo');
			$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo');
			//$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo|valid_periodo_intervalo[' . $data['query']['Intervalo'] . ']');
			$this->form_validation->set_rules('Tempo', 'Tempo', 'required|trim');
			$this->form_validation->set_rules('Tempo', 'Tempo2', 'required|trim');
			$this->form_validation->set_rules('DataMinima', 'Data Mínima:', 'trim|valid_date');
			$this->form_validation->set_rules('DataTermino', 'Termina em:', 'required|trim|valid_date|valid_data_termino[' . $data['cadastrar']['DataMinima'] . ']|valid_data_termino2[' . $data['query']['Data'] . ']');
		}else{
			if($data['query']['Recorrencias'] > 1){
				$this->form_validation->set_rules('Repetir', 'Repetir', 'valid_repetir');
			}
		}
		if(($data['query']['OS'] > 1 && $data['cadastrar']['Adicionar'] == "S" 
			&& $data['cadastrar']['PorConsulta'] == "N" && $data['cadastrar']['NovaOS'] == "N" 
			&& $data['cadastrar']['Vincular'] == "S") 
			|| ($data['query']['OS'] == 1 && $data['cadastrar']['Adicionar'] == "S" 
			&& $data['cadastrar']['PorConsulta'] == "N" && $data['cadastrar']['Vincular'] == "S" )){
			$this->form_validation->set_rules('idApp_OrcaTrata', 'O.S.', 'required|trim');
		}		
        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data do Fim', 'required|trim|valid_date');

        $this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');

		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_consulta', $data);
        
		} else {

			$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
			$data1 = $data1->format('Y-m-d');       
			
			$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
			$data2 = $data2->format('Y-m-d');    

			$this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_periodo_data[' . $data['query']['Data'] . ']');			
			$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
			
			if(strtotime($data2) == strtotime($data1)){
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
			}else{
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
			}			
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('consulta/form_consulta', $data);

			} else {		

				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'consulta/cadastrar_extra/' . $_SESSION['Cliente']['idApp_Cliente'] . '/' . $_SESSION['Consulta']['Repeticao'] . $data['msg']);
					
				} else {

					$dataini_cad 	= $this->basico->mascara_data($data['query']['Data'], 'mysql');
					$datafim_cad 	= $this->basico->mascara_data($data['query']['Data2'], 'mysql');
					$horaini_cad 	= $data['query']['HoraInicio'];
					$horafim_cad 	= $data['query']['HoraFim'];
					
					if ($data['cadastrar']['Repetir'] == 'N') {
						$data['query']['Intervalo'] = 0;
						$data['query']['Periodo'] = 0;
						$data['query']['Tempo'] = 0;
						$data['query']['Tempo2'] = 0;
						$data['query']['DataTermino'] = $dataini_cad;
					}else{
						
						$tipointervalo = $data['query']['Tempo'];
						if($tipointervalo == 1){
							$semana = 1;
							$ref = "day";
						}elseif($tipointervalo == 2){
							$semana = 7;
							$ref = "day";
						}elseif($tipointervalo == 3){
							$semana = 1;
							$ref = "month";
						}elseif($tipointervalo == 4){
							$semana = 1;
							$ref = "Year";
						}

						$n = $data['query']['Intervalo']; //intervalo - a cada tantos dias
						$qtd = $data['query']['Recorrencias'];
						$data['query']['DataTermino'] = $this->basico->mascara_data($data['query']['DataTermino'], 'mysql');				
						
					}
					if($_SESSION['Empresa']['CadastrarDep'] == "N"){
						$data['query']['idApp_ClienteDep'] = 0;
					}else{
						if($data['query']['idApp_ClienteDep'] == ''){
							$data['query']['idApp_ClienteDep'] = 0;
						}
					}
					if($_SESSION['Empresa']['CadastrarPet'] == "N"){
						$data['query']['idApp_ClientePet'] = 0;
						}else{
						if($data['query']['idApp_ClientePet'] == ''){
							$data['query']['idApp_ClientePet'] = 0;
						}
					}
					$data['query']['Tipo'] = 2;
					$data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
					#$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
					$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
					//$data['query']['idTab_Status'] = 1;
					$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

					if($data['cadastrar']['Extra'] == 'S'){
						
						$data['consulta'] = $this->Consulta_model->get_repeticao($data['query']['Repeticao']);
						$data['update']['cons_anters'] = $this->Consulta_model->get_consultas($data['query']['Repeticao']);
						$cont_cons_anters = count($data['update']['cons_anters']);
						
						if($data['cadastrar']['Hidden_Caso'] == 0){
							
							$data['query']['Repeticao'] = 0;				
							
							if($data['cadastrar']['Adicionar'] == "S"){
								if($data['cadastrar']['PorConsulta'] == "S"){
									//Cadastro O número de Recorrências de OS  novas
									$data['query']['OS'] = $data['query']['Recorrencias'];
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['query']['Recorrencias'] > 1){
										//Abro a Opção de escolher Cadastrar  1 OS Nova, ou Selecionar 1 OS
										if($data['cadastrar']['NovaOS'] == "S"){
											//Cadastro 1 OS  nova
											$data['query']['OS'] = "1";
											$data['query']['idApp_OrcaTrata'] = "0";
										}else{
											if($data['cadastrar']['Vincular'] == "S"){
												//Seleciona 1 OS
												$data['query']['OS'] = "1";
											}else{
												//Não cadastro nenhuma OS
												$data['query']['OS'] = "0";
												$data['query']['idApp_OrcaTrata'] = "0";
											}
										}
									}else{
										//Escolher 1 OS
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}
							}else{
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 1){
							
							//N-1 ou N-N, Cadastro 1 ou N os novas
							
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['cadastrar']['NovaOS'] == "S"){
										//cadastro 1 OS nova
										$data['query']['OS'] = "1";
										$data['query']['idApp_OrcaTrata'] = "0";
									}else{
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
													
						}elseif($data['cadastrar']['Hidden_Caso'] == 2){
							
							//N-1 ou N-N, Uso a OS existente, ou Cadastro o Numero de Recorrencias de OS novas
							
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['OS'] = $data['query']['Recorrencias'];
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									//Pego a OS existente e uso para todas os agendamentos
									$data['query']['OS'] = 1;
									$data['query']['idApp_OrcaTrata'] = $data['consulta']['idApp_OrcaTrata'];
								}
							}else{
								//Não cadastro nenhuma OS
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 3){
							
							//N-1 ou N-N, Cadastro 1 ou N os novas
							
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['cadastrar']['NovaOS'] == "S"){
										//cadastro 1 OS nova
										$data['query']['OS'] = "1";
										$data['query']['idApp_OrcaTrata'] = "0";
									}else{
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 4){
							if($data['cadastrar']['Adicionar'] == "S"){
								//N-1, Pego a OS existente e uso para todas os agendamentos
								$data['query']['OS'] = 1;
								$data['query']['idApp_OrcaTrata'] = $data['consulta']['idApp_OrcaTrata'];
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
						}elseif($data['cadastrar']['Hidden_Caso'] == 5){
							if($data['cadastrar']['Adicionar'] == "S"){		
								//N-N, Cadastro o número de OS novas
								$data['query']['OS'] = $data['query']['Recorrencias'];
								$data['query']['idApp_OrcaTrata'] = "0";
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}						
						}else{

						}
										
					}else{
						$data['query']['Repeticao'] = 0;				
						
						if($data['cadastrar']['Adicionar'] == "S"){
							if($data['cadastrar']['PorConsulta'] == "S"){
								//Cadastro O número de Recorrências de OS  novas
								$data['query']['OS'] = $data['query']['Recorrencias'];
								$data['query']['idApp_OrcaTrata'] = "0";
							}else{
								if($data['query']['Recorrencias'] > 1){
									//Abro a Opção de escolher Cadastrar  1 OS Nova, ou Selecionar 1 OS
									if($data['cadastrar']['NovaOS'] == "S"){
										//Cadastro 1 OS  nova
										$data['query']['OS'] = "1";
										$data['query']['idApp_OrcaTrata'] = "0";
									}else{
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
											//$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}else{
									//Escolher 1 OS
									if($data['cadastrar']['Vincular'] == "S"){
										//Seleciona 1 OS
										$data['query']['OS'] = "1";
										//$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
									}else{
										//Não cadastro nenhuma OS
										$data['query']['OS'] = "0";
										$data['query']['idApp_OrcaTrata'] = "0";
									}
								}
							}
						}else{
							$data['query']['OS'] = "0";
							$data['query']['idApp_OrcaTrata'] = "0";
						}
					}
						
					$data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
					
					$dataini_whats 	= $data['query']['Data'];
					$horaini_whats	= $data['query']['HoraInicio'];	

					#unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
					unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
					
					$data['campos'] = array_keys($data['query']);
					$data['anterior'] = array();

					$data['query']['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

					unset($_SESSION['Agenda']);

					if ($data['query']['idApp_Consulta'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('consulta/form_consulta', $data);
					} else {
						
						#### Whatsapp ####
						if($data['cadastrar']['Whatsapp'] == 'S'){
							$data['Profissional'] 	= $this->Cliente_model->get_profissional($data['query']['idApp_Agenda'], TRUE);
							
							$_SESSION['bd_consulta']['Whatsapp'] 		= $data['cadastrar']['Whatsapp'];
							$_SESSION['bd_consulta']['NomeCliente'] 	= utf8_encode($_SESSION['Cliente']['NomeCliente']);
							$_SESSION['bd_consulta']['CelularCliente'] 	= $_SESSION['Cliente']['CelularCliente'];
							$_SESSION['bd_consulta']['Profissional'] 	= utf8_encode($data['Profissional']['Nome']);
							$_SESSION['bd_consulta']['DataInicio'] 		= $dataini_whats;
							$_SESSION['bd_consulta']['HoraInicio'] 		= $horaini_whats;
							
							unset($data['Profissional'], $dataini_whats, $horaini_whats);
						}

						if($data['cadastrar']['Extra'] == 'S'){
							if(isset($data['consulta'])){
								$data['copiar']['idApp_ClientePet'] = $data['consulta']['idApp_ClientePet'];
								$data['copiar']['idApp_ClienteDep'] = $data['consulta']['idApp_ClienteDep'];
							}else{
								$data['copiar']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
								$data['copiar']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
							}
							$data['copiar']['Repeticao'] 		= $data['query']['Repeticao'];
							$_SESSION['Copiar']['Repeticao'] 	= $data['query']['Repeticao'];
							$qtd_OS = $data['query']['OS'];
						}else{
							$data['copiar']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
							$data['copiar']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
							$data['copiar']['Repeticao'] 		= $data['query']['idApp_Consulta'];
							$_SESSION['Copiar']['Repeticao'] 	= $data['query']['idApp_Consulta'];
							$qtd_OS = $data['query']['Recorrencias'];
						}
						
						$pegouOS = false;
						if($data['cadastrar']['Adicionar'] == "S"){
							if($data['cadastrar']['PorConsulta'] == "N"){
								if($qtd_OS > 1){
									if($data['cadastrar']['NovaOS'] == "N"){
										if($data['cadastrar']['Vincular'] == "S"){
											if(isset($data['query']['idApp_OrcaTrata']) && $data['query']['idApp_OrcaTrata'] !=0){
												$pegouOS = true;
											}
										}
									}
								}else{
									if($data['cadastrar']['Vincular'] == "S"){
										if(isset($data['query']['idApp_OrcaTrata']) && $data['query']['idApp_OrcaTrata'] !=0){
											$pegouOS = true;
										}
									}
								}
							}							
						}
						
						if($pegouOS == true){	
							
							//Passo o valor da repetição para a OS selecionada

							$data['orcatrata']['RepeticaoCons'] = $data['copiar']['Repeticao'];
							$data['orcatrata']['idApp_ClientePet'] = $data['copiar']['idApp_ClientePet'];
							$data['orcatrata']['idApp_ClienteDep'] = $data['copiar']['idApp_ClienteDep'];
							
							$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['query']['idApp_OrcaTrata']);
							
							// update nos agendamento de OS = 0 
							if(isset($cont_cons_anters)){
								
								for($j=0;$j<$cont_cons_anters;$j++) {
								
									$data['update']['cons_anters'][$j]['OS'] = $data['query']['OS'];
									$data['update']['cons_anters'][$j]['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
									
									$data['update']['cons_anters']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_anters'][$j], $data['update']['cons_anters'][$j]['idApp_Consulta']);
								}
							}
						}					

						if($data['cadastrar']['Repetir'] == 'S'){
							$data['copiar']['DataTermino'] = $data['query']['DataTermino'];
							$data['copiar']['Recorrencia'] = "1/" . $qtd;
						}else{
							if($data['cadastrar']['Extra'] == 'S'){
								$data['copiar']['Recorrencia'] = "Ext";
							}else{
								$data['copiar']['Recorrencia'] = "1/1";
								//$data['copiar']['DataTermino'] = $dataini_cad;
							}
						}
						
						$data['update']['copiar']['bd'] = $this->Consulta_model->update_consulta($data['copiar'], $data['query']['idApp_Consulta']);
						
						if ($data['update']['copiar']['bd'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('consulta/form_consulta', $data);
						} else {
							if ($data['cadastrar']['Repetir'] == 'S') {
								for($j=1; $j<$qtd; $j++) {
									$data['repeticao'][$j] = array(
										'Repeticao' 			=> $data['copiar']['Repeticao'],
										'Intervalo' 			=> $data['query']['Intervalo'],
										'Periodo' 				=> $data['query']['Periodo'],
										'Tempo' 				=> $data['query']['Tempo'],
										'Tempo2' 				=> $data['query']['Tempo2'],
										'DataTermino' 			=> $data['query']['DataTermino'],
										'Recorrencias' 			=> $data['query']['Recorrencias'],
										'Recorrencia' 			=> ($j + 1) .  '/' . $data['query']['Recorrencias'],
										'OS' 					=> $data['query']['OS'],
										'idApp_Agenda' 			=> $data['query']['idApp_Agenda'],
										'idApp_Cliente' 		=> $data['query']['idApp_Cliente'],
										'idApp_ClienteDep' 		=> $data['query']['idApp_ClienteDep'],
										'idApp_ClientePet' 		=> $data['query']['idApp_ClientePet'],
										'idApp_OrcaTrata' 		=> $data['query']['idApp_OrcaTrata'],
										//'Evento' 				=> $data['query']['Evento'],
										'Obs' 					=> $data['query']['Obs'],
										'idTab_Status' 			=> $data['query']['idTab_Status'],
										'Tipo' 					=> $data['query']['Tipo'],
										'idTab_TipoConsulta' 	=> $data['query']['idTab_TipoConsulta'],
										'Paciente' 				=> $data['query']['Paciente'],
										'DataInicio' 			=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) .  $ref,strtotime($dataini_cad))) . ' ' . $horaini_cad,
										'DataFim' 				=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) . $ref,strtotime($datafim_cad))) . ' ' . $horafim_cad,
										'idSis_Usuario' 		=> $_SESSION['log']['idSis_Usuario'],
										'idSis_Empresa' 		=> $_SESSION['log']['idSis_Empresa'],
										'idTab_Modulo' 			=> $_SESSION['log']['idTab_Modulo']

									);
									$data['campos'] = array_keys($data['repeticao'][$j]);
									$data['id_Repeticao'] = $this->Consulta_model->set_consulta($data['repeticao'][$j]);
								}
						
							}
						}
						
						if($data['cadastrar']['Extra'] == 'S'){
													
							$data['cons_datatermino'] = $this->Consulta_model->get_consulta_datatermino($data['query']['Repeticao']);
							$data['data_termino'] = $data['cons_datatermino']['DataInicio'];
							
							$data['update']['cons_posts'] = $this->Consulta_model->get_consultas($data['query']['Repeticao']);
							$cont_cons_posts = count($data['update']['cons_posts']);
							
							if(isset($cont_cons_posts)){
								for($j=0;$j<$cont_cons_posts;$j++) {
									$k = (1 + $j);
									$data['update']['cons_posts'][$j]['DataTermino'] = $data['data_termino'];
									$data['update']['cons_posts'][$j]['Recorrencias'] = $cont_cons_posts;
									$data['update']['cons_posts'][$j]['Recorrencia'] = $k . "/" . $cont_cons_posts;
									$data['update']['cons_posts']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_posts'][$j], $data['update']['cons_posts'][$j]['idApp_Consulta']);
								}
							}
						}
											
						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';

						if($data['cadastrar']['Extra'] == 'S'){
							
							if($data['cadastrar']['Hidden_Caso'] == 0){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										if($data['query']['Recorrencias'] > 1){
											if($data['cadastrar']['NovaOS'] == "S"){
												//Gera uma única O.S.
												redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
												exit();
											}else{
												//Não Gera O.S. 
												redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
												exit();
											}
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}

							}elseif($data['cadastrar']['Hidden_Caso'] == 1){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										if($data['cadastrar']['NovaOS'] == "S"){
											//Gera uma única O.S.
											redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
											exit();
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}
								
							}elseif($data['cadastrar']['Hidden_Caso'] == 2){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										//Não Gera O.S. 
										redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
										exit();
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}
								
							}elseif($data['cadastrar']['Hidden_Caso'] == 3){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										if($data['cadastrar']['NovaOS'] == "S"){
											//Gera uma única O.S.
											redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
											exit();
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}
								
							}elseif($data['cadastrar']['Hidden_Caso'] == 4){
								if($data['cadastrar']['Adicionar'] == "S"){	
									//Pega a O.S. da repetição
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}							
							}elseif($data['cadastrar']['Hidden_Caso'] == 5){
								if($data['cadastrar']['Adicionar'] == "S"){	
									//Gera O.S. Replicadas pelo número de Recorrências
									redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
									exit();
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}							
							}else{

							}							
						}else{
							if($data['cadastrar']['Adicionar'] == "S"){	
								if($data['cadastrar']['PorConsulta'] == "S"){
									//Gera O.S. Replicadas pelo número de ocorrências
									redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
									exit();
								}else{
									if($data['query']['Recorrencias'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//Gera uma única O.S.
											redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
											exit();
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}else{
										//Não Gera O.S. 
										redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
										exit();
									}
								}
							}else{
								//Não Gera O.S. 
								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
								exit();
							}						
						}
					}
				}
			}
		}

        $this->load->view('basico/footer');
    }

    public function cadastrar2($idApp_Cliente = NULL, $idApp_ContatoCliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar o novo Agendamento.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Whatsapp',
			'Repetir',
			'Extra',
			'Adicionar',
			'Vincular',
			'NovaOS',
			'PorConsulta',
			'Prazo',
			'DataMinima',
			'RelacaoDep',
			'PeloPet',
			'PortePet',
			'EspeciePet',
			'RacaPet',
			'id_Cliente_Auto',
			'NomeClienteAuto',
			'id_ClientePet_Auto',
			'NomeClientePetAuto',
			'id_ClienteDep_Auto',
			'NomeClienteDepAuto',
			'Hidden_status',
			'Hidden_Caso',
        ), TRUE));

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			//'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
            'idApp_ClientePet',
            'idApp_ClienteDep',
            'idApp_OrcaTrata',
            'Repeticao',
            'Data2',
			'Data',
            'HoraInicio',
            'HoraFim',
            'Paciente',
			'idTab_Status',
            'idTab_TipoConsulta',
            'Procedimento',
            'Obs',
			'Intervalo',
			'Periodo',
			'Tempo',
			'Tempo2',
			'DataTermino',
			'Recorrencias',
			'Recorrencia',
			'OS',
		), TRUE));
		
 		(!$data['cadastrar']['Hidden_Caso']) ? $data['cadastrar']['Hidden_Caso'] = 0 : FALSE;
 		(!$data['cadastrar']['Whatsapp']) ? $data['cadastrar']['Whatsapp'] = 'S' : FALSE;
 		(!$data['cadastrar']['Repetir']) ? $data['cadastrar']['Repetir'] = 'N' : FALSE;
 		(!$data['cadastrar']['Extra']) ? $data['cadastrar']['Extra'] = 'N' : FALSE;
 		(!$data['cadastrar']['Adicionar']) ? $data['cadastrar']['Adicionar'] = 'N' : FALSE;
 		(!$data['cadastrar']['Vincular']) ? $data['cadastrar']['Vincular'] = 'S' : FALSE;
 		(!$data['cadastrar']['NovaOS']) ? $data['cadastrar']['NovaOS'] = 'S' : FALSE;
 		(!$data['cadastrar']['PorConsulta']) ? $data['cadastrar']['PorConsulta'] = 'S' : FALSE;
		(!$data['query']['Recorrencias']) ? $data['query']['Recorrencias'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo2'] = '1' : FALSE;
		(!$data['query']['OS']) ? $data['query']['OS'] = 0 : FALSE;		
		
		if($_SESSION['log']['idSis_Empresa'] != 5){
			(!$data['query']['idApp_Agenda']) ? $data['query']['idApp_Agenda'] = $_SESSION['log']['Agenda'] : FALSE;
		}

		/*
		//// Uso esse método para cadastrar agendamentos escolhendo clientes no pesquisa clientes////
        if (isset($_SESSION['agenda']) && !$data['query']['HoraInicio'] && !$data['query']['HoraFim']) {
            $data['query']['Data'] = date('d/m/Y', $_SESSION['agenda']['HoraInicio']);
            $data['query']['Data2'] = date('d/m/Y', $_SESSION['agenda']['HoraFim']);
			$data['query']['HoraInicio'] = date('H:i', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraFim'] = date('H:i', $_SESSION['agenda']['HoraFim']);
        }
		*/		
		
		//// Uso esse método para cadastrar agendamentos escolhendo clientes no formulário////
		if ($this->input->get('start') && $this->input->get('end')) {
            //$data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
            $data['query']['Data2'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
			$data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
		}

        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

		
		$data['select']['EspeciePet'] = array (
            //'0' => '',
            '1' => 'CÃO',
            '2' => 'GATO',
			'3' => 'AVE',
        );		
		$data['select']['PeloPet'] = array (
            //'0' => '',
            '1' => 'CURTO',
            '2' => 'MÉDIO',
			'3' => 'LONGO',
			'4' => 'CACHEADO',
        );		
		$data['select']['PortePet'] = array (
            //'0' => '',
            '1' => 'MINI',
            '2' => 'PEQUENO',
			'3' => 'MÉDIO',
			'4' => 'GRANDE',
			'5' => 'GIGANTE',
        );
		$data['select']['RacaPet'] = $this->Cliente_model->select_racapet();
		$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Whatsapp'] = $this->Basico_model->select_status_sn();
		$data['select']['Repetir'] = $this->Basico_model->select_status_sn();
		$data['select']['Extra'] = $this->Basico_model->select_status_sn();
		$data['select']['Adicionar'] = $this->Basico_model->select_status_sn();  
		$data['select']['Vincular'] = $this->Basico_model->select_status_sn();
		$data['select']['NovaOS'] = $this->Basico_model->select_status_sn();
		$data['select']['PorConsulta'] = $this->Basico_model->select_status_sn();        
		$data['select']['Tempo'] = array (
            '1' => 'Dia(s)',
            '2' => 'Semana(s)',
            '3' => 'Mês(s)',
			'4' => 'Ano(s)',
        );		
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		$data['select']['RelacaoDep'] = $this->Cliente_model->select_relacao();

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['titulo'] = 'Agendamento';
        $data['form_open_path'] = 'consulta/cadastrar2';
        $data['panel'] = 'primary';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['metodo'] = 1;
        $data['alterarcliente'] = 1;
        $data['caminho2'] = '../';
 		$data['vincular'] = 'S';
		$data['porconsulta'] = 'S';
		
		$data['exibir_id'] = 1;
		$data['count_repet'] = 0;
		
		//(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
				
		$data['radio'] = array(
            'Whatsapp' => $this->basico->radio_checked($data['cadastrar']['Whatsapp'], 'Whatsapp', 'NS'),
        );
        ($data['cadastrar']['Whatsapp'] == 'N') ?
            $data['div']['Whatsapp'] = '' : $data['div']['Whatsapp'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Repetir' => $this->basico->radio_checked($data['cadastrar']['Repetir'], 'Repetir', 'NS'),
        );
        ($data['cadastrar']['Repetir'] == 'S') ?
            $data['div']['Repetir'] = '' : $data['div']['Repetir'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Extra' => $this->basico->radio_checked($data['cadastrar']['Extra'], 'Extra', 'NS'),
        );
        ($data['cadastrar']['Extra'] == 'S') ?
            $data['div']['Extra'] = '' : $data['div']['Extra'] = 'style="display: none;"';
				
		$data['radio'] = array(
            'Adicionar' => $this->basico->radio_checked($data['cadastrar']['Adicionar'], 'Adicionar', 'NS'),
        );
        ($data['cadastrar']['Adicionar'] == 'S') ?
            $data['div']['Adicionar'] = '' : $data['div']['Adicionar'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'Vincular' => $this->basico->radio_checked($data['cadastrar']['Vincular'], 'Vincular', 'NS'),
        );
        ($data['cadastrar']['Vincular'] == 'S') ?
            $data['div']['Vincular'] = '' : $data['div']['Vincular'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'NovaOS' => $this->basico->radio_checked($data['cadastrar']['NovaOS'], 'NovaOS', 'NS'),
        );
        ($data['cadastrar']['NovaOS'] == 'N') ?
            $data['div']['NovaOS'] = '' : $data['div']['NovaOS'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'PorConsulta' => $this->basico->radio_checked($data['cadastrar']['PorConsulta'], 'PorConsulta', 'NS'),
        );
        ($data['cadastrar']['PorConsulta'] == 'N') ?
            $data['div']['PorConsulta'] = '' : $data['div']['PorConsulta'] = 'style="display: none;"';
		
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		
		$data['q3'] = $this->Clientepet_model->list_racapet(TRUE);
		$data['list3'] = $this->load->view('clientepet/list_racapet', $data, TRUE);		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		if ($data['cadastrar']['Extra'] == 'S') {
			$this->form_validation->set_rules('Repeticao', 'Repeticao', 'required|trim');
		}
		if ($data['cadastrar']['Repetir'] == 'S') {
			$this->form_validation->set_rules('Intervalo', 'Intervalo', 'required|trim|valid_intervalo');
			$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo');
			$this->form_validation->set_rules('Tempo', 'Tempo', 'required|trim');
			$this->form_validation->set_rules('Tempo', 'Tempo2', 'required|trim');
			$this->form_validation->set_rules('DataMinima', 'Data Mínima:', 'trim|valid_date');
			$this->form_validation->set_rules('DataTermino', 'Termina em:', 'required|trim|valid_date|valid_data_termino[' . $data['cadastrar']['DataMinima'] . ']|valid_data_termino2[' . $data['query']['Data'] . ']');
		}else{
			if($data['query']['Recorrencias'] > 1){
				$this->form_validation->set_rules('Repetir', 'Repetir', 'valid_repetir');
			}
		}
		if(($data['query']['OS'] > 1 && $data['cadastrar']['Adicionar'] == "S" 
			&& $data['cadastrar']['PorConsulta'] == "N" && $data['cadastrar']['NovaOS'] == "N" 
			&& $data['cadastrar']['Vincular'] == "S") 
			|| ($data['query']['OS'] == 1 && $data['cadastrar']['Adicionar'] == "S" 
			&& $data['cadastrar']['PorConsulta'] == "N" && $data['cadastrar']['Vincular'] == "S" )){
			$this->form_validation->set_rules('idApp_OrcaTrata', 'O.S.', 'required|trim');
		}
        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data do Fim', 'required|trim|valid_date');

        $this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim|valid_cliente');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');

		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
			$this->load->view('consulta/form_consulta', $data);

		} else {
		
			$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
			$data1 = $data1->format('Y-m-d');       
			
			$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
			$data2 = $data2->format('Y-m-d');    
				

			$this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_periodo_data[' . $data['query']['Data'] . ']');			
			$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
			
			if(strtotime($data2) == strtotime($data1)){
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
			}else{
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
			}			
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('consulta/form_consulta', $data);

			} else {

				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'consulta/cadastrar2' . $data['msg']);

				} else {

					$dataini_cad 	= $this->basico->mascara_data($data['query']['Data'], 'mysql');
					$datafim_cad 	= $this->basico->mascara_data($data['query']['Data2'], 'mysql');
					$horaini_cad 	= $data['query']['HoraInicio'];
					$horafim_cad 	= $data['query']['HoraFim'];
					
					if ($data['cadastrar']['Repetir'] == 'N') {
						$data['query']['Intervalo'] = 0;
						$data['query']['Periodo'] = 0;
						$data['query']['Tempo'] = 0;
						$data['query']['Tempo2'] = 0;
						$data['query']['DataTermino'] = $dataini_cad;
					}else{
						
						$tipointervalo = $data['query']['Tempo'];
						if($tipointervalo == 1){
							$semana = 1;
							$ref = "day";
						}elseif($tipointervalo == 2){
							$semana = 7;
							$ref = "day";
						}elseif($tipointervalo == 3){
							$semana = 1;
							$ref = "month";
						}elseif($tipointervalo == 4){
							$semana = 1;
							$ref = "Year";
						}

						$n = $data['query']['Intervalo']; //intervalo - a cada tantos dias
						$qtd = $data['query']['Recorrencias'];
						$data['query']['DataTermino'] = $this->basico->mascara_data($data['query']['DataTermino'], 'mysql');
						
					}
					if($_SESSION['Empresa']['CadastrarDep'] == "N"){
						$data['query']['idApp_ClienteDep'] = 0;
					}else{
						if($data['query']['idApp_ClienteDep'] == ''){
							$data['query']['idApp_ClienteDep'] = 0;
						}
					}
					if($_SESSION['Empresa']['CadastrarPet'] == "N"){
						$data['query']['idApp_ClientePet'] = 0;
					}else{
						if($data['query']['idApp_ClientePet'] == ''){
							$data['query']['idApp_ClientePet'] = 0;
						}
					}
					$data['query']['Tipo'] = 2;
					$data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
					#$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
					$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
					//$data['query']['idTab_Status'] = 1;
					$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

					if($data['cadastrar']['Extra'] == 'S'){
						
						$data['consulta'] = $this->Consulta_model->get_consulta($data['query']['Repeticao']);
						$data['update']['cons_anters'] = $this->Consulta_model->get_consultas($data['query']['Repeticao']);
						$cont_cons_anters = count($data['update']['cons_anters']);
						
						if($data['cadastrar']['Hidden_Caso'] == 0){
							
							$data['query']['Repeticao'] = 0;				
							
							if($data['cadastrar']['Adicionar'] == "S"){
								if($data['cadastrar']['PorConsulta'] == "S"){
									//Cadastro O número de Recorrências de OS  novas
									$data['query']['OS'] = $data['query']['Recorrencias'];
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['query']['Recorrencias'] > 1){
										//Abro a Opção de escolher Cadastrar  1 OS Nova, ou Selecionar 1 OS
										if($data['cadastrar']['NovaOS'] == "S"){
											//Cadastro 1 OS  nova
											$data['query']['OS'] = "1";
											$data['query']['idApp_OrcaTrata'] = "0";
										}else{
											if($data['cadastrar']['Vincular'] == "S"){
												//Seleciona 1 OS
												$data['query']['OS'] = "1";
											}else{
												//Não cadastro nenhuma OS
												$data['query']['OS'] = "0";
												$data['query']['idApp_OrcaTrata'] = "0";
											}
										}
									}else{
										//Escolher 1 OS
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}
							}else{
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 1){
							
							//N-1 ou N-N, Cadastro 1 ou N os novas
							
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['query']['OS'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//cadastro 1 OS nova
											$data['query']['OS'] = "1";
											$data['query']['idApp_OrcaTrata'] = "0";
										}else{
											if($data['cadastrar']['Vincular'] == "S"){
												//Seleciona 1 OS
												$data['query']['OS'] = "1";
											}else{
												//Não cadastro nenhuma OS
												$data['query']['OS'] = "0";
												$data['query']['idApp_OrcaTrata'] = "0";
											}
										}
									}else{
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
													
						}elseif($data['cadastrar']['Hidden_Caso'] == 2){
							
							//N-1 ou N-N, Uso a OS existente, ou Cadastro o Numero de Recorrencias de OS novas
							
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['OS'] = $data['query']['Recorrencias'];
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									//Pego a OS existente e uso para todas os agendamentos
									$data['query']['OS'] = 1;
									$data['query']['idApp_OrcaTrata'] = $data['consulta']['idApp_OrcaTrata'];
								}
							}else{
								//Não cadastro nenhuma OS
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 3){
							
							//N-1 ou N-N, Cadastro 1 ou N os novas
							
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['query']['OS'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//cadastro 1 OS nova
											$data['query']['OS'] = "1";
											$data['query']['idApp_OrcaTrata'] = "0";
										}else{
											if($data['cadastrar']['Vincular'] == "S"){
												//Seleciona 1 OS
												$data['query']['OS'] = "1";
											}else{
												//Não cadastro nenhuma OS
												$data['query']['OS'] = "0";
												$data['query']['idApp_OrcaTrata'] = "0";
											}
										}
									}else{
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 4){
							if($data['cadastrar']['Adicionar'] == "S"){
								//N-1, Pego a OS existente e uso para todas os agendamentos
								$data['query']['OS'] = 1;
								$data['query']['idApp_OrcaTrata'] = $data['consulta']['idApp_OrcaTrata'];
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
						}elseif($data['cadastrar']['Hidden_Caso'] == 5){
							if($data['cadastrar']['Adicionar'] == "S"){		
								//N-N, Cadastro o número de OS novas
								$data['query']['OS'] = $data['query']['Recorrencias'];
								$data['query']['idApp_OrcaTrata'] = "0";
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}						
						}else{

						}
										
					}else{
						$data['query']['Repeticao'] = 0;				
						
						if($data['cadastrar']['Adicionar'] == "S"){
							if($data['cadastrar']['PorConsulta'] == "S"){
								//Cadastro O número de Recorrências de OS  novas
								$data['query']['OS'] = $data['query']['Recorrencias'];
								$data['query']['idApp_OrcaTrata'] = "0";
							}else{
								if($data['query']['Recorrencias'] > 1){
									//Abro a Opção de escolher Cadastrar  1 OS Nova, ou Selecionar 1 OS
									if($data['cadastrar']['NovaOS'] == "S"){
										//Cadastro 1 OS  nova
										$data['query']['OS'] = "1";
										$data['query']['idApp_OrcaTrata'] = "0";
									}else{
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
											//$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}else{
									//Escolher 1 OS
									if($data['cadastrar']['Vincular'] == "S"){
										//Seleciona 1 OS
										$data['query']['OS'] = "1";
										//$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
									}else{
										//Não cadastro nenhuma OS
										$data['query']['OS'] = "0";
										$data['query']['idApp_OrcaTrata'] = "0";
									}
								}
							}
						}else{
							$data['query']['OS'] = "0";
							$data['query']['idApp_OrcaTrata'] = "0";
						}
					}
					
					$data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
					
					$dataini_whats 	= $data['query']['Data'];
					$horaini_whats	= $data['query']['HoraInicio'];
					
					#unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
					unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
					
					$data['campos'] = array_keys($data['query']);
					$data['anterior'] = array();

					$data['query']['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

					unset($_SESSION['Agenda']);

					if ($data['query']['idApp_Consulta'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('consulta/form_consulta', $data);
					} else {
						
						#### Whatsapp ####
						if($data['cadastrar']['Whatsapp'] == 'S'){
							$data['Cliente'] 		= $this->Cliente_model->get_cliente($data['query']['idApp_Cliente'], TRUE);
							$data['Profissional'] 	= $this->Cliente_model->get_profissional($data['query']['idApp_Agenda'], TRUE);
							
							$_SESSION['bd_consulta']['Whatsapp'] 		= $data['cadastrar']['Whatsapp'];
							$_SESSION['bd_consulta']['NomeCliente'] 	= utf8_encode($data['Cliente']['NomeCliente']);
							$_SESSION['bd_consulta']['CelularCliente'] 	= $data['Cliente']['CelularCliente'];
							$_SESSION['bd_consulta']['Profissional'] 	= utf8_encode($data['Profissional']['Nome']);
							$_SESSION['bd_consulta']['DataInicio'] 		= $dataini_whats;
							$_SESSION['bd_consulta']['HoraInicio'] 		= $horaini_whats;
							
							unset($data['Cliente'], $data['Profissional'], $dataini_whats, $horaini_whats);
						}

						if($data['cadastrar']['Extra'] == 'S'){
							if(isset($data['consulta'])){
								$data['copiar']['idApp_ClientePet'] = $data['consulta']['idApp_ClientePet'];
								$data['copiar']['idApp_ClienteDep'] = $data['consulta']['idApp_ClienteDep'];
							}else{
								$data['copiar']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
								$data['copiar']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
							}
							$data['copiar']['Repeticao'] 		= $data['query']['Repeticao'];
							$_SESSION['Copiar']['Repeticao'] 	= $data['query']['Repeticao'];
							$qtd_OS = $data['query']['OS'];
						}else{
							$data['copiar']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
							$data['copiar']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
							$data['copiar']['Repeticao'] 		= $data['query']['idApp_Consulta'];
							$_SESSION['Copiar']['Repeticao'] 	= $data['query']['idApp_Consulta'];
							$qtd_OS = $data['query']['Recorrencias'];
						}
						
						$pegouOS = false;
						if($data['cadastrar']['Adicionar'] == "S"){
							if($data['cadastrar']['PorConsulta'] == "N"){
								if($qtd_OS > 1){
									if($data['cadastrar']['NovaOS'] == "N"){
										if($data['cadastrar']['Vincular'] == "S"){
											if(isset($data['query']['idApp_OrcaTrata']) && $data['query']['idApp_OrcaTrata'] !=0){
												$pegouOS = true;
											}
										}
									}
								}else{
									if($data['cadastrar']['Vincular'] == "S"){
										if(isset($data['query']['idApp_OrcaTrata']) && $data['query']['idApp_OrcaTrata'] !=0){
											$pegouOS = true;
										}
									}
								}
							}							
						}
						
						if($pegouOS == true){	
							
							//Passo o valor da repetição para a OS selecionada

							$data['orcatrata']['RepeticaoCons'] 	= $data['copiar']['Repeticao'];
							$data['orcatrata']['idApp_ClientePet'] 	= $data['copiar']['idApp_ClientePet'];
							$data['orcatrata']['idApp_ClienteDep'] 	= $data['copiar']['idApp_ClienteDep'];
							
							$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['query']['idApp_OrcaTrata']);
							
							// update nos agendamento de OS = 0 
							if(isset($cont_cons_anters)){
								
								for($j=0;$j<$cont_cons_anters;$j++) {
								
									$data['update']['cons_anters'][$j]['OS'] = $data['query']['OS'];
									$data['update']['cons_anters'][$j]['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
									
									$data['update']['cons_anters']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_anters'][$j], $data['update']['cons_anters'][$j]['idApp_Consulta']);
								}
							}
						}					

						
						if($data['cadastrar']['Repetir'] == 'S'){
							$data['copiar']['DataTermino'] = $data['query']['DataTermino'];
							$data['copiar']['Recorrencia'] = "1/" . $qtd;
						}else{
							if($data['cadastrar']['Extra'] == 'S'){
								$data['copiar']['Recorrencia'] = "Ext";
							}else{
								$data['copiar']['Recorrencia'] = "1/1";
								//$data['copiar']['DataTermino'] = $dataini_cad;
							}
						}
						
						$data['update']['copiar']['bd'] = $this->Consulta_model->update_consulta($data['copiar'], $data['query']['idApp_Consulta']);

						if ($data['update']['copiar']['bd'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('consulta/form_consulta', $data);
						} else {
							if ($data['cadastrar']['Repetir'] == 'S') {
								for($j=1; $j<$qtd; $j++) {
									$data['repeticao'][$j] = array(
										'Repeticao' 			=> $data['copiar']['Repeticao'],
										'Intervalo' 			=> $data['query']['Intervalo'],
										'Periodo' 				=> $data['query']['Periodo'],
										'Tempo' 				=> $data['query']['Tempo'],
										'Tempo2' 				=> $data['query']['Tempo2'],
										'DataTermino' 			=> $data['query']['DataTermino'],
										'Recorrencias' 			=> $data['query']['Recorrencias'],
										'Recorrencia' 			=> ($j + 1) .  '/' . $data['query']['Recorrencias'],
										'OS' 					=> $data['query']['OS'],
										'idApp_Agenda' 			=> $data['query']['idApp_Agenda'],
										'idApp_Cliente' 		=> $data['query']['idApp_Cliente'],
										'idApp_ClienteDep' 		=> $data['copiar']['idApp_ClienteDep'],
										'idApp_ClientePet' 		=> $data['copiar']['idApp_ClientePet'],
										'idApp_OrcaTrata' 		=> $data['query']['idApp_OrcaTrata'],
										//'Evento' 				=> $data['query']['Evento'],
										'Obs' 					=> $data['query']['Obs'],
										'idTab_Status' 			=> $data['query']['idTab_Status'],
										'Tipo' 					=> $data['query']['Tipo'],
										'idTab_TipoConsulta' 	=> $data['query']['idTab_TipoConsulta'],
										'Paciente' 				=> $data['query']['Paciente'],
										'DataInicio' 			=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) .  $ref,strtotime($dataini_cad))) . ' ' . $horaini_cad,
										'DataFim' 				=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) . $ref,strtotime($datafim_cad))) . ' ' . $horafim_cad,
										'idSis_Usuario' 		=> $_SESSION['log']['idSis_Usuario'],
										'idSis_Empresa' 		=> $_SESSION['log']['idSis_Empresa'],
										'idTab_Modulo' 			=> $_SESSION['log']['idTab_Modulo']
									);
									$data['campos'] = array_keys($data['repeticao'][$j]);
									$data['id_Repeticao'] = $this->Consulta_model->set_consulta($data['repeticao'][$j]);
								}
						
							}
						}

						if($data['cadastrar']['Extra'] == 'S'){	
						
							$data['cons_datatermino'] = $this->Consulta_model->get_consulta_datatermino($data['query']['Repeticao']);
							$data['data_termino'] = $data['cons_datatermino']['DataInicio'];
							
							$data['update']['cons_posts'] = $this->Consulta_model->get_consultas($data['query']['Repeticao']);
							$cont_cons_posts = count($data['update']['cons_posts']);
							
							if(isset($cont_cons_posts)){
								
								for($j=0;$j<$cont_cons_posts;$j++) {
									$k = (1 + $j);
									$data['update']['cons_posts'][$j]['DataTermino'] = $data['data_termino'];
									$data['update']['cons_posts'][$j]['Recorrencias'] = $cont_cons_posts;
									$data['update']['cons_posts'][$j]['Recorrencia'] = $k . "/" . $cont_cons_posts;
									$data['update']['cons_posts']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_posts'][$j], $data['update']['cons_posts'][$j]['idApp_Consulta']);
								}
							}
						}
											
						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';

						if($data['cadastrar']['Extra'] == 'S'){
							
							if($data['cadastrar']['Hidden_Caso'] == 0){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										if($data['query']['Recorrencias'] > 1){
											if($data['cadastrar']['NovaOS'] == "S"){
												//Gera uma única O.S.
												redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
												exit();
											}else{
												//Não Gera O.S. 
												redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
												exit();
											}
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}

							}elseif($data['cadastrar']['Hidden_Caso'] == 1){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										if($data['query']['OS'] > 1){
											if($data['cadastrar']['NovaOS'] == "S"){
												//Gera uma única O.S.
												redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
												exit();
											}else{
												//Não Gera O.S. 
												redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
												exit();
											}
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}
								
							}elseif($data['cadastrar']['Hidden_Caso'] == 2){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										//Não Gera O.S. 
										redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
										exit();
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}
								
							}elseif($data['cadastrar']['Hidden_Caso'] == 3){
								
								if($data['cadastrar']['Adicionar'] == "S"){	
									if($data['cadastrar']['PorConsulta'] == "S"){
										//Gera O.S. Replicadas pelo número de ocorrências
										redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
										exit();
									}else{
										if($data['query']['OS'] > 1){
											if($data['cadastrar']['NovaOS'] == "S"){
												//Gera uma única O.S.
												redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
												exit();
											}else{
												//Não Gera O.S. 
												redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
												exit();
											}
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}
								
							}elseif($data['cadastrar']['Hidden_Caso'] == 4){
								if($data['cadastrar']['Adicionar'] == "S"){	
									//Pega a O.S. da repetição
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}							
							}elseif($data['cadastrar']['Hidden_Caso'] == 5){
								if($data['cadastrar']['Adicionar'] == "S"){	
									//Gera O.S. Replicadas pelo número de Recorrências
									redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
									exit();
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}							
							}else{

							}							
						}else{
							if($data['cadastrar']['Adicionar'] == "S"){	
								if($data['cadastrar']['PorConsulta'] == "S"){
									//Gera O.S. Replicadas pelo número de ocorrências
									redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
									exit();
								}else{
									if($data['query']['Recorrencias'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//Gera uma única O.S.
											redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
											exit();
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}else{
										//Não Gera O.S. 
										redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
										exit();
									}
								}
							}else{
								//Não Gera O.S. 
								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
								exit();
							}						
						}
					}
				}	
			}
        }

        $this->load->view('basico/footer');
    }

    public function alterar($idApp_Cliente = NULL, $idApp_Consulta = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar as alterações do Agendamento.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Whatsapp',
			'Adicionar',
			'PeloPet',
			'PortePet',
			'RacaPet',
			'Extra',
			'Vincular',
			'NovaOS',
			'PorConsulta',
			'EspeciePet',
			'Hidden_status',
			'Hidden_Caso',
        ), TRUE));
		
		$data['alterar'] = quotes_to_entities($this->input->post(array(
			'Quais',
			'Quais_excluir',
			'DeletarOS',
        ), TRUE));

        $data['query'] = $this->input->post(array(
			'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
            'idApp_ClienteDep',
            'idApp_ClientePet',
            'idApp_OrcaTrata',
            'Repeticao',
            'OS',
            'Data',
            'Data2',
			'HoraInicio',
            'HoraFim',
            'idTab_Status',
            'Paciente',
            'Procedimento',
            'Obs',
			'idTab_TipoConsulta',
		), TRUE);

		(!$data['alterar']['Quais']) ? $data['alterar']['Quais'] = 1 : FALSE;
 		(!$data['alterar']['DeletarOS']) ? $data['alterar']['DeletarOS'] = 'S' : FALSE;
 		(!$data['cadastrar']['Extra']) ? $data['cadastrar']['Extra'] = 'S' : FALSE;
 		(!$data['cadastrar']['Adicionar']) ? $data['cadastrar']['Adicionar'] = 'N' : FALSE;
 		(!$data['cadastrar']['Vincular']) ? $data['cadastrar']['Vincular'] = 'S' : FALSE;
 		(!$data['cadastrar']['NovaOS']) ? $data['cadastrar']['NovaOS'] = 'S' : FALSE;
 		(!$data['cadastrar']['PorConsulta']) ? $data['cadastrar']['PorConsulta'] = 'S' : FALSE;

		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
			$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
		}
		
        if ($idApp_Consulta) {
            #$data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Consulta'] = $data['query'] = $this->Consulta_model->get_consulta($idApp_Consulta);
			$_SESSION['dataTermino'] = $_SESSION['Consulta']['DataTermino'];
            $_SESSION['Consulta']['DataTermino'] = $this->basico->mascara_data($_SESSION['Consulta']['DataTermino'], 'barras');
			$dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);
            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['Data2'] = $this->basico->mascara_data($datafim[0], 'barras');
			$data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
			$_SESSION['Consulta']['DataInicio'] = $dataini[0];
            $_SESSION['Consulta']['DataFim'] = $datafim[0];
			
			$_SESSION['Consultas_zero'] = $data['consultas_zero'] = $this->Consulta_model->get_consultas_zero($_SESSION['Consulta']['idApp_OrcaTrata'], TRUE);
            $_SESSION['Consultas_Repet'] = $data['consultas_repet'] = $this->Consulta_model->get_consultas_repet($_SESSION['Consulta']['Repeticao']);
			
			$_SESSION['Repeticao_Cons'] = $this->Consulta_model->get_repeticao_cos($_SESSION['Consulta']['Repeticao']);			
			
			$_SESSION['RepeticaoCons'] = $this->Orcatrata_model->get_repeticaocons($_SESSION['Consulta']['Repeticao']);
			$_SESSION['RepeticaoOrca'] = $this->Orcatrata_model->get_repeticaoorca($_SESSION['Consulta']['Repeticao']);
				
		} else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
        }

		$data['count_zero'] = count($_SESSION['Consultas_zero']);//conta quantas Consultas tem esse idApp_OrcaTrata
		if(isset($_SESSION['Consultas_Repet'])){
			$data['count_repet'] = count($_SESSION['Consultas_Repet']);//conta quantas Consultas tem essa repetição e "idApp_OrcaTrata = 0"	
		}else{
			$data['count_repet'] = 0;
		}
		
		$data['repeticaocons'] = count($_SESSION['RepeticaoCons']);// conto quantas Consultas tem essa repetição
		$data['repeticaoorca'] = count($_SESSION['RepeticaoOrca']);// conto quantas OS tem essa repetição

		/////////////// pego as informçãoes das OS para colocar no visor das consultas///////////////////////
		
		if (isset($_SESSION['Repeticao_Cons']) && count($_SESSION['Repeticao_Cons']) > 0) {
			$data['repeticao_cons'] = $_SESSION['Repeticao_Cons'];
			$data['repeticao_cons'] = array_combine(range(1, count($data['repeticao_cons'])), array_values($data['repeticao_cons']));
			$data['count']['POCount'] = count($data['repeticao_cons']);           
			
			if (isset($data['repeticao_cons'])) {

				for($i=1;$i<=$data['count']['POCount'];$i++) {

					//$data['repeticao_cons'][$i]['DataEntregaOrca'] = $this->basico->mascara_data($data['repeticao_cons'][$i]['DataEntregaOrca'], 'barras');
					
					#### App_ProdutoVenda ####
					$data['produto'][$i] = $this->Consulta_model->get_produto($data['repeticao_cons'][$i]['idApp_OrcaTrata']);
					if (count($data['produto'][$i]) > 0) {
						$data['produto'][$i] = array_combine(range(1, count($data['produto'][$i])), array_values($data['produto'][$i]));
						$data['count']['PCount'][$i] = count($data['produto'][$i]);

						if (isset($data['produto'][$i])) {

							for($k=1;$k<=$data['count']['PCount'][$i];$k++) {
								$data['produto'][$i][$k]['SubtotalProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto'] * $data['produto'][$i][$k]['QtdProduto']), 2, ',', '.');
								$data['produto'][$i][$k]['ValorProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto']), 2, ',', '.');
								$data['produto'][$i][$k]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$i][$k]['DataConcluidoProduto'], 'barras');
								$data['produto'][$i][$k]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['ConcluidoProduto'], 'NS');
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['produto'][$i][$k]);
								echo "</pre>";
								*/
							}
						}
					}
				}
			}
		}
		
		//////////////////////////////////////////////////////////////////
		
        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            #$data['readonly'] = 'readonly';
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }

        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';
		
		$data['select']['EspeciePet'] = array (
            //'0' => '',
            '1' => 'CÃO',
            '2' => 'GATO',
			'3' => 'AVE',
        );	
		$data['select']['PeloPet'] = array (
            //'0' => '',
            '1' => 'CURTO',
            '2' => 'MÉDIO',
			'3' => 'LONGO',
			'4' => 'CACHEADO',
        );		
		$data['select']['PortePet'] = array (
            //'0' => '',
            '1' => 'MINI',
            '2' => 'PEQUENO',
			'3' => 'MÉDIO',
			'4' => 'GRANDE',
			'5' => 'GIGANTE',
        );
		$data['select']['RacaPet'] = $this->Cliente_model->select_racapet();	
        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['Whatsapp'] = $this->Basico_model->select_status_sn();
        $data['select']['Adicionar'] = $this->Basico_model->select_status_sn();
		$data['select']['DeletarOS'] = $this->Basico_model->select_status_sn();
		$data['select']['Vincular'] = $this->Basico_model->select_status_sn();
		$data['select']['NovaOS'] = $this->Basico_model->select_status_sn();
		$data['select']['PorConsulta'] = $this->Basico_model->select_status_sn();
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
        $data['select']['idApp_ClienteDep'] = $this->Cliente_model->select_clientedep($_SESSION['Cliente']['idApp_Cliente']);
        $data['select']['idApp_ClientePet'] = $this->Cliente_model->select_clientepet($_SESSION['Cliente']['idApp_Cliente']);
        $data['select']['idApp_OrcaTrata'] = $this->Cliente_model->select_orcatrata($_SESSION['Cliente']['idApp_Cliente']);	
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa4();
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );		
		$data['select']['Quais'] = array (
            '1' => 'Apenas Este',
            '2' => 'Este e os Anteriores',
			'3' => 'Este e os Posteriores',
			'4' => 'Todas',
        );

		if ($_SESSION['log']['idSis_Empresa'] == 5) {
			$data['resumo1'] = $this->Agenda_model->get_agenda($data['query']['idApp_Agenda']);
			$_SESSION['Agenda']['Nome'] = (strlen($data['resumo1']['Nome']) > 30) ? substr($data['resumo1']['Nome'], 0, 30) : $data['resumo1']['Nome'];
			$_SESSION['Agenda']['NomeEmpresa'] = (strlen($data['resumo1']['NomeEmpresa']) > 30) ? substr($data['resumo1']['NomeEmpresa'], 0, 30) : $data['resumo1']['NomeEmpresa'];
		}

        $data['titulo'] = 'Editar Agendamento';
        $data['form_open_path'] = 'consulta/alterar';
        #$data['readonly'] = '';
        #$data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['alterarcliente'] = 2;
        $data['caminho2'] = '../../';
		$data['extra'] = 'S';
		
		$data['exibir_id'] = 0;
		
		if($_SESSION['Consulta']['idApp_OrcaTrata'] == 0 || $_SESSION['Consulta']['idApp_OrcaTrata'] == ""){
			$data['vincular'] = 'S';
		}else{
			$data['vincular'] = 'N';
		}
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
		
 		(!$data['cadastrar']['Whatsapp']) ? $data['cadastrar']['Whatsapp'] = 'N' : FALSE;       
		
		$data['radio'] = array(
            'Whatsapp' => $this->basico->radio_checked($data['cadastrar']['Whatsapp'], 'Whatsapp', 'NS'),
        );
        ($data['cadastrar']['Whatsapp'] == 'S') ?
            $data['div']['Whatsapp'] = '' : $data['div']['Whatsapp'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Adicionar' => $this->basico->radio_checked($data['cadastrar']['Adicionar'], 'Adicionar', 'NS'),
        );
        ($data['cadastrar']['Adicionar'] == 'S') ?
            $data['div']['Adicionar'] = '' : $data['div']['Adicionar'] = 'style="display: none;"';

		$data['radio'] = array(
            'DeletarOS' => $this->basico->radio_checked($data['alterar']['DeletarOS'], 'DeletarOS', 'NS'),
        );
        ($data['alterar']['DeletarOS'] == 'S') ?
            $data['div']['DeletarOS'] = '' : $data['div']['DeletarOS'] = 'style="display: none;"';			

		$data['radio'] = array(
            'Vincular' => $this->basico->radio_checked($data['cadastrar']['Vincular'], 'Vincular', 'NS'),
        );
        ($data['cadastrar']['Vincular'] == 'S') ?
            $data['div']['Vincular'] = '' : $data['div']['Vincular'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'NovaOS' => $this->basico->radio_checked($data['cadastrar']['NovaOS'], 'NovaOS', 'NS'),
        );
        ($data['cadastrar']['NovaOS'] == 'N') ?
            $data['div']['NovaOS'] = '' : $data['div']['NovaOS'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'PorConsulta' => $this->basico->radio_checked($data['cadastrar']['PorConsulta'], 'PorConsulta', 'NS'),
        );
        ($data['cadastrar']['PorConsulta'] == 'N') ?
            $data['div']['PorConsulta'] = '' : $data['div']['PorConsulta'] = 'style="display: none;"';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		
		$data['q3'] = $this->Clientepet_model->list_racapet(TRUE);
		$data['list3'] = $this->load->view('clientepet/list_racapet', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('Data', 'Data Inicio', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_date');

		$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');	

		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');
		$this->form_validation->set_rules('Quais', 'Quais Alterar', 'required|trim');	
		
		if(($data['count_repet'] > 1 && $data['cadastrar']['Adicionar'] == "S" 
			&& $data['cadastrar']['PorConsulta'] == "N" && $data['cadastrar']['NovaOS'] == "N" 
			&& $data['cadastrar']['Vincular'] == "S") 
			|| ($data['count_repet'] == 1 && $data['cadastrar']['Adicionar'] == "S" 
			&& $data['cadastrar']['PorConsulta'] == "N" && $data['cadastrar']['Vincular'] == "S" )){
			$this->form_validation->set_rules('idApp_OrcaTrata', 'O.S.', 'required|trim');
		}
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            if ($_SESSION['log']['idSis_Empresa'] == 5) {
				$this->load->view('consulta/form_consulta0', $data);
			} else {
				$this->load->view('consulta/form_consulta', $data);
			}
			
        } else {
		
			$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
			$data1 = $data1->format('Y-m-d');       
			
			$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
			$data2 = $data2->format('Y-m-d');    

			$this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_periodo_data[' . $data['query']['Data'] . ']');			
			$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
			
			if(strtotime($data2) == strtotime($data1)){
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
			}else{
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
			}			
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('consulta/form_consulta', $data);

			} else {

				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'consulta/alterar/' . $_SESSION['Cliente']['idApp_Cliente'] . '/' . $_SESSION['Consulta']['idApp_Consulta'] . $data['msg']);
					
				} else {
				
					/*
					echo '<br>';
					echo "<pre>";
					print_r('OS = ' . $data['query']['OS']);
					echo '<br>';
					print_r('Cont = ' . $data['count_repet']);
					echo "</pre>";
					exit();			
					*/
					if($_SESSION['Consulta']['idApp_Cliente'] != $data['query']['idApp_Cliente']){
						$data['query']['Repeticao'] = $data['query']['idApp_Consulta'];
					}else{
						$data['query']['Repeticao'] = $_SESSION['Consulta']['Repeticao'];
					}
					if($_SESSION['Empresa']['CadastrarDep'] == "N"){
						$data['query']['idApp_ClienteDep'] = 0;
					}else{
						if($data['query']['idApp_ClienteDep'] == ''){
							$data['query']['idApp_ClienteDep'] = 0;
						}
					}
					if($_SESSION['Empresa']['CadastrarPet'] == "N"){
						$data['query']['idApp_ClientePet'] = 0;
					}else{
						if($data['query']['idApp_ClientePet'] == ''){
							$data['query']['idApp_ClientePet'] = 0;
						}
					}			
					$data['query']['Tipo'] = 2;
					$data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
					$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
					$data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
					
					$dataanteriorinicio = strtotime($_SESSION['Consulta']['DataInicio']);
					$dataanteriorfim = strtotime($_SESSION['Consulta']['DataFim']);
					
					$dataposteriorinicio = strtotime($data1);
					$dataposteriorfim = strtotime($data2);
					
					$diferencainicio = ($dataposteriorinicio - $dataanteriorinicio)/86400;
					$diferencafim = ($dataposteriorfim - $dataanteriorfim)/86400;
					
					if($diferencainicio <= 0){
						$difinicio = $diferencainicio;
					}else{
						$difinicio = '+' . $diferencainicio;
					}
					
					if($diferencafim < 0){
						$diffim = $diferencafim;
					}else{
						$diffim = '+' . $diferencafim;
					}
					
					$dataini_alt 	= $this->basico->mascara_data($data['query']['Data'], 'mysql');
					$datafim_alt 	= $this->basico->mascara_data($data['query']['Data2'], 'mysql');
					$horaini_alt 	= $data['query']['HoraInicio'];
					$horafim_alt 	= $data['query']['HoraFim'];

					if($_SESSION['Consulta']['idApp_OrcaTrata'] == 0 || $_SESSION['Consulta']['idApp_OrcaTrata'] == ""){
						
						//$data['consulta'] = $this->Consulta_model->get_repeticao($_SESSION['Consulta']['Repeticao']); //pego a consulta original dessa repetição
						
						if($data['repeticaoorca'] == 1){
							$data['consulta']['idApp_OrcaTrata'] = $_SESSION['RepeticaoOrca'][0]['idApp_OrcaTrata'];
						}
						
						//$data['consultas'] = $this->Consulta_model->get_consulta_posterior($data['query']['idApp_Consulta'], $_SESSION['Consulta']['Repeticao'], $data['alterar']['Quais'], $dataini_alt);// Pego "QUAIS" Consultas da repetição eu quero usar
						$data['consultas'] = $this->Consulta_model->get_consultas($_SESSION['Consulta']['Repeticao']); //pego todas as consultas que pertencem a essa repetição
						$cont_cons_anters = count($data['consultas']);//conto a quantidade de consultas dessa repetição
						
						if($data['cadastrar']['Hidden_Caso'] == 0){

							if($data['cadastrar']['Adicionar'] == "S"){
								if($data['cadastrar']['PorConsulta'] == "S"){
									//Cadastro O número de Recorrências de OS  novas
									$data['query']['OS'] = $data['query']['Recorrencias'];
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['query']['Recorrencias'] > 1){
										//Abro a Opção de escolher Cadastrar  1 OS Nova, ou Selecionar 1 OS
										if($data['cadastrar']['NovaOS'] == "S"){
											//Cadastro 1 OS  nova
											$data['query']['OS'] = "1";
											$data['query']['idApp_OrcaTrata'] = "0";
										}else{
											if($data['cadastrar']['Vincular'] == "S"){
												//Seleciona 1 OS
												$data['query']['OS'] = "1";
											
												$data['orcatrata']['RepeticaoCons'] 	= $_SESSION['Consulta']['Repeticao'];
												$data['orcatrata']['idApp_ClientePet'] 	= $data['query']['idApp_ClientePet'];
												$data['orcatrata']['idApp_ClienteDep'] 	= $data['query']['idApp_ClienteDep'];
												$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['query']['idApp_OrcaTrata']);
												
												if (count($data['consultas']) > 0) {
													$data['consultas'] = array_combine(range(1, count($data['consultas'])), array_values($data['consultas']));
													$max_consultas = count($data['consultas']);
													if (isset($data['consultas'])) {
														for($j=1; $j <= $max_consultas; $j++) {
															
															$data['consultas'][$j]['idApp_OrcaTrata'] 		= $data['query']['idApp_OrcaTrata'];
															
															$data['update']['consultas'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['consultas'][$j], $data['consultas'][$j]['idApp_Consulta']);
														}
													}
												}
											}else{
												//Não cadastro nenhuma OS
												$data['query']['OS'] = "0";
												$data['query']['idApp_OrcaTrata'] = "0";
											}
										}
									}else{
										//Escolher 1 OS
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS
											$data['query']['OS'] = "1";
										}else{
											//Não cadastro nenhuma OS
											$data['query']['OS'] = "0";
											$data['query']['idApp_OrcaTrata'] = "0";
										}
									}
								}
							}else{
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 1){
							
							//N-1 ou N-N, Cadastro 1 ou N os novas
							
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['count_repet'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//cadastro 1 OS nova
											$data['query']['OS'] = "1";
											$data['query']['idApp_OrcaTrata'] = "0";
										}else{
											if($data['cadastrar']['Vincular'] == "S"){
												//Seleciona 1 OS e uso para todas os agendamentos
												$data['query']['OS'] = "1";
												
												$data['orcatrata']['RepeticaoCons'] 	= $_SESSION['Consulta']['Repeticao'];
												$data['orcatrata']['idApp_ClientePet'] 	= $data['query']['idApp_ClientePet'];
												$data['orcatrata']['idApp_ClienteDep'] 	= $data['query']['idApp_ClienteDep'];
												$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['query']['idApp_OrcaTrata']);
												
												if (count($data['consultas']) > 0) {
													$data['consultas'] = array_combine(range(1, count($data['consultas'])), array_values($data['consultas']));
													$max_consultas = count($data['consultas']);
													if (isset($data['consultas'])) {
														for($j=1; $j <= $max_consultas; $j++) {
															
															$data['consultas'][$j]['idApp_OrcaTrata'] 		= $data['query']['idApp_OrcaTrata'];
															
															$data['update']['consultas'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['consultas'][$j], $data['consultas'][$j]['idApp_Consulta']);
														}
													}
												}
												
											}else{
												//Não cadastro nenhuma OS
												$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
												$data['query']['OS'] = $_SESSION['Consulta']['OS'];
											}
										}
									}else{
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS e uso para todas os agendamentos
											$data['query']['OS'] = "1";
											
											$data['orcatrata']['RepeticaoCons'] 	= $_SESSION['Consulta']['Repeticao'];
											$data['orcatrata']['idApp_ClientePet'] 	= $data['query']['idApp_ClientePet'];
											$data['orcatrata']['idApp_ClienteDep'] 	= $data['query']['idApp_ClienteDep'];
											$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['query']['idApp_OrcaTrata']);
											
											if (count($data['consultas']) > 0) {
												$data['consultas'] = array_combine(range(1, count($data['consultas'])), array_values($data['consultas']));
												$max_consultas = count($data['consultas']);
												if (isset($data['consultas'])) {
													for($j=1; $j <= $max_consultas; $j++) {
														
														$data['consultas'][$j]['idApp_OrcaTrata'] 		= $data['query']['idApp_OrcaTrata'];
														
														$data['update']['consultas'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['consultas'][$j], $data['consultas'][$j]['idApp_Consulta']);
													}
												}
											}
											
										}else{
											//Não cadastro nenhuma OS
											$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
											$data['query']['OS'] = $_SESSION['Consulta']['OS'];
										}
									}	
								}
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
								$data['query']['OS'] = $_SESSION['Consulta']['OS'];
							}
													
						}elseif($data['cadastrar']['Hidden_Caso'] == 2){
							//N-1 ou N-N, Uso a OS existente, ou Cadastro o Numero de Recorrencias de OS novas
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['OS'] = $data['query']['Recorrencias'];
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									//Pego a OS existente e uso para todas os agendamentos
									$data['query']['OS'] = 1;
									$data['query']['idApp_OrcaTrata'] = $data['consulta']['idApp_OrcaTrata'];
											
									if (count($data['consultas']) > 0) {
										$data['consultas'] = array_combine(range(1, count($data['consultas'])), array_values($data['consultas']));
										$max_consultas = count($data['consultas']);
										if (isset($data['consultas'])) {
											for($j=1; $j <= $max_consultas; $j++) {
												
												$data['consultas'][$j]['idApp_OrcaTrata'] 		= $data['query']['idApp_OrcaTrata'];
												
												$data['update']['consultas'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['consultas'][$j], $data['consultas'][$j]['idApp_Consulta']);
											}
										}
									}		
								}
							}else{
								//Não cadastro nenhuma OS
								$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
								$data['query']['OS'] = $_SESSION['Consulta']['OS'];
							}
						}elseif($data['cadastrar']['Hidden_Caso'] == 3){
							//N-1 ou N-N, Cadastro 1 ou N os novas
							if($data['cadastrar']['Adicionar'] == "S"){
								//Opções de cadastro de OS
								if($data['cadastrar']['PorConsulta'] == "S"){
									//cadastro o número de OS novas
									$data['query']['idApp_OrcaTrata'] = "0";
								}else{
									if($data['count_repet'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//cadastro 1 OS nova
											$data['query']['OS'] = "1";
											$data['query']['idApp_OrcaTrata'] = "0";
										}else{
											if($data['cadastrar']['Vincular'] == "S"){
												//Seleciona 1 OS e uso para todas os agendamentos
												$data['query']['OS'] = "1";	
												
												$data['orcatrata']['RepeticaoCons'] 	= $_SESSION['Consulta']['Repeticao'];
												$data['orcatrata']['idApp_ClientePet'] 	= $data['query']['idApp_ClientePet'];
												$data['orcatrata']['idApp_ClienteDep'] 	= $data['query']['idApp_ClienteDep'];
												$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['query']['idApp_OrcaTrata']);
												
												if (count($data['consultas']) > 0) {
													$data['consultas'] = array_combine(range(1, count($data['consultas'])), array_values($data['consultas']));
													$max_consultas = count($data['consultas']);
													if (isset($data['consultas'])) {
														for($j=1; $j <= $max_consultas; $j++) {
															
															$data['consultas'][$j]['idApp_OrcaTrata'] 		= $data['query']['idApp_OrcaTrata'];
															
															$data['update']['consultas'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['consultas'][$j], $data['consultas'][$j]['idApp_Consulta']);
														}
													}
												}
																					
											}else{
												//Não cadastro nenhuma OS
												$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
												$data['query']['OS'] = $_SESSION['Consulta']['OS'];
											}
										}
									}else{
										if($data['cadastrar']['Vincular'] == "S"){
											//Seleciona 1 OS e uso para todas os agendamentos
											$data['query']['OS'] = "1";	
											
											$data['orcatrata']['RepeticaoCons'] 	= $_SESSION['Consulta']['Repeticao'];
											$data['orcatrata']['idApp_ClientePet'] 	= $data['query']['idApp_ClientePet'];
											$data['orcatrata']['idApp_ClienteDep'] 	= $data['query']['idApp_ClienteDep'];
											$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['query']['idApp_OrcaTrata']);
											
											if (count($data['consultas']) > 0) {
												$data['consultas'] = array_combine(range(1, count($data['consultas'])), array_values($data['consultas']));
												$max_consultas = count($data['consultas']);
												if (isset($data['consultas'])) {
													for($j=1; $j <= $max_consultas; $j++) {
														
														$data['consultas'][$j]['idApp_OrcaTrata'] 		= $data['query']['idApp_OrcaTrata'];
														
														$data['update']['consultas'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['consultas'][$j], $data['consultas'][$j]['idApp_Consulta']);
													}
												}
											}
																				
										}else{
											//Não cadastro nenhuma OS
											$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
											$data['query']['OS'] = $_SESSION['Consulta']['OS'];
										}
									}
								}
							}else{
								//Não cadastro nemhuma OS nova
								$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
								$data['query']['OS'] = $_SESSION['Consulta']['OS'];
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 4){
							if($data['cadastrar']['Adicionar'] == "S"){		
								//N-1, Pego a OS existente e uso para todas os agendamentos
								$data['query']['OS'] = 1;
								$data['query']['idApp_OrcaTrata'] = $data['consulta']['idApp_OrcaTrata'];
								
								if (count($data['consultas']) > 0) {
									$data['consultas'] = array_combine(range(1, count($data['consultas'])), array_values($data['consultas']));
									$max_consultas = count($data['consultas']);
									if (isset($data['consultas'])) {
										for($j=1; $j <= $max_consultas; $j++) {
											
											$data['consultas'][$j]['idApp_OrcaTrata'] 		= $data['query']['idApp_OrcaTrata'];
											
											$data['update']['consultas'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['consultas'][$j], $data['consultas'][$j]['idApp_Consulta']);
										}
									}
								}
							}else{
								$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
								$data['query']['OS'] = $_SESSION['Consulta']['OS'];
							}
						}elseif($data['cadastrar']['Hidden_Caso'] == 5){
							
							$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
							$data['query']['OS'] = $_SESSION['Consulta']['OS'];
							
						}else{

						}
					}else{
						$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
						$data['query']['OS'] = $_SESSION['Consulta']['OS'];
					}
					
					$dataini_whats 	= $data['query']['Data'];
					$horaini_whats	= $data['query']['HoraInicio'];	
				
					unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
					
					$data['anterior'] = $this->Consulta_model->get_consulta($data['query']['idApp_Consulta']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);

					$data['update']['query']['bd'] = $this->Consulta_model->update_consulta($data['query'], $data['query']['idApp_Consulta']);
					
					#### Whatsapp ####
					if($data['cadastrar']['Whatsapp'] == 'S'){
						$data['Profissional'] 	= $this->Cliente_model->get_profissional($data['query']['idApp_Agenda'], TRUE);
						
						$_SESSION['bd_consulta']['Whatsapp'] 		= $data['cadastrar']['Whatsapp'];
						$_SESSION['bd_consulta']['NomeCliente'] 	= utf8_encode($_SESSION['Cliente']['NomeCliente']);
						$_SESSION['bd_consulta']['CelularCliente'] 	= $_SESSION['Cliente']['CelularCliente'];
						$_SESSION['bd_consulta']['Profissional'] 	= utf8_encode($data['Profissional']['Nome']);
						$_SESSION['bd_consulta']['DataInicio'] 		= $dataini_whats;
						$_SESSION['bd_consulta']['HoraInicio'] 		= $horaini_whats;
						
						unset($data['Profissional'], $dataini_whats, $horaini_whats);				
					}
					
					$data['update']['cliente_repeticao']['anterior'] = $this->Orcatrata_model->get_cliente($data['query']['idApp_Cliente']);
					
					if($data['query']['idApp_OrcaTrata'] != 0){
						
						$data['orca']['idApp_ClienteDep']	= $data['query']['idApp_ClienteDep'];
						$data['orca']['idApp_ClientePet']	= $data['query']['idApp_ClientePet'];
						
						################################ Comparo a quantidade de OS ##################################################################################################	
						############ antes eu comparava se as quantidades de connsultas e OS eram iguais "$data['repeticaocons'] == $data['repeticaoorca']". Agora verifico se a quandidade de OS é maior que 1 #########################
						if($data['repeticaocons'] == $data['repeticaoorca']){
							
							$data['orca']['DataOrca']			= $dataini_alt;
							$data['orca']['DataVencimentoOrca']	= $dataini_alt;
							$data['orca']['DataEntregaOrca']	= $dataini_alt;
							$data['orca']['HoraEntregaOrca']	= $horaini_alt;

							$data['update']['orca']['bd'] 	= $this->Orcatrata_model->update_orcatrata($data['orca'], $data['query']['idApp_OrcaTrata']);

							if(isset($data['query']['idApp_Cliente']) && $data['query']['idApp_Cliente'] !=0){

								#### Verificação do UltimoPedido ####
								if(strtotime($data['update']['cliente_repeticao']['anterior']['UltimoPedido']) < strtotime($data['orca']['DataOrca'])){
								
									$data['cliente_repeticao']['UltimoPedido'] 		= $data['orca']['DataOrca'];
									$data['cliente_repeticao']['id_UltimoPedido'] 	= $data['query']['idApp_OrcaTrata'];
									$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['query']['idApp_Cliente']);
									
								}else if(strtotime($data['update']['cliente_repeticao']['anterior']['UltimoPedido']) == strtotime($data['orca']['DataOrca'])){
									
									if($data['update']['cliente_repeticao']['anterior']['id_UltimoPedido'] < $data['query']['idApp_OrcaTrata']){
										
										$data['cliente_repeticao']['id_UltimoPedido'] = $data['query']['idApp_OrcaTrata'];
										$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['query']['idApp_Cliente']);
									
									}
									
								}else{
									
									if($data['update']['cliente_repeticao']['anterior']['id_UltimoPedido'] == $data['query']['idApp_OrcaTrata']){

										$data['get_ult_pdd_cliente'] = $this->Orcatrata_model->get_ult_pdd_cliente($data['query']['idApp_Cliente'], TRUE);
										$data['cliente_repeticao']['UltimoPedido'] = $data['get_ult_pdd_cliente']['DataOrca'];
										$data['cliente_repeticao']['id_UltimoPedido'] = $data['get_ult_pdd_cliente']['idApp_OrcaTrata'];
										$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['query']['idApp_Cliente']);
									}
									
								}				

							}					
							############################################### Comparo as OS. Seforem iguais, não altero as datas doas produtos e das parcelas ##########################
							
							#### App_Produto ####
							$data['update']['produto']['alterar'] = $this->Orcatrata_model->get_produto_alterar($data['query']['idApp_OrcaTrata']);
							if (isset($data['update']['produto']['alterar'])){

								$max = count($data['update']['produto']['alterar']);
								for($j=0;$j<$max;$j++) {
									$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $dataini_alt;
									$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] = $horaini_alt;

									$data['update']['produto']['bd'][$j] = $this->Orcatrata_model->update_produto_id($data['update']['produto']['alterar'][$j], $data['update']['produto']['alterar'][$j]['idApp_Produto']);
								
								}
							}

							#### App_Parcelas ####
							$data['update']['parcelas']['alterar'] = $this->Orcatrata_model->get_parcelas_alterar($data['query']['idApp_OrcaTrata']);
							if (isset($data['update']['parcelas']['alterar'])){

								$max = count($data['update']['parcelas']['alterar']);
								for($j=0;$j<$max;$j++) {
									$data['update']['parcelas']['alterar'][$j]['DataVencimento'] = $dataini_alt;

									$data['update']['parcelas']['bd'][$j] = $this->Orcatrata_model->update_parcelas_id($data['update']['parcelas']['alterar'][$j], $data['update']['parcelas']['alterar'][$j]['idApp_Parcelas']);
								
								}
							}
						}	
					}

					$_SESSION['Repeticao'] = $data['repeticao'] = $this->Consulta_model->get_consulta_posterior($data['query']['idApp_Consulta'], $_SESSION['Consulta']['Repeticao'], $data['alterar']['Quais'], $dataini_alt);

					if (count($data['repeticao']) > 0) {
						$data['repeticao'] = array_combine(range(1, count($data['repeticao'])), array_values($data['repeticao']));
						$max = count($data['repeticao']);
						if (isset($data['repeticao'])) {
							for($j=1; $j <= $max; $j++) {

								if($data['repeticao'][$j]['idApp_Consulta'] != $data['query']['idApp_Consulta']){
									//pego a data original, de cada linha, e somo a diferença
									$datainicial[$j] 								= explode(' ', $data['repeticao'][$j]['DataInicio']);
									$datafinal[$j] 									= explode(' ', $data['repeticao'][$j]['DataFim']);
									$dataoriginalinicio[$j] 						= $datainicial[$j][0];
									$dataoriginalfim[$j] 							= $datafinal[$j][0];
									$dataatualinicio[$j] 							= date('Y-m-d', strtotime($difinicio  .  'day',strtotime($dataoriginalinicio[$j])));
									$dataatualfim[$j] 								= date('Y-m-d', strtotime($diffim  .  'day',strtotime($dataoriginalfim[$j])));
									$data['repeticao'][$j]['DataInicio'] 			= $dataatualinicio[$j] . ' ' . $horaini_alt;
									$data['repeticao'][$j]['DataFim'] 				= $dataatualfim[$j] . ' ' . $horafim_alt;
									$data['repeticao'][$j]['Repeticao'] 			= $data['query']['Repeticao'];
									$data['repeticao'][$j]['idApp_Agenda'] 			= $data['query']['idApp_Agenda'];
									$data['repeticao'][$j]['idApp_Cliente'] 		= $data['query']['idApp_Cliente'];
									$data['repeticao'][$j]['idApp_ClienteDep'] 		= $data['query']['idApp_ClienteDep'];
									$data['repeticao'][$j]['idApp_ClientePet'] 		= $data['query']['idApp_ClientePet'];
									$data['repeticao'][$j]['Obs'] 					= $data['query']['Obs'];
									$data['repeticao'][$j]['idTab_Status'] 			= $data['query']['idTab_Status'];
									$data['repeticao'][$j]['idTab_TipoConsulta'] 	= $data['query']['idTab_TipoConsulta'];
									
									$data['update']['repeticao'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['repeticao'][$j], $data['repeticao'][$j]['idApp_Consulta']);
									
									if(($data['repeticao'][$j]['idApp_OrcaTrata'] != 0) && ($data['repeticao'][$j]['idApp_OrcaTrata'] != $data['query']['idApp_OrcaTrata'])){
										
										$data['orca']['idApp_ClienteDep'] 	= $data['query']['idApp_ClienteDep'];
										$data['orca']['idApp_ClientePet'] 	= $data['query']['idApp_ClientePet'];
										
										##################################  compara as OS. SeForem iguais, não altero as datas dos produtos e das parcelas ##########################
										############ antes eu comparava se as quantidades de connsultas e OS eram iguais "$data['repeticaocons'] == $data['repeticaoorca']". Agora verifico se a quandidade de OS é maior que 1 #########################
										
										if($data['repeticaoorca'] > 1){
											
											$data['orca']['DataOrca'] 			= $dataatualinicio[$j];
											$data['orca']['DataVencimentoOrca'] = $dataatualinicio[$j];
											$data['orca']['DataEntregaOrca'] 	= $dataatualinicio[$j];
											$data['orca']['HoraEntregaOrca'] 	= $horaini_alt;
										
											//$data['update']['orca']['bd'] 		= $this->Orcatrata_model->update_orcatrata($data['orca'], $data['repeticao'][$j]['idApp_OrcaTrata']);

											#### Verificação do UltimoPedido ####
											
											if(strtotime($data['update']['cliente_repeticao']['anterior']['UltimoPedido']) < strtotime($data['orca']['DataOrca'])){

												$data['cliente_repeticao']['UltimoPedido'] 		= $data['orca']['DataOrca'];
												$data['cliente_repeticao']['id_UltimoPedido'] 	= $data['repeticao'][$j]['idApp_OrcaTrata'];
												$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['query']['idApp_Cliente']);
												
											}else if(strtotime($data['update']['cliente_repeticao']['anterior']['UltimoPedido']) == strtotime($data['orca']['DataOrca'])){

												if($data['update']['cliente_repeticao']['anterior']['id_UltimoPedido'] < $data['repeticao'][$j]['idApp_OrcaTrata']){
													
													$data['cliente_repeticao']['id_UltimoPedido'] = $data['repeticao'][$j]['idApp_OrcaTrata'];
													$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['query']['idApp_Cliente']);
												
												}else{
													
												}
												
											}else{
													
													
												if($data['update']['cliente_repeticao']['anterior']['id_UltimoPedido'] == $data['repeticao'][$j]['idApp_OrcaTrata']){
													
													$data['get_ult_pdd_cliente'] = $this->Orcatrata_model->get_ult_pdd_cliente($data['query']['idApp_Cliente'], TRUE);
													$data['cliente_repeticao']['UltimoPedido'] 		= $data['get_ult_pdd_cliente']['DataOrca'];
													$data['cliente_repeticao']['id_UltimoPedido'] 	= $data['get_ult_pdd_cliente']['idApp_OrcaTrata'];
													$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['query']['idApp_Cliente']);
												}else{
													
												}
												
											}
											##################################  compara as OS. SeForem iguais, não altero as datas dos produtos e das parcelas ##########################
											
											#### App_Produto ####
											$data['update']['produto']['posterior'][$j] = $this->Orcatrata_model->get_produto_alterar($data['repeticao'][$j]['idApp_OrcaTrata']);
											if (isset($data['update']['produto']['posterior'][$j])){
												
												$max_produto = count($data['update']['produto']['posterior'][$j]);
												
												for($k=0;$k<$max_produto;$k++) {
													
													$data['update']['produto']['posterior'][$j][$k]['DataConcluidoProduto'] = $dataatualinicio[$j];
													$data['update']['produto']['posterior'][$j][$k]['HoraConcluidoProduto'] = $horaini_alt;
													
													$data['update']['produto']['bd']['posterior'][$j][$k] = $this->Orcatrata_model->update_produto_id($data['update']['produto']['posterior'][$j][$k], $data['update']['produto']['posterior'][$j][$k]['idApp_Produto']);

												}
												
											}							

											#### App_Parcelas ####
											$data['update']['parcelas']['posterior'][$j] = $this->Orcatrata_model->get_parcelas_alterar($data['repeticao'][$j]['idApp_OrcaTrata']);
											if (isset($data['update']['parcelas']['posterior'][$j])){
												
												$max_parcelas = count($data['update']['parcelas']['posterior'][$j]);
												
												for($k=0;$k<$max_parcelas;$k++) {
													
													$data['update']['parcelas']['posterior'][$j][$k]['DataVencimento'] = $dataatualinicio[$j];
													
													$data['update']['parcelas']['bd']['posterior'][$j][$k] = $this->Orcatrata_model->update_parcelas_id($data['update']['parcelas']['posterior'][$j][$k], $data['update']['parcelas']['posterior'][$j][$k]['idApp_Parcelas']);

												}
												
											}							
										}
										$data['update']['orca']['bd'] 		= $this->Orcatrata_model->update_orcatrata($data['orca'], $data['repeticao'][$j]['idApp_OrcaTrata']);
									}
								}
							}
						}				
					}

					$data['cons_datatermino'] = $this->Consulta_model->get_consulta_datatermino($_SESSION['Consulta']['Repeticao']);
					$data['data_termino'] = $data['cons_datatermino']['DataInicio'];

					if(strtotime($data['data_termino']) != strtotime($_SESSION['dataTermino'])){

						$data['update']['cons_posts'] = $this->Consulta_model->get_consultas($_SESSION['Consulta']['Repeticao']);
						$cont_cons_posts = count($data['update']['cons_posts']);
						
						if(isset($cont_cons_posts)){
							
							for($j=0;$j<$cont_cons_posts;$j++) {
								$data['update']['cons_posts'][$j]['DataTermino'] = $data['data_termino'];
								$data['update']['cons_posts']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_posts'][$j], $data['update']['cons_posts'][$j]['idApp_Consulta']);
							}
						}							
					}

					if ($data['auditoriaitem'] === FALSE) {
						$data['msg'] = '';
					} else {
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';
					}

					if(!isset($data['query']['idApp_OrcaTrata']) || (isset($data['query']['idApp_OrcaTrata']) && $data['query']['idApp_OrcaTrata'] == 0) || $data['query']['idApp_OrcaTrata'] == ""){
						
						
						if($data['cadastrar']['Hidden_Caso'] == 0){
							
							if($data['cadastrar']['Adicionar'] == "S"){	
								if($data['cadastrar']['PorConsulta'] == "S"){
									//Gera O.S. Replicadas pelo número de ocorrências
									redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
									exit();
								}else{
									if($data['count_repet'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//Gera uma única O.S.
											redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
											exit();
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}else{
										//Não Gera O.S. 
										redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
										exit();
									}
								}
							}else{
								//Não Gera O.S. 
								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
								exit();
							}

						}elseif($data['cadastrar']['Hidden_Caso'] == 1){
							
							if($data['cadastrar']['Adicionar'] == "S"){	
								if($data['cadastrar']['PorConsulta'] == "S"){
									//Gera O.S. Replicadas pelo número de ocorrências
									redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
									exit();
								}else{
									if($data['count_repet'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//Gera uma única O.S.
											redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
											exit();
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									
									}else{
										//Não Gera O.S. 
										redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
										exit();
									}
								}
							}else{
								//Não Gera O.S. 
								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
								exit();
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 2){
							
							if($data['cadastrar']['Adicionar'] == "S"){	
								if($data['cadastrar']['PorConsulta'] == "S"){
									//Gera O.S. Replicadas pelo número de ocorrências
									redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
									exit();
								}else{
									//Não Gera O.S. 
									redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
									exit();
								}
							}else{
								//Não Gera O.S. 
								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
								exit();
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 3){
							
							if($data['cadastrar']['Adicionar'] == "S"){	
								if($data['cadastrar']['PorConsulta'] == "S"){
									//Gera O.S. Replicadas pelo número de ocorrências
									redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
									exit();
								}else{
									if($data['count_repet'] > 1){
										if($data['cadastrar']['NovaOS'] == "S"){
											//Gera uma única O.S.
											redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
											exit();
										}else{
											//Não Gera O.S. 
											redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
											exit();
										}
									}else{
										//Não Gera O.S. 
										redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
										exit();
									}
								}
							}else{
								//Não Gera O.S. 
								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
								exit();
							}
							
						}elseif($data['cadastrar']['Hidden_Caso'] == 4){
							if($data['cadastrar']['Adicionar'] == "S"){	
								//Pego a OS e repasso para todos os agendamentos
								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
								exit();
							}else{
								//Não Gera O.S. 
								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
								exit();
							}
						}elseif($data['cadastrar']['Hidden_Caso'] == 5){
							if($data['cadastrar']['Adicionar'] == "S"){	
								//Gera O.S. Replicadas pelo número de Recorrências
								redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
								exit();
							}else{
								//Não Gera O.S. 
								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
								exit();
							}
						}else{

						}
					}else{
						//Não Gera O.S.
						unset($_SESSION['Agenda'], $_SESSION['Cliente'], $_SESSION['Consulta'], $_SESSION['Consultas_Repet'], $_SESSION['Repeticao']);
						redirect(base_url() . 'orcatrata/alterar/' . $data['query']['idApp_OrcaTrata'] . $data['msg']);
					}
				}	
				exit();
			}
		}
        $this->load->view('basico/footer');
    }

    public function alterar2($idApp_Cliente = NULL, $idApp_Consulta = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
		
		$data['alterar'] = quotes_to_entities($this->input->post(array(
			'Quais',
        ), TRUE));

        $data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
            'idApp_ClienteDep',
            'idApp_ClientePet',
            'Data',
            'Data2',
			'HoraInicio',
            'HoraFim',
            'idTab_Status',
            'Paciente',
            //'idApp_ContatoCliente',
            //'idApp_Profissional',
            'Procedimento',
            'Obs',
			'idTab_TipoConsulta',
                ), TRUE);

 		(!$data['alterar']['Quais']) ? $data['alterar']['Quais'] = 1 : FALSE;

		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
			$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
			#$data['resumo'] = $this->Cliente_model->get_cliente($idApp_Cliente);
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 30) ? substr($data['resumo']['NomeCliente'], 0, 30) : $data['resumo']['NomeCliente'];
		}
		
        if ($idApp_Consulta) {
            $_SESSION['Consulta'] = $data['query'] = $this->Consulta_model->get_consulta($idApp_Consulta);
            $_SESSION['Consulta']['DataTermino'] = $this->basico->mascara_data($_SESSION['Consulta']['DataTermino'], 'barras');
            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);
            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['Data2'] = $this->basico->mascara_data($datafim[0], 'barras');
			$data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
			$_SESSION['Consulta']['DataInicio'] = $dataini[0];
            $_SESSION['Consulta']['DataFim'] = $datafim[0];
        }
        else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
        }


        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            #$data['readonly'] = 'readonly';
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }

		$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
		$data1 = $data1->format('Y-m-d');       
		$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
		$data2 = $data2->format('Y-m-d');	
		
        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';
	
        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
        $data['select']['idApp_ClienteDep'] = $this->Cliente_model->select_clientedep($_SESSION['Cliente']['idApp_Cliente']);
        $data['select']['idApp_ClientePet'] = $this->Cliente_model->select_clientepet($_SESSION['Cliente']['idApp_Cliente']);	
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa4();
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );		
		$data['select']['Quais'] = array (
            '1' => 'Apenas Este',
            '2' => 'Este e os Anteriores',
			'3' => 'Este e os Posteriores',
			'4' => 'Todas',
        );

		if ($_SESSION['log']['idSis_Empresa'] == 5) {
			$data['resumo1'] = $this->Agenda_model->get_agenda($data['query']['idApp_Agenda']);
			$_SESSION['Agenda']['Nome'] = (strlen($data['resumo1']['Nome']) > 30) ? substr($data['resumo1']['Nome'], 0, 30) : $data['resumo1']['Nome'];
			$_SESSION['Agenda']['NomeEmpresa'] = (strlen($data['resumo1']['NomeEmpresa']) > 30) ? substr($data['resumo1']['NomeEmpresa'], 0, 30) : $data['resumo1']['NomeEmpresa'];
		}

        $data['titulo'] = 'Editar Agendamento';
        $data['form_open_path'] = 'consulta/alterar2';
        #$data['readonly'] = '';
        #$data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['alterarcliente'] = 2;

 		//(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);


        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_date|valid_periodo_data[' . $data['query']['Data'] . ']');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        if(strtotime($data2) == strtotime($data1)){
			$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		}else{
			$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
		}
		$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');	
        /*
		if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');
		*/
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');			
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            if ($_SESSION['log']['idSis_Empresa'] == 5) {
				$this->load->view('consulta/form_consulta0', $data);
			} else {
				$this->load->view('consulta/form_consulta', $data);
			}	
        } else {
			if($_SESSION['Consulta']['idApp_Cliente'] != $data['query']['idApp_Cliente']){
				$data['query']['Repeticao'] = $data['query']['idApp_Consulta'];
			}else{
				$data['query']['Repeticao'] = $_SESSION['Consulta']['Repeticao'];
			}
			if($_SESSION['Empresa']['CadastrarDep'] == "N"){
				$data['query']['idApp_ClienteDep'] = 0;
			}else{
				if($data['query']['idApp_ClienteDep'] == ''){
					$data['query']['idApp_ClienteDep'] = 0;
				}
			}
			if($_SESSION['Empresa']['CadastrarPet'] == "N"){
				$data['query']['idApp_ClientePet'] = 0;
			}else{
				if($data['query']['idApp_ClientePet'] == ''){
					$data['query']['idApp_ClientePet'] = 0;
				}
			}
            $data['query']['Tipo'] = 2;
			$data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            #$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
			$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            //exit();
            
			$dataanteriorinicio = strtotime($_SESSION['Consulta']['DataInicio']);
			$dataanteriorfim = strtotime($_SESSION['Consulta']['DataFim']);
			
			$dataposteriorinicio = strtotime($data1);
			$dataposteriorfim = strtotime($data2);
			
			$diferencainicio = ($dataposteriorinicio - $dataanteriorinicio)/86400;
			$diferencafim = ($dataposteriorfim - $dataanteriorfim)/86400;
			
			if($diferencainicio < 0){
				$difinicio = $diferencainicio;
			}else{
				$difinicio = '+' . $diferencainicio;
			}
			
			if($diferencafim < 0){
				$diffim = $diferencafim;
			}else{
				$diffim = '+' . $diferencafim;
			}
			
			$dataini_alt 	= $this->basico->mascara_data($data['query']['Data'], 'mysql');
			$datafim_alt 	= $this->basico->mascara_data($data['query']['Data2'], 'mysql');
			$horaini_alt 	= $data['query']['HoraInicio'];
			$horafim_alt 	= $data['query']['HoraFim'];
			
            #unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			
            $data['anterior'] = $this->Consulta_model->get_consulta($data['query']['idApp_Consulta']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);

			$data['update']['query']['bd'] = $this->Consulta_model->update_consulta($data['query'], $data['query']['idApp_Consulta']);
			
			$_SESSION['Repeticao'] = $data['repeticao'] = $this->Consulta_model->get_consulta_posterior($data['query']['idApp_Consulta'], $_SESSION['Consulta']['Repeticao'], $data['alterar']['Quais'], $dataini_alt);
			
			if (count($data['repeticao']) > 0) {
				$data['repeticao'] = array_combine(range(1, count($data['repeticao'])), array_values($data['repeticao']));
                $max = count($data['repeticao']);
				if (isset($data['repeticao'])) {
					for($j=1; $j <= $max; $j++) {
						//pego a data original, de cada linha, e somo a diferença
						$datainicial[$j] 								= explode(' ', $data['repeticao'][$j]['DataInicio']);
						$datafinal[$j] 									= explode(' ', $data['repeticao'][$j]['DataFim']);
						$dataoriginalinicio[$j] 						= $datainicial[$j][0];
						$dataoriginalfim[$j] 							= $datafinal[$j][0];
						$dataatualinicio[$j] 							= date('Y-m-d', strtotime($difinicio  .  'day',strtotime($dataoriginalinicio[$j])));
						$dataatualfim[$j] 								= date('Y-m-d', strtotime($diffim  .  'day',strtotime($dataoriginalfim[$j])));
						if($data['repeticao'][$j]['idApp_Consulta'] != $data['query']['idApp_Consulta']){
							$data['repeticao'][$j]['DataInicio'] 		= $dataatualinicio[$j] . ' ' . $horaini_alt;
							$data['repeticao'][$j]['DataFim'] 			= $dataatualfim[$j] . ' ' . $horafim_alt;
						}
						$data['repeticao'][$j]['idApp_Agenda'] 			= $data['query']['idApp_Agenda'];
						$data['repeticao'][$j]['idApp_Cliente'] 		= $data['query']['idApp_Cliente'];
						$data['repeticao'][$j]['idApp_ClienteDep'] 		= $data['query']['idApp_ClienteDep'];
						$data['repeticao'][$j]['idApp_ClientePet'] 		= $data['query']['idApp_ClientePet'];
						$data['repeticao'][$j]['Obs'] 					= $data['query']['Obs'];
						//$data['repeticao'][$j]['idApp_Profissional'] 	= $data['query']['idApp_Profissional'];
						$data['repeticao'][$j]['idTab_Status'] 			= $data['query']['idTab_Status'];
						$data['repeticao'][$j]['idTab_TipoConsulta'] 	= $data['query']['idTab_TipoConsulta'];
						
						$data['update']['repeticao'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['repeticao'][$j], $data['repeticao'][$j]['idApp_Consulta']);
					}
				}
			}			
			
			unset($_SESSION['Agenda'], $_SESSION['Cliente'], $_SESSION['Consulta'], $_SESSION['Repeticao']);			
			
            if ($data['auditoriaitem'] && $data['update']['query']['bd'] === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
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
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
		}
		
		$data['titulo'] = 'Agenda : ';
        $data['panel'] = 'primary';
        $data['novo'] = '';
        $data['metodo'] = 4;

        $data['query'] = array();
        $data['proxima'] = $this->Consulta_model->lista_consulta_proxima($idApp_Cliente);
        $data['anterior'] = $this->Consulta_model->lista_consulta_anterior($idApp_Cliente);

        #$data['tela'] = $this->load->view('consulta/list_consulta', $data, TRUE);
        #$data['resumo'] = $this->Cliente_model->get_cliente($data['Cliente']['idApp_Cliente']);
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('consulta/list_consulta', $data);

        $this->load->view('basico/footer');
    }

    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['alterar'] = quotes_to_entities($this->input->post(array(
			'Quais_Excluir',
			'DeletarOS',
        ), TRUE));
		
		$quais = $data['alterar']['Quais_Excluir'];	
		$deletaros = $data['alterar']['DeletarOS'];
		
		if (!$id) {
            $data['msg'] = '?m=2';
            redirect(base_url() . 'agenda' . $data['msg']);
        } else {

			$data['anterior'] = $this->Consulta_model->get_consulta($id);
			
			$repeticao = $data['anterior']['Repeticao'];
			$dataini = $data['anterior']['DataInicio'];
			/*
				echo '<br>';
			  echo "<pre>";
			  //print_r('ido riginal = ' . $id);
			  echo '<br>';
			  //print_r($_SESSION['Repeticao'][$j]['idApp_OrcaTrata']);
			  echo '<br>';
			  print_r('$deletaros = ' . $deletaros);
			  echo "</pre>";
			exit();
			*/
			$_SESSION['Repeticao'] 	= $this->Consulta_model->get_consulta_repeticao($id, $repeticao, $quais, $dataini);

			$count_delete_orca		= count($_SESSION['Repeticao']);
            $data['campos'] = array_keys($data['anterior']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['anterior']['idApp_Consulta'], FALSE, TRUE);
            $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'DELETE', $data['auditoriaitem']);

			$data['delete']['consulta'] = $this->Consulta_model->delete_consulta($id, $repeticao, $quais, $dataini);

			if($deletaros == "S"){
				if($count_delete_orca > 0){
					for($j=0; $j < $count_delete_orca; $j++) {
						if($_SESSION['Repeticao'][$j]['idApp_OrcaTrata'] != 0){
							$_SESSION['Consultas_Zero'][$j] = $this->Consulta_model->get_consultas_zero($_SESSION['Repeticao'][$j]['idApp_OrcaTrata']);
							$data['count_zero'][$j]	= count($_SESSION['Consultas_Zero'][$j]);
							if($data['count_zero'][$j] == 0){
								$data['delete_orcatrata'][$j] = $this->Orcatrata_model->delete_orcatrata($_SESSION['Repeticao'][$j]['idApp_OrcaTrata']);
							}
						}
					}

					$data['update']['orcamentos'] = $this->Orcatrata_model->get_repeticaoorca($repeticao);// pega as OS que tem essa repeticao
					$cont_orcamentos = count($data['update']['orcamentos']);// conta quantas OS tem essa repeticao					
					if(isset($cont_orcamentos) && $cont_orcamentos > 0){
					
						for($j=0;$j<$cont_orcamentos;$j++) {
							$k = (1 + $j);
							$data['update']['orcamentos'][$j]['RecorrenciasOrca'] = $cont_orcamentos;
							$data['update']['orcamentos'][$j]['RecorrenciaOrca'] = $k . "/" . $cont_orcamentos;

							$data['update']['orcamentos']['bd'][$j] = $this->Orcatrata_model->update_orcatrata($data['update']['orcamentos'][$j], $data['update']['orcamentos'][$j]['idApp_OrcaTrata']);
						}
					}
				}
			}
	
			$data['cons_datatermino'] = $this->Consulta_model->get_consulta_datatermino($repeticao);
			if(isset($data['cons_datatermino'])){
				$data['data_termino'] = $data['cons_datatermino']['DataInicio'];
			}else{
				$data['data_termino'] = "0000-00-00";
			}
			$data['update']['cons_posts'] = $this->Consulta_model->get_consultas($repeticao);
			$cont_cons_posts = count($data['update']['cons_posts']);
			
			if(isset($cont_cons_posts) && $cont_cons_posts > 0){
				
				for($j=0;$j<$cont_cons_posts;$j++) {
					$k = (1 + $j);
					$data['update']['cons_posts'][$j]['DataTermino'] = $data['data_termino'];
					$data['update']['cons_posts'][$j]['Recorrencias'] = $cont_cons_posts;
					$data['update']['cons_posts'][$j]['Recorrencia'] = $k . "/" . $cont_cons_posts;
					$data['update']['cons_posts']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_posts'][$j], $data['update']['cons_posts'][$j]['idApp_Consulta']);
				}
			}	

			$data['msg'] = '?m=1';
			redirect(base_url() . 'agenda' . $data['msg']);
			exit();
        }

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
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar o novo Agendamento.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Repetir',
			'Prazo',
			'DataMinima',
			'Hidden_status',
			'Extra',
        ), TRUE));
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'idSis_Usuario',
			//'idApp_Consulta',
			'idApp_Agenda',
			'Data',
			'Data2',
			'HoraInicio',
			'HoraFim',
			'Evento',
			'Obs',
			'idTab_Status',
			'Intervalo',
			'Periodo',
			'Tempo',
			'Tempo2',
			'DataTermino',
			'Recorrencias',
			'Recorrencia',
            'Repeticao',
		), TRUE));
		
 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'N' : FALSE;
 		(!$data['cadastrar']['Repetir']) ? $data['cadastrar']['Repetir'] = 'N' : FALSE;
 		(!$data['cadastrar']['Extra']) ? $data['cadastrar']['Extra'] = 'N' : FALSE;
		//(!$data['query']['Intervalo']) ? $data['query']['Intervalo'] = '1' : FALSE;
		//(!$data['query']['Periodo']) ? $data['query']['Periodo'] = '1' : FALSE;
		(!$data['query']['Recorrencias']) ? $data['query']['Recorrencias'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo2'] = '1' : FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] != 5){
			(!$data['query']['idApp_Agenda']) ? $data['query']['idApp_Agenda'] = $_SESSION['log']['Agenda'] : FALSE;
		}
		
        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
            $data['query']['Data2'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
			$data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }

		//$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		#$data['select']['idSis_EmpresaFilial'] = $this->Empresafilial_model->select_empresafilial();
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
		$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Repetir'] = $this->Basico_model->select_status_sn(); 
		$data['select']['Extra'] = $this->Basico_model->select_status_sn();       
		$data['select']['Tempo'] = array (
            '1' => 'Dia(s)',
            '2' => 'Semana(s)',
            '3' => 'Mês(s)',
			'4' => 'Ano(s)',
        );
        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

		$data['titulo'] = 'Evento';
        $data['form_open_path'] = 'consulta/cadastrar_evento';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['evento'] = 1;
		
        $data['readonly'] = '';
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'S') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		

		$data['radio'] = array(
            'Repetir' => $this->basico->radio_checked($data['cadastrar']['Repetir'], 'Repetir', 'NS'),
        );
        ($data['cadastrar']['Repetir'] == 'S') ?
            $data['div']['Repetir'] = '' : $data['div']['Repetir'] = 'style="display: none;"';

		$data['radio'] = array(
            'Extra' => $this->basico->radio_checked($data['cadastrar']['Extra'], 'Extra', 'NS'),
        );
        ($data['cadastrar']['Extra'] == 'S') ?
            $data['div']['Extra'] = '' : $data['div']['Extra'] = 'style="display: none;"';
					
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		if ($data['cadastrar']['Extra'] == 'S') {
			$this->form_validation->set_rules('Repeticao', 'Repeticao', 'required|trim');
		}		
		$this->form_validation->set_rules('Prazo', 'Prazo', 'trim|valid_prazo');
        $this->form_validation->set_rules('Data', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_date|valid_periodo_data[' . $data['query']['Data'] . ']');

		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');
        
		if ($data['cadastrar']['Repetir'] == 'S') {
			$this->form_validation->set_rules('Intervalo', 'Intervalo', 'required|trim|valid_intervalo');
			$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo');
			//$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo|valid_periodo_intervalo[' . $data['query']['Intervalo'] . ']');
			$this->form_validation->set_rules('Tempo', 'Tempo', 'required|trim');
			$this->form_validation->set_rules('Tempo', 'Tempo2', 'required|trim');
			$this->form_validation->set_rules('DataMinima', 'Data Mínima:', 'trim|valid_date');
			$this->form_validation->set_rules('DataTermino', 'Termina em:', 'required|trim|valid_date|valid_data_termino[' . $data['cadastrar']['DataMinima'] . ']|valid_data_termino2[' . $data['query']['Data'] . ']');
		}
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_evento', $data);
        } else {
		
			$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
			$data1 = $data1->format('Y-m-d');       
			
			$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
			$data2 = $data2->format('Y-m-d');    
				

			$this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_periodo_data[' . $data['query']['Data'] . ']');			
			$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
			
			if(strtotime($data2) == strtotime($data1)){
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
			}else{
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
			}			
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('consulta/form_evento', $data);
			
			} else {

				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'consulta/cadastrar_evento' . $data['msg']);
					
				} else {

					$dataini_cad 	= $this->basico->mascara_data($data['query']['Data'], 'mysql');
					$datafim_cad 	= $this->basico->mascara_data($data['query']['Data2'], 'mysql');
					$horaini_cad 	= $data['query']['HoraInicio'];
					$horafim_cad 	= $data['query']['HoraFim'];
					
					if ($data['cadastrar']['Repetir'] == 'N') {
						$data['query']['Intervalo'] = 0;
						$data['query']['Periodo'] = 0;
						$data['query']['Tempo'] = 0;
						$data['query']['Tempo2'] = 0;
						$data['query']['DataTermino'] = $dataini_cad;
					}else{
						
						$tipointervalo = $data['query']['Tempo'];
						if($tipointervalo == 1){
							$semana = 1;
							$ref = "day";
						}elseif($tipointervalo == 2){
							$semana = 7;
							$ref = "day";
						}elseif($tipointervalo == 3){
							$semana = 1;
							$ref = "month";
						}elseif($tipointervalo == 4){
							$semana = 1;
							$ref = "Year";
						}
						
						$n = $data['query']['Intervalo']; //intervalo - a cada tantos dias
						$qtd = $data['query']['Recorrencias'];
						$data['query']['DataTermino'] = $this->basico->mascara_data($data['query']['DataTermino'], 'mysql');				
						
					}

					$data['query']['Tipo'] = 1;
					$data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
					$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
					//$data['query']['idTab_Status'] = 1;
					$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

					if($data['cadastrar']['Extra'] == 'N'){
						$data['query']['Repeticao'] = 0;
					}
					
					$data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
					
					unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
					
					$data['campos'] = array_keys($data['query']);
					$data['anterior'] = array();
					$data['query']['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

					if ($data['query']['idApp_Consulta'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('consulta/form_evento', $data);
					} else {
						
						if($data['cadastrar']['Extra'] == 'S'){
							$data['copiar']['Repeticao'] = $data['query']['Repeticao'];
						}else{
							$data['copiar']['Repeticao'] = $data['query']['idApp_Consulta'];
						}
						
						if($data['cadastrar']['Repetir'] == 'S'){
							//$data['copiar']['DataTermino'] = $ultimaocorrencia;
							$data['copiar']['DataTermino'] = $data['query']['DataTermino'];
							$data['copiar']['Recorrencia'] = "1/" . $qtd;
						}else{
							$data['copiar']['Recorrencia'] = "1/1";
							//$data['copiar']['DataTermino'] = $dataini_cad;
						}
						
						$data['update']['copiar']['bd'] = $this->Consulta_model->update_consulta($data['copiar'], $data['query']['idApp_Consulta']);
						
						if ($data['update']['copiar']['bd'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('consulta/form_evento', $data);
						} else {
							if ($data['cadastrar']['Repetir'] == 'S') {
								for($j=1; $j<$qtd; $j++) {
									$data['repeticao'][$j] = array(
										//'Repeticao' 			=> $data['query']['idApp_Consulta'],
										'Repeticao' 			=> $data['copiar']['Repeticao'],
										'Intervalo' 			=> $data['query']['Intervalo'],
										'Periodo' 				=> $data['query']['Periodo'],
										'Tempo' 				=> $data['query']['Tempo'],
										'Tempo2' 				=> $data['query']['Tempo2'],
										//'DataTermino' 			=> $ultimaocorrencia,
										'DataTermino' 			=> $data['query']['DataTermino'],
										'Recorrencias' 			=> $data['query']['Recorrencias'],
										'Recorrencia' 			=> ($j + 1) .  '/' . $data['query']['Recorrencias'],
										'idApp_Agenda' 			=> $data['query']['idApp_Agenda'],
										//'idApp_Cliente' 		=> $data['query']['idApp_Cliente'],
										'Evento' 				=> $data['query']['Evento'],
										'Obs' 					=> $data['query']['Obs'],
										//'idApp_Profissional' 	=> $data['query']['idApp_Profissional'],
										'idTab_Status' 			=> $data['query']['idTab_Status'],
										'Tipo' 					=> $data['query']['Tipo'],
										'DataInicio' 			=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) .  $ref,strtotime($dataini_cad))) . ' ' . $horaini_cad,
										'DataFim' 				=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) . $ref,strtotime($datafim_cad))) . ' ' . $horafim_cad,
										'idSis_Usuario' 		=> $_SESSION['log']['idSis_Usuario'],
										'idSis_Empresa' 		=> $_SESSION['log']['idSis_Empresa'],
										'idTab_Modulo' 			=> $_SESSION['log']['idTab_Modulo']
									);
									$data['campos'] = array_keys($data['repeticao'][$j]);
									$data['id_Repeticao'] = $this->Consulta_model->set_consulta($data['repeticao'][$j]);
								}
						
							}
								
							if($data['cadastrar']['Extra'] == 'S'){
								$data['update']['cons_posts'] = $this->Consulta_model->get_consultas($data['query']['Repeticao']);
								$cont_cons_posts = count($data['update']['cons_posts']);
								
								if(isset($cont_cons_posts)){
									
									for($j=0;$j<$cont_cons_posts;$j++) {
										$k = (1 + $j);
										$data['update']['cons_posts'][$j]['Recorrencias'] = $cont_cons_posts;
										$data['update']['cons_posts'][$j]['Recorrencia'] = $k . "/" . $cont_cons_posts;

										$data['update']['cons_posts']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_posts'][$j], $data['update']['cons_posts'][$j]['idApp_Consulta']);
									}
								}
							}
								
							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], FALSE);
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
							
							redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
							exit();
						}	
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function cadastrar_evento_extra($repeticao_extra = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar o novo Agendamento.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Repetir',
			'Prazo',
			'DataMinima',
			'Hidden_status',
			'Extra',
        ), TRUE));
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'idSis_Usuario',
			//'idApp_Consulta',
			'idApp_Agenda',
			'Data',
			'Data2',
			'HoraInicio',
			'HoraFim',
			'Evento',
			'Obs',
			'idTab_Status',
			'Intervalo',
			'Periodo',
			'Tempo',
			'Tempo2',
			'DataTermino',
			'Recorrencias',
			'Recorrencia',
		), TRUE));
		
 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'N' : FALSE;
 		(!$data['cadastrar']['Repetir']) ? $data['cadastrar']['Repetir'] = 'N' : FALSE;
 		(!$data['cadastrar']['Extra']) ? $data['cadastrar']['Extra'] = 'S' : FALSE;
		(!$data['query']['Recorrencias']) ? $data['query']['Recorrencias'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo2'] = '1' : FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] != 5){
			(!$data['query']['idApp_Agenda']) ? $data['query']['idApp_Agenda'] = $_SESSION['log']['Agenda'] : FALSE;
		}
		
        if ($repeticao_extra) {
            $_SESSION['Consulta'] = $this->Consulta_model->get_repeticao($repeticao_extra); //pego os dados dessa repetição
			$_SESSION['Consulta']['DataTermino'] = $this->basico->mascara_data($_SESSION['Consulta']['DataTermino'], 'barras');
		}
		
		$data['query']['Repeticao'] = $_SESSION['Consulta']['Repeticao'];
				
        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
            $data['query']['Data2'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
			$data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }

		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
		$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Repetir'] = $this->Basico_model->select_status_sn(); 
		$data['select']['Extra'] = $this->Basico_model->select_status_sn();       
		$data['select']['Tempo'] = array (
            '1' => 'Dia(s)',
            '2' => 'Semana(s)',
            '3' => 'Mês(s)',
			'4' => 'Ano(s)',
        );
        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

		$data['titulo'] = 'Evento';
        $data['form_open_path'] = 'consulta/cadastrar_evento_extra';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['evento'] = 1;
		$data['extra'] = 'S';
		
        $data['readonly'] = '';
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'S') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		

		$data['radio'] = array(
            'Repetir' => $this->basico->radio_checked($data['cadastrar']['Repetir'], 'Repetir', 'NS'),
        );
        ($data['cadastrar']['Repetir'] == 'S') ?
            $data['div']['Repetir'] = '' : $data['div']['Repetir'] = 'style="display: none;"';

		$data['radio'] = array(
            'Extra' => $this->basico->radio_checked($data['cadastrar']['Extra'], 'Extra', 'NS'),
        );
        ($data['cadastrar']['Extra'] == 'S') ?
            $data['div']['Extra'] = '' : $data['div']['Extra'] = 'style="display: none;"';
					
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
		$this->form_validation->set_rules('Prazo', 'Prazo', 'trim|valid_prazo');
        $this->form_validation->set_rules('Data', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_date|valid_periodo_data[' . $data['query']['Data'] . ']');

		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');
        
		if ($data['cadastrar']['Repetir'] == 'S') {
			$this->form_validation->set_rules('Intervalo', 'Intervalo', 'required|trim|valid_intervalo');
			$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo');
			//$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo|valid_periodo_intervalo[' . $data['query']['Intervalo'] . ']');
			$this->form_validation->set_rules('Tempo', 'Tempo', 'required|trim');
			$this->form_validation->set_rules('Tempo', 'Tempo2', 'required|trim');
			$this->form_validation->set_rules('DataMinima', 'Data Mínima:', 'trim|valid_date');
			$this->form_validation->set_rules('DataTermino', 'Termina em:', 'required|trim|valid_date|valid_data_termino[' . $data['cadastrar']['DataMinima'] . ']|valid_data_termino2[' . $data['query']['Data'] . ']');
		}
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_evento', $data);
			
        } else {
		
			$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
			$data1 = $data1->format('Y-m-d');       
			
			$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
			$data2 = $data2->format('Y-m-d');    
				

			$this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_periodo_data[' . $data['query']['Data'] . ']');			
			$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
			
			if(strtotime($data2) == strtotime($data1)){
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
			}else{
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
			}			
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('consulta/form_evento', $data);
				
			} else {

				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'consulta/cadastrar_evento_extra/' . $_SESSION['Consulta']['Repeticao'] . $data['msg']);
					
				} else {
		
					$dataini_cad 	= $this->basico->mascara_data($data['query']['Data'], 'mysql');
					$datafim_cad 	= $this->basico->mascara_data($data['query']['Data2'], 'mysql');
					$horaini_cad 	= $data['query']['HoraInicio'];
					$horafim_cad 	= $data['query']['HoraFim'];
					
					if ($data['cadastrar']['Repetir'] == 'N') {
						$data['query']['Intervalo'] = 0;
						$data['query']['Periodo'] = 0;
						$data['query']['Tempo'] = 0;
						$data['query']['Tempo2'] = 0;
						$data['query']['DataTermino'] = $dataini_cad;
					}else{
						
						$tipointervalo = $data['query']['Tempo'];
						if($tipointervalo == 1){
							$semana = 1;
							$ref = "day";
						}elseif($tipointervalo == 2){
							$semana = 7;
							$ref = "day";
						}elseif($tipointervalo == 3){
							$semana = 1;
							$ref = "month";
						}elseif($tipointervalo == 4){
							$semana = 1;
							$ref = "Year";
						}
						
						$n = $data['query']['Intervalo']; //intervalo - a cada tantos dias
						$qtd = $data['query']['Recorrencias'];
						$data['query']['DataTermino'] = $this->basico->mascara_data($data['query']['DataTermino'], 'mysql');				
						
					}

					$data['query']['Tipo'] = 1;
					$data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
					$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
					//$data['query']['idTab_Status'] = 1;
					$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

					if($data['cadastrar']['Extra'] == 'N'){
						$data['query']['Repeticao'] = 0;
					}
					
					$data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
					
					unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
					
					$data['campos'] = array_keys($data['query']);
					$data['anterior'] = array();
					$data['query']['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

					if ($data['query']['idApp_Consulta'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('consulta/form_evento', $data);
					} else {
						
						if($data['cadastrar']['Extra'] == 'S'){
							$data['copiar']['Repeticao'] = $data['query']['Repeticao'];
						}else{
							$data['copiar']['Repeticao'] = $data['query']['idApp_Consulta'];
						}
						
						if($data['cadastrar']['Repetir'] == 'S'){
							//$data['copiar']['DataTermino'] = $ultimaocorrencia;
							$data['copiar']['DataTermino'] = $data['query']['DataTermino'];
							$data['copiar']['Recorrencia'] = "1/" . $qtd;
						}else{
							$data['copiar']['Recorrencia'] = "1/1";
							//$data['copiar']['DataTermino'] = $dataini_cad;
						}
						
						$data['update']['copiar']['bd'] = $this->Consulta_model->update_consulta($data['copiar'], $data['query']['idApp_Consulta']);
						
						if ($data['update']['copiar']['bd'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('consulta/form_evento', $data);
						} else {
							if ($data['cadastrar']['Repetir'] == 'S') {
								for($j=1; $j<$qtd; $j++) {
									$data['repeticao'][$j] = array(
										'Repeticao' 			=> $data['copiar']['Repeticao'],
										'Intervalo' 			=> $data['query']['Intervalo'],
										'Periodo' 				=> $data['query']['Periodo'],
										'Tempo' 				=> $data['query']['Tempo'],
										'Tempo2' 				=> $data['query']['Tempo2'],
										//'DataTermino' 		=> $ultimaocorrencia,
										'DataTermino' 			=> $data['query']['DataTermino'],
										'Recorrencias' 			=> $data['query']['Recorrencias'],
										'Recorrencia' 			=> ($j + 1) .  '/' . $data['query']['Recorrencias'],
										'idApp_Agenda' 			=> $data['query']['idApp_Agenda'],
										'Evento' 				=> $data['query']['Evento'],
										'Obs' 					=> $data['query']['Obs'],
										'idTab_Status' 			=> $data['query']['idTab_Status'],
										'Tipo' 					=> $data['query']['Tipo'],
										'DataInicio' 			=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) .  $ref,strtotime($dataini_cad))) . ' ' . $horaini_cad,
										'DataFim' 				=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) . $ref,strtotime($datafim_cad))) . ' ' . $horafim_cad,
										'idSis_Usuario' 		=> $_SESSION['log']['idSis_Usuario'],
										'idSis_Empresa' 		=> $_SESSION['log']['idSis_Empresa'],
										'idTab_Modulo' 			=> $_SESSION['log']['idTab_Modulo']
									);
									$data['campos'] = array_keys($data['repeticao'][$j]);
									$data['id_Repeticao'] = $this->Consulta_model->set_consulta($data['repeticao'][$j]);
								}
						
							}
								
							if($data['cadastrar']['Extra'] == 'S'){
								
								$data['cons_datatermino'] = $this->Consulta_model->get_consulta_datatermino($data['query']['Repeticao']);
								$data['data_termino'] = $data['cons_datatermino']['DataInicio'];
								
								$data['update']['cons_posts'] = $this->Consulta_model->get_consultas($data['query']['Repeticao']);
								$cont_cons_posts = count($data['update']['cons_posts']);
								
								if(isset($cont_cons_posts)){
									for($j=0;$j<$cont_cons_posts;$j++) {
										$k = (1 + $j);
										$data['update']['cons_posts'][$j]['DataTermino'] = $data['data_termino'];
										$data['update']['cons_posts'][$j]['Recorrencias'] = $cont_cons_posts;
										$data['update']['cons_posts'][$j]['Recorrencia'] = $k . "/" . $cont_cons_posts;
										$data['update']['cons_posts']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_posts'][$j], $data['update']['cons_posts'][$j]['idApp_Consulta']);
									}
								}
							}
								
							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], FALSE);
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
							
							redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
							exit();
						}	
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function alterar_evento($idApp_Consulta = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar as alterações do Agendamento.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Hidden_status',
        ), TRUE));
				
		$data['alterar'] = quotes_to_entities($this->input->post(array(
			'Quais',
        ), TRUE));
		
        $data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'Data2',
			'Data',
            'HoraInicio',
            'HoraFim',
            'Evento',
            'Obs',
			'idTab_Status',
		), TRUE);

 		(!$data['alterar']['Quais']) ? $data['alterar']['Quais'] = 1 : FALSE;
		
        if ($idApp_Consulta) {
            $_SESSION['Consulta'] = $data['query'] = $this->Consulta_model->get_consulta($idApp_Consulta);
			$_SESSION['dataTermino'] = $_SESSION['Consulta']['DataTermino'];
			$_SESSION['Consulta']['DataTermino'] = $this->basico->mascara_data($_SESSION['Consulta']['DataTermino'], 'barras');
            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);
            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['Data2'] = $this->basico->mascara_data($datafim[0], 'barras');
			$data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
			$_SESSION['Consulta']['DataInicio'] = $dataini[0];
            $_SESSION['Consulta']['DataFim'] = $datafim[0];
        } else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
        }
			
        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            #$data['readonly'] = 'readonly';
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }

		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
		
		$data['select']['Quais'] = array (
            '1' => 'Apenas Este',
            '2' => 'Este e os Anteriores',
			'3' => 'Este e os Posteriores',
			'4' => 'Todas',
        );


		if ($_SESSION['log']['idSis_Empresa'] == 5) {
			$data['resumo1'] = $this->Agenda_model->get_agenda($data['query']['idApp_Agenda']);
			$_SESSION['Agenda']['Nome'] = (strlen($data['resumo1']['Nome']) > 30) ? substr($data['resumo1']['Nome'], 0, 30) : $data['resumo1']['Nome'];
			$_SESSION['Agenda']['NomeEmpresa'] = (strlen($data['resumo1']['NomeEmpresa']) > 30) ? substr($data['resumo1']['NomeEmpresa'], 0, 30) : $data['resumo1']['NomeEmpresa'];
		}
		
        $data['titulo'] = 'Editar Evento';
        $data['form_open_path'] = 'consulta/alterar_evento';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['evento'] = 1;

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_date|valid_periodo_data[' . $data['query']['Data'] . ']');

		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            if ($_SESSION['log']['idSis_Empresa'] == $_SESSION['Consulta']['idSis_Empresa']) {
				$this->load->view('consulta/form_evento', $data);
			} else {
				$this->load->view('consulta/form_evento0', $data);
			}
			
        } else {
		
			$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
			$data1 = $data1->format('Y-m-d');       
			
			$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
			$data2 = $data2->format('Y-m-d');    

			$this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_periodo_data[' . $data['query']['Data'] . ']');			
			$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
			
			if(strtotime($data2) == strtotime($data1)){
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
			}else{
				$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
			}			
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('consulta/form_evento', $data);

			} else {

				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'consulta/alterar_evento/' . $_SESSION['Consulta']['idApp_Consulta'] . $data['msg']);
					
				} else {

					$data['query']['Tipo'] = 1;
					$data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
					$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
					#$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
					
					$dataanteriorinicio = strtotime($_SESSION['Consulta']['DataInicio']);
					$dataanteriorfim = strtotime($_SESSION['Consulta']['DataFim']);
					
					$dataposteriorinicio = strtotime($data1);
					$dataposteriorfim = strtotime($data2);
					
					$diferencainicio = ($dataposteriorinicio - $dataanteriorinicio)/86400;
					$diferencafim = ($dataposteriorfim - $dataanteriorfim)/86400;
					
					if($diferencainicio < 0){
						$difinicio = $diferencainicio;
					}else{
						$difinicio = '+' . $diferencainicio;
					}
					
					if($diferencafim < 0){
						$diffim = $diferencafim;
					}else{
						$diffim = '+' . $diferencafim;
					}
					
					$dataini_alt 	= $this->basico->mascara_data($data['query']['Data'], 'mysql');
					$datafim_alt 	= $this->basico->mascara_data($data['query']['Data2'], 'mysql');
					$horaini_alt 	= $data['query']['HoraInicio'];
					$horafim_alt 	= $data['query']['HoraFim'];			

					unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
					
					$data['anterior'] = $this->Consulta_model->get_consulta($data['query']['idApp_Consulta']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);
					$data['update']['query']['bd'] = $this->Consulta_model->update_consulta($data['query'], $data['query']['idApp_Consulta']);	

					$_SESSION['Repeticao'] = $data['repeticao'] = $this->Consulta_model->get_consulta_posterior($data['query']['idApp_Consulta'], $_SESSION['Consulta']['Repeticao'], $data['alterar']['Quais'], $dataini_alt);
					if (count($data['repeticao']) > 0) {
						$data['repeticao'] = array_combine(range(1, count($data['repeticao'])), array_values($data['repeticao']));
						$max = count($data['repeticao']);
						if (isset($data['repeticao'])) {
							for($j=1; $j <= $max; $j++) {
								//pego a data original, de cada linha, e somo a diferença
								$datainicial[$j] 								= explode(' ', $data['repeticao'][$j]['DataInicio']);
								$datafinal[$j] 									= explode(' ', $data['repeticao'][$j]['DataFim']);
								$dataoriginalinicio[$j] 						= $datainicial[$j][0];
								$dataoriginalfim[$j] 							= $datafinal[$j][0];
								$dataatualinicio[$j] 							= date('Y-m-d', strtotime($difinicio  .  'day',strtotime($dataoriginalinicio[$j])));
								$dataatualfim[$j] 								= date('Y-m-d', strtotime($diffim  .  'day',strtotime($dataoriginalfim[$j])));
								if($data['repeticao'][$j]['idApp_Consulta'] != $data['query']['idApp_Consulta']){
									$data['repeticao'][$j]['DataInicio'] 		= $dataatualinicio[$j] . ' ' . $horaini_alt;
									$data['repeticao'][$j]['DataFim'] 			= $dataatualfim[$j] . ' ' . $horafim_alt;
								}
								$data['repeticao'][$j]['idApp_Agenda'] 			= $data['query']['idApp_Agenda'];
								//$data['repeticao'][$j]['idApp_Cliente'] 		= $data['query']['idApp_Cliente'];
								$data['repeticao'][$j]['Obs'] 					= $data['query']['Obs'];
								//$data['repeticao'][$j]['idApp_Profissional'] 	= $data['query']['idApp_Profissional'];
								$data['repeticao'][$j]['idTab_Status'] 			= $data['query']['idTab_Status'];
								
								$data['update']['repeticao'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['repeticao'][$j], $data['repeticao'][$j]['idApp_Consulta']);
							}
						}
					}

					$data['cons_datatermino'] = $this->Consulta_model->get_consulta_datatermino($_SESSION['Consulta']['Repeticao']);
					$data['data_termino'] = $data['cons_datatermino']['DataInicio'];
					
					if(strtotime($data['data_termino']) != strtotime($_SESSION['dataTermino'])){
						
						$data['update']['cons_posts'] = $this->Consulta_model->get_consultas($_SESSION['Consulta']['Repeticao']);
						$cont_cons_posts = count($data['update']['cons_posts']);
						
						if(isset($cont_cons_posts)){
							
							for($j=0;$j<$cont_cons_posts;$j++) {
								$data['update']['cons_posts'][$j]['DataTermino'] = $data['data_termino'];
								$data['update']['cons_posts']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_posts'][$j], $data['update']['cons_posts'][$j]['idApp_Consulta']);
							}
						}
					}
					
					if ($data['auditoriaitem'] && $data['update']['query']['bd'] === FALSE) {
						$data['msg'] = '?m=1';
						redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						//redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
						redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
						exit();
					}
				}
			}
        }

        $this->load->view('basico/footer');
    }

    public function excluir_evento($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['alterar'] = quotes_to_entities($this->input->post(array(
			'Quais_Excluir',
        ), TRUE));
		
		$quais = $data['alterar']['Quais_Excluir'];	
		
		if (!$id) {
            $data['msg'] = '?m=2';
            redirect(base_url() . 'agenda' . $data['msg']);
        } else {

            $data['anterior'] = $this->Consulta_model->get_consulta($id);
			
			$repeticao = $data['anterior']['Repeticao'];
			$dataini = $data['anterior']['DataInicio'];
			/*
			echo '<br>';
          echo "<pre>";
          print_r('ido riginal = ' . $id);
		  echo '<br>';
          print_r('quais = ' . $quais);
		  echo '<br>';
          //print_r('DeletarOS = ' . $deletaros);
		  echo '<br>';
          print_r('repeticao = ' . $repeticao);
		  echo '<br>';
          print_r('data = ' . $dataini);
		  echo '<br>';
          //print_r('cont_delete_orca = ' . $count_delete_orca);
          echo "</pre>";
          exit ();
		  */
            $data['campos'] = array_keys($data['anterior']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['anterior']['idApp_Consulta'], FALSE, TRUE);
            $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'DELETE', $data['auditoriaitem']);
            $data['delete']['consulta'] = $this->Consulta_model->delete_consulta($id, $repeticao, $quais, $dataini);	
			
			$data['cons_datatermino'] = $this->Consulta_model->get_consulta_datatermino($repeticao);
			if(isset($data['cons_datatermino'])){
				$data['data_termino'] = $data['cons_datatermino']['DataInicio'];
			}else{
				$data['data_termino'] = "0000-00-00";
			}
			$data['update']['cons_posts'] = $this->Consulta_model->get_consultas($repeticao);
			$cont_cons_posts = count($data['update']['cons_posts']);
			
			if(isset($cont_cons_posts) && $cont_cons_posts > 0){
				
				for($j=0;$j<$cont_cons_posts;$j++) {
					$k = (1 + $j);
					$data['update']['cons_posts'][$j]['DataTermino'] = $data['data_termino'];
					$data['update']['cons_posts'][$j]['Recorrencias'] = $cont_cons_posts;
					$data['update']['cons_posts'][$j]['Recorrencia'] = $k . "/" . $cont_cons_posts;
					$data['update']['cons_posts']['bd'][$j] = $this->Consulta_model->update_consulta($data['update']['cons_posts'][$j], $data['update']['cons_posts'][$j]['idApp_Consulta']);
				}
			}            
			
			$data['msg'] = '?m=1';

            redirect(base_url() . 'agenda' . $data['msg']);
            exit();
        }

        $this->load->view('basico/footer');
    }
	
	public function cadastrar_particular($idApp_Cliente = NULL, $idApp_Agenda = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
                    'idSis_Usuario',
					'idApp_Consulta',
                    'idApp_Agenda',
                    'Data',
                    'HoraInicio',
                    'HoraFim',
                    'Evento',
                    'Obs',
					//'idApp_Profissional',
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
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');

        $data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

		$data['titulo'] = 'Agenda Particular';
        $data['form_open_path'] = 'consulta/cadastrar_particular';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['evento'] = 3;

        $data['readonly'] = '';
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_particular', $data);
        } else {

			$data['query']['Tipo'] = 3;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consulta'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar_particular($idApp_Consulta = FALSE, $idApp_Agenda = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'Data',
            'HoraInicio',
            'HoraFim',
            'Evento',
            'Obs',
			//'idApp_Profissional',
                ), TRUE);


        if ($idApp_Consulta) {
            $data['query'] = $this->Consulta_model->get_consulta($idApp_Consulta);

            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);

            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
        }

        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            #$data['readonly'] = 'readonly';
            $data['readonly'] = '';
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
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
        $data['titulo'] = 'Agenda Particular';
        $data['form_open_path'] = 'consulta/alterar_particular';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['evento'] = 1;

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_particular', $data);
        } else {

			$data['query']['Tipo'] = 3;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            //exit();

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['anterior'] = $this->Consulta_model->get_consulta($data['query']['idApp_Consulta']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);

            if ($data['auditoriaitem'] && $this->Consulta_model->update_consulta($data['query'], $data['query']['idApp_Consulta']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Consulta'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar_recorrencia() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        
				#### App_Consulta ####
				$data['anterior'] = $this->Consulta_model->get_recorrencia();
				if (isset($data['anterior'])){
				
					$max = count($data['anterior']);
					for($j=0;$j<$max;$j++) {
						
						$dataini[$j] 		= explode('/', $data['anterior'][$j]['Recorrencias']);
						$recorrencia[$j]	 = $dataini[$j][0];
						if(isset($dataini[$j][1])){
							$recorrencias[$j]	 = $dataini[$j][1];
							$data['anterior'][$j]['Recorrencia'] = $dataini[$j][1];
						}else{
							$data['anterior'][$j]['Recorrencia']	 = 1;
							
						}
					}
					
					if (count($data['anterior']))
						$data['update']['anterior']['bd'] =  $this->Consulta_model->update_procedimento($data['anterior']);
					/*
					echo '<br>';
					echo "<pre>";
					echo '<br>';
					print_r($data['update']['anterior']['bd']);
					echo "</pre>";	
					*/	
				}        

        //exit();
            
		redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
		exit();
			
        $this->load->view('basico/footer');
    }

}
