
		<?php
			if($slides){
				foreach ($slides as $row){
				?>		
				<div class="col-lg-12 col-md-6 mb-4">
					<div class="card h-100">
						<!--<img class="img-responsive" width='800' src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Slide1'] . ''; ?>">-->
						<!--<a href="produto.php?id=<?php echo $row['idApp_Slides'];?>"><img class="team-img" src="../'.$_SESSION['log']['Site'].'/<?php echo $_SESSION['Empresa']['idSis_Empresa']; ?>/documentos/miniatura/<?php echo $row['Slide1']; ?>" alt="" ></a>					 
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>-->
						<a href="<?php echo base_url() . 'slides/alterar_slide/' . $row['idApp_Slides'] . ''; ?>"><img class="img-responsive" width='800' src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Slide1'] . ''; ?>"></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href="<?php echo base_url() . 'slides/alterar/' . $row['idApp_Slides'] . ''; ?>"><?php echo $row['Texto_Slide1'];?></a>
							</h4>
						</div>
					</div>
				</div>
				<?php 
				}
			}
		?>
