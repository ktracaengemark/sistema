<div class="panel panel-<?php echo $panel; ?>">
	<div class="panel-heading">
		<div class="row">	
			<!--
			<div class="col-md-2">
				<label for="DataFim">
					<?php if($metodo == 2) {?>
						Entregues
					<?php }else{?>	
						Recebidos
					<?php } ?>	
				</label>
				<div class="input-group">
					<input type="text" class="form-control" disabled aria-label="Total Recebido" value="<?php echo $report->soma->somaentregue ?>">
					<span class="input-group-addon">Srvs</span>
				</div>
			</div>
			<div class="col-md-2">
				<label for="DataFim">
					<?php if($metodo == 2) {?>
						à Entregar
					<?php }else{?>		
						à Receber
					<?php } ?>	
				</label>
				<div class="input-group">
					<input type="text" class="form-control" disabled aria-label="Total a Receber" value="<?php echo $report->soma->diferenca ?>">
					<span class="input-group-addon">Srvs</span>
				</div>
			</div>
			-->
			<div class="col-md-2">
				<label for="DataFim">SubTotal/Total</label>
				<div class="input-group">
					<input type="text" class="form-control" disabled aria-label="Total de Entradas" value="<?php echo $report->num_rows(); ?> / <?php echo $total_rows ?>">
					<span class="input-group-addon">Srvs</span>
				</div>
			</div>
			<div class="col-md-2">
				<label for="DataFim">SubTotal/Total</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total de Entradas" value="<?php echo $report->soma->Soma_valor_Total_Servicos ?> / <?php echo $pesquisa_query->soma2->somafinal2 ?>">
				</div>
			</div>
			<div class="col-md-2">
				<label for="DataFim">Comissão Total</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total de Entradas" value="<?php echo $report->soma->Soma_Valor_Com_Total ?> / <?php echo $pesquisa_query->soma2->Soma_Valor_Com_Total2 ?>">
				</div>
			</div>
			<div class="col-md-2">
				<label for="DataFim">Comissão Profis</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total de Entradas" value="<?php echo $report->soma->Soma_Valor_Com_Total_Prof ?> / <?php echo $pesquisa_query->soma2->Soma_Valor_Com_Total_Prof2 ?>">
				</div>
			</div>				
		</div>
		<div class="row">
			<?php if($paginacao == "S") { ?>
				<div class="col-md-2">
					<label>Filtros</label>
					<a href="<?php echo base_url() . $caminho; ?>">
						<button class="btn btn-warning btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-filter"></span>
						</button>
					</a>
				</div>	
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
				<?php } ?>
			<?php }else{?>	
				<div class="col-md-2">
					<label>Filtros</label>
					<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-filter"></span>
					</button>
				</div>				
			<?php } ?>
			<div class="col-md-2">
				<label>Baixa</label>
				<a href="<?php echo base_url() . $baixacomissao . $_SESSION['log']['idSis_Empresa']; ?>">
					<button class="btn btn-primary btn-md btn-block" type="button">
						<span class="glyphicon glyphicon-edit"></span>
					</button>
				</a>
			</div>
			<div class="col-md-4 text-left">
				<?php echo $pagination; ?>
			</div>			
		</div>
	</div>
</div>
<div style="overflow: auto; height: 550px; ">
	<div class="container-fluid">
		<div class="row">
			<div>
				<!--
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="3" class="active"><?php #echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>
				-->
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<th class="active">Imp.</th>
							<!--<th class="active">Baixa</th>-->
							<th class="active">Cont.</th>
							<th class="active">Pedido</th>
							<!--<th class="active">DtPedido</th>-->
							<th class="active">DataEntr.</th>
							<th class="active">Entregue</th>
							<th class="col-md-2 active"><?php echo $nome; ?></th>
							<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
								<th class="active">Pet</th>
							<?php }else{ ?>
								<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
									<th class="active">Dep</th>
								<?php } ?>
							<?php } ?>
							<th class="active">Qtd</th>
							<th class="active">Recor</th>
							<th class="active">Produto</th>
							<th class="active">ValorR$</th>
							<th class="active">Profissional_1.</th>
							<!--<th class="active">Com1.</th>-->
							<th class="active">Profissional_2.</th>
							<!--<th class="active">Com2.</th>-->
							<th class="active">Profissional_3.</th>
							<!--<th class="active">Com3.</th>-->
							<th class="active">Profissional_4.</th>
							<!--<th class="active">Com4.</th>-->
							<th class="active">ValorTotal.</th>
							<th class="active">ValorProf.</th>
							<!--<th class="active">NºProf.</th>-->
							<th class="active">StatusCom</th>
							<th class="active">DataPago.</th>
							<!--<th class="active">HoraEntr.</th>-->					
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

								echo '<td class="notclickable">
										<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . $imprimir . $row['idApp_OrcaTrata'] . '">
										<span class="glyphicon glyphicon-print notclickable"></span>
										</a>
									</td>';

								echo '<td>' . ($linha + $count) . '/' . $total_rows . '</td>';
								echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
								#echo '<td>' . $row['DataOrca'] . '</td>';
								echo '<td>' . $row['DataConcluidoProduto'] . '</td>';
								echo '<td>' . $row['ConcluidoProduto'] . '</td>';
								echo '<td>' . $row['Nome' . $nome] . '</td>';
								if($_SESSION['Empresa']['CadastrarPet'] == "S"){
									echo '<td>' . $row['NomeClientePet'] . '</td>';
								}else{
									if($_SESSION['Empresa']['CadastrarDep'] == "S"){
										echo '<td>' . $row['NomeClienteDep'] . '</td>';
									}
								}
								echo '<td class="text-left">' . $row['QtdProduto'] . '</td>';
								echo '<td>' . $row['RecorrenciaOrca'] . '</td>';
								echo '<td class="text-left">' . $row['NomeProduto'] . '</td>';
								echo '<td class="text-left">R$' . $row['ValorTotalProduto'] . '</td>';
								echo '<td>' . $row['Abrev1'] . ' | ' . $row['Nome1'] . ' | ' . $row['ComFunProf_1'] . '% | R$' . $row['ValorComProf_1'] . '</td>';
								echo '<td>' . $row['Abrev2'] . ' | ' . $row['Nome2'] . ' | ' . $row['ComFunProf_2'] . '% | R$' . $row['ValorComProf_2'] . '</td>';
								echo '<td>' . $row['Abrev3'] . ' | ' . $row['Nome3'] . ' | ' . $row['ComFunProf_3'] . '% | R$' . $row['ValorComProf_3'] . '</td>';
								echo '<td>' . $row['Abrev4'] . ' | ' . $row['Nome4'] . ' | ' . $row['ComFunProf_4'] . '% | R$' . $row['ValorComProf_4'] . '</td>';
								echo '<td>R$' . $row['Valor_Com_Total'] . '</td>';
								echo '<td>R$' . $row['Valor_Com_Total_Prof'] . '</td>';
								//echo '<td class="text-left">/ ' . $row['Contagem'] . '</td>';
								echo '<td>' . $row['StatusComissaoServico'] . '</td>';
								echo '<td>' . $row['DataPagoComissaoServico'] . '</td>';
								//echo '<td>' . $row['HoraConcluidoProduto'] . '</td>';
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