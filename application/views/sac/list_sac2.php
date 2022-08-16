<div class="panel panel-<?php echo $panel; ?>">
	<div class="panel-heading">
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
			<?php if($paginacao == "N") { ?>
				<div class="col-md-1">
					<label></label><br>
					<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-filter"></span>Filtros
					</button>
				</div>
			<?php }else{ ?>
				<div class="col-md-1">
					<label></label><br>
					<a href="<?php echo base_url() . $caminho; ?>">
						<button class="btn btn-warning btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-filter"></span>Filtros
						</button>
					</a>
				</div>
			<?php } ?>	
			<?php if ($print == 1) { ?>	
				<div class="col-md-1">
					<label></label><br>
					<a href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
						<button class="btn btn-info btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-print"></span>Imprimir
						</button>
					</a>
				</div>
			<?php } ?>
			<?php if ($editar == 1) { ?>	
				<div class="col-md-1">
					<label></label><br>
					<a href="<?php echo base_url() . $alterarparc . $_SESSION['log']['idSis_Empresa']; ?>">
						<button class="btn btn-success btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-edit"></span>Editar
						</button>
					</a>
				</div>	
			<?php } ?>
			<div class="col-lg-1 col-md-2 col-sm-2 col-xs-6 text-left">
				<label></label><br>
				<a href="<?php echo base_url() . 'gerar_excel/Sac/Sac_total_xls.php'; ?>">
					<button type='button' class='btn btn-md btn-success btn-block'>
						<span class="glyphicon glyphicon-print"></span>Excel
					</button>
				</a>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">	
    <div class="row">
		<div style="overflow: auto; height: auto; ">
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
						<?php if($query['TipoSac'] == 3 || $query['TipoSac'] == 4) { ?>
							<th class="active">Tipo_de_<?php echo $titulo1; ?></th>
						<?php } ?>
						<th class="active">id_<?php echo $nome; ?></th>
						<th class="active"><?php echo $nome; ?></th>
						<th class="active">Descr_do_<?php echo $titulo1; ?></th>
						<th class="active">Quem_Fazer</th>
						<th class="active">Concluída?</th>
						<?php if($query['TipoSac'] == 3 || $query['TipoSac'] == 4) { ?>
							<th class="active">Ação</th>
							<th class="active">Data</th>
							<th class="active">Hora</th>
							<th class="active">Quem_Fez</th>
							<th class="active">Concluída?</th>
						<?php } ?>	
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
							//echo '<tr class="clickable-row" data-href="' . base_url() . 'sac/alterar/' . $row['idApp_Sac'] . '">';
							
							echo '<td>' . ($linha + $count) . '</td>';
							echo '<td>' . $row['NomeUsuario'] . '</td>';
							echo '<td>' . $row['DataSac'] . '</td>';
							echo '<td>' . $row['HoraSac'] . '</td>';
							if($query['TipoSac'] == 1 || $query['TipoSac'] == 2) {
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
							}elseif($query['TipoSac'] == 3 || $query['TipoSac'] == 4) {
								if($query['TipoSac'] == 3){
									echo '<td class="notclickable">
											<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . 'sac/tela_'.$titulo1.'/' . $row['idApp_Sac'] . '">
												 ' . $row['idApp_Sac'] . '
											</a>
										</td>';
								}elseif($query['TipoSac'] == 4){
									echo '<td class="notclickable">
											<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . 'sac/tela_'.$titulo1.'/' . $row['idApp_Sac'] . '">
												 ' . $row['idApp_Sac'] . '
											</a>
										</td>';
								}
							}
							
							if($query['TipoSac'] == 3 || $query['TipoSac'] == 4) {
								echo '<td>' . $row['Categoria'.$titulo1] . '</td>';
							}
				
							if($nome == "Cliente"){	
								if(isset($row['idApp_' . $nome]) && $row['idApp_' . $nome] != 0){	
									if(isset($row['idApp_OrcaTrata']) && $row['idApp_OrcaTrata'] != 0){
										echo '<td class="notclickable">
												<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'orcatrata/listar/' . $row['idApp_' . $nome] . '">
													 ' . $row['idApp_' . $nome] . '
												</a>
											</td>';
									}else{
										if($query['TipoSac'] == 3){
											echo '<td class="notclickable">
													<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'sac/listar_Sac/' . $row['idApp_' . $nome] . '">
														 ' . $row['idApp_' . $nome] . '
													</a>
												</td>';
										}elseif($query['TipoSac'] == 4){	
											echo '<td class="notclickable">
													<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'sac/listar_Marketing/' . $row['idApp_' . $nome] . '">
														 ' . $row['idApp_' . $nome] . '
													</a>
												</td>';
										}		
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
									<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'sac/alterar/' . $row['idApp_Sac'] . '">
										 ' . $row['idApp_Sac'] . '
									</a>
								</td>';
								*/
							echo '<td>' . $row['Sac'] . '</td>';	
							echo '<td>' . $row['NomeCompartilhar'] . '</td>';					
							echo '<td>' . $row['ConcluidoSac'] . '</td>';
							if($query['TipoSac'] == 3 || $query['TipoSac'] == 4) {
								echo '<td>' . $row['SubSac'] . '</td>';
								echo '<td>' . $row['DataSubSac'] . '</td>';
								echo '<td>' . $row['HoraSubSac'] . '</td>';
								echo '<td>' . $row['NomeSubUsuario'] . '</td>';							
								echo '<td>' . $row['ConcluidoSubSac'] . '</td>';
							}

						echo '</tr>';
						$count++;
					}
					?>

				</tbody>

			</table>
		</div>
    </div>
</div>
