<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Despesa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'TipoDespesa_model', 'Profissional_model', 'Despesa_model', 'FormaPag_model', 'Empresa_model', 'ContatoCliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('cliente/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('cliente/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['despesa'] = quotes_to_entities($this->input->post(array(
            
		#### App_Despesa ####
			'idApp_Despesa',
            'Despesa',
			'DataDesp',
			'DataVencDesp',			
			#'StatusOrca',
			'ObsDesp',
			#'idApp_Profissional',
			'FormaPag',
			'Empresa',
			'TipoDespesa',
			#'idTab_TipoConcluido',
			'ValorDesp',
			'ValorTotalDesp',
			'QtdParcDesp'
			
			
			), TRUE));
		
		
		$data['parcelasdesp'] = quotes_to_entities($this->input->post(array(
		
		#### App_ParcDesp ####
			'idApp_Despesa',
			'idApp_ParcelasDesp',
			'ParcDesp',
			'ValorParcDesp',
			'DataVencParcDesp',
			'ValorPagoDesp',
			'DataPagoDesp',
			'QuitDesp',
			
			), TRUE));	
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		#### App_Despesa ####
		$this->form_validation->set_rules('DataDesp', 'DataDesp', 'required|trim');
		
		$this->form_validation->set_rules('ParcDesp', 'ParcDesp', 'required|trim');
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		
		
        #$data['select']['StatusOrca'] = $this->Despesa_model->select_status_orca();			
		$data['select']['Empresa'] = $this->Empresa_model->select_empresa();
		$data['select']['FormaPag'] = $this->FormaPag_model->select_formapag();
		$data['select']['TipoDespesa'] = $this->TipoDespesa_model->select_tipodespesa();
        #$data['select']['TipoConcluido'] = $this->Basico_model->select_tipo_concluido();
		#$data['select']['Profissional'] = $this->Profissional_model->select_profissional();
		
		
		$data['titulo'] = 'Cadastrar Despesas';
        $data['form_open_path'] = 'despesa/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['button'] = 
                '
                <button class="btn btn-sm btn-primary" name="pesquisar" value="0" type="submit">
                    <span class="glyphicon glyphicon-plus"></span> Cadastrar
                </button>
        ';        

		if ($data['despesa']['FormaPag']) 
            $data['collapse'] = '';
        else 
            $data['collapse'] = 'class="collapse"';
		
        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['q'] = $this->Despesa_model->lista_despesa(TRUE);
        $data['list'] = $this->load->view('despesa/list_despesa', $data, TRUE);
	
		$data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('despesa/pesq_despesa', $data);
        } else {

				////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////

			#### App_Despesa ####
			$data['despesa']['Despesa'] = $data['despesa']['Despesa'];
			$data['despesa']['DataVencDesp'] = $this->basico->mascara_data($data['despesa']['DataVencDesp'], 'mysql');
			
			$data['despesa']['DataDesp'] = $this->basico->mascara_data($data['despesa']['DataDesp'], 'mysql');
			#$data['despesa']['StatusOrca'] = $data['despesa']['StatusOrca'];
			$data['despesa']['ObsDesp'] = nl2br($data['despesa']['ObsDesp']);
			#$data['despesa']['idApp_Profissional'] = $data['despesa']['idApp_Profissional'];
			$data['despesa']['Empresa'] = $data['despesa']['Empresa'];
			$data['despesa']['TipoDespesa'] = $data['despesa']['TipoDespesa'];
			$data['despesa']['FormaPag'] = $data['despesa']['FormaPag'];
			#$data['despesa']['idTab_TipoConcluido'] = $data['despesa']['idTab_TipoConcluido'];
			$data['despesa']['ValorDesp'] = str_replace(',','.',str_replace('.','',$data['despesa']['ValorDesp']));
			$data['despesa']['ValorTotalDesp'] = str_replace(',','.',str_replace('.','',$data['despesa']['ValorTotalDesp']));
			$data['despesa']['QtdParcDesp'] = $data['despesa']['QtdParcDesp'];
			
			#### App_ParcelasDesp ####
			#$data['parcelasdesp']['ParcDesp'] = str_replace(',','.',str_replace('.','',$data['parcelasdesp']['ParcDesp']));
			$data['parcelasdesp']['ParcDesp'] = $data['parcelasdesp']['ParcDesp'];
			$data['parcelasdesp']['ValorParcDesp'] = str_replace(',','.',str_replace('.','',$data['parcelasdesp']['ValorParcDesp']));
			$data['parcelasdesp']['ValorPagoDesp'] = str_replace(',','.',str_replace('.','',$data['parcelasdesp']['ValorPagoDesp']));
			$data['parcelasdesp']['DataVencParcDesp'] = $this->basico->mascara_data($data['parcelasdesp']['DataVencParcDesp'], 'mysql');
			$data['parcelasdesp']['DataPagoDesp'] = $this->basico->mascara_data($data['parcelasdesp']['DataPagoDesp'], 'mysql');
			$data['parcelasdesp']['QuitDesp'] = $data['parcelasdesp']['QuitDesp'];

			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			#### Geral ####
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
			$data['anterior'] = array();
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////			
			#### App_Despesa ####
			$data['despesa']['idSis_Usuario'] = $_SESSION['log']['id'];
			$data['despesa']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			#$data['despesa']['idApp_Cliente'] = $data['despesa']['idApp_Cliente'];					
			$data['idApp_Despesa'] = $this->Despesa_model->set_despesa($data['despesa']);			
					
			#### App_ParcDesp ####
			$data['parcelasdesp']['idSis_Usuario'] = $_SESSION['log']['id'];
			$data['parcelasdesp']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];			
			$data['parcelasdesp']['idApp_Despesa'] = $data['idApp_Despesa'];							
			$data['idApp_ParcelasDesp'] = $this->Despesa_model->set_parcelasdesp($data['parcelasdesp']);			
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
			/*
			BLOCO DE DEBUG (PRA VISUALIZAR O CONTEÚDO DE VARIÁVEIS MULTIDIMENSIONAIS)
			echo '<br>';
			echo "<pre>";
			print_r($data['y']);
			echo "</pre>";
			exit ();
			*/
				

            if ($data['idApp_Despesa'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('despesa/form_despesa', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Despesa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Despesa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'despesa/cadastrar' . $data['msg']);
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
        $data['despesa'] = quotes_to_entities($this->input->post(array(
            
		#### App_Despesa ####
			'idApp_Despesa',
            'Despesa',
			'DataDesp',
			'DataVencDesp',
			
			#'StatusOrca',
			'ObsDesp',
			#'idApp_Profissional',
			'FormaPag',
			'Empresa',
			'TipoDespesa',
			#'idTab_TipoConcluido',
			'ValorDesp',
			'ValorTotalDesp',
			'QtdParcDesp',
			
			
			), TRUE));
	
		$data['parcelasdesp'] = quotes_to_entities($this->input->post(array(
		
		#### App_ParcDesp ####
			'idApp_Despesa',
			'idApp_ParcelasDesp',
			'ParcDesp',
			'ValorParcDesp',
			'DataVencParcDesp',
			'ValorPagoDesp',
			'DataPagoDesp',
			'QuitDesp',
			
			), TRUE));
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusOrca']='V';       
        if ($id) {
            $data['despesa'] = $this->Despesa_model->get_despesa($id);
			$data['parcelasdesp'] = $this->Despesa_model->get_parcelasdesp($id);
			#$data['procedimento'] = $this->Despesa_model->get_procedimento($id);				
            $_SESSION['log']['idApp_Despesa'] = $id;
			
/////////////////////////////////////////     Preparar dados Para Leitura do get 'Visualização' Ex. Datas "barras"  //////////////////////////////////////////////////////////////////////////////
			#### App_Despesa ####
			$data['despesa']['DataDesp'] = $this->basico->mascara_data($data['despesa']['DataDesp'], 'barras');
			$data['despesa']['DataVencDesp'] = $this->basico->mascara_data($data['despesa']['DataVencDesp'], 'barras');
						
			$data['despesa']['ObsDesp'] = nl2br($data['despesa']['ObsDesp']);
			$data['despesa']['ValorDesp'] = str_replace(',','.',str_replace('.','',$data['despesa']['ValorDesp']));
			$data['despesa']['ValorTotalDesp'] = str_replace(',','.',str_replace('.','',$data['despesa']['ValorTotalDesp']));
			$data['despesa']['QtdParcDesp'] = $data['despesa']['QtdParcDesp'];
			
			
			### App_ParcelasDesp #####
			$data['parcelasdesp']['ValorParcDesp'] = str_replace(',','.',str_replace('.','',$data['parcelasdesp']['ValorParcDesp']));
			$data['parcelasdesp']['ValorPagoDesp'] = str_replace(',','.',str_replace('.','',$data['parcelasdesp']['ValorPagoDesp']));
			$data['parcelasdesp']['DataVencParcDesp'] = $this->basico->mascara_data($data['parcelasdesp']['DataVencParcDesp'], 'barras');
			$data['parcelasdesp']['DataPagoDesp'] = $this->basico->mascara_data($data['parcelasdesp']['DataPagoDesp'], 'barras');
			$data['parcelasdesp']['QuitDesp'] = $data['parcelasdesp']['QuitDesp'];
        }
			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		$data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		#### App_Despesa ####
		$this->form_validation->set_rules('DataDesp', 'DataDesp', 'required|trim');
		#$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
		$this->form_validation->set_rules('ParcDesp', 'ParcDesp', 'required|trim');
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		
		#$data['select']['TipoConcluido'] = $this->Basico_model->select_tipo_concluido();
		#$data['select']['Profissional'] = $this->Profissional_model->select_profissional();		
        #$data['select']['StatusOrca'] = $this->Despesa_model->select_status_orca();			
        $data['select']['Empresa'] = $this->Empresa_model->select_empresa(); 
		$data['select']['FormaPag'] = $this->FormaPag_model->select_formapag();
		$data['select']['TipoDespesa'] = $this->TipoDespesa_model->select_tipodespesa();
		
		
		$data['titulo'] = 'Editar Despesa';
        $data['form_open_path'] = 'despesa/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['button'] = 
                '
                <button class="btn btn-sm btn-warning" name="pesquisar" value="0" type="submit">
                    <span class="glyphicon glyphicon-edit"></span> Salvar Alteração
                </button>
        ';

		if ($data['despesa']['FormaPag'])  
            $data['collapse'] = '';
        else 
            $data['collapse'] = 'class="collapse"';
		
        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['q'] = $this->Despesa_model->lista_despesa(TRUE);
        $data['list'] = $this->load->view('despesa/list_despesa', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('despesa/pesq_despesa', $data);
        } else {

	///////////////////////////////// Preparar dados para inserção novamente set Ex. Datas "mysql" ///////////////////////////////////////////////////////////////
			
			#### App_Despesa ####
			$data['despesa']['DataDesp'] = $this->basico->mascara_data($data['despesa']['DataDesp'], 'mysql');
			
			$data['despesa']['DataVencDesp'] = $this->basico->mascara_data($data['despesa']['DataVencDesp'], 'mysql');
			$data['despesa']['ObsDesp'] = nl2br($data['despesa']['ObsDesp']);
			$data['despesa']['ValorDesp'] = str_replace(',','.',str_replace('.','',$data['despesa']['ValorDesp']));
			$data['despesa']['ValorTotalDesp'] = str_replace(',','.',str_replace('.','',$data['despesa']['ValorTotalDesp']));
			$data['despesa']['QtdParcDesp'] = $data['despesa']['QtdParcDesp'];
			
			### App_ParcelasDesp #####
			
			$data['parcelasdesp']['ValorPagoDesp'] = str_replace(',','.',str_replace('.','',$data['parcelasdesp']['ValorPagoDesp']));
			$data['parcelasdesp']['DataVencParcDesp'] = $this->basico->mascara_data($data['parcelasdesp']['DataVencParcDesp'], 'mysql');
			$data['parcelasdesp']['DataPagoDesp'] = $this->basico->mascara_data($data['parcelasdesp']['DataPagoDesp'], 'mysql');
			
			
////////////////////////////////////////////////////  FIM   //////////////////////////////////////////////////////////////////////////////////		
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
			$data['anterior1'] = $this->Despesa_model->get_despesa($data['despesa']['idApp_Despesa']);
			#$data['anterior2'] = $this->Despesa_model->get_procedimento($data['despesa']['idApp_Despesa']);
			$data['anterior3'] = $this->Despesa_model->get_parcelasdesp($data['despesa']['idApp_Despesa']);            
			$data['campos1'] = array_keys($data['despesa']);
			#$data['campos2'] = array_keys($data['procedimento']);
			$data['campos3'] = array_keys($data['parcelasdesp']);
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****						
            $data['auditoriaitem1'] = $this->basico->set_log($data['anterior1'], $data['despesa'], $data['campos1'], $data['despesa']['idApp_Despesa'], TRUE);
			#$data['auditoriaitem2'] = $this->basico->set_log($data['anterior2'], $data['procedimento'], $data['campos2'], $data['procedimento']['idApp_Procedimento'], TRUE);
			$data['auditoriaitem3'] = $this->basico->set_log($data['anterior3'], $data['parcelasdesp'], $data['campos3'], $data['parcelasdesp']['idApp_ParcelasDesp'], TRUE);
/*
			echo '<br>';
			echo "<pre>";
			print_r($data);
			echo "</pre>";
			exit ();	
*/
			if (
				$data['auditoriaitem1'] && $this->Despesa_model->update_despesa($data['despesa'], $data['despesa']['idApp_Despesa']) === FALSE 
				//$data['auditoriaitem2'] && $this->Despesa_model->update_procedimento($data['procedimento'], $data['procedimento']['idApp_Procedimento']) === FALSE &&
				//$data['auditoriaitem3'] && $this->Despesa_model->update_parcelasdesp($data['parcelasdesp'], $data['parcelasdesp']['idApp_ParcelasDesp']) === FALSE
				) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'despesa/form_despesa/' . $data['despesa']['idApp_Despesa'] . $data['msg']);
                exit();
            } else {
			
                if ($data['auditoriaitem1'] === FALSE || $data['auditoriaitem2'] === FALSE) {
                    $data['msg'] = '';
                } else {
					
                    //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Despesa', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
				
				#$this->Despesa_model->update_procedimento($data['procedimento'], $data['procedimento']['idApp_Procedimento']);
				$this->Despesa_model->update_parcelasdesp($data['parcelasdesp'], $data['parcelasdesp']['idApp_ParcelasDesp']);

                redirect(base_url() . 'despesa/cadastrar/' . $data['msg']);
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

        $data['query'] = $this->input->post(array(
            'idApp_Despesa',
            'Despesa',
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Despesa_model->get_despesa($id);
		
			$data['query']['DataVenc'] = $this->basico->mascara_data($data['query']['DataVenc'], 'barras');
            
			$data['query']['DataDespesa'] = $this->basico->mascara_data($data['query']['DataDespesa'], 'barras');

		}
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Despesa', 'Nome do Despesa', 'required|trim');

        $data['titulo'] = 'Editar Despesa';
        $data['form_open_path'] = 'despesa/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['button'] = 
                '
                <button class="btn btn-sm btn-warning" name="pesquisar" value="0" type="submit">
                    <span class="glyphicon glyphicon-edit"></span> Salvar Alteração
                </button>
        ';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['q'] = $this->Despesa_model->lista_despesa(TRUE);
        $data['list'] = $this->load->view('despesa/list_despesa', $data, TRUE);

		if ($data['query']['ValorTotal']) # || $data['query']['FormaPag'] || $data['query']['DataVenc']) 
            $data['collapse'] = '';
        else 
            $data['collapse'] = 'class="collapse"';
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('despesa/pesq_despesa', $data);
        } else {

            $data['query']['Despesa'] = trim(mb_strtoupper($data['query']['Despesa'], 'ISO-8859-1'));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];

            $data['anterior'] = $this->Despesa_model->get_despesa($data['query']['idApp_Despesa']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Despesa'], TRUE);

            if ($data['auditoriaitem'] && $this->Despesa_model->update_despesa($data['query'], $data['query']['idApp_Despesa']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'despesa/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Despesa', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'despesa/cadastrar/despesa/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
    
    
}
