<div class="panel panel-<?php echo $panel; ?>">
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 text-left">
						<label for="DataFim">Cont: Parc / Total</label>
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
							<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php echo $report->num_rows(); ?> / <?php echo $total_rows; ?>">
						</div>
					</div>
					<?php if($_SESSION['Usuario']['Rel_Pag'] == "S") {?>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-left">
							<label for="DataFim">Prod + Serv:</label>
							<div class="input-group">
								<span class="input-group-addon">R$</span>
								<input type="text" class="form-control" disabled aria-label="Orcamento" value="<?php echo $report->soma->somarestante ?> / <?php echo $pesquisa_query->soma2->somarestante2 ?>">
							</div>
						</div>
					<?php } ?>
					<?php if($_SESSION['Usuario']['Rel_Com'] == "S") {?>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-left">
							<label for="DataFim">Com: Parc / Total</label>
							<div class="input-group">
								<span class="input-group-addon">R$</span>
								<input type="text" class="form-control" disabled aria-label="Comissao" value="<?php echo $report->soma->somacomissao ?> / <?php echo $pesquisa_query->soma2->somacomissao2 ?>">
							</div>
						</div>
					<?php } ?>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-left">
						<?php echo $pagination; ?>
					</div>
				</div>	
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
				<div class="row">		
					<?php if($paginacao == "S") { ?>
						<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
							<label>Filtros</label>
							<a href="<?php echo base_url() . $caminho; ?>">
								<button class="btn btn-warning btn-md btn-block" type="button">
									<span class="glyphicon glyphicon-filter"></span>
								</button>
							</a>
						</div>
					<?php }else{ ?>
						<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
							<label>Filtros</label>
							<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					<?php } ?>
					<?php if($_SESSION['Usuario']['Nivel'] != 2 && $_SESSION['Usuario']['Permissao_Comissao'] == 3) {?>
						<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
							<label>Excel</label><br>
							<a href="<?php echo base_url() . 'gerar_excel/Comissao/Comissao_xls.php'; ?>">
								<button type='button' class='btn btn-md btn-success btn-block'>
									C/<span class="glyphicon glyphicon-filter"></span>
								</button>
							</a>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
							<label>Lista</label>
							<a href="<?php echo base_url() . $imprimirlista; ?>">
								<button class="btn btn-<?php echo $panel; ?> btn-md btn-block" type="button">
									<span class="glyphicon glyphicon-list"></span>
								</button>
							</a>
						</div>
						<?php 
							$exibir_baixa = FALSE;
							$exibir_ajuste = FALSE;
							$exibir_antigas = FALSE;
							if(isset($total_rows) && $total_rows >= 1) { 
								if(isset($_SESSION['FiltroComissao']['id_Funcionario']) && $_SESSION['FiltroComissao']['id_Funcionario'] != 0){
									if(!isset($_SESSION['FiltroComissao']['id_Comissao']) || $_SESSION['FiltroComissao']['id_Comissao'] == 0){
										if(isset($_SESSION['FiltroComissao']['StatusComissaoOrca']) && $_SESSION['FiltroComissao']['StatusComissaoOrca'] == "S"){
											if(isset($_SESSION['FiltroComissao']['Recibo']) && $_SESSION['FiltroComissao']['Recibo'] == 2){
												$exibir_antigas = TRUE;
											}	
										}elseif(isset($_SESSION['FiltroComissao']['StatusComissaoOrca']) && $_SESSION['FiltroComissao']['StatusComissaoOrca'] == "N"){
											
												$exibir_baixa = TRUE;
											
										}else{
											
										}
									}else{
										
									}
								}else{
									if(!isset($_SESSION['FiltroComissao']['id_Comissao']) || $_SESSION['FiltroComissao']['id_Comissao'] == 0){
										if(isset($_SESSION['FiltroComissao']['StatusComissaoOrca']) && $_SESSION['FiltroComissao']['StatusComissaoOrca'] == "S"){
											if(isset($_SESSION['FiltroComissao']['Recibo']) && $_SESSION['FiltroComissao']['Recibo'] == 2){
												$exibir_antigas = TRUE;
											}	
										}elseif(isset($_SESSION['FiltroComissao']['StatusComissaoOrca']) && $_SESSION['FiltroComissao']['StatusComissaoOrca'] == "N"){
											
											
										}else{
											
										}
									}else{
										
									}
								}
								if(isset($_SESSION['FiltroComissao']['id_Comissao']) && $_SESSION['FiltroComissao']['id_Comissao'] != 0){
									$exibir_ajuste = TRUE;
								}else{
									if(isset($_SESSION['FiltroComissao']['StatusComissaoOrca']) && $_SESSION['FiltroComissao']['StatusComissaoOrca'] == "S"){
										if(isset($_SESSION['FiltroComissao']['Recibo']) && $_SESSION['FiltroComissao']['Recibo'] == 2){
											$exibir_antigas = TRUE;
										}	
									}
								}
							}	
						?>
						<?php if(isset($exibir_baixa) && $exibir_baixa == TRUE) { ?>
							<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
								<label>Baixa</label>
								<a href="<?php echo base_url() . $baixatodas . $_SESSION['log']['idSis_Empresa']; ?>">
									<button class="btn btn-danger btn-md btn-block" type="button">
										<span class="glyphicon glyphicon-ok"></span>
									</button>
								</a>
							</div>
						<?php } ?>
						<?php if(isset($exibir_ajuste) && $exibir_ajuste == TRUE) { ?>
							<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
								<label>Ajuste</label>
								<a href="<?php echo base_url() . $ajuste . $_SESSION['log']['idSis_Empresa']; ?>">
									<button class="btn btn-danger btn-md btn-block" type="button">
										<span class="glyphicon glyphicon-ok"></span>
									</button>
								</a>
							</div>
						<?php } ?>
						<?php if(isset($exibir_antigas) && $exibir_antigas == TRUE) { ?>
							<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
								<label>Ajustar Antigas</label>
								<a href="<?php echo base_url() . $antigas . $_SESSION['log']['idSis_Empresa']; ?>">
									<button class="btn btn-danger btn-md btn-block" type="button">
										<span class="glyphicon glyphicon-ok"></span>
									</button>
								</a>
							</div>
						<?php } ?>
					<?php } ?>
				</div>	
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div style="overflow: auto; height: auto; ">
			<table class="table table-bordered table-condensed table-striped">
				<thead>						
					<tr>
						<th class="active">Cont.</th>
						<th class="active">Imp.</th>
						<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
							<?php if($_SESSION['Usuario']['Nivel'] != 2) { ?>
								<th class="active">Editar</th>
							<?php } ?>
						<?php } ?>
						<th class="active">Pdd|Tp</th>
						<th class="active">DtPedido</th>
						<th class="active">Receita</th>
						<th class="active"><?php echo $nome ?></th>
						<th class="active">Cb.Ent</th>
						<th class="active">Cb.Pag</th>
						<th class="active">Entr.</th>
						<th class="active">Pago</th>
						<th class="active">Final.</th>
						<th class="active">Canc.</th>
						<th class="active">Pagam.</th>
						<th class="active">Form.Pag.</th>
						<?php if($_SESSION['Usuario']['Rel_Pag'] == "S") {?>
							<th class="active">Prd/Srv</th>
						<?php } ?>	
						<th class="active">Func/Vendeu</th>
						<th class="active">Comissao</th>
						<th class="active">Paga?</th>
						<th class="active">DataPago</th>
						<th class="active">Recibo</th>	
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 1;
					foreach ($report->result_array() as $row) {
					?>
						<tr>
							<td><?php echo ($linha + $count);?></td>
							<td class="notclickable">
								<a class="btn btn-md btn-<?php echo $panel;?> notclickable" href="<?php echo base_url() . $imprimir . $row['idApp_OrcaTrata']; ?>">
									<span class="glyphicon glyphicon-print notclickable"></span>
								</a>
							</td>
							<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
								<?php if($_SESSION['Usuario']['Nivel'] != 2) { ?>
									<td class="notclickable">
										<a class="btn btn-md btn-warning notclickable" href="<?php echo base_url() . $edit . $row['idApp_OrcaTrata'];?>">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>
								<?php } ?>
							<?php } ?>
							<td><?php echo $row['idApp_OrcaTrata'];?> - <?php echo $row['TipoFinanceiro'];?></td>
							<?php echo '<td>' . $row['DataOrca'] . '</td>';?>	
							<?php echo '<td>' . $row['Tipo_Orca'] . '</td>';?>
							<td class="notclickable">
								<?php echo $row['Nome'.$nome]; ?>
							</td>
							<?php echo '<td>' . $row['CombinadoFrete'] . '</td>';?>	
							<?php echo '<td>' . $row['AprovadoOrca'] . '</td>';?>	
							<?php echo '<td>' . $row['ConcluidoOrca'] . '</td>';?>	
							<?php echo '<td>' . $row['QuitadoOrca'] . '</td>';?>	
							<?php echo '<td>' . $row['FinalizadoOrca'] . '</td>';?>	
							<?php echo '<td>' . $row['CanceladoOrca'] . '</td>';?>
							<?php echo '<td>' . $row['AVAP'] . '</td>';?>	
							<?php echo '<td>' . $row['FormaPag'] . '</td>';?>
							<?php if($_SESSION['Usuario']['Rel_Pag'] == 'S') { ?>
								<td><?php echo $row['ValorRestanteOrca'] ?></td>
							<?php } ?>
							<?php echo '<td>' . $row[$nomeusuario] . '</td>';?>
							<?php echo '<td>' . $row['ValorComissao'] . '</td>';?>
							<?php echo '<td>' . $row[$status] . '</td>';?>
							<?php echo '<td>' . $row['DataPagoComissaoOrca'] . '</td>';?>
							<?php echo '<td>' . $row['id_Comissao'] . '</td>';?>	
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