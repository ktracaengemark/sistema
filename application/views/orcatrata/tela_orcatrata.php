<?php if ($msg) echo $msg; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php echo $nav_secundario; ?>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <?php
            if (!$list) {
            ?>
                <a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>orcatrata/cadastrar" role="button">
                    <span class="glyphicon glyphicon-plus"></span> Cadastrar Novo Orçamento
                </a>
                <br><br>
                <div class="alert alert-info" role="alert"><b>Nenhum orçamento cadastrado</b></div>
            <?php
            } else {
                echo $list;
            }
            ?>

        </div>

    </div>
</div>
