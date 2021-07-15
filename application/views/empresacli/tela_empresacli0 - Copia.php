<?php if ($msg) echo $msg; ?>
<section id="banner" class="img-responsive">
	<div class="bg-color">
		<nav class="navbar navbar-inverse navbar-fixed-top header-menu">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>					
					<a class="navbar-brand" href="<?php echo base_url() ?>../enkontraki/index.php"><img src="<?php echo base_url() ?>/arquivos/imagens/Logo_Navegador.png"></a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/contato.php">Fale Conosco</a>
						</li>
						<!--
						<li class="nav-item">
							<a class="nav-link" href="#cta-1">Planos</a>
						</li>
						-->
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() . '../enkontraki';?>">Site</a>
						</li>
					</ul>
				</div>		
			</div>
		</nav>
				
		<div class="container">
			<div class="row">
				<div class="banner-info">
					<!--
					<div data-interval="3000" id="carouselSite" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#carouselSite" data-slide-to="0" class="active"></li>
							<li data-target="#carouselSite" data-slide-to="1"></li>
							<li data-target="#carouselSite" data-slide-to="2"></li>
							<li data-target="#carouselSite" data-slide-to="3"></li>
							<li data-target="#carouselSite" data-slide-to="4"></li>				
						</ol>
						<div class="carousel-inner" role="listbox">
							<div class="item active">
								<img src="<?php echo base_url() ?>/arquivos/imagens/Slide1.jpg" class="img-responsive d-block">												
							</div>
							<div class="item">
								<img src="<?php echo base_url() ?>/arquivos/imagens/Slide2.jpg" class="img-responsive d-block">												
							</div>
							<div class="item">
								<img src="<?php echo base_url() ?>/arquivos/imagens/Slide3.jpg" class="img-responsive d-block">												
							</div>
							<div class="item">
								<img src="<?php echo base_url() ?>/arquivos/imagens/Slide4.jpg" class="img-responsive d-block">												
							</div>
							<div class="item">
								<img src="<?php echo base_url() ?>/arquivos/imagens/Slide5.jpg" class="img-responsive d-block">												
							</div>
						</div>
					</div>
					-->
					<div class="col-md-12 col-sm-12 col-xs-12 text-center img-responsive">	
						<center>
							<figure>
								<div class="boxVideo">
									<a  href="<?php echo base_url() ?>../enkontraki" role="button">
										<img class="img-responsive" src="<?php echo base_url() . 'arquivos/imagens/Logo_Navegador.png'; ?>" >
									</a>
								</div>
							</figure>
						</center>	
					</div>
					<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>

					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="panel panel-default">
									<!--
									<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header bg-danger">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title">"Para enviar uma Mensagem,<br>
																			Você precisa estar logado em uma Conta!"</h4>
												</div>
												<div class="modal-footer">
													<div class="form-group col-md-6 text-left">
															<div class="form-footer ">
																<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
																	<span class="glyphicon glyphicon-remove"></span> Fechar
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
									-->
									
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
											<div class="form-group col-md-6 text-center">
												<div class="form-footer">		
													<a type="button" class="btn btn-success btn-xs " href="<?php echo base_url() ?>login/index4" role="button">
														<h4><span class="glyphicon glyphicon-log-in"></span> Acessar Empresa</h4>
													</a>
												</div>	
											</div>
											<div class="col-md-6 text-center">
												<!--<label for="">Empresa:</label>-->
												<div class="form-group">
													<div class="row">							
														<!--<a href="https://www.enkontraki.com/<?php #echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">-->
														<a href="https://www.enkontraki.com.br/<?php echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">
															<button type="button" class="btn btn-info btn-xs">
																<h4><span class="glyphicon glyphicon-picture"></span> Acesse o Site</h4>
															</button>
														</a>
													</div>
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
					
					<div class=" col-md-12 col-sm-12 col-xs-12 banner-text text-center ">
						<div class="row">
							<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group text-center">
								<h3 class="white">Empresas</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group text-center">
								<a  type="button" class="btn btn-sm btn-warning btn-block text-left" href="<?php echo base_url() ?>pesquisar/empresas" role="button" > 
									 Pesquisar!
								</a>											
							</div>
							<div class=" col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group text-center">
								<a  type="button" class="btn btn-sm btn-danger btn-block text-left" href="<?php echo base_url() ?>loginempresa/registrar" role="button" > 
									 Cadastrar!
								</a>											
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group text-center">
								<a  type="button" class="btn btn-sm btn-info btn-block text-left" href="<?php echo base_url() ?>login/index2" role="button" > 
									 Acessar!
								</a>											
							</div>	
						</div>
					</div>
					
				</div>
			</div>
			<!--
			<div class="overlay-detail text-center">
				<a href="#service"><i class="fa fa-angle-down"></i></a>
			</div>
			-->
		</div>
	</div>
</section>