<br>

<table class="table table-hover">
    <thead>
        <tr>
			<!--<th>idTab_Produto</th>-->		
			<th>Tipo</th>
			<th>Produto</th>
            <th>Unidade</th>
            <th>Valor de Compra</th>
			<th>Cod. do Prod.</th>
			<th>Plano</th>
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
					#echo '<td>' . str_replace('.',',',$row['idTab_Produto']) . '</td>';					
					echo '<td>' . str_replace('.',',',$row['TipoProduto']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['ProdutoBase']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['UnidadeProdutoBase']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['ValorCompraProdutoBase']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['CodProd']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['Convenio']) . '</td>';
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



