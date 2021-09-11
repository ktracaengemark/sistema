<?php if (isset($msg)) echo $msg; ?>

<?php echo validation_errors(); ?>
<div class="col-md-2"></div>
<div class="col-md-8">	
	<nav class="navbar navbar-inverse navbar-fixed" role="banner">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<div class="btn-menu-print btn-group">
					<a type="button" class="col-md-4 btn btn-md btn-default " href="javascript:window.print()">
						<span class="glyphicon glyphicon-print"></span>
					</a>
					<a type="button" class="col-md-8 btn btn-md btn-warning "  href="<?php echo base_url() . $form_open_path . $_SESSION['log']['idSis_Empresa'];?>">
						<span class="glyphicon glyphicon-pencil"></span> Baixa
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
			<table class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'></td>
						<td class="col-md-3 text-left" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>'?></td>
						<td class="col-md-3 text-left" scope="col"><?php echo '<strong>' . $titulo . '</strong>'?><br>Total: R$ <?php echo $somatotal?> / <?php echo '<strong>' . $pesquisa_query->soma2->somacomissao2 . '</strong>' ?></td>
					</tr>
				</thead>			
			</table>
			<table class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<th class="col-md-1" scope="col">cont: <?php echo $total_rows;?></th>
						<th class="col-md-1" scope="col">Pedido</th>
						<th class="col-md-1" scope="col">Local</th>
						<th class="col-md-2" scope="col">Nome</th>
						<th class="col-md-1" scope="col">Valor</th>
						<th class="col-md-1" scope="col">Comissao</th>
						<th class="col-md-1" scope="col">Pago</th>
						<th class="col-md-1" scope="col">Data</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$linha =  $per_page*$pagina;
						for ($i=1; $i <= $count['POCount']; $i++) {
							$contagem = ($linha + $i);
						?>
						<tr>
							<td class="col-md-1" scope="col"><?php echo $contagem ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['idApp_OrcaTrata'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['Tipo_Orca'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $orcatrata[$i][$nome] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['ValorRestanteOrca'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['ValorComissao'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i][$status] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['DataPagoComissaoOrca'] ?></td>
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