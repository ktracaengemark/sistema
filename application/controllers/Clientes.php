<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array(	'Basico_model', 'Cliente_model', 'Relatorio_model', 'Base_model',  'Empresa_model', 
									'Loginempresa_model', 'Associado_model', 'Usuario_model', 'Agenda_model'
								));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        if ($this->agent->is_browser()) {

            if (
                    (preg_match("/(chrome|Firefox)/i", $this->agent->browser()) && $this->agent->version() < 30) ||
                    (preg_match("/(safari)/i", $this->agent->browser()) && $this->agent->version() < 6) ||
                    (preg_match("/(opera)/i", $this->agent->browser()) && $this->agent->version() < 12) ||
                    (preg_match("/(internet explorer)/i", $this->agent->browser()) && $this->agent->version() < 9 )
            ) {
                $msg = '<h2><strong>Navegador não suportado.</strong></h2>';

                echo $this->basico->erro($msg);
                exit();
            }
        }		
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('Clientes/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function clientes() {
		
		unset($_SESSION['FiltroClientes']);
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Cliente Não Encontrado.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>A Pesquisa está muito grande, ela excedeu 30000 linhas. Refine o seu filtro.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'id_Cliente_Auto',
				'NomeClienteAuto',
				'id_ClientePet_Auto',
				'NomeClientePetAuto',
				'id_ClienteDep_Auto',
				'NomeClienteDepAuto',
			), TRUE));	
			
			$data['query'] = quotes_to_entities($this->input->post(array(
				//'NomeCliente',
				'idApp_Cliente',
				'idApp_ClientePet',
				'idApp_ClienteDep',
				'idApp_ClientePet2',
				'idApp_ClienteDep2',
				'Ativo',
				'Motivo',
				'Ordenamento',
				'Campo',
				'DataInicio',
				'DataFim',
				'DataInicio2',
				'DataFim2',
				'DataInicio3',
				'DataFim3',
				'Dia',
				'Mes',
				'Ano',
				'Texto1',
				'Texto2',
				'Texto3',
				'Texto4',
				'Agrupar',
				'Pedidos',
				'Sexo',
				'Pesquisa',
			), TRUE));

			$data['select']['Ativo'] = array(
				'#' => 'TODOS',
				'N' => 'Não',
				'S' => 'Sim',
			);
			
			$data['select']['Sexo'] = array(
				'0' => 'Todos',
				'1' => 'Masculino',
				'2' => 'Feminino',
				'3' => 'Outros',
			);
			
			if($_SESSION['Empresa']['CadastrarPet'] == "S"){
				$data['select']['Agrupar'] = array(
					'0' => 'Cliente/Pet',
					'idApp_Cliente' => 'Cliente',
				);
			}else{
				if($_SESSION['Empresa']['CadastrarDep'] == "S"){
					$data['select']['Agrupar'] = array(
						'0' => 'Cliente/Det',
						'idApp_Cliente' => 'Cliente',
					);
				}else{
					$data['select']['Agrupar'] = array(
						'idApp_Cliente' => 'Cliente',
					);
				}
			}	
				
			$data['select']['Pedidos'] = array(
				'0' => 'Todos',
				'1' => 'Clientes S/Pedidos',
				'2' => 'Clientes C/Pedidos',
			);
					
			$data['select']['Campo'] = array(
				'C.idApp_Cliente' => 'nº Cliente',
				'C.NomeCliente' => 'Nome do Cliente',
				'C.Ativo' => 'Ativo',
				'C.DataNascimento' => 'Data de Nascimento',
				'C.DataCadastroCliente' => 'Data do Cadastro',
				'C.Sexo' => 'Sexo',
				'C.BairroCliente' => 'Bairro',
				'C.MunicipioCliente' => 'Município',
				'C.Email' => 'E-mail',
				'CC.NomeContatoCliente' => 'Contato do Cliente',
				'TCC.RelaPes' => 'Rel. Pes.',
				'TCC.RelaCom' => 'Rel. Com.',
				'CC.Sexo' => 'Sexo',
				'C.UltimoPedido' => 'Ultimo Pedido',
				'C.ValidadeCashBack' => 'Validade CashBack',

			);

			$data['select']['Ordenamento'] = array(
				'ASC' => 'Crescente',
				'DESC' => 'Decrescente',
			);

			//$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
			$data['select']['Dia'] = $this->Relatorio_model->select_dia();
			$data['select']['Mes'] = $this->Relatorio_model->select_mes();
			$data['select']['Motivo'] = $this->Relatorio_model->select_motivo();
			
			$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

			$data['titulo'] = 'Clientes';
			$data['form_open_path'] = 'Clientes/clientes';
			
			$data['paginacao'] = 'N';

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
			$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'trim');
			$this->form_validation->set_rules('DataInicio', 'Data Início do Cadastro', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim', 'Data Fim do Cadastro', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio2', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim2', 'Data Fim', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio3', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim3', 'Data Fim', 'trim|valid_date');

			#run form validation
			if ($this->form_validation->run() !== FALSE) {

				$_SESSION['FiltroClientes']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
				$_SESSION['FiltroClientes']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
				$_SESSION['FiltroClientes']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
				$_SESSION['FiltroClientes']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
				$_SESSION['FiltroClientes']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
				$_SESSION['FiltroClientes']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');        
				$_SESSION['FiltroClientes']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
				$_SESSION['FiltroClientes']['idApp_ClientePet'] = $data['query']['idApp_ClientePet'];
				$_SESSION['FiltroClientes']['idApp_ClienteDep'] = $data['query']['idApp_ClienteDep'];
				$_SESSION['FiltroClientes']['idApp_ClientePet2'] = $data['query']['idApp_ClientePet2'];
				$_SESSION['FiltroClientes']['idApp_ClienteDep2'] = $data['query']['idApp_ClienteDep2'];
				$_SESSION['FiltroClientes']['Ativo'] = $data['query']['Ativo'];
				$_SESSION['FiltroClientes']['Motivo'] = $data['query']['Motivo'];
				$_SESSION['FiltroClientes']['Campo'] = $data['query']['Campo'];
				$_SESSION['FiltroClientes']['Ordenamento'] = $data['query']['Ordenamento'];
				$_SESSION['FiltroClientes']['Dia'] = $data['query']['Dia'];
				$_SESSION['FiltroClientes']['Mes'] = $data['query']['Mes'];
				$_SESSION['FiltroClientes']['Ano'] = $data['query']['Ano'];
				$_SESSION['FiltroClientes']['Agrupar'] = $data['query']['Agrupar'];
				$_SESSION['FiltroClientes']['Pedidos'] = $data['query']['Pedidos'];
				$_SESSION['FiltroClientes']['Sexo'] = $data['query']['Sexo'];
				$_SESSION['FiltroClientes']['Pesquisa'] = $data['query']['Pesquisa'];
					
				if(isset($_SESSION['FiltroClientes']['Agrupar']) && $_SESSION['FiltroClientes']['Agrupar'] != "0"){
					$_SESSION['FiltroClientes']['Aparecer'] = 0;
					$data['aparecer'] = 0;
				}else{
					$_SESSION['FiltroClientes']['Aparecer'] = 1;
					$data['aparecer'] = 1;
				}
					
				$data['pesquisa_query'] = $this->Base_model->list_clientes($_SESSION['FiltroClientes'],TRUE, TRUE);

				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'Clientes/clientes' . $data['msg']);
					exit();
				}else{

					$config['total_rows'] = $data['pesquisa_query'];
					
					$config['base_url'] = base_url() . 'Clientes/clientes_pag/';					
					$config['per_page'] = 10;
					$config["uri_segment"] = 3;
					$config['reuse_query_string'] = TRUE;
					$config['num_links'] = 2;
					$config['use_page_numbers'] = TRUE;
					$config['full_tag_open'] = "<ul class='pagination'>";
					$config['full_tag_close'] = "</ul>";
					$config['num_tag_open'] = '<li>';
					$config['num_tag_close'] = '</li>';
					$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
					$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
					$config['next_tag_open'] = "<li>";
					$config['next_tagl_close'] = "</li>";
					$config['prev_tag_open'] = "<li>";
					$config['prev_tagl_close'] = "</li>";
					$config['first_tag_open'] = "<li>";
					$config['first_tagl_close'] = "</li>";
					$config['last_tag_open'] = "<li>";
					$config['last_tagl_close'] = "</li>";

					if($config['total_rows'] >= 1){
						$data['total_rows'] = $config['total_rows'];
					}else{
						$data['total_rows'] = 0;
					}
					
					$this->pagination->initialize($config);
					
					$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
					$data['pagina'] = $page;
					$data['per_page'] = $config['per_page'];

					$data['report'] = $this->Base_model->list_clientes($_SESSION['FiltroClientes'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
					
					$_SESSION['FiltroClientes']['Texto1'] = utf8_encode($data['query']['Texto1']);
					$_SESSION['FiltroClientes']['Texto2'] = utf8_encode($data['query']['Texto2']);
					$_SESSION['FiltroClientes']['Texto3'] = utf8_encode($data['query']['Texto3']);
					$_SESSION['FiltroClientes']['Texto4'] = utf8_encode($data['query']['Texto4']);					

					$data['pagination'] = $this->pagination->create_links();

					if($data['query']['idApp_Cliente']){
						if ($data['report']->num_rows() >= 1) {
							$info = $data['report']->result_array();
							redirect('cliente/prontuario/' . $info[0]['idApp_Cliente'] );
							exit();
						} else {
							$data['list'] = $this->load->view('Clientes/list_clientes', $data, TRUE);
						}				
					}else{
						$data['list'] = $this->load->view('Clientes/list_clientes', $data, TRUE);
					}
				}	
			}

			$this->load->view('Clientes/tela_clientes', $data);
		}
        $this->load->view('basico/footer');

    }

    public function clientes_pag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{

			$data['titulo'] = 'Clientes';
			$data['form_open_path'] = 'Clientes/clientes_pag';
			
			$data['paginacao'] = 'S';
			$data['caminho'] = 'Clientes/clientes/';

			if(isset($_SESSION['FiltroClientes']['Agrupar']) && $_SESSION['FiltroClientes']['Agrupar'] != "0"){
				$_SESSION['FiltroClientes']['Aparecer'] = 0;
				$data['aparecer'] = 0;
			}else{
				$_SESSION['FiltroClientes']['Aparecer'] = 1;
				$data['aparecer'] = 1;
			}

			$data['pesquisa_query'] = $this->Base_model->list_clientes($_SESSION['FiltroClientes'],TRUE, TRUE);

			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'Clientes/clientes' . $data['msg']);
				exit();
			}else{

				$config['base_url'] = base_url() . 'Clientes/clientes_pag/';
				
				//$config['total_rows'] = $this->Base_model->list_clientes(FALSE, TRUE, TRUE);

				$config['total_rows'] = $data['pesquisa_query'];			   					
				
				$config['per_page'] = 10;
				$config["uri_segment"] = 3;
				$config['reuse_query_string'] = TRUE;
				$config['num_links'] = 2;
				$config['use_page_numbers'] = TRUE;
				$config['full_tag_open'] = "<ul class='pagination'>";
				$config['full_tag_close'] = "</ul>";
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
				$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
				$config['next_tag_open'] = "<li>";
				$config['next_tagl_close'] = "</li>";
				$config['prev_tag_open'] = "<li>";
				$config['prev_tagl_close'] = "</li>";
				$config['first_tag_open'] = "<li>";
				$config['first_tagl_close'] = "</li>";
				$config['last_tag_open'] = "<li>";
				$config['last_tagl_close'] = "</li>";
				$data['Pesquisa'] = '';

				if($config['total_rows'] >= 1){
					$data['total_rows'] = $config['total_rows'];
				}else{
					$data['total_rows'] = 0;
				}
				
				$this->pagination->initialize($config);
				
				$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
				$data['pagina'] = $page;
				$data['per_page'] = $config['per_page'];
				$data['report'] = $this->Base_model->list_clientes($_SESSION['FiltroClientes'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
				
				$data['pagination'] = $this->pagination->create_links();

				if($_SESSION['FiltroClientes']['Agrupar'] != "0"){
					$data['aparecer'] = 0;
				}else{
					$data['aparecer'] = 1;
				}
				
				$data['list'] = $this->load->view('Clientes/list_clientes', $data, TRUE);
			
			}
			
			$this->load->view('Clientes/tela_clientes', $data);
		}
        $this->load->view('basico/footer');

    }

	public function clientes_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Clientes Sem Filtros';
				$data['metodo'] = $id;
				$data['aparecer'] = 1;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroClientes'])){
					if(isset($_SESSION['FiltroClientes']['Agrupar']) && $_SESSION['FiltroClientes']['Agrupar'] != "0"){
						$_SESSION['FiltroClientes']['Aparecer'] = 0;
						$data['aparecer'] = 0;
					}else{
						$_SESSION['FiltroClientes']['Aparecer'] = 1;
						$data['aparecer'] = 1;
					}
					$dados = $_SESSION['FiltroClientes'];
					$data['titulo'] = 'Clientes Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Clientes Sem Filtros';
					$data['metodo'] = 1;
					$data['aparecer'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Clientes Sem Filtros';
				$data['metodo'] = 1;
				$data['aparecer'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Clientes Sem Filtros';
			$data['metodo'] = 1;
			$data['aparecer'] = 1;
		}

        $data['nome'] = 'Cliente';

		$data['report'] = $this->Base_model->list_clientes($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Clientes/clientes' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Clientes/list_clientes_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

	public function clientes_csv($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 3){
				if(isset($_SESSION['FiltroClientes'])){
					$_SESSION['FiltroClientes']['Aparecer'] = 0;
					$dados = $_SESSION['FiltroClientes'];
					$data['titulo'] = 'G-mail Com Filtros';
					$data['metodo'] = $id;
				}else{
					$data['msg'] = '?m=4';
					redirect(base_url() . 'Clientes/clientes' . $data['msg']);
					exit();
				}
			}else{
				$data['msg'] = '?m=4';
				redirect(base_url() . 'Clientes/clientes' . $data['msg']);
				exit();
			}
		}else{		
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Clientes/clientes' . $data['msg']);
			exit();
		}
		
        $data['nome'] = 'Cliente';

		$data['report'] = $this->Base_model->list_clientes($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'Clientes/clientes' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Clientes/list_clientes_csv', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

    public function imprimirlistacliente($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		

		if (!$id) {

			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			if($_SESSION['log']['idSis_Empresa'] !== $id){
					
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			}else{
				
				$data['Imprimir']['DataInicio'] = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio'], 'barras') : FALSE;
				$data['Imprimir']['DataFim'] = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim'], 'barras') : FALSE;
				$data['Imprimir']['DataInicio6'] = ($_SESSION['FiltroAlteraParcela']['DataInicio6']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio6'], 'barras') : FALSE;
				$data['Imprimir']['DataFim6'] = ($_SESSION['FiltroAlteraParcela']['DataFim6']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim6'], 'barras') : FALSE;
				
				//$_SESSION['DataInicio'] = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio'], 'barras') : FALSE;
				$_SESSION['DataInicio'] = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? $_SESSION['FiltroAlteraParcela']['DataInicio'] : FALSE;
				
				/*
				echo '<br>';
				echo "<pre>";
				print_r($data['Imprimir']['DataInicio']);
				echo "</pre>";
				exit ();
				*/

				//$this->load->library('pagination');

				$data['Pesquisa'] = '';

				$data['pesquisa_query'] = $this->Orcatrataprint_model->get_orcatrata_cliente($id, TRUE);
				$config['total_rows'] = $data['pesquisa_query']->num_rows();
				
				//$config['total_rows'] = $this->Orcatrataprint_model->get_orcatrata_cliente($id, TRUE);
				
				$config['base_url'] = base_url() . 'OrcatrataPrint/imprimirlistacliente/' . $id . '/';
				$config['per_page'] = 19;
				$config["uri_segment"] = 4;
				$config['reuse_query_string'] = TRUE;
				$config['num_links'] = 2;
				$config['use_page_numbers'] = TRUE;
				$config['full_tag_open'] = "<ul class='pagination'>";
				$config['full_tag_close'] = "</ul>";
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
				$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
				$config['next_tag_open'] = "<li>";
				$config['next_tagl_close'] = "</li>";
				$config['prev_tag_open'] = "<li>";
				$config['prev_tagl_close'] = "</li>";
				$config['first_tag_open'] = "<li>";
				$config['first_tagl_close'] = "</li>";
				$config['last_tag_open'] = "<li>";
				$config['last_tagl_close'] = "</li>";
				
				if($config['total_rows'] >= 1){
					$data['total_rows'] = $config['total_rows'];
				}else{
					$data['total_rows'] = 0;
				}
				
				$this->pagination->initialize($config);
				
				$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
				$data['pagina'] = $page;
				$data['per_page'] = $config['per_page'];
				
				$data['pagination'] = $this->pagination->create_links();		

				#### App_OrcaTrata ####
				//$data['orcatrata'] = $this->Orcatrataprintcobranca_model->get_orcatrata_cliente($id);
				$data['orcatrata'] = $this->Orcatrataprint_model->get_orcatrata_cliente($id, FALSE, $config['per_page'], ($page * $config['per_page']));
				if (count($data['orcatrata']) > 0) {
					$data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
					$data['count']['POCount'] = count($data['orcatrata']);           

					if (isset($data['orcatrata'])) {

						for($j=1;$j<=$data['count']['POCount'];$j++) {
							
							$data['orcatrata'][$j]['idApp_OrcaTrata'] = $data['orcatrata'][$j]['idApp_OrcaTrata'];
							$data['orcatrata'][$j]['DataCadastroCliente'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataCadastroCliente'], 'barras');
							$data['orcatrata'][$j]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataOrca'], 'barras');
							$data['orcatrata'][$j]['DataPrazo'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataPrazo'], 'barras');
							$data['orcatrata'][$j]['DataConclusao'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataConclusao'], 'barras');
							$data['orcatrata'][$j]['DataRetorno'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataRetorno'], 'barras');
							$data['orcatrata'][$j]['DataQuitado'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataQuitado'], 'barras');
							$data['orcatrata'][$j]['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntradaOrca'], 'barras');
							$data['orcatrata'][$j]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataEntregaOrca'], 'barras');
							$data['orcatrata'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$j]['DataVencimentoOrca'], 'barras');
							$data['orcatrata'][$j]['ValorTotalOrca'] = number_format(($data['orcatrata'][$j]['ValorTotalOrca']), 2, ',', '.');
							$data['orcatrata'][$j]['ConcluidoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$j]['ConcluidoOrca'], 'NS');
							$data['orcatrata'][$j]['QuitadoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$j]['QuitadoOrca'], 'NS');

						}
					}	
				}
				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data['orcatrata']);
				  echo "</pre>";
				  //exit ();
				*/ 


				$data['titulo'] = 'Lista Clientes';
				$data['form_open_path'] = 'OrcatrataPrint/imprimirlistacliente';
				$data['panel'] = 'info';
				$data['metodo'] = 1;
				$data['imprimir'] = 'OrcatrataPrint/imprimir/';
				$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistacliente/';
				$data['imprimirrecibo'] = 'Cobrancas/cobrancas_recibo/';
				
				/*
				  echo '<br>';
				  echo "<pre>";
				  print_r($data);
				  echo "</pre>";
				  #exit ();
				 */

				$this->load->view('orcatrata/print_orcatratacliente_lista', $data);
			}
		}
        $this->load->view('basico/footer');

    }

	public function rankingvendas() {
		
		unset($_SESSION['FiltroRankingVendas']);

		if ($this->input->get('m') == 1)
			$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
		elseif ($this->input->get('m') == 2)
			$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
		else
			$data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'id_Cliente_Auto',
				'NomeClienteAuto',
			), TRUE));	
				
			$data['query'] = quotes_to_entities($this->input->post(array(
				'ValorOrca',
				'NomeCliente',
				'idApp_Cliente',
				'DataInicio',
				'DataFim',
				'DataInicio2',
				'DataFim2',
				'DataInicio3',
				'DataFim3',
				'Ordenamento',
				'Campo',
				'Pedidos_de',
				'Pedidos_ate',
				'Valor_de',
				'Valor_ate',
				'Valor_cash_de',
				'Valor_cash_ate',
				'Ultimo',
				'Texto1',
				'Texto2',
				'Texto3',
				'Texto4',
				'nomedoCliente',
				'idCliente',
				'numerodopedido',
				'site',
			), TRUE));
			
			$data['select']['nomedoCliente'] = $this->Basico_model->select_status_sn();
			$data['select']['idCliente'] = $this->Basico_model->select_status_sn();
			$data['select']['numerodopedido'] = $this->Basico_model->select_status_sn();
			$data['select']['site'] = $this->Basico_model->select_status_sn();
			
			(!$data['query']['nomedoCliente']) ? $data['query']['nomedoCliente'] = 'N' : FALSE;
			$data['radio'] = array(
				'nomedoCliente' => $this->basico->radio_checked($data['query']['nomedoCliente'], 'nomedoCliente', 'NS'),
			);
			($data['query']['nomedoCliente'] == 'S') ?
				$data['div']['nomedoCliente'] = '' : $data['div']['nomedoCliente'] = 'style="display: none;"';		

			(!$data['query']['idCliente']) ? $data['query']['idCliente'] = 'N' : FALSE;
			$data['radio'] = array(
				'idCliente' => $this->basico->radio_checked($data['query']['idCliente'], 'idCliente', 'NS'),
			);
			($data['query']['idCliente'] == 'S') ?
				$data['div']['idCliente'] = '' : $data['div']['idCliente'] = 'style="display: none;"';
				
			(!$data['query']['numerodopedido']) ? $data['query']['numerodopedido'] = 'N' : FALSE;
			$data['radio'] = array(
				'numerodopedido' => $this->basico->radio_checked($data['query']['numerodopedido'], 'numerodopedido', 'NS'),
			);
			($data['query']['numerodopedido'] == 'S') ?
				$data['div']['numerodopedido'] = '' : $data['div']['numerodopedido'] = 'style="display: none;"';		

			(!$data['query']['site']) ? $data['query']['site'] = 'N' : FALSE;
			$data['radio'] = array(
				'site' => $this->basico->radio_checked($data['query']['site'], 'site', 'NS'),
			);
			($data['query']['site'] == 'S') ?
				$data['div']['site'] = '' : $data['div']['site'] = 'style="display: none;"';		

			$data['select']['Campo'] = array(
				'Valor' => 'Valor Pedido',
				'F.CashBackCliente' => 'Valor CashBach',
				'ContPedidos' => 'Pedidos',
				'F.NomeCliente' => 'Cliente',
				'F.idApp_Cliente' => 'Id',
				'F.UltimoPedido' => 'Ultimo Pedido',
			);

			$data['select']['Ordenamento'] = array(
				'DESC' => 'Decrescente',
				'ASC' => 'Crescente',
			);
			
			$data['select']['Ultimo'] = array(
				'0' => '::Nenhum::',			
				#'1' => 'Último Pedido',
			);		

			$data['titulo'] = 'Ranking de Vendas';
			$data['form_open_path'] = 'Clientes/rankingvendas';	
			$data['paginacao'] = 'N';
			$data['nome'] = 'Cliente';
			
			$_SESSION['FiltroRankingVendas']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
			$_SESSION['FiltroRankingVendas']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
			$_SESSION['FiltroRankingVendas']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$_SESSION['FiltroRankingVendas']['Ordenamento'] = $data['query']['Ordenamento'];
			$_SESSION['FiltroRankingVendas']['Campo'] = $data['query']['Campo'];
			$_SESSION['FiltroRankingVendas']['Pedidos_de'] = $data['query']['Pedidos_de'];
			$_SESSION['FiltroRankingVendas']['Pedidos_ate'] = $data['query']['Pedidos_ate'];
			$_SESSION['FiltroRankingVendas']['Valor_de'] = $data['query']['Valor_de'];
			$_SESSION['FiltroRankingVendas']['Valor_ate'] = $data['query']['Valor_ate'];
			$_SESSION['FiltroRankingVendas']['Valor_cash_de'] = $data['query']['Valor_cash_de'];
			$_SESSION['FiltroRankingVendas']['Valor_cash_ate'] = $data['query']['Valor_cash_ate'];
			$_SESSION['FiltroRankingVendas']['Ultimo'] = $data['query']['Ultimo'];
			
			$_SESSION['FiltroRankingVendas']['Texto1'] = utf8_encode($data['query']['Texto1']);
			$_SESSION['FiltroRankingVendas']['Texto2'] = utf8_encode($data['query']['Texto2']);
			$_SESSION['FiltroRankingVendas']['Texto3'] = utf8_encode($data['query']['Texto3']);
			$_SESSION['FiltroRankingVendas']['Texto4'] = utf8_encode($data['query']['Texto4']);	
			$_SESSION['FiltroRankingVendas']['nomedoCliente'] = $data['query']['nomedoCliente'];
			$_SESSION['FiltroRankingVendas']['idCliente'] = $data['query']['idCliente'];
			$_SESSION['FiltroRankingVendas']['numerodopedido'] = $data['query']['numerodopedido'];
			$_SESSION['FiltroRankingVendas']['site'] = $data['query']['site'];	
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
			#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
			$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio2', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim2', 'Data Fim', 'trim|valid_date');
			$this->form_validation->set_rules('DataInicio3', 'Data Inicio', 'trim|valid_date');
			$this->form_validation->set_rules('DataFim3', 'Data Fim', 'trim|valid_date');

			#run form validation
			if ($this->form_validation->run() !== FALSE) {

				$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
				$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
				$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
				$data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
				$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
				$data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
				$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
				$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
				$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
				$data['bd']['Campo'] = $data['query']['Campo'];
				$data['bd']['Valor_de'] = $data['query']['Valor_de'];
				$data['bd']['Valor_ate'] = $data['query']['Valor_ate'];
				$data['bd']['Valor_cash_de'] = $data['query']['Valor_cash_de'];
				$data['bd']['Valor_cash_ate'] = $data['query']['Valor_cash_ate'];
				$data['bd']['Pedidos_de'] = $data['query']['Pedidos_de'];
				$data['bd']['Pedidos_ate'] = $data['query']['Pedidos_ate'];
				$data['bd']['Ultimo'] = $data['query']['Ultimo'];

				//$data['report'] = $this->Base_model->list_rankingvendas($data['bd'],TRUE);

				//$this->load->library('pagination');
				$config['per_page'] = 10;
				$config["uri_segment"] = 3;
				$config['reuse_query_string'] = TRUE;
				$config['num_links'] = 2;
				$config['use_page_numbers'] = TRUE;
				$config['full_tag_open'] = "<ul class='pagination'>";
				$config['full_tag_close'] = "</ul>";
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
				$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
				$config['next_tag_open'] = "<li>";
				$config['next_tagl_close'] = "</li>";
				$config['prev_tag_open'] = "<li>";
				$config['prev_tagl_close'] = "</li>";
				$config['first_tag_open'] = "<li>";
				$config['first_tagl_close'] = "</li>";
				$config['last_tag_open'] = "<li>";
				$config['last_tagl_close'] = "</li>";
				$data['Pesquisa'] = '';
				
				$config['base_url'] = base_url() . 'Clientes/rankingvendas_pag/';
				$config['total_rows'] = $this->Base_model->list_rankingvendas($data['bd'],TRUE, TRUE);
			   
				if($config['total_rows'] >= 1){
					$data['total_rows'] = $config['total_rows'];
				}else{
					$data['total_rows'] = 0;
				}
				
				$this->pagination->initialize($config);
				
				$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
				$data['pagina'] = $page;
				$data['per_page'] = $config['per_page'];
				$data['report'] = $this->Base_model->list_rankingvendas($data['bd'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
				$data['pagination'] = $this->pagination->create_links();
				
				$data['list'] = $this->load->view('Clientes/list_rankingvendas', $data, TRUE);
				//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
			}

			$this->load->view('Clientes/tela_rankingvendas', $data);
		}
		$this->load->view('basico/footer');

	}

	public function rankingvendas_pag() {

		if ($this->input->get('m') == 1)
			$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
		elseif ($this->input->get('m') == 2)
			$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
		else
			$data['msg'] = '';
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		}else{
			
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'id_Cliente_Auto',
				'NomeClienteAuto',
			), TRUE));	
				
			$data['query'] = quotes_to_entities($this->input->post(array(
				'ValorOrca',
				'NomeCliente',
				'idApp_Cliente',
				'DataInicio',
				'DataFim',
				'DataInicio2',
				'DataFim2',
				'DataInicio3',
				'DataFim3',
				'Ordenamento',
				'Campo',
				'Pedidos_de',
				'Pedidos_ate',
				'Valor_de',
				'Valor_ate',
				'Valor_cash_de',
				'Valor_cash_ate',
				'Ultimo',
				'Texto1',
				'Texto2',
				'Texto3',
				'Texto4',
				'nomedoCliente',
				'idCliente',
				'numerodopedido',
				'site',
			), TRUE));

			$data['titulo'] = 'Ranking de Vendas';
			$data['form_open_path'] = 'Clientes/rankingvendas_pag';	
			$data['paginacao'] = 'S';
			$data['caminho'] = 'Clientes/rankingvendas/';
			$data['nome'] = 'Cliente';
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			#run form validation
			if ($this->form_validation->run() !== TRUE) {

				$config['per_page'] = 10;
				$config["uri_segment"] = 3;
				$config['reuse_query_string'] = TRUE;
				$config['num_links'] = 2;
				$config['use_page_numbers'] = TRUE;
				$config['full_tag_open'] = "<ul class='pagination'>";
				$config['full_tag_close'] = "</ul>";
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
				$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
				$config['next_tag_open'] = "<li>";
				$config['next_tagl_close'] = "</li>";
				$config['prev_tag_open'] = "<li>";
				$config['prev_tagl_close'] = "</li>";
				$config['first_tag_open'] = "<li>";
				$config['first_tagl_close'] = "</li>";
				$config['last_tag_open'] = "<li>";
				$config['last_tagl_close'] = "</li>";
				$data['Pesquisa'] = '';
				
				$config['base_url'] = base_url() . 'Clientes/rankingvendas_pag/';
				$config['total_rows'] = $this->Base_model->list_rankingvendas(FALSE, TRUE, TRUE);
			   
				if($config['total_rows'] >= 1){
					$data['total_rows'] = $config['total_rows'];
				}else{
					$data['total_rows'] = 0;
				}
				
				$this->pagination->initialize($config);
				
				$page = ($this->uri->segment($config["uri_segment"])) ? ($this->uri->segment($config["uri_segment"]) - 1) : 0;
				$data['pagina'] = $page;
				$data['per_page'] = $config['per_page'];
				$data['report'] = $this->Base_model->list_rankingvendas(FALSE, TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
				$data['pagination'] = $this->pagination->create_links();
				
				$data['list'] = $this->load->view('Clientes/list_rankingvendas', $data, TRUE);
				//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
			}

			$this->load->view('Clientes/tela_rankingvendas', $data);
		}
		$this->load->view('basico/footer');

	}

}