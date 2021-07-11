<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Consultaprint_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function get_consulta($data, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

		$cliente 		= ($_SESSION['Agendamentos']['idApp_Cliente']) ? ' AND CO.idApp_Cliente = ' . $_SESSION['Agendamentos']['idApp_Cliente'] : FALSE;
		$clientepet		= ($_SESSION['Empresa']['CadastrarPet'] == "S" && $_SESSION['Agendamentos']['idApp_ClientePet']) ? ' AND CO.idApp_ClientePet = ' . $_SESSION['Agendamentos']['idApp_ClientePet'] : FALSE;
		$clientedep		= ($_SESSION['Empresa']['CadastrarDep'] == "S" && $_SESSION['Agendamentos']['idApp_ClienteDep']) ? ' AND CO.idApp_ClienteDep = ' . $_SESSION['Agendamentos']['idApp_ClienteDep'] : FALSE;			
		
		$campo 			= (!$_SESSION['Agendamentos']['Campo']) ? 'CO.DataInicio' : $_SESSION['Agendamentos']['Campo'];
        $ordenamento 	= (!$_SESSION['Agendamentos']['Ordenamento']) ? 'ASC' : $_SESSION['Agendamentos']['Ordenamento'];

		($_SESSION['Agendamentos']['DataInicio']) ? $date_inicio = $_SESSION['Agendamentos']['DataInicio'] : FALSE;
		($_SESSION['Agendamentos']['DataFim']) ? $date_fim = date('Y-m-d', strtotime('+1 days', strtotime($_SESSION['Agendamentos']['DataFim']))) : FALSE;
		
		$date_inicio_orca 	= ($_SESSION['Agendamentos']['DataInicio']) ? 'DataInicio >= "' . $date_inicio . '" AND ' : FALSE;
		$date_fim_orca 		= ($_SESSION['Agendamentos']['DataFim']) ? 'DataInicio <= "' . $date_fim . '" AND ' : FALSE;

        if ($limit){
			$querylimit = 'LIMIT ' . $start . ', ' . $limit;
		}else{
			$querylimit = '';
		}
				
		$query = $this->db->query('
            SELECT
				CO.*,
				DATE_FORMAT(CO.DataInicio, "%Y-%m-%d") AS DataInicio,
				DATE_FORMAT(CO.DataInicio, "%H:%i") AS HoraInicio,
				DATE_FORMAT(CO.DataFim, "%Y-%m-%d") AS DataFim,
				DATE_FORMAT(CO.DataFim, "%H:%i") AS HoraFim,
				CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
				CP.*,
				CONCAT(IFNULL(CP.idApp_ClientePet,""), " - " ,IFNULL(CP.NomeClientePet,"")) AS NomeClientePet,
				CD.*,
				CONCAT(IFNULL(CD.idApp_ClienteDep,""), " - " ,IFNULL(CD.NomeClienteDep,"")) AS NomeClienteDep
            FROM
                App_Consulta AS CO
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CO.idApp_Cliente
					LEFT JOIN App_ClientePet AS CP ON CP.idApp_ClientePet = CO.idApp_ClientePet
					LEFT JOIN App_ClienteDep AS CD ON CD.idApp_ClienteDep = CO.idApp_ClienteDep
            WHERE
				' . $date_inicio_orca . '
				' . $date_fim_orca . '
                CO.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				CO.Tipo = 2
				' . $cliente . '
				' . $clientepet . '
				' . $clientepet . '
			ORDER BY
				' . $campo . '
				' . $ordenamento . '
			' . $querylimit . ' 		
        ');
	
		if($total == TRUE) {
			return $query->num_rows();
		}
		
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

}
