$(document).ready(function () {
    $('#fileInputExcel').on('change', manipuladorDeArquivo);
    $('th a').each(adicionarSetasOrdenacao);
});

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
                if (response.status !== 200) {
                    // Extraindo a mensagem do response
                    console.log(response);
                    const res = JSON.parse(response);
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

function adicionarSetasOrdenacao() {
    if ($(this).attr('href')) {
        const direcao = $(this).attr('href').split('&direcao=')[1];

        if (direcao.includes('asc')) {
            $(this).append(' &#9650;');
        } else {
            $(this).append(' &#9660;');
        }
    }
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

function previewImage(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    }
}