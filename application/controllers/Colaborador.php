<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Colaborador extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Colaborador_model', 'Relatorio_model'));
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

        $this->load->view('colaborador/tela_index', $data);

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
			//'idApp_Colaborador',
            'Arquivo_Colaborador',
			'Nome_Colaborador',
			'Texto_Colaborador',
			'Ativo_Colaborador',
			'idSis_Usuario',
			'idSis_Empresa',
		), TRUE));
		
        $data['file'] = $this->input->post(array(
			//'idApp_Colaborador',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'colaborador/cadastrar';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

 		(!$data['query']['Ativo_Colaborador']) ? $data['query']['Ativo_Colaborador'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo_Colaborador' => $this->basico->radio_checked($data['query']['Ativo_Colaborador'], 'Ativo_Colaborador', 'NS'),
        );
        ($data['query']['Ativo_Colaborador'] == 'S') ?
            $data['div']['Ativo_Colaborador'] = '' : $data['div']['Ativo_Colaborador'] = 'style="display: none;"';	
			
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('Nome_Colaborador', 'Nome do Colaborador', 'trim');

		$data['select']['Ativo_Colaborador'] = $this->Basico_model->select_status_sn();
		
        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->nomeia_colaborador($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('colaborador/form_cad_colaborador', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('colaborador/form_cad_colaborador', $data);
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

					case 'image/png':
					case 'image/x-png';
						
						list($largura, $altura, $tipo) = getimagesize($diretorio);
						
						$img = imagecreatefrompng($diretorio);

						$thumb = imagecreatetruecolor(300, 300);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 300, 300, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;
					
				endswitch;			
				
				$data['query']['Arquivo_Colaborador'] = $data['file']['Arquivo'];
				$data['query']['Nome_Colaborador'] = $data['query']['Nome_Colaborador'];
				$data['query']['Texto_Colaborador'] = $data['query']['Texto_Colaborador'];
				$data['query']['Ativo_Colaborador'] = $data['query']['Ativo_Colaborador'];
				$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
				$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

				$data['campos'] = array_keys($data['query']);
				$data['anterior'] = array();

				$data['query']['idApp_Colaborador'] = $this->Colaborador_model->set_colaborador($data['query']);

				if ($data['query']['idApp_Colaborador'] === FALSE) {
					$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
					$this->basico->erro($msg);
					$this->load->view('colaborador/form_cad_colaborador', $data);
				}				

				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Colaborador'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Colaborador', 'CREATE', $data['auditoriaitem']);
					
					$data['file']['idApp_Colaborador'] = $data['query']['idApp_Colaborador'];					
					$data['file']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['camposfile'] = array_keys($data['file']);
					$data['idSis_Arquivo'] = $this->Colaborador_model->set_arquivo($data['file']);

					if ($data['idSis_Arquivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
						$this->basico->erro($msg);
						$this->load->view('colaborador/form_cad_colaborador', $data);
					} 
					else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);						

						$data['msg'] = '?m=1';

						redirect(base_url() . 'relatorio/colaborador' . $data['msg']);
						exit();
					}				
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

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idApp_Colaborador',
            'Nome_Colaborador',
            'Texto_Colaborador',
			'Ativo_Colaborador',
			'idSis_Empresa',
		), TRUE));


        if ($id){
			$data['query'] = $this->Colaborador_model->get_colaborador($id);
		}

		$data['select']['Ativo_Colaborador'] = $this->Basico_model->select_status_sn();

        $data['titulo'] = 'Editar Colaborador';
        $data['form_open_path'] = 'colaborador/alterar';
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

 		(!$data['query']['Ativo_Colaborador']) ? $data['query']['Ativo_Colaborador'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo_Colaborador' => $this->basico->radio_checked($data['query']['Ativo_Colaborador'], 'Ativo_Colaborador', 'NS'),
        );
        ($data['query']['Ativo_Colaborador'] == 'S') ?
            $data['div']['Ativo_Colaborador'] = '' : $data['div']['Ativo_Colaborador'] = 'style="display: none;"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('Nome_Colaborador', 'Nome do Colaborador', 'trim');
		$this->form_validation->set_rules('Texto_Colaborador', 'Texto do Colaborador', 'trim');
					
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('colaborador/form_texto_colaborador', $data);
        } else {

           # $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));		
			$data['query']['Nome_Colaborador'] = $data['query']['Nome_Colaborador'];
			$data['query']['Texto_Colaborador'] = $data['query']['Texto_Colaborador'];
            $data['query']['Ativo_Colaborador'] = $data['query']['Ativo_Colaborador'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

            $data['anterior'] = $this->Colaborador_model->get_colaborador($data['query']['idApp_Colaborador']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Colaborador'], TRUE);

            if ($data['auditoriaitem'] && $this->Colaborador_model->update_colaborador($data['query'], $data['query']['idApp_Colaborador']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'colaborador/form_texto_colaborador' . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Colaborador', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'relatorio/colaborador/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
		
    public function alterar_colaborador($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		/*
        $data['query'] = $this->input->post(array(
			'idApp_Colaborador',
			//'Texto_Colaborador',
        ), TRUE);
		*/
        $data['query'] = quotes_to_entities($this->input->post(array(
			'idApp_Colaborador',
            'Nome_Colaborador',
            'Texto_Colaborador',
			'Ativo_Colaborador',
		), TRUE));
				
        $data['file'] = $this->input->post(array(
            'idApp_Colaborador',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Colaborador'] = $data['query'] = $this->Colaborador_model->get_colaborador($id, TRUE);
			$data['file']['idApp_Colaborador'] = $id;
		}

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$data['select']['Ativo_Colaborador'] = $this->Basico_model->select_status_sn();		
		
        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeiacolaborador($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'colaborador/alterar_colaborador';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

 		(!$data['query']['Ativo_Colaborador']) ? $data['query']['Ativo_Colaborador'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo_Colaborador' => $this->basico->radio_checked($data['query']['Ativo_Colaborador'], 'Ativo_Colaborador', 'NS'),
        );
        ($data['query']['Ativo_Colaborador'] == 'S') ?
            $data['div']['Ativo_Colaborador'] = '' : $data['div']['Ativo_Colaborador'] = 'style="display: none;"';
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('colaborador/form_colaborador', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('colaborador/form_colaborador', $data);
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

					case 'image/png':
					case 'image/x-png';
						
						list($largura, $altura, $tipo) = getimagesize($diretorio);
						
						$img = imagecreatefrompng($diretorio);

						$thumb = imagecreatetruecolor(300, 300);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 300, 300, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;
					
				endswitch;			

                $data['camposfile'] = array_keys($data['file']);
				$data['file']['idSis_Empresa'] = $_SESSION['Empresa']['idSis_Empresa'];
				$data['idSis_Arquivo'] = $this->Colaborador_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('colaborador/form_colaborador', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo_Colaborador'] = $data['file']['Arquivo'];
					$data['query']['Nome_Colaborador'] = $data['query']['Nome_Colaborador'];
					$data['query']['Texto_Colaborador'] = $data['query']['Texto_Colaborador'];
					$data['query']['Ativo_Colaborador'] = $data['query']['Ativo_Colaborador'];
					$data['anterior'] = $this->Colaborador_model->get_colaborador($data['query']['idApp_Colaborador']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Colaborador'], TRUE);

					if ($data['auditoriaitem'] && $this->Colaborador_model->update_colaborador($data['query'], $data['query']['idApp_Colaborador']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'colaborador/form_colaborador/' . $data['query']['idApp_Colaborador'] . $data['msg']);
						exit();
					} else {

						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/colaborador.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . '');						
						}
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/colaborador.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . '');						
						}						
						
						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Colaborador', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'relatorio/colaborador/' . $data['msg']);
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

			if ($id) {
				$_SESSION['Colaborador'] = $this->Colaborador_model->get_colaborador($id, TRUE);
			}		
			$this->Colaborador_model->delete_colaborador($id);

			$data['msg'] = '?m=1';
			
			if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . ''))
				&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . '')
				!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/colaborador.jpg'))){
				unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . '');						
			}
			if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . ''))
				&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . '')
				!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/colaborador.jpg'))){
				unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Colaborador']['Arquivo_Colaborador'] . '');						
			}
			
			redirect(base_url() . 'relatorio/colaborador/' . $data['msg']);
			exit();

        $this->load->view('basico/footer');
    }
	
}
