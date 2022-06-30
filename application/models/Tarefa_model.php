<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Tarefa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_tarefa($data) {

        $query = $this->db->insert('App_Tarefa', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_procedtarefa($data) {

        $query = $this->db->insert_batch('App_SubTarefa', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_tarefa($data) {

		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao = 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
			$permissao2 = FALSE;
		}else{
			if($_SESSION['Usuario']['Nivel'] == 2){
				$permissao = 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
				$permissao2 = FALSE;
			}else{
				$permissao = 'P.NivelTarefa = "1" AND';
				$permissao2 = 'OR P.Compartilhar = 0';
			}
		}

        $query = $this->db->query('
			SELECT
				P.*,
				P.Compartilhar,
				CT.*,
				
				US.idSis_Usuario AS Compartilhar,
				US.CelularUsuario AS CelularCompartilhou,
				US.Nome AS NomeCompartilhar,
				
				P.idSis_Usuario AS idSis_Usuario,
				USC.CelularUsuario AS CelularCadastrou,
				USC.Nome AS NomeCadastrou
			FROM 
				App_Tarefa AS P
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = P.idTab_Categoria
					LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = P.idSis_Usuario
			WHERE 
				' . $permissao . '
				P.idApp_Tarefa = ' . $data . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				(P.Compartilhar = ' . $_SESSION['log']['idSis_Usuario'] . ' OR P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' ' . $permissao2 . ') 
		');
		
		foreach ($query->result() as $row) {
			
		}

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			$query = $query->result_array();
			return $query[0];
        }

    }

    public function get_tarefa_original($data) {
        $query = $this->db->query('
			SELECT
				PC.*,
				PC.Compartilhar AS idCompartilhar,
				CT.*,
				CT.idTab_Categoria AS Categoria,
				CT.Categoria AS NomeCategoria,
				
				US.idSis_Usuario AS Compartilhar,
				US.CelularUsuario AS CelularCompartilhou,
				US.Nome AS NomeCompartilhar,
				
				PC.idSis_Usuario AS idSis_Usuario,
				USC.CelularUsuario AS CelularCadastrou,
				USC.Nome AS NomeCadastrou
			FROM 
				App_Tarefa AS PC
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = PC.Categoria
					LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = PC.Compartilhar
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Tarefa = ' . $data . '
		');
		
		foreach ($query->result_array() as $row) {
			//$row->DataTarefa = $this->basico->mascara_data($row->DataTarefa, 'barras');
			//$row->DataTarefaLimite = $this->basico->mascara_data($row->DataTarefaLimite, 'barras');
			//$row->ConcluidoTarefa = $this->basico->mascara_palavra_completa($row->ConcluidoTarefa, 'NS');
			//$row->ConcluidoSubTarefa = $this->basico->mascara_palavra_completa2($row->ConcluidoSubTarefa, 'NS');
			//$row->Prioridade = $this->basico->prioridade($row->Prioridade, '123');
			//$row->SubPrioridade = $this->basico->prioridade($row->SubPrioridade, '123');
			//$row->Statustarefa = $this->basico->statustrf($row->Statustarefa, '123');
			//$row->Statussubtarefa = $this->basico->statustrf($row->Statussubtarefa, '123');
			
			if($row['Compartilhar'] == 0){
				$row['NomeCompartilhar'] = 'TODOS';
			}
			
		}
		
		//$query = $query->result_array();		
		
		/*
        echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($row);
        echo '<br>';
        print_r($row['Compartilhar']);
        echo '<br>';
        print_r($row['NomeCompartilhar']);
        echo "</pre>";
        exit ();
       */

		return $row;
        //return $query[0];
    }

    public function get_procedtarefa($data) {
		$query = $this->db->query('
			SELECT 
				PC.*,
				PC.idSis_Usuario,
				USC.*,
				USC.idSis_Usuario AS idSis_Usuario,
				USC.CelularUsuario AS CelularCadastrou,
				USC.Nome AS NomeCadastrou
				
			FROM 
				App_SubTarefa AS PC
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Tarefa = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_procedtarefa_posterior($data) {
		$query = $this->db->query('
			SELECT 
				PC.*
			FROM 
				App_SubTarefa AS PC
			WHERE 
				PC.idApp_Tarefa = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_profissional($data) {
		$query = $this->db->query('SELECT NomeProfissional FROM App_Profissional WHERE idApp_Profissional = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['NomeProfissional'])) ? $query[0]['NomeProfissional'] : FALSE;
    }
	
	public function list1_tarefa($data, $completo) {
	
		$date_inicio_proc = ($data['DataInicio']) ? 'P.DataTarefa >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_proc = ($data['DataFim']) ? 'P.DataTarefa <= "' . $data['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_limite = ($data['DataInicio2']) ? 'P.DataTarefaLimite >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_limite = ($data['DataFim2']) ? 'P.DataTarefaLimite <= "' . $data['DataFim2'] . '" AND ' : FALSE;
		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(P.DataTarefa) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(P.DataTarefa) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(P.DataTarefa) = ' . $data['Ano'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.DataTarefa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		$filtro5 = ($data['ConcluidoTarefa']) ? 'P.ConcluidoTarefa = "' . $data['ConcluidoTarefa'] . '" AND ' : FALSE;
		$filtro8 = ($data['ConcluidoSubTarefa']) ? 'SP.ConcluidoSubTarefa = "' . $data['ConcluidoSubTarefa'] . '" AND ' : FALSE;
		$filtro6 = ($data['Prioridade']) ? 'P.Prioridade = "' . $data['Prioridade'] . '" AND ' : FALSE;
		$filtro10 = ($data['SubPrioridade']) ? 'SP.Prioridade = "' . $data['SubPrioridade'] . '" AND ' : FALSE;
		$filtro9 = ($data['idTab_Categoria']) ? 'P.idTab_Categoria = "' . $data['idTab_Categoria'] . '" AND ' : FALSE;
		$filtro11 = ($data['Statustarefa']) ? 'P.Statustarefa = "' . $data['Statustarefa'] . '" AND ' : FALSE;
		$filtro12 = ($data['Statussubtarefa']) ? 'SP.Statussubtarefa = "' . $data['Statussubtarefa'] . '" AND ' : FALSE;
		#$filtro5 = ($data['ConcluidoTarefa'] != '0') ? 'P.ConcluidoTarefa = "' . $data['ConcluidoTarefa'] . '" AND ' : FALSE;
        #$filtro6 = ($data['Prioridade'] != '0') ? 'P.Prioridade = "' . $data['Prioridade'] . '" AND ' : FALSE;		
		#$filtro9 = ($data['idTab_Categoria'] != '0') ? 'P.idTab_Categoria = "' . $data['idTab_Categoria'] . '" AND ' : FALSE;		
		#$filtro8 = (($data['ConcluidoSubTarefa'] != '0') && ($data['ConcluidoSubTarefa'] != 'M')) ? 'SP.ConcluidoSubTarefa = "' . $data['ConcluidoSubTarefa'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoSubTarefa'] == 'M') ? '((SP.ConcluidoSubTarefa = "S") OR (SP.ConcluidoSubTarefa = "N")) AND ' : FALSE;		
		$data['ConcluidoTarefa'] = ($data['ConcluidoTarefa'] != '') ? ' AND P.ConcluidoTarefa = ' . $data['ConcluidoTarefa'] : FALSE;
		$data['ConcluidoSubTarefa'] = ($data['ConcluidoSubTarefa'] != '') ? ' AND SP.ConcluidoSubTarefa = ' . $data['ConcluidoSubTarefa'] : FALSE;
		$data['Prioridade'] = ($data['Prioridade'] != '') ? ' AND P.Prioridade = ' . $data['Prioridade'] : FALSE;
		$data['Tarefa'] = ($data['Tarefa']) ? ' AND P.idApp_Tarefa = ' . $data['Tarefa'] : FALSE;
		$data['Compartilhar'] = ($data['Compartilhar']) ? ' AND P.Compartilhar = ' . $data['Compartilhar'] : FALSE;
		$data['NomeUsuario'] = ($data['NomeUsuario']) ? ' AND P.idSis_Usuario = ' . $data['NomeUsuario'] : FALSE;
		$data['NomeProfissional'] = ($data['NomeProfissional']) ? ' AND P.idSis_Usuario = ' . $data['NomeProfissional'] : FALSE;

		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao = 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
			$permissao2 = FALSE;
		}else{
			if($_SESSION['Usuario']['Nivel'] == 2){
				$permissao = 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
				$permissao2 = FALSE;
			}else{
				$permissao = 'P.NivelTarefa = "1" AND';
				$permissao2 = 'OR P.Compartilhar = 0';
			}
		}

		$query = $this->db->query('
            SELECT
				P.idSis_Empresa,
				P.idApp_Tarefa,
                P.Tarefa,
				P.DataTarefa,
				P.DataTarefaLimite,
				P.ConcluidoTarefa,
				P.Prioridade,
				P.Statustarefa,
				P.Compartilhar,
				P.idSis_Usuario,
				E.NomeEmpresa,
				U.CpfUsuario,
				U.Nome AS NomeUsuario,
				AU.Nome AS Comp,
				CT.Categoria,
				SP.SubTarefa,
				SP.Statussubtarefa,
				SP.ConcluidoSubTarefa,				
				SP.DataSubTarefa,
				SP.DataSubTarefaLimite,
				SP.Prioridade AS SubPrioridade,
				SN.StatusSN
            FROM
				App_Tarefa AS P
					LEFT JOIN App_SubTarefa AS SP ON SP.idApp_Tarefa = P.idApp_Tarefa
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoTarefa
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = P.idTab_Categoria
            WHERE
				' . $permissao . '
				' . $date_inicio_proc . '
                ' . $date_fim_proc . '
                ' . $date_inicio_limite . '
                ' . $date_fim_limite . '
				' . $filtro6 . '
				' . $filtro5 . '
				' . $filtro9 . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				(P.Compartilhar = ' . $_SESSION['log']['idSis_Usuario'] . ' OR P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' ' . $permissao2 . ') AND
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" AND
				P.idApp_Fornecedor = "0" AND
				P.ConcluidoTarefa = "N"
				' . $data['Compartilhar'] . '
				' . $data['NomeProfissional'] . '
			GROUP BY
				P.idApp_Tarefa
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
				$row->DataTarefa = $this->basico->mascara_data($row->DataTarefa, 'barras');
				$row->DataTarefaLimite = $this->basico->mascara_data($row->DataTarefaLimite, 'barras');
				$row->ConcluidoTarefa = $this->basico->mascara_palavra_completa($row->ConcluidoTarefa, 'NS');
				$row->ConcluidoSubTarefa = $this->basico->mascara_palavra_completa2($row->ConcluidoSubTarefa, 'NS');
				$row->Prioridade = $this->basico->prioridade($row->Prioridade, '123');
				$row->SubPrioridade = $this->basico->prioridade($row->SubPrioridade, '123');
				$row->Statustarefa = $this->basico->statustrf($row->Statustarefa, '123');
				$row->Statussubtarefa = $this->basico->statustrf($row->Statussubtarefa, '123');
				if($row->Compartilhar == 0){
					$row->Comp = '" TODOS "';
				}
            }

            return $query;
        }

    }

	public function list2_tarefacli($data, $completo) {

		$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Diacli'] = ($data['Diacli']) ? ' AND DAY(P.DataTarefaLimite) = ' . $data['Diacli'] : FALSE;
		$data['Mesvenccli'] = ($data['Mesvenccli']) ? ' AND MONTH(P.DataTarefaLimite) = ' . $data['Mesvenccli'] : FALSE;
		$data['Anocli'] = ($data['Anocli']) ? ' AND YEAR(P.DataTarefaLimite) = ' . $data['Anocli'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.DataTarefa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		$filtro4 = ($data['Concluidocli']) ? 'P.ConcluidoTarefa = "' . $data['Concluidocli'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
				C.idApp_Cliente,
				C.NomeCliente,
				U.idSis_Usuario,
				U.CpfUsuario,
				P.idSis_Empresa,
				P.idApp_Tarefa,
                P.Tarefa,
				P.DataTarefa,
				P.DataTarefaLimite,
				P.ConcluidoTarefa,
				SN.StatusSN
            FROM
				App_Tarefa AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoTarefa
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_EmpresaCli = "0" AND
				P.idApp_Cliente != "0" AND
				' . $filtro4 . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
                ' . $data['NomeCliente'] . '

				' . $data['Diacli'] . ' 
				' . $data['Mesvenccli'] . ' 
				' . $data['Anocli'] . ' 
				
            ORDER BY
                P.ConcluidoTarefa ASC,
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
				$row->DataTarefa = $this->basico->mascara_data($row->DataTarefa, 'barras');
				$row->DataTarefaLimite = $this->basico->mascara_data($row->DataTarefaLimite, 'barras');
				$row->ConcluidoTarefa = $this->basico->mascara_palavra_completa($row->ConcluidoTarefa, 'NS');

            }

            return $query;
        }

    }

	public function list3_mensagemenv($data, $completo) {

		$data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND P.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
		$data['NomeEmpresaCli'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['NomeEmpresaCli']) ? ' AND P.idSis_EmpresaCli = ' . $data['NomeEmpresaCli'] : FALSE;
		$data['Diaemp'] = ($data['Diaemp']) ? ' AND DAY(P.DataTarefa) = ' . $data['Diaemp'] : FALSE;
		$data['Mesvencemp'] = ($data['Mesvencemp']) ? ' AND MONTH(P.DataTarefa) = ' . $data['Mesvencemp'] : FALSE;
		$data['Anoemp'] = ($data['Anoemp']) ? ' AND YEAR(P.DataTarefa) = ' . $data['Anoemp'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.ConcluidoTarefa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_UsuarioCli = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$filtro4 = ($data['Concluidoemp']) ? 'P.ConcluidoTarefa = "' . $data['Concluidoemp'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
				EE.NomeEmpresa AS NomeEmpresaCli,
				ER.NomeEmpresa AS NomeEmpresa,
				UE.Nome AS NomeCli,
				UR.Nome AS Nome,
				P.idSis_Empresa,
				P.idSis_EmpresaCli,
				P.idApp_Tarefa,
                P.idApp_OrcaTrata,
				P.idApp_Cliente,
				P.Tarefa,
				P.DataTarefa,
				P.ConcluidoTarefa,
				P.idSis_EmpresaCli,
				P.TarefaCli,
				P.DataTarefaCli,
				P.ConcluidoTarefaCli,
				SN.StatusSN
            FROM
				App_Tarefa AS P
					LEFT JOIN Sis_Empresa AS EE ON EE.idSis_Empresa = P.idSis_EmpresaCli
					LEFT JOIN Sis_Empresa AS ER ON ER.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Sis_Usuario AS UE ON UE.idSis_Usuario = P.idSis_UsuarioCli
					LEFT JOIN Sis_Usuario AS UR ON UR.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoTarefa
            WHERE 
				P.idSis_EmpresaCli = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao . '
				' . $filtro4 . '
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" 
				' . $data['NomeEmpresa'] . '
				' . $data['NomeEmpresaCli'] . '
				' . $data['Diaemp'] . ' 
				' . $data['Mesvencemp'] . ' 
				' . $data['Anoemp'] . ' 
            ORDER BY
				P.ConcluidoTarefa,
				P.DataTarefaCli ASC
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
				$row->DataTarefa = $this->basico->mascara_data($row->DataTarefa, 'barras');
				$row->ConcluidoTarefa = $this->basico->mascara_palavra_completa($row->ConcluidoTarefa, 'NS');
				$row->DataTarefaCli = $this->basico->mascara_data($row->DataTarefaCli, 'barras');
				$row->ConcluidoTarefaCli = $this->basico->mascara_palavra_completa($row->ConcluidoTarefaCli, 'NS');
            }

            return $query;
        }

    }
	
	public function list4_mensagemrec($data, $completo) {

		$data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND P.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
		$data['NomeEmpresaCli'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['NomeEmpresaCli']) ? ' AND P.idSis_EmpresaCli = ' . $data['NomeEmpresaCli'] : FALSE;
		$data['Diaemp'] = ($data['Diaemp']) ? ' AND DAY(P.DataTarefa) = ' . $data['Diaemp'] : FALSE;
		$data['Mesvencemp'] = ($data['Mesvencemp']) ? ' AND MONTH(P.DataTarefa) = ' . $data['Mesvencemp'] : FALSE;
		$data['Anoemp'] = ($data['Anoemp']) ? ' AND YEAR(P.DataTarefa) = ' . $data['Anoemp'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.ConcluidoTarefa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_UsuarioCli = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$filtro4 = ($data['Concluidoemp']) ? 'P.ConcluidoTarefa = "' . $data['Concluidoemp'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
				EE.NomeEmpresa AS NomeEmpresaCli,
				ER.NomeEmpresa AS NomeEmpresa,
				UE.Nome AS NomeCli,
				UR.Nome AS Nome,
				P.idSis_Empresa,
				P.idSis_EmpresaCli,
				P.idApp_Tarefa,
                P.idApp_OrcaTrata,
				P.idApp_Cliente,
				P.Tarefa,
				P.DataTarefa,
				P.ConcluidoTarefa,
				P.idSis_EmpresaCli,
				P.TarefaCli,
				P.DataTarefaCli,
				P.ConcluidoTarefaCli,
				SN.StatusSN
            FROM
				App_Tarefa AS P
					LEFT JOIN Sis_Empresa AS EE ON EE.idSis_Empresa = P.idSis_EmpresaCli
					LEFT JOIN Sis_Empresa AS ER ON ER.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Sis_Usuario AS UE ON UE.idSis_Usuario = P.idSis_UsuarioCli
					LEFT JOIN Sis_Usuario AS UR ON UR.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoTarefa
            WHERE 
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao . '
				' . $filtro4 . '
				P.idSis_EmpresaCli != "0" AND
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" 
				' . $data['NomeEmpresa'] . '
				' . $data['NomeEmpresaCli'] . '
				' . $data['Diaemp'] . ' 
				' . $data['Mesvencemp'] . ' 
				' . $data['Anoemp'] . ' 
            ORDER BY
				P.ConcluidoTarefa,
				P.DataTarefaCli ASC
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
				$row->DataTarefa = $this->basico->mascara_data($row->DataTarefa, 'barras');
				$row->ConcluidoTarefa = $this->basico->mascara_palavra_completa($row->ConcluidoTarefa, 'NS');
				$row->DataTarefaCli = $this->basico->mascara_data($row->DataTarefaCli, 'barras');
				$row->ConcluidoTarefaCli = $this->basico->mascara_palavra_completa($row->ConcluidoTarefaCli, 'NS');
            }

            return $query;
        }

    }
	
    public function list_tarefa($id, $aprovado, $completo) {

        $query = $this->db->query('
            SELECT
                TF.idApp_Tarefa,
                TF.DataTarefa,
    			TF.DataTarefaLimite,
				TF.Prioridade,
				TF.Statustarefa,
				TF.Rotina,
                TF.ProfissionalTarefa,
                TF.ConcluidoTarefa,
                TF.Tarefa
            FROM
                App_Tarefa AS TF
            WHERE
                TF.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
                TF.ConcluidoTarefa = "' . $aprovado . '"
            ORDER BY
                TF.ProfissionalTarefa ASC,
				TF.Rotina DESC,				
				TF.Prioridade DESC,
				TF.DataTarefaLimite ASC
				
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
					$row->DataTarefa = $this->basico->mascara_data($row->DataTarefa, 'barras');
					$row->DataTarefaLimite = $this->basico->mascara_data($row->DataTarefaLimite, 'barras');
                    $row->ConcluidoTarefa = $this->basico->mascara_palavra_completa($row->ConcluidoTarefa, 'NS');
					$row->Rotina = $this->basico->mascara_palavra_completa($row->Rotina, 'NS');
					#$row->Prioridade = $this->basico->mascara_palavra_completa($row->Prioridade, 'NS');
                    $row->ProfissionalTarefa = $this->get_profissional($row->ProfissionalTarefa);
                }
                return $query;
            }
        }
    }
    
	public function list_categoria($data, $x) {
		
		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
		}else{
			if($_SESSION['Usuario']['Nivel'] == 2){
				$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
			}else{
				$permissao = 'C.NivelCategoria = "1" AND';
			}
		}
		
        $query = $this->db->query('
			SELECT 
				C.*
			FROM 
				Tab_Categoria AS C
			WHERE 
                ' . $permissao . '
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY  
				C.Categoria ASC 
		');

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

    public function list_tarefaBKP($x) {

        $query = $this->db->query('SELECT '
            . 'TF.idApp_Tarefa, '
            . 'TF.DataTarefa, '
			. 'TF.DataTarefaLimite, '
            . 'TF.ProfissionalTarefa, '
            . 'TF.ConcluidoTarefa, '
            . 'TF.Tarefa '
            . 'FROM '
            . 'App_Tarefa AS TF '
            . 'WHERE '
            #. 'TF.idApp_Cliente = ' . $_SESSION['Tarefa']['idApp_Cliente'] . ' '
            . 'ORDER BY TF.DataTarefa ASC ');
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
					$row->DataTarefa = $this->basico->mascara_data($row->DataTarefa, 'barras');
					$row->DataTarefaLimite = $this->basico->mascara_data($row->DataTarefaLimite, 'barras');
                    $row->ConcluidoTarefa = $this->basico->mascara_palavra_completa($row->ConcluidoTarefa, 'NS');
                    $row->ProfissionalTarefa = $this->get_profissional($row->ProfissionalTarefa);
                }

                return $query;
            }
        }
    }

    public function update_tarefa($data, $id) {

        unset($data['idApp_Tarefa']);
        $query = $this->db->update('App_Tarefa', $data, array('idApp_Tarefa' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_procedtarefa($data) {

        $query = $this->db->update_batch('App_SubTarefa', $data, 'idApp_SubTarefa');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_procedtarefa($data) {

        $this->db->where_in('idApp_SubTarefa', $data);
        $this->db->delete('App_SubTarefa');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_tarefa($id) {

        $query = $this->db->delete('App_SubTarefa', array('idApp_Tarefa' => $id));
        $query = $this->db->delete('App_Tarefa', array('idApp_Tarefa' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

	public function select_categoria() {

		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
		}else{
			if($_SESSION['Usuario']['Nivel'] == 2){
				$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
			}else{
				$permissao = 'C.NivelCategoria = "1" AND';
			}
		}
		
		$query = $this->db->query('
            SELECT
                C.idTab_Categoria,
                C.Categoria
            FROM
                Tab_Categoria AS C
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = C.idSis_Usuario
            WHERE
				' . $permissao . '
				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                C.Categoria ASC
        ');

        $array = array();	
        foreach ($query->result() as $row) {
            $array[$row->idTab_Categoria] = $row->Categoria;
        }

        return $array;
    }

    public function select_categoria2() {

		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
		}else{
			if($_SESSION['Usuario']['Nivel'] == 2){
				$permissao = 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
			}else{
				$permissao = 'C.NivelCategoria = "1" AND';
			}
		}
		
		$query = $this->db->query('
            SELECT
                C.idTab_Categoria,
                C.Categoria
            FROM
                Tab_Categoria AS C
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = C.idSis_Usuario
            WHERE
				' . $permissao . '
				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                C.Categoria ASC
        ');

        $array = array();
		$array[0] = '::Todos::';
        foreach ($query->result() as $row) {
			$array[$row->idTab_Categoria] = $row->Categoria;
        }

        return $array;
    }
	
	public function select_usuario() {

		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao = 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
		}else{
			if($_SESSION['Usuario']['Nivel'] == 2){
				$permissao = 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
			}else{
				$permissao = 'P.Nivel = "1" AND';
			}
		}
		
        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				P.CpfUsuario,
				P.CelularUsuario,
				CONCAT(IFNULL(P.Nome,"")) AS NomeUsuario
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
				' . $permissao . '
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND 
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				P.Nome ASC
        ');

        $array = array();
		
		if($_SESSION['Usuario']['Nivel'] == 1){
			$array[0] = ':: Todos ::';
		}
		
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }

        return $array;
    }

	public function select_compartilhar() {

		if($_SESSION['log']['idSis_Empresa'] == 5){
			$permissao = 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
		}else{
			if($_SESSION['Usuario']['Nivel'] == 2){
				$permissao = 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND';
			}else{
				$permissao = 'P.Nivel = "1" AND';
			}
		}
		
        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS NomeUsuario
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
				' . $permissao . '
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				P.Nome ASC
        ');

        $array = array();
		
		if($_SESSION['log']['idSis_Empresa'] != 5){
			if($_SESSION['Usuario']['Nivel'] == 1){
				$array[0] = ':: Todos ::';
			}
		}
		
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }

        return $array;
    }
	
	public function select_usuario1() {
		
        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				P.CpfUsuario,
				P.CelularUsuario,
				CONCAT(IFNULL(F.Abrev,""), " --- ", IFNULL(P.Nome,"")) AS NomeUsuario
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND 
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				F.Abrev ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->CpfUsuario] = $row->NomeUsuario;
        }

        return $array;
    }	
	
    public function select_status_sn2($data = FALSE) {

        $query = $this->db->query('
            SELECT
                idTab_StatusSN,
                StatusSN,
				Abrev
            FROM
                Tab_StatusSN 

            ORDER BY
                StatusSN DESC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->Abrev] = $row->StatusSN;
        }

        return $array;
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

    public function select_cliente() {

        $query = $this->db->query('
            SELECT
                C.idApp_Cliente,
                CONCAT(IFNULL(C.NomeCliente, ""), " --- ", IFNULL(C.CelularCliente, ""), " --- ", IFNULL(C.Telefone2, ""), " --- ", IFNULL(C.Telefone3, "")) As NomeCliente
            FROM
                App_Cliente AS C

            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                C.NomeCliente ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Cliente] = $row->NomeCliente;
        }

        return $array;
    }

    public function select_empresarec() {

        $query = $this->db->query('
            SELECT
                ER.idSis_Empresa,
                ER.NomeEmpresa
            FROM
                Sis_Empresa AS ER

            WHERE
                ER.idSis_Empresa != "1"
			ORDER BY	
                ER.NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresa;
        }

        return $array;
    }

    public function select_empresaenv() {

        $query = $this->db->query('
            SELECT
                EE.idSis_Empresa,
                EE.NomeEmpresa AS NomeEmpresaCli
            FROM
                Sis_Empresa AS EE

            WHERE
                EE.idSis_Empresa != "1"
			ORDER BY	
                EE.NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresaCli;
        }

        return $array;
    }	

    public function select_tarefa_original() {

        $query = $this->db->query('
            SELECT
                P.idApp_Tarefa,
                P.Tarefa
            FROM
                App_Tarefa AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" AND
				P.idSis_EmpresaCli = "0" AND
				U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' 
            ORDER BY
                P.idApp_Tarefa ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Tarefa] = $row->Tarefa;
        }

        return $array;
    }

	public function select_tarefa() {

		$permissao1 = (($_SESSION['FiltroAlteraTarefa']['idTab_Categoria'] != "0" ) && ($_SESSION['FiltroAlteraTarefa']['idTab_Categoria'] != '' )) ? 'P.idTab_Categoria = "' . $_SESSION['FiltroAlteraTarefa']['idTab_Categoria'] . '" AND ' : FALSE;
		$permissao2 = (($_SESSION['FiltroAlteraTarefa']['ConcluidoTarefa'] != "0" ) && ($_SESSION['FiltroAlteraTarefa']['ConcluidoTarefa'] != '' )) ? 'P.ConcluidoTarefa = "' . $_SESSION['FiltroAlteraTarefa']['ConcluidoTarefa'] . '" AND ' : FALSE;
		$permissao3 = (($_SESSION['FiltroAlteraTarefa']['Prioridade'] != "0" ) && ($_SESSION['FiltroAlteraTarefa']['Prioridade'] != '' )) ? 'P.Prioridade = "' . $_SESSION['FiltroAlteraTarefa']['Prioridade'] . '" AND ' : FALSE;
		$permissao6 = (($_SESSION['FiltroAlteraTarefa']['Statustarefa'] != "0" ) && ($_SESSION['FiltroAlteraTarefa']['Statustarefa'] != '' )) ? 'P.Statustarefa = "' . $_SESSION['FiltroAlteraTarefa']['Statustarefa'] . '" AND ' : FALSE;
		$permissao7 = (($_SESSION['FiltroAlteraTarefa']['Statussubtarefa'] != "0" ) && ($_SESSION['FiltroAlteraTarefa']['Statussubtarefa'] != '' )) ? 'SP.Statussubtarefa = "' . $_SESSION['FiltroAlteraTarefa']['Statussubtarefa'] . '" AND ' : FALSE;
		$permissao8 = (($_SESSION['FiltroAlteraTarefa']['SubPrioridade'] != "0" ) && ($_SESSION['FiltroAlteraTarefa']['SubPrioridade'] != '' )) ? 'SP.SubPrioridade = "' . $_SESSION['FiltroAlteraTarefa']['SubPrioridade'] . '" AND ' : FALSE;
		$permissao4 = ((($_SESSION['FiltroAlteraTarefa']['ConcluidoSubTarefa'] != "0")&& ($_SESSION['FiltroAlteraTarefa']['ConcluidoSubTarefa'] != 'M') ) && ($_SESSION['FiltroAlteraTarefa']['ConcluidoSubTarefa'] != '' )) ? 'SP.ConcluidoSubTarefa = "' . $_SESSION['FiltroAlteraTarefa']['ConcluidoSubTarefa'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['FiltroAlteraTarefa']['ConcluidoSubTarefa'] == 'M') && ($_SESSION['FiltroAlteraTarefa']['ConcluidoSubTarefa'] != '' )) ? '((SP.ConcluidoSubTarefa = "S") OR (SP.ConcluidoSubTarefa = "N")) AND ' : FALSE;		
		
		$query = $this->db->query('
            SELECT
                P.idApp_Tarefa,
                P.Tarefa
            FROM
				App_Tarefa AS P
					LEFT JOIN App_SubTarefa AS SP ON SP.idApp_Tarefa = P.idApp_Tarefa
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoTarefa
					LEFT JOIN Tab_Prioridade AS PR ON PR.idTab_Prioridade = P.Prioridade
            WHERE
				' . $permissao1 . '
				' . $permissao3 . '
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao8 . '
				(U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				AU.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				P.Compartilhar = ' . $_SESSION['log']['idSis_Usuario'] . ' OR
				(P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') OR
				(P.Compartilhar = 51 AND P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '))
            ORDER BY
                P.Tarefa ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Tarefa] = $row->Tarefa;
        }

        return $array;
    }
	
}
