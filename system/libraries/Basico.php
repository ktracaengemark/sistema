<?php

#Controller criado para a adição de classes que serã utilizadas pelos vários módulos que irão compor o SISHUAP

defined('BASEPATH') OR exit('No direct script access allowed');

class Basico {

    public function __construct() {
        #error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    }

    #create an alert like form_validator

    public function msg($msg, $tipo, $align = FALSE, $icon = FALSE, $modal = FALSE) {

        if ($tipo == 'erro') {
            $glyphicon = 'remove';
            $alert = 'danger';
        } elseif ($tipo == 'sucesso') {
            $glyphicon = 'ok';
            $alert = 'success';
        } elseif ($tipo == 'alerta') {
            $glyphicon = 'exclamation';
            $alert = 'warning';
        } else {
            $glyphicon = 'info';
            $alert = 'info';
        }

        if ($tipo == 'erro')
            $hide = 'hidediverro';
        else
            $hide = 'hidediv';


        $span = '';
        if ($icon === TRUE)
            $span = '<span class="glyphicon glyphicon-' . $glyphicon . '-sign"></span> ';

        if ($align === TRUE)
            $align = ' text-center';
        else
            $align = '';

        if ($modal === TRUE) {
            $data = '<div class="alert alert-' . $alert . ' hidediv text-center" id="' . $hide . '" role="alert">' . $span . $msg . '</div>';
        } else {
            $data = '
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="alert alert-' . $alert . $align . '" role="alert">' . $span . $msg . '</div>
                    </div>
                    <div class="col-md-2"></div>
                </div>';
        }

        return $data;
    }

    function check_date($data) {
        if ($data) {
            #($data && preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.]\d\d\d\d$/", $data)) 
            if (preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](1[89][0-9][0-9]|2[0189][0-9][0-9])$/", $data) &&
                    checkdate(substr($data, 3, 2), substr($data, 0, 2), substr($data, 6, 4)))
                return TRUE;
            else
                return FALSE;
        } else {
            return FALSE;
        }
    }

    function check_hour($data) {
        if ($data) {
            if (preg_match("/^([01][0-9]|2[0-3])[- \:.]([0-5][0-9])$/", $data))
                return TRUE;
            else
                return FALSE;
        } else {
            return FALSE;
        }
    }
	
    function check_prazo($data) {
        if ($data) {
            if ($data > 5)
                return TRUE;
            else
                return FALSE;
        } else {
            return FALSE;
        }
    }
		
    function check_intervalo($data) {
        if ($data) {
            if ($data > 0)
                return TRUE;
            else
                return FALSE;
        } else {
            return FALSE;
        }
    }
		
    function check_repetir($data) {
        if ($data) {
            if ($data == 'S')
                return TRUE;
            else
                return FALSE;
        } else {
            return FALSE;
        }
    }
	
    function check_periodo($data) {
        if ($data) {
            if ($data > 0)
                return TRUE;
            else
                return FALSE;
        } else {
            return FALSE;
        }
    }

    function check_periodo_hora($horafim, $horainicio) {

        if ($horafim && $horainicio && preg_match("/^([01][0-9]|2[0-3])[- \:.]([0-5][0-9])$/", $horafim) &&
                preg_match("/^([01][0-9]|2[0-3])[- \:.]([0-5][0-9])$/", $horainicio)) {

            $horafim = explode(':', $horafim);
            $horainicio = explode(':', $horainicio);

            if (mktime($horafim[0], $horafim[1]) <= mktime($horainicio[0], $horainicio[1]))
                return FALSE;
            else
                return TRUE;
        } else {
            return FALSE;
        }
    }

    function check_periodo_data($datafim, $dataini) {

		$data1 = DateTime::createFromFormat('d/m/Y', $dataini);
		$data1 = $data1->format('Y-m-d');       
		$data2 = DateTime::createFromFormat('d/m/Y', $datafim);
		$data2 = $data2->format('Y-m-d');		
			/*
			echo '<br>';
			echo "<pre>";
			print_r($data2);
			echo '<br>';
			print_r($data1);
			echo "</pre>";
			exit();
			*/
		if(strtotime($data2) < strtotime($data1)){
			return FALSE;
		}else{
			return TRUE;
		}
    }

    function check_data_termino($datafim, $dataini) {

		$data1 = DateTime::createFromFormat('d/m/Y', $dataini);
		$data1 = $data1->format('Y-m-d');       
		$data2 = DateTime::createFromFormat('d/m/Y', $datafim);
		$data2 = $data2->format('Y-m-d');
		
		if(strtotime($data2) >= strtotime($data1)){
			return TRUE;
		}else{
			return FALSE;
		}
    }

    function check_data_termino2($datafim, $dataini) {

		$data1 = DateTime::createFromFormat('d/m/Y', $dataini);
		$data1 = $data1->format('Y-m-d');       
		$data2 = DateTime::createFromFormat('d/m/Y', $datafim);
		$data2 = $data2->format('Y-m-d');		
		$diferenca = strtotime($data2) - strtotime($data1);
		$dias = floor($diferenca / (60 * 60 * 24));
			/*
			echo '<br>';
			echo "<pre>";
			print_r($data1);
			echo '<br>';
			print_r($data2);
			echo '<br>';
			print_r($dias);
			echo "</pre>";
			exit();
			*/
		if($dias <= 730){
			return TRUE;
		}else{
			return FALSE;
		}
    }

    function check_periodo_intervalo($periodo, $intervalo) {
		if ($periodo>1 && $intervalo>0) {
			if($periodo <= $intervalo){
				return FALSE;
			}else{
				return TRUE;
			}
		} else {
            return FALSE;
        }	
    }
	
    function calcula_idade($data) {

        $from = new DateTime($data);
        $to = new DateTime('today');
        return $from->diff($to)->y;
    }

    function get_sexo($data) {

        if ($data == 'M')
            return 'MASCULINO';
        elseif ($data == 'F')
            return 'FEMININO';
        else
            return NULL;
    }

    function get_nacionalidade($data) {

        if ($data == 'B')
            return 'BRASILEIRA';
        elseif ($data == 'E')
            return 'ESTRANGEIRA';
        else
            return NULL;
    }

    function set_log($anterior = NULL, $atual, $campos, $id, $update = NULL, $delete = NULL) {

        $query['auditoriaitem'] = array();

        $i = 0;
        #compara valores antigos com os novos e vê onde há mudanças
        if ($update === TRUE) {
            foreach ($campos as $novo) {
                if ($atual[$novo] != $anterior[$novo]) {
                    $query['auditoriaitem'][] = array(
                        'Coluna' => $novo,
                        'ValorAnterior' => $anterior[$novo],
                        'ValorAtual' => $atual[$novo],
                        'ChavePrimaria' => $id,
                    );
                }
            }
        }
        #apenas monta o select para inserção de novos dados, sem fazer comparações
        else {
            if ($delete === TRUE) {
                foreach ($campos as $novo) {
                    if ($anterior[$novo]) {
                        $query['auditoriaitem'][] = array(
                            'Coluna' => $novo,
                            'ValorAnterior' => $anterior[$novo],
                            'ChavePrimaria' => $id,
                        );
                    }
                }
            } else {
                foreach ($campos as $novo) {
                    if ($atual[$novo]) {
                        $query['auditoriaitem'][] = array(
                            'Coluna' => $novo,
                            'ValorAtual' => $atual[$novo],
                            'ChavePrimaria' => $id,
                        );
                    }
                }
            }
        }
        /*
          echo "<pre>";
          print_r($query['auditoriaitem']);
          echo "</pre>";
         *
         */
        if ($query['auditoriaitem']) {
            return $query;
        } else {
            return FALSE;
        }
    }

    function mascara_cpf($data, $completo = FALSE) {

        $zeros = 11 - strlen($data);
        for ($i = 0; $i < $zeros; $i++) {
            $data = '0' . $data;
        }

        if ($completo === FALSE) {
            return $data;
        } else {
            return substr($data, 0, 3) . '.' . substr($data, 3, 3) . '.' . substr($data, 6, 3) . '-' . substr($data, 9, 2);
        }
    }

    function mascara_cep($data, $completo = FALSE) {

        $zeros = 8 - strlen($data);
        for ($i = 0; $i < $zeros; $i++) {
            $data = '0' . $data;
        }

        if ($completo === FALSE) {
            return $data;
        } else {
            return substr($data, 0, 5) . '-' . substr($data, 6, 2);
        }
    }

    function mascara_data($data, $opcao) {

        if (preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $data)) {
			
            if ($opcao == 'barras') {
                if ($data && $data != '0000-00-00') {
                    $data = nice_date($data, 'd/m/Y');
                } else {
                    $data = '';
                }
            } elseif ($opcao == 'mysql') {
                if ($data && $data != '0000-00-00') {
                    $data = DateTime::createFromFormat('d/m/Y', $data);
                    $data = $data->format('Y-m-d');
                } else {
                    $data = NULL;
                }
            }
        }
		#exit($data);
        return $data;
    }
	
    function mascara_data2($data, $opcao) {

        if (preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $data)) {
			
            if ($opcao == 'barras') {
                if ($data && $data != '0000-00-00') {
                    $data = nice_date($data, 'd/m/Y');
                } else {
                    $data = '';
                }
            } elseif ($opcao == 'mysql') {
                if ($data) {
                    $data = DateTime::createFromFormat('d/m/Y H:i:s', $data);
                    $data = $data->format('Y-m-d H:i:s');
                } else {
                    $data = NULL;
                }
            }
        }
		#exit($data);
        return $data;
    }
	
    function mascara_data3($data, $opcao) {

        if (preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $data)) {
			
            if ($opcao == 'barras') {
                if ($data && $data != '0000-00-00') {
                    $data = nice_date($data, 'm/d/Y');
                } else {
                    $data = '';
                }
            } elseif ($opcao == 'mysql') {
                if ($data) {
                    $data = DateTime::createFromFormat('d/m/Y H:i:s', $data);
                    $data = $data->format('Y-m-d H:i:s');
                } else {
                    $data = NULL;
                }
            }
        }
		#exit($data);
        return $data;
    }
	
    function mascara_hora($data, $opcao) {

        if (preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $data)) {
			
            if ($opcao == 'barras') {
                if ($data && $data != '0000-00-00') {
                    $data = nice_date($data, 'd/m/Y');
                } else {
                    $data = '';
                }
            } elseif ($opcao == 'mysql') {
                if ($data) {
                    $data = DateTime::createFromFormat('d/m/Y', $data);
                    $data = $data->format('Y-m-d');
                } else {
                    $data = NULL;
                }
            } elseif ($opcao == 'hora') {
                if ($data) {
					$dataini = explode(' ', $data);
					$data = substr($dataini[1], 0, 5);
                } else {
                    $data = NULL;
                }
            }
        }
		#exit($data);
        return $data;
    }

    function apenas_numeros($data) {

        return preg_replace("/[^0-9]/", "", $data);
    }

    function limpa_nome_arquivo($data) {
        return preg_replace("/([^\w.]+)|(\.(?=.*\.))/", "_", $data);
    }
	
    function limpa_nome_arquivo2($data) {
        return preg_replace("/([^\w.]+)|(\.(?=.*\.))/", "", $data);
    }

	function url_amigavel_BKP($string) {
		$palavra = strtr($string, "ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
		$palavranova = str_replace("_", " ", $palavra);
		$pattern = '|[^a-zA-Z0-9\-]|';    
		$palavranova = preg_replace($pattern, ' ', $palavranova);
		$string = str_replace(' ', '', $palavranova);
		$string = str_replace('---', '', $string);
		$string = str_replace('--', '', $string);
		return strtolower($string);
	}
	
	function url_amigavel($string) {

		$palavra = strtr($string, "ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
		$palavranova = str_replace("_", " ", $palavra);
		$pattern = '|[^a-zA-Z0-9\-]|';    
		$palavranova = preg_replace($pattern, ' ', $palavranova);
		$string = str_replace(' ', '', $palavranova);
		$string = str_replace('---', '', $string);
		$string = str_replace('--', '', $string);
		$string = preg_replace("/([^\w.]+)|(\.(?=.*\.))/", "", $string);		
		return strtolower($string);
	}	

    function nomeiaarquivos($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = 'arquivos' . '_' . $_SESSION['log']['idSis_Empresa'] . '_' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . '_' . rand() . $extensao;
		return $data;
    }

    function renomeiaarquivos($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = 'arquivos' . '_' . $_SESSION['Empresa']['idSis_Empresa'] . '_' . $_SESSION['Arquivos']['idApp_OrcaTrata'] . '_' . rand() . $extensao;
		return $data;
    }

    function renomeiacatprod($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'catprod' . '_' . $_SESSION['Catprod']['idTab_Catprod'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }	

    function renomeiaprodutos($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
        //$data = 'produto' . '_' . $_SESSION['Produtos']['idTab_Produto'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		$data = rand() . '_' . 'produto' . '_' . $_SESSION['Produtos']['idTab_Produto'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }	

    function renomeiaderivado($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
        //$data = 'produto' . '_' . $_SESSION['Produtos']['idTab_Produto'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		$data = rand() . '_derivado_' . $_SESSION['Derivados']['idTab_Produtos'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }
	
    function renomeiaprodaux2($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
        //$data = 'produto' . '_' . $_SESSION['Produtos']['idTab_Prodaux2'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		$data = rand() . '_' . 'prodaux2' . '_' . $_SESSION['Produtos']['idTab_Prodaux2'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }	
	
    function renomeiapromocao($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
        //$data = 'promocao' . '_' . $_SESSION['Promocao']['idTab_Promocao'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		$data = rand() . '_' . 'promocao' . '_' . $_SESSION['Promocao']['idTab_Promocao'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }	

    function renomeiadepoimento($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'depoimento' . '_' . $_SESSION['Depoimento']['idApp_Depoimento'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }

    function renomeiaatuacao($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'atuacao' . '_' . $_SESSION['Atuacao']['idApp_Atuacao'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }

    function renomeiacolaborador($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'colaborador' . '_' . $_SESSION['Colaborador']['idApp_Colaborador'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }

    function renomeiaslides($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'slides' . '_' . $_SESSION['Slides']['idApp_Slides'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }

    function nomeia_depoimento($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'depoimento' . '_' . $_SESSION['log']['idSis_Empresa'] . $extensao;
		return $data;
    }

    function nomeia_atuacao($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'atuacao' . '_' . $_SESSION['log']['idSis_Empresa'] . $extensao;
		return $data;
    }

    function nomeia_colaborador($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'colaborador' . '_' . $_SESSION['log']['idSis_Empresa'] . $extensao;
		return $data;
    }

    function nomeia_slides($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'slides' . '_' . $_SESSION['log']['idSis_Empresa'] . $extensao;
		return $data;
    }
	
    function renomeia_logo_nav($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'logo_nav' . '_' . $_SESSION['Documentos']['idApp_Documentos'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }
	
    function renomeia_icone($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'icone' . '_' . $_SESSION['Documentos']['idApp_Documentos'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }	
	
    function renomeiaempresa($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;		
        //$data = 'Logo_empresa' . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		$data = rand() . '_' . 'Logo_empresa' . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }
	
    function renomeiaassociado($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
        //$data = 'usuario' . '_' . $_SESSION['Usuario']['idSis_Usuario'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		$data = rand() . '_' . 'associado' . '_' . $_SESSION['Usuario']['idSis_Associado'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }
	
    function renomeiausuario($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
        //$data = 'usuario' . '_' . $_SESSION['Usuario']['idSis_Usuario'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		$data = rand() . '_' . 'usuario' . '_' . $_SESSION['Usuario']['idSis_Usuario'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }
	
    function renomeiacliente($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
        //$data = 'cliente' . '_' . $_SESSION['Cliente']['idApp_Cliente'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		$data = 'cliente' . '_' . $_SESSION['Cliente']['idApp_Cliente'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . '_' . rand() . $extensao;
		return $data;
    }	
	
    function renomeiaclientepet($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
        //$data = 'cliente' . '_' . $_SESSION['Cliente']['idApp_Cliente'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		$data = 'clientepet' . '_' . $_SESSION['ClientePet']['idApp_ClientePet'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . '_' . rand() . $extensao;
		return $data;
    }
	
    function renomeiaclientedep($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
        //$data = 'cliente' . '_' . $_SESSION['Cliente']['idApp_Cliente'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		$data = 'clientedep' . '_' . $_SESSION['ClienteDep']['idApp_ClienteDep'] . '_' . $_SESSION['Empresa']['idSis_Empresa'] . '_' . rand() . $extensao;
		return $data;
    }
	
    function renomeiaempresa1($data, $path) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'empresa' . '_' . $_SESSION['Usuario']['idSis_Empresa'] . $extensao;
        #$data = 'Logo_empresa' . '_' . $_SESSION['Usuario']['idSis_Empresa'] . $extensao;
		return $data;
    }	
	
    function renomeia_logo($data, $path) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		
		$tiposPermitidos	= ['png','gif'];
		
        if (in_array($extensao, $tiposPermitidos)) {
			$extensao	= '.' . $extensao;
			$data = 'Logo_empresa' . '_' . $_SESSION['Usuario']['idSis_Empresa'] . $extensao;
			return $data;
			
		}else {
            return FALSE;
        }		
		
    }
	
    function valid_extensao($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_extensao', '<b>%s</b>');
		$tiposPermitidos	= ['png','gif'];
		$tamanho			= $arquivo['size'];
		
		$extensao			= explode('.', $data);
		$extensao			= end($extensao);
		
        if (in_array($extensao, $tiposPermitidos)) {
            return FALSE;
        }
        else {
            return TRUE;
        }

    }	

    function renomeia_slide_1($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'Slide_1_empresa' . '_' . $_SESSION['Usuario']['idSis_Empresa'] . $extensao;
        //$data = 'Slide_1_empresa' . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }	

    function renomeia_slide_2($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'Slide_2_empresa' . '_' . $_SESSION['Usuario']['idSis_Empresa'] . $extensao;
        //$data = 'Slide_2_empresa' . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }
	
    function renomeia_imagem_1($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'Imagem_1_empresa' . '_' . $_SESSION['Usuario']['idSis_Empresa'] . $extensao;
        //$data = 'Imagem_1_empresa' . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }	

    function renomeia_imagem_2($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'Imagem_2_empresa' . '_' . $_SESSION['Usuario']['idSis_Empresa'] . $extensao;
        //$data = 'Imagem_2_empresa' . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }	

    function renomeia_imagem_3($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'Imagem_3_empresa' . '_' . $_SESSION['Usuario']['idSis_Empresa'] . $extensao;
        //$data = 'Imagem_3_empresa' . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }	

    function renomeia_imagem_4($data) {
		$extensao	= explode('.', $data);
		$extensao	= end($extensao);
		$extensao	= '.' . $extensao;
		$data = rand() . '_' . 'Imagem_4_empresa' . '_' . $_SESSION['Usuario']['idSis_Empresa'] . $extensao;
        //$data = 'Imagem_4_empresa' . '_' . $_SESSION['Empresa']['idSis_Empresa'] . $extensao;
		return $data;
    }
	
    function renomeia_arquivo1($data, $path) {

        $data = preg_replace("/\.[a-z]{1,9}/", "-copia$0", $data);

        if (file_exists(APPPATH . '../'.$_SESSION['log']['Site'].'/' . $data))
            $data = $this->renomeia_arquivo($data, $path . $data);

        return $data;
    }

    function renomeia_arquivo($data, $path) {
        #$data = preg_replace("/\.[a-z]{1,9}/", "-copia$0", $data);
        #$data = "img01_2a_.pdf";
        #echo '<br>=> ' . $data;

        $pos2 = strrpos($data, "_.");
        $subs = substr($data, 0, $pos2);
        $pos1 = strrpos($subs, "_");
        $i = substr($subs, $pos1 + 1);

        #echo '<br>0 - ' . $data;
        #echo '<br>path - ' . $path . ' ' . $data;

        if (is_numeric($i))
            $data = substr($data, 0, $pos1) . '_' . ($i + 1) . substr($data, $pos2);
        else
            $data = preg_replace("/\.[a-z]{1,9}$/", "_1_$0", $data);

        #echo '<br>1 - ' . $data;
        #echo '<br>path - ' . $path . ' ' . $data;

        if (file_exists($path . $data)) {
            #echo '<br>oi - ' . $data;
            $data = $this->renomeia_arquivo($data, $path);
        }

        #echo '<br>2 - ' . $data;
        #echo '<br>path - ' . $path . ' ' . $data;
        #exit();

        return $data;

    }

    function tipo_status_cor($data) {

        if ($data == 1)
            return 'warning';
        elseif ($data == 2)
            return 'success';
        elseif ($data == 3)
            return 'primary';
        else
            return 'danger';

    }

    function radio_checked($data, $campo, $tipo = NULL) {

        if ($data) {


            $tipo = str_split($tipo);
            $i = count($tipo);

            for ($j = 0; $j < $i; $j++) {

                if ($data == $tipo[$j]) {

                    for ($k = 0; $k < $i; $k++)
                        ($k == $j) ? $radio[$k] = 'checked' : $radio[$k] = '';
                }
            }

            return $radio;
        }
        else {
            return FALSE;
        }

    }

    function mascara_palavra_completa($data, $opcao) {

        if ($opcao == 'NS') {

            if ($data == 'S')
                return 'Sim';
            else
                return 'Não';

        }
    }
	
    function mascara_palavra_completa2($data, $opcao) {

        if ($opcao == 'NS') {

            if ($data == 'S')
                return 'Sim';
            else if ($data == 'N')
                return 'Não';

        }
    }

    function prioridade($data, $opcao) {

        if ($opcao == '123') {

            if ($data == '1')
                return 'Alta';
            else if ($data == '2')
                return 'Media';
			else if ($data == '3')
                return 'Baixa';

        }
    }

    function statustrf($data, $opcao) {

        if ($opcao == '123') {

            if ($data == '1')
                return 'A Fazer';
            else if ($data == '2')
                return 'Fazendo';
			else if ($data == '3')
                return 'Feito';

        }
    }	

    function tratamento_array_multidimensional($data, $anterior, $campo) {

        $max = count($data);
        $maxanterior = count($anterior);

        $array['inserir'] = array();
        $array['alterar'] = array();
        $array['excluir'] = array();

        for($i=0;$i<$max;$i++) {

            //identifica os itens adicionados
            if (!$data[$i][$campo]) {
                $array['inserir'][] = $data[$i];
            }
            //identifica os itens alterados
            else {

                for($j=0;$j<$maxanterior;$j++) {
                    if ($data[$i][$campo] == $anterior[$j][$campo])
                        $array['alterar'][] = $data[$i];
                }

            }

        }

        //identifica os itens excluídos
        for($i=0;$i<$maxanterior;$i++)
            $array['excluir'][] = $anterior[$i][$campo];

        $maxinserir = count($array['alterar']);
        $excluir = array();
        for($i=0;$i<$maxanterior;$i++) {

            for($j=0;$j<$maxinserir;$j++) {
                if ($array['excluir'][$i] == $array['alterar'][$j][$campo]) {
                    unset($array['excluir'][$i]);
                    break;
                }
            }

        }
        $array['excluir'] = array_values($array['excluir']);

        /*
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        echo '<br>';
        echo "<pre>";
        print_r($anterior);
        echo "</pre>";

        echo '<br>';
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        exit ();
        */

        return $array;

    }
	
    function tratamento_array_multidimensional2($data, $anterior, $campo) {

        $max = count($data);
        $maxanterior = count($anterior);

        $array['inserir'] = array();
        $array['alterar'] = array();
        $array['excluir'] = array();

        for($i=0;$i<$max;$i++) {

            //identifica os itens adicionados
            if (!$data[$i][$campo]) {
                $array['inserir'][] = $data[$i];
            }
            //identifica os itens alterados
            else {

                for($j=0;$j<$maxanterior;$j++) {
                    if ($data[$i][$campo] == $anterior[$j][$campo])
                        $array['alterar'][] = $data[$i];
                }

            }

        }

        //identifica os itens excluídos
        for($i=0;$i<$maxanterior;$i++)
            $array['excluir'][] = $anterior[$i][$campo];

        $maxinserir = count($array['alterar']);
        $excluir = array();
        for($i=0;$i<$maxanterior;$i++) {

            for($j=0;$j<$maxinserir;$j++) {
                if ($array['excluir'][$i] == $array['alterar'][$j][$campo]) {
                    unset($array['excluir'][$i]);
                    break;
                }
            }

        }
        $array['excluir'] = array_values($array['excluir']);

        /*
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        echo '<br>';
        echo "<pre>";
        print_r($anterior);
        echo "</pre>";

        echo '<br>';
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        exit ();
        */

        return $array;

    }	
		
}
