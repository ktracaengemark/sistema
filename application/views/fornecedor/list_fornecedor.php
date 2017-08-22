<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Fornecedor</th>
            <th>Serv./Prod.</th>
			<th>P/Venda</th>
			<th>Atividade</th>			
            <th>Telefone</th>
        </tr>
    </thead>
    <tbody>
        <?php

        foreach ($query->result_array() as $row) {
            
            if (isset($_SESSION['agenda']))
                $url = base_url() . 'consulta/cadastrar/' . $row['idApp_Fornecedor'];
            else
                $url = base_url() . 'fornecedor/prontuario/' . $row['idApp_Fornecedor'];
                    
            echo '<tr class="clickable-row" data-href="' . $url . '">';
                echo '<td>' . $row['NomeFornecedor'] . '</td>';
				echo '<td>' . $row['TipoFornec'] . '</td>';
				echo '<td>' . $row['StatusSN'] . '</td>';
				echo '<td>' . $row['Atividade'] . '</td>';				               
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



