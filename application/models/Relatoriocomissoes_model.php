<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatoriocomissoes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

	public function list_porservicos($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		if($data != FALSE){
			
			$date_inicio_orca 		= ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca 			= ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega 	= ($data['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega 		= ($data['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $data['DataFim2'] . '" AND ' : FALSE;
			
			$date_inicio_pg_com 	= ($data['DataInicio7']) ? 'PRDS.DataPagoComissaoServico >= "' . $data['DataInicio7'] . '" AND ' : FALSE;
			$date_fim_pg_com 		= ($data['DataFim7']) ? 'PRDS.DataPagoComissaoServico <= "' . $data['DataFim7'] . '" AND ' : FALSE;
			
			$date_inicio_prd_entr 	= ($data['DataInicio8']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio8'] . '" AND ' : FALSE;
			$date_fim_prd_entr 		= ($data['DataFim8']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim8'] . '" AND ' : FALSE;
			
			//$Funcionario 			= ($data['Funcionario']) ? ' AND (PRDS.ProfissionalProduto_1 = ' . $data['Funcionario'] . ' OR PRDS.ProfissionalProduto_2 = ' . $data['Funcionario'] . ' OR PRDS.ProfissionalProduto_3 = ' . $data['Funcionario'] . ' OR PRDS.ProfissionalProduto_4 = ' . $data['Funcionario'] . ' )' : FALSE;
			$Funcionario 			= ($data['Funcionario']) ? ' AND (UP1.idSis_Usuario = ' . $data['Funcionario'] . ' OR UP2.idSis_Usuario = ' . $data['Funcionario'] . ' OR UP3.idSis_Usuario = ' . $data['Funcionario'] . ' OR UP4.idSis_Usuario = ' . $data['Funcionario'] . ' )' : FALSE;
			$Orcamento 				= ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
			$Cliente 				= ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
			$idApp_Cliente 			= ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
			$Fornecedor 			= ($data['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'] : FALSE;
			$idApp_Fornecedor 		= ($data['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['idApp_Fornecedor'] : FALSE;
			$Produtos 				= ($data['Produtos']) ? ' AND PRDS.idTab_Produtos_Produto = ' . $data['Produtos'] : FALSE;
			$Categoria 				= ($data['Categoria']) ? ' AND TCAT.idTab_Catprod = ' . $data['Categoria'] : FALSE;
			$TipoFinanceiro 		= ($data['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
			$idTab_TipoRD			= ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] . ' AND PRDS.idTab_TipoRD = ' . $data['idTab_TipoRD'] : FALSE;
			$AprovadoOrca 			= ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
			$QuitadoOrca 			= ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
			$ConcluidoOrca 			= ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
			$StatusComissaoServico 	= ($data['StatusComissaoServico']) ? 'PRDS.StatusComissaoServico = "' . $data['StatusComissaoServico'] . '" AND ' : FALSE;
			$ConcluidoProduto 		= ($data['ConcluidoProduto']) ? 'PRDS.ConcluidoProduto = "' . $data['ConcluidoProduto'] . '" AND ' : FALSE;
			$Modalidade 			= ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
			$FormaPagamento 		= ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
			$Tipo_Orca 				= ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
			$TipoFrete 				= ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
			$AVAP 					= ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
			$FinalizadoOrca 		= ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
			$CanceladoOrca 			= ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
			$CombinadoFrete 		= ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
			$permissao 				= ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
			$groupby 				= (1 == 1) ? 'GROUP BY PRDS.idApp_Produto' : FALSE;
			$Campo 					= (!$data['Campo']) ? 'PRDS.DataConcluidoProduto' : $data['Campo'];
			$Ordenamento 			= (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];        
		
		}else{
			
			$date_inicio_orca 		= ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca 			= ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega 	= ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega 		= ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;
			
			$date_inicio_pg_com 	= ($_SESSION['FiltroAlteraParcela']['DataInicio7']) ? 'PRDS.DataPagoComissaoServico >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio7'] . '" AND ' : FALSE;
			$date_fim_pg_com 		= ($_SESSION['FiltroAlteraParcela']['DataFim7']) ? 'PRDS.DataPagoComissaoServico <= "' . $_SESSION['FiltroAlteraParcela']['DataFim7'] . '" AND ' : FALSE;
			
			$date_inicio_prd_entr 	= ($_SESSION['FiltroAlteraParcela']['DataInicio8']) ? 'PRDS.DataConcluidoProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio8'] . '" AND ' : FALSE;
			$date_fim_prd_entr 		= ($_SESSION['FiltroAlteraParcela']['DataFim8']) ? 'PRDS.DataConcluidoProduto <= "' . $_SESSION['FiltroAlteraParcela']['DataFim8'] . '" AND ' : FALSE;
			
			//$Funcionario 			= ($_SESSION['FiltroAlteraParcela']['Funcionario']) ? ' AND (PRDS.ProfissionalProduto_1 = ' . $_SESSION['FiltroAlteraParcela']['Funcionario'] . ' OR PRDS.ProfissionalProduto_2 = ' . $_SESSION['FiltroAlteraParcela']['Funcionario'] . ' OR PRDS.ProfissionalProduto_3 = ' . $data['Funcionario'] . ' OR PRDS.ProfissionalProduto_4 = ' . $data['Funcionario'] . ' )' : FALSE;
			$Funcionario 			= ($_SESSION['FiltroAlteraParcela']['Funcionario']) ? ' AND (UP1.idSis_Usuario = ' . $_SESSION['FiltroAlteraParcela']['Funcionario'] . ' OR UP2.idSis_Usuario = ' . $_SESSION['FiltroAlteraParcela']['Funcionario'] . ' OR UP3.idSis_Usuario = ' . $data['Funcionario'] . ' OR UP4.idSis_Usuario = ' . $data['Funcionario'] . ' )' : FALSE;
			$Orcamento 				= ($_SESSION['FiltroAlteraParcela']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroAlteraParcela']['Orcamento'] : FALSE;
			$Cliente 				= ($_SESSION['FiltroAlteraParcela']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['Cliente'] : FALSE;
			$idApp_Cliente 			= ($_SESSION['FiltroAlteraParcela']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] : FALSE;
			$Fornecedor 			= ($_SESSION['FiltroAlteraParcela']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] : FALSE;
			$idApp_Fornecedor 		= ($_SESSION['FiltroAlteraParcela']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] : FALSE;
			$Produtos 				= ($_SESSION['FiltroAlteraParcela']['Produtos']) ? ' AND PRDS.idTab_Produtos_Produto = ' . $_SESSION['FiltroAlteraParcela']['Produtos'] : FALSE;
			$Categoria 				= ($_SESSION['FiltroAlteraParcela']['Categoria']) ? ' AND TCAT.idTab_Catprod = ' . $_SESSION['FiltroAlteraParcela']['Categoria'] : FALSE;
			$TipoFinanceiro 		= ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] : FALSE;
			$idTab_TipoRD			= ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . ' AND PRDS.idTab_TipoRD = ' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] : FALSE;
			$AprovadoOrca 			= ($_SESSION['FiltroAlteraParcela']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
			$QuitadoOrca 			= ($_SESSION['FiltroAlteraParcela']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
			$ConcluidoOrca 			= ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
			$StatusComissaoServico 	= ($_SESSION['FiltroAlteraParcela']['StatusComissaoServico']) ? 'PRDS.StatusComissaoServico = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoServico'] . '" AND ' : FALSE;
			$ConcluidoProduto 		= ($_SESSION['FiltroAlteraParcela']['ConcluidoProduto']) ? 'PRDS.ConcluidoProduto = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] . '" AND ' : FALSE;
			$Modalidade 			= ($_SESSION['FiltroAlteraParcela']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroAlteraParcela']['Modalidade'] . '" AND ' : FALSE;
			$FormaPagamento 		= ($_SESSION['FiltroAlteraParcela']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
			$Tipo_Orca 				= ($_SESSION['FiltroAlteraParcela']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
			$TipoFrete 				= ($_SESSION['FiltroAlteraParcela']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
			$AVAP 					= ($_SESSION['FiltroAlteraParcela']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
			$FinalizadoOrca 		= ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
			$CanceladoOrca 			= ($_SESSION['FiltroAlteraParcela']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
			$CombinadoFrete 		= ($_SESSION['FiltroAlteraParcela']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
			$permissao 				= ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
			$groupby 				= (1 == 1) ? 'GROUP BY PRDS.idApp_Produto' : FALSE;
			$Campo 					= (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'PRDS.DataConcluidoProduto' : $_SESSION['FiltroAlteraParcela']['Campo'];
			$Ordenamento 			= (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];        
				
		}
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
		$query = $this->db->query(
            'SELECT
				CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
                CP.NomeClientePet,
				CD.NomeClienteDep,
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
				TR.TipoFinanceiro,
				MD.Modalidade,
				PRDS.idApp_Produto,
				PRDS.idTab_TipoRD,
				PRDS.NomeProduto,
				PRDS.ValorProduto,
				PRDS.ValorComissaoVenda,
				PRDS.ValorComissaoServico,
				PRDS.ValorComissaoCashBack,
				PRDS.ComissaoProduto,
				PRDS.ComissaoServicoProduto,
				PRDS.ComissaoCashBackProduto,
				PRDS.QtdProduto,
				PRDS.QtdIncrementoProduto,
				(PRDS.QtdProduto * PRDS.QtdIncrementoProduto) AS QuantidadeProduto,
				PRDS.ConcluidoProduto,
				PRDS.idTab_Produtos_Produto,
				PRDS.Prod_Serv_Produto,
				PRDS.DataConcluidoProduto,
				PRDS.HoraConcluidoProduto,
				
				PRDS.StatusComissaoServico,
				PRDS.DataPagoComissaoServico,
				
				PRDS.ProfissionalProduto_1,
				PRDS.ProfissionalProduto_2,
				PRDS.ProfissionalProduto_3,
				PRDS.ProfissionalProduto_4,

				UP1.idSis_Usuario AS id_Usu_Prof_1,
				UP2.idSis_Usuario AS id_Usu_Prof_2,
				UP3.idSis_Usuario AS id_Usu_Prof_3,
				UP4.idSis_Usuario AS id_Usu_Prof_4,				
				
				AF1.idTab_Funcao AS id_Fun_Prof_1,
				AF2.idTab_Funcao AS id_Fun_Prof_2,
				AF3.idTab_Funcao AS id_Fun_Prof_3,
				AF4.idTab_Funcao AS id_Fun_Prof_4,				
				
				AF1.Comissao_Funcao AS ComProf1,
				AF2.Comissao_Funcao AS ComProf2,
				AF3.Comissao_Funcao AS ComProf3,
				AF4.Comissao_Funcao AS ComProf4,
				
				CONCAT(IFNULL(TF1.Abrev,""), " || " ,IFNULL(UP1.Nome,"")) AS NomeProf1,				
				CONCAT(IFNULL(TF2.Abrev,""), " || " ,IFNULL(UP2.Nome,"")) AS NomeProf2,				
				CONCAT(IFNULL(TF3.Abrev,""), " || " ,IFNULL(UP3.Nome,"")) AS NomeProf3,				
				CONCAT(IFNULL(TF4.Abrev,""), " || " ,IFNULL(UP4.Nome,"")) AS NomeProf4,
				
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
					LEFT JOIN App_ClientePet AS CP ON CP.idApp_Cliente = C.idApp_Cliente
					LEFT JOIN App_ClienteDep AS CD ON CD.idApp_Cliente = C.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata

					LEFT JOIN App_Funcao AS AF1 ON AF1.idApp_Funcao = PRDS.ProfissionalProduto_1
					LEFT JOIN App_Funcao AS AF2 ON AF2.idApp_Funcao = PRDS.ProfissionalProduto_2
					LEFT JOIN App_Funcao AS AF3 ON AF3.idApp_Funcao = PRDS.ProfissionalProduto_3
					LEFT JOIN App_Funcao AS AF4 ON AF4.idApp_Funcao = PRDS.ProfissionalProduto_4
					
					LEFT JOIN Tab_Funcao AS TF1 ON TF1.idTab_Funcao = AF1.idTab_Funcao
					LEFT JOIN Tab_Funcao AS TF2 ON TF2.idTab_Funcao = AF2.idTab_Funcao
					LEFT JOIN Tab_Funcao AS TF3 ON TF3.idTab_Funcao = AF3.idTab_Funcao
					LEFT JOIN Tab_Funcao AS TF4 ON TF4.idTab_Funcao = AF4.idTab_Funcao					
					
					
					LEFT JOIN Sis_Usuario AS UP1 ON UP1.idSis_Usuario = AF1.idSis_Usuario
					LEFT JOIN Sis_Usuario AS UP2 ON UP2.idSis_Usuario = AF2.idSis_Usuario
					LEFT JOIN Sis_Usuario AS UP3 ON UP3.idSis_Usuario = AF3.idSis_Usuario
					LEFT JOIN Sis_Usuario AS UP4 ON UP4.idSis_Usuario = AF4.idSis_Usuario
					
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
				
				
                ' . $date_inicio_pg_com . '
                ' . $date_fim_pg_com . '
				
				
                ' . $date_inicio_prd_entr . '
                ' . $date_fim_prd_entr . '
				' . $permissao . '
				' . $AprovadoOrca . '
				' . $QuitadoOrca . '
				' . $ConcluidoOrca . '
				' . $Modalidade . '
				' . $FormaPagamento . '
				' . $Tipo_Orca . '
				' . $TipoFrete . '
				' . $AVAP . '
				' . $FinalizadoOrca . '
				' . $CanceladoOrca . '
				' . $CombinadoFrete . '
				' . $ConcluidoProduto . '
				' . $StatusComissaoServico . '
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				PRDS.Prod_Serv_Produto = "S" AND
                PRDS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
                ' . $Orcamento . '
                ' . $Cliente . '
                ' . $Fornecedor . '
                ' . $idApp_Cliente . '
                ' . $idApp_Fornecedor . '
				' . $TipoFinanceiro . '
				' . $idTab_TipoRD . '
                ' . $Produtos . '
                ' . $Categoria . '
				' . $Funcionario . '
                ' . $groupby . '
			ORDER BY
				' . $Campo . '
                ' . $Ordenamento . '
			' . $querylimit . '
		');
		
		if($total == TRUE) {
			//return $query->num_rows();			
			
			if ($completo === FALSE) {
				return TRUE;
			} else {

				//$somafinal2=0;
				//$somacomissao2=0;
				
				foreach ($query->result() as $row) {
					
				}
				
				$query->soma2 = new stdClass();
				
				return $query;
			}
			
		}
		
        ####################################################################
        #SOMATÓRIO DAS Parcelas Recebidas
		
        $parcelasrecebidas = $this->db->query(
            'SELECT
				PRDS.idApp_Produto,
				PRDS.idTab_TipoRD,
				PRDS.NomeProduto,
				PRDS.ValorProduto,
				PRDS.ValorComissaoVenda,
				PRDS.ValorComissaoServico,
				PRDS.ValorComissaoCashBack,
				PRDS.ComissaoProduto,
				PRDS.ComissaoServicoProduto,
				PRDS.ComissaoCashBackProduto,
				PRDS.QtdProduto,
				PRDS.QtdIncrementoProduto,
				(PRDS.QtdProduto * PRDS.QtdIncrementoProduto) AS QuantidadeProduto,
				PRDS.ConcluidoProduto,
				PRDS.idTab_Produtos_Produto,
				PRDS.Prod_Serv_Produto,
				PRDS.DataConcluidoProduto,
				PRDS.HoraConcluidoProduto,
				
				PRDS.StatusComissaoServico,
				PRDS.DataPagoComissaoServico,
				
				PRDS.ProfissionalProduto_1,
				PRDS.ProfissionalProduto_2,
				PRDS.ProfissionalProduto_3,
				PRDS.ProfissionalProduto_4,


				UP1.idSis_Usuario AS id_Usu_Prof_1,
				UP2.idSis_Usuario AS id_Usu_Prof_2,
				UP3.idSis_Usuario AS id_Usu_Prof_3,
				UP4.idSis_Usuario AS id_Usu_Prof_4,					
				
				AF1.idTab_Funcao AS id_Fun_Prof_1,
				AF2.idTab_Funcao AS id_Fun_Prof_2,
				AF3.idTab_Funcao AS id_Fun_Prof_3,
				AF4.idTab_Funcao AS id_Fun_Prof_4,
				
				AF1.Comissao_Funcao AS ComProf1,
				AF2.Comissao_Funcao AS ComProf2,
				AF3.Comissao_Funcao AS ComProf3,
				AF4.Comissao_Funcao AS ComProf4,
				
				CONCAT(IFNULL(TF1.Abrev,""), " || " ,IFNULL(UP1.Nome,"")) AS NomeProf1,				
				CONCAT(IFNULL(TF2.Abrev,""), " || " ,IFNULL(UP2.Nome,"")) AS NomeProf2,				
				CONCAT(IFNULL(TF3.Abrev,""), " || " ,IFNULL(UP3.Nome,"")) AS NomeProf3,				
				CONCAT(IFNULL(TF4.Abrev,""), " || " ,IFNULL(UP4.Nome,"")) AS NomeProf4,
				
				TPRDS.idTab_Produtos,
				TPRDS.Nome_Prod,
				TCAT.idTab_Catprod,
				TCAT.Catprod
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN App_ClientePet AS CP ON CP.idApp_Cliente = C.idApp_Cliente
					LEFT JOIN App_ClienteDep AS CD ON CD.idApp_Cliente = C.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
					
					LEFT JOIN App_Funcao AS AF1 ON AF1.idApp_Funcao = PRDS.ProfissionalProduto_1
					LEFT JOIN App_Funcao AS AF2 ON AF2.idApp_Funcao = PRDS.ProfissionalProduto_2
					LEFT JOIN App_Funcao AS AF3 ON AF3.idApp_Funcao = PRDS.ProfissionalProduto_3
					LEFT JOIN App_Funcao AS AF4 ON AF4.idApp_Funcao = PRDS.ProfissionalProduto_4
					
					LEFT JOIN Tab_Funcao AS TF1 ON TF1.idTab_Funcao = AF1.idTab_Funcao
					LEFT JOIN Tab_Funcao AS TF2 ON TF2.idTab_Funcao = AF2.idTab_Funcao
					LEFT JOIN Tab_Funcao AS TF3 ON TF3.idTab_Funcao = AF3.idTab_Funcao
					LEFT JOIN Tab_Funcao AS TF4 ON TF4.idTab_Funcao = AF4.idTab_Funcao
					
					LEFT JOIN Sis_Usuario AS UP1 ON UP1.idSis_Usuario = AF1.idSis_Usuario
					LEFT JOIN Sis_Usuario AS UP2 ON UP2.idSis_Usuario = AF2.idSis_Usuario
					LEFT JOIN Sis_Usuario AS UP3 ON UP3.idSis_Usuario = AF3.idSis_Usuario
					LEFT JOIN Sis_Usuario AS UP4 ON UP4.idSis_Usuario = AF4.idSis_Usuario
					
					LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
					LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
					LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
            WHERE
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
				
				' . $date_inicio_pg_com . '
                ' . $date_fim_pg_com . '
				
                ' . $date_inicio_prd_entr . '
                ' . $date_fim_prd_entr . '			
				' . $permissao . '
				' . $AprovadoOrca . '
				' . $QuitadoOrca . '
				' . $ConcluidoOrca . '
				' . $Modalidade . '
				' . $FormaPagamento . '
				' . $Tipo_Orca . '
				' . $TipoFrete . '
				' . $AVAP . '
				' . $FinalizadoOrca . '
				' . $CanceladoOrca . '
				' . $CombinadoFrete . '
				' . $ConcluidoProduto . '
				' . $StatusComissaoServico . '
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				PRDS.Prod_Serv_Produto = "S" AND
                PRDS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				PRDS.ConcluidoProduto = "S"
				' . $Orcamento . '
                ' . $Cliente . '
                ' . $Fornecedor . '
                ' . $idApp_Cliente . '
                ' . $idApp_Fornecedor . '
				' . $TipoFinanceiro . '	
				' . $idTab_TipoRD . '
                ' . $Produtos . '
                ' . $Categoria . '
				' . $Funcionario . '
                ' . $groupby . '
			ORDER BY
				' . $Campo . '
                ' . $Ordenamento . '
			' . $querylimit . '
 				
        ');			
		$parcelasrecebidas = $parcelasrecebidas->result();		
			/*
			  echo $this->db->last_query();
			  echo "<pre>";
			  print_r($query);
			  echo "</pre>";
			  exit();
			  */

        if ($completo === FALSE) {
            return TRUE;
        } else {

             $Soma_valor_Total_Servicos=$Soma_Valor_Com_Total=$Soma_Valor_Com_Total_Prof=$somacomissaoprof=$somacomissaototal=$diferenca=$somaentregar=$somaentregue=$somaentrada=$balanco=$ant=0;
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
				$row->StatusComissaoServico = $this->basico->mascara_palavra_completa($row->StatusComissaoServico, 'NS');
				$row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
                $row->DataConcluidoProduto = $this->basico->mascara_data($row->DataConcluidoProduto, 'barras');
                $row->DataPagoComissaoServico = $this->basico->mascara_data($row->DataPagoComissaoServico, 'barras');
				
				$somaentregar += $row->QuantidadeProduto;
				#esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                
				if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }
				
				$cont_id_Fun_1=0;
				if(isset($row->id_Fun_Prof_1)){
					for ($i = 1; $i <= 4; $i++) {
						$p = 'id_Fun_Prof_'.$i;
						if($row->$p == $row->id_Fun_Prof_1){
							$cont_id_Fun_1++;
						}
					}
				}
				$row->cont_id_Fun_1 = $cont_id_Fun_1;
				
				$cont_id_Fun_2=0;
				if(isset($row->id_Fun_Prof_2)){
					for ($i = 1; $i <= 4; $i++) {
						$p = 'id_Fun_Prof_'.$i;
						if($row->$p == $row->id_Fun_Prof_2){
							$cont_id_Fun_2++;
						}
					}
				}	
				$row->cont_id_Fun_2 = $cont_id_Fun_2;				
				
				$cont_id_Fun_3=0;
				if(isset($row->id_Fun_Prof_3)){
					for ($i = 1; $i <= 4; $i++) {
						$p = 'id_Fun_Prof_'.$i;
						if($row->$p == $row->id_Fun_Prof_3){
							$cont_id_Fun_3++;
						}
					}	
				}	
				$row->cont_id_Fun_3 = $cont_id_Fun_3;				
				
				$cont_id_Fun_4=0;
				if(isset($row->id_Fun_Prof_4)){
					for ($i = 1; $i <= 4; $i++) {
						$p = 'id_Fun_Prof_'.$i;
						if($row->$p == $row->id_Fun_Prof_4){
							$cont_id_Fun_4++;
						}
					}
				}	
				$row->cont_id_Fun_4 = $cont_id_Fun_4;
				
				$contagem=0;
				for ($i = 1; $i <= 4; $i++) {
					$p = 'ProfissionalProduto_'.$i;
					if($row->$p != 0){
						$contagem++;
					}
				}
				
				$row->Contagem = $contagem;
				
				if($contagem == 0){
					$divisor = 1;
				}else{
					$divisor = $contagem;
				}
				
				$valortotalproduto = $row->QtdProduto*$row->ValorProduto;
				$Soma_valor_Total_Servicos += $valortotalproduto;
				//$comissao_total = $valortotalproduto*$row->ComissaoProduto/100;
				
				if(isset($row->ComProf1)){
					$com_Prof_1 = $row->ComProf1;
					if($cont_id_Fun_1 != 0){
						$valor_com_Prof_1 = $valortotalproduto*$com_Prof_1/$cont_id_Fun_1/100;
					}else{
						$valor_com_Prof_1 = 0.00;
					}	
				}else{
					$valor_com_Prof_1 = 0.00;
				}
				
				if(isset($row->ComProf2)){
					$com_Prof_2 = $row->ComProf2;
					if($cont_id_Fun_2 != 0){
						$valor_com_Prof_2 = $valortotalproduto*$com_Prof_2/$cont_id_Fun_2/100;
					}else{
						$valor_com_Prof_2 = 0.00;
					}	
				}else{
					$valor_com_Prof_2 = 0.00;
				}
				
				if(isset($row->ComProf3)){
					$com_Prof_3 = $row->ComProf3;
					if($cont_id_Fun_3 != 0){
						$valor_com_Prof_3 = $valortotalproduto*$com_Prof_3/$cont_id_Fun_3/100;
					}else{
						$valor_com_Prof_3 = 0.00;
					}	
				}else{
					$valor_com_Prof_3 = 0.00;
				}
								
				if(isset($row->ComProf4)){
					$com_Prof_4 = $row->ComProf4;
					if($cont_id_Fun_4 != 0){
						$valor_com_Prof_4 = $valortotalproduto*$com_Prof_4/$cont_id_Fun_4/100;
					}else{
						$valor_com_Prof_4 = 0.00;
					}	
				}else{
					$valor_com_Prof_4 = 0.00;
				}
				
				$Valor_Com_Total = ($valor_com_Prof_1 + $valor_com_Prof_2 + $valor_com_Prof_3 + $valor_com_Prof_4);
				$Soma_Valor_Com_Total += $Valor_Com_Total;				
				
				if(isset($data['Funcionario']) && $data['Funcionario'] !=0){
	
					if($row->id_Usu_Prof_1 == $data['Funcionario']){
						$valor_com_filtro_Prof_1 = $valor_com_Prof_1;	
					}else{
						$valor_com_filtro_Prof_1 = 0.00;	
					}
					if($row->id_Usu_Prof_2 == $data['Funcionario']){
						$valor_com_filtro_Prof_2 = $valor_com_Prof_2;	
					}else{
						$valor_com_filtro_Prof_2 = 0.00;	
					}
					if($row->id_Usu_Prof_3 == $data['Funcionario']){
						$valor_com_filtro_Prof_3 = $valor_com_Prof_3;	
					}else{
						$valor_com_filtro_Prof_3 = 0.00;	
					}
					if($row->id_Usu_Prof_4 == $data['Funcionario']){
						$valor_com_filtro_Prof_4 = $valor_com_Prof_4;	
					}else{
						$valor_com_filtro_Prof_4 = 0.00;	
					}
				}else{
					$valor_com_filtro_Prof_1 = $valor_com_Prof_1;
					$valor_com_filtro_Prof_2 = $valor_com_Prof_2;
					$valor_com_filtro_Prof_3 = $valor_com_Prof_3;
					$valor_com_filtro_Prof_4 = $valor_com_Prof_4;	
				}
				
				$Valor_Com_Total_Prof = ($valor_com_filtro_Prof_1 + $valor_com_filtro_Prof_2 + $valor_com_filtro_Prof_3 + $valor_com_filtro_Prof_4);
				$Soma_Valor_Com_Total_Prof += $Valor_Com_Total_Prof;
				
				$row->valor_com_Prof_1 = number_format($valor_com_Prof_1, 2, ',', '.');
				$row->valor_com_Prof_2 = number_format($valor_com_Prof_2, 2, ',', '.');
				$row->valor_com_Prof_3 = number_format($valor_com_Prof_3, 2, ',', '.');
				$row->valor_com_Prof_4 = number_format($valor_com_Prof_4, 2, ',', '.');
				$row->Valor_Com_Total = number_format($Valor_Com_Total, 2, ',', '.');	
				$row->Valor_Com_Total_Prof = number_format($Valor_Com_Total_Prof, 2, ',', '.');						
				
				$comissao_total = $row->ValorComissaoServico;
				$pro_prof = $comissao_total/$divisor;
				$somacomissaototal 	+= $comissao_total;
				$somacomissaoprof	+= $pro_prof;
				
				$row->ValorTotalProduto = number_format($valortotalproduto, 2, ',', '.');
				$row->ValorProduto = number_format($row->ValorProduto, 2, ',', '.');
				$row->ComissaoServicoProduto = number_format($row->ComissaoServicoProduto, 2, ',', '.');
				$row->ComissaoTotal = number_format($comissao_total, 2, ',', '.');
				$row->ComissaoProf = number_format($pro_prof, 2, ',', '.');
                
				
				$row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');			
				
				if($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}elseif($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}else{
					$row->Tipo_Orca = "Outros";
				}				
				/*
				  echo $this->db->last_query();
				  echo "<pre>";
				  print_r($somaentrada);          
				  echo "</pre>";
				  exit();
				*/	
		  
            }
			
            foreach ($parcelasrecebidas as $row) {
				$somaentregue += $row->QuantidadeProduto;
            }			
			$diferenca =  $somaentregar - $somaentregue;
			
			/*
			echo $this->db->last_query();
			echo "<pre>";
			print_r($balanco);
			echo "</pre>";
			exit();			
			*/
			
            $query->soma = new stdClass();
			//$query->soma->contagem = $contagem;
            $query->soma->somacomissaototal = number_format($somacomissaototal, 2, ',', '.');
            $query->soma->somacomissaoprof = number_format($somacomissaoprof, 2, ',', '.');
            $query->soma->diferenca = $diferenca;
            $query->soma->somaentregar = $somaentregar;
            $query->soma->somaentregue = $somaentregue;
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->Soma_Valor_Com_Total = number_format($Soma_Valor_Com_Total, 2, ',', '.');
            $query->soma->Soma_Valor_Com_Total_Prof = number_format($Soma_Valor_Com_Total_Prof, 2, ',', '.');
            $query->soma->Soma_valor_Total_Servicos = number_format($Soma_valor_Total_Servicos, 2, ',', '.');
			
            return $query;
        }

    }

    public function select_funcao() {

        $query = $this->db->query('
            SELECT
				AF.idApp_Funcao,
				CONCAT(IFNULL(TF.Abrev,""), " || ", IFNULL(U.Nome,"")) AS Nome
            FROM
                App_Funcao AS AF
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = AF.idSis_Usuario
					LEFT JOIN Tab_Funcao AS TF ON TF.idTab_Funcao = AF.idTab_Funcao
            WHERE
				AF.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				U.Inativo = "0" AND
				U.Servicos = "S"  
			
			ORDER BY 
				TF.Abrev ASC,
				U.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Funcao] = $row->Nome;
        }

        return $array;
    }
	
    public function select_funcionario() {

        $query = $this->db->query('
            SELECT
                F.idSis_Usuario,
                F.Nome
            FROM
                Sis_Usuario AS F
            WHERE
                F.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                F.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->Nome;
        }

        return $array;
    }
	
	
}
