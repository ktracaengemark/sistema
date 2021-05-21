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
							<h3 class="text-left">Dados do Empresa  </h3>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<!--<label for="NomeEmpresa">NomeEmpresa do Empresa:</label>-->
										<input type="text" class="form-control" id="NomeEmpresa" maxlength="45" readonly=''
												name="NomeEmpresa"  value="<?php echo $_SESSION['Empresa']['NomeEmpresa']; ?>">
									</div>

								</div>
							</div>				
							<?php if ($metodo != 3) { ?>
							<div class="row">
								<div class="col-md-12 ">
									<div class="col-md-6 "> 
										<a href="<?php echo base_url() . 'empresa/pagina/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
											<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Documentos']['Slide2'] . ''; ?>" 
											class="img-responsive" width='600'>
										</a>												
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label for="Slide2">Slide2: *</label>
												<input type="file" class="file" multiple="false" data-show-upload="false" data-show-caption="true" 
													   name="Slide2" value="<?php echo $file['Slide2']; ?>">
											</div>
										</div>
									</div>
								</div>								
							</div>
							<?php } else { ?>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label for="Arquivo">Arquivo: *</label><br>
										<a href="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $file['Arquivo']?>" target="_blank" class="btn btn-info">
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
							<input type="hidden" name="idSis_Empresa" value="<?php echo $file['idSis_Empresa']; ?>">
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
		<div class="col-md-1"></div>
	</div>
</div>
<?php } ?>
