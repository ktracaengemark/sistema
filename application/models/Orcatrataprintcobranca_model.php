<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrataprintcobranca_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function get_orcatrata($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {		
		
		if($data){

			$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($data['DataInicio2']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($data['DataFim2']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($data['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $data['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($data['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $data['HoraFim5'] . '" AND ' : FALSE;
										
			$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($data['DataInicio4']) ? 'PR.DataVencimento >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($data['DataFim4']) ? 'PR.DataVencimento <= "' . $data['DataFim4'] . '" AND ' : FALSE;
			
			$date_inicio_pag_prc = ($data['DataInicio5']) ? 'PR.DataPago >= "' . $data['DataInicio5'] . '" AND ' : FALSE;
			$date_fim_pag_prc = ($data['DataFim5']) ? 'PR.DataPago <= "' . $data['DataFim5'] . '" AND ' : FALSE;
		
			$date_inicio_lan_prc = ($data['DataInicio8']) ? 'PR.DataLanc >= "' . $data['DataInicio8'] . '" AND ' : FALSE;
			$date_fim_lan_prc = ($data['DataFim8']) ? 'PR.DataLanc <= "' . $data['DataFim8'] . '" AND ' : FALSE;
			
			$date_inicio_cadastro = ($data['DataInicio6']) ? 'C.DataCadastroCliente >= "' . $data['DataInicio6'] . '" AND ' : FALSE;
			$date_fim_cadastro = ($data['DataFim6']) ? 'C.DataCadastroCliente <= "' . $data['DataFim6'] . '" AND ' : FALSE;
			
			$orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
			$cliente = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
			$id_cliente = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
			$tipofinanceiro = ($data['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
			$tipord = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] . ' AND PR.idTab_TipoRD = ' . $data['idTab_TipoRD'] : FALSE;
			$campo = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
			$ordenamento = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
			$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($data['ConcluidoProduto']) ? 'PRDS.ConcluidoProduto = "' . $data['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
			$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
			
			if($_SESSION['log']['idSis_Empresa'] != 5){
				$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
			}else{
				$permissao_orcam = FALSE;
			}
			
			$groupby = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['Agrupar'] != "0") ? 'GROUP BY ' . $data['Agrupar'] . '' : 'GROUP BY PR.idApp_Parcelas';
			
			$produtos = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['Produtos'] != "0") ? 'PRDS.idSis_Empresa ' . $data['Produtos'] . '  AND' : FALSE;

		}
		/*	  
		echo "<pre>";
		echo "<br>";
		print_r($produtos);
		echo "<br>";
		print_r($groupby);
		echo "</pre>";
		*/						
        if ($limit){
			$querylimit = 'LIMIT ' . $start . ', ' . $limit;
		}else{
			$querylimit = '';
		}

		if($total == TRUE) {
		   $query_total = $this->db->query('
				SELECT
					PR.ValorParcela
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				WHERE
					' . $date_inicio_orca . '
					' . $date_fim_orca . '
					' . $date_inicio_entrega . '
					' . $date_fim_entrega . '
					' . $hora_inicio_entrega_prd . '
					' . $hora_fim_entrega_prd . '
					' . $date_inicio_vnc . '
					' . $date_fim_vnc . '
					' . $date_inicio_vnc_prc . '
					' . $date_fim_vnc_prc . '
					' . $date_inicio_pag_prc . '
					' . $date_fim_pag_prc . '
					' . $date_inicio_lan_prc . '
					' . $date_fim_lan_prc . '
					' . $date_inicio_cadastro . '
					' . $date_fim_cadastro . '
					OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					' . $permissao . '
					' . $permissao_orcam . '
					' . $filtro1 . '
					' . $filtro2 . '
					' . $filtro3 . '
					' . $filtro4 . '
					' . $filtro14 . '
					' . $filtro5 . '
					' . $filtro6 . '
					' . $filtro7 . '
					' . $filtro8 . '
					' . $filtro9 . '
					' . $filtro10 . '
					' . $filtro11 . '
					' . $filtro13 . '
					' . $produtos . '
					PR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
					' . $orcamento . '
					' . $cliente . '
					' . $id_cliente . '
					' . $tipofinanceiro . '
					' . $tipord . '
				' . $groupby . '
				ORDER BY
					' . $campo . '
					' . $ordenamento . '
				' . $querylimit . '
			');
		
			$count = $query_total->num_rows();
			
			if(!isset($count)){
				return FALSE;
			}else{
				if($count >= 20001){
					return FALSE;
				}else{
					return $query_total->num_rows();
				}
			}
		}

        ####################################################################
        #SOMATÓRIO DAS Parcelas A Receber
		$query = $this->db->query('
            SELECT
				C.NomeCliente,
                C.CelularCliente,
                C.Telefone,
                C.Telefone2,
                C.Telefone3,
				C.DataCadastroCliente,
				C.EnderecoCliente,
				C.NumeroCliente,
				C.ComplementoCliente,
				C.BairroCliente,
				C.CidadeCliente,
				C.EstadoCliente,
				C.ReferenciaCliente,
				OT.idApp_OrcaTrata,
				OT.idApp_Cliente,
				OT.Tipo_Orca,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
                OT.CombinadoFrete,
				CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntregaOrca,
                OT.DataVencimentoOrca,
				OT.ValorFinalOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.Modalidade,
				OT.AVAP,
				OT.TipoFrete,
				OT.NomeRec,
				OT.ParentescoRec,
				OT.FormaPagamento,
				TR.TipoFinanceiro,
                PR.idApp_Parcelas,
                PR.idSis_Empresa,
				PR.idSis_Usuario,
				PR.idApp_Cliente,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.DataLanc,
                PR.ValorPago,
                PR.Quitado,
				PR.idTab_TipoRD,
				PR.FormaPagamentoParcela,
				PRDS.DataConcluidoProduto,
				PRDS.ConcluidoProduto,
				TFP.FormaPag
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
            WHERE
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $hora_inicio_entrega_prd . '
                ' . $hora_fim_entrega_prd . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_prc . '
                ' . $date_fim_vnc_prc . '
                ' . $date_inicio_pag_prc . '
                ' . $date_fim_pag_prc . '
                ' . $date_inicio_lan_prc . '
                ' . $date_fim_lan_prc . '
                ' . $date_inicio_cadastro . '
                ' . $date_fim_cadastro . '
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao . '
				' . $permissao_orcam . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro4 . '
				' . $filtro14 . '
				' . $filtro5 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				' . $filtro10 . '
				' . $filtro11 . '
				' . $filtro13 . '
				' . $produtos . '
                PR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
                ' . $orcamento . '
                ' . $cliente . '
                ' . $id_cliente . '
				' . $tipofinanceiro . '
				' . $tipord . '
			' . $groupby . '
			ORDER BY
				' . $campo . '
				' . $ordenamento . '
			' . $querylimit . '
		');
		
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
