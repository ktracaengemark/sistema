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
							<!--<th class="active">id</th>-->
							<th class="active">Cliente</th>
							<th class="active">Celular</th>
							<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
								<th class="active">Pet</th>
							<?php }else{ ?>
								<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
									<th class="active">Dep</th>
								<?php } ?>
							<?php } ?>
							<th class="active">Ficha</th>
							<th class="active">Sexo</th>
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
							<!--<th class="active">Sexo</th>
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
						
						<!--<tr class="clickable-row" data-href="<?php #echo base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'] . ''; ?>">-->
						<tr>
							<td><?php echo ($linha + $count) ?></td>
							<td class="notclickable">
								<a class="notclickable" href="<?php echo base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'] . ''; ?>">
									<img  class="img-circle img-responsive" width='50' alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $row['Arquivo'] . ''; ?> ">
									<?php echo $row['idApp_Cliente'] ?>
								</a>
							</td>
							<td> <?php echo $row['NomeCliente'] ?></td>
							<td class="notclickable">
								<?php echo $row['CelularCliente'] ?>
								<!--<a href="javascript:window.open('https://api.whatsapp.com/send?phone=55<?php echo $_SESSION['Cliente']['CelularCliente'];?>&text=','1366002941508','width=700,height=250,top=300')">
								<a class="notclickable" href="https://api.whatsapp.com/send?phone=55<?php #echo $row['CelularCliente'] ?>&text=<?php #echo $_SESSION['FiltroAlteraParcela']['Texto1'] ?> <?php #echo $row['NomeCliente'] ?> <?php #echo $_SESSION['FiltroAlteraParcela']['Texto2'] ?>" target="_blank">-->
								<a href="javascript:window.open('https://api.whatsapp.com/send?phone=55<?php echo $row['CelularCliente'];?>&text=<?php echo $row['NomeCliente'] ?>','1366002941508','width=700,height=250,top=300')">	
									<svg enable-background="new 0 0 512 512" width="20" height="20" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
								</a>
							</td>
							<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
								<td><?php echo $row['NomeClientePet'] ?></td>
							<?php }else{ ?>
								<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
									<td><?php echo $row['NomeClienteDep'] ?></td>
								<?php } ?>
							<?php } ?>
							<td><?php echo $row['RegistroFicha'] ?></td>
							<td><?php echo $row['Sexo'] ?></td>
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