<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Despesas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function list_pedidos_busca($total = FALSE) {	
		
		if($total == TRUE) {
			$busca1 = '
				SELECT 
					OT.idApp_OrcaTrata
				FROM 
					App_OrcaTrata AS OT
						LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
			';
			
			return $busca1;
		}	
		
		if($total == FALSE) {
			$busca2 = '
				SELECT 
					C.idApp_Fornecedor,
					C.NomeFornecedor,
					C.CelularFornecedor,
					OT.Descricao,
					OT.idApp_OrcaTrata,
					OT.AprovadoOrca,
					DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
					DATE_FORMAT(OT.DataEntregaOrca, "%d/%m/%Y") AS DataEntregaOrca,
					DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
					OT.DataEntradaOrca,
					OT.DataPrazo,
					OT.ValorOrca,
					OT.ValorDev,				
					OT.ValorEntradaOrca,
					OT.ValorRestanteOrca,
					OT.DataVencimentoOrca,
					OT.ConcluidoOrca,
					OT.QuitadoOrca,
					OT.FinalizadoOrca,
					OT.CanceladoOrca,
					OT.EnviadoOrca,
					OT.ProntoOrca,
					OT.DataConclusao,
					OT.DataQuitado,
					OT.DataRetorno,
					OT.idTab_TipoRD,
					OT.FormaPagamento,
					OT.ObsOrca,
					OT.QtdParcelasOrca,
					OT.Tipo_Orca,
					OT.CombinadoFrete,
					PR.idSis_Empresa,
					PR.Parcela,
					CONCAT(PR.Parcela) AS Parcela,
					DATE_FORMAT(PR.DataVencimento, "%d/%m/%Y") AS DataVencimento,
					PR.ValorParcela,
					PR.DataPago,
					PR.ValorPago,
					PR.Quitado,
					PRD.NomeProduto,
					PRD.ConcluidoProduto,
					DATE_FORMAT(PRD.DataConcluidoProduto, "%d/%m/%Y") AS DataConcluidoProduto,
					DATE_FORMAT(PRD.HoraConcluidoProduto, "%H:%i") AS HoraConcluidoProduto,
					TF.TipoFrete,
					MD.Modalidade,
					VP.Abrev2,
					VP.AVAP,
					TFP.FormaPag,
					TR.TipoFinanceiro
				FROM 
					App_OrcaTrata AS OT
						LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
						LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
						LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
						LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
				WHERE
			';
			
			return $busca2;
		}	
	}	
	
    public function list_pedidos_filtros($data = FALSE) {	
		
		$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($data['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($data['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $data['DataFim2'] . '" AND ' : FALSE;

		$hora_inicio_entrega_prd = ($data['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $data['HoraInicio5'] . '" AND ' : FALSE;
		$hora_fim_entrega_prd = ($data['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $data['HoraFim5'] . '" AND ' : FALSE;
					
		$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($data['DataInicio4']) ? 'PR.DataVencimento >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($data['DataFim4']) ? 'PR.DataVencimento <= "' . $data['DataFim4'] . '" AND ' : FALSE;
		
		$Orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$Fornecedor = ($data['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'] : FALSE;
		$id_Fornecedor = ($data['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['idApp_Fornecedor'] : FALSE;
		$TipoFinanceiro = ($data['TipoFinanceiroD']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
		$Campo = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
		$Ordenamento = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
		$filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro14 = ($data['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $data['ConcluidoProduto'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;

		if($_SESSION['log']['idSis_Empresa'] != 5){
			if($_SESSION['Empresa']['Rede'] == "S"){
				if($_SESSION['Usuario']['Nivel'] == 2){
					$nivel = 'AND OT.NivelOrca = 2';
					$permissao = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}elseif($_SESSION['Usuario']['Nivel'] == 1){
					$nivel = FALSE;
					$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
						$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}else{
						$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}
				}else{
					$nivel = FALSE;
					$permissao = FALSE;
					$permissao_orcam = FALSE;
				}
			}else{
				if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
					$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}else{
					$permissao_orcam = FALSE;
				}
				$nivel = FALSE;
				$permissao = FALSE;
			}
			$produtos = ($data['Produtos']) ? 'PRD.idSis_Empresa ' . $data['Produtos'] . ' AND' : FALSE;
			$parcelas = ($data['Parcelas']) ? 'PR.idSis_Empresa ' . $data['Parcelas'] . ' AND' : FALSE;
		}else{
			$permissao_orcam = FALSE;
			if(isset($data['metodo']) && $data['metodo'] == 3){
				$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao = FALSE;
			}
			$nivel = FALSE;
			$produtos = FALSE;
			$parcelas = FALSE;
		}

		$filtro_base = '
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
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao_orcam . '
				' . $permissao . '
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
				' . $parcelas . '
				OT.idTab_TipoRD = "1" AND
				OT.CanceladoOrca = "N" 
				' . $Orcamento . '
				' . $Fornecedor . '
				' . $id_Fornecedor . '
				' . $TipoFinanceiro . '
				' . $nivel . '

		';

		return $filtro_base;
		
	}

    public function list_pedidos_retorno($query = FALSE, $total = FALSE) {
		
		if($total == TRUE) {
			return $query->num_rows();
		}
		
		if($total == FALSE) {
			foreach ($query->result() as $row) {
				$row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
				$row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
				$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
				$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
				$row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
				$row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				
				if($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}elseif($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}else{
					$row->Tipo_Orca = "Outros";
				}
			}
			return $query;
		}
	}
	
    public function list_pedidos_pesquisar($data = FALSE, $completo = FALSE) {
		/*
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		exit();
		*/
		$Orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;

		if($_SESSION['log']['idSis_Empresa'] != 5){
			if($_SESSION['Empresa']['Rede'] == "S"){
				if($_SESSION['Usuario']['Nivel'] == 2){
					$nivel = 'AND OT.NivelOrca = 2';
					$permissao = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}elseif($_SESSION['Usuario']['Nivel'] == 1){
					$nivel = FALSE;
					$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
						$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}else{
						$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}
				}else{
					$nivel = FALSE;
					$permissao = FALSE;
					$permissao_orcam = FALSE;
				}
			}else{
				if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
					$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}else{
					$permissao_orcam = FALSE;
				}
				$nivel = FALSE;
				$permissao = FALSE;
			}
			$produtos = ($data['Produtos']) ? 'PRD.idSis_Empresa ' . $data['Produtos'] . ' AND' : FALSE;
			$parcelas = ($data['Parcelas']) ? 'PR.idSis_Empresa ' . $data['Parcelas'] . ' AND' : FALSE;
		}else{
			$permissao_orcam = FALSE;
			if(isset($data['metodo']) && $data['metodo'] == 3){
				$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao = FALSE;
			}
			$nivel = FALSE;
			$produtos = FALSE;
			$parcelas = FALSE;
		}
			
        $query = $this->db->query('
			SELECT
				OT.idApp_OrcaTrata
			FROM
				App_OrcaTrata AS OT
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao_orcam . '
				' . $permissao . '
				OT.idTab_TipoRD = "1" 
                ' . $Orcamento . '
                ' . $nivel . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.idApp_OrcaTrata ASC
				
		');

		foreach ($query->result() as $row) {
		}
		return $query;
       		

    }
	
    public function list_pedidos_combinar($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		$complemento = ' 
				AND OT.CombinadoFrete = "N"
			GROUP BY
				OT.idApp_OrcaTrata
			ORDER BY 
				PRD.DataConcluidoProduto ASC,
				PRD.HoraConcluidoProduto ASC,
				OT.idApp_OrcaTrata
		';

		$busca = $this->Despesas_model->list_pedidos_busca($total);
		$filtro_base = $this->Despesas_model->list_pedidos_filtros($data);
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		$query = $this->db->query('
			' . $busca . '
			' . $filtro_base . '
			' . $complemento . '
			' . $querylimit . '
		');
		$retorno = $this->Despesas_model->list_pedidos_retorno($query, $total);	
		return $retorno;

    }

    public function list_pedidos_aprovar($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		$complemento = ' 
				AND OT.AprovadoOrca = "N"
			GROUP BY
				OT.idApp_OrcaTrata
			ORDER BY 
				PRD.DataConcluidoProduto ASC,
				PRD.HoraConcluidoProduto ASC,
				OT.idApp_OrcaTrata
		';

		$busca = $this->Despesas_model->list_pedidos_busca($total);
		$filtro_base = $this->Despesas_model->list_pedidos_filtros($data);
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		$busca = $this->Despesas_model->list_pedidos_busca($total);
		$filtro_base = $this->Despesas_model->list_pedidos_filtros($data);
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		$query = $this->db->query('
			' . $busca . '
			' . $filtro_base . '
			' . $complemento . '
			' . $querylimit . '
		');
		$retorno = $this->Despesas_model->list_pedidos_retorno($query, $total);	
		return $retorno;
		
    }	
	
    public function list_pedidos_producao($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		$complemento = ' 
				AND OT.CombinadoFrete = "S" 
				AND OT.AprovadoOrca = "S" 
				AND OT.ConcluidoOrca = "N" 
				AND OT.ProntoOrca = "N"
			GROUP BY
				OT.idApp_OrcaTrata
			ORDER BY 
				PRD.DataConcluidoProduto ASC,
				PRD.HoraConcluidoProduto ASC,
				OT.idApp_OrcaTrata
		';

		$busca = $this->Despesas_model->list_pedidos_busca($total);
		$filtro_base = $this->Despesas_model->list_pedidos_filtros($data);
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		$query = $this->db->query('
			' . $busca . '
			' . $filtro_base . '
			' . $complemento . '
			' . $querylimit . '
		');
		$retorno = $this->Despesas_model->list_pedidos_retorno($query, $total);	
		return $retorno;

    }

    public function list_pedidos_envio($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		$complemento = ' 
				AND OT.CombinadoFrete = "S" 
				AND OT.AprovadoOrca = "S" 
				AND OT.ConcluidoOrca = "N" 
				AND OT.EnviadoOrca = "N" 
			GROUP BY
				OT.idApp_OrcaTrata
			ORDER BY 
				PRD.DataConcluidoProduto ASC,
				PRD.HoraConcluidoProduto ASC,
				OT.idApp_OrcaTrata
		';

		$busca = $this->Despesas_model->list_pedidos_busca($total);
		$filtro_base = $this->Despesas_model->list_pedidos_filtros($data);
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		$query = $this->db->query('
			' . $busca . '
			' . $filtro_base . '
			' . $complemento . '
			' . $querylimit . '
		');
		$retorno = $this->Despesas_model->list_pedidos_retorno($query, $total);	
		return $retorno;

    }

    public function list_pedidos_entrega($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		$complemento = '
				AND OT.CombinadoFrete = "S" 
				AND OT.AprovadoOrca = "S" 
				AND OT.ConcluidoOrca = "N" 
				AND PRD.ConcluidoProduto = "N"
			GROUP BY
				OT.idApp_OrcaTrata
			ORDER BY 
				PRD.DataConcluidoProduto ASC,
				PRD.HoraConcluidoProduto ASC,
				OT.idApp_OrcaTrata
		';

		$busca = $this->Despesas_model->list_pedidos_busca($total);
		$filtro_base = $this->Despesas_model->list_pedidos_filtros($data);
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		$query = $this->db->query('
			' . $busca . '
			' . $filtro_base . '
			' . $complemento . '
			' . $querylimit . '
		');
		$retorno = $this->Despesas_model->list_pedidos_retorno($query, $total);	
		return $retorno;

    }

    public function list_pedidos_pagamento($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		$complemento = '
				AND OT.CombinadoFrete = "S" 
				AND OT.AprovadoOrca = "S" 
				AND OT.QuitadoOrca = "N" 
				AND PR.Quitado = "N"
			GROUP BY
				OT.idApp_OrcaTrata
			ORDER BY 
				PR.DataVencimento ASC,
				OT.idApp_OrcaTrata
		';

		$busca = $this->Despesas_model->list_pedidos_busca($total);
		$filtro_base = $this->Despesas_model->list_pedidos_filtros($data);
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		$query = $this->db->query('
			' . $busca . '
			' . $filtro_base . '
			' . $complemento . '
			' . $querylimit . '
		');
		$retorno = $this->Despesas_model->list_pedidos_retorno($query, $total);	
		return $retorno;

    }

    public function list_despesas($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($data['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($data['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $data['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_entrega_prd = ($data['DataInicio5']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio5'] . '" AND ' : FALSE;
		$date_fim_entrega_prd = ($data['DataFim5']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim5'] . '" AND ' : FALSE;

		$hora_inicio_entrega_prd = ($data['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $data['HoraInicio5'] . '" AND ' : FALSE;
		$hora_fim_entrega_prd = ($data['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $data['HoraFim5'] . '" AND ' : FALSE;
						
		$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
		
		if(isset($data['Quitado']) && $data['Quitado'] == "S"){
			$dataref = 'PR.DataPago';
		}else{
			$dataref = 'PR.DataVencimento';
		}
		
		$date_inicio_vnc_prc = ($data['DataInicio4']) ? ''.$dataref.' >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($data['DataFim4']) ? ''.$dataref.' <= "' . $data['DataFim4'] . '" AND ' : FALSE;

		$date_inicio_cadastro = ($data['DataInicio6']) ? 'C.DataCadastroFornecedor >= "' . $data['DataInicio6'] . '" AND ' : FALSE;
		$date_fim_cadastro = ($data['DataFim6']) ? 'C.DataCadastroFornecedor <= "' . $data['DataFim6'] . '" AND ' : FALSE;

		$DiaAniv = ($data['DiaAniv']) ? ' AND DAY(C.DataNascimento) = ' . $data['DiaAniv'] : FALSE;
		$MesAniv = ($data['MesAniv']) ? ' AND MONTH(C.DataNascimento) = ' . $data['MesAniv'] : FALSE;
		$AnoAniv = ($data['AnoAniv']) ? ' AND YEAR(C.DataNascimento) = ' . $data['AnoAniv'] : FALSE;

		$orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
		$fornecedor = ($data['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'] . '' : FALSE;
		$id_fornecedor = ($data['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['idApp_Fornecedor'] . '' : FALSE;
		$id_funcionario = ($data['id_Funcionario']) ? ' AND OT.id_Funcionario = ' . $data['id_Funcionario'] . '' : FALSE;
		$id_associado = ($data['id_Associado']) ? ' AND OT.id_Associado = ' . $data['id_Associado'] . '' : FALSE;
		$tipofinandeiro = ($data['TipoFinanceiro']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$idtipord = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] : ' AND OT.idTab_TipoRD = 1';
		$campo = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
		$ordenamento = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
		$filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		$filtro17 = ($data['NomeUsuario']) ? 'OT.idSis_Usuario = "' . $data['NomeUsuario'] . '" AND ' : FALSE;

		if($_SESSION['log']['idSis_Empresa'] != 5){
			if($_SESSION['Empresa']['Rede'] == "S"){
				if($_SESSION['Usuario']['Nivel'] == 2){
					$nivel = 'AND OT.NivelOrca = 2';
					$permissao = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}elseif($_SESSION['Usuario']['Nivel'] == 1){
					$nivel = FALSE;
					$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
						$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}else{
						$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}
				}else{
					$nivel = FALSE;
					$permissao = FALSE;
					$permissao_orcam = FALSE;
				}
			}else{
				if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
					$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}else{
					$permissao_orcam = FALSE;
				}
				$nivel = FALSE;
				$permissao = FALSE;
			}
			$produtos = ($data['Produtos']) ? 'PRDS.idSis_Empresa ' . $data['Produtos'] . ' AND' : FALSE;
			$parcelas = ($data['Parcelas']) ? 'PR.idSis_Empresa ' . $data['Parcelas'] . ' AND' : FALSE;
		}else{
			$permissao_orcam = FALSE;
			if(isset($data['metodo']) && $data['metodo'] == 3){
				$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao = FALSE;
			}
			$nivel = FALSE;
			$produtos = FALSE;
			$parcelas = FALSE;
		}

		$groupby = (isset($data['Agrupar']) && $data['Agrupar'] != "0") ? 'GROUP BY OT.' . $data['Agrupar'] . '' : 'GROUP BY OT.idApp_OrcaTrata';

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;


		if($completo == FALSE){
			$complemento = FALSE;
		}else{
			$complemento = ' AND OT.CanceladoOrca = "N" AND OT.FinalizadoOrca = "N"';
		}

		$filtro_base = '
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
				' . $permissao . '
				' . $permissao_orcam . '
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
				' . $produtos . '
				' . $parcelas . '
				OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . '
				' . $orcamento . '
				' . $fornecedor . '
				' . $id_fornecedor . '
				' . $id_funcionario . '
				' . $id_associado . '
				' . $tipofinandeiro . ' 
				' . $idtipord . '
				' . $DiaAniv . '
				' . $MesAniv . '
				' . $AnoAniv . '
				' . $nivel . '
				' . $complemento . '
			' . $groupby . '
			ORDER BY
				' . $campo . '
				' . $ordenamento . '
			' . $querylimit . '
		';
		
		####Contagem e soma total ####
		if($total == TRUE && $date == FALSE) {
			
			$query_total = $this->db->query(
				'SELECT
					OT.ValorFinalOrca
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . ''
			);
			
			$count = $query_total->num_rows();
			
			if(!isset($count)){
				return FALSE;
			}else{
				if($count >= 12001){
					return FALSE;
				}else{
					$somafinal2=0;
					foreach ($query_total->result() as $row) {
						$somafinal2 += $row->ValorFinalOrca;
					}
					$query_total->soma2 = new stdClass();
					$query_total->soma2->somafinal2 = number_format($somafinal2, 2, ',', '.');

					return $query_total;
				}
			}
		}
			
		####Campos para Relatório/Lista/Excel ####
		if($total == FALSE && $date == FALSE) {
			$query = $this->db->query(
				'SELECT
					OT.idApp_OrcaTrata,
					OT.CombinadoFrete,
					OT.AprovadoOrca,
					OT.FinalizadoOrca,
					OT.CanceladoOrca,
					OT.ConcluidoOrca,
					OT.QuitadoOrca,
					OT.DataOrca,
					OT.DataEntregaOrca,
					DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
					OT.ValorRestanteOrca,
					OT.DescValorOrca,
					OT.ValorFinalOrca,
					OT.ValorFrete,
					OT.ValorExtraOrca,
					(OT.ValorExtraOrca + OT.ValorRestanteOrca + OT.ValorFrete) AS TotalOrca,
					OT.CashBackOrca,
					OT.idTab_TipoRD,
					OT.Tipo_Orca,
					OT.NomeRec,
					OT.ParentescoRec,
					OT.TelefoneRec,
					OT.NivelOrca,
					OT.idSis_Usuario,
					US.Nome,
					CONCAT(IFNULL(US.idSis_Usuario,""), " - " ,IFNULL(US.Nome,"")) AS NomeColaborador,
					OT.id_Funcionario,
					CONCAT(IFNULL(UF.idSis_Usuario,""), " - " ,IFNULL(UF.Nome,"")) AS NomeFuncionario,
					OT.id_Associado,
					CONCAT(IFNULL(ASS.idSis_Associado,""), " - " ,IFNULL(ASS.Nome,"")) AS NomeAssociado,
					OT.idApp_Fornecedor,
					CONCAT(IFNULL(C.idApp_Fornecedor,""), " - " ,IFNULL(C.NomeFornecedor,"")) AS NomeFornecedor,
					CONCAT(IFNULL(C.NomeFornecedor,"")) AS Fornecedor,
					C.CelularFornecedor,
					C.DataCadastroFornecedor,
					C.DataNascimento,
					C.Telefone2,
					C.Telefone3,
					TFP.FormaPag,
					TR.TipoFinanceiro,
					OT.Modalidade,
					OT.AVAP,
					OT.TipoFrete
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UF ON UF.idSis_Usuario = OT.id_Funcionario
						LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = OT.id_Associado
						LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
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

			$somasubtotal=0;
			$subtotal=0;
			$somadesconto=0;
			$somarestante=0;
			$somasubcomissao=0;
			$somaextra=0;
			$somafrete=0;
			$somatotal=0;
			$somadesc=0;
			$somacashback=0;
			$somafinal=0;
			
			foreach ($query->result() as $row) {
				
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataCadastroFornecedor = $this->basico->mascara_data($row->DataCadastroFornecedor, 'barras');

				$somaextra += $row->ValorExtraOrca;
				$row->ValorExtraOrca = number_format($row->ValorExtraOrca, 2, ',', '.');
				$somarestante += $row->ValorRestanteOrca;
				$row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');
				$somafrete += $row->ValorFrete;
				$row->ValorFrete = number_format($row->ValorFrete, 2, ',', '.');
				$somatotal += $row->TotalOrca;
				$row->TotalOrca = number_format($row->TotalOrca, 2, ',', '.');
				$somadesc += $row->DescValorOrca;
				$row->DescValorOrca = number_format($row->DescValorOrca, 2, ',', '.');
				$somacashback += $row->CashBackOrca;
				$row->CashBackOrca = number_format($row->CashBackOrca, 2, ',', '.');
				$somafinal += $row->ValorFinalOrca;
				$row->ValorFinalOrca = number_format($row->ValorFinalOrca, 2, ',', '.');

				if($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "NaLoja";
				}elseif($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "OnLine";
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
			$query->soma->somaextra = number_format($somaextra, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');
			$query->soma->somafrete = number_format($somafrete, 2, ',', '.');
			$query->soma->somatotal = number_format($somatotal, 2, ',', '.');
			$query->soma->somadesc = number_format($somadesc, 2, ',', '.');
			$query->soma->somacashback = number_format($somacashback, 2, ',', '.');
			$query->soma->somafinal = number_format($somafinal, 2, ',', '.');

			if(!isset($query)){
				return FALSE;
			} else {
				return $query;
			}
		}
    
		####Campos para Baixa ####
		if($total == TRUE && $date == TRUE) {
			$query = $this->db->query(
				'SELECT
					OT.idApp_OrcaTrata,
					OT.idSis_Usuario,
					OT.CombinadoFrete,
					OT.AprovadoOrca,
					OT.FinalizadoOrca,
					OT.CanceladoOrca,
					OT.ConcluidoOrca,
					OT.QuitadoOrca,
					OT.DataOrca,
					OT.DataEntregaOrca,
					DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
					OT.ValorRestanteOrca,
					OT.DescValorOrca,
					OT.ValorFinalOrca,
					OT.ValorFrete,
					OT.ValorExtraOrca,
					(OT.ValorExtraOrca + OT.ValorRestanteOrca + OT.ValorFrete) AS TotalOrca,
					OT.CashBackOrca,
					OT.idTab_TipoRD,
					OT.Tipo_Orca,
					OT.NomeRec,
					OT.ParentescoRec,
					OT.TelefoneRec,
					OT.idApp_Fornecedor,
					CONCAT(IFNULL(C.idApp_Fornecedor,""), " - " ,IFNULL(C.NomeFornecedor,"")) AS NomeFornecedor,
					CONCAT(IFNULL(C.NomeFornecedor,"")) AS Fornecedor,
					C.CelularFornecedor,
					C.DataCadastroFornecedor,
					C.DataNascimento,
					C.Telefone2,
					C.Telefone3,
					US.Nome,
					CONCAT(IFNULL(US.idSis_Usuario,""), " - " ,IFNULL(US.Nome,"")) AS NomeColaborador,
					TFP.FormaPag,
					TR.TipoFinanceiro,
					OT.Modalidade,
					OT.AVAP,
					OT.TipoFrete
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
				WHERE
					' . $filtro_base . ''
			);	
			
			$query = $query->result_array();
			return $query;
		}
	}

	public function list_debitos($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

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
		
		$date_inicio_cadastro = ($data['DataInicio6']) ? 'C.DataCadastroFornecedor >= "' . $data['DataInicio6'] . '" AND ' : FALSE;
		$date_fim_cadastro = ($data['DataFim6']) ? 'C.DataCadastroFornecedor <= "' . $data['DataFim6'] . '" AND ' : FALSE;
		
		$orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;

		$tipofinanceiro = ($data['TipoFinanceiro']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$tipord = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] : ' AND OT.idTab_TipoRD = 1';
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

		if($_SESSION['log']['idSis_Empresa'] != 5){
			if($data['Fornecedor']){
				$fornecedor = ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'];
			}else{
				$fornecedor = FALSE;
			}
			if($data['idApp_Fornecedor']){
				$id_fornecedor = ' AND OT.idApp_Fornecedor = ' . $data['idApp_Fornecedor'];
			}else{
				$id_fornecedor = FALSE;
			}				
			if($_SESSION['Empresa']['Rede'] == "S"){
				if($_SESSION['Usuario']['Nivel'] == 2){
					$nivel = 'AND OT.NivelOrca = 2';
					$permissao = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}elseif($_SESSION['Usuario']['Nivel'] == 1){
					$nivel = FALSE;
					$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
						$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}else{
						$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}
				}else{
					$nivel = FALSE;
					$permissao = FALSE;
					$permissao_orcam = FALSE;
				}
			}else{
				if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
					$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}else{
					$permissao_orcam = FALSE;
				}
				$nivel = FALSE;
				$permissao = FALSE;
			}
			$produtos = ($data['Produtos']) ? 'PRDS.idSis_Empresa ' . $data['Produtos'] . ' AND' : FALSE;
			$parcelas = ($data['Parcelas']) ? 'PR.idSis_Empresa ' . $data['Parcelas'] . ' AND' : FALSE;
		}else{
			$fornecedor = FALSE;
			$id_fornecedor = FALSE;
			$permissao_orcam = FALSE;
			if(isset($data['metodo']) && $data['metodo'] == 3){
				$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao = FALSE;
			}
			$nivel = FALSE;
			$produtos = FALSE;
			$parcelas = FALSE;
		}

		$groupby = ($data['Agrupar']) ? 'GROUP BY ' . $data['Agrupar'] . '' : 'GROUP BY PR.idApp_Parcelas';

		/*	  
		echo "<pre>";
		echo "<br>";
		print_r($produtos);
		echo "<br>";
		print_r($groupby);
		echo "</pre>";
		*/	  
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
				' . $parcelas . '
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
				' . $orcamento . '
				' . $fornecedor . '
				' . $id_fornecedor . '
				' . $tipofinanceiro . '
				' . $tipord . '
				' . $nivel . '
				' . $complemento . '
			' . $groupby . '
			ORDER BY
				' . $campo . '
				' . $ordenamento . '
			' . $querylimit . '
		';
		
        ####################################################################
        #Contagem DAS Parcelas e Soma total Para todas as listas e baixas
		if($total == TRUE && $date == FALSE) {
		   $query_total = $this->db->query(
				'SELECT
					PR.ValorParcela
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . ''
			);
		
			$count = $query_total->num_rows();
			
			if(!isset($count)){
				return FALSE;
			}else{
				if($count >= 12001){
					return FALSE;
				}else{
					$somaparcelas2=0;
					foreach ($query_total->result() as $row) {
						$somaparcelas2 += $row->ValorParcela;
					}
					$query_total->soma2 = new stdClass();
					$query_total->soma2->somaparcelas2 = number_format($somaparcelas2, 2, ',', '.');

					return $query_total;
				}
			}
		}

        ####################################################################
        # Relatório/Excel Campos para exibição DAS Parcelas
		if($total == FALSE && $date == FALSE) {
			$query = $this->db->query(
				'SELECT
					C.NomeFornecedor,
					C.CelularFornecedor,
					C.Telefone2,
					C.Telefone3,
					C.DataCadastroFornecedor,
					C.EnderecoFornecedor,
					C.NumeroFornecedor,
					C.ComplementoFornecedor,
					C.BairroFornecedor,
					C.CidadeFornecedor,
					C.EstadoFornecedor,
					C.ReferenciaFornecedor,
					OT.idApp_OrcaTrata,
					OT.idApp_Fornecedor,
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
					PR.idApp_Fornecedor,
					PR.Parcela,
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
						LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				WHERE
					' . $filtro_base . ''
			);

            $somapago=$somapagar=$somaentrada=$somareceber=$somapago=$somapagar=$somareal=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
                $row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');
                $row->DataLanc = $this->basico->mascara_data($row->DataLanc, 'barras');
                //$row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                //$row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				//$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				//$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
				//$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
				//$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                //$row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

				#esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez

                $somareceber += $row->ValorParcela;				
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.'); 			
				
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
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');

			if(!isset($query)){
				return FALSE;
			} else {
				return $query;
			}
		}
    
        ####################################################################
        # Lista/Recibo Campos para Impressão DAS Parcelas
		if($total == FALSE && $date == TRUE) {
			$query = $this->db->query('
				SELECT
					C.NomeFornecedor,
					C.CelularFornecedor,
					C.Telefone2,
					C.Telefone3,
					C.DataCadastroFornecedor,
					C.EnderecoFornecedor,
					C.NumeroFornecedor,
					C.ComplementoFornecedor,
					C.BairroFornecedor,
					C.CidadeFornecedor,
					C.EstadoFornecedor,
					C.ReferenciaFornecedor,
					OT.idApp_OrcaTrata,
					OT.idApp_Fornecedor,
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
					PR.idApp_Fornecedor,
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
						LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				WHERE
					' . $filtro_base . ''
			);

			$query = $query->result_array();

			return $query;
		}
		
        ####################################################################
        # Campos para Baixa DAS Parcelas
		if($total == TRUE && $date == TRUE) {
			$query = $this->db->query(
				'SELECT
					C.NomeFornecedor,
					C.CelularFornecedor,
					C.Telefone2,
					C.Telefone3,
					C.DataCadastroFornecedor,
					C.EnderecoFornecedor,
					C.NumeroFornecedor,
					C.ComplementoFornecedor,
					C.BairroFornecedor,
					C.CidadeFornecedor,
					C.EstadoFornecedor,
					C.ReferenciaFornecedor,
					OT.idApp_OrcaTrata,
					OT.idApp_Fornecedor,
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
					CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TR.TipoFinanceiro,""), "--", IFNULL(C.idApp_Fornecedor,""), "--", IFNULL(C.NomeFornecedor,""), "--", IFNULL(OT.Descricao,"")) AS Despesa,
					TR.TipoFinanceiro,
					PR.idApp_Parcelas,
					PR.idSis_Empresa,
					PR.idSis_Usuario,
					PR.idApp_Fornecedor,
					PR.Parcela,
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
						LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				WHERE
					' . $filtro_base . ''
			);
			
			$query = $query->result_array();
			return $query;
		}
		
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