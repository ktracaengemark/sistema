<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Paciente</th>
            <th>Funcao</th>
			<!--<th>Nascimento</th>-->
            <th>Telefone</th>
        </tr>
    </thead>
    <tbody>
        <?php

        foreach ($query->result_array() as $row) {
            
            if (isset($_SESSION['agenda']))
                $url = base_url() . 'consulta/cadastrar/' . $row['idApp_Profissional'];
            else
                $url = base_url() . 'profissional/prontuario/' . $row['idApp_Profissional'];
                    
            echo '<tr class="clickable-row" data-href="' . $url . '">';
                echo '<td>' . $row['NomeProfissional'] . '</td>';
				echo '<td>' . $row['Funcao'] . '</td>';
				
                #echo '<td>' . $row['DataNascimento'] . '</td>';
                echo '<td>' . $row['Telefone1'] . '</td>';
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



