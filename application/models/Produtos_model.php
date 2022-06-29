<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_produtos($data) {

        $query = $this->db->insert('Tab_Produtos', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_produtos_Original($data) {

        $query = $this->db->insert('Tab_Produto', $data);

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
	
    public function set_valor($data) {

        $query = $this->db->insert_batch('Tab_Valor', $data);
		
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_servico($data) {

        $query = $this->db->insert_batch('Tab_Atributo_Select', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
			} else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_opcao_select($data) {

        $query = $this->db->insert_batch('Tab_Opcao_Select', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_produto($data) {

        $query = $this->db->insert_batch('Tab_Opcao_Select', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_procedimento($data) {

        $query = $this->db->insert_batch('Tab_Opcao_Select', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	

    public function set_derivados($data) {

        $query = $this->db->insert_batch('Tab_Produtos', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	
	
    public function set_valor1($data) {

        $query = $this->db->insert('Tab_Valor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	

    public function set_promocao($data) {

        $query = $this->db->insert('Tab_Promocao', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_catprod_verificacao($data) {
		$query = $this->db->query(
			'SELECT
				idTab_Catprod
			FROM 
				Tab_Catprod AS TP
			WHERE 
				idTab_Catprod = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
	}

    public function get_catprod($data) {
		$query = $this->db->query(
			'SELECT
				TP.*
			FROM 
				Tab_Catprod AS TP
			WHERE 
				idTab_Catprod = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
	}

    public function get_produto_verificacao($data) {
		$query = $this->db->query(
			'SELECT
				idTab_Produto
			FROM 
				Tab_Produto AS TP
			WHERE 
				idTab_Produto = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
	}

    public function get_produto($data) {
		$query = $this->db->query(
			'SELECT
				TP.*
			FROM 
				Tab_Produto AS TP
			WHERE 
				idTab_Produto = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
	}
	
    public function get_produtos_verificacao($data) {
        $query = $this->db->query(
			'SELECT  
				TPS.idTab_Produtos
			FROM 
				Tab_Produtos AS TPS
			WHERE 
				TPS.idTab_Produtos = ' . $data . ' AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }
	
    public function get_produtos($data) {
        $query = $this->db->query(
			'SELECT  
				TPS.*,
				TPS.Arquivo AS ArquivoDerivado,
				TCP.*,
				TCP.Arquivo AS ArquivoCatprod,
				TP.idTab_Produto,
				TP.Produtos,
				TP.VendaSite AS VendaSite_Produto,
				TOP1.idTab_Opcao,
				TOP1.Opcao AS Opcao1,
				TOP2.idTab_Opcao,
				TOP2.Opcao AS Opcao2
			FROM 
				Tab_Produtos AS TPS
					LEFT JOIN Tab_Catprod AS TCP ON TCP.idTab_Catprod = TPS.idTab_Catprod
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_2
			WHERE 
				TPS.idTab_Produtos = ' . $data . ' AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
    }

    public function get_app_produto($data) {
		$query = $this->db->query('
			SELECT
				TAP.*
			FROM 
				App_Produto AS TAP
			WHERE 
				TAP.idSis_Empresa = ' . $data['idSis_Empresa'] . ' AND
				TAP.idTab_Produtos_Produto = ' . $data['idTab_Produtos'] . '
		');
        $query = $query->result_array();

        //return $query[0];
		return $query;
    }

    public function get_tab_valor($data) {
		$query = $this->db->query('
			SELECT
				TV.*
			FROM 
				Tab_Valor AS TV
			WHERE 
				TV.idSis_Empresa = ' . $data['idSis_Empresa'] . ' AND
				TV.idTab_Produtos = ' . $data['idTab_Produtos'] . ' AND
				TV.Desconto = "2"
		');
        $query = $query->result_array();

        //return $query[0];
		return $query;
    }
		
    public function get_modelo($data) {
		$query = $this->db->query('SELECT * FROM Tab_Produto WHERE idTab_Produto = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_valor_verificacao($data) {
		$query = $this->db->query(
			'SELECT 
				TV.idTab_Valor
			FROM 
				Tab_Valor AS TV
			WHERE 
				TV.idTab_Valor = ' . $data . ' AND
				TV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }
	
    public function get_valor($data) {
		$query = $this->db->query(
			'SELECT 
				TV.*,
				TPS.Nome_Prod,
				TPS.idTab_Produto,
				TPS.idTab_Catprod,
				TPS.Arquivo,
				TPS.Cod_Prod,
				TPS.Cod_Barra,
				TPS.ContarEstoque,
				TPS.Produtos_Descricao,
				TPS.Estoque
			FROM 
				Tab_Valor AS TV
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
			WHERE 
				TV.idTab_Valor = ' . $data . ' AND
				TV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
    }

    public function get_servico($data) {
		$query = $this->db->query('SELECT * FROM Tab_Atributo_Select WHERE idTab_Produto = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_atributos($data) {
		$query = $this->db->query('
			SELECT 
				TA.*
			FROM 
				Tab_Atributo AS TA
			WHERE 
				TA.idTab_Catprod = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_atributos2($data) {
		$query = $this->db->query('
			SELECT 
				TAS.*,
				TA.*
			FROM 
				Tab_Atributo_Select AS TAS
					LEFT JOIN Tab_Atributo AS TA ON TA.idTab_Atributo = TAS.idTab_Atributo
			WHERE 
				TAS.idTab_Catprod = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }
	
	public function get_opcao_select($data, $item) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Opcao_Select 
			WHERE 
				idTab_Produto = ' . $data . ' AND
				Item_Atributo = '. $item . '
		');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_opcao_select1($data) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Opcao_Select 
			WHERE 
				idTab_Produto = ' . $data . ' AND
				Item_Atributo = "1"
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_opcao_select2($data) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Opcao_Select 
			WHERE 
				idTab_Produto = ' . $data . ' AND
				Item_Atributo = "2"
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_produto_Original($data) {
		$query = $this->db->query('SELECT * FROM Tab_Opcao_Select WHERE idTab_Produto = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM Tab_Opcao_Select WHERE idTab_Produto = ' . $data);
        $query = $query->result_array();

        return $query;
    }	

    public function get_produtosderivados_verificacao($data) {
		$query = $this->db->query(
			'SELECT
				TPS.idTab_Produtos
			FROM 
				Tab_Produtos AS TPS
			WHERE 
				TPS.idTab_Produtos = ' . $data . ' AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }

    public function get_produtosderivados($data) {
		$query = $this->db->query(
			'SELECT
				TPS.idTab_Produtos,
				TPS.idSis_Empresa,
				TPS.Arquivo,
				TPS.Nome_Prod,
				TP.Produtos,
				TOP2.Opcao,
				TOP1.Opcao,
				CONCAT(IFNULL(TP.Produtos,""), " - ",  IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,"")) AS NomeProduto
			FROM 
				Tab_Produtos AS TPS
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
			WHERE 
				TPS.idTab_Produtos = ' . $data . ' AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
    }
	
	public function get_item($data, $desconto) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Valor 
			WHERE 
				idTab_Produtos = ' . $data . ' AND
				Desconto = ' . $desconto . '
		');
        $query = $query->result_array();

        return $query;
    }

	public function list_categoria($data, $x) {
		
		//$data['idSis_Empresa'] = ($data['idSis_Empresa'] != 0) ? ' AND TPS.idSis_Empresa = ' . $data['idSis_Empresa'] : FALSE;
			
			/*
			echo "<pre>";
			print_r($data['idSis_Empresa']);
			echo "</pre>";
			exit();
			*/
		
		
        $query = $this->db->query('
			SELECT 
				TCT.*,
				TPSA.*,
				TPS.idTab_Produtos
			FROM 
				Tab_Catprod AS TCT
					LEFT JOIN Tab_Prod_Serv AS TPSA ON TPSA.Abrev_Prod_Serv = TCT.TipoCatprod
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Catprod = TCT.idTab_Catprod
			WHERE 
                TCT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			GROUP BY
				TCT.idTab_Catprod
			ORDER BY  
				TPSA.Prod_Serv ASC,  
				TCT.Catprod ASC 
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
                foreach ($query->result() as $row) {
					
					if($row->idTab_Produtos){
						$row->CategoriaUsada = "S";
					}else{
						$row->CategoriaUsada = "N";
					}
					
				#    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                }
                $query = $query->result_array();
                return $query;
            }
        }
    }
    
	public function list_atributo($data, $x) {
		
		$data['idTab_Catprod'] = ($data['idTab_Catprod'] != 0) ? ' AND TA.idTab_Catprod = ' . $data['idTab_Catprod'] : FALSE;

        $query = $this->db->query('
			SELECT 
				TA.*,
				TOP.idTab_Opcao
			FROM 
				Tab_Atributo AS TA
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Atributo = TA.idTab_Atributo
			WHERE 
                TA.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
                ' . $data['idTab_Catprod'] . '
			GROUP BY
				TA.idTab_Atributo
			ORDER BY  
				TA.Atributo ASC 
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
                foreach ($query->result() as $row) {
                
					if($row->idTab_Opcao){
						$row->VariacaoUsada = "S";
					}else{
						$row->VariacaoUsada = "N";
					}
				
				
				#    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                }
                $query = $query->result_array();
                return $query;
            }
        }
    }
    
	public function list_opcao($data, $x) {
		
		$data['idTab_Catprod'] = ($data['idTab_Catprod'] != 0) ? ' AND TOP.idTab_Catprod = ' . $data['idTab_Catprod'] : FALSE;

        $query = $this->db->query('
			SELECT 
				TOP.*,
				TA.*,
				TPS1.Opcao_Atributo_1,
				TPS2.Opcao_Atributo_2
			FROM 
				Tab_Opcao AS TOP
					LEFT JOIN Tab_Atributo AS TA ON TA.idTab_Atributo = TOP.idTab_Atributo
					LEFT JOIN Tab_Produtos AS TPS1 ON TPS1.Opcao_Atributo_1 = TOP.idTab_Opcao
					LEFT JOIN Tab_Produtos AS TPS2 ON TPS2.Opcao_Atributo_2 = TOP.idTab_Opcao
			WHERE 
                TOP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
                ' . $data['idTab_Catprod'] . '
			GROUP BY
				TOP.idTab_Opcao
			ORDER BY  
				TA.Atributo ASC, 
				TOP.Opcao ASC 
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
                foreach ($query->result() as $row) {
                
					if($row->Opcao_Atributo_1){
						$row->OpcaoUsada = "S";
					}else{
						if($row->Opcao_Atributo_2){
							$row->OpcaoUsada = "S";
						}else{
							$row->OpcaoUsada = "N";
						}
					}
				
				#    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                }
                $query = $query->result_array();
                return $query;
            }
        }
    }
        
	public function list_produto($data, $x) {
		
		$data['idTab_Catprod'] = ($data['idTab_Catprod'] != 0) ? ' AND TP.idTab_Catprod = ' . $data['idTab_Catprod'] : FALSE;

        $query = $this->db->query('
			SELECT 
				TP.*,
				TPS.idTab_Produtos
			FROM 
				Tab_Produto AS TP
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produto = TP.idTab_Produto
			WHERE 
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
                ' . $data['idTab_Catprod'] . '
			GROUP BY
				TP.idTab_Produto
			ORDER BY  
				TP.Produtos ASC 
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
                foreach ($query->result() as $row) {
                
					if($row->idTab_Produtos){
						$row->ProdutoUsada = "S";
					}else{
						$row->ProdutoUsada = "N";
					}
				
					#$row->idApp_Profissional = $row->idApp_Profissional;
					#$row->NomeProfissional = $row->NomeProfissional;
                }
                $query = $query->result_array();
                return $query;
            }
        }
    }
		
    public function list_produtos1($id, $aprovado, $completo) {

        $query = $this->db->query('
            SELECT
                TF.idTab_Produto,
                TF.TipoProduto,
                TF.Produtos
            FROM
                Tab_Produto AS TF
            WHERE
                TF.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' 
            ORDER BY
                TF.TipoProduto ASC
				
        ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {

                    $row->TipoProduto = $this->get_tipoproduto($row->TipoProduto);
                }
                return $query;
            }
        }
    }
    
	public function list_produtos($data, $x) {
		
		$data['idTab_Produto'] = ($data['idTab_Produto'] != 0) ? ' AND TPS.idTab_Produto = ' . $data['idTab_Produto'] : FALSE;
			
			/*
			echo "<pre>";
			print_r($data['idTab_Produto']);
			echo "</pre>";
			exit();
			*/
		
		
        $query = $this->db->query('
			SELECT 
				TPS.*,
				TCT.*,
				TP.*,
				TOP1.Opcao AS Atributo1,
				TOP2.Opcao AS Atributo2
			FROM 
				Tab_Produtos AS TPS
					LEFT JOIN Tab_Catprod AS TCT ON TCT.idTab_Catprod = TPS.idTab_Catprod
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_2
			WHERE 
                TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Catprod = ' . $data['idTab_Catprod'] . '
				' . $data['idTab_Produto'] . '
			ORDER BY  
				TPS.Nome_Prod ASC 
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
    
	public function list_precos($data, $x) {
		
		$data['idTab_Produtos'] = ($data['idTab_Produtos'] != 0) ? ' AND TV.idTab_Produtos = ' . $data['idTab_Produtos'] : FALSE;
			
			/*
			echo "<pre>";
			print_r($data['Metodo']);
			echo "</pre>";
			exit();
			*/
		
		
        $query = $this->db->query('
			SELECT 
				TV.*,
				TDS.*,
				TPM.DataInicioProm,
				TPM.DataFimProm,
				TPM.Promocao,
				TPM.Descricao,
				TPS.Nome_Prod
			FROM 
				Tab_Valor AS TV
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = TV.Desconto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = TV.idTab_Promocao
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_produtos
			WHERE 
                TV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TV.Desconto = "1" 
				' . $data['idTab_Produtos'] . '
			ORDER BY  
				TDS.Desconto ASC,
				TPM.Promocao ASC 
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
                
				foreach ($query->result() as $row) {
					if($row->idTab_Valor){
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
						$row->AtivoPreco = "Não";
					}
					//$row->AtivoPreco = $this->basico->mascara_palavra_completa($row->AtivoPreco, 'NS');
					$row->VendaSitePreco = $this->basico->mascara_palavra_completa($row->VendaSitePreco, 'NS');
					$row->VendaBalcaoPreco = $this->basico->mascara_palavra_completa($row->VendaBalcaoPreco, 'NS');
					$row->ValorProduto = number_format($row->ValorProduto, 2, ',', '.');
					$row->ComissaoVenda = number_format($row->ComissaoVenda, 2, ',', '.');
					$row->ComissaoServico = number_format($row->ComissaoServico, 2, ',', '.');
					$row->ComissaoCashBack = number_format($row->ComissaoCashBack, 2, ',', '.');
					if($row->TempoDeEntrega == 0){
						$row->TempoDeEntrega = "Pronta Entrega";
					}else{
						$row->TempoDeEntrega = $row->TempoDeEntrega . " Dia(s)";
					}
                }
				
                $query = $query->result_array();
                return $query;
            }
        }
    }
    
	public function list_precos_promocoes($data, $x) {
		
		$data['idTab_Produtos'] = ($data['idTab_Produtos'] != 0) ? ' AND TV.idTab_Produtos = ' . $data['idTab_Produtos'] : FALSE;
			
			/*
			echo "<pre>";
			print_r($data['Metodo']);
			echo "</pre>";
			exit();
			*/
		
		
        $query = $this->db->query('
			SELECT 
				TV.*,
				TDS.*,
				TPM.Ativo AS AtivoPromocao,
				TPM.VendaBalcao AS VendaBalcaoPromocao,
				TPM.VendaSite AS VendaSitePromocao,
				TPM.DataInicioProm,
				TPM.DataFimProm,
				TPM.Promocao,
				TPM.Descricao,
				TPM.TipoPromocao
			FROM 
				Tab_Valor AS TV
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = TV.Desconto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = TV.idTab_Promocao
			WHERE 
                TV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TV.Desconto = "2"
				' . $data['idTab_Produtos'] . '
			ORDER BY  
				TDS.Desconto ASC,
				TPM.Promocao ASC 
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
                foreach ($query->result() as $row) {
					$row->DataInicioProm = $this->basico->mascara_data($row->DataInicioProm, 'barras');
					$row->DataFimProm = $this->basico->mascara_data($row->DataFimProm, 'barras');
					
					if($row->idTab_Promocao){
						if($row->VendaBalcaoPromocao == "S"){
							if($row->VendaSitePromocao == "S"){
								$row->AtivoPromocao = "Balcao/Site";
							}else{
								$row->AtivoPromocao = "Balcao";
							}
						}else{
							if($row->VendaSitePromocao == "S"){
								$row->AtivoPromocao = "Site";
							}else{
								$row->AtivoPromocao = "Não";
							}
						}
					}else{
						$row->AtivoPromocao = "Não";
					}
					
                }
                $query = $query->result_array();
                return $query;
            }
        }
    }
    
	public function list_promocoes($data, $x) {
		
		$data['idTab_Produtos'] = ($data['idTab_Produtos'] != 0) ? ' AND TV.idTab_Produtos = ' . $data['idTab_Produtos'] : FALSE;
			/*
			echo "<pre>";
			print_r($data['Metodo']);
			echo "</pre>";
			exit();
			*/
        $query = $this->db->query('
			SELECT 
				TPM.*,
				TPM.Ativo AS AtivoPromocao,
				TPM.VendaBalcao AS VendaBalcaoPromocao,
				TPM.VendaSite AS VendaSitePromocao,
				TCT.*
			FROM 
				Tab_Promocao AS TPM
					LEFT JOIN Tab_Catprom AS TCT ON TCT.idTab_Catprom = TPM.idTab_Catprom
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPM.idTab_Promocao
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
			WHERE 
                TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TV.Desconto = "2"
				' . $data['idTab_Produtos'] . '
			ORDER BY
				TPM.Promocao ASC 
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
                foreach ($query->result() as $row) {
					$row->DataInicioProm = $this->basico->mascara_data($row->DataInicioProm, 'barras');
					$row->DataFimProm = $this->basico->mascara_data($row->DataFimProm, 'barras');
					$row->VendaBalcao = $this->basico->mascara_palavra_completa($row->VendaBalcao, 'NS');
					$row->VendaSite = $this->basico->mascara_palavra_completa($row->VendaSite, 'NS');
					
					if($row->idTab_Promocao){
						if($row->VendaBalcaoPromocao == "S"){
							if($row->VendaSitePromocao == "S"){
								$row->AtivoPromocao = "Balcao/Site";
							}else{
								$row->AtivoPromocao = "Balcao";
							}
						}else{
							if($row->VendaSitePromocao == "S"){
								$row->AtivoPromocao = "Site";
							}else{
								$row->AtivoPromocao = "Não";
							}
						}
					}else{
						$row->AtivoPromocao = "Não";
					}
					
                }
                $query = $query->result_array();
                return $query;
            }
        }
    }

	public function lista_produtos($x) {

		#$data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
		
        $query = $this->db->query('
			SELECT 
				TP.idTab_Produto,
				TP.Produtos,
				TV.ValorProduto
			FROM 
				Tab_Produto AS TP
				 LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produto = TP.idTab_Produto
				 
			WHERE 
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TV.idTab_Produto = TP.idTab_Produto
			ORDER BY 
				TP.Produtos ASC 
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
	
    public function update_catprod($data, $id) {

        unset($data['idTab_Catprod']);
        $query = $this->db->update('Tab_Catprod', $data, array('idTab_Catprod' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_produto($data, $id) {

        unset($data['idTab_Produto']);
        $query = $this->db->update('Tab_Produto', $data, array('idTab_Produto' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
		
    public function update_produtos($data, $id) {

        unset($data['idTab_Produtos']);
        $query = $this->db->update('Tab_Produtos', $data, array('idTab_Produtos' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_produtos_Original($data, $id) {

        unset($data['idTab_Produto']);
        $query = $this->db->update('Tab_Produto', $data, array('idTab_Produto' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produtosderivados($data, $id) {

        unset($data['idTab_Produtos']);
        $query = $this->db->update('Tab_Produtos', $data, array('idTab_Produtos' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_valor($data) {

        $query = $this->db->update_batch('Tab_Valor', $data, 'idTab_Valor');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_valor1($data, $id) {

        unset($data['idTab_Valor']);
        $query = $this->db->update('Tab_Valor', $data, array('idTab_Valor' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;
		
    }
	
    public function update_servico($data) {
		
        $query = $this->db->update_batch('Tab_Atributo_Select', $data, 'idTab_Atributo_Select');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function update_opcao_select($data) {
		
        $query = $this->db->update_batch('Tab_Opcao_Select', $data, 'idTab_Opcao_Select');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	
	
    public function update_produto_original($data) {
		
        $query = $this->db->update_batch('Tab_Opcao_Select', $data, 'idTab_Opcao_Select');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_procedimento($data) {
		
        $query = $this->db->update_batch('Tab_Opcao_Select', $data, 'idTab_Opcao_Select');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function update_derivados($data) {
		
        $query = $this->db->update_batch('Tab_Produtos', $data, 'idTab_Produtos');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	
	
    public function delete_valor($data) {

        $this->db->where_in('idTab_Valor', $data);
        $this->db->delete('Tab_Valor');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function delete_servico($data) {

        $this->db->where_in('idTab_Atributo_Select', $data);
        $this->db->delete('Tab_Atributo_Select');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_opcao_select($data) {
		
        $this->db->where_in('idTab_Opcao_Select', $data);
        $this->db->delete('Tab_Opcao_Select');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }	
	
    public function delete_produto($data) {

        $this->db->where_in('idTab_Opcao_Select', $data);
        $this->db->delete('Tab_Opcao_Select');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function delete_procedimento($data) {

        $this->db->where_in('idTab_Opcao_Select', $data);
        $this->db->delete('Tab_Opcao_Select');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }	

    public function delete_derivados($data) {

        $this->db->where_in('idTab_Produtos', $data);
        $this->db->delete('Tab_Produtos');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }	
	
    public function delete_produtos($id) {

		$query = $this->db->delete('Tab_Produtos', array('idTab_Produtos' => $id));
        $query = $this->db->delete('Tab_Valor', array('idTab_Produtos' => $id));
		
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_tipoproduto($data) {
		$query = $this->db->query('SELECT TipoProduto FROM Tab_TipoProduto WHERE idTab_TipoProduto = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['TipoProduto'])) ? $query[0]['TipoProduto'] : FALSE;
    }

}
