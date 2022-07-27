<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<div class="navbar-header ">
			<button type="button" class="navbar-toggle " data-toggle="collapse" data-target="#myNavbar1">
				<span class="sr-only">MENU</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<!--<a type="button" class="navbar-brand btn btn-sm" href="<?php #echo base_url() ?>empresa/prontuario/<?php #echo $_SESSION['log']['idSis_Empresa']; ?>"> 
				<?php #echo $_SESSION['log']['NomeEmpresa2']; ?>.
			</a>
			<a class="navbar-brand" href="https://www.enkontraki.com"> Melhor loja</a>-->

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8 btn-menu btn-group ">
				<div class="btn-group" role="group" aria-label="Grupo de botões com dropdown aninhado">
					<a type="button" class="btn btn-secondary btn-sm btn-default" href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['AdminEmpresa']['idSis_Empresa']; ?>" role="button">
						<span class="glyphicon glyphicon-home"></span>
						<strong><?php echo $_SESSION['AdminEmpresa']['NomeEmpresa']; ?></strong>
					</a>
					<!--<div class="btn-group" role="group">-->				
						<button type="button" class="btn btn-secondary btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">							
							<li>
								<a href="<?php echo base_url() ?>acessoempresa">
									<span class="glyphicon glyphicon-home"></span> Perfil
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['AdminEmpresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-file"> </span> Ver Dados da Empresa
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['AdminEmpresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Dados da Empresa
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/atendimento\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/atendimento/' . $_SESSION['AdminEmpresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Horario de Atendimento
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['AdminEmpresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Alterar Logo
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/saudacao\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/saudacao/' . $_SESSION['AdminEmpresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-file"></span> Saudacoes
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/pagseguro\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/pagseguro/' . $_SESSION['AdminEmpresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-file"></span> Pag Seguro
									</a>
								</a>
							</li>								
						</ul>						
					<!--</div>-->
				</div>
			</div>
		</div>
	</div>		
	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 ">	
		<div class="collapse navbar-collapse" id="myNavbar1">
			<ul class="nav navbar-nav navbar-center">
				<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="Grupo de botões com dropdown aninhado">
						<a type="button" class="btn btn-secondary btn-sm btn-info " href="<?php echo base_url() ?>relatorioempresa/funcionario" role="button">
							 Usuarios 
						</a>
						<!--<div class="btn-group" role="group">-->
							<button type="button" class="btn btn-sm btn-info  dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">							
								<li><a href="<?php echo base_url() ?>relatorioempresa/funcionario"><span class="glyphicon glyphicon-user"></span> Lista de Usuários </a></li>
							</ul>
						<!--</div>-->
					</div>
				</li>
				<!--
				<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-pencil"></span> Empresas Associadas  <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">							
							<li><a href="<?php #echo base_url() ?>relatorioempresa/associado"><span class="glyphicon glyphicon-home"></span> Lista de Empresas Associadas </a></li>
						</ul>
					</div>
				</li>
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">				
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorioempresa/login">
							<button type="button" class="btn btn-sm btn-success ">
								<span class="glyphicon glyphicon-home"></span> Loja
							</button>
						</a>
					</div>
				</li>
				-->
				
				<li class="botoesnav">
					<div class="btn-group" role="group" aria-label="Grupo de botões com dropdown aninhado">
						<?php
							$data1 = new DateTime(); 
							$data2 = new DateTime($_SESSION['log']['DataDeValidade']); 
							if (($data2 <= $data1) && ($_SESSION['log']['idSis_Empresa'] != 5)){
								$atua_flash = 'flash';
							}else{
								$atua_flash = '';
							}
						?>
						<a type="button" class="<?php echo $atua_flash ?> btn btn-secondary btn-sm btn-warning" href="<?php echo base_url(); ?>relatorioempresa/login" role="button">
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
								Acessar Loja
							<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
								Acessar Loja
							<?php } else {?>
								Sair
							<?php } ?>
						</a>
						<!--<div class="btn-group" role="group">-->
							<button type="button" class="<?php echo $atua_flash ?> btn btn-secondary btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
								<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
									
									<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?> 
								<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
									<span class="glyphicon glyphicon-warning-sign"></span> Renovar
								<?php } else {?>
									<span class="glyphicon glyphicon-home"></span> enkontraki
								<?php } ?>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo base_url() ?>relatorioempresa/login"><span class="glyphicon glyphicon-home"></span> Acessar Loja</a></li>
								<li role="separator" class="divider"></li>
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
								<li><a href="<?php echo base_url() ?>../enkontraki/login_cliente.php?id_empresa=<?php echo $_SESSION['log']['idSis_Empresa']; ?>" target="_blank"><span class="glyphicon glyphicon-pencil"></span> Renovar Assinatura</a></li>
								<li role="separator" class="divider"></li>									
								<?php } ?>
								<li><a href="<?php echo base_url() ?>relatorioempresa/empresas"><span class="glyphicon glyphicon-home"></span> Empresas</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>login/sair"><span class="glyphicon glyphicon-log-out"></span> Sair do Sistema</a></li>
							</ul>
						<!--</div>-->
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
<br>
