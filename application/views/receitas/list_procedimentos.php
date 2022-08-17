<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
			<label></label><br>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php echo $report->num_rows(); ?> / <?php echo $total_rows; ?>">
			</div>
		</div>	
		<div class="col-md-4 text-left">
			<?php echo $pagination; ?>
		</div>
	</div>
	
    <div class="row">
		<div class="col-md-12 text-left">
			<div style="overflow: auto; height: 550px; ">
				<!--
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="9" class="active">Total: <?php #echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>
				-->
				<table class="table table-bordered table-condensed table-striped">								
					<thead>
						<tr>
							<th class="active">Cont.</th>
							<th class="active">Quem_Cadastrou</th>
							<th class="active">Data</th>
							<th class="active">Hora</th>
							<th class="active">id_<?php echo $titulo1; ?></th>
							<th class="active">id_<?php echo $nome; ?></th>
							<th class="active"><?php echo $nome; ?></th>
							<th class="active">Descr_do_<?php echo $titulo1; ?></th>
							<th class="active">Quem_Fazer</th>
							<th class="active">Concluída?</th>
						</tr>
					</thead>

					<tbody>

						<?php
						$linha =  $per_page*$pagina;
						$count = 1;
						foreach ($report->result_array() as $row) {

							echo '<tr>';
										 
							 /*
								  //echo $this->db->last_query();
							  echo "<br>";
							  echo "<pre>";
							  print_r($row['idApp_' . $nome]);
							  echo "</pre>";
							  exit();
								*/	
								//echo '<tr class="clickable-row" data-href="' . base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'] . '">';
								
								echo '<td>' . ($linha + $count) . '</td>';
								echo '<td>' . $row['NomeUsuario'] . '</td>';
								echo '<td>' . $row['DataProcedimento'] . '</td>';
								echo '<td>' . $row['HoraProcedimento'] . '</td>';
								if(isset($row['idApp_OrcaTrata']) && $row['idApp_OrcaTrata'] != 0){
									if($nome == "Cliente"){
										if(isset($row['idApp_' . $nome]) && $row['idApp_' . $nome] != 0){
											echo '<td class="notclickable">
													<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] . '">
														 ' . $row['idApp_OrcaTrata'] . '
													</a>
												</td>';
										}else{	
											echo '<td class="notclickable">
													<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] . '">
														 ' . $row['idApp_OrcaTrata'] . '
													</a>
												</td>';
										}
									}else{
										echo '<td class="notclickable">
												<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">
													 ' . $row['idApp_OrcaTrata'] . '
												</a>
											</td>';
									}	
								}else{
									echo '<td class="notclickable">
											<a class="notclickable" >
												
											</a>
										</td>';
								}
								if($nome == "Cliente"){	
									if(isset($row['idApp_' . $nome]) && $row['idApp_' . $nome] != 0){	
										if(isset($row['idApp_OrcaTrata']) && $row['idApp_OrcaTrata'] != 0){
											echo '<td class="notclickable">
													<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'orcatrata/listar/' . $row['idApp_' . $nome] . '">
														 ' . $row['idApp_' . $nome] . '
													</a>
												</td>';
										}	
									}else{
										echo '<td class="notclickable">
												<a class="notclickable" >
													
												</a>
											</td>';
									}
								}else{
									if(isset($row['idApp_' . $nome]) && $row['idApp_' . $nome] != 0){
										echo '<td class="notclickable">
												<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">
													 ' . $row['idApp_' . $nome] . '
												</a>
											</td>';
									}else{
										echo '<td class="notclickable">
												<a class="notclickable" >
													
												</a>
											</td>';
									
									}		
								}	
								echo '<td>' . $row['Nome' . $nome] . '</td>';	
								/*
								echo '<td class="notclickable">
										<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'] . '">
											 ' . $row['idApp_Procedimento'] . '
										</a>
									</td>';
									*/
								echo '<td>' . $row['Procedimento'] . '</td>';	
								echo '<td>' . $row['NomeCompartilhar'] . '</td>';					
								echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';

							echo '</tr>';
							$count++;
						}
						?>

					</tbody>

				</table>

			</div>
		</div>
    </div>

</div>
