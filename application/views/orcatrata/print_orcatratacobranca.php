<?php if (isset($msg)) echo $msg; ?>

<?php echo validation_errors(); ?>
<div class="col-md-3"></div>	
<div class="col-md-6">	
	<!--
	<nav class="navbar navbar-inverse navbar-fixed" role="banner">
	  <div class="container-fluid">
		<div class="navbar-header">
			<div class="btn-line " role="group" aria-label="...">	
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<a type="button" class="btn btn-md btn-default " href="javascript:window.print()">
					<span class="glyphicon glyphicon-print"></span>
				</a>
				
				<a type="button" class="btn btn-md btn-warning"  href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
					<span class="glyphicon glyphicon-pencil"></span> Versão Lista
				</a>
				
			</div>
		</div>
	  </div>
	</nav>
	-->
	<nav class="navbar navbar-inverse navbar-fixed" role="banner">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<div class="btn-menu-print btn-group">
					<a type="button" class="col-md-3 btn btn-md btn-default " href="javascript:window.print()">
						<span class="glyphicon glyphicon-print"></span>
					</a>
					<a type="button" class="col-md-9 btn btn-md btn-warning "  href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
						<span class="glyphicon glyphicon-pencil"></span> Versão Lista
					</a>
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-left">
				<label></label>
				<a href="<?php echo base_url() . 'gerar_excel/Receitas/Parcelas_xls.php'; ?>">
					<button type='button' class='btn-paginacao btn btn-md btn-success btn-block'>
						Excel
					</button>
				</a>
			</div>
			<div class="btn-paginacao collapse navbar-collapse" id="myNavbar">
				<?php echo $pagination; ?>
			</div>
		</div>
	</nav>	
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
																				. '<br><br>Recebedor:<br><strong>'  . $orcatrata[$i]['NomeRec'] . '</strong>'
																			?></td>
							<td class="col-md-1 text-center" scope="col"><?php echo 'Orçamento:<br><strong>' . $orcatrata[$i]['idApp_OrcaTrata'] . '</strong>'
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
																				. '<br><br>Recebedor:<br><strong>'  . $orcatrata[$i]['NomeRec'] . '</strong>'
																			?></td>
							<td class="col-md-1 text-center" scope="col"><?php echo 'Orçamento:<br><strong>' . $orcatrata[$i]['idApp_OrcaTrata'] . '</strong>'
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
		<h3 class="text-center">Nenhum Orçamento Filtrado!</h3>
	<?php } ?>		

</div>	