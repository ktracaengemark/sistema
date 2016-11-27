<div class="container text-center" id="login">

    <p class="text-center">
        <!--<a href="<?php echo base_url() . '/' . $_SESSION['log']['modulo']; ?>">-->
        <a href="<?php echo base_url() ?>">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $_SESSION['log']['modulo'] . '.png' ; ?>" width="25%" />
        </a> 
    </p>
    <h2 class="form-signin-heading text-center">Agenda <?php echo ucfirst($_SESSION['log']['nome_modulo']) ?></h2>

    <?php if ($aviso) echo $aviso; ?>

    <a class="btn btn-lg btn-primary" href="<?php echo base_url() ?>">
    <!--<a class="btn btn-lg btn-primary" href="<?php echo base_url() . $_SESSION['log']['modulo']; ?>">-->
        <span class="glyphicon glyphicon-home"></span> Login
    </a>  

</div>
