<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Usuario'])) { ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-2 col-md-8">
		<?php echo form_open_multipart($form_open_path); ?>
	
			<div class="row">
					
				<div class="col-md-12">	
					<?php echo validation_errors(); ?>

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Usuario']['Nome'] . '</small> - <small>Id.: ' . $_SESSION['Usuario']['idSis_Associado'] . '</small>' ?> <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/associado\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
											<a href="<?php echo base_url() . 'associado/prontuario/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
												<span class="glyphicon glyphicon-file"> </span>Ver Dados do Associado
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/associado\/associadoalterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'associado/associadoalterar/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados do Associado
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/associado\/alterarsenha\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'associado/alterarsenha/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Senha do Associado
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/associado\/alterarconta\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'associado/alterarconta/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Conta Comissão
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/associado\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'associado/alterarlogo/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Alterar Foto
											</a>
										</a>
									</li>									
								</ul>
							</div>
						</div>
						<div class="panel-body">
							<div class="panel panel-info">
								<div class="panel-heading">
									<div class="form-group">
										<div class="row">
											<div class="col-md-8">
												<label for="Nome">Nome do Usuário:</label>
												<input type="text" class="form-control" id="Nome" maxlength="45" readonly=''
														 name="Nome"  value="<?php echo $query['Nome']; ?>">
												<?php echo form_error('Nome'); ?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-4">
												<label for="Conta">Chave PIX / Conta:</label>
												<input type="text" class="form-control" id="Conta" maxlength="100"
														autofocus name="Conta"  value="<?php echo $query['Conta']; ?>">
												<?php echo form_error('Conta'); ?>
											</div>
											<div class="col-md-4">
												<label for="Banco">Banco:</label>
												<input type="text" class="form-control" id="Banco" maxlength="100"
														 name="Banco"  value="<?php echo $query['Banco']; ?>">
												<?php echo form_error('Banco'); ?>
											</div>
											<div class="col-md-4">
												<label for="Agencia">Agencia:</label>
												<input type="text" class="form-control" id="Agencia" maxlength="100" 
														 name="Agencia"  value="<?php echo $query['Agencia']; ?>">
												<?php echo form_error('Agencia'); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<input type="hidden" name="idSis_Empresa" value="<?php echo $query['idSis_Empresa']; ?>">
									<input type="hidden" name="idSis_Associado" value="<?php echo $query['idSis_Associado']; ?>">
									<div class="col-md-6">
										<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
											<span class="glyphicon glyphicon-save"></span> Salvar
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>							
				</div>	
			</div>
		</form>	
		</div>
	</div>	
</div>
<?php } ?>