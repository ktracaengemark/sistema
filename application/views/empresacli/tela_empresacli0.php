<?php if ($msg) echo $msg; ?>
<section id="banner" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="bg-color">	
		<div class="banner-info">		
			<div class="row">
				<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>
					<div class="col-lg-offset-2 col-lg-8  col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-12">
						<div class="panel panel-primary">
							<div style="overflow: auto; height: auto; ">
								<div class="panel-body">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 " align="left"> 
										<img alt="User Pic" src="<?php echo base_url() . '../'.$query['Site'].'/' . $query['idSis_Empresa'] . '/documentos/miniatura/' . $query['Arquivo'] . ''; ?> " class="img-circle img-responsive" width='100'>
									</div>
									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 ">					
										<h4><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong> - <strong>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</strong>' ?></h4>
									</div>
									<div class=" col-md-12"> 
										<table class="table table-user-information">
											<tbody>
												
												<?php 
												
												if ($query['NomeEmpresa']) {
													
												echo ' 
												<tr>
													<td><span class="glyphicon glyphicon-home"></span> Empresa:</td>
													<td>' . $query['NomeEmpresa'] . '</td>
												</tr>  
												';
												
												}
												
												if ($query['CelularAdmin']) {
													
												echo '                                                 
												<tr>
													<td><span class="glyphicon glyphicon-phone-alt"></span> Telefone:</td>
													<td>' . $query['CelularAdmin'] . '</td>
												</tr>
												';
												
												}
												
												
												if ($query['EnderecoEmpresa'] || $query['BairroEmpresa'] || $query['MunicipioEmpresa']) {
													
												echo '                                                 
												<tr>
													<td><span class="glyphicon glyphicon-home"></span> Endereço:</td>
													<td>' . $query['EnderecoEmpresa'] . ' ' . $query['BairroEmpresa'] . ' ' . $query['MunicipioEmpresa'] . '</td>
												</tr>
												';
												
												}
												
												if ($query['Email']) {
													
												echo '                                                 
												<tr>
													<td><span class="glyphicon glyphicon-envelope"></span> E-mail:</td>
													<td>' . $query['Email'] . '</td>
												</tr>
												';
												
												}
												
												?>
												
											</tbody>
										</table>
									</div>
									<div class="col-md-12">
										<div class="row">
											<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">		
												<a type="button" class="btn btn-success btn-xs btn-block" href="<?php echo base_url() ?>login/index4" role="button">
													<span class="glyphicon glyphicon-log-in"></span> Empresa
												</a>	
											</div>
											<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
												<a type="button" class="btn btn-info btn-xs btn-block" href="https://www.enkontraki.com.br/<?php echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">
													<span class="glyphicon glyphicon-picture"></span> Site
												</a>
											</div>
										</div>	
										<!--
										<div class="col-md-6 text-center">
											<div class="form-group">
												<div class="row">							
													<button  class="btn btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
														<h3><span class="glyphicon glyphicon-comment"></span> Fale Conosco</h3>
													</button>
												</div>
											</div>	
										</div>
										<div class="col-md-4 text-left">
											<div class="form-group">
												<div class="row">							
													<a href="https://www.ktracaengenharia.com.br/<?php echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">
														<button type="button" class="btn btn-success">
															<strong>Fale Conosco2</strong>
															<h4>  <?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>' ?> </h4>
														</button>
													</a>
												</div>
											</div>	
										</div>
										-->
									</div>	

								</div>
							</div>
						</div>
					</div>
				<?php } ?>				
			</div>
		</div>
	</div>
</section>