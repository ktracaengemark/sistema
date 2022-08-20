<div style="overflow: auto; height: auto;">
	<div class="container-fluid">
		<div class="row">
			
				<table class="table table-bordered table-condensed table-striped">

					<thead>
						<tr>
							<th class="active text-center"><?php echo '<small>' . $_SESSION['FiltroBalanco']['Ano'] . '</small>' ?></th>
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
						
							<?php
							$mes[1] = "Jan";
							$mes[2] = "Fev";
							$mes[3] = "Mar";
							$mes[4] = "Abr";
							$mes[5] = "Mai";
							$mes[6] = "Jun";
							$mes[7] = "Jul";
							$mes[8] = "Ago";
							$mes[9] = "Set";
							$mes[10] = "Out";
							$mes[11] = "Nov";
							$mes[12] = "Dez";
							$i = 1;
							
							if($_SESSION['FiltroBalanco']['Quitado'] == 'S')
								$status = 'Todas as Receitas e Despesas "Pagas"';
							else if ($_SESSION['FiltroBalanco']['Quitado'] == 'N')
								$status = 'Todas as Receitas e Despesas "NAO Pagas"';
							else if ($_SESSION['FiltroBalanco']['Quitado'] == '0')
								$status = 'Todas as Receitas e Despesas "Pagas & Nao Pagas"';
							else 
								$status = 'Todas as Receitas e Despesas "Pagas & Nao Pagas"';
							
							?>
						<!--
						<tr>
							<?php
							echo '<td><b>' . $report['RecPagar'][0]->Balancopagar . '</b></td>';
							for($i=1;$i<=12;$i++) {
								$bgcolor = ($report['RecPagar'][0]->{'M'.$i} <= 0) ? 'bg-info' : 'bg-info';
								echo '<td class="text-right ' . $bgcolor . '">' . $report['RecPagar'][0]->{'M'.$i} . '</td>';
							}
							$bgcolor = ($report['TotalGeralpagar']->RecPagar <= 0) ? 'bg-info' : 'bg-info';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpagar']->RecPagar . '</td>';
							?>
						</tr>
						<tr>
							<?php
							echo '<td><b>' . $report['DesPagar'][0]->Balancopagar . '</b></td>';
							for($i=1;$i<=12;$i++) {
								$bgcolor = ($report['DesPagar'][0]->{'M'.$i} <= 0) ? 'bg-danger' : 'bg-danger';
								echo '<td class="text-right ' . $bgcolor . '">' . $report['DesPagar'][0]->{'M'.$i} . '</td>';
							}
							$bgcolor = ($report['TotalGeralpagar']->DesPagar <= 0) ? 'bg-danger' : 'bg-danger';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpagar']->DesPagar . '</td>';
							?>
						</tr>
						-->
						<tr>
							<?php
							echo '<td><b>' . $report['RecPago'][0]->Balancopago . '</b></td>';
							for($i=1;$i<=12;$i++) {
								$bgcolor = ($report['RecPago'][0]->{'M'.$i} <= 0) ? 'bg-info' : 'bg-info';
								echo '<td class="text-right ' . $bgcolor . '">' . $report['RecPago'][0]->{'M'.$i} . '</td>';
							}
							$bgcolor = ($report['TotalGeralpago']->RecPago <= 0) ? 'bg-info' : 'bg-info';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpago']->RecPago . '</td>';
							?>
						</tr>
						<tr>
							<?php
							echo '<td><b>' . $report['DesPago'][0]->Balancopago . '</b></td>';
							for($i=1;$i<=12;$i++) {
								$bgcolor = ($report['DesPago'][0]->{'M'.$i} <= 0) ? 'bg-danger' : 'bg-danger';
								echo '<td class="text-right ' . $bgcolor . '">' . $report['DesPago'][0]->{'M'.$i} . '</td>';
							}
							$bgcolor = ($report['TotalGeralpago']->DesPago <= 0) ? 'bg-danger' : 'bg-danger';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpago']->DesPago . '</td>';
							?>
						</tr>

						<tr>
							<?php
							echo '<td><b>' . $report['TotalPago']->Balancopago . '</b></td>';
							for($i=1;$i<=12;$i++) {
								$bgcolor = ($report['TotalPago']->{'M'.$i} < 0) ? 'bg-warning' : 'bg-warning';
								echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalPago']->{'M'.$i} . '</td>';
							}
							$bgcolor = ($report['TotalGeralpago']->BalancoGeralpago < 0) ? 'bg-warning' : 'bg-warning';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpago']->BalancoGeralpago . '</td>';
							?>
						</tr>

					</tbody>
					
				</table>
				<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
				<script type="text/javascript">
				  google.charts.load('current', {'packages':['bar']});
				  google.charts.setOnLoadCallback(drawChart);

				  function drawChart() {
					var data = google.visualization.arrayToDataTable([
					  ["Mes", "Receita", "Despesa", "Lucro"],
						<?php 
						$k = 12;
						for ($i = 1; $i <= $k; $i++){?>
								
						['<?php echo $mes[$i] ?>', (<?php echo $report['RecPago'][0]->{'M'.$i} ?>), (<?php echo $report['DesPago'][0]->{'M'.$i} ?>), (<?php echo $report['TotalPago']->{'M'.$i} ?>)],

						<?php } ?>
					]);

					var options = {
					  chart: {
						title: 'Performance - <?php echo '' . $_SESSION['FiltroBalanco']['Ano'] . '' ?>',
						subtitle: '<?php echo $status ?>',
					  },
					  vAxis: {format: 'decimal'},
							width: 700,
							height: 250,
							bar: {groupWidth: "80%"},
							legend: { position: "right" },
						
					};

					var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

					chart.draw(data, google.charts.Bar.convertOptions(options));
				  }
				</script>			
				<div id="columnchart_material" ></div>
			
		</div>
	</div>
</div>
