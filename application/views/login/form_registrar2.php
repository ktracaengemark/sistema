<?php if (isset($msg)) echo $msg; ?>

<div class="container col-sm-offset-1 col-md-5 ">
	<?php echo form_open('login/registrar2', 'role="form"'); ?>
	
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
							<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>login/index" role="button">
								<span class="glyphicon glyphicon-floppy-remove"></span> Cancelar
							</a>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>

	<h2 class="form-signin-heading text-center">enkontraki</h2>		 
	<div class="container col-md-5 ">
		<div class="row">	
			<center>
				<figure>
					<div class="boxVideo">
						<iframe width="270" height="270" src="https://www.youtube.com/embed/videoseries?list=PLPP9yl-2bfZFWltdqkqZ2WSazBo7dnDx1" frameborder="0" allowfullscreen></iframe>
						<!--<iframe width="255" height="255" src="<?php echo base_url() . 'arquivos/videos/apresentacao.mp4'; ?>" frameborder="0" allowfullscreen></iframe>-->
					</div>
				</figure>
			</center>
			<script type="text/javascript">
				$('#ca-container').contentcarousel();
			</script>
		</div>
	</div>
	<div class="col-md-2 "></div>
	<div class="container col-md-5 ">	
		<div class="row">			
			<label for="Associado">Cadastrado por:</label>
			<select data-placeholder="Selecione uma opçao..." class="form-control" id="Associado" name="Associado">			
				<!--<option value="">-- Selecione uma Empresa --</option>-->
				<?php
				foreach ($select['Associado'] as $key => $row) {
					(!$query['Associado']) ? $query['Associado'] = $_SESSION['log']['idSis_Empresa'] : FALSE;
					if ($query['Associado'] == $key) {
						echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
					} else {
						echo '<option value="' . $key . '">' . $row . '</option>';
					}
				}
				?>   
			</select> 
			<?php echo form_error('Associado'); ?>
			<br>
			<label class="sr-only">Empresa</label>
			<select data-placeholder="Selecione uma opção..." class="form-control" id="idSis_Empresa" name="idSis_Empresa">			
				
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
			
			
			<label for="Nome">Nome da Pessoa:</label>
			<input type="text" class="form-control" id="Nome" maxlength="255"
				   name="Nome" value="<?php echo $query['Nome']; ?>">
			<?php echo form_error('Nome'); ?>

			<!--
			<label class="text-">E-mail:</label>
			<input type="text" class="form-control" id="Email" maxlength="100"
				   name="Email" value="<?php #echo $query['Email']; ?>">
			<?php #echo form_error('Email'); ?>
			<br>

			<label class="text-">Confirmar E-mail:</label>
			<input type="text" class="form-control" id="ConfirmarEmail" maxlength="100"
				   name="ConfirmarEmail" value="<?php #echo $query['ConfirmarEmail']; ?>">
			<?php #echo form_error('ConfirmarEmail'); ?>
			<br>
			
			<label for="Usuario">Usuário:</label>
			<input type="text" class="form-control" id="Usuario" maxlength="45"
				   name="Usuario" value="<?php #echo $query['Usuario']; ?>">
			<?php #echo form_error('Usuario'); ?>
			<br>
			-->			
			
			<label for="DataNascimento">Data de Aniver.:</label>
			<input type="text" class="form-control Date" id="inputDate0" maxlength="10"
				   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
			<?php echo form_error('DataNascimento'); ?>
			
			<!--
			<label for="Sexo">Sexo:</label>
			<select data-placeholder="Selecione um TROCA..." class="form-control" id="Sexo" name="Sexo">
				<option value=""></option>
				<?php
				foreach ($select['Sexo'] as $key => $row) {
					if ($query['Sexo'] == $key) {
						echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
					} else {
						echo '<option value="' . $key . '">' . $row . '</option>';
					}
				}
				?>
			</select>
			<?php echo form_error('Sexo'); ?>
			<br>
			
			<label for="CpfUsuario">CPF do Usuário:</label>
			<input type="text" class="form-control " id="CpfUsuario" maxlength="11"
				   name="CpfUsuario" placeholder="99999999999" value="<?php echo $query['CpfUsuario']; ?>">
			<?php echo form_error('CpfUsuario'); ?>
			<br>
			-->
			
			<label for="CelularUsuario">Celular / (Login):</label>
			<input type="text" class="form-control Celular Celular" id="CelularUsuario" maxlength="11"
				   name="CelularUsuario" placeholder="(XX)999999999" value="<?php echo $query['CelularUsuario']; ?>">
			<?php echo form_error('CelularUsuario'); ?>

			
			<label for="Senha">Senha:</label>
			<input type="password" class="form-control" id="Senha" maxlength="45"
				   name="Senha" value="<?php echo $query['Senha']; ?>">
			<?php echo form_error('Senha'); ?>


			<label for="Senha">Confirmar Senha:</label>
			<input type="password" class="form-control" id="Confirma" maxlength="45"
				   name="Confirma" value="<?php echo $query['Confirma']; ?>">
			<?php echo form_error('Confirma'); ?>
			<br>
		<!--
			<button class="btn btn-lg btn-success btn-block" type="submit">REGISTRAR</button>
			<br>
		-->
			<button  class="btn btn-md btn-success btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
				<span class="glyphicon glyphicon-floppy-saved"></span> Registrar
			</button>

			<br>
			
			<a class="btn btn-md btn-danger btn-block" href="<?php echo base_url(); ?>login/index" role="button">
				<span class="glyphicon glyphicon-floppy-remove"></span>	Cancelar
			</a>
			<!--<a class="btn btn btn-warning btn-block" href="<?php #echo base_url(); ?>loginempresa/index" role="button">Acesso dos Administradores</a>-->

		</div>
	</div>
	
</div>
<div class="container col-md-4 text-center">
	<center>
	<h2 class="form-signin-heading text-center">patrocinadores</h2>	
	</center>	
	<div class="row">
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="http://159.89.138.173/passareladoslanches" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-37.jpg'; ?>" alt="..." class="team-img"><h5>Passarela dos Lanches</h5></a>
		  </div>
		</div>
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="http://159.89.138.173/academia" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-34.jpg'; ?>" alt="..." class="team-img"><h5>Fitness Brasil</h5></a>
		  </div>
		</div>				
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="http://159.89.138.173/espmmoda" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-43.jpg'; ?>" alt="..." class="team-img"><h5>Mãos a Moda</h5></a>
		  </div>
		</div>
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="http://159.89.138.173/salaoadrielly" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-50.jpg'; ?>" alt="..." class="team-img"><h5>Salão Adrielly</h5></a>
		  </div>
		</div>			
	</div>
</div>
<div class="container col-md-1 text-center"></div>	