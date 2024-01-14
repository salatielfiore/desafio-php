<?php
include(__DIR__ . '/../../inc/conecta.php');
include(__DIR__ . '/../../util/StringUtil.php');

if (isset($_GET['excluir']) && is_numeric($_GET['excluir'])) {
    $idContato = limparScapeString($_GET['excluir']);
    $sqlExcluir = "DELETE FROM `contatos` WHERE id = $idContato";
    mysql_query($sqlExcluir);
    header("Location: index.php");
    exit();
}

