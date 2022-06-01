<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php if ($nav_secundario) echo $nav_secundario; ?>
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading">
							<?php echo '<small>' . $titulo . '</small> <strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?>
						</div>
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

	
