<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrataprint_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function get_orcatrata_verificacao($data) {

		if($_SESSION['Empresa']['Rede'] == "S"){
			if($_SESSION['Usuario']['Nivel'] == 2){
				$nivel = 'AND OT.NivelOrca = 2';
				$revendedor = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}elseif($_SESSION['Usuario']['Nivel'] == 1){
				$nivel = FALSE;
				$revendedor = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
					$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}else{
					$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}
			}else{
				$nivel = FALSE;
				$revendedor = FALSE;
				$permissao_orcam = FALSE;
			}
		}else{
			if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
				$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao_orcam = FALSE;
			}
			$nivel = FALSE;
			$revendedor = FALSE;
		}

        $query = $this->db->query(
            'SELECT
				OT.idApp_OrcaTrata,
				OT.idTab_TipoRD
            FROM
				App_OrcaTrata AS OT
            WHERE
            	OT.idApp_OrcaTrata = ' . $data . ' AND
				' . $revendedor . '
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }

    public function get_orcatrata($data) {

		if($_SESSION['Empresa']['Rede'] == "S"){
			if($_SESSION['Usuario']['Nivel'] == 2){
				$nivel = 'AND OT.NivelOrca = 2';
				$revendedor = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}elseif($_SESSION['Usuario']['Nivel'] == 1){
				$nivel = FALSE;
				$revendedor = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
					$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}else{
					$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}
			}else{
				$nivel = FALSE;
				$revendedor = FALSE;
				$permissao_orcam = FALSE;
			}
		}else{
			if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
				$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
			}else{
				$permissao_orcam = FALSE;
			}
			$nivel = FALSE;
			$revendedor = FALSE;
		}
		
        $query = $this->db->query(
            'SELECT
				C.NomeCliente,
				C.CelularCliente,
				C.Telefone,
				C.Telefone2,
				C.Telefone3,
				C.EnderecoCliente,
				C.NumeroCliente,
				C.ComplementoCliente,
				C.BairroCliente,
				C.CidadeCliente,
				C.EstadoCliente,
				C.ReferenciaCliente,
				
				OT.idApp_ClientePet,
				OT.idApp_ClienteDep,
				
				OT.idSis_Empresa,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				OT.ConcluidoOrca,
				OT.QuitadoOrca,
				
				OT.Cep,
				OT.Logradouro,
				OT.Numero,
				OT.Complemento,
				OT.Bairro,
				OT.Cidade,
				OT.Estado,
				OT.Referencia,
				
				OT.NomeRec,
				OT.TelefoneRec,
				OT.ParentescoRec,
				OT.ObsEntrega,
				OT.Aux1Entrega,
				OT.Aux2Entrega,

				OT.PrazoEntrega,
				OT.ValorTotalOrca,
				OT.ValorFrete,
				OT.CombinadoFrete,
				TF.TipoFrete,
				OT.FinalizadoOrca,
				OT.EnviadoOrca,
				OT.ProntoOrca,
				SU.Nome AS Entregador,
				
				OT.DataOrca,
				OT.DataEntregaOrca,
				DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
				OT.DataPrazo,
				OT.DataConclusao,
				OT.DataQuitado,				
				OT.DataRetorno,
				OT.DataEntradaOrca,
				OT.idApp_Cliente,
				OT.idApp_Fornecedor,
				OT.id_Funcionario,
				OT.id_Associado,
				OT.ValorOrca,
				OT.ValorDev,
				OT.QtdPrdOrca,
				OT.QtdSrvOrca,
				OT.ValorDinheiro,
				OT.ValorTroco,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.ValorExtraOrca,
				OT.ValorSomaOrca,
				OT.QtdParcelasOrca,
				OT.DataVencimentoOrca,
				OT.idSis_Usuario,
				OT.ObsOrca,
				OT.Consideracoes,
				OT.Descricao,
				OT.TipoFinanceiro,
				OT.Tipo_Orca,
				FP.FormaPag,				
				EF.NomeEmpresa,	
				EF.Site,
				EF.idSis_Empresa,
				EF.Arquivo,
				EF.Cnpj,
				EF.CepEmpresa,
				EF.EnderecoEmpresa,
				EF.NumeroEmpresa,
				EF.ComplementoEmpresa,
				EF.BairroEmpresa,
				EF.MunicipioEmpresa,
				EF.EstadoEmpresa,
				EF.Telefone,
				TAVAP.AVAP AS OndePagar,
				MO.AVAP,
				MO.Abrev3,
				OT.Modalidade,
				OT.TipoDescOrca,
				OT.DescPercOrca,
				OT.DescValorOrca,
				OT.UsarCashBack,
				OT.UsarCupom,
				OT.Cupom,
				OT.CashBackOrca,
				OT.ValorFinalOrca,
				OT.idTab_TipoRD,
				MO.Modalidade,
				TP.TipoFinanceiro

            FROM
				App_OrcaTrata AS OT
				LEFT JOIN Sis_Empresa AS EF ON EF.idSis_Empresa = OT.idSis_Empresa
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
				LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TP ON TP.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_AVAP AS TAVAP ON TAVAP.Abrev2 = OT.AVAP
				LEFT JOIN Tab_Modalidade AS MO ON MO.Abrev = OT.Modalidade
				LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
				LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = OT.Entregador

            WHERE
				' . $revendedor . '
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
            	OT.idApp_OrcaTrata = ' . $data . ' 
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

	public function get_servico1($data) {
		$query = $this->db->query('SELECT * FROM App_Servico WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

	public function get_servico($data) {
		$query = $this->db->query(
            'SELECT
            	PV.QtdProduto,
				PV.DataValidadeProduto,
				(PV.QtdProduto * PV.QtdIncrementoProduto) AS SubTotalQtd,
				PV.ObsProduto,
				PV.idApp_Produto,
				PV.idApp_OrcaTrata,
				PV.ConcluidoProduto,
				PV.DataConcluidoProduto,
				PV.HoraConcluidoProduto,
				PV.Prod_Serv_Produto,
				P.UnidadeProduto,
				P.Cod_Prod,
				TCO.Convenio,
				V.Convdesc,
				TFO.NomeFornecedor,
				SU1.Nome,
				SU2.Nome,
				SU3.Nome,
				SU4.Nome,
				CONCAT(IFNULL(PV.idApp_Produto,""), " - " , IFNULL(PV.ConcluidoProduto,""), " - Obs.: " , IFNULL(PV.ObsProduto,"")) AS idApp_Produto,
				CONCAT(IFNULL(PV.QtdProduto,"")) AS QtdProduto,
            	CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(TPM.Promocao,"")) AS NomeProduto,
            	
				CONCAT(IFNULL(SU1.Nome,"")) AS Prof1,
            	CONCAT(IFNULL(SU2.Nome,"")) AS Prof2,
            	CONCAT(IFNULL(SU3.Nome,"")) AS Prof3,
            	CONCAT(IFNULL(SU4.Nome,"")) AS Prof4,
            	
				PV.ValorProduto
				
            FROM
            	App_Produto AS PV
				
					LEFT JOIN App_Funcao AS AF1 ON AF1.idApp_Funcao = PV.ProfissionalProduto_1
					LEFT JOIN App_Funcao AS AF2 ON AF2.idApp_Funcao = PV.ProfissionalProduto_2
					LEFT JOIN App_Funcao AS AF3 ON AF3.idApp_Funcao = PV.ProfissionalProduto_3
					LEFT JOIN App_Funcao AS AF4 ON AF4.idApp_Funcao = PV.ProfissionalProduto_4
					
					LEFT JOIN Sis_Usuario AS SU1 ON SU1.idSis_Usuario = AF1.idSis_Usuario
					LEFT JOIN Sis_Usuario AS SU2 ON SU2.idSis_Usuario = AF2.idSis_Usuario
					LEFT JOIN Sis_Usuario AS SU3 ON SU3.idSis_Usuario = AF3.idSis_Usuario
					LEFT JOIN Sis_Usuario AS SU4 ON SU4.idSis_Usuario = AF4.idSis_Usuario
					
            		LEFT JOIN Tab_Valor AS V ON V.idTab_Valor = PV.idTab_Produto
					LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
            WHERE
            	PV.idApp_OrcaTrata = ' . $data . ' AND
				PV.Prod_Serv_Produto = "S"
            ORDER BY
            	PV.idApp_Produto'
        );
        $query = $query->result_array();

        return $query;
    }

    public function get_produto($data) {
		$query = $this->db->query(
            'SELECT
            	PV.QtdProduto,
				PV.QtdIncrementoProduto,
				(PV.QtdProduto * PV.QtdIncrementoProduto) AS SubTotalQtd,
				PV.DataValidadeProduto,
				PV.DataConcluidoProduto,
				PV.HoraConcluidoProduto,
				PV.ObsProduto,
				PV.idApp_Produto,
				PV.idApp_OrcaTrata,
				PV.ConcluidoProduto,
				PV.DevolvidoProduto,
				PV.Prod_Serv_Produto,
				P.UnidadeProduto,
				P.Cod_Prod,
				TCO.Convenio,
				V.Convdesc,
				TFO.NomeFornecedor,
				CONCAT(IFNULL(PV.QtdProduto,""), " X " , IFNULL(PV.QtdIncrementoProduto,"")) AS QtdProduto,
            	CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(V.Convdesc,"")) AS NomeProduto,
            	PV.ValorProduto
				FROM
            	App_Produto AS PV
            		LEFT JOIN Tab_Valor AS V ON V.idTab_Valor = PV.idTab_Produto
					LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos					
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor

            WHERE
            	PV.idApp_OrcaTrata = ' . $data . ' AND
				PV.Prod_Serv_Produto = "P"
            ORDER BY
            	PV.idApp_Produto'
        );
        $query = $query->result_array();

        return $query;
    }

    public function get_produto_desp($data) {
		$query = $this->db->query(
            'SELECT
            	PV.QtdProduto,
				PV.QtdIncrementoProduto,
				(PV.QtdProduto * PV.QtdIncrementoProduto) AS SubTotalQtd,
				PV.DataValidadeProduto,
				PV.ObsProduto,
				PV.idApp_Produto,
				PV.idApp_OrcaTrata,
				PV.ConcluidoProduto,
				PV.DevolvidoProduto,
				P.UnidadeProduto,
				P.Cod_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				TFO.NomeFornecedor,
				CONCAT(IFNULL(PV.QtdProduto,""), " X " , IFNULL(PV.QtdIncrementoProduto,"")) AS QtdProduto,
            	CONCAT(IFNULL(P.Nome_Prod,"")) AS NomeProduto,
            	PV.ValorProduto
            FROM
            	App_Produto AS PV
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = PV.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2					
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor

            WHERE
            	PV.idApp_OrcaTrata = ' . $data . ' AND
                PV.idTab_Produto = P.idTab_Produtos AND
				PV.Prod_Serv_Produto = "P"
            ORDER BY
            	PV.idApp_Produto'
        );
        $query = $query->result_array();

        return $query;
    }

	public function get_servico_desp($data) {
		$query = $this->db->query(
            'SELECT
            	PV.QtdProduto,
				PV.QtdIncrementoProduto,
				(PV.QtdProduto * PV.QtdIncrementoProduto) AS SubTotalQtd,
				PV.DataValidadeProduto,
				PV.ObsProduto,
				PV.idApp_Produto,
				PV.idApp_OrcaTrata,
				PV.ConcluidoProduto,
				PV.DevolvidoProduto,
				P.UnidadeProduto,
				P.Cod_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				TFO.NomeFornecedor,
				CONCAT(IFNULL(PV.QtdProduto,""), " X " , IFNULL(PV.QtdIncrementoProduto,"")) AS QtdProduto,
            	CONCAT(IFNULL(P.Nome_Prod,"")) AS NomeProduto,
            	PV.ValorProduto
            FROM
            	App_Produto AS PV
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = PV.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2					
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
            WHERE
            	PV.idApp_OrcaTrata = ' . $data . ' AND
                PV.idTab_Produto = P.idTab_Produtos AND
				PV.Prod_Serv_Produto = "S"
            ORDER BY
            	PV.idApp_Produto'
        );
        $query = $query->result_array();

        return $query;
    }
	
	public function get_servico_desp_original($data) {
		$query = $this->db->query(
            'SELECT
            	PV.QtdServico,
				PV.DataValidadeServico,
				PV.ObsServico,
				PV.idApp_Servico,
				PV.idApp_OrcaTrata,
				PV.ConcluidoServico,
				P.UnidadeProduto,
				P.Cod_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				TFO.NomeFornecedor,
				SU.Nome,
				CONCAT(IFNULL(PV.idApp_Servico,""), " - " , IFNULL(PV.ConcluidoServico,""), " - Obs.: " , IFNULL(PV.ObsServico,"")) AS idApp_Servico,
				CONCAT(IFNULL(PV.QtdServico,"")) AS QtdServico,
            	CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(SU.Nome,"")) AS NomeServico,
            	PV.ValorServico
            FROM
            	App_Servico AS PV
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = PV.ProfissionalServico
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = PV.idTab_Servico
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
            WHERE
            	PV.idApp_OrcaTrata = ' . $data . ' AND
                PV.idTab_Produto = P.idTab_Produtos AND
				PV.Prod_Serv_Produto = "S"
            ORDER BY
            	PV.idApp_Servico'
        );
        $query = $query->result_array();

        return $query;
    }
	
    public function get_parcelasrec($data) {
		$query = $this->db->query('
			SELECT 
				PR.*,
				FP.FormaPag
			FROM 
				App_Parcelas AS PR 
					LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = PR.FormaPagamentoParcela
			WHERE 
				PR.idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_profissional($data) {
		$query = $this->db->query('SELECT NomeProfissional FROM App_Profissional WHERE idApp_Profissional = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['NomeProfissional'])) ? $query[0]['NomeProfissional'] : FALSE;
    }

}
