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
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>acesso/index">
							<button type="button" class="btn btn-md btn-primary">
								<span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['log']['Usuario']; ?>
							</button>
						</a>						
					</div>
					<div class="btn-group" role="group" aria-label="..."> </div>
				</li>
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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
					<div class="btn-group" role="group" aria-label="..."> </div>
				</li>				
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<!--
					<div class="btn-group" role="group" aria-label="...">						
						<a href="<?php echo base_url(); ?>orcatrata2/cadastrar">
							<button type="button" class="btn btn-md btn-info ">
								<span class="glyphicon glyphicon-usd"></span>Or�am.
							</button>
						</a>
						<a href="<?php echo base_url(); ?>despesas/cadastrar">
							<button type="button" class="btn btn-md panel-danger ">
								<span class="glyphicon glyphicon-usd"></span>Despesa
							</button>
						</a>

						<a href="<?php echo base_url(); ?>consumo/cadastrar">
							<button type="button" class="btn btn-md panel-danger ">
								<span class="glyphicon glyphicon-pencil"></span>Consumo
							</button>
						</a>
					</div>
					-->
					<div class="btn-group">
						<button type="button" class="btn btn-md btn-primary  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-usd"></span> Entradas<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							
							<li><a href="<?php echo base_url() ?>orcatrata2/cadastrar"><span class="glyphicon glyphicon-usd"></span> Or�am / Vendas - Cad.</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/receitas"><span class="glyphicon glyphicon-list"></span> Or�am / Vendas - Ver</a></li>
							<li role="separator" class="divider"></li>
						</ul>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-md panel-danger  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-usd"></span> Sa�das<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>despesas/cadastrar"><span class="glyphicon glyphicon-usd"></span> Despesas - Cad.</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/despesas"><span class="glyphicon glyphicon-list"></span> Despesas - Ver</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>consumo/cadastrar"><span class="glyphicon glyphicon-pencil"></span> Consumos - Cad.</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/consumo"><span class="glyphicon glyphicon-list"></span> Consumos - Ver</a></li>
							<li role="separator" class="divider"></li>
						</ul>
					</div>
					
					<!--
					<div class="btn-group">
						<button type="button" class="btn btn-primary  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-list-alt"></span> Relat. <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>relatorio/clientes">Clientes & Contatos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/funcionario">Funcion�rios & Contatos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/fornecedor">Fornecedores & Contatos.</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/orcamento">Clientes & Or�amentos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/receitas">Clientes & Pagamentos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/orcamentopc">Clientes & Procedimentos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/tarefa">Tarefas dos Funcion�rios</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/despesas">Despesas</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/produtoscomp">Produtos Comprados</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/produtosvend">Produtos Vendidos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/consumo">Produtos Consumidos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/servicosprest">Servi�os Prestados</a></li>
						</ul>
					</div>
					-->
					<!--
					<div class="btn-group">
						<button type="button" class="btn btn-md btn-primary  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-tags"></span> Assoc. <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>loginassociado/registrar">Cadastrar Associado ou Nova Empresa</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/associado">Relat�rio de Associados</a></li>
						</ul>
					</div>
					-->
					<div class="btn-group" role="group" aria-label="..."> </div>
				</li>

				<li class="btn-toolbar navbar-form navbar-right" role="toolbar" aria-label="...">
					<!--
					<div class="btn-group" role="group" aria-label="...">
						<button type="button" class="btn btn-md active " id="countdowndiv">
							<span class="glyphicon glyphicon-hourglass" id="clock"></span>
						</button>
					</div>
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorio/sistema">
							<button type="button" class="btn btn-md btn-primary ">
								<span class="glyphicon glyphicon-cog"></span> Indicar
							</button>
						</a>
					</div>
					-->
					<div class="btn-group">
						<button type="button" class="btn btn-md btn-primary  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-list"></span> Relat�rios<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							
							<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balan�o</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/estoque"><span class="glyphicon glyphicon-list"></span> Estoque</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-pencil"></span> Anota��es</a></li>
						</ul>
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
			</ul>

		</div>
	</div>
</nav>
<br>
