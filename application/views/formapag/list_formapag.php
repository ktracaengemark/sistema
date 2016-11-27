<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Serviço</th>
            <th>Valor</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
        if ($q) {

            foreach ($q as $row)
            {

                $url = base_url() . 'formapag/alterar/' . $row['idTab_FormaPag'];
                #$url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';
                    echo '<td>' . $row['FormaPag'] . '</td>';
                    #echo '<td>' . str_replace('.',',',$row['ValorVenda']) . '</td>';
                    echo '<td></td>';
                echo '</tr>';            

                $i++;
            }
            
        }
        ?>

    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total encontrado: <?php echo $i; ?> resultado(s)</th>
        </tr>
    </tfoot>
</table>



