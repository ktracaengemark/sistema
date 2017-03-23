<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Produto</th>
            <!--<th>Qte Compra</th>-->
            <th>Unidade de Medida</th>
            <th>Valor de Compra</th>
            <th>Valor de Venda</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
        if ($q) {

            foreach ($q as $row)
            {

                $url = base_url() . 'produto/alterar/' . $row['idTab_Produto'];
                #$url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';
                    echo '<td>' . str_replace('.',',',$row['NomeProduto']) . '</td>';
                    #echo '<td>' . str_replace('.',',',$row['Quantidade']) . '</td>';
                    echo '<td>' . str_replace('.',',',$row['UnidadeProduto']) . '</td>';                    
                    echo '<td>' . str_replace('.',',',$row['ValorCompraProduto']) . '</td>';
                    echo '<td>' . str_replace('.',',',$row['ValorVendaProduto']) . '</td>';
                    echo '<td></td>';
                echo '</tr>';            

                $i++;
            }
            
        }
        ?>

    </tbody>
    <tfoot>
        <tr>
            <th colspan="6">Total encontrado: <?php echo $i; ?> resultado(s)</th>
        </tr>
    </tfoot>
</table>



