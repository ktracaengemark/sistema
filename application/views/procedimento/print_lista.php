<?php if (isset($msg)) echo $msg; ?>

<?php echo validation_errors(); ?>
<div class="col-md-1"></div>
<div class="col-md-10">	
	<nav class="navbar navbar-inverse navbar-fixed" role="banner">
	  <div class="container-fluid">
		<div class="navbar-header">
			<div class="btn-line " role="group" aria-label="...">	
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<div class="navbar-form btn-group">
					<a type="button" class="btn btn-md btn-default " href="javascript:window.print()">
						<span class="glyphicon glyphicon-print"></span>
					</a>
				</div>
				<!--
				<div class="navbar-form btn-group">
					<a type="button" class="btn btn-md btn-warning"  href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
						<span class="glyphicon glyphicon-pencil"></span> Versão Lista
					</a>
				</div>
				-->
			</div>
		</div>
	  </div>
	</nav>	
	<?php if( isset($count['POCount']) ) { ?>	
		<?php for ($i=1; $i <= $count['POCount']; $i++) { ?>
			<div style="overflow: auto; height: auto; ">
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<td class="col-md-3 text-left bg-<?php echo $panel; ?>" scope="col"><?php echo 'cont.: <strong>'  . $i . '/' . $count['POCount'] . '</strong> - 
																											' . $titulo . ': <strong>' . $procedimento[$i]['idApp_Procedimento'] . '</strong> - 
																											Tipo: <strong>'  . $procedimento[$i][$titulo] . '</strong>
																											<br>Quem Cad.: <strong>'  . $procedimento[$i]['NomeUsuario'] . '</strong> 
																											<br>Quem Fazer: <strong>'  . $procedimento[$i]['NomeCompartilhar'] . '</strong>'
																								?></td>
							<td class="col-md-3 text-left bg-<?php echo $panel; ?>" scope="col"><?php echo 'Cliente: <strong>' . $procedimento[$i]['NomeCliente'] . '</strong> - ' . $procedimento[$i]['idApp_Cliente'] . '
																											<br><strong>Relato:</strong> ' . $procedimento[$i]['Procedimento'] . ''
																								?></td>
							<td class="col-md-1 text-center bg-<?php echo $panel; ?>" scope="col"><?php echo 'Data: <strong>'  . $procedimento[$i]['DataProcedimento'] . '</strong>
																											 <br>Hora: <strong>'  . $procedimento[$i]['HoraProcedimento'] . '</strong>
																											 <br>Concl.: <strong>'  . $procedimento[$i]['ConcluidoProcedimento'] . '</strong>'
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
								if($procedimento[$i]['idApp_Procedimento'] == $subprocedimento[$j]['idApp_Procedimento']){
							?>
								<tr>
									<td class="col-md-3" scope="col"><?php echo $subprocedimento[$j]['SubProcedimento'] ?></td>
									<td class="col-md-3" scope="col"><?php echo $subprocedimento[$j]['DataSubProcedimento'] ?> - <?php echo $subprocedimento[$j]['HoraSubProcedimento'] ?></td>
									<td class="col-md-1" scope="col"><?php echo $subprocedimento[$j]['ConcluidoSubProcedimento'] ?></td>									
									
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