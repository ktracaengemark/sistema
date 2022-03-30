<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Documentos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Documentos_model', 'Fornecedor_model', 'Formapag_model', 'Relatorio_model'));
        $this->load->driver('session');

        
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

        $this->load->view('slides/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($tabela = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idApp_Documentos',
			'Texto_Logo_Nav',
			'idSis_Empresa',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('Texto_Logo_Nav', 'Texto', 'required|trim');

        $data['titulo'] = 'Slide';
        $data['form_open_path'] = 'slides/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['button'] =
                '
                <button class="btn btn-sm btn-primary" name="pesquisar" value="0" type="submit">
                    <span class="glyphicon glyphicon-plus"></span> Cadastrar
                </button>
        ';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('slides/form_texto_slides', $data);
        } else {

			#$data['query']['Texto_Logo_Nav'] = trim(mb_strtoupper($data['query']['Texto_Logo_Nav'], 'ISO-8859-1'));
			$data['query']['Texto_Logo_Nav'] = $data['query']['Texto_Logo_Nav'];
           # $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Documentos'] = $this->Documentos_model->set_slides($data['query']);

            if ($data['idApp_Documentos'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('slides/form_texto_slides', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Documentos'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Documentos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'relatorio/slides' . $data['msg']);
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

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idApp_Documentos',
            'Texto_Logo_Nav',
			'idSis_Empresa',
                ), TRUE));


        if ($id)
            $data['query'] = $this->Documentos_model->get_slides($id);


        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('Texto_Logo_Nav', 'Texto_Logo_Naviação', 'required|trim');


        $data['titulo'] = 'Editar Slide';
        $data['form_open_path'] = 'slides/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['button'] =
                '
                <button class="btn btn-sm btn-warning" name="pesquisar" value="0" type="submit">
                    <span class="glyphicon glyphicon-edit"></span> Salvar Alteração
                </button>
        ';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('slides/form_texto_slides', $data);
        } else {

			$data['query']['Texto_Logo_Nav'] = $data['query']['Texto_Logo_Nav'];
           # $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

            $data['anterior'] = $this->Documentos_model->get_slides($data['query']['idApp_Documentos']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Documentos'], TRUE);

            if ($data['auditoriaitem'] && $this->Documentos_model->update_slides($data['query'], $data['query']['idApp_Documentos']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'slides/form_texto_slides' . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Documentos', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'relatorio/slides/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
    
    public function alterar_title($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['empresa'] = $this->input->post(array(
			'idSis_Empresa',
			'Title',
        ), TRUE);
				

        if ($id) {
            $data['empresa'] = $this->Documentos_model->get_empresa($id, TRUE);
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('Title', 'Título', 'required|trim');

        $data['titulo'] = 'Título';
        $data['form_open_path'] = 'documentos/alterar_title';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('documentos/form_alterar_title', $data);
        } else {

            $data['anterior'] = $this->Documentos_model->get_empresa($data['empresa']['idSis_Empresa']);
            $data['campos'] = array_keys($data['empresa']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['empresa'], $data['campos'], $data['empresa']['idSis_Empresa'], TRUE);

            if ($data['auditoriaitem'] && $this->Documentos_model->update_empresa($data['empresa'], $data['empresa']['idSis_Empresa']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'documentos/alterar_title/' . $data['empresa']['idSis_Empresa'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

				redirect(base_url() . 'relatorio/site/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
    
    public function alterar_description($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['empresa'] = $this->input->post(array(
			'idSis_Empresa',
			'Description',
        ), TRUE);
				

        if ($id) {
            $data['empresa'] = $this->Documentos_model->get_empresa($id, TRUE);
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('Description', 'Descrição', 'required|trim');

        $data['titulo'] = 'Título';
        $data['form_open_path'] = 'documentos/alterar_description';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('documentos/form_alterar_description', $data);
        } else {

            $data['anterior'] = $this->Documentos_model->get_empresa($data['empresa']['idSis_Empresa']);
            $data['campos'] = array_keys($data['empresa']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['empresa'], $data['campos'], $data['empresa']['idSis_Empresa'], TRUE);

            if ($data['auditoriaitem'] && $this->Documentos_model->update_empresa($data['empresa'], $data['empresa']['idSis_Empresa']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'documentos/alterar_description/' . $data['empresa']['idSis_Empresa'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

				redirect(base_url() . 'relatorio/site/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function alterar_logo_nav($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idApp_Documentos',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idApp_Documentos',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Documentos'] = $data['query'] = $this->Documentos_model->get_slides($id, TRUE);
        }
		
        if ($id)
            $data['file']['idApp_Documentos'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeia_logo_nav($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'documentos/alterar_logo_nav';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('documentos/form_logo_nav', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('documentos/form_logo_nav', $data);
            }
            else {
			
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

						$thumb = imagecreatetruecolor(150, 66);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 150, 66, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;					

					case 'image/png';
					case 'image/x-png';

						list($width, $height) = getimagesize($diretorio);
						$newwidth = 150;
						$newheight = 66;

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
				$data['file']['idSis_Empresa'] = $_SESSION['Empresa']['idSis_Empresa'];
				$data['idSis_Arquivo'] = $this->Documentos_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('documentos/form_logo_nav', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Logo_Nav'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Documentos_model->get_slides($data['query']['idApp_Documentos']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Documentos'], TRUE);

					if ($data['auditoriaitem'] && $this->Documentos_model->update_slides($data['query'], $data['query']['idApp_Documentos']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'documentos/form_logo_nav/' . $data['query']['idApp_Documentos'] . $data['msg']);
						exit();
					} else {

						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Logo_Nav'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Logo_Nav'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/slide.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Logo_Nav'] . '');						
						}
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Logo_Nav'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Logo_Nav'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/slide.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Logo_Nav'] . '');						
						}						
						
						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Documentos', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'relatorio/site/' . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function alterar_icone($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idApp_Documentos',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idApp_Documentos',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Documentos'] = $data['query'] = $this->Documentos_model->get_slides($id, TRUE);
        }
		
        if ($id)
            $data['file']['idApp_Documentos'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeia_icone($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'documentos/alterar_icone';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('documentos/form_icone', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('documentos/form_icone', $data);
            }
            else {
			
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

						$thumb = imagecreatetruecolor(300, 300);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 300, 300, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;					

					case 'image/png';
					case 'image/x-png';

						list($width, $height) = getimagesize($diretorio);
						$newwidth = 300;
						$newheight = 300;

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
				$data['file']['idSis_Empresa'] = $_SESSION['Empresa']['idSis_Empresa'];
				$data['idSis_Arquivo'] = $this->Documentos_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('documentos/form_icone', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Icone'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Documentos_model->get_slides($data['query']['idApp_Documentos']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Documentos'], TRUE);

					if ($data['auditoriaitem'] && $this->Documentos_model->update_slides($data['query'], $data['query']['idApp_Documentos']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'documentos/form_icone/' . $data['query']['idApp_Documentos'] . $data['msg']);
						exit();
					} else {

						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Icone'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Icone'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/icone.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Icone'] . '');						
						}
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Icone'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Icone'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/icone.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Icone'] . '');						
						}						
						
						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Documentos', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'relatorio/site/' . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }
    
    public function alterar_a_empresa($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['empresa'] = $this->input->post(array(
			'idSis_Empresa',
			'AEmpresa',
			'Top1',
			'Top2',
			'Texto_Top1',
			'Texto_Top2',
        ), TRUE);
				

        if ($id) {
            $data['empresa'] = $this->Documentos_model->get_empresa($id, TRUE);
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('AEmpresa', 'A Empresa', 'required|trim');

        $data['titulo'] = 'A Empresa';
        $data['form_open_path'] = 'documentos/alterar_a_empresa';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('documentos/form_alterar_a_empresa', $data);
        } else {

            $data['anterior'] = $this->Documentos_model->get_empresa($data['empresa']['idSis_Empresa']);
            $data['campos'] = array_keys($data['empresa']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['empresa'], $data['campos'], $data['empresa']['idSis_Empresa'], TRUE);

            if ($data['auditoriaitem'] && $this->Documentos_model->update_empresa($data['empresa'], $data['empresa']['idSis_Empresa']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'documentos/alterar_a_empresa/' . $data['empresa']['idSis_Empresa'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

				redirect(base_url() . 'relatorio/site/' . $data['msg']);
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

			if ($id) {
				$_SESSION['Documentos'] = $this->Documentos_model->get_slides($id, TRUE);
			}		
			$this->Documentos_model->delete_slides($id);

			$data['msg'] = '?m=1';
			
			if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Logo_Nav'] . ''))
				&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Logo_Nav'] . '')
				!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/slide.jpg'))){
				unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Logo_Nav'] . '');						
			}
			if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Logo_Nav'] . ''))
				&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Logo_Nav'] . '')
				!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/slide.jpg'))){
				unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Logo_Nav'] . '');						
			}
			
			redirect(base_url() . 'relatorio/slides/' . $data['msg']);
			exit();

        $this->load->view('basico/footer');
    }
	
}
