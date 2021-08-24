<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Empresa_model'));
        #$this->load->model(array('Basico_model', 'Empresa_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

        #$this->load->view('empresa/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('empresa/tela_index', $data);

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
			'idSis_Empresa',
			'UsuarioEmpresa',
            'NomeAdmin',
			#'Senha',
			#'Confirma',
            #'DataNascimento',
            'CelularAdmin',
			'Email',
            #'Sexo',
			'Inativo',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('Email', 'E-mail', 'required|trim|valid_email|is_unique[Sis_Empresa.Email]');
        $this->form_validation->set_rules('UsuarioEmpresa', 'NomeAdmin do Func./ Usuário', 'required|trim|is_unique[Sis_Empresa.UsuarioEmpresa]');
		$this->form_validation->set_rules('NomeAdmin', 'NomeAdmin do Usuário', 'required|trim');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        #$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        //$this->form_validation->set_rules('CelularAdmin', 'Celular', 'required|trim');
		$this->form_validation->set_rules('CelularAdmin', 'Celular do Admin', 'required|trim|is_unique_duplo[Sis_Empresa.CelularAdmin.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');

        #$data['select']['Sexo'] = $this->Basico_model->select_sexo();
		#$data['select']['Empresa'] = $this->Basico_model->select_status_sn();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();


        $data['titulo'] = 'Cadastrar Usuário';
        $data['form_open_path'] = 'empresa/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('empresa/form_empresa', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('empresa/form_empresa', $data);
        } else {


			$data['query']['Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['query']['Senha'] = md5($data['query']['Senha']);
			#$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Codigo'] = md5(uniqid(time() . rand()));
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['query']['Inativo'] = 0;
            unset($data['query']['Confirma']);


            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idSis_Empresa'] = $this->Empresa_model->set_empresa($data['query']);

            if ($data['idSis_Empresa'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('empresa/form_empresa', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'empresa/prontuario/' . $data['idSis_Empresa'] . $data['msg']);
				#redirect(base_url() . 'relatorio/empresa/' .  $data['msg']);
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

        $data['query'] = $this->input->post(array(

			'idSis_Empresa',
			#'UsuarioEmpresa',
            'NomeEmpresa',
			'NomeAdmin',
            'DataNascimento',
            #'CelularAdmin',
            'Email',
			'Cnpj',
			'InscEstadual',
			'EnderecoEmpresa',
			'NumeroEmpresa',
			'ComplementoEmpresa',
			'BairroEmpresa',
			'MunicipioEmpresa',
			'EstadoEmpresa',
			'CepEmpresa',
			'Telefone',
			'Atuacao',
			#'Sexo',
			#'Inativo',
			'CategoriaEmpresa',
			#'Site',
            #'Senha',
			'EComerce',
			'RetirarLoja',
			'MotoBoy',
			'Correios',
			'NaLoja',
			'NaEntrega',
			'OnLine',
			'Boleto',
			'Debito',
			'Cartao',
			'Atendimento',
			'SobreNos',
			'ValorMinimo',
			'TaxaEntrega',
			'CadastrarPet',
			'CadastrarDep',
			'TipoBoleto',
			'BancoEmpresa',
			'AgenciaEmpresa',
			'ContaEmpresa',
			'PixEmpresa',
			'AssociadoAtivo',
			'CashBackAtivo',
			'PrazoCashBackEmpresa',
        ), TRUE);
				

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
			//$data['query'] = $this->Empresa_model->get_empresa($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
        }

        $data['select']['MunicipioEmpresa'] = $this->Basico_model->select_municipio();
		$data['select']['CategoriaEmpresa'] = $this->Basico_model->select_categoriaempresa();
		$data['select']['EComerce'] = $this->Basico_model->select_status_sn();
		$data['select']['RetirarLoja'] = $this->Basico_model->select_status_sn();
		$data['select']['MotoBoy'] = $this->Basico_model->select_status_sn();
		$data['select']['Correios'] = $this->Basico_model->select_status_sn();
		$data['select']['CadastrarPet'] = $this->Basico_model->select_status_sn();
		$data['select']['CadastrarDep'] = $this->Basico_model->select_status_sn();
		$data['select']['TipoBoleto'] = array(
			'L' => 'Da Loja',
			'P' => 'Pag Seguro',
        );
		$data['select']['NaLoja'] = $this->Basico_model->select_status_sn();
		$data['select']['NaEntrega'] = $this->Basico_model->select_status_sn();
		$data['select']['OnLine'] = $this->Basico_model->select_status_sn();
		
		$data['select']['Boleto'] = $this->Basico_model->select_status_sn();
		$data['select']['Debito'] = $this->Basico_model->select_status_sn();
		$data['select']['Cartao'] = $this->Basico_model->select_status_sn();
		
		$data['select']['CashBackAtivo'] = $this->Basico_model->select_status_sn();
		$data['select']['AssociadoAtivo'] = $this->Basico_model->select_status_sn();
        #$data['select']['Sexo'] = $this->Basico_model->select_sexo();
		#$data['select']['Empresa'] = $this->Basico_model->select_status_sn();
		#$data['select']['Inativo'] = $this->Basico_model->select_inativo();

        $data['titulo'] = 'Editar Empresa';
        $data['form_open_path'] = 'empresa/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        if ($data['query']['EnderecoEmpresa'] || $data['query']['BairroEmpresa'] ||
			$data['query']['MunicipioEmpresa'] || $data['query']['CepEmpresa'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

		(!$data['query']['CadastrarPet']) ? $data['query']['CadastrarPet'] = 'N' : FALSE;
        $data['radio'] = array(
            'CadastrarPet' => $this->basico->radio_checked($data['query']['CadastrarPet'], 'E-Comerce', 'NS'),
        );
        ($data['query']['CadastrarPet'] == 'N') ?
            $data['div']['CadastrarPet'] = '' : $data['div']['CadastrarPet'] = 'style="display: none;"';

		(!$data['query']['CadastrarDep']) ? $data['query']['CadastrarDep'] = 'N' : FALSE;
        $data['radio'] = array(
            'CadastrarDep' => $this->basico->radio_checked($data['query']['CadastrarDep'], 'E-Comerce', 'NS'),
        );
        ($data['query']['CadastrarDep'] == 'N') ?
            $data['div']['CadastrarDep'] = '' : $data['div']['CadastrarDep'] = 'style="display: none;"';
			
		(!$data['query']['EComerce']) ? $data['query']['EComerce'] = 'S' : FALSE;
        $data['radio'] = array(
            'EComerce' => $this->basico->radio_checked($data['query']['EComerce'], 'E-Comerce', 'NS'),
        );
        ($data['query']['EComerce'] == 'S') ?
            $data['div']['EComerce'] = '' : $data['div']['EComerce'] = 'style="display: none;"';
			
		(!$data['query']['OnLine']) ? $data['query']['OnLine'] = 'S' : FALSE;
        $data['radio'] = array(
            'OnLine' => $this->basico->radio_checked($data['query']['OnLine'], 'OnLine', 'NS'),
        );
        ($data['query']['OnLine'] == 'S') ?
            $data['div']['OnLine'] = '' : $data['div']['OnLine'] = 'style="display: none;"';			
		
		(!$data['query']['Boleto']) ? $data['query']['Boleto'] = 'S' : FALSE;
        $data['radio'] = array(
            'Boleto' => $this->basico->radio_checked($data['query']['Boleto'], 'Boleto', 'NS'),
        );
        ($data['query']['Boleto'] == 'S') ?
            $data['div']['Boleto'] = '' : $data['div']['Boleto'] = 'style="display: none;"';		
		
			
		(!$data['query']['AssociadoAtivo']) ? $data['query']['AssociadoAtivo'] = 'N' : FALSE;
        $data['radio'] = array(
            'AssociadoAtivo' => $this->basico->radio_checked($data['query']['AssociadoAtivo'], 'E-Comerce', 'NS'),
        );
        ($data['query']['AssociadoAtivo'] == 'S') ?
            $data['div']['AssociadoAtivo'] = '' : $data['div']['AssociadoAtivo'] = 'style="display: none;"';
			
			
		(!$data['query']['CashBackAtivo']) ? $data['query']['CashBackAtivo'] = 'N' : FALSE;
        $data['radio'] = array(
            'CashBackAtivo' => $this->basico->radio_checked($data['query']['CashBackAtivo'], 'E-Comerce', 'NS'),
        );
        ($data['query']['CashBackAtivo'] == 'S') ?
            $data['div']['CashBackAtivo'] = '' : $data['div']['CashBackAtivo'] = 'style="display: none;"';
			
		
        $data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeAdmin', 'NomeAdmin do Responsável', 'required|trim|is_unique_duplo[Sis_Empresa.NomeAdmin.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('NomeEmpresa', 'Nome da Empresa', 'required|trim');
		$this->form_validation->set_rules('NomeAdmin', 'NomeAdmin do Responsável', 'required|trim');
        #$this->form_validation->set_rules('Site', 'Site', 'trim|is_unique[Sis_Empresa.Site]');
		$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        #$this->form_validation->set_rules('CelularAdmin', 'Celular', 'required|trim');
        //$this->form_validation->set_rules('CelularAdmin', 'Celular do Admin', 'required|trim|is_unique_by_id_empresa[Sis_Empresa.CelularAdmin.' . $data['query']['idSis_Empresa'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
        #$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        #$this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');		
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('empresa/form_empresa', $data);
        } else {

			if($data['query']['CadastrarPet'] == 'S'){
				$data['query']['CadastrarDep'] = 'N';
			}
			$data['query']['NomeEmpresa'] = trim(mb_strtoupper($data['query']['NomeEmpresa'], 'ISO-8859-1'));
            $data['query']['NomeAdmin'] = trim(mb_strtoupper($data['query']['NomeAdmin'], 'ISO-8859-1'));
            #$data['query']['Senha'] = md5($data['query']['Senha']);            
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['ValorMinimo'] = str_replace(',', '.', str_replace('.', '', $data['query']['ValorMinimo']));
			$data['query']['TaxaEntrega'] = str_replace(',', '.', str_replace('.', '', $data['query']['TaxaEntrega']));
            #$data['query']['Obs'] = nl2br($data['query']['Obs']);
            #$data['query']['Empresa'] = $_SESSION['log']['idSis_Empresa'];

            $data['anterior'] = $this->Empresa_model->get_empresa($data['query']['idSis_Empresa']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

            if ($data['auditoriaitem'] && $this->Empresa_model->update_empresa($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'empresa/form_empresa/' . $data['query']['idSis_Empresa'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'empresa/prontuario/' . $data['query']['idSis_Empresa'] . $data['msg']);
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
			'idSis_Empresa',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {

			$data['file']['Arquivo'] = $this->basico->renomeiaempresa($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_logo', $data);
        }
        else {

			$tiposPermitidos	= ['jpg','jpeg','pjpeg','png','x-png'];
			$tamanho			= $_FILES['Arquivo']['size'];
			$extensao			= explode('.', $data['file']['Arquivo']);
			$extensao			= end($extensao);
			
			if (!in_array($extensao, $tiposPermitidos)) {
				$data['msg'] = $this->basico->msg('<strong>O Tipo de Arquivo não é Permitido.</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_logo', $data);
				
			} elseif(!($tamanho > 1000)){
				$data['msg'] = $this->basico->msg('<strong>O Tamanho do Arquivo ultrapassa o máximo Permitido</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_logo', $data);
			}
			
			else {
				
				$diretorio = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/';
				$altura = "200";
				$largura = "200";

				switch($_FILES['Arquivo']['type']):
					case 'image/jpg';
					case 'image/jpeg';
					case 'image/pjpeg';
						$imagem_temporaria = imagecreatefromjpeg($_FILES['Arquivo']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						
						$altura_original = imagesy($imagem_temporaria);
						
						//echo "largura original: $largura_original - Altura original: $altura_original <br>";
						
						$nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
						
						$nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
						
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						imagejpeg($imagem_redimensionada, $diretorio . $data['file']['Arquivo']);

					break;

					//Caso a imagem seja extensão PNG cai nesse CASE
					case 'image/png':
					case 'image/x-png';
						$imagem_temporaria = imagecreatefrompng($_FILES['Arquivo']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						$altura_original = imagesy($imagem_temporaria);

						
						/* Configura a nova largura */
						$nova_largura = $largura ? $largura : floor(( $largura_original / $altura_original ) * $altura);

						/* Configura a nova altura */
						$nova_altura = $altura ? $altura : floor(( $altura_original / $largura_original ) * $largura);
						
						/* Retorna a nova imagem criada */
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						
						/* Copia a nova imagem da imagem antiga com o tamanho correto */
						//imagealphablending($imagem_redimensionada, false);
						//imagesavealpha($imagem_redimensionada, true);

						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						//função imagejpeg que envia para o browser a imagem armazenada no parâmetro passado
						imagepng($imagem_redimensionada, $diretorio . $data['file']['Arquivo']);
						
					break;					
					
				endswitch;

				//if (!$this->upload->do_upload('Arquivo')) {
				
				
					$data['camposfile'] = array_keys($data['file']);
					$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

					if ($data['idSis_Arquivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
						$this->basico->erro($msg);
						$this->load->view('empresa/form_logo', $data);
					}
					else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
						
						$data['query']['Arquivo'] = $data['file']['Arquivo'];
						$data['anterior'] = $this->Empresa_model->get_empresa($data['query']['idSis_Empresa']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

						if ($data['auditoriaitem'] && $this->Empresa_model->update_empresa($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'empresa/form_logo/' . $data['query']['idSis_Empresa'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'empresa/prontuario/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						}				
					}
				
			}
		}

        $this->load->view('basico/footer');
    }

    public function alterarlogoBKP($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = $this->input->post(array(
			'idSis_Empresa',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			//$data['file']['Arquivo'] = $this->basico->limpa_nome_arquivo($_FILES['Arquivo']['name']);
			$data['file']['Arquivo'] = $this->basico->renomeiaempresa($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_logo', $data);
        }
        else {
			
            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg', 'jpeg', 'gif', 'png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
			
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('empresa/form_logo', $data);
            }
            else {

                $data['camposfile'] = array_keys($data['file']);
				$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('empresa/form_logo', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Empresa_model->get_empresa($data['query']['idSis_Empresa']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

					if ($data['auditoriaitem'] && $this->Empresa_model->update_empresa($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'empresa/form_logo/' . $data['query']['idSis_Empresa'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'empresa/prontuario/' . $data['file']['idSis_Empresa'] . $data['msg']);
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
			'idSis_Empresa',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeiaempresa($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_logo', $data);
        }
        else {
            
			$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
			
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('empresa/form_logo', $data);
            }
            else {

				//$diretorio = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';
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

						$thumb = imagecreatetruecolor(200, 200);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 200, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;					

					case 'image/png':
					case 'image/x-png';
						
						list($largura, $altura, $tipo) = getimagesize($diretorio);
						
						$img = imagecreatefrompng($diretorio);

						$thumb = imagecreatetruecolor(200, 200);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 200, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;
					
				endswitch;                
				
				$data['camposfile'] = array_keys($data['file']);
				$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('empresa/form_logo', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Empresa_model->get_empresa($data['query']['idSis_Empresa']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

					if ($data['auditoriaitem'] && $this->Empresa_model->update_empresa($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'empresa/form_logo/' . $data['query']['idSis_Empresa'] . $data['msg']);
						exit();
					} else {

						if(null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Empresa']['Arquivo'] . '')){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Empresa']['Arquivo'] . '');						
						}
						if(null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . '')){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . '');						
						}					
					
						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'empresa/prontuario/' . $data['file']['idSis_Empresa'] . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar_pagina($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo4',
			'Arquivo3',			
			'Arquivo2',
			'Arquivo1',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
			$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        if (isset($_FILES['Arquivo4']) && $_FILES['Arquivo4']['name']) {
            
			$data['file']['Arquivo4'] = $this->basico->renomeia_imagem_4($_FILES['Arquivo4']['name']);
			$this->form_validation->set_rules($data['file']['Arquivo4'], 'Tipo de Arquivo não é permitido', 'trim|valid_extensao');
        }
        else {
            $this->form_validation->set_rules('Arquivo4', 'Arquivo 4', 'required');
        }
		
        if (isset($_FILES['Arquivo3']) && $_FILES['Arquivo3']['name']) {
            
			$data['file']['Arquivo3'] = $this->basico->renomeia_imagem_3($_FILES['Arquivo3']['name']);
			$this->form_validation->set_rules($data['file']['Arquivo3'], 'Tipo de Arquivo não é permitido', 'trim|valid_extensao');
        }
        else {
            $this->form_validation->set_rules('Arquivo3', 'Arquivo 3', 'required');
        }		
		
        if (isset($_FILES['Arquivo2']) && $_FILES['Arquivo2']['name']) {
            
			$data['file']['Arquivo2'] = $this->basico->renomeia_imagem_2($_FILES['Arquivo2']['name']);
			$this->form_validation->set_rules($data['file']['Arquivo2'], 'Tipo de Arquivo não é permitido', 'trim|valid_extensao');
        }
        else {
            $this->form_validation->set_rules('Arquivo2', 'Arquivo 2', 'required');
        }
		
        if (isset($_FILES['Arquivo1']) && $_FILES['Arquivo1']['name']) {
            
			$data['file']['Arquivo1'] = $this->basico->renomeia_imagem_1($_FILES['Arquivo1']['name']);
			$this->form_validation->set_rules($data['file']['Arquivo1'], 'Tipo de Arquivo não é permitido', 'trim|valid_extensao');
        }
        else {
            $this->form_validation->set_rules('Arquivo1', 'Arquivo1', 'required');
        }		

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterar_pagina';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_pagina', $data);
        }
        else {

			/*
			$arquivo4 = isset($_FILES['Arquivo4']) ? $_FILES['Arquivo4'] : FALSE;	
			$destino4 = $diretorio."/".$data['file']['Arquivo4'];
			$mover_logo = move_uploaded_file($arquivo4['tmp_name'], $destino4);
			
			$arquivo3 = isset($_FILES['Arquivo3']) ? $_FILES['Arquivo3'] : FALSE;	
			$destino3 = $diretorio."/".$data['file']['Arquivo3'];
			$mover_logo = move_uploaded_file($arquivo3['tmp_name'], $destino3);
			
			$arquivo2 = isset($_FILES['Arquivo2']) ? $_FILES['Arquivo2'] : FALSE;	
			$destino2 = $diretorio."/".$data['file']['Arquivo2'];
			$mover_logo = move_uploaded_file($arquivo2['tmp_name'], $destino2);

			
			$arquivo1 = isset($_FILES['Arquivo1']) ? $_FILES['Arquivo1'] : FALSE;		
			$destino1 = $diretorio."/".$data['file']['Arquivo1'];
			$mover_arquivo_1 = move_uploaded_file($arquivo1['tmp_name'], $destino1);		
			*/
			$tiposPermitidos	= ['jpg','jpeg','pjpeg','png','x-png'];
			$tamanho			= $_FILES['Arquivo']['size'];
			$extensao			= explode('.', $data['file']['Arquivo']);
			$extensao			= end($extensao);
			
			if (!in_array($extensao, $tiposPermitidos)) {
				$data['msg'] = $this->basico->msg('<strong>O Tipo de Arquivo não é Permitido.</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_logo', $data);
				
			} elseif(!($tamanho > 1000)){
				$data['msg'] = $this->basico->msg('<strong>O Tamanho do Arquivo ultrapassa o máximo Permitido</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_logo', $data);
			}
			
			else {
				
				$diretorio = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/';
				$altura = "200";
				$largura = "200";

				switch($_FILES['Arquivo1']['type']):
					case 'image/jpg';
					case 'image/jpeg';
					case 'image/pjpeg';
						$imagem_temporaria = imagecreatefromjpeg($_FILES['Arquivo1']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						
						$altura_original = imagesy($imagem_temporaria);
						
						//echo "largura original: $largura_original - Altura original: $altura_original <br>";
						
						$nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
						
						$nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
						
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						imagejpeg($imagem_redimensionada, $diretorio . $data['file']['Arquivo1']);

					break;

					//Caso a imagem seja extensão PNG cai nesse CASE
					case 'image/png':
					case 'image/x-png';
						$imagem_temporaria = imagecreatefrompng($_FILES['Arquivo1']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						$altura_original = imagesy($imagem_temporaria);

						
						/* Configura a nova largura */
						$nova_largura = $largura ? $largura : floor(( $largura_original / $altura_original ) * $altura);

						/* Configura a nova altura */
						$nova_altura = $altura ? $altura : floor(( $altura_original / $largura_original ) * $largura);
						
						/* Retorna a nova imagem criada */
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						
						/* Copia a nova imagem da imagem antiga com o tamanho correto */
						//imagealphablending($imagem_redimensionada, false);
						//imagesavealpha($imagem_redimensionada, true);

						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						//função imagejpeg que envia para o browser a imagem armazenada no parâmetro passado
						imagepng($imagem_redimensionada, $diretorio . $data['file']['Arquivo1']);
						
					break;					
					
				endswitch;
				
				switch($_FILES['Arquivo2']['type']):
					case 'image/jpg';
					case 'image/jpeg';
					case 'image/pjpeg';
						$imagem_temporaria = imagecreatefromjpeg($_FILES['Arquivo2']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						
						$altura_original = imagesy($imagem_temporaria);
						
						//echo "largura original: $largura_original - Altura original: $altura_original <br>";
						
						$nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
						
						$nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
						
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						imagejpeg($imagem_redimensionada, $diretorio . $data['file']['Arquivo2']);

					break;

					//Caso a imagem seja extensão PNG cai nesse CASE
					case 'image/png':
					case 'image/x-png';
						$imagem_temporaria = imagecreatefrompng($_FILES['Arquivo2']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						$altura_original = imagesy($imagem_temporaria);

						
						/* Configura a nova largura */
						$nova_largura = $largura ? $largura : floor(( $largura_original / $altura_original ) * $altura);

						/* Configura a nova altura */
						$nova_altura = $altura ? $altura : floor(( $altura_original / $largura_original ) * $largura);
						
						/* Retorna a nova imagem criada */
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						
						/* Copia a nova imagem da imagem antiga com o tamanho correto */
						//imagealphablending($imagem_redimensionada, false);
						//imagesavealpha($imagem_redimensionada, true);

						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						//função imagejpeg que envia para o browser a imagem armazenada no parâmetro passado
						imagepng($imagem_redimensionada, $diretorio . $data['file']['Arquivo2']);
						
					break;					
					
				endswitch;
				
				switch($_FILES['Arquivo3']['type']):
					case 'image/jpg';
					case 'image/jpeg';
					case 'image/pjpeg';
						$imagem_temporaria = imagecreatefromjpeg($_FILES['Arquivo3']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						
						$altura_original = imagesy($imagem_temporaria);
						
						//echo "largura original: $largura_original - Altura original: $altura_original <br>";
						
						$nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
						
						$nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
						
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						imagejpeg($imagem_redimensionada, $diretorio . $data['file']['Arquivo3']);

					break;

					//Caso a imagem seja extensão PNG cai nesse CASE
					case 'image/png':
					case 'image/x-png';
						$imagem_temporaria = imagecreatefrompng($_FILES['Arquivo3']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						$altura_original = imagesy($imagem_temporaria);

						
						/* Configura a nova largura */
						$nova_largura = $largura ? $largura : floor(( $largura_original / $altura_original ) * $altura);

						/* Configura a nova altura */
						$nova_altura = $altura ? $altura : floor(( $altura_original / $largura_original ) * $largura);
						
						/* Retorna a nova imagem criada */
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						
						/* Copia a nova imagem da imagem antiga com o tamanho correto */
						//imagealphablending($imagem_redimensionada, false);
						//imagesavealpha($imagem_redimensionada, true);

						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						//função imagejpeg que envia para o browser a imagem armazenada no parâmetro passado
						imagepng($imagem_redimensionada, $diretorio . $data['file']['Arquivo3']);
						
					break;					
					
				endswitch;
				
				switch($_FILES['Arquivo4']['type']):
					case 'image/jpg';
					case 'image/jpeg';
					case 'image/pjpeg';
						$imagem_temporaria = imagecreatefromjpeg($_FILES['Arquivo4']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						
						$altura_original = imagesy($imagem_temporaria);
						
						//echo "largura original: $largura_original - Altura original: $altura_original <br>";
						
						$nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
						
						$nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
						
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						imagejpeg($imagem_redimensionada, $diretorio . $data['file']['Arquivo4']);

					break;

					//Caso a imagem seja extensão PNG cai nesse CASE
					case 'image/png':
					case 'image/x-png';
						$imagem_temporaria = imagecreatefrompng($_FILES['Arquivo4']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						$altura_original = imagesy($imagem_temporaria);

						
						/* Configura a nova largura */
						$nova_largura = $largura ? $largura : floor(( $largura_original / $altura_original ) * $altura);

						/* Configura a nova altura */
						$nova_altura = $altura ? $altura : floor(( $altura_original / $largura_original ) * $largura);
						
						/* Retorna a nova imagem criada */
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						
						/* Copia a nova imagem da imagem antiga com o tamanho correto */
						//imagealphablending($imagem_redimensionada, false);
						//imagesavealpha($imagem_redimensionada, true);

						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						//função imagejpeg que envia para o browser a imagem armazenada no parâmetro passado
						imagepng($imagem_redimensionada, $diretorio . $data['file']['Arquivo4']);
						
					break;					
					
				endswitch;				
			


				$data['camposfile'] = array_keys($data['file']);
				$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);
				
				if ($data['idSis_Arquivo'] === FALSE) {
					$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
					$this->basico->erro($msg);
					$this->load->view('empresa/form_pagina', $data);
				}
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo4'] = $data['file']['Arquivo4'];
					$data['query']['Arquivo3'] = $data['file']['Arquivo3'];
					$data['query']['Arquivo2'] = $data['file']['Arquivo2'];
					$data['query']['Arquivo1'] = $data['file']['Arquivo1'];
					$data['anterior'] = $this->Empresa_model->get_pagina($data['query']['idSis_Empresa']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

					if ($data['auditoriaitem'] && $this->Empresa_model->update_pagina($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'empresa/pagina/' . $data['query']['idSis_Empresa'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'empresa/pagina/' . $data['file']['idSis_Empresa'] . $data['msg']);
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

        //$this->Empresa_model->delete_empresa($id);
        $this->Empresa_model->delete_empresa_toda($id);

        $data['msg'] = '?m=1';

		//redirect(base_url() . 'agenda' . $data['msg']);
		redirect(base_url() . 'relatorio/empresas/' .  $data['msg']);
		exit();

        $this->load->view('basico/footer');
    }

    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_empresa');

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);
        }

        $data['titulo'] = "Pesquisar Empresa";

        $data['Pesquisa'] = $this->input->post('Pesquisa');
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Empresa_model->lista_empresa($data['Pesquisa'], FALSE) === TRUE) {

            $data['query'] = $this->Empresa_model->lista_empresa($data['Pesquisa'], TRUE);

            if ($data['query']->num_rows() == 1) {
                $info = $data['query']->result_array();

                if ($_SESSION['agenda'])
                    redirect('consulta/cadastrar/' . $info[0]['idSis_Empresa'] );
                else
                    redirect('empresa/prontuario/' . $info[0]['idSis_Empresa'] );

                exit();
            } else {
                $data['list'] = $this->load->view('empresa/list_empresa', $data, TRUE);
            }

        }

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('empresa/pesq_empresa', $data);

        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' ;
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

        $_SESSION['log']['idSis_Empresa'] = $data['resumo']['idSis_Empresa'] = $data['query']['idSis_Empresa'];
        $data['resumo']['NomeAdmin'] = $data['query']['NomeAdmin'];

        $data['query']['Idade'] = $this->basico->calcula_idade($data['query']['DataCriacao']);
        $data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'barras');

        /*
        if ($data['query']['Sexo'] == 1)
            $data['query']['profile'] = 'm';
        elseif ($data['query']['Sexo'] == 2)
            $data['query']['profile'] = 'f';
        else
            $data['query']['profile'] = 'o';
        */
        #$data['query']['profile'] = ($data['query']['Sexo']) ? strtolower($data['query']['Sexo']) : 'o';

        #$data['query']['Sexo'] = $this->Basico_model->get_sexo($data['query']['Sexo']);
		$data['query']['Inativo'] = $this->Basico_model->get_inativo($data['query']['Inativo']);
		$data['query']['Empresa'] = $this->Basico_model->get_empresa($data['query']['NomeEmpresa']);
		$data['query']['CategoriaEmpresa'] = $this->Basico_model->get_categoriaempresa($data['query']['CategoriaEmpresa']);
		#$data['query']['Empresa'] = $data['query']['Empresa'];

        $data['query']['Telefone'] = $data['query']['CelularAdmin'];

        $data['contatoempresa'] = $this->Empresa_model->lista_contatoempresa($id, TRUE);
        /*
          echo "<pre>";
          print_r($data['contatoempresa']);
          echo "</pre>";
          exit();
          */
        if (!$data['contatoempresa'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('empresa/list_contatoempresa', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);
        $this->load->view('empresa/tela_empresa', $data);

        $this->load->view('basico/footer');
    }

    public function pagina($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($id, TRUE);
		$_SESSION['Produtos'] = $data['produtos'] = $this->Empresa_model->get_produtos($id, TRUE);
		$_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);

		$data['titulo'] = 'Prontuário ' ;
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

		$data['prod'] = $this->Empresa_model->list1_produtos(TRUE);
		$data['slides'] = $this->Empresa_model->list2_slides(TRUE);
		$data['doc'] = $this->Empresa_model->list3_documentos(TRUE);
		
		$data['list1'] = $this->load->view('empresa/list1_produtos', $data, TRUE);
		$data['list2'] = $this->load->view('empresa/list2_slides', $data, TRUE);		
		$data['list3'] = $this->load->view('empresa/list3_logo_nav', $data, TRUE);
		$data['list4'] = $this->load->view('empresa/list4_icone', $data, TRUE);		
		
        $_SESSION['log']['idSis_Empresa'] = $data['resumo']['idSis_Empresa'] = $data['documentos']['idSis_Empresa'] = $data['query']['idSis_Empresa'];

        #$data['query']['Sexo'] = $this->Basico_model->get_sexo($data['query']['Sexo']);
		#$data['documentos']['Arquivo1'] = $this->Empresa_model->get_pagina($data['documentos']['Arquivo1']);
		#$data['documentos']['Arquivo2'] = $this->Empresa_model->get_pagina($data['documentos']['Arquivo2']);
		$data['query']['Empresa'] = $this->Basico_model->get_empresa($data['query']['NomeEmpresa']);
		$data['query']['CategoriaEmpresa'] = $this->Basico_model->get_categoriaempresa($data['query']['CategoriaEmpresa']);
		#$data['query']['Empresa'] = $data['query']['Empresa'];


        /*
          echo "<pre>";
          print_r($data['contatoempresa']);
          echo "</pre>";
          exit();
          */

        $this->load->view('empresa/tela_pagina', $data);

        $this->load->view('basico/footer');
    }

    public function alterar_imagem_1($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'Texto_Arquivo1',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo1',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
			$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('Texto_Arquivo1', 'Texto 1', 'required');
		
        if (isset($_FILES['Arquivo1']) && $_FILES['Arquivo1']['name']) {
            
			$data['file']['Arquivo1'] = $this->basico->renomeia_imagem_1($_FILES['Arquivo1']['name']);
            $this->form_validation->set_rules('Arquivo1', 'Arquivo1', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo1', 'Arquivo1', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterar_imagem_1';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		#run form validation
		if ($this->form_validation->run() === FALSE) {
			#load login view
			$this->load->view('empresa/form_imagem_1', $data);
		}
	
		else {
			
			$tiposPermitidos	= ['jpg','jpeg','pjpeg'];
			$tamanho			= $_FILES['Arquivo1']['size'];
			$extensao			= explode('.', $data['file']['Arquivo1']);
			$extensao			= end($extensao);
			
			if (!in_array($extensao, $tiposPermitidos)) {
				$data['msg'] = $this->basico->msg('<strong>O Tipo de Arquivo não é Permitido.</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_imagem_1', $data);
				
			} elseif(!($tamanho > 1000)){
				$data['msg'] = $this->basico->msg('<strong>O Tamanho do Arquivo ultrapassa o máximo Permitido</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_imagem_1', $data);
			}
			else {
					$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
					//$foto = $_FILES['Arquivo1']['name'];		
					$foto = $data['file']['Arquivo1'];
					$diretorio = $dir.$foto;

				if (!move_uploaded_file($_FILES['Arquivo1']['tmp_name'], $diretorio)) {
					$data['msg'] = $this->basico->msg('<strong>Arquivo não pode ser enviado</strong>', 'erro', TRUE, TRUE, TRUE);
					$this->load->view('empresa/form_imagem_1', $data);
					
				} 
				else {					
					
					$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';

					switch($_FILES['Arquivo1']['type']):
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

						case 'image/png':
						case 'image/x-png';
							
							list($largura, $altura, $tipo) = getimagesize($diretorio);
							
							$img = imagecreatefrompng($diretorio);

							$thumb = imagecreatetruecolor(200, 200);
							
							imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 200, $largura, $altura);
							
							imagejpeg($thumb, $dir2 . $foto);
							imagedestroy($img);
							imagedestroy($thumb);				      
						
						break;
						
					endswitch;					
					
					
					$data['camposfile'] = array_keys($data['file']);
					$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

					if ($data['idSis_Arquivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
						$this->basico->erro($msg);
						$this->load->view('empresa/form_imagem_1', $data);
					}
					else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
						
						$data['query']['Arquivo1'] = $data['file']['Arquivo1'];
						$data['anterior'] = $this->Empresa_model->get_pagina($data['query']['idSis_Empresa']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

						if ($data['auditoriaitem'] && $this->Empresa_model->update_pagina($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'empresa/form_imagem_1/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						} else {
						
							if(null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Arquivo1'] . '')){
									unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Arquivo1'] . '');						
							}
							if(null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo1'] . '')){
									unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo1'] . '');						
							}							
							
							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'empresa/pagina/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						}
					}
				}	
			}
			
		}
			
        $this->load->view('basico/footer');
    }

    public function alterar_imagem_2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'Texto_Arquivo2',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo2',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
			$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('Texto_Arquivo2', 'Texto 2', 'required');
		
        if (isset($_FILES['Arquivo2']) && $_FILES['Arquivo2']['name']) {
            
			$data['file']['Arquivo2'] = $this->basico->renomeia_imagem_2($_FILES['Arquivo2']['name']);
            $this->form_validation->set_rules('Arquivo2', 'Arquivo2', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo2', 'Arquivo2', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterar_imagem_2';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_imagem_2', $data);
        }
        else {
			
			$tiposPermitidos	= ['jpg','jpeg','pjpeg'];
			$tamanho			= $_FILES['Arquivo2']['size'];
			$extensao			= explode('.', $data['file']['Arquivo2']);
			$extensao			= end($extensao);
			
			if (!in_array($extensao, $tiposPermitidos)) {
				$data['msg'] = $this->basico->msg('<strong>O Tipo de Arquivo não é Permitido.</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_imagem_2', $data);
				
			} elseif(!($tamanho > 1000)){
				$data['msg'] = $this->basico->msg('<strong>O Tamanho do Arquivo ultrapassa o máximo Permitido</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_imagem_2', $data);
			}
            else {
					$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
					//$foto = $_FILES['Arquivo2']['name'];		
					$foto = $data['file']['Arquivo2'];
					$diretorio = $dir.$foto;

				if (!move_uploaded_file($_FILES['Arquivo2']['tmp_name'], $diretorio)) {
					$data['msg'] = $this->basico->msg('<strong>Arquivo não pode ser enviado</strong>', 'erro', TRUE, TRUE, TRUE);
					$this->load->view('empresa/form_imagem_2', $data);
					
				} 
				else {					
					
					$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';

					switch($_FILES['Arquivo2']['type']):
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

						case 'image/png':
						case 'image/x-png';
							
							list($largura, $altura, $tipo) = getimagesize($diretorio);
							
							$img = imagecreatefrompng($diretorio);

							$thumb = imagecreatetruecolor(200, 200);
							
							imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 200, $largura, $altura);
							
							imagejpeg($thumb, $dir2 . $foto);
							imagedestroy($img);
							imagedestroy($thumb);				      
						
						break;
						
					endswitch;					
					
					
					$data['camposfile'] = array_keys($data['file']);
					$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

					if ($data['idSis_Arquivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
						$this->basico->erro($msg);
						$this->load->view('empresa/form_imagem_2', $data);
					}
					else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
						
						$data['query']['Arquivo2'] = $data['file']['Arquivo2'];
						$data['anterior'] = $this->Empresa_model->get_pagina($data['query']['idSis_Empresa']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

						if ($data['auditoriaitem'] && $this->Empresa_model->update_pagina($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'empresa/form_imagem_2/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						} else {
						
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo2'] . '');
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Arquivo2'] . '');							

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'empresa/pagina/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						}				
					}
				}	
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar_imagem_3($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'Texto_Arquivo3',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo3',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
			$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('Texto_Arquivo3', 'Texto 1', 'required');
		
        if (isset($_FILES['Arquivo3']) && $_FILES['Arquivo3']['name']) {
            
			$data['file']['Arquivo3'] = $this->basico->renomeia_imagem_3($_FILES['Arquivo3']['name']);
            $this->form_validation->set_rules('Arquivo3', 'Arquivo3', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo3', 'Arquivo3', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterar_imagem_3';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_imagem_3', $data);
        }
        else {
			
			$tiposPermitidos	= ['jpg','jpeg','pjpeg'];
			$tamanho			= $_FILES['Arquivo3']['size'];
			$extensao			= explode('.', $data['file']['Arquivo3']);
			$extensao			= end($extensao);
			
			if (!in_array($extensao, $tiposPermitidos)) {
				$data['msg'] = $this->basico->msg('<strong>O Tipo de Arquivo não é Permitido.</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_imagem_3', $data);
				
			} elseif(!($tamanho > 1000)){
				$data['msg'] = $this->basico->msg('<strong>O Tamanho do Arquivo ultrapassa o máximo Permitido</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_imagem_3', $data);
			}
            else {
					$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
					//$foto = $_FILES['Arquivo3']['name'];		
					$foto = $data['file']['Arquivo3'];
					$diretorio = $dir.$foto;

				if (!move_uploaded_file($_FILES['Arquivo3']['tmp_name'], $diretorio)) {
					$data['msg'] = $this->basico->msg('<strong>Arquivo não pode ser enviado</strong>', 'erro', TRUE, TRUE, TRUE);
					$this->load->view('empresa/form_imagem_3', $data);
					
				} 
				else {					
					
					$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';

					switch($_FILES['Arquivo3']['type']):
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

						case 'image/png':
						case 'image/x-png';
							
							list($largura, $altura, $tipo) = getimagesize($diretorio);
							
							$img = imagecreatefrompng($diretorio);

							$thumb = imagecreatetruecolor(200, 200);
							
							imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 200, $largura, $altura);
							
							imagejpeg($thumb, $dir2 . $foto);
							imagedestroy($img);
							imagedestroy($thumb);				      
						
						break;
						
					endswitch;					
					
					
					$data['camposfile'] = array_keys($data['file']);
					$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

					if ($data['idSis_Arquivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
						$this->basico->erro($msg);
						$this->load->view('empresa/form_imagem_3', $data);
					}
					else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
						
						$data['query']['Arquivo3'] = $data['file']['Arquivo3'];
						$data['anterior'] = $this->Empresa_model->get_pagina($data['query']['idSis_Empresa']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

						if ($data['auditoriaitem'] && $this->Empresa_model->update_pagina($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'empresa/form_imagem_3/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						} else {
						
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo3'] . '');
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Arquivo3'] . '');							

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'empresa/pagina/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						}				
					}
				}	
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar_imagem_4($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'Texto_Arquivo4',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo4',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
			$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('Texto_Arquivo4', 'Texto 1', 'required');
		
        if (isset($_FILES['Arquivo4']) && $_FILES['Arquivo4']['name']) {
            
			$data['file']['Arquivo4'] = $this->basico->renomeia_imagem_4($_FILES['Arquivo4']['name']);
            $this->form_validation->set_rules('Arquivo4', 'Arquivo4', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo4', 'Arquivo4', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterar_imagem_4';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_imagem_4', $data);
        }
        else {
			
			$tiposPermitidos	= ['jpg','jpeg','pjpeg'];
			$tamanho			= $_FILES['Arquivo4']['size'];
			$extensao			= explode('.', $data['file']['Arquivo4']);
			$extensao			= end($extensao);
			
			if (!in_array($extensao, $tiposPermitidos)) {
				$data['msg'] = $this->basico->msg('<strong>O Tipo de Arquivo não é Permitido.</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_imagem_4', $data);
				
			} elseif(!($tamanho > 1000)){
				$data['msg'] = $this->basico->msg('<strong>O Tamanho do Arquivo ultrapassa o máximo Permitido</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_imagem_4', $data);
			}
            else {
					$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
					//$foto = $_FILES['Arquivo4']['name'];		
					$foto = $data['file']['Arquivo4'];
					$diretorio = $dir.$foto;

				if (!move_uploaded_file($_FILES['Arquivo4']['tmp_name'], $diretorio)) {
					$data['msg'] = $this->basico->msg('<strong>Arquivo não pode ser enviado</strong>', 'erro', TRUE, TRUE, TRUE);
					$this->load->view('empresa/form_imagem_4', $data);
					
				} 
				else {					
					
					$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';

					switch($_FILES['Arquivo4']['type']):
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

						case 'image/png':
						case 'image/x-png';
							
							list($largura, $altura, $tipo) = getimagesize($diretorio);
							
							$img = imagecreatefrompng($diretorio);

							$thumb = imagecreatetruecolor(200, 200);
							
							imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 200, $largura, $altura);
							
							imagejpeg($thumb, $dir2 . $foto);
							imagedestroy($img);
							imagedestroy($thumb);				      
						
						break;
						
					endswitch;					
					
					
					$data['camposfile'] = array_keys($data['file']);
					$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

					if ($data['idSis_Arquivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
						$this->basico->erro($msg);
						$this->load->view('empresa/form_imagem_4', $data);
					}
					else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
						
						$data['query']['Arquivo4'] = $data['file']['Arquivo4'];
						$data['anterior'] = $this->Empresa_model->get_pagina($data['query']['idSis_Empresa']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

						if ($data['auditoriaitem'] && $this->Empresa_model->update_pagina($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'empresa/form_imagem_4/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						} else {
						
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo4'] . '');
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Arquivo4'] . '');							

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'empresa/pagina/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						}				
					}
				}	
            }
        }

        $this->load->view('basico/footer');
    }
	
	public function alterar_slide_1($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Slide1',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
			$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Slide1']) && $_FILES['Slide1']['name']) {
            
			$data['file']['Slide1'] = $this->basico->renomeia_slide_1($_FILES['Slide1']['name']);
            $this->form_validation->set_rules('Slide1', 'Slide1', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Slide1', 'Slide1', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterar_slide_1';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_slide_1', $data);
        }
        else {
			
			$tiposPermitidos	= ['jpg','jpeg','pjpeg'];
			$tamanho			= $_FILES['Slide1']['size'];
			$extensao			= explode('.', $data['file']['Slide1']);
			$extensao			= end($extensao);
			
			if (!in_array($extensao, $tiposPermitidos)) {
				$data['msg'] = $this->basico->msg('<strong>O Tipo de Arquivo não é Permitido.</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_slide_1', $data);
				
			} elseif(!($tamanho > 1000)){
				$data['msg'] = $this->basico->msg('<strong>O Tamanho do Arquivo ultrapassa o máximo Permitido</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_slide_1', $data);
			}
            else {
					$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
					//$foto = $_FILES['Slide1']['name'];		
					$foto = $data['file']['Slide1'];
					$diretorio = $dir.$foto;

				if (!move_uploaded_file($_FILES['Slide1']['tmp_name'], $diretorio)) {
					$data['msg'] = $this->basico->msg('<strong>Arquivo não pode ser enviado</strong>', 'erro', TRUE, TRUE, TRUE);
					$this->load->view('empresa/form_slide_1', $data);
					
				} 
				else {					
					
					$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';

					switch($_FILES['Slide1']['type']):
						case 'image/jpg';
						case 'image/jpeg';
						case 'image/pjpeg';
					
							list($largura, $altura, $tipo) = getimagesize($diretorio);
							
							$img = imagecreatefromjpeg($diretorio);

							$thumb = imagecreatetruecolor(1902, 448);
							
							imagecopyresampled($thumb, $img, 0, 0, 0, 0, 1902, 448, $largura, $altura);
							
							imagejpeg($thumb, $dir2 . $foto);
							imagedestroy($img);
							imagedestroy($thumb);				      
						
						break;					
						
					endswitch;					
					
					
					$data['camposfile'] = array_keys($data['file']);
					$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

					if ($data['idSis_Arquivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
						$this->basico->erro($msg);
						$this->load->view('empresa/form_slide_1', $data);
					}
					else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
						
						$data['query']['Slide1'] = $data['file']['Slide1'];
						$data['anterior'] = $this->Empresa_model->get_pagina($data['query']['idSis_Empresa']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

						if ($data['auditoriaitem'] && $this->Empresa_model->update_pagina($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'empresa/form_slide_1/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'empresa/pagina/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						}				
					}
				}	
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar_slide_2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Slide2',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
			$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Slide2']) && $_FILES['Slide2']['name']) {
            
			$data['file']['Slide2'] = $this->basico->renomeia_slide_2($_FILES['Slide2']['name']);
            $this->form_validation->set_rules('Slide2', 'Slide2', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Slide2', 'Slide2', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterar_slide_2';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_slide_2', $data);
        }
        else {
			
			$tiposPermitidos	= ['jpg','jpeg','pjpeg'];
			$tamanho			= $_FILES['Slide2']['size'];
			$extensao			= explode('.', $data['file']['Slide2']);
			$extensao			= end($extensao);
			
			if (!in_array($extensao, $tiposPermitidos)) {
				$data['msg'] = $this->basico->msg('<strong>O Tipo de Arquivo não é Permitido.</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_slide_2', $data);
				
			} elseif(!($tamanho > 1000)){
				$data['msg'] = $this->basico->msg('<strong>O Tamanho do Arquivo ultrapassa o máximo Permitido</strong>', 'erro', TRUE, TRUE, TRUE);
				$this->load->view('empresa/form_slide_2', $data);
			}
            else {
					$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
					//$foto = $_FILES['Slide2']['name'];		
					$foto = $data['file']['Slide2'];
					$diretorio = $dir.$foto;

				if (!move_uploaded_file($_FILES['Slide2']['tmp_name'], $diretorio)) {
					$data['msg'] = $this->basico->msg('<strong>Arquivo não pode ser enviado</strong>', 'erro', TRUE, TRUE, TRUE);
					$this->load->view('empresa/form_slide_2', $data);
					
				} 
				else {					
					
					$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';

					switch($_FILES['Slide2']['type']):
						case 'image/jpg';
						case 'image/jpeg';
						case 'image/pjpeg';
					
							list($largura, $altura, $tipo) = getimagesize($diretorio);
							
							$img = imagecreatefromjpeg($diretorio);

							$thumb = imagecreatetruecolor(1902, 448);
							
							imagecopyresampled($thumb, $img, 0, 0, 0, 0, 1902, 448, $largura, $altura);
							
							imagejpeg($thumb, $dir2 . $foto);
							imagedestroy($img);
							imagedestroy($thumb);				      
						
						break;
						
					endswitch;					
					
					
					$data['camposfile'] = array_keys($data['file']);
					$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

					if ($data['idSis_Arquivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
						$this->basico->erro($msg);
						$this->load->view('empresa/form_slide_2', $data);
					}
					else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
						
						$data['query']['Slide2'] = $data['file']['Slide2'];
						$data['anterior'] = $this->Empresa_model->get_pagina($data['query']['idSis_Empresa']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

						if ($data['auditoriaitem'] && $this->Empresa_model->update_pagina($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'empresa/form_slide_2/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'empresa/pagina/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						}				
					}
				}	
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function alterar_texto_1($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'Texto_Arquivo1',
			'Texto_Arquivo2',
			'Texto_Arquivo3',
			'Texto_Arquivo4',
        ), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
			$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($id, TRUE);
        }
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('Texto_Arquivo1', 'Texto 1', 'required');
		$this->form_validation->set_rules('Texto_Arquivo2', 'Texto 2', 'required');
		$this->form_validation->set_rules('Texto_Arquivo3', 'Texto 3', 'required');
		$this->form_validation->set_rules('Texto_Arquivo4', 'Texto 4', 'required');
        
        $data['titulo'] = 'Alterar Texto';
        $data['form_open_path'] = 'empresa/alterar_texto_1';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_texto_1', $data);
        }

		else {

			$data['query']['Texto_Arquivo1'] = $data['query']['Texto_Arquivo1'];
			$data['query']['Texto_Arquivo2'] = $data['query']['Texto_Arquivo2'];
			$data['query']['Texto_Arquivo3'] = $data['query']['Texto_Arquivo3'];
			$data['query']['Texto_Arquivo4'] = $data['query']['Texto_Arquivo4'];
			
			$data['anterior'] = $this->Empresa_model->get_pagina($data['query']['idSis_Empresa']);
			$data['campos'] = array_keys($data['query']);

			$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

			if ($data['auditoriaitem'] && $this->Empresa_model->update_pagina($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
				$data['msg'] = '?m=2';
				redirect(base_url() . 'empresa/form_texto_1/' . $data['query']['idSis_Empresa'] . $data['msg']);
				exit();
			} else {

				if ($data['auditoriaitem'] === FALSE) {
					$data['msg'] = '';
				} else {
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
					$data['msg'] = '?m=1';
				}

				redirect(base_url() . 'empresa/pagina/' . $data['query']['idSis_Empresa'] . $data['msg']);
				exit();
			}				
		}
         
        $this->load->view('basico/footer');
    }

    public function alterar_imagem_1_BKP($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
			'Texto_Arquivo1',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo1',

		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
			$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo1']) && $_FILES['Arquivo1']['name']) {
            
			$data['file']['Arquivo1'] = $this->basico->renomeia_imagem_1($_FILES['Arquivo1']['name']);
            $this->form_validation->set_rules('Arquivo1', 'Arquivo1', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo1', 'Arquivo1', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterar_imagem_1';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_imagem_1', $data);
        }
        else {
			
            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo1'];

            $this->load->library('upload', $config);
			
            if (!$this->upload->do_upload('Arquivo1')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('empresa/form_imagem_1', $data);
            }
            else {

				$diretorio = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';
				$altura = "200";
				$largura = "200";

				switch($_FILES['Arquivo1']['type']):
					case 'image/jpg';
					case 'image/jpeg';
					case 'image/pjpeg';
						$imagem_temporaria = imagecreatefromjpeg($_FILES['Arquivo1']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						
						$altura_original = imagesy($imagem_temporaria);
						
						
						$nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
						
						$nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
						
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						imagejpeg($imagem_redimensionada, $diretorio . $data['file']['Arquivo1']);

					break;

					//Caso a imagem seja extensão PNG cai nesse CASE
					case 'image/png':
					case 'image/x-png';
						$imagem_temporaria = imagecreatefrompng($_FILES['Arquivo1']['tmp_name']);
						
						$largura_original = imagesx($imagem_temporaria);
						$altura_original = imagesy($imagem_temporaria);

						
						/* Configura a nova largura */
						$nova_largura = $largura ? $largura : floor(( $largura_original / $altura_original ) * $altura);

						/* Configura a nova altura */
						$nova_altura = $altura ? $altura : floor(( $altura_original / $largura_original ) * $largura);
						
						/* Retorna a nova imagem criada */
						$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
						
						/* Copia a nova imagem da imagem antiga com o tamanho correto */
						//imagealphablending($imagem_redimensionada, false);
						//imagesavealpha($imagem_redimensionada, true);

						imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
						
						//função imagejpeg que envia para o browser a imagem armazenada no parâmetro passado
						imagepng($imagem_redimensionada, $diretorio . $data['file']['Arquivo1']);
						
					break;					
					
				endswitch;                
				
				$data['camposfile'] = array_keys($data['file']);
				$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('empresa/form_imagem_1', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo1'] = $data['file']['Arquivo1'];
					$data['anterior'] = $this->Empresa_model->get_pagina($data['query']['idSis_Empresa']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

					if ($data['auditoriaitem'] && $this->Empresa_model->update_pagina($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'empresa/form_imagem_1/' . $data['query']['idSis_Empresa'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'empresa/pagina/' . $data['file']['idSis_Empresa'] . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }

    public function atendimento($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['empresa'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
			
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');

        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('Aberto' . $i) || $this->input->post('Hora_Abre' . $i) || $this->input->post('Hora_Fecha' . $i)) {
                $data['atendimento'][$j]['idApp_Atendimento'] = $this->input->post('idApp_Atendimento' . $i);
                $data['atendimento'][$j]['id_Dia'] = $this->input->post('id_Dia' . $i);
                $data['atendimento'][$j]['Dia_Semana'] = $this->input->post('Dia_Semana' . $i);
                $data['atendimento'][$j]['Aberto'] = $this->input->post('Aberto' . $i);
                $data['atendimento'][$j]['Hora_Abre'] = $this->input->post('Hora_Abre' . $i);
                $data['atendimento'][$j]['Hora_Fecha'] = $this->input->post('Hora_Fecha' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Sis_Empresa ####
            $data['empresa'] = $this->Empresa_model->get_empresa($id);


            #### App_Parcelas ####
            $_SESSION['Atendimento'] = $data['atendimento'] = $this->Empresa_model->get_atendimento($id);
            if (count($data['atendimento']) > 0) {
                $data['atendimento'] = array_combine(range(1, count($data['atendimento'])), array_values($data['atendimento']));
				$data['count']['PRCount'] = count($data['atendimento']);
				
                if (isset($data['atendimento'])) {

                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
                        //$data['atendimento'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['atendimento'][$j]['DataVencimentoOrca'], 'barras');
                    }

                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');
		//$this->form_validation->set_rules('Hora_Abre', 'Abre às', 'required|trim|valid_hour');
		//$this->form_validation->set_rules('Hora_Fecha', 'Fecha às', 'required|trim|valid_hour');
        //$this->form_validation->set_rules('Hora_Fecha', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['atendimento']['Hora_Abre'] . ']');


        $data['select']['Aberto'] = $this->Basico_model->select_status_sn();		
		
        $data['titulo'] = 'Atendimento';
        $data['form_open_path'] = 'empresa/atendimento';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 2;

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

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('empresa/form_atendimento', $data);
        } else {
			
			////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####

			$data['empresa']['DataOrca'] = $this->basico->mascara_data($data['empresa']['DataOrca'], 'mysql');


            $data['update']['empresa']['anterior'] = $this->Empresa_model->get_empresa($data['empresa']['idSis_Empresa']);
            $data['update']['empresa']['campos'] = array_keys($data['empresa']);
            $data['update']['empresa']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['empresa']['anterior'],
                $data['empresa'],
                $data['update']['empresa']['campos'],
                $data['empresa']['idSis_Empresa'], TRUE);
            $data['update']['empresa']['bd'] = $this->Empresa_model->update_empresa($data['empresa'], $data['empresa']['idSis_Empresa']);


            #### App_ParcelasRec ####
            $data['update']['atendimento']['anterior'] = $this->Empresa_model->get_atendimento($data['empresa']['idSis_Empresa']);
            if (isset($data['atendimento']) || (!isset($data['atendimento']) && isset($data['update']['atendimento']['anterior']) ) ) {

                if (isset($data['atendimento']))
                    $data['atendimento'] = array_values($data['atendimento']);
                else
                    $data['atendimento'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['atendimento'] = $this->basico->tratamento_array_multidimensional($data['atendimento'], $data['update']['atendimento']['anterior'], 'idApp_Atendimento');

                $max = count($data['update']['atendimento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    //$data['update']['atendimento']['alterar'][$j]['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['update']['atendimento']['alterar'][$j]['ValorRestanteOrca']));
                    //$data['update']['atendimento']['alterar'][$j]['ValorComissao'] = str_replace(',', '.', str_replace('.', '', $data['update']['atendimento']['alterar'][$j]['ValorComissao']));
                    //$data['update']['atendimento']['alterar'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['update']['atendimento']['alterar'][$j]['DataVencimentoOrca'], 'mysql');
					
				}

                if (count($data['update']['atendimento']['alterar']))
                    $data['update']['atendimento']['bd']['alterar'] =  $this->Empresa_model->update_atendimento($data['update']['atendimento']['alterar']);

            }

            //if ($data['idSis_Empresa'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['empresa']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('empresa/form_atendimento', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				//redirect(base_url() . 'relatorio/comissao/' . $data['msg']);
				redirect(base_url() . 'empresa/prontuario/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function pagseguro($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['PagSeguro'] = $data['pagseguro'] = $this->Empresa_model->get_pagseguro($id, TRUE);
        $data['titulo'] = 'Pag Seguro ' ;
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

        $this->load->view('empresa/tela_pagseguro', $data);

        $this->load->view('basico/footer');
    }

    public function alterarpagseguro($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['pagseguro'] = $this->input->post(array(
			'idSis_Empresa',
			'idApp_Documentos',
			'Token_Sandbox',
			'Token_Producao',
			'Email_Pagseguro',
			'Email_Loja',
			'Ativo_Pagseguro',
        ), TRUE);
				

        if ($id) {
            $_SESSION['PagSeguro'] = $data['pagseguro'] = $this->Empresa_model->get_pagseguro($id, TRUE);
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('Email_Pagseguro', 'E-mail do PagSeguro', 'required|trim|valid_email');
		$this->form_validation->set_rules('Email_Loja', 'E-mail da Loja', 'required|trim|valid_email');
        $this->form_validation->set_rules('Token_Sandbox', 'Token_Sandbox', 'required|trim');
        $this->form_validation->set_rules('Token_Producao', 'Token_Producao', 'required|trim');
		
		$data['select']['Ativo_Pagseguro'] = $this->Basico_model->select_status_sn();

        $data['titulo'] = 'Pag Seguro';
        $data['form_open_path'] = 'empresa/alterarpagseguro';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('empresa/form_pagseguro', $data);
        } else {

			//$data['pagseguro']['NomeEmpresa'] = trim(mb_strtoupper($data['pagseguro']['NomeEmpresa'], 'ISO-8859-1'));
            //$data['pagseguro']['NomeAdmin'] = trim(mb_strtoupper($data['pagseguro']['NomeAdmin'], 'ISO-8859-1'));

            $data['anterior'] = $this->Empresa_model->get_pagseguro($data['pagseguro']['idSis_Empresa']);
            $data['campos'] = array_keys($data['pagseguro']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['pagseguro'], $data['campos'], $data['pagseguro']['idSis_Empresa'], TRUE);

            if ($data['auditoriaitem'] && $this->Empresa_model->update_pagseguro($data['pagseguro'], $data['pagseguro']['idSis_Empresa']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'empresa/form_pagseguro/' . $data['pagseguro']['idSis_Empresa'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

				redirect(base_url() . 'empresa/pagseguro/' . $data['pagseguro']['idSis_Empresa'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
}
