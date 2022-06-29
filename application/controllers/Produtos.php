<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Produtos_model', 'Fornecedor_model', 'Fornecedor_model', 'Formapag_model', 'Relatorio_model'));
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
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar o Novo Produto.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da<br>Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'TipoCatprod',
        ), TRUE));		

        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produtos ####
            //'idTab_Produtos',  
            'idTab_Catprod',
        ), TRUE));

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
		$data['select']['TipoCatprod'] = $this->Basico_model->select_prod_serv();	
		$data['select']['idTab_Catprod'] = $this->Basico_model->select_catprod();
		
        $data['titulo'] = 'Cadastrar Categoria';
        $data['form_open_path'] = 'produtos/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		

        
		$data['q1'] = $this->Produtos_model->list_categoria($_SESSION['log'], TRUE);
		$data['list1'] = $this->load->view('produtos/list_categoria', $data, TRUE);		
		
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('idTab_Catprod', 'Categoria', 'required|trim');		
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Produto.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');	
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

			if($this->Basico_model->get_dt_validade() === FALSE){
				$data['msg'] = '?m=3';
				redirect(base_url() . 'produtos/cadastrar' . $data['msg']);
				
			} else {
							
				$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
				////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
				#### Tab_Produtos ####
				$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
				$data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
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

				if ($data['produtos']['idTab_Produtos'] === FALSE) {
					$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

					$this->basico->erro($msg);
					$this->load->view('produtos/form_produtos', $data);
				} else {

					//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
					//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
					$data['msg'] = '?m=1';

					redirect(base_url() . 'produtos/alterar/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
					exit();
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
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar as alterações.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'Cadastrar',
				'TipoCatprod',
				'idCat_Atributo',
				'idCat_Opcao',
				'idAtributo_Opcao',
				'idCat_Produto',
				'Codigo',
				'VendaSite_Cadastrar',
				'VendaSite_Alterar',
			), TRUE));	
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['produtos'] = quotes_to_entities($this->input->post(array(
				#### Tab_Produtos ####
				'idTab_Produtos',			
				'idTab_Catprod', 
				'idTab_Produto',
				'Opcao_Atributo_1',
				'Opcao_Atributo_2', 
				'Cod_Prod', 
				'Nome_Prod',
				'Cod_Barra',
				'Estoque',
				'ContarEstoque',
				'Produtos_Descricao',
			), TRUE));


			if ($id) {
				
				#### Tab_Produtos ####
			   $_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
				
				if($data['produtos'] === FALSE){
					
					unset($_SESSION['Produtos']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}
			}

			if(!$data['produtos']['idTab_Produtos'] || !$_SESSION['Produtos']){
				
				unset($_SESSION['Produtos']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				#### Busca Se o produto já foi usado###
				$data['usado'] = $this->Produtos_model->get_app_produto($_SESSION['Produtos']);
				if (isset($data['usado'])){
					$max_produto = count($data['usado']);
					if($max_produto >= 1){
						$data['usado']['produto'] = "S";
					}else{
						$data['usado']['produto'] = "N";
					}
				}
				#### Busca Se o produto pertence a promoções###
				$data['promocao'] = $this->Produtos_model->get_tab_valor($_SESSION['Produtos']);
				if (isset($data['promocao'])){
					$max_promocao = count($data['promocao']);
					if($max_promocao >= 1){
						$data['promocao']['produto'] = "S";
					}else{
						$data['promocao']['produto'] = "N";
					}
				}	
				
				/*
				echo '<br>';
				echo "<pre>";
				print_r($max_produto);
				echo '<br>';
				print_r($data['usado']['produto']);
				echo '<br>';
				print_r($max_promocao);
				echo '<br>';
				print_r($data['promocao']['produto']);
				echo "</pre>";
				*/
				#### Tab_Atributo_Select ####
				$_SESSION['Atributo'] = $data['atributo'] = $this->Produtos_model->get_atributos($_SESSION['Produtos']['idTab_Catprod']);
				
				$data['Conta_Atributos'] = count($data['atributo']);
				if (count($data['atributo']) > 0) {
					$data['atributo'] = array_combine(range(1, count($data['atributo'])), array_values($data['atributo']));
					
					/*
					echo '<br>';
					  echo "<pre>";
					  print_r($data['Conta_Atributos']);
					  echo '<br>';
					  echo "</pre>";
					 */ 
					if (isset($data['atributo'])) {
						if ($data['Conta_Atributos'] >= 2) {
							for($j=1; $j <= $data['Conta_Atributos']; $j++){
								$_SESSION['Atributo'][$j]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
								$_SESSION['Atributo'][$j]['Atributo'] = $data['atributo'][$j]['Atributo'];
								/*
								  echo '<br>';
								  echo "<pre>";
								  //print_r($data['Conta_Atributos']);
								  echo '<br>';
								  print_r($_SESSION['Atributo'][$j]['idTab_Atributo']);
								  echo '<br>';
								  print_r($_SESSION['Atributo'][$j]['Atributo']);
								  echo "</pre>";					
								*/
							}
						}else{
							for($j=1; $j <= $data['Conta_Atributos']; $j++){
								$_SESSION['Atributo'][1]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
								$_SESSION['Atributo'][1]['Atributo'] = $data['atributo'][$j]['Atributo'];
							}
							$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
							$_SESSION['Atributo'][2]['Atributo'] = FALSE;
						}
					}
					/*
					$item_atributo = 1;	
					foreach($data['atributo'] as $atributo_view){
						$_SESSION['Atributo'][$item_atributo]['idTab_Atributo'] = $atributo_view['idTab_Atributo'];
						$_SESSION['Atributo'][$item_atributo]['Atributo'] = $atributo_view['Atributo'];
						$item_atributo++;
					}
					*/
					
				}else{
					$_SESSION['Atributo'][1]['idTab_Atributo'] = FALSE;
					$_SESSION['Atributo'][1]['Atributo'] = FALSE;
					$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
					$_SESSION['Atributo'][2]['Atributo'] = FALSE;
				}		
				
				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($_SESSION['Produtos']);
				  echo "</pre>";
				  exit ();
				 */
				//$data['cadastrar']['Codigo'] = $data['produtos']['idTab_Catprod'] . ':' . $data['produtos']['idTab_Produto'] . ':' . $data['produtos']['Opcao_Atributo_1'] . ':' . $data['produtos']['Opcao_Atributo_2'];
				  
				

				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
				$data['select']['ContarEstoque'] = $this->Basico_model->select_status_sn();	
				$data['select']['TipoCatprod'] = $this->Basico_model->select_prod_serv();
				$data['select']['idCat_Atributo'] = $this->Basico_model->select_catprod();
				$data['select']['idCat_Opcao'] = $this->Basico_model->select_catprod();
				$data['select']['idAtributo_Opcao'] = $this->Basico_model->select_atributo($_SESSION['Produtos']['idTab_Catprod']);	
				$data['select']['idTab_Catprod'] = $this->Basico_model->select_catprod();		
				$data['select']['idCat_Produto'] = $this->Basico_model->select_catprod();
				$data['select']['idTab_Produto'] = $this->Basico_model->select_produto($_SESSION['Produtos']['idTab_Catprod']);
				$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_atributo1($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][1]['idTab_Atributo']);
				$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_atributo2($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][2]['idTab_Atributo']);
				
				$data['titulo'] = 'Cadastrar Produto';
				$data['form_open_path'] = 'produtos/alterar';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';

				(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
				(!$data['produtos']['ContarEstoque']) ? $data['produtos']['ContarEstoque'] = 'S' : FALSE;        
				
				$data['radio'] = array(
					'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
				);
				($data['cadastrar']['Cadastrar'] == 'N') ?
					$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';	
						  
				$data['radio'] = array(
					'ContarEstoque' => $this->basico->radio_checked($data['produtos']['ContarEstoque'], 'ContarEstoque', 'NS'),
				);
				($data['produtos']['ContarEstoque'] == 'S') ?
					$data['div']['ContarEstoque'] = '' : $data['div']['ContarEstoque'] = 'style="display: none;"';		

				$data['q1'] = $this->Produtos_model->list_categoria($_SESSION['log'], TRUE);
				$data['list1'] = $this->load->view('produtos/list_categoria', $data, TRUE);
				
				$data['q2'] = $this->Produtos_model->list_produto($data['produtos'], TRUE);
				$data['list2'] = $this->load->view('produtos/list_produto', $data, TRUE);
				
				$data['q3'] = $this->Produtos_model->list_atributo($data['produtos'], TRUE);
				$data['list3'] = $this->load->view('produtos/list_atributo', $data, TRUE);
				
				$data['q4'] = $this->Produtos_model->list_opcao($data['produtos'], TRUE);
				$data['list4'] = $this->load->view('produtos/list_opcao', $data, TRUE);
				
				$data['q'] = $this->Produtos_model->list_produtos($_SESSION['Produtos'], TRUE);
				$data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);			
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				//$this->form_validation->set_rules('idTab_Catprod', 'Categoria', 'required|trim');
				$this->form_validation->set_rules('idTab_Produto', 'Produto', 'required|trim');
				$this->form_validation->set_rules('Cod_Prod', 'Código', 'required|trim|is_unique_by_id_empresa[Tab_Produtos.Cod_Prod.' . $data['produtos']['idTab_Produtos'] . '.idSis_Empresa.' . $_SESSION['Produtos']['idSis_Empresa'] . ']');
				$this->form_validation->set_rules('Cod_Barra', 'Código de Barra', 'trim|is_unique_by_id_empresa[Tab_Produtos.Cod_Barra.' . $data['produtos']['idTab_Produtos'] . '.idSis_Empresa.' . $_SESSION['Produtos']['idSis_Empresa'] . ']');
				$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');
				if($data['Conta_Atributos'] > 0){
					if($data['Conta_Atributos'] == 1){
						$this->form_validation->set_rules('Opcao_Atributo_1', $_SESSION['Atributo'][1]['Atributo'], 'required|trim');
					}elseif($data['Conta_Atributos'] == 2){
						$this->form_validation->set_rules('Opcao_Atributo_1', $_SESSION['Atributo'][1]['Atributo'], 'required|trim');
						$this->form_validation->set_rules('Opcao_Atributo_2', $_SESSION['Atributo'][2]['Atributo'], 'required|trim');
					}
				}          

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('produtos/form_produtos', $data);
				
				} else {
					
					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'produtos/alterar/' . $_SESSION['Produtos']['idTab_Produtos'] . $data['msg']);
						
					} else {
				   
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						#### Tab_Produtos ####
						
						$data['produtos']['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Nome_Prod'], 'ISO-8859-1'));
						$data['produtos']['Produtos_Descricao'] = trim(mb_strtoupper($data['produtos']['Produtos_Descricao'], 'ISO-8859-1'));
						$data['produtos']['Prod_Serv'] = $_SESSION['Produtos']['TipoCatprod'];
						$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produtos']);
						$data['update']['produtos']['campos'] = array_keys($data['produtos']);
						$data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['produtos']['anterior'],
							$data['produtos'],
							$data['update']['produtos']['campos'],
							$data['produtos']['idTab_Produtos'], TRUE);
						$data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produtos']);

						if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('produtos/form_produtos', $data);
						} else {

							//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
							//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';

							redirect(base_url() . 'produtos/tela/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
							exit();
						}
					}
				}
			}
		
        $this->load->view('basico/footer');

    }
	
    public function alterar2($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar as alterações.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';

			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'Cadastrar',
				'TipoCatprod',
				'idCat_Atributo',
				'idCat_Opcao',
				'idAtributo_Opcao',
				'idCat_Produto',
				'Codigo',
				'VendaSite_Cadastrar',
				'VendaSite_Alterar',
			), TRUE));	

			$data['produtos'] = quotes_to_entities($this->input->post(array(
				#### Tab_Produtos ####
				'idTab_Produtos',			
				'idTab_Catprod', 
				'idTab_Produto',
				'Opcao_Atributo_1',
				'Opcao_Atributo_2', 
				'Cod_Prod', 
				'Nome_Prod',
				'Cod_Barra',
				'Estoque',
				'ContarEstoque',
				'Produtos_Descricao',
			), TRUE));

			if ($id) {
				
				#### Tab_Produtos ####
			   $_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
				
				if($data['produtos'] === FALSE){
					
					unset($_SESSION['Produtos']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}
			}

			if(!$data['produtos']['idTab_Produtos'] || !$_SESSION['Produtos']){
				
				unset($_SESSION['Produtos']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {			
			
				#### Busca Se o produto já foi usado###
				$data['usado'] = $this->Produtos_model->get_app_produto($_SESSION['Produtos']);
				if (isset($data['usado'])){
					$max_produto = count($data['usado']);
					if($max_produto >= 1){
						$data['usado']['produto'] = "S";
					}else{
						$data['usado']['produto'] = "N";
					}
				}
				#### Busca Se o produto pertence a promoções###
				$data['promocao'] = $this->Produtos_model->get_tab_valor($_SESSION['Produtos']);
				if (isset($data['promocao'])){
					$max_promocao = count($data['promocao']);
					if($max_promocao >= 1){
						$data['promocao']['produto'] = "S";
					}else{
						$data['promocao']['produto'] = "N";
					}
				}	
				
				/*
				echo '<br>';
				echo "<pre>";
				print_r($data['produtos']);
				echo '<br>';
				print_r($_SESSION['Produtos']);
				echo '<br>';
				
				print_r($max_promocao);
				echo '<br>';
				print_r($data['promocao']['produto']);	
				
				echo "</pre>";
				exit();
				*/
				
				#### Tab_Atributo_Select ####
				$_SESSION['Atributo'] = $data['atributo'] = $this->Produtos_model->get_atributos($_SESSION['Produtos']['idTab_Catprod']);
				$data['Conta_Atributos'] = count($data['atributo']);
				if (count($data['atributo']) > 0) {
					$data['atributo'] = array_combine(range(1, count($data['atributo'])), array_values($data['atributo']));
					
					/*
					echo '<br>';
					  echo "<pre>";
					  print_r($data['Conta_Atributos']);
					  echo '<br>';
					  echo "</pre>";
					 */ 
					if (isset($data['atributo'])) {
						if ($data['Conta_Atributos'] >= 2) {
							for($j=1; $j <= $data['Conta_Atributos']; $j++){
								$_SESSION['Atributo'][$j]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
								$_SESSION['Atributo'][$j]['Atributo'] = $data['atributo'][$j]['Atributo'];
								/*
								  echo '<br>';
								  echo "<pre>";
								  //print_r($data['Conta_Atributos']);
								  echo '<br>';
								  print_r($_SESSION['Atributo'][$j]['idTab_Atributo']);
								  echo '<br>';
								  print_r($_SESSION['Atributo'][$j]['Atributo']);
								  echo "</pre>";					
								*/
							}
						}else{
							for($j=1; $j <= $data['Conta_Atributos']; $j++){
								$_SESSION['Atributo'][1]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
								$_SESSION['Atributo'][1]['Atributo'] = $data['atributo'][$j]['Atributo'];
							}
							$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
							$_SESSION['Atributo'][2]['Atributo'] = FALSE;
						}
					}
					/*
					$item_atributo = 1;	
					foreach($data['atributo'] as $atributo_view){
						$_SESSION['Atributo'][$item_atributo]['idTab_Atributo'] = $atributo_view['idTab_Atributo'];
						$_SESSION['Atributo'][$item_atributo]['Atributo'] = $atributo_view['Atributo'];
						$item_atributo++;
					}
					*/
					
				}else{
					$_SESSION['Atributo'][1]['idTab_Atributo'] = FALSE;
					$_SESSION['Atributo'][1]['Atributo'] = FALSE;
					$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
					$_SESSION['Atributo'][2]['Atributo'] = FALSE;
				}		

				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
				$data['select']['ContarEstoque'] = $this->Basico_model->select_status_sn();
				$data['select']['TipoCatprod'] = $this->Basico_model->select_prod_serv();
				$data['select']['idCat_Atributo'] = $this->Basico_model->select_catprod();
				$data['select']['idCat_Opcao'] = $this->Basico_model->select_catprod();
				$data['select']['idAtributo_Opcao'] = $this->Basico_model->select_atributo($_SESSION['Produtos']['idTab_Catprod']);	
				$data['select']['idTab_Catprod'] = $this->Basico_model->select_catprod();
				$data['select']['idCat_Produto'] = $this->Basico_model->select_catprod();	
				$data['select']['idTab_Produto'] = $this->Basico_model->select_produto($_SESSION['Produtos']['idTab_Catprod']);
				$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_atributo1($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][1]['idTab_Atributo']);
				$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_atributo2($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][2]['idTab_Atributo']);
				
				$data['titulo'] = 'Cadastrar Variações';
				$data['form_open_path'] = 'produtos/alterar2';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 3;

				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';

				(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
				(!$data['produtos']['ContarEstoque']) ? $data['produtos']['ContarEstoque'] = 'S' : FALSE;       
				
				$data['radio'] = array(
					'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
				);
				($data['cadastrar']['Cadastrar'] == 'N') ?
					$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';	
						  
				$data['radio'] = array(
					'ContarEstoque' => $this->basico->radio_checked($data['produtos']['ContarEstoque'], 'ContarEstoque', 'NS'),
				);
				($data['produtos']['ContarEstoque'] == 'S') ?
					$data['div']['ContarEstoque'] = '' : $data['div']['ContarEstoque'] = 'style="display: none;"';

				$data['q1'] = $this->Produtos_model->list_categoria($_SESSION['log'], TRUE);
				$data['list1'] = $this->load->view('produtos/list_categoria', $data, TRUE);
				
				$data['q2'] = $this->Produtos_model->list_produto($data['produtos'], TRUE);
				$data['list2'] = $this->load->view('produtos/list_produto', $data, TRUE);
				
				$data['q3'] = $this->Produtos_model->list_atributo($data['produtos'], TRUE);
				$data['list3'] = $this->load->view('produtos/list_atributo', $data, TRUE);
				
				$data['q4'] = $this->Produtos_model->list_opcao($data['produtos'], TRUE);
				$data['list4'] = $this->load->view('produtos/list_opcao', $data, TRUE);
				
				$data['q'] = $this->Produtos_model->list_produtos($data['produtos'], TRUE);
				$data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);			
				
				$data['q_list_promocoes'] = $this->Produtos_model->list_promocoes($data['produtos'], TRUE);
				$data['list_promocoes'] = $this->load->view('produtos/list_promocoes', $data, TRUE);
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				$this->form_validation->set_rules('idTab_Catprod', 'Categoria', 'required|trim');
				$this->form_validation->set_rules('idTab_Produto', 'Produto', 'required|trim');
				$this->form_validation->set_rules('Cod_Prod', 'Código', 'required|trim|is_unique_by_id_empresa[Tab_Produtos.Cod_Prod.' . $data['produtos']['idTab_Produtos'] . '.idSis_Empresa.' . $_SESSION['Produtos']['idSis_Empresa'] . ']');
				$this->form_validation->set_rules('Cod_Barra', 'Código de Barra', 'trim|is_unique_by_id_empresa[Tab_Produtos.Cod_Barra.' . $data['produtos']['idTab_Produtos'] . '.idSis_Empresa.' . $_SESSION['Produtos']['idSis_Empresa'] . ']');
				$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');			
				if($data['Conta_Atributos'] > 0){
					if($data['Conta_Atributos'] == 1){
						$this->form_validation->set_rules('Opcao_Atributo_1', $_SESSION['Atributo'][1]['Atributo'], 'required|trim');
					}elseif($data['Conta_Atributos'] == 2){
						$this->form_validation->set_rules('Opcao_Atributo_1', $_SESSION['Atributo'][1]['Atributo'], 'required|trim');
						$this->form_validation->set_rules('Opcao_Atributo_2', $_SESSION['Atributo'][2]['Atributo'], 'required|trim');
					}
				}
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('produtos/form_produtos', $data);
				
				} else { 			
					
					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'produtos/alterar2/' . $_SESSION['Produtos']['idTab_Produtos'] . $data['msg']);
						
					} else {

						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						#### Tab_Produtos ####
						$data['produtos']['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Nome_Prod'], 'ISO-8859-1'));
						$data['produtos']['Produtos_Descricao'] = trim(mb_strtoupper($data['produtos']['Produtos_Descricao'], 'ISO-8859-1'));
						$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produtos']);
						$data['update']['produtos']['campos'] = array_keys($data['produtos']);
						$data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['produtos']['anterior'],
							$data['produtos'],
							$data['update']['produtos']['campos'],
							$data['produtos']['idTab_Produtos'], TRUE);
						$data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produtos']);

						if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('produtos/form_produtos', $data);
						} else {

							//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
							//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';

							redirect(base_url() . 'produtos/tela/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
							exit();
						}
					}
				}
			}
		
        $this->load->view('basico/footer');

    }
	
    public function tela($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar as alterações.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';

			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'Cadastrar',
				'idCat_Atributo',
				'idCat_Opcao',
				'idAtributo_Opcao',
				'idCat_Produto',
				'Codigo',
			), TRUE));	
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$data['produtos'] = quotes_to_entities($this->input->post(array(
				#### Tab_Produtos ####
				'idTab_Produtos',			
				'idTab_Catprod', 
				'idTab_Produto',
				'Opcao_Atributo_1',
				'Opcao_Atributo_2', 
				'Cod_Prod',
			), TRUE));

			if ($id) {
				
				#### Tab_Produtos ####
				$_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
			
				if($data['produtos'] === FALSE){
					
					unset($_SESSION['Produtos']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}
			}
			
			if(!$data['produtos']['idTab_Produtos'] || !$_SESSION['Produtos']){
				
				unset($_SESSION['Produtos']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {			
								
				#### Tab_Atributo_Select ####
				$_SESSION['Atributo'] = $data['atributo'] = $this->Produtos_model->get_atributos($_SESSION['Produtos']['idTab_Catprod']);
				if (count($data['atributo']) > 0) {
					$data['atributo'] = array_combine(range(1, count($data['atributo'])), array_values($data['atributo']));
					$data['Conta_Atributos'] = count($data['atributo']);
					/*
					echo '<br>';
					  echo "<pre>";
					  print_r($data['Conta_Atributos']);
					  echo '<br>';
					  echo "</pre>";
					 */ 
					if (isset($data['atributo'])) {
						if ($data['Conta_Atributos'] >= 2) {
							for($j=1; $j <= $data['Conta_Atributos']; $j++){
								$_SESSION['Atributo'][$j]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
								$_SESSION['Atributo'][$j]['Atributo'] = $data['atributo'][$j]['Atributo'];
								/*
								  echo '<br>';
								  echo "<pre>";
								  //print_r($data['Conta_Atributos']);
								  echo '<br>';
								  print_r($_SESSION['Atributo'][$j]['idTab_Atributo']);
								  echo '<br>';
								  print_r($_SESSION['Atributo'][$j]['Atributo']);
								  echo "</pre>";					
								*/
							}
						}else{
							for($j=1; $j <= $data['Conta_Atributos']; $j++){
								$_SESSION['Atributo'][1]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
								$_SESSION['Atributo'][1]['Atributo'] = $data['atributo'][$j]['Atributo'];
							}
							$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
							$_SESSION['Atributo'][2]['Atributo'] = FALSE;
						}
					}
					/*
					$item_atributo = 1;	
					foreach($data['atributo'] as $atributo_view){
						$_SESSION['Atributo'][$item_atributo]['idTab_Atributo'] = $atributo_view['idTab_Atributo'];
						$_SESSION['Atributo'][$item_atributo]['Atributo'] = $atributo_view['Atributo'];
						$item_atributo++;
					}
					*/
					
				}else{
					$_SESSION['Atributo'][1]['idTab_Atributo'] = FALSE;
					$_SESSION['Atributo'][1]['Atributo'] = FALSE;
					$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
					$_SESSION['Atributo'][2]['Atributo'] = FALSE;
				}		
				
				

				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
				$data['select']['idCat_Atributo'] = $this->Basico_model->select_catprod();
				$data['select']['idCat_Opcao'] = $this->Basico_model->select_catprod();
				$data['select']['idAtributo_Opcao'] = $this->Basico_model->select_atributo($_SESSION['Produtos']['idTab_Catprod']);	
				$data['select']['idTab_Catprod'] = $this->Basico_model->select_catprod();
				$data['select']['idCat_Produto'] = $this->Basico_model->select_catprod();	
				$data['select']['idTab_Produto'] = $this->Basico_model->select_produto($_SESSION['Produtos']['idTab_Catprod']);
				$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_atributo1($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][1]['idTab_Atributo']);
				$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_atributo2($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][2]['idTab_Atributo']);
				
				$data['titulo'] = 'Tela';
				$data['form_open_path'] = 'produtos/tela';
				$data['readonly'] = 'readonly=""';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 4;

				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';

				(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;      
				
				$data['radio'] = array(
					'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
				);
				($data['cadastrar']['Cadastrar'] == 'N') ?
					$data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';    

				$data['q1'] = $this->Produtos_model->list_categoria($_SESSION['log'], TRUE);
				$data['list1'] = $this->load->view('produtos/list_categoria', $data, TRUE);
				
				$data['q2'] = $this->Produtos_model->list_produto($data['produtos'], TRUE);
				$data['list2'] = $this->load->view('produtos/list_produto', $data, TRUE);
				
				$data['q3'] = $this->Produtos_model->list_atributo($data['produtos'], TRUE);
				$data['list3'] = $this->load->view('produtos/list_atributo', $data, TRUE);
				
				$data['q4'] = $this->Produtos_model->list_opcao($data['produtos'], TRUE);
				$data['list4'] = $this->load->view('produtos/list_opcao', $data, TRUE);
				
				$data['q'] = $this->Produtos_model->list_produtos($data['produtos'], TRUE);
				$data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);
				
				$data['q_list_promocoes'] = $this->Produtos_model->list_promocoes($data['produtos'], TRUE);
				$data['list_promocoes'] = $this->load->view('produtos/list_promocoes', $data, TRUE);		
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				$this->form_validation->set_rules('idTab_Catprod', 'Categoria', 'required|trim');
				$this->form_validation->set_rules('idTab_Produto', 'Produto', 'required|trim');
				$this->form_validation->set_rules('Cod_Prod', 'Código', 'required|trim|is_unique_by_id_empresa[Tab_Produtos.Cod_Prod.' . $data['produtos']['idTab_Produtos'] . '.idSis_Empresa.' . $_SESSION['Produtos']['idSis_Empresa'] . ']');
				//$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');			
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
					
					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'produtos/tela/' . $_SESSION['Produtos']['idTab_Produtos'] . $data['msg']);
						
					} else {

						/*
						echo '<br>';
						echo "<pre>";
						print_r($data['cadastrar']['Codigo']);
						echo "</pre>";
						exit ();
						*/
					
						$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						#### Tab_Produtos ####

						$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produtos']);
						$data['update']['produtos']['campos'] = array_keys($data['produtos']);
						$data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['produtos']['anterior'],
							$data['produtos'],
							$data['update']['produtos']['campos'],
							$data['produtos']['idTab_Produtos'], TRUE);
						$data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produtos']);

						if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('produtos/form_produtos', $data);
						} else {

							//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
							//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';

							redirect(base_url() . 'produtos/alterar2/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
							exit();
						}
					}
				}
			}
		
        $this->load->view('basico/footer');

    }

    public function tela_precos($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar as alterações.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';

			$data['produtos'] = quotes_to_entities($this->input->post(array(
				#### Tab_Produtos ####
				'idTab_Produtos',
			), TRUE));


			if ($id) {
				
				#### Tab_Produtos ####
				$_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
			
				if($data['produtos'] === FALSE){
					
					unset($_SESSION['Produtos']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}
			}
			
			if(!$data['produtos']['idTab_Produtos'] || !$_SESSION['Produtos']){
				
				unset($_SESSION['Produtos']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {			
					
				$data['titulo'] = 'Tela';
				$data['form_open_path'] = 'produtos/tela_precos';
				$data['readonly'] = 'readonly=""';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 6;

				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';

				$data['q_precos'] = $this->Produtos_model->list_precos($data['produtos'], TRUE);
				$data['list_precos'] = $this->load->view('produtos/list_precos', $data, TRUE);
				
				$data['q_precos_promocoes'] = $this->Produtos_model->list_precos_promocoes($data['produtos'], TRUE);
				$data['list_precos_promocoes'] = $this->load->view('produtos/list_precos_promocoes', $data, TRUE);			
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				$this->form_validation->set_rules('idTab_Produtos', 'Produto', 'required|trim');

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('produtos/form_produtos', $data);
				
				} else {
					
					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'produtos/tela_precos/' . $_SESSION['Produtos']['idTab_Produtos'] . $data['msg']);
						
					} else {
				   
						if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('produtos/form_produtos', $data);
						} else {

							$data['msg'] = '?m=1';
							redirect(base_url() . 'produtos/alterar2/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
							
							exit();
						}
					}
				}
			}
			
        $this->load->view('basico/footer');

    }
	
    public function alterar_precos($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar as alterações.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';

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

			#### Tab_Produtos ####
			$data['produtos'] = quotes_to_entities($this->input->post(array(
				'idTab_Produtos',
			), TRUE));

			#### Tab_Valor ####
			(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
			$j = 1;
			for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

				if ($this->input->post('ValorProduto' . $i)) {
					$data['valor'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
					$data['valor'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
					$data['valor'][$j]['QtdProdutoIncremento'] = $this->input->post('QtdProdutoIncremento' . $i);
					//$data['valor'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
					$data['valor'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
					$data['valor'][$j]['ComissaoVenda'] = $this->input->post('ComissaoVenda' . $i);
					$data['valor'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
					$data['valor'][$j]['ComissaoCashBack'] = $this->input->post('ComissaoCashBack' . $i);
					$data['valor'][$j]['TempoDeEntrega'] = $this->input->post('TempoDeEntrega' . $i);
					$data['valor'][$j]['Convdesc'] = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($this->input->post('Convdesc' . $i), $caracteres_sem_acento));
					//$data['valor'][$j]['AtivoPreco'] = $this->input->post('AtivoPreco' . $i);
					$data['valor'][$j]['VendaSitePreco'] = $this->input->post('VendaSitePreco' . $i);
					$data['valor'][$j]['VendaBalcaoPreco'] = $this->input->post('VendaBalcaoPreco' . $i);
					$data['valor'][$j]['TipoPreco'] = $this->input->post('TipoPreco' . $i);
					$j++;
				}
							
			}
			$data['count']['PTCount'] = $j - 1;		
			
			if ($id) {
				
				#### Tab_Produtos ####
				$_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
				
				if($data['produtos'] === FALSE){
					
					unset($_SESSION['Produtos']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
					
					#### Tab_Valor ####
					$data['valor'] = $this->Produtos_model->get_item($id, "1");
					if (count($data['valor']) > 0) {
						$data['valor'] = array_combine(range(1, count($data['valor'])), array_values($data['valor']));
						$data['count']['PTCount'] = count($data['valor']);
						/*
						if (isset($data['valor'])) {

							for($j=1; $j <= $data['count']['PTCount']; $j++){
							
							}
								
						}
						*/				
					}
				}	
			}
			
			if(!$data['produtos']['idTab_Produtos'] || !$_SESSION['Produtos']){
				
				unset($_SESSION['Produtos']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {			
				/*
				echo '<br>';
				echo "<pre>";
				print_r($data['produtos']);
				echo '<br>';
				print_r($_SESSION['Produtos']);
				echo '<br>';
				
				print_r($max_promocao);
				echo '<br>';
				print_r($data['promocao']['produto']);	
				
				echo "</pre>";
				exit();
				*/			
				//$data['select']['AtivoPreco'] = $this->Basico_model->select_status_sn();
				$data['select']['VendaSitePreco'] = $this->Basico_model->select_status_sn();
				$data['select']['VendaBalcaoPreco'] = $this->Basico_model->select_status_sn();
				$data['select']['TipoPreco'] = array(
					'V' => 'Venda',
					'R' => 'Revenda',
				);

				$data['titulo'] = 'Tela';
				$data['form_open_path'] = 'produtos/alterar_precos';
				$data['readonly'] = 'readonly=""';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 7;

				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';

				$data['q_precos'] = $this->Produtos_model->list_precos($_SESSION['Produtos'], TRUE);
				$data['list_precos'] = $this->load->view('produtos/list_precos', $data, TRUE);			
				
				$data['q_precos_promocoes'] = $this->Produtos_model->list_precos_promocoes($_SESSION['Produtos'], TRUE);
				$data['list_precos_promocoes'] = $this->load->view('produtos/list_precos_promocoes', $data, TRUE);
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				$this->form_validation->set_rules('idTab_Produtos', 'Produto', 'required|trim');
				
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('produtos/form_produtos', $data);
				
				} else {
					
					if($this->Basico_model->get_dt_validade() === FALSE){
						$data['msg'] = '?m=3';
						redirect(base_url() . 'produtos/alterar_precos/' . $_SESSION['Produtos']['idTab_Produtos'] . $data['msg']);
						
					} else {
							   
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						/*
						echo '<br>';
						echo "<pre>";
						print_r($data['cadastrar']['Codigo']);
						echo "</pre>";
						exit ();
						*/
						/*
						#### Tab_Produtos ####
						$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produtos']);
						$data['update']['produtos']['campos'] = array_keys($data['produtos']);
						$data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['produtos']['anterior'],
							$data['produtos'],
							$data['update']['produtos']['campos'],
							$data['produtos']['idTab_Produtos'], TRUE);
						$data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produtos']);
						*/
						#### Tab_Valor ####
						$data['update']['valor']['anterior'] = $this->Produtos_model->get_item($_SESSION['Produtos']['idTab_Produtos'], "1");
						if (isset($data['valor']) || (!isset($data['valor']) && isset($data['update']['valor']['anterior']) ) ) {

							if (isset($data['valor']))
								$data['valor'] = array_values($data['valor']);
							else
								$data['valor'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

							$max = count($data['update']['valor']['inserir']);
							for($j=0;$j<$max;$j++) {
								$data['update']['valor']['inserir'][$j]['Item_Promocao'] = 1;
								$data['update']['valor']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['inserir'][$j]['Convdesc'], 'UTF-8'));
								$data['update']['valor']['inserir'][$j]['Desconto'] = 1;
								$data['update']['valor']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['update']['valor']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['valor']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['valor']['inserir'][$j]['idTab_Produtos'] = $_SESSION['Produtos']['idTab_Produtos'];
								$data['update']['valor']['inserir'][$j]['idTab_Promocao'] = 1;
								$data['update']['valor']['inserir'][$j]['idTab_Catprod'] = $_SESSION['Produtos']['idTab_Catprod'];
								$data['update']['valor']['inserir'][$j]['idTab_Produto'] = $_SESSION['Produtos']['idTab_Produto'];
								
								if(empty($data['update']['valor']['inserir'][$j]['ValorProduto'])){
									$data['update']['valor']['inserir'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['valor']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ValorProduto']));
								}
								if(empty($data['update']['valor']['inserir'][$j]['ComissaoVenda'])){
									$data['update']['valor']['inserir'][$j]['ComissaoVenda'] = "0.00";
								}else{
									$data['update']['valor']['inserir'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ComissaoVenda']));
								}						
								if(empty($data['update']['valor']['inserir'][$j]['ComissaoServico'])){
									$data['update']['valor']['inserir'][$j]['ComissaoServico'] = "0.00";
								}else{
									$data['update']['valor']['inserir'][$j]['ComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ComissaoServico']));
								}						
								if(empty($data['update']['valor']['inserir'][$j]['ComissaoCashBack'])){
									$data['update']['valor']['inserir'][$j]['ComissaoCashBack'] = "0.00";
								}else{
									$data['update']['valor']['inserir'][$j]['ComissaoCashBack'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ComissaoCashBack']));
								}
								if(empty($data['update']['valor']['inserir'][$j]['QtdProdutoDesconto'])){
									$data['update']['valor']['inserir'][$j]['QtdProdutoDesconto'] = "1";
								}
								if(empty($data['update']['valor']['inserir'][$j]['QtdProdutoIncremento'])){
									$data['update']['valor']['inserir'][$j]['QtdProdutoIncremento'] = "1";
								}
								if(empty($data['update']['valor']['inserir'][$j]['TempoDeEntrega'])){
									$data['update']['valor']['inserir'][$j]['TempoDeEntrega'] = "0";
								}
							}

							$max = count($data['update']['valor']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['valor']['alterar'][$j]['Item_Promocao'] = 1;
								$data['update']['valor']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['alterar'][$j]['Convdesc'], 'UTF-8'));
								$data['update']['valor']['alterar'][$j]['Desconto'] = 1;
								$data['update']['valor']['alterar'][$j]['idTab_Promocao'] = 1;
								$data['update']['valor']['alterar'][$j]['idTab_Produto'] = $_SESSION['Produtos']['idTab_Produto'];

								if(empty($data['update']['valor']['alterar'][$j]['ValorProduto'])){
									$data['update']['valor']['alterar'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['valor']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ValorProduto']));
								}
								if(empty($data['update']['valor']['alterar'][$j]['ComissaoVenda'])){
									$data['update']['valor']['alterar'][$j]['ComissaoVenda'] = "0.00";
								}else{
									$data['update']['valor']['alterar'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ComissaoVenda']));
								}						
								if(empty($data['update']['valor']['alterar'][$j]['ComissaoServico'])){
									$data['update']['valor']['alterar'][$j]['ComissaoServico'] = "0.00";
								}else{
									$data['update']['valor']['alterar'][$j]['ComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ComissaoServico']));
								}						
								if(empty($data['update']['valor']['alterar'][$j]['ComissaoCashBack'])){
									$data['update']['valor']['alterar'][$j]['ComissaoCashBack'] = "0.00";
								}else{
									$data['update']['valor']['alterar'][$j]['ComissaoCashBack'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ComissaoCashBack']));
								}
								if(empty($data['update']['valor']['alterar'][$j]['QtdProdutoDesconto'])){
									$data['update']['valor']['alterar'][$j]['QtdProdutoDesconto'] = "1";
								}
								if(empty($data['update']['valor']['alterar'][$j]['QtdProdutoIncremento'])){
									$data['update']['valor']['alterar'][$j]['QtdProdutoIncremento'] = "1";
								}					
								if(empty($data['update']['valor']['alterar'][$j]['TempoDeEntrega'])){
									$data['update']['valor']['alterar'][$j]['TempoDeEntrega'] = "0";
								}
							}

							if (count($data['update']['valor']['inserir']))
								$data['update']['valor']['bd']['inserir'] = $this->Produtos_model->set_valor($data['update']['valor']['inserir']);

							if (count($data['update']['valor']['alterar']))
								$data['update']['valor']['bd']['alterar'] =  $this->Produtos_model->update_valor($data['update']['valor']['alterar']);

							if (count($data['update']['valor']['excluir']))
								$data['update']['valor']['bd']['excluir'] = $this->Produtos_model->delete_valor($data['update']['valor']['excluir']);

						}
							
						if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('produtos/form_produtos', $data);
						} else {

							$data['msg'] = '?m=1';
							redirect(base_url() . 'produtos/tela_precos/' . $_SESSION['Produtos']['idTab_Produtos'] . $data['msg']);
							
							exit();
						}
					}
				}
			}
		
        $this->load->view('basico/footer');

    }

    public function tela_valor($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar as alterações.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';
			
			$data['valor'] = quotes_to_entities($this->input->post(array(
				#### Tab_Valor ####
				'idTab_Valor',
			), TRUE));

			if ($id) {
				
				#### Tab_Valor ####
				$_SESSION['Valor'] = $data['valor'] = $this->Produtos_model->get_valor($id);
				
				if($data['valor'] === FALSE){
					
					unset($_SESSION['Valor']);
					unset($_SESSION['Produtos']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
				}
			}
			
			if(!$data['valor']['idTab_Valor'] || !$_SESSION['Valor']){
				
				unset($_SESSION['Valor']);
				unset($_SESSION['Produtos']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				#### Tab_Produtos ####
				$_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($_SESSION['Valor']['idTab_Produtos']);
				
				if($data['produtos'] === FALSE){
					
					unset($_SESSION['Valor']);
					unset($_SESSION['Produtos']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
					
					//$data['select']['AtivoPreco'] = $this->Basico_model->select_status_sn();
					$data['select']['VendaSitePreco'] = $this->Basico_model->select_status_sn();
					$data['select']['VendaBalcaoPreco'] = $this->Basico_model->select_status_sn();
					$data['select']['TipoPreco'] = array(
						'V' => 'Venda',
						'R' => 'Revenda',
					);
					
					$data['titulo'] = 'Tela Preço';
					$data['form_open_path'] = 'produtos/tela_valor';
					$data['readonly'] = 'readonly=""';
					$data['disabled'] = '';
					$data['panel'] = 'primary';
					$data['metodo'] = 6;

					$data['sidebar'] = 'col-sm-3 col-md-2';
					$data['main'] = 'col-sm-7 col-md-8';

					$data['datepicker'] = 'DatePicker';
					$data['timepicker'] = 'TimePicker';

					$data['q_precos'] = $this->Produtos_model->list_precos($_SESSION['Valor'], TRUE);
					$data['list_precos'] = $this->load->view('produtos/list_precos', $data, TRUE);
					
					$data['q_precos_promocoes'] = $this->Produtos_model->list_precos_promocoes($_SESSION['Valor'], TRUE);
					$data['list_precos_promocoes'] = $this->load->view('produtos/list_precos_promocoes', $data, TRUE);			
					
					$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
					$this->form_validation->set_rules('idTab_Valor', 'Produto', 'required|trim');

					#run form validation
					if ($this->form_validation->run() === FALSE) {
						$this->load->view('produtos/form_valor', $data);
					
					} else {
						
						if($this->Basico_model->get_dt_validade() === FALSE){
							$data['msg'] = '?m=3';
							redirect(base_url() . 'produtos/tela_valor/' . $_SESSION['Valor']['idTab_Valor'] . $data['msg']);
							
						} else {
							
							if ($data['auditoriaitem'] && !$data['update']['valor']['bd']) {
								$data['msg'] = '?m=2';
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

								$this->basico->erro($msg);
								$this->load->view('produtos/form_valor', $data);
							} else {

								$data['msg'] = '?m=1';
								redirect(base_url() . 'produtos/tela_valor/' . $data['valor']['idTab_Valor'] . $data['msg']);
								
								exit();
							}
						}
					}
				}	
			}
		
        $this->load->view('basico/footer');

    }

    public function alterar_valor($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Não é possível salvar as alterações.<br>Não identificamos o pagamento da sua última Fatura.<br>Por favor, Entre em contato com a administração da Plataforma Enkontraki.</strong>', 'alerta', TRUE, TRUE, FALSE);
        else
            $data['msg'] = '';

			$data['valor'] = quotes_to_entities($this->input->post(array(
				#### Tab_Valor ####
				'idTab_Valor',			
				'QtdProdutoDesconto', 
				'QtdProdutoIncremento',
				'ComissaoVenda',
				'ComissaoServico',
				'ComissaoCashBack',
				'TempoDeEntrega',
				//'AtivoPreco', 
				'VendaSitePreco',
				'VendaBalcaoPreco',
				'Convdesc',
				'ValorProduto',
				'TipoPreco',
			), TRUE));

			if ($id) {
				
				#### Tab_Valor ####
				$_SESSION['Valor'] = $data['valor'] = $this->Produtos_model->get_valor($id);			
				
				if($data['valor'] === FALSE){
					
					unset($_SESSION['Valor']);
					unset($_SESSION['Produtos']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				}
			}
			
			if(!$data['valor']['idTab_Valor'] || !$_SESSION['Valor']){
				
				unset($_SESSION['Valor']);
				unset($_SESSION['Produtos']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				#### Tab_Produtos ####
				$_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($_SESSION['Valor']['idTab_Produtos']);
				
				if($data['produtos'] === FALSE){
					
					unset($_SESSION['Valor']);
					unset($_SESSION['Produtos']);
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

					$convdesc1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['valor']['Convdesc'], $caracteres_sem_acento));		
							
					//$data['select']['AtivoPreco'] = $this->Basico_model->select_status_sn();
					$data['select']['VendaSitePreco'] = $this->Basico_model->select_status_sn();
					$data['select']['VendaBalcaoPreco'] = $this->Basico_model->select_status_sn();
					$data['select']['TipoPreco'] = array(
						'V' => 'Venda',
						'R' => 'Revenda',
					);		
					
					$data['titulo'] = 'Alterar Preço';
					$data['form_open_path'] = 'produtos/alterar_valor';
					$data['readonly'] = '';
					$data['disabled'] = '';
					$data['panel'] = 'primary';
					$data['metodo'] = 7;

					$data['sidebar'] = 'col-sm-3 col-md-2';
					$data['main'] = 'col-sm-7 col-md-8';

					$data['datepicker'] = 'DatePicker';
					$data['timepicker'] = 'TimePicker';

					$data['q_precos'] = $this->Produtos_model->list_precos($_SESSION['Valor'], TRUE);
					$data['list_precos'] = $this->load->view('produtos/list_precos', $data, TRUE);
					
					$data['q_precos_promocoes'] = $this->Produtos_model->list_precos_promocoes($_SESSION['Valor'], TRUE);
					$data['list_precos_promocoes'] = $this->load->view('produtos/list_precos_promocoes', $data, TRUE);			
					
					$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
					$this->form_validation->set_rules('idTab_Valor', 'Produto', 'required|trim');
					$this->form_validation->set_rules('ValorProduto', 'Valor', 'required|trim');

					#run form validation
					if ($this->form_validation->run() === FALSE) {
						$this->load->view('produtos/form_valor', $data);
					
					} else {
						
						if($this->Basico_model->get_dt_validade() === FALSE){
							$data['msg'] = '?m=3';
							redirect(base_url() . 'produtos/alterar_valor/' . $_SESSION['Valor']['idTab_Valor'] . $data['msg']);
							
						} else {
											
							////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
							/*
							echo '<br>';
							echo "<pre>";
							print_r($data['valor']);
							echo "</pre>";
							exit ();
							*/
							#### Tab_Valor ####
							$data['valor']['Item_Promocao'] = "1";
							$data['valor']['Desconto'] = 1;
							$data['valor']['idTab_Promocao'] = 1;
							$data['valor']['idTab_Produto'] = $_SESSION['Valor']['idTab_Produto'];
							$data['valor']['idTab_Catprod'] = $_SESSION['Valor']['idTab_Catprod'];
							$data['valor']['Convdesc'] = trim(mb_strtoupper($convdesc1, 'UTF-8'));	

							if(empty($data['valor']['ValorProduto'])){
								$data['valor']['ValorProduto'] = "0.00";
							}else{
								$data['valor']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['valor']['ValorProduto']));			
							}
							
							if(empty($data['valor']['ComissaoVenda'])){
								$data['valor']['ComissaoVenda'] = "0.00";
							}else{
								$data['valor']['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['valor']['ComissaoVenda']));			
							}			
							
							if(empty($data['valor']['ComissaoServico'])){
								$data['valor']['ComissaoServico'] = "0.00";
							}else{
								$data['valor']['ComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['valor']['ComissaoServico']));			
							}			
							
							if(empty($data['valor']['ComissaoCashBack'])){
								$data['valor']['ComissaoCashBack'] = "0.00";
							}else{
								$data['valor']['ComissaoCashBack'] = str_replace(',', '.', str_replace('.', '', $data['valor']['ComissaoCashBack']));			
							}			
							
							if(empty($data['valor']['QtdProdutoDesconto'])){
								$data['valor']['QtdProdutoDesconto'] = "1";
							}
										
							if(empty($data['valor']['QtdProdutoIncremento'])){
								$data['valor']['QtdProdutoIncremento'] = "1";
							}
										
							if(empty($data['valor']['TempoDeEntrega'])){
								$data['valor']['TempoDeEntrega'] = "0";
							}
							
							$data['update']['valor']['anterior'] = $this->Produtos_model->get_valor($data['valor']['idTab_Valor']);
							$data['update']['valor']['campos'] = array_keys($data['valor']);
							$data['update']['valor']['auditoriaitem'] = $this->basico->set_log(
								$data['update']['valor']['anterior'],
								$data['valor'],
								$data['update']['valor']['campos'],
								$data['valor']['idTab_Valor'], TRUE);
							$data['update']['valor']['bd'] = $this->Produtos_model->update_valor1($data['valor'], $data['valor']['idTab_Valor']);
							
							if ($data['auditoriaitem'] && !$data['update']['valor']['bd']) {
								$data['msg'] = '?m=2';
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

								$this->basico->erro($msg);
								$this->load->view('produtos/form_valor', $data);
							} else {

								$data['msg'] = '?m=1';
								//redirect(base_url() . 'produtos/tela_valor/' . $data['valor']['idTab_Valor'] . $data['msg']);
								redirect(base_url() . 'produtos/tela_precos/' . $_SESSION['Valor']['idTab_Produtos'] . $data['msg']);
								
								exit();
							}
						}
					}
				}
			}
		
        $this->load->view('basico/footer');

    }
	
    public function alterarlogocatprod($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

			$data['catprod'] = $this->input->post(array(
				'idTab_Catprod',
			), TRUE);
			
			$data['file'] = $this->input->post(array(
				'idTab_Catprod',
				'idSis_Empresa',
				'Arquivo',
			), TRUE);

			if ($id) {
				
				$_SESSION['Catprod'] = $data['catprod'] = $this->Produtos_model->get_catprod($id, TRUE);
				
				if($data['catprod'] === FALSE){
					
					unset($_SESSION['Catprod']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
					$data['file']['idTab_Catprod'] = $id;
				}
			}
			
			if(!$data['catprod']['idTab_Catprod'] || !$_SESSION['Catprod']){
				
				unset($_SESSION['Catprod']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
					
					$data['file']['Arquivo'] = $this->basico->renomeiacatprod($_FILES['Arquivo']['name']);
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
				}
				else {
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
				}

				$data['titulo'] = 'Alterar Foto';
				$data['form_open_path'] = 'produtos/alterarlogocatprod';
				$data['readonly'] = 'readonly';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					#load login view
					$this->load->view('produtos/form_catprod', $data);
				} else {
						
					if($this->Basico_model->get_dt_validade() === FALSE){
					
						unset($_SESSION['Catprod']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
						
						$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/';
						$config['max_size'] = 1000;
						$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
						$config['file_name'] = $data['file']['Arquivo'];

						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('Arquivo')) {
							$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
							$this->load->view('produtos/form_catprod', $data);
						} else {
						
							$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/';		
							$foto = $data['file']['Arquivo'];
							$diretorio = $dir.$foto;					
							$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/';

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
							$data['file']['idSis_Empresa'] = $_SESSION['Empresa']['idSis_Empresa'];
							$data['idSis_Arquivo'] = $this->Produtos_model->set_arquivo($data['file']);

							if ($data['idSis_Arquivo'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
								$this->basico->erro($msg);
								$this->load->view('produtos/form_catprod', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
								
								$data['catprod']['Arquivo'] = $data['file']['Arquivo'];
								$data['anterior'] = $this->Produtos_model->get_catprod($data['catprod']['idTab_Catprod']);
								$data['campos'] = array_keys($data['catprod']);

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['catprod'], $data['campos'], $data['catprod']['idTab_Catprod'], TRUE);

								if ($data['auditoriaitem'] && $this->Produtos_model->update_catprod($data['catprod'], $data['catprod']['idTab_Catprod']) === FALSE) {
									$data['msg'] = '?m=2';
									redirect(base_url() . 'produtos/alterarlogocatprod/' . $data['catprod']['idTab_Catprod'] . $data['msg']);
									exit();
								} else {

									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Catprod']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Catprod']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/fotoproduto.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Catprod']['Arquivo'] . '');						
									}
									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Catprod']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Catprod']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/fotoproduto.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Catprod']['Arquivo'] . '');						
									}						
									
									if ($data['auditoriaitem'] === FALSE) {
										$data['msg'] = '';
									} else {
										$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Catprod', 'UPDATE', $data['auditoriaitem']);
										$data['msg'] = '?m=1';
									}

									redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
									exit();
								}				
							}
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
				'idTab_Produto',
			), TRUE);
			
			$data['file'] = $this->input->post(array(
				'idTab_Produto',
				'idSis_Empresa',
				'Arquivo',
			), TRUE);

			if ($id) {
				
				$_SESSION['Produto'] = $data['query'] = $this->Produtos_model->get_produto($id, TRUE);
			
				if($data['query'] === FALSE){
					
					unset($_SESSION['Produto']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
					$data['file']['idTab_Produto'] = $id;
				}
			}
			
			if(!$data['query']['idTab_Produto'] || !$_SESSION['Produto']){
				
				unset($_SESSION['Produto']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
					
					$data['file']['Arquivo'] = $this->basico->renomeiaprodutos($_FILES['Arquivo']['name']);
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
				}
				else {
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
				}

				$data['titulo'] = 'Alterar Foto';
				$data['form_open_path'] = 'produtos/alterarlogo';
				$data['readonly'] = 'readonly';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					#load login view
					$this->load->view('produtos/form_perfil', $data);
				} else {
						
					if($this->Basico_model->get_dt_validade() === FALSE){
				
						unset($_SESSION['Produto']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
						
						$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/';
						$config['max_size'] = 1000;
						$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
						$config['file_name'] = $data['file']['Arquivo'];

						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('Arquivo')) {
							$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
							$this->load->view('produtos/form_perfil', $data);
						} else {
						
							$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/';		
							$foto = $data['file']['Arquivo'];
							$diretorio = $dir.$foto;					
							$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/';

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
							$data['file']['idSis_Empresa'] = $_SESSION['Empresa']['idSis_Empresa'];
							$data['idSis_Arquivo'] = $this->Produtos_model->set_arquivo($data['file']);

							if ($data['idSis_Arquivo'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
								$this->basico->erro($msg);
								$this->load->view('produtos/form_perfil', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
								
								$data['query']['Arquivo'] = $data['file']['Arquivo'];
								$data['anterior'] = $this->Produtos_model->get_produto($data['query']['idTab_Produto']);
								$data['campos'] = array_keys($data['query']);

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Produto'], TRUE);

								if ($data['auditoriaitem'] && $this->Produtos_model->update_produto($data['query'], $data['query']['idTab_Produto']) === FALSE) {
									$data['msg'] = '?m=2';
									redirect(base_url() . 'produtos/alterarlogo/' . $data['query']['idTab_Produto'] . $data['msg']);
									exit();
								} else {

									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Produto']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Produto']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/fotoproduto.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Produto']['Arquivo'] . '');						
									}
									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Produto']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Produto']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/fotoproduto.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Produto']['Arquivo'] . '');						
									}						
									
									if ($data['auditoriaitem'] === FALSE) {
										$data['msg'] = '';
									} else {
										$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'UPDATE', $data['auditoriaitem']);
										$data['msg'] = '?m=1';
									}

									redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
									exit();
								}				
							}
						}
					}
				}
			}
		
        $this->load->view('basico/footer');
    }

    public function alterarlogoderivado($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

			$data['derivado'] = $this->input->post(array(
				'idTab_Produtos',
			), TRUE);
			
			$data['file'] = $this->input->post(array(
				'idTab_Produtos',
				'idSis_Empresa',
				'Arquivo',
			), TRUE);

			if ($id) {
				
				$_SESSION['Derivados'] = $data['derivado'] = $this->Produtos_model->get_produtosderivados($id, TRUE);
			
				if($data['derivado'] === FALSE){
					
					unset($_SESSION['Derivados']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
					$data['file']['idTab_Produtos'] = $id;
				}
			}
			
			if(!$data['derivado']['idTab_Produtos'] || !$_SESSION['Derivados']){
				
				unset($_SESSION['Derivados']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
					
					$data['file']['Arquivo'] = $this->basico->renomeiaderivado($_FILES['Arquivo']['name']);
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
				}
				else {
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
				}

				$data['titulo'] = 'Alterar Foto';
				$data['form_open_path'] = 'produtos/alterarlogoderivado';
				$data['readonly'] = 'readonly';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;
				/*
				echo "<pre>";
				print_r($data['file']);
				echo "</pre>";
				exit();
				*/		
				#run form validation
				if ($this->form_validation->run() === FALSE) {
					#load login view
					$this->load->view('produtos/form_derivado', $data);
				} else {
						
					if($this->Basico_model->get_dt_validade() === FALSE){
						
						unset($_SESSION['Derivados']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
						
						$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/';
						$config['max_size'] = 1000;
						$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
						$config['file_name'] = $data['file']['Arquivo'];

						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('Arquivo')) {
							$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
							$this->load->view('produtos/form_derivado', $data);
						} else {
						
							$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/';		
							$foto = $data['file']['Arquivo'];
							$diretorio = $dir.$foto;					
							$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/';

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
							$data['file']['idSis_Empresa'] = $_SESSION['Empresa']['idSis_Empresa'];
							$data['idSis_Arquivo'] = $this->Produtos_model->set_arquivo($data['file']);

							if ($data['idSis_Arquivo'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
								$this->basico->erro($msg);
								$this->load->view('produtos/form_derivado', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
								
								$data['derivado']['Arquivo'] = $data['file']['Arquivo'];
								$data['anterior'] = $this->Produtos_model->get_produtosderivados($data['derivado']['idTab_Produtos']);
								$data['campos'] = array_keys($data['derivado']);

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['derivado'], $data['campos'], $data['derivado']['idTab_Produtos'], TRUE);

								if ($data['auditoriaitem'] && $this->Produtos_model->update_produtosderivados($data['derivado'], $data['derivado']['idTab_Produtos']) === FALSE) {
									$data['msg'] = '?m=2';
									redirect(base_url() . 'produtos/form_derivado/' . $data['derivado']['idTab_Produtos'] . $data['msg']);
									exit();
								} else {

									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Derivados']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Derivados']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/fotoproduto.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Derivados']['Arquivo'] . '');						
									}
									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Derivados']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Derivados']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/fotoproduto.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Derivados']['Arquivo'] . '');						
									}						
									
									if ($data['auditoriaitem'] === FALSE) {
										$data['msg'] = '';
									} else {
										$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'UPDATE', $data['auditoriaitem']);
										$data['msg'] = '?m=1';
									}

									//redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
									redirect(base_url() . 'produtos/tela/' . $data['derivado']['idTab_Produtos'] . $data['msg']);
									exit();
								}				
							}
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

		if (!$id) {

			unset($_SESSION['Produtos']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
				
			#### Tab_Produtos ####
			$_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
		
			if($data['produtos'] === FALSE){
				
				unset($_SESSION['Produtos']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
						
				if($this->Basico_model->get_dt_validade() === FALSE){
					
					unset($_SESSION['Produtos']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {
					
					#### Busca Se o produto já foi usado###
					$data['usado'] = $this->Produtos_model->get_app_produto($_SESSION['Produtos']);
					if (isset($data['usado'])){
						$max_produto = count($data['usado']);
						if($max_produto >= 1){
							$data['usado']['produto'] = "S";
						}else{
							$data['usado']['produto'] = "N";
						}
					}
					#### Busca Se o produto pertence a promoções###
					$data['promocao'] = $this->Produtos_model->get_tab_valor($_SESSION['Produtos']);
					if (isset($data['promocao'])){
						$max_promocao = count($data['promocao']);
						if($max_promocao >= 1){
							$data['promocao']['produto'] = "S";
						}else{
							$data['promocao']['produto'] = "N";
						}
					}	

					if($data['usado']['produto'] == "S" || $data['promocao']['produto'] == "S"){
					
						unset($_SESSION['Produtos']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						exit();
					
					}else{
						$this->Produtos_model->delete_produtos($id);

						$data['msg'] = '?m=1';

						unset($_SESSION['Produtos']);
						unset($_SESSION['Atributo']);

						redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
						exit();
					}
				}	
			}
		}
        $this->load->view('basico/footer');
    }

/*	
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

        $data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);
       # $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('produtos/tela_produtos', $data);

        $this->load->view('basico/footer');
    }
*/
/*
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

        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('produtos/tela_produtos', $data);

        $this->load->view('basico/footer');
    }
*/
}
