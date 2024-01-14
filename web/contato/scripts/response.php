<?php
function mensagemResponse($status, $success, $mensagem)
{
    return array(
        "status" => $status,
        "success" => $success,
        "message" => $mensagem
    );
}
