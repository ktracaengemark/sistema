<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

	public function list_agendamentos($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		if($data != FALSE){

			$tipo = (isset($data['Tipo'])) ? $data['Tipo'] : '0';		
			if(isset($tipo)){
				if($tipo == 2){
					$tipoevento	= 'AND CO.Tipo = 2';	
				}elseif($tipo == 1){
					$tipoevento	= 'AND CO.Tipo = 1';
				}else{
					$tipoevento	= FALSE;
				}
			}else{
				$tipoevento	= FALSE;
			}
			
			$cliente = ($data['idApp_Cliente'] && isset($data['idApp_Cliente'])) ? 'AND CO.idApp_Cliente = ' . $data['idApp_Cliente'] . '  ' : FALSE;
			$clientepet = ($data['idApp_ClientePet'] && isset($data['idApp_ClientePet'])) ? 'AND CO.idApp_ClientePet = ' . $data['idApp_ClientePet'] . '  ' : FALSE;
			$clientepet2 = ($data['idApp_ClientePet2'] && isset($data['idApp_ClientePet2'])) ? 'AND CO.idApp_ClientePet = ' . $data['idApp_ClientePet2'] . '  ' : FALSE;
			$clientedep = ($data['idApp_ClienteDep'] && isset($data['idApp_ClienteDep'])) ? 'AND CO.idApp_ClienteDep = ' . $data['idApp_ClienteDep'] . '  ' : FALSE;
			$clientedep2 = ($data['idApp_ClienteDep2'] && isset($data['idApp_ClienteDep2'])) ? 'AND CO.idApp_ClienteDep = ' . $data['idApp_ClienteDep2'] . '  ' : FALSE;		
			$usuario 	= ($data['NomeUsuario']) ? ' AND ASS.idSis_Associado = ' . $data['NomeUsuario'] : FALSE;
			$recorrencia = ($data['Recorrencia'] && isset($data['Recorrencia'])) ? 'AND CO.Recorrencia = "' . $data['Recorrencia'] . '"  ' : FALSE;		
			$repeticao = ($data['Repeticao'] && isset($data['Repeticao'])) ? 'AND CO.Repeticao = "' . $data['Repeticao'] . '"  ' : FALSE;
			
			($data['DataInicio']) ? $date_inicio = $data['DataInicio'] : FALSE;
			($data['DataFim']) ? $date_fim = date('Y-m-d', strtotime('+1 days', strtotime($data['DataFim']))) : FALSE;

			$date_inicio_orca 	= ($data['DataInicio']) ? 'DataInicio >= "' . $date_inicio . '" AND ' : FALSE;
			$date_fim_orca 		= ($data['DataFim']) ? 'DataInicio <= "' . $date_fim . '" AND ' : FALSE;

			if(isset($data['Agrupar'])){
				if($data['Agrupar'] == 1){
					$agrupar = 'CO.idApp_Consulta';
				}elseif($data['Agrupar'] == 2){
					$agrupar = 'P.idApp_Produto';
				}else{
					$agrupar = 'CO.idApp_Consulta';
				}
			}else{
				$agrupar = 'CO.idApp_Consulta';
			}
			
			$campo 			= (!$data['Campo']) ? 'CO.DataInicio' : $data['Campo'];
			$ordenamento 	= (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
						
		}else{

			$tipo = (isset($_SESSION['Agendamentos']['Tipo'])) ? $_SESSION['Agendamentos']['Tipo'] : '0';		
			if(isset($tipo)){
				if($tipo == 2){
					$tipoevento	= 'AND CO.Tipo = 2';	
				}elseif($tipo == 1){
					$tipoevento	= 'AND CO.Tipo = 1';
				}else{
					$tipoevento	= FALSE;
				}
			}else{
				$tipoevento	= FALSE;
			}

			$cliente = ($_SESSION['Agendamentos']['idApp_Cliente'] && isset($_SESSION['Agendamentos']['idApp_Cliente'])) ? 'AND CO.idApp_Cliente = ' . $_SESSION['Agendamentos']['idApp_Cliente'] . '  ' : FALSE;
			$clientepet = ($_SESSION['Agendamentos']['idApp_ClientePet'] && isset($_SESSION['Agendamentos']['idApp_ClientePet'])) ? 'AND CO.idApp_ClientePet = ' . $_SESSION['Agendamentos']['idApp_ClientePet'] . '  ' : FALSE;
			$clientepet2 = ($_SESSION['Agendamentos']['idApp_ClientePet2'] && isset($_SESSION['Agendamentos']['idApp_ClientePet2'])) ? 'AND CO.idApp_ClientePet = ' . $_SESSION['Agendamentos']['idApp_ClientePet2'] . '  ' : FALSE;
			$clientedep = ($_SESSION['Agendamentos']['idApp_ClienteDep'] && isset($_SESSION['Agendamentos']['idApp_ClienteDep'])) ? 'AND CO.idApp_ClienteDep = ' . $_SESSION['Agendamentos']['idApp_ClienteDep'] . '  ' : FALSE;
			$clientedep2 = ($_SESSION['Agendamentos']['idApp_ClienteDep2'] && isset($_SESSION['Agendamentos']['idApp_ClienteDep2'])) ? 'AND CO.idApp_ClienteDep = ' . $_SESSION['Agendamentos']['idApp_ClienteDep2'] . '  ' : FALSE;		
			$usuario 	= ($_SESSION['Agendamentos']['NomeUsuario']) ? ' AND ASS.idSis_Associado = ' . $_SESSION['Agendamentos']['NomeUsuario'] : FALSE;
			$recorrencia = ($_SESSION['Agendamentos']['Recorrencia'] && isset($_SESSION['Agendamentos']['Recorrencia'])) ? 'AND CO.Recorrencia = "' . $_SESSION['Agendamentos']['Recorrencia'] . '"  ' : FALSE;		
			$repeticao = ($_SESSION['Agendamentos']['Repeticao'] && isset($_SESSION['Agendamentos']['Repeticao'])) ? 'AND CO.Repeticao = "' . $_SESSION['Agendamentos']['Repeticao'] . '"  ' : FALSE;
			
			($_SESSION['Agendamentos']['DataInicio']) ? $date_inicio = $_SESSION['Agendamentos']['DataInicio'] : FALSE;
			($_SESSION['Agendamentos']['DataFim']) ? $date_fim = date('Y-m-d', strtotime('+1 days', strtotime($_SESSION['Agendamentos']['DataFim']))) : FALSE;

			$date_inicio_orca 	= ($_SESSION['Agendamentos']['DataInicio']) ? 'DataInicio >= "' . $date_inicio . '" AND ' : FALSE;
			$date_fim_orca 		= ($_SESSION['Agendamentos']['DataFim']) ? 'DataInicio <= "' . $date_fim . '" AND ' : FALSE;

			if(isset($_SESSION['Agendamentos']['Agrupar'])){
				if($_SESSION['Agendamentos']['Agrupar'] == 1){
					$agrupar = 'CO.idApp_Consulta';
				}elseif($_SESSION['Agendamentos']['Agrupar'] == 2){
					$agrupar = 'P.idApp_Produto';
				}else{
					$agrupar = 'CO.idApp_Consulta';
				}
			}else{
				$agrupar = 'CO.idApp_Consulta';
			}
			
			$campo 			= (!$_SESSION['Agendamentos']['Campo']) ? 'CO.DataInicio' : $_SESSION['Agendamentos']['Campo'];
			$ordenamento 	= (!$_SESSION['Agendamentos']['Ordenamento']) ? 'ASC' : $_SESSION['Agendamentos']['Ordenamento'];
		
		}	
			
		$groupby = (isset($agrupar)) ? 'GROUP BY ' . $agrupar . '' : 'GROUP BY CO.idApp_Consulta';
					
		$permissao_agenda = ($_SESSION['log']['idSis_Empresa'] == 5) ? 'CO.idApp_Agenda = ' . $_SESSION['log']['Agenda'] . ' AND ' : FALSE;
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
				
		$query = $this->db->query('
			SELECT
				CO.*,
				CO.idSis_Empresa AS Empresa,
				DATE_FORMAT(CO.DataInicio, "%Y-%m-%d") AS DataInicio,
				DATE_FORMAT(CO.DataInicio, "%H:%i") AS HoraInicio,
				DATE_FORMAT(CO.DataFim, "%Y-%m-%d") AS DataFim,
				DATE_FORMAT(CO.DataFim, "%H:%i") AS HoraFim,
				P.idApp_Produto,
				P.NomeProduto,
				P.QtdProduto,
				P.ValorProduto,
				CONCAT(IFNULL(P.ObsProduto,"")) AS ObsProduto,
				(P.QtdProduto*P.ValorProduto) AS SubTotalProduto,
				DATE_FORMAT(P.DataConcluidoProduto, "%Y-%m-%d") AS DataProduto,
				DATE_FORMAT(P.HoraConcluidoProduto, "%H:%i") AS HoraProduto,
				CONCAT(IFNULL(TCAT.Catprod,"")) AS Catprod,
				C.idApp_Cliente AS id_Cliente,
				C.CelularCliente,
				CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
				CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente2,
				CP.*,
				CONCAT(IFNULL(CP.NomeClientePet,"")) AS NomeClientePet,
				RP.RacaPet,
				PEP.PeloPet,
				POP.PortePet,
				EPP.EspeciePet,
				CD.*,
				CONCAT(IFNULL(CD.NomeClienteDep,"")) AS NomeClienteDep,
				ASS.Nome
			FROM
				App_Consulta AS CO
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = CO.idApp_OrcaTrata
					LEFT JOIN App_Produto AS P ON P.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = P.idTab_Produtos_Produto
					LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
					LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
					LEFT JOIN App_Agenda AS A ON A.idApp_Agenda = CO.idApp_Agenda
					LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = A.idSis_Associado
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CO.idApp_Cliente
					LEFT JOIN App_ClientePet AS CP ON CP.idApp_ClientePet = CO.idApp_ClientePet
					LEFT JOIN Tab_RacaPet AS RP ON RP.idTab_RacaPet = CP.RacaPet
					LEFT JOIN Tab_PeloPet AS PEP ON PEP.idTab_PeloPet = CP.PeloPet
					LEFT JOIN Tab_PortePet AS POP ON POP.idTab_PortePet = CP.PortePet
					LEFT JOIN Tab_EspeciePet AS EPP ON EPP.idTab_EspeciePet = CP.EspeciePet
					LEFT JOIN App_ClienteDep AS CD ON CD.idApp_ClienteDep = CO.idApp_ClienteDep
			WHERE
				' . $date_inicio_orca . '
				' . $date_fim_orca . '
				' . $permissao_agenda . '
				CO.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				' . $tipoevento . '
				' . $cliente . '
				' . $clientepet . '
				' . $clientepet2 . '
				' . $clientedep . '
				' . $clientedep2 . '
				' . $recorrencia . '
				' . $repeticao . '
				' . $usuario . '
			' . $groupby . '
			ORDER BY
				' . $campo . '
				' . $ordenamento . '
			' . $querylimit . '
        ');

		if($total == TRUE) {
			return $query->num_rows();
		}
		
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

            $somareceber=0;
            foreach ($query->result() as $row) {
				//$row->HoraInicio = $this->basico->mascara_hora($row->DataInicio, 'hora');
				$row->DataInicio = $this->basico->mascara_data($row->DataInicio, 'barras');
				//$row->HoraFim = $this->basico->mascara_hora($row->DataFim, 'hora');
				$row->DataFim = $this->basico->mascara_data($row->DataFim, 'barras');
                $row->AlergicoPet = $this->basico->mascara_palavra_completa($row->AlergicoPet, 'NS');
				/*
				if($row->PeloPet == 1){
					$row->Pelo = "CURTO";
				}elseif($row->PeloPet == 2){
					$row->Pelo = "MÉDIO";
				}elseif($row->PeloPet == 3){
					$row->Pelo = "LONGO";
				}elseif($row->PeloPet == 4){
					$row->Pelo = "CACHEADO";
				}else{
					$row->Pelo = "N.I.";
				}
				
				if($row->PortePet == 1){
					$row->Porte = "MINI";
				}elseif($row->PortePet == 2){
					$row->Porte = "PEQUENO";
				}elseif($row->PortePet == 3){
					$row->Porte = "MÉDIO";
				}elseif($row->PortePet == 4){
					$row->Porte = "GRANDE";
				}elseif($row->PortePet == 5){
					$row->Porte = "GIGANTE";
				}else{
					$row->Porte = "N.I.";
				}
								
				if($row->EspeciePet == 1){
					$row->Especie = "CÃO";
				}elseif($row->EspeciePet == 2){
					$row->Especie = "GATO";
				}elseif($row->EspeciePet == 3){
					$row->Especie = "AVE";
				}else{
					$row->Especie = "N.I.";
				}
								
				if($row->SexoPet == "M"){
					$row->Sexo = "MACHO";
				}elseif($row->SexoPet == "F"){
					$row->Sexo = "FEMEA";
				}elseif($row->SexoPet == "O"){
					$row->Sexo = "OUT";
				}else{
					$row->Sexo = "N.I.";
				}				
				*/
				/*
				$data = DateTime::createFromFormat('d/m/Y H:i:s', $data);
				$data = $data->format('Y-m-d H:i:s');
				format('Y-m-d H:i:s');
				*/
				/*
				  echo $this->db->last_query();
				  echo "<pre>";
				  print_r($somaentrada);          
				  echo "</pre>";
				  exit();
				*/	
		  
            }	
			/*
			echo $this->db->last_query();
			echo "<pre>";
			print_r($balanco);
			echo "</pre>";
			exit();			
			*/
			
            $query->soma = new stdClass();
            //$query->soma->somareceber = number_format($somareceber, 2, ',', '.');
			
            return $query;
        }

    }

	public function list_procedimentos($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		if($data != FALSE){
					
			$date_inicio_prc = ($data['DataInicio9']) ? 'PRC.DataProcedimento >= "' . $data['DataInicio9'] . '" AND ' : FALSE;
			$date_fim_prc = ($data['DataFim9']) ? 'PRC.DataProcedimento <= "' . $data['DataFim9'] . '" AND ' : FALSE;
			
			$date_inicio_sub_prc = ($data['DataInicio10']) ? 'SPRC.DataSubProcedimento >= "' . $data['DataInicio10'] . '" AND ' : FALSE;
			$date_fim_sub_prc = ($data['DataFim10']) ? 'SPRC.DataSubProcedimento <= "' . $data['DataFim10'] . '" AND ' : FALSE;

			$hora_inicio_prc = ($data['HoraInicio9']) ? 'PRC.HoraProcedimento >= "' . $data['HoraInicio9'] . '" AND ' : FALSE;
			$hora_fim_prc = ($data['HoraFim9']) ? 'PRC.HoraProcedimento <= "' . $data['HoraFim9'] . '" AND ' : FALSE;
			
			$hora_inicio_sub_prc = ($data['HoraInicio10']) ? 'SPRC.HoraSubProcedimento >= "' . $data['HoraInicio10'] . '" AND ' : FALSE;
			$hora_fim_sub_prc = ($data['HoraFim10']) ? 'SPRC.HoraSubProcedimento <= "' . $data['HoraFim10'] . '" AND ' : FALSE;
			
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PRC.DataProcedimento) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PRC.DataProcedimento) = ' . $data['Mesvenc'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PRC.DataProcedimento) = ' . $data['Ano'] : FALSE;
			$data['Campo'] = (!$data['Campo']) ? 'PRC.DataProcedimento' : $data['Campo'];
			$data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
			
			$filtro10 = ($data['ConcluidoProcedimento'] != '#') ? 'PRC.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;
			
			$filtro21 = ($data['idTab_TipoRD'] == 1) ? 'AND (OT.idTab_TipoRD = "1" OR F.idApp_Fornecedor = PRC.idApp_Fornecedor)' : FALSE;
			$filtro22 = ($data['idTab_TipoRD'] == 2) ? 'AND (OT.idTab_TipoRD = "2" OR C.idApp_Cliente = PRC.idApp_Cliente)' : FALSE;
			
			$data['idApp_Procedimento'] = ($data['idApp_Procedimento']) ? ' AND PRC.idApp_Procedimento = ' . $data['idApp_Procedimento'] . '  ': FALSE;		
			$data['Sac'] = ($data['Sac']) ? ' AND PRC.Sac = ' . $data['Sac'] . '  ': FALSE;		
			$data['Marketing'] = ($data['Marketing']) ? ' AND PRC.Marketing = ' . $data['Marketing'] . '  ': FALSE;
			$data['Orcamento'] = ($data['Orcamento']) ? ' AND PRC.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
			$data['Cliente'] = ($data['Cliente']) ? ' AND PRC.idApp_Cliente = ' . $data['Cliente'] . '' : FALSE;
			$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND PRC.idApp_Cliente = ' . $data['idApp_Cliente'] . '' : FALSE;
			$data['Fornecedor'] = ($data['Fornecedor']) ? ' AND PRC.idApp_Fornecedor = ' . $data['Fornecedor'] . '' : FALSE;
			$data['idApp_Fornecedor'] = ($data['idApp_Fornecedor']) ? ' AND PRC.idApp_Cliente = ' . $data['idApp_Fornecedor'] . '' : FALSE;        
			$filtro17 = ($data['NomeUsuario']) ? 'PRC.idSis_Usuario = "' . $data['NomeUsuario'] . '" AND ' : FALSE;        
			$filtro18 = ($data['Compartilhar']) ? 'PRC.Compartilhar = "' . $data['Compartilhar'] . '" AND ' : FALSE;		
			
			$data['TipoProcedimento'] = $data['TipoProcedimento'];
			if($data['TipoProcedimento'] == 1){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata != 0 AND PRC.idApp_Cliente = 0 AND PRC.Sac = 0 AND PRC.Marketing = 0)';
			}elseif($data['TipoProcedimento'] == 2){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac = 0 AND PRC.Marketing = 0)';
			}elseif($data['TipoProcedimento'] == 3){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata = 0 AND PRC.idApp_Cliente != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac != 0 AND PRC.Marketing = 0)';
			}elseif($data['TipoProcedimento'] == 4){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata = 0 AND PRC.idApp_Cliente != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac = 0 AND PRC.Marketing != 0)';
			}
			$groupby = ($data['Agrupar'] && $data['Agrupar'] != "0") ? 'GROUP BY PRC.' . $data['Agrupar'] . '' : FALSE;
			
		}else{
					
			$date_inicio_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio9']) ? 'PRC.DataProcedimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio9'] . '" AND ' : FALSE;
			$date_fim_prc = ($_SESSION['FiltroAlteraParcela']['DataFim9']) ? 'PRC.DataProcedimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim9'] . '" AND ' : FALSE;
			
			$date_inicio_sub_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio10']) ? 'SPRC.DataSubProcedimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio10'] . '" AND ' : FALSE;
			$date_fim_sub_prc = ($_SESSION['FiltroAlteraParcela']['DataFim10']) ? 'SPRC.DataSubProcedimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim10'] . '" AND ' : FALSE;

			$hora_inicio_prc = ($_SESSION['FiltroAlteraParcela']['HoraInicio9']) ? 'PRC.HoraProcedimento >= "' . $_SESSION['FiltroAlteraParcela']['HoraInicio9'] . '" AND ' : FALSE;
			$hora_fim_prc = ($_SESSION['FiltroAlteraParcela']['HoraFim9']) ? 'PRC.HoraProcedimento <= "' . $_SESSION['FiltroAlteraParcela']['HoraFim9'] . '" AND ' : FALSE;
			
			$hora_inicio_sub_prc = ($_SESSION['FiltroAlteraParcela']['HoraInicio10']) ? 'SPRC.HoraSubProcedimento >= "' . $_SESSION['FiltroAlteraParcela']['HoraInicio10'] . '" AND ' : FALSE;
			$hora_fim_sub_prc = ($_SESSION['FiltroAlteraParcela']['HoraFim10']) ? 'SPRC.HoraSubProcedimento <= "' . $_SESSION['FiltroAlteraParcela']['HoraFim10'] . '" AND ' : FALSE;
			
			$data['Dia'] = ($_SESSION['FiltroAlteraParcela']['Dia']) ? ' AND DAY(PRC.DataProcedimento) = ' . $_SESSION['FiltroAlteraParcela']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroAlteraParcela']['Mesvenc']) ? ' AND MONTH(PRC.DataProcedimento) = ' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroAlteraParcela']['Ano']) ? ' AND YEAR(PRC.DataProcedimento) = ' . $_SESSION['FiltroAlteraParcela']['Ano'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'PRC.DataProcedimento' : $_SESSION['FiltroAlteraParcela']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'DESC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
			
			$filtro10 = ($_SESSION['FiltroAlteraParcela']['ConcluidoProcedimento'] != '#') ? 'PRC.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoProcedimento'] . '" AND ' : FALSE;
			
			$filtro21 = ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] == 1) ? 'AND (OT.idTab_TipoRD = "1" OR F.idApp_Fornecedor = PRC.idApp_Fornecedor)' : FALSE;
			$filtro22 = ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] == 2) ? 'AND (OT.idTab_TipoRD = "2" OR C.idApp_Cliente = PRC.idApp_Cliente)' : FALSE;
			
			$data['idApp_Procedimento'] = ($_SESSION['FiltroAlteraParcela']['idApp_Procedimento']) ? ' AND PRC.idApp_Procedimento = ' . $_SESSION['FiltroAlteraParcela']['idApp_Procedimento'] . '  ': FALSE;		
			$data['Sac'] = ($_SESSION['FiltroAlteraParcela']['Sac']) ? ' AND PRC.Sac = ' . $_SESSION['FiltroAlteraParcela']['Sac'] . '  ': FALSE;		
			$data['Marketing'] = ($_SESSION['FiltroAlteraParcela']['Marketing']) ? ' AND PRC.Marketing = ' . $_SESSION['FiltroAlteraParcela']['Marketing'] . '  ': FALSE;
			$data['Orcamento'] = ($_SESSION['FiltroAlteraParcela']['Orcamento']) ? ' AND PRC.idApp_OrcaTrata = ' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '  ': FALSE;
			$data['Cliente'] = ($_SESSION['FiltroAlteraParcela']['Cliente']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['Cliente'] . '' : FALSE;
			$data['idApp_Cliente'] = ($_SESSION['FiltroAlteraParcela']['idApp_Cliente']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] . '' : FALSE;
			$data['Fornecedor'] = ($_SESSION['FiltroAlteraParcela']['Fornecedor']) ? ' AND PRC.idApp_Fornecedor = ' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] . '' : FALSE;
			$data['idApp_Fornecedor'] = ($_SESSION['FiltroAlteraParcela']['idApp_Fornecedor']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] . '' : FALSE;        
			$filtro17 = ($_SESSION['FiltroAlteraParcela']['NomeUsuario']) ? 'PRC.idSis_Usuario = "' . $_SESSION['FiltroAlteraParcela']['NomeUsuario'] . '" AND ' : FALSE;        
			$filtro18 = ($_SESSION['FiltroAlteraParcela']['Compartilhar']) ? 'PRC.Compartilhar = "' . $_SESSION['FiltroAlteraParcela']['Compartilhar'] . '" AND ' : FALSE;		
			
			$data['TipoProcedimento'] = $_SESSION['FiltroAlteraParcela']['TipoProcedimento'];
			if($_SESSION['FiltroAlteraParcela']['TipoProcedimento'] == 1){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata != 0 AND PRC.idApp_Cliente = 0 AND PRC.Sac = 0 AND PRC.Marketing = 0)';
			}elseif($_SESSION['FiltroAlteraParcela']['TipoProcedimento'] == 2){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac = 0 AND PRC.Marketing = 0)';
			}elseif($_SESSION['FiltroAlteraParcela']['TipoProcedimento'] == 3){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata = 0 AND PRC.idApp_Cliente != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac != 0 AND PRC.Marketing = 0)';
			}elseif($_SESSION['FiltroAlteraParcela']['TipoProcedimento'] == 4){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata = 0 AND PRC.idApp_Cliente != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac = 0 AND PRC.Marketing != 0)';
			}
			$groupby = ($_SESSION['FiltroAlteraParcela']['Agrupar'] && $_SESSION['FiltroAlteraParcela']['Agrupar'] != "0") ? 'GROUP BY PRC.' . $_SESSION['FiltroAlteraParcela']['Agrupar'] . '' : FALSE;
					
		}	
		/*
		echo $this->db->last_query();
		echo "<pre>";
		print_r($groupby);
		echo "</pre>";
		exit();
        */ 
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
		$query = $this->db->query('
            SELECT
				PRC.idSis_Empresa,
				PRC.idApp_Procedimento,
                PRC.Procedimento,
				PRC.DataProcedimento,
				PRC.HoraProcedimento,
				PRC.ConcluidoProcedimento,
				PRC.idApp_Cliente,
				PRC.idApp_Fornecedor,
				PRC.idApp_OrcaTrata,
				PRC.Compartilhar,
				PRC.Sac,
				PRC.Marketing,
				SPRC.SubProcedimento,
				SPRC.ConcluidoSubProcedimento,
				SPRC.DataSubProcedimento,
				SPRC.HoraSubProcedimento,
				OT.idTab_TipoRD,
				CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
				CONCAT(IFNULL(F.NomeFornecedor,"")) AS NomeFornecedor,
				U.idSis_Usuario,
				U.CpfUsuario,
				U.Nome AS NomeUsuario,
				SU.idSis_Usuario,
				SU.Nome AS NomeSubUsuario,
				AU.idSis_Usuario,
				AU.Nome AS NomeCompartilhar
            FROM
				App_Procedimento AS PRC
					LEFT JOIN App_SubProcedimento AS SPRC ON SPRC.idApp_Procedimento = PRC.idApp_Procedimento
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PRC.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = PRC.idApp_Fornecedor
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = SPRC.idSis_Usuario
            WHERE
                ' . $date_inicio_prc . '
                ' . $date_fim_prc . '
                ' . $date_inicio_sub_prc . '
                ' . $date_fim_sub_prc . '
                ' . $hora_inicio_prc . '
                ' . $hora_fim_prc . '
                ' . $hora_inicio_sub_prc . '
                ' . $hora_fim_sub_prc . '
				PRC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $filtro10 . '
				' . $filtro17 . '
				' . $filtro18 . '
				' . $tipoprocedimento . ' 
                ' . $filtro21 . ' 
                ' . $filtro22 . '
                ' . $data['idApp_Procedimento'] . '
                ' . $data['Sac'] . '
                ' . $data['Marketing'] . '
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['idApp_Fornecedor'] . '
			' . $groupby . '
            ORDER BY
                ' . $data['Campo'] . ' 
				' . $data['Ordenamento'] . '
			' . $querylimit . '
		');

		if($total == TRUE) {
			return $query->num_rows();
		}
		
        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
				$row->DataSubProcedimento = $this->basico->mascara_data($row->DataSubProcedimento, 'barras');
				$row->ConcluidoSubProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoSubProcedimento, 'NS');
				
				if($row->Compartilhar == "0"){
					$row->NomeCompartilhar = 'Todos';
				}
				
				if($row->Sac == 1){
					$row->Sac = 'Solicitação';
				}elseif($row->Sac == 2){
					$row->Sac = 'Elogio';
				}elseif($row->Sac == 3){
					$row->Sac = 'Reclamação';
				}
				
				if($row->Marketing == 1){
					$row->Marketing = 'Atualização';
				}elseif($row->Marketing == 2){
					$row->Marketing = 'Pesquisa';
				}elseif($row->Marketing == 3){
					$row->Marketing = 'Retorno';
				}elseif($row->Marketing == 4){
					$row->Marketing = 'Promoções';
				}elseif($row->Marketing == 5){
					$row->Marketing = 'Felicitações';
				}
				
            }
          /*
		  //echo $this->db->last_query();
		  echo "<br>";
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
		  */
            return $query;
        }

    }

	public function list_sac($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		if($data != FALSE){
					
			$date_inicio_prc = ($data['DataInicio9']) ? 'PRC.DataSac >= "' . $data['DataInicio9'] . '" AND ' : FALSE;
			$date_fim_prc = ($data['DataFim9']) ? 'PRC.DataSac <= "' . $data['DataFim9'] . '" AND ' : FALSE;
			
			$date_inicio_sub_prc = ($data['DataInicio10']) ? 'SPRC.DataSubSac >= "' . $data['DataInicio10'] . '" AND ' : FALSE;
			$date_fim_sub_prc = ($data['DataFim10']) ? 'SPRC.DataSubSac <= "' . $data['DataFim10'] . '" AND ' : FALSE;

			$hora_inicio_prc = ($data['HoraInicio9']) ? 'PRC.HoraSac >= "' . $data['HoraInicio9'] . '" AND ' : FALSE;
			$hora_fim_prc = ($data['HoraFim9']) ? 'PRC.HoraSac <= "' . $data['HoraFim9'] . '" AND ' : FALSE;
			
			$hora_inicio_sub_prc = ($data['HoraInicio10']) ? 'SPRC.HoraSubSac >= "' . $data['HoraInicio10'] . '" AND ' : FALSE;
			$hora_fim_sub_prc = ($data['HoraFim10']) ? 'SPRC.HoraSubSac <= "' . $data['HoraFim10'] . '" AND ' : FALSE;
			
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PRC.DataSac) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PRC.DataSac) = ' . $data['Mesvenc'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PRC.DataSac) = ' . $data['Ano'] : FALSE;
			$data['Campo'] = (!$data['Campo']) ? 'PRC.DataSac' : $data['Campo'];
			$data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
			
			$filtro10 = ($data['ConcluidoSac'] != '#') ? 'PRC.ConcluidoSac = "' . $data['ConcluidoSac'] . '" AND ' : FALSE;
			
			$filtro21 = ($data['idTab_TipoRD'] == 1) ? 'AND (OT.idTab_TipoRD = "1" OR F.idApp_Fornecedor = PRC.idApp_Fornecedor)' : FALSE;
			$filtro22 = ($data['idTab_TipoRD'] == 2) ? 'AND (OT.idTab_TipoRD = "2" OR C.idApp_Cliente = PRC.idApp_Cliente)' : FALSE;
			
			$data['idApp_Sac'] = ($data['idApp_Sac']) ? ' AND PRC.idApp_Sac = ' . $data['idApp_Sac'] . '  ': FALSE;		
			$data['CategoriaSac'] = ($data['CategoriaSac']) ? ' AND PRC.CategoriaSac = ' . $data['CategoriaSac'] . '  ': FALSE;		
			$data['Marketing'] = ($data['Marketing']) ? ' AND PRC.Marketing = ' . $data['Marketing'] . '  ': FALSE;
			$data['Orcamento'] = ($data['Orcamento']) ? ' AND PRC.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
			$data['Cliente'] = ($data['Cliente']) ? ' AND PRC.idApp_Cliente = ' . $data['Cliente'] . '' : FALSE;
			$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND PRC.idApp_Cliente = ' . $data['idApp_Cliente'] . '' : FALSE;
			$data['Fornecedor'] = ($data['Fornecedor']) ? ' AND PRC.idApp_Fornecedor = ' . $data['Fornecedor'] . '' : FALSE;
			$data['idApp_Fornecedor'] = ($data['idApp_Fornecedor']) ? ' AND PRC.idApp_Cliente = ' . $data['idApp_Fornecedor'] . '' : FALSE;        
			$filtro17 = ($data['NomeUsuario']) ? 'PRC.idSis_Usuario = "' . $data['NomeUsuario'] . '" AND ' : FALSE;        
			$filtro18 = ($data['Compartilhar']) ? 'PRC.Compartilhar = "' . $data['Compartilhar'] . '" AND ' : FALSE;		
			
			$data['TipoSac'] = $data['TipoSac'];
			if($data['TipoSac'] == 1){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata != 0 AND PRC.idApp_Cliente = 0 AND PRC.Sac = 0 AND PRC.Marketing = 0)';
			}elseif($data['TipoSac'] == 2){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac = 0 AND PRC.Marketing = 0)';
			}elseif($data['TipoSac'] == 3){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata = 0 AND PRC.idApp_Cliente != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac != 0 AND PRC.Marketing = 0)';
			}elseif($data['TipoSac'] == 4){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata = 0 AND PRC.idApp_Cliente != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac = 0 AND PRC.Marketing != 0)';
			}
			$groupby = ($data['Agrupar'] && $data['Agrupar'] != "0") ? 'GROUP BY PRC.' . $data['Agrupar'] . '' : FALSE;
			
		}else{
					
			$date_inicio_prc = ($_SESSION['FiltroSac']['DataInicio9']) ? 'PRC.DataSac >= "' . $_SESSION['FiltroSac']['DataInicio9'] . '" AND ' : FALSE;
			$date_fim_prc = ($_SESSION['FiltroSac']['DataFim9']) ? 'PRC.DataSac <= "' . $_SESSION['FiltroSac']['DataFim9'] . '" AND ' : FALSE;
			
			$date_inicio_sub_prc = ($_SESSION['FiltroSac']['DataInicio10']) ? 'SPRC.DataSubSac >= "' . $_SESSION['FiltroSac']['DataInicio10'] . '" AND ' : FALSE;
			$date_fim_sub_prc = ($_SESSION['FiltroSac']['DataFim10']) ? 'SPRC.DataSubSac <= "' . $_SESSION['FiltroSac']['DataFim10'] . '" AND ' : FALSE;

			$hora_inicio_prc = ($_SESSION['FiltroSac']['HoraInicio9']) ? 'PRC.HoraSac >= "' . $_SESSION['FiltroSac']['HoraInicio9'] . '" AND ' : FALSE;
			$hora_fim_prc = ($_SESSION['FiltroSac']['HoraFim9']) ? 'PRC.HoraSac <= "' . $_SESSION['FiltroSac']['HoraFim9'] . '" AND ' : FALSE;
			
			$hora_inicio_sub_prc = ($_SESSION['FiltroSac']['HoraInicio10']) ? 'SPRC.HoraSubSac >= "' . $_SESSION['FiltroSac']['HoraInicio10'] . '" AND ' : FALSE;
			$hora_fim_sub_prc = ($_SESSION['FiltroSac']['HoraFim10']) ? 'SPRC.HoraSubSac <= "' . $_SESSION['FiltroSac']['HoraFim10'] . '" AND ' : FALSE;
			
			$data['Dia'] = ($_SESSION['FiltroSac']['Dia']) ? ' AND DAY(PRC.DataSac) = ' . $_SESSION['FiltroSac']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroSac']['Mesvenc']) ? ' AND MONTH(PRC.DataSac) = ' . $_SESSION['FiltroSac']['Mesvenc'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroSac']['Ano']) ? ' AND YEAR(PRC.DataSac) = ' . $_SESSION['FiltroSac']['Ano'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroSac']['Campo']) ? 'PRC.DataSac' : $_SESSION['FiltroSac']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroSac']['Ordenamento']) ? 'DESC' : $_SESSION['FiltroSac']['Ordenamento'];
			
			$filtro10 = ($_SESSION['FiltroSac']['ConcluidoSac'] != '#') ? 'PRC.ConcluidoSac = "' . $_SESSION['FiltroSac']['ConcluidoSac'] . '" AND ' : FALSE;
			
			$filtro21 = ($_SESSION['FiltroSac']['idTab_TipoRD'] == 1) ? 'AND (OT.idTab_TipoRD = "1" OR F.idApp_Fornecedor = PRC.idApp_Fornecedor)' : FALSE;
			$filtro22 = ($_SESSION['FiltroSac']['idTab_TipoRD'] == 2) ? 'AND (OT.idTab_TipoRD = "2" OR C.idApp_Cliente = PRC.idApp_Cliente)' : FALSE;
			
			$data['idApp_Sac'] = ($_SESSION['FiltroSac']['idApp_Sac']) ? ' AND PRC.idApp_Sac = ' . $_SESSION['FiltroSac']['idApp_Sac'] . '  ': FALSE;		
			$data['CategoriaSac'] = ($_SESSION['FiltroSac']['CategoriaSac']) ? ' AND PRC.CategoriaSac = ' . $_SESSION['FiltroSac']['CategoriaSac'] . '  ': FALSE;		
			$data['Marketing'] = ($_SESSION['FiltroSac']['Marketing']) ? ' AND PRC.Marketing = ' . $_SESSION['FiltroSac']['Marketing'] . '  ': FALSE;
			$data['Orcamento'] = ($_SESSION['FiltroSac']['Orcamento']) ? ' AND PRC.idApp_OrcaTrata = ' . $_SESSION['FiltroSac']['Orcamento'] . '  ': FALSE;
			$data['Cliente'] = ($_SESSION['FiltroSac']['Cliente']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroSac']['Cliente'] . '' : FALSE;
			$data['idApp_Cliente'] = ($_SESSION['FiltroSac']['idApp_Cliente']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroSac']['idApp_Cliente'] . '' : FALSE;
			$data['Fornecedor'] = ($_SESSION['FiltroSac']['Fornecedor']) ? ' AND PRC.idApp_Fornecedor = ' . $_SESSION['FiltroSac']['Fornecedor'] . '' : FALSE;
			$data['idApp_Fornecedor'] = ($_SESSION['FiltroSac']['idApp_Fornecedor']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroSac']['idApp_Fornecedor'] . '' : FALSE;        
			$filtro17 = ($_SESSION['FiltroSac']['NomeUsuario']) ? 'PRC.idSis_Usuario = "' . $_SESSION['FiltroSac']['NomeUsuario'] . '" AND ' : FALSE;        
			$filtro18 = ($_SESSION['FiltroSac']['Compartilhar']) ? 'PRC.Compartilhar = "' . $_SESSION['FiltroSac']['Compartilhar'] . '" AND ' : FALSE;		
			
			$data['TipoSac'] = $_SESSION['FiltroSac']['TipoSac'];

			$groupby = ($_SESSION['FiltroSac']['Agrupar'] && $_SESSION['FiltroSac']['Agrupar'] != "0") ? 'GROUP BY PRC.' . $_SESSION['FiltroSac']['Agrupar'] . '' : FALSE;

		}	
		/*
		echo $this->db->last_query();
		echo "<pre>";
		print_r($groupby);
		echo "</pre>";
		exit();
        */ 
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
		$query = $this->db->query('
            SELECT
				PRC.idSis_Empresa,
				PRC.idApp_Sac,
                PRC.Sac,
				PRC.DataSac,
				PRC.HoraSac,
				PRC.ConcluidoSac,
				PRC.idApp_Cliente,
				PRC.idApp_Fornecedor,
				PRC.idApp_OrcaTrata,
				PRC.Compartilhar,
				PRC.CategoriaSac,
				PRC.Marketing,
				SPRC.SubSac,
				SPRC.ConcluidoSubSac,
				SPRC.DataSubSac,
				SPRC.HoraSubSac,
				OT.idTab_TipoRD,
				CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
				CONCAT(IFNULL(F.NomeFornecedor,"")) AS NomeFornecedor,
				U.idSis_Usuario,
				U.CpfUsuario,
				U.Nome AS NomeUsuario,
				SU.idSis_Usuario,
				SU.Nome AS NomeSubUsuario,
				AU.idSis_Usuario,
				AU.Nome AS NomeCompartilhar
            FROM
				App_Sac AS PRC
					LEFT JOIN App_SubSac AS SPRC ON SPRC.idApp_Sac = PRC.idApp_Sac
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PRC.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = PRC.idApp_Fornecedor
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = SPRC.idSis_Usuario
            WHERE
                ' . $date_inicio_prc . '
                ' . $date_fim_prc . '
                ' . $date_inicio_sub_prc . '
                ' . $date_fim_sub_prc . '
                ' . $hora_inicio_prc . '
                ' . $hora_fim_prc . '
                ' . $hora_inicio_sub_prc . '
                ' . $hora_fim_sub_prc . '
				' . $filtro10 . '
				' . $filtro17 . '
				' . $filtro18 . '
				PRC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
				PRC.idApp_OrcaTrata = 0 AND 
				PRC.idApp_Cliente != 0 AND 
				PRC.idApp_Fornecedor = 0 AND 
				PRC.CategoriaSac != 0 AND 
				PRC.Marketing = 0
                ' . $filtro21 . ' 
                ' . $filtro22 . '
                ' . $data['idApp_Sac'] . '
                ' . $data['CategoriaSac'] . '
                ' . $data['Marketing'] . '
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['idApp_Fornecedor'] . '
			' . $groupby . '
            ORDER BY
                ' . $data['Campo'] . ' 
				' . $data['Ordenamento'] . '
			' . $querylimit . '
		');

		if($total == TRUE) {
			return $query->num_rows();
		}
		
        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataSac = $this->basico->mascara_data($row->DataSac, 'barras');
				$row->ConcluidoSac = $this->basico->mascara_palavra_completa($row->ConcluidoSac, 'NS');
				$row->DataSubSac = $this->basico->mascara_data($row->DataSubSac, 'barras');
				$row->ConcluidoSubSac = $this->basico->mascara_palavra_completa($row->ConcluidoSubSac, 'NS');
				
				if($row->Compartilhar == "0"){
					$row->NomeCompartilhar = 'Todos';
				}
				
				if($row->CategoriaSac == 1){
					$row->CategoriaSac = 'Solicitação';
				}elseif($row->CategoriaSac == 2){
					$row->CategoriaSac = 'Elogio';
				}elseif($row->CategoriaSac == 3){
					$row->CategoriaSac = 'Reclamação';
				}
				
				if($row->Marketing == 1){
					$row->Marketing = 'Atualização';
				}elseif($row->Marketing == 2){
					$row->Marketing = 'Pesquisa';
				}elseif($row->Marketing == 3){
					$row->Marketing = 'Retorno';
				}elseif($row->Marketing == 4){
					$row->Marketing = 'Promoções';
				}elseif($row->Marketing == 5){
					$row->Marketing = 'Felicitações';
				}
				
            }
          /*
		  //echo $this->db->last_query();
		  echo "<br>";
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
		  */
            return $query;
        }

    }

	public function list_marketing($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		if($data != FALSE){
					
			$date_inicio_prc = ($data['DataInicio9']) ? 'PRC.DataMarketing >= "' . $data['DataInicio9'] . '" AND ' : FALSE;
			$date_fim_prc = ($data['DataFim9']) ? 'PRC.DataMarketing <= "' . $data['DataFim9'] . '" AND ' : FALSE;
			
			$date_inicio_sub_prc = ($data['DataInicio10']) ? 'SPRC.DataSubMarketing >= "' . $data['DataInicio10'] . '" AND ' : FALSE;
			$date_fim_sub_prc = ($data['DataFim10']) ? 'SPRC.DataSubMarketing <= "' . $data['DataFim10'] . '" AND ' : FALSE;

			$hora_inicio_prc = ($data['HoraInicio9']) ? 'PRC.HoraMarketing >= "' . $data['HoraInicio9'] . '" AND ' : FALSE;
			$hora_fim_prc = ($data['HoraFim9']) ? 'PRC.HoraMarketing <= "' . $data['HoraFim9'] . '" AND ' : FALSE;
			
			$hora_inicio_sub_prc = ($data['HoraInicio10']) ? 'SPRC.HoraSubMarketing >= "' . $data['HoraInicio10'] . '" AND ' : FALSE;
			$hora_fim_sub_prc = ($data['HoraFim10']) ? 'SPRC.HoraSubMarketing <= "' . $data['HoraFim10'] . '" AND ' : FALSE;
			
			$data['Dia'] = ($data['Dia']) ? ' AND DAY(PRC.DataMarketing) = ' . $data['Dia'] : FALSE;
			$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PRC.DataMarketing) = ' . $data['Mesvenc'] : FALSE;
			$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PRC.DataMarketing) = ' . $data['Ano'] : FALSE;
			$data['Campo'] = (!$data['Campo']) ? 'PRC.DataMarketing' : $data['Campo'];
			$data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
			
			$filtro10 = ($data['ConcluidoMarketing'] != '#') ? 'PRC.ConcluidoMarketing = "' . $data['ConcluidoMarketing'] . '" AND ' : FALSE;
			
			$filtro21 = ($data['idTab_TipoRD'] == 1) ? 'AND (OT.idTab_TipoRD = "1" OR F.idApp_Fornecedor = PRC.idApp_Fornecedor)' : FALSE;
			$filtro22 = ($data['idTab_TipoRD'] == 2) ? 'AND (OT.idTab_TipoRD = "2" OR C.idApp_Cliente = PRC.idApp_Cliente)' : FALSE;
			
			$data['idApp_Marketing'] = ($data['idApp_Marketing']) ? ' AND PRC.idApp_Marketing = ' . $data['idApp_Marketing'] . '  ': FALSE;		
			$data['Sac'] = ($data['Sac']) ? ' AND PRC.Sac = ' . $data['Sac'] . '  ': FALSE;		
			$data['CategoriaMarketing'] = ($data['CategoriaMarketing']) ? ' AND PRC.CategoriaMarketing = ' . $data['CategoriaMarketing'] . '  ': FALSE;
			$data['Orcamento'] = ($data['Orcamento']) ? ' AND PRC.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
			$data['Cliente'] = ($data['Cliente']) ? ' AND PRC.idApp_Cliente = ' . $data['Cliente'] . '' : FALSE;
			$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND PRC.idApp_Cliente = ' . $data['idApp_Cliente'] . '' : FALSE;
			$data['Fornecedor'] = ($data['Fornecedor']) ? ' AND PRC.idApp_Fornecedor = ' . $data['Fornecedor'] . '' : FALSE;
			$data['idApp_Fornecedor'] = ($data['idApp_Fornecedor']) ? ' AND PRC.idApp_Cliente = ' . $data['idApp_Fornecedor'] . '' : FALSE;        
			$filtro17 = ($data['NomeUsuario']) ? 'PRC.idSis_Usuario = "' . $data['NomeUsuario'] . '" AND ' : FALSE;        
			$filtro18 = ($data['Compartilhar']) ? 'PRC.Compartilhar = "' . $data['Compartilhar'] . '" AND ' : FALSE;		
			
			$data['TipoMarketing'] = $data['TipoMarketing'];
			if($data['TipoMarketing'] == 1){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata != 0 AND PRC.idApp_Cliente = 0 AND PRC.Sac = 0 AND PRC.Marketing = 0)';
			}elseif($data['TipoMarketing'] == 2){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac = 0 AND PRC.Marketing = 0)';
			}elseif($data['TipoMarketing'] == 3){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata = 0 AND PRC.idApp_Cliente != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac != 0 AND PRC.Marketing = 0)';
			}elseif($data['TipoMarketing'] == 4){
				$tipoprocedimento = '(PRC.idApp_OrcaTrata = 0 AND PRC.idApp_Cliente != 0 AND PRC.idApp_Fornecedor = 0 AND PRC.Sac = 0 AND PRC.Marketing != 0)';
			}
			$groupby = ($data['Agrupar'] && $data['Agrupar'] != "0") ? 'GROUP BY PRC.' . $data['Agrupar'] . '' : FALSE;
			
		}else{
					
			$date_inicio_prc = ($_SESSION['FiltroMarketing']['DataInicio9']) ? 'PRC.DataMarketing >= "' . $_SESSION['FiltroMarketing']['DataInicio9'] . '" AND ' : FALSE;
			$date_fim_prc = ($_SESSION['FiltroMarketing']['DataFim9']) ? 'PRC.DataMarketing <= "' . $_SESSION['FiltroMarketing']['DataFim9'] . '" AND ' : FALSE;
			
			$date_inicio_sub_prc = ($_SESSION['FiltroMarketing']['DataInicio10']) ? 'SPRC.DataSubMarketing >= "' . $_SESSION['FiltroMarketing']['DataInicio10'] . '" AND ' : FALSE;
			$date_fim_sub_prc = ($_SESSION['FiltroMarketing']['DataFim10']) ? 'SPRC.DataSubMarketing <= "' . $_SESSION['FiltroMarketing']['DataFim10'] . '" AND ' : FALSE;

			$hora_inicio_prc = ($_SESSION['FiltroMarketing']['HoraInicio9']) ? 'PRC.HoraMarketing >= "' . $_SESSION['FiltroMarketing']['HoraInicio9'] . '" AND ' : FALSE;
			$hora_fim_prc = ($_SESSION['FiltroMarketing']['HoraFim9']) ? 'PRC.HoraMarketing <= "' . $_SESSION['FiltroMarketing']['HoraFim9'] . '" AND ' : FALSE;
			
			$hora_inicio_sub_prc = ($_SESSION['FiltroMarketing']['HoraInicio10']) ? 'SPRC.HoraSubMarketing >= "' . $_SESSION['FiltroMarketing']['HoraInicio10'] . '" AND ' : FALSE;
			$hora_fim_sub_prc = ($_SESSION['FiltroMarketing']['HoraFim10']) ? 'SPRC.HoraSubMarketing <= "' . $_SESSION['FiltroMarketing']['HoraFim10'] . '" AND ' : FALSE;
			
			$data['Dia'] = ($_SESSION['FiltroMarketing']['Dia']) ? ' AND DAY(PRC.DataMarketing) = ' . $_SESSION['FiltroMarketing']['Dia'] : FALSE;
			$data['Mesvenc'] = ($_SESSION['FiltroMarketing']['Mesvenc']) ? ' AND MONTH(PRC.DataMarketing) = ' . $_SESSION['FiltroMarketing']['Mesvenc'] : FALSE;
			$data['Ano'] = ($_SESSION['FiltroMarketing']['Ano']) ? ' AND YEAR(PRC.DataMarketing) = ' . $_SESSION['FiltroMarketing']['Ano'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroMarketing']['Campo']) ? 'PRC.DataMarketing' : $_SESSION['FiltroMarketing']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroMarketing']['Ordenamento']) ? 'DESC' : $_SESSION['FiltroMarketing']['Ordenamento'];
			
			$filtro10 = ($_SESSION['FiltroMarketing']['ConcluidoMarketing'] != '#') ? 'PRC.ConcluidoMarketing = "' . $_SESSION['FiltroMarketing']['ConcluidoMarketing'] . '" AND ' : FALSE;
			
			$filtro21 = ($_SESSION['FiltroMarketing']['idTab_TipoRD'] == 1) ? 'AND (OT.idTab_TipoRD = "1" OR F.idApp_Fornecedor = PRC.idApp_Fornecedor)' : FALSE;
			$filtro22 = ($_SESSION['FiltroMarketing']['idTab_TipoRD'] == 2) ? 'AND (OT.idTab_TipoRD = "2" OR C.idApp_Cliente = PRC.idApp_Cliente)' : FALSE;
			
			$data['idApp_Marketing'] = ($_SESSION['FiltroMarketing']['idApp_Marketing']) ? ' AND PRC.idApp_Marketing = ' . $_SESSION['FiltroMarketing']['idApp_Marketing'] . '  ': FALSE;		
			$data['Sac'] = ($_SESSION['FiltroMarketing']['Sac']) ? ' AND PRC.Sac = ' . $_SESSION['FiltroMarketing']['Sac'] . '  ': FALSE;		
			$data['CategoriaMarketing'] = ($_SESSION['FiltroMarketing']['CategoriaMarketing']) ? ' AND PRC.CategoriaMarketing = ' . $_SESSION['FiltroMarketing']['CategoriaMarketing'] . '  ': FALSE;
			$data['Orcamento'] = ($_SESSION['FiltroMarketing']['Orcamento']) ? ' AND PRC.idApp_OrcaTrata = ' . $_SESSION['FiltroMarketing']['Orcamento'] . '  ': FALSE;
			$data['Cliente'] = ($_SESSION['FiltroMarketing']['Cliente']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroMarketing']['Cliente'] . '' : FALSE;
			$data['idApp_Cliente'] = ($_SESSION['FiltroMarketing']['idApp_Cliente']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroMarketing']['idApp_Cliente'] . '' : FALSE;
			$data['Fornecedor'] = ($_SESSION['FiltroMarketing']['Fornecedor']) ? ' AND PRC.idApp_Fornecedor = ' . $_SESSION['FiltroMarketing']['Fornecedor'] . '' : FALSE;
			$data['idApp_Fornecedor'] = ($_SESSION['FiltroMarketing']['idApp_Fornecedor']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroMarketing']['idApp_Fornecedor'] . '' : FALSE;        
			$filtro17 = ($_SESSION['FiltroMarketing']['NomeUsuario']) ? 'PRC.idSis_Usuario = "' . $_SESSION['FiltroMarketing']['NomeUsuario'] . '" AND ' : FALSE;        
			$filtro18 = ($_SESSION['FiltroMarketing']['Compartilhar']) ? 'PRC.Compartilhar = "' . $_SESSION['FiltroMarketing']['Compartilhar'] . '" AND ' : FALSE;		
			
			$data['TipoMarketing'] = $_SESSION['FiltroMarketing']['TipoMarketing'];

			$groupby = ($_SESSION['FiltroMarketing']['Agrupar'] && $_SESSION['FiltroMarketing']['Agrupar'] != "0") ? 'GROUP BY PRC.' . $_SESSION['FiltroMarketing']['Agrupar'] . '' : FALSE;
					
		}	
		/*
		echo $this->db->last_query();
		echo "<pre>";
		print_r($groupby);
		echo "</pre>";
		exit();
        */ 
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		
		$query = $this->db->query('
            SELECT
				PRC.idSis_Empresa,
				PRC.idApp_Marketing,
                PRC.Marketing,
				PRC.DataMarketing,
				PRC.HoraMarketing,
				PRC.ConcluidoMarketing,
				PRC.idApp_Cliente,
				PRC.idApp_Fornecedor,
				PRC.idApp_OrcaTrata,
				PRC.Compartilhar,
				PRC.Sac,
				PRC.CategoriaMarketing,
				SPRC.SubMarketing,
				SPRC.ConcluidoSubMarketing,
				SPRC.DataSubMarketing,
				SPRC.HoraSubMarketing,
				OT.idTab_TipoRD,
				CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
				CONCAT(IFNULL(F.NomeFornecedor,"")) AS NomeFornecedor,
				U.idSis_Usuario,
				U.CpfUsuario,
				U.Nome AS NomeUsuario,
				SU.idSis_Usuario,
				SU.Nome AS NomeSubUsuario,
				AU.idSis_Usuario,
				AU.Nome AS NomeCompartilhar
            FROM
				App_Marketing AS PRC
					LEFT JOIN App_SubMarketing AS SPRC ON SPRC.idApp_Marketing = PRC.idApp_Marketing
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PRC.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = PRC.idApp_Fornecedor
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = SPRC.idSis_Usuario
            WHERE
                ' . $date_inicio_prc . '
                ' . $date_fim_prc . '
                ' . $date_inicio_sub_prc . '
                ' . $date_fim_sub_prc . '
                ' . $hora_inicio_prc . '
                ' . $hora_fim_prc . '
                ' . $hora_inicio_sub_prc . '
                ' . $hora_fim_sub_prc . '
				' . $filtro10 . '
				' . $filtro17 . '
				' . $filtro18 . '
				PRC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				PRC.idApp_OrcaTrata = 0 AND 
				PRC.idApp_Cliente != 0 AND 
				PRC.idApp_Fornecedor = 0 AND 
				PRC.Sac = 0 AND 
				PRC.CategoriaMarketing != 0 
                ' . $filtro21 . ' 
                ' . $filtro22 . '
                ' . $data['idApp_Marketing'] . '
                ' . $data['Sac'] . '
                ' . $data['CategoriaMarketing'] . '
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['idApp_Fornecedor'] . '
			' . $groupby . '
            ORDER BY
                ' . $data['Campo'] . ' 
				' . $data['Ordenamento'] . '
			' . $querylimit . '
		');

		if($total == TRUE) {
			return $query->num_rows();
		}
		
        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataMarketing = $this->basico->mascara_data($row->DataMarketing, 'barras');
				$row->ConcluidoMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoMarketing, 'NS');
				$row->DataSubMarketing = $this->basico->mascara_data($row->DataSubMarketing, 'barras');
				$row->ConcluidoSubMarketing = $this->basico->mascara_palavra_completa($row->ConcluidoSubMarketing, 'NS');
				
				if($row->Compartilhar == "0"){
					$row->NomeCompartilhar = 'Todos';
				}
				
				if($row->Sac == 1){
					$row->Sac = 'Solicitação';
				}elseif($row->Sac == 2){
					$row->Sac = 'Elogio';
				}elseif($row->Sac == 3){
					$row->Sac = 'Reclamação';
				}
				
				if($row->CategoriaMarketing == 1){
					$row->CategoriaMarketing = 'Atualização';
				}elseif($row->CategoriaMarketing == 2){
					$row->CategoriaMarketing = 'Pesquisa';
				}elseif($row->CategoriaMarketing == 3){
					$row->CategoriaMarketing = 'Retorno';
				}elseif($row->CategoriaMarketing == 4){
					$row->CategoriaMarketing = 'Promoções';
				}elseif($row->CategoriaMarketing == 5){
					$row->CategoriaMarketing = 'Felicitações';
				}
				
            }
          /*
		  //echo $this->db->last_query();
		  echo "<br>";
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
		  */
            return $query;
        }

    }
	
	public function list1_receitadiaria($data, $completo) {
		
		$quitado = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		if(isset($data['Quitado']) && $data['Quitado'] == "S"){
			$dataref = 'PR.DataPago';
		}else{
			$dataref = 'PR.DataVencimento';
		}
		
		$data['Diavenc'] = ($data['Diavenc']) ? ' AND DAY('.$dataref.') = ' . $data['Diavenc'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH('.$dataref.') = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR('.$dataref.') = ' . $data['Ano'] : FALSE;	
		
		//$data['Diavenc'] = ($data['Diavenc']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Diavenc'] : FALSE;
		//$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		//$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;	
				
		$data['Diapag'] = ($data['Diapag']) ? ' AND DAY(PR.DataPago) = ' . $data['Diapag'] : FALSE;	
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;	
		$data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$aprovadoorca = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
		$entregaorca = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		//$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		//$filtro4 = ($data['Quitado'] != '#') ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade'] != '#') ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query(
            'SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				OT.Descricao,
				CONCAT(IFNULL(TR.TipoFinanceiro,""), " / ", IFNULL(C.NomeCliente,""), " / ", IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
				
                PR.DataPago,
                PR.ValorPago,
				
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				OT.CanceladoOrca = "N" AND
				' . $aprovadoorca . '
				' . $entregaorca . '
				' . $quitado . '
				' . $permissao . '
				OT.idTab_TipoRD = "2"
                ' . $data['Diavenc'] . ' 
				' . $data['Mesvenc'] . '
				' . $data['Ano'] . ' 
            ORDER BY
				PR.DataVencimento
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

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

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

                $somarecebido += $row->ValorParcela;
                $somareceber += $row->ValorParcela;


                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');

            }
            $somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');

            return $query;
        }

    }
	
	public function list2_despesadiaria($data, $completo) {
		
		$quitado = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		if(isset($data['Quitado']) && $data['Quitado'] == "S"){
			$dataref = 'PR.DataPago';
		}else{
			$dataref = 'PR.DataVencimento';
		}
		
		$data['Diavenc'] = ($data['Diavenc']) ? ' AND DAY('.$dataref.') = ' . $data['Diavenc'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH('.$dataref.') = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR('.$dataref.') = ' . $data['Ano'] : FALSE;
		
		//$data['Diavenc'] = ($data['Diavenc']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Diavenc'] : FALSE;	
		//$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		//$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;
		
		$data['Diapag'] = ($data['Diapag']) ? ' AND DAY(PR.DataPago) = ' . $data['Diapag'] : FALSE;	
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;		
		$data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TD.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$aprovadoorca = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
		$entregaorca = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		//$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		//$filtro4 = ($data['Quitado'] != '#') ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade'] != '#') ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query(
            'SELECT
                
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				OT.Descricao,
				CONCAT(IFNULL(TD.TipoFinanceiro,""), " / ", IFNULL(OT.Descricao,"")) AS TipoFinanceiro,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
				
                PR.DataPago,
                PR.ValorPago,
				
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				OT.CanceladoOrca = "N" AND
				' . $aprovadoorca . '
				' . $entregaorca . '
				' . $quitado . '
				' . $permissao . '
				OT.idTab_TipoRD = "1"
                ' . $data['Diavenc'] . ' 
				' . $data['Mesvenc'] . '				
				' . $data['Ano'] . ' 

            ORDER BY
				PR.DataVencimento
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

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

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

                $somarecebido += $row->ValorParcela;
                $somareceber += $row->ValorParcela;


                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');

            }
            $somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');

            return $query;
        }

    }
	
    public function list_balancoanual($data) {
		
		$aprovadoorca = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
		$entregaorca = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		
		$quitado = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
        
		if(isset($data['Quitado']) && $data['Quitado'] == "S"){
			$dataref = 'PR.DataPago';
		}else{
			$dataref = 'PR.DataVencimento';
		}
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao_orcam = (isset($_SESSION['Usuario']['Permissao_Orcam']) && $_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		####################################################################
        #SOMATÓRIO DAS RECEITAS Pago DO ANO
        $somareceitas='';
        for ($i=1;$i<=12;$i++){
            $somareceitas .= 'SUM(IF(' . $dataref . ' BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somareceitas = substr($somareceitas, 0 ,-2);

		$query['RecPago'] = $this->db->query(
        #$receitas = $this->db->query(
            'SELECT
				' . $somareceitas . '
            FROM

                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $aprovadoorca . '
				' . $entregaorca . '
				' . $permissao . '
				' . $permissao_orcam . '
				OT.CanceladoOrca = "N" AND
				OT.idTab_TipoRD = "2" AND
				PR.idTab_TipoRD = "2" AND
				' . $quitado . '
            	YEAR(' . $dataref . ') = ' . $data['Ano']
        );

        #$query['RecPago'] = $query['RecPago']->result_array();
        $query['RecPago'] = $query['RecPago']->result();
        $query['RecPago'][0]->Balancopago = 'Receitas';
		
        ####################################################################
        #SOMATÓRIO DAS RECEITAS À Pagar DO ANO
        $somareceitaspagar='';
        for ($i=1;$i<=12;$i++){
            $somareceitaspagar .= 'SUM(IF(' . $dataref . ' BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somareceitaspagar = substr($somareceitaspagar, 0 ,-2);
       
		$query['RecPagar'] = $this->db->query(
        #$receitas = $this->db->query(
            'SELECT
				' . $somareceitaspagar . '
            FROM

                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $aprovadoorca . '
				' . $entregaorca . '
				' . $permissao . '
				' . $permissao_orcam . '
				OT.CanceladoOrca = "N" AND
				OT.idTab_TipoRD = "2" AND
				PR.idTab_TipoRD = "2" AND
				' . $quitado . '
            	YEAR(' . $dataref . ') = ' . $data['Ano']
        );

        #$query['RecPagar'] = $query['RecPagar']->result_array();
        $query['RecPagar'] = $query['RecPagar']->result();
        $query['RecPagar'][0]->Balancopagar = 'Receber';
		
        ####################################################################
        #SOMATÓRIO DAS RECEITAS Venc. DO ANO
        $somareceitasvenc='';
        for ($i=1;$i<=12;$i++){
            $somareceitasvenc .= 'SUM(IF(' . $dataref . ' BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somareceitasvenc = substr($somareceitasvenc, 0 ,-2);
		
        $query['RecVenc'] = $this->db->query(
        #$receitas = $this->db->query(
            'SELECT
                ' . $somareceitasvenc . '
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $aprovadoorca . '
				' . $entregaorca . '
				' . $permissao . '
				' . $permissao_orcam . '
				OT.CanceladoOrca = "N" AND
				OT.idTab_TipoRD = "2" AND
				PR.idTab_TipoRD = "2" AND
				' . $quitado . '
            	YEAR(' . $dataref . ') = ' . $data['Ano']
        );

        #$query['RecVenc'] = $query['RecVenc']->result_array();
        $query['RecVenc'] = $query['RecVenc']->result();
        $query['RecVenc'][0]->Balancovenc = 'Rec.Esp';


        ####################################################################
        #SOMATÓRIO DAS DESPESAS PAGAS DO ANO
        $somadespesas='';
        for ($i=1;$i<=12;$i++){
            $somadespesas .= 'SUM(IF(' . $dataref . ' BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somadespesas = substr($somadespesas, 0 ,-2);
		
        $query['DesPago'] = $this->db->query(
        #$despesas = $this->db->query(
            'SELECT
                ' . $somadespesas . '
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $aprovadoorca . '
				' . $entregaorca . '
				' . $permissao . '
				' . $permissao_orcam . '
				OT.CanceladoOrca = "N" AND
				OT.idTab_TipoRD = "1" AND
				PR.idTab_TipoRD = "1" AND
				' . $quitado . '				
            	YEAR(' . $dataref . ') = ' . $data['Ano']
        );

        #$query['DesPago'] = $query['DesPago']->result_array();
        $query['DesPago'] = $query['DesPago']->result();
        $query['DesPago'][0]->Balancopago = 'Despesas';

        ####################################################################
        #SOMATÓRIO DAS DESPESAS À PAGAR DO ANO
        $somadespesaspagar='';
        for ($i=1;$i<=12;$i++){
            $somadespesaspagar .= 'SUM(IF(' . $dataref . ' BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somadespesaspagar = substr($somadespesaspagar, 0 ,-2);
		
        $query['DesPagar'] = $this->db->query(
        #$despesas = $this->db->query(
            'SELECT
                ' . $somadespesaspagar . '
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $aprovadoorca . '
				' . $entregaorca . '
				' . $permissao . '
				' . $permissao_orcam . '
				OT.CanceladoOrca = "N" AND
				OT.idTab_TipoRD = "1" AND
				PR.idTab_TipoRD = "1" AND
				' . $quitado . '				
            	YEAR(' . $dataref . ') = ' . $data['Ano']
        );

        #$query['DesPagar'] = $query['DesPagar']->result_array();
        $query['DesPagar'] = $query['DesPagar']->result();
        $query['DesPagar'][0]->Balancopagar = 'Pagar';
		
        ####################################################################
        #SOMATÓRIO DAS DESPESAS Venc DO ANO
        $somadespesasvenc='';
        for ($i=1;$i<=12;$i++){
            $somadespesasvenc .= 'SUM(IF(' . $dataref . ' BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somadespesasvenc = substr($somadespesasvenc, 0 ,-2);

        $query['DesVenc'] = $this->db->query(
        #$despesas = $this->db->query(
            'SELECT
                ' . $somadespesasvenc . '
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $aprovadoorca . '
				' . $entregaorca . '
				' . $permissao . '
				' . $permissao_orcam . '
				OT.CanceladoOrca = "N" AND
				OT.idTab_TipoRD = "1" AND
				PR.idTab_TipoRD = "1" AND
				' . $quitado . '
            	YEAR(' . $dataref . ') = ' . $data['Ano']
        );

        #$query['DesVenc'] = $query['DesVenc']->result_array();
        $query['DesVenc'] = $query['DesVenc']->result();
        $query['DesVenc'][0]->Balancovenc = 'Desp.Esp';
		
        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit();
        */
		#$query['RecVenc'] = $query['RecVenc']->result();
		$query['RecVenc'][0]->BalancoResRec = 'RecVenc';
		#$query['RecPago'] = $query['RecPago']->result();
		$query['RecPago'][0]->BalancoResRec = 'RecPago';
		#$query['RecPagar'] = $query['RecPagar']->result();
		$query['RecPagar'][0]->BalancoResRec = 'RecPagar';		
		#$query['DesVenc'] = $query['DesVenc']->result();
		$query['DesVenc'][0]->BalancoResDes = 'DesVenc';
		#$query['DesPago'] = $query['DesPago']->result();
		$query['DesPago'][0]->BalancoResDes = 'DesPago';
		#$query['DesPagar'] = $query['DesPagar']->result();
		$query['DesPagar'][0]->BalancoResDes = 'DesPagar';		
		
        $query['TotalPago'] = new stdClass();
        $query['TotalGeralpago'] = new stdClass();
        $query['TotalPagar'] = new stdClass();
        $query['TotalGeralpagar'] = new stdClass();		
        $query['TotalVenc'] = new stdClass();
        $query['TotalGeralvenc'] = new stdClass();
		$query['TotalResRec'] = new stdClass();
        $query['TotalGeralResRec'] = new stdClass();
		$query['TotalResDes'] = new stdClass();
        $query['TotalGeralResDes'] = new stdClass();
		
        $query['TotalPago']->Balancopago = 'Balanço';
        $query['TotalGeralpago']->RecPago = $query['TotalGeralpago']->DesPago = $query['TotalGeralpago']->BalancoGeralpago = 0;
        $query['TotalPagar']->Balancopagar = 'Bal.Pagar';
        $query['TotalGeralpagar']->RecPagar = $query['TotalGeralpagar']->DesPagar = $query['TotalGeralpagar']->BalancoGeralpagar = 0;		
        $query['TotalVenc']->Balancovenc = 'Bal.Esp';
        $query['TotalGeralvenc']->RecVenc = $query['TotalGeralvenc']->DesVenc = $query['TotalGeralvenc']->BalancoGeralvenc = 0;
		$query['TotalResRec']->BalancoResRec = 'TotalResRec';
        $query['TotalGeralResRec']->RecVenc = $query['TotalGeralResRec']->RecPago = $query['TotalGeralResRec']->BalancoGeralResRec = 0;
		$query['TotalResDes']->BalancoResDes = 'TotalResDes';
        $query['TotalGeralResDes']->DesVenc = $query['TotalGeralResDes']->DesPago = $query['TotalGeralResDes']->BatancoGeralResDes = 0;
		
        for ($i=1;$i<=12;$i++) {
            $query['TotalVenc']->{'M'.$i} = $query['RecVenc'][0]->{'M'.$i} - $query['DesVenc'][0]->{'M'.$i};

            $query['TotalGeralvenc']->RecVenc += $query['RecVenc'][0]->{'M'.$i};
            $query['TotalGeralvenc']->DesVenc += $query['DesVenc'][0]->{'M'.$i};

            $query['RecVenc'][0]->{'M'.$i} = number_format($query['RecVenc'][0]->{'M'.$i}, 2, ',', '.');
			$query['DesVenc'][0]->{'M'.$i} = number_format($query['DesVenc'][0]->{'M'.$i}, 2, ',', '.');
            $query['TotalVenc']->{'M'.$i} = number_format($query['TotalVenc']->{'M'.$i}, 2, ',', '.');
        }		
        $query['TotalGeralvenc']->BalancoGeralvenc = $query['TotalGeralvenc']->RecVenc - $query['TotalGeralvenc']->DesVenc;

        $query['TotalGeralvenc']->RecVenc = number_format($query['TotalGeralvenc']->RecVenc, 2, ',', '.');
		$query['TotalGeralvenc']->DesVenc = number_format($query['TotalGeralvenc']->DesVenc, 2, ',', '.');
        $query['TotalGeralvenc']->BalancoGeralvenc = number_format($query['TotalGeralvenc']->BalancoGeralvenc, 2, ',', '.');

        for ($i=1;$i<=12;$i++) {
            $query['TotalPago']->{'M'.$i} = $query['RecPago'][0]->{'M'.$i} - $query['DesPago'][0]->{'M'.$i};

            $query['TotalGeralpago']->RecPago += $query['RecPago'][0]->{'M'.$i};
            $query['TotalGeralpago']->DesPago += $query['DesPago'][0]->{'M'.$i};

            #$query['RecPago'][0]->{'M'.$i} = number_format($query['RecPago'][0]->{'M'.$i}, 2, ',', '.');
			#$query['DesPago'][0]->{'M'.$i} = number_format($query['DesPago'][0]->{'M'.$i}, 2, ',', '.');
            #$query['TotalPago']->{'M'.$i} = number_format($query['TotalPago']->{'M'.$i}, 2, ',', '.');
        }		
        $query['TotalGeralpago']->BalancoGeralpago = $query['TotalGeralpago']->RecPago - $query['TotalGeralpago']->DesPago;

        $query['TotalGeralpago']->RecPago = number_format($query['TotalGeralpago']->RecPago, 2, ',', '.');
		$query['TotalGeralpago']->DesPago = number_format($query['TotalGeralpago']->DesPago, 2, ',', '.');
        $query['TotalGeralpago']->BalancoGeralpago = number_format($query['TotalGeralpago']->BalancoGeralpago, 2, ',', '.');
		
        for ($i=1;$i<=12;$i++) {
            $query['TotalPagar']->{'M'.$i} = $query['RecPagar'][0]->{'M'.$i} - $query['DesPagar'][0]->{'M'.$i};

            $query['TotalGeralpagar']->RecPagar += $query['RecPagar'][0]->{'M'.$i};
            $query['TotalGeralpagar']->DesPagar += $query['DesPagar'][0]->{'M'.$i};

            #$query['RecPagar'][0]->{'M'.$i} = number_format($query['RecPagar'][0]->{'M'.$i}, 2, ',', '.');
			#$query['DesPagar'][0]->{'M'.$i} = number_format($query['DesPagar'][0]->{'M'.$i}, 2, ',', '.');
            $query['TotalPagar']->{'M'.$i} = number_format($query['TotalPagar']->{'M'.$i}, 2, ',', '.');
        }		
        $query['TotalGeralpagar']->BalancoGeralpagar = $query['TotalGeralpagar']->RecPagar - $query['TotalGeralpagar']->DesPagar;

        $query['TotalGeralpagar']->RecPagar = number_format($query['TotalGeralpagar']->RecPagar, 2, ',', '.');
		$query['TotalGeralpagar']->DesPagar = number_format($query['TotalGeralpagar']->DesPagar, 2, ',', '.');
        $query['TotalGeralpagar']->BalancoGeralpagar = number_format($query['TotalGeralpagar']->BalancoGeralpagar, 2, ',', '.');		

        for ($i=1;$i<=12;$i++) {
            $query['TotalResRec']->{'M'.$i} = $query['RecVenc'][0]->{'M'.$i} - $query['RecPago'][0]->{'M'.$i};

            $query['TotalGeralResRec']->RecVenc += $query['RecVenc'][0]->{'M'.$i};
            $query['TotalGeralResRec']->RecPago += $query['RecPago'][0]->{'M'.$i};

            #$query['RecVenc'][0]->{'M'.$i} = number_format($query['RecVenc'][0]->{'M'.$i}, 2, ',', '.');
			#$query['RecPago'][0]->{'M'.$i} = number_format($query['RecPago'][0]->{'M'.$i}, 2, ',', '.');
            #$query['TotalResRec']->{'M'.$i} = number_format($query['TotalResRec']->{'M'.$i}, 2, ',', '.');
        }		
        $query['TotalGeralResRec']->BalancoGeralResRec = $query['TotalGeralResRec']->RecVenc - $query['TotalGeralResRec']->RecPago;

        #$query['TotalGeralResRec']->RecVenc = number_format($query['TotalGeralResRec']->RecVenc, 2, ',', '.');
		#$query['TotalGeralResRec']->RecPago = number_format($query['TotalGeralResRec']->RecPago, 2, ',', '.');
        $query['TotalGeralResRec']->BalancoGeralResRec = number_format($query['TotalGeralResRec']->BalancoGeralResRec, 2, ',', '.');
		
        for ($i=1;$i<=12;$i++) {
            $query['TotalResDes']->{'M'.$i} = $query['DesVenc'][0]->{'M'.$i} - $query['DesPago'][0]->{'M'.$i};

            $query['TotalGeralResDes']->DesVenc += $query['DesVenc'][0]->{'M'.$i};
            $query['TotalGeralResDes']->DesPago += $query['DesPago'][0]->{'M'.$i};

            #$query['DesVenc'][0]->{'M'.$i} = number_format($query['DesVenc'][0]->{'M'.$i}, 2, ',', '.');
			#$query['DesPago'][0]->{'M'.$i} = number_format($query['DesPago'][0]->{'M'.$i}, 2, ',', '.');
            #$query['TotalResDes']->{'M'.$i} = number_format($query['TotalResDes']->{'M'.$i}, 2, ',', '.');
        }		
        $query['TotalGeralResDes']->BalancoGeralResDes = $query['TotalGeralResDes']->DesVenc - $query['TotalGeralResDes']->DesPago;

        #$query['TotalGeralResDes']->DesVenc = number_format($query['TotalGeralResDes']->DesVenc, 2, ',', '.');
		#$query['TotalGeralResDes']->DesPago = number_format($query['TotalGeralResDes']->DesPago, 2, ',', '.');
        $query['TotalGeralResDes']->BalancoGeralResDes = number_format($query['TotalGeralResDes']->BalancoGeralResDes, 2, ',', '.');
		
        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit();
        */
        return $query;

    }

	public function list_rankingformapag($data) {

        if ($data['DataFim']) {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '" AND TPR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }
		
		$data['FormaPag'] = ($data['FormaPag']) ? ' AND FP.idTab_FormaPag = ' . $data['FormaPag'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'FP.FormaPag' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        ####################################################################
        #LISTA DE Forma de Pagamento
        $query['FormaPag'] = $this->db->query('
            SELECT
                FP.idTab_FormaPag,
                CONCAT(IFNULL(FP.FormaPag,"")) AS FormaPag
            FROM
                Tab_FormaPag AS FP
				LEFT JOIN App_OrcaTrata AS TOT ON TOT.FormaPagamento = FP.idTab_FormaPag
				LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
				TPR.Quitado = "S" AND
				' . $consulta . '
                ' . $data['FormaPag'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        $query['FormaPag'] = $query['FormaPag']->result();		
		
        ####################################################################
        #Parcelas 

        $query['Parcelas'] = $this->db->query(
            'SELECT
                SUM(TPR.ValorParcela) AS QtdParc,
                TC.idApp_Cliente,
				FP.idTab_FormaPag
            FROM
                App_OrcaTrata AS TOT
                    LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = TOT.FormaPagamento
					LEFT JOIN App_Cliente AS TC ON TC.idApp_Cliente = TOT.idApp_Cliente
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TPR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['FormaPag'] . ' AND
                TOT.AprovadoOrca = "S" AND
				TPR.Quitado = "S" AND
				TPR.idTab_TipoRD = "2" AND
                TC.idApp_Cliente != "0"
            GROUP BY
                FP.idTab_FormaPag
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Parcelas'] = $query['Parcelas']->result();
		
		$rankingvendas = new stdClass();
		#$estoque = array();
        foreach ($query['FormaPag'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $rankingvendas->{$row->idTab_FormaPag} = new stdClass();
            $rankingvendas->{$row->idTab_FormaPag}->FormaPag = $row->FormaPag;
        }


				/*
		echo "<pre>";
		print_r($query['Comprados']);
		echo "</pre>";
		exit();*/
		
		foreach ($query['Parcelas'] as $row) {
            if (isset($rankingvendas->{$row->idTab_FormaPag}))
                $rankingvendas->{$row->idTab_FormaPag}->QtdParc = $row->QtdParc;
        }
		
		$rankingvendas->soma = new stdClass();
		$somaqtdorcam = $somaqtddescon = $somaqtdvendida = $somaqtdparc = $somaqtddevol = 0;

		foreach ($rankingvendas as $row) {
	
			$row->QtdParc = (!isset($row->QtdParc)) ? 0 : $row->QtdParc;
			#$row->QtdDevol = (!isset($row->QtdDevol)) ? 0 : $row->QtdDevol;
		
			$somaqtdparc += $row->QtdParc;
			#$row->QtdParc = number_format($row->QtdParc, 2, ',', '.');																
        }
		
		$rankingvendas->soma->somaqtdparc = number_format($somaqtdparc, 2, ',', '.');
        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $rankingvendas;

    }

	public function list_rankingformaentrega($data) {

        if ($data['DataFim']) {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '" AND TPR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }
		
		$data['TipoFrete'] = ($data['TipoFrete']) ? ' AND FP.idTab_TipoFrete = ' . $data['TipoFrete'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'FP.TipoFrete' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        ####################################################################
        #LISTA DE Forma de Pagamento
        $query['TipoFrete'] = $this->db->query('
            SELECT
                FP.idTab_TipoFrete,
                CONCAT(IFNULL(FP.TipoFrete,"")) AS TipoFrete
            FROM
                Tab_TipoFrete AS FP
				LEFT JOIN App_OrcaTrata AS TOT ON TOT.TipoFrete = FP.idTab_TipoFrete
				LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
				TPR.Quitado = "S" AND
				' . $consulta . '
                ' . $data['TipoFrete'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        $query['TipoFrete'] = $query['TipoFrete']->result();		
		
        ####################################################################
        #Parcelas 

        $query['Parcelas'] = $this->db->query(
            'SELECT
                SUM(TPR.ValorParcela) AS QtdParc,
                TC.idApp_Cliente,
				FP.idTab_TipoFrete
            FROM
                App_OrcaTrata AS TOT
                    LEFT JOIN Tab_TipoFrete AS FP ON FP.idTab_TipoFrete = TOT.TipoFrete
					LEFT JOIN App_Cliente AS TC ON TC.idApp_Cliente = TOT.idApp_Cliente
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TPR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['TipoFrete'] . ' AND
                TOT.AprovadoOrca = "S" AND
				TPR.Quitado = "S" AND
				TPR.idTab_TipoRD = "2" AND
                TC.idApp_Cliente != "0"
            GROUP BY
                FP.idTab_TipoFrete
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Parcelas'] = $query['Parcelas']->result();
		
        ####################################################################
        #Entregador 

        $query['Entregador'] = $this->db->query('
            SELECT
                TOT.ValorFrete AS QtdEntrega,
				FP.idTab_TipoFrete,
				SUE.Nome
            FROM
                App_OrcaTrata AS TOT
                    LEFT JOIN Sis_Usuario AS SUE ON SUE.idSis_Usuario = TOT.Entregador
					LEFT JOIN Tab_TipoFrete AS FP ON FP.idTab_TipoFrete = TOT.TipoFrete
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                TOT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TOT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['TipoFrete'] . ' AND
                TOT.AprovadoOrca = "S" AND
				TOT.QuitadoOrca = "S" AND
				TOT.idTab_TipoRD = "2" 
            GROUP BY
                FP.idTab_TipoFrete
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        $query['Entregador'] = $query['Entregador']->result();		
		
		$rankingvendas = new stdClass();
		#$estoque = array();
        foreach ($query['TipoFrete'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $rankingvendas->{$row->idTab_TipoFrete} = new stdClass();
            $rankingvendas->{$row->idTab_TipoFrete}->TipoFrete = $row->TipoFrete;
        }

		/*
		echo "<pre>";
		print_r($query['Comprados']);
		echo "</pre>";
		exit();
		*/
		
		foreach ($query['Parcelas'] as $row) {
            if (isset($rankingvendas->{$row->idTab_TipoFrete}))
                $rankingvendas->{$row->idTab_TipoFrete}->QtdParc = $row->QtdParc;
        }
		
		foreach ($query['Entregador'] as $row) {
            if (isset($rankingvendas->{$row->idTab_TipoFrete}))
                $rankingvendas->{$row->idTab_TipoFrete}->QtdEntrega = $row->QtdEntrega;
        }
		
		$rankingvendas->soma = new stdClass();
		$somaqtdparc = $somaqtdentrega = 0;

		foreach ($rankingvendas as $row) {
	
			$row->QtdParc = (!isset($row->QtdParc)) ? 0 : $row->QtdParc;
			$row->QtdEntrega = (!isset($row->QtdEntrega)) ? 0 : $row->QtdEntrega;
		
			$somaqtdparc += $row->QtdParc;
			#$row->QtdParc = number_format($row->QtdParc, 2, ',', '.');
			$somaqtdentrega += $row->QtdEntrega;
			#$row->QtdEntrega = number_format($row->QtdEntrega, 2, ',', '.');
        }
		
		$rankingvendas->soma->somaqtdparc = number_format($somaqtdparc, 2, ',', '.');
		$rankingvendas->soma->somaqtdentrega = number_format($somaqtdentrega, 2, ',', '.');
        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $rankingvendas;

    }
	
    public function list_estoque($data) {
        
		if ($data['DataFim']) {
            $consulta =
                '(APV.DataValidadeProduto >= "' . $data['DataInicio'] . '" AND APV.DataValidadeProduto <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(APV.DataValidadeProduto >= "' . $data['DataInicio'] . '")';
        }
		
        $data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produtos = ' . $data['Produtos'] : FALSE;

        $data['Campo'] = (!$data['Campo']) ? 'TP.Nome_Prod' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        
		
		####################################################################
        #LISTA DE PRODUTOS
        $query['Produtos'] = $this->db->query('
            SELECT
                TP.idTab_Produtos,
				TP.TipoProduto,
				TOP2.Opcao,
				TOP1.Opcao,
                CONCAT(IFNULL(TP.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,"")) AS Produtos
            FROM
				Tab_Produtos AS TP
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TP.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TP.Opcao_Atributo_2
 
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				

				' . $data['Produtos'] . '
				
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        $query['Produtos'] = $query['Produtos']->result();
		
        ####################################################################
        #COMPRADOS
		
        $query['Comprados'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto * APV.QtdIncrementoProduto) AS QtdCompra,
                TP.idTab_Produtos
            FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
                    LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = APV.idTab_Produtos_Produto					
            WHERE
                
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                
				OT.idTab_TipoRD = "1" AND
				APV.idTab_TipoRD = "1" AND
				APV.ConcluidoProduto = "S"
				' . $data['Produtos'] . '
			GROUP BY
                TP.idTab_Produtos
            ORDER BY
                TP.Nome_Prod ASC				

        ');
        $query['Comprados'] = $query['Comprados']->result();

        ####################################################################
        #VENDIDOS
		
        $query['Vendidos'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto * APV.QtdIncrementoProduto) AS QtdVenda,
                TP.idTab_Produtos
            FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
                    LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = APV.idTab_Produtos_Produto					
            WHERE
                
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND

                
				OT.idTab_TipoRD = "2" AND
				APV.idTab_TipoRD = "2" 
				' . $data['Produtos'] . '
			GROUP BY
                TP.idTab_Produtos
            ORDER BY
                TP.Nome_Prod ASC				

        ');
        $query['Vendidos'] = $query['Vendidos']->result();

/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();
*/		

		$estoque = new stdClass();
		#$estoque = array();
        foreach ($query['Produtos'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $estoque->{$row->idTab_Produtos} = new stdClass();
            $estoque->{$row->idTab_Produtos}->Produtos = $row->Produtos;
        }


        foreach ($query['Comprados'] as $row) {
            if (isset($estoque->{$row->idTab_Produtos}))
                $estoque->{$row->idTab_Produtos}->QtdCompra = $row->QtdCompra;
		}

        foreach ($query['Vendidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produtos}))
                $estoque->{$row->idTab_Produtos}->QtdVenda = $row->QtdVenda;
        }
		

		$estoque->soma = new stdClass();
		$somaqtdcompra = $somaqtdvenda = $somaqtdestoque = 0;

		foreach ($estoque as $row) {

			$row->QtdCompra = (!isset($row->QtdCompra)) ? 0 : $row->QtdCompra;
            $row->QtdVenda = (!isset($row->QtdVenda)) ? 0 : $row->QtdVenda;

            
			$row->QtdEstoque = $row->QtdCompra - $row->QtdVenda;

			$somaqtdcompra += $row->QtdCompra;
			$row->QtdCompra = ($row->QtdCompra);

			$somaqtdvenda += $row->QtdVenda;
			$row->QtdVenda = ($row->QtdVenda);

			$somaqtdestoque += $row->QtdEstoque;
			$row->QtdEstoque = ($row->QtdEstoque);

        }


		$estoque->soma->somaqtdcompra = ($somaqtdcompra);
		$estoque->soma->somaqtdvenda = ($somaqtdvenda);
		$estoque->soma->somaqtdestoque = ($somaqtdestoque);

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $estoque;

    }

	public function list_clenkontraki($data, $completo) {

        $data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND C.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro10 = ($data['Inativo'] != '#') ? 'C.Ativo = "' . $data['Inativo'] . '" AND ' : FALSE;
        #$q = ($_SESSION['log']['Permissao'] > 2) ? ' C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
				C.idSis_Empresa,
                C.NomeEmpresa,
				C.NomeAdmin,
				C.Inativo,
				SN.StatusSN,
                C.DataCriacao,
				C.DataDeValidade,
				C.NivelEmpresa,
                C.CelularAdmin,
                C.Endereco,
                C.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                C.Email
            FROM
				Sis_Empresa AS C
                    LEFT JOIN Tab_Municipio AS M ON C.Municipio = M.idTab_Municipio
					LEFT JOIN Tab_StatusSN AS SN ON SN.Inativo = C.Inativo
            WHERE
				C.idSis_Empresa != 1 AND
				C.idSis_Empresa != 2 AND
				C.idSis_Empresa != 5 
				' . $data['NomeEmpresa'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

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
				$row->DataCriacao = $this->basico->mascara_data($row->DataCriacao, 'barras');
				$row->DataDeValidade = $this->basico->mascara_data($row->DataDeValidade, 'barras');
				#$row->Inativo = $this->basico->mascara_palavra_completa($row->Inativo, 'NS');
                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->CelularAdmin = ($row->CelularAdmin) ? $row->CelularAdmin : FALSE;
				#$row->Telefone2 = ($row->Telefone2) ? $row->Telefone2 : FALSE;
				#$row->Telefone3 = ($row->Telefone3) ? $row->Telefone3 : FALSE;

                #$row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                #$row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_associado($data, $completo) {

        $data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND C.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];



        $query = $this->db->query('
            SELECT
				C.idSis_Empresa,
				C.Associado,
                C.NomeEmpresa,
                C.DataCriacao,
				C.Celular,
				C.Site,
				SN.StatusSN,
				C.Inativo
            FROM
                Sis_Empresa AS C
					LEFT JOIN Tab_StatusSN AS SN ON SN.Inativo = C.Inativo
            WHERE
                C.Associado = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeEmpresa'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

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
				$row->DataCriacao = $this->basico->mascara_data($row->DataCriacao, 'barras');
                $row->Celular = ($row->Celular) ? $row->Celular : FALSE;
            }

            return $query;
        }

    }

	public function list_empresaassociado($data, $completo) {

        $data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND C.idSis_EmpresaFilial = ' . $data['NomeEmpresa'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];



        $query = $this->db->query('
            SELECT
				C.idSis_EmpresaFilial,
				C.Associado,
                C.NomeEmpresa,
				C.Nome,
                C.Celular,
                C.Email,
				C.UsuarioidSis_EmpresaFilial,
				SN.StatusSN,
				C.Inativo
            FROM
                Sis_EmpresaFilial AS C
					LEFT JOIN Tab_StatusSN AS SN ON SN.Inativo = C.Inativo
            WHERE
                C.Associado = ' . $_SESSION['log']['idSis_EmpresaFilial'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeEmpresa'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

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

                $row->Celular = ($row->Celular) ? $row->Celular : FALSE;
            }

            return $query;
        }

    }

	public function list_profissionais($data, $completo) {

        $data['NomeProfissional'] = ($data['NomeProfissional']) ? ' AND P.idApp_Profissional = ' . $data['NomeProfissional'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.NomeProfissional' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                P.idApp_Profissional,
                P.NomeProfissional,
				TF.Funcao,
                P.DataNascimento,
                P.CelularCliente,
                P.Telefone2,
                P.Telefone3,
                P.Sexo,
                P.Endereco,
                P.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                P.Email,
				CP.NomeContatoProf,
				TRP.RelaPes,
				CP.Sexo
            FROM
                App_Profissional AS P
                    LEFT JOIN Tab_Municipio AS M ON P.Municipio = M.idTab_Municipio
					LEFT JOIN App_ContatoProf AS CP ON P.idApp_Profissional = CP.idApp_Profissional
					LEFT JOIN Tab_RelaPes AS TRP ON TRP.idTab_RelaPes = CP.RelaPes
					LEFT JOIN Tab_Funcao AS TF ON TF.idTab_Funcao= P.Funcao
            WHERE
                P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['NomeProfissional'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

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
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');

                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->Telefone = ($row->CelularCliente) ? $row->CelularCliente : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_funcionario($data, $completo) {

        $data['Nome'] = ($data['Nome']) ? ' AND F.idSis_Usuario = ' . $data['Nome'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'F.Nome' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                F.idSis_Usuario,
                F.Nome,
				FU.Funcao,
				PE.Nivel,
				PE.Permissao
            FROM
                Sis_Usuario AS F
					LEFT JOIN Tab_Funcao AS FU ON FU.idTab_Funcao = F.Funcao
					LEFT JOIN Sis_Permissao AS PE ON PE.idSis_Permissao = F.Permissao
            WHERE
				F.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				F.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Nome'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

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

	public function list_empresas($data, $completo) {

		$data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND E.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
		$data['CategoriaEmpresa'] = ($data['CategoriaEmpresa']) ? ' AND E.CategoriaEmpresa = ' . $data['CategoriaEmpresa'] : FALSE;
		$data['Atuacao'] = ($data['Atuacao']) ? ' AND E.idSis_Empresa = ' . $data['Atuacao'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'E.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                E.idSis_Empresa,
                E.NomeEmpresa,
				E.Site,
				E.Inativo,
                E.EnderecoEmpresa,
                E.BairroEmpresa,
				CE.CategoriaEmpresa,
				E.Atuacao,
				E.Arquivo,
                E.MunicipioEmpresa,
                E.Email
            FROM
                Sis_Empresa AS E
					LEFT JOIN Tab_CategoriaEmpresa AS CE ON CE.idTab_CategoriaEmpresa = E.CategoriaEmpresa
            WHERE

				E.idSis_Empresa != "1" AND
				E.idSis_Empresa != "5" AND
				E.Inativo = 0
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

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {


            }

            return $query;
        }

    }
	
	public function list_empresas1($data, $completo) {

		$data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND E.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'E.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                E.idSis_Empresa,
                E.NomeEmpresa,
				TF.TipoFornec,
				TS.StatusSN,
				E.Fornec,
				TA.Atividade,
                E.DataNascimento,
                E.CelularCliente,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.EnderecoEmpresa,
                E.BairroEmpresa,
                E.MunicipioEmpresa,
                E.Email,
				CE.NomeContato,
				TCE.RelaCom,
				CE.Sexo
            FROM
                Sis_Empresa AS E
					LEFT JOIN App_Contato AS CE ON E.idSis_Empresa = CE.idSis_Empresa
					LEFT JOIN Tab_RelaCom AS TCE ON TCE.idTab_RelaCom = CE.RelaCom
					LEFT JOIN Tab_TipoFornec AS TF ON TF.Abrev = E.TipoFornec
					LEFT JOIN Tab_StatusSN AS TS ON TS.Abrev = E.Fornec
					LEFT JOIN App_Atividade AS TA ON TA.idApp_Atividade = E.Atividade
            WHERE
                E.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				E.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeEmpresa'] . '
			ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

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
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');

                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->Telefone = ($row->CelularCliente) ? $row->CelularCliente : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_fornecedor($data, $completo) {

		$data['NomeFornecedor'] = ($data['NomeFornecedor']) ? ' AND E.idApp_Fornecedor = ' . $data['NomeFornecedor'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'E.NomeFornecedor' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                E.idApp_Fornecedor,
                E.NomeFornecedor,
				TF.TipoFornec,
				TS.StatusSN,
				E.Ativo,
				TA.Atividade,
                E.DataNascimento,
                E.DataCadastroFornecedor,
                E.CelularFornecedor,
                E.Telefone1,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.EnderecoFornecedor,
                E.BairroFornecedor,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS MunicipioFornecedor,
                E.Email,
				CE.NomeContatofornec,
				TCE.Relacao,
				CE.Sexo
            FROM
                App_Fornecedor AS E
                    LEFT JOIN Tab_Municipio AS M ON E.MunicipioFornecedor = M.idTab_Municipio
					LEFT JOIN App_Contatofornec AS CE ON E.idApp_Fornecedor = CE.idApp_Fornecedor
					LEFT JOIN Tab_Relacao AS TCE ON TCE.idTab_Relacao = CE.Relacao
					LEFT JOIN Tab_TipoFornec AS TF ON TF.Abrev = E.TipoFornec
					LEFT JOIN Tab_StatusSN AS TS ON TS.Abrev = E.Ativo
					LEFT JOIN App_Atividade AS TA ON TA.idApp_Atividade = E.Atividade
            WHERE
                E.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				E.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeFornecedor'] . '
			ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

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
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
				$row->DataCadastroFornecedor = $this->basico->mascara_data($row->DataCadastroFornecedor, 'barras');

                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->Telefone = ($row->CelularFornecedor) ? $row->CelularFornecedor : FALSE;
                $row->Telefone .= ($row->Telefone1) ? ' / ' . $row->Telefone1 : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }
	
	public function list_produtos($data, $completo) {
		
		if(!$data['Agrupar']){
			$groupby =  FALSE ;
			$data['Desconto'] = FALSE;
		}elseif($data['Agrupar'] == 1){
			$groupby = 'GROUP BY TPS.idTab_Produtos';
			$data['Desconto'] = FALSE;
		}elseif($data['Agrupar'] == 2){
			$groupby = 'GROUP BY TV.idTab_Valor';
			$data['Desconto'] = 'AND TV.Desconto = "1"';
		}elseif($data['Agrupar'] == 3){
			$groupby = 'GROUP BY TV.idTab_Valor';
			$data['Desconto'] = 'AND TV.Desconto = "2"';
		}elseif($data['Agrupar'] == 4){
			$groupby = 'GROUP BY TV.idTab_Promocao';
			$data['Desconto'] = 'AND TV.Desconto = "2"';
		}
		
		$data['Tipo'] = ($data['Tipo']) ? ' AND TV.Desconto = ' . $data['Tipo'] : FALSE;
		$data['idTab_Catprod'] = ($data['idTab_Catprod']) ? ' AND TPS.idTab_Catprod = ' . $data['idTab_Catprod'] : FALSE;
		$data['idTab_Produto'] = ($data['idTab_Produto']) ? ' AND TPS.idTab_Produto = ' . $data['idTab_Produto'] : FALSE;
		$data['idTab_Produtos'] = ($data['idTab_Produtos']) ? ' AND TPS.idTab_Produtos = ' . $data['idTab_Produtos'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TCP.Catprod' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		
        $query = $this->db->query('
            SELECT
                TPS.*,
				TPS.Arquivo AS ArquivoProdutos,
				TPRS.Prod_Serv,
				TOP1.Opcao AS Opcao1,
				TOP2.Opcao AS Opcao2,
				TP.idTab_Produto,
				TP.Produtos,
				TP.Arquivo AS ArquivoProduto,
				TP.Ativo,
				TCP.idTab_Catprod,
				TCP.Catprod,
				TCP.Arquivo AS ArquivoCatprod,
				TV.idTab_Valor,
				TV.Desconto,
				TV.ValorProduto,
				TV.Convdesc,
				TV.ComissaoVenda,
				TV.ComissaoServico,
				TV.ComissaoCashBack,
				TV.AtivoPreco,
				TV.VendaBalcaoPreco,
				TV.VendaSitePreco,
				TV.idTab_Promocao,
				TV.TempoDeEntrega,
				TV.QtdProdutoDesconto,
				TV.QtdProdutoIncremento,
				TV.TipoPreco,
				TDS.idTab_Desconto,
				TDS.Desconto,
				TPM.idTab_Promocao,
				TPM.Promocao,
				TPM.Descricao,
				TPM.Arquivo AS ArquivoPromocao,
                TCT.*
            FROM
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
					LEFT JOIN Tab_Catprod AS TCP ON TCP.idTab_Catprod = TPS.idTab_Catprod
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_2
					LEFT JOIN Tab_Prod_Serv AS TPRS ON TPRS.Abrev_Prod_Serv = TPS.Prod_Serv
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TPS.idTab_Produtos
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = TV.Desconto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = TV.idTab_Promocao
					LEFT JOIN Tab_Catprom AS TCT ON TCT.idTab_Catprom = TPM.idTab_Catprom
            WHERE
                TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				' . $data['Tipo'] . ' 
				' . $data['idTab_Catprod'] . '
				' . $data['idTab_Produto'] . '
				' . $data['idTab_Produtos'] . '
				' . $data['Desconto'] . '
			' . $groupby . '
			ORDER BY
				' . $data['Campo'] . '
				' . $data['Ordenamento'] . ', 
				TP.Produtos
		
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

            #$valor_produto=0;
			#$somaorcamento=0;
			#$somacomissao=0;
            foreach ($query->result() as $row) {

				#$valor_produto = $row->Valor_Cor_Prod * $row->Fator_Tam_Prod;
				#$somaorcamento += $row->ValorRestanteOrca;
				#$somacomissao += $row->ValorComissao;
				if($row->idTab_Promocao == 1){
					$row->idTab_Promocao = "";
				}
				if($row->idTab_Valor){
					if($row->AtivoPreco == "S"){
						if($row->VendaBalcaoPreco == "S"){
							if($row->VendaSitePreco == "S"){
								$row->AtivoPreco = "Balcao/Site";
							}else{
								$row->AtivoPreco = "Balcao";
							}
						}else{
							if($row->VendaSitePreco == "S"){
								$row->AtivoPreco = "Site";
							}else{
								$row->AtivoPreco = "Não";
							}
						}
					}else{
						$row->AtivoPreco = $this->basico->mascara_palavra_completa($row->AtivoPreco, 'NS');
					}
				}else{
					$row->AtivoPreco = "";
				}
				if($row->ValorProduto != 0){
					$row->ValorProduto = number_format($row->ValorProduto, 2, ',', '.');
				}
				if($row->ComissaoVenda != 0.00){
					$row->ComissaoVenda = number_format($row->ComissaoVenda, 2, ',', '.');
				}else{
					$row->ComissaoVenda = "";
				}
				if($row->ComissaoServico != 0.00){
					$row->ComissaoServico = number_format($row->ComissaoServico, 2, ',', '.');
				}else{
					$row->ComissaoServico = "";
				}
				if($row->ComissaoCashBack != 0.00){
					$row->ComissaoCashBack = number_format($row->ComissaoCashBack, 2, ',', '.');
				}else{
					$row->ComissaoCashBack = "";
				}
				#$valor_produto = number_format($valor_produto, 2, ',', '.');
				
            }
            #$query->soma = new stdClass();
			#$query->soma->valor_produto = number_format($valor_produto, 2, ',', '.');
            #$query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			#$query->soma->somacomissao = number_format($somacomissao, 2, ',', '.');			
			
			
            return $query;
        }

    }

	public function list_servicos($data, $completo) {

		$data['Servicos'] = ($data['Servicos']) ? ' AND TP.idApp_Servicos = ' . $data['Servicos'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TP.Servicos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TP.idApp_Servicos,
				TP.CodServ,
				TP.Servicos,
				TP.UnidadeProduto,
				TP.ValorCompraServico,
				TP.Fornecedor,
				TF.NomeFornecedor,

				TV.ValorServico,
				TC.Convenio
            FROM
                App_Servicos AS TP
					LEFT JOIN Tab_ValorServ AS TV ON TV.idApp_Servicos = TP.idApp_Servicos
					LEFT JOIN Tab_Convenio AS TC ON TC.idTab_Convenio = TV.Convenio
					LEFT JOIN App_Fornecedor AS TF ON TF.idApp_Fornecedor = TP.Fornecedor
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['Servicos'] . '
			ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

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

	public function list_promocao($data, $completo) {
		
		$data['Produtos'] = ($data['Produtos']) ? ' AND TPS.idTab_Produtos = ' . $data['Produtos'] : FALSE;
		$data['Promocao'] = ($data['Promocao']) ? ' AND TPM.idTab_Promocao = ' . $data['Promocao'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TPM.Promocao' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TPM.*,
				TPM.Arquivo AS ArquivoPromocao,
                TDS.*,
                TCT.*,
				TCT.Arquivo AS ArquivoCatprom,
				SUM(TV.ValorProduto) AS SubTotal2
            FROM
                Tab_Promocao AS TPM
					LEFT JOIN Tab_Catprom AS TCT ON TCT.idTab_Catprom = TPM.idTab_Catprom
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = TPM.Desconto
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPM.idTab_Promocao
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
            WHERE
                TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPM.Desconto = "2"
				' . $data['Promocao'] . '
				' . $data['Produtos'] . '
			GROUP BY
                TPM.idTab_Promocao
			ORDER BY
				TPM.idTab_Promocao ASC		
        ');

        if ($completo === FALSE) {
            return TRUE;
        } else {
           
			foreach ($query->result() as $row) {
				$row->ValorPromocao = number_format($row->ValorPromocao, 2, ',', '.');
				$row->SubTotal2 = number_format($row->SubTotal2, 2, ',', '.');
				
				if($row->VendaBalcao == "S"){
					if($row->VendaSite == "S"){
						$row->Ativo = "Balcao/Site";
					}else{
						$row->Ativo = "Balcao";
					}
				}else{
					if($row->VendaSite == "S"){
						$row->Ativo = "Site";
					}else{
						$row->Ativo = "Não";
					}
				}
				
            }
            return $query;
        }

    }

	public function list_precopromocao($data, $completo) {

		$data['Produtos'] = ($data['Produtos']) ? ' AND TPD.idTab_Produtos = ' . $data['Produtos'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TPD.Nome_Prod' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
				TV.*,
				TPD.Arquivo,
				CONCAT(IFNULL(TPD.Nome_Prod,""), " ", IFNULL(TV.Convdesc,""), " - ", IFNULL(TV.QtdProdutoIncremento,""), " Unid.") AS Nome_Prod,
				TDC.Desconto
            FROM
                Tab_Valor AS TV
					LEFT JOIN Tab_Produtos AS TPD ON TPD.idTab_Produtos = TV.idTab_Produtos
					LEFT JOIN Tab_Desconto AS TDC ON TDC.idTab_Desconto = TV.Desconto					
            WHERE
                TV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TV.Desconto = "1"
				' . $data['Produtos'] . '
			ORDER BY
				TPD.Nome_Prod ASC		
        ');

        /*
        ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '	, TPM.Promocao ASC
		#AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            #$somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            $subtotal=$total=0;
			foreach ($query->result() as $row) {
				/*
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
				*/
                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                /*
				if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }
				*/
                
				$valor_produto = $row->ValorProduto;
				$qtd_produto = $row->QtdProdutoDesconto;
				$subtotal += $valor_produto * $qtd_produto;
				
				/*
				$somarecebido += $row->ValorPago;
                $somareceber += $row->ValorParcela;
				

                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');
				*/
            }
            $total = $subtotal;
			/*
			$somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;
			*/
            $query->soma = new stdClass();
            /*
			$query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');
			*/
			$query->soma->total = number_format($total, 2, ',', '.');
			
            return $query;
        }

    }
	
	public function list_catprod($data, $completo) {

		$data['Catprod'] = ($data['Catprod']) ? ' AND TPM.idTab_Catprod = ' . $data['Catprod'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TPD.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TPM.idTab_Catprod,
				TPM.Catprod,
				TPM.TipoCatprod,
				TPM.idSis_Empresa,
				TPRS.Prod_Serv,
				TAT.Atributo,
				TOP.Opcao
            FROM
                Tab_Catprod AS TPM
					LEFT JOIN Tab_Prod_Serv AS TPRS ON TPRS.Abrev_Prod_Serv = TPM.TipoCatprod
					LEFT JOIN Tab_Atributo AS TAT ON TAT.idTab_Catprod = TPM.idTab_Catprod
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Atributo = TAT.idTab_Atributo
            WHERE
                TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY
				TPM.Catprod ASC,
				TAT.Atributo ASC,
				TOP.Opcao ASC
        ');

        /*
        ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '	, TPM.Promocao ASC
		#AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            #$somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            #$subtotal=$total=0;
			foreach ($query->result() as $row) {
				/*
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
				*/
                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                /*
				if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }
				
                
				$valor_produto = $row->ValorProduto;
				$qtd_produto = $row->QtdProdutoDesconto;
				$subtotal += $valor_produto * $qtd_produto;
				
				
				$somarecebido += $row->ValorPago;
                $somareceber += $row->ValorParcela;
				

                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');
				*/
            }
            /*
				$total = $subtotal;
			
			$somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;
			
            $query->soma = new stdClass();
            
			$query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');
			
			$query->soma->total = number_format($total, 2, ',', '.');
			*/
            return $query;
        }

    }

	public function list_atributo($data, $completo) {
		
		$data['idTab_Catprod'] = ($data['idTab_Catprod']) ? ' AND TPM.idTab_Catprod = ' . $data['idTab_Catprod'] : FALSE;
		$data['Atributo'] = ($data['Atributo']) ? ' AND TPM.idTab_Atributo = ' . $data['Atributo'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TPD.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TPM.*,
				TCP.*,
				TOP.Opcao
            FROM
                Tab_Atributo AS TPM
					LEFT JOIN Tab_Catprod AS TCP ON TCP.idTab_Catprod = TPM.idTab_Catprod
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Atributo = TPM.idTab_Atributo
            WHERE
                TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY
				TCP.Catprod ASC,
				TPM.Atributo ASC
        ');

        /*
        ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '	, TPM.Promocao ASC
		#AND
        #P.idApp_Profissional = OT.idApp_Cliente

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

	public function list_tarefa($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(P.DataTarefa >= "' . $data['DataInicio'] . '" AND P.DataTarefa <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(P.DataTarefa >= "' . $data['DataInicio'] . '")';
        }
		
        $data['Campo'] = (!$data['Campo']) ? 'P.DataTarefa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro4 = ($data['ConcluidoTarefa']) ? 'P.ConcluidoTarefa = "' . $data['ConcluidoTarefa'] . '" AND ' : FALSE;
		#$filtro5 = ($data['Prioridade']) ? 'P.Prioridade = "' . $data['Prioridade'] . '" AND ' : FALSE;
		#$filtro5 = ($data['ConcluidoTarefa'] != '0') ? 'P.ConcluidoTarefa = "' . $data['ConcluidoTarefa'] . '" AND ' : FALSE;
        $filtro6 = ($data['Prioridade'] != '0') ? 'P.Prioridade = "' . $data['Prioridade'] . '" AND ' : FALSE;		
		$filtro11 = ($data['Statustarefa'] != '0') ? 'P.Statustarefa = "' . $data['Statustarefa'] . '" AND ' : FALSE;
		$filtro12 = ($data['Statussubtarefa'] != '0') ? 'SP.Statussubtarefa = "' . $data['Statussubtarefa'] . '" AND ' : FALSE;
		$filtro9 = ($data['idTab_Categoria'] != '0') ? 'P.idTab_Categoria = "' . $data['idTab_Categoria'] . '" AND ' : FALSE;
		$filtro8 = (($data['ConcluidoSubTarefa'] != '0') && ($data['ConcluidoSubTarefa'] != 'M')) ? 'SP.ConcluidoSubTarefa = "' . $data['ConcluidoSubTarefa'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoSubTarefa'] == 'M') ? '((SP.ConcluidoSubTarefa = "S") OR (SP.ConcluidoSubTarefa = "N")) AND ' : FALSE;
		$filtro10 = ($data['SubPrioridade'] != '0') ? 'SP.Prioridade = "' . $data['SubPrioridade'] . '" AND ' : FALSE;
		$data['Tarefa'] = ($data['Tarefa']) ? ' AND P.idApp_Tarefa = ' . $data['Tarefa'] : FALSE;
		#$data['ConcluidoTarefa'] = ($data['ConcluidoTarefa'] != '') ? ' AND P.ConcluidoTarefa = ' . $data['ConcluidoTarefa'] : FALSE;
		#$data['Prioridade'] = ($data['Prioridade'] != '') ? ' AND P.Prioridade = ' . $data['Prioridade'] : FALSE;
		#$permissao1 = (($_SESSION['FiltroAlteraTarefa']['Categoria'] != "0" ) && ($_SESSION['FiltroAlteraTarefa']['Categoria'] != '' )) ? 'P.Categoria = "' . $_SESSION['FiltroAlteraTarefa']['Categoria'] . '" AND ' : FALSE;
		#$permissao2 = (($_SESSION['FiltroAlteraTarefa']['ConcluidoTarefa'] != "0" ) && ($_SESSION['FiltroAlteraTarefa']['ConcluidoTarefa'] != '' )) ? 'P.ConcluidoTarefa = "' . $_SESSION['FiltroAlteraTarefa']['ConcluidoTarefa'] . '" AND ' : FALSE;
		#$permissao3 = (($_SESSION['FiltroAlteraTarefa']['Prioridade'] != "0" ) && ($_SESSION['FiltroAlteraTarefa']['Prioridade'] != '' )) ? 'P.Prioridade = "' . $_SESSION['FiltroAlteraTarefa']['Prioridade'] . '" AND ' : FALSE;

		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao = 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
			$permissao2 = FALSE;
		}else{
			if($_SESSION['Usuario']['Nivel'] == 2){
				$permissao = 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
				$permissao2 = FALSE;
			}else{
				$permissao = 'P.NivelTarefa = "1" AND';
				$permissao2 = 'OR P.Compartilhar = 0';
			}
		}

		$groupby = ($data['Agrupar'] != "0") ? 'GROUP BY P.' . $data['Agrupar'] . '' : FALSE;		
		/*
		echo $this->db->last_query();
		echo "<pre>";
		print_r($data['Agrupar']);
		echo "<br>";
		print_r($groupby);
		echo "</pre>";
		exit();	
		*/
		$query = $this->db->query('
            SELECT
				E.NomeEmpresa,
				P.idSis_Usuario,
				U.CpfUsuario,
				U.Nome AS NomeUsuario,
				AU.Nome AS Comp,
				P.idSis_Empresa,
				P.idApp_Tarefa,
                P.Tarefa,
				P.DataTarefa,
				P.DataTarefaLimite,
				P.ConcluidoTarefa,
				P.Prioridade,
				P.Statustarefa,
				P.Compartilhar,
				CT.Categoria,
				SP.SubTarefa,
				SP.Statussubtarefa,
				SP.ConcluidoSubTarefa,
				SP.DataSubTarefa,
				SP.DataSubTarefaLimite,
				SP.Prioridade AS SubPrioridade,
				SN.StatusSN
            FROM
				App_Tarefa AS P
					LEFT JOIN App_SubTarefa AS SP ON SP.idApp_Tarefa = P.idApp_Tarefa
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoTarefa
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = P.idTab_Categoria
            WHERE
				' . $permissao . '
				' . $filtro4 . '
				' . $filtro9 . '
				' . $filtro3 . '
				' . $filtro8 . '
				(' . $consulta . ') AND
				((P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				(P.Compartilhar = ' . $_SESSION['log']['idSis_Usuario'] . ' OR P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' ' . $permissao2 . '))) AND
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" AND
				P.idApp_Fornecedor = "0" 
				' . $data['Tarefa'] . '
			' . $groupby . '
			ORDER BY
				' . $data['Campo'] . '
				' . $data['Ordenamento'] . '
				
				
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

            $somatarefa=0;
            foreach ($query->result() as $row) {
				$row->DataTarefa = $this->basico->mascara_data($row->DataTarefa, 'barras');
				$row->DataTarefaLimite = $this->basico->mascara_data($row->DataTarefaLimite, 'barras');
				$row->DataSubTarefa = $this->basico->mascara_data($row->DataSubTarefa, 'barras');
				$row->DataSubTarefaLimite = $this->basico->mascara_data($row->DataSubTarefaLimite, 'barras');				
				#$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
				$row->ConcluidoTarefa = $this->basico->mascara_palavra_completa($row->ConcluidoTarefa, 'NS');
                $row->ConcluidoSubTarefa = $this->basico->mascara_palavra_completa2($row->ConcluidoSubTarefa, 'NS');
				$row->Prioridade = $this->basico->prioridade($row->Prioridade, '123');
				$row->SubPrioridade = $this->basico->prioridade($row->SubPrioridade, '123');
				$row->Statustarefa = $this->basico->statustrf($row->Statustarefa, '123');
				$row->Statussubtarefa = $this->basico->statustrf($row->Statussubtarefa, '123');
				#$row->Rotina = $this->basico->mascara_palavra_completa($row->Rotina, 'NS');
				if($row->Compartilhar == 0){
					$row->Comp = 'Todos';
				}
			
			}
            $query->soma = new stdClass();
            $query->soma->somatarefa = number_format($somatarefa, 2, ',', '.');

            return $query;
        }

    }

	public function list_procedimento($data, $completo) {

		$data['Dia'] = ($data['Dia']) ? ' AND DAY(C.DataProcedimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(C.DataProcedimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(C.DataProcedimento) = ' . $data['Ano'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.DataProcedimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		$filtro10 = ($data['ConcluidoProcedimento'] != '#') ? 'C.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;
        
		$query = $this->db->query('
            SELECT
				U.idSis_Usuario,
				U.CpfUsuario,
				C.idSis_Empresa,
				C.idApp_Procedimento,
                C.Procedimento,
				C.DataProcedimento,
				C.ConcluidoProcedimento
            FROM
				App_Procedimento AS C
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = C.idSis_Usuario
            WHERE
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				C.idApp_OrcaTrata = "0" AND
				C.idApp_Cliente = "0" AND
				' . $filtro10 . '
				U.CpfUsuario = ' . $_SESSION['log']['CpfUsuario'] . ' 
                ' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 
				
            ORDER BY
                ' . $data['Campo'] . ' 
				' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

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
				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');

            }

            return $query;
        }

    }

	public function list_alterarprocedimento($data, $completo) {

		$data['Dia'] = ($data['Dia']) ? ' AND DAY(C.DataProcedimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(C.DataProcedimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(C.DataProcedimento) = ' . $data['Ano'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.DataProcedimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		$filtro10 = ($data['ConcluidoProcedimento'] != '#') ? 'C.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;
        
		$query = $this->db->query('
            SELECT
				U.idSis_Usuario,
				U.CpfUsuario,
				C.idSis_Empresa,
				C.idApp_Procedimento,
                C.Procedimento,
				C.DataProcedimento,
				C.ConcluidoProcedimento
            FROM
				App_Procedimento AS C
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = C.idSis_Usuario
            WHERE
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				C.idApp_OrcaTrata = "0" AND
				C.idApp_Cliente = "0" AND
				' . $filtro10 . '
				U.CpfUsuario = ' . $_SESSION['log']['CpfUsuario'] . ' 
                ' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 
				
            ORDER BY
                ' . $data['Campo'] . ' 
				' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

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
				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');

            }

            return $query;
        }

    }

	public function list_depoimento($data, $completo) {

        $query = $this->db->query('
            SELECT
                idApp_Depoimento,
				Nome_Depoimento,
				Texto_Depoimento,
				Arquivo_Depoimento,
				Ativo_Depoimento
            FROM
                App_Depoimento
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY
				idApp_Depoimento		
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

	public function list_atuacao($data, $completo) {

        $query = $this->db->query('
            SELECT
                idApp_Atuacao,
				Nome_Atuacao,
				Texto_Atuacao,
				Arquivo_Atuacao,
				Ativo_Atuacao
            FROM
                App_Atuacao
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY
				idApp_Atuacao		
        ');
		
        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {

            }

            return $query;
        }

    }

	public function list_colaborador($data, $completo) {

        $query = $this->db->query('
            SELECT
                idApp_Colaborador,
				Nome_Colaborador,
				Texto_Colaborador,
				Arquivo_Colaborador,
				Ativo_Colaborador
            FROM
                App_Colaborador
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY
				idApp_Colaborador		
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

	public function list_slides($data, $completo) {

        $query = $this->db->query('
            SELECT
                idApp_Slides,
				Slide1,
				Texto_Slide1,
				Ativo
            FROM
                App_Slides
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY
				idApp_Slides		
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

    public function list1_produtos($x) {

        $query = $this->db->query('
			SELECT 
				TP.idTab_Produtos,
				TP.Nome_Prod,
				TP.Arquivo,
				TP.Ativo,
				TP.VendaSite,
				TP.ValorProdutoSite,
				TP.Comissao,
				TV.ValorProduto
			FROM 
				Tab_Produtos AS TP
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TP.idTab_Produtos
			WHERE
				TP.idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . ' AND
				TP.Ativo = "S" AND
				TP.VendaSite = "S"
			ORDER BY 
				TP.Nome_Prod ASC 
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function list2_slides($x) {

        $query = $this->db->query('
			SELECT 
				TS.idApp_Slides,
				TS.Slide1,
				TS.Texto_Slide1,
				TS.Ativo
			FROM 
				App_Slides AS TS
			WHERE
				TS.idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . ' AND
				TS.Ativo = "S"
			ORDER BY 
				TS.idApp_Slides ASC 
		');

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function list3_documentos($x) {

        $query = $this->db->query('
			SELECT 
				TD.idApp_Documentos,
				TD.Logo_Nav,
				TD.Icone
			FROM 
				App_Documentos AS TD
			WHERE
				TD.idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . '
			ORDER BY 
				TD.idApp_Documentos ASC 
		');

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function list5_colaboradores($x) {

        $query = $this->db->query('
			SELECT 
				idApp_Colaborador,
				Nome_Colaborador,
				Texto_Colaborador,
				Arquivo_Colaborador,
				Ativo_Colaborador
			FROM 
				App_Colaborador
			WHERE
				idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . ' AND
				Ativo_Colaborador = "S"
			ORDER BY 
				idApp_Colaborador ASC 
		');

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function list6_depoimentos($x) {

        $query = $this->db->query('
			SELECT 
				idApp_Depoimento,
				Nome_Depoimento,
				Texto_Depoimento,
				Arquivo_Depoimento,
				Ativo_Depoimento
			FROM 
				App_Depoimento
			WHERE
				idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . ' AND
				Ativo_Depoimento = "S"
			ORDER BY 
				idApp_Depoimento ASC 
		');

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function list7_atuacao($x) {

        $query = $this->db->query('
			SELECT 
				idApp_Atuacao,
				Nome_Atuacao,
				Texto_Atuacao,
				Arquivo_Atuacao,
				Ativo_Atuacao
			FROM 
				App_Atuacao
			WHERE
				idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . ' AND
				Ativo_Atuacao = "S"
			ORDER BY 
				idApp_Atuacao ASC 
		');

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                $query = $query->result_array();
                return $query;
            }
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
	
    public function select_cliente() {

        $query = $this->db->query('
            SELECT
                C.idApp_Cliente,
                CONCAT(IFNULL(C.idApp_Cliente, ""), " --- ", IFNULL(C.NomeCliente, ""), " --- ", IFNULL(C.CelularCliente, ""), " --- ", IFNULL(C.RegistroFicha, ""), " --- ", IFNULL(C.Telefone, ""), " --- ", IFNULL(C.Telefone2, ""), " --- ", IFNULL(C.Telefone3, "")) As NomeCliente
            FROM
                App_Cliente AS C

            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                C.NomeCliente ASC	
        ');

        $array = array();
        $array[0] = ':: Todos os Clientes ::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Cliente] = $row->NomeCliente;
        }

        return $array;
    }
	
    public function select_clientepet() {

        $query = $this->db->query('
            SELECT
                CP.idApp_ClientePet,
                CONCAT(IFNULL(CP.idApp_ClientePet, ""), " --- ", IFNULL(CP.NomeClientePet, ""), " || Tutor: ", IFNULL(C.NomeCliente, "")) As NomeClientePet
            FROM
                App_ClientePet AS CP
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CP.idApp_Cliente
            WHERE
                CP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                CP.NomeClientePet ASC	
        ');

        $array = array();
        $array[0] = ':: Todos os Pets ::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_ClientePet] = $row->NomeClientePet;
        }

        return $array;
    }
	
    public function select_clientedep() {

        $query = $this->db->query('
            SELECT
                CP.idApp_ClienteDep,
                CONCAT(IFNULL(CP.idApp_ClienteDep, ""), " --- ", IFNULL(CP.NomeClienteDep, ""), " || Tutor: ", IFNULL(C.NomeCliente, "")) As NomeClienteDep
            FROM
                App_ClienteDep AS CP
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CP.idApp_Cliente
            WHERE
                CP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                CP.NomeClienteDep ASC	
        ');

        $array = array();
        $array[0] = ':: Todos os Deps ::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_ClienteDep] = $row->NomeClienteDep;
        }

        return $array;
    }
	
    public function select_cliente_associado() {

        $query = $this->db->query('
            SELECT
                ASS.idSis_Associado,
                CONCAT(IFNULL(C.NomeCliente, ""), " - ", IFNULL(ASS.idSis_Associado, "")) As NomeAssociado
            FROM
                Sis_Associado AS ASS
					LEFT JOIN App_Cliente AS C ON C.idSis_Associado = ASS.idSis_Associado

            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.ClienteConsultor = "S"
            ORDER BY
                NomeAssociado ASC	
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Associado] = $row->NomeAssociado;
        }

        return $array;
    }
	
    public function select_clenkontraki() {

        $query = $this->db->query('
            SELECT
                C.idSis_Empresa,
                CONCAT(IFNULL(C.NomeEmpresa, ""), " --- ", IFNULL(C.NomeAdmin, "")) As NomeEmpresa
            FROM
                Sis_Empresa AS C
            WHERE
                C.idSis_Empresa != ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                C.NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresa;
        }

        return $array;
    }

	public function select_associado() {

        $query = $this->db->query('
            SELECT
                idSis_Empresa,
                NomeEmpresa
            FROM
                Sis_Empresa
            WHERE
                Associado = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresa;
        }

        return $array;
    }

	public function select_empresaassociado() {

        $query = $this->db->query('
            SELECT
                idSis_EmpresaFilial,
                NomeEmpresa
            FROM
                Sis_EmpresaFilial
            WHERE
                Associado = ' . $_SESSION['log']['idSis_EmpresaFilial'] . ' AND
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
			$array[$row->idSis_EmpresaFilial] = $row->NomeEmpresa;
        }

        return $array;
    }

	public function select_empresas() {

        $query = $this->db->query('
            SELECT
                idSis_Empresa,
				NomeEmpresa
            FROM
                Sis_Empresa
            WHERE
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				idSis_Empresa != "1" AND 
				idSis_Empresa != "5" 
            ORDER BY
                NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresa;
        }

        return $array;
    }

	public function select_empresa() {

        $query = $this->db->query('
            SELECT
                SE.idSis_Empresa,
				SE.NomeEmpresa
            FROM
                Sis_Empresa AS SE
					LEFT JOIN App_OrcaTrata AS OT ON OT.idSis_Empresa = SE.idSis_Empresa
            WHERE
				SE.idSis_Empresa != "1" AND 
				SE.idSis_Empresa != "5" AND
				OT.Tipo_Orca = "O" AND
				OT.Associado = ' . $_SESSION['log']['idSis_Usuario'] . ' 
            ORDER BY
                SE.NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = '::Todos::';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresa;
        }

        return $array;
    }
	
	public function select_fornecedor() {

        $query = $this->db->query('
            SELECT
                idApp_Fornecedor,
				CONCAT(IFNULL(NomeFornecedor, ""), " --- ", IFNULL(Telefone1, "")) As NomeFornecedor
            FROM
                App_Fornecedor
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeFornecedor ASC
        ');

        $array = array();
        $array[0] = ':: Todos os Fornecedores ::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Fornecedor] = $row->NomeFornecedor;
        }

        return $array;
    }

    public function select_funcionario() {

        $query = $this->db->query('
            SELECT
                F.idSis_Usuario,
                F.Nome,
				CONCAT(IFNULL(F.Nome, ""), " - ", IFNULL(F.idSis_Usuario,"")) AS NomeUsuario
            FROM
                Sis_Usuario AS F
            WHERE
                F.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				F.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				Nivel != 2
            ORDER BY
                F.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }

        return $array;
    }

	public function select_profissional() {

        $query = $this->db->query('
            SELECT
                P.idApp_Profissional,
                CONCAT(P.NomeProfissional, " ", "---", P.CelularCliente) AS NomeProfissional
            FROM
                App_Profissional AS P
            WHERE
                P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeProfissional ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Profissional] = $row->NomeProfissional;
        }

        return $array;
    }

	public function select_profissional2() {

        $query = $this->db->query('
            SELECT
                P2.idApp_Profissional,
                P2.NomeProfissional
            FROM
                App_Profissional AS P2
            WHERE
                P2.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				P2.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeProfissional ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Profissional] = $row->NomeProfissional;
        }

        return $array;
    }

	public function select_profissional3() {

        $query = $this->db->query('
            SELECT
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY F.Abrev ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Profissional] = $row->NomeProfissional;
        }

        return $array;
    }

	public function select_convenio() {

        $query = $this->db->query('
            SELECT
                P.idTab_Convenio,
                P.Convenio
            FROM
                Tab_Convenio AS P
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Convenio ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Convenio] = $row->Convenio;
        }

        return $array;
    }

	public function select_formapag() {

        $query = $this->db->query('
            SELECT
                P.idTab_FormaPag,
                P.FormaPag
            FROM
                Tab_FormaPag AS P
            WHERE
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                FormaPag ASC
        ');

        $array = array();
        $array[0] = '::TODOS::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_FormaPag] = $row->FormaPag;
        }

        return $array;
    }
	
	public function select_tipofrete() {

        $query = $this->db->query('
            SELECT
                P.idTab_TipoFrete,
                P.TipoFrete
            FROM
                Tab_TipoFrete AS P
            ORDER BY
                TipoFrete ASC
        ');

        $array = array();
        $array[0] = '::TODOS::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFrete] = $row->TipoFrete;
        }

        return $array;
    }	

	public function select_dia() {

        $query = $this->db->query('
            SELECT
				D.idTab_Dia,
				D.Dia				
			FROM
				Tab_Dia AS D
			ORDER BY
				D.Dia
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Dia] = $row->Dia;
        }

        return $array;
    }	
	
	public function select_mes() {

        $query = $this->db->query('
            SELECT
				M.idTab_Mes,
				M.Mesdesc,
				CONCAT(M.Mes, " - ", M.Mesdesc) AS Mes
			FROM
				Tab_Mes AS M

			ORDER BY
				M.Mes
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Mes] = $row->Mes;
        }

        return $array;
    }	

	public function select_ano() {

        $query = $this->db->query('
            SELECT
				A.idTab_Ano,
				A.Ano				
			FROM
				Tab_Ano AS A
			ORDER BY
				A.Ano
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->Ano] = $row->Ano;
        }

        return $array;
    }	
	
	public function select_tipofinanceiro() {

        $query = $this->db->query('
            SELECT
				TR.idTab_TipoFinanceiro,
				TR.TipoFinanceiro
			FROM
				Tab_TipoFinanceiro AS TR
			WHERE
				TR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
			ORDER BY
				TR.TipoFinanceiro
        ');

        $array = array();
        $array[0] = ':: TODOS ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
        }

        return $array;
    }
	
	public function select_tipofinanceiroR() {

		$permissao1 = ($_SESSION['log']['idSis_Empresa'] != 5 ) ? ' AND (TR.EP = "E" OR TR.EP = "EP")' : FALSE;
		$permissao2 = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? ' AND (TR.EP = "P" OR TR.EP = "EP" )' : FALSE;
		
        $query = $this->db->query('
            SELECT
				TR.idTab_TipoFinanceiro,
				TR.TipoFinanceiro,
				TR.RD
			FROM
				Tab_TipoFinanceiro AS TR
			WHERE
				TR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TR.RD = "R" OR TR.RD = "RD")
					' . $permissao1 . '
					' . $permissao2 . '				
			ORDER BY
				TR.TipoFinanceiro
        ');

        $array = array();
        $array[0] = ':: TODOS ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
        }

        return $array;
    }

	public function select_tipofinanceiroD() {

		$permissao1 = ($_SESSION['log']['idSis_Empresa'] != 5 ) ? ' AND (TR.EP = "E" OR TR.EP = "EP")' : FALSE;
		$permissao2 = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? ' AND (TR.EP = "P" OR TR.EP = "EP" )' : FALSE;	
	
        $query = $this->db->query('
            SELECT
				TR.idTab_TipoFinanceiro,
				TR.TipoFinanceiro,
				TR.RD
			FROM
				Tab_TipoFinanceiro AS TR
			WHERE
				TR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TR.RD = "D" OR TR.RD = "RD")
					' . $permissao1 . '
					' . $permissao2 . '				
			ORDER BY
				TR.TipoFinanceiro
        ');

        $array = array();
        $array[0] = ':: TODOS ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
        }

        return $array;
    }
	
	public function select_tiporeceita() {

        $query = $this->db->query('
            SELECT
				TR.idTab_TipoFinanceiro,
				TR.TipoFinanceiro
			FROM
				Tab_TipoFinanceiro AS TR
			WHERE
				TR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
			ORDER BY
				TR.TipoFinanceiro
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
        }

        return $array;
    }
	
	public function select_tipodespesa() {

        $query = $this->db->query('
            SELECT
				TD.idTab_TipoFinanceiro,
				CONCAT(TD.TipoFinanceiro) AS TipoFinanceiro


			FROM
				Tab_TipoFinanceiro AS TD

			WHERE
				TD.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
			ORDER BY

				TD.TipoFinanceiro
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
        }

        return $array;
    }

	public function select_tipoproduto() {

        $query = $this->db->query('
            SELECT
				TD.idTab_TipoProduto,
				TD.Abrev,
				CONCAT(TD.TipoProduto) AS TipoProduto
			FROM
				Tab_TipoProduto AS TD

			ORDER BY
				TD.TipoProduto DESC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->Abrev] = $row->TipoProduto;
        }

        return $array;
    }
	
	public function select_categoriadesp() {

        $query = $this->db->query('
            SELECT
				Categoriadesp
			FROM
				Tab_Categoriadesp

			ORDER BY
				Categoriadesp
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->Categoriadesp] = $row->Categoriadesp;
        }

        return $array;
    }

	public function select_categoriaempresa() {

        $query = $this->db->query('
            SELECT
				idTab_CategoriaEmpresa,
				CategoriaEmpresa
			FROM
				Tab_CategoriaEmpresa

			ORDER BY
				CategoriaEmpresa
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_CategoriaEmpresa] = $row->CategoriaEmpresa;
        }

        return $array;
    }
	
	public function select_atuacao() {

        $query = $this->db->query('
            SELECT
				idSis_Empresa,
				NomeEmpresa,
				CONCAT(idSis_Empresa, " - ", NomeEmpresa, " ->>>>- ", Atuacao) AS Atuacao
			FROM
				Sis_Empresa

			ORDER BY
				NomeEmpresa
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Empresa] = $row->Atuacao;
        }

        return $array;
    }	
	
	public function select_tipoconsumo() {

        $query = $this->db->query('
            SELECT
                TD.idTab_TipoConsumo,
                TD.TipoConsumo
            FROM
                Tab_TipoConsumo AS TD
			WHERE
				TD.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                TipoConsumo ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoConsumo] = $row->TipoConsumo;
        }

        return $array;
    }

	public function select_tipodevolucao() {

        $query = $this->db->query('
            SELECT
                idTab_TipoDevolucao,
                TipoDevolucao
            FROM
                Tab_TipoDevolucao
            ORDER BY
                TipoDevolucao DESC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoDevolucao] = $row->TipoDevolucao;
        }

        return $array;
    }

	public function select_obstarefa() {

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OB.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        
		$query = $this->db->query('
            SELECT
                OB.idApp_Procedimento,
                OB.Procedimento
            FROM
                App_Procedimento AS OB
            WHERE
                ' . $permissao . '
				OB.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				OB.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                OB.Procedimento ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Procedimento] = $row->Procedimento;
        }

        return $array;
    }

	public function select_tarefa() {

		$permissao1 = (($_SESSION['FiltroAlteraProcedimento']['Categoria'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['Categoria'] != '' )) ? 'P.Categoria = "' . $_SESSION['FiltroAlteraProcedimento']['Categoria'] . '" AND ' : FALSE;
		#$permissao2 = (($_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] != '' )) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] . '" AND ' : FALSE;
		$permissao3 = (($_SESSION['FiltroAlteraProcedimento']['Prioridade'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['Prioridade'] != '' )) ? 'P.Prioridade = "' . $_SESSION['FiltroAlteraProcedimento']['Prioridade'] . '" AND ' : FALSE;
		$permissao7 = (($_SESSION['FiltroAlteraProcedimento']['Statustarefa'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['Statustarefa'] != '' )) ? 'P.Statustarefa = "' . $_SESSION['FiltroAlteraProcedimento']['Statustarefa'] . '" AND ' : FALSE;
		$permissao8 = (($_SESSION['FiltroAlteraProcedimento']['Statussubtarefa'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['Statussubtarefa'] != '' )) ? 'SP.Statussubtarefa = "' . $_SESSION['FiltroAlteraProcedimento']['Statussubtarefa'] . '" AND ' : FALSE;
		$permissao6 = (($_SESSION['FiltroAlteraProcedimento']['SubPrioridade'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['SubPrioridade'] != '' )) ? 'SP.Prioridade = "' . $_SESSION['FiltroAlteraProcedimento']['SubPrioridade'] . '" AND ' : FALSE;
		#$permissao4 = ((($_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] != "0")&& ($_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] != 'M') ) && ($_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] != '' )) ? 'SP.ConcluidoSubProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] . '" AND ' : FALSE;
		#$permissao5 = (($_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] == 'M') && ($_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] != '' )) ? '((SP.ConcluidoSubProcedimento = "S") OR (SP.ConcluidoSubProcedimento = "N")) AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
                P.idApp_Procedimento,
                P.Procedimento
            FROM
				App_Procedimento AS P
					LEFT JOIN App_SubProcedimento AS SP ON SP.idApp_Procedimento = P.idApp_Procedimento
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoProcedimento
					LEFT JOIN Tab_Prioridade AS PR ON PR.idTab_Prioridade = P.Prioridade
            WHERE
				' . $permissao1 . '
				' . $permissao3 . '
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao8 . '
				(U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				AU.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				P.Compartilhar = ' . $_SESSION['log']['idSis_Usuario'] . ' OR
				(P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') OR
				(P.Compartilhar = 51 AND P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '))
            ORDER BY
                P.Procedimento ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Procedimento] = $row->Procedimento;
        }

        return $array;
    }

    public function select_categoria() {

		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
		}else{
			if($_SESSION['Usuario']['Nivel'] == 2){
				$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
			}else{
				$permissao = 'C.NivelCategoria = "1" AND';
			}
		}
		
		$query = $this->db->query('
            SELECT
                C.idTab_Categoria,
                C.Categoria
            FROM
                Tab_Categoria AS C
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = C.idSis_Usuario
            WHERE
				' . $permissao . '
				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                C.Categoria ASC
        ');

        $array = array();
        $array[0] = '::Todos::';
        foreach ($query->result() as $row) {
			$array[$row->idTab_Categoria] = $row->Categoria;
        }

        return $array;
    }

	public function select_tarefa1() {

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OB.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        
		$query = $this->db->query('
            SELECT
                OB.idApp_Procedimento,
                OB.Procedimento
            FROM
                App_Procedimento AS OB
            WHERE
                ' . $permissao . '
				OB.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                OB.Procedimento ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Procedimento] = $row->Procedimento;
        }

        return $array;
    }

	public function select_promocao() {
		
        $query = $this->db->query('
            SELECT
                TPM.*
            FROM
                Tab_Promocao AS TPM
            WHERE
				TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPM.Desconto = "2"
            ORDER BY
				Promocao ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Promocao] = $row->Promocao;
        }

        return $array;
    }

	public function select_catprod() {
		
        $query = $this->db->query('
            SELECT
                P.idTab_Catprod,
                P.Catprod
            FROM
                Tab_Catprod AS P
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                Catprod ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Catprod] = $row->Catprod;
        }

        return $array;
    }
		
	public function select_produto() {
		
        $query = $this->db->query('
            SELECT
				TP.*,
				CONCAT(IFNULL(TP.Produtos,"")) AS Produtos
            FROM
                Tab_Produto AS TP
            WHERE
				TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
				Produtos ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Produto] = $row->Produtos;
        }

        return $array;
    }
		
	public function select_produtos() {
		
        $query = $this->db->query('
            SELECT
                TPS.*,
				CONCAT(IFNULL(TPS.Nome_Prod,"")) AS Produtos
            FROM
                Tab_Produtos AS TPS
            WHERE
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
				Produtos ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Produtos] = $row->Produtos;
        }

        return $array;
    }
	
	public function select_produtos1() {
		
        $query = $this->db->query('
            SELECT
                OB.idTab_Produtos,
				CONCAT(IFNULL(OB.Nome_Prod,"")) AS Produtos
            FROM
                Tab_Produtos AS OB
            WHERE
				OB.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
				Produtos ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Produtos] = $row->Produtos;
        }

        return $array;
    }
	
	public function select_orcatrata() {

        $query = $this->db->query('
            SELECT
                CONCAT(P.idApp_OrcaTrata, " - ",C.NomeCliente) AS idApp_OrcaTrata,
                P.idApp_Cliente,
				C.NomeCliente
            FROM
                App_OrcaTrata AS P
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                idApp_OrcaTrata ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_OrcaTrata] = $row->idApp_OrcaTrata;
        }

        return $array;
    }

	public function select_obsorca() {

        $query = $this->db->query('
            SELECT
                P.idApp_OrcaTrata,
                P.ObsOrca
            FROM
                App_OrcaTrata AS P
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                idApp_OrcaTrata ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_OrcaTrata] = $row->ObsOrca;
        }

        return $array;
    }
	
	public function select_servicos() {

        $query = $this->db->query('
            SELECT
                OB.idApp_Servicos,
                OB.Servicos
            FROM
                App_Servicos AS OB
            WHERE
                OB.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OB.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Servicos ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Servicos] = $row->Servicos;
        }

        return $array;
    }

	public function select_procedtarefa() {

        $query = $this->db->query('
            SELECT
                OB.idApp_SubProcedimento,
                OB.SubProcedimento
            FROM
                App_SubProcedimento AS OB
            WHERE
                OB.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				OB.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                SubProcedimento ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_SubProcedimento] = $row->SubProcedimento;
        }

        return $array;
    }

	public function select_usuario() {

        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome, ""), " - ", IFNULL(P.idSis_Usuario,"")) AS NomeUsuario
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				P.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }

        return $array;
    }

	public function select_usuario_associado() {

        $query = $this->db->query('
            SELECT
				C.idSis_Usuario_5,
				P.idSis_Usuario,
				CONCAT(IFNULL(C.idApp_Cliente,""), " --- ", IFNULL(P.Nome,""), " --- ", IFNULL(P.CelularUsuario,"")) AS NomeAssociado
            FROM
                App_Cliente AS C
					LEFT JOIN Sis_Usuario AS P ON P.idSis_Usuario = C.idSis_Usuario_5
					LEFT JOIN App_OrcaTrata AS OT ON OT.Associado = P.idSis_Usuario
            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				C.NomeCliente ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeAssociado;
        }

        return $array;
    }
	
	public function select_orcarec() {

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
				idApp_OrcaTrata,
				idSis_Usuario,
				idSis_Empresa,
				idTab_TipoRD
			FROM
				App_OrcaTrata
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao . '
				idTab_TipoRD = "2"
			ORDER BY
				idApp_OrcaTrata
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idApp_OrcaTrata] = $row->idApp_OrcaTrata;
        }

        return $array;
    }	

	public function select_orcades() {

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
				idApp_OrcaTrata,
				idSis_Usuario,
				idSis_Empresa,
				idTab_TipoRD
			FROM
				App_OrcaTrata
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao . '
				idTab_TipoRD = "1"
			ORDER BY
				idApp_OrcaTrata
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idApp_OrcaTrata] = $row->idApp_OrcaTrata;
        }

        return $array;
    }	

	public function select_compartilhar() {

        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS NomeUsuario
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				P.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }

        return $array;
    }

	public function select_motivo() {

        $query = $this->db->query('
            SELECT
				*,
				CONCAT(IFNULL(Motivo,"")) AS Motivo
            FROM
                Tab_Motivo
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Motivo ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Motivo] = $row->Motivo;
        }

        return $array;
    }
	
}