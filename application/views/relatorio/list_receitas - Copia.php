<div class="panel panel-<?php echo $panel; ?>">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-2">
				<label for="DataFim">Cont: Parc / Total</label>
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
					<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php echo $report->num_rows(); ?> / <?php echo $_SESSION['FiltroReceitas']['total_rows']; ?>">
				</div>
			</div>
			<?php if($_SESSION['Usuario']['Rel_Pag'] == "S") {?>
				<div class="col-md-2">
					<label for="DataFim">Final: Parc / Total</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total" value="<?php echo $report->soma->somafinal ?> / <?php echo $_SESSION['FiltroReceitas']['total_valor']; ?>">
					</div>
				</div>
			<?php } ?>
			<div class="col-md-4 text-left">
				<?php echo $pagination; ?>
			</div>
			<?php if($paginacao == "S") { ?>
				<div class="col-md-1">
					<label>Filtros</label>
					<a href="<?php echo base_url() . $caminho; ?>">
						<button class="btn btn-warning btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-filter"></span>
						</button>
					</a>
				</div>
			<?php }else{ ?>
				<div class="col-md-1">
					<label>Filtros</label>
					<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-filter"></span>
					</button>
				</div>
			<?php } ?>
			<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
				<?php if($_SESSION['Usuario']['Bx_Prd'] == "S" && $_SESSION['Usuario']['Bx_Pag'] == "S") {?>
					<?php if ($editar == 1) { ?>
						<div class="col-md-1">
							<label>Todas</label>
							<a href="<?php echo base_url() . $baixatodas . $_SESSION['log']['idSis_Empresa']; ?>">
								<button class="btn btn-danger btn-md btn-block" type="button">
									<span class="glyphicon glyphicon-edit"></span>
								</button>
							</a>
						</div>
					<?php }elseif($editar == 2){ ?>
						<div class="col-md-1">
							<label>Baixa</label>
							<a href="<?php echo base_url() . $alterar; ?>">
								<button class="btn btn-danger btn-md btn-block" type="button">
									<span class="glyphicon glyphicon-alert"></span>
								</button>
							</a>
						</div>
					<?php } ?>
				<?php } ?>	
				<?php if ($print == 1) { ?>	
					<div class="col-md-1">
						<label>Imprimir</label>
						<a href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
							<button class="btn btn-<?php echo $panel; ?> btn-md btn-block" type="button">
								<span class="glyphicon glyphicon-print"></span>
							</button>
						</a>
					</div>
				<?php } ?>
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-6 text-left">
					<label>Excel</label><br>
					<a href="<?php echo base_url() . 'gerar_excel/Orcamentos/Orcamentos_xls.php'; ?>">
						<button type='button' class='btn btn-md btn-success btn-block'>
							<span class="glyphicon glyphicon-print"></span>
						</button>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
	

<div class="container-fluid">
	<div class="row">
		<div style="overflow: auto; height: auto; ">
			<table class="table table-bordered table-condensed table-striped">
				<thead>						
					<tr>
						<th class="active">cont.</th>
						<th class="active">Imp.</th>
						<?php if($editar == 1) { ?>
							<?php if($metodo == 3) { ?>
								<?php if($_SESSION['Usuario']['Bx_Prd'] == "S" && $_SESSION['Usuario']['Bx_Pag'] == "S") {?>
									<th class="active">Baixa</th>
								<?php } ?>
							<?php } ?>
						<?php }elseif($editar == 2) {?>
							<th class="active">Editar</th>
						<?php } ?>
						<th class="active">Pdd</th>
						<th class="active">DtPedido</th>
						<th class="active">Comb.Ent</th>
						<th class="active">Comb.Pag</th>
						<th class="active">Entr.</th>
						<th class="active">Pago</th>
						<th class="active">Final.</th>
						<th class="active">Canc.</th>
					</tr>
				</thead>
				<tbody>
					<?php
					//$linha =  $per_page*$pagina;
					$count = 1;
					foreach ($report->result_array() as $row) { 
					?>
						<tr>
							<td><?php echo ($linha + $count);?></td>
							<td class="notclickable">
								<a class="btn btn-md btn-<?php echo $panel;?> notclickable" href="<?php echo base_url() . $imprimir . $row['idApp_OrcaTrata']; ?>">
									<span class="glyphicon glyphicon-print notclickable"></span>
								</a>
							</td>
							<?php if($editar == 1){ ?>
								<?php if($_SESSION['Usuario']['Bx_Prd'] == "S" && $_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
									<?php if($metodo == 3){ ?>
										<?php if($row['CanceladoOrca'] == "N"){ ?>	
											<?php if($row['QuitadoOrca'] == "S" && $row['ConcluidoOrca'] == "S"){ ?>
												<td class="notclickable">
													<a class="btn btn-md btn-danger notclickable">
														<span class="glyphicon glyphicon-ok notclickable"></span>
													</a>
												</td>
											<?php }else{ ?>
												<td class="notclickable">
													<a class="btn btn-md btn-success notclickable" href="<?php echo base_url() . $baixa . $row['idApp_OrcaTrata'];?>">
														<span class="glyphicon glyphicon-ok notclickable"></span>
													</a>
												</td>
											<?php } ?>
										<?php }else{ ?>
											<td class="notclickable">
												<a class="btn btn-md btn-danger notclickable">
													<span class="glyphicon glyphicon-ok notclickable"></span>
												</a>
											</td>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							<?php }else if($editar == 2){ ?>
								<td class="notclickable">
									<a class="btn btn-md btn-warning notclickable" href="<?php echo base_url() . $edit . $row['idApp_OrcaTrata'];?>">
										<span class="glyphicon glyphicon-edit notclickable"></span>
									</a>
								</td>
							<?php } ?>
							<td><?php echo $row['idApp_OrcaTrata'];?></td>
							<td><?php echo $row['DataOrca'];?></td>
							<?php echo '<td>' . $row['CombinadoFrete'] . '</td>';?>	
							<?php echo '<td>' . $row['AprovadoOrca'] . '</td>';?>	
							<?php echo '<td>' . $row['ConcluidoOrca'] . '</td>';?>	
							<?php echo '<td>' . $row['QuitadoOrca'] . '</td>';?>	
							<?php echo '<td>' . $row['FinalizadoOrca'] . '</td>';?>	
							<?php echo '<td>' . $row['CanceladoOrca'] . '</td>';?>							
						</tr>
					<?php	
						$count++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>