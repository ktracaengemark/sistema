<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong> - <small>Id.: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?></strong></div>
				<div class="panel-body">
			
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="col-md-4 text-left">
									<label for="">Cliente & Contatos:</label>
									<div class="form-group">
										<div class="row">	
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
												</a>
											</a>				
											<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Edit.
												</a>
											</a>
										</div>
									</div>	
								</div>

								<div class="col-md-4 text-center">
									<label for="">Consultas:</label>
									<div class="form-group">
										<div class="row">
											<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-list-alt"></span> List.
												</a>
											</a>
											<a <?php if (preg_match("/consulta\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-plus"></span> Cad.
												</a>
											</a>
										</div>	
									</div>	
								</div>

								<div class="col-md-4 text-right">
									<label for="">Orçamentos:</label>
									<div class="form-group ">
										<div class="row">
											<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-list-alt"></span> List.
												</a>
											</a>
											<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-plus"></span> Cad.
												</a>
											</a>
										</div>		
									</div>	
								</div>
							</div>	
						</div>	
					</div>		
					<!--
					<div class="form-group">		
						<div class="row">
							<div class="text-center t">
								<h3><?php echo '<strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong> - <small>Id.: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?></h3>
							</div>
						</div>
					</div>
					-->
					<div class="row">
					
						<div class="col-md-12 col-lg-12">

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong></strong></div>
								<div class="panel-body">
		
									<div>

										<!-- Nav tabs -->
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" ><a href="#anterior" aria-controls="anterior" role="tab" data-toggle="tab">Hist. de Agend.</a></li>
											<li role="presentation" class="active"><a href="#proxima" aria-controls="proxima" role="tab" data-toggle="tab">Próx. Agend.</a></li>
										   
										</ul>

										<!-- Tab panes -->
										<div class="tab-content">
											
											<!-- Histórico de Consultas -->
											<div role="tabpanel" class="tab-pane" id="anterior">

												<?php
												if ($anterior) {

													foreach ($anterior->result_array() as $row) {

														$row['DataInicio'] = explode(' ', $row['DataInicio']);
														$row['DataFim'] = explode(' ', $row['DataFim']);

														($row['Paciente'] == 'D') ? 
															$row['NomePaciente'] = '<b>ContatoCliente</b> - ' . $row['NomeContatoCliente'] : 
															$row['NomePaciente'] = 'O Próprio ';
														
														echo '<div data-href="' . base_url() . 'consulta/alterar/' . $row['idApp_Cliente'] . '/' . $row['idApp_Consulta'] . '" '
														. 'class="clickable-row bs-callout bs-callout-' . $this->basico->tipo_status_cor($row['idTab_Status']) . '">';
														echo '<h4><b>Status: ' . $row['Status'] . '</b></h4>';
														echo '<p><b>Data:</b> ' . $this->basico->mascara_data($row['DataInicio'][0], 'barras') . ' '
														. 'das ' . substr($row['DataInicio'][1], 0, 5) . ' às ' . substr($row['DataFim'][1], 0, 5) . '</p>';
														#echo '<p><b>Fregues:</b> ' . $row['NomePaciente'] . '</p>';
														echo '<p><b>Profissional:</b> ' . $row['Nome'] . '</p>';                                
														echo '<p><b>Obs:</b><br> ' . nl2br($row['Obs']) . '</p>';
														echo '</div>';                                
													}
												} else {
													echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhuma consulta registrada</b></div>';
												}
												?>            

											</div>
											
											<!-- Próximas Consultas -->
											<div role="tabpanel" class="tab-pane active" id="proxima">

												<?php
												if ($proxima) {

													foreach ($proxima->result_array() as $row) {

														$row['DataInicio'] = explode(' ', $row['DataInicio']);
														$row['DataFim'] = explode(' ', $row['DataFim']);

														($row['Paciente'] == 'D') ? 
															$row['NomePaciente'] = '<b>ContatoCliente</b> - ' . $row['NomeContatoCliente'] : 
															$row['NomePaciente'] = 'O Próprio ';
														
														echo '<div data-href="' . base_url() . 'consulta/alterar/' . $row['idApp_Cliente'] . '/' . $row['idApp_Consulta'] . '" '
														. 'class="clickable-row bs-callout bs-callout-' . $this->basico->tipo_status_cor($row['idTab_Status']) . '">';
														echo '<h4><b>Status: ' . $row['Status'] . '</b></h4>';
														echo '<p><b>Data:</b> ' . $this->basico->mascara_data($row['DataInicio'][0], 'barras') . ' '
														. 'das ' . substr($row['DataInicio'][1], 0, 5) . ' às ' . substr($row['DataFim'][1], 0, 5) . '</p>';
														#echo '<p><b>Fregues:</b> ' . $row['NomePaciente'] . '</p>';
														echo '<p><b>Profissional:</b> ' . $row['Nome'] . '</p>';                                
														echo '<p><b>Obs:</b><br> ' . nl2br($row['Obs']) . '</p>';
														echo '</div>';
													}
												} else {
													echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhuma consulta registrada</b></div>';
												}
												?>

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
		<div class="col-md-2"></div>
	</div>	
</div>

	<?php } ?>
