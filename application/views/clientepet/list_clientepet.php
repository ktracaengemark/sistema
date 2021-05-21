<?php (isset($clientepet)) ? $query = $clientepet : FALSE; ?>
<div class="container-fluid">
	<div class="row">
		<div class="btn-group" role="group">
			<a class="btn btn-lg btn-primary active"> 
				<span class="glyphicon glyphicon-sort-by-attributes"></span> <?php echo '<b>Total:</b> ' . $query->num_rows() ?>
			</a>        
		</div>

		<div class="btn-group" role="group">
			<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>clientepet/cadastrar" role="button"> 
				<span class="glyphicon glyphicon-plus"></span> Cad.
			</a>
		</div>
	</div>        
</div>
<br>

<?php
foreach ($query->result_array() as $row) {

    if ($row['StatusVidaPet'] == 'O') {
        $row['class'] = 'danger';
        #$row['icon'] = 'glyphicon glyphicon-info-sign';
        $row['vida'] = '<span class="label label-danger" style="font-size: 14px;">Óbito</span>';
    } else {
        $row['class'] = 'info';
        #$row['icon'] = 'fa fa-user';
        $row['vida'] = '';
    }
    
    if ($row['SexoPet'] == 'FEMININO') {
        $row['icon'] = 'fa fa-female';
        $row['icon-sex'] = 'fa fa-venus';
    }
    elseif ($row['SexoPet'] == 'MASCULINO') {
        $row['icon'] = 'fa fa-male';
        $row['icon-sex'] = 'fa fa-mars';
    }
    else  {
        $row['icon'] = 'fa fa-user';
        $row['icon-sex'] = 'fa fa-genderless';
    }
    
    ?>

        <div class="bs-callout bs-callout-<?php echo $row['class']; ?>" id=callout-overview-not-both> 
			<div class="row">
				<div class="col-md-12">
					<div class=" col-md-2">	
						<div class="row">	
							<div class="col-sm-offset-2 col-md-10 " align="left"> 
								<a href="<?php echo base_url() . 'clientepet/alterarlogopet/' . $row['idApp_ClientePet']; ?>">
									<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $row['Arquivo'] . ''; ?>" class="img-circle img-responsive" width='200'>
								</a>													
							</div>
						</div>		
					</div>
					<div class="col-md-6">
						<a class="btn btn-<?php echo $row['class']; ?>" href="<?php echo base_url() . 'clientepet/alterar/' . $row['idApp_ClientePet'] ?>" role="button"> 
							<span class="glyphicon glyphicon-edit"></span> Editar Dados
						</a>          
						
						<br><br>
						
						<h4>
							<span class="<?php echo $row['icon']; ?>"></span> 
							<?php echo $row['NomeClientePet'] . '</small></code>'; ?>
							<?php echo $row['vida']; ?>
							
						</h4>
			 
						<p>
							<?php if ($row['DataNascimentoPet']) { ?>
							<span class="glyphicon glyphicon-gift"></span> <b>Aniver.:</b> <?php echo $row['DataNascimentoPet']; ?>-
								
								<!--<b>Idade:</b> <?php /*echo $row['Idade']; */?>--> 
						</p>
						<p>
							<?php } if ($row['SexoPet']) { ?>
							<span class="<?php echo $row['icon-sex']; ?>"></span> <b>SexoPet:</b> <?php echo $row['SexoPet']; ?>										
							<?php } ?>
						</p>
						<p>	
							<?php if ($row['AtivoPet']) { ?>
							<span class="glyphicon glyphicon-alert"></span> <b>AtivoPet:</b> <?php echo $row['AtivoPet']; ?>
							<?php } ?>
						</p>

						<p>
							<span class="glyphicon glyphicon-pencil"></span> <b>ObsPet:</b> <?php echo nl2br($row['ObsPet']); ?>
						</p>
					</div>
				</div>
			</div>	
        </div>        

<?php } ?>