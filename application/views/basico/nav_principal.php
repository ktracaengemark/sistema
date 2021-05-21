<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="col-lg-12 col-md-12 col-sm-12 ">
		<div class="navbar-header ">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">
				<span class="sr-only">MENU</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php if($_SESSION['log']['idSis_Empresa'] == "5") {?>
				<a type="button" class="navbar-brand btn btn-sm" href="<?php echo base_url() ?>usuario2/prontuario/<?php echo $_SESSION['log']['idSis_Usuario']; ?>"> 
					 <?php echo $_SESSION['log']['Nome2']; ?>./<?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
				</a>
			<?php }else{?>	
				<?php echo form_open(base_url() . 'cliente/pesquisar', 'class="navbar-form navbar-left"'); ?>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-info btn-md" type="submit">
							<span class="glyphicon glyphicon-user"></span> <span class="glyphicon glyphicon-search"></span> 
						</button>
					</span>
					<input type="text" placeholder="Pesquisar Cliente" class="form-control btn-sm " name="Pesquisa" value="">
				</div>
				</form>
			<?php } ?>	
		</div>
		<div class="collapse navbar-collapse" id="myNavbar1">

			<ul class="nav navbar-nav navbar-center">
				<!--
				<li>
					<?php #echo form_open(base_url() . 'empresacli/pesquisar', 'class="navbar-form navbar-left"'); ?>
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-info" type="submit">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
						<input type="text" placeholder="Pesquisar Empresa" class="form-control" name="Pesquisa" value="">
					</div>
					</form>
				</li>
				-->
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group">
						<!--
						<a type="button" class="btn btn-sm btn-success" role="button" href="<?php echo base_url(); ?>agenda">
							 Tarefas <span class="glyphicon glyphicon-pencil"></span> |  
							 Agenda <span class="glyphicon glyphicon-calendar"></span>
						</a>
						<button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
						</button>
						-->
						<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-calendar"></span> Agenda | 
							<span class="glyphicon glyphicon-pencil"></span> Tarefas |  <span class="caret"></span>
						</button>
						
						<ul class="dropdown-menu" role="menu">
							<li><a class="dropdown-item" href="<?php echo base_url() ?>agenda"><span class="glyphicon glyphicon-calendar"></span> Agenda </a></li>
							<li role="separator" class="divider"></li>
							<li><a class="dropdown-item" href="<?php echo base_url() ?>tarefa"><span class="glyphicon glyphicon-pencil"></span> Tarefas </a></li>
							<li role="separator" class="divider"></li>
							<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes </a></li>
							<!--<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>Consulta/alterar_recorrencia"><span class="glyphicon glyphicon-plus"></span> Alterar Recorencias</a></li>-->
						</ul>
					</div>							
				</li>						
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group">
						<!--
							<a type="button" class="btn btn-sm btn-primary" role="button" href="<?php echo base_url(); ?>pedidos/pedidos">
							Receitas<span class="glyphicon glyphicon-usd"></span><span class="glyphicon glyphicon-arrow-down"></span> & 
							Vendas<span class="glyphicon glyphicon-gift"></span><span class="glyphicon glyphicon-arrow-up"></span>

						</a>
						<button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
						</button>
						-->
						<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-usd"></span> Receitas <span class="glyphicon glyphicon-arrow-down"></span> |  
							<span class="glyphicon glyphicon-gift"></span> Vendas <span class="glyphicon glyphicon-arrow-up"></span> | <span class="caret"></span>
						</button>
						
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>pedidos/pedidos"><span class="glyphicon glyphicon-pencil"></span> Gestor de Receitas Dinamico</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>orcatrata/pedidos"><span class="glyphicon glyphicon-pencil"></span> Gestor de Receitas Statico</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>Orcatrata/cadastrar3"><span class="glyphicon glyphicon-plus"></span> Nova Receita</a></li>
							
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes</a></li>
							<?php if ($_SESSION['log']['idSis_Empresa'] == 5 ) { ?>
							<!--<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/orcamentoonline"><span class="glyphicon glyphicon-pencil"></span> Or�amentos Online</a></li>
							<li role="separator" class="divider"></li>							
							<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/produtosvendaonline"><span class="glyphicon glyphicon-pencil"></span> Produtos Vendidos Online</a></li>
							<li role="separator" class="divider"></li>-->
							<?php } else {?>
							<!--<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/orcamentoonlineempresa"><span class="glyphicon glyphicon-pencil"></span> Or�amentos Online</a></li>
							<li role="separator" class="divider"></li>-->						
							<?php } ?>
							<!--<li><a href="<?php echo base_url() ?>relatorio/rankingreceitas"><span class="glyphicon glyphicon-equalizer"></span> Estat�stica das Receitas</a></li>-->
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
							<!--<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/fiadorec"><span class="glyphicon glyphicon-usd"></span> Fiado das Vendas</a></li>
							<li role="separator" class="divider"></li>-->
							<?php } ?>						
						</ul>
					</div>							
				</li>
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group">
						<!--
							<a type="button" class="btn btn-sm btn-danger" role="button" href="<?php echo base_url(); ?>despesas/despesas">
							Despesas<span class="glyphicon glyphicon-usd"></span><span class="glyphicon glyphicon-arrow-up"></span>/ 
							Compras<span class="glyphicon glyphicon-gift"></span><span class="glyphicon glyphicon-arrow-down"></span>
						</a>
						<button type="button" class="btn btn-sm btn-danger dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
						</button>
						-->
						<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
							 <span class="glyphicon glyphicon-usd"></span> Despesas <span class="glyphicon glyphicon-arrow-up"></span>  | 
							 <span class="glyphicon glyphicon-gift"></span> Compras <span class="glyphicon glyphicon-arrow-down"></span>  | <span class="caret"></span>
						</button>
						
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>despesas/despesas"><span class="glyphicon glyphicon-pencil"></span> Gestor de Despesas Dinamico</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>Orcatrata/cadastrardesp"><span class="glyphicon glyphicon-plus"></span> Nova Despesa</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes </a></li>
							<!--<li role="separator" class="divider"></li>
							<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/parcelasdesp"><span class="glyphicon glyphicon-pencil"></span> Relat�rio das Despesas</a></li>
							<li role="separator" class="divider"></li>-->
							<!--<li><a href="<?php echo base_url() ?>relatorio/rankingdespesas"><span class="glyphicon glyphicon-equalizer"></span> Estat�stica das Despesas</a></li>-->
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
							<!--<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/fiadodesp"><span class="glyphicon glyphicon-usd"></span> Fiado das Compras</a></li>
							<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/produtoscomp"><span class="glyphicon glyphicon-pencil"></span> Produtos Comprados </a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/rankingcompras"><span class="glyphicon glyphicon-pencil"></span> Ranking de Compras</a></li>-->
							<?php } ?>
							<!--<li role="separator" class="divider"></li>-->							
						</ul>
					</div>							
				</li>
				<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">								
					<div class="btn-group">
						<!--
						<a type="button" class="btn btn-sm btn-default" role="button" href="<?php echo base_url(); ?>relatorio/loginempresa">
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
						</a>
						<button type="button" class="btn btn-sm btn-default dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
						</button>
						-->
						<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
							
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
								<span class="glyphicon glyphicon-hand-right"></span>
								<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?> 
								 | <span class="glyphicon glyphicon-home"></span> Admin | Sair
							<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
								<span class="glyphicon glyphicon-warning-sign"></span> Renovar ! 
								<span class="glyphicon glyphicon-home"></span> Admin | Sair
							<?php } else {?>
								<span class="glyphicon glyphicon-home"></span> enkontraki | Sair
							<?php } ?>
							 | <span class="caret"></span>
						</button>
						
						
						<ul class="dropdown-menu" role="menu">
							<!--
							<li>
								<a href="<?php echo base_url() ?>acesso"> 
									<span class="glyphicon glyphicon-user"></span> Perfil
								</a>
							</li>
							<li role="separator" class="divider"></li>
							-->							
							<?php if ($_SESSION['log']['idSis_Empresa'] != 5) { ?>	
							<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-pencil"></span> Administracao</a></li>
							<li role="separator" class="divider"></li>
							<?php } ?>
							<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-list"></span> Mais Opcoes</a></li>
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