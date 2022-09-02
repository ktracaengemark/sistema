
		<?php
			if($doc){
				foreach ($doc as $row){
				?>		
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">	
					<div class="card h-100">
						<a href="<?php echo base_url() . 'documentos/alterar_logo_nav/' . $row['idApp_Documentos'] . ''; ?>">
							<img class="img-responsive" width='300' src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Logo_Nav'] . ''; ?>">
						</a>
					</div>
				</div>
				<?php 
				}
			}
		?>
