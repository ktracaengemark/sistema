
		<?php
			if($depoim){
				foreach ($depoim as $row){
				?>		
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 mb-4">
					<div class="card h-100">
						<a href="<?php echo base_url() . 'depoimento/alterar_depoimento/' . $row['idApp_Depoimento'] . ''; ?>"><img class="img-responsive" width='80' src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Arquivo_Depoimento'] . ''; ?>"></a>
						<div class="card-body">
							<h5 class="card-title">
								<a href="<?php echo base_url() . 'depoimento/alterar/' . $row['idApp_Depoimento'] . ''; ?>"><?php echo $row['Nome_Depoimento'];?></a>
							</h5>
						</div>
					</div>
				</div>
				<?php 
				}
			}
		?>
