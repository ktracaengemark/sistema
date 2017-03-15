<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<ul class="nav nav-sidebar">
    <li>
        <div class="text-center t">
            <h4><?php echo '<strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong><br><small>Identificador: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?></h4>
        </div>
    </li>
</ul>

<ul class="nav nav-sidebar">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<span class="glyphicon glyphicon-user"> </span> Dados do Cliente<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
				<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
					<span class="glyphicon glyphicon-user"> </span> Visualizar <span class="sr-only">(current)</span>
				</a>
			</li>				
			<li role="separator" class="divider"></li>
			<li <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
				<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
					<span class="glyphicon glyphicon-edit"></span> Editar
				</a>
			</li>											
		</ul>
	</li>
	
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<span class="fa fa-user-plus"></span> Contatos<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li <?php if (preg_match("/contatocliente\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
				<a href="<?php echo base_url() . 'contatocliente/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
					<span class="fa fa-user-plus"></span> Visualizar
				</a>
			</li>																			
		</ul>
	</li>
	
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<span class="glyphicon glyphicon-calendar"></span> Agenda<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li <?php if (preg_match("/consulta\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
				<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
					<span class="glyphicon glyphicon-time"></span> Cadastrar Sessões
				</a>
			</li>				
			<li role="separator" class="divider"></li>
			<li <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
				<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
					<span class="glyphicon glyphicon-list"></span> Listar Sessões
				</a>
			</li>											
		</ul>
	</li>
	
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<span class="glyphicon glyphicon-usd"></span> Orçamentos<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
				<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
					<span class="glyphicon glyphicon-plus"></span> Cadastrar
				</a>
			</li>				
			<li role="separator" class="divider"></li>
			<li <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
				<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
					<span class="glyphicon glyphicon-list-alt"></span> Listar
				</a>
			</li>											
		</ul>
	</li>		
</ul>

<?php } ?>
