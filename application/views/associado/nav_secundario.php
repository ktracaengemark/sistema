<?php if ( !isset($evento) && isset($_SESSION['Associado'])) { ?>
<div class="container-fluid">
	<ul class="nav nav-sidebar">
		<li>
			<div class="text-center t">
				<h4><?php echo '<strong>' . $_SESSION['Associado']['Nome'] . '</strong><br><small>Identificador: ' . $_SESSION['Associado']['idSis_Usuario'] . '</small>' ?></h4>
			</div>
		</li>
	</ul>

	<div class="nav nav-sidebar">
		<!--<span class="glyphicon glyphicon-user"> </span> Dados do Associado<span ></span>-->
		<h4 class="col-md-10 text-center glyphicon glyphicon-user"></span> Associado<span ></h4>	
		<div class="form-group">
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
					<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'associado/prontuario/' . $_SESSION['Associado']['idSis_Usuario']; ?>">
						<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
					</a>
				</li>
			</div>
		</div>	
	</div>
</div>	
	<?php } ?>
