<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Receitas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }
	
    public function list_pedidos_pesquisar($data, $completo) {
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
				OT.idTab_TipoRD = "2" 
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
	
    public function list_pedidos_combinar($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

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
		$Cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
		$id_Cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
		$TipoFinanceiro = ($data['TipoFinanceiroR']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
		$complemento = ' 
				AND OT.CombinadoFrete = "N"
			GROUP BY
				OT.idApp_OrcaTrata
			ORDER BY 
				PRD.DataConcluidoProduto ASC,
				PRD.HoraConcluidoProduto ASC,
				OT.idApp_OrcaTrata
		';

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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" 
				' . $Orcamento . '
				' . $Cliente . '
				' . $id_Cliente . '
				' . $TipoFinanceiro . '
				' . $nivel . '
				' . $complemento . '
			' . $querylimit . '
		';

		####Contagem e soma total ####
		if($total == TRUE) {
			$query = $this->db->query('
				SELECT 
					OT.idApp_OrcaTrata
				FROM 
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . '
			');
			return $query->num_rows();
		}

		if($total == FALSE) {
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
					' . $filtro_base . '
			');

			/*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

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

    public function list_pedidos_aprovar($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

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
		$Cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
		$id_Cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
		$TipoFinanceiro = ($data['TipoFinanceiroR']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
		$complemento = ' 
				AND OT.AprovadoOrca = "N"
			GROUP BY
				OT.idApp_OrcaTrata
			ORDER BY 
				PRD.DataConcluidoProduto ASC,
				PRD.HoraConcluidoProduto ASC,
				OT.idApp_OrcaTrata
		';

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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" 
				' . $Orcamento . '
				' . $Cliente . '
				' . $id_Cliente . '
				' . $TipoFinanceiro . '
				' . $nivel . '
				' . $complemento . '
			' . $querylimit . '
		';

		if($total == TRUE) {
			$query = $this->db->query('
				SELECT 
					OT.idApp_OrcaTrata
				FROM 
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . '
			');
			
			return $query->num_rows();
		}
		
		if($total == FALSE) {	  
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
					' . $filtro_base . '
			');

			/*
			  echo $this->db->last_query();
			  echo "<pre>";
			  print_r($query);
			  echo "</pre>";
			  exit();
			  */
			
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
	
    public function list_pedidos_producao($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

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
		$Cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
		$id_Cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
		$TipoFinanceiro = ($data['TipoFinanceiroR']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" 
				' . $Orcamento . '
				' . $Cliente . '
				' . $id_Cliente . '
				' . $TipoFinanceiro . '
				' . $nivel . '
				' . $complemento . '
			' . $querylimit . '
		';
			
		if($total == TRUE) {
			$query = $this->db->query('
				SELECT 
					OT.idApp_OrcaTrata
				FROM 
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . '
			');
			
			
			return $query->num_rows();
		}
		
		if($total == FALSE) {
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
					' . $filtro_base . '
			');

			/*
			  echo $this->db->last_query();
			  echo "<pre>";
			  print_r($query);
			  echo "</pre>";
			  exit();
			  */
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

    public function list_pedidos_envio($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

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
		$Cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
		$id_Cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
		$TipoFinanceiro = ($data['TipoFinanceiroR']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" 
				' . $Orcamento . '
				' . $Cliente . '
				' . $id_Cliente . '
				' . $TipoFinanceiro . '
				' . $nivel . '
				' . $complemento . '
			' . $querylimit . '
		';

		####Contagem e soma total ####
		if($total == TRUE) {
			$query = $this->db->query('
				SELECT 
					OT.idApp_OrcaTrata
				FROM 
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . '
			');
			return $query->num_rows();
		}
		
		if($total == FALSE) {
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
					' . $filtro_base . '
			');

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

    public function list_pedidos_entrega($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

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
		$Cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
		$id_Cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
		$TipoFinanceiro = ($data['TipoFinanceiroR']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" 
				' . $Orcamento . '
				' . $Cliente . '
				' . $id_Cliente . '
				' . $TipoFinanceiro . '
				' . $nivel . '
				' . $complemento . '
			' . $querylimit . '
		';

		####Contagem e soma total ####
		if($total == TRUE) {
			$query = $this->db->query('
				SELECT 
					OT.idApp_OrcaTrata
				FROM 
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . '
			');
			return $query->num_rows();
		}
		
		if($total == FALSE) {
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
					' . $filtro_base . '
			');

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

    public function list_pedidos_pagamento($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

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
		$Cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
		$id_Cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
		$TipoFinanceiro = ($data['TipoFinanceiroR']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
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

		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
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
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" 
				' . $Orcamento . '
				' . $Cliente . '
				' . $id_Cliente . '
				' . $TipoFinanceiro . '
				' . $nivel . '
				' . $complemento . '
			' . $querylimit . '
		';

		####Contagem e soma total ####
		if($total == TRUE) {
			$query = $this->db->query('
				SELECT 
					OT.idApp_OrcaTrata
				FROM 
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . '
			');
			return $query->num_rows();
		}
		
		if($total == FALSE) {		
        
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
					' . $filtro_base . '
			');
	
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
