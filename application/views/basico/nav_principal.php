<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="col-lg-1 col-md-1">	
	</div>
	<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
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
					<button type="button" class="btn btn-sm btn-default btn-block dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-user"></span>
							<strong>Clientes</strong>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo base_url() ?>relatorio/clientes"><span class="glyphicon glyphicon-user"></span> Clientes/ Dep/ Pet</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/rankingvendas"><span class="glyphicon glyphicon-user"></span> Ranking & CashBack</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/sac"><span class="glyphicon glyphicon-pencil"></span> Sac</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/marketing"><span class="glyphicon glyphicon-pencil"></span> Marketing</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes</a></li>
					</ul>
				</div>
			<?php } ?>
		</div>
	</div>		
	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 ">		
		<div class="collapse navbar-collapse" id="myNavbar1">
			<ul class="nav navbar-nav navbar-center">
				<li class="botoesnav" >
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
							Agenda | Tarefas | <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a class="dropdown-item" href="<?php echo base_url() ?>agenda"><span class="glyphicon glyphicon-calendar"></span> Agenda </a></li>
							<li role="separator" class="divider"></li>
							<li><a class="dropdown-item" href="<?php echo base_url() ?>tarefa"><span class="glyphicon glyphicon-pencil"></span> Tarefas </a></li>
							<li role="separator" class="divider"></li>
							<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes </a></li>
						</ul>
					</div>							
				</li>						
				<li class="botoesnav">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
							Receitas | Vendas | <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>pedidos/pedidos"><span class="glyphicon glyphicon-pencil"></span> Gestor Dinamico de Receitas</a></li>
								<li role="separator" class="divider"></li>
							<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
								<li><a href="<?php echo base_url() ?>pedidos_statico/pedidos"><span class="glyphicon glyphicon-pencil"></span> Gestor Estatico de Receitas</a></li>
							<?php } ?>
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
							<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes</a></li>						
						</ul>
					</div>							
				</li>
				<li class="botoesnav">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
							 Despesas | Compras | <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>despesas_statico/despesas"><span class="glyphicon glyphicon-pencil"></span> Gestor Estatico de Despesas </a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>Orcatrata/cadastrardesp"><span class="glyphicon glyphicon-plus"></span> Nova Despesa</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes </a></li>							
						</ul>
					</div>							
				</li>
				<li class="botoesnav">								
					<div class="btn-group">
						<?php
							$data1 = new DateTime(); 
							$data2 = new DateTime($_SESSION['log']['DataDeValidade']); 
							if (($data2 <= $data1) && ($_SESSION['log']['idSis_Empresa'] != 5)){
								$atua_flash = 'flash';
							}else{
								$atua_flash = '';
							}
						?>
						<button type="button" class="<?php echo $atua_flash ?> btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
							
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
								
								<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?>| Sair
							<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
								<span class="glyphicon glyphicon-warning-sign"></span>Renovar ! 
								<span class="glyphicon glyphicon-home"></span>Sair
							<?php } else {?>
								<span class="glyphicon glyphicon-home"></span> enkontraki|Sair
							<?php } ?>
							 | <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">						
							<?php if ($_SESSION['log']['idSis_Empresa'] != 5) { ?>
								<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-barcode"></span> Administração</a></li>
								<li role="separator" class="divider"></li>
							<?php } ?>
							<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>login/sair"><span class="glyphicon glyphicon-log-out"></span> Sair do Sistema</a></li>
						</ul>
					</div>
				</li>
				<li class="botoesnav">
					<?php 
						if($_SESSION['log']['idSis_Empresa'] == "5"){
							$usuario = 'associado';
						}else{
							
							$usuario = 'usuario2';
						}
					?>				
					<a href="<?php echo base_url() ?><?php echo $usuario; ?>/prontuario/<?php echo $_SESSION['log']['idSis_Usuario']; ?>" > 
						<img class="img-circle img-responsive" width='30' height='30' style="margin-top:-15px; margin-bottom:-10px" alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Usuario']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['Usuario']['Arquivo'] . ''; ?>">
					</a>
				</li>					
			</ul>
		</div>
	</div>
</nav>
<br>