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
		
		<div style="overflow: auto; width: auto; height: 300px;">
			<!--
			<table class="table table-bordered table-condensed table-striped">	
				<thead>
					<tr>						
						<th colspan="1" class="active">Cont / id_Cliente:</th>
						<th colspan="7" class="active">Clientes = <?php #echo $report->soma->somaqtdclientes ?>/<?php echo $total_rows ?></th>
						<th colspan="1" class="active">Pedidos = <?php #echo $report->soma->somaqtdpedidos ?></th>
						<th colspan="1" class="active">Valor Total = <?php #echo $report->soma->somaqtdparc ?></th>
						<th colspan="1" class="active">CashBack<?php #echo $report->soma->somaqtdparc ?></th>	
						<th colspan="1" class="active">Validade<?php #echo $report->soma->somaqtdparc ?></th>							
					</tr>
				</thead>
			</table>
			-->		
			<table class="table table-bordered table-condensed table-striped">
				
				<thead>
					<tr>						
						<th colspan="1" class="active">Cont / id_Cliente:</th>
						<th colspan="7" class="active">Clientes = <?php echo $report->soma->somaqtdclientes ?>/<?php echo $total_rows ?></th>
						<th colspan="1" class="active">Pedidos = <?php echo $report->soma->somaqtdpedidos ?></th>
						<th colspan="1" class="active">Valor Total = <?php echo $report->soma->somaqtdparc ?></th>
						<th colspan="1" class="active">CashBack</th>	
						<th colspan="1" class="active">Validade</th>
						<th colspan="1" class="active">Whatsapp</th>							
					</tr>
				</thead>
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
								echo '<td colspan="1">' . ($linha + $cont) . ' / ' . $row->idApp_Cliente . '</td>';
								echo '<td colspan="7">' . $row->NomeCliente . '</td>';
								echo '<td colspan="1">' . $row->ContPedidos . '</td>';
								echo '<td colspan="1">' . $row->Valor2 . '</td>';
								echo '<td colspan="1">' . $row->CashBackCliente . '</td>';	
								echo '<td colspan="1">' . $row->ValidadeCashBack . '</td>';			
								echo '<td class="notclickable">
										' . $row->CelularCliente . '
										<a class="notclickable" href="https://api.whatsapp.com/send?phone=55'.$row->CelularCliente.'&text='.$_SESSION['FiltroRankingVendas']['Texto1'].' '.$row->NomeCliente.' '.$_SESSION['FiltroRankingVendas']['Texto2'].' R$'.$row->CashBackCliente.' '.$_SESSION['FiltroRankingVendas']['Texto3'].' '.$row->ValidadeCashBack.' '.$_SESSION['FiltroRankingVendas']['Texto4'].'" target="_blank">
											<svg enable-background="new 0 0 512 512" width="20" height="20" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
										</a>
									</td>';
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
