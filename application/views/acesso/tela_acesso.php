<?php if (isset($msg)) echo $msg; ?>
<?php if (( !isset($evento) && isset($_SESSION['log'])) || ( isset($_SESSION['Empresa'])) || ( isset($_SESSION['Usuario']))) { ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6  col-sm-offset-2 col-sm-8 col-xs-12 text-center t">
			<div class="panel panel-primary">
				<div class="panel-heading"></div>
				<div class="panel-body">
					<div class="row">	
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " align="center">
							<h4><?php echo '<small>Bem Vindo<br> </small><strong>"' . $_SESSION['Usuario']['Nome'] . '"</strong>'  ?></h4>
							<a href="<?php echo base_url() . 'usuario2/alterarlogo/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">	
								<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Usuario']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['Usuario']['Arquivo'] . ''; ?>" class="img-circle img-responsive" width='200'>
							</a>							
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="center">
							<h4><?php echo '<small>a(o)<br></small><strong> ' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>.'  ?></h4>
							<a href="<?php echo base_url() . 'relatorio/loginempresa/'; ?>">
								<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-circle img-responsive" width='200'>
							</a>
						</div>	
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