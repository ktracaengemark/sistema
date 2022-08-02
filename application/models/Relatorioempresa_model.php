<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorioempresa_model extends CI_Model {

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
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
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
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
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
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
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
                '(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '" AND PR.DataVencimentoRecebiveis <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPagoRecebiveis >= "' . $data['DataInicio2'] . '" AND PR.DataPagoRecebiveis <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPagoRecebiveis >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }

		$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimentoRecebiveis) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPagoRecebiveis) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimentoRecebiveis) = ' . $data['Ano'] : FALSE;
		$data['TipoReceita'] = ($data['TipoReceita']) ? ' AND OT.TipoReceita = ' . $data['TipoReceita'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimentoRecebiveis' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];		
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['QuitadoRecebiveis'] != '#') ? 'PR.QuitadoRecebiveis = "' . $data['QuitadoRecebiveis'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade'] != '#') ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
                C.NomeCliente,
                CONCAT(IFNULL(C.NomeCliente,""), " / ", IFNULL(OT.Receitas,""), " / ", IFNULL(TR.TipoReceita,"")) AS NomeCliente,
				TR.TipoReceita,
				OT.idApp_OrcaTrataCli,
				OT.idSis_Usuario,
				OT.idSis_Empresa,
				OT.TipoRD,
                OT.AprovadoOrca,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
                PR.ParcelaRecebiveis,
                PR.DataVencimentoRecebiveis,
                PR.ValorParcelaRecebiveis,
				PR.ValorParcelaPagaveis,
                PR.DataPagoRecebiveis,
                PR.ValorPagoRecebiveis,
				PR.ValorPagoPagaveis,
                PR.QuitadoRecebiveis,
				CONCAT(PR.ParcelaRecebiveis," ", OT.Modalidade,"/",PR.QuitadoRecebiveis) AS ParcelaRecebiveis
            FROM

                App_OrcaTrataCli AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = OT.idSis_Empresa
                    LEFT JOIN App_ParcelasRecebiveisCli AS PR ON OT.idApp_OrcaTrataCli = PR.idApp_OrcaTrataCli
					LEFT JOIN Tab_TipoReceita AS TR ON TR.idTab_TipoReceita = OT.TipoReceita
            WHERE
                
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro4 . ' 
				' . $filtro5 . '
				OT.TipoRD = "R"
				' . $data['NomeCliente'] . '
				' . $data['Mesvenc'] . ' 
				' . $data['Mespag'] . '
				' . $data['Ano'] . ' 
				' . $data['TipoReceita'] . ' 

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
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->QuitadoRecebiveis = $this->basico->mascara_palavra_completa($row->QuitadoRecebiveis, 'NS');

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrataCli) {
                    $ant = $row->idApp_OrcaTrataCli;
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

	public function list_receitas1($data, $completo) {


        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '" AND PR.DataVencimentoRecebiveis <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPagoRecebiveis >= "' . $data['DataInicio2'] . '" AND PR.DataPagoRecebiveis <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPagoRecebiveis >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }

		$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['QuitadoRecebiveis'] != '#') ? 'PR.QuitadoRecebiveis = "' . $data['QuitadoRecebiveis'] . '" AND ' : FALSE;

        $query = $this->db->query(
            'SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.TipoRD,
                OT.AprovadoOrca,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
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
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
				(' . $consulta2 . ') AND
				(' . $consulta3 . ') AND
                ' . $filtro1 . '
                ' . $filtro2 . '
                ' . $filtro3 . '
				' . $filtro4 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . ' AND
				OT.TipoRD = "R"

            ORDER BY
                C.NomeCliente,
				OT.AprovadoOrca DESC,
				PR.DataVencimentoRecebiveis'
            );

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
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
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

	public function list_despesas1($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '" AND PP.DataVencimentoPagaveis <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '")';
        }

		if ($data['DataFim2']) {
            $consulta2 =
                '(PP.DataPagoPagaveis >= "' . $data['DataInicio2'] . '" AND PP.DataPagoPagaveis <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PP.DataPagoPagaveis >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(DS.DataDespesas >= "' . $data['DataInicio3'] . '" AND DS.DataDespesas <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(DS.DataDespesas >= "' . $data['DataInicio3'] . '")';
        }


		$data['TipoDespesa'] = ($data['TipoDespesa']) ? ' AND TD.idTab_TipoDespesa = ' . $data['TipoDespesa'] : FALSE;
		$filtro1 = ($data['AprovadoDespesas'] != '#') ? 'DS.AprovadoDespesas = "' . $data['AprovadoDespesas'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrcaDespesas'] != '#') ? 'DS.ConcluidoOrcaDespesas = "' . $data['ConcluidoOrcaDespesas'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoDespesas'] != '#') ? 'DS.QuitadoDespesas = "' . $data['QuitadoDespesas'] . '" AND ' : FALSE;
		$filtro4 = ($data['QuitadoPagaveis'] != '#') ? 'PP.QuitadoPagaveis = "' . $data['QuitadoPagaveis'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                DS.idApp_Despesas,
				DS.Despesa,
				TD.TipoDespesa,
				DS.TipoProduto,
                DS.DataDespesas,
                DS.DataEntradaDespesas,
                DS.ValorEntradaDespesas,
				DS.AprovadoDespesas,
				DS.ConcluidoOrcaDespesas,
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
                DS.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				DS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $filtro2 . '
				' . $filtro4 . '
				(' . $consulta . ') AND
				(' . $consulta2 . ') AND
				(' . $consulta3 . ')
				' . $data['TipoDespesa'] . ' AND
				(DS.TipoProduto = "D" OR DS.TipoProduto = "E")
            ORDER BY
				PP.DataVencimentoPagaveis
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
				$row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
				$row->ConcluidoOrcaDespesas = $this->basico->mascara_palavra_completa($row->ConcluidoOrcaDespesas, 'NS');
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

	public function list_despesasprod($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '" AND PP.DataVencimentoPagaveis <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '")';
        }

		if ($data['DataFim2']) {
            $consulta2 =
                '(PP.DataPagoPagaveis >= "' . $data['DataInicio2'] . '" AND PP.DataPagoPagaveis <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PP.DataPagoPagaveis >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(DS.DataDespesas >= "' . $data['DataInicio3'] . '" AND DS.DataDespesas <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(DS.DataDespesas >= "' . $data['DataInicio3'] . '")';
        }


		$data['TipoDespesa'] = ($data['TipoDespesa']) ? ' AND TD.idTab_TipoDespesa = ' . $data['TipoDespesa'] : FALSE;
		$filtro1 = ($data['AprovadoDespesas'] != '#') ? 'DS.AprovadoDespesas = "' . $data['AprovadoDespesas'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrcaDespesas'] != '#') ? 'DS.ConcluidoOrcaDespesas = "' . $data['ConcluidoOrcaDespesas'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoDespesas'] != '#') ? 'DS.QuitadoDespesas = "' . $data['QuitadoDespesas'] . '" AND ' : FALSE;
		$filtro4 = ($data['QuitadoPagaveis'] != '#') ? 'PP.QuitadoPagaveis = "' . $data['QuitadoPagaveis'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                DS.idApp_Despesas,
				DS.Despesa,
				TD.TipoDespesa,
				DS.TipoProduto,
                DS.DataDespesas,
                DS.DataEntradaDespesas,
                DS.ValorEntradaDespesas,
				DS.AprovadoDespesas,
				DS.ConcluidoOrcaDespesas,
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
                DS.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				DS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $filtro2 . '
				' . $filtro4 . '
				(' . $consulta . ') AND
				(' . $consulta2 . ') AND
				(' . $consulta3 . ')
				' . $data['TipoDespesa'] . ' AND
				(DS.TipoProduto = "D" OR DS.TipoProduto = "E")
            ORDER BY
				PP.DataVencimentoPagaveis
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
				$row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
				$row->ConcluidoOrcaDespesas = $this->basico->mascara_palavra_completa($row->ConcluidoOrcaDespesas, 'NS');
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

	public function list_despesaspag($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '" AND PP.DataVencimentoPagaveis <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '")';
        }

		if ($data['DataFim2']) {
            $consulta2 =
                '(PP.DataPagoPagaveis >= "' . $data['DataInicio2'] . '" AND PP.DataPagoPagaveis <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PP.DataPagoPagaveis >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(DS.DataDespesas >= "' . $data['DataInicio3'] . '" AND DS.DataDespesas <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(DS.DataDespesas >= "' . $data['DataInicio3'] . '")';
        }


		$data['TipoDespesa'] = ($data['TipoDespesa']) ? ' AND TD.idTab_TipoDespesa = ' . $data['TipoDespesa'] : FALSE;
		$filtro1 = ($data['AprovadoDespesas'] != '#') ? 'DS.AprovadoDespesas = "' . $data['AprovadoDespesas'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrcaDespesas'] != '#') ? 'DS.ConcluidoOrcaDespesas = "' . $data['ConcluidoOrcaDespesas'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoDespesas'] != '#') ? 'DS.QuitadoDespesas = "' . $data['QuitadoDespesas'] . '" AND ' : FALSE;
		$filtro4 = ($data['QuitadoPagaveis'] != '#') ? 'PP.QuitadoPagaveis = "' . $data['QuitadoPagaveis'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                DS.idApp_Despesas,
				DS.Despesa,
				TD.TipoDespesa,
				DS.TipoProduto,
                DS.DataDespesas,
                DS.DataEntradaDespesas,
                DS.ValorEntradaDespesas,
				DS.AprovadoDespesas,
				DS.ConcluidoOrcaDespesas,
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
                DS.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				DS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $filtro2 . '
				' . $filtro4 . '
				(' . $consulta . ') AND
				(' . $consulta2 . ') AND
				(' . $consulta3 . ')
				' . $data['TipoDespesa'] . ' AND
				(DS.TipoProduto = "D" OR DS.TipoProduto = "E")
            ORDER BY
				PP.DataVencimentoPagaveis
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
				$row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
				$row->ConcluidoOrcaDespesas = $this->basico->mascara_palavra_completa($row->ConcluidoOrcaDespesas, 'NS');
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

	public function list_devolucao1DESPESAS($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '" AND PP.DataVencimentoPagaveis <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PP.DataVencimentoPagaveis >= "' . $data['DataInicio'] . '")';
        }

		if ($data['DataFim2']) {
            $consulta2 =
                '(PP.DataPagoPagaveis >= "' . $data['DataInicio2'] . '" AND PP.DataPagoPagaveis <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PP.DataPagoPagaveis >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(DS.DataDespesas >= "' . $data['DataInicio3'] . '" AND DS.DataDespesas <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(DS.DataDespesas >= "' . $data['DataInicio3'] . '")';
        }


		$data['TipoDespesa'] = ($data['TipoDespesa']) ? ' AND TD.idTab_TipoDespesa = ' . $data['TipoDespesa'] : FALSE;
		$filtro1 = ($data['AprovadoDespesas'] != '#') ? 'DS.AprovadoDespesas = "' . $data['AprovadoDespesas'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrcaDespesas'] != '#') ? 'DS.ConcluidoOrcaDespesas = "' . $data['ConcluidoOrcaDespesas'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoDespesas'] != '#') ? 'DS.QuitadoDespesas = "' . $data['QuitadoDespesas'] . '" AND ' : FALSE;
		$filtro4 = ($data['QuitadoPagaveis'] != '#') ? 'PP.QuitadoPagaveis = "' . $data['QuitadoPagaveis'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                DS.idApp_Despesas,
				DS.Despesa,
				TD.TipoDespesa,
				DS.TipoProduto,
                DS.DataDespesas,
                DS.DataEntradaDespesas,
                DS.ValorEntradaDespesas,
				DS.AprovadoDespesas,
				DS.ConcluidoOrcaDespesas,
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
                DS.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				DS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $filtro2 . '
				' . $filtro4 . '
				(' . $consulta . ') AND
				(' . $consulta2 . ') AND
				(' . $consulta3 . ')
				' . $data['TipoDespesa'] . ' AND
				DS.TipoProduto = "E"
            ORDER BY
				PP.DataVencimentoPagaveis
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
				$row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
				$row->ConcluidoOrcaDespesas = $this->basico->mascara_palavra_completa($row->ConcluidoOrcaDespesas, 'NS');
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

    public function list_balanco($data) {

        ####################################################################
        #SOMATÓRIO DAS RECEITAS DO ANO
        $somareceitas='';
        for ($i=1;$i<=12;$i++){
            $somareceitas .= 'SUM(IF(PR.DataPagoRecebiveis BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorPagoRecebiveis, 0)) AS M' . $i . ', ';
        }
        $somareceitas = substr($somareceitas, 0 ,-2);

        $query['Receitas'] = $this->db->query(
        #$receitas = $this->db->query(
            'SELECT
                ' . $somareceitas . '
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_ParcelasRecebiveis AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                C.idApp_Cliente = OT.idApp_Cliente AND
				OT.TipoRD = "R" AND
            	YEAR(PR.DataPagoRecebiveis) = ' . $data['Ano']
        );

        #$query['Receitas'] = $query['Receitas']->result_array();
        $query['Receitas'] = $query['Receitas']->result();
        $query['Receitas'][0]->Balanco = 'Receitas';


		####################################################################
        #SOMATÓRIO DAS DEVOLUÇÕES DO ANO
        $somadevolucoes='';
        for ($i=1;$i<=12;$i++){
            $somadevolucoes .= 'SUM(IF(PR.DataPagoRecebiveis BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorPagoRecebiveis, 0)) AS M' . $i . ', ';
        }
        $somadevolucoes = substr($somadevolucoes, 0 ,-2);

        $query['Devolucoes'] = $this->db->query(
        #$devolucoes = $this->db->query(
            'SELECT
                ' . $somadevolucoes . '
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_ParcelasRecebiveis AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                C.idApp_Cliente = OT.idApp_Cliente AND
				OT.TipoRD = "D" AND
            	YEAR(PR.DataPagoRecebiveis) = ' . $data['Ano']
        );

        #$query['Devolucoes'] = $query['Devolucoes']->result_array();
        $query['Devolucoes'] = $query['Devolucoes']->result();
        $query['Devolucoes'][0]->Balanco = 'Devolucoes';


        ####################################################################
        #SOMATÓRIO DAS DESPESAS DO ANO
        $somadespesas='';
        for ($i=1;$i<=12;$i++){
            $somadespesas .= 'SUM(IF(PP.DataPagoPagaveis BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PP.ValorPagoPagaveis, 0)) AS M' . $i . ', ';
        }
        $somadespesas = substr($somadespesas, 0 ,-2);

        $query['Despesas'] = $this->db->query(
        #$despesas = $this->db->query(
            'SELECT
                ' . $somadespesas . '
            FROM
                App_Despesas AS DS
                    LEFT JOIN App_ParcelasPagaveis AS PP ON DS.idApp_Despesas = PP.idApp_Despesas
                    LEFT JOIN Tab_TipoDespesa AS TD ON TD.idTab_TipoDespesa = DS.TipoDespesa
            WHERE
                DS.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                DS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (DS.TipoProduto = "D") AND
            	YEAR(PP.DataPagoPagaveis) = ' . $data['Ano']
        );

        #$query['Despesas'] = $query['Despesas']->result_array();
        $query['Despesas'] = $query['Despesas']->result();
        $query['Despesas'][0]->Balanco = 'Despesas';

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit();
        */

        $query['Total'] = new stdClass();
        $query['TotalGeral'] = new stdClass();

        $query['Total']->Balanco = 'Total';
        $query['TotalGeral']->Receitas = $query['TotalGeral']->Devolucoes = $query['TotalGeral']->Despesas = $query['TotalGeral']->BalancoGeral = 0;

        for ($i=1;$i<=12;$i++) {
            $query['Total']->{'M'.$i} = $query['Receitas'][0]->{'M'.$i} - $query['Devolucoes'][0]->{'M'.$i} - $query['Despesas'][0]->{'M'.$i};

            $query['TotalGeral']->Receitas += $query['Receitas'][0]->{'M'.$i};
			$query['TotalGeral']->Devolucoes += $query['Devolucoes'][0]->{'M'.$i};
            $query['TotalGeral']->Despesas += $query['Despesas'][0]->{'M'.$i};

            $query['Receitas'][0]->{'M'.$i} = number_format($query['Receitas'][0]->{'M'.$i}, 2, ',', '.');
            $query['Devolucoes'][0]->{'M'.$i} = number_format($query['Devolucoes'][0]->{'M'.$i}, 2, ',', '.');
			$query['Despesas'][0]->{'M'.$i} = number_format($query['Despesas'][0]->{'M'.$i}, 2, ',', '.');
            $query['Total']->{'M'.$i} = number_format($query['Total']->{'M'.$i}, 2, ',', '.');
        }
        $query['TotalGeral']->BalancoGeral = $query['TotalGeral']->Receitas - $query['TotalGeral']->Devolucoes - $query['TotalGeral']->Despesas;

        $query['TotalGeral']->Receitas = number_format($query['TotalGeral']->Receitas, 2, ',', '.');
        $query['TotalGeral']->Devolucoes = number_format($query['TotalGeral']->Devolucoes, 2, ',', '.');
		$query['TotalGeral']->Despesas = number_format($query['TotalGeral']->Despesas, 2, ',', '.');
        $query['TotalGeral']->BalancoGeral = number_format($query['TotalGeral']->BalancoGeral, 2, ',', '.');

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit();
        */
        return $query;

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

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataConclusao >= "' . $data['DataInicio2'] . '" AND OT.DataConclusao <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataConclusao >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataRetorno >= "' . $data['DataInicio3'] . '" AND OT.DataRetorno <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataRetorno >= "' . $data['DataInicio3'] . '")';
        }

		if ($data['DataFim4']) {
            $consulta4 =
                '(OT.DataQuitado >= "' . $data['DataInicio4'] . '" AND OT.DataQuitado <= "' . $data['DataFim4'] . '")';
        }
        else {
            $consulta4 =
                '(OT.DataQuitado >= "' . $data['DataInicio4'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['FormaPag'] = ($data['FormaPag']) ? ' AND TFP.idTab_FormaPag = ' . $data['FormaPag'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;

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
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.TipoRD,
				OT.FormaPagamento,
				TFP.FormaPag,
				TSU.Nome
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
				LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = OT.idSis_Usuario
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento

            WHERE
				C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
				(' . $consulta2 . ') AND
				(' . $consulta3 . ') AND
				(' . $consulta4 . ') AND
                ' . $filtro1 . '
                ' . $filtro2 . '
				' . $filtro3 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '
				' . $data['FormaPag'] . ' AND
				OT.TipoRD = "R"
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
                $row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
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

	public function list_devolucao1($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataConclusao >= "' . $data['DataInicio2'] . '" AND OT.DataConclusao <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataConclusao >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataRetorno >= "' . $data['DataInicio3'] . '" AND OT.DataRetorno <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataRetorno >= "' . $data['DataInicio3'] . '")';
        }

		if ($data['DataFim4']) {
            $consulta4 =
                '(OT.DataQuitado >= "' . $data['DataInicio4'] . '" AND OT.DataQuitado <= "' . $data['DataFim4'] . '")';
        }
        else {
            $consulta4 =
                '(OT.DataQuitado >= "' . $data['DataInicio4'] . '")';
        }

		$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;

        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        $query = $this->db->query('
            SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.Orcamento,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataQuitado,
				OT.DataConclusao,
                OT.DataRetorno,
				OT.FormaPagamento,
				OT.TipoRD,
				TD.TipoDevolucao,
				TFP.FormaPag,
				TSU.Nome
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
				LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = OT.idSis_Usuario
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoDevolucao AS TD ON TD.idTab_TipoDevolucao = OT.TipoDevolucao
            WHERE
				C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
				(' . $consulta2 . ') AND
				(' . $consulta3 . ') AND
				(' . $consulta4 . ') AND
                ' . $filtro1 . '
                ' . $filtro2 . '
				' . $filtro3 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . ' AND
				OT.TipoRD = "D"
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
                $row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
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

	public function list_devolucao($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataDespesas >= "' . $data['DataInicio'] . '" AND OT.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataConclusaoDespesas >= "' . $data['DataInicio2'] . '" AND OT.DataConclusaoDespesas <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataConclusaoDespesas >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataRetornoDespesas >= "' . $data['DataInicio3'] . '" AND OT.DataRetornoDespesas <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataRetornoDespesas >= "' . $data['DataInicio3'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;

        $filtro1 = ($data['AprovadoDespesas'] != '#') ? 'OT.AprovadoDespesas = "' . $data['AprovadoDespesas'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoDespesas'] != '#') ? 'OT.QuitadoDespesas = "' . $data['QuitadoDespesas'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrcaDespesas'] != '#') ? 'OT.ConcluidoOrcaDespesas = "' . $data['ConcluidoOrcaDespesas'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT

                OT.idApp_Despesas,
				OT.idApp_OrcaTrata,
                OT.AprovadoDespesas,
                OT.DataDespesas,
				OT.DataEntradaDespesas,
                OT.ValorDespesas,
				OT.ValorEntradaDespesas,
				OT.ValorRestanteDespesas,
                OT.ConcluidoOrcaDespesas,
                OT.QuitadoDespesas,
                OT.DataConclusaoDespesas,
                OT.DataRetornoDespesas,
				OT.FormaPagamentoDespesas,
				C.NomeCliente,
				OT.TipoProduto,
				TFP.FormaPag,
				TSU.Nome
            FROM

                App_Despesas AS OT
				LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = OT.idSis_Usuario
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamentoDespesas
				LEFT JOIN App_OrcaTrata AS TR ON TR.idApp_OrcaTrata = OT.idApp_OrcaTrata
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = TR.idApp_Cliente

            WHERE
				OT.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['NomeCliente'] . ' AND
				' . $consulta . ' AND
				' . $consulta2 . ' AND
				' . $consulta3 . ' AND

				OT.TipoProduto = "E"

            ORDER BY
                OT.idApp_Despesas DESC,
				OT.AprovadoDespesas ASC,
				OT.DataDespesas

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
				$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');
				$row->DataEntradaDespesas = $this->basico->mascara_data($row->DataEntradaDespesas, 'barras');
                $row->DataConclusaoDespesas = $this->basico->mascara_data($row->DataConclusaoDespesas, 'barras');
                $row->DataRetornoDespesas = $this->basico->mascara_data($row->DataRetornoDespesas, 'barras');

                $row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
                $row->ConcluidoOrcaDespesas = $this->basico->mascara_palavra_completa($row->ConcluidoOrcaDespesas, 'NS');
                $row->QuitadoDespesas = $this->basico->mascara_palavra_completa($row->QuitadoDespesas, 'NS');

                $somaorcamento += $row->ValorDespesas;
                $row->ValorDespesas = number_format($row->ValorDespesas, 2, ',', '.');

				$somadesconto += $row->ValorEntradaDespesas;
                $row->ValorEntradaDespesas = number_format($row->ValorEntradaDespesas, 2, ',', '.');

				$somarestante += $row->ValorRestanteDespesas;
                $row->ValorRestanteDespesas = number_format($row->ValorRestanteDespesas, 2, ',', '.');



            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somadesconto = number_format($somadesconto, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');

            return $query;
        }

    }

	public function list_despesas($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataDespesas >= "' . $data['DataInicio'] . '" AND OT.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataConclusaoDespesas >= "' . $data['DataInicio2'] . '" AND OT.DataConclusaoDespesas <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataConclusaoDespesas >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataRetornoDespesas >= "' . $data['DataInicio3'] . '" AND OT.DataRetornoDespesas <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataRetornoDespesas >= "' . $data['DataInicio3'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['TipoDespesa'] = ($data['TipoDespesa']) ? ' AND TD.idTab_TipoDespesa = ' . $data['TipoDespesa'] : FALSE;
		$data['Categoriadesp'] = ($data['Categoriadesp']) ? ' AND CD.idTab_Categoriadesp = ' . $data['Categoriadesp'] : FALSE;
        $filtro1 = ($data['AprovadoDespesas'] != '#') ? 'OT.AprovadoDespesas = "' . $data['AprovadoDespesas'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoDespesas'] != '#') ? 'OT.QuitadoDespesas = "' . $data['QuitadoDespesas'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrcaDespesas'] != '#') ? 'OT.ConcluidoOrcaDespesas = "' . $data['ConcluidoOrcaDespesas'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT

                OT.idApp_Despesas,
				OT.idApp_OrcaTrata,
                OT.AprovadoDespesas,
                OT.DataDespesas,
				TD.TipoDespesa,
				CD.Categoriadesp,
				OT.Despesa,
				OT.DataEntradaDespesas,
                OT.ValorDespesas,
				OT.ValorEntradaDespesas,
				OT.ValorRestanteDespesas,
				OT.QtdParcelasDespesas,
                OT.ConcluidoOrcaDespesas,
                OT.QuitadoDespesas,
                OT.DataConclusaoDespesas,
				OT.DataQuitadoDespesas,
                OT.DataRetornoDespesas,
				OT.FormaPagamentoDespesas,
				C.NomeCliente,
				OT.TipoProduto,
				TFP.FormaPag,
				TSU.Nome
            FROM

                App_Despesas AS OT
				LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = OT.idSis_Usuario
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamentoDespesas
				LEFT JOIN App_OrcaTrata AS TR ON TR.idApp_OrcaTrata = OT.idApp_OrcaTrata
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = TR.idApp_Cliente
				LEFT JOIN Tab_TipoDespesa AS TD ON TD.idTab_TipoDespesa = OT.TipoDespesa
				LEFT JOIN Tab_Categoriadesp AS CD ON CD.idTab_Categoriadesp = TD.Categoriadesp

            WHERE
				OT.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['NomeCliente'] . ' AND
				' . $consulta . ' AND
				' . $consulta2 . ' AND
				' . $consulta3 . '
				' . $data['TipoDespesa'] . ' AND

				OT.QtdParcelasDespesas != "0"

            ORDER BY
                OT.idApp_Despesas DESC,
				OT.AprovadoDespesas ASC,
				OT.DataDespesas

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
				$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');
				$row->DataEntradaDespesas = $this->basico->mascara_data($row->DataEntradaDespesas, 'barras');
                $row->DataConclusaoDespesas = $this->basico->mascara_data($row->DataConclusaoDespesas, 'barras');
                $row->DataRetornoDespesas = $this->basico->mascara_data($row->DataRetornoDespesas, 'barras');
				$row->DataQuitadoDespesas = $this->basico->mascara_data($row->DataQuitadoDespesas, 'barras');
                $row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
                $row->ConcluidoOrcaDespesas = $this->basico->mascara_palavra_completa($row->ConcluidoOrcaDespesas, 'NS');
                $row->QuitadoDespesas = $this->basico->mascara_palavra_completa($row->QuitadoDespesas, 'NS');

                $somaorcamento += $row->ValorDespesas;
                $row->ValorDespesas = number_format($row->ValorDespesas, 2, ',', '.');

				$somadesconto += $row->ValorEntradaDespesas;
                $row->ValorEntradaDespesas = number_format($row->ValorEntradaDespesas, 2, ',', '.');

				$somarestante += $row->ValorRestanteDespesas;
                $row->ValorRestanteDespesas = number_format($row->ValorRestanteDespesas, 2, ',', '.');



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

				D.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
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
                #$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                #$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

                $somadespesa += $row->ValorTotalDesp;

                $row->ValorTotalDesp = number_format($row->ValorTotalDesp, 2, ',', '.');

            }
            $query->soma = new stdClass();
            $query->soma->somadespesa = number_format($somadespesa, 2, ',', '.');

            return $query;
        }

    }

    public function list_clientes1($data, $completo) {

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro10 = ($data['Ativo'] != '#') ? 'C.Ativo = "' . $data['Ativo'] . '" AND ' : FALSE;
        $query = $this->db->query('
            SELECT
				C.idApp_Cliente,
                C.NomeCliente,
				C.Ativo,
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
				TCC.RelaCom,
				TCP.RelaPes,
				CC.Sexo

            FROM
                App_Cliente AS C
                    LEFT JOIN Tab_Municipio AS M ON C.Municipio = M.idTab_Municipio
					LEFT JOIN App_ContatoCliente AS CC ON C.idApp_Cliente = CC.idApp_Cliente
					LEFT JOIN Tab_RelaCom AS TCC ON TCC.idTab_RelaCom = CC.RelaCom
					LEFT JOIN Tab_RelaPes AS TCP ON TCP.idTab_RelaPes = CC.RelaPes
            WHERE
				C.Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeCliente'] . '
				OR
				C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
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
				$row->Ativo = $this->basico->mascara_palavra_completa($row->Ativo, 'NS');
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

	public function list_clientes($data, $completo) {

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro10 = ($data['Ativo'] != '#') ? 'C.Ativo = "' . $data['Ativo'] . '" AND ' : FALSE;
        $query = $this->db->query('
            SELECT
				C.idApp_Cliente,
                C.NomeCliente,
				C.Ativo,
                C.DataNascimento,
                C.Telefone1,
                C.Telefone2,
                C.Telefone3,
                C.Sexo,
                C.Endereco,
                C.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                C.Email

            FROM
				App_Cliente AS C
                    LEFT JOIN Tab_Municipio AS M ON C.Municipio = M.idTab_Municipio

            WHERE
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				C.Empresa = ' . $_SESSION['log']['Empresa'] . '
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
				$row->Ativo = $this->basico->mascara_palavra_completa($row->Ativo, 'NS');
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

	public function list_associado($data, $completo) {

        $data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND E.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
		$data['CategoriaEmpresa'] = ($data['CategoriaEmpresa']) ? ' AND E.CategoriaEmpresa = ' . $data['CategoriaEmpresa'] : FALSE;
		$data['Atuacao'] = ($data['Atuacao']) ? ' AND E.idSis_Empresa = ' . $data['Atuacao'] : FALSE;        
		$data['Campo'] = (!$data['Campo']) ? 'E.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
				E.idSis_Empresa,
				E.Associado,
                E.NomeEmpresa,
                E.DataCriacao,
				E.CelularAdmin,
				E.Site,
				CE.CategoriaEmpresa,
				E.Atuacao,
				E.Arquivo,
				SN.StatusSN,
				E.Inativo
            FROM
                Sis_Empresa AS E
					LEFT JOIN Tab_StatusSN AS SN ON SN.Inativo = E.Inativo
					LEFT JOIN Tab_CategoriaEmpresa AS CE ON CE.idTab_CategoriaEmpresa = E.CategoriaEmpresa
            WHERE
                E.Associado = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				E.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['Atuacao'] . ' 
				' . $data['NomeEmpresa'] . ' 
				' . $data['CategoriaEmpresa'] . ' AND
				E.idSis_Empresa != "1" AND
				E.idSis_Empresa != "5"
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
				$row->DataCriacao = $this->basico->mascara_data($row->DataCriacao, 'barras');
                $row->CelularAdmin = ($row->CelularAdmin) ? $row->CelularAdmin : FALSE;
            }

            return $query;
        }

    }

	public function list_empresaassociado($data, $completo) {

        $data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND C.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];



        $query = $this->db->query('
            SELECT
				C.idSis_Empresa,
				C.Associado,
                C.NomeEmpresa,
				C.Nome,
                C.CelularAdmin,
                C.Email,
				C.UsuarioEmpresa,
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
                P.Telefone1,
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

                $row->Telefone = ($row->Telefone1) ? $row->Telefone1 : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_funcionario($data, $completo) {

        $data['Nome'] = ($data['Nome']) ? ' AND F.idSis_Usuario = ' . $data['Nome'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'F.Nivel' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                F.idSis_Usuario,
                F.Nome,
				F.Nivel,
				FU.Funcao,
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
				if($_SESSION['AdminEmpresa']['Rede'] == "S"){
					if($row->Nivel == 0){
						$row->Nivel = "Nivel 0 - Administrador";
					}elseif($row->Nivel == 1){
						$row->Nivel = "Nivel 1 - Supervisor/Vendedor";
					}elseif($row->Nivel == 2){
						$row->Nivel = "Nivel 2 - Vendedor";
					}else{
						$row->Nivel = "N.I.";
					}
				}else{
					if($row->Nivel == 0){
						$row->Nivel = "Nivel 0 - Administrador";
					}elseif($row->Nivel == 1){
						$row->Nivel = "Nivel 1 - Funcionario";
					}else{
						$row->Nivel = "N.I.";
					}
				}
            }

            return $query;
        }

    }

	public function list_colaboradoronline($data, $completo) {
		
		$filtro1 = ($data['Inativo'] != '#') ? 'UOL.Inativo = "' . $data['Inativo'] . '" AND ' : FALSE;
        $data['Nome'] = ($data['Nome']) ? ' AND U.idSis_Usuario = ' . $data['Nome'] : FALSE;
		$data['Inativo'] = ($data['Inativo']) ? ' AND UOL.Inativo = ' . $data['Inativo'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'U.Nome' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                UOL.idSis_Usuario_Online,
				UOL.idSis_Empresa,
				UOL.idSis_Usuario,
				UOL.Inativo,
				UOL.Codigo,
				UOL.DataCriacao,
                U.Nome,
				TSN.StatusSN
            FROM
                Sis_Usuario_Online AS UOL
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = UOL.idSis_Usuario
					LEFT JOIN Tab_StatusSN AS TSN ON TSN.idTab_StatusSN = UOL.Inativo
            WHERE

				UOL.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				' . $data['Nome'] . '
				' . $data['Inativo'] . '

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
				$row->DataCriacao = $this->basico->mascara_data($row->DataCriacao, 'barras');
            }

            return $query;
        }

    }
		
	public function list_empresafilial($data, $completo) {

        $data['Nome'] = ($data['Nome']) ? ' AND F.idSis_Usuario = ' . $data['Nome'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'F.Nome' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                F.idSis_Empresa,
                F.Nome
            FROM
                Sis_Empresa AS F

            WHERE
				F.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
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
				
				E.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' 
				' . $data['Atuacao'] . ' 
				' . $data['NomeEmpresa'] . ' 
				' . $data['CategoriaEmpresa'] . ' AND
				E.idSis_Empresa != "1" AND
				E.idSis_Empresa != "5"  AND
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
	
	public function list_empresas2($data, $completo) {

		$data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND E.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'E.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                E.idSis_Empresa,
                E.NomeEmpresa,
                E.EnderecoEmpresa,
                E.BairroEmpresa,
				E.Site,
				E.Atuacao,
				E.CategoriaEmpresa,
				E.Municipio,
                E.Email
            FROM
                Sis_Empresa AS E
			WHERE
				E.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '

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
	
	public function list_empresas1($data, $completo) {

		$data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND E.idApp_Empresa = ' . $data['NomeEmpresa'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'E.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                E.idApp_Empresa,
                E.NomeEmpresa,
				TF.TipoFornec,
				TS.StatusSN,
				E.VendaFornec,
				TA.Atividade,
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
				TCE.RelaCom,
				CE.Sexo
            FROM
                App_Empresa AS E
                    LEFT JOIN Tab_Municipio AS M ON E.Municipio = M.idTab_Municipio
					LEFT JOIN App_Contato AS CE ON E.idApp_Empresa = CE.idApp_Empresa
					LEFT JOIN Tab_RelaCom AS TCE ON TCE.idTab_RelaCom = CE.RelaCom
					LEFT JOIN Tab_TipoFornec AS TF ON TF.Abrev = E.TipoFornec
					LEFT JOIN Tab_StatusSN AS TS ON TS.Abrev = E.VendaFornec
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

                $row->Telefone = ($row->Telefone1) ? $row->Telefone1 : FALSE;
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
				E.VendaFornec,
				TA.Atividade,
                E.DataNascimento,
                E.Telefone1,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.Endereco,
                E.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                E.Email,
				CE.NomeContatofornec,
				TCE.RelaCom,
				CE.Sexo
            FROM
                App_Fornecedor AS E
                    LEFT JOIN Tab_Municipio AS M ON E.Municipio = M.idTab_Municipio
					LEFT JOIN App_Contatofornec AS CE ON E.idApp_Fornecedor = CE.idApp_Fornecedor
					LEFT JOIN Tab_RelaCom AS TCE ON TCE.idTab_RelaCom = CE.RelaCom
					LEFT JOIN Tab_TipoFornec AS TF ON TF.Abrev = E.TipoFornec
					LEFT JOIN Tab_StatusSN AS TS ON TS.Abrev = E.VendaFornec
					LEFT JOIN App_Atividade AS TA ON TA.idApp_Atividade = E.Atividade
            WHERE
                E.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
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

                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->Telefone = ($row->Telefone1) ? $row->Telefone1 : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

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

				TV.ValorVendaServico,
				TC.Convenio
            FROM
                App_Servicos AS TP
					LEFT JOIN Tab_ValorServ AS TV ON TV.idApp_Servicos = TP.idApp_Servicos
					LEFT JOIN Tab_Convenio AS TC ON TC.idTab_Convenio = TV.Convenio
					LEFT JOIN App_Fornecedor AS TF ON TF.idApp_Fornecedor = TP.Fornecedor
            WHERE
                TP.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
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
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['ConcluidoProcedimento'] != '#') ? 'PC.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;


        $query = $this->db->query('
            SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataPrazo,
                OT.ValorOrca,
                OT.ConcluidoOrca,
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
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '
				' . $filtro3 . '
				' . $filtro4 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '
				' . $data['NomeProfissional'] . '
            ORDER BY
                C.NomeCliente ASC,
				OT.AprovadoOrca DESC,
				OT.ConcluidoOrca,
				PC.DataProcedimento,
				PC.ConcluidoProcedimento
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
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
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

		#$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TF.DataPrazoTarefa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['NomeProfissional'] = ($data['NomeProfissional']) ? ' AND P.idApp_Profissional = ' . $data['NomeProfissional'] : FALSE;
		$data['Profissional'] = ($data['Profissional']) ? ' AND P2.idApp_Profissional = ' . $data['Profissional'] : FALSE;
		$data['ObsTarefa'] = ($data['ObsTarefa']) ? ' AND TF.idApp_Tarefa = ' . $data['ObsTarefa'] : FALSE;
		$filtro5 = ($data['TarefaConcluida'] != '#') ? 'TF.TarefaConcluida = "' . $data['TarefaConcluida'] . '" AND ' : FALSE;
        $filtro6 = ($data['Prioridade'] != '#') ? 'TF.Prioridade = "' . $data['Prioridade'] . '" AND ' : FALSE;
		$filtro7 = ($data['Rotina'] != '#') ? 'TF.Rotina = "' . $data['Rotina'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
				P.NomeProfissional,
                TF.idApp_Tarefa,
				TF.ObsTarefa,
                TF.TarefaConcluida,
                TF.DataTarefa,
				TF.Prioridade,
				TF.Rotina,
				TF.DataPrazoTarefa,
				TF.DataConclusao
            FROM
                App_Tarefa AS TF
					LEFT JOIN App_Profissional AS P ON P.idApp_Profissional = TF.ProfissionalTarefa
            WHERE
                TF.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				TF.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				TF.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $filtro5 . '
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

            $somatarefa=0;
            foreach ($query->result() as $row) {
				$row->DataTarefa = $this->basico->mascara_data($row->DataTarefa, 'barras');
				$row->DataPrazoTarefa = $this->basico->mascara_data($row->DataPrazoTarefa, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
				$row->TarefaConcluida = $this->basico->mascara_palavra_completa($row->TarefaConcluida, 'NS');
                $row->Prioridade = $this->basico->mascara_palavra_completa($row->Prioridade, 'NS');
				$row->Rotina = $this->basico->mascara_palavra_completa($row->Rotina, 'NS');
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
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
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
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['ConcluidoProcedimento'] != '#') ? 'PC.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;


        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataPrazo,
                OT.ValorOrca,

                OT.ConcluidoOrca,

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
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
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
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
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

    public function select_cliente() {

        $query = $this->db->query('
            SELECT
                C.idApp_Cliente,
                CONCAT(IFNULL(C.NomeCliente, ""), " --- ", IFNULL(C.Telefone1, ""), " --- ", IFNULL(C.Telefone2, ""), " --- ", IFNULL(C.Telefone3, "")) As NomeCliente
            FROM
                App_Cliente AS C

            WHERE
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                C.NomeCliente ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Cliente] = $row->NomeCliente;
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
	
	public function select_empresas2() {

        $query = $this->db->query('
            SELECT
                idSis_Empresa,
				NomeEmpresa
            FROM
                Sis_Empresa
            
                
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
	
	public function select_fornecedor() {

        $query = $this->db->query('
            SELECT
                idApp_Fornecedor,
				CONCAT(NomeFornecedor, " ", " --- ", Telefone1, " --- ", Telefone2) As NomeFornecedor
            FROM
                App_Fornecedor
            WHERE
                Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeFornecedor ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Fornecedor] = $row->NomeFornecedor;
        }

        return $array;
    }

    public function select_funcionario() {

        $query = $this->db->query('
            SELECT
                F.idSis_Usuario,
                F.Nome
            FROM
                Sis_Usuario AS F
            WHERE
                F.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				F.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                F.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->Nome;
        }

        return $array;
    }
	
    public function select_colaboradoronline() {

        $query = $this->db->query('
            SELECT
                UOL.idSis_Usuario,
                U.Nome
            FROM
                Sis_Usuario_Online AS UOL
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = UOL.idSis_Usuario
            WHERE
                UOL.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
            ORDER BY
                U.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->Nome;
        }

        return $array;
    }	

    public function select_empresafilial() {

        $query = $this->db->query('
            SELECT
                F.idSis_Empresa,
                F.Nome
            FROM
                Sis_Empresa AS F
            WHERE
                F.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                F.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Empresa] = $row->Nome;
        }

        return $array;
    }
		
	public function select_profissional() {

        $query = $this->db->query('
            SELECT
                P.idApp_Profissional,
                CONCAT(P.NomeProfissional, " ", "---", P.Telefone1) AS NomeProfissional
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
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
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
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                FormaPag ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_FormaPag] = $row->FormaPag;
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
	
	public function select_tiporeceita() {

        $query = $this->db->query('
            SELECT
				TR.idTab_TipoReceita,
				TR.TipoReceita
			FROM
				Tab_TipoReceita AS TR
			WHERE
				TR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
			ORDER BY
				TR.TipoReceita
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoReceita] = $row->TipoReceita;
        }

        return $array;
    }
	
	public function select_tipodespesa() {

        $query = $this->db->query('
            SELECT
				TD.idTab_TipoDespesa,
				CONCAT(CD.Abrevcategoriadesp, " " , "--" , " " , TD.TipoDespesa) AS TipoDespesa,
				CD.Categoriadesp,
				CD.Abrevcategoriadesp
			FROM
				Tab_TipoDespesa AS TD
					LEFT JOIN Tab_Categoriadesp AS CD ON CD.idTab_Categoriadesp = TD.Categoriadesp
			WHERE
				TD.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
			ORDER BY
				CD.Abrevcategoriadesp,
				TD.TipoDespesa
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoDespesa] = $row->TipoDespesa;
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

	public function select_tipoconsumo() {

        $query = $this->db->query('
            SELECT
                TD.idTab_TipoConsumo,
                TD.TipoConsumo
            FROM
                Tab_TipoConsumo AS TD
			WHERE
				TD.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
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

        $query = $this->db->query('
            SELECT
                OB.idApp_Tarefa,
                OB.ObsTarefa
            FROM
                App_Tarefa AS OB
            WHERE
                OB.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				OB.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
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
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
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

	public function select_servicos() {

        $query = $this->db->query('
            SELECT
                OB.idApp_Servicos,
                OB.Servicos
            FROM
                App_Servicos AS OB
            WHERE
                OB.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
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
                OB.idApp_Procedtarefa,
                OB.Procedtarefa
            FROM
                App_Procedtarefa AS OB
            WHERE
                OB.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				OB.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
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

	public function select_usuario() {

        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(F.Abrev,""), " --- ", IFNULL(P.Nome,"")) AS NomeUsuario
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY F.Abrev ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }

        return $array;
    }

}
