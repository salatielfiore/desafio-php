<?php
include(__DIR__ . '/../../inc/conecta.php');
include_once(__DIR__ . '/../../util/StringUtil.php');
include_once('response.php');
include_once('validar_contato.php');
include_once('buscar_contato.php');
include_once('salvar_imagem.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar o formulário quando enviado
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    // Validação dos dados
    validarDadosContato(null, $nome, $telefone, $email);

    // Processar a imagem
    $imagem = $_FILES['imagem'];

    // Inserir dados no banco de dados
    $sqlInserir = "INSERT INTO `contatos` (nome, telefone, email) VALUES ('$nome', '$telefone', '$email')";
    $resultado = mysql_query($sqlInserir);

    if ($resultado) {
        if (imagemSalva($imagem, $email)) {
            // Redirecionar para a página de listagem após a inserção
            $response = mensagemResponse(200, true, 'Contato inserido com sucesso');
        } else {
            $response = mensagemResponse(500, false, 'Erro ao salvar imagem');
        }
        echo json_encode($response);
        exit();
    } else {
        $response = mensagemResponse(500, false, 'Erro ao inserir o contato');
        echo json_encode($response);
        exit();
    }
}

function imagemSalva($imagem, $email)
{
    if (!empty($imagem)) {
        $contato = buscarIdContatoPorEmail($email);
        $id = $contato['id'];
        $logo = salvarImagem($imagem, $id);

        $sqlAtualizarImagem = "UPDATE `contatos` SET logo= '$logo' where id = $id";
        return mysql_query($sqlAtualizarImagem);
    }
    return true;
}