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
					<div class="container col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12 text-center">
						<?php echo form_open('login/index1', 'role="form"'); ?>
						<div class="col-md-12 col-sm-12 col-xs-12 text-center">
							<div class="row acabamento text-center">
								<div class="col-md-6 col-sm-6 col-xs-6 "style="color: #000000">			
									
										<span class="glyphicon glyphicon-user"></span> Associado
									
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 ">			
									<a class="" href="<?php echo base_url(); ?>login/index2" role="button"  >
										<span class="glyphicon glyphicon-home"></span> Empresa
									</a>
								</div>	
								<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10  col-xs-12 text-center">
									<label class="sr-only">Empresa</label>
									<select data-placeholder="Selecione uma opção..." class="form-control acabamento2" id="idSis_Empresa" name="idSis_Empresa" readonly="">			
										<!--<option value="">-- Selecione sua Empresa --</option>-->
										<?php
										foreach ($select['idSis_Empresa'] as $key => $row) {
													(!$query['idSis_Empresa']) ? $query['idSis_Empresa'] = '5' : FALSE;	
											if ($query['idSis_Empresa'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>   
									</select> 
									<?php echo form_error('idSis_Empresa'); ?>
								</div>
								<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 text-center">	
									<label class="sr-only">Celular</label>
									<input type="text" id="CelularUsuario" maxlength="11" class="form-control acabamento3" placeholder="Celular Pessoal (xx)999999999" autofocus name="CelularUsuario" value="<?php echo set_value('CelularUsuario'); ?>">	   
									<?php echo form_error('CelularUsuario'); ?>
								</div>
								<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10  col-xs-12 text-center">	
									<label class="sr-only">Senha</label>
									<div class="input-group acabamento3">
										<input type="password" name="Senha" id="inputPassword" placeholder="Digite a sua senha" class="form-control btn-sm " value="">
										<span class="input-group-btn">
											<button class="btn btn-info btn-md " type="button" onclick="mostrarSenha()">
												
												<span class="Mostrar glyphicon glyphicon-eye-open"></span>
												
												<span class="NMostrar glyphicon glyphicon-eye-close"></span>
												
											</button>
										</span>
										<script type="text/javascript">
											//$('#ca-container').contentcarousel();
										</script>
										<script>
											function mostrarSenha(){
												var tipo = document.getElementById("inputPassword");
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
										</script>
									</div>
									<!--<input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">-->
									<?php echo form_error('Senha'); ?>
								</div>	
								<input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
								<div class=" col-md-12 col-sm-12 col-xs-12 center">		
									<button class="btn btn-lg btn-info btn-block acabamento2" type="submit">
										<span class="glyphicon glyphicon-log-in"></span> Acessar
									</button>	
								</div>
								<!--
								<div class=" col-md-6 col-sm-6 col-xs-6 text-center acabamento2">	
									<a class="acabamento2" href="<?php #echo base_url(); ?>pesquisar/empresas" role="button">
										<span class="glyphicon glyphicon-search"></span> Empresas
									</a>
								</div>
								<div class=" col-md-6 col-sm-6 col-xs-6 text-center acabamento2">	
									<a class="acabamento2" href="<?php #echo base_url(); ?>../enkontraki" role="button">
										<span class="glyphicon glyphicon-search"></span> enkontraki
									</a>
								</div>
								-->
									<!--<p><a href="<?php #echo base_url(); ?>login/recuperar/?usuario=<?php #echo set_value('CelularUsuario'); ?>">Esqueci usuário/senha!</a></p>-->

									<!--
									<a class="btn btn-md btn-primary  btn-block" href="<?php #echo base_url(); ?>loginempresa/index" role="button">
										<span class="glyphicon glyphicon-log-in"></span> Acessar Conta Admin. 
									</a>
									
									<br>
									
									<br>
									<a class="btn btn-md btn-success  btn-block" href="<?php #echo base_url(); ?>login/index3" role="button">
										<span class="glyphicon glyphicon-plus"></span> Cadastrar Nova Conta
									</a>
									-->
							</div>
						</div>
					</div>					
					
					
					
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