<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Despesa</th>
			<th>Tipo Desp.</th>
			<th>Valor das Parc.</th>
			<th>Dt Despesa</th>
			
			<th>Forma Pag.</th>
			
			<th>Dt Venc Desp</th>
			<th>Empresa</th>
            <!--<th>Qtd Parc.</th>
            <th>Unidade de Medida</th>
            <th>Valor Parc.</th>
			<th>Dt Venc.</th>-->
			
            
			
			
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
        if ($q) {

            foreach ($q as $row)
            {

                $url = base_url() . 'despesa/alterar/' . $row['idApp_Despesa'];
                #$url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';
                    echo '<td>' . str_replace('.',',',$row['Despesa']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['TipoDespesa']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['ValorDesp']) . '</td>';
					#echo '<td>' . str_replace('.',',',$row['ValorTotal']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['DataDesp']) . '</td>';
					
					echo '<td>' . str_replace('.',',',$row['FormaPag']) . '</td>';
					
					echo '<td>' . str_replace('.',',',$row['DataVencDesp']) . '</td>';
					echo '<td>' . str_replace('.',',',$row['Empresa']) . '</td>';
					
                   # echo '<td>' . str_replace('.',',',$row['QtdParc']) . '</td>';
                   # echo '<td>' . str_replace('.',',',$row['Unidade']) . '</td>';                    
                   
					#echo '<td>' . str_replace('.',',',$row['DataVenc']) . '</td>';
					                    
				    
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



