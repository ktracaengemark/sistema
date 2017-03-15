<div class="container-fluid">
    <div class="row">

        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
    			<li role="presentation"><a href="#proxima" aria-controls="proxima" role="tab" data-toggle="tab">Concluída.</a></li>
                <li role="presentation" class="active"><a href="#anterior" aria-controls="anterior" role="tab" data-toggle="tab"><strong>Não</strong> Concluída</a></li>
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

                        <h3>
							<span class="glyphicon glyphicon-pencil"></span> <b>Tarefa:</b> <?php echo nl2br($row['ObsTarefa']); ?>                           
                        </h3>
						<h4>
                            <span class="glyphicon glyphicon-calendar"></span> <b>Data Limite:</b> <?php echo $row['DataTarefa']; ?>
                        </h4>
						<br>
                        <p>
                            
							<?php if ($row['ProfissionalTarefa']) { ?>
                            <span class="glyphicon glyphicon-user"></span> <b>Responsável:</b> <?php echo $row['ProfissionalTarefa']; ?> -
                        </p>
						<p>
							<?php } if ($row['AprovadoTarefa']) { ?>
                            <span class="glyphicon glyphicon-thumbs-up"></span> <b>Tarefa Concluída?</b> <?php echo $row['AprovadoTarefa']; ?>
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
						<h3>
							<span class="glyphicon glyphicon-pencil"></span> <b>Tarefa:</b> <?php echo nl2br($row['ObsTarefa']); ?>                           
                        </h3>
                        <h4>
							<span class="glyphicon glyphicon-calendar"></span> <b>Data Limite:</b> <?php echo $row['DataTarefa']; ?>                          
                        </h4>
						<br>
                        <p>
                            <?php if ($row['ProfissionalTarefa']) { ?>
                            <span class="glyphicon glyphicon-user"></span> <b>Responsável:</b> <?php echo $row['ProfissionalTarefa']; ?> -
                        </p>
						<p>		
							<?php } if ($row['AprovadoTarefa']) { ?>
                            <span class="glyphicon glyphicon-thumbs-up"></span> <b>Tarefa Concluída?</b> <?php echo $row['AprovadoTarefa']; ?>
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
