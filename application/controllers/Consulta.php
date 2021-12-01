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
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Whatsapp',
			'Repetir',
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
        ), TRUE));

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			//'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
            'idApp_ClienteDep',
            'idApp_ClientePet',
			'idApp_OrcaTrata',
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
		), TRUE));
		
 		//(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
 		(!$data['cadastrar']['Whatsapp']) ? $data['cadastrar']['Whatsapp'] = 'S' : FALSE;
 		(!$data['cadastrar']['Repetir']) ? $data['cadastrar']['Repetir'] = 'N' : FALSE;
 		(!$data['cadastrar']['Adicionar']) ? $data['cadastrar']['Adicionar'] = 'N' : FALSE;
 		(!$data['cadastrar']['Vincular']) ? $data['cadastrar']['Vincular'] = 'S' : FALSE;
 		(!$data['cadastrar']['NovaOS']) ? $data['cadastrar']['NovaOS'] = 'S' : FALSE;
 		(!$data['cadastrar']['PorConsulta']) ? $data['cadastrar']['PorConsulta'] = 'S' : FALSE;
		//(!$data['query']['Intervalo']) ? $data['query']['Intervalo'] = '1' : FALSE;
		//(!$data['query']['Periodo']) ? $data['query']['Periodo'] = '1' : FALSE;
		(!$data['query']['Recorrencias']) ? $data['query']['Recorrencias'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo2'] = '1' : FALSE;		
		
		/*
        if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Clienteusuario_model->get_clienteusuario($idApp_Cliente, TRUE);
        }
		
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
        }
		*/
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
		#$data['select']['idSis_EmpresaFilial'] = $this->Empresafilial_model->select_empresafilial();
		#$data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		
        #echo $data['query']['idApp_Agenda'] . ' ' . $_SESSION['log']['idSis_Usuario'];
        #$data['query']['idApp_Agenda'] = ($_SESSION['log']['Permissao'] > 2) ? $_SESSION['log']['idSis_Usuario'] : FALSE;

        /*
        echo count($data['select']['idApp_Agenda']);
        echo '<br>';
        echo "<pre>";
        print_r($data['select']['idApp_Agenda']);
        echo "</pre>";
        #exit();
        */

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
/*
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );
*/
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
		
        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data do Fim', 'required|trim|valid_date');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
        $this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');
		#$this->form_validation->set_rules('idSis_EmpresaFilial', 'Unidade', 'required|trim');
		
/*
        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');
*/
        #$data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
		#$data['resumo'] = $this->Clienteusuario_model->get_clienteusuario($data['query']['idApp_Cliente']);
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_consulta', $data);
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
			
			/*
			if($data['cadastrar']['Vincular'] == "N"){
				$data['query']['OS'] = "0";
				$data['query']['idApp_OrcaTrata'] = "0";
			}else{
			
				if($data['cadastrar']['NovaOS'] == "N"){
					$data['query']['OS'] = "1";
					$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
				}else{
					$data['query']['idApp_OrcaTrata'] = "0";
					if($data['cadastrar']['PorConsulta'] == "N"){
						//$data['query']['idApp_OrcaTrata'] = "0";
						$data['query']['OS'] = "1";
					}else{
						//$data['query']['idApp_OrcaTrata'] = "0";
						$data['query']['OS'] = $data['query']['Recorrencias'];
					}
				}
			}
			*/
			
			
			if($data['cadastrar']['PorConsulta'] == "S"){
				$data['query']['OS'] = $data['query']['Recorrencias'];
				$data['query']['idApp_OrcaTrata'] = "0";
			}else{
				if($data['query']['Recorrencias'] > 1){
					if($data['cadastrar']['NovaOS'] == "S"){
						$data['query']['OS'] = "1";
						$data['query']['idApp_OrcaTrata'] = "0";
					}else{
						if($data['cadastrar']['Vincular'] == "S"){
							$data['query']['OS'] = "1";
							$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
						}else{
							$data['query']['OS'] = "0";
							$data['query']['idApp_OrcaTrata'] = "0";
						}
					}
				}else{
					if($data['cadastrar']['Vincular'] == "S"){
						$data['query']['OS'] = "1";
						$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
					}else{
						$data['query']['OS'] = "0";
						$data['query']['idApp_OrcaTrata'] = "0";
					}
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
				
				if($data['cadastrar']['Whatsapp'] == 'S'){
					#### Whatsapp ####
					$data['Profissional'] 	= $this->Cliente_model->get_profissional($data['query']['idApp_Agenda'], TRUE);
					
					$_SESSION['bd']['NomeCliente'] 		= utf8_encode($_SESSION['Cliente']['NomeCliente']);
					$_SESSION['bd']['CelularCliente'] 	= $_SESSION['Cliente']['CelularCliente'];
					$_SESSION['bd']['Profissional'] 	= utf8_encode($data['Profissional']['Nome']);
					$_SESSION['bd']['DataInicio'] 		= $dataini_whats;
					$_SESSION['bd']['HoraInicio'] 		= $horaini_whats;
					
					unset($data['Profissional'], $dataini_whats, $horaini_whats);
				}

				$data['copiar']['Repeticao'] = $data['query']['idApp_Consulta'];
				if($data['cadastrar']['Repetir'] == 'S'){
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
					$this->load->view('consulta/form_consulta', $data);
				} else {
					if ($data['cadastrar']['Repetir'] == 'S') {
						for($j=1; $j<$qtd; $j++) {
							$data['repeticao'][$j] = array(
								'Repeticao' 			=> $data['query']['idApp_Consulta'],
								'Intervalo' 			=> $data['query']['Intervalo'],
								'Periodo' 				=> $data['query']['Periodo'],
								'Tempo' 				=> $data['query']['Tempo'],
								'Tempo2' 				=> $data['query']['Tempo2'],
								'DataTermino' 			=> $data['query']['DataTermino'],
								'Recorrencias' 			=> $data['query']['Recorrencias'],
								'Recorrencia' 			=> ($j + 1) .  '/' . $data['query']['Recorrencias'],
								'idApp_Agenda' 			=> $data['query']['idApp_Agenda'],
								'idApp_Cliente' 		=> $data['query']['idApp_Cliente'],
								'idApp_ClienteDep' 		=> $data['query']['idApp_ClienteDep'],
								'idApp_ClientePet' 		=> $data['query']['idApp_ClientePet'],
								'idApp_OrcaTrata' 		=> $data['query']['idApp_OrcaTrata'],
								//'Evento' 				=> $data['query']['Evento'],
								'Obs' 					=> $data['query']['Obs'],
								//'idApp_Profissional' 	=> $data['query']['idApp_Profissional'],
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
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                //redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
				//redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
				/*
				if($data['cadastrar']['Vincular'] == 'S'){	
					if($data['cadastrar']['NovaOS'] == 'S'){
						if($data['cadastrar']['PorConsulta'] == 'S'){
							//Gera O.S. Replicadas pelo número de ocorrências
							redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
						}else{
							//Gera uma única O.S.
							redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
						}
					}else{
						//Busca na lista de O.S. do cliente 
						//redirect(base_url() . 'orcatrata/listar/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
						redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
					}
				}else{
					//Não Gera O.S. 
					redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
				}
				*/
				
				if($data['cadastrar']['Adicionar'] == "S"){
					if($data['cadastrar']['PorConsulta'] == "S"){
						//Gera O.S. Replicadas pelo número de ocorrências
						redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
					}else{
						if($data['query']['Recorrencias'] > 1){
							if($data['cadastrar']['NovaOS'] == "S"){
								//Gera uma única O.S.
								redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
							}else{
								//Não Gera O.S. 
								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
							}
						}else{
							//Não Gera O.S. 
							redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
						}
					}
				}else{
					//Não Gera O.S. 
					redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
				}
					
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function cadastrar2($idApp_Cliente = NULL, $idApp_ContatoCliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Whatsapp',
			'Repetir',
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
        ), TRUE));

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			//'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
            'idApp_ClienteDep',
            'idApp_ClientePet',
            'idApp_OrcaTrata',
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
			//'OS',
		), TRUE));
		
 		//(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
 		(!$data['cadastrar']['Whatsapp']) ? $data['cadastrar']['Whatsapp'] = 'S' : FALSE;
 		(!$data['cadastrar']['Repetir']) ? $data['cadastrar']['Repetir'] = 'N' : FALSE;
 		(!$data['cadastrar']['Adicionar']) ? $data['cadastrar']['Adicionar'] = 'N' : FALSE;
 		(!$data['cadastrar']['Vincular']) ? $data['cadastrar']['Vincular'] = 'S' : FALSE;
 		(!$data['cadastrar']['NovaOS']) ? $data['cadastrar']['NovaOS'] = 'S' : FALSE;
 		(!$data['cadastrar']['PorConsulta']) ? $data['cadastrar']['PorConsulta'] = 'S' : FALSE;
		//(!$data['query']['Intervalo']) ? $data['query']['Intervalo'] = '1' : FALSE;
		//(!$data['query']['Periodo']) ? $data['query']['Periodo'] = '1' : FALSE;
		(!$data['query']['Recorrencias']) ? $data['query']['Recorrencias'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo2'] = '1' : FALSE;		
		
		/*
        if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Clienteusuario_model->get_clienteusuario($idApp_Cliente, TRUE);
        }
		
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
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
		*/
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
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['Data2'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
			$data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));

			/*
			$data['dtinicio'] = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
			$data['dtinicio'] = $data['dtinicio']->format('Y-m-d');
			
			
			$data['hrinicio'] = DateTime::createFromFormat('H:i', $data['query']['HoraInicio']);
			$data['hrinicio'] = $data['hrinicio']->format('H:i:s');
			
			
			$_SESSION['Horario'] = $this->Consulta_model->get_horarios($data['dtinicio'] . ' ' . $data['hrinicio']);		
			
			$data['count_horario'] = count($_SESSION['Horario']);
			
		   
			echo '<br>';
			echo "<pre>";
			print_r($data['query']['Data']);
			echo '<br>';
			print_r($data['query']['HoraInicio']);
			echo '<br>';
			print_r($data['dtinicio']);
			echo '<br>';
			print_r($data['hrinicio']);
			echo '<br>';
			print_r($data['count_horario']);
			echo '<br>';
			print_r($_SESSION['Horario']);
			echo '<br>';
			echo "</pre>";
			*/	
		
		
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
        //$data['select']['idApp_ClienteDep'] = $this->Cliente_model->select_clientedep($_SESSION['Cliente']['idApp_Cliente']);
        //$data['select']['idApp_ClientePet'] = $this->Cliente_model->select_clientepet($_SESSION['Cliente']['idApp_Cliente']);
		#$data['select']['idSis_EmpresaFilial'] = $this->Empresafilial_model->select_empresafilial();
		#$data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		
        #echo $data['query']['idApp_Agenda'] . ' ' . $_SESSION['log']['idSis_Usuario'];
        #$data['query']['idApp_Agenda'] = ($_SESSION['log']['Permissao'] > 2) ? $_SESSION['log']['idSis_Usuario'] : FALSE;

        /*
        echo count($data['select']['idApp_Agenda']);
        echo '<br>';
        echo "<pre>";
        print_r($data['select']['idApp_Agenda']);
        echo "</pre>";
        #exit();
        */

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
/*
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );
*/
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
		
		/*
		$data['dtinicio'] = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
		$data['dtinicio'] = $data['dtinicio']->format('Y-m-d');
		
		
		$data['hrinicio'] = DateTime::createFromFormat('H:i', $data['query']['HoraInicio']);
		$data['hrinicio'] = $data['hrinicio']->format('H:i:s');
		
		
		$_SESSION['Horario'] = $this->Consulta_model->get_horarios($data['dtinicio'] . ' ' . $data['hrinicio']);		
		
		$data['count_horario'] = count($_SESSION['Horario']);
		
	   
		echo '<br>';
		echo "<pre>";
		print_r($data['query']['Data']);
		echo '<br>';
		print_r($data['query']['HoraInicio']);
		echo '<br>';
		print_r($data['dtinicio']);
		echo '<br>';
		print_r($data['hrinicio']);
		echo '<br>';
		print_r($data['count_horario']);
		echo '<br>';
		print_r($_SESSION['Horario']);
		echo '<br>';
		echo "</pre>";
		exit();	
		*/

		
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
        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data do Fim', 'required|trim|valid_date');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
        $this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim|valid_cliente');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');
		#$this->form_validation->set_rules('idSis_EmpresaFilial', 'Unidade', 'required|trim');
		
		/*
        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');
		*/
        #$data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
		#$data['resumo'] = $this->Clienteusuario_model->get_clienteusuario($data['query']['idApp_Cliente']);
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
			$this->load->view('consulta/form_consulta', $data);
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
			
			
			
			/*
			if($data['cadastrar']['Vincular'] == "N"){
				$data['query']['OS'] = "0";
				$data['query']['idApp_OrcaTrata'] = "0";
			}else{
			
				if($data['cadastrar']['NovaOS'] == "N"){
					$data['query']['OS'] = "1";
					$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
				}else{
					$data['query']['idApp_OrcaTrata'] = "0";
					if($data['cadastrar']['PorConsulta'] == "N"){
						//$data['query']['idApp_OrcaTrata'] = "0";
						$data['query']['OS'] = "1";
					}else{
						//$data['query']['idApp_OrcaTrata'] = "0";
						$data['query']['OS'] = $data['query']['Recorrencias'];
					}
				}
			}
			*/
			
			if($data['cadastrar']['PorConsulta'] == "S"){
				$data['query']['OS'] = $data['query']['Recorrencias'];
				$data['query']['idApp_OrcaTrata'] = "0";
			}else{
				if($data['query']['Recorrencias'] > 1){
					if($data['cadastrar']['NovaOS'] == "S"){
						$data['query']['OS'] = "1";
						$data['query']['idApp_OrcaTrata'] = "0";
					}else{
						if($data['cadastrar']['Vincular'] == "S"){
							$data['query']['OS'] = "1";
							$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
						}else{
							$data['query']['OS'] = "0";
							$data['query']['idApp_OrcaTrata'] = "0";
						}
					}
				}else{
					if($data['cadastrar']['Vincular'] == "S"){
						$data['query']['OS'] = "1";
						$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
					}else{
						$data['query']['OS'] = "0";
						$data['query']['idApp_OrcaTrata'] = "0";
					}
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
				
				if($data['cadastrar']['Whatsapp'] == 'S'){
					#### Whatsapp ####
					$data['Cliente'] 		= $this->Cliente_model->get_cliente($data['query']['idApp_Cliente'], TRUE);
					$data['Profissional'] 	= $this->Cliente_model->get_profissional($data['query']['idApp_Agenda'], TRUE);
					
					$_SESSION['bd']['NomeCliente'] 		= utf8_encode($data['Cliente']['NomeCliente']);
					$_SESSION['bd']['CelularCliente'] 	= $data['Cliente']['CelularCliente'];
					$_SESSION['bd']['Profissional'] 	= utf8_encode($data['Profissional']['Nome']);
					$_SESSION['bd']['DataInicio'] 		= $dataini_whats;
					$_SESSION['bd']['HoraInicio'] 		= $horaini_whats;
					
					unset($data['Cliente'], $data['Profissional'], $dataini_whats, $horaini_whats);
				}

				$_SESSION['Copiar']['Repeticao'] = $data['query']['idApp_Consulta'];
				$data['copiar']['Repeticao'] = $data['query']['idApp_Consulta'];
				
				if($data['cadastrar']['Repetir'] == 'S'){
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
					$this->load->view('consulta/form_consulta', $data);
				} else {
					if ($data['cadastrar']['Repetir'] == 'S') {
						for($j=1; $j<$qtd; $j++) {
							$data['repeticao'][$j] = array(
								'Repeticao' 			=> $data['query']['idApp_Consulta'],
								'Intervalo' 			=> $data['query']['Intervalo'],
								'Periodo' 				=> $data['query']['Periodo'],
								'Tempo' 				=> $data['query']['Tempo'],
								'Tempo2' 				=> $data['query']['Tempo2'],
								'DataTermino' 			=> $data['query']['DataTermino'],
								'Recorrencias' 			=> $data['query']['Recorrencias'],
								'Recorrencia' 			=> ($j + 1) .  '/' . $data['query']['Recorrencias'],
								//'OS' 					=> $data['query']['OS'],
								'idApp_Agenda' 			=> $data['query']['idApp_Agenda'],
								'idApp_Cliente' 		=> $data['query']['idApp_Cliente'],
								'idApp_ClienteDep' 		=> $data['query']['idApp_ClienteDep'],
								'idApp_ClientePet' 		=> $data['query']['idApp_ClientePet'],
								'idApp_OrcaTrata' 		=> $data['query']['idApp_OrcaTrata'],
								//'Evento' 				=> $data['query']['Evento'],
								'Obs' 					=> $data['query']['Obs'],
								//'idApp_Profissional' 	=> $data['query']['idApp_Profissional'],
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
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
				
				/*
				if($data['cadastrar']['Vincular'] == 'S'){	
					if($data['cadastrar']['NovaOS'] == 'S'){
						if($data['cadastrar']['PorConsulta'] == 'S'){
							//Gera O.S. Replicadas pelo número de ocorrências
							redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
						}else{
							//Gera uma única O.S.
							redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
						}
					}else{
						//Busca na lista de O.S. do cliente 
						//redirect(base_url() . 'orcatrata/listar/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
						redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
					}
				}else{
					//Não Gera O.S. 
					redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
				}
				*/
				
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

        $this->load->view('basico/footer');
    }

    public function cadastrar2_Funcionando($idApp_Cliente = NULL, $idApp_ContatoCliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Repetir',
			'Prazo',
			'DataMinima',
			'RelacaoDep',
			'PeloPet',
			'PortePet',
			'EspeciePet',
        ), TRUE));

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
            'idApp_ClienteDep',
            'idApp_ClientePet',
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
		), TRUE));
		/*
		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            'idApp_Cliente',
            'idApp_ClientePet',
            'ObsOrca',
        ), TRUE));		
		*/
 		//(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
 		(!$data['cadastrar']['Repetir']) ? $data['cadastrar']['Repetir'] = 'N' : FALSE;
		//(!$data['query']['Intervalo']) ? $data['query']['Intervalo'] = '1' : FALSE;
		//(!$data['query']['Periodo']) ? $data['query']['Periodo'] = '1' : FALSE;
		(!$data['query']['Recorrencias']) ? $data['query']['Recorrencias'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo2'] = '1' : FALSE;		
		
		/*
        if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Clienteusuario_model->get_clienteusuario($idApp_Cliente, TRUE);
        }
		
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
        }
		*/
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
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
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
            '0' => '',
            '1' => 'CÃO',
            '2' => 'GATO',
			'3' => 'AVE',
        );		
		$data['select']['PeloPet'] = array (
            '0' => '',
            '1' => 'CURTO',
            '2' => 'MÉDIO',
			'3' => 'LONGO',
			'4' => 'CACHEADO',
        );		
		$data['select']['PortePet'] = array (
            '0' => '',
            '1' => 'MINI',
            '2' => 'PEQUENO',
			'3' => 'MÉDIO',
			'4' => 'GRANDE',
			'5' => 'GIGANTE',
        );
		$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Repetir'] = $this->Basico_model->select_status_sn();        
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
        //$data['select']['idApp_ClienteDep'] = $this->Cliente_model->select_clientedep($_SESSION['Cliente']['idApp_Cliente']);
        //$data['select']['idApp_ClientePet'] = $this->Cliente_model->select_clientepet($_SESSION['Cliente']['idApp_Cliente']);
		#$data['select']['idSis_EmpresaFilial'] = $this->Empresafilial_model->select_empresafilial();
		#$data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		
        #echo $data['query']['idApp_Agenda'] . ' ' . $_SESSION['log']['idSis_Usuario'];
        #$data['query']['idApp_Agenda'] = ($_SESSION['log']['Permissao'] > 2) ? $_SESSION['log']['idSis_Usuario'] : FALSE;

        /*
        echo count($data['select']['idApp_Agenda']);
        echo '<br>';
        echo "<pre>";
        print_r($data['select']['idApp_Agenda']);
        echo "</pre>";
        #exit();
        */

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
/*
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );
*/
        $data['titulo'] = 'Agendamento';
        $data['form_open_path'] = 'consulta/cadastrar2';
        $data['panel'] = 'primary';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['metodo'] = 1;
        $data['alterarcliente'] = 1;

 		//(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Repetir' => $this->basico->radio_checked($data['cadastrar']['Repetir'], 'Repetir', 'NS'),
        );
        ($data['cadastrar']['Repetir'] == 'S') ?
            $data['div']['Repetir'] = '' : $data['div']['Repetir'] = 'style="display: none;"';
					
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		if ($data['cadastrar']['Repetir'] == 'S') {
			$this->form_validation->set_rules('Intervalo', 'Intervalo', 'required|trim|valid_intervalo');
			$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo');
			//$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo|valid_periodo_intervalo[' . $data['query']['Intervalo'] . ']');
			$this->form_validation->set_rules('Tempo', 'Tempo', 'required|trim');
			$this->form_validation->set_rules('Tempo', 'Tempo2', 'required|trim');
			$this->form_validation->set_rules('DataMinima', 'Data Mínima:', 'trim|valid_date');
			$this->form_validation->set_rules('DataTermino', 'Termina em:', 'required|trim|valid_date|valid_data_termino[' . $data['cadastrar']['DataMinima'] . ']|valid_data_termino2[' . $data['query']['Data'] . ']');
		}
		
        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data do Fim', 'required|trim|valid_date');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
        $this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');
		#$this->form_validation->set_rules('idSis_EmpresaFilial', 'Unidade', 'required|trim');
		
/*
        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');
*/
        #$data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
		#$data['resumo'] = $this->Clienteusuario_model->get_clienteusuario($data['query']['idApp_Cliente']);
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            
			/*
			echo '<br>';
			echo "<pre>";
			print_r('id_Cliente: ' . $data['query']['idApp_Cliente']);
			echo '<br>';
			print_r('id_Pet: ' . $data['query']['idApp_ClientePet']);
			echo "</pre>";
			exit();			
			*/
			$this->load->view('consulta/form_consulta', $data);
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
				
				$data['query']['DataTermino'] = $this->basico->mascara_data($data['query']['DataTermino'], 'mysql');
				$n = $data['query']['Intervalo']; //intervalo - a cada tantos dias
				$qtd = $data['query']['Recorrencias'];				
				
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

            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');

            #unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

            unset($_SESSION['Agenda']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta', $data);
            } else {
				$data['copiar']['Repeticao'] = $data['idApp_Consulta'];
				if($data['cadastrar']['Repetir'] == 'S'){
					//$data['copiar']['DataTermino'] = $ultimaocorrencia;
					$data['copiar']['DataTermino'] = $data['query']['DataTermino'];;
					$data['copiar']['Recorrencias'] = "1/" . $qtd;
				}else{
					$data['copiar']['Recorrencias'] = "1/1";
					//$data['copiar']['DataTermino'] = $dataini_cad;
				}
				
				$data['update']['copiar']['bd'] = $this->Consulta_model->update_consulta($data['copiar'], $data['idApp_Consulta']);
				
				if ($data['update']['copiar']['bd'] === FALSE) {
					$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

					$this->basico->erro($msg);
					$this->load->view('consulta/form_consulta', $data);
				} else {
					if ($data['cadastrar']['Repetir'] == 'S') {
						for($j=1; $j<$qtd; $j++) {
							$data['repeticao'][$j] = array(
								'Repeticao' 			=> $data['idApp_Consulta'],
								'Intervalo' 			=> $data['query']['Intervalo'],
								'Periodo' 				=> $data['query']['Periodo'],
								'Tempo' 				=> $data['query']['Tempo'],
								'Tempo2' 				=> $data['query']['Tempo2'],
								//'DataTermino' 			=> $ultimaocorrencia,
								'DataTermino' 			=> $data['query']['DataTermino'],
								'Recorrencias' 			=> ($j + 1) .  '/' . $data['query']['Recorrencias'],
								'idApp_Agenda' 			=> $data['query']['idApp_Agenda'],
								'idApp_Cliente' 		=> $data['query']['idApp_Cliente'],
								'idApp_ClienteDep' 		=> $data['query']['idApp_ClienteDep'],
								'idApp_ClientePet' 		=> $data['query']['idApp_ClientePet'],
								//'Evento' 				=> $data['query']['Evento'],
								'Obs' 					=> $data['query']['Obs'],
								//'idApp_Profissional' 	=> $data['query']['idApp_Profissional'],
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

    public function cadastrar1111($idApp_Cliente = NULL, $idApp_ContatoCliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Empresa',
			'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
            'Data',
            'Data2',
			'HoraInicio',
            'HoraFim',
            'Paciente',
			'idTab_Status',
            'idTab_TipoConsulta',
            'idApp_ContatoCliente',
            //'idApp_Profissional',
            'Procedimento',
            'Obs',
                ), TRUE));

        /*
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
		}
		*/
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

        if (isset($_SESSION['agenda']) && !$data['query']['HoraInicio'] && !$data['query']['HoraFim']) {
            $data['query']['Data'] = date('d/m/Y', $_SESSION['agenda']['HoraInicio']);
            $data['query']['Data2'] = date('d/m/Y', $_SESSION['agenda']['HoraFim']);
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
        $this->form_validation->set_rules('Data2', 'Data do Fim', 'required|trim|valid_date');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
        #$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');


        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');

        $data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);

		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa3();
        #echo $data['query']['idApp_Agenda'] . ' ' . $_SESSION['log']['idSis_Usuario'];
        #$data['query']['idApp_Agenda'] = ($_SESSION['log']['Permissao'] > 2) ? $_SESSION['log']['idSis_Usuario'] : FALSE;

        /*
        echo count($data['select']['idApp_Agenda']);
        echo '<br>';
        echo "<pre>";
        print_r($data['select']['idApp_Agenda']);
        echo "</pre>";
        #exit();
        */

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );

        $data['titulo'] = 'Agendamento';
        $data['form_open_path'] = 'consulta/cadastrar1';
        $data['panel'] = 'primary';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['metodo'] = 1;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_consulta1', $data);
        } else {

			$data['query']['Tipo'] = 2;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            #$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
			//$data['query']['idTab_Status'] = 1;
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');

            #unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

            unset($_SESSION['Agenda']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta1', $data);
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
	
    public function cadastrar222($idApp_Cliente = NULL) {

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
            'idApp_Cliente',
			#'idSis_EmpresaFilial',
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
                ), TRUE));

		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
		}
/*
        if ($idApp_ContatoCliente) {
            $data['query']['idApp_ContatoCliente'] = $idApp_ContatoCliente;
            $data['query']['Paciente'] = 'D';
        }

        if (isset($_SESSION['agenda']) && !$data['query']['HoraInicio'] && !$data['query']['HoraFim']) {
            $data['query']['Data'] = date('d/m/Y', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraInicio'] = date('H:i', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraFim'] = date('H:i', $_SESSION['agenda']['HoraFim']);
        }
*/		
		if ($this->input->get('start') && $this->input->get('end')) {
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
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

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
		$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');
		#$this->form_validation->set_rules('idSis_EmpresaFilial', 'Unidade', 'required|trim');
/*
        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');

        $data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
*/
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		#$data['select']['idSis_EmpresaFilial'] = $this->Empresafilial_model->select_empresafilial();
		
        #echo $data['query']['idApp_Agenda'] . ' ' . $_SESSION['log']['idSis_Usuario'];
        #$data['query']['idApp_Agenda'] = ($_SESSION['log']['Permissao'] > 2) ? $_SESSION['log']['idSis_Usuario'] : FALSE;

        /*
        echo count($data['select']['idApp_Agenda']);
        echo '<br>';
        echo "<pre>";
        print_r($data['select']['idApp_Agenda']);
        echo "</pre>";
        #exit();
        */

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
/*
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );
*/
        $data['titulo'] = 'Agendamento';
        $data['form_open_path'] = 'consulta/cadastrar2';
        $data['panel'] = 'primary';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['metodo'] = 1;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_consulta2', $data);
        } else {

			$data['query']['Tipo'] = 2;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            //$data['query']['idTab_Status'] = 1;
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

            unset($_SESSION['Agenda']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta2', $data);
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

    public function alterar($idApp_Cliente = NULL, $idApp_Consulta = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Adicionar',
			'PeloPet',
			'PortePet',
			'RacaPet',
			'Vincular',
			'NovaOS',
			'PorConsulta',
			'EspeciePet',
        ), TRUE));
		
		$data['alterar'] = quotes_to_entities($this->input->post(array(
			'Quais',
			'Quais_excluir',
			'DeletarOS',
        ), TRUE));

        $data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
            'idApp_ClienteDep',
            'idApp_ClientePet',
            'idApp_OrcaTrata',
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
 		(!$data['alterar']['DeletarOS']) ? $data['alterar']['DeletarOS'] = 'S' : FALSE;
 		(!$data['cadastrar']['Adicionar']) ? $data['cadastrar']['Adicionar'] = 'N' : FALSE;
 		(!$data['cadastrar']['Vincular']) ? $data['cadastrar']['Vincular'] = 'S' : FALSE;
 		(!$data['cadastrar']['NovaOS']) ? $data['cadastrar']['NovaOS'] = 'S' : FALSE;
 		(!$data['cadastrar']['PorConsulta']) ? $data['cadastrar']['PorConsulta'] = 'S' : FALSE;

		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
			$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
			#$data['resumo'] = $this->Cliente_model->get_cliente($idApp_Cliente);
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
		}
		
        if ($idApp_Consulta) {
            #$data['query']['idApp_Cliente'] = $idApp_Cliente;
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
			
			$_SESSION['Consultas_zero'] = $data['consultas_zero'] = $this->Consulta_model->get_consultas_zero($_SESSION['Consulta']['idApp_OrcaTrata'], TRUE);
            $_SESSION['Consultas_Repet'] = $data['consultas_repet'] = $this->Consulta_model->get_consultas_repet($_SESSION['Consulta']['Repeticao']);
			
		}
        else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
        }
		
		$data['count_zero'] = count($_SESSION['Consultas_zero']);
		$data['count_repet'] = count($_SESSION['Consultas_Repet']);

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
		
		$data['exibir_id'] = 0;
		
		if($_SESSION['Consulta']['idApp_OrcaTrata'] == 0 || $_SESSION['Consulta']['idApp_OrcaTrata'] == ""){
			$data['vincular'] = 'S';
		}else{
			$data['vincular'] = 'N';
		}
		
 		//(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
		
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
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');	
        /*
		if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');
		*/
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');
		$this->form_validation->set_rules('Quais', 'Quais Alterar', 'required|trim');	
		
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

			/*
			if($data['cadastrar']['Vincular'] == "N"){
				$data['query']['OS'] = "0";
			}else{
				if($data['cadastrar']['NovaOS'] == "N"){
					$data['query']['OS'] = "1";
				}else{
					if($data['cadastrar']['PorConsulta'] == "N"){
						$data['query']['OS'] = "1";
					}else{
						$data['query']['OS'] = $_SESSION['Consulta']['Recorrencias'];
					}
				}
			}
			*/
        
		/*
        echo '<br>';
        echo "<pre>";
        print_r($_SESSION['Consulta']['OS']);
        echo '<br>';
        print_r($data['query']['idApp_OrcaTrata']);
        echo "</pre>";
        exit();
       	*/		
			if($_SESSION['Consulta']['idApp_OrcaTrata'] == 0 || $_SESSION['Consulta']['idApp_OrcaTrata'] == ""){						
				if($data['cadastrar']['PorConsulta'] == "S"){
					//$data['query']['OS'] = $data['query']['Recorrencias'];
					$data['query']['OS'] = $data['count_repet'];
					$data['query']['idApp_OrcaTrata'] = "0";
				}else{
					if($data['count_repet'] > 1){
						if($data['cadastrar']['NovaOS'] == "S"){
							$data['query']['OS'] = "1";
							$data['query']['idApp_OrcaTrata'] = "0";
						}else{
							if($data['cadastrar']['Vincular'] == "S"){
								$data['query']['OS'] = "1";
								$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
							}else{
								$data['query']['OS'] = "0";
								$data['query']['idApp_OrcaTrata'] = "0";
							}
						}
					}else{
						if($data['cadastrar']['Vincular'] == "S"){
							$data['query']['OS'] = "1";
							$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
						}else{
							$data['query']['OS'] = "0";
							$data['query']['idApp_OrcaTrata'] = "0";
						}
					}
				}	
			}else{
				$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
				$data['query']['OS'] = $_SESSION['Consulta']['OS'];
			}			

			/*
			if($_SESSION['Consulta']['idApp_OrcaTrata'] == 0 || $_SESSION['Consulta']['idApp_OrcaTrata'] == ""){
				
				$data['vincular'] = 'S';
				
				if($data['count_repet'] == 0){
					$data['porconsulta'] = 'N';
				}else{
					$data['porconsulta'] = 'N';
					$data['cadastrar']['PorConsulta'] = "N";
				}
				
				if($data['cadastrar']['Vincular'] == "N"){
					$data['query']['idApp_OrcaTrata'] = "0";
				}else{
					
					if($data['cadastrar']['NovaOS'] == "N"){
						$data['query']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];
					
					}else{
					
						$data['query']['idApp_OrcaTrata'] = "0";
						if($data['cadastrar']['PorConsulta'] == "N"){
							$data['query']['idApp_OrcaTrata'] = "0";
						}else{
							$data['query']['idApp_OrcaTrata'] = "0";
						}
					}
				}

			}else{
				$data['query']['idApp_OrcaTrata'] = $_SESSION['Consulta']['idApp_OrcaTrata'];
				$data['vincular'] = 'N';
				$data['porconsulta'] = 'N';
				$data['cadastrar']['Vincular'] = "N";
				$data['cadastrar']['NovaOS'] = "N";
				$data['cadastrar']['PorConsulta'] = "N";
			}		
			*/
		
			unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			
            $data['anterior'] = $this->Consulta_model->get_consulta($data['query']['idApp_Consulta']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);

			$data['update']['query']['bd'] = $this->Consulta_model->update_consulta($data['query'], $data['query']['idApp_Consulta']);
			
			if($data['query']['idApp_OrcaTrata'] != 0){
				$data['orca']['idApp_ClientePet']	= $data['query']['idApp_ClientePet'];
				$data['orca']['DataEntregaOrca']	= $dataini_alt;
				$data['orca']['HoraEntregaOrca']	= $horaini_alt;

				$data['update']['orca']['bd'] 	= $this->Orcatrata_model->update_orcatrata($data['orca'], $data['query']['idApp_OrcaTrata']);

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
			}
			/*
			echo '<br>';
			echo "<pre>";
			print_r($data['query']['idApp_OrcaTrata']);
			echo '<br>';
			print_r($dataini_alt);
			echo '<br>';
			//print_r($data['update']['orca']['bd']);
			echo '<br>';
			print_r('Contagem = '.$max);
			echo '<br>';
			print_r($data['update']['produto']['alterar']);
			echo '<br>';
			echo "</pre>";			
			exit();
			*/
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
						$data['repeticao'][$j]['Repeticao'] 			= $data['query']['Repeticao'];
						$data['repeticao'][$j]['idApp_Agenda'] 			= $data['query']['idApp_Agenda'];
						$data['repeticao'][$j]['idApp_Cliente'] 		= $data['query']['idApp_Cliente'];
						$data['repeticao'][$j]['idApp_ClienteDep'] 		= $data['query']['idApp_ClienteDep'];
						$data['repeticao'][$j]['idApp_ClientePet'] 		= $data['query']['idApp_ClientePet'];
						$data['repeticao'][$j]['Obs'] 					= $data['query']['Obs'];
						//$data['repeticao'][$j]['idApp_Profissional'] 	= $data['query']['idApp_Profissional'];
						$data['repeticao'][$j]['idTab_Status'] 			= $data['query']['idTab_Status'];
						$data['repeticao'][$j]['idTab_TipoConsulta'] 	= $data['query']['idTab_TipoConsulta'];
						
						$data['update']['repeticao'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['repeticao'][$j], $data['repeticao'][$j]['idApp_Consulta']);
						
						if($data['repeticao'][$j]['idApp_OrcaTrata'] != 0 && $data['repeticao'][$j]['idApp_OrcaTrata'] != $data['query']['idApp_OrcaTrata']){
							
							$data['orca'][$j]['idApp_ClientePet'] 	= $data['query']['idApp_ClientePet'];
							$data['orca'][$j]['DataEntregaOrca'] 	= $dataatualinicio[$j];
							$data['orca'][$j]['HoraEntregaOrca'] 	= $horaini_alt;
							
							$data['update']['orca']['bd'][$j] 		= $this->Orcatrata_model->update_orcatrata($data['orca'][$j], $data['repeticao'][$j]['idApp_OrcaTrata']);

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
							
						}
						
					}
				}
			}
			
			if($_SESSION['Consulta']['idApp_OrcaTrata'] == 0 || $_SESSION['Consulta']['idApp_OrcaTrata'] == ""){
			
				if($data['cadastrar']['Vincular'] == "S" && $data['cadastrar']['NovaOS'] == "N"){
					
					$_SESSION['OrcaTrata'] = $data['orcatrata'] = $this->Consulta_model->get_consulta_posterior($data['query']['idApp_Consulta'], $_SESSION['Consulta']['Repeticao'], 4, $dataini_alt);
					
					if (count($data['orcatrata']) > 0) {
						$data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
						$max_orcatrata = count($data['orcatrata']);
						if (isset($data['orcatrata'])) {
							for($j=1; $j <= $max_orcatrata; $j++) {
								
								$data['orcatrata'][$j]['idApp_OrcaTrata'] 		= $data['query']['idApp_OrcaTrata'];
								
								$data['update']['orcatrata'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['orcatrata'][$j], $data['orcatrata'][$j]['idApp_Consulta']);
							}
						}
					}
				
				}

			}			


			if ($data['auditoriaitem'] === FALSE) {
				$data['msg'] = '';
			} else {
				$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
				$data['msg'] = '?m=1';
			}

			if(isset($data['query']['idApp_OrcaTrata']) && ($data['query']['idApp_OrcaTrata'] == 0 || $data['query']['idApp_OrcaTrata'] == "")){
				/*
				if($data['cadastrar']['Vincular'] == 'S'){	
					if($data['cadastrar']['NovaOS'] == 'S'){
						if($data['cadastrar']['PorConsulta'] == 'S'){
							//Gera O.S. Replicadas pelo número de ocorrências
							unset($_SESSION['Agenda'], $_SESSION['Cliente'], $_SESSION['Consulta'], $_SESSION['Consultas_Repet'], $_SESSION['Repeticao']);
							redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
						}else{
							//Gera uma única O.S.
							unset($_SESSION['Agenda'], $_SESSION['Cliente'], $_SESSION['Consulta'], $_SESSION['Consultas_Repet'], $_SESSION['Repeticao']);
							redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
						}
					}else{
						//Busca na lista de O.S. do cliente
						unset($_SESSION['Agenda'], $_SESSION['Cliente'], $_SESSION['Consulta'], $_SESSION['Consultas_Repet'], $_SESSION['Repeticao']);
						//redirect(base_url() . 'orcatrata/listar/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
						redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
					}
				}else{
					//Não Gera O.S.
					unset($_SESSION['Agenda'], $_SESSION['Cliente'], $_SESSION['Consulta'], $_SESSION['Consultas_Repet'], $_SESSION['Repeticao']);
					redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
				}
				*/
				if($data['cadastrar']['Adicionar'] == "S"){
					if($data['cadastrar']['PorConsulta'] == "S"){
						//Gera O.S. Replicadas pelo número de ocorrências
						unset($_SESSION['Agenda'], $_SESSION['Cliente'], $_SESSION['Consulta'], $_SESSION['Consultas_Repet'], $_SESSION['Repeticao']);
						redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
					}else{
						if($data['cadastrar']['NovaOS'] == "S"){
							//Gera uma única O.S.
							unset($_SESSION['Agenda'], $_SESSION['Cliente'], $_SESSION['Consulta'], $_SESSION['Consultas_Repet'], $_SESSION['Repeticao']);
							redirect(base_url() . 'orcatrata/cadastrarrepet/' . $data['query']['idApp_Cliente'] . '/' . $data['query']['idApp_Consulta'] . $data['msg']);
						}else{
							//Busca na lista de O.S. do cliente
							unset($_SESSION['Agenda'], $_SESSION['Cliente'], $_SESSION['Consulta'], $_SESSION['Consultas_Repet'], $_SESSION['Repeticao']);
							redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
						}
					}
				}else{
					//Não Gera O.S.
					unset($_SESSION['Agenda'], $_SESSION['Cliente'], $_SESSION['Consulta'], $_SESSION['Consultas_Repet'], $_SESSION['Repeticao']);
					redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
				}
			}else{
				//Não Gera O.S.
				unset($_SESSION['Agenda'], $_SESSION['Cliente'], $_SESSION['Consulta'], $_SESSION['Consultas_Repet'], $_SESSION['Repeticao']);
				//redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
				redirect(base_url() . 'orcatrata/alterarstatus/' . $data['query']['idApp_OrcaTrata'] . $data['msg']);
			}
				
			exit();
           
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
					  
					$data['msg'] = '?m=1';
					redirect(base_url() . 'agenda' . $data['msg']);
					exit();
				}else{
					$data['msg'] = '?m=1';
					redirect(base_url() . 'agenda' . $data['msg']);
					exit();
				}
			}else{
				$data['msg'] = '?m=1';
				redirect(base_url() . 'agenda' . $data['msg']);
				exit();
			}
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
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Repetir',
			'Prazo',
			'DataMinima',
        ), TRUE));
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'idSis_Usuario',
			//'idApp_Consulta',
			'idApp_Agenda',
			//'idApp_Cliente',
			#'idSis_EmpresaFilial',
			'Data',
			'Data2',
			'HoraInicio',
			'HoraFim',
			'Evento',
			'Obs',
			//'idApp_Profissional',
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
		//(!$data['query']['Intervalo']) ? $data['query']['Intervalo'] = '1' : FALSE;
		//(!$data['query']['Periodo']) ? $data['query']['Periodo'] = '1' : FALSE;
		(!$data['query']['Recorrencias']) ? $data['query']['Recorrencias'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo2'] = '1' : FALSE;

        if ($this->input->get('start') && $this->input->get('end')) {
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['Data2'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
			$data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }

		$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
		$data1 = $data1->format('Y-m-d');       
		$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
		$data2 = $data2->format('Y-m-d');		
		/*
			echo '<br>';
			echo "<pre>";
			print_r($data1);
			echo '<br>';
			print_r($data2);
			echo "</pre>";
			exit();		
		*/

		//$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		#$data['select']['idSis_EmpresaFilial'] = $this->Empresafilial_model->select_empresafilial();
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
		$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Repetir'] = $this->Basico_model->select_status_sn();        
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
			
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
		$this->form_validation->set_rules('Prazo', 'Prazo', 'trim|valid_prazo');
        $this->form_validation->set_rules('Data', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_date|valid_periodo_data[' . $data['query']['Data'] . ']');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        if(strtotime($data2) == strtotime($data1)){
			$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		}else{
			$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
		}
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

				$data['copiar']['Repeticao'] = $data['query']['idApp_Consulta'];
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
								'Repeticao' 			=> $data['query']['idApp_Consulta'],
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
			
					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
					$data['msg'] = '?m=1';
					
					redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
					exit();
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
        else
            $data['msg'] = '';
		
		$data['alterar'] = quotes_to_entities($this->input->post(array(
			'Quais',
        ), TRUE));
		
        $data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
			#'idSis_EmpresaFilial',
            'Data2',
			'Data',
            'HoraInicio',
            'HoraFim',
            'Evento',
            'Obs',
			//'idApp_Profissional',
			'idTab_Status',
                ), TRUE);

 		(!$data['alterar']['Quais']) ? $data['alterar']['Quais'] = 1 : FALSE;
		
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

		$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
		$data1 = $data1->format('Y-m-d');       
		$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
		$data2 = $data2->format('Y-m-d');		

		//$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		#$data['select']['idSis_EmpresaFilial'] = $this->Empresafilial_model->select_empresafilial();
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
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        if(strtotime($data2) == strtotime($data1)){
			$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		}else{
			$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
		}
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            if ($_SESSION['log']['idSis_Empresa'] == $_SESSION['Consulta']['idSis_Empresa']) {
				$this->load->view('consulta/form_evento', $data);
			} else {
				$this->load->view('consulta/form_evento0', $data);
			}			
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
            $this->Consulta_model->delete_consulta($id, $repeticao, $quais, $dataini);	
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
