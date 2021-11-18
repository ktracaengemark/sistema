<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">

	<div class=" col-lg-12 col-md-12 col-sm-12">
		<div class="navbar-header ">
			<button type="button" class="navbar-toggle " data-toggle="collapse" data-target="#myNavbar1">
				<span class="sr-only">MENU</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a type="button" class="navbar-brand btn btn-sm" href="<?php echo base_url() ?>empresa/prontuario/<?php echo $_SESSION['log']['idSis_Empresa']; ?>"> 
				<?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
			</a>
			<!--<a class="navbar-brand" href="https://www.enkontraki.com"> Melhor loja</a>-->
		</div>
		<div class="collapse navbar-collapse" id="myNavbar1">
			<ul class="nav navbar-nav navbar-center">				
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">				
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorioempresa/login">
							<button type="button" class="btn btn-sm btn-success ">
								<span class="glyphicon glyphicon-log-in"></span> Acessar Empresa
							</button>
						</a>
					</div>
				</li>
				<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-pencil"></span> Cadastros & Relatórios  <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">							
							<li><a href="<?php echo base_url() ?>relatorioempresa/funcionario"><span class="glyphicon glyphicon-user"></span> Funcionários </a></li>
							<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorioempresa/associado"><span class="glyphicon glyphicon-home"></span> Empresas Associadas </a></li>
						</ul>
					</div>
				</li>				
				<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">								
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
							
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
								<span class="glyphicon glyphicon-hand-right"></span>
								<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?> 
								 / <span class="glyphicon glyphicon-home"></span> Admin / Sair
							<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
								<span class="glyphicon glyphicon-warning-sign"></span> Renovar ! 
								<span class="glyphicon glyphicon-home"></span> Admin / Sair
							<?php } else {?>
								<span class="glyphicon glyphicon-home"></span> enkontraki / Sair
							<?php } ?>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">							
							<li><a href="<?php echo base_url() ?>acessoempresa"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
							<li role="separator" class="divider"></li>
							<li>
								<a href="<?php echo base_url() ?>empresa/prontuario/<?php echo $_SESSION['log']['idSis_Empresa']; ?>"> 
									<span class="glyphicon glyphicon-pencil"></span> <?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<!--
							<li>
								<a href="<?php #echo base_url() ?>empresa/pagina/<?php #echo $_SESSION['log']['idSis_Empresa']; ?>">
									<span class="glyphicon glyphicon-user"></span> Página
								</a>
							</li>
							<li role="separator" class="divider"></li>
							-->
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
							<li><a href="<?php echo base_url() ?>../enkontraki/login_cliente.php?id_empresa=<?php echo $_SESSION['log']['idSis_Empresa']; ?>" target="_blank"><span class="glyphicon glyphicon-pencil"></span> Renovar Assinatura</a></li>
							<li role="separator" class="divider"></li>									
							<?php } ?>
							<li><a href="<?php echo base_url() ?>relatorioempresa/empresas"><span class="glyphicon glyphicon-home"></span> Empresas</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>login/sair"><span class="glyphicon glyphicon-log-out"></span> Sair do Sistema</a></li>
						</ul>
					</div>
				</li>				
			</ul>
		</div>
	</div>
</nav>
<br>
