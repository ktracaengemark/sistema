<br>

<table class="table table-hover">
    <thead>
        <tr>           
			<th>Nome do Serviço</th>
			<th>Cod. do Serviço</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
        if ($q) {

            foreach ($q as $row)
            {

                $url = base_url() . 'servicobase/alterar/' . $row['idTab_ServicoBase'];				
                #$url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';                   
					echo '<td>' . str_replace('.',',',$row['ServicoBase']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['CodServ']) . '</td>';
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



