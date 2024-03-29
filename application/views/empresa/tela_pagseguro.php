<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['QueryEmpresa']) && isset($_SESSION['PagSeguro'])) { ?>
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
																<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['QueryEmpresa']['idSis_Empresa']; ?>">	
																	<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['QueryEmpresa']['Arquivo'] . ''; ?>"
																	class="img-circle img-responsive" width='200'>
																</a>
															</div>
														</div>		
													</div>
												</div>
												<h3>Status do PagSeguro</h3>
												<div class="row">	
													<div class=" col-md-12">							
														<table class="table table-user-information">
															<tbody>

																<?php
																
																if ($pagseguro['Ativo_Pagseguro'] == "N") {

																echo '
																<tr>
																	<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-thumbs-down"></span> Ativo_Pagseguro:</td>
																	<td>NAO</td>
																</tr>
																';

																} else if($pagseguro['Ativo_Pagseguro'] == "S"){

																echo '
																<tr>
																	<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-thumbs-up"></span> Ativo_Pagseguro:</td>
																	<td>SIM</td>
																</tr>
																';
																}
																
																if ($pagseguro['Email_Loja']) {

																echo '
																<tr>
																	<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-envelope"></span> Email_Loja:</td>
																	<td>' . $pagseguro['Email_Loja'] . '</td>
																</tr>
																';

																} else {
																
																echo '
																<tr>
																	<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-envelope"></span> Email da Loja:</td>
																	<td>Nao existe E-Mail Cadastrado</td>
																</tr>
																';
																}
																
																if ($pagseguro['Email_Pagseguro']) {

																echo '
																<tr>
																	<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-envelope"></span> Email_Pagseguro:</td>
																	<td>' . $pagseguro['Email_Pagseguro'] . '</td>
																</tr>
																';

																} else {
																
																echo '
																<tr>
																	<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-envelope"></span> Email do PagSeguro:</td>
																	<td>Nao existe E-Mail Cadastrado</td>
																</tr>
																';
																}
																
																if ($pagseguro['Token_Sandbox']) {

																echo '
																<tr>
																	<td><span class="glyphicon glyphicon-pencil"></span> Token_Sandbox:</td>
																	<td>' . $pagseguro['Token_Sandbox'] . '</td>
																</tr>
																';

																} else {
																
																echo '
																<tr>
																	<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-pencil"></span> Token do Sandbox:</td>
																	<td>Nao existe Token do Sandbox Cadastrado</td>
																</tr>
																';
																}

																if ($pagseguro['Prod_PagSeguro'] == "N") {

																echo '
																<tr>
																	<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-thumbs-down"></span> Prod_PagSeguro:</td>
																	<td>NAO</td>
																</tr>
																';

																} else if($pagseguro['Prod_PagSeguro'] == "S"){

																echo '
																<tr>
																	<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-thumbs-up"></span> Prod_PagSeguro:</td>
																	<td>SIM</td>
																</tr>
																';
																}
																
																if ($pagseguro['Token_Producao']) {

																echo '
																<tr>
																	<td><span class="glyphicon glyphicon-pencil"></span> Token_Producao:</td>
																	<td>' . $pagseguro['Token_Producao'] . '</td>
																</tr>
																';

																} else {
																
																echo '
																<tr>
																	<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-pencil"></span> Token do PagSeguro:</td>
																	<td>Nao existe Token do PagSeguro Cadastrado</td>
																</tr>
																';
																}

																?>

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
																<a type="button" class="btn btn-sm btn-default" href="<?php echo base_url() . 'empresa/alterarpagseguro/' . $_SESSION['QueryEmpresa']['idSis_Empresa']; ?>">
																	<span class="glyphicon glyphicon-edit"></span> Editar Pag Seguro
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
