<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido2 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Orcatrata_model', 'Usuario_model', 'Cliente_model', 'Fornecedor_model', 'Relatorio_model', 'Formapag_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header_refresh_pedido2');
        $this->load->view('basico/nav_principal');

        #$this->load->view('orcatrata/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
            $data['msg'] = '';

		$this->load->view('orcatrata/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }
	
    public function pedido() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
        $data['titulo'] = 'Pedido';
        $data['form_open_path'] = 'pedido2/pedido';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		
		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		

		$data['q'] = $this->Orcatrata_model->list1_produtosvend(TRUE);
		$data['list1'] = $this->load->view('orcatrata/list1_produtosvend', $data, TRUE);

		$data['q5'] = $this->Orcatrata_model->list5_produtosvend(TRUE);
		$data['list5'] = $this->load->view('orcatrata/list5_produtosvend', $data, TRUE);
		
		$data['q2'] = $this->Orcatrata_model->list2_rankingfiado(TRUE);
		$data['list2'] = $this->load->view('orcatrata/list2_rankingfiado', $data, TRUE);

		$data['q3'] = $this->Orcatrata_model->list3_produtosaluguel(TRUE);
		$data['list3'] = $this->load->view('orcatrata/list3_produtosaluguel', $data, TRUE);
		
        $data['q6'] = $this->Orcatrata_model->list6_produtosaluguel(TRUE);
        $data['list6'] = $this->load->view('orcatrata/list6_produtosaluguel', $data, TRUE);		

		$data['q4'] = $this->Orcatrata_model->list4_receitasparc(TRUE);
		$data['list4'] = $this->load->view('orcatrata/list4_receitasparc', $data, TRUE);

		$data['q7'] = $this->Orcatrata_model->list7_combinar(TRUE);
		$data['list7'] = $this->load->view('orcatrata/list7_combinar', $data, TRUE);

		$data['q8'] = $this->Orcatrata_model->list8_pagamentoonline(TRUE);
		$data['list8'] = $this->load->view('orcatrata/list8_pagamentoonline', $data, TRUE);		

		
		$this->load->view('orcatrata/form_pedido', $data);
        

        $this->load->view('basico/footer');
    }

}
