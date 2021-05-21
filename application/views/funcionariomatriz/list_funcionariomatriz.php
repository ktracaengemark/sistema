<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Funcionário</th>
            <th>Nascimento</th>
            <th>Telefone</th>
        </tr>
    </thead>
    <tbody>
        <?php

        foreach ($list->result_array() as $row) {
/*
            if (isset($_SESSION['agenda']))
                $url = base_url() . 'consulta/cadastrar/' . $row['idSis_UsuarioMatriz'];
            else
                $url = base_url() . 'funcionariomatriz/prontuario/' . $row['idSis_UsuarioMatriz'];
*/
            echo '<tr class="clickable-row" data-href="' . $url . '">';
                echo '<td>' . $row['Nome'] . '</td>';
                echo '<td>' . $row['DataNascimento'] . '</td>';
                echo '<td>' . $row['Celular'] . '</td>';
            echo '</tr>';
        }
        ?>

    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total encontrado: <?php echo $query->num_rows(); ?> resultado(s)</th>
        </tr>
    </tfoot>
</table>
