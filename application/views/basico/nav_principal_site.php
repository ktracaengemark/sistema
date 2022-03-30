<?php if (isset($msg)) echo $msg; ?>
<section id="login" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<nav class="navbar navbar-inverse navbar-fixed-top navbar-menu">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle navbar-toggle-site collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>					
			<a class="navbar-brand navbar-logo" href="<?php echo base_url() ?>../enkontraki/index.php"><img src="<?php echo base_url() ?>/arquivos/imagens/Logo_Navegador.png"></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right navbar-fonte">
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url() . '../enkontraki/index.php';?>">Home</a>
				</li>
				<!--
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#about">A Plataforma</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#cta-1">Planos</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#testimonial">Depoimentos</a>
				</li>
				-->
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/dicas.php">Dicas</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/contact.php">Fale Conosco</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link " href="../../enkontraki/pesquisar.php" >Empresas</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Login <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" aria-labelledby="dropdown01">
						<li>
							<a class="dropdown-item" href="<?php echo base_url() ?>login/index2">Acessar Plataforma</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>	
	</nav>
</section>