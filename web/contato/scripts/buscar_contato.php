<?php
include_once(__DIR__ . '/../../inc/conecta.php');

function buscarContatoPorId($idContato)
{
    $sqlEditar = "SELECT * FROM `contatos` WHERE id = $idContato";
    return resultadoBusca($sqlEditar);
}

function buscarIdContatoPorTelefone($telefone)
{
    $sql = "SELECT id FROM `contatos` WHERE telefone = '$telefone'";
    return resultadoBusca($sql);
}

function buscarIdContatoPorEmail($email)
{
    $sql = "SELECT id FROM `contatos` where email ='$email'";
    return resultadoBusca($sql);
}

function resultadoBusca($sql)
{
    $resultado = mysql_query($sql);
    if ($resultado) {
        if (mysql_num_rows($resultado) == 1) {
            return mysql_fetch_assoc($resultado);
        }
    }
    return null;
}
