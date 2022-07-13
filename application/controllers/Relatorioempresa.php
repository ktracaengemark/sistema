<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorioempresa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Relatorioempresa_model', 'Login_model', 'Empresa_model', 'Usuario_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

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

        $this->load->view('relatorioempresa/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

	public function receitas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'Ano',
			'Mesvenc',
			'Mespag',			
			'TipoReceita',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'QuitadoRecebiveis',
			'Modalidade',
        ), TRUE));
/*
		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = date("d/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		
		if (!$data['query']['DataFim2'])
           $data['query']['DataFim2'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
						
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2018';
		
		if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));

	   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
	   
	   if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());
*/
		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());
	   
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		#$this->form_validation->set_rules('Mesvenc', 'Mês do Vencimento', 'required|trim');
		#$this->form_validation->set_rules('Mespag', 'Mês do Pagamento', 'required|trim');
		#$this->form_validation->set_rules('Ano', 'Ano', 'required|trim');        
		$this->form_validation->set_rules('DataInicio', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início do Pagamento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim do Pagamento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Orçamento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Orçamento', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            'S' => 'Sim',
			'N' => 'Não',
			'#' => 'TODOS',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['QuitadoRecebiveis'] = array(
            '#' => 'TODOS',
			'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Modalidade'] = array(
            '#' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
        $data['select']['Campo'] = array(
            'PR.DataVencimentoRecebiveis' => 'Data do Venc.',
			'PR.DataPagoRecebiveis' => 'Data do Pagam.',
			'PR.QuitadoRecebiveis' => 'Quit.Parc.',
			'C.NomeCliente' => 'Nome do Cliente',
			'TR.TipoReceita' => 'Tipo de Receita',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrataCli' => 'Número do Orçamento',
            'OT.DataOrca' => 'Data do Orçamento',
            'OT.ValorOrca' => 'Valor do Orçamento',
            'OT.ConcluidoOrca' => 'Serviço Concluído?',
            'OT.QuitadoOrca' => 'Orçamento Quitado?',
            'OT.DataRetorno' => 'Data de Retorno',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorioempresa_model->select_cliente();
		$data['select']['TipoReceita'] = $this->Relatorioempresa_model->select_tiporeceita();
		$data['select']['Mesvenc'] = $this->Relatorioempresa_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorioempresa_model->select_mes();
		/*
        $data['select']['Pesquisa'] = array(
            'DataEntradaOrca' => 'Data de Entrada',
            'DataVencimentoRecebiveis' => 'Data de Vencimento da Parcela',
        );
        */


        $data['titulo'] = 'Receitas & Pagamentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoReceita'] = $data['query']['TipoReceita'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['QuitadoRecebiveis'] = $data['query']['QuitadoRecebiveis'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['report'] = $this->Relatorioempresa_model->list_receitas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_receitas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_receitas', $data);

        $this->load->view('basico/footer');

    }
	
	public function adminempresa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Relatório 1';
		$data['titulo2'] = 'Relatório 2';
		$data['titulo2'] = 'Relatório 3';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorioempresa/tela_adminempresa', $data);

        $this->load->view('basico/footer');

    }	

	public function sistemaempresa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Assinatura';
		$data['titulo2'] = 'Comissão';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorioempresa/tela_sistemaempresa', $data);

        $this->load->view('basico/footer');

    }

	public function funcionario() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'F.Nivel' => 'Nivel',
            'F.Nome' => 'Nome do Usuário',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorioempresa_model->select_funcionario();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
        
		$data['titulo'] = 'Usuários';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresa_model->list_funcionario($data['bd'],TRUE);
			$data['total'] = $data['report']->num_rows();
            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_funcionario', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_funcionario', $data);

        $this->load->view('basico/footer');



    }

	public function colaboradoronline() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
			'Inativo',
			'DataCriacao',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'U.Nome' => 'Nome do Colaborador',
			'UOL.DataCriacao' => 'Data do Cadastro',
			'UOL.Inativo' => 'Ativo',
        );
		
        $data['select']['Inativo'] = array(
			'0' => 'TODOS',            
			'2' => 'Sim',
			'1' => 'Não',
        );
		
        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorioempresa_model->select_colaboradoronline();
		#$data['select']['Inativo'] = $this->Basico_model->select_inativo();
        
		$data['titulo'] = 'Colaboradores Online';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
			$data['bd']['DataCriacao'] = $data['query']['DataCriacao'];
			$data['bd']['Inativo'] = $data['query']['Inativo'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresa_model->list_colaboradoronline($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_colaboradoronline', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_colaboradoronline', $data);

        $this->load->view('basico/footer');

    }
	
	public function empresafilial() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'F.Nome' => 'Nome do Usuário',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorioempresa_model->select_empresafilial();

        $data['titulo'] = 'Relatório Empresa ';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresa_model->list_empresafilial($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_empresafilial', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

$this->load->view('relatorioempresa/tela_empresafilial', $data);

        $this->load->view('basico/footer');



    }

	public function associado() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'CategoriaEmpresa',
			'Atuacao',			
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');



		$data['select']['Campo'] = array(
            'E.NomeEmpresa' => 'Nome da Empresa',
			'CE.CategoriaEmpresa' => 'Categoria',
            'E.Bairro' => 'Bairro',
            'E.Municipio' => 'Município',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorioempresa_model->select_associado();
		$data['select']['CategoriaEmpresa'] = $this->Relatorioempresa_model->select_categoriaempresa();
		$data['select']['Atuacao'] = $this->Relatorioempresa_model->select_atuacao();		

        $data['titulo'] = 'Associados';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['CategoriaEmpresa'] = $data['query']['CategoriaEmpresa'];
			$data['bd']['Atuacao'] = $data['query']['Atuacao'];			
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresa_model->list_associado($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_associado', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_associado', $data);

        $this->load->view('basico/footer');

    }
	
	public function empresas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'CategoriaEmpresa',
			'Atuacao',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.NomeEmpresa' => 'Nome da Empresa',
			'CE.CategoriaEmpresa' => 'Categoria',
            'E.BairroEmpresa' => 'Bairro',
            'E.MunicipioEmpresa' => 'Município',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorioempresa_model->select_empresas();
		$data['select']['CategoriaEmpresa'] = $this->Relatorioempresa_model->select_categoriaempresa();
		$data['select']['Atuacao'] = $this->Relatorioempresa_model->select_atuacao();

        $data['titulo'] = 'Empresas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['CategoriaEmpresa'] = $data['query']['CategoriaEmpresa'];
			$data['bd']['Atuacao'] = $data['query']['Atuacao'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresa_model->list_empresas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_empresas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_empresas', $data);

        $this->load->view('basico/footer');

    }
	
	public function empresas2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.idSis_Empresa' => 'nº Empresa',
			'E.NomeEmpresa' => 'Nome da Empresa',
            'E.Bairro' => 'Bairro',
            'E.Municipio' => 'Município',
            'E.Email' => 'E-mail',


        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorioempresa_model->select_empresas();

        $data['titulo'] = 'Relatório de Empresas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresa_model->list_empresas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_empresas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_empresas', $data);

        $this->load->view('basico/footer');

    }

    public function login() {
		
		if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o login novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o login para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        #Get GET or POST data
        $empresa = $this->input->get_post('idSis_Empresa');
		$celular = $this->input->get_post('CelularUsuario');
		$senha = md5($this->input->get_post('Senha'));

		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa3();

        #set validation rules
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('CelularUsuario', 'Celular do Usuário', 'required|trim');
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5');
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('relatorioempresa/form_login', $data);
        } else {

            session_regenerate_id(true);

			$query = $this->Login_model->check_dados_empresa($empresa, $celular, $senha, TRUE);
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */

            if ($query === FALSE) {
			
                $data['msg'] = $this->basico->msg('<strong>Celular ou Senha</strong> incorretos.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('relatorioempresa/form_login', $data);

            } else {
			
				if ($this->Login_model->check_usuario($empresa, $celular, $senha) == 1) {
					$data['msg'] = $this->basico->msg('<strong>Usuario</strong> não existe.', 'erro', FALSE, FALSE, FALSE);
					$this->load->view('relatorioempresa/form_login', $data);
				} else if ($this->Login_model->check_usuario($empresa, $celular, $senha) == 2) {
					$data['msg'] = $this->basico->msg('<strong>Usuario</strong> inativo! Fale com o Administrador da sua Empresa!', 'erro', FALSE, FALSE, FALSE);
					$this->load->view('relatorioempresa/form_login', $data);
				} else {
					#initialize session
					$this->load->driver('session');
					
					$_SESSION['Empresa']  = $data['empresa'] = $this->Empresa_model->get_empresa($empresa, TRUE);
					$_SESSION['Usuario']  = $data['usuario'] = $this->Usuario_model->get_usuario($query['idSis_Usuario'], TRUE);

					if ($data['empresa'] === FALSE || $data['usuario'] === FALSE ) {
					
						$data['msg'] = $this->basico->msg('<strong>Empresa, Celular ou Senha</strong> incorretos.', 'erro', FALSE, FALSE, FALSE);
						$this->load->view('relatorioempresa/form_login', $data);
						
					} else {
			
						if($_SESSION['Usuario']['Horario_Atend'] == "S"){
							
							if($this->Empresa_model->get_horario_atend($empresa) === TRUE){
								
								unset($_SESSION['log']);		
										
								$_SESSION['log']['Agenda'] = $this->Login_model->get_agenda_padrao($query['idSis_Usuario']);
								
								#### Carrega os dados da Empresa nas vari?ves de sess?o ####

								$query2 = $this->Login_model->check_documentos_log($empresa, TRUE);
								$_SESSION['log']['Icone'] = $query2['Icone'];

								$query3 = $this->Login_model->dados_empresa_log($empresa);			
								$_SESSION['log']['NivelEmpresa'] = $query3['NivelEmpresa'];
								$_SESSION['log']['TabelasEmpresa'] = $query3['TabelasEmpresa'];
								$_SESSION['log']['DataDeValidade'] = $query3['DataDeValidade'];
								$_SESSION['log']['Site'] = $query3['Site'];
								$_SESSION['log']['Arquivo_Empresa'] = $query3['Arquivo'];
								$_SESSION['log']['NomeEmpresa'] = $query3['NomeEmpresa'];
								$_SESSION['log']['NomeEmpresa2'] = (strlen($query3['NomeEmpresa']) > 6) ? substr($query3['NomeEmpresa'], 0, 6) : $query3['NomeEmpresa'];			
							
								#$_SESSION['log']['Usuario'] = $query['Usuario'];
								//se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
								$_SESSION['log']['Usuario'] = (strlen($query['Usuario']) > 13) ? substr($query['Usuario'], 0, 13) : $query['Usuario'];
								$_SESSION['log']['Nome'] = $query['Nome'];
								$_SESSION['log']['Nome2'] = (strlen($query['Nome']) > 6) ? substr($query['Nome'], 0, 6) : $query['Nome'];
								$_SESSION['log']['CpfUsuario'] = $query['CpfUsuario'];
								$_SESSION['log']['CelularUsuario'] = $query['CelularUsuario'];
								$_SESSION['log']['idSis_Usuario'] = $query['idSis_Usuario'];
								$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
								$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
								$_SESSION['log']['idTab_Modulo'] = $query['idTab_Modulo'];
								$_SESSION['log']['Permissao'] = $query['Permissao'];
								$_SESSION['log']['Arquivo'] = $query['Arquivo'];
								$_SESSION['log']['Cad_Orcam'] = $query['Cad_Orcam'];

								$this->load->database();
								$_SESSION['db']['hostname'] = $this->db->hostname;
								$_SESSION['db']['username'] = $this->db->username;
								$_SESSION['db']['password'] = $this->db->password;
								$_SESSION['db']['database'] = $this->db->database;

								if ($this->Login_model->set_acesso($_SESSION['log']['idSis_Usuario'], 'LOGIN') === FALSE) {
									$msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

									$this->basico->erro($msg);
									$this->load->view('relatorioempresa/form_login');
								} else {
									unset($_SESSION['AdminEmpresa'], $_SESSION['AdminUsuario']);
									unset($_SESSION['QueryUsuario']);
									unset($_SESSION['QueryEmpresa']);
									redirect('acesso');
								}
							}else{
								/*
								$this->session->unset_userdata('log');
								foreach ($_SESSION as $key => $value) {
									if ($key != 'Site_Back') {
										unset($_SESSION[$key]);
									}
								}
								*/
								$data['aviso'] = ''
										. '
									<div class="alert alert-success" role="alert">
										<h4>
											<p><b>Horário de Acesso Negado para esse Usuário ' . $celular . ' !</b></p>
											<p>Entre em contato com o Administrador da sua Empresa</b>.</p>
										</h4>
									</div> '
										. '';

								$this->load->view('login/tela_msg', $data);
							}
						}else{
								
							unset($_SESSION['log']);
							
							$_SESSION['log']['Agenda'] = $this->Login_model->get_agenda_padrao($query['idSis_Usuario']);
							#### Carrega os dados da Empresa nas vari?ves de sess?o ####
							
							$query2 = $this->Login_model->check_documentos_log($empresa, TRUE);
							$_SESSION['log']['Icone'] = $query2['Icone'];

							$query3 = $this->Login_model->dados_empresa_log($empresa);			
							$_SESSION['log']['NivelEmpresa'] = $query3['NivelEmpresa'];
							$_SESSION['log']['TabelasEmpresa'] = $query3['TabelasEmpresa'];
							$_SESSION['log']['DataDeValidade'] = $query3['DataDeValidade'];
							$_SESSION['log']['Site'] = $query3['Site'];
							$_SESSION['log']['Arquivo_Empresa'] = $query3['Arquivo'];
							$_SESSION['log']['NomeEmpresa'] = $query3['NomeEmpresa'];
							$_SESSION['log']['NomeEmpresa2'] = (strlen($query3['NomeEmpresa']) > 6) ? substr($query3['NomeEmpresa'], 0, 6) : $query3['NomeEmpresa'];			
						
							#$_SESSION['log']['Usuario'] = $query['Usuario'];
							//se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
							$_SESSION['log']['Usuario'] = (strlen($query['Usuario']) > 13) ? substr($query['Usuario'], 0, 13) : $query['Usuario'];
							$_SESSION['log']['Nome'] = $query['Nome'];
							$_SESSION['log']['Nome2'] = (strlen($query['Nome']) > 6) ? substr($query['Nome'], 0, 6) : $query['Nome'];
							$_SESSION['log']['CpfUsuario'] = $query['CpfUsuario'];
							$_SESSION['log']['CelularUsuario'] = $query['CelularUsuario'];
							$_SESSION['log']['idSis_Usuario'] = $query['idSis_Usuario'];
							$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
							$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
							$_SESSION['log']['idTab_Modulo'] = $query['idTab_Modulo'];
							$_SESSION['log']['Permissao'] = $query['Permissao'];
							$_SESSION['log']['Arquivo'] = $query['Arquivo'];
							$_SESSION['log']['Cad_Orcam'] = $query['Cad_Orcam'];

							$this->load->database();
							$_SESSION['db']['hostname'] = $this->db->hostname;
							$_SESSION['db']['username'] = $this->db->username;
							$_SESSION['db']['password'] = $this->db->password;
							$_SESSION['db']['database'] = $this->db->database;

							if ($this->Login_model->set_acesso($_SESSION['log']['idSis_Usuario'], 'LOGIN') === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

								$this->basico->erro($msg);
								$this->load->view('form_login2');
							} else {
								unset($_SESSION['AdminEmpresa'], $_SESSION['AdminUsuario']);
								unset($_SESSION['QueryUsuario']);
								unset($_SESSION['QueryEmpresa']);
								redirect('acesso');
							}						
						}						
					}
				}	
            }
        }

        $this->load->view('basico/footer');
    }

    function valid_celular($celular) {

        if ($this->Login_model->check_celular($celular) == 1) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> não existe.');
            return FALSE;
        } else if ($this->Login_model->check_celular($celular) == 2) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> inativo! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    function check_empresa($data) {

        if ($this->Login_model->check_empresa($data) == 1) {
            $this->form_validation->set_message('check_empresa', '<strong>%s</strong> não existe.');
            return FALSE;
        } else if ($this->Login_model->check_empresa($data) == 2) {
            $this->form_validation->set_message('check_empresa', '<strong>%s</strong> inativa! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }	
	
	function valid_empresa($empresa, $celular) {

        if ($this->Login_model->check_dados_empresa($empresa, $celular) == FALSE) {
            $this->form_validation->set_message('valid_empresa', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    function valid_senha($senha, $celular) {

        if ($this->Login_model->check_dados_celular($senha, $celular) == FALSE) {
            $this->form_validation->set_message('valid_senha', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
}
