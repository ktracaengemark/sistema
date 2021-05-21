<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Cont.</th>
            <th>Motivo</th>
			<th>Descrição</th>
            
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
		$b = $i + 1;
        if ($q) {

            foreach ($q as $row)
            {

                $url = base_url() . 'motivo/alterar/' . $row['idTab_Motivo'];
                #$url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';
                    echo '<td>' . $b . '</td>';
                    echo '<td>' . $row['Motivo'] . '</td>';
					echo '<td>' . $row['Desc_Motivo'] . '</td>';
                    echo '<td></td>';
                echo '</tr>';
				$b++;
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



