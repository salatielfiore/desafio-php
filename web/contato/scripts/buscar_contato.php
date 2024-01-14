<?php
include(__DIR__ . '/../../inc/conecta.php');
include_once(__DIR__ . '/../../util/StringUtil.php');

// Verifica se o parâmetro 'id' está presente na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idContato = limparScapeString($_GET['id']);

    // Recupera os dados do contato a ser editado
    $sqlEditar = "SELECT * FROM `contatos` WHERE id = $idContato";
    $resultadoEditar = mysql_query($sqlEditar);

    if (mysql_num_rows($resultadoEditar) == 1) {
        $contato = mysql_fetch_assoc($resultadoEditar);
    }
}
