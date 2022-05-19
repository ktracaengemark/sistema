<div class="container-fluid">
	<div class="row">
		<?php if($paginacao == "S") { ?>
			<div class="col-lg-1 col-md-2 col-sm-2 col-xs-6">
				<label></label><br>
				<a href="<?php echo base_url() . $caminho; ?>">
					<button class="btn btn-warning btn-md btn-block" type="button">
						<span class="glyphicon glyphicon-filter"></span> Filtros
					</button>
				</a>
			</div>
		<?php }else{ ?>
			<div class="col-lg-1 col-md-2 col-sm-2 col-xs-6">
				<label></label><br>
				<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
					<span class="glyphicon glyphicon-filter"></span>
				</button>
			</div>		
		<?php } ?>
		<?php if ($editar == 1) { ?>
			<?php if ($print == 1) { ?>
				<!--
				<div class="col-lg-1 col-md-2 col-sm-2 col-xs-6">
					<label></label><br>
					<a href="<?php #echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
						<button class="btn btn-<?php #echo $panel; ?> btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-print"></span>
						</button>
					</a>
				</div>
				-->
			<?php } ?>	
		<?php } ?>
		<div class="col-lg-1 col-md-2 col-sm-2 col-xs-6 text-left">
			<label></label><br>
			<a href="<?php echo base_url() . 'gerar_excel/Agendamentos/Agendamentos_total_xls.php'; ?>">
				<button type='button' class='btn btn-md btn-success btn-block'>
					Total
				</button>
			</a>
		</div>
		<div class="col-lg-1 col-md-2 col-sm-2 col-xs-6 text-left">
			<label></label><br>
			<a href="<?php echo base_url() . 'gerar_excel/Agendamentos/Agendamentos_parc_xls.php'; ?>">
				<button type='button' class='btn btn-md btn-success btn-block'>
					Parcial
				</button>
			</a>
		</div>
		<div class="ccol-lg-2 col-md-2 col-sm-2 col-xs-6">
			<label></label><br>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php echo $report->num_rows(); ?> / <?php echo $total_rows; ?>">
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-left">
			<?php echo $pagination; ?>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-12 text-left">
			<div style="overflow: auto; height: auto; ">            
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<th class="active">Cont.</th>
							<th class="active">Tipo</th>
							<th class="active">id_Agenda</th>
							<th class="active">Repeticao</th>
							<th class="active">Prof</th>
							<th class="active">Recor</th>
							<th class="active">Evento</th>
							<th class="active">DataIni</th>
							<th class="active">DataFim</th>
							<th class="active">HoraIni</th>
							<th class="active">HoraFim</th>
							<th class="active">id_Cliente</th>
							<th class="active">Cliente</th>
							<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){ ?>
								<th class="active">id_Pet</th>
								<th class="active">Pet</th>
								<th class="active">Especie</th>
								<th class="active">Sexo</th>
								<th class="active">Raca</th>
								<th class="active">Pelo</th>
								<th class="active">Porte</th>
								<th class="active">Cor</th>
								<th class="active">Peso</th>
								<th class="active">Aler.</th>
								<th class="active">Obs</th>
							<?php }elseif($_SESSION['Empresa']['CadastrarDep'] == "S"){ ?>
								<th class="active">id_Dep</th>
								<th class="active">Dep</th>
							<?php } ?>
							<th class="active">id_OS</th>
							<th class="active">id_Produto</th>
							<th class="active">Categoria</th>
							<th class="active">Produto</th>
							<th class="active">ObsProduto</th>
							<th class="active">DataProduto</th>
							<th class="active">HoraProduto</th>
							<th class="active">Valor</th>
		
						</tr>
					</thead>
					<tbody>
						<?php
						$linha =  $per_page*$pagina;
						$count = 1;
						foreach ($report->result_array() as $row) {
							echo '<tr>';	
								echo '<td>' . ($linha + $count) . '</td>';
								echo '<td>'.$row["Tipo"].'</td>';
								echo '<td>'.$row["idApp_Consulta"].'</td>';
								echo '<td>'.$row["Repeticao"].'</td>';
								echo '<td>'.utf8_encode($row["Nome"]).'</td>';
								echo '<td>'.$row["Recorrencia"].'.</td>';
								echo '<td>'.utf8_encode($row["Obs"]).'</td>';
								echo '<td>'.$row["DataInicio"].'</td>';
								echo '<td>'.$row["DataFim"].'</td>';
								echo '<td>'.$row["HoraInicio"].'</td>';
								echo '<td>'.$row["HoraFim"].'</td>';
								echo '<td>'.$row["id_Cliente"].'</td>';
								echo '<td>'.utf8_encode($row["NomeCliente"]).'</td>';
								if($_SESSION['Empresa']['CadastrarPet'] == "S"){
									echo '<td>'.$row["idApp_ClientePet"].'</td>';
									echo '<td>'.utf8_encode($row["NomeClientePet"]).'</td>';
									echo '<td>'.utf8_encode($row["EspeciePet"]).'</td>';
									echo '<td>'.utf8_encode($row["SexoPet"]).'</td>';
									echo '<td>'.utf8_encode($row["RacaPet"]).'</td>';
									echo '<td>'.utf8_encode($row["PeloPet"]).'</td>';
									echo '<td>'.utf8_encode($row["PortePet"]).'</td>';
									echo '<td>'.utf8_encode($row["CorPet"]).'</td>';
									echo '<td>'.utf8_encode($row["PesoPet"]).'</td>';
									echo '<td>'.$row["AlergicoPet"].'</td>';
									echo '<td>'.utf8_encode($row["ObsPet"]).'</td>';
								}elseif($_SESSION['Empresa']['CadastrarDep'] == "S"){
									echo '<td>'.$row["idApp_ClienteDep"].'</td>';
									echo '<td>'.utf8_encode($row["NomeClienteDep"]).'</td>';
								}
								echo '<td>'.$row["idApp_OrcaTrata"].'</td>';
								echo '<td>'.$row["idApp_Produto"].'</td>';
								echo '<td>'.utf8_encode($row["Catprod"]).'</td>';
								echo '<td>'.utf8_encode($row["NomeProduto"]).'</td>';
								echo '<td>'.utf8_encode($row["ObsProduto"]).'</td>';
								echo '<td>'.$row["DataProduto"].'</td>';
								echo '<td>'.$row["HoraProduto"].'</td>';
								echo '<td>'.number_format($row["SubTotalProduto"], 2, ',', '.'). '</td>';
											
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
