<div style="overflow: auto; height: 550px; ">	
	<div class="container-fluid">
			<div>
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>
				<?php if (($_SESSION['log']['NivelEmpresa'] >= 4) AND ($_SESSION['log']['NivelEmpresa'] <= 10) ) { ?>
				<table class="table table-bordered table-condensed table-striped">

					<thead>
						<tr> 
							<?php if($query['Agrupar'] != 4) { ?>
								<!--<th class="active">Id.Imagem</th>-->
								<th class="active" scope="col">Im.CT</th>
								<th class="active">Id.CT</th>
								<th class="active" scope="col">Im.PB</th>
								<th class="active">Id.PB</th>
								<th class="active" scope="col">Im.PD</th>
								<th class="active">Id.PD</th>
								<th class="active" scope="col">Edit.Produto</th>
								<th class="active">Código</th>
								<!--<th class="active">Tipo</th>-->
								<th class="active">Categoria</th>
								<th class="active">Produto</th>
								<th class="active">Estoque</th>
								<!--<th class="active">Var1</th>
								<th class="active">Var2</th>-->
							<?php } ?>
							<?php if((!$query['Agrupar']) || $query['Agrupar'] == 2 ||  $query['Agrupar'] == 3 || $query['Agrupar'] == 4) { ?>
								<th class="active" scope="col">Edit.Preco</th>
								<?php if($query['Agrupar'] != 4) { ?>
									<th class="active">id.Preco</th>
								<?php } ?>
								<th class="active">Tipo</th>
								<?php if($query['Agrupar'] != 2) { ?>
									<th class="active">CatProm</th>
									<th class="active">id.Prom</th>
									<th class="active">Im.Prom</th>
									<th class="active">Titulo</th>
									<th class="active">Descricao</th>
								<?php } ?>
								<?php if($query['Agrupar'] != 4) { ?>
									<th class="active">DcPreco</th>
									<th class="active">Qtd</th>
									<th class="active">Embal</th>
									<th class="active">Preco</th>
									<th class="active">ComVenda</th>
									<th class="active">ComServico</th>
									<th class="active">CashBack</th>
									<th class="active">Tempo</th>
									<th class="active">Ativo</th>
									<th class="active">V/R</th>
								<?php } ?>
							<?php } ?>
						</tr>
					</thead>

					<tbody>
						<?php
						foreach ($report->result_array() as $row) {?>

							<!--<tr class="clickable-row" data-href="<?php #echo base_url() . 'produtos/alterarlogo/' . $row['idTab_Produto'] . ''; ?>">-->
							<tr>	
								<?php if($query['Agrupar'] != 4) { ?>
								
									<td class="notclickable">
										<a class="notclickable" href="<?php echo base_url() . 'produtos/alterarlogocatprod/' . $row['idTab_Catprod'] . ''; ?>">
											<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['ArquivoCatprod'] . ''; ?> "class="img-circle img-responsive" width='50'>
										</a>
									</td>
									<td><?php echo $row['idTab_Catprod'] ?></td>
									<td class="notclickable">
										<a class="notclickable" href="<?php echo base_url() . 'produtos/alterarlogo/' . $row['idTab_Produto'] . ''; ?>">
											<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['ArquivoProduto'] . ''; ?> "class="img-circle img-responsive" width='50'>
										</a>
									</td>
									<td><?php echo $row['idTab_Produto'] ?></td>
									<td class="notclickable">
										<a class="notclickable" href="<?php echo base_url() . 'produtos/alterarlogoderivado/' . $row['idTab_Produtos'] . ''; ?>">
											<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['ArquivoProdutos'] . ''; ?> "class="img-circle img-responsive" width='50'>
										</a>
									</td>
									<td><?php echo $row['idTab_Produtos'] ?></td>
									<td class="notclickable">
										<a class="btn btn-md btn-info notclickable" href="<?php echo base_url() . 'produtos/tela/' . $row['idTab_Produtos'] . ''; ?>">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>
									<!--<td><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'></td>-->
									
									<td><?php echo $row['Cod_Prod'] ?></td>
									<!--<td><?php echo $row['Prod_Serv'] ?></td>-->
									<td><?php echo $row['Catprod'] ?></td>
									<td><?php echo $row['Nome_Prod'] ?></td>
									<td><?php echo $row['Estoque'] ?></td>
									<!--<td><?php #echo $row['Opcao1'] ?></td>
									<td><?php #echo $row['Opcao2'] ?></td>-->
								<?php } ?>
								<?php if((!$query['Agrupar']) || $query['Agrupar'] == 2 ||  $query['Agrupar'] == 3 || $query['Agrupar'] == 4) { ?>
									<?php 
										if(isset($row['idTab_Valor'])){
											if($row['idTab_Desconto'] == 1){
												$url = base_url() . 'produtos/tela_valor/' . $row['idTab_Valor'];
												//$url = $row['idTab_Valor'];
											}elseif($row['idTab_Desconto'] == 2){
												$url = base_url() . 'promocao/tela_promocao/' . $row['idTab_Promocao'];
											}
										}else{
											$url = base_url() . 'produtos/tela_precos/' . $row['idTab_Produtos'];
											//$url = '';
										}
									?>	
									<td class="notclickable">
										<a class="btn btn-md btn-info notclickable" href="<?php echo $url ?>">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>
									<?php if($query['Agrupar'] != 4) { ?>
										<td><?php echo $row['idTab_Valor'] ?></td>
									<?php } ?>
									<td><?php echo $row['Desconto'] ?></td>
									<?php if($query['Agrupar'] != 2) { ?>
										<td><?php echo $row['Catprom'] ?></td>
										<td><?php echo $row['idTab_Promocao'] ?></td>
										<td class="notclickable">
											<?php if($row['idTab_Desconto'] == 2) { ?>
												<a class="notclickable" href="<?php echo base_url() . 'promocao/alterarlogo/' . $row['idTab_Promocao'] . ''; ?>">
													<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $row['ArquivoPromocao'] . ''; ?> "class="img-circle img-responsive" width='50'>
												</a>
											<?php } ?>
										</td>
										<td><?php echo $row['Promocao'] ?></td>
										<td><?php echo $row['Descricao'] ?></td>
									<?php } ?>
									<?php if($query['Agrupar'] != 4) { ?>
										<td><?php echo $row['Convdesc'] ?></td>
										<td><?php echo $row['QtdProdutoDesconto'] ?>x</td>
										<td><?php echo $row['QtdProdutoIncremento'] ?>unid</td>
										<td>R$<?php echo $row['ValorProduto'] ?></td>
										<td><?php echo $row['ComissaoVenda'] ?> %</td>
										<td><?php echo $row['ComissaoServico'] ?> %</td>
										<td><?php echo $row['ComissaoCashBack'] ?> %</td>
										<td><?php echo $row['TempoDeEntrega'] ?> Dias</td>
										<td><?php echo $row['AtivoPreco'] ?></td>
										<td><?php echo $row['TipoPreco'] ?></td>
									<?php } ?>	
								<?php } ?>	
							</tr>	
						<?php } ?>						
					
					</tbody>

				</table>
				<?php } ?>				
			</div>

	</div>
</div>
