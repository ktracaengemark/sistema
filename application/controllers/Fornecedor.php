<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Fornecedor extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Fornecedor_model', 'Atividade_model', 'Contatofornec_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('fornecedor/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('fornecedor/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Fornecedor',
            'NomeFornecedor',
            'DataNascimento',
            'Atividade',
            'Telefone1',
            'Telefone2',
            'Telefone3',
            'Ativo',
            'Sexo',
            'Endereco',
            'Bairro',
            'Municipio',
			
            'Obs',
			'Email',
            'idSis_Usuario',
            
            'Cnpj',
			'TipoFornec',
			'VendaFornec',
        ), TRUE));

		(!$data['query']['TipoFornec']) ? $data['query']['TipoFornec'] = 'P' : FALSE;
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeFornecedor', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Fornecedor.NomeFornecedor.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('NomeFornecedor', 'Nome do Responsável', 'required|trim');
        #$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
        #$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		#$this->form_validation->set_rules('Atividade', 'Atividade', 'required|trim');
		
        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Atividade'] = $this->Atividade_model->select_atividade();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		$data['select']['VendaFornec'] = $this->Basico_model->select_status_sn();
		$data['select']['TipoFornec'] = $this->Basico_model->select_tipofornec();
		
		
        $data['titulo'] = 'Cadastrar Fornecedor';
        $data['form_open_path'] = 'fornecedor/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        
        if ($data['query']['Sexo'] || $data['query']['Endereco'] || $data['query']['Bairro'] || 
                $data['query']['Municipio'] || $data['query']['Obs'] || $data['query']['Email'] || $data['query']['Cnpj'])
            $data['collapse'] = '';
        else 
            $data['collapse'] = 'class="collapse"';            
        
        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';        

        $data['tela'] = $this->load->view('fornecedor/form_fornecedor', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('fornecedor/form_fornecedor', $data);        
        } else {

            $data['query']['NomeFornecedor'] = trim(mb_strtoupper($data['query']['NomeFornecedor'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
            $data['query']['TipoFornec'] = $data['query']['TipoFornec'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['query']['Empresa'] = $_SESSION['log']['Empresa'];
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Fornecedor'] = $this->Fornecedor_model->set_fornecedor($data['query']);

            if ($data['idApp_Fornecedor'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('fornecedor/form_fornecedor', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Fornecedor'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Fornecedor', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'fornecedor/prontuario/' . $data['idApp_Fornecedor'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_Fornecedor',
            'NomeFornecedor',
            'DataNascimento',
            'Atividade',
            'Telefone1',
            'Telefone2',
            'Telefone3',
            'Ativo',
            'Sexo',
            'Endereco',
            'Bairro',
            'Municipio',
			
            'Obs',
            'idSis_Usuario',
            'Email',
            'Cnpj',
			'TipoFornec',
			'VendaFornec',
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Fornecedor_model->get_fornecedor($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
        }

        #(!$data['query']['TipoFornec']) ? $data['query']['TipoFornec'] = 'P' : FALSE;
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeFornecedor', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Fornecedor.NomeFornecedor.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('NomeFornecedor', 'Nome do Responsável', 'required|trim');
        #$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
        #$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
        #$this->form_validation->set_rules('Atividade', 'Atividade', 'required|trim'); 
		
        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Atividade'] = $this->Atividade_model->select_atividade();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		$data['select']['VendaFornec'] = $this->Basico_model->select_status_sn();
		$data['select']['TipoFornec'] = $this->Basico_model->select_tipofornec();
		
        $data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'fornecedor/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        
        if ($data['query']['Sexo'] || $data['query']['Endereco'] || $data['query']['Bairro'] || 
                $data['query']['Municipio'] || $data['query']['Obs'] || $data['query']['Email'] || $data['query']['Cnpj'])
            $data['collapse'] = '';
        else 
            $data['collapse'] = 'class="collapse"';        

        $data['nav_secundario'] = $this->load->view('fornecedor/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';
        
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('fornecedor/form_fornecedor', $data);
        } else {

            $data['query']['NomeFornecedor'] = trim(mb_strtoupper($data['query']['NomeFornecedor'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
            $data['query']['TipoFornec'] = $data['query']['TipoFornec'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];          

            $data['anterior'] = $this->Fornecedor_model->get_fornecedor($data['query']['idApp_Fornecedor']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Fornecedor'], TRUE);

            if ($data['auditoriaitem'] && $this->Fornecedor_model->update_fornecedor($data['query'], $data['query']['idApp_Fornecedor']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'fornecedor/form_fornecedor/' . $data['query']['idApp_Fornecedor'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Fornecedor', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'fornecedor/prontuario/' . $data['query']['idApp_Fornecedor'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function excluir2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_Fornecedor',
            'submit'
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Fornecedor_model->get_fornecedor($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $data['query']['FornecedorDataNascimento'] = $this->basico->mascara_data($data['query']['FornecedorDataNascimento'], 'barras');
        }

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        $data['titulo'] = 'Tem certeza que deseja excluir o registro abaixo?';
        $data['form_open_path'] = 'fornecedor/excluir';
        $data['readonly'] = 'readonly';
        $data['disabled'] = 'disabled';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;

        $data['tela'] = $this->load->view('fornecedor/form_fornecedor', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('fornecedor/tela_fornecedor', $data); 
        } else {

            if ($data['query']['idApp_Fornecedor'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('fornecedor/form_fornecedor', $data);
            } else {

                $data['anterior'] = $this->Fornecedor_model->get_fornecedor($data['query']['idApp_Fornecedor']);
                $data['campos'] = array_keys($data['anterior']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idApp_Fornecedor'], FALSE, TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Fornecedor', 'DELETE', $data['auditoriaitem']);

                $this->Fornecedor_model->delete_fornecedor($data['query']['idApp_Fornecedor']);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'fornecedor' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
	public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

                $this->Fornecedor_model->delete_fornecedor($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_fornecedor');
        
        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);            
        }
        
        $data['titulo'] = "Pesquisar Fornecedor";
        
        $data['Pesquisa'] = $this->input->post('Pesquisa');
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));
        
        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Fornecedor_model->lista_fornecedor($data['Pesquisa'], FALSE) === TRUE) {

            $data['query'] = $this->Fornecedor_model->lista_fornecedor($data['Pesquisa'], TRUE);
            
            if ($data['query']->num_rows() == 1) {
                $info = $data['query']->result_array();
                
                if ($_SESSION['agenda']) 
                    redirect('consulta/cadastrar/' . $info[0]['idApp_Fornecedor'] );
                else
                    redirect('fornecedor/prontuario/' . $info[0]['idApp_Fornecedor'] );
                
                exit();
            } else {
                $data['list'] = $this->load->view('fornecedor/list_fornecedor', $data, TRUE);
            }
           
        }
       
        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('fornecedor/pesq_fornecedor', $data);

        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Fornecedor'] = $data['query'] = $this->Fornecedor_model->get_fornecedor($id, TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' . $data['query']['NomeFornecedor'];
        $data['panel'] = 'primary';
        $data['metodo'] = 4;
        
        $_SESSION['log']['idApp_Fornecedor'] = $data['resumo']['idApp_Fornecedor'] = $data['query']['idApp_Fornecedor'];
        $data['resumo']['NomeFornecedor'] = $data['query']['NomeFornecedor'];

        $data['query']['Idade'] = $this->basico->calcula_idade($data['query']['DataNascimento']);
        $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
        
        if ($data['query']['Sexo'] == 1)
            $data['query']['profile'] = 'm';
        elseif ($data['query']['Sexo'] == 2)
            $data['query']['profile'] = 'f';
        else
            $data['query']['profile'] = 'o';
        
        $data['query']['Sexo'] = $this->Basico_model->get_sexo($data['query']['Sexo']);
		
		$data['query']['Atividade'] = $this->Basico_model->get_atividade($data['query']['Atividade']);
		$data['query']['TipoFornec'] = $this->Basico_model->get_tipofornec($data['query']['TipoFornec']);
		$data['query']['VendaFornec'] = $this->Basico_model->get_vendafornec($data['query']['VendaFornec']);
		$data['query']['Ativo'] = $this->Basico_model->get_ativo($data['query']['Ativo']);
		
        $data['query']['Telefone'] = $data['query']['Telefone1'];
        ($data['query']['Telefone2']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone2'] : FALSE;
        ($data['query']['Telefone3']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone3'] : FALSE;
        
        
        if ($data['query']['Municipio']) {
            $mun = $this->Basico_model->get_municipio($data['query']['Municipio']);
            $data['query']['Municipio'] = $mun['NomeMunicipio'] . '/' . $mun['Uf'];
        } else {
            $data['query']['Municipio'] = $data['query']['Uf'] = $mun['Uf'] = '';
        }

        $data['contatofornec'] = $this->Contatofornec_model->lista_contatofornec(TRUE);
        /*
          echo "<pre>";
          print_r($data['contatofornec']);
          echo "</pre>";
          exit();
        */
        if (!$data['contatofornec'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('contatofornec/list_contatofornec', $data, TRUE);
        
        $data['nav_secundario'] = $this->load->view('fornecedor/nav_secundario', $data, TRUE);     
        $this->load->view('fornecedor/tela_fornecedor', $data);

        $this->load->view('basico/footer');
    }

    function get_fornecedor($data) {

        if ($this->Fornecedor_model->lista_fornecedor($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_fornecedor', '<strong>Fornecedor</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
