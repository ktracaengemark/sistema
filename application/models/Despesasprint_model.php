<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Despesasprint_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function get_despesas($data) {

        /*
        OT.DataOrca,
        OT.DataPrazo,
        OT.DataConclusao,
        OT.DataRetorno,
        OT.DataEntradaOrca,
        OT.idApp_Cliente,

        OT.ValorDespesas,
        OT.ValorEntradaDespesas,
        OT.ValorRestanteDespesas,
        FP.FormaPag,
        OT.QtdParcelasDespesas,
        OT.DataVencimentoOrca
        */        

        $query = $this->db->query(
            'SELECT
                *
            FROM
            	Tab_FormaPag AS FP,
				App_Despesas AS DP
				LEFT JOIN Sis_EmpresaFilial AS EF ON EF.idSis_EmpresaFilial = DP.Empresa
				LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = DP.idApp_OrcaTrata				
				LEFT JOIN App_Cliente AS CL ON CL.idApp_Cliente = OT.idApp_Cliente
            WHERE
            	DP.idApp_Despesas = ' . $data . ' AND
                DP.FormaPagamentoDespesas = FP.idTab_FormaPag'
        );
        $query = $query->result_array();

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query[0];
    }

	public function get_servico($data) {
		$query = $this->db->query('SELECT * FROM App_ServicoVenda WHERE idApp_Despesas = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_produto($data) {
		$query = $this->db->query(
            'SELECT
            	PV.QtdCompraProduto,
				PV.DataValidadeProduto,
				PV.idApp_ProdutoCompra,
				PV.idApp_Despesas,
				P.UnidadeProduto,
				P.CodProd,
				TP3.Prodaux3,
				TP1.Prodaux1,
            	TP2.Prodaux2,
				TCO.Convenio,
				V.Convdesc,
				TFO.NomeFornecedor,
            	CONCAT(IFNULL(P.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(P.Produtos,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,"")) AS NomeProduto,
            	PV.ValorCompraProduto
            FROM
            	App_ProdutoCompra AS PV,
            	Tab_Valor AS V
            		LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
            		LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = P.Prodaux3
            		LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = P.Prodaux2
            		LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = P.Prodaux1
            WHERE
            	PV.idApp_Despesas = ' . $data . ' AND
                PV.idTab_Produto = V.idTab_Valor AND
            	P.idTab_Produtos = V.idTab_Produtos
            ORDER BY
            	PV.idApp_ProdutoCompra'
        );
        $query = $query->result_array();

        return $query;
    }

    public function get_parcelaspag($data) {
		$query = $this->db->query('SELECT * FROM App_ParcelasPagaveis WHERE idApp_Despesas = ' . $data);
        $query = $query->result_array();

        return $query;
    }
/*
    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_Despesas = ' . $data);
        $query = $query->result_array();

        return $query;
    }
*/
    public function get_profissional($data) {
		$query = $this->db->query('SELECT NomeProfissional FROM App_Profissional WHERE idApp_Profissional = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['NomeProfissional'])) ? $query[0]['NomeProfissional'] : FALSE;
    }

}
