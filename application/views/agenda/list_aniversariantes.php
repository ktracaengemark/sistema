<div style="overflow: auto; height: auto; ">
	<div class="container-fluid">
		<div class="row">
			<?php if($paginacao == "S") { ?>
				<div class="col-md-3">
					<label></label><br>
					<a href="<?php echo base_url() . $caminho; ?>">
						<button class="btn btn-warning btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-filter"></span>Filtros
						</button>
					</a>
				</div>
			<?php } ?>
			<!--
			<div class="col-md-6">
				<label></label><br>
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
					<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php #echo $report->num_rows(); ?> / <?php #echo $total_rows; ?>">
				</div>
			</div>
			-->
			<div class="col-md-9 text-left">
				<?php echo $pagination; ?>
			</div>
		</div>	
		<div class="row">

				<!--
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="9" class="active">Aniversariantes: <?php #echo $report->num_rows(); ?>/<?php #echo $total_rows; ?> </th>
						</tr>
					</tfoot>
				</table>
				-->
				<table class="table  table-condensed table-striped">
					<thead>
						<tr>
							<!--<th class="active">Prior.</th>-->
							<th class="active">Ver</th>
							<th class="active">Clientes - <?php echo $report->num_rows(); ?>/<?php echo $total_rows; ?></th>
							<th class="active">Aniv</th>
							<th class="active">Whats</th>
						</tr>
					</thead>

					
					<!--
						<a href="https://api.whatsapp.com/send?phone=55<?php echo $_SESSION['Cliente']['CelularCliente'];?>&text=" target="_blank" style="">
							<svg enable-background="new 0 0 512 512" width="30" height="30" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
						</a>
					-->
					
					
					<tbody>

						<?php
						$linha =  $per_page*$pagina;
						$count = 1;
						foreach ($report->result_array() as $row) {
							$contagem = $linha + $count;
							echo '<tr>';
							$url = base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'];
							#echo '<tr class="clickable-row" data-href="' . $url . '" data-original-title="' . $row['Idade'] . ' anos" data-container="body" data-toggle="tooltip" data-placement="center" title="">';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'tarefa/alterar/' . $row['idApp_Procedimento'] . '">';
								echo '<td class="notclickable" data-original-title="' . $row['Idade'] . ' anos" data-container="body" data-toggle="tooltip" data-placement="center" title="">
										<a class="btn btn-sm btn-info notclickable" href="' . base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
								#echo '<td>' . $contagem . '</td>';
								echo '<td>' . $row['NomeCliente'] . '</td>';
								echo '<td>' . $row['DataNascimento'] . '</td>';
								#echo '<td>' . $row['CelularCliente'] . '</td>';								
								echo '<td class="notclickable">
										' . $row['CelularCliente'] . '
										<a class="notclickable" href="https://api.whatsapp.com/send?phone=55'.$row['CelularCliente'].'&text=" target="_blank">
											<svg enable-background="new 0 0 512 512" width="20" height="20" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
											
										</a>
									</td>';
							echo '</tr>';
							$count++;
						}
						?>

					</tbody>

				</table>

			

		</div>

	</div>
</div>