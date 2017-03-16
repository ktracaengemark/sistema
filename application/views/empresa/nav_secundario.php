<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>

<ul class="nav nav-sidebar">
    <li>
        <div class="text-center t">
            <h4><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong><br><small>Identificador: ' . $_SESSION['Empresa']['idApp_Empresa'] . '</small>' ?></h4>
        </div>
    </li>
</ul>

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

<?php } ?>