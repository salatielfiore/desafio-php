<?php
include(__DIR__ . '/../../inc/conecta.php');
include_once(__DIR__ . '/../../util/StringUtil.php');

// Configurações de paginação
$resultados_por_pagina = isset($_GET['itensPorPagina']) ? (int)$_GET['itensPorPagina'] : 10; // Valor padrão: 10
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Calcula o offset (deslocamento) para a consulta SQL
$offset = ($pagina_atual - 1) * $resultados_por_pagina;

// Consulta para recuperar os contatos paginados
$sql = "SELECT * FROM `contatos`";

if ($_GET['submit'] === 'limpar') {
    $_GET['pesquisa'] = '';
}

// Adiciona a condição de pesquisa se um termo de pesquisa estiver presente
if (!empty($_GET['pesquisa'])) {
    $sql .= queryPequisaPorFiltro();
}

// Adiciona a limitação de resultados por página
$sql .= " LIMIT $offset, $resultados_por_pagina";

$queryContatos = mysql_query($sql);

// Consulta para contar o número total de contatos
$sqlContagem = "SELECT COUNT(*) AS total FROM `contatos`";
if (!empty($_GET['pesquisa'])) {
    $sqlContagem .= queryPequisaPorFiltro();
}
$queryContagem = mysql_query($sqlContagem);
$contagem = mysql_fetch_assoc($queryContagem);
$total_resultados = $contagem['total'];

function queryPequisaPorFiltro(){
    $termo_pesquisa = limparScapeString($_GET['pesquisa']);
    return " WHERE `nome` LIKE '%$termo_pesquisa%' OR `telefone` LIKE '%$termo_pesquisa%' OR `email` LIKE '%$termo_pesquisa%'";
}
