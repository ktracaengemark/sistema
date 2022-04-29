<section id="banner" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="bg-color">
		<div class="banner-info">
			<div class="row">
				<div class="col-lg-offset-3 col-lg-6  col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12 text-center">
					<?php if (isset($msg)) echo $msg; ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
						<div class="row acabamento text-center">	
							
							<h2 class="form-signin-heading text-center">Seja Bem Vindo!! </h2>

							<?php if ($aviso) echo $aviso; ?>
							<div class=" col-md-12 col-sm-12 col-xs-12 center">    
								<a class="btn btn-lg btn-primary btn-block acabamento2" href="<?php echo base_url() ?>login/index2" role="button">
									<span class="glyphicon glyphicon-home"></span> Login
								</a>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>