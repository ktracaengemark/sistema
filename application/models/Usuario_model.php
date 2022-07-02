<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }


    ##############
    #RESPONSÁVEL
    ##############

    public function set_usuario($data) {

        $query = $this->db->insert('Sis_Usuario', $data);

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
	
    public function get_usuario_verificacao_admin($data) {
        $query = $this->db->query(
			'SELECT 
				U.*,
				A.idApp_Agenda
			FROM 
				Sis_Usuario AS U
				 LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = U.idSis_Associado
				 LEFT JOIN App_Agenda AS A ON A.idSis_Associado = ASS.idSis_Associado
			WHERE 
				U.idSis_Usuario = ' . $data . ' AND
				U.idSis_Empresa = ' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }

    }
		
    public function get_usuario_verificacao($data) {
        $query = $this->db->query(
			'SELECT 
				U.*,
				A.idApp_Agenda
			FROM 
				Sis_Usuario AS U
				 LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = U.idSis_Associado
				 LEFT JOIN App_Agenda AS A ON A.idSis_Associado = ASS.idSis_Associado
			WHERE 
				U.idSis_Usuario = ' . $data . ' AND
				U.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				U.idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }

    }
	
    public function get_usuario($data) {
        $query = $this->db->query(
			'SELECT 
				U.*,
				A.idApp_Agenda
			FROM 
				Sis_Usuario AS U
				 LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = U.idSis_Associado
				 LEFT JOIN App_Agenda AS A ON A.idSis_Associado = ASS.idSis_Associado
			WHERE 
				U.idSis_Usuario = ' . $data . ''
		);

        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }

    public function get_usuario_associado($data) {
        $query = $this->db->query('SELECT idSis_Usuario FROM Sis_Usuario WHERE idSis_Associado = ' . $data);

        $query = $query->result_array();

        return $query;
    }
	
    public function get_associado($data) {
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

    public function get_usuario_online($data) {
        $query = $this->db->query('SELECT * FROM Sis_Usuario_Online WHERE idSis_Usuario_Online = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_funcao($data) {
		$query = $this->db->query('
			SELECT 
				PC.*,
				PC.idSis_Usuario
			FROM 
				App_Funcao AS PC
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idSis_Usuario = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_arquivo($data) {
        $query = $this->db->query('SELECT * FROM Sis_Arquivo WHERE idSis_Arquivo = ' . $data);
        $query = $query->result_array();

        return $query[0];

    }    

    public function update_usuario($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Sis_Usuario', $data, array('idSis_Usuario' => $id));
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

    public function update_usuario_online($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Sis_Usuario_Online', $data, array('idSis_Usuario_Online' => $id));
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
	
    public function delete_usuario($data) {

        $query = $this->db->query('SELECT idApp_OrcaTrata FROM App_OrcaTrata WHERE idSis_Usuario = ' . $data);
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

        $this->db->delete('App_Consulta', array('idSis_Usuario' => $data));
        $this->db->delete('App_ContatoUsuario', array('idSis_Usuario' => $data));

        foreach ($query as $key) {
            $query = $this->db->delete('App_ProdutoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ServicoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ParcelasRecebiveis', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_Procedimento', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
        }

        $this->db->delete('App_OrcaTrata', array('idSis_Usuario' => $data));
        $this->db->delete('Sis_Usuario', array('idSis_Usuario' => $data));

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

    public function lista_usuario($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Sis_Usuario WHERE '
                #. 'Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
				. 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND '
                . '(Nome like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'Nome like "%' . $data . '%" OR '
                . 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'CelularUsuario like "%' . $data . '%") '
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
    
	public function list_funcao($x) {
		
        $query = $this->db->query('
			SELECT 
				TA.*,
				TOP.idSis_Usuario,
				AF.idApp_Funcao
			FROM 
				Tab_Funcao AS TA
					LEFT JOIN Sis_Usuario AS TOP ON TOP.Funcao = TA.idTab_Funcao
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
					
					if($row->idSis_Usuario || $row->idApp_Funcao){
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

    public function lista_contatousuario($id, $bool) {

        $query = $this->db->query(
            'SELECT * '
                . 'FROM App_ContatoUsuario WHERE '
                . 'idSis_Usuario = ' . $id . ' '
            . 'ORDER BY NomeContatoUsuario ASC ');
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

	public function select_usuario($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        if ($data === TRUE) {
            $array = $this->db->query('					
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
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
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
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
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }	

	public function select_usuario_entregador($data = FALSE) {
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
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$entregadar = ($data) ? 'P.idSis_Usuario = ' . $data . ' OR ' : FALSE;
        if ($data === TRUE) {
            $array = $this->db->query('					
				SELECT
					P.idSis_Usuario,
					CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
				FROM
					Sis_Usuario AS P
						LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
				WHERE 
					' . $permissao . '
					(' . $entregadar . '
					(P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND P.Inativo = "0" AND P.Entregas = "S"))  
				ORDER BY 
					F.Funcao ASC,
					P.Nome ASC
			');
					
        } else {
            $query = $this->db->query('
				SELECT
					P.idSis_Usuario,
					CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
				FROM
					Sis_Usuario AS P
						LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
				WHERE
					' . $permissao . '
					(' . $entregadar . '
					(P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND P.Inativo = "0" AND P.Entregas = "S"))  
				ORDER BY 
					F.Funcao ASC,
					P.Nome ASC
			');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }	

	public function select_usuario_servicos($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'AF.idApp_Funcao = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        $servico = ($data) ? 'AF.idApp_Funcao = ' . $data . ' OR ' : FALSE;
		if ($data === TRUE) {
            $array = $this->db->query('					
				SELECT
					AF.idApp_Funcao,
					CONCAT(IFNULL(TF.Abrev,"")) AS Abrev,
					CONCAT(IFNULL(U.Nome,"")) AS Nome,
					CONCAT(IFNULL(AF.Comissao_Funcao,"")) AS Comissao_Funcao
				
				FROM
					App_Funcao AS AF
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = AF.idSis_Usuario
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
					CONCAT(IFNULL(TF.Abrev,"")) AS Abrev,
					CONCAT(IFNULL(U.Nome,"")) AS Nome,
					CONCAT(IFNULL(AF.Comissao_Funcao,"")) AS Comissao_Funcao
				FROM
					App_Funcao AS AF
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = AF.idSis_Usuario
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
                $row->Nome = $row->Abrev." | ".substr($row->Nome, 0, 10)." | ".$row->Comissao_Funcao;
				$array[$row->idApp_Funcao] = $row->Nome;		
            }
        }

        return $array;
    }	

	public function select_usuario_servicos_orig($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        $servico = ($data) ? 'P.idSis_Usuario = ' . $data . ' OR ' : FALSE;
		if ($data === TRUE) {
            $array = $this->db->query('					
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
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
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
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
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }	

	public function select_usuario_procedimentos($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        $procedimentos = ($data) ? 'P.idSis_Usuario = ' . $data . ' OR ' : FALSE;
		if ($data === TRUE) {
            $array = $this->db->query('					
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE 
				' . $permissao . '
				(' . $procedimentos . '
				(P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND P.Inativo = "0" AND P.Procedimentos = "S"))
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');
					
        } else {
            $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
				' . $permissao . '
				(' . $procedimentos . '
				(P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND P.Inativo = "0" AND P.Procedimentos = "S"))  
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }	

	public function select_compartilhar($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao2 = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? $array[0] = '::Todos::' : FALSE;
        if ($data === TRUE) {
            $array = $this->db->query('					
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
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
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
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
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }
	
	public function select_profissional1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				(P.Nivel = "3" OR P.Nivel = "4")
  
			ORDER BY P.Nome ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				(P.Nivel = "3" OR P.Nivel = "4")
 
			ORDER BY P.Nome ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }

	public function select_profissional($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Usuario AS P
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
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "6"
 
			ORDER BY P.Nome ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }

	public function select_usuarioemp($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Usuario,
				Nome				
            FROM
                Sis_Usuario					
            WHERE
				Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Nome ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Usuario,
				Nome
            FROM
                Sis_Usuario					
            WHERE
                Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Nome ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }	
	
}
