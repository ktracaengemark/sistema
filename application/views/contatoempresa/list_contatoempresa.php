<?php (isset($contatoempresa)) ? $query = $contatoempresa : FALSE; ?>
<div class="container-fluid">
	<div class="row">
		<div class="btn-group" role="group">
			<a class="btn btn-lg btn-primary active"> 
				<span class="glyphicon glyphicon-sort-by-attributes"></span> <?php echo '<b>Total:</b> ' . $query->num_rows() ?>
			</a>        
		</div>
		<?php if ($_SESSION['log']['idSis_Empresa'] == $_SESSION['Empresa2']['idSis_Empresa'] ) { ?>
		<div class="btn-group" role="group">
			<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>contatoempresa/cadastrar" role="button"> 
				<span class="glyphicon glyphicon-plus"></span> Cad.
			</a>
		</div>
		<?php } ?>
	</div>        
</div>
<br>

<?php
foreach ($query->result_array() as $row) {

    if ($row['StatusVida'] == 'O') {
        $row['class'] = 'danger';
        #$row['icon'] = 'glyphicon glyphicon-info-sign';
        $row['vida'] = '<span class="label label-danger" style="font-size: 14px;">Óbito</span>';
    } else {
        $row['class'] = 'info';
        #$row['icon'] = 'fa fa-user';
        $row['vida'] = '';
    }
  
    if ($row['Sexo'] == 'FEMININO') {
        $row['icon'] = 'fa fa-female';
        $row['icon-sex'] = 'fa fa-venus';
    }
    elseif ($row['Sexo'] == 'MASCULINO') {
        $row['icon'] = 'fa fa-male';
        $row['icon-sex'] = 'fa fa-mars';
    }
    else  {
        $row['icon'] = 'fa fa-user';
        $row['icon-sex'] = 'fa fa-genderless';
    }
    
    ?>

        <div class="bs-callout bs-callout-<?php echo $row['class']; ?>" id=callout-overview-not-both> 
			<?php if ($_SESSION['log']['idSis_Empresa'] == $_SESSION['Empresa2']['idSis_Empresa'] ) { ?>
            <a class="btn btn-<?php echo $row['class']; ?>" href="<?php echo base_url() . 'contatoempresa/alterar/' . $row['idSis_Usuario'] ?>" role="button"> 
                <span class="glyphicon glyphicon-edit"></span> Editar Dados
            </a>          
            
            <br><br>
            <?php } ?>
            <h4>
                <span class="<?php echo $row['icon']; ?>"></span> 
                <?php echo $row['Nome'] . '</small></code>'; ?>
                <?php echo $row['vida']; ?>
				
			</h4>	

 
            <p>
                <?php if ($row['DataNascimento']) { ?>
                <span class="glyphicon glyphicon-gift"></span> <b>Aniver.:</b> <?php echo $row['DataNascimento']; ?>-
                    
					<b>Idade:</b> <?php echo $row['Idade']; ?> 
            </p>
			<p>
				<?php } if ($row['Sexo']) { ?>
                <span class="<?php echo $row['icon-sex']; ?>"></span> <b>Sexo:</b> <?php echo $row['Sexo']; ?>										
                <?php } ?>
			</p>
			<p>	
				<?php if ($row['Celular']) { ?>
				<span class="glyphicon glyphicon-phone-alt"></span> <b>Telefone:</b> <?php echo $row['Celular']; ?>
				<?php } ?>
            </p>
			<!--
			<p>	
				<?php if ($row['Ativo']) { ?>
				<span class="glyphicon glyphicon-alert"></span> <b>Ativo:</b> <?php echo $row['Ativo']; ?>
				<?php } ?>
            </p>
			-->

        </div>        

<?php } ?>