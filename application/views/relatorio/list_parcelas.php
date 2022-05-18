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
					<input type="text" class="form-control" disabled aria-label="Total de Entradas" value="<?php echo $report->soma->somareceber ?> / <?php echo $pesquisa_query->soma2->somaparcelas2 ?>">
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
				<?php if ($_SESSION['log']['idSis_Empresa'] == 5) { ?>
					<div class="col-md-1">
						<label>Baixa</label>
						<a href="<?php echo base_url() . $alterarparc . $_SESSION['log']['idSis_Empresa']; ?>">
							<button class="btn btn-danger btn-md btn-block" type="button">
								<span class="glyphicon glyphicon-edit"></span>
							</button>
						</a>
					</div>
				<?php }else{ ?>
					<?php if ($_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
						<div class="col-md-1">
							<label>Baixa</label>
							<a href="<?php echo base_url() . $alterarparc . $_SESSION['log']['idSis_Empresa']; ?>">
								<button class="btn btn-danger btn-md btn-block" type="button">
									<span class="glyphicon glyphicon-edit"></span>
								</button>
							</a>
						</div>
					<?php } ?>
					<?php if ($print == 1) { ?>	
						<div class="col-md-1">
							<label>Imprimir</label>
							<a href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
								<button class="btn btn-info btn-md btn-block" type="button">
									<span class="glyphicon glyphicon-print"></span>
								</button>
							</a>
						</div>
					<?php } ?>
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
						<?php if($_SESSION['log']['idSis_Empresa'] == "5") {?>
							<th class="active">Baixa</th>
						<?php }else{ ?>
							<?php if ($_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
								<th class="active">Baixa</th>
							<?php } ?>
						<?php } ?>	
						<th class="active">Pdd|Tp|Ct</th>
						<th class="active">Pc</th>
						<!--<th class="active">Pedido</th>-->
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
						<th class="active">Parc.R$</th>
						<th class="active">Quitada</th>
						<th class="active">Vencimento</th>
						<th class="active">Pagamento</th>
						<th class="active">Lancamento</th>
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
							if ($_SESSION['log']['idSis_Empresa'] == 5) {
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
							}else{	
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
							}	
							echo '<td>' . $row['idApp_OrcaTrata'] . ' - ' . $row['TipoFinanceiro'] . ' - ' . $row['Descricao'] . ' - ' . ($linha + $count) . '</td>';	
							echo '<td>' . $row['Parcela'] . '</td>';
							//echo '<td>' . $row['idApp_OrcaTrata'] . '- ' . $row['TipoFinanceiro'] . ' - ' . $row['Descricao'] . '</td>';
							if($_SESSION['log']['idSis_Empresa'] != "5"){
							
								if(isset($_SESSION['FiltroAlteraParcela']['nomedo' . $nome]) && $_SESSION['FiltroAlteraParcela']['nomedo' . $nome] == "S") {
									$nomedo_ = $row[$nome];
								}else{
									$nomedo_ = FALSE;
								}
								
								if(isset($_SESSION['FiltroAlteraParcela']['numerodopedido']) && $_SESSION['FiltroAlteraParcela']['numerodopedido'] == "S") {
									$numerodopedido = '*'.$row['idApp_OrcaTrata'].'*';
								}else{
									$numerodopedido = FALSE;
								}
								
								if($metodo == 1 || $metodo == 2) {
									$whatsapp = '<a class="notclickable" href="https://api.whatsapp.com/send?phone=55'.$row['Celular' . $nome].'&text='.$_SESSION['FiltroAlteraParcela']['Texto1'].' '.$nomedo_.' '.$_SESSION['FiltroAlteraParcela']['Texto2'].' '.$numerodopedido.' '.$_SESSION['FiltroAlteraParcela']['Texto3'].'  " target="_blank">
													<svg enable-background="new 0 0 512 512" width="20" height="20" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
												</a>';
								}else{
									$whatsapp = FALSE;
								}
															
								echo '<td>' . $row['Nome' . $nome] . ' '.$whatsapp.'</td>';
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
							echo '<td class="text-left">' . $row['ValorParcela'] . '</td>';
							echo '<td>' . $row['Quitado'] . '</td>';
							echo '<td>' . $row['DataVencimento'] . '</td>';
							echo '<td>' . $row['DataPago'] . '</td>';
							echo '<td>' . $row['DataLanc'] . '</td>';
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
