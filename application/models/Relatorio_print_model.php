<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_print_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function get_orcatrata_cliente($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;
			
		$date_inicio_entrega_prd = ($_SESSION['FiltroAlteraParcela']['DataInicio5']) ? 'PRDS.DataConcluidoProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio5'] . '" AND ' : FALSE;
		$date_fim_entrega_prd = ($_SESSION['FiltroAlteraParcela']['DataFim5']) ? 'PRDS.DataConcluidoProduto <= "' . $_SESSION['FiltroAlteraParcela']['DataFim5'] . '" AND ' : FALSE;

		$hora_inicio_entrega_prd = ($_SESSION['FiltroAlteraParcela']['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $_SESSION['FiltroAlteraParcela']['HoraInicio5'] . '" AND ' : FALSE;
		$hora_fim_entrega_prd = ($_SESSION['FiltroAlteraParcela']['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $_SESSION['FiltroAlteraParcela']['HoraFim5'] . '" AND ' : FALSE;
					
		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		if(isset($_SESSION['FiltroAlteraParcela']['Quitado']) && $_SESSION['FiltroAlteraParcela']['Quitado'] == "S"){
			$dataref = 'PR.DataPago';
		}else{
			$dataref = 'PR.DataVencimento';
		}
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? ''.$dataref.' >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? ''.$dataref.' <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;
			
		if($_SESSION['FiltroAlteraParcela']['nome']){
			if($_SESSION['FiltroAlteraParcela']['nome'] == "Cliente"){
				$cadastro = "C.DataCadastroCliente";
				$aniversario = "C.DataNascimento";
			}elseif($_SESSION['FiltroAlteraParcela']['nome'] == "Fornecedor"){
				$cadastro = "F.DataCadastroFornecedor";
				$aniversario = "F.DataNascimento";
			}
		}else{
			echo "N�o existe data de cadastro";
		}
			
		$date_inicio_cadastro = ($_SESSION['FiltroAlteraParcela']['DataInicio6']) ? '' . $cadastro . ' >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio6'] . '" AND ' : FALSE;
		$date_fim_cadastro = ($_SESSION['FiltroAlteraParcela']['DataFim6']) ? '' . $cadastro . ' <= "' . $_SESSION['FiltroAlteraParcela']['DataFim6'] . '" AND ' : FALSE;
			
		$DiaAniv = ($_SESSION['FiltroAlteraParcela']['DiaAniv']) ? ' AND DAY(' . $aniversario . ') = ' . $_SESSION['FiltroAlteraParcela']['DiaAniv'] : FALSE;
		$MesAniv = ($_SESSION['FiltroAlteraParcela']['MesAniv']) ? ' AND MONTH(' . $aniversario . ') = ' . $_SESSION['FiltroAlteraParcela']['MesAniv'] : FALSE;
		$AnoAniv = ($_SESSION['FiltroAlteraParcela']['AnoAniv']) ? ' AND YEAR(' . $aniversario . ') = ' . $_SESSION['FiltroAlteraParcela']['AnoAniv'] : FALSE;			

		if(isset($_SESSION['FiltroAlteraParcela']['Associado'])){
			if($_SESSION['FiltroAlteraParcela']['Associado'] == 0){
				$associado = ' AND OT.Associado = 0 ';
			}else{
				$associado = ' AND OT.Associado != 0 ';
			}
		}else{
			$associado = FALSE;
		}
		
		if(isset($_SESSION['FiltroAlteraParcela']['Vendedor'])){
			if($_SESSION['FiltroAlteraParcela']['Vendedor'] == 0){
				$vendedor = ' AND OT.idSis_Usuario = 0 ';
			}else{
				$vendedor = ' AND OT.idSis_Usuario != 0 ';
			}
		}else{
			$vendedor = FALSE;
		}			
					
		$permissao30 = ($_SESSION['FiltroAlteraParcela']['Orcamento'] != "" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '" AND ' : FALSE;
		$permissao31 = ($_SESSION['FiltroAlteraParcela']['Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['Cliente'] . '" AND ' : FALSE;
		$permissao36 = ($_SESSION['FiltroAlteraParcela']['Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] . '" AND ' : FALSE;
		$permissao37 = ($_SESSION['FiltroAlteraParcela']['idApp_Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] . '" AND ' : FALSE;
		$permissao38 = ($_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] . '" AND ' : FALSE;
		$permissao13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete'] != "0" ) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		//$permissao4 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] != "0" ) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$permissao11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca'] != "0" ) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
		
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca'] != "0" ) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao33 = ($_SESSION['FiltroAlteraParcela']['AVAP'] != "0" ) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$permissao34 = ($_SESSION['FiltroAlteraParcela']['TipoFrete'] != "0" ) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$permissao32 = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] != "0" ) ? 'OT.TipoFinanceiro = "' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] . '" AND ' : FALSE;
		$permissao35 = ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] != "" ) ? 'OT.idTab_TipoRD = "' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . '" AND' : FALSE;
		
		//$permissao26 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		//$permissao27 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao25 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		$permissao60 = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'OT.idApp_OrcaTrata' : $_SESSION['FiltroAlteraParcela']['Campo'];
        $permissao61 = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
		
		$produtos = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['Produtos'] != "0") ? 'PRDS.idSis_Empresa ' . $_SESSION['FiltroAlteraParcela']['Produtos'] . ' AND' : FALSE;
		$parcelas = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['Parcelas'] != "0") ? 'PR.idSis_Empresa ' . $_SESSION['FiltroAlteraParcela']['Parcelas'] . ' AND' : FALSE;
	
		$nome = $_SESSION['FiltroAlteraParcela']['nome'];
		/*
		if($_SESSION['FiltroAlteraParcela']['Quitado']){
			if($_SESSION['FiltroAlteraParcela']['Quitado'] == "N"){
				$ref_data = 'DataVencimento';
			}elseif($_SESSION['FiltroAlteraParcela']['Quitado'] == "S"){	
				$ref_data = 'DataPago';
			}
		}else{
			$ref_data = 'DataVencimento';
		}
		*/
		$ref_data = 'DataVencimentoOrca';
		$agrupar = $_SESSION['FiltroAlteraParcela']['Agrupar'];
		
		$groupby = ($agrupar != "0") ? 'GROUP BY OT.' . $agrupar . '' : FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] != 5){
			if($_SESSION['FiltroAlteraParcela']['Ultimo'] != 0){	
				if($_SESSION['FiltroAlteraParcela']['Ultimo'] == 1){	
					$ultimopedido1 = 'LEFT JOIN App_OrcaTrata AS OT2 ON (OT.idApp_' . $nome . ' = OT2.idApp_' . $nome . ' AND OT.idApp_OrcaTrata < OT2.idApp_OrcaTrata)';
					$ultimopedido2 = 'AND OT2.idApp_OrcaTrata IS NULL';
				}
			}else{
				$ultimopedido1 = FALSE;
				$ultimopedido2 = FALSE;
			}	
		}else{
			$ultimopedido1 = FALSE;
			$ultimopedido2 = FALSE;
		}		
		/*
		echo '<br>';
        echo "<pre>";
        print_r($nome);
		echo '<br>';
        print_r($agrupar);
		echo '<br>';
        print_r($groupby);
		echo '<br>';
        print_r($ref_data);
		echo '<br>';
        print_r($_SESSION['FiltroAlteraParcela']['Ultimo']);
		echo '<br>';
        print_r($ultimopedido1);
		echo '<br>';
        print_r($ultimopedido2);
        echo "</pre>";
        //exit ();		
		*/

        if ($limit){
			$querylimit = 'LIMIT ' . $start . ', ' . $limit;
		}else{
			$querylimit = '';
		}
		
		$query = $this->db->query(
            'SELECT
				C.NomeCliente,
				C.DataCadastroCliente,
				C.DataNascimento,
				C.CelularCliente,
				C.Telefone,
				C.Telefone2,
				C.Telefone3,
				F.NomeFornecedor,
				F.DataCadastroFornecedor,
				F.DataNascimento,
				OT.idSis_Empresa,
				OT.idApp_OrcaTrata,
				OT.CombinadoFrete,
				OT.AprovadoOrca,
				OT.ConcluidoOrca,
				OT.QuitadoOrca,
				OT.TipoFrete,
				OT.AVAP,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.DataOrca,
				OT.DataPrazo,
				OT.DataConclusao,
				OT.DataQuitado,				
				OT.DataRetorno,
				OT.DataEntradaOrca,
				OT.DataEntregaOrca,
				OT.idApp_Cliente,
				OT.idApp_Fornecedor,
				OT.ValorOrca,
				OT.ValorTotalOrca,
				OT.ValorDev,
				OT.ValorDinheiro,
				OT.ValorTroco,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.QtdParcelasOrca,
				OT.DataVencimentoOrca,
				OT.idSis_Usuario,
				OT.ObsOrca,
				OT.Consideracoes,
				OT.Descricao,
				OT.TipoFinanceiro,
				OT.Tipo_Orca,
				OT.NomeRec,
				OT.TelefoneRec,
				OT.ParentescoRec,
				FP.FormaPag,				
				EF.NomeEmpresa,
				TAV.AVAP,
				TAV.Abrev2,
				TP.TipoFinanceiro
            FROM 
				App_OrcaTrata AS OT
				LEFT JOIN Sis_Empresa AS EF ON EF.idSis_Empresa = OT.idSis_Empresa
				LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TP ON TP.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_AVAP AS TAV ON TAV.Abrev2 = OT.AVAP
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
				LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
				LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
				LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
				' . $ultimopedido1 . '
            WHERE
            	' . $permissao . '
            	' . $permissao_orcam . '		
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao10 . '
				' . $permissao11 . '
				' . $permissao13 . '
				' . $permissao30 . '
				' . $permissao31 . '
				' . $permissao32 . '
				' . $permissao33 . '
				' . $permissao34 . '
				' . $permissao35 . '
				' . $permissao36 . '
				' . $permissao37 . '
				' . $permissao38 . '
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_entrega_prd . '
                ' . $date_fim_entrega_prd . '
                ' . $hora_inicio_entrega_prd . '
                ' . $hora_fim_entrega_prd . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_prc . '
                ' . $date_fim_vnc_prc . '
                ' . $date_inicio_cadastro . '
                ' . $date_fim_cadastro . '
				' . $produtos . '
				' . $parcelas . '
				OT.idSis_Empresa = ' . $data . ' 
				' . $ultimopedido2 . '
				' . $associado . '
				' . $vendedor . '
				' . $DiaAniv . '
				' . $MesAniv . '
				' . $AnoAniv . '
			' . $groupby . '
            ORDER BY
				' . $permissao60 . '
				' . $permissao61 . ' 
			' . $querylimit . ' 		
        ');
	
		if($total == TRUE) {
			//return $query->num_rows();
			/*
			$somafinal2=0;
			$somacomissao2=0;
			*/
			foreach ($query->result() as $row) {
				/*
				$somafinal2 += $row->ValorFinalOrca;
				$somacomissao2 += $row->ValorComissao;
				*/
			}
			
			$query->soma2 = new stdClass();
			/*
			$query->soma2->somafinal2 = number_format($somafinal2, 2, ',', '.');
			$query->soma2->somacomissao2 = number_format($somacomissao2, 2, ',', '.');
			*/
			return $query;
		}
				
        $query = $query->result_array();

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query;
    }

    public function get_produto($data) {
		$query = $this->db->query('
			SELECT  
				PV.idSis_Empresa,
				PV.idApp_OrcaTrata,
				PV.idTab_Produto,
				PV.QtdProduto,
				PV.QtdIncrementoProduto,
				(PV.QtdProduto * PV.QtdIncrementoProduto) AS Qtd_Prod,
				PV.DataValidadeProduto,
				PV.ObsProduto,
				PV.idApp_Produto,
				PV.ConcluidoProduto,
				PV.DevolvidoProduto,
				PV.ValorProduto,
				PV.NomeProduto,
				TPS.Nome_Prod
			FROM 
				
				App_Produto AS PV
					
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = PV.idTab_Produtos_Produto
			WHERE 
				
				PV.idApp_OrcaTrata = ' . $data . ' 
            ORDER BY
            	PV.idTab_Produto ASC				
		
		');
        $query = $query->result_array();
		
		/*
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        */		
		
        return $query;
    }
	
    public function get_parcelasrec($data) {

		$query = $this->db->query('
			SELECT  
				PR.idSis_Empresa,
				PR.idApp_OrcaTrata,
				PR.Parcela,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.DataPago,
				PR.DataLanc,
				PR.Quitado,
				FP.FormaPag
			FROM 
				
				App_Parcelas AS PR
					
					LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = PR.FormaPagamentoParcela

			WHERE 
				
				PR.idApp_OrcaTrata = ' . $data . ' 
            ORDER BY
            	PR.DataVencimento ASC				
		
		');
        $query = $query->result_array();
		
		/*
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        */		
		
        return $query;
    }

    public function get_procedimento($data) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				App_Procedimento 
			WHERE idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }

}
