<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_cliente($data) {

        $query = $this->db->insert('App_Cliente', $data);

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

    public function set_usuario($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('Sis_Usuario', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
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

    public function get_cliente_verificacao($data) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(NivelCliente = "1" OR idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}

		$query = $this->db->query(
			'SELECT 
				idApp_Cliente 
			FROM 
				App_Cliente 
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $revendedor . '
				idApp_Cliente = ' . $data . ''
		);

        $query = $query->result_array();
		
		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }

    public function get_cliente($data) {
		
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = '(NivelCliente = "1" OR idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
		}else{
			$revendedor = FALSE;
		}

		$query = $this->db->query(
			'SELECT 
				* 
			FROM 
				App_Cliente 
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $revendedor . '
				idApp_Cliente = ' . $data . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }

    }

    public function get_cliente_associado($data) {
        $query = $this->db->query('SELECT idApp_Cliente FROM App_Cliente WHERE idSis_Associado = ' . $data);

        $query = $query->result_array();

        return $query;
    }

    public function get_usuario($data) {
        $query = $this->db->query('SELECT * FROM Sis_Usuario WHERE idSis_Usuario = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_arquivo($data) {
        $query = $this->db->query('SELECT * FROM Sis_Arquivo WHERE idSis_Arquivo = ' . $data);
        $query = $query->result_array();

        return $query[0];

    }    
	
    public function get_empresa_verificacao($data) {
        $query = $this->db->query(
			'SELECT 
				idSis_Empresa 
			FROM 
				Sis_Empresa 
			WHERE 
				idSis_Empresa = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);
        $query = $query->result_array();

		if($query){
			return $query[0];
		}else{
			return FALSE;
		}
    }
	
    public function get_empresa($data) {
        $query = $this->db->query(
			'SELECT 
				idSis_Empresa 
			FROM 
				Sis_Empresa 
			WHERE 
				idSis_Empresa = ' . $data . ' AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
		);

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }
    }
	
    public function get_empresa5($data) {
        $query = $this->db->query('SELECT * FROM Sis_Usuario WHERE idSis_Empresa = "5" AND CelularUsuario = ' . $data);
        $query = $query->result_array();

        return $query[0];

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
	
    public function get_profissional($data) {
        $query = $this->db->query(
			'SELECT 
				ASS.Nome,
				A.idApp_Agenda
			FROM 
				Sis_Associado AS ASS
					LEFT JOIN App_Agenda AS A ON A.idSis_Associado = ASS.idSis_Associado
			WHERE 
				A.idApp_Agenda = ' . $data . ' 
			LIMIT 1'
		);
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

	public function get_alterarcashback($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'TOT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
			
		$date_inicio_orca = ($_SESSION['FiltroRankingVendas']['DataInicio']) ? 'TOT.DataOrca >= "' . $_SESSION['FiltroRankingVendas']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroRankingVendas']['DataFim']) ? 'TOT.DataOrca <= "' . $_SESSION['FiltroRankingVendas']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_cash = ($_SESSION['FiltroRankingVendas']['DataInicio2']) ? 'TC.ValidadeCashBack >= "' . $_SESSION['FiltroRankingVendas']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_cash = ($_SESSION['FiltroRankingVendas']['DataFim2']) ? 'TC.ValidadeCashBack <= "' . $_SESSION['FiltroRankingVendas']['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_ultimo = ($_SESSION['FiltroRankingVendas']['DataInicio3']) ? 'TC.UltimoPedido >= "' . $_SESSION['FiltroRankingVendas']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_ultimo = ($_SESSION['FiltroRankingVendas']['DataFim3']) ? 'TC.UltimoPedido <= "' . $_SESSION['FiltroRankingVendas']['DataFim3'] . '" AND ' : FALSE;
						
		$pedidos_de = ($_SESSION['FiltroRankingVendas']['Pedidos_de']) ? 'F.ContPedidos >= "' . $_SESSION['FiltroRankingVendas']['Pedidos_de'] . '" AND ' : FALSE;
		$pedidos_ate = ($_SESSION['FiltroRankingVendas']['Pedidos_ate']) ? 'F.ContPedidos <= "' . $_SESSION['FiltroRankingVendas']['Pedidos_ate'] . '" AND ' : FALSE;	
		
		$valor_de = ($_SESSION['FiltroRankingVendas']['Valor_de']) ? 'F.Valor >= "' . $_SESSION['FiltroRankingVendas']['Valor_de'] . '" AND ' : FALSE;
		$valor_ate = ($_SESSION['FiltroRankingVendas']['Valor_ate']) ? 'F.Valor <= "' . $_SESSION['FiltroRankingVendas']['Valor_ate'] . '" AND ' : FALSE;	
		
		$valor_cash_de = ($_SESSION['FiltroRankingVendas']['Valor_cash_de']) ? 'F.CashBackCliente >= "' . $_SESSION['FiltroRankingVendas']['Valor_cash_de'] . '" AND ' : FALSE;
		$valor_cash_ate = ($_SESSION['FiltroRankingVendas']['Valor_cash_ate']) ? 'F.CashBackCliente <= "' . $_SESSION['FiltroRankingVendas']['Valor_cash_ate'] . '" AND ' : FALSE;	

		//$nome_cliente = ($_SESSION['FiltroRankingVendas']['NomeCliente']) ? ' AND TC.idApp_Cliente = ' . $_SESSION['FiltroRankingVendas']['NomeCliente'] : FALSE;
        $idapp_cliente = ($_SESSION['FiltroRankingVendas']['idApp_Cliente']) ? ' AND TC.idApp_Cliente = ' . $_SESSION['FiltroRankingVendas']['idApp_Cliente'] : FALSE;
        $campo = (!$_SESSION['FiltroRankingVendas']['Campo']) ? 'F.Valor' : $_SESSION['FiltroRankingVendas']['Campo'];
        $ordenamento = (!$_SESSION['FiltroRankingVendas']['Ordenamento']) ? 'DESC' : $_SESSION['FiltroRankingVendas']['Ordenamento'];
        
		if($_SESSION['log']['idSis_Empresa'] != 5){
			if($_SESSION['FiltroRankingVendas']['Ultimo'] != 0){	
				if($_SESSION['FiltroRankingVendas']['Ultimo'] == 1){	
					$ultimopedido1 = 'LEFT JOIN App_OrcaTrata AS TOT2 ON (TOT.idApp_Cliente = TOT2.idApp_Cliente AND TOT.idApp_OrcaTrata < TOT2.idApp_OrcaTrata)';
					$ultimopedido2 = 'AND TOT2.idApp_OrcaTrata IS NULL';
				}else{
					$ultimopedido1 = FALSE;
					$ultimopedido2 = FALSE;
				}
			}else{
				$ultimopedido1 = FALSE;
				$ultimopedido2 = FALSE;
			}	
		}else{
			$ultimopedido1 = FALSE;
			$ultimopedido2 = FALSE;
		}		
		
        if ($limit){
			$querylimit = 'LIMIT ' . $start . ', ' . $limit;
		}else{
			$querylimit = '';
		}

        $query = $this->db->query('
			SELECT
				F.idApp_Cliente,
				F.NomeCliente,
				F.CashBackCliente,
				F.addCashBackCliente,
				F.PrazoCashBack,
				F.ValidadeCashBack,
				F.id_UltimoPedido,
				F.UltimoPedido,
				F.ContPedidos,
				F.Valor
			FROM
				(SELECT
					TC.idApp_Cliente,
					TC.NomeCliente,
					TC.CashBackCliente,
					TC.addCashBackCliente,
					TC.PrazoCashBack,
					TC.ValidadeCashBack,
					TC.id_UltimoPedido,
					TC.UltimoPedido,
					TOT.DataOrca,
					COUNT(TOT.idApp_OrcaTrata) AS ContPedidos,
					SUM(TOT.ValorFinalOrca) AS Valor
				FROM
					App_Cliente AS TC
						INNER JOIN App_OrcaTrata AS TOT ON TOT.idApp_Cliente = TC.idApp_Cliente
				WHERE
					' . $permissao_orcam . '
					' . $date_inicio_orca . '
					' . $date_fim_orca . '
					' . $date_inicio_cash . '
					' . $date_fim_cash . '
					' . $date_inicio_ultimo . '
					' . $date_fim_ultimo . '
					TOT.CanceladoOrca = "N" AND
					TC.idSis_Empresa = ' . $data . ' 
					' . $idapp_cliente . '
				GROUP BY
					TC.idApp_Cliente
				) AS F
			WHERE
				' . $pedidos_de . '
				' . $pedidos_ate . '
				' . $valor_de . '
				' . $valor_ate . '
				' . $valor_cash_de . '
				' . $valor_cash_ate . '
				F.idApp_Cliente != 0
			ORDER BY
				' . $campo . '
				' . $ordenamento . '
			' . $querylimit . '
        ');
	
		if($total == TRUE) {
			return $query->num_rows();
		}	
			
        $query = $query->result_array();
 
        return $query;		

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

    public function update_usuario($data, $id) {

        unset($data['idSis_Usuario']);
        $query = $this->db->update('Sis_Usuario', $data, array('idSis_Usuario' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_cliente($data) {

        $query = $this->db->query('SELECT idApp_OrcaTrata FROM App_OrcaTrata WHERE idApp_Cliente = ' . $data);
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

        $this->db->delete('App_Consulta', array('idApp_Cliente' => $data));
        $this->db->delete('App_ContatoCliente', array('idApp_Cliente' => $data));

        foreach ($query as $key) {
            $query = $this->db->delete('App_ProdutoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ServicoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ParcelasRecebiveis', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_Procedimento', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
        }

        $this->db->delete('App_OrcaTrata', array('idApp_Cliente' => $data));
        $this->db->delete('App_Cliente', array('idApp_Cliente' => $data));

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
	
    public function lista_cliente_2($data, $data2, $data3, $x, $qtde=0, $page=0) {
			/*
			echo "<pre>";
			print_r($data);
			echo "<br>";
			print_r($data2);
			echo "<br>";
			print_r($data3);
			echo "<br>";
			print_r($x);
			echo "<br>";
			print_r($qtde);
			echo "<br>";
			print_r($page);
			echo "<br>";
			echo "</pre>";
			exit();
			*/	
		$ficha = ($data) ? ' AND RegistroFicha like "%' . $data . '%" ' : '';
		$nomedocliente = ($data2) ? ' AND NomeCliente like "%' . $data2 . '%" ' : '';
		$telefonedocliente = ($data3) ? ' AND (CelularCliente like "%' . $data3 . '%" OR Telefone like "%' . $data3 . '%" OR Telefone2 like "%' . $data3 . '%" OR Telefone3 like "%' . $data3 . '%") ' : '';
		$querylimit = ($qtde)? 'LIMIT ' . $page . ', ' . $qtde : '';
        $query = $this->db->query('SELECT * '
                . 'FROM App_Cliente WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
				. $nomedocliente
				. $ficha
				. $telefonedocliente
                . 'ORDER BY NomeCliente ASC '
				. $querylimit
				);
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

    public function lista_cliente_total() {
	
        $query = $this->db->query('SELECT * '
                . 'FROM App_Cliente WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' ');
		/*
          echo "<pre>";
          print_r($query->num_rows());
          echo "</pre>";
          exit();
		  */
		
		if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			return $query->num_rows();
        }
    }
	
    public function lista_cliente($data, $existe = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

        if (preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](1[89][0-9][0-9]|2[0189][0-9][0-9])$/", $data)) {
            $query = '(DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                    . 'DataCadastroCliente = "' . $this->basico->mascara_data($data, 'mysql') . '" )';
        }elseif (is_numeric($data)) {
            if($date === TRUE) {
                $query = '(DataNascimento = "' . substr($data, 4, 4).'-'.substr($data, 2, 2).'-'.substr($data, 0, 2) . '" OR '
                        . 'DataCadastroCliente = "' . substr($data, 4, 4).'-'.substr($data, 2, 2).'-'.substr($data, 0, 2) . '" )';
            }else{
				if((strlen($data)) < 6){
					/*
					$query = '(idApp_Cliente like "' . $data . '" OR '
							. 'RegistroFicha like "' . $data . '" )';
					
					*/
					$query = 'RegistroFicha like "' . $data . '"';
				}elseif(strlen($data) >= 6 && strlen($data) <= 7){
					$query = 'idApp_Cliente like "' . $data . '"';
					
				}else{
					$query = '(CelularCliente like "%' . $data . '%" OR '
							. 'Telefone like "%' . $data . '%" OR '
							. 'Telefone2 like "%' . $data . '%" OR '
							. 'Telefone3 like "%' . $data . '%" )';
				}
			}			
        }else{
			$query = '(NomeCliente like "%' . $data . '%" )';
		}
            

        $querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

        if ($existe === TRUE) {

            $query = $this->db->query('SELECT * '
                    . 'FROM App_Cliente WHERE '
					. 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
                    . $query
                    . 'ORDER BY NomeCliente ASC');

            if ($query->num_rows() == 0)
                return FALSE;
            else
                return TRUE;
        }else {

            if ($total === TRUE) {

                $query = $this->db->query('SELECT * '
                        . 'FROM App_Cliente WHERE '
						. 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
                        . $query
                        . 'ORDER BY NomeCliente ASC');

                return $query->num_rows();
            }else {

                $query = $this->db->query('SELECT * '
                        . 'FROM App_Cliente WHERE '
						. 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
                        . $query
                        . 'ORDER BY NomeCliente ASC '
                        . $querylimit);

                /*
                echo $this->db->last_query();
                echo "<pre>";
                print_r($query);
                echo "</pre>";
                exit();
                */

                foreach ($query->result() as $row) {
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                    $row->DataCadastroCliente = $this->basico->mascara_data($row->DataCadastroCliente, 'barras');
                }

                return $query;
            }
        }

    }	

	public function list_clientes($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		if($data['Pesquisa']){
			if (preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](1[89][0-9][0-9]|2[0189][0-9][0-9])$/", $data['Pesquisa'])) {
				$pesquisa = '(DataNascimento = "' . $this->basico->mascara_data($data['Pesquisa'], 'mysql') . '" OR '
						. 'DataCadastroCliente = "' . $this->basico->mascara_data($data['Pesquisa'], 'mysql') . '" )';
			}elseif (is_numeric($data['Pesquisa'])) {
				if($date === TRUE) {
					$pesquisa = '(DataNascimento = "' . substr($data['Pesquisa'], 4, 4).'-'.substr($data['Pesquisa'], 2, 2).'-'.substr($data['Pesquisa'], 0, 2) . '" OR '
							. 'DataCadastroCliente = "' . substr($data['Pesquisa'], 4, 4).'-'.substr($data['Pesquisa'], 2, 2).'-'.substr($data['Pesquisa'], 0, 2) . '" )';
				}else{
					if((strlen($data['Pesquisa'])) < 6){
						$pesquisa = 'RegistroFicha like "' . $data['Pesquisa'] . '"';
					}elseif(strlen($data['Pesquisa']) >= 6 && strlen($data['Pesquisa']) <= 7){
						$pesquisa = 'idApp_Cliente like "' . $data['Pesquisa'] . '"';
						
					}else{
						$pesquisa = '(CelularCliente like "%' . $data['Pesquisa'] . '%" OR '
								. 'Telefone like "%' . $data['Pesquisa'] . '%" OR '
								. 'Telefone2 like "%' . $data['Pesquisa'] . '%" OR '
								. 'Telefone3 like "%' . $data['Pesquisa'] . '%" )';
					}
				}			
			}else{
				$pesquisa = '(NomeCliente like "%' . $data['Pesquisa'] . '%" )';
			}
			$pesquisar = 'AND ' . $pesquisa;
		}else{
			$pesquisar = FALSE;
		}		

		$date_inicio_orca = ($data['DataInicio']) ? 'C.DataCadastroCliente >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($data['DataFim']) ? 'C.DataCadastroCliente <= "' . $data['DataFim'] . '" AND ' : FALSE;

		$date_inicio_cash = ($data['DataInicio2']) ? 'C.ValidadeCashBack >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_cash = ($data['DataFim2']) ? 'C.ValidadeCashBack <= "' . $data['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_ultimo = ($data['DataInicio3']) ? 'C.UltimoPedido >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_ultimo = ($data['DataFim3']) ? 'C.UltimoPedido <= "' . $data['DataFim3'] . '" AND ' : FALSE;		
		
		$dia = ($data['Dia']) ? ' AND DAY(C.DataNascimento) = ' . $data['Dia'] : FALSE;
		$mes = ($data['Mes']) ? ' AND MONTH(C.DataNascimento) = ' . $data['Mes'] : FALSE;
		$ano = ($data['Ano']) ? ' AND YEAR(C.DataNascimento) = ' . $data['Ano'] : FALSE;
		

		$id_cliente = ($data['idApp_Cliente']) ? ' AND C.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
		
		if($_SESSION['Empresa']['CadastrarPet'] == "S"){
			$id_clientepet = ($data['idApp_ClientePet']) ? ' AND CP.idApp_ClientePet = ' . $data['idApp_ClientePet'] : FALSE;
			$id_clientepet2 = ($data['idApp_ClientePet2']) ? 'AND CP.idApp_ClientePet = ' . $data['idApp_ClientePet2'] : FALSE;
			$id_clientedep = FALSE;
			$id_clientedep2 =  FALSE;
		}else{
			if($_SESSION['Empresa']['CadastrarDep'] == "S"){
				$id_clientedep = ($data['idApp_ClienteDep']) ? ' AND CD.idApp_ClienteDep = ' . $data['idApp_ClienteDep'] : FALSE;
				$id_clientedep2 = ($data['idApp_ClienteDep2']) ? 'AND CD.idApp_ClienteDep = ' . $data['idApp_ClienteDep2'] : FALSE;
			}else{	
				$id_clientedep = FALSE;
				$id_clientedep2 = FALSE;
			}
			$id_clientepet = FALSE;
			$id_clientepet2 = FALSE;
		}
		if(isset($data['Sexo'])){
			if($data['Sexo'] == 0){
				$sexo = FALSE;
			}elseif($data['Sexo'] == 1){
				$sexo = 'C.Sexo = "M" AND ';
			}elseif($data['Sexo'] == 2){
				$sexo = 'C.Sexo = "F" AND ';
			}elseif($data['Sexo'] == 3){
				$sexo = 'C.Sexo = "O" AND ';
			}
		}else{
			$sexo = FALSE;
		}
		if(isset($data['Pedidos'])){
			if($data['Pedidos'] == 0){
				$pedidos = FALSE;
			}elseif($data['Pedidos'] == 1){
				$pedidos = 'C.UltimoPedido = "0000-00-00" AND ';
			}elseif($data['Pedidos'] == 2){
				$pedidos = 'C.UltimoPedido != "0000-00-00" AND ';
			}
		}else{
			$pedidos = FALSE;
		}			
		$campo = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
		$ordenamento = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro10 = (isset($data['Ativo']) && $data['Ativo'] != '#') ? 'C.Ativo = "' . $data['Ativo'] . '" AND ' : FALSE;
		$filtro20 = (isset($data['Motivo']) && $data['Motivo'] != '0') ? 'C.Motivo = "' . $data['Motivo'] . '" AND ' : FALSE;
		
		$groupby = (isset($data['Agrupar']) && $data['Agrupar'] != "0") ? 'GROUP BY C.' . $data['Agrupar'] . '' : FALSE;

		if($data){
			if($data['Aparecer'] == 1){
				if($_SESSION['Empresa']['CadastrarPet'] == "S"){
					$clientepet = 'LEFT JOIN App_ClientePet AS CP ON CP.idApp_Cliente = C.idApp_Cliente';
					$cp_id_clientepet = 'CP.idApp_ClientePet,';
					$cp_nomeclientepet = 'CP.NomeClientePet,';
					$clientedep = FALSE;
					$cd_id_clientedep = FALSE;
					$cd_nomeclientedep = FALSE;
				}else{
					$clientepet = FALSE;
					$cp_id_clientepet = FALSE;
					$cp_nomeclientepet = FALSE;
					if($_SESSION['Empresa']['CadastrarDep'] == "S"){
						$clientedep = 'LEFT JOIN App_ClienteDep AS CD ON CD.idApp_Cliente = C.idApp_Cliente';
						$cd_id_clientedep = 'CD.idApp_ClienteDep,';
						$cd_nomeclientedep = 'CD.NomeClienteDep,';
					}else{
						$clientedep = FALSE;
						$cd_id_clientedep = FALSE;
						$cd_nomeclientedep = FALSE;
					}
				}
			}else{
				$clientepet = FALSE;
				$cp_id_clientepet = FALSE;
				$cp_nomeclientepet = FALSE;
				$clientedep = FALSE;
				$cd_id_clientedep = FALSE;
				$cd_nomeclientedep = FALSE;
			}
		}else{
			if($_SESSION['Empresa']['CadastrarPet'] == "S"){
				$clientepet = 'LEFT JOIN App_ClientePet AS CP ON CP.idApp_Cliente = C.idApp_Cliente';
				$cp_id_clientepet = 'CP.idApp_ClientePet,';
				$cp_nomeclientepet = 'CP.NomeClientePet,';
				$clientedep = FALSE;
				$cd_id_clientedep = FALSE;
				$cd_nomeclientedep = FALSE;
			}else{
				$clientepet = FALSE;
				$cp_id_clientepet = FALSE;
				$cp_nomeclientepet = FALSE;
				if($_SESSION['Empresa']['CadastrarDep'] == "S"){
					$clientedep = 'LEFT JOIN App_ClienteDep AS CD ON CD.idApp_Cliente = C.idApp_Cliente';
					$cd_id_clientedep = 'CD.idApp_ClienteDep,';
					$cd_nomeclientedep = 'CD.NomeClienteDep,';
				}else{
					$clientedep = FALSE;
					$cd_id_clientedep = FALSE;
					$cd_nomeclientedep = FALSE;
				}
			}
		}
			
		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = 'AND (C.NivelCliente = "1" OR C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ')';
		}else{
			$revendedor = FALSE;
		}
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
		

		if($total == TRUE) {

			$query_total = $this->db->query('
				SELECT
					C.idApp_Cliente
				FROM
					App_Cliente AS C
						LEFT JOIN Tab_Municipio AS M ON C.MunicipioCliente = M.idTab_Municipio
						LEFT JOIN Tab_Motivo AS MT ON  MT.idTab_Motivo = C.Motivo
						' . $clientepet . '
						' . $clientedep . '
				WHERE
					' . $date_inicio_orca . '
					' . $date_fim_orca . '
					' . $date_inicio_cash . '
					' . $date_fim_cash . '
					' . $date_inicio_ultimo . '
					' . $date_fim_ultimo . '
					' . $filtro10 . '
					' . $filtro20 . '
					' . $pedidos . '
					' . $sexo . '
					C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
					' . $id_cliente . ' 
					' . $id_clientepet . '
					' . $id_clientedep . '
					' . $id_clientepet2 . '
					' . $id_clientedep2 . '
					' . $dia . ' 
					' . $mes . '
					' . $ano . '
					' . $pesquisar . '
					' . $revendedor . '
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
				if($count >= 30001){
					return FALSE;
				}else{
					if ($completo === FALSE) {
						return TRUE;
					} else {
						return $count;
					}
				}
			}
		}

		$query = $this->db->query('
            SELECT
				C.idSis_Empresa,
				C.idApp_Cliente,
                C.NomeCliente,
				' . $cp_id_clientepet . '
				' . $cp_nomeclientepet . '
				' . $cd_id_clientedep . '
				' . $cd_nomeclientedep . '
				C.Arquivo,
				C.Ativo,
				C.Motivo,
                C.DataNascimento,
				C.DataCadastroCliente,
				DATE_FORMAT(C.DataNascimento, "%d/%m/%Y") AS Aniversario,
				DATE_FORMAT(C.DataCadastroCliente, "%d/%m/%Y") AS Cadastro,
                C.CelularCliente,
                C.Telefone,
                C.Telefone2,
                C.Telefone3,
                C.Sexo,
                C.EnderecoCliente,
				C.NumeroCliente,
				C.ComplementoCliente,
                C.BairroCliente,
				C.CidadeCliente,
				C.EstadoCliente,
				C.ReferenciaCliente,
				C.CepCliente,
				C.Obs,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS MunicipioCliente,
                C.Email,
				C.RegistroFicha,
				C.usuario,
				C.senha,
				C.CodInterno,
				C.CashBackCliente,
				C.ValidadeCashBack,
				C.id_UltimoPedido,
				C.UltimoPedido,
				MT.Motivo
            FROM
				App_Cliente AS C
                    LEFT JOIN Tab_Municipio AS M ON C.MunicipioCliente = M.idTab_Municipio
                    LEFT JOIN Tab_Motivo AS MT ON  MT.idTab_Motivo = C.Motivo
					' . $clientepet . '
					' . $clientedep . '
			WHERE
				' . $date_inicio_orca . '
				' . $date_fim_orca . '
				' . $date_inicio_cash . '
				' . $date_fim_cash . '
				' . $date_inicio_ultimo . '
				' . $date_fim_ultimo . '
				' . $filtro10 . '
				' . $filtro20 . '
				' . $pedidos . '
				' . $sexo . '
				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				' . $id_cliente . ' 
				' . $id_clientepet . '
				' . $id_clientedep . '
				' . $id_clientepet2 . '
				' . $id_clientedep2 . '
				' . $dia . ' 
				' . $mes . '
				' . $ano . '
				' . $pesquisar . '
				' . $revendedor . '
			' . $groupby . '
            ORDER BY
                ' . $campo . '
				' . $ordenamento . '
			' . $querylimit . '
        ');

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
				$row->DataCadastroCliente = $this->basico->mascara_data($row->DataCadastroCliente, 'barras');
				$row->UltimoPedido = $this->basico->mascara_data($row->UltimoPedido, 'barras');
				$row->ValidadeCashBack = $this->basico->mascara_data($row->ValidadeCashBack, 'barras');
				$row->Ativo = $this->basico->mascara_palavra_completa($row->Ativo, 'NS');
                $row->NomeEmpresa = $_SESSION['Empresa']['NomeEmpresa'];
				#$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->CelularCliente = ($row->CelularCliente) ? $row->CelularCliente : FALSE;
				$row->Telefone2 = ($row->Telefone2) ? $row->Telefone2 : FALSE;
				$row->Telefone3 = ($row->Telefone3) ? $row->Telefone3 : FALSE;

                #$row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                #$row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

    public function list_rankingvendas($data, $completo, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {
		
		if($data != FALSE){
			
			$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'TOT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
			
			$date_inicio_orca = ($data['DataInicio']) ? 'TOT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($data['DataFim']) ? 'TOT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;

			$date_inicio_cash = ($data['DataInicio2']) ? 'TC.ValidadeCashBack >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_cash = ($data['DataFim2']) ? 'TC.ValidadeCashBack <= "' . $data['DataFim2'] . '" AND ' : FALSE;

			$date_inicio_ultimo = ($data['DataInicio3']) ? 'TC.UltimoPedido >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_ultimo = ($data['DataFim3']) ? 'TC.UltimoPedido <= "' . $data['DataFim3'] . '" AND ' : FALSE;
							
			$data['Pedidos_de'] = ($data['Pedidos_de']) ? 'F.ContPedidos >= "' . $data['Pedidos_de'] . '" AND ' : FALSE;
			$data['Pedidos_ate'] = ($data['Pedidos_ate']) ? 'F.ContPedidos <= "' . $data['Pedidos_ate'] . '" AND ' : FALSE;	
			
			$data['Valor_de'] = ($data['Valor_de']) ? 'F.Valor >= "' . $data['Valor_de'] . '" AND ' : FALSE;
			$data['Valor_ate'] = ($data['Valor_ate']) ? 'F.Valor <= "' . $data['Valor_ate'] . '" AND ' : FALSE;
			
			$data['Valor_cash_de'] = ($data['Valor_cash_de']) ? 'F.CashBackCliente >= "' . $data['Valor_cash_de'] . '" AND ' : FALSE;
			$data['Valor_cash_ate'] = ($data['Valor_cash_ate']) ? 'F.CashBackCliente <= "' . $data['Valor_cash_ate'] . '" AND ' : FALSE;	

			//$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND TC.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
			$data['idApp_Cliente'] = ($data['idApp_Cliente']) ? ' AND TC.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
			$data['Campo'] = (!$data['Campo']) ? 'F.Valor' : $data['Campo'];
			$data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];

		}else{
		
			$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'TOT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
			
			$date_inicio_orca = ($_SESSION['FiltroRankingVendas']['DataInicio']) ? 'TOT.DataOrca >= "' . $_SESSION['FiltroRankingVendas']['DataInicio'] . '" AND ' : FALSE;
			$date_fim_orca = ($_SESSION['FiltroRankingVendas']['DataFim']) ? 'TOT.DataOrca <= "' . $_SESSION['FiltroRankingVendas']['DataFim'] . '" AND ' : FALSE;

			$date_inicio_cash = ($_SESSION['FiltroRankingVendas']['DataInicio2']) ? 'TC.ValidadeCashBack >= "' . $_SESSION['FiltroRankingVendas']['DataInicio2'] . '" AND ' : FALSE;
			$date_fim_cash = ($_SESSION['FiltroRankingVendas']['DataFim2']) ? 'TC.ValidadeCashBack <= "' . $_SESSION['FiltroRankingVendas']['DataFim2'] . '" AND ' : FALSE;

			$date_inicio_ultimo = ($_SESSION['FiltroRankingVendas']['DataInicio3']) ? 'TC.UltimoPedido >= "' . $_SESSION['FiltroRankingVendas']['DataInicio3'] . '" AND ' : FALSE;
			$date_fim_ultimo = ($_SESSION['FiltroRankingVendas']['DataFim3']) ? 'TC.UltimoPedido <= "' . $_SESSION['FiltroRankingVendas']['DataFim3'] . '" AND ' : FALSE;
						
			$data['Pedidos_de'] = ($_SESSION['FiltroRankingVendas']['Pedidos_de']) ? 'F.ContPedidos >= "' . $_SESSION['FiltroRankingVendas']['Pedidos_de'] . '" AND ' : FALSE;
			$data['Pedidos_ate'] = ($_SESSION['FiltroRankingVendas']['Pedidos_ate']) ? 'F.ContPedidos <= "' . $_SESSION['FiltroRankingVendas']['Pedidos_ate'] . '" AND ' : FALSE;	
			
			$data['Valor_de'] = ($_SESSION['FiltroRankingVendas']['Valor_de']) ? 'F.Valor >= "' . $_SESSION['FiltroRankingVendas']['Valor_de'] . '" AND ' : FALSE;
			$data['Valor_ate'] = ($_SESSION['FiltroRankingVendas']['Valor_ate']) ? 'F.Valor <= "' . $_SESSION['FiltroRankingVendas']['Valor_ate'] . '" AND ' : FALSE;
			
			$data['Valor_cash_de'] = ($_SESSION['FiltroRankingVendas']['Valor_cash_de']) ? 'F.CashBackCliente >= "' . $_SESSION['FiltroRankingVendas']['Valor_cash_de'] . '" AND ' : FALSE;
			$data['Valor_cash_ate'] = ($_SESSION['FiltroRankingVendas']['Valor_cash_ate']) ? 'F.CashBackCliente <= "' . $_SESSION['FiltroRankingVendas']['Valor_cash_ate'] . '" AND ' : FALSE;	
	

			//$data['NomeCliente'] = ($_SESSION['FiltroRankingVendas']['NomeCliente']) ? ' AND TC.idApp_Cliente = ' . $_SESSION['FiltroRankingVendas']['NomeCliente'] : FALSE;
			$data['idApp_Cliente'] = ($_SESSION['FiltroRankingVendas']['idApp_Cliente']) ? ' AND TC.idApp_Cliente = ' . $_SESSION['FiltroRankingVendas']['idApp_Cliente'] : FALSE;
			$data['Campo'] = (!$_SESSION['FiltroRankingVendas']['Campo']) ? 'F.Valor' : $_SESSION['FiltroRankingVendas']['Campo'];
			$data['Ordenamento'] = (!$_SESSION['FiltroRankingVendas']['Ordenamento']) ? 'DESC' : $_SESSION['FiltroRankingVendas']['Ordenamento'];
		
		}	
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;
				
        $query['NomeCliente'] = $this->db->query('
			SELECT
				F.idApp_Cliente,
				F.NomeCliente,
				F.CelularCliente,
				F.CashBackCliente,
				F.ValidadeCashBack,
				F.id_UltimoPedido,
				F.UltimoPedido,
				F.ContPedidos,
				F.Valor
			FROM
				(SELECT
					TC.idApp_Cliente,
					TC.NomeCliente,
					TC.CelularCliente,
					TC.CashBackCliente,
					TC.ValidadeCashBack,
					TC.id_UltimoPedido,
					TC.UltimoPedido,
					TOT.DataOrca,
					COUNT(TOT.idApp_OrcaTrata) AS ContPedidos,
					SUM(TOT.ValorFinalOrca) AS Valor
				FROM
					App_Cliente AS TC
						INNER JOIN App_OrcaTrata AS TOT ON TOT.idApp_Cliente = TC.idApp_Cliente
				WHERE
					' . $permissao_orcam . '
					' . $date_inicio_orca . '
					' . $date_fim_orca . '
					' . $date_inicio_cash . '
					' . $date_fim_cash . '
					' . $date_inicio_ultimo . '
					' . $date_fim_ultimo . '
					TOT.CanceladoOrca = "N" AND
					TC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
					' . $data['idApp_Cliente'] . '
				GROUP BY
					TC.idApp_Cliente
				) AS F
			WHERE
				' . $data['Pedidos_de'] . '
				' . $data['Pedidos_ate'] . '
				' . $data['Valor_de'] . '
				' . $data['Valor_ate'] . '
				' . $data['Valor_cash_de'] . '
				' . $data['Valor_cash_ate'] . '
				F.idApp_Cliente != 0
			ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
			
			' . $querylimit . '	
        ');
		
		if($total == TRUE) {
			return $query['NomeCliente']->num_rows();
		}
				
        $query['NomeCliente'] = $query['NomeCliente']->result();

		$rankingvendas = new stdClass();
		$data['contagem'] = 0;
        foreach ($query['NomeCliente'] as $row) {

            $rankingvendas->{$row->idApp_Cliente} = new stdClass();
            $rankingvendas->{$row->idApp_Cliente}->idApp_Cliente = $row->idApp_Cliente;
            $rankingvendas->{$row->idApp_Cliente}->NomeCliente = $row->NomeCliente;
            $rankingvendas->{$row->idApp_Cliente}->CelularCliente = $row->CelularCliente;
            $rankingvendas->{$row->idApp_Cliente}->CashBackCliente = $row->CashBackCliente;
            $rankingvendas->{$row->idApp_Cliente}->ValidadeCashBack = $row->ValidadeCashBack;
            $rankingvendas->{$row->idApp_Cliente}->UltimoPedido = $row->UltimoPedido;
			$rankingvendas->{$row->idApp_Cliente}->ContPedidos = $row->ContPedidos;
			$rankingvendas->{$row->idApp_Cliente}->Valor = $row->Valor;
			$data['contagem']++;
		}
		
		$rankingvendas->soma = new stdClass();
		$somaqtdorcam = $somaqtddescon = $somaqtdvendida = $somaqtdparc = $somaqtddevol = $somaqtdpedidos = 0;
		
		foreach ($rankingvendas as $row) {
	
			
			$row->ContPedidos = (!isset($row->ContPedidos)) ? 0 : $row->ContPedidos;
			$row->Valor = (!isset($row->Valor)) ? 0 : $row->Valor;
			$row->CashBackCliente = (!isset($row->CashBackCliente)) ? 0 : $row->CashBackCliente;
			
			$row->ValidadeCashBack = (!isset($row->ValidadeCashBack)) ? "0000-00-00" : $row->ValidadeCashBack;
			$row->UltimoPedido = (!isset($row->UltimoPedido)) ? "0000-00-00" : $row->UltimoPedido;
			
			$somaqtdpedidos += $row->ContPedidos;
			$somaqtdparc += $row->Valor;
			$row->Valor2 = number_format($row->Valor, 2, ',', '.');	
			$row->CashBackCliente = number_format($row->CashBackCliente, 2, ',', '.');																
			
			$row->ValidadeCashBack = $this->basico->mascara_data($row->ValidadeCashBack, 'barras');
			$row->UltimoPedido = $this->basico->mascara_data($row->UltimoPedido, 'barras');
			
		}
		$rankingvendas->soma->somaqtdclientes = $data['contagem'];
		$rankingvendas->soma->somaqtdpedidos = $somaqtdpedidos;
		$rankingvendas->soma->somaqtdparc = number_format($somaqtdparc, 2, ',', '.');

        return $rankingvendas;

    }
    
	public function list_motivo($data, $x) {

        $query = $this->db->query('
			SELECT 
				TA.*
			FROM 
				Tab_Motivo AS TA
			WHERE 
                TA.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY  
				TA.Motivo ASC 
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
	
	public function select_cliente($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Cliente,
				CelularCliente,
				RegistroFicha,
				CONCAT(IFNULL(idApp_Cliente,""), " - ", IFNULL(NomeCliente,""), " - ", IFNULL(CelularCliente,""), " - ", IFNULL(Telefone,""), " - ", IFNULL(Telefone2,""), " - FCH:", IFNULL(RegistroFicha,"")) AS NomeCliente
            FROM
                App_Cliente					
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				idApp_Cliente DESC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Cliente,
				CelularCliente,
				RegistroFicha,
				CONCAT(IFNULL(idApp_Cliente,""), " - ", IFNULL(NomeCliente,""), " - ", IFNULL(CelularCliente,""), " - ", IFNULL(Telefone,""), " - ", IFNULL(Telefone2,""), " - FCH:", IFNULL(RegistroFicha,"")) AS NomeCliente		
            FROM
                App_Cliente					
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				idApp_Cliente DESC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Cliente] = $row->NomeCliente;
            }
        }

        return $array;
    }
	
	public function select_clientedep($data = FALSE) {
		
        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
					idApp_ClienteDep,      
					idApp_Cliente,
					CONCAT(IFNULL(NomeClienteDep,"")) AS NomeClienteDep
				FROM
					App_ClienteDep					
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					idApp_Cliente = ' . $data . '
				ORDER BY 
					NomeClienteDep ASC'
			);
					
        } else {
            $query = $this->db->query(
				'SELECT                
					idApp_ClienteDep,      
					idApp_Cliente,
					CONCAT(IFNULL(NomeClienteDep,"")) AS NomeClienteDep
				FROM
					App_ClienteDep					
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					idApp_Cliente = ' . $data . '
				ORDER BY 
					NomeClienteDep ASC'
			);
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_ClienteDep] = $row->NomeClienteDep;
            }
        }

        return $array;
    }
	
	public function select_clientepet($data = FALSE) {
		
        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
					idApp_ClientePet,      
					idApp_Cliente,
					CONCAT(IFNULL(NomeClientePet,"")) AS NomeClientePet
				FROM
					App_ClientePet
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					idApp_Cliente = ' . $data . '
				ORDER BY 
					NomeClientePet ASC'
			);
					
        } else {
            $query = $this->db->query(
				'SELECT                
					idApp_ClientePet,      
					idApp_Cliente,
					CONCAT(IFNULL(NomeClientePet,"")) AS NomeClientePet
				FROM
					App_ClientePet
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					idApp_Cliente = ' . $data . '
				ORDER BY 
					NomeClientePet ASC'
			);
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_ClientePet] = $row->NomeClientePet;
            }
        }

        return $array;
    }
	
	public function select_orcatrata($data = FALSE) {
		
        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
					idApp_OrcaTrata,      
					idApp_Cliente,
					CONCAT(IFNULL(idApp_OrcaTrata,""), " | ", IFNULL(Descricao,"")) AS Descricao
				FROM
					App_OrcaTrata
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					idApp_Cliente = ' . $data . '
				ORDER BY 
					idApp_OrcaTrata ASC'
			);
					
        } else {
            $query = $this->db->query(
				'SELECT                
					idApp_OrcaTrata,      
					idApp_Cliente,
					CONCAT(IFNULL(idApp_OrcaTrata,""), " | ", IFNULL(Descricao,"")) AS Descricao
				FROM
					App_OrcaTrata
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					idApp_Cliente = ' . $data . '
				ORDER BY 
					idApp_OrcaTrata ASC'
			);
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_OrcaTrata] = $row->Descricao;
            }
        }

        return $array;
    }
	
	public function select_clienteonline($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Cliente,
				CONCAT(NomeCliente) As NomeCliente				
            FROM
                App_Cliente					
            WHERE
                idSis_Empresa = "5"
			ORDER BY 
				NomeCliente ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Cliente,
				CONCAT(NomeCliente) As NomeCliente			
            FROM
                App_Cliente					
            WHERE
                idSis_Empresa = "5"
			ORDER BY 
				NomeCliente ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Cliente] = $row->NomeCliente;
            }
        }

        return $array;
    }	

	public function select_relacao($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT 
                    TR.idTab_Relacao,
					TR.Tipo,
                    CONCAT(IFNULL(TR.Relacao,"")) AS Relacao
				FROM
                    Tab_Relacao AS TR
				WHERE
					TR.Tipo = "PESSOAL"
				ORDER BY 
					TR.Relacao ASC
			');

        } else {
            #$query = $this->db->query('SELECT  idTab_Relacao, Relacao FROM Tab_Relacao  WHERE idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario']);
            $query = $this->db->query('
                SELECT 
                    TR.idTab_Relacao,
					TR.Tipo,
                    CONCAT(IFNULL(TR.Relacao,"")) AS Relacao
				FROM
                    Tab_Relacao AS TR
				WHERE
					TR.Tipo = "PESSOAL"
				ORDER BY 
					TR.Relacao ASC
			');
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Relacao] = $row->Relacao;
				#$array[$row->Relacao] = $row->Relacao;
            }
        }

        return $array;
    }

	public function select_racapet($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT 
                    TR.idTab_RacaPet,
                    CONCAT(IFNULL(TR.RacaPet,"")) AS RacaPet
				FROM
                    Tab_RacaPet AS TR
				WHERE
					TR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				ORDER BY 
					TR.RacaPet ASC
			');

        } else {
            $query = $this->db->query('
                SELECT 
                    TR.idTab_RacaPet,
                    CONCAT(IFNULL(TR.RacaPet,"")) AS RacaPet
				FROM
                    Tab_RacaPet AS TR
				WHERE
					TR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				ORDER BY 
					RacaPet ASC
			');
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_RacaPet] = $row->RacaPet;
				#$array[$row->Relacao] = $row->Relacao;
            }
        }

        return $array;
    }
	
}
