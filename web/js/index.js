$(document).ready(function () {
    $('#fileInputExcel').on('change', manipuladorDeArquivo);
    $('th a').on('click', adicionarSetasOrdenacao);
    $('button[type="submit"]').click(function () {
        const botaoClicado = $(this).attr('name');
        $('#filtroForm').data('botaoClicado', botaoClicado);
    });

    $('#modalAlertaExcluir').on('show.bs.modal', modalAlertaExcluir);

    // Adicione um evento de clique para o botão de confirmação de exclusão dentro do modal
    $('#btnConfirmarExclusao').on('click', excluirContato);

    $('#filtroForm').submit(function (event) {
        event.preventDefault();
        filtroContatos(true);
    });

    filtroContatos(false);
});

function modalAlertaExcluir(event) {
    const button = $(event.relatedTarget);
    const contatoId = button.data('contato-id');
    // Adicione o contatoId ao botão de confirmação como atributo de dados
    $('#btnConfirmarExclusao').data('contato-id', contatoId);
    const modal = $(this);
    modal.find('.modal-body p').text(`Tem certeza que deseja excluir o contato com ID ${contatoId}?`);
}

function excluirContato() {
    const contatoId = $(this).data('contato-id');
    console.log(contatoId);
    // $('#modalAlertaExcluir').modal('hide');
}


function filtroContatos(isvalidarCampo) {
    let ordem = $('#ordem').val();
    let direcao = $('#direcao').val();
    let itensPorPagina = $('input[name="itensPorPagina"]').val();
    itensPorPagina = itensPorPagina != null ? itensPorPagina : 10;
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
                    atualizarTabela(contatos);
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
        linha.append($('<td>').text(contato.nome));
        linha.append($('<td>').text(contato.telefone));
        linha.append($('<td>').text(contato.email));
        linha.append($('<td>').text(contato.data_criacao));
        linha.append($('<td>').html(`
            <a href="contato/views/tela_editar_contato.php?id=${contato.id}" class="btn btn-warning btn-sm">Editar</a>
            <button type="button" class="btn btn-danger btn-sm btn-excluir" data-toggle="modal" data-target="#modalAlertaExcluir" data-contato-id="${contato.id}">
                Excluir
            </button>
        `));
        tabela.append(linha);
    });
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

    // Remover a classe 'seta-desc' e 'seta-asc' de todas as tags 'a'
    $('th a').removeClass('seta-desc').addClass('seta-asc');

    // Adicionar a classe apropriada à tag 'a' clicada
    $(this).removeClass('seta-desc seta-asc').addClass(novaDirecao === 'desc' ? 'seta-desc' : 'seta-asc');

    // Executar a função de filtro
    filtroContatos(false);
}


function atualizarPaginaComItensPorPagina() {
    const itensPorPagina = document.getElementById("itensPorPagina").value;
    const termoPesquisaElement = document.querySelector("input[name='pesquisa']");
    const dataInicioElement = document.querySelector("input[name='dataInicio']");
    const dataFimElement = document.querySelector("input[name='dataFim']");
    const termoPesquisa = termoPesquisaElement ? termoPesquisaElement.value.trim() : '';
    const dataInicio = termoPesquisaElement ? dataInicioElement.value.trim() : '';
    const dataFim = termoPesquisaElement ? dataFimElement.value.trim() : '';
    const ordem = document.getElementById("ordem").value;
    const direcao = document.getElementById("direcao").value;

    let href = `?pagina=1&itensPorPagina=${itensPorPagina}`;

    if (termoPesquisa !== '') {
        href += `&pesquisa=${termoPesquisa}`;
    }
    if (dataInicio !== '') {
        href += `&dataInicio=${dataInicio}`;
    }
    if (dataFim !== '') {
        href += `&dataFim=${dataFim}`;
    }
    if (ordem !== '') {
        href += `&ordem=${ordem}&direcao=${direcao}`;
    } else {
        href += "&ordem=id&direcao=desc";
    }

    window.location.href = href;
}