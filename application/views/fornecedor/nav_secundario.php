<?php if ( !isset($evento) && isset($_SESSION['Fornecedor'])) { ?>
<div class="container-fluid">
	<ul class="nav nav-sidebar">
		<li>
			<div class="text-center t">
				<h4><?php echo '<strong>' . $_SESSION['Fornecedor']['NomeFornecedor'] . '</strong><br><small>Identificador: ' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . '</small>' ?></h4>
			</div>
		</li>
	</ul>
	
	<div class="nav nav-sidebar">
		<h4 class="col-md-10 text-center glyphicon glyphicon-user"></span> Fornecedor<span ></h4>	
		<div class="form-group">
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
					<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'fornecedor/prontuario/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
						<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
					</a>
				</li>				
			</div>
			<div class="form-group col-md-5">				
				<li <?php if (preg_match("/fornecedor\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
					<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'fornecedor/alterar/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
						<span class="glyphicon glyphicon-edit"></span> Edit.
					</a>
				</li>												
			</div>
		</div>	
	</div>

	<div class="nav nav-sidebar">
		<h4 class="col-md-10 text-center glyphicon glyphicon-user"></span> Contatofornecs<span ></h4>
		<div class="form-group">
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/contatofornec\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'contatofornec/pesquisar/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
						<span class="glyphicon glyphicon-th-list"></span> List.
					</a>
				</li>				
			</div>
			<div class="form-group col-md-5">
				<li <?php if (preg_match("/contatofornec\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'contatofornec/cadastrar/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
						<span class="glyphicon glyphicon-plus"></span> Cad.
					</a>
				</li>
			</div>	
		</div>	
	</div>
</div>
	<?php } ?>