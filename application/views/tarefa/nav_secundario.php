<?php if ( !isset($evento) && isset($_SESSION['Profissional'])) { ?>
<div class="container-fluid">
	<ul class="nav nav-sidebar">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-list"></span> Tarefas<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li <?php if (preg_match("/tarefa\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a href="<?php echo base_url() . 'tarefa/cadastrar/'; ?>">
						<span class="glyphicon glyphicon-plus"></span> Cadastrar
					</a>
				</li>				
				<li role="separator" class="divider"></li>
				<li <?php if (preg_match("/tarefa\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
					<a href="<?php echo base_url() . 'tarefa/listar/'; ?>">
						<span class="glyphicon glyphicon-list-alt"></span> Listar
					</a>
				</li>											
			</ul>
		</li>	
	</ul>
</div>
<?php } ?>