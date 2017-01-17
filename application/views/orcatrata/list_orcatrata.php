<?php (isset($orcatrata)) ? $query = $orcatrata : FALSE; ?>

<div class="row">
    <div class="btn-group" role="group">
        <a class="btn btn-lg btn-primary active">
            <span class="glyphicon glyphicon-sort-by-attributes"></span> <?php echo '<b>Total de Orçamentos:</b> ' . $query->num_rows() ?>
        </a>
    </div>

    <div class="btn-group" role="group">
        <a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>orcatrata/cadastrar" role="button">
            <span class="glyphicon glyphicon-plus"></span> Novo Orçamento
        </a>
    </div>
</div>

<br>

<?php
foreach ($query->result_array() as $row) {
    ?>

        <div class="bs-callout bs-callout-info" id=callout-overview-not-both>

            <a class="btn btn-info" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
                <span class="glyphicon glyphicon-edit"></span> Editar Dados
            </a>

            <br><br>

            <h4>
                <span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
            </h4>

            <p>
                <?php if ($row['ProfissionalOrca']) { ?>
                <span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
                <?php } if ($row['AprovadoOrca']) { ?>
                <span class="glyphicon glyphicon-thumbs-up"></span> <b>Orçamento Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
                <?php } ?>

            </p>
            <p>
                <span class="glyphicon glyphicon-pencil"></span> <b>Obs:</b> <?php echo nl2br($row['ObsOrca']); ?>
            </p>

        </div>

<?php } ?>
