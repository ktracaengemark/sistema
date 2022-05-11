<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">

	<div class="row">
		
		<div class="col-md-12">

			<div class="panel-heading text-center">
				<h2><?php echo '<strong>' . $_SESSION['Despesas']['NomeEmpresa'] . '</strong> - <strong>DEVOLUÇÃO</strong> - <strong>Nº: ' . $_SESSION['Despesas']['idApp_Despesas'] . '</strong>' ?></h2>
			</div>

			<div class="panel-body">				
				
				<hr />
				<?php echo '<h3>Orçam. Nº: ' . $_SESSION['Despesas']['idApp_OrcaTrata'] . ' - ' . $_SESSION['Despesas']['NomeCliente'] . '</h3>' ?>
				<hr />
				
				<h3 class="text-center">Produtos </h3>
				<hr />

				<table class="table table-bordered">
					<thead>
						<tr>							
							<!--<th scope="col">Nº</th>-->
							<th scope="col">id</th>
							<!--<th scope="col">idTab_Produto</th>
							<th scope="col">idTab_Produtos</th>
							<th scope="col">CodProd.</th>
							<th scope="col">CategProd.</th>-->
							<th scope="col">DescProd.</th>
							<th scope="col">Data</th>
						</tr>	
						<tr>
							<th scope="col"></th>
							<th scope="col">Qtd</th>
							<!--<th scope="col">Unidade</th>																				
							<th scope="col">Aux1</th>
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
							#echo $produto[$i]['QtdCompraProduto'];
						?>

						<tr>								
							<!--<td><?php echo $produto[$i]['idApp_Despesas'] ?></td>-->
							<td><?php echo $produto[$i]['idApp_ProdutoCompra'] ?></td>
							<!--<td><?php echo $produto[$i]['CodProd'] ?></td>
							<td><?php echo $produto[$i]['Prodaux3'] ?></td>
							<td><?php echo $produto[$i]['idTab_Produto'] ?></td>
							<td><?php echo $produto[$i]['idTab_Produtos'] ?></td>-->
							<td><?php echo $produto[$i]['NomeProduto'] ?></td>							
							<td><?php echo $produto[$i]['DataValidadeProduto'] ?></td>
						</tr>						
						<tr>
							<td></td>
							<td><?php echo $produto[$i]['QtdCompraProduto'] ?></td>
							<!--<td><?php echo $produto[$i]['UnidadeProduto'] ?></td>													
							<td><?php echo $produto[$i]['Prodaux1'] ?></td>
							<td><?php echo $produto[$i]['Prodaux2'] ?></td>-->
							<!--<td><?php echo $produto[$i]['Convenio'] ?></td>
							<td><?php echo $produto[$i]['Convdesc'] ?></td>-->
							<td><?php echo number_format($produto[$i]['ValorCompraProduto'], 2, ',', '.') ?></td>
							<td><?php echo $produto[$i]['SubtotalProduto'] ?></td>							
						</tr>

						<?php
						}
						?>

					</tbody>
				</table>
				
				<hr />
				<h3 class="text-center">Devolução & Forma de Pagam.</h3>
				<hr />				

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
							<td><?php echo number_format($despesas['ValorDespesas'], 2, ',', '.') ?></td>
							<td><?php echo number_format($despesas['ValorEntradaDespesas'], 2, ',', '.') ?></td>
							<td><?php echo number_format($despesas['ValorRestanteDespesas'], 2, ',', '.') ?></td>
						</tr>
					</tbody>
				</table>
			
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
							<td><?php echo $despesas['QtdParcelasDespesas'] ?></td>
							<td><?php echo $despesas['FormaPag'] ?></td>
							<td><?php echo $despesas['DataVencimentoDespesas'] ?></td>
						</tr>
					</tbody>
				</table>
				
				<hr />
				<h3 class="text-center">Parcelas</h3>
				<hr />

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
						for ($i=1; $i <= $despesas['QtdParcelasDespesas']; $i++) {
							#echo $produto[$i]['QtdCompraProduto'];
						?>

						<tr>
							<td><?php echo $parcelaspag[$i]['ParcelaPagaveis'] ?></td>
							<td><?php echo number_format($parcelaspag[$i]['ValorParcelaPagaveis'], 2, ',', '.') ?></td>
							<td><?php echo $parcelaspag[$i]['DataVencimentoPagaveis'] ?></td>
							<td><?php echo number_format($parcelaspag[$i]['ValorPagoPagaveis'], 2, ',', '.') ?></td>
							<td><?php echo $parcelaspag[$i]['DataPagoPagaveis'] ?></td>
							<td><?php echo $this->basico->mascara_palavra_completa($parcelaspag[$i]['QuitadoPagaveis'], 'NS') ?></td>
						</tr>

						<?php
						}
						?>

					</tbody>
				</table>
				
				<hr />
				<h3 class="text-center">Status da Devolução</h3>
				<hr />				

				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="col-md-4" scope="col">Devol. Aprovado?</th>
							<th class="col-md-4" scope="col">Prd Entregue?</th>
							<th class="col-md-4" scope="col">Devol. Quitado?</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $this->basico->mascara_palavra_completa($despesas['AprovadoDespesas'], 'NS') ?></td>
							<td><?php echo $this->basico->mascara_palavra_completa($despesas['ServicoConcluidoDespesas'], 'NS') ?></td>
							<td><?php echo $this->basico->mascara_palavra_completa($despesas['QuitadoDespesas'], 'NS') ?></td>
						</tr>
					</tbody>
				</table>

				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="col-md-4" scope="col">Data da Devolução</th>
							<th class="col-md-4" scope="col">Data da Conclusão</th>
							<th class="col-md-4" scope="col">Data do Retorno</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $despesas['DataDespesas'] ?></td>
							<td><?php echo $despesas['DataConclusaoDespesas'] ?></td>
							<td><?php echo $despesas['DataRetornoDespesas'] ?></td>
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

							<td><?php echo $despesas['ObsDespesas'] ?></td>
						</tr>
					</tbody>
				</table>

			</div>

		</div>
	</div>

</div>
