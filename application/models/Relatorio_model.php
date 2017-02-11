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


    public function list_orcamento($data, $completo) {

        $consulta = ($data['DataFim']) ? $data['Pesquisa'] . ' <= "' . $data['DataFim'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
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
                app.App_Cliente AS C,
                app.App_OrcaTrata AS OT,
                app.App_ParcelasRecebiveis AS PR

            WHERE
                ' . $data['Pesquisa'] . ' >= "' . $data['DataInicio'] . '" AND
                ' . $consulta . '
                C.idApp_Cliente = OT.idApp_Cliente AND
                OT.idApp_OrcaTrata = PR.idApp_OrcaTrata

            ORDER BY
                C.NomeCliente ASC,
                ' . $data['Pesquisa'] . ' ASC,
                PR.ParcelaRecebiveis ASC

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

            $entrada=$somaparcela=$somapago=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimentoRecebiveis = $this->basico->mascara_data($row->DataVencimentoRecebiveis, 'barras');
                $row->DataPagoRecebiveis = $this->basico->mascara_data($row->DataPagoRecebiveis, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->QuitadoRecebiveis = $this->basico->mascara_palavra_completa($row->QuitadoRecebiveis, 'NS');

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaparcela += $row->ValorParcelaRecebiveis + $row->ValorEntradaOrca;
                }
                else {
                    $somaparcela += $row->ValorParcelaRecebiveis;
                }
                $somapago += $row->ValorPagoRecebiveis;

                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcelaRecebiveis = number_format($row->ValorParcelaRecebiveis, 2, ',', '.');
                $row->ValorPagoRecebiveis = number_format($row->ValorPagoRecebiveis, 2, ',', '.');
            }
            $query->soma = new stdClass();
            $query->soma->somaparcela = number_format($somaparcela, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');

            return $query;
        }

    }
    
}
