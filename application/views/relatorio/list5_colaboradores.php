
		<?php
			if($colab){
				foreach ($colab as $row){
				?>		
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 mb-4">
					<div class="card h-100">
						<a href="<?php echo base_url() . 'colaborador/alterar_colaborador/' . $row['idApp_Colaborador'] . ''; ?>"><img class="img-responsive" width='100' src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Arquivo_Colaborador'] . ''; ?>"></a>
						<div class="card-body">
							<h5 class="card-title">
								<a href="<?php echo base_url() . 'colaborador/alterar/' . $row['idApp_Colaborador'] . ''; ?>"><?php echo $row['Nome_Colaborador'];?></a>
							</h5>
						</div>
					</div>
				</div>
				<?php 
				}
			}
		?>
