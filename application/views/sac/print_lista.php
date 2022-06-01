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
					<a type="button" class="col-md-3 btn btn-md btn-default " href="javascript:window.print()">
						<span class="glyphicon glyphicon-print"></span>
					</a>
					<a type="button" class="col-md-3 btn btn-md btn-info">
						<?php echo $total_rows; ?>
					</a>
					<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
						<a type="button" class="col-md-3 btn btn-md btn-warning "  href="<?php echo base_url() . $caminho; ?>">
							<span class="glyphicon glyphicon-filter"></span>
						</a>
					<?php } ?>
					<a type='button' class='col-md-3 btn btn-md btn-success' href="<?php echo base_url() . 'gerar_excel/Sac/Sac_total_xls.php'; ?>">
						<span class="glyphicon glyphicon-print"></span>
					</a>
				</div>
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
							<td class="col-md-3 text-left bg-<?php echo $panel; ?>" scope="col"><?php echo 'cont.: <strong>'  . $contagem . '</strong> - 
								' . $titulo . ': <strong>' . $sac[$i]['idApp_Sac'] . '</strong> - 
								Tipo: <strong>'  . $sac[$i]['Categoria'.$titulo] . '</strong>
								<br>Quem Cad.: <strong>'  . $sac[$i]['NomeUsuario'] . '</strong> 
								<br>Quem Fazer: <strong>'  . $sac[$i]['NomeCompartilhar'] . '</strong>'
							?></td>
							<td class="col-md-3 text-left bg-<?php echo $panel; ?>" scope="col"><?php echo 'Cliente: <strong>' . $sac[$i]['NomeCliente'] . '</strong> - ' . $sac[$i]['idApp_Cliente'] . '
								<br><strong>Relato:</strong> ' . $sac[$i]['Sac'] . ''
							?></td>
							<td class="col-md-1 text-center bg-<?php echo $panel; ?>" scope="col"><?php echo 'Data: <strong>'  . $sac[$i]['DataSac'] . '</strong>
								<br>Hora: <strong>'  . $sac[$i]['HoraSac'] . '</strong>
								<br>Concl.: <strong>'  . $sac[$i]['ConcluidoSac'] . '</strong>'
							?></td>
						</tr>
					</thead>
					<thead>
						<tr>
							<th class="col-md-3" scope="col">Ações</th>
							<th class="col-md-3" scope="col">Data - Hora</th>
							<th class="col-md-1" scope="col">Concl?</th>										
						</tr>
					</thead>
					<tbody>
						<?php if( isset($count['PMCount']) ) { ?>
							<?php for ($j=1; $j <= $count['PMCount']; $j++) { ?>
								<?php 
									if($sac[$i]['idApp_Sac'] == $subsac[$j]['idApp_Sac']){
									?>
									<tr>
										<td class="col-md-3" scope="col"><?php echo $subsac[$j]['SubSac'] ?></td>
										<td class="col-md-3" scope="col"><?php echo $subsac[$j]['DataSubSac'] ?> - <?php echo $subsac[$j]['HoraSubSac'] ?></td>
										<td class="col-md-1" scope="col"><?php echo $subsac[$j]['ConcluidoSubSac'] ?></td>									
										
									</tr>
									<?php 
									}
								?>
							<?php } ?>
							<?php } else echo '<h3 class="text-center">Nenhuma Ação Realizada!</h3>';{?>
						<?php } ?>
					</tbody>					
				</table>
			</div>
		<?php } ?>
		<?php } else echo '<h3 class="text-center">Nenhum Orçamento Filtrado!</h3>';{?>
	<?php } ?>
</div>							