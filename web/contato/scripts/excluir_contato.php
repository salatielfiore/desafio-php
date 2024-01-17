<?php
include(__DIR__ . '/../../inc/conecta.php');
include(__DIR__ . '/../../util/StringUtil.php');
include_once('response.php');

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    try {
        $idContato = limparScapeString($_POST['id']);
        $sqlExcluir = "DELETE FROM `contatos` WHERE id = $idContato";
        mysql_query($sqlExcluir);
        $response = mensagemResponse(200, true, "Contato Excluido com Sucesso!");
        echo json_encode($response);
        exit();
    } catch (Exception $e) {
        $response = mensagemResponse(500, false, "Erro ao tentar Excluir o Contato!");
        echo json_encode($response);
        exit();
    }
}

