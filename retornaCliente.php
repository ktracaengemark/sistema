<?php
    $pdo = new PDO("mysql:host=localhost; dbname=app; charset=utf8;", "root", "", $opcoes);
    $dados = $pdo->prepare("SELECT NomeProfissional FROM App_Profissional");
    $dados->execute();
    echo json_encode($dados->fetchAll(PDO::FETCH_ASSOC));
    $json = '[';
    $first = true;
?>
