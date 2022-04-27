<section id="banner" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="bg-color">
		<div class="banner-info">
			<div class="row">
				<div class="col-lg-offset-3 col-lg-6  col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12 text-center">
					<?php if (isset($msg)) echo $msg; ?>
					<?php echo form_open('login/recuperar', 'role="form"'); ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
						<div class="row acabamento text-center">	
							<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 text-center">				
   
								<label>Celular/Login Cadastrado:</label>
								<input type="text" class="form-control acabamento2" id="Associado" maxlength="11" autofocus="" placeholder="(XX)999999999" name="Associado" value="<?php echo $query['Associado']; ?>">
								<?php echo form_error('Associado'); ?>

							</div>
							<div class=" col-md-12 col-sm-12 col-xs-12 center">		
								<button class="btn btn-lg btn-info btn-block acabamento2" type="submit">
									<span class="glyphicon glyphicon-log-in"></span> Enviar Link
								</button>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>