<?php if ( !isset($evento) && isset($_SESSION['Usuario'])) { ?>
<div class="container-fluid">	
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="panel panel-<?php echo $panel; ?>">

				<div class="panel-heading">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Usuario']['Nome'] . '</small> - <small>Id.: ' . $_SESSION['Usuario']['idSis_Usuario'] . '</small>' ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/usuario\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'usuario/prontuario/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-file"> </span>Ver Dados do Usuario
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/usuario\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'usuario/alterar/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Dados do Usuario
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/usuario\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'usuario/alterarlogo/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Alterar Logo
									</a>
								</a>
							</li>							
						</ul>
					</div>
				</div>
				<div class="panel-body">
					<?php if (isset($msg)) echo $msg; ?>
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>
					<div class="panel panel-info">
						<div class="panel-heading">						
							<h3 class="text-left">Dados do Usuario  </h3>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<!--<label for="Nome">Nome do Usuario:</label>-->
										<input type="text" class="form-control" id="Nome" maxlength="45" readonly=''
												name="Nome"  value="<?php echo $_SESSION['Usuario']['Nome']; ?>">
									</div>

								</div>
							</div>				
							<?php if ($metodo != 3) { ?>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12 "> 
										<a href="<?php echo base_url() . 'usuario/prontuario/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
											<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['Usuario']['Arquivo'] . ''; ?>" 
											class="img-circle img-responsive" width='200'>
										</a>												
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label for="Arquivo">Arquivo: *</label>
										<input type="file" class="file" multiple="false" data-show-upload="false" data-show-caption="true" 
											   name="Arquivo" value="<?php echo $file['Arquivo']; ?>">
									</div>
								</div>
							</div>

							<?php } else { ?>

							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label for="Arquivo">Arquivo: *</label><br>
										<a href="<?php echo base_url() . 'arquivos/imagens/usuarios/' . $file['Arquivo']?>" target="_blank" class="btn btn-info">
											<span class="glyphicon glyphicon-file"></span> Visualizar
										</a>
										<?php echo $file['Arquivo']; ?>
									</div>
								</div>
							</div>                
							
							<?php } ?>
							
							<br>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idSis_Usuario" value="<?php echo $file['idSis_Usuario']; ?>">
							<?php if ($metodo == 3) { ?>
								<input type="hidden" name="idSis_Arquivo" value="<?php echo $file['idSis_Arquivo']; ?>">
								<input type="hidden" name="Arquivo" value="<?php echo $file['Arquivo']; ?>">
								<div class="col-md-6">                            
									<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." type="submit" name="submit">
										<span class="glyphicon glyphicon-trash"></span> Excluir
									</button>                            
								</div>                        
							<?php } else { ?>
								<div class="col-md-6">                            
									<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>                            
								</div>                        
							<?php } ?>     
								<!--
								<div class="col-md-6 text-right">
									<button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1); return true;">
										<span class="glyphicon glyphicon-ban-circle"></span> Voltar
									</button>
								</div>
								-->
						</div>
					</div>                
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
<?php } ?>
