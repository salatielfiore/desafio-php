<?php
function mensagemResponse($status, $success, $mensagem)
{
    return array(
        "status" => $status,
        "success" => $success,
        "message" => $mensagem
    );
}

function mensagemResponseData($status, $success, $mensagem, $data, $totalResultado)
{
    return array(
        "status" => $status,
        "success" => $success,
        "message" => $mensagem,
        "data" => $data,
        "totalResultado" => $totalResultado
    );
}
