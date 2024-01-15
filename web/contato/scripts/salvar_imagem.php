<?php
/**
 * @param $imagem
 * @param $idContato
 * @return string
 */
function salvarImagem($imagem, $idContato)
{
    $imagemNome = $imagem['name'];
    // Obtém as informações do caminho do arquivo
    $info = pathinfo($imagemNome);
    // Obtém a extensão do arquivo
    $extensao = strtolower($info['extension']);
    $novoNomeImagem = "$idContato.$extensao";
    // Fazer o upload da imagem para um diretório no servidor
    $diretorioDestino = dirname(__DIR__) . '/img/';
    $caminhoImagem = $diretorioDestino . $novoNomeImagem;
    move_uploaded_file($imagem['tmp_name'], $caminhoImagem);
    return $novoNomeImagem;
}