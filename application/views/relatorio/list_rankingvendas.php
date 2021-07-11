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
		</div>
		<div class="row">
			<div class="col-md-5 text-left">
				<?php echo $pagination; ?>
			</div>
			<?php if($paginacao == "S") { ?>
				<div class="col-md-2">
					<br>
					<a href="<?php echo base_url() . $caminho; ?>">
						<button class="btn btn-warning btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-filter"></span> Filtros
						</button>
					</a>
				</div>
				<div class="col-md-2">
					<br>
					<a href="<?php echo base_url() . 'cliente/alterarcashback/' . $_SESSION['log']['idSis_Empresa']; ?>">
						<button class="btn btn-success btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-pencil"></span> CashBack
						</button>
					</a>
				</div>
			<?php } ?>
		</div>
		<table class="table table-bordered table-condensed table-striped">	
			<thead>
				<tr>						
					<th colspan="1" class="active">Cont / id_Cliente:</th>
					<th colspan="7" class="active">Clientes = <?php echo $report->soma->somaqtdclientes ?>/<?php echo $total_rows ?></th>
					<th colspan="1" class="active">Pedidos = <?php echo $report->soma->somaqtdpedidos ?></th>
					<th colspan="1" class="active">Valor Total = <?php echo $report->soma->somaqtdparc ?></th>
					<th colspan="1" class="active">CashBack<?php #echo $report->soma->somaqtdparc ?></th>	
					<th colspan="1" class="active">Validade<?php #echo $report->soma->somaqtdparc ?></th>							
				</tr>
			</thead>
		</table>
		
		<div style="overflow: auto; width: auto; height: 300px;">			
			<table class="table table-bordered table-condensed table-striped">
				<!--
				<thead>
					<tr>
						<th colspan="1" class="active text-center">id</th>
						<th colspan="5" class="active text-center">Cliente</th>
						<th colspan="3" class="active text-center">Pedidos = <?php #echo $report->soma->somaqtdpedidos ?></th>
						<th colspan="3" class="active text-center">Valor Total = <?php #echo $report->soma->somaqtdparc ?></th>
					</tr>
				</thead>
				
				<thead>
					<tr>						
						<th colspan="1" class="active">Total :</th>
						<th colspan="1" class="active"><?php #echo $report->soma->somaqtdparc ?></th>												
					</tr>
				</thead>
				-->
				
				<tbody>

					<?php
					$cliente = array ();
					$valor = array();
					$i = 0;
					$linha =  $per_page*$pagina;
					$cont = 1;
					foreach ($report as $row) {
					
						if(isset($row->NomeCliente)) {
							
							echo '<tr>';
								echo '<td>' . ($linha + $cont) . ' / ' . $row->idApp_Cliente . '</td>';
								echo '<td>' . $row->NomeCliente . '</td>';
								echo '<td>' . $row->ContPedidos . '</td>';
								echo '<td>' . $row->Valor2 . '</td>';
								echo '<td>' . $row->CashBackCliente . '</td>';	
								echo '<td>' . $row->ValidadeCashBack . '</td>';							
							echo '</tr>';
						
							$nomecliente = $row->NomeCliente;
							$valorcliente = $row->Valor;
							$cliente[$i] = $nomecliente;
							$valor[$i] = $valorcliente;
							$i = $i + 1;
							$cont++;
						}
					}
					?>

				</tbody>
				
				<!--
				<tfoot>
					<tr>						
						<th colspan="1" class="active">Total:</th>
						<th colspan="1" class="active"><?php #echo $report->soma->somaqtdparc ?></th>						
					</tr>
				</tfoot>
				-->
			</table>
		</div>	  
		  
		  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		  <script type="text/javascript">
			
			google.charts.load("current", {packages:['corechart']});
			google.charts.setOnLoadCallback(drawChart);
			
			function drawChart() {
			  var data = google.visualization.arrayToDataTable([
				["Cliente", "Receita", { role: "style" } ],
				
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
				title: "Cliente X Receita",
				vAxis: {format: 'decimal'},
				height: 400,
				bar: {groupWidth: "95%"},
				legend: { position: "none" },
			  };
			  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
			  chart.draw(view, options);
		  }
		  
		  </script>	

		<script type="text/javascript">
		  
		  google.charts.load('current', {'packages':['corechart']});
		  google.charts.setOnLoadCallback(drawChart);

		  function drawChart() {

			var data = google.visualization.arrayToDataTable([
			  ['Cliente', 'Receita'],
				
				<?php 
				$k = $i;
				for ($i = 0; $i < $k; $i++){?>
						
				['<?php echo $cliente[$i] ?>', ( <?php echo $valor[$i] ?> )],

				<?php } ?>
			]);

			var options = {
			  title: 'Ranking de Vendas'
			};

			var chart = new google.visualization.PieChart(document.getElementById('piechart'));

			chart.draw(data, options);
		  }
		  
		</script>
		
	
</div>
