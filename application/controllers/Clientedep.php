<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientedep extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Clientedep_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('clientedep/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('clientedep/tela_index', $data);

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
            //'idApp_ClienteDep',
            'idApp_Cliente',
            'idSis_Usuario',
            'NomeClienteDep',
            'StatusVidaDep',
            'DataNascimentoDep',
			'AtivoDep',
            'SexoDep',
            'ObsDep',
			'RelacaoDep',
		), TRUE));

        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVidaDep']='V';
		
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

		$clientedep1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['NomeClienteDep'], $caracteres_sem_acento));		
				
		$data['select']['RelacaoDep'] = $this->Cliente_model->select_relacao();
		$data['select']['SexoDep'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVidaDep'] = $this->Clientedep_model->select_status_vida();
		$data['select']['AtivoDep'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Contatos e Responsáveis';
        $data['form_open_path'] = 'clientedep/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
		
        $data['cor_cli'] 	= 'warning';
        $data['cor_cons'] 	= 'default';
        $data['cor_orca'] 	= 'default';
        $data['cor_sac'] 	= 'default';
        $data['cor_mark'] 	= 'default';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);		
        
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeClienteDep', 'Nome do Dependente', 'required|trim');
        $this->form_validation->set_rules('DataNascimentoDep', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('RelacaoDep', 'Relação', 'required|trim');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('clientedep/form_clientedep', $data);
        } else {

			$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['query']['NomeClienteDep'] = trim(mb_strtoupper($clientedep1, 'ISO-8859-1'));
            $data['query']['ObsDep'] = nl2br($data['query']['ObsDep']);

			if(empty($data['query']['DataNascimentoDep'])){
				$data['query']['DataNascimentoDep'] = "0000-00-00";
			}else{
				$data['query']['DataNascimentoDep'] = $this->basico->mascara_data($data['query']['DataNascimentoDep'], 'mysql');
			}
			
			if(empty($data['query']['RelacaoDep'])){
				$data['query']['RelacaoDep'] = "0";
			}				
									
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_ClienteDep'] = $this->Clientedep_model->set_clientedep($data['query']);

            if ($data['idApp_ClienteDep'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('clientedep/form_clientedep', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_ClienteDep'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClienteDep', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'clientedep/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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
            'idApp_ClienteDep',
            'idApp_Cliente',
            'NomeClienteDep',
            'StatusVidaDep',
            'DataNascimentoDep',
            'SexoDep',
            //'idSis_Usuario',
            'ObsDep',
			'AtivoDep',
			'RelacaoDep',
		), TRUE);

        if ($id) {
            $_SESSION['ClienteDep'] = $data['query'] = $this->Clientedep_model->get_clientedep($id);
            $data['query']['DataNascimentoDep'] = $this->basico->mascara_data($data['query']['DataNascimentoDep'], 'barras');
            //$_SESSION['ClienteDep']['idApp_ClienteDep'] = $id;
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

		$clientedep1 = preg_replace("/[^a-zA-Z]/", " ", strtr($data['query']['NomeClienteDep'], $caracteres_sem_acento));		
				
		$data['select']['RelacaoDep'] = $this->Cliente_model->select_relacao();
		$data['select']['SexoDep'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVidaDep'] = $this->Clientedep_model->select_status_vida();      
		$data['select']['AtivoDep'] = $this->Basico_model->select_status_sn();

		$data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'clientedep/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
		
        $data['cor_cli'] 	= 'warning';
        $data['cor_cons'] 	= 'default';
        $data['cor_orca'] 	= 'default';
        $data['cor_sac'] 	= 'default';
        $data['cor_mark'] 	= 'default';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeClienteDep', 'Nome do Dependente', 'required|trim');
        $this->form_validation->set_rules('DataNascimentoDep', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('RelacaoDep', 'Relação', 'required|trim');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('clientedep/form_clientedep', $data);
        } else {

			$data['query']['idApp_ClienteDep'] = $_SESSION['ClienteDep']['idApp_ClienteDep'];
            $data['query']['NomeClienteDep'] = trim(mb_strtoupper($clientedep1, 'ISO-8859-1'));
            $data['query']['ObsDep'] = nl2br($data['query']['ObsDep']);

			if(empty($data['query']['DataNascimentoDep'])){
				$data['query']['DataNascimentoDep'] = "0000-00-00";
			}else{
				$data['query']['DataNascimentoDep'] = $this->basico->mascara_data($data['query']['DataNascimentoDep'], 'mysql');
			}
			
			if(empty($data['query']['RelacaoDep'])){
				$data['query']['RelacaoDep'] = "0";
			}				
			
            $data['anterior'] = $this->Clientedep_model->get_clientedep($data['query']['idApp_ClienteDep']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ClienteDep'], TRUE);

            if ($data['auditoriaitem'] && $this->Clientedep_model->update_clientedep($data['query'], $data['query']['idApp_ClienteDep']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'clientedep/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClienteDep', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'clientedep/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                redirect(base_url() . 'cliente/clientedep/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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

                $this->Clientedep_model->delete_clientedep($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'clientedep/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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

        $data['query'] = $this->Clientedep_model->lista_clientedep(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('clientedep/list_clientedep', $data, TRUE);
		
        $data['cor_cli'] 	= 'warning';
        $data['cor_cons'] 	= 'default';
        $data['cor_orca'] 	= 'default';
        $data['cor_sac'] 	= 'default';
        $data['cor_mark'] 	= 'default';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('clientedep/tela_clientedep', $data);

        $this->load->view('basico/footer');
    }

    public function alterarlogodep($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idApp_ClienteDep',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idApp_ClienteDep',
            'Arquivo',
		), TRUE);

        if ($id) {
			$_SESSION['ClienteDep'] = $data['query'] = $this->Clientedep_model->get_clientedep($id, TRUE);
			$_SESSION['ClienteDep']['NomeClienteDep'] = (strlen($data['query']['NomeClienteDep']) > 12) ? substr($data['query']['NomeClienteDep'], 0, 12) : $data['query']['NomeClienteDep'];
        }
		
        if ($id)
            $data['file']['idApp_ClienteDep'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeiaclientedep($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'clientedep/alterarlogodep';
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
            $this->load->view('clientedep/form_perfil', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('clientedep/form_perfil', $data);
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
				$data['idSis_Arquivo'] = $this->Clientedep_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('clientedep/form_perfil', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Clientedep_model->get_clientedep($data['query']['idApp_ClienteDep']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ClienteDep'], TRUE);

					if ($data['auditoriaitem'] && $this->Clientedep_model->update_clientedep($data['query'], $data['query']['idApp_ClienteDep']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'clientedep/form_perfil/' . $data['query']['idApp_ClienteDep'] . $data['msg']);
						exit();
					} else {
						
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/' . $_SESSION['ClienteDep']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/' . $_SESSION['ClienteDep']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/Foto.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/original/' . $_SESSION['ClienteDep']['Arquivo'] . '');						
						}
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['ClienteDep']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['ClienteDep']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/Foto.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['ClienteDep']['Arquivo'] . '');						
						}						

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClienteDep', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'cliente/clientedep/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }

}
