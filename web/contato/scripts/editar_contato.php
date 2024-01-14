<?php
include(__DIR__ . '/../../inc/conecta.php');
include_once(__DIR__ . '/../../util/StringUtil.php');
include_once('response.php');
include_once('validar_form_contato.php');


// Verifica se o parâmetro 'id' está presente na URL
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $idContato = limparScapeString($_POST['id']);
    // Processar o formulário quando enviado
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    // Validação dos dados
    validarDadosContato($idContato, $nome, $telefone, $email);

    // Atualizar dados no banco de dados
    $sqlAtualizar = "UPDATE `contatos` SET nome='$nome', telefone='$telefone', email='$email' WHERE id=$idContato";
    $resultadoAtualizar = mysql_query($sqlAtualizar);

    if ($resultadoAtualizar) {
        // Responder com sucesso
        $response = mensagemResponse(200, true, 'Contato atualizado com sucesso');
    } else {
        // Responder com erro
        $response = mensagemResponse(500, false, 'Erro ao atualizar o contato');
    }
} else {
    // Responder com erro se o parâmetro 'id' não estiver presente na URL
    $response = mensagemResponse(400, false, 'ID do contato não especificado');
}
echo json_encode($response);
