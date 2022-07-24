<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_print extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Relatorio_model', 'Empresa_model', 'Relatorio_print_model', 
									'Loginempresa_model', 'Associado_model', 'Usuario_model', 'Agenda_model'
								));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('relatorio/nav_secundario');
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

        $this->load->view('relatorio/tela_index', $data);

        #load footer view
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

		$data['report'] = $this->Relatorio_model->list_clientes($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio/clientes' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Relatorio_print/list_clientes_excel', $data, TRUE);
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
					redirect(base_url() . 'relatorio/clientes' . $data['msg']);
					exit();
				}
			}else{
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio/clientes' . $data['msg']);
				exit();
			}
		}else{		
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio/clientes' . $data['msg']);
			exit();
		}
		
        $data['nome'] = 'Cliente';

		$data['report'] = $this->Relatorio_model->list_clientes($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio/clientes' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Relatorio_print/list_clientes_csv', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

	public function receitas_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Receitas Sem Filtros';
				$data['metodo'] = $id;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroReceitas'])){
					$dados = $_SESSION['FiltroReceitas'];
					$data['titulo'] = 'Receitas Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Receitas Sem Filtros';
					$data['metodo'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Receitas Sem Filtros';
				$data['metodo'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Receitas Sem Filtros';
			$data['metodo'] = 1;
		}

        $data['nome'] = 'Cliente';

		$data['report'] = $this->Relatorio_model->list_receitas($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio/receitas' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Relatorio_print/list_receitas_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

	public function receitas_lista() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
        $data['titulo'] = 'Receitas';
		$data['form_open_path'] = 'Relatorio_print/receitas_lista';
		$data['baixatodas'] = 'Orcatrata/baixadasreceitas/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio/receitas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistacliente/';
		$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/receitas/';
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation

			$data['pesquisa_query'] = $this->Relatorio_model->list_receitas($_SESSION['FiltroReceitas'],TRUE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio/receitas' . $data['msg']);
				exit();
			}else{

				$config['total_rows'] = $data['pesquisa_query']->num_rows();
				
				$config['base_url'] = base_url() . 'Relatorio_print/receitas_lista/';
				$config['per_page'] = 19;
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
				
				$data['linha'] = $page * $config['per_page'];
			
				$_SESSION['FiltroReceitas']['Limit'] = $data['per_page'];
				$_SESSION['FiltroReceitas']['Start'] = $data['linha'];

				$data['report'] = $this->Relatorio_model->list_receitas($_SESSION['FiltroReceitas'], TRUE, FALSE, $config['per_page'], $data['linha']);
							
				$data['pagination'] = $this->pagination->create_links();

				$data['list1'] = $this->load->view('Relatorio_print/list_receitas_lista', $data, TRUE);
			}
        		

        $this->load->view('relatorio/tela_receitas', $data);

        $this->load->view('basico/footer');

    }

	public function despesas_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Despesas Sem Filtros';
				$data['metodo'] = $id;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroDespesas'])){
					$dados = $_SESSION['FiltroDespesas'];
					$data['titulo'] = 'Despesas Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Despesas Sem Filtros';
					$data['metodo'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Despesas Sem Filtros';
				$data['metodo'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Despesas Sem Filtros';
			$data['metodo'] = 1;
		}

        $data['nome'] = 'Fornecedor';

		$data['report'] = $this->Relatorio_model->list_despesas($dados, TRUE, FALSE, FALSE, FALSE);

		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio/despesas' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Relatorio_print/list_despesas_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

	public function despesas_lista() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
        $data['titulo'] = 'Despesas';
		$data['form_open_path'] = 'Relatorio_print/despesas_lista';
		$data['baixatodas'] = 'Orcatrata/baixadasdespesas/';
		$data['baixa'] = 'Orcatrata/baixadadespesa/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio/despesas/';
		$data['editar'] = 2;
		$data['metodo'] = 3;
		$data['panel'] = 'danger';
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['print'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimirdesp/';
		$data['imprimirlista'] = 'Relatorio_print/debitos_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/debitos_recibo/';
		$data['edit'] = 'Orcatrata/alterardesp/';
		$data['alterarparc'] = 'Orcatrata/alterarparceladesp/';	
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/despesas/';		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        

			$data['pesquisa_query'] = $this->Relatorio_model->list_despesas($_SESSION['FiltroDespesas'],TRUE, TRUE);
			
			if($data['pesquisa_query'] === FALSE){
				
				$data['msg'] = '?m=4';
				redirect(base_url() . 'relatorio/despesas/' . $data['msg']);
				exit();
			}else{

				$_SESSION['FiltroDespesas']['total_valor'] = $data['pesquisa_query']->soma2->somafinal2;
				
				$_SESSION['FiltroDespesas']['total_rows'] = $config['total_rows'] = $data['pesquisa_query']->num_rows();			

				//$config['total_rows'] = $_SESSION['FiltroDespesas']['total_rows'];

				$config['base_url'] = base_url() . 'Relatorio_print/despesas_lista/';
				$config['per_page'] = 19;
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
					
				$data['linha'] = $page * $config['per_page'];
			
				$_SESSION['FiltroDespesas']['Limit'] = $data['per_page'];
				$_SESSION['FiltroDespesas']['Start'] = $data['linha'];

				$data['report'] = $this->Relatorio_model->list_despesas($_SESSION['FiltroDespesas'], TRUE, FALSE, $config['per_page'], $data['linha']);			
				
				$data['pagination'] = $this->pagination->create_links();
				
				$data['list1'] = $this->load->view('Relatorio_print/list_despesas_lista', $data, TRUE);
			}
       		

        $this->load->view('relatorio/tela_despesas', $data);

        $this->load->view('basico/footer');

    }

	public function cobrancas_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Cobrancas Sem Filtros';
				$data['metodo'] = $id;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroCobrancas'])){
					$dados = $_SESSION['FiltroCobrancas'];
					$data['titulo'] = 'Cobrancas Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Cobrancas Sem Filtros';
					$data['metodo'] = 1;
				}
			}elseif($id == 3){
				if(isset($_SESSION['FiltroCobrancas'])){
					$dados = $_SESSION['FiltroCobrancas'];
					$data['titulo'] = 'Cobrancas Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Cobrancas Sem Filtros';
					$data['metodo'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Cobrancas Sem Filtros';
				$data['metodo'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Cobrancas Sem Filtros';
			$data['metodo'] = 1;
		}

        $data['nome'] = 'Cliente';

		$data['report'] = $this->Relatorio_model->list_cobrancas($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio/cobrancas' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Relatorio_print/list_cobrancas_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

    public function cobrancas_lista($id = FALSE) {

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
				
				$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroCobrancas']['DataInicio4'], 'barras');
				$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroCobrancas']['DataFim4'], 'barras');
		
				$data['pesquisa_query'] = $this->Relatorio_print_model->get_cobrancas($_SESSION['FiltroCobrancas'], TRUE);
				
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'relatorio/cobrancas' . $data['msg']);
					exit();
				}else{

					$config['base_url'] = base_url() . 'Relatorio_print/cobrancas_lista/' . $id . '/';
					$config['total_rows'] = $data['pesquisa_query'];
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
					$data['orcatrata'] = $this->Relatorio_print_model->get_cobrancas($_SESSION['FiltroCobrancas'], FALSE, $config['per_page'], ($page * $config['per_page']));
					if (count($data['orcatrata']) > 0) {
						$data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
						$data['count']['POCount'] = count($data['orcatrata']);           

						if (isset($data['orcatrata'])) {

							for($i=1;$i<=$data['count']['POCount'];$i++) {

								$data['orcatrata'][$i]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataOrca'], 'barras');
								$data['orcatrata'][$i]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataEntregaOrca'], 'barras');
								$data['orcatrata'][$i]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataVencimentoOrca'], 'barras');
								$data['orcatrata'][$i]['ValorFinalOrca'] = number_format(($data['orcatrata'][$i]['ValorFinalOrca']), 2, ',', '.');
								$data['orcatrata'][$i]['ConcluidoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['ConcluidoOrca'], 'NS');
								$data['orcatrata'][$i]['QuitadoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['QuitadoOrca'], 'NS');
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['orcatrata'][$i]);
								echo "</pre>";
								*/
								#### App_ProdutoVenda ####
								$data['produto'][$i] = $this->Relatorio_print_model->get_produto($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['produto'][$i]) > 0) {
									$data['produto'][$i] = array_combine(range(1, count($data['produto'][$i])), array_values($data['produto'][$i]));
									$data['count']['PCount'][$i] = count($data['produto'][$i]);

									if (isset($data['produto'][$i])) {

										for($k=1;$k<=$data['count']['PCount'][$i];$k++) {
											$data['produto'][$i][$k]['SubtotalProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto'] * $data['produto'][$i][$k]['QtdProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['ValorProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$i][$k]['DataValidadeProduto'], 'barras');
											$data['produto'][$i][$k]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['ConcluidoProduto'], 'NS');
											$data['produto'][$i][$k]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['DevolvidoProduto'], 'NS');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['produto'][$i]);
								echo "</pre>";
								*/		
								#### App_Parcelas####
								$data['parcelasrec'][$i] = $this->Relatorio_print_model->get_parcelasrec($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['parcelasrec'][$i]) > 0) {
									$data['parcelasrec'][$i] = array_combine(range(1, count($data['parcelasrec'][$i])), array_values($data['parcelasrec'][$i]));
									$data['count']['PRCount'][$i] = count($data['parcelasrec'][$i]);
									
									if (isset($data['parcelasrec'][$i])) {

										for($j=1; $j <= $data['count']['PRCount'][$i]; $j++) {
											$data['parcelasrec'][$i][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataVencimento'], 'barras');
											$data['parcelasrec'][$i][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataPago'], 'barras');
											$data['parcelasrec'][$i][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataLanc'], 'barras');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['parcelasrec'][$i]);
								echo "</pre>";
								*/
								#### App_Procedimento ####
								$data['procedimento'][$i] = $this->Relatorio_print_model->get_procedimento($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['procedimento'][$i]) > 0) {
									$data['procedimento'][$i] = array_combine(range(1, count($data['procedimento'][$i])), array_values($data['procedimento'][$i]));
									$data['count']['PMCount'][$i] = count($data['procedimento'][$i]);

									if (isset($data['procedimento'][$i])) {

										for($j=1; $j <= $data['count']['PMCount'][$i]; $j++){
											$data['procedimento'][$i][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$i][$j]['DataProcedimento'], 'barras');						
										}
									}
								}					
							}
						}	
					}

					$data['titulo'] = 'Versão Lista Cobrança';
					$data['form_open_path'] = 'Relatorio_print/cobrancas_lista';
					$data['panel'] = 'info';
					$data['metodo'] = 1;
					$data['imprimir'] = 'OrcatrataPrint/imprimir/';
					$data['imprimirlista'] = 'Relatorio_print/cobrancas_lista/';
					$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
					
					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$this->load->view('Relatorio_print/print_cobrancas_lista', $data);
				}
			}	
		}
        $this->load->view('basico/footer');

    }

    public function cobrancas_recibo($id = FALSE) {

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
						
				$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroCobrancas']['DataInicio4'], 'barras');
				$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroCobrancas']['DataFim4'], 'barras');
				
				$data['pesquisa_query'] = $this->Relatorio_print_model->get_cobrancas($_SESSION['FiltroCobrancas'], TRUE);
				
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'relatorio/cobrancas' . $data['msg']);
					exit();
				}else{

					$config['base_url'] = base_url() . 'Relatorio_print/cobrancas_recibo/' . $id . '/';
					$config['total_rows'] = $data['pesquisa_query'];
					$config['per_page'] = 12;
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
					$data['orcatrata'] = $this->Relatorio_print_model->get_cobrancas($_SESSION['FiltroCobrancas'], FALSE, $config['per_page'], ($page * $config['per_page']));
					if (count($data['orcatrata']) > 0) {
						$data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
						$data['count']['POCount'] = count($data['orcatrata']);           

						if (isset($data['orcatrata'])) {

							for($i=1;$i<=$data['count']['POCount'];$i++) {

								$data['orcatrata'][$i]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataOrca'], 'barras');
								$data['orcatrata'][$i]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataEntregaOrca'], 'barras');
								$data['orcatrata'][$i]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataVencimentoOrca'], 'barras');
								$data['orcatrata'][$i]['ValorFinalOrca'] = number_format(($data['orcatrata'][$i]['ValorFinalOrca']), 2, ',', '.');
								$data['orcatrata'][$i]['ConcluidoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['ConcluidoOrca'], 'NS');
								$data['orcatrata'][$i]['QuitadoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['QuitadoOrca'], 'NS');
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['orcatrata'][$i]);
								echo "</pre>";
								*/
								#### App_ProdutoVenda ####
								$data['produto'][$i] = $this->Relatorio_print_model->get_produto($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['produto'][$i]) > 0) {
									$data['produto'][$i] = array_combine(range(1, count($data['produto'][$i])), array_values($data['produto'][$i]));
									$data['count']['PCount'][$i] = count($data['produto'][$i]);

									if (isset($data['produto'][$i])) {

										for($k=1;$k<=$data['count']['PCount'][$i];$k++) {
											$data['produto'][$i][$k]['SubtotalProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto'] * $data['produto'][$i][$k]['QtdProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['ValorProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$i][$k]['DataValidadeProduto'], 'barras');
											$data['produto'][$i][$k]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['ConcluidoProduto'], 'NS');
											$data['produto'][$i][$k]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['DevolvidoProduto'], 'NS');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['produto'][$i]);
								echo "</pre>";
								*/		
								#### App_Parcelas####
								$data['parcelasrec'][$i] = $this->Relatorio_print_model->get_parcelasrec($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['parcelasrec'][$i]) > 0) {
									$data['parcelasrec'][$i] = array_combine(range(1, count($data['parcelasrec'][$i])), array_values($data['parcelasrec'][$i]));
									$data['count']['PRCount'][$i] = count($data['parcelasrec'][$i]);
									
									if (isset($data['parcelasrec'][$i])) {

										for($j=1; $j <= $data['count']['PRCount'][$i]; $j++) {
											$data['parcelasrec'][$i][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataVencimento'], 'barras');
											$data['parcelasrec'][$i][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataPago'], 'barras');
											$data['parcelasrec'][$i][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataLanc'], 'barras');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['parcelasrec'][$i]);
								echo "</pre>";
								*/
								#### App_Procedimento ####
								$data['procedimento'][$i] = $this->Relatorio_print_model->get_procedimento($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['procedimento'][$i]) > 0) {
									$data['procedimento'][$i] = array_combine(range(1, count($data['procedimento'][$i])), array_values($data['procedimento'][$i]));
									$data['count']['PMCount'][$i] = count($data['procedimento'][$i]);

									if (isset($data['procedimento'][$i])) {

										for($j=1; $j <= $data['count']['PMCount'][$i]; $j++){
											$data['procedimento'][$i][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$i][$j]['DataProcedimento'], 'barras');						
										}
									}
								}						
								
							}
						}	
					}

					$data['titulo'] = 'Versão Recibo Cobrança';
					$data['form_open_path'] = 'Relatorio_print/cobrancas_recibo';
					$data['panel'] = 'info';
					$data['metodo'] = 1;
					$data['imprimir'] = 'OrcatrataPrint/imprimir/';
					$data['imprimirlista'] = 'Relatorio_print/cobrancas_lista/';
					$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';		
					

					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$this->load->view('Relatorio_print/print_cobrancas_recibo', $data);			
				}
			}
		}
        $this->load->view('basico/footer');

    }

	public function debitos_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Debitos Sem Filtros';
				$data['metodo'] = $id;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroDebitos'])){
					$dados = $_SESSION['FiltroDebitos'];
					$data['titulo'] = 'Debitos Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Debitos Sem Filtros';
					$data['metodo'] = 1;
				}
			}elseif($id == 3){
				if(isset($_SESSION['FiltroDebitos'])){
					$dados = $_SESSION['FiltroDebitos'];
					$data['titulo'] = 'Debitos Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Debitos Sem Filtros';
					$data['metodo'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Debitos Sem Filtros';
				$data['metodo'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Debitos Sem Filtros';
			$data['metodo'] = 1;
		}

        $data['nome'] = 'Fornecedor';

		$data['report'] = $this->Relatorio_model->list_debitos($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio/debitos' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Relatorio_print/list_debitos_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

    public function debitos_lista($id = FALSE) {

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
				
				$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroDebitos']['DataInicio4'], 'barras');
				$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroDebitos']['DataFim4'], 'barras');
		
				$data['pesquisa_query'] = $this->Relatorio_print_model->get_debitos($_SESSION['FiltroDebitos'], TRUE);
				
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'relatorio/debitos' . $data['msg']);
					exit();
				}else{

					$config['base_url'] = base_url() . 'Relatorio_print/debitos_lista/' . $id . '/';
					$config['total_rows'] = $data['pesquisa_query'];
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
					$data['orcatrata'] = $this->Relatorio_print_model->get_debitos($_SESSION['FiltroDebitos'], FALSE, $config['per_page'], ($page * $config['per_page']));
					if (count($data['orcatrata']) > 0) {
						$data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
						$data['count']['POCount'] = count($data['orcatrata']);           

						if (isset($data['orcatrata'])) {

							for($i=1;$i<=$data['count']['POCount'];$i++) {

								$data['orcatrata'][$i]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataOrca'], 'barras');
								$data['orcatrata'][$i]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataEntregaOrca'], 'barras');
								$data['orcatrata'][$i]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataVencimentoOrca'], 'barras');
								$data['orcatrata'][$i]['ValorFinalOrca'] = number_format(($data['orcatrata'][$i]['ValorFinalOrca']), 2, ',', '.');
								$data['orcatrata'][$i]['ConcluidoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['ConcluidoOrca'], 'NS');
								$data['orcatrata'][$i]['QuitadoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['QuitadoOrca'], 'NS');
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['orcatrata'][$i]);
								echo "</pre>";
								*/
								#### App_ProdutoVenda ####
								$data['produto'][$i] = $this->Relatorio_print_model->get_produto($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['produto'][$i]) > 0) {
									$data['produto'][$i] = array_combine(range(1, count($data['produto'][$i])), array_values($data['produto'][$i]));
									$data['count']['PCount'][$i] = count($data['produto'][$i]);

									if (isset($data['produto'][$i])) {

										for($k=1;$k<=$data['count']['PCount'][$i];$k++) {
											$data['produto'][$i][$k]['SubtotalProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto'] * $data['produto'][$i][$k]['QtdProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['ValorProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$i][$k]['DataValidadeProduto'], 'barras');
											$data['produto'][$i][$k]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['ConcluidoProduto'], 'NS');
											$data['produto'][$i][$k]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['DevolvidoProduto'], 'NS');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['produto'][$i]);
								echo "</pre>";
								*/		
								#### App_Parcelas####
								$data['parcelasrec'][$i] = $this->Relatorio_print_model->get_parcelasrec($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['parcelasrec'][$i]) > 0) {
									$data['parcelasrec'][$i] = array_combine(range(1, count($data['parcelasrec'][$i])), array_values($data['parcelasrec'][$i]));
									$data['count']['PRCount'][$i] = count($data['parcelasrec'][$i]);
									
									if (isset($data['parcelasrec'][$i])) {

										for($j=1; $j <= $data['count']['PRCount'][$i]; $j++) {
											$data['parcelasrec'][$i][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataVencimento'], 'barras');
											$data['parcelasrec'][$i][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataPago'], 'barras');
											$data['parcelasrec'][$i][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataLanc'], 'barras');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['parcelasrec'][$i]);
								echo "</pre>";
								*/
								#### App_Procedimento ####
								$data['procedimento'][$i] = $this->Relatorio_print_model->get_procedimento($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['procedimento'][$i]) > 0) {
									$data['procedimento'][$i] = array_combine(range(1, count($data['procedimento'][$i])), array_values($data['procedimento'][$i]));
									$data['count']['PMCount'][$i] = count($data['procedimento'][$i]);

									if (isset($data['procedimento'][$i])) {

										for($j=1; $j <= $data['count']['PMCount'][$i]; $j++){
											$data['procedimento'][$i][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$i][$j]['DataProcedimento'], 'barras');						
										}
									}
								}					
							}
						}	
					}

					$data['titulo'] = 'Versão Lista Cobrança';
					$data['form_open_path'] = 'Relatorio_print/debitos_lista';
					$data['panel'] = 'danger';
					$data['metodo'] = 1;
					$data['imprimir'] = 'OrcatrataPrint/imprimir/';
					$data['imprimirlista'] = 'Relatorio_print/debitos_lista/';
					$data['imprimirrecibo'] = 'Relatorio_print/debitos_recibo/';
					
					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$this->load->view('Relatorio_print/print_debitos_lista', $data);
				}
			}	
		}
        $this->load->view('basico/footer');

    }

    public function debitos_recibo($id = FALSE) {

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
						
				$data['Imprimir']['DataInicio4'] = $this->basico->mascara_data($_SESSION['FiltroDebitos']['DataInicio4'], 'barras');
				$data['Imprimir']['DataFim4'] = $this->basico->mascara_data($_SESSION['FiltroDebitos']['DataFim4'], 'barras');
				
				$data['pesquisa_query'] = $this->Relatorio_print_model->get_debitos($_SESSION['FiltroDebitos'], TRUE);
				
				if($data['pesquisa_query'] === FALSE){
					
					$data['msg'] = '?m=4';
					redirect(base_url() . 'relatorio/debitos' . $data['msg']);
					exit();
				}else{

					$config['base_url'] = base_url() . 'Relatorio_print/debitos_recibo/' . $id . '/';
					$config['total_rows'] = $data['pesquisa_query'];
					$config['per_page'] = 12;
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
					$data['orcatrata'] = $this->Relatorio_print_model->get_debitos($_SESSION['FiltroDebitos'], FALSE, $config['per_page'], ($page * $config['per_page']));
					if (count($data['orcatrata']) > 0) {
						$data['orcatrata'] = array_combine(range(1, count($data['orcatrata'])), array_values($data['orcatrata']));
						$data['count']['POCount'] = count($data['orcatrata']);           

						if (isset($data['orcatrata'])) {

							for($i=1;$i<=$data['count']['POCount'];$i++) {

								$data['orcatrata'][$i]['DataOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataOrca'], 'barras');
								$data['orcatrata'][$i]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataEntregaOrca'], 'barras');
								$data['orcatrata'][$i]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata'][$i]['DataVencimentoOrca'], 'barras');
								$data['orcatrata'][$i]['ValorFinalOrca'] = number_format(($data['orcatrata'][$i]['ValorFinalOrca']), 2, ',', '.');
								$data['orcatrata'][$i]['ConcluidoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['ConcluidoOrca'], 'NS');
								$data['orcatrata'][$i]['QuitadoOrca'] = $this->basico->mascara_palavra_completa($data['orcatrata'][$i]['QuitadoOrca'], 'NS');
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['orcatrata'][$i]);
								echo "</pre>";
								*/
								#### App_ProdutoVenda ####
								$data['produto'][$i] = $this->Relatorio_print_model->get_produto($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['produto'][$i]) > 0) {
									$data['produto'][$i] = array_combine(range(1, count($data['produto'][$i])), array_values($data['produto'][$i]));
									$data['count']['PCount'][$i] = count($data['produto'][$i]);

									if (isset($data['produto'][$i])) {

										for($k=1;$k<=$data['count']['PCount'][$i];$k++) {
											$data['produto'][$i][$k]['SubtotalProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto'] * $data['produto'][$i][$k]['QtdProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['ValorProduto'] = number_format(($data['produto'][$i][$k]['ValorProduto']), 2, ',', '.');
											$data['produto'][$i][$k]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$i][$k]['DataValidadeProduto'], 'barras');
											$data['produto'][$i][$k]['ConcluidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['ConcluidoProduto'], 'NS');
											$data['produto'][$i][$k]['DevolvidoProduto'] = $this->basico->mascara_palavra_completa($data['produto'][$i][$k]['DevolvidoProduto'], 'NS');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['produto'][$i]);
								echo "</pre>";
								*/		
								#### App_Parcelas####
								$data['parcelasrec'][$i] = $this->Relatorio_print_model->get_parcelasrec($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['parcelasrec'][$i]) > 0) {
									$data['parcelasrec'][$i] = array_combine(range(1, count($data['parcelasrec'][$i])), array_values($data['parcelasrec'][$i]));
									$data['count']['PRCount'][$i] = count($data['parcelasrec'][$i]);
									
									if (isset($data['parcelasrec'][$i])) {

										for($j=1; $j <= $data['count']['PRCount'][$i]; $j++) {
											$data['parcelasrec'][$i][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataVencimento'], 'barras');
											$data['parcelasrec'][$i][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataPago'], 'barras');
											$data['parcelasrec'][$i][$j]['DataLanc'] = $this->basico->mascara_data($data['parcelasrec'][$i][$j]['DataLanc'], 'barras');
										}
									}
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($data['parcelasrec'][$i]);
								echo "</pre>";
								*/
								#### App_Procedimento ####
								$data['procedimento'][$i] = $this->Relatorio_print_model->get_procedimento($data['orcatrata'][$i]['idApp_OrcaTrata']);
								if (count($data['procedimento'][$i]) > 0) {
									$data['procedimento'][$i] = array_combine(range(1, count($data['procedimento'][$i])), array_values($data['procedimento'][$i]));
									$data['count']['PMCount'][$i] = count($data['procedimento'][$i]);

									if (isset($data['procedimento'][$i])) {

										for($j=1; $j <= $data['count']['PMCount'][$i]; $j++){
											$data['procedimento'][$i][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$i][$j]['DataProcedimento'], 'barras');						
										}
									}
								}						
								
							}
						}	
					}

					$data['titulo'] = 'Versão Recibo Debito';
					$data['form_open_path'] = 'Relatorio_print/debitos_recibo';
					$data['panel'] = 'danger';
					$data['metodo'] = 1;
					$data['imprimir'] = 'OrcatrataPrint/imprimir/';
					$data['imprimirlista'] = 'Relatorio_print/debitos_lista/';
					$data['imprimirrecibo'] = 'Relatorio_print/debitos_recibo/';		
					

					/*
					  echo '<br>';
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  #exit ();
					 */

					$this->load->view('Relatorio_print/print_debitos_recibo', $data);			
				}
			}
		}
        $this->load->view('basico/footer');

    }

	public function comissao_lista() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		//$data['query']['nome'] = 'Cliente';
		$data['titulo'] = 'Comissão Colaborador';
		$data['form_open_path'] = 'relatorio_pag/comissao_pag';
		$data['baixatodas'] = 'Orcatrata/baixadacomissao/';
		$data['baixa'] = 'Orcatrata/baixadareceita/';
		$data['nomeusuario'] = 'NomeColaborador';
		$data['status'] = 'StatusComissaoOrca';
		$data['alterar'] = 'relatorio/comissao/';
		$data['editar'] = 1;
		$data['metodo'] = 1;
		$data['panel'] = 'info';
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
		$data['nome'] = 'Cliente';
		if($_SESSION['Usuario']['Permissao_Comissao'] == 3){
			$data['print'] = 1;
		}else{
			$data['print'] = 0;
		}	
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'Relatorio_print/comissao_lista/';
		$data['imprimirrecibo'] = 'Relatorio_print/comissao_recibo/';
		$data['edit'] = 'orcatrata/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';
		
		$data['paginacao'] = 'S';
		$data['caminho'] = 'relatorio/comissao/';

		$data['pesquisa_query'] = $this->Relatorio_model->list_comissao($_SESSION['FiltroComissao'],TRUE, TRUE);
		
		if($data['pesquisa_query'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio/comissao' . $data['msg']);
			exit();
		}else{

			$config['total_rows'] = $data['pesquisa_query']->num_rows();

			$config['base_url'] = base_url() . 'relatorio_print/comissao_lista/';

			$config['per_page'] = 19;
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
			
			$data['report'] = $this->Relatorio_model->list_comissao($_SESSION['FiltroComissao'], TRUE, FALSE, $config['per_page'], ($page * $config['per_page']));			
			
			$data['pagination'] = $this->pagination->create_links();

			$data['list1'] = $this->load->view('Relatorio_print/list_comissao_lista', $data, TRUE);
		}
        $this->load->view('relatorio/tela_comissao', $data);

        $this->load->view('basico/footer');

    }

	public function comissao_excel($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		if($id){
			if($id == 1){
				$dados = FALSE;
				$data['titulo'] = 'Receitas Sem Filtros';
				$data['metodo'] = $id;
			}elseif($id == 2){
				if(isset($_SESSION['FiltroReceitas'])){
					$dados = $_SESSION['FiltroReceitas'];
					$data['titulo'] = 'Receitas Com Filtros';
					$data['metodo'] = $id;
				}else{
					$dados = FALSE;
					$data['titulo'] = 'Receitas Sem Filtros';
					$data['metodo'] = 1;
				}
			}else{
				$dados = FALSE;
				$data['titulo'] = 'Receitas Sem Filtros';
				$data['metodo'] = 1;
			}
		}else{
			$dados = FALSE;
			$data['titulo'] = 'Receitas Sem Filtros';
			$data['metodo'] = 1;
		}

        $data['nome'] = 'Cliente';

		$data['report'] = $this->Relatorio_model->list_receitas($dados, TRUE, FALSE, FALSE, FALSE);
		
		if($data['report'] === FALSE){
			
			$data['msg'] = '?m=4';
			redirect(base_url() . 'relatorio/receitas' . $data['msg']);
			exit();
		}else{

			$data['list1'] = $this->load->view('Relatorio_print/list_receitas_excel', $data, TRUE);
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
				$data['imprimirrecibo'] = 'Relatorio_print/cobrancas_recibo/';
				
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

}