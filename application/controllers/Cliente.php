<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Relatorio_model', 'Associado_model', 'Cliente_model', 'Contatocliente_model', 'Clientedep_model', 'Clientepet_model'));
        #$this->load->model(array('Basico_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('cliente/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('cliente/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

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
		
			$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id);
		
			if(!$data['query']['idApp_Cliente'] || $_SESSION['Cliente'] === FALSE){
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {			
								
				$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
				
				#$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
				$data['titulo'] = 'Prontu�rio ' . $data['query']['NomeCliente'];
				$data['panel'] = 'primary';
				$data['metodo'] = 4;

				$_SESSION['log']['idApp_Cliente'] = $data['resumo']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
				$data['resumo']['NomeCliente'] = $data['query']['NomeCliente'];

				$data['query']['Idade'] = $this->basico->calcula_idade($data['query']['DataNascimento']);
				$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');

				/*
				if ($data['query']['Sexo'] == 1)
					$data['query']['profile'] = 'm';
				elseif ($data['query']['Sexo'] == 2)
					$data['query']['profile'] = 'f';
				else
					$data['query']['profile'] = 'o';
				*/
				$data['query']['profile'] = ($data['query']['Sexo']) ? strtolower($data['query']['Sexo']) : 'o';

				$data['query']['Sexo'] = $this->Basico_model->get_sexo($data['query']['Sexo']);
				$data['query']['Ativo'] = $this->Basico_model->get_ativo($data['query']['Ativo']);
				$data['query']['ClienteConsultor'] = $this->Basico_model->get_ativo($data['query']['ClienteConsultor']);
				$data['query']['idSis_Empresa'] = $this->Basico_model->get_empresa($data['query']['idSis_Empresa']);
				$data['query']['Profissional'] = $this->Basico_model->get_profissional($data['query']['Profissional']);
				
				$data['query']['Telefone'] = $data['query']['CelularCliente'] . ' - ' . $data['query']['Telefone'];
				($data['query']['Telefone2']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone2'] : FALSE;
				($data['query']['Telefone3']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone3'] : FALSE;


				if ($data['query']['MunicipioCliente']) {
					$mun = $this->Basico_model->get_municipio($data['query']['MunicipioCliente']);
					$data['query']['MunicipioCliente'] = $mun['NomeMunicipio'] . '/' . $mun['Uf'];
				} else {
					$data['query']['MunicipioCliente'] = $data['query']['Uf'] = $mun['Uf'] = '';
				}

				$data['contatocliente'] = $this->Contatocliente_model->lista_contatocliente($id, TRUE);
				/*
				  echo "<pre>";
				  print_r($data['contatocliente']);
				  echo "</pre>";
				  exit();
				*/
				if (!$data['contatocliente'])
					$data['list'] = FALSE;
				else
					$data['list'] = $this->load->view('contatocliente/list_contatocliente', $data, TRUE);
			
			
				$data['cor_cli'] 	= 'warning';
				$data['cor_cons'] 	= 'default';
				$data['cor_orca'] 	= 'default';
				$data['cor_sac'] 	= 'default';
				$data['cor_mark'] 	= 'default';
				
				$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

				$this->load->view('cliente/tela_cliente', $data);
			}
		}
	
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>N�o � poss�vel salvar o novo Registro.<br>N�o identificamos o pagamento da sua �ltima Fatura.<br>Por favor,<br>Entre em contato com a administra��o da<br>Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'Cadastrar',
				'CadastrarResp',
				'Responsavel',
				'idApp_Responsavel',
				'RelacaoDep',
			), TRUE));        
			
			$data['query'] = quotes_to_entities($this->input->post(array(
				'idSis_Empresa',
				'idSis_Usuario',
				//'idApp_Cliente',
				'NomeCliente',
				'DataNascimento',
				'DataCadastroCliente',
				'CpfCliente',
				'Rg',
				'OrgaoExp',
				'EstadoExp',
				'DataEmissao',			
				'CepCliente',
				'CelularCliente',
				'Telefone',
				'Telefone2',
				'Telefone3',
				'Ativo',
				'Motivo',
				'ClienteConsultor',
				'Sexo',
				'EnderecoCliente',
				'NumeroCliente',
				'ComplementoCliente',
				'CidadeCliente',
				'BairroCliente',
				//'MunicipioCliente',
				'EstadoCliente',
				'ReferenciaCliente',
				'Obs',
				'Email',
				'RegistroFicha',
				'Associado',
				#'Profissional',
				#'usuario',
				#'senha',
				#'CodInterno',
			), TRUE));
			
			
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

			$cliente1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['NomeCliente'], $caracteres_sem_acento));		
			
			$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['EnderecoCliente'], $caracteres_sem_acento));

			$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['query']['CepCliente'], $caracteres_sem_acento));

			$numero1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['NumeroCliente'], $caracteres_sem_acento));

			$complemento1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['ComplementoCliente'], $caracteres_sem_acento));

			$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['BairroCliente'], $caracteres_sem_acento));

			$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['CidadeCliente'], $caracteres_sem_acento));

			$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['EstadoCliente'], $caracteres_sem_acento));

			$referencia1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['ReferenciaCliente'], $caracteres_sem_acento));

			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
			(!$data['cadastrar']['Responsavel']) ? $data['cadastrar']['Responsavel'] = 'S' : FALSE;
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			(!$data['query']['DataCadastroCliente']) ? $data['query']['DataCadastroCliente'] = date('d/m/Y', time()) : FALSE;
			(!$data['query']['ClienteConsultor']) ? $data['query']['ClienteConsultor'] = 'N' : FALSE;
			(!$data['query']['Ativo']) ? $data['query']['Ativo'] = 'S' : FALSE;


			$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
			$data['select']['CadastrarResp'] = $this->Basico_model->select_status_sn();		
			//$data['select']['MunicipioCliente'] = $this->Basico_model->select_municipio();
			$data['select']['Sexo'] = $this->Basico_model->select_sexo();
			$data['select']['Associado'] = $this->Basico_model->select_status_sn();
			$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
			$data['select']['Motivo'] = $this->Basico_model->select_motivo();
			$data['select']['ClienteConsultor'] = $this->Basico_model->select_status_sn();
			$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresacli();
			$data['select']['idApp_Responsavel'] = $this->Basico_model->select_responsavel();
			$data['select']['Responsavel'] = array(
				'N' => 'Dependente',
				'S' => 'Responsavel',
			);
			$data['select']['RelacaoDep'] = $this->Cliente_model->select_relacao();
			$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
			
			$data['titulo'] = 'Cadastrar Cliente';
			$data['form_open_path'] = 'cliente/cadastrar';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 1;

			if ($data['query']['Sexo'] || $data['query']['EnderecoCliente'] || $data['query']['BairroCliente'] ||
				$data['query']['Obs'] || $data['query']['Email'] || 
				$data['query']['RegistroFicha'] || $data['query']['CepCliente'] || $data['query']['CpfCliente'] || 
				$data['query']['Rg']  || $data['query']['OrgaoExp'] || $data['query']['EstadoCliente']  || $data['query']['DataEmissao'])
				$data['collapse'] = '';
			else
				$data['collapse'] = 'class="collapse"';

			$data['sidebar'] = 'col-sm-3 col-md-2';
			$data['main'] = 'col-sm-7 col-md-8';

			$data['tela'] = $this->load->view('cliente/form_cliente', $data, TRUE);

			$data['radio'] = array(
				'Responsavel' => $this->basico->radio_checked($data['cadastrar']['Responsavel'], 'Responsavel', 'NS'),
			);
			($data['cadastrar']['Responsavel'] == 'N') ?
				$data['div']['Responsavel'] = '' : $data['div']['Responsavel'] = 'style="display: none;"';
				
			$data['radio'] = array(
				'CadastrarResp' => $this->basico->radio_checked($data['cadastrar']['CadastrarResp'], 'CadastrarResp', 'NS'),
			);
			($data['cadastrar']['CadastrarResp'] == 'N') ?
				$data['div']['CadastrarResp'] = '' : $data['div']['CadastrarResp'] = 'style="display: none;"';			
			
			$data['radio'] = array(
				'Ativo' => $this->basico->radio_checked($data['query']['Ativo'], 'Ativo', 'NS'),
			);
			($data['query']['Ativo'] == 'N') ?
				$data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';
			
			$data['radio'] = array(
				'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
			);
			($data['cadastrar']['Cadastrar'] == 'N') ?
				$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
			
			
			$data['q_motivo'] = $this->Cliente_model->list_motivo($_SESSION['log']['idSis_Empresa'], TRUE);
			$data['list_motivo'] = $this->load->view('cliente/list_motivo', $data, TRUE);		
			
			$data['cor_cli'] 	= 'warning';
			$data['cor_cons'] 	= 'default';
			$data['cor_orca'] 	= 'default';
			$data['cor_sac'] 	= 'default';
			$data['cor_mark'] 	= 'default';

			$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			#$this->form_validation->set_rules('NomeCliente', 'Nome do Respons�vel', 'required|trim|is_unique_duplo[App_Cliente.NomeCliente.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
			$this->form_validation->set_rules('CpfCliente', 'Cpf', 'trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[App_Cliente.CpfCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
			$this->form_validation->set_rules('NomeCliente', 'Nome do Cliente', 'required|trim');
			$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
			if($data['cadastrar']['Responsavel'] == 'S'){
				$this->form_validation->set_rules('CelularCliente', 'CelularCliente', 'required|trim|is_unique_duplo[App_Cliente.CelularCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']|valid_celular');
			}else{
				$this->form_validation->set_rules('idApp_Responsavel', 'Nome do Respons�vel', 'required|trim');
				$this->form_validation->set_rules('RelacaoDep', 'Rela��o', 'required|trim');
			}
			$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
			$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
			$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		
			if($data['query']['Ativo'] == 'N'){
				$this->form_validation->set_rules('Motivo', 'Motivo', 'required|trim');
			}
			
			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('cliente/form_cliente', $data);
				
			} else {
			
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'cliente/cadastrar' . $data['msg']);
					
				} else {
								
					if($data['query']['DataNascimento'] == ''){
						$data['query']['DataNascimento'] = "0000-00-00";
					}
					if($data['query']['DataEmissao'] == ''){
						$data['query']['DataEmissao'] = "0000-00-00";
					}
					if($data['cadastrar']['Responsavel'] == 'S'){
					
						//$_SESSION['Empresa5'] = $data['empresa5'] = $this->Cliente_model->get_empresa5($data['query']['CelularCliente']);
						$data['associado'] = $this->Cliente_model->get_associado($data['query']['CelularCliente']);
						
						/*			
						echo "<br>";
						echo "<pre>";
						echo "<br>";
						print_r($data['associado']);
						echo "</pre>";			
						exit();
						*/
						
						if (!isset($data['associado']) || $data['associado'] == FALSE){
							
							//$data['associado']['Nome'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
							$data['associado']['Nome'] = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));
							$data['associado']['idSis_Empresa'] = 5;
							$data['associado']['NomeEmpresa'] = "CONTA PESSOAL";
							//$data['associado']['Permissao'] = 3;
							$data['associado']['idTab_Modulo'] = 1;
							$data['associado']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
							$data['associado']['DataCriacao'] = date('Y-m-d', time());
							$data['associado']['Codigo'] = md5(uniqid(time() . rand()));
							$data['associado']['Inativo'] = 0;
							$data['associado']['CelularAssociado'] = $data['query']['CelularCliente'];
							$data['associado']['Associado'] = $data['query']['CelularCliente'];
							$data['associado']['Senha'] = md5($data['query']['CelularCliente']);
							
							$data['anterior'] = array();
							$data['campos'] = array_keys($data['associado']);

							$data['associado']['idSis_Associado'] = $this->Associado_model->set_associado($data['associado']);

							if ($data['associado']['idSis_Associado'] === FALSE) {
								$data['msg'] = '?m=2';
								$this->load->view('cliente/form_cliente', $data);
							} else {
								/*
								$data['associado']['Usuario'] = $data['idSis_Usuario'];
								$data['associado']['Senha'] = md5($data['idSis_Usuario']);
								$data['update']['associado']['bd'] = $this->Cliente_model->update_associado($data['associado'], $data['idSis_Usuario']);
								*/
								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['associado'], $data['campos'], $data['associado']['idSis_Associado']);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Associado', 'CREATE', $data['auditoriaitem'], $data['associado']['idSis_Associado']);
								/*
								  echo $this->db->last_query();
								  echo "<pre>";
								  print_r($data);
								  echo "</pre>";
								  exit();
								 */
								$data['agenda'] = array(
									'NomeAgenda' => 'Associado',
									'idSis_Associado' => $data['associado']['idSis_Associado'],
									'idSis_Empresa' => "5"
								);
								$data['campos'] = array_keys($data['agenda']);

								$data['idApp_Agenda'] = $this->Cliente_model->set_agenda($data['agenda']);
						
								$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
								
								$data['query']['idTab_Modulo'] = 1;
								//$data['query']['NomeCliente'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
								$data['query']['NomeCliente'] = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));
								$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
								$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'mysql');
								$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
								$data['query']['Obs'] = nl2br($data['query']['Obs']);
								$data['query']['EnderecoCliente'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
								$data['query']['NumeroCliente'] = trim(mb_strtoupper($numero1, 'ISO-8859-1'));
								$data['query']['ComplementoCliente'] = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));
								$data['query']['BairroCliente'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
								$data['query']['CidadeCliente'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
								$data['query']['EstadoCliente'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));
								$data['query']['ReferenciaCliente'] = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));
								if($data['query']['Ativo'] == 'S'){
									$data['query']['Motivo'] = 0;
								}
								
								//$data['query']['usuario'] = $data['idSis_Usuario'];
								$data['query']['usuario'] = $data['query']['CelularCliente'];
								$data['query']['senha'] = $data['associado']['Senha'];
								$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
								
								$data['query']['idSis_Associado'] = $data['associado']['idSis_Associado'];
								$data['query']['Codigo'] = $data['associado']['Codigo'];
								$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								if($_SESSION['Usuario']['Nivel'] == 2){
									$data['query']['NivelCliente'] = $_SESSION['Usuario']['Nivel'];
								}else{
									$data['query']['NivelCliente'] = 1;
								}
								$data['query']['LocalCadastroCliente'] = "L";
								
								$data['campos'] = array_keys($data['query']);
								$data['anterior'] = array();
								$data['idApp_Cliente'] = $this->Cliente_model->set_cliente($data['query']);

								if ($data['idApp_Cliente'] === FALSE) {
									$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

									$this->basico->erro($msg);
									$this->load->view('cliente/form_cliente', $data);
								} else {

									$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Cliente'], FALSE);
									$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'CREATE', $data['auditoriaitem']);
									$data['msg'] = '?m=1';

									redirect(base_url() . 'cliente/prontuario/' . $data['idApp_Cliente'] . $data['msg']);
									exit();
								}
							}
						} else {
							/*
							echo "<pre>";
							print_r($data['query']['CelularCliente']);
							echo "<br>";
							print_r($data['associado']);
							echo "<br>";
							echo "</pre>";
							exit();		
							*/
							$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
							
							$data['query']['idTab_Modulo'] = 1;
							//$data['query']['NomeCliente'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
							$data['query']['NomeCliente'] = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));
							$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
							$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'mysql');
							$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
							$data['query']['Obs'] = nl2br($data['query']['Obs']);
							$data['query']['EnderecoCliente'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
							$data['query']['NumeroCliente'] = trim(mb_strtoupper($numero1, 'ISO-8859-1'));
							$data['query']['ComplementoCliente'] = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));
							$data['query']['BairroCliente'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
							$data['query']['CidadeCliente'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
							$data['query']['EstadoCliente'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));
							$data['query']['ReferenciaCliente'] = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));
							if($data['query']['Ativo'] == 'S'){
								$data['query']['Motivo'] = 0;
							}
							
							//$data['query']['usuario'] = $data['query']['CelularCliente'];
							$data['query']['usuario'] = $data['associado']['Associado'];
							$data['query']['senha'] = $data['associado']['Senha'];
							$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
							
							$data['query']['idSis_Associado'] = $data['associado']['idSis_Associado'];
							//$data['query']['idSis_Usuario_5'] = $_SESSION['Empresa5']['idSis_Usuario'];
							$data['query']['Codigo'] = $data['associado']['Codigo'];
							$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
							$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
							if($_SESSION['Usuario']['Nivel'] == 2){
								$data['query']['NivelCliente'] = $_SESSION['Usuario']['Nivel'];
							}else{
								$data['query']['NivelCliente'] = 1;
							}
							$data['query']['LocalCadastroCliente'] = "L";

							$data['campos'] = array_keys($data['query']);
							$data['anterior'] = array();
								/*
								echo "<pre>";
								print_r($data['query']['CelularCliente']);
								echo "<br>";
								print_r(strlen($data['query']['CelularCliente']));
								echo "<br>";
								print_r($data['query']);
								echo "<br>";
								print_r($data['campos']);
								echo "<br>";
								print_r($data['anterior']);
								echo "<br>";
								echo "</pre>";
								exit();
								*/
							$data['idApp_Cliente'] = $this->Cliente_model->set_cliente($data['query']);

							if ($data['idApp_Cliente'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

								$this->basico->erro($msg);
								$this->load->view('cliente/form_cliente', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Cliente'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'CREATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';

								redirect(base_url() . 'cliente/prontuario/' . $data['idApp_Cliente'] . $data['msg']);
								exit();
							}
							
						}
					
					}else{
					
						//$data['dependente']['NomeClienteDep'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
						$data['dependente']['NomeClienteDep'] = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));
						$data['dependente']['DataNascimentoDep'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
						$data['dependente']['SexoDep'] = $data['query']['Sexo'];
						$data['dependente']['RelacaoDep'] = $data['cadastrar']['RelacaoDep'];
						$data['dependente']['idApp_Cliente'] = $data['cadastrar']['idApp_Responsavel'];
						$data['dependente']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
						$data['dependente']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						$data['dependente']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
						
						$data['campos'] = array_keys($data['dependente']);
						$data['anterior'] = array();
						$data['idApp_ClienteDep'] = $this->Clientedep_model->set_clientedep($data['dependente']);
						
						if ($data['idApp_ClienteDep'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('cliente/form_cliente', $data);
						} else {

							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['dependente'], $data['campos'], $data['idApp_ClienteDep'], FALSE);
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClienteDep', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';

							redirect(base_url() . 'clientedep/pesquisar/' . $data['cadastrar']['idApp_Responsavel'] . $data['msg']);
							exit();
						}				
					
					}
				}
				
			}
		}
        $this->load->view('basico/footer');
    }

    public function cadastrar_orig() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'CadastrarResp',
        ), TRUE));        
		
		$data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Empresa',
			'idSis_Usuario',
			'idApp_Cliente',
			'Responsavel',
			'idApp_Responsavel',
            'NomeCliente',
            'DataNascimento',
			'DataCadastroCliente',
			'CpfCliente',
			'Rg',
			'OrgaoExp',
			'EstadoExp',
			'DataEmissao',			
			'CepCliente',
            'CelularCliente',
			'Telefone',
            'Telefone2',
            'Telefone3',
			'Ativo',
			'Motivo',
			'ClienteConsultor',
            'Sexo',
            'EnderecoCliente',
			'NumeroCliente',
			'ComplementoCliente',
			'CidadeCliente',
            'BairroCliente',
            'MunicipioCliente',
			'EstadoCliente',
			'ReferenciaCliente',
            'Obs',
			'Email',
            'RegistroFicha',
			'Associado',
			#'Profissional',
			#'usuario',
			#'senha',
			#'CodInterno',
        ), TRUE));
		
		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
		$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
		(!$data['query']['DataCadastroCliente']) ? $data['query']['DataCadastroCliente'] = date('d/m/Y', time()) : FALSE;
		(!$data['query']['ClienteConsultor']) ? $data['query']['ClienteConsultor'] = 'N' : FALSE;
		(!$data['query']['Responsavel']) ? $data['query']['Responsavel'] = 'S' : FALSE;
		(!$data['query']['Ativo']) ? $data['query']['Ativo'] = 'S' : FALSE;
		
	   $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeCliente', 'Nome do Respons�vel', 'required|trim|is_unique_duplo[App_Cliente.NomeCliente.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('CpfCliente', 'Cpf', 'trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[App_Cliente.CpfCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('NomeCliente', 'Nome do Respons�vel', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('CelularCliente', 'CelularCliente', 'required|trim|is_unique_duplo[App_Cliente.CelularCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']|valid_celular');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		
		if($data['query']['Ativo'] == 'N'){
			$this->form_validation->set_rules('Motivo', 'Motivo', 'required|trim');
		}
        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['CadastrarResp'] = $this->Basico_model->select_status_sn();		
        $data['select']['MunicipioCliente'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Associado'] = $this->Basico_model->select_status_sn();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		$data['select']['Motivo'] = $this->Basico_model->select_motivo();
		$data['select']['ClienteConsultor'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresacli();
		$data['select']['idApp_Responsavel'] = $this->Basico_model->select_responsavel();
		$data['select']['Responsavel'] = array(
			'N' => 'Outro',
			'S' => 'O Pr�prio',
        );
		$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
		
        $data['titulo'] = 'Cadastrar Cliente';
        $data['form_open_path'] = 'cliente/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        if ($data['query']['Sexo'] || $data['query']['EnderecoCliente'] || $data['query']['BairroCliente'] ||
			$data['query']['MunicipioCliente'] || $data['query']['Obs'] || $data['query']['Email'] || 
			$data['query']['RegistroFicha'] || $data['query']['CepCliente'] || $data['query']['CpfCliente'] || 
			$data['query']['Rg']  || $data['query']['OrgaoExp'] || $data['query']['EstadoCliente']  || $data['query']['DataEmissao'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('cliente/form_cliente', $data, TRUE);

		$data['radio'] = array(
            'Responsavel' => $this->basico->radio_checked($data['query']['Responsavel'], 'Responsavel', 'NS'),
        );
        ($data['query']['Responsavel'] == 'N') ?
            $data['div']['Responsavel'] = '' : $data['div']['Responsavel'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'CadastrarResp' => $this->basico->radio_checked($data['cadastrar']['CadastrarResp'], 'CadastrarResp', 'NS'),
        );
        ($data['cadastrar']['CadastrarResp'] == 'N') ?
            $data['div']['CadastrarResp'] = '' : $data['div']['CadastrarResp'] = 'style="display: none;"';			
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['query']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['query']['Ativo'] == 'N') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('cliente/form_cliente', $data);
        } else {

			$_SESSION['Empresa5'] = $data['empresa5'] = $this->Cliente_model->get_empresa5($data['query']['CelularCliente']);
			
			if (!isset($_SESSION['Empresa5'])){
				
				$data['usuario']['Nome'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
				$data['usuario']['idSis_Empresa'] = 5;
				$data['usuario']['NomeEmpresa'] = "CONTA PESSOAL";
				$data['usuario']['Permissao'] = 3;
				$data['usuario']['idTab_Modulo'] = 1;
				$data['usuario']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
				$data['usuario']['DataCriacao'] = date('Y-m-d', time());
				$data['usuario']['Codigo'] = md5(uniqid(time() . rand()));
				$data['usuario']['Inativo'] = 0;
				$data['usuario']['CelularUsuario'] = $data['query']['CelularCliente'];
				$data['usuario']['Usuario'] = $data['query']['CelularCliente'];
				$data['usuario']['Senha'] = md5($data['query']['CelularCliente']);
				
				$data['anterior'] = array();
				$data['campos'] = array_keys($data['usuario']);

				$data['idSis_Usuario'] = $this->Cliente_model->set_usuario($data['usuario']);

				if ($data['idSis_Usuario'] === FALSE) {
					$data['msg'] = '?m=2';
					$this->load->view('cliente/form_cliente', $data);
				} else {
					
					$data['usuario']['Usuario'] = $data['idSis_Usuario'];
					$data['usuario']['Senha'] = md5($data['idSis_Usuario']);
					
					$data['update']['usuario']['bd'] = $this->Cliente_model->update_usuario($data['usuario'], $data['idSis_Usuario']);
					
					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['usuario'], $data['campos'], $data['idSis_Usuario']);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'CREATE', $data['auditoriaitem'], $data['idSis_Usuario']);
					/*
					  echo $this->db->last_query();
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  exit();
					 */
					$data['agenda'] = array(
						'NomeAgenda' => 'Associado',
						'idSis_Usuario' => $data['idSis_Usuario'],
						'idSis_Empresa' => "5"
					);
					$data['campos'] = array_keys($data['agenda']);

					$data['idApp_Agenda'] = $this->Cliente_model->set_agenda($data['agenda']);
			
					$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
					
					$data['query']['idTab_Modulo'] = 1;
					$data['query']['NomeCliente'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
					$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
					$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'mysql');
					$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
					$data['query']['Obs'] = nl2br($data['query']['Obs']);
					$data['query']['EnderecoCliente'] = trim(mb_strtoupper($data['query']['EnderecoCliente'], 'ISO-8859-1'));
					$data['query']['NumeroCliente'] = trim(mb_strtoupper($data['query']['NumeroCliente'], 'ISO-8859-1'));
					$data['query']['ComplementoCliente'] = trim(mb_strtoupper($data['query']['ComplementoCliente'], 'ISO-8859-1'));
					$data['query']['BairroCliente'] = trim(mb_strtoupper($data['query']['BairroCliente'], 'ISO-8859-1'));
					$data['query']['CidadeCliente'] = trim(mb_strtoupper($data['query']['CidadeCliente'], 'ISO-8859-1'));
					$data['query']['EstadoCliente'] = trim(mb_strtoupper($data['query']['EstadoCliente'], 'ISO-8859-1'));
					$data['query']['ReferenciaCliente'] = trim(mb_strtoupper($data['query']['ReferenciaCliente'], 'ISO-8859-1'));
					if($data['query']['Ativo'] == 'S'){
						$data['query']['Motivo'] = 0;
					}
					
					//$data['query']['usuario'] = $data['query']['CelularCliente'];
					$data['query']['usuario'] = $data['idSis_Usuario'];
					$data['query']['senha'] = $data['usuario']['Senha'];
					$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
					
					$data['query']['idSis_Usuario_5'] = $data['idSis_Usuario'];
					$data['query']['Codigo'] = $data['usuario']['Codigo'];
					$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['query']['LocalCadastroCliente'] = "L";
					
					$data['campos'] = array_keys($data['query']);
					$data['anterior'] = array();
					$data['idApp_Cliente'] = $this->Cliente_model->set_cliente($data['query']);

					if ($data['idApp_Cliente'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

						$this->basico->erro($msg);
						$this->load->view('cliente/form_cliente', $data);
					} else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Cliente'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'CREATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';

						redirect(base_url() . 'cliente/prontuario/' . $data['idApp_Cliente'] . $data['msg']);
						exit();
					}
				}
			} else {
				/*
				echo "<pre>";
				print_r($data['query']['CelularCliente']);
				echo "<br>";
				print_r($_SESSION['Empresa5']);
				echo "<br>";
				echo "</pre>";
				exit();		
				*/
				$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
					
				$data['query']['idTab_Modulo'] = 1;
				$data['query']['NomeCliente'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
				$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
				$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'mysql');
				$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
				$data['query']['Obs'] = nl2br($data['query']['Obs']);
				$data['query']['EnderecoCliente'] = trim(mb_strtoupper($data['query']['EnderecoCliente'], 'ISO-8859-1'));
				$data['query']['NumeroCliente'] = trim(mb_strtoupper($data['query']['NumeroCliente'], 'ISO-8859-1'));
				$data['query']['ComplementoCliente'] = trim(mb_strtoupper($data['query']['ComplementoCliente'], 'ISO-8859-1'));
				$data['query']['BairroCliente'] = trim(mb_strtoupper($data['query']['BairroCliente'], 'ISO-8859-1'));
				$data['query']['CidadeCliente'] = trim(mb_strtoupper($data['query']['CidadeCliente'], 'ISO-8859-1'));
				$data['query']['EstadoCliente'] = trim(mb_strtoupper($data['query']['EstadoCliente'], 'ISO-8859-1'));
				$data['query']['ReferenciaCliente'] = trim(mb_strtoupper($data['query']['ReferenciaCliente'], 'ISO-8859-1'));
				if($data['query']['Ativo'] == 'S'){
					$data['query']['Motivo'] = 0;
				}
				
				//$data['query']['usuario'] = $data['query']['CelularCliente'];
				$data['query']['usuario'] = $_SESSION['Empresa5']['Usuario'];
				$data['query']['senha'] = $_SESSION['Empresa5']['Senha'];
				$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
				
				$data['query']['idSis_Usuario_5'] = $_SESSION['Empresa5']['idSis_Usuario'];
				$data['query']['Codigo'] = $_SESSION['Empresa5']['Codigo'];
				$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
				$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
				$data['query']['LocalCadastroCliente'] = "L";

				$data['campos'] = array_keys($data['query']);
				$data['anterior'] = array();
					/*
					echo "<pre>";
					print_r($data['query']['CelularCliente']);
					echo "<br>";
					print_r(strlen($data['query']['CelularCliente']));
					echo "<br>";
					print_r($data['query']);
					echo "<br>";
					print_r($data['campos']);
					echo "<br>";
					print_r($data['anterior']);
					echo "<br>";
					echo "</pre>";
					exit();
					*/
				$data['idApp_Cliente'] = $this->Cliente_model->set_cliente($data['query']);

				if ($data['idApp_Cliente'] === FALSE) {
					$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

					$this->basico->erro($msg);
					$this->load->view('cliente/form_cliente', $data);
				} else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Cliente'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'CREATE', $data['auditoriaitem']);
					$data['msg'] = '?m=1';

					redirect(base_url() . 'cliente/prontuario/' . $data['idApp_Cliente'] . $data['msg']);
					exit();
				}
				
			}	
        }

        $this->load->view('basico/footer');
    }
	
    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>N�o � poss�vel salvar as altera��es.<br>N�o identificamos o pagamento da sua �ltima Fatura.<br>Por favor, Entre em contato com a administra��o da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';
	
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'CadastrarResp',
		), TRUE));		

		$data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idApp_Cliente',
			//'Responsavel',
			//'idApp_Responsavel',
			'NomeCliente',
			'DataNascimento',
			#'DataCadastroCliente',
			'CpfCliente',
			'Rg',
			'OrgaoExp',
			'EstadoExp',
			'DataEmissao',
			'CepCliente',
			'CelularCliente',
			'Telefone',
			'Telefone2',
			'Telefone3',
			'Ativo',
			'Motivo',
			'ClienteConsultor',
			'Sexo',
			'EnderecoCliente',
			'NumeroCliente',
			'ComplementoCliente',
			'CidadeCliente',
			'BairroCliente',
			//'MunicipioCliente',
			'EstadoCliente',
			'ReferenciaCliente',
			'Obs',
			#'idSis_Usuario',
			'Email',
			'RegistroFicha',
			'Associado',
			#'Profissional',
			#'usuario',
			#'senha',
			#'CodInterno',
			'NivelCliente',
		), TRUE);

		if ($id) {
			$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id);
		
			if($data['query'] === FALSE){
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
				$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'barras');
			}	
		}
		
		if(!$data['query']['idApp_Cliente'] || !$_SESSION['Cliente']){
			unset($_SESSION['Cliente']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {			
				
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

			$cliente1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['NomeCliente'], $caracteres_sem_acento));		
			
			$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['EnderecoCliente'], $caracteres_sem_acento));

			$cep1 = preg_replace("/[^0-9]/", " ", strtr($data['query']['CepCliente'], $caracteres_sem_acento));

			$numero1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['NumeroCliente'], $caracteres_sem_acento));

			$complemento1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['ComplementoCliente'], $caracteres_sem_acento));

			$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['BairroCliente'], $caracteres_sem_acento));

			$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['CidadeCliente'], $caracteres_sem_acento));

			$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['EstadoCliente'], $caracteres_sem_acento));

			$referencia1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['query']['ReferenciaCliente'], $caracteres_sem_acento));
			
			$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
			$data['select']['CadastrarResp'] = $this->Basico_model->select_status_sn();
			//$data['select']['MunicipioCliente'] = $this->Basico_model->select_municipio();
			$data['select']['Sexo'] = $this->Basico_model->select_sexo();
			$data['select']['Associado'] = $this->Basico_model->select_status_sn();
			$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
			$data['select']['Motivo'] = $this->Basico_model->select_motivo();
			$data['select']['ClienteConsultor'] = $this->Basico_model->select_status_sn();
			$data['select']['Profissional'] = $this->Basico_model->select_profissional2();
			$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresacli();
			$data['select']['NivelCliente'] = array(
				'1' => '1 - Da Empresa',
				'2' => '2 - Do Revendedor',
			);
					
			//$data['select']['idApp_Responsavel'] = $this->Basico_model->select_responsavel();
			/*
			$data['select']['Responsavel'] = array(
				'N' => 'Outro',
				'S' => 'O Pr�prio',
			);
			*/
			$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
			
			$data['titulo'] = 'Editar Dados';
			$data['form_open_path'] = 'cliente/alterar';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 2;

			if ($data['query']['Sexo'] || $data['query']['EnderecoCliente'] || $data['query']['BairroCliente'] ||
				$data['query']['Obs'] || $data['query']['Email'] || 
				$data['query']['RegistroFicha'] || $data['query']['CepCliente'] || $data['query']['CpfCliente'] || 
				$data['query']['Rg']  || $data['query']['OrgaoExp'] || $data['query']['EstadoCliente']  || $data['query']['DataEmissao'])
				$data['collapse'] = '';
			else
				$data['collapse'] = 'class="collapse"';

			$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
			$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';
			/*
			$data['radio'] = array(
				'Responsavel' => $this->basico->radio_checked($data['query']['Responsavel'], 'Responsavel', 'NS'),
			);
			($data['query']['Responsavel'] == 'N') ?
				$data['div']['Responsavel'] = '' : $data['div']['Responsavel'] = 'style="display: none;"';
			*/	
			$data['radio'] = array(
				'CadastrarResp' => $this->basico->radio_checked($data['cadastrar']['CadastrarResp'], 'CadastrarResp', 'NS'),
			);
			($data['cadastrar']['CadastrarResp'] == 'N') ?
				$data['div']['CadastrarResp'] = '' : $data['div']['CadastrarResp'] = 'style="display: none;"';		
			
			(!$data['query']['Ativo']) ? $data['query']['Ativo'] = 'S' : FALSE;
			
			$data['radio'] = array(
				'Ativo' => $this->basico->radio_checked($data['query']['Ativo'], 'Ativo', 'NS'),
			);
			($data['query']['Ativo'] == 'N') ?
				$data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';

			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
			
			$data['radio'] = array(
				'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
			);
			($data['cadastrar']['Cadastrar'] == 'N') ?
				$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
			
			$data['q_motivo'] = $this->Cliente_model->list_motivo($_SESSION['log']['idSis_Empresa'], TRUE);
			$data['list_motivo'] = $this->load->view('cliente/list_motivo', $data, TRUE);		
			
			$data['cor_cli'] 	= 'warning';
			$data['cor_cons'] 	= 'default';
			$data['cor_orca'] 	= 'default';
			$data['cor_sac'] 	= 'default';
			$data['cor_mark'] 	= 'default';

			$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			#$this->form_validation->set_rules('NomeCliente', 'Nome do Cliente', 'required|trim|is_unique_duplo[App_Cliente.NomeCliente.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
			#$this->form_validation->set_rules('CpfCliente', 'Cpf', 'trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[App_Cliente.CpfCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
			$this->form_validation->set_rules('CpfCliente', 'Cpf', 'trim|valid_cpf|alpha_numeric_spaces|is_unique_by_id_empresa[App_Cliente.CpfCliente.' . $data['query']['idApp_Cliente'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
			$this->form_validation->set_rules('NomeCliente', 'Nome do Cliente', 'required|trim');
			$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
			$this->form_validation->set_rules('CelularCliente', 'CelularCliente', 'required|trim|is_unique_by_id_empresa[App_Cliente.CelularCliente.' . $data['query']['idApp_Cliente'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']|valid_celular');
			$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
			$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
			$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		
			if($data['query']['Ativo'] == 'N'){
				$this->form_validation->set_rules('Motivo', 'Motivo', 'required|trim');
			}
			
			#run form validation

			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('cliente/form_cliente', $data);
					
			} else {
				
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {
							
					if($data['query']['DataNascimento'] == ''){
						$data['query']['DataNascimento'] = "0000-00-00";
					}
					if($data['query']['DataEmissao'] == ''){
						$data['query']['DataEmissao'] = "0000-00-00";
					}
					/*
					echo "<br>";
					echo "<pre>";
					print_r('id_cliente = '.$data['query']['idApp_Cliente']);
					echo "<br>";
					print_r('id_empresa_5 = '.$_SESSION['Query']['idSis_Associado']);
					echo "</pre>";			
					exit();	
					*/	
					if (!isset($_SESSION['Cliente']['idSis_Associado']) || $_SESSION['Cliente']['idSis_Associado'] == ''){
						/*
						echo "<br>";
						echo "<pre>";
						print_r('N�o existe id_empresa_5');
						echo "</pre>";			
						exit();
						*/
						//$_SESSION['Empresa5'] = $data['empresa5'] = $this->Cliente_model->get_empresa5($data['query']['CelularCliente']);
						$data['associado'] = $this->Cliente_model->get_associado($data['query']['CelularCliente']);
						
						if (!isset($data['associado']) || $data['associado'] == FALSE ){
							
							$data['associado']['Nome'] = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));
							$data['associado']['idSis_Empresa'] = 5;
							$data['associado']['NomeEmpresa'] = "CONTA PESSOAL";
							//$data['associado']['Permissao'] = 3;
							$data['associado']['idTab_Modulo'] = 1;
							$data['associado']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
							$data['associado']['DataCriacao'] = date('Y-m-d', time());
							$data['associado']['Codigo'] = md5(uniqid(time() . rand()));
							$data['associado']['Inativo'] = 0;
							$data['associado']['CelularAssociado'] = $data['query']['CelularCliente'];
							$data['associado']['Associado'] = $data['query']['CelularCliente'];
							if(!isset($data['query']['senha'])){
								$data['associado']['Senha'] = md5($data['query']['CelularCliente']);
								$data['query']['senha'] = $data['associado']['Senha'];
								//$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
							}else{
								$data['associado']['Senha'] = $data['query']['senha'];
							}
							$data['anterior'] = array();
							$data['campos'] = array_keys($data['associado']);

							$data['associado']['idSis_Associado'] = $this->Associado_model->set_associado($data['associado']);

							if ($data['associado']['idSis_Associado'] === FALSE) {
								$data['msg'] = '?m=2';
								$this->load->view('cliente/form_cliente', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['associado'], $data['campos'], $data['associado']['idSis_Associado']);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Associado', 'CREATE', $data['auditoriaitem'], $data['associado']['idSis_Associado']);
								/*
								  echo $this->db->last_query();
								  echo "<pre>";
								  print_r($data);
								  echo "</pre>";
								  exit();
								 */
								$data['agenda'] = array(
									'NomeAgenda' => 'Associado',
									'idSis_Associado' => $data['associado']['idSis_Associado'],
									'idSis_Empresa' => "5"
								);
								$data['campos'] = array_keys($data['agenda']);

								$data['idApp_Agenda'] = $this->Cliente_model->set_agenda($data['agenda']);
					
								$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
								
								$data['query']['idTab_Modulo'] = 1;
								$data['query']['NomeCliente'] = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));
								$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
								$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
								$data['query']['Obs'] = nl2br($data['query']['Obs']);
								$data['query']['EnderecoCliente'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
								$data['query']['NumeroCliente'] = trim(mb_strtoupper($numero1, 'ISO-8859-1'));
								$data['query']['ComplementoCliente'] = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));
								$data['query']['BairroCliente'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
								$data['query']['CidadeCliente'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
								$data['query']['EstadoCliente'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));
								$data['query']['ReferenciaCliente'] = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));
								if($data['query']['Ativo'] == 'S'){
									$data['query']['Motivo'] = 0;
								}
								/*
								if ($data['cadastrar']['Cadastrar'] == 'S'){
								
									$data['query']['usuario'] = $data['query']['CelularCliente'];

									$data['query']['senha'] = md5($data['query']['CelularCliente']);
									
									$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
									
									$data['usuario']['Senha'] = $data['query']['senha'];
									
									$data['update']['usuario']['anterior'] = $this->Cliente_model->get_usuario($data['idSis_Usuario']);
									
									$data['update']['usuario']['campos'] = array_keys($data['usuario']);
									
									$data['update']['usuario']['auditoriaitem'] = $this->basico->set_log(
										$data['update']['usuario']['anterior'],
										$data['usuario'],
										$data['update']['usuario']['campos'],
										$data['usuario']['idSis_Usuario'], TRUE);
										
									$data['update']['usuario']['bd'] = $this->Cliente_model->update_usuario($data['usuario'], $data['idSis_Usuario']);
									
								}
								*/
								if(!isset($data['query']['CodInterno'])){
									$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
								}
								$data['query']['idSis_Associado'] = $data['associado']['idSis_Associado'];
								$data['query']['usuario'] = $data['associado']['Associado'];
								$data['query']['Codigo'] = $data['associado']['Codigo'];
											
								$data['anterior'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
								$data['campos'] = array_keys($data['query']);

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Cliente'], TRUE);

								if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
									$data['msg'] = '?m=1';
									redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
									exit();
								} else {

									if ($data['auditoriaitem'] === FALSE) {
										$data['msg'] = '';
									} else {
										$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
										$data['msg'] = '?m=1';
									}
									
									redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
									exit();
								}
							}
							
						} else {
					
							$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
								
							$data['query']['idTab_Modulo'] = 1;
							$data['query']['NomeCliente'] = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));
							$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
							$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
							$data['query']['Obs'] = nl2br($data['query']['Obs']);
							$data['query']['EnderecoCliente'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
							$data['query']['NumeroCliente'] = trim(mb_strtoupper($numero1, 'ISO-8859-1'));
							$data['query']['ComplementoCliente'] = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));
							$data['query']['BairroCliente'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
							$data['query']['CidadeCliente'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
							$data['query']['EstadoCliente'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));
							$data['query']['ReferenciaCliente'] = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));
							if($data['query']['Ativo'] == 'S'){
								$data['query']['Motivo'] = 0;
							}
							/*	
							if ($data['cadastrar']['Cadastrar'] == 'S'){
							
								$data['query']['usuario'] = $data['query']['CelularCliente'];
								$data['query']['senha'] = md5($data['query']['CelularCliente']);
								$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
								
								$data['usuario']['Senha'] = $data['query']['senha'];
								
								$data['update']['usuario']['anterior'] = $this->Cliente_model->get_usuario($_SESSION['Empresa5']['idSis_Usuario']);
								
								$data['update']['usuario']['campos'] = array_keys($data['usuario']);
								
								$data['update']['usuario']['auditoriaitem'] = $this->basico->set_log(
									$data['update']['usuario']['anterior'],
									$data['usuario'],
									$data['update']['usuario']['campos'],
									$data['usuario']['idSis_Usuario'], TRUE);
									
								$data['update']['usuario']['bd'] = $this->Cliente_model->update_usuario($data['usuario'], $_SESSION['Empresa5']['idSis_Usuario']);
								
							}else{
								$data['query']['usuario'] = $data['query']['CelularCliente'];
								$data['query']['senha'] = $_SESSION['Empresa5']['Senha'];
								$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
							}
							*/
							if(!isset($data['query']['CodInterno'])){
								$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
							}
							$data['query']['idSis_Associado'] = $data['associado']['idSis_Associado'];
							$data['query']['usuario'] = $data['associado']['Associado'];
							$data['query']['senha'] = $data['associado']['Senha'];
							$data['query']['Codigo'] = $data['associado']['Codigo'];				

							$data['anterior'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
							$data['campos'] = array_keys($data['query']);

							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Cliente'], TRUE);

							if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
								$data['msg'] = '?m=1';
								redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
								exit();
							} else {

								if ($data['auditoriaitem'] === FALSE) {
									$data['msg'] = '';
								} else {
									$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
									$data['msg'] = '?m=1';
								}
								
								redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
								exit();
							}
						}
					}else{

						$data['query']['idTab_Modulo'] = 1;
						$data['query']['NomeCliente'] = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));
						$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
						$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
						$data['query']['Obs'] = nl2br($data['query']['Obs']);
						$data['query']['EnderecoCliente'] = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));
						$data['query']['NumeroCliente'] = trim(mb_strtoupper($numero1, 'ISO-8859-1'));
						$data['query']['ComplementoCliente'] = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));
						$data['query']['BairroCliente'] = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));
						$data['query']['CidadeCliente'] = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));
						$data['query']['EstadoCliente'] = trim(mb_strtoupper($estado1, 'ISO-8859-1'));
						$data['query']['ReferenciaCliente'] = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));
						if($data['query']['Ativo'] == 'S'){
							$data['query']['Motivo'] = 0;
						}
						
						/*
						$data['query']['usuario'] = $data['query']['CelularCliente'];
						$data['query']['senha'] = $_SESSION['Empresa5']['Senha'];
						if(!isset($data['query']['CodInterno'])){
							$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
						}
						$data['query']['idSis_Usuario_5'] = $_SESSION['Empresa5']['idSis_Usuario'];
						$data['query']['Codigo'] = $_SESSION['Empresa5']['Codigo'];				
						*/
						
						$data['anterior'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Cliente'], TRUE);

						if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
							$data['msg'] = '?m=1';
							
							unset(	$_SESSION['Cliente'],
									$_SESSION['Empresa5']	
							);
							
							redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}
							
							unset(	$_SESSION['Cliente'],
									$_SESSION['Empresa5']	
							);
							
							redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
							exit();
						}			
						
					}
				}
			}
		}
	
        $this->load->view('basico/footer');
    }
	
    public function alterar_status($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
		), TRUE));		

		$data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'idApp_Cliente',
			'Ativo',
			'Motivo',

		), TRUE);

		if ($id) {
			$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id);
		
			if($data['query'] === FALSE){
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {

			}
		}

		if(!$data['query']['idApp_Cliente'] || !$_SESSION['Cliente']){
			unset($_SESSION['Cliente']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
			$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
			$data['select']['Motivo'] = $this->Basico_model->select_motivo();
			
			$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
			
			$data['titulo'] = 'Editar Dados';
			$data['form_open_path'] = 'cliente/alterar_status';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'primary';
			$data['metodo'] = 3;

			if ($data['query']['Ativo'])
				$data['collapse'] = '';
			else
				$data['collapse'] = 'class="collapse"';

			$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
			$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

			(!$data['query']['Ativo']) ? $data['query']['Ativo'] = 'S' : FALSE;
			
			$data['radio'] = array(
				'Ativo' => $this->basico->radio_checked($data['query']['Ativo'], 'Ativo', 'NS'),
			);
			($data['query']['Ativo'] == 'N') ?
				$data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';

			(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
			
			$data['radio'] = array(
				'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
			);
			($data['cadastrar']['Cadastrar'] == 'N') ?
				$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
						
			$data['q_motivo'] = $this->Cliente_model->list_motivo($_SESSION['log']['idSis_Empresa'], TRUE);
			$data['list_motivo'] = $this->load->view('cliente/list_motivo', $data, TRUE);		
			
			$data['cor_cli'] 	= 'warning';
			$data['cor_cons'] 	= 'default';
			$data['cor_orca'] 	= 'default';
			$data['cor_sac'] 	= 'default';
			$data['cor_mark'] 	= 'default';

			$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
			$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		
			if($data['query']['Ativo'] == 'N'){
				$this->form_validation->set_rules('Motivo', 'Motivo', 'required|trim');
			}
			
			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('cliente/form_cliente', $data);
			} else {
							
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {

					if($data['query']['Ativo'] == 'S'){
						$data['query']['Motivo'] = 0;
					}

					$data['anterior'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Cliente'], TRUE);

					if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
						$data['msg'] = '?m=1';
						redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}
						
						redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
						exit();
					}
				}
			}
		}
	
        $this->load->view('basico/footer');
    }

    public function alterarlogo1($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idApp_Cliente',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idApp_Cliente',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id, TRUE);
        }
		
        if ($id)
            $data['file']['idApp_Cliente'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->limpa_nome_arquivo($_FILES['Arquivo']['name']);
			$data['file']['Arquivo'] = $this->basico->renomeiacliente($data['file']['Arquivo'], '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/');
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'cliente/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
		
        $data['cor_cli'] 	= 'warning';
        $data['cor_cons'] 	= 'default';
        $data['cor_orca'] 	= 'default';
        $data['cor_sac'] 	= 'default';
        $data['cor_mark'] 	= 'default';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('cliente/form_perfil', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg', 'jpeg', 'gif', 'png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('cliente/form_perfil', $data);
            }
            else {

                $data['camposfile'] = array_keys($data['file']);
				$data['idSis_Arquivo'] = $this->Cliente_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('cliente/form_perfil', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Cliente'], TRUE);

					if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'cliente/form_perfil/' . $data['query']['idApp_Cliente'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'cliente/prontuario/' . $data['file']['idApp_Cliente'] . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterarlogo($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = $this->input->post(array(
			'idApp_Cliente',
		), TRUE);
		
		$data['file'] = $this->input->post(array(
			'idApp_Cliente',
			'Arquivo',
		), TRUE);

		if ($id) {
			$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id, TRUE);
			$data['file']['idApp_Cliente'] = $id;
	
			if($data['query'] === FALSE){
				unset($_SESSION['Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {

			}
		}

		if(!$data['query']['idApp_Cliente'] || !$_SESSION['Cliente']){
			unset($_SESSION['Cliente']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			//$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
				
				$data['file']['Arquivo'] = $this->basico->renomeiacliente($_FILES['Arquivo']['name']);
				$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
			}
			else {
				$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
			}

			$data['titulo'] = 'Alterar Foto';
			$data['form_open_path'] = 'cliente/alterarlogo';
			$data['readonly'] = 'readonly';
			$data['panel'] = 'primary';
			$data['metodo'] = 2;
			
			$data['cor_cli'] 	= 'warning';
			$data['cor_cons'] 	= 'default';
			$data['cor_orca'] 	= 'default';
			$data['cor_sac'] 	= 'default';
			$data['cor_mark'] 	= 'default';

			$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				#load login view
				$this->load->view('cliente/form_perfil', $data);
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {

					$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/';
					$config['max_size'] = 1000;
					$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
					$config['file_name'] = $data['file']['Arquivo'];

					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('Arquivo')) {
						$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
						$this->load->view('cliente/form_perfil', $data);
					}else {

						$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/';		
						$foto = $data['file']['Arquivo'];
						$diretorio = $dir.$foto;					
						$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/';

						switch($_FILES['Arquivo']['type']):
							case 'image/jpg';
							case 'image/jpeg';
							case 'image/pjpeg';
						
								list($largura, $altura, $tipo) = getimagesize($diretorio);
								
								$img = imagecreatefromjpeg($diretorio);

								$thumb = imagecreatetruecolor(200, 200);
								
								imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 200, $largura, $altura);
								
								imagejpeg($thumb, $dir2 . $foto);
								imagedestroy($img);
								imagedestroy($thumb);				      
							
							break;					

							case 'image/png';
							case 'image/x-png';
								
								list($width, $height) = getimagesize($diretorio);
								$newwidth = 200;
								$newheight = 200;

								$thumb = imagecreatetruecolor($newwidth, $newheight);
								imagealphablending($thumb, false);
								imagesavealpha($thumb, true);
								$source = imagecreatefrompng($diretorio);
								imagealphablending($source, true);
								imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
								imagepng($thumb, $dir2 . $foto);
								imagedestroy($thumb);
								imagedestroy($source);				      
							
							break;
							
						endswitch;			
					
						$data['camposfile'] = array_keys($data['file']);
						$data['idSis_Arquivo'] = $this->Cliente_model->set_arquivo($data['file']);

						if ($data['idSis_Arquivo'] === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
							$this->basico->erro($msg);
							$this->load->view('cliente/form_perfil', $data);
						}else {

							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
							
							$data['query']['Arquivo'] = $data['file']['Arquivo'];
							$data['anterior'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
							$data['campos'] = array_keys($data['query']);

							$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Cliente'], TRUE);

							if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
								$data['msg'] = '?m=2';
								redirect(base_url() . 'cliente/form_perfil/' . $data['query']['idApp_Cliente'] . $data['msg']);
								exit();
							} else {
								
								if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/' . $_SESSION['Cliente']['Arquivo'] . ''))
									&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/' . $_SESSION['Cliente']['Arquivo'] . '')
									!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/Foto.jpg'))){
									unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/' . $_SESSION['Cliente']['Arquivo'] . '');						
								}
								if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['Cliente']['Arquivo'] . ''))
									&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['Cliente']['Arquivo'] . '')
									!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/Foto.jpg'))){
									unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['Cliente']['Arquivo'] . '');						
								}						

								if ($data['auditoriaitem'] === FALSE) {
									$data['msg'] = '';
								} else {
									$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
									$data['msg'] = '?m=1';
								}

								redirect(base_url() . 'cliente/prontuario/' . $data['file']['idApp_Cliente'] . $data['msg']);
								exit();
							}				
						}
					}
				}
			}
		}	
	
        $this->load->view('basico/footer');
    }
	
    public function alterarcashback($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'AlterarTodos',
			'TipoAdd',
			'ValorAddCashBack',
			'PrazoGeralCashBack',
			'ValidadeGeralCashBack',
		), TRUE));
		
		$data['empresa'] = quotes_to_entities($this->input->post(array(
			#### Sis_Empresa ####
			'idSis_Empresa',
			
		), TRUE));
		 
		$data['hoje'] = date('Y-m-d', time());		 
		//(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE; 
		 
		 
		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		$j = 1;
		for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

			if ($this->input->post('CashBackCliente' . $i) || $this->input->post('ValidadeCashBack' . $i)) {
				$data['orcamento'][$j]['idApp_Cliente'] = $this->input->post('idApp_Cliente' . $i);
				$data['orcamento'][$j]['NomeCliente'] = $this->input->post('NomeCliente' . $i);
				$data['orcamento'][$j]['addCashBackCliente'] = $this->input->post('addCashBackCliente' . $i);
				$data['orcamento'][$j]['CashBackCliente'] = $this->input->post('CashBackCliente' . $i);
				$data['orcamento'][$j]['PrazoCashBack'] = $this->input->post('PrazoCashBack' . $i);
				$data['orcamento'][$j]['ValidadeCashBack'] = $this->input->post('ValidadeCashBack' . $i);
				$data['orcamento'][$j]['Valor'] = $this->input->post('Valor' . $i);
				$j++;
			}
		}
		$data['count']['PRCount'] = $j - 1;

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
				
			#### Sis_Empresa ####
			$_SESSION['Empresa_Cliente'] = $data['empresa'] = $this->Cliente_model->get_empresa($id);

			if($data['empresa'] === FALSE){
				
				unset($_SESSION['Empresa_Cliente']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
			
				$config['base_url'] = base_url() . 'cliente/alterarcashback/' . $id . '/';
				$config['total_rows'] = $this->Cliente_model->get_alterarcashback($id, TRUE);
			   
				if($config['total_rows'] >= 1){
					$_SESSION['Total_Rows'] = $data['total_rows'] = $config['total_rows'];
				}else{
					$_SESSION['Total_Rows'] = $data['total_rows'] = 0;
				}
				
				$this->pagination->initialize($config);

				$_SESSION['Pagina'] = $data['pagina'] = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
				$_SESSION['Per_Page'] = $data['per_page'] = $config['per_page'];
				
				$_SESSION['Pagination'] = $data['pagination'] = $this->pagination->create_links();		
				
				#### App_OrcaTrata ####
				$_SESSION['Orcamento'] = $data['orcamento'] = $this->Cliente_model->get_alterarcashback($id, FALSE, $_SESSION['Per_Page'], ($_SESSION['Pagina'] * $_SESSION['Per_Page']));
				
				if (count($data['orcamento']) > 0) {
					$data['orcamento'] = array_combine(range(1, count($data['orcamento'])), array_values($data['orcamento']));
					$data['count']['PRCount'] = count($data['orcamento']);
					if (isset($data['orcamento'])) {
						for($j=1; $j <= $data['count']['PRCount']; $j++) {
							$data['orcamento'][$j]['ValidadeCashBack'] = $this->basico->mascara_data($data['orcamento'][$j]['ValidadeCashBack'], 'barras');
							
						}
					}
				
				}
			}
		}

		if(!$data['empresa']['idSis_Empresa'] || !$_SESSION['Empresa_Cliente']){
			
			unset($_SESSION['Empresa_Cliente']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['empresa']);
			  echo '<br>';
			  print_r($data['orcamento']);
			  echo "</pre>";
			  exit ();
			*/
			
			$data['select']['TipoAdd'] = array (
				'P' => '.%',
				'V' => 'R$',
			);
			$data['select']['AlterarTodos'] = $this->Basico_model->select_status_sn();		
			
			$data['titulo'] = 'Ranking de Vendas';
			$data['form_open_path'] = 'cliente/alterarcashback';
			$data['relatorio'] = 'Cliente/rankingvendas_pag/';
			$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
			$data['nomeusuario'] = 'NomeColaborador';
			$data['readonly'] = '';
			$data['disabled'] = '';
			$data['panel'] = 'info';
			$data['metodo'] = 3;
			$data['TipoFinanceiro'] = 'Receitas';
			$data['TipoRD'] = 2;
			$data['nome'] = 'Cliente';
			$data['imprimir'] = 'OrcatrataPrint/imprimir/';
			$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
			$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
			$data['edit'] = 'orcatrata/alterarstatus/';
			$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';

			$data['collapse'] = '';	
			$data['collapse1'] = 'class="collapse"';		
			
			if ($data['count']['PRCount'] > 0 )
				$data['parcelasin'] = 'in';
			else
				$data['parcelasin'] = '';

			$data['sidebar'] = 'col-sm-3 col-md-2';
			$data['main'] = 'col-sm-7 col-md-8';

			$data['datepicker'] = 'DatePicker';
			$data['timepicker'] = 'TimePicker';
			
			(!$data['query']['AlterarTodos']) ? $data['query']['AlterarTodos'] = 'N' : FALSE;
			$data['radio'] = array(
				'AlterarTodos' => $this->basico->radio_checked($data['query']['AlterarTodos'], 'AlterarTodos', 'NS'),
			);
			($data['query']['AlterarTodos'] == 'S') ?
				$data['div']['AlterarTodos'] = '' : $data['div']['AlterarTodos'] = 'style="display: none;"';

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
			$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');
			if($data['query']['AlterarTodos'] == 'S'){
				$this->form_validation->set_rules('ValorAddCashBack', 'ValorAddCashBack', 'required|trim');
				$this->form_validation->set_rules('PrazoGeralCashBack', 'PrazoGeralCashBack', 'required|trim');
			}
			
			
			#run form validation
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('cliente/form_alterarcashback', $data);
			
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {

					$data['bd']['AlterarTodos'] = $data['query']['AlterarTodos'];
					$data['bd']['PrazoGeralCashBack'] = $data['query']['PrazoGeralCashBack'];
					$data['bd']['ValorAddCashBack'] = str_replace(',', '.', str_replace('.', '', $data['query']['ValorAddCashBack']));
					$data['bd']['ValidadeGeralCashBack'] = $this->basico->mascara_data($data['query']['ValidadeGeralCashBack'], 'mysql');
					////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////

					#### App_OrcaTrata ####
					$data['update']['orcamento']['anterior'] = $this->Cliente_model->get_alterarcashback($data['empresa']['idSis_Empresa'], FALSE, $_SESSION['Per_Page'], ($_SESSION['Pagina'] * $_SESSION['Per_Page']));
					if (isset($data['orcamento']) || (!isset($data['orcamento']) && isset($data['update']['orcamento']['anterior']) ) ) {

						if (isset($data['orcamento']))
							$data['orcamento'] = array_values($data['orcamento']);
						else
							$data['orcamento'] = array();

						//faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
						$data['update']['orcamento'] = $this->basico->tratamento_array_multidimensional($data['orcamento'], $data['update']['orcamento']['anterior'], 'idApp_Cliente');
						
						$max = count($data['update']['orcamento']['alterar']);
						for($j=0;$j<$max;$j++) {

							$data['update']['orcamento']['alterar'][$j]['Valor'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['Valor']));
							$data['update']['orcamento']['alterar'][$j]['addCashBackCliente'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['addCashBackCliente']));

							if($data['update']['orcamento']['alterar'][$j]['CashBackCliente'] == "" || $data['update']['orcamento']['alterar'][$j]['CashBackCliente'] == 0){
								$data['update']['orcamento']['alterar'][$j]['CashBackCliente'] = "0.00";
							}else{
								$data['update']['orcamento']['alterar'][$j]['CashBackCliente'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['CashBackCliente']));
							}
							
							if(isset($data['update']['orcamento']['alterar'][$j]['addCashBackCliente']) && $data['update']['orcamento']['alterar'][$j]['addCashBackCliente'] != ""){
								$data['addValor'][$j] = $data['update']['orcamento']['alterar'][$j]['addCashBackCliente'];
							}else{					
								if($data['bd']['AlterarTodos'] == "S"){
									$data['addValor'][$j] = $data['bd']['ValorAddCashBack'];
								}else{
									$data['addValor'][$j] = "0.00";
								}
							}
							
							if($data['query']['TipoAdd'] == "V"){					
								$data['addCashBack'][$j] = $data['addValor'][$j];
							}else{
								$data['addCashBack'][$j] = $data['update']['orcamento']['alterar'][$j]['Valor']*$data['addValor'][$j]/100;
							}
							
							$data['alterar']['orcamento'][$j]['CashBackCliente'] = $data['update']['orcamento']['alterar'][$j]['CashBackCliente'] + $data['addCashBack'][$j];
							
							
							if(isset($data['update']['orcamento']['alterar'][$j]['ValidadeCashBack']) && $data['update']['orcamento']['alterar'][$j]['ValidadeCashBack'] != "00/00/0000" && $data['update']['orcamento']['alterar'][$j]['ValidadeCashBack'] != "" ){
								$data['update']['orcamento']['alterar'][$j]['ValidadeCashBack'] = $this->basico->mascara_data($data['update']['orcamento']['alterar'][$j]['ValidadeCashBack'], 'mysql');
							}else{
								$data['update']['orcamento']['alterar'][$j]['ValidadeCashBack'] = $data['hoje'];
							}					
							
							if(isset($data['update']['orcamento']['alterar'][$j]['PrazoCashBack']) && $data['update']['orcamento']['alterar'][$j]['PrazoCashBack'] != ""){
								$data['prazo'][$j] = $data['update']['orcamento']['alterar'][$j]['PrazoCashBack'];
								$data['alterar']['orcamento'][$j]['ValidadeCashBack'] = date('Y-m-d', strtotime($data['update']['orcamento']['alterar'][$j]['ValidadeCashBack'] . '+'.$data['prazo'][$j].'day'));
							}else{					
								if($data['bd']['AlterarTodos'] == "S"){
									if($data['update']['orcamento']['alterar'][$j]['ValidadeCashBack'] >= $data['bd']['ValidadeGeralCashBack']){
										$data['alterar']['orcamento'][$j]['ValidadeCashBack'] = $data['update']['orcamento']['alterar'][$j]['ValidadeCashBack'];
									}else{
										$data['alterar']['orcamento'][$j]['ValidadeCashBack'] = $data['bd']['ValidadeGeralCashBack'];
									}
								}else{
									$data['alterar']['orcamento'][$j]['ValidadeCashBack'] = $data['update']['orcamento']['alterar'][$j]['ValidadeCashBack'];
								}
							}

							$data['update']['orcamento']['bd'] = $this->Cliente_model->update_cliente($data['alterar']['orcamento'][$j], $data['update']['orcamento']['alterar'][$j]['idApp_Cliente']);

						}
			
					}

					$data['msg'] = '?m=1';
					
					redirect(base_url() . 'cliente/alterarcashback/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

					exit();			
				}	
			}
		}
	
        $this->load->view('basico/footer');

    }
	
    public function excluir($id = FALSE) {

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

			$data['query'] = $this->Cliente_model->get_cliente($id, TRUE);
		
			if($data['query'] === FALSE){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
		
				if($this->Basico_model->get_dt_validade() === FALSE){
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {

					/*
					#$this->Cliente_model->delete_cliente($id);
					#$data['msg'] = '?m=1';
					//redirect(base_url() . 'cliente/pesquisar');
					*/
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
				}
			}
		}
        $this->load->view('basico/footer');
    }

    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			if ($this->input->get('start') && $this->input->get('end')) {
				//$data['start'] = substr($this->input->get('start'),0,-3);
				//$data['end'] = substr($this->input->get('end'),0,-3);
				$_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
				$_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);
			}		
			
			$data['titulo'] = "Pesquisar Cliente";
			$data['novo'] = '';

			$this->load->library('pagination');
			$config['per_page'] = 10;
			$config["uri_segment"] = 4;
			$config['reuse_query_string'] = TRUE;
			$config['num_links'] = 3;
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
			$data['total'] = $this->Cliente_model->lista_cliente_total();
			$data['Pesquisa'] = '';

			#echo '<br><br><br><br> >> ' . $this->uri->segment(3);
			
			if ($this->uri->segment(3)) {
			
				$data['Pesquisa'] = urldecode($this->uri->segment(3));

				#run form validation
				if ($this->Cliente_model->lista_cliente($data['Pesquisa'], TRUE) === TRUE) {

					$config['base_url'] = base_url() . 'cliente/pesquisar/' . $data['Pesquisa'] . '/';
					$config['total_rows'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], FALSE, TRUE);
					($config['total_rows'] > 1) ? $data['total_rows'] = $config['total_rows'] . ' resultados' : $config['total_rows'] . ' resultado';
					($config['total_rows'] > 1) ? $data['cadastrar'] = FALSE : $data['cadastrar'] = TRUE;
					$this->pagination->initialize($config);
					
					#echo '<br><br><br><br> >> ' . $config["uri_segment"];
					
					$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
					$data['query'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], FALSE, FALSE, $config["per_page"], ($page * $config["per_page"]));
					/*
					echo "<pre>";
					print_r($data['total']);
					echo "</pre>";
					exit();
					*/
					$data['pagination'] = $this->pagination->create_links();

					if ($data['query']->num_rows() == 1) {
						$info = $data['query']->result_array();
						
						if ($_SESSION['agenda'])
							redirect('consulta/cadastrar/' . $info[0]['idApp_Cliente'] );
						else
							redirect('cliente/prontuario/' . $info[0]['idApp_Cliente'] );

						exit();
					} else {
						$data['list'] = $this->load->view('cliente/list_cliente', $data, TRUE);
					}				
					
					
					//$data['list'] = $this->load->view('cliente/list_cliente', $data, TRUE);
				}
			} elseif ($this->input->post('Pesquisa')) {

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_cliente');

				#$data['Pesquisa'] = $this->input->post('Pesquisa');
				#echo '<br /><br /><br /> >>> '.$this->input->post('Pesquisa').'<>'.$_SESSION['DataURI'] = (strpos($data['Pesquisa'], "/") > 0) ? TRUE : FALSE;
				#$_SESSION['DataURI'] = (strpos($data['Pesquisa'], "/") > 0) ? TRUE : FALSE;
				if((strpos($data['Pesquisa'], "/") > 0)) {
					$data['Pesquisa'] = str_replace("/", "", $this->input->post('Pesquisa'));
					$SESSION['DataURI'] = TRUE;
				}
				else {
					$data['Pesquisa'] = $this->input->post('Pesquisa');
					$SESSION['DataURI'] = FALSE;
				}


				#run form validation
				if ($this->form_validation->run() !== FALSE && $this->Cliente_model->lista_cliente($data['Pesquisa'], TRUE) === TRUE) {

					$config['base_url'] = base_url() . 'cliente/pesquisar/' . $data['Pesquisa'] . '/';
					$config['total_rows'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], FALSE, TRUE);
					/*
					echo "<pre>";
					print_r($data['total']);
					echo "</pre>";
					exit();
					*/
					($config['total_rows'] > 1) ? $data['total_rows'] = $config['total_rows'] . ' resultados' : $data['total_rows'] = $config['total_rows'] . ' resultado';
					($config['total_rows'] > 1) ? $data['cadastrar'] = FALSE : $data['cadastrar'] = TRUE;
					$this->pagination->initialize($config);

					$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
					$data['query'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], FALSE, FALSE, $config["per_page"], ($page * $config["per_page"]));

					$data['pagination'] = $this->pagination->create_links();

					if ($data['query']->num_rows() == 1) {
						$info = $data['query']->result_array();
						
						if ($_SESSION['agenda'])
							redirect('consulta/cadastrar/' . $info[0]['idApp_Cliente'] );
						else
							redirect('cliente/prontuario/' . $info[0]['idApp_Cliente'] );

						exit();
					} else {
						$data['list'] = $this->load->view('cliente/list_cliente', $data, TRUE);
					}                
					
					
					//$data['list'] = $this->load->view('cliente/list_cliente', $data, TRUE);
				}
			}

			($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;
			
			$this->load->view('cliente/pesq_cliente', $data);
		}
        $this->load->view('basico/footer');		

    }

    public function clientes() {
		
		unset($_SESSION['FiltroClientes']);
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Cliente N�o Encontrado.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa est� muito grande, ela excedeu 30000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'id_Cliente_Auto',
				'NomeClienteAuto',
				'id_ClientePet_Auto',
				'NomeClientePetAuto',
				'id_ClienteDep_Auto',
				'NomeClienteDepAuto',
			), TRUE));	
			
			$data['query'] = quotes_to_entities($this->input->post(array(
				//'NomeCliente',
				'idApp_Cliente',
				'idApp_ClientePet',
				'idApp_ClienteDep',
				'idApp_ClientePet2',
				'idApp_ClienteDep2',
				'Ativo',
				'Motivo',
				'Ordenamento',
				'Campo',
				'DataInicio',
				'DataFim',
				'DataInicio2',
				'DataFim2',
				'DataInicio3',
				'DataFim3',
				'Dia',
				'Mes',
				'Ano',
				'Texto1',
				'Texto2',
				'Texto3',
				'Texto4',
				'Agrupar',
				'Pedidos',
				'Sexo',
				'Pesquisa',
			), TRUE));

			$data['select']['Ativo'] = array(
				'#' => 'TODOS',
				'N' => 'N�o',
				'S' => 'Sim',
			);
			
			$data['select']['Sexo'] = array(
				'0' => 'Todos',
				'1' => 'Masculino',
				'2' => 'Feminino',
				'3' => 'Outros',
			);
			
			if($_SESSION['Empresa']['CadastrarPet'] == "S"){
				$data['select']['Agrupar'] = array(
					'0' => 'Cliente & Pet',
					'1' => 'Cliente',
				);
			}else{
				if($_SESSION['Empresa']['CadastrarDep'] == "S"){
					$data['select']['Agrupar'] = array(
						'0' => 'Cliente & Dep',
						'1' => 'Cliente',
					);
				}else{
					$data['select']['Agrupar'] = array(
						'0' => 'Cliente',
					);
				}
			}	
				
			$data['select']['Pedidos'] = array(
				'0' => 'Todos',
				'1' => 'Clientes S/Pedidos',
				'2' => 'Clientes C/Pedidos',
			);
					
			$data['select']['Campo'] = array(
				'C.idApp_Cliente' => 'n� Cliente',
				'C.NomeCliente' => 'Nome do Cliente',
				'C.Ativo' => 'Ativo',
				'C.DataNascimento' => 'Data de Nascimento',
				'C.DataCadastroCliente' => 'Data do Cadastro',
				'C.Sexo' => 'Sexo',
				'C.BairroCliente' => 'Bairro',
				'C.MunicipioCliente' => 'Munic�pio',
				'C.Email' => 'E-mail',
				'CC.NomeContatoCliente' => 'Contato do Cliente',
				'TCC.RelaPes' => 'Rel. Pes.',
				'TCC.RelaCom' => 'Rel. Com.',
				'CC.Sexo' => 'Sexo',
				'C.UltimoPedido' => 'Ultimo Pedido',
				'C.ValidadeCashBack' => 'Validade CashBack',

			);

			$data['select']['Ordenamento'] = array(
				'ASC' => 'Crescente',
				'DESC' => 'Decrescente',
			);

			//$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
			$data['select']['Dia'] = $this->Relatorio_model->select_dia();
			$data['select']['Mes'] = $this->Relatorio_model->select_mes();
			$data['select']['Motivo'] = $this->Relatorio_model->select_motivo();
			
			$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

			$data['titulo'] = 'Clientes';
			$data['form_open_path'] = 'Cliente/clientes';
			
			$data['paginacao'] = 'N';

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
			$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'trim');
			$this->form_validation->set_rules('DataInicio', 'Data In�cio do Cadastro', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim', 'Data Fim do Cadastro', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio2', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim2', 'Data Fim', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio3', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim3', 'Data Fim', 'trim|valid_date');

			#run form validation
			if ($this->form_validation->run() !== FALSE) {

				$_SESSION['FiltroClientes']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
				$_SESSION['FiltroClientes']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
				$_SESSION['FiltroClientes']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
				$_SESSION['FiltroClientes']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
				$_SESSION['FiltroClientes']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
				$_SESSION['FiltroClientes']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');        
				$_SESSION['FiltroClientes']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
				$_SESSION['FiltroClientes']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
				$_SESSION['FiltroClientes']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
				$_SESSION['FiltroClientes']['idApp_ClientePet2'] = $data['query']['idApp_ClientePet2'];
				$_SESSION['FiltroClientes']['idApp_ClienteDep2'] = $data['query']['idApp_ClienteDep2'];
				$_SESSION['FiltroClientes']['Ativo'] = $data['query']['Ativo'];
				$_SESSION['FiltroClientes']['Motivo'] = $data['query']['Motivo'];
				$_SESSION['FiltroClientes']['Campo'] = $data['query']['Campo'];
				$_SESSION['FiltroClientes']['Ordenamento'] = $data['query']['Ordenamento'];
				$_SESSION['FiltroClientes']['Dia'] = $data['query']['Dia'];
				$_SESSION['FiltroClientes']['Mes'] = $data['query']['Mes'];
				$_SESSION['FiltroClientes']['Ano'] = $data['query']['Ano'];
				$_SESSION['FiltroClientes']['Agrupar'] = $data['query']['Agrupar'];
				$_SESSION['FiltroClientes']['Pedidos'] = $data['query']['Pedidos'];
				$_SESSION['FiltroClientes']['Sexo'] = $data['query']['Sexo'];
				$_SESSION['FiltroClientes']['Pesquisa'] = $data['query']['Pesquisa'];

				$data['pesquisa_query'] = $this->Cliente_model->list_clientes($_SESSION['FiltroClientes'],TRUE, TRUE);

				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'Cliente/clientes' . $data['msg']);
					exit();
				}else{

					$config['total_rows'] = $data['pesquisa_query'];
					
					$config['base_url'] = base_url() . 'Cliente/clientes_pag/';					
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

					if($config['total_rows'] >= 1){
						$data['total_rows'] = $config['total_rows'];
					}else{
						$data['total_rows'] = 0;
					}
					
					$this->pagination->initialize($config);
					
					$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
					$data['pagina'] = $page;
					$data['per_page'] = $config['per_page'];

					$data['report'] = $this->Cliente_model->list_clientes($_SESSION['FiltroClientes'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
					
					$_SESSION['FiltroClientes']['Texto1'] = utf8_encode($data['query']['Texto1']);
					$_SESSION['FiltroClientes']['Texto2'] = utf8_encode($data['query']['Texto2']);
					$_SESSION['FiltroClientes']['Texto3'] = utf8_encode($data['query']['Texto3']);
					$_SESSION['FiltroClientes']['Texto4'] = utf8_encode($data['query']['Texto4']);					

					$data['pagination'] = $this->pagination->create_links();

					if($data['query']['idApp_Cliente']){
						if ($data['report']->num_rows() >= 1) {
							$info = $data['report']->result_array();
							redirect('cliente/prontuario/' . $info[0]['idApp_Cliente'] );
							exit();
						} else {
							$data['list'] = $this->load->view('cliente/list_clientes', $data, TRUE);
						}				
					}else{
						$data['list'] = $this->load->view('cliente/list_clientes', $data, TRUE);
					}
				}	
			}

			$this->load->view('cliente/tela_clientes', $data);
		}
        $this->load->view('basico/footer');

    }

    public function clientes_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{

			$data['titulo'] = 'Clientes';
			$data['form_open_path'] = 'Cliente/clientes_pag';
			
			$data['paginacao'] = 'S';
			$data['caminho'] = 'Cliente/clientes/';
				
			if(!isset($_SESSION['FiltroClientes'])){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}else{							

				$data['pesquisa_query'] = $this->Cliente_model->list_clientes($_SESSION['FiltroClientes'],TRUE, TRUE);

				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'Cliente/clientes' . $data['msg']);
					exit();
				}else{

					$config['base_url'] = base_url() . 'Cliente/clientes_pag/';
					
					//$config['total_rows'] = $this->Cliente_model->list_clientes(FALSE, TRUE, TRUE);

					$config['total_rows'] = $data['pesquisa_query'];			   					
					
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
					$data['Pesquisa'] = '';

					if($config['total_rows'] >= 1){
						$data['total_rows'] = $config['total_rows'];
					}else{
						$data['total_rows'] = 0;
					}
					
					$this->pagination->initialize($config);
					
					$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
					$data['pagina'] = $page;
					$data['per_page'] = $config['per_page'];
					$data['report'] = $this->Cliente_model->list_clientes($_SESSION['FiltroClientes'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
					
					$data['pagination'] = $this->pagination->create_links();

					if($_SESSION['FiltroClientes']['Agrupar'] != "0"){
						$data['aparecer'] = 0;
					}else{
						$data['aparecer'] = 1;
					}
					
					$data['list'] = $this->load->view('cliente/list_clientes', $data, TRUE);
				
				}
			}	
			$this->load->view('cliente/tela_clientes', $data);
		}
        $this->load->view('basico/footer');

    }

	public function clientes_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Clientes Sem Filtros';
				$data['metodo'] = $id;
				$data['aparecer'] = 1;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroClientes'])){
					if(isset($_SESSION['FiltroClientes']['Agrupar']) && $_SESSION['FiltroClientes']['Agrupar'] != "0"){
						$_SESSION['FiltroClientes']['Aparecer'] = 0;
						$data['aparecer'] = 0;
					}else{
						$_SESSION['FiltroClientes']['Aparecer'] = 1;
						$data['aparecer'] = 1;
					}
					$dados = $_SESSION['FiltroClientes'];
					$data['titulo'] = 'Clientes Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Clientes Sem Filtros';
					$data['metodo'] = 1;
					$data['aparecer'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Clientes Sem Filtros';
				$data['metodo'] = 1;
				$data['aparecer'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Clientes Sem Filtros';
			$data['metodo'] = 1;
			$data['aparecer'] = 1;
		}

        $data['nome'] = 'Cliente';

		$data['report'] = $this->Cliente_model->list_clientes($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Cliente/clientes' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('cliente/list_clientes_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

	public function clientes_csv($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 3){
				if(isset($_SESSION['FiltroClientes'])){
					$_SESSION['FiltroClientes']['Aparecer'] = 0;
					$dados = $_SESSION['FiltroClientes'];
					$data['titulo'] = 'G-mail Com Filtros';
					$data['metodo'] = $id;
				}else{
					$data['msg'] = '?m=4';
					redirect(base_url() . 'Cliente/clientes' . $data['msg']);
					exit();
				}
			}else{
				$data['msg'] = '?m=4';
				redirect(base_url() . 'Cliente/clientes' . $data['msg']);
				exit();
			}
		}else{		
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Cliente/clientes' . $data['msg']);
			exit();
		}
		
        $data['nome'] = 'Cliente';

		$data['report'] = $this->Cliente_model->list_clientes($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Cliente/clientes' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('cliente/list_clientes_csv', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

    public function imprimirlistacliente($id = FALSE) {

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
				
				$data['Imprimir']['DataInicio'] = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio'], 'barras') : FALSE;
				$data['Imprimir']['DataFim'] = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim'], 'barras') : FALSE;
				$data['Imprimir']['DataInicio6'] = ($_SESSION['FiltroAlteraParcela']['DataInicio6']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio6'], 'barras') : FALSE;
				$data['Imprimir']['DataFim6'] = ($_SESSION['FiltroAlteraParcela']['DataFim6']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim6'], 'barras') : FALSE;
				
				//$_SESSION['DataInicio'] = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio'], 'barras') : FALSE;
				$_SESSION['DataInicio'] = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? $_SESSION['FiltroAlteraParcela']['DataInicio'] : FALSE;
				
				/*
				echo '<br>';
				echo "<pre>";
				print_r($data['Imprimir']['DataInicio']);
				echo "</pre>";
				exit ();
				*/

				//$this->load->library('pagination');

				$data['Pesquisa'] = '';

				$data['pesquisa_query'] = $this->Orcatrataprint_model->get_orcatrata_cliente($id, TRUE);
				$config['total_rows'] = $data['pesquisa_query']->num_rows();
				
				//$config['total_rows'] = $this->Orcatrataprint_model->get_orcatrata_cliente($id, TRUE);
				
				$config['base_url'] = base_url() . 'OrcatrataPrint/imprimirlistacliente/' . $id . '/';
				$config['per_page'] = 19;
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

				#### App_OrcaTrata ####
				//$data['orcatrata'] = $this->Orcatrataprintcobranca_model->get_orcatrata_cliente($id);
				$data['orcatrata'] = $this->Orcatrataprint_model->get_orcatrata_cliente($id, FALSE, $config['per_page'], ($page * $config['per_page']));
				if (count($data['orcatrata']) > 0) {
					$data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
					$data['count']['POCount'] = count($data['orcatrata']);           

					if (isset($data['orcatrata'])) {

						for($j=1;$j<=$data['count']['POCount'];$j++) {
							
							$data['orcatrata'][$j]['idApp_OrcaTrata'] = $data['orcatrata'][$j]['idApp_OrcaTrata'];
							$data['orcatrata'][$j]['DataCadastroCliente'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataCadastroCliente'], 'barras');
							$data['orcatrata'][$j]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataOrca'], 'barras');
							$data['orcatrata'][$j]['DataPrazo'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataPrazo'], 'barras');
							$data['orcatrata'][$j]['DataConclusao'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataConclusao'], 'barras');
							$data['orcatrata'][$j]['DataRetorno'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataRetorno'], 'barras');
							$data['orcatrata'][$j]['DataQuitado'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataQuitado'], 'barras');
							$data['orcatrata'][$j]['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntradaOrca'], 'barras');
							$data['orcatrata'][$j]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntregaOrca'], 'barras');
							$data['orcatrata'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataVencimentoOrca'], 'barras');
							$data['orcatrata'][$j]['ValorTotalOrca'] = number_format(($data['orcatrata'][$j]['ValorTotalOrca']), 2, ',', '.');
							$data['orcatrata'][$j]['ConcluidoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$j]['ConcluidoOrca'], 'NS');
							$data['orcatrata'][$j]['QuitadoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$j]['QuitadoOrca'], 'NS');

						}
					}	
				}
				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data['orcatrata']);
				  echo "</pre>";
				  //exit ();
				*/ 


				$data['titulo'] = 'Lista Clientes';
				$data['form_open_path'] = 'OrcatrataPrint/imprimirlistacliente';
				$data['panel'] = 'info';
				$data['metodo'] = 1;
				$data['imprimir'] = 'OrcatrataPrint/imprimir/';
				$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistacliente/';
				$data['imprimirrecibo'] = 'Cobrancas/cobrancas_recibo/';
				
				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data);
				  echo "</pre>";
				  #exit ();
				 */

				$this->load->view('orcatrata/print_orcatratacliente_lista', $data);
			}
		}
        $this->load->view('basico/footer');

    }

	public function rankingvendas() {
		
		unset($_SESSION['FiltroRankingVendas']);

		if ($this->input->get('m') == 1)
			$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
		elseif ($this->input->get('m') == 2)
			$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
		else
			$data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'id_Cliente_Auto',
				'NomeClienteAuto',
			), TRUE));	
				
			$data['query'] = quotes_to_entities($this->input->post(array(
				'ValorOrca',
				'NomeCliente',
				'idApp_Cliente',
				'DataInicio',
				'DataFim',
				'DataInicio2',
				'DataFim2',
				'DataInicio3',
				'DataFim3',
				'Ordenamento',
				'Campo',
				'Pedidos_de',
				'Pedidos_ate',
				'Valor_de',
				'Valor_ate',
				'Valor_cash_de',
				'Valor_cash_ate',
				'Ultimo',
				'Texto1',
				'Texto2',
				'Texto3',
				'Texto4',
				'nomedoCliente',
				'idCliente',
				'numerodopedido',
				'site',
			), TRUE));
			
			$data['select']['nomedoCliente'] = $this->Basico_model->select_status_sn();
			$data['select']['idCliente'] = $this->Basico_model->select_status_sn();
			$data['select']['numerodopedido'] = $this->Basico_model->select_status_sn();
			$data['select']['site'] = $this->Basico_model->select_status_sn();
			
			(!$data['query']['nomedoCliente']) ? $data['query']['nomedoCliente'] = 'N' : FALSE;
			$data['radio'] = array(
				'nomedoCliente' => $this->basico->radio_checked($data['query']['nomedoCliente'], 'nomedoCliente', 'NS'),
			);
			($data['query']['nomedoCliente'] == 'S') ?
				$data['div']['nomedoCliente'] = '' : $data['div']['nomedoCliente'] = 'style="display: none;"';		

			(!$data['query']['idCliente']) ? $data['query']['idCliente'] = 'N' : FALSE;
			$data['radio'] = array(
				'idCliente' => $this->basico->radio_checked($data['query']['idCliente'], 'idCliente', 'NS'),
			);
			($data['query']['idCliente'] == 'S') ?
				$data['div']['idCliente'] = '' : $data['div']['idCliente'] = 'style="display: none;"';
				
			(!$data['query']['numerodopedido']) ? $data['query']['numerodopedido'] = 'N' : FALSE;
			$data['radio'] = array(
				'numerodopedido' => $this->basico->radio_checked($data['query']['numerodopedido'], 'numerodopedido', 'NS'),
			);
			($data['query']['numerodopedido'] == 'S') ?
				$data['div']['numerodopedido'] = '' : $data['div']['numerodopedido'] = 'style="display: none;"';		

			(!$data['query']['site']) ? $data['query']['site'] = 'N' : FALSE;
			$data['radio'] = array(
				'site' => $this->basico->radio_checked($data['query']['site'], 'site', 'NS'),
			);
			($data['query']['site'] == 'S') ?
				$data['div']['site'] = '' : $data['div']['site'] = 'style="display: none;"';		

			$data['select']['Campo'] = array(
				'Valor' => 'Valor Pedido',
				'F.CashBackCliente' => 'Valor CashBach',
				'ContPedidos' => 'Pedidos',
				'F.NomeCliente' => 'Cliente',
				'F.idApp_Cliente' => 'Id',
				'F.UltimoPedido' => 'Ultimo Pedido',
			);

			$data['select']['Ordenamento'] = array(
				'DESC' => 'Decrescente',
				'ASC' => 'Crescente',
			);
			
			$data['select']['Ultimo'] = array(
				'0' => '::Nenhum::',			
				#'1' => '�ltimo Pedido',
			);		

			$data['titulo'] = 'Ranking de Vendas';
			$data['form_open_path'] = 'Cliente/rankingvendas';	
			$data['paginacao'] = 'N';
			$data['nome'] = 'Cliente';
			
			$_SESSION['FiltroRankingVendas']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$_SESSION['FiltroRankingVendas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$_SESSION['FiltroRankingVendas']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['FiltroRankingVendas']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroRankingVendas']['Pedidos_de'] = $data['query']['Pedidos_de'];
			$_SESSION['FiltroRankingVendas']['Pedidos_ate'] = $data['query']['Pedidos_ate'];
			$_SESSION['FiltroRankingVendas']['Valor_de'] = $data['query']['Valor_de'];
			$_SESSION['FiltroRankingVendas']['Valor_ate'] = $data['query']['Valor_ate'];
			$_SESSION['FiltroRankingVendas']['Valor_cash_de'] = $data['query']['Valor_cash_de'];
			$_SESSION['FiltroRankingVendas']['Valor_cash_ate'] = $data['query']['Valor_cash_ate'];
			$_SESSION['FiltroRankingVendas']['Ultimo'] = $data['query']['Ultimo'];
			
			$_SESSION['FiltroRankingVendas']['Texto1'] = utf8_encode($data['query']['Texto1']);
			$_SESSION['FiltroRankingVendas']['Texto2'] = utf8_encode($data['query']['Texto2']);
			$_SESSION['FiltroRankingVendas']['Texto3'] = utf8_encode($data['query']['Texto3']);
			$_SESSION['FiltroRankingVendas']['Texto4'] = utf8_encode($data['query']['Texto4']);	
			$_SESSION['FiltroRankingVendas']['nomedoCliente'] = $data['query']['nomedoCliente'];
			$_SESSION['FiltroRankingVendas']['idCliente'] = $data['query']['idCliente'];
			$_SESSION['FiltroRankingVendas']['numerodopedido'] = $data['query']['numerodopedido'];
			$_SESSION['FiltroRankingVendas']['site'] = $data['query']['site'];	
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
			#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
			$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio2', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim2', 'Data Fim', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio3', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim3', 'Data Fim', 'trim|valid_date');

			#run form validation
			if ($this->form_validation->run() !== FALSE) {

				$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
				$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
				$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
				$data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
				$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
				$data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
				$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
				$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
				$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
				$data['bd']['Campo'] = $data['query']['Campo'];
				$data['bd']['Valor_de'] = $data['query']['Valor_de'];
				$data['bd']['Valor_ate'] = $data['query']['Valor_ate'];
				$data['bd']['Valor_cash_de'] = $data['query']['Valor_cash_de'];
				$data['bd']['Valor_cash_ate'] = $data['query']['Valor_cash_ate'];
				$data['bd']['Pedidos_de'] = $data['query']['Pedidos_de'];
				$data['bd']['Pedidos_ate'] = $data['query']['Pedidos_ate'];
				$data['bd']['Ultimo'] = $data['query']['Ultimo'];

				//$data['report'] = $this->Cliente_model->list_rankingvendas($data['bd'],TRUE);

				//$this->load->library('pagination');
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
				$data['Pesquisa'] = '';
				
				$config['base_url'] = base_url() . 'Cliente/rankingvendas_pag/';
				$config['total_rows'] = $this->Cliente_model->list_rankingvendas($data['bd'],TRUE, TRUE);
			   
				if($config['total_rows'] >= 1){
					$data['total_rows'] = $config['total_rows'];
				}else{
					$data['total_rows'] = 0;
				}
				
				$this->pagination->initialize($config);
				
				$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
				$data['pagina'] = $page;
				$data['per_page'] = $config['per_page'];
				$data['report'] = $this->Cliente_model->list_rankingvendas($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
				$data['pagination'] = $this->pagination->create_links();
				
				$data['list'] = $this->load->view('cliente/list_rankingvendas', $data, TRUE);
				//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
			}

			$this->load->view('cliente/tela_rankingvendas', $data);
		}
		$this->load->view('basico/footer');

	}

	public function rankingvendas_pag() {

		if ($this->input->get('m') == 1)
			$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
		elseif ($this->input->get('m') == 2)
			$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
		else
			$data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'id_Cliente_Auto',
				'NomeClienteAuto',
			), TRUE));	
				
			$data['query'] = quotes_to_entities($this->input->post(array(
				'ValorOrca',
				'NomeCliente',
				'idApp_Cliente',
				'DataInicio',
				'DataFim',
				'DataInicio2',
				'DataFim2',
				'DataInicio3',
				'DataFim3',
				'Ordenamento',
				'Campo',
				'Pedidos_de',
				'Pedidos_ate',
				'Valor_de',
				'Valor_ate',
				'Valor_cash_de',
				'Valor_cash_ate',
				'Ultimo',
				'Texto1',
				'Texto2',
				'Texto3',
				'Texto4',
				'nomedoCliente',
				'idCliente',
				'numerodopedido',
				'site',
			), TRUE));

			$data['titulo'] = 'Ranking de Vendas';
			$data['form_open_path'] = 'Cliente/rankingvendas_pag';	
			$data['paginacao'] = 'S';
			$data['caminho'] = 'Cliente/rankingvendas/';
			$data['nome'] = 'Cliente';
			
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
				$data['Pesquisa'] = '';
				
				$config['base_url'] = base_url() . 'Cliente/rankingvendas_pag/';
				$config['total_rows'] = $this->Cliente_model->list_rankingvendas(FALSE, TRUE, TRUE);
			   
				if($config['total_rows'] >= 1){
					$data['total_rows'] = $config['total_rows'];
				}else{
					$data['total_rows'] = 0;
				}
				
				$this->pagination->initialize($config);
				
				$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
				$data['pagina'] = $page;
				$data['per_page'] = $config['per_page'];
				$data['report'] = $this->Cliente_model->list_rankingvendas(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
				$data['pagination'] = $this->pagination->create_links();
				
				$data['list'] = $this->load->view('cliente/list_rankingvendas', $data, TRUE);
				//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
			}

			$this->load->view('cliente/tela_rankingvendas', $data);
		}
		$this->load->view('basico/footer');

	}

    function get_cliente($data) {

        if ($this->Cliente_model->lista_cliente($data, TRUE) === FALSE) {
            $this->form_validation->set_message('get_cliente', '<strong>Cliente</strong> n�o encontrado.');
			return FALSE;
        } else {
			return TRUE;
        }
    }

}
