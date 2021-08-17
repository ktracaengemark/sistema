<?php if (isset($msg)) echo $msg; ?>
<?php if (( !isset($evento) && isset($_SESSION['log'])) || ( isset($_SESSION['Empresa'])) || ( isset($_SESSION['Usuario']))) { ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
			<h4><?php echo '<strong> ' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>.'  ?></h4>
			<img class="img-circle img-responsive" width='500' alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" >
			<h4><?php echo '<small>Acesse o </small><strong> Menu </strong><small> acima <br>e tenha um bom trabalho! </small>'  ?></h4>
		</div>
	</div>
</div>	
<?php } ?>