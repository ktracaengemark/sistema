<div class="container" id="login">

    <?php #echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('loginempresafilial/registrar', 'role="form"'); ?>

    <!--
    <p class="text-center">
        <a href="<?php echo base_url() . '/' . $_SESSION['log']['modulo']; ?>">
        <a href="<?php echo base_url() ?>">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $_SESSION['log']['modulo'] . '.png' ; ?>" width="25%" />
        </a>
    </p>
    -->
	<p class="text-center">
        <a href="<?php echo base_url(); ?>loginempresafilial">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>

	<h2 class="panel-heading text-center" ><?php echo '<strong>' . $_SESSION['log']['NomeEmpresa'] . '</strong>' ?></h2>
	
	<h3 class="form-signin-heading text-center">Cadastrar Nova Unidade</h3>
<!--
	<label for="NomeEmpresa">Nome da Empresa:</label>
	<input type="text" class="form-control" id="NomeEmpresa" maxlength="45" 
		   name="NomeEmpresa" value="<?php echo $query['NomeEmpresa']; ?>">
	<?php echo form_error('NomeEmpresa'); ?>
	<br>
	
	<label for="NumUsuarios">Nº de Usuários da Empresa:</label>
	<input type="text" class="form-control" id="NumUsuarios" maxlength="45" 
		   name="NumUsuarios" value="<?php echo $query['NumUsuarios']; ?>">
	<?php echo form_error('NumUsuarios'); ?>
	<br>	

	<label for="NumUsuarios">Nº de Usuários da Empresa:*</label>
	<select data-placeholder="Selecione uma opção..." class="form-control" id="NumUsuarios" name="NumUsuarios">			
		<option value="">-- Selecione uma NumUsuarios --</option>
		<?php
		foreach ($select['NumUsuarios'] as $key => $row) {
			if ($query['NumUsuarios'] == $key) {
				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
			} else {
				echo '<option value="' . $key . '">' . $row . '</option>';
			}
		}
		?>   
	</select> 
    <?php echo form_error('NumUsuarios'); ?>
    <br>
-->	
	<label for="Nome">Nome da Unidade:</label>
    <input type="text" class="form-control" id="Nome" maxlength="255"
           name="Nome" value="<?php echo $query['Nome']; ?>">
    <?php echo form_error('Nome'); ?>
    <br>
	
    <label for="Celular">Telefone:</label>
    <input type="text" class="form-control Celular Celular" id="Celular" maxlength="11"
           name="Celular" placeholder="(XX)999999999" value="<?php echo $query['Celular']; ?>">
    <?php echo form_error('Celular'); ?>
    <br>
<!--	
    <label class="text-">E-mail do Administrador:</label>
    <input type="text" class="form-control" id="Email" maxlength="100"
           name="Email" value="<?php echo $query['Email']; ?>">
    <?php echo form_error('Email'); ?>
    <br>
-->	
    <label for="UsuarioEmpresaFilial">Usuário do Admin. da Unidade:</label>
    <input type="text" class="form-control" id="UsuarioEmpresaFilial" maxlength="45"
           name="UsuarioEmpresaFilial" value="<?php echo $query['UsuarioEmpresaFilial']; ?>">
    <?php echo form_error('UsuarioEmpresaFilial'); ?>
    <br>

    <label for="Senha">Senha do Usuário:</label>
    <input type="password" class="form-control" id="Senha" maxlength="45"
           name="Senha" value="<?php echo $query['Senha']; ?>">
    <?php echo form_error('Senha'); ?>
    <br>

    <label for="Senha">Confirmar Senha:</label>
    <input type="password" class="form-control" id="Confirma" maxlength="45"
           name="Confirma" value="<?php echo $query['Confirma']; ?>">
    <?php echo form_error('Confirma'); ?>
    <br>	

    <button class="btn btn-lg btn-info btn-block" type="submit">REGISTRAR</button>
	<br>
	<a class="btn btn-lg btn-primary  btn-block" href="<?php echo base_url(); ?>login/index" role="button">Acesso dos Usuários</a>
	<br>
	<a class="btn btn-lg btn-danger btn-block" href="<?php echo base_url(); ?>loginempresamatriz/index" role="button">Acesso do Admin. Matriz</a>		
</form>

</div>
