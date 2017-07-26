<br>

<table class="table table-hover">
    <thead>
        <tr>           			
			<th>Tipo</th>
			<th>Serviço</th>
			<th>Fornecedor</th>
            <th>Valor de Compra</th>
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

                $url = base_url() . 'servico/alterar/' . $row['idTab_Servico'];
                #$url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';					
					echo '<td>' . str_replace('.',',',$row['TipoProduto']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['ServicoBase']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['NomeEmpresa']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['ValorCompraServico']) . '</td>';
                    echo '<td>' . str_replace('.',',',$row['Convenio']) . '</td>';
				    echo '<td>' . str_replace('.',',',$row['ValorVendaServico']) . '</td>';
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



