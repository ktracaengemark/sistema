<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Comissao_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

	public function valida_comissao() {

		$com_vend 	= FALSE;
		$com_ass 	= FALSE;
		$com_super 	= FALSE;
		$com_serv 	= FALSE;
		
		if($_SESSION['log']['idSis_Empresa'] != 5){
			if($_SESSION['Usuario']['Rel_Com'] == "S"){
				if($_SESSION['Empresa']['EComerce'] == "S"){	
					if($_SESSION['Empresa']['Rede'] == "S"){
						
						if($_SESSION['Usuario']['Nivel'] == 2){
							$com_vend 	= TRUE;
						}elseif($_SESSION['Usuario']['Nivel'] == 1){
							$com_vend 	= TRUE;
							$com_super 	= TRUE;
							$com_serv 	= TRUE;
						}else{
							$com_vend 	= TRUE;
							$com_ass 	= TRUE;
							$com_super 	= TRUE;
							$com_serv 	= TRUE;
						}
					}else{
						$com_vend 	= TRUE;
						$com_ass 	= TRUE;
						$com_serv 	= TRUE;
					}
				}else{
					$com_vend 	= TRUE;
					$com_serv 	= TRUE;
				}
			}
		}else{
			$com_ass 	= TRUE;
		}

		$query = array(
			'com_vend' 	=> $com_vend,
			'com_ass' 	=> $com_ass,
			'com_super' => $com_super,
			'com_serv' 	=> $com_serv
		);
			
		return $query;
	}

    public function list_comissao($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE, $ajuste = FALSE, $antigo = FALSE) {

		$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($data['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($data['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $data['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
		
		if(isset($data['Quitado']) && $data['Quitado'] == "S"){
			$dataref = 'PR.DataPago';
		}else{
			$dataref = 'PR.DataVencimento';
		}
		
		$date_inicio_vnc_prc = ($data['DataInicio4']) ? ''.$dataref.' >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($data['DataFim4']) ? ''.$dataref.' <= "' . $data['DataFim4'] . '" AND ' : FALSE;
		
		$date_inicio_entrega_prd = ($data['DataInicio5']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio5'] . '" AND ' : FALSE;
		$date_fim_entrega_prd = ($data['DataFim5']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim5'] . '" AND ' : FALSE;

		$hora_inicio_entrega_prd = ($data['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $data['HoraInicio5'] . '" AND ' : FALSE;
		$hora_fim_entrega_prd = ($data['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $data['HoraFim5'] . '" AND ' : FALSE;

		$date_inicio_pag_com = ($data['DataInicio7']) ? 'OT.DataPagoComissaoOrca >= "' . $data['DataInicio7'] . '" AND ' : FALSE;
		$date_fim_pag_com = ($data['DataFim7']) ? 'OT.DataPagoComissaoOrca <= "' . $data['DataFim7'] . '" AND ' : FALSE;

		$orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
		$id_comissao = ($data['id_Comissao']) ? ' AND OT.id_Comissao = ' . $data['id_Comissao'] . '  ': FALSE;
		$cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] . '' : FALSE;
		$id_cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] . '' : FALSE;
		$tipofinandeiro = ($data['TipoFinanceiro']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$idtipord = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] : ' AND OT.idTab_TipoRD = 2';
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
		$filtro12 = ($data['StatusComissaoOrca']) ? 'OT.StatusComissaoOrca = "' . $data['StatusComissaoOrca'] . '" AND ' : FALSE;
		$filtro17 = ($data['id_Funcionario']) ? 'OT.id_Funcionario = "' . $data['id_Funcionario'] . '" AND ' : FALSE;

		if($_SESSION['log']['idSis_Empresa'] != 5){
			if($_SESSION['Empresa']['Rede'] == "S"){
				if($_SESSION['Usuario']['Nivel'] == 2){
					$nivel = 'AND OT.NivelOrca = 2';
					$permissao = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					$permissao_comissao = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}elseif($_SESSION['Usuario']['Nivel'] == 1){
					$nivel = FALSE;
					$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
						$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}else{
						$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}
					if($_SESSION['Usuario']['Permissao_Comissao'] == 1){
						$permissao_comissao = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}elseif($_SESSION['Usuario']['Permissao_Comissao'] == 2){
						$permissao_comissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}else{
						$permissao_comissao = FALSE;
					}
				}else{
					$nivel = FALSE;
					$permissao = FALSE;
					$permissao_orcam = FALSE;
					$permissao_comissao = FALSE;
				}
			}else{
				if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
					$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}else{
					$permissao_orcam = FALSE;
				}
				if($_SESSION['Usuario']['Permissao_Comissao'] == 1){
					$permissao_comissao = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}elseif($_SESSION['Usuario']['Permissao_Comissao'] == 2){
					$permissao_comissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}else{
					$permissao_comissao = FALSE;
				}
				$nivel = FALSE;
				$permissao = FALSE;
			}
			
			$produtos = ($data['Produtos']) ? 'PRDS.idSis_Empresa ' . $data['Produtos'] . ' AND' : FALSE;
			$parcelas = ($data['Parcelas']) ? 'PR.idSis_Empresa ' . $data['Parcelas'] . ' AND' : FALSE;

			if(isset($data['Recibo']) && $data['Recibo'] != 0){
				if($data['Recibo'] == 1){
					$recibo = 'OT.id_Comissao != 0 AND';
				}elseif($data['Recibo'] == 2){
					$recibo = 'OT.id_Comissao = 0 AND';
				}else{
					$recibo = FALSE;
				}
			}else{
				$recibo = FALSE;
			}

		}else{
			$permissao_orcam = FALSE;
			$permissao_comissao = FALSE;
			if(isset($data['metodo']) && $data['metodo'] == 3){
				$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao = FALSE;
			}
			$nivel = FALSE;
			$produtos = FALSE;
			$parcelas = FALSE;
			$recibo = FALSE;
		}

		$groupby = (isset($data['Agrupar']) && $data['Agrupar'] != "0") ? 'GROUP BY OT.' . $data['Agrupar'] . '' : 'GROUP BY OT.idApp_OrcaTrata';

        /*
		//echo $this->db->last_query();
		echo "<pre>";
		echo "<br>";
		print_r($rede);
		echo "</pre>";
		//exit();
		*/
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		if ($completo === FALSE) {
			$complemento = FALSE;
		} else {
			if($ajuste === FALSE){
				if($antigo === FALSE){
					$complemento = '
						AND OT.CanceladoOrca = "N" 
						AND OT.StatusComissaoOrca = "N" 
						AND OT.id_Comissao = 0 
					';
				}else{
					$complemento = '
						AND OT.CanceladoOrca = "N" 
						AND OT.StatusComissaoOrca = "S"
						AND OT.id_Comissao = 0 
					';
				}
			}else{
				$complemento = '
					AND OT.CanceladoOrca = "N" 
					AND OT.StatusComissaoOrca = "S" 
					AND OT.id_Comissao != 0 
				';
			}
		}
		
		if($ajuste === FALSE){		
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
					' . $date_inicio_pag_com . '
					' . $date_fim_pag_com . '
					' . $permissao . '
					' . $permissao_orcam . '
					' . $permissao_comissao . '
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
					' . $filtro12 . '
					' . $produtos . '
					' . $parcelas . '
					' . $recibo . '
					OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
					OT.id_Associado = 0  AND 
					OT.id_Funcionario != 0
					' . $orcamento . '
					' . $id_comissao . '
					' . $cliente . '
					' . $id_cliente . '
					' . $tipofinandeiro . ' 
					' . $idtipord . '
					' . $nivel . '
					' . $complemento . '
				' . $groupby . '
				ORDER BY
					' . $campo . '
					' . $ordenamento . '
				' . $querylimit . '
			';
		}else{
			$filtro_base = ' 
					OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
					OT.id_Associado = 0  AND 
					OT.id_Funcionario != 0
					' . $id_comissao . '
					' . $complemento . '
				' . $groupby . '
				ORDER BY
					' . $campo . '
					' . $ordenamento . '
				' . $querylimit . '
			';
		}
		
		####### Contagem e soma total ###########
		if($total == TRUE && $date == FALSE) {
			
			$query_total = $this->db->query(
				'SELECT
					OT.ValorFinalOrca,
					OT.ValorComissao,
					OT.ValorRestanteOrca
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . ''
			);
			
			$count = $query_total->num_rows();
			
			if(!isset($count)){
				return FALSE;
			}else{
				if($count >= 15001){
					return FALSE;
				}else{
					$somafinal2=0;
					$somacomissao2=0;
					$somarestante2=0;
					foreach ($query_total->result() as $row) {
						$somafinal2 += $row->ValorFinalOrca;
						$somacomissao2 += $row->ValorComissao;
						$somarestante2 += $row->ValorRestanteOrca;
					}
					
					$query_total->soma2 = new stdClass();
					$query_total->soma2->somafinal2 = number_format($somafinal2, 2, ',', '.');
					$query_total->soma2->somacomissao2 = number_format($somacomissao2, 2, ',', '.');
					$query_total->soma2->somarestante2 = number_format($somarestante2, 2, ',', '.');

					return $query_total;
				}
			}
		}

		####### Campos do Relat�rio/ Lista/ Excel ###########
		if($total == FALSE && $date == FALSE) {		
			$query = $this->db->query(
				'SELECT
					OT.idApp_OrcaTrata,
					OT.idSis_Usuario,
					OT.id_Funcionario,
					US.Nome,
					CONCAT(IFNULL(US.idSis_Usuario,""), " - " ,IFNULL(US.Nome,"")) AS NomeColaborador,
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
					OT.ValorComissao,
					OT.ValorFrete,
					OT.ValorExtraOrca,
					(OT.ValorExtraOrca + OT.ValorRestanteOrca + OT.ValorFrete) AS TotalOrca,
					OT.CashBackOrca,
					OT.idTab_TipoRD,
					OT.Tipo_Orca,
					OT.NomeRec,
					OT.ParentescoRec,
					OT.TelefoneRec,
					OT.StatusComissaoOrca,
					OT.DataPagoComissaoOrca,
					OT.id_Comissao,
					OT.Modalidade,
					OT.AVAP,
					OT.TipoFrete,
					OT.idApp_Cliente,
					CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
					CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
					C.CelularCliente,
					C.DataNascimento,
					C.Telefone,
					C.Telefone2,
					C.Telefone3,
					TFP.FormaPag,
					TR.TipoFinanceiro
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.id_Funcionario
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
				WHERE
					' . $filtro_base . ''
			);

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
			$somacomissao=0;
			
			foreach ($query->result() as $row) {
				
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataPagoComissaoOrca = $this->basico->mascara_data($row->DataPagoComissaoOrca, 'barras');

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
				$somacomissao += $row->ValorComissao;
				$row->ValorComissao = number_format($row->ValorComissao, 2, ',', '.');
			
				if($row->id_Comissao == 0){
					$row->id_Comissao = "";
				}
				
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
			$query->soma->somacomissao = number_format($somacomissao, 2, ',', '.');

			if(!isset($query)){
				return FALSE;
			} else {
				return $query;
			}
		}

		####### Ajuste de Valores da Baixa ###########
		if($total == FALSE && $date == TRUE) {
			$query = $this->db->query(
				'SELECT
					OT.idApp_OrcaTrata,
					OT.idSis_Usuario,
					OT.id_Funcionario,
					US.Nome,
					CONCAT(IFNULL(US.idSis_Usuario,""), " - " ,IFNULL(US.Nome,"")) AS NomeColaborador,
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
					OT.ValorComissao,
					OT.ValorFrete,
					OT.ValorExtraOrca,
					(OT.ValorExtraOrca + OT.ValorRestanteOrca + OT.ValorFrete) AS TotalOrca,
					OT.CashBackOrca,
					OT.idTab_TipoRD,
					OT.Tipo_Orca,
					OT.NomeRec,
					OT.ParentescoRec,
					OT.TelefoneRec,
					OT.StatusComissaoOrca,
					OT.DataPagoComissaoOrca,
					OT.id_Comissao,
					OT.Modalidade,
					OT.AVAP,
					OT.TipoFrete,
					OT.idApp_Cliente,
					CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
					CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
					C.CelularCliente,
					C.DataNascimento,
					C.Telefone,
					C.Telefone2,
					C.Telefone3,
					TFP.FormaPag,
					TR.TipoFinanceiro
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.id_Funcionario
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
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
		
		####### Baixa da comiss�o ###########
		if($total == TRUE && $date == TRUE) {

			$query = $this->db->query(
				'SELECT
					OT.idApp_OrcaTrata
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . ''
			);
		
			$query = $query->result_array();
	 
			return $query;
		}			
	
	}

    public function list_comissaoass($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE, $ajuste = FALSE) {

		$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($data['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($data['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $data['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
		
		if(isset($data['Quitado']) && $data['Quitado'] == "S"){
			$dataref = 'PR.DataPago';
		}else{
			$dataref = 'PR.DataVencimento';
		}
		
		$date_inicio_vnc_prc = ($data['DataInicio4']) ? ''.$dataref.' >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($data['DataFim4']) ? ''.$dataref.' <= "' . $data['DataFim4'] . '" AND ' : FALSE;
		
		$date_inicio_entrega_prd = ($data['DataInicio5']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio5'] . '" AND ' : FALSE;
		$date_fim_entrega_prd = ($data['DataFim5']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim5'] . '" AND ' : FALSE;

		$hora_inicio_entrega_prd = ($data['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $data['HoraInicio5'] . '" AND ' : FALSE;
		$hora_fim_entrega_prd = ($data['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $data['HoraFim5'] . '" AND ' : FALSE;

		$date_inicio_pag_com = ($data['DataInicio7']) ? 'OT.DataPagoComissaoOrca >= "' . $data['DataInicio7'] . '" AND ' : FALSE;
		$date_fim_pag_com = ($data['DataFim7']) ? 'OT.DataPagoComissaoOrca <= "' . $data['DataFim7'] . '" AND ' : FALSE;

		$orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
		$id_comissao = ($data['id_Comissao']) ? ' AND OT.id_Comissao = ' . $data['id_Comissao'] . '  ': FALSE;
		$cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] . '' : FALSE;
		$id_cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] . '' : FALSE;
		$tipofinandeiro = ($data['TipoFinanceiro']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$idtipord = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] : ' AND OT.idTab_TipoRD = 2';
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
		$filtro12 = ($data['StatusComissaoOrca']) ? 'OT.StatusComissaoOrca = "' . $data['StatusComissaoOrca'] . '" AND ' : FALSE;
		$filtro18 = ($data['id_Associado']) ? 'OT.id_Associado = "' . $data['id_Associado'] . '" AND ' : FALSE;

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

			if(isset($data['Recibo']) && $data['Recibo'] != 0){
				if($data['Recibo'] == 1){
					$recibo = 'OT.id_Comissao != 0 AND';
				}elseif($data['Recibo'] == 2){
					$recibo = 'OT.id_Comissao = 0 AND';
				}else{
					$recibo = FALSE;
				}
			}else{
				$recibo = FALSE;
			}

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
			$recibo = FALSE;
		}

		$groupby = (isset($data['Agrupar']) && $data['Agrupar'] != "0") ? 'GROUP BY OT.' . $data['Agrupar'] . '' : 'GROUP BY OT.idApp_OrcaTrata';

        /*
		//echo $this->db->last_query();
		echo "<pre>";
		echo "<br>";
		print_r($rede);
		echo "</pre>";
		//exit();
		*/
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		if ($completo === FALSE) {
			$complemento = FALSE;
		} else {
			if($ajuste === FALSE){
				$complemento = '
					AND OT.CanceladoOrca = "N" 
					AND OT.StatusComissaoOrca = "N" 
					AND OT.id_Comissao = 0 
				';			
			}else{
				$complemento = '
					AND OT.CanceladoOrca = "N" 
					AND OT.StatusComissaoOrca = "S" 
					AND OT.id_Comissao != 0 
				';
			}
		}
		
		if($ajuste === FALSE){
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
					' . $date_inicio_pag_com . '
					' . $date_fim_pag_com . '
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
					' . $filtro18 . '
					' . $filtro12 . '
					' . $produtos . '
					' . $parcelas . '
					' . $recibo . '
					OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					OT.id_Associado != 0 AND
					OT.id_Funcionario = 0
					' . $orcamento . '
					' . $id_comissao . '
					' . $cliente . '
					' . $id_cliente . '
					' . $tipofinandeiro . ' 
					' . $idtipord . '
					' . $nivel . '
					' . $complemento . '
				' . $groupby . '
				ORDER BY
					' . $campo . '
					' . $ordenamento . '
				' . $querylimit . '
			';
		}else{
			$filtro_base = ' 
					OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					OT.id_Associado != 0 AND
					OT.id_Funcionario = 0
					' . $id_comissao . '
					' . $complemento . '
				' . $groupby . '
				ORDER BY
					' . $campo . '
					' . $ordenamento . '
				' . $querylimit . '
			';
		}
		
		####### Contagem e soma total ###########
		if($total == TRUE && $date == FALSE) {
			$query_total = $this->db->query(
				'SELECT
					OT.ValorFinalOrca,
					OT.ValorComissaoAssoc,
					OT.ValorRestanteOrca
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . ''
			);
			
			$count = $query_total->num_rows();
			
			if(!isset($count)){
				return FALSE;
			}else{
				if($count >= 15001){
					return FALSE;
				}else{
					$somafinal2=0;
					$somacomissaoass2=0;
					$somarestante2=0;
					foreach ($query_total->result() as $row) {
						$somafinal2 += $row->ValorFinalOrca;
						$somacomissaoass2 += $row->ValorComissaoAssoc;
						$somarestante2 += $row->ValorRestanteOrca;
					}
					
					$query_total->soma2 = new stdClass();
					$query_total->soma2->somafinal2 = number_format($somafinal2, 2, ',', '.');
					$query_total->soma2->somacomissaoass2 = number_format($somacomissaoass2, 2, ',', '.');
					$query_total->soma2->somarestante2 = number_format($somarestante2, 2, ',', '.');

					return $query_total;
				}
			}
		}
			
		####### Campos do Relat�rio/ Lista/ Excel ###########
		if($total == FALSE && $date == FALSE) {	
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
					OT.ValorComissaoAssoc,
					OT.ValorFrete,
					OT.ValorExtraOrca,
					(OT.ValorExtraOrca + OT.ValorRestanteOrca + OT.ValorFrete) AS TotalOrca,
					OT.CashBackOrca,
					OT.idTab_TipoRD,
					OT.Tipo_Orca,
					OT.NomeRec,
					OT.ParentescoRec,
					OT.TelefoneRec,
					OT.StatusComissaoOrca,
					OT.DataPagoComissaoOrca,
					OT.id_Comissao,
					OT.Modalidade,
					OT.AVAP,
					OT.TipoFrete,
					OT.idApp_Cliente,
					CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
					CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
					C.CelularCliente,
					C.DataNascimento,
					C.Telefone,
					C.Telefone2,
					C.Telefone3,
					TFP.FormaPag,
					TR.TipoFinanceiro,
					ASS.Nome,
					CONCAT(IFNULL(ASS.idSis_Associado,""), " - " ,IFNULL(ASS.Nome,"")) AS NomeAssociado
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = OT.id_Associado
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
				WHERE
					' . $filtro_base . ''
			);

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
			$somacomissaoass=0;
			
			foreach ($query->result() as $row) {
				
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataPagoComissaoOrca = $this->basico->mascara_data($row->DataPagoComissaoOrca, 'barras');

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
				$somacomissaoass += $row->ValorComissaoAssoc;
				$row->ValorComissaoAssoc = number_format($row->ValorComissaoAssoc, 2, ',', '.');
			
				if($row->id_Comissao == 0){
					$row->id_Comissao = "";
				}
				
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
			$query->soma->somacomissaoass = number_format($somacomissaoass, 2, ',', '.');

			if(!isset($query)){
				return FALSE;
			} else {
				return $query;
			}
		}

		####### Ajuste de Valores da Baixa ###########
		if($total == FALSE && $date == TRUE) {
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
					OT.ValorComissaoAssoc,
					OT.ValorFrete,
					OT.ValorExtraOrca,
					(OT.ValorExtraOrca + OT.ValorRestanteOrca + OT.ValorFrete) AS TotalOrca,
					OT.CashBackOrca,
					OT.idTab_TipoRD,
					OT.Tipo_Orca,
					OT.NomeRec,
					OT.ParentescoRec,
					OT.TelefoneRec,
					OT.StatusComissaoOrca,
					OT.DataPagoComissaoOrca,
					OT.id_Comissao,
					OT.Modalidade,
					OT.AVAP,
					OT.TipoFrete,
					OT.idApp_Cliente,
					CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
					CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
					C.CelularCliente,
					C.DataNascimento,
					C.Telefone,
					C.Telefone2,
					C.Telefone3,
					TFP.FormaPag,
					TR.TipoFinanceiro,
					ASS.Nome,
					CONCAT(IFNULL(ASS.idSis_Associado,""), " - " ,IFNULL(ASS.Nome,"")) AS NomeAssociado
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = OT.id_Associado
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
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
		
		####### Baixa da comiss�o ###########
		if($total == TRUE && $date == TRUE) {
			$query = $this->db->query(
				'SELECT
					OT.idApp_OrcaTrata
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . ''
			);
		
			$query = $query->result_array();
	 
			return $query;
		
		}
		
	}		

    public function list_comissaofunc($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE, $ajuste = FALSE) {

		$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($data['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($data['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $data['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
		
		if(isset($data['Quitado']) && $data['Quitado'] == "S"){
			$dataref = 'PR.DataPago';
		}else{
			$dataref = 'PR.DataVencimento';
		}
		
		$date_inicio_vnc_prc = ($data['DataInicio4']) ? ''.$dataref.' >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($data['DataFim4']) ? ''.$dataref.' <= "' . $data['DataFim4'] . '" AND ' : FALSE;
		
		$date_inicio_entrega_prd = ($data['DataInicio5']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio5'] . '" AND ' : FALSE;
		$date_fim_entrega_prd = ($data['DataFim5']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim5'] . '" AND ' : FALSE;

		$hora_inicio_entrega_prd = ($data['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $data['HoraInicio5'] . '" AND ' : FALSE;
		$hora_fim_entrega_prd = ($data['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $data['HoraFim5'] . '" AND ' : FALSE;

		$date_inicio_pag_com = ($data['DataInicio7']) ? 'OT.DataPagoComissaoFunc >= "' . $data['DataInicio7'] . '" AND ' : FALSE;
		$date_fim_pag_com = ($data['DataFim7']) ? 'OT.DataPagoComissaoFunc <= "' . $data['DataFim7'] . '" AND ' : FALSE;

		$orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
		$id_comissaofunc = ($data['id_ComissaoFunc']) ? ' AND OT.id_ComissaoFunc = ' . $data['id_ComissaoFunc'] . '  ': FALSE;
		$cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] . '' : FALSE;
		$id_cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] . '' : FALSE;
		$tipofinandeiro = ($data['TipoFinanceiro']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$idtipord = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] : ' AND OT.idTab_TipoRD = 2';
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
		$filtro12 = ($data['StatusComissaoFunc']) ? 'OT.StatusComissaoFunc = "' . $data['StatusComissaoFunc'] . '" AND ' : FALSE;
		$filtro17 = ($data['id_Usuario']) ? 'OT.idSis_Usuario = "' . $data['id_Usuario'] . '" AND ' : FALSE;

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

			if(isset($data['Recibo']) && $data['Recibo'] != 0){
				if($data['Recibo'] == 1){
					$recibo = 'OT.id_ComissaoFunc != 0 AND';
				}elseif($data['Recibo'] == 2){
					$recibo = 'OT.id_ComissaoFunc = 0 AND';
				}else{
					$recibo = FALSE;
				}
			}else{
				$recibo = FALSE;
			}

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
			$recibo = FALSE;
		}

		$groupby = (isset($data['Agrupar']) && $data['Agrupar'] != "0") ? 'GROUP BY OT.' . $data['Agrupar'] . '' : 'GROUP BY OT.idApp_OrcaTrata';

        /*
		//echo $this->db->last_query();
		echo "<pre>";
		echo "<br>";
		print_r($rede);
		echo "</pre>";
		//exit();
		*/
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		if ($completo === FALSE) {
			$complemento = FALSE;
		} else {
			if($ajuste === FALSE){
				$complemento = '
					AND OT.CanceladoOrca = "N" 
					AND OT.StatusComissaoFunc = "N" 
					AND OT.id_ComissaoFunc = 0 
				';
			}else{
				$complemento = '
					AND OT.CanceladoOrca = "N" 
					AND OT.StatusComissaoFunc = "S" 
					AND OT.id_ComissaoFunc != 0 
				';
			}
		}

		if($ajuste === FALSE){
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
					' . $date_inicio_pag_com . '
					' . $date_fim_pag_com . '
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
					' . $filtro12 . '
					' . $produtos . '
					' . $parcelas . '
					' . $recibo . '
					OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . '
					' . $orcamento . '
					' . $id_comissaofunc . '
					' . $cliente . '
					' . $id_cliente . '
					' . $tipofinandeiro . ' 
					' . $idtipord . '
					' . $nivel . '
					' . $complemento . '
				' . $groupby . '
				ORDER BY
					' . $campo . '
					' . $ordenamento . '
				' . $querylimit . '
			';
		}else{
			$filtro_base = ' 
					OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . '
					' . $id_comissaofunc . '
					' . $complemento . '
				' . $groupby . '
				ORDER BY
					' . $campo . '
					' . $ordenamento . '
				' . $querylimit . '
			';
		}
		
		####### Contagem e soma total ###########
		if($total == TRUE && $date == FALSE) {
			
			$query_total = $this->db->query(
				'SELECT
					OT.ValorFinalOrca,
					OT.ValorComissaoFunc,
					OT.ValorRestanteOrca
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . ''
			);
			
			$count = $query_total->num_rows();
			
			if(!isset($count)){
				return FALSE;
			}else{
				if($count >= 15001){
					return FALSE;
				}else{
					$somafinal2=0;
					$somacomissaofunc2=0;
					$somarestante2=0;
					foreach ($query_total->result() as $row) {
						$somafinal2 += $row->ValorFinalOrca;
						$somacomissaofunc2 += $row->ValorComissaoFunc;
						$somarestante2 += $row->ValorRestanteOrca;
					}
					
					$query_total->soma2 = new stdClass();
					$query_total->soma2->somafinal2 = number_format($somafinal2, 2, ',', '.');
					$query_total->soma2->somacomissaofunc2 = number_format($somacomissaofunc2, 2, ',', '.');
					$query_total->soma2->somarestante2 = number_format($somarestante2, 2, ',', '.');

					return $query_total;
				}
			}
		}
		
		####### Campos do Relat�rio/ Lista/ Excel ###########
		if($total == FALSE && $date == FALSE) {	
			$query = $this->db->query(
				'SELECT
					OT.idApp_OrcaTrata,
					OT.idSis_Usuario,
					US.Nome,
					CONCAT(IFNULL(US.idSis_Usuario,""), " - " ,IFNULL(US.Nome,"")) AS NomeColaborador,
					OT.id_Associado,
					CONCAT(IFNULL(ASS.idSis_Associado,""), " - " ,IFNULL(ASS.Nome,"")) AS NomeAssociado,
					OT.id_Funcionario,
					CONCAT(IFNULL(UF.idSis_Usuario,""), " - " ,IFNULL(UF.Nome,"")) AS NomeFuncionario,
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
					OT.ValorComissao,
					OT.StatusComissaoOrca,
					OT.DataPagoComissaoOrca,
					OT.id_Comissao,
					OT.ValorComissaoFunc,
					OT.StatusComissaoFunc,
					OT.DataPagoComissaoFunc,
					OT.id_ComissaoFunc,
					OT.Modalidade,
					OT.AVAP,
					OT.TipoFrete,
					OT.idApp_Cliente,
					CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
					CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
					C.CelularCliente,
					C.DataNascimento,
					C.Telefone,
					C.Telefone2,
					C.Telefone3,
					TFP.FormaPag,
					TR.TipoFinanceiro
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UF ON UF.idSis_Usuario = OT.id_Funcionario
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = OT.id_Associado
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
				WHERE
					' . $filtro_base . ''
			);

			$somasubtotal=0;
			$subtotal=0;
			$somadesconto=0;
			$somarestante=0;
			$somasubcomissaofunc=0;
			$somaextra=0;
			$somafrete=0;
			$somatotal=0;
			$somadesc=0;
			$somacashback=0;
			$somafinal=0;
			$somacomissao=0;
			$somacomissaofunc=0;
			
			foreach ($query->result() as $row) {
				
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataPagoComissaoOrca = $this->basico->mascara_data($row->DataPagoComissaoOrca, 'barras');
				$row->DataPagoComissaoFunc = $this->basico->mascara_data($row->DataPagoComissaoFunc, 'barras');

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
				$somacomissao += $row->ValorComissao;
				$row->ValorComissao = number_format($row->ValorComissao, 2, ',', '.');
				$somacomissaofunc += $row->ValorComissaoFunc;
				$row->ValorComissaoFunc = number_format($row->ValorComissaoFunc, 2, ',', '.');
			
				if($row->id_Comissao == 0){
					$row->id_Comissao = "";
				}
			
				if($row->id_ComissaoFunc == 0){
					$row->id_ComissaoFunc = "";
				}
				
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
			$query->soma->somacomissao = number_format($somacomissao, 2, ',', '.');
			$query->soma->somacomissaofunc = number_format($somacomissaofunc, 2, ',', '.');

			if(!isset($query)){
				return FALSE;
			} else {
				return $query;
			}
		}

		####### Ajuste de Valores da Baixa ###########
		if($total == FALSE && $date == TRUE) {
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
					OT.ValorComissaoFunc,
					OT.ValorFrete,
					OT.ValorExtraOrca,
					(OT.ValorExtraOrca + OT.ValorRestanteOrca + OT.ValorFrete) AS TotalOrca,
					OT.CashBackOrca,
					OT.idTab_TipoRD,
					OT.Tipo_Orca,
					OT.NomeRec,
					OT.ParentescoRec,
					OT.TelefoneRec,
					OT.StatusComissaoFunc,
					OT.DataPagoComissaoFunc,
					OT.id_ComissaoFunc,
					OT.Modalidade,
					OT.AVAP,
					OT.TipoFrete,
					OT.idApp_Cliente,
					CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
					CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
					C.CelularCliente,
					C.DataNascimento,
					C.Telefone,
					C.Telefone2,
					C.Telefone3,
					US.Nome,
					CONCAT(IFNULL(US.idSis_Usuario,""), " - " ,IFNULL(US.Nome,"")) AS NomeColaborador,
					TFP.FormaPag,
					TR.TipoFinanceiro
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
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
		
		####### Baixa da comiss�o ###########
		if($total == TRUE && $date == TRUE) {

			$query = $this->db->query(
				'SELECT
					OT.idApp_OrcaTrata
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
				WHERE
					' . $filtro_base . ''
			);
		
			$query = $query->result_array();
	 
			return $query;
		}			

	}

	public function list_comissaoserv($data = FALSE, $completo = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE, $ajuste = FALSE) {

		$date_inicio_orca 		= ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca 			= ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega 	= ($data['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega 		= ($data['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $data['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_pg_com 	= ($data['DataInicio7']) ? 'PRDS.DataPagoComissaoServico >= "' . $data['DataInicio7'] . '" AND ' : FALSE;
		$date_fim_pg_com 		= ($data['DataFim7']) ? 'PRDS.DataPagoComissaoServico <= "' . $data['DataFim7'] . '" AND ' : FALSE;
		
		$date_inicio_prd_entr 	= ($data['DataInicio8']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio8'] . '" AND ' : FALSE;
		$date_fim_prd_entr 		= ($data['DataFim8']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim8'] . '" AND ' : FALSE;
		
		$Funcionario 			= ($data['Funcionario']) ? ' AND (UP1.idSis_Usuario = ' . $data['Funcionario'] . ' OR UP2.idSis_Usuario = ' . $data['Funcionario'] . ' OR UP3.idSis_Usuario = ' . $data['Funcionario'] . ' OR UP4.idSis_Usuario = ' . $data['Funcionario'] . ' )' : FALSE;
		$Orcamento 				= ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$id_gruposervico 		= ($data['id_GrupoServico']) ? ' AND PRDS.id_GrupoServico = ' . $data['id_GrupoServico'] . '  ': FALSE;
		$Cliente 				= ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
		$idApp_Cliente 			= ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
		$Produtos 				= ($data['Produtos']) ? ' AND PRDS.idTab_Produtos_Produto = ' . $data['Produtos'] : FALSE;
		$Categoria 				= ($data['Categoria']) ? ' AND TCAT.idTab_Catprod = ' . $data['Categoria'] : FALSE;
		$TipoFinanceiro 		= ($data['TipoFinanceiro']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
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
		$RecorrenciaOrca 		= ($data['RecorrenciaOrca']) ? 'OT.RecorrenciaOrca = "' . $data['RecorrenciaOrca'] . '" AND ' : FALSE;
		$permissao 				= ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$groupby 				= (1 == 1) ? 'GROUP BY PRDS.idApp_Produto' : FALSE;
		$Campo 					= (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
		$Ordenamento 			= (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];        
		
		$query4 				= ($data['idApp_ClientePet'] && isset($data['idApp_ClientePet'])) ? 'AND OT.idApp_ClientePet = ' . $data['idApp_ClientePet'] . '  ' : FALSE;
		$query42 				= ($data['idApp_ClientePet2'] && isset($data['idApp_ClientePet2'])) ? 'AND OT.idApp_ClientePet = ' . $data['idApp_ClientePet2'] . '  ' : FALSE;
		$query5 				= ($data['idApp_ClienteDep'] && isset($data['idApp_ClienteDep'])) ? 'AND OT.idApp_ClienteDep = ' . $data['idApp_ClienteDep'] . '  ' : FALSE;
		$query52 				= ($data['idApp_ClienteDep2'] && isset($data['idApp_ClienteDep2'])) ? 'AND OT.idApp_ClienteDep = ' . $data['idApp_ClienteDep2'] . '  ' : FALSE;			

		if(isset($data['Grupo']) && $data['Grupo'] != 0){
			if($data['Grupo'] == 1){
				$grupo = 'PRDS.id_GrupoServico != 0 AND';
			}elseif($data['Grupo'] == 2){
				$grupo = 'PRDS.id_GrupoServico = 0 AND';
			}else{
				$grupo = FALSE;
			}
		}else{
			$grupo = FALSE;
		}
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		if ($completo === FALSE) {
			$complemento = FALSE;
		} else {
			if($ajuste === FALSE){
				$complemento = '
					AND OT.CanceladoOrca = "N" 
					AND PRDS.StatusComissaoServico = "N" 
					AND PRDS.id_GrupoServico = 0 
				';				
			}else{
				$complemento = '
					AND OT.CanceladoOrca = "N" 
					AND PRDS.StatusComissaoServico = "S" 
					AND PRDS.id_GrupoServico != 0 
				';
			}
		}
		
		if($ajuste === FALSE){
			$filtro_base = '
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
					' . $RecorrenciaOrca . '
					' . $ConcluidoProduto . '
					' . $StatusComissaoServico . '
					' . $grupo . '
					OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					PRDS.Prod_Serv_Produto = "S" AND
					PRDS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
					' . $Orcamento . '
					' . $id_gruposervico . '
					' . $Cliente . '
					' . $idApp_Cliente . '
					' . $TipoFinanceiro . '
					' . $idTab_TipoRD . '
					' . $Produtos . '
					' . $Categoria . '
					' . $Funcionario . '
					' . $query4 . '
					' . $query42 . '
					' . $query5 . '
					' . $query52 . '
					' . $complemento . '
				' . $groupby . '
				ORDER BY
					' . $Campo . '
					' . $Ordenamento . '
				' . $querylimit . '
			';
		}else{
			$filtro_base = '
					OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					PRDS.Prod_Serv_Produto = "S" AND
					PRDS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
					' . $id_gruposervico . '
					' . $Funcionario . '
					' . $complemento . '
				' . $groupby . '
				ORDER BY
					' . $Campo . '
					' . $Ordenamento . '
				' . $querylimit . '
			';
		}

		####### Contagem e soma total ###########
		if($total == TRUE && $date == FALSE) {
			$query_total = $this->db->query(
				'SELECT
					PRDS.*,

					UP1.idSis_Usuario AS id_Usu_Prof_1,
					UP2.idSis_Usuario AS id_Usu_Prof_2,
					UP3.idSis_Usuario AS id_Usu_Prof_3,
					UP4.idSis_Usuario AS id_Usu_Prof_4,
					UP5.idSis_Usuario AS id_Usu_Prof_5,
					UP6.idSis_Usuario AS id_Usu_Prof_6,
					
					AF1.idTab_Funcao AS id_Fun_Prof_1,
					AF2.idTab_Funcao AS id_Fun_Prof_2,
					AF3.idTab_Funcao AS id_Fun_Prof_3,
					AF4.idTab_Funcao AS id_Fun_Prof_4,
					AF5.idTab_Funcao AS id_Fun_Prof_5,
					AF6.idTab_Funcao AS id_Fun_Prof_6,				
					
					AF1.Comissao_Funcao AS ComProf1,
					AF2.Comissao_Funcao AS ComProf2,
					AF3.Comissao_Funcao AS ComProf3,
					AF4.Comissao_Funcao AS ComProf4,
					AF5.Comissao_Funcao AS ComProf5,
					AF6.Comissao_Funcao AS ComProf6,
					
					CONCAT(IFNULL(UP1.Nome,"")) AS Nome1,				
					CONCAT(IFNULL(UP2.Nome,"")) AS Nome2,				
					CONCAT(IFNULL(UP3.Nome,"")) AS Nome3,
					CONCAT(IFNULL(UP4.Nome,"")) AS Nome4,
					CONCAT(IFNULL(UP5.Nome,"")) AS Nome5,
					CONCAT(IFNULL(UP6.Nome,"")) AS Nome6,

					CONCAT(IFNULL(TF1.Abrev,"")) AS Abrev1,				
					CONCAT(IFNULL(TF2.Abrev,"")) AS Abrev2,				
					CONCAT(IFNULL(TF3.Abrev,"")) AS Abrev3,
					CONCAT(IFNULL(TF4.Abrev,"")) AS Abrev4,
					CONCAT(IFNULL(TF5.Abrev,"")) AS Abrev5,
					CONCAT(IFNULL(TF6.Abrev,"")) AS Abrev6,
					
					TPRDS.idTab_Produtos,
					TPRDS.Nome_Prod,
					TCAT.idTab_Catprod,
					TCAT.Catprod
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_ClientePet AS CP ON CP.idApp_ClientePet = OT.idApp_ClientePet
						LEFT JOIN App_ClienteDep AS CD ON CD.idApp_ClienteDep = OT.idApp_ClienteDep
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata

						LEFT JOIN App_Funcao AS AF1 ON AF1.idApp_Funcao = PRDS.ProfissionalProduto_1
						LEFT JOIN App_Funcao AS AF2 ON AF2.idApp_Funcao = PRDS.ProfissionalProduto_2
						LEFT JOIN App_Funcao AS AF3 ON AF3.idApp_Funcao = PRDS.ProfissionalProduto_3
						LEFT JOIN App_Funcao AS AF4 ON AF4.idApp_Funcao = PRDS.ProfissionalProduto_4
						LEFT JOIN App_Funcao AS AF5 ON AF5.idApp_Funcao = PRDS.ProfissionalProduto_5
						LEFT JOIN App_Funcao AS AF6 ON AF6.idApp_Funcao = PRDS.ProfissionalProduto_6
						
						LEFT JOIN Tab_Funcao AS TF1 ON TF1.idTab_Funcao = AF1.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF2 ON TF2.idTab_Funcao = AF2.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF3 ON TF3.idTab_Funcao = AF3.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF4 ON TF4.idTab_Funcao = AF4.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF5 ON TF5.idTab_Funcao = AF5.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF6 ON TF6.idTab_Funcao = AF6.idTab_Funcao					
						
						
						LEFT JOIN Sis_Usuario AS UP1 ON UP1.idSis_Usuario = AF1.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP2 ON UP2.idSis_Usuario = AF2.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP3 ON UP3.idSis_Usuario = AF3.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP4 ON UP4.idSis_Usuario = AF4.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP5 ON UP5.idSis_Usuario = AF5.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP6 ON UP6.idSis_Usuario = AF6.idSis_Usuario
						
						LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
						LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
						LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
				WHERE
					' . $filtro_base . ''
			);
		
		
				$somafinal2=0;
				$somacomissao2=0;
				$Soma_Valor_Com_Total2=0;
				$Soma_Valor_Com_Total_Prof2=0;
				
				foreach ($query_total->result() as $row) {
					
					$valortotalproduto2 = $row->QtdProduto*$row->ValorProduto;
					$somafinal2 += $valortotalproduto2;					
				
					$Valor_Com_Total2 = $row->ValorComissaoServico;
					$Soma_Valor_Com_Total2 += $Valor_Com_Total2;					
					//$somacomissao2 += $row->ValorComissao;
				
					$valor_com_Prof_1 = $row->ValorComProf_1;
					$valor_com_Prof_2 = $row->ValorComProf_2;
					$valor_com_Prof_3 = $row->ValorComProf_3;
					$valor_com_Prof_4 = $row->ValorComProf_4;
					$valor_com_Prof_5 = $row->ValorComProf_5;
					$valor_com_Prof_6 = $row->ValorComProf_6;
				
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
						if($row->id_Usu_Prof_5 == $data['Funcionario']){
							$valor_com_filtro_Prof_5 = $valor_com_Prof_5;	
						}else{
							$valor_com_filtro_Prof_5 = 0.00;	
						}
						if($row->id_Usu_Prof_6 == $data['Funcionario']){
							$valor_com_filtro_Prof_6 = $valor_com_Prof_6;	
						}else{
							$valor_com_filtro_Prof_6 = 0.00;	
						}
					}else{
						$valor_com_filtro_Prof_1 = $valor_com_Prof_1;
						$valor_com_filtro_Prof_2 = $valor_com_Prof_2;
						$valor_com_filtro_Prof_3 = $valor_com_Prof_3;
						$valor_com_filtro_Prof_4 = $valor_com_Prof_4;
						$valor_com_filtro_Prof_5 = $valor_com_Prof_5;
						$valor_com_filtro_Prof_6 = $valor_com_Prof_6;
					}
					
					$Valor_Com_Total_Prof2 = ($valor_com_filtro_Prof_1 + $valor_com_filtro_Prof_2 + $valor_com_filtro_Prof_3 + $valor_com_filtro_Prof_4 + $valor_com_filtro_Prof_5 + $valor_com_filtro_Prof_6);
					$Soma_Valor_Com_Total_Prof2 += $Valor_Com_Total_Prof2;
					
					$row->valor_com_Prof_1 = number_format($valor_com_Prof_1, 2, ',', '.');
					$row->valor_com_Prof_2 = number_format($valor_com_Prof_2, 2, ',', '.');
					$row->valor_com_Prof_3 = number_format($valor_com_Prof_3, 2, ',', '.');
					$row->valor_com_Prof_4 = number_format($valor_com_Prof_4, 2, ',', '.');
					$row->valor_com_Prof_5 = number_format($valor_com_Prof_5, 2, ',', '.');
					$row->valor_com_Prof_6 = number_format($valor_com_Prof_6, 2, ',', '.');
					$row->Valor_Com_Total2 = number_format($Valor_Com_Total2, 2, ',', '.');	
					$row->Valor_Com_Total_Prof2 = number_format($Valor_Com_Total_Prof2, 2, ',', '.');					
						
	
				}
				
				$query_total->soma2 = new stdClass();
				$query_total->soma2->somafinal2 = number_format($somafinal2, 2, ',', '.');
				//$query_total->soma2->somacomissao2 = number_format($somacomissao2, 2, ',', '.');
				$query_total->soma2->Soma_Valor_Com_Total2 = number_format($Soma_Valor_Com_Total2, 2, ',', '.');
				$query_total->soma2->Soma_Valor_Com_Total_Prof2 = number_format($Soma_Valor_Com_Total_Prof2, 2, ',', '.');

				return $query_total;
			
			
		}

		####### Campos do Relat�rio/ Lista/ Excel ###########
		if($total == FALSE && $date == FALSE) {
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
					OT.RecorrenciaOrca,
					TR.TipoFinanceiro,
					MD.Modalidade,
					PRDS.*,
					(PRDS.QtdProduto * PRDS.QtdIncrementoProduto) AS QuantidadeProduto,
					UP1.idSis_Usuario AS id_Usu_Prof_1,
					UP2.idSis_Usuario AS id_Usu_Prof_2,
					UP3.idSis_Usuario AS id_Usu_Prof_3,
					UP4.idSis_Usuario AS id_Usu_Prof_4,
					UP5.idSis_Usuario AS id_Usu_Prof_5,
					UP6.idSis_Usuario AS id_Usu_Prof_6,
					
					AF1.idTab_Funcao AS id_Fun_Prof_1,
					AF2.idTab_Funcao AS id_Fun_Prof_2,
					AF3.idTab_Funcao AS id_Fun_Prof_3,
					AF4.idTab_Funcao AS id_Fun_Prof_4,
					AF5.idTab_Funcao AS id_Fun_Prof_5,
					AF6.idTab_Funcao AS id_Fun_Prof_6,				
					
					AF1.Comissao_Funcao AS ComProf1,
					AF2.Comissao_Funcao AS ComProf2,
					AF3.Comissao_Funcao AS ComProf3,
					AF4.Comissao_Funcao AS ComProf4,
					AF5.Comissao_Funcao AS ComProf5,
					AF6.Comissao_Funcao AS ComProf6,
					
					CONCAT(IFNULL(UP1.Nome,"")) AS Nome1,				
					CONCAT(IFNULL(UP2.Nome,"")) AS Nome2,				
					CONCAT(IFNULL(UP3.Nome,"")) AS Nome3,
					CONCAT(IFNULL(UP4.Nome,"")) AS Nome4,
					CONCAT(IFNULL(UP5.Nome,"")) AS Nome5,
					CONCAT(IFNULL(UP6.Nome,"")) AS Nome6,

					CONCAT(IFNULL(TF1.Abrev,"")) AS Abrev1,				
					CONCAT(IFNULL(TF2.Abrev,"")) AS Abrev2,				
					CONCAT(IFNULL(TF3.Abrev,"")) AS Abrev3,
					CONCAT(IFNULL(TF4.Abrev,"")) AS Abrev4,
					CONCAT(IFNULL(TF5.Abrev,"")) AS Abrev5,
					CONCAT(IFNULL(TF6.Abrev,"")) AS Abrev6,
					
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
						LEFT JOIN App_ClientePet AS CP ON CP.idApp_ClientePet = OT.idApp_ClientePet
						LEFT JOIN App_ClienteDep AS CD ON CD.idApp_ClienteDep = OT.idApp_ClienteDep
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata

						LEFT JOIN App_Funcao AS AF1 ON AF1.idApp_Funcao = PRDS.ProfissionalProduto_1
						LEFT JOIN App_Funcao AS AF2 ON AF2.idApp_Funcao = PRDS.ProfissionalProduto_2
						LEFT JOIN App_Funcao AS AF3 ON AF3.idApp_Funcao = PRDS.ProfissionalProduto_3
						LEFT JOIN App_Funcao AS AF4 ON AF4.idApp_Funcao = PRDS.ProfissionalProduto_4
						LEFT JOIN App_Funcao AS AF5 ON AF5.idApp_Funcao = PRDS.ProfissionalProduto_5
						LEFT JOIN App_Funcao AS AF6 ON AF6.idApp_Funcao = PRDS.ProfissionalProduto_6
						
						LEFT JOIN Tab_Funcao AS TF1 ON TF1.idTab_Funcao = AF1.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF2 ON TF2.idTab_Funcao = AF2.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF3 ON TF3.idTab_Funcao = AF3.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF4 ON TF4.idTab_Funcao = AF4.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF5 ON TF5.idTab_Funcao = AF5.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF6 ON TF6.idTab_Funcao = AF6.idTab_Funcao					
						
						
						LEFT JOIN Sis_Usuario AS UP1 ON UP1.idSis_Usuario = AF1.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP2 ON UP2.idSis_Usuario = AF2.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP3 ON UP3.idSis_Usuario = AF3.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP4 ON UP4.idSis_Usuario = AF4.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP5 ON UP5.idSis_Usuario = AF5.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP6 ON UP6.idSis_Usuario = AF6.idSis_Usuario
						
						LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
						LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
						LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
						LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
						LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
						LEFT JOIN Tab_AVAP AS TAV ON TAV.Abrev2 = OT.AVAP
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


			$Soma_valor_Total_Servicos=$Soma_Valor_Com_Total=$Soma_Valor_Com_Total_Prof=$somacomissaoprof=$somacomissaototal=$somaentregar=$somaentrada=$balanco=$ant=0;
            
			foreach ($query->result() as $row) {
				$row->Nome1 = (strlen($row->Nome1) > 8) ? substr($row->Nome1, 0, 8) : $row->Nome1;
				$row->Nome2 = (strlen($row->Nome2) > 8) ? substr($row->Nome2, 0, 8) : $row->Nome2;
				$row->Nome3 = (strlen($row->Nome3) > 8) ? substr($row->Nome3, 0, 8) : $row->Nome3;
				$row->Nome4 = (strlen($row->Nome4) > 8) ? substr($row->Nome4, 0, 8) : $row->Nome4;
				$row->Nome5 = (strlen($row->Nome5) > 8) ? substr($row->Nome5, 0, 8) : $row->Nome5;
				$row->Nome6 = (strlen($row->Nome6) > 8) ? substr($row->Nome6, 0, 8) : $row->Nome6;
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
				
				if($row->id_GrupoServico == 0){
					$row->Grupo = '';
				}else{
					$row->Grupo = $row->id_GrupoServico;
				}

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
				
				$valortotalproduto = $row->QtdProduto*$row->ValorProduto;
				$Soma_valor_Total_Servicos += $valortotalproduto;

				$valor_com_Prof_1 = $row->ValorComProf_1;
				$valor_com_Prof_2 = $row->ValorComProf_2;
				$valor_com_Prof_3 = $row->ValorComProf_3;
				$valor_com_Prof_4 = $row->ValorComProf_4;
				$valor_com_Prof_5 = $row->ValorComProf_5;
				$valor_com_Prof_6 = $row->ValorComProf_6;

				$Valor_Com_Total = $row->ValorComissaoServico;
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
					if($row->id_Usu_Prof_5 == $data['Funcionario']){
						$valor_com_filtro_Prof_5 = $valor_com_Prof_5;	
					}else{
						$valor_com_filtro_Prof_5 = 0.00;	
					}
					if($row->id_Usu_Prof_6 == $data['Funcionario']){
						$valor_com_filtro_Prof_6 = $valor_com_Prof_6;	
					}else{
						$valor_com_filtro_Prof_6 = 0.00;	
					}
				}else{
					$valor_com_filtro_Prof_1 = $valor_com_Prof_1;
					$valor_com_filtro_Prof_2 = $valor_com_Prof_2;
					$valor_com_filtro_Prof_3 = $valor_com_Prof_3;
					$valor_com_filtro_Prof_4 = $valor_com_Prof_4;
					$valor_com_filtro_Prof_5 = $valor_com_Prof_5;
					$valor_com_filtro_Prof_6 = $valor_com_Prof_6;	
				}
				
				$Valor_Com_Total_Prof = ($valor_com_filtro_Prof_1 + $valor_com_filtro_Prof_2 + $valor_com_filtro_Prof_3 + $valor_com_filtro_Prof_4 + $valor_com_filtro_Prof_5 + $valor_com_filtro_Prof_6);
				$Soma_Valor_Com_Total_Prof += $Valor_Com_Total_Prof;
				
				$row->valor_com_Prof_1 = number_format($valor_com_Prof_1, 2, ',', '.');
				$row->valor_com_Prof_2 = number_format($valor_com_Prof_2, 2, ',', '.');
				$row->valor_com_Prof_3 = number_format($valor_com_Prof_3, 2, ',', '.');
				$row->valor_com_Prof_4 = number_format($valor_com_Prof_4, 2, ',', '.');
				$row->valor_com_Prof_5 = number_format($valor_com_Prof_5, 2, ',', '.');
				$row->valor_com_Prof_6 = number_format($valor_com_Prof_6, 2, ',', '.');
				$row->Valor_Com_Total = number_format($Valor_Com_Total, 2, ',', '.');	
				$row->Valor_Com_Total_Prof = number_format($Valor_Com_Total_Prof, 2, ',', '.');						

				$row->ValorTotalProduto = number_format($valortotalproduto, 2, ',', '.');
				$row->ValorProduto = number_format($row->ValorProduto, 2, ',', '.');

				if($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}elseif($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}else{
					$row->Tipo_Orca = "Outros";
				}				

            }

            $query->soma = new stdClass();
            $query->soma->somaentregar = $somaentregar;
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->Soma_Valor_Com_Total = number_format($Soma_Valor_Com_Total, 2, ',', '.');
            $query->soma->Soma_Valor_Com_Total_Prof = number_format($Soma_Valor_Com_Total_Prof, 2, ',', '.');
            $query->soma->Soma_valor_Total_Servicos = number_format($Soma_valor_Total_Servicos, 2, ',', '.');
			
            return $query;
        }

		####### Ajuste de Valores da Baixa ###########
		if($total == FALSE && $date == TRUE) {
			$query = $this->db->query(
				'SELECT
					CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
					C.idApp_Cliente,
					C.CelularCliente,
					CONCAT(IFNULL(CPT.NomeClientePet,"")) AS NomeClientePet,
					CONCAT(IFNULL(CDP.NomeClienteDep,"")) AS NomeClienteDep,
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
					OT.RecorrenciaOrca,
					TR.TipoFinanceiro,
					MD.Modalidade,
					PRDS.*,
					(PRDS.QtdProduto * PRDS.QtdIncrementoProduto) AS QuantidadeProduto,
					
					UP1.idSis_Usuario AS id_Usu_Prof_1,
					UP2.idSis_Usuario AS id_Usu_Prof_2,
					UP3.idSis_Usuario AS id_Usu_Prof_3,
					UP4.idSis_Usuario AS id_Usu_Prof_4,
					UP5.idSis_Usuario AS id_Usu_Prof_5,
					UP6.idSis_Usuario AS id_Usu_Prof_6,				
					
					AF1.idTab_Funcao AS id_Fun_Prof_1,
					AF2.idTab_Funcao AS id_Fun_Prof_2,
					AF3.idTab_Funcao AS id_Fun_Prof_3,
					AF4.idTab_Funcao AS id_Fun_Prof_4,
					AF5.idTab_Funcao AS id_Fun_Prof_5,
					AF6.idTab_Funcao AS id_Fun_Prof_6,				
					
					AF1.Comissao_Funcao AS ComProf1,
					AF2.Comissao_Funcao AS ComProf2,
					AF3.Comissao_Funcao AS ComProf3,
					AF4.Comissao_Funcao AS ComProf4,
					AF5.Comissao_Funcao AS ComProf5,
					AF6.Comissao_Funcao AS ComProf6,
					
					CONCAT(IFNULL(TF1.Abrev,""), " || " ,IFNULL(UP1.Nome,"")) AS NomeProf1,				
					CONCAT(IFNULL(TF2.Abrev,""), " || " ,IFNULL(UP2.Nome,"")) AS NomeProf2,				
					CONCAT(IFNULL(TF3.Abrev,""), " || " ,IFNULL(UP3.Nome,"")) AS NomeProf3,
					CONCAT(IFNULL(TF4.Abrev,""), " || " ,IFNULL(UP4.Nome,"")) AS NomeProf4,
					CONCAT(IFNULL(TF5.Abrev,""), " || " ,IFNULL(UP5.Nome,"")) AS NomeProf5,
					CONCAT(IFNULL(TF6.Abrev,""), " || " ,IFNULL(UP6.Nome,"")) AS NomeProf6,
					
					CONCAT(IFNULL(PRDS.NomeProduto,"")) AS Receita,
					CONCAT(IFNULL(PRDS.QtdProduto,"")," x ", IFNULL(PRDS.ValorProduto,"")," x ", IFNULL(PRDS.ComissaoServicoProduto,""),"%") AS Valor,
					
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
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						
						LEFT JOIN App_Funcao AS AF1 ON AF1.idApp_Funcao = PRDS.ProfissionalProduto_1
						LEFT JOIN App_Funcao AS AF2 ON AF2.idApp_Funcao = PRDS.ProfissionalProduto_2
						LEFT JOIN App_Funcao AS AF3 ON AF3.idApp_Funcao = PRDS.ProfissionalProduto_3
						LEFT JOIN App_Funcao AS AF4 ON AF4.idApp_Funcao = PRDS.ProfissionalProduto_4
						LEFT JOIN App_Funcao AS AF5 ON AF5.idApp_Funcao = PRDS.ProfissionalProduto_5
						LEFT JOIN App_Funcao AS AF6 ON AF6.idApp_Funcao = PRDS.ProfissionalProduto_6
						
						LEFT JOIN Tab_Funcao AS TF1 ON TF1.idTab_Funcao = AF1.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF2 ON TF2.idTab_Funcao = AF2.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF3 ON TF3.idTab_Funcao = AF3.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF4 ON TF4.idTab_Funcao = AF4.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF5 ON TF5.idTab_Funcao = AF5.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF6 ON TF6.idTab_Funcao = AF6.idTab_Funcao
						
						
						LEFT JOIN Sis_Usuario AS UP1 ON UP1.idSis_Usuario = AF1.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP2 ON UP2.idSis_Usuario = AF2.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP3 ON UP3.idSis_Usuario = AF3.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP4 ON UP4.idSis_Usuario = AF4.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP5 ON UP5.idSis_Usuario = AF5.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP6 ON UP6.idSis_Usuario = AF6.idSis_Usuario
						
						LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
						LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
						LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
						LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
						LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
						LEFT JOIN Tab_AVAP AS TAV ON TAV.Abrev2 = OT.AVAP
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				WHERE
					' . $filtro_base . ''
			);

			foreach ($query->result() as $row) {
				$row->NomeCliente = (strlen($row->NomeCliente) > 12) ? substr($row->NomeCliente, 0, 12) : $row->NomeCliente;
				$row->NomeClientePet = (strlen($row->NomeClientePet) > 12) ? substr($row->NomeClientePet, 0, 12) : $row->NomeClientePet;
				$row->NomeClienteDep = (strlen($row->NomeClienteDep) > 12) ? substr($row->NomeClienteDep, 0, 12) : $row->NomeClienteDep;
			}

			$query = $query->result_array();
			return $query;
			
		}

		####### Baixa da comiss�o / Gerar Grupo ###########
		if($total == TRUE && $date == TRUE) {
			$query = $this->db->query(
				'SELECT
					PRDS.idApp_Produto
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_ClientePet AS CP ON CP.idApp_ClientePet = OT.idApp_ClientePet
						LEFT JOIN App_ClienteDep AS CD ON CD.idApp_ClienteDep = OT.idApp_ClienteDep
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata

						LEFT JOIN App_Funcao AS AF1 ON AF1.idApp_Funcao = PRDS.ProfissionalProduto_1
						LEFT JOIN App_Funcao AS AF2 ON AF2.idApp_Funcao = PRDS.ProfissionalProduto_2
						LEFT JOIN App_Funcao AS AF3 ON AF3.idApp_Funcao = PRDS.ProfissionalProduto_3
						LEFT JOIN App_Funcao AS AF4 ON AF4.idApp_Funcao = PRDS.ProfissionalProduto_4
						LEFT JOIN App_Funcao AS AF5 ON AF5.idApp_Funcao = PRDS.ProfissionalProduto_5
						LEFT JOIN App_Funcao AS AF6 ON AF6.idApp_Funcao = PRDS.ProfissionalProduto_6
						
						LEFT JOIN Tab_Funcao AS TF1 ON TF1.idTab_Funcao = AF1.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF2 ON TF2.idTab_Funcao = AF2.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF3 ON TF3.idTab_Funcao = AF3.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF4 ON TF4.idTab_Funcao = AF4.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF5 ON TF5.idTab_Funcao = AF5.idTab_Funcao
						LEFT JOIN Tab_Funcao AS TF6 ON TF6.idTab_Funcao = AF6.idTab_Funcao					
						
						
						LEFT JOIN Sis_Usuario AS UP1 ON UP1.idSis_Usuario = AF1.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP2 ON UP2.idSis_Usuario = AF2.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP3 ON UP3.idSis_Usuario = AF3.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP4 ON UP4.idSis_Usuario = AF4.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP5 ON UP5.idSis_Usuario = AF5.idSis_Usuario
						LEFT JOIN Sis_Usuario AS UP6 ON UP6.idSis_Usuario = AF6.idSis_Usuario
						
						LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
						LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
						LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
				WHERE
					' . $filtro_base . ''
			);
		
			$query = $query->result_array();
	 
			return $query;
		}
		
		####### Gerar Recibo da comiss�o Para cada funcion�rio ###########
		
    }

	public function list_grupos($data, $completo) {

        $data['Campo'] = (!$data['Campo']) ? 'OT.idApp_Grupos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                OT.idApp_Grupos,
				OT.DataOrca,
				OT.ValorExtraOrca,
				OT.Descricao
            FROM
                App_Grupos AS OT
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_TipoRD = 4
			ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

		foreach ($query->result() as $row) {
			$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
			$row->ValorExtraOrca = number_format($row->ValorExtraOrca, 2, ',', '.');
		}

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

    public function set_grupo($data) {

        $query = $this->db->insert('App_Grupos', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
		} else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	

    public function get_grupo($data) {
		$query = $this->db->query('
			SELECT  
				GR.*
			FROM 
				App_Grupos AS GR
			WHERE 
				GR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				GR.idApp_Grupos = ' . $data . ' 			
		
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

        //return $query[0];
		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }

    public function get_recibo($data) {
		$query = $this->db->query('
			SELECT  
				OT.idApp_OrcaTrata,
				OT.id_Funcionario,
				OT.id_Associado,
				OT.DataOrca,
				OT.Descricao,
				OT.ValorExtraOrca,
				OT.FinalizadoOrca,
				OT.QuitadoOrca
			FROM 
				App_OrcaTrata AS OT
			WHERE 
				OT.idApp_OrcaTrata = ' . $data . '  AND
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '			
		
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

        //return $query[0];
		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }
	
    public function update_grupo($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Grupos', $data, array('idApp_Grupos' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;
    }
	
    public function update_recibo($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_OrcaTrata', $data, array('idApp_OrcaTrata' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;
    }
	
}