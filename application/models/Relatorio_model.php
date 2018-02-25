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
		$filtro3 = ($data['ServicoConcluido'] != '#') ? 'OT.ServicoConcluido = "' . $data['ServicoConcluido'] . '" AND ' : FALSE;
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
		$filtro3 = ($data['ServicoConcluidoDespesas'] != '#') ? 'DS.ServicoConcluidoDespesas = "' . $data['ServicoConcluidoDespesas'] . '" AND ' : FALSE;
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
				DS.ServicoConcluidoDespesas,
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
				$row->ServicoConcluidoDespesas = $this->basico->mascara_palavra_completa($row->ServicoConcluidoDespesas, 'NS');
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
		$filtro3 = ($data['ServicoConcluidoDespesas'] != '#') ? 'DS.ServicoConcluidoDespesas = "' . $data['ServicoConcluidoDespesas'] . '" AND ' : FALSE;
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
				DS.ServicoConcluidoDespesas,
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
				$row->ServicoConcluidoDespesas = $this->basico->mascara_palavra_completa($row->ServicoConcluidoDespesas, 'NS');
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
		$filtro3 = ($data['ServicoConcluidoDespesas'] != '#') ? 'DS.ServicoConcluidoDespesas = "' . $data['ServicoConcluidoDespesas'] . '" AND ' : FALSE;
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
				DS.ServicoConcluidoDespesas,
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
				$row->ServicoConcluidoDespesas = $this->basico->mascara_palavra_completa($row->ServicoConcluidoDespesas, 'NS');
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
		$filtro3 = ($data['ServicoConcluidoDespesas'] != '#') ? 'DS.ServicoConcluidoDespesas = "' . $data['ServicoConcluidoDespesas'] . '" AND ' : FALSE;
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
				DS.ServicoConcluidoDespesas,
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
				$row->ServicoConcluidoDespesas = $this->basico->mascara_palavra_completa($row->ServicoConcluidoDespesas, 'NS');
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

    public function list_estoque($data) {

        $data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produtos = ' . $data['Produtos'] : FALSE;
        $data['Prodaux1'] = ($data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
        $data['Prodaux2'] = ($data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        ####################################################################
        #LISTA DE PRODUTOS
        $query['Produtos'] = $this->db->query(
            'SELECT
                TP.idTab_Produtos,
                TP.CodProd,
                CONCAT(IFNULL(TP.CodProd,""), " - ", IFNULL(TP.Produtos,"")) AS Produtos,
                TP1.Prodaux1,
                TP2.Prodaux2,
                TP3.Prodaux3
            FROM
                Tab_Produtos AS TP
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TP.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Produtos'] . '
                ' . $data['Prodaux1'] . '
                ' . $data['Prodaux2'] . '
                ' . $data['Prodaux3'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Produtos'] = $query['Produtos']->result();
		
        ####################################################################
        #LISTA DE PRODAUX1
        $query['Prodaux1'] = $this->db->query(
            'SELECT
                TP.idTab_Produtos,
                TP.CodProd,
                CONCAT(IFNULL(TP1.Prodaux1,"")) AS Prodaux1,
                TP1.Prodaux1
            FROM
                Tab_Produtos AS TP
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
            WHERE
                TP.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux1'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux1'] = $query['Prodaux1']->result();		

        ####################################################################
        #LISTA DE PRODAUX2
        $query['Prodaux2'] = $this->db->query(
            'SELECT
                TP.idTab_Produtos,
                TP.CodProd,
                CONCAT(IFNULL(TP2.Prodaux2,"")) AS Prodaux2,
                TP2.Prodaux2
            FROM
                Tab_Produtos AS TP
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
            WHERE
                TP.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux2'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux2'] = $query['Prodaux2']->result();		

        ####################################################################
        #LISTA DE PRODAUX3
        $query['Prodaux3'] = $this->db->query(
            'SELECT
                TP.idTab_Produtos,
                TP.CodProd,
                CONCAT(IFNULL(TP3.Prodaux3,"")) AS Prodaux3,
                TP3.Prodaux3
            FROM
                Tab_Produtos AS TP
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TP.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux3'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux3'] = $query['Prodaux3']->result();
		
        ####################################################################
        #COMPRADOS
        if ($data['DataFim']) {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '" AND TCO.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

        $query['Comprados'] = $this->db->query(
            'SELECT
                SUM(APC.QtdCompraProduto) AS QtdCompra,
                TP.idTab_Produtos
            FROM
                App_Despesas AS TCO
                    LEFT JOIN App_ProdutoCompra AS APC ON APC.idApp_Despesas = TCO.idApp_Despesas
                    LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = APC.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TCO.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                TCO.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['Produtos'] . ' AND
                TCO.TipoProduto = "D" AND
                TP.idTab_Produtos != "0"
                ' . $data['Produtos'] . '
            GROUP BY
                TP.idTab_Produtos
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Comprados'] = $query['Comprados']->result();

        ####################################################################
        #VENDIDOS
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $query['Vendidos'] = $this->db->query(
            'SELECT
                SUM(APV.QtdVendaProduto) AS QtdVenda,
                TP.idTab_Produtos,
                OT.TipoRD
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_ProdutoVenda AS APV ON APV.idApp_OrcaTrata = OT.idApp_OrcaTrata
                    LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = TVV.idTab_Produtos
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                APV.idApp_ProdutoVenda != "0" AND
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['Produtos'] . ' AND
                OT.TipoRD = "R"
            GROUP BY
                TP.idTab_Produtos
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Vendidos'] = $query['Vendidos']->result();

  
        ####################################################################
        #DEVOLVIDOS(ORCATRATA)
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $query['Devolvidos'] = $this->db->query(
            'SELECT
                SUM(APV.QtdVendaProduto) AS QtdDevolve,
                TP.idTab_Produtos,
                OT.TipoRD
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_ProdutoVenda AS APV ON APV.idApp_OrcaTrata = OT.idApp_OrcaTrata
                    LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = TVV.idTab_Produtos
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                APV.idApp_ProdutoVenda != "0" AND
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['Produtos'] . ' AND
                OT.TipoRD = "D"
            GROUP BY
                TP.idTab_Produtos
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Devolvidos'] = $query['Devolvidos']->result();
    
/*
        ####################################################################
        #DEVOLVIDOS (DESPESAS)
        if ($data['DataFim']) {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '" AND TCO.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

        $query['Devolvidos'] = $this->db->query(
            'SELECT
                SUM(APC.QtdCompraProduto) AS QtdDevolve,
                TP.idTab_Produtos
            FROM
                App_Despesas AS TCO
                    LEFT JOIN App_ProdutoCompra AS APC ON APC.idApp_Despesas = TCO.idApp_Despesas
                    LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = APC.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TCO.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                TCO.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['Produtos'] . ' AND
                TCO.TipoProduto = "E" AND
                TP.idTab_Produtos != "0"
                ' . $data['Produtos'] . '
            GROUP BY
                TP.idTab_Produtos
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Devolvidos'] = $query['Devolvidos']->result();

*/
        ####################################################################
        #CONSUMIDOS
        if ($data['DataFim']) {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '" AND TCO.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

        $query['Consumidos'] = $this->db->query(
            'SELECT
                SUM(APC.QtdCompraProduto) AS QtdConsumo,
                TP.idTab_Produtos
            FROM
                App_Despesas AS TCO
                    LEFT JOIN App_ProdutoCompra AS APC ON APC.idApp_Despesas = TCO.idApp_Despesas
                    LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = APC.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TCO.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                TCO.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                TCO.TipoProduto = "C"
                ' . $data['Produtos'] . '
            GROUP BY
                TP.idTab_Produtos
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Consumidos'] = $query['Consumidos']->result();

        $estoque = new stdClass();
        #$estoque = array();
        foreach ($query['Produtos'] as $row) {
            #echo $row->idTab_Produtos . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produtos] = $row->Produtos;
            $estoque->{$row->idTab_Produtos} = new stdClass();
            $estoque->{$row->idTab_Produtos}->Produtos = $row->Produtos;
        }

        foreach ($query['Prodaux1'] as $row) {
            #echo $row->idTab_Produtos . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produtos] = $row->Produtos;
            #$estoque->{$row->idTab_Produtos} = new stdClass();
            if (isset($estoque->{$row->idTab_Produtos}))
			$estoque->{$row->idTab_Produtos}->Prodaux1 = $row->Prodaux1;
        }

        foreach ($query['Prodaux2'] as $row) {
            #echo $row->idTab_Produtos . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produtos] = $row->Produtos;
            #$estoque->{$row->idTab_Produtos} = new stdClass();
            if (isset($estoque->{$row->idTab_Produtos}))
			$estoque->{$row->idTab_Produtos}->Prodaux2 = $row->Prodaux2;
        }

        foreach ($query['Prodaux3'] as $row) {
            #echo $row->idTab_Produtos . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produtos] = $row->Produtos;
            #$estoque->{$row->idTab_Produtos} = new stdClass();
            if (isset($estoque->{$row->idTab_Produtos}))
			$estoque->{$row->idTab_Produtos}->Prodaux3 = $row->Prodaux3;
        }		
		
		/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();*/
        foreach ($query['Comprados'] as $row) {
            if (isset($estoque->{$row->idTab_Produtos}))
                $estoque->{$row->idTab_Produtos}->QtdCompra = $row->QtdCompra;
        }

        foreach ($query['Vendidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produtos}))
                $estoque->{$row->idTab_Produtos}->QtdVenda = $row->QtdVenda;
        }

        foreach ($query['Devolvidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produtos}))
                $estoque->{$row->idTab_Produtos}->QtdDevolve = $row->QtdDevolve;
        }

        foreach ($query['Consumidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produtos}))
                $estoque->{$row->idTab_Produtos}->QtdConsumo = $row->QtdConsumo;
        }

        foreach ($estoque as $row) {
            $row->QtdCompra = (!isset($row->QtdCompra)) ? 0 : $row->QtdCompra;
            $row->QtdVenda = (!isset($row->QtdVenda)) ? 0 : $row->QtdVenda;
            $row->QtdDevolve = (!isset($row->QtdDevolve)) ? 0 : $row->QtdDevolve;
            $row->QtdConsumo = (!isset($row->QtdConsumo)) ? 0 : $row->QtdConsumo;

            $row->QtdEstoque = $row->QtdCompra - $row->QtdVenda + $row->QtdDevolve - $row->QtdConsumo;
            $row->QtdVendida = $row->QtdVenda - $row->QtdDevolve;
        }

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

    public function list_estoque21($data) {

		$data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produtos = ' . $data['Produtos'] : FALSE;
		$data['Prodaux1'] = ($data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		$data['Prodaux2'] = ($data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        ####################################################################
        #LISTA DE PRODUTOS
        $query['Produtos'] = $this->db->query(
            'SELECT
            	TP.idTab_Produtos,
				TP.CodProd,
            	CONCAT(IFNULL(TP.CodProd,""), " - ", IFNULL(TP3.Prodaux3,""), " - ", IFNULL(TP.Produtos,""), " - ", IFNULL(TP1.Prodaux1,""), " - ", IFNULL(TP2.Prodaux2,"")) AS Produtos,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TP3.Prodaux3
            FROM
            	Tab_Produtos AS TP,
				Tab_Prodaux1 AS TP1,
				Tab_Prodaux2 AS TP2,
				Tab_Prodaux3 AS TP3
            WHERE
                TP1.idTab_Prodaux1 = TP.Prodaux1 AND
                TP2.idTab_Prodaux2 = TP.Prodaux2 AND
                TP3.idTab_Prodaux3 = TP.Prodaux3 AND

            	TP.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
            	TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['Produtos'] . '
				' . $data['Prodaux1'] . '
				' . $data['Prodaux2'] . '
				' . $data['Prodaux3'] . '
			ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Produtos'] = $query['Produtos']->result();

        ####################################################################
        #COMPRADOS
        if ($data['DataFim']) {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '" AND TCO.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

        $query['Comprados'] = $this->db->query(
            'SELECT
            	SUM(APC.QtdCompraProduto) AS QtdCompra,
            	TP.idTab_Produtos
            FROM
            	App_Despesas AS TCO
            		LEFT JOIN App_ProdutoCompra AS APC ON APC.idApp_Despesas = TCO.idApp_Despesas
            		LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = APC.idTab_Produto
            WHERE
                TCO.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                TCO.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['Produtos'] . ' AND
                TCO.TipoProduto = "D" AND
                TP.idTab_Produtos != "0"
                ' . $data['Produtos'] . '
            GROUP BY
            	TP.idTab_Produtos
            ORDER BY
            	TP.Produtos ASC'
        );
        $query['Comprados'] = $query['Comprados']->result();

        ####################################################################
        #VENDIDOS
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $query['Vendidos'] = $this->db->query(
            'SELECT
            	SUM(APV.QtdVendaProduto) AS QtdVenda,
                TP.idTab_Produtos,
				OT.TipoRD
            FROM
            	App_Cliente AS C,
            	App_OrcaTrata AS OT
            		LEFT JOIN App_ProdutoVenda AS APV ON APV.idApp_OrcaTrata = OT.idApp_OrcaTrata
            		LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
            		LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = TVV.idTab_Produtos
            WHERE
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
            	APV.idApp_ProdutoVenda != "0" AND
            	C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['Produtos'] . ' AND
				OT.TipoRD = "R"
            GROUP BY
            	TP.idTab_Produtos
            ORDER BY
            	TP.Produtos ASC'
        );
        $query['Vendidos'] = $query['Vendidos']->result();

/*
		####################################################################
        #DEVOLVIDOS1
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $query['Devolvidos'] = $this->db->query(
            'SELECT
            	SUM(APV.QtdVendaProduto) AS QtdDevolve,
                TP.idTab_Produtos,
				OT.TipoRD
            FROM
            	App_Cliente AS C,
            	App_OrcaTrata AS OT
            		LEFT JOIN App_ProdutoVenda AS APV ON APV.idApp_OrcaTrata = OT.idApp_OrcaTrata
            		LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
            		LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = TVV.idTab_Produtos
            WHERE
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
            	APV.idApp_ProdutoVenda != "0" AND
            	C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['Produtos'] . ' AND
				OT.TipoRD = "D"
            GROUP BY
            	TP.idTab_Produtos
            ORDER BY
            	TP.Produtos ASC'
        );
        $query['Devolvidos'] = $query['Devolvidos']->result();
*/

        ####################################################################
        #Devolvidos
        if ($data['DataFim']) {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '" AND TCO.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

        $query['Devolvidos'] = $this->db->query(
            'SELECT
            	SUM(APC.QtdCompraProduto) AS QtdDevolve,
            	TP.idTab_Produtos
            FROM
            	App_Despesas AS TCO
            		LEFT JOIN App_ProdutoCompra AS APC ON APC.idApp_Despesas = TCO.idApp_Despesas
            		LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = APC.idTab_Produto
            WHERE
                TCO.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                TCO.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['Produtos'] . ' AND
                TCO.TipoProduto = "E" AND
                TP.idTab_Produtos != "0"
                ' . $data['Produtos'] . '
            GROUP BY
            	TP.idTab_Produtos
            ORDER BY
            	TP.Produtos ASC'
        );
        $query['Devolvidos'] = $query['Devolvidos']->result();
        ####################################################################
        #CONSUMIDOS
        if ($data['DataFim']) {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '" AND TCO.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

        $query['Consumidos'] = $this->db->query(
            'SELECT
            	SUM(APC.QtdCompraProduto) AS QtdConsumo,
            	TP.idTab_Produtos
            FROM
            	App_Despesas AS TCO
            		LEFT JOIN App_ProdutoCompra AS APC ON APC.idApp_Despesas = TCO.idApp_Despesas
            		LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = APC.idTab_Produto
            WHERE
                TCO.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                TCO.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                TCO.TipoProduto = "C"
                ' . $data['Produtos'] . '
            GROUP BY
            	TP.idTab_Produtos
            ORDER BY
            	TP.Produtos ASC'
        );
        $query['Consumidos'] = $query['Consumidos']->result();

        $estoque = new stdClass();
        #$estoque = array();
        foreach ($query['Produtos'] as $row) {
            #echo $row->idTab_Produtos . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produtos] = $row->Produtos;
            $estoque->{$row->idTab_Produtos} = new stdClass();
            $estoque->{$row->idTab_Produtos}->Produtos = $row->Produtos;
        }

        foreach ($query['Comprados'] as $row) {
            $estoque->{$row->idTab_Produtos}->QtdCompra = $row->QtdCompra;
        }

        foreach ($query['Vendidos'] as $row) {
            $estoque->{$row->idTab_Produtos}->QtdVenda = $row->QtdVenda;
        }

		foreach ($query['Devolvidos'] as $row) {
            $estoque->{$row->idTab_Produtos}->QtdDevolve = $row->QtdDevolve;
        }

        foreach ($query['Consumidos'] as $row) {
            $estoque->{$row->idTab_Produtos}->QtdConsumo = $row->QtdConsumo;
        }

        foreach ($estoque as $row) {
            $row->QtdCompra = (!isset($row->QtdCompra)) ? 0 : $row->QtdCompra;
            $row->QtdVenda = (!isset($row->QtdVenda)) ? 0 : $row->QtdVenda;
			$row->QtdDevolve = (!isset($row->QtdDevolve)) ? 0 : $row->QtdDevolve;
            $row->QtdConsumo = (!isset($row->QtdConsumo)) ? 0 : $row->QtdConsumo;

            $row->QtdEstoque = $row->QtdCompra - $row->QtdVenda + $row->QtdDevolve - $row->QtdConsumo;
			$row->QtdVendida = $row->QtdVenda - $row->QtdDevolve;
        }

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        */

        return $estoque;

    }

	public function list_produtosvend($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Produtos'] = ($data['Produtos']) ? ' AND TPV.idTab_Produtos = ' . $data['Produtos'] : FALSE;
		$data['Prodaux1'] = ($data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		$data['Prodaux2'] = ($data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;

		$query = $this->db->query('
            SELECT
                C.NomeCliente,
				OT.idApp_OrcaTrata,
                OT.DataOrca,
				OT.ValorOrca,
				OT.FormaPagamento,
				OT.TipoRD,
				OT.AprovadoOrca,
				TFP.FormaPag,
				APV.QtdVendaProduto,
				APV.ValorVendaProduto,
				APV.ObsProduto,
				APV.DataValidadeProduto,
				TPV.Produtos,
				TPV.CodProd,
				TPV.Fornecedor,
				TFO.NomeFornecedor,
				TVV.idTab_Valor,
				TP3.Prodaux3,
				TP2.Prodaux2,
				TP1.Prodaux1

            FROM
                App_Cliente AS C,
				App_OrcaTrata AS OT
					LEFT JOIN App_ProdutoVenda AS APV ON APV.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
					LEFT JOIN Tab_Produtos AS TPV ON TPV.idTab_Produtos = TVV.idTab_Produtos
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = TPV.Fornecedor
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TPV.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TPV.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TPV.Prodaux1
		   WHERE
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(' . $consulta . ') AND
				' . $filtro1 . '
				APV.idApp_ProdutoVenda != "0" AND
				C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '
				' . $data['Produtos'] . '
				' . $data['Prodaux1'] . '
				' . $data['Prodaux2'] . '
				' . $data['Prodaux3'] . ' AND
				OT.TipoRD = "R"
            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
		#LEFT JOIN Tab_ProdutoBase AS TPD ON TPD.idTab_ProdutoBase = PD.idTab_Produto
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          #exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataValidadeProduto = $this->basico->mascara_data($row->DataValidadeProduto, 'barras');
				$row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
            }
            return $query;
        }
    }

	public function list_produtosdevol1($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Produtos'] = ($data['Produtos']) ? ' AND TPV.idTab_Produtos = ' . $data['Produtos'] : FALSE;
		$data['Prodaux1'] = ($data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		$data['Prodaux2'] = ($data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$query = $this->db->query('
            SELECT
                C.NomeCliente,
				OT.idApp_OrcaTrata,
                OT.DataOrca,
				OT.ValorOrca,
				OT.FormaPagamento,
				OT.TipoRD,
				TD.TipoDevolucao,
				OT.Orcamento,
				OT.AprovadoOrca,
				TFP.FormaPag,
				APV.QtdVendaProduto,
				APV.ValorVendaProduto,
				APV.ObsProduto,
				TPV.Produtos,
				TPV.CodProd,
				TPV.Fornecedor,
				TFO.NomeFornecedor,
				TVV.idTab_Valor,
				TP3.Prodaux3,
				TP2.Prodaux2,
				TP1.Prodaux1

            FROM
                App_Cliente AS C,
				App_OrcaTrata AS OT
					LEFT JOIN App_ProdutoVenda AS APV ON APV.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
					LEFT JOIN Tab_Produtos AS TPV ON TPV.idTab_Produtos = TVV.idTab_Produtos
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = TPV.Fornecedor
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TPV.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TPV.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TPV.Prodaux1
					LEFT JOIN Tab_TipoDevolucao AS TD ON TD.idTab_TipoDevolucao = OT.TipoDevolucao
		   WHERE
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(' . $consulta . ') AND
				APV.idApp_ProdutoVenda != "0" AND
				C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '
				' . $data['Produtos'] . '
				' . $data['Prodaux1'] . '
				' . $data['Prodaux2'] . '
				' . $data['Prodaux3'] . ' AND
				OT.TipoRD = "D"
            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
		#LEFT JOIN Tab_ProdutoBase AS TPD ON TPD.idTab_ProdutoBase = PD.idTab_Produto
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          #exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
            }
            return $query;
        }
    }

	public function list_servicosprest1($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['NomeProfissional'] = ($data['NomeProfissional']) ? ' AND P.idApp_Profissional = ' . $data['NomeProfissional'] : FALSE;

		$query = $this->db->query('
            SELECT
                C.NomeCliente,
				P.NomeProfissional,
				OT.idApp_OrcaTrata,
                OT.DataOrca,
				PV.QtdVendaServico,
				PV.idApp_ServicoVenda,
				PD.idTab_Servico,
				TPB.ServicoBase
            FROM
                App_Cliente AS C,
				App_OrcaTrata AS OT
					LEFT JOIN App_ServicoVenda AS PV ON PV.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Tab_Servico AS PD ON PD.idTab_Servico = PV.idTab_Servico
					LEFT JOIN Tab_ServicoCompra AS TSC ON TSC.idTab_ServicoCompra = PD.ServicoBase
					LEFT JOIN Tab_ServicoBase AS TPB ON TPB.idTab_ServicoBase = TSC.ServicoBase
					LEFT JOIN App_Profissional AS P ON P.idApp_Profissional = OT.ProfissionalOrca
            WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(' . $consulta . ') AND
				PV.idApp_ServicoVenda != "0" AND
				C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '
				' . $data['NomeProfissional'] . '
            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
		LEFT JOIN Tab_ProdutoBase AS TPD ON TPD.idTab_ProdutoBase = PD.idTab_Produto
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
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
            }
            return $query;
        }
    }

	public function list_servicosprest($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['NomeProfissional'] = ($data['NomeProfissional']) ? ' AND P.idApp_Profissional = ' . $data['NomeProfissional'] : FALSE;

		$query = $this->db->query('
            SELECT
                C.NomeCliente,
				TSU.Nome,
				P.NomeProfissional,
				OT.idApp_OrcaTrata,
                OT.DataOrca,
				PV.QtdVendaServico,
				PV.idApp_ServicoVenda,
				PD.idTab_Servico,
				PD.NomeServico
            FROM
                App_Cliente AS C,
				App_OrcaTrata AS OT
					LEFT JOIN App_ServicoVenda AS PV ON PV.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Tab_Servico AS PD ON PD.idTab_Servico = PV.idTab_Servico
					LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = PV.idSis_Usuario
					LEFT JOIN App_Profissional AS P ON P.idApp_Profissional = OT.ProfissionalOrca
            WHERE
                C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(' . $consulta . ') AND
				PV.idApp_ServicoVenda != "0" AND
				C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '

            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
		LEFT JOIN Tab_ProdutoBase AS TPD ON TPD.idTab_ProdutoBase = PD.idTab_Produto
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
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
            }
            return $query;
        }
    }

	public function list_consumo($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '" AND TCO.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

		$data['TipoDespesa'] = ($data['TipoDespesa']) ? ' AND TTC.idTab_TipoConsumo = ' . $data['TipoDespesa'] : FALSE;
		$data['Produtos'] = ($data['Produtos']) ? ' AND TPB.idTab_Produtos = ' . $data['Produtos'] : FALSE;

        $query = $this->db->query('
            SELECT
                TCO.idApp_Despesas,
				TCO.Despesa,
				TTC.TipoConsumo,
				TCO.TipoProduto,
                TCO.DataDespesas,
				APC.QtdCompraProduto,
				APC.idTab_Produto,
				TPB.Produtos,
				APC.ObsProduto,
				TP3.Prodaux3,
				TP2.Prodaux2,
				TP1.Prodaux1
            FROM
                App_Despesas AS TCO
                    LEFT JOIN Tab_TipoConsumo AS TTC ON TTC.idTab_TipoConsumo = TCO.TipoDespesa
					LEFT JOIN App_ProdutoCompra AS APC ON APC.idApp_Despesas = TCO.idApp_Despesas
					LEFT JOIN Tab_Produtos AS TPB ON TPB.idTab_Produtos = APC.idTab_Produto
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TPB.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TPB.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TPB.Prodaux1
            WHERE
                TCO.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				TCO.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(' . $consulta . ')
				' . $data['TipoDespesa'] . '
				' . $data['Produtos'] . ' AND
				TCO.TipoProduto = "C"
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          #exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');

            }
            return $query;
        }
    }

	public function list_produtoscomp($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '" AND TCO.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

		$data['TipoDespesa'] = ($data['TipoDespesa']) ? ' AND TTC.idTab_TipoConsumo = ' . $data['TipoDespesa'] : FALSE;
		$data['Produtos'] = ($data['Produtos']) ? ' AND TPB.idTab_Produtos = ' . $data['Produtos'] : FALSE;

        $query = $this->db->query('
            SELECT
                TCO.idApp_Despesas,
				TCO.Despesa,
				TTC.TipoDespesa,
				TCO.TipoProduto,
                TCO.DataDespesas,
				APC.QtdCompraProduto,
				APC.idTab_Produto,
				TPB.Produtos,
				TP3.Prodaux3,
				TP2.Prodaux2,
				TP1.Prodaux1
            FROM
                App_Despesas AS TCO
                    LEFT JOIN Tab_TipoDespesa AS TTC ON TTC.idTab_TipoDespesa = TCO.TipoDespesa
					LEFT JOIN App_ProdutoCompra AS APC ON APC.idApp_Despesas = TCO.idApp_Despesas
					LEFT JOIN Tab_Produtos AS TPB ON TPB.idTab_Produtos = APC.idTab_Produto
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TPB.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TPB.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TPB.Prodaux1
            WHERE
                TCO.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				TCO.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(' . $consulta . ')
				' . $data['TipoDespesa'] . '
				' . $data['Produtos'] . ' AND
				TCO.TipoProduto = "D" AND
				TPB.idTab_Produtos != "0"

            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          #exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');

            }
            return $query;
        }
    }

	public function list_produtosdevol($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '" AND TCO.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

		$data['TipoDespesa'] = ($data['TipoDespesa']) ? ' AND TTC.idTab_TipoConsumo = ' . $data['TipoDespesa'] : FALSE;
		$data['Produtos'] = ($data['Produtos']) ? ' AND TPB.idTab_Produtos = ' . $data['Produtos'] : FALSE;
        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Prodaux1'] = ($data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		$data['Prodaux2'] = ($data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
		$filtro1 = ($data['AprovadoDespesas'] != '#') ? 'TCO.AprovadoDespesas = "' . $data['AprovadoDespesas'] . '" AND ' : FALSE;
        $query = $this->db->query('
            SELECT
                C.NomeCliente,
				TCO.idApp_Despesas,
				TCO.idApp_OrcaTrata,
				TCO.Despesa,
				TTC.TipoDespesa,
				TCO.TipoProduto,
                TCO.DataDespesas,
				TCO.ValorDespesas,
				APC.QtdCompraProduto,
				APC.ValorCompraProduto,
				APC.idTab_Produto,
				TCO.AprovadoDespesas,
				TFP.FormaPag,
				TCO.FormaPagamentoDespesas,
				TPB.Produtos,
				TPB.CodProd,
				TP3.Prodaux3,
				TP2.Prodaux2,
				TP1.Prodaux1

            FROM
                App_Despesas AS TCO
                    LEFT JOIN Tab_TipoDespesa AS TTC ON TTC.idTab_TipoDespesa = TCO.TipoDespesa
					LEFT JOIN App_ProdutoCompra AS APC ON APC.idApp_Despesas = TCO.idApp_Despesas
					LEFT JOIN Tab_Produtos AS TPB ON TPB.idTab_Produtos = APC.idTab_Produto
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = TCO.FormaPagamentoDespesas
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TPB.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TPB.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TPB.Prodaux1
					LEFT JOIN App_OrcaTrata AS TR ON TR.idApp_OrcaTrata = TCO.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = TR.idApp_Cliente
            WHERE
                TCO.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				TCO.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeCliente'] . ' AND
				(' . $consulta . ')
				' . $data['TipoDespesa'] . '
				' . $data['Produtos'] . '
				' . $data['Prodaux1'] . '
				' . $data['Prodaux2'] . '
				' . $data['Prodaux3'] . ' AND
				TCO.TipoProduto = "E" AND
				TPB.idTab_Produtos != "0"

            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          #exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');

            }
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

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['FormaPag'] = ($data['FormaPag']) ? ' AND TFP.idTab_FormaPag = ' . $data['FormaPag'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
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

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;

        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ServicoConcluido'] != '#') ? 'OT.ServicoConcluido = "' . $data['ServicoConcluido'] . '" AND ' : FALSE;
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
                OT.ServicoConcluido,
                OT.QuitadoOrca,
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
		$filtro3 = ($data['ServicoConcluidoDespesas'] != '#') ? 'OT.ServicoConcluidoDespesas = "' . $data['ServicoConcluidoDespesas'] . '" AND ' : FALSE;

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
                OT.ServicoConcluidoDespesas,
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
                $row->ServicoConcluidoDespesas = $this->basico->mascara_palavra_completa($row->ServicoConcluidoDespesas, 'NS');
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
		$filtro3 = ($data['ServicoConcluidoDespesas'] != '#') ? 'OT.ServicoConcluidoDespesas = "' . $data['ServicoConcluidoDespesas'] . '" AND ' : FALSE;

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
                OT.ServicoConcluidoDespesas,
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

                $row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
                $row->ServicoConcluidoDespesas = $this->basico->mascara_palavra_completa($row->ServicoConcluidoDespesas, 'NS');
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
				C.Empresa = ' . $_SESSION['log']['id'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeCliente'] . '
				OR
				C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
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

        $data['Nome'] = ($data['Nome']) ? ' AND C.idSis_Usuario = ' . $data['Nome'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.Nome' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];



        $query = $this->db->query('
            SELECT
				C.idSis_Usuario,
				C.Associado,
                C.Nome,
                C.DataNascimento,
                C.Celular,
                C.Sexo,
                C.Email,
				C.Usuario,
				SN.StatusSN,
				C.Inativo
            FROM
                Sis_Usuario AS C
					LEFT JOIN Tab_StatusSN AS SN ON SN.Inativo = C.Inativo
            WHERE
                C.Associado = ' . $_SESSION['log']['id'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['Nome'] . '
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
                $row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

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
				C.UsuarioEmpresaFilial,
				SN.StatusSN,
				C.Inativo
            FROM
                Sis_EmpresaFilial AS C
					LEFT JOIN Tab_StatusSN AS SN ON SN.Inativo = C.Inativo
            WHERE
                C.Associado = ' . $_SESSION['log']['id'] . ' AND
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
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
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
				F.idSis_EmpresaFilial = ' . $_SESSION['log']['id'] . ' AND
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
                E.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
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

	public function list_produtos($data, $completo) {

		$data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produtos = ' . $data['Produtos'] : FALSE;
		$data['Prodaux1'] = ($data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		$data['Prodaux2'] = ($data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TP.idTab_Produtos,
				TP.TipoProduto,
				TP.CodProd,
				TP.Produtos,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TP3.Prodaux3,
				TP1.Abrev1,
				TP2.Abrev2,
				TP3.Abrev3,
				TP.UnidadeProduto,
				TP.ValorCompraProduto,
				TP.Fornecedor,
				TF.NomeFornecedor,
				TCA.Categoria,
				TCA.Abrev,
				TV.Convdesc,
				TV.ValorVendaProduto,
				TC.Convenio
            FROM
                Tab_Produtos AS TP
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TP.idTab_Produtos
					LEFT JOIN Tab_Convenio AS TC ON TC.idTab_Convenio = TV.Convenio
					LEFT JOIN App_Fornecedor AS TF ON TF.idApp_Fornecedor = TP.Fornecedor
					LEFT JOIN Tab_Categoria AS TCA ON TCA.Abrev = TP.Categoria
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TP.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['Produtos'] . '
				' . $data['Prodaux1'] . '
				' . $data['Prodaux2'] . '
				' . $data['Prodaux3'] . '
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
				OT.ServicoConcluido,
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
				TF.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
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
                idSis_Usuario,
                Nome
            FROM
                Sis_Usuario
            WHERE
                Associado = ' . $_SESSION['log']['id'] . ' AND
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Usuario] = $row->Nome;
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
                Associado = ' . $_SESSION['log']['id'] . ' AND
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
                idApp_Empresa,
				CONCAT(NomeEmpresa, " ", " --- ", Telefone1, " --- ", Telefone2) As NomeEmpresa
            FROM
                App_Empresa
            WHERE
                idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Empresa] = $row->NomeEmpresa;
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
                F.Empresa = ' . $_SESSION['log']['id'] . ' AND
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

	public function select_profissional() {

        $query = $this->db->query('
            SELECT
                P.idApp_Profissional,
                CONCAT(P.NomeProfissional, " ", "---", P.Telefone1) AS NomeProfissional
            FROM
                App_Profissional AS P
            WHERE
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
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
                P2.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
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
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
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
                OB.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
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

	public function select_produtos() {

        $query = $this->db->query('
            SELECT
                OB.idTab_Produtos,
				CONCAT(IFNULL(OB.CodProd,""), " - ", IFNULL(TP3.Prodaux3,""), " - ", IFNULL(OB.Produtos,""), " - ", IFNULL(TP1.Prodaux1,""), " - ", IFNULL(TP2.Prodaux2,"")) AS Produtos,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TP3.Prodaux3,
				TP1.Abrev1,
				TP2.Abrev2,
                OB.CodProd
            FROM
                Tab_Produtos AS OB
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = OB.Prodaux1
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = OB.Prodaux2
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = OB.Prodaux3
            WHERE
                OB.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				OB.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                OB.CodProd,
				TP3.Prodaux3,
				Produtos ASC,
				TP1.Abrev1 DESC,
				TP2.Abrev2 DESC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Produtos] = $row->Produtos;
        }

        return $array;
    }

	public function select_prodaux1() {

        $query = $this->db->query('
            SELECT
                P.idTab_Prodaux1,
                P.Prodaux1
            FROM
                Tab_Prodaux1 AS P
            WHERE
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Prodaux1 ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Prodaux1] = $row->Prodaux1;
        }

        return $array;
    }

	public function select_prodaux2() {

        $query = $this->db->query('
            SELECT
                P.idTab_Prodaux2,
                P.Prodaux2
            FROM
                Tab_Prodaux2 AS P
            WHERE
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Prodaux2 ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Prodaux2] = $row->Prodaux2;
        }

        return $array;
    }

	public function select_prodaux3() {

        $query = $this->db->query('
            SELECT
                P.idTab_Prodaux3,
                P.Prodaux3
            FROM
                Tab_Prodaux3 AS P
            WHERE
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Prodaux3 ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Prodaux3] = $row->Prodaux3;
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
                OB.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
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
                P.Empresa = ' . $_SESSION['log']['Empresa'] . '
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
