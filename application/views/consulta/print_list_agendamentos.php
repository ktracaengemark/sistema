<?php if (isset($msg)) echo $msg; ?>

<?php echo validation_errors(); ?>
<div class="col-md-12">	
	<nav class="navbar navbar-inverse navbar-fixed" role="banner">
		<!--
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
				</div>
			</div>
		</div>
		-->
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<div class="navbar-brand btn-group">
					<a type="button" class="col-md-3 btn btn-md btn-default " href="javascript:window.print()">
						<span class="glyphicon glyphicon-print"></span>
					</a>
					<a type="button" class="col-md-9 btn btn-md btn-warning "  href="<?php echo base_url() ?>relatorio/list_agendamentos">
						<span class="glyphicon glyphicon-pencil"></span> Agendamentos
					</a>
				</div>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<?php echo $pagination; ?>
			</div>
		</div>
	</nav>	
	<?php if( isset($count['POCount']) ) { ?>
		<div style="overflow: auto; height: auto; ">
			<table class="  table-condensed table-striped">
				<thead>
					<tr>
						<td class="col-md-1" scope="col">
							<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='50'>
						</td>
						<td class="col-md-3 text-left" scope="col">
							<?php 
								echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>  "' . $titulo . '"'
							?>
						</td>
						<!--
							<td class="col-md-1 text-left" scope="col">
							<?php 
								echo 'Vencimento De: <strong>'  . $Imprimir['DataInicio'] . '</strong> '
								. ', À: <strong>'  . $Imprimir['DataFim'] . '</strong>'
							?>
							</td>
						-->
					</tr>
				</thead>
				</table>
			<table class="table table-bordered table-condensed table-striped">	
				<thead>
					<tr>
						<th class="col-md-1" scope="col"><?php echo $total_rows;?> Eventos</th>
						<th class="col-md-2" scope="col">Cliente</th>
						<th class="col-md-1" scope="col">Data</th>
						<th class="col-md-1" scope="col">Hora</th>
						<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
							<th class="col-md-5" scope="col">Pet</th>
						<?php } ?>
						<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
							<th class="col-md-5" scope="col">Dep</th>
						<?php } ?>		
						<th class="col-md-2" scope="col">Evento</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$linha =  $per_page*$pagina;
						for ($i=1; $i <= $count['POCount']; $i++) { 
							$contagem = ($linha + $i);
						?>
						<tr>
							<td class="col-md-1" scope="col"><?php echo $contagem ?> - <?php echo $consulta[$i]['idApp_Consulta'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $consulta[$i]['NomeCliente'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $consulta[$i]['DataInicio'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $consulta[$i]['HoraInicio'] ?> / <?php echo $consulta[$i]['HoraFim'] ?></td>
							<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
								<td class="col-md-5" scope="col">
									<?php echo $consulta[$i]['NomeClientePet'] ?>/ Especie: <?php echo $consulta[$i]['Especie'] ?>/ Raca: <?php echo $consulta[$i]['RacaPet'] ?>/ Gen: <?php echo $consulta[$i]['Sexo'] ?>/ 
									Pelo: <?php echo $consulta[$i]['Pelo'] ?>/ Porte: <?php echo $consulta[$i]['Porte'] ?>/ Alrg: <?php echo $consulta[$i]['Alergico'] ?>/ Obs: <?php echo $consulta[$i]['ObsPet'] ?>
								</td>
							<?php } ?>
							<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
								<td class="col-md-5" scope="col">
									<?php echo $consulta[$i]['NomeClientePet'] ?>
								</td>
							<?php } ?>	
							<td class="col-md-2" scope="col"><?php echo $consulta[$i]['Obs'] ?></td>
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