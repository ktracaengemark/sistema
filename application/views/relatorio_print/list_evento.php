<div class="container-fluid">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-left">
			<?php echo $pagination; ?>
		</div>
		<div class="ccol-lg-2 col-md-2 col-sm-2 col-xs-6">
			<label></label><br>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php echo $report->num_rows(); ?> / <?php echo $total_rows; ?>">
			</div>
		</div>	
		<?php if($paginacao == "S") { ?>
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
				<label></label><br>
				<a href="<?php echo base_url() . $caminho; ?>">
					<button class="btn btn-warning btn-md btn-block" type="button">
						<span class="glyphicon glyphicon-filter"></span> Filtros
					</button>
				</a>
			</div>
		<?php }else{ ?>
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
				<label></label><br>
				<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
					<span class="glyphicon glyphicon-filter"></span>
				</button>
			</div>		
		<?php } ?>
			<?php if ($editar == 1) { ?>
				<?php if ($print == 1) { ?>	
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
						<label></label><br>
						<a href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
							<button class="btn btn-<?php echo $panel; ?> btn-md btn-block" type="button">
								<span class="glyphicon glyphicon-print"></span>
							</button>
						</a>
					</div>
				<?php } ?>	
			<?php } ?>
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-6 text-left">
			<label></label><br>
			<a href="<?php echo base_url() . 'gerar_excel/Agendamentos/Agendamentos_xls.php'; ?>">
				<button type='button' class='btn btn-md btn-success btn-block'>
					Completo
				</button>
			</a>
		</div>
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-6 text-left">
			<label></label><br>
			<a href="<?php echo base_url() . 'gerar_excel/Agendamentos/Agendamentos_parc_xls.php'; ?>">
				<button type='button' class='btn btn-md btn-success btn-block'>
					Parcial
				</button>
			</a>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-12 text-left">
			<div style="overflow: auto; height: auto; ">            
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<th class="active">Ver</th>
							<th class="active">Cont.</th>
							<th class="active">id</th>
							<th class="active">Rec</th>
							<th class="active">Evento</th>
							<th class="active">Prof.</th>
							<th class="active">Data</th>
							<th class="active">Hora</th>
							<?php if($TipoEvento == 2){?>
								<th class="active">Cliente</th>
								<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
									<th class="active">Pet</th>
								<?php } ?>
								<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
									<th class="active">Dep</th>
								<?php } ?>
								<th class="active">OS</th>
								<th class="active">Categoria</th>
								<th class="active">Produto</th>
								<th class="active">Valor</th>
								<th class="active">Obs</th>
							<?php } ?>								
						</tr>
					</thead>
					<tbody>
						<?php
						$linha =  $per_page*$pagina;
						$count = 1;
						foreach ($report->result_array() as $row) {
							echo '<tr>';
								if($TipoEvento == 2){
									echo '<td class="notclickable">
											<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . 'Consulta/alterar/' . $row['id_Cliente'] . '/' . $row['idApp_Consulta'] . '">
												<span class="glyphicon glyphicon-calendar notclickable"></span>
											</a>
										</td>';
								}else if($TipoEvento == 1){
									echo '<td class="notclickable">
											<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . 'Consulta/alterar_evento/' . $row['idApp_Consulta'] . '">
												<span class="glyphicon glyphicon-calendar notclickable"></span>
											</a>
										</td>';
								}	
								echo '<td>' . ($linha + $count) . '</td>';
								echo '<td>' . $row['idApp_Consulta'] . '</td>';
								echo '<td>' . $row['Recorrencia'] . '</td>';
								echo '<td>' . $row['Obs'] . '</td>';
								echo '<td>' . $row['Nome'] . '</td>';
								echo '<td>' . $row['DataInicio'] . '</td>';
								echo '<td>' . $row['HoraInicio'] . '/' . $row['HoraFim'] . '</td>';
								if($TipoEvento == 2){
								
									if(isset($_SESSION['Agendamentos']['nomedo' . $nome]) && $_SESSION['Agendamentos']['nomedo' . $nome] == "S") {
										$nomedo_ = '*'.$row['Nome'.$nome.'2'].'*';
									}else{
										$nomedo_ = FALSE;
									}
																						
									if(isset($_SESSION['Agendamentos']['id' . $nome]) && $_SESSION['Agendamentos']['id' . $nome] == "S") {
										$id_ = '*'.$row['id_'.$nome].'*';
									}else{
										$id_ = FALSE;
									}
									
									if(isset($_SESSION['Agendamentos']['numerodopedido']) && $_SESSION['Agendamentos']['numerodopedido'] == "S") {
										$numerodopedido = '*'.$row['idApp_Consulta'].'*';
									}else{
										$numerodopedido = FALSE;
									}
																
									if(isset($_SESSION['Agendamentos']['site']) && $_SESSION['Agendamentos']['site'] == "S") {
										$site = ' https://enkontraki.com.br/'.$_SESSION['Empresa']['Site'];
									}else{
										$site = FALSE;
									}
																		
									
									$whatsapp = '<a class="notclickable" href="https://api.whatsapp.com/send?phone=55'.$row['Celular' . $nome].'&text='.$_SESSION['Agendamentos']['Texto1'].' '.$nomedo_.' '.$_SESSION['Agendamentos']['Texto2'].' '.$id_.' '.$_SESSION['Agendamentos']['Texto3'].' '.$numerodopedido.' '.$_SESSION['Agendamentos']['Texto4'].' '.$site.'  " target="_blank">
													<svg enable-background="new 0 0 512 512" width="20" height="20" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
												</a>';
									/*
									$whatsapp = '<a class="notclickable" href="https://api.whatsapp.com/send?phone=55'.$row['Celular' . $nome].'&text=" target="_blank">
													<svg enable-background="new 0 0 512 512" width="20" height="20" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
												</a>';
									*/			
									echo '<td>' . $row['Nome'.$nome] . ' - ' . $row['Celular'.$nome] . $whatsapp.'</td>';
									if($_SESSION['Empresa']['CadastrarPet'] == "S"){	
										echo '<td>' . $row['NomeClientePet'] . ' / Especie: ' . $row['Especie'] . ' / Raca: ' . $row['RacaPet'] . '
													/ Gen: ' . $row['Sexo'] . ' / Pelo: ' . $row['Pelo'] . ' / Porte: ' . $row['Porte'] . ' 
													/ Alrg: ' . $row['AlergicoPet'] . ' / Obs: ' . $row['ObsPet'] . '</td>';
									}
									if($_SESSION['Empresa']['CadastrarDep'] == "S"){	
										echo '<td>' . $row['NomeClienteDep'] . '</td>';
									}
									echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
									echo '<td>' . $row['Catprod'] . '</td>';
									echo '<td>' . $row['NomeProduto'] . '</td>';
									echo '<td>' . $row['ValorProduto'] . '</td>';
									echo '<td>' . $row['ObsProduto'] . '</td>';
								}
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
