<br>

<table class="table table-hover">
    <thead>
        <tr>           
			<th>Tipo de Serviço</th>
			<th>Nome do Serviço</th>
            <!--<th>Valor de Compra</th>-->
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
					echo '<td>' . str_replace('.',',',$row['TipoProduto']) . '</td>';
					echo '<td>' . $row['ServicoBase'] . '</td>';
					#echo '<td>' . str_replace('.',',',$row['ValorCompraServicoBase']) . '</td>';
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



