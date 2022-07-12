<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Basico_model extends CI_Model {

    public function __construct() {
        #parent::__construct();
        $this->load->database();
        $this->load->library(array('basico', 'user_agent'));
    }

    function set_auditoria($auditoriaitem, $tabela, $operacao, $data, $id = NULL) {

        if ($id == NULL)
            $id = $_SESSION['log']['idSis_Usuario'];

        $auditoria = array(
            'Tabela' => $tabela,
            'idSis_Usuario' => $id,
            'DataAuditoria' => date('Y-m-d H:i:s', time()),
            'Operacao' => $operacao,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
        );

        if ($this->db->insert('Sis_Auditoria', $auditoria)) {
            $i = 0;
            while (isset($data['auditoriaitem'][$i])) {
                $data['auditoriaitem'][$i]['idSis_Auditoria'] = $this->db->insert_id();
                $i++;
            }

            $this->db->insert_batch('Sis_AuditoriaItem', $data['auditoriaitem']);
        }
    }

    function set_auditoriacli($auditoriaitem, $tabela, $operacao, $data, $id = NULL) {

        if ($id == NULL)
            $id = $_SESSION['log']['idSis_UsuarioCli'];

        $auditoria = array(
            'Tabela' => $tabela,
            'idSis_UsuarioCli' => $id,
            'DataAuditoria' => date('Y-m-d H:i:s', time()),
            'Operacao' => $operacao,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
        );

        if ($this->db->insert('Sis_AuditoriaCli', $auditoria)) {
            $i = 0;
            while (isset($data['auditoriaitem'][$i])) {
                $data['auditoriaitem'][$i]['idSis_AuditoriaCli'] = $this->db->insert_id();
                $i++;
            }

            $this->db->insert_batch('Sis_AuditoriaItemCli', $data['auditoriaitem']);
        }
    }
	
    function set_auditoriaempresa($auditoriaitem, $tabela, $operacao, $data, $id = NULL) {

        if ($id == NULL)
            $id = $_SESSION['log']['idSis_Empresa'];

        $auditoria = array(
            'Tabela' => $tabela,
            'idSis_Empresa' => $id,
            'DataAuditoria' => date('Y-m-d H:i:s', time()),
            'Operacao' => $operacao,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
        );

        if ($this->db->insert('Sis_AuditoriaEmpresa', $auditoria)) {
            $i = 0;
            while (isset($data['auditoriaitem'][$i])) {
                $data['auditoriaitem'][$i]['idSis_AuditoriaEmpresa'] = $this->db->insert_id();
                $i++;
            }

            $this->db->insert_batch('Sis_AuditoriaItemEmpresa', $data['auditoriaitem']);
        }
    }

    function set_auditoriaempresamatriz($auditoriaitem, $tabela, $operacao, $data, $id = NULL) {

        if ($id == NULL)
            $id = $_SESSION['log']['idSis_EmpresaMatriz'];

        $auditoria = array(
            'Tabela' => $tabela,
            'idSis_EmpresaMatriz' => $id,
            'DataAuditoria' => date('Y-m-d H:i:s', time()),
            'Operacao' => $operacao,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
        );

        if ($this->db->insert('Sis_AuditoriaEmpresaMatriz', $auditoria)) {
            $i = 0;
            while (isset($data['auditoriaitem'][$i])) {
                $data['auditoriaitem'][$i]['idSis_AuditoriaEmpresaMatriz'] = $this->db->insert_id();
                $i++;
            }

            $this->db->insert_batch('Sis_AuditoriaItemEmpresaMatriz', $data['auditoriaitem']);
        }
    }

    public function get_dt_validade() {

        if (isset($_SESSION['log']['idSis_Empresa'])) {
			
			if ($_SESSION['log']['idSis_Empresa'] == 5) {
				return TRUE;
			} else {
				
				if (!isset($_SESSION['log']['DataDeValidade'])) {
					return FALSE;
				} else {
					
					$dt_val_extra 	= date('Y-m-d', strtotime('+ 7 day',strtotime($_SESSION['log']['DataDeValidade'])));
					$dt_hoje 	= date('Y-m-d', time());

					if(strtotime($dt_val_extra) >= strtotime($dt_hoje)){
						return TRUE;
					}else{
						return FALSE;
					}
				}
			}
        } else {
            return FALSE;
        }
    }
	
    public function get_municipio($data) {

        if (isset($data) && $data) {

            $query = $this->db->query('SELECT * FROM Tab_Municipio WHERE idTab_Municipio = ' . $data);

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0];
            }
        } else {
            return "---";
        }
    }

    public function get_sexo($data) {

        if (isset($data) && $data) {

            #$query = $this->db->query('SELECT * FROM Tab_Sexo WHERE idTab_Sexo = ' . $data);
            $query = $this->db->query('SELECT * FROM Tab_Sexo WHERE Abrev = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
			$query = $query->result_array();
                return $query[0]['Sexo'];
            }
        } else {
            return '';
        }
    }

	public function get_relacao($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_Relacao WHERE idTab_Relacao = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Relacao'];
            }
        } else {
            return '';
        }
    }
	
	public function get_relacom($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_RelaCom WHERE idTab_RelaCom = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['RelaCom'];
            }
        } else {
            return '';
        }
    }

	public function get_relapes($data) {

        if (isset($data) && $data) {

$query = $this->db->query('SELECT * FROM Tab_RelaPes WHERE idTab_RelaPes = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['RelaPes'];
            }
        } else {
            return '';
        }
    }

	public function get_funcao($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_Funcao WHERE idTab_Funcao = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Funcao'];
            }
        } else {
            return '';
        }
    }

	public function get_permissao($data) {
		
        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Sis_Permissao WHERE idSis_Permissao = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Nivel'];
            }
        } else {
            return '';
        }
    }

	public function get_atividade($data) {

if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM App_Atividade WHERE idApp_Atividade = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Atividade'];
            }
        } else {
            return '';
        }
    }

	public function get_tipofornec($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_TipoFornec WHERE Abrev = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['TipoFornec'];
            }
        } else {
            return '';
        }
    }

	public function get_vendafornec($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_StatusSN WHERE Abrev = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['StatusSN'];
            }
        } else {
            return '';
        }
    }

	public function get_ativo($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_StatusSN WHERE Abrev = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['StatusSN'];
            }
        } else {
            return '';
        }
    }

	public function get_compagenda($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_StatusSN WHERE Abrev = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['StatusSN'];
            }
        } else {
            return '';
        }
    }
	
	public function get_inativo($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_StatusSN WHERE Inativo = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['StatusSN'];
            }
        } else {
            return '';
        }
    }
	
	public function get_empresa($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
					SELECT *
					FROM
						Sis_Empresa
					WHERE
						idSis_Empresa = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['NomeEmpresa'];
            }
        } else {
            return '';
        }
    }
	
	public function get_end_empresa($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
					SELECT *
					FROM
						Sis_Empresa
					WHERE
						idSis_Empresa = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0];
            }
        } else {
            return '';
        }
    }	
	
	public function get_tipofinanceiro($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
				SELECT *
					FROM
						Tab_TipoFinanceiro
					WHERE
						idTab_TipoFinanceiro = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['TipoFinanceiro'];
            }
        } else {
            return '';
        }
    }

	public function get_avap($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
				SELECT *
					FROM
						Tab_Modalidade
					WHERE
						Abrev2 = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Abrev3'];
            }
        } else {
            return '';
        }
    }
	
	public function get_modalidade($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
				SELECT *
					FROM
						Tab_Modalidade
					WHERE
						Abrev = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Modalidade'];
            }
        } else {
            return '';
        }
    }	

	public function get_formapagamento($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
				SELECT *
					FROM
						Tab_FormaPag
					WHERE
						idTab_FormaPag = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['FormaPag'];
            }
        } else {
            return '';
        }
    }
	
	public function get_cliente($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
				SELECT *
					FROM
						App_Cliente
					WHERE
						idApp_Cliente = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['NomeCliente'];
            }
        } else {
            return '';
        }
    }
	
	public function get_usuario_online($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
				SELECT *
					FROM
						Sis_Usuario
					WHERE
						idSis_Usuario = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Nome'];
            }
        } else {
            return '';
        }
    }	
	
	public function get_categoriaempresa($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
				SELECT *
					FROM
						Tab_CategoriaEmpresa
					WHERE
						idTab_CategoriaEmpresa = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['CategoriaEmpresa'];
            }
        } else {
            return '';
        }
    }	
	
	public function get_profissional($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
				SELECT *
					FROM
						Sis_Usuario
					WHERE
						idSis_Usuario = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Nome'];
            }
        } else {
            return '';
        }
    }	

    public function select_item($modulo, $tabela, $campo = FALSE, $campoitem = FALSE) {

        if ($campo !== FALSE) {
            $query = $this->db->query('SELECT id' . $modulo . '_' . $tabela . ' AS Id, ' . $tabela . ' AS Item FROM '
                    . '' . $modulo . '_' . $tabela . ' '
                    . 'WHERE ' . $campo . ' = "' . $campoitem . '" ORDER BY ' . $tabela . ' ASC');
        } else {
            $query = $this->db->query('SELECT id' . $modulo . '_' . $tabela . ' AS Id, ' . $tabela . ' AS Item FROM '
                    . '' . $modulo . '_' . $tabela . ' ORDER BY ' . $tabela . ' ASC');
        }

        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Id] = $row->Item;
            }

            /*
              echo $this->db->last_query();
              echo '<br>';
              echo "<pre>";
              print_r($array);
              echo "</pre>";
              exit();
             */

            return $array;
        }
    }

    public function select_nacionalidade() {

        $query = $this->db->query('SELECT * FROM Tab_Nacionalidade ORDER BY Nacionalidade ASC');

        $array = array();
        $array[0] = ':: SELECIONE ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Nacionalidade] = $row->Nacionalidade;
        }

        return $array;
    }

    public function select_estado_civil($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_EstadoCivil ORDER BY EstadoCivil ASC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_EstadoCivil ORDER BY EstadoCivil ASC');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_EstadoCivil] = $row->EstadoCivil;
            }
        }

        return $array;
    }

    public function select_uf($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Uf ORDER BY Uf ASC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Uf ORDER BY Uf ASC');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Uf] = $row->Uf;
            }
        }

        return $array;
    }

    public function select_sexo($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Sexo');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Sexo');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->Sexo;
            }
        }

        return $array;
    }

    public function select_tipo_consulta($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_TipoConsulta');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_TipoConsulta');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoConsulta] = $row->TipoConsulta;
            }
        }

        return $array;
    }

	public function select_tipo_concluido($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_TipoConcluido');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_TipoConcluido');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoConcluido] = $row->TipoConcluido;
            }
        }

        return $array;
    }

	public function select_tipo_tratamentos($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_TipoConsulta');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_TipoConsulta');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoConsulta] = $row->TipoConsulta;
            }
        }

        return $array;
    }

    public function select_status($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Status');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Status');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Status] = $row->Status;
            }
        }

        return $array;
    }

    public function select_municipio2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Municipio ORDER BY NomeMunicipio ASC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Municipio ORDER BY NomeMunicipio ASC');

            $array = array();
            #$array[0] = ':: SELECIONE ::';
            foreach ($query->result() as $row) {
                $array[$row->idTab_Municipio] = $row->NomeMunicipio;
            }
        }

        return $array;
    }

	public function select_municipio($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
				'SELECT
					idTab_Municipio,
					CONCAT(Uf, " - ", NomeMunicipio) AS NomeMunicipio
				FROM
					Tab_Municipio
				ORDER BY NomeMunicipio ASC, Uf ASC'
				);
        } else {
            $query = $this->db->query(
				'SELECT
					idTab_Municipio,
					CONCAT(Uf, " - ", NomeMunicipio) AS NomeMunicipio
				FROM
					Tab_Municipio
				ORDER BY Uf ASC, NomeMunicipio ASC'
				);

            $array = array();
            #$array[0] = ':: SELECIONE ::';
            foreach ($query->result() as $row) {
                $array[$row->idTab_Municipio] = $row->NomeMunicipio;
            }
        }

        return $array;
    }
	
    public function select_cliente() {

        $query = $this->db->query('
            SELECT
                C.idApp_Cliente,
                CONCAT(IFNULL(C.NomeCliente, ""), " --- ", IFNULL(C.CelularCliente, "")) As NomeCliente
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

    public function select_fornecedor() {

        $query = $this->db->query('
            SELECT
                C.idApp_Fornecedor,
                CONCAT(IFNULL(C.NomeFornecedor, "")) As NomeFornecedor
            FROM
                App_Fornecedor AS C

            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                C.NomeFornecedor ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Fornecedor] = $row->NomeFornecedor;
        }

        return $array;
    }

    public function select_motivo() {

        $query = $this->db->query('
            SELECT
                *,
				CONCAT(Motivo, " --- ", Desc_Motivo) AS Motivo
            FROM
                Tab_Motivo
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                Motivo ASC
        ');

        $array = array();
        foreach ($query->result() as $row) {
			$array[$row->idTab_Motivo] = $row->Motivo;
        }

        return $array;
    }
	
	public function select_orcatrata($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", C.NomeCliente) AS NomeCliente,
					C.idApp_Cliente
				FROM
					App_OrcaTrata AS P
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
				WHERE
					P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					P.TipoRD = "R" AND
					P.ServicoConcluido = "N"
				ORDER BY
					idApp_OrcaTrata ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
					P.idApp_OrcaTrata,
					CONCAT(P.idApp_OrcaTrata, " --- ", C.NomeCliente) AS NomeCliente,
					C.idApp_Cliente
				FROM
					App_OrcaTrata AS P
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
				WHERE
					P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					P.TipoRD = "R" AND
					P.ServicoConcluido = "N"
				ORDER BY
					idApp_OrcaTrata ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_OrcaTrata] = $row->NomeCliente;
            }
        }

        return $array;
    }
	
	public function select_orcatrata2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", C.NomeCliente) AS NomeCliente,
					C.idApp_Cliente
				FROM
					App_OrcaTrata AS P
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
				WHERE
					P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					P.TipoRD = "R" AND
					C.idApp_Cliente = ' . $_SESSION['Cliente']['idApp_Cliente'] . ' AND
					P.ServicoConcluido = "N"
				ORDER BY
					idApp_OrcaTrata ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
					P.idApp_OrcaTrata,
					CONCAT(P.idApp_OrcaTrata, " --- ", C.NomeCliente) AS NomeCliente,
					C.idApp_Cliente
				FROM
					App_OrcaTrata AS P
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
				WHERE
					P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					P.TipoRD = "R" AND
					C.idApp_Cliente = ' . $_SESSION['Cliente']['idApp_Cliente'] . ' AND
					P.ServicoConcluido = "N"
				ORDER BY
					idApp_OrcaTrata ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_OrcaTrata] = $row->NomeCliente;
            }
        }

        return $array;
    }
	
	public function select_orcatrata3($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", C.NomeCliente) AS NomeCliente,
					C.idApp_Cliente
				FROM
					App_OrcaTrata AS P
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
				WHERE
					P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					P.TipoRD = "R" AND
					C.idApp_Cliente = ' . $_SESSION['Cliente']['idApp_Cliente'] . ' 
				ORDER BY
					idApp_OrcaTrata ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
					P.idApp_OrcaTrata,
					CONCAT(P.idApp_OrcaTrata, " --- ", C.NomeCliente) AS NomeCliente,
					C.idApp_Cliente
				FROM
					App_OrcaTrata AS P
						LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
				WHERE
					P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					P.TipoRD = "R" AND
					C.idApp_Cliente = ' . $_SESSION['Cliente']['idApp_Cliente'] . ' 
				ORDER BY
					idApp_OrcaTrata ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_OrcaTrata] = $row->NomeCliente;
            }
        }

        return $array;
    }
	
	public function select_profissional($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
				'SELECT
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao


                ORDER BY F.Abrev ASC, P.NomeProfissional ASC'
    );

        } else {
            $query = $this->db->query(
                'SELECT
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao


                ORDER BY F.Abrev ASC, P.NomeProfissional ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Profissional] = $row->NomeProfissional;
            }
        }

        return $array;
    }

	public function select_promocao($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				P.idTab_Promocao,
				P.Promocao,
				P.Descricao,
				CONCAT(IFNULL(P.Promocao,""), " - ", IFNULL(P.Descricao,"")) AS Promocao
            FROM
                Tab_Promocao AS P
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
				ORDER BY 
				P.Promocao ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				P.idTab_Promocao,
				P.Promocao,
				P.Descricao,
				CONCAT(IFNULL(P.Promocao,""), " - ", IFNULL(P.Descricao,"")) AS Promocao
            FROM
                Tab_Promocao AS P
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				P.Promocao ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Promocao] = $row->Promocao;
            }
        }

        return $array;
    }

	public function select_atributo($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				P.*,
				CONCAT(IFNULL(P.Atributo,"")) AS Atributo
            FROM
                Tab_Atributo AS P
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Catprod = ' . $data . '
			ORDER BY 
				P.Atributo ASC
			');
        } else {
            $query = $this->db->query('
            SELECT
				P.*,
				CONCAT(IFNULL(P.Atributo,"")) AS Atributo
            FROM
                Tab_Atributo AS P
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Catprod = ' . $data . '
			ORDER BY 
				P.Atributo ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Atributo] = $row->Atributo;
            }
        }

        return $array;
    }
	
	public function select_produto($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				P.idTab_Produto,
				P.idTab_Catprod,
				P.Produtos,
				CONCAT(IFNULL(P.Produtos,"")) AS Produtos
            FROM
                Tab_Produto AS P
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Catprod = ' . $data . '
			ORDER BY 
				P.Produtos ASC
			');
        } else {
            $query = $this->db->query('
            SELECT
				P.idTab_Produto,
				P.idTab_Catprod,
				P.Produtos,
				CONCAT(IFNULL(P.Produtos,"")) AS Produtos
            FROM
                Tab_Produto AS P
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Catprod = ' . $data . '
			ORDER BY 
				P.Produtos ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->Produtos;
            }
        }

        return $array;
    }
	
	public function select_produto1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT
				P.idTab_Produto,
				CONCAT(CO.Abrev, " --- ", PB.ProdutoBase, " --- ", PB.UnidadeProdutoBase, " --- ", EM.NomeEmpresa, " ---R$", P.ValorProduto) AS ProdutoBase
            FROM
                Tab_Produto AS P
				LEFT JOIN Tab_ProdutoBase AS PB ON PB.idTab_ProdutoBase = P.ProdutoBase
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = P.Convenio
				LEFT JOIN Sis_Empresa AS EM ON EM.idSis_Empresa = P.idSis_Empresa
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY CO.Convenio DESC, PB.ProdutoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT
				P.idTab_Produto,
				CONCAT(CO.Abrev, " --- ", PB.ProdutoBase, " --- ", PB.UnidadeProdutoBase, " --- ", EM.NomeEmpresa, " ---R$", P.ValorProduto) AS ProdutoBase
            FROM
                Tab_Produto AS P
				LEFT JOIN Tab_ProdutoBase AS PB ON PB.idTab_ProdutoBase = P.ProdutoBase
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = P.Convenio
				LEFT JOIN Sis_Empresa AS EM ON EM.idSis_Empresa = P.idSis_Empresa
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY CO.Convenio DESC, PB.ProdutoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->ProdutoBase;
            }
        }

        return $array;
    }

	public function select_produto_original($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT
                TPV.idTab_Produto,
				CONCAT(TPV.NomeProduto, " --- ", TPV.UnidadeProduto, " --- R$ ", TPV.ValorProduto) AS NomeProduto,
				TPV.ValorProduto
            FROM
                Tab_Produto AS TPV
            WHERE
				TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TPV.Empresa = ' . $_SESSION['log']['idSis_Usuario'] . ' OR
				 TPV.Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ')
			ORDER BY
				TPV.NomeProduto ASC
    ');
        } else {
            $query = $this->db->query(
                'SELECT
                TPV.idTab_Produto,
				CONCAT(TPV.NomeProduto, " --- ", TPV.UnidadeProduto, " --- R$ ", TPV.ValorProduto) AS NomeProduto,
				TPV.ValorProduto
            FROM
                Tab_Produto AS TPV
            WHERE
				TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TPV.Empresa = ' . $_SESSION['log']['idSis_Usuario'] . ' OR
				 TPV.Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ')
			ORDER BY
				TPV.NomeProduto ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->NomeProduto;
            }
        }

        return $array;
    }

	public function select_produtos2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                idTab_Produto,
                CONCAT(IFNULL(Produtos,"")) AS NomeProduto,
                ValorCompraProduto
            FROM 
                Tab_Produto 
            WHERE
			idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
    ');
        } else {
            $query = $this->db->query('
            SELECT
                idTab_Produto,
                CONCAT(IFNULL(Produtos,"")) AS NomeProduto,
                ValorCompraProduto
            FROM 
                Tab_Produto 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->NomeProduto;
            }
        }

        return $array;
    }

	public function select_produtos3($data = FALSE) {
		$filtro1 = ($data == "B") ? ' AND V.VendaBalcaoPreco = "S"  ': ' AND V.VendaSitePreco = "S"  ';
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                V.idTab_Valor,
				V.idTab_Produtos,
                V.ValorProduto,
				V.QtdProdutoIncremento,
				V.Convdesc,
				TDS.Desconto,
				TPM.Promocao,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(V.Convdesc,""), " - ", IFNULL(P.Cod_Barra,""), " - ", IFNULL(V.QtdProdutoIncremento,""), " UNID - ", IFNULL(TDS.Desconto,""), " - ", IFNULL(TPM.Promocao,""), " - R$", IFNULL(V.ValorProduto,"")) AS NomeProduto
            FROM
                Tab_Valor AS V
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos				
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
				P.Prod_Serv = "P"
				' . $filtro1 . '
			ORDER BY
				TDS.Desconto ASC,
				P.Nome_Prod ASC,
				TPM.Promocao ASC
			');
        } else {
            $query = $this->db->query('
            SELECT
                V.idTab_Valor,
				V.idTab_Produtos,
                V.ValorProduto,
				V.QtdProdutoIncremento,
				V.Convdesc,
				TDS.Desconto,
				TPM.Promocao,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(V.Convdesc,""), " - ", IFNULL(P.Cod_Barra,""), " - ", IFNULL(V.QtdProdutoIncremento,""), " UNID - ", IFNULL(TDS.Desconto,""), " - ", IFNULL(TPM.Promocao,""), " - R$", IFNULL(V.ValorProduto,"")) AS NomeProduto
            FROM
                Tab_Valor AS V
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos				
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
				P.Prod_Serv = "P"
				' . $filtro1 . '
			ORDER BY
				TDS.Desconto ASC,
				P.Nome_Prod ASC,
				TPM.Promocao ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Valor] = $row->NomeProduto;
            }
        }

        return $array;
    }

	public function select_servicos3($data = FALSE) {
		$filtro1 = ($data == "B") ? ' AND V.VendaBalcaoPreco = "S"  ': ' AND V.VendaSitePreco = "S"  ';
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                V.idTab_Valor,
				V.idTab_Produtos,
                V.ValorProduto,
				V.QtdProdutoIncremento,
				V.Convdesc,
				TDS.Desconto,
				TPM.Promocao,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(V.Convdesc,""), " - ", IFNULL(P.Cod_Barra,""), " - ", IFNULL(V.QtdProdutoIncremento,""), " UNID - ", IFNULL(TDS.Desconto,""), " - ", IFNULL(TPM.Promocao,""), " - R$ ",  IFNULL(V.ValorProduto,"")) AS NomeProduto
            FROM
                Tab_Valor AS V
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos				
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.Prod_Serv = "S"
				' . $filtro1 . '
			ORDER BY
				TDS.Desconto ASC,
				P.Nome_Prod ASC,
				TPM.Promocao ASC
			');
        } else {
            $query = $this->db->query('
            SELECT
                V.idTab_Valor,
				V.idTab_Produtos,
                V.ValorProduto,
				V.QtdProdutoIncremento,
				V.Convdesc,
				TDS.Desconto,
				TPM.Promocao,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(V.Convdesc,""), " - ", IFNULL(P.Cod_Barra,""), " - ", IFNULL(V.QtdProdutoIncremento,""), " UNID - ", IFNULL(TDS.Desconto,""), " - ", IFNULL(TPM.Promocao,""), " - R$ ",  IFNULL(V.ValorProduto,"")) AS NomeProduto
            FROM
                Tab_Valor AS V
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos				
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.Prod_Serv = "S"
				' . $filtro1 . '
			ORDER BY
				TDS.Desconto ASC,
				P.Nome_Prod ASC,
				TPM.Promocao ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Valor] = $row->NomeProduto;
            }
        }

        return $array;
    }
	
	public function select_produto2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TOP2.Opcao,
				TOP1.Opcao,
                CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS NomeProduto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.Prod_Serv = "P"
			ORDER BY
				TPS.Nome_Prod ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TOP2.Opcao,
				TOP1.Opcao,
                CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS NomeProduto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.Prod_Serv = "P"
			ORDER BY
				TPS.Nome_Prod ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produtos] = $row->NomeProduto;
            }
        }

        return $array;
    }

	public function select_servico2($data = FALSE) {
		
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TOP2.Opcao,
				TOP1.Opcao,
                CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS NomeProduto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.Prod_Serv = "S"
			ORDER BY
				TPS.Nome_Prod ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TOP2.Opcao,
				TOP1.Opcao,
                CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS NomeProduto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.Prod_Serv = "S"
			ORDER BY
				TPS.Nome_Prod ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produtos] = $row->NomeProduto;
            }
        }

        return $array;
    }
	
	public function select_prod_der0($data = FALSE) {
		
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . '
			ORDER BY
				TPS.Nome_Prod ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . '
			ORDER BY
				TPS.Nome_Prod ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produtos] = $row->Nome_Prod;
            }
        }

        return $array;
    }	
	
	public function select_produto_promocao($data = FALSE) {
		
		//$permissao1 = isset($_SESSION['Promocao']['Mod_1']) ? 'AND TPS.idTab_Produto = ' . $_SESSION['Promocao']['Mod_1'] : 'AND TPS.idTab_Produto = "0"';
        
		if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                TPS.*
            FROM 
                Tab_Produtos AS TPS
            WHERE
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY
				TPS.Nome_Prod ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                TPS.*
            FROM 
                Tab_Produtos AS TPS			
            WHERE
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY
				TPS.Nome_Prod ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produtos] = $row->Nome_Prod;
            }
        }

        return $array;
    }
	
	public function select_prod_der($data = FALSE) {
		
		$permissao1 = isset($_SESSION['Promocao']['Mod_1']) ? 'AND TPS.idTab_Produto = ' . $_SESSION['Promocao']['Mod_1'] : 'AND TPS.idTab_Produto = "0"';
        
		if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
				' . $permissao1 . '
			ORDER BY
				TPS.Nome_Prod ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2			
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				' . $permissao1 . '
			ORDER BY
				TPS.Nome_Prod ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produtos] = $row->Nome_Prod;
            }
        }

        return $array;
    }
	
	public function select_prod_der2($data = FALSE) {

		$permissao2 = isset($_SESSION['Promocao']['Mod_2']) ? 'AND TPS.idTab_Produto = ' . $_SESSION['Promocao']['Mod_2'] : 'AND TPS.idTab_Produto = "0"';
		
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
				' . $permissao2 . '
			ORDER BY
				TPS.Nome_Prod ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
				' . $permissao2 . '
			ORDER BY
				TPS.Nome_Prod ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produtos] = $row->Nome_Prod;
            }
        }

        return $array;
    }
	
	public function select_prod_der3($data = FALSE) {

		$permissao3 = isset($_SESSION['Promocao']['Mod_3']) ? 'AND TPS.idTab_Produto = ' . $_SESSION['Promocao']['Mod_3'] : 'AND TPS.idTab_Produto = "0"';
	
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
				' . $permissao3 . '
			ORDER BY
				TPS.Nome_Prod ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
				' . $permissao3 . '
			ORDER BY
				TPS.Nome_Prod ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produtos] = $row->Nome_Prod;
            }
        }

        return $array;
    }	
	
	public function select_servico4($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                TSV.idTab_Servico,
                CONCAT(TCO.Abrev, " --- ", TSB.ServicoBase, " --- R$ ", TSV.ValorServico) AS ServicoBase,
                TSV.ValorServico
            FROM
                Tab_Servico AS TSV
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TSV.Convenio
				LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSV.ServicoBase
            WHERE
                TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSV.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY
				TCO.Convenio DESC,
				TSB.ServicoBase ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                TSV.idTab_Servico,
                CONCAT(TCO.Abrev, " --- ", TSB.ServicoBase, " --- R$ ", TSV.ValorServico) AS ServicoBase,
                TSV.ValorServico
            FROM
                Tab_Servico AS TSV
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TSV.Convenio
				LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSV.ServicoBase
            WHERE
                TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSV.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY
				TCO.Convenio DESC,
				TSB.ServicoBase ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->ServicoBase;
            }
        }

        return $array;
    }

	public function select_servico($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT
                TSV.idTab_Servico,
                CONCAT(TSV.NomeServico, " --- R$ ", TSV.ValorServico) AS NomeServico,
                TSV.ValorServico
            FROM
                Tab_Servico AS TSV
            WHERE
				TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TSV.Empresa = ' . $_SESSION['log']['idSis_Usuario'] . ' OR
				 TSV.Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ')
			ORDER BY
				TSV.NomeServico ASC
    ');
        } else {
            $query = $this->db->query(
                'SELECT
                TSV.idTab_Servico,
                CONCAT(TSV.NomeServico, " --- R$ ", TSV.ValorServico) AS NomeServico,
                TSV.ValorServico
            FROM
                Tab_Servico AS TSV
            WHERE
				TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TSV.Empresa = ' . $_SESSION['log']['idSis_Usuario'] . ' OR
				 TSV.Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ')
			ORDER BY
				TSV.NomeServico ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->NomeServico;
            }
        }

        return $array;
    }

	public function select_servico2_bkp($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Servico, '
                    . 'NomeServico, '
                    . 'ValorServico, '
					. 'ValorCompraServico '
                    . 'FROM '
                    . 'Tab_Servico '
                    . 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] );
        } else {
            $query = $this->db->query('SELECT idTab_Servico, NomeServico, ValorServico, ValorCompraServico  FROM Tab_Servico WHERE idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario']);

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->NomeServico;
            }
        }

        return $array;
    }

	public function select_status_sn($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN ORDER BY Abrev ASC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN ORDER BY Abrev ASC');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->StatusSN;
            }
        }

        return $array;
    }
	
	public function select_status_sn1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN ORDER BY Abrev DESC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN ORDER BY Abrev DESC');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->StatusSN;
            }
        }

        return $array;
    }	

	public function select_status_sn2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_StatusSN] = $row->StatusSN;
            }
        }

        return $array;
    }
	
	public function select_inativo($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Inativo] = $row->StatusSN;
            }
        }

        return $array;
    }
	
	public function select_inativo2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_StatusSN] = $row->StatusSN;
            }
        }

        return $array;
    }	

	public function select_tipoproduto($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_TipoProduto');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_TipoProduto');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->TipoProduto;
            }
        }

        return $array;
    }

	public function select_unidadeproduto($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_UnidadeProduto');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_UnidadeProduto');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->UnidadeProduto;
            }
        }

        return $array;
    }

	public function select_categoria($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Categoria');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Categoria');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->Categoria;
            }
        }

        return $array;
    }
	
	public function select_prod_serv($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Prod_Serv');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Prod_Serv');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev_Prod_Serv] = $row->Prod_Serv;
            }
        }

        return $array;
    }	

	public function select_categoriatarefa($data = FALSE) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        if ($data === TRUE) {
            $array = $this->db->query('
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
        } else {
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
        }

        return $array;
    }
		
	public function select_categoriaempresa($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_CategoriaEmpresa');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_CategoriaEmpresa');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_CategoriaEmpresa] = $row->CategoriaEmpresa;
            }
        }

        return $array;
    }	
	
	public function select_categoriadesp($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Categoriadesp');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Categoriadesp');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Categoriadesp] = $row->Categoriadesp;
            }
        }

        return $array;
    }

	public function select_tipofornec($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_TipoFornec');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_TipoFornec');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->TipoFornec;
            }
        }

        return $array;
    }

	public function select_permissao($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    idSis_Permissao,
                    Permissao,
					CONCAT(Nivel, " -- ", Permissao) AS Nivel
				FROM
                    Sis_Permissao

				ORDER BY idSis_Permissao ASC
			');

        } else {
            $query = $this->db->query('
				SELECT
                    idSis_Permissao,
                    Permissao,
					CONCAT(Nivel, " -- ", Permissao) AS Nivel
				FROM
                    Sis_Permissao

				ORDER BY idSis_Permissao ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Permissao] = $row->Nivel;
            }
        }

        return $array;
    }
	
	public function select_numusuarios($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    idTab_NumUsuarios,
					DescNumUsuarios,
					CONCAT(DescNumUsuarios) AS NumUsuarios
				FROM
                    Tab_NumUsuarios
				ORDER BY 
					idTab_NumUsuarios ASC
			');

        } else {
            $query = $this->db->query('
                SELECT
                    idTab_NumUsuarios,
					DescNumUsuarios,
					CONCAT(DescNumUsuarios) AS NumUsuarios
				FROM
                    Tab_NumUsuarios
				ORDER BY 
					idTab_NumUsuarios ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_NumUsuarios] = $row->NumUsuarios;
            }
        }

        return $array;
    }	

	public function select_agenda($data = FALSE) {
		/*
        $q = (($_SESSION['log']['idSis_Empresa'] == 5) || ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] >= 3)) ?
            ' U.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		*/
		if($_SESSION['log']['idSis_Empresa'] != 5){
			
			if($_SESSION['Usuario']['Nivel'] == 0 || $_SESSION['Usuario']['Nivel'] == 1){
				$nivel = 'AND U.Nivel = 1';
			}else{
				$nivel = 'AND U.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '';
			}
			$usuario = 'WHERE
							U.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 				
							' . $nivel . '';
		}else{
			$usuario = 'WHERE
							A.idSis_Associado = ' . $_SESSION['log']['idSis_Usuario'] . ' ';
		}

		if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    A.idApp_Agenda,
                    A.idSis_Associado,
					ASS.Nome
				FROM
                    App_Agenda AS A
						LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = A.idSis_Associado
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Associado = ASS.idSis_Associado
				' . $usuario . '
				ORDER BY
					ASS.Nome ASC
			');

        } else {
            $query = $this->db->query('
				SELECT
                    A.idApp_Agenda,
                    A.idSis_Associado,
					ASS.Nome
				FROM
                    App_Agenda AS A
						LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = A.idSis_Associado
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Associado = ASS.idSis_Associado
				' . $usuario . '
				ORDER BY
					ASS.Nome ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Agenda] = $row->Nome;
            }
        }

        return $array;
    }

	public function select_agenda_original($data = FALSE) {

        $q = (($_SESSION['log']['idSis_Empresa'] == 5) || ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] >= 3)) ?
            ' U.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    A.idApp_Agenda,
                    A.idSis_Usuario,
					U.Nome
				FROM
                    App_Agenda AS A
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = A.idSis_Usuario
				WHERE
                    ' . $q . '
					A.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				ORDER BY
					U.Nome ASC
			');

        } else {
            $query = $this->db->query('
				SELECT
                    A.idApp_Agenda,
                    A.idSis_Usuario,
					U.Nome
				FROM
                    App_Agenda AS A
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = A.idSis_Usuario
				WHERE
                    ' . $q . '
					A.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				ORDER BY
					U.Nome ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Agenda] = $row->Nome;
            }
        }

        return $array;
    }

	public function select_agenda1($data = FALSE) {

        $q = (($_SESSION['log']['idSis_Empresa'] == 5) || ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] >= 3)) ?
            ' U.CpfUsuario = ' . $_SESSION['log']['CpfUsuario'] . ' ' : FALSE;

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    A.idApp_Agenda,
                    A.idSis_Usuario,
					U.CpfUsuario,
					U.Nome
				FROM
                    App_Agenda AS A
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = A.idSis_Usuario
				WHERE
                    ' . $q . '
					
				ORDER BY
					U.Nome ASC
			');

        } else {
            $query = $this->db->query('
				SELECT
                    A.idApp_Agenda,
                    A.idSis_Usuario,
					U.CpfUsuario,
					U.Nome
				FROM
                    App_Agenda AS A
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = A.idSis_Usuario
				WHERE
                    ' . $q . '
					
				ORDER BY
					U.Nome ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->CpfUsuario] = $row->Nome;
            }
        }

        return $array;
    }
	
	public function select_agendacli($data = FALSE) {

        $q = ($_SESSION['log']['Permissao'] > 2) ?
            ' U.idSis_UsuarioCli = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    A.idApp_Agenda,
                    A.idSis_UsuarioCli,
					A.idSis_Usuario,
					A.NomeAgenda,
					U.Nome
				FROM
                    App_Agenda AS A
						LEFT JOIN Sis_UsuarioCli AS U ON U.idSis_UsuarioCli = A.idSis_UsuarioCli
				WHERE
                    ' . $q . '
					(A.NomeAgenda = "Cliente" OR A.NomeAgenda = "Padão")
				ORDER BY
					U.Nome ASC
			');

        } else {
            $query = $this->db->query('
				SELECT
                    A.idApp_Agenda,
                    A.idSis_UsuarioCli,
					A.idSis_Usuario,
					A.NomeAgenda,
					U.Nome
				FROM
                    App_Agenda AS A
						LEFT JOIN Sis_UsuarioCli AS U ON U.idSis_UsuarioCli = A.idSis_UsuarioCli
				WHERE
                    ' . $q . '
					(A.NomeAgenda = "Cliente" OR A.NomeAgenda = "Padão")
				ORDER BY
					U.Nome ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Agenda] = $row->Nome;
            }
        }

        return $array;
    }
	
	public function select_profissional2($data = FALSE) {

        $q = ($_SESSION['log']['Permissao'] > 2) ?
            ' U.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT

                    U.idSis_Usuario,
					CONCAT(IFNULL(F.Abrev,""), " --- ", IFNULL(U.Nome,"")) AS Nome

				FROM

					Sis_Usuario AS U 
						LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = U.Funcao
				WHERE
                    ' . $q . '
					U.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				ORDER BY
					F.Abrev ASC
			');

        } else {
            $query = $this->db->query('
				SELECT

                    U.idSis_Usuario,
					CONCAT(IFNULL(F.Abrev,""), " --- ", IFNULL(U.Nome,"")) AS Nome

				FROM

					Sis_Usuario AS U 
						LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = U.Funcao
				WHERE
                    ' . $q . '
					U.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				ORDER BY
					F.Abrev ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }	
	
	public function select_profissional3($data = FALSE) {

        $q = ($_SESSION['log']['Permissao'] > 2) ?
            ' U.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    C.Profissional,
					U.idSis_Usuario,
					U.Nome
				FROM
                    App_Cliente AS C,
					Sis_Usuario AS U
						LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = U.Funcao
				WHERE
                    ' . $q . '
					U.Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				ORDER BY
					U.Nome ASC
						
			');

        } else {
            $query = $this->db->query('
				SELECT
                    C.Profissional,
					U.idSis_Usuario,
					U.Nome
				FROM
                    App_Cliente AS C,
					Sis_Usuario AS U
						LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = U.Funcao
				WHERE
                    ' . $q . '
					U.Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				ORDER BY
					U.Nome ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Profissional] = $row->Nome;
            }
        }

        return $array;
    }
	
	public function select_tipoprofissional($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    idTab_TipoProfissional,
                    TipoProfissional,
					idTab_Modulo
				FROM
                    Tab_TipoProfissional
				WHERE
					idTab_Modulo = "1"
				ORDER BY TipoProfissional ASC
			');

        } else {
            $query = $this->db->query('
				SELECT
                    idTab_TipoProfissional,
                    TipoProfissional,
					idTab_Modulo
				FROM
                    Tab_TipoProfissional
				WHERE
					idTab_Modulo = "1"
				ORDER BY TipoProfissional ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoProfissional] = $row->TipoProfissional;
            }
        }

        return $array;
    }

    public function select_tipofinanceiroR($data = FALSE) {

		$permissao1 = ($_SESSION['log']['idSis_Empresa'] != 5 ) ? ' AND (TD.EP = "E" OR TD.EP = "EP")' : FALSE;
		$permissao2 = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? ' AND (TD.EP = "P" OR TD.EP = "EP" )' : FALSE;
		
        if ($data === TRUE) {
            $array = $this->db->query('
				SELECT 
					TD.idTab_TipoFinanceiro,
					TD.RD,
					CONCAT(TD.TipoFinanceiro) AS TipoFinanceiro
				FROM 
					Tab_TipoFinanceiro AS TD
				WHERE 
					TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					(TD.RD = "R" OR TD.RD = "RD")
					' . $permissao1 . '
					' . $permissao2 . '
				ORDER BY
					TD.TipoFinanceiro
			');
				   
        } 
		else {
            $query = $this->db->query('
				SELECT 
					TD.idTab_TipoFinanceiro,
					TD.RD,
					CONCAT(TD.TipoFinanceiro) AS TipoFinanceiro
				FROM 
					Tab_TipoFinanceiro AS TD
				WHERE 
					TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					(TD.RD = "R" OR TD.RD = "RD")
					' . $permissao1 . '
					' . $permissao2 . '					
				ORDER BY
					TD.TipoFinanceiro
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
            }
        }

        return $array;
    }

    public function select_tipofinanceiroD($data = FALSE) {

		$permissao1 = ($_SESSION['log']['idSis_Empresa'] != 5 ) ? ' AND (TD.EP = "E" OR TD.EP = "EP")' : FALSE;
		$permissao2 = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? ' AND (TD.EP = "P" OR TD.EP = "EP" )' : FALSE;
		
        if ($data === TRUE) {
            $array = $this->db->query('
				SELECT 
					TD.idTab_TipoFinanceiro,
					TD.RD,
					CONCAT(TD.TipoFinanceiro) AS TipoFinanceiro
				FROM 
					Tab_TipoFinanceiro AS TD
				WHERE 
					TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					(TD.RD = "D" OR TD.RD = "RD")
					' . $permissao1 . '
					' . $permissao2 . '					
				ORDER BY
					TD.TipoFinanceiro
			');
				   
        } 
		else {
            $query = $this->db->query('
				SELECT 
					TD.idTab_TipoFinanceiro,
					TD.RD,
					CONCAT(TD.TipoFinanceiro) AS TipoFinanceiro
				FROM 
					Tab_TipoFinanceiro AS TD
				WHERE 
					TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					(TD.RD = "D" OR TD.RD = "RD")
					' . $permissao1 . '
					' . $permissao2 . '					
				ORDER BY
					TD.TipoFinanceiro
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
            }
        }

        return $array;
    }
	
    public function select_tiporeceita($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
				SELECT 
					TD.idTab_TipoReceita, 
					CONCAT(TD.TipoReceita) AS TipoReceita
				FROM 
					Tab_TipoReceita AS TD
				WHERE 
					TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				ORDER BY
					TD.TipoReceita
				');
				   
        } 
		else {
            $query = $this->db->query('
				SELECT 
					TD.idTab_TipoReceita, 
					CONCAT(TD.TipoReceita) AS TipoReceita
				FROM 
					Tab_TipoReceita AS TD
				WHERE 
					TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				ORDER BY
					TD.TipoReceita
				');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoReceita] = $row->TipoReceita;
            }
        }

        return $array;
    }

    public function select_tipodespesa($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
				SELECT 
					TD.idTab_TipoDespesa, 
					TD.TipoDespesa,
					CD.Categoriadesp,
					CD.Abrevcategoriadesp
				FROM 
					Tab_TipoDespesa AS TD
						LEFT JOIN Tab_Categoriadesp AS CD ON CD.idTab_Categoriadesp = TD.Categoriadesp
				WHERE 
					TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				ORDER BY
					TD.TipoDespesa
				');
				   
        } 
		else {
            $query = $this->db->query('
				SELECT 
					TD.idTab_TipoDespesa, 
					TD.TipoDespesa,
					CD.Categoriadesp,
					CD.Abrevcategoriadesp
				FROM 
					Tab_TipoDespesa AS TD
						LEFT JOIN Tab_Categoriadesp AS CD ON CD.idTab_Categoriadesp = TD.Categoriadesp
				WHERE 
					TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				ORDER BY
					TD.TipoDespesa
				');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoDespesa] = $row->TipoDespesa;
            }
        }

        return $array;
    }
	
	public function select_modalidade($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Modalidade');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Modalidade');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->Modalidade;
            }
        }

        return $array;
    }
	
	public function select_tipofrete($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_TipoFrete');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_TipoFrete');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoFrete] = $row->TipoFrete;
            }
        }

        return $array;
    }	
	
	public function select_desconto($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
				SELECT * 
				FROM 
					Tab_Desconto
			');
        } else {
            $query = $this->db->query('
				SELECT * 
				FROM 
					Tab_Desconto
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Desconto] = $row->Desconto;
            }
        }

        return $array;
    }	

	public function select_modalidade2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Modalidade ORDER BY Abrev2 DESC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Modalidade ORDER BY Abrev2 DESC');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev2] = $row->AVAP;
            }
        }

        return $array;
    }
	
	public function select_avap($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_AVAP ORDER BY idTab_AVAP ASC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_AVAP ORDER BY idTab_AVAP ASC');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev2] = $row->AVAP;
            }
        }

        return $array;
    }	

	public function select_empresa_matriz($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_EmpresaMatriz,
				NomeEmpresa				
            FROM
                Sis_EmpresaMatriz					

			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_EmpresaMatriz,
				NomeEmpresa				
            FROM
                Sis_EmpresaMatriz					

			ORDER BY 
				NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_EmpresaMatriz] = $row->NomeEmpresa;
            }
        }

        return $array;
    }
	
	public function select_empresa($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Empresa,
				idSis_EmpresaMatriz,
				NomeEmpresa				
            FROM
                Sis_Empresa					
            WHERE
				idSis_EmpresaMatriz = ' . $_SESSION['log']['idSis_EmpresaMatriz'] . '
			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Empresa,
				idSis_EmpresaMatriz,
				NomeEmpresa				
            FROM
                Sis_Empresa					
            WHERE
				idSis_EmpresaMatriz = ' . $_SESSION['log']['idSis_EmpresaMatriz'] . '
			ORDER BY 
				NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }

	public function select_empresa1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Empresa,
				CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa				
            FROM
                Sis_Empresa					
			WHERE
				idSis_Empresa != ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idSis_Empresa != "1" AND
				idSis_Empresa != "5"
			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Empresa,
				CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa					
            FROM
                Sis_Empresa					
			WHERE
				idSis_Empresa != ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idSis_Empresa != "1" AND
				idSis_Empresa != "5" 
			ORDER BY 
				NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }
	
	public function select_empresa2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Empresa,
				NomeEmpresa				
            FROM
                Sis_Empresa					
            WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Empresa,
				NomeEmpresa				
            FROM
                Sis_Empresa					
            WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }
			
	public function select_empresa3($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Empresa,
				CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa				
            FROM
                Sis_Empresa					
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Empresa,
				CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa					
            FROM
                Sis_Empresa					
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }

	public function select_empresa31($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Empresa,
				CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa				
            FROM
                Sis_Empresa					
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Empresa,
				CONCAT(NomeEmpresa, " ", "(", " ", idSis_Empresa, " ", ")" ) as NomeEmpresa					
            FROM
                Sis_Empresa					
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }
	
	public function select_empresa4($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Empresa,
				NomeEmpresa				
            FROM
                Sis_Empresa					
            WHERE
				idSis_Empresa != "1" 
			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Empresa,
				NomeEmpresa				
            FROM
                Sis_Empresa					
            WHERE
				idSis_Empresa != "1" 
			ORDER BY 
				NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }

	public function select_empresa5($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Empresa,
				NomeEmpresa				
            FROM
                Sis_Empresa					
            WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Empresa,
				NomeEmpresa				
            FROM
                Sis_Empresa					
            WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Empresa] = $row->NomeEmpresa;
            }
        }

        return $array;
    }
	
	public function select_empresacli($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Empresa,
				NomeEmpresa				
            FROM
                Sis_Empresa					
            WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				NomeEmpresa ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Empresa,
				NomeEmpresa				
            FROM
                Sis_Empresa					
            WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				NomeEmpresa ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Empresa] = $row->NomeEmpresa;
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
	
	public function select_procedimento($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Procedimento,
				Procedimento				
            FROM
                App_Procedimento					

			ORDER BY 
				Procedimento ASC'
    );
					
        } else {
            $query = $this->db->query(
				'SELECT                
				idApp_Procedimento,
				Procedimento				
            FROM
                App_Procedimento					

			ORDER BY 
				Procedimento ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Procedimento] = $row->Procedimento;
            }
        }

        return $array;
    }

	public function select_orcarec() {

        $query = $this->db->query('
            SELECT
				idApp_OrcaTrata,
				idSis_Empresa,
				idTab_TipoRD
			FROM
				App_OrcaTrata
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idTab_TipoRD = "2"
			ORDER BY
				idApp_OrcaTrata
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idApp_OrcaTrata] = $row->idApp_OrcaTrata;
        }

        return $array;
    }	

	public function select_orcades() {

        $query = $this->db->query('
            SELECT
				idApp_OrcaTrata,
				idSis_Empresa,
				idTab_TipoRD
			FROM
				App_OrcaTrata
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idTab_TipoRD = "1"
			ORDER BY
				idApp_OrcaTrata
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idApp_OrcaTrata] = $row->idApp_OrcaTrata;
        }

        return $array;
    }	

	public function select_cor_prod($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('					
            SELECT
				P.idTab_Cor_Prod,
				P.Cor_Prod,
				P.idTab_Produto,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Nome_Cor_Prod
            FROM
                Tab_Cor_Prod AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.Cor_Prod
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . ' 
			ORDER BY 
				P.Nome_Cor_Prod ASC
    ');
					
        } else {
            $query = $this->db->query('
            SELECT
				P.idTab_Cor_Prod,
				P.Cor_Prod,
				P.idTab_Produto,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Nome_Cor_Prod
            FROM
                Tab_Cor_Prod AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.Cor_Prod
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . ' 
			ORDER BY 
				P.Nome_Cor_Prod ASC
    ');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Cor_Prod] = $row->Nome_Cor_Prod;
            }
        }

        return $array;
    }

	public function select_tam_prod($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('					
            SELECT
				P.idTab_Tam_Prod,
				P.Tam_Prod,
				P.idTab_Produto,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Nome_Tam_Prod
            FROM
                Tab_Tam_Prod AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.Tam_Prod
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . ' 
			ORDER BY 
				P.Nome_Tam_Prod ASC
    ');
					
        } else {
            $query = $this->db->query('
            SELECT
				P.idTab_Tam_Prod,
				P.Tam_Prod,
				P.idTab_Produto,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Nome_Tam_Prod
            FROM
                Tab_Tam_Prod AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.Tam_Prod
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . ' 
			ORDER BY 
				P.Nome_Tam_Prod ASC
    ');
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Tam_Prod] = $row->Nome_Tam_Prod;
            }
        }

        return $array;
    }

	public function select_catprom($data = FALSE) {
	
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				TCAT.idTab_Catprom,
				TCAT.TipoCatprom,
                CONCAT(IFNULL(TCAT.Catprod,"")) AS Catprod
            FROM 
                Tab_Catprom AS TCAT
            WHERE
				TCAT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				TCAT.Catprom ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				TCAT.idTab_Catprom,
				TCAT.TipoCatprom,
                CONCAT(IFNULL(TCAT.Catprom,"")) AS Catprom
            FROM 
                Tab_Catprom AS TCAT
            WHERE
				TCAT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				TCAT.Catprom ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Catprom] = $row->Catprom;
            }
        }

        return $array;
    }

	public function select_catprod($data = FALSE) {
	
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				TCAT.idTab_Catprod,
				TCAT.TipoCatprod,
                CONCAT(IFNULL(TPRS.Prod_Serv,""), " - " ,IFNULL(TCAT.Catprod,"")) AS Catprod
            FROM 
                Tab_Catprod AS TCAT
					LEFT JOIN Tab_Prod_Serv AS TPRS ON TPRS.Abrev_Prod_Serv = TCAT.TipoCatprod
            WHERE
                TCAT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TCAT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				TPRS.Prod_Serv ASC,
				TCAT.Catprod ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				TCAT.idTab_Catprod,
				TCAT.TipoCatprod,
                CONCAT(IFNULL(TPRS.Prod_Serv,""), " - " ,IFNULL(TCAT.Catprod,"")) AS Catprod
            FROM 
                Tab_Catprod AS TCAT
					LEFT JOIN Tab_Prod_Serv AS TPRS ON TPRS.Abrev_Prod_Serv = TCAT.TipoCatprod
            WHERE
                TCAT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TCAT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				TPRS.Prod_Serv ASC,
				TCAT.Catprod ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Catprod] = $row->Catprod;
            }
        }

        return $array;
    }

	public function select_catprod1($data = FALSE) {
	
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				idTab_Catprod,
				TipoCatprod,
                CONCAT(IFNULL(Catprod,"")) AS Catprod
            FROM 
                Tab_Catprod 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . 'AND
				TipoCatprod = "' . $data . '" 
			ORDER BY 
				Catprod ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				idTab_Catprod,
				TipoCatprod,
                CONCAT(IFNULL(Catprod,"")) AS Catprod
            FROM 
                Tab_Catprod 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TipoCatprod = "' . $data . '"
			ORDER BY 
				Catprod ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Catprod] = $row->Catprod;
            }
        }

        return $array;
    }
	
	public function select_atributo_cat($data = FALSE) {
	
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				TAS.idTab_Atributo,
				TAS.idTab_Catprod,
				TAS.Atributo,
                CONCAT(IFNULL(TAS.Atributo,"")) AS Atributo
            FROM 
                Tab_Atributo AS TAS
            WHERE
				TAS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				TAS.Atributo ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				TAS.idTab_Atributo,
				TAS.idTab_Catprod,
				TAS.Atributo,
                CONCAT(IFNULL(TAS.Atributo,"")) AS Atributo
            FROM 
                Tab_Atributo AS TAS
            WHERE
				TAS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				TAS.Atributo ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Atributo] = $row->Atributo;
            }
        }

        return $array;
    }	

	public function select_opcao2($data = FALSE) {
	
		$permissao1 = isset($_SESSION['Atributos'][1]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][1] : 'AND idTab_Atributo = "0"';
		
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				' . $permissao1 . '
			ORDER BY 
				Opcao ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				' . $permissao1 . '
			ORDER BY 
				Opcao ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Opcao] = $row->Opcao;
            }
        }

        return $array;
    }
	
	public function select_opcao1($data = FALSE) {
		
		$permissao2 = isset($_SESSION['Atributos'][2]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][2] : 'AND idTab_Atributo = "0"';
		
		
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				' . $permissao2 . '
			ORDER BY 
				Opcao ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
				' . $permissao2 . '
			ORDER BY 
				Opcao ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Opcao] = $row->Opcao;
            }
        }

        return $array;
    }	

	public function select_opcao_3($data = FALSE) {
		
		$permissao1 = isset($_SESSION['Atributos'][1]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][1] : 'AND idTab_Atributo = "0"';
		
		
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				' . $permissao1 . '
			ORDER BY 
				Opcao ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
				' . $permissao1 . '
			ORDER BY 
				Opcao ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Opcao] = $row->Opcao;
            }
        }

        return $array;
    }	
	
	public function select_opcao_2($data = FALSE) {
		
		$permissao2 = isset($_SESSION['Atributos'][2]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][2] : 'AND idTab_Atributo = "0"';
		
		
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				' . $permissao2 . '
			ORDER BY 
				Opcao ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
				' . $permissao2 . '
			ORDER BY 
				Opcao ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Opcao] = $row->Opcao;
            }
        }

        return $array;
    }	

	public function select_opcao_select3($data = FALSE) {
		
		$permissao1 = isset($_SESSION['Atributos'][1]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][1] : 'AND idTab_Atributo = "0"';
		
		
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				P.idTab_Opcao_Select,
				P.idTab_Opcao,
				P.idTab_Produto,
				P.Item_Atributo,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao_Select AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.idTab_Opcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . ' 
				' . $permissao1 . '
			ORDER BY 
				TOP.Opcao ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				P.idTab_Opcao_Select,
				P.idTab_Opcao,
				P.idTab_Produto,
				P.Item_Atributo,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao_Select AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.idTab_Opcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . ' 
				' . $permissao1 . '
			ORDER BY 
				TOP.Opcao ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Opcao] = $row->Opcao;
            }
        }

        return $array;
    }	
	
	public function select_opcao_select2($data = FALSE) {
		
		$permissao2 = isset($_SESSION['Atributos'][2]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][2] : 'AND idTab_Atributo = "0"';
		
		
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				P.idTab_Opcao_Select,
				P.idTab_Opcao,
				P.idTab_Produto,
				P.Item_Atributo,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao_Select AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.idTab_Opcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . ' 
				' . $permissao2 . '
			ORDER BY 
				TOP.Opcao ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				P.idTab_Opcao_Select,
				P.idTab_Opcao,
				P.idTab_Produto,
				P.Item_Atributo,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao_Select AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.idTab_Opcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . ' 
				' . $permissao2 . '
			ORDER BY 
				TOP.Opcao ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Opcao] = $row->Opcao;
            }
        }

        return $array;
    }	

	public function select_opcao_select33($data = FALSE) {
		
		$permissao1 = isset($_SESSION['Atributos'][1]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][1] : 'AND idTab_Atributo = "0"';
		
		
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				P.idTab_Opcao_Select,
				P.idTab_Opcao,
				P.idTab_Produto,
				P.Item_Atributo,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao_Select AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.idTab_Opcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				TOP.Opcao ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				P.idTab_Opcao_Select,
				P.idTab_Opcao,
				P.idTab_Produto,
				P.Item_Atributo,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao_Select AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.idTab_Opcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				TOP.Opcao ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Opcao] = $row->Opcao;
            }
        }

        return $array;
    }	
	
	public function select_opcao_select22($data = FALSE) {
		
		$permissao2 = isset($_SESSION['Atributos'][2]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][2] : 'AND idTab_Atributo = "0"';
		
		
        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				P.idTab_Opcao_Select,
				P.idTab_Opcao,
				P.idTab_Produto,
				P.Item_Atributo,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao_Select AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.idTab_Opcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				TOP.Opcao ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				P.idTab_Opcao_Select,
				P.idTab_Opcao,
				P.idTab_Produto,
				P.Item_Atributo,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao_Select AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.idTab_Opcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				TOP.Opcao ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Opcao] = $row->Opcao;
            }
        }

        return $array;
    }	
	
	public function select_opcao_atributo1($categoria = FALSE, $atributo = FALSE) {
		 
		//$permissao2 = isset($_SESSION['Atributos'][2]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][2] : 'AND idTab_Atributo = "0"';
		$opcao = ($atributo) ? 'AND TOP.idTab_Atributo = ' . $atributo : FALSE;
			/*
			echo $this->db->last_query();
			echo '<br>';
			echo "<pre>";
			print_r($categoria);
			echo '<br>';
			print_r($atributo);
			echo '<br>';
			print_r($opcao);
			echo "</pre>";
			exit();
			*/  
        if ($categoria === TRUE) {
            $array = $this->db->query('
            SELECT
				TOP.*,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao AS TOP
            WHERE
				TOP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TOP.idTab_Catprod = ' . $categoria . '
				' . $opcao . '
			ORDER BY 
				TOP.Opcao ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				TOP.*,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao AS TOP
            WHERE
				TOP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TOP.idTab_Catprod = ' . $categoria . '
				' . $opcao . ' 
			ORDER BY 
				TOP.Opcao ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Opcao] = $row->Opcao;
            }
        }

        return $array;
    }	

	public function select_opcao_atributo2($categoria = FALSE, $atributo = FALSE) {
		
		//$permissao1 = isset($_SESSION['Atributos'][1]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][1] : 'AND idTab_Atributo = "0"';
		$opcao = ($atributo) ? 'AND TOP.idTab_Atributo = ' . $atributo : FALSE;
		
        if ($categoria === TRUE) {
            $array = $this->db->query('
            SELECT
				TOP.*,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao AS TOP
            WHERE
				TOP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TOP.idTab_Catprod = ' . $categoria . '
				' . $opcao . '
			ORDER BY 
				TOP.Opcao ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				TOP.*,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao AS TOP
            WHERE
				TOP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TOP.idTab_Catprod = ' . $categoria . '
				' . $opcao . '
			ORDER BY 
				TOP.Opcao ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Opcao] = $row->Opcao;
            }
        }

        return $array;
    }	
			
	public function select_responsavel($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
					idApp_Cliente,
					CONCAT(IFNULL(NomeCliente,""), " - " ,IFNULL(CelularCliente,"")) AS NomeCliente
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
					CONCAT(IFNULL(NomeCliente,""), " - " ,IFNULL(CelularCliente,"")) AS NomeCliente		
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
	
}
