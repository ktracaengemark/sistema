<div class="container" id="login">

    <?php #echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('login/trocar_senha', 'role="form"'); ?>

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
    <h2 class="form-signin-heading text-center">Trocar senha</h2>

    <label class="text-">E-mail:</label>
    <input type="text" class="form-control" id="Email" maxlength="100" readonly
           name="Email" value="<?php echo $query['Email']; ?>">
    <?php echo form_error('Email'); ?>
    <br>

    <label for="Usuario">Usuário:</label>
    <input type="text" class="form-control" id="Usuario" maxlength="45" readonly
           name="Usuario" value="<?php echo $query['Usuario']; ?>">
    <?php echo form_error('Usuario'); ?>
    <br>

    <label for="Senha">Senha:</label>
    <input type="password" class="form-control" id="Senha" maxlength="45" autofocus
           name="Senha" value="<?php echo $query['Senha']; ?>">
    <?php echo form_error('Senha'); ?>
    <br>

    <label for="Senha">Confirmar Senha:</label>
    <input type="password" class="form-control" id="Confirma" maxlength="45"
           name="Confirma" value="<?php echo $query['Confirma']; ?>">
    <?php echo form_error('Confirma'); ?>
    <br>

    <input type="hidden" id="idSis_Usuario" name="idSis_Usuario" value="<?php echo $query['idSis_Usuario']; ?>">
    <button class="btn btn-lg btn-primary btn-block" type="submit">TROCAR SENHA</button>
</form>

</div>
