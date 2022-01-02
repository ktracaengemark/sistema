<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Usuario'])) { ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-2 col-md-8">
		<?php echo form_open_multipart($form_open_path); ?>

					
			<div class="row">
					
				<div class="col-md-12">	
					<?php #echo validation_errors(); ?>

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
												<span class="glyphicon glyphicon-edit"></span> Alterar Dados do Associado
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/associado\/alterarsenha\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'associado/alterarsenha/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Alterar Senha do Associado
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/associado\/alterarcelular\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'associado/alterarcelular/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Alterar Celular do Associado
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/associado\/alterarconta\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'associado/alterarconta/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Alterar Conta Comissão
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
												<label for="Nome">Nome do Associado:</label>
												<input type="text" class="form-control" readonly='' value="<?php echo $_SESSION['Usuario']['Nome']; ?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">		
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
												<label  >Digite a Nova Senha</label>
												<div class="input-group">
													<input type="password" name="Senha" id="Senha" placeholder="Digite uma senha" class="form-control btn-sm " value="<?php echo $confirma['Senha']; ?>"><br>
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
												<label  >Confirmar Nova Senha</label>
												<div class="input-group">
													<input type="password" name="Confirma" id="Confirma" placeholder="Digite a senha novamente" class="form-control btn-sm " value="<?php echo $confirma['Confirma']; ?>"><br>
													<span class="input-group-btn">
														<button class="btn btn-info btn-md " type="button" onclick="confirmarSenha()">
															
															<span class="Open glyphicon glyphicon-eye-open"></span>
															
															<span class="Close glyphicon glyphicon-eye-close"></span>
															
														</button>
													</span>
												</div>
												<?php echo form_error('Confirma'); ?>					
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
		</div>
	</div>	
</div>
<?php } ?>