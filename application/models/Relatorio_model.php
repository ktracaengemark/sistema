<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }


    public function list_financeiro($data, $completo) {

        if ($data['DataFim']) {
            $consulta1 =
                '(OT.DataEntradaOrca >= "' . $data['DataInicio'] . '" AND OT.DataEntradaOrca <= "' . $data['DataFim'] . '")';

            $consulta2 =
                '(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '" AND PR.DataVencimentoRecebiveis <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta1 =
                '(OT.DataEntradaOrca >= "' . $data['DataInicio'] . '")';

            $consulta2 =
                '(PR.DataVencimentoRecebiveis >= "' . $data['DataInicio'] . '")';
        }

        $query1 = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca

            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT

            WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                (' . $consulta1 . ') AND
                OT.AprovadoOrca = "S" AND
                C.idApp_Cliente = OT.idApp_Cliente

            ORDER BY
                OT.DataOrca ASC,
                C.NomeCliente ASC
        ');

        $query2 = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,

                PR.ParcelaRecebiveis,
                PR.DataVencimentoRecebiveis,
                PR.ValorParcelaRecebiveis,
                PR.DataPagoRecebiveis,
                PR.ValorPagoRecebiveis,
                PR.QuitadoRecebiveis

            FROM
                App_Cliente AS C,
                App_ParcelasRecebiveis AS PR,
                App_OrcaTrata AS OT

            WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                (
                    (' . $consulta2 . ') AND
                    OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
                ) AND
                OT.AprovadoOrca = "S" AND
                C.idApp_Cliente = OT.idApp_Cliente

            ORDER BY
                OT.DataOrca ASC,
                PR.ParcelaRecebiveis ASC,
                C.NomeCliente ASC
        ');

        #$query = array_merge($query1, $query2);

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaentrada=$somareceber=$somapago=$somareal=$balanco=$ant=0;
            #$query = new stdClass();
            #$query->soma = new stdClass();
            $query = array();
            $i=0;

            /*
            foreach ($query1->result() as $row) {
                $query->$i = new stdClass();
                $query['report'][$i]['NomeCliente = $row->NomeCliente;
                $i++;
            }

            foreach ($query2->result() as $row) {
                $query->$i = new stdClass();
                $query['report'][$i]['NomeCliente = $row->NomeCliente;
                $i++;
            }


            echo "<pre>";
            print_r($query);
            echo "</pre>";
            exit();
            */

            #Query1
            foreach ($query1->result() as $row) {
                #$query['report'][$i] = new stdClass();

                $query['report'][$i]['NomeCliente'] = $row->NomeCliente;

                $query['report'][$i]['idApp_OrcaTrata'] = $row->idApp_OrcaTrata;
                $query['report'][$i]['AprovadoOrca'] = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $query['report'][$i]['DataOrca'] = $this->basico->mascara_data($row->DataOrca, 'barras');
                $query['report'][$i]['DataEntradaOrca'] = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');

                $query['report'][$i]['ParcelaRecebiveis'] = FALSE;
                $query['report'][$i]['DataVencimentoRecebiveis'] = FALSE;
                $query['report'][$i]['ValorParcelaRecebiveis'] = FALSE;
                $query['report'][$i]['DataPagoRecebiveis'] = FALSE;
                $query['report'][$i]['ValorPagoRecebiveis'] = FALSE;
                $query['report'][$i]['QuitadoRecebiveis'] = FALSE;

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $query['report'][$i]['ValorEntradaOrca'] = number_format($row->ValorEntradaOrca, 2, ',', '.');

                $i++;
            }
            $somareceber -= $somapago;
            $somareal = $somapago + $somaentrada;
            $balanco = $somapago + $somareceber + $somaentrada;

            /*
            $query['somareceber'] = number_format($somareceber, 2, ',', '.');
            $query['somapago'] = number_format($somapago, 2, ',', '.');
            $query['somareal'] = number_format($somareal, 2, ',', '.');
            $query['somaentrada'] = number_format($somaentrada, 2, ',', '.');
            $query['balanco'] = number_format($balanco, 2, ',', '.');
            */

            #Query2
            foreach ($query2->result() as $row) {
                #$query->$i = new stdClass();

                $query['report'][$i]['NomeCliente'] = $row->NomeCliente;

                $query['report'][$i]['idApp_OrcaTrata'] = $row->idApp_OrcaTrata;
                $query['report'][$i]['AprovadoOrca'] = $row->AprovadoOrca;
                $query['report'][$i]['DataOrca'] = $this->basico->mascara_data($row->DataOrca, 'barras');
                $query['report'][$i]['DataEntradaOrca'] = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');

                $query['report'][$i]['DataVencimentoRecebiveis'] = $this->basico->mascara_data($row->DataVencimentoRecebiveis, 'barras');
                $query['report'][$i]['DataPagoRecebiveis'] = $this->basico->mascara_data($row->DataPagoRecebiveis, 'barras');

                $query['report'][$i]['AprovadoOrca'] = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $query['report'][$i]['QuitadoRecebiveis'] = $this->basico->mascara_palavra_completa($row->QuitadoRecebiveis, 'NS');

                $query['report'][$i]['ParcelaRecebiveis'] = $row->ParcelaRecebiveis;

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somapago += $row->ValorPagoRecebiveis;
                $somareceber += $row->ValorParcelaRecebiveis;

                $query['report'][$i]['ValorEntradaOrca'] = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $query['report'][$i]['ValorParcelaRecebiveis'] = number_format($row->ValorParcelaRecebiveis, 2, ',', '.');
                $query['report'][$i]['ValorPagoRecebiveis'] = number_format($row->ValorPagoRecebiveis, 2, ',', '.');


                $i++;
            }
            $somareceber -= $somapago;
            $somareal = $somapago + $somaentrada;
            $balanco = $somapago + $somareceber + $somaentrada;

            #$query->soma = new stdClass();
            $query['somareceber'] = number_format($somareceber, 2, ',', '.');
            $query['somapago'] = number_format($somapago, 2, ',', '.');
            $query['somareal'] = number_format($somareal, 2, ',', '.');
            $query['somaentrada'] = number_format($somaentrada, 2, ',', '.');
            $query['balanco'] = number_format($balanco, 2, ',', '.');

            /*
            #echo $this->db->last_query();
            echo "<pre>";
            print_r($query);
            echo "</pre>";
            exit();
            */

            return $query;
        }

    }

    public function list_orcamento($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
                OT.ValorOrca,

                OT.ServicoConcluido,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataRetorno

            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT

            WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '
                ' . $filtro2 . '
                C.idApp_Cliente = OT.idApp_Cliente

            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
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

            $somaorcamento=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

                $somaorcamento += $row->ValorOrca;

                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');

            return $query;
        }

    }

	public function list_despesa($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(D.DataDesp >= "' . $data['DataInicio'] . '" AND D.DataDesp <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(D.DataDesp >= "' . $data['DataInicio'] . '")';
        }

        #$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        #$filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                D.Despesa,
                D.idApp_Despesa,
                TD.TipoDespesa,
                D.DataDesp,
                D.ValorTotalDesp,
				FP.FormaPag,
				E.NomeEmpresa AS Empresa

            FROM
                App_Despesa AS D
                    LEFT JOIN Tab_TipoDespesa AS TD ON TD.idTab_TipoDespesa = D.TipoDespesa
                    LEFT JOIN Tab_FormaPag    AS FP ON FP.idTab_FormaPag    = D.FormaPag
                    LEFT JOIN App_Empresa     AS E  ON E.idApp_Empresa      = D.Empresa

            WHERE
                D.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				D.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(' . $consulta . ')

            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
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

            $somadespesa=0;
            foreach ($query->result() as $row) {
				$row->DataDesp = $this->basico->mascara_data($row->DataDesp, 'barras');
                #$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                #$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                #$row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                #$row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
                #$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

                $somadespesa += $row->ValorTotalDesp;

                $row->ValorTotalDesp = number_format($row->ValorTotalDesp, 2, ',', '.');

            }
            $query->soma = new stdClass();
            $query->soma->somadespesa = number_format($somadespesa, 2, ',', '.');

            return $query;
        }

    }

    public function list_clientes($data, $completo) {

        $data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                C.idApp_Cliente,
                C.NomeCliente,

                C.DataNascimento,
                C.Telefone1,
                C.Telefone2,
                C.Telefone3,
                C.Sexo,
                C.Endereco,
                C.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                C.Email

            FROM
                App_Cliente AS C
                    LEFT JOIN Tab_Municipio AS M ON C.Municipio = M.idTab_Municipio

            WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . '


            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
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
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');

                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->Telefone = ($row->Telefone1) ? $row->Telefone1 : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_profissionais($data, $completo) {

        $data['Campo'] = (!$data['Campo']) ? 'P.NomeProfissional' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                P.idApp_Profissional,
                P.NomeProfissional,
				P.Funcao,
                P.DataNascimento,
                P.Telefone1,
                P.Telefone2,
                P.Telefone3,
                P.Sexo,
                P.Endereco,
                P.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                P.Email

            FROM
                App_Profissional AS P
                    LEFT JOIN Tab_Municipio AS M ON P.Municipio = M.idTab_Municipio

            WHERE
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '


            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

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
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');

                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->Telefone = ($row->Telefone1) ? $row->Telefone1 : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_empresas($data, $completo) {

        $data['Campo'] = (!$data['Campo']) ? 'E.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                E.idApp_Empresa,
                E.NomeEmpresa,
				E.Atividade,
                E.DataNascimento,
                E.Telefone1,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.Endereco,
                E.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                E.Email

            FROM
                App_Empresa AS E
                    LEFT JOIN Tab_Municipio AS M ON E.Municipio = M.idTab_Municipio

            WHERE
                E.idSis_Usuario = ' . $_SESSION['log']['id'] . '


            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

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
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');

                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->Telefone = ($row->Telefone1) ? $row->Telefone1 : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_orcamentopc($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ServicoConcluido'] != '#') ? 'OT.ServicoConcluido = "' . $data['ServicoConcluido'] . '" AND ' : FALSE;
		$filtro4 = ($data['ConcluidoProcedimento'] != '#') ? 'PC.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;


        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataPrazo,
                OT.ValorOrca,

                OT.ServicoConcluido,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataRetorno,

				PC.DataProcedimento,
				PR.NomeProfissional,
				PC.Procedimento,
				PC.ConcluidoProcedimento,
				PC.DataProcedimentoLimite

			FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
					LEFT JOIN App_Procedimento AS PC ON OT.idApp_OrcaTrata = PC.idApp_OrcaTrata
					LEFT JOIN App_Profissional AS PR ON PR.idApp_Profissional = PC.Profissional

			WHERE
                C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '
                ' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro4 . '
                C.idApp_Cliente = OT.idApp_Cliente

            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
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

            $somaorcamento=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                $row->DataProcedimentoLimite = $this->basico->mascara_data($row->DataProcedimentoLimite, 'barras');

				$somaorcamento += $row->ValorOrca;

                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');

            return $query;
        }

    }

}
