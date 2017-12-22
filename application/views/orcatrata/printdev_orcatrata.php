<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">

	<div class="row">
		<div class="col-md-12">

			<div class="panel-heading text-center">
				<h2 class="text-center">DEVOLUÇÃO / EXTORNO</h2>
			</div>

			<div class="panel-body">

				<hr />
				<?php echo '<h4>' . $_SESSION['Cliente']['NomeCliente'] . ' - Id: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</h4>' ?>
				<hr />

				<h3 class="text-center">Devolução & Produtos </h3>
				<hr />

				<table class="table table-bordered">
					<thead>
						<tr>
							<th scope="col">Nº</th>
							<th scope="col">id</th>
							<th scope="col">Qtd</th>
							<th scope="col">Unidade</th>
							<th scope="col">CodProd.</th>
							<th scope="col">CategProd.</th>
							<th scope="col">DescProd.</th>							
							<!--<th scope="col">Aux1</th>
							<th scope="col">Aux2</th>-->
							<!--<th scope="col">Tipo Venda</th>
							<th scope="col">Desc Venda</th>-->
							<th scope="col">Valor</th>
							<th scope="col">Subtotal</th>
						</tr>
					</thead>

					<tbody>

						<?php
						for ($i=1; $i <= $count['PCount']; $i++) {
							#echo $produto[$i]['QtdVendaProduto'];
						?>

						<tr>
							<td><?php echo $produto[$i]['idApp_OrcaTrata'] ?></td>
							<td><?php echo $produto[$i]['idApp_ProdutoVenda'] ?></td>
							<td><?php echo $produto[$i]['QtdVendaProduto'] ?></td>
							<td><?php echo $produto[$i]['UnidadeProduto'] ?></td>
							<td><?php echo $produto[$i]['CodProd'] ?></td>
							<td><?php echo $produto[$i]['Prodaux3'] ?></td>
							<td><?php echo $produto[$i]['NomeProduto'] ?></td>
							<!--<td><?php echo $produto[$i]['Prodaux1'] ?></td>
							<td><?php echo $produto[$i]['Prodaux2'] ?></td>-->
							<!--<td><?php echo $produto[$i]['Convenio'] ?></td>
							<td><?php echo $produto[$i]['Convdesc'] ?></td>-->
							<td><?php echo number_format($produto[$i]['ValorVendaProduto'], 2, ',', '.') ?></td>
							<td><?php echo $produto[$i]['SubtotalProduto'] ?></td>
						</tr>

						<?php
						}
						?>

					</tbody>
				</table>

				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="col-md-4" scope="col">Devolução</th>
							<th class="col-md-4" scope="col">Desconto</th>
							<th class="col-md-4" scope="col">Resta Pagar</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo number_format($orcatrata['ValorOrca'], 2, ',', '.') ?></td>
							<td><?php echo number_format($orcatrata['ValorEntradaOrca'], 2, ',', '.') ?></td>
							<td><?php echo number_format($orcatrata['ValorRestanteOrca'], 2, ',', '.') ?></td>
						</tr>
					</tbody>
				</table>

				<hr />
				<h3 class="text-center">Forma de Pagamento & Parcelas</h3>
				<hr />

				<table class="table table-bordered">
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

				<table class="table table-bordered">
					<thead>
						<tr>
							<th scope="col">Parcela</th>
							<th scope="col">Valor Parcela</th>
							<th scope="col">Data Venc. Parc</th>
							<th scope="col">Valor Pago</th>
							<th scope="col">Data Pag</th>
							<th scope="col">Quitado?</th>
						</tr>
					</thead>

					<tbody>

						<?php
						for ($i=1; $i <= $orcatrata['QtdParcelasOrca']; $i++) {
							#echo $produto[$i]['QtdVendaProduto'];
						?>

						<tr>
							<td><?php echo $parcelasrec[$i]['ParcelaRecebiveis'] ?></td>
							<td><?php echo number_format($parcelasrec[$i]['ValorParcelaRecebiveis'], 2, ',', '.') ?></td>
							<td><?php echo $parcelasrec[$i]['DataVencimentoRecebiveis'] ?></td>
							<td><?php echo number_format($parcelasrec[$i]['ValorPagoRecebiveis'], 2, ',', '.') ?></td>
							<td><?php echo $parcelasrec[$i]['DataPagoRecebiveis'] ?></td>
							<td><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$i]['QuitadoRecebiveis'], 'NS') ?></td>
						</tr>

						<?php
						}
						?>

					</tbody>
				</table>

				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="col-md-4" scope="col">Devol. Aprovado?</th>
							<th class="col-md-4" scope="col">Srv/Prd Entregue?</th>
							<th class="col-md-4" scope="col">Devol. Quitado?</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['AprovadoOrca'], 'NS') ?></td>
							<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['ServicoConcluido'], 'NS') ?></td>
							<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['QuitadoOrca'], 'NS') ?></td>
						</tr>
					</tbody>
				</table>

				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="col-md-4" scope="col">Data da Devolução</th>
							<th class="col-md-4" scope="col">Data da Entrega</th>
							<th class="col-md-4" scope="col">Data do Retorno</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $orcatrata['DataOrca'] ?></td>
							<td><?php echo $orcatrata['DataConclusao'] ?></td>
							<td><?php echo $orcatrata['DataRetorno'] ?></td>
						</tr>
					</tbody>
				</table>

				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="col-md-12" scope="col">Observações</th>
						</tr>
					</thead>
					<tbody>
						<tr>

							<td><?php echo $orcatrata['ObsOrca'] ?></td>
						</tr>
					</tbody>
				</table>

			</div>

		</div>
	</div>

</div>
