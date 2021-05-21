<div style="overflow: auto; height: 550px; ">	
	<div class="container-fluid">
		
		<div>
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
					<tr>
						<th colspan="9" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
					</tr>
				</tfoot>
			</table>	
			<table class="table table-bordered table-condensed table-striped">								
				<thead>
					<tr>
						<th class=" col-md-1" scope="col">Foto</th>
						<th class="active">id</th>
						<th class="active">Cliente</th>
						<th class="active">Ficha</th>
						<th class="active">Sexo</th>
						<th class="active">Celular</th>
						<th class="active">Telefone2</th>
						<th class="active">Telefone3</th>
						<th class="active">Nascimento</th>
						<th class="active">Endereço</th>
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
					foreach ($report->result_array() as $row) {
					?>
					<tr class="clickable-row" data-href="<?php echo base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'] . ''; ?>">
						<td><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'></td>
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