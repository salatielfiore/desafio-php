$(document).ready(function () {
    $('#fileInputExcel').on('change', manipuladorDeArquivo);

    $('th a').on('click', adicionarSetasOrdenacao);

    $('button[type="submit"]').click(function () {
        const botaoClicado = $(this).attr('name');
        $('#filtroForm').data('botaoClicado', botaoClicado);
    });

    $('#itensPorPaginaSelect').change(atualizarPaginaComItensPorPagina);

    $('#modalAlertaExcluir').on('show.bs.modal', modalAlertaExcluir);

    // Adicione um evento de clique para o botão de confirmação de exclusão dentro do modal
    $('#btnConfirmarExclusao').on('click', excluirContato);

    $('#filtroForm').submit(function (event) {
        event.preventDefault();
        filtrarContatos();
    });

    // Adicione um evento de clique para os botões de paginação
    $('#pagination-container').on('click', 'a', function (event) {
        event.preventDefault();
        const newPage = $(this).data('page');
        $('#paginaAtual').val(newPage);
        // Atualize a página com o novo número
        listarContatos(false);
    });

    listarContatos(false);
});

function modalAlertaExcluir(event) {
    const button = $(event.relatedTarget);
    const contatoId = button.data('contato-id');
    // Adicione o contatoId ao botão de confirmação como atributo de dados
    $('#btnConfirmarExclusao').data('contato-id', contatoId);
    const modal = $(this);
    modal.find('.modal-body p').text(`Tem certeza que deseja excluir esse contato?`);
}

function excluirContato() {
    const contatoId = $(this).data('contato-id');
    const formData = new FormData();
    formData.append("id", contatoId);
    $.ajax({
        url: '../web/contato/scripts/excluir_contato.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            const res = JSON.parse(response);
            if (res.status === 200) {
                exibirToast(res.message, "success")
                listarContatos(false);
            } else {
                exibirToast(res.message, "danger")
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
    $('#modalAlertaExcluir').modal('hide');
}

function filtrarContatos() {
    $('#paginaAtual').val("1");
    listarContatos(true);
}


function listarContatos(isvalidarCampo) {
    let ordem = $('#ordem').val();
    let direcao = $('#direcao').val();
    let itensPorPagina = $('input[name="itensPorPagina"]').val();
    const paginaAtual = $('#paginaAtual').val();
    let pesquisa = $('#pesquisa').val();
    let dataInicio = $('#dataInicio').val();
    let dataFim = $('#dataFim').val();
    if (validacaoDados(pesquisa, dataInicio, dataFim, isvalidarCampo)) {
        const botaoClicado = $('#filtroForm').data('botaoClicado');
        if (botaoClicado === "limpar") {
            pesquisa = '';
            dataInicio = '';
            dataFim = '';
            $('#pesquisa').val('')
            $('#dataInicio').val('')
            $('#dataFim').val('');
        }

        const formData = new FormData();
        formData.append("ordem", ordem);
        formData.append("direcao", direcao);
        formData.append("itensPorPagina", itensPorPagina);
        formData.append("pesquisa", pesquisa);
        formData.append("dataInicio", dataInicio);
        formData.append("dataFim", dataFim);
        formData.append("pagina", paginaAtual);
        $.ajax({
            url: '../web/contato/scripts/listar_contato_filtro.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                const res = JSON.parse(response);
                if (res.status === 200) {
                    const contatos = res.data;
                    const totalResultado = res.totalResultado;
                    let paginaAtual = res.paginaAtual;

                    const resultadosPorPagina = $('input[name="itensPorPagina"]').val();
                    const totalPaginas = Math.ceil(totalResultado / resultadosPorPagina);
                    if (totalPaginas !== 0 && paginaAtual > totalPaginas) {
                        paginaAtual = paginaAtual - 1;
                        $("#paginaAtual").val(paginaAtual);
                        listarContatos(false);
                    }
                    atualizarTabela(contatos)
                    atualizarPaginacao(totalResultado, paginaAtual, totalPaginas);
                } else {
                    const mensagem = res.message;
                    // Atualizando o conteúdo do modal com a mensagem
                    $('#modalAlerta .modal-body p').text(mensagem);
                    // Abrindo o modal de alerta do Bootstrap
                    $('#modalAlerta').modal('show');
                }
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
}

function validacaoDados(pesquisa, dataInicio, dataFim, isvalidarCampo) {
    if (!isvalidarCampo) {
        return true;
    }
    return !(pesquisa === '' && dataInicio === '' && dataFim === '');
}

function atualizarTabela(contatos) {
    const tabela = $('.table tbody');
    tabela.empty(); // Limpa o conteúdo atual da tabela

    contatos.forEach(function (contato) {
        const linha = $('<tr>');
        linha.append($('<td>').text(contato.id));
        linha.append($('<td >').text(contato.nome));
        linha.append($('<td >').text(adicionarMascaraTelefone(contato.telefone)));
        linha.append($('<td>').text(contato.email));
        linha.append($('<td>').text(formatarData(contato.data_criacao)));
        linha.append($('<td>').html(`
            <a href="contato/views/tela_editar_contato.php?id=${contato.id}" class="btn btn-warning btn-sm">Editar</a>
            <button type="button" class="btn btn-danger btn-sm btn-excluir" data-toggle="modal" data-target="#modalAlertaExcluir" data-contato-id="${contato.id}">
                Excluir
            </button>
        `));
        tabela.append(linha);
    });
}

function formatarData(dataString) {
    return moment(dataString).format('DD-MM-YYYY');
}

function adicionarMascaraTelefone(telefone) {
    if (!telefone) return ""
    telefone = telefone.replace(/\D/g, '')
    telefone = telefone.replace(/(\d{2})(\d)/, "($1) $2")
    telefone = telefone.replace(/(\d)(\d{4})$/, "$1-$2")
    return telefone
}


function manipuladorDeArquivo() {
    const arquivo = $(this)[0].files[0];

    if (arquivo !== null) {
        const formData = new FormData();
        formData.append('arquivo_excel', arquivo);

        $.ajax({
            url: '../web/contato/scripts/salvar_contato_excel.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                const res = JSON.parse(response);
                if (res.status === 200) {
                    window.location.href = 'index.php';
                } else {
                    console.error(res.message);
                }
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
}

function adicionarSetasOrdenacao(event) {
    event.preventDefault();

    // Alterar os valores dos inputs de ordem e direção
    const ordemAtual = $('#ordem').val();
    const novaOrdem = $(this).data('ordem');
    let novaDirecao;
    if (ordemAtual !== novaOrdem) {
        novaDirecao = 'desc'
    } else {
        novaDirecao = (ordemAtual === novaOrdem && $('#direcao').val() === 'asc') ? 'desc' : 'asc';
    }

    $('#ordem').val(novaOrdem);
    $('#direcao').val(novaDirecao);

    // Remover a classe 'seta-desc' e adicionar a classe 'seta-asc' para todas as tags 'a'
    $('th a').removeClass('seta-desc').addClass('seta-asc');

    // Adicionar a classe apropriada à tag 'a' clicada
    $(this).removeClass('seta-desc seta-asc').addClass(novaDirecao === 'desc' ? 'seta-desc' : 'seta-asc');

    // Executar a função de filtro
    listarContatos(false);
}


function atualizarPaginaComItensPorPagina() {
    const itensPorPagina = $('#itensPorPaginaSelect').val();
    $('input[name="itensPorPagina"]').val(itensPorPagina);
    $('#paginaAtual').val("1");
    listarContatos(false);
}

function atualizarPaginacao(totalResultado, paginaAtual, totalPaginas) {

    // Lógica para criar os botões da paginação
    const numLinks = 5;
    const meio = Math.ceil(numLinks / 2);
    const inicio = Math.max(1, Math.min(paginaAtual - meio, totalPaginas - numLinks + 1));

    const paginationContainer = $('#pagination-container');
    paginationContainer.empty(); // Limpa a paginação atual

    // Adiciona seta para a esquerda
    if (paginaAtual > 1) {
        paginationContainer.append(`<li class='page-item'><a class='page-link' style="cursor: pointer" data-page='${paginaAtual - 1}'>&laquo;</a></li>`);
    }

    // Exibe os links de paginação
    for (let i = inicio; i < inicio + numLinks && i <= totalPaginas; i++) {
        paginationContainer.append(`<li class='page-item ${paginaAtual === i ? 'active' : ''}'><a class='page-link' style="cursor: pointer" data-page='${i}'>${i}</a></li>`);
    }

    // Adiciona seta para a direita
    if (paginaAtual < totalPaginas) {
        paginationContainer.append(`<li class='page-item'><a class='page-link' style="cursor: pointer" data-page='${paginaAtual + 1}'>&raquo;</a></li>`);
    }
}

function exibirToast(mensagem, tipo) {
    // 'tipo' pode ser 'success', 'danger', 'warning', etc.
    // Modificar o conteúdo do toast
    $('#customToast .toast-body').text(mensagem);
    // Modificar a classe de cor do toast de acordo com o tipo
    $('#customToast').removeClass().addClass(`toast bg-${tipo}`);
    // Exibir o toast
    $('#customToast').toast('show');
}