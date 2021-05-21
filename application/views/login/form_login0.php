<div class="container text-center" id="login">

    <!--<?php #echo validation_errors(); ?>-->

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('login', 'role="form"'); ?>

    <p class="text-center">
        <a href="<?php echo base_url(); ?>login">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>
    <!--<h2 class="form-signin-heading text-center">Agenda <?php echo ucfirst($nome_modulo) ?></h2><h4><b>***** versão alpha *****</b></h4>-->
    <h2 class="form-signin-heading text-center">Empresas & Pessoas</h2>	
	<!--
	<label class="sr-only">Empresa</label>
    <input type="text" id="idSis_Empresa" class="form-control" placeholder="Empresa" autofocus name="idSis_Empresa" value="<?php echo set_value('idSis_Empresa'); ?>">
	-->
	<!--
	<label class="sr-only">Empresa</label>
	<select data-placeholder="Selecione uma opção..." class="form-control" id="idSis_Empresa" name="idSis_Empresa">			
		<option value="">-- Selecione sua Empresa --</option>
		<?php
		foreach ($select['idSis_Empresa'] as $key => $row) {
					(!$query['idSis_Empresa']) ? $query['idSis_Empresa'] = '5' : FALSE;	
			if ($query['idSis_Empresa'] == $key) {
				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
			} else {
				echo '<option value="' . $key . '">' . $row . '</option>';
			}
		}
		?>   
	</select> 
    <?php #echo form_error('idSis_Empresa'); ?>
	<label class="sr-only">Usuário</label>
    <input type="text" id="Usuario" class="form-control" placeholder="Usuário ou E-mail" autofocus name="Usuario" value="<?php #echo set_value('Usuario'); ?>">	   
	<?php #echo form_error('Usuario'); ?>
	<label class="sr-only">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">
    <?php #echo form_error('Senha'); ?>
	<input type="hidden" name="modulo" value="<?php #echo $modulo; ?>">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Acesso dos Usuários </button>	
    <br>
	<p><a href="<?php #echo base_url(); ?>login/recuperar/?usuario=<?php #echo set_value('Usuario'); ?>">Esqueci usuário/senha!</a></p>
    <br>
	-->
	<a class="btn btn-lg btn-warning btn-block" href="<?php echo base_url(); ?>login/index0" role="button">Acessar Contas</a>
	<a class="btn btn-lg btn-danger btn-block" href="<?php echo base_url(); ?>pesquisar" role="button">Empresas, Produtos e Serviços</a>	

	
</form>

</div>