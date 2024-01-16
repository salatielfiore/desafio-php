<?php
include(__DIR__ . '/../../inc/conecta.php');
include_once(__DIR__ . '/../../util/StringUtil.php');
include_once('buscar_contato.php');

// Verifica se o parâmetro 'id' está presente na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idContato = limparScapeString($_GET['id']);
    $contato = buscarContatoPorId($idContato);
    $logo = $contato['logo'];
    $urlLogo = !empty($logo) ? '../img/' . $logo : '../img/avatar.png';
}
