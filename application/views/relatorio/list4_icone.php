
		<?php
			if($doc){
				foreach ($doc as $row){
				?>		
				<div class="col-lg-12 col-md-6 col-sm-6 col-xs-6 mb-4">
					<div class="card h-100">
						<!--<img class="img-responsive" width='100' src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Icone'] . ''; ?>">
						<a href="produto.php?id=<?php echo $row['idApp_Slides'];?>"><img class="team-img" src="../'.$_SESSION['log']['Site'].'/<?php echo $_SESSION['Empresa']['idSis_Empresa']; ?>/documentos/miniatura/<?php echo $row['Slide1']; ?>" alt="" ></a>					 
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>-->
						<a href="<?php echo base_url() . 'documentos/alterar_icone/' . $row['idApp_Documentos'] . ''; ?>"><img class="img-responsive" width='100' src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Icone'] . ''; ?>"></a>
						<!--
						<div class="card-body">
							<h4 class="card-title">
								<a href="<?php echo base_url() . 'documentos/alterar_icone/' . $row['idApp_Documentos'] . ''; ?>"><?php echo $row['Icone'];?></a>
							</h4>
						</div>
						-->
					</div>
				</div>
				<?php 
				}
			}
		?>
