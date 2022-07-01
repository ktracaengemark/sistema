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

    public function get_empresa_verificacao($data) {
        $query = $this->db->query(
			'SELECT 
				E.*,
				D.TextoPedido_1,
				D.TextoPedido_2,
				D.TextoPedido_3,
				D.TextoPedido_4,
				D.ClientePedido,
				D.idClientePedido,
				D.idPedido,
				D.SitePedido,
				D.TextoAgenda_1,
				D.TextoAgenda_2,
				D.TextoAgenda_3,
				D.TextoAgenda_4,
				D.ClienteAgenda,
				D.ProfAgenda,
				D.DataAgenda,
				D.SiteAgenda
				
			FROM 
				Sis_Empresa AS E
					LEFT JOIN App_Documentos AS D ON D.idSis_Empresa = E.idSis_Empresa
			WHERE 
				E.idSis_Empresa = ' . $data . ' AND
				E.idSis_Empresa = ' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . ''
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

    public function get_empresa($data) {
        $query = $this->db->query('
			SELECT 
				E.*,
				D.TextoPedido_1,
				D.TextoPedido_2,
				D.TextoPedido_3,
				D.TextoPedido_4,
				D.ClientePedido,
				D.idClientePedido,
				D.idPedido,
				D.SitePedido,
				D.TextoAgenda_1,
				D.TextoAgenda_2,
				D.TextoAgenda_3,
				D.TextoAgenda_4,
				D.ClienteAgenda,
				D.ProfAgenda,
				D.DataAgenda,
				D.SiteAgenda
				
			FROM 
				Sis_Empresa AS E
					LEFT JOIN App_Documentos AS D ON D.idSis_Empresa = E.idSis_Empresa
			WHERE 
				E.idSis_Empresa = ' . $data . '
		');

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

    public function get_horario_atend($data) {

		$dia_da_semana = date('N');
		$horario = date('H:i:s');

		$query = $this->db->query('
            SELECT *
            FROM
				App_Atendimento
            WHERE
				idSis_Empresa = ' . $data . ' AND
				id_Dia = ' . $dia_da_semana . ' AND
				Aberto_Atend = "S"
			LIMIT 1
		');
		/*
        $query = $query->result_array();
          
        return $query;
		*/
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			foreach ($query->result() as $row) {
				$hora_abre 	= $row->Hora_Abre_Atend;
				$hora_fecha	= $row->Hora_Fecha_Atend;
				if($horario >= $hora_abre && $horario <= $hora_fecha){
					return TRUE;
				}else{
					return FALSE;
				}
			}
        }		
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
	
}
