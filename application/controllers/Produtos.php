<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Produtos_model', 'Convenio_model', 'Fornecedor_model', 'Formapag_model'));
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

        $this->load->view('produtos/tela_index', $data);

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
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produtos ####
            'idTab_Produtos',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'ValorCompraProduto',
            'Produtos',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.
      
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Convenio' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorVendaProduto' . $i)) {

                $data['valor'][$j]['Convenio'] = $this->input->post('Convenio' . $i);
				$data['valor'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['valor'][$j]['ValorVendaProduto'] = $this->input->post('ValorVendaProduto' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produtos ####

		$this->form_validation->set_rules('Produtos', 'Produto ou Serviço', 'required|trim');        
		$this->form_validation->set_rules('TipoProduto', 'TipoProduto', 'required|trim');
		$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Produtos.CodProd]');

		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();		
        $data['select']['Convenio'] = $this->Convenio_model->select_convenio();
		$data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();

        $data['titulo'] = 'Cadastar Produtos & Serviços';
        $data['form_open_path'] = 'produtos/cadastrar';
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
            $this->load->view('produtos/form_produtos', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produtos ####

			$data['produtos']['Empresa'] = $_SESSION['log']['Empresa'];            
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['produtos']['idTab_Produtos'] = $this->Produtos_model->set_produtos($data['produtos']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### Tab_Valor ####
            if (isset($data['valor'])) {
                $max = count($data['valor']);
                for($j=1;$j<=$max;$j++) {
                    $data['valor'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['valor'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['valor'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
                    $data['valor'][$j]['idTab_Produtos'] = $data['produtos']['idTab_Produtos'];					

                }
                $data['valor']['idTab_Valor'] = $this->Produtos_model->set_valor($data['valor']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idTab_Produtos'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
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
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produtos ####
            'idTab_Produtos',			
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'ValorCompraProduto',            
            'Produtos',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Convenio' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorVendaProduto' . $i)) {
                $data['valor'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
                $data['valor'][$j]['Convenio'] = $this->input->post('Convenio' . $i);
				$data['valor'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['valor'][$j]['ValorVendaProduto'] = $this->input->post('ValorVendaProduto' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Tab_Produtos ####
            $data['produtos'] = $this->Produtos_model->get_produtos($id);
           
            #### Carrega os dados do cliente nas variáves de sessão ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['produtos']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### Tab_Valor ####
            $data['valor'] = $this->Produtos_model->get_valor($id);
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

        #### Tab_Produtos ####

		$this->form_validation->set_rules('Produtos', 'Produto ou Serviço', 'required|trim'); 		
        $this->form_validation->set_rules('TipoProduto', 'TipoProduto', 'required|trim');
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Produtos.CodProd]');
     
		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		$data['select']['Convenio'] = $this->Convenio_model->select_convenio();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();

        $data['titulo'] = 'Editar Produtos & Serviços';
        $data['form_open_path'] = 'produtos/alterar';
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
            $this->load->view('produtos/form_produtos', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produtos ####

			$data['produtos']['Empresa'] = $_SESSION['log']['Empresa'];             
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produtos']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produtos'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produtos']);

            #### Tab_Valor ####
            $data['update']['valor']['anterior'] = $this->Produtos_model->get_valor($data['produtos']['idTab_Produtos']);
            if (isset($data['valor']) || (!isset($data['valor']) && isset($data['update']['valor']['anterior']) ) ) {

                if (isset($data['valor']))
                    $data['valor'] = array_values($data['valor']);
                else
                    $data['valor'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['valor']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['id'];
                    $data['update']['valor']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['valor']['inserir'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
                    $data['update']['valor']['inserir'][$j]['idTab_Produtos'] = $data['produtos']['idTab_Produtos'];

					
                }

                $max = count($data['update']['valor']['alterar']);
                for($j=0;$j<$max;$j++) {

                }

                if (count($data['update']['valor']['inserir']))
                    $data['update']['valor']['bd']['inserir'] = $this->Produtos_model->set_valor($data['update']['valor']['inserir']);

                if (count($data['update']['valor']['alterar']))
                    $data['update']['valor']['bd']['alterar'] =  $this->Produtos_model->update_valor($data['update']['valor']['alterar']);

                if (count($data['update']['valor']['excluir']))
                    $data['update']['valor']['bd']['excluir'] = $this->Produtos_model->delete_valor($data['update']['valor']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Produtos'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
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
        
                $this->Produtos_model->delete_produtos($id);

                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
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


        //$_SESSION['Produtos'] = $this->Produtos_model->get_cliente($id, TRUE);
        //$_SESSION['Produtos']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Produtos_model->list_produtos($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Produtos_model->list_produtos($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);
       # $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('produtos/tela_produtos', $data);

        $this->load->view('basico/footer');
    }

    public function listarBKP($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Produtos'] = $this->Produtos_model->get_cliente($id, TRUE);
        #$_SESSION['Produtos']['idApp_Cliente'] = $id;
        $data['query'] = $this->Produtos_model->list_produtos(TRUE, TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('produtos/tela_produtos', $data);

        $this->load->view('basico/footer');
    }

}
