<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_empresa($data) {

        $query = $this->db->insert('Sis_Empresa', $data);

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

    public function get_empresa($data) {
        $query = $this->db->query('SELECT * FROM Sis_Empresa WHERE idSis_Empresa = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_empresa_associado($data) {
        $query = $this->db->query('SELECT idSis_Empresa FROM Sis_Empresa WHERE idSis_Associado = ' . $data);

        $query = $query->result_array();

        return $query;
    }
	
    public function get_pagseguro($data) {
        $query = $this->db->query('SELECT * FROM App_Documentos WHERE idSis_Empresa = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }	
	
    public function get_saudacao($data) {
        $query = $this->db->query('
			SELECT
				idSis_Empresa,
				idApp_Documentos, 
				TextoPedido_1,
				TextoPedido_2,
				TextoPedido_3,
				TextoPedido_4,
				ClientePedido,
				idClientePedido,
				idPedido,
				SitePedido,
				TextoAgenda_1,
				TextoAgenda_2,
				TextoAgenda_3,
				TextoAgenda_4,
				ClienteAgenda,
				ProfAgenda,
				DataAgenda,
				SiteAgenda
			FROM 
				App_Documentos 
			WHERE 
				idSis_Empresa = ' . $data . '
		');

        $query = $query->result_array();

        return $query[0];
    }	

    public function get_pagina($data) {
        $query = $this->db->query('SELECT * FROM App_Documentos WHERE idSis_Empresa = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }
	
    public function get_arquivo($data) {
        $query = $this->db->query('SELECT * FROM Sis_Arquivo WHERE idSis_Arquivo = ' . $data);
        $query = $query->result_array();

        return $query[0];

    }    

    public function get_produtos($data) {
        $query = $this->db->query('SELECT * FROM Tab_Produto WHERE idSis_Empresa = ' . $data);
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

    public function get_atendimento($data) {
		
		$query = $this->db->query('
            SELECT *
            FROM
				App_Atendimento
            WHERE
				idSis_Empresa = ' . $data . '	
            ORDER BY
				idApp_Atendimento 
		');
        $query = $query->result_array();
          
        return $query;
    }

    public function update_empresa($data, $id) {
		
		unset($data['Id']);
        $query = $this->db->update('Sis_Empresa', $data, array('idSis_Empresa' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function update_pagseguro($data, $id) {
		
		unset($data['idSis_Empresa']);
        $query = $this->db->update('App_Documentos', $data, array('idSis_Empresa' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_saudacao($data, $id) {
		
		unset($data['idSis_Empresa']);
        $query = $this->db->update('App_Documentos', $data, array('idSis_Empresa' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_empresa_original($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Sis_Empresa', $data, array('idSis_Empresa' => $id));
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
	
    public function update_pagina($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Documentos', $data, array('idSis_Empresa' => $id));
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

    public function update_atendimento($data) {
		
        $query = $this->db->update_batch('App_Atendimento', $data, 'idApp_Atendimento');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function delete_empresa($data) {

        $query = $this->db->query('SELECT idApp_OrcaTrata FROM App_OrcaTrata WHERE idSis_Empresa = ' . $data);
        $query = $query->result_array();

        /*
        echo $this->db->last_query();
        #$query = $query->result();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";


        foreach ($query as $key) {
            /*
            echo $key['idApp_OrcaTrata'];
            echo '<br />';
            #echo $value;
            echo '<br />';
        }

        exit();

        */

        $this->db->delete('Sis_Empresa', array('idSis_Empresa' => $data));
        $this->db->delete('App_Consulta', array('idSis_Empresa' => $data));
        $this->db->delete('App_ContatoEmpresa', array('idSis_Empresa' => $data));
        $this->db->delete('App_OrcaTrata', array('idSis_Empresa' => $data));

        foreach ($query as $key) {
            $query = $this->db->delete('App_ProdutoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ServicoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ParcelasRecebiveis', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_Procedimento', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
        }


        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function delete_empresa_toda($data) { 
		
		if(isset($data) && $data !=0){
			
			$this->db->delete('Sis_Empresa', array('idSis_Empresa' => $data));
			$this->db->delete('App_Agenda', array('idSis_Empresa' => $data));
			$this->db->delete('App_Atendimento', array('idSis_Empresa' => $data));
			$this->db->delete('App_Atividade', array('idSis_Empresa' => $data));
			$this->db->delete('App_Cliente', array('idSis_Empresa' => $data));
			$this->db->delete('App_ClienteDep', array('idSis_Empresa' => $data));
			$this->db->delete('App_ClientePet', array('idSis_Empresa' => $data));
			$this->db->delete('App_Consulta', array('idSis_Empresa' => $data));
			$this->db->delete('App_Contato', array('idSis_Empresa' => $data));
			$this->db->delete('App_ContatoCliente', array('idSis_Empresa' => $data));
			$this->db->delete('App_Contatofornec', array('idSis_Empresa' => $data));
			$this->db->delete('App_ContatoUsuario', array('idSis_Empresa' => $data));
			$this->db->delete('App_Documentos', array('idSis_Empresa' => $data));
			$this->db->delete('App_Fornecedor', array('idSis_Empresa' => $data));
			$this->db->delete('App_OrcaTrata', array('idSis_Empresa' => $data));
			$this->db->delete('App_Pagamento', array('idSis_Empresa' => $data));
			$this->db->delete('App_Parcelas', array('idSis_Empresa' => $data));
			$this->db->delete('App_Parcelas_Pagamento', array('idSis_Empresa' => $data));
			$this->db->delete('App_Procedimento', array('idSis_Empresa' => $data));
			$this->db->delete('App_Produto', array('idSis_Empresa' => $data));
			$this->db->delete('App_Produto_Pagamento', array('idSis_Empresa' => $data));
			$this->db->delete('App_Servico', array('idSis_Empresa' => $data));
			$this->db->delete('App_Slides', array('idSis_Empresa' => $data));
			$this->db->delete('App_SubProcedimento', array('idSis_Empresa' => $data));
			$this->db->delete('Sis_Arquivo', array('idSis_Empresa' => $data));
			$this->db->delete('Sis_EmpresaFilial', array('idSis_Empresa' => $data));
			$this->db->delete('Sis_Usuario', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Atributo', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Categoria', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Catprod', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Catprom', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Convenio', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Dia_Prom', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Funcao', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Motivo', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Opcao', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Produto', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Produtos', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Promocao', array('idSis_Empresa' => $data));
			$this->db->delete('Tab_Valor', array('idSis_Empresa' => $data));

			//$query = $this->db->delete('Tab_Produtos', array('idTab_Produtos' => $id));
			//$query = $this->db->delete('Tab_Valor', array('idTab_Produtos' => $id));
			
			if ($this->db->affected_rows() === 0) {
				return FALSE;
			} else {
				return TRUE;
			}
		}	
    }

    public function delete_arquivo($data) {
        $query = $this->db->delete('Sis_Arquivo', array('idSis_Arquivo' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            return TRUE;
        }

    }    

    public function lista_empresa($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Sis_Empresa WHERE '
                . 'Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
				. 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND '
                . '(NomeAdmin like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'NomeAdmin like "%' . $data . '%" OR '
                . 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Celular like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY NomeAdmin ASC ');
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
            if ($x === FALSE) {
                return TRUE;
            } else {
                foreach ($query->result() as $row) {
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                }

                return $query;
            }
        }
    }

    public function lista_contatoempresa($id, $bool) {

        $query = $this->db->query(
            'SELECT * '
                . 'FROM Sis_Usuario WHERE '
                . 'idSis_Empresa = ' . $id . ' '
            . 'ORDER BY Nome ASC ');
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
            if ($bool === FALSE) {
                return TRUE;
            } else {
                foreach ($query->result() as $row) {
                    $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                    $row->Sexo = $this->Basico_model->get_sexo($row->Sexo);

                }

                return $query;
            }
        }
    }

    public function list1_produtos($x) {

        $query = $this->db->query('
			SELECT 
				TP.idTab_Produto,
				TP.Produtos,
				TP.Arquivo,
				TP.Ativo,
				TP.VendaSite,
				TP.ValorProdutoSite,
				TV.ValorProduto
			FROM 
				Tab_Produto AS TP
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produto = TP.idTab_Produto
			WHERE
				TP.idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . ' AND
				TP.Ativo = "S" AND
				TP.VendaSite = "S"
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

    public function list2_slides($x) {

        $query = $this->db->query('
			SELECT 
				TS.idApp_Slides,
				TS.Slide1,
				TS.Texto_Slide1
			FROM 
				App_Slides AS TS
			WHERE
				TS.idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . '
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
	
}
