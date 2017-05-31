<div class="container-fluid">
    <div class="row">

        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
    			<li role="presentation"><a href="#proxima" aria-controls="proxima" role="tab" data-toggle="tab">Despesass Aprovados</a></li>
                <li role="presentation" class="active"><a href="#anterior" aria-controls="anterior" role="tab" data-toggle="tab">Despesass Não Aprovados</a></li>
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

                        <a class="btn btn-success" href="<?php echo base_url() . 'despesas/alterar/' . $row['idApp_Despesas'] ?>" role="button">
                            <span class="glyphicon glyphicon-edit"></span> Editar Dados
                        </a>

                        <br><br>

                        <h4>
                            <span class="glyphicon glyphicon-calendar"></span> <b>Data do Despesas:</b> <?php echo $row['DataDespesas']; ?>
                        </h4>

                        <p>
                            <?php if ($row['ProfissionalDespesas']) { ?>
                            <span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalDespesas']; ?> -
                            <?php } if ($row['AprovadoDespesas']) { ?>
                            <span class="glyphicon glyphicon-thumbs-up"></span> <b>Despesas Aprovado?</b> <?php echo $row['AprovadoDespesas']; ?>
                            <?php } ?>

                        </p>
                        <p>
                            <span class="glyphicon glyphicon-pencil"></span> <b>Obs:</b> <?php echo nl2br($row['ObsDespesas']); ?>
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

                        <a class="btn btn-danger" href="<?php echo base_url() . 'despesas/alterar/' . $row['idApp_Despesas'] ?>" role="button">
                            <span class="glyphicon glyphicon-edit"></span> Editar Dados
                        </a>

                        <br><br>

                        <h4>
                            <span class="glyphicon glyphicon-calendar"></span> <b>Data do Despesas:</b> <?php echo $row['DataDespesas']; ?>
                        </h4>

                        <p>
                            <?php if ($row['ProfissionalDespesas']) { ?>
                            <span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalDespesas']; ?> -
                            <?php } if ($row['AprovadoDespesas']) { ?>
                            <span class="glyphicon glyphicon-thumbs-up"></span> <b>Despesas Aprovado?</b> <?php echo $row['AprovadoDespesas']; ?>
                            <?php } ?>

                        </p>
                        <p>
                            <span class="glyphicon glyphicon-pencil"></span> <b>Obs:</b> <?php echo nl2br($row['ObsDespesas']); ?>
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
