<?php
include_once(__DIR__ . '/../../util/validateUtil.php');
include_once('validar_form_contato.php');
function processarFormularioContato($nome, $telefone, $email)
{
    $telefone = removeMaskPhone($telefone);
    // Validação dos dados
    if (empty($nome) || empty($telefone) || empty($email)) {
        $response = mensagemResponse(400, false, 'Preencha todos os campos!');
        echo json_encode($response);
        exit();
    }

    if (strlen($telefone) < 11 || !ctype_digit($telefone)) {
        $response = mensagemResponse(400, false, 'O número de telefone é inválido!');
        echo json_encode($response);
        exit();
    }

    if (!isEmailValido($email)) {
        $response = mensagemResponse(400, false, 'O email não é válido!');
        echo json_encode($response);
        exit();
    }
}