<?php
function removeMaskPhone($telefone){
    return preg_replace('/[^0-9]/', '', $telefone);
}

function limparScapeString($str){
    return mysql_real_escape_string($str);
}