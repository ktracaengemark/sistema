<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Contatousuario extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Contatousuario_model', 'Relacao_model', 'Usuario_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

        #$this->load->view('contatousuario/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('contatousuario/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            //'idApp_ContatoUsuario',
            'idSis_Empresa',			
            'NomeContatoUsuario',
            'StatusVida',
			'Ativo',
            'DataNascimento',
            'Sexo',
			'Relacao',
			'TelefoneContatoUsuario',
            'Obs',
            'idSis_Usuario',
			'QuemCad',
			), TRUE));

        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVida']='V';

		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contatousuario_model->select_status_vida();
		$data['select']['Relacao'] = $this->Relacao_model->select_relacao();
        $data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Cadastrar Contato';
        $data['form_open_path'] = 'contatousuario/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContatoUsuario', 'Nome do Respons�vel', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContatoUsuario', 'TelefoneContatoUsuario', 'required|trim');
        $this->form_validation->set_rules('Relacao', 'Relacao', 'required|trim'); 
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatousuario/form_contatousuario', $data);
        } else {

            $data['query']['NomeContatoUsuario'] = trim(mb_strtoupper($data['query']['NomeContatoUsuario'], 'ISO-8859-1'));
 			if(!isset($data['query']['DataNascimento']) || $data['query']['DataNascimento'] == ''){
				$data['query']['DataNascimento'] = "0000-00-00";
			}else{
				$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			}
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['query']['QuemCad'] = $_SESSION['log']['idSis_Usuario'];
			$data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['query']['idApp_ContatoUsuario'] = $this->Contatousuario_model->set_contatousuario($data['query']);

            if ($data['query']['idApp_ContatoUsuario'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('contatousuario/form_contatousuario', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ContatoUsuario'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoUsuario', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'contatousuario/pesquisar/' . $_SESSION['QueryUsuario']['idSis_Usuario'] . $data['msg']);
                #redirect(base_url() . 'usuario/prontuario/' . $_SESSION['QueryUsuario']['idSis_Usuario'] . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_ContatoUsuario',
            'idSis_Empresa',
            'NomeContatoUsuario',
            'StatusVida',
            'DataNascimento',
            'Sexo',
			'Relacao',
            'TelefoneContatoUsuario',
            'Obs',
            'idSis_Usuario',
			'Ativo',
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Contatousuario_model->get_contatousuario($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $_SESSION['log']['idApp_ContatoUsuario'] = $id;
        }

		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contatousuario_model->select_status_vida();
        $data['select']['Relacao'] = $this->Relacao_model->select_relacao();
        $data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'contatousuario/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContatoUsuario', 'Nome do Respons�vel', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContatoUsuario', 'TelefoneContatoUsuario', 'required|trim');
        $this->form_validation->set_rules('Relacao', 'Relacao', 'required|trim');
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatousuario/form_contatousuario', $data);
        } else {

            $data['query']['NomeContatoUsuario'] = trim(mb_strtoupper($data['query']['NomeContatoUsuario'], 'ISO-8859-1'));
 			if(!isset($data['query']['DataNascimento']) || $data['query']['DataNascimento'] == ''){
				$data['query']['DataNascimento'] = "0000-00-00";
			}else{
				$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			}
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
            $data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa']; 
			$data['query']['idApp_ContatoUsuario'] = $_SESSION['log']['idApp_ContatoUsuario'];

            $data['anterior'] = $this->Contatousuario_model->get_contatousuario($data['query']['idApp_ContatoUsuario']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ContatoUsuario'], TRUE);

            if ($data['auditoriaitem'] && $this->Contatousuario_model->update_contatousuario($data['query'], $data['query']['idApp_ContatoUsuario']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'usuario/prontuario/' . $_SESSION['QueryUsuario']['idSis_Usuario'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoUsuario', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'contatousuario/pesquisar/' . $_SESSION['QueryUsuario']['idSis_Usuario'] . $data['msg']);
				#redirect(base_url() . 'usuario/prontuario/' . $_SESSION['QueryUsuario']['idSis_Usuario'] . $data['msg']);
                exit();
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

                $this->Contatousuario_model->delete_contatousuario($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'contatousuario/pesquisar/' . $_SESSION['QueryUsuario']['idSis_Usuario'] . $data['msg']);
				exit();


        $this->load->view('basico/footer');
    }
	
    public function pesquisar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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

        $_SESSION['QueryUsuario'] = $this->Usuario_model->get_usuario($id, TRUE);
        
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        $data['query'] = $this->Contatousuario_model->lista_contatousuario(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('contatousuario/list_contatousuario', $data, TRUE);
        
        
		$data['titulo'] = 'Contatos';
        
		$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

        $this->load->view('contatousuario/tela_contatousuario', $data);

        $this->load->view('basico/footer');
    }

}
