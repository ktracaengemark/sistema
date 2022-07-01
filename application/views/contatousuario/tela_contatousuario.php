<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['QueryUsuario'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-sm-offset-1 col-md-10">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<strong><?php echo $titulo; ?></strong>
							</div>
							<div class="panel-body">
								<?php
								if (!$list) {
								?>
									<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>contatousuario/cadastrar" role="button"> 
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
<?php } ?>