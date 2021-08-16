<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrataprintcomissao_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function get_orcatrata($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
				'(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim2']) {
            $consulta2 =
				'(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '")';
        }
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim3']) {
            $consulta3 =
				'(OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '")';
        }
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;
			
		$date_inicio_pag_com = ($_SESSION['FiltroAlteraParcela']['DataInicio7']) ? 'OT.DataPagoComissaoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio7'] . '" AND ' : FALSE;
		$date_fim_pag_com = ($_SESSION['FiltroAlteraParcela']['DataFim7']) ? 'OT.DataPagoComissaoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim7'] . '" AND ' : FALSE;
				
		$permissao30 = ($_SESSION['FiltroAlteraParcela']['Orcamento'] != "" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '" AND ' : FALSE;
		$permissao31 = ($_SESSION['FiltroAlteraParcela']['Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['Cliente'] . '" AND ' : FALSE;
		$permissao37 = ($_SESSION['FiltroAlteraParcela']['idApp_Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] . '" AND ' : FALSE;
		$permissao13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete'] != "0" ) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] != "0" ) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$permissao11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca'] != "0" ) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
		
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca'] != "0" ) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao33 = ($_SESSION['FiltroAlteraParcela']['AVAP'] != "0" ) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$permissao34 = ($_SESSION['FiltroAlteraParcela']['TipoFrete'] != "0" ) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$permissao32 = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] != "0" ) ? 'OT.TipoFinanceiro = "' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] . '" AND ' : FALSE;
		
		$permissao26 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao27 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao25 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;		
		
		$permissao17 = ($_SESSION['FiltroAlteraParcela']['NomeUsuario'] != "0" ) ? 'OT.idSis_Usuario = "' . $_SESSION['FiltroAlteraParcela']['NomeUsuario'] . '" AND ' : FALSE;
		$permissao18 = ($_SESSION['FiltroAlteraParcela']['NomeAssociado'] != "" ) ? 'OT.Associado = "' . $_SESSION['FiltroAlteraParcela']['NomeAssociado'] . '" AND ' : FALSE;
		$permissao12 = ($_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] != "0" ) ? 'OT.StatusComissaoOrca = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] . '" AND ' : FALSE;
		$permissao14 = ($_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] != "0" ) ? 'OT.StatusComissaoOrca_Online = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] . '" AND ' : FALSE;

        if ($limit){
			$querylimit = 'LIMIT ' . $start . ', ' . $limit;
		}else{
			$querylimit = '';
		}
				
		$query = $this->db->query(
            'SELECT
				C.NomeCliente,
				C.CelularCliente,
				C.Telefone,
				C.Telefone2,
				C.Telefone3,
				C.EnderecoCliente,
				C.NumeroCliente,
				C.ComplementoCliente,
				C.BairroCliente,
				C.CidadeCliente,
				C.EstadoCliente,
				OT.idSis_Empresa,
				OT.idApp_OrcaTrata,
				OT.CombinadoFrete,
				OT.AprovadoOrca,
				OT.ConcluidoOrca,
				OT.QuitadoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.DataOrca,
				OT.DataPrazo,
				OT.DataConclusao,
				OT.DataQuitado,				
				OT.DataRetorno,
				OT.DataEntradaOrca,
				OT.idApp_Cliente,
				OT.idApp_Fornecedor,
				OT.ValorOrca,
				OT.ValorTotalOrca,
				OT.ValorFinalOrca,
				OT.ValorDev,
				OT.ValorDinheiro,
				OT.ValorTroco,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.ValorComissao,
				OT.QtdParcelasOrca,
				OT.DataEntregaOrca,
				OT.DataVencimentoOrca,
				OT.DataPagoComissaoOrca,
				OT.StatusComissaoOrca,
				OT.StatusComissaoOrca_Online,
				OT.idSis_Usuario,
				OT.ObsOrca,
				OT.Descricao,
				OT.TipoFinanceiro,
				OT.Tipo_Orca,
				OT.FormaPagamento,
				OT.Associado,
				TTF.TipoFrete,
				FP.FormaPag,				
				EF.NomeEmpresa,
				MO.AVAP,
				MO.Abrev2,
				OT.Modalidade,
				TP.TipoFinanceiro,
				PR.DataVencimento,
				PR.Quitado,
				US.Nome AS NomeColaborador,
				USA.Nome AS NomeAssociado
            FROM
				App_OrcaTrata AS OT
				LEFT JOIN Sis_Empresa AS EF ON EF.idSis_Empresa = OT.idSis_Empresa
				LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TP ON TP.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_AVAP AS MO ON MO.Abrev2 = OT.AVAP
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
				LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
				LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
				LEFT JOIN Sis_Usuario AS USA ON USA.idSis_Usuario = OT.Associado
				LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
            WHERE
				' . $permissao . '
				' . $permissao_orcam . '
				' . $permissao30 . '
				' . $permissao31 . '
				' . $permissao37 . '
				' . $permissao13 . '
				' . $permissao1 . '
				' . $permissao3 . '
				' . $permissao2 . '
				' . $permissao4 . '
				' . $permissao10 . '
				' . $permissao11 . '
				' . $permissao12 . '
				' . $permissao14 . '
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao32 . '
				' . $permissao33 . '
				' . $permissao34 . '
				' . $permissao17 . '
				' . $permissao18 . '
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_prc . '
                ' . $date_fim_vnc_prc . '
                ' . $date_inicio_pag_com . '
                ' . $date_fim_pag_com . '
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "2" 
			GROUP BY
                OT.idApp_OrcaTrata	
            ORDER BY
				OT.DataVencimentoOrca,
				OT.idApp_OrcaTrata
			' . $querylimit . ' 		
        ');
	
		if($total == TRUE) {
			//return $query->num_rows();
			//$somafinal2=0;
			$somacomissao2=0;
			
			foreach ($query->result() as $row) {
				
				//$somafinal2 += $row->ValorFinalOrca;
				$somacomissao2 += $row->ValorComissao;
				
			}
			
			$query->soma2 = new stdClass();
			
			//$query->soma2->somafinal2 = number_format($somafinal2, 2, ',', '.');
			$query->soma2->somacomissao2 = number_format($somacomissao2, 2, ',', '.');
			
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
				App_OrcaTrata AS OT,
				App_Produto AS PV
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = PV.idTab_Produtos_Produto
			WHERE 
				PV.idApp_OrcaTrata = OT.idApp_OrcaTrata AND
				PV.idSis_Empresa = ' . $data . ' 
            ORDER BY
            	PV.idApp_OrcaTrata DESC				
		
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
		
        if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
				'(PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }		
		
		$query = $this->db->query('
			SELECT  
				PR.idSis_Empresa,
				PR.idApp_OrcaTrata,
				PR.Parcela,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.DataPago,
				PR.Quitado
			FROM 
				App_OrcaTrata AS OT,
				App_Parcelas AS PR

			WHERE 
				PR.idApp_OrcaTrata = OT.idApp_OrcaTrata AND
				PR.idSis_Empresa = ' . $data . ' 
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
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idSis_Empresa = ' . $data);
        $query = $query->result_array();

        return $query;
    }

}
