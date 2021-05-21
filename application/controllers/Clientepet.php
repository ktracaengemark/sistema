<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientepet extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Clientepet_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('clientepet/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('clientepet/tela_index', $data);

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
		
        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_ClientePet',
            'idApp_Cliente',
            'idSis_Usuario',
            'NomeClientePet',
            'StatusVidaPet',
            'DataNascimentoPet',
			'AtivoPet',
            'SexoPet',
            'EspeciePet',
            'RacaPet',
            'PeloPet',
            'CorPet',
            'PortePet',
            'ObsPet',
            'AlergicoPet',
            'PesoPet',
		), TRUE));

        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVidaPet']='V';
		
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

		$clientepet1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['NomeClientePet'], $caracteres_sem_acento));		
		
 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
		
        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		//$data['select']['SexoPet'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVidaPet'] = $this->Clientepet_model->select_status_vida();
		$data['select']['AtivoPet'] = $this->Basico_model->select_status_sn();
		$data['select']['AlergicoPet'] = $this->Basico_model->select_status_sn();
		$data['select']['RacaPet'] = $this->Cliente_model->select_racapet();
		$data['select']['EspeciePet'] = array (
            //'0' => '',
            '1' => 'CÃO',
            '2' => 'GATO',
			'3' => 'AVE',
        );
		$data['select']['SexoPet'] = array(
			//'O' => '',
			'M' => 'MACHO',
			'F' => 'FÊMEA',
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
		$data['titulo'] = 'Contatos e Responsáveis';
        $data['form_open_path'] = 'clientepet/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
		
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		
		$data['q3'] = $this->Clientepet_model->list_racapet(TRUE);
		$data['list3'] = $this->load->view('clientepet/list_racapet', $data, TRUE);
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('NomeClientePet', 'Nome do Pet', 'required|trim');
        $this->form_validation->set_rules('DataNascimentoPet', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('clientepet/form_clientepet', $data);
        } else {
			
			$data['query']['PesoPet'] = str_replace(',', '.', str_replace('.', '', $data['query']['PesoPet']));
            $data['query']['NomeClientePet'] = trim(mb_strtoupper($clientepet1, 'ISO-8859-1'));
            $data['query']['DataNascimentoPet'] = $this->basico->mascara_data($data['query']['DataNascimentoPet'], 'mysql');
            $data['query']['ObsPet'] = trim(mb_strtoupper($data['query']['ObsPet'], 'ISO-8859-1'));
            $data['query']['EspeciePet'] = trim(mb_strtoupper($data['query']['EspeciePet'], 'ISO-8859-1'));
            $data['query']['RacaPet'] = trim(mb_strtoupper($data['query']['RacaPet'], 'ISO-8859-1'));
            $data['query']['PeloPet'] = trim(mb_strtoupper($data['query']['PeloPet'], 'ISO-8859-1'));
            $data['query']['CorPet'] = trim(mb_strtoupper($data['query']['CorPet'], 'ISO-8859-1'));
            $data['query']['PortePet'] = trim(mb_strtoupper($data['query']['PortePet'], 'ISO-8859-1'));
			$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_ClientePet'] = $this->Clientepet_model->set_clientepet($data['query']);

            if ($data['idApp_ClientePet'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('clientepet/form_clientepet', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_ClientePet'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClientePet', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'clientepet/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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
		
        $data['query'] = $this->input->post(array(
            'idApp_ClientePet',
            'idApp_Cliente',
            'NomeClientePet',
            'StatusVidaPet',
            'DataNascimentoPet',
            'SexoPet',
            'EspeciePet',
            'RacaPet',
            'PeloPet',
            'CorPet',
            'PortePet',
            'ObsPet',
			'AtivoPet',
            'AlergicoPet',
            'PesoPet',
		), TRUE);

        if ($id) {
            $_SESSION['ClientePet'] = $data['query'] = $this->Clientepet_model->get_clientepet($id);
            $data['query']['DataNascimentoPet'] = $this->basico->mascara_data($data['query']['DataNascimentoPet'], 'barras');
            //$_SESSION['ClientePet']['idApp_ClientePet'] = $id;
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

		$clientepet1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['NomeClientePet'], $caracteres_sem_acento));		
				
        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		//$data['select']['SexoPet'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVidaPet'] = $this->Clientepet_model->select_status_vida();      
		$data['select']['AtivoPet'] = $this->Basico_model->select_status_sn();    
		$data['select']['AlergicoPet'] = $this->Basico_model->select_status_sn();
		$data['select']['RacaPet'] = $this->Cliente_model->select_racapet();
		$data['select']['EspeciePet'] = array (
            //'0' => '',
            '1' => 'CÃO',
            '2' => 'GATO',
			'3' => 'AVE',
        );
		$data['select']['SexoPet'] = array(
			//'O' => '',
			'M' => 'MACHO',
			'F' => 'FÊMEA',
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
		$data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'clientepet/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
		
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		
		$data['q3'] = $this->Clientepet_model->list_racapet(TRUE);
		$data['list3'] = $this->load->view('clientepet/list_racapet', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('NomeClientePet', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimentoPet', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('clientepet/form_clientepet', $data);
        } else {

			$data['query']['PesoPet'] = str_replace(',', '.', str_replace('.', '', $data['query']['PesoPet']));		
            $data['query']['NomeClientePet'] = trim(mb_strtoupper($clientepet1, 'ISO-8859-1'));
            $data['query']['DataNascimentoPet'] = $this->basico->mascara_data($data['query']['DataNascimentoPet'], 'mysql');
            $data['query']['ObsPet'] = trim(mb_strtoupper($data['query']['ObsPet'], 'ISO-8859-1'));
            $data['query']['EspeciePet'] = trim(mb_strtoupper($data['query']['EspeciePet'], 'ISO-8859-1'));
            $data['query']['RacaPet'] = trim(mb_strtoupper($data['query']['RacaPet'], 'ISO-8859-1'));
            $data['query']['PeloPet'] = trim(mb_strtoupper($data['query']['PeloPet'], 'ISO-8859-1'));
            $data['query']['CorPet'] = trim(mb_strtoupper($data['query']['CorPet'], 'ISO-8859-1'));
            $data['query']['PortePet'] = trim(mb_strtoupper($data['query']['PortePet'], 'ISO-8859-1'));
            //$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idApp_ClientePet'] = $_SESSION['ClientePet']['idApp_ClientePet'];

            $data['anterior'] = $this->Clientepet_model->get_clientepet($data['query']['idApp_ClientePet']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ClientePet'], TRUE);

            if ($data['auditoriaitem'] && $this->Clientepet_model->update_clientepet($data['query'], $data['query']['idApp_ClientePet']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'clientepet/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClientePet', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'clientepet/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                redirect(base_url() . 'cliente/clientepet/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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

                $this->Clientepet_model->delete_clientepet($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'clientepet/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }
	
    public function pesquisar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'), 0, -3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'), 0, -3);
        }

        $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id, TRUE);
		$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        $data['query'] = $this->Clientepet_model->lista_clientepet(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('clientepet/list_clientepet', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('clientepet/tela_clientepet', $data);

        $this->load->view('basico/footer');
    }

    public function alterarlogopet($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idApp_ClientePet',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idApp_ClientePet',
            'Arquivo',
		), TRUE);

        if ($id) {
			$_SESSION['ClientePet'] = $data['query'] = $this->Clientepet_model->get_clientepet($id, TRUE);
			$_SESSION['ClientePet']['NomeClientePet'] = (strlen($data['query']['NomeClientePet']) > 12) ? substr($data['query']['NomeClientePet'], 0, 12) : $data['query']['NomeClientePet'];
        }
		
        if ($id)
            $data['file']['idApp_ClientePet'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeiaclientepet($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'clientepet/alterarlogopet';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('clientepet/form_perfil', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('clientepet/form_perfil', $data);
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
					////Corrigir esse " : " ////
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
				$data['idSis_Arquivo'] = $this->Clientepet_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('clientepet/form_perfil', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Clientepet_model->get_clientepet($data['query']['idApp_ClientePet']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ClientePet'], TRUE);

					if ($data['auditoriaitem'] && $this->Clientepet_model->update_clientepet($data['query'], $data['query']['idApp_ClientePet']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'clientepet/form_perfil/' . $data['query']['idApp_ClientePet'] . $data['msg']);
						exit();
					} else {
						
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/' . $_SESSION['ClientePet']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/' . $_SESSION['ClientePet']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/pata.png'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/' . $_SESSION['ClientePet']['Arquivo'] . '');						
						}
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['ClientePet']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['ClientePet']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/pata.png'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['ClientePet']['Arquivo'] . '');						
						}						

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClientePet', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						//redirect(base_url() . 'clientepet/pesquisar/' . $data['file']['idApp_ClientePet'] . $data['msg']);
						redirect(base_url() . 'cliente/clientepet/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }

}
