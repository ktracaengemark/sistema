<?php if (isset($msg)) echo $msg; ?>
<div class="container col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12 text-center">
    <?php echo form_open('login/index2', 'role="form"'); ?>
	<!--<h2 class="form-signin-heading text-center">enkontraki</h2>-->		 
	
	<div class="col-md-12 col-sm-12 col-xs-12 text-center img-responsive">	
		<center>
			<figure>
				<div class="boxVideo">
					<img class="img-responsive" src="<?php echo base_url() . 'arquivos/imagens/Logo_Navegador.png'; ?>" >
				</div>
			</figure>
		</center>	
	</div>
	
	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
		<div class="row acabamento text-center">
			<div class="col-md-6 col-sm-6 col-xs-6 "style="color: #000000">			
				
					<span class="glyphicon glyphicon-home"></span> Empresa
				
			</div>	
			<div class="col-md-6 col-sm-6 col-xs-6 ">			
				<a class="" href="<?php echo base_url(); ?>login" role="button" >
					<span class="glyphicon glyphicon-user"></span> Associado
				</a>
			</div>
				<!--
				<label class="sr-only">Empresa</label>
				<select data-placeholder="Selecione uma opção..." class="form-control" id="idSis_Empresa" name="idSis_Empresa">			
					<option value="">Selecione sua Empresa</option>
					<?php
					/*
					foreach ($select['idSis_Empresa'] as $key => $row) {
						if ($query['idSis_Empresa'] == $key) {
							(!$query['idSis_Empresa']) ? $query['idSis_Empresa'] = $_SESSION['Empresa']['idSis_Empresa'] : FALSE;
							echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
						} else {
							echo '<option value="' . $key . '">' . $row . '</option>';
						}
					}
					*/
					?>   
				</select>
				<?php #echo form_error('idSis_Empresa'); ?>
				-->
			<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 text-center">				
				<label class="sr-only">Empresa</label>
				<input type="text" id="idSis_Empresa" class="form-control acabamento2" placeholder=" XXX  'Número da Empresa'" autofocus name="idSis_Empresa" value="<?php echo set_value('idSis_Empresa'); ?>">	   
				<?php echo form_error('idSis_Empresa'); ?>			
			
			</div>
			<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 text-center">		
				<label class="sr-only">Celular do Usuário</label>
				<input type="text" id="CelularUsuario" maxlength="11" class="form-control acabamento3" placeholder="Celular Usuário (xx)999999999" name="CelularUsuario" value="<?php echo set_value('CelularUsuario'); ?>">	   
				<?php echo form_error('CelularUsuario'); ?>
			
			</div>
			<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 text-center">		
				<label class="sr-only">Senha</label>
				<div class="input-group acabamento3">
					<input type="password" name="Senha" id="inputPassword" placeholder="Digite a sua senha" class="form-control btn-sm " value="">
					<span class="input-group-btn">
						<button class="btn btn-info btn-md " type="button" onclick="mostrarSenha()">
							
							<span class="Mostrar glyphicon glyphicon-eye-open"></span>
							
							<span class="NMostrar glyphicon glyphicon-eye-close"></span>
							
						</button>
					</span>
					<script type="text/javascript"></script>
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
			<div class=" col-md-6 col-sm-6 col-xs-6 text-center acabamento2">	
				<a class="acabamento2" href="<?php echo base_url(); ?>pesquisar/empresas" role="button">
					<span class="glyphicon glyphicon-search"></span> Empresas
				</a>
			</div>
			<div class=" col-md-6 col-sm-6 col-xs-6 text-center acabamento2">	
				<a class="acabamento2" href="<?php echo base_url(); ?>../enkontraki" role="button">
					<span class="glyphicon glyphicon-search"></span> enkontraki
				</a>
			</div>
				<!--
				<br>
				<a class="btn btn-md btn-success  btn-block" href="<?php echo base_url(); ?>login/index3" role="button">
					<span class="glyphicon glyphicon-plus"></span> Cadastrar Nova Conta
				</a>
				-->
		</div>	
	</div>	
</div>
<!--
<div class="container col-md-4 text-center">
	<center>
	<h2 class="form-signin-heading text-center">patrocinadores</h2>	
	</center>	
	<div class="row">
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="http://159.89.138.173/passareladoslanches" target="_blank"><img src="<?php #echo base_url() . 'arquivos/imagens/patroc/profile-37.jpg'; ?>" alt="..." class="team-img"><h5>Passarela dos Lanches</h5></a>
		  </div>
		</div>
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="http://159.89.138.173/academia" target="_blank"><img src="<?php #echo base_url() . 'arquivos/imagens/patroc/profile-34.jpg'; ?>" alt="..." class="team-img"><h5>Fitness Brasil</h5></a>
		  </div>
		</div>				
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="http://159.89.138.173/espmmoda" target="_blank"><img src="<?php #echo base_url() . 'arquivos/imagens/patroc/profile-43.jpg'; ?>" alt="..." class="team-img"><h5>Mãos a Moda</h5></a>
		  </div>
		</div>
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="http://159.89.138.173/salaoadrielly" target="_blank"><img src="<?php #echo base_url() . 'arquivos/imagens/patroc/profile-50.jpg'; ?>" alt="..." class="team-img"><h5>Salão Adrielly</h5></a>
		  </div>
		</div>			
	</div>
</div>
-->