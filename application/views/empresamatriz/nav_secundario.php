<?php if ( !isset($evento) && isset($_SESSION['Funcionario'])) { ?>
<div class="container-fluid">
	<ul class="nav nav-sidebar">
		<li>
			<div class="text-center t">
				<h4><?php echo '<strong>' . $_SESSION['Funcionario']['Nome'] . '</strong><br><small>Identificador: ' . $_SESSION['Funcionario']['idSis_Usuario'] . '</small>' ?></h4>
			</div>
		</li>
	</ul>

	<div class="nav nav-sidebar">
		<!--<span class="glyphicon glyphicon-user"> </span> Dados do Funcionario<span ></span>-->
		<h4 class="col-md-10 text-center glyphicon glyphicon-user"></span> Funcionario<span ></h4>	
		<div class="form-group">
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
					<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'funcionario/prontuario/' . $_SESSION['Funcionario']['idSis_Usuario']; ?>">
						<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
					</a>
				</li>
			</div>	
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/funcionario\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
					<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'funcionario/alterar/' . $_SESSION['Funcionario']['idSis_Usuario']; ?>">
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
				<li <?php if (preg_match("/contatofunc\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'contatofunc/pesquisar/' . $_SESSION['Funcionario']['idSis_Usuario']; ?>">
						<span class="glyphicon glyphicon-th-list"></span> List.
					</a>																		
				</li>
			</div>
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/contatofunc\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'contatofunc/cadastrar/' . $_SESSION['Funcionario']['idSis_Usuario']; ?>">
						<span class="glyphicon glyphicon-plus-sign"></span> Cad.
					</a>
				</li>
			</div>	
		</div>	
	</div>
</div>	
	<?php } ?>
