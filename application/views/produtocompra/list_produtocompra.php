<br>

<table class="table table-hover">
    <thead>
        <tr>
			<th>Tipo</th>
			<th>Produto</th>
            <th>Unidade</th>
			<th>Fornecedor</th>
			<th>Cod. Fornec.</th>
            <th>Valor de Compra</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
        if ($q) {

            foreach ($q as $row)
            {

                $url = base_url() . 'produtocompra/alterar/' . $row['idTab_ProdutoCompra'];
                #$url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';                   
					#echo '<td>' . str_replace('.',',',$row['idTab_ProdutoCompra']) . '</td>';					
					echo '<td>' . str_replace('.',',',$row['TipoProduto']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['ProdutoBase']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['UnidadeProdutoBase']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['NomeEmpresa']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['CodFornec']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['ValorCompraProduto']) . '</td>';
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



