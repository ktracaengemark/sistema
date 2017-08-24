<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['log'])) { ?>

<div class="container-fluid">
	<div class="row">

		<div class="col-md-2"></div>
		<div class="col-md-12 text-center t">
		
			<div class="panel panel-primary">
				<div class="panel-heading"></div>
				<div class="panel-body">
					<div class="col-md-12 text-center t">
						<h1><?php echo '<small>Seja Bem Vindo, </small><strong>"' . $_SESSION['log']['Nome'] . '"</strong>'  ?></h1>
					</div>

					<div class="col-md-12 text-center t">
						<h1><?php echo '<small>A Empresa </small><strong> ' . $_SESSION['log']['NomeEmpresa'] . ' </strong>!'  ?></h1>
					</div>

					<div class="col-md-12 text-center t">
						<h1><?php echo '<small>selecione o </small><strong> Menu </strong><small> acima <br>e bom trabalho. </small>'  ?></h1>
					</div>
				</div>	
			</div>		
		</div>
		<div class="col-md-2"></div>

	</div>
</div>	

	<?php } ?>