<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Contatocliente_model', 'Clientedep_model', 'Clientepet_model'));
        #$this->load->model(array('Basico_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('cliente/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('cliente/tela_index', $data);

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
			'CadastrarResp',
			'Responsavel',
			'idApp_Responsavel',
			'RelacaoDep',
        ), TRUE));        
		
		$data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Empresa',
			'idSis_Usuario',
			'idApp_Cliente',
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
		
		
		$caracteres_sem_acento = array(
			'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
			'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
			'Ï'=>'I', 'Ñ'=>'N', 'N'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
			'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
			'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
			'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'n'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
			'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
			'a'=>'a', 'î'=>'i', 'â'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', 'Î'=>'I', 'Â'=>'A', '?'=>'S', '?'=>'T',
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
        $data['select']['MunicipioCliente'] = $this->Basico_model->select_municipio();
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
		
		
		$data['q_motivo'] = $this->Cliente_model->list_motivo($_SESSION['log'], TRUE);
		$data['list_motivo'] = $this->load->view('cliente/list_motivo', $data, TRUE);		
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeCliente', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Cliente.NomeCliente.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('CpfCliente', 'Cpf', 'trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[App_Cliente.CpfCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('NomeCliente', 'Nome do Cliente', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        if($data['cadastrar']['Responsavel'] == 'S'){
			$this->form_validation->set_rules('CelularCliente', 'CelularCliente', 'required|trim|is_unique_duplo[App_Cliente.CelularCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']|valid_celular');
        }else{
			$this->form_validation->set_rules('idApp_Responsavel', 'Nome do Responsável', 'required|trim');
			$this->form_validation->set_rules('RelacaoDep', 'Relação', 'required|trim');
		}
		$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
		if($data['query']['Ativo'] == 'N'){
			$this->form_validation->set_rules('Motivo', 'Motivo', 'required|trim');
		}
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('cliente/form_cliente', $data);
        } else {
		
			if($data['cadastrar']['Responsavel'] == 'S'){
			
				$_SESSION['Empresa5'] = $data['empresa5'] = $this->Cliente_model->get_empresa5($data['query']['CelularCliente']);
				
				if (!isset($_SESSION['Empresa5'])){
					
					//$data['usuario']['Nome'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
					$data['usuario']['Nome'] = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));
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
						/*
						$data['usuario']['Usuario'] = $data['idSis_Usuario'];
						$data['usuario']['Senha'] = md5($data['idSis_Usuario']);
						$data['update']['usuario']['bd'] = $this->Cliente_model->update_usuario($data['usuario'], $data['idSis_Usuario']);
						*/
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
							'NomeAgenda' => 'Cliente',
							'idSis_Usuario' => $data['idSis_Usuario'],
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

        $this->load->view('basico/footer');
    }

    public function cadastrar_orig() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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

        #$this->form_validation->set_rules('NomeCliente', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Cliente.NomeCliente.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('CpfCliente', 'Cpf', 'trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[App_Cliente.CpfCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('NomeCliente', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('CelularCliente', 'CelularCliente', 'required|trim|is_unique_duplo[App_Cliente.CelularCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']|valid_celular');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
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
			'S' => 'O Próprio',
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
						'NomeAgenda' => 'Cliente',
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
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
            'MunicipioCliente',
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
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Cliente_model->get_cliente($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'barras');
			$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'barras');
        }

		$caracteres_sem_acento = array(
			'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
			'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
			'Ï'=>'I', 'Ñ'=>'N', 'N'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
			'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
			'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
			'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'n'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
			'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
			'a'=>'a', 'î'=>'i', 'â'=>'a', '?'=>'s', '?'=>'t', 'A'=>'A', 'Î'=>'I', 'Â'=>'A', '?'=>'S', '?'=>'T',
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
        $data['select']['MunicipioCliente'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Associado'] = $this->Basico_model->select_status_sn();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		$data['select']['Motivo'] = $this->Basico_model->select_motivo();
		$data['select']['ClienteConsultor'] = $this->Basico_model->select_status_sn();
		$data['select']['Profissional'] = $this->Basico_model->select_profissional2();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresacli();
		//$data['select']['idApp_Responsavel'] = $this->Basico_model->select_responsavel();
		/*
		$data['select']['Responsavel'] = array(
			'N' => 'Outro',
			'S' => 'O Próprio',
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
			$data['query']['MunicipioCliente'] || $data['query']['Obs'] || $data['query']['Email'] || 
			$data['query']['RegistroFicha'] || $data['query']['CepCliente'] || $data['query']['CpfCliente'] || 
			$data['query']['Rg']  || $data['query']['OrgaoExp'] || $data['query']['EstadoCliente']  || $data['query']['DataEmissao'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

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
		
		$data['q_motivo'] = $this->Cliente_model->list_motivo($_SESSION['log'], TRUE);
		$data['list_motivo'] = $this->load->view('cliente/list_motivo', $data, TRUE);		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeCliente', 'Nome do Cliente', 'required|trim|is_unique_duplo[App_Cliente.NomeCliente.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        #$this->form_validation->set_rules('CpfCliente', 'Cpf', 'trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[App_Cliente.CpfCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('CpfCliente', 'Cpf', 'trim|valid_cpf|alpha_numeric_spaces|is_unique_by_id_empresa[App_Cliente.CpfCliente.' . $data['query']['idApp_Cliente'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('NomeCliente', 'Nome do Cliente', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('CelularCliente', 'CelularCliente', 'required|trim|is_unique_by_id_empresa[App_Cliente.CelularCliente.' . $data['query']['idApp_Cliente'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']|valid_celular');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
		if($data['query']['Ativo'] == 'N'){
			$this->form_validation->set_rules('Motivo', 'Motivo', 'required|trim');
		}
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('cliente/form_cliente', $data);
        } else {

			$_SESSION['Empresa5'] = $data['empresa5'] = $this->Cliente_model->get_empresa5($data['query']['CelularCliente']);
			
			if (!isset($_SESSION['Empresa5'])){
				
				$data['usuario']['Nome'] = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));
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
				if(!isset($data['query']['senha'])){
					$data['usuario']['Senha'] = md5($data['query']['CelularCliente']);
					$data['query']['senha'] = $data['usuario']['Senha'];
					//$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
				}else{
					$data['usuario']['Senha'] = $data['query']['senha'];
				}
				$data['anterior'] = array();
				$data['campos'] = array_keys($data['usuario']);

				$data['idSis_Usuario'] = $this->Cliente_model->set_usuario($data['usuario']);

				if ($data['idSis_Usuario'] === FALSE) {
					$data['msg'] = '?m=2';
					$this->load->view('cliente/form_cliente', $data);
				} else {

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
						'NomeAgenda' => 'Cliente',
						'idSis_Usuario' => $data['idSis_Usuario'],
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
					$data['query']['idSis_Usuario_5'] = $data['idSis_Usuario'];
					$data['query']['Codigo'] = $data['usuario']['Codigo'];
								
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
				$data['query']['usuario'] = $data['query']['CelularCliente'];
				$data['query']['senha'] = $_SESSION['Empresa5']['Senha'];
				if(!isset($data['query']['CodInterno'])){
					$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
				}
				$data['query']['idSis_Usuario_5'] = $_SESSION['Empresa5']['idSis_Usuario'];
				$data['query']['Codigo'] = $_SESSION['Empresa5']['Codigo'];				

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

        $this->load->view('basico/footer');
    }
	
    public function alterar_status($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            $data['query'] = $this->Cliente_model->get_cliente($id);
			$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		
		if($data['query']['Ativo'] == 'N'){
			$this->form_validation->set_rules('Motivo', 'Motivo', 'required|trim');
		}
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

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

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
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('cliente/form_cliente', $data);
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

        $this->load->view('basico/footer');
    }

    public function alterarlogo1($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
        }
		
        if ($id)
            $data['file']['idApp_Cliente'] = $id;

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

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('cliente/form_perfil', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('cliente/form_perfil', $data);
            }
            else {

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

        $this->load->view('basico/footer');
    }
	
    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->Cliente_model->delete_cliente($id);

        $data['msg'] = '?m=1';

		//redirect(base_url() . 'agenda' . $data['msg']);
		redirect(base_url() . 'cliente/pesquisar');
		exit();

        $this->load->view('basico/footer');
    }

    public function pesquisar_2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		

        //$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        //$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'trim|callback_get_cliente');
		//$this->form_validation->set_rules('NomeDoCliente', 'Nome do Cliente', 'trim');
		//$this->form_validation->set_rules('TelefoneDoCliente', 'Telefone do Cliente', 'trim');

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);
        }

        $data['titulo'] = "Pesquisar Cliente";
		
		$this->load->library('pagination');
		$_SESSION['Qtde'] = $config['per_page'] = 5;
		$_SESSION['Page'] = $config["uri_segment"] = 5;
		
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

		
        $_SESSION['pesquisa'] = $data['Pesquisa'] = $this->input->post('Pesquisa');
		$_SESSION['nomedocliente'] = $data['NomeDoCliente'] = $this->input->post('NomeDoCliente');
		$_SESSION['telefone'] = $data['TelefoneDoCliente'] = $this->input->post('TelefoneDoCliente');
		/*	
			echo "<pre>";
			print_r($_SESSION['pesquisa']);
			echo "<br>";
			print_r($_SESSION['nomedocliente']);
			echo "<br>";
			echo "</pre>";
			exit();
		*/
		
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        #run form validation
        //if ($this->form_validation->run() !== FALSE && $this->Cliente_model->lista_cliente($data['Pesquisa'], $data['NomeDoCliente'], $data['TelefoneDoCliente'],  FALSE) === TRUE) {

		$uri = (!$this->input->post('Pesquisa')) ? 4 : 4;

        //if ($this->uri->segment($uri)) {
			$config['base_url'] = base_url() . 'cliente/pesquisar/' . $data['Pesquisa'] . '/';
			//$config['base_url'] = base_url() . 'cliente/pesquisar/';
			//$config['total_rows'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], $data['NomeDoCliente'], $data['TelefoneDoCliente'], TRUE)->num_rows();
			$config['total_rows'] = $this->Cliente_model->lista_cliente($_SESSION['pesquisa'], $_SESSION['nomedocliente'], $_SESSION['telefone'], TRUE)->num_rows();
			($config['total_rows'] > 1) ? $data['total'] = $config['total_rows']: $config['total_rows'];
			$qtde = $config['per_page'];
			
			
			//$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"])) : 0;
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
			
			$this->pagination->initialize($config);
		
            //$data['query'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], TRUE);
			//$data['query'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], $data['NomeDoCliente'], $data['TelefoneDoCliente'], TRUE, $qtde, $page);
			$data['query'] = $this->Cliente_model->lista_cliente($_SESSION['pesquisa'], $_SESSION['nomedocliente'], $_SESSION['telefone'], TRUE, $qtde, ($page * $config["per_page"]));
			$data['pagination'] = $this->pagination->create_links();
			/*
			echo "<pre>";
			print_r($config['base_url']);
			echo "<br>";
			print_r($config['total_rows']);
			echo "<br>";
			print_r($qtde);
			echo "<br>";
			print_r($page);
			echo "<br>";
			echo "</pre>";
			exit();
			*/
			/*
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
			*/
			$data['list'] = $this->load->view('cliente/list_cliente', $data, TRUE);
			
        //}

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('cliente/pesq_cliente', $data);

        $this->load->view('basico/footer');
    }
	
    public function pesquisar1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'trim|callback_get_cliente');
		$this->form_validation->set_rules('NomeDoCliente', 'Nome do Cliente', 'trim');
		$this->form_validation->set_rules('TelefoneDoCliente', 'Telefone do Cliente', 'trim');

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);
        }

        $data['titulo'] = "Pesquisar Cliente";
		
		$this->load->library('pagination');
		$_SESSION['Qtde'] = $config['per_page'] = 5;
		$_SESSION['Page'] = $config["uri_segment"] = 4;
		
        $_SESSION['pesquisa'] = $data['Pesquisa'] = $this->input->post('Pesquisa');
		$_SESSION['nomedocliente'] = $data['NomeDoCliente'] = $this->input->post('NomeDoCliente');
		$_SESSION['telefone'] = $data['TelefoneDoCliente'] = $this->input->post('TelefoneDoCliente');
		/*	
			echo "<pre>";
			print_r($_SESSION['pesquisa']);
			echo "<br>";
			print_r($_SESSION['nomedocliente']);
			echo "<br>";
			echo "</pre>";
			exit();
		*/
		
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Cliente_model->lista_cliente($data['Pesquisa'], $data['NomeDoCliente'], $data['TelefoneDoCliente'],  FALSE) === TRUE) {

			$config['base_url'] = base_url() . 'cliente/pesquisar/' . $data['Pesquisa'] . '/';
			$config['total_rows'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], $data['NomeDoCliente'], $data['TelefoneDoCliente'], TRUE)->num_rows();
			
			$qtde = $config['per_page'];
			$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"])) : 0;
			
			
			$this->pagination->initialize($config);
		
            //$data['query'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], TRUE);
			$data['query'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], $data['NomeDoCliente'], $data['TelefoneDoCliente'], TRUE, $qtde, $page);
			
			$data['pagination'] = $this->pagination->create_links();
			/*
			echo "<pre>";
			print_r($config['base_url']);
			echo "<br>";
			print_r($config['total_rows']);
			echo "<br>";
			print_r($qtde);
			echo "<br>";
			print_r($page);
			echo "<br>";
			echo "</pre>";
			exit();
			*/
			/*
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
			*/
			$data['list'] = $this->load->view('cliente/list_cliente', $data, TRUE);
			
        }

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('cliente/pesq_cliente', $data);

        $this->load->view('basico/footer');
    }

    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

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

        $this->load->view('basico/footer');		

    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id, TRUE);
        $_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
		
		#$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' . $data['query']['NomeCliente'];
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

        $data['contatocliente'] = $this->Contatocliente_model->lista_contatocliente(TRUE);
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

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        $this->load->view('cliente/tela_cliente', $data);

        $this->load->view('basico/footer');
    }

    public function clientedep($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id, TRUE);
        $_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
		
		#$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' . $data['query']['NomeCliente'];
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

        $data['clientedep'] = $this->Clientedep_model->lista_clientedep(TRUE);
        /*
          echo "<pre>";
          print_r($data['clientedep']);
          echo "</pre>";
          exit();
        */
        if (!$data['clientedep'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('clientedep/list_clientedep', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        $this->load->view('cliente/tela_clientedep', $data);

        $this->load->view('basico/footer');
    }

    public function clientepet($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id, TRUE);
        $_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
		
		#$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' . $data['query']['NomeCliente'];
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

        $data['clientepet'] = $this->Clientepet_model->lista_clientepet(TRUE);
        /*
          echo "<pre>";
          print_r($data['clientepet']);
          echo "</pre>";
          exit();
        */
        if (!$data['clientepet'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('clientepet/list_clientepet', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        $this->load->view('cliente/tela_clientepet', $data);

        $this->load->view('basico/footer');
    }

    function get_cliente_1() {
		
        if ($this->Cliente_model->lista_cliente($_SESSION['pesquisa'], $_SESSION['nomedocliente'], $_SESSION['telefone'], FALSE, $_SESSION['Qtde'], $_SESSION['Page']) === FALSE) {
            $this->form_validation->set_message('get_cliente', '<strong>Cliente</strong> não encontrado.');
            return FALSE;
        } else {
		return TRUE;
        }
    }
	
    function get_cliente($data) {

        if ($this->Cliente_model->lista_cliente($data, TRUE) === FALSE) {
            $this->form_validation->set_message('get_cliente', '<strong>Cliente</strong> não encontrado.');
			return FALSE;
        } else {
			return TRUE;
        }
    }

}
