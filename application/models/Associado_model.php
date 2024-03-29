<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Associado_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }


    ##############
    #RESPONS�VEL
    ##############

    public function set_associado($data) {

        $query = $this->db->insert('Sis_Associado', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_funcao($data) {

        $query = $this->db->insert_batch('App_Funcao', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_agenda($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('App_Agenda', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
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

    public function get_associado_verificacao($data) {
        $query = $this->db->query(
			'SELECT
				* 
			FROM
				Sis_Associado
			WHERE 
				idSis_Associado = ' . $data . ' AND
				idSis_Associado = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . ''
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
	
    public function get_associado($data) {
        $query = $this->db->query('SELECT * FROM Sis_Associado WHERE idSis_Associado = ' . $data);

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
	
    public function get_associado_celular($data) {
        $query = $this->db->query('SELECT * FROM Sis_Associado WHERE Associado = ' . $data . ' LIMIT 1');
        $count = $query->num_rows();
		$query = $query->result_array();
		
		if(isset($count)){
			if($count == 0){
				return FALSE;
			}else{
				return $query[0];
			}
		}else{
			return FALSE;
		}
		
    }

    public function get_associado_online($data) {
        $query = $this->db->query('SELECT * FROM Sis_Associado_Online WHERE idSis_Associado_Online = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_funcao($data) {
		$query = $this->db->query('
			SELECT 
				PC.*,
				PC.idSis_Associado
			FROM 
				App_Funcao AS PC
					LEFT JOIN Sis_Associado AS USC ON USC.idSis_Associado = PC.idSis_Associado
			WHERE 
				PC.idSis_Associado = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_arquivo($data) {
        $query = $this->db->query('SELECT * FROM Sis_Arquivo WHERE idSis_Arquivo = ' . $data);
        $query = $query->result_array();

        return $query[0];

    }    

    public function update_associado($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Sis_Associado', $data, array('idSis_Associado' => $id));
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

    public function update_associado_online($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Sis_Associado_Online', $data, array('idSis_Associado_Online' => $id));
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

    public function update_funcao($data) {

        $query = $this->db->update_batch('App_Funcao', $data, 'idApp_Funcao');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function delete_associado($data) {

        $query = $this->db->query('SELECT idApp_OrcaTrata FROM App_OrcaTrata WHERE idSis_Associado = ' . $data);
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

        $this->db->delete('App_Consulta', array('idSis_Associado' => $data));
        $this->db->delete('App_ContatoAssociado', array('idSis_Associado' => $data));

        foreach ($query as $key) {
            $query = $this->db->delete('App_ProdutoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ServicoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ParcelasRecebiveis', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_Procedimento', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
        }

        $this->db->delete('App_OrcaTrata', array('idSis_Associado' => $data));
        $this->db->delete('Sis_Associado', array('idSis_Associado' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_funcao($data) {

        $this->db->where_in('idApp_Funcao', $data);
        $this->db->delete('App_Funcao');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
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
    
	public function list_funcao($x) {
		
        $query = $this->db->query('
			SELECT 
				TA.*,
				TOP.idSis_Associado,
				AF.idApp_Funcao
			FROM 
				Tab_Funcao AS TA
					LEFT JOIN Sis_Associado AS TOP ON TOP.Funcao = TA.idTab_Funcao
					LEFT JOIN App_Funcao AS AF ON AF.idTab_Funcao = TA.idTab_Funcao
			WHERE 
                TA.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			GROUP BY
				TA.idTab_Funcao
			ORDER BY  
				TA.Funcao ASC 
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
		  echo "<br>";
          print_r($data);
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
					
					if($row->idSis_Associado || $row->idApp_Funcao){
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

    public function lista_contatoassociado($id, $bool) {

        $query = $this->db->query(
            'SELECT * '
                . 'FROM App_ContatoAssociado WHERE '
                . 'idSis_Associado = ' . $id . ' '
            . 'ORDER BY NomeContatoAssociado ASC ');
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
                    $row->Relacao = $this->Basico_model->get_relacao($row->Relacao);
                    #$row->Relacao2 = $this->Basico_model->get_relacao($row->Relacao2);
                }

                return $query;
            }
        }
    }

	public function select_associado($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Associado = ' . $_SESSION['log']['idSis_Associado'] . ' AND ' : FALSE;
        if ($data === TRUE) {
            $array = $this->db->query('					
            SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE 
				' . $permissao . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');
					
        } else {
            $query = $this->db->query('
            SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
				' . $permissao . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Associado] = $row->Nome;
            }
        }

        return $array;
    }	

	public function select_associado_tarefa($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Associado = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        if ($data === TRUE) {
            $array = $this->db->query('					
            SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Associado AS P
            WHERE 
				' . $permissao . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				P.Nome ASC
    ');
					
        } else {
            $query = $this->db->query('
            SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Associado AS P
            WHERE
				' . $permissao . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				P.Nome ASC
    ');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Associado] = $row->Nome;
            }
        }

        return $array;
    }	

	public function select_associado_entregador($data = FALSE) {
		/*		
		//echo $this->db->last_query();
	  echo "<pre>";
	  print_r($data);
	  echo "<br>";
	  //print_r($data['Entregador']);
	  echo "<br>";
	  //print_r($date_inicio_orca);
	  echo "<br>";
	 // print_r($date_fim_orca);
	  echo "</pre>";
	  exit();
		*/
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Associado = ' . $_SESSION['log']['idSis_Associado'] . ' AND ' : FALSE;
		$entregadar = ($data) ? 'P.idSis_Associado = ' . $data . ' OR ' : FALSE;
        if ($data === TRUE) {
            $array = $this->db->query('					
				SELECT
					P.idSis_Associado,
					CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
				FROM
					Sis_Associado AS P
						LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
				WHERE 
					' . $permissao . '
					P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					' . $entregadar . '
					(P.Inativo = "0" AND
					P.Entregas = "S")  
				ORDER BY 
					F.Funcao ASC,
					P.Nome ASC
			');
					
        } else {
            $query = $this->db->query('
				SELECT
					P.idSis_Associado,
					CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
				FROM
					Sis_Associado AS P
						LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
				WHERE
					' . $permissao . '
					P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					' . $entregadar . '
					(P.Inativo = "0" AND
					P.Entregas = "S")  
				ORDER BY 
					F.Funcao ASC,
					P.Nome ASC
			');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Associado] = $row->Nome;
            }
        }

        return $array;
    }	

	public function select_associado_servicos($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'AF.idApp_Funcao = ' . $_SESSION['log']['idSis_Associado'] . ' AND ' : FALSE;
        $servico = ($data) ? 'AF.idApp_Funcao = ' . $data . ' OR ' : FALSE;
		if ($data === TRUE) {
            $array = $this->db->query('					
				SELECT
					AF.idApp_Funcao,
					CONCAT(IFNULL(TF.Abrev,""), " || ", IFNULL(U.Nome,""), " ||| ", IFNULL(AF.Comissao_Funcao,"")) AS Nome
				FROM
					App_Funcao AS AF
						LEFT JOIN Sis_Associado AS U ON U.idSis_Associado = AF.idSis_Associado
						LEFT JOIN Tab_Funcao AS TF ON TF.idTab_Funcao = AF.idTab_Funcao
				WHERE 
					' . $servico . '
					' . $permissao . '
					AF.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					
					U.Inativo = "0" AND
					U.Servicos = "S"
				ORDER BY 
					TF.Abrev ASC,
					U.Nome ASC
			');
					
        } else {
            $query = $this->db->query('
				SELECT
					AF.idApp_Funcao,
					CONCAT(IFNULL(TF.Abrev,""), " || ", IFNULL(U.Nome,""), " ||| ", IFNULL(AF.Comissao_Funcao,"")) AS Nome
				FROM
					App_Funcao AS AF
						LEFT JOIN Sis_Associado AS U ON U.idSis_Associado = AF.idSis_Associado
						LEFT JOIN Tab_Funcao AS TF ON TF.idTab_Funcao = AF.idTab_Funcao
				WHERE 
					' . $servico . '
					' . $permissao . '
					AF.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					
					U.Inativo = "0" AND
					U.Servicos = "S"
				ORDER BY 
					TF.Abrev ASC,
					U.Nome ASC
			');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Funcao] = $row->Nome;
            }
        }

        return $array;
    }	

	public function select_associado_servicos_orig($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Associado = ' . $_SESSION['log']['idSis_Associado'] . ' AND ' : FALSE;
        $servico = ($data) ? 'P.idSis_Associado = ' . $data . ' OR ' : FALSE;
		if ($data === TRUE) {
            $array = $this->db->query('					
            SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE 
				' . $permissao . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $servico . '
				P.Inativo = "0" AND
				P.Servicos = "S"
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');
					
        } else {
            $query = $this->db->query('
            SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
				' . $permissao . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $servico . '
				P.Inativo = "0" AND
				P.Servicos = "S"  
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Associado] = $row->Nome;
            }
        }

        return $array;
    }	

	public function select_associado_procedimentos($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Associado = ' . $_SESSION['log']['idSis_Associado'] . ' AND ' : FALSE;
        $procedimentos = ($data) ? 'P.idSis_Associado = ' . $data . ' OR ' : FALSE;
		if ($data === TRUE) {
            $array = $this->db->query('					
            SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE 
				' . $permissao . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $procedimentos . '
				P.Inativo = "0" AND
				P.Procedimentos = "S"
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');
					
        } else {
            $query = $this->db->query('
            SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
				' . $permissao . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $procedimentos . '
				P.Inativo = "0" AND
				P.Procedimentos = "S"  
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Associado] = $row->Nome;
            }
        }

        return $array;
    }	

	public function select_compartilhar($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Associado = ' . $_SESSION['log']['idSis_Associado'] . ' AND ' : FALSE;
		$permissao2 = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? $array[0] = '::Todos::' : FALSE;
        if ($data === TRUE) {
            $array = $this->db->query('					
            SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE 
				' . $permissao . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
			');
					
        } else {
            $query = $this->db->query('
            SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
				' . $permissao . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
			');
            
            $array = array();
			$permissao;
            foreach ($query->result() as $row) {
                $array[$row->idSis_Associado] = $row->Nome;
            }
        }

        return $array;
    }
	
	public function select_profissional1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.idSis_Associado = ' . $_SESSION['log']['idSis_Associado'] . ' AND
				(P.Nivel = "3" OR P.Nivel = "4")
  
			ORDER BY P.Nome ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.idSis_Associado = ' . $_SESSION['log']['idSis_Associado'] . ' AND
				(P.Nivel = "3" OR P.Nivel = "4")
 
			ORDER BY P.Nome ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Associado] = $row->Nome;
            }
        }

        return $array;
    }

	public function select_profissional($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "6"
  
			ORDER BY P.Nome ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
				P.idSis_Associado,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Associado AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "6"
 
			ORDER BY P.Nome ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Associado] = $row->Nome;
            }
        }

        return $array;
    }

	public function select_associadoemp($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Associado,
				Nome				
            FROM
                Sis_Associado					
            WHERE
				Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Nome ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Associado,
				Nome
            FROM
                Sis_Associado					
            WHERE
                Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Nome ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Associado] = $row->Nome;
            }
        }

        return $array;
    }	
	
}
