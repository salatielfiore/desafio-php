<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="css/index.css">
    <title>A.R. Phoenix</title>
</head>

<body>

<div class="container">
    <h1 class="mt-3">Contatos</h1>

    <!-- Botão para adicionar novo contato -->
    <a href="contato/views/tela_adicionar_contato.php" class="btn btn-primary mb-3">Novo Contato</a>

    <!-- Campo de pesquisa -->
    <form action="" method="POST" id="filtroForm">
        <input type="hidden" id="ordem" name="ordem" value="id">
        <input type="hidden" id="direcao" name="direcao" value="asc">
        <input type="hidden" id="paginaAtual" name="paginaAtual" value="1">
        <input type="hidden" name="itensPorPagina" value="5">
        <div class="input-group mb-3">
            <!-- Campo de pesquisa -->
            <input type="text" class="form-control mb-2" name="pesquisa" id="pesquisa" placeholder="Pesquisar contatos"
                   aria-label="Pesquisar contatos" aria-describedby="button-pesquisar">

            <!-- Agrupamento dos campos de data -->
            <div class="input-group mb-2">
                <!-- Campo de data inicial -->
                <input type="text" class="form-control datepicker" name="dataInicio" id="dataInicio"
                       placeholder="Data Inicial"
                       aria-label="Data Inicial" aria-describedby="basic-addon1">

                <!-- Campo de data final -->
                <input type="text" class="form-control datepicker ml-2" name="dataFim" id="dataFim"
                       placeholder="Data Final"
                       aria-label="Data Final" aria-describedby="basic-addon2">
            </div>
            <div class="input-group ml-auto"> <!-- Adicionado a classe "ml-auto" para empurrar para a direita -->
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit" id="button-pesquisar" name="pesquisar"
                            value="pesquisar">
                        Pesquisar
                    </button>
                </div>
                <div class="input-group-append ml-2">
                    <button class="btn btn-outline-danger" type="submit" name="limpar" value="limpar">Limpar</button>
                </div>
                <div class="input-group-append ml-auto">
                    <label class="btn btn-outline-success" id="labelEnvioExcel" style="cursor: pointer">
                        Importar
                        <input type="file" name="arquivo_excel" style="display: none;" id="fileInputExcel"
                               accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    </label>
                </div>
            </div>
        </div>
    </form>

    <table class="table mt-4">
        <thead>
        <tr>
            <th class="seta" scope="col"><a class="link-ordenacao seta-asc" data-ordem="id" style="cursor: pointer">Código</a>
            </th>
            <th class="seta" scope="col"><a class="link-ordenacao seta-asc" data-ordem="nome" style="cursor: pointer">Nome</a>
            </th>
            <th class="seta" scope="col"><a class="link-ordenacao seta-asc" data-ordem="telefone"
                                            style="cursor: pointer">Telefone</a>
            </th>
            <th class="seta" scope="col"><a class="link-ordenacao seta-asc" data-ordem="email" style="cursor: pointer">Email</a>
            </th>
            <th class="seta" scope="col"><a class="link-ordenacao seta-asc" data-ordem="data_criacao"
                                            style="cursor: pointer">Data
                    de
                    Criação</a></th>
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="pagination mt-4">
        <div class="ml-3">
            <label for="itensPorPaginaSelect"></label><select class="custom-select" id="itensPorPaginaSelect"
                                                        name="itensPorPaginaSelect">
                <option value="5" selected>5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end" id="pagination-container">

                </ul>
            </nav>
        </div>
    </div>
    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="modalAlertaExcluir" tabindex="-1" role="dialog"
         aria-labelledby="modalAlertaExcluirLabel">
        <div class="modal-dialog modal-alerta" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalAlertaExcluirLabel">Confirmação de Exclusão</h4>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir o contato?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarExclusao">Confirmar Exclusão</button>
                </div>
            </div>
        </div>
    </div>
    <div class="toast" id="customToast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="position: absolute; top: 0; right: 0;">
        <div class="toast-header">
            <strong class="mr-auto">Mensagem</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="js/script.js"></script>
<script src="js/index.js"></script>
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