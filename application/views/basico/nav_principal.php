<nav class="navbar navbar-inverse navbar-fixed-top">

    <div class="row">
        <div class="col-md-9">

            <ul class="nav navbar-nav navbar-left"> 			
				<li>												
					<?php echo form_open(base_url() . 'cliente/pesquisar', 'class="navbar-form navbar-left"'); ?>
					<form>
					<div class="input-group">
						<input type="text" placeholder="Pesquisar Cliente" class="form-control" name="Pesquisa" value="">
						<span class="input-group-btn">
							<button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						</span>
					</div>						
					</form>
					<li><a class="navbar-brand" href="<?php echo base_url(); ?>agenda">AGENDA</a></li>
				</li>				
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cadastros<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url() ?>cliente/pesquisar">Clientes & Contatos</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>profissional/pesquisar">Funcionários & Contatos</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>empresa/pesquisar">Fornecedores & Contatos</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>cliente/pesquisar">Orçamentos & Entradas</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>cliente/pesquisar">Consultas & Reuniões</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>tarefa/cadastrar">Tarefas dos Funcionários</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>despesas/cadastrar">Despesas & Saídas</a></li>
						<li role="separator" class="divider"></li>
						<!--<li><a href="<?php echo base_url() ?>consumo/cadastrar">Consumo de Produtos</a></li>
						<li role="separator" class="divider"></li>-->
						<li><a href="<?php echo base_url() ?>funcao/cadastrar/funcao">Função dos Funcionários</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>atividade/cadastrar/atividade">Atividade dos Fornecedores</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>convenio/cadastrar">Convênio</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>servico/cadastrar">Tabela de Preço de Serviços</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>produto/cadastrar">Tabela de Preço de Produtos</a></li>
						<li role="separator" class="divider"></li>
						<!--<li><a href="<?php echo base_url() ?>formapag/cadastrar/formapag">Forma de Pagamento</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>tipodespesa/cadastrar/tipodespesa">Tipo de Despesa</a></li>
						<li role="separator" class="divider"></li>						
						<li><a href="<?php echo base_url() ?>relapes/cadastrar">Relação Pessoal</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relacom/cadastrar">Relação Comercial</a></li>
						<li role="separator" class="divider"></li>-->						
					</ul>
				</li>
				
				<!--<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Anotações<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url() ?>cliente/pesquisar">Orçamentos & Entradas</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>despesa/cadastrar/despesa">Despesas & Saídas - Antigas</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>despesas/cadastrar">Despesas & Saídas</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>cliente/pesquisar">Consultas & Reuniões</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/tarefa">Tarefas & A Fazer</a></li>
						<li role="separator" class="divider"></li>
					</ul>
				</li>
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Financeiro<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url() ?>relatorio/financeiro">Orçamentos & Pagamentos</a></li>
						<li role="separator" class="divider"></li>				
						<li><a href="<?php echo base_url() ?>relatorio/despesa">Despesas & Saídas - Antigas</a></li>						
						<li role="separator" class="divider"></li>	
						<li><a href="<?php echo base_url() ?>relatorio/receitas">Receitas & Entradas</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/despesas">Despesas & Saídas</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/balanco">Balanço</a></li>
						<li role="separator" class="divider"></li>

					</ul>
				</li>-->
	
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relatórios<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url() ?>relatorio/clientes">Clientes & Contatos</a></li>											
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/profissionais">Funcionários & Contatos.</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/empresas">Fornecedores & Contatos.</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/orcamentopc">Clientes & Procedimentos</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/orcamento">Clientes & Orçamentos</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/receitas">Clientes & Pagamentos</a></li>
						<li role="separator" class="divider"></li>						
						<li><a href="<?php echo base_url() ?>relatorio/tarefa">Tarefas dos Funcionários</a></li>
						<li role="separator" class="divider"></li>						
						<li><a href="<?php echo base_url() ?>relatorio/despesas">Despesas & Saídas</a></li>
						<li role="separator" class="divider"></li>
						<!--<li><a href="<?php echo base_url() ?>relatorio/consumo">Consumo de Produtos</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/orcamentosv">Clientes & Serviços</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/clienteprod">Clientes & Produtos</a></li>
						<li role="separator" class="divider"></li>					
						<li><a href="<?php echo base_url() ?>relatorio/financeiro">Orçamentos & Pagamentos</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/despesa">Despesas & Saídas - Antigas</a></li>
						<li role="separator" class="divider"></li>-->						
						<!--<li><a href="<?php echo base_url() ?>relatorio/balanco">Balanço</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>relatorio/estoque">Estoque</a></li>
						<li role="separator" class="divider"></li>-->
					</ul>
				</li>																													
			</ul>	
        </div>
        <div class="col-md-3">
            <div class="btn-toolbar navbar-form navbar-right" role="toolbar" aria-label="...">
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn active" id="countdowndiv">
                        <span class="glyphicon glyphicon-hourglass" id="clock"></span>
                    </button>
                </div>
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-info active">
                        <span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['log']['Usuario']; ?>
                    </button>
                </div>
                <div class="btn-group" role="group" aria-label="...">
                    <a href="<?php echo base_url(); ?>login/sair">
                        <button type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-log-out"></span> Sair
                        </button>
                    </a>
                </div>
                <div class="btn-group" role="group" aria-label="..."> </div>
            </div>
        </div>


    </div>

</nav>

<br>
