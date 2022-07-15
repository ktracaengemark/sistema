<div class="container-fluid">
    <div class="row">

        <div style="overflow: auto; height: 220px;">
		
            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>
						<th class="active text-center"></th>
                        <th class="active text-center">JAN</th>
                        <th class="active text-center">FEV</th>
                        <th class="active text-center">MAR</th>
                        <th class="active text-center">ABR</th>
                        <th class="active text-center">MAI</th>
                        <th class="active text-center">JUN</th>
                        <th class="active text-center">JUL</th>
                        <th class="active text-center">AGO</th>
                        <th class="active text-center">SET</th>
                        <th class="active text-center">OUT</th>
                        <th class="active text-center">NOV</th>
                        <th class="active text-center">DEZ</th>
                        <th class="active text-center">TOTAL</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <?php
                        echo '<td><b>' . $report['Receitas'][0]->Balanco . '</b></td>';
                        for($i=1;$i<=12;$i++) {
                            echo '<td class="text-right">' . $report['Receitas'][0]->{'M'.$i} . '</td>';
                        }
                        echo '<td class="text-right">' . $report['TotalGeral']->Receitas . '</td>';
                        ?>
                    </tr>
					
					<tr>
                        <?php
                        echo '<td><b>' . $report['Devolucoes'][0]->Balanco . '</b></td>';
                        for($i=1;$i<=12;$i++) {
                            echo '<td class="text-right">' . $report['Devolucoes'][0]->{'M'.$i} . '</td>';
                        }
                        echo '<td class="text-right">' . $report['TotalGeral']->Devolucoes . '</td>';
                        ?>
                    </tr>

                    <tr>
                        <?php
                        echo '<td><b>' . $report['Despesas'][0]->Balanco . '</b></td>';
                        for($i=1;$i<=12;$i++) {
							echo '<td class="text-right">' . $report['Despesas'][0]->{'M'.$i} . '</td>';
                        }
                        echo '<td class="text-right">' . $report['TotalGeral']->Despesas . '</td>';
                        ?>
                    </tr>

                    <tr>
                        <?php
                        echo '<td><b>' . $report['Total']->Balanco . '</b></td>';
                        for($i=1;$i<=12;$i++) {
                            $bgcolor = ($report['Total']->{'M'.$i} < 0) ? 'bg-danger' : 'bg-success';
                            echo '<td class="text-right ' . $bgcolor . '">' . $report['Total']->{'M'.$i} . '</td>';
                        }
                        $bgcolor = ($report['TotalGeral']->BalancoGeral < 0) ? 'bg-danger' : 'bg-success';
                        echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeral']->BalancoGeral . '</td>';
                        ?>
                    </tr>


                </tbody>

            </table>

        </div>

    </div>

</div>
