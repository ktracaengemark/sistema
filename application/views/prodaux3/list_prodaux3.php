<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Categoria</th>
			<th>Abrev</th>
            
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
        if ($q) {

            foreach ($q as $row)
            {

                $url = base_url() . 'prodaux3/alterar/' . $row['idTab_Prodaux3'];
                #$url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';
                    echo '<td>' . $row['Prodaux3'] . '</td>';
					echo '<td>' . $row['Abrev3'] . '</td>';
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



