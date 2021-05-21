<div class="container" id="login">

    <?php #echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('loginempresamatriz/recuperar', 'role="form"'); ?>

    <!--
    <p class="text-center">
        <a href="<?php echo base_url() . '/' . $_SESSION['log']['modulo']; ?>">
        <a href="<?php echo base_url() ?>">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $_SESSION['log']['modulo'] . '.png' ; ?>" width="25%" />
        </a>
    </p>
    -->
	<p class="text-center">
        <a href="<?php echo base_url(); ?>login">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>
    <h2 class="form-signin-heading text-center">Recuperar Senha</h2>
    <br>

    <label>Usuário ou E-mail:</label>
    <input type="text" class="form-control" id="Usuario" maxlength="100" autofocus="" placeholder="Usuário ou E-mail de cadastro"
           name="Usuario" value="<?php echo $query['UsuarioEmpresaMatriz']; ?>">
    <?php echo form_error('UsuarioEmpresaMatriz'); ?>

    <button class="btn btn-lg btn-warning btn-block" type="submit">Enviar Link</button>
	<br>
	<a class="btn btn-lg btn-warning btn-block" href="<?php echo base_url(); ?>loginempresamatriz/index" role="button">Acesso do Administrador</a>
</form>

</div>
