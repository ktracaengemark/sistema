<div class="container-fluid">

	<div class="form-group">
		<div class="row">			
			<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>tarefa/cadastrar" role="button"> 
				<span class="glyphicon glyphicon-plus"></span> Nova Tarefa
			</a>
			<a class="btn btn-lg btn-info" href="<?php echo base_url() ?>agenda" role="button"> 
				<span class="glyphicon glyphicon-calendar"></span> Agenda
			</a>						
		</div>		
	</div>
    <div class="row">

        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
    			<li role="presentation"><a href="#proxima" aria-controls="proxima" role="tab" data-toggle="tab">Concluída</a></li>
                <li role="presentation" class="active"><a href="#anterior" aria-controls="anterior" role="tab" data-toggle="tab">Não Concluída</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

    			<!-- Próximas Consultas -->
                <div role="tabpanel" class="tab-pane" id="proxima">

                    <?php
                    if ($aprovado) {

                        foreach ($aprovado->result_array() as $row) {
                    ?>

                    <div class="bs-callout bs-callout-success" id=callout-overview-not-both>

                        <a class="btn btn-success" href="<?php echo base_url() . 'tarefa/alterar/' . $row['idApp_Tarefa'] ?>" role="button">
                            <span class="glyphicon glyphicon-edit"></span> Editar Dados
                        </a>

                        <br><br>
						
                            
                             
                        
                        <h4>
							<p>
								<span class=""></span> <b>Tarefa:</b> <?php echo $row['idApp_Tarefa']; ?>
                            </p>
							<p>
								<span class="glyphicon glyphicon-pencil"></span> <b></b> <?php echo nl2br($row['ObsTarefa']); ?>	
							</p>
                        </h4>
						
						<p>
                            <?php if ($row['ProfissionalTarefa']) { ?>
                            <span class="glyphicon glyphicon-user"></span> <b>Responsável:</b> <?php echo $row['ProfissionalTarefa']; ?> 
                        </p>
						<p>
							<?php } if ($row['Rotina']) { ?>
                            <span class="glyphicon glyphicon-refresh"></span> <b>Rotina?</b> <?php echo $row['Rotina']; ?>							
						</p>
						<p>                           
							<?php if ($row['DataTarefa']) { ?>
                            <span class="glyphicon glyphicon-calendar"></span> <b>Criada:</b> <?php echo $row['DataTarefa']; ?> 
                        </p>    
						<p>	
							<?php } if ($row['DataPrazoTarefa']) { ?>
                            <span class="glyphicon glyphicon-calendar"></span> <b>Prazo:</b> <?php echo $row['DataPrazoTarefa']; ?>						
						</p>
						<p>
							<?php } if ($row['Prioridade']) { ?>
                            <span class="glyphicon glyphicon-upload"></span> <b>Prioridade?</b> <?php echo $row['Prioridade']; ?>
                            <?php } ?>						
						</p>                       
						<p>    
							<?php } if ($row['TarefaConcluida']) { ?>
                            <span class="glyphicon glyphicon-thumbs-up"></span> <b>Tarefa Concluída?</b> <?php echo $row['TarefaConcluida']; ?>
                            <?php } ?>
                        </p>                        
                    </div>

                    <?php
                        }
                    } else {
                        echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
                    }
                    ?>

                </div>

                <!-- Histórico de Consultas -->
                <div role="tabpanel" class="tab-pane active" id="anterior">

                    <?php
                    if ($naoaprovado) {

                        foreach ($naoaprovado->result_array() as $row) {
                    ?>

                    <div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

                        <a class="btn btn-danger" href="<?php echo base_url() . 'tarefa/alterar/' . $row['idApp_Tarefa'] ?>" role="button">
                            <span class="glyphicon glyphicon-edit"></span> Editar Dados
                        </a>

                        <br><br>
						
                        <h4>						
                            <p>
								<span class=""></span> <b>Tarefa:</b> <?php echo $row['idApp_Tarefa']; ?>
                            </p>
							<p>
								<span class="glyphicon glyphicon-pencil"></span> <b></b> <?php echo nl2br($row['ObsTarefa']); ?>	
							</p>					
                        </h4>
						
						<p>
                            <?php if ($row['ProfissionalTarefa']) { ?>
                            <span class="glyphicon glyphicon-user"></span> <b>Responsável:</b> <?php echo $row['ProfissionalTarefa']; ?> 
                        </p>
						<p>
							<?php } if ($row['Rotina']) { ?>
                            <span class="glyphicon glyphicon-refresh"></span> <b>Rotina?</b> <?php echo $row['Rotina']; ?>							
						</p>
						<p>                           
							<?php if ($row['DataTarefa']) { ?>
                            <span class="glyphicon glyphicon-calendar"></span> <b>Criada:</b> <?php echo $row['DataTarefa']; ?> 
                        </p>    
						<p>	
							<?php } if ($row['DataPrazoTarefa']) { ?>
                            <span class="glyphicon glyphicon-calendar"></span> <b>Prazo:</b> <?php echo $row['DataPrazoTarefa']; ?>						
						</p>
						<p>
							<?php } if ($row['Prioridade']) { ?>
                            <span class="glyphicon glyphicon-upload"></span> <b>Prioridade?</b> <?php echo $row['Prioridade']; ?>
                            <?php } ?>						
						</p>                       
						<p>    
							<?php } if ($row['TarefaConcluida']) { ?>
                            <span class="glyphicon glyphicon-thumbs-down"></span> <b>Tarefa Concluída?</b> <?php echo $row['TarefaConcluida']; ?>
                            <?php } ?>
                        </p>                       
                    </div>

                    <?php
                        }
                    } else {
                        echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
                    }
                    ?>

                </div>

            </div>

        </div>

    </div>

</div>
