<div class="container-fluid">
	<div class="row">
		<?php if($paginacao == "S") { ?>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
				<label></label><br>
				<a href="<?php echo base_url() . $caminho; ?>">
					<button class="btn btn-warning btn-md btn-block" type="button">
						<span class="glyphicon glyphicon-filter"></span>Filtros
					</button>
				</a>
			</div>
		<?php } ?>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-left">
			<label></label><br>
			<a href="<?php echo base_url() . 'gerar_excel/Clientes/Clientes.php'; ?>">
				<button type='button' class='btn btn-md btn-success btn-block'>
					Gerar Excel
				</button>
			</a>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
			<label></label><br>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php echo $report->num_rows(); ?> / <?php echo $total_rows; ?>">
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-left">
			<?php echo $pagination; ?>
		</div>
	</div>
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
			<div style="overflow: auto; height: 550px; ">
				<!--
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="9" class="active">Total encontrado: <?php #echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>
				-->
				<table class="table table-bordered table-condensed table-striped">								
					<thead>
						<tr>
							<th class="active">cont</th>
							<th class=" col-md-1" scope="col">Foto</th>
							<th class="active">id</th>
							<th class="active">Cliente</th>
							<th class="active">Ficha</th>
							<th class="active">Sexo</th>
							<th class="active">Celular</th>
							<th class="active">Telefone2</th>
							<th class="active">Telefone3</th>
							<th class="active">Nascimento</th>
							<th class="active">Endere�o</th>
							<th class="active">Bairro</th>
							<th class="active">Cidade</th>
							<!--<th class="active">E-mail</th>-->
							<th class="active">Ativo?</th>
							<th class="active">Motivo</th>
							<th class="active">Cadastrado</th>
							<th class="active">Login</th>
							<!--<th class="active">Contato</th>
							<th class="active">Sexo</th>
							<th class="active">Rel. Com.</th>
							<th class="active">Rel. Pes.</th>-->

						</tr>
					</thead>

					<tbody>

						<?php
						$cont_feminino = 0;
						$cont_masculino = 0;
						$cont_outros = 0;
						$cont_nao_infor = 0;
						$linha =  $per_page*$pagina;
						$count = 1;
						foreach ($report->result_array() as $row) {
						?>
						<tr class="clickable-row" data-href="<?php echo base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'] . ''; ?>">
							<td><?php echo ($linha + $count) ?></td>
							<td><img  class="img-circle img-responsive" width='50' alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $row['Arquivo'] . ''; ?> "></td>
							<td><?php echo $row['idApp_Cliente'] ?></td>
							<td><?php echo $row['NomeCliente'] ?></td>
							<td><?php echo $row['RegistroFicha'] ?></td>
							<td><?php echo $row['Sexo'] ?></td>
							<td><?php echo $row['CelularCliente'] ?></td>
							<td><?php echo $row['Telefone2'] ?></td>
							<td><?php echo $row['Telefone3'] ?></td>
							<td><?php echo $row['DataNascimento'] ?></td>
							<td><?php echo $row['EnderecoCliente'] ?></td>
							<td><?php echo $row['BairroCliente'] ?></td>
							<td><?php echo $row['CidadeCliente'] ?></td>
							<!--<td><?php #echo $row['Email'] ?></td>-->
							<td><?php echo $row['Ativo'] ?></td>
							<td><?php echo $row['Motivo'] ?></td>
							<td><?php echo $row['DataCadastroCliente'] ?></td>
							<td><?php echo $row['usuario'] ?></td>
						</tr>						
						<?php
							$count++;
							if($row['Sexo'] == 'F')
								$cont_feminino++;
							else if ($row['Sexo'] == 'M')
								$cont_masculino++;
							else if ($row['Sexo'] == 'O')
								$cont_outros++;
							else 
								$cont_nao_infor++;
						
						}
						?>

					</tbody>

				</table>
				  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
				  <script type="text/javascript">
					google.charts.load("current", {packages:['corechart']});
					google.charts.setOnLoadCallback(drawChart);
					
					function drawChart() {
					  var data = google.visualization.arrayToDataTable([
						["Sexo", "Quantidade", { role: "style" } ],
						["Feminino", <?php echo $cont_feminino; ?>, "#b87333"],
						["Masculino", <?php echo $cont_masculino; ?>, "silver"],
						["Outros", <?php echo $cont_outros; ?>, "gold"],
						["Nao Inform", <?php echo $cont_nao_infor; ?>, "color: #e5e4e2"]			
					  ]);

					  var view = new google.visualization.DataView(data);
					  view.setColumns([0, 1,
									   { calc: "stringify",
										 sourceColumn: 1,
										 type: "string",
										 role: "annotation" },
									   2]);

					  var options = {
						title: "Sexo",
						width: 600,
						height: 400,
						bar: {groupWidth: "95%"},
						legend: { position: "none" },
					  };
					  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
					  chart.draw(view, options);
				  }
				  </script>			
				<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
			</div>
		</div>	
	</div>
</div>