<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>
<div class="container-fluid">
	<ul class="nav nav-sidebar">
		<li>
			<div class="text-center t">
				<h4><?php echo '<strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong><br><small>Identificador: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?></h4>
			</div>
		</li>
	</ul>

	<div class="nav nav-sidebar">
		<!--<span class="glyphicon glyphicon-user"> </span> Dados do Cliente<span ></span>-->
		<h4 class="col-md-10 text-center glyphicon glyphicon-user"></span> Cliente<span ></h4>	
		<div class="form-group">
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
					<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
						<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
					</a>
				</li>
			</div>
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
					<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
						<span class="glyphicon glyphicon-edit"></span> Edit.
					</a>
				</li>
			</div>
		</div>	
	</div>
	<div class="nav nav-sidebar">
		<!--<span class="glyphicon glyphicon-calendar "> </span> Contatos<span ></span>-->
		<h4 class="col-md-10 text-center glyphicon glyphicon-user"></span> Contatos<span ></h4>
		<div class="form-group">
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/contatocliente\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'contatocliente/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
						<span class="glyphicon glyphicon-th-list"></span> List.
					</a>																		
				</li>
			</div>
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/contatocliente\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'contatocliente/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
						<span class="glyphicon glyphicon-plus-sign"></span> Cad.
					</a>
				</li>
			</div>	
		</div>	
	</div>

	<div class="nav nav-sidebar">
		<!--<span class="glyphicon glyphicon-calendar"> </span> Consultas & Sessões<span ></span>-->
		<h4 class="col-md-10 text-center glyphicon glyphicon-calendar"></span> Consultas<span ></h4>
		<div class="form-group">
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
						<span class="glyphicon glyphicon-list-alt"></span> List.
					</a>
				</li>
			</div>
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/consulta\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
						<span class="glyphicon glyphicon-plus"></span> Cad.
					</a>
				</li>
			</div>	
		</div>	
	</div>

	<div class="nav nav-sidebar">
		<!--<span class="glyphicon glyphicon-usd"> </span> Pedidos & Orçamentos<span ></span>-->
		<h4 class="col-md-10 text-center glyphicon glyphicon-usd"></span> Orçamentos<span ></h4>
		<div class="form-group">
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
						<span class="glyphicon glyphicon-list-alt"></span> List.
					</a>
				</li>
			</div>
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
						<span class="glyphicon glyphicon-plus"></span> Cad.
					</a>
				</li>
			</div>		
		</div>	
	</div>
</div>	
	<?php } ?>
