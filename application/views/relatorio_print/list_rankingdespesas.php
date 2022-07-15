<div class="container-fluid">
	<div class="row">
		<div style="overflow: auto; width: auto; height: auto;">			
			<div class="form-group">
				<div class="row">			
					<div class="col-md-6" >	
						<div id="columnchart_values" ></div>
					</div>
					
					<div class="col-md-6">
						<div id="piechart" style="width: auto; height: auto;"></div>
					</div>
					
				</div>	
			</div>	
		</div>	
		<table class="table table-bordered table-condensed table-striped">	
			<tfoot>
				<tr>						
					<th colspan="1" class="active">Total:</th>
					<th colspan="1" class="active"><?php echo $report->soma->somaqtdparc ?></th>						
				</tr>
			</tfoot>
		</table>
		<div style="overflow: auto; width: auto; height: 300px;">	
			<table class="table table-bordered table-condensed table-striped">
				
				<thead>
					<tr>
						<th class="active text-center">Tipo</th>
						<th class="active text-center">Valor</th>
					</tr>
				</thead>
				<!--
				<thead>
					<tr>						
						<th colspan="1" class="active">Total :</th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdparc ?></th>												
					</tr>
				</thead>
				-->
				<tbody>

					<?php
					$cliente = array ();
					$valor = array();
					$i = 0;
					foreach ($report as $row) {
					#for($i=0;$i<count($report);$i++) {

						if(isset($row->TipoFinanceiro)) {
							
							echo '<tr>';
								echo '<td>' . $row->TipoFinanceiro . '</td>';
								echo '<td>' . $row->QtdParc . '</td>';							
							echo '</tr>';
						
							$nomecliente = $row->TipoFinanceiro;
							$valorcliente = $row->QtdParc;
							$cliente[$i] = $nomecliente;
							$valor[$i] = $valorcliente;
							$i = $i + 1;
							
						}
					}
					?>

				</tbody>


			</table>
		</div>
	  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	  <script type="text/javascript">
		google.charts.load("current", {packages:['corechart']});
		google.charts.setOnLoadCallback(drawChart);
		
		function drawChart() {
		  var data = google.visualization.arrayToDataTable([
			["Tipo", "Despesa", { role: "style" } ],
			
			<?php 
			$k = $i;
			for ($i = 0; $i < $k; $i++){?>
					
			['<?php echo $cliente[$i] ?>', ( <?php echo $valor[$i] ?> ), "#b87333"],

			<?php } ?>		
		  ]);

		  var view = new google.visualization.DataView(data);
		  view.setColumns([0, 1,
						   { calc: "stringify",
							 sourceColumn: 1,
							 type: "string",
							 role: "annotation" },
						   2]);

		  var options = {
			title: "Tipo X Despesa",
			vAxis: {format: 'decimal'},
			height: 400,
			bar: {groupWidth: "95%"},
			legend: { position: "none" },
		  };
		  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
		  chart.draw(view, options);
	  }
	  </script>	
	  

	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
	  google.charts.load('current', {'packages':['corechart']});
	  google.charts.setOnLoadCallback(drawChart);

	  function drawChart() {

		var data = google.visualization.arrayToDataTable([
		  ['Tipo', 'Despesa'],
			
			<?php 
			$k = $i;
			for ($i = 0; $i < $k; $i++){?>
					
			['<?php echo $cliente[$i] ?>', ( <?php echo $valor[$i] ?> )],

			<?php } ?>
		]);

		var options = {
		  title: 'Ranking de Despesas'
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));

		chart.draw(data, options);
	  }
	</script>		
	</div>
</div>
