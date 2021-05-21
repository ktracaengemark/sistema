<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Cont.</th>
            <th>Categoria</th>
			<!--<th>Abrev</th>-->
            
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
		$b = $i + 1;
        if ($q) {

            foreach ($q as $row){

                $url = base_url() . 'categoria/alterar/' . $row['idTab_Categoria'];
                #$url = '';
				
                echo '<tr class="clickable-row" data-href="' . $url . '">';
                    echo '<td>' . $b . '</td>';
                    echo '<td>' . $row['Categoria'] . '</td>';
					#echo '<td>' . $row['Abrev'] . '</td>';
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



