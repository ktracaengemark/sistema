<div class="container-fluid">
	<div class="row">	
		<table class="table table-bordered table-condensed table-striped">	
			<tfoot>
				<tr>
					<th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
				</tr>
			</tfoot>
		</table>
		<div style="overflow: auto; width: auto; height: auto;">
			<table class="table table-bordered table-condensed table-striped">

				<thead>
					
					<tr>                       											
						<th class="active">Nº</th>
						<?php if($_SESSION['log']['idSis_Empresa'] != 5) { ?>
							<th class="active">Quem Fazer</th>
						<?php } ?>
						<th class="active">Categoria</th>
						<!--<th class="active">Prior</th>
						<th class="active">StatusTRF</th>-->
						<th class="active">Tarefa</th>
						<th class="active">Concl.?</th>
						<th class="active">Inicia em:</th>
						<th class="active">Conc. em:</th>
						<th class="active">SubTarefa</th>
						<th class="active">Concl.?</th>
						<th class="active">Inicio em:</th>
						<th class="active">Fim em:</th>
						<?php if($_SESSION['log']['idSis_Empresa'] != 5) { ?>
							<th class="active">Quem Cad</th>
						<?php } ?>
					</tr>
				</thead>

				<tbody>

					<?php
					$cliente = array ();
					$valor = array();
					$i = 0;
					$cont_s_1 = 0;
					$cont_n_1 = 0;
					$cont_s_2 = 0;
					$cont_n_2 = 0;
					$cont_info_1 = 0;
					$cont_info_2 = 0;
					
					$cont_fazer = 0;
					$cont_fazendo = 0;
					$cont_feito = 0;
					$cont_nao_infor = 0;
					$cont_fazer2 = 0;
					$cont_fazendo2 = 0;
					$cont_feito2 = 0;
					$cont_nao_infor2 = 0;
					foreach ($report->result_array() as $row) {
						
						#echo '<tr>';
						echo '<tr class="clickable-row" data-href="' . base_url() . 'tarefa/alterar/' . $row['idApp_Tarefa'] . '">';
							echo '<td>' . $row['idApp_Tarefa'] . '</td>';
							if($_SESSION['log']['idSis_Empresa'] != 5) {	
								echo '<td>' . $row['Comp'] . '</td>';
							}
							echo '<td>' . $row['Categoria'] . '</td>';
							#echo '<td>' . $row['Prioridade'] . '</td>';
							#echo '<td>' . $row['Statustarefa'] . '</td>';
							echo '<td>' . $row['Tarefa'] . '</td>';
							echo '<td>' . $row['ConcluidoTarefa'] . '</td>';
							echo '<td>' . $row['DataTarefa'] . '</td>';
							echo '<td>' . $row['DataTarefaLimite'] . '</td>';
							echo '<td>' . $row['SubTarefa'] . '</td>';
							echo '<td>' . $row['ConcluidoSubTarefa'] . '</td>';
							echo '<td>' . $row['DataSubTarefa'] . '</td>';
							echo '<td>' . $row['DataSubTarefaLimite'] . '</td>';
							if($_SESSION['log']['idSis_Empresa'] != 5) {	
								echo '<td>' . $row['NomeUsuario'] . '</td>';
							}
						echo '</tr>';
						
						$nomecliente = $row['Tarefa'];
						$valorcliente = $row['Prioridade'];
						$cliente[$i] = $nomecliente;
						$valor[$i] = $valorcliente;
						$i = $i + 1;
						
						if($row['ConcluidoSubTarefa'] == 'Sim')
							$cont_s_2++;
						else if ($row['ConcluidoSubTarefa'] == 'Não')
							$cont_n_2++;
						else 
							$cont_info_2++;
						
						if($row['ConcluidoTarefa'] == 'Sim')
							$cont_s_1++;
						else if ($row['ConcluidoTarefa'] == 'Não')
							$cont_n_1++;
						else 
							$cont_info_1++;
						

						
						if($row['Statussubtarefa'] == 'Fazer')
							$cont_fazer++;
						else if ($row['Statussubtarefa'] == 'Fazendo')
							$cont_fazendo++;
						else if ($row['Statussubtarefa'] == 'Feito')
							$cont_feito++;
						else 
							$cont_nao_infor++;
						
						if($row['Statustarefa'] == 'Fazer')
							$cont_fazer2++;
						else if ($row['Statustarefa'] == 'Fazendo')
							$cont_fazendo2++;
						else if ($row['Statustarefa'] == 'Feito')
							$cont_feito2++;
						else 
							$cont_nao_infor2++;
					}
					/*
					echo "<pre>";
					print_r($cont_s_2);
					echo "<br>";
					print_r($cont_n_2);
					echo "<br>";
					print_r($cont_info_2);
					echo "</pre>";
					exit();
					*/
					?>

				</tbody>

			</table>

		</div>
	</div>	
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-4">	
				<div id="piechart" style="width: auto; height: 300px;"></div>
			</div>
			<div class="col-md-4">
				<div id="piechart3" style="width: auto; height: 300px;"></div>
			</div>			
			<div class="col-md-4">
				<div id="piechart2" style="width: auto; height: 300px;"></div>
			</div>
		</div>
	</div>	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
	  google.charts.load('current', {'packages':['corechart']});
	  google.charts.setOnLoadCallback(drawChart);

	  function drawChart() {

		var data = google.visualization.arrayToDataTable([
		  ['Tarefas', ''],
			
			<?php 
			$k = $i;
			for ($i = 0; $i < $k; $i++){?>
					
			['<?php echo $cliente[$i] ?>', 1],

			<?php } ?>
		]);

		var options = {
		  title: 'Tarefa Dividida em - <?php echo $report->num_rows(); ?> partes'
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));

		chart.draw(data, options);
	  }
	</script>
	<script type="text/javascript">
	  google.charts.load('current', {'packages':['corechart']});
	  google.charts.setOnLoadCallback(drawChart);

	  function drawChart() {

		var data = google.visualization.arrayToDataTable([
		/*
		["StsTrf", "Quantidade", { role: "style" } ],
		["Fazer", <?php echo $cont_fazer2; ?>, "#b87333"],
		["Fazendo", <?php echo $cont_fazendo2; ?>, "silver"],
		["Feito", <?php echo $cont_feito2; ?>, "silver"],
		["Nao Inform", <?php echo $cont_nao_infor2; ?>, "color: #e5e4e2"]
		*/
		
		["StsTrf", "Quantidade", { role: "style" } ],
		["Concluído", <?php echo $cont_s_1; ?>, "#b87333"],
		["Não_Concluído", <?php echo $cont_n_1; ?>, "silver"],
		["Nao_Inform", <?php echo $cont_info_1; ?>, "color: #e5e4e2"]				
		
		]);

		var options = {
		  title: 'Porcentagem do Status das Tarefas'
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart3'));

		chart.draw(data, options);
	  }
	</script>						
	<script type="text/javascript">
	  google.charts.load('current', {'packages':['corechart']});
	  google.charts.setOnLoadCallback(drawChart);

	  function drawChart() {

		var data = google.visualization.arrayToDataTable([
		/*
		["StsSubTrf", "Quantidade", { role: "style" } ],
		["Fazer", <?php echo $cont_fazer; ?>, "#b87333"],
		["Fazendo", <?php echo $cont_fazendo; ?>, "silver"],
		["Feito", <?php echo $cont_feito; ?>, "silver"],
		["Nao Inform", <?php echo $cont_nao_infor; ?>, "color: #e5e4e2"]
		*/
		
		["StsSubTrf", "Quantidade", { role: "style" } ],
		["Concluído", <?php echo $cont_s_2; ?>, "#b87333"],
		["Não_Concluído", <?php echo $cont_n_2; ?>, "silver"],
		["Nao_Inform", <?php echo $cont_info_2; ?>, "color: #e5e4e2"]
		
		]);

		var options = {
		  title: 'Porcentagem do Status das Sub-Tarefas'
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

		chart.draw(data, options);
	  }
	</script>

</div>
