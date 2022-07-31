<div class="container ">
	<?php if (isset($msg)) echo $msg; ?>
	<?php echo form_open('relatorioempresa/login', 'role="form"'); ?>
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
	<div class="col-sm-offset-4 col-md-4 ">
		<div class="row">
			<label class="sr-only">Empresa</label>
			<select data-placeholder="Selecione uma opção..." class="form-control" id="idSis_Empresa" name="idSis_Empresa" readonly=''>			
				<!--<option value="">Selecione sua Empresa</option>-->
				<?php
				foreach ($select['idSis_Empresa'] as $key => $row) {
					if ($query['idSis_Empresa'] == $key) {
						echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
					} else {
						echo '<option value="' . $key . '">' . $row . '</option>';
					}
				}
				?>   
			</select> 
			<?php echo form_error('idSis_Empresa'); ?>
			<label class="sr-only">Celular do Usuário</label>
			<input type="text" id="inputText" maxlength="11" class="form-control" placeholder="Celular Usuario (xx)999999999" autofocus name="CelularUsuario" value="<?php echo set_value('CelularUsuario'); ?>">	   
			<?php echo form_error('CelularUsuario'); ?>
			<label class="sr-only">Senha</label>
			<div class="input-group">
				<input type="password" name="Senha" id="inputPassword" placeholder="Digite a sua senha" class="form-control btn-sm " value="">
				<span class="input-group-btn">
					<button class="btn btn-info btn-md " type="button" onclick="mostrarSenha()">
						
						<span class="Mostrar glyphicon glyphicon-eye-open"></span>
						
						<span class="NMostrar glyphicon glyphicon-eye-close"></span>
						
					</button>
				</span>
			</div>
			<!--<input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">-->
			<?php echo form_error('Senha'); ?>
			<input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
			<button class="btn btn-lg btn-primary btn-block" type="submit"><span class="glyphicon glyphicon-log-in"></span> Acessar Loja</button>
		</div>	
	</div>		
</div>
<div class="container col-md-2 "></div>