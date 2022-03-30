
		<?php
			if($atuacao){
				foreach ($atuacao as $row){
				?>		
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-4">
					<div class="card h-100">
						<a href="<?php echo base_url() . 'atuacao/alterar_atuacao/' . $row['idApp_Atuacao'] . ''; ?>"><img class="img-responsive" width='200' src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Arquivo_Atuacao'] . ''; ?>"></a>
						<div class="card-body">
							<h5 class="card-title">
								<a href="<?php echo base_url() . 'atuacao/alterar/' . $row['idApp_Atuacao'] . ''; ?>"><?php echo $row['Nome_Atuacao'];?></a>
							</h5>
						</div>
					</div>
				</div>
				<?php 
				}
			}
		?>
