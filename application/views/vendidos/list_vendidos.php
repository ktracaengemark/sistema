<div class="panel panel-<?php echo $panel; ?>">
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-left">
				<label></label><br>
				<div class="input-group">
					<span class="input-group-addon">Prds</span>
					<input type="text" class="form-control" disabled aria-label="Total de Entradas" value="<?php echo $report->num_rows() ?> / <?php echo $total_rows ?>">
				</div>
			</div>
			<div class="col-md-4 text-left">
				<?php echo $pagination; ?>
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
			<?php }else{ ?>
				<div class="col-md-2">
					<label>Filtros</label>
					<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-filter"></span>
					</button>
				</div>
			<?php } ?>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-left">
				<label>Excel</label><br>
				<a href="<?php echo base_url() . 'gerar_excel/Orcamentos/Produtos_resumido_xls.php'; ?>">
					<button type='button' class='btn btn-md btn-success btn-block'>
						Gerar Parcial
					</button>
				</a>
			</div>
			<div class="col-md-2">
				<label>Baixa</label>
				<a href="<?php echo base_url() . $alterarprod . $_SESSION['log']['idSis_Empresa']; ?>">
					<button class="btn btn-danger btn-md btn-block" type="button">
						<span class="glyphicon glyphicon-edit"></span>
					</button>
				</a>
			</div>
		</div>	
	</div>
</div>	
<div class="container-fluid">
	<div class="row">
		<div style="overflow: auto; height: auto; ">
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
						<th class="active">Baixa</th>
						<th class="active">Cont.</th>
						<th class="active">Pedido</th>
						<th class="active">DtPedido</th>
						<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
							<th class="col-md-2 active"><?php echo $nome; ?></th>
							<th class="col-md-2 active">Celular</th>
							<?php if($_SESSION['Empresa']['CadastrarPet'] == "S") {?>
								<th class="col-md-2 active">Pet</th>
							<?php }else{ ?>
								<?php if($_SESSION['Empresa']['CadastrarDep'] == "S") {?>
									<th class="col-md-2 active">Dep</th>
								<?php } ?>							
							<?php } ?>
							<th class="active">Comb.</th>
							<th class="active">Apro.</th>
							<th class="active">Entr.</th>
							<th class="active">Pago.</th>
							<th class="active">Final.</th>
							<th class="active">Cancel.</th>
							<th class="active">Compra</th>
							<th class="active">Entrega</th>
							<th class="active">Pagam.</th>
						<?php } ?>
						<th class="active">Form.Pag.</th>
						<th class="active">Categoria</th>
						<th class="active">Qtd</th>
						<th class="active">Produto</th>
						<th class="active">ValorR$</th>
						<th class="active">Entregue</th>
						<th class="active">DataEntr.</th>
						<th class="active">HoraEntr.</th>					
					</tr>
				</thead>
				<tbody>
					<?php
					$linha =  $per_page*$pagina;
					$count = 1;
					foreach ($report->result_array() as $row) {
						echo '<tr>';
							echo '<td class="notclickable">
									<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . $imprimir . $row['idApp_OrcaTrata'] . '">
										<span class="glyphicon glyphicon-print notclickable"></span>
									</a>
								</td>';
							if ($_SESSION['Usuario']['Bx_Prd'] == "S") {
								if($row['CanceladoOrca'] == "N" && $row['ConcluidoProduto'] == "N"){	
									echo '<td class="notclickable">
											<a class="btn btn-md btn-success notclickable" href="' . base_url() . $edit . $row['idApp_Produto'] . '">
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
							echo '<td>' . ($linha + $count) . '/' . $total_rows . '</td>';
							echo '<td>' . $row['idApp_OrcaTrata'] . '- ' . $row['TipoFinanceiro'] . ' - ' . $row['Descricao'] . '</td>';
							echo '<td>' . $row['DataOrca'] . '</td>';
							if($_SESSION['log']['idSis_Empresa'] != "5"){
								echo '<td>' . $row['Nome' . $nome] . '</td>';
								echo '<td>' . $row['Celular' . $nome] . '</td>';
								if($_SESSION['Empresa']['CadastrarPet'] == "S"){
									echo '<td>' . $row['NomeClientePet'] . '</td>';
								}else{
									if($_SESSION['Empresa']['CadastrarDep'] == "S"){
										echo '<td>' . $row['NomeClienteDep'] . '</td>';
									}
								}
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
							echo '<td class="text-left">' . $row['Catprod'] . '</td>';
							echo '<td class="text-left">' . $row['QuantidadeProduto'] . '</td>';
							echo '<td class="text-left">' . $row['NomeProduto'] . '</td>';
							echo '<td class="text-left">' . $row['ValorProduto'] . '</td>';
							echo '<td>' . $row['ConcluidoProduto'] . '</td>';
							echo '<td>' . $row['DataConcluidoProduto'] . '</td>';
							echo '<td>' . $row['HoraConcluidoProduto'] . '</td>';
						echo '</tr>';
						$count++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
