<div class="panel panel-<?php echo $panel; ?>">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-2">
				<label for="DataFim">Cont: Parc / Total111</label>
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
					<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php echo $report->num_rows(); ?> / <?php echo $total_rows; ?>">
				</div>
			</div>
			<div class="col-md-3 text-left">
				<?php echo $pagination; ?>
			</div>
			<?php if($paginacao == "S") { ?>
				<div class="col-md-1">
					<label>Filtros</label>
					<a href="<?php echo base_url() . $caminho; ?>">
						<button class="btn btn-warning btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-filter"></span>
						</button>
					</a>
				</div>
			<?php }else{ ?>
				<div class="col-md-1">
					<label>Filtros</label>
					<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-filter"></span>
					</button>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
	

<div class="container-fluid">
	<div class="row">
		<div style="overflow: auto; height: 550px; ">
			<table class="table table-bordered table-condensed table-striped">
				<thead>						
					<tr>
						<th class="active">Pdd|Ct</th>
						<th class="active"><?php echo $nome ?></th>
						<th class="active">DtPedido</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$linha =  $per_page*$pagina;
					$count = 1;
					foreach ($report->result_array() as $row) {

					?>
						<tr>
							<td><?php echo $row['idApp_OrcaTrata'];?> - <?php echo ($linha + $count);?></td>
							<td class="notclickable">
								<?php echo $row['NomeCliente']; ?>
							</td>	
							<?php echo '<td>' . $row['DataOrca'] . '</td>';?>	
						</tr>
					<?php	
						$count++;
					}
					?>
				</tbody>

			</table>
		</div>
	</div>
</div>
<!--<div class="text-left"><?php #echo $pagination; ?></div>-->