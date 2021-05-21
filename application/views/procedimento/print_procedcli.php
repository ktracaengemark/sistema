<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">

	<div class="row">
		
		<div class="col-md-12">

			<div class="panel-heading text-center">
				<h3><?php echo '<strong>' . $_SESSION['Cliente']['NomeEmpresa'] . '</strong> - <strong>ORÇAMENTO</strong> - <strong>Nº: ' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . '</strong>' ?></h3>
			</div>

			<div class="panel-body">

				<hr />
				<?php echo '<h4>Cliente(a): ' . $_SESSION['Cliente']['NomeCliente'] . ' - Id: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</h4>' ?>
				<hr />

				<h3 class="text-center">Produtos Entregues </h3>

				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<!--<th scope="col">Nº</th>-->
							<th class="col-md-1" scope="col">Qtd</th>																				
							<!--<th scope="col">CodProd.</th>
							<th scope="col">CategProd.</th>-->												
							<th class="col-md-9" scope="col">DescProd.</th>							
							<th class="col-md-1" scope="col">Valor</th>
							<th class="col-md-1" scope="col">Subtotal</th>
						</tr>	
						<tr>
							<th class="col-md-1" scope="col"></th>
							<th class="col-md-9" scope="col">id</th>	
							<!--<th scope="col">Unidade</th>																				
							<th scope="col">Aux1</th>
							<th scope="col">Aux2</th>-->
							<!--<th scope="col">Tipo Venda</th>
							<th scope="col">Desc Venda</th>-->
							<th class="col-md-1" scope="col">Data</th>							
						</tr>
					</thead>

					<tbody>

						<?php
						for ($i=1; $i <= $count['PCount']; $i++) {
							#echo $produto[$i]['QtdVendaProduto'];
						?>

						<tr>
							<!--<td><?php echo $produto[$i]['idApp_OrcaTrata'] ?></td>-->
							<td><?php echo $produto[$i]['QtdVendaProduto'] ?></td>														
							<!--<td><?php echo $produto[$i]['CodProd'] ?></td>
							<td><?php echo $produto[$i]['Prodaux3'] ?></td>-->					
							<td><?php echo $produto[$i]['NomeProduto'] ?></td>							
							<td><?php echo number_format($produto[$i]['ValorVendaProduto'], 2, ',', '.') ?></td>
							<td><?php echo $produto[$i]['SubtotalProduto'] ?></td>
						</tr>						
						<tr>
							<td></td>
							<td><?php echo $produto[$i]['idApp_ProdutoVenda'] ?></td>
							<!--<td><?php echo $produto[$i]['UnidadeProduto'] ?></td>														
							<td><?php echo $produto[$i]['Prodaux1'] ?></td>
							<td><?php echo $produto[$i]['Prodaux2'] ?></td>-->
							<!--<td><?php echo $produto[$i]['Convenio'] ?></td>
							<td><?php echo $produto[$i]['Convdesc'] ?></td>-->
							<td><?php echo $produto[$i]['DataValidadeProduto'] ?></td>							
						</tr>

						<?php
						}
						?>

					</tbody>
				</table>
				<hr />
				
				<h3 class="text-center">Produtos Devolvidos  </h3>

				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<!--<th scope="col">Nº</th>-->
							<th class="col-md-1" scope="col">Qtd</th>																				
							<!--<th scope="col">CodProd.</th>
							<th scope="col">CategProd.</th>-->												
							<th class="col-md-9" scope="col">DescProd.</th>							
							<th class="col-md-1" scope="col">Valor</th>
							<th class="col-md-1" scope="col">Subtotal</th>
						</tr>	
						<tr>
							<th class="col-md-1" scope="col"></th>
							<th class="col-md-9" scope="col">id</th>	
							<!--<th scope="col">Unidade</th>																				
							<th scope="col">Aux1</th>
							<th scope="col">Aux2</th>-->
							<!--<th scope="col">Tipo Venda</th>
							<th scope="col">Desc Venda</th>-->
							<th class="col-md-1" scope="col">Data</th>							
						</tr>
					</thead>

					<tbody>

						<?php
						for ($i=1; $i <= $count['SCount']; $i++) {
							#echo $produto[$i]['QtdVendaProduto'];
						?>

						<tr>
							<!--<td><?php echo $servico[$i]['idApp_OrcaTrata'] ?></td>-->
							<td><?php echo $servico[$i]['QtdVendaServico'] ?></td>														
							<!--<td><?php echo $servico[$i]['CodProd'] ?></td>
							<td><?php echo $servico[$i]['Prodaux3'] ?></td>-->					
							<td><?php echo $servico[$i]['NomeServico'] ?></td>							
							<td><?php echo number_format($servico[$i]['ValorVendaServico'], 2, ',', '.') ?></td>
							<td><?php echo $servico[$i]['SubtotalServico'] ?></td>
						</tr>						
						<tr>
							<td></td>
							<td><?php echo $servico[$i]['idApp_ServicoVenda'] ?></td>
							<!--<td><?php echo $servico[$i]['UnidadeProduto'] ?></td>														
							<td><?php echo $servico[$i]['Prodaux1'] ?></td>
							<td><?php echo $servico[$i]['Prodaux2'] ?></td>-->
							<!--<td><?php echo $servico[$i]['Convenio'] ?></td>
							<td><?php echo $servico[$i]['Convdesc'] ?></td>-->
							<td><?php echo $servico[$i]['DataValidadeServico'] ?></td>							
						</tr>

						<?php
						}
						?>

					</tbody>
				</table>
				
				<hr />
				<h3 class="text-center">Orçamento, Devolução & Forma de Pagam.</h3>

				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<th class="col-md-4" scope="col">Orçamento</th>
							<th class="col-md-4" scope="col">Devolução</th>
							<th class="col-md-4" scope="col">Valor</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo number_format($orcatrata['ValorOrca'], 2, ',', '.') ?></td>
							<td><?php echo number_format($orcatrata['ValorDev'], 2, ',', '.') ?></td>
							<td><?php echo number_format($orcatrata['ValorRestanteOrca'], 2, ',', '.') ?></td>
						</tr>
					</tbody>

					<thead>
						<tr>
							<th class="col-md-4" scope="col">Qtd Parc.</th>
							<th class="col-md-4" scope="col">Forma de Pagam.</th>
							<th class="col-md-4" scope="col">1º Venc.</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $orcatrata['QtdParcelasOrca'] ?></td>
							<td><?php echo $orcatrata['FormaPag'] ?></td>
							<td><?php echo $orcatrata['DataVencimentoOrca'] ?></td>
						</tr>
					</tbody>
				</table>
				
				<hr />
				<h3 class="text-center">Parcelas</h3>

				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<th class="col-md-2" scope="col">Parcela</th>
							<th class="col-md-2" scope="col">Venc</th>
							<!--<th class="col-md-2" scope="col">Data Venc. Parc</th>-->
							<th class="col-md-2" scope="col">Pago</th>
							<!--<th class="col-md-2" scope="col">Data Pag</th>
							<th class="col-md-2" scope="col">Quitado?</th>-->
						</tr>
					</thead>

					<tbody>

						<?php
						for ($i=1; $i <= $count['PRCount']; $i++) {
							#echo $produto[$i]['QtdVendaProduto'];
						?>

						<tr>
							<td><?php echo $parcelasrec[$i]['ParcelaRecebiveis'] ?> Qt.<?php echo $this->basico->mascara_palavra_completa($parcelasrec[$i]['QuitadoRecebiveis'], 'NS') ?></td>
							<td><?php echo $parcelasrec[$i]['DataVencimentoRecebiveis'] ?> R$<?php echo number_format($parcelasrec[$i]['ValorParcelaRecebiveis'], 2, ',', '.') ?></td>
							<!--<td><?php echo $parcelasrec[$i]['DataVencimentoRecebiveis'] ?></td>-->
							<td><?php echo $parcelasrec[$i]['DataPagoRecebiveis'] ?> R$<?php echo number_format($parcelasrec[$i]['ValorPagoRecebiveis'], 2, ',', '.') ?></td>
							<!--<td><?php echo $parcelasrec[$i]['DataPagoRecebiveis'] ?></td>
							<td><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$i]['QuitadoRecebiveis'], 'NS') ?></td>-->
						</tr>

						<?php
						}
						?>

					</tbody>
				</table>

				<hr />
				<h3 class="text-center">Status do Orçamento</h3>
				
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<th class="col-md-4" scope="col">Aprovado?</th>
							<th class="col-md-4" scope="col">Concluído?</th>
							<th class="col-md-4" scope="col">Quitado?</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['AprovadoOrca'], 'NS') ?></td>
							<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['ServicoConcluido'], 'NS') ?></td>
							<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['QuitadoOrca'], 'NS') ?></td>
						</tr>
					</tbody>

					<thead>
						<tr>
							<th class="col-md-4" scope="col">Data do Orçamento</th>
							<th class="col-md-4" scope="col">Data da Conclusão</th>
							<th class="col-md-4" scope="col">Data do Quitação</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $orcatrata['DataOrca'] ?></td>
							<td><?php echo $orcatrata['DataConclusao'] ?></td>
							<td><?php echo $orcatrata['DataQuitado'] ?></td>
						</tr>
					</tbody>
				</table>

				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<th class="col-md-8" scope="col">Observações</th>
							<th class="col-md-4" scope="col">Data do Retorno</th>
						</tr>
					</thead>
					<tbody>
						<tr>

							<td><?php echo $orcatrata['ObsOrca'] ?></td>
							<td><?php echo $orcatrata['DataRetorno'] ?></td>
						</tr>
					</tbody>
				</table>

			</div>

		</div>
	</div>

</div>
