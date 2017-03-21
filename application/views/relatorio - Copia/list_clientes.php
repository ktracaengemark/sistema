<div class="container-fluid">
    <div class="row">

        <div>

            <table class="table table-bordered table-condensed table-hover">

                <thead>
                    <tr>
                        <th class="active">#</th>
                        <th class="active">Cliente</th>
                        <th class="active">Nascimento</th>
                        <th class="active">Telefone</th>
                        <th class="active">Sexo</th>
                        <th class="active">Endereço</th>
                        <th class="active">Bairro</th>
                        <th class="active">Município</th>
                        <th class="active">E-mail</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'] . '">';
                            echo '<td>' . $row['idApp_Cliente'] . '</td>';

                            echo '<td>' . $row['NomeCliente'] . '</td>';
                            echo '<td>' . $row['DataNascimento'] . '</td>';
                            echo '<td>' . $row['Telefone'] . '</td>';
                            echo '<td>' . $row['Sexo'] . '</td>';
                            echo '<td>' . $row['Endereco'] . '</td>';
                            echo '<td>' . $row['Bairro'] . '</td>';
                            echo '<td>' . $row['Municipio'] . '</td>';
                            echo '<td>' . $row['Email'] . '</td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="9" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
            </table>

        </div>

    </div>

</div>
