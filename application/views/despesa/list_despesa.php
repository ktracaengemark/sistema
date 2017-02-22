<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Despesa</th>
			<th>Tipo Desp.</th>
			<th>Valor Total Desp.</th>
			<!--<th>ValorTotalDesp</th>-->
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

            foreach ($q->result_array() as $row) {

                $url = base_url() . 'despesa/alterar/' . $row['idApp_Despesa'];
                #$url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';
                    echo '<td>' . $row['Despesa'] . '</td>';
					echo '<td>' . $row['TipoDespesa'] . '</td>';
					echo '<td class="text-right">R$ ' . $row['ValorTotalDesp'] . '</td>';
					#echo '<td>' . $row['ValorTotalDesp'] . '</td>';
					echo '<td>' . $row['DataDesp'] . '</td>';

					echo '<td>' . $row['FormaPag'] . '</td>';

					echo '<td>' . $row['DataVencDesp'] . '</td>';
					echo '<td>' . $row['Empresa'] . '</td>';

                   # echo '<td>' . $row['QtdParc'] . '</td>';
                   # echo '<td>' . $row['Unidade'] . '</td>';

					#echo '<td>' . $row['DataVenc'] . '</td>';


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
