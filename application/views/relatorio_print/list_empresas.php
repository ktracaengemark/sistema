<div class="container-fluid">
	<div class="row">
		<?php
		foreach ($report->result_array() as $row) {
		?>
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
				<br>
				<div class="card-body  text-center">
					<a href="../../<?php echo $row['Site'];?>" target="_blank">
						<img  alt="User Pic"  width='200' src="<?php echo base_url() . '../'.$row['Site'].'/' . $row['idSis_Empresa'] . '/documentos/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive">
					</a>
				</div>
				<div class="card-body  text-left">
					<a href="../../<?php echo $row['Site'];?>" target="_blank">
						<h5 class="card-title">
							<?php echo $row['NomeEmpresa'];?> - 
							<?php echo $row['idSis_Empresa'];?>	
						</h5>
					</a>
				</div>
			</div>	
		<?php
		}
		?>
	</div>
</div>
