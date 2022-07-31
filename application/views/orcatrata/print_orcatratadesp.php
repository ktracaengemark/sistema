<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">	
			<?php #if ($nav_secundario) echo $nav_secundario; ?>
			<?php if ($msg) {?>
				<div class="row">
					<div class="col-md-12 ">
						<?php echo $msg; ?>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">		
					<?php if ( !isset($evento) && isset($query)) { ?>
						<?php if ($query['idApp_OrcaTrata'] != 1 ) { ?>
							<nav class="navbar navbar-inverse navbar-fixed" role="banner">
							  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span> 
									</button>
									<!--
									<a class="navbar-brand" href="<?php echo base_url() . 'orcatrata/cadastrardesp/'; ?>">
										<span class="glyphicon glyphicon-plus"></span> Novo
									</a>
									-->
									<a class="navbar-brand" href="<?php echo base_url() . 'orcatrata/alterardesp/' . $query['idApp_OrcaTrata']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Despesa										
									</a>
								</div>
								<div class="collapse navbar-collapse" id="myNavbar">
									<ul class="nav navbar-nav navbar-center">
										<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
											<div class="btn-group " role="group" aria-label="...">
												<a href="javascript:window.print()">
													<button type="button" class="btn btn-md btn-default ">
														<span class="glyphicon glyphicon-print"></span> Imprimir
													</button>
												</a>										
											</div>
										</li>
									</ul>
								</div>
							  </div>
							</nav>
						<?php } ?>
					<?php } ?>			
					
					<?php echo validation_errors(); ?>
					<?php 
						if($_SESSION['log']['idSis_Empresa'] != 5) {
							$none = '';
						}else{
							$none = 'none';
						}
					?>
					<div style="overflow: auto; height: auto; ">		
						<div class="row">	
							<div class="panel panel-danger">
								<div class="panel-heading">
									<table class="table table-condensed table-striped">
										<tbody>
											<tr>
												<td class="col-md-4 text-center" scope="col"><img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='200'></td>
												<td class="col-md-8 text-center" scope="col">
													<h3><?php echo '<strong>' . $query['NomeEmpresa'] . '</strong>' ?></h3>
													<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>	
														<h4>CNPJ:<?php echo '<strong>' . $orcatrata['Cnpj'] . '</strong>' ?></h4>
														<h4>Endereço:<?php echo '<small>' . $orcatrata['EnderecoEmpresa'] . '</small> <small>' . $orcatrata['NumeroEmpresa'] . '</small> <small>' . $orcatrata['ComplementoEmpresa'] . '</small><br>
																				<small>' . $orcatrata['BairroEmpresa'] . '</small> - <small>' . $orcatrata['MunicipioEmpresa'] . '</small> - <small>' . $orcatrata['EstadoEmpresa'] . '</small>' ?></h4>
													<?php } ?>	
													<h5>Colaborador.:<?php 
																	if(isset($usuario)){
																		$colaborador = $usuario['Nome'];
																	}else{
																		$colaborador = "O Cliente";
																	} echo '<strong>' . $colaborador . '</strong>'
																?>
													</h5>
													<h4 class="text-center">Despesa<?php echo ' - <strong>' . $query['idApp_OrcaTrata'] . '</strong>' ?> </h4>
												</td>
											</tr>
										</tbody>
									</table>
										
									<div class="panel-body">

										<!--<hr />-->
										<?php if($orcatrata['idApp_Fornecedor'] != 0) { ?>								
											<h3 class="text-left"><b>Fornecedor</b>: <?php echo '' . $fornecedor['NomeFornecedor'] . '' ?></h3>
											<h5 class="text-left"><b>Tel</b>: <?php echo '' . $fornecedor['Telefone1'] . '' ?> - <b>ID</b>: <?php echo '' . $fornecedor['idApp_Fornecedor'] . '' ?> </h5>
										<?php } ?>
										<?php if($orcatrata['id_Funcionario'] != 0) { ?>								
											<h3 class="text-left"><b>Funcionario</b>: <?php echo '' . $funcionario['Nome'] . '' ?></h3>
										<?php } ?>
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
														<th class="col-md-10" scope="col">Produto</th>
														<th class="col-md-1" scope="col">Subtotal</th>
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
														<td class="col-md-10" scope="col">
															<h4>
																<?php echo $produto[$i]['NomeProduto'] ?> <br>
																<?php if(!empty($produto[$i]['ObsProduto'])) echo 'Obs: ' . $produto[$i]['ObsProduto'] ?>
															</h4>
														</td>
														<td class="col-md-1" scope="col">
															<?php echo $produto[$i]['SubtotalProduto'] ?>
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
														<th class="col-md-10" scope="col">Serviço</th>
														<th class="col-md-1" scope="col">Subtotal</th>
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
														<td class="col-md-10" scope="col">
															<h4>
																<?php echo $servico[$i]['NomeProduto'] ?><br>
																<?php if(!empty($servico[$i]['ObsProduto'])) echo 'Obs: ' . $servico[$i]['ObsProduto'] ?>
															</h4>
														</td>
														<td class="col-md-1" scope="col">
															<?php echo $servico[$i]['SubtotalProduto'] ?>
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
											<h3 class="text-left"><b>Entrega</b>: <?php echo '<strong>' . $query['idApp_OrcaTrata'] . '</strong>' ?></h3>
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
					</div>	
				</div>
			</div>	
		</div>
	</div>	
</div>