<?php if (isset($msg)) echo $msg; ?>

<div class="col-sm-offset-3 col-md-6 ">		
	
	<?php echo validation_errors(); ?>
		


			<nav class="navbar navbar-center navbar-inverse navbar-fixed-top">
			  <div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
					<!--
					<a class="navbar-brand" href="<?php echo base_url() ?>orcatrata/cadastrar3/"> 
						 <span class="glyphicon glyphicon-plus"></span> Nova Produto
					</a>
					
					<a  class="navbar-brand" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
						<span class="glyphicon glyphicon-plus"></span>Produto
					</a>
					-->		
					<?php if ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) { ?>	
					<a  class="navbar-brand" type="button" data-loading-text="Aguarde...">
						<div class="col-md-12 text-left">
							<label class="sr-only" for="Ordenamento">Agenda dos Prof.:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
									id="NomeUsuario" name="NomeUsuario">
								<?php
								foreach ($select['NomeUsuario'] as $key => $row) {
									if ($query['NomeUsuario'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>	
					</a>
					<?php } ?>
					
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav navbar-center">
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>agenda">
									<button type="button" class="btn btn-sm btn-info ">
										<span class="glyphicon glyphicon-calendar"></span> Agenda
									</button>
								</a>
							</div>
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>relatorio/clientes">
									<button type="button" class="btn btn-sm btn-success ">
										<span class="glyphicon glyphicon-user"></span> Clientes
									</button>
								</a>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-gift"></span> Produtos <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a href="<?php echo base_url() ?>relatorio/produtos"><span class="glyphicon glyphicon-gift"></span> Produtos</a></li>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/estoque"><span class="glyphicon glyphicon-list-alt"></span> Estoque</a></li>
								</ul>
							</div>																				
							<?php } ?>
						</li>						
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a <?php if (preg_match("/orcatrata\/cadastrar3\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'orcatrata/cadastrar3/'; ?>">
										<button type="button" class="btn btn-sm btn-primary ">
											<span class="glyphicon glyphicon-plus"></span> Receita
										</button>										
									</a>
								</a>
							</div>
							<div class="btn-group " role="group" aria-label="...">
								<a <?php if (preg_match("/orcatrata\/cadastrardesp\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'orcatrata/cadastrardesp/'; ?>">
										<button type="button" class="btn btn-sm btn-danger ">
											<span class="glyphicon glyphicon-plus"></span> Despesa
										</button>										
									</a>
								</a>
							</div>
							<div class="btn-group " role="group" aria-label="...">
								<a <?php if (preg_match("/relatorio\/financeiro\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'relatorio/financeiro/'; ?>">
										<button type="button" class="btn btn-sm btn-success ">
											<span class="glyphicon glyphicon-list"></span> Relatório
										</button>										
									</a>
								</a>
							</div>																				
						</li>
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a href="javascript:window.print()">
									<button type="button" class="btn btn-sm btn-default ">
										<span class="glyphicon glyphicon-print"></span> Imprimir
									</button>
								</a>
							</div>
							<div class="btn-group " role="group" aria-label="...">
								<a <?php if (preg_match("/relatorio\/estoque\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'relatorio/estoque/'; ?>">
										<button type="button" class="btn btn-sm btn-default ">
											<span class="glyphicon glyphicon-edit"></span> Estoque
										</button>										
									</a>
								</a>
							</div>
							<div class="btn-group " role="group" aria-label="...">
								<button  class="btn btn-sm btn-default" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
									<span class="glyphicon glyphicon-filter"></span>Filtros <!--<?php #echo $titulo; ?>-->
								</button>
							</div>
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url() . 'orcatrata/alterarprocedimento/' . $_SESSION['log']['idSis_Empresa']; ?>">
									<button type="button" class="btn btn-sm btn-info">
										<span class="glyphicon glyphicon-edit"></span>
									</button>
								</a>
							</div>

							
						</li>						
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a <?php if (preg_match("/agenda/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'agenda/'; ?>">
										<button type="button" class="btn btn-sm btn-active ">
											<span class="glyphicon glyphicon-remove"></span> Fechar
										</button>										
									</a>
								</a>
							</div>
							<div class="btn-group" role="group" aria-label="..."> </div>							
						</li>						
					</ul>
				</div>
			  </div>
			</nav>
			
	<div <?php echo $collapse; ?> id="Tarefas">	
		<div class="panel-body">
			<?php echo (isset($list1)) ? $list1 : FALSE ?>
		</div>
	</div>
	<div <?php echo $collapse; ?> id="Agenda">
		<div class="panel-body">
			<div class="text-right">
				<div <?php echo $collapse1; ?> id="Calendario">
						<div class="form-group" id="datepickerinline" class="col-md-12" >
						</div>
				</div>
			</div>
			<div class="form-group">
				<div  style="overflow: auto; height: 456px; "> 
						<table id="calendar" class="table table-condensed table-striped "></table>
				</div>
			</div>
		</div>
	</div>	
</div>
<?php echo form_open('agenda', 'role="form"'); ?>
<div id="fluxo" class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="fluxo" aria-hidden="true">
	<div class="vertical-alignment-helper">
		<div class="modal-dialog modal-sm vertical-align-center">
			<div class="modal-content">
				<div class="modal-body text-center">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<label for="">Agendamento:</label>
								<div class="form-group">
									<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>				
									<div class="row">
										<button type="button" id="MarcarConsulta" onclick="redirecionar(2)" class="btn btn-primary"> Com Cliente
										</button>
									</div>
									<?php } ?>
									<br>
									<div class="row">
										<button type="button" id="AgendarEvento" onclick="redirecionar(1)" class="btn btn-info"> Outro Evento
										</button>
									</div>
										<input type="hidden" id="start" />
										<input type="hidden" id="end" />
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtro de Tarefas</h4>
			</div>
			<div class="modal-footer">
				<div class="form-group">	
					<div class="row">	
						<div class="col-md-3 text-left">
							<label for="ConcluidoProcedimento">Concluido</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
									id="ConcluidoProcedimento" name="ConcluidoProcedimento">
								<?php
								foreach ($select['ConcluidoProcedimento'] as $key => $row) {
									if ($query['ConcluidoProcedimento'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>								
						<div class="col-md-3 text-left">
							<label for="Prioridade">Prioridade</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
									id="Prioridade" name="Prioridade">
								<?php
								foreach ($select['Prioridade'] as $key => $row) {
									if ($query['Prioridade'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>

						<div class="col-md-4 text-left">
							<label for="Ordenamento">Tarefa:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
									id="Procedimento" name="Procedimento">
								<?php
								foreach ($select['Procedimento'] as $key => $row) {
									if ($query['Procedimento'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="form-group col-md-3 text-left">
							<div class="form-footer ">
								<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
									<span class="glyphicon glyphicon-filter"></span> Filtrar
								</button>
							</div>
						</div>
						<div class="form-group col-md-3 text-left">
							<div class="form-footer ">
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
									<span class="glyphicon glyphicon-remove"> Fechar
								</button>
							</div>
						</div>
					</div>
					<div class="row">	
						<div class="col-md-12 text-left">
							<label for="Ordenamento">Ordenamento:</label>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
												id="Campo" name="Campo">
											<?php
											foreach ($select['Campo'] as $key => $row) {
												if ($query['Campo'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									<div class="col-md-4">
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
												id="Ordenamento" name="Ordenamento">
											<?php
											foreach ($select['Ordenamento'] as $key => $row) {
												if ($query['Ordenamento'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
						</div>								
					</div>							
					<!--
					<div class="row">	
						<div class="col-md-3 text-left" >
							<label for="Ordenamento">Dia:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
									id="Dia" name="Dia">
								<?php
								foreach ($select['Dia'] as $key => $row) {
									if ($query['Dia'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-3 text-left" >
							<label for="Ordenamento">Mês:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
									id="Mesvenc" name="Mesvenc">
								<?php
								foreach ($select['Mesvenc'] as $key => $row) {
									if ($query['Mesvenc'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-3 text-left" >
							<label for="Ordenamento">Ano:</label>
							<div>
								<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
									   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
							</div>
						</div>
					</div>
					-->
				</div>											
			</div>
		</div>
	</div>
</div>