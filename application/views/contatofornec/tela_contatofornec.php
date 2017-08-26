<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Fornecedor'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Fornecedor']['NomeFornecedor'] . '</strong> - <small>Id.: ' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . '</small>' ?></strong></div>
				<div class="panel-body">
			
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="col-md-4 text-left">
									<label for="">Fornecedor & Contatos:</label>
									<div class="form-group">
										<div class="row">							
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'fornecedor/prontuario/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
													<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
												</a>
											</a>								
											<a <?php if (preg_match("/fornecedor\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'fornecedor/alterar/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Edit.
												</a>
											</a>																																																						
										</div>
									</div>	
								</div>
							</div>	
						</div>
					</div>	
					<!--
					<div class="form-group">
						<div class="row">
							<div class="text-center t">
								<h3><?php echo '<strong>' . $_SESSION['Fornecedor']['NomeFornecedor'] . '</strong> - <small>Id.: ' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . '</small>' ?></h3>
							</div>
						</div>
					</div>
					-->
					<?php } ?>

					<div class="row">
					
						<div class="col-md-12 col-lg-12">

							<div class="panel panel-primary">

								<div class="panel-heading"><strong>Contato</strong></div>
								<div class="panel-body">
									<?php
									if (!$list) {
									?>
										<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>contatofornec/cadastrar" role="button"> 
											<span class="glyphicon glyphicon-plus"></span> Cad.
										</a>
										<br><br>
										<div class="alert alert-info" role="alert"><b>Nenhum Cad.</b></div>
									<?php
									} else {
										echo $list;
									}
									?>

								</div>
							</div>
						</div>	
					</div>	
				</div>	
			</div>		
		</div>
		<div class="col-md-2"></div>
	</div>	
</div>