<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Campanha_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_campanha($data) {

        $query = $this->db->insert('App_Campanha', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_campanha($data) {
        $query = $this->db->query('
			SELECT
				PC.*
			FROM 
				App_Campanha AS PC
			WHERE
				PC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				PC.idApp_Campanha = ' . $data . '
		');
		
		foreach ($query->result_array() as $row) {
			//$row->DataCampanha = $this->basico->mascara_data($row->DataCampanha, 'barras');
			//$row->DataCampanhaLimite = $this->basico->mascara_data($row->DataCampanhaLimite, 'barras');
			//$row->AtivoCampanha = $this->basico->mascara_palavra_completa($row->AtivoCampanha, 'NS');
		}
		
		//$query = $query->result_array();		
		
		/*
        echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($row);
        echo '<br>';
        print_r($row['idApp_Campanha']);
        echo '<br>';
        print_r($row['Campanha']);
        echo '<br>';
        print_r($row['DescCampanha']);
        echo "</pre>";
        exit ();
       */

		return $row;
        //return $query[0];
    }

    public function get_campanha_cupom($data) {
		if ($data == 0) {
			return FALSE;
		}else{
			$query = $this->db->query('
				SELECT
					PC.*,
					CONCAT(IFNULL(Campanha,""), "<br>", IFNULL(DescCampanha,"")) AS Campanha
				FROM 
					App_Campanha AS PC
				WHERE 
					PC.idApp_Campanha = ' . $data . '
			');
			$query = $query->result_array();
			return $query[0];
		}	
    }

    public function get_campanha_original($data) {
        $query = $this->db->query('
			SELECT
				PC.*,
				CONCAT(IFNULL(Campanha,""), "<br>", IFNULL(DescCampanha,"")) AS Campanha
			FROM 
				App_Campanha AS PC
			WHERE 
				PC.idApp_Campanha = ' . $data . '
		');
		/*
		foreach ($query->result_array() as $row) {
			//$row->DataCampanha = $this->basico->mascara_data($row->DataCampanha, 'barras');
			//$row->DataCampanhaLimite = $this->basico->mascara_data($row->DataCampanhaLimite, 'barras');
			//$row->AtivoCampanha = $this->basico->mascara_palavra_completa($row->AtivoCampanha, 'NS');
		}
		*/
		$query = $query->result_array();
		/*
        echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($row);
        echo '<br>';
        print_r($row['idApp_Campanha']);
        echo '<br>';
        print_r($row['Campanha']);
        echo '<br>';
        print_r($row['DescCampanha']);
        echo "</pre>";
        exit ();
		*/

		//return $row;
        return $query[0];
    }

    public function get_contagem_orc($data) {
        $query = $this->db->query('
			SELECT 
				idApp_OrcaTrata,
				idSis_Empresa,
				Cupom
			FROM 
				App_OrcaTrata
			WHERE 
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				Cupom = ' . $data . ' 
				
		');
        $query = $query->result_array();
        $contagem = count($query);
		/*
		echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($contagem);
        echo '<br>';
        print_r($query);
        echo "</pre>";
        */
        if(isset($contagem) && $contagem > 0){
			return TRUE;
		}else{
			return FALSE;
		}
    }
	
	public function list1_campanha($data, $completo) {
	
		$date_inicio_proc = ($data['DataInicio']) ? 'P.DataCampanha >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_proc = ($data['DataFim']) ? 'P.DataCampanha <= "' . $data['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_limite = ($data['DataInicio2']) ? 'P.DataCampanhaLimite >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_limite = ($data['DataFim2']) ? 'P.DataCampanhaLimite <= "' . $data['DataFim2'] . '" AND ' : FALSE;
		

        $data['Campo'] = (!$data['Campo']) ? 'P.idApp_Campanha' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		$filtro5 = ($data['AtivoCampanha']) ? 'P.AtivoCampanha = "' . $data['AtivoCampanha'] . '" AND ' : FALSE;
		$filtro9 = ($data['TipoCampanha']) ? 'P.TipoCampanha = "' . $data['TipoCampanha'] . '" AND ' : FALSE;
		#$filtro5 = ($data['AtivoCampanha'] != '0') ? 'P.AtivoCampanha = "' . $data['AtivoCampanha'] . '" AND ' : FALSE;
		#$filtro9 = ($data['TipoCampanha'] != '0') ? 'P.TipoCampanha = "' . $data['TipoCampanha'] . '" AND ' : FALSE;		
		$data['AtivoCampanha'] = ($data['AtivoCampanha'] != '') ? ' AND P.AtivoCampanha = ' . $data['AtivoCampanha'] : FALSE;
		
		$query = $this->db->query('
            SELECT
				P.idSis_Empresa,
				P.idApp_Campanha,
                P.Campanha,
                P.DescCampanha,
				P.DataCampanha,
				P.DataCampanhaLimite,
				P.AtivoCampanha,
				P.idSis_Usuario,
				P.TipoCampanha,
				P.TipoDescCampanha,
				P.ValorDesconto,
				P.ValorMinimo,
				P.Ganhador,
				E.NomeEmpresa,
				SN.StatusSN
            FROM
				App_Campanha AS P
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.AtivoCampanha
            WHERE
				' . $date_inicio_proc . '
                ' . $date_fim_proc . '
                ' . $date_inicio_limite . '
                ' . $date_fim_limite . '
				' . $filtro5 . '
				' . $filtro9 . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			GROUP BY
				P.idApp_Campanha
			ORDER BY
				' . $data['Campo'] . '
				' . $data['Ordenamento'] . '

        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

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
				$row->DataCampanha = $this->basico->mascara_data($row->DataCampanha, 'barras');
				$row->DataCampanhaLimite = $this->basico->mascara_data($row->DataCampanhaLimite, 'barras');
				$row->AtivoCampanha = $this->basico->mascara_palavra_completa($row->AtivoCampanha, 'NS');
				if($row->TipoCampanha == 0){
					$row->TipoCampanha = 'Sem Tipo';
					$row->ValorDesconto = '';
					$row->ValorMinimo = '';
					$row->TipoDescCampanha = '';
				}elseif($row->TipoCampanha == 1){
					$row->TipoCampanha = 'Sorteio';
					$row->ValorDesconto = '';
					$row->ValorMinimo = '';
					$row->TipoDescCampanha = '';
				}elseif($row->TipoCampanha == 2){
					$row->TipoCampanha = 'Cupom';
					$row->ValorMinimo = 'R$' . number_format($row->ValorMinimo, 2, ',', '.');
					if($row->TipoDescCampanha == 'V'){
						$row->TipoDescCampanha = 'R$';
						$row->ValorDesconto = $row->TipoDescCampanha . number_format($row->ValorDesconto, 2, ',', '.');
					}elseif($row->TipoDescCampanha == 'P'){
						$row->TipoDescCampanha = '%';
						$row->ValorDesconto = number_format($row->ValorDesconto, 2, ',', '.') . $row->TipoDescCampanha;
					}
				}
			}

            return $query;
        }

    }

    public function update_campanha($data, $id) {

        unset($data['idApp_Campanha']);
        $query = $this->db->update('App_Campanha', $data, array('idApp_Campanha' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_campanha($id) {

        $query = $this->db->delete('App_Campanha', array('idApp_Campanha' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

	public function select_status_sn($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN');

            $array = array();
			$array[0] = 'TODOS';
			foreach ($query->result() as $row) {
			$array[$row->Abrev] = $row->StatusSN;
			
            }
        }

        return $array;
    }

	public function select_dia() {

        $query = $this->db->query('
            SELECT
				D.idTab_Dia,
				D.Dia				
			FROM
				Tab_Dia AS D
			ORDER BY
				D.Dia
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Dia] = $row->Dia;
        }

        return $array;
    }	
	
	public function select_mes() {

        $query = $this->db->query('
            SELECT
				M.idTab_Mes,
				M.Mesdesc,
				CONCAT(M.Mes, " - ", M.Mesdesc) AS Mes
			FROM
				Tab_Mes AS M

			ORDER BY
				M.Mes
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Mes] = $row->Mes;
        }

        return $array;
    }	
	
	public function select_campanha($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
					idApp_Campanha,
					CONCAT(IFNULL(idApp_Campanha,""), " - ", IFNULL(Campanha,""), " - ", IFNULL(DescCampanha,"")) AS Campanha
				FROM
					App_Campanha					
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				ORDER BY 
					idApp_Campanha DESC'
			);
					
        } else {
            $query = $this->db->query(
				'SELECT                
					idApp_Campanha,
					CONCAT(IFNULL(idApp_Campanha,""), " - ", IFNULL(Campanha,""), " - ", IFNULL(DescCampanha,"")) AS Campanha
				FROM
					App_Campanha					
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				ORDER BY 
					idApp_Campanha DESC'
			);
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Campanha] = $row->Campanha;
            }
        }

        return $array;
    }
	
	public function select_campanha0() {

		$permissao1 = (($_SESSION['FiltroAlteraCampanha']['TipoCampanha'] != "0" ) && ($_SESSION['FiltroAlteraCampanha']['TipoCampanha'] != '' )) ? 'P.TipoCampanha = "' . $_SESSION['FiltroAlteraCampanha']['TipoCampanha'] . '" AND ' : FALSE;
		$permissao2 = (($_SESSION['FiltroAlteraCampanha']['AtivoCampanha'] != "0" ) && ($_SESSION['FiltroAlteraCampanha']['AtivoCampanha'] != '' )) ? 'P.AtivoCampanha = "' . $_SESSION['FiltroAlteraCampanha']['AtivoCampanha'] . '" AND ' : FALSE;	
		
		$query = $this->db->query('
            SELECT
                P.idApp_Campanha,
                P.DescCampanha
            FROM
				App_Campanha AS P
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.AtivoCampanha
            WHERE
				' . $permissao1 . '
				' . $permissao2 . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                P.DescCampanha ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Campanha] = $row->DescCampanha;
        }

        return $array;
    }
	
}
