<nav class="navbar navbar-inverse navbar-fixed-top">

    <div class="row">
        <div class="col-md-9">

            <ul class="nav navbar-nav">
                <li>
                    <?php echo form_open(base_url() . 'cliente/pesquisar', 'class="navbar-form navbar-left"'); ?>
                    <div class="input-group">
                        <input type="text" placeholder="Pesquisar" class="form-control" name="Pesquisa" value="">
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                    </form>
                </li>
				<li class="active"><a class="navbar-brand" href="<?php echo base_url(); ?>agenda">AGENDA</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Clientes<span class="caret"></span></a>
                    <ul class="dropdown-menu">
						<li><a href="<?php echo base_url() ?>cliente/pesquisar">Pesquisar/Cadastrar Clientes</a></li>
						<li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url() ?>cliente/pesquisar">Pesquisar/Cadastrar Contato</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Serviços<span class="caret"></span></a>
                    <ul class="dropdown-menu">
						<li><a href="<?php echo base_url() ?>cliente/pesquisar">Sessão ou Consulta</a></li>
						<li><a href="<?php echo base_url() ?>cliente/pesquisar">Orçamento e Plano de Tratamento</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>servico/cadastrar">Tabela de Preço de Serviços</a></li>
						<li><a href="<?php echo base_url() ?>produto/cadastrar">Tabela de Preço de Produtos</a></li>
                    </ul>
                </li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Despesas<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url() ?>despesa/cadastrar/despesa">Despesas</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>tipodespesa/cadastrar/tipodespesa">Tipo de Despesa</a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relatórios<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url() ?>">Financeiro</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>">Estoque</a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Outros<span class="caret"></span></a>
					<ul class="dropdown-menu">
					    <li><a href="<?php echo base_url() ?>profissional/pesquisar">Pesquisar/Cadastrar Funcionários/Profissionais</a></li>
					    <li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>empresa/pesquisar">Pesquisar/Cadastrar Empresas/Prestadores de Serviço</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url() ?>funcao/cadastrar/funcao">Função dos Funcionários/Profissionais</a></li>
						<li><a href="<?php echo base_url() ?>atividade/cadastrar/atividade">Atividade das Empresas/Prestadores de Serviço</a></li>
					</ul>
				</li>

                <!--<li class="active"><a class="navbar-brand" href="<?php echo base_url(); ?>teste">TESTE</a></li>-->
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
