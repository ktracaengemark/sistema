
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php if ($nav_secundario) echo $nav_secundario; ?>
			<?php if ($msg) {?>
				<div class="row">
					<div class="col-md-12">
						<?php echo $msg; ?>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<?php echo '<small>' . $titulo . '</small> <strong>' . $_SESSION['Cliente']['NomeCompleto'] . '</strong> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '.</small>' ?>
							
						</div>
						<div class="panel-body">
							
							<div>

								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" ><a style="color:red" href="#naocombinado" aria-controls="naocombinado" role="tab" data-toggle="tab">Não Aprov Ent <?php echo $naocombinado->num_rows(); ?></a></li>
									<li role="presentation" ><a style="color:red" href="#anterior" aria-controls="anterior" role="tab" data-toggle="tab">Não Aprov Pag <?php echo $naoaprovado->num_rows(); ?></a></li>
									<li role="presentation" ><a style="color:green" href="#combinado" aria-controls="combinado" role="tab" data-toggle="tab">Aprov Ent <?php echo $combinado->num_rows(); ?></a></li>
									<li role="presentation" class="active" ><a style="color:green" href="#proxima" aria-controls="proxima" role="tab" data-toggle="tab">Aprov Pag <?php echo $aprovado->num_rows(); ?></a></li>
									<li role="presentation" ><a style="color:green" href="#finalizado" aria-controls="finalizado" role="tab" data-toggle="tab">Finalizado <?php echo $finalizado->num_rows(); ?></a></li>
									<!--<li role="presentation" ><a style="color:red" href="#naofinalizado" aria-controls="naofinalizado" role="tab" data-toggle="tab">Não Finalizado <?php #echo $naofinalizado->num_rows(); ?></a></li>-->
									<li role="presentation" ><a style="color:black" href="#cancelado" aria-controls="cancelado" role="tab" data-toggle="tab">Cancelado <?php echo $cancelado->num_rows(); ?></a></li>
									<!--<li role="presentation" ><a style="color:black" href="#naocancelado" aria-controls="naocancelado" role="tab" data-toggle="tab">Não Cancelado <?php #echo $naocancelado->num_rows(); ?></a></li>-->
									<li role="presentation"><a style="color:green" href="#concluido_orc" aria-controls="concluido_orc" role="tab" data-toggle="tab">Procedimentos <?php echo $concluido_orc->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#nao_concluido_orc" aria-controls="nao_concluido_orc" role="tab" data-toggle="tab">Procedimentos <?php echo $nao_concluido_orc->num_rows(); ?></a></li>
								</ul>
								
								<!-- Tab panes -->
								<div class="tab-content">

									<!-- Combinados -->
									<div role="tabpanel" class="tab-pane " id="combinado">

										<?php
										if ($combinado) {

											foreach ($combinado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>
											
											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>

											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>
									
									<!-- Não Combinados -->
									<div role="tabpanel" class="tab-pane" id="naocombinado">

										<?php
										if ($naocombinado) {

											foreach ($naocombinado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-down"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Aprovados -->
									<div role="tabpanel" class="tab-pane active" id="proxima">

										<?php
										if ($aprovado) {

											foreach ($aprovado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>
											

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>
											
											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>

											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Não Aprovados -->
									<div role="tabpanel" class="tab-pane " id="anterior">

										<?php
										if ($naoaprovado) {

											foreach ($naoaprovado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-down"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Finalizados -->
									<div role="tabpanel" class="tab-pane " id="finalizado">

										<?php
										if ($finalizado) {

											foreach ($finalizado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Não Finalizados -->
									<div role="tabpanel" class="tab-pane " id="naofinalizado">

										<?php
										if ($naofinalizado) {

											foreach ($naofinalizado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Cancelado -->
									<div role="tabpanel" class="tab-pane " id="cancelado">

										<?php
										if ($cancelado) {

											foreach ($cancelado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Não Cancelado -->
									<div role="tabpanel" class="tab-pane " id="naocancelado">

										<?php
										if ($naocancelado) {

											foreach ($naocancelado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>


									<!-- Concluido-Orç -->
									<div role="tabpanel" class="tab-pane " id="concluido_orc">

										<?php
										if ($concluido_orc) {

											foreach ($concluido_orc->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
											<!--	
											<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão para Impressão
											</a>
											-->

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Orçam.:</b> <?php echo $row['idApp_OrcaTrata']; ?><br>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?> 
											</h4>
											<br>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>											
											<p>
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastro</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data Conclusão</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Não Concluido-Orç -->
									<div role="tabpanel" class="tab-pane " id="nao_concluido_orc">

										<?php
										if ($nao_concluido_orc) {

											foreach ($nao_concluido_orc->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<!--
											<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão para Impressão
											</a>
											-->
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Orçam.:</b> <?php echo $row['idApp_OrcaTrata']; ?><br>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b><?php echo $row['idApp_Procedimento']; ?>
											</h4>
											<br>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>											
											<p>
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastro</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data Conclusão</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
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
		<div class="col-md-1"></div>
	</div>	
</div>
