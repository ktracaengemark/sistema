<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_excel extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array(
									'Basico_model', 'Cliente_model', 'Relatorio_model', 'Empresa_model', 
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

	public function receitas($id = FALSE) {

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

			$data['list1'] = $this->load->view('relatorio_excel/list_receitas_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

	public function despesas($id = FALSE) {

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

			$data['list1'] = $this->load->view('relatorio_excel/list_despesas_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }

	public function cobrancas($id = FALSE) {

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

			$data['list1'] = $this->load->view('relatorio_excel/list_cobrancas_excel', $data, TRUE);
		}

        $this->load->view('basico/footer');

    }
	
}