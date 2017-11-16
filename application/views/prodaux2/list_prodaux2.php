<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Aux2</th>
			<th>Abrev2</th>
            
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
        if ($q) {

            foreach ($q as $row)
            {

                $url = base_url() . 'prodaux2/alterar/' . $row['idTab_Prodaux2'];
                #$url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';
                    echo '<td>' . $row['Prodaux2'] . '</td>';
					echo '<td>' . $row['Abrev2'] . '</td>';
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



