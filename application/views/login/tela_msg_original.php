<div class="container text-center" id="login">

	<center>
		<figure>
			<div class="boxVideo">
				<img class="img-responsive" src="<?php echo base_url() . 'arquivos/imagens/Logo_Navegador.png'; ?>" >
			</div>
		</figure>
	</center>	
    <h2 class="form-signin-heading text-center">Olá!! </h2>

    <?php if ($aviso) echo $aviso; ?>

    <a class="btn btn-lg btn-primary" href="<?php echo base_url() ?>login/index" role="button">
        <span class="glyphicon glyphicon-home"></span> Login
    </a>

</div>
