<?php if ( !isset($evento) && $_SESSION['log']['idSis_Empresa'] != 5 && isset($_SESSION['Cliente'])) { ?>
	<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 150001 && $_SESSION['Cliente']['idApp_Cliente'] != 1 && $_SESSION['Cliente']['idApp_Cliente'] != 0) { ?>
		<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
		  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<li class="navbar-form">
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span> Cliente <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
									<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
									</a>
								</a>
							</li>
						</ul>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
									<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
									</a>
								</a>
							</li>
							<?php if ($_SESSION['Usuario']['Cad_Agend'] == "S" ) { ?>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
										<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
											<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
										</a>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>

					<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-usd"></span> Orçs. <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
									<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-usd"></span> Lista de Orçamentos
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
									</a>
								</a>
							</li>
						</ul>
					</div>
					<?php } ?>									
				</li>				
				<!--
				<a class="navbar-brand" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
					<?php echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
				</a>
				-->
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-center">
					<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
						<div class="btn-group " role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>agenda">
								<button type="button" class="btn btn-lg btn-info ">
									<span class="glyphicon glyphicon-calendar"></span> Agenda
								</button>
							</a>
						</div>
					</li>
					<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
						
						<div class="btn-group " role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>relatorio/clientes">
								<button type="button" class="btn btn-sm btn-warning ">
									<span class="glyphicon glyphicon-user"></span> Clientes
								</button>
							</a>
						</div>
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-user"></span> Fornecedores <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">							
								<li><a href="<?php echo base_url() ?>relatorio/fornecedor"><span class="glyphicon glyphicon-user"></span> Lista de Fornecedores</a></li>
								<li role="separator" class="divider"></li>							
								<li><a href="<?php echo base_url() ?>atividade/cadastrar"><span class="glyphicon glyphicon-list-alt"></span> Atividade dos Fornecedores</a></li>									
							</ul>
						</div>																				
						
					</li>
					<?php } ?>
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
						<?php if ($_SESSION['Usuario']['Cad_Orcam'] == "S" ) { ?>
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>orcatrata/cadastrar3">
									<button type="button" class="btn btn-lg btn-primary ">
										<span class="glyphicon glyphicon-plus"></span>Receitas
									</button>
								</a>
							</div>
						<?php } ?>
						<div class="btn-group " role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>orcatrata/cadastrardesp">
								<button type="button" class="btn btn-lg btn-danger ">
									<span class="glyphicon glyphicon-plus"></span>Despesas
								</button>
							</a>
						</div>														
					</li>
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-usd"></span> Financeiro <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">							
								<li><a href="<?php echo base_url() ?>relatorio/financeiro"><span class="glyphicon glyphicon-usd"></span> Orçamentos</a></li>
								<li role="separator" class="divider"></li>							
								<li><a href="<?php echo base_url() ?>relatorio/parcelas"><span class="glyphicon glyphicon-usd"></span> Receber X Pagar</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>relatorio/fiado"><span class="glyphicon glyphicon-usd"></span> Fiado</a></li>									
								<li role="separator" class="divider"></li>																	
								<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>relatorio/rankingvendas"><span class="glyphicon glyphicon-pencil"></span> Ranking de Vendas</a></li>
								<?php } ?>
							</ul>
						</div>							
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-gift"></span> Produtos <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">							
								<li><a href="<?php echo base_url() ?>relatorio/produtos"><span class="glyphicon glyphicon-usd"></span> Produtos & Valores</a></li>
								<li role="separator" class="divider"></li>							
								<li><a href="<?php echo base_url() ?>relatorio/estoque"><span class="glyphicon glyphicon-list-alt"></span> Produtos & Estoque</a></li>							
								<li role="separator" class="divider"></li>							
								<li><a href="<?php echo base_url() ?>relatorio/compvend"><span class="glyphicon glyphicon-pencil"></span> Produtos Comprados & Vendidos</a></li>
								<li role="separator" class="divider"></li>									
								<li><a href="<?php echo base_url() ?>Prodaux3/cadastrar"><span class="glyphicon glyphicon-list"></span> Lista de Categoria</a></li>										
								<li role="separator" class="divider"></li>																			
								<li><a data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal3-sm"><span class="glyphicon glyphicon-plus"></span> Novo Produto</a></li>
							</ul>
						</div>																				
						<?php } ?>
					</li>
					<!--
					<li class="botoesnav" role="toolbar" aria-label="...">
						<div class="btn-group">
							<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-user"></span> Cliente <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li>
									<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
										<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
											<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
										<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
										<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
											<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
										</a>
									</a>
								</li>
							</ul>
						</div>
						<div class="btn-group">
							<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li>
									<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
										<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
											<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
										<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
											<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
										</a>
									</a>
								</li>
							</ul>
						</div>

						<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
						<div class="btn-group">
							<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-usd"></span> Orçs. <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li>
									<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
										<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
											<span class="glyphicon glyphicon-usd"></span> Lista de Orçamentos
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
										<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
											<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
										</a>
									</a>
								</li>
							</ul>
						</div>
						<?php } ?>									
					</li>
					-->
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">								
						<div class="btn-group">
							<button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-home"></span> enkontraki
								<span class="caret"></span>
								<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
									<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?>
								<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
									Renovar !!!
								<?php } ?>
							</button>
							<ul class="dropdown-menu" role="menu">							
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
								<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-pencil"></span> Renovar Assinatura</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-pencil"></span> Dicas de Negócios</a></li>
								<li role="separator" class="divider"></li>									
								<?php } ?>
								<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-home"></span> Outras Empresas</a></li>
							</ul>
						</div>
					</li>	
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">		
						<div class="btn-group " role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>login/sair">
								<button type="button" class="btn btn-sm btn-active ">
									<span class="glyphicon glyphicon-log-out"></span> Sair
								</button>
							</a>
						</div>							
					</li>
				</ul>
			</div>
		  </div>
		</nav>
	<?php } ?>
<?php } ?>

<?php if ($msg) echo $msg; ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
			
			<div class="row">
			
				<div class="col-md-12 col-lg-12">

					<div class="panel panel-primary">

						<div class="panel-heading"><strong>Procedimentos</strong></div>
						<div class="panel-body">				
						
							<?php
							if (!$list) {
							?>
								<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>procedimento/cadastrar_Sac" role="button">
									<span class="glyphicon glyphicon-plus"></span> Cadastrar Novo Procedimento
								</a>
								<br><br>
								<div class="alert alert-info" role="alert"><b>Nenhum Procedimento cadastrado</b></div>
							<?php
							} else {
								echo $list;
							}
							?>

						</div>
					</div>		
				</div>
			</div>									

		</div>
		<div class="col-md-2"></div>
	</div>	
</div>