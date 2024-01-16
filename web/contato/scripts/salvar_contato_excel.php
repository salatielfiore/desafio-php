<?php
include(__DIR__ . '/../../inc/conecta.php');
include_once(__DIR__ . '/../../util/StringUtil.php');
include_once('response.php');
include_once('validar_contato.php');
include_once('buscar_contato.php');
include_once(__DIR__ . '/../../Classes/PHPExcel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['arquivo_excel'])) {
    $arquivoTmp = $_FILES['arquivo_excel']['tmp_name'];

    try {
        $objPHPExcel = PHPExcel_IOFactory::load($arquivoTmp);
        $sheet = $objPHPExcel->getActiveSheet();

        // Itera sobre as linhas do Excel a partir da segunda linha (índice 2)
        for ($row = 2; $row <= $sheet->getHighestRow(); $row++) {
            $nome = $sheet->getCellByColumnAndRow(0, $row)->getValue(); // Coluna 'Nome'
            $telefone = $sheet->getCellByColumnAndRow(1, $row)->getValue(); // Coluna 'Telefone'
            $email = $sheet->getCellByColumnAndRow(2, $row)->getValue(); // Coluna 'Email'

            validarDadosContato(null, $nome, $telefone, $email);

            // Insere os dados no banco de dados (assumindo que você tem uma tabela chamada 'contato')
            $sqlInserir = "INSERT INTO `contatos` (nome, telefone, email, data_criacao) VALUES ('$nome', '$telefone', '$email', CURDATE())";
            $resultado = mysql_query($sqlInserir);
        }
    } catch (Exception $e) {
        $response = mensagemResponse(500, false, 'Erro ao processar o arquivo!');
        echo json_encode($response);
        exit();
    }
}