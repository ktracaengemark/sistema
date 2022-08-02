<?php if (isset($msg)) echo $msg; ?>

<?php echo validation_errors(); ?>
<div class="col-md-12">
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
						<a type="button" class="col-md-6 btn btn-md btn-info "  href="<?php echo base_url() . $imprimirrecibo . $_SESSION['log']['idSis_Empresa']; ?>">
							<span class="glyphicon glyphicon-pencil"></span> Recibo
						</a>
					<?php } ?>
					<a type="button" class="col-md-3 btn btn-md btn-default " href="javascript:window.print()">
						<span class="glyphicon glyphicon-print"></span>
					</a>
					<a type="button" class="col-md-3 btn btn-md btn-warning "  href="<?php echo base_url() ?>relatorio/cobrancas_pag">
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				</div>
			</div>
			<div class="btn-paginacao collapse navbar-collapse" id="myNavbar">
				<?php echo $pagination; ?>
			</div>
		</div>
	</nav>
	<?php if( isset($count['POCount']) ) { ?>
		<div style="overflow: auto; height: auto; ">
			<table class="  table-condensed table-striped">
				<thead>
					<tr>
						<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='50'>
							
						</td>
						<td class="col-md-3 text-left" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>  "' . $titulo . '"'
						?></td>
						<td class="col-md-1 text-left" scope="col"><?php echo 'Vencimento De: <strong>'  . $Imprimir['DataInicio4'] . '</strong> '
							. ', À: <strong>'  . $Imprimir['DataFim4'] . '</strong>'
						?></td>
					</tr>
				</thead>
			</table>
			<table class="table table-bordered table-condensed table-striped">	
				<thead>
					<tr>
						<th class="col-md-1" scope="col">cont: <?php echo $total_rows;?> Pedidos</th>
						<th class="col-md-1" scope="col">DtPedido</th>
						<th class="col-md-1" scope="col">DtEntr</th>
						<th class="col-md-1" scope="col">DtVnc</th>
						<th class="col-md-1" scope="col">DtVncPrc</th>
						<th class="col-md-1" scope="col">id</th>
						<th class="col-md-2" scope="col">Cliente</th>
						<th class="col-md-2" scope="col">Tel</th>
						<th class="col-md-1" scope="col">Entr/Pago</th>
						<th class="col-md-1" scope="col">Valor</th>
						<th class="col-md-1" scope="col">Lc/Fr.Pag.</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$linha =  $per_page*$pagina;
						for ($i=1; $i <= $count['POCount']; $i++) { 
							$contagem = ($linha + $i);
						?>
						<tr>
							<td class="col-md-1" scope="col"><?php echo $contagem ?> - <?php echo $orcatrata[$i]['idApp_OrcaTrata'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['DataOrca'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['DataEntregaOrca'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['DataVencimentoOrca'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['DataVencimento'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['idApp_Cliente'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $orcatrata[$i]['NomeCliente'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $orcatrata[$i]['CelularCliente'] ?>
								- <?php echo $orcatrata[$i]['Telefone'] ?>
								- <?php echo $orcatrata[$i]['Telefone2'] ?>
								- <?php echo $orcatrata[$i]['Telefone3'] ?>
							</td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['ConcluidoOrca'] ?> / <?php echo $orcatrata[$i]['QuitadoOrca'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['ValorFinalOrca'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['AVAP'] ?>/<?php echo $orcatrata[$i]['FormaPag'] ?></td>
						</tr>
						
						<?php
						}
					?>
				</tbody>
			</table>
		</div>
	<?php } else echo '<h3 class="text-center">Nenhum Orçamento Filtrado!</h3>';{?>
	<?php } ?>
</div>	