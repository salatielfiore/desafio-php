<?php
function removeMaskPhone($telefone)
{
    return preg_replace('/[^0-9]/', '', $telefone);
}

function limparScapeString($str)
{
    return mysql_real_escape_string($str);
}

function formatarDataPadraoAmericano($data)
{
    return formatarData($data, 'd-m-Y', 'Y-m-d', 'UTC');
}

function formatarDataPadraoBR($data)
{
    return formatarData($data, 'Y-m-d', 'd-m-Y', 'UTC');
}

function formatarData($data, $dataFormatoTipo, $dataFormatoFinal, $timeZoneId)
{
    date_default_timezone_set($timeZoneId);
    $dataObjeto = DateTime::createFromFormat($dataFormatoTipo, $data);
    return $dataObjeto->format($dataFormatoFinal);
}