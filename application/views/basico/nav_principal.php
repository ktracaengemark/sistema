<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="container">
		<div class="navbar-header ">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">MENU</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
			<!--<a class="navbar-brand" href="http://www.ktracaengemark.com.br"> Melhor loja</a>-->
		</div>
		<div class="collapse navbar-collapse">

			<ul class="nav navbar-nav navbar-center">
				<!--
				<li>
					<?php echo form_open(base_url() . 'cliente/pesquisar', 'class="navbar-form navbar-left"'); ?>
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-info" type="submit">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
						<input type="text" placeholder="Pesquisar Cliente" class="form-control" name="Pesquisa" value="">
					</div>
					</form>
				</li>

				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">

					<div class="btn-group">
						<button type="button" class="btn btn-md btn-primary  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['log']['Usuario']; ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>acesso/index"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['log']['Usuario']; ?></a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url(); ?>agenda"><span class="glyphicon glyphicon-calendar"></span>Agenda</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>tipobanco/cadastrar"><span class="glyphicon glyphicon-usd"></span> Cad - Conta Corrente</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/empresaassociado"><span class="glyphicon glyphicon-pencil"></span> Cad - Associados</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url(); ?>login/sair"><span class="glyphicon glyphicon-pencil"><span class="glyphicon glyphicon-log-out"></span> Sair</a></li>
							<li role="separator" class="divider"></li>
						</ul>
					</div>

					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>acesso/index">
							<button type="button" class="btn btn-md btn-primary">
								<span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['log']['Usuario']; ?>
							</button>
						</a>
					</div>

					<div class="btn-group" role="group" aria-label="..."> </div>
				</li>
				-->
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<!--
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>agenda">
							<button type="button" class="btn btn-md btn-warning ">
								<span class="glyphicon glyphicon-calendar"></span>Agenda
							</button>
						</a>

						<a href="<?php echo base_url(); ?>relatorio/clientes">
							<button type="button" class="btn btn-md btn-success ">
								<span class="glyphicon glyphicon-user"></span>Clientes
							</button>
						</a>

					</div>
					-->
					<div class="btn-group">
						<button type="button" class="btn btn-md btn-primary  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['log']['Usuario']; ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>acesso/index"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['log']['Usuario']; ?></a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>tipobanco/cadastrar"><span class="glyphicon glyphicon-pencil"></span> Cad - Conta Corrente</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/empresaassociado"><span class="glyphicon glyphicon-pencil"></span> Cad - Associados</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url(); ?>login/sair"><span class="glyphicon glyphicon-log-out"></span> Sair</a></li>
							<li role="separator" class="divider"></li>
						</ul>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-md btn-warning dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-calendar"></span> Agendas <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url(); ?>agenda"><span class="glyphicon glyphicon-calendar"></span> Agendas</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/tarefa"><span class="glyphicon glyphicon-pencil"></span> Tarefas</a></li>
						</ul>
					</div>
					<div class="btn-group" role="group" aria-label="..."> </div>
				</li>

				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorio/clientes">
							<button type="button" class="btn btn-md btn-success ">
								<span class="glyphicon glyphicon-user"></span>Clientes
							</button>
						</a>
					</div>
					<div class="btn-group" role="group" aria-label="..."> </div>
				</li>

				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group">
						<button type="button" class="btn btn-md btn-primary dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-pencil"></span> Cadastros <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">							
							<li><a href="<?php echo base_url() ?>orcatrata2/cadastrar"><span class="glyphicon glyphicon-usd"></span> Orçamentos</a></li>
							<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>despesas/cadastrar"><span class="glyphicon glyphicon-usd"></span> Despesas</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>orcatrata3/cadastrar"><span class="glyphicon glyphicon-usd"></span> Devoluções</a></li>
							<li role="separator" class="divider"></li>
							<!--<li><a href="<?php echo base_url() ?>devolucao/cadastrar"><span class="glyphicon glyphicon-pencil"></span> Devol(Desp)</a></li>
							<li role="separator" class="divider"></li>-->
							<li><a href="<?php echo base_url() ?>consumo/cadastrar"><span class="glyphicon glyphicon-pencil"></span> Consumos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/produtos"><span class="glyphicon glyphicon-pencil"></span> Produtos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-pencil"></span> Outros</a></li>
							<li role="separator" class="divider"></li>
						</ul>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-md btn-primary  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-list"></span> Relatórios <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>relatorio/orcamento"><span class="glyphicon glyphicon-list"></span> Orçamentos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/produtosvend"><span class="glyphicon glyphicon-list"></span> Orç. X Cl. X Prd.</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/receitas"><span class="glyphicon glyphicon-list"></span> Orç. X Cl. X Pag.</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/despesas"><span class="glyphicon glyphicon-list"></span> Despesas</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/produtoscomp"><span class="glyphicon glyphicon-list"></span> Despesas X Prd.</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/despesaspag"><span class="glyphicon glyphicon-list"></span> Despesas X Pag.</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/devolucao1"><span class="glyphicon glyphicon-list"></span> Devoluções</a></li>
							<li role="separator" class="divider"></li>
							<!--<li><a href="<?php echo base_url() ?>relatorio/devolucao"><span class="glyphicon glyphicon-list"></span> Devol(Desp)</a></li>
							<li role="separator" class="divider"></li>-->							
							<li><a href="<?php echo base_url() ?>relatorio/produtosdevol1"><span class="glyphicon glyphicon-list"></span> Devol. X Cl. X Prd.</a></li>
							<li role="separator" class="divider"></li>
							<!--<li><a href="<?php echo base_url() ?>relatorio/produtosdevol"><span class="glyphicon glyphicon-list"></span> Devol. X Cl. X Prd.(Desp)</a></li>
							<li role="separator" class="divider"></li>-->
							<li><a href="<?php echo base_url() ?>relatorio/consumo"><span class="glyphicon glyphicon-list"></span> Consumos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/estoque"><span class="glyphicon glyphicon-list"></span> Estoque</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/rankingvendas"><span class="glyphicon glyphicon-list"></span> RankigVendas</a></li>
							<li role="separator" class="divider"></li>
						</ul>
					</div>
					<!--
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url() ?>loginempresafilial/index">
							<button type="button" class="btn btn-md active " id="countdowndiv">
								<span class="glyphicon glyphicon-hourglass" id="clock"></span>
							</button>
						</a>
					</div>
					-->
					<div class="btn-group" role="group" aria-label="..."> </div>
				</li>
				<!--
				<li class="btn-toolbar navbar-form navbar-right" role="toolbar" aria-label="...">

					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url() ?>loginempresafilial/index">
							<button type="button" class="btn btn-md active " id="countdowndiv">
								<span class="glyphicon glyphicon-hourglass" id="clock"></span>
							</button>
						</a>
					</div>

					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorio/sistema">
							<button type="button" class="btn btn-md btn-primary ">
								<span class="glyphicon glyphicon-cog"></span> Indicar
							</button>
						</a>
					</div>

					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>login/sair">
							<button type="button" class="btn btn-md btn-danger ">
								<span class="glyphicon glyphicon-log-out"></span> Sair
							</button>
						</a>
					</div>

					<div class="btn-group" role="group" aria-label="..."> </div>
				</li>
				-->
			</ul>

		</div>
	</div>
</nav>
<br>
