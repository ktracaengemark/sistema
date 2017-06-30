<div class="container" id="login">

    <?php #echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('login/registrar', 'role="form"'); ?>

    <!--
    <p class="text-center">
        <a href="<?php echo base_url() . '/' . $_SESSION['log']['modulo']; ?>">
        <a href="<?php echo base_url() ?>">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $_SESSION['log']['modulo'] . '.png' ; ?>" width="25%" />
        </a>
    </p>
    -->
    <h2 class="form-signin-heading text-center">Criar nova conta</h2>

    <label for="Nome">Nome e Sobrenome:</label>
    <input type="text" class="form-control" id="Nome" maxlength="255"
           name="Nome" autofocus value="<?php echo $query['Nome']; ?>">
    <?php echo form_error('Nome'); ?>
    <br>

    <label class="text-">E-mail:</label>
    <input type="text" class="form-control" id="Email" maxlength="100"
           name="Email" value="<?php echo $query['Email']; ?>">
    <?php echo form_error('Email'); ?>
    <br>

    <label for="Usuario">Usuário:</label>
    <input type="text" class="form-control" id="Usuario" maxlength="45"
           name="Usuario" value="<?php echo $query['Usuario']; ?>">
    <?php echo form_error('Usuario'); ?>
    <br>

    <label for="Senha">Senha:</label>
    <input type="password" class="form-control" id="Senha" maxlength="45"
           name="Senha" value="<?php echo $query['Senha']; ?>">
    <?php echo form_error('Senha'); ?>
    <br>

    <label for="Senha">Confirmar Senha:</label>
    <input type="password" class="form-control" id="Confirma" maxlength="45"
           name="Confirma" value="<?php echo $query['Confirma']; ?>">
    <?php echo form_error('Confirma'); ?>
    <br>

    <label for="Celular">Celular:</label>
    <input type="text" class="form-control Celular CelularVariavel" id="Celular" maxlength="45"
           name="Celular" placeholder="99999999999" value="<?php echo $query['Celular']; ?>">
    <?php echo form_error('Celular'); ?>
    <br>

    <label for="DataNascimento">Data de Nascimento:</label>
    <input type="text" class="form-control Date" id="inputDate0" maxlength="10"
           name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
    <?php echo form_error('DataNascimento'); ?>
    <br>

    <label for="Sexo">Sexo:</label>
    <select data-placeholder="Selecione um TROCA..." class="form-control" id="Sexo" name="Sexo">
        <option value=""></option>
        <?php
        foreach ($select['Sexo'] as $key => $row) {
            if ($query['Sexo'] == $key) {
                echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
            } else {
                echo '<option value="' . $key . '">' . $row . '</option>';
            }
        }
        ?>
    </select>
    <?php echo form_error('Sexo'); ?>
    <br>

    <button class="btn btn-lg btn-primary btn-block" type="submit">REGISTRAR</button>
</form>

</div>
