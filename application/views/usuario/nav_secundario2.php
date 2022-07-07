<?php if ($_SESSION['Empresa']['idSis_Empresa'] && $_SESSION['Usuario']['idSis_Usuario']) { ?>

		<nav class="navbar navbar-inverse navbar-fixed" role="banner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
					<div class="btn-menu btn-group">
						<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Usuario']['Nome'] . '</small> - <small>Id.: ' . $_SESSION['Usuario']['idSis_Usuario'] . '</small>' ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/usuario2\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'usuario2/prontuario/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-file"> </span>Ver Dados do Usuário
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<?php if ($_SESSION['log']['idSis_Empresa'] == 5 ) { ?>
								<li>
									<a <?php if (preg_match("/usuario2\/associadoalterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'usuario2/associadoalterar/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Editar Dados do Usuário
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/usuario2\/permissoes\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'usuario2/permissoes/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Editar Permissões do Usuário
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/usuario2\/alterarsenha\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'usuario2/alterarsenha/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Editar Senha
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
							<?php } ?>
							<li>
								<a <?php if (preg_match("/usuario2\/alterarconta\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'usuario2/alterarconta/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Conta Comissão
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/usuario2\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'usuario2/alterarlogo/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Alterar Foto
									</a>
								</a>
							</li>
							<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/usuario2\/revendedores\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'usuario2/revendedores/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
											<span class="glyphicon glyphicon-file"></span> Revendedores
										</a>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav navbar-center">
						<li class="botoesnav" role="toolbar" aria-label="...">
							<div class="btn-group">
								<!--
								<button type="button" class="btn btn-md btn-<?php #echo $cor_cons;?>  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php #if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php #echo base_url() . 'consulta/listar/' . $_SESSION['Usuario']['idSis_Empresa']; ?>">
												<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php #if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php #echo base_url() . 'consulta/cadastrar/' . $_SESSION['Usuario']['idSis_Empresa']; ?>">
												<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
											</a>
										</a>
									</li>
								</ul>
								-->
							</div>									
						</li>
					</ul>
				</div>
			</div>
		</nav>
	
<?php } ?>