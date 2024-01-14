<?php
include(__DIR__ . '/../../inc/conecta.php');
include_once(__DIR__ . '/../../util/StringUtil.php');
include_once('response.php');
include_once('validar_form_contato.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar o formulário quando enviado
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    // Validação dos dados
    validarDadosContato(null, $nome, $telefone, $email);

    // Inserir dados no banco de dados
    $sqlInserir = "INSERT INTO `contatos` (nome, telefone, email) VALUES ('$nome', '$telefone', '$email')";
    $resultado = mysql_query($sqlInserir);

    if ($resultado) {
        // Redirecionar para a página de listagem após a inserção
        $response = mensagemResponse(200, true, 'Contato inserido com sucesso');
    } else {
        $response = mensagemResponse(500, true, 'Erro ao inserir o contato');
    }
    echo json_encode($response);
    exit();
}