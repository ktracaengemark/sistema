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
	
    public function list_despesas_pagonline($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
		'(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca  <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca  >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca  >= "' . $data['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '")';
        }

        if ($data['DataFim4']) {
            $consulta4 =
                '(PR.DataVencimento >= "' . $data['DataInicio4'] . '" AND PR.DataVencimento <= "' . $data['DataFim4'] . '")';
        }
        else {
            $consulta4 =
                '(PR.DataVencimento >= "' . $data['DataInicio4'] . '")';
        }		
		
		$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($data['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($data['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $data['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($data['DataInicio4']) ? 'PR.DataVencimento >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($data['DataFim4']) ? 'PR.DataVencimento <= "' . $data['DataFim4'] . '" AND ' : FALSE;
		
		$data['selecione'] = $data['selecione'];
		$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$data['Fornecedor'] = ($data['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'] : FALSE;
		$data['idApp_Fornecedor'] = ($data['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['idApp_Fornecedor'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
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
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
		}else{
			if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
				$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao_orcam = FALSE;
			}
			$permissao = FALSE;
		}
				
		//$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		//$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        $query = $this->db->query('
			' . $data['selecione'] . '
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
				OT.idTab_TipoRD = "1" AND
				OT.CanceladoOrca = "S"
                ' . $data['Orcamento'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Fornecedor'] . '
                ' . $data['TipoFinanceiroD'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
		');

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
    
	public function list_despesas_pesquisar($data, $completo) {

		$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;

		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
		}else{
			if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
				$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao_orcam = FALSE;
			}
			$permissao = FALSE;
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
                ' . $data['Orcamento'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.idApp_OrcaTrata ASC
				
		');

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
            foreach ($query->result() as $row) {
            }
            return $query;
        }		

    }
	
    public function list_despesas_combinar($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		if($data != FALSE){
			
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
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($data['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($data['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
			$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
			$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
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
			
		}else{
			
			$date_inicio_orca = ($_SESSION['FiltroDespesas']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroDespesas']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroDespesas']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroDespesas']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroDespesas']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroDespesas']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroDespesas']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['HoraFim5'] . '" AND ' : FALSE;
			
			$hora_inicio_entrega_prd = ($_SESSION['FiltroDespesas']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroDespesas']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['HoraFim5'] . '" AND ' : FALSE;
				
			$date_inicio_vnc = ($_SESSION['FiltroDespesas']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroDespesas']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroDespesas']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroDespesas']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroDespesas']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroDespesas']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroDespesas']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroDespesas']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($_SESSION['FiltroDespesas']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($_SESSION['FiltroDespesas']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroDespesas']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroDespesas']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroDespesas']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroDespesas']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroDespesas']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($_SESSION['FiltroDespesas']['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroDespesas']['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroDespesas']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroDespesas']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroDespesas']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroDespesas']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroDespesas']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroDespesas']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroDespesas']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroDespesas']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroDespesas']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroDespesas']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroDespesas']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroDespesas']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroDespesas']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroDespesas']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroDespesas']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroDespesas']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroDespesas']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroDespesas']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroDespesas']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroDespesas']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroDespesas']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroDespesas']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroDespesas']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroDespesas']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroDespesas']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroDespesas']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroDespesas']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroDespesas']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroDespesas']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroDespesas']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroDespesas']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroDespesas']['CombinadoFrete'] . '" AND ' : FALSE;
			
		}
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
		}else{
			if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
				$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao_orcam = FALSE;
			}
			$permissao = FALSE;
		}

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		        
		$query = $this->db->query('
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
				OT.idTab_TipoRD = "1" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "N"
                ' . $data['Orcamento'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Fornecedor'] . '
                ' . $data['TipoFinanceiroD'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
			' . $querylimit . '
		');

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
			if($total == TRUE) {
				return $query->num_rows();
			}else{
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
    }

    public function list_despesas_aprovar($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		if($data != FALSE){
	
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
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($data['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($data['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
			$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
			$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
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
			
		}else{
			
			$date_inicio_orca = ($_SESSION['FiltroDespesas']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroDespesas']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroDespesas']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroDespesas']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroDespesas']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroDespesas']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroDespesas']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['HoraFim5'] . '" AND ' : FALSE;
			
			$date_inicio_vnc = ($_SESSION['FiltroDespesas']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroDespesas']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroDespesas']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroDespesas']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroDespesas']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroDespesas']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroDespesas']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroDespesas']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($_SESSION['FiltroDespesas']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($_SESSION['FiltroDespesas']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroDespesas']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroDespesas']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroDespesas']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroDespesas']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroDespesas']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($_SESSION['FiltroDespesas']['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroDespesas']['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroDespesas']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroDespesas']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroDespesas']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroDespesas']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroDespesas']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroDespesas']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroDespesas']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroDespesas']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroDespesas']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroDespesas']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroDespesas']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroDespesas']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroDespesas']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroDespesas']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroDespesas']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroDespesas']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroDespesas']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroDespesas']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroDespesas']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroDespesas']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroDespesas']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroDespesas']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroDespesas']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroDespesas']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroDespesas']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroDespesas']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroDespesas']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroDespesas']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroDespesas']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroDespesas']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroDespesas']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroDespesas']['CombinadoFrete'] . '" AND ' : FALSE;
			
		}
					
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
		}else{
			if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
				$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao_orcam = FALSE;
			}
			$permissao = FALSE;
		}

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		        
		$query = $this->db->query('
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
				OT.idTab_TipoRD = "1" AND
				OT.CanceladoOrca = "N" AND
				
				OT.AprovadoOrca = "N"
                ' . $data['Orcamento'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Fornecedor'] . '
                ' . $data['TipoFinanceiroD'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
			' . $querylimit . '
		');

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
			if($total == TRUE) {
				return $query->num_rows();
			}else{
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
    }	
	
    public function list_despesas_producao($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		if($data != FALSE){
	
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
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($data['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($data['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
			$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
			$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
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
			
		}else{
			
			$date_inicio_orca = ($_SESSION['FiltroDespesas']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroDespesas']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroDespesas']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroDespesas']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroDespesas']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroDespesas']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroDespesas']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['HoraFim5'] . '" AND ' : FALSE;
			
			$date_inicio_vnc = ($_SESSION['FiltroDespesas']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroDespesas']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroDespesas']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroDespesas']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroDespesas']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroDespesas']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroDespesas']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroDespesas']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($_SESSION['FiltroDespesas']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($_SESSION['FiltroDespesas']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroDespesas']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroDespesas']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroDespesas']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroDespesas']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroDespesas']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($_SESSION['FiltroDespesas']['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroDespesas']['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroDespesas']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroDespesas']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroDespesas']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroDespesas']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroDespesas']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroDespesas']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroDespesas']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroDespesas']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroDespesas']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroDespesas']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroDespesas']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroDespesas']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroDespesas']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroDespesas']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroDespesas']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroDespesas']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroDespesas']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroDespesas']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroDespesas']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroDespesas']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroDespesas']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroDespesas']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroDespesas']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroDespesas']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroDespesas']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroDespesas']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroDespesas']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroDespesas']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroDespesas']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroDespesas']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroDespesas']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroDespesas']['CombinadoFrete'] . '" AND ' : FALSE;
			
		}
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
		}else{
			if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
				$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao_orcam = FALSE;
			}
			$permissao = FALSE;
		}

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		      
        $query = $this->db->query('
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
				OT.idTab_TipoRD = "1" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				OT.ConcluidoOrca = "N" AND
				OT.ProntoOrca = "N" 
				
                ' . $data['Orcamento'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Fornecedor'] . '
                ' . $data['TipoFinanceiroD'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
			' . $querylimit . '
		');

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
			if($total == TRUE) {
				return $query->num_rows();
			}else{
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
		
    }

    public function list_despesas_envio($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		if($data != FALSE){
	
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
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($data['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($data['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
			$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
			$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
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
			
		}else{
			
			$date_inicio_orca = ($_SESSION['FiltroDespesas']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroDespesas']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroDespesas']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroDespesas']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroDespesas']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroDespesas']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroDespesas']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['HoraFim5'] . '" AND ' : FALSE;
			
			$date_inicio_vnc = ($_SESSION['FiltroDespesas']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroDespesas']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroDespesas']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroDespesas']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroDespesas']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroDespesas']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroDespesas']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroDespesas']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($_SESSION['FiltroDespesas']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($_SESSION['FiltroDespesas']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroDespesas']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroDespesas']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroDespesas']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroDespesas']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroDespesas']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($_SESSION['FiltroDespesas']['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroDespesas']['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroDespesas']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroDespesas']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroDespesas']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroDespesas']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroDespesas']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroDespesas']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroDespesas']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroDespesas']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroDespesas']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroDespesas']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroDespesas']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroDespesas']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroDespesas']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroDespesas']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroDespesas']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroDespesas']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroDespesas']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroDespesas']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroDespesas']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroDespesas']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroDespesas']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroDespesas']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroDespesas']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroDespesas']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroDespesas']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroDespesas']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroDespesas']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroDespesas']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroDespesas']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroDespesas']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroDespesas']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroDespesas']['CombinadoFrete'] . '" AND ' : FALSE;
			
		}
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
		}else{
			if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
				$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao_orcam = FALSE;
			}
			$permissao = FALSE;
		}

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		      
        $query = $this->db->query('
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
				OT.idTab_TipoRD = "1" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				OT.ConcluidoOrca = "N" AND
				OT.ProntoOrca = "S" AND
				OT.EnviadoOrca = "N"
				
                ' . $data['Orcamento'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Fornecedor'] . '
                ' . $data['TipoFinanceiroD'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
			' . $querylimit . '
		');

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
			if($total == TRUE) {
				return $query->num_rows();
			}else{
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

    }

    public function list_despesas_entrega($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		if($data != FALSE){
	
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
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($data['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($data['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
			$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
			$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
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
			
		}else{
			
			$date_inicio_orca = ($_SESSION['FiltroDespesas']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroDespesas']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroDespesas']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroDespesas']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroDespesas']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroDespesas']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroDespesas']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['HoraFim5'] . '" AND ' : FALSE;
			
			$date_inicio_vnc = ($_SESSION['FiltroDespesas']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroDespesas']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroDespesas']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroDespesas']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroDespesas']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroDespesas']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroDespesas']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroDespesas']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($_SESSION['FiltroDespesas']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($_SESSION['FiltroDespesas']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroDespesas']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroDespesas']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroDespesas']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroDespesas']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroDespesas']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($_SESSION['FiltroDespesas']['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroDespesas']['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroDespesas']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroDespesas']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroDespesas']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroDespesas']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroDespesas']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroDespesas']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroDespesas']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroDespesas']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroDespesas']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroDespesas']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroDespesas']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroDespesas']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroDespesas']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroDespesas']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroDespesas']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroDespesas']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroDespesas']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroDespesas']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroDespesas']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroDespesas']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroDespesas']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroDespesas']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroDespesas']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroDespesas']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroDespesas']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroDespesas']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroDespesas']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroDespesas']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroDespesas']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroDespesas']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroDespesas']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroDespesas']['CombinadoFrete'] . '" AND ' : FALSE;
			
		}
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
		}else{
			if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
				$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao_orcam = FALSE;
			}
			$permissao = FALSE;
		}

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		    
        $query = $this->db->query('
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
				OT.idTab_TipoRD = "1" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				OT.ConcluidoOrca = "N" 
				
                ' . $data['Orcamento'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Fornecedor'] . '
                ' . $data['TipoFinanceiroD'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
			' . $querylimit . '
		');

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
			if($total == TRUE) {
				return $query->num_rows();
			}else{
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
    }

    public function list_despesas_pagamento($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		if($data != FALSE){
	
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
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($data['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($data['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
			$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
			$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
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
			
		}else{
			
			$date_inicio_orca = ($_SESSION['FiltroDespesas']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroDespesas']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroDespesas']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroDespesas']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroDespesas']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroDespesas']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroDespesas']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroDespesas']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroDespesas']['HoraFim5'] . '" AND ' : FALSE;
			
			$date_inicio_vnc = ($_SESSION['FiltroDespesas']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroDespesas']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroDespesas']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroDespesas']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroDespesas']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroDespesas']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroDespesas']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroDespesas']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroDespesas']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcamento'] : FALSE;
			$data['Fornecedor'] = ($_SESSION['FiltroDespesas']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['Fornecedor'] : FALSE;
			$data['idApp_Fornecedor'] = ($_SESSION['FiltroDespesas']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroDespesas']['idApp_Fornecedor'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroDespesas']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroDespesas']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroDespesas']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroDespesas']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroDespesas']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroDespesas']['Ano'] : FALSE;		
			$data['TipoFinanceiroD'] = ($_SESSION['FiltroDespesas']['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroDespesas']['TipoFinanceiroD'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroDespesas']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroDespesas']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroDespesas']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroDespesas']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroDespesas']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroDespesas']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroDespesas']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroDespesas']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroDespesas']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroDespesas']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroDespesas']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroDespesas']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroDespesas']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroDespesas']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroDespesas']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroDespesas']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroDespesas']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroDespesas']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroDespesas']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroDespesas']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroDespesas']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroDespesas']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroDespesas']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroDespesas']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroDespesas']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroDespesas']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroDespesas']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroDespesas']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroDespesas']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroDespesas']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroDespesas']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroDespesas']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroDespesas']['CombinadoFrete'] . '" AND ' : FALSE;
			
		}
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
		}else{
			if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
				$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao_orcam = FALSE;
			}
			$permissao = FALSE;
		}

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		       
        $query = $this->db->query('
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
				OT.idTab_TipoRD = "1" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				OT.QuitadoOrca = "N" AND
				PR.Quitado = "N"
                ' . $data['Orcamento'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Fornecedor'] . '
                ' . $data['TipoFinanceiroD'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				PR.DataVencimento ASC
			' . $querylimit . '
		');

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
			if($total == TRUE) {
				return $query->num_rows();
			}else{			
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
    }
	
}
