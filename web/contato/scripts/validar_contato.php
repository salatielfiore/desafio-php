<?php
include_once(__DIR__ . '/../../util/validateUtil.php');
include_once('validar_contato.php');
include_once('buscar_contato.php');
function validarDadosContato($id, $nome, $telefone, $email)
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

    if (!validarTelefone($id, $telefone)) {
        $response = mensagemResponse(400, false, 'Já existe esse telefone cadastrado.');
        echo json_encode($response);
        exit();
    }

    if (!validarEmail($id, $email)) {
        $response = mensagemResponse(400, false, 'Já existe esse email cadastrado.');
        echo json_encode($response);
        exit();
    }

}

function validarEmail($id, $email)
{
    $contato = buscarIdContatoPorEmail($email);
    return retornoValidacaoDadosDuplicados($contato, $id);
}

function validarTelefone($id, $telefone)
{
    $contato = buscarIdContatoPorTelefone($telefone);
    return retornoValidacaoDadosDuplicados($contato, $id);
}

function retornoValidacaoDadosDuplicados($contato, $id)
{
    if (!empty($contato)) {
        if (empty($id)) {
            return false;
        }
        if ($contato['id'] !== $id) {
            return false;
        }
    }
    return true;
}