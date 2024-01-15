<?php
global $queryContatos, $resultados_por_pagina, $total_resultados, $pagina_atual;
include('contato/scripts/excluir_contato.php');
include('contato/scripts/listar_contato.php');
include_once(__DIR__ . '/util/StringUtil.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <title>A.R. Phoenix</title>
    <style>
        body {
            padding: 20px;
        }

        .link-ordenacao {
            color: inherit;
            text-decoration: none;
        }

        .link-ordenacao:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">
    <h1 class="mt-3">Contatos</h1>

    <!-- Botão para adicionar novo contato -->
    <a href="contato/views/tela_adicionar_contato.php" class="btn btn-primary mb-3">Novo Contato</a>

    <!-- Campo de pesquisa -->
    <form action="" method="GET">
        <div class="input-group mb-3">
            <input type="hidden" id="ordem" name="ordem"
                   value="<?php echo isset($_GET['ordem']) ? $_GET['ordem'] : 'id'; ?>">
            <input type="hidden" id="direcao" name="direcao"
                   value="<?php echo isset($_GET['direcao']) ? $_GET['direcao'] : 'desc'; ?>">
            <label>
                <input hidden name="itensPorPagina" value="<?php echo $resultados_por_pagina; ?> ">
            </label>
            <!-- Campo de pesquisa -->
            <input type="text" class="form-control mb-2" name="pesquisa" placeholder="Pesquisar contatos"
                   aria-label="Pesquisar contatos" aria-describedby="button-pesquisar"
                   value="<?php echo isset($_GET['pesquisa']) ? $_GET['pesquisa'] : ''; ?>">

            <!-- Agrupamento dos campos de data -->
            <div class="input-group mb-2">
                <!-- Campo de data inicial -->
                <input type="text" class="form-control datepicker" name="dataInicio" placeholder="Data Inicial"
                       aria-label="Data Inicial" aria-describedby="basic-addon1"
                       value="<?php echo isset($_GET['dataInicio']) ? $_GET['dataInicio'] : ''; ?>">

                <!-- Campo de data final -->
                <input type="text" class="form-control datepicker ml-2" name="dataFim" placeholder="Data Final"
                       aria-label="Data Final" aria-describedby="basic-addon2"
                       value="<?php echo isset($_GET['dataFim']) ? $_GET['dataFim'] : ''; ?>">
            </div>
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="submit" id="button-pesquisar">Pesquisar</button>
            </div>
            <div class="input-group-append ml-2">
                <button class="btn btn-outline-danger" type="submit" name="submit" value="limpar">Limpar</button>
            </div>
        </div>
    </form>

    <table class="table mt-4">
        <thead>
        <tr>
            <th scope="col"><a class="link-ordenacao" href="
            ?ordem=id&direcao=<?php echo inverterDirecao('id')
                    . '&pesquisa=' . $_GET['pesquisa']
                    . '&dataInicio=' . $_GET['dataInicio']
                    . '&dataFim=' . $_GET['dataFim']
                    . '&itensPorPagina=' . $resultados_por_pagina; ?>">Código</a></th>
            <th scope="col"><a class="link-ordenacao" href="
            ?ordem=nome&direcao=<?php echo inverterDirecao('nome')
                    . '&pesquisa=' . $_GET['pesquisa']
                    . '&dataInicio=' . $_GET['dataInicio']
                    . '&dataFim=' . $_GET['dataFim']
                    . '&itensPorPagina=' . $resultados_por_pagina; ?>">Nome</a>
            </th>
            <th scope="col"><a class="link-ordenacao" href="
            ?ordem=telefone&direcao=<?php echo inverterDirecao('telefone')
                    . '&pesquisa=' . $_GET['pesquisa']
                    . '&dataInicio=' . $_GET['dataInicio']
                    . '&dataFim=' . $_GET['dataFim']
                    . '&itensPorPagina=' . $resultados_por_pagina; ?>">Telefone</a>
            </th>
            <th scope="col"><a class="link-ordenacao" href="
            ?ordem=email&direcao=<?php echo inverterDirecao('email')
                    . '&pesquisa=' . $_GET['pesquisa']
                    . '&dataInicio=' . $_GET['dataInicio']
                    . '&dataFim=' . $_GET['dataFim']
                    . '&itensPorPagina=' . $resultados_por_pagina; ?>">Email</a></th>
            <th scope="col"><a class="link-ordenacao" href="
            ?ordem=data_criacao&direcao=<?php echo inverterDirecao('data_criacao')
                    . '&pesquisa=' . $_GET['pesquisa']
                    . '&dataInicio=' . $_GET['dataInicio']
                    . '&dataFim=' . $_GET['dataFim']
                    . '&itensPorPagina=' . $resultados_por_pagina; ?>">Data de
                    Criação</a></th>
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($contato = mysql_fetch_assoc($queryContatos)) { ?>
            <tr>
                <td><?php echo $contato['id']; ?></td>
                <td><?php echo $contato['nome']; ?></td>
                <td class="telefone-mask"><?php echo $contato['telefone']; ?></td>
                <td><?php echo $contato['email']; ?></td>
                <td><?php echo formatarDataPadraoBR($contato['data_criacao']) ?></td>
                <td>
                    <!-- Botões de ação -->
                    <a href="contato/views/tela_editar_contato.php?id=<?php echo $contato['id']; ?>"
                       class="btn btn-warning btn-sm">Editar</a>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#confirmarExclusao_<?php echo $contato['id']; ?>">
                        Excluir
                    </button>
                    <!-- Modal de confirmação de exclusão -->
                    <div class="modal fade" id="confirmarExclusao_<?php echo $contato['id']; ?>" tabindex="-1"
                         role="dialog" aria-labelledby="confirmarExclusaoLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmarExclusaoLabel">Confirmar Exclusão</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Tem certeza que deseja excluir este contato?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
                                    </button>
                                    <!-- Link para excluir o contato -->
                                    <a href="index.php?excluir=<?php echo $contato['id']; ?>" class="btn btn-danger">Excluir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
    // Verifica se não há nenhum contato encontrado
    if (mysql_num_rows($queryContatos) == 0) { ?>
        <h3 class="text-center">Nenhum contato encontrado</h3>
    <?php } else { ?>
        <div class="pagination mt-4">
            <div class="ml-3">
                <label for="itensPorPagina"></label><select class="custom-select" id="itensPorPagina"
                                                            name="itensPorPagina"
                                                            onchange="atualizarPaginaComItensPorPagina()">
                    <option value="5" <?php echo ($resultados_por_pagina == 5) ? 'selected' : ''; ?>>5</option>
                    <option value="10" <?php echo ($resultados_por_pagina == 10) ? 'selected' : ''; ?>>10</option>
                    <option value="15" <?php echo ($resultados_por_pagina == 15) ? 'selected' : ''; ?>>15</option>
                    <option value="20" <?php echo ($resultados_por_pagina == 20) ? 'selected' : ''; ?>>20</option>
                    <option value="25" <?php echo ($resultados_por_pagina == 25) ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo ($resultados_por_pagina == 50) ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo ($resultados_por_pagina == 100) ? 'selected' : ''; ?>>100</option>
                </select>
            </div>
            <div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <?php
                        // Calcula o número total de páginas
                        $total_paginas = ceil($total_resultados / $resultados_por_pagina);

                        // Limita a quantidade de botões por página
                        $num_links = 5; // Número desejado de botões
                        $meio = ceil($num_links / 2);
                        $inicio = max(1, min($pagina_atual - $meio, $total_paginas - $num_links + 1));

                        // Adiciona seta para a esquerda
                        if ($pagina_atual > 1) {
                            echo "<li class='page-item'><a class='page-link' href='?pagina=" . ($pagina_atual - 1) .
                                "&itensPorPagina=$resultados_por_pagina&pesquisa=" . urlencode($_GET['pesquisa']) .
                                "&dataInicio=" . urlencode($_GET['dataInicio']) .
                                "&dataFim=" . urlencode($_GET['dataFim']) .
                                "&ordem=" . urlencode($_GET['ordem']) .
                                "&direcao=" . urlencode($_GET['direcao']) . "'>&laquo;</a></li>";
                        }

                        // Exibe os links de paginação
                        for ($i = $inicio; $i < $inicio + $num_links && $i <= $total_paginas; $i++) {
                            echo "<li class='page-item " . ($pagina_atual == $i ? 'active' : '') . "'><a class='page-link' 
                            href='?pagina=$i&itensPorPagina=$resultados_por_pagina&pesquisa=" . urlencode($_GET['pesquisa']) .
                                "&dataInicio=" . urlencode($_GET['dataInicio']) .
                                "&dataFim=" . urlencode($_GET['dataFim']) .
                                "&ordem=" . urlencode($_GET['ordem']) .
                                "&direcao=" . urlencode($_GET['direcao']) . "'>$i</a></li>";
                        }

                        // Adiciona seta para a direita
                        if ($pagina_atual < $total_paginas) {
                            echo "<li class='page-item'><a class='page-link' href='?pagina=" . ($pagina_atual + 1) .
                                "&itensPorPagina=$resultados_por_pagina&pesquisa=" . urlencode($_GET['pesquisa']) .
                                "&dataInicio=" . urlencode($_GET['dataInicio']) .
                                "&dataFim=" . urlencode($_GET['dataFim']) .
                                "&ordem=" . urlencode($_GET['ordem']) .
                                "&direcao=" . urlencode($_GET['direcao']) . "'>&raquo;</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    <?php } ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="js/script.js"></script>
<script src="js/util/validateUtil.js"></script>
<script>
    $(document).ready(function () {
        $('.datepicker').datepicker({
            language: 'pt-BR',
            format: 'dd-mm-yyyy', // formato de data desejado
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
</body>
</html>