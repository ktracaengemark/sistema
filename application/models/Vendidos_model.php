<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendidos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

	public function list_vendidos($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($data['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($data['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $data['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_par = ($data['DataInicio4']) ? 'PR.DataVencimento >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_par = ($data['DataFim4']) ? 'PR.DataVencimento <= "' . $data['DataFim4'] . '" AND ' : FALSE;

		$date_inicio_prd_entr = ($data['DataInicio8']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio8'] . '" AND ' : FALSE;
		$date_fim_prd_entr = ($data['DataFim8']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim8'] . '" AND ' : FALSE;

		$hora_inicio_entrega_prd = ($data['HoraInicio8']) ? 'PRDS.HoraConcluidoProduto >= "' . $data['HoraInicio8'] . '" AND ' : FALSE;
		$hora_fim_entrega_prd = ($data['HoraFim8']) ? 'PRDS.HoraConcluidoProduto <= "' . $data['HoraFim8'] . '" AND ' : FALSE;
					
		$Orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$Cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
		$idApp_Cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
		$Produto = ($data['Produto']) ? ' AND PRDS.idTab_Produtos_Produto = ' . $data['Produto'] : FALSE;
		$Categoria = ($data['Categoria']) ? ' AND TCAT.idTab_Catprod = ' . $data['Categoria'] : FALSE;
		$TipoFinanceiro = ($data['TipoFinanceiro']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$idTab_TipoRD = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] . ' AND PRDS.idTab_TipoRD = ' . $data['idTab_TipoRD'] : FALSE;
		$Campo = (!$data['Campo']) ? 'TCAT.Catprod' : $data['Campo'];
		$Ordenamento = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
		$filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro17 = ($data['ConcluidoProduto']) ? 'PRDS.ConcluidoProduto = "' . $data['ConcluidoProduto'] . '" AND ' : FALSE;
		$filtro21 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro18 = ($data['Prod_Serv_Produto']) ? 'PRDS.Prod_Serv_Produto = "' . $data['Prod_Serv_Produto'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		
		$query4 = ($data['idApp_ClientePet'] && isset($data['idApp_ClientePet'])) ? 'AND OT.idApp_ClientePet = ' . $data['idApp_ClientePet'] . '  ' : FALSE;
		$query42 = ($data['idApp_ClientePet2'] && isset($data['idApp_ClientePet2'])) ? 'AND OT.idApp_ClientePet = ' . $data['idApp_ClientePet2'] . '  ' : FALSE;
		$query5 = ($data['idApp_ClienteDep'] && isset($data['idApp_ClienteDep'])) ? 'AND OT.idApp_ClienteDep = ' . $data['idApp_ClienteDep'] . '  ' : FALSE;
		$query52 = ($data['idApp_ClienteDep2'] && isset($data['idApp_ClienteDep2'])) ? 'AND OT.idApp_ClienteDep = ' . $data['idApp_ClienteDep2'] . '  ' : FALSE;			
		
		$produtos = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['Produtos'] != "0") ? 'PRDS.idSis_Empresa ' . $data['Produtos'] . '  AND' : FALSE;	
		$parcelas = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['Parcelas'] != "0") ? 'PR.idSis_Empresa ' . $data['Parcelas'] . '  AND' : FALSE;							
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		//$groupby = (1 == 1) ? 'GROUP BY PRDS.idApp_Produto' : FALSE;
		$groupby = ($data['Agrupar'] != "0") ? 'GROUP BY ' . $data['Agrupar'] . '' : 'GROUP BY PRDS.idApp_Produto';

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		
		if($completo == FALSE){
			$complemento = FALSE;
		}else{
			$complemento = ' AND OT.CanceladoOrca = "N" AND PR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND PR.Quitado = "N"';
		}

		$filtro_base = '
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_prd_entr . '
                ' . $date_fim_prd_entr . '
                ' . $hora_inicio_entrega_prd . '
                ' . $hora_fim_entrega_prd . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_par . '
                ' . $date_fim_vnc_par . '
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro5 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				' . $filtro10 . '
				' . $filtro11 . '
				' . $filtro13 . '
				' . $filtro17 . '
				' . $filtro18 . '
				' . $filtro21 . '
				' . $produtos . '
				' . $parcelas . '
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_TipoRD = 2
                ' . $Orcamento . '
                ' . $Cliente . '
                ' . $idApp_Cliente . '
				' . $TipoFinanceiro . '
                ' . $Produto . '
                ' . $Categoria . '
				' . $query4 . '
				' . $query42 . '
				' . $query5 . '
				' . $query52 . '
			' . $groupby . '
			ORDER BY
				' . $Campo . '
				' . $Ordenamento . '
			' . $querylimit . '
		';


        ####################################################################
        #Contagem Dos Produtos e Soma total Para todas as listas e baixas
		if($total == TRUE && $date == FALSE) {
			
			$query = $this->db->query('
				SELECT
					OT.idApp_OrcaTrata
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_ClientePet AS CPT ON CPT.idApp_ClientePet = OT.idApp_ClientePet
						LEFT JOIN App_ClienteDep AS CDP ON CDP.idApp_ClienteDep = OT.idApp_ClienteDep
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
						LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
						LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
				WHERE
					' . $filtro_base . '
			');
		
			$count = $query->num_rows();
			
			if(!isset($count)){
				return FALSE;
			}else{
				if($count >= 15001){
					return FALSE;
				}else{
					//return $query->num_rows();
					return $query;
				}
			}
		}
		
        ####################################################################
        # Relatório/Excel Campos para exibição Dos Produtos
		if($total == FALSE && $date == FALSE) {	
			
			$query = $this->db->query(
				'SELECT
					CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,""), " - " ,IFNULL(C.Telefone,""), " - " ,IFNULL(C.Telefone2,""), " - " ,IFNULL(C.Telefone3,"") ) AS NomeCliente,
					C.CelularCliente,
					OT.idApp_OrcaTrata,
					OT.Tipo_Orca,
					OT.idSis_Usuario,
					OT.idTab_TipoRD,
					OT.AprovadoOrca,
					OT.CombinadoFrete,
					OT.ObsOrca,
					CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
					OT.DataOrca,
					OT.DataEntradaOrca,
					OT.DataEntregaOrca,
					OT.DataVencimentoOrca,
					OT.ValorEntradaOrca,
					OT.QuitadoOrca,
					OT.ConcluidoOrca,
					OT.FinalizadoOrca,
					OT.CanceladoOrca,
					OT.Modalidade,
					OT.AVAP,
					OT.TipoFrete,
					CPT.NomeClientePet,
					CDP.NomeClienteDep,
					TR.TipoFinanceiro,
					PRDS.idApp_Produto,
					PRDS.idTab_TipoRD,
					PRDS.NomeProduto,
					PRDS.ValorProduto,
					PRDS.QtdProduto,
					PRDS.QtdIncrementoProduto,
					(PRDS.QtdProduto * PRDS.QtdIncrementoProduto) AS QuantidadeProduto,
					PRDS.ConcluidoProduto,
					PRDS.idTab_Produtos_Produto,
					PRDS.Prod_Serv_Produto,
					PRDS.DataConcluidoProduto,
					PRDS.HoraConcluidoProduto,
					TPRDS.idTab_Produtos,
					TPRDS.Nome_Prod,
					TCAT.idTab_Catprod,
					TCAT.Catprod,
					TFP.FormaPag
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_ClientePet AS CPT ON CPT.idApp_ClientePet = OT.idApp_ClientePet
						LEFT JOIN App_ClienteDep AS CDP ON CDP.idApp_ClienteDep = OT.idApp_ClienteDep
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
						LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
						LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				WHERE
					' . $filtro_base . ''
			);
	
			/*
			  echo $this->db->last_query();
			  echo "<pre>";
			  print_r($query);
			  echo "</pre>";
			  exit();
			  */

            $somaentregar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
                $row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
                $row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
				$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
				$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
				$row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
                $row->DataConcluidoProduto = $this->basico->mascara_data($row->DataConcluidoProduto, 'barras');
				$row->ValorProduto = number_format($row->ValorProduto, 2, ',', '.');

				$somaentregar += $row->QuantidadeProduto;

				$row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');			
				
				if($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}elseif($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}else{
					$row->Tipo_Orca = "Outros";
				}

				if($row->Modalidade == "P"){
					$row->Modalidade = "Dividido";
				}elseif($row->Modalidade == "M"){
					$row->Modalidade = "Mensal";
				}else{
					$row->Modalidade = "Outros";
				}
				
				if($row->AVAP == "V"){
					$row->AVAP = "NaLoja";
				}elseif($row->AVAP == "O"){
					$row->AVAP = "OnLine";
				}elseif($row->AVAP == "P"){
					$row->AVAP = "NaEntr";
				}else{
					$row->AVAP = "Outros";
				}
				
				if($row->TipoFrete == 1){
					$row->TipoFrete = "Retirar/NaLoja";
				}elseif($row->TipoFrete == 2){
					$row->TipoFrete = "EmCasa/PelaLoja";
				}elseif($row->TipoFrete == 3){
					$row->TipoFrete = "EmCasa/PeloCorreio";
				}else{
					$row->TipoFrete = "Outros";
				}
		  
            }

            $query->soma = new stdClass();
            $query->soma->somaentregar = $somaentregar;
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			
            return $query;
		}

    }

    public function get_alterarproduto($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		$date_inicio_orca = ($_SESSION['Filtro_Vendidos']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['Filtro_Vendidos']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['Filtro_Vendidos']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['Filtro_Vendidos']['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($_SESSION['Filtro_Vendidos']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['Filtro_Vendidos']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['Filtro_Vendidos']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['Filtro_Vendidos']['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_vnc = ($_SESSION['Filtro_Vendidos']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['Filtro_Vendidos']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['Filtro_Vendidos']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['Filtro_Vendidos']['DataFim3'] . '" AND ' : FALSE;
			
		$date_inicio_vnc_par = ($_SESSION['Filtro_Vendidos']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['Filtro_Vendidos']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_par = ($_SESSION['Filtro_Vendidos']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['Filtro_Vendidos']['DataFim4'] . '" AND ' : FALSE;

		$date_inicio_prd_entr = ($_SESSION['Filtro_Vendidos']['DataInicio8']) ? 'PRDS.DataConcluidoProduto >= "' . $_SESSION['Filtro_Vendidos']['DataInicio8'] . '" AND ' : FALSE;
		$date_fim_prd_entr = ($_SESSION['Filtro_Vendidos']['DataFim8']) ? 'PRDS.DataConcluidoProduto <= "' . $_SESSION['Filtro_Vendidos']['DataFim8'] . '" AND ' : FALSE;

		$hora_inicio_entrega_prd = ($_SESSION['Filtro_Vendidos']['HoraInicio8']) ? 'PRDS.HoraConcluidoProduto >= "' . $_SESSION['Filtro_Vendidos']['HoraInicio8'] . '" AND ' : FALSE;
		$hora_fim_entrega_prd = ($_SESSION['Filtro_Vendidos']['HoraFim8']) ? 'PRDS.HoraConcluidoProduto <= "' . $_SESSION['Filtro_Vendidos']['HoraFim8'] . '" AND ' : FALSE;
					
		$filtro['Orcamento'] = ($_SESSION['Filtro_Vendidos']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['Filtro_Vendidos']['Orcamento'] : FALSE;
		$filtro['Cliente'] = ($_SESSION['Filtro_Vendidos']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['Filtro_Vendidos']['Cliente'] : FALSE;
		$filtro['idApp_Cliente'] = ($_SESSION['Filtro_Vendidos']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['Filtro_Vendidos']['idApp_Cliente'] : FALSE;
		$filtro['Fornecedor'] = ($_SESSION['Filtro_Vendidos']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['Filtro_Vendidos']['Fornecedor'] : FALSE;
		$filtro['idApp_Fornecedor'] = ($_SESSION['Filtro_Vendidos']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['Filtro_Vendidos']['idApp_Fornecedor'] : FALSE;
		$filtro['Produto'] = ($_SESSION['Filtro_Vendidos']['Produto']) ? ' AND PRDS.idTab_Produtos_Produto = ' . $_SESSION['Filtro_Vendidos']['Produto'] : FALSE;
		$filtro['Categoria'] = ($_SESSION['Filtro_Vendidos']['Categoria']) ? ' AND TCAT.idTab_Catprod = ' . $_SESSION['Filtro_Vendidos']['Categoria'] : FALSE;
		$filtro['TipoFinanceiro'] = ($_SESSION['Filtro_Vendidos']['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['Filtro_Vendidos']['TipoFinanceiro'] : FALSE;
		$filtro['idTab_TipoRD'] = ($_SESSION['Filtro_Vendidos']['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $_SESSION['Filtro_Vendidos']['idTab_TipoRD'] . ' AND PRDS.idTab_TipoRD = ' . $_SESSION['Filtro_Vendidos']['idTab_TipoRD'] : FALSE;
		$filtro['Campo'] = (!$_SESSION['Filtro_Vendidos']['Campo']) ? 'TCAT.Catprod' : $_SESSION['Filtro_Vendidos']['Campo'];
		$filtro['Ordenamento'] = (!$_SESSION['Filtro_Vendidos']['Ordenamento']) ? 'ASC' : $_SESSION['Filtro_Vendidos']['Ordenamento'];
		$filtro1 = ($_SESSION['Filtro_Vendidos']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['Filtro_Vendidos']['AprovadoOrca'] . '" AND ' : FALSE;
		$filtro2 = ($_SESSION['Filtro_Vendidos']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['Filtro_Vendidos']['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($_SESSION['Filtro_Vendidos']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['Filtro_Vendidos']['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro17 = ($_SESSION['Filtro_Vendidos']['ConcluidoProduto']) ? 'PRDS.ConcluidoProduto = "' . $_SESSION['Filtro_Vendidos']['ConcluidoProduto'] . '" AND ' : FALSE;
		$filtro18 = ($_SESSION['Filtro_Vendidos']['Prod_Serv_Produto']) ? 'PRDS.Prod_Serv_Produto = "' . $_SESSION['Filtro_Vendidos']['Prod_Serv_Produto'] . '" AND ' : FALSE;
		$filtro5 = ($_SESSION['Filtro_Vendidos']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['Filtro_Vendidos']['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($_SESSION['Filtro_Vendidos']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['Filtro_Vendidos']['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($_SESSION['Filtro_Vendidos']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['Filtro_Vendidos']['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($_SESSION['Filtro_Vendidos']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['Filtro_Vendidos']['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($_SESSION['Filtro_Vendidos']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['Filtro_Vendidos']['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($_SESSION['Filtro_Vendidos']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['Filtro_Vendidos']['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($_SESSION['Filtro_Vendidos']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['Filtro_Vendidos']['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($_SESSION['Filtro_Vendidos']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['Filtro_Vendidos']['CombinadoFrete'] . '" AND ' : FALSE;
		
		$query4 = ($_SESSION['Filtro_Vendidos']['idApp_ClientePet'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClientePet'])) ? 'AND OT.idApp_ClientePet = ' . $_SESSION['Filtro_Vendidos']['idApp_ClientePet'] . '  ' : FALSE;
		$query42 = ($_SESSION['Filtro_Vendidos']['idApp_ClientePet2'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClientePet2'])) ? 'AND OT.idApp_ClientePet = ' . $_SESSION['Filtro_Vendidos']['idApp_ClientePet2'] . '  ' : FALSE;
		$query5 = ($_SESSION['Filtro_Vendidos']['idApp_ClienteDep'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClienteDep'])) ? 'AND OT.idApp_ClienteDep = ' . $_SESSION['Filtro_Vendidos']['idApp_ClienteDep'] . '  ' : FALSE;
		$query52 = ($_SESSION['Filtro_Vendidos']['idApp_ClienteDep2'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClienteDep2'])) ? 'AND OT.idApp_ClienteDep = ' . $_SESSION['Filtro_Vendidos']['idApp_ClienteDep2'] . '  ' : FALSE;			
			
									
		$produtos = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Filtro_Vendidos']['Produtos'] != "0") ? 'PRDS.idSis_Empresa ' . $_SESSION['Filtro_Vendidos']['Produtos'] . ' AND' : FALSE;
		$parcelas = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Filtro_Vendidos']['Parcelas'] != "0") ? 'PR.idSis_Empresa ' . $_SESSION['Filtro_Vendidos']['Parcelas'] . ' AND' : FALSE;

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$groupby = (1 == 1) ? 'GROUP BY PRDS.idApp_Produto' : FALSE;		
		
        if ($limit){
			$querylimit = 'LIMIT ' . $start . ', ' . $limit;
		}else{
			$querylimit = '';
		}
					
		$query = $this->db->query('
            SELECT
				CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
                C.idApp_Cliente,
				C.CelularCliente,
				CONCAT(IFNULL(F.NomeFornecedor,"")) AS NomeFornecedor,
				F.idApp_Fornecedor,
				F.CelularFornecedor,
				OT.idApp_OrcaTrata,
				OT.Tipo_Orca,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
                OT.CombinadoFrete,
				OT.ObsOrca,
				OT.Consideracoes,
				CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.DataEntregaOrca,
                OT.DataVencimentoOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.Modalidade,
				CPT.NomeClientePet,
				CDP.NomeClienteDep,
				TR.TipoFinanceiro,
				MD.Modalidade,
				PRDS.*,
				(PRDS.QtdProduto * PRDS.QtdIncrementoProduto) AS QuantidadeProduto,
				TPRDS.idTab_Produtos,
				TPRDS.Nome_Prod,
				TCAT.idTab_Catprod,
				TCAT.Catprod,
				TAV.AVAP,
				TTF.TipoFrete,
				TFP.FormaPag
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN App_ClientePet AS CPT ON CPT.idApp_ClientePet = OT.idApp_ClientePet
					LEFT JOIN App_ClienteDep AS CDP ON CDP.idApp_ClienteDep = OT.idApp_ClienteDep
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
					LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
					LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
					LEFT JOIN Tab_AVAP AS TAV ON TAV.Abrev2 = OT.AVAP
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
            WHERE
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_prd_entr . '
                ' . $date_fim_prd_entr . '
                ' . $hora_inicio_entrega_prd . '
                ' . $hora_fim_entrega_prd . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_par . '
                ' . $date_fim_vnc_par . '
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro5 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				' . $filtro10 . '
				' . $filtro11 . '
				' . $filtro13 . '
				' . $filtro17 . '
				' . $filtro18 . '
				' . $produtos . '
				' . $parcelas . '
                OT.idSis_Empresa = ' . $data . ' AND
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.CanceladoOrca = "N" AND
                PRDS.idSis_Empresa = ' . $data . ' 
                ' . $filtro['Orcamento'] . '
                ' . $filtro['Cliente'] . '
                ' . $filtro['Fornecedor'] . '
                ' . $filtro['idApp_Cliente'] . '
                ' . $filtro['idApp_Fornecedor'] . '
				' . $filtro['TipoFinanceiro'] . '
				' . $filtro['idTab_TipoRD'] . '
                ' . $filtro['Produto'] . '
                ' . $filtro['Categoria'] . '
				' . $query4 . '
				' . $query42 . '
				' . $query5 . '
				' . $query52 . '
			' . $groupby . '
			ORDER BY
				' . $filtro['Campo'] . '
				' . $filtro['Ordenamento'] . '
			' . $querylimit . '
		');

		if($total == TRUE) {
			return $query->num_rows();
		}

		foreach ($query->result() as $row) {
			$row->NomeCliente = (strlen($row->NomeCliente) > 12) ? substr($row->NomeCliente, 0, 12) : $row->NomeCliente;
			$row->NomeClientePet = (strlen($row->NomeClientePet) > 12) ? substr($row->NomeClientePet, 0, 12) : $row->NomeClientePet;
			$row->NomeClienteDep = (strlen($row->NomeClienteDep) > 12) ? substr($row->NomeClienteDep, 0, 12) : $row->NomeClienteDep;
		}
						
        $query = $query->result_array();

        return $query;
    }	
	
}