<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">	
			<?php if ($nav_secundario) echo $nav_secundario; ?>
			<?php if ($msg) {?>
				<div class="row">
					<div class="col-md-12 ">
						<?php echo $msg; ?>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<?php echo validation_errors(); ?>
					<?php 
						if($_SESSION['log']['idSis_Empresa'] != 5) {
							$none = '';
						}else{
							$none = 'none';
						}
					?>
					<div style="overflow: auto; height: auto; ">		
						<?php if($metodo == 1) { ?>
							<div class="row">	
								<div class="panel panel-info">
									<div class="panel-heading">
										<table class="table table-condensed table-striped">
											<tbody>
												<tr>
													<td class="col-md-4 text-center" scope="col"><img alt="User Pic" src="<?php echo base_url() . '../'.$orcatrata['Site'].'/' . $orcatrata['idSis_Empresa'] . '/documentos/miniatura/' . $orcatrata['Arquivo'] . ''; ?>" class="img-responsive" width='200'></td>
													<td class="col-md-8 text-center" scope="col">
														<h3><?php echo '<strong>' . $query['NomeEmpresa'] . '</strong>' ?></h3>
														<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>	
															<h4>CNPJ:<?php echo '<strong>' . $orcatrata['Cnpj'] . '</strong>' ?></h4>
															<h4>Endereço:<?php echo '<small>' . $orcatrata['EnderecoEmpresa'] . '</small> <small>' . $orcatrata['NumeroEmpresa'] . '</small> <small>' . $orcatrata['ComplementoEmpresa'] . '</small><br>
																					<small>' . $orcatrata['BairroEmpresa'] . '</small> - <small>' . $orcatrata['MunicipioEmpresa'] . '</small> - <small>' . $orcatrata['EstadoEmpresa'] . '</small><br><strong>Tel: </strong>'  . $orcatrata['Telefone'] ?></h4>
														<?php } ?>	
														<h5>Colab.:<?php 
																		if(isset($usuario)){
																			$colaborador = $usuario['Nome'];
																		}else{
																			$colaborador = "O Cliente";
																		} echo '<strong>' . $colaborador . '</strong>'
																	?>
														</h5>
																						
														
														<h4 class="text-center">
															Receita
															<?php
																if($query['Tipo_Orca'] == "B"){
																	echo ' - <strong>' . $query['idApp_OrcaTrata'] . '</strong> - Balcão';
																}elseif($query['Tipo_Orca'] == "O"){
																	echo ' - <strong>' . $query['idApp_OrcaTrata'] . '</strong> - Online';
																}
															?> 
														</h4>
													</td>
												</tr>
											</tbody>
										</table>
											
										<div class="panel-body">
											<div class="row">
												<?php if($orcatrata['idApp_Cliente'] != 0) { ?>								
													<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">	
														<h3 class="text-left">
															<b>Cliente</b>: <?php echo '' . $cliente['NomeCliente'] . '' ?>
														</h3>
														<h5 class="text-left"><b>Tel</b>: <?php echo '' . $cliente['CelularCliente'] . '' ?> - <b>ID</b>: <?php echo '' . $cliente['idApp_Cliente'] . '' ?> </h5>
													</div>
												<?php }?>
												<?php if($orcatrata['idApp_ClientePet'] != 0) { ?>								
													<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">	
														<h3 class="text-left">
															<b>Pet</b>: <?php echo '' . $clientepet['NomeClientePet'] . '' ?>
														</h3>
													</div>
												<?php } ?>
												<?php if($orcatrata['idApp_ClienteDep'] != 0) { ?>								
													<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">	
														<h3 class="text-left">
															<b>Dep</b>: <?php echo '' . $clientedep['NomeClienteDep'] . '' ?>
														</h3>
													</div>
												<?php } ?>	
												<?php if(isset($Campanha)) { ?>	
													<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
														<h3 class="text-left" style="color:#FF0000"><?php echo $Campanha['Campanha2'];?></h3>
													</div>
												<?php }?>
											</div>
											<table class="table table-bordered table-condensed table-striped">
												<thead>
													<tr>
														<th class="col-md-2" scope="col">Tipo</th>
														<th class="col-md-2" scope="col">Data</th>
														<th class="col-md-8" scope="col">Desc.</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><?php echo $orcatrata['TipoFinanceiro'] ?></td>
														<td><?php echo $orcatrata['DataOrca'] ?></td>
														<td><?php echo $orcatrata['Descricao'] ?></td>
													</tr>
												</tbody>
											</table>
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>	
												<?php if( isset($count['PCount']) ) { ?>
												<h3 class="text-left"><b>Produtos</b></h3>

												<table class="table table-bordered table-condensed table-striped">
													<thead>
														<tr>
															<th class="col-md-1" scope="col">Qtd</th>												
															<th class="col-md-9" scope="col">Produto</th>
															<th class="col-md-1" scope="col">Subtotal</th>
															<th class="col-md-1" scope="col">Data</th>
														</tr>
													</thead>

													<tbody>

														<?php
														for ($i=1; $i <= $count['PCount']; $i++) {
															#echo $produto[$i]['QtdProduto'];
														?>

														<tr>
															<td class="col-md-1" scope="col">
																<h4>
																	<b>
																		<?php echo $produto[$i]['SubTotalQtd'] ?>
																	</b>
																</h4>
															</td>
															<td class="col-md-9" scope="col">
																<h4>
																	<?php echo $produto[$i]['NomeProduto'] ?> <br>
																	<?php if(!empty($produto[$i]['ObsProduto'])) echo 'Obs: ' . $produto[$i]['ObsProduto'] ?>
																</h4>
															</td>
															<td class="col-md-1" scope="col">
																<?php echo $produto[$i]['SubtotalProduto'] ?>
															</td>
															<td class="col-md-1" scope="col">
																<?php echo $produto[$i]['DataConcluidoProduto'] ?>
															</td>
														</tr>
														
														<?php
														}
														?>
														<tr>
															<td class="col-md-1 text-left">Total: <b><?php echo $orcatrata['QtdPrdOrca'] ?></b></td>
														</tr>
													</tbody>
												</table>
												<?php } else echo '<h3 class="text-left">S/Produtos</h3>';{?>
												<?php } ?>
											<?php } ?>
											
											<!--<hr />-->
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
												<?php if( isset($count['SCount']) ) { ?>							
												<h3 class="text-left"><b>Serviços</b></h3>
												<table class="table table-bordered table-condensed table-striped">
													<thead>
														<tr>
															<th class="col-md-1" scope="col">Qtd</th>																															
															<th class="col-md-9" scope="col">Serviço</th>
															<th class="col-md-1" scope="col">Subtotal</th>
															<th class="col-md-1" scope="col">Data</th>
														</tr>	
													</thead>
													<tbody>

														<?php
														for ($i=1; $i <= $count['SCount']; $i++) {
															#echo $produto[$i]['QtdProduto'];
														?>

														<tr>
															<td class="col-md-1" scope="col">
																<h4>
																	<b>
																		<?php echo $servico[$i]['SubTotalQtd'] ?>
																	</b>
																</h4>
															</td>																			
															<td class="col-md-9" scope="col">
																<h4>
																	<?php echo $servico[$i]['NomeProduto']  ?>
																</h4>	
																	<?php if(!empty($servico[$i]['ObsProduto'])) echo 'Obs: ' . $servico[$i]['ObsProduto'] . '<br> '?>
																	<?php if(!empty($servico[$i]['Prof1'])) echo 'Prof1: ' . $servico[$i]['Prof1'] . ' | ' ?> 
																	<?php if(!empty($servico[$i]['Prof2'])) echo 'Prof2: ' . $servico[$i]['Prof2'] . ' | ' ?> 
																	<?php if(!empty($servico[$i]['Prof3'])) echo 'Prof3: ' . $servico[$i]['Prof3'] . ' | ' ?>
																	<?php if(!empty($servico[$i]['Prof4'])) echo 'Prof4: ' . $servico[$i]['Prof4'] ?> 
															</td>
															<td class="col-md-1" scope="col">
																<?php echo $servico[$i]['SubtotalProduto'] ?>
															</td>
															<td class="col-md-1" scope="col">
																<?php echo $servico[$i]['DataConcluidoProduto'] ?>
															</td>
														</tr>

														<?php
														}
														?>
														<tr>
															<td class="col-md-1 text-left">Total: <b><?php echo $orcatrata['QtdSrvOrca'] ?></b></td>
														</tr>
													</tbody>
												</table>
												<?php } else echo '<h3 class="text-left">S/Serviços</h3>';{?>
												<?php } ?>							
											<?php } ?>
											
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>						
												<h3 class="text-left"><b>Entrega</b>: <?php echo '<strong>' . $query['idApp_OrcaTrata'] . '</strong>' ?>
												<?php if($orcatrata['idApp_Cliente'] != 0) { ?>
													- <b> Cliente:</b> <?php echo '' . $cliente['NomeCliente'] . '' ?> <h4>Tel: <?php echo '' . $cliente['CelularCliente'] . '' ?> - id: <?php echo '' . $cliente['idApp_Cliente'] . '' ?></h4>
												<?php } ?>
												</h3>
												<table class="table table-bordered table-condensed table-striped">
													<thead>
														<tr>
															<th class="col-md-3" scope="col">Onde</th>
															<th class="col-md-3" scope="col">Entregador</th>
															<th class="col-md-3" scope="col">Data</th>
															<th class="col-md-3" scope="col">Hora</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><?php echo $orcatrata['TipoFrete'] ?></td>
															<td><?php echo $orcatrata['Entregador'] ?></td>
															<!--<td><?php echo number_format($orcatrata['ValorFrete'], 2, ',', '.') ?></td>-->
															<td><?php echo $orcatrata['DataEntregaOrca'] ?></td>
															<td><?php echo $orcatrata['HoraEntregaOrca'] ?></td>
														</tr>
													</tbody>
												</table>
												<table class="table table-bordered table-condensed table-striped">
													<thead>
														<tr>
															<th class="col-md-2" scope="col">Cep</th>
															<th class="col-md-4" scope="col">End.</th>
															<th class="col-md-2" scope="col">Número</th>
															<th class="col-md-4" scope="col">Compl.</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><?php echo $orcatrata['Cep'] ?></td>
															<td><?php echo $orcatrata['Logradouro'] ?></td>
															<td><?php echo $orcatrata['Numero'] ?></td>
															<td><?php echo $orcatrata['Complemento'] ?></td>
														</tr>
													</tbody>
													<thead>
														<tr>
															<th class="col-md-2" scope="col">Bairro</th>
															<th class="col-md-4" scope="col">Cidade</th>
															<th class="col-md-2" scope="col">Estado</th>
															<th class="col-md-4" scope="col">Ref.</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><?php echo $orcatrata['Bairro'] ?></td>
															<td><?php echo $orcatrata['Cidade'] ?></td>
															<td><?php echo $orcatrata['Estado'] ?></td>
															<td><?php echo $orcatrata['Referencia'] ?></td>
														</tr>
													</tbody>
												</table>					
												<table class="table table-bordered table-condensed table-striped">
													<thead>
														<tr>
															<th class="col-md-4" scope="col">Nome</th>
															<th class="col-md-4" scope="col">Tel.</th>
															<th class="col-md-4" scope="col">Paren</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><?php echo $orcatrata['NomeRec'] ?></td>
															<td><?php echo $orcatrata['TelefoneRec'] ?></td>
															<td><?php echo $orcatrata['ParentescoRec'] ?></td>
														</tr>
													</tbody>
													<thead>
														<tr>
															<th class="col-md-4" scope="col">Aux1</th>
															<th class="col-md-4" scope="col">Aux2</th>
															<th class="col-md-4" scope="col">ObsEnt.</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><?php echo $orcatrata['Aux1Entrega'] ?></td>
															<td><?php echo $orcatrata['Aux2Entrega'] ?></td>
															<td><?php echo $orcatrata['ObsEntrega'] ?></td>
														</tr>
													</tbody>
												</table>
											<?php } ?>
											<h3 class="text-left"><b>Pagamento</b></h3>
											<table class="table table-bordered table-condensed table-striped">
												<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
													<thead>
														<tr>
															<th class="col-md-3" scope="col">Prudutos</th>
															<th class="col-md-3" scope="col">Servicos</th>
															<th class="col-md-3" scope="col">Taxa Entrega</th>
															<th class="col-md-3" scope="col">Extra</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>R$ <?php echo number_format($orcatrata['ValorOrca'], 2, ',', '.') ?></td>
															<td>R$ <?php echo number_format($orcatrata['ValorDev'], 2, ',', '.') ?></td>
															<td>R$ <?php echo number_format($orcatrata['ValorFrete'], 2, ',', '.') ?></td>
															<td>R$ <?php echo number_format($orcatrata['ValorExtraOrca'], 2, ',', '.') ?></td>
														</tr>
													</tbody>
												<?php } ?>	
												<thead>
													<tr>
														<th class="col-md-3" scope="col">Total Pedido</th>
														<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
															<th class="col-md-3" scope="col">Desconto</th>
															<th class="col-md-3" scope="col">CashBack</th>
															<th class="col-md-3" scope="col">Valor Final</th>
														<?php } ?>
														
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>R$ <?php echo number_format($orcatrata['ValorTotalOrca'], 2, ',', '.') ?></td>
														<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
															<td>R$ <?php echo number_format($orcatrata['DescValorOrca'], 2, ',', '.') ?></td>
															<td>R$ <?php echo number_format($orcatrata['CashBackOrca'], 2, ',', '.') ?></td>
															<td>R$ <?php echo number_format($orcatrata['ValorFinalOrca'], 2, ',', '.') ?></td>
														<?php } ?>
													</tr>
												</tbody>
												<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
													<thead>
														<tr>
															<th class="col-md-3" scope="col">Troco para</th>
															<th class="col-md-3" scope="col">Troco</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>R$ <?php echo number_format($orcatrata['ValorDinheiro'], 2, ',', '.') ?></td>
															<td>R$ <?php echo number_format($orcatrata['ValorTroco'], 2, ',', '.') ?></td>
														</tr>
													</tbody>
												<?php } ?>
											</table>
											<table class="table table-bordered table-condensed table-striped">
												<thead>
													<tr>
														<th class="col-md-4" scope="col">Onde</th>
														<th class="col-md-4" scope="col">Forma</th>
														<th class="col-md-4" scope="col">Venc.</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><?php echo $orcatrata['OndePagar'] ?></td>
														<td><?php echo $orcatrata['FormaPag'] ?></td>
														<td><?php echo $orcatrata['DataVencimentoOrca'] ?></td>
													</tr>
												</tbody>
											</table>
											
											<?php if( isset($count['PRCount']) ) { ?>
											<h3 class="text-left">Parcelas</h3>
											<table class="table table-bordered table-condensed table-striped">
												<thead>
													<tr>
														<th class="col-md-1" scope="col">Parcela</th>
														<th class="col-md-3" scope="col">FormaPag</th>
														<th class="col-md-1" scope="col">R$</th>
														<th class="col-md-3" scope="col">Venc. </th>
														<th class="col-md-1" scope="col">Pago?</th>
														<th class="col-md-3" scope="col">Dt.Pago</th>
													</tr>
												</thead>

												<tbody>

													<?php
													for ($i=1; $i <= $count['PRCount']; $i++) {
													?>

													<tr>
														<td><?php echo $parcelasrec[$i]['Parcela'] ?></td>
														<td><?php echo $parcelasrec[$i]['FormaPag'] ?></td>
														<td><?php echo number_format($parcelasrec[$i]['ValorParcela'], 2, ',', '.') ?></td>
														<td><?php echo $parcelasrec[$i]['DataVencimento'] ?></td>
														<td><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$i]['Quitado'], 'NS') ?></td>
														<td><?php echo $parcelasrec[$i]['DataPago'] ?></td>									
													</tr>

													<?php
													}
													?>

												</tbody>
											</table>
											<?php } else echo '<h3 class="text-left">S/Parcelas </h3>';{?>
											<?php } ?>
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
												<!--
												<h3 class="text-left"><b>Status do Pedido</b></h3>
												<table class="table table-bordered table-condensed table-striped">
													<thead>
														<tr>
															<th class="col-md-2" scope="col">Aprovado?</th>
															<th class="col-md-2" scope="col">Finalizado?</th>
															<th class="col-md-2" scope="col">Pronto?</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['AprovadoOrca'], 'NS') ?></td>
															<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['FinalizadoOrca'], 'NS') ?></td>
															<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['ProntoOrca'], 'NS') ?></td>
														</tr>
													</tbody>
													<thead>
														<tr>
															<th class="col-md-2" scope="col">Enviado?</th>
															<th class="col-md-2" scope="col">Entregue?</th>
															<th class="col-md-2" scope="col">Pago?</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['EnviadoOrca'], 'NS') ?></td>
															<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['ConcluidoOrca'], 'NS') ?></td>
															<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['QuitadoOrca'], 'NS') ?></td>
														</tr>
													</tbody>
												</table>
												<table class="table table-bordered table-condensed table-striped">
													<thead>
														<tr>

															<th class="col-md-4" scope="col">Data da Entrega</th>
															<th class="col-md-4" scope="col">Data do Quitação</th>
															
														</tr>
													</thead>
													<tbody>
														<tr>

															<td><?php echo $orcatrata['DataConclusao'] ?></td>
															<td><?php echo $orcatrata['DataQuitado'] ?></td>
															
														</tr>
													</tbody>
												</table>
												-->
												<table class="table table-bordered table-condensed table-striped">
													<thead>
														<tr>
															<th class="col-md-12" scope="col">Informações Gerais</th>
														</tr>
													</thead>
													<tbody>
														<tr>

															<td><?php echo $orcatrata['Consideracoes'] ?></td>
														</tr>
													</tbody>
												</table>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						<?php } elseif($metodo == 2) { ?>
							<table class="table table-bordered table-condensed table-striped">
								<thead>
									<tr>
										<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'>
																									
																									</td>
										<td class="col-md-3 text-left" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>'
																							. '<br><br><strong>' . $orcatrata['NomeCliente'] . '</strong> - ' . $orcatrata['idApp_Cliente'] . ''
																							. '<br>' . $orcatrata['EnderecoCliente'] . ' - ' . $orcatrata['NumeroCliente'] . ''
																							. '<br>' . $orcatrata['ComplementoCliente'] . ' - ' . $orcatrata['BairroCliente'] . ' - ' . $orcatrata['CidadeCliente'] . ' - ' . $orcatrata['EstadoCliente'] . '<br>' . $orcatrata['ReferenciaCliente'] . ''
																							. '<br>Tel.:' . $orcatrata['CelularCliente'] . ' / ' . $orcatrata['Telefone'] . ' / ' . $orcatrata['Telefone2'] . ' / ' . $orcatrata['Telefone3'] . ''
																					?></td>
										<td class="col-md-1 text-center" scope="col"><?php echo 'Data:<br><strong>'  . $orcatrata['DataOrca'] . '</strong>'
																							. '<br><br>Recebedor:<br><strong>'  . $orcatrata['NomeRec'] . '</strong>'
																						?></td>
										<td class="col-md-1 text-center" scope="col"><?php echo 'Orçamento:<br><strong>' . $orcatrata['idApp_OrcaTrata'] . '</strong>'
																							. '<br><br>Valor Total:'
																							. '<br>R$: <strong>'  . $orcatrata['ValorTotalOrca'] . '</strong>'
																							. '<br><br>Via da Empresa'
																						?></td>
									</tr>
								</thead>
								<thead>
									<tr>
										<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'>
																									
																									</td>
										<td class="col-md-3 text-left" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>'
																							. '<br><br><strong>' . $orcatrata['NomeCliente'] . '</strong> - ' . $orcatrata['idApp_Cliente'] . ''
																							. '<br>' . $orcatrata['EnderecoCliente'] . ' - ' . $orcatrata['NumeroCliente'] . ''
																							. '<br>' . $orcatrata['ComplementoCliente'] . ' - ' . $orcatrata['BairroCliente'] . ' - ' . $orcatrata['CidadeCliente'] . ' - ' . $orcatrata['EstadoCliente'] . '<br>' . $orcatrata['ReferenciaCliente'] . ''
																							. '<br>Tel.:' . $orcatrata['CelularCliente'] . ' / ' . $orcatrata['Telefone'] . ' / ' . $orcatrata['Telefone2'] . ' / ' . $orcatrata['Telefone3'] . ''
																					?></td>
										<td class="col-md-1 text-center" scope="col"><?php echo 'Data:<br><strong>'  . $orcatrata['DataOrca'] . '</strong>'
																							. '<br><br>Recebedor:<br><strong>'  . $orcatrata['NomeRec'] . '</strong>'
																						?></td>
										<td class="col-md-1 text-center" scope="col"><?php echo 'Orçamento:<br><strong>' . $orcatrata['idApp_OrcaTrata'] . '</strong>'
																							. '<br><br>Valor Total:'
																							. '<br>R$: <strong>'  . $orcatrata['ValorTotalOrca'] . '</strong>'
																							. '<br><br>Via do Cliente'
																						?></td>
									</tr>
								</thead>
								
								<thead>
									<tr>
										<th class="col-md-1" scope="col">Qtd</th>
										<th class="col-md-3" scope="col">Prd/Srv</th>							
										<th class="col-md-1" scope="col">R$</th>
										<th class="col-md-1" scope="col">Ent?</th>
									</tr>
								</thead>
								<?php if( isset($count['PCount']) ) { ?>
									<tbody>
									<?php for ($k=1; $k <= $count['PCount']; $k++) { ?>
										<tr>
											<td class="col-md-1" scope="col"><?php echo $produto[$k]['SubTotalQtd'] ?></td>
											<td class="col-md-3" scope="col"><?php echo $produto[$k]['NomeProduto'] ?></td>
											<td class="col-md-1" scope="col"><?php echo $produto[$k]['SubtotalProduto'] ?></td>
											<td class="col-md-1" scope="col"><?php echo $produto[$k]['ConcluidoProduto'] ?></td>										
										</tr>
									
									<?php
									}
									?>
									</tbody>
								<?php
								}
								?>
								<?php if( isset($count['SCount']) ) { ?>
									<tbody>
									<?php for ($k=1; $k <= $count['SCount']; $k++) { ?>
										<tr>
											<td class="col-md-1" scope="col"><?php echo $servico[$k]['SubTotalQtd'] ?></td>
											<td class="col-md-3" scope="col"><?php echo $servico[$k]['NomeProduto'] ?></td>
											<td class="col-md-1" scope="col"><?php echo $servico[$k]['SubtotalProduto'] ?></td>
											<td class="col-md-1" scope="col"><?php echo $servico[$k]['ConcluidoProduto'] ?></td>										
										</tr>
									
									<?php
									}
									?>
									</tbody>
								<?php
								}
								?>
								
								<thead>
									<tr>
										<th class="col-md-1" scope="col">Par</th>
										<th class="col-md-1" scope="col">R$|Forma</th>
										<th class="col-md-3" scope="col">Venc. || Dt.Pago</th>
										<th class="col-md-1" scope="col">Pago?</th>										
									</tr>
								</thead>
								<?php if( isset($count['PRCount']) ) { ?>
									<tbody>
									<?php for ($j=1; $j <= $count['PRCount']; $j++) { ?>
										<tr>
											<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['Parcela'] ?></td>
											<td class="col-md-1" scope="col"><?php echo number_format($parcelasrec[$j]['ValorParcela'], 2, ',', '.') ?> | <?php echo $parcelasrec[$j]['FormaPag'] ?></td>
											<td class="col-md-3" scope="col"><?php echo $parcelasrec[$j]['DataVencimento'] ?> || <?php echo $parcelasrec[$j]['DataPago'] ?></td>
											<td class="col-md-1" scope="col"><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$j]['Quitado'], 'NS') ?></td>
										</tr>
									<?php
									} 
									?>
									</tbody>
								<?php
								} 
								?>					
							</table>
						<?php } ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	if ($_SESSION['log']['idSis_Empresa'] != 5){
		if(isset($_SESSION['bd_orcamento']['Whatsapp']) && $_SESSION['bd_orcamento']['Whatsapp'] == "S"){
			if(isset($whatsapp)){
				echo "
					<script>
						var	win = window.open('https://api.whatsapp.com/send?phone=55".$cliente['CelularCliente']."&text=" . $whatsapp . "','1366002941508','width=700,height=350,left=375,right=375,top=300');
						/*
						setTimeout(function () { win.close();}, 500);
						*/
					</script>
				";
			}
		}
		unset($_SESSION['bd_orcamento'], $whatsapp, $whatsapp_site);	
	}
?>