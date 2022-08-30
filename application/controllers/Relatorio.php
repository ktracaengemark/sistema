<?php
	
	#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation', 'pagination'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Relatorio_model', 'Empresa_model', 
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

	public function admin() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
        if($_SESSION['log']['idSis_Empresa'] == 5){
			$data['query'] = $this->Associado_model->get_associado($_SESSION['log']['idSis_Usuario'], TRUE);
		}else{
			$data['query'] = $this->Usuario_model->get_usuario($_SESSION['log']['idSis_Usuario'], TRUE);
		}

		$data['titulo1'] = 'Cadastrar';
		$data['titulo2'] = 'Finanças & Estoque';
		$data['titulo3'] = 'Relatório 3';
		$data['titulo4'] = 'Comissão';
		
		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorio/tela_admin', $data);

        $this->load->view('basico/footer');

    }
	
    public function balanco() {

		unset($_SESSION['FiltroBalanco']);
	
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$acesso = FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$acesso = TRUE;
		}else{
			if ($_SESSION['Usuario']['Rel_Pag'] == "S" && $_SESSION['Usuario']['Rel_Est'] == "S") {
				$acesso = TRUE;
			}	
		}
		
		if ($acesso === FALSE) {

			$data['msg'] = '?m=4';
			redirect(base_url() . $this->Basico_model->acesso() . $data['msg']);
			exit();
			
		} else {
			
			$data['datepicker'] = 'DatePicker';
			$data['timepicker'] = 'TimePicker';
			$data['collapse'] = '';	
			$data['collapse1'] = 'class="collapse"';
			
			$data['query'] = quotes_to_entities($this->input->post(array(
				'Ano',
				'Mesvenc',
				'Diavenc',
				'AprovadoOrca',
				'CombinadoFrete',
				'Quitado',
			), TRUE));

			$data['select']['AprovadoOrca'] = array(
				'0' => 'TODOS',
				'S' => 'Aprovado',
				'N' => 'Não Aprovado',
			);
			
			$data['select']['CombinadoFrete'] = array(
				'0' => 'TODOS',
				'S' => 'Aprovado',
				'N' => 'Não Aprovado',
			);

			$data['select']['Quitado'] = array(
				'0' => 'TODAS',
				'S' => 'Pagas',
				'N' => 'Não Pagas',
			);

			$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
			$data['select']['Diavenc'] = $this->Relatorio_model->select_dia();
			$data['select']['Ano'] = $this->Relatorio_model->select_ano();

			if (!$data['query']['Diavenc'])
			   $data['query']['Diavenc'] = date('d', time());
		   
			if (!$data['query']['Mesvenc'])
			   $data['query']['Mesvenc'] = date('m', time());
		   
			if (!$data['query']['Ano'])
			   $data['query']['Ano'] = date('Y', time());
			
			$_SESSION['FiltroBalanco']['Ano'] = $data['query']['Ano'];
			$_SESSION['FiltroBalanco']['Mesvenc'] = $data['query']['Mesvenc'];
			$_SESSION['FiltroBalanco']['Diavenc'] = $data['query']['Diavenc'];
			$_SESSION['FiltroBalanco']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$_SESSION['FiltroBalanco']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$_SESSION['FiltroBalanco']['Quitado'] = $data['query']['Quitado'];

			
			$data['balancodiario'] = $this->Relatorio_model->list_balancodiario($_SESSION['FiltroBalanco']);

			$data['titulo3'] = 'Anual';
			$data['report'] = $this->Relatorio_model->list_balancoanual($_SESSION['FiltroBalanco']);

			$data['list3'] = $this->load->view('relatorio/list_balancodiaria', $data, TRUE);

			$data['list'] = $this->load->view('relatorio/list_balancoanual', $data, TRUE);

			
			$this->load->view('relatorio/tela_balanco', $data);
		}
        $this->load->view('basico/footer');

    }
	
    public function balanco_print() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['balancodiario'] = $this->Relatorio_model->list_balancodiario($_SESSION['FiltroBalanco']);

		$data['list3'] = $this->load->view('relatorio/list_balancodiaria_print', $data, TRUE);

        $this->load->view('relatorio/tela_balanco_print', $data);

        $this->load->view('basico/footer');

    }
			
    public function estoque() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Produtos',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        #$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(

			'TP.Nome_Prod' => 'Produto',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );


        $data['select']['Produtos'] = $this->Relatorio_model->select_produtos();


        $data['titulo'] = 'Relatório de Estoque';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_estoque($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              #exit();
              #*/

            $data['list'] = $this->load->view('relatorio/list_estoque', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_estoque', $data);

        $this->load->view('basico/footer');

    }

    public function estoque2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Produtos',
            'CodProd',			
            'DataInicio',
            'DataFim',
			'idTab_Catprod',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        #$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(
			'TP.Produtos' => 'Produto',	
			'TP.idTab_Catprod' => 'Categoria',
			'TP.CodProd' => 'Código',
			'TP.TipoProduto' => 'V/C/A',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );


        $data['select']['Produtos'] = $this->Relatorio_model->select_produtos();


        $data['titulo'] = 'Relatório de Estoque';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['CodProd'] = $data['query']['CodProd'];	
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_estoque($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              #exit();
              #*/

            $data['list'] = $this->load->view('relatorio/list_estoque2', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_estoque2', $data);

        $this->load->view('basico/footer');

    }

	public function rankingformapag() {

	if ($this->input->get('m') == 1)
		$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
	elseif ($this->input->get('m') == 2)
		$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
	else
		$data['msg'] = '';

	$data['query'] = quotes_to_entities($this->input->post(array(
		'ValorOrca',
		'FormaPag',
		'idTab_FormaPag',
		'DataInicio',
		'DataFim',
		'Ordenamento',
		'Campo',
	), TRUE));

	$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
	#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
	#$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
	#$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

	$data['select']['Campo'] = array(
		'FP.FormaPag' => 'Pagamento',
		'FP.idTab_FormaPag' => 'Id',
	);

	$data['select']['Ordenamento'] = array(
		'ASC' => 'Crescente',
		'DESC' => 'Decrescente',
	);

	$data['select']['FormaPag'] = $this->Relatorio_model->select_formapag();
	$data['select']['idTab_FormaPag'] = $this->Relatorio_model->select_formapag();

	$data['titulo'] = 'Ranking de Pagamentos';

	#run form validation
	if ($this->form_validation->run() !== TRUE) {

		$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$data['bd']['FormaPag'] = $data['query']['FormaPag'];
		$data['bd']['idTab_FormaPag'] = $data['query']['idTab_FormaPag'];
		$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
		$data['bd']['Campo'] = $data['query']['Campo'];

		$data['report'] = $this->Relatorio_model->list_rankingformapag($data['bd'],TRUE);

		/*
		  echo "<pre>";
		  print_r($data['report']);
		  echo "</pre>";
		  #exit();
		  #*/

		$data['list'] = $this->load->view('relatorio/list_rankingformapag', $data, TRUE);
		//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
	}

	$this->load->view('relatorio/tela_rankingformapag', $data);

	$this->load->view('basico/footer');

}

	public function rankingformaentrega() {

	if ($this->input->get('m') == 1)
		$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
	elseif ($this->input->get('m') == 2)
		$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
	else
		$data['msg'] = '';

	$data['query'] = quotes_to_entities($this->input->post(array(
		'ValorOrca',
		'ValorFrete',
		'TipoFrete',
		'idTab_TipoFrete',
		'DataInicio',
		'DataFim',
		'Ordenamento',
		'Campo',
	), TRUE));

	$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
	#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
	#$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
	#$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

	$data['select']['Campo'] = array(
		'FP.TipoFrete' => 'Tipo de Entrega',
		'FP.idTab_TipoFrete' => 'Id',
	);

	$data['select']['Ordenamento'] = array(
		'ASC' => 'Crescente',
		'DESC' => 'Decrescente',
	);

	$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();
	$data['select']['idTab_TipoFrete'] = $this->Relatorio_model->select_tipofrete();

	$data['titulo'] = 'Ranking de Entrega';

	#run form validation
	if ($this->form_validation->run() !== TRUE) {

		$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
		$data['bd']['idTab_TipoFrete'] = $data['query']['idTab_TipoFrete'];
		$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
		$data['bd']['Campo'] = $data['query']['Campo'];

		$data['report'] = $this->Relatorio_model->list_rankingformaentrega($data['bd'],TRUE);

		/*
		  echo "<pre>";
		  print_r($data['report']);
		  echo "</pre>";
		  #exit();
		  #*/

		$data['list'] = $this->load->view('relatorio/list_rankingformaentrega', $data, TRUE);
		//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
	}

	$this->load->view('relatorio/tela_rankingformaentrega', $data);

	$this->load->view('basico/footer');

}

    public function clenkontraki() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'NomeAdmin',
			'Inativo',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['Inativo'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Campo'] = array(
            'C.idSis_Empresa' => 'nº Emp.',
			'C.NomeEmpresa' => 'Empresa',
			'C.NomeAdmin' => 'Admin',
            'C.DataCriacao' => 'Criação',
			'C.DataDeValidade' => 'Validade',
			'C.NivelEmpresa' => 'Nivel',
			'C.Inativo' => 'Ativo',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_clenkontraki();
		
		$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['titulo'] = 'Clientes Enkontraki';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['Inativo'] = $data['query']['Inativo'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_clenkontraki($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_clenkontraki', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_clenkontraki', $data);

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
            'C.NomeEmpresa' => 'Nome da Empresa',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_associado();
		$data['select']['CategoriaEmpresa'] = $this->Relatorio_model->select_categoriaempresa();
		$data['select']['Atuacao'] = $this->Relatorio_model->select_atuacao();		

        $data['titulo'] = 'Associados';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['CategoriaEmpresa'] = $data['query']['CategoriaEmpresa'];
			$data['bd']['Atuacao'] = $data['query']['Atuacao'];			
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_associado($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_associado', $data, TRUE);
        }

        $this->load->view('relatorio/tela_associado', $data);

        $this->load->view('basico/footer');

    }

	public function empresaassociado() {

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
            'C.NomeEmpresa' => 'idSis_Empresa',
            'C.Email' => 'E-mail',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresaassociado();

        $data['titulo'] = 'Relatório de Indicações';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_empresaassociado($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_empresaassociado', $data, TRUE);
        }

        $this->load->view('relatorio/tela_empresaassociado', $data);

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
            'E.MunicipioEmpresa' => 'Cidade',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresas();
		$data['select']['CategoriaEmpresa'] = $this->Relatorio_model->select_categoriaempresa();
		$data['select']['Atuacao'] = $this->Relatorio_model->select_atuacao();

        $data['titulo'] = 'Empresas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['CategoriaEmpresa'] = $data['query']['CategoriaEmpresa'];
			$data['bd']['Atuacao'] = $data['query']['Atuacao'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_empresas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_empresas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_empresas', $data);

        $this->load->view('basico/footer');

    }
	
	public function empresas1() {

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
            'E.idSis_Empresa' => 'nº idSis_Empresa',
			'E.NomeEmpresa' => 'Nome do Fornecedor',
			'E.Atividade' => 'Atividade',
            #'E.DataNascimento' => 'Data de Nascimento',
            #'E.Sexo' => 'Sexo',
            'E.BairroEmpresa' => 'Bairro',
            'E.MunicipioEmpresa' => 'Cidade',
            'E.Email' => 'E-mail',
			'CE.NomeContato' => 'Contato da idSis_Empresa',
			'TCE.RelaCom' => 'Relação',
			'CE.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresas();

        $data['titulo'] = 'Relatório de Fornecedores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_empresas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_empresas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_empresas', $data);

        $this->load->view('basico/footer');

    }

	public function fornecedor() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeFornecedor',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.idApp_Fornecedor' => 'nº Fornecedor',
			'E.NomeFornecedor' => 'Nome do Fornecedor',
			'E.Atividade' => 'Atividade',
            #'E.DataNascimento' => 'Data de Nascimento',
            #'E.Sexo' => 'Sexo',
            'E.BairroFornecedor' => 'Bairro',
            'E.MunicipioFornecedor' => 'Município',
            'E.Email' => 'E-mail',
			'CE.NomeContatofornec' => 'Contatofornec da Fornecedor',
			'TCE.RelaCom' => 'Relação',
			'CE.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();

        $data['titulo'] = 'Relatório de Fornecedores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_fornecedor($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_fornecedor', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_fornecedor', $data);

        $this->load->view('basico/footer');

    }

	public function produtos() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idTab_Promocao',
            'idTab_Catprod',
            'idTab_Produto',
            'idTab_Produtos',
			'TipoProduto',
			'Ordenamento',
            'Campo',
			'Agrupar',
			'Tipo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['Campo'] = array(
			'TCP.Catprod' => 'Categoria',
			'TP.Produtos' => 'Produto Base',
			'TPS.Nome_Prod' => 'Produtos',
			'TV.idTab_Valor' => 'id_Preço',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );
		
        $data['select']['Tipo'] = array(
			'0' => '::Todos::',
			'1' => 'Preço',
			'2' => 'Promoção',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Todos::',
			'1' => 'Produtos',
			'2' => 'Produtos C/Preço',
			'3' => 'Produtos C/Promocao',
			'4' => 'Promoções',
        );		
		
		$data['select']['idTab_Catprod'] = $this->Relatorio_model->select_catprod();
		$data['select']['idTab_Produto'] = $this->Relatorio_model->select_produto();
		$data['select']['idTab_Produtos'] = $this->Relatorio_model->select_produtos();

        $data['titulo'] = 'Produtos';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
			$data['bd']['idTab_Produto'] = $data['query']['idTab_Produto'];
			$data['bd']['idTab_Produtos'] = $data['query']['idTab_Produtos'];
			$data['bd']['Tipo'] = $data['query']['Tipo'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_produtos($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_produtos', $data, TRUE);

        }

        $this->load->view('relatorio/tela_produtos', $data);

        $this->load->view('basico/footer');

    }

	public function promocao() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Produtos',
			'Promocao',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TPM.Promocao' => 'Promocao',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Produtos'] = $this->Relatorio_model->select_produtos1();
		$data['select']['Promocao'] = $this->Relatorio_model->select_promocao();
		$data['select']['TipoProduto'] = $this->Relatorio_model->select_tipoproduto();

        $data['titulo'] = 'Promoçoes';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Promocao'] = $data['query']['Promocao'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_promocao($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_promocao', $data, TRUE);

        }

        $this->load->view('relatorio/tela_promocao', $data);

        $this->load->view('basico/footer');

    }

	public function tarefa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'DataInicio',
            'DataFim',
            #'NomeProfissional',
			#'Profissional',
			'Ordenamento',
            'Campo',
            'ConcluidoTarefa',
            'Prioridade',
			'idTab_Categoria',
			#'Rotina',
			'ConcluidoSubTarefa',
			'Tarefa',
			'SubTarefa',
			'SubPrioridade',
			'Statustarefa',
			'Statussubtarefa',
			'Agrupar',
        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
		
		$_SESSION['FiltroAlteraTarefa']['idTab_Categoria'] = $data['query']['idTab_Categoria'];
		$_SESSION['FiltroAlteraTarefa']['ConcluidoTarefa'] = $data['query']['ConcluidoTarefa'];
		$_SESSION['FiltroAlteraTarefa']['Prioridade'] = $data['query']['Prioridade'];
		$_SESSION['FiltroAlteraTarefa']['ConcluidoSubTarefa'] = $data['query']['ConcluidoSubTarefa'];
		$_SESSION['FiltroAlteraTarefa']['SubPrioridade'] = $data['query']['SubPrioridade'];
		$_SESSION['FiltroAlteraTarefa']['Statustarefa'] = $data['query']['Statustarefa'];
		$_SESSION['FiltroAlteraTarefa']['Statussubtarefa'] = $data['query']['Statussubtarefa'];
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['ConcluidoTarefa'] = array(
            '0' => '::Todos::',
			'S' => 'Sim',
			'N' => 'Não',
        );

        $data['select']['Prioridade'] = array(
            '0' => '::Todos::',
			'1' => 'Alta',
            '2' => 'Media',
            '3' => 'Baixa',
        );
		
        $data['select']['SubPrioridade'] = array(
            '0' => '::Todos::',
			'1' => 'Alta',
            '2' => 'Media',
            '3' => 'Baixa',
        );
        $data['select']['Statustarefa'] = array(
            '0' => '::Todos::',
			'1' => 'Fazer',
            '2' => 'Fazendo',
            '3' => 'Feito',
        );
        $data['select']['Statussubtarefa'] = array(
            '0' => '::Todos::',
			'1' => 'Fazer',
            '2' => 'Fazendo',
            '3' => 'Feito',
        );		
/*
		$data['select']['Rotina'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
*/
		$data['select']['ConcluidoSubTarefa'] = array(
            '0' => '::Todos::',
			'S' => 'Sim',
			'N' => 'Não',
			'M' => 'Com SubTarefa',
        );
		
        $data['select']['Agrupar'] = array(
			'0' => '::Nenhum::',			
			'idApp_Tarefa' => 'Tarefa',
        );

        $data['select']['Campo'] = array(
			'P.DataTarefa' => 'Data do Inicio',
			'P.DataTarefaLimite' => 'Data da Concl.',	
			'P.Compartilhar' => 'Quem Fazer',
			'P.idSis_Usuario' => 'Quem Cadastrou',		
			'P.ConcluidoTarefa' => 'Concluido',
			'P.idTab_Categoria' => 'Categoria',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

		$data['select']['idTab_Categoria'] = $this->Relatorio_model->select_categoria();
        #$data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional3();
		#$data['select']['Profissional'] = $this->Relatorio_model->select_profissional2();
		//$data['select']['Tarefa'] = $this->Relatorio_model->select_tarefa();
		//$data['select']['SubTarefa'] = $this->Relatorio_model->select_procedtarefa();

        $data['titulo'] = 'Tarefas';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            #$data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
			#$data['bd']['Profissional'] = $data['query']['Profissional'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['ConcluidoTarefa'] = $data['query']['ConcluidoTarefa'];
            $data['bd']['Prioridade'] = $data['query']['Prioridade'];
			$data['bd']['idTab_Categoria'] = $data['query']['idTab_Categoria'];
			#$data['bd']['Rotina'] = $data['query']['Rotina'];
			$data['bd']['ConcluidoSubTarefa'] = $data['query']['ConcluidoSubTarefa'];
			$data['bd']['Tarefa'] = $data['query']['Tarefa'];
			$data['bd']['SubTarefa'] = $data['query']['SubTarefa'];
			$data['bd']['SubPrioridade'] = $data['query']['SubPrioridade'];
			$data['bd']['Statustarefa'] = $data['query']['Statustarefa'];
			$data['bd']['Statussubtarefa'] = $data['query']['Statussubtarefa'];
			$data['bd']['Agrupar'] = $data['query']['Agrupar'];

            $data['report'] = $this->Relatorio_model->list_tarefa($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_tarefa', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_tarefa', $data);

        $this->load->view('basico/footer');

    }

	public function orcamentosv() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
            'DataInicio',
            'DataFim',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            #'QuitadoOrca',
			'ConcluidoOrca',
			'ConcluidoProcedimento',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
/*
        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
*/
		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
		$data['select']['ConcluidoProcedimento'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Número do Orçamento',
			'OT.DataOrca' => 'Data do Orçamento',
            'OT.DataPrazo' => 'Data Prazo',
			'OT.AprovadoOrca' => 'Orçamento Aprovado?',
			'OT.ValorOrca' => 'Valor do Orçamento',
            #'OT.QuitadoOrca' => 'Orçamento Quitado?',
			'OT.ConcluidoOrca' => 'Serviço Concluído?',
            'OT.DataConclusao' => 'Data de Conclusão',
            #'OT.DataRetorno' => 'Renovação',
			#'PD.QtdProduto' => 'Qtd. do Produto',
			#'PD.idTab_Produto' => 'Produto',
			'SV.idTab_Servico' => 'Servico',
			'PC.DataProcedimento' => 'Data do Procedimento',
			'PC.Profissional' => 'Profissional',
			'PC.Procedimento' => 'Procedimento',
			'PC.ConcluidoProcedimento' => 'Proc. Concl.?',
			'PC.DataProcedimentoLimite' => 'Data Limite',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();

        $data['titulo'] = 'Relatório de Orçamentos X Procedimentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            #$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];

			#$data['bd']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');


            $data['report'] = $this->Relatorio_model->list_orcamentosv($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_orcamentosv', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_orcamentosv', $data);

        $this->load->view('basico/footer');



    }

	public function depoimento() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Depoimento',
			'Arquivo_Depoimento',
			'Texto_Depoimento',
			'Ativo_Depoimento',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['titulo'] = 'Depoimento';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['idApp_Depoimento'] = $data['query']['idApp_Depoimento'];
			$data['bd']['Arquivo_Depoimento'] = $data['query']['Arquivo_Depoimento'];
			$data['bd']['Texto_Depoimento'] = $data['query']['Texto_Depoimento'];
			$data['bd']['Ativo_Depoimento'] = $data['query']['Ativo_Depoimento'];

            $data['report'] = $this->Relatorio_model->list_depoimento($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_depoimento', $data, TRUE);

        }

        $this->load->view('relatorio/tela_depoimento', $data);

        $this->load->view('basico/footer');

    }

	public function atuacao() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Atuacao',
			'Arquivo_Atuacao',
			'Texto_Atuacao',
			'Ativo_Atuacao',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['titulo'] = 'Atuacao';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['idApp_Atuacao'] = $data['query']['idApp_Atuacao'];
			$data['bd']['Arquivo_Atuacao'] = $data['query']['Arquivo_Atuacao'];
			$data['bd']['Texto_Atuacao'] = $data['query']['Texto_Atuacao'];
			$data['bd']['Ativo_Atuacao'] = $data['query']['Ativo_Atuacao'];

            $data['report'] = $this->Relatorio_model->list_atuacao($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_atuacao', $data, TRUE);

        }

        $this->load->view('relatorio/tela_atuacao', $data);

        $this->load->view('basico/footer');

    }

	public function colaborador() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Colaborador',
			'Arquivo_Colaborador',
			'Texto_Colaborador',
			'Ativo_Colaborador',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['titulo'] = 'Colaborador';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['idApp_Colaborador'] = $data['query']['idApp_Colaborador'];
			$data['bd']['Arquivo_Colaborador'] = $data['query']['Arquivo_Colaborador'];
			$data['bd']['Texto_Colaborador'] = $data['query']['Texto_Colaborador'];
			$data['bd']['Ativo_Colaborador'] = $data['query']['Ativo_Colaborador'];

            $data['report'] = $this->Relatorio_model->list_colaborador($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_colaborador', $data, TRUE);

        }

        $this->load->view('relatorio/tela_colaborador', $data);

        $this->load->view('basico/footer');

    }

	public function slides() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Slides',
			'Slide1',
			'Texto_Slide1',
			'Ativo',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['titulo'] = 'Slides';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['idApp_Slides'] = $data['query']['idApp_Slides'];
			$data['bd']['Slide1'] = $data['query']['Slide1'];
			$data['bd']['Texto_Slide1'] = $data['query']['Texto_Slide1'];
			$data['bd']['Ativo'] = $data['query']['Ativo'];

            $data['report'] = $this->Relatorio_model->list_slides($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_slides', $data, TRUE);

        }

        $this->load->view('relatorio/tela_slides', $data);

        $this->load->view('basico/footer');

    }
	
    public function site() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$_SESSION['Documentos'] = $data['documentos'] = $this->Empresa_model->get_pagina($_SESSION['log']['idSis_Empresa'], TRUE);
		$_SESSION['Produtos'] = $data['produtos'] = $this->Empresa_model->get_produtos($_SESSION['log']['idSis_Empresa'], TRUE);
		$_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);

		$data['titulo'] = 'Prontuário ' ;
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

		$data['prod'] = $this->Relatorio_model->list1_produtos(TRUE);
		$data['slides'] = $this->Relatorio_model->list2_slides(TRUE);
		$data['doc'] = $this->Relatorio_model->list3_documentos(TRUE);
		$data['colab'] = $this->Relatorio_model->list5_colaboradores(TRUE);
		$data['depoim'] = $this->Relatorio_model->list6_depoimentos(TRUE);
		$data['atuacao'] = $this->Relatorio_model->list7_atuacao(TRUE);
		
		$data['list1'] = $this->load->view('relatorio/list1_produtos', $data, TRUE);
		$data['list2'] = $this->load->view('relatorio/list2_slides', $data, TRUE);		
		$data['list3'] = $this->load->view('relatorio/list3_logo_nav', $data, TRUE);
		$data['list4'] = $this->load->view('relatorio/list4_icone', $data, TRUE);
		$data['list5'] = $this->load->view('relatorio/list5_colaboradores', $data, TRUE);
		$data['list6'] = $this->load->view('relatorio/list6_depoimentos', $data, TRUE);
		$data['list7'] = $this->load->view('relatorio/list7_atuacao', $data, TRUE);
		
        $_SESSION['log']['idSis_Empresa'] = $data['resumo']['idSis_Empresa'] = $data['documentos']['idSis_Empresa'] = $data['query']['idSis_Empresa'];

		$data['query']['Empresa'] = $this->Basico_model->get_empresa($data['query']['NomeEmpresa']);
		$data['query']['CategoriaEmpresa'] = $this->Basico_model->get_categoriaempresa($data['query']['CategoriaEmpresa']);

        /*
          echo "<pre>";
          print_r($data['contatoempresa']);
          echo "</pre>";
          exit();
          */

        $this->load->view('relatorio/tela_site', $data);

        $this->load->view('basico/footer');
    }
	
    public function loginempresa() {
		
		if ($_SESSION['Empresa']['idSis_Empresa'] == 5) {
				
			$data['msg'] = '?m=3';
			redirect(base_url() . 'login/sair' . $data['msg']);
			exit();
			
		}else{
				
			$_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
			$_SESSION['log']['idTab_Modulo'] = 1;

			#change error delimiter view
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

			#Get GET or POST data
			$celular = $this->input->get_post('CelularAdmin');
			$empresa = $this->input->get_post('idSis_Empresa');
			$senha = md5($this->input->get_post('Senha'));

			#set validation rules

			$this->form_validation->set_rules('CelularAdmin', 'Celular do Admin', 'required|trim');
			$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
			$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5');
			
			$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa31();
			
			if ($this->input->get('m') == 1)
				$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
				$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 3)
				$data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o loginempresa novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 4)
				$data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o loginempresa para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 5)
				$data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
				$data['msg'] = '';

			#run form validation
			if ($this->form_validation->run() === FALSE) {
				#load loginempresa view
				$this->load->view('relatorio/form_loginempresa', $data);
			} else {

				session_regenerate_id(true);

				$_SESSION['AdminUsuario'] = $query = $this->Loginempresa_model->check_dados_admin($empresa, $celular, $senha, TRUE);

				if ($query === FALSE) {
					
					unset($_SESSION['AdminUsuario']);
					
					$data['msg'] = $this->basico->msg('<strong>Celular ou Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);

					$this->load->view('relatorio/form_loginempresa', $data);

				} else {
					#initialize session
					$this->load->driver('session');

					$_SESSION['AdminEmpresa']  = $query2 = $this->Empresa_model->get_empresa($empresa, TRUE);
					
					if ($query2 === FALSE) {
						
						unset($_SESSION['AdminUsuario'], $_SESSION['AdminEmpresa']);
						
						$data['msg'] = $this->basico->msg('<strong>Celular ou Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);

						$this->load->view('relatorio/form_loginempresa', $data);

					} else {
						
						unset($_SESSION['log']);
						
						$_SESSION['log']['Nome'] = $query['Nome'];
						$_SESSION['log']['Nome2'] = (strlen($query['Nome']) > 6) ? substr($query['Nome'], 0, 6) : $query['Nome'];
						$_SESSION['log']['CpfAdmin'] = $query['CpfUsuario'];
						$_SESSION['log']['CelularAdmin'] = $query['CelularUsuario'];
						$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
						$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 15) ? substr($query['NomeEmpresa'], 0, 15) : $query['NomeEmpresa'];
						$_SESSION['log']['idSis_Usuario'] = $query['idSis_Usuario'];
						$_SESSION['log']['idTab_Modulo'] = $query['idTab_Modulo'];
						$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
						$_SESSION['log']['UsuarioEmpresa'] = $query2['UsuarioEmpresa'];
						$_SESSION['log']['PermissaoEmpresa'] = $query2['PermissaoEmp'];
						$_SESSION['log']['NivelEmpresa'] = $query2['NivelEmpresa'];
						$_SESSION['log']['DataCriacao'] = $query2['DataCriacao'];
						$_SESSION['log']['DataDeValidade'] = $query2['DataDeValidade'];
						$_SESSION['log']['Site'] = $query2['Site'];

						$this->load->database();
						$_SESSION['db']['hostname'] = $this->db->hostname;
						$_SESSION['db']['username'] = $this->db->username;
						$_SESSION['db']['password'] = $this->db->password;
						$_SESSION['db']['database'] = $this->db->database;

						if ($this->Loginempresa_model->set_acesso($_SESSION['log']['idSis_Empresa'], 'LOGIN') === FALSE) {
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

							$this->basico->erro($msg);
							$this->load->view('relatorio/form_loginempresa');
						} else {
							
							unset($_SESSION['Empresa']);
							unset($_SESSION['Usuario']);
							redirect('acessoempresa');
						}
					}	
				}
			}
		}
        $this->load->view('basico/footer');
    }
	
	function valid_celular($celular) {

        if ($this->Loginempresa_model->check_celular($celular) == 1) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> não existe.');
            return FALSE;
        } else if ($this->Loginempresa_model->check_celular($celular) == 2) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> inativo! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	function valid_empresa($empresa, $celular) {

        if ($this->Loginempresa_model->check_dados_empresa($empresa, $celular) == FALSE) {
            $this->form_validation->set_message('valid_empresa', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function valid_senha($senha, $celular) {

        if ($this->Loginempresa_model->check_dados_celular($senha, $celular) == FALSE) {
            $this->form_validation->set_message('valid_senha', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
}