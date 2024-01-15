<?php
include(__DIR__ . '/../../inc/conecta.php');
include_once(__DIR__ . '/../../util/StringUtil.php');

// Configurações de paginação
$resultados_por_pagina = isset($_GET['itensPorPagina']) ? (int)$_GET['itensPorPagina'] : 10; // Valor padrão: 10
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

if ($_GET['submit'] === 'limpar') {
    $_GET['pesquisa'] = '';
    $_GET['dataInicio'] = '';
    $_GET['dataFim'] = '';
}

$pesquisa = $_GET['pesquisa'];
$dataInicio = $_GET['dataInicio'];
$dataFim = $_GET['dataFim'];

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

// Adiciona a limitação de resultados por página
$sql .= " LIMIT $offset, $resultados_por_pagina";

$queryContatos = mysql_query($sql);

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

$queryContagem = mysql_query($sqlContagem);
$contagem = mysql_fetch_assoc($queryContagem);
$total_resultados = $contagem['total'];

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