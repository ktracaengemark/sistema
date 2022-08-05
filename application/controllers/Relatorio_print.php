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