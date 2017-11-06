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

				<li class="btn-toolbar navbar-form navbar-left" role="toolbar" aria-label="...">
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>acesso/index">
							<button type="button" class="btn btn-md btn-primary">
								<span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['log']['Usuario']; ?>
							</button>
						</a>
					</div>
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>agenda">
							<button type="button" class="btn btn-md btn-warning ">
								<span class="glyphicon glyphicon-calendar"></span>Agenda
							</button>
						</a>
					</div>
					<div class="btn-group" role="group" aria-label="..."> </div>
				</li>
				<li class="btn-toolbar navbar-form navbar-left" role="toolbar" aria-label="...">
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorio/clientes">
							<button type="button" class="btn btn-md btn-success ">
								<span class="glyphicon glyphicon-user"></span>Clientes
							</button>
						</a>
					</div>
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorio/orcamento">
							<button type="button" class="btn btn-md btn-info ">
								<span class="glyphicon glyphicon-usd"></span>Vendas
							</button>
						</a>
					</div>					
					<!--
					<div class="btn-group">
						<button type="button" class="btn btn-md btn-primary  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-pencil"></span> Admin.	<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>relatorio/funcionario">Funcionários & Contatos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/fornecedor">Fornecedores & Contatos.</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>despesas/cadastrar">Despesas</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>consumo/cadastrar">Produtos Consumidos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>tarefa/cadastrar">Tarefas dos Funcionários</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>convenio/cadastrar">Planos & Convênios</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>produto/cadastrar">Produtos  P/Venda & P/Consumo</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>servico/cadastrar">Serviços P/Venda</a></li>
						</ul>
					</div>
					-->
					<!--
					<div class="btn-group">
						<button type="button" class="btn btn-primary  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-list-alt"></span> Relat. <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url() ?>relatorio/clientes">Clientes & Contatos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/funcionario">Funcionários & Contatos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/fornecedor">Fornecedores & Contatos.</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/orcamento">Clientes & Orçamentos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/receitas">Clientes & Pagamentos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/orcamentopc">Clientes & Procedimentos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/tarefa">Tarefas dos Funcionários</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/despesas">Despesas</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/produtoscomp">Produtos Comprados</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/produtosvend">Produtos Vendidos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/consumo">Produtos Consumidos</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/servicosprest">Serviços Prestados</a></li>
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
							<li><a href="<?php echo base_url() ?>relatorio/associado">Relatório de Associados</a></li>
						</ul>
					</div>
					-->
					<div class="btn-group" role="group" aria-label="..."> </div>
				</li>
				<li class="btn-toolbar navbar-form navbar-left" role="toolbar" aria-label="...">
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>despesas/cadastrar">
							<button type="button" class="btn btn-md btn-primary ">
								<span class="glyphicon glyphicon-usd"></span>Despesa
							</button>
						</a>
					</div>
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>consumo/cadastrar">
							<button type="button" class="btn btn-md btn-primary ">
								<span class="glyphicon glyphicon-pencil"></span>Consumo
							</button>
						</a>
					</div>				
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
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorio/admin">
							<button type="button" class="btn btn-md btn-primary ">
								<span class="glyphicon glyphicon-pencil"></span>Admin
							</button>
						</a>
					</div>
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>login/sair">
							<button type="button" class="btn btn-md btn-danger ">
								<span class="glyphicon glyphicon-log-out"></span>Sair
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
