<?php if (isset($msg)) echo $msg; ?>

<?php echo validation_errors(); ?>	
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<nav class="navbar navbar-inverse navbar-fixed" role="banner">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<div class="btn-menu-print btn-group">
					<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
						<a type="button" class="col-md-6 btn btn-md btn-info "  href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
							<span class="glyphicon glyphicon-list"></span> Lista
						</a>
					<?php } ?>
					<a type="button" class="col-md-3 btn btn-md btn-warning "  href="<?php echo base_url() ?>Cobrancas/cobrancas_pag">
						<span class="glyphicon glyphicon-edit"></span>
					</a>
					<a type="button" class="col-md-3 btn btn-md btn-default " href="javascript:window.print()">
						<span class="glyphicon glyphicon-print"></span>
					</a>
				</div>
			</div>
			<div class="btn-paginacao collapse navbar-collapse" id="myNavbar">
				<?php echo $pagination; ?>
			</div>
		</div>
	</nav>
</div>	
<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3  col-lg-6">	
	<?php if( isset($count['POCount']) ) { ?>	
		<?php 
			$linha =  $per_page*$pagina;
			for ($i=1; $i <= $count['POCount']; $i++) {
				$contagem = ($linha + $i);
		?>
			<div style="overflow: auto; height: auto; ">
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'>
																						
																						</td>
							<td class="col-md-3 text-left" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>'
																				. '<br><br><strong>' . $orcatrata[$i]['NomeCliente'] . '</strong> - ' . $orcatrata[$i]['idApp_Cliente'] . ''
																				. '<br>' . $orcatrata[$i]['EnderecoCliente'] . ' - ' . $orcatrata[$i]['NumeroCliente'] . ''
																				. '<br>' . $orcatrata[$i]['ComplementoCliente'] . ' - ' . $orcatrata[$i]['BairroCliente'] . ' - ' . $orcatrata[$i]['CidadeCliente'] . ' - ' . $orcatrata[$i]['EstadoCliente'] . '<br>' . $orcatrata[$i]['ReferenciaCliente'] . ''
																				. '<br>Tel.:' . $orcatrata[$i]['CelularCliente'] . ' / ' . $orcatrata[$i]['Telefone'] . ' / ' . $orcatrata[$i]['Telefone2'] . ' / ' . $orcatrata[$i]['Telefone3'] . ''
																		?></td>
							<td class="col-md-1 text-center" scope="col"><?php echo 'Data:<br><strong>'  . $orcatrata[$i]['DataOrca'] . '</strong>'
																				. '<br>Recebedor:<br><strong>'  . $orcatrata[$i]['NomeRec'] . '</strong>'
																				. '<br>Obs:<br><strong>'  . $orcatrata[$i]['Descricao'] . '</strong>'
																			?></td>
							<td class="col-md-1 text-center" scope="col"><?php echo 'Or�amento:<br><strong>' . $orcatrata[$i]['idApp_OrcaTrata'] . '</strong>'
																				. '<br><br>Valor Total:'
																				. '<br>R$: <strong>'  . $orcatrata[$i]['ValorFinalOrca'] . '</strong>'
																				. '<br><br>Via da Empresa: <strong>'  . $contagem . '/' . $total_rows . '</strong>'
																			?></td>
						</tr>
					</thead>
					<thead>
						<tr>
							<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'>
																						
																						</td>
							<td class="col-md-3 text-left" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>'
																				. '<br><br><strong>' . $orcatrata[$i]['NomeCliente'] . '</strong> - ' . $orcatrata[$i]['idApp_Cliente'] . ''
																				. '<br>' . $orcatrata[$i]['EnderecoCliente'] . ' - ' . $orcatrata[$i]['NumeroCliente'] . ''
																				. '<br>' . $orcatrata[$i]['ComplementoCliente'] . ' - ' . $orcatrata[$i]['BairroCliente'] . ' - ' . $orcatrata[$i]['CidadeCliente'] . ' - ' . $orcatrata[$i]['EstadoCliente'] . '<br>' . $orcatrata[$i]['ReferenciaCliente'] . ''
																				. '<br>Tel.:' . $orcatrata[$i]['CelularCliente'] . ' / ' . $orcatrata[$i]['Telefone'] . ' / ' . $orcatrata[$i]['Telefone2'] . ' / ' . $orcatrata[$i]['Telefone3'] . ''
																		?></td>
							<td class="col-md-1 text-center" scope="col"><?php echo 'Data:<br><strong>'  . $orcatrata[$i]['DataOrca'] . '</strong>'
																				. '<br>Recebedor:<br><strong>'  . $orcatrata[$i]['NomeRec'] . '</strong>'
																				. '<br>Obs:<br><strong>'  . $orcatrata[$i]['Descricao'] . '</strong>'
																			?></td>
							<td class="col-md-1 text-center" scope="col"><?php echo 'Or�amento:<br><strong>' . $orcatrata[$i]['idApp_OrcaTrata'] . '</strong>'
																				. '<br><br>Valor Total:'
																				. '<br>R$: <strong>'  . $orcatrata[$i]['ValorFinalOrca'] . '</strong>'
																				. '<br><br>Via do Cliente'
																			?></td>
						</tr>
					</thead>
					
						<thead>
							<tr>
								<th class="col-md-1" scope="col">Qtd</th>
								<th class="col-md-3" scope="col">Produto</th>							
								<th class="col-md-1" scope="col">R$</th>
								<th class="col-md-1" scope="col">Ent?</th>
							</tr>
						</thead>
						
						<tbody>
							<?php if( isset($count['PCount'][$i]) ) { ?>
								<?php for ($k=1; $k <= $count['PCount'][$i]; $k++) { ?>
										<tr>
											<td class="col-md-1" scope="col"><?php echo $produto[$i][$k]['Qtd_Prod'] ?></td>
											<td class="col-md-3" scope="col"><?php echo $produto[$i][$k]['NomeProduto'] ?></td>
											<td class="col-md-1" scope="col"><?php echo $produto[$i][$k]['SubtotalProduto'] ?></td>
											<td class="col-md-1" scope="col"><?php echo $produto[$i][$k]['ConcluidoProduto'] ?></td>										
										</tr>
								<?php } ?>					
							<?php } else { ?>
								<tr>
									<td class="col-md-1" scope="col"></td>
									<td class="col-md-3" scope="col"></td>
									<td class="col-md-1" scope="col"></td>
									<td class="col-md-1" scope="col"></td>										
								</tr>
							<?php } ?>

						</tbody>

					
						<thead>
							<tr>
								<th class="col-md-1" scope="col">Parcela</th>
								<th class="col-md-3" scope="col">FormaPag || Venc. || Dt.Pago</th>
								<th class="col-md-1" scope="col">R$</th>
								<th class="col-md-1" scope="col">Pago?</th>										
							</tr>
						</thead>
						
						<tbody>
							<?php if( isset($count['PRCount'][$i]) ) { ?>
								<?php 
								for ($j=1; $j <= $count['PRCount'][$i]; $j++){ 
								?>
									
									<tr>
										<td class="col-md-1" scope="col"><?php echo $parcelasrec[$i][$j]['Parcela'] ?></td>
										<td class="col-md-3" scope="col"><?php echo $parcelasrec[$i][$j]['FormaPag'] ?> || <?php echo $parcelasrec[$i][$j]['DataVencimento'] ?> || <?php echo $parcelasrec[$i][$j]['DataPago'] ?></td>
										<td class="col-md-1" scope="col"><?php echo number_format($parcelasrec[$i][$j]['ValorParcela'], 2, ',', '.') ?></td>
										<td class="col-md-1" scope="col"><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$i][$j]['Quitado'], 'NS') ?></td>									
									</tr>
									
								<?php
								}
								?>					
							<?php } else { ?>
							
									<tr>
										<td class="col-md-1" scope="col"></td>
										<td class="col-md-3" scope="col"></td>
										<td class="col-md-1" scope="col"></td>
										<td class="col-md-1" scope="col"></td>									
									</tr>
							<?php } ?>
						</tbody>
					
				</table>
				
			</div>
		<?php } ?>
	<?php } else {?>
		<h3 class="text-center">Nenhum Or�amento Filtrado!</h3>
	<?php } ?>		

</div>	