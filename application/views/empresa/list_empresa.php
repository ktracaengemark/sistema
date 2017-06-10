<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Fornecedor</th>
            <th>Atividade</th>
			<!--<th>Nascimento</th>-->
            <th>Telefone</th>
        </tr>
    </thead>
    <tbody>
        <?php

        foreach ($query->result_array() as $row) {
            
            if (isset($_SESSION['agenda']))
                $url = base_url() . 'consulta/cadastrar/' . $row['idApp_Empresa'];
            else
                $url = base_url() . 'empresa/prontuario/' . $row['idApp_Empresa'];
                    
            echo '<tr class="clickable-row" data-href="' . $url . '">';
                echo '<td>' . $row['NomeEmpresa'] . '</td>';
				echo '<td>' . $row['Atividade'] . '</td>';
				
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



