<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>
<div class="container-fluid">
	<ul class="nav nav-sidebar">
		<li>
			<div class="text-center t">
				<h4><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong><br><small>Identificador: ' . $_SESSION['Empresa']['idApp_Empresa'] . '</small>' ?></h4>
			</div>
		</li>
	</ul>
	
	<div class="nav nav-sidebar">
		<!--<span class="glyphicon glyphicon-user"> </span> Dados do Cliente<span ></span>-->
		<h4 class="col-md-10 text-center glyphicon glyphicon-user"></span> Fornecedor<span ></h4>	
		<div class="form-group">
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
					<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idApp_Empresa']; ?>">
						<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
					</a>
				</li>				
			</div>
			<div class="form-group col-md-5">				
				<li <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
					<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idApp_Empresa']; ?>">
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
				<li <?php if (preg_match("/contato\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'contato/pesquisar/' . $_SESSION['Empresa']['idApp_Empresa']; ?>">
						<span class="glyphicon glyphicon-th-list"></span> List.
					</a>
				</li>				
			</div>
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/contato\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'contato/cadastrar/' . $_SESSION['Empresa']['idApp_Empresa']; ?>">
						<span class="glyphicon glyphicon-plus"></span> Cad.
					</a>
				</li>
			</div>	
		</div>	
	</div>
<!--
	<ul class="nav nav-sidebar">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-user"> </span> Dados do Fornecedor<span class="caret"></span>			
			</a>	
			<ul class="dropdown-menu">	
				<li <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
					<a href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idApp_Empresa']; ?>">
						<span class="glyphicon glyphicon-user"> </span> Visualizar<span class="sr-only">(current)</span>
					</a>
				</li>
				<li role="separator" class="divider"></li>
				<li <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
					<a href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idApp_Empresa']; ?>">
						<span class="glyphicon glyphicon-edit"></span> Editar
					</a>
				</li>
			</ul>
		</li>

		<li <?php if (preg_match("/contato\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
			<a href="<?php echo base_url() . 'contato/pesquisar/' . $_SESSION['Empresa']['idApp_Empresa']; ?>">
				<span class="fa fa-user-plus"></span> Contatos
			</a>
		</li>		
	</ul>
-->
</div>
	<?php } ?>