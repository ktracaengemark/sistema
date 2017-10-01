<div class="container text-center" id="login">

    <?php echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('loginassociadoempresafilial', 'role="form"'); ?>

    <p class="text-center">
        <a href="<?php echo base_url(); ?>loginassociadoempresafilial">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>
    <!--<h2 class="form-signin-heading text-center">Agenda <?php echo ucfirst($nome_modulo) ?></h2><h4><b>***** versão alpha *****</b></h4>-->
    <h2 class="form-signin-heading text-center">Módulo "Empresas"</h2>	
    <input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
    <button class="btn btn-lg btn-warning btn-block" type="submit">Acesso do Admin. da Empresa</button>	
	<label class="sr-only">Usuário</label>
    <input type="text" id="inputText" class="form-control" placeholder="Usuário ou E-mail" autofocus name="UsuarioEmpresaFilial" value="<?php echo set_value('UsuarioEmpresaFilial'); ?>">	   
	<label class="sr-only">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">

    <p><a href="<?php echo base_url(); ?>loginassociadoempresafilial/recuperar/?usuario=<?php echo set_value('UsuarioEmpresaFilial'); ?>">Esqueci Admin./senha!</a></p>
    <br>
	<a class="btn btn  btn-primary btn-block" href="<?php echo base_url(); ?>login/index" role="button">Acesso do Usuário da Empresa</a>	   
	<a class="btn btn  btn-danger btn-block" href="<?php echo base_url(); ?>loginassociadoempresafilial/registrar" role="button">Cadastrar Nova Empresa</a>

</form>

</div>