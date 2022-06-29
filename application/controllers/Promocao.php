<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Promocao extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Promocao_model', 'Fornecedor_model', 'Formapag_model', 'Relatorio_model'));
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

        $this->load->view('promocao/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
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

		//$convdesc1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['valor']['Convdesc'], $caracteres_sem_acento));		
				
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			//'TipoCatprod',
			'PTCount2',
        ), TRUE));
		
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            //'idTab_Promocao', 
            'idTab_Catprom',  
            'Promocao',  
            'Descricao',
			'DataInicioProm',
			'DataFimProm',
			'TodoDiaProm',
			'VendaSite',
			'VendaBalcao',
			'TipoPromocao',
        ), TRUE));

 		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$this->input->post('DiaCount')) ? $data['count']['DiaCount'] = 0 : $data['count']['DiaCount'] = $this->input->post('DiaCount');		

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('ValorProduto' . $i) && $this->input->post('idTab_Produtos' . $i) && 
				$this->input->post('QtdProdutoDesconto' . $i) && $this->input->post('QtdProdutoIncremento' . $i)) {
				$data['item_promocao'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
                $data['item_promocao'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
				$data['item_promocao'][$j]['QtdProdutoIncremento'] = $this->input->post('QtdProdutoIncremento' . $i);
				$data['item_promocao'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				$data['item_promocao'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
				$data['item_promocao'][$j]['ComissaoVenda'] = $this->input->post('ComissaoVenda' . $i);
				$data['item_promocao'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
				$data['item_promocao'][$j]['ComissaoCashBack'] = $this->input->post('ComissaoCashBack' . $i);
				$data['item_promocao'][$j]['TempoDeEntrega'] = $this->input->post('TempoDeEntrega' . $i);
				//$data['item_promocao'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
				$data['item_promocao'][$j]['Convdesc'] = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($this->input->post('Convdesc' . $i), $caracteres_sem_acento));
				//$data['item_promocao'][$j]['AtivoPreco'] = $this->input->post('AtivoPreco' . $i);
				//$data['item_promocao'][$j]['VendaSitePreco'] = $this->input->post('VendaSitePreco' . $i);
				//$data['item_promocao'][$j]['VendaBalcaoPreco'] = $this->input->post('VendaBalcaoPreco' . $i);
                $j++;
            }
						
        }
        $data['count']['PTCount'] = $j - 1;

		if (isset($data['item_promocao'])) {
			if ($data['item_promocao']) {
				$data['conta_produto'] = 1;
			}else{
				$data['conta_produto'] = 0;
			}	
		}else{
			$data['conta_produto'] = 0;
		}		
		
		if (1==1) {
			
            for ($i = 1; $i <= 7; $i++) {

				if ($this->input->post('Aberto_Prom' . $i)){
					
					$data['dia_promocao'][$i]['Aberto_Prom'] = $this->input->post('Aberto_Prom' . $i);
				}
				/*
				(!$data['dia_promocao'][$i]['Aberto_Prom']) ? $data['dia_promocao'][$i]['Aberto_Prom'] = 'N' : FALSE;
				$data['radio'] = array(
					'Aberto_Prom' . $i => $this->basico->radio_checked($data['dia_promocao'][$i]['Aberto_Prom'], 'Aberto_Prom' . $i, 'NS'),
				);
				($data['dia_promocao'][$i]['Aberto_Prom'] == 'S') ? $data['div']['Aberto_Prom' . $i] = '' : $data['div']['Aberto_Prom' . $i] = 'style="display: none;"';
				*/
            }
			
        }		
		
		$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
		//$data['select']['TipoCatprod'] = $this->Basico_model->select_prod_serv();
		$data['select']['idTab_Catprom'] = $this->Basico_model->select_catprom();		
		$data['select']['idTab_Produtos'] = $this->Basico_model->select_produto_promocao();
		$data['select']['VendaBalcao'] = $this->Basico_model->select_status_sn();
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		//$data['select']['AtivoPreco'] = $this->Basico_model->select_status_sn();
		//$data['select']['VendaSitePreco'] = $this->Basico_model->select_status_sn();
		//$data['select']['VendaBalcaoPreco'] = $this->Basico_model->select_status_sn();		
		$data['select']['TodoDiaProm'] = $this->Basico_model->select_status_sn();
		$data['select']['Aberto_Prom'] = $this->Basico_model->select_status_sn();
        $data['select']['TipoPromocao'] = array(
            'V' => 'Venda',
            'R' => 'Revenda',
        );
				
		$data['radio'] = array(
            'TodoDiaProm' => $this->basico->radio_checked($data['promocao']['TodoDiaProm'], 'Todos os Dias', 'NS'),
        );
        ($data['promocao']['TodoDiaProm'] == 'N') ?
            $data['div']['TodoDiaProm'] = '' : $data['div']['TodoDiaProm'] = 'style="display: none;"';		
				
        $data['titulo'] = 'Cadastrar Promocao';
        $data['form_open_path'] = 'promocao/cadastrar';
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

		$data['q1'] = $this->Promocao_model->list_categoria($_SESSION['log'], TRUE);
		$data['list1'] = $this->load->view('promocao/list_categoria', $data, TRUE);			
        
		$data['q_promocoes'] = $this->Promocao_model->list_promocoes($_SESSION['log'], TRUE);
		$data['list_promocoes'] = $this->load->view('promocao/list_promocoes', $data, TRUE);		
		
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('Promocao', 'Titulo', 'required|trim');
		$this->form_validation->set_rules('Descricao', 'Descrição', 'required|trim');
		$this->form_validation->set_rules('DataInicioProm', 'Data do Inicio', 'required|trim|valid_date');
		$this->form_validation->set_rules('DataFimProm', 'Data do Fim', 'required|trim|valid_date');
		$this->form_validation->set_rules('PTCount2', 'A promoção deve possuir , pelo menos, 1 produto!', 'trim|valid_promocao');
		$this->form_validation->set_rules('idTab_Catprom', 'Categoria', 'required|trim');	
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
            $this->load->view('promocao/form_promocao', $data);
        } else {
			////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////

			#### Tab_Promocao ####
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'UTF-8'));
			$data['promocao']['Descricao'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'UTF-8'));
			$data['promocao']['DataInicioProm'] = $this->basico->mascara_data($data['promocao']['DataInicioProm'], 'mysql');
			$data['promocao']['DataFimProm'] = $this->basico->mascara_data($data['promocao']['DataFimProm'], 'mysql');
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['promocao']['Desconto'] = 2;
            $data['promocao']['idTab_Promocao'] = $this->Promocao_model->set_promocao($data['promocao']);
            
			if ($data['promocao']['idTab_Promocao'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao', $data);
            } else {            
				#### Tab_Dia_Prom ####
				if (isset($data['dia_promocao'])) {
					
					$data['dia_promocao']['1']['Dia_Semana_Prom'] = "SEGUNDA";
					$data['dia_promocao']['2']['Dia_Semana_Prom'] = "TERCA";
					$data['dia_promocao']['3']['Dia_Semana_Prom'] = "QUARTA";
					$data['dia_promocao']['4']['Dia_Semana_Prom'] = "QUINTA";
					$data['dia_promocao']['5']['Dia_Semana_Prom'] = "SEXTA";
					$data['dia_promocao']['6']['Dia_Semana_Prom'] = "SABADO";
					$data['dia_promocao']['7']['Dia_Semana_Prom'] = "DOMINGO";
					
					$max = count($data['dia_promocao']);
					for($j=1;$j<=$max;$j++) {
						$data['dia_promocao'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];
						$data['dia_promocao'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];					
						$data['dia_promocao'][$j]['id_Dia_Prom'] = $j;					
						$data['dia_promocao'][$j]['Dia_Semana_Prom'] = $data['dia_promocao'][$j]['Dia_Semana_Prom'];
						$data['dia_promocao'][$j]['Hora_Abre_Prom'] = "00:00:00";
						$data['dia_promocao'][$j]['Hora_Fecha_Prom'] = "23:59:59";
						
						if ($data['promocao']['TodoDiaProm'] == 'S') {
							$data['dia_promocao'][$j]['Aberto_Prom'] = 'S';
						} else {
							$data['dia_promocao'][$j]['Aberto_Prom'] = $data['dia_promocao'][$j]['Aberto_Prom'];
						}
					}
					$data['dia_promocao']['idTab_Dia_Prom'] = $this->Promocao_model->set_dia_promocao1($data['dia_promocao']);
				}
				
				
				#### Tab_Dia_Prom ####
				if (isset($data['item_promocao'])) {
					$max = count($data['item_promocao']);
					for($j=1;$j<=$max;$j++) {
						$data['item_promocao'][$j]['Item_Promocao'] = "1";
						$data['item_promocao'][$j]['Convdesc'] = trim(mb_strtoupper($data['item_promocao'][$j]['Convdesc'], 'UTF-8'));
						$data['item_promocao'][$j]['Desconto'] = 2;
						$data['item_promocao'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						$data['item_promocao'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
						$data['item_promocao'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
						$data['item_promocao'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];
						
						if(empty($data['item_promocao'][$j]['ValorProduto'])){
							$data['item_promocao'][$j]['ValorProduto'] = "0.00";
						}else{
							$data['item_promocao'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['item_promocao'][$j]['ValorProduto']));
						}
						if(empty($data['item_promocao'][$j]['ComissaoVenda'])){
							$data['item_promocao'][$j]['ComissaoVenda'] = "0.00";
						}else{
							$data['item_promocao'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['item_promocao'][$j]['ComissaoVenda']));
						}
						if(empty($data['item_promocao'][$j]['ComissaoServico'])){
							$data['item_promocao'][$j]['ComissaoServico'] = "0.00";
						}else{
							$data['item_promocao'][$j]['ComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['item_promocao'][$j]['ComissaoServico']));
						}
						if(empty($data['item_promocao'][$j]['ComissaoCashBack'])){
							$data['item_promocao'][$j]['ComissaoCashBack'] = "0.00";
						}else{
							$data['item_promocao'][$j]['ComissaoCashBack'] = str_replace(',', '.', str_replace('.', '', $data['item_promocao'][$j]['ComissaoCashBack']));
						}							
						
						if(empty($data['item_promocao'][$j]['QtdProdutoDesconto'])){
							$data['item_promocao'][$j]['QtdProdutoDesconto'] = "1";
						}
						if(empty($data['item_promocao'][$j]['QtdProdutoIncremento'])){
							$data['item_promocao'][$j]['QtdProdutoIncremento'] = "1";
						}
						if(empty($data['item_promocao'][$j]['TempoDeEntrega'])){
							$data['item_promocao'][$j]['TempoDeEntrega'] = "0";
						}	
					
					}
					$data['item_promocao']['idTab_Valor'] = $this->Promocao_model->set_item_promocao($data['item_promocao']);
				}
				
				$data['update']['dia_promocao']['posterior'] = $this->Promocao_model->get_dia_promocao_posterior($data['promocao']['idTab_Promocao']);
				if (isset($data['update']['dia_promocao']['posterior'])){
					$max_dia_promocao = count($data['update']['dia_promocao']['posterior']);
					if($max_dia_promocao == 0){
						$data['promocao']['TodoDiaProm'] = "S";				
					}else{
						$data['promocao']['TodoDiaProm'] = "N";
					}

				}
				
				$data['update']['promocao']['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
				$data['update']['promocao']['campos'] = array_keys($data['promocao']);
				$data['update']['promocao']['auditoriaitem'] = $this->basico->set_log(
					$data['update']['promocao']['anterior'],
					$data['promocao'],
					$data['update']['promocao']['campos'],
					$data['promocao']['idTab_Promocao'], TRUE);
				$data['update']['promocao']['bd'] = $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']);	

				//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				redirect(base_url() . 'promocao/tela_promocao/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
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

			//$convdesc1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['valor']['Convdesc'], $caracteres_sem_acento));		
					
			$data['cadastrar'] = quotes_to_entities($this->input->post(array(
				'Cadastrar',
				//'TipoCatprod',
				'PTCount2',
			), TRUE));
			
			$data['promocao'] = quotes_to_entities($this->input->post(array(
				#### Tab_Promocao ####
				'idTab_Promocao',
				'idTab_Catprom',			
				'Promocao', 
				'Descricao',
				'DataInicioProm',
				'DataFimProm',
				'TodoDiaProm',
				'VendaBalcao',
				'VendaSite',
				'TipoPromocao',
			), TRUE));

			(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
			(!$this->input->post('DiaCount')) ? $data['count']['DiaCount'] = 0 : $data['count']['DiaCount'] = $this->input->post('DiaCount');
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

				if ($this->input->post('idTab_Produtos' . $i)){
					$data['item_promocao'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
					$data['item_promocao'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
					$data['item_promocao'][$j]['QtdProdutoIncremento'] = $this->input->post('QtdProdutoIncremento' . $i);
					$data['item_promocao'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
					$data['item_promocao'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
					$data['item_promocao'][$j]['ComissaoVenda'] = $this->input->post('ComissaoVenda' . $i);
					$data['item_promocao'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
					$data['item_promocao'][$j]['ComissaoCashBack'] = $this->input->post('ComissaoCashBack' . $i);
					$data['item_promocao'][$j]['TempoDeEntrega'] = $this->input->post('TempoDeEntrega' . $i);
					$data['item_promocao'][$j]['Convdesc'] = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($this->input->post('Convdesc' . $i), $caracteres_sem_acento));
					//$data['item_promocao'][$j]['AtivoPreco'] = $this->input->post('AtivoPreco' . $i);
					//$data['item_promocao'][$j]['VendaSitePreco'] = $this->input->post('VendaSitePreco' . $i);
					//$data['item_promocao'][$j]['VendaBalcaoPreco'] = $this->input->post('VendaBalcaoPreco' . $i);
					$j++;
				}
							
			}
			$data['count']['PTCount'] = $j - 1;

			if (isset($data['item_promocao'])) {
				if ($data['item_promocao']) {
					$data['conta_produto'] = 1;
				}else{
					$data['conta_produto'] = 1;
				}	
			}else{
				$data['conta_produto'] = 1;
			}		

			$j = 1;
			for ($i = 1; $i <= $data['count']['DiaCount']; $i++) {

				if ($this->input->post('idTab_Dia_Prom' . $i)) {
					$data['dia_promocao'][$j]['idTab_Dia_Prom'] = $this->input->post('idTab_Dia_Prom' . $i);
					$data['dia_promocao'][$j]['Aberto_Prom'] = $this->input->post('Aberto_Prom' . $i);
					$j++;
				}
							
			}
			$data['count']['DiaCount'] = $j - 1;		
			
			if ($id) {
				#### Tab_Promocao ####
				$_SESSION['Promocao'] = $data['promocao'] = $this->Promocao_model->get_promocao($id);

				if($data['promocao'] === FALSE){
					
					unset($_SESSION['Promocao']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
				
					$data['promocao']['DataInicioProm'] = $this->basico->mascara_data($data['promocao']['DataInicioProm'], 'barras');
					$data['promocao']['DataFimProm'] = $this->basico->mascara_data($data['promocao']['DataFimProm'], 'barras');
					
					#### Tab_Valor ####
					$_SESSION['Item_Promocao'] = $data['item_promocao'] = $this->Promocao_model->get_item_promocao($id, "2");
					if (count($data['item_promocao']) > 0) {
						$data['item_promocao'] = array_combine(range(1, count($data['item_promocao'])), array_values($data['item_promocao']));
						$data['count']['PTCount'] = count($data['item_promocao']);
						if (isset($data['item_promocao'])) {

							for($j=1; $j <= $data['count']['PTCount']; $j++){
								$_SESSION['Item_Promocao'][$j] = $data['item_promocao'][$j];	 
								/*
								echo '<br>';
								echo "<pre>";
								print_r($_SESSION['Item_Promocao'][$j]);
								echo "</pre>";
								*/
							}
								
						}				
					}

					#### Tab_Dia_Prom ####
					$_SESSION['Dia_Promocao'] = $data['dia_promocao'] = $this->Promocao_model->get_dia_promocao($id, "2");
					if (count($data['dia_promocao']) > 0) {
						$data['dia_promocao'] = array_combine(range(1, count($data['dia_promocao'])), array_values($data['dia_promocao']));
						$data['count']['DiaCount'] = count($data['dia_promocao']);
						
						if (isset($data['dia_promocao'])) {

							for($j=1; $j <= $data['count']['DiaCount']; $j++){
								$_SESSION['Dia_Promocao'][$j] = $data['dia_promocao'][$j];
								/*
								echo '<br>';
								echo "<pre>";
								print_r($_SESSION['Dia_Promocao'][$j]);
								echo "</pre>";
								*/
							}
								
						}
										
					}			
				}
			}

			if(!$data['promocao']['idTab_Promocao'] || !$_SESSION['Promocao']){
				
				unset($_SESSION['Promocao']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
				$data['select']['idTab_Produtos'] = $this->Basico_model->select_produto_promocao();
				$data['select']['idTab_Catprom'] = $this->Basico_model->select_catprom();
				$data['select']['VendaBalcao'] = $this->Basico_model->select_status_sn();
				$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
				//$data['select']['AtivoPreco'] = $this->Basico_model->select_status_sn();
				//$data['select']['VendaSitePreco'] = $this->Basico_model->select_status_sn();
				//$data['select']['VendaBalcaoPreco'] = $this->Basico_model->select_status_sn();
				$data['select']['TodoDiaProm'] = $this->Basico_model->select_status_sn();
				$data['select']['Aberto_Prom'] = $this->Basico_model->select_status_sn();
				$data['select']['TipoPromocao'] = array(
					'V' => 'Venda',
					'R' => 'Revenda',
				);	
						
				$data['radio'] = array(
					'TodoDiaProm' => $this->basico->radio_checked($data['promocao']['TodoDiaProm'], 'Todos os Dias', 'NS'),
				);
				($data['promocao']['TodoDiaProm'] == 'N') ?
					$data['div']['TodoDiaProm'] = '' : $data['div']['TodoDiaProm'] = 'style="display: none;"';		
				
				$data['titulo'] = 'Editar Promoção';
				$data['form_open_path'] = 'promocao/alterar';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

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
					
				$data['q1'] = $this->Promocao_model->list_categoria($_SESSION['log'], TRUE);
				$data['list1'] = $this->load->view('promocao/list_categoria', $data, TRUE);			
				
				$data['q_promocoes'] = $this->Promocao_model->list_promocoes($_SESSION['log'], TRUE);
				$data['list_promocoes'] = $this->load->view('promocao/list_promocoes', $data, TRUE);
				
				$data['q_itens_promocao'] = $this->Promocao_model->list_itens_promocao($data['promocao'], TRUE);
				$data['list_itens_promocao'] = $this->load->view('promocao/list_itens_promocao', $data, TRUE);
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				$this->form_validation->set_rules('idTab_Promocao', 'Promocao', 'required|trim');
				$this->form_validation->set_rules('Promocao', 'Titulo', 'required|trim');
				$this->form_validation->set_rules('Descricao', 'Descrição', 'required|trim');
				$this->form_validation->set_rules('DataInicioProm', 'Data do Inicio', 'required|trim|valid_date');
				$this->form_validation->set_rules('DataFimProm', 'Data do Fim', 'required|trim|valid_date');
				$this->form_validation->set_rules('PTCount2', 'A promoção deve possuir, pelo menos, 1 produto! Confira e Salve!', 'trim|valid_promocao');
				$this->form_validation->set_rules('idTab_Catprom', 'Categoria', 'required|trim');	
				$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('promocao/form_promocao', $data);
				} else {
	
					if($this->Basico_model->get_dt_validade() === FALSE){
						
						unset($_SESSION['Promocao']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
						
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
						
						#### Tab_Promocao ####
						$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'UTF-8'));
						$data['promocao']['Descricao'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'UTF-8'));
						$data['promocao']['DataInicioProm'] = $this->basico->mascara_data($data['promocao']['DataInicioProm'], 'mysql');
						$data['promocao']['DataFimProm'] = $this->basico->mascara_data($data['promocao']['DataFimProm'], 'mysql');
						
						$data['update']['promocao']['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
						$data['update']['promocao']['campos'] = array_keys($data['promocao']);
						$data['update']['promocao']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['promocao']['anterior'],
							$data['promocao'],
							$data['update']['promocao']['campos'],
							$data['promocao']['idTab_Promocao'], TRUE);
						$data['update']['promocao']['bd'] = $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']);
						
						#### Tab_Valor ####
						$data['update']['item_promocao']['anterior'] = $this->Promocao_model->get_item_promocao($data['promocao']['idTab_Promocao'], "2");
						if (isset($data['item_promocao']) || (!isset($data['item_promocao']) && isset($data['update']['item_promocao']['anterior']) ) ) {

							if (isset($data['item_promocao']))
								$data['item_promocao'] = array_values($data['item_promocao']);
							else
								$data['item_promocao'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['item_promocao'] = $this->basico->tratamento_array_multidimensional($data['item_promocao'], $data['update']['item_promocao']['anterior'], 'idTab_Valor');

							$max = count($data['update']['item_promocao']['inserir']);
							for($j=0;$j<$max;$j++) {
								$data['update']['item_promocao']['inserir'][$j]['Item_Promocao'] = "1";
								$data['update']['item_promocao']['inserir'][$j]['Desconto'] = 2;
								$data['update']['item_promocao']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['update']['item_promocao']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['item_promocao']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['item_promocao']['inserir'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];
								//$data['update']['item_promocao']['inserir'][$j]['idTab_Catprod'] = $_SESSION['Item_Promocao']['idTab_Catprod'];
								//$data['update']['item_promocao']['inserir'][$j]['idTab_Produto'] = $_SESSION['Item_Promocao']['idTab_Produto'];
								$data['update']['item_promocao']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['inserir'][$j]['Convdesc'], 'UTF-8'));					
								if(empty($data['update']['item_promocao']['inserir'][$j]['ValorProduto'])){
									$data['update']['item_promocao']['inserir'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['item_promocao']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ValorProduto']));
								}
								if(empty($data['update']['item_promocao']['inserir'][$j]['ComissaoVenda'])){
									$data['update']['item_promocao']['inserir'][$j]['ComissaoVenda'] = "0.00";
								}else{
									$data['update']['item_promocao']['inserir'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ComissaoVenda']));
								}
								if(empty($data['update']['item_promocao']['inserir'][$j]['ComissaoServico'])){
									$data['update']['item_promocao']['inserir'][$j]['ComissaoServico'] = "0.00";
								}else{
									$data['update']['item_promocao']['inserir'][$j]['ComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ComissaoServico']));
								}
								if(empty($data['update']['item_promocao']['inserir'][$j]['ComissaoCashBack'])){
									$data['update']['item_promocao']['inserir'][$j]['ComissaoCashBack'] = "0.00";
								}else{
									$data['update']['item_promocao']['inserir'][$j]['ComissaoCashBack'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ComissaoCashBack']));
								}
								if(empty($data['update']['item_promocao']['inserir'][$j]['QtdProdutoDesconto'])){
									$data['update']['item_promocao']['inserir'][$j]['QtdProdutoDesconto'] = "1";
								}
								if(empty($data['update']['item_promocao']['inserir'][$j]['QtdProdutoIncremento'])){
									$data['update']['item_promocao']['inserir'][$j]['QtdProdutoIncremento'] = "1";
								}
								if(empty($data['update']['item_promocao']['inserir'][$j]['TempoDeEntrega'])){
									$data['update']['item_promocao']['inserir'][$j]['TempoDeEntrega'] = "0";
								}
								if(empty($data['update']['item_promocao']['inserir'][$j]['idTab_Produtos'])){
									$data['update']['item_promocao']['inserir'][$j]['idTab_Produtos'] = "0";
								}						

							}

							$max = count($data['update']['item_promocao']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['item_promocao']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['alterar'][$j]['Convdesc'], 'UTF-8'));
								if(empty($data['update']['item_promocao']['alterar'][$j]['ValorProduto'])){
									$data['update']['item_promocao']['alterar'][$j]['ValorProduto'] = "0.00";
								}else{
									$data['update']['item_promocao']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ValorProduto']));
								}					
								if(empty($data['update']['item_promocao']['alterar'][$j]['ComissaoVenda'])){
									$data['update']['item_promocao']['alterar'][$j]['ComissaoVenda'] = "0.00";
								}else{
									$data['update']['item_promocao']['alterar'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ComissaoVenda']));
								}						
								if(empty($data['update']['item_promocao']['alterar'][$j]['ComissaoServico'])){
									$data['update']['item_promocao']['alterar'][$j]['ComissaoServico'] = "0.00";
								}else{
									$data['update']['item_promocao']['alterar'][$j]['ComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ComissaoServico']));
								}						
								if(empty($data['update']['item_promocao']['alterar'][$j]['ComissaoCashBack'])){
									$data['update']['item_promocao']['alterar'][$j]['ComissaoCashBack'] = "0.00";
								}else{
									$data['update']['item_promocao']['alterar'][$j]['ComissaoCashBack'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ComissaoCashBack']));
								}
								if(empty($data['update']['item_promocao']['alterar'][$j]['QtdProdutoDesconto'])){
									$data['update']['item_promocao']['alterar'][$j]['QtdProdutoDesconto'] = "1";
								}
								if(empty($data['update']['item_promocao']['alterar'][$j]['QtdProdutoIncremento'])){
									$data['update']['item_promocao']['alterar'][$j]['QtdProdutoIncremento'] = "1";
								}
								if(empty($data['update']['item_promocao']['alterar'][$j]['TempoDeEntrega'])){
									$data['update']['item_promocao']['alterar'][$j]['TempoDeEntrega'] = "0";
								}
								if(empty($data['update']['item_promocao']['alterar'][$j]['idTab_Produtos'])){
									$data['update']['item_promocao']['alterar'][$j]['idTab_Produtos'] = "0";
								}						
								
							}

							if (count($data['update']['item_promocao']['inserir']))
								$data['update']['item_promocao']['bd']['inserir'] = $this->Promocao_model->set_item_promocao($data['update']['item_promocao']['inserir']);

							if (count($data['update']['item_promocao']['alterar']))
								$data['update']['item_promocao']['bd']['alterar'] =  $this->Promocao_model->update_item_promocao($data['update']['item_promocao']['alterar']);

							if (count($data['update']['item_promocao']['excluir']))
								$data['update']['item_promocao']['bd']['excluir'] = $this->Promocao_model->delete_item_promocao($data['update']['item_promocao']['excluir']);

						}
						
						#### Tab_Dia_Prom ####
						$data['update']['dia_promocao']['anterior'] = $this->Promocao_model->get_dia_promocao($data['promocao']['idTab_Promocao'], "2");

						if (isset($data['dia_promocao']) || (!isset($data['dia_promocao']) && isset($data['update']['dia_promocao']['anterior']) ) ) {

							if (isset($data['dia_promocao']))
								$data['dia_promocao'] = array_values($data['dia_promocao']);
							else
								$data['dia_promocao'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['dia_promocao'] = $this->basico->tratamento_array_multidimensional($data['dia_promocao'], $data['update']['dia_promocao']['anterior'], 'idTab_Dia_Prom');

							$max = count($data['update']['dia_promocao']['alterar']);
							for($j=0;$j<$max;$j++) {
								if($data['promocao']['TodoDiaProm'] == 'S'){
									$data['update']['dia_promocao']['alterar'][$j]['Aberto_Prom'] = 'S';
								}
								/*
								$data['update']['dia_promocao']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['dia_promocao']['alterar'][$j]['ValorProduto']));
								$data['update']['dia_promocao']['alterar'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['dia_promocao']['alterar'][$j]['ComissaoVenda']));
								$data['update']['dia_promocao']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['dia_promocao']['alterar'][$j]['Convdesc'], 'UTF-8'));
								*/
							}

							if (count($data['update']['dia_promocao']['alterar']))
								$data['update']['dia_promocao']['bd']['alterar'] =  $this->Promocao_model->update_dia_promocao($data['update']['dia_promocao']['alterar']);
							
							if(!$data['dia_promocao'] && !$data['update']['dia_promocao']['anterior']){
						
								$data['dia_promocao']['1']['Dia_Semana_Prom'] = "SEGUNDA";
								$data['dia_promocao']['2']['Dia_Semana_Prom'] = "TERCA";
								$data['dia_promocao']['3']['Dia_Semana_Prom'] = "QUARTA";
								$data['dia_promocao']['4']['Dia_Semana_Prom'] = "QUINTA";
								$data['dia_promocao']['5']['Dia_Semana_Prom'] = "SEXTA";
								$data['dia_promocao']['6']['Dia_Semana_Prom'] = "SABADO";
								$data['dia_promocao']['7']['Dia_Semana_Prom'] = "DOMINGO";
								
								for($j=1; $j<=7; $j++) {
									$data['dia_promocao'][$j] = array(
										'idTab_Promocao' => $data['promocao']['idTab_Promocao'],
										'idSis_Empresa' => $_SESSION['log']['idSis_Empresa'],
										'id_Dia_Prom' => $j,
										'Dia_Semana_Prom' => $data['dia_promocao'][$j]['Dia_Semana_Prom'],
										'Aberto_Prom' => "S",
										'Hora_Abre_Prom' => "00:00:00",
										'Hora_Fecha_Prom' => "23:59:59"
									);
									$data['campos'] = array_keys($data['dia_promocao'][$j]);
									$data['idTab_Dia_Prom'] = $this->Promocao_model->set_dia_promocao($data['dia_promocao'][$j]);
								}			
							
							}
							
						}
						
						$data['update']['dia_promocao']['posterior'] = $this->Promocao_model->get_dia_promocao_posterior($data['promocao']['idTab_Promocao']);
						if (isset($data['update']['dia_promocao']['posterior'])){
							$max_dia_promocao = count($data['update']['dia_promocao']['posterior']);
							if($max_dia_promocao == 0){
								$data['promocao']['TodoDiaProm'] = "S";				
							}else{
								$data['promocao']['TodoDiaProm'] = "N";
							}

						}
						
						$data['update']['promocao']['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
						$data['update']['promocao']['campos'] = array_keys($data['promocao']);
						$data['update']['promocao']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['promocao']['anterior'],
							$data['promocao'],
							$data['update']['promocao']['campos'],
							$data['promocao']['idTab_Promocao'], TRUE);
						$data['update']['promocao']['bd'] = $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']);	
							
						if ($data['auditoriaitem'] && !$data['update']['promocao']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('promocao/form_promocao', $data);
						} else {

							$data['msg'] = '?m=1';
							redirect(base_url() . 'promocao/tela_promocao/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
							
							exit();
						}
					}	
				}
			}
		
        $this->load->view('basico/footer');

    }
	
    public function tela_promocao($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
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

			//$convdesc1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($data['valor']['Convdesc'], $caracteres_sem_acento));		
			
			$data['promocao'] = quotes_to_entities($this->input->post(array(
				#### Tab_Promocao ####
				'idTab_Promocao',			
				'Promocao', 
				'Descricao',
				'DataInicioProm',
				'DataFimProm',
				'TodoDiaProm',
				'VendaBalcao',
				'VendaSite',
				'TipoPromocao',
			), TRUE));
			
			$dia_da_semana = date('N');
			/*
			echo '<br>';
			echo "<pre>";
			print_r($dia_da_semana);
			echo "</pre>";
			exit();
			*/
			(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
			(!$this->input->post('DiaCount')) ? $data['count']['DiaCount'] = 0 : $data['count']['DiaCount'] = $this->input->post('DiaCount');		
			$data['conta_produto'] = 0;
			$j = 1;
			for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

				if ($this->input->post('ValorProduto' . $i)) {
					$data['item_promocao'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
					$data['item_promocao'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
					$data['item_promocao'][$j]['QtdProdutoIncremento'] = $this->input->post('QtdProdutoIncremento' . $i);
					$data['item_promocao'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
					$data['item_promocao'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
					$data['item_promocao'][$j]['ComissaoVenda'] = $this->input->post('ComissaoVenda' . $i);
					$data['item_promocao'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
					$data['item_promocao'][$j]['ComissaoCashBack'] = $this->input->post('ComissaoCashBack' . $i);
					$data['item_promocao'][$j]['TempoDeEntrega'] = $this->input->post('TempoDeEntrega' . $i);
					$data['item_promocao'][$j]['Convdesc'] = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($this->input->post('Convdesc' . $i), $caracteres_sem_acento));
					//$data['item_promocao'][$j]['AtivoPreco'] = $this->input->post('AtivoPreco' . $i);
					//$data['item_promocao'][$j]['VendaSitePreco'] = $this->input->post('VendaSitePreco' . $i);
					//data['item_promocao'][$j]['VendaBalcaoPreco'] = $this->input->post('VendaBalcaoPreco' . $i);
					$j++;
				}
							
			}
			$data['count']['PTCount'] = $j - 1;		
			
			$j = 1;
			for ($i = 1; $i <= $data['count']['DiaCount']; $i++) {

				if ($this->input->post('idTab_Dia_Prom' . $i)) {
					$data['dia_promocao'][$j]['idTab_Dia_Prom'] = $this->input->post('idTab_Dia_Prom' . $i);
					$data['dia_promocao'][$j]['Aberto_Prom'] = $this->input->post('Aberto_Prom' . $i);
					$j++;
				}
							
			}
			$data['count']['DiaCount'] = $j - 1;		

			if ($id) {
				#### Tab_Promocao ####
				$_SESSION['Promocao'] = $data['promocao'] = $this->Promocao_model->get_promocao($id);

				if($data['promocao'] === FALSE){
					
					unset($_SESSION['Promocao']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
					#### Tab_Valor ####
					$_SESSION['Item_Promocao'] = $data['item_promocao'] = $this->Promocao_model->get_item_promocao($id, "2");
					if (count($data['item_promocao']) > 0) {
						$data['item_promocao'] = array_combine(range(1, count($data['item_promocao'])), array_values($data['item_promocao']));
						$data['count']['PTCount'] = count($data['item_promocao']);
						
						if (isset($data['item_promocao'])) {

							for($j=1; $j <= $data['count']['PTCount']; $j++){
								$_SESSION['Item_Promocao'][$j] = $data['item_promocao'][$j];
								//$_SESSION['Item_Promocao'][$j]['AtivoPreco'] = $this->basico->mascara_palavra_completa($data['item_promocao'][$j]['AtivoPreco'], 'NS');
								//$_SESSION['Item_Promocao'][$j]['VendaSitePreco'] = $this->basico->mascara_palavra_completa($data['item_promocao'][$j]['VendaSitePreco'], 'NS');
								//$_SESSION['Item_Promocao'][$j]['VendaBalcaoPreco'] = $this->basico->mascara_palavra_completa($data['item_promocao'][$j]['VendaBalcaoPreco'], 'NS');
								if($data['item_promocao'][$j]['TempoDeEntrega'] == 0){
									$_SESSION['Item_Promocao'][$j]['TempoDeEntrega'] = "Pronta Entrega";
								}
								/*
								echo '<br>';
								echo "<pre>";
								print_r($_SESSION['Item_Promocao'][$j]);
								echo "</pre>";
								*/
							}
								
						}
										
					}
					
					#### Tab_Dia_Prom ####
					$_SESSION['Dia_Promocao'] = $data['dia_promocao'] = $this->Promocao_model->get_dia_promocao($id, "2");
					if (count($data['dia_promocao']) > 0) {
						$data['dia_promocao'] = array_combine(range(1, count($data['dia_promocao'])), array_values($data['dia_promocao']));
						$data['count']['DiaCount'] = count($data['dia_promocao']);
						
						if (isset($data['dia_promocao'])) {

							for($j=1; $j <= $data['count']['DiaCount']; $j++){
								$_SESSION['Dia_Promocao'][$j] = $data['dia_promocao'][$j];
								$_SESSION['Dia_Promocao'][$j]['Aberto_Prom'] = $this->basico->mascara_palavra_completa($data['dia_promocao'][$j]['Aberto_Prom'], 'NS');
								/*
								echo '<br>';
								echo "<pre>";
								print_r($_SESSION['Dia_Promocao'][$j]);
								echo "</pre>";
								*/
							}
								
						}
										
					}			
				}
			}
			//exit();

			if(!$data['promocao']['idTab_Promocao'] || !$_SESSION['Promocao']){
				
				unset($_SESSION['Promocao']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				$_SESSION['Promocao']['DataInicioProm']  = $this->basico->mascara_data($data['promocao']['DataInicioProm'], 'barras');
				$_SESSION['Promocao']['DataFimProm']  = $this->basico->mascara_data($data['promocao']['DataFimProm'], 'barras');
				
				$_SESSION['Promocao']['TodoDiaProm'] = $this->basico->mascara_palavra_completa($data['promocao']['TodoDiaProm'], 'NS');
				$_SESSION['Promocao']['VendaBalcao'] = $this->basico->mascara_palavra_completa($data['promocao']['VendaBalcao'], 'NS');
				$_SESSION['Promocao']['VendaSite'] = $this->basico->mascara_palavra_completa($data['promocao']['VendaSite'], 'NS');

				$data['select']['idTab_Produtos'] = $this->Basico_model->select_produto_promocao();
				$data['select']['VendaBalcao'] = $this->Basico_model->select_status_sn();
				$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
				//$data['select']['AtivoPreco'] = $this->Basico_model->select_status_sn();
				//$data['select']['VendaSitePreco'] = $this->Basico_model->select_status_sn();
				//$data['select']['VendaBalcaoPreco'] = $this->Basico_model->select_status_sn();
				$data['select']['TodoDiaProm'] = $this->Basico_model->select_status_sn();
				$data['select']['Aberto_Prom'] = $this->Basico_model->select_status_sn();
				$data['select']['TipoPromocao'] = array(
					'V' => 'Venda',
					'R' => 'Revenda',
				);		

				$data['radio'] = array(
					'TodoDiaProm' => $this->basico->radio_checked($data['promocao']['TodoDiaProm'], 'Todos os Dias', 'NS'),
				);
				($data['promocao']['TodoDiaProm'] == 'N') ?
					$data['div']['TodoDiaProm'] = '' : $data['div']['TodoDiaProm'] = 'style="display: none;"';
					
				$data['titulo'] = 'Promoção';
				$data['form_open_path'] = 'promocao/tela_promocao';
				$data['readonly'] = '';
				$data['disabled'] = '';
				$data['panel'] = 'primary';
				$data['metodo'] = 3;

				$data['sidebar'] = 'col-sm-3 col-md-2';
				$data['main'] = 'col-sm-7 col-md-8';

				$data['datepicker'] = 'DatePicker';
				$data['timepicker'] = 'TimePicker';

				$data['q_promocoes'] = $this->Promocao_model->list_promocoes($_SESSION['log'], TRUE);
				$data['list_promocoes'] = $this->load->view('promocao/list_promocoes', $data, TRUE);
				
				$data['q_itens_promocao'] = $this->Promocao_model->list_itens_promocao($data['promocao'], TRUE);
				$data['list_itens_promocao'] = $this->load->view('promocao/list_itens_promocao', $data, TRUE);
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
				$this->form_validation->set_rules('idTab_Promocao', 'Promocao', 'required|trim');
				$this->form_validation->set_rules('Promocao', 'Titulo', 'required|trim');
				$this->form_validation->set_rules('Descricao', 'Descrição', 'required|trim');

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('promocao/form_promocao', $data);
				} else {
						
					if($this->Basico_model->get_dt_validade() === FALSE){
						
						unset($_SESSION['Promocao']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
							
						////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////

						#### Tab_Promocao ####
						$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'UTF-8'));
						$data['promocao']['Descricao'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'UTF-8'));
						
						$data['update']['promocao']['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
						$data['update']['promocao']['campos'] = array_keys($data['promocao']);
						$data['update']['promocao']['auditoriaitem'] = $this->basico->set_log(
							$data['update']['promocao']['anterior'],
							$data['promocao'],
							$data['update']['promocao']['campos'],
							$data['promocao']['idTab_Promocao'], TRUE);
						$data['update']['promocao']['bd'] = $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']);
						
						#### Tab_Valor ####
						$data['update']['item_promocao']['anterior'] = $this->Promocao_model->get_item_promocao($data['promocao']['idTab_Promocao'], "2");
						if (isset($data['item_promocao']) || (!isset($data['item_promocao']) && isset($data['update']['item_promocao']['anterior']) ) ) {

							if (isset($data['item_promocao']))
								$data['item_promocao'] = array_values($data['item_promocao']);
							else
								$data['item_promocao'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['item_promocao'] = $this->basico->tratamento_array_multidimensional($data['item_promocao'], $data['update']['item_promocao']['anterior'], 'idTab_Valor');

							$max = count($data['update']['item_promocao']['inserir']);
							for($j=0;$j<$max;$j++) {
								$data['update']['item_promocao']['inserir'][$j]['Item_Promocao'] = "1";
								$data['update']['item_promocao']['inserir'][$j]['Desconto'] = 2;
								$data['update']['item_promocao']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
								$data['update']['item_promocao']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
								$data['update']['item_promocao']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
								$data['update']['item_promocao']['inserir'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];
								//$data['update']['item_promocao']['inserir'][$j]['idTab_Catprod'] = $_SESSION['Item_Promocao']['idTab_Catprod'];
								//$data['update']['item_promocao']['inserir'][$j]['idTab_Produto'] = $_SESSION['Item_Promocao']['idTab_Produto'];
								$data['update']['item_promocao']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ValorProduto']));
								$data['update']['item_promocao']['inserir'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ComissaoVenda']));
								$data['update']['item_promocao']['inserir'][$j]['ComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ComissaoServico']));
								$data['update']['item_promocao']['inserir'][$j]['ComissaoCashBack'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ComissaoCashBack']));
								$data['update']['item_promocao']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['inserir'][$j]['Convdesc'], 'UTF-8'));
							}

							$max = count($data['update']['item_promocao']['alterar']);
							for($j=0;$j<$max;$j++) {
								$data['update']['item_promocao']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ValorProduto']));
								$data['update']['item_promocao']['alterar'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ComissaoVenda']));
								$data['update']['item_promocao']['alterar'][$j]['ComissaoServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ComissaoServico']));
								$data['update']['item_promocao']['alterar'][$j]['ComissaoCashBack'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ComissaoCashBack']));
								$data['update']['item_promocao']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['alterar'][$j]['Convdesc'], 'UTF-8'));
							}

							if (count($data['update']['item_promocao']['inserir']))
								$data['update']['item_promocao']['bd']['inserir'] = $this->Promocao_model->set_item_promocao($data['update']['item_promocao']['inserir']);

							if (count($data['update']['item_promocao']['alterar']))
								$data['update']['item_promocao']['bd']['alterar'] =  $this->Promocao_model->update_item_promocao($data['update']['item_promocao']['alterar']);

							if (count($data['update']['item_promocao']['excluir']))
								$data['update']['item_promocao']['bd']['excluir'] = $this->Promocao_model->delete_item_promocao($data['update']['item_promocao']['excluir']);

						}
						
						#### Tab_Dia_Prom ####
						$data['update']['dia_promocao']['anterior'] = $this->Promocao_model->get_dia_promocao($data['promocao']['idTab_Promocao'], "2");
						if (isset($data['dia_promocao']) || (!isset($data['dia_promocao']) && isset($data['update']['dia_promocao']['anterior']) ) ) {

							if (isset($data['dia_promocao']))
								$data['dia_promocao'] = array_values($data['dia_promocao']);
							else
								$data['dia_promocao'] = array();

							//faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
							$data['update']['dia_promocao'] = $this->basico->tratamento_array_multidimensional($data['dia_promocao'], $data['update']['dia_promocao']['anterior'], 'idTab_Dia_Prom');

							$max = count($data['update']['dia_promocao']['alterar']);
							for($j=0;$j<$max;$j++) {
								/*
								$data['update']['dia_promocao']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['dia_promocao']['alterar'][$j]['ValorProduto']));
								$data['update']['dia_promocao']['alterar'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['dia_promocao']['alterar'][$j]['ComissaoVenda']));
								$data['update']['dia_promocao']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['dia_promocao']['alterar'][$j]['Convdesc'], 'UTF-8'));
								*/
							}

							if (count($data['update']['dia_promocao']['alterar']))
								$data['update']['dia_promocao']['bd']['alterar'] =  $this->Promocao_model->update_dia_promocao($data['update']['dia_promocao']['alterar']);

						}			
							
						if ($data['auditoriaitem'] && !$data['update']['promocao']['bd']) {
							$data['msg'] = '?m=2';
							$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

							$this->basico->erro($msg);
							$this->load->view('promocao/form_promocao', $data);
						} else {

							$data['msg'] = '?m=1';
							redirect(base_url() . 'promocao/tela_promocao/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
							
							exit();
						}
					}
				}
			}
		
        $this->load->view('basico/footer');

    }
	
    public function alterarlogocatprom($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

			$data['catprom'] = $this->input->post(array(
				'idTab_Catprom',
			), TRUE);
			
			$data['file'] = $this->input->post(array(
				'idTab_Catprom',
				'idSis_Empresa',
				'Arquivo',
			), TRUE);

			if ($id) {
				$_SESSION['Catprom'] = $data['catprom'] = $this->Promocao_model->get_catprom($id, TRUE);
			
				if($data['catprom'] === FALSE){
					
					unset($_SESSION['Catprom']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
					$data['file']['idTab_Catprom'] = $id;
				}
			}
			
			if(!$data['catprom']['idTab_Catprom'] || !$_SESSION['Catprom']){
				
				unset($_SESSION['Catprom']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
					
					$data['file']['Arquivo'] = $this->basico->renomeiacatprom($_FILES['Arquivo']['name']);
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
				} else {
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
				}

				$data['titulo'] = 'Alterar Foto';
				$data['form_open_path'] = 'promocao/alterarlogocatprom';
				$data['readonly'] = 'readonly';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					#load login view
					$this->load->view('promocao/form_catprom', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						unset($_SESSION['Catprom']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
						
						$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/';
						$config['max_size'] = 1000;
						$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
						$config['file_name'] = $data['file']['Arquivo'];

						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('Arquivo')) {
							$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
							$this->load->view('promocao/form_catprom', $data);
						} else {
						
							$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/';		
							$foto = $data['file']['Arquivo'];
							$diretorio = $dir.$foto;					
							$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/';

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
							$data['idSis_Arquivo'] = $this->Promocao_model->set_arquivo($data['file']);

							if ($data['idSis_Arquivo'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
								$this->basico->erro($msg);
								$this->load->view('promocao/form_catprom', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
								
								$data['catprom']['Arquivo'] = $data['file']['Arquivo'];
								$data['anterior'] = $this->Promocao_model->get_catprom($data['catprom']['idTab_Catprom']);
								$data['campos'] = array_keys($data['catprom']);

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['catprom'], $data['campos'], $data['catprom']['idTab_Catprom'], TRUE);

								if ($data['auditoriaitem'] && $this->Promocao_model->update_catprom($data['catprom'], $data['catprom']['idTab_Catprom']) === FALSE) {
									$data['msg'] = '?m=2';
									redirect(base_url() . 'promocao/alterarlogocatprom/' . $data['catprom']['idTab_Catprom'] . $data['msg']);
									exit();
								} else {

									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/' . $_SESSION['Catprom']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/' . $_SESSION['Catprom']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/fotopromocao.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/' . $_SESSION['Catprom']['Arquivo'] . '');						
									}
									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Catprom']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Catprom']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/fotopromocao.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Catprom']['Arquivo'] . '');						
									}						
									
									if ($data['auditoriaitem'] === FALSE) {
										$data['msg'] = '';
									} else {
										$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Catprom', 'UPDATE', $data['auditoriaitem']);
										$data['msg'] = '?m=1';
									}

									redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
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
		
		if ($id) {
            $verificacao = $this->Promocao_model->get_promocao_verificacao($id);
			if($verificacao === FALSE){
				$seguir = FALSE;
			}else{
				$seguir = TRUE;
			}
		}else{
			if(!$_SESSION['Promocao']){
				$seguir = FALSE;
			}else{
				$seguir = TRUE;
			}
		}
	
		if($seguir === FALSE){
			unset($_SESSION['Promocao']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			
			$data['promocao'] = $this->input->post(array(
				'idTab_Promocao',
			), TRUE);
			
			$data['file'] = $this->input->post(array(
				'idTab_Promocao',
				'idSis_Empresa',
				'Arquivo',
			), TRUE);

			if ($id) {
				$_SESSION['Promocao'] = $data['promocao'] = $this->Promocao_model->get_promocao($id, TRUE);

				if($data['promocao'] === FALSE){
					
					unset($_SESSION['Promocao']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					exit();
					
				} else {
					$data['file']['idTab_Promocao'] = $id;
				}
			}

			if(!$data['promocao']['idTab_Promocao'] || !$_SESSION['Promocao']){
				
				unset($_SESSION['Promocao']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

				if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
					
					$data['file']['Arquivo'] = $this->basico->renomeiapromocao($_FILES['Arquivo']['name']);
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
				} else {
					$this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
				}

				$data['titulo'] = 'Alterar Foto';
				$data['form_open_path'] = 'promocao/alterarlogo';
				$data['readonly'] = 'readonly';
				$data['panel'] = 'primary';
				$data['metodo'] = 2;

				#run form validation
				if ($this->form_validation->run() === FALSE) {
					#load login view
					$this->load->view('promocao/form_logo_promocao', $data);
				} else {

					if($this->Basico_model->get_dt_validade() === FALSE){
						
						unset($_SESSION['Promocao']);
						$data['msg'] = '?m=3';
						redirect(base_url() . 'acesso' . $data['msg']);
						
					} else {
						
						$config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/';
						$config['max_size'] = 1000;
						$config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
						$config['file_name'] = $data['file']['Arquivo'];

						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('Arquivo')) {
							$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
							$this->load->view('promocao/form_logo_promocao', $data);
						} else {
						
							$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/';		
							$foto = $data['file']['Arquivo'];
							$diretorio = $dir.$foto;					
							$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/';

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
							$data['idSis_Arquivo'] = $this->Promocao_model->set_arquivo($data['file']);

							if ($data['idSis_Arquivo'] === FALSE) {
								$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
								$this->basico->erro($msg);
								$this->load->view('promocao/form_logo_promocao', $data);
							} else {

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
								
								$data['promocao']['Arquivo'] = $data['file']['Arquivo'];
								$data['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
								$data['campos'] = array_keys($data['promocao']);

								$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['promocao'], $data['campos'], $data['promocao']['idTab_Promocao'], TRUE);

								if ($data['auditoriaitem'] && $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']) === FALSE) {
									$data['msg'] = '?m=2';
									redirect(base_url() . 'promocao/form_logo_promocao/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
									exit();
								} else {

									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/' . $_SESSION['Promocao']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/' . $_SESSION['Promocao']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/fotopromocao.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/' . $_SESSION['Promocao']['Arquivo'] . '');						
									}
									if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Promocao']['Arquivo'] . ''))
										&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Promocao']['Arquivo'] . '')
										!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/fotopromocao.jpg'))){
										unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Promocao']['Arquivo'] . '');						
									}						
									
									if ($data['auditoriaitem'] === FALSE) {
										$data['msg'] = '';
									} else {
										$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'UPDATE', $data['auditoriaitem']);
										$data['msg'] = '?m=1';
									}

									redirect(base_url() . 'promocao/tela_promocao/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
									exit();
								}				
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
			unset($_SESSION['Promocao']);
			$data['msg'] = '?m=3';
			redirect(base_url() . 'acesso' . $data['msg']);
			exit();
			
		} else {
			$_SESSION['Promocao'] = $data['promocao'] = $this->Promocao_model->get_promocao($id, TRUE);

			if($data['promocao'] === FALSE){
				
				unset($_SESSION['Promocao']);
				$data['msg'] = '?m=3';
				redirect(base_url() . 'acesso' . $data['msg']);
				exit();
				
			} else {
	
				if($this->Basico_model->get_dt_validade() === FALSE){
					
					unset($_SESSION['Promocao']);
					$data['msg'] = '?m=3';
					redirect(base_url() . 'acesso' . $data['msg']);
					
				} else {
					
					$this->Promocao_model->delete_promocao($id);
					
					unset($_SESSION['Promocao']);

					$data['msg'] = '?m=1';

					redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
					exit();
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


        //$_SESSION['Promocao'] = $this->Promocao_model->get_cliente($id, TRUE);
        //$_SESSION['Promocao']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Promocao_model->list_promocao($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Promocao_model->list_promocao($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();


        $data['list'] = $this->load->view('promocao/list_promocao', $data, TRUE);
       # $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('promocao/tela_promocao', $data);

        $this->load->view('basico/footer');
    }
*/
}
