<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }
	
    public function list_pedidos_pagonline($data, $completo) {
		
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
		$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
		$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
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
				' . $filtro5 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				' . $filtro10 . '
				' . $filtro11 . '
				' . $filtro13 . '
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "S"
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['TipoFinanceiroR'] . '
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

    public function list_pedidos_pesquisar($data, $completo) {

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
				OT.idTab_TipoRD = "2" 
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
	
    public function list_pedidos_combinar($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
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
			$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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
			
			$date_inicio_orca = ($_SESSION['FiltroPedidos']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroPedidos']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroPedidos']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroPedidos']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroPedidos']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroPedidos']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroPedidos']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['HoraFim5'] . '" AND ' : FALSE;
				
			$date_inicio_vnc = ($_SESSION['FiltroPedidos']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroPedidos']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroPedidos']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroPedidos']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroPedidos']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroPedidos']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroPedidos']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroPedidos']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcamento'] : FALSE;
			$data['Cliente'] = ($_SESSION['FiltroPedidos']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($_SESSION['FiltroPedidos']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroPedidos']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroPedidos']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroPedidos']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroPedidos']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroPedidos']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($_SESSION['FiltroPedidos']['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroPedidos']['TipoFinanceiroR'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroPedidos']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroPedidos']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroPedidos']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroPedidos']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroPedidos']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroPedidos']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroPedidos']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroPedidos']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroPedidos']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroPedidos']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroPedidos']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroPedidos']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroPedidos']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroPedidos']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroPedidos']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroPedidos']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroPedidos']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroPedidos']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroPedidos']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroPedidos']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroPedidos']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroPedidos']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroPedidos']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroPedidos']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroPedidos']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroPedidos']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroPedidos']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroPedidos']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroPedidos']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroPedidos']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroPedidos']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroPedidos']['CombinadoFrete'] . '" AND ' : FALSE;
			
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
                C.idApp_Cliente,
				C.NomeCliente,
				C.CelularCliente,
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
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "N"
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['TipoFinanceiroR'] . '
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

    public function list_pedidos_aprovar($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
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
			$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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
			
			$date_inicio_orca = ($_SESSION['FiltroPedidos']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroPedidos']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroPedidos']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroPedidos']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroPedidos']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroPedidos']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroPedidos']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['HoraFim5'] . '" AND ' : FALSE;
			
			$date_inicio_vnc = ($_SESSION['FiltroPedidos']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroPedidos']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroPedidos']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroPedidos']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroPedidos']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroPedidos']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroPedidos']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroPedidos']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcamento'] : FALSE;
			$data['Cliente'] = ($_SESSION['FiltroPedidos']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($_SESSION['FiltroPedidos']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroPedidos']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroPedidos']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroPedidos']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroPedidos']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroPedidos']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($_SESSION['FiltroPedidos']['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroPedidos']['TipoFinanceiroR'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroPedidos']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroPedidos']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroPedidos']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroPedidos']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroPedidos']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroPedidos']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroPedidos']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroPedidos']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroPedidos']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroPedidos']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroPedidos']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroPedidos']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroPedidos']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroPedidos']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroPedidos']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroPedidos']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroPedidos']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroPedidos']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroPedidos']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroPedidos']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroPedidos']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroPedidos']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroPedidos']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroPedidos']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroPedidos']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroPedidos']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroPedidos']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroPedidos']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroPedidos']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroPedidos']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroPedidos']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroPedidos']['CombinadoFrete'] . '" AND ' : FALSE;
			
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
                C.idApp_Cliente,
				C.NomeCliente,
				C.CelularCliente,
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
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				
				OT.AprovadoOrca = "N"
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['TipoFinanceiroR'] . '
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
	
    public function list_pedidos_producao($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
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
			$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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
			
			$date_inicio_orca = ($_SESSION['FiltroPedidos']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroPedidos']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroPedidos']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroPedidos']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroPedidos']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroPedidos']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroPedidos']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['HoraFim5'] . '" AND ' : FALSE;
			
			$date_inicio_vnc = ($_SESSION['FiltroPedidos']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroPedidos']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroPedidos']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroPedidos']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroPedidos']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroPedidos']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroPedidos']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroPedidos']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcamento'] : FALSE;
			$data['Cliente'] = ($_SESSION['FiltroPedidos']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($_SESSION['FiltroPedidos']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroPedidos']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroPedidos']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroPedidos']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroPedidos']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroPedidos']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($_SESSION['FiltroPedidos']['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroPedidos']['TipoFinanceiroR'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroPedidos']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroPedidos']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroPedidos']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroPedidos']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroPedidos']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroPedidos']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroPedidos']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroPedidos']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroPedidos']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroPedidos']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroPedidos']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroPedidos']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroPedidos']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroPedidos']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroPedidos']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroPedidos']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroPedidos']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroPedidos']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroPedidos']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroPedidos']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroPedidos']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroPedidos']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroPedidos']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroPedidos']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroPedidos']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroPedidos']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroPedidos']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroPedidos']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroPedidos']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroPedidos']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroPedidos']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroPedidos']['CombinadoFrete'] . '" AND ' : FALSE;
			
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
                C.idApp_Cliente,
				C.NomeCliente,
				C.CelularCliente,
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
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				OT.ConcluidoOrca = "N" AND
				OT.ProntoOrca = "N" 
				
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['TipoFinanceiroR'] . '
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

    public function list_pedidos_envio($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
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
			$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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
			
			$date_inicio_orca = ($_SESSION['FiltroPedidos']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroPedidos']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroPedidos']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroPedidos']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroPedidos']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroPedidos']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroPedidos']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['HoraFim5'] . '" AND ' : FALSE;
			
			$date_inicio_vnc = ($_SESSION['FiltroPedidos']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroPedidos']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroPedidos']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroPedidos']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroPedidos']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroPedidos']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroPedidos']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroPedidos']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcamento'] : FALSE;
			$data['Cliente'] = ($_SESSION['FiltroPedidos']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($_SESSION['FiltroPedidos']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroPedidos']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroPedidos']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroPedidos']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroPedidos']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroPedidos']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($_SESSION['FiltroPedidos']['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroPedidos']['TipoFinanceiroR'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroPedidos']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroPedidos']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroPedidos']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroPedidos']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroPedidos']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroPedidos']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroPedidos']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroPedidos']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroPedidos']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroPedidos']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroPedidos']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroPedidos']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroPedidos']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroPedidos']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroPedidos']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroPedidos']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroPedidos']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroPedidos']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroPedidos']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroPedidos']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroPedidos']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroPedidos']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroPedidos']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroPedidos']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroPedidos']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroPedidos']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroPedidos']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroPedidos']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroPedidos']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroPedidos']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroPedidos']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroPedidos']['CombinadoFrete'] . '" AND ' : FALSE;
			
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
                C.idApp_Cliente,
				C.NomeCliente,
				C.CelularCliente,
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
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				OT.ConcluidoOrca = "N" AND
				OT.ProntoOrca = "S" AND
				OT.EnviadoOrca = "N" 
				
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['TipoFinanceiroR'] . '
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

    public function list_pedidos_entrega($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
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
			$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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
			
			$date_inicio_orca = ($_SESSION['FiltroPedidos']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroPedidos']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroPedidos']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroPedidos']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroPedidos']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroPedidos']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroPedidos']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['HoraFim5'] . '" AND ' : FALSE;
			
			$date_inicio_vnc = ($_SESSION['FiltroPedidos']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroPedidos']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroPedidos']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroPedidos']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroPedidos']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroPedidos']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroPedidos']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroPedidos']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcamento'] : FALSE;
			$data['Cliente'] = ($_SESSION['FiltroPedidos']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($_SESSION['FiltroPedidos']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroPedidos']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroPedidos']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroPedidos']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroPedidos']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroPedidos']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($_SESSION['FiltroPedidos']['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroPedidos']['TipoFinanceiroR'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroPedidos']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroPedidos']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroPedidos']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroPedidos']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroPedidos']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroPedidos']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroPedidos']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroPedidos']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroPedidos']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroPedidos']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroPedidos']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroPedidos']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroPedidos']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroPedidos']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroPedidos']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroPedidos']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroPedidos']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroPedidos']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroPedidos']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroPedidos']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroPedidos']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroPedidos']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroPedidos']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroPedidos']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroPedidos']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroPedidos']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroPedidos']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroPedidos']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroPedidos']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroPedidos']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroPedidos']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroPedidos']['CombinadoFrete'] . '" AND ' : FALSE;
			
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
                C.idApp_Cliente,
				C.NomeCliente,
				C.CelularCliente,
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
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				OT.ConcluidoOrca = "N" 
				
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['TipoFinanceiroR'] . '
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

    public function list_pedidos_pagamento($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
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
			$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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
			
			$date_inicio_orca = ($_SESSION['FiltroPedidos']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroPedidos']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroPedidos']['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($_SESSION['FiltroPedidos']['DataInicio2']) ? 'PRD.DataConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($_SESSION['FiltroPedidos']['DataFim2']) ? 'PRD.DataConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($_SESSION['FiltroPedidos']['HoraInicio5']) ? 'PRD.HoraConcluidoProduto >= "' . $_SESSION['FiltroPedidos']['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($_SESSION['FiltroPedidos']['HoraFim5']) ? 'PRD.HoraConcluidoProduto <= "' . $_SESSION['FiltroPedidos']['HoraFim5'] . '" AND ' : FALSE;
				
			$date_inicio_vnc = ($_SESSION['FiltroPedidos']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroPedidos']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($_SESSION['FiltroPedidos']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroPedidos']['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($_SESSION['FiltroPedidos']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroPedidos']['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($_SESSION['FiltroPedidos']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroPedidos']['DataFim4'] . '" AND ' : FALSE;
			
			//$data['selecione'] = $data['selecione'];
			$data['Orcamento'] = ($_SESSION['FiltroPedidos']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcamento'] : FALSE;
			$data['Cliente'] = ($_SESSION['FiltroPedidos']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['Cliente'] : FALSE;
			$data['idApp_Cliente'] = ($_SESSION['FiltroPedidos']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroPedidos']['idApp_Cliente'] : FALSE;		
			$data['Dia'] = ($_SESSION['FiltroPedidos']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroPedidos']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Mesvenc'] : FALSE;
			$data['Mespag'] = ($_SESSION['FiltroPedidos']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroPedidos']['Mespag'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroPedidos']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroPedidos']['Ano'] : FALSE;		
			$data['TipoFinanceiroR'] = ($_SESSION['FiltroPedidos']['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroPedidos']['TipoFinanceiroR'] : FALSE;
			$data['ObsOrca'] = ($_SESSION['FiltroPedidos']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['ObsOrca'] : FALSE;
			$data['Orcarec'] = ($_SESSION['FiltroPedidos']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroPedidos']['Orcarec'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroPedidos']['Campo']) ? 'PR.DataVencimento' : $_SESSION['FiltroPedidos']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroPedidos']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroPedidos']['Ordenamento'];
			$filtro1 = ($_SESSION['FiltroPedidos']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroPedidos']['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($_SESSION['FiltroPedidos']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroPedidos']['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($_SESSION['FiltroPedidos']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroPedidos']['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($_SESSION['FiltroPedidos']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroPedidos']['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($_SESSION['FiltroPedidos']['ConcluidoProduto']) ? 'PRD.ConcluidoProduto = "' . $_SESSION['FiltroPedidos']['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($_SESSION['FiltroPedidos']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroPedidos']['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($_SESSION['FiltroPedidos']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroPedidos']['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($_SESSION['FiltroPedidos']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroPedidos']['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($_SESSION['FiltroPedidos']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroPedidos']['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($_SESSION['FiltroPedidos']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroPedidos']['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($_SESSION['FiltroPedidos']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroPedidos']['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($_SESSION['FiltroPedidos']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroPedidos']['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($_SESSION['FiltroPedidos']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroPedidos']['CombinadoFrete'] . '" AND ' : FALSE;
			
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
                C.idApp_Cliente,
				C.NomeCliente,
				C.CelularCliente,
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
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				OT.QuitadoOrca = "N" AND
				PR.Quitado = "N"
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['TipoFinanceiroR'] . '
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
