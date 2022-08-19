<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">	
			<?php #if ($nav_secundario) echo $nav_secundario; ?>
			<?php if ($msg) {?>
				<div class="row">
					<div class="col-md-12 ">
						<?php echo $msg; ?>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<div class="col-md-12 ">		
					<?php if ( !isset($evento) && isset($orcatrata)) { ?>
						<?php if ($orcatrata['idApp_OrcaTrata'] != 1 ) { ?>
							<nav class="navbar navbar-inverse navbar-fixed" role="banner">
							  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span> 
									</button>
									<!--
									<a class="navbar-brand" href="<?php #echo base_url() . 'orcatrata/alterardesp/' . $orcatrata['idApp_OrcaTrata']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Despesa										
									</a>
									-->
								</div>
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
							  </div>
							</nav>
						<?php } ?>
					<?php } ?>			
					
					<?php echo validation_errors(); ?>
					<div class="panel panel-danger">
						<div class="panel-heading">
							<table class="table table-condensed table-striped">
								<tbody>
									<tr>
										<td class="col-md-4 text-center" scope="col"><img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='200'></td>
										<td class="col-md-8 text-center" scope="col">
											<h3><?php echo '<strong>' . $orcatrata['NomeEmpresa'] . '</strong>' ?></h3>
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>	
												<h4>CNPJ:<?php echo '<strong>' . $orcatrata['Cnpj'] . '</strong>' ?></h4>
												<h4>Endereço:<?php echo '<small>' . $orcatrata['EnderecoEmpresa'] . '</small> <small>' . $orcatrata['NumeroEmpresa'] . '</small> <small>' . $orcatrata['ComplementoEmpresa'] . '</small><br>
																		<small>' . $orcatrata['BairroEmpresa'] . '</small> - <small>' . $orcatrata['MunicipioEmpresa'] . '</small> - <small>' . $orcatrata['EstadoEmpresa'] . '</small>' ?></h4>
											<?php } ?>	
											<h5>Usuario:<?php 
															if(isset($usuario)){
																$colaborador = $usuario['Nome'];
															}else{
																$colaborador = "O Cliente";
															} echo '<strong>' . $colaborador . '</strong>'
														?>
											</h5>
											<h4 class="text-center">Grupo<?php echo ' - <strong>' . $orcatrata['idApp_OrcaTrata'] . '</strong>' ?> </h4>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="panel-body">
								<h3 class="text-left"><b>Grupo</b><?php echo ' - <strong>' . $orcatrata['idApp_OrcaTrata'] . '</strong>' ?></h3>
								<table class="table table-bordered table-condensed table-striped">
									<thead>
										<tr>
											<th class="col-md-2" scope="col">Tipo</th>
											<th class="col-md-2" scope="col">Data</th>
											<th class="col-md-3" scope="col">Valor</th>
											<th class="col-md-8" scope="col">Desc.</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo $orcatrata['TipoFinanceiro'] ?></td>
											<td><?php echo $orcatrata['DataOrca'] ?></td>
											<td>R$ <?php echo number_format($orcatrata['ValorTotalOrca'], 2, ',', '.') ?></td>
											<td><?php echo $orcatrata['Descricao'] ?></td>
										</tr>
									</tbody>
								</table>	
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>	
</div>