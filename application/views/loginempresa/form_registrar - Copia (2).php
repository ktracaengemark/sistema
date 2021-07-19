<?php if (isset($msg)) echo $msg; ?>	
<section id="banner" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="bg-color">
		<nav class="navbar navbar-inverse navbar-fixed-top navbar-menu">
			
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>					
					<a class="navbar-brand navbar-logo" href="<?php echo base_url() ?>../enkontraki/index.php"><img src="<?php echo base_url() ?>/arquivos/imagens/Logo_Navegador.png"></a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right navbar-fonte">
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() . '../enkontraki/#banner';?>">Enkontraki</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#about">A Plataforma</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#cta-1">Planos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#testimonial">Depoimentos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#dicas">Dicas</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#contact">Fale Conosco</a>
						</li>
					</ul>
				</div>		
			
		</nav>
				
		
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
					
						<div class="container-fluid">
							<?php echo form_open('loginempresa/registrar', 'role="form"'); ?>
							<div class="container col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12">
								<div class="panel-body">	
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<label for="NomeEmpresa" style="color: #FFFFFF">Nome da Empresa:</label>
												<input type="text" class="form-control" id="NomeEmpresa" maxlength="45" 
													   autofocus name="NomeEmpresa" value="<?php echo $query['NomeEmpresa']; ?>">
												<?php echo form_error('NomeEmpresa'); ?>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<label for="Site" style="color: #FFFFFF">Site ( Não colocar ".com.br"):</label>
												<input type="text" class="form-control" id="Site" maxlength="45" 
														name="Site" value="<?php echo $query['Site']; ?>">
												<?php echo form_error('Site'); ?>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<label for="CepEmpresa" style="color: #FFFFFF">Cep da Empresa:</label>
												<input type="text" class="form-control" id="CepEmpresa" maxlength="8" 
														name="CepEmpresa" value="<?php echo $query['CepEmpresa']; ?>">
												<?php echo form_error('CepEmpresa'); ?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<label for="EnderecoEmpresa" style="color: #FFFFFF">Endereço da Empresa:</label>
												<input type="text" class="form-control" id="EnderecoEmpresa" maxlength="45" 
														name="EnderecoEmpresa" value="<?php echo $query['EnderecoEmpresa']; ?>">
												<?php echo form_error('EnderecoEmpresa'); ?>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label for="NumeroEmpresa" style="color: #FFFFFF">Número:</label>
												<input type="text" class="form-control" id="NumeroEmpresa" maxlength="45" 
														name="NumeroEmpresa" value="<?php echo $query['NumeroEmpresa']; ?>">
												<?php echo form_error('NumeroEmpresa'); ?>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label for="ComplementoEmpresa" style="color: #FFFFFF">Complemento:</label>
												<input type="text" class="form-control" id="ComplementoEmpresa" maxlength="45" 
														name="ComplementoEmpresa" value="<?php echo $query['ComplementoEmpresa']; ?>">
												<?php echo form_error('ComplementoEmpresa'); ?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label for="BairroEmpresa" style="color: #FFFFFF">Bairro:</label>
												<input type="text" class="form-control" id="BairroEmpresa" maxlength="45" 
														name="BairroEmpresa" value="<?php echo $query['BairroEmpresa']; ?>">
												<?php echo form_error('BairroEmpresa'); ?>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label for="MunicipioEmpresa" style="color: #FFFFFF">Cidade:</label>
												<input type="text" class="form-control" id="MunicipioEmpresa" maxlength="45" 
														name="MunicipioEmpresa" value="<?php echo $query['MunicipioEmpresa']; ?>">
												<?php echo form_error('MunicipioEmpresa'); ?>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label for="EstadoEmpresa" style="color: #FFFFFF">Estado:</label>
												<input type="text" class="form-control" id="EstadoEmpresa" maxlength="45" 
														name="EstadoEmpresa" value="<?php echo $query['EstadoEmpresa']; ?>">
												<?php echo form_error('EstadoEmpresa'); ?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label class="text-" style="color: #FFFFFF">E-mail:</label>
												<input type="text" class="form-control" id="Email" maxlength="100"
													   name="Email" value="<?php echo $query['Email']; ?>">
												<?php echo form_error('Email'); ?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label for="NomeAdmin" style="color: #FFFFFF">Nome do Admin.:</label>
												<input type="text" class="form-control" id="NomeAdmin" maxlength="255"
													   name="NomeAdmin" value="<?php echo $query['NomeAdmin']; ?>">
												<?php echo form_error('NomeAdmin'); ?>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label for="DataNascimento" style="color: #FFFFFF">Data de Aniver.:</label>
												<input type="text" class="form-control Date" id="inputDate0" maxlength="10"
													   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
												<?php echo form_error('DataNascimento'); ?>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label for="CpfAdmin" style="color: #FFFFFF">CPF do Administrador:</label>
												<input type="text" class="form-control " id="CpfAdmin" maxlength="11"
													   name="CpfAdmin" placeholder="99999999999" value="<?php echo $query['CpfAdmin']; ?>">
												<?php echo form_error('CpfAdmin'); ?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label for="CelularAdmin" style="color: #FFFFFF">Celular / (Login):</label>
												<input type="text" class="form-control Celular Celular" id="CelularAdmin" maxlength="11"
													   name="CelularAdmin" placeholder="(XX)999999999" value="<?php echo $query['CelularAdmin']; ?>">
												<?php echo form_error('CelularAdmin'); ?>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label  style="color: #FFFFFF">Digite uma Senha</label>
												<!--<input type="password" name="senha" placeholder="Digite a senha" class="form-control"><br>-->
												<div class="input-group">
													<input type="password" name="Senha" id="Senha" placeholder="Digite uma senha" class="form-control btn-sm " value="<?php echo $query['Senha']; ?>"><br>
													<span class="input-group-btn">
														<button class="btn btn-info btn-md " type="button" onclick="mostrarSenha()">
															
															<span class="Mostrar glyphicon glyphicon-eye-open"></span>
															
															<span class="NMostrar glyphicon glyphicon-eye-close"></span>
															
														</button>
													</span>
												</div>
												<?php echo form_error('Senha'); ?>					
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label  style="color: #FFFFFF">Digite a mesma Senha novamente</label>
												<!--<input type="password" name="senha" placeholder="Digite a senha" class="form-control"><br>-->
												<div class="input-group">
													<input type="password" name="Confirma" id="Confirma" placeholder="Digite a senha novamente" class="form-control btn-sm " value="<?php echo $query['Confirma']; ?>"><br>
													<span class="input-group-btn">
														<button class="btn btn-info btn-md " type="button" onclick="confirmarSenha()">
															
															<span class="Open glyphicon glyphicon-eye-open"></span>
															
															<span class="Close glyphicon glyphicon-eye-close"></span>
															
														</button>
													</span>
												</div>
												<?php echo form_error('Confirma'); ?>					
											</div>					
											
											<!--
											<div class="col-md-4">
												<label for="Senha">Senha:</label>
												<input type="password" class="form-control" id="Senha" maxlength="45"
													   name="Senha" value="<?php echo $query['Senha']; ?>">
												<?php echo form_error('Senha'); ?>
											</div>
											
											<div class="col-md-4">
												<label for="Senha">Confirmar Senha:</label>
												<input type="password" class="form-control" id="Confirma" maxlength="45"
													   name="Confirma" value="<?php echo $query['Confirma']; ?>">
												<?php echo form_error('Confirma'); ?>
											</div>
											-->
										</div>
									</div>
									<div class="form-group">
										<div class="row">
												<!--
												<button class="btn btn-lg btn-warning btn-block" type="submit">REGISTRAR</button>
												<br>
												-->
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<br>
												<button  class="btn btn-md btn-success btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
													<span class="glyphicon glyphicon-floppy-saved"></span> Registrar
												</button>
											</div>	
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<br>
												<a class="btn btn-md btn-danger btn-block" href="<?php echo base_url(); ?>../enkontraki" role="button">
													<span class="glyphicon glyphicon-floppy-remove"></span>	Cancelar
												</a>
												<!--
												<a class="btn btn btn-primary btn-block" href="<?php echo base_url(); ?>login/index" role="button">Acesso dos Usuários</a>
												<a class="btn btn btn-warning btn-block" href="<?php echo base_url(); ?>loginempresa/index" role="button">Acesso dos Administradores</a>
												-->
											</div>	
										</div>	
									</div>
								</div>	
							</div>
							<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header bg-danger">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title">Ao "Confirmar Registro",<br>
																	Você concorda com a nossa Política de Privacidade!</h4>
										</div>
										
										<div class="modal-body">
											<p>Política de Privacidade.....</p>
										</div>
										
										<div class="modal-footer">
											<div class="form-group col-md-4 text-left">
												<div class="form-footer">
													<button  class="btn btn-success btn-block" type="submit">
														<span class="glyphicon glyphicon-floppy-saved"></span> Confirmar Registro
													</button>
												</div>
											</div>
											<div class="form-group col-md-4 text-left">
												<div class="form-footer ">
													<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
														<span class="glyphicon glyphicon-remove"> Fechar
													</button>
												</div>
											</div>
											<div class="form-group col-md-4 text-right">
												<div class="form-footer">		
													<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>../enkontraki" role="button">
														<span class="glyphicon glyphicon-floppy-remove"></span> Cancelar
													</a>
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
							<script type="text/javascript">
								$('#ca-container').contentcarousel();
							</script>
							<script>
								function mostrarSenha(){
									var tipo = document.getElementById("Senha");
									if(tipo.type == "password"){
										tipo.type = "text";
										$('.Mostrar').hide();
										$('.NMostrar').show();
									}else{
										tipo.type = "password";
										$('.Mostrar').show();
										$('.NMostrar').hide();
									}
								}
								function confirmarSenha(){
									var tipo = document.getElementById("Confirma");
									if(tipo.type == "password"){
										tipo.type = "text";
										$('.Open').hide();
										$('.Close').show();
									}else{
										tipo.type = "password";
										$('.Open').show();
										$('.Close').hide();
									}
								}
							</script>
						</form>
					
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
</section>