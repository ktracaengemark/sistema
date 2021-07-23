<?php if (isset($msg)) echo $msg; ?>	
<section id="banner" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="bg-color">
		<div class="banner-info">
			<div class="col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12">
				<div class="row">
					<div class="panel panel-default">
						<div class="panel-heading">		
							<div class="row">
								<div class="panel-body">
									<h2 class="form-signin-heading text-center">Bem Vindo!! <?php #echo ucfirst($_SESSION['log']['nome_modulo']) ?></h2>

									<?php if ($aviso) echo $aviso; ?>

									<a class="btn btn-lg btn-primary" href="<?php echo base_url(); ?>login/index2" role="button">
									<!--<a class="btn btn-lg btn-primary" href="<?php echo base_url() . $_SESSION['log']['modulo']; ?>">-->
										<span class="glyphicon glyphicon-home"></span> Acessar Empresa
									</a>								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>