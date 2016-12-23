<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class OrcaTrata extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Orcatrata_model', 'Profissional_model', 'Formapag_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('orcatrata/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('orcatrata/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(

		#### App_OrcaTrata ####
			'idApp_OrcaTrata',
            'idApp_Cliente',
			'DataOrca',
			'DataConcl',
			'DataRet',
			'StatusOrca',
			'ObsOrca',
			'idApp_Profissional',
			'FormaPag',
			'QtdParcOrca',
			'DataVencOrca',
			'idTab_TipoConcluido',
			'ValorOrca',
			'ValorEntOrca',
			'ValorResOrca',

			), TRUE));

		$data['procedimento'] = quotes_to_entities($this->input->post(array(

		#### App_Procedimento ####
			'idApp_OrcaTrata',
			'idApp_Procedimento',
			'DataProcedimento',
			'Proc',
			'Profissional',

			), TRUE));

		$data['parcelasrec'] = quotes_to_entities($this->input->post(array(

		#### App_ParcRec ####
			'idApp_OrcaTrata',
			'idApp_ParcelasRec',
			'ParcRec',
			'ValorParcRec',
			'ValorPagoRec',
			'DataVencRec',
			'DataPagoRec',
			'QuitRec',

			), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		#### App_OrcaTrata ####
		$this->form_validation->set_rules('DataOrca', 'DataOrca', 'required|trim');
		#$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
		#$this->form_validation->set_rules('ParcRec', 'ParcRec', 'required|trim');
		$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');


        $data['select']['StatusOrca'] = $this->Orcatrata_model->select_status_orca();
		$data['select']['FormaPag'] = $this->Formapag_model->select_formapag();
        $data['select']['TipoConcluido'] = $this->Basico_model->select_tipo_concluido();
		$data['select']['Profissional'] = $this->Profissional_model->select_profissional();

		$data['titulo'] = 'Cad. Or�amento/ Pl. Trat.';
        $data['form_open_path'] = 'orcatrata/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;


		if ($data['orcatrata']['FormaPag']) #|| $data['query']['FormaPag'] || $data['query']['DataVenc'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';


		$data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

		$data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

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
            $this->load->view('orcatrata/form_orcatrata', $data);
        } else {

		////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////

			#### App_OrcaTrata ####
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
			$data['orcatrata']['DataConcl'] = $this->basico->mascara_data($data['orcatrata']['DataConcl'], 'mysql');
			$data['orcatrata']['DataRet'] = $this->basico->mascara_data($data['orcatrata']['DataRet'], 'mysql');
			$data['orcatrata']['StatusOrca'] = $data['orcatrata']['StatusOrca'];
			$data['orcatrata']['ObsOrca'] = nl2br($data['orcatrata']['ObsOrca']);
			$data['orcatrata']['idApp_Profissional'] = $data['orcatrata']['idApp_Profissional'];
			$data['orcatrata']['FormaPag'] = $data['orcatrata']['FormaPag'];
			$data['orcatrata']['QtdParcOrca'] = $data['orcatrata']['QtdParcOrca'];
			$data['orcatrata']['DataVencOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencOrca'], 'mysql');
			$data['orcatrata']['idTab_TipoConcluido'] = $data['orcatrata']['idTab_TipoConcluido'];
			$data['orcatrata']['ValorEntOrca'] = str_replace(',','.',str_replace('.','',$data['orcatrata']['ValorEntOrca']));
			$data['orcatrata']['ValorResOrca'] = str_replace(',','.',str_replace('.','',$data['orcatrata']['ValorResOrca']));
			$data['orcatrata']['ValorOrca'] = str_replace(',','.',str_replace('.','',$data['orcatrata']['ValorOrca']));


			#### App_Procedimento ####
			$data['procedimento']['DataProcedimento'] = $this->basico->mascara_data($data['procedimento']['DataProcedimento'], 'mysql');
			$data['procedimento']['Proc'] = nl2br($data['procedimento']['Proc']);
			$data['procedimento']['Profissional'] = $data['procedimento']['Profissional'];

			#### App_ParcelasRec ####
			$data['parcelasrec']['ParcRec'] = $data['parcelasrec']['ParcRec'];
			$data['parcelasrec']['ValorParcRec'] = str_replace(',','.',str_replace('.','',$data['parcelasrec']['ValorParcRec']));
			$data['parcelasrec']['ValorPagoRec'] = str_replace(',','.',str_replace('.','',$data['parcelasrec']['ValorPagoRec']));
			$data['parcelasrec']['DataVencRec'] = $this->basico->mascara_data($data['parcelasrec']['DataVencRec'], 'mysql');
			$data['parcelasrec']['DataPagoRec'] = $this->basico->mascara_data($data['parcelasrec']['DataPagoRec'], 'mysql');
			$data['parcelasrec']['QuitRec'] = $data['parcelasrec']['QuitRec'];

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			#### Geral ####
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
			$data['anterior'] = array();
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
			#### App_OrcaTrata ####
			$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['id'];
			$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['orcatrata']['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
			$data['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['orcatrata']);
			#### App_Procedimento ####
			$data['procedimento']['idSis_Usuario'] = $_SESSION['log']['id'];
			$data['procedimento']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['procedimento']['idApp_OrcaTrata'] = $data['idApp_OrcaTrata'];
			$data['idApp_Procedimento'] = $this->Orcatrata_model->set_procedimento($data['procedimento']);
			#### App_ParcRec ####
			$data['parcelasrec']['idSis_Usuario'] = $_SESSION['log']['id'];
			$data['parcelasrec']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['parcelasrec']['idApp_OrcaTrata'] = $data['idApp_OrcaTrata'];
			$data['idApp_ParcelasRec'] = $this->Orcatrata_model->set_parcelasrec($data['parcelasrec']);
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			/*
			BLOCO DE DEBUG (PRA VISUALIZAR O CONTE�DO DE VARI�VEIS MULTIDIMENSIONAIS)
			echo '<br>';
			echo "<pre>";
			print_r($data['y']);
			echo "</pre>";
			exit ();
			*/


            if ($data['idApp_OrcaTrata'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_orcatrata', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'orcatrata/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(

		#### App_OrcaTrata ####
			'idApp_OrcaTrata',
            'idApp_Cliente',
			'DataOrca',
			'DataConcl',
			'DataRet',
			'StatusOrca',
			'ObsOrca',
			'idApp_Profissional',
			'FormaPag',
			'QtdParcOrca',
			'DataVencOrca',
			'idTab_TipoConcluido',
			'ValorOrca',
			'ValorEntOrca',
			'ValorResOrca',

			), TRUE));

		$data['procedimento'] = quotes_to_entities($this->input->post(array(

		#### App_Procedimento ####
			'idApp_OrcaTrata',
			'idApp_Procedimento',
			'DataProcedimento',
			'Proc',
			'Profissional',

			), TRUE));

		$data['parcelasrec'] = quotes_to_entities($this->input->post(array(

		#### App_ParcRec ####
			'idApp_OrcaTrata',
			'idApp_ParcelasRec',
			'ParcRec',
			'ValorParcRec',
			'ValorPagoRec',
			'DataVencRec',
			'DataPagoRec',
			'QuitRec',

			), TRUE));
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusOrca']='V';
        if ($id) {
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
			$data['parcelasrec'] = $this->Orcatrata_model->get_parcelasrec($id);
			$data['procedimento'] = $this->Orcatrata_model->get_procedimento($id);
            $_SESSION['log']['idApp_OrcaTrata'] = $id;

/////////////////////////////////////////     Preparar dados Para Leitura do get 'Visualiza��o' Ex. Datas "barras"  //////////////////////////////////////////////////////////////////////////////
			#### App_OrcaTrata ####
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
			$data['orcatrata']['DataConcl'] = $this->basico->mascara_data($data['orcatrata']['DataConcl'], 'barras');
			$data['orcatrata']['DataRet'] = $this->basico->mascara_data($data['orcatrata']['DataRet'], 'barras');
			$data['orcatrata']['ObsOrca'] = nl2br($data['orcatrata']['ObsOrca']);
			$data['orcatrata']['ValorEntOrca'] = str_replace(',','.',str_replace('.','',$data['orcatrata']['ValorEntOrca']));
			$data['orcatrata']['ValorResOrca'] = str_replace(',','.',str_replace('.','',$data['orcatrata']['ValorResOrca']));
			$data['orcatrata']['ValorOrca'] = str_replace(',','.',str_replace('.','',$data['orcatrata']['ValorOrca']));
			$data['orcatrata']['QtdParcOrca'] = $data['orcatrata']['QtdParcOrca'];
			$data['orcatrata']['DataVencOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencOrca'], 'barras');

			#### App_Procedimento ####
			$data['procedimento']['DataProcedimento'] = $this->basico->mascara_data($data['procedimento']['DataProcedimento'], 'barras');
			$data['procedimento']['Proc'] = nl2br($data['procedimento']['Proc']);

			### App_ParcelasRec #####
			$data['parcelasrec']['ValorParcRec'] = str_replace(',','.',str_replace('.','',$data['parcelasrec']['ValorParcRec']));
			$data['parcelasrec']['ValorPagoRec'] = str_replace(',','.',str_replace('.','',$data['parcelasrec']['ValorPagoRec']));
			$data['parcelasrec']['DataVencRec'] = $this->basico->mascara_data($data['parcelasrec']['DataVencRec'], 'barras');
			$data['parcelasrec']['DataPagoRec'] = $this->basico->mascara_data($data['parcelasrec']['DataPagoRec'], 'barras');
			$data['parcelasrec']['QuitRec'] = $data['parcelasrec']['QuitRec'];
        }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		#### App_OrcaTrata ####
		$this->form_validation->set_rules('DataOrca', 'DataOrca', 'required|trim');
		#$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
		#$this->form_validation->set_rules('ParcRec', 'ParcRec', 'required|trim');
		$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');

		$data['select']['TipoConcluido'] = $this->Basico_model->select_tipo_concluido();
		$data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        $data['select']['StatusOrca'] = $this->Orcatrata_model->select_status_orca();
        $data['select']['FormaPag'] = $this->Formapag_model->select_formapag();

        $data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'orcatrata/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		if ($data['orcatrata']['FormaPag'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

		$data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

		/*
			echo '<br>';
			echo "<pre>";
			print_r($data);
			echo "</pre>";

			echo '===========>>>>'.$data['orcatrata']['DataOrca'];
			exit ();
		*/
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_orcatrata', $data);
        } else {

	///////////////////////////////// Preparar dados para inser��o novamente set Ex. Datas "mysql" ///////////////////////////////////////////////////////////////

			#### App_OrcaTrata ####
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
			$data['orcatrata']['DataConcl'] = $this->basico->mascara_data($data['orcatrata']['DataConcl'], 'mysql');
			$data['orcatrata']['DataRet'] = $this->basico->mascara_data($data['orcatrata']['DataRet'], 'mysql');
			$data['orcatrata']['ObsOrca'] = nl2br($data['orcatrata']['ObsOrca']);
			$data['orcatrata']['ValorEntOrca'] = str_replace(',','.',str_replace('.','',$data['orcatrata']['ValorEntOrca']));
			$data['orcatrata']['ValorResOrca'] = str_replace(',','.',str_replace('.','',$data['orcatrata']['ValorResOrca']));
			$data['orcatrata']['ValorOrca'] = str_replace(',','.',str_replace('.','',$data['orcatrata']['ValorOrca']));
			$data['orcatrata']['QtdParcOrca'] = $data['orcatrata']['QtdParcOrca'];
			$data['orcatrata']['DataVencOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencOrca'], 'mysql');

			#### App_Procedimento ####
			$data['procedimento']['DataProcedimento'] = $this->basico->mascara_data($data['procedimento']['DataProcedimento'], 'mysql');
			$data['procedimento']['Proc'] = nl2br($data['procedimento']['Proc']);

			### App_ParcelasRec #####
			$data['parcelasrec']['ValorParcRec'] = str_replace(',','.',str_replace('.','',$data['parcelasrec']['ValorParcRec']));
			$data['parcelasrec']['ValorPagoRec'] = str_replace(',','.',str_replace('.','',$data['parcelasrec']['ValorPagoRec']));
			$data['parcelasrec']['DataVencRec'] = $this->basico->mascara_data($data['parcelasrec']['DataVencRec'], 'mysql');
			$data['parcelasrec']['DataPagoRec'] = $this->basico->mascara_data($data['parcelasrec']['DataPagoRec'], 'mysql');
			$data['parcelasrec']['QuitRec'] = $data['parcelasrec']['QuitRec'];
////////////////////////////////////////////////////  FIM   //////////////////////////////////////////////////////////////////////////////////
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
			$data['anterior1'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
			$data['anterior2'] = $this->Orcatrata_model->get_procedimento($data['orcatrata']['idApp_OrcaTrata']);
			$data['anterior3'] = $this->Orcatrata_model->get_parcelasrec($data['orcatrata']['idApp_OrcaTrata']);
			$data['campos1'] = array_keys($data['orcatrata']);
			$data['campos2'] = array_keys($data['procedimento']);
			$data['campos3'] = array_keys($data['parcelasrec']);
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['auditoriaitem1'] = $this->basico->set_log($data['anterior1'], $data['orcatrata'], $data['campos1'], $data['orcatrata']['idApp_OrcaTrata'], TRUE);
			$data['auditoriaitem2'] = $this->basico->set_log($data['anterior2'], $data['procedimento'], $data['campos2'], $data['procedimento']['idApp_Procedimento'], TRUE);
			$data['auditoriaitem3'] = $this->basico->set_log($data['anterior3'], $data['parcelasrec'], $data['campos3'], $data['parcelasrec']['idApp_ParcelasRec'], TRUE);
/*
			echo '<br>';
			echo "<pre>";
			print_r($data);
			echo "</pre>";
			exit ();
*/
			if (
				$data['auditoriaitem1'] && $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']) === FALSE
				//$data['auditoriaitem2'] && $this->Orcatrata_model->update_procedimento($data['procedimento'], $data['procedimento']['idApp_Procedimento']) === FALSE &&
				//$data['auditoriaitem3'] && $this->Orcatrata_model->update_parcelasrec($data['parcelasrec'], $data['parcelasrec']['idApp_ParcelasRec']) === FALSE
				) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'orcatrata/form_orcatrata/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem1'] === FALSE || $data['auditoriaitem2'] === FALSE || $data['auditoriaitem3'] === FALSE) {
                    $data['msg'] = '';
                } else {

                    //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

				$this->Orcatrata_model->update_procedimento($data['procedimento'], $data['procedimento']['idApp_Procedimento']);
				$this->Orcatrata_model->update_parcelasrec($data['parcelasrec'], $data['parcelasrec']['idApp_ParcelasRec']);
                redirect(base_url() . 'orcatrata/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_OrcaTrata',
            'submit'
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Orcatrata_model->get_orcatrata($id);
            $data['query']['DataConcl'] = $this->basico->mascara_data($data['query']['DataConcl'], 'barras');
			$data['query']['OrcaTrataDataConcl'] = $this->basico->mascara_data($data['query']['OrcaTrataDataConcl'], 'barras');
			$data['query']['DataRet'] = $this->basico->mascara_data($data['query']['DataRet'], 'barras');
			$data['query']['OrcaTrataDataRet'] = $this->basico->mascara_data($data['query']['OrcaTrataDataRet'], 'barras');
			$data['query']['DataVenc'] = $this->basico->mascara_data($data['query']['DataVenc'], 'barras');
            $data['query']['OrcaTrataDataVenc'] = $this->basico->mascara_data($data['query']['OrcaTrataDataVenc'], 'barras');
			$data['query']['DataOrca'] = $this->basico->mascara_data($data['query']['DataOrca'], 'barras');
            $data['query']['OrcaTrataDataOrca'] = $this->basico->mascara_data($data['query']['OrcaTrataDataOrca'], 'barras');

        }

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
       # $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        $data['titulo'] = 'Tem certeza que deseja excluir o registro abaixo?';
        $data['form_open_path'] = 'orcatrata/excluir';
        $data['readonly'] = 'readonly';
        $data['disabled'] = 'disabled';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;

		if ($data['orcatrata']['FormaPag'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['tela'] = $this->load->view('orcatrata/form_orcatrata', $data, TRUE);

		$data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';



        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/tela_orcatrata', $data);
        } else {

            if ($data['query']['idApp_OrcaTrata'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('orcatrata/form_orcatrata', $data);
            } else {

                $data['anterior'] = $this->Orcatrata_model->get_orcatrata($data['query']['idApp_OrcaTrata']);
                $data['campos'] = array_keys($data['anterior']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idApp_OrcaTrata'], FALSE, TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'DELETE', $data['auditoriaitem']);

                $this->Orcatrata_model->delete_orcatrata($data['query']['idApp_OrcaTrata']);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'orcatrata' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function pesquisar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'), 0, -3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'), 0, -3);
        }

        $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($id, TRUE);

        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        $data['query'] = $this->Orcatrata_model->lista_orcatrata(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('orcatrata/list_orcatrata', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('orcatrata/tela_orcatrata', $data);

        $this->load->view('basico/footer');
    }

}
