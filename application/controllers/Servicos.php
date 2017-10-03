<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Servicos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Servicos_model', 'Convenio_model', 'Fornecedor_model', 'Formapag_model'));
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

        $this->load->view('servicos/tela_index', $data);

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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['servicos'] = quotes_to_entities($this->input->post(array(
            #### App_Servicos ####
            'idApp_Servicos',           
            'TipoProduto',
			'UnidadeProduto',
			'CodServ',
			'Fornecedor',
			#'ValorCompraServico',
            'Servicos',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.
      
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

		(!$data['servicos']['TipoProduto']) ? $data['servicos']['TipoProduto'] = 'V' : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Convenio' . $i) || $this->input->post('ValorVendaServico' . $i)) {

                $data['valor'][$j]['Convenio'] = $this->input->post('Convenio' . $i);
                $data['valor'][$j]['ValorVendaServico'] = $this->input->post('ValorVendaServico' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Servicos ####

        $this->form_validation->set_rules('TipoProduto', 'TipoProduto', 'required|trim');

		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
        $data['select']['Convenio'] = $this->Convenio_model->select_convenio();

        $data['titulo'] = 'Cadastar Produto';
        $data['form_open_path'] = 'servicos/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['valor'][0]['DataValor'] || $data['valor'][0]['Convenio'])
        if (isset($data['valor']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

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
            //if (1 == 1) {
            $this->load->view('servicos/form_servicos', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Servicos ####

			$data['servicos']['Empresa'] = $_SESSION['log']['Empresa'];            
            $data['servicos']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['servicos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['servicos']['idApp_Servicos'] = $this->Servicos_model->set_servicos($data['servicos']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### App_ValorServ ####
            if (isset($data['valor'])) {
                $max = count($data['valor']);
                for($j=1;$j<=$max;$j++) {
                    $data['valor'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['valor'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['valor'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
                    $data['valor'][$j]['idApp_Servicos'] = $data['servicos']['idApp_Servicos'];					

                }
                $data['valor']['idApp_ValorServ'] = $this->Servicos_model->set_valor($data['valor']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_Servicos'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('servicos/form_servicos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Servicos'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Servicos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'servicos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/servicos/' . $data['msg']);
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['servicos'] = quotes_to_entities($this->input->post(array(
            #### App_Servicos ####
            'idApp_Servicos',			
            'TipoProduto',
			'UnidadeProduto',
			'CodServ',
			'Fornecedor',
			#'ValorCompraServico',            
            'Servicos',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Convenio' . $i) || $this->input->post('ValorVendaServico' . $i)) {
                $data['valor'][$j]['idApp_ValorServ'] = $this->input->post('idApp_ValorServ' . $i);
                $data['valor'][$j]['Convenio'] = $this->input->post('Convenio' . $i);
                $data['valor'][$j]['ValorVendaServico'] = $this->input->post('ValorVendaServico' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_Servicos ####
            $data['servicos'] = $this->Servicos_model->get_servicos($id);
           
            #### Carrega os dados do cliente nas variáves de sessão ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['servicos']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_ValorServ ####
            $data['valor'] = $this->Servicos_model->get_valor($id);
            if (count($data['valor']) > 0) {
                $data['valor'] = array_combine(range(1, count($data['valor'])), array_values($data['valor']));
                $data['count']['PTCount'] = count($data['valor']);
/*
                if (isset($data['valor'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
*/				
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Servicos ####
     
        $this->form_validation->set_rules('TipoProduto', 'TipoProduto', 'required|trim');
     
		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Convenio'] = $this->Convenio_model->select_convenio();
        

        $data['titulo'] = 'Editar Produto';
        $data['form_open_path'] = 'servicos/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['valor']) && ($data['valor'][0]['DataValor'] || $data['valor'][0]['Convenio']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

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
            $this->load->view('servicos/form_servicos', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Servicos ####

			$data['servicos']['Empresa'] = $_SESSION['log']['Empresa'];             
            $data['servicos']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['servicos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['servicos']['anterior'] = $this->Servicos_model->get_servicos($data['servicos']['idApp_Servicos']);
            $data['update']['servicos']['campos'] = array_keys($data['servicos']);
            $data['update']['servicos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['servicos']['anterior'],
                $data['servicos'],
                $data['update']['servicos']['campos'],
                $data['servicos']['idApp_Servicos'], TRUE);
            $data['update']['servicos']['bd'] = $this->Servicos_model->update_servicos($data['servicos'], $data['servicos']['idApp_Servicos']);

            #### App_ValorServ ####
            $data['update']['valor']['anterior'] = $this->Servicos_model->get_valor($data['servicos']['idApp_Servicos']);
            if (isset($data['valor']) || (!isset($data['valor']) && isset($data['update']['valor']['anterior']) ) ) {

                if (isset($data['valor']))
                    $data['valor'] = array_values($data['valor']);
                else
                    $data['valor'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idApp_ValorServ');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['valor']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['update']['valor']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['valor']['inserir'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
                    $data['update']['valor']['inserir'][$j]['idApp_Servicos'] = $data['servicos']['idApp_Servicos'];

					
                }

                $max = count($data['update']['valor']['alterar']);
                for($j=0;$j<$max;$j++) {

                }

                if (count($data['update']['valor']['inserir']))
                    $data['update']['valor']['bd']['inserir'] = $this->Servicos_model->set_valor($data['update']['valor']['inserir']);

                if (count($data['update']['valor']['alterar']))
                    $data['update']['valor']['bd']['alterar'] =  $this->Servicos_model->update_valor($data['update']['valor']['alterar']);

                if (count($data['update']['valor']['excluir']))
                    $data['update']['valor']['bd']['excluir'] = $this->Servicos_model->delete_valor($data['update']['valor']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_Servicos'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['servicos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('servicos/form_servicos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Servicos'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Servicos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'servicos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/servicos/' . $data['msg']);
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
        
                $this->Servicos_model->delete_servicos($id);

                $data['msg'] = '?m=1';

                #redirect(base_url() . 'servicos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/servicos/' . $data['msg']);
                exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

    public function listar($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Servicos'] = $this->Servicos_model->get_cliente($id, TRUE);
        //$_SESSION['Servicos']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Servicos_model->list_servicos($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Servicos_model->list_servicos($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('servicos/list_servicos', $data, TRUE);
       # $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('servicos/tela_servicos', $data);

        $this->load->view('basico/footer');
    }

    public function listarBKP($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Servicos'] = $this->Servicos_model->get_cliente($id, TRUE);
        #$_SESSION['Servicos']['idApp_Cliente'] = $id;
        $data['query'] = $this->Servicos_model->list_servicos(TRUE, TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('servicos/list_servicos', $data, TRUE);

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('servicos/tela_servicos', $data);

        $this->load->view('basico/footer');
    }

}
