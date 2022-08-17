<div class="panel panel-<?php echo $panel; ?>">
	<div class="panel-heading">
		<div class="row">
			<?php if($paginacao == "S") { ?>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-left">
					<label></label>
					<a href="<?php echo base_url() . $caminho; ?>">
						<button class="btn btn-warning btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-filter"></span>
						</button>
					</a>
				</div>
			<?php }else{ ?>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-left">
					<label></label>
					<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-filter"></span>
					</button>
				</div>
			<?php } ?>
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
    </div>
</div>
<div class="container-fluid">	
    <div class="row">
		<div style="overflow: auto; height: 550px; ">
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
