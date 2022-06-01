<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">	
	<div class="row">
		<div class="col-md-12">
			<?php if ($nav_secundario) echo $nav_secundario; ?>
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>Id.: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
											<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-file"> </span>Ver Dados do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/cliente\/alterar_status\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'cliente/alterar_status/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Alterar Status do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/cliente\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'cliente/alterarlogo/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
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
									<h3 class="text-left">Dados do Dep  </h3>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<!--<label for="NomeCliente">Nome do Cliente:</label>-->
												<input type="text" class="form-control" id="NomeClienteDep" maxlength="45" readonly=''
														name="NomeClienteDep"  value="<?php echo $_SESSION['ClienteDep']['NomeClienteDep']; ?>">
											</div>

										</div>
									</div>				
									<?php if ($metodo != 3) { ?>
									<div class="form-group">
										<div class="row">
											<div class="col-md-12 "> 
												<a href="<?php echo base_url() . 'cliente/clientedep/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['ClienteDep']['Arquivo'] . ''; ?>" 
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
												<a href="<?php echo base_url() . 'arquivos/imagens/clientes/' . $file['Arquivo']?>" target="_blank" class="btn btn-info">
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
									<input type="hidden" name="idApp_ClienteDep" value="<?php echo $file['idApp_ClienteDep']; ?>">
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
			</div>			
		</div>
	</div>
</div>

