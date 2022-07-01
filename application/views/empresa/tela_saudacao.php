<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['QueryEmpresa']) && isset($_SESSION['Saudacao'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php #if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<div class="panel panel-primary">
							<div class="panel-heading">
									<?php echo $titulo; ?>
							</div>
							<div class="panel-body">
								<div style="overflow: auto; height: auto; ">
									<div class="panel panel-info">
										<div class="panel-heading">
											<div class="form-group">	
												<div class="row">
													<div class=" col-md-6">	
														<div class="row">	
															<div class="col-sm-offset-2 col-md-10 " align="left"> 	
																	<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['QueryEmpresa']['Arquivo'] . ''; ?>"
																	class="img-circle img-responsive" width='200'>
															</div>
														</div>		
													</div>
												</div>
												<h3>Agendamento</h3>
												<div class="row">	
													<div class=" col-md-12">							
														<table class="table table-user-information">
															<tbody>
																<tr>
																	<td>
																		<span class="glyphicon glyphicon-pencil"></span>
																		<?php echo $saudacao['TextoAgenda_1']; ?>
																		<?php if($saudacao['ClienteAgenda'] == "S") echo '<b>Nome do Cliente</b>'; ?>
																		<?php echo $saudacao['TextoAgenda_2']; ?>
																		<?php if($saudacao['ProfAgenda'] == "S") echo '<b>Nome do Profissional</b>'; ?>
																		<?php echo $saudacao['TextoAgenda_3']; ?>
																		<?php if($saudacao['DataAgenda'] == "S") echo '<b>Data & Hora</b>'; ?>
																		<?php echo $saudacao['TextoAgenda_4']; ?>
																		<?php if($saudacao['SiteAgenda'] == "S") echo '<b>Site da Empresa</b>'; ?>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<h3>Pedido</h3>
												<div class="row">	
													<div class=" col-md-12">							
														<table class="table table-user-information">
															<tbody>
																<tr>
																	<td>
																		<span class="glyphicon glyphicon-pencil"></span>
																		<?php echo $saudacao['TextoPedido_1']; ?>
																		<?php if($saudacao['ClientePedido'] == "S") echo '<b>Nome do Cliente</b>'; ?>
																		<?php echo $saudacao['TextoPedido_2']; ?>
																		<?php if($saudacao['idClientePedido'] == "S") echo '<b>N do Cliente</b>'; ?>
																		<?php echo $saudacao['TextoPedido_3']; ?>
																		<?php if($saudacao['idPedido'] == "S") echo '<b>N do Pedido</b>'; ?>
																		<?php echo $saudacao['TextoPedido_4']; ?>
																		<?php if($saudacao['SitePedido'] == "S") echo '<b>Site da Empresa</b>'; ?>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>		
											<div class="row">
												<div class="col-md-12">
													<div class="panel panel-primary">
														<div class="panel-heading">
															<div class="btn-group">
																<a type="button" class="btn btn-sm btn-default" href="<?php echo base_url() . 'empresa/alterarsaudacao/' . $_SESSION['QueryEmpresa']['idSis_Empresa']; ?>">
																	<span class="glyphicon glyphicon-edit"></span> Editar Saudacoes
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>						
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
