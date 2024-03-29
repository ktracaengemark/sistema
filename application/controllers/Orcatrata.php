<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrata extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array(	'Basico_model', 'Orcatrata_model', 'Procedimento_model', 
									'Produtos_model', 'Usuario_model', 'Cliente_model', 'Clientepet_model', 
									'Clientedep_model', 'Consulta_model', 'Fornecedor_model', 'Relatorio_model', 
									'Formapag_model', 'Associado_model', 'Campanha_model'
								));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('orcatrata/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
            $data['msg'] = '';

		$this->load->view('orcatrata/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrarrepet($idApp_Cliente = NULL, $idApp_Consulta = NULL) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Cad_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 3)
				$data['msg'] = $this->basico->msg('<strong>N�o � poss�vel salvar o novo Pedido.<br>N�o identificamos o pagamento da sua �ltima Fatura.<br>Por favor, Entre em contato com a administra��o da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
			else
				$data['msg'] = '';

			#### Carrega os dados da Agenda nas vari�ves de sess�o do Whatsapp ####
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

			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'ConcluidoProduto',
				'QuitadoParcelas',
				'Cadastrar',
				'AtualizaEndereco',
				'Repetir',
				'StatusProdutos',
				'StatusParcelas',
				'Valor_S_Desc',
				'Valor_C_Desc',
				'UsarC',
				'UsarD',
				'UsarE',
				'ValidaCupom',
				'MensagemCupom',
				'CodigoCupom',
			), TRUE));

			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['orcatrata'] = quotes_to_entities($this->input->post(array(
				#### App_OrcaTrata ####
				//'idApp_OrcaTrata',
				'Tipo_Orca',
				'idApp_Cliente',
				'idApp_ClientePet',
				'idApp_ClienteDep',
				'DataOrca',
				'HoraOrca',
				'TipoFinanceiro',
				'Descricao',
				'AprovadoOrca',
				'ConcluidoOrca',
				'BrindeOrca',
				'DevolvidoOrca',
				'ProntoOrca',
				'QuitadoOrca',
				'ValorOrca',
				'ValorComissao',
				'ValorDev',
				'QtdPrdOrca',
				'QtdSrvOrca',
				'PrazoProdutos',
				'PrazoServicos',
				'PrazoProdServ',
				'PrazoCorreios',
				'ValorDinheiro',
				'ValorTroco',
				'ValorRestanteOrca',
				'FormaPagamento',
				'Modalidade',
				'QtdParcelasOrca',
				'DataVencimentoOrca',
				'ObsOrca',
				'Consideracoes',
				'idTab_TipoRD',
				'AVAP',
				'EnviadoOrca',
				'Cep',
				'Logradouro',
				'Numero',
				'Complemento',
				'Bairro',
				'Cidade',
				'Estado',
				'Referencia',
				'TipoFrete',
				'ValorFrete',
				'ValorExtraOrca',
				'PercExtraOrca',
				'ValorSomaOrca',
				'CombinadoFrete',
				'PrazoEntrega',
				'ValorTotalOrca',
				'FinalizadoOrca',
				'Entregador',
				'DataEntregaOrca',
				'HoraEntregaOrca',
				'NomeRec',
				'TelefoneRec',
				'ParentescoRec',
				'ObsEntrega',
				'Aux1Entrega',
				'Aux2Entrega',
				'DetalhadaEntrega',
				'CanceladoOrca',
				'Cli_Forn_Orca',
				'Prd_Srv_Orca',
				'Entrega_Orca',
				'TipoDescOrca',
				'TipoExtraOrca',
				'DescPercOrca',
				'DescValorOrca',
				'CashBackOrca',
				'ValidadeCashBackOrca',
				'UsarCashBack',
				'UsarCupom',
				'Cupom',
				'SubValorFinal',
				'ValorFinalOrca',
				//'RepeticaoOrca',
				'RepeticaoCons',
				'RecorrenciasOrca',
				'RecorrenciaOrca',
			), TRUE));
			
			$data['cliente'] = $this->input->post(array(
				'idApp_Cliente',
				'CepCliente',
				'EnderecoCliente',
				'NumeroCliente',
				'ComplementoCliente',
				'CidadeCliente',
				'BairroCliente',
				'MunicipioCliente',
				'EstadoCliente',
				'ReferenciaCliente',
			), TRUE);

			$caracteres_sem_acento = array(
				'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
				'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
				'�'=>'I', '�'=>'N', 'N'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
				'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
				'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
				'�'=>'i', '�'=>'o', '�'=>'n', 'n'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
				'�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f',
				'a'=>'a', '�'=>'i', '�'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', '�'=>'I', '�'=>'A', '?'=>'S', '?'=>'T',
			);

			$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Logradouro'], $caracteres_sem_acento));

			$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['orcatrata']['Cep'], $caracteres_sem_acento));

			$numero1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Numero'], $caracteres_sem_acento));

			$complemento1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Complemento'], $caracteres_sem_acento));

			$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Bairro'], $caracteres_sem_acento));

			$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Cidade'], $caracteres_sem_acento));

			$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Estado'], $caracteres_sem_acento));

			$referencia1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Referencia'], $caracteres_sem_acento));
		
			if ($idApp_Consulta) {
				
				$_SESSION['Consulta'] = $data['consulta'] = $this->Consulta_model->get_consulta_orca_zero($idApp_Consulta, TRUE);
				
				if($data['consulta'] === FALSE){
					
					unset($_SESSION['Consulta']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				}
			}
			
			if(!$_SESSION['Consulta'] || $_SESSION['Consulta']['Tipo'] == 1){
				
				unset($_SESSION['Consulta']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {

				$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($_SESSION['Consulta']['idApp_Cliente'], TRUE);
				
				if($data['query'] === FALSE){
					
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {
					
					$data['query']['idApp_Cliente'] = $_SESSION['Consulta']['idApp_Cliente'];
									
					$_SESSION['Consultas'] = $this->Consulta_model->get_consultas($_SESSION['Consulta']['Repeticao'], TRUE);
					
					if(isset($_SESSION['Consulta']['idApp_ClientePet']) && !empty($_SESSION['Consulta']['idApp_ClientePet']) && $_SESSION['Consulta']['idApp_ClientePet'] != 0){
						$_SESSION['Pet'] = $this->Orcatrata_model->get_pet($_SESSION['Consulta']['idApp_ClientePet'], TRUE);
					}
					if(isset($_SESSION['Consulta']['idApp_ClienteDep']) && !empty($_SESSION['Consulta']['idApp_ClienteDep']) && $_SESSION['Consulta']['idApp_ClienteDep'] != 0){
						$_SESSION['Dep'] = $this->Orcatrata_model->get_dep($_SESSION['Consulta']['idApp_ClienteDep'], TRUE);
					}
				
					$_SESSION['RepeticaoCons'] = $this->Orcatrata_model->get_repeticaocons($_SESSION['Consulta']['Repeticao']);
					$_SESSION['RepeticaoOrca'] = $this->Orcatrata_model->get_repeticaoorca($_SESSION['Consulta']['Repeticao']);				

					if(isset($data['query']['CepCliente'])){
						(!$data['orcatrata']['Cep']) ? $data['orcatrata']['Cep'] = $data['query']['CepCliente'] : FALSE;
					}
					
					if(isset($data['query']['EnderecoCliente'])){
						(!$data['orcatrata']['Logradouro']) ? $data['orcatrata']['Logradouro'] = $data['query']['EnderecoCliente'] : FALSE;
					}
					
					if(isset($data['query']['NumeroCliente'])){
						(!$data['orcatrata']['Numero']) ? $data['orcatrata']['Numero'] = $data['query']['NumeroCliente'] : FALSE;
					}
					
					if(isset($data['query']['ComplementoCliente'])){	
						(!$data['orcatrata']['Complemento']) ? $data['orcatrata']['Complemento'] = $data['query']['ComplementoCliente'] : FALSE;
					}
					
					if(isset($data['query']['BairroCliente'])){
					 (!$data['orcatrata']['Bairro']) ? $data['orcatrata']['Bairro'] = $data['query']['BairroCliente'] : FALSE;
					}
					
					if(isset($data['query']['CidadeCliente'])){
					 (!$data['orcatrata']['Cidade']) ? $data['orcatrata']['Cidade'] = $data['query']['CidadeCliente'] : FALSE;
					}
						
					if(isset($data['query']['EstadoCliente'])){
					 (!$data['orcatrata']['Estado']) ? $data['orcatrata']['Estado'] = $data['query']['EstadoCliente'] : FALSE;
					}
					
					if(isset($data['query']['ReferenciaCliente'])){
					 (!$data['orcatrata']['Referencia']) ? $data['orcatrata']['Referencia'] = $data['query']['ReferenciaCliente'] : FALSE;
					}

					($_SESSION['Usuario']['Bx_Pag'] == "S") ? $data['div']['Prof_comissao'] = '' : $data['div']['Prof_comissao'] = 'style="display: none;"';		
					
					(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
					(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
					(!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');

					//Data de hoje como default
					
					//Dados para gerar repeti��es do orcamento////
					
					(!$data['orcatrata']['RecorrenciasOrca']) ? $data['orcatrata']['RecorrenciasOrca'] = "1" : FALSE;

					$data['repeticaocons'] = count($_SESSION['RepeticaoCons']);// conto quantas Consultas tem essa repeti��o
					$data['repeticaoorca'] = count($_SESSION['RepeticaoOrca']);// conto quantas OS tem essa repeti��o			
					/*
					echo '<br>';
					echo "<pre>";
					echo '<br>';
					print_r($data['repeticaocons']);
					echo '<br>';
					print_r($data['repeticaoorca']);
					echo '<br>';
					print_r($_SESSION['Consulta']['OS']);
					echo "</pre>"; 
					*/
					
					/////////////// Conferir a parte de poder ou n�o alterar os campos/////////////////////////////////
					if(isset($_SESSION['Consulta']['OS'])){
						if($data['repeticaocons'] > $_SESSION['Consulta']['OS']){
							$data['alterar_campos'] = 1;
							$data['readonly_cons'] = '';
						}else{
							$data['alterar_campos'] = 0;
							$data['readonly_cons'] = 'readonly=""';
						}
					}else{
						$data['alterar_campos'] = 1;
						$data['readonly_cons'] = '';
					}		
					////////////////////////////////////////////////////////////////////////////////////////////////

					//$data['orcatrata']['RecorrenciasOrca'] = 2;
					$dataini = explode(' ', $_SESSION['Consulta']['DataInicio']);
					$data['orcatrata']['DataOrca']			=	$this->basico->mascara_data($dataini[0], 'barras');
					(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($dataini[0], 'barras') : FALSE;
					$data['orcatrata']['HoraEntregaOrca']	=	substr($dataini[1], 0, 5);
					$data['orcatrata']['DataVencimentoOrca']=	$this->basico->mascara_data($dataini[0], 'barras');
					
					
					if($data['repeticaoorca'] == 0){
						if($_SESSION['Consulta']['OS'] == 1){
							$data['orcatrata']['RecorrenciasOrca'] 	= 	$_SESSION['Consulta']['OS'];
						}else{
							$data['orcatrata']['RecorrenciasOrca'] 	=  $data['repeticaocons'];
						}
					}else{
						$data['diferencaOS'] = $data['repeticaocons'] - $data['repeticaoorca'];
						$data['orcatrata']['RecorrenciasOrca'] 	= 	$data['diferencaOS'];
					}

					$data['orcatrata']['RepeticaoCons'] 	= 	$_SESSION['Consulta']['Repeticao'];
					/*
					echo '<br>';
					echo "<pre>";
					print_r($data['orcatrata']['RecorrenciasOrca']);
					echo '<br>';
					print_r($data['orcatrata']['RepeticaoCons']);
					echo '<br>';
					
					print_r($idApp_Consulta);
					echo '<br>';
					print_r($_SESSION['Consulta']);
					
					echo "</pre>";		
					*/
					$data['orcatrata']['idApp_ClientePet'] 	= 	$_SESSION['Consulta']['idApp_ClientePet'];
					$data['orcatrata']['idApp_ClienteDep'] 	= 	$_SESSION['Consulta']['idApp_ClienteDep'];
					

					//Fim dos Dados//////
					
					$data['orcatrata']['Tipo_Orca'] = "B";
					(!$data['orcatrata']['Descricao']) ? $data['orcatrata']['Descricao'] = $_SESSION['Consulta']['Obs'] : FALSE;
					(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
					(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;
					(!$data['orcatrata']['Entrega_Orca']) ? $data['orcatrata']['Entrega_Orca'] = 'S' : FALSE;
					(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
					(!$data['orcatrata']['HoraOrca']) ? $data['orcatrata']['HoraOrca'] = date('H:i:s', time()) : FALSE;
					//(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
					(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
					(!$data['orcatrata']['DataVencimentoOrca']) ? $data['orcatrata']['DataVencimentoOrca'] = date('d/m/Y', time()) : FALSE;
					#(!$data['orcatrata']['DataPrazo']) ? $data['orcatrata']['DataPrazo'] = date('d/m/Y', time()) : FALSE;
					(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "2" : FALSE;
					(!$data['orcatrata']['ValorOrca']) ? $data['orcatrata']['ValorOrca'] = '0.00' : FALSE;
					(!$data['orcatrata']['ValorComissao']) ? $data['orcatrata']['ValorComissao'] = '0.00' : FALSE;
					(!$data['orcatrata']['QtdPrdOrca']) ? $data['orcatrata']['QtdPrdOrca'] = '0' : FALSE;
					(!$data['orcatrata']['QtdSrvOrca']) ? $data['orcatrata']['QtdSrvOrca'] = '0' : FALSE;
					(!$data['orcatrata']['PrazoProdutos']) ? $data['orcatrata']['PrazoProdutos'] = '0' : FALSE;
					(!$data['orcatrata']['PrazoServicos']) ? $data['orcatrata']['PrazoServicos'] = '0' : FALSE;
					(!$data['orcatrata']['ValorDev']) ? $data['orcatrata']['ValorDev'] = '0.00' : FALSE;
					(!$data['orcatrata']['ValorExtraOrca']) ? $data['orcatrata']['ValorExtraOrca'] = '0.00' : FALSE;
					(!$data['orcatrata']['ValorRestanteOrca']) ? $data['orcatrata']['ValorRestanteOrca'] = '0.00' : FALSE;
					(!$data['orcatrata']['ValorSomaOrca']) ? $data['orcatrata']['ValorSomaOrca'] = '0.00' : FALSE;
					(!$data['orcatrata']['ValorTotalOrca']) ? $data['orcatrata']['ValorTotalOrca'] = '0.00' : FALSE;
					(!$data['orcatrata']['PercExtraOrca']) ? $data['orcatrata']['PercExtraOrca'] = '0.00' : FALSE;
					(!$data['orcatrata']['DescPercOrca']) ? $data['orcatrata']['DescPercOrca'] = '0.00' : FALSE;
					(!$data['orcatrata']['DescValorOrca']) ? $data['orcatrata']['DescValorOrca'] = '0.00' : FALSE;
					(!$data['orcatrata']['CashBackOrca']) ? $data['orcatrata']['CashBackOrca'] = '0.00' : FALSE;
					(!$data['orcatrata']['ValidadeCashBackOrca']) ? $data['orcatrata']['ValidadeCashBackOrca'] = date('d/m/Y', time()) : FALSE;
					(!$data['orcatrata']['SubValorFinal']) ? $data['orcatrata']['SubValorFinal'] = '0.00' : FALSE;
					(!$data['orcatrata']['ValorFinalOrca']) ? $data['orcatrata']['ValorFinalOrca'] = '0.00' : FALSE;
					(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
					(!$data['orcatrata']['Entregador']) ? $data['orcatrata']['Entregador'] = '0' : FALSE;
					(!$data['orcatrata']['idApp_ClientePet']) ? $data['orcatrata']['idApp_ClientePet'] = '0' : FALSE;
					(!$data['orcatrata']['idApp_ClienteDep']) ? $data['orcatrata']['idApp_ClienteDep'] = '0' : FALSE;
					(!$data['orcatrata']['PrazoCorreios']) ? $data['orcatrata']['PrazoCorreios'] = '0' : FALSE;
					(!$data['orcatrata']['ValorDinheiro']) ? $data['orcatrata']['ValorDinheiro'] = '0.00' : FALSE;
					(!$data['orcatrata']['ValorFrete']) ? $data['orcatrata']['ValorFrete'] = '0.00' : FALSE;
					(!$data['orcatrata']['PrazoProdServ']) ? $data['orcatrata']['PrazoProdServ'] = '0' : FALSE;
					(!$data['orcatrata']['TipoDescOrca']) ? $data['orcatrata']['TipoDescOrca'] = 'V' : FALSE;
					(!$data['orcatrata']['TipoExtraOrca']) ? $data['orcatrata']['TipoExtraOrca'] = 'V' : FALSE; 
					(!$data['orcatrata']['UsarCashBack']) ? $data['orcatrata']['UsarCashBack'] = 'N' : FALSE;
					(!$data['orcatrata']['UsarCupom']) ? $data['orcatrata']['UsarCupom'] = 'N' : FALSE;
					(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
					(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
					(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;
					(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
					(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;		
					(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
					(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
					(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;       
					(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
					(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
					(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
					(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
					(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
					(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
					(!$data['cadastrar']['StatusProdutos']) ? $data['cadastrar']['StatusProdutos'] = 'N' : FALSE;
					(!$data['cadastrar']['StatusParcelas']) ? $data['cadastrar']['StatusParcelas'] = 'N' : FALSE;
					(!$data['cadastrar']['ValidaCupom']) ? $data['cadastrar']['ValidaCupom'] = '0' : FALSE;
					
					$j = 1;
					for ($i = 1; $i <= $data['count']['SCount']; $i++) {

						if ($this->input->post('idTab_Servico' . $i)) {
							$data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
							$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
							$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
							$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
							$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
							$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
							$data['servico'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoServico' . $i);
							$data['servico'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackServico' . $i);
							$data['servico'][$j]['PrazoProduto'] = $this->input->post('PrazoServico' . $i);
							$data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
							$data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
							$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
							$data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
							$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
							$data['servico'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoServico' . $i);
							$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackServico' . $i);
							$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
							$data['servico'][$j]['ValorComissaoServico'] = $this->input->post('ValorComissaoServico' . $i);
							$data['servico'][$j]['ObsProduto'] = $this->input->post('ObsServico' . $i);
							$data['servico'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeServico' . $i);
							$data['servico'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoServico' . $i);
							$data['servico'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoServico' . $i);
							$data['servico'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoServico' . $i);
							
							$data['servico'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalServico_1' . $i);
							if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
								$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
							}else{
								$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
							}				
							$data['servico'][$j]['ProfissionalProduto_2'] = $this->input->post('ProfissionalServico_2' . $i);
							if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
								$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
							}else{
								$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
							}
							$data['servico'][$j]['ProfissionalProduto_3'] = $this->input->post('ProfissionalServico_3' . $i);
							if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
								$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
							}else{
								$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
							}
							$data['servico'][$j]['ProfissionalProduto_4'] = $this->input->post('ProfissionalServico_4' . $i);
							if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
								$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
							}else{
								$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
							}
							$data['servico'][$j]['ProfissionalProduto_5'] = $this->input->post('ProfissionalServico_5' . $i);
							if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
								$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
							}else{
								$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
							}
							$data['servico'][$j]['ProfissionalProduto_6'] = $this->input->post('ProfissionalServico_6' . $i);
							if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
								$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
							}else{
								$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
							}
							
							$data['servico'][$j]['idTFProf_1'] = $this->input->post('idTFProf_Servico_1' . $i);
							$data['servico'][$j]['ComFunProf_1'] = $this->input->post('ComFunProf_Servico_1' . $i);
							$data['servico'][$j]['ValorComProf_1'] = $this->input->post('ValorComProf_Servico_1' . $i);
							
							$data['servico'][$j]['idTFProf_2'] = $this->input->post('idTFProf_Servico_2' . $i);
							$data['servico'][$j]['ComFunProf_2'] = $this->input->post('ComFunProf_Servico_2' . $i);
							$data['servico'][$j]['ValorComProf_2'] = $this->input->post('ValorComProf_Servico_2' . $i);
							
							$data['servico'][$j]['idTFProf_3'] = $this->input->post('idTFProf_Servico_3' . $i);
							$data['servico'][$j]['ComFunProf_3'] = $this->input->post('ComFunProf_Servico_3' . $i);
							$data['servico'][$j]['ValorComProf_3'] = $this->input->post('ValorComProf_Servico_3' . $i);
							
							$data['servico'][$j]['idTFProf_4'] = $this->input->post('idTFProf_Servico_4' . $i);
							$data['servico'][$j]['ComFunProf_4'] = $this->input->post('ComFunProf_Servico_4' . $i);
							$data['servico'][$j]['ValorComProf_4'] = $this->input->post('ValorComProf_Servico_4' . $i);
							
							$data['servico'][$j]['idTFProf_5'] = $this->input->post('idTFProf_Servico_5' . $i);
							$data['servico'][$j]['ComFunProf_5'] = $this->input->post('ComFunProf_Servico_5' . $i);
							$data['servico'][$j]['ValorComProf_5'] = $this->input->post('ValorComProf_Servico_5' . $i);
							
							$data['servico'][$j]['idTFProf_6'] = $this->input->post('idTFProf_Servico_6' . $i);
							$data['servico'][$j]['ComFunProf_6'] = $this->input->post('ComFunProf_Servico_6' . $i);
							$data['servico'][$j]['ValorComProf_6'] = $this->input->post('ValorComProf_Servico_6' . $i);
							
							(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
							$data['radio'] = array(
								'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
							);
							($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';
							
							$j++;
						}

					}
					$data['count']['SCount'] = $j - 1;

					$j = 1;
					for ($i = 1; $i <= $data['count']['PCount']; $i++) {

						if ($this->input->post('idTab_Produto' . $i)) {
							$data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
							$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
							$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
							$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
							$data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
							$data['produto'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoProduto' . $i);
							$data['produto'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackProduto' . $i);
							$data['produto'][$j]['PrazoProduto'] = $this->input->post('PrazoProduto' . $i);                
							$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
							$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
							$data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
							$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
							$data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
							$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
							$data['produto'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoProduto' . $i);
							$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackProduto' . $i);
							$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
							$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
							$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
							$data['produto'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoProduto' . $i);
							$data['produto'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoProduto' . $i);
							$data['produto'][$j]['Aux_App_Produto_1'] = $this->input->post('Aux_App_Produto_1' . $i);
							$data['produto'][$j]['Aux_App_Produto_2'] = $this->input->post('Aux_App_Produto_2' . $i);
							$data['produto'][$j]['Aux_App_Produto_3'] = $this->input->post('Aux_App_Produto_3' . $i);
							$data['produto'][$j]['Aux_App_Produto_4'] = $this->input->post('Aux_App_Produto_4' . $i);
							$data['produto'][$j]['Aux_App_Produto_5'] = $this->input->post('Aux_App_Produto_5' . $i);
							$data['produto'][$j]['HoraValidadeProduto'] = $this->input->post('HoraValidadeProduto' . $i);
							$data['produto'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoProduto' . $i);
							$data['produto'][$j]['DevolvidoProduto'] = $this->input->post('DevolvidoProduto' . $i);
							//$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
							//$data['produto'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalProduto_1' . $i);
							
							(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
							$data['radio'] = array(
								'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
							);
							($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';
							
							$j++;
						}
					}
					$data['count']['PCount'] = $j - 1;

					$j = 1;
					for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

						if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataConcluidoProcedimento' . $i) || 
								$this->input->post('Profissional' . $i) || $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
							$data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
							$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->input->post('DataConcluidoProcedimento' . $i);
							$data['procedimento'][$j]['HoraProcedimento'] = $this->input->post('HoraProcedimento' . $i);
							$data['procedimento'][$j]['HoraConcluidoProcedimento'] = $this->input->post('HoraConcluidoProcedimento' . $i);
							//$data['procedimento'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
							#$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
							$data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
							$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
							$data['procedimento'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
							$data['procedimento'][$j]['Compartilhar'] = $this->input->post('Compartilhar' . $i);
							
							(!$data['procedimento'][$j]['ConcluidoProcedimento']) ? $data['procedimento'][$j]['ConcluidoProcedimento'] = 'N' : FALSE;
							$data['radio'] = array(
								'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
							);
							($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';	
							
							$j++;
						}

					}
					$data['count']['PMCount'] = $j - 1;

					//$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorFinalOrca']);
					//$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
					$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
					$data['valortotalorca'] = floatval ($data['valortotalorca']);
					$data['somatotal'] = 0;
					
					if ($data['valortotalorca'] > 0.00 && $data['orcatrata']['QtdParcelasOrca'] >=1) {
						
						for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

							$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
							$data['somatotal'] += $data['valoredit'][$i];
							
							if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) || $this->input->post('DataVencimento' . $i)){
								$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
								$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
								$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
								//$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
								$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
								$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
								$data['parcelasrec'][$i]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
							}
							(!$data['parcelasrec'][$i]['Quitado']) ? $data['parcelasrec'][$i]['Quitado'] = 'N' : FALSE;
							$data['radio'] = array(
								'Quitado' . $i => $this->basico->radio_checked($data['parcelasrec'][$i]['Quitado'], 'Quitado' . $i, 'NS'),
							);
							($data['parcelasrec'][$i]['Quitado'] == 'S') ? $data['div']['Quitado' . $i] = '' : $data['div']['Quitado' . $i] = 'style="display: none;"';
						}
						
					}
					
					/*
					if ($data['orcatrata']['ValorTotalOrca'] > 0) {

						for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

							if ($this->input->post('ValorParcela' . $i) > 0 && $this->input->post('ValorParcela' . $i) != ''){
								$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
								$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
								$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
								$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
								$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
								$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
								$data['parcelasrec'][$i]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
							}
							(!$data['parcelasrec'][$i]['Quitado']) ? $data['parcelasrec'][$i]['Quitado'] = 'N' : FALSE;
							$data['radio'] = array(
								'Quitado' . $i => $this->basico->radio_checked($data['parcelasrec'][$i]['Quitado'], 'Quitado' . $i, 'NS'),
							);
							($data['parcelasrec'][$i]['Quitado'] == 'S') ? $data['div']['Quitado' . $i] = '' : $data['div']['Quitado' . $i] = 'style="display: none;"';
					   
						}

					}
					*/

					//Fim do trecho de c�digo que d� pra melhorar
							
					$data['select']['TipoDescOrca'] = array (
						'P' => '.%',
						'V' => 'R$',
					);		
					$data['select']['TipoExtraOrca'] = array (
						'P' => '.%',
						'V' => 'R$',
					);			
					$data['select']['UsarCashBack'] = $this->Basico_model->select_status_sn();
					$data['select']['UsarCupom'] = $this->Basico_model->select_status_sn();
					$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
					$data['select']['StatusProdutos'] = $this->Basico_model->select_status_sn();
					$data['select']['StatusParcelas'] = $this->Basico_model->select_status_sn();
					$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
					$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
					$data['select']['Entrega_Orca'] = $this->Basico_model->select_status_sn();
					$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
					$data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
					$data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
					$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
					$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
					$data['select']['FormaPagamentoParcela'] = $this->Formapag_model->select_formapag();
					$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['DevolvidoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['ProntoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
					$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
					$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
					$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
					$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
					$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['Quitado'] = $this->Basico_model->select_status_sn();
					$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
					$data['select']['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
					$data['select']['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
					$data['select']['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
					$data['select']['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
					$data['select']['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
					$data['select']['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
					//$data['select']['ProfissionalProduto_1'] = $this->Usuario_model->select_usuario();
					$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
					$data['select']['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos();
					$data['select']['Produto'] = $this->Basico_model->select_produtos3($data['orcatrata']['Tipo_Orca']);
					$data['select']['Servico'] = $this->Basico_model->select_servicos3($data['orcatrata']['Tipo_Orca']);
					#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
					$data['select']['AVAP'] = $this->Basico_model->select_avap();
					$data['select']['TipoFrete'] = $this->Basico_model->select_tipofrete();
					$data['select']['Entregador'] = $this->Usuario_model->select_usuario_entregador();
					$data['select']['Prioridade'] = array (
						'1' => 'Alta',
						'2' => 'M�dia',
						'3' => 'Baixa',
					);
					
					$data['titulo'] = 'Nova Receita';
					$data['form_open_path'] = 'orcatrata/cadastrarrepet';
					$data['readonly'] = '';
					$data['disabled'] = '';
					$data['panel'] = 'primary';
					$data['metodo'] = 1;
					$data['caminho'] = '../../';
					$data['caminho2'] = '../';
					
				//////////////////////corrigir esta parte sobre o numero de repetic�oes	
					
					//$data['Recorrencias'] = $_SESSION['Consulta']['OS'];
					$data['Recorrencias'] = $data['orcatrata']['RecorrenciasOrca'];
					
					$data['Recorrencias_outras'] = $data['Recorrencias'] - 1;
					
					$data['exibir_id'] = 0;
					
					$data['exibirExtraOrca'] = 1;
					$data['exibirDescOrca'] = 1;
					
					$data['AtivoCashBack'] = 'S';
					
					//$data['vinculadas'] = $_SESSION['Consulta']['OS'] - 1;
					$data['vinculadas'] = $data['Recorrencias'] - 1;
					
					if ($data['vinculadas'] > 0){
						$data['textoEntregues'] = '';
						$data['textoPagas'] = '';
					}else{
						$data['textoEntregues'] = 'style="display: none;"';
						$data['textoPagas'] = 'style="display: none;"';
					}
					
					if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorRestanteOrca'])
						$data['orcamentoin'] = 'in';
					else
						$data['orcamentoin'] = '';

					if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
						$data['parcelasin'] = 'in';
					else
						$data['parcelasin'] = '';

					//if ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional'])
					if (isset($data['procedimento']))
						$data['tratamentosin'] = 'in';
					else
						$data['tratamentosin'] = '';

					
					$data['collapse'] = '';	

					$data['collapse1'] = 'class="collapse"';	
					
					if ($_SESSION['log']['NivelEmpresa'] >= '4' )
						$data['visivel'] = '';
					else
						$data['visivel'] = 'style="display: none;"';		
				
					#Ver uma solu��o melhor para este campo
					(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
					(!$data['orcatrata']['TipoFinanceiro']) ? $data['orcatrata']['TipoFinanceiro'] = '31' : FALSE;
					
					#(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
					($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
					
					/*
					$data['radio'] = array(
						'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
					);
					($data['orcatrata']['AVAP'] == 'P') ?
						$data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
					*/

					($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
					
					$data['radio'] = array(
						'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
					);
					($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Finalizado', 'NS'),
					);
					($data['orcatrata']['FinalizadoOrca'] == 'N') ?
						$data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Or�amento Cancelado', 'NS'),
					);
					($data['orcatrata']['CanceladoOrca'] == 'N') ?
						$data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';		
					
					$data['radio'] = array(
						'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Pronto p/Entrega', 'NS'),
					);
					($data['orcatrata']['ProntoOrca'] == 'S') ?
						$data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
						
					$data['radio'] = array(
						'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
					);
					($data['orcatrata']['DevolvidoOrca'] == 'S') ?
						$data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';			
					
					$data['radio'] = array(
						'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
					);
					($data['cadastrar']['Cadastrar'] == 'N') ?
						$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
					
					$data['radio'] = array(
						'StatusProdutos' => $this->basico->radio_checked($data['cadastrar']['StatusProdutos'], 'StatusProdutos', 'NS'),
					);
					($data['cadastrar']['StatusProdutos'] == 'S') ?
						$data['div']['StatusProdutos'] = '' : $data['div']['StatusProdutos'] = 'style="display: none;"';		
					
					$data['radio'] = array(
						'StatusParcelas' => $this->basico->radio_checked($data['cadastrar']['StatusParcelas'], 'StatusParcelas', 'NS'),
					);
					($data['cadastrar']['StatusParcelas'] == 'S') ?
						$data['div']['StatusParcelas'] = '' : $data['div']['StatusParcelas'] = 'style="display: none;"';
						
					$data['radio'] = array(
						'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
					);
					($data['cadastrar']['AtualizaEndereco'] == 'N') ?
						$data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	
						
					$data['radio'] = array(
						'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
					);
					($data['orcatrata']['CombinadoFrete'] == 'S') ?
						$data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';

					$data['radio'] = array(
						'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
					);
					($data['orcatrata']['EnviadoOrca'] == 'S') ?
						$data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';			
						
					$data['radio'] = array(
						'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
					);
					($data['orcatrata']['AprovadoOrca'] == 'S') ?
					$data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
						
					$data['radio'] = array(
						'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Or�amento Concluido', 'NS'),
					);
					($data['orcatrata']['ConcluidoOrca'] == 'S') ?
						$data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

						
					$data['radio'] = array(
						'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
					);
					($data['orcatrata']['BrindeOrca'] == 'N') ?
						$data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';

					$data['radio'] = array(
						'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
					);
					($data['orcatrata']['QuitadoOrca'] == 'S') ?
						$data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
					);
					($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
						$data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
					);
					($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
						$data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'Entrega_Orca' => $this->basico->radio_checked($data['orcatrata']['Entrega_Orca'], 'Entrega', 'NS'),
					);
					($data['orcatrata']['Entrega_Orca'] == 'S') ?
						$data['div']['Entrega_Orca'] = '' : $data['div']['Entrega_Orca'] = 'style="display: none;"';
						
					$data['radio'] = array(
						'UsarCashBack' => $this->basico->radio_checked($data['orcatrata']['UsarCashBack'], 'UsarCashBack', 'NS'),
					);
					($data['orcatrata']['UsarCashBack'] == 'S') ?
						$data['div']['UsarCashBack'] = '' : $data['div']['UsarCashBack'] = 'style="display: none;"';	
					
					$data['radio'] = array(
						'UsarCupom' => $this->basico->radio_checked($data['orcatrata']['UsarCupom'], 'UsarCupom', 'NS'),
					);
					($data['orcatrata']['UsarCupom'] == 'S') ?
						$data['div']['UsarCupom'] = '' : $data['div']['UsarCupom'] = 'style="display: none;"';		
					
					$data['sidebar'] = 'col-sm-3 col-md-2';
					$data['main'] = 'col-sm-7 col-md-8';

					$data['datepicker'] = 'DatePicker';
					$data['timepicker'] = 'TimePicker';
					
					$data['cor_cli'] 	= 'default';
					$data['cor_cons'] 	= 'default';
					$data['cor_orca'] 	= 'warning';
					$data['cor_sac'] 	= 'default';
					$data['cor_mark'] 	= 'default';

					$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

					$data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
					
					$data['somatotal'] = floatval ($data['somatotal']);
					$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];
					
					$epsilon = 0.001;

					if(abs($data['diferenca']) < $epsilon){
						$data['diferenca'] = 0.00;
					}else{
						$data['diferenca'] = $data['diferenca'];
					}
					
					$data['diferenca'] = floatval ($data['diferenca']);		
					
					$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

					#### App_OrcaTrata ####
					
					if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
						if($data['diferenca'] < 0.00){
							$data['diferenca'] = number_format($data['diferenca'],2,",",".");
							//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
							$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
						}elseif($data['diferenca'] > 0.00){
							$data['diferenca'] = number_format($data['diferenca'],2,",",".");
							//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
							$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
						}
					}
					if ($data['valortotalorca'] <= 0.00 ) {
						$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
					}
					
					$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
					$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
					$this->form_validation->set_rules('Modalidade', 'Tipo de Recebimento', 'required|trim');		
					#$this->form_validation->set_rules('ValorRestanteOrca', 'Valor da Receita', 'required|trim');		
					$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
					$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
					$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
					$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');
					$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');	
					
					if($data['orcatrata']['TipoFrete'] !=1){
						if($data['orcatrata']['AVAP'] == 'O'){
							if($data['orcatrata']['FormaPagamento'] == '1' || $data['orcatrata']['FormaPagamento'] == '2' || $data['orcatrata']['FormaPagamento'] == '3'){
								$this->form_validation->set_rules('Cep', 'Cep', 'required|trim');
								$this->form_validation->set_rules('Logradouro', 'Endere�o', 'required|trim');
								$this->form_validation->set_rules('Numero', 'Numero', 'required|trim');
								$this->form_validation->set_rules('Bairro', 'Bairro', 'required|trim');
								$this->form_validation->set_rules('Cidade', 'Cidade', 'required|trim');
								$this->form_validation->set_rules('Estado', 'Estado', 'required|trim');
							}
						}
					}
					
					#run form validation
					if ($this->form_validation->run() === FALSE) {
						/*        
						echo '<br>';
						echo "<pre>";
						print_r($data['orcatrata']['idApp_Cliente']);
						echo '<br>';
						print_r($data['orcatrata']['idApp_ClientePet']);
						echo "</pre>";
						exit ();
						*/
						$this->load->view('orcatrata/form_orcatratarepet', $data);
					} else {

						if($this->Basico_model->get_dt_validade() === FALSE){
							$data['msg'] = '?m=3';
							redirect(base_url() . 'orcatrata/cadastrarrepet/' . $_SESSION['Cliente']['idApp_Cliente'] . '/' . $_SESSION['Consulta']['Repeticao'] . $data['msg']);

						} else {
						
							////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
							#### App_OrcaTrata ####
							if ($data['orcatrata']['Entrega_Orca'] == "S") {	
								if ($data['orcatrata']['TipoFrete'] == '1') {
									$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
									$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
									$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
									$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
									$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
									$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
									$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
									$data['orcatrata']['Referencia'] = '';
								} else {	
									$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
									$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
									$data['orcatrata']['Numero'] = trim(mb_strtoupper($numero1, 'ISO-8859-1'));
									$data['orcatrata']['Complemento'] = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));
									$data['orcatrata']['Bairro'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
									$data['orcatrata']['Cidade'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
									$data['orcatrata']['Estado'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));
									$data['orcatrata']['Referencia'] = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));
								}
							} else {
								$data['orcatrata']['Cep'] = '';
								$data['orcatrata']['Logradouro'] = '';
								$data['orcatrata']['Numero'] = '';
								$data['orcatrata']['Complemento'] = '';
								$data['orcatrata']['Bairro'] = '';
								$data['orcatrata']['Cidade'] = '';
								$data['orcatrata']['Estado'] = '';
								$data['orcatrata']['Referencia'] = '';
							}
							$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
							$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
							$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
							$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
							$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));
							$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
							$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
							//$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
							//$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
							//$data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
							//$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
							$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
							$data['orcatrata']['Tipo_Orca'] = "B";
							/*
							if ($data['cadastrar']['StatusParcelas'] == 'S'){
								$data['orcatrata']['QuitadoOrca'] = "S";
							}
							*/
							
							if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
								$data['orcatrata']['ConcluidoOrca'] = "S";
								$data['orcatrata']['QuitadoOrca'] = "S";
							} 
							if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['FinalizadoOrca'] = "S";
								$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
							} 
							if($data['orcatrata']['ConcluidoOrca'] == 'S'){
								$data['orcatrata']['CombinadoFrete'] = "S";
							} 
							if($data['orcatrata']['QuitadoOrca'] == 'S'){
								$data['orcatrata']['AprovadoOrca'] = "S";
							} 
							if ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
								$data['orcatrata']['EnviadoOrca'] = "S";
							}
							
							$data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
							$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
							$data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
							//$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
							//$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
							if($data['orcatrata']['FormaPagamento'] == "7"){
								$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
								$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
							}else{
								$data['orcatrata']['ValorDinheiro'] = 0.00;
								$data['orcatrata']['ValorTroco'] = 0.00;
							}
							$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
							$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
							$data['orcatrata']['PercExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['PercExtraOrca']));
							
							$data['orcatrata']['DescPercOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescPercOrca']));
							$data['orcatrata']['DescValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescValorOrca']));
							$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
							$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'mysql');
							$data['CashBackAtual'] = $data['orcatrata']['CashBackOrca'];
							$data['ValidadeAtual'] = $data['orcatrata']['ValidadeCashBackOrca'];
							if($data['orcatrata']['UsarCashBack'] == "N"){
								$data['orcatrata']['CashBackOrca'] = 0.00;
								$data['orcatrata']['ValidadeCashBackOrca'] = "0000-00-00";
							}
							/*
							if($data['orcatrata']['UsarCashBack'] == "S"){
								$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
							}else{
								$data['orcatrata']['CashBackOrca'] = 0.00;
							}
							*/
							$data['orcatrata']['ValorFinalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
							
							$data['orcatrata']['SubValorFinal'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['SubValorFinal']));
							$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
							$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
							$data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
							
							$data['orcatrata']['idTab_TipoRD'] 	= "2";
							$data['orcatrata']['NivelOrca'] 	= $_SESSION['Consulta']['NivelAgenda'];
							$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
							$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
							$data['orcatrata']['id_Funcionario'] = $_SESSION['log']['idSis_Usuario'];
							$data['orcatrata']['id_Associado'] 	= 0;
							$data['orcatrata']['idTab_Modulo'] 	= $_SESSION['log']['idTab_Modulo'];
							$data['orcatrata']['Cli_Forn_Orca'] = 'S';

							if($data['orcatrata']['Entrega_Orca'] == "N"){
								$data['orcatrata']['DataEntregaOrca'] = $data['orcatrata']['DataOrca'];
								$data['orcatrata']['HoraEntregaOrca'] = "00:00:00";
								$data['orcatrata']['PrazoProdServ'] = 0;
								$data['orcatrata']['PrazoCorreios'] = 0;
								$data['orcatrata']['PrazoEntrega'] = 0;
							}
							
							if (!$data['orcatrata']['PrazoEntrega']){
								//$data1 = date('Y-m-d', time());
								$data1 = $data['orcatrata']['DataOrca'];
								$data2 = $data['orcatrata']['DataEntregaOrca'];
								$intervalo = strtotime($data2)-strtotime($data1); 
								$dias = floor($intervalo / (60 * 60 * 24));
								$data['orcatrata']['PrazoEntrega'] = $dias;
							}
			
							$data['orcatrata']['ValorFatura'] = $data['orcatrata']['ValorFinalOrca'];
							
							if($data['orcatrata']['AVAP'] == "O" && ($data['orcatrata']['FormaPagamento'] == "1" || $data['orcatrata']['FormaPagamento'] == "2" || $data['orcatrata']['FormaPagamento'] == "3")){
								$data['orcatrata']['ValorGateway'] = ($data['orcatrata']['ValorFatura'] * 0.04) + 0.40;
							}else{
								$data['orcatrata']['ValorGateway'] = 0.00;
							}
							$data['orcatrata']['ValorEmpresa'] = $data['orcatrata']['ValorFatura'] - $data['orcatrata']['ValorComissao'] - $data['orcatrata']['ValorGateway'];
							
							$data['redirect'] = '&gtd=' . $data['orcatrata']['DataEntregaOrca']; 
							
							//$data['orcatrata']['RecorrenciasOrca']  =  $_SESSION['Consulta']['OS'];
							$data['orcatrata']['RepeticaoCons'] 	= $_SESSION['Consulta']['Repeticao'];
							
							if ($data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['UsarCashBack'] == 'S' && $data['orcatrata']['idApp_Cliente'] != 0){
								$data['orcatrata']['AtivoCashBack'] = 'N';
							}
										
							if($data['orcatrata']['UsarCupom'] == "S"){
								$data['orcatrata']['TipoDescOrca'] = $data['cadastrar']['UsarE'];
								if($data['cadastrar']['ValidaCupom'] == 0 || !$data['orcatrata']['Cupom'] || empty($data['orcatrata']['Cupom'])){
									$data['orcatrata']['Cupom'] = 0;
								}
							}else{
								$data['orcatrata']['Cupom'] = 0;
							}

							### pego o Valor da Comiss�o do Funcion�rio ###
							if($_SESSION['Usuario']['Nivel'] != 2){
								$data['orcatrata']['ComissaoFunc'] = $_SESSION['Usuario']['Comissao'];
							}else{
								$data['Funcionario'] = $this->Usuario_model->get_funcionario($_SESSION['Usuario']['QuemCad']);
								if($data['Funcionario'] !== FALSE){
									$data['orcatrata']['ComissaoFunc'] = $data['Funcionario']['Comissao'];
								}else{
									$data['orcatrata']['ComissaoFunc'] = 0;
								}
							}
							$data['orcatrata']['ValorComissaoFunc'] = 0;
							$data['orcatrata']['ValorComissaoAssoc'] = 0;

							/*
							echo '<br>';
							echo "<pre>";
							print_r($data['orcatrata']['ComissaoFunc']);
							echo '<br>';
							print_r($data['Funcionario']);
							echo "</pre>";
							exit ();
							*/
							
							$data['orcatrata']['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['orcatrata']);

							if ($data['orcatrata']['idApp_OrcaTrata'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

								$this->basico->erro($msg);
								$this->load->view('orcatrata/form_orcatratarepet', $data);
							} else {
							
								#### APP_Cliente ####
								if ($data['cadastrar']['AtualizaEndereco'] == 'S' && $data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['Entrega_Orca'] == "S" && $data['orcatrata']['idApp_Cliente'] != 0){
									$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
									$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
									$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
									$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
									$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
									$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
									$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
									$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
												
									$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
									$data['update']['cliente']['campos'] = array_keys($data['cliente']);
									/*
									$data['update']['cliente']['auditoriaitem'] = $this->basico->set_log(
										$data['update']['cliente']['anterior'],
										$data['cliente'],
										$data['update']['cliente']['campos'],
										$data['cliente']['idApp_Cliente'], TRUE);
									*/	
									$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);

									
								}
								
								//in�cio do c�digo que ser� desligado. N�o preciso dizer qual produto foi pago o cashback
								/*
								if ($data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['UsarCashBack'] == 'S' && $data['orcatrata']['idApp_Cliente'] != 0){
									$data['update']['cashback'] = $this->Orcatrata_model->get_produto_cashback($data['orcatrata']['idApp_Cliente']);
									if (isset($data['update']['cashback'])){
										$count_cash = count($data['update']['cashback']);
										for($k=0;$k<$count_cash;$k++) {
											
											$data['update']['cashback'][$k]['StatusComissaoCashBack'] = 'S';
											$data['update']['cashback'][$k]['DataPagoCashBack'] = $data['orcatrata']['DataOrca'];
											$data['update']['cashback'][$k]['id_Orca_CashBack'] = $data['orcatrata']['idApp_OrcaTrata'];
											
											$data['update']['cashback']['bd'] = $this->Orcatrata_model->update_produto_id($data['update']['cashback'][$k], $data['update']['cashback'][$k]['idApp_Produto']);
										
										
										}
									}
								}
								*/
								//fim do c�digo que ser� desligado
								
								/*
								//echo count($data['servico']);
								echo '<br>';
								echo "<pre>";
								print_r($data['cliente']);
								echo "</pre>";
								exit ();
								*/			
								
								$data['CashBackServicos'] = 0;
								$data['ComAssocServicos'] = 0;
								$data['ComFuncServicos'] = 0;
								#### App_Servico ####
								if (isset($data['servico'])) {
									$max = count($data['servico']);
									for($j=1;$j<=$max;$j++) {
										
										$data['servico'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
										$data['servico'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
										$data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
										$data['servico'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
										$data['servico'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
										$data['servico'][$j]['idTab_TipoRD'] = "2";
										$data['servico'][$j]['NivelProduto'] = $data['orcatrata']['NivelOrca'];

										if(!$data['servico'][$j]['ProfissionalProduto_1']){
											$data['servico'][$j]['ProfissionalProduto_1'] = 0;
										}
										if(!$data['servico'][$j]['ProfissionalProduto_2']){
											$data['servico'][$j]['ProfissionalProduto_2'] = 0;
										}
										if(!$data['servico'][$j]['ProfissionalProduto_3']){
											$data['servico'][$j]['ProfissionalProduto_3'] = 0;
										}
										if(!$data['servico'][$j]['ProfissionalProduto_4']){
											$data['servico'][$j]['ProfissionalProduto_4'] = 0;
										}
										if(!$data['servico'][$j]['ProfissionalProduto_5']){
											$data['servico'][$j]['ProfissionalProduto_5'] = 0;
										}
										if(!$data['servico'][$j]['ProfissionalProduto_6']){
											$data['servico'][$j]['ProfissionalProduto_6'] = 0;
										}
										
										if(empty($data['servico'][$j]['ValorProduto'])){
											$data['servico'][$j]['ValorProduto'] = "0.00";
										}else{
											$data['servico'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorProduto']));
										}
										
										if(empty($data['servico'][$j]['ValorComProf_1'])){
											$data['servico'][$j]['ValorComProf_1'] = "0.00";
										}else{
											$data['servico'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_1']));
										}
										
										if(empty($data['servico'][$j]['ValorComProf_2'])){
											$data['servico'][$j]['ValorComProf_2'] = "0.00";
										}else{
											$data['servico'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_2']));
										}
										
										if(empty($data['servico'][$j]['ValorComProf_3'])){
											$data['servico'][$j]['ValorComProf_3'] = "0.00";
										}else{
											$data['servico'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_3']));
										}
										
										if(empty($data['servico'][$j]['ValorComProf_4'])){
											$data['servico'][$j]['ValorComProf_4'] = "0.00";
										}else{
											$data['servico'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_4']));
										}
										
										if(empty($data['servico'][$j]['ValorComProf_5'])){
											$data['servico'][$j]['ValorComProf_5'] = "0.00";
										}else{
											$data['servico'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_5']));
										}
										
										if(empty($data['servico'][$j]['ValorComProf_6'])){
											$data['servico'][$j]['ValorComProf_6'] = "0.00";
										}else{
											$data['servico'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_6']));
										}
										
										if(empty($data['servico'][$j]['ValorComissaoServico'])){
											$data['servico'][$j]['ValorComissaoServico'] = "0.00";
										}else{
											$data['servico'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComissaoServico']));
										}
																	
										$data['servico'][$j]['ValorComissaoVenda'] = $data['servico'][$j]['SubtotalComissaoProduto'];
										
										//$data['servico'][$j]['ValorComissaoServico'] = $data['servico'][$j]['SubtotalComissaoServicoProduto'];
										$data['servico'][$j]['ValorComissaoAssociado'] = $data['servico'][$j]['SubtotalComissaoServicoProduto'];
										$data['ComAssocServicos'] += $data['servico'][$j]['ValorComissaoAssociado'];

										$data['servico'][$j]['ValorComissaoFuncionario'] = $data['servico'][$j]['QtdProduto']*$data['servico'][$j]['ValorProduto']*$data['orcatrata']['ComissaoFunc']/100;
										$data['ComFuncServicos'] += $data['servico'][$j]['ValorComissaoFuncionario'];

										$data['servico'][$j]['ValorComissaoCashBack'] = $data['servico'][$j]['SubtotalComissaoCashBackProduto'];
										$data['CashBackServicos'] += $data['servico'][$j]['ValorComissaoCashBack'];

										if(!$data['servico'][$j]['DataValidadeProduto'] || $data['servico'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['servico'][$j]['DataValidadeProduto'])){
											$data['servico'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
										}else{
											$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'mysql');
										}
																
										if(!$data['servico'][$j]['DataConcluidoProduto'] || $data['servico'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['servico'][$j]['DataConcluidoProduto'])){
											$data['servico'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
										}else{
											$data['servico'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataConcluidoProduto'], 'mysql');
										}
										
										if(!$data['servico'][$j]['HoraConcluidoProduto'] || $data['servico'][$j]['HoraConcluidoProduto'] == "00:00"){
											$data['servico'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
										}else{
											$data['servico'][$j]['HoraConcluidoProduto'] = $data['servico'][$j]['HoraConcluidoProduto'];
										}
										
										if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
											$data['servico'][$j]['ConcluidoProduto'] = 'S';
										}else{
											$data['servico'][$j]['ConcluidoProduto'] = $data['servico'][$j]['ConcluidoProduto'];
										}
										/*
										if ($data['servico'][$j]['ConcluidoProduto'] == 'S') {
											if(!$data['servico'][$j]['DataConcluidoProduto']){
												$data['servico'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
											}else{
												$data['servico'][$j]['DataConcluidoProduto'] = $data['servico'][$j]['DataConcluidoProduto'];
											}
											if(!$data['servico'][$j]['HoraConcluidoProduto'] || $data['servico'][$j]['HoraConcluidoProduto'] == "00:00"){
												$data['servico'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
											}else{
												$data['servico'][$j]['HoraConcluidoProduto'] = $data['servico'][$j]['HoraConcluidoProduto'];
											}
										}else{
											$data['servico'][$j]['DataConcluidoProduto'] = "0000-00-00";
											$data['servico'][$j]['HoraConcluidoProduto'] = "00:00";
										}
										*/
										unset($data['servico'][$j]['SubtotalProduto']);
										unset($data['servico'][$j]['SubtotalComissaoProduto']);
										unset($data['servico'][$j]['SubtotalComissaoServicoProduto']);
										unset($data['servico'][$j]['SubtotalComissaoCashBackProduto']);
										unset($data['servico'][$j]['SubtotalQtdProduto']);	
									}
									$data['servico']['idApp_Produto'] = $this->Orcatrata_model->set_servico($data['servico']);
								}

								$data['CashBackProdutos'] = 0;
								$data['ComAssocProdutos'] = 0;
								$data['ComFuncProdutos'] = 0;
								#### App_Produto ####
								if (isset($data['produto'])) {
									$max = count($data['produto']);
									for($j=1;$j<=$max;$j++) {
										
										$data['produto'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
										$data['produto'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
										$data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
										$data['produto'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
										$data['produto'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
										$data['produto'][$j]['idTab_TipoRD'] = "2";
										$data['produto'][$j]['NivelProduto'] = $data['orcatrata']['NivelOrca'];

										if(empty($data['produto'][$j]['ValorProduto'])){
											$data['produto'][$j]['ValorProduto'] = "0.00";
										}else{
											$data['produto'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorProduto']));
										}
										
										$data['produto'][$j]['ValorComissaoVenda'] = $data['produto'][$j]['SubtotalComissaoProduto'];
										
										//$data['produto'][$j]['ValorComissaoServico'] = $data['produto'][$j]['SubtotalComissaoServicoProduto'];
										$data['produto'][$j]['ValorComissaoAssociado'] = $data['produto'][$j]['SubtotalComissaoServicoProduto'];
										$data['ComAssocProdutos'] += $data['produto'][$j]['ValorComissaoAssociado'];

										$data['produto'][$j]['ValorComissaoFuncionario'] = $data['produto'][$j]['QtdProduto']*$data['produto'][$j]['ValorProduto']*$data['orcatrata']['ComissaoFunc']/100;
										$data['ComFuncProdutos'] += $data['produto'][$j]['ValorComissaoFuncionario'];

										$data['produto'][$j]['ValorComissaoCashBack'] = $data['produto'][$j]['SubtotalComissaoCashBackProduto'];
										$data['CashBackProdutos'] += $data['produto'][$j]['ValorComissaoCashBack'];

										if(!$data['produto'][$j]['DataValidadeProduto'] || $data['produto'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['produto'][$j]['DataValidadeProduto'])){
											$data['produto'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
										}else{
											$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'mysql');
										}
																
										if(!$data['produto'][$j]['DataConcluidoProduto'] || $data['produto'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['produto'][$j]['DataConcluidoProduto'])){
											$data['produto'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
										}else{
											$data['produto'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataConcluidoProduto'], 'mysql');
										}
										
										if(!$data['produto'][$j]['HoraConcluidoProduto'] || $data['produto'][$j]['HoraConcluidoProduto'] == "00:00"){
											$data['produto'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
										}else{
											$data['produto'][$j]['HoraConcluidoProduto'] = $data['produto'][$j]['HoraConcluidoProduto'];
										}
																
										if ($data['orcatrata']['ConcluidoOrca'] == 'S') {
											$data['produto'][$j]['ConcluidoProduto'] = 'S';
										}else{
											$data['produto'][$j]['ConcluidoProduto'] = $data['produto'][$j]['ConcluidoProduto'];
										}
										/*
										if ($data['produto'][$j]['ConcluidoProduto'] == 'S') {
											if(!$data['produto'][$j]['DataConcluidoProduto']){
												$data['produto'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
											}else{
												$data['produto'][$j]['DataConcluidoProduto'] = $data['produto'][$j]['DataConcluidoProduto'];
											}
											if(!$data['produto'][$j]['HoraConcluidoProduto'] || $data['produto'][$j]['HoraConcluidoProduto'] == "00:00"){
												$data['produto'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
											}else{
												$data['produto'][$j]['HoraConcluidoProduto'] = $data['produto'][$j]['HoraConcluidoProduto'];
											}
										}else{
											$data['produto'][$j]['DataConcluidoProduto'] = "0000-00-00";
											$data['produto'][$j]['HoraConcluidoProduto'] = "00:00";
										}
										*/
										if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
											$data['produto'][$j]['DevolvidoProduto'] = 'S';
										} else {
											$data['produto'][$j]['DevolvidoProduto'] = $data['produto'][$j]['DevolvidoProduto'];
										}
										unset($data['produto'][$j]['SubtotalProduto']);
										unset($data['produto'][$j]['SubtotalComissaoProduto']);
										unset($data['produto'][$j]['SubtotalComissaoServicoProduto']);
										unset($data['produto'][$j]['SubtotalComissaoCashBackProduto']);
										unset($data['produto'][$j]['SubtotalQtdProduto']);
									}
									$data['produto']['idApp_Produto'] = $this->Orcatrata_model->set_produto($data['produto']);
								}

								#### App_ParcelasRec ####
								if (isset($data['parcelasrec'])) {
									$max = count($data['parcelasrec']);
									for($j=1;$j<=$max;$j++) {
										$data['parcelasrec'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
										$data['parcelasrec'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
										$data['parcelasrec'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
										$data['parcelasrec'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
										$data['parcelasrec'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
										$data['parcelasrec'][$j]['idTab_TipoRD'] = "2";
										$data['parcelasrec'][$j]['NivelParcela'] = $data['orcatrata']['NivelOrca'];
										
										$data['parcelasrec'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorParcela']));
										//$data['parcelasrec'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorPago']));
										$data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'mysql');
										$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'mysql');
										if ($data['parcelasrec'][$j]['FormaPagamentoParcela']) {
											$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $data['parcelasrec'][$j]['FormaPagamentoParcela'];
										}else{
											$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
										}
										if ($data['orcatrata']['QuitadoOrca'] == 'S') {
											$data['parcelasrec'][$j]['Quitado'] = 'S';
										} else {
											$data['parcelasrec'][$j]['Quitado'] = $data['parcelasrec'][$j]['Quitado'];
										}
										if ($data['parcelasrec'][$j]['Quitado'] == 'S') {
											if (!$data['parcelasrec'][$j]['DataPago']){
												$data['parcelasrec'][$j]['DataPago'] = $data['parcelasrec'][$j]['DataVencimento'];
											} else {
												$data['parcelasrec'][$j]['DataPago'] = $data['parcelasrec'][$j]['DataPago'];
											}
											$data['parcelasrec'][$j]['DataLanc'] = date('Y-m-d', time());
										} else {
											$data['parcelasrec'][$j]['DataPago'] = "0000-00-00";
											$data['parcelasrec'][$j]['DataLanc'] = "0000-00-00";
										}
									}
									$data['parcelasrec']['idApp_Parcelas'] = $this->Orcatrata_model->set_parcelas($data['parcelasrec']);
								}

								#### App_Procedimento ####
								if (isset($data['procedimento'])) {
									$max = count($data['procedimento']);
									for($j=1;$j<=$max;$j++) {
										$data['procedimento'][$j]['TipoProcedimento'] = 2;
										$data['procedimento'][$j]['NivelProcedimento'] = $data['orcatrata']['NivelOrca'];
										$data['procedimento'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
										if(!$data['procedimento'][$j]['Compartilhar']){
											$data['procedimento'][$j]['Compartilhar'] = $_SESSION['log']['idSis_Usuario'];
										}
										$data['procedimento'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
										$data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
										$data['procedimento'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
										$data['procedimento'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
										$data['procedimento'][$j]['Profissional'] = $_SESSION['log']['idSis_Usuario'];
										$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'mysql');
										
										if(!$data['procedimento'][$j]['DataConcluidoProcedimento']){
											$data['procedimento'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
										}else{
											$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataConcluidoProcedimento'], 'mysql');
										}

									}
									$data['procedimento']['idApp_Procedimento'] = $this->Orcatrata_model->set_procedimento($data['procedimento']);
								}
						
								$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_contagem($data['orcatrata']['idApp_OrcaTrata']);
								if (isset($data['update']['produto']['posterior'])){
									$max_produto = count($data['update']['produto']['posterior']);
									if($max_produto > 0){
										$data['orcatrata']['Prd_Srv_Orca'] = "S";
									}
								}
						
								$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
								if (isset($data['update']['produto']['posterior'])){
									$max_produto = count($data['update']['produto']['posterior']);
									if($max_produto == 0){
										$data['orcatrata']['CombinadoFrete'] = "S";
										#$data['orcatrata']['AprovadoOrca'] = "S";
										$data['orcatrata']['ProntoOrca'] = "S";
										$data['orcatrata']['EnviadoOrca'] = "S";
										$data['orcatrata']['ConcluidoOrca'] = "S";
									}else{
										$data['orcatrata']['ConcluidoOrca'] = "N";
									}
								}
								
								$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
								if (isset($data['update']['parcelasrec']['posterior'])){
									$max_parcela = count($data['update']['parcelasrec']['posterior']);
									if($max_parcela == 0){
										#$data['orcatrata']['CombinadoFrete'] = "S";
										$data['orcatrata']['AprovadoOrca'] = "S";
										$data['orcatrata']['QuitadoOrca'] = "S";				
									}else{
										$data['orcatrata']['QuitadoOrca'] = "N";
									}

								}
								
								$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);
								if (isset($data['update']['produto']['posterior'])){
									$max_produto = count($data['update']['produto']['posterior']);
									if($max_produto > 0){
										$data['orcatrata']['CombinadoFrete'] = "S";
										#$data['orcatrata']['AprovadoOrca'] = "S";
									}
								}			

								$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);	
								if (isset($data['update']['parcelasrec']['posterior'])){
									$max_parcela = count($data['update']['parcelasrec']['posterior']);
									if($max_parcela > 0){
										#$data['orcatrata']['CombinadoFrete'] = "S";
										$data['orcatrata']['AprovadoOrca'] = "S";				
									}

								}

								if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
									$data['orcatrata']['AprovadoOrca'] = "S";
									$data['orcatrata']['FinalizadoOrca'] = "S";
									$data['orcatrata']['CombinadoFrete'] = "S";
									$data['orcatrata']['ProntoOrca'] = "S";
									$data['orcatrata']['EnviadoOrca'] = "S";
								}else{
									$data['orcatrata']['FinalizadoOrca'] = "N";
								}

								if($data['repeticaoorca'] > 0){
									$data['Repeticao'] = $this->Orcatrata_model->get_repeticao($_SESSION['Consulta']['Repeticao']);
									$data['orcatrata']['RepeticaoOrca'] = $data['Repeticao'][0]['RepeticaoOrca'];
									$data['orcatrata']['RecorrenciaOrca'] = "Ext";
								}else{
									$data['orcatrata']['RepeticaoOrca'] = $data['orcatrata']['idApp_OrcaTrata'];
									$data['orcatrata']['RecorrenciaOrca'] = '1/' . $data['orcatrata']['RecorrenciasOrca'];				
								}

								/*
								if ($data['cadastrar']['Repetir'] == 'S') {
								
									$data['orcatrata']['RecorrenciaOrca'] = '1/' . $data['orcatrata']['RecorrenciasOrca'];
								}else{
									$data['orcatrata']['RecorrenciaOrca'] = '1/1';
								}
								*/
								
								//exit ();
								////Fim da Cria��o das Repeti��es///////				
								
								
								$data['orcatrata']['ValorComissaoFunc'] = $data['ComFuncServicos'] + $data['ComFuncProdutos'];
								$data['orcatrata']['ValorComissaoFunc'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorComissaoFunc']));
								
								$data['orcatrata']['ValorComissaoAssoc'] = $data['ComAssocServicos'] + $data['ComAssocProdutos'];
								$data['orcatrata']['ValorComissaoAssoc'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorComissaoAssoc']));

								$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
								$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
								$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
									$data['update']['orcatrata']['anterior'],
									$data['orcatrata'],
									$data['update']['orcatrata']['campos'],
									$data['orcatrata']['idApp_OrcaTrata'], TRUE);
								$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);

								#### Verifica��o do UltimoPedido ####
								$data['update']['cliente_repeticao']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
										
								if(strtotime($data['update']['cliente_repeticao']['anterior']['UltimoPedido']) < strtotime($data['orcatrata']['DataOrca'])){
								
									$data['cliente_repeticao']['UltimoPedido'] 		= $data['orcatrata']['DataOrca'];
									$data['cliente_repeticao']['id_UltimoPedido'] 	= $data['orcatrata']['idApp_OrcaTrata'];
									$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['orcatrata']['idApp_Cliente']);
									
								}else if(strtotime($data['update']['cliente_repeticao']['anterior']['UltimoPedido']) == strtotime($data['orcatrata']['DataOrca'])){
									
									if($data['update']['cliente_repeticao']['anterior']['id_UltimoPedido'] < $data['orcatrata']['idApp_OrcaTrata']){
										
										$data['cliente_repeticao']['id_UltimoPedido'] = $data['orcatrata']['idApp_OrcaTrata'];
										$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['orcatrata']['idApp_Cliente']);
									
									}
									
								}else{
									
									if($data['update']['cliente_repeticao']['anterior']['id_UltimoPedido'] == $data['orcatrata']['idApp_OrcaTrata']){

										$data['get_ult_pdd_cliente'] = $this->Orcatrata_model->get_ult_pdd_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
										
										$data['cliente_repeticao']['UltimoPedido'] 		= $data['get_ult_pdd_cliente']['DataOrca'];
										$data['cliente_repeticao']['id_UltimoPedido'] 	= $data['get_ult_pdd_cliente']['idApp_OrcaTrata'];
										
										$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['orcatrata']['idApp_Cliente']);
									}
									
								}
								
								#### Estoque_Produto_posterior ####
								
									
									if ($data['orcatrata']['CombinadoFrete'] == 'S' && $data['orcatrata']['CanceladoOrca'] == 'N') {
										
										$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
										
										if (count($data['busca']['estoque']['posterior']) > 0) {
											
											$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
											$max_estoque = count($data['busca']['estoque']['posterior']);
											
											if (isset($data['busca']['estoque']['posterior'])){
												
												for($j=1;$j<=$max_estoque;$j++) {
													
													$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
													
													if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
														
														$qtd_produto[$j]	= ($data['busca']['estoque']['posterior'][$j]['QtdProduto'] * $data['busca']['estoque']['posterior'][$j]['QtdIncrementoProduto']);
														
														$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] - $qtd_produto[$j]);
														
														if($diff_estoque[$j] <= 0){
															$estoque[$j] = 0; 
														}else{
															$estoque[$j] = $diff_estoque[$j]; 
														}
														
														$data['alterar']['produto']['posterior'][$j]['Estoque'] = $estoque[$j];
														$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$j], $data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
														
														unset($qtd_produto[$j]);
														unset($diff_estoque[$j]);
														unset($estoque[$j]);
													}
													
												}
												
											}
											
										}
										
									}
								
								////Inicio da Cria��o das Repeti��es///////
								$tipointervalo = 1;
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
								
								$data['cadastrar']['Repetir'] = 'S';
								
								$n = 1; //intervalo - a cada tantos dias
								
								////////////////////////////////////////////////////////////corrigir esta parte
								//$qtd = $_SESSION['Consulta']['OS'];
								$qtd = $data['orcatrata']['RecorrenciasOrca'];
								
								/*	
								echo '<br>';
								echo "<pre>";
								print_r($data['orcatrata']['RecorrenciasOrca']);
								echo '<br>';
								print_r($qtd);
								echo "</pre>";
								exit();
								*/
								
								$data['orcatrata']['RepeticaoCons'] 	= $_SESSION['Consulta']['Repeticao'];
								//$data['orcatrata']['RepeticaoOrca'] 	= $data['orcatrata']['idApp_OrcaTrata'];
								
								if($data['orcatrata']['ConcluidoOrca'] == "S"){				
									if($data['cadastrar']['StatusProdutos'] == "N"){
										$concluidoorca = "N";
										$concluidoproduto = "N";
										$dataproduto = "0000-00-00";
										$horaproduto = "00:00:00";
									}else{
										$concluidoorca = "S";
										$concluidoproduto = "S";
										$dataproduto = $data['orcatrata']['DataEntregaOrca'];
										$horaproduto = $data['orcatrata']['HoraEntregaOrca'];
									}
								}else{
									$concluidoorca = "N";
									$concluidoproduto = "N";
									$dataproduto = "0000-00-00";
									$horaproduto = "00:00:00";
								}
								
								if($data['orcatrata']['QuitadoOrca'] == "S"){	
									if($data['cadastrar']['StatusParcelas'] == "N"){
										$quitadoorca = "N";
										$quitado = "N";
										$datapago = "0000-00-00";
										$datalanc = "0000-00-00";
									}else{
										$quitadoorca = "S";
										$quitado = "S";
										$datapago = $data['orcatrata']['DataOrca'];
										$datalanc = date('Y-m-d', time());
									}
								}else{
									$quitadoorca = "N";
									$quitado = "N";
									$datapago = "0000-00-00";
									$datalanc = "0000-00-00";
								}
								
								//$combinadofrete = "N";
								//$aprovadoorca = "N";
								$prontooorca = "N";
								$enviadooorca = "N";
								$finalizadoorca = "N";
								
								if($concluidoorca == "S"){
									//$combinadofrete = "S";
									//$aprovadoorca = "S";
									$prontooorca = "S";
									$enviadooorca = "S";
									if($quitadoorca == "S"){
										//$aprovadoorca = "S";
										$finalizadoorca = "S";
									}else{
										$finalizadoorca = "N";
									}
								}else{
									if($quitadoorca == "S"){
										$finalizadoorca = "N";
										//$combinadofrete = "S";
										//$aprovadoorca = "S";
										//$prontooorca = "N";
										//$enviadooorca = "N";
									}else{
										$finalizadoorca = "N";
										//$combinadofrete = "N";
										//$aprovadoorca = "N";
										//$prontooorca = "N";
										//$enviadooorca = "N";
									}
								}

								if($data['orcatrata']['UsarCashBack'] == "S"){
									$usarcashback			= "N";
									$valorfinalorca 		= $data['orcatrata']['SubValorFinal'];
									$cashbackorca  			= 0.00;
									$validadecashbackorca  	= "0000-00-00";
									
								}else{
									$usarcashback			= $data['orcatrata']['UsarCashBack'];
									$valorfinalorca 		= $data['orcatrata']['ValorFinalOrca'];
									$cashbackorca 			= 0.00;
									$validadecashbackorca  	= "0000-00-00";
								}
												
								
								if ($data['cadastrar']['Repetir'] == 'S' && $data['orcatrata']['RecorrenciasOrca'] > 1) {
									for($j=1; $j<$qtd; $j++) {
										$data['repeticao'][$j] = array(
											//'RepeticaoOrca' 		=> $data['orcatrata']['idApp_OrcaTrata'],
											'RepeticaoOrca' 		=> $data['orcatrata']['RepeticaoOrca'],
											'RepeticaoCons' 		=> $data['orcatrata']['RepeticaoCons'],
											'RecorrenciasOrca' 		=> $data['orcatrata']['RecorrenciasOrca'],
											'RecorrenciaOrca' 		=> ($j + 1) .  '/' . $qtd,
											//'CombinadoFrete' 		=> $combinadofrete,
											//'AprovadoOrca' 		=> $aprovadoorca,
											'CombinadoFrete' 		=> $data['orcatrata']['CombinadoFrete'],
											'AprovadoOrca' 			=> $data['orcatrata']['AprovadoOrca'],
											'FinalizadoOrca' 		=> $finalizadoorca,
											'ProntoOrca' 			=> $prontooorca,
											'EnviadoOrca' 			=> $enviadooorca,
											'ConcluidoOrca' 		=> $concluidoorca,
											'QuitadoOrca' 			=> $quitadoorca,
											'Cli_Forn_Orca' 		=> $data['orcatrata']['Cli_Forn_Orca'],
											'Prd_Srv_Orca' 			=> $data['orcatrata']['Prd_Srv_Orca'],
											'Entrega_Orca' 			=> $data['orcatrata']['Entrega_Orca'],
											'DataOrca' 				=> $data['orcatrata']['DataOrca'],
											'HoraOrca' 				=> $data['orcatrata']['HoraOrca'],
											//'ProfissionalOrca' 		=> $data['orcatrata']['ProfissionalOrca'],
											'Entregador' 			=> $data['orcatrata']['Entregador'],
											'DevolvidoOrca' 		=> $data['orcatrata']['DevolvidoOrca'],
											'CanceladoOrca' 		=> $data['orcatrata']['CanceladoOrca'],
											//'DataConclusao' 		=> $data['orcatrata']['DataConclusao'],
											//'DataRetorno' 			=> $data['orcatrata']['DataRetorno'],
											'ValorOrca' 			=> $data['orcatrata']['ValorOrca'],
											//'ValorEntradaOrca' 		=> $data['orcatrata']['ValorEntradaOrca'],
											//'DataEntradaOrca' 		=> $data['orcatrata']['DataEntradaOrca'],
											'ValorRestanteOrca' 	=> $data['orcatrata']['ValorRestanteOrca'],
											'ValorDinheiro' 		=> $data['orcatrata']['ValorDinheiro'],
											'ValorTroco' 			=> $data['orcatrata']['ValorTroco'],
											'FormaPagamento' 		=> $data['orcatrata']['FormaPagamento'],
											'QtdParcelasOrca' 		=> $data['orcatrata']['QtdParcelasOrca'],
											'DataVencimentoOrca' 	=> $data['orcatrata']['DataVencimentoOrca'],
											'ObsOrca' 				=> $data['orcatrata']['ObsOrca'],
											'Consideracoes' 		=> $data['orcatrata']['Consideracoes'],
											//'DataPrazo' 			=> $data['orcatrata']['DataPrazo'],
											'idTab_TipoRD' 			=> $data['orcatrata']['idTab_TipoRD'],
											//'DataQuitado' 			=> $data['orcatrata']['DataQuitado'],
											'Modalidade' 			=> $data['orcatrata']['Modalidade'],
											'ValorDev' 				=> $data['orcatrata']['ValorDev'],
											'AVAP' 					=> $data['orcatrata']['AVAP'],
											'TipoFinanceiro' 		=> $data['orcatrata']['TipoFinanceiro'],
											'Tipo_Orca' 			=> $data['orcatrata']['Tipo_Orca'],
											'TipoFrete' 			=> $data['orcatrata']['TipoFrete'],
											'ValorFrete' 			=> $data['orcatrata']['ValorFrete'],
											'ValorTotalOrca' 		=> $data['orcatrata']['ValorTotalOrca'],
											
											'TipoExtraOrca' 		=> $data['orcatrata']['TipoExtraOrca'],
											'PercExtraOrca' 		=> $data['orcatrata']['PercExtraOrca'],
											'ValorExtraOrca' 		=> $data['orcatrata']['ValorExtraOrca'],
											
											'TipoDescOrca' 			=> $data['orcatrata']['TipoDescOrca'],
											'DescPercOrca' 			=> $data['orcatrata']['DescPercOrca'],
											'DescValorOrca' 		=> $data['orcatrata']['DescValorOrca'],
											'UsarCupom' 			=> $data['orcatrata']['UsarCupom'],
											'Cupom' 				=> $data['orcatrata']['Cupom'],
											'SubValorFinal' 		=> $data['orcatrata']['SubValorFinal'],
											
											'UsarCashBack' 			=> $usarcashback,
											'ValorFinalOrca' 		=> $valorfinalorca,
											'CashBackOrca' 			=> $cashbackorca,
											'ValidadeCashBackOrca' 	=> $validadecashbackorca,
											
											'BrindeOrca' 			=> $data['orcatrata']['BrindeOrca'],
											'PrazoEntrega' 			=> $data['orcatrata']['PrazoEntrega'],
											'Cep' 					=> $data['orcatrata']['Cep'],
											'Logradouro' 			=> $data['orcatrata']['Logradouro'],
											'Numero' 				=> $data['orcatrata']['Numero'],
											'Complemento' 			=> $data['orcatrata']['Complemento'],
											'Bairro' 				=> $data['orcatrata']['Bairro'],
											'Cidade' 				=> $data['orcatrata']['Cidade'],
											'Estado' 				=> $data['orcatrata']['Estado'],
											'Referencia' 			=> $data['orcatrata']['Referencia'],
											'ValorFatura' 			=> $data['orcatrata']['ValorFatura'],
											'ValorGateway' 			=> $data['orcatrata']['ValorGateway'],
											'ValorComissao' 		=> $data['orcatrata']['ValorComissao'],
											'ValorComissaoAssoc' 	=> $data['orcatrata']['ValorComissaoAssoc'],
											'ValorComissaoFunc' 	=> $data['orcatrata']['ValorComissaoFunc'],
											'ComissaoFunc' 			=> $data['orcatrata']['ComissaoFunc'],
											'ValorEmpresa' 			=> $data['orcatrata']['ValorEmpresa'],
											'QtdPrdOrca' 			=> $data['orcatrata']['QtdPrdOrca'],
											'QtdSrvOrca' 			=> $data['orcatrata']['QtdSrvOrca'],
											'NomeRec' 				=> $data['orcatrata']['NomeRec'],
											'TelefoneRec' 			=> $data['orcatrata']['TelefoneRec'],
											'ParentescoRec' 		=> $data['orcatrata']['ParentescoRec'],
											'ObsEntrega' 			=> $data['orcatrata']['ObsEntrega'],
											'Aux1Entrega' 			=> $data['orcatrata']['Aux1Entrega'],
											'Aux2Entrega' 			=> $data['orcatrata']['Aux2Entrega'],
											'DetalhadaEntrega' 		=> $data['orcatrata']['DetalhadaEntrega'],
											'id_Associado' 			=> $data['orcatrata']['id_Associado'],
											'ValorSomaOrca' 		=> $data['orcatrata']['ValorSomaOrca'],
											'PrazoProdutos' 		=> $data['orcatrata']['PrazoProdutos'],
											'PrazoServicos' 		=> $data['orcatrata']['PrazoServicos'],
											'PrazoProdServ' 		=> $data['orcatrata']['PrazoProdServ'],
											'PrazoCorreios' 		=> $data['orcatrata']['PrazoCorreios'],
											'idApp_Cliente' 		=> $data['orcatrata']['idApp_Cliente'],
											'idApp_ClienteDep' 		=> $data['orcatrata']['idApp_ClienteDep'],
											'idApp_ClientePet' 		=> $data['orcatrata']['idApp_ClientePet'],
											'Descricao' 			=> $data['orcatrata']['Descricao'],
											'idSis_Usuario' 		=> $_SESSION['log']['idSis_Usuario'],
											'idSis_Empresa' 		=> $_SESSION['log']['idSis_Empresa'],
											'idTab_Modulo' 			=> $_SESSION['log']['idTab_Modulo'],
											'NivelOrca' 			=> $data['orcatrata']['NivelOrca'],
											'HoraEntregaOrca' 		=> $data['orcatrata']['HoraEntregaOrca'],
											'DataEntregaOrca' 		=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) .  $ref,strtotime($data['orcatrata']['DataEntregaOrca'])))
										);
										$data['campos'] = array_keys($data['repeticao'][$j]);
										
										$data['id_Repeticao'] = $this->Orcatrata_model->set_orcatrata($data['repeticao'][$j]);

										#### App_Produto ####
										
										$data['update']['produto']['baixa'] = $this->Orcatrata_model->get_produto_baixa($data['orcatrata']['idApp_OrcaTrata']);
										
										if (count($data['update']['produto']['baixa']) > 0) {
											
											$data['update']['produto']['baixa'] = array_combine(range(1, count($data['update']['produto']['baixa'])), array_values($data['update']['produto']['baixa']));
											
											$max_produto = count($data['update']['produto']['baixa']);

											if (isset($data['update']['produto']['baixa'])){
												for($k=1;$k<=$max_produto;$k++) {
													$data['update']['produto']['baixa'][$k] = array(
														'idApp_OrcaTrata' 		=> $data['id_Repeticao'],
														'idApp_Cliente' 		=> $data['update']['produto']['baixa'][$k]['idApp_Cliente'],
														'idSis_Usuario' 		=> $data['update']['produto']['baixa'][$k]['idSis_Usuario'],
														'idSis_Empresa' 		=> $data['update']['produto']['baixa'][$k]['idSis_Empresa'],
														'idTab_Modulo' 			=> $data['update']['produto']['baixa'][$k]['idTab_Modulo'],
														'idTab_TipoRD' 			=> $data['update']['produto']['baixa'][$k]['idTab_TipoRD'],
														'NivelProduto'    		=> $data['orcatrata']['NivelOrca'],
														'DataValidadeProduto' 	=> $data['update']['produto']['baixa'][$k]['DataValidadeProduto'],
														'ConcluidoProduto' 		=> $concluidoproduto,
														'DataConcluidoProduto' 	=> $dataproduto,
														'HoraConcluidoProduto' 	=> $horaproduto,
														'ValorProduto'			=> $data['update']['produto']['baixa'][$k]['ValorProduto'],
														'ComissaoProduto' 		=> $data['update']['produto']['baixa'][$k]['ComissaoProduto'],
														'ComissaoServicoProduto'	=> $data['update']['produto']['baixa'][$k]['ComissaoServicoProduto'],
														'ComissaoCashBackProduto' 	=> $data['update']['produto']['baixa'][$k]['ComissaoCashBackProduto'],
														'ValorComissaoVenda' 	=> $data['update']['produto']['baixa'][$k]['ValorComissaoVenda'],
														'ValorComissaoAssociado' 	=> $data['update']['produto']['baixa'][$k]['ValorComissaoAssociado'],
														'ValorComissaoFuncionario' 	=> $data['update']['produto']['baixa'][$k]['ValorComissaoFuncionario'],
														'ValorComissaoServico' 	=> $data['update']['produto']['baixa'][$k]['ValorComissaoServico'],
														'ValorComissaoCashBack'	=> $data['update']['produto']['baixa'][$k]['ValorComissaoCashBack'],
														'NomeProduto' 			=> $data['update']['produto']['baixa'][$k]['NomeProduto'],
														'DevolvidoProduto' 		=> $data['update']['produto']['baixa'][$k]['DevolvidoProduto'],
														'idTab_Produto' 		=> $data['update']['produto']['baixa'][$k]['idTab_Produto'],
														'idTab_Valor_Produto' 	=> $data['update']['produto']['baixa'][$k]['idTab_Valor_Produto'],
														'idTab_Produtos_Produto'=> $data['update']['produto']['baixa'][$k]['idTab_Produtos_Produto'],
														'ProfissionalProduto_1' => $data['update']['produto']['baixa'][$k]['ProfissionalProduto_1'],
														'ProfissionalProduto_2' => $data['update']['produto']['baixa'][$k]['ProfissionalProduto_2'],
														'ProfissionalProduto_3' => $data['update']['produto']['baixa'][$k]['ProfissionalProduto_3'],
														'ProfissionalProduto_4' => $data['update']['produto']['baixa'][$k]['ProfissionalProduto_4'],
														'ProfissionalProduto_5' => $data['update']['produto']['baixa'][$k]['ProfissionalProduto_5'],
														'ProfissionalProduto_6' => $data['update']['produto']['baixa'][$k]['ProfissionalProduto_6'],
														'ValorComProf_1' 		=> $data['update']['produto']['baixa'][$k]['ValorComProf_1'],
														'idTFProf_1' 			=> $data['update']['produto']['baixa'][$k]['idTFProf_1'],
														'ComFunProf_1' 			=> $data['update']['produto']['baixa'][$k]['ComFunProf_1'],
														'ValorComProf_2' 		=> $data['update']['produto']['baixa'][$k]['ValorComProf_2'],
														'idTFProf_2' 			=> $data['update']['produto']['baixa'][$k]['idTFProf_2'],
														'ComFunProf_2'	 		=> $data['update']['produto']['baixa'][$k]['ComFunProf_2'],
														'ValorComProf_3' 		=> $data['update']['produto']['baixa'][$k]['ValorComProf_3'],
														'idTFProf_3' 			=> $data['update']['produto']['baixa'][$k]['idTFProf_3'],
														'ComFunProf_3' 			=> $data['update']['produto']['baixa'][$k]['ComFunProf_3'],
														'ValorComProf_4' 		=> $data['update']['produto']['baixa'][$k]['ValorComProf_4'],
														'idTFProf_4' 			=> $data['update']['produto']['baixa'][$k]['idTFProf_4'],
														'ComFunProf_4' 			=> $data['update']['produto']['baixa'][$k]['ComFunProf_4'],
														'ValorComProf_5' 		=> $data['update']['produto']['baixa'][$k]['ValorComProf_5'],
														'idTFProf_5' 			=> $data['update']['produto']['baixa'][$k]['idTFProf_5'],
														'ComFunProf_5' 			=> $data['update']['produto']['baixa'][$k]['ComFunProf_5'],
														'ValorComProf_6' 		=> $data['update']['produto']['baixa'][$k]['ValorComProf_6'],
														'idTFProf_6' 			=> $data['update']['produto']['baixa'][$k]['idTFProf_6'],
														'ComFunProf_6' 			=> $data['update']['produto']['baixa'][$k]['ComFunProf_6'],
														'QtdProduto' 			=> $data['update']['produto']['baixa'][$k]['QtdProduto'],
														'QtdIncrementoProduto' 	=> $data['update']['produto']['baixa'][$k]['QtdIncrementoProduto'],
														'ObsProduto' 			=> $data['update']['produto']['baixa'][$k]['ObsProduto'],
														'HoraValidadeProduto' 	=> $data['update']['produto']['baixa'][$k]['HoraValidadeProduto'],
														'CanceladoProduto' 		=> $data['update']['produto']['baixa'][$k]['CanceladoProduto'],
														'StatusComissaoPedido' 	=> $data['update']['produto']['baixa'][$k]['StatusComissaoPedido'],
														'Prod_Serv_Produto' 	=> $data['update']['produto']['baixa'][$k]['Prod_Serv_Produto'],
														'PrazoProduto' 			=> $data['update']['produto']['baixa'][$k]['PrazoProduto']
													
													);
												}
												$data['update']['produto']['baixa']['idApp_Produto'] = $this->Orcatrata_model->set_produto($data['update']['produto']['baixa']);
											}
											
										}
										#### App_Parcelas ####
										
										$data['update']['parcelas']['baixa'] = $this->Orcatrata_model->get_parcelas_baixa($data['orcatrata']['idApp_OrcaTrata']);
										
										if (count($data['update']['parcelas']['baixa']) > 0) {
											$data['update']['parcelas']['baixa'] = array_combine(range(1, count($data['update']['parcelas']['baixa'])), array_values($data['update']['parcelas']['baixa']));
											
											$max_parcelas = count($data['update']['parcelas']['baixa']);

											if (isset($data['update']['parcelas']['baixa'])){
												for($k=1;$k<=$max_parcelas;$k++) {
													if($data['orcatrata']['UsarCashBack'] == "S"){
														$valorparcela[$k] 	= $data['orcatrata']['SubValorFinal']/$data['orcatrata']['QtdParcelasOrca'];
														$valorpago[$k]		= $data['orcatrata']['SubValorFinal']/$data['orcatrata']['QtdParcelasOrca'];
														/*
														if($data['cadastrar']['StatusParcelas'] == "S"){
															$valorparcela[$k] 	= $data['update']['parcelas']['baixa'][$k]['ValorParcela']; 
														}else{
															$valorparcela[$k] 	= $data['orcatrata']['SubValorFinal']/$data['orcatrata']['QtdParcelasOrca'];
														}
														*/
													}else{
														$valorparcela[$k] 	= $data['update']['parcelas']['baixa'][$k]['ValorParcela'];
														$valorpago[$k] 		= $data['update']['parcelas']['baixa'][$k]['ValorParcela'];
													}
													$data['update']['parcelas']['baixa'][$k] = array(
														'idApp_OrcaTrata' 		=> $data['id_Repeticao'],
														'idApp_Cliente' 		=> $data['update']['parcelas']['baixa'][$k]['idApp_Cliente'],
														'idSis_Usuario' 		=> $data['update']['parcelas']['baixa'][$k]['idSis_Usuario'],
														'idSis_Empresa' 		=> $data['update']['parcelas']['baixa'][$k]['idSis_Empresa'],
														'idTab_Modulo' 			=> $data['update']['parcelas']['baixa'][$k]['idTab_Modulo'],
														'idTab_TipoRD' 			=> $data['update']['parcelas']['baixa'][$k]['idTab_TipoRD'],
														'NivelParcela'    		=> $data['orcatrata']['NivelOrca'],
														'Parcela' 				=> $data['update']['parcelas']['baixa'][$k]['Parcela'],
														'FormaPagamentoParcela' => $data['update']['parcelas']['baixa'][$k]['FormaPagamentoParcela'],
														
														'ValorParcela' 			=> $valorparcela[$k],
														
														'DataVencimento'		=> $data['update']['parcelas']['baixa'][$k]['DataVencimento'],
														//'ValorPago' 			=> $valorpago[$k],
														'Quitado' 				=> $quitado,
														'DataPago' 				=> $datapago,
														'DataLanc' 				=> $datalanc,
														'idApp_Fornecedor' 		=> $data['update']['parcelas']['baixa'][$k]['idApp_Fornecedor']
													
													);
												}
												$data['update']['parcelas']['baixa']['idApp_Produto'] = $this->Orcatrata_model->set_parcelas($data['update']['parcelas']['baixa']);
											}
											
										}
									}
								}
								
								$data['update']['consultas'] = $_SESSION['Consultas'];
								//$data['update']['orcamentos'] = $this->Orcatrata_model->get_orcatratas($data['orcatrata']['idApp_OrcaTrata']);
								$data['update']['orcamentos'] = $this->Orcatrata_model->get_orcatratas($data['orcatrata']['RepeticaoOrca']);// pega as OS que tem essa repeticao
								
								$cont_consultas = count($data['update']['consultas']);
								$cont_orcamentos = count($data['update']['orcamentos']);// conta quantas OS tem essa repeticao
								
								if ($cont_orcamentos > 0) {
									for($j=0;$j<$cont_orcamentos;$j++) {
										$data['idApp_OrcaTrata'][$j] = $data['update']['orcamentos'][$j]['idApp_OrcaTrata'];
									}
								}
								if ($cont_consultas > 0) {
									for($k=0;$k<$cont_consultas;$k++) {
										if($cont_consultas == $cont_orcamentos){
											$data['update']['consultas'][$k]['idApp_OrcaTrata'] = $data['idApp_OrcaTrata'][$k];
										}else{
											$data['update']['consultas'][$k]['idApp_OrcaTrata'] = $data['idApp_OrcaTrata']['0'];
										}
										$data['update']['consultas']['bd'][$k] = $this->Consulta_model->update_consulta($data['update']['consultas'][$k], $data['update']['consultas'][$k]['idApp_Consulta']);
									}				
								}
								
								if ($cont_consultas > 0) {
									for($k=0;$k<$cont_consultas;$k++) {
										$dataini[$k]	= explode(' ', $data['update']['consultas'][$k]['DataInicio']);
										$dia[$k]	 	= $dataini[$k][0];
										$hora[$k]	 	= $dataini[$k][1];
									}
								}
								
								if($data['orcatrata']['RecorrenciasOrca'] >1){
									if ($cont_orcamentos > 0) {
										
										for($j=0;$j<$cont_orcamentos;$j++) {
										
											if($cont_consultas == $cont_orcamentos){
												$data['update']['orcamentos'][$j]['DataOrca'] = $dia[$j];
												$data['update']['orcamentos'][$j]['DataVencimentoOrca'] = $dia[$j];
												$data['update']['orcamentos'][$j]['DataEntregaOrca'] = $dia[$j];
												$data['update']['orcamentos'][$j]['HoraEntregaOrca'] = $hora[$j];
											}else{
												$data['update']['orcamentos'][$j]['DataOrca'] = $dia['0'];
												$data['update']['orcamentos'][$j]['DataVencimentoOrca'] = $dia['0'];
												$data['update']['orcamentos'][$j]['DataEntregaOrca'] = $dia['0'];
												$data['update']['orcamentos'][$j]['HoraEntregaOrca'] = $hora['0'];
											}
											$data['update']['orcamentos']['bd'][$j] = $this->Orcatrata_model->update_orcatrata($data['update']['orcamentos'][$j], $data['update']['orcamentos'][$j]['idApp_OrcaTrata']);
											
											#### Verifica��o do UltimoPedido ####
											if(strtotime($data['update']['cliente_repeticao']['anterior']['UltimoPedido']) < strtotime($data['update']['orcamentos'][$j]['DataOrca'])){
											
												$data['cliente_repeticao']['UltimoPedido'] 		= $data['update']['orcamentos'][$j]['DataOrca'];
												$data['cliente_repeticao']['id_UltimoPedido'] 	= $data['update']['orcamentos'][$j]['idApp_OrcaTrata'];
												
												$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['orcatrata']['idApp_Cliente']);
												
											}else if(strtotime($data['update']['cliente_repeticao']['anterior']['UltimoPedido']) == strtotime($data['update']['orcamentos'][$j]['DataOrca'])){
												
												if($data['update']['cliente_repeticao']['anterior']['id_UltimoPedido'] < $data['update']['orcamentos'][$j]['idApp_OrcaTrata']){
													
													$data['cliente_repeticao']['id_UltimoPedido'] = $data['update']['orcamentos'][$j]['idApp_OrcaTrata'];
													
													$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['orcatrata']['idApp_Cliente']);
												
												}
												
											}else{
												
												if($data['update']['cliente_repeticao']['anterior']['id_UltimoPedido'] == $data['update']['orcamentos'][$j]['idApp_OrcaTrata']){

													$data['get_ult_pdd_cliente'] = $this->Orcatrata_model->get_ult_pdd_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
													
													$data['cliente_repeticao']['UltimoPedido'] 		= $data['get_ult_pdd_cliente']['DataOrca'];
													$data['cliente_repeticao']['id_UltimoPedido'] 	= $data['get_ult_pdd_cliente']['idApp_OrcaTrata'];
													
													$data['update']['cliente_repeticao']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_repeticao'], $data['orcatrata']['idApp_Cliente']);
												}
												
											}

										}				
									}
									
									
									if ($cont_orcamentos > 0) {
										for($j=0;$j<$cont_orcamentos;$j++) {
											$data['update']['produtos_orcamento'][$j] = $this->Orcatrata_model->get_produtos_orcamento($data['idApp_OrcaTrata'][$j]);
											$cont_produtos_orcamento = count($data['update']['produtos_orcamento'][$j]);
											for($k=0;$k<$cont_produtos_orcamento;$k++) {
												$data['update']['produtos_orcamento'][$j][$k]['DataConcluidoProduto'] = $data['update']['orcamentos'][$j]['DataEntregaOrca'];
												$data['update']['produtos_orcamento'][$j][$k]['HoraConcluidoProduto'] = $data['update']['orcamentos'][$j]['HoraEntregaOrca'];
												$data['update']['produtos_orcamento']['bd'][$j][$k] = $this->Orcatrata_model->update_produto_id($data['update']['produtos_orcamento'][$j][$k], $data['update']['produtos_orcamento'][$j][$k]['idApp_Produto']);
											}
										}
									}
									
									if ($cont_orcamentos > 0) {
										for($j=0;$j<$cont_orcamentos;$j++) {
											$data['update']['parcelas_orcamento'][$j] = $this->Orcatrata_model->get_parcelas_orcamento($data['idApp_OrcaTrata'][$j]);
											$cont_parcelas_orcamento = count($data['update']['parcelas_orcamento'][$j]);
											for($k=0;$k<$cont_parcelas_orcamento;$k++) {
												$data['update']['parcelas_orcamento'][$j][$k]['DataVencimento'] = $data['update']['orcamentos'][$j]['DataVencimentoOrca'];
												$data['update']['parcelas_orcamento']['bd'][$j][$k] = $this->Orcatrata_model->update_parcelas_id($data['update']['parcelas_orcamento'][$j][$k], $data['update']['parcelas_orcamento'][$j][$k]['idApp_Parcelas']);
											}
										}
									}

								}					
								////Fim da Cria��o das Repeti��es///////				

								
								////////// Ajustar o Valor da RecorrenciasOrca e as RecorrenciaOrca
								 /// pego a quantidade(N) de repeti��es, e refa�o a sequencia 1/N
								if(isset($cont_orcamentos) && $cont_orcamentos > 0){
									
									for($j=0;$j<$cont_orcamentos;$j++) {
										$k = (1 + $j);
										$data['update']['orcamentos'][$j]['RecorrenciasOrca'] = $cont_orcamentos;
										$data['update']['orcamentos'][$j]['RecorrenciaOrca'] = $k . "/" . $cont_orcamentos;

										$data['update']['orcamentos']['bd'][$j] = $this->Orcatrata_model->update_orcatrata($data['update']['orcamentos'][$j], $data['update']['orcamentos'][$j]['idApp_OrcaTrata']);
									}
								}				
								//////////////////////////////////////////////////////////////////

								$data['CashBackNovo'] = $data['CashBackServicos'] + $data['CashBackProdutos'];

								//Se existir Cliente  Atualizo ou n�o o valor do cashback no campo CashBackCliente do Cliente
								
									
									if(isset($data['orcatrata']['idApp_Cliente']) && $data['orcatrata']['idApp_Cliente'] !=0){
										
										if($data['orcatrata']['UsarCashBack'] == "S"){
										
											if($data['orcatrata']['QuitadoOrca'] == "S"){
												
												if($data['cadastrar']['StatusParcelas'] == "S"){
													
													//CashBackCliente = novo valor; x Recorr�ncias
													$data['cliente_cashback']['CashBackCliente'] = $data['CashBackNovo']*$data['orcatrata']['RecorrenciasOrca'];
												}else{
												
													//CashBackCliente = novo valor; 1 vez
													//$data['cliente_cashback']['CashBackCliente'] = $data['CashBackNovo'] + ($data['CashBackAtual']*$data['orcatrata']['RecorrenciasOrca']*(($data['orcatrata']['RecorrenciasOrca'] - 1)/$data['orcatrata']['RecorrenciasOrca']));
													$data['cliente_cashback']['CashBackCliente'] = $data['CashBackNovo'];
												}
												$data['cliente_cashback']['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
											
											}else{
											
												//CashBackCliente = o troco do que ficou para as outras;
												//$data['cliente_cashback']['CashBackCliente'] = ($data['CashBackAtual']*$data['orcatrata']['RecorrenciasOrca']*(($data['orcatrata']['RecorrenciasOrca'] - 1)/$data['orcatrata']['RecorrenciasOrca']));
												$data['cliente_cashback']['CashBackCliente'] = 0.00;
											}
											
										}else{
											if($data['orcatrata']['QuitadoOrca'] == "S"){
												
												if($data['cadastrar']['StatusParcelas'] == "S"){
												
													//CashBackCliente = novo valor; x Recorr�ncias
													$data['cliente_cashback']['CashBackCliente'] = $data['CashBackAtual'] + ($data['CashBackNovo']*$data['orcatrata']['RecorrenciasOrca']);
													
												}else{
												
													//CashBackCliente = novo valor; 1 vez
													$data['cliente_cashback']['CashBackCliente'] = $data['CashBackAtual'] + $data['CashBackNovo'];
												}
												$data['cliente_cashback']['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
												
											}else{
												//CashBackCliente = velho valor;
												$data['cliente_cashback']['CashBackCliente'] = $data['CashBackAtual'];
											}
											
										}
										//fa�o o update no cliente

										//$data['get_ult_pdd_cliente'] = $this->Orcatrata_model->get_ult_pdd_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
										//$data['cliente_cashback']['UltimoPedido'] = $data['get_ult_pdd_cliente']['DataOrca'];
												
										$data['update']['cliente_cashback']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
										$data['update']['cliente_cashback']['campos'] = array_keys($data['cliente_cashback']);
						
										$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);					
									
									}
								
								$data['msg'] = '?m=1';

								redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);	
								//redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
								exit();
							}
						}
					}
				}
			}	
		}
        $this->load->view('basico/footer');
    }
	
    public function cadastrar($idApp_Cliente = NULL) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Cad_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 3)
				$data['msg'] = $this->basico->msg('<strong>N�o � poss�vel salvar o novo Pedido.<br>N�o identificamos o pagamento da sua �ltima Fatura.<br>Por favor, Entre em contato com a administra��o da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
			else
				$data['msg'] = '';
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'ConcluidoProduto',
				'QuitadoParcelas',
				'Cadastrar',
				'Whatsapp',
				'Whatsapp_Site',
				'AtualizaEndereco',
				'StatusProdutos',
				'StatusParcelas',
				'PeloPet',
				'PortePet',
				'EspeciePet',
				'RacaPet',
				'RelacaoDep',
				'Valor_S_Desc',
				'Valor_C_Desc',
				'UsarC',
				'UsarD',
				'UsarE',
				'ValidaCupom',
				'MensagemCupom',
				'CodigoCupom',
			), TRUE));

			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['orcatrata'] = quotes_to_entities($this->input->post(array(
				#### App_OrcaTrata ####
				//'idApp_OrcaTrata',
				'Tipo_Orca',
				'idApp_Cliente',
				'idApp_ClientePet',
				'idApp_ClienteDep',
				'DataOrca',
				'HoraOrca',
				'TipoFinanceiro',
				'Descricao',
				'AprovadoOrca',
				'ConcluidoOrca',
				'BrindeOrca',
				'DevolvidoOrca',
				'ProntoOrca',
				'QuitadoOrca',
				'ValorOrca',
				'ValorComissao',
				'ValorDev',
				'QtdPrdOrca',
				'QtdSrvOrca',
				'PrazoProdutos',
				'PrazoServicos',
				'PrazoProdServ',
				'PrazoCorreios',
				'ValorDinheiro',
				'ValorTroco',
				'ValorRestanteOrca',
				'FormaPagamento',
				'Modalidade',
				'QtdParcelasOrca',
				'DataVencimentoOrca',
				'ObsOrca',
				'Consideracoes',
				'idTab_TipoRD',
				'AVAP',
				'EnviadoOrca',
				'Cep',
				'Logradouro',
				'Numero',
				'Complemento',
				'Bairro',
				'Cidade',
				'Estado',
				'Referencia',
				'TipoFrete',
				'ValorFrete',
				'ValorExtraOrca',
				'PercExtraOrca',
				'ValorSomaOrca',
				'CombinadoFrete',
				'PrazoEntrega',
				'ValorTotalOrca',
				'FinalizadoOrca',
				'Entregador',
				'DataEntregaOrca',
				'HoraEntregaOrca',
				'NomeRec',
				'TelefoneRec',
				'ParentescoRec',
				'ObsEntrega',
				'Aux1Entrega',
				'Aux2Entrega',
				'DetalhadaEntrega',
				'CanceladoOrca',
				'Cli_Forn_Orca',
				'Prd_Srv_Orca',
				'Entrega_Orca',
				'TipoDescOrca',
				'TipoExtraOrca',
				'DescPercOrca',
				'DescValorOrca',
				'CashBackOrca',
				'ValidadeCashBackOrca',
				'UsarCashBack',
				'UsarCupom',
				'Cupom',
				'SubValorFinal',
				'ValorFinalOrca',
			), TRUE));
			
			$data['cliente'] = $this->input->post(array(
				'idApp_Cliente',
				'CepCliente',
				'EnderecoCliente',
				'NumeroCliente',
				'ComplementoCliente',
				'CidadeCliente',
				'BairroCliente',
				'MunicipioCliente',
				'EstadoCliente',
				'ReferenciaCliente',
			), TRUE);

			$caracteres_sem_acento = array(
				'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
				'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
				'�'=>'I', '�'=>'N', 'N'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
				'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
				'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
				'�'=>'i', '�'=>'o', '�'=>'n', 'n'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
				'�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f',
				'a'=>'a', '�'=>'i', '�'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', '�'=>'I', '�'=>'A', '?'=>'S', '?'=>'T',
			);

			$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Logradouro'], $caracteres_sem_acento));

			$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['orcatrata']['Cep'], $caracteres_sem_acento));

			$numero1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Numero'], $caracteres_sem_acento));

			$complemento1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Complemento'], $caracteres_sem_acento));

			$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Bairro'], $caracteres_sem_acento));

			$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Cidade'], $caracteres_sem_acento));

			$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Estado'], $caracteres_sem_acento));

			$referencia1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Referencia'], $caracteres_sem_acento));
					
			if ($idApp_Cliente) {
				
				$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
				
				if($data['query'] === FALSE){
					
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				}
				//$data['query']['idApp_Cliente'] = $idApp_Cliente;
				//$data['resumo'] = $this->Cliente_model->get_cliente($idApp_Cliente);
				//$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
			}
		
			if(!$_SESSION['Cliente']){
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {
				
				$data['query']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];	
					
				if(isset($data['query']['CepCliente'])){
					(!$data['orcatrata']['Cep']) ? $data['orcatrata']['Cep'] = $data['query']['CepCliente'] : FALSE;
				}
				
				if(isset($data['query']['EnderecoCliente'])){
					(!$data['orcatrata']['Logradouro']) ? $data['orcatrata']['Logradouro'] = $data['query']['EnderecoCliente'] : FALSE;
				}
				
				if(isset($data['query']['NumeroCliente'])){
					(!$data['orcatrata']['Numero']) ? $data['orcatrata']['Numero'] = $data['query']['NumeroCliente'] : FALSE;
				}
				
				if(isset($data['query']['ComplementoCliente'])){	
					(!$data['orcatrata']['Complemento']) ? $data['orcatrata']['Complemento'] = $data['query']['ComplementoCliente'] : FALSE;
				}
				
				if(isset($data['query']['BairroCliente'])){
				 (!$data['orcatrata']['Bairro']) ? $data['orcatrata']['Bairro'] = $data['query']['BairroCliente'] : FALSE;
				}
				
				if(isset($data['query']['CidadeCliente'])){
				 (!$data['orcatrata']['Cidade']) ? $data['orcatrata']['Cidade'] = $data['query']['CidadeCliente'] : FALSE;
				}
					
				if(isset($data['query']['EstadoCliente'])){
				 (!$data['orcatrata']['Estado']) ? $data['orcatrata']['Estado'] = $data['query']['EstadoCliente'] : FALSE;
				}
				
				if(isset($data['query']['ReferenciaCliente'])){
				 (!$data['orcatrata']['Referencia']) ? $data['orcatrata']['Referencia'] = $data['query']['ReferenciaCliente'] : FALSE;
				}

				//D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
				//comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

				($_SESSION['Usuario']['Bx_Pag'] == "S") ? $data['div']['Prof_comissao'] = '' : $data['div']['Prof_comissao'] = 'style="display: none;"';		
				
				(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
				(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
				(!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');

				//Data de hoje como default
				$data['orcatrata']['Tipo_Orca'] = "B";
				(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
				(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;
				(!$data['orcatrata']['Entrega_Orca']) ? $data['orcatrata']['Entrega_Orca'] = 'S' : FALSE;
				(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
				(!$data['orcatrata']['HoraOrca']) ? $data['orcatrata']['HoraOrca'] = date('H:i:s', time()) : FALSE;
				(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
				(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
				(!$data['orcatrata']['DataVencimentoOrca']) ? $data['orcatrata']['DataVencimentoOrca'] = date('d/m/Y', time()) : FALSE;
				#(!$data['orcatrata']['DataPrazo']) ? $data['orcatrata']['DataPrazo'] = date('d/m/Y', time()) : FALSE;
				(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "2" : FALSE;
				(!$data['orcatrata']['ValorOrca']) ? $data['orcatrata']['ValorOrca'] = '0.00' : FALSE;
				(!$data['orcatrata']['ValorComissao']) ? $data['orcatrata']['ValorComissao'] = '0.00' : FALSE;
				(!$data['orcatrata']['QtdPrdOrca']) ? $data['orcatrata']['QtdPrdOrca'] = '0' : FALSE;
				(!$data['orcatrata']['QtdSrvOrca']) ? $data['orcatrata']['QtdSrvOrca'] = '0' : FALSE;
				(!$data['orcatrata']['PrazoProdutos']) ? $data['orcatrata']['PrazoProdutos'] = '0' : FALSE;
				(!$data['orcatrata']['PrazoServicos']) ? $data['orcatrata']['PrazoServicos'] = '0' : FALSE;
				(!$data['orcatrata']['ValorDev']) ? $data['orcatrata']['ValorDev'] = '0.00' : FALSE;
				(!$data['orcatrata']['ValorExtraOrca']) ? $data['orcatrata']['ValorExtraOrca'] = '0.00' : FALSE;
				(!$data['orcatrata']['ValorSomaOrca']) ? $data['orcatrata']['ValorSomaOrca'] = '0.00' : FALSE;
				(!$data['orcatrata']['ValorSomaOrca']) ? $data['orcatrata']['ValorSomaOrca'] = '0.00' : FALSE;
				(!$data['orcatrata']['ValorRestanteOrca']) ? $data['orcatrata']['ValorRestanteOrca'] = '0.00' : FALSE;
				(!$data['orcatrata']['ValorTotalOrca']) ? $data['orcatrata']['ValorTotalOrca'] = '0.00' : FALSE;
				(!$data['orcatrata']['PercExtraOrca']) ? $data['orcatrata']['PercExtraOrca'] = '0.00' : FALSE;
				(!$data['orcatrata']['DescPercOrca']) ? $data['orcatrata']['DescPercOrca'] = '0.00' : FALSE;
				(!$data['orcatrata']['DescValorOrca']) ? $data['orcatrata']['DescValorOrca'] = '0.00' : FALSE;
				(!$data['orcatrata']['CashBackOrca']) ? $data['orcatrata']['CashBackOrca'] = '0.00' : FALSE;
				(!$data['orcatrata']['ValidadeCashBackOrca']) ? $data['orcatrata']['ValidadeCashBackOrca'] = date('d/m/Y', time()) : FALSE;
				(!$data['orcatrata']['SubValorFinal']) ? $data['orcatrata']['SubValorFinal'] = '0.00' : FALSE;
				(!$data['orcatrata']['ValorFinalOrca']) ? $data['orcatrata']['ValorFinalOrca'] = '0.00' : FALSE;
				(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
				(!$data['orcatrata']['Entregador']) ? $data['orcatrata']['Entregador'] = '0' : FALSE;
				(!$data['orcatrata']['idApp_ClientePet']) ? $data['orcatrata']['idApp_ClientePet'] = '0' : FALSE;
				(!$data['orcatrata']['idApp_ClienteDep']) ? $data['orcatrata']['idApp_ClienteDep'] = '0' : FALSE;
				(!$data['orcatrata']['PrazoCorreios']) ? $data['orcatrata']['PrazoCorreios'] = '0' : FALSE;
				(!$data['orcatrata']['ValorDinheiro']) ? $data['orcatrata']['ValorDinheiro'] = '0.00' : FALSE;
				(!$data['orcatrata']['ValorFrete']) ? $data['orcatrata']['ValorFrete'] = '0.00' : FALSE;
				(!$data['orcatrata']['PrazoProdServ']) ? $data['orcatrata']['PrazoProdServ'] = '0' : FALSE;
				(!$data['orcatrata']['TipoDescOrca']) ? $data['orcatrata']['TipoDescOrca'] = 'V' : FALSE;
				(!$data['orcatrata']['TipoExtraOrca']) ? $data['orcatrata']['TipoExtraOrca'] = 'V' : FALSE; 
				(!$data['orcatrata']['UsarCashBack']) ? $data['orcatrata']['UsarCashBack'] = 'N' : FALSE;
				(!$data['orcatrata']['UsarCupom']) ? $data['orcatrata']['UsarCupom'] = 'N' : FALSE;
				(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
				(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;
				(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
				(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;		
				(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
				(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
				(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;       
				(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
				(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
				(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
				(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
				(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
				(!$data['cadastrar']['StatusProdutos']) ? $data['cadastrar']['StatusProdutos'] = 'N' : FALSE;
				(!$data['cadastrar']['StatusParcelas']) ? $data['cadastrar']['StatusParcelas'] = 'N' : FALSE;
				(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
				(!$data['cadastrar']['Whatsapp']) ? $data['cadastrar']['Whatsapp'] = 'S' : FALSE;
				(!$data['cadastrar']['Whatsapp_Site']) ? $data['cadastrar']['Whatsapp_Site'] = 'N' : FALSE;
				(!$data['cadastrar']['ValidaCupom']) ? $data['cadastrar']['ValidaCupom'] = '0' : FALSE;
				
				$j = 1;
				for ($i = 1; $i <= $data['count']['SCount']; $i++) {

					if ($this->input->post('idTab_Servico' . $i)) {
						$data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
						$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
						$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
						$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
						$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
						$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
						$data['servico'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoServico' . $i);
						$data['servico'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackServico' . $i);
						$data['servico'][$j]['PrazoProduto'] = $this->input->post('PrazoServico' . $i);
						$data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
						$data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
						$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
						$data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
						$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
						$data['servico'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoServico' . $i);
						$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackServico' . $i);
						$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
						$data['servico'][$j]['ValorComissaoServico'] = $this->input->post('ValorComissaoServico' . $i);
						$data['servico'][$j]['ObsProduto'] = $this->input->post('ObsServico' . $i);
						$data['servico'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeServico' . $i);
						$data['servico'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoServico' . $i);
						$data['servico'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoServico' . $i);
						$data['servico'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoServico' . $i);
						
						$data['servico'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalServico_1' . $i);
						if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
							$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
						}else{
							$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
						}				
						$data['servico'][$j]['ProfissionalProduto_2'] = $this->input->post('ProfissionalServico_2' . $i);
						if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
							$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
						}else{
							$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
						}
						$data['servico'][$j]['ProfissionalProduto_3'] = $this->input->post('ProfissionalServico_3' . $i);
						if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
							$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
						}else{
							$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
						}
						$data['servico'][$j]['ProfissionalProduto_4'] = $this->input->post('ProfissionalServico_4' . $i);
						if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
							$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
						}else{
							$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
						}
						$data['servico'][$j]['ProfissionalProduto_5'] = $this->input->post('ProfissionalServico_5' . $i);
						if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
							$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
						}else{
							$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
						}
						$data['servico'][$j]['ProfissionalProduto_6'] = $this->input->post('ProfissionalServico_6' . $i);
						if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
							$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
						}else{
							$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
						}
						
						$data['servico'][$j]['idTFProf_1'] = $this->input->post('idTFProf_Servico_1' . $i);
						$data['servico'][$j]['ComFunProf_1'] = $this->input->post('ComFunProf_Servico_1' . $i);
						$data['servico'][$j]['ValorComProf_1'] = $this->input->post('ValorComProf_Servico_1' . $i);
						
						$data['servico'][$j]['idTFProf_2'] = $this->input->post('idTFProf_Servico_2' . $i);
						$data['servico'][$j]['ComFunProf_2'] = $this->input->post('ComFunProf_Servico_2' . $i);
						$data['servico'][$j]['ValorComProf_2'] = $this->input->post('ValorComProf_Servico_2' . $i);
						
						$data['servico'][$j]['idTFProf_3'] = $this->input->post('idTFProf_Servico_3' . $i);
						$data['servico'][$j]['ComFunProf_3'] = $this->input->post('ComFunProf_Servico_3' . $i);
						$data['servico'][$j]['ValorComProf_3'] = $this->input->post('ValorComProf_Servico_3' . $i);
						
						$data['servico'][$j]['idTFProf_4'] = $this->input->post('idTFProf_Servico_4' . $i);
						$data['servico'][$j]['ComFunProf_4'] = $this->input->post('ComFunProf_Servico_4' . $i);
						$data['servico'][$j]['ValorComProf_4'] = $this->input->post('ValorComProf_Servico_4' . $i);
						
						$data['servico'][$j]['idTFProf_5'] = $this->input->post('idTFProf_Servico_5' . $i);
						$data['servico'][$j]['ComFunProf_5'] = $this->input->post('ComFunProf_Servico_5' . $i);
						$data['servico'][$j]['ValorComProf_5'] = $this->input->post('ValorComProf_Servico_5' . $i);
						
						$data['servico'][$j]['idTFProf_6'] = $this->input->post('idTFProf_Servico_6' . $i);
						$data['servico'][$j]['ComFunProf_6'] = $this->input->post('ComFunProf_Servico_6' . $i);
						$data['servico'][$j]['ValorComProf_6'] = $this->input->post('ValorComProf_Servico_6' . $i);
						
						(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
						$data['radio'] = array(
							'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
						);
						($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';
						
						$j++;
					}

				}
				$data['count']['SCount'] = $j - 1;

				$j = 1;
				for ($i = 1; $i <= $data['count']['PCount']; $i++) {

					if ($this->input->post('idTab_Produto' . $i)) {
						$data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
						$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
						$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
						$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
						$data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
						$data['produto'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoProduto' . $i);
						$data['produto'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackProduto' . $i);
						$data['produto'][$j]['PrazoProduto'] = $this->input->post('PrazoProduto' . $i);                
						$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
						$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
						$data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
						$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
						$data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
						$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
						$data['produto'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoProduto' . $i);
						$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackProduto' . $i);
						$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
						$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
						$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
						$data['produto'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoProduto' . $i);
						$data['produto'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoProduto' . $i);
						$data['produto'][$j]['Aux_App_Produto_1'] = $this->input->post('Aux_App_Produto_1' . $i);
						$data['produto'][$j]['Aux_App_Produto_2'] = $this->input->post('Aux_App_Produto_2' . $i);
						$data['produto'][$j]['Aux_App_Produto_3'] = $this->input->post('Aux_App_Produto_3' . $i);
						$data['produto'][$j]['Aux_App_Produto_4'] = $this->input->post('Aux_App_Produto_4' . $i);
						$data['produto'][$j]['Aux_App_Produto_5'] = $this->input->post('Aux_App_Produto_5' . $i);
						$data['produto'][$j]['HoraValidadeProduto'] = $this->input->post('HoraValidadeProduto' . $i);
						$data['produto'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoProduto' . $i);
						$data['produto'][$j]['DevolvidoProduto'] = $this->input->post('DevolvidoProduto' . $i);
						//$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
						//$data['produto'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalProduto_1' . $i);
						
						(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
						$data['radio'] = array(
							'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
						);
						($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';
						
						$j++;
					}
				}
				$data['count']['PCount'] = $j - 1;

				$j = 1;
				for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

					if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataConcluidoProcedimento' . $i) || 
							$this->input->post('Profissional' . $i) || $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
						$data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
						$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->input->post('DataConcluidoProcedimento' . $i);
						$data['procedimento'][$j]['HoraProcedimento'] = $this->input->post('HoraProcedimento' . $i);
						$data['procedimento'][$j]['HoraConcluidoProcedimento'] = $this->input->post('HoraConcluidoProcedimento' . $i);
						//$data['procedimento'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
						#$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
						$data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
						$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
						$data['procedimento'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
						$data['procedimento'][$j]['Compartilhar'] = $this->input->post('Compartilhar' . $i);
						
						(!$data['procedimento'][$j]['ConcluidoProcedimento']) ? $data['procedimento'][$j]['ConcluidoProcedimento'] = 'N' : FALSE;
						$data['radio'] = array(
							'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
						);
						($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';	
						
						$j++;
					}

				}
				$data['count']['PMCount'] = $j - 1;

				//$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorFinalOrca']);
				$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
				$data['valortotalorca'] = floatval ($data['valortotalorca']);
				$data['somatotal'] = 0;
				
				if ($data['valortotalorca'] > 0.00 && $data['orcatrata']['QtdParcelasOrca'] >=1) {
					
					for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

						$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
						$data['somatotal'] += $data['valoredit'][$i];
						
						if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) || $this->input->post('DataVencimento' . $i)){
							$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
							$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
							$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
							//$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
							$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
							$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
							$data['parcelasrec'][$i]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
						}
						(!$data['parcelasrec'][$i]['Quitado']) ? $data['parcelasrec'][$i]['Quitado'] = 'N' : FALSE;
						$data['radio'] = array(
							'Quitado' . $i => $this->basico->radio_checked($data['parcelasrec'][$i]['Quitado'], 'Quitado' . $i, 'NS'),
						);
						($data['parcelasrec'][$i]['Quitado'] == 'S') ? $data['div']['Quitado' . $i] = '' : $data['div']['Quitado' . $i] = 'style="display: none;"';
					}
					
				}
				
				/*
				if ($data['orcatrata']['ValorTotalOrca'] > 0) {

					for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

						if ($this->input->post('ValorParcela' . $i) > 0 && $this->input->post('ValorParcela' . $i) != ''){
							$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
							$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
							$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
							$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
							$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
							$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
							$data['parcelasrec'][$i]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
						}
						(!$data['parcelasrec'][$i]['Quitado']) ? $data['parcelasrec'][$i]['Quitado'] = 'N' : FALSE;
						$data['radio'] = array(
							'Quitado' . $i => $this->basico->radio_checked($data['parcelasrec'][$i]['Quitado'], 'Quitado' . $i, 'NS'),
						);
						($data['parcelasrec'][$i]['Quitado'] == 'S') ? $data['div']['Quitado' . $i] = '' : $data['div']['Quitado' . $i] = 'style="display: none;"';
				   
					}

				}
				*/

				//Fim do trecho de c�digo que d� pra melhorar
				$data['select']['EspeciePet'] = array (
					'0' => '',
					'1' => 'C�O',
					'2' => 'GATO',
					'3' => 'AVE',
				);	
				$data['select']['PeloPet'] = array (
					'0' => '',
					'1' => 'CURTO',
					'2' => 'M�DIO',
					'3' => 'LONGO',
					'4' => 'CACHEADO',
				);		
				$data['select']['PortePet'] = array (
					'0' => '',
					'1' => 'MINI',
					'2' => 'PEQUENO',
					'3' => 'M�DIO',
					'4' => 'GRANDE',
					'5' => 'GIGANTE',
					);		
				$data['select']['TipoDescOrca'] = array (
					'P' => '.%',
					'V' => 'R$',
				);		
				$data['select']['TipoExtraOrca'] = array (
					'P' => '.%',
					'V' => 'R$',
				);
				$data['select']['RacaPet'] = $this->Cliente_model->select_racapet();
				$data['select']['RelacaoDep'] = $this->Cliente_model->select_relacao();			
				$data['select']['UsarCashBack'] = $this->Basico_model->select_status_sn();
				$data['select']['UsarCupom'] = $this->Basico_model->select_status_sn();
				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
				$data['select']['Whatsapp'] = $this->Basico_model->select_status_sn();
				$data['select']['Whatsapp_Site'] = $this->Basico_model->select_status_sn();
				$data['select']['StatusProdutos'] = $this->Basico_model->select_status_sn();
				$data['select']['StatusParcelas'] = $this->Basico_model->select_status_sn();
				$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['Entrega_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
				$data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
				$data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
				$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
				$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
				$data['select']['FormaPagamentoParcela'] = $this->Formapag_model->select_formapag();
				$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['DevolvidoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['ProntoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
				$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
				$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['Quitado'] = $this->Basico_model->select_status_sn();
				$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
				$data['select']['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
				$data['select']['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
				$data['select']['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
				$data['select']['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
				$data['select']['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
				$data['select']['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalProduto_1'] = $this->Usuario_model->select_usuario();
				$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
				$data['select']['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos();
				$data['select']['Produto'] = $this->Basico_model->select_produtos3($data['orcatrata']['Tipo_Orca']);
				$data['select']['Servico'] = $this->Basico_model->select_servicos3($data['orcatrata']['Tipo_Orca']);
				#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
				$data['select']['AVAP'] = $this->Basico_model->select_avap();
				$data['select']['TipoFrete'] = $this->Basico_model->select_tipofrete();
				$data['select']['Entregador'] = $this->Usuario_model->select_usuario_entregador();
				$data['select']['Prioridade'] = array (
					'1' => 'Alta',
					'2' => 'M�dia',
					'3' => 'Baixa',
				);
				$data['select']['idApp_ClienteDep'] = $this->Cliente_model->select_clientedep($_SESSION['Cliente']['idApp_Cliente']);
				$data['select']['idApp_ClientePet'] = $this->Cliente_model->select_clientepet($_SESSION['Cliente']['idApp_Cliente']);
				
				$data['titulo'] = 'Nova Receita';
				$data['form_open_path'] = 'orcatrata/cadastrar';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 1;
				$data['caminho'] = '../../';
				$data['caminho2'] = '';
				$data['Recorrencias'] = 1;
				$data['Recorrencias_outras'] = $data['Recorrencias'] - 1;
				
				$data['exibir_id'] = 0;
				
				$data['exibirExtraOrca'] = 1;
				$data['exibirDescOrca'] = 1;
				
				$data['AtivoCashBack'] = 'S';
				
				$data['vinculadas'] = 0;
				if ($data['vinculadas'] > 0){
					$data['textoEntregues'] = '';
					$data['textoPagas'] = '';
				}else{
					$data['textoEntregues'] = 'style="display: none;"';
					$data['textoPagas'] = 'style="display: none;"';
				}

				
				if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorRestanteOrca'])
					$data['orcamentoin'] = 'in';
				else
					$data['orcamentoin'] = '';

				if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
					$data['parcelasin'] = 'in';
				else
					$data['parcelasin'] = '';

				//if ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional'])
				if (isset($data['procedimento']))
					$data['tratamentosin'] = 'in';
				else
					$data['tratamentosin'] = '';

				
				$data['collapse'] = '';	

				$data['collapse1'] = 'class="collapse"';	
				
				if ($_SESSION['log']['NivelEmpresa'] >= '4' )
					$data['visivel'] = '';
				else
					$data['visivel'] = 'style="display: none;"';		
			
				#Ver uma solu��o melhor para este campo
				(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
				(!$data['orcatrata']['TipoFinanceiro']) ? $data['orcatrata']['TipoFinanceiro'] = '31' : FALSE;
				
				#(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
				($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
				
				/*
				$data['radio'] = array(
					'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
				);
				($data['orcatrata']['AVAP'] == 'P') ?
					$data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
				*/

				($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
				
				$data['radio'] = array(
					'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
				);
				($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Finalizado', 'NS'),
				);
				($data['orcatrata']['FinalizadoOrca'] == 'N') ?
					$data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Or�amento Cancelado', 'NS'),
				);
				($data['orcatrata']['CanceladoOrca'] == 'N') ?
					$data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Pronto p/Entrega', 'NS'),
				);
				($data['orcatrata']['ProntoOrca'] == 'S') ?
					$data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
				);
				($data['orcatrata']['DevolvidoOrca'] == 'S') ?
					$data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';			
				
				$data['radio'] = array(
					'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
				);
				($data['cadastrar']['Cadastrar'] == 'N') ?
					$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'Whatsapp' => $this->basico->radio_checked($data['cadastrar']['Whatsapp'], 'Whatsapp', 'NS'),
				);
				($data['cadastrar']['Whatsapp'] == 'S') ?
					$data['div']['Whatsapp'] = '' : $data['div']['Whatsapp'] = 'style="display: none;"';		
							
				$data['radio'] = array(
					'Whatsapp_Site' => $this->basico->radio_checked($data['cadastrar']['Whatsapp_Site'], 'Whatsapp_Site', 'NS'),
				);
				($data['cadastrar']['Whatsapp_Site'] == 'S') ?
					$data['div']['Whatsapp_Site'] = '' : $data['div']['Whatsapp_Site'] = 'style="display: none;"';
							
				$data['radio'] = array(
					'StatusProdutos' => $this->basico->radio_checked($data['cadastrar']['StatusProdutos'], 'StatusProdutos', 'NS'),
				);
				($data['cadastrar']['StatusProdutos'] == 'S') ?
					$data['div']['StatusProdutos'] = '' : $data['div']['StatusProdutos'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'StatusParcelas' => $this->basico->radio_checked($data['cadastrar']['StatusParcelas'], 'StatusParcelas', 'NS'),
				);
				($data['cadastrar']['StatusParcelas'] == 'S') ?
					$data['div']['StatusParcelas'] = '' : $data['div']['StatusParcelas'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
				);
				($data['cadastrar']['AtualizaEndereco'] == 'N') ?
					$data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	
					
				$data['radio'] = array(
					'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
				);
				($data['orcatrata']['CombinadoFrete'] == 'S') ?
					$data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';

				$data['radio'] = array(
					'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
				);
				($data['orcatrata']['EnviadoOrca'] == 'S') ?
					$data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';			
					
				$data['radio'] = array(
					'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
				);
				($data['orcatrata']['AprovadoOrca'] == 'S') ?
				$data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Or�amento Concluido', 'NS'),
				);
				($data['orcatrata']['ConcluidoOrca'] == 'N') ?
					$data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

					
				$data['radio'] = array(
					'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
				);
				($data['orcatrata']['BrindeOrca'] == 'N') ?
					$data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';

				$data['radio'] = array(
					'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
				);
				($data['orcatrata']['QuitadoOrca'] == 'S') ?
					$data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
				);
				($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
					$data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
				);
				($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
					$data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Entrega_Orca' => $this->basico->radio_checked($data['orcatrata']['Entrega_Orca'], 'Entrega', 'NS'),
				);
				($data['orcatrata']['Entrega_Orca'] == 'S') ?
					$data['div']['Entrega_Orca'] = '' : $data['div']['Entrega_Orca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'UsarCashBack' => $this->basico->radio_checked($data['orcatrata']['UsarCashBack'], 'UsarCashBack', 'NS'),
				);
				($data['orcatrata']['UsarCashBack'] == 'S') ?
					$data['div']['UsarCashBack'] = '' : $data['div']['UsarCashBack'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'UsarCupom' => $this->basico->radio_checked($data['orcatrata']['UsarCupom'], 'UsarCupom', 'NS'),
				);
				($data['orcatrata']['UsarCupom'] == 'S') ?
					$data['div']['UsarCupom'] = '' : $data['div']['UsarCupom'] = 'style="display: none;"';		
				
				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';
				
				$data['cor_cli'] 	= 'default';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'warning';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';

				$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

				$data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data);
				  echo "</pre>";
				  exit ();
				  */

				$data['somatotal'] = floatval ($data['somatotal']);
				$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];
				
				$epsilon = 0.001;

				if(abs($data['diferenca']) < $epsilon){
					$data['diferenca'] = 0.00;
				}else{
					$data['diferenca'] = $data['diferenca'];
				}
				
				$data['diferenca'] = floatval ($data['diferenca']);		  
				
				$data['q3'] = $this->Clientepet_model->list_racapet(TRUE);
				$data['list3'] = $this->load->view('clientepet/list_racapet', $data, TRUE);
				  
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				#### App_OrcaTrata ####
				
				if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
					if($data['diferenca'] < 0.00){
						$data['diferenca'] = number_format($data['diferenca'],2,",",".");
						//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
						$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
					}elseif($data['diferenca'] > 0.00){
						$data['diferenca'] = number_format($data['diferenca'],2,",",".");
						//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
						$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
					}
				}
				if ($data['valortotalorca'] <= 0.00 ) {
					$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
				}
				
				$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
				$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
				$this->form_validation->set_rules('Modalidade', 'Tipo de Recebimento', 'required|trim');		
				#$this->form_validation->set_rules('ValorRestanteOrca', 'Valor da Receita', 'required|trim');		
				$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
				$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
				$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
				$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');
				$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');	
				
				if($data['orcatrata']['TipoFrete'] !=1){
					if($data['orcatrata']['AVAP'] == 'O'){
						if($data['orcatrata']['FormaPagamento'] == '1' || $data['orcatrata']['FormaPagamento'] == '2' || $data['orcatrata']['FormaPagamento'] == '3'){
							$this->form_validation->set_rules('Cep', 'Cep', 'required|trim');
							$this->form_validation->set_rules('Logradouro', 'Endere�o', 'required|trim');
							$this->form_validation->set_rules('Numero', 'Numero', 'required|trim');
							$this->form_validation->set_rules('Bairro', 'Bairro', 'required|trim');
							$this->form_validation->set_rules('Cidade', 'Cidade', 'required|trim');
							$this->form_validation->set_rules('Estado', 'Estado', 'required|trim');
						}
					}
				}
						
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('orcatrata/form_orcatrata', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);

					} else {

						$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
						$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
						$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
						$data['cadastrar']['AtualizaEndereco'] = $data['cadastrar']['AtualizaEndereco'];
						////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
						#### App_OrcaTrata ####
						if ($data['orcatrata']['Entrega_Orca'] == "S") {	
							if ($data['orcatrata']['TipoFrete'] == '1') {
								$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
								$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
								$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
								$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
								$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
								$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
								$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
								$data['orcatrata']['Referencia'] = '';
							} else {	
								$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
								$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
								$data['orcatrata']['Numero'] = trim(mb_strtoupper($numero1, 'ISO-8859-1'));
								$data['orcatrata']['Complemento'] = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));
								$data['orcatrata']['Bairro'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
								$data['orcatrata']['Cidade'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
								$data['orcatrata']['Estado'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));
								$data['orcatrata']['Referencia'] = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));
							}
						} else {
							$data['orcatrata']['Cep'] = '';
							$data['orcatrata']['Logradouro'] = '';
							$data['orcatrata']['Numero'] = '';
							$data['orcatrata']['Complemento'] = '';
							$data['orcatrata']['Bairro'] = '';
							$data['orcatrata']['Cidade'] = '';
							$data['orcatrata']['Estado'] = '';
							$data['orcatrata']['Referencia'] = '';
						}
						$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
						$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
						$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
						$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
						$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));
						$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
						$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
						//$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
						//$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
						//$data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
						//$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
						$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
						$data['orcatrata']['Tipo_Orca'] = "B";
						
						if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
							$data['orcatrata']['ConcluidoOrca'] = "S";
							$data['orcatrata']['QuitadoOrca'] = "S";
						} 
						if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['FinalizadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
						} 
						if($data['orcatrata']['ConcluidoOrca'] == 'S'){
							$data['orcatrata']['CombinadoFrete'] = "S";
						} 
						if($data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
						} 
						if ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
							$data['orcatrata']['EnviadoOrca'] = "S";
						}
						
						$data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
						$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
						$data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
						//$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
						//$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
						if($data['orcatrata']['FormaPagamento'] == "7"){
							$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
							$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
						}else{
							$data['orcatrata']['ValorDinheiro'] = 0.00;
							$data['orcatrata']['ValorTroco'] = 0.00;
						}
						$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
						$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
						$data['orcatrata']['PercExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['PercExtraOrca']));
						
						$data['orcatrata']['DescPercOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescPercOrca']));
						$data['orcatrata']['DescValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescValorOrca']));
						$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
						$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'mysql');
						$data['CashBackAtual'] = $data['orcatrata']['CashBackOrca'];
						$data['ValidadeAtual'] = $data['orcatrata']['ValidadeCashBackOrca'];
						if($data['orcatrata']['UsarCashBack'] == "N"){
							$data['orcatrata']['CashBackOrca'] = 0.00;
							$data['orcatrata']['ValidadeCashBackOrca'] = "0000-00-00";
						}
						/*
						if($data['orcatrata']['UsarCashBack'] == "S"){
							$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
						}else{
							$data['orcatrata']['CashBackOrca'] = 0.00;
						}
						*/
						$data['orcatrata']['ValorFinalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
						
						$data['orcatrata']['SubValorFinal'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['SubValorFinal']));
						$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
						$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
						$data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
						
						$data['orcatrata']['idTab_TipoRD'] = "2";

						if($_SESSION['Usuario']['Nivel'] == 2){
							$data['orcatrata']['NivelOrca'] = 2;
						}else{
							$data['orcatrata']['NivelOrca'] = 1;
						}
					
						$data['orcatrata']['idSis_Empresa'] 	= $_SESSION['log']['idSis_Empresa'];
						$data['orcatrata']['idSis_Usuario'] 	= $_SESSION['log']['idSis_Usuario'];
						$data['orcatrata']['id_Funcionario'] 	= $_SESSION['log']['idSis_Usuario'];
						$data['orcatrata']['id_Associado'] 		= 0;
						$data['orcatrata']['idTab_Modulo'] 		= $_SESSION['log']['idTab_Modulo'];
						$data['orcatrata']['Cli_Forn_Orca'] 	= 'S';

						if($data['orcatrata']['Entrega_Orca'] == "N"){
							$data['orcatrata']['DataEntregaOrca'] = $data['orcatrata']['DataOrca'];
							$data['orcatrata']['HoraEntregaOrca'] = "00:00:00";
							$data['orcatrata']['PrazoProdServ'] = 0;
							$data['orcatrata']['PrazoCorreios'] = 0;
							$data['orcatrata']['PrazoEntrega'] = 0;
						}
						
						if (!$data['orcatrata']['PrazoEntrega']){
							//$data1 = date('Y-m-d', time());
							$data1 = $data['orcatrata']['DataOrca'];
							$data2 = $data['orcatrata']['DataEntregaOrca'];
							$intervalo = strtotime($data2)-strtotime($data1); 
							$dias = floor($intervalo / (60 * 60 * 24));
							$data['orcatrata']['PrazoEntrega'] = $dias;
						}
			
						$data['orcatrata']['ValorFatura'] = $data['orcatrata']['ValorFinalOrca'];
						
						if($data['orcatrata']['AVAP'] == "O" && ($data['orcatrata']['FormaPagamento'] == "1" || $data['orcatrata']['FormaPagamento'] == "2" || $data['orcatrata']['FormaPagamento'] == "3")){
							$data['orcatrata']['ValorGateway'] = ($data['orcatrata']['ValorFatura'] * 0.04) + 0.40;
						}else{
							$data['orcatrata']['ValorGateway'] = 0.00;
						}
						$data['orcatrata']['ValorEmpresa'] = $data['orcatrata']['ValorFatura'] - $data['orcatrata']['ValorComissao'] - $data['orcatrata']['ValorGateway'];
						
						
						if ($data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['UsarCashBack'] == 'S' && $data['orcatrata']['idApp_Cliente'] != 0){
							$data['orcatrata']['AtivoCashBack'] = 'N';
						}			
						
						if($data['orcatrata']['UsarCupom'] == "S"){
							$data['orcatrata']['TipoDescOrca'] = $data['cadastrar']['UsarE'];
							if($data['cadastrar']['ValidaCupom'] == 0 || !$data['orcatrata']['Cupom'] || empty($data['orcatrata']['Cupom'])){
								$data['orcatrata']['Cupom'] = 0;
							}
						}else{
							$data['orcatrata']['Cupom'] = 0;
						}

						### pego o Valor da Comiss�o do Funcion�rio ###
						if($_SESSION['Usuario']['Nivel'] != 2){
							$data['orcatrata']['ComissaoFunc'] = $_SESSION['Usuario']['Comissao'];
						}else{
							$data['Funcionario'] = $this->Usuario_model->get_funcionario($_SESSION['Usuario']['QuemCad']);
							if($data['Funcionario'] !== FALSE){
								$data['orcatrata']['ComissaoFunc'] = $data['Funcionario']['Comissao'];
							}else{
								$data['orcatrata']['ComissaoFunc'] = 0;
							}
						}
						$data['orcatrata']['ValorComissaoFunc'] = 0;
						$data['orcatrata']['ValorComissaoAssoc'] = 0;

						$data['redirect'] = '&gtd=' . $data['orcatrata']['DataEntregaOrca'];
						/*
						echo '<br>';
						echo "<pre>";
						print_r('UsarCupom = ' . $data['orcatrata']['UsarCupom']);
						echo '<br>';
						print_r('UsarE = ' . $data['cadastrar']['UsarE']);
						echo '<br>';
						print_r('TipoDescOrca = ' . $data['orcatrata']['TipoDescOrca']);
						echo '<br>';
						print_r('ValidaCupom = ' . $data['cadastrar']['ValidaCupom']);
						echo '<br>';
						print_r('Cupom = ' . $data['orcatrata']['Cupom']);
						echo "</pre>";			
						exit ();
						*/			
						$data['orcatrata']['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['orcatrata']);


						if ($data['orcatrata']['idApp_OrcaTrata'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('orcatrata/form_orcatrata', $data);
						} else {
							
							#### Whatsapp ####
							if($data['cadastrar']['Whatsapp'] == 'S'){
								$_SESSION['bd_orcamento']['Whatsapp'] = $data['cadastrar']['Whatsapp'];
								$_SESSION['bd_orcamento']['Whatsapp_Site'] = $data['cadastrar']['Whatsapp_Site'];
							}
									
							#### APP_Cliente ####
							if ($data['cadastrar']['AtualizaEndereco'] == 'S' && $data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['Entrega_Orca'] == "S" && $data['orcatrata']['idApp_Cliente'] != 0){
								$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
								$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
								$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
								$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
								$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
								$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
								$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
								$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
											
								$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
								$data['update']['cliente']['campos'] = array_keys($data['cliente']);
								/*
								$data['update']['cliente']['auditoriaitem'] = $this->basico->set_log(
									$data['update']['cliente']['anterior'],
									$data['cliente'],
									$data['update']['cliente']['campos'],
									$data['cliente']['idApp_Cliente'], TRUE);
								*/	
								$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);
								
								/*
								// ""ver modo correto de fazer o set_log e set_auditoria""
								if ($data['auditoriaitem'] === FALSE) {
									$data['msg'] = '';
								} else {
									$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
									$data['msg'] = '?m=1';
								}
								*/
								
							}
							
							//in�cio do c�digo que ser� desligado. N�o preciso dizer qual produto foi pago o cashback
							/*
							if ($data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['UsarCashBack'] == 'S' && $data['orcatrata']['idApp_Cliente'] != 0){
								$data['update']['cashback'] = $this->Orcatrata_model->get_produto_cashback($data['orcatrata']['idApp_Cliente']);
								if (isset($data['update']['cashback'])){
									$count_cash = count($data['update']['cashback']);
									for($k=0;$k<$count_cash;$k++) {
										
										$data['update']['cashback'][$k]['StatusComissaoCashBack'] = 'S';
										$data['update']['cashback'][$k]['DataPagoCashBack'] = $data['orcatrata']['DataOrca'];
										$data['update']['cashback'][$k]['id_Orca_CashBack'] = $data['orcatrata']['idApp_OrcaTrata'];
										
										$data['update']['cashback']['bd'] = $this->Orcatrata_model->update_produto_id($data['update']['cashback'][$k], $data['update']['cashback'][$k]['idApp_Produto']);
									
									
									}
								}
							}
							*/
							//fim do c�digo que ser� desligado
							
							/*
							//echo count($data['servico']);
							echo '<br>';
							echo "<pre>";
							print_r($data['cliente']);
							echo "</pre>";
							exit ();
							*/
							
							$data['CashBackServicos'] = 0;
							$data['ComAssocServicos'] = 0;
							$data['ComFuncServicos'] = 0;
							#### App_Servico ####
							if (isset($data['servico'])) {
								$max = count($data['servico']);
								for($j=1;$j<=$max;$j++) {
									
									$data['servico'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
									$data['servico'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
									$data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
									$data['servico'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
									$data['servico'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
									$data['servico'][$j]['idTab_TipoRD'] = "2";
									$data['servico'][$j]['NivelProduto'] = $_SESSION['Usuario']['Nivel'];

									if(!$data['servico'][$j]['ProfissionalProduto_1']){
										$data['servico'][$j]['ProfissionalProduto_1'] = 0;
									}
									if(!$data['servico'][$j]['ProfissionalProduto_2']){
										$data['servico'][$j]['ProfissionalProduto_2'] = 0;
									}
									if(!$data['servico'][$j]['ProfissionalProduto_3']){
										$data['servico'][$j]['ProfissionalProduto_3'] = 0;
									}
									if(!$data['servico'][$j]['ProfissionalProduto_4']){
										$data['servico'][$j]['ProfissionalProduto_4'] = 0;
									}
									if(!$data['servico'][$j]['ProfissionalProduto_5']){
										$data['servico'][$j]['ProfissionalProduto_5'] = 0;
									}
									if(!$data['servico'][$j]['ProfissionalProduto_6']){
										$data['servico'][$j]['ProfissionalProduto_6'] = 0;
									}
									
									if(empty($data['servico'][$j]['ValorProduto'])){
										$data['servico'][$j]['ValorProduto'] = "0.00";
									}else{
										$data['servico'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorProduto']));
									}
									
									if(empty($data['servico'][$j]['ValorComProf_1'])){
										$data['servico'][$j]['ValorComProf_1'] = "0.00";
									}else{
										$data['servico'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_1']));
									}
									
									if(empty($data['servico'][$j]['ValorComProf_2'])){
										$data['servico'][$j]['ValorComProf_2'] = "0.00";
									}else{
										$data['servico'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_2']));
									}
									
									if(empty($data['servico'][$j]['ValorComProf_3'])){
										$data['servico'][$j]['ValorComProf_3'] = "0.00";
									}else{
										$data['servico'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_3']));
									}
									
									if(empty($data['servico'][$j]['ValorComProf_4'])){
										$data['servico'][$j]['ValorComProf_4'] = "0.00";
									}else{
										$data['servico'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_4']));
									}
									
									if(empty($data['servico'][$j]['ValorComProf_5'])){
										$data['servico'][$j]['ValorComProf_5'] = "0.00";
									}else{
										$data['servico'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_5']));
									}
									
									if(empty($data['servico'][$j]['ValorComProf_6'])){
										$data['servico'][$j]['ValorComProf_6'] = "0.00";
									}else{
										$data['servico'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_6']));
									}
									
									if(empty($data['servico'][$j]['ValorComissaoServico'])){
										$data['servico'][$j]['ValorComissaoServico'] = "0.00";
									}else{
										$data['servico'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComissaoServico']));
									}
																
									$data['servico'][$j]['ValorComissaoVenda'] = $data['servico'][$j]['SubtotalComissaoProduto'];
									
									//$data['servico'][$j]['ValorComissaoServico'] = $data['servico'][$j]['SubtotalComissaoServicoProduto'];
									$data['servico'][$j]['ValorComissaoAssociado'] = $data['servico'][$j]['SubtotalComissaoServicoProduto'];
									$data['ComAssocServicos'] += $data['servico'][$j]['ValorComissaoAssociado'];

									$data['servico'][$j]['ValorComissaoFuncionario'] = $data['servico'][$j]['QtdProduto']*$data['servico'][$j]['ValorProduto']*$data['orcatrata']['ComissaoFunc']/100;
									$data['ComFuncServicos'] += $data['servico'][$j]['ValorComissaoFuncionario'];

									$data['servico'][$j]['ValorComissaoCashBack'] = $data['servico'][$j]['SubtotalComissaoCashBackProduto'];
									$data['CashBackServicos'] += $data['servico'][$j]['ValorComissaoCashBack'];
													
									if(!$data['servico'][$j]['DataValidadeProduto'] || $data['servico'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['servico'][$j]['DataValidadeProduto'])){
										$data['servico'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['servico'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataConcluidoProduto'], 'mysql');
									}
																					
									if(!$data['servico'][$j]['DataConcluidoProduto'] || $data['servico'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['servico'][$j]['DataConcluidoProduto'])){
										$data['servico'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['servico'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataConcluidoProduto'], 'mysql');
									}
									
									if(!$data['servico'][$j]['HoraConcluidoProduto'] || $data['servico'][$j]['HoraConcluidoProduto'] == "00:00"){
										$data['servico'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
									}else{
										$data['servico'][$j]['HoraConcluidoProduto'] = $data['servico'][$j]['HoraConcluidoProduto'];
									}
									
									if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
										$data['servico'][$j]['ConcluidoProduto'] = 'S';
									}else{
										$data['servico'][$j]['ConcluidoProduto'] = $data['servico'][$j]['ConcluidoProduto'];
									}
									/*
									if ($data['servico'][$j]['ConcluidoProduto'] == 'S') {
										if(!$data['servico'][$j]['DataConcluidoProduto']){
											$data['servico'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
										}else{
											$data['servico'][$j]['DataConcluidoProduto'] = $data['servico'][$j]['DataConcluidoProduto'];
										}
										if(!$data['servico'][$j]['HoraConcluidoProduto'] || $data['servico'][$j]['HoraConcluidoProduto'] == "00:00"){
											$data['servico'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
										}else{
											$data['servico'][$j]['HoraConcluidoProduto'] = $data['servico'][$j]['HoraConcluidoProduto'];
										}
									}else{
										$data['servico'][$j]['DataConcluidoProduto'] = "0000-00-00";
										$data['servico'][$j]['HoraConcluidoProduto'] = "00:00";
									}
									*/
									unset($data['servico'][$j]['SubtotalProduto']);
									unset($data['servico'][$j]['SubtotalComissaoProduto']);
									unset($data['servico'][$j]['SubtotalComissaoServicoProduto']);
									unset($data['servico'][$j]['SubtotalComissaoCashBackProduto']);
									unset($data['servico'][$j]['SubtotalQtdProduto']);	
								}
								$data['servico']['idApp_Produto'] = $this->Orcatrata_model->set_servico($data['servico']);
							}

							$data['CashBackProdutos'] = 0;
							$data['ComAssocProdutos'] = 0;
							$data['ComFuncProdutos'] = 0;
							#### App_Produto ####
							if (isset($data['produto'])) {
								$max = count($data['produto']);
								for($j=1;$j<=$max;$j++) {
									
									$data['produto'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
									$data['produto'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
									$data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
									$data['produto'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
									$data['produto'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
									$data['produto'][$j]['idTab_TipoRD'] = "2";
									$data['produto'][$j]['NivelProduto'] = $_SESSION['Usuario']['Nivel'];

									if(empty($data['produto'][$j]['ValorProduto'])){
										$data['produto'][$j]['ValorProduto'] = "0.00";
									}else{
										$data['produto'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorProduto']));
									}

									$data['produto'][$j]['ValorComissaoVenda'] = $data['produto'][$j]['SubtotalComissaoProduto'];
									
									//$data['produto'][$j]['ValorComissaoServico'] = $data['produto'][$j]['SubtotalComissaoServicoProduto'];
									$data['produto'][$j]['ValorComissaoAssociado'] = $data['produto'][$j]['SubtotalComissaoServicoProduto'];
									$data['ComAssocProdutos'] += $data['produto'][$j]['ValorComissaoAssociado'];

									$data['produto'][$j]['ValorComissaoFuncionario'] = $data['produto'][$j]['QtdProduto']*$data['produto'][$j]['ValorProduto']*$data['orcatrata']['ComissaoFunc']/100;
									$data['ComFuncProdutos'] += $data['produto'][$j]['ValorComissaoFuncionario'];

									$data['produto'][$j]['ValorComissaoCashBack'] = $data['produto'][$j]['SubtotalComissaoCashBackProduto'];
									$data['CashBackProdutos'] += $data['produto'][$j]['ValorComissaoCashBack'];

									if(!$data['produto'][$j]['DataValidadeProduto'] || $data['produto'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['produto'][$j]['DataValidadeProduto'])){
										$data['produto'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'mysql');
									}
															
									if(!$data['produto'][$j]['DataConcluidoProduto'] || $data['produto'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['produto'][$j]['DataConcluidoProduto'])){
										$data['produto'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['produto'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataConcluidoProduto'], 'mysql');
									}
									
									if(!$data['produto'][$j]['HoraConcluidoProduto'] || $data['produto'][$j]['HoraConcluidoProduto'] == "00:00"){
										$data['produto'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
									}else{
										$data['produto'][$j]['HoraConcluidoProduto'] = $data['produto'][$j]['HoraConcluidoProduto'];
									}
															
									if ($data['orcatrata']['ConcluidoOrca'] == 'S') {
										$data['produto'][$j]['ConcluidoProduto'] = 'S';
									}else{
										$data['produto'][$j]['ConcluidoProduto'] = $data['produto'][$j]['ConcluidoProduto'];
									}
									/*
									if ($data['produto'][$j]['ConcluidoProduto'] == 'S') {
										if(!$data['produto'][$j]['DataConcluidoProduto']){
											$data['produto'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
										}else{
											$data['produto'][$j]['DataConcluidoProduto'] = $data['produto'][$j]['DataConcluidoProduto'];
										}
										if(!$data['produto'][$j]['HoraConcluidoProduto'] || $data['produto'][$j]['HoraConcluidoProduto'] == "00:00"){
											$data['produto'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
										}else{
											$data['produto'][$j]['HoraConcluidoProduto'] = $data['produto'][$j]['HoraConcluidoProduto'];
										}
									}else{
										$data['produto'][$j]['DataConcluidoProduto'] = "0000-00-00";
										$data['produto'][$j]['HoraConcluidoProduto'] = "00:00";
									}
									*/
									if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
										$data['produto'][$j]['DevolvidoProduto'] = 'S';
									} else {
										$data['produto'][$j]['DevolvidoProduto'] = $data['produto'][$j]['DevolvidoProduto'];
									}
									unset($data['produto'][$j]['SubtotalProduto']);
									unset($data['produto'][$j]['SubtotalComissaoProduto']);
									unset($data['produto'][$j]['SubtotalComissaoServicoProduto']);
									unset($data['produto'][$j]['SubtotalComissaoCashBackProduto']);
									unset($data['produto'][$j]['SubtotalQtdProduto']);
								}
								$data['produto']['idApp_Produto'] = $this->Orcatrata_model->set_produto($data['produto']);
							}

							#### App_ParcelasRec ####
							if (isset($data['parcelasrec'])) {
								$max = count($data['parcelasrec']);
								for($j=1;$j<=$max;$j++) {
									$data['parcelasrec'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
									$data['parcelasrec'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
									$data['parcelasrec'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
									$data['parcelasrec'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
									$data['parcelasrec'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
									$data['parcelasrec'][$j]['idTab_TipoRD'] = "2";
									$data['parcelasrec'][$j]['NivelParcela'] = $_SESSION['Usuario']['Nivel'];
									
									$data['parcelasrec'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorParcela']));
									//$data['parcelasrec'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorPago']));
									$data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'mysql');
									$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'mysql');
									if ($data['parcelasrec'][$j]['FormaPagamentoParcela']) {
										$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $data['parcelasrec'][$j]['FormaPagamentoParcela'];
									}else{
										$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
									}
									if ($data['orcatrata']['QuitadoOrca'] == 'S') {
										$data['parcelasrec'][$j]['Quitado'] = 'S';
									} else {
										$data['parcelasrec'][$j]['Quitado'] = $data['parcelasrec'][$j]['Quitado'];
									}
									if ($data['parcelasrec'][$j]['Quitado'] == 'S') {
										if (!$data['parcelasrec'][$j]['DataPago']){
											$data['parcelasrec'][$j]['DataPago'] = $data['parcelasrec'][$j]['DataVencimento'];
										} else {
											$data['parcelasrec'][$j]['DataPago'] = $data['parcelasrec'][$j]['DataPago'];
										}
										$data['parcelasrec'][$j]['DataLanc'] = date('Y-m-d', time());
									} else {
										$data['parcelasrec'][$j]['DataPago'] = "0000-00-00";
										$data['parcelasrec'][$j]['DataLanc'] = "0000-00-00";
									}
								}
								$data['parcelasrec']['idApp_Parcelas'] = $this->Orcatrata_model->set_parcelas($data['parcelasrec']);
							}

							#### App_Procedimento ####
							if (isset($data['procedimento'])) {
								$max = count($data['procedimento']);
								for($j=1;$j<=$max;$j++) {
									$data['procedimento'][$j]['TipoProcedimento'] = 2;
									$data['procedimento'][$j]['NivelProcedimento'] = $_SESSION['Usuario']['Nivel'];
									$data['procedimento'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
									if(!$data['procedimento'][$j]['Compartilhar']){
										$data['procedimento'][$j]['Compartilhar'] = $_SESSION['log']['idSis_Usuario'];
									}
									$data['procedimento'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
									$data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
									$data['procedimento'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
									$data['procedimento'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
									$data['procedimento'][$j]['Profissional'] = $_SESSION['log']['idSis_Usuario'];
									$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'mysql');
									
									if(!$data['procedimento'][$j]['DataConcluidoProcedimento']){
										$data['procedimento'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
									}else{
										$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataConcluidoProcedimento'], 'mysql');
									}

								}
								$data['procedimento']['idApp_Procedimento'] = $this->Orcatrata_model->set_procedimento($data['procedimento']);
							}
						
							$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_contagem($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['update']['produto']['posterior'])){
								$max_produto = count($data['update']['produto']['posterior']);
								if($max_produto > 0){
									$data['orcatrata']['Prd_Srv_Orca'] = "S";
								}
							}
							
							$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['update']['produto']['posterior'])){
								$max_produto = count($data['update']['produto']['posterior']);
								if($max_produto == 0){
									$data['orcatrata']['CombinadoFrete'] = "S";
									#$data['orcatrata']['AprovadoOrca'] = "S";
									$data['orcatrata']['ProntoOrca'] = "S";
									$data['orcatrata']['EnviadoOrca'] = "S";
									$data['orcatrata']['ConcluidoOrca'] = "S";
								}else{
									$data['orcatrata']['ConcluidoOrca'] = "N";
								}
							}
							
							$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['update']['parcelasrec']['posterior'])){
								$max_parcela = count($data['update']['parcelasrec']['posterior']);
								if($max_parcela == 0){
									#$data['orcatrata']['CombinadoFrete'] = "S";
									$data['orcatrata']['AprovadoOrca'] = "S";
									$data['orcatrata']['QuitadoOrca'] = "S";				
								}else{
									$data['orcatrata']['QuitadoOrca'] = "N";
								}

							}
							
							$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['update']['produto']['posterior'])){
								$max_produto = count($data['update']['produto']['posterior']);
								if($max_produto > 0){
									$data['orcatrata']['CombinadoFrete'] = "S";
									#$data['orcatrata']['AprovadoOrca'] = "S";
								}
							}			

							$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);	
							if (isset($data['update']['parcelasrec']['posterior'])){
								$max_parcela = count($data['update']['parcelasrec']['posterior']);
								if($max_parcela > 0){
									#$data['orcatrata']['CombinadoFrete'] = "S";
									$data['orcatrata']['AprovadoOrca'] = "S";				
								}

							}

							if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['FinalizadoOrca'] = "S";
								$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
							}else{
								$data['orcatrata']['FinalizadoOrca'] = "N";
							}
							
							$data['CashBackNovo'] = $data['CashBackServicos'] + $data['CashBackProdutos'];

							//Se existir Cliente  Atualizo ou n�o o valor do cashback no campo CashBackCliente do Cliente
							
								if(isset($data['orcatrata']['idApp_Cliente']) && $data['orcatrata']['idApp_Cliente'] !=0){
									if($data['orcatrata']['UsarCashBack'] == "S"){
										if($data['orcatrata']['QuitadoOrca'] == "S"){
											//CashBackCliente = novo valor;
											$data['cliente_cashback']['CashBackCliente'] = $data['CashBackNovo'];
											$data['cliente_cashback']['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
										}else{
											//CashBackCliente = 0.00;
											$data['cliente_cashback']['CashBackCliente'] = '0.00';
										}
									}else{
										if($data['orcatrata']['QuitadoOrca'] == "S"){
											//CashBackCliente = velho valor + novo valor;
											$data['cliente_cashback']['CashBackCliente'] = $data['CashBackAtual'] + $data['CashBackNovo'];
											$data['cliente_cashback']['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
										}else{
											//CashBackCliente = velho valor;
											$data['cliente_cashback']['CashBackCliente'] = $data['CashBackAtual'];
										}
									}
									//fa�o o update no cliente
						
									$data['update']['cliente_cashback']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
									$data['update']['cliente_cashback']['campos'] = array_keys($data['cliente_cashback']);
					
									if(strtotime($data['update']['cliente_cashback']['anterior']['UltimoPedido']) < strtotime($data['orcatrata']['DataOrca'])){
									
										$data['cliente_cashback']['UltimoPedido'] 		= $data['orcatrata']['DataOrca'];
										$data['cliente_cashback']['id_UltimoPedido'] 	= $data['orcatrata']['idApp_OrcaTrata'];
										
									}else if(strtotime($data['update']['cliente_cashback']['anterior']['UltimoPedido']) == strtotime($data['orcatrata']['DataOrca'])){
										
										if($data['update']['cliente_cashback']['anterior']['id_UltimoPedido'] < $data['orcatrata']['idApp_OrcaTrata']){
											
											$data['cliente_cashback']['id_UltimoPedido'] = $data['orcatrata']['idApp_OrcaTrata'];
										
										}
										
									}else{
										
										if($data['update']['cliente_cashback']['anterior']['id_UltimoPedido'] == $data['orcatrata']['idApp_OrcaTrata']){

											$data['get_ult_pdd_cliente'] = $this->Orcatrata_model->get_ult_pdd_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
											$data['cliente_cashback']['UltimoPedido'] = $data['get_ult_pdd_cliente']['DataOrca'];
											$data['cliente_cashback']['id_UltimoPedido'] = $data['get_ult_pdd_cliente']['idApp_OrcaTrata'];						
										}
										
									}

									$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);					
								
								}
							
							$data['orcatrata']['ValorComissaoFunc'] = $data['ComFuncServicos'] + $data['ComFuncProdutos'];
							$data['orcatrata']['ValorComissaoFunc'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorComissaoFunc']));
							
							$data['orcatrata']['ValorComissaoAssoc'] = $data['ComAssocServicos'] + $data['ComAssocProdutos'];
							$data['orcatrata']['ValorComissaoAssoc'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorComissaoAssoc']));
							
							$data['orcatrata']['RepeticaoOrca'] = $data['orcatrata']['idApp_OrcaTrata'];
							$data['orcatrata']['RecorrenciasOrca'] = "1";
							$data['orcatrata']['RecorrenciaOrca'] = "1/1";
							
							$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
							$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
							$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
								$data['update']['orcatrata']['anterior'],
								$data['orcatrata'],
								$data['update']['orcatrata']['campos'],
								$data['orcatrata']['idApp_OrcaTrata'], TRUE);
							$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);
							
							#### Estoque_Produto_posterior ####
							
								if ($data['orcatrata']['CombinadoFrete'] == 'S' && $data['orcatrata']['CanceladoOrca'] == 'N') {
									
									$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
									
									if (count($data['busca']['estoque']['posterior']) > 0) {
										
										$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
										$max_estoque = count($data['busca']['estoque']['posterior']);
										
										if (isset($data['busca']['estoque']['posterior'])){
											
											for($j=1;$j<=$max_estoque;$j++) {
												
												$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
												
												if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
													
													$qtd_produto[$j]	= ($data['busca']['estoque']['posterior'][$j]['QtdProduto'] * $data['busca']['estoque']['posterior'][$j]['QtdIncrementoProduto']);
													
													$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] - $qtd_produto[$j]);
													
													if($diff_estoque[$j] <= 0){
														$estoque[$j] = 0; 
													}else{
														$estoque[$j] = $diff_estoque[$j]; 
													}
													
													$data['alterar']['produto']['posterior'][$j]['Estoque'] = $estoque[$j];
													$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$j], $data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
													
													unset($qtd_produto[$j]);
													unset($diff_estoque[$j]);
													unset($estoque[$j]);
												}
												
											}
											
										}
										
									}
									
								}
							
							/*
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
										//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
										$data['campos'] = array_keys($data['query']);
										$data['anterior'] = array();
										//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
							//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
							*/


							//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
							//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';

							#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
							#redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
							#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
							redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
							//redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
							exit();
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }
	
    public function cadastrar3() {

		$acesso = FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$acesso = TRUE;
		}else{
			if($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Usuario']['Nivel'] != 2 && $_SESSION['Usuario']['Usu_Rec'] == "S" && $_SESSION['Usuario']['Cad_Orcam'] == "S"){
				$acesso = TRUE;
			}	
		}
		
		if($acesso === FALSE){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 3)
				$data['msg'] = $this->basico->msg('<strong>N�o � poss�vel salvar o novo Pedido.<br>N�o identificamos o pagamento da sua �ltima Fatura.<br>Por favor, Entre em contato com a administra��o da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
			else
				$data['msg'] = '';
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'ConcluidoProduto',
				'QuitadoParcelas',
				'Cadastrar',
				'Whatsapp',
				'Whatsapp_Site',
				'AtualizaEndereco',
				'StatusProdutos',
				'StatusParcelas',
				'PeloPet',
				'PortePet',
				'EspeciePet',
				'RacaPet',
				'RelacaoDep',
				'Hidden_idApp_Cliente',
				'id_Cliente_Auto',
				'NomeClienteAuto',
				'Valor_S_Desc',
				'Valor_C_Desc',
				'UsarC',
				'UsarD',
				'UsarE',
				'ValidaCupom',
				'MensagemCupom',
				'CodigoCupom',
			), TRUE));
		
			$data['orcatrata'] = quotes_to_entities($this->input->post(array(
				#### App_OrcaTrata ####
				//'idApp_OrcaTrata',
				'Tipo_Orca',
				'idApp_Cliente',
				'idApp_ClientePet',
				'idApp_ClienteDep',
				'DataOrca',
				'HoraOrca',
				'TipoFinanceiro',
				'Descricao',
				'AprovadoOrca',
				'ConcluidoOrca',
				'BrindeOrca',
				'DevolvidoOrca',
				'ProntoOrca',
				'QuitadoOrca',
				'ValorOrca',
				'ValorComissao',
				'ValorDev',
				'QtdPrdOrca',
				'QtdSrvOrca',
				'PrazoProdutos',
				'PrazoServicos',
				'PrazoProdServ',
				'PrazoCorreios',
				'ValorDinheiro',
				'ValorTroco',
				'ValorRestanteOrca',
				'FormaPagamento',
				'Modalidade',
				'QtdParcelasOrca',
				'DataVencimentoOrca',
				'ObsOrca',
				'Consideracoes',
				'idTab_TipoRD',
				'AVAP',
				'EnviadoOrca',
				'Cep',
				'Logradouro',
				'Numero',
				'Complemento',
				'Bairro',
				'Cidade',
				'Estado',
				'Referencia',
				'TipoFrete',
				'ValorFrete',
				'ValorExtraOrca',
				'PercExtraOrca',
				'ValorSomaOrca',
				'CombinadoFrete',
				'PrazoEntrega',
				'ValorTotalOrca',
				'FinalizadoOrca',
				'Entregador',
				'DataEntregaOrca',
				'HoraEntregaOrca',
				'NomeRec',
				'TelefoneRec',
				'ParentescoRec',
				'ObsEntrega',
				'Aux1Entrega',
				'Aux2Entrega',
				'DetalhadaEntrega',
				'CanceladoOrca',
				'Cli_Forn_Orca',
				'Prd_Srv_Orca',
				'Entrega_Orca',
				'TipoDescOrca',
				'TipoExtraOrca',
				'DescPercOrca',
				'DescValorOrca',
				'CashBackOrca',
				'ValidadeCashBackOrca',
				'UsarCashBack',
				'UsarCupom',
				'Cupom',
				'SubValorFinal',
				'ValorFinalOrca',
			), TRUE));
			
			$data['cliente'] = $this->input->post(array(
				'idApp_Cliente',
				'CepCliente',
				'EnderecoCliente',
				'NumeroCliente',
				'ComplementoCliente',
				'CidadeCliente',
				'BairroCliente',
				'MunicipioCliente',
				'EstadoCliente',
				'ReferenciaCliente',
			), TRUE);

			$caracteres_sem_acento = array(
				'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
				'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
				'�'=>'I', '�'=>'N', 'N'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
				'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
				'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
				'�'=>'i', '�'=>'o', '�'=>'n', 'n'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
				'�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f',
				'a'=>'a', '�'=>'i', '�'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', '�'=>'I', '�'=>'A', '?'=>'S', '?'=>'T',
			);

			$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Logradouro'], $caracteres_sem_acento));

			$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['orcatrata']['Cep'], $caracteres_sem_acento));

			$numero1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Numero'], $caracteres_sem_acento));

			$complemento1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Complemento'], $caracteres_sem_acento));

			$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Bairro'], $caracteres_sem_acento));

			$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Cidade'], $caracteres_sem_acento));

			$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Estado'], $caracteres_sem_acento));

			$referencia1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Referencia'], $caracteres_sem_acento));
					
			//D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
			//comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

			(isset($_SESSION['Usuario']['Bx_Pag']) && $_SESSION['Usuario']['Bx_Pag'] == "S") ? $data['div']['Prof_comissao'] = '' : $data['div']['Prof_comissao'] = 'style="display: none;"';		
			
			(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
			(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
			(!$this->input->post('P2Count')) ? $data['count']['P2Count'] = 0 : $data['count']['P2Count'] = $this->input->post('P2Count');
			(!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
			//(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');

			//Data de hoje como default
			$data['orcatrata']['Tipo_Orca'] = "B";
			(!$data['orcatrata']['TipoDescOrca']) ? $data['orcatrata']['TipoDescOrca'] = 'V' : FALSE;
			(!$data['orcatrata']['TipoExtraOrca']) ? $data['orcatrata']['TipoExtraOrca'] = 'V' : FALSE; 
			(!$data['orcatrata']['UsarCashBack']) ? $data['orcatrata']['UsarCashBack'] = 'N' : FALSE;
			(!$data['orcatrata']['UsarCupom']) ? $data['orcatrata']['UsarCupom'] = 'N' : FALSE;
			(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '0' : FALSE;
			if($_SESSION['log']['idSis_Empresa'] != 5){
				(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
				(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;
				(!$data['orcatrata']['Entrega_Orca']) ? $data['orcatrata']['Entrega_Orca'] = 'S' : FALSE;
			}else{
				$data['orcatrata']['Cli_Forn_Orca'] = 'N';
				$data['orcatrata']['Prd_Srv_Orca'] = 'N';
				$data['orcatrata']['Entrega_Orca'] = 'N';
			}
			(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;       
			(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['HoraOrca']) ? $data['orcatrata']['HoraOrca'] = date('H:i:s', time()) : FALSE;
			(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
			(!$data['orcatrata']['DataVencimentoOrca']) ? $data['orcatrata']['DataVencimentoOrca'] = date('d/m/Y', time()) : FALSE;
			#(!$data['orcatrata']['DataPrazo']) ? $data['orcatrata']['DataPrazo'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "2" : FALSE;
			(!$data['orcatrata']['ValorOrca']) ? $data['orcatrata']['ValorOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorComissao']) ? $data['orcatrata']['ValorComissao'] = '0.00' : FALSE;
			(!$data['orcatrata']['QtdPrdOrca']) ? $data['orcatrata']['QtdPrdOrca'] = '0' : FALSE;
			(!$data['orcatrata']['QtdSrvOrca']) ? $data['orcatrata']['QtdSrvOrca'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoProdutos']) ? $data['orcatrata']['PrazoProdutos'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoServicos']) ? $data['orcatrata']['PrazoServicos'] = '0' : FALSE;
			(!$data['orcatrata']['ValorDev']) ? $data['orcatrata']['ValorDev'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorFrete']) ? $data['orcatrata']['ValorFrete'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorExtraOrca']) ? $data['orcatrata']['ValorExtraOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorSomaOrca']) ? $data['orcatrata']['ValorSomaOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorRestanteOrca']) ? $data['orcatrata']['ValorRestanteOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorTotalOrca']) ? $data['orcatrata']['ValorTotalOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['PercExtraOrca']) ? $data['orcatrata']['PercExtraOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['DescPercOrca']) ? $data['orcatrata']['DescPercOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['DescValorOrca']) ? $data['orcatrata']['DescValorOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['CashBackOrca']) ? $data['orcatrata']['CashBackOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValidadeCashBackOrca']) ? $data['orcatrata']['ValidadeCashBackOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['SubValorFinal']) ? $data['orcatrata']['SubValorFinal'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorFinalOrca']) ? $data['orcatrata']['ValorFinalOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = 1 : FALSE;
			(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
			(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
			(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
			(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE; 
			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
			(!$data['cadastrar']['Whatsapp']) ? $data['cadastrar']['Whatsapp'] = 'S' : FALSE;
			(!$data['cadastrar']['Whatsapp_Site']) ? $data['cadastrar']['Whatsapp_Site'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusProdutos']) ? $data['cadastrar']['StatusProdutos'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusParcelas']) ? $data['cadastrar']['StatusParcelas'] = 'N' : FALSE;
			(!$data['cadastrar']['ValidaCupom']) ? $data['cadastrar']['ValidaCupom'] = '0' : FALSE;
			(!$data['orcatrata']['Entregador']) ? $data['orcatrata']['Entregador'] = '0' : FALSE;
			(!$data['orcatrata']['idApp_ClientePet']) ? $data['orcatrata']['idApp_ClientePet'] = '0' : FALSE;
			(!$data['orcatrata']['idApp_ClienteDep']) ? $data['orcatrata']['idApp_ClienteDep'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoCorreios']) ? $data['orcatrata']['PrazoCorreios'] = '0' : FALSE;
			(!$data['orcatrata']['ValorDinheiro']) ? $data['orcatrata']['ValorDinheiro'] = '0.00' : FALSE;
			(!$data['orcatrata']['PrazoProdServ']) ? $data['orcatrata']['PrazoProdServ'] = '0' : FALSE;
			if($_SESSION['log']['idSis_Empresa'] == 5){
				(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'S' : FALSE;
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'S' : FALSE;			
			}else{
				(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;		
			}
			(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
			
			/*
			$j = 1;
			for ($i = 1; $i <= $data['count']['SCount']; $i++) {

				if ($this->input->post('idTab_Servico' . $i)) {
					$data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
					$data['servico'][$j]['idTab_Valor_Servico'] = $this->input->post('idTab_Valor_Servico' . $i);
					$data['servico'][$j]['idTab_Produtos_Servico'] = $this->input->post('idTab_Produtos_Servico' . $i);
					$data['servico'][$j]['Prod_Serv_Servico'] = $this->input->post('Prod_Serv_Servico' . $i);
					$data['servico'][$j]['NomeServico'] = $this->input->post('NomeServico' . $i);
					$data['servico'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
					$data['servico'][$j]['ValorServico'] = $this->input->post('ValorServico' . $i);
					$data['servico'][$j]['QtdServico'] = $this->input->post('QtdServico' . $i);
					$data['servico'][$j]['QtdIncrementoServico'] = $this->input->post('QtdIncrementoServico' . $i);
					$data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
					$data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
					$data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
					$data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
					$data['servico'][$j]['ProfissionalServico_1'] = $this->input->post('ProfissionalServico_1' . $i);
					$j++;
				}

			}
			$data['count']['SCount'] = $j - 1;
			*/
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['SCount']; $i++) {

				if ($this->input->post('idTab_Servico' . $i)) {
					$data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
					$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
					$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
					$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
					$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
					$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
					$data['servico'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoServico' . $i);
					$data['servico'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackServico' . $i);
					$data['servico'][$j]['PrazoProduto'] = $this->input->post('PrazoServico' . $i);
					$data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
					$data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
					$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
					$data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
					$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
					$data['servico'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoServico' . $i);
					$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackServico' . $i);
					$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
					$data['servico'][$j]['ValorComissaoServico'] = $this->input->post('ValorComissaoServico' . $i);
					$data['servico'][$j]['ObsProduto'] = $this->input->post('ObsServico' . $i);
					$data['servico'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeServico' . $i);
					$data['servico'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoServico' . $i);
					$data['servico'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoServico' . $i);
					$data['servico'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoServico' . $i);
					
					$data['servico'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalServico_1' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
					}				
					$data['servico'][$j]['ProfissionalProduto_2'] = $this->input->post('ProfissionalServico_2' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_3'] = $this->input->post('ProfissionalServico_3' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_4'] = $this->input->post('ProfissionalServico_4' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_5'] = $this->input->post('ProfissionalServico_5' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_6'] = $this->input->post('ProfissionalServico_6' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
					}
					
					$data['servico'][$j]['idTFProf_1'] = $this->input->post('idTFProf_Servico_1' . $i);
					$data['servico'][$j]['ComFunProf_1'] = $this->input->post('ComFunProf_Servico_1' . $i);
					$data['servico'][$j]['ValorComProf_1'] = $this->input->post('ValorComProf_Servico_1' . $i);
					
					$data['servico'][$j]['idTFProf_2'] = $this->input->post('idTFProf_Servico_2' . $i);
					$data['servico'][$j]['ComFunProf_2'] = $this->input->post('ComFunProf_Servico_2' . $i);
					$data['servico'][$j]['ValorComProf_2'] = $this->input->post('ValorComProf_Servico_2' . $i);
					
					$data['servico'][$j]['idTFProf_3'] = $this->input->post('idTFProf_Servico_3' . $i);
					$data['servico'][$j]['ComFunProf_3'] = $this->input->post('ComFunProf_Servico_3' . $i);
					$data['servico'][$j]['ValorComProf_3'] = $this->input->post('ValorComProf_Servico_3' . $i);
					
					$data['servico'][$j]['idTFProf_4'] = $this->input->post('idTFProf_Servico_4' . $i);
					$data['servico'][$j]['ComFunProf_4'] = $this->input->post('ComFunProf_Servico_4' . $i);
					$data['servico'][$j]['ValorComProf_4'] = $this->input->post('ValorComProf_Servico_4' . $i);
					
					$data['servico'][$j]['idTFProf_5'] = $this->input->post('idTFProf_Servico_5' . $i);
					$data['servico'][$j]['ComFunProf_5'] = $this->input->post('ComFunProf_Servico_5' . $i);
					$data['servico'][$j]['ValorComProf_5'] = $this->input->post('ValorComProf_Servico_5' . $i);
					
					$data['servico'][$j]['idTFProf_6'] = $this->input->post('idTFProf_Servico_6' . $i);
					$data['servico'][$j]['ComFunProf_6'] = $this->input->post('ComFunProf_Servico_6' . $i);
					$data['servico'][$j]['ValorComProf_6'] = $this->input->post('ValorComProf_Servico_6' . $i);
					
					(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
					);
					($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';

					$j++;
				}

			}
			$data['count']['SCount'] = $j - 1;		

			$j = 1;
			for ($i = 1; $i <= $data['count']['PCount']; $i++) {
				
				if ($this->input->post('idTab_Produto' . $i)) {
					$data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
					$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
					$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
					$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
					$data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
					$data['produto'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoProduto' . $i);
					$data['produto'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackProduto' . $i);
					$data['produto'][$j]['PrazoProduto'] = $this->input->post('PrazoProduto' . $i);
					$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
					$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
					$data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
					$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
					$data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackProduto' . $i);
					$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
					$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
					$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
					$data['produto'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoProduto' . $i);
					$data['produto'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoProduto' . $i);
					$data['produto'][$j]['Aux_App_Produto_1'] = $this->input->post('Aux_App_Produto_1' . $i);
					$data['produto'][$j]['Aux_App_Produto_2'] = $this->input->post('Aux_App_Produto_2' . $i);
					$data['produto'][$j]['Aux_App_Produto_3'] = $this->input->post('Aux_App_Produto_3' . $i);
					$data['produto'][$j]['Aux_App_Produto_4'] = $this->input->post('Aux_App_Produto_4' . $i);
					$data['produto'][$j]['Aux_App_Produto_5'] = $this->input->post('Aux_App_Produto_5' . $i);
					$data['produto'][$j]['HoraValidadeProduto'] = $this->input->post('HoraValidadeProduto' . $i);
					$data['produto'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoProduto' . $i);
					$data['produto'][$j]['DevolvidoProduto'] = $this->input->post('DevolvidoProduto' . $i);
					$data['produto'][$j]['CanceladoProduto'] = $this->input->post('CanceladoProduto' . $i);
					//$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					//$data['produto'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalProduto_1' . $i);
					
					(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
					);
					($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';
					
					(!$data['produto'][$j]['DevolvidoProduto']) ? $data['produto'][$j]['DevolvidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'DevolvidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['DevolvidoProduto'], 'DevolvidoProduto' . $j, 'NS'),
					);
					($data['produto'][$j]['DevolvidoProduto'] == 'S') ? $data['div']['DevolvidoProduto' . $j] = '' : $data['div']['DevolvidoProduto' . $j] = 'style="display: none;"';
					
					$j++;
				}
			}
			$data['count']['PCount'] = $j - 1;
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

				if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataConcluidoProcedimento' . $i) ||
					$this->input->post('Profissional' . $i) || $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
					$data['procedimento'][$j]['idApp_Procedimento'] = $this->input->post('idApp_Procedimento' . $i);
					$data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
					$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->input->post('DataConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['HoraProcedimento'] = $this->input->post('HoraProcedimento' . $i);
					$data['procedimento'][$j]['HoraConcluidoProcedimento'] = $this->input->post('HoraConcluidoProcedimento' . $i);				
					#$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
					//$data['procedimento'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
					$data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
					$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					$data['procedimento'][$j]['Compartilhar'] = $this->input->post('Compartilhar' . $i);
					
					(!$data['procedimento'][$j]['ConcluidoProcedimento']) ? $data['procedimento'][$j]['ConcluidoProcedimento'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
					);
					($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';	
					
					$j++;
				}

			}
			$data['count']['PMCount'] = $j - 1;

			//$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorTotalOrca']);
			
			//$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorFinalOrca']);
			$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
			$data['valortotalorca'] = floatval ($data['valortotalorca']);
			
			$data['somatotal'] = 0;
			
			if ($data['valortotalorca'] > 0.00 && $data['orcatrata']['QtdParcelasOrca'] >=1) {
				
				for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

					$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
					$data['somatotal'] += $data['valoredit'][$i];
					
					if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) || $this->input->post('DataVencimento' . $i)){
						$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
						$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
						$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
						//$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
						$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
						$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
						$data['parcelasrec'][$i]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
					}
					(!$data['parcelasrec'][$i]['Quitado']) ? $data['parcelasrec'][$i]['Quitado'] = 'N' : FALSE;
					$data['radio'] = array(
						'Quitado' . $i => $this->basico->radio_checked($data['parcelasrec'][$i]['Quitado'], 'Quitado' . $i, 'NS'),
					);
					($data['parcelasrec'][$i]['Quitado'] == 'S') ? $data['div']['Quitado' . $i] = '' : $data['div']['Quitado' . $i] = 'style="display: none;"';
				}
				
			}

			
			//Fim do trecho de c�digo que d� pra melhorar
			
			$data['select']['EspeciePet'] = array (
				//'0' => '',
				'1' => 'C�O',
				'2' => 'GATO',
				'3' => 'AVE',
			);	
			$data['select']['PeloPet'] = array (
				//'0' => '',
				'1' => 'CURTO',
				'2' => 'M�DIO',
				'3' => 'LONGO',
				'4' => 'CACHEADO',
			);		
			$data['select']['PortePet'] = array (
				//'0' => '',
				'1' => 'MINI',
				'2' => 'PEQUENO',
				'3' => 'M�DIO',
				'4' => 'GRANDE',
				'5' => 'GIGANTE',
			);		
			$data['select']['TipoDescOrca'] = array (
				'P' => '.%',
				'V' => 'R$',
			);		
			$data['select']['TipoExtraOrca'] = array (
				'P' => '.%',
				'V' => 'R$',
			);
			$data['select']['RacaPet'] = $this->Cliente_model->select_racapet();	
			$data['select']['RelacaoDep'] = $this->Cliente_model->select_relacao();
			$data['select']['UsarCashBack'] = $this->Basico_model->select_status_sn();
			$data['select']['UsarCupom'] = $this->Basico_model->select_status_sn();
			$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
			$data['select']['Whatsapp'] = $this->Basico_model->select_status_sn();
			$data['select']['Whatsapp_Site'] = $this->Basico_model->select_status_sn();
			$data['select']['StatusProdutos'] = $this->Basico_model->select_status_sn();
			$data['select']['StatusParcelas'] = $this->Basico_model->select_status_sn();
			$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
			$data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
			$data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
			$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
			$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
			$data['select']['Entrega_Orca'] = $this->Basico_model->select_status_sn();
			$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
			$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
			$data['select']['FormaPagamentoParcela'] = $this->Formapag_model->select_formapag();
			$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['DevolvidoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['ProntoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
			$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
			$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
			$data['select']['CanceladoProduto'] = $this->Basico_model->select_status_sn();
			$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
			$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
			$data['select']['TipoFrete'] = $this->Basico_model->select_tipofrete();
			$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['Quitado'] = $this->Basico_model->select_status_sn();
			#$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
			$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
			$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
			$data['select']['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
			$data['select']['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
			$data['select']['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
			$data['select']['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
			$data['select']['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
			$data['select']['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
			//$data['select']['ProfissionalProduto_1'] = $this->Usuario_model->select_usuario();
			$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
			$data['select']['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos();
			$data['select']['Entregador'] = $this->Usuario_model->select_usuario_entregador();
			$data['select']['Produto'] = $this->Basico_model->select_produtos3($data['orcatrata']['Tipo_Orca']);
			$data['select']['Servico'] = $this->Basico_model->select_servicos3($data['orcatrata']['Tipo_Orca']);
			#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
			$data['select']['AVAP'] = $this->Basico_model->select_avap();
			$data['select']['Prioridade'] = array (
				'1' => 'Alta',
				'2' => 'M�dia',
				'3' => 'Baixa',
			);
			
			$data['titulo'] = 'Novo Pedido';
			$data['form_open_path'] = 'orcatrata/cadastrar3';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 1;
			$data['caminho'] = '../';
			$data['caminho2'] = '../';
			$data['Recorrencias'] = 1;
			$data['Recorrencias_outras'] = $data['Recorrencias'] - 1;
			
			$data['exibirExtraOrca'] = 1;
			$data['exibirDescOrca'] = 1;
			
			$data['exibir_id'] = 1;
			if($_SESSION['log']['idSis_Empresa'] == 5){
				$data['AtivoCashBack'] = 'N';
			}else{
				$data['AtivoCashBack'] = 'S';
			}
			
			$data['vinculadas'] = 0;
			if ($data['vinculadas'] > 0){
				$data['textoEntregues'] = '';
				$data['textoPagas'] = '';
			}else{
				$data['textoEntregues'] = 'style="display: none;"';
				$data['textoPagas'] = 'style="display: none;"';
			}

			$data['collapse'] = '';	
			$data['collapse1'] = 'class="collapse"';
			
			$data['tipofinan1'] = '1';

			$data['tipofinan12'] = '12';			
			
			if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorRestanteOrca'])
				$data['orcamentoin'] = 'in';
			else
				$data['orcamentoin'] = '';

			if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
				$data['parcelasin'] = 'in';
			else
				$data['parcelasin'] = '';

			//if ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional'])
			if (isset($data['procedimento']))
				$data['tratamentosin'] = 'in';
			else
				$data['tratamentosin'] = '';
			
			if ($_SESSION['log']['NivelEmpresa'] >= '4' )
				$data['visivel'] = '';
			else
				$data['visivel'] = 'style="display: none;"';
			

			($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
			
			($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
			
			/*
			$data['radio'] = array(
				'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
			);
			($data['orcatrata']['AVAP'] == 'P') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';	        
			*/
			
			$data['radio'] = array(
				'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
			);
			($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';		

			$data['radio'] = array(
				'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
			);
			($data['cadastrar']['Cadastrar'] == 'N') ?
				$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
			
			$data['radio'] = array(
				'Whatsapp' => $this->basico->radio_checked($data['cadastrar']['Whatsapp'], 'Whatsapp', 'NS'),
			);
			($data['cadastrar']['Whatsapp'] == 'S') ?
				$data['div']['Whatsapp'] = '' : $data['div']['Whatsapp'] = 'style="display: none;"';
						
			$data['radio'] = array(
				'Whatsapp_Site' => $this->basico->radio_checked($data['cadastrar']['Whatsapp_Site'], 'Whatsapp_Site', 'NS'),
			);
			($data['cadastrar']['Whatsapp_Site'] == 'S') ?
				$data['div']['Whatsapp_Site'] = '' : $data['div']['Whatsapp_Site'] = 'style="display: none;"';
				
			$data['radio'] = array(
				'StatusProdutos' => $this->basico->radio_checked($data['cadastrar']['StatusProdutos'], 'StatusProdutos', 'NS'),
			);
			($data['cadastrar']['StatusProdutos'] == 'S') ?
				$data['div']['StatusProdutos'] = '' : $data['div']['StatusProdutos'] = 'style="display: none;"';		
			
			$data['radio'] = array(
				'StatusParcelas' => $this->basico->radio_checked($data['cadastrar']['StatusParcelas'], 'StatusParcelas', 'NS'),
			);
			($data['cadastrar']['StatusParcelas'] == 'S') ?
				$data['div']['StatusParcelas'] = '' : $data['div']['StatusParcelas'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
			);
			($data['orcatrata']['CombinadoFrete'] == 'S') ?
				$data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
			);
			($data['orcatrata']['EnviadoOrca'] == 'S') ?
				$data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
			);
			($data['orcatrata']['AprovadoOrca'] == 'S') ?
				$data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';

				
			$data['radio'] = array(
				'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
			);
			($data['orcatrata']['ConcluidoOrca'] == 'S') ?
				$data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

				
			$data['radio'] = array(
				'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
			);
			($data['orcatrata']['BrindeOrca'] == 'N') ?
				$data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';
				
			$data['radio'] = array(
				'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
			);
			($data['cadastrar']['AtualizaEndereco'] == 'N') ?
				$data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	

				
			$data['radio'] = array(
				'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Prontos p/Entrega', 'NS'),
			);
			($data['orcatrata']['ProntoOrca'] == 'S') ?
				$data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';

			$data['radio'] = array(
				'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
			);
			($data['orcatrata']['DevolvidoOrca'] == 'S') ?
				$data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';
				
			$data['radio'] = array(
				'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
			);
			($data['orcatrata']['QuitadoOrca'] == 'S') ?
				$data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
				
			$data['radio'] = array(
				'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Finalizado', 'NS'),
			);
			($data['orcatrata']['FinalizadoOrca'] == 'N') ?
				$data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
			);
			($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
				$data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
			);
			($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
				$data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'Entrega_Orca' => $this->basico->radio_checked($data['orcatrata']['Entrega_Orca'], 'Entrega', 'NS'),
			);
			($data['orcatrata']['Entrega_Orca'] == 'S') ?
				$data['div']['Entrega_Orca'] = '' : $data['div']['Entrega_Orca'] = 'style="display: none;"';
			
			
			$data['radio'] = array(
				'UsarCashBack' => $this->basico->radio_checked($data['orcatrata']['UsarCashBack'], 'UsarCashBack', 'NS'),
			);
			($data['orcatrata']['UsarCashBack'] == 'S') ?
				$data['div']['UsarCashBack'] = '' : $data['div']['UsarCashBack'] = 'style="display: none;"';		
			
			$data['radio'] = array(
				'UsarCupom' => $this->basico->radio_checked($data['orcatrata']['UsarCupom'], 'UsarCupom', 'NS'),
			);
			($data['orcatrata']['UsarCupom'] == 'S') ?
				$data['div']['UsarCupom'] = '' : $data['div']['UsarCupom'] = 'style="display: none;"';		
			
			$data['radio'] = array(
				'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Or�amento Cancelado', 'NS'),
			);
			($data['orcatrata']['CanceladoOrca'] == 'N') ?
				$data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';	
				
			#Ver uma solu��o melhor para este campo
			#(!$data['orcatrata']['TipoFinanceiro']) ? $data['orcatrata']['TipoFinanceiro'] = '1' : FALSE;
	/*
			$data['radio'] = array(
				'TipoFinanceiro' => $this->basico->radio_checked($data['orcatrata']['TipoFinanceiro'], 'Tarefa Aprovado', 'NS'),
			);

			($data['orcatrata']['TipoFinanceiro'] == '1') ? $data['div']['TipoFinanceiro'] = '' : $data['div']['TipoFinanceiro'] = 'style="display: none;"';			
	*/
			$data['sidebar'] = 'col-sm-3 col-md-2';
			$data['main'] = 'col-sm-7 col-md-8';

			$data['datepicker'] = 'DatePicker';
			$data['timepicker'] = 'TimePicker';
			
			$data['cor_cli'] 	= 'default';
			$data['cor_cons'] 	= 'default';
			$data['cor_orca'] 	= 'warning';
			$data['cor_sac'] 	= 'default';
			$data['cor_mark'] 	= 'default';

			$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

			$data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);

			$data['somatotal'] = floatval ($data['somatotal']);
			$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];
			
			$epsilon = 0.001;

			if(abs($data['diferenca']) < $epsilon){
				$data['diferenca'] = 0.00;
			}else{
				$data['diferenca'] = $data['diferenca'];
			}
			
			$data['diferenca'] = floatval ($data['diferenca']);  
			
			$data['q3'] = $this->Clientepet_model->list_racapet(TRUE);
			$data['list3'] = $this->load->view('clientepet/list_racapet', $data, TRUE);

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			#### App_OrcaTrata ####
			
			if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
				if($data['diferenca'] < 0.00){
					$data['diferenca'] = number_format($data['diferenca'],2,",",".");
					//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
					$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
				}elseif($data['diferenca'] > 0.00){
					$data['diferenca'] = number_format($data['diferenca'],2,",",".");
					//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
					$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
				}
			}
			if ($data['valortotalorca'] <= 0.00 ) {
				$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
			}
			
			if ($_SESSION['log']['NivelEmpresa'] >= '4' && $data['orcatrata']['Cli_Forn_Orca'] == "S") {
				$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim|valid_cliente');
				$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');
			} else {
				$data['cadastrar']['Cadastrar'] = 'S';
			}
			$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
			$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
			$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
			if ($_SESSION['log']['NivelEmpresa'] >= '4') {
				$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
			}
			//$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas Tem que ser maior que "0" ', 'required|trim|valid_qtdparcelas');
			$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas Tem que ser maior que "0" ', 'required|trim');
			$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');		
			
			if($data['orcatrata']['TipoFrete'] !=1){
				if($data['orcatrata']['AVAP'] == 'O'){
					if($data['orcatrata']['FormaPagamento'] == '1' || $data['orcatrata']['FormaPagamento'] == '2' || $data['orcatrata']['FormaPagamento'] == '3'){
						$this->form_validation->set_rules('Cep', 'Cep', 'required|trim');
						$this->form_validation->set_rules('Logradouro', 'Endere�o', 'required|trim');
						$this->form_validation->set_rules('Numero', 'Numero', 'required|trim');
						$this->form_validation->set_rules('Bairro', 'Bairro', 'required|trim');
						$this->form_validation->set_rules('Cidade', 'Cidade', 'required|trim');
						$this->form_validation->set_rules('Estado', 'Estado', 'required|trim');
					}
				}
			}

			#run form validation
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('orcatrata/form_orcatrata3', $data);
			} else {

				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'orcatrata/cadastrar3' . $data['msg']);

				} else {

					////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
					#### App_OrcaTrata ####
					if ($data['orcatrata']['Entrega_Orca'] == "S") {	
						if ($data['orcatrata']['TipoFrete'] == '1') {
							$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
							$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
							$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
							$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
							$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
							$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
							$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
							$data['orcatrata']['Referencia'] = '';
						} else {	
							$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
							$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
							$data['orcatrata']['Numero'] = trim(mb_strtoupper($numero1, 'ISO-8859-1'));
							$data['orcatrata']['Complemento'] = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));
							$data['orcatrata']['Bairro'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
							$data['orcatrata']['Cidade'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
							$data['orcatrata']['Estado'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));
							$data['orcatrata']['Referencia'] = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));
						}
					} else {
						$data['orcatrata']['Cep'] = '';
						$data['orcatrata']['Logradouro'] = '';
						$data['orcatrata']['Numero'] = '';
						$data['orcatrata']['Complemento'] = '';
						$data['orcatrata']['Bairro'] = '';
						$data['orcatrata']['Cidade'] = '';
						$data['orcatrata']['Estado'] = '';
						$data['orcatrata']['Referencia'] = '';
					}
					$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
					$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
					$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
					$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
					$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));
					$data['orcatrata']['TipoFinanceiro'] = $data['orcatrata']['TipoFinanceiro'];
					$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
					$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
					//$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
					//$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
					//$data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
					//$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
					$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
					$data['orcatrata']['Tipo_Orca'] = "B";
					
					if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
					} 
					if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
					} 
					if($data['orcatrata']['ConcluidoOrca'] == 'S'){
						$data['orcatrata']['CombinadoFrete'] = "S";
					} 
					if($data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
					} 
					if ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
						$data['orcatrata']['EnviadoOrca'] = "S";
					}
					
					$data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
					$data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
					$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
					//$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
					//$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
					if($data['orcatrata']['FormaPagamento'] == "7"){
						$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
						$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
					}else{
						$data['orcatrata']['ValorDinheiro'] = 0.00;
						$data['orcatrata']['ValorTroco'] = 0.00;
					}
					$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
					$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
					$data['orcatrata']['PercExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['PercExtraOrca']));
					
					$data['orcatrata']['DescPercOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescPercOrca']));
					$data['orcatrata']['DescValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescValorOrca']));

					$data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
					$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
					$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
					$data['orcatrata']['SubValorFinal'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['SubValorFinal']));
					$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
					$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'mysql');
					$data['CashBackAtual'] = $data['orcatrata']['CashBackOrca'];
					$data['ValidadeAtual'] = $data['orcatrata']['ValidadeCashBackOrca'];
					if($data['orcatrata']['UsarCashBack'] == "N"){
						$data['orcatrata']['CashBackOrca'] = 0.00;
						$data['orcatrata']['ValidadeCashBackOrca'] = "0000-00-00";
					}
					/*
					if($data['orcatrata']['UsarCashBack'] == "S"){
						$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
					}else{
						$data['orcatrata']['CashBackOrca'] = 0.00;
					}			
					*/
					$data['orcatrata']['ValorFinalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
					
					$data['orcatrata']['idTab_TipoRD'] = "2";

					if($_SESSION['Usuario']['Nivel'] == 2){
						$data['orcatrata']['NivelOrca'] = 2;
					}else{
						$data['orcatrata']['NivelOrca'] = 1;
					}
					
					$data['orcatrata']['idSis_Empresa'] 	= $_SESSION['log']['idSis_Empresa']; 
					$data['orcatrata']['idSis_Usuario'] 	= $_SESSION['log']['idSis_Usuario']; // quem cadastrou o pedido
					$data['orcatrata']['id_Funcionario'] 	= $_SESSION['log']['idSis_Usuario']; // quem vendeu
					$data['orcatrata']['id_Associado'] 		= 0;

					if($data['orcatrata']['Entrega_Orca'] == "N"){
						$data['orcatrata']['DataEntregaOrca'] = $data['orcatrata']['DataOrca'];
						$data['orcatrata']['HoraEntregaOrca'] = "00:00:00";
						$data['orcatrata']['PrazoProdServ'] = 0;
						$data['orcatrata']['PrazoCorreios'] = 0;
						$data['orcatrata']['PrazoEntrega'] = 0;
					}
					
					if (!$data['orcatrata']['PrazoEntrega']){
						//$data1 = date('Y-m-d', time());
						$data1 = $data['orcatrata']['DataOrca'];
						$data2 = $data['orcatrata']['DataEntregaOrca'];
						$intervalo = strtotime($data2)-strtotime($data1); 
						$dias = floor($intervalo / (60 * 60 * 24));
						$data['orcatrata']['PrazoEntrega'] = $dias;
					}

					//$data['orcatrata']['ValorFatura'] = $data['orcatrata']['ValorTotalOrca'];
					$data['orcatrata']['ValorFatura'] = $data['orcatrata']['ValorFinalOrca'];
					
					if($data['orcatrata']['AVAP'] == "O" && ($data['orcatrata']['FormaPagamento'] == "1" || $data['orcatrata']['FormaPagamento'] == "2" || $data['orcatrata']['FormaPagamento'] == "3")){
						$data['orcatrata']['ValorGateway'] = ($data['orcatrata']['ValorFatura'] * 0.04) + 0.40;
					}else{
						$data['orcatrata']['ValorGateway'] = 0.00;
					}
					$data['orcatrata']['ValorEmpresa'] = $data['orcatrata']['ValorFatura'] - $data['orcatrata']['ValorComissao'] - $data['orcatrata']['ValorGateway'];			

					if ($data['orcatrata']['Cli_Forn_Orca'] == 'S'){
						if ($data['orcatrata']['UsarCashBack'] == 'S' && $data['orcatrata']['idApp_Cliente'] != 0){
							$data['orcatrata']['AtivoCashBack'] = 'N';
						}
					}else{
						$data['orcatrata']['AtivoCashBack'] = 'N';
					}
					
					if($data['orcatrata']['UsarCupom'] == "S"){
						$data['orcatrata']['TipoDescOrca'] = $data['cadastrar']['UsarE'];
						if($data['cadastrar']['ValidaCupom'] == 0 || !$data['orcatrata']['Cupom'] || empty($data['orcatrata']['Cupom'])){
							$data['orcatrata']['Cupom'] = 0;
						}
					}else{
						$data['orcatrata']['Cupom'] = 0;
					}

					### pego o Valor da Comiss�o do Funcion�rio ###
					if($_SESSION['Usuario']['Nivel'] != 2){
						$data['orcatrata']['ComissaoFunc'] = $_SESSION['Usuario']['Comissao'];
					}else{
						$data['Funcionario'] = $this->Usuario_model->get_funcionario($_SESSION['Usuario']['QuemCad']);
						if($data['Funcionario'] !== FALSE){
							$data['orcatrata']['ComissaoFunc'] = $data['Funcionario']['Comissao'];
						}else{
							$data['orcatrata']['ComissaoFunc'] = 0;
						}
					}
					$data['orcatrata']['ValorComissaoFunc'] = 0;
					$data['orcatrata']['ValorComissaoAssoc'] = 0;

					/*
					echo '<br>';
					echo "<pre>";
					print_r($data['Funcionario']);
					echo '<br>';
					print_r('ComissaoFunc = ' . $data['Funcionario']['Comissao']);
					echo '<br>';
					//print_r('TipoDescOrca = ' . $data['orcatrata']['TipoDescOrca']);
					echo '<br>';
					//print_r('ValidaCupom = ' . $data['cadastrar']['ValidaCupom']);
					echo '<br>';
					//print_r('Cupom = ' . $data['orcatrata']['Cupom']);
					echo "</pre>";	
					exit ();
					*/
					/*
					//uso estas linhas apenas para testar a pesquisa do cashbak
					if ($data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['UsarCashBack'] == 'S' && $data['orcatrata']['idApp_Cliente'] != 0){
						$data['update']['cashback'] = $this->Orcatrata_model->get_produto_cashback($data['orcatrata']['idApp_Cliente']);
						if (isset($data['update']['cashback'])){
							$count_cash = count($data['update']['cashback']);
							echo '<br>';
							echo "<pre>";
							print_r($count_cash);
							echo '<br>';
							print_r($data['update']['cashback']);
							echo "</pre>";
							
						}
					}			
					exit ();
					*/
					
					$data['orcatrata']['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['orcatrata']);
					
					
					if ($data['orcatrata']['idApp_OrcaTrata'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('orcatrata/form_orcatrata3', $data);
					} else {			

						#### Whatsapp ####
						if ($data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['cadastrar']['Whatsapp'] == 'S'){
							if (isset($data['orcatrata']['idApp_Cliente']) && $data['orcatrata']['idApp_Cliente'] != 0){
								$_SESSION['bd_orcamento']['Whatsapp'] = $data['cadastrar']['Whatsapp'];
								$_SESSION['bd_orcamento']['Whatsapp_Site'] = $data['cadastrar']['Whatsapp_Site'];
							}
						}			
					
						#### APP_Cliente ####
						if ($data['cadastrar']['AtualizaEndereco'] == 'S' && $data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['Entrega_Orca'] == "S" && $data['orcatrata']['idApp_Cliente'] != 0){
							$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
							$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
							$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
							$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
							$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
							$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
							$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
							$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
										
							$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
							$data['update']['cliente']['campos'] = array_keys($data['cliente']);
							/*
							$data['update']['cliente']['auditoriaitem'] = $this->basico->set_log(
								$data['update']['cliente']['anterior'],
								$data['cliente'],
								$data['update']['cliente']['campos'],
								$data['cliente']['idApp_Cliente'], TRUE);
							*/	
							$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);
							
							/*
							// ""ver modo correto de fazer o set_log e set_auditoria""
							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}
							*/
							
						}
						
						//in�cio do c�digo que ser� desligado. N�o preciso dizer qual produto foi pago o cashback
						/*
						if ($data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['UsarCashBack'] == 'S' && $data['orcatrata']['idApp_Cliente'] != 0){
							$data['update']['cashback'] = $this->Orcatrata_model->get_produto_cashback($data['orcatrata']['idApp_Cliente']);
							if (isset($data['update']['cashback'])){
								$count_cash = count($data['update']['cashback']);
								for($k=0;$k<$count_cash;$k++) {
									
									$data['update']['cashback'][$k]['StatusComissaoCashBack'] = 'S';
									$data['update']['cashback'][$k]['DataPagoCashBack'] = $data['orcatrata']['DataOrca'];
									$data['update']['cashback'][$k]['id_Orca_CashBack'] = $data['orcatrata']['idApp_OrcaTrata'];
									
									$data['update']['cashback']['bd'] = $this->Orcatrata_model->update_produto_id($data['update']['cashback'][$k], $data['update']['cashback'][$k]['idApp_Produto']);
								
								
								}
							}
						}
						*/
						//fim do c�digo que ser� desligado
						
						$data['CashBackServicos'] = 0;
						$data['ComAssocServicos'] = 0;
						$data['ComFuncServicos'] = 0;
						#### App_Servico ####
						if (isset($data['servico'])) {
							$max = count($data['servico']);
							for($j=1;$j<=$max;$j++) {
							
								$data['servico'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['servico'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['servico'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['servico'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
								$data['servico'][$j]['idTab_TipoRD'] = "2";
								$data['servico'][$j]['NivelProduto'] = $_SESSION['Usuario']['Nivel'];
								
								if(!$data['servico'][$j]['ProfissionalProduto_1']){
									$data['servico'][$j]['ProfissionalProduto_1'] = 0;
								}
								if(!$data['servico'][$j]['ProfissionalProduto_2']){
									$data['servico'][$j]['ProfissionalProduto_2'] = 0;
								}
								if(!$data['servico'][$j]['ProfissionalProduto_3']){
									$data['servico'][$j]['ProfissionalProduto_3'] = 0;
								}
								if(!$data['servico'][$j]['ProfissionalProduto_4']){
									$data['servico'][$j]['ProfissionalProduto_4'] = 0;
								}
								if(!$data['servico'][$j]['ProfissionalProduto_5']){
									$data['servico'][$j]['ProfissionalProduto_5'] = 0;
								}
								if(!$data['servico'][$j]['ProfissionalProduto_6']){
									$data['servico'][$j]['ProfissionalProduto_6'] = 0;
								}
								
								if(empty($data['servico'][$j]['ValorProduto'])){
									$data['servico'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['servico'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorProduto']));
								}
								
								if(empty($data['servico'][$j]['ValorComProf_1'])){
									$data['servico'][$j]['ValorComProf_1'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_1']));
								}
								
								if(empty($data['servico'][$j]['ValorComProf_2'])){
									$data['servico'][$j]['ValorComProf_2'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_2']));
								}
								
								if(empty($data['servico'][$j]['ValorComProf_3'])){
									$data['servico'][$j]['ValorComProf_3'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_3']));
								}
								
								if(empty($data['servico'][$j]['ValorComProf_4'])){
									$data['servico'][$j]['ValorComProf_4'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_4']));
								}
								
								if(empty($data['servico'][$j]['ValorComProf_5'])){
									$data['servico'][$j]['ValorComProf_5'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_5']));
								}
								
								if(empty($data['servico'][$j]['ValorComProf_6'])){
									$data['servico'][$j]['ValorComProf_6'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_6']));
								}
								
								if(empty($data['servico'][$j]['ValorComissaoServico'])){
									$data['servico'][$j]['ValorComissaoServico'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComissaoServico']));
								}
								
								$data['servico'][$j]['ValorComissaoVenda'] = $data['servico'][$j]['SubtotalComissaoProduto'];
								
								//$data['servico'][$j]['ValorComissaoServico'] = $data['servico'][$j]['SubtotalComissaoServicoProduto'];
								$data['servico'][$j]['ValorComissaoAssociado'] = $data['servico'][$j]['SubtotalComissaoServicoProduto'];
								$data['ComAssocServicos'] += $data['servico'][$j]['ValorComissaoAssociado'];

								$data['servico'][$j]['ValorComissaoFuncionario'] = $data['servico'][$j]['QtdProduto']*$data['servico'][$j]['ValorProduto']*$data['orcatrata']['ComissaoFunc']/100;
								$data['ComFuncServicos'] += $data['servico'][$j]['ValorComissaoFuncionario'];
								
								$data['servico'][$j]['ValorComissaoCashBack'] = $data['servico'][$j]['SubtotalComissaoCashBackProduto'];
								$data['CashBackServicos'] += $data['servico'][$j]['ValorComissaoCashBack'];

								if(!$data['servico'][$j]['DataValidadeProduto'] || $data['servico'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['servico'][$j]['DataValidadeProduto'])){
									$data['servico'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'mysql');
								}

								if(!$data['servico'][$j]['DataConcluidoProduto'] || $data['servico'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['servico'][$j]['DataConcluidoProduto'])){
									$data['servico'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['servico'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['servico'][$j]['HoraConcluidoProduto'] || $data['servico'][$j]['HoraConcluidoProduto'] == "00:00"){
									$data['servico'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['servico'][$j]['HoraConcluidoProduto'] = $data['servico'][$j]['HoraConcluidoProduto'];
								}
								
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['servico'][$j]['ConcluidoProduto'] = 'S';
								}else{
									$data['servico'][$j]['ConcluidoProduto'] = $data['servico'][$j]['ConcluidoProduto'];
								}
								/*
								if ($data['servico'][$j]['ConcluidoProduto'] == 'S') {
									if(!$data['servico'][$j]['DataConcluidoProduto']){
										$data['servico'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['servico'][$j]['DataConcluidoProduto'] = $data['servico'][$j]['DataConcluidoProduto'];
									}
									if(!$data['servico'][$j]['HoraConcluidoProduto'] || $data['servico'][$j]['HoraConcluidoProduto'] == "00:00"){
										$data['servico'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
									}else{
										$data['servico'][$j]['HoraConcluidoProduto'] = $data['servico'][$j]['HoraConcluidoProduto'];
									}
								}else{
									$data['servico'][$j]['DataConcluidoProduto'] = "0000-00-00";
									$data['servico'][$j]['HoraConcluidoProduto'] = "00:00";
								}
								*/
								unset($data['servico'][$j]['SubtotalProduto']);
								unset($data['servico'][$j]['SubtotalComissaoProduto']);
								unset($data['servico'][$j]['SubtotalComissaoServicoProduto']);
								unset($data['servico'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['servico'][$j]['SubtotalQtdProduto']);	
							}
							$data['servico']['idApp_Produto'] = $this->Orcatrata_model->set_servico($data['servico']);
						}

						$data['CashBackProdutos'] = 0;
						$data['ComAssocProdutos'] = 0;
						$data['ComFuncProdutos'] = 0;
						#### App_Produto ####
						if (isset($data['produto'])) {
							$max = count($data['produto']);
							for($j=1;$j<=$max;$j++) {
								
								$data['produto'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['produto'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['produto'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['produto'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
								$data['produto'][$j]['idTab_TipoRD'] = "2";
								$data['produto'][$j]['NivelProduto'] = $_SESSION['Usuario']['Nivel'];
								
								if(empty($data['produto'][$j]['ValorProduto'])){
									$data['produto'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['produto'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorProduto']));
								}
									
								$data['produto'][$j]['ValorComissaoVenda'] = $data['produto'][$j]['SubtotalComissaoProduto'];
								
								//$data['produto'][$j]['ValorComissaoServico'] = $data['produto'][$j]['SubtotalComissaoServicoProduto'];
								$data['produto'][$j]['ValorComissaoAssociado'] = $data['produto'][$j]['SubtotalComissaoServicoProduto'];
								$data['ComAssocProdutos'] += $data['produto'][$j]['ValorComissaoAssociado'];

								$data['produto'][$j]['ValorComissaoFuncionario'] = $data['produto'][$j]['QtdProduto']*$data['produto'][$j]['ValorProduto']*$data['orcatrata']['ComissaoFunc']/100;
								$data['ComFuncProdutos'] += $data['produto'][$j]['ValorComissaoFuncionario'];
								
								$data['produto'][$j]['ValorComissaoCashBack'] = $data['produto'][$j]['SubtotalComissaoCashBackProduto'];
								$data['CashBackProdutos'] += $data['produto'][$j]['ValorComissaoCashBack'];

								if(!$data['produto'][$j]['DataValidadeProduto'] || $data['produto'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['produto'][$j]['DataValidadeProduto'])){
									$data['produto'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'mysql');
								}						
								
								if(!$data['produto'][$j]['DataConcluidoProduto'] || $data['produto'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['produto'][$j]['DataConcluidoProduto'])){
									$data['produto'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['produto'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['produto'][$j]['HoraConcluidoProduto'] || $data['produto'][$j]['HoraConcluidoProduto'] == "00:00"){
									$data['produto'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['produto'][$j]['HoraConcluidoProduto'] = $data['produto'][$j]['HoraConcluidoProduto'];
								}
									
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') {
									$data['produto'][$j]['ConcluidoProduto'] = 'S';
								}else{
									$data['produto'][$j]['ConcluidoProduto'] = $data['produto'][$j]['ConcluidoProduto'];
								}
								
								/*
								if ($data['produto'][$j]['ConcluidoProduto'] == 'S') {
									if(!$data['produto'][$j]['DataConcluidoProduto']){
										$data['produto'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['produto'][$j]['DataConcluidoProduto'] = $data['produto'][$j]['DataConcluidoProduto'];
									}
									if(!$data['produto'][$j]['HoraConcluidoProduto'] || $data['produto'][$j]['HoraConcluidoProduto'] == "00:00"){
										$data['produto'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
									}else{
										$data['produto'][$j]['HoraConcluidoProduto'] = $data['produto'][$j]['HoraConcluidoProduto'];
									}
								}else{
									$data['produto'][$j]['DataConcluidoProduto'] = "0000-00-00";
									$data['produto'][$j]['HoraConcluidoProduto'] = "00:00";
								}
								*/
								if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
									$data['produto'][$j]['DevolvidoProduto'] = 'S';
								} else {
									$data['produto'][$j]['DevolvidoProduto'] = $data['produto'][$j]['DevolvidoProduto'];
								}

								unset($data['produto'][$j]['SubtotalProduto']);
								unset($data['produto'][$j]['SubtotalComissaoProduto']);
								unset($data['produto'][$j]['SubtotalComissaoServicoProduto']);
								unset($data['produto'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['produto'][$j]['SubtotalQtdProduto']);
								
							}
							
							//exit ();
							
							$data['produto']['idApp_Produto'] = $this->Orcatrata_model->set_produto($data['produto']);
						}

						#### App_ParcelasRec ####
						if (isset($data['parcelasrec'])) {
							$max = count($data['parcelasrec']);
							for($j=1;$j<=$max;$j++) {
								$data['parcelasrec'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['parcelasrec'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['parcelasrec'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['parcelasrec'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['parcelasrec'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
								$data['parcelasrec'][$j]['idTab_TipoRD'] = "2";
								$data['parcelasrec'][$j]['NivelParcela'] = $_SESSION['Usuario']['Nivel'];
								
								$data['parcelasrec'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorParcela']));
								
								//$data['parcelasrec'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorPago']));
								
								$data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'mysql');
								
								$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'mysql');
								
								if ($data['parcelasrec'][$j]['FormaPagamentoParcela']) {
									$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $data['parcelasrec'][$j]['FormaPagamentoParcela'];
								}else{
									$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
								}
								
								if ($data['orcatrata']['QuitadoOrca'] == 'S') {
									$data['parcelasrec'][$j]['Quitado'] = 'S';
								} else {
									$data['parcelasrec'][$j]['Quitado'] = $data['parcelasrec'][$j]['Quitado'];
								}
								
								if ($data['parcelasrec'][$j]['Quitado'] == 'S') {
									if (!$data['parcelasrec'][$j]['DataPago']){
										$data['parcelasrec'][$j]['DataPago'] = $data['parcelasrec'][$j]['DataVencimento'];
									} else {
										$data['parcelasrec'][$j]['DataPago'] = $data['parcelasrec'][$j]['DataPago'];
									}
									
									$data['parcelasrec'][$j]['DataLanc'] = date('Y-m-d', time());
									
								} else {
									$data['parcelasrec'][$j]['DataPago'] = "0000-00-00";
									$data['parcelasrec'][$j]['DataLanc'] = "0000-00-00";
								}
							}
							$data['parcelasrec']['idApp_Parcelas'] = $this->Orcatrata_model->set_parcelas($data['parcelasrec']);
						}			

						#### App_Procedimento ####
						if (isset($data['procedimento'])) {
							$max = count($data['procedimento']);
							for($j=1;$j<=$max;$j++) {
								$data['procedimento'][$j]['TipoProcedimento'] = 2;
								$data['procedimento'][$j]['NivelProcedimento'] = $_SESSION['Usuario']['Nivel'];
								$data['procedimento'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								if(!$data['procedimento'][$j]['Compartilhar']){
									$data['procedimento'][$j]['Compartilhar'] = $_SESSION['log']['idSis_Usuario'];
								}
								$data['procedimento'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['procedimento'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['procedimento'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
								$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'mysql');
								
								if(!$data['procedimento'][$j]['DataConcluidoProcedimento']){
									$data['procedimento'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
								}else{
									$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataConcluidoProcedimento'], 'mysql');
								}
							
							}
							$data['procedimento']['idApp_Procedimento'] = $this->Orcatrata_model->set_procedimento($data['procedimento']);
						}
						/*
						$data['update']['servico']['posterior'] = $this->Orcatrata_model->get_servico_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['servico']['posterior'])){
							$max_produto = count($data['update']['servico']['posterior']);
							if($max_produto == 0){
								$data['orcatrata']['ConcluidoOrca'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
								$data['orcatrata']['CombinadoFrete'] = "S";
							}else{
								$data['orcatrata']['ConcluidoOrca'] = "N";
							}
						}
						*/
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_contagem($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto > 0){
								$data['orcatrata']['Prd_Srv_Orca'] = "S";
							}
						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto == 0){
								$data['orcatrata']['CombinadoFrete'] = "S";
								#$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
								$data['orcatrata']['ConcluidoOrca'] = "S";
							}else{
								$data['orcatrata']['ConcluidoOrca'] = "N";
							}
						}
						
						$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['parcelasrec']['posterior'])){
							$max_parcela = count($data['update']['parcelasrec']['posterior']);
							if($max_parcela == 0){
								#$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['QuitadoOrca'] = "S";				
							}else{
								$data['orcatrata']['QuitadoOrca'] = "N";
							}

						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto > 0){
								$data['orcatrata']['CombinadoFrete'] = "S";
								#$data['orcatrata']['AprovadoOrca'] = "S";
							}
						}			

						$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);	
						if (isset($data['update']['parcelasrec']['posterior'])){
							$max_parcela = count($data['update']['parcelasrec']['posterior']);
							if($max_parcela > 0){
								#$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['AprovadoOrca'] = "S";				
							}

						}			
						
						if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['FinalizadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
						}else{
							$data['orcatrata']['FinalizadoOrca'] = "N";
						}
						
						$data['CashBackNovo'] = $data['CashBackServicos'] + $data['CashBackProdutos'];

						//Se existir Cliente  Atualizo ou n�o o valor do cashback no campo CashBackCliente do Cliente
						
							if(isset($data['orcatrata']['idApp_Cliente']) && $data['orcatrata']['idApp_Cliente'] !=0){
								if($data['orcatrata']['UsarCashBack'] == "S"){
									if($data['orcatrata']['QuitadoOrca'] == "S"){
										//CashBackCliente = novo valor;
										$data['cliente_cashback']['CashBackCliente'] = $data['CashBackNovo'];
										$data['cliente_cashback']['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
									}else{
										//CashBackCliente = 0.00;
										$data['cliente_cashback']['CashBackCliente'] = '0.00';
									}
								}else{
									if($data['orcatrata']['QuitadoOrca'] == "S"){
										//CashBackCliente = velho valor + novo valor;
										$data['cliente_cashback']['CashBackCliente'] = $data['CashBackAtual'] + $data['CashBackNovo'];
										$data['cliente_cashback']['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
									}else{
										//CashBackCliente = velho valor;
										$data['cliente_cashback']['CashBackCliente'] = $data['CashBackAtual'];
										
									}
								}
								//fa�o o update no cliente
								
								$data['update']['cliente_cashback']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
								
								$data['update']['cliente_cashback']['campos'] = array_keys($data['cliente_cashback']);
				
								if(strtotime($data['update']['cliente_cashback']['anterior']['UltimoPedido']) < strtotime($data['orcatrata']['DataOrca'])){
								
									$data['cliente_cashback']['UltimoPedido'] 		= $data['orcatrata']['DataOrca'];
									$data['cliente_cashback']['id_UltimoPedido'] 	= $data['orcatrata']['idApp_OrcaTrata'];
									
								}else if(strtotime($data['update']['cliente_cashback']['anterior']['UltimoPedido']) == strtotime($data['orcatrata']['DataOrca'])){
									
									if($data['update']['cliente_cashback']['anterior']['id_UltimoPedido'] < $data['orcatrata']['idApp_OrcaTrata']){
										
										$data['cliente_cashback']['id_UltimoPedido'] = $data['orcatrata']['idApp_OrcaTrata'];
									
									}
									
								}else{
									
									if($data['update']['cliente_cashback']['anterior']['id_UltimoPedido'] == $data['orcatrata']['idApp_OrcaTrata']){

										$data['get_ult_pdd_cliente'] = $this->Orcatrata_model->get_ult_pdd_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
										$data['cliente_cashback']['UltimoPedido'] = $data['get_ult_pdd_cliente']['DataOrca'];
										$data['cliente_cashback']['id_UltimoPedido'] = $data['get_ult_pdd_cliente']['idApp_OrcaTrata'];						
									}
									
								}

								$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);					
							
							}
						
						$data['orcatrata']['ValorComissaoFunc'] = $data['ComFuncServicos'] + $data['ComFuncProdutos'];
						$data['orcatrata']['ValorComissaoFunc'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorComissaoFunc']));
						
						$data['orcatrata']['ValorComissaoAssoc'] = $data['ComAssocServicos'] + $data['ComAssocProdutos'];
						$data['orcatrata']['ValorComissaoAssoc'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorComissaoAssoc']));
						
						$data['orcatrata']['RepeticaoOrca'] = $data['orcatrata']['idApp_OrcaTrata'];
						$data['orcatrata']['RecorrenciasOrca'] = "1";
						$data['orcatrata']['RecorrenciaOrca'] = "1/1";
						
						$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$data['orcatrata']['idApp_OrcaTrata'], TRUE);
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);
						
						#### Estoque_Produto_posterior ####
						
							if ($data['orcatrata']['CombinadoFrete'] == 'S' && $data['orcatrata']['CanceladoOrca'] == 'N') {
								
								$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['busca']['estoque']['posterior']);
								echo "</pre>";
								exit ();
								*/
								if (count($data['busca']['estoque']['posterior']) > 0) {
									
									$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
									$max_estoque = count($data['busca']['estoque']['posterior']);
									
									if (isset($data['busca']['estoque']['posterior'])){
										
										for($j=1;$j<=$max_estoque;$j++) {
											
											$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
											
											if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
												
												$qtd_produto[$j]	= ($data['busca']['estoque']['posterior'][$j]['QtdProduto'] * $data['busca']['estoque']['posterior'][$j]['QtdIncrementoProduto']);
												
												$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] - $qtd_produto[$j]);
												
												if($diff_estoque[$j] <= 0){
													$estoque[$j] = 0; 
												}else{
													$estoque[$j] = $diff_estoque[$j]; 
												}
												
												$data['alterar']['produto']['posterior'][$j]['Estoque'] = $estoque[$j];
												$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$j], $data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
												
												unset($qtd_produto[$j]);
												unset($diff_estoque[$j]);
												unset($estoque[$j]);
											}
											
										}
										
									}
									
								}
								
							}			
						
						/*
						/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
									$data['campos'] = array_keys($data['query']);
									$data['anterior'] = array();
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
						//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
						*/
						//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
						//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';


						redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);				
						exit();
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }
	
    public function alterar($id = FALSE) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Edit_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 3)
				$data['msg'] = $this->basico->msg('<strong>N�o � poss�vel salvar as altera��es.<br>N�o identificamos o pagamento da sua �ltima Fatura.<br>Por favor, Entre em contato com a administra��o da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
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
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'ConcluidoProduto',
				'QuitadoParcelas',
				'Cadastrar',
				'Whatsapp',
				'Whatsapp_Site',
				'AtualizaEndereco',
				'StatusProdutos',
				'StatusParcelas',
				'PeloPet',
				'PortePet',
				'EspeciePet',
				'RacaPet',
				'RelacaoDep',
				'Valor_S_Desc',
				'Valor_C_Desc',
				'UsarC',
				'UsarD',
				'UsarE',
				'ValidaCupom',
				'MensagemCupom',
				'CodigoCupom',
			), TRUE));

	        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['orcatrata'] = quotes_to_entities($this->input->post(array(
				#### App_OrcaTrata ####
				'idApp_OrcaTrata',
				#N�o h� a necessidade de atualizar o valor do campo a seguir
				'idApp_Cliente',
				'idApp_ClientePet',
				'idApp_ClienteDep',
				'DataOrca',
				'TipoFinanceiro',
				'Descricao',
				'AprovadoOrca',
				'ConcluidoOrca',
				'BrindeOrca',
				'DevolvidoOrca',
				'ProntoOrca',
				'QuitadoOrca',
				'FinalizadoOrca',
				'ValorOrca',
				'ValorComissao',
				'QtdPrdOrca',
				'QtdSrvOrca',
				'PrazoProdutos',
				'PrazoServicos',
				'PrazoProdServ',
				'PrazoCorreios',
				'ValorDev',
				'ValorDinheiro',
				'ValorTroco',
				'ValorRestanteOrca',
				'FormaPagamento',
				//'QtdParcelasOrca',
				//'DataVencimentoOrca',
				'ObsOrca',
				'Consideracoes',
				'Modalidade',
				#'idTab_TipoRD',
				'AVAP',
				'Tipo_Orca',
				'EnviadoOrca',
				'Cep',
				'Logradouro',
				'Numero',
				'Complemento',
				'Bairro',
				'Cidade',
				'Estado',
				'Referencia',
				'TipoFrete',
				'ValorFrete',
				'ValorExtraOrca',
				'PercExtraOrca',
				'ValorSomaOrca',
				'CombinadoFrete',
				'PrazoEntrega',
				'ValorTotalOrca',
				'Entregador',
				'DataEntregaOrca',
				'HoraEntregaOrca',
				'NomeRec',
				'TelefoneRec',
				'ParentescoRec',
				'ObsEntrega',
				'Aux1Entrega',
				'Aux2Entrega',
				'DetalhadaEntrega',
				'CanceladoOrca',
				'Cli_Forn_Orca',
				'Prd_Srv_Orca',
				'Entrega_Orca',
				'TipoDescOrca',
				'TipoExtraOrca',
				'DescPercOrca',
				'DescValorOrca',
				'CashBackOrca',
				'ValidadeCashBackOrca',
				'UsarCashBack',
				'UsarCupom',
				'Cupom',
				'SubValorFinal',
				'ValorFinalOrca',
			), TRUE));
			
			$data['cliente'] = $this->input->post(array(
				'idApp_Cliente',
				'CepCliente',
				'EnderecoCliente',
				'NumeroCliente',
				'ComplementoCliente',
				'CidadeCliente',
				'BairroCliente',
				'MunicipioCliente',
				'EstadoCliente',
				'ReferenciaCliente',
			), TRUE);

			$caracteres_sem_acento = array(
				'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
				'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
				'�'=>'I', '�'=>'N', 'N'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
				'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
				'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
				'�'=>'i', '�'=>'o', '�'=>'n', 'n'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
				'�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f',
				'a'=>'a', '�'=>'i', '�'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', '�'=>'I', '�'=>'A', '?'=>'S', '?'=>'T',
			);

			$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Logradouro'], $caracteres_sem_acento));

			$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['orcatrata']['Cep'], $caracteres_sem_acento));

			$numero1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Numero'], $caracteres_sem_acento));

			$complemento1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Complemento'], $caracteres_sem_acento));

			$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Bairro'], $caracteres_sem_acento));

			$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Cidade'], $caracteres_sem_acento));

			$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Estado'], $caracteres_sem_acento));

			$referencia1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Referencia'], $caracteres_sem_acento));
			
			//D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
			//comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

			($_SESSION['Usuario']['Bx_Pag'] == "S") ? $data['div']['Prof_comissao'] = '' : $data['div']['Prof_comissao'] = 'style="display: none;"';		

			(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
			(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
			(!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
			(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
			
			#(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
			(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '0' : FALSE;
			(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
			(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE; 
			(!$data['orcatrata']['Entrega_Orca']) ? $data['orcatrata']['Entrega_Orca'] = 'S' : FALSE;		
			(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['ValidadeCashBackOrca']) ? $data['orcatrata']['ValidadeCashBackOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
			//(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
			(!$data['orcatrata']['Entregador']) ? $data['orcatrata']['Entregador'] = '0' : FALSE;
			(!$data['orcatrata']['idApp_ClientePet']) ? $data['orcatrata']['idApp_ClientePet'] = '0' : FALSE;
			(!$data['orcatrata']['idApp_ClienteDep']) ? $data['orcatrata']['idApp_ClienteDep'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoProdServ']) ? $data['orcatrata']['PrazoProdServ'] = '0' : FALSE;
			(!$data['orcatrata']['ValorOrca']) ? $data['orcatrata']['ValorOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorDev']) ? $data['orcatrata']['ValorDev'] = '0.00' : FALSE;
			(!$data['orcatrata']['QtdPrdOrca']) ? $data['orcatrata']['QtdPrdOrca'] = '0' : FALSE;
			(!$data['orcatrata']['QtdSrvOrca']) ? $data['orcatrata']['QtdSrvOrca'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoProdutos']) ? $data['orcatrata']['PrazoProdutos'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoServicos']) ? $data['orcatrata']['PrazoServicos'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoCorreios']) ? $data['orcatrata']['PrazoCorreios'] = '0' : FALSE;
			(!$data['orcatrata']['TipoDescOrca']) ? $data['orcatrata']['TipoDescOrca'] = 'V' : FALSE;
			(!$data['orcatrata']['TipoExtraOrca']) ? $data['orcatrata']['TipoExtraOrca'] = 'V' : FALSE; 
			(!$data['orcatrata']['UsarCashBack']) ? $data['orcatrata']['UsarCashBack'] = 'N' : FALSE;
			(!$data['orcatrata']['UsarCupom']) ? $data['orcatrata']['UsarCupom'] = 'N' : FALSE;
			(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
			(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
			(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
			(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;	
			(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;	
			
			(!$data['orcatrata']['ValorFrete']) ? $data['orcatrata']['ValorFrete'] = 0 : FALSE;
			(!$data['orcatrata']['ValorExtraOrca']) ? $data['orcatrata']['ValorExtraOrca'] = 0 : FALSE;
			(!$data['orcatrata']['PercExtraOrca']) ? $data['orcatrata']['PercExtraOrca'] = 0 : FALSE;
			(!$data['orcatrata']['DescPercOrca']) ? $data['orcatrata']['DescPercOrca'] = 0 : FALSE;
			(!$data['orcatrata']['DescValorOrca']) ? $data['orcatrata']['DescValorOrca'] = 0 : FALSE;
			
			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE; 
			(!$data['cadastrar']['Whatsapp']) ? $data['cadastrar']['Whatsapp'] = 'N' : FALSE;
			(!$data['cadastrar']['Whatsapp_Site']) ? $data['cadastrar']['Whatsapp_Site'] = 'N' : FALSE;
			(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusProdutos']) ? $data['cadastrar']['StatusProdutos'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusParcelas']) ? $data['cadastrar']['StatusParcelas'] = 'N' : FALSE;
			(!$data['cadastrar']['ValidaCupom']) ? $data['cadastrar']['ValidaCupom'] = '0' : FALSE;
					
			$j = 1;
			for ($i = 1; $i <= $data['count']['SCount']; $i++) {

				if ($this->input->post('idTab_Servico' . $i)) {
					$data['servico'][$j]['idApp_Produto'] = $this->input->post('idApp_Servico' . $i);
					$data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
					$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
					$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
					$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
					$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
					$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
					$data['servico'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoServico' . $i);
					$data['servico'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackServico' . $i);
					$data['servico'][$j]['PrazoProduto'] = $this->input->post('PrazoServico' . $i);
					$data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
					$data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
					$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
					$data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
					$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
					$data['servico'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoServico' . $i);
					$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackServico' . $i);
					$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
					$data['servico'][$j]['ValorComissaoServico'] = $this->input->post('ValorComissaoServico' . $i);
					$data['servico'][$j]['ObsProduto'] = $this->input->post('ObsServico' . $i);
					$data['servico'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeServico' . $i);
					$data['servico'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoServico' . $i);
					$data['servico'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoServico' . $i);
					$data['servico'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoServico' . $i);
					
					$data['servico'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalServico_1' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
					}				
					$data['servico'][$j]['ProfissionalProduto_2'] = $this->input->post('ProfissionalServico_2' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_3'] = $this->input->post('ProfissionalServico_3' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_4'] = $this->input->post('ProfissionalServico_4' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_5'] = $this->input->post('ProfissionalServico_5' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_6'] = $this->input->post('ProfissionalServico_6' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
					}
					
					$data['servico'][$j]['idTFProf_1'] = $this->input->post('idTFProf_Servico_1' . $i);
					$data['servico'][$j]['ComFunProf_1'] = $this->input->post('ComFunProf_Servico_1' . $i);
					$data['servico'][$j]['ValorComProf_1'] = $this->input->post('ValorComProf_Servico_1' . $i);
					
					$data['servico'][$j]['idTFProf_2'] = $this->input->post('idTFProf_Servico_2' . $i);
					$data['servico'][$j]['ComFunProf_2'] = $this->input->post('ComFunProf_Servico_2' . $i);
					$data['servico'][$j]['ValorComProf_2'] = $this->input->post('ValorComProf_Servico_2' . $i);
					
					$data['servico'][$j]['idTFProf_3'] = $this->input->post('idTFProf_Servico_3' . $i);
					$data['servico'][$j]['ComFunProf_3'] = $this->input->post('ComFunProf_Servico_3' . $i);
					$data['servico'][$j]['ValorComProf_3'] = $this->input->post('ValorComProf_Servico_3' . $i);
					
					$data['servico'][$j]['idTFProf_4'] = $this->input->post('idTFProf_Servico_4' . $i);
					$data['servico'][$j]['ComFunProf_4'] = $this->input->post('ComFunProf_Servico_4' . $i);
					$data['servico'][$j]['ValorComProf_4'] = $this->input->post('ValorComProf_Servico_4' . $i);
					
					$data['servico'][$j]['idTFProf_5'] = $this->input->post('idTFProf_Servico_5' . $i);
					$data['servico'][$j]['ComFunProf_5'] = $this->input->post('ComFunProf_Servico_5' . $i);
					$data['servico'][$j]['ValorComProf_5'] = $this->input->post('ValorComProf_Servico_5' . $i);
					
					$data['servico'][$j]['idTFProf_6'] = $this->input->post('idTFProf_Servico_6' . $i);
					$data['servico'][$j]['ComFunProf_6'] = $this->input->post('ComFunProf_Servico_6' . $i);
					$data['servico'][$j]['ValorComProf_6'] = $this->input->post('ValorComProf_Servico_6' . $i);
					
					(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
					);
					($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';
		
					$data['select'][$j]['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_1']);
					$data['select'][$j]['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_2']);
					$data['select'][$j]['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_3']);
					$data['select'][$j]['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_4']);
					$data['select'][$j]['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_5']);
					$data['select'][$j]['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_6']);
					
					$j++;
				}

			}
			$data['count']['SCount'] = $j - 1;

			$j = 1;
			for ($i = 1; $i <= $data['count']['PCount']; $i++) {

				if ($this->input->post('idTab_Produto' . $i)) {
					$data['produto'][$j]['idApp_Produto'] = $this->input->post('idApp_Produto' . $i);
					$data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
					$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
					$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
					$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
					$data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
					$data['produto'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoProduto' . $i);
					$data['produto'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackProduto' . $i);
					$data['produto'][$j]['PrazoProduto'] = $this->input->post('PrazoProduto' . $i);                
					$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
					$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
					$data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
					$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
					$data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackProduto' . $i);
					$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
					$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
					$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
					$data['produto'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoProduto' . $i);
					$data['produto'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoProduto' . $i);
					$data['produto'][$j]['Aux_App_Produto_1'] = $this->input->post('Aux_App_Produto_1' . $i);
					$data['produto'][$j]['Aux_App_Produto_2'] = $this->input->post('Aux_App_Produto_2' . $i);
					$data['produto'][$j]['Aux_App_Produto_3'] = $this->input->post('Aux_App_Produto_3' . $i);
					$data['produto'][$j]['Aux_App_Produto_4'] = $this->input->post('Aux_App_Produto_4' . $i);
					$data['produto'][$j]['Aux_App_Produto_5'] = $this->input->post('Aux_App_Produto_5' . $i);
					$data['produto'][$j]['HoraValidadeProduto'] = $this->input->post('HoraValidadeProduto' . $i);
					$data['produto'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoProduto' . $i);
					$data['produto'][$j]['DevolvidoProduto'] = $this->input->post('DevolvidoProduto' . $i);
					//$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					//$data['produto'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalProduto_1' . $i);
					
					(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
					);
					($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';
					
					$j++;
				}
			}
			$data['count']['PCount'] = $j - 1;

			$j = 1;
			for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

				if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataConcluidoProcedimento' . $i) ||
					$this->input->post('Profissional' . $i) || $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
					$data['procedimento'][$j]['idApp_Procedimento'] = $this->input->post('idApp_Procedimento' . $i);
					$data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
					$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->input->post('DataConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['HoraProcedimento'] = $this->input->post('HoraProcedimento' . $i);
					$data['procedimento'][$j]['HoraConcluidoProcedimento'] = $this->input->post('HoraConcluidoProcedimento' . $i);				
					#$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
					//$data['procedimento'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
					$data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
					$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					$data['procedimento'][$j]['Compartilhar'] = $this->input->post('Compartilhar' . $i);
					
					(!$data['procedimento'][$j]['ConcluidoProcedimento']) ? $data['procedimento'][$j]['ConcluidoProcedimento'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
					);
					($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';	

					$data['select'][$j]['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos($data['procedimento'][$j]['Compartilhar']);
					
					$j++;
				}

			}
			$data['count']['PMCount'] = $j - 1;

			$data['somatotal'] = 0;	

			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

					$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
					$data['somatotal'] += $data['valoredit'][$i];            
				
				if ($data['valoredit'][$i] > 0.00){
					$data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
					$data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					//$data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$j]['DataLanc'] = $this->input->post('DataLanc' . $i);
					$data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
					$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
					//$data['parcelasrec'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					
					(!$data['parcelasrec'][$j]['Quitado']) ? $data['parcelasrec'][$j]['Quitado'] = 'N' : FALSE;
					$data['radio'] = array(
						'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
					);
					($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';				

					$j++;
				}
			}
			$data['count']['PRCount'] = $j - 1;

			/*
			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				if ($this->input->post('ValorParcela' . $i) > 0 && $this->input->post('ValorParcela' . $i) != ''){
					$data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
					$data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					$data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
					$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
					
					(!$data['parcelasrec'][$j]['Quitado']) ? $data['parcelasrec'][$j]['Quitado'] = 'N' : FALSE;
					$data['radio'] = array(
						'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
					);
					($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';				

					$j++;
				}
			}
			$data['count']['PRCount'] = $j - 1;
			*/
			
			//Fim do trecho de c�digo que d� pra melhorar

			if ($id) {
				#### App_OrcaTrata ####
				$_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
			
				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 2  || $data['orcatrata']['idApp_Cliente'] == 0){
					
					unset($_SESSION['Orcatrata']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {

					$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
					$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'barras');
					$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'barras');

					if(!empty($data['orcatrata']['idApp_ClientePet']) && $data['orcatrata']['idApp_ClientePet'] != 0){
						//$this->load->model('Clientepet_model');
						$_SESSION['ClientePet'] = $data['clientepet'] = $this->Clientepet_model->get_clientepet($data['orcatrata']['idApp_ClientePet'], TRUE);
						$_SESSION['ClientePet']['NomeClientePet'] = (strlen($data['clientepet']['NomeClientePet']) > 20) ? substr($data['clientepet']['NomeClientePet'], 0, 20) : $data['clientepet']['NomeClientePet'];
					}

					if(!empty($data['orcatrata']['idApp_ClienteDep']) && $data['orcatrata']['idApp_ClienteDep'] != 0){
						//$this->load->model('Clientedep_model');
						$_SESSION['ClienteDep'] = $data['clientedep'] = $this->Clientedep_model->get_clientedep($data['orcatrata']['idApp_ClienteDep'], TRUE);
						$_SESSION['ClienteDep']['NomeClienteDep'] = (strlen($data['clientedep']['NomeClienteDep']) > 20) ? substr($data['clientedep']['NomeClienteDep'], 0, 20) : $data['clientedep']['NomeClienteDep'];
					}

					#### App_Servico ####
					$data['servico'] = $this->Orcatrata_model->get_servico($id);
					if (count($data['servico']) > 0) {
						$data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
						$data['count']['SCount'] = count($data['servico']);

						if (isset($data['servico'])) {

							for($j=1;$j<=$data['count']['SCount'];$j++) {
								$data['servico'][$j]['SubtotalProduto'] = number_format(($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto']), 2, ',', '.');
								$data['servico'][$j]['SubtotalComissaoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoProduto'] /100);
								$data['servico'][$j]['SubtotalComissaoServicoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoServicoProduto'] /100);
								$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoCashBackProduto'] /100);
								$data['servico'][$j]['SubtotalQtdProduto'] = ($data['servico'][$j]['QtdIncrementoProduto'] * $data['servico'][$j]['QtdProduto']);
								$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'barras');
								$data['servico'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataConcluidoProduto'], 'barras');

								$data['servico'][$j]['ValorComissaoServico'] = number_format(($data['servico'][$j]['ValorComissaoServico']), 2, ',', '.');
								
								$data['servico'][$j]['ValorComProf_1'] = number_format(($data['servico'][$j]['ValorComProf_1']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_2'] = number_format(($data['servico'][$j]['ValorComProf_2']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_3'] = number_format(($data['servico'][$j]['ValorComProf_3']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_4'] = number_format(($data['servico'][$j]['ValorComProf_4']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_5'] = number_format(($data['servico'][$j]['ValorComProf_5']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_6'] = number_format(($data['servico'][$j]['ValorComProf_6']), 2, ',', '.');
								
								(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
								$data['radio'] = array(
									'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
								);
								($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';
								
								$_SESSION['Servico'][$j]['ProfissionalServico_1'] = $data['servico'][$j]['ProfissionalProduto_1'];
								$_SESSION['Servico'][$j]['ProfissionalServico_2'] = $data['servico'][$j]['ProfissionalProduto_2'];
								$_SESSION['Servico'][$j]['ProfissionalServico_3'] = $data['servico'][$j]['ProfissionalProduto_3'];
								$_SESSION['Servico'][$j]['ProfissionalServico_4'] = $data['servico'][$j]['ProfissionalProduto_4'];
								$_SESSION['Servico'][$j]['ProfissionalServico_5'] = $data['servico'][$j]['ProfissionalProduto_5'];
								$_SESSION['Servico'][$j]['ProfissionalServico_6'] = $data['servico'][$j]['ProfissionalProduto_6'];
								
								$data['select'][$j]['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
								
								if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
								}						
							}
						}
					}

					#### App_Produto ####
					$data['produto'] = $this->Orcatrata_model->get_produto($id);
					if (count($data['produto']) > 0) {
						$data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
						$data['count']['PCount'] = count($data['produto']);

						if (isset($data['produto'])) {

							for($j=1;$j<=$data['count']['PCount'];$j++) {
								$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
								$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
								$data['produto'][$j]['SubtotalComissaoServicoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoServicoProduto'] /100);
								$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoCashBackProduto'] /100);
								$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
								$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
								$data['produto'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataConcluidoProduto'], 'barras');

								(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
								$data['radio'] = array(
									'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
								);
								($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';

								///talvez tenha que retirar esta linha///
								//$data['produto'][$j]['NomeProduto'] = $data['produto'][$j]['Produto'];
							}

						}
					}

					#### App_Parcelas ####
					$data['parcelasrec'] = $this->Orcatrata_model->get_parcelas($id);
					if (count($data['parcelasrec']) > 0) {
						$data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
						$data['count']['PRCount'] = count($data['parcelasrec']);
						
						if (isset($data['parcelasrec'])) {

							for($j=1; $j <= $data['count']['PRCount']; $j++) {
								$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
								$data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
								$data['parcelasrec'][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataLanc'], 'barras');
							
								$data['radio'] = array(
									'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
								);
								($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';
							}

						}
					}

					#### App_Procedimento ####
					$_SESSION['Procedimento'] = $data['procedimento'] = $this->Orcatrata_model->get_procedimento($id);
					if (count($data['procedimento']) > 0) {
						$data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
						$data['count']['PMCount'] = count($data['procedimento']);

						if (isset($data['procedimento'])) {

							for($j=1; $j <= $data['count']['PMCount']; $j++) {
								$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');
								$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataConcluidoProcedimento'], 'barras');
								$_SESSION['Procedimento'][$j]['Nome'] = $data['procedimento'][$j]['Nome'];
							
								$data['radio'] = array(
									'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
								);
								($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';
								
								$_SESSION['Procedimento'][$j]['Compartilhar'] = $data['procedimento'][$j]['Compartilhar'];
								$data['select'][$j]['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos($_SESSION['Procedimento'][$j]['Compartilhar']);
							}
						}
					}
				}
			}
			
			if(!$data['orcatrata']['idApp_OrcaTrata'] || !$_SESSION['Orcatrata'] || $_SESSION['Orcatrata']['idTab_TipoRD'] != 2  || $_SESSION['Orcatrata']['idApp_Cliente'] == 0){
				
				unset($_SESSION['Orcatrata']);
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {		
				
				#### Carrega os dados do cliente nas vari�ves de sess�o ####
				$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($_SESSION['Orcatrata']['idApp_Cliente'], TRUE);
			
				if($data['query'] === FALSE){
					
					unset($_SESSION['Orcatrata']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {
					
					#### Carrega os dados do Vendedor nas vari�ves de sess�o ####
					if($_SESSION['log']['idSis_Empresa'] != 5){
						if(isset($_SESSION['Orcatrata']['id_Funcionario']) && $_SESSION['Orcatrata']['id_Funcionario'] != 0){
							$data['funcionario']['Nome'] = $this->Usuario_model->get_usuario($_SESSION['Orcatrata']['id_Funcionario'], TRUE)['Nome'];
						}
						if(isset($_SESSION['Orcatrata']['id_Associado']) && $_SESSION['Orcatrata']['id_Associado'] != 0){
							$data['associado']['Nome'] = $this->Associado_model->get_associado($_SESSION['Orcatrata']['id_Associado'], TRUE)['Nome'];
						}
					}
					
					$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];

					#### Carrega os dados da Campanha nas vari�ves de sess�o ####
					$_SESSION['Campanha'] = $this->Campanha_model->get_campanha_cupom($_SESSION['Orcatrata']['Cupom']);

					#### Carrega os dados das consultas nas vari�ves de sess�o ####
					$_SESSION['Consultas_orca'] = $data['consultas_orca'] = $this->Consulta_model->get_consultas_orca($_SESSION['Orcatrata']['idApp_OrcaTrata'], TRUE);
					$_SESSION['Orcatratas'] = $data['orcatratas'] = $this->Orcatrata_model->get_orcatratas_repet($_SESSION['Orcatrata']['RepeticaoOrca']);
					$_SESSION['RepeticaoOrca'] = $this->Orcatrata_model->get_repeticaoorca($_SESSION['Orcatrata']['RepeticaoCons']);
					$_SESSION['RepeticaoCons'] = $this->Orcatrata_model->get_repeticaocons($_SESSION['Orcatrata']['RepeticaoCons']);

					$data['count_orca'] = count($_SESSION['Consultas_orca']);// conta quantos idApp_OrcaTrata existem na tabela de APP_Consultas,  na posicao idApp_OrcaTrata
					$data['count_orcatratas'] = count($_SESSION['Orcatratas']);// conta quantos RepeticaoOrca, que est� anotado nesta O.S., existem na tabela App_OrcaTrata, na posi��o RepeticaoOrca
					
					$data['repeticaocons'] = count($_SESSION['RepeticaoCons']);// conto quantas Consultas tem essa repeti��o
					$data['repeticaoorca'] = count($_SESSION['RepeticaoOrca']);// conto quantas OS tem essa repeti��o	
					/*
					echo '<br>';
					echo "<pre>";
					echo '<br>';
					print_r($data['orcatrata']);
					echo '<br>';
					print_r($_SESSION['Orcatrata']);
					echo "</pre>"; 
					*/
					if(isset($_SESSION['Orcatrata']) && $_SESSION['Orcatrata']['RepeticaoCons'] != 0){
						
						$data['orcatrata']['idApp_ClientePet'] = $_SESSION['Orcatrata']['idApp_ClientePet'];
						$data['orcatrata']['idApp_ClienteDep'] = $_SESSION['Orcatrata']['idApp_ClienteDep'];
						
						if( $data['repeticaocons'] > $data['repeticaoorca']){
							$data['readonly_cons'] = '';
							$data['alterar_campos'] = 1;
						}else{
							$data['alterar_campos'] = 0;
							$data['readonly_cons'] = 'readonly=""';
						}
						
					}else{
						$data['readonly_cons'] = '';
						$data['alterar_campos'] = 1;
					}

					$data['select']['EspeciePet'] = array (
						'0' => '',
						'1' => 'C�O',
						'2' => 'GATO',
						'3' => 'AVE',
					);	
					$data['select']['PeloPet'] = array (
						'0' => '',
						'1' => 'CURTO',
						'2' => 'M�DIO',
						'3' => 'LONGO',
						'4' => 'CACHEADO',
					);		
					$data['select']['PortePet'] = array (
						'0' => '',
						'1' => 'MINI',
						'2' => 'PEQUENO',
						'3' => 'M�DIO',
						'4' => 'GRANDE',
						'5' => 'GIGANTE',
					);		
					$data['select']['TipoDescOrca'] = array (
						'P' => '.%',
						'V' => 'R$',
					);		
					$data['select']['TipoExtraOrca'] = array (
						'P' => '.%',
						'V' => 'R$',
					);
					$data['select']['RacaPet'] = $this->Cliente_model->select_racapet();
					$data['select']['RelacaoDep'] = $this->Cliente_model->select_relacao();			
					$data['select']['UsarCashBack'] = $this->Basico_model->select_status_sn();
					$data['select']['UsarCupom'] = $this->Basico_model->select_status_sn();
					$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
					$data['select']['Whatsapp'] = $this->Basico_model->select_status_sn();
					$data['select']['Whatsapp_Site'] = $this->Basico_model->select_status_sn();
					$data['select']['StatusProdutos'] = $this->Basico_model->select_status_sn();
					$data['select']['StatusParcelas'] = $this->Basico_model->select_status_sn();
					$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
					$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
					$data['select']['Entrega_Orca'] = $this->Basico_model->select_status_sn();
					$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
					$data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
					$data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
					$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
					$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
					$data['select']['FormaPagamentoParcela'] = $this->Formapag_model->select_formapag();
					$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['ProntoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['TipoFrete'] = $this->Basico_model->select_tipofrete();
					$data['select']['DevolvidoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
					$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
					$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
					$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
					$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
					$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['Quitado'] = $this->Basico_model->select_status_sn();
					$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
					$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
					//$data['select']['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
					//$data['select']['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
					//$data['select']['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
					//$data['select']['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
					//$data['select']['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
					//$data['select']['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
					//$data['select']['ProfissionalProduto_1'] = $this->Usuario_model->select_usuario();
					$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
					//$data['select']['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos();
					$data['select']['Entregador'] = $this->Usuario_model->select_usuario_entregador($_SESSION['Orcatrata']['Entregador']);
					$data['select']['Produto'] = $this->Basico_model->select_produtos3($data['orcatrata']['Tipo_Orca']);
					$data['select']['Servico'] = $this->Basico_model->select_servicos3($data['orcatrata']['Tipo_Orca']);
					#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
					$data['select']['AVAP'] = $this->Basico_model->select_avap();
					$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
					$data['select']['Prioridade'] = array (
						'1' => 'Alta',
						'2' => 'M�dia',
						'3' => 'Baixa',
					);
					
					//$data['select']['idApp_ClienteDep'] = $this->Cliente_model->select_clientedep($_SESSION['Cliente']['idApp_Cliente']);
					//$data['select']['idApp_ClientePet'] = $this->Cliente_model->select_clientepet($_SESSION['Cliente']['idApp_Cliente']);
					
					$data['titulo'] = 'Pedido';
					$data['form_open_path'] = 'orcatrata/alterar';
					$data['readonly'] = '';
					$data['disabled'] = '';
					$data['panel'] = 'primary';
					$data['metodo'] = 2;
					$data['caminho'] = '../../';
					$data['caminho2'] = '';
					$data['Recorrencias'] = $_SESSION['Orcatrata']['RecorrenciasOrca'];
					$data['Recorrencias_outras'] = $data['Recorrencias'] - 1;
					
					$data['exibir_id'] = 0;
					
					$data['exibirExtraOrca'] = 1;
					$data['exibirDescOrca'] = 1;
					
					$data['AtivoCashBack'] = $_SESSION['Orcatrata']['AtivoCashBack'];

					$data['orcatratas_total'] = $this->Orcatrata_model->get_orcatratas_repet_total($_SESSION['Orcatrata']['RepeticaoOrca'], $_SESSION['Orcatrata']['idApp_OrcaTrata']);	
					$data['count_orcatratas_total'] = count($data['orcatratas_total']);
					
					$data['soma_cashback_repet_total_outras'] = 0;
					if ($data['count_orcatratas_total'] > 0) {
						$data['orcatratas_total'] = array_combine(range(1, count($data['orcatratas_total'])), array_values($data['orcatratas_total']));

						if (isset($data['orcatratas_total'])) {

							for($j=1; $j <= $data['count_orcatratas_total']; $j++) {
								$data['soma_cashback_repet_total_outras'] += $data['orcatratas_total'][$j]['ValorComissaoCashBack'];
								
							}
						}
					}				
					
					$data['orcatratas_s_pago'] = $this->Orcatrata_model->get_orcatratas_repet_s_pago($_SESSION['Orcatrata']['RepeticaoOrca'], $_SESSION['Orcatrata']['idApp_OrcaTrata']);	
					$data['count_orcatratas_s_pago'] = count($data['orcatratas_s_pago']);
					
					$data['soma_cashback_repet_s_pago_outras'] = 0;
					if ($data['count_orcatratas_s_pago'] > 0) {
						$data['orcatratas_s_pago'] = array_combine(range(1, count($data['orcatratas_s_pago'])), array_values($data['orcatratas_s_pago']));

						if (isset($data['orcatratas_s_pago'])) {

							for($j=1; $j <= $data['count_orcatratas_s_pago']; $j++) {
								$data['soma_cashback_repet_s_pago_outras'] += $data['orcatratas_s_pago'][$j]['ValorComissaoCashBack'];
								
							}
						}
					}		
				
					$data['orcatratas_n_pago'] = $this->Orcatrata_model->get_orcatratas_repet_n_pago($_SESSION['Orcatrata']['RepeticaoOrca'], $_SESSION['Orcatrata']['idApp_OrcaTrata']);	
					$data['count_orcatratas_n_pago'] = count($data['orcatratas_n_pago']);

					$data['soma_repet_n_pago'] = 0;
					if ($data['count_orcatratas_n_pago'] > 0) {
						$data['orcatratas_n_pago'] = array_combine(range(1, count($data['orcatratas_n_pago'])), array_values($data['orcatratas_n_pago']));

						if (isset($data['orcatratas_n_pago'])) {

							for($j=1; $j <= $data['count_orcatratas_n_pago']; $j++) {
								$data['soma_repet_n_pago'] += $data['orcatratas_n_pago'][$j]['ValorParcela'];
								
							}
						}
					}
					
					/*		
					echo '<br>';
					echo "<pre>";
					echo '<br>';
					print_r($data['Recorrencias']);
					echo '<br>';
					print_r($data['count_orcatratas_n_pago']);
					echo '<br>';
					print_r($data['soma_repet_n_pago']);
					echo '<br>';
					print_r($data['orcatratas_n_pago']);
					echo "</pre>";
					//exit();		
					*/
					
					$data['valorfinal_os'] = $_SESSION['Orcatrata']['ValorFinalOrca'];
					
					$data['valorfinal_soma_os'] = $data['valorfinal_os'] + $data['soma_repet_n_pago']; 
					
					$data['soma_repet_n_pago'] = number_format($data['soma_repet_n_pago'],2,",",".");
					$data['valorfinal_soma_os'] = number_format($data['valorfinal_soma_os'],2,",",".");
					
					(!$data['cadastrar']['Valor_S_Desc']) ? $data['cadastrar']['Valor_S_Desc'] = $data['valorfinal_soma_os'] : FALSE;
					
						
					if($data['count_orcatratas'] <= 0){
						$data['vinculadas'] = 0;
					}else{
						$data['vinculadas'] = $data['count_orcatratas'] - 1;
					}

					if ($data['vinculadas'] > 0){
						$data['textoEntregues'] = '';
						$data['textoPagas'] = '';
					}else{
						$data['textoEntregues'] = 'style="display: none;"';
						$data['textoPagas'] = 'style="display: none;"';
					}
					
					$data['collapse'] = '';	
					$data['collapse1'] = 'class="collapse"';		
					
					//if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
					if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
						$data['orcamentoin'] = 'in';
					else
						$data['orcamentoin'] = '';

					if ($data['orcatrata']['FormaPagamento'])
						$data['parcelasin'] = 'in';
					else
						$data['parcelasin'] = '';

					//if (isset($data['procedimento']) && ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional']))
					if ($data['count']['PMCount'] > 0)
						$data['tratamentosin'] = 'in';
					else
						$data['tratamentosin'] = '';

					if ($_SESSION['log']['NivelEmpresa'] >= '4' )
						$data['visivel'] = '';
					else
						$data['visivel'] = 'style="display: none;"';		

					#Ver uma solu��o melhor para este campo
					//(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
					($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
					/*
					$data['radio'] = array(
						'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
					);
					($data['orcatrata']['AVAP'] == 'P') ?
						$data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
					*/

					($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
					
					$data['radio'] = array(
						'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
					);
					($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
					);
					($data['cadastrar']['Cadastrar'] == 'N') ?
						$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
					
					$data['radio'] = array(
						'Whatsapp' => $this->basico->radio_checked($data['cadastrar']['Whatsapp'], 'Whatsapp', 'NS'),
					);
					($data['cadastrar']['Whatsapp'] == 'S') ?
						$data['div']['Whatsapp'] = '' : $data['div']['Whatsapp'] = 'style="display: none;"';		
								
					$data['radio'] = array(
						'Whatsapp_Site' => $this->basico->radio_checked($data['cadastrar']['Whatsapp_Site'], 'Whatsapp_Site', 'NS'),
					);
					($data['cadastrar']['Whatsapp_Site'] == 'S') ?
						$data['div']['Whatsapp_Site'] = '' : $data['div']['Whatsapp_Site'] = 'style="display: none;"';
								
					$data['radio'] = array(
						'StatusProdutos' => $this->basico->radio_checked($data['cadastrar']['StatusProdutos'], 'StatusProdutos', 'NS'),
					);
					($data['cadastrar']['StatusProdutos'] == 'S') ?
						$data['div']['StatusProdutos'] = '' : $data['div']['StatusProdutos'] = 'style="display: none;"';		
					
					$data['radio'] = array(
						'StatusParcelas' => $this->basico->radio_checked($data['cadastrar']['StatusParcelas'], 'StatusParcelas', 'NS'),
					);
					($data['cadastrar']['StatusParcelas'] == 'S') ?
						$data['div']['StatusParcelas'] = '' : $data['div']['StatusParcelas'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
					);
					($data['cadastrar']['AtualizaEndereco'] == 'N') ?
						$data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';
						
					$data['radio'] = array(
						'Modalidade' => $this->basico->radio_checked($data['orcatrata']['Modalidade'], 'Modalidade', 'PM'),
					);
					($data['orcatrata']['Modalidade'] == 'P') ?
						$data['div']['Modalidade'] = '' : $data['div']['Modalidade'] = 'style="display: none;"';
					
					
					$data['radio'] = array(
						'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
					);
					($data['orcatrata']['CombinadoFrete'] == 'S') ?
						$data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
					);
					($data['orcatrata']['EnviadoOrca'] == 'S') ?
						$data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';		
					
					
					$data['radio'] = array(
						'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
					);

					($data['orcatrata']['AprovadoOrca'] == 'S') ?
						$data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';

					$data['radio'] = array(
						'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
					);
					($data['orcatrata']['ConcluidoOrca'] == 'S') ?
						$data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

						
					$data['radio'] = array(
						'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
					);
					($data['orcatrata']['BrindeOrca'] == 'N') ?
						$data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';
						
					$data['radio'] = array(
						'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Pronto p/Entrega', 'NS'),
					);
					($data['orcatrata']['ProntoOrca'] == 'S') ?
						$data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Finalizado', 'NS'),
					);
					($data['orcatrata']['FinalizadoOrca'] == 'N') ?
						$data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Or�amento Cancelado', 'NS'),
					);
					($data['orcatrata']['CanceladoOrca'] == 'N') ?
						$data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"'; 		
					
					$data['radio'] = array(
						'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
					);
					($data['orcatrata']['DevolvidoOrca'] == 'S') ?
						$data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';				

					$data['radio'] = array(
						'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
					);
					($data['orcatrata']['QuitadoOrca'] == 'S') ?
						$data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
						/*
					$data['radio'] = array(
						'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
					);
					($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
						$data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
					*/
					$data['radio'] = array(
						'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
					);
					($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
						$data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'Entrega_Orca' => $this->basico->radio_checked($data['orcatrata']['Entrega_Orca'], 'Entrega', 'NS'),
					);
					($data['orcatrata']['Entrega_Orca'] == 'S') ?
						$data['div']['Entrega_Orca'] = '' : $data['div']['Entrega_Orca'] = 'style="display: none;"';
					
					$data['radio'] = array(
						'UsarCashBack' => $this->basico->radio_checked($data['orcatrata']['UsarCashBack'], 'UsarCashBack', 'NS'),
					);
					($data['orcatrata']['UsarCashBack'] == 'S') ?
						$data['div']['UsarCashBack'] = '' : $data['div']['UsarCashBack'] = 'style="display: none;"';		
					
					$data['radio'] = array(
						'UsarCupom' => $this->basico->radio_checked($data['orcatrata']['UsarCupom'], 'UsarCupom', 'NS'),
					);
					($data['orcatrata']['UsarCupom'] == 'S') ?
						$data['div']['UsarCupom'] = '' : $data['div']['UsarCupom'] = 'style="display: none;"';		
							
					$data['sidebar'] = 'col-sm-3 col-md-2';
					$data['main'] = 'col-sm-7 col-md-8';

					$data['datepicker'] = 'DatePicker';
					$data['timepicker'] = 'TimePicker';
					
					$data['cor_cli'] 	= 'default';
					$data['cor_cons'] 	= 'default';
					$data['cor_orca'] 	= 'warning';
					$data['cor_sac'] 	= 'default';
					$data['cor_mark'] 	= 'default';
					
					$data['nav_orca'] 		= 'S';
					$data['nav_status'] 	= 'S';
					$data['nav_alterar'] 	= 'N';
					
					$data['nav_imprimir'] 	= 'N';
					$data['nav_entrega'] 	= 'S';
					$data['nav_cobranca'] 	= 'S';

					$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

					$data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);

					$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
					$data['valortotalorca'] = floatval ($data['valortotalorca']);

					$data['somatotal'] = floatval ($data['somatotal']);

					$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];

					$epsilon = 0.001;

					if(abs($data['diferenca']) < $epsilon){
						$data['diferenca'] = 0.00;
					}else{
						$data['diferenca'] = $data['diferenca'];
					}

					$data['diferenca'] = floatval ($data['diferenca']);	

					$data['q3'] = $this->Clientepet_model->list_racapet(TRUE);
					$data['list3'] = $this->load->view('clientepet/list_racapet', $data, TRUE);
					
					$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

					#### App_OrcaTrata ####
					
					if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
						if($data['diferenca'] < 0.00){

							$data['diferenca'] = number_format($data['diferenca'],2,",",".");
							//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
							$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
						}elseif($data['diferenca'] > 0.00){

							$data['diferenca'] = number_format($data['diferenca'],2,",",".");
							//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
							$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
						}
					}

					if ($data['valortotalorca'] <= 0.00 ) {
						$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
					}
					
					$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
					$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
					$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
					$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
					//$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
					//$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');
					$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');	
					
					if($data['orcatrata']['TipoFrete'] !=1){
						if($data['orcatrata']['AVAP'] == 'O'){
							if($data['orcatrata']['FormaPagamento'] == '1' || $data['orcatrata']['FormaPagamento'] == '2' || $data['orcatrata']['FormaPagamento'] == '3'){
								$this->form_validation->set_rules('Cep', 'Cep', 'required|trim');
								$this->form_validation->set_rules('Logradouro', 'Endere�o', 'required|trim');
								$this->form_validation->set_rules('Numero', 'Numero', 'required|trim');
								$this->form_validation->set_rules('Bairro', 'Bairro', 'required|trim');
								$this->form_validation->set_rules('Cidade', 'Cidade', 'required|trim');
								$this->form_validation->set_rules('Estado', 'Estado', 'required|trim');
							}
						}
					}
							
					#run form validation
					if ($this->form_validation->run() === FALSE) {
						$this->load->view('orcatrata/form_orcatrataalterar', $data);
					
					} else {

						if($this->Basico_model->get_dt_validade() === FALSE){
							$data['msg'] = '?m=3';
							redirect(base_url() . 'orcatrata/alterar/' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . $data['msg']);
							
						} else {
							
							#### Estoque_Produto_anterior e CashBack_anterior####
							
								
								#### Estoque_Produto_anterior ####
								if ($_SESSION['Orcatrata']['CombinadoFrete'] == 'S') {
									
									$data['busca']['estoque']['anterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
									
									if (count($data['busca']['estoque']['anterior']) > 0) {
										
										$data['busca']['estoque']['anterior'] = array_combine(range(1, count($data['busca']['estoque']['anterior'])), array_values($data['busca']['estoque']['anterior']));
										$max_estoque = count($data['busca']['estoque']['anterior']);
										
										if (isset($data['busca']['estoque']['anterior'])){
											
											for($j=1;$j<=$max_estoque;$j++) {
												
												$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['anterior'][$j]['idTab_Produtos_Produto']);
												
												if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
													
													$qtd_produto[$j]	= ($data['busca']['estoque']['anterior'][$j]['QtdProduto'] * $data['busca']['estoque']['anterior'][$j]['QtdIncrementoProduto']);
													
													$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] + $qtd_produto[$j]);
													
													if($diff_estoque[$j] <= 0){
														$estoque[$j] = 0; 
													}else{
														$estoque[$j] = $diff_estoque[$j]; 
													}
													
													$data['alterar']['produto']['anterior'][$j]['Estoque'] = $estoque[$j];
													$data['alterar']['produto']['anterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['anterior'][$j], $data['get']['produto'][$j]['idTab_Produtos']);
													
													unset($qtd_produto[$j]);
													unset($diff_estoque[$j]);
													unset($estoque[$j]);
												}
												
											}
											
										}
										
									}
									
								}
								
								#### CashBack_anterior####
								$data['busca']['cashback']['anterior'] = $this->Orcatrata_model->get_produto_cashback_pedido($data['orcatrata']['idApp_OrcaTrata']);
								$max_cashback = count($data['busca']['cashback']['anterior']);				

								if ($max_cashback > 0) {
									
									$data['busca']['cashback']['anterior'] = array_combine(range(1, count($data['busca']['cashback']['anterior'])), array_values($data['busca']['cashback']['anterior']));
									
									if (isset($data['busca']['cashback']['anterior'])){
										
										$data['valorcashbackpedido']=0;
										
										for($j=1;$j<=$max_cashback;$j++) {
											$data['get']['valorcashback'][$j] = $data['busca']['cashback']['anterior'][$j]['ValorComissaoCashBack'];
											$data['valorcashbackpedido'] += $data['get']['valorcashback'][$j];
										}
										
										$data['update']['cliente_cashback']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
										$data['valorcashbackcliente'] = $data['update']['cliente_cashback']['anterior']['CashBackCliente'];
											
										if ($_SESSION['Orcatrata']['CanceladoOrca'] == 'N') {	
											
											if($_SESSION['Orcatrata']['QuitadoOrca'] == 'S'){
											
												//subtraio o valorcashbackpedido e o valordocashbackoutrasos do valor atual do cashbackcliente
												
												$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] - ($data['valorcashbackpedido'] + $data['soma_cashback_repet_s_pago_outras']);
							
												if($data['cliente_cashback']['CashBackCliente'] >= 0){
													$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
												}else{
													$data['cliente_cashback']['CashBackCliente'] = 0.00;
												}

												$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);
						
											}else{
												
												//subtraio o valordocashbackoutrasos do valor atual do cashbackcliente
												
												$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] - $data['soma_cashback_repet_s_pago_outras'];
							
												if($data['cliente_cashback']['CashBackCliente'] >= 0){
													$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
												}else{
													$data['cliente_cashback']['CashBackCliente'] = 0.00;
												}

												$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);						
											}
											
										}else{
										
											//subtraio o valordocashbackoutrasos do valor atual do cashbackcliente
											
											$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] - $data['soma_cashback_repet_s_pago_outras'];
						
											if($data['cliente_cashback']['CashBackCliente'] >= 0){
												$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
											}else{
												$data['cliente_cashback']['CashBackCliente'] = 0.00;
											}

											$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);					
										
										}
										
									}
									
								}			
							
							
							$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
							$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
							$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
							$data['cadastrar']['AtualizaEndereco'] = $data['cadastrar']['AtualizaEndereco'];

							////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
							#### App_OrcaTrata ####
							if ($data['orcatrata']['Entrega_Orca'] == "S") {	
								if ($data['orcatrata']['TipoFrete'] == '1') {
									$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
									$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
									$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
									$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
									$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
									$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
									$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
									$data['orcatrata']['Referencia'] = '';
								} else {	
									$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
									$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
									$data['orcatrata']['Numero'] = trim(mb_strtoupper($numero1, 'ISO-8859-1'));
									$data['orcatrata']['Complemento'] = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));
									$data['orcatrata']['Bairro'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
									$data['orcatrata']['Cidade'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
									$data['orcatrata']['Estado'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));
									$data['orcatrata']['Referencia'] = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));
								}
							} else {
								$data['orcatrata']['Cep'] = '';
								$data['orcatrata']['Logradouro'] = '';
								$data['orcatrata']['Numero'] = '';
								$data['orcatrata']['Complemento'] = '';
								$data['orcatrata']['Bairro'] = '';
								$data['orcatrata']['Cidade'] = '';
								$data['orcatrata']['Estado'] = '';
								$data['orcatrata']['Referencia'] = '';
							}
							$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
							$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
							$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
							$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
							$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));
							$data['orcatrata']['TipoFinanceiro'] = $data['orcatrata']['TipoFinanceiro'];
							$data['orcatrata']['Entregador'] = $data['orcatrata']['Entregador'];
							$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
							$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
							$data['orcatrata']['Descricao'] = $data['orcatrata']['Descricao'];
							//$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
							//$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
							//$data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
							//$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
							//$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');

							if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
								$data['orcatrata']['ConcluidoOrca'] = "S";
								$data['orcatrata']['QuitadoOrca'] = "S";
							} 
							if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['FinalizadoOrca'] = "S";
								$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
							} 
							if($data['orcatrata']['ConcluidoOrca'] == 'S'){
								$data['orcatrata']['CombinadoFrete'] = "S";
							} 
							if($data['orcatrata']['QuitadoOrca'] == 'S'){
								$data['orcatrata']['AprovadoOrca'] = "S";
							} 
							if ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
								$data['orcatrata']['EnviadoOrca'] = "S";
							}

							$data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
							$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
							$data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
							//$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
							if($data['orcatrata']['FormaPagamento'] == "7"){
								$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
								$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
							}else{
								$data['orcatrata']['ValorDinheiro'] = 0.00;
								$data['orcatrata']['ValorTroco'] = 0.00;
							}
							//$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');		
							
							/*
							$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
							$data['orcatrata']['PercExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['PercExtraOrca']));
							$data['orcatrata']['DescPercOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescPercOrca']));
							$data['orcatrata']['DescValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescValorOrca']));
							*/
							
							if(!$data['orcatrata']['ValorFrete']){
								$data['orcatrata']['ValorFrete'] = 0;
							}else{
								$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
							}
							
							if(!$data['orcatrata']['ValorExtraOrca']){
								$data['orcatrata']['ValorExtraOrca'] = 0;
							}else{
								$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
							}			
										
							if(!$data['orcatrata']['PercExtraOrca']){
								$data['orcatrata']['PercExtraOrca'] = 0;
							}else{
								$data['orcatrata']['PercExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['PercExtraOrca']));
							}			

							if(!$data['orcatrata']['DescPercOrca']){
								$data['orcatrata']['DescPercOrca'] = 0;
							}else{
								$data['orcatrata']['DescPercOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescPercOrca']));
							}			
							
							if(!$data['orcatrata']['DescValorOrca']){
								$data['orcatrata']['DescValorOrca'] = 0;
							}else{
								$data['orcatrata']['DescValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescValorOrca']));
							}

							$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
							$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'mysql');
							if(isset($data['orcatrata']['ValidadeCashBackOrca']) && $data['orcatrata']['ValidadeCashBackOrca'] != "0000-00-00" && $data['orcatrata']['ValidadeCashBackOrca'] != ""){
								$data['orcatrata']['ValidadeCashBackOrca'] = $data['orcatrata']['ValidadeCashBackOrca'];
							}else{
								$data['orcatrata']['ValidadeCashBackOrca'] = "0000-00-00";
							}
							
							$data['orcatrata']['ValorFinalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
							
							$data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
							$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
							$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
							$data['orcatrata']['SubValorFinal'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['SubValorFinal']));
							
							#$data['orcatrata']['idTab_TipoRD'] = $data['orcatrata']['idTab_TipoRD'];
							#$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
							#$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
							#$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

							if($data['orcatrata']['Entrega_Orca'] == "N"){
								$data['orcatrata']['DataEntregaOrca'] = $data['orcatrata']['DataOrca'];
								$data['orcatrata']['HoraEntregaOrca'] = "00:00:00";
								$data['orcatrata']['PrazoProdServ'] = 0;
								$data['orcatrata']['PrazoCorreios'] = 0;
								$data['orcatrata']['PrazoEntrega'] = 0;
							}
							
							if (!$data['orcatrata']['PrazoEntrega']){
								//$data1 = date('Y-m-d', time());
								$data1 = $data['orcatrata']['DataOrca'];
								$data2 = $data['orcatrata']['DataEntregaOrca'];
								$intervalo = strtotime($data2)-strtotime($data1); 
								$dias = floor($intervalo / (60 * 60 * 24));
								$data['orcatrata']['PrazoEntrega'] = $dias;
							}
			
							$data['orcatrata']['ValorFatura'] = $data['orcatrata']['ValorFinalOrca'];
							
							if($data['orcatrata']['AVAP'] == "O" && ($data['orcatrata']['FormaPagamento'] == "1" || $data['orcatrata']['FormaPagamento'] == "2" || $data['orcatrata']['FormaPagamento'] == "3")){
								$data['orcatrata']['ValorGateway'] = ($data['orcatrata']['ValorFatura'] * 0.04) + 0.40;
							}else{
								$data['orcatrata']['ValorGateway'] = 0.00;
							}
							$data['orcatrata']['ValorEmpresa'] = $data['orcatrata']['ValorFatura'] - $data['orcatrata']['ValorComissao'] - $data['orcatrata']['ValorGateway'];
							
							if ($data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['UsarCashBack'] == 'S' && $data['orcatrata']['idApp_Cliente'] != 0){
								$data['orcatrata']['AtivoCashBack'] = 'N';
							}

							if($_SESSION['Orcatrata']['UsarCupom'] == "N"){
								if($data['orcatrata']['UsarCupom'] == "S"){
									$data['orcatrata']['TipoDescOrca'] = $data['cadastrar']['UsarE'];
									if($data['cadastrar']['ValidaCupom'] == 0 || !$data['orcatrata']['Cupom'] || empty($data['orcatrata']['Cupom'])){
										$data['orcatrata']['Cupom'] = 0;
									}
								}else{
									$data['orcatrata']['Cupom'] = 0;
								}
							}
							/*
							echo '<br>';
							echo "<pre>";
							echo '<br>';
							print_r($data['orcatrata']['ValorFrete']);
							echo "</pre>";
							exit();
							*/
							/*
							$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
							$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
							$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
								$data['update']['orcatrata']['anterior'],
								$data['orcatrata'],
								$data['update']['orcatrata']['campos'],
								$data['orcatrata']['idApp_OrcaTrata'], TRUE);
							$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);
							*/
							#### APP_Cliente ####
							if ($data['cadastrar']['AtualizaEndereco'] == 'S' && $data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['Entrega_Orca'] == "S" && $data['orcatrata']['idApp_Cliente'] != 0){
								$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
								$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
								$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
								$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
								$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
								$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
								$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
								$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
											
								$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
								$data['update']['cliente']['campos'] = array_keys($data['cliente']);
								/*
								$data['update']['cliente']['auditoriaitem'] = $this->basico->set_log(
									$data['update']['cliente']['anterior'],
									$data['cliente'],
									$data['update']['cliente']['campos'],
									$data['cliente']['idApp_Cliente'], TRUE);
								*/	
								$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);
								
								/*
								// ""ver modo correto de fazer o set_log e set_auditoria""
								if ($data['auditoriaitem'] === FALSE) {
									$data['msg'] = '';
								} else {
									$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
									$data['msg'] = '?m=1';
								}
								*/
								
							}

							
							/*
							//echo count($data['servico']);
							echo '<br>';
							echo "<pre>";
							print_r($data['cliente']);
							echo "</pre>";
							exit ();
							*/			
							
							#### App_Servico ####
							$data['update']['servico']['anterior'] = $this->Orcatrata_model->get_servico($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

								if (isset($data['servico']))
									$data['servico'] = array_values($data['servico']);
								else
									$data['servico'] = array();

								//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
								$data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_Produto');

								$max = count($data['update']['servico']['inserir']);
								for($j=0;$j<$max;$j++) {
									
									if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_1']){
										$data['update']['servico']['inserir'][$j]['ProfissionalProduto_1'] = 0;
									}
									if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_2']){
										$data['update']['servico']['inserir'][$j]['ProfissionalProduto_2'] = 0;
									}
									if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_3']){
										$data['update']['servico']['inserir'][$j]['ProfissionalProduto_3'] = 0;
									}
									if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_4']){
										$data['update']['servico']['inserir'][$j]['ProfissionalProduto_4'] = 0;
									}
									if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_5']){
										$data['update']['servico']['inserir'][$j]['ProfissionalProduto_5'] = 0;
									}
									if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_6']){
										$data['update']['servico']['inserir'][$j]['ProfissionalProduto_6'] = 0;
									}					

									$data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['Orcatrata']['idSis_Usuario'];
									$data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
									$data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
									$data['update']['servico']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
									$data['update']['servico']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
									$data['update']['servico']['inserir'][$j]['idTab_TipoRD'] = "2";
									$data['update']['servico']['inserir'][$j]['NivelProduto'] = $_SESSION['Orcatrata']['NivelOrca'];

									if(empty($data['update']['servico']['inserir'][$j]['ValorProduto'])){
										$data['update']['servico']['inserir'][$j]['ValorProduto'] = "0.00";
									}else{
										$data['update']['servico']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorProduto']));
									}

									if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_1'])){
										$data['update']['servico']['inserir'][$j]['ValorComProf_1'] = "0.00";
									}else{
										$data['update']['servico']['inserir'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_1']));
									}

									if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_2'])){
										$data['update']['servico']['inserir'][$j]['ValorComProf_2'] = "0.00";
									}else{
										$data['update']['servico']['inserir'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_2']));
									}

									if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_3'])){
										$data['update']['servico']['inserir'][$j]['ValorComProf_3'] = "0.00";
									}else{
										$data['update']['servico']['inserir'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_3']));
									}

									if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_4'])){
										$data['update']['servico']['inserir'][$j]['ValorComProf_4'] = "0.00";
									}else{
										$data['update']['servico']['inserir'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_4']));
									}

									if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_5'])){
										$data['update']['servico']['inserir'][$j]['ValorComProf_5'] = "0.00";
									}else{
										$data['update']['servico']['inserir'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_5']));
									}

									if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_6'])){
										$data['update']['servico']['inserir'][$j]['ValorComProf_6'] = "0.00";
									}else{
										$data['update']['servico']['inserir'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_6']));
									}

									if(empty($data['update']['servico']['inserir'][$j]['ValorComissaoServico'])){
										$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = "0.00";
									}else{
										$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComissaoServico']));
									}

									$data['update']['servico']['inserir'][$j]['ValorComissaoVenda'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto'];
									
									//$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoServicoProduto'];
									$data['update']['servico']['inserir'][$j]['ValorComissaoAssociado'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoServicoProduto'];

									$data['update']['servico']['inserir'][$j]['ValorComissaoFuncionario'] = $data['update']['servico']['inserir'][$j]['QtdProduto']*$data['update']['servico']['inserir'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;

									$data['update']['servico']['inserir'][$j]['ValorComissaoCashBack'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoCashBackProduto'];
									
									if(!$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] || $data['update']['servico']['inserir'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['servico']['inserir'][$j]['DataValidadeProduto'])){
										$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataValidadeProduto'], 'mysql');
									}
														
									if(!$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] || $data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['servico']['inserir'][$j]['DataConcluidoProduto'])){
										$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataConcluidoProduto'], 'mysql');
									}
									
									if(!$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] || $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] == ""){
										$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
									}else{
										$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'];
									}					
									
									if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
										$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = 'S';
									} else {
										$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['ConcluidoProduto'];
									}

									unset($data['update']['servico']['inserir'][$j]['SubtotalProduto']);
									unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto']);
									unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoServicoProduto']);
									unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoCashBackProduto']);
									unset($data['update']['servico']['inserir'][$j]['SubtotalQtdProduto']);
								}

								$max = count($data['update']['servico']['alterar']);
								for($j=0;$j<$max;$j++) {
								
									if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_1']){
										$data['update']['servico']['alterar'][$j]['ProfissionalProduto_1'] = 0;
									}
									if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_2']){
										$data['update']['servico']['alterar'][$j]['ProfissionalProduto_2'] = 0;
									}
									if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_3']){
										$data['update']['servico']['alterar'][$j]['ProfissionalProduto_3'] = 0;
									}
									if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_4']){
										$data['update']['servico']['alterar'][$j]['ProfissionalProduto_4'] = 0;
									}
									if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_5']){
										$data['update']['servico']['alterar'][$j]['ProfissionalProduto_5'] = 0;
									}
									if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_6']){
										$data['update']['servico']['alterar'][$j]['ProfissionalProduto_6'] = 0;
									}
									
									$data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'];
									
									$data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'];

									if(empty($data['update']['servico']['alterar'][$j]['ValorProduto'])){
										$data['update']['servico']['alterar'][$j]['ValorProduto'] = "0.00";
									}else{
										$data['update']['servico']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorProduto']));
									}

									if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_1'])){
										$data['update']['servico']['alterar'][$j]['ValorComProf_1'] = "0.00";
									}else{
										$data['update']['servico']['alterar'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_1']));
									}

									if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_2'])){
										$data['update']['servico']['alterar'][$j]['ValorComProf_2'] = "0.00";
									}else{
										$data['update']['servico']['alterar'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_2']));
									}

									if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_3'])){
										$data['update']['servico']['alterar'][$j]['ValorComProf_3'] = "0.00";
									}else{
										$data['update']['servico']['alterar'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_3']));
									}

									if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_4'])){
										$data['update']['servico']['alterar'][$j]['ValorComProf_4'] = "0.00";
									}else{
										$data['update']['servico']['alterar'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_4']));
									}

									if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_5'])){
										$data['update']['servico']['alterar'][$j]['ValorComProf_5'] = "0.00";
									}else{
										$data['update']['servico']['alterar'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_5']));
									}

									if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_6'])){
										$data['update']['servico']['alterar'][$j]['ValorComProf_6'] = "0.00";
									}else{
										$data['update']['servico']['alterar'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_6']));
									}

									if(empty($data['update']['servico']['alterar'][$j]['ValorComissaoServico'])){
										$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = "0.00";
									}else{
										$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComissaoServico']));
									}

									$data['update']['servico']['alterar'][$j]['ValorComissaoVenda'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto'];
									
									//$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoServicoProduto'];
									$data['update']['servico']['alterar'][$j]['ValorComissaoAssociado'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoServicoProduto'];

									$data['update']['servico']['alterar'][$j]['ValorComissaoFuncionario'] = $data['update']['servico']['alterar'][$j]['QtdProduto']*$data['update']['servico']['alterar'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;

									$data['update']['servico']['alterar'][$j]['ValorComissaoCashBack'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoCashBackProduto'];
								
									if(!$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] || $data['update']['servico']['alterar'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['servico']['alterar'][$j]['DataValidadeProduto'])){
										$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeProduto'], 'mysql');
									}
																			
									if(!$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] || $data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['servico']['alterar'][$j]['DataConcluidoProduto'])){
										$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataConcluidoProduto'], 'mysql');
									}
									
									if(!$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] || $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] == ""){
										$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
									}else{
										$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'];
									}					
									
									if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
										$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = 'S';
									} else {
										$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['ConcluidoProduto'];
									}
									
									if ($data['orcatrata']['idApp_Cliente']) $data['update']['servico']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];

									unset($data['update']['servico']['alterar'][$j]['SubtotalProduto']);
									unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto']);
									unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoServicoProduto']);
									unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoCashBackProduto']);
									unset($data['update']['servico']['alterar'][$j]['SubtotalQtdProduto']);					
								}

								if (count($data['update']['servico']['inserir']))
									$data['update']['servico']['bd']['inserir'] = $this->Orcatrata_model->set_servico($data['update']['servico']['inserir']);

								if (count($data['update']['servico']['alterar']))
									$data['update']['servico']['bd']['alterar'] = $this->Orcatrata_model->update_servico($data['update']['servico']['alterar']);

								if (count($data['update']['servico']['excluir']))
									$data['update']['servico']['bd']['excluir'] = $this->Orcatrata_model->delete_servico($data['update']['servico']['excluir']);
							}

							#### App_Produto ####
							$data['update']['produto']['anterior'] = $this->Orcatrata_model->get_produto($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

								if (isset($data['produto']))
									$data['produto'] = array_values($data['produto']);
								else
									$data['produto'] = array();

								//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
								$data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_Produto');

								$max = count($data['update']['produto']['inserir']);
								for($j=0;$j<$max;$j++) {
								
									$data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['Orcatrata']['idSis_Usuario'];
									$data['update']['produto']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
									$data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
									$data['update']['produto']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
									$data['update']['produto']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
									$data['update']['produto']['inserir'][$j]['idTab_TipoRD'] = "2";
									$data['update']['produto']['inserir'][$j]['NivelProduto'] = $_SESSION['Orcatrata']['NivelOrca'];

									if(empty($data['update']['produto']['inserir'][$j]['ValorProduto'])){
										$data['update']['produto']['inserir'][$j]['ValorProduto'] = "0.00";
									}else{
										$data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));
									}

									$data['update']['produto']['inserir'][$j]['ValorComissaoVenda'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto'];
									
									//$data['update']['produto']['inserir'][$j]['ValorComissaoServico'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoServicoProduto'];
									$data['update']['produto']['inserir'][$j]['ValorComissaoAssociado'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoServicoProduto'];

									$data['update']['produto']['inserir'][$j]['ValorComissaoFuncionario'] = $data['update']['produto']['inserir'][$j]['QtdProduto']*$data['update']['produto']['inserir'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;

									$data['update']['produto']['inserir'][$j]['ValorComissaoCashBack'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoCashBackProduto'];
									
									if(!$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] || $data['update']['produto']['inserir'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['produto']['inserir'][$j]['DataValidadeProduto'])){
										$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
									}
														
									if(!$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] || $data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['produto']['inserir'][$j]['DataConcluidoProduto'])){
										$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataConcluidoProduto'], 'mysql');
									}
									
									if(!$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] || $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] == ""){
										$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
									}else{
										$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'];
									}
										
									if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
										$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
									} else {
										$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
									}

									unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
									unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
									unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoServicoProduto']);
									unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoCashBackProduto']);
									unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);
								}

								$max = count($data['update']['produto']['alterar']);
								for($j=0;$j<$max;$j++) {

									$data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
									$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
									$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];

									if(empty($data['update']['produto']['alterar'][$j]['ValorProduto'])){
										$data['update']['produto']['alterar'][$j]['ValorProduto'] = "0.00";
									}else{
										$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
									}

									$data['update']['produto']['alterar'][$j]['ValorComissaoVenda'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto'];
									
									//$data['update']['produto']['alterar'][$j]['ValorComissaoServico'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoServicoProduto'];
									$data['update']['produto']['alterar'][$j]['ValorComissaoAssociado'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoServicoProduto'];

									$data['update']['produto']['alterar'][$j]['ValorComissaoFuncionario'] = $data['update']['produto']['alterar'][$j]['QtdProduto']*$data['update']['produto']['alterar'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;

									$data['update']['produto']['alterar'][$j]['ValorComissaoCashBack'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoCashBackProduto'];

									if(!$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] || $data['update']['produto']['alterar'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['produto']['alterar'][$j]['DataValidadeProduto'])){
										$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
									}
														
									if(!$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['produto']['alterar'][$j]['DataConcluidoProduto'])){
										$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataConcluidoProduto'], 'mysql');
									}
									
									if(!$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] == ""){
										$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
									}else{
										$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'];
									}
									
									if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
										$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
									} else {
										$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['ConcluidoProduto'];
									}
									
									if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
										$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'S';
									} else {	
										$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = $data['update']['produto']['alterar'][$j]['DevolvidoProduto'];
									}
									
									if ($data['orcatrata']['idApp_Cliente']) $data['update']['produto']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];

									unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
									unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
									unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoServicoProduto']);
									unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoCashBackProduto']);
									unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);
									
								}

								if (count($data['update']['produto']['inserir']))
									$data['update']['produto']['bd']['inserir'] = $this->Orcatrata_model->set_produto($data['update']['produto']['inserir']);

								if (count($data['update']['produto']['alterar']))
									$data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

								if (count($data['update']['produto']['excluir']))
									$data['update']['produto']['bd']['excluir'] = $this->Orcatrata_model->delete_produto($data['update']['produto']['excluir']);

							}
							
							#### App_ParcelasRec ####
							$data['update']['parcelasrec']['anterior'] = $this->Orcatrata_model->get_parcelas($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

								if (isset($data['parcelasrec']))
									$data['parcelasrec'] = array_values($data['parcelasrec']);
								else
									$data['parcelasrec'] = array();

								//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
								$data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

								$max = count($data['update']['parcelasrec']['inserir']);
								for($j=0;$j<$max;$j++) {
									$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
									$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
									$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
									$data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
									$data['update']['parcelasrec']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
									$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "2";
									$data['update']['parcelasrec']['inserir'][$j]['NivelParcela'] = $_SESSION['Orcatrata']['NivelOrca'];
									
									$data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
									$data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
									//$data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
									$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
									if($data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela']){
										$data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'] = $data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'];
									}else{
										$data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
									}
									if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
										$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
									} else {
										$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
									}
									if ($data['update']['parcelasrec']['inserir'][$j]['Quitado'] == 'S'){
										if(!$data['update']['parcelasrec']['inserir'][$j]['DataPago']){
											$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'];
										}else{
											$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $data['update']['parcelasrec']['inserir'][$j]['DataPago'];
										}
										$data['update']['parcelasrec']['inserir'][$j]['DataLanc'] = date('Y-m-d', time());
									} else {
										$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = "0000-00-00";
										$data['update']['parcelasrec']['inserir'][$j]['DataLanc'] = "0000-00-00";
									}
								
								}

								$max = count($data['update']['parcelasrec']['alterar']);
								for($j=0;$j<$max;$j++) {
									$data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
									$data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
									//$data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
									$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
									$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataLanc'], 'mysql');
									if($data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela']){
										$data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'] = $data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'];
									}else{
										$data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
									}
									if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
										$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
									} else {
										$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = $data['update']['parcelasrec']['alterar'][$j]['Quitado'];
									}
									if ($data['update']['parcelasrec']['alterar'][$j]['Quitado'] == 'S'){
										if(!$data['update']['parcelasrec']['alterar'][$j]['DataPago']){
											$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'];
										}else{
											$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataPago'];
										}
										if(!$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] || empty($data['update']['parcelasrec']['alterar'][$j]['DataLanc']) || $data['update']['parcelasrec']['alterar'][$j]['DataPago'] == "0000-00-00"){
											$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = date('Y-m-d', time());
										}
									} else {
										$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = "0000-00-00";
										$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = "0000-00-00";
									}
									if ($data['orcatrata']['idApp_Cliente']) $data['update']['parcelasrec']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
								}

								if (count($data['update']['parcelasrec']['inserir']))
									$data['update']['parcelasrec']['bd']['inserir'] = $this->Orcatrata_model->set_parcelas($data['update']['parcelasrec']['inserir']);

								if (count($data['update']['parcelasrec']['alterar']))
									$data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

								if (count($data['update']['parcelasrec']['excluir']))
									$data['update']['parcelasrec']['bd']['excluir'] = $this->Orcatrata_model->delete_parcelas($data['update']['parcelasrec']['excluir']);

							}
							
							#### App_Procedimento ####
							$data['update']['procedimento']['anterior'] = $this->Orcatrata_model->get_procedimento($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

								if (isset($data['procedimento']))
									$data['procedimento'] = array_values($data['procedimento']);
								else
									$data['procedimento'] = array();

								//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
								$data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_Procedimento');

								$max = count($data['update']['procedimento']['inserir']);
								for($j=0;$j<$max;$j++) {
									$data['update']['procedimento']['inserir'][$j]['TipoProcedimento'] = 2;
									$data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
									$data['update']['procedimento']['inserir'][$j]['NivelProcedimento'] = $_SESSION['Orcatrata']['NivelOrca'];
									if(!$data['update']['procedimento']['inserir'][$j]['Compartilhar']){
										$data['update']['procedimento']['inserir'][$j]['Compartilhar'] = $_SESSION['log']['idSis_Usuario'];	
									}
									$data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
									$data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
									$data['update']['procedimento']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
									$data['update']['procedimento']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
									$data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');
									
									if(!$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento']){
										$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
									}else{
										$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'], 'mysql');
									}
								
								}

								$max = count($data['update']['procedimento']['alterar']);
								for($j=0;$j<$max;$j++) {
									$data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');
									
									if(!$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento']){
										$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
									}else{                  
										$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'], 'mysql');
									}
									
									if ($data['orcatrata']['idApp_Cliente']) $data['update']['procedimento']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
								}

								if (count($data['update']['procedimento']['inserir']))
									$data['update']['procedimento']['bd']['inserir'] = $this->Orcatrata_model->set_procedimento($data['update']['procedimento']['inserir']);

								if (count($data['update']['procedimento']['alterar']))
									$data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

								if (count($data['update']['procedimento']['excluir']))
									$data['update']['procedimento']['bd']['excluir'] = $this->Orcatrata_model->delete_procedimento($data['update']['procedimento']['excluir']);

							}
							
							#### Recalcaula as Comiss�es ####
							$data['orcatrata']['ValorComissaoFunc'] = 0;
							$data['orcatrata']['ValorComissaoAssoc'] = 0;
							$data['update']['produto']['atual'] = $this->Orcatrata_model->get_produto_comissao_atual($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['update']['produto']['atual'])){
								$max_produto = count($data['update']['produto']['atual']);
								if($max_produto > 0){
									for($j=0;$j<$max_produto;$j++) {
										$data['orcatrata']['ValorComissaoFunc'] += $data['update']['produto']['atual'][$j]['ValorComissaoFuncionario'];
										$data['orcatrata']['ValorComissaoAssoc'] += $data['update']['produto']['atual'][$j]['ValorComissaoAssociado'];
									}
								}
							}
						
							$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_contagem($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['update']['produto']['posterior'])){
								$max_produto = count($data['update']['produto']['posterior']);
								if($max_produto > 0){
									$data['orcatrata']['Prd_Srv_Orca'] = "S";
								}
							}
							
							$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['update']['produto']['posterior'])){
								$max_produto = count($data['update']['produto']['posterior']);
								if($max_produto == 0){
									$data['orcatrata']['CombinadoFrete'] = "S";
									#$data['orcatrata']['AprovadoOrca'] = "S";
									$data['orcatrata']['ProntoOrca'] = "S";
									$data['orcatrata']['EnviadoOrca'] = "S";
									$data['orcatrata']['ConcluidoOrca'] = "S";
								}else{
									$data['orcatrata']['ConcluidoOrca'] = "N";
								}
							}
							
							$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['update']['parcelasrec']['posterior'])){
								$max_parcela = count($data['update']['parcelasrec']['posterior']);
								if($max_parcela == 0){
									#$data['orcatrata']['CombinadoFrete'] = "S";
									$data['orcatrata']['AprovadoOrca'] = "S";
									$data['orcatrata']['QuitadoOrca'] = "S";				
								}else{
									$data['orcatrata']['QuitadoOrca'] = "N";
								}
							}
							
							$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);
							if (isset($data['update']['produto']['posterior'])){
								$max_produto = count($data['update']['produto']['posterior']);
								if($max_produto > 0){
									$data['orcatrata']['CombinadoFrete'] = "S";
									#$data['orcatrata']['AprovadoOrca'] = "S";
								}
							}			

							$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);	
							if (isset($data['update']['parcelasrec']['posterior'])){
								$max_parcela = count($data['update']['parcelasrec']['posterior']);
								if($max_parcela > 0){
									#$data['orcatrata']['CombinadoFrete'] = "S";
									$data['orcatrata']['AprovadoOrca'] = "S";				
								}

							}			
							
							if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['FinalizadoOrca'] = "S";
								$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
							}else{
								$data['orcatrata']['FinalizadoOrca'] = "N";
							}

							$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
							$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
							$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
								$data['update']['orcatrata']['anterior'],
								$data['orcatrata'],
								$data['update']['orcatrata']['campos'],
								$data['orcatrata']['idApp_OrcaTrata'], TRUE);
							$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);
							
							#### Whatsapp ####
							if($data['cadastrar']['Whatsapp'] == 'S'){
								$_SESSION['bd_orcamento']['Whatsapp'] = $data['cadastrar']['Whatsapp'];
								$_SESSION['bd_orcamento']['Whatsapp_Site'] = $data['cadastrar']['Whatsapp_Site'];
							}
							
							#### Estoque_Produto_posterior e CashBack_posterior####
							
								
								#### Estoque_Produto_posterior ####
								if ($data['orcatrata']['CombinadoFrete'] == 'S' && $data['orcatrata']['CanceladoOrca'] == 'N') {
									
									$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
									
									if (count($data['busca']['estoque']['posterior']) > 0) {
										
										$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
										$max_estoque = count($data['busca']['estoque']['posterior']);
										
										if (isset($data['busca']['estoque']['posterior'])){
											
											for($j=1;$j<=$max_estoque;$j++) {
												
												$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
												
												if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
													
													$qtd_produto[$j]	= ($data['busca']['estoque']['posterior'][$j]['QtdProduto'] * $data['busca']['estoque']['posterior'][$j]['QtdIncrementoProduto']);
													
													$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] - $qtd_produto[$j]);
													
													if($diff_estoque[$j] <= 0){
														$estoque[$j] = 0; 
													}else{
														$estoque[$j] = $diff_estoque[$j]; 
													}
													
													$data['alterar']['produto']['posterior'][$j]['Estoque'] = $estoque[$j];
													$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$j], $data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
													
													unset($qtd_produto[$j]);
													unset($diff_estoque[$j]);
													unset($estoque[$j]);
												}
												
											}
											
										}
										
									}
									
								}
					
								#### CashBack_posterior ####
								$data['busca']['cashback']['anterior'] = $this->Orcatrata_model->get_produto_cashback_pedido($data['orcatrata']['idApp_OrcaTrata']);
								$max_cashback = count($data['busca']['cashback']['anterior']);				

								if ($max_cashback > 0) {
									
									$data['busca']['cashback']['anterior'] = array_combine(range(1, count($data['busca']['cashback']['anterior'])), array_values($data['busca']['cashback']['anterior']));
									
									if (isset($data['busca']['cashback']['anterior'])){
										
										$data['valorcashbackpedido']=0;
										
										for($j=1;$j<=$max_cashback;$j++) {
											$data['get']['valorcashback'][$j] = $data['busca']['cashback']['anterior'][$j]['ValorComissaoCashBack'];
											$data['valorcashbackpedido'] += $data['get']['valorcashback'][$j];
										}
										
										$data['update']['cliente_cashback']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
										$data['valorcashbackcliente'] = $data['update']['cliente_cashback']['anterior']['CashBackCliente'];
										
										//somo o valorcashbackpedido ao valor atual do cashbackcliente
										if ($data['orcatrata']['CanceladoOrca'] == 'N') {	
											
											if ($data['orcatrata']['QuitadoOrca'] == 'S') {	
													
												if ($data['cadastrar']['StatusParcelas'] == 'S') {		
													//Somo o valorcashbackpedido + valorcashbackoutrasos + valoratualcashbackcliente
													$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] + $data['valorcashbackpedido'] + $data['soma_cashback_repet_total_outras'];
								
													if($data['cliente_cashback']['CashBackCliente'] >= 0){
														$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
													}else{
														$data['cliente_cashback']['CashBackCliente'] = 0.00;
													}
													if($_SESSION['Orcatrata']['QuitadoOrca'] == 'N'){
														$data['cliente_cashback']['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
													}
													$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);
												
												}else{
													//Somo o valorcashbackpedido + valorcashbackoutrasos  + valoratualcashbackcliente
													$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] + $data['valorcashbackpedido'] + $data['soma_cashback_repet_s_pago_outras'];
								
													if($data['cliente_cashback']['CashBackCliente'] >= 0){
														$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
													}else{
														$data['cliente_cashback']['CashBackCliente'] = 0.00;
													}
													if($_SESSION['Orcatrata']['QuitadoOrca'] == 'N'){
														$data['cliente_cashback']['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
													}
													$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);
																	
												}
											}else{
													
												if ($data['cadastrar']['StatusParcelas'] == 'S') {		
													//Mantenho, apenas, o valoratualcashbackcliente

												}else{
													//Somo o valorcashbackoutrasos + valoratualcashbackcliente
													$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] + $data['soma_cashback_repet_s_pago_outras'];
								
													if($data['cliente_cashback']['CashBackCliente'] >= 0){
														$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
													}else{
														$data['cliente_cashback']['CashBackCliente'] = 0.00;
													}
													$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);
																	
												}
												
											}
												
										}else{
										
											//Somo o valorcashbackoutrasos + valoratualcashbackcliente
											$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] + $data['soma_cashback_repet_s_pago_outras'];
						
											if($data['cliente_cashback']['CashBackCliente'] >= 0){
												$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
											}else{
												$data['cliente_cashback']['CashBackCliente'] = 0.00;
											}
											$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);
																
										}
										
									}
									
								}			
								
							if(isset($data['orcatrata']['idApp_Cliente']) && $data['orcatrata']['idApp_Cliente'] != 0 && $data['orcatrata']['idApp_Cliente'] != ''){

								$data['update']['cliente_ult_pdd']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);

								if(strtotime($data['update']['cliente_ult_pdd']['anterior']['UltimoPedido']) < strtotime($data['orcatrata']['DataOrca'])){
								
									$data['cliente_ult_pdd']['UltimoPedido'] 		= $data['orcatrata']['DataOrca'];
									$data['cliente_ult_pdd']['id_UltimoPedido'] 	= $data['orcatrata']['idApp_OrcaTrata'];
									$data['update']['cliente_ult_pdd']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_ult_pdd'], $data['orcatrata']['idApp_Cliente']);
								
								}else if(strtotime($data['update']['cliente_ult_pdd']['anterior']['UltimoPedido']) == strtotime($data['orcatrata']['DataOrca'])){
									
									if($data['update']['cliente_ult_pdd']['anterior']['id_UltimoPedido'] < $data['orcatrata']['idApp_OrcaTrata']){
										
										$data['cliente_ult_pdd']['id_UltimoPedido'] = $data['orcatrata']['idApp_OrcaTrata'];
										$data['update']['cliente_ult_pdd']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_ult_pdd'], $data['orcatrata']['idApp_Cliente']);
									}
									
								}else{
									
									if($data['update']['cliente_ult_pdd']['anterior']['id_UltimoPedido'] == $data['orcatrata']['idApp_OrcaTrata']){

										$data['get_ult_pdd_cliente'] = $this->Orcatrata_model->get_ult_pdd_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
										$data['cliente_ult_pdd']['UltimoPedido'] 	= $data['get_ult_pdd_cliente']['DataOrca'];
										$data['cliente_ult_pdd']['id_UltimoPedido'] = $data['get_ult_pdd_cliente']['idApp_OrcaTrata'];						
										$data['update']['cliente_ult_pdd']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_ult_pdd'], $data['orcatrata']['idApp_Cliente']);
									}
									
								}
													
							}			

							if($data['count_orcatratas'] > 0){
							
								if($data['orcatrata']['QuitadoOrca'] == "S"){	
									
									if($data['cadastrar']['StatusParcelas'] == "S"){
										
										for($j=0;$j<$data['count_orcatratas'];$j++) {
											$data['update']['orcamentos']['bd'][$j] = $this->baixaparcelasrepet($_SESSION['Orcatratas'][$j]['idApp_OrcaTrata']);
										}
										
									}else{
									
									}
									
								}else{
									
									if($data['cadastrar']['StatusParcelas'] == "S"){
										
										for($j=0;$j<$data['count_orcatratas'];$j++) {
											$data['update']['orcamentos']['bd'][$j] = $this->revert_baixaparcelasrepet($_SESSION['Orcatratas'][$j]['idApp_OrcaTrata']);
										}
										
									}else{
									
									}
													
								}
								
								/*
								if($data['orcatrata']['ConcluidoOrca'] == "S" && $data['cadastrar']['StatusProdutos'] == "S"){
									for($j=0;$j<$data['count_orcatratas'];$j++) {
										$data['update']['orcamentos']['bd'][$j] = $this->baixaprodutosrepet($_SESSION['Orcatratas'][$j]['idApp_OrcaTrata']);
									}
								}
								*/
							}		
							/*
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
										//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
										$data['campos'] = array_keys($data['query']);
										$data['anterior'] = array();
										//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
							//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
							*/


							if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
								$data['msg'] = '?m=2';
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

								$this->basico->erro($msg);
								$this->load->view('orcatrata/form_orcatrataalterar', $data);
							} else {
								
								//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
								//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';

								unset($_SESSION['Orcatrata'], $_SESSION['ClientePet'], $_SESSION['ClienteDep'], $_SESSION['Orcatratas'], $_SESSION['Consultas_orca']);
								
								redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
								exit();
							}
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');

    }

    public function alterar2($id = FALSE) {

		$acesso = FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$acesso = TRUE;
		}else{
			if($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Usuario']['Nivel'] != 2 && $_SESSION['Usuario']['Usu_Rec'] == "S" && $_SESSION['Usuario']['Edit_Orcam'] == "S"){
				$acesso = TRUE;
			}	
		}
		
		if($acesso === FALSE){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 3)
				$data['msg'] = $this->basico->msg('<strong>N�o � poss�vel salvar as altera��es.<br>N�o identificamos o pagamento da sua �ltima Fatura.<br>Por favor, Entre em contato com a administra��o da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
			else
				$data['msg'] = '';
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'ConcluidoProduto',
				'QuitadoParcelas',
				'Cadastrar',
				'AtualizaEndereco',
				'StatusProdutos',
				'StatusParcelas',
				'Valor_S_Desc',
				'Valor_C_Desc',
				'UsarC',
				'UsarD',
				'UsarE',
				'ValidaCupom',
				'MensagemCupom',
				'CodigoCupom',
			), TRUE));

			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['orcatrata'] = quotes_to_entities($this->input->post(array(
				#### App_OrcaTrata ####
				'idApp_OrcaTrata',
				#N�o h� a necessidade de atualizar o valor do campo a seguir
				'idApp_Cliente',
				'DataOrca',
				'TipoFinanceiro',
				'Descricao',
				'AprovadoOrca',
				'ConcluidoOrca',
				'BrindeOrca',
				'DevolvidoOrca',
				'ProntoOrca',
				'QuitadoOrca',
				'FinalizadoOrca',
				'ValorOrca',
				'ValorComissao',
				'QtdPrdOrca',
				'QtdSrvOrca',
				'PrazoProdutos',
				'PrazoServicos',
				'PrazoProdServ',
				'PrazoCorreios',
				'ValorDev',
				'ValorDinheiro',
				'ValorTroco',
				'ValorRestanteOrca',
				'FormaPagamento',
				//'QtdParcelasOrca',
				//'DataVencimentoOrca',
				'ObsOrca',
				'Consideracoes',
				'Modalidade',
				#'idTab_TipoRD',
				'AVAP',
				'Tipo_Orca',
				'EnviadoOrca',
				'Cep',
				'Logradouro',
				'Numero',
				'Complemento',
				'Bairro',
				'Cidade',
				'Estado',
				'Referencia',
				'CombinadoFrete',
				'TipoFrete',
				'ValorFrete',
				'ValorExtraOrca',
				'PercExtraOrca',
				'ValorSomaOrca',
				'PrazoEntrega',
				'ValorTotalOrca',
				'Entregador',
				'DataEntregaOrca',
				'HoraEntregaOrca',
				'NomeRec',
				'TelefoneRec',
				'ParentescoRec',
				'ObsEntrega',
				'Aux1Entrega',
				'Aux2Entrega',
				'DetalhadaEntrega',
				'CanceladoOrca',
				'Cli_Forn_Orca',
				'Prd_Srv_Orca',
				'Entrega_Orca',
				'TipoDescOrca',
				'TipoExtraOrca',
				'DescPercOrca',
				'DescValorOrca',
				'CashBackOrca',
				'ValidadeCashBackOrca',
				'UsarCashBack',
				'UsarCupom',
				'Cupom',
				'SubValorFinal',
				'ValorFinalOrca',
			), TRUE));
			
			$data['cliente'] = $this->input->post(array(
				'idApp_Cliente',
				'CepCliente',
				'EnderecoCliente',
				'NumeroCliente',
				'ComplementoCliente',
				'CidadeCliente',
				'BairroCliente',
				'MunicipioCliente',
				'EstadoCliente',
				'ReferenciaCliente',
			), TRUE);

			$caracteres_sem_acento = array(
				'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
				'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
				'�'=>'I', '�'=>'N', 'N'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
				'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
				'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
				'�'=>'i', '�'=>'o', '�'=>'n', 'n'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
				'�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f',
				'a'=>'a', '�'=>'i', '�'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', '�'=>'I', '�'=>'A', '?'=>'S', '?'=>'T',
			);

			$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Logradouro'], $caracteres_sem_acento));

			$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['orcatrata']['Cep'], $caracteres_sem_acento));

			$numero1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Numero'], $caracteres_sem_acento));

			$complemento1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Complemento'], $caracteres_sem_acento));

			$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Bairro'], $caracteres_sem_acento));

			$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Cidade'], $caracteres_sem_acento));

			$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Estado'], $caracteres_sem_acento));

			$referencia1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Referencia'], $caracteres_sem_acento));
			
			//D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
			//comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

			(isset($_SESSION['Usuario']['Bx_Pag']) && $_SESSION['Usuario']['Bx_Pag'] == "S") ? $data['div']['Prof_comissao'] = '' : $data['div']['Prof_comissao'] = 'style="display: none;"';		
			
			(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
			(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
			(!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
			(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
			
			#(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
			(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '0' : FALSE;
			if($_SESSION['log']['idSis_Empresa'] != 5){
				(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
				(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;
				(!$data['orcatrata']['Entrega_Orca']) ? $data['orcatrata']['Entrega_Orca'] = 'S' : FALSE;
			}else{
				$data['orcatrata']['Cli_Forn_Orca'] = 'N';
				$data['orcatrata']['Prd_Srv_Orca'] = 'N';
				$data['orcatrata']['Entrega_Orca'] = 'N';
			} 		
			(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
			//(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
			(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
			(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
			(!$data['orcatrata']['Entregador']) ? $data['orcatrata']['Entregador'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoProdServ']) ? $data['orcatrata']['PrazoProdServ'] = '0' : FALSE;
			(!$data['orcatrata']['ValorOrca']) ? $data['orcatrata']['ValorOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorDev']) ? $data['orcatrata']['ValorDev'] = '0.00' : FALSE;
			(!$data['orcatrata']['QtdPrdOrca']) ? $data['orcatrata']['QtdPrdOrca'] = '0' : FALSE;
			(!$data['orcatrata']['QtdSrvOrca']) ? $data['orcatrata']['QtdSrvOrca'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoProdutos']) ? $data['orcatrata']['PrazoProdutos'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoServicos']) ? $data['orcatrata']['PrazoServicos'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoCorreios']) ? $data['orcatrata']['PrazoCorreios'] = '0' : FALSE;
			(!$data['orcatrata']['TipoDescOrca']) ? $data['orcatrata']['TipoDescOrca'] = 'V' : FALSE;
			(!$data['orcatrata']['TipoExtraOrca']) ? $data['orcatrata']['TipoExtraOrca'] = 'V' : FALSE; 
			(!$data['orcatrata']['UsarCashBack']) ? $data['orcatrata']['UsarCashBack'] = 'N' : FALSE;
			(!$data['orcatrata']['UsarCupom']) ? $data['orcatrata']['UsarCupom'] = 'N' : FALSE;
			if($_SESSION['log']['idSis_Empresa'] == 5){
				(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'S' : FALSE;
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'S' : FALSE;			
			}else{
				(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;		
			}
			(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
			(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
			(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;
			
			(!$data['orcatrata']['ValorFrete']) ? $data['orcatrata']['ValorFrete'] = 0 : FALSE;
			(!$data['orcatrata']['ValorExtraOrca']) ? $data['orcatrata']['ValorExtraOrca'] = 0 : FALSE;
			(!$data['orcatrata']['PercExtraOrca']) ? $data['orcatrata']['PercExtraOrca'] = 0 : FALSE;
			(!$data['orcatrata']['DescPercOrca']) ? $data['orcatrata']['DescPercOrca'] = 0 : FALSE;
			(!$data['orcatrata']['DescValorOrca']) ? $data['orcatrata']['DescValorOrca'] = 0 : FALSE;
				
			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
			(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusProdutos']) ? $data['cadastrar']['StatusProdutos'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusParcelas']) ? $data['cadastrar']['StatusParcelas'] = 'N' : FALSE;
			(!$data['cadastrar']['ValidaCupom']) ? $data['cadastrar']['ValidaCupom'] = '0' : FALSE;
					
			/*
			$j = 1;
			for ($i = 1; $i <= $data['count']['SCount']; $i++) {

				if ($this->input->post('idTab_Servico' . $i)) {
					$data['servico'][$j]['idApp_Servico'] = $this->input->post('idApp_Servico' . $i);
					$data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
					$data['servico'][$j]['idTab_Valor_Servico'] = $this->input->post('idTab_Valor_Servico' . $i);
					$data['servico'][$j]['idTab_Produtos_Servico'] = $this->input->post('idTab_Produtos_Servico' . $i);
					$data['servico'][$j]['Prod_Serv_Servico'] = $this->input->post('Prod_Serv_Servico' . $i);
					$data['servico'][$j]['NomeServico'] = $this->input->post('NomeServico' . $i);
					$data['servico'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
					$data['servico'][$j]['ValorServico'] = $this->input->post('ValorServico' . $i);
					$data['servico'][$j]['QtdServico'] = $this->input->post('QtdServico' . $i);
					$data['servico'][$j]['QtdIncrementoServico'] = $this->input->post('QtdIncrementoServico' . $i);
					$data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
					$data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
					$data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
					$data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
					$data['servico'][$j]['ProfissionalServico_1'] = $this->input->post('ProfissionalServico_1' . $i);
					$j++;
				}

			}
			$data['count']['SCount'] = $j - 1;
			*/
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['SCount']; $i++) {

				if ($this->input->post('idTab_Servico' . $i)) {
					$data['servico'][$j]['idApp_Produto'] = $this->input->post('idApp_Servico' . $i);
					$data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
					$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
					$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
					$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
					$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
					$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
					$data['servico'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoServico' . $i);
					$data['servico'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackServico' . $i);
					$data['servico'][$j]['PrazoProduto'] = $this->input->post('PrazoServico' . $i);
					$data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
					$data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
					$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
					$data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
					$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
					$data['servico'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoServico' . $i);
					$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackServico' . $i);
					$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
					$data['servico'][$j]['ValorComissaoServico'] = $this->input->post('ValorComissaoServico' . $i);
					$data['servico'][$j]['ObsProduto'] = $this->input->post('ObsServico' . $i);
					$data['servico'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeServico' . $i);
					$data['servico'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoServico' . $i);
					$data['servico'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoServico' . $i);
					$data['servico'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoServico' . $i);
					
					$data['servico'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalServico_1' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
					}				
					$data['servico'][$j]['ProfissionalProduto_2'] = $this->input->post('ProfissionalServico_2' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_3'] = $this->input->post('ProfissionalServico_3' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_4'] = $this->input->post('ProfissionalServico_4' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_5'] = $this->input->post('ProfissionalServico_5' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_6'] = $this->input->post('ProfissionalServico_6' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
					}
					
					$data['servico'][$j]['idTFProf_1'] = $this->input->post('idTFProf_Servico_1' . $i);
					$data['servico'][$j]['ComFunProf_1'] = $this->input->post('ComFunProf_Servico_1' . $i);
					$data['servico'][$j]['ValorComProf_1'] = $this->input->post('ValorComProf_Servico_1' . $i);
					
					$data['servico'][$j]['idTFProf_2'] = $this->input->post('idTFProf_Servico_2' . $i);
					$data['servico'][$j]['ComFunProf_2'] = $this->input->post('ComFunProf_Servico_2' . $i);
					$data['servico'][$j]['ValorComProf_2'] = $this->input->post('ValorComProf_Servico_2' . $i);
					
					$data['servico'][$j]['idTFProf_3'] = $this->input->post('idTFProf_Servico_3' . $i);
					$data['servico'][$j]['ComFunProf_3'] = $this->input->post('ComFunProf_Servico_3' . $i);
					$data['servico'][$j]['ValorComProf_3'] = $this->input->post('ValorComProf_Servico_3' . $i);
					
					$data['servico'][$j]['idTFProf_4'] = $this->input->post('idTFProf_Servico_4' . $i);
					$data['servico'][$j]['ComFunProf_4'] = $this->input->post('ComFunProf_Servico_4' . $i);
					$data['servico'][$j]['ValorComProf_4'] = $this->input->post('ValorComProf_Servico_4' . $i);
					
					$data['servico'][$j]['idTFProf_5'] = $this->input->post('idTFProf_Servico_5' . $i);
					$data['servico'][$j]['ComFunProf_5'] = $this->input->post('ComFunProf_Servico_5' . $i);
					$data['servico'][$j]['ValorComProf_5'] = $this->input->post('ValorComProf_Servico_5' . $i);
					
					$data['servico'][$j]['idTFProf_6'] = $this->input->post('idTFProf_Servico_6' . $i);
					$data['servico'][$j]['ComFunProf_6'] = $this->input->post('ComFunProf_Servico_6' . $i);
					$data['servico'][$j]['ValorComProf_6'] = $this->input->post('ValorComProf_Servico_6' . $i);
					
					(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
					);
					($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';
									
					$data['select'][$j]['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_1']);
					$data['select'][$j]['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_2']);
					$data['select'][$j]['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_3']);
					$data['select'][$j]['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_4']);
					$data['select'][$j]['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_5']);
					$data['select'][$j]['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_6']);
					
					$j++;
				}

			}
			$data['count']['SCount'] = $j - 1;		

			$j = 1;
			for ($i = 1; $i <= $data['count']['PCount']; $i++) {

				if ($this->input->post('idTab_Produto' . $i)) {
					$data['produto'][$j]['idApp_Produto'] = $this->input->post('idApp_Produto' . $i);
					$data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
					$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
					$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
					$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
					$data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
					$data['produto'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoProduto' . $i);
					$data['produto'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackProduto' . $i);
					$data['produto'][$j]['PrazoProduto'] = $this->input->post('PrazoProduto' . $i);
					$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
					$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
					$data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
					$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
					$data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackProduto' . $i);
					$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
					$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
					$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
					$data['produto'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoProduto' . $i);
					$data['produto'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoProduto' . $i);
					$data['produto'][$j]['Aux_App_Produto_1'] = $this->input->post('Aux_App_Produto_1' . $i);
					$data['produto'][$j]['Aux_App_Produto_2'] = $this->input->post('Aux_App_Produto_2' . $i);
					$data['produto'][$j]['Aux_App_Produto_3'] = $this->input->post('Aux_App_Produto_3' . $i);
					$data['produto'][$j]['Aux_App_Produto_4'] = $this->input->post('Aux_App_Produto_4' . $i);
					$data['produto'][$j]['Aux_App_Produto_5'] = $this->input->post('Aux_App_Produto_5' . $i);
					$data['produto'][$j]['HoraValidadeProduto'] = $this->input->post('HoraValidadeProduto' . $i);
					$data['produto'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoProduto' . $i);
					$data['produto'][$j]['DevolvidoProduto'] = $this->input->post('DevolvidoProduto' . $i);
					$data['produto'][$j]['CanceladoProduto'] = $this->input->post('CanceladoProduto' . $i);
					//$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					//$data['produto'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalProduto_1' . $i);
					
					(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
					);
					($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';
					
					$j++;
				}
			}
			$data['count']['PCount'] = $j - 1;

			$j = 1;
			for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

				if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataConcluidoProcedimento' . $i) ||
					$this->input->post('Profissional' . $i) || $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
					$data['procedimento'][$j]['idApp_Procedimento'] = $this->input->post('idApp_Procedimento' . $i);
					$data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
					$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->input->post('DataConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['HoraProcedimento'] = $this->input->post('HoraProcedimento' . $i);
					$data['procedimento'][$j]['HoraConcluidoProcedimento'] = $this->input->post('HoraConcluidoProcedimento' . $i);				
					#$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
					//$data['procedimento'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
					$data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
					$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					$data['procedimento'][$j]['Compartilhar'] = $this->input->post('Compartilhar' . $i);
					
					(!$data['procedimento'][$j]['ConcluidoProcedimento']) ? $data['procedimento'][$j]['ConcluidoProcedimento'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
					);
					($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';	
					
					$data['select'][$j]['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos($data['procedimento'][$j]['Compartilhar']);
					
					$j++;
				}

			}
			$data['count']['PMCount'] = $j - 1;

			$data['somatotal'] = 0;	

			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
				$data['somatotal'] += $data['valoredit'][$i];            
					
				if ($data['valoredit'][$i] > 0.00){
					$data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
					$data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					//$data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$j]['DataLanc'] = $this->input->post('DataLanc' . $i);
					$data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
					$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
					//$data['parcelasrec'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					
					(!$data['parcelasrec'][$j]['Quitado']) ? $data['parcelasrec'][$j]['Quitado'] = 'N' : FALSE;
					$data['radio'] = array(
						'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
					);
					($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';				
					
					$j++;
				}
			}
			$data['count']['PRCount'] = $j - 1;
		
			//Fim do trecho de c�digo que d� pra melhorar

			if ($id) {

				#### App_OrcaTrata ####
				$_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
		
				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 2){
					
					unset($_SESSION['Orcatrata']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {			

					$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
					$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'barras');
					$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'barras');

					#### App_Servico ####
					$data['servico'] = $this->Orcatrata_model->get_servico($id);
					if (count($data['servico']) > 0) {
						$data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
						$data['count']['SCount'] = count($data['servico']);

						if (isset($data['servico'])) {

							for($j=1;$j<=$data['count']['SCount'];$j++) {
								$data['servico'][$j]['SubtotalProduto'] = number_format(($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto']), 2, ',', '.');
								$data['servico'][$j]['SubtotalComissaoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoProduto'] /100);
								$data['servico'][$j]['SubtotalComissaoServicoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoServicoProduto'] /100);
								$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoCashBackProduto'] /100);
								$data['servico'][$j]['SubtotalQtdProduto'] = ($data['servico'][$j]['QtdIncrementoProduto'] * $data['servico'][$j]['QtdProduto']);
								$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'barras');
								$data['servico'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataConcluidoProduto'], 'barras');
								$data['servico'][$j]['ValorComissaoServico'] = number_format(($data['servico'][$j]['ValorComissaoServico']), 2, ',', '.');

								$data['servico'][$j]['ValorComProf_1'] = number_format(($data['servico'][$j]['ValorComProf_1']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_2'] = number_format(($data['servico'][$j]['ValorComProf_2']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_3'] = number_format(($data['servico'][$j]['ValorComProf_3']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_4'] = number_format(($data['servico'][$j]['ValorComProf_4']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_5'] = number_format(($data['servico'][$j]['ValorComProf_5']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_6'] = number_format(($data['servico'][$j]['ValorComProf_6']), 2, ',', '.');
												
								(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
								$data['radio'] = array(
									'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
								);
								($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';
								
								$_SESSION['Servico'][$j]['ProfissionalServico_1'] = $data['servico'][$j]['ProfissionalProduto_1'];
								$_SESSION['Servico'][$j]['ProfissionalServico_2'] = $data['servico'][$j]['ProfissionalProduto_2'];
								$_SESSION['Servico'][$j]['ProfissionalServico_3'] = $data['servico'][$j]['ProfissionalProduto_3'];
								$_SESSION['Servico'][$j]['ProfissionalServico_4'] = $data['servico'][$j]['ProfissionalProduto_4'];
								$_SESSION['Servico'][$j]['ProfissionalServico_5'] = $data['servico'][$j]['ProfissionalProduto_5'];
								$_SESSION['Servico'][$j]['ProfissionalServico_6'] = $data['servico'][$j]['ProfissionalProduto_6'];
								
								$data['select'][$j]['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
								
								if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
								}						
							}
						}
					}

					#### App_Produto ####
					$data['produto'] = $this->Orcatrata_model->get_produto($id);
					if (count($data['produto']) > 0) {
						$data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
						$data['count']['PCount'] = count($data['produto']);

						if (isset($data['produto'])) {

							for($j=1;$j<=$data['count']['PCount'];$j++) {
								$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
								//$data['produto'][$j]['ComissaoProduto'] = $data['produto'][$j]['ComissaoProduto'];
								$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
								$data['produto'][$j]['SubtotalComissaoServicoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoServicoProduto'] /100);
								$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoCashBackProduto'] /100);
								$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
								$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
								$data['produto'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataConcluidoProduto'], 'barras');

								(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
								$data['radio'] = array(
									'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
								);
								($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';
								
								///esta linha deve ser retirada ap�s corre��o dos nomes dos pedidos antigos///
								//$data['produto'][$j]['NomeProduto'] = $data['produto'][$j]['Produto'];
							}

						}
					}

					#### App_Parcelas ####
					$data['parcelasrec'] = $this->Orcatrata_model->get_parcelas($id);
					if (count($data['parcelasrec']) > 0) {
						$data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
						$data['count']['PRCount'] = count($data['parcelasrec']);
						
						if (isset($data['parcelasrec'])) {

							for($j=1; $j <= $data['count']['PRCount']; $j++) {
								$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
								$data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
								$data['parcelasrec'][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataLanc'], 'barras');
							
								$data['radio'] = array(
									'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
								);
								($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';	
							}
						}
					}
					
					#### App_Procedimento ####
					$_SESSION['Procedimento'] = $_SESSION['Procedimento'] = $data['procedimento'] = $this->Orcatrata_model->get_procedimento($id);
					if (count($data['procedimento']) > 0) {
						$data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
						$data['count']['PMCount'] = count($data['procedimento']);

						if (isset($data['procedimento'])) {

							for($j=1; $j <= $data['count']['PMCount']; $j++) {
								$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');
								$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataConcluidoProcedimento'], 'barras');
								$_SESSION['Procedimento'][$j]['Nome'] = $data['procedimento'][$j]['Nome'];
							
								$data['radio'] = array(
									'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
								);
								($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';
								
								$_SESSION['Procedimento'][$j]['Compartilhar'] = $data['procedimento'][$j]['Compartilhar'];
								$data['select'][$j]['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos($_SESSION['Procedimento'][$j]['Compartilhar']);
							}
						}
					}
				}
			}
			
			if(!$data['orcatrata']['idApp_OrcaTrata'] || !$_SESSION['Orcatrata'] || $_SESSION['Orcatrata']['idTab_TipoRD'] != 2){
				
				unset($_SESSION['Orcatrata']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {

				#### Carrega os dados do Vendedor nas vari�ves de sess�o ####
				if($_SESSION['log']['idSis_Empresa'] != 5){
					if(isset($_SESSION['Orcatrata']['id_Funcionario']) && $_SESSION['Orcatrata']['id_Funcionario'] != 0){
						$data['funcionario']['Nome'] = $this->Usuario_model->get_usuario($_SESSION['Orcatrata']['id_Funcionario'], TRUE)['Nome'];
					}
					if(isset($_SESSION['Orcatrata']['id_Associado']) && $_SESSION['Orcatrata']['id_Associado'] != 0){
						$data['associado']['Nome'] = $this->Associado_model->get_associado($_SESSION['Orcatrata']['id_Associado'], TRUE)['Nome'];
					}
				}elseif($_SESSION['log']['idSis_Empresa'] == 5){
					if(isset($_SESSION['Orcatrata']['id_Funcionario']) && $_SESSION['Orcatrata']['id_Funcionario'] != 0){
						$data['associado']['Nome'] = $this->Associado_model->get_associado($_SESSION['Orcatrata']['id_Funcionario'], TRUE)['Nome'];
					}
				}
				
				#### Carrega os dados da Campanha nas vari�ves de sess�o ####
				$_SESSION['Campanha'] = $this->Campanha_model->get_campanha_cupom($_SESSION['Orcatrata']['Cupom']);
				
				#### Carrega os dados das consultas nas vari�ves de sess�o ####
				$_SESSION['Consultas_orca'] = $data['consultas_orca'] = $this->Consulta_model->get_consultas_orca($_SESSION['Orcatrata']['idApp_OrcaTrata'], TRUE);
				$_SESSION['Orcatratas'] = $data['orcatratas'] = $this->Orcatrata_model->get_orcatratas_repet($_SESSION['Orcatrata']['RepeticaoOrca']);

				/*
				echo '<br>';
				echo "<pre>";
				print_r($data['valortotalorca']);
				echo '<br>';
				print_r($data['somatotal']);
				echo '<br>';
				print_r($data['diferenca']);
				echo "</pre>";		
				*/	
				
				$data['select']['TipoDescOrca'] = array (
					'P' => '.%',
					'V' => 'R$',
				);		
				$data['select']['TipoExtraOrca'] = array (
					'P' => '.%',
					'V' => 'R$',
				);			
				$data['select']['UsarCupom'] = $this->Basico_model->select_status_sn();
				$data['select']['UsarCashBack'] = $this->Basico_model->select_status_sn();
				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
				$data['select']['StatusProdutos'] = $this->Basico_model->select_status_sn();
				$data['select']['StatusParcelas'] = $this->Basico_model->select_status_sn();
				$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['Entrega_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
				$data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
				$data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
				$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
				$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
				$data['select']['FormaPagamentoParcela'] = $this->Formapag_model->select_formapag();
				$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['DevolvidoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['ProntoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['CanceladoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
				$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
				$data['select']['TipoFrete'] = $this->Basico_model->select_tipofrete();
				$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['Quitado'] = $this->Basico_model->select_status_sn();
				$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
				$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
				//$data['select']['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalProduto_1'] = $this->Usuario_model->select_usuario();
				$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
				//$data['select']['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos();
				$data['select']['Entregador'] = $this->Usuario_model->select_usuario_entregador($_SESSION['Orcatrata']['Entregador']);
				$data['select']['Produto'] = $this->Basico_model->select_produtos3($data['orcatrata']['Tipo_Orca']);
				$data['select']['Servico'] = $this->Basico_model->select_servicos3($data['orcatrata']['Tipo_Orca']);
				#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
				$data['select']['AVAP'] = $this->Basico_model->select_avap();
				$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['Prioridade'] = array (
					'1' => 'Alta',
					'2' => 'M�dia',
					'3' => 'Baixa',
				);

				$data['count_orca'] = count($_SESSION['Consultas_orca']);		
				
				$data['titulo'] = 'Pedido';
				$data['form_open_path'] = 'orcatrata/alterar2';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;
				$data['caminho'] = '../../';
				$data['Recorrencias'] = 1;
				$data['Recorrencias_outras'] = $data['Recorrencias'] - 1;
				
				$data['exibirExtraOrca'] = 1;
				$data['exibirDescOrca'] = 1;

				$data['collapse'] = '';	
				$data['collapse1'] = 'class="collapse"';		
				
				//if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
				if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
					$data['orcamentoin'] = 'in';
				else
					$data['orcamentoin'] = '';

				if ($data['orcatrata']['FormaPagamento'])
					$data['parcelasin'] = 'in';
				else
					$data['parcelasin'] = '';

				//if (isset($data['procedimento']) && ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional']))
				if ($data['count']['PMCount'] > 0)
					$data['tratamentosin'] = 'in';
				else
					$data['tratamentosin'] = '';

				if ($_SESSION['log']['NivelEmpresa'] >= '4' )
					$data['visivel'] = '';
				else
					$data['visivel'] = 'style="display: none;"';		

				($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
				
				$data['radio'] = array(
					'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
				);
				($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
				
				($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
				/*
				$data['radio'] = array(
					'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
				);
				($data['orcatrata']['AVAP'] == 'P') ?
					$data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';		
				*/
				
				$data['radio'] = array(
					'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
				);
				($data['cadastrar']['Cadastrar'] == 'N') ?
					$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'StatusProdutos' => $this->basico->radio_checked($data['cadastrar']['StatusProdutos'], 'StatusProdutos', 'NS'),
				);
				($data['cadastrar']['StatusProdutos'] == 'S') ?
					$data['div']['StatusProdutos'] = '' : $data['div']['StatusProdutos'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'StatusParcelas' => $this->basico->radio_checked($data['cadastrar']['StatusParcelas'], 'StatusParcelas', 'NS'),
				);
				($data['cadastrar']['StatusParcelas'] == 'S') ?
					$data['div']['StatusParcelas'] = '' : $data['div']['StatusParcelas'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
				);
				($data['cadastrar']['AtualizaEndereco'] == 'N') ?
					$data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	
					
				$data['radio'] = array(
					'Modalidade' => $this->basico->radio_checked($data['orcatrata']['Modalidade'], 'Modalidade', 'PM'),
				);
				($data['orcatrata']['Modalidade'] == 'P') ?
					$data['div']['Modalidade'] = '' : $data['div']['Modalidade'] = 'style="display: none;"';
						
				$data['radio'] = array(
					'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
				);
				($data['orcatrata']['CombinadoFrete'] == 'S') ?
					$data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
				);
				($data['orcatrata']['AprovadoOrca'] == 'S') ?
					$data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
				);
				($data['orcatrata']['EnviadoOrca'] == 'S') ?
					$data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';			

				$data['radio'] = array(
					'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Cancelado', 'NS'),
				);
				($data['orcatrata']['FinalizadoOrca'] == 'N') ?
					$data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';        
				
				$data['radio'] = array(
					'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Produtos Entregues', 'NS'),
				);
				($data['orcatrata']['CanceladoOrca'] == 'N') ?
					$data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';        
				
				$data['radio'] = array(
					'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
				);
				($data['orcatrata']['ConcluidoOrca'] == 'N') ?
					$data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

					
				$data['radio'] = array(
					'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
				);
				($data['orcatrata']['BrindeOrca'] == 'N') ?
					$data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';

				$data['radio'] = array(
					'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Produtos Devolvidos', 'NS'),
				);
				($data['orcatrata']['ProntoOrca'] == 'S') ?
					$data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
				);
				($data['orcatrata']['DevolvidoOrca'] == 'S') ?
					$data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';			

				$data['radio'] = array(
					'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
				);
				($data['orcatrata']['QuitadoOrca'] == 'S') ?
					$data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
				);
				($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
					$data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
				);
				($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
					$data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Entrega_Orca' => $this->basico->radio_checked($data['orcatrata']['Entrega_Orca'], 'Entrega', 'NS'),
				);
				($data['orcatrata']['Entrega_Orca'] == 'S') ?
					$data['div']['Entrega_Orca'] = '' : $data['div']['Entrega_Orca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'UsarCashBack' => $this->basico->radio_checked($data['orcatrata']['UsarCashBack'], 'UsarCashBack', 'NS'),
				);
				($data['orcatrata']['UsarCashBack'] == 'S') ?
					$data['div']['UsarCashBack'] = '' : $data['div']['UsarCashBack'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'UsarCupom' => $this->basico->radio_checked($data['orcatrata']['UsarCupom'], 'UsarCupom', 'NS'),
				);
				($data['orcatrata']['UsarCupom'] == 'S') ?
					$data['div']['UsarCupom'] = '' : $data['div']['UsarCupom'] = 'style="display: none;"';		
					
				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';

				$data['cor_cli'] 	= 'default';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'warning';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';
				
				$data['nav_orca'] 		= 'S';
				$data['nav_status'] 	= 'S';
				$data['nav_alterar'] 	= 'N';
				
				$data['nav_imprimir'] 	= 'N';
				$data['nav_entrega'] 	= 'S';
				$data['nav_cobranca'] 	= 'S';

				$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data);
				  echo "</pre>";
				  exit ();
				*/

				$data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);		

				$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
				$data['valortotalorca'] = floatval ($data['valortotalorca']);
			
				$data['somatotal'] = floatval ($data['somatotal']);
				$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];
				
				$epsilon = 0.001;

				if(abs($data['diferenca']) < $epsilon){
					$data['diferenca'] = 0.00;
				}else{
					$data['diferenca'] = $data['diferenca'];
				}
				
				$data['diferenca'] = floatval ($data['diferenca']);		
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				#### App_OrcaTrata ####
				
				if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
					if($data['diferenca'] < 0.00){
						$data['diferenca'] = number_format($data['diferenca'],2,",",".");
						//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
						$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
					}elseif($data['diferenca'] > 0.00){
						$data['diferenca'] = number_format($data['diferenca'],2,",",".");
						//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
						$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
					}
				}
				if ($data['valortotalorca'] <= 0.00 ) {
					$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
				}		
				
				if ($_SESSION['log']['NivelEmpresa'] >= '4' ){
					//$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
					$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
				}
				$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
				$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
				$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
				//$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
				//$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');
				$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');			
				
				if($data['orcatrata']['TipoFrete'] !=1){
					if($data['orcatrata']['AVAP'] == 'O'){
						if($data['orcatrata']['FormaPagamento'] == '1' || $data['orcatrata']['FormaPagamento'] == '2' || $data['orcatrata']['FormaPagamento'] == '3'){
							$this->form_validation->set_rules('Cep', 'Cep', 'required|trim');
							$this->form_validation->set_rules('Logradouro', 'Endere�o', 'required|trim');
							$this->form_validation->set_rules('Numero', 'Numero', 'required|trim');
							$this->form_validation->set_rules('Bairro', 'Bairro', 'required|trim');
							$this->form_validation->set_rules('Cidade', 'Cidade', 'required|trim');
							$this->form_validation->set_rules('Estado', 'Estado', 'required|trim');
						}
					}
				}
					
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('orcatrata/form_orcatrataalterar2', $data);
						
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'orcatrata/alterar2/' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . $data['msg']);
						
					} else {
						
						#### Estoque_Produto_anterior####
						
							
							#### Estoque_Produto_anterior ####
							if ($_SESSION['Orcatrata']['CombinadoFrete'] == 'S') {
								
								$data['busca']['estoque']['anterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
								
								if (count($data['busca']['estoque']['anterior']) > 0) {
									
									$data['busca']['estoque']['anterior'] = array_combine(range(1, count($data['busca']['estoque']['anterior'])), array_values($data['busca']['estoque']['anterior']));
									$max_estoque = count($data['busca']['estoque']['anterior']);
									
									if (isset($data['busca']['estoque']['anterior'])){
										
										for($j=1;$j<=$max_estoque;$j++) {
											
											$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['anterior'][$j]['idTab_Produtos_Produto']);
											
											if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
												
												$qtd_produto[$j]	= ($data['busca']['estoque']['anterior'][$j]['QtdProduto'] * $data['busca']['estoque']['anterior'][$j]['QtdIncrementoProduto']);
												
												$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] + $qtd_produto[$j]);
												
												if($diff_estoque[$j] <= 0){
													$estoque[$j] = 0; 
												}else{
													$estoque[$j] = $diff_estoque[$j]; 
												}
												
												$data['alterar']['produto']['anterior'][$j]['Estoque'] = $estoque[$j];
												$data['alterar']['produto']['anterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['anterior'][$j], $data['get']['produto'][$j]['idTab_Produtos']);
												
												unset($qtd_produto[$j]);
												unset($diff_estoque[$j]);
												unset($estoque[$j]);
											}
											
										}
										
									}
									
								}
								
							}
										
						$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
						$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
						$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

						////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
						#### App_OrcaTrata ####
						if ($data['orcatrata']['Entrega_Orca'] == "S") {	
							if ($data['orcatrata']['TipoFrete'] == '1') {
								$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
								$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
								$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
								$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
								$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
								$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
								$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
								$data['orcatrata']['Referencia'] = '';
							} else {	
								$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
								$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
								$data['orcatrata']['Numero'] = trim(mb_strtoupper($numero1, 'ISO-8859-1'));
								$data['orcatrata']['Complemento'] = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));
								$data['orcatrata']['Bairro'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
								$data['orcatrata']['Cidade'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
								$data['orcatrata']['Estado'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));
								$data['orcatrata']['Referencia'] = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));
							}
						} else {
							$data['orcatrata']['Cep'] = '';
							$data['orcatrata']['Logradouro'] = '';
							$data['orcatrata']['Numero'] = '';
							$data['orcatrata']['Complemento'] = '';
							$data['orcatrata']['Bairro'] = '';
							$data['orcatrata']['Cidade'] = '';
							$data['orcatrata']['Estado'] = '';
							$data['orcatrata']['Referencia'] = '';
						}
						$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
						$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
						$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
						$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
						$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));			
						$data['orcatrata']['TipoFinanceiro'] = $data['orcatrata']['TipoFinanceiro'];
						$data['orcatrata']['Entregador'] = $data['orcatrata']['Entregador'];
						$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
						$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
						$data['orcatrata']['Descricao'] = $data['orcatrata']['Descricao'];
						//$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
						//$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
						//$data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
						//$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
						//$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
						
						if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
							$data['orcatrata']['ConcluidoOrca'] = "S";
							$data['orcatrata']['QuitadoOrca'] = "S";
						} 
						if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['FinalizadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
						} 
						if($data['orcatrata']['ConcluidoOrca'] == 'S'){
							$data['orcatrata']['CombinadoFrete'] = "S";
						} 
						if($data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
						} 
						if ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
							$data['orcatrata']['EnviadoOrca'] = "S";
						}
						
						$data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
						$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
						$data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
						//$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
						if($data['orcatrata']['FormaPagamento'] == "7"){
							$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
							$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
						}else{
							$data['orcatrata']['ValorDinheiro'] = 0.00;
							$data['orcatrata']['ValorTroco'] = 0.00;
						}
						//$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
						/*
						$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
						$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
						$data['orcatrata']['PercExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['PercExtraOrca']));
						$data['orcatrata']['DescPercOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescPercOrca']));
						$data['orcatrata']['DescValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescValorOrca']));
						*/
						
						if(!$data['orcatrata']['ValorFrete']){
							$data['orcatrata']['ValorFrete'] = 0;
						}else{
							$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
						}
						
						if(!$data['orcatrata']['ValorExtraOrca']){
							$data['orcatrata']['ValorExtraOrca'] = 0;
						}else{
							$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
						}			
									
						if(!$data['orcatrata']['PercExtraOrca']){
							$data['orcatrata']['PercExtraOrca'] = 0;
						}else{
							$data['orcatrata']['PercExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['PercExtraOrca']));
						}			

						if(!$data['orcatrata']['DescPercOrca']){
							$data['orcatrata']['DescPercOrca'] = 0;
						}else{
							$data['orcatrata']['DescPercOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescPercOrca']));
						}			
						
						if(!$data['orcatrata']['DescValorOrca']){
							$data['orcatrata']['DescValorOrca'] = 0;
						}else{
							$data['orcatrata']['DescValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescValorOrca']));
						}
						
						$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
						$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'mysql');
						if(isset($data['orcatrata']['ValidadeCashBackOrca']) && $data['orcatrata']['ValidadeCashBackOrca'] != "0000-00-00" && $data['orcatrata']['ValidadeCashBackOrca'] != ""){
							$data['orcatrata']['ValidadeCashBackOrca'] = $data['orcatrata']['ValidadeCashBackOrca'];
						}else{
							$data['orcatrata']['ValidadeCashBackOrca'] = "0000-00-00";
						}
						
						$data['orcatrata']['ValorFinalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
						
						$data['orcatrata']['SubValorFinal'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['SubValorFinal']));
						$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
						$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
						$data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
						
						#$data['orcatrata']['idTab_TipoRD'] = $data['orcatrata']['idTab_TipoRD'];
						#$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
						#$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						#$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

						if($data['orcatrata']['Entrega_Orca'] == "N"){
							$data['orcatrata']['DataEntregaOrca'] = $data['orcatrata']['DataOrca'];
							$data['orcatrata']['HoraEntregaOrca'] = "00:00:00";
							$data['orcatrata']['PrazoProdServ'] = 0;
							$data['orcatrata']['PrazoCorreios'] = 0;
							$data['orcatrata']['PrazoEntrega'] = 0;
						}
						
						if (!$data['orcatrata']['PrazoEntrega']){
							//$data1 = date('Y-m-d', time());
							$data1 = $data['orcatrata']['DataOrca'];
							$data2 = $data['orcatrata']['DataEntregaOrca'];
							$intervalo = strtotime($data2)-strtotime($data1); 
							$dias = floor($intervalo / (60 * 60 * 24));
							$data['orcatrata']['PrazoEntrega'] = $dias;
						}
			
						$data['orcatrata']['ValorFatura'] = $data['orcatrata']['ValorFinalOrca'];
						
						if($data['orcatrata']['AVAP'] == "O" && ($data['orcatrata']['FormaPagamento'] == "1" || $data['orcatrata']['FormaPagamento'] == "2" || $data['orcatrata']['FormaPagamento'] == "3")){
							$data['orcatrata']['ValorGateway'] = ($data['orcatrata']['ValorFatura'] * 0.04) + 0.40;
						}else{
							$data['orcatrata']['ValorGateway'] = 0.00;
						}
						$data['orcatrata']['ValorEmpresa'] = $data['orcatrata']['ValorFatura'] - $data['orcatrata']['ValorComissao'] - $data['orcatrata']['ValorGateway'];
						
						if($_SESSION['Orcatrata']['UsarCupom'] == "N"){
							if($data['orcatrata']['UsarCupom'] == "S"){
								$data['orcatrata']['TipoDescOrca'] = $data['cadastrar']['UsarE'];
								if($data['cadastrar']['ValidaCupom'] == 0 || !$data['orcatrata']['Cupom'] || empty($data['orcatrata']['Cupom'])){
									$data['orcatrata']['Cupom'] = 0;
								}
							}else{
								$data['orcatrata']['Cupom'] = 0;
							}
						}	

						/*
						$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$data['orcatrata']['idApp_OrcaTrata'], TRUE);
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);
						*/
						
						/*
						//echo count($data['servico']);
						echo '<br>';
						echo "<pre>";
						print_r($data['orcatrata']['idApp_Cliente']);
						echo "</pre>";
						exit ();
						   */
						if($_SESSION['log']['idSis_Empresa'] != 5){
							   
							#### APP_Cliente ####
							if ($data['cadastrar']['AtualizaEndereco'] == 'S' && $data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['Entrega_Orca'] == "S" && $data['orcatrata']['idApp_Cliente'] != 0 && $data['orcatrata']['idApp_Cliente'] != 1 && $data['orcatrata']['idApp_Cliente'] != 150001){
								$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
								$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
								$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
								$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
								$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
								$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
								$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
								$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
								if ($data['orcatrata']['idApp_Cliente'] != 0 || $data['orcatrata']['idApp_Cliente'] != ''){			
									$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
									$data['update']['cliente']['campos'] = array_keys($data['cliente']);
									/*
									$data['update']['cliente']['auditoriaitem'] = $this->basico->set_log(
										$data['update']['cliente']['anterior'],
										$data['cliente'],
										$data['update']['cliente']['campos'],
										$data['cliente']['idApp_Cliente'], TRUE);
									*/	
									$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);
								}	
								/*
								// ""ver modo correto de fazer o set_log e set_auditoria""
								if ($data['auditoriaitem'] === FALSE) {
									$data['msg'] = '';
								} else {
									$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
									$data['msg'] = '?m=1';
								}
								*/
								
							}
						}
						/*
						//echo count($data['servico']);
						echo '<br>';
						echo "<pre>";
						print_r($data['cliente']);
						echo "</pre>";
						exit ();
						*/			
						
						
						#### App_Servico ####
						$data['update']['servico']['anterior'] = $this->Orcatrata_model->get_servico($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

							if (isset($data['servico']))
								$data['servico'] = array_values($data['servico']);
							else
								$data['servico'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_Produto');

							$max = count($data['update']['servico']['inserir']);
							for($j=0;$j<$max;$j++) {
								
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_1']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_1'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_2']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_2'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_3']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_3'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_4']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_4'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_5']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_5'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_6']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_6'] = 0;
								}					

								$data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['Orcatrata']['idSis_Usuario'];
								$data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['servico']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['servico']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
								$data['update']['servico']['inserir'][$j]['idTab_TipoRD'] = "2";
								$data['update']['servico']['inserir'][$j]['NivelProduto'] = $_SESSION['Orcatrata']['NivelOrca'];

								if(empty($data['update']['servico']['inserir'][$j]['ValorProduto'])){
									$data['update']['servico']['inserir'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorProduto']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_1'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_1'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_1']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_2'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_2'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_2']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_3'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_3'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_3']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_4'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_4'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_4']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_5'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_5'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_5']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_6'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_6'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_6']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComissaoServico'])){
									$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComissaoServico']));
								}
								
								$data['update']['servico']['inserir'][$j]['ValorComissaoVenda'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto'];
								
								//$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoServicoProduto'];
								$data['update']['servico']['inserir'][$j]['ValorComissaoAssociado'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoServicoProduto'];

								$data['update']['servico']['inserir'][$j]['ValorComissaoFuncionario'] = $data['update']['servico']['inserir'][$j]['QtdProduto']*$data['update']['servico']['inserir'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;
								
								$data['update']['servico']['inserir'][$j]['ValorComissaoCashBack'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoCashBackProduto'];
						
								if(!$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] || $data['update']['servico']['inserir'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['servico']['inserir'][$j]['DataValidadeProduto'])){
									$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataValidadeProduto'], 'mysql');
								}
																		
								if(!$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] || $data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['servico']['inserir'][$j]['DataConcluidoProduto'])){
									$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] || $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'];
								}
													
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['ConcluidoProduto'];
								}
								
								unset($data['update']['servico']['inserir'][$j]['SubtotalProduto']);
								unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto']);
								unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoServicoProduto']);
								unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['servico']['inserir'][$j]['SubtotalQtdProduto']);
							}

							$max = count($data['update']['servico']['alterar']);
							for($j=0;$j<$max;$j++) {
								
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_1']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_1'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_2']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_2'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_3']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_3'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_4']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_4'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_5']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_5'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_6']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_6'] = 0;
								}
								
								$data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'];
								$data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'];

								if(empty($data['update']['servico']['alterar'][$j]['ValorProduto'])){
									$data['update']['servico']['alterar'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorProduto']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_1'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_1'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_1']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_2'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_2'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_2']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_3'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_3'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_3']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_4'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_4'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_4']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_5'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_5'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_5']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_6'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_6'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_6']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComissaoServico'])){
									$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComissaoServico']));
								}
								
								$data['update']['servico']['alterar'][$j]['ValorComissaoVenda'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto'];
								
								//$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoServicoProduto'];
								$data['update']['servico']['alterar'][$j]['ValorComissaoAssociado'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoServicoProduto'];

								$data['update']['servico']['alterar'][$j]['ValorComissaoFuncionario'] = $data['update']['servico']['alterar'][$j]['QtdProduto']*$data['update']['servico']['alterar'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;
								
								$data['update']['servico']['alterar'][$j]['ValorComissaoCashBack'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoCashBackProduto'];
								
								if(!$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] || $data['update']['servico']['alterar'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['servico']['alterar'][$j]['DataValidadeProduto'])){
									$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeProduto'], 'mysql');
								}
																		
								if(!$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] || $data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['servico']['alterar'][$j]['DataConcluidoProduto'])){
									$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] || $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'];
								}					
													
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['ConcluidoProduto'];
								}
								
								if ($data['orcatrata']['idApp_Cliente']) $data['update']['servico']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					

								unset($data['update']['servico']['alterar'][$j]['SubtotalProduto']);
								unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto']);
								unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoServicoProduto']);
								unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['servico']['alterar'][$j]['SubtotalQtdProduto']);
							}

							if (count($data['update']['servico']['inserir']))
								$data['update']['servico']['bd']['inserir'] = $this->Orcatrata_model->set_servico($data['update']['servico']['inserir']);

							if (count($data['update']['servico']['alterar']))
								$data['update']['servico']['bd']['alterar'] = $this->Orcatrata_model->update_servico($data['update']['servico']['alterar']);

							if (count($data['update']['servico']['excluir']))
								$data['update']['servico']['bd']['excluir'] = $this->Orcatrata_model->delete_servico($data['update']['servico']['excluir']);
						}

						#### App_Produto ####
						$data['update']['produto']['anterior'] = $this->Orcatrata_model->get_produto($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

							if (isset($data['produto']))
								$data['produto'] = array_values($data['produto']);
							else
								$data['produto'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_Produto');

							$max = count($data['update']['produto']['inserir']);
							for($j=0;$j<$max;$j++) {
							
								$data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['Orcatrata']['idSis_Usuario'];
								$data['update']['produto']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['produto']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['produto']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
								$data['update']['produto']['inserir'][$j]['idTab_TipoRD'] = "2";
								$data['update']['produto']['inserir'][$j]['NivelProduto'] = $_SESSION['Orcatrata']['NivelOrca'];

								if(empty($data['update']['produto']['inserir'][$j]['ValorProduto'])){
									$data['update']['produto']['inserir'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));					
								}

								$data['update']['produto']['inserir'][$j]['ValorComissaoVenda'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto'];
								
								//$data['update']['produto']['inserir'][$j]['ValorComissaoServico'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoServicoProduto'];
								$data['update']['produto']['inserir'][$j]['ValorComissaoAssociado'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoServicoProduto'];

								$data['update']['produto']['inserir'][$j]['ValorComissaoFuncionario'] = $data['update']['produto']['inserir'][$j]['QtdProduto']*$data['update']['produto']['inserir'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;
								
								$data['update']['produto']['inserir'][$j]['ValorComissaoCashBack'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoCashBackProduto'];

								if(!$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] || $data['update']['produto']['inserir'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['produto']['inserir'][$j]['DataValidadeProduto'])){
									$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
								}
													
								if(!$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] || $data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['produto']['inserir'][$j]['DataConcluidoProduto'])){
									$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] || $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'];
								}
													
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
								}

								if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
									$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
								} else {
									$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = $data['update']['produto']['inserir'][$j]['DevolvidoProduto'];
								}
								
								unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
								unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
								unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoServicoProduto']);
								unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);                
							}

							$max = count($data['update']['produto']['alterar']);
							for($j=0;$j<$max;$j++) {
							
								//$data['update']['produto']['alterar'][$j]['ProfissionalProduto_1'] = $data['update']['produto']['alterar'][$j]['ProfissionalProduto_1'];
								$data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
								$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
								$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];

								if(empty($data['update']['produto']['alterar'][$j]['ValorProduto'])){
									$data['update']['produto']['alterar'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
								}
								
								$data['update']['produto']['alterar'][$j]['ValorComissaoVenda'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto'];
								
								//$data['update']['produto']['alterar'][$j]['ValorComissaoServico'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoServicoProduto'];
								$data['update']['produto']['alterar'][$j]['ValorComissaoAssociado'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoServicoProduto'];

								$data['update']['produto']['alterar'][$j]['ValorComissaoFuncionario'] = $data['update']['produto']['alterar'][$j]['QtdProduto']*$data['update']['produto']['alterar'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;
								
								$data['update']['produto']['alterar'][$j]['ValorComissaoCashBack'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoCashBackProduto'];

								if(!$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] || $data['update']['produto']['alterar'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['produto']['alterar'][$j]['DataValidadeProduto'])){
									$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
								}
													
								if(!$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['produto']['alterar'][$j]['DataConcluidoProduto'])){
									$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'];
								}
													
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['ConcluidoProduto'];
								}
								
								if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
									$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'S';
								} else {	
									$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = $data['update']['produto']['alterar'][$j]['DevolvidoProduto'];
								}
								
								if ($data['orcatrata']['idApp_Cliente']) $data['update']['produto']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					

								unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
								unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
								unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoServicoProduto']);
								unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);                
							}

							if (count($data['update']['produto']['inserir']))
								$data['update']['produto']['bd']['inserir'] = $this->Orcatrata_model->set_produto($data['update']['produto']['inserir']);

							if (count($data['update']['produto']['alterar']))
								$data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

							if (count($data['update']['produto']['excluir']))
								$data['update']['produto']['bd']['excluir'] = $this->Orcatrata_model->delete_produto($data['update']['produto']['excluir']);

						}

						#### App_ParcelasRec ####
						$data['update']['parcelasrec']['anterior'] = $this->Orcatrata_model->get_parcelas($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

							if (isset($data['parcelasrec']))
								$data['parcelasrec'] = array_values($data['parcelasrec']);
							else
								$data['parcelasrec'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

							$max = count($data['update']['parcelasrec']['inserir']);
							for($j=0;$j<$max;$j++) {
								$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								/*
								if ($data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario']){
									$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'];
								}else{
									$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								}
								*/
								$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['parcelasrec']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
								$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "2";
								$data['update']['parcelasrec']['inserir'][$j]['NivelParcela'] = $_SESSION['Orcatrata']['NivelOrca'];
								
								$data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
								$data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
								//$data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
								$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
								if($data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela']){
									$data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'] = $data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'];
								}else{
									$data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
								}
								if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
									$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
								} else {
									$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
								}
								if ($data['update']['parcelasrec']['inserir'][$j]['Quitado'] == 'S'){
									if(!$data['update']['parcelasrec']['inserir'][$j]['DataPago']){
										$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'];
									}else{
										$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $data['update']['parcelasrec']['inserir'][$j]['DataPago'];
									}
									$data['update']['parcelasrec']['inserir'][$j]['DataLanc'] = date('Y-m-d', time());
								} else {
									$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = "0000-00-00";
									$data['update']['parcelasrec']['inserir'][$j]['DataLanc'] = "0000-00-00";
								}
								
							}	

							$max = count($data['update']['parcelasrec']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
								$data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
								//$data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
								$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
								$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataLanc'], 'mysql');
								if($data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela']){
									$data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'] = $data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'];
								}else{
									$data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
								}
								if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
									$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
								} else {
									$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = $data['update']['parcelasrec']['alterar'][$j]['Quitado'];
								}
								if ($data['update']['parcelasrec']['alterar'][$j]['Quitado'] == 'S'){
									if(!$data['update']['parcelasrec']['alterar'][$j]['DataPago']){
										$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'];
									}else{
										$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataPago'];
									}
									if(!$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] || empty($data['update']['parcelasrec']['alterar'][$j]['DataLanc']) || $data['update']['parcelasrec']['alterar'][$j]['DataPago'] == "0000-00-00"){
										$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = date('Y-m-d', time());
									}
								} else {
									$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = "0000-00-00";
									$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = "0000-00-00";
								}
								if ($data['orcatrata']['idApp_Cliente']) $data['update']['parcelasrec']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
							}

							if (count($data['update']['parcelasrec']['inserir']))
								$data['update']['parcelasrec']['bd']['inserir'] = $this->Orcatrata_model->set_parcelas($data['update']['parcelasrec']['inserir']);

							if (count($data['update']['parcelasrec']['alterar']))
								$data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

							if (count($data['update']['parcelasrec']['excluir']))
								$data['update']['parcelasrec']['bd']['excluir'] = $this->Orcatrata_model->delete_parcelas($data['update']['parcelasrec']['excluir']);

						}
						
						#### App_Procedimento ####
						$data['update']['procedimento']['anterior'] = $this->Orcatrata_model->get_procedimento($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

							if (isset($data['procedimento']))
								$data['procedimento'] = array_values($data['procedimento']);
							else
								$data['procedimento'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_Procedimento');

							$max = count($data['update']['procedimento']['inserir']);
							for($j=0;$j<$max;$j++) {
								$data['update']['procedimento']['inserir'][$j]['TipoProcedimento'] = 2;
								$data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['update']['procedimento']['inserir'][$j]['NivelProcedimento'] = $_SESSION['Orcatrata']['NivelOrca'];
								if(!$data['update']['procedimento']['inserir'][$j]['Compartilhar']){
									$data['update']['procedimento']['inserir'][$j]['Compartilhar'] = $_SESSION['log']['idSis_Usuario'];	
								}
								$data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['procedimento']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['procedimento']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
								$data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');
								
								if(!$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento']){
									$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
								}else{
									$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'], 'mysql');
								}
							
							}

							$max = count($data['update']['procedimento']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');
								
								if(!$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento']){
									$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
								}else{                  
									$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'], 'mysql');
								}
													
								if ($data['orcatrata']['idApp_Cliente']) $data['update']['procedimento']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
							}

							if (count($data['update']['procedimento']['inserir']))
								$data['update']['procedimento']['bd']['inserir'] = $this->Orcatrata_model->set_procedimento($data['update']['procedimento']['inserir']);

							if (count($data['update']['procedimento']['alterar']))
								$data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

							if (count($data['update']['procedimento']['excluir']))
								$data['update']['procedimento']['bd']['excluir'] = $this->Orcatrata_model->delete_procedimento($data['update']['procedimento']['excluir']);

						}
							
						#### Recalcaula as Comiss�es ####
						$data['orcatrata']['ValorComissaoFunc'] = 0;
						$data['orcatrata']['ValorComissaoAssoc'] = 0;
						$data['update']['produto']['atual'] = $this->Orcatrata_model->get_produto_comissao_atual($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['atual'])){
							$max_produto = count($data['update']['produto']['atual']);
							if($max_produto > 0){
								for($j=0;$j<$max_produto;$j++) {
									$data['orcatrata']['ValorComissaoFunc'] += $data['update']['produto']['atual'][$j]['ValorComissaoFuncionario'];
									$data['orcatrata']['ValorComissaoAssoc'] += $data['update']['produto']['atual'][$j]['ValorComissaoAssociado'];
								}
							}
						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_contagem($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto > 0){
								$data['orcatrata']['Prd_Srv_Orca'] = "S";
							}
						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto == 0){
								$data['orcatrata']['CombinadoFrete'] = "S";
								#$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
								$data['orcatrata']['ConcluidoOrca'] = "S";
							}else{
								$data['orcatrata']['ConcluidoOrca'] = "N";
							}
						}
						
						$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['parcelasrec']['posterior'])){
							$max_parcela = count($data['update']['parcelasrec']['posterior']);
							if($max_parcela == 0){
								#$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['QuitadoOrca'] = "S";				
							}else{
								$data['orcatrata']['QuitadoOrca'] = "N";
							}
						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto > 0){
								$data['orcatrata']['CombinadoFrete'] = "S";
								#$data['orcatrata']['AprovadoOrca'] = "S";
							}
						}			

						$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);	
						if (isset($data['update']['parcelasrec']['posterior'])){
							$max_parcela = count($data['update']['parcelasrec']['posterior']);
							if($max_parcela > 0){
								#$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['AprovadoOrca'] = "S";				
							}

						}

						if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['FinalizadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
						}else{
							$data['orcatrata']['FinalizadoOrca'] = "N";
						}
						
						$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$data['orcatrata']['idApp_OrcaTrata'], TRUE);
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);			
						
						#### Estoque_Produto_posterior####
						
										
							#### Estoque_Produto_posterior ####
							if ($data['orcatrata']['CombinadoFrete'] == 'S' && $data['orcatrata']['CanceladoOrca'] == 'N') {
								
								$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
								
								if (count($data['busca']['estoque']['posterior']) > 0) {
									
									$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
									$max_estoque = count($data['busca']['estoque']['posterior']);
									
									if (isset($data['busca']['estoque']['posterior'])){
										
										for($j=1;$j<=$max_estoque;$j++) {
											
											$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
											
											if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
												
												$qtd_produto[$j]	= ($data['busca']['estoque']['posterior'][$j]['QtdProduto'] * $data['busca']['estoque']['posterior'][$j]['QtdIncrementoProduto']);
												
												$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] - $qtd_produto[$j]);
												
												if($diff_estoque[$j] <= 0){
													$estoque[$j] = 0; 
												}else{
													$estoque[$j] = $diff_estoque[$j]; 
												}
												
												$data['alterar']['produto']['posterior'][$j]['Estoque'] = $estoque[$j];
												$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$j], $data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
												
												unset($qtd_produto[$j]);
												unset($diff_estoque[$j]);
												unset($estoque[$j]);
											}
											
										}
										
									}
									
								}
								
							}
						
						/*
						/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
									$data['campos'] = array_keys($data['query']);
									$data['anterior'] = array();
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
						//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
						*/

						//if ($data['idApp_OrcaTrata'] === FALSE) {
						//if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
						if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('orcatrata/form_orcatrataalterar2', $data);
						} else {

							//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
							//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';

							//redirect(base_url() . 'relatorio/orcamento/' . $data['msg']);
							#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
							#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
							redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
							exit();
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function alterarstatus($id = FALSE) {

		$acesso = FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$acesso = TRUE;
		}else{
			if($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Usuario']['Nivel'] != 2 && $_SESSION['Usuario']['Usu_Rec'] == "S" && $_SESSION['Usuario']['Edit_Orcam'] == "S"){
				$acesso = TRUE;
			}	
		}
		
		if($acesso === FALSE){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{
			
			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 3)
				$data['msg'] = $this->basico->msg('<strong>N�o � poss�vel salvar as altera��es.<br>N�o identificamos o pagamento da sua �ltima Fatura.<br>Por favor, Entre em contato com a administra��o da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
			else
				$data['msg'] = '';
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'ConcluidoProduto',
				'QuitadoParcelas',
				'Cadastrar',
				'Whatsapp',
				'Whatsapp_Site',
				'AtualizaEndereco',
				'StatusProdutos',
				'StatusParcelas',
				'Valor_S_Desc',
				'Valor_C_Desc',
				'UsarC',
				'UsarD',
				'UsarE',
				'ValidaCupom',
				'MensagemCupom',
				'CodigoCupom',
			), TRUE));

			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['orcatrata'] = quotes_to_entities($this->input->post(array(
				#### App_OrcaTrata ####
				'idApp_OrcaTrata',
				#N�o h� a necessidade de atualizar o valor do campo a seguir
				'idApp_Cliente',
				//'idApp_ClientePet',
				//'idApp_ClienteDep',
				'DataOrca',
				'TipoFinanceiro',
				'Descricao',
				'AprovadoOrca',
				'ConcluidoOrca',
				'DevolvidoOrca',
				'ProntoOrca',
				'QuitadoOrca',
				'FinalizadoOrca',
				'ValorOrca',
				'ValorComissao',
				'QtdPrdOrca',
				'QtdSrvOrca',
				'PrazoProdutos',
				'PrazoServicos',
				'PrazoProdServ',
				'PrazoCorreios',
				'ValorDev',
				'ValorDinheiro',
				'ValorTroco',
				'ValorRestanteOrca',
				'FormaPagamento',
				//'QtdParcelasOrca',
				//'DataVencimentoOrca',
				'ObsOrca',
				'Consideracoes',
				'Modalidade',
				#'idTab_TipoRD',
				'AVAP',
				'Tipo_Orca',
				'EnviadoOrca',
				'Cep',
				'Logradouro',
				'Numero',
				'Complemento',
				'Bairro',
				'Cidade',
				'Estado',
				'Referencia',
				'CombinadoFrete',
				'TipoFrete',
				'ValorFrete',
				'ValorExtraOrca',
				'PercExtraOrca',
				'ValorSomaOrca',
				'PrazoEntrega',
				'ValorTotalOrca',
				'Entregador',
				'DataEntregaOrca',
				'HoraEntregaOrca',
				'NomeRec',
				'TelefoneRec',
				'ParentescoRec',
				'ObsEntrega',
				'Aux1Entrega',
				'Aux2Entrega',
				'DetalhadaEntrega',
				'CanceladoOrca',
				'Cli_Forn_Orca',
				'Prd_Srv_Orca',
				'Entrega_Orca',
				//'TipoDescOrca',
				//'TipoExtraOrca',
				'DescPercOrca',
				'DescValorOrca',
				'CashBackOrca',
				'ValidadeCashBackOrca',
				//'UsarCashBack',
				//'UsarCupom',
				//'Cupom',
				'SubValorFinal',
				'ValorFinalOrca',
			), TRUE));
			
			$data['cliente'] = $this->input->post(array(
				'idApp_Cliente',
				'CepCliente',
				'EnderecoCliente',
				'NumeroCliente',
				'ComplementoCliente',
				'CidadeCliente',
				'BairroCliente',
				'MunicipioCliente',
				'EstadoCliente',
				'ReferenciaCliente',
			), TRUE);

			$caracteres_sem_acento = array(
				'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
				'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
				'�'=>'I', '�'=>'N', 'N'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
				'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
				'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
				'�'=>'i', '�'=>'o', '�'=>'n', 'n'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
				'�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f',
				'a'=>'a', '�'=>'i', '�'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', '�'=>'I', '�'=>'A', '?'=>'S', '?'=>'T',
			);

			$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Logradouro'], $caracteres_sem_acento));

			$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['orcatrata']['Cep'], $caracteres_sem_acento));

			$numero1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Numero'], $caracteres_sem_acento));

			$complemento1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Complemento'], $caracteres_sem_acento));

			$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Bairro'], $caracteres_sem_acento));

			$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Cidade'], $caracteres_sem_acento));

			$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Estado'], $caracteres_sem_acento));

			$referencia1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Referencia'], $caracteres_sem_acento));
			
			//D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
			//comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

			(isset($_SESSION['Usuario']['Bx_Pag']) && $_SESSION['Usuario']['Bx_Pag'] == "S") ? $data['div']['Prof_comissao'] = '' : $data['div']['Prof_comissao'] = 'style="display: none;"';		
			
			(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
			(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
			(!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
			(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
			
			#(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
			(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '0' : FALSE;
			(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
			(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;
			(!$data['orcatrata']['Entrega_Orca']) ? $data['orcatrata']['Entrega_Orca'] = 'S' : FALSE;
			(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['ValidadeCashBackOrca']) ? $data['orcatrata']['ValidadeCashBackOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
			//(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
			(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
			(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
			(!$data['orcatrata']['Entregador']) ? $data['orcatrata']['Entregador'] = '0' : FALSE;
			//(!$data['orcatrata']['idApp_ClientePet']) ? $data['orcatrata']['idApp_ClientePet'] = '0' : FALSE;
			//(!$data['orcatrata']['idApp_ClienteDep']) ? $data['orcatrata']['idApp_ClienteDep'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoProdServ']) ? $data['orcatrata']['PrazoProdServ'] = '0' : FALSE;
			(!$data['orcatrata']['ValorOrca']) ? $data['orcatrata']['ValorOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorDev']) ? $data['orcatrata']['ValorDev'] = '0.00' : FALSE;
			(!$data['orcatrata']['QtdPrdOrca']) ? $data['orcatrata']['QtdPrdOrca'] = '0' : FALSE;
			(!$data['orcatrata']['QtdSrvOrca']) ? $data['orcatrata']['QtdSrvOrca'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoProdutos']) ? $data['orcatrata']['PrazoProdutos'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoServicos']) ? $data['orcatrata']['PrazoServicos'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoCorreios']) ? $data['orcatrata']['PrazoCorreios'] = '0' : FALSE;
			if($_SESSION['log']['idSis_Empresa'] == 5){
				(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'S' : FALSE;
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'S' : FALSE;			
			}else{
				(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;		
			}
			(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
			//(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;	
			(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
			
			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
			(!$data['cadastrar']['Whatsapp']) ? $data['cadastrar']['Whatsapp'] = 'N' : FALSE;
			(!$data['cadastrar']['Whatsapp_Site']) ? $data['cadastrar']['Whatsapp_Site'] = 'N' : FALSE;       
			(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusProdutos']) ? $data['cadastrar']['StatusProdutos'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusParcelas']) ? $data['cadastrar']['StatusParcelas'] = 'N' : FALSE;
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['SCount']; $i++) {

				if ($this->input->post('idTab_Servico' . $i)) {
					$data['servico'][$j]['idApp_Produto'] = $this->input->post('idApp_Servico' . $i);
					$data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
					$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
					$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
					$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
					$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
					$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
					$data['servico'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoServico' . $i);
					$data['servico'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackServico' . $i);
					$data['servico'][$j]['PrazoProduto'] = $this->input->post('PrazoServico' . $i);
					$data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
					$data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
					$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
					$data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
					$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
					$data['servico'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoServico' . $i);
					$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackServico' . $i);
					$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
					$data['servico'][$j]['ValorComissaoServico'] = $this->input->post('ValorComissaoServico' . $i);
					$data['servico'][$j]['ObsProduto'] = $this->input->post('ObsServico' . $i);
					$data['servico'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeServico' . $i);
					$data['servico'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoServico' . $i);
					$data['servico'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoServico' . $i);
					$data['servico'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoServico' . $i);
					
					$data['servico'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalServico_1' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
					}				
					$data['servico'][$j]['ProfissionalProduto_2'] = $this->input->post('ProfissionalServico_2' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_3'] = $this->input->post('ProfissionalServico_3' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_4'] = $this->input->post('ProfissionalServico_4' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_5'] = $this->input->post('ProfissionalServico_5' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_6'] = $this->input->post('ProfissionalServico_6' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
					}
									
					$data['servico'][$j]['idTFProf_1'] = $this->input->post('idTFProf_Servico_1' . $i);
					$data['servico'][$j]['ComFunProf_1'] = $this->input->post('ComFunProf_Servico_1' . $i);
					$data['servico'][$j]['ValorComProf_1'] = $this->input->post('ValorComProf_Servico_1' . $i);
					
					$data['servico'][$j]['idTFProf_2'] = $this->input->post('idTFProf_Servico_2' . $i);
					$data['servico'][$j]['ComFunProf_2'] = $this->input->post('ComFunProf_Servico_2' . $i);
					$data['servico'][$j]['ValorComProf_2'] = $this->input->post('ValorComProf_Servico_2' . $i);
					
					$data['servico'][$j]['idTFProf_3'] = $this->input->post('idTFProf_Servico_3' . $i);
					$data['servico'][$j]['ComFunProf_3'] = $this->input->post('ComFunProf_Servico_3' . $i);
					$data['servico'][$j]['ValorComProf_3'] = $this->input->post('ValorComProf_Servico_3' . $i);
					
					$data['servico'][$j]['idTFProf_4'] = $this->input->post('idTFProf_Servico_4' . $i);
					$data['servico'][$j]['ComFunProf_4'] = $this->input->post('ComFunProf_Servico_4' . $i);
					$data['servico'][$j]['ValorComProf_4'] = $this->input->post('ValorComProf_Servico_4' . $i);
					
					$data['servico'][$j]['idTFProf_5'] = $this->input->post('idTFProf_Servico_5' . $i);
					$data['servico'][$j]['ComFunProf_5'] = $this->input->post('ComFunProf_Servico_5' . $i);
					$data['servico'][$j]['ValorComProf_5'] = $this->input->post('ValorComProf_Servico_5' . $i);
					
					$data['servico'][$j]['idTFProf_6'] = $this->input->post('idTFProf_Servico_6' . $i);
					$data['servico'][$j]['ComFunProf_6'] = $this->input->post('ComFunProf_Servico_6' . $i);
					$data['servico'][$j]['ValorComProf_6'] = $this->input->post('ValorComProf_Servico_6' . $i);
					
					(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
					);
					($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';
					
					$data['select'][$j]['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_1']);
					$data['select'][$j]['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_2']);
					$data['select'][$j]['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_3']);
					$data['select'][$j]['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_4']);
					$data['select'][$j]['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_5']);
					$data['select'][$j]['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_6']);
					
					$j++;
				}

			}
			$data['count']['SCount'] = $j - 1;		

			$j = 1;
			for ($i = 1; $i <= $data['count']['PCount']; $i++) {

				if ($this->input->post('idTab_Produto' . $i)) {
					$data['produto'][$j]['idApp_Produto'] = $this->input->post('idApp_Produto' . $i);
					$data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
					$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
					$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
					$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
					$data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
					$data['produto'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoProduto' . $i);
					$data['produto'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackProduto' . $i);
					$data['produto'][$j]['PrazoProduto'] = $this->input->post('PrazoProduto' . $i);
					$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
					$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
					$data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
					$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
					$data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoProduto' . $i);
					$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackProduto' . $i);
					$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
					$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
					$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
					$data['produto'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoProduto' . $i);
					$data['produto'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoProduto' . $i);
					$data['produto'][$j]['Aux_App_Produto_1'] = $this->input->post('Aux_App_Produto_1' . $i);
					$data['produto'][$j]['Aux_App_Produto_2'] = $this->input->post('Aux_App_Produto_2' . $i);
					$data['produto'][$j]['Aux_App_Produto_3'] = $this->input->post('Aux_App_Produto_3' . $i);
					$data['produto'][$j]['Aux_App_Produto_4'] = $this->input->post('Aux_App_Produto_4' . $i);
					$data['produto'][$j]['Aux_App_Produto_5'] = $this->input->post('Aux_App_Produto_5' . $i);
					$data['produto'][$j]['HoraValidadeProduto'] = $this->input->post('HoraValidadeProduto' . $i);
					$data['produto'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoProduto' . $i);
					$data['produto'][$j]['DevolvidoProduto'] = $this->input->post('DevolvidoProduto' . $i);
					$data['produto'][$j]['CanceladoProduto'] = $this->input->post('CanceladoProduto' . $i);
					//$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					//$data['produto'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalProduto_1' . $i);
					
					(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
					);
					($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';
					
					$j++;
				}
			}
			$data['count']['PCount'] = $j - 1;

			$j = 1;
			for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

				if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataConcluidoProcedimento' . $i) ||
					$this->input->post('Profissional' . $i) || $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
					$data['procedimento'][$j]['idApp_Procedimento'] = $this->input->post('idApp_Procedimento' . $i);
					$data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
					$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->input->post('DataConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['HoraProcedimento'] = $this->input->post('HoraProcedimento' . $i);
					$data['procedimento'][$j]['HoraConcluidoProcedimento'] = $this->input->post('HoraConcluidoProcedimento' . $i);				
					#$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
					//$data['procedimento'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
					$data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
					$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					$data['procedimento'][$j]['Compartilhar'] = $this->input->post('Compartilhar' . $i);
					
					(!$data['procedimento'][$j]['ConcluidoProcedimento']) ? $data['procedimento'][$j]['ConcluidoProcedimento'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
					);
					($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';	
					
					$data['select'][$j]['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos($data['procedimento'][$j]['Compartilhar']);
					
					$j++;
				}

			}
			$data['count']['PMCount'] = $j - 1;

			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {
				
				if ($this->input->post('ValorParcela' . $i) > 0 && $this->input->post('ValorParcela' . $i) != '') {
					$data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
					$data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					//$data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$j]['DataLanc'] = $this->input->post('DataLanc' . $i);
					$data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
					$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
					//$data['parcelasrec'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					
					(!$data['parcelasrec'][$j]['Quitado']) ? $data['parcelasrec'][$j]['Quitado'] = 'N' : FALSE;
					$data['radio'] = array(
						'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
					);
					($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';				

					$j++;
				}
			}
			$data['count']['PRCount'] = $j - 1;

			//Fim do trecho de c�digo que d� pra melhorar

			if ($id) {
				#### App_OrcaTrata ####
				$_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
			
				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 2){
					
					unset($_SESSION['Orcatrata']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {			

					$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
					$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'barras');
					$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'barras');
					$data['orcatrata']['Descricao'] = $data['orcatrata']['Descricao'];

					#### App_Servico ####
					$data['servico'] = $this->Orcatrata_model->get_servico($id);
					if (count($data['servico']) > 0) {
						$data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
						$data['count']['SCount'] = count($data['servico']);

						if (isset($data['servico'])) {

							for($j=1;$j<=$data['count']['SCount'];$j++) {
								$data['servico'][$j]['SubtotalProduto'] = number_format(($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto']), 2, ',', '.');
								$data['servico'][$j]['SubtotalComissaoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoProduto'] /100);
								$data['servico'][$j]['SubtotalComissaoServicoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoServicoProduto'] /100);
								$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoCashBackProduto'] /100);
								$data['servico'][$j]['SubtotalQtdProduto'] = ($data['servico'][$j]['QtdIncrementoProduto'] * $data['servico'][$j]['QtdProduto']);
								$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'barras');
								$data['servico'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataConcluidoProduto'], 'barras');
								$data['servico'][$j]['ValorComissaoServico'] = number_format(($data['servico'][$j]['ValorComissaoServico']), 2, ',', '.');

								$data['servico'][$j]['ValorComProf_1'] = number_format(($data['servico'][$j]['ValorComProf_1']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_2'] = number_format(($data['servico'][$j]['ValorComProf_2']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_3'] = number_format(($data['servico'][$j]['ValorComProf_3']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_4'] = number_format(($data['servico'][$j]['ValorComProf_4']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_5'] = number_format(($data['servico'][$j]['ValorComProf_5']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_6'] = number_format(($data['servico'][$j]['ValorComProf_6']), 2, ',', '.');
												
								(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
								$data['radio'] = array(
									'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
								);
								($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';
								
								$_SESSION['Servico'][$j]['ProfissionalServico_1'] = $data['servico'][$j]['ProfissionalProduto_1'];
								$_SESSION['Servico'][$j]['ProfissionalServico_2'] = $data['servico'][$j]['ProfissionalProduto_2'];
								$_SESSION['Servico'][$j]['ProfissionalServico_3'] = $data['servico'][$j]['ProfissionalProduto_3'];
								$_SESSION['Servico'][$j]['ProfissionalServico_4'] = $data['servico'][$j]['ProfissionalProduto_4'];
								$_SESSION['Servico'][$j]['ProfissionalServico_5'] = $data['servico'][$j]['ProfissionalProduto_5'];
								$_SESSION['Servico'][$j]['ProfissionalServico_6'] = $data['servico'][$j]['ProfissionalProduto_6'];
								
								$data['select'][$j]['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
								
								if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
								}
							}
						}
					}

					#### App_Produto ####
					$data['produto'] = $this->Orcatrata_model->get_produto($id);
					if (count($data['produto']) > 0) {
						$data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
						$data['count']['PCount'] = count($data['produto']);

						if (isset($data['produto'])) {

							for($j=1;$j<=$data['count']['PCount'];$j++) {
								$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
								$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
								$data['produto'][$j]['SubtotalComissaoServicoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoServicoProduto'] /100);
								$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoCashBackProduto'] /100);
								$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
								$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
								$data['produto'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataConcluidoProduto'], 'barras');

								(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
								$data['radio'] = array(
									'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
								);
								($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';

								///esta linha deve ser retirada ap�s corre��o dos nomes dos pedidos antigos///
								//$data['produto'][$j]['NomeProduto'] = $data['produto'][$j]['Produto'];
							}

						}
					}

					#### App_Parcelas ####
					$data['parcelasrec'] = $this->Orcatrata_model->get_parcelas($id);
					if (count($data['parcelasrec']) > 0) {
						$data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
						$data['count']['PRCount'] = count($data['parcelasrec']);
						
						if (isset($data['parcelasrec'])) {

							for($j=1; $j <= $data['count']['PRCount']; $j++) {
								$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
								$data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
								$data['parcelasrec'][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataLanc'], 'barras');
							
								$data['radio'] = array(
									'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
								);
								($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';
							}

						}
					}

					#### App_Procedimento ####
					$_SESSION['Procedimento'] = $data['procedimento'] = $this->Orcatrata_model->get_procedimento($id);
					if (count($data['procedimento']) > 0) {
						$data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
						$data['count']['PMCount'] = count($data['procedimento']);

						if (isset($data['procedimento'])) {

							for($j=1; $j <= $data['count']['PMCount']; $j++) {
								$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');
								$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataConcluidoProcedimento'], 'barras');
								$_SESSION['Procedimento'][$j]['Nome'] = $data['procedimento'][$j]['Nome'];
								$data['radio'] = array(
									'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
								);
								($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';
							
								$_SESSION['Procedimento'][$j]['Compartilhar'] = $data['procedimento'][$j]['Compartilhar'];
								$data['select'][$j]['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos($_SESSION['Procedimento'][$j]['Compartilhar']);
							
							}
						}
					}
				}
			}
			
			if(!$data['orcatrata']['idApp_OrcaTrata'] || !$_SESSION['Orcatrata'] || $_SESSION['Orcatrata']['idTab_TipoRD'] != 2){
				
				unset($_SESSION['Orcatrata']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {			
					
				#### Carrega os dados do Vendedor nas vari�ves de sess�o ####
				if($_SESSION['log']['idSis_Empresa'] != 5){
					if(isset($_SESSION['Orcatrata']['id_Funcionario']) && $_SESSION['Orcatrata']['id_Funcionario'] != 0){
						$data['funcionario']['Nome'] = $this->Usuario_model->get_usuario($_SESSION['Orcatrata']['id_Funcionario'], TRUE)['Nome'];
					}
					if(isset($_SESSION['Orcatrata']['id_Associado']) && $_SESSION['Orcatrata']['id_Associado'] != 0){
						$data['associado']['Nome'] = $this->Associado_model->get_associado($_SESSION['Orcatrata']['id_Associado'], TRUE)['Nome'];
					}
				}elseif($_SESSION['log']['idSis_Empresa'] == 5){
					if(isset($_SESSION['Orcatrata']['id_Funcionario']) && $_SESSION['Orcatrata']['id_Funcionario'] != 0){
						$data['associado']['Nome'] = $this->Associado_model->get_associado($_SESSION['Orcatrata']['id_Funcionario'], TRUE)['Nome'];
					}
				}
					
				#### Carrega os dados do cliente nas vari�ves de sess�o ####
				if($_SESSION['Orcatrata']['idApp_Cliente'] != 0){

					$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($_SESSION['Orcatrata']['idApp_Cliente'], TRUE);
			
					if($data['query'] === FALSE){
						
						unset($_SESSION['Cliente']);
						$data['msg'] = '?m=3';
						redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
						exit();
						
					} else {
						$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
					}
				}else{
					unset($_SESSION['Cliente']);
				}
									
				#### Carrega os dados da Campanha nas vari�ves de sess�o ####
				$_SESSION['Campanha'] = $this->Campanha_model->get_campanha_cupom($_SESSION['Orcatrata']['Cupom']);
				
				#### Carrega os dados das consultas nas vari�ves de sess�o ####
				$_SESSION['Consultas_orca'] = $data['consultas_orca'] = $this->Consulta_model->get_consultas_orca($_SESSION['Orcatrata']['idApp_OrcaTrata'], TRUE);
				$_SESSION['Orcatratas'] = $data['orcatratas'] = $this->Orcatrata_model->get_orcatratas_repet($_SESSION['Orcatrata']['RepeticaoOrca']);

				if(!empty($_SESSION['Orcatrata']['idApp_ClientePet']) && $_SESSION['Orcatrata']['idApp_ClientePet'] != 0){
					//$this->load->model('Clientepet_model');
					$_SESSION['ClientePet'] = $data['clientepet'] = $this->Clientepet_model->get_clientepet($_SESSION['Orcatrata']['idApp_ClientePet'], TRUE);
					$_SESSION['ClientePet']['NomeClientePet'] = (strlen($data['clientepet']['NomeClientePet']) > 20) ? substr($data['clientepet']['NomeClientePet'], 0, 20) : $data['clientepet']['NomeClientePet'];
				}

				if(!empty($_SESSION['Orcatrata']['idApp_ClienteDep']) && $_SESSION['Orcatrata']['idApp_ClienteDep'] != 0){
					//$this->load->model('Clientedep_model');
					$_SESSION['ClienteDep'] = $data['clientedep'] = $this->Clientedep_model->get_clientedep($_SESSION['Orcatrata']['idApp_ClienteDep'], TRUE);
					$_SESSION['ClienteDep']['NomeClienteDep'] = (strlen($data['clientedep']['NomeClienteDep']) > 20) ? substr($data['clientedep']['NomeClienteDep'], 0, 20) : $data['clientedep']['NomeClienteDep'];
				}

				
				if(isset($_SESSION['Orcatrata']) && $_SESSION['Orcatrata']['RepeticaoCons'] != 0){
					$data['readonly_cons'] = 'readonly=""';
				}else{
					$data['readonly_cons'] = '';
				}
				
				$data['select']['TipoDescOrca'] = array (
					'P' => '.%',
					'V' => 'R$',
				);		
				$data['select']['TipoExtraOrca'] = array (
					'P' => '.%',
					'V' => 'R$',
				);			
				$data['select']['UsarCashBack'] = $this->Basico_model->select_status_sn();
				$data['select']['UsarCupom'] = $this->Basico_model->select_status_sn();
				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
				$data['select']['Whatsapp'] = $this->Basico_model->select_status_sn();
				$data['select']['Whatsapp_Site'] = $this->Basico_model->select_status_sn();
				$data['select']['StatusProdutos'] = $this->Basico_model->select_status_sn();
				$data['select']['StatusParcelas'] = $this->Basico_model->select_status_sn();
				$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['Entrega_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
				$data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
				$data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
				$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
				$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
				$data['select']['FormaPagamentoParcela'] = $this->Formapag_model->select_formapag();
				$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['DevolvidoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['ProntoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['CanceladoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
				$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
				$data['select']['TipoFrete'] = $this->Basico_model->select_tipofrete();
				$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['Quitado'] = $this->Basico_model->select_status_sn();
				//$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
				$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
				//$data['select']['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalProduto_1'] = $this->Usuario_model->select_usuario();
				$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
				//$data['select']['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos();
				$data['select']['Entregador'] = $this->Usuario_model->select_usuario_entregador($_SESSION['Orcatrata']['Entregador']);
				$data['select']['Produto'] = $this->Basico_model->select_produtos3($data['orcatrata']['Tipo_Orca']);
				$data['select']['Servico'] = $this->Basico_model->select_servicos3($data['orcatrata']['Tipo_Orca']);
				#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
				$data['select']['AVAP'] = $this->Basico_model->select_avap();
				$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['Prioridade'] = array (
					'1' => 'Alta',
					'2' => 'M�dia',
					'3' => 'Baixa',
				);
				
				$data['titulo'] = 'Pedido';
				$data['form_open_path'] = 'orcatrata/alterarstatus';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;
				$data['caminho'] = '../../';
				
				$data['exibir_id'] = 0;
				
				$data['AtivoCashBack'] = 'N';

				$data['collapse'] = '';	
				$data['collapse1'] = 'class="collapse"';
				
				$data['exibirExtraOrca'] = 0;
				$data['exibirDescOrca'] = 0;
				
				$data['count_orca'] = count($_SESSION['Consultas_orca']);// conta quantos idApp_OrcaTrata existem na tabela de APP_Consultas,  na posicao idApp_OrcaTrata
				$data['count_orcatratas'] = count($_SESSION['Orcatratas']);// conta quantos RepeticaoOrca, que est� anotado nesta O.S., existem na tabela App_OrcaTrata, na posi��o RepeticaoOrca

				$data['Recorrencias'] = $_SESSION['Orcatrata']['RecorrenciasOrca'];
				$data['Recorrencias_outras'] = $data['Recorrencias'] - 1;
				
				$data['orcatratas_total'] = $this->Orcatrata_model->get_orcatratas_repet_total($_SESSION['Orcatrata']['RepeticaoOrca'], $_SESSION['Orcatrata']['idApp_OrcaTrata']);	
				$data['count_orcatratas_total'] = count($data['orcatratas_total']);
				
				$data['soma_cashback_repet_total_outras'] = 0;
				if ($data['count_orcatratas_total'] > 0) {
					$data['orcatratas_total'] = array_combine(range(1, count($data['orcatratas_total'])), array_values($data['orcatratas_total']));

					if (isset($data['orcatratas_total'])) {

						for($j=1; $j <= $data['count_orcatratas_total']; $j++) {
							$data['soma_cashback_repet_total_outras'] += $data['orcatratas_total'][$j]['ValorComissaoCashBack'];
							
						}
					}
				}		

				$data['orcatratas_s_pago'] = $this->Orcatrata_model->get_orcatratas_repet_s_pago($_SESSION['Orcatrata']['RepeticaoOrca'], $_SESSION['Orcatrata']['idApp_OrcaTrata']);	
				$data['count_orcatratas_s_pago'] = count($data['orcatratas_s_pago']);
				
				$data['soma_cashback_repet_s_pago_outras'] = 0;
				if ($data['count_orcatratas_s_pago'] > 0) {
					$data['orcatratas_s_pago'] = array_combine(range(1, count($data['orcatratas_s_pago'])), array_values($data['orcatratas_s_pago']));

					if (isset($data['orcatratas_s_pago'])) {

						for($j=1; $j <= $data['count_orcatratas_s_pago']; $j++) {
							$data['soma_cashback_repet_s_pago_outras'] += $data['orcatratas_s_pago'][$j]['ValorComissaoCashBack'];
							
						}
					}
				}		
			
				
				$data['orcatratas_n_pago'] = $this->Orcatrata_model->get_orcatratas_repet_n_pago($_SESSION['Orcatrata']['RepeticaoOrca'], $_SESSION['Orcatrata']['idApp_OrcaTrata']);	
				$data['count_orcatratas_n_pago'] = count($data['orcatratas_n_pago']);

				$data['soma_repet_n_pago'] = 0;
				if ($data['count_orcatratas_n_pago'] > 0) {
					$data['orcatratas_n_pago'] = array_combine(range(1, count($data['orcatratas_n_pago'])), array_values($data['orcatratas_n_pago']));

					if (isset($data['orcatratas_n_pago'])) {

						for($j=1; $j <= $data['count_orcatratas_n_pago']; $j++) {
							$data['soma_repet_n_pago'] += $data['orcatratas_n_pago'][$j]['ValorParcela'];
							
						}
					}
				}
				/*
				echo '<br>';
				echo "<pre>";
				echo '<br>';
				print_r($data['Recorrencias']);
				echo '<br>';
				print_r($data['count_orcatratas_n_pago']);
				echo '<br>';
				print_r($data['soma_repet_n_pago']);
				echo '<br>';
				print_r($data['orcatratas_n_pago']);
				echo "</pre>";
				//exit();		
				*/
				$data['valorfinal_os'] = $_SESSION['Orcatrata']['ValorFinalOrca'];
				
				$data['valorfinal_soma_os'] = $data['valorfinal_os'] + $data['soma_repet_n_pago']; 
				
				$data['soma_repet_n_pago'] = number_format($data['soma_repet_n_pago'],2,",",".");
				$data['valorfinal_soma_os'] = number_format($data['valorfinal_soma_os'],2,",",".");
				
				(!$data['cadastrar']['Valor_S_Desc']) ? $data['cadastrar']['Valor_S_Desc'] = $data['valorfinal_soma_os'] : FALSE;

				if($data['count_orcatratas'] <= 0){
					$data['vinculadas'] = 0;
				}else{
					$data['vinculadas'] = $data['count_orcatratas'] - 1;
				}

				if ($data['vinculadas'] > 0){
					$data['textoEntregues'] = '';
					$data['textoPagas'] = '';
				}else{
					$data['textoEntregues'] = 'style="display: none;"';
					$data['textoPagas'] = 'style="display: none;"';
				}		

				//if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
				if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
					$data['orcamentoin'] = 'in';
				else
					$data['orcamentoin'] = '';

				if ($data['orcatrata']['FormaPagamento'])
					$data['parcelasin'] = 'in';
				else
					$data['parcelasin'] = '';

				//if (isset($data['procedimento']) && ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional']))
				if ($data['count']['PMCount'] > 0)
					$data['tratamentosin'] = 'in';
				else
					$data['tratamentosin'] = '';

				if ($_SESSION['log']['NivelEmpresa'] >= '4' )
					$data['visivel'] = '';
				else
					$data['visivel'] = 'style="display: none;"';		

				($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
				
				$data['radio'] = array(
					'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
				);
				($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
				
				($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
				/*
				$data['radio'] = array(
					'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
				);
				($data['orcatrata']['AVAP'] == 'P') ?
					$data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';		
				*/
				
				$data['radio'] = array(
					'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
				);
				($data['cadastrar']['Cadastrar'] == 'N') ?
					$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'Whatsapp' => $this->basico->radio_checked($data['cadastrar']['Whatsapp'], 'Whatsapp', 'NS'),
				);
				($data['cadastrar']['Whatsapp'] == 'S') ?
					$data['div']['Whatsapp'] = '' : $data['div']['Whatsapp'] = 'style="display: none;"';		
							
				$data['radio'] = array(
					'Whatsapp_Site' => $this->basico->radio_checked($data['cadastrar']['Whatsapp_Site'], 'Whatsapp_Site', 'NS'),
				);
				($data['cadastrar']['Whatsapp_Site'] == 'S') ?
					$data['div']['Whatsapp_Site'] = '' : $data['div']['Whatsapp_Site'] = 'style="display: none;"';
							
				$data['radio'] = array(
					'StatusProdutos' => $this->basico->radio_checked($data['cadastrar']['StatusProdutos'], 'StatusProdutos', 'NS'),
				);
				($data['cadastrar']['StatusProdutos'] == 'S') ?
					$data['div']['StatusProdutos'] = '' : $data['div']['StatusProdutos'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'StatusParcelas' => $this->basico->radio_checked($data['cadastrar']['StatusParcelas'], 'StatusParcelas', 'NS'),
				);
				($data['cadastrar']['StatusParcelas'] == 'S') ?
					$data['div']['StatusParcelas'] = '' : $data['div']['StatusParcelas'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
				);
				($data['cadastrar']['AtualizaEndereco'] == 'N') ?
					$data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	
				/*	
				$data['radio'] = array(
					'Modalidade' => $this->basico->radio_checked($data['orcatrata']['Modalidade'], 'Modalidade', 'PM'),
				);
				($data['orcatrata']['Modalidade'] == 'P') ?
					$data['div']['Modalidade'] = '' : $data['div']['Modalidade'] = 'style="display: none;"';
				*/		
				$data['radio'] = array(
					'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
				);
				($data['orcatrata']['CombinadoFrete'] == 'S') ?
					$data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
				);
				($data['orcatrata']['AprovadoOrca'] == 'S') ?
					$data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
				);
				($data['orcatrata']['EnviadoOrca'] == 'S') ?
					$data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';			

				$data['radio'] = array(
					'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Cancelado', 'NS'),
				);
				($data['orcatrata']['FinalizadoOrca'] == 'N') ?
					$data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';        
				
				$data['radio'] = array(
					'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Produtos Entregues', 'NS'),
				);
				($data['orcatrata']['CanceladoOrca'] == 'N') ?
					$data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';        
				
				$data['radio'] = array(
					'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
				);
				($data['orcatrata']['ConcluidoOrca'] == 'S') ?
					$data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

				$data['radio'] = array(
					'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Produtos Devolvidos', 'NS'),
				);
				($data['orcatrata']['ProntoOrca'] == 'S') ?
					$data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
				);
				($data['orcatrata']['DevolvidoOrca'] == 'S') ?
					$data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';			

				$data['radio'] = array(
					'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
				);
				($data['orcatrata']['QuitadoOrca'] == 'S') ?
					$data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
				);
				($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
					$data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
				);
				($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
					$data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Entrega_Orca' => $this->basico->radio_checked($data['orcatrata']['Entrega_Orca'], 'Entrega', 'NS'),
				);
				($data['orcatrata']['Entrega_Orca'] == 'S') ?
					$data['div']['Entrega_Orca'] = '' : $data['div']['Entrega_Orca'] = 'style="display: none;"';
				

				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';
				
				$data['cor_cli'] 	= 'default';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'warning';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';
				
				$data['nav_orca'] 		= 'S';
				$data['nav_status'] 	= 'N';
				$data['nav_alterar'] 	= 'S';
				
				$data['nav_imprimir'] 	= 'N';
				$data['nav_entrega'] 	= 'S';
				$data['nav_cobranca'] 	= 'S';

				$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

				$data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				#### App_OrcaTrata ####
				$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
				$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
				$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
				if ($_SESSION['log']['NivelEmpresa'] >= '4') {
					$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
				}
				//$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
				//$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');
				$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');			
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('orcatrata/form_orcatrataalterarstatus', $data);
				
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'orcatrata/alterarstatus/' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . $data['msg']);
						
					} else {

						/*
						echo '<br>';
						echo "<pre>";
						echo '<br>';
						print_r($_SESSION['Orcatrata']['idApp_Cliente']);
						echo '<br>';
						print_r($data['orcatrata']['idApp_Cliente']);
						echo '<br>';
						print_r($_SESSION['Orcatrata']['idApp_ClientePet']);
						echo '<br>';
						print_r($_SESSION['Orcatrata']['idApp_ClienteDep']);
						echo "</pre>";
						exit();		
						*/
						
						#### Estoque_Produto_anterior e CashBack_anterior####
						
							
							#### Estoque_Produto_anterior ####					
							if ($_SESSION['Orcatrata']['CombinadoFrete'] == 'S') {
								
								$data['busca']['estoque']['anterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
								
								if (count($data['busca']['estoque']['anterior']) > 0) {
									
									$data['busca']['estoque']['anterior'] = array_combine(range(1, count($data['busca']['estoque']['anterior'])), array_values($data['busca']['estoque']['anterior']));
									$max_estoque = count($data['busca']['estoque']['anterior']);
									
									if (isset($data['busca']['estoque']['anterior'])){
										
										for($j=1;$j<=$max_estoque;$j++) {
											
											$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['anterior'][$j]['idTab_Produtos_Produto']);
											
											if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
												
												$qtd_produto[$j]	= ($data['busca']['estoque']['anterior'][$j]['QtdProduto'] * $data['busca']['estoque']['anterior'][$j]['QtdIncrementoProduto']);
												
												$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] + $qtd_produto[$j]);
												
												if($diff_estoque[$j] <= 0){
													$estoque[$j] = 0; 
												}else{
													$estoque[$j] = $diff_estoque[$j]; 
												}
												
												$data['alterar']['produto']['anterior'][$j]['Estoque'] = $estoque[$j];
												$data['alterar']['produto']['anterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['anterior'][$j], $data['get']['produto'][$j]['idTab_Produtos']);

												unset($qtd_produto[$j]);
												unset($diff_estoque[$j]);
												unset($estoque[$j]);
											}
											
										}
										
									}
									
								}
								
							}		
							
							#### CashBack_anterior####	
							$data['busca']['cashback']['anterior'] = $this->Orcatrata_model->get_produto_cashback_pedido($data['orcatrata']['idApp_OrcaTrata']);
							$max_cashback = count($data['busca']['cashback']['anterior']);				

							if ($max_cashback > 0) {
								
								$data['busca']['cashback']['anterior'] = array_combine(range(1, count($data['busca']['cashback']['anterior'])), array_values($data['busca']['cashback']['anterior']));
								
								if (isset($data['busca']['cashback']['anterior'])){
									
									$data['valorcashbackpedido']=0;
									
									for($j=1;$j<=$max_cashback;$j++) {
										$data['get']['valorcashback'][$j] = $data['busca']['cashback']['anterior'][$j]['ValorComissaoCashBack'];
										$data['valorcashbackpedido'] += $data['get']['valorcashback'][$j];
									}
									
									if(isset($data['orcatrata']['idApp_Cliente']) && $data['orcatrata']['idApp_Cliente'] != 0 && $data['orcatrata']['idApp_Cliente'] != ""){	

										$data['update']['cliente_cashback']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
										$data['valorcashbackcliente'] = $data['update']['cliente_cashback']['anterior']['CashBackCliente'];

										if ($_SESSION['Orcatrata']['CanceladoOrca'] == 'N') {	
											
											if($_SESSION['Orcatrata']['QuitadoOrca'] == 'S'){
											
												//subtraio o valorcashbackpedido e o valordocashbackoutrasos do valor atual do cashbackcliente
												
												$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] - ($data['valorcashbackpedido'] + $data['soma_cashback_repet_s_pago_outras']);
							
												if($data['cliente_cashback']['CashBackCliente'] >= 0){
													$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
												}else{
													$data['cliente_cashback']['CashBackCliente'] = 0.00;
												}

												$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);
						
											}else{
												
												//subtraio o valordocashbackoutrasos do valor atual do cashbackcliente
												
												$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] - $data['soma_cashback_repet_s_pago_outras'];
							
												if($data['cliente_cashback']['CashBackCliente'] >= 0){
													$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
												}else{
													$data['cliente_cashback']['CashBackCliente'] = 0.00;
												}

												$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);						
											}
											
										}else{
										
											//subtraio o valordocashbackoutrasos do valor atual do cashbackcliente
											
											$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] - $data['soma_cashback_repet_s_pago_outras'];
						
											if($data['cliente_cashback']['CashBackCliente'] >= 0){
												$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
											}else{
												$data['cliente_cashback']['CashBackCliente'] = 0.00;
											}

											$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);					
															
										}
									}
								}
								
							}
							
						/*
						echo '<br>';
						echo "<pre>";
						echo '<br>';
						print_r($data['valorcashbackcliente']);
						echo '<br>';
						print_r($data['valorcashbackpedido']);
						echo '<br>';
						print_r($data['cliente_cashback']['CashBackCliente']);
						echo "</pre>";
						*/			
					
						$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
						$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
						$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

						////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
						#### App_OrcaTrata ####
						if ($data['orcatrata']['Entrega_Orca'] == "S") {	
							if ($data['orcatrata']['TipoFrete'] == '1') {
								$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
								$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
								$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
								$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
								$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
								$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
								$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
								$data['orcatrata']['Referencia'] = '';
							} else {	
								$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
								$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
								$data['orcatrata']['Numero'] = trim(mb_strtoupper($numero1, 'ISO-8859-1'));
								$data['orcatrata']['Complemento'] = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));
								$data['orcatrata']['Bairro'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
								$data['orcatrata']['Cidade'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
								$data['orcatrata']['Estado'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));
								$data['orcatrata']['Referencia'] = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));
							}
						} else {
							$data['orcatrata']['Cep'] = '';
							$data['orcatrata']['Logradouro'] = '';
							$data['orcatrata']['Numero'] = '';
							$data['orcatrata']['Complemento'] = '';
							$data['orcatrata']['Bairro'] = '';
							$data['orcatrata']['Cidade'] = '';
							$data['orcatrata']['Estado'] = '';
							$data['orcatrata']['Referencia'] = '';
						}
						$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
						$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
						$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
						$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
						$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));			
						$data['orcatrata']['TipoFinanceiro'] = $data['orcatrata']['TipoFinanceiro'];
						$data['orcatrata']['Entregador'] = $data['orcatrata']['Entregador'];
						$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
						$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
						$data['orcatrata']['Descricao'] = $data['orcatrata']['Descricao'];
						//$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
						//$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
						//$data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
						//$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
						//$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');

						if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
							$data['orcatrata']['ConcluidoOrca'] = "S";
							$data['orcatrata']['QuitadoOrca'] = "S";
						} 
						if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['FinalizadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
						} 
						if($data['orcatrata']['ConcluidoOrca'] == 'S'){
							$data['orcatrata']['CombinadoFrete'] = "S";
						} 
						if($data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
						} 
						if ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
							$data['orcatrata']['EnviadoOrca'] = "S";
						}

						$data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
						$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
						$data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
						//$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
						if($data['orcatrata']['FormaPagamento'] == "7"){
							$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
							$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
						}else{
							$data['orcatrata']['ValorDinheiro'] = 0.00;
							$data['orcatrata']['ValorTroco'] = 0.00;
						}
						//$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
						
						$data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
						$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
						$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
						$data['orcatrata']['PercExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['PercExtraOrca']));
						
						
						$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
						$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
					
						$data['orcatrata']['DescPercOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescPercOrca']));
						$data['orcatrata']['DescValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescValorOrca']));
						
						$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
						$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'mysql');
						if(isset($data['orcatrata']['ValidadeCashBackOrca']) && $data['orcatrata']['ValidadeCashBackOrca'] != "0000-00-00" && $data['orcatrata']['ValidadeCashBackOrca'] != ""){
							$data['orcatrata']['ValidadeCashBackOrca'] = $data['orcatrata']['ValidadeCashBackOrca'];
						}else{
							$data['orcatrata']['ValidadeCashBackOrca'] = "0000-00-00";
						}
						
						$data['orcatrata']['ValorFinalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
						$data['orcatrata']['SubValorFinal'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['SubValorFinal']));

						if($data['orcatrata']['Entrega_Orca'] == "N"){
							$data['orcatrata']['DataEntregaOrca'] = $data['orcatrata']['DataOrca'];
							$data['orcatrata']['HoraEntregaOrca'] = "00:00:00";
							$data['orcatrata']['PrazoProdServ'] = 0;
							$data['orcatrata']['PrazoCorreios'] = 0;
							$data['orcatrata']['PrazoEntrega'] = 0;
						}
						
						if (!$data['orcatrata']['PrazoEntrega']){
							//$data1 = date('Y-m-d', time());
							$data1 = $data['orcatrata']['DataOrca'];
							$data2 = $data['orcatrata']['DataEntregaOrca'];
							$intervalo = strtotime($data2)-strtotime($data1); 
							$dias = floor($intervalo / (60 * 60 * 24));
							$data['orcatrata']['PrazoEntrega'] = $dias;
						}

						$data['orcatrata']['ValorFatura'] = $data['orcatrata']['ValorFinalOrca'];
						
						if($data['orcatrata']['AVAP'] == "O" && ($data['orcatrata']['FormaPagamento'] == "1" || $data['orcatrata']['FormaPagamento'] == "2" || $data['orcatrata']['FormaPagamento'] == "3")){
							$data['orcatrata']['ValorGateway'] = ($data['orcatrata']['ValorFatura'] * 0.04) + 0.40;
						}else{
							$data['orcatrata']['ValorGateway'] = 0.00;
						}
						$data['orcatrata']['ValorEmpresa'] = $data['orcatrata']['ValorFatura'] - $data['orcatrata']['ValorComissao'] - $data['orcatrata']['ValorGateway'];

						#### APP_Cliente ####
						if ($data['cadastrar']['AtualizaEndereco'] == 'S' && $data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['Entrega_Orca'] == "S" && $data['orcatrata']['idApp_Cliente'] != 0){
							$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
							$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
							$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
							$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
							$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
							$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
							$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
							$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
										
							$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
							$data['update']['cliente']['campos'] = array_keys($data['cliente']);
				
							$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);

							
						}

						#### App_Servico ####
						$data['update']['servico']['anterior'] = $this->Orcatrata_model->get_servico($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

							if (isset($data['servico']))
								$data['servico'] = array_values($data['servico']);
							else
								$data['servico'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_Produto');

							$max = count($data['update']['servico']['inserir']);
							for($j=0;$j<$max;$j++) {
								
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_1']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_1'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_2']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_2'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_3']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_3'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_4']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_4'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_5']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_5'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_6']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_6'] = 0;
								}

								$data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['Orcatrata']['idSis_Usuario'];
								$data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['servico']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['servico']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
								$data['update']['servico']['inserir'][$j]['idTab_TipoRD'] = "2";
								$data['update']['servico']['inserir'][$j]['NivelProduto'] = $_SESSION['Orcatrata']['NivelOrca'];

								if(empty($data['update']['servico']['inserir'][$j]['ValorProduto'])){
									$data['update']['servico']['inserir'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorProduto']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_1'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_1'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_1']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_2'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_2'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_2']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_3'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_3'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_3']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_4'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_4'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_4']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_5'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_5'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_5']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_6'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_6'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_6']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComissaoServico'])){
									$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComissaoServico']));
								}
								
								$data['update']['servico']['inserir'][$j]['ValorComissaoVenda'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto'];
								
								//$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoServicoProduto'];
								$data['update']['servico']['inserir'][$j]['ValorComissaoAssociado'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoServicoProduto'];

								$data['update']['servico']['inserir'][$j]['ValorComissaoFuncionario'] = $data['update']['servico']['inserir'][$j]['QtdProduto']*$data['update']['servico']['inserir'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;
								
								$data['update']['servico']['inserir'][$j]['ValorComissaoCashBack'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoCashBackProduto'];
						
								if(!$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] || $data['update']['servico']['inserir'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['servico']['inserir'][$j]['DataValidadeProduto'])){
									$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataValidadeProduto'], 'mysql');
								}
																		
								if(!$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] || $data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['servico']['inserir'][$j]['DataConcluidoProduto'])){
									$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] || $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'];
								}
													
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['ConcluidoProduto'];
								}
								
								unset($data['update']['servico']['inserir'][$j]['SubtotalProduto']);
								unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto']);
								unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoServicoProduto']);
								unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['servico']['inserir'][$j]['SubtotalQtdProduto']);
							}

							$max = count($data['update']['servico']['alterar']);
							for($j=0;$j<$max;$j++) {
								
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_1']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_1'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_2']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_2'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_3']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_3'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_4']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_4'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_5']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_5'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_6']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_6'] = 0;
								}

								$data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'];
								$data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'];

								if(empty($data['update']['servico']['alterar'][$j]['ValorProduto'])){
									$data['update']['servico']['alterar'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorProduto']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_1'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_1'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_1']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_2'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_2'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_2']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_3'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_3'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_3']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_4'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_4'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_4']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_5'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_5'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_5']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_6'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_6'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_6']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComissaoServico'])){
									$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComissaoServico']));
								}
								
								$data['update']['servico']['alterar'][$j]['ValorComissaoVenda'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto'];
								
								//$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoServicoProduto'];
								$data['update']['servico']['alterar'][$j]['ValorComissaoAssociado'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoServicoProduto'];

								$data['update']['servico']['alterar'][$j]['ValorComissaoFuncionario'] = $data['update']['servico']['alterar'][$j]['QtdProduto']*$data['update']['servico']['alterar'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;
								
								$data['update']['servico']['alterar'][$j]['ValorComissaoCashBack'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoCashBackProduto'];
						
								if(!$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] || $data['update']['servico']['alterar'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['servico']['alterar'][$j]['DataValidadeProduto'])){
									$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeProduto'], 'mysql');
								}
																		
								if(!$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] || $data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['servico']['alterar'][$j]['DataConcluidoProduto'])){
									$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] || $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'];
								}					
													
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['ConcluidoProduto'];
								}

								if ($data['orcatrata']['idApp_Cliente']) $data['update']['servico']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					

								unset($data['update']['servico']['alterar'][$j]['SubtotalProduto']);
								unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto']);
								unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoServicoProduto']);
								unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['servico']['alterar'][$j]['SubtotalQtdProduto']);
							}

							if (count($data['update']['servico']['inserir']))
								$data['update']['servico']['bd']['inserir'] = $this->Orcatrata_model->set_servico($data['update']['servico']['inserir']);

							if (count($data['update']['servico']['alterar']))
								$data['update']['servico']['bd']['alterar'] = $this->Orcatrata_model->update_servico($data['update']['servico']['alterar']);

							if (count($data['update']['servico']['excluir']))
								$data['update']['servico']['bd']['excluir'] = $this->Orcatrata_model->delete_servico($data['update']['servico']['excluir']);
						}

						#### App_Produto ####
						$data['update']['produto']['anterior'] = $this->Orcatrata_model->get_produto($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

							if (isset($data['produto']))
								$data['produto'] = array_values($data['produto']);
							else
								$data['produto'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_Produto');

							$max = count($data['update']['produto']['inserir']);
							for($j=0;$j<$max;$j++) {
								
								$data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['Orcatrata']['idSis_Usuario'];
								$data['update']['produto']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['produto']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['produto']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
								$data['update']['produto']['inserir'][$j]['idTab_TipoRD'] = "2";
								$data['update']['produto']['inserir'][$j]['NivelProduto'] = $_SESSION['Orcatrata']['NivelOrca'];

								if(empty($data['update']['produto']['inserir'][$j]['ValorProduto'])){
									$data['update']['produto']['inserir'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));
								}
								
								$data['update']['produto']['inserir'][$j]['ValorComissaoVenda'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto'];
								
								//$data['update']['produto']['inserir'][$j]['ValorComissaoServico'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoServicoProduto'];
								$data['update']['produto']['inserir'][$j]['ValorComissaoAssociado'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoServicoProduto'];

								$data['update']['produto']['inserir'][$j]['ValorComissaoFuncionario'] = $data['update']['produto']['inserir'][$j]['QtdProduto']*$data['update']['produto']['inserir'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;
								
								$data['update']['produto']['inserir'][$j]['ValorComissaoCashBack'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoCashBackProduto'];

								if(!$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] || $data['update']['produto']['inserir'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['produto']['inserir'][$j]['DataValidadeProduto'])){
									$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
								}
													
								if(!$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] || $data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['produto']['inserir'][$j]['DataConcluidoProduto'])){
									$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] || $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'];
								}
													
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
								}
								
								if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
									$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
								} else {
									$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = $data['update']['produto']['inserir'][$j]['DevolvidoProduto'];
								}
								
								unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
								unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
								unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoServicoProduto']);
								unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);                
							}

							$max = count($data['update']['produto']['alterar']);
							for($j=0;$j<$max;$j++) {

								//$data['update']['produto']['alterar'][$j]['ProfissionalProduto_1'] = $data['update']['produto']['alterar'][$j]['ProfissionalProduto_1'];
								$data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
								$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
								$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];

								if(empty($data['update']['produto']['alterar'][$j]['ValorProduto'])){
									$data['update']['produto']['alterar'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
								}
								
								$data['update']['produto']['alterar'][$j]['ValorComissaoVenda'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto'];
								
								//$data['update']['produto']['alterar'][$j]['ValorComissaoServico'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoServicoProduto'];
								$data['update']['produto']['alterar'][$j]['ValorComissaoAssociado'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoServicoProduto'];

								$data['update']['produto']['alterar'][$j]['ValorComissaoFuncionario'] = $data['update']['produto']['alterar'][$j]['QtdProduto']*$data['update']['produto']['alterar'][$j]['ValorProduto']*$_SESSION['Orcatrata']['ComissaoFunc']/100;
								
								$data['update']['produto']['alterar'][$j]['ValorComissaoCashBack'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoCashBackProduto'];

								if(!$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] || $data['update']['produto']['alterar'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['produto']['alterar'][$j]['DataValidadeProduto'])){
									$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
								}
													
								if(!$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['produto']['alterar'][$j]['DataConcluidoProduto'])){
									$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'];
								}
													
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['ConcluidoProduto'];
								}

								if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
									$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'S';
								} else {	
									$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = $data['update']['produto']['alterar'][$j]['DevolvidoProduto'];
								}
								
								if ($data['orcatrata']['idApp_Cliente']) $data['update']['produto']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];

								unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
								unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
								unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoServicoProduto']);
								unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);					
							}

							if (count($data['update']['produto']['inserir']))
								$data['update']['produto']['bd']['inserir'] = $this->Orcatrata_model->set_produto($data['update']['produto']['inserir']);

							if (count($data['update']['produto']['alterar']))
								$data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

							if (count($data['update']['produto']['excluir']))
								$data['update']['produto']['bd']['excluir'] = $this->Orcatrata_model->delete_produto($data['update']['produto']['excluir']);

						}
						
						#### App_ParcelasRec ####
						$data['update']['parcelasrec']['anterior'] = $this->Orcatrata_model->get_parcelas($data['orcatrata']['idApp_OrcaTrata']);	
						if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

							if (isset($data['parcelasrec']))
								$data['parcelasrec'] = array_values($data['parcelasrec']);
							else
								$data['parcelasrec'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');
							/*
							echo '<br>';
							echo "<pre>";
							echo '<br>';
							print_r($data['update']['parcelasrec']['alterar']);
							echo "</pre>";
							exit();	
							*/
							$max = count($data['update']['parcelasrec']['inserir']);
							for($j=0;$j<$max;$j++) {
								$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['parcelasrec']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
								$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "2";
								$data['update']['parcelasrec']['inserir'][$j]['NivelParcela'] = $_SESSION['Orcatrata']['NivelOrca'];
								
								$data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
								$data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
								//$data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
								$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
								if($data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela']){
									$data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'] = $data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'];
								}else{
									$data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
								}
								if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
									$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
								} else {
									$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
								}
								if ($data['update']['parcelasrec']['inserir'][$j]['Quitado'] == 'S'){
									if(!$data['update']['parcelasrec']['inserir'][$j]['DataPago']){
										$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'];
									}else{
										$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $data['update']['parcelasrec']['inserir'][$j]['DataPago'];
									}
									$data['update']['parcelasrec']['inserir'][$j]['DataLanc'] = date('Y-m-d', time());
								} else {
									$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = "0000-00-00";
									$data['update']['parcelasrec']['inserir'][$j]['DataLanc'] = "0000-00-00";
								}
							}	

							$max = count($data['update']['parcelasrec']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
								$data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
								//$data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
								$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
								$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataLanc'], 'mysql');
								if($data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela']){
									$data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'] = $data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'];
								}else{
									$data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
								}
								if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
									$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
								} else {
									$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = $data['update']['parcelasrec']['alterar'][$j]['Quitado'];
								}
								if ($data['update']['parcelasrec']['alterar'][$j]['Quitado'] == 'S'){
									if(!$data['update']['parcelasrec']['alterar'][$j]['DataPago']){
										$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'];
									}else{
										$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataPago'];
									}
									if(!$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] || empty($data['update']['parcelasrec']['alterar'][$j]['DataLanc']) || $data['update']['parcelasrec']['alterar'][$j]['DataPago'] == "0000-00-00"){
										$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = date('Y-m-d', time());
									}
								} else {
									$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = "0000-00-00";
									$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = "0000-00-00";
								}
								if ($data['orcatrata']['idApp_Cliente']) $data['update']['parcelasrec']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
							}

							if (count($data['update']['parcelasrec']['inserir']))
								$data['update']['parcelasrec']['bd']['inserir'] = $this->Orcatrata_model->set_parcelas($data['update']['parcelasrec']['inserir']);

							if (count($data['update']['parcelasrec']['alterar']))
								$data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

							if (count($data['update']['parcelasrec']['excluir']))
								$data['update']['parcelasrec']['bd']['excluir'] = $this->Orcatrata_model->delete_parcelas($data['update']['parcelasrec']['excluir']);

						}
						
						#### App_Procedimento ####
						$data['update']['procedimento']['anterior'] = $this->Orcatrata_model->get_procedimento($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

							if (isset($data['procedimento']))
								$data['procedimento'] = array_values($data['procedimento']);
							else
								$data['procedimento'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_Procedimento');

							$max = count($data['update']['procedimento']['inserir']);
							for($j=0;$j<$max;$j++) {
								$data['update']['procedimento']['inserir'][$j]['TipoProcedimento'] = 2;
								$data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['update']['procedimento']['inserir'][$j]['NivelProcedimento'] = $_SESSION['Orcatrata']['NivelOrca'];
								if(!$data['update']['procedimento']['inserir'][$j]['Compartilhar']){
									$data['update']['procedimento']['inserir'][$j]['Compartilhar'] = $_SESSION['log']['idSis_Usuario'];	
								}
								$data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['procedimento']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['procedimento']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
								$data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');
								
								if(!$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento']){
									$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
								}else{
									$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'], 'mysql');
								}
							
							}

							$max = count($data['update']['procedimento']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');
								
								if(!$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento']){
									$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
								}else{                  
									$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'], 'mysql');
								}
												
								if ($data['orcatrata']['idApp_Cliente']) $data['update']['procedimento']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
							}

							if (count($data['update']['procedimento']['inserir']))
								$data['update']['procedimento']['bd']['inserir'] = $this->Orcatrata_model->set_procedimento($data['update']['procedimento']['inserir']);

							if (count($data['update']['procedimento']['alterar']))
								$data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

							if (count($data['update']['procedimento']['excluir']))
								$data['update']['procedimento']['bd']['excluir'] = $this->Orcatrata_model->delete_procedimento($data['update']['procedimento']['excluir']);

						}
							
						#### Recalcaula as Comiss�es ####
						$data['orcatrata']['ValorComissaoFunc'] = 0;
						$data['orcatrata']['ValorComissaoAssoc'] = 0;
						$data['update']['produto']['atual'] = $this->Orcatrata_model->get_produto_comissao_atual($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['atual'])){
							$max_produto = count($data['update']['produto']['atual']);
							if($max_produto > 0){
								for($j=0;$j<$max_produto;$j++) {
									$data['orcatrata']['ValorComissaoFunc'] += $data['update']['produto']['atual'][$j]['ValorComissaoFuncionario'];
									$data['orcatrata']['ValorComissaoAssoc'] += $data['update']['produto']['atual'][$j]['ValorComissaoAssociado'];
								}
							}
						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_contagem($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto > 0){
								$data['orcatrata']['Prd_Srv_Orca'] = "S";
							}
						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto == 0){
								$data['orcatrata']['CombinadoFrete'] = "S";
								#$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
								$data['orcatrata']['ConcluidoOrca'] = "S";
							}else{
								$data['orcatrata']['ConcluidoOrca'] = "N";
							}
						}
						
						$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['parcelasrec']['posterior'])){
							$max_parcela = count($data['update']['parcelasrec']['posterior']);
							if($max_parcela == 0){
								#$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['QuitadoOrca'] = "S";				
							}else{
								$data['orcatrata']['QuitadoOrca'] = "N";
							}
						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto > 0){
								$data['orcatrata']['CombinadoFrete'] = "S";
								#$data['orcatrata']['AprovadoOrca'] = "S";
							}
						}			

						$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);	
						if (isset($data['update']['parcelasrec']['posterior'])){
							$max_parcela = count($data['update']['parcelasrec']['posterior']);
							if($max_parcela > 0){
								#$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['AprovadoOrca'] = "S";				
							}

						}			
						
						if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['FinalizadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
						}else{
							$data['orcatrata']['FinalizadoOrca'] = "N";
						}
						
						$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$data['orcatrata']['idApp_OrcaTrata'], TRUE);
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);			
						
						#### Whatsapp ####
						if ($_SESSION['Orcatrata']['Cli_Forn_Orca'] == 'S' && $data['cadastrar']['Whatsapp'] == 'S'){
							if (isset($_SESSION['Orcatrata']['idApp_Cliente']) && $_SESSION['Orcatrata']['idApp_Cliente'] != 0){
								$_SESSION['bd_orcamento']['Whatsapp'] = $data['cadastrar']['Whatsapp'];
								$_SESSION['bd_orcamento']['Whatsapp_Site'] = $data['cadastrar']['Whatsapp_Site'];
							}
						}
						
						#### Estoque_Produto_posterior e CashBack_posterior####
						
							
							#### Estoque_Produto_posterior ####
							if ($data['orcatrata']['CombinadoFrete'] == 'S' && $data['orcatrata']['CanceladoOrca'] == 'N') {
								
								$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
								
								if (count($data['busca']['estoque']['posterior']) > 0) {
									
									$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
									$max_estoque = count($data['busca']['estoque']['posterior']);
									
									if (isset($data['busca']['estoque']['posterior'])){
										
										for($j=1;$j<=$max_estoque;$j++) {
											
											$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
											
											if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
												
												$qtd_produto[$j]	= ($data['busca']['estoque']['posterior'][$j]['QtdProduto'] * $data['busca']['estoque']['posterior'][$j]['QtdIncrementoProduto']);
												
												$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] - $qtd_produto[$j]);
												
												if($diff_estoque[$j] <= 0){
													$estoque[$j] = 0; 
												}else{
													$estoque[$j] = $diff_estoque[$j]; 
												}
												
												$data['alterar']['produto']['posterior'][$j]['Estoque'] = $estoque[$j];
												$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$j], $data['get']['produto'][$j]['idTab_Produtos']);
												
												unset($qtd_produto[$j]);
												unset($diff_estoque[$j]);
												unset($estoque[$j]);
											}	
											
										}
										
									}
									
								}
								
							}
							
							#### CashBack_posterior ####
							$data['busca']['cashback']['anterior'] = $this->Orcatrata_model->get_produto_cashback_pedido($data['orcatrata']['idApp_OrcaTrata']);
							$max_cashback = count($data['busca']['cashback']['anterior']);				

							if ($max_cashback > 0) {
								
								$data['busca']['cashback']['anterior'] = array_combine(range(1, count($data['busca']['cashback']['anterior'])), array_values($data['busca']['cashback']['anterior']));
								
								if (isset($data['busca']['cashback']['anterior'])){
									
									$data['valorcashbackpedido']=0;
									
									for($j=1;$j<=$max_cashback;$j++) {
										$data['get']['valorcashback'][$j] = $data['busca']['cashback']['anterior'][$j]['ValorComissaoCashBack'];
										$data['valorcashbackpedido'] += $data['get']['valorcashback'][$j];
									}

									if(isset($data['orcatrata']['idApp_Cliente']) && $data['orcatrata']['idApp_Cliente'] != 0 && $data['orcatrata']['idApp_Cliente'] != ""){

										$data['update']['cliente_cashback']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);

										$data['valorcashbackcliente'] = $data['update']['cliente_cashback']['anterior']['CashBackCliente'];
											
										if ($data['orcatrata']['CanceladoOrca'] == 'N') {
											
											if ($data['orcatrata']['QuitadoOrca'] == 'S') {	
													
												if ($data['cadastrar']['StatusParcelas'] == 'S') {		
													//Somo o valorcashbackpedido + valorcashbackoutrasos + valoratualcashbackcliente
													$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] + $data['valorcashbackpedido'] + $data['soma_cashback_repet_total_outras'];
								
													if($data['cliente_cashback']['CashBackCliente'] >= 0){
														$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
													}else{
														$data['cliente_cashback']['CashBackCliente'] = 0.00;
													}
													if($_SESSION['Orcatrata']['QuitadoOrca'] == 'N'){
														$data['cliente_cashback']['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
													}
													$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);
												
												}else{
													//Somo o valorcashbackpedido + valorcashbackoutrasos  + valoratualcashbackcliente
													$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] + $data['valorcashbackpedido'] + $data['soma_cashback_repet_s_pago_outras'];
								
													if($data['cliente_cashback']['CashBackCliente'] >= 0){
														$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
													}else{
														$data['cliente_cashback']['CashBackCliente'] = 0.00;
													}
													if($_SESSION['Orcatrata']['QuitadoOrca'] == 'N'){
														$data['cliente_cashback']['ValidadeCashBack'] = date('Y-m-d', strtotime('+' . $_SESSION['Empresa']['PrazoCashBackEmpresa'] . ' day'));
													}
													$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);
																	
												}
												
												
											}else{
													
												if ($data['cadastrar']['StatusParcelas'] == 'S') {		
													//Mantenho, apenas, o valoratualcashbackcliente

												}else{
													//Somo o valorcashbackoutrasos + valoratualcashbackcliente
													$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] + $data['soma_cashback_repet_s_pago_outras'];
								
													if($data['cliente_cashback']['CashBackCliente'] >= 0){
														$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
													}else{
														$data['cliente_cashback']['CashBackCliente'] = 0.00;
													}
													$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);
																	
												}
												
											}
											
										}else{
										
											//Somo o valorcashbackoutrasos + valoratualcashbackcliente
											$data['cliente_cashback']['CashBackCliente'] = $data['valorcashbackcliente'] + $data['soma_cashback_repet_s_pago_outras'];
						
											if($data['cliente_cashback']['CashBackCliente'] >= 0){
												$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
											}else{
												$data['cliente_cashback']['CashBackCliente'] = 0.00;
											}
											$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']);
																
										}
									}
								}
								
							}			
							
						if($data['count_orcatratas'] > 0){
						
							if($data['orcatrata']['QuitadoOrca'] == "S"){	
								
								if($data['cadastrar']['StatusParcelas'] == "S"){
									
									for($j=0;$j<$data['count_orcatratas'];$j++) {
										$data['update']['orcamentos']['bd'][$j] = $this->baixaparcelasrepet($_SESSION['Orcatratas'][$j]['idApp_OrcaTrata']);
									}
									
								}else{
								
								}
								
							}else{
								
								if($data['cadastrar']['StatusParcelas'] == "S"){
									
									for($j=0;$j<$data['count_orcatratas'];$j++) {
										$data['update']['orcamentos']['bd'][$j] = $this->revert_baixaparcelasrepet($_SESSION['Orcatratas'][$j]['idApp_OrcaTrata']);
									}
									
								}else{
								
								}
												
							}
							
							/*
							if($data['orcatrata']['ConcluidoOrca'] == "S" && $data['cadastrar']['StatusProdutos'] == "S"){
								for($j=0;$j<$data['count_orcatratas'];$j++) {
									$data['update']['orcamentos']['bd'][$j] = $this->baixaprodutosrepet($_SESSION['Orcatratas'][$j]['idApp_OrcaTrata']);
								}
							}
							*/
						}
						
						/*
						/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
									$data['campos'] = array_keys($data['query']);
									$data['anterior'] = array();
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
						//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
						*/

						//if ($data['idApp_OrcaTrata'] === FALSE) {
						//if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
						if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('orcatrata/form_orcatrataalterarstatus', $data);
						} else {

							//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
							//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
							/*
							if($data['orcatrata']['idApp_Cliente'] == 0 || $data['orcatrata']['idApp_Cliente'] == 1 || $data['orcatrata']['idApp_Cliente'] == 150001 || $_SESSION['log']['idSis_Empresa'] == 5){
								redirect(base_url() . 'pedidos/pedidos/' . $data['msg']);
							}else{
								//redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
								redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
							}
							*/
							
							unset($_SESSION['Orcatrata'], $_SESSION['ClientePet'], $_SESSION['ClienteDep'], $_SESSION['Orcatratas'], $_SESSION['Consultas_orca']);
							
							redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
						
							exit();
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }
		
    public function cadastrardesp() {

		$acesso = FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$acesso = TRUE;
		}else{
			if($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Usuario']['Nivel'] != 2 && $_SESSION['Usuario']['Usu_Des'] == "S"){
				$acesso = TRUE;
			}	
		}
		
		if($acesso === FALSE){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 3)
				$data['msg'] = $this->basico->msg('<strong>N�o � poss�vel salvar a Nova Despesa.<br>N�o identificamos o pagamento da sua �ltima Fatura.<br>Por favor, Entre em contato com a administra��o da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
			else
				$data['msg'] = '';
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'ConcluidoProduto',
				'QuitadoParcelas',
				'Cadastrar',
				'AtualizaEndereco',
				'StatusProdutos',
				'StatusParcelas',
				'Valor_S_Desc',
				'Valor_C_Desc',
				'UsarC',
				'UsarD',
				'UsarE',
				'ValidaCupom',
				'MensagemCupom',
				'CodigoCupom',
			), TRUE));
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			$data['orcatrata'] = quotes_to_entities($this->input->post(array(
				#### App_OrcaTrata ####
				//'idApp_OrcaTrata',
				'Tipo_Orca',
				'idApp_Fornecedor',
				'id_Funcionario',
				'DataOrca',
				'HoraOrca',
				'TipoFinanceiro',
				'Descricao',
				'AprovadoOrca',
				'ConcluidoOrca',
				'BrindeOrca',
				'DevolvidoOrca',
				'ProntoOrca',
				'QuitadoOrca',
				'ValorOrca',
				//'ValorComissao',
				'ValorDev',
				'QtdPrdOrca',
				'QtdSrvOrca',
				'PrazoProdutos',
				'PrazoServicos',
				'PrazoProdServ',
				'PrazoCorreios',
				'ValorDinheiro',
				'ValorTroco',
				'ValorRestanteOrca',
				'FormaPagamento',
				'Modalidade',
				'QtdParcelasOrca',
				'DataVencimentoOrca',
				'ObsOrca',
				'Consideracoes',
				'idTab_TipoRD',
				'AVAP',
				'EnviadoOrca',
				'Cep',
				'Logradouro',
				'Numero',
				'Complemento',
				'Bairro',
				'Cidade',
				'Estado',
				'Referencia',
				'TipoFrete',
				'ValorFrete',
				'ValorExtraOrca',
				'PercExtraOrca',
				'ValorSomaOrca',
				'CombinadoFrete',
				'PrazoEntrega',
				'ValorTotalOrca',
				'FinalizadoOrca',
				'Entregador',
				'DataEntregaOrca',
				'HoraEntregaOrca',
				'NomeRec',
				'TelefoneRec',
				'ParentescoRec',
				'ObsEntrega',
				'Aux1Entrega',
				'Aux2Entrega',
				'DetalhadaEntrega',
				'CanceladoOrca',
				'Cli_Forn_Orca',
				'Func_Orca',
				'Prd_Srv_Orca',
				'Entrega_Orca',
				'TipoDescOrca',
				'TipoExtraOrca',
				'DescPercOrca',
				'DescValorOrca',
				'CashBackOrca',
				'ValidadeCashBackOrca',
				'UsarCashBack',
				'UsarCupom',
				'Cupom',
				'SubValorFinal',
				'ValorFinalOrca',
			), TRUE));
			
			$data['fornecedor'] = $this->input->post(array(
				'idApp_Fornecedor',
				'CepFornecedor',
				'EnderecoFornecedor',
				'NumeroFornecedor',
				'ComplementoFornecedor',
				'CidadeFornecedor',
				'BairroFornecedor',
				'MunicipioFornecedor',
				'EstadoFornecedor',
				'ReferenciaFornecedor',
			), TRUE);

			$caracteres_sem_acento = array(
				'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
				'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
				'�'=>'I', '�'=>'N', 'N'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
				'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
				'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
				'�'=>'i', '�'=>'o', '�'=>'n', 'n'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
				'�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f',
				'a'=>'a', '�'=>'i', '�'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', '�'=>'I', '�'=>'A', '?'=>'S', '?'=>'T',
			);

			$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Logradouro'], $caracteres_sem_acento));

			$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['orcatrata']['Cep'], $caracteres_sem_acento));

			$numero1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Numero'], $caracteres_sem_acento));

			$complemento1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Complemento'], $caracteres_sem_acento));

			$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Bairro'], $caracteres_sem_acento));

			$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Cidade'], $caracteres_sem_acento));

			$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Estado'], $caracteres_sem_acento));

			$referencia1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Referencia'], $caracteres_sem_acento));
					
			//D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
			//comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

			(isset($_SESSION['Usuario']['Bx_Pag']) && $_SESSION['Usuario']['Bx_Pag'] == "S") ? $data['div']['Prof_comissao'] = '' : $data['div']['Prof_comissao'] = 'style="display: none;"';		
			
			(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
			(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
			(!$this->input->post('P2Count')) ? $data['count']['P2Count'] = 0 : $data['count']['P2Count'] = $this->input->post('P2Count');
			(!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');

			//Data de hoje como default
			$data['orcatrata']['Tipo_Orca'] = "B";
			(!$data['orcatrata']['idApp_Fornecedor']) ? $data['orcatrata']['idApp_Fornecedor'] = '0' : FALSE;
			(!$data['orcatrata']['id_Funcionario']) ? $data['orcatrata']['id_Funcionario'] = '0' : FALSE;
			if($_SESSION['log']['idSis_Empresa'] != 5){
				(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
				(!$data['orcatrata']['Func_Orca']) ? $data['orcatrata']['Func_Orca'] = 'S' : FALSE;
				(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;
				(!$data['orcatrata']['Entrega_Orca']) ? $data['orcatrata']['Entrega_Orca'] = 'S' : FALSE;
			}else{
				$data['orcatrata']['Cli_Forn_Orca'] = 'N';
				$data['orcatrata']['Func_Orca'] = 'N';
				$data['orcatrata']['Prd_Srv_Orca'] = 'N';
				$data['orcatrata']['Entrega_Orca'] = 'N';
			}
			(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['HoraOrca']) ? $data['orcatrata']['HoraOrca'] = date('H:i:s', time()) : FALSE;
			(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
			(!$data['orcatrata']['DataVencimentoOrca']) ? $data['orcatrata']['DataVencimentoOrca'] = date('d/m/Y', time()) : FALSE;
			#(!$data['orcatrata']['DataPrazo']) ? $data['orcatrata']['DataPrazo'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
			(!$data['orcatrata']['ValorOrca']) ? $data['orcatrata']['ValorOrca'] = '0.00' : FALSE;
			//(!$data['orcatrata']['ValorComissao']) ? $data['orcatrata']['ValorComissao'] = '0.00' : FALSE;
			(!$data['orcatrata']['QtdPrdOrca']) ? $data['orcatrata']['QtdPrdOrca'] = '0' : FALSE;
			(!$data['orcatrata']['QtdSrvOrca']) ? $data['orcatrata']['QtdSrvOrca'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoProdutos']) ? $data['orcatrata']['PrazoProdutos'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoServicos']) ? $data['orcatrata']['PrazoServicos'] = '0' : FALSE;
			(!$data['orcatrata']['ValorDev']) ? $data['orcatrata']['ValorDev'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorExtraOrca']) ? $data['orcatrata']['ValorExtraOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorRestanteOrca']) ? $data['orcatrata']['ValorRestanteOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorSomaOrca']) ? $data['orcatrata']['ValorSomaOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['PercExtraOrca']) ? $data['orcatrata']['PercExtraOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['DescPercOrca']) ? $data['orcatrata']['DescPercOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['DescValorOrca']) ? $data['orcatrata']['DescValorOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['CashBackOrca']) ? $data['orcatrata']['CashBackOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValidadeCashBackOrca']) ? $data['orcatrata']['ValidadeCashBackOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['SubValorFinal']) ? $data['orcatrata']['SubValorFinal'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorFinalOrca']) ? $data['orcatrata']['ValorFinalOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorFrete']) ? $data['orcatrata']['ValorFrete'] = '0.00' : FALSE;
			(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
			(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
			(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
			(!$data['orcatrata']['Entregador']) ? $data['orcatrata']['Entregador'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoCorreios']) ? $data['orcatrata']['PrazoCorreios'] = '0' : FALSE;
			(!$data['orcatrata']['ValorDinheiro']) ? $data['orcatrata']['ValorDinheiro'] = '0.00' : FALSE;
			(!$data['orcatrata']['PrazoProdServ']) ? $data['orcatrata']['PrazoProdServ'] = '0' : FALSE;
			(!$data['orcatrata']['TipoDescOrca']) ? $data['orcatrata']['TipoDescOrca'] = 'V' : FALSE;
			(!$data['orcatrata']['TipoExtraOrca']) ? $data['orcatrata']['TipoExtraOrca'] = 'V' : FALSE; 
			(!$data['orcatrata']['UsarCashBack']) ? $data['orcatrata']['UsarCashBack'] = 'N' : FALSE;
			(!$data['orcatrata']['UsarCupom']) ? $data['orcatrata']['UsarCupom'] = 'N' : FALSE;
			(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
			if($_SESSION['log']['idSis_Empresa'] == 5){
				(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'S' : FALSE;
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'S' : FALSE;			
			}else{
				(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;		
			}
			(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
			(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;
			
			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
			(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusProdutos']) ? $data['cadastrar']['StatusProdutos'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusParcelas']) ? $data['cadastrar']['StatusParcelas'] = 'N' : FALSE;
			(!$data['cadastrar']['ValidaCupom']) ? $data['cadastrar']['ValidaCupom'] = '0' : FALSE;
			
			/*
			$j = 1;
			for ($i = 1; $i <= $data['count']['SCount']; $i++) {

				if ($this->input->post('idTab_Servico' . $i)) {
					$data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
					$data['servico'][$j]['idTab_Valor_Servico'] = $this->input->post('idTab_Valor_Servico' . $i);
					$data['servico'][$j]['idTab_Produtos_Servico'] = $this->input->post('idTab_Produtos_Servico' . $i);
					$data['servico'][$j]['Prod_Serv_Servico'] = $this->input->post('Prod_Serv_Servico' . $i);
					$data['servico'][$j]['NomeServico'] = $this->input->post('NomeServico' . $i);
					$data['servico'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
					$data['servico'][$j]['ValorServico'] = $this->input->post('ValorServico' . $i);
					$data['servico'][$j]['QtdServico'] = $this->input->post('QtdServico' . $i);
					$data['servico'][$j]['QtdIncrementoServico'] = $this->input->post('QtdIncrementoServico' . $i);
					$data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
					$data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
					$data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
					$data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
					$data['servico'][$j]['ProfissionalServico_1'] = $this->input->post('ProfissionalServico_1' . $i);
					$j++;
				}

			}
			$data['count']['SCount'] = $j - 1;
			*/
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['SCount']; $i++) {

				if ($this->input->post('idTab_Servico' . $i)) {
					$data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
					//$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
					$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
					$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
					$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
					//$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
					//$data['servico'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoServico' . $i);
					//$data['servico'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackServico' . $i);
					$data['servico'][$j]['PrazoProduto'] = $this->input->post('PrazoServico' . $i);
					$data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
					$data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
					$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
					$data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
					//$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
					//$data['servico'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoServico' . $i);
					//$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackServico' . $i);
					$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
					$data['servico'][$j]['ValorComissaoServico'] = $this->input->post('ValorComissaoServico' . $i);
					$data['servico'][$j]['ObsProduto'] = $this->input->post('ObsServico' . $i);
					$data['servico'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeServico' . $i);
					$data['servico'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoServico' . $i);
					$data['servico'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoServico' . $i);
					$data['servico'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoServico' . $i);
					
					$data['servico'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalServico_1' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
					}				
					$data['servico'][$j]['ProfissionalProduto_2'] = $this->input->post('ProfissionalServico_2' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_3'] = $this->input->post('ProfissionalServico_3' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_4'] = $this->input->post('ProfissionalServico_4' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_5'] = $this->input->post('ProfissionalServico_5' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_6'] = $this->input->post('ProfissionalServico_6' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
					}

					$data['servico'][$j]['idTFProf_1'] = $this->input->post('idTFProf_Servico_1' . $i);
					$data['servico'][$j]['ComFunProf_1'] = $this->input->post('ComFunProf_Servico_1' . $i);
					$data['servico'][$j]['ValorComProf_1'] = $this->input->post('ValorComProf_Servico_1' . $i);
					
					$data['servico'][$j]['idTFProf_2'] = $this->input->post('idTFProf_Servico_2' . $i);
					$data['servico'][$j]['ComFunProf_2'] = $this->input->post('ComFunProf_Servico_2' . $i);
					$data['servico'][$j]['ValorComProf_2'] = $this->input->post('ValorComProf_Servico_2' . $i);
					
					$data['servico'][$j]['idTFProf_3'] = $this->input->post('idTFProf_Servico_3' . $i);
					$data['servico'][$j]['ComFunProf_3'] = $this->input->post('ComFunProf_Servico_3' . $i);
					$data['servico'][$j]['ValorComProf_3'] = $this->input->post('ValorComProf_Servico_3' . $i);
					
					$data['servico'][$j]['idTFProf_4'] = $this->input->post('idTFProf_Servico_4' . $i);
					$data['servico'][$j]['ComFunProf_4'] = $this->input->post('ComFunProf_Servico_4' . $i);
					$data['servico'][$j]['ValorComProf_4'] = $this->input->post('ValorComProf_Servico_4' . $i);
					
					$data['servico'][$j]['idTFProf_5'] = $this->input->post('idTFProf_Servico_5' . $i);
					$data['servico'][$j]['ComFunProf_5'] = $this->input->post('ComFunProf_Servico_5' . $i);
					$data['servico'][$j]['ValorComProf_5'] = $this->input->post('ValorComProf_Servico_5' . $i);
					
					$data['servico'][$j]['idTFProf_6'] = $this->input->post('idTFProf_Servico_6' . $i);
					$data['servico'][$j]['ComFunProf_6'] = $this->input->post('ComFunProf_Servico_6' . $i);
					$data['servico'][$j]['ValorComProf_6'] = $this->input->post('ValorComProf_Servico_6' . $i);
					
					(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
					);
					($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';
					
					$j++;
				}

			}
			$data['count']['SCount'] = $j - 1;		

			$j = 1;
			for ($i = 1; $i <= $data['count']['PCount']; $i++) {
				
				if ($this->input->post('idTab_Produto' . $i)) {
					$data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
					//$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
					$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
					$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
					//$data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
					//$data['produto'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoProduto' . $i);
					//$data['produto'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackProduto' . $i);
					$data['produto'][$j]['PrazoProduto'] = $this->input->post('PrazoProduto' . $i);
					$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
					$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
					$data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
					$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
					$data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
					//$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
					//$data['produto'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoProduto' . $i);
					//$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackProduto' . $i);
					$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
					$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
					$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
					$data['produto'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoProduto' . $i);
					$data['produto'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoProduto' . $i);
					$data['produto'][$j]['Aux_App_Produto_1'] = $this->input->post('Aux_App_Produto_1' . $i);
					$data['produto'][$j]['Aux_App_Produto_2'] = $this->input->post('Aux_App_Produto_2' . $i);
					$data['produto'][$j]['Aux_App_Produto_3'] = $this->input->post('Aux_App_Produto_3' . $i);
					$data['produto'][$j]['Aux_App_Produto_4'] = $this->input->post('Aux_App_Produto_4' . $i);
					$data['produto'][$j]['Aux_App_Produto_5'] = $this->input->post('Aux_App_Produto_5' . $i);
					$data['produto'][$j]['HoraValidadeProduto'] = $this->input->post('HoraValidadeProduto' . $i);				
					$data['produto'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoProduto' . $i);
					$data['produto'][$j]['DevolvidoProduto'] = $this->input->post('DevolvidoProduto' . $i);
					$data['produto'][$j]['CanceladoProduto'] = $this->input->post('CanceladoProduto' . $i);
					//$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					//$data['produto'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalProduto_1' . $i);
					
					(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
					);
					($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';
					
					$j++;
				}
			}
			$data['count']['PCount'] = $j - 1;

			$j = 1;
			for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

				if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataConcluidoProcedimento' . $i) ||
					$this->input->post('Profissional' . $i) || $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
					$data['procedimento'][$j]['idApp_Procedimento'] = $this->input->post('idApp_Procedimento' . $i);
					$data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
					$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->input->post('DataConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['HoraProcedimento'] = $this->input->post('HoraProcedimento' . $i);
					$data['procedimento'][$j]['HoraConcluidoProcedimento'] = $this->input->post('HoraConcluidoProcedimento' . $i);				
					#$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
					//$data['procedimento'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
					$data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
					$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					$data['procedimento'][$j]['Compartilhar'] = $this->input->post('Compartilhar' . $i);
					
					(!$data['procedimento'][$j]['ConcluidoProcedimento']) ? $data['procedimento'][$j]['ConcluidoProcedimento'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
					);
					($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';	

					$j++;
				}

			}
			$data['count']['PMCount'] = $j - 1;

			//$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorFinalOrca']);
			$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
			$data['valortotalorca'] = floatval ($data['valortotalorca']);
			
			$data['somatotal'] = 0;
			
			if ($data['valortotalorca'] > 0.00 && $data['orcatrata']['QtdParcelasOrca'] >=1) {
				
				for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

					$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
					$data['somatotal'] += $data['valoredit'][$i];
					
					if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) || $this->input->post('DataVencimento' . $i)){
						$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
						$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
						$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
						//$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
						$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
						$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
						$data['parcelasrec'][$i]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
					}
					(!$data['parcelasrec'][$i]['Quitado']) ? $data['parcelasrec'][$i]['Quitado'] = 'N' : FALSE;
					$data['radio'] = array(
						'Quitado' . $i => $this->basico->radio_checked($data['parcelasrec'][$i]['Quitado'], 'Quitado' . $i, 'NS'),
					);
					($data['parcelasrec'][$i]['Quitado'] == 'S') ? $data['div']['Quitado' . $i] = '' : $data['div']['Quitado' . $i] = 'style="display: none;"';
				}
				
			}
			
			
			/*
			if ($data['orcatrata']['ValorTotalOrca'] > 0 ) {

				for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {
					
					if ($this->input->post('ValorParcela' . $i) > 0 && $this->input->post('ValorParcela' . $i) != ''){
						$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
						$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
						$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
						$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
						$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
						$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
						$data['parcelasrec'][$i]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
					}
				}

			}
			*/
			//Fim do trecho de c�digo que d� pra melhorar

			$data['select']['TipoDescOrca'] = array (
				'P' => '.%',
				'V' => 'R$',
			);		
			$data['select']['TipoExtraOrca'] = array (
				'P' => '.%',
				'V' => 'R$',
			);			
			$data['select']['UsarCashBack'] = $this->Basico_model->select_status_sn();
			$data['select']['UsarCupom'] = $this->Basico_model->select_status_sn();
			$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
			$data['select']['StatusProdutos'] = $this->Basico_model->select_status_sn();
			$data['select']['StatusParcelas'] = $this->Basico_model->select_status_sn();
			$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
			$data['select']['Func_Orca'] = $this->Basico_model->select_status_sn();
			$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
			$data['select']['Entrega_Orca'] = $this->Basico_model->select_status_sn();
			$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
			$data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
			$data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroD();
			$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
			$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
			$data['select']['FormaPagamentoParcela'] = $this->Formapag_model->select_formapag();
			$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['DevolvidoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['ProntoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
			$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
			$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
			$data['select']['CanceladoProduto'] = $this->Basico_model->select_status_sn();
			$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
			$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
			$data['select']['TipoFrete'] = $this->Basico_model->select_tipofrete();
			$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
			$data['select']['Quitado'] = $this->Basico_model->select_status_sn();
			$data['select']['id_Funcionario'] = $this->Usuario_model->select_usuario();
			$data['select']['idApp_Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
			$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
			$data['select']['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
			$data['select']['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
			$data['select']['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
			$data['select']['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
			$data['select']['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
			$data['select']['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
			//$data['select']['ProfissionalProduto_1'] = $this->Usuario_model->select_usuario();
			$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
			$data['select']['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos();
			$data['select']['Entregador'] = $this->Usuario_model->select_usuario_entregador();
			$data['select']['Produto'] = $this->Basico_model->select_produto2();
			$data['select']['Servico'] = $this->Basico_model->select_servico2();
			#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
			$data['select']['AVAP'] = $this->Basico_model->select_avap();
			$data['select']['Prioridade'] = array (
				'1' => 'Alta',
				'2' => 'M�dia',
				'3' => 'Baixa',
			);
			
			$data['titulo'] = 'Nova Despesa';
			$data['form_open_path'] = 'orcatrata/cadastrardesp';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'danger';
			$data['metodo'] = 1;
			$data['caminho'] = '../';
			$data['Recorrencias'] = 1;
			$data['Recorrencias_outras'] = $data['Recorrencias'] - 1;
			
			$data['exibirExtraOrca'] = 1;
			$data['exibirDescOrca'] = 1;		
			
			$data['exibir_id'] = 1;
			if($_SESSION['log']['idSis_Empresa'] == 5){
				$data['AtivoCashBack'] = 'N';
			}else{
				$data['AtivoCashBack'] = 'S';
			}		
			
			$data['vinculadas'] = 0;
			if ($data['vinculadas'] > 0){
				$data['textoEntregues'] = '';
				$data['textoPagas'] = '';
			}else{
				$data['textoEntregues'] = 'style="display: none;"';
				$data['textoPagas'] = 'style="display: none;"';
			}

			$data['collapse'] = '';	
			$data['collapse1'] = 'class="collapse"';
			
			$data['tipofinan1'] = '1';

			$data['tipofinan12'] = '12';			
			
			if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorRestanteOrca'])
				$data['orcamentoin'] = 'in';
			else
				$data['orcamentoin'] = '';

			if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
				$data['parcelasin'] = 'in';
			else
				$data['parcelasin'] = '';

			//if ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional'])
			if (isset($data['procedimento']))
				$data['tratamentosin'] = 'in';
			else
				$data['tratamentosin'] = '';
			
			if ($_SESSION['log']['NivelEmpresa'] >= '4' )
				$data['visivel'] = '';
			else
				$data['visivel'] = 'style="display: none;"';

			($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
			
			($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
			
			/*
			$data['radio'] = array(
				'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
			);
			($data['orcatrata']['AVAP'] == 'P') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';	        
			*/
			
			$data['radio'] = array(
				'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
			);
			($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';		

			$data['radio'] = array(
				'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
			);
			($data['cadastrar']['Cadastrar'] == 'N') ?
				$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
			
			$data['radio'] = array(
				'StatusProdutos' => $this->basico->radio_checked($data['cadastrar']['StatusProdutos'], 'StatusProdutos', 'NS'),
			);
			($data['cadastrar']['StatusProdutos'] == 'S') ?
				$data['div']['StatusProdutos'] = '' : $data['div']['StatusProdutos'] = 'style="display: none;"';		
			
			$data['radio'] = array(
				'StatusParcelas' => $this->basico->radio_checked($data['cadastrar']['StatusParcelas'], 'StatusParcelas', 'NS'),
			);
			($data['cadastrar']['StatusParcelas'] == 'S') ?
				$data['div']['StatusParcelas'] = '' : $data['div']['StatusParcelas'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
			);
			($data['orcatrata']['CombinadoFrete'] == 'S') ?
				$data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
			);
			($data['orcatrata']['EnviadoOrca'] == 'S') ?
				$data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
			);
			($data['orcatrata']['AprovadoOrca'] == 'S') ?
				$data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';

				
			$data['radio'] = array(
				'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
			);
			($data['orcatrata']['ConcluidoOrca'] == 'N') ?
				$data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

				
			$data['radio'] = array(
				'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
			);
			($data['orcatrata']['BrindeOrca'] == 'N') ?
				$data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';
				
			$data['radio'] = array(
				'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
			);
			($data['cadastrar']['AtualizaEndereco'] == 'N') ?
				$data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	

				
			$data['radio'] = array(
				'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Prontos p/Entrega', 'NS'),
			);
			($data['orcatrata']['ProntoOrca'] == 'S') ?
				$data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';

			$data['radio'] = array(
				'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
			);
			($data['orcatrata']['DevolvidoOrca'] == 'S') ?
				$data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';
				
			$data['radio'] = array(
				'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
			);
			($data['orcatrata']['QuitadoOrca'] == 'S') ?
				$data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
				
			$data['radio'] = array(
				'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Finalizado', 'NS'),
			);
			($data['orcatrata']['FinalizadoOrca'] == 'N') ?
				$data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Or�amento Cancelado', 'NS'),
			);
			($data['orcatrata']['CanceladoOrca'] == 'N') ?
				$data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
			);
			($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
				$data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'Func_Orca' => $this->basico->radio_checked($data['orcatrata']['Func_Orca'], 'Colaborador', 'NS'),
			);
			($data['orcatrata']['Func_Orca'] == 'S') ?
				$data['div']['Func_Orca'] = '' : $data['div']['Func_Orca'] = 'style="display: none;"';
			
			
			$data['radio'] = array(
				'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
			);
			($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
				$data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'Entrega_Orca' => $this->basico->radio_checked($data['orcatrata']['Entrega_Orca'], 'Entrega', 'NS'),
			);
			($data['orcatrata']['Entrega_Orca'] == 'S') ?
				$data['div']['Entrega_Orca'] = '' : $data['div']['Entrega_Orca'] = 'style="display: none;"';
				
			
			$data['radio'] = array(
				'UsarCashBack' => $this->basico->radio_checked($data['orcatrata']['UsarCashBack'], 'UsarCashBack', 'NS'),
			);
			($data['orcatrata']['UsarCashBack'] == 'S') ?
				$data['div']['UsarCashBack'] = '' : $data['div']['UsarCashBack'] = 'style="display: none;"';		
			
			$data['radio'] = array(
				'UsarCupom' => $this->basico->radio_checked($data['orcatrata']['UsarCupom'], 'UsarCupom', 'NS'),
			);
			($data['orcatrata']['UsarCupom'] == 'S') ?
				$data['div']['UsarCupom'] = '' : $data['div']['UsarCupom'] = 'style="display: none;"';		
						
			#Ver uma solu��o melhor para este campo
			#(!$data['orcatrata']['TipoFinanceiro']) ? $data['orcatrata']['TipoFinanceiro'] = '1' : FALSE;
	/*
			$data['radio'] = array(
				'TipoFinanceiro' => $this->basico->radio_checked($data['orcatrata']['TipoFinanceiro'], 'Tarefa Aprovado', 'NS'),
			);

			($data['orcatrata']['TipoFinanceiro'] == '1') ? $data['div']['TipoFinanceiro'] = '' : $data['div']['TipoFinanceiro'] = 'style="display: none;"';			
	*/
			$data['sidebar'] = 'col-sm-3 col-md-2';
			$data['main'] = 'col-sm-7 col-md-8';

			$data['datepicker'] = 'DatePicker';
			$data['timepicker'] = 'TimePicker';

			#$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data);
			  echo "</pre>";
			  exit ();
			  */
			

			$data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
			/*	 
			echo '<br>';
			echo "<pre>";
			print_r($_SESSION['Empresa']['CepEmpresa']);
			echo "</pre>";
			exit ();
			*/
			
			$data['somatotal'] = floatval ($data['somatotal']);
			$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];
			
			$epsilon = 0.001;

			if(abs($data['diferenca']) < $epsilon){
				$data['diferenca'] = 0.00;
			}else{
				$data['diferenca'] = $data['diferenca'];
			}
			
			$data['diferenca'] = floatval ($data['diferenca']);		
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			#### App_OrcaTrata ####
			
			if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
				if($data['diferenca'] < 0.00){
					$data['diferenca'] = number_format($data['diferenca'],2,",",".");
					//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
					$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
				}elseif($data['diferenca'] > 0.00){
					$data['diferenca'] = number_format($data['diferenca'],2,",",".");
					//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
					$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
				}
			}
			if ($data['valortotalorca'] <= 0.00 ) {
				$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
			}
			
			if ($_SESSION['log']['NivelEmpresa'] >= '4' && $data['orcatrata']['Cli_Forn_Orca'] == "S") {
				$this->form_validation->set_rules('idApp_Fornecedor', 'Fornecedor', 'required|trim');
				$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');
			} else {
				$data['cadastrar']['Cadastrar'] = 'S';
			}
			
			if ($_SESSION['log']['NivelEmpresa'] >= '4' && $data['orcatrata']['Func_Orca'] == "S") {
				$this->form_validation->set_rules('id_Funcionario', 'Colaborador', 'required|trim');
			}
			$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
			$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
			$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
			if ($_SESSION['log']['NivelEmpresa'] >= '4') {
				$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
			}
			$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
			$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');	        
			
			#run form validation
			if ($this->form_validation->run() === FALSE) {
				//if (1 == 1) {
				$this->load->view('orcatrata/form_orcatratadesp', $data);
			} else {

				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'orcatrata/cadastrardesp' . $data['msg']);

				} else {
			
					$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
					$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
					$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
					$data['cadastrar']['AtualizaEndereco'] = $data['cadastrar']['AtualizaEndereco'];
					
					////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
					#### App_OrcaTrata ####
						/*
						$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
						$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
						$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
						$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
						$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
						$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
						$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
						$data['orcatrata']['Referencia'] = '';
						*/
						$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
						$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
						$data['orcatrata']['Numero'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
						$data['orcatrata']['Complemento'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
						$data['orcatrata']['Bairro'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
						$data['orcatrata']['Cidade'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
						$data['orcatrata']['Estado'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
						$data['orcatrata']['Referencia'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
					
					$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
					$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
					$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
					$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
					$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));
					$data['orcatrata']['TipoFinanceiro'] = $data['orcatrata']['TipoFinanceiro'];
					$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
					$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
					//$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
					//$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
					//$data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
					//$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
					$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
					$data['orcatrata']['Tipo_Orca'] = "B";
					
					if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
					} 
					if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
					} 
					if($data['orcatrata']['ConcluidoOrca'] == 'S'){
						$data['orcatrata']['CombinadoFrete'] = "S";
					} 
					if($data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
					} 
					if ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
						$data['orcatrata']['EnviadoOrca'] = "S";
					}
					
					$data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
					//$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
					$data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
					//$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
					//$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
					$data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
					if($data['orcatrata']['FormaPagamento'] == "7"){
						$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
						$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
					}else{
						$data['orcatrata']['ValorDinheiro'] = 0.00;
						$data['orcatrata']['ValorTroco'] = 0.00;
					}
					$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
					$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
					$data['orcatrata']['PercExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['PercExtraOrca']));
					$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
					$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
					
					$data['orcatrata']['DescPercOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescPercOrca']));
					$data['orcatrata']['DescValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescValorOrca']));
					$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
					$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'mysql');
					if(isset($data['orcatrata']['ValidadeCashBackOrca']) && $data['orcatrata']['ValidadeCashBackOrca'] != "0000-00-00" && $data['orcatrata']['ValidadeCashBackOrca'] != ""){
						$data['orcatrata']['ValidadeCashBackOrca'] = $data['orcatrata']['ValidadeCashBackOrca'];
					}else{
						$data['orcatrata']['ValidadeCashBackOrca'] = "0000-00-00";
					}
					$data['CashBackAtual'] = $data['orcatrata']['CashBackOrca'];
					$data['ValidadeAtual'] = $data['orcatrata']['ValidadeCashBackOrca'];
					if($data['orcatrata']['UsarCashBack'] == "N"){
						$data['orcatrata']['CashBackOrca'] = 0.00;
						$data['orcatrata']['ValidadeCashBackOrca'] = "0000-00-00";
					}
					/*
					if($data['orcatrata']['UsarCashBack'] == "S"){
						$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
					}else{
						$data['orcatrata']['CashBackOrca'] = 0.00;
					}
					*/
					$data['orcatrata']['ValorFinalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
					$data['orcatrata']['SubValorFinal'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['SubValorFinal']));
					$data['orcatrata']['idTab_TipoRD'] = "1";
					/*
					if($_SESSION['Usuario']['Nivel'] == 2){
						$data['orcatrata']['NivelOrca'] = 2;
					}else{
						$data['orcatrata']['NivelOrca'] = 1;
					}
					*/
					$data['orcatrata']['NivelOrca'] = 0;		
					
					$data['orcatrata']['idSis_Empresa'] 	= $_SESSION['log']['idSis_Empresa']; 
					$data['orcatrata']['idSis_Usuario'] 	= $_SESSION['log']['idSis_Usuario'];
					$data['orcatrata']['id_Funcionario'] 	= $_SESSION['log']['idSis_Usuario'];
					$data['orcatrata']['id_Associado'] 		= 0;
					$data['orcatrata']['idTab_Modulo'] 		= $_SESSION['log']['idTab_Modulo'];

					if($data['orcatrata']['Entrega_Orca'] == "N"){
						$data['orcatrata']['DataEntregaOrca'] = $data['orcatrata']['DataOrca'];
						$data['orcatrata']['HoraEntregaOrca'] = "00:00:00";
						$data['orcatrata']['PrazoProdServ'] = 0;
						$data['orcatrata']['PrazoCorreios'] = 0;
						$data['orcatrata']['PrazoEntrega'] = 0;
					}
					
					if (!$data['orcatrata']['PrazoEntrega']){
						//$data1 = date('Y-m-d', time());
						$data1 = $data['orcatrata']['DataOrca'];
						$data2 = $data['orcatrata']['DataEntregaOrca'];
						$intervalo = strtotime($data2)-strtotime($data1); 
						$dias = floor($intervalo / (60 * 60 * 24));
						$data['orcatrata']['PrazoEntrega'] = $dias;
					}
					
					if($data['orcatrata']['UsarCupom'] == "S"){
						$data['orcatrata']['TipoDescOrca'] = $data['cadastrar']['UsarE'];
						if($data['cadastrar']['ValidaCupom'] == 0 || !$data['orcatrata']['Cupom'] || empty($data['orcatrata']['Cupom'])){
							$data['orcatrata']['Cupom'] = 0;
						}
					}else{
						$data['orcatrata']['Cupom'] = 0;
					}

					### Na despesa, n�o preciso pegar o Valor da Comiss�o do Funcion�rio ###
					$data['orcatrata']['ComissaoFunc'] = 0;
					$data['orcatrata']['ValorComissaoFunc'] = 0;
					$data['orcatrata']['ValorComissaoAssoc'] = 0;

					$data['orcatrata']['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['orcatrata']);
					
					if ($data['orcatrata']['idApp_OrcaTrata'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('orcatrata/form_orcatratadesp', $data);
					} else {			

						#### APP_Fornecedor ####
						if ($data['cadastrar']['AtualizaEndereco'] == 'S' && $data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['idApp_Fornecedor'] != 0){
							$data['fornecedor']['CepFornecedor'] = $data['orcatrata']['Cep'];
							$data['fornecedor']['EnderecoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
							$data['fornecedor']['NumeroFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
							$data['fornecedor']['ComplementoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
							$data['fornecedor']['BairroFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
							$data['fornecedor']['CidadeFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
							$data['fornecedor']['EstadoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
							$data['fornecedor']['ReferenciaFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
										
							$data['update']['fornecedor']['anterior'] = $this->Orcatrata_model->get_fornecedor($data['orcatrata']['idApp_Fornecedor']);
							$data['update']['fornecedor']['campos'] = array_keys($data['fornecedor']);
							/*
							$data['update']['fornecedor']['auditoriaitem'] = $this->basico->set_log(
								$data['update']['fornecedor']['anterior'],
								$data['fornecedor'],
								$data['update']['fornecedor']['campos'],
								$data['fornecedor']['idApp_Fornecedor'], TRUE);
							*/	
							$data['update']['fornecedor']['bd'] = $this->Orcatrata_model->update_fornecedor($data['fornecedor'], $data['orcatrata']['idApp_Fornecedor']);
							
							/*
							// ""ver modo correto de fazer o set_log e set_auditoria""
							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Fornecedor', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}
							*/
							
						}
						
						/*
						//echo count($data['servico']);
						echo '<br>';
						echo "<pre>";
						print_r($data['fornecedor']);
						echo "</pre>";
						exit ();
						*/
						
						#### App_Servico ####
						if (isset($data['servico'])) {
							$max = count($data['servico']);
							for($j=1;$j<=$max;$j++) {
								
								$data['servico'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['servico'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['servico'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['servico'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
								$data['servico'][$j]['idTab_TipoRD'] = "1";
								//$data['servico'][$j]['NivelProduto'] = $_SESSION['Usuario']['Nivel'];
								$data['servico'][$j]['NivelProduto'] = 0;

								if(!$data['servico'][$j]['ProfissionalProduto_1']){
									$data['servico'][$j]['ProfissionalProduto_1'] = 0;
								}
								if(!$data['servico'][$j]['ProfissionalProduto_2']){
									$data['servico'][$j]['ProfissionalProduto_2'] = 0;
								}
								if(!$data['servico'][$j]['ProfissionalProduto_3']){
									$data['servico'][$j]['ProfissionalProduto_3'] = 0;
								}
								if(!$data['servico'][$j]['ProfissionalProduto_4']){
									$data['servico'][$j]['ProfissionalProduto_4'] = 0;
								}
								if(!$data['servico'][$j]['ProfissionalProduto_5']){
									$data['servico'][$j]['ProfissionalProduto_5'] = 0;
								}
								if(!$data['servico'][$j]['ProfissionalProduto_6']){
									$data['servico'][$j]['ProfissionalProduto_6'] = 0;
								}
								
								if(empty($data['servico'][$j]['ValorProduto'])){
									$data['servico'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['servico'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorProduto']));
								}						
									
								if(empty($data['servico'][$j]['ValorComProf_1'])){
									$data['servico'][$j]['ValorComProf_1'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_1']));
								}
								
								if(empty($data['servico'][$j]['ValorComProf_2'])){
									$data['servico'][$j]['ValorComProf_2'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_2']));
								}
								
								if(empty($data['servico'][$j]['ValorComProf_3'])){
									$data['servico'][$j]['ValorComProf_3'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_3']));
								}
								
								if(empty($data['servico'][$j]['ValorComProf_4'])){
									$data['servico'][$j]['ValorComProf_4'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_4']));
								}
									
								if(empty($data['servico'][$j]['ValorComProf_5'])){
									$data['servico'][$j]['ValorComProf_5'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_5']));
								}
								
								if(empty($data['servico'][$j]['ValorComProf_6'])){
									$data['servico'][$j]['ValorComProf_6'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComProf_6']));
								}
									
								if(empty($data['servico'][$j]['ValorComissaoServico'])){
									$data['servico'][$j]['ValorComissaoServico'] = "0.00";
								}else{
									$data['servico'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorComissaoServico']));
								}
									
								//$data['servico'][$j]['ValorComissaoVenda'] = $data['servico'][$j]['SubtotalComissaoProduto'];
								//$data['servico'][$j]['ValorComissaoServico'] = $data['servico'][$j]['SubtotalComissaoServicoProduto'];
								//$data['servico'][$j]['ValorComissaoCashBack'] = $data['servico'][$j]['SubtotalComissaoCashBackProduto'];
								/*
								if(!$data['servico'][$j]['ComissaoProduto']){
									$data['servico'][$j]['ComissaoProduto'] = "0.00";
								}
								if(!$data['servico'][$j]['ComissaoServicoProduto']){
									$data['servico'][$j]['ComissaoServicoProduto'] = "0.00";
								}
								if(!$data['servico'][$j]['ComissaoCashBackProduto']){
									$data['servico'][$j]['ComissaoCashBackProduto'] = "0.00";
								}
								*/
								
								if(!$data['servico'][$j]['DataValidadeProduto'] || $data['servico'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['servico'][$j]['DataValidadeProduto'])){
									$data['servico'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'mysql');
								}
																	
								if(!$data['servico'][$j]['DataConcluidoProduto'] || $data['servico'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['servico'][$j]['DataConcluidoProduto'])){
									$data['servico'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['servico'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['servico'][$j]['HoraConcluidoProduto'] || $data['servico'][$j]['HoraConcluidoProduto'] == "00:00"){
									$data['servico'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['servico'][$j]['HoraConcluidoProduto'] = $data['servico'][$j]['HoraConcluidoProduto'];
								}
									
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['servico'][$j]['ConcluidoProduto'] = 'S';
								}else{
									$data['servico'][$j]['ConcluidoProduto'] = $data['servico'][$j]['ConcluidoProduto'];
								}
								/*
								if ($data['servico'][$j]['ConcluidoProduto'] == 'S') {
									if(!$data['servico'][$j]['DataConcluidoProduto']){
										$data['servico'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['servico'][$j]['DataConcluidoProduto'] = $data['servico'][$j]['DataConcluidoProduto'];
									}
									if(!$data['servico'][$j]['HoraConcluidoProduto'] || $data['servico'][$j]['HoraConcluidoProduto'] == "00:00"){
										$data['servico'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
									}else{
										$data['servico'][$j]['HoraConcluidoProduto'] = $data['servico'][$j]['HoraConcluidoProduto'];
									}
								}else{
									$data['servico'][$j]['DataConcluidoProduto'] = "0000-00-00";
									$data['servico'][$j]['HoraConcluidoProduto'] = "00:00";
								}
								*/
								unset($data['servico'][$j]['SubtotalProduto']);
								//unset($data['servico'][$j]['SubtotalComissaoProduto']);
								//unset($data['servico'][$j]['SubtotalComissaoServicoProduto']);
								//unset($data['servico'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['servico'][$j]['SubtotalQtdProduto']);	
							}
							$data['servico']['idApp_Produto'] = $this->Orcatrata_model->set_servico($data['servico']);
						}

						#### App_Produto ####
						if (isset($data['produto'])) {
							$max = count($data['produto']);
							for($j=1;$j<=$max;$j++) {
								
								$data['produto'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['produto'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['produto'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['produto'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
								$data['produto'][$j]['idTab_TipoRD'] = "1";
								//$data['produto'][$j]['NivelProduto'] = $_SESSION['Usuario']['Nivel'];
								$data['produto'][$j]['NivelProduto'] = 0;

								if(empty($data['produto'][$j]['ValorProduto'])){
									$data['produto'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['produto'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorProduto']));
								}
								
								/*
								if(!$data['produto'][$j]['ComissaoProduto']){
									$data['produto'][$j]['ComissaoProduto'] = "0.00";
								}
								if(!$data['produto'][$j]['ComissaoServicoProduto']){
									$data['produto'][$j]['ComissaoServicoProduto'] = "0.00";
								}
								if(!$data['produto'][$j]['ComissaoCashBackProduto']){
									$data['produto'][$j]['ComissaoCashBackProduto'] = "0.00";
								}
								*/
								
								//$data['produto'][$j]['NomeProduto'] = $data['produto'][$j]['NomeProduto'];

								if(!$data['produto'][$j]['DataValidadeProduto'] || $data['produto'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['produto'][$j]['DataValidadeProduto'])){
									$data['produto'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'mysql');
								}
												   
								if(!$data['produto'][$j]['DataConcluidoProduto'] || $data['produto'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['produto'][$j]['DataConcluidoProduto'])){
									$data['produto'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['produto'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['produto'][$j]['HoraConcluidoProduto'] || $data['produto'][$j]['HoraConcluidoProduto'] == "00:00"){
									$data['produto'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['produto'][$j]['HoraConcluidoProduto'] = $data['produto'][$j]['HoraConcluidoProduto'];
								}
									
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') {
									$data['produto'][$j]['ConcluidoProduto'] = 'S';
								}else{
									$data['produto'][$j]['ConcluidoProduto'] = $data['produto'][$j]['ConcluidoProduto'];
								}
								/*
								if ($data['produto'][$j]['ConcluidoProduto'] == 'S') {
									if(!$data['produto'][$j]['DataConcluidoProduto']){
										$data['produto'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
									}else{
										$data['produto'][$j]['DataConcluidoProduto'] = $data['produto'][$j]['DataConcluidoProduto'];
									}
									if(!$data['produto'][$j]['HoraConcluidoProduto'] || $data['produto'][$j]['HoraConcluidoProduto'] == "00:00"){
										$data['produto'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
									}else{
										$data['produto'][$j]['HoraConcluidoProduto'] = $data['produto'][$j]['HoraConcluidoProduto'];
									}
								}else{
									$data['produto'][$j]['DataConcluidoProduto'] = "0000-00-00";
									$data['produto'][$j]['HoraConcluidoProduto'] = "00:00";
								}
								*/
								if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
									$data['produto'][$j]['DevolvidoProduto'] = 'S';
								} else {
									$data['produto'][$j]['DevolvidoProduto'] = $data['produto'][$j]['DevolvidoProduto'];
								}
								
								unset($data['produto'][$j]['SubtotalProduto']);
								//unset($data['produto'][$j]['SubtotalComissaoProduto']);
								//unset($data['produto'][$j]['SubtotalComissaoServicoProduto']);
								//unset($data['produto'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['produto'][$j]['SubtotalQtdProduto']);					
								
							}
							$data['produto']['idApp_Produto'] = $this->Orcatrata_model->set_produto($data['produto']);
						}

						#### App_ParcelasRec ####
						if (isset($data['parcelasrec'])) {
							$max = count($data['parcelasrec']);
							for($j=1;$j<=$max;$j++) {
								$data['parcelasrec'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['parcelasrec'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['parcelasrec'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['parcelasrec'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['parcelasrec'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
								$data['parcelasrec'][$j]['idTab_TipoRD'] = "1";
								//$data['parcelasrec'][$j]['NivelParcela'] = $_SESSION['Usuario']['Nivel'];
								$data['parcelasrec'][$j]['NivelParcela'] = 0;
									
								$data['parcelasrec'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorParcela']));
								//$data['parcelasrec'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorPago']));
								$data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'mysql');					
								$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'mysql');
								if ($data['parcelasrec'][$j]['FormaPagamentoParcela']) {
									$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $data['parcelasrec'][$j]['FormaPagamentoParcela'];
								}else{
									$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
								}
								if ($data['orcatrata']['QuitadoOrca'] == 'S') {
									$data['parcelasrec'][$j]['Quitado'] = 'S';
								} else {
									$data['parcelasrec'][$j]['Quitado'] = $data['parcelasrec'][$j]['Quitado'];
								}
								if ($data['parcelasrec'][$j]['Quitado'] == 'S') {
									if (!$data['parcelasrec'][$j]['DataPago']){
										$data['parcelasrec'][$j]['DataPago'] = $data['parcelasrec'][$j]['DataVencimento'];
									} else {
										$data['parcelasrec'][$j]['DataPago'] = $data['parcelasrec'][$j]['DataPago'];
									}
									$data['parcelasrec'][$j]['DataLanc'] = date('Y-m-d', time());
								} else {
									$data['parcelasrec'][$j]['DataPago'] = "0000-00-00";
									$data['parcelasrec'][$j]['DataLanc'] = "0000-00-00";
								}
							}
							$data['parcelasrec']['idApp_Parcelas'] = $this->Orcatrata_model->set_parcelas($data['parcelasrec']);
						}			

						#### App_Procedimento ####
						if (isset($data['procedimento'])) {
							$max = count($data['procedimento']);
							for($j=1;$j<=$max;$j++) {
								$data['procedimento'][$j]['TipoProcedimento'] = 1;
								//$data['procedimento'][$j]['NivelProcedimento'] = $_SESSION['Usuario']['Nivel'];
								$data['procedimento'][$j]['NivelProcedimento'] = 0;
								$data['procedimento'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								if(!$data['procedimento'][$j]['Compartilhar']){
									$data['procedimento'][$j]['Compartilhar'] = $_SESSION['log']['idSis_Usuario'];
								}
								$data['procedimento'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['procedimento'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['procedimento'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];
								$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'mysql');
														
								if(!$data['procedimento'][$j]['DataConcluidoProcedimento']){
									$data['procedimento'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
								}else{
									$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataConcluidoProcedimento'], 'mysql');
								}				
							
							}
							$data['procedimento']['idApp_Procedimento'] = $this->Orcatrata_model->set_procedimento($data['procedimento']);
						}
						/*
						$data['update']['servico']['posterior'] = $this->Orcatrata_model->get_servico_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['servico']['posterior'])){
							$max_produto = count($data['update']['servico']['posterior']);
							if($max_produto == 0){
								$data['orcatrata']['ConcluidoOrca'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
								$data['orcatrata']['CombinadoFrete'] = "S";
							}else{
								$data['orcatrata']['ConcluidoOrca'] = "N";
							}
						}
						*/
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_contagem($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto > 0){
								$data['orcatrata']['Prd_Srv_Orca'] = "S";
							}
						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto == 0){
								$data['orcatrata']['CombinadoFrete'] = "S";
								#$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
								$data['orcatrata']['ConcluidoOrca'] = "S";
							}else{
								$data['orcatrata']['ConcluidoOrca'] = "N";
							}
						}
						
						$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['parcelasrec']['posterior'])){
							$max_parcela = count($data['update']['parcelasrec']['posterior']);
							if($max_parcela == 0){
								#$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['QuitadoOrca'] = "S";				
							}else{
								$data['orcatrata']['QuitadoOrca'] = "N";
							}

						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto > 0){
								$data['orcatrata']['CombinadoFrete'] = "S";
								#$data['orcatrata']['AprovadoOrca'] = "S";
							}
						}			

						$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);	
						if (isset($data['update']['parcelasrec']['posterior'])){
							$max_parcela = count($data['update']['parcelasrec']['posterior']);
							if($max_parcela > 0){
								#$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['AprovadoOrca'] = "S";				
							}

						}
						
						if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['FinalizadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
						}else{
							$data['orcatrata']['FinalizadoOrca'] = "N";
						}
						
						$data['orcatrata']['RepeticaoOrca'] = $data['orcatrata']['idApp_OrcaTrata'];
						$data['orcatrata']['RecorrenciasOrca'] = "1";
						$data['orcatrata']['RecorrenciaOrca'] = "1/1";
						
						$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$data['orcatrata']['idApp_OrcaTrata'], TRUE);
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);			
						
						#### Estoque_Produto_posterior ####
						
							if ($data['orcatrata']['CombinadoFrete'] == 'S' && $data['orcatrata']['CanceladoOrca'] == 'N') {
								
								$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
								
								if (count($data['busca']['estoque']['posterior']) > 0) {
									
									$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
									$max_estoque = count($data['busca']['estoque']['posterior']);
									
									if (isset($data['busca']['estoque']['posterior'])){
										
										for($j=1;$j<=$max_estoque;$j++) {
											
											$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
											
											if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
												
												$qtd_produto[$j]	= ($data['busca']['estoque']['posterior'][$j]['QtdProduto'] * $data['busca']['estoque']['posterior'][$j]['QtdIncrementoProduto']);
												
												$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] + $qtd_produto[$j]);
												
												if($diff_estoque[$j] <= 0){
													$estoque[$j] = 0; 
												}else{
													$estoque[$j] = $diff_estoque[$j]; 
												}
												
												$data['alterar']['produto']['posterior'][$j]['Estoque'] = $estoque[$j];
												$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$j], $data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
												
												unset($qtd_produto[$j]);
												unset($diff_estoque[$j]);
												unset($estoque[$j]);
											}
											
										}
										
									}
									
								}
								
							}
						
						/*
						/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
									$data['campos'] = array_keys($data['query']);
									$data['anterior'] = array();
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
						////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
						*/

						if ($data['idApp_OrcaTrata'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('orcatrata/form_orcatratadesp', $data);
						} else {

							//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
							//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';

							#redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
							#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
							#redirect(base_url() . 'orcatrata/cadastrardesp/' . $data['msg']);
							redirect(base_url() . 'OrcatrataPrint/imprimirdesp/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);				
							exit();
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }
		
    public function alterardesp($id = FALSE) {

		$acesso = FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$acesso = TRUE;
		}else{
			if($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Usuario']['Nivel'] != 2 && $_SESSION['Usuario']['Usu_Des'] == "S"){
				$acesso = TRUE;
			}	
		}
		
		if($acesso === FALSE){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{
			
			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 3)
				$data['msg'] = $this->basico->msg('<strong>N�o � poss�vel salvar as altera��es.<br>N�o identificamos o pagamento da sua �ltima Fatura.<br>Por favor, Entre em contato com a administra��o da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
			else
				$data['msg'] = '';
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'ConcluidoProduto',
				'QuitadoParcelas',
				'Cadastrar',
				'AtualizaEndereco',
				'StatusProdutos',
				'StatusParcelas',
				'Valor_S_Desc',
				'Valor_C_Desc',
				'UsarC',
				'UsarD',
				'UsarE',
				'ValidaCupom',
				'MensagemCupom',
				'CodigoCupom',
			), TRUE));

			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['orcatrata'] = quotes_to_entities($this->input->post(array(
				#### App_OrcaTrata ####
				'idApp_OrcaTrata',
				#N�o h� a necessidade de atualizar o valor do campo a seguir
				'idApp_Fornecedor',
				'id_Funcionario',
				'DataOrca',
				'TipoFinanceiro',
				'Descricao',
				'AprovadoOrca',
				'ConcluidoOrca',
				'BrindeOrca',
				'DevolvidoOrca',
				'ProntoOrca',
				'QuitadoOrca',
				'FinalizadoOrca',
				'ValorOrca',
				//'ValorComissao',
				'QtdPrdOrca',
				'QtdSrvOrca',
				'PrazoProdutos',
				'PrazoServicos',
				'PrazoProdServ',
				'PrazoCorreios',
				'ValorDev',
				'ValorDinheiro',
				'ValorTroco',
				'ValorRestanteOrca',
				'FormaPagamento',
				//'QtdParcelasOrca',
				//'DataVencimentoOrca',
				'ObsOrca',
				'Consideracoes',
				'Modalidade',
				#'idTab_TipoRD',
				'AVAP',
				'Tipo_Orca',
				'EnviadoOrca',
				'Cep',
				'Logradouro',
				'Numero',
				'Complemento',
				'Bairro',
				'Cidade',
				'Estado',
				'Referencia',
				'CombinadoFrete',
				'TipoFrete',
				'ValorFrete',
				'ValorExtraOrca',
				'PercExtraOrca',
				'ValorSomaOrca',
				'PrazoEntrega',
				'ValorTotalOrca',
				'Entregador',
				'DataEntregaOrca',
				'HoraEntregaOrca',
				'NomeRec',
				'TelefoneRec',
				'ParentescoRec',
				'ObsEntrega',
				'Aux1Entrega',
				'Aux2Entrega',
				'DetalhadaEntrega',
				'CanceladoOrca',
				'Cli_Forn_Orca',
				'Func_Orca',
				'Prd_Srv_Orca',
				'Entrega_Orca',
				'TipoDescOrca',
				'TipoExtraOrca',
				'DescPercOrca',
				'DescValorOrca',
				'CashBackOrca',
				'ValidadeCashBackOrca',
				'UsarCashBack',
				'UsarCupom',
				'Cupom',
				'ValorFinalOrca',
				'SubValorFinal',
			), TRUE));
			
			$data['fornecedor'] = $this->input->post(array(
				'idApp_Fornecedor',
				'CepFornecedor',
				'EnderecoFornecedor',
				'NumeroFornecedor',
				'ComplementoFornecedor',
				'CidadeFornecedor',
				'BairroFornecedor',
				'MunicipioFornecedor',
				'EstadoFornecedor',
				'ReferenciaFornecedor',
			), TRUE);

			$caracteres_sem_acento = array(
				'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
				'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
				'�'=>'I', '�'=>'N', 'N'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
				'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
				'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
				'�'=>'i', '�'=>'o', '�'=>'n', 'n'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
				'�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f',
				'a'=>'a', '�'=>'i', '�'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', '�'=>'I', '�'=>'A', '?'=>'S', '?'=>'T',
			);

			$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Logradouro'], $caracteres_sem_acento));

			$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['orcatrata']['Cep'], $caracteres_sem_acento));

			$numero1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Numero'], $caracteres_sem_acento));

			$complemento1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Complemento'], $caracteres_sem_acento));

			$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Bairro'], $caracteres_sem_acento));

			$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Cidade'], $caracteres_sem_acento));

			$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Estado'], $caracteres_sem_acento));

			$referencia1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['orcatrata']['Referencia'], $caracteres_sem_acento));
			
			//D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
			//comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

			(isset($_SESSION['Usuario']['Bx_Pag']) && $_SESSION['Usuario']['Bx_Pag'] == "S") ? $data['div']['Prof_comissao'] = '' : $data['div']['Prof_comissao'] = 'style="display: none;"';		
			
			(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
			(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
			(!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
			(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
			
			#(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
			(!$data['orcatrata']['idApp_Fornecedor']) ? $data['orcatrata']['idApp_Fornecedor'] = '0' : FALSE;
			(!$data['orcatrata']['id_Funcionario']) ? $data['orcatrata']['id_Funcionario'] = '0' : FALSE;
			(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
			(!$data['orcatrata']['Func_Orca']) ? $data['orcatrata']['Func_Orca'] = 'S' : FALSE;
			(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;
			(!$data['orcatrata']['Entrega_Orca']) ? $data['orcatrata']['Entrega_Orca'] = 'S' : FALSE;  
			(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
			(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
			//(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
			(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
			(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
			(!$data['orcatrata']['Entregador']) ? $data['orcatrata']['Entregador'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoProdServ']) ? $data['orcatrata']['PrazoProdServ'] = '0' : FALSE;
			(!$data['orcatrata']['ValorOrca']) ? $data['orcatrata']['ValorOrca'] = '0.00' : FALSE;
			(!$data['orcatrata']['ValorDev']) ? $data['orcatrata']['ValorDev'] = '0.00' : FALSE;
			(!$data['orcatrata']['QtdPrdOrca']) ? $data['orcatrata']['QtdPrdOrca'] = '0' : FALSE;
			(!$data['orcatrata']['QtdSrvOrca']) ? $data['orcatrata']['QtdSrvOrca'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoProdutos']) ? $data['orcatrata']['PrazoProdutos'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoServicos']) ? $data['orcatrata']['PrazoServicos'] = '0' : FALSE;
			(!$data['orcatrata']['PrazoCorreios']) ? $data['orcatrata']['PrazoCorreios'] = '0' : FALSE;
			(!$data['orcatrata']['TipoDescOrca']) ? $data['orcatrata']['TipoDescOrca'] = 'V' : FALSE;
			(!$data['orcatrata']['TipoExtraOrca']) ? $data['orcatrata']['TipoExtraOrca'] = 'V' : FALSE; 
			(!$data['orcatrata']['UsarCashBack']) ? $data['orcatrata']['UsarCashBack'] = 'N' : FALSE;
			(!$data['orcatrata']['UsarCupom']) ? $data['orcatrata']['UsarCupom'] = 'N' : FALSE;
			if($_SESSION['log']['idSis_Empresa'] == 5){
				(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'S' : FALSE;
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'S' : FALSE;			
			}else{
				(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
				(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;		
			}
			(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
			(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;		
			(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
			(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;
			
			(!$data['orcatrata']['ValorFrete']) ? $data['orcatrata']['ValorFrete'] = 0 : FALSE;
			(!$data['orcatrata']['ValorExtraOrca']) ? $data['orcatrata']['ValorExtraOrca'] = 0 : FALSE;
			(!$data['orcatrata']['PercExtraOrca']) ? $data['orcatrata']['PercExtraOrca'] = 0 : FALSE;
			(!$data['orcatrata']['DescPercOrca']) ? $data['orcatrata']['DescPercOrca'] = 0 : FALSE;
			(!$data['orcatrata']['DescValorOrca']) ? $data['orcatrata']['DescValorOrca'] = 0 : FALSE;
					
			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
			(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusProdutos']) ? $data['cadastrar']['StatusProdutos'] = 'N' : FALSE;
			(!$data['cadastrar']['StatusParcelas']) ? $data['cadastrar']['StatusParcelas'] = 'N' : FALSE;
			(!$data['cadastrar']['ValidaCupom']) ? $data['cadastrar']['ValidaCupom'] = '0' : FALSE;
					
			/*
			$j = 1;
			for ($i = 1; $i <= $data['count']['SCount']; $i++) {

				if ($this->input->post('idTab_Servico' . $i)) {
					$data['servico'][$j]['idApp_Servico'] = $this->input->post('idApp_Servico' . $i);
					$data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
					$data['servico'][$j]['idTab_Valor_Servico'] = $this->input->post('idTab_Valor_Servico' . $i);
					$data['servico'][$j]['idTab_Produtos_Servico'] = $this->input->post('idTab_Produtos_Servico' . $i);
					$data['servico'][$j]['Prod_Serv_Servico'] = $this->input->post('Prod_Serv_Servico' . $i);
					$data['servico'][$j]['NomeServico'] = $this->input->post('NomeServico' . $i);
					$data['servico'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
					$data['servico'][$j]['ValorServico'] = $this->input->post('ValorServico' . $i);
					$data['servico'][$j]['QtdServico'] = $this->input->post('QtdServico' . $i);
					$data['servico'][$j]['QtdIncrementoServico'] = $this->input->post('QtdIncrementoServico' . $i);
					$data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
					$data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
					$data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
					$data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
					$data['servico'][$j]['ProfissionalServico_1'] = $this->input->post('ProfissionalServico_1' . $i);
					$j++;
				}

			}
			$data['count']['SCount'] = $j - 1;
			*/
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['SCount']; $i++) {

				if ($this->input->post('idTab_Servico' . $i)) {
					$data['servico'][$j]['idApp_Produto'] = $this->input->post('idApp_Servico' . $i);
					$data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
					//$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
					$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
					$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
					$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
					//$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
					//$data['servico'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoServico' . $i);
					//$data['servico'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackServico' . $i);
					$data['servico'][$j]['PrazoProduto'] = $this->input->post('PrazoServico' . $i);
					$data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
					$data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
					$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
					$data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
					//$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
					//$data['servico'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoServico' . $i);
					//$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackServico' . $i);
					$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
					$data['servico'][$j]['ValorComissaoServico'] = $this->input->post('ValorComissaoServico' . $i);
					$data['servico'][$j]['ObsProduto'] = $this->input->post('ObsServico' . $i);
					$data['servico'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeServico' . $i);
					$data['servico'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoServico' . $i);
					$data['servico'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoServico' . $i);
					$data['servico'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoServico' . $i);

					$data['servico'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalServico_1' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
					}				
					$data['servico'][$j]['ProfissionalProduto_2'] = $this->input->post('ProfissionalServico_2' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_3'] = $this->input->post('ProfissionalServico_3' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_4'] = $this->input->post('ProfissionalServico_4' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_5'] = $this->input->post('ProfissionalServico_5' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
					}
					$data['servico'][$j]['ProfissionalProduto_6'] = $this->input->post('ProfissionalServico_6' . $i);
					if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
					}else{
						$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
					}

					$data['servico'][$j]['idTFProf_1'] = $this->input->post('idTFProf_Servico_1' . $i);
					$data['servico'][$j]['ComFunProf_1'] = $this->input->post('ComFunProf_Servico_1' . $i);
					$data['servico'][$j]['ValorComProf_1'] = $this->input->post('ValorComProf_Servico_1' . $i);
					
					$data['servico'][$j]['idTFProf_2'] = $this->input->post('idTFProf_Servico_2' . $i);
					$data['servico'][$j]['ComFunProf_2'] = $this->input->post('ComFunProf_Servico_2' . $i);
					$data['servico'][$j]['ValorComProf_2'] = $this->input->post('ValorComProf_Servico_2' . $i);
					
					$data['servico'][$j]['idTFProf_3'] = $this->input->post('idTFProf_Servico_3' . $i);
					$data['servico'][$j]['ComFunProf_3'] = $this->input->post('ComFunProf_Servico_3' . $i);
					$data['servico'][$j]['ValorComProf_3'] = $this->input->post('ValorComProf_Servico_3' . $i);
					
					$data['servico'][$j]['idTFProf_4'] = $this->input->post('idTFProf_Servico_4' . $i);
					$data['servico'][$j]['ComFunProf_4'] = $this->input->post('ComFunProf_Servico_4' . $i);
					$data['servico'][$j]['ValorComProf_4'] = $this->input->post('ValorComProf_Servico_4' . $i);
					
					$data['servico'][$j]['idTFProf_5'] = $this->input->post('idTFProf_Servico_5' . $i);
					$data['servico'][$j]['ComFunProf_5'] = $this->input->post('ComFunProf_Servico_5' . $i);
					$data['servico'][$j]['ValorComProf_5'] = $this->input->post('ValorComProf_Servico_5' . $i);
					
					$data['servico'][$j]['idTFProf_6'] = $this->input->post('idTFProf_Servico_6' . $i);
					$data['servico'][$j]['ComFunProf_6'] = $this->input->post('ComFunProf_Servico_6' . $i);
					$data['servico'][$j]['ValorComProf_6'] = $this->input->post('ValorComProf_Servico_6' . $i);
					
					(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
					);
					($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';
									
					$data['select'][$j]['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_1']);
					$data['select'][$j]['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_2']);
					$data['select'][$j]['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_3']);
					$data['select'][$j]['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_4']);
					$data['select'][$j]['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_5']);
					$data['select'][$j]['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos($data['servico'][$j]['ProfissionalProduto_6']);
					
					$j++;
				}

			}
			$data['count']['SCount'] = $j - 1;		

			$j = 1;
			for ($i = 1; $i <= $data['count']['PCount']; $i++) {

				if ($this->input->post('idTab_Produto' . $i)) {
					$data['produto'][$j]['idApp_Produto'] = $this->input->post('idApp_Produto' . $i);
					$data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
					//$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
					$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
					$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
					//$data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
					//$data['produto'][$j]['ComissaoServicoProduto'] = $this->input->post('ComissaoServicoProduto' . $i);
					//$data['produto'][$j]['ComissaoCashBackProduto'] = $this->input->post('ComissaoCashBackProduto' . $i);
					$data['produto'][$j]['PrazoProduto'] = $this->input->post('PrazoProduto' . $i);
					$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
					$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
					$data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
					$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
					$data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
					//$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
					//$data['produto'][$j]['SubtotalComissaoServicoProduto'] = $this->input->post('SubtotalComissaoServicoProduto' . $i);
					//$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = $this->input->post('SubtotalComissaoCashBackProduto' . $i);
					$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
					$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
					$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
					$data['produto'][$j]['DataConcluidoProduto'] = $this->input->post('DataConcluidoProduto' . $i);
					$data['produto'][$j]['HoraConcluidoProduto'] = $this->input->post('HoraConcluidoProduto' . $i);
					$data['produto'][$j]['Aux_App_Produto_1'] = $this->input->post('Aux_App_Produto_1' . $i);
					$data['produto'][$j]['Aux_App_Produto_2'] = $this->input->post('Aux_App_Produto_2' . $i);
					$data['produto'][$j]['Aux_App_Produto_3'] = $this->input->post('Aux_App_Produto_3' . $i);
					$data['produto'][$j]['Aux_App_Produto_4'] = $this->input->post('Aux_App_Produto_4' . $i);
					$data['produto'][$j]['Aux_App_Produto_5'] = $this->input->post('Aux_App_Produto_5' . $i);
					$data['produto'][$j]['HoraValidadeProduto'] = $this->input->post('HoraValidadeProduto' . $i);
					$data['produto'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoProduto' . $i);
					$data['produto'][$j]['DevolvidoProduto'] = $this->input->post('DevolvidoProduto' . $i);
					$data['produto'][$j]['CanceladoProduto'] = $this->input->post('CanceladoProduto' . $i);
					//$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					//$data['produto'][$j]['ProfissionalProduto_1'] = $this->input->post('ProfissionalProduto_1' . $i);
					
					(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
					);
					($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';
					
					$j++;
				}
			}
			$data['count']['PCount'] = $j - 1;

			$j = 1;
			for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

				if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataConcluidoProcedimento' . $i) ||
					$this->input->post('Profissional' . $i) || $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
					$data['procedimento'][$j]['idApp_Procedimento'] = $this->input->post('idApp_Procedimento' . $i);
					$data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
					$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->input->post('DataConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['HoraProcedimento'] = $this->input->post('HoraProcedimento' . $i);
					$data['procedimento'][$j]['HoraConcluidoProcedimento'] = $this->input->post('HoraConcluidoProcedimento' . $i);				
					#$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
					//$data['procedimento'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
					$data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
					$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
					$data['procedimento'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					$data['procedimento'][$j]['Compartilhar'] = $this->input->post('Compartilhar' . $i);
					
					(!$data['procedimento'][$j]['ConcluidoProcedimento']) ? $data['procedimento'][$j]['ConcluidoProcedimento'] = 'N' : FALSE;
					$data['radio'] = array(
						'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
					);
					($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';	

					$data['select'][$j]['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos($data['procedimento'][$j]['Compartilhar']);
					
					$j++;
				}

			}
			$data['count']['PMCount'] = $j - 1;

			$data['somatotal'] = 0;	

			$j = 1;
			for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

					$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
					$data['somatotal'] += $data['valoredit'][$i];            
				
				if ($data['valoredit'][$i] > 0.00){
					$data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
					$data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					//$data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$j]['DataLanc'] = $this->input->post('DataLanc' . $i);
					$data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
					$data['parcelasrec'][$j]['FormaPagamentoParcela'] = $this->input->post('FormaPagamentoParcela' . $i);
					//$data['parcelasrec'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
					
					(!$data['parcelasrec'][$j]['Quitado']) ? $data['parcelasrec'][$j]['Quitado'] = 'N' : FALSE;
					$data['radio'] = array(
						'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
					);
					($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';				

					$j++;
				}
			}
			$data['count']['PRCount'] = $j - 1;
		
			//Fim do trecho de c�digo que d� pra melhorar

			if ($id) {
				#### App_OrcaTrata ####
				$_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);

				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 1){
					
					unset($_SESSION['Orcatrata']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {			
					if($_SESSION['log']['idSis_Empresa'] != 5){
						if(isset($data['orcatrata']['id_Associado']) && $data['orcatrata']['id_Associado'] !=0){
							$_SESSION['Orcatrata']['NomeAssociado'] = $this->Orcatrata_model->get_associado($data['orcatrata']['id_Associado'])['NomeCliente'];
						}else{
							unset($_SESSION['Orcatrata']['NomeAssociado']);
						}
						if(isset($data['orcatrata']['id_Funcionario']) && $data['orcatrata']['id_Funcionario'] !=0){
							$_SESSION['Orcatrata']['NomeFuncionario'] = $this->Usuario_model->get_usuario($data['orcatrata']['id_Funcionario'])['Nome'];
						}else{
							unset($_SESSION['Orcatrata']['NomeFuncionario']);
						}						
					}elseif($_SESSION['log']['idSis_Empresa'] == 5){
						if(isset($data['orcatrata']['id_Funcionario']) && $data['orcatrata']['id_Funcionario'] !=0){
							$_SESSION['Orcatrata']['NomeAssociado'] = $this->Orcatrata_model->get_associado($data['orcatrata']['id_Funcionario'])['NomeCliente'];
						}else{
							unset($_SESSION['Orcatrata']['NomeAssociado']);
						}
					}	
					if(isset($data['orcatrata']['NivelOrca']) && $data['orcatrata']['NivelOrca'] !=0){
						switch ($data['orcatrata']['TipoFinanceiro']) {
						   case 66:
							   $tipofinac = 'COMISSAO VENDEDOR';
							   break;
						   case 67:
							   $tipofinac = 'COMISSAO SUPERVISOR';
							   break;
						   case 68:
							   $tipofinac = 'COMISSAO ASSOCIADO';
							   break;
						   case 69:
							   $tipofinac = 'COMISSAO SERVICO';
							   break;
						}
						$_SESSION['Orcatrata']['Tipo_Financeiro'] = $tipofinac;	
					}else{
						unset($_SESSION['Orcatrata']['Tipo_Financeiro']);
					}
					/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($_SESSION['Orcatrata']['Tipo_Financeiro']);
				  echo "</pre>";
				  exit ();
				  */
					$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
					$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'barras');
					$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'barras');

					#### App_Servico ####
					$data['servico'] = $this->Orcatrata_model->get_servicodesp($id);
					if (count($data['servico']) > 0) {
						$data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
						$data['count']['SCount'] = count($data['servico']);

						if (isset($data['servico'])) {

							for($j=1;$j<=$data['count']['SCount'];$j++) {
								$data['servico'][$j]['SubtotalProduto'] = number_format(($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto']), 2, ',', '.');
								//$data['servico'][$j]['SubtotalComissaoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoProduto'] /100);
								//$data['servico'][$j]['SubtotalComissaoServicoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoServicoProduto'] /100);
								//$data['servico'][$j]['SubtotalComissaoCashBackProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoCashBackProduto'] /100);
								$data['servico'][$j]['SubtotalQtdProduto'] = ($data['servico'][$j]['QtdIncrementoProduto'] * $data['servico'][$j]['QtdProduto']);
								$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'barras');
								$data['servico'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataConcluidoProduto'], 'barras');
								$data['servico'][$j]['ValorComissaoServico'] = number_format(($data['servico'][$j]['ValorComissaoServico']), 2, ',', '.');

								$data['servico'][$j]['ValorComProf_1'] = number_format(($data['servico'][$j]['ValorComProf_1']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_2'] = number_format(($data['servico'][$j]['ValorComProf_2']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_3'] = number_format(($data['servico'][$j]['ValorComProf_3']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_4'] = number_format(($data['servico'][$j]['ValorComProf_4']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_5'] = number_format(($data['servico'][$j]['ValorComProf_5']), 2, ',', '.');
								$data['servico'][$j]['ValorComProf_6'] = number_format(($data['servico'][$j]['ValorComProf_6']), 2, ',', '.');
												
								(!$data['servico'][$j]['ConcluidoProduto']) ? $data['servico'][$j]['ConcluidoProduto'] = 'N' : FALSE;
								$data['radio'] = array(
									'ConcluidoServico' . $j => $this->basico->radio_checked($data['servico'][$j]['ConcluidoProduto'], 'ConcluidoServico' . $j, 'NS'),
								);
								($data['servico'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoServico' . $j] = '' : $data['div']['ConcluidoServico' . $j] = 'style="display: none;"';
								
								$_SESSION['Servico'][$j]['ProfissionalServico_1'] = $data['servico'][$j]['ProfissionalProduto_1'];
								$_SESSION['Servico'][$j]['ProfissionalServico_2'] = $data['servico'][$j]['ProfissionalProduto_2'];
								$_SESSION['Servico'][$j]['ProfissionalServico_3'] = $data['servico'][$j]['ProfissionalProduto_3'];
								$_SESSION['Servico'][$j]['ProfissionalServico_4'] = $data['servico'][$j]['ProfissionalProduto_4'];
								$_SESSION['Servico'][$j]['ProfissionalServico_5'] = $data['servico'][$j]['ProfissionalProduto_5'];
								$_SESSION['Servico'][$j]['ProfissionalServico_6'] = $data['servico'][$j]['ProfissionalProduto_6'];
								
								$data['select'][$j]['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
								$data['select'][$j]['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
								
								if(!$data['servico'][$j]['ProfissionalProduto_1'] || $data['servico'][$j]['ProfissionalProduto_1'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_1'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_2'] || $data['servico'][$j]['ProfissionalProduto_2'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_2'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_3'] || $data['servico'][$j]['ProfissionalProduto_3'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_3'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_4'] || $data['servico'][$j]['ProfissionalProduto_4'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_4'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_5'] || $data['servico'][$j]['ProfissionalProduto_5'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_5'] = '';
								}
								if(!$data['servico'][$j]['ProfissionalProduto_6'] || $data['servico'][$j]['ProfissionalProduto_6'] == 0){
									$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = 'readonly=""';
								}else{
									$data['cadastrar_servico'][$j]['Hidden_readonly_6'] = '';
								}						
							}
						}
					}

					#### App_Produto ####
					$data['produto'] = $this->Orcatrata_model->get_produtodesp($id);
					if (count($data['produto']) > 0) {
						$data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
						$data['count']['PCount'] = count($data['produto']);

						if (isset($data['produto'])) {

							for($j=1;$j<=$data['count']['PCount'];$j++) {
								$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
								//$data['produto'][$j]['ComissaoProduto'] = $data['produto'][$j]['ComissaoProduto'];
								//$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
								//$data['produto'][$j]['SubtotalComissaoServicoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoServicoProduto'] /100);
								//$data['produto'][$j]['SubtotalComissaoCashBackProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoCashBackProduto'] /100);
								$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
								$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
								$data['produto'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataConcluidoProduto'], 'barras');

								(!$data['produto'][$j]['ConcluidoProduto']) ? $data['produto'][$j]['ConcluidoProduto'] = 'N' : FALSE;
								$data['radio'] = array(
									'ConcluidoProduto' . $j => $this->basico->radio_checked($data['produto'][$j]['ConcluidoProduto'], 'ConcluidoProduto' . $j, 'NS'),
								);
								($data['produto'][$j]['ConcluidoProduto'] == 'S') ? $data['div']['ConcluidoProduto' . $j] = '' : $data['div']['ConcluidoProduto' . $j] = 'style="display: none;"';

								///esta linha deve ser retirada ap�s corre��o dos nomes dos pedidos antigos///
								//$data['produto'][$j]['NomeProduto'] = $data['produto'][$j]['Produto'];
							}

						}
					}

					#### App_Parcelas ####
					$data['parcelasrec'] = $this->Orcatrata_model->get_parcelas($id);
					if (count($data['parcelasrec']) > 0) {
						$data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
						$data['count']['PRCount'] = count($data['parcelasrec']);
						
						if (isset($data['parcelasrec'])) {

							for($j=1; $j <= $data['count']['PRCount']; $j++) {
								$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
								$data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
								$data['parcelasrec'][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataLanc'], 'barras');
							
								$data['radio'] = array(
									'Quitado' . $j => $this->basico->radio_checked($data['parcelasrec'][$j]['Quitado'], 'Quitado' . $j, 'NS'),
								);
								($data['parcelasrec'][$j]['Quitado'] == 'S') ? $data['div']['Quitado' . $j] = '' : $data['div']['Quitado' . $j] = 'style="display: none;"';
							}

						}
					}

					#### App_Procedimento ####
					$_SESSION['Procedimento'] = $data['procedimento'] = $this->Orcatrata_model->get_procedimento($id);
					if (count($data['procedimento']) > 0) {
						$data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
						$data['count']['PMCount'] = count($data['procedimento']);

						if (isset($data['procedimento'])) {

							for($j=1; $j <= $data['count']['PMCount']; $j++) {
								$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');
								$data['procedimento'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataConcluidoProcedimento'], 'barras');
								$_SESSION['Procedimento'][$j]['Nome'] = $data['procedimento'][$j]['Nome'];
							
								$data['radio'] = array(
									'ConcluidoProcedimento' . $j => $this->basico->radio_checked($data['procedimento'][$j]['ConcluidoProcedimento'], 'ConcluidoProcedimento' . $j, 'NS'),
								);
								($data['procedimento'][$j]['ConcluidoProcedimento'] == 'S') ? $data['div']['ConcluidoProcedimento' . $j] = '' : $data['div']['ConcluidoProcedimento' . $j] = 'style="display: none;"';
								
								$_SESSION['Procedimento'][$j]['Compartilhar'] = $data['procedimento'][$j]['Compartilhar'];
								$data['select'][$j]['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos($_SESSION['Procedimento'][$j]['Compartilhar']);
							}
						}
					}
				}
			}

			if(!$data['orcatrata']['idApp_OrcaTrata'] || !$_SESSION['Orcatrata'] || $_SESSION['Orcatrata']['idTab_TipoRD'] != 1){
				
				unset($_SESSION['Orcatrata']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {			
								
				#### Carrega os dados das consultas nas vari�ves de sess�o ####
				$_SESSION['Consultas_orca'] = $data['consultas_orca'] = $this->Consulta_model->get_consultas_orca($_SESSION['Orcatrata']['idApp_OrcaTrata'], TRUE);
				$_SESSION['Orcatratas'] = $data['orcatratas'] = $this->Orcatrata_model->get_orcatratas_repet($_SESSION['Orcatrata']['RepeticaoOrca']);		

				$data['count_orca'] = count($_SESSION['Consultas_orca']);
				
				$data['select']['TipoDescOrca'] = array (
					'P' => '.%',
					'V' => 'R$',
				);		
				$data['select']['TipoExtraOrca'] = array (
					'P' => '.%',
					'V' => 'R$',
				);			
				$data['select']['UsarCashBack'] = $this->Basico_model->select_status_sn();
				$data['select']['UsarCupom'] = $this->Basico_model->select_status_sn();
				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
				$data['select']['StatusProdutos'] = $this->Basico_model->select_status_sn();
				$data['select']['StatusParcelas'] = $this->Basico_model->select_status_sn();
				$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['Func_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['Entrega_Orca'] = $this->Basico_model->select_status_sn();
				$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
				$data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
				$data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroD();
				$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
				$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
				$data['select']['FormaPagamentoParcela'] = $this->Formapag_model->select_formapag();
				$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['DevolvidoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['ProntoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['CanceladoProduto'] = $this->Basico_model->select_status_sn();
				$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
				$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
				$data['select']['TipoFrete'] = $this->Basico_model->select_tipofrete();
				$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['Quitado'] = $this->Basico_model->select_status_sn();
				$data['select']['idApp_Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
				$data['select']['id_Funcionario'] = $this->Usuario_model->select_usuario();
				$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
				//$data['select']['ProfissionalServico_1'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_2'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_3'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_4'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_5'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalServico_6'] = $this->Usuario_model->select_usuario_servicos();
				//$data['select']['ProfissionalProduto_1'] = $this->Usuario_model->select_usuario();
				$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
				//$data['select']['Compartilhar'] = $this->Usuario_model->select_usuario_procedimentos();
				$data['select']['Entregador'] = $this->Usuario_model->select_usuario_entregador($_SESSION['Orcatrata']['Entregador']);
				$data['select']['Produto'] = $this->Basico_model->select_produto2();
				$data['select']['Servico'] = $this->Basico_model->select_servico2();
				#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
				$data['select']['AVAP'] = $this->Basico_model->select_avap();
				$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
				$data['select']['Prioridade'] = array (
					'1' => 'Alta',
					'2' => 'M�dia',
					'3' => 'Baixa',
				);
				
				$data['titulo'] = 'Editar Despesa';
				$data['form_open_path'] = 'orcatrata/alterardesp';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'danger';
				$data['metodo'] = 2;
				$data['caminho'] = '../../';		
				
				$data['Recorrencias'] = 1;
				$data['Recorrencias_outras'] = $data['Recorrencias'] - 1;
				
				$data['exibirExtraOrca'] = 1;
				$data['exibirDescOrca'] = 1;		
				
				$data['vinculadas'] = 0;
				if ($data['vinculadas'] > 0){
					$data['textoEntregues'] = '';
					$data['textoPagas'] = '';
				}else{
					$data['textoEntregues'] = 'style="display: none;"';
					$data['textoPagas'] = 'style="display: none;"';
				}

				$data['collapse'] = '';	
				$data['collapse1'] = 'class="collapse"';		
				
				//if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
				if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
					$data['orcamentoin'] = 'in';
				else
					$data['orcamentoin'] = '';

				if ($data['orcatrata']['FormaPagamento'])
					$data['parcelasin'] = 'in';
				else
					$data['parcelasin'] = '';

				//if (isset($data['procedimento']) && ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional']))
				if ($data['count']['PMCount'] > 0)
					$data['tratamentosin'] = 'in';
				else
					$data['tratamentosin'] = '';

				if ($_SESSION['log']['NivelEmpresa'] >= '4' )
					$data['visivel'] = '';
				else
					$data['visivel'] = 'style="display: none;"';		
				

				($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
				
				$data['radio'] = array(
					'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
				);
				($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
				
				($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
				/*
				$data['radio'] = array(
					'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
				);
				($data['orcatrata']['AVAP'] == 'P') ?
					$data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';		
				*/
				
				$data['radio'] = array(
					'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
				);
				($data['cadastrar']['Cadastrar'] == 'N') ?
					$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'StatusProdutos' => $this->basico->radio_checked($data['cadastrar']['StatusProdutos'], 'StatusProdutos', 'NS'),
				);
				($data['cadastrar']['StatusProdutos'] == 'S') ?
					$data['div']['StatusProdutos'] = '' : $data['div']['StatusProdutos'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'StatusParcelas' => $this->basico->radio_checked($data['cadastrar']['StatusParcelas'], 'StatusParcelas', 'NS'),
				);
				($data['cadastrar']['StatusParcelas'] == 'S') ?
					$data['div']['StatusParcelas'] = '' : $data['div']['StatusParcelas'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
				);
				($data['cadastrar']['AtualizaEndereco'] == 'N') ?
					$data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	
					
				$data['radio'] = array(
					'Modalidade' => $this->basico->radio_checked($data['orcatrata']['Modalidade'], 'Modalidade', 'PM'),
				);
				($data['orcatrata']['Modalidade'] == 'P') ?
					$data['div']['Modalidade'] = '' : $data['div']['Modalidade'] = 'style="display: none;"';
						
				$data['radio'] = array(
					'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
				);
				($data['orcatrata']['CombinadoFrete'] == 'S') ?
					$data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
				);
				($data['orcatrata']['AprovadoOrca'] == 'S') ?
					$data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
				);
				($data['orcatrata']['EnviadoOrca'] == 'S') ?
					$data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';			

				$data['radio'] = array(
					'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Cancelado', 'NS'),
				);
				($data['orcatrata']['FinalizadoOrca'] == 'N') ?
					$data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';        
				
				$data['radio'] = array(
					'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Produtos Entregues', 'NS'),
				);
				($data['orcatrata']['CanceladoOrca'] == 'N') ?
					$data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
				);
				($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
					$data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';

				
				$data['radio'] = array(
					'Func_Orca' => $this->basico->radio_checked($data['orcatrata']['Func_Orca'], 'Funcionario', 'NS'),
				);
				($data['orcatrata']['Func_Orca'] == 'S') ?
					$data['div']['Func_Orca'] = '' : $data['div']['Func_Orca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
				);
				($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
					$data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'Entrega_Orca' => $this->basico->radio_checked($data['orcatrata']['Entrega_Orca'], 'Entrega', 'NS'),
				);
				($data['orcatrata']['Entrega_Orca'] == 'S') ?
					$data['div']['Entrega_Orca'] = '' : $data['div']['Entrega_Orca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
				);
				($data['orcatrata']['ConcluidoOrca'] == 'N') ?
					$data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

					
				$data['radio'] = array(
					'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
				);
				($data['orcatrata']['BrindeOrca'] == 'N') ?
					$data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';

				$data['radio'] = array(
					'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Produtos Devolvidos', 'NS'),
				);
				($data['orcatrata']['ProntoOrca'] == 'S') ?
					$data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
					
				$data['radio'] = array(
					'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
				);
				($data['orcatrata']['DevolvidoOrca'] == 'S') ?
					$data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';			

				$data['radio'] = array(
					'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
				);
				($data['orcatrata']['QuitadoOrca'] == 'S') ?
					$data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
				
				$data['radio'] = array(
					'UsarCashBack' => $this->basico->radio_checked($data['orcatrata']['UsarCashBack'], 'UsarCashBack', 'NS'),
				);
				($data['orcatrata']['UsarCashBack'] == 'S') ?
					$data['div']['UsarCashBack'] = '' : $data['div']['UsarCashBack'] = 'style="display: none;"';		
				
				$data['radio'] = array(
					'UsarCupom' => $this->basico->radio_checked($data['orcatrata']['UsarCupom'], 'UsarCupom', 'NS'),
				);
				($data['orcatrata']['UsarCupom'] == 'S') ?
					$data['div']['UsarCupom'] = '' : $data['div']['UsarCupom'] = 'style="display: none;"';

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

				$data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);		

				$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
				$data['valortotalorca'] = floatval ($data['valortotalorca']);
			
				$data['somatotal'] = floatval ($data['somatotal']);
				$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];
				
				$epsilon = 0.001;

				if(abs($data['diferenca']) < $epsilon){
					$data['diferenca'] = 0.00;
				}else{
					$data['diferenca'] = $data['diferenca'];
				}
				
				$data['diferenca'] = floatval ($data['diferenca']);		
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				#### App_OrcaTrata ####
				
				if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
					if($data['diferenca'] < 0.00){
						$data['diferenca'] = number_format($data['diferenca'],2,",",".");
						//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
						$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
					}elseif($data['diferenca'] > 0.00){
						$data['diferenca'] = number_format($data['diferenca'],2,",",".");
						//$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
						$this->form_validation->set_rules('ValorFinalOrca', 'O Valor Final �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
					}
				}
				if ($data['valortotalorca'] <= 0.00 ) {
					$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
				}
				
				if ($_SESSION['log']['NivelEmpresa'] >= '4' && $data['orcatrata']['Cli_Forn_Orca'] == "S") {
					$this->form_validation->set_rules('idApp_Fornecedor', 'Fornecedor', 'required|trim');
					$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');
				} else {
					$data['cadastrar']['Cadastrar'] = 'S';
				}
				if ($_SESSION['log']['NivelEmpresa'] >= '4' && $data['orcatrata']['Func_Orca'] == "S") {
					$this->form_validation->set_rules('id_Funcionario', 'Funcionario', 'required|trim');
				}
				$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
				$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
				$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
				if ($_SESSION['log']['NivelEmpresa'] >= '4') {	
					$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
				}
				//$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
				//$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');			
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					if($_SESSION['Orcatrata']['NivelOrca'] == 0){
						$this->load->view('orcatrata/form_orcatrataalterardesp', $data);
					}else{
						$this->load->view('orcatrata/form_orcatrataalterarrecibo', $data);
					}
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'orcatrata/alterardesp/' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . $data['msg']);
						
					} else {
						
						#### Estoque_Produto_anterior####
						
							
							#### Estoque_Produto_anterior ####
							if ($_SESSION['Orcatrata']['CombinadoFrete'] == 'S') {
								
								$data['busca']['estoque']['anterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
								
								if (count($data['busca']['estoque']['anterior']) > 0) {
									
									$data['busca']['estoque']['anterior'] = array_combine(range(1, count($data['busca']['estoque']['anterior'])), array_values($data['busca']['estoque']['anterior']));
									$max_estoque = count($data['busca']['estoque']['anterior']);
									
									if (isset($data['busca']['estoque']['anterior'])){
										
										for($j=1;$j<=$max_estoque;$j++) {
											
											$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['anterior'][$j]['idTab_Produtos_Produto']);
											
											if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
												
												$qtd_produto[$j]	= ($data['busca']['estoque']['anterior'][$j]['QtdProduto'] * $data['busca']['estoque']['anterior'][$j]['QtdIncrementoProduto']);
												
												$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] - $qtd_produto[$j]);
												
												if($diff_estoque[$j] <= 0){
													$estoque[$j] = 0; 
												}else{
													$estoque[$j] = $diff_estoque[$j]; 
												}
												
												$data['alterar']['produto']['anterior'][$j]['Estoque'] = $estoque[$j];
												$data['alterar']['produto']['anterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['anterior'][$j], $data['get']['produto'][$j]['idTab_Produtos']);
												
												unset($qtd_produto[$j]);
												unset($diff_estoque[$j]);
												unset($estoque[$j]);
											}
											
										}
										
									}
									
								}
								
							}
						
						
						$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
						$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
						$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

						////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
						#### App_OrcaTrata ####
							/*
							$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
							$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
							$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
							$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
							$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
							$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
							$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
							$data['orcatrata']['Referencia'] = '';
							*/
							$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
							$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
							$data['orcatrata']['Numero'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
							$data['orcatrata']['Complemento'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
							$data['orcatrata']['Bairro'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
							$data['orcatrata']['Cidade'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
							$data['orcatrata']['Estado'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
							$data['orcatrata']['Referencia'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
						
						$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
						$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
						$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
						$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
						$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));			
						$data['orcatrata']['TipoFinanceiro'] = $data['orcatrata']['TipoFinanceiro'];
						$data['orcatrata']['Entregador'] = $data['orcatrata']['Entregador'];
						$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
						$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
						$data['orcatrata']['Descricao'] = $data['orcatrata']['Descricao'];
						//$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
						//$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
						//$data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
						//$data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
						//$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
						
						if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
							$data['orcatrata']['ConcluidoOrca'] = "S";
							$data['orcatrata']['QuitadoOrca'] = "S";
						} 
						if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['FinalizadoOrca'] = "S";
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
						} 
						if($data['orcatrata']['ConcluidoOrca'] == 'S'){
							$data['orcatrata']['CombinadoFrete'] = "S";
						} 
						if($data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['AprovadoOrca'] = "S";
						} 
						if ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
							$data['orcatrata']['EnviadoOrca'] = "S";
						}
							
						$data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
						//$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
						$data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
						//$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
						if($data['orcatrata']['FormaPagamento'] == "7"){
							$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
							$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
						}else{
							$data['orcatrata']['ValorDinheiro'] = 0.00;
							$data['orcatrata']['ValorTroco'] = 0.00;
						}
						//$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
						$data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
						/*
						$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
						$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
						$data['orcatrata']['PercExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['PercExtraOrca']));
						$data['orcatrata']['DescPercOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescPercOrca']));
						$data['orcatrata']['DescValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescValorOrca']));
						*/
						if(!$data['orcatrata']['ValorFrete']){
							$data['orcatrata']['ValorFrete'] = 0;
						}else{
							$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
						}
						
						if(!$data['orcatrata']['ValorExtraOrca']){
							$data['orcatrata']['ValorExtraOrca'] = 0;
						}else{
							$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
						}			
									
						if(!$data['orcatrata']['PercExtraOrca']){
							$data['orcatrata']['PercExtraOrca'] = 0;
						}else{
							$data['orcatrata']['PercExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['PercExtraOrca']));
						}			

						if(!$data['orcatrata']['DescPercOrca']){
							$data['orcatrata']['DescPercOrca'] = 0;
						}else{
							$data['orcatrata']['DescPercOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescPercOrca']));
						}			
						
						if(!$data['orcatrata']['DescValorOrca']){
							$data['orcatrata']['DescValorOrca'] = 0;
						}else{
							$data['orcatrata']['DescValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['DescValorOrca']));
						}
						
						$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
						$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
						$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
						$data['orcatrata']['ValidadeCashBackOrca'] = $this->basico->mascara_data($data['orcatrata']['ValidadeCashBackOrca'], 'mysql');
						if(isset($data['orcatrata']['ValidadeCashBackOrca']) && $data['orcatrata']['ValidadeCashBackOrca'] != "0000-00-00" && $data['orcatrata']['ValidadeCashBackOrca'] != ""){
							$data['orcatrata']['ValidadeCashBackOrca'] = $data['orcatrata']['ValidadeCashBackOrca'];
						}else{
							$data['orcatrata']['ValidadeCashBackOrca'] = "0000-00-00";
						}
						$data['CashBackAtual'] = $data['orcatrata']['CashBackOrca'];
						$data['ValidadeAtual'] = $data['orcatrata']['ValidadeCashBackOrca'];
						if($data['orcatrata']['UsarCashBack'] == "N"){
							$data['orcatrata']['CashBackOrca'] = 0.00;
							$data['orcatrata']['ValidadeCashBackOrca'] = "0000-00-00";
						}
						/*
						if($data['orcatrata']['UsarCashBack'] == "S"){
							$data['orcatrata']['CashBackOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['CashBackOrca']));
						}else{
							$data['orcatrata']['CashBackOrca'] = 0.00;
						}
						*/
						$data['orcatrata']['ValorFinalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFinalOrca']));
						$data['orcatrata']['SubValorFinal'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['SubValorFinal']));
					
						#$data['orcatrata']['idTab_TipoRD'] = $data['orcatrata']['idTab_TipoRD'];
						#$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
						#$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						#$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

						if($data['orcatrata']['Entrega_Orca'] == "N"){
							$data['orcatrata']['DataEntregaOrca'] = $data['orcatrata']['DataOrca'];
							$data['orcatrata']['HoraEntregaOrca'] = "00:00:00";
							$data['orcatrata']['PrazoProdServ'] = 0;
							$data['orcatrata']['PrazoCorreios'] = 0;
							$data['orcatrata']['PrazoEntrega'] = 0;
						}
						
						if (!$data['orcatrata']['PrazoEntrega']){
							//$data1 = date('Y-m-d', time());
							$data1 = $data['orcatrata']['DataOrca'];
							$data2 = $data['orcatrata']['DataEntregaOrca'];
							$intervalo = strtotime($data2)-strtotime($data1); 
							$dias = floor($intervalo / (60 * 60 * 24));
							$data['orcatrata']['PrazoEntrega'] = $dias;
						}

						if($_SESSION['Orcatrata']['UsarCupom'] == "N"){
							if($data['orcatrata']['UsarCupom'] == "S"){
								$data['orcatrata']['TipoDescOrca'] = $data['cadastrar']['UsarE'];
								if($data['cadastrar']['ValidaCupom'] == 0 || !$data['orcatrata']['Cupom'] || empty($data['orcatrata']['Cupom'])){
									$data['orcatrata']['Cupom'] = 0;
								}
							}else{
								$data['orcatrata']['Cupom'] = 0;
							}
						}			
						/*
						$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$data['orcatrata']['idApp_OrcaTrata'], TRUE);
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);
						*/
						
						#### APP_Fornecedor ####
						if ($data['cadastrar']['AtualizaEndereco'] == 'S' && $data['orcatrata']['Cli_Forn_Orca'] == 'S' && $data['orcatrata']['idApp_Fornecedor'] != 0){
							$data['fornecedor']['CepFornecedor'] = $data['orcatrata']['Cep'];
							$data['fornecedor']['EnderecoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
							$data['fornecedor']['NumeroFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
							$data['fornecedor']['ComplementoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
							$data['fornecedor']['BairroFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
							$data['fornecedor']['CidadeFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
							$data['fornecedor']['EstadoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
							$data['fornecedor']['ReferenciaFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
										
							$data['update']['fornecedor']['anterior'] = $this->Orcatrata_model->get_fornecedor($data['orcatrata']['idApp_Fornecedor']);
							$data['update']['fornecedor']['campos'] = array_keys($data['fornecedor']);
							/*
							$data['update']['fornecedor']['auditoriaitem'] = $this->basico->set_log(
								$data['update']['fornecedor']['anterior'],
								$data['fornecedor'],
								$data['update']['fornecedor']['campos'],
								$data['fornecedor']['idApp_Fornecedor'], TRUE);
							*/	
							$data['update']['fornecedor']['bd'] = $this->Orcatrata_model->update_fornecedor($data['fornecedor'], $data['orcatrata']['idApp_Fornecedor']);
							
							/*
							// ""ver modo correto de fazer o set_log e set_auditoria""
							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Fornecedor', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}
							*/
							
						}
						
						/*
						//echo count($data['servico']);
						echo '<br>';
						echo "<pre>";
						print_r($data['cliente']);
						echo "</pre>";
						exit ();
						*/			
						
						
						#### App_Servico ####
						$data['update']['servico']['anterior'] = $this->Orcatrata_model->get_servicodesp($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

							if (isset($data['servico']))
								$data['servico'] = array_values($data['servico']);
							else
								$data['servico'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_Produto');

							$max = count($data['update']['servico']['inserir']);
							for($j=0;$j<$max;$j++) {
							
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_1']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_1'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_2']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_2'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_3']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_3'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_4']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_4'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_5']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_5'] = 0;
								}
								if(!$data['update']['servico']['inserir'][$j]['ProfissionalProduto_6']){
									$data['update']['servico']['inserir'][$j]['ProfissionalProduto_6'] = 0;
								}
								
								$data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['Orcatrata']['idSis_Usuario'];
								$data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['servico']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['servico']['inserir'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
								$data['update']['servico']['inserir'][$j]['idTab_TipoRD'] = "1";
								$data['update']['servico']['inserir'][$j]['NivelProduto'] = $_SESSION['Orcatrata']['NivelOrca'];

								if(empty($data['update']['servico']['inserir'][$j]['ValorProduto'])){
									$data['update']['servico']['inserir'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorProduto']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_1'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_1'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_1']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_2'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_2'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_2']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_3'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_3'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_3']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_4'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_4'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_4']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_5'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_5'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_5']));
								}

								if(empty($data['update']['servico']['inserir'][$j]['ValorComProf_6'])){
									$data['update']['servico']['inserir'][$j]['ValorComProf_6'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComProf_6']));
								}
								
								if(empty($data['update']['servico']['inserir'][$j]['ValorComissaoServico'])){
									$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = "0.00";
								}else{
									$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorComissaoServico']));
								}

								//$data['update']['servico']['inserir'][$j]['ValorComissaoVenda'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto'];
								//$data['update']['servico']['inserir'][$j]['ValorComissaoServico'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoServicoProduto'];
								//$data['update']['servico']['inserir'][$j]['ValorComissaoCashBack'] = $data['update']['servico']['inserir'][$j]['SubtotalComissaoCashBackProduto'];
							
								if(!$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] || $data['update']['servico']['inserir'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['servico']['inserir'][$j]['DataValidadeProduto'])){
									$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataValidadeProduto'], 'mysql');
								}
																		
								if(!$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] || $data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['servico']['inserir'][$j]['DataConcluidoProduto'])){
									$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['inserir'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] || $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['HoraConcluidoProduto'];
								}
								
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['ConcluidoProduto'];
								}
								
								unset($data['update']['servico']['inserir'][$j]['SubtotalProduto']);
								//unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto']);
								//unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoServicoProduto']);
								//unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['servico']['inserir'][$j]['SubtotalQtdProduto']);
							}

							$max = count($data['update']['servico']['alterar']);
							for($j=0;$j<$max;$j++) {
							
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_1']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_1'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_2']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_2'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_3']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_3'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_4']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_4'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_5']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_5'] = 0;
								}
								if(!$data['update']['servico']['alterar'][$j]['ProfissionalProduto_6']){
									$data['update']['servico']['alterar'][$j]['ProfissionalProduto_6'] = 0;
								}
								
								//$data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'];
								$data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'];

								if(empty($data['update']['servico']['alterar'][$j]['ValorProduto'])){
									$data['update']['servico']['alterar'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorProduto']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_1'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_1'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_1'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_1']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_2'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_2'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_2'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_2']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_3'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_3'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_3'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_3']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_4'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_4'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_4'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_4']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_5'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_5'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_5'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_5']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComProf_6'])){
									$data['update']['servico']['alterar'][$j]['ValorComProf_6'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComProf_6'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComProf_6']));
								}

								if(empty($data['update']['servico']['alterar'][$j]['ValorComissaoServico'])){
									$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = "0.00";
								}else{
									$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorComissaoServico']));
								}
								
								//$data['update']['servico']['alterar'][$j]['ValorComissaoVenda'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto'];
								//$data['update']['servico']['alterar'][$j]['ValorComissaoServico'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoServicoProduto'];
								//$data['update']['servico']['alterar'][$j]['ValorComissaoCashBack'] = $data['update']['servico']['alterar'][$j]['SubtotalComissaoCashBackProduto'];
								
								if(!$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] || $data['update']['servico']['alterar'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['servico']['alterar'][$j]['DataValidadeProduto'])){
									$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataConcluidoProduto'], 'mysql');
								}
																		
								if(!$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] || $data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['servico']['alterar'][$j]['DataConcluidoProduto'])){
									$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['servico']['alterar'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] || $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['HoraConcluidoProduto'];
								}					
													
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['ConcluidoProduto'];
								}

								if ($data['orcatrata']['idApp_Fornecedor']) $data['update']['servico']['alterar'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];	

								unset($data['update']['servico']['alterar'][$j]['SubtotalProduto']);
								//unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto']);
								//unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoServicoProduto']);
								//unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['servico']['alterar'][$j]['SubtotalQtdProduto']);					
							}

							if (count($data['update']['servico']['inserir']))
								$data['update']['servico']['bd']['inserir'] = $this->Orcatrata_model->set_servico($data['update']['servico']['inserir']);

							if (count($data['update']['servico']['alterar']))
								$data['update']['servico']['bd']['alterar'] = $this->Orcatrata_model->update_servico($data['update']['servico']['alterar']);

							if (count($data['update']['servico']['excluir']))
								$data['update']['servico']['bd']['excluir'] = $this->Orcatrata_model->delete_servico($data['update']['servico']['excluir']);
						}

						#### App_Produto ####
						$data['update']['produto']['anterior'] = $this->Orcatrata_model->get_produtodesp($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

							if (isset($data['produto']))
								$data['produto'] = array_values($data['produto']);
							else
								$data['produto'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_Produto');

							$max = count($data['update']['produto']['inserir']);
							for($j=0;$j<$max;$j++) {
								
								$data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['Orcatrata']['idSis_Usuario'];
								$data['update']['produto']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['produto']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['produto']['inserir'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];
								$data['update']['produto']['inserir'][$j]['idTab_TipoRD'] = "1";
								$data['update']['produto']['inserir'][$j]['NivelProduto'] = $_SESSION['Orcatrata']['NivelOrca'];

								if(empty($data['update']['produto']['inserir'][$j]['ValorProduto'])){
									$data['update']['produto']['inserir'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));
								}
								
								//$data['update']['produto']['inserir'][$j]['ValorComissaoVenda'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto'];
								//$data['update']['produto']['inserir'][$j]['ValorComissaoServico'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoServicoProduto'];
								//$data['update']['produto']['inserir'][$j]['ValorComissaoCashBack'] = $data['update']['produto']['inserir'][$j]['SubtotalComissaoCashBackProduto'];

								if(!$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] || $data['update']['produto']['inserir'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['produto']['inserir'][$j]['DataValidadeProduto'])){
									$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
								}
													
								if(!$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] || $data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['produto']['inserir'][$j]['DataConcluidoProduto'])){
									$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['inserir'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] || $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['HoraConcluidoProduto'];
								}
													
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
								}

								if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
									$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
								} else {
									$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = $data['update']['produto']['inserir'][$j]['DevolvidoProduto'];
								}
								
								unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
								//unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
								//unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoServicoProduto']);
								//unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);
							}

							$max = count($data['update']['produto']['alterar']);
							for($j=0;$j<$max;$j++) {
								
								//$data['update']['produto']['alterar'][$j]['ProfissionalProduto_1'] = $data['update']['produto']['alterar'][$j]['ProfissionalProduto_1'];
								//$data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
								$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
								$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];

								if(empty($data['update']['produto']['alterar'][$j]['ValorProduto'])){
									$data['update']['produto']['alterar'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
								}

								//$data['update']['produto']['alterar'][$j]['ValorComissaoVenda'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto'];
								//$data['update']['produto']['alterar'][$j]['ValorComissaoServico'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoServicoProduto'];
								//$data['update']['produto']['alterar'][$j]['ValorComissaoCashBack'] = $data['update']['produto']['alterar'][$j]['SubtotalComissaoCashBackProduto'];

								if(!$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] || $data['update']['produto']['alterar'][$j]['DataValidadeProduto'] == "00/00/0000" || empty($data['update']['produto']['alterar'][$j]['DataValidadeProduto'])){
									$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
								}
													
								if(!$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] == "00/00/0000" || empty($data['update']['produto']['alterar'][$j]['DataConcluidoProduto'])){
									$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $data['orcatrata']['DataEntregaOrca'];
								}else{
									$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataConcluidoProduto'], 'mysql');
								}
								
								if(!$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] == "00:00" || $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] == ""){
									$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] = $data['orcatrata']['HoraEntregaOrca'];
								}else{
									$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'];
								}
													
								if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
									$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
								} else {
									$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['ConcluidoProduto'];
								}
								
								if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
									$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'S';
								} else {	
									$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = $data['update']['produto']['alterar'][$j]['DevolvidoProduto'];
								}
								
								if ($data['orcatrata']['idApp_Fornecedor']) $data['update']['produto']['alterar'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];

								unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
								//unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
								//unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoServicoProduto']);
								//unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoCashBackProduto']);
								unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);
							}

							if (count($data['update']['produto']['inserir']))
								$data['update']['produto']['bd']['inserir'] = $this->Orcatrata_model->set_produto($data['update']['produto']['inserir']);

							if (count($data['update']['produto']['alterar']))
								$data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

							if (count($data['update']['produto']['excluir']))
								$data['update']['produto']['bd']['excluir'] = $this->Orcatrata_model->delete_produto($data['update']['produto']['excluir']);

						}

						#### App_ParcelasRec ####
						$data['update']['parcelasrec']['anterior'] = $this->Orcatrata_model->get_parcelas($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

							if (isset($data['parcelasrec']))
								$data['parcelasrec'] = array_values($data['parcelasrec']);
							else
								$data['parcelasrec'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

							$max = count($data['update']['parcelasrec']['inserir']);
							for($j=0;$j<$max;$j++) {
								$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								/*
								if ($data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario']){
									$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'];
								}else{
									$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								}
								*/
								$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['parcelasrec']['inserir'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];
								$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "1";
								$data['update']['parcelasrec']['inserir'][$j]['NivelParcela'] = $_SESSION['Orcatrata']['NivelOrca'];
								
								$data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
								$data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
								//$data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
								$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
								if($data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela']){
									$data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'] = $data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'];
								}else{
									$data['update']['parcelasrec']['inserir'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
								}
								if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
									$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
								} else {
									$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
								}
								if ($data['update']['parcelasrec']['inserir'][$j]['Quitado'] == 'S'){
									if(!$data['update']['parcelasrec']['inserir'][$j]['DataPago']){
										$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'];
									}else{
										$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $data['update']['parcelasrec']['inserir'][$j]['DataPago'];
									}
									$data['update']['parcelasrec']['inserir'][$j]['DataLanc'] = date('Y-m-d', time());
								} else {
									$data['update']['parcelasrec']['inserir'][$j]['DataPago'] = "0000-00-00";
									$data['update']['parcelasrec']['inserir'][$j]['DataLanc'] = "0000-00-00";
								}
							}

							$max = count($data['update']['parcelasrec']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
								$data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
								//$data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
								$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
								$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataLanc'], 'mysql');
								if($data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela']){
									$data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'] = $data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'];
								}else{
									$data['update']['parcelasrec']['alterar'][$j]['FormaPagamentoParcela'] = $data['orcatrata']['FormaPagamento'];
								}
								if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
									$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
								} else {
									$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = $data['update']['parcelasrec']['alterar'][$j]['Quitado'];
								}
								if ($data['update']['parcelasrec']['alterar'][$j]['Quitado'] == 'S'){
									if(!$data['update']['parcelasrec']['alterar'][$j]['DataPago']){
										$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'];
									}else{
										$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataPago'];
									}
									if(!$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] || empty($data['update']['parcelasrec']['alterar'][$j]['DataLanc']) || $data['update']['parcelasrec']['alterar'][$j]['DataPago'] == "0000-00-00"){
										$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = date('Y-m-d', time());
									}
								} else {
									$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = "0000-00-00";
									$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = "0000-00-00";
								}
								if ($data['orcatrata']['idApp_Fornecedor']) $data['update']['parcelasrec']['alterar'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
							}

							if (count($data['update']['parcelasrec']['inserir']))
								$data['update']['parcelasrec']['bd']['inserir'] = $this->Orcatrata_model->set_parcelas($data['update']['parcelasrec']['inserir']);

							if (count($data['update']['parcelasrec']['alterar']))
								$data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

							if (count($data['update']['parcelasrec']['excluir']))
								$data['update']['parcelasrec']['bd']['excluir'] = $this->Orcatrata_model->delete_parcelas($data['update']['parcelasrec']['excluir']);

						}
						
						#### App_Procedimento ####
						$data['update']['procedimento']['anterior'] = $this->Orcatrata_model->get_procedimento($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

							if (isset($data['procedimento']))
								$data['procedimento'] = array_values($data['procedimento']);
							else
								$data['procedimento'] = array();

							//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
							$data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_Procedimento');

							$max = count($data['update']['procedimento']['inserir']);
							for($j=0;$j<$max;$j++) {
								$data['update']['procedimento']['inserir'][$j]['TipoProcedimento'] = 1;
								$data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['update']['procedimento']['inserir'][$j]['NivelProcedimento'] = $_SESSION['Orcatrata']['NivelOrca'];
								if(!$data['update']['procedimento']['inserir'][$j]['Compartilhar']){
									$data['update']['procedimento']['inserir'][$j]['Compartilhar'] = $_SESSION['log']['idSis_Usuario'];	
								}
								$data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['procedimento']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
								$data['update']['procedimento']['inserir'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];
								$data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');
								
								if(!$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento']){
									$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
								}else{
									$data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataConcluidoProcedimento'], 'mysql');
								}
							
							}

							$max = count($data['update']['procedimento']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');
								
								if(!$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento']){
									$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'] = "0000-00-00";
								}else{                  
									$data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataConcluidoProcedimento'], 'mysql');
								}
													
								if ($data['orcatrata']['idApp_Fornecedor']) $data['update']['procedimento']['alterar'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];
							}

							if (count($data['update']['procedimento']['inserir']))
								$data['update']['procedimento']['bd']['inserir'] = $this->Orcatrata_model->set_procedimento($data['update']['procedimento']['inserir']);

							if (count($data['update']['procedimento']['alterar']))
								$data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

							if (count($data['update']['procedimento']['excluir']))
								$data['update']['procedimento']['bd']['excluir'] = $this->Orcatrata_model->delete_procedimento($data['update']['procedimento']['excluir']);

						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_contagem($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto > 0){
								$data['orcatrata']['Prd_Srv_Orca'] = "S";
							}
						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto == 0){
								$data['orcatrata']['CombinadoFrete'] = "S";
								#$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['ProntoOrca'] = "S";
								$data['orcatrata']['EnviadoOrca'] = "S";
								$data['orcatrata']['ConcluidoOrca'] = "S";
							}else{
								$data['orcatrata']['ConcluidoOrca'] = "N";
							}
						}
						
						$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['parcelasrec']['posterior'])){
							$max_parcela = count($data['update']['parcelasrec']['posterior']);
							if($max_parcela == 0){
								#$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['AprovadoOrca'] = "S";
								$data['orcatrata']['QuitadoOrca'] = "S";				
							}else{
								$data['orcatrata']['QuitadoOrca'] = "N";
							}
						}
						
						$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'])){
							$max_produto = count($data['update']['produto']['posterior']);
							if($max_produto > 0){
								$data['orcatrata']['CombinadoFrete'] = "S";
								#$data['orcatrata']['AprovadoOrca'] = "S";
							}
						}			

						$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior_sim($data['orcatrata']['idApp_OrcaTrata']);	
						if (isset($data['update']['parcelasrec']['posterior'])){
							$max_parcela = count($data['update']['parcelasrec']['posterior']);
							if($max_parcela > 0){
								#$data['orcatrata']['CombinadoFrete'] = "S";
								$data['orcatrata']['AprovadoOrca'] = "S";				
							}

						}
						
						if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['FinalizadoOrca'] = "S";
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
						}else{
							$data['orcatrata']['FinalizadoOrca'] = "N";
						}			
						
						$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$data['orcatrata']['idApp_OrcaTrata'], TRUE);
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);			
						
						#### Estoque_Produto_posterior####
						
												
							#### Estoque_Produto_posterior ####
							if ($data['orcatrata']['CombinadoFrete'] == 'S' && $data['orcatrata']['CanceladoOrca'] == 'N') {
								
								$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($data['orcatrata']['idApp_OrcaTrata']);
								
								if (count($data['busca']['estoque']['posterior']) > 0) {
									
									$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
									$max_estoque = count($data['busca']['estoque']['posterior']);
									
									if (isset($data['busca']['estoque']['posterior'])){
										
										for($j=1;$j<=$max_estoque;$j++) {
											
											$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
											
											if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
												
												$qtd_produto[$j]	= ($data['busca']['estoque']['posterior'][$j]['QtdProduto'] * $data['busca']['estoque']['posterior'][$j]['QtdIncrementoProduto']);
												
												$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] + $qtd_produto[$j]);
												
												if($diff_estoque[$j] <= 0){
													$estoque[$j] = 0; 
												}else{
													$estoque[$j] = $diff_estoque[$j]; 
												}
												
												$data['alterar']['produto']['posterior'][$j]['Estoque'] = $estoque[$j];
												$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$j], $data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
												
												unset($qtd_produto[$j]);
												unset($diff_estoque[$j]);
												unset($estoque[$j]);
											}
											
										}
										
									}
									
								}
								
							}
						
						
						/*
						/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
									$data['campos'] = array_keys($data['query']);
									$data['anterior'] = array();
									//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
						//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
						*/

						//if ($data['idApp_OrcaTrata'] === FALSE) {
						//if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
						if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);

							if($_SESSION['Orcatrata']['NivelOrca'] == 0){
								$this->load->view('orcatrata/form_orcatrataalterardesp', $data);
							}else{
								$this->load->view('orcatrata/form_orcatrataalterarrecibo', $data);
							}
							
						} else {

							//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
							//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';

							//redirect(base_url() . 'relatorio/orcamento/' . $data['msg']);
							#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
							#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
							redirect(base_url() . 'OrcatrataPrint/imprimirdesp/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
							exit();
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }	

    public function excluir($id = FALSE) {
		
		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Delet_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
				$data['msg'] = '';
			
			if (!$id) {

				unset($_SESSION['Orcatrata']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {
			
				$data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
				
				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 2 || $data['orcatrata']['idApp_Cliente'] == 0){
					
					unset($_SESSION['Orcatrata']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {
					#### Carrega os dados do cliente nas vari�ves de sess�o ####

					$data['query'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);	
					
					if($data['query'] === FALSE){
						
						unset($_SESSION['Orcatrata']);
						unset($_SESSION['Cliente']);
						$data['msg'] = '?m=3';
						redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
						exit();
						
					} else {
						$this->Orcatrata_model->delete_orcatrata($id);

						$data['msg'] = '?m=1';

						//redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
						redirect(base_url() . 'orcatrata/listar/' . $data['query']['idApp_Cliente'] . $data['msg']);

						exit();
					}
				}
			}
		}	
        $this->load->view('basico/footer');
    }
	
    public function excluir2($id = FALSE) {

		$acesso = FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$acesso = TRUE;
		}else{
			if($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Usuario']['Nivel'] != 2 && $_SESSION['Usuario']['Usu_Rec'] == "S" && $_SESSION['Usuario']['Delet_Orcam'] == "S"){
				$acesso = TRUE;
			}	
		}
		
		if($acesso === FALSE){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
				$data['msg'] = '';
			
			if (!$id) {

				unset($_SESSION['Orcatrata']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {
			
				$data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
				
				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 2 || $data['orcatrata']['idApp_Cliente'] != 0){
					
					unset($_SESSION['Orcatrata']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {
					
					$this->Orcatrata_model->delete_orcatrata($id);

					$data['msg'] = '?m=1';

					redirect(base_url() . 'Receitas/receitas/' . $data['msg']);
					
					exit();
				}
			}
		}			
        $this->load->view('basico/footer');
    }

    public function excluirdesp($id = FALSE) {

		$acesso = FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$acesso = TRUE;
		}else{
			if($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Usuario']['Nivel'] != 2 && $_SESSION['Usuario']['Usu_Des'] == "S"){
				$acesso = TRUE;
			}	
		}
		
		if($acesso === FALSE){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
				$data['msg'] = '';
			
			if (!$id) {

				unset($_SESSION['Orcatrata']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {
			
				$data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
				
				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 1){
					
					unset($_SESSION['Orcatrata']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {
					
					$this->Orcatrata_model->delete_orcatrata($id);
					$data['msg'] = '?m=1';
					redirect(base_url() . 'Despesas/despesas/' . $data['msg']);
					exit();
				}
			}
		}
        $this->load->view('basico/footer');
    }	
	
    public function listar($id = NULL) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Ver_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{
			
			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
				$data['msg'] = '';

			if (!$id) {

				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {
				
				$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($id, TRUE);
				
				if($data['cliente'] === FALSE){
					
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {
					
					$data['combinado'] = $this->Orcatrata_model->list_orcamentocomb($id, 'S', TRUE);
					$data['naocombinado'] = $this->Orcatrata_model->list_orcamentocomb($id, 'N', TRUE);
					$data['aprovado'] = $this->Orcatrata_model->list_orcamento($id, 'S', TRUE);
					$data['naoaprovado'] = $this->Orcatrata_model->list_orcamento($id, 'N', TRUE);
					$data['finalizado'] = $this->Orcatrata_model->list_orcamentofinal($id, 'S', TRUE);
					$data['naofinalizado'] = $this->Orcatrata_model->list_orcamentofinal($id, 'N', TRUE);
					$data['cancelado'] = $this->Orcatrata_model->list_orcamentocancel($id, 'S', TRUE);
					$data['naocancelado'] = $this->Orcatrata_model->list_orcamentocancel($id, 'N', TRUE);
					$data['concluido_orc'] = $this->Procedimento_model->list_procedimento_orc($id, 'S', TRUE);
					$data['nao_concluido_orc'] = $this->Procedimento_model->list_procedimento_orc($id, 'N', TRUE);
					
					$data['titulo'] = 'Or�amento : ';

					//$data['aprovado'] = array();
					//$data['naoaprovado'] = array();
					/*
					  echo "<pre>";
					  print_r($data['query']);
					  echo "</pre>";
					  exit();
					 */

					$data['list'] = $this->load->view('orcatrata/list_orcatrata', $data, TRUE);
					
					$data['cor_cli'] 	= 'default';
					$data['cor_cons'] 	= 'default';
					$data['cor_orca'] 	= 'warning';
					$data['cor_sac'] 	= 'default';
					$data['cor_mark'] 	= 'default';

					$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

					$this->load->view('orcatrata/list_orcatrata', $data);
				}
			}
		}
		$this->load->view('basico/footer');
    }

	public function arquivos($id = FALSE) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Edit_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{
			
			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
				$data['msg'] = '';
			
			if (!$id) {

				unset($_SESSION['Orcatrata']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {

				$_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata_arquivo($id);

				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 2){
					
					unset($_SESSION['Orcatrata']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {
					
					if($_SESSION['Orcatrata']['idApp_Cliente'] != 0){
						
						$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($_SESSION['Orcatrata']['idApp_Cliente']);			
						
						if($data['query'] === FALSE){
							
							unset($_SESSION['Orcatrata']);
							unset($_SESSION['Cliente']);
							$data['msg'] = '?m=3';
							redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
							exit();
							
						} else {
							$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
						}
					}else{
						unset($_SESSION['Cliente']);
					}
					
					$data['cor_cli'] 	= 'default';
					$data['cor_cons'] 	= 'default';
					$data['cor_orca'] 	= 'warning';
					$data['cor_sac'] 	= 'default';
					$data['cor_mark'] 	= 'default';
					
					$data['nav_orca'] 		= 'S';
					$data['nav_status'] 	= 'S';
					$data['nav_alterar'] 	= 'N';
					
					$data['nav_imprimir'] 	= 'N';
					$data['nav_entrega'] 	= 'S';
					$data['nav_cobranca'] 	= 'S';

					$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

					$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
					#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

					$data['titulo'] = 'Arquivos';

					#run form validation
					if ($this->form_validation->run() !== TRUE) {
						$data['bd']['idApp_OrcaTrata'] 	= $data['orcatrata']['idApp_OrcaTrata'];

						$data['report'] = $this->Orcatrata_model->list_arquivos($data['bd'],TRUE);

						/*
						  echo "<pre>";
						  print_r($data['report']);
						  echo "</pre>";
						  exit();
						  */

						$data['list'] = $this->load->view('orcatrata/list_arquivos', $data, TRUE);

					}

					$this->load->view('orcatrata/tela_arquivos', $data);
				}	
			}
		}
		$this->load->view('basico/footer');

    }

    public function cadastrar_arquivos($id = FALSE) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Edit_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
				$data['msg'] = '';
			
			$data['query'] = quotes_to_entities($this->input->post(array(
				#'idApp_Arquivos',
				'Arquivos',
				'Texto_Arquivos',
				'Ativo_Arquivos',
				'idSis_Usuario',
				'idSis_Empresa',
				'idApp_OrcaTrata',
			), TRUE));
			
			$data['file'] = $this->input->post(array(
				'idApp_Arquivos',
				'idSis_Empresa',
				'Arquivo',
			), TRUE);

			if ($id) {
				
				$_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata_arquivo($id);
				
				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 2){
					
					unset($_SESSION['Orcatrata']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				}
			}
			
			if(!$_SESSION['Orcatrata'] || $_SESSION['Orcatrata']['idTab_TipoRD'] != 2){
				
				unset($_SESSION['Orcatrata']);
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {
				
				if($_SESSION['Orcatrata']['idApp_Cliente'] != 0){
					
					$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($_SESSION['Orcatrata']['idApp_Cliente']);			
					
					if($data['cliente'] === FALSE){
						
						unset($_SESSION['Orcatrata']);
						unset($_SESSION['Cliente']);
						$data['msg'] = '?m=3';
						redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
						exit();
						
					} else {
						$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
					}
				}else{
					unset($_SESSION['Cliente']);
				}
				/*
				echo "<pre>";
				print_r($data['orcatrata']);
				echo "</pre>";
				exit();
				*/
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				$data['select']['Ativo_Arquivos'] = $this->Basico_model->select_status_sn();
				
				if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
					
					$data['file']['Arquivo'] = $this->basico->nomeiaarquivos($_FILES['Arquivo']['name']);
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
				}
				else {
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
				}

				$data['titulo'] = 'Alterar Foto';
				$data['form_open_path'] = 'orcatrata/cadastrar_arquivos';
				$data['readonly'] = 'readonly';
				$data['panel'] = 'primary';
				$data['metodo'] = 1;

				$data['cor_cli'] 	= 'default';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'warning';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';
				
				$data['nav_orca'] 		= 'S';
				$data['nav_status'] 	= 'S';
				$data['nav_alterar'] 	= 'N';
				
				$data['nav_imprimir'] 	= 'N';
				$data['nav_entrega'] 	= 'S';
				$data['nav_cobranca'] 	= 'S';

				$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

				(!$data['query']['Ativo_Arquivos']) ? $data['query']['Ativo_Arquivos'] = 'S' : FALSE;       
				
				$data['radio'] = array(
					'Ativo_Arquivos' => $this->basico->radio_checked($data['query']['Ativo_Arquivos'], 'Ativo_Arquivos', 'NS'),
				);
				($data['query']['Ativo_Arquivos'] == 'S') ?
					$data['div']['Ativo_Arquivos'] = '' : $data['div']['Ativo_Arquivos'] = 'style="display: none;"';		
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					#load login view
					$this->load->view('orcatrata/form_cad_arquivos', $data);
				} else {

					$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
					$config['max_size'] = 1000;
					$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
					$config['file_name'] = $data['file']['Arquivo'];

					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('Arquivo')) {
						$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
						$this->load->view('orcatrata/form_cad_arquivos', $data);
					} else {
					
						$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';		
						$foto = $data['file']['Arquivo'];
						$diretorio = $dir.$foto;					
						$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';

						switch($_FILES['Arquivo']['type']):
							case 'image/jpg';
							case 'image/jpeg';
							case 'image/pjpeg';
						
								list($largura, $altura, $tipo) = getimagesize($diretorio);
								
								$img = imagecreatefromjpeg($diretorio);

								$thumb = imagecreatetruecolor(600, 315);
								
								imagecopyresampled($thumb, $img, 0, 0, 0, 0, 600, 315, $largura, $altura);
								
								imagejpeg($thumb, $dir2 . $foto);
								imagedestroy($img);
								imagedestroy($thumb);				      
							
							break;					

							case 'image/png':
							case 'image/x-png';
								
								list($largura, $altura, $tipo) = getimagesize($diretorio);
								
								$img = imagecreatefrompng($diretorio);

								$thumb = imagecreatetruecolor(600, 315);
								
								imagecopyresampled($thumb, $img, 0, 0, 0, 0, 600, 315, $largura, $altura);
								
								imagejpeg($thumb, $dir2 . $foto);
								imagedestroy($img);
								imagedestroy($thumb);				      
							
							break;
							
						endswitch;			
						
						$data['query']['Arquivos'] = $data['file']['Arquivo'];
						$data['query']['Texto_Arquivos'] = $data['query']['Texto_Arquivos'];
						$data['query']['Ativo_Arquivos'] = $data['query']['Ativo_Arquivos'];
						$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
						$data['query']['idApp_OrcaTrata'] = $_SESSION['Orcatrata']['idApp_OrcaTrata'];

						$data['campos'] = array_keys($data['query']);
						$data['anterior'] = array();

						$data['idApp_Arquivos'] = $this->Orcatrata_model->set_arquivos($data['query']);

						if ($data['idApp_Arquivos'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
							$this->basico->erro($msg);
							$this->load->view('orcatrata/form_cad_arquivos', $data);
						} else {

							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Arquivos'], FALSE);
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Arquivos', 'CREATE', $data['auditoriaitem']);
							
							$data['file']['idApp_Arquivos'] = $data['idApp_Arquivos'];					
							$data['file']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
							$data['camposfile'] = array_keys($data['file']);
							$data['idSis_Arquivo'] = $this->Orcatrata_model->set_arquivo($data['file']);

							if ($data['idSis_Arquivo'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
								$this->basico->erro($msg);
								$this->load->view('orcatrata/form_cad_arquivos', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);						

								$data['msg'] = '?m=1';

								#redirect(base_url() . 'relatorio/arquivos' . $data['msg']);
								#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Orcatrata']['idApp_Cliente'] . $data['msg']);
								#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
								redirect(base_url() . 'Orcatrata/arquivos/' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . $data['msg']);
								exit();
							}				
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }
		
    public function alterar_arquivos($id = FALSE) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Edit_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
				$data['msg'] = '';
			
			$data['arquivos'] = quotes_to_entities($this->input->post(array(
				'idApp_Arquivos',
				'Texto_Arquivos',
				'Ativo_Arquivos',
			), TRUE));
					
			$data['file'] = $this->input->post(array(
				'idApp_Arquivos',
				'idSis_Empresa',
				'Arquivo',
			), TRUE);

			if ($id) {
				$_SESSION['Arquivos'] = $data['arquivos'] = $this->Orcatrata_model->get_arquivos($id, TRUE);
				$data['file']['idApp_Arquivos'] = $id;
			
				if($data['arquivos'] === FALSE){
					
					unset($_SESSION['Arquivos']);
					unset($_SESSION['Orcatrata']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				}
			}
			
			if(!$data['arquivos']['idApp_Arquivos'] || !$_SESSION['Arquivos']){
				
				unset($_SESSION['Arquivos']);
				unset($_SESSION['Orcatrata']);
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {			
				
				$_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata_arquivo($_SESSION['Arquivos']['idApp_OrcaTrata']);
			
				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 2){
					
					unset($_SESSION['Arquivos']);
					unset($_SESSION['Orcatrata']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {

					if($_SESSION['Orcatrata']['idApp_Cliente'] != 0){
						
						$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($_SESSION['Orcatrata']['idApp_Cliente']);			
						
						if($data['cliente'] === FALSE){
							
							unset($_SESSION['Arquivos']);
							unset($_SESSION['Orcatrata']);
							unset($_SESSION['Cliente']);
							$data['msg'] = '?m=3';
							redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
							exit();
							
						} else {
							$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
						}
					}else{
						unset($_SESSION['Cliente']);
					}
					/*
					echo "<pre>";
					print_r($_SESSION['Arquivos']['idApp_OrcaTrata']);
					echo "</pre>";
					exit();
					*/
					
					$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

					$data['select']['Ativo_Arquivos'] = $this->Basico_model->select_status_sn();		
					
					if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
						
						$data['file']['Arquivo'] = $this->basico->renomeiaarquivos($_FILES['Arquivo']['name']);
						$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
					} else {
						$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
					}

					$data['titulo'] = 'Alterar Foto';
					$data['form_open_path'] = 'orcatrata/alterar_arquivos';
					$data['readonly'] = 'readonly';
					$data['panel'] = 'primary';
					$data['metodo'] = 2;

					$data['cor_cli'] 	= 'default';
					$data['cor_cons'] 	= 'default';
					$data['cor_orca'] 	= 'warning';
					$data['cor_sac'] 	= 'default';
					$data['cor_mark'] 	= 'default';
					
					$data['nav_orca'] 		= 'S';
					$data['nav_status'] 	= 'S';
					$data['nav_alterar'] 	= 'N';
					
					$data['nav_imprimir'] 	= 'N';
					$data['nav_entrega'] 	= 'S';
					$data['nav_cobranca'] 	= 'S';

					$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

					(!$data['arquivos']['Ativo_Arquivos']) ? $data['arquivos']['Ativo_Arquivos'] = 'S' : FALSE;       
					
					$data['radio'] = array(
						'Ativo_Arquivos' => $this->basico->radio_checked($data['arquivos']['Ativo_Arquivos'], 'Ativo_Arquivos', 'NS'),
					);
					($data['arquivos']['Ativo_Arquivos'] == 'S') ?
						$data['div']['Ativo_Arquivos'] = '' : $data['div']['Ativo_Arquivos'] = 'style="display: none;"';
					
					#run form validation
					if ($this->form_validation->run() === FALSE) {
						#load login view
						$this->load->view('orcatrata/form_arquivos', $data);
					} else {

						$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
						$config['max_size'] = 1000;
						$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
						$config['file_name'] = $data['file']['Arquivo'];

						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('Arquivo')) {
							$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
							$this->load->view('orcatrata/form_arquivos', $data);
						} else {
						
							$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';		
							$foto = $data['file']['Arquivo'];
							$diretorio = $dir.$foto;					
							$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';

							switch($_FILES['Arquivo']['type']):
								case 'image/jpg';
								case 'image/jpeg';
								case 'image/pjpeg';
							
									list($largura, $altura, $tipo) = getimagesize($diretorio);
									
									$img = imagecreatefromjpeg($diretorio);

									$thumb = imagecreatetruecolor(600, 315);
									
									imagecopyresampled($thumb, $img, 0, 0, 0, 0, 600, 315, $largura, $altura);
									
									imagejpeg($thumb, $dir2 . $foto);
									imagedestroy($img);
									imagedestroy($thumb);				      
								
								break;					

								case 'image/png':
								case 'image/x-png';
									
									list($largura, $altura, $tipo) = getimagesize($diretorio);
									
									$img = imagecreatefrompng($diretorio);

									$thumb = imagecreatetruecolor(600, 315);
									
									imagecopyresampled($thumb, $img, 0, 0, 0, 0, 600, 315, $largura, $altura);
									
									imagejpeg($thumb, $dir2 . $foto);
									imagedestroy($img);
									imagedestroy($thumb);				      
								
								break;
								
							endswitch;			

							$data['camposfile'] = array_keys($data['file']);
							$data['file']['idSis_Empresa'] = $_SESSION['Empresa']['idSis_Empresa'];
							$data['idSis_Arquivo'] = $this->Orcatrata_model->set_arquivo($data['file']);

							if ($data['idSis_Arquivo'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
								$this->basico->erro($msg);
								$this->load->view('orcatrata/form_arquivos', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
								
								$data['arquivos']['Arquivos'] = $data['file']['Arquivo'];
								$data['arquivos']['Texto_Arquivos'] = $data['arquivos']['Texto_Arquivos'];
								$data['arquivos']['Ativo_Arquivos'] = $data['arquivos']['Ativo_Arquivos'];
								$data['anterior'] = $this->Orcatrata_model->get_arquivos($data['arquivos']['idApp_Arquivos']);
								$data['campos'] = array_keys($data['arquivos']);

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['arquivos'], $data['campos'], $data['arquivos']['idApp_Arquivos'], TRUE);

								if ($data['auditoriaitem'] && $this->Orcatrata_model->update_arquivos($data['arquivos'], $data['arquivos']['idApp_Arquivos']) === FALSE) {
									$data['msg'] = '?m=2';
									redirect(base_url() . 'orcatrata/form_arquivos/' . $data['arquivos']['idApp_Arquivos'] . $data['msg']);
									exit();
								} else {

									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/arquivos.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . '');						
									}
									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/arquivos.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . '');						
									}						
									
									if ($data['auditoriaitem'] === FALSE) {
										$data['msg'] = '';
									} else {
										$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Arquivos', 'UPDATE', $data['auditoriaitem']);
										$data['msg'] = '?m=1';
									}

									//redirect(base_url() . 'relatorio/site/' . $data['msg']);
									redirect(base_url() . 'Orcatrata/arquivos/' . $_SESSION['Arquivos']['idApp_OrcaTrata'] . $data['msg']);
									exit();
								}				
							}
						}
					}
				}	
			}	
		}
        $this->load->view('basico/footer');
    }
	
    public function alterar_texto($id = FALSE) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Edit_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
				$data['msg'] = '';
			
			$data['arquivos'] = quotes_to_entities($this->input->post(array(
				//'idSis_Usuario',
				'idApp_Arquivos',
				'Texto_Arquivos',
				'Ativo_Arquivos',
				//'idSis_Empresa',
					), TRUE));

			if ($id){
				
				$_SESSION['Arquivos'] = $data['arquivos'] = $this->Orcatrata_model->get_arquivos($id);
				
				if($data['arquivos'] === FALSE){
					
					unset($_SESSION['Arquivos']);
					unset($_SESSION['Orcatrata']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				}
			}
			
			if(!$data['arquivos']['idApp_Arquivos'] || !$_SESSION['Arquivos']){
				
				unset($_SESSION['Arquivos']);
				unset($_SESSION['Orcatrata']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {
				
				$_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata_arquivo($_SESSION['Arquivos']['idApp_OrcaTrata']);

				if($data['orcatrata'] === FALSE || $data['orcatrata']['idTab_TipoRD'] != 2){
					
					unset($_SESSION['Arquivos']);
					unset($_SESSION['Orcatrata']);
					unset($_SESSION['Cliente']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {

					if($_SESSION['Orcatrata']['idApp_Cliente'] != 0){
						
						$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($_SESSION['Orcatrata']['idApp_Cliente']);			
						
						if($data['cliente'] === FALSE){
							
							unset($_SESSION['Arquivos']);
							unset($_SESSION['Orcatrata']);
							unset($_SESSION['Cliente']);
							$data['msg'] = '?m=3';
							redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
							exit();
							
						} else {
							$_SESSION['Cliente']['NomeCliente'] = (strlen($data['cliente']['NomeCliente']) > 12) ? substr($data['cliente']['NomeCliente'], 0, 12) : $data['cliente']['NomeCliente'];
						}
					}else{
						unset($_SESSION['Cliente']);
					}
					
					$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

					$this->form_validation->set_rules('Texto_Arquivos', 'Texto do Arquivo', 'trim');
					
					$data['select']['Ativo_Arquivos'] = $this->Basico_model->select_status_sn();

					$data['titulo'] = 'Editar Slide';
					$data['form_open_path'] = 'orcatrata/alterar_texto';
					$data['readonly'] = '';
					$data['disabled'] = '';
					$data['panel'] = 'primary';
					$data['metodo'] = 2;
					$data['button'] =
							'
							<button class="btn btn-sm btn-warning" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-edit"></span> Salvar Altera��o
							</button>
					';

					$data['cor_cli'] 	= 'default';
					$data['cor_cons'] 	= 'default';
					$data['cor_orca'] 	= 'warning';
					$data['cor_sac'] 	= 'default';
					$data['cor_mark'] 	= 'default';
					
					$data['nav_orca'] 		= 'S';
					$data['nav_status'] 	= 'S';
					$data['nav_alterar'] 	= 'N';
					
					$data['nav_imprimir'] 	= 'N';
					$data['nav_entrega'] 	= 'S';
					$data['nav_cobranca'] 	= 'S';

					$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

					$data['sidebar'] = 'col-sm-3 col-md-2';
					$data['main'] = 'col-sm-7 col-md-8';

					(!$data['arquivos']['Ativo_Arquivos']) ? $data['arquivos']['Ativo_Arquivos'] = 'S' : FALSE;       
					
					$data['radio'] = array(
						'Ativo_Arquivos' => $this->basico->radio_checked($data['arquivos']['Ativo_Arquivos'], 'Ativo_Arquivos', 'NS'),
					);
					($data['arquivos']['Ativo_Arquivos'] == 'S') ?
						$data['div']['Ativo_Arquivos'] = '' : $data['div']['Ativo_Arquivos'] = 'style="display: none;"';
						
					#run form validation
					if ($this->form_validation->run() === FALSE) {
						$this->load->view('orcatrata/form_texto_arquivos', $data);
					} else {
						$data['arquivos']['Texto_Arquivos'] = $data['arquivos']['Texto_Arquivos'];
						$data['arquivos']['Ativo_Arquivos'] = $data['arquivos']['Ativo_Arquivos'];
						//$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						//$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

						$data['anterior'] = $this->Orcatrata_model->get_arquivos($data['arquivos']['idApp_Arquivos']);
						$data['campos'] = array_keys($data['arquivos']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['arquivos'], $data['campos'], $data['arquivos']['idApp_Arquivos'], TRUE);

						if ($data['auditoriaitem'] && $this->Orcatrata_model->update_arquivos($data['arquivos'], $data['arquivos']['idApp_Arquivos']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'orcatrata/form_texto_arquivos' . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Arquivos', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							//redirect(base_url() . 'relatorio/arquivos/' . $data['msg']);
							redirect(base_url() . 'Orcatrata/arquivos/' . $_SESSION['Arquivos']['idApp_OrcaTrata'] . $data['msg']);
							exit();
						}
					}
				}
			}
		}
        $this->load->view('basico/footer');
    }

	public function excluir_arquivos($id = FALSE) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Edit_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{

			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
				$data['msg'] = '';
			
			if (!$id) {

				unset($_SESSION['Arquivos']);
				unset($_SESSION['Orcatrata']);
				$data['msg'] = '?m=3';
				redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
				exit();
				
			} else {

				$_SESSION['Arquivos'] = $data['arquivos'] = $this->Orcatrata_model->get_arquivos($id, TRUE);
				
				if($data['arquivos'] === FALSE){
					
					unset($_SESSION['Arquivos']);
					unset($_SESSION['Orcatrata']);
					$data['msg'] = '?m=3';
					redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
					exit();
					
				} else {
					
					$this->Orcatrata_model->delete_arquivos($_SESSION['Arquivos']['idApp_Arquivos']);

					$data['msg'] = '?m=1';
					
					if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . ''))
						&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . '')
						!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/arquivos.jpg'))){
						unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . '');						
					}
					if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . ''))
						&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . '')
						!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/arquivos.jpg'))){
						unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . '');						
					}
					
					//redirect(base_url() . 'relatorio/arquivos/' . $data['msg']);
					redirect(base_url() . 'Orcatrata/arquivos/' . $_SESSION['Arquivos']['idApp_OrcaTrata'] . $data['msg']);
					exit();
						
				}
					
			}
		}
        $this->load->view('basico/footer');
    }

    public function baixaparcelasrepet($id = FALSE) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Edit_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{
			
			if ($id) {
				#### App_OrcaTrata ####
				$_SESSION['Orcatrata'] = $data['baixaorca'] = $this->Orcatrata_model->get_orcatrata($id);		
				
				if ($data['baixaorca'] !== FALSE && $data['baixaorca']['idTab_TipoRD'] == 2) {

					if($this->Basico_model->get_dt_validade() !== FALSE){
		
						////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
						#### App_OrcaTrata ####
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
						if($_SESSION['Orcatrata']['ConcluidoOrca'] == "S"){
							$data['orcatrata']['FinalizadoOrca'] = "S";
						}
						$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata_baixa($id);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$id, 
						TRUE);
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $id);


						#### App_ParcelasRec ####
						$data['update']['parcelasrec']['alterar'] = $this->Orcatrata_model->get_parcelas_posterior($id);
						if (isset($data['update']['parcelasrec']['alterar'])){
						
							$max = count($data['update']['parcelasrec']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';				
								if(!$data['update']['parcelasrec']['alterar'][$j]['DataPago'] || $data['update']['parcelasrec']['alterar'][$j]['DataPago'] == "0000-00-00"){
									$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'];
								}				
							}
							if (count($data['update']['parcelasrec']['alterar']))
								$data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

						}
					}
				}
			}
			
			return ($this->db->affected_rows() === 0) ? FALSE : TRUE;
		}	
    }

    public function baixaprodutosrepet($id = FALSE) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Edit_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{
			
			if ($id) {
				#### App_OrcaTrata ####
				$_SESSION['Orcatrata'] = $data['baixaorca'] = $this->Orcatrata_model->get_orcatrata($id);		

				if ($data['baixaorca'] !== FALSE && $data['baixaorca']['idTab_TipoRD'] == 2) {

					if($this->Basico_model->get_dt_validade() !== FALSE){
						
						////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
						#### App_OrcaTrata ####
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						if($_SESSION['Orcatrata']['QuitadoOrca'] == "S"){
							$data['orcatrata']['FinalizadoOrca'] = "S";
						}
				   
						$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata_baixa($id);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$id, 
						TRUE);
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $id);

						#### App_Produto ####
						$data['update']['produto']['alterar'] = $this->Orcatrata_model->get_produto_posterior($id);
						if (isset($data['update']['produto']['alterar'])){

							$max = count($data['update']['produto']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
								if(!$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] == "0000-00-00"){
									$data['update']['produto']['alterar'][$j]['DataConcluidoProduto'] = $data['update']['orcatrata']['anterior']['DataEntregaOrca'];
								}
								if(!$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] || $data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] == "00:00:00"){
									$data['update']['produto']['alterar'][$j]['HoraConcluidoProduto'] = $data['update']['orcatrata']['anterior']['HoraEntregaOrca'];
								}
							}
							
							if (count($data['update']['produto']['alterar']))
								$data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

						}

						#### Estoque_Produto_posterior ####
						if(($_SESSION['Orcatrata']['CombinadoFrete'] == 'N' || $_SESSION['Orcatrata']['AprovadoOrca'] == 'N') && $_SESSION['Orcatrata']['CanceladoOrca'] == 'N') {
							
							$data['busca']['estoque']['posterior'] = $this->Orcatrata_model->get_produto_estoque($id);
							
							if (count($data['busca']['estoque']['posterior']) > 0) {
								
								$data['busca']['estoque']['posterior'] = array_combine(range(1, count($data['busca']['estoque']['posterior'])), array_values($data['busca']['estoque']['posterior']));
								$max_estoque = count($data['busca']['estoque']['posterior']);
								
								if (isset($data['busca']['estoque']['posterior'])){
									
									for($j=1;$j<=$max_estoque;$j++) {
										
										$data['get']['produto'][$j] = $this->Orcatrata_model->get_tab_produtos($data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
										
										if($data['get']['produto'][$j]['ContarEstoque'] == "S"){
											
											$qtd_produto[$j]	= ($data['busca']['estoque']['posterior'][$j]['QtdProduto'] * $data['busca']['estoque']['posterior'][$j]['QtdIncrementoProduto']);
											
											$diff_estoque[$j] 	= ($data['get']['produto'][$j]['Estoque'] - $qtd_produto[$j]);
											
											if($diff_estoque[$j] <= 0){
												$estoque[$j] = 0; 
											}else{
												$estoque[$j] = $diff_estoque[$j]; 
											}
											
											$data['alterar']['produto']['posterior'][$j]['Estoque'] = $estoque[$j];
											$data['alterar']['produto']['posterior']['bd'] = $this->Orcatrata_model->update_tab_produtos_id($data['alterar']['produto']['posterior'][$j], $data['busca']['estoque']['posterior'][$j]['idTab_Produtos_Produto']);
											
											unset($qtd_produto[$j]);
											unset($diff_estoque[$j]);
											unset($estoque[$j]);
										}
										
									}
									
								}
								
							}
							
						}
					}
				}			
			}
			
			return ($this->db->affected_rows() === 0) ? FALSE : TRUE;
		}
    }

    public function revert_baixaparcelasrepet($id = FALSE) {

		if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Nivel'] == 2 || $_SESSION['Usuario']['Usu_Rec'] == "N" || $_SESSION['Usuario']['Edit_Orcam'] == "N"){
			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
		}else{
			
			if ($id) {
				#### App_OrcaTrata ####
				$_SESSION['Orcatrata'] = $data['baixaorca'] = $this->Orcatrata_model->get_orcatrata($id);		
				
				if ($data['baixaorca'] !== FALSE && $data['baixaorca']['idTab_TipoRD'] == 2) {

					if($this->Basico_model->get_dt_validade() !== FALSE){
							
						////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
						#### App_OrcaTrata ####
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "N";
						$data['orcatrata']['FinalizadoOrca'] = "N";
						
						$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata_baixa($id);
						$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
						$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['orcatrata']['anterior'],
							$data['orcatrata'],
							$data['update']['orcatrata']['campos'],
							$id, 
						TRUE);
						$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $id);


						#### App_ParcelasRec ####
						$data['update']['parcelasrec']['alterar'] = $this->Orcatrata_model->get_parcelas_posterior_sim($id);
						if (isset($data['update']['parcelasrec']['alterar'])){
						
							$max = count($data['update']['parcelasrec']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'N';	
								$data['update']['parcelasrec']['alterar'][$j]['DataPago'] = "0000-00-00";
								$data['update']['parcelasrec']['alterar'][$j]['DataLanc'] = "0000-00-00";
							}
							if (count($data['update']['parcelasrec']['alterar']))
								$data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

						}
					}
				}
			}
			
			return ($this->db->affected_rows() === 0) ? FALSE : TRUE;
		}
    }

}