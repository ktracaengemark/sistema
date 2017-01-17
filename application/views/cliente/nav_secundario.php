<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<ul class="nav nav-sidebar">
    <li>
        <div class="text-center t">
            <h4><?php echo '<strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong><br><small>Identificador: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?></h4>
        </div>
    </li>
</ul>

<ul class="nav nav-sidebar">
    <li <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
        <a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
            <span class="glyphicon glyphicon-user"> </span> Dados do Cliente <span class="sr-only">(current)</span>
        </a>
    </li>

    <li <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
        <a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
            <span class="glyphicon glyphicon-edit"></span> Editar Dados
        </a>
    </li>

    <li <?php if (preg_match("/contatocliente\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
        <a href="<?php echo base_url() . 'contatocliente/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
            <span class="fa fa-user-plus"></span> Contatos
        </a>
    </li>

    <li <?php if (preg_match("/consulta\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
        <a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
            <span class="glyphicon glyphicon-time"></span> Marcar Sessão
        </a>
    </li>

    <li <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
        <a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
            <span class="glyphicon glyphicon-list"></span> Listar Sessões
        </a>
    </li>

	<li <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
        <a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
            <span class="glyphicon glyphicon-plus"></span> Novo Orçamento
        </a>
    </li>

	<li <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
        <a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
            <span class="glyphicon glyphicon-list-alt"></span> Listar Orçamentos
        </a>
    </li>

    <!--<li <?php if (preg_match("/tratamentos\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
        <a href="<?php echo base_url() . 'tratamentos/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
            <span class="glyphicon glyphicon-time"></span> Modelo/Orçam/Pl.Trata.
        </a>
    </li>-->


</ul>

<?php } ?>
