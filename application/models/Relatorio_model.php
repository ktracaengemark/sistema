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

    public function list_financeiro($data, $completo) {

        /*
        $consulta = ($data['DataFim']) ? $data['Pesquisa'] . ' <= "' . $data['DataFim'] . '" AND ' : FALSE;
        ' . $data['Pesquisa'] . ' >= "' . $data['DataInicio'] . '" AND
        ' . $consulta . '
        ' . $data['Pesquisa'] . ' ASC,
        #C.NomeCliente ASC
        */

        
        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '" AND PR.DataVencimentoRecebiveis <= "' . $data['DataFim'] . '") OR
                (PR.DataPagoRecebiveis >= "' . $data['DataInicio'] . '" AND PR.DataPagoRecebiveis <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '") OR
                (PR.DataPagoRecebiveis >= "' . $data['DataInicio'] . '")';
        }
		
		$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ServicoConcluido'] != '#') ? 'OT.ServicoConcluido = "' . $data['ServicoConcluido'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ServicoConcluido,
                PR.ParcelaRecebiveis,
                PR.DataVencimentoRecebiveis,
                PR.ValorParcelaRecebiveis,
				PR.ValorParcelaPagaveis,
                PR.DataPagoRecebiveis,
                PR.ValorPagoRecebiveis,
				PR.ValorPagoPagaveis,
                PR.QuitadoRecebiveis

            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_ParcelasRecebiveis AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata

            WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '
                ' . $filtro2 . '
                ' . $filtro3 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '

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

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimentoRecebiveis = $this->basico->mascara_data($row->DataVencimentoRecebiveis, 'barras');
                $row->DataPagoRecebiveis = $this->basico->mascara_data($row->DataPagoRecebiveis, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
                $row->QuitadoRecebiveis = $this->basico->mascara_palavra_completa($row->QuitadoRecebiveis, 'NS');

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

                $somarecebido += $row->ValorPagoRecebiveis;
                $somareceber += $row->ValorParcelaRecebiveis;
				$somapago += $row->ValorPagoPagaveis;
				$somapagar += $row->ValorParcelaPagaveis;

                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcelaRecebiveis = number_format($row->ValorParcelaRecebiveis, 2, ',', '.');
                $row->ValorPagoRecebiveis = number_format($row->ValorPagoRecebiveis, 2, ',', '.');
				$row->ValorParcelaPagaveis = number_format($row->ValorParcelaPagaveis, 2, ',', '.');
				$row->ValorPagoPagaveis = number_format($row->ValorPagoPagaveis, 2, ',', '.');
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
	
	public function list_receitas($data, $completo) {

        
        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '" AND PR.DataVencimentoRecebiveis <= "' . $data['DataFim'] . '") OR
                (PR.DataPagoRecebiveis >= "' . $data['DataInicio'] . '" AND PR.DataPagoRecebiveis <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '") OR
                (PR.DataPagoRecebiveis >= "' . $data['DataInicio'] . '")';
        }
		
		$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ServicoConcluido'] != '#') ? 'OT.ServicoConcluido = "' . $data['ServicoConcluido'] . '" AND ' : FALSE;
		$filtro4 = ($data['QuitadoRecebiveis'] != '#') ? 'PR.QuitadoRecebiveis = "' . $data['QuitadoRecebiveis'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ServicoConcluido,
                PR.ParcelaRecebiveis,
                PR.DataVencimentoRecebiveis,
                PR.ValorParcelaRecebiveis,
				PR.ValorParcelaPagaveis,
                PR.DataPagoRecebiveis,
                PR.ValorPagoRecebiveis,
				PR.ValorPagoPagaveis,
                PR.QuitadoRecebiveis

            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_ParcelasRecebiveis AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata

            WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                (' . $consulta . ') AND				
                ' . $filtro1 . '
                ' . $filtro2 . '
                ' . $filtro3 . '
				' . $filtro4 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '

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

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimentoRecebiveis = $this->basico->mascara_data($row->DataVencimentoRecebiveis, 'barras');
                $row->DataPagoRecebiveis = $this->basico->mascara_data($row->DataPagoRecebiveis, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
                $row->QuitadoRecebiveis = $this->basico->mascara_palavra_completa($row->QuitadoRecebiveis, 'NS');

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

                $somarecebido += $row->ValorPagoRecebiveis;
                $somareceber += $row->ValorParcelaRecebiveis;
				$somapago += $row->ValorPagoPagaveis;
				$somapagar += $row->ValorParcelaPagaveis;

                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcelaRecebiveis = number_format($row->ValorParcelaRecebiveis, 2, ',', '.');
                $row->ValorPagoRecebiveis = number_format($row->ValorPagoRecebiveis, 2, ',', '.');
				$row->ValorParcelaPagaveis = number_format($row->ValorParcelaPagaveis, 2, ',', '.');
				$row->ValorPagoPagaveis = number_format($row->ValorPagoPagaveis, 2, ',', '.');
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
	
	public function list_despesas($data, $completo) {
       
        if ($data['DataFim']) {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '" AND PP.DataVencimentoPagaveis <= "' . $data['DataFim'] . '") OR
                (PP.DataPagoPagaveis >= "' . $data['DataInicio'] . '" AND PP.DataPagoPagaveis <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '") OR
                (PP.DataPagoPagaveis >= "' . $data['DataInicio'] . '")';
        }
		
		$data['TipoDespesa'] = ($data['TipoDespesa']) ? ' AND TD.idTab_TipoDespesa = ' . $data['TipoDespesa'] : FALSE;
        $filtro2 = ($data['QuitadoDespesas'] != '#') ? 'DS.QuitadoDespesas = "' . $data['QuitadoDespesas'] . '" AND ' : FALSE;
		$filtro4 = ($data['QuitadoPagaveis'] != '#') ? 'PP.QuitadoPagaveis = "' . $data['QuitadoPagaveis'] . '" AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT

                DS.idApp_Despesas,
				DS.Despesa,
				TD.TipoDespesa,
                DS.DataDespesas,
                DS.DataEntradaDespesas,
                DS.ValorEntradaDespesas,
				DS.QuitadoDespesas,
                PP.ParcelaPagaveis,
                PP.DataVencimentoPagaveis,
                PP.ValorParcelaPagaveis,
                PP.DataPagoPagaveis,
				PP.ValorPagoPagaveis,
                PP.QuitadoPagaveis

            FROM

                App_Despesas AS DS
                    LEFT JOIN App_ParcelasPagaveis AS PP ON DS.idApp_Despesas = PP.idApp_Despesas							
                    LEFT JOIN Tab_TipoDespesa AS TD ON TD.idTab_TipoDespesa = DS.TipoDespesa

            WHERE
                DS.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND               
				' . $filtro2 . '				
				' . $filtro4 . '
				(' . $consulta . ') 
				' . $data['TipoDespesa'] . '

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

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');
                $row->DataEntradaDespesas = $this->basico->mascara_data($row->DataEntradaDespesas, 'barras');
                $row->DataVencimentoPagaveis = $this->basico->mascara_data($row->DataVencimentoPagaveis, 'barras');
                $row->DataPagoPagaveis = $this->basico->mascara_data($row->DataPagoPagaveis, 'barras');	
				$row->QuitadoDespesas = $this->basico->mascara_palavra_completa($row->QuitadoDespesas, 'NS');				
                $row->QuitadoPagaveis = $this->basico->mascara_palavra_completa($row->QuitadoPagaveis, 'NS');

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_Despesas) {
                    $ant = $row->idApp_Despesas;
                    $somaentrada += $row->ValorEntradaDespesas;
                }
                else {
                    $row->ValorEntradaDespesas = FALSE;
                    $row->DataEntradaDespesas = FALSE;
                }

                $somarecebido += $row->ValorPagoPagaveis;
                $somareceber += $row->ValorParcelaPagaveis;
				$somapago += $row->ValorPagoPagaveis;
				$somapagar += $row->ValorParcelaPagaveis;

                $row->ValorEntradaDespesas = number_format($row->ValorEntradaDespesas, 2, ',', '.');
                $row->ValorParcelaPagaveis = number_format($row->ValorParcelaPagaveis, 2, ',', '.');
                $row->ValorPagoPagaveis = number_format($row->ValorPagoPagaveis, 2, ',', '.');
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
	
	public function list_balanco($data, $completo) {
       
        if ($data['DataFim']) {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '" AND PP.DataVencimentoPagaveis <= "' . $data['DataFim'] . '") OR
                (PP.DataPagoPagaveis >= "' . $data['DataInicio'] . '" AND PP.DataPagoPagaveis <= "' . $data['DataFim'] . '") OR
				(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '" AND PR.DataVencimentoRecebiveis <= "' . $data['DataFim'] . '") OR
                (PR.DataPagoRecebiveis >= "' . $data['DataInicio'] . '" AND PR.DataPagoRecebiveis <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '") OR
                (PP.DataPagoPagaveis >= "' . $data['DataInicio'] . '") OR
				(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '") OR
                (PR.DataPagoRecebiveis >= "' . $data['DataInicio'] . '")';
        }
		
		
        $query = $this->db->query('
            SELECT

                DS.idApp_Despesas,
                DS.DataDespesas,
                DS.DataEntradaDespesas,
                DS.ValorEntradaDespesas,
                PP.ParcelaPagaveis,
                PP.DataVencimentoPagaveis,
                PP.ValorParcelaPagaveis,
                PP.DataPagoPagaveis,
				PP.ValorPagoPagaveis,
                PP.QuitadoPagaveis,
				
				OT.idApp_OrcaTrata,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
                PR.ParcelaRecebiveis,
                PR.DataVencimentoRecebiveis,
                PR.ValorParcelaRecebiveis,
                PR.DataPagoRecebiveis,
                PR.ValorPagoRecebiveis,
                PR.QuitadoRecebiveis

            FROM

                App_Despesas AS DS
                    LEFT JOIN App_ParcelasPagaveis AS PP ON DS.idApp_Despesas = PP.idApp_Despesas,
				App_OrcaTrata AS OT
                    LEFT JOIN App_ParcelasRecebiveis AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					

            WHERE
                DS.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				OT.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                (' . $consulta . ')

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

            $somapago=$somapagar=$somaentrada=$somaentrada2=$somareceber=$somarecebido=$somareal=$balanco=$somareal2=$balanco2=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');
                $row->DataEntradaDespesas = $this->basico->mascara_data($row->DataEntradaDespesas, 'barras');
                $row->DataVencimentoPagaveis = $this->basico->mascara_data($row->DataVencimentoPagaveis, 'barras');
                $row->DataPagoPagaveis = $this->basico->mascara_data($row->DataPagoPagaveis, 'barras');
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimentoRecebiveis = $this->basico->mascara_data($row->DataVencimentoRecebiveis, 'barras');
                $row->DataPagoRecebiveis = $this->basico->mascara_data($row->DataPagoRecebiveis, 'barras');

                $row->QuitadoPagaveis = $this->basico->mascara_palavra_completa($row->QuitadoPagaveis, 'NS');
				$row->QuitadoRecebiveis = $this->basico->mascara_palavra_completa($row->QuitadoRecebiveis, 'NS');
                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_Despesas) {
                    $ant = $row->idApp_Despesas;
                    $somaentrada += $row->ValorEntradaDespesas;
                }
                else {
                    $row->ValorEntradaDespesas = FALSE;
                    $row->DataEntradaDespesas = FALSE;
                }
				
				if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada2 += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somarecebido += $row->ValorPagoRecebiveis;
                $somareceber += $row->ValorParcelaRecebiveis;
				$somapago += $row->ValorPagoPagaveis;
				$somapagar += $row->ValorParcelaPagaveis;

                $row->ValorEntradaDespesas = number_format($row->ValorEntradaDespesas, 2, ',', '.');
                $row->ValorParcelaPagaveis = number_format($row->ValorParcelaPagaveis, 2, ',', '.');
                $row->ValorPagoPagaveis = number_format($row->ValorPagoPagaveis, 2, ',', '.');
				$row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcelaRecebiveis = number_format($row->ValorParcelaRecebiveis, 2, ',', '.');
                $row->ValorPagoRecebiveis = number_format($row->ValorPagoRecebiveis, 2, ',', '.');
				
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
            $query->soma->somaentrada2 = number_format($somaentrada2, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');

            return $query;
        }

    }

    public function list_orcamento($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;

        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ServicoConcluido'] != '#') ? 'OT.ServicoConcluido = "' . $data['ServicoConcluido'] . '" AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,

                OT.ServicoConcluido,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataRetorno,
				PR.NomeProfissional


            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
				LEFT JOIN App_Profissional AS PR ON PR.idApp_Profissional = OT.ProfissionalOrca

            WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '
                ' . $filtro2 . '
				' . $filtro3 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '

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

            $somaorcamento=0;
			$somadesconto=0;
			$somarestante=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
				$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
                $row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

                $somaorcamento += $row->ValorOrca;
                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');
				
				$somadesconto += $row->ValorEntradaOrca;
                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
				
				$somarestante += $row->ValorRestanteOrca;
                $row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');
				
				

            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somadesconto = number_format($somadesconto, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');

            return $query;
        }

    }

	public function list_despesa($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(D.DataDesp >= "' . $data['DataInicio'] . '" AND D.DataDesp <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(D.DataDesp >= "' . $data['DataInicio'] . '")';
        }
		
		if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['TipoDespesa'] = ($data['TipoDespesa']) ? ' AND TD.idTab_TipoDespesa = ' . $data['TipoDespesa'] : FALSE;
		#$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        #$filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                D.Despesa,
                D.idApp_Despesa,
                TD.TipoDespesa,
                D.DataDesp,
                D.ValorTotalDesp,
				FP.FormaPag,
				E.NomeEmpresa AS Empresa,
				OT.idApp_OrcaTrata,
                OT.DataOrca,
				OT.ValorOrca

            FROM
                App_OrcaTrata AS OT,
				App_Despesa AS D				
                    LEFT JOIN Tab_TipoDespesa AS TD ON TD.idTab_TipoDespesa = D.TipoDespesa
                    LEFT JOIN Tab_FormaPag    AS FP ON FP.idTab_FormaPag    = D.FormaPag
                    LEFT JOIN App_Empresa     AS E  ON E.idApp_Empresa      = D.Empresa

            WHERE
                
				D.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				OT.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				(' . $consulta . ')
				' . $data['TipoDespesa'] . ' 

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

            $somadespesa=0;
            foreach ($query->result() as $row) {
				$row->DataDesp = $this->basico->mascara_data($row->DataDesp, 'barras');
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                #$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                #$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                #$row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                #$row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
                #$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

                $somadespesa += $row->ValorTotalDesp;

                $row->ValorTotalDesp = number_format($row->ValorTotalDesp, 2, ',', '.');

            }
            $query->soma = new stdClass();
            $query->soma->somadespesa = number_format($somadespesa, 2, ',', '.');

            return $query;
        }

    }

    public function list_clientes($data, $completo) {

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
				C.idApp_Cliente,
                C.NomeCliente,
                C.DataNascimento,
                C.Telefone1,
                C.Telefone2,
                C.Telefone3,
                C.Sexo,
                C.Endereco,
                C.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                C.Email,
				CC.NomeContatoCliente,
				CC.RelaCom,
				CC.Sexo

            FROM
                App_Cliente AS C
                    LEFT JOIN Tab_Municipio AS M ON C.Municipio = M.idTab_Municipio
					LEFT JOIN App_ContatoCliente AS CC ON C.idApp_Cliente = CC.idApp_Cliente
            WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ' . $data['NomeCliente'] . '

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
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');

                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->Telefone1 = ($row->Telefone1) ? $row->Telefone1 : FALSE;
				$row->Telefone2 = ($row->Telefone2) ? $row->Telefone2 : FALSE;
				$row->Telefone3 = ($row->Telefone3) ? $row->Telefone3 : FALSE;

                #$row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                #$row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

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
				P.Funcao,
                P.DataNascimento,
                P.Telefone1,
                P.Telefone2,
                P.Telefone3,
                P.Sexo,
                P.Endereco,
                P.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                P.Email,
				CP.NomeContatoProf,
				CP.RelaPes,
				CP.Sexo

            FROM
                App_Profissional AS P
                    LEFT JOIN Tab_Municipio AS M ON P.Municipio = M.idTab_Municipio
					LEFT JOIN App_ContatoProf AS CP ON P.idApp_Profissional = CP.idApp_Profissional
            WHERE
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
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

                $row->Telefone = ($row->Telefone1) ? $row->Telefone1 : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_empresas($data, $completo) {

        $data['Campo'] = (!$data['Campo']) ? 'E.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                E.idApp_Empresa,
                E.NomeEmpresa,
				E.Atividade,
                E.DataNascimento,
                E.Telefone1,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.Endereco,
                E.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                E.Email,
				CE.NomeContato,
				CE.RelaCom,
				CE.Sexo

            FROM
                App_Empresa AS E
                    LEFT JOIN Tab_Municipio AS M ON E.Municipio = M.idTab_Municipio
					LEFT JOIN App_Contato AS CE ON E.idApp_Empresa = CE.idApp_Empresa
            WHERE
                E.idSis_Usuario = ' . $_SESSION['log']['id'] . '


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

                $row->Telefone = ($row->Telefone1) ? $row->Telefone1 : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_orcamentopc($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['NomeProfissional'] = ($data['NomeProfissional']) ? ' AND PR.idApp_Profissional = ' . $data['NomeProfissional'] : FALSE;
        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        #$filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ServicoConcluido'] != '#') ? 'OT.ServicoConcluido = "' . $data['ServicoConcluido'] . '" AND ' : FALSE;
		$filtro4 = ($data['ConcluidoProcedimento'] != '#') ? 'PC.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;


        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataPrazo,
                OT.ValorOrca,

                OT.ServicoConcluido,

                OT.DataConclusao,


				TPD.NomeProduto,

				PC.DataProcedimento,
				PR.NomeProfissional,
				PC.Procedimento,
				PC.ConcluidoProcedimento

			FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
					LEFT JOIN App_ProdutoVenda AS PD ON OT.idApp_OrcaTrata = PD.idApp_OrcaTrata
					LEFT JOIN Tab_Produto AS TPD ON TPD.idTab_Produto = PD.idTab_Produto
					LEFT JOIN App_Procedimento AS PC ON OT.idApp_OrcaTrata = PC.idApp_OrcaTrata
					LEFT JOIN App_Profissional AS PR ON PR.idApp_Profissional = PC.Profissional
					
					
			WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '

				' . $filtro3 . '
				' . $filtro4 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '
				' . $data['NomeProfissional'] . ' 
				

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

            $somaorcamento=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                #$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
                #$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');


				$somaorcamento += $row->ValorOrca;

                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');

            return $query;
        }

    }

	public function list_tarefa($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(TF.DataTarefa >= "' . $data['DataInicio'] . '" AND TF.DataTarefa <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TF.DataTarefa >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeProfissional'] = ($data['NomeProfissional']) ? ' AND P.idApp_Profissional = ' . $data['NomeProfissional'] : FALSE;
		$data['Profissional'] = ($data['Profissional']) ? ' AND P2.idApp_Profissional = ' . $data['Profissional'] : FALSE;
		
		$data['ObsTarefa'] = ($data['ObsTarefa']) ? ' AND TF.idApp_Tarefa = ' . $data['ObsTarefa'] : FALSE;
        
		$data['Procedtarefa'] = ($data['Procedtarefa']) ? ' AND PT.idApp_Procedtarefa = ' . $data['Procedtarefa'] : FALSE;
		
		$filtro5 = ($data['AprovadoTarefa'] != '#') ? 'TF.AprovadoTarefa = "' . $data['AprovadoTarefa'] . '" AND ' : FALSE;
		
        $filtro6 = ($data['QuitadoTarefa'] != '#') ? 'TF.QuitadoTarefa = "' . $data['QuitadoTarefa'] . '" AND ' : FALSE;
		$filtro7 = ($data['ServicoConcluido'] != '#') ? 'TF.ServicoConcluido = "' . $data['ServicoConcluido'] . '" AND ' : FALSE;
		$filtro8 = ($data['ConcluidoProcedtarefa'] != '#') ? 'PT.ConcluidoProcedtarefa = "' . $data['ConcluidoProcedtarefa'] . '" AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT

				P.NomeProfissional,
                TF.idApp_Tarefa,				
				TF.ObsTarefa,
                TF.AprovadoTarefa,
                TF.DataTarefa,
				TF.QuitadoTarefa,
				TF.ServicoConcluido,
				TF.DataPrazoTarefa,
				TF.DataConclusao,
				P2.NomeProfissional AS Profissional,
				PT.idApp_Procedtarefa,
				PT.Procedtarefa,
				PT.DataProcedtarefa,
				PT.ConcluidoProcedtarefa

            FROM

                App_Tarefa AS TF
					
					LEFT JOIN App_Procedtarefa AS PT ON TF.idApp_Tarefa = PT.idApp_Tarefa
					LEFT JOIN App_Profissional AS P ON P.idApp_Profissional = TF.ProfissionalTarefa
					LEFT JOIN App_Profissional AS P2 ON P2.idApp_Profissional = PT.Profissional

            WHERE
                TF.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				TF.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND			
					'.$filtro5.'
					'.$filtro6.'
					'.$filtro7.'
					'.$filtro8.'
				(' . $consulta . ')
                ' . $data['NomeProfissional'] . ' 
				' . $data['Profissional'] . '
				' . $data['ObsTarefa'] . '
				' . $data['Procedtarefa'] . '
				                 
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

            $somatarefa=0;
            foreach ($query->result() as $row) {
				$row->DataTarefa = $this->basico->mascara_data($row->DataTarefa, 'barras');
				$row->DataPrazoTarefa = $this->basico->mascara_data($row->DataPrazoTarefa, 'barras');
				$row->DataProcedtarefa = $this->basico->mascara_data($row->DataProcedtarefa, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');

				$row->AprovadoTarefa = $this->basico->mascara_palavra_completa($row->AprovadoTarefa, 'NS');
                $row->QuitadoTarefa = $this->basico->mascara_palavra_completa($row->QuitadoTarefa, 'NS');
				$row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
				$row->ConcluidoProcedtarefa = $this->basico->mascara_palavra_completa($row->ConcluidoProcedtarefa, 'NS');

            }
            $query->soma = new stdClass();
            $query->soma->somatarefa = number_format($somatarefa, 2, ',', '.');

            return $query;
        }

    }

	public function list_clienteprod($data, $completo) {

        $data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		#$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT

                C.NomeCliente,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				PD.QtdVendaProduto,
				TPD.NomeProduto,
				PC.Procedimento,
				PC.ConcluidoProcedimento

            FROM
                App_Cliente AS C,
				App_OrcaTrata AS OT
				LEFT JOIN App_ProdutoVenda AS PD ON OT.idApp_OrcaTrata = PD.idApp_OrcaTrata
				LEFT JOIN Tab_Produto AS TPD ON TPD.idTab_Produto = PD.idTab_Produto
				LEFT JOIN App_Procedimento AS PC ON OT.idApp_OrcaTrata = PC.idApp_OrcaTrata

            WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND

				C.idApp_Cliente = OT.idApp_Cliente


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
				#$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
				$row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');

				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');

            }

            return $query;
        }

    }

	public function list_orcamentosv($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;

        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        #$filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ServicoConcluido'] != '#') ? 'OT.ServicoConcluido = "' . $data['ServicoConcluido'] . '" AND ' : FALSE;
		$filtro4 = ($data['ConcluidoProcedimento'] != '#') ? 'PC.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;


        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataPrazo,
                OT.ValorOrca,

                OT.ServicoConcluido,

                OT.DataConclusao,

				TSV.NomeServico,

				PC.DataProcedimento,
				PR.NomeProfissional,
				PC.Procedimento,
				PC.ConcluidoProcedimento

			FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
					LEFT JOIN App_ServicoVenda AS SV ON OT.idApp_OrcaTrata = SV.idApp_OrcaTrata
					LEFT JOIN Tab_Servico AS TSV ON TSV.idTab_Servico = SV.idTab_Servico
					LEFT JOIN App_Procedimento AS PC ON OT.idApp_OrcaTrata = PC.idApp_OrcaTrata
					LEFT JOIN App_Profissional AS PR ON PR.idApp_Profissional = PC.Profissional

			WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '

				' . $filtro3 . '
				' . $filtro4 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '

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

            $somaorcamento=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                #$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
                #$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');


				$somaorcamento += $row->ValorOrca;

                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');

            return $query;
        }

    }
	
	public function list_estoque($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;

        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.ValorOrca,
				PD.QtdVendaProduto,
				TPD.NomeProduto,
				PD.ValorVendaProduto

			FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT					
					LEFT JOIN App_ProdutoVenda AS PD ON OT.idApp_OrcaTrata = PD.idApp_OrcaTrata
					LEFT JOIN Tab_Produto AS TPD ON TPD.idTab_Produto = PD.idTab_Produto

			WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '

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

            $somaorcamento=$somavalorvenda=$subtotalvenda=$subtotalcompra=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');

				$somaorcamento += $row->ValorOrca;

                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');

            return $query;
        }

    }

    public function select_cliente() {

        $query = $this->db->query('
            SELECT
                C.idApp_Cliente,
                C.NomeCliente
            FROM
                App_Cliente AS C
            WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . '
            ORDER BY
                NomeCliente ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Cliente] = $row->NomeCliente;
        }

        return $array;
    }

    public function select_profissional() {

        $query = $this->db->query('
            SELECT
                P.idApp_Profissional,
                P.NomeProfissional
            FROM
                App_Profissional AS P
            WHERE
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
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
                P2.idSis_Usuario = ' . $_SESSION['log']['id'] . '
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
	
	public function select_tipodespesa() {

        $query = $this->db->query('
            SELECT
                TD.idTab_TipoDespesa,
                TD.TipoDespesa
            FROM
                Tab_TipoDespesa AS TD
            
            ORDER BY
                TipoDespesa ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoDespesa] = $row->TipoDespesa;
        }

        return $array;
    }
	
	public function select_obstarefa() {

        $query = $this->db->query('
            SELECT
                OB.idApp_Tarefa,
                OB.ObsTarefa
            FROM
                App_Tarefa AS OB
            WHERE
                OB.idSis_Usuario = ' . $_SESSION['log']['id'] . '
            ORDER BY
                ObsTarefa ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Tarefa] = $row->ObsTarefa;
        }

        return $array;
    }
	
	public function select_procedtarefa() {

        $query = $this->db->query('
            SELECT
                OB.idApp_Procedtarefa,
                OB.Procedtarefa
            FROM
                App_Procedtarefa AS OB
            WHERE
                OB.idSis_Usuario = ' . $_SESSION['log']['id'] . '
            ORDER BY
                Procedtarefa ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Procedtarefa] = $row->Procedtarefa;
        }

        return $array;
    }

}
