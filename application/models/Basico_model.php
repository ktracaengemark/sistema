<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Basico_model extends CI_Model {

    public function __construct() {
        #parent::__construct();
        $this->load->database();
        $this->load->library(array('basico', 'user_agent'));
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

    function set_auditoria($auditoriaitem, $tabela, $operacao, $data, $id = NULL) {

        if ($id == NULL)
            $id = $_SESSION['log']['id'];

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
	
	public function select_profissional($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional				
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
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
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY F.Abrev ASC, P.NomeProfissional ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Profissional] = $row->NomeProfissional;
            }
        }

        return $array;
    }

	public function select_produto1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				P.idTab_Produto,				
				CONCAT(CO.Abrev, " --- ", PB.ProdutoBase, " --- ", PB.UnidadeProdutoBase, " --- ", EM.NomeEmpresa, " ---R$", P.ValorVendaProduto) AS ProdutoBase				
            FROM
                Tab_Produto AS P
				LEFT JOIN Tab_ProdutoBase AS PB ON PB.idTab_ProdutoBase = P.ProdutoBase    
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = P.Convenio
				LEFT JOIN App_Empresa AS EM ON EM.idApp_Empresa = P.Empresa
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY CO.Convenio DESC, PB.ProdutoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				P.idTab_Produto,				
				CONCAT(CO.Abrev, " --- ", PB.ProdutoBase, " --- ", PB.UnidadeProdutoBase, " --- ", EM.NomeEmpresa, " ---R$", P.ValorVendaProduto) AS ProdutoBase				
            FROM
                Tab_Produto AS P
				LEFT JOIN Tab_ProdutoBase AS PB ON PB.idTab_ProdutoBase = P.ProdutoBase    
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = P.Convenio
				LEFT JOIN App_Empresa AS EM ON EM.idApp_Empresa = P.Empresa
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY CO.Convenio DESC, PB.ProdutoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->ProdutoBase;
            }
        }

        return $array;
    }
	
	public function select_produto($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT
                TPV.idTab_Produto,
				CONCAT(TCO.Abrev, " --- ", TEM.NomeEmpresa, " --- ", TPB.ProdutoBase, " --- ", TPB.UnidadeProdutoBase, " --- R$ ", TPV.ValorVendaProduto) AS ProdutoBase,
				TPV.ValorVendaProduto
            FROM
                Tab_Produto AS TPV				
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TPV.Convenio				
				LEFT JOIN Tab_ProdutoCompra AS TPC ON TPC.idTab_ProdutoCompra = TPV.ProdutoBase				
				LEFT JOIN App_Empresa AS TEM ON TEM.idApp_Empresa = TPC.Empresa				
				LEFT JOIN Tab_ProdutoBase AS TPB ON TPB.idTab_ProdutoBase = TPC.ProdutoBase								
            WHERE
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TPV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TCO.Convenio DESC,
				TEM.NomeEmpresa,
				TPB.ProdutoBase ASC 
    ');
        } else {
            $query = $this->db->query(
                'SELECT
                TPV.idTab_Produto,
				CONCAT(TCO.Abrev, " --- ", TEM.NomeEmpresa, " --- ", TPB.ProdutoBase, " --- ", TPB.UnidadeProdutoBase, " --- R$ ", TPV.ValorVendaProduto) AS ProdutoBase,
				TPV.ValorVendaProduto
            FROM
                Tab_Produto AS TPV				
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TPV.Convenio				
				LEFT JOIN Tab_ProdutoCompra AS TPC ON TPC.idTab_ProdutoCompra = TPV.ProdutoBase				
				LEFT JOIN App_Empresa AS TEM ON TEM.idApp_Empresa = TPC.Empresa				
				LEFT JOIN Tab_ProdutoBase AS TPB ON TPB.idTab_ProdutoBase = TPC.ProdutoBase								
            WHERE
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TPV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TCO.Convenio DESC,
				TEM.NomeEmpresa,
				TPB.ProdutoBase ASC 
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->ProdutoBase;
            }
        }

        return $array;
    }
	
	public function select_servico($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                TSV.idTab_Servico,
                CONCAT(TCO.Abrev, " --- ", TEM.NomeEmpresa, " --- ", TSB.ServicoBase, " --- R$ ", TSV.ValorVendaServico) AS ServicoBase,
                TSV.ValorVendaServico
            FROM
                Tab_Servico AS TSV
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TSV.Convenio				
				LEFT JOIN Tab_ServicoCompra AS TSC ON TSC.idTab_ServicoCompra = TSV.ServicoBase												
				LEFT JOIN App_Empresa AS TEM ON TEM.idApp_Empresa = TSC.Empresa				
				LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSC.ServicoBase								
            WHERE
                TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TCO.Convenio DESC, 
				TEM.NomeEmpresa,
				TSB.ServicoBase ASC				
    ');
        } else {
            $query = $this->db->query('
            SELECT
                TSV.idTab_Servico,
                CONCAT(TCO.Abrev, " --- ", TEM.NomeEmpresa, " --- ", TSB.ServicoBase, " --- R$ ", TSV.ValorVendaServico) AS ServicoBase,
                TSV.ValorVendaServico
            FROM
                Tab_Servico AS TSV
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TSV.Convenio				
				LEFT JOIN Tab_ServicoCompra AS TSC ON TSC.idTab_ServicoCompra = TSV.ServicoBase												
				LEFT JOIN App_Empresa AS TEM ON TEM.idApp_Empresa = TSC.Empresa				
				LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSC.ServicoBase								
            WHERE
                TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TCO.Convenio DESC, 
				TEM.NomeEmpresa ASC,
				TSB.ServicoBase ASC				
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->ServicoBase;
            }
        }

        return $array;
    }
	
	public function select_servico1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				S.idTab_Servico,
				CONCAT(CO.Abrev, " --- ", SB.ServicoBase, " --- ", EM.NomeEmpresa, " --- R$ ", S.ValorVendaServico) AS ServicoBase				
            FROM
                Tab_Servico AS S
                LEFT JOIN Tab_ServicoBase AS SB ON SB.idTab_ServicoBase = S.ServicoBase    
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = S.Convenio
				LEFT JOIN App_Empresa AS EM ON EM.idApp_Empresa = S.Empresa
            WHERE
                S.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                S.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY CO.Convenio DESC, SB.ServicoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				S.idTab_Servico,
				CONCAT(CO.Abrev, " --- ", SB.ServicoBase, " --- ", EM.NomeEmpresa, " --- R$ ", S.ValorVendaServico) AS ServicoBase				
            FROM
                Tab_Servico AS S
                LEFT JOIN Tab_ServicoBase AS SB ON SB.idTab_ServicoBase = S.ServicoBase    
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = S.Convenio
				LEFT JOIN App_Empresa AS EM ON EM.idApp_Empresa = S.Empresa
            WHERE
                S.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                S.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY CO.Convenio DESC, SB.ServicoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->ServicoBase;
            }
        }

        return $array;
    }

	public function select_servico2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Servico, '
                    . 'NomeServico, '
                    . 'ValorVendaServico, '
					. 'ValorCompraServico '
                    . 'FROM '
                    . 'Tab_Servico '
                    . 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] );
        } else {
            $query = $this->db->query('SELECT idTab_Servico, NomeServico, ValorVendaServico, ValorCompraServico  FROM Tab_Servico WHERE idSis_Usuario = ' . $_SESSION['log']['id']);

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->NomeServico;
            }
        }

        return $array;
    }

	public function select_status_sn($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->StatusSN;
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

}
