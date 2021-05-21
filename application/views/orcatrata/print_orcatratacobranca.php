<?php if (isset($msg)) echo $msg; ?>

<?php echo validation_errors(); ?>
<div class="col-md-3"></div>
<div class="col-md-6">	
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
		<!--
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav navbar-center">
				<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						
						<a href="javascript:window.print()">
							<button type="button" class="btn btn-md btn-default ">
								<span class="glyphicon glyphicon-print"></span> Imprimir
							</button>
						</a>
						
					</div>
				</li>
			</ul>
		</div>
		-->
	  </div>
	</nav>	
	<?php if( isset($count['POCount']) ) { ?>	
		<?php for ($i=1; $i <= $count['POCount']; $i++) { ?>
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
																				. '<br>R$: <strong>'  . $orcatrata[$i]['ValorTotalOrca'] . '</strong>'
																				. '<br><br>Via da Empresa: <strong>'  . $i . '/' . $count['POCount'] . '</strong>'
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
																				. '<br>R$: <strong>'  . $orcatrata[$i]['ValorTotalOrca'] . '</strong>'
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

						<?php
						for ($k=1; $k <= $count['PCount']; $k++) {
						?>
						<?php if($orcatrata[$i]['idApp_OrcaTrata'] == $produto[$k]['idApp_OrcaTrata']) { ?>
						<tr>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['Qtd_Prod'] ?></td>
							<td class="col-md-3" scope="col"><?php echo $produto[$k]['NomeProduto'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['SubtotalProduto'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['ConcluidoProduto'] ?></td>										
						</tr>
						<?php
						}
						?>
						
						<?php
						}
						?>

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
					<?php for ($j=1; $j <= $count['PRCount']; $j++) { ?>
						<?php if($orcatrata[$i]['idApp_OrcaTrata'] == $parcelasrec[$j]['idApp_OrcaTrata']) { ?>
						<tr>
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['Parcela'] ?></td>
							<td class="col-md-3" scope="col"><?php echo $parcelasrec[$j]['FormaPag'] ?> || <?php echo $parcelasrec[$j]['DataVencimento'] ?> || <?php echo $parcelasrec[$j]['DataPago'] ?></td>
							<td class="col-md-1" scope="col"><?php echo number_format($parcelasrec[$j]['ValorParcela'], 2, ',', '.') ?></td>
							<td class="col-md-1" scope="col"><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$j]['Quitado'], 'NS') ?></td>									
						</tr>
						<?php } ?>
					<?php } ?>
					</tbody>					
				</table>
				<?php if( isset($count['PCount']) ) { ?>
				<?php } else echo '<h3 class="text-left">S/Produtos Entregues </h3>';{?>
				<?php } ?>
			</div>
		<?php } ?>
	<?php } else echo '<h3 class="text-center">Nenhum Orçamento Filtrado!</h3>';{?>
	<?php } ?>		

</div>	