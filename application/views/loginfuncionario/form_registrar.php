<div class="container" id="loginfuncionario">

    <?php #echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('loginfuncionario/registrar', 'role="form"'); ?>

    <!--
    <p class="text-center">
        <a href="<?php echo base_url() . '/' . $_SESSION['log']['modulo']; ?>">
        <a href="<?php echo base_url() ?>">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $_SESSION['log']['modulo'] . '.png' ; ?>" width="25%" />
        </a>
    </p>
    -->
	<p class="text-center">
        <a href="<?php echo base_url(); ?>loginfuncionario">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>
    <h2 class="form-signin-heading text-center">Cadastrar Novo Funcionário</h2>
	<!--
	<label for="NomeEmpresa">Nome da Empresa:</label>
	<input type="text" class="form-control" id="NomeEmpresa" maxlength="45" 
		   name="NomeEmpresa" value="<?php echo $query['NomeEmpresa']; ?>">
	<?php echo form_error('NomeEmpresa'); ?>
	<br>
	-->
	<label for="Nome">Nome do Funcionário:</label>
    <input type="text" class="form-control" id="Nome" maxlength="255"
           name="Nome" value="<?php echo $query['Nome']; ?>">
    <?php echo form_error('Nome'); ?>
    <br>
	
	<label for="Celular">Celular:</label>
    <input type="text" class="form-control Celular Celular" id="Celular" maxlength="11"
           name="Celular" placeholder="(XX)999999999" value="<?php echo $query['Celular']; ?>">
    <?php echo form_error('Celular'); ?>
    <br>

    <label for="DataNascimento">Data de Nascimento:</label>
    <input type="text" class="form-control Date" id="inputDate0" maxlength="10"
           name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
    <?php echo form_error('DataNascimento'); ?>
    <br>

    <label for="Sexo">Sexo:</label>
    <select data-placeholder="Selecione um TROCA..." class="form-control" id="Sexo" name="Sexo">
        <option value="">-- Selecione uma opção --</option>
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
	
	<label for="Funcao">Funcao:*</label>
	<select data-placeholder="Selecione uma opção..." class="form-control" id="Funcao" name="Funcao">		
		<option value="">-- Selecione uma Funcao --</option>
		<?php
		foreach ($select['Funcao'] as $key => $row) {
			if ($query['Funcao'] == $key) {
				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
			} else {
				echo '<option value="' . $key . '">' . $row . '</option>';
			}
		}
		?>   
	</select> 
    <?php echo form_error('Sexo'); ?>
    <br>

	<label for="Permissao">Nível de Permissão:*</label>
	<select data-placeholder="Selecione uma opção..." class="form-control" id="Permissao" name="Permissao">			
		<option value="">-- Selecione uma Permissao --</option>
		<?php
		foreach ($select['Permissao'] as $key => $row) {
			if ($query['Permissao'] == $key) {
				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
			} else {
				echo '<option value="' . $key . '">' . $row . '</option>';
			}
		}
		?>   
	</select> 
    <?php echo form_error('Sexo'); ?>
    <br>	
	
    <label class="text-">E-mail do Usuário:</label>
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
	

    <button class="btn btn-lg btn-primary btn-block" type="submit">REGISTRAR</button>
</form>

</div>
