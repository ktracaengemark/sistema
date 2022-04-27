<div class="container" id="login">

    <?php #echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('login/recuperar', 'role="form"'); ?>

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

    <label>Celular/Login Cadastrado:</label>
    <input type="text" class="form-control" id="Associado" maxlength="11" autofocus="" placeholder="(XX)999999999"
           name="Associado" value="<?php echo $query['Associado']; ?>">
    <?php echo form_error('Associado'); ?>
    <br>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Enviar Link</button>
</form>

</div>
