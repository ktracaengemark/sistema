<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario2 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Cliente_model', 'Usuario_model'));
        #$this->load->model(array('Basico_model', 'Usuario_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('usuario/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['Empresa']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
			
			$this->load->view('usuario/tela_index', $data);
		
		}
        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['Empresa']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
			
			if (!$id) {
					
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}else{		
				
				$data['query'] = $this->Usuario_model->get_usuario_verificacao($id, TRUE);
			
				if($data['query'] === FALSE){
					
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {

					$data['titulo'] = 'Prontuário ' . $data['query']['Nome'];
					$data['panel'] = 'primary';
					$data['metodo'] = 4;

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
					$data['query']['Inativo'] = $this->Basico_model->get_inativo($data['query']['Inativo']);
					$data['query']['Funcao'] = $this->Basico_model->get_funcao($data['query']['Funcao']);
					$data['query']['Permissao'] = $this->Basico_model->get_permissao($data['query']['Permissao']);
					$data['query']['idSis_Empresa'] = $this->Basico_model->get_empresa($data['query']['idSis_Empresa']);
					#$data['query']['Usuario'] = $data['query']['Usuario'];
					$data['query']['CompAgenda'] = $this->Basico_model->get_compagenda($data['query']['CompAgenda']);
					$data['query']['Telefone'] = $data['query']['CelularUsuario'];
					$data['query']['CpfUsuario'] = $data['query']['CpfUsuario'];

					$data['contatousuario'] = $this->Usuario_model->lista_contatousuario($id, TRUE);
					/*
					  echo "<pre>";
					  print_r($data['contatousuario']);
					  echo "</pre>";
					  exit();
					  */
					if (!$data['contatousuario'])
						$data['list'] = FALSE;
					else
						$data['list'] = $this->load->view('usuario/list_contatousuario', $data, TRUE);

					$data['nav_secundario'] = $this->load->view('usuario/nav_secundario2', $data, TRUE);
					
					$this->load->view('usuario/tela_usuario2', $data);
				}
			}
			
		}
        $this->load->view('basico/footer');
    }

    public function alterarconta($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['Empresa']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
			
			$data['query'] = $this->input->post(array(
				'idSis_Usuario',
				'Banco',
				'Agencia',
				'Conta',
			), TRUE);

			if ($id) {
				$data['query'] = $this->Usuario_model->get_usuario_verificacao($id);
		
				if($data['query'] === FALSE){
					
					unset($_SESSION['Query']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}
			}
		
			if(!$data['query']['idSis_Usuario']){
				
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {

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

				$data['titulo'] = 'Editar Conta';
				$data['form_open_path'] = 'usuario2/alterarconta';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				if ($data['query']['Agencia'] || $data['query']['Conta'])
					$data['collapse'] = '';
				else
					$data['collapse'] = 'class="collapse"';

				$data['nav_secundario'] = $this->load->view('usuario/nav_secundario2', $data, TRUE);

				$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
				$data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				
				$this->form_validation->set_rules('Conta', 'Chave Pix / Conta', 'trim');

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('usuario/form_usuarioconta', $data);
				} else {

					$data['anterior'] = $this->Usuario_model->get_usuario_verificacao($data['query']['idSis_Usuario']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

					if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
						$data['msg'] = '?m=1';
						
						redirect(base_url() . 'usuario2/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'usuario2/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
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
		
		if ($_SESSION['Empresa']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
			
			$data['query'] = $this->input->post(array(
				'idSis_Usuario',
			), TRUE);
			
			$data['file'] = $this->input->post(array(
				'idSis_Usuario',
				'Arquivo',
			), TRUE);

			if ($id) {
				$_SESSION['Query'] = $data['query'] = $this->Usuario_model->get_usuario_verificacao($id, TRUE);
		
				if($data['query'] === FALSE){
					
					unset($_SESSION['Query']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
					$data['file']['idSis_Usuario'] = $id;
				}
			}
		
			if(!$data['query']['idSis_Usuario'] || !$_SESSION['Query']){
				
				unset($_SESSION['Query']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {

				$data['titulo'] = 'Alterar Foto';
				$data['form_open_path'] = 'usuario2/alterarlogo';
				$data['readonly'] = 'readonly';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				$data['nav_secundario'] = $this->load->view('usuario/nav_secundario2', $data, TRUE);
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
					
					$data['file']['Arquivo'] = $this->basico->renomeiausuario($_FILES['Arquivo']['name']);
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
				} else {
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
				}

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					#load login view
					$this->load->view('usuario/form_perfil2', $data);
				} else {
					
					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
						
						$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/';
						$config['max_size'] = 1000;
						$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
						$config['file_name'] = $data['file']['Arquivo'];

						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('Arquivo')) {
							$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
							$this->load->view('usuario/form_perfil2', $data);
						} else {

							$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/';		
							$foto = $data['file']['Arquivo'];
							$diretorio = $dir.$foto;					
							$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/';

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
							$data['idSis_Arquivo'] = $this->Usuario_model->set_arquivo($data['file']);

							if ($data['idSis_Arquivo'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
								$this->basico->erro($msg);
								$this->load->view('usuario/form_perfil2', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
								
								$data['query']['Arquivo'] = $data['file']['Arquivo'];
								$data['anterior'] = $this->Usuario_model->get_usuario_verificacao($data['query']['idSis_Usuario']);
								$data['campos'] = array_keys($data['query']);

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

								if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
									$data['msg'] = '?m=2';
									redirect(base_url() . 'usuario/form_perfil2/' . $data['query']['idSis_Usuario'] . $data['msg']);
									exit();
								} else {

									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/' . $_SESSION['Usuario']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/' . $_SESSION['Usuario']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/SuaFoto.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/original/' . $_SESSION['Usuario']['Arquivo'] . '');						
									}
									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['Usuario']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['Usuario']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/SuaFoto.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['Usuario']['Arquivo'] . '');						
									}						
									
									if ($data['auditoriaitem'] === FALSE) {
										$data['msg'] = '';
									} else {
										$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
										$data['msg'] = '?m=1';
									}
									
									unset($_SESSION['Query']);
									redirect(base_url() . 'usuario2/prontuario/' . $data['file']['idSis_Usuario'] . $data['msg']);
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
	
    public function revendedores($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		if ($_SESSION['Empresa']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
						
			if (!$id) {
					
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}else{		
				
				$data['query'] = $this->Usuario_model->get_usuario_verificacao($id, TRUE);

				if($data['query'] === FALSE){
					
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {

					$data['revendedor'] = $this->Usuario_model->lista_revendedor($id, TRUE);
					/*
					  echo "<pre>";
					  print_r($data['revendedor']);
					  echo "</pre>";
					  exit();
					 */
					if (!$data['revendedor'])
						$data['list'] = FALSE;
					else
						$data['list'] = $this->load->view('usuario/list_revendedores', $data, TRUE);
					
					
					$data['titulo'] = 'Revendedor';
					
					$data['nav_secundario'] = $this->load->view('usuario/nav_secundario2', $data, TRUE);

					$this->load->view('usuario/tela_revendedores', $data);
				}
			}
		}
        $this->load->view('basico/footer');
    }

    function get_usuario($data) {

        if ($this->Usuario_model->lista_usuario($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_usuario', '<strong>Usuario</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
