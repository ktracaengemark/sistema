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
            #if ($data && preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.]\d\d\d\d$/", $data)) {
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
                if ($data) {
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

    function apenas_numeros($data) {

        return preg_replace("/[^0-9]/", "", $data);
    }

    function limpa_nome_arquivo($data) {
        return preg_replace("/([^\w.]+)|(\.(?=.*\.))/", "_", $data);
    }

    function renomeia_arquivo($data, $path) {

        $data = preg_replace("/\.[a-z]{1,9}/", "-copia$0", $data);

        if (file_exists(APPPATH . 'upload/sisbedam/be/' . $data))
            $data = $this->renomeia_arquivo($data, $path . $data);

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

}
