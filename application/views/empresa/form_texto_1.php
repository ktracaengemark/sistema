<?php if ( !isset($evento) && isset($_SESSION['Empresa']) && isset($_SESSION['Documentos'])) { ?>
<div class="container-fluid">	
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="panel panel-<?php echo $panel; ?>">

				<div class="panel-heading">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Empresa']['NomeEmpresa'] . '</small> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/empresa\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-file"> </span>Ver Dados do Empresa
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Dados do Empresa
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
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
							<!--
							<h3 class="text-left">Dados do Empresa  </h3>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="NomeEmpresa">NomeEmpresa do Empresa:</label>
										<input type="text" class="form-control" id="NomeEmpresa" maxlength="45" readonly=''
												name="NomeEmpresa"  value="<?php echo $_SESSION['Empresa']['NomeEmpresa']; ?>">
									</div>

								</div>
							</div>
							-->
							<?php if ($metodo != 3) { ?>
							<div class="row">
								<div class="col-md-12 ">
									<div class="col-md-3 ">	
										<div class="col-md-12 ">	
											<div class="row "> 
												<a href="<?php echo base_url() . 'empresa/pagina/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
													<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo1'] . ''; ?>" 
													class="img-responsive" width='300'>
												</a>												
											</div>
										</div>	
										<div class="col-md-12 ">		
											<div class="row">
												<label for="Texto_Arquivo1">Texto 1:</label>
												<input type="text" class="form-control" id="Texto_Arquivo1" maxlength="45" 
														name="Texto_Arquivo1" autofocus value="<?php echo $_SESSION['Documentos']['Texto_Arquivo1']; ?>">
											</div>
										</div>	
									</div>
									<div class="col-md-3 ">	
										<div class="col-md-12 ">	
											<div class="row "> 
												<a href="<?php echo base_url() . 'empresa/pagina/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
													<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo2'] . ''; ?>" 
													class="img-responsive" width='300'>
												</a>												
											</div>
										</div>	
										<div class="col-md-12 ">	
											<div class="row">
												<label for="Texto_Arquivo2">Texto 2:</label>
												<input type="text" class="form-control" id="Texto_Arquivo2" maxlength="45" 
														name="Texto_Arquivo2" autofocus value="<?php echo $_SESSION['Documentos']['Texto_Arquivo2']; ?>">
											</div>
										</div>	
									</div>
									<div class="col-md-3 ">
										<div class="col-md-12 ">
											<div class="row "> 
												<a href="<?php echo base_url() . 'empresa/pagina/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
													<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo4'] . ''; ?>" 
													class="img-responsive" width='300'>
												</a>												
											</div>
										</div>	
										<div class="col-md-12 ">	
											<div class="row">
												<label for="Texto_Arquivo3">Texto 3:</label>
												<input type="text" class="form-control" id="Texto_Arquivo3" maxlength="45" 
														name="Texto_Arquivo3" autofocus value="<?php echo $_SESSION['Documentos']['Texto_Arquivo3']; ?>">
											</div>
										</div>	
									</div>
									<div class="col-md-3 ">	
										<div class="col-md-12 ">	
											<div class="row "> 
												<a href="<?php echo base_url() . 'empresa/pagina/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
													<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo4'] . ''; ?>" 
													class="img-responsive" width='300'>
												</a>												
											</div>
										</div>	
										<div class="col-md-12 ">	
											<div class="row">
												<label for="Texto_Arquivo4">Texto 4:</label>
												<input type="text" class="form-control" id="Texto_Arquivo4" maxlength="45" 
														name="Texto_Arquivo4" autofocus value="<?php echo $_SESSION['Documentos']['Texto_Arquivo4']; ?>">
											</div>
										</div>	
									</div>									
								</div>								
							</div>
							<?php } ?>
							<br>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idSis_Empresa" value="<?php echo $query['idSis_Empresa']; ?>">
							<?php if ($metodo == 3) { ?>
								<!--
								<input type="hidden" name="idSis_Arquivo" value="<?php echo $file['idSis_Arquivo']; ?>">
								<input type="hidden" name="Arquivo" value="<?php echo $file['Arquivo']; ?>">
								-->
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
		<div class="col-md-1"></div>
	</div>
</div>
<?php } ?>
