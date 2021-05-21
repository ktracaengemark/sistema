<?php (isset($clientedep)) ? $query = $clientedep : FALSE; ?>
<div class="container-fluid">
	<div class="row">
		<div class="btn-group" role="group">
			<a class="btn btn-lg btn-primary active"> 
				<span class="glyphicon glyphicon-sort-by-attributes"></span> <?php echo '<b>Total:</b> ' . $query->num_rows() ?>
			</a>        
		</div>

		<div class="btn-group" role="group">
			<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>clientedep/cadastrar" role="button"> 
				<span class="glyphicon glyphicon-plus"></span> Cad.
			</a>
		</div>
	</div>        
</div>
<br>

<?php
foreach ($query->result_array() as $row) {

    if ($row['StatusVidaDep'] == 'O') {
        $row['class'] = 'danger';
        #$row['icon'] = 'glyphicon glyphicon-info-sign';
        $row['vida'] = '<span class="label label-danger" style="font-size: 14px;">Óbito</span>';
    } else {
        $row['class'] = 'info';
        #$row['icon'] = 'fa fa-user';
        $row['vida'] = '';
    }
    
    if ($row['SexoDep'] == 'FEMININO') {
        $row['icon'] = 'fa fa-female';
        $row['icon-sex'] = 'fa fa-venus';
    }
    elseif ($row['SexoDep'] == 'MASCULINO') {
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
								<a href="<?php echo base_url() . 'clientedep/alterarlogodep/' . $row['idApp_ClienteDep']; ?>">
									<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $row['Arquivo'] . ''; ?>" class="img-circle img-responsive" width='200'>
								</a>													
							</div>
						</div>		
					</div>
					<div class="col-md-6">
						<a class="btn btn-<?php echo $row['class']; ?>" href="<?php echo base_url() . 'clientedep/alterar/' . $row['idApp_ClienteDep'] ?>" role="button"> 
							<span class="glyphicon glyphicon-edit"></span> Editar Dados
						</a>          
						
						<br><br>
						
						<h4>
							<span class="<?php echo $row['icon']; ?>"></span> 
							<?php echo $row['NomeClienteDep'] . '</small></code>'; ?>
							<?php echo $row['vida']; ?>
							
						</h4>
			 
						<p>
							<?php if ($row['DataNascimentoDep']) { ?>
							<span class="glyphicon glyphicon-gift"></span> <b>Aniver.:</b> <?php echo $row['DataNascimentoDep']; ?>-
								
								<!--<b>Idade:</b> <?php /*echo $row['Idade']; */?>--> 
						</p>
						<p>
							<?php } if ($row['SexoDep']) { ?>
							<span class="<?php echo $row['icon-sex']; ?>"></span> <b>SexoDep:</b> <?php echo $row['SexoDep']; ?>										
							<?php } ?>
						</p>
						<p>	
							<?php if ($row['AtivoDep']) { ?>
							<span class="glyphicon glyphicon-alert"></span> <b>AtivoDep:</b> <?php echo $row['AtivoDep']; ?>
							<?php } ?>
						</p>

						<p>
							<span class="glyphicon glyphicon-pencil"></span> <b>ObsDep:</b> <?php echo nl2br($row['ObsDep']); ?>
						</p>
					</div>
				</div>
			</div>
		</div>        

<?php } ?>