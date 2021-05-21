<div class="container text-center" id="login">

    <!--<?php #echo validation_errors(); ?>-->

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('login', 'role="form"'); ?>
<!--
    <p class="text-center">
        <a href="<?php echo base_url(); ?>login">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>
-->
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" type="text/css" href="css/popup.css">
	<link rel="stylesheet" href="css/icomoon.css">
	<link rel="stylesheet" href="css/simple-line-icons.css">
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="engine1/style.css" />   
	<link rel="stylesheet" href="css/style.css">
	<script src="js/modernizr-2.6.2.min.js"></script>
	<script type="text/javascript" src="engine1/jquery.js"></script>
	
	<div id="wowslider-container1">
		<div class="ws_imagens"><ul>
			<li><img src="arquivos/imagens/1.jpg" alt="" title="" id="wows1_0"/>Nós somos a <strong>Engrenagem</strong> que faltava
			na sua <strong>Empresa</strong>.</li>
			<li><img src="arquivos/imagens/2.jpg" alt="" title="" id="wows1_1"/></a>Nós te ajudamos a cuidar dos seus <strong>Clientes</strong>, 
			antes que a concorrência <strong>Cuide</strong>!</li>
			<li><img src="arquivos/imagens/3.jpg" alt="" title="" id="wows1_2"/>Nós te ajudamos a Organizar seu <strong>Negócio</strong> 
			e melhorar seus <strong>Resultados</strong>.</li>
			</ul>
		</div>
		<!--
		<div class="ws_bullets">
			<div>
				<a href="#" title=""><span><img src="data1/tooltips/1.png" alt=""/>1</span></a>
				<a href="#" title=""><span><img src="data1/tooltips/2.jpg" alt=""/>2</span></a>
				<a href="#" title=""><span><img src="data1/tooltips/3.jpg" alt=""/>3</span></a>
			</div>
		</div>
		-->
		<div class="ws_script" style="position:absolute;left:-99%"></div>
		<div class="ws_shadow"></div>
	</div>	
	<script type="text/javascript" src="engine1/wowslider.js"></script>
	<script type="text/javascript" src="engine1/script.js"></script>


    <h2 class="form-signin-heading text-center">Eu Encontrei Aqui</h2>	
	<a class="btn btn-lg btn-warning btn-block" href="<?php echo base_url(); ?>login/index2" role="button">Conta Empresa</a>
	<a class="btn btn-lg btn-danger btn-block" href="<?php echo base_url(); ?>login/index1" role="button">Conta Pessoal</a>	
	<a class="btn btn-lg btn-success btn-block" href="<?php echo base_url(); ?>pesquisar/empresas" role="button">
		<span class="glyphicon glyphicon-search"></span> Produtos & Serviços
	</a>
</form>

</div>