<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<div class="navbar-header ">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">
				<span class="sr-only">MENU</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php if($_SESSION['log']['idSis_Empresa'] == "5") {?>
				<a type="button" class="navbar-brand btn btn-sm" href="<?php echo base_url() ?>associado/prontuario/<?php echo $_SESSION['log']['idSis_Usuario']; ?>"> 
					 <?php echo $_SESSION['log']['Nome2']; ?>./<?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
				</a>
			<?php }else{?>	
				<!--
				<?php #echo form_open(base_url() . 'cliente/pesquisar', 'class="pesquisarnav navbar-left"'); ?>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-info btn-md" type="submit">
							<span class="glyphicon glyphicon-search"></span> 
						</button>
					</span>
					<input type="text" placeholder="Pesquisar Cliente" class="form-control btn-sm " name="Pesquisa" value="">
				</div>
				</form>
				-->
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8 btn-menu btn-group ">
					<div class="btn-group" role="group" aria-label="Grupo de botões com dropdown aninhado">
						<a type="button" class="btn btn-secondary btn-sm btn-default" data-toggle="tooltip" data-placement="bottom" title="Pesquisar Clientes"  href="<?php echo base_url() ?>Cliente/clientes" role="button">
							<span class="glyphicon glyphicon-user"></span> Pesquisar
						</a>
						<!--<div class="btn-group" role="group">-->
							<button type="button" class="btn btn-secondary btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
								 <span data-toggle="tooltip" data-placement="bottom" title="mais opcoes">Clientes <span class="caret"></span></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo base_url() ?>Cliente/clientes"><span class="glyphicon glyphicon-user"></span> Pesquisar Clientes</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>Cliente/rankingvendas"><span class="glyphicon glyphicon-usd"></span> Ranking & CashBack</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>Sac/sac"><span class="glyphicon glyphicon-pencil"></span> Sac</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>Marketing/marketing"><span class="glyphicon glyphicon-pencil"></span> Marketing</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes</a></li>
							</ul>
						<!--</div>-->
					</div>
				</div>
			<?php } ?>
		</div>
	</div>		
	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 ">		
		<div class="collapse navbar-collapse" id="myNavbar1">
			<ul class="nav navbar-nav navbar-center">
				<li class="botoesnav" >
					<div class="btn-group" role="group" aria-label="Grupo de botões com dropdown aninhado">
						<a type="button" class="btn btn-secondary btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Acessar a Agenda" href="<?php echo base_url() ?>agenda" role="button">
							 Agenda  
						</a>
						<!--<div class="btn-group" role="group">-->
							<button type="button" class="btn btn-secondary btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
								<span data-toggle="tooltip" data-placement="bottom" title="mais opcoes">Tarefas <span class="caret"></span></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a class="dropdown-item" href="<?php echo base_url() ?>agenda"><span class="glyphicon glyphicon-calendar"></span> Agenda </a></li>
								<li role="separator" class="divider"></li>
								<li><a class="dropdown-item" href="<?php echo base_url() ?>tarefa"><span class="glyphicon glyphicon-pencil"></span> Tarefas </a></li>
								<li role="separator" class="divider"></li>
								<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes </a></li>
							</ul>
						<!--</div>-->
					</div>	
				</li>						
				<li class="botoesnav">
					<div class="btn-group" role="group" aria-label="Grupo de botões com dropdown aninhado">
						<a type="button" class="btn btn-secondary btn-sm btn-primary" data-toggle="tooltip" data-placement="bottom" title="Gestor de Receitas Dinamico"  href="<?php echo base_url() ?>receitas_dinamico/pedidos" role="button">
							 Receitas 
						</a>
						<!--<div class="btn-group" role="group">-->
							<button type="button" class="btn btn-secondary btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
								<span data-toggle="tooltip" data-placement="bottom" title="mais opcoes">Vendas <span class="caret"></span></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
								<li><a href="<?php echo base_url() ?>receitas_dinamico/pedidos"><span class="glyphicon glyphicon-pencil"></span> Gestor de Receitas Dinamico</a></li>
									<li role="separator" class="divider"></li>
								<?php } ?>
									<li><a href="<?php echo base_url() ?>receitas_statico/pedidos"><span class="glyphicon glyphicon-pencil"></span> Gestor de Receitas Estatico</a></li>
								<?php if ($_SESSION['log']['idSis_Empresa'] == 5 ) { ?>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>Orcatrata/cadastrar3"><span class="glyphicon glyphicon-plus"></span> Nova Receita</a></li>
								<?php }else{ ?>	
									<?php if ($_SESSION['log']['Cad_Orcam'] == "S" ) { ?>	
										<li role="separator" class="divider"></li>
										<li><a href="<?php echo base_url() ?>Orcatrata/cadastrar3"><span class="glyphicon glyphicon-plus"></span> Nova Receita</a></li>
									<?php } ?>
								<?php } ?>	
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanco</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes</a></li>						
							</ul>
						<!--</div>-->
					</div>							
				</li>
				<li class="botoesnav">
					<div class="btn-group" role="group" aria-label="Grupo de botões com dropdown aninhado">
						<a type="button" class="btn btn-secondary btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Gestor de Despesas Statico"  href="<?php echo base_url() ?>despesas_statico/pedidos" role="button">
							 Despesas 
						</a>
						<!--<div class="btn-group" role="group">-->
							<button type="button" class="btn btn-secondary btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
								<span data-toggle="tooltip" data-placement="bottom" title="mais opcoes">Compras <span class="caret"></span></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo base_url() ?>despesas_statico/pedidos"><span class="glyphicon glyphicon-pencil"></span> Gestor Estatico</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>Orcatrata/cadastrardesp"><span class="glyphicon glyphicon-plus"></span> Nova Despesa</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanco</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes </a></li>							
							</ul>
						<!--</div>-->
					</div>							
				</li>
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
							 
							if ($_SESSION['log']['idSis_Empresa'] != 5){
								$loginempresa = base_url() . 'relatorio/loginempresa';
							}else{
								$loginempresa = '';
							}
						?>
						<a type="button" class="<?php echo $atua_flash ?> btn btn-secondary btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Administracao"  href="<?php echo $loginempresa ?>" role="button">
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
								Admin
							<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
								Admin
							<?php } else {?>
								Sair
							<?php } ?>
						</a>
						<!--<div class="btn-group" role="group">-->
							<button type="button" class="<?php echo $atua_flash ?> btn btn-secondary btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
								<span data-toggle="tooltip" data-placement="bottom" title="mais opcoes">
									<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
										<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?>
									<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
										<span class="glyphicon glyphicon-warning-sign"> </span> Renovar 
									<?php } else {?>
										<span class="glyphicon glyphicon-home"></span> enkontraki
									<?php } ?>
									<span class="caret"></span>
								</span>
							</button>
							<ul class="dropdown-menu" role="menu">						
								<?php if ($_SESSION['log']['idSis_Empresa'] != 5) { ?>
									<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-barcode"></span> Administracao</a></li>
									<li role="separator" class="divider"></li>
								<?php } ?>
								<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes</a></li>
							</ul>
						<!--</div>-->
					</div>
				</li>
				<li class="botoesnav">
					<div class="btn-group" role="group" aria-label="Grupo de botões com dropdown aninhado">
						<?php 
							if($_SESSION['log']['idSis_Empresa'] == "5"){
								$usuario = 'associado';
							}else{
								
								$usuario = 'usuario2';
							}
						?>
						<!--<div class="btn-group" role="group">-->
							<a type="button" class="dropdown-toggle" data-toggle="dropdown">
								<span data-toggle="tooltip" data-placement="bottom" title="<?php echo $_SESSION['log']['Nome']; ?>">
									<img class="img-circle img-responsive" width='30' height='30' style="margin-top:0px; margin-bottom:-10px" alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Usuario']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['Usuario']['Arquivo'] . ''; ?>">
								</span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo base_url() ?><?php echo $usuario; ?>/prontuario/<?php echo $_SESSION['log']['idSis_Usuario']; ?>"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
								<?php if($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Empresa']['Rede'] == "S" && $_SESSION['Usuario']['Nivel'] == 1 ) { ?>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>Usuario2/revendedores/<?php echo $_SESSION['log']['idSis_Usuario']; ?>"><span class="glyphicon glyphicon-user"></span> Revendedores</a></li>
								<?php } ?>
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