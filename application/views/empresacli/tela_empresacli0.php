<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>

<div class="container-fluid">
	<div class="row">
			
		<div class="col-md-offset-3 col-md-6">

			<div class="panel panel-primary">

				<div class="panel-heading">					
					<h4><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong> - <strong>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</strong>' ?></h4>
					<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>pesquisar/empresas" role="button">
						<span class="glyphicon glyphicon-search"></span> Empresas
					</a>
				</div>
				<div class="panel-body">
					<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header bg-danger">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">"Para enviar uma Mensagem,<br>
															Você precisa estar logado em uma Conta!"</h4>
								</div>
								<!--
								<div class="modal-body">
									<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema. 
										Esta operação é irreversível.</p>
								</div>
								-->
								<div class="modal-footer">
									<div class="form-group col-md-6 text-left">
											<div class="form-footer ">
												<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
													<span class="glyphicon glyphicon-remove"> Fechar
												</button>
											</div>
										</div>
									<div class="form-group col-md-6 text-right">
										<div class="form-footer">		
											<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>login/index4" role="button">
												<span class="glyphicon glyphicon-plus"></span> Acessar sua Conta
											</a>
										</div>	
									</div>
								</div>
							</div>
						</div>
					</div>					
					<div style="overflow: auto; height: 400px; ">
						<div class="form-group">
							<div class="form-group">	
								<div class="row">
									<div class="col-sm-offset-1 col-lg-4 " align="left"> 
										<img alt="User Pic" src="<?php echo base_url() . '../'.$query['Site'].'/' . $query['idSis_Empresa'] . '/documentos/miniatura/' . $query['Arquivo'] . ''; ?> " class="img-circle img-responsive" width='200'>
									</div>
									<div class=" col-md-6"> 
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
 
								</div>
							</div>	
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-6 text-center">
										<!--<label for="">Empresa:</label>-->
										<div class="form-group">
											<div class="row">							
												<!--<a href="https://www.enkontraki.com/<?php #echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">-->
												<a href="https://www.enkontraki.com.br/<?php echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">
													<button type="button" class="btn btn-info">
														<h4><span class="glyphicon glyphicon-picture"></span> Acesse o Site</h4>
													</button>
												</a>
											</div>
										</div>	
									</div>
									<div class="form-group col-md-6 text-center">
										<div class="form-footer">		
											<a type="button" class="btn btn-success " href="<?php echo base_url() ?>login/index4" role="button">
												<h4><span class="glyphicon glyphicon-log-in"></span> Acessar Empresa</h4>
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
			</div>
		</div>

	</div>
</div>
<?php } ?>