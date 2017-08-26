<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Funcionario'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Funcionario']['Nome'] . '</strong> - <small>Id.: ' . $_SESSION['Funcionario']['idSis_Usuario'] . '</small>' ?></strong></div>
				<div class="panel-body">
			
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="col-md-4 text-left">
									<label for="">Funcionario & Contatos:</label>
									<div class="form-group">
										<div class="row">							
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'funcionario/prontuario/' . $_SESSION['Funcionario']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
												</a>
											</a>
											<a <?php if (preg_match("/funcionario\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'funcionario/alterar/' . $_SESSION['Funcionario']['idSis_Usuario']; ?>">
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
								<h3><?php echo '<strong>' . $_SESSION['Funcionario']['Nome'] . '</strong> - <small>Id.: ' . $_SESSION['Funcionario']['idSis_Usuario'] . '</small>' ?></h3>
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
										<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>contatofunc/cadastrar" role="button"> 
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