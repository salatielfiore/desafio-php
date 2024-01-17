<?php
include(__DIR__ . '/../../inc/conecta.php');
include_once(__DIR__ . '/../../util/StringUtil.php');
include_once('response.php');

// Configurações de paginação
$resultados_por_pagina = isset($_POST['itensPorPagina']) ? (int)$_POST['itensPorPagina'] : 5;
$pagina_atual = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;

$pesquisa = $_POST['pesquisa'];
$dataInicio = $_POST['dataInicio'];
$dataFim = $_POST['dataFim'];
$ordem = isset($_POST['ordem']) ? $_POST['ordem'] : 'id';
$direcao = isset($_POST['direcao']) ? $_POST['direcao'] : 'asc';

// Calcula o offset (deslocamento) para a consulta SQL
$offset = ($pagina_atual - 1) * $resultados_por_pagina;

// Consulta para recuperar os contatos paginados
$sql = "SELECT * FROM `contatos` WHERE 1 = 1";

if (!empty($dataInicio)) {
    $sql .= queryPequisaPorFiltroDataInicio($dataInicio);
}
if (!empty($dataFim)) {
    $sql .= queryPequisaPorFiltroDataFim($dataFim);
}
if (!empty($pesquisa)) {
    $sql .= queryPequisaPorFiltroPesquisa($pesquisa);
}

$sql .= ordenacao($ordem, $direcao);
//// Adiciona a limitação de resultados por página
$sql .= " LIMIT $offset, $resultados_por_pagina";
$queryContatos = mysql_query($sql);
$contatos = array();
if ($queryContatos) {
    // Fetch todos os resultados
    while ($row = mysql_fetch_assoc($queryContatos)) {
        $contatos[] = $row;
    }
} else {
    die('Erro na consulta SQL: ' . mysql_error() . " " . $sql);
}

// Consulta para contar o número total de contatos
$sqlContagem = "SELECT COUNT(*) AS total FROM `contatos` WHERE 1 = 1";
if (!empty($dataInicio)) {
    $sqlContagem .= queryPequisaPorFiltroDataInicio($dataInicio);
}
if (!empty($dataFim)) {
    $sqlContagem .= queryPequisaPorFiltroDataFim($dataFim);
}

if (!empty($pesquisa)) {
    $sqlContagem .= queryPequisaPorFiltroPesquisa($pesquisa);
}

$sqlContagem .= ordenacao($ordem, $direcao);
$queryContagem = mysql_query($sqlContagem);
$contagem = mysql_fetch_assoc($queryContagem);
$total_resultados = $contagem['total'];

// Crie a resposta em formato JSON
$response = mensagemResponseData(200, true, null, $contatos, $total_resultados);
echo json_encode($response);
exit();

function queryPequisaPorFiltroPesquisa($pesquisa)
{
    $termo_pesquisa = limparScapeString(trim($pesquisa));
    return " AND `nome` LIKE '%$termo_pesquisa%' OR `telefone` LIKE '%$termo_pesquisa%' OR `email` LIKE '%$termo_pesquisa%'";
}

function queryPequisaPorFiltroDataInicio($dataInicio)
{
    $termoDataInicio = formatarDataPadraoAmericano(limparScapeString(trim($dataInicio)));
    return " AND data_criacao >= '$termoDataInicio'";
}

function queryPequisaPorFiltroDataFim($dataFim)
{
    $termoDataFim = formatarDataPadraoAmericano(limparScapeString(trim($dataFim)));
    return " AND data_criacao <= '$termoDataFim'";
}

function ordenacao($ordem, $direcao)
{
    $termoOrdem = limparScapeString(trim($ordem));
    $termoDirecao = limparScapeString(trim($direcao));
    return " ORDER BY $termoOrdem $termoDirecao";
}