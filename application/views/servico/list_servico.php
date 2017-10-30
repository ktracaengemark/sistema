<br>

<table class="table table-hover">
    <thead>
        <tr>           			
			<th>id_Serviço</th>
			<th>Nome da Empresa</th>
			<th>Cod. Serv.</th>			
			<th>Serviço</th>
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
					echo '<td>' . str_replace('.',',',$row['idTab_Servico']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['NomeEmpresa']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['CodServ']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['NomeServico']) . '</td>';
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



