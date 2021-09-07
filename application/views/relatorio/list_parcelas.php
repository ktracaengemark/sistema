<div class="panel panel-<?php echo $panel; ?>">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-2">
				<label for="DataFim">Resultado:</label>
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
					<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php echo $report->num_rows(); ?> / <?php echo $total_rows; ?>">
				</div>
			</div>	
			<div class="col-md-2">
				<label for="DataFim">
					<?php if($metodo == 2) {?>
						Recebido
					<?php }else{?>	
						Pago
					<?php } ?>	
				</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Recebido" value="<?php echo $report->soma->somarecebido ?>">
				</div>
			</div>
			<div class="col-md-2">
				<label for="DataFim">
					<?php if($metodo == 2) {?>
						à Receber
					<?php }else{?>		
						à Pagar
					<?php } ?>	
				</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total a Receber" value="<?php echo $report->soma->balanco ?>">
				</div>
			</div>
			<div class="col-md-2">
				<label for="DataFim"><?php #echo $titulo1; ?> Total:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total de Entradas" value="<?php echo $report->soma->somareceber ?>">
				</div>
			</div>	
		</div>	
		<div class="row">
			<div class="col-md-4 text-left">
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
				<?php if ($editar == 1) { ?>
					<?php if ($print == 1) { ?>	
						<div class="col-md-1">
							<label>Imprimir</label>
							<a href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
								<button class="btn btn-<?php echo $panel; ?> btn-md btn-block" type="button">
									<span class="glyphicon glyphicon-print"></span>
								</button>
							</a>
						</div>
					<?php } ?>
					<?php if ($_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
						<!--
						<div class="col-md-1">
							<label>Baixa</label>
							<a href="<?php echo base_url() . $alterarparc . $_SESSION['log']['idSis_Empresa']; ?>">
								<button class="btn btn-success btn-md btn-block" type="button">
									<span class="glyphicon glyphicon-edit"></span>
								</button>
							</a>
						</div>
						-->
					<?php } ?>	
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
						<th class="active">Imp.</th>
						<?php if ($_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
							<th class="active">Baixa</th>
						<?php } ?>
						<th class="active">Cont.</th>
						<th class="active">Pc</th>
						<th class="active">Pedido</th>
						<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
							<th class="col-md-2 active"><?php echo $nome; ?></th>
							<th class="active">Comb.Ent</th>
							<th class="active">Comb.Pag</th>
							<th class="active">Entr.</th>
							<th class="active">Pago.</th>
							<th class="active">Final.</th>
							<th class="active">Cancel.</th>
							<th class="active">Compra</th>
							<th class="active">Entrega</th>
							<th class="active">Pagam.</th>
						<?php } ?>
						<th class="active">Form.Pag.</th>
						<th class="active">DtPedido</th>
						<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
							<th class="active">DtEntrega</th>
						<?php } ?>
						<th class="active">Vencimento</th>
						<th class="active">Parc.R$</th>
						<th class="active">Quitada</th>
						<th class="active">Pagamento</th>
						<!--<th class="active">Dt.Pag</th>
						<th class="active">Recebido</th>
						<th class="active">Valor Recebido</th>
						<th class="active">Data do Orç.</th>
						<th class="active">Orç.</th>
						<th class="active">Prod. Entr.?</th>-->						
					</tr>
				</thead>
				<tbody>
					<?php
					$linha =  $per_page*$pagina;
					$count = 1;
					foreach ($report->result_array() as $row) {
						echo '<tr>';
						#echo '<tr class="clickable-row" data-href="' . base_url() . 'Orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">';
						#echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterarparcelarec/' . $row['idSis_Empresa'] . '">';
							
							/*echo '<td class="notclickable">
									<a class="btn btn-md btn-success notclickable" href="' . base_url() . 'Orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">
										<span class="glyphicon glyphicon-edit notclickable"></span>
									</a>
								</td>';								
							
							echo '<td class="notclickable">
									<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterarparcelarec/' . $row['idSis_Empresa'] . '">
										<span class="glyphicon glyphicon-edit notclickable"></span>
									</a>
								</td>';
							*/
							echo '<td class="notclickable">
									<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . $imprimir . $row['idApp_OrcaTrata'] . '">
										<span class="glyphicon glyphicon-print notclickable"></span>
									</a>
								</td>';
							if ($_SESSION['Usuario']['Bx_Pag'] == "S") {
								if($row['CanceladoOrca'] == "Não" && $row['Quitado'] == "Não"){	
									echo '<td class="notclickable">
											<a class="btn btn-md btn-success notclickable" href="' . base_url() . $edit . $row['idApp_Parcelas'] . '">
												<span class="glyphicon glyphicon-ok notclickable"></span>
											</a>
										</td>';
								}else{
									echo '<td class="notclickable">
											<a class="btn btn-md btn-danger notclickable">
												<span class="glyphicon glyphicon-ok notclickable"></span>
											</a>
										</td>';
								}
							}
							echo '<td>' . ($linha + $count) . '</td>';	
							echo '<td>' . $row['Parcela'] . '</td>';
							echo '<td>' . $row['idApp_OrcaTrata'] . '- ' . $row['TipoFinanceiro'] . ' - ' . $row['Descricao'] . '</td>';
							if($_SESSION['log']['idSis_Empresa'] != "5"){
								echo '<td>' . $row['Nome' . $nome] . '</td>';
								echo '<td>' . $row['CombinadoFrete'] . '</td>';
								echo '<td>' . $row['AprovadoOrca'] . '</td>';
								echo '<td>' . $row['ConcluidoOrca'] . '</td>';
								echo '<td>' . $row['QuitadoOrca'] . '</td>';
								echo '<td>' . $row['FinalizadoOrca'] . '</td>';
								echo '<td>' . $row['CanceladoOrca'] . '</td>';
								echo '<td>' . $row['Tipo_Orca'] . '</td>';
								echo '<td>' . $row['TipoFrete'] . '</td>';
								echo '<td>' . $row['AVAP'] . '</td>';
							}
							echo '<td>' . $row['FormaPag'] . '</td>';
							echo '<td>' . $row['DataOrca'] . '</td>';
							if($_SESSION['log']['idSis_Empresa'] != "5"){
								echo '<td>' . $row['DataEntregaOrca'] . '</td>';
							}
							echo '<td>' . $row['DataVencimento'] . '</td>';
							echo '<td class="text-left">' . $row['ValorParcela'] . '</td>';
							echo '<td>' . $row['Quitado'] . '</td>';
							echo '<td>' . $row['DataPago'] . '</td>';
							#echo '<td>' . $row['DataPago'] . '</td>';
							#echo '<td class="text-left">' . $row['ValorPago'] . '</td>';
							#echo '<td class="text-left">R$ ' . $row['ValorPago'] . '</td>';
							#echo '<td>' . $row['DataOrca'] . '</td>';
						echo '</tr>';
						$count++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
