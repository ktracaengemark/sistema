<?php if (isset($msg)) echo $msg; ?>
<?php if (( !isset($evento) && isset($_SESSION['log'])) || ( isset($_SESSION['AdminEmpresa']))) { ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-3 col-md-6 text-center t">
			<div class="panel panel-primary">
				<div class="panel-heading"></div>
				<div class="panel-body">
					<div class="col-md-12 text-center t">
						<h4><?php echo '<small>Bem Vindo<br></small><strong>"' . $_SESSION['AdminEmpresa']['NomeAdmin'] . '"</strong>'  ?></h4>
						<h4><?php echo '<small>Administrador da(o)<br></small><strong> ' . $_SESSION['AdminEmpresa']['NomeEmpresa'] . '</strong>.'  ?></h4>
					</div>
					<div class="col-sm-offset-4 col-lg-4 " align="center"> 
						<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['AdminEmpresa']['idSis_Empresa']; ?>">
							<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['AdminEmpresa']['Arquivo'] . ''; ?>" class="img-circle img-responsive">
						</a>
					</div>
					<div class="col-md-12 text-center t">
						<h4><?php echo '<small>Acesse o </small><strong> Menu </strong><small> acima <br>e tenha um bom trabalho! </small>'  ?></h4>
					</div>
				</div>	
			</div>		
		</div>
	</div>
</div>	
<?php } ?>