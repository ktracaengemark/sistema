<div class="panel panel-<?php echo $panel; ?>">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-2">
				<label for="DataFim">Cont: Parc / Total</label>
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
					<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php echo $report->num_rows(); ?> / <?php echo $total_rows; ?>">
				</div>
			</div>
			<?php if($_SESSION['Usuario']['Rel_Pag'] == "S") {?>
				<div class="col-md-2">
					<label for="DataFim">Prod + Serv:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Orcamento" value="<?php echo $report->soma->somarestante ?>">
					</div>
				</div>
				<div class="col-md-2">
					<label for="DataFim">Frete:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Frete" value="<?php echo $report->soma->somafrete ?>">
					</div>
				</div>	
				<div class="col-md-2">
					<label for="DataFim">Extra:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Orcamento" value="<?php echo $report->soma->somaextra; ?>">
					</div>
				</div>
				<div class="col-md-2">
					<label for="DataFim">Total:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total" value="<?php echo $report->soma->somatotal ?>">
					</div>
				</div>
				<div class="col-md-2">
					<label for="DataFim">Desc:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total" value="<?php echo $report->soma->somadesc ?>">
					</div>
				</div>
				<div class="col-md-2">
					<label for="DataFim">CashBack:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total" value="<?php echo $report->soma->somacashback ?>">
					</div>
				</div>
				<div class="col-md-2">
					<label for="DataFim">Final: Parc / Total</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total" value="<?php echo $report->soma->somafinal ?> / <?php echo $pesquisa_query->soma2->somafinal2 ?>">
					</div>
				</div>
			<?php } ?>
			<?php if($metodo == 1 || $metodo == 2) { ?>
				<?php if($_SESSION['Usuario']['Rel_Com'] == "S") {?>
					<div class="col-md-2">
						<label for="DataFim">Comissao: Parc / Total</label>
						<div class="input-group">
							<span class="input-group-addon">R$</span>
							<input type="text" class="form-control" disabled aria-label="Comissao" value="<?php echo $report->soma->somacomissao ?> / <?php echo $pesquisa_query->soma2->somacomissao2 ?>">
						</div>
					</div>
				<?php } ?>	
			<?php } ?>
			<div class="col-md-3 text-left">
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
				<?php if($_SESSION['Usuario']['Bx_Prd'] == "S" && $_SESSION['Usuario']['Bx_Pag'] == "S") {?>
					<?php if ($editar == 1) { ?>
						<div class="col-md-1">
							<label>Todas</label>
							<a href="<?php echo base_url() . $baixatodas . $_SESSION['log']['idSis_Empresa']; ?>">
								<button class="btn btn-success btn-md btn-block" type="button">
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
			<?php } ?>
		</div>
	</div>
</div>
	

<div class="container-fluid">
	<div class="row">
		<div style="overflow: auto; height: 550px; ">
			<table class="table table-bordered table-condensed table-striped">
				<thead>						
					<tr>
						<!--<th class="active">Excluir</th>-->
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
						<th class="active">Cont.</th>
						<th class="active">Pedido</th>
						
						<!--<th class="active">Contagem</th>-->
						
						<th class="active">Empresa</th>
						
						<th class="active"><?php echo $nome ?></th>
						<th class="active">Tipo</th>
						<?php if($_SESSION['Usuario']['Rel_Pag'] == "S") {?>
							<th class="active">Prd.SrvR$</th>
							<th class="active">FreteR$</th>
							<th class="active">ExtraR$</th>
							<th class="active">TotalR$</th>
							<th class="active">DescR$</th>
							<th class="active">CashR$</th>
							<th class="active">FinalR$</th>
						<?php } ?>	
						<th class="active"><?php echo $nomeusuario ?></th>
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
						<th class="active">DtPedido</th>
						<th class="active">DtEntrega</th>
						<!--<th class="active">DtVnc</th>
						<th class="active">DtVncPrc</th>-->
						<?php if($metodo == 1 || $metodo == 2) { ?>
							<th class="active">Comissao</th>
							<th class="active">Paga?</th>
							<th class="active">DataPago</th>
						<?php } ?>
						<!--<th class="active">Qtd</th>									
						<th class="active">Produto</th>
						<th class="active">Valor</th>
						<th class="active">SubTotal</th>
						<th class="active">Comissao(%)</th>
						<th class="active">SubComissao</th>
						<th class="active">Paga?</th>-->
					</tr>
				</thead>
				<tbody>
					<?php
					$linha =  $per_page*$pagina;
					$count = 1;
					foreach ($report->result_array() as $row) {
						echo '<tr>';
							echo '<td class="notclickable">
									<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . $imprimir . $row['idApp_OrcaTrata'] . '">
										<span class="glyphicon glyphicon-print notclickable"></span>
									</a>
									
								</td>';
							if($editar == 1){
								if($_SESSION['Usuario']['Bx_Prd'] == "S" && $_SESSION['Usuario']['Bx_Pag'] == "S") {
									if($metodo == 3){
										if($row['CanceladoOrca'] == "Não"){	
											if($row['QuitadoOrca'] == "Sim" && $row['ConcluidoOrca'] == "Sim"){
												echo '<td class="notclickable">
														<a class="btn btn-md btn-danger notclickable">
															<span class="glyphicon glyphicon-ok notclickable"></span>
														</a>
													</td>';
											}else{
												echo '<td class="notclickable">
														<a class="btn btn-md btn-success notclickable" href="' . base_url() . $baixa . $row['idApp_OrcaTrata'] . '">
															<span class="glyphicon glyphicon-ok notclickable"></span>
														</a>
													</td>';
											}
										}else{
											echo '<td class="notclickable">
														<a class="btn btn-md btn-danger notclickable">
															<span class="glyphicon glyphicon-ok notclickable"></span>
														</a>
													</td>';
										}
									}
								}	
							}else if($editar == 2){
								echo '<td class="notclickable">
										<a class="btn btn-md btn-warning notclickable" href="' . base_url() . $edit . $row['idApp_OrcaTrata'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
							}	
							echo '<td>' . ($linha + $count) . '</td>';
							echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
							
							//echo '<td>' . $report->soma->contagem . '</td>';
							
							echo '<td>' . $row['NomeEmpresa'] . '</td>';
							
							echo '<td>' . $row['Nome' . $nome] . '</td>';
							echo '<td>' . $row['TipoFinanceiro'] . '</td>';
							if($_SESSION['Usuario']['Rel_Pag'] == "S") {
								echo '<td>' . $row['ValorRestanteOrca'] . '</td>';
								echo '<td>' . $row['ValorFrete'] . '</td>';
								echo '<td>' . $row['ValorExtraOrca'] . '</td>';
								echo '<td>' . $row['TotalOrca'] . '</td>';
								echo '<td>' . $row['DescValorOrca'] . '</td>';
								echo '<td>' . $row['CashBackOrca'] . '</td>';
								echo '<td>' . $row['ValorFinalOrca'] . '</td>';
							}	
							echo '<td>' . $row[$nomeusuario] . '</td>';
							echo '<td>' . $row['CombinadoFrete'] . '</td>';
							echo '<td>' . $row['AprovadoOrca'] . '</td>';
							echo '<td>' . $row['ConcluidoOrca'] . '</td>';
							echo '<td>' . $row['QuitadoOrca'] . '</td>';
							echo '<td>' . $row['FinalizadoOrca'] . '</td>';
							echo '<td>' . $row['CanceladoOrca'] . '</td>';
							echo '<td>' . $row['Tipo_Orca'] . '</td>';
							echo '<td>' . $row['TipoFrete'] . '</td>';
							echo '<td>' . $row['AVAP'] . '</td>';
							echo '<td>' . $row['FormaPag'] . '</td>';
							echo '<td>' . $row['DataOrca'] . '</td>';
							echo '<td>' . $row['DataEntregaOrca'] . '</td>';
							#echo '<td>' . $row['DataVencimentoOrca'] . '</td>';
							#echo '<td>' . $row['DataVencimento'] . '</td>';
							if($metodo == 1 || $metodo == 2){	
								echo '<td>' . $row['ValorComissao'] . '</td>';
								echo '<td>' . $row[$status] . '</td>';
								echo '<td>' . $row['DataPagoComissaoOrca'] . '</td>';
							}
							//echo '<td>' . $row['QtdProduto'] . '</td>';	
							//echo '<td>' . $row['Produtos'] . '</td>';
							//echo '<td class="text-right">' . $row['ValorProduto'] . '</td>';
							//echo '<td class="text-right">' . $row['SubTotal'] . '</td>';
							//echo '<td class="text-right">' . $row['ComissaoProduto'] . '</td>';
							//echo '<td class="text-right">' . $row['SubComissao'] . '</td>';
							//echo '<td>' . $row['StatusComissao'] . '</td>';

							/*
							echo '<td class="notclickable">
									<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'orcatrata/excluir2/' . $row['idApp_OrcaTrata'] . '">
										<span class="glyphicon glyphicon-trash notclickable"></span>
									</a>
								</td>';	
							*/	
						echo '</tr>';
						$count++;
					}
					?>
				</tbody>

			</table>
		</div>
	</div>
</div>
<!--<div class="text-left"><?php #echo $pagination; ?></div>-->