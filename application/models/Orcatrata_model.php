<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrata_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_orcatrata($data) {

        $query = $this->db->insert('App_OrcaTrata', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
		} else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	

    public function set_servico($data) {

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        //exit ();
        */

        $query = $this->db->insert_batch('App_Produto', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_produto($data) {

        $query = $this->db->insert_batch('App_Produto', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
		#return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_parcelas($data) {

        $query = $this->db->insert_batch('App_Parcelas', $data);
		
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
		}
    }
	
    public function set_comissao($data) {

        $query = $this->db->insert_batch('App_OrcaTrata', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_procedimento($data) {

        $query = $this->db->insert_batch('App_Procedimento', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_arquivos($data) {

        $query = $this->db->insert('App_Arquivos', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_arquivo($data) {

        $query = $this->db->insert('Sis_Arquivo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }
	
    public function get_arquivos_verificacao($data) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
		$query = $this->db->query(
			'SELECT
				idApp_Arquivos 
			FROM 
				App_Arquivos 
			WHERE 
				idApp_Arquivos = ' . $data . ' AND
				' . $revendedor . '
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}		
    }
	
    public function get_arquivos($data) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query(
			'SELECT
				*
			FROM 
				App_Arquivos 
			WHERE 
				idApp_Arquivos = ' . $data . ' AND
				' . $revendedor . '
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}		
    }

    public function get_orcatrata_delete($data) {
        $query = $this->db->query('
			SELECT 
				OT.idApp_Cliente,
				OT.CanceladoOrca,
				OT.QuitadoOrca
			FROM 
				App_OrcaTrata AS OT
			WHERE 
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

        return $query[0];
    }

    public function get_orcatrata_delete_produtos($data) {
        $query = $this->db->query('
			SELECT 
				PRD.ValorComissaoCashBack
			FROM 
				App_OrcaTrata AS OT
					LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
			WHERE 
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

        return $query;
    }

    public function get_orcatrata_verificacao($data) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query(
			'SELECT 
				OT.idApp_OrcaTrata,
				OT.idTab_TipoRD,
				OT.idApp_Cliente
			FROM 
				App_OrcaTrata AS OT 
			WHERE 
				OT.idApp_OrcaTrata = ' . $data . ' AND
				' . $revendedor . '
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
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

        //return $query[0];
		if($query){
			return $query[0];
		}else{
			return FALSE;
		}		
    }

    public function get_orcatrata($data) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query('
			SELECT 
				OT.*,
				C.*,
				FP.*,
				TF.*,
				TF.idTab_TipoFinanceiro AS TipoFinanceiro,
				TF.TipoFinanceiro AS NomeTipoFinanceiro,
				SU.*
			FROM 
				App_OrcaTrata AS OT 
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TF ON TF.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = OT.idSis_Usuario
			WHERE 
				OT.idApp_OrcaTrata = ' . $data . ' AND
				' . $revendedor . '
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
		');

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
    }

    public function get_orcatrata_arquivo($data) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
        $query = $this->db->query(
			'SELECT 
				OT.*
			FROM 
				App_OrcaTrata AS OT 
			WHERE 
				idApp_OrcaTrata = ' . $data . ' AND
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
	
    public function get_orcatratas($data) {
        $query = $this->db->query('
			SELECT *
			FROM 
				App_OrcaTrata
			WHERE 
				RepeticaoOrca = ' . $data . '
			ORDER BY
				DataOrca ASC
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

        return $query;
    }
	
    public function get_orcatratas_repet($data) {
        $query = $this->db->query('
			SELECT *
			FROM 
				App_OrcaTrata
			WHERE 
				RepeticaoOrca = ' . $data . ' AND
				RepeticaoOrca != 0 
			ORDER BY
				idApp_OrcaTrata ASC
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

        return $query;
    }
	
    public function get_repeticaoorca($data) {
        $query = $this->db->query('
			SELECT 
				idApp_OrcaTrata
			FROM 
				App_OrcaTrata
			WHERE 
				RepeticaoCons = ' . $data . ' AND
				RepeticaoCons != 0 
			ORDER BY
				idApp_OrcaTrata ASC
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

        return $query;
    }

    public function get_repeticao($data) {
        $query = $this->db->query('
			SELECT 
				idApp_OrcaTrata,
				RepeticaoOrca
			FROM 
				App_OrcaTrata
			WHERE 
				RepeticaoCons = ' . $data . ' AND
				RepeticaoCons != 0 
			ORDER BY
				idApp_OrcaTrata ASC
			LIMIT 1
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

        return $query;
    }
		
    public function get_repeticaocons($data) {
        $query = $this->db->query('
			SELECT 
				idApp_Consulta
			FROM 
				App_Consulta
			WHERE 
				Repeticao = ' . $data . ' AND
				Repeticao != 0 
			ORDER BY
				idApp_Consulta ASC
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

        return $query;
    }
	
    public function get_orcatratas_repet_n_pago($data, $data2) {
        $query = $this->db->query('
			SELECT
				OT.RepeticaoOrca,
				OT.idApp_OrcaTrata,
				PRC.idApp_Parcelas,
				PRC.ValorParcela
			FROM 
				App_OrcaTrata AS OT
				 LEFT JOIN App_Parcelas AS PRC ON PRC.idApp_OrcaTrata = OT.idApp_OrcaTrata
			WHERE 
				OT.RepeticaoOrca = ' . $data . ' AND
				OT.idApp_OrcaTrata != ' . $data2 . ' AND
				OT.QuitadoOrca = "N" AND
				OT.RepeticaoOrca != 0 AND
				PRC.Quitado = "N" 
			ORDER BY
				PRC.idApp_Parcelas ASC
		');
        $query = $query->result_array();
		
        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo '<br>';
		print_r($data2);
        echo '<br>';
		print_r($query);
        echo "</pre>";
        exit ();
        */
        return $query;
    }
	
    public function get_orcatratas_repet_s_pago($data, $data2) {
        $query = $this->db->query('
			SELECT
				OT.RepeticaoOrca,
				OT.idApp_OrcaTrata,
				OT.ValorFinalOrca,
				PRD.idApp_Produto,
				PRD.ValorComissaoCashBack
			FROM 
				App_OrcaTrata AS OT
					LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
			WHERE 
				OT.RepeticaoOrca = ' . $data . ' AND
				OT.idApp_OrcaTrata != ' . $data2 . ' AND
				OT.QuitadoOrca = "S" AND
				OT.RepeticaoOrca != 0 
			ORDER BY
				OT.idApp_OrcaTrata ASC
		');
        $query = $query->result_array();
		
        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo '<br>';
		print_r($data2);
        echo '<br>';
		print_r($query);
        echo "</pre>";
        exit ();
        */
        return $query;
    }
	
    public function get_orcatratas_repet_total($data, $data2) {
        $query = $this->db->query('
			SELECT
				OT.RepeticaoOrca,
				OT.idApp_OrcaTrata,
				PRD.idApp_Produto,
				PRD.ValorComissaoCashBack
			FROM 
				App_OrcaTrata AS OT
					LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
			WHERE 
				OT.RepeticaoOrca = ' . $data . ' AND
				OT.idApp_OrcaTrata != ' . $data2 . ' AND
				OT.RepeticaoOrca != 0 
			ORDER BY
				OT.idApp_OrcaTrata ASC
		');
        $query = $query->result_array();
		
        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo '<br>';
		print_r($data2);
        echo '<br>';
		print_r($query);
        echo "</pre>";
        exit ();
        */
        return $query;
    }
				
    public function get_orcatrata_baixa($data) {
        $query = $this->db->query('
			SELECT * 
			FROM 
				App_OrcaTrata
			WHERE 
				idApp_OrcaTrata = ' . $data . '
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

        return $query[0];
    }
	
    public function get_orcatrata2($data) {
        $query = $this->db->query('
		SELECT * 
			FROM 
				App_OrcaTrata AS OT 
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_AVAP AS TAVAP ON TAVAP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = OT.Entregador
			WHERE 
				idApp_OrcaTrata = ' . $data . '
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

        return $query[0];
    }	
				
    public function get_orcamento_baixa_parcela($data) {
        $query = $this->db->query('
			SELECT 
				idApp_OrcaTrata,
				idApp_Cliente,
				CanceladoOrca,
				QuitadoOrca,
				FormaPagamento
			FROM 
				App_OrcaTrata
			WHERE 
				idApp_OrcaTrata = ' . $data . '
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

        return $query[0];
    }
				
    public function get_orcamento_baixa_produto($data) {
        $query = $this->db->query('
			SELECT 
				idApp_OrcaTrata,
				idApp_Cliente,
				CombinadoFrete,
				AprovadoOrca,
				ConcluidoOrca,
				QuitadoOrca,
				CanceladoOrca
			FROM 
				App_OrcaTrata
			WHERE 
				idApp_OrcaTrata = ' . $data . '
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

        return $query[0];
    }

    public function get_cliente($data) {
        $query = $this->db->query('SELECT * FROM App_Cliente WHERE idApp_Cliente = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_cliente_delete($data) {
        $query = $this->db->query('SELECT CashBackCliente FROM App_Cliente WHERE idApp_Cliente = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_ult_pdd_cliente($data) {
        $query = $this->db->query('
			SELECT
				OT.idApp_OrcaTrata,
				OT.DataOrca
			FROM 
				App_OrcaTrata AS OT
			WHERE 
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
				OT.idApp_Cliente = '.$data.'
			 ORDER BY 
				OT.DataOrca DESC,
				OT.idApp_OrcaTrata DESC
			LIMIT 1
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
        return $query[0];
        //return $query;
    }

    public function get_pri_pdd_cliente($data) {
        $query = $this->db->query('SELECT CashBackCliente FROM App_Cliente WHERE idApp_Cliente = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }
		
    public function get_pet($data) {
        $query = $this->db->query('SELECT * FROM App_ClientePet WHERE idApp_ClientePet = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_dep($data) {
        $query = $this->db->query('SELECT * FROM App_ClienteDep WHERE idApp_ClienteDep = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }
			
    public function get_fornecedor($data) {
        $query = $this->db->query('SELECT * FROM App_Fornecedor WHERE idApp_Fornecedor = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }	
	
    public function get_orcatrataalterar($data) {
        $query = $this->db->query('
			SELECT 
				* 
			FROM 
				Sis_Empresa 
			WHERE 
				idSis_Empresa = ' . $data . ' AND
				' . $_SESSION['log']['idSis_Empresa'] . ' = ' . $data . ''
		);
		
        //$query = $query->result_array();
        //return $query[0];

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }		
    }

    public function get_servico($data) {
		$query = $this->db->query('
			SELECT 
				TAP.idApp_Produto,
				TAP.idSis_Empresa,
				TAP.idTab_Modulo,
				TAP.idApp_OrcaTrata,
				TAP.idApp_Cliente,
				TAP.idApp_Fornecedor,
				TAP.idSis_Usuario,
				TAP.idTab_Produto,
				TAP.idTab_Valor_Produto,
				TAP.idTab_Produtos_Produto,
				TAP.Prod_Serv_Produto,
				TAP.NomeProduto,
				TAP.ComissaoProduto,
				TAP.ComissaoServicoProduto,
				TAP.ComissaoCashBackProduto,
				TAP.ValorComissaoServico,
				TAP.PrazoProduto,
				TAP.ValorProduto,
				TAP.ObsProduto,
				TAP.QtdProduto,
				TAP.QtdIncrementoProduto,
				TAP.DataValidadeProduto,
				TAP.DataConcluidoProduto,
				TAP.HoraConcluidoProduto,
				TAP.ConcluidoProduto,
				TAP.idTab_TipoRD,
				TAP.ProfissionalProduto_1,
				TAP.ProfissionalProduto_2,
				TAP.ProfissionalProduto_3,
				TAP.ProfissionalProduto_4,
				TAP.ProfissionalProduto_5,
				TAP.ProfissionalProduto_6,
				TAP.ValorComProf_1,
				TAP.idTFProf_1,
				TAP.ComFunProf_1,
				TAP.ValorComProf_2,
				TAP.idTFProf_2,
				TAP.ComFunProf_2,
				TAP.ValorComProf_3,
				TAP.idTFProf_3,
				TAP.ComFunProf_3,
				TAP.ValorComProf_4,
				TAP.idTFProf_4,
				TAP.ComFunProf_4,
				TAP.ValorComProf_5,
				TAP.idTFProf_5,
				TAP.ComFunProf_5,
				TAP.ValorComProf_6,
				TAP.idTFProf_6,
				TAP.ComFunProf_6,
				P.Nome_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TDS.Desconto,""), " - ", IFNULL(TPM.Promocao,"")) AS Produto,
				(TAP.QtdProduto * TAP.ValorProduto) AS Subtotal_Produto
			FROM 
				App_Produto AS TAP
					LEFT JOIN Sis_Usuario AS SU1 ON SU1.idSis_Usuario = TAP.ProfissionalProduto_1
					LEFT JOIN Sis_Usuario AS SU2 ON SU2.idSis_Usuario = TAP.ProfissionalProduto_2
					LEFT JOIN Sis_Usuario AS SU3 ON SU3.idSis_Usuario = TAP.ProfissionalProduto_3
					LEFT JOIN Sis_Usuario AS SU4 ON SU4.idSis_Usuario = TAP.ProfissionalProduto_4
					LEFT JOIN Sis_Usuario AS SU5 ON SU5.idSis_Usuario = TAP.ProfissionalProduto_5
					LEFT JOIN Sis_Usuario AS SU6 ON SU6.idSis_Usuario = TAP.ProfissionalProduto_6
					LEFT JOIN Tab_Valor AS V ON V.idTab_Valor = TAP.idTab_Produto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2
			WHERE 
				TAP.idApp_OrcaTrata = ' . $data . ' AND
				TAP.Prod_Serv_Produto = "S" 
		');
        $query = $query->result_array();

        return $query;
    }
	
	public function get_servicodesp($data) {
		$query = $this->db->query('SELECT * FROM App_Produto WHERE idApp_OrcaTrata = ' . $data . ' AND Prod_Serv_Produto = "S"  ');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_produto($data) {
		$query = $this->db->query('
			SELECT 
			TAP.idApp_Produto,
				TAP.idSis_Empresa,
				TAP.idTab_Modulo,
				TAP.idApp_OrcaTrata,
				TAP.idApp_Cliente,
				TAP.idApp_Fornecedor,
				TAP.idSis_Usuario,
				TAP.idTab_Produto,
				TAP.idTab_Valor_Produto,
				TAP.idTab_Produtos_Produto,
				TAP.Prod_Serv_Produto,
				TAP.NomeProduto,
				TAP.ValorProduto,
				TAP.QtdProduto,
				TAP.QtdIncrementoProduto,
				(TAP.QtdProduto * TAP.QtdIncrementoProduto) AS SubTotalQtd,
				TAP.ValorCompraProduto,
				TAP.QtdCompraProduto,
				TAP.ObsProduto,
				TAP.DataValidadeProduto,
				TAP.DataConcluidoProduto,
				TAP.HoraConcluidoProduto,
				TAP.HoraValidadeProduto,
				TAP.ConcluidoProduto,
				TAP.DevolvidoProduto,
				TAP.CanceladoProduto,
				TAP.idTab_TipoRD,
				TAP.itens_pedido_valor_total,
				TAP.ComissaoProduto,
				TAP.ComissaoServicoProduto,
				TAP.ComissaoCashBackProduto,
				TAP.PrazoProduto,
				TAP.StatusComissaoPedido,
				TAP.Aux_App_Produto_1,
				TAP.Aux_App_Produto_2,
				TAP.Aux_App_Produto_3,
				TAP.Aux_App_Produto_4,
				TAP.Aux_App_Produto_5,
				TAP.ProfissionalProduto_1,
				V.Convdesc,
				P.Nome_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				SU.Nome,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ",  IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(V.Convdesc,"")) AS Produto,
				(TAP.QtdProduto * TAP.ValorProduto) AS Subtotal_Produto
			FROM 
				App_Produto AS TAP
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = TAP.ProfissionalProduto_1
					LEFT JOIN Tab_Valor AS V ON V.idTab_Valor = TAP.idTab_Produto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2
			WHERE 
				TAP.idApp_OrcaTrata = ' . $data . ' AND
				TAP.Prod_Serv_Produto = "P" 
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_produtos($data) {
        $query = $this->db->query(
			'SELECT
				* 
			FROM 
				App_Produto 
			WHERE 
				idApp_Produto = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        
		//$query = $query->result_array();
        //return $query[0];

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
    }

    public function get_produto_baixa($data) {
		$query = $this->db->query('
			SELECT *
			FROM 
				App_Produto
			WHERE 
				idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_produto_baixa_parcela($data) {
		$query = $this->db->query('
			SELECT *
			FROM 
				App_Produto
			WHERE 
				idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_produtos_baixa_receita($data) {
		$query = $this->db->query('
			SELECT *
			FROM 
				App_Produto
			WHERE 
				idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_produto_cashback($data) {
		$query = $this->db->query('
			SELECT 
				PD.idApp_Produto,
				PD.idSis_Empresa,
				PD.idApp_Cliente,
				PD.ValorComissaoCashBack,
				PD.StatusComissaoCashBack,
				PD.DataPagoCashBack,
				PD.id_Orca_CashBack
			FROM 
				App_Produto AS PD
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PD.idApp_OrcaTrata
			WHERE
				PD.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				PD.StatusComissaoCashBack = "N" AND
				PD.id_Orca_CashBack = 0 AND
				PD.ValorComissaoCashBack > 0.00 AND
				OT.QuitadoOrca = "S" AND
				OT.CanceladoOrca = "N" AND
				PD.idApp_Cliente = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }
		
    public function get_produto_posterior($data) {
		$query = $this->db->query('SELECT * FROM App_Produto WHERE idApp_OrcaTrata = ' . $data . ' AND ConcluidoProduto = "N"');
        $query = $query->result_array();

        return $query;
    }
		
    public function get_produto_posterior_sim($data) {
		$query = $this->db->query('SELECT * FROM App_Produto WHERE idApp_OrcaTrata = ' . $data . ' AND ConcluidoProduto = "S"');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_produto_anterior($data) {
		$query = $this->db->query('SELECT * FROM App_Produto WHERE idApp_Produto = ' . $data . '');
        $query = $query->result_array();

        return $query[0];
    }

    public function get_produto_comissao_atual($data) {
		$query = $this->db->query(
			'SELECT
				ValorComissaoAssociado,
				ValorComissaoFuncionario
			FROM 
				App_Produto 
			WHERE 
				idApp_OrcaTrata = ' . $data . ''
		);
		
        $query = $query->result_array();

        return $query;
    }

    public function get_produto_estoque($data) {
		$query = $this->db->query('SELECT * FROM App_Produto WHERE idApp_OrcaTrata = ' . $data . '');
        $query = $query->result_array();

        return $query;
    }

    public function get_produto_comissao_pedido($data) {
		$query = $this->db->query('SELECT idApp_Produto, idApp_OrcaTrata FROM App_Produto WHERE idApp_OrcaTrata = ' . $data . '');
        $query = $query->result_array();

        return $query;
    }

    public function get_produto_cashback_pedido($data) {
		$query = $this->db->query('SELECT * 
									FROM 
										App_Produto 
									WHERE 
										idApp_OrcaTrata = ' . $data . ' 
								');
        $query = $query->result_array();

        return $query;
    }
			
    public function get_tab_produtos($data) {
		$query = $this->db->query('SELECT * FROM Tab_Produtos WHERE idTab_Produtos = ' . $data . '');
        $query = $query->result_array();

        return $query[0];
    }

    public function get_produto_alterar($data) {
		$query = $this->db->query('
			SELECT 
				TAP.idApp_Produto
			FROM 
				App_Produto AS TAP
			WHERE 
				TAP.idApp_OrcaTrata = ' . $data . ' 
		');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_produtodesp($data) {
		$query = $this->db->query('
			SELECT
				TAP.idApp_Produto,
				TAP.idSis_Empresa,
				TAP.idTab_Modulo,
				TAP.idApp_OrcaTrata,
				TAP.idApp_Cliente,
				TAP.idApp_Fornecedor,
				TAP.idSis_Usuario,
				TAP.idTab_Produto,
				TAP.idTab_Valor_Produto,
				TAP.idTab_Produtos_Produto,
				TAP.Prod_Serv_Produto,
				TAP.NomeProduto,
				TAP.ValorProduto,
				TAP.QtdProduto,
				TAP.QtdIncrementoProduto,
				(TAP.QtdProduto * TAP.QtdIncrementoProduto) AS SubTotalQtd,
				TAP.ValorCompraProduto,
				TAP.QtdCompraProduto,
				TAP.ObsProduto,
				TAP.DataValidadeProduto,
				TAP.DataConcluidoProduto,
				TAP.HoraConcluidoProduto,
				TAP.HoraValidadeProduto,
				TAP.ConcluidoProduto,
				TAP.DevolvidoProduto,
				TAP.CanceladoProduto,
				TAP.idTab_TipoRD,
				TAP.itens_pedido_valor_total,
				TAP.ComissaoProduto,
				TAP.ComissaoServicoProduto,
				TAP.ComissaoCashBackProduto,
				TAP.PrazoProduto,
				TAP.StatusComissaoPedido,
				TAP.Aux_App_Produto_1,
				TAP.Aux_App_Produto_2,
				TAP.Aux_App_Produto_3,
				TAP.Aux_App_Produto_4,
				TAP.Aux_App_Produto_5,
				P.Nome_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ",  IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,"")) AS Produto,
				(TAP.QtdProduto * TAP.ValorProduto) AS Subtotal_Produto
			FROM 
				App_Produto AS TAP
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = TAP.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2 
			WHERE 
				TAP.idApp_OrcaTrata = ' . $data . ' AND
				TAP.Prod_Serv_Produto = "P" 
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_parcelas_alterar($data) {
		$query = $this->db->query('
			SELECT 
				TAP.idApp_Parcelas
			FROM 
				App_Parcelas AS TAP
			WHERE 
				TAP.idApp_OrcaTrata = ' . $data . ' 
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_parcelas($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_parcela($data) {
        $query = $this->db->query(
			' SELECT
				* 
			FROM 
				App_Parcelas 
			WHERE 
				idApp_Parcelas = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '' 
		);
		
        //$query = $query->result_array();
        //return $query[0];

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
    }
	
    public function get_parcelas_orcamento($data) {
		$query = $this->db->query('SELECT idApp_Parcelas, DataVencimento FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data . '');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_produtos_orcamento($data) {
		$query = $this->db->query('SELECT idApp_Produto, DataConcluidoProduto, HoraConcluidoProduto  FROM App_Produto WHERE idApp_OrcaTrata = ' . $data . '');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_parcelas_posterior($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data . ' AND Quitado = "N"');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_parcelas_posterior_sim($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data . ' AND Quitado = "S"');
        $query = $query->result_array();

        return $query;
    }	

    public function get_parcelas_baixa($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

	public function get_alterarorcamentos($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
				'(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim2']) {
            $consulta2 =
				'(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '")';
        }
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim3']) {
            $consulta3 =
				'(OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '")';
        }
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;
			
		$date_inicio_entrega_prd = ($_SESSION['FiltroAlteraParcela']['DataInicio5']) ? 'PRDS.DataConcluidoProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio5'] . '" AND ' : FALSE;
		$date_fim_entrega_prd = ($_SESSION['FiltroAlteraParcela']['DataFim5']) ? 'PRDS.DataConcluidoProduto <= "' . $_SESSION['FiltroAlteraParcela']['DataFim5'] . '" AND ' : FALSE;

		$hora_inicio_entrega_prd = ($_SESSION['FiltroAlteraParcela']['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $_SESSION['FiltroAlteraParcela']['HoraInicio5'] . '" AND ' : FALSE;
		$hora_fim_entrega_prd = ($_SESSION['FiltroAlteraParcela']['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $_SESSION['FiltroAlteraParcela']['HoraFim5'] . '" AND ' : FALSE;
				
		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		if(isset($_SESSION['FiltroAlteraParcela']['Quitado']) && $_SESSION['FiltroAlteraParcela']['Quitado'] == "S"){
			$dataref = 'PR.DataPago';
		}else{
			$dataref = 'PR.DataVencimento';
		}
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? ''.$dataref.' >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? ''.$dataref.' <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;
		
		if($_SESSION['FiltroAlteraParcela']['nome']){
			if($_SESSION['FiltroAlteraParcela']['nome'] == "Cliente"){
				$cadastro = "C.DataCadastroCliente";
				$aniversario = "C.DataNascimento";
			}elseif($_SESSION['FiltroAlteraParcela']['nome'] == "Fornecedor"){
				$cadastro = "F.DataCadastroFornecedor";
				$aniversario = "F.DataNascimento";
			}
		}else{
			echo "Não existe data de cadastro";
		}
			
		$date_inicio_cadastro = ($_SESSION['FiltroAlteraParcela']['DataInicio6']) ? '' . $cadastro . ' >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio6'] . '" AND ' : FALSE;
		$date_fim_cadastro = ($_SESSION['FiltroAlteraParcela']['DataFim6']) ? '' . $cadastro . ' <= "' . $_SESSION['FiltroAlteraParcela']['DataFim6'] . '" AND ' : FALSE;
			
		$DiaAniv = ($_SESSION['FiltroAlteraParcela']['DiaAniv']) ? ' AND DAY(' . $aniversario . ') = ' . $_SESSION['FiltroAlteraParcela']['DiaAniv'] : FALSE;
		$MesAniv = ($_SESSION['FiltroAlteraParcela']['MesAniv']) ? ' AND MONTH(' . $aniversario . ') = ' . $_SESSION['FiltroAlteraParcela']['MesAniv'] : FALSE;
		$AnoAniv = ($_SESSION['FiltroAlteraParcela']['AnoAniv']) ? ' AND YEAR(' . $aniversario . ') = ' . $_SESSION['FiltroAlteraParcela']['AnoAniv'] : FALSE;			
			
		if(isset($_SESSION['FiltroAlteraParcela']['Associado'])){
			if($_SESSION['FiltroAlteraParcela']['Associado'] == 0){
				$associado = ' AND OT.Associado = 0 ';
			}else{
				$associado = ' AND OT.Associado != 0 ';
			}
		}else{
			$associado = FALSE;
		}
		
		if(isset($_SESSION['FiltroAlteraParcela']['Vendedor'])){
			if($_SESSION['FiltroAlteraParcela']['Vendedor'] == 0){
				$vendedor = ' AND OT.idSis_Usuario = 0 ';
			}else{
				$vendedor = ' AND OT.idSis_Usuario != 0 ';
			}
		}else{
			$vendedor = FALSE;
		}			
		
		$permissao30 = ($_SESSION['FiltroAlteraParcela']['Orcamento'] != "" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '" AND ' : FALSE;
		$permissao31 = ($_SESSION['FiltroAlteraParcela']['Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['Cliente'] . '" AND ' : FALSE;
		$permissao36 = ($_SESSION['FiltroAlteraParcela']['Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] . '" AND ' : FALSE;
		$permissao37 = ($_SESSION['FiltroAlteraParcela']['idApp_Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] . '" AND ' : FALSE;
		$permissao38 = ($_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] . '" AND ' : FALSE;
		$permissao13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete'] != "0" ) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		//$permissao4 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;

		$permissao10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] != "0" ) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$permissao11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca'] != "0" ) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
		
		//$permissao10 = 'OT.FinalizadoOrca = "N" AND ';
		//$permissao11 = 'OT.CanceladoOrca = "N" AND ';

		$permissao5 = ($_SESSION['FiltroAlteraParcela']['Modalidade'] != "0" ) ? 'OT.Modalidade = "' . $_SESSION['FiltroAlteraParcela']['Modalidade'] . '" AND ' : FALSE;
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca'] != "0" ) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao33 = ($_SESSION['FiltroAlteraParcela']['AVAP'] != "0" ) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$permissao34 = ($_SESSION['FiltroAlteraParcela']['TipoFrete'] != "0" ) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$permissao32 = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] != "0" ) ? 'OT.TipoFinanceiro = "' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] . '" AND ' : FALSE;
		$permissao35 = ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] != "" ) ? 'OT.idTab_TipoRD = "' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . '" AND ' : FALSE;
		
		//$permissao26 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		//$permissao27 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao25 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		
		$permissao17 = ($_SESSION['FiltroAlteraParcela']['NomeUsuario'] != "0" ) ? 'OT.idSis_Usuario = "' . $_SESSION['FiltroAlteraParcela']['NomeUsuario'] . '" AND ' : FALSE;
		$permissao18 = ($_SESSION['FiltroAlteraParcela']['NomeAssociado'] != "" ) ? 'OT.Associado = "' . $_SESSION['FiltroAlteraParcela']['NomeAssociado'] . '" AND ' : FALSE;
		$permissao12 = ($_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] != "0" ) ? 'OT.StatusComissaoOrca = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] . '" AND ' : FALSE;
		$permissao14 = ($_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] != "0" ) ? 'OT.StatusComissaoOrca_Online = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] . '" AND ' : FALSE;
		
		$permissao60 = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'OT.idApp_OrcaTrata' : $_SESSION['FiltroAlteraParcela']['Campo'];
        $permissao61 = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
		
		$produtos = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['Produtos'] != "0") ? 'PRDS.idSis_Empresa ' . $_SESSION['FiltroAlteraParcela']['Produtos'] . ' AND' : FALSE;
		$parcelas = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['Parcelas'] != "0") ? 'PR.idSis_Empresa ' . $_SESSION['FiltroAlteraParcela']['Parcelas'] . ' AND' : FALSE;
	
        if ($limit){
			$querylimit = 'LIMIT ' . $start . ', ' . $limit;
		}else{
			$querylimit = '';
		}

		$query = $this->db->query('
			SELECT
				C.idApp_Cliente,
				C.NomeCliente,
				C.DataCadastroCliente,
				C.DataNascimento,
				F.idApp_Fornecedor,
				F.NomeFornecedor,
				F.DataCadastroFornecedor,
				F.DataNascimento,
				OT.idSis_Empresa,
				OT.idApp_OrcaTrata,
				OT.CombinadoFrete,
				OT.AprovadoOrca,
				OT.ConcluidoOrca,
				OT.QuitadoOrca,
				OT.CanceladoOrca,
				OT.FinalizadoOrca,
				OT.DataOrca,
				OT.idApp_Cliente,
				OT.idApp_Fornecedor,
				OT.ValorFinalOrca,
				OT.DataEntregaOrca,
				OT.HoraEntregaOrca,
				OT.idSis_Usuario,
				OT.TipoFinanceiro,
				OT.Tipo_Orca,
				OT.FormaPagamento,
				OT.Associado,
				OT.idTab_TipoRD,
				TTF.TipoFrete,
				FP.FormaPag,				
				EF.NomeEmpresa,
				MO.AVAP,
				MO.Abrev2,
				OT.Modalidade,
				TP.TipoFinanceiro,
				US.Nome AS NomeColaborador,
				USA.Nome AS NomeAssociado
			FROM
				App_OrcaTrata AS OT
				LEFT JOIN Sis_Empresa AS EF ON EF.idSis_Empresa = OT.idSis_Empresa
				LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TP ON TP.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_AVAP AS MO ON MO.Abrev2 = OT.AVAP
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
				LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
				LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
				LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
				LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
				LEFT JOIN Sis_Usuario AS USA ON USA.idSis_Usuario = OT.Associado
				LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
			WHERE
				' . $permissao . '
				' . $permissao_orcam . '
				' . $permissao30 . '
				' . $permissao31 . '
				' . $permissao13 . '
				' . $permissao1 . '
				' . $permissao3 . '
				' . $permissao2 . '
				' . $permissao10 . '
				' . $permissao11 . '
				' . $permissao12 . '
				' . $permissao14 . '
				' . $permissao6 . '
				' . $permissao5 . '
				' . $permissao7 . '
				' . $permissao32 . '
				' . $permissao33 . '
				' . $permissao34 . '
				' . $permissao17 . '
				' . $permissao18 . '
				' . $permissao35 . '
				' . $permissao36 . '
				' . $permissao37 . '
				' . $permissao38 . '
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
                ' . $date_inicio_cadastro . '
                ' . $date_fim_cadastro . '
				' . $produtos . '
				' . $parcelas . '
				OT.FinalizadoOrca = "N" AND 
				OT.CanceladoOrca = "N" AND			
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				' . $associado . '
				' . $vendedor . '
				' . $DiaAniv . '
				' . $MesAniv . '
				' . $AnoAniv . '
			GROUP BY
				OT.idApp_OrcaTrata	
			ORDER BY
				' . $permissao60 . '
				' . $permissao61 . '
			' . $querylimit . '
		');		
	
		if($total == TRUE) {
			//return $query->num_rows();
			
			$somafinal2=0;
			//$somacomissao2=0;
			
			foreach ($query->result() as $row) {
				
				$somafinal2 += $row->ValorFinalOrca;
				//$somacomissao2 += $row->ValorComissao;
				
			}
			
			$query->soma2 = new stdClass();
			
			$query->soma2->somafinal2 = number_format($somafinal2, 2, ',', '.');
			//$query->soma2->somacomissao2 = number_format($somacomissao2, 2, ',', '.');
			
			return $query;
		}	

		$query = $query->result_array();
        return $query;

    }
	
    public function get_alterarparcela($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		if($data){

			$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
			
			$date_inicio_entrega = ($data['DataInicio2']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_entrega = ($data['DataFim2']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim2'] . '" AND ' : FALSE;

			$hora_inicio_entrega_prd = ($data['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $data['HoraInicio5'] . '" AND ' : FALSE;
			$hora_fim_entrega_prd = ($data['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $data['HoraFim5'] . '" AND ' : FALSE;
										
			$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
			
			$date_inicio_vnc_prc = ($data['DataInicio4']) ? 'PR.DataVencimento >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
			$date_fim_vnc_prc = ($data['DataFim4']) ? 'PR.DataVencimento <= "' . $data['DataFim4'] . '" AND ' : FALSE;
			
			$date_inicio_pag_prc = ($data['DataInicio5']) ? 'PR.DataPago >= "' . $data['DataInicio5'] . '" AND ' : FALSE;
			$date_fim_pag_prc = ($data['DataFim5']) ? 'PR.DataPago <= "' . $data['DataFim5'] . '" AND ' : FALSE;
		
			$date_inicio_lan_prc = ($data['DataInicio8']) ? 'PR.DataLanc >= "' . $data['DataInicio8'] . '" AND ' : FALSE;
			$date_fim_lan_prc = ($data['DataFim8']) ? 'PR.DataLanc <= "' . $data['DataFim8'] . '" AND ' : FALSE;
			
			$date_inicio_cadastro = ($data['DataInicio6']) ? 'C.DataCadastroCliente >= "' . $data['DataInicio6'] . '" AND ' : FALSE;
			$date_fim_cadastro = ($data['DataFim6']) ? 'C.DataCadastroCliente <= "' . $data['DataFim6'] . '" AND ' : FALSE;
			
			$orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
			$cliente = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
			$id_cliente = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
			$tipofinanceiro = ($data['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
			$tipord = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] . ' AND PR.idTab_TipoRD = ' . $data['idTab_TipoRD'] : FALSE;
			$campo = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
			$ordenamento = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
			$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
			$filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
			$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
			$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
			$filtro14 = ($data['ConcluidoProduto']) ? 'PRDS.ConcluidoProduto = "' . $data['ConcluidoProduto'] . '" AND ' : FALSE;
			$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
			$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
			$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
			$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
			$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
			$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
			$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
			$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
			$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
			
			if($_SESSION['log']['idSis_Empresa'] != 5){
				$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
			}else{
				$permissao_orcam = FALSE;
			}
			
			$groupby = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['Agrupar'] != "0") ? 'GROUP BY ' . $data['Agrupar'] . '' : 'GROUP BY PR.idApp_Parcelas';
			
			$produtos = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['Produtos'] != "0") ? 'PRDS.idSis_Empresa ' . $data['Produtos'] . '  AND' : FALSE;

		}
		/*	  
		echo "<pre>";
		echo "<br>";
		print_r($produtos);
		echo "<br>";
		print_r($groupby);
		echo "</pre>";
		*/	        
		if ($limit){
			$querylimit = 'LIMIT ' . $start . ', ' . $limit;
		}else{
			$querylimit = '';
		}
	
		if($total == TRUE) {
		   $query_total = $this->db->query('
				SELECT
					PR.ValorParcela
				FROM
					App_OrcaTrata AS OT
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
						LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
						LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
						LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
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
					' . $date_inicio_pag_prc . '
					' . $date_fim_pag_prc . '
					' . $date_inicio_lan_prc . '
					' . $date_fim_lan_prc . '
					' . $date_inicio_cadastro . '
					' . $date_fim_cadastro . '
					OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					' . $permissao . '
					' . $permissao_orcam . '
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
					PR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
					' . $orcamento . '
					' . $cliente . '
					' . $id_cliente . '
					' . $tipofinanceiro . '
					' . $tipord . '
				' . $groupby . '
				ORDER BY
					' . $campo . '
					' . $ordenamento . '
				' . $querylimit . '
			');
		
			$count = $query_total->num_rows();
			
			if(!isset($count)){
				return FALSE;
			}else{
				if($count >= 12001){
					return FALSE;
				}else{
					return $query_total->num_rows();
				}
			}
		}

        ####################################################################
        #SOMATÓRIO DAS Parcelas A Receber
		$query = $this->db->query('
            SELECT
				C.NomeCliente,
                C.CelularCliente,
                C.Telefone,
                C.Telefone2,
                C.Telefone3,
				C.DataCadastroCliente,
				C.EnderecoCliente,
				C.NumeroCliente,
				C.ComplementoCliente,
				C.BairroCliente,
				C.CidadeCliente,
				C.EstadoCliente,
				C.ReferenciaCliente,
				OT.idApp_OrcaTrata,
				OT.idApp_Cliente,
				OT.Tipo_Orca,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
                OT.CombinadoFrete,
				CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntregaOrca,
                OT.DataVencimentoOrca,
				OT.ValorFinalOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.Modalidade,
				OT.AVAP,
				OT.TipoFrete,
				OT.NomeRec,
				OT.ParentescoRec,
				OT.FormaPagamento,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TR.TipoFinanceiro,""), "--", IFNULL(C.idApp_Cliente,""), "--", IFNULL(C.NomeCliente,""), "--", IFNULL(OT.Descricao,"")) AS Receita,
				TR.TipoFinanceiro,
                PR.idApp_Parcelas,
                PR.idSis_Empresa,
				PR.idSis_Usuario,
				PR.idApp_Cliente,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.DataLanc,
                PR.ValorPago,
                PR.Quitado,
				PR.idTab_TipoRD,
				PR.FormaPagamentoParcela,
				PRDS.DataConcluidoProduto,
				PRDS.ConcluidoProduto,
				TFP.FormaPag
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
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
                ' . $date_inicio_pag_prc . '
                ' . $date_fim_pag_prc . '
                ' . $date_inicio_lan_prc . '
                ' . $date_fim_lan_prc . '
                ' . $date_inicio_cadastro . '
                ' . $date_fim_cadastro . '
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao . '
				' . $permissao_orcam . '
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
                PR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				PR.Quitado = "N"  
                ' . $orcamento . '
                ' . $cliente . '
                ' . $id_cliente . '
				' . $tipofinanceiro . '
				' . $tipord . '
			' . $groupby . '
			ORDER BY
				' . $campo . '
				' . $ordenamento . '
			' . $querylimit . '
		');
		
        $query = $query->result_array();
        return $query;

		
    }	
	
    public function get_alterarparceladesp($data) {

        if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND OT.DataOrca  <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
		}
        else {
            $consulta =
                '(OT.DataOrca  >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }

        if ($_SESSION['FiltroAlteraParcela']['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca  >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '")';
        }
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;
		
		$permissao30 = ($_SESSION['FiltroAlteraParcela']['Orcamento'] != "" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '" AND ' : FALSE;
		$permissao31 = ($_SESSION['FiltroAlteraParcela']['Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] . '" AND ' : FALSE;
		$permissao37 = ($_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] . '" AND ' : FALSE;
		$permissao13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete'] != "0" ) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] != "0" ) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$permissao11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca'] != "0" ) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
		
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca'] != "0" ) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao33 = ($_SESSION['FiltroAlteraParcela']['AVAP'] != "0" ) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$permissao34 = ($_SESSION['FiltroAlteraParcela']['TipoFrete'] != "0" ) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraParcela']['Modalidade'] != "0" ) ? 'OT.Modalidade = "' . $_SESSION['FiltroAlteraParcela']['Modalidade'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		//$permissao32 = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiroD'] != "0" ) ? 'OT.TipoFinanceiro = "' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiroD'] . '" AND ' : FALSE;
		
		$permissao26 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao27 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao25 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		//$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeFornecedor'] != "0" )) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['NomeFornecedor'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeFornecedor,
				OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.Descricao,
				OT.TipoFinanceiro,
				OT.AprovadoOrca,
				OT.ConcluidoOrca,
				OT.QuitadoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.CombinadoFrete,
				OT.AVAP,
				OT.TipoFrete,
				OT.Modalidade,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				TR.TipoFinanceiro,
				
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idApp_Parcelas,
				PR.Parcela,
				PR.idApp_OrcaTrata,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TR.TipoFinanceiro,""), "--", IFNULL(C.NomeFornecedor,""), "--", IFNULL(OT.Descricao,"")) AS Despesa,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.ValorPago,
				PR.DataPago,
				PR.Quitado				
			FROM 
				App_Parcelas AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					WHERE 
				' . $permissao . '
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_prc . '
                ' . $date_fim_vnc_prc . '
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "1" AND
				
				PR.idSis_Empresa = ' . $data . ' AND		
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao4 . '
				' . $permissao5 . '
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao10 . '
				' . $permissao11 . '
				' . $permissao13 . '
				' . $permissao30 . '
				' . $permissao31 . '
				' . $permissao33 . '
				' . $permissao34 . '
				PR.idTab_TipoRD = "1"
			ORDER BY
				C.NomeFornecedor ASC,
				PR.DataVencimento  
		');
        $query = $query->result_array();
          
        return $query;
    }	

	public function get_alterarparceladespfiado($data) {

		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcades'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcades'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeFornecedor'] != "0" )) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['NomeFornecedor'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeFornecedor,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.TipoFinanceiro,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				TD.TipoFinanceiro,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "-", IFNULL(OT.Descricao,"")) AS idApp_OrcaTrata,
				E.NomeEmpresa,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idSis_Usuario,
				PR.idApp_Parcelas,
				PR.Parcela,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TD.TipoFinanceiro,""), "--", IFNULL(C.NomeFornecedor,""), "--", IFNULL(OT.Descricao,"")) AS Despesa,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.ValorPago,
				PR.DataPago,
				PR.Quitado
			FROM
				App_Parcelas AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
			WHERE
				' . $permissao . '
				' . $permissao5 . '				
				OT.idSis_Empresa = ' . $data . ' AND
				OT.AprovadoOrca = "S" AND
				PR.idSis_Empresa = ' . $data . ' AND			
				PR.idTab_TipoRD = "1" AND
				PR.idTab_TipoRD = "1" AND
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"				
			ORDER BY
				C.NomeFornecedor,
				PR.DataVencimento
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_alterarparcelarecfiado($data) {
		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeCliente'] != "0" )) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeCliente,
				OT.idApp_OrcaTrata,
				OT.Descricao,
				OT.TipoFinanceiro,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,				
				TR.TipoFinanceiro,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "-", IFNULL(OT.Descricao,"")) AS idApp_OrcaTrata,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idApp_Parcelas,
				PR.Parcela,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TR.TipoFinanceiro,""), "--", IFNULL(C.NomeCliente,""), "--", IFNULL(OT.Descricao,"")) AS Receita,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.ValorPago,
				PR.DataPago,
				PR.Quitado
			FROM 
				App_Parcelas AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
			WHERE 
				' . $permissao . '
				' . $permissao5 . '					
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "2" AND				
				OT.AprovadoOrca = "S" AND

				PR.idSis_Empresa = ' . $data . ' AND
				PR.idTab_TipoRD = "2" AND			
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
			ORDER BY
				C.NomeCliente,
				PR.DataVencimento
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_alterarproduto($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		$date_inicio_orca = ($_SESSION['Filtro_Vendidos']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['Filtro_Vendidos']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['Filtro_Vendidos']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['Filtro_Vendidos']['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($_SESSION['Filtro_Vendidos']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['Filtro_Vendidos']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['Filtro_Vendidos']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['Filtro_Vendidos']['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_vnc = ($_SESSION['Filtro_Vendidos']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['Filtro_Vendidos']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['Filtro_Vendidos']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['Filtro_Vendidos']['DataFim3'] . '" AND ' : FALSE;
			
		$date_inicio_vnc_par = ($_SESSION['Filtro_Vendidos']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['Filtro_Vendidos']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_par = ($_SESSION['Filtro_Vendidos']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['Filtro_Vendidos']['DataFim4'] . '" AND ' : FALSE;

		$date_inicio_prd_entr = ($_SESSION['Filtro_Vendidos']['DataInicio8']) ? 'PRDS.DataConcluidoProduto >= "' . $_SESSION['Filtro_Vendidos']['DataInicio8'] . '" AND ' : FALSE;
		$date_fim_prd_entr = ($_SESSION['Filtro_Vendidos']['DataFim8']) ? 'PRDS.DataConcluidoProduto <= "' . $_SESSION['Filtro_Vendidos']['DataFim8'] . '" AND ' : FALSE;

		$hora_inicio_entrega_prd = ($_SESSION['Filtro_Vendidos']['HoraInicio8']) ? 'PRDS.HoraConcluidoProduto >= "' . $_SESSION['Filtro_Vendidos']['HoraInicio8'] . '" AND ' : FALSE;
		$hora_fim_entrega_prd = ($_SESSION['Filtro_Vendidos']['HoraFim8']) ? 'PRDS.HoraConcluidoProduto <= "' . $_SESSION['Filtro_Vendidos']['HoraFim8'] . '" AND ' : FALSE;
					
		$filtro['Orcamento'] = ($_SESSION['Filtro_Vendidos']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['Filtro_Vendidos']['Orcamento'] : FALSE;
		$filtro['Cliente'] = ($_SESSION['Filtro_Vendidos']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['Filtro_Vendidos']['Cliente'] : FALSE;
		$filtro['idApp_Cliente'] = ($_SESSION['Filtro_Vendidos']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['Filtro_Vendidos']['idApp_Cliente'] : FALSE;
		$filtro['Fornecedor'] = ($_SESSION['Filtro_Vendidos']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['Filtro_Vendidos']['Fornecedor'] : FALSE;
		$filtro['idApp_Fornecedor'] = ($_SESSION['Filtro_Vendidos']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['Filtro_Vendidos']['idApp_Fornecedor'] : FALSE;
		$filtro['Produtos'] = ($_SESSION['Filtro_Vendidos']['Produtos']) ? ' AND PRDS.idTab_Produtos_Produto = ' . $_SESSION['Filtro_Vendidos']['Produtos'] : FALSE;
		$filtro['Categoria'] = ($_SESSION['Filtro_Vendidos']['Categoria']) ? ' AND TCAT.idTab_Catprod = ' . $_SESSION['Filtro_Vendidos']['Categoria'] : FALSE;
		$filtro['TipoFinanceiro'] = ($_SESSION['Filtro_Vendidos']['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['Filtro_Vendidos']['TipoFinanceiro'] : FALSE;
		$filtro['idTab_TipoRD'] = ($_SESSION['Filtro_Vendidos']['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $_SESSION['Filtro_Vendidos']['idTab_TipoRD'] . ' AND PRDS.idTab_TipoRD = ' . $_SESSION['Filtro_Vendidos']['idTab_TipoRD'] : FALSE;
		//$filtro['ObsOrca'] = ($_SESSION['Filtro_Vendidos']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['Filtro_Vendidos']['ObsOrca'] : FALSE;
		$filtro['Orcarec'] = ($_SESSION['Filtro_Vendidos']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['Filtro_Vendidos']['Orcarec'] : FALSE;
		$filtro['Campo'] = (!$_SESSION['Filtro_Vendidos']['Campo']) ? 'TCAT.Catprod' : $_SESSION['Filtro_Vendidos']['Campo'];
		$filtro['Ordenamento'] = (!$_SESSION['Filtro_Vendidos']['Ordenamento']) ? 'ASC' : $_SESSION['Filtro_Vendidos']['Ordenamento'];
		$filtro1 = ($_SESSION['Filtro_Vendidos']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['Filtro_Vendidos']['AprovadoOrca'] . '" AND ' : FALSE;
		$filtro2 = ($_SESSION['Filtro_Vendidos']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['Filtro_Vendidos']['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($_SESSION['Filtro_Vendidos']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['Filtro_Vendidos']['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro17 = ($_SESSION['Filtro_Vendidos']['ConcluidoProduto']) ? 'PRDS.ConcluidoProduto = "' . $_SESSION['Filtro_Vendidos']['ConcluidoProduto'] . '" AND ' : FALSE;
		$filtro18 = ($_SESSION['Filtro_Vendidos']['Prod_Serv_Produto']) ? 'PRDS.Prod_Serv_Produto = "' . $_SESSION['Filtro_Vendidos']['Prod_Serv_Produto'] . '" AND ' : FALSE;
		$filtro5 = ($_SESSION['Filtro_Vendidos']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['Filtro_Vendidos']['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($_SESSION['Filtro_Vendidos']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['Filtro_Vendidos']['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($_SESSION['Filtro_Vendidos']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['Filtro_Vendidos']['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($_SESSION['Filtro_Vendidos']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['Filtro_Vendidos']['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($_SESSION['Filtro_Vendidos']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['Filtro_Vendidos']['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($_SESSION['Filtro_Vendidos']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['Filtro_Vendidos']['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($_SESSION['Filtro_Vendidos']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['Filtro_Vendidos']['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($_SESSION['Filtro_Vendidos']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['Filtro_Vendidos']['CombinadoFrete'] . '" AND ' : FALSE;
		
		$query4 = ($_SESSION['Filtro_Vendidos']['idApp_ClientePet'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClientePet'])) ? 'AND OT.idApp_ClientePet = ' . $_SESSION['Filtro_Vendidos']['idApp_ClientePet'] . '  ' : FALSE;
		$query42 = ($_SESSION['Filtro_Vendidos']['idApp_ClientePet2'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClientePet2'])) ? 'AND OT.idApp_ClientePet = ' . $_SESSION['Filtro_Vendidos']['idApp_ClientePet2'] . '  ' : FALSE;
		$query5 = ($_SESSION['Filtro_Vendidos']['idApp_ClienteDep'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClienteDep'])) ? 'AND OT.idApp_ClienteDep = ' . $_SESSION['Filtro_Vendidos']['idApp_ClienteDep'] . '  ' : FALSE;
		$query52 = ($_SESSION['Filtro_Vendidos']['idApp_ClienteDep2'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClienteDep2'])) ? 'AND OT.idApp_ClienteDep = ' . $_SESSION['Filtro_Vendidos']['idApp_ClienteDep2'] . '  ' : FALSE;			
			
		$parcelas = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Filtro_Vendidos']['Parcelas'] != "0") ? 'PR.idSis_Empresa ' . $_SESSION['Filtro_Vendidos']['Parcelas'] . ' AND' : FALSE;
								
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$groupby = (1 == 1) ? 'GROUP BY PRDS.idApp_Produto' : FALSE;		
		
        if ($limit){
			$querylimit = 'LIMIT ' . $start . ', ' . $limit;
		}else{
			$querylimit = '';
		}
					
		$query = $this->db->query('
            SELECT
				CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
                C.idApp_Cliente,
				C.CelularCliente,
				CONCAT(IFNULL(F.NomeFornecedor,"")) AS NomeFornecedor,
				F.idApp_Fornecedor,
				F.CelularFornecedor,
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
				CPT.NomeClientePet,
				CDP.NomeClienteDep,
				TR.TipoFinanceiro,
				MD.Modalidade,
				PRDS.*,
				(PRDS.QtdProduto * PRDS.QtdIncrementoProduto) AS QuantidadeProduto,
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
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
					LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
					LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
					LEFT JOIN Tab_AVAP AS TAV ON TAV.Abrev2 = OT.AVAP
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
            WHERE
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_prd_entr . '
                ' . $date_fim_prd_entr . '
                ' . $hora_inicio_entrega_prd . '
                ' . $hora_fim_entrega_prd . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_par . '
                ' . $date_fim_vnc_par . '
				' . $permissao . '
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
				' . $filtro18 . '
				' . $parcelas . '
                OT.idSis_Empresa = ' . $data . ' AND
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.CanceladoOrca = "N" AND
                PRDS.idSis_Empresa = ' . $data . ' 
                ' . $filtro['Orcamento'] . '
                ' . $filtro['Cliente'] . '
                ' . $filtro['Fornecedor'] . '
                ' . $filtro['idApp_Cliente'] . '
                ' . $filtro['idApp_Fornecedor'] . '
				' . $filtro['TipoFinanceiro'] . '
				' . $filtro['idTab_TipoRD'] . '
                ' . $filtro['Produtos'] . '
                ' . $filtro['Categoria'] . '
				' . $query4 . '
				' . $query42 . '
				' . $query5 . '
				' . $query52 . '
			' . $groupby . '
			ORDER BY
				' . $filtro['Campo'] . '
				' . $filtro['Ordenamento'] . '
			' . $querylimit . '
		');

		if($total == TRUE) {
			return $query->num_rows();
		}

		foreach ($query->result() as $row) {
			$row->NomeCliente = (strlen($row->NomeCliente) > 12) ? substr($row->NomeCliente, 0, 12) : $row->NomeCliente;
			$row->NomeClientePet = (strlen($row->NomeClientePet) > 12) ? substr($row->NomeClientePet, 0, 12) : $row->NomeClientePet;
			$row->NomeClienteDep = (strlen($row->NomeClienteDep) > 12) ? substr($row->NomeClienteDep, 0, 12) : $row->NomeClienteDep;
		}
						
        $query = $query->result_array();

        return $query;
    }	

    public function get_alterarservicorec($data) {
		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataValidadeServico) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['ConcluidoServico'] != "0" ) ? 'PR.ConcluidoServico = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoServico'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataValidadeServico) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataValidadeServico) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeCliente'] != "0" )) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeCliente,
				OT.idApp_OrcaTrata,
				OT.Descricao,
				OT.TipoFinanceiro,
				TR.TipoFinanceiro,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				CONCAT(OT.idApp_OrcaTrata,"-",C.NomeCliente) AS Servico,
				PR.idTab_Servico,
				PR.idApp_Servico,
				PR.DataValidadeServico,
				PR.ValorServico,
				PR.ConcluidoServico,
				PR.QtdServico,
				PR.ObsServico,
				TP.Produtos
			FROM 
				App_Servico AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = PR.idTab_Servico
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Produto
			WHERE 
				' . $permissao . '
				' . $permissao5 . '
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "2" AND				
				OT.AprovadoOrca = "S" AND				
				PR.idSis_Empresa = ' . $data . ' AND
				
				PR.idTab_TipoRD = "4" 
			ORDER BY
				C.NomeCliente,
				PR.DataValidadeServico  
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_alterarprodutorec($data) {

        if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
                '(PR.DataValidadeProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND PR.DataValidadeProduto <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataValidadeProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataValidadeProduto) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Produtos'] != "0" ) ? 'TP.idTab_Produto = "' . $_SESSION['FiltroAlteraParcela']['Produtos'] . '" AND ' : FALSE;		
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] != "0" ) ? 'PR.ConcluidoProduto = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] != "0" ) ? 'PR.DevolvidoProduto = "' . $_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] . '" AND ' : FALSE;
		$permissao8 = ($_SESSION['FiltroAlteraParcela']['Dia'] != "0" ) ? 'DAY(PR.DataValidadeProduto) = "' . $_SESSION['FiltroAlteraParcela']['Dia'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataValidadeProduto) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataValidadeProduto) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeCliente'] != "0" )) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] . '" AND ' : FALSE;
			/*
              echo "<pre>";
              print_r($_SESSION['FiltroAlteraParcela']['Produtos']);
			  echo "<br>";
			  print_r($_SESSION['FiltroAlteraParcela']['ConcluidoProduto']);
			  echo "<br>";
			  print_r($_SESSION['FiltroAlteraParcela']['DevolvidoProduto']);			  
              echo "</pre>";
              exit();
			*/
		$query = $this->db->query('
			SELECT
				C.NomeCliente,
				OT.idApp_OrcaTrata,
				OT.Descricao,
				OT.TipoFinanceiro,
				TR.TipoFinanceiro,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				CONCAT(OT.idApp_OrcaTrata,"-",C.NomeCliente) AS Produto,
				PR.idTab_Produto,
				PR.idApp_Produto,
				PR.DataValidadeProduto,
				PR.ValorProduto,
				PR.ConcluidoProduto,
				PR.DevolvidoProduto,
				PR.QtdProduto,
				PR.ObsProduto,
				TP.Produtos
			FROM 
				App_Produto AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = PR.idTab_Produto
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Produto					
			WHERE 
				' . $permissao . '
				' . $permissao5 . '
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao6 . '
				' . $permissao4 . '
				' . $permissao7 . '
				' . $permissao8 . '
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "2" AND				
				OT.AprovadoOrca = "S" AND				
				PR.idSis_Empresa = ' . $data . ' AND
				' . $consulta . ' AND
				PR.idTab_TipoRD = "2" 
			ORDER BY
				PR.DataValidadeProduto  DESC,
				C.NomeCliente
				
		');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_alterarservicodesp($data) {
		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataValidadeServico) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['ConcluidoServico'] != "0" ) ? 'PR.ConcluidoServico = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoServico'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataValidadeServico) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataValidadeServico) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcades'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcades'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeFornecedor'] != "0" )) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['NomeFornecedor'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeFornecedor,
				OT.idApp_OrcaTrata,
				OT.Descricao,
				OT.TipoFinanceiro,
				TR.TipoFinanceiro,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				CONCAT(OT.idApp_OrcaTrata,"-",C.NomeFornecedor) AS Servico,
				PR.idTab_Servico,
				PR.idApp_Servico,
				PR.DataValidadeServico,
				PR.ValorServico,
				PR.ConcluidoServico,
				PR.QtdServico,
				PR.ObsServico,
				TP.Produtos
			FROM 
				App_Servico AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = PR.idTab_Servico
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Produto
			WHERE 
				' . $permissao . '
				' . $permissao5 . '
				' . $permissao1 . '				
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "1" AND				
				OT.AprovadoOrca = "S" AND				
				PR.idSis_Empresa = ' . $data . ' AND
				
				PR.idTab_TipoRD = "3" 
			ORDER BY
				C.NomeFornecedor,
				PR.DataValidadeServico  
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_alterarprodutodesp($data) {

        if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
                '(PR.DataValidadeProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND PR.DataValidadeProduto <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataValidadeProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataValidadeProduto) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Produtos'] != "0" ) ? 'TP.idTab_Produto = "' . $_SESSION['FiltroAlteraParcela']['Produtos'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] != "0" ) ? 'PR.ConcluidoProduto = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] != "0" ) ? 'PR.DevolvidoProduto = "' . $_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] . '" AND ' : FALSE;		
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataValidadeProduto) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataValidadeProduto) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcades'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcades'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeFornecedor'] != "0" )) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['NomeFornecedor'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeFornecedor,
				OT.idApp_OrcaTrata,
				OT.Descricao,
				OT.TipoFinanceiro,
				TR.TipoFinanceiro,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				CONCAT(OT.idApp_OrcaTrata,"-",C.NomeFornecedor) AS Produto,
				PR.idTab_Produto,
				PR.idApp_Produto,
				PR.DataValidadeProduto,
				PR.ValorProduto,
				PR.ConcluidoProduto,
				PR.DevolvidoProduto,
				PR.QtdProduto,
				PR.ObsProduto,
				TP.Produtos
			FROM 
				App_Produto AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = PR.idTab_Produto
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Produto					
			WHERE 
				' . $permissao . '
				' . $permissao5 . '
				' . $permissao1 . '
				' . $permissao6 . '
				' . $permissao4 . '
				' . $permissao7 . '				
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "1" AND				
				OT.AprovadoOrca = "S" AND				
				PR.idSis_Empresa = ' . $data . ' AND
				' . $consulta . ' AND
				PR.idTab_TipoRD = "1" 
			ORDER BY
				PR.DataValidadeProduto DESC,
				C.NomeFornecedor
				
		');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_procedimento($data) {
		$query = $this->db->query('
			SELECT 
				PC.*,
				US.*
			FROM 
				App_Procedimento AS PC
					LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_procedimento_posterior($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_OrcaTrata = ' . $data . ' AND ConcluidoProcedimento = "N"');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_procedimento_baixa($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }	

    public function get_alterarprocedimento($data) {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] != '0' ) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraProcedimento']['Prioridade'] != '0' ) ? 'P.Prioridade = "' . $_SESSION['FiltroAlteraProcedimento']['Prioridade'] . '" AND ' : FALSE;
		$permissao7 = ($_SESSION['FiltroAlteraProcedimento']['Procedimento'] != '0' ) ? 'P.idApp_Procedimento = "' . $_SESSION['FiltroAlteraProcedimento']['Procedimento'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraProcedimento']['Mesvenc'] != "0" ) ? 'MONTH(P.DataProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraProcedimento']['Ano'] != "" ) ? 'YEAR(P.DataProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Ano'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraProcedimento']['Dia'] != "0" ) ? 'DAY(P.DataProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Dia'] . '" AND ' : FALSE;
		$permissao8 = ($_SESSION['FiltroAlteraProcedimento']['Categoria'] != '0' ) ? 'P.Categoria = "' . $_SESSION['FiltroAlteraProcedimento']['Categoria'] . '" AND ' : FALSE;
		$permissao9 = ($_SESSION['FiltroAlteraProcedimento']['Statustarefa'] != '0' ) ? 'P.Statustarefa = "' . $_SESSION['FiltroAlteraProcedimento']['Statustarefa'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				P.*,
				
				US.idSis_Usuario AS Compartilhar,
				US.CelularUsuario AS CelularCompartilhou,
				US.Nome AS NomeCompartilhar,
				
				P.idSis_Usuario AS idSis_Usuario,
				USC.CelularUsuario AS CelularCadastrou,
				USC.Nome AS NomeCadastrou
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoProcedimento
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = P.Categoria
			WHERE 
				' . $permissao1 . '	 
				' . $permissao8 . '	
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" AND
				P.idApp_Fornecedor = "0" 
			ORDER BY
				P.DataProcedimento DESC,
				P.Prioridade ASC,
				CT.Categoria DESC
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_alterarprocedimentocli($data) {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraProcedimento']['Concluidocli'] != '0' ) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['Concluidocli'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraProcedimento']['Mesvenccli'] != "0" ) ? 'MONTH(P.DataConcluidoProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Mesvenccli'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraProcedimento']['Anocli'] != "" ) ? 'YEAR(P.DataConcluidoProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Anocli'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraProcedimento']['NomeCliente'] != "0" ) ? 'C.idApp_Cliente = "' . $_SESSION['FiltroAlteraProcedimento']['NomeCliente'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraProcedimento']['Diacli'] != "0" ) ? 'DAY(P.DataConcluidoProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Diacli'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.idApp_Cliente,
				C.NomeCliente,
				U.CpfUsuario,
				P.idSis_Usuario,
				P.idSis_Empresa,
				P.idApp_Procedimento,
                P.Procedimento,
				P.DataProcedimento,
				P.DataConcluidoProcedimento,
				P.HoraProcedimento,				
				P.ConcluidoProcedimento
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
			WHERE 

				P.idSis_Empresa = ' . $data . '  AND

				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao4 . '
				' . $permissao5 . '
				P.idApp_Cliente != "0" 
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_alterarmensagemenv($data) {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_UsuarioCli = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraProcedimento']['Concluidoemp'] != '0' ) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['Concluidoemp'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraProcedimento']['Mesvencemp'] != "0" ) ? 'MONTH(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Mesvencemp'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraProcedimento']['Anoemp'] != "" ) ? 'YEAR(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Anoemp'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraProcedimento']['Diaemp'] != "0" ) ? 'DAY(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Diaemp'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraProcedimento']['NomeEmpresa'] != "0" ) ? 'P.idSis_Empresa = "' . $_SESSION['FiltroAlteraProcedimento']['NomeEmpresa'] . '" AND ' : FALSE;
		$permissao7 = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraProcedimento']['NomeEmpresaCli'] != "0" ) ? 'P.idSis_EmpresaCli = "' . $_SESSION['FiltroAlteraProcedimento']['NomeEmpresaCli'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				
				P.idApp_Procedimento,
				
				UR.Nome AS Nome,
				P.idSis_Usuario,
				ER.NomeEmpresa AS NomeEmpresa,
				P.idSis_Empresa,
                P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento,
				
				UE.Nome AS NomeCli,
				P.idSis_UsuarioCli,
				EE.NomeEmpresa AS NomeEmpresaCli,
				P.idSis_EmpresaCli,
                P.ProcedimentoCli,
				P.DataProcedimentoCli,
				P.ConcluidoProcedimentoCli
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS UE ON UE.idSis_Usuario = P.idSis_UsuarioCli
					LEFT JOIN Sis_Usuario AS UR ON UR.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Empresa AS EE ON EE.idSis_Empresa = P.idSis_EmpresaCli
					LEFT JOIN Sis_Empresa AS ER ON ER.idSis_Empresa = P.idSis_Empresa
			WHERE 

				P.idSis_EmpresaCli = ' . $data . '  AND
				P.idApp_OrcaTrata = "0" AND
				' . $permissao . '
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao5 . '
				' . $permissao6 . '

				P.idApp_Cliente = "0" 
		');
		/*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        $query = $query->result_array();

        return $query;
    }

    public function get_alterarmensagemrec($data) {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_UsuarioCli = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraProcedimento']['Concluidoemp'] != '0' ) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['Concluidoemp'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraProcedimento']['Mesvencemp'] != "0" ) ? 'MONTH(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Mesvencemp'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraProcedimento']['Anoemp'] != "" ) ? 'YEAR(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Anoemp'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraProcedimento']['Diaemp'] != "0" ) ? 'DAY(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Diaemp'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraProcedimento']['NomeEmpresa'] != "0" ) ? 'P.idSis_Empresa = "' . $_SESSION['FiltroAlteraProcedimento']['NomeEmpresa'] . '" AND ' : FALSE;
		$permissao7 = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraProcedimento']['NomeEmpresaCli'] != "0" ) ? 'P.idSis_EmpresaCli = "' . $_SESSION['FiltroAlteraProcedimento']['NomeEmpresaCli'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				
				P.idApp_Procedimento,
				
				UR.Nome AS Nome,
				P.idSis_Usuario,
				ER.NomeEmpresa AS NomeEmpresa,
				P.idSis_Empresa,
                P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento,
				
				UE.Nome AS NomeCli,
				P.idSis_UsuarioCli,
				EE.NomeEmpresa AS NomeEmpresaCli,
				P.idSis_EmpresaCli,
                P.ProcedimentoCli,
				P.DataProcedimentoCli,
				P.ConcluidoProcedimentoCli
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS UE ON UE.idSis_Usuario = P.idSis_UsuarioCli
					LEFT JOIN Sis_Usuario AS UR ON UR.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Empresa AS EE ON EE.idSis_Empresa = P.idSis_EmpresaCli
					LEFT JOIN Sis_Empresa AS ER ON ER.idSis_Empresa = P.idSis_Empresa
			WHERE 

				P.idSis_Empresa =  ' . $data . '  AND
				P.idSis_EmpresaCli != "0" AND
				P.idApp_OrcaTrata = "0" AND
				' . $permissao . '
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao5 . '

				' . $permissao7 . '
				P.idApp_Cliente = "0" 
		');
		/*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        $query = $query->result_array();

        return $query;
    }
	
    public function get_associado($data) {
        $query = $this->db->query(
			'SELECT
				C.idApp_Cliente,
				C.NomeCliente
			FROM 
				App_Cliente AS C 
			WHERE 
				C.idSis_Associado = ' . $data . ' AND
				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			LIMIT 1'
		);
        
		$count = $query->num_rows();
		
		if(isset($count)){
			if($count == 0){
				return FALSE;
			}else{
				$query = $query->result_array();
				return $query[0];
			}
		}else{
			return FALSE;
		}
    }
	
    public function get_profissional($data) {
		$query = $this->db->query('SELECT NomeProfissional FROM App_Profissional WHERE idApp_Profissional = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['NomeProfissional'])) ? $query[0]['NomeProfissional'] : FALSE;
    }
	
    public function list_orcamentocomb($id, $combinado, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
				
		$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrata, '
			. 'OT.idSis_Empresa, '
            . 'OT.DataOrca, '
            . 'OT.DataEntregaOrca, '
            . 'OT.DataVencimentoOrca, '
			. 'OT.DataPrazo, '
			. 'OT.DataConclusao, '
			. 'OT.DataQuitado, '
            . 'OT.ProfissionalOrca, '
            . 'OT.AprovadoOrca, '
			. 'OT.ConcluidoOrca, '
			. 'OT.QuitadoOrca, '
			. 'OT.FinalizadoOrca, '
			. 'OT.CanceladoOrca, '
			. 'OT.CombinadoFrete, '
            . 'OT.ObsOrca, '
			. 'OT.Consideracoes '
            . 'FROM '
            . 'App_OrcaTrata AS OT '
            . 'WHERE '
			. $permissao_orcam 
			. $revendedor 
			. 'OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
			. 'OT.idApp_Cliente = ' . $id . ' AND '
			. 'OT.idTab_TipoRD = "2" AND '
            . 'OT.CombinadoFrete = "' . $combinado . '" AND '
            
            . 'OT.FinalizadoOrca = "N" AND '
			. 'OT.CanceladoOrca = "N" '
            . 'ORDER BY '
			. 'OT.DataOrca DESC, '
			. 'OT.DataEntregaOrca DESC, '
			. 'OT.DataVencimentoOrca DESC ');
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
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
					$row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
					$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
					$row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
                    $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
					$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
					$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
					$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
					$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
					$row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                    #$row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }
                return $query;
            }
        
    }
	
    public function list_orcamento($id, $aprovado, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
		$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrata, '
			. 'OT.idSis_Empresa, '
            . 'OT.DataOrca, '
            . 'OT.DataEntregaOrca, '
            . 'OT.DataVencimentoOrca, '
			. 'OT.DataPrazo, '
			. 'OT.DataConclusao, '
			. 'OT.DataQuitado, '
            . 'OT.ProfissionalOrca, '
			. 'OT.CombinadoFrete, '
            . 'OT.AprovadoOrca, '
			. 'OT.ConcluidoOrca, '
			. 'OT.QuitadoOrca, '
			. 'OT.FinalizadoOrca, '
			. 'OT.CanceladoOrca, '
            . 'OT.ObsOrca, '
			. 'OT.Consideracoes '
            . 'FROM '
            . 'App_OrcaTrata AS OT '
            . 'WHERE '
			. $permissao_orcam 
			. $revendedor 
			. 'OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
			. 'OT.idApp_Cliente = ' . $id . ' AND '
			. 'OT.idTab_TipoRD = "2" AND '
            
            . 'OT.AprovadoOrca = "' . $aprovado . '" AND '
            . 'OT.FinalizadoOrca = "N" AND '
			. 'OT.CanceladoOrca = "N" '
            . 'ORDER BY '
			. 'OT.DataOrca DESC, '
			. 'OT.DataEntregaOrca DESC, '
			. 'OT.DataVencimentoOrca DESC ');
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
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
					$row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
					$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
					$row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
                    $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
					$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
					$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
					$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
					$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                    #$row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }
                return $query;
            }
        
    }

    public function list_orcamentofinal($id, $finalizado, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
		$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrata, '
			. 'OT.idSis_Empresa, '
            . 'OT.DataOrca, '
            . 'OT.DataEntregaOrca, '
            . 'OT.DataVencimentoOrca, '
			. 'OT.DataPrazo, '
			. 'OT.DataConclusao, '
			. 'OT.DataQuitado, '
            . 'OT.ProfissionalOrca, '
            . 'OT.AprovadoOrca, '
			. 'OT.ConcluidoOrca, '
			. 'OT.QuitadoOrca, '
			. 'OT.FinalizadoOrca, '
			. 'OT.CanceladoOrca, '
            . 'OT.ObsOrca, '
			. 'OT.Consideracoes '
            . 'FROM '
            . 'App_OrcaTrata AS OT '
            . 'WHERE '
			. $permissao_orcam
			. $revendedor
			. 'OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
			. 'OT.idApp_Cliente = ' . $id . ' AND '
			. 'OT.idTab_TipoRD = "2" AND '
            . 'OT.FinalizadoOrca = "' . $finalizado . '" AND '
			. 'OT.CanceladoOrca = "N" '
            . 'ORDER BY '
			. 'OT.DataOrca DESC, '
			. 'OT.DataEntregaOrca DESC, '
			. 'OT.DataVencimentoOrca DESC ');
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
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
					$row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
					$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
					$row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
                    $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
					$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
					$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
					$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
					$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                    #$row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }
                return $query;
            }
        
    }

    public function list_orcamentocancel($id, $cancelado, $completo) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}        
		
		$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrata, '
			. 'OT.idSis_Empresa, '
            . 'OT.DataOrca, '
            . 'OT.DataEntregaOrca, '
            . 'OT.DataVencimentoOrca, '
			. 'OT.DataPrazo, '
			. 'OT.DataConclusao, '
			. 'OT.DataQuitado, '
            . 'OT.ProfissionalOrca, '
            . 'OT.AprovadoOrca, '
			. 'OT.ConcluidoOrca, '
			. 'OT.QuitadoOrca, '
			. 'OT.FinalizadoOrca, '
			. 'OT.CanceladoOrca, '
            . 'OT.ObsOrca, '
			. 'OT.Consideracoes '
            . 'FROM '
            . 'App_OrcaTrata AS OT '
            . 'WHERE '
			. $permissao_orcam 
			. $revendedor 
			. 'OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
			. 'OT.idApp_Cliente = ' . $id . ' AND '
			. 'OT.idTab_TipoRD = "2" AND '
            . 'OT.CanceladoOrca = "' . $cancelado . '" '
            . 'ORDER BY '
			. 'OT.DataOrca DESC, '
			. 'OT.DataEntregaOrca DESC, '
			. 'OT.DataVencimentoOrca DESC ');
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
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
					$row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
					$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
					$row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
                    $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
					$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
					$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
					$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
					$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                    #$row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }
                return $query;
            }
        
    }

	public function list_arquivos($data, $completo) {

        $query = $this->db->query('
            SELECT
                idApp_Arquivos,
                idApp_OrcaTrata,
				Arquivos,
				Texto_Arquivos,
				Ativo_Arquivos
            FROM
                App_Arquivos
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idApp_OrcaTrata = ' . $data['idApp_OrcaTrata']. '
			ORDER BY
				idApp_Arquivos		
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
	
    public function update_orcatrata($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_OrcaTrata', $data, array('idApp_OrcaTrata' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;
    }

    public function update_cliente($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Cliente', $data, array('idApp_Cliente' => $id));
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function update_fornecedor($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Fornecedor', $data, array('idApp_Fornecedor' => $id));
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function update_orcatrataalterar($data, $id) {

        unset($data['idSis_Empresa']);
        $query = $this->db->update('Sis_Empresa', $data, array('idSis_Empresa' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
		
    public function update_servico($data) {

        $query = $this->db->update_batch('App_Produto', $data, 'idApp_Produto');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produto($data) {

        $query = $this->db->update_batch('App_Produto', $data, 'idApp_Produto');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produto_id($data, $id) {

        unset($data['idApp_Produto']);
        $query = $this->db->update('App_Produto', $data, array('idApp_Produto' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_tab_produtos_id($data, $id) {

        unset($data['idTab_Produtos']);
        $query = $this->db->update('Tab_Produtos', $data, array('idTab_Produtos' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_parcelas($data) {

        $query = $this->db->update_batch('App_Parcelas', $data, 'idApp_Parcelas');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_parcela($data, $id) {

        unset($data['idApp_Parcelas']);
        $query = $this->db->update('App_Parcelas', $data, array('idApp_Parcelas' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_parcelas_id($data, $id) {

        unset($data['idApp_Parcelas']);
        $query = $this->db->update('App_Parcelas', $data, array('idApp_Parcelas' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function update_comissao($data) {

        $query = $this->db->update_batch('App_OrcaTrata', $data, 'idApp_OrcaTrata');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function update_procedimento($data) {

        $query = $this->db->update_batch('App_Procedimento', $data, 'idApp_Procedimento');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_procedimento_id($data, $id) {

        unset($data['idApp_Procedimento']);
        $query = $this->db->update('App_Procedimento', $data, array('idApp_Procedimento' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_arquivos($data, $id) {

        unset($data['idApp_Arquivos']);
        $query = $this->db->update('App_Arquivos', $data, array('idApp_Arquivos' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_servico($data) {

        $this->db->where_in('idApp_Produto', $data);
        $this->db->delete('App_Produto');

        //$query = $this->db->delete('App_Servico', array('idApp_Servico' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
		return TRUE;
        }
    }

    public function delete_produto($data) {

        $this->db->where_in('idApp_Produto', $data);
        $this->db->delete('App_Produto');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_parcelas($data) {

        $this->db->where_in('idApp_Parcelas', $data);
        $this->db->delete('App_Parcelas');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function delete_comissao($data) {

        $this->db->where_in('idApp_OrcaTrata', $data);
        $this->db->delete('App_OrcaTrata');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }	
	
    public function delete_procedimento($data) {

        $this->db->where_in('idApp_Procedimento', $data);
        $this->db->delete('App_Procedimento');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_orcatrata($id) {
		/*
		echo '<br>';
		echo "<pre>";
		echo '<br>';
		print_r($id);
		echo "</pre>";
		exit();	
		*/
		if(isset($id) && $id != 0 && $id != ''){
			
			$data['orcatrata'] = $this->Orcatrata_model->get_orcatrata_delete($id);
			
			$data['orcatrata_produtos'] = $this->Orcatrata_model->get_orcatrata_delete_produtos($id);
			$data['count_orcatrata_produtos'] = count($data['orcatrata_produtos']);
			
			$data['soma_cashback_produtos'] = 0;
			if ($data['count_orcatrata_produtos'] > 0) {
				$data['orcatrata_produtos'] = array_combine(range(1, count($data['orcatrata_produtos'])), array_values($data['orcatrata_produtos']));

				if (isset($data['orcatrata_produtos'])) {

					for($j=1; $j <= $data['count_orcatrata_produtos']; $j++) {
						$data['soma_cashback_produtos'] += $data['orcatrata_produtos'][$j]['ValorComissaoCashBack'];
						
					}
				}
			}		

			if(isset($data['orcatrata']['idApp_Cliente']) && $data['orcatrata']['idApp_Cliente'] != 0 && $data['orcatrata']['idApp_Cliente'] != ''){
				
				$data['cliente'] = $this->Orcatrata_model->get_cliente_delete($data['orcatrata']['idApp_Cliente'], TRUE);

				if($data['orcatrata']['CanceladoOrca'] == "N"){
					
					if($data['orcatrata']['QuitadoOrca'] == "S"){
						//muda o cashback		
						$data['cliente_cashback']['CashBackCliente'] = $data['cliente']['CashBackCliente'] - $data['soma_cashback_produtos'];

						if($data['cliente_cashback']['CashBackCliente'] >= 0){
							$data['cliente_cashback']['CashBackCliente'] = $data['cliente_cashback']['CashBackCliente'];
						}else{
							$data['cliente_cashback']['CashBackCliente'] = 0.00;
						}
						$data['update']['cliente_cashback']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_cashback'], $data['orcatrata']['idApp_Cliente']); 
					
					}else{
						//não muda o cashback
					}
				}else{
					if($data['orcatrata']['QuitadoOrca'] == "S"){
						//não muda o cashback
					}else{
						//não muda o cashback
					}
				}

			}else{
				//não existe cliente - não faz nada		
			}

			
			/*
			$tables = array('App_Servico', 'App_Produto', 'App_Parcelas', 'App_Procedimento', 'App_OrcaTrata');
			$this->db->where('idApp_Orcatrata', $id);
			$this->db->delete($tables);
			*/
		
			$query = $this->db->delete('App_Arquivos', array('idApp_Orcatrata' => $id));
			$query = $this->db->delete('App_Servico', array('idApp_Orcatrata' => $id));
			$query = $this->db->delete('App_Produto', array('idApp_Orcatrata' => $id));
			$query = $this->db->delete('App_Parcelas', array('idApp_Orcatrata' => $id));
			$query = $this->db->delete('App_Procedimento', array('idApp_Orcatrata' => $id));
			$query = $this->db->delete('App_OrcaTrata', array('idApp_Orcatrata' => $id));			
			
			if(isset($data['orcatrata']['idApp_Cliente']) && $data['orcatrata']['idApp_Cliente'] != 0 && $data['orcatrata']['idApp_Cliente'] != ''){
					
				$data['get_ult_pdd_cliente'] = $this->Orcatrata_model->get_ult_pdd_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
				if(isset($data['get_ult_pdd_cliente'])){
					$data['cliente_ult_pdd']['id_UltimoPedido'] = $data['get_ult_pdd_cliente']['idApp_OrcaTrata'];
					$data['cliente_ult_pdd']['UltimoPedido'] 	= $data['get_ult_pdd_cliente']['DataOrca'];			
				}else{
					$data['cliente_ult_pdd']['id_UltimoPedido'] = 0;
					$data['cliente_ult_pdd']['UltimoPedido'] 	= "0000-00-00";
				}
				$data['update']['cliente_ult_pdd']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente_ult_pdd'], $data['orcatrata']['idApp_Cliente']);
			}
		
		}

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
		
    }

    public function delete_arquivos($id) {

        $query = $this->db->delete('App_Arquivos', array('idApp_Arquivos' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
}
