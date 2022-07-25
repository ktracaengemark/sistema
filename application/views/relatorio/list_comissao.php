<div class="panel panel-<?php echo $panel; ?>">
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 text-left">
				<label for="DataFim">Cont: Parc / Total</label>
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
					<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php echo $report->num_rows(); ?> / <?php echo $total_rows; ?>">
				</div>
			</div>
			<?php if($_SESSION['Usuario']['Rel_Pag'] == "S") {?>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
					<label for="DataFim">Prod + Serv:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Orcamento" value="<?php echo $report->soma->somarestante ?>">
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
					<label for="DataFim">Frete:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Frete" value="<?php echo $report->soma->somafrete ?>">
					</div>
				</div>	
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
					<label for="DataFim">Extra:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Orcamento" value="<?php echo $report->soma->somaextra; ?>">
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
					<label for="DataFim">Total:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total" value="<?php echo $report->soma->somatotal ?>">
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
					<label for="DataFim">Desc:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total" value="<?php echo $report->soma->somadesc ?>">
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
					<label for="DataFim">CashBack:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total" value="<?php echo $report->soma->somacashback ?>">
					</div>
				</div>
				<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 text-left">
					<label for="DataFim">Final: Parc / Total</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total" value="<?php echo $report->soma->somafinal ?> / <?php echo $pesquisa_query->soma2->somafinal2;?>">
					</div>
				</div>	
				<?php if($_SESSION['Usuario']['Rel_Com'] == "S") {?>
					<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 text-left">
						<label for="DataFim">Com: Parc / Total</label>
						<div class="input-group">
							<span class="input-group-addon">R$</span>
							<input type="text" class="form-control" disabled aria-label="Comissao" value="<?php echo $report->soma->somacomissao ?> / <?php echo $pesquisa_query->soma2->somacomissao2 ?>">
						</div>
					</div>
				<?php } ?>
			<?php } ?>
			<div class="col-lg-2 col-md-4 col-sm-12 col-xs-12 text-left">
				<?php echo $pagination; ?>
			</div>
			<?php if($paginacao == "S") { ?>
				<div class="col-lg-1 col-md-1 col-sm-2 col-xs-6 text-left">
					<label>Filtros</label>
					<a href="<?php echo base_url() . $caminho; ?>">
						<button class="btn btn-warning btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-filter"></span>
						</button>
					</a>
				</div>
			<?php }else{ ?>
				<div class="col-lg-1 col-md-1 col-sm-2 col-xs-6 text-left">
					<label>Filtros</label>
					<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-filter"></span>
					</button>
				</div>
			<?php } ?>
			<div class="col-lg-1 col-md-1 col-sm-2 col-xs-6 text-left">
				<label>Excel</label><br>
				<a href="<?php echo base_url() . 'Relatorio_print/comissao_excel/2'; ?>">
					<button type='button' class='btn btn-md btn-success btn-block'>
						C/<span class="glyphicon glyphicon-filter"></span>
					</button>
				</a>
			</div>
			<?php if($_SESSION['Usuario']['Bx_Prd'] == "S" && $_SESSION['Usuario']['Bx_Pag'] == "S" && $_SESSION['Usuario']['Nivel'] != 2) {?>
				<?php if ($editar == 1) { ?>
					<?php if ($print == 1) { ?>	
						<div class="col-lg-1 col-md-1 col-sm-2 col-xs-6 text-left">
							<label>Lista</label>
							<a href="<?php echo base_url() . $imprimirlista; ?>">
								<button class="btn btn-<?php echo $panel; ?> btn-md btn-block" type="button">
									<span class="glyphicon glyphicon-list"></span>
								</button>
							</a>
						</div>
					<?php } ?>
					<div class="col-lg-1 col-md-1 col-sm-2 col-xs-6 text-left">
						<label>Baixa</label>
						<a href="<?php echo base_url() . $baixatodas . $_SESSION['log']['idSis_Empresa']; ?>">
							<button class="btn btn-danger btn-md btn-block" type="button">
								<span class="glyphicon glyphicon-ok"></span>
							</button>
						</a>
					</div>
				<?php } ?>
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
						<th class="active">Cont.</th>
						<th class="active">Imp.</th>
						<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
							<?php if($_SESSION['Usuario']['Nivel'] != 2) { ?>
								<th class="active">Editar</th>
							<?php } ?>
						<?php } ?>
						<th class="active">Pdd|Tp</th>
						<th class="active">DtPedido</th>
						<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
							<th class="active"><?php echo $nome ?></th>
							<th class="active">Celular</th>
							<?php if($_SESSION['Usuario']['Rel_Pag'] == "S") {?>
								<th class="active">Prd/Srv</th>
								<th class="active">Frete</th>
								<th class="active">Extra</th>
								<th class="active">Total</th>
								<th class="active">Desc</th>
								<th class="active">Cash</th>
								<th class="active">Final</th>
							<?php } ?>
						<?php }else{ ?>	
							<th class="active">Extra</th>
						<?php } ?>
						<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>	
							<th class="active">Comb.Ent</th>
							<th class="active">Comb.Pag</th>
							<th class="active">Entr.</th>
							<th class="active">Pago</th>
							<th class="active">Final.</th>
							<th class="active">Canc.</th>
							<th class="active">Compra</th>
							<th class="active">Entrega</th>
							<th class="active">Pagam.</th>
							<th class="active">Form.Pag.</th>
							<th class="active"><?php echo $nomeusuario ?></th>
							<th class="active">Comissao</th>
							<th class="active">Paga?</th>
							<th class="active">DataPago</th>
						<?php }else{ ?>
							<th class="active">Pago</th>
							<th class="active">Form.Pag.</th>
						<?php } ?>	
					</tr>
				</thead>
				<tbody>
					<?php
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
							<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
								<?php if($_SESSION['Usuario']['Nivel'] != 2) { ?>
									<td class="notclickable">
										<a class="btn btn-md btn-warning notclickable" href="<?php echo base_url() . $edit . $row['idApp_OrcaTrata'];?>">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>
								<?php } ?>
							<?php } ?>
							<td><?php echo $row['idApp_OrcaTrata'];?> - <?php echo $row['TipoFinanceiro'];?></td>
							<?php echo '<td>' . $row['DataOrca'] . '</td>';?>
							<?php if($_SESSION['log']['idSis_Empresa'] != 5) { ?>
								<td class="notclickable">
									<?php echo $row['Nome'.$nome]; ?>
								</td>
								<td>
									<?php echo $row['Celular'.$nome] ?>
								</td>
								<?php if($_SESSION['Usuario']['Rel_Pag'] == 'S') { ?>
									<td><?php echo $row['ValorRestanteOrca'] ?></td>
									<td><?php echo $row['ValorFrete'] ?></td>
									<td><?php echo $row['ValorExtraOrca'] ?></td>
									<td><?php echo $row['TotalOrca'] ?></td>
									<td><?php echo $row['DescValorOrca'] ?></td>
									<td><?php echo $row['CashBackOrca'] ?></td>
									<td><?php echo $row['ValorFinalOrca'] ?></td>
								<?php } ?>
							<?php }else{ ?>
								<td><?php echo $row['ValorExtraOrca'] ?></td>
							<?php }	 ?>
							<?php if($_SESSION['log']['idSis_Empresa'] != 5) { ?>
								<?php echo '<td>' . $row['CombinadoFrete'] . '</td>';?>	
								<?php echo '<td>' . $row['AprovadoOrca'] . '</td>';?>	
								<?php echo '<td>' . $row['ConcluidoOrca'] . '</td>';?>	
								<?php echo '<td>' . $row['QuitadoOrca'] . '</td>';?>	
								<?php echo '<td>' . $row['FinalizadoOrca'] . '</td>';?>	
								<?php echo '<td>' . $row['CanceladoOrca'] . '</td>';?>	
								<?php echo '<td>' . $row['Tipo_Orca'] . '</td>';?>	
								<?php echo '<td>' . $row['TipoFrete'] . '</td>';?>	
								<?php echo '<td>' . $row['AVAP'] . '</td>';?>	
								<?php echo '<td>' . $row['FormaPag'] . '</td>';?>
							<?php }else{ ?>		
								<?php echo '<td>' . $row['QuitadoOrca'] . '</td>';?>
								<?php echo '<td>' . $row['FormaPag'] . '</td>';?>
							<?php }	 ?>
							<?php echo '<td>' . $row[$nomeusuario] . '</td>';?>
							<?php echo '<td>' . $row['ValorComissao'] . '</td>';?>
							<?php echo '<td>' . $row[$status] . '</td>';?>
							<?php echo '<td>' . $row['DataPagoComissaoOrca'] . '</td>';?>	
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