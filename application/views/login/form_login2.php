<section id="banner" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="bg-color">
		<div class="banner-info">
			<div class="row">
				<?php if (isset($msg)) echo $msg; ?>
				<div class="col-lg-offset-3 col-lg-6  col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12 text-center">
					<?php echo form_open('login/index2', 'role="form"'); ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
						<div class="row acabamento text-center">
							<div class="col-md-6 col-sm-6 col-xs-6 "style="color: #000000">
								<span class="glyphicon glyphicon-home"></span> Empresa
							</div>	
							<div class="col-md-6 col-sm-6 col-xs-6 ">			
								<a class="" href="<?php echo base_url(); ?>login" role="button" >
									<span class="glyphicon glyphicon-user"></span> Associado
								</a>
							</div>	
							<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 text-center">				
								<label class="sr-only">Empresa</label>
								<input type="text" id="idSis_Empresa" class="form-control acabamento2" placeholder=" XXX  'Número da Empresa'" autofocus name="idSis_Empresa" value="<?php echo set_value('idSis_Empresa'); ?>">	   
								<?php echo form_error('idSis_Empresa'); ?>
							</div>
							<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 text-center">	
								<label class="sr-only">Celular</label>
								<input type="text" id="CelularUsuario" maxlength="11" class="form-control acabamento3" placeholder="Celular (xx)999999999" name="CelularUsuario" value="<?php echo set_value('CelularUsuario'); ?>">	   
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
							<div class=" col-md-12 col-sm-12 col-xs-12 center">	
								<p><a href="<?php echo base_url(); ?>login/recuperar">Esqueci usuário/senha!</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>