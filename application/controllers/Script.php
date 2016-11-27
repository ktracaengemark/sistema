<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Script extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('Script_model');
        $this->load->library('basico');
    }

    public function index() {
        echo 'utilize os métodos';

        echo '<p><a href="' . base_url() . 'script/campos">Gerar Campos da tabela</a></p>';
        echo '<p><a href="' . base_url() . 'script/form_html">Gerar Form da tabela</a></p>';
    }

    public function form_html() {

        echo '<p><a href="../script">Volta</a></p>';

        if (!isset($_POST['table']))
            $_POST['table'] = '';

        echo '<div class="container" id="login">

                <form action="form_html" method="post" accept-charset="iso-8859-1"> 

                    <label class="sr-only">Tabela</label>
                    <input type="text" autofocus name="table" value="' . $_POST['table'] . '">

                    <button class="btn btn-lg btn-primary btn-block" type="submit">OK</button>
                </form>

           </div>';

        if ($_POST['table']) {
            $i = $j = 0;
            echo '
                <\div class="form-group"><br>
                    <\div class="row"><br>         
            ';

            foreach ($this->Script_model->describe_table($_POST['table'])->result() as $row) {

                if ($i > 0) {

                    if ($row->Field == "Nacionalidade") {
                        echo ' 
                        <\div class="col-md-6"><br>   
                        <\label for="' . $row->Field . '">TROCA<\/label><br>
                        <\?php<br>   
                            $select[\'' . $row->Field . '\'] = array(<br>   
                                \'\' => \'-----\',<br>   
                                \'B\' => \'BRASILEIRA\',<br>   
                                \'E\' => \'ESTRANGEIRA\',<br>   
                            );<br>   

                        echo form_dropdown(\'' . $row->Field . '\' , $select[\'' . $row->Field . '\'],<br>'
                        . ' $query[\'' . $row->Field . '\'], \'class = "form-control" id = "Nacionalidade"\');<br>
                        ?\><br>   
                        <\/div><br>
                    ';
                    } elseif (strpos($row->Field, "Uf")) {
                        echo ' 
                        <\div class="col-md-6"><br>   
                        <\label for="' . $row->Field . '">TROCA<\/label><br>
                        <\select data-placeholder="Selecione uma Unidade Federativa..." class="form-control"<br>
                                id="Uf" name="' . $row->Field . '"><br>
                            <\option value=""><\/option><br>
                            <\?php<br>
                            \foreach ($select[\'Uf\'] as $key => $row)<br>
                            {<br>
                                if ($query[\'' . $row->Field . '\'] == $key)<br>
                                {<br>
                                    echo \'<\option value="\' . $key . \'" selected="selected">\' . $row . \'<\/option>\';<br>
                                }<br>
                                else<br>
                                {<br>
                                    echo \'<\option value="\' . $key . \'">\' . $row . \'<\/option>\';<br>
                                }<br>
                            }<br>
                        ?\><br>   
                        <\/div><br>
                    ';
                    } elseif ($i > 0 && substr($row->Field, 0, 2) == "id") {

                        echo ' 
                            <\div class="col-md-6"><br>   
                            <\label for="' . $row->Field . '">TROCA<\/label><\br><br>
                            <\select data-placeholder="Selecione um TROCA..." class="form-control" <br>
                                    id="' . $row->Field . '" name="' . $row->Field . '"><br>
                                <\option value=""><\/option><br>
                            <\?php<br>
                        ';

                        if ($row->Field == "idTabela_Municipio") {

                            echo ' 
                                \foreach ($select[\'' . substr($row->Field, strpos($row->Field, "_") + 1) . '\']->result_array() as $row)<br>
                                {<br>
                                    if ($query[\'' . $row->Field . '\'] == $row[\'' . $row->Field . '\'])<br>
                                    {<br>
                                        echo \'<\option value="\' . $row[\'' . $row->Field . '\'] . \'" selected="selected">\' . $row[\'NomeMunicipio\'] . \' - \' . $row[\'Uf\'] . \'<\/option>\';<br>
                                    }<br>
                                    else<br>
                                    {<br>
                                        echo \'<\option value="\' . $row[\'' . $row->Field . '\'] . \'">\' . $row[\'NomeMunicipio\'] . \' - \' . $row[\'Uf\'] . \'<\/option>\';<br>
                                    }<br>
                                }<br>
                                ';
                        } else {

                            echo ' 
                                foreach ($select[\'' . substr($row->Field, strpos($row->Field, "_") + 1) . '\'] as $key => $row)<br>
                                {<br>
                                    if ($query[\'' . $row->Field . '\'] == $key)<br>
                                    {<br>
                                        echo \'<\option value="\' . $key . \'" selected="selected">\' . $row . \'<\/option>\';<br>
                                    }<br>
                                    else<br>
                                    {<br>
                                        echo \'<\option value="\' . $key . \'">\' . $row . \'<\/option>\';<br>
                                    }<br>
                                }<br>
                                ';
                        }

                        echo ' 
                            ?\><br>
                            <\/select><br>
                            <\/div><br>
                        ';
                    } else {

                        if ($row->Type == "date") {
                            $placeholder = 'placeholder="DD/MM/AAAA"';
                            $maxlength = 10;
                            $id = 'inputDate' . $j;
                            $j++;
                        } else {
                            $placeholder = '';

                            $ini = strpos($row->Type, "(") + 1;
                            $fim = strpos($row->Type, ")") - $ini;

                            $maxlength = substr($row->Type, $ini, $fim);
                            $id = $row->Field;
                        }

                        $autofocus = '';
                        if ($i == 1) {
                            $autofocus = 'autofocus';
                        }

                        echo ' 
                        <\div class="col-md-6"><br>   
                        <\label for="' . $row->Field . '">TROCA<\/label><br>
                        <\input type="text" class="form-control" id="' . $id . '" maxlength="' . $maxlength . '"<br>
                            name="' . $row->Field . '" ' . $placeholder . ' ' . $autofocus . ' value="<\?php echo $query[\'' . $row->Field . '\']; ?>"><br>
                        <\/div><br>
                        ';
                    }

                    if (($i % 2) == 0) {
                        echo ' 
                        
                                <\/div><br>
                            <\/div>
                            <br><br>
                            <\div class="form-group"><br>
                                <\div class="row"><br> 

                        ';
                    }
                }

                $i++;
            }

            echo ' 
                    <\/div><br>
                <\/div><br> 
            ';

            echo '<br><br>';
        }
    }

    public function campos() {

        echo '<p><a href="../script">Volta</a></p>';

        if (!isset($_POST['table']))
            $_POST['table'] = '';

        echo '<div class="container" id="login">

                <form action="Campos" method="post" accept-charset="iso-8859-1"> 

                    <label class="sr-only">Tabela</label>
                    <input type="text" autofocus name="table" value="' . $_POST['table'] . '">

                    <button class="btn btn-lg btn-primary btn-block" type="submit">OK</button>
                </form>

           </div>';

        if ($_POST['table']) {

            foreach ($this->Script_model->describe_table($_POST['table'])->result() as $row) {
#echo '"' . $row['cd_id_paciente'] . '", ';
                echo 'echo \'"\' . $row[\'' . $row->Field . '\'] . \'", \';<br>';
            }

            echo '<br><br>';

            foreach ($this->Script_model->describe_table($_POST['table'])->result() as $row) {
#'Usuario' => $usuario,
                echo '\'' . $row->Field . '\' => $' . $row->Field . ',<br>';
            }

            echo '<br><br>';

            foreach ($this->Script_model->describe_table($_POST['table'])->result() as $row) {
                echo '`' . $row->Field . '`,<br>';
            }

            echo '<br><br>';

            foreach ($this->Script_model->describe_table($_POST['table'])->result() as $row) {
                echo '\'' . $row->Field . '\',<br>';
            }

            echo '<br><br>';

            foreach ($this->Script_model->describe_table($_POST['table'])->result() as $row) {
                echo '. \'' . $row->Field . ', \'<br>';
            }
        }
    }

}
