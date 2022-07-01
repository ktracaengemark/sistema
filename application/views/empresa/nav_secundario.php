<?php if ($_SESSION['AdminEmpresa']['idSis_Empresa']) { ?>

		<nav class="navbar navbar-inverse navbar-fixed" role="banner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
					<div class="btn-menu btn-group">	
						<button type="button" class="btn btn-md btn-<?php echo $cor_cli;?>  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-file"></span>
								<?php echo '<small>' . $_SESSION['Empresa']['NomeEmpresa'] . '</small> - <small>' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?> 
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-file"> </span> Ver Dados da Empresa
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Dados da Empresa
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/atendimento\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/atendimento/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Horario de Atendimento
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Alterar Logo
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/saudacao\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/saudacao/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Saudacoes
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/pagseguro\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/pagseguro/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Pag Seguro
									</a>
								</a>
							</li>								
						</ul>
						
						
						
						
						
						
						
					</div>
						<!--
						<a class="navbar-brand" href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
							<?php echo '<small>' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>|<small>' . $_SESSION['Empresa']['NomeEmpresa'] . '.</small>' ?>
						</a>
						-->
				</div>
				<!--
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav navbar-center">
						<li class="botoesnav" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-md btn-<?php #echo $cor_cons;?>  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php #if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php #echo base_url() . 'consulta/listar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
												<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php #if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php #echo base_url() . 'consulta/cadastrar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
												<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
											</a>
										</a>
									</li>
								</ul>
							</div>									
						</li>
					</ul>
				</div>
				-->
			</div>
		</nav>
	
<?php } ?>