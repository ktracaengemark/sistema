<?php (isset($orcatrata)) ? $query = $orcatrata : FALSE; ?>

<div class="row">
    <div class="btn-group" role="group">
        <a class="btn btn-lg btn-primary active"> 
            <span class="glyphicon glyphicon-sort-by-attributes"></span> <?php echo '<b>Total de Orçamentos:</b> ' . $query->num_rows() ?>
        </a>        
    </div>

    <div class="btn-group" role="group">
        <a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>orcatrata/cadastrar" role="button"> 
            <span class="glyphicon glyphicon-plus"></span> Novo Orçamento/Plano de Trat.
        </a>
    </div>
</div>        

<br>

<?php
foreach ($query->result_array() as $row) {

    /*if ($row['StatusVida'] == 'V') {
        $row['class'] = 'danger';
        #$row['icon'] = 'glyphicon glyphicon-info-sign';
        $row['vida'] = '<span class="label label-danger" style="font-size: 14px;">Óbito</span>';
    } else {
        $row['class'] = 'info';
        #$row['icon'] = 'fa fa-user';
        $row['vida'] = '';
    }*/
	
	if ($row['StatusOrca'] == 'N') {
        $row['class'] = 'danger';
        #$row['icon'] = 'glyphicon glyphicon-info-sign';
        $row['vida'] = '<span class="label label-danger" style="font-size: 14px;">Atenção</span>';
    } else {
        $row['class'] = 'info';
        #$row['icon'] = 'fa fa-user';
        $row['vida'] = '';
    }
    
    /*if ($row['Sexo'] == 'FEMININO') {
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
    }*/
    
    ?>

        <div class="bs-callout bs-callout-<?php echo $row['class']; ?>" id=callout-overview-not-both> 

            <a class="btn btn-<?php echo $row['class']; ?>" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button"> 
                <span class="glyphicon glyphicon-edit"></span> Editar Dados
            </a>          
            <!--<a class="btn btn-<?php echo $row['class']; ?>" href="<?php echo base_url() . 'consulta/cadastrar/' . $row['idApp_Cliente'] . '/' . $row['idApp_OrcaTrata'] ?>" role="button"> 
                <span class="glyphicon glyphicon-time"></span> Marcar Sessão
            </a>            
            <a class="btn btn-<?php echo $row['class']; ?>" href="<?php echo base_url() . 'consulta/listar/' . $row['idApp_Cliente'] ?>" role="button"> 
                <span class="glyphicon glyphicon-list"></span> Listar Sessões
            </a>-->  
            
            <br><br>
            
            <h4>
                <!--<span class="<?php echo $row['icon']; ?>"></span>
                Nome<?php echo $row['Profissional'] . ' <code><small>Identificador: ' . $row['idApp_Profissional'] . '</small></code>'; ?>
                <?php echo $row['vida']; ?>
				--> 
				<?php if ($row['idApp_Profissional']) { ?>
				<span class="glyphicon glyphicon-user"></span> <b>Prof.:</b> <?php echo $row['idApp_Profissional']; ?>
				<?php } ?>
				
				<?php if ($row['StatusOrca']) { ?>
				<span class="glyphicon glyphicon-info-sign"></span> <b>Aprovado:</b> <?php echo $row['StatusOrca']; ?>
				<?php } ?>
								
				<?php if ($row['idTab_TipoConcluido']) { ?>
				<span class="glyphicon glyphicon-info-sign"></span> <b>Concluído:</b> <?php echo $row['idTab_TipoConcluido']; ?>
				<?php } ?>
				
				
			
			</h4>

            <br>
            
            <p>
                <!--<?php if ($row['DataOrca']) { ?>
                <span class="glyphicon glyphicon-usd"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?> -
                    <b>Idade:</b> <?php echo $row['Idade']; ?> -
				
				<?php } if ($row['Sexo']) { ?>
                <span class="<?php echo $row['icon-sex']; ?>"></span> <b>Sexo:</b> <?php echo $row['Sexo']; ?>
                <?php } ?>
				-->
				<?php if ($row['DataOrca']) { ?>
				<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçam.:</b> <?php echo $row['DataOrca']; ?>
				<?php } ?>
				
				<?php if ($row['DataConcl']) { ?>
				<span class="glyphicon glyphicon-calendar"></span> <b>Data da Concl.:</b> <?php echo $row['DataConcl']; ?>
				<?php } ?>

				<?php if ($row['DataRet']) { ?>
				<span class="glyphicon glyphicon-calendar"></span> <b>Data de Ret.:</b> <?php echo $row['DataRet']; ?>
				<?php } ?>

            </p>
			
			<p>
			    <?php if ($row['ValorOrca']) { ?>
				<span class="glyphicon glyphicon-usd"></span> <b>Orçam.:R$</b> <?php echo $row['ValorOrca']; ?>
				<?php } ?>
				
				<?php if ($row['FormaPag']) { ?>
				<span class="glyphicon glyphicon-usd"></span> <b>Forma de Pagam.:</b> <?php echo $row['FormaPag']; ?>
				<?php } ?>
			</p>	
							
			<p>
				<?php if ($row['QtdParcOrca']) { ?>
				<span class="glyphicon glyphicon-usd"></span> <b>Quant de Parc.:</b> <?php echo $row['QtdParcOrca']; ?>
				<?php } ?>
				
				<?php if ($row['DataVenc']) { ?>
				<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVenc']; ?>
				<?php } ?>
			
			
			</p>
			

			
			<hr>
            <p>
				
                <span class="glyphicon glyphicon-pencil"></span> <b>Obs.:</b> <?php echo nl2br($row['ObsOrca']); ?>
            </p>

        </div>        

<?php } ?>