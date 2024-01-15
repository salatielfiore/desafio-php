$(document).ready(function () {
    // Adiciona setas de ordenação nas colunas apropriadas
    $('th a').each(function () {
        if ($(this).attr('href')) {
            const direcao = $(this).attr('href').split('&direcao=')[1];
            console.log(direcao)
            if (direcao.includes('asc')) {
                $(this).append(' &#9650;'); // Seta para cima
            } else {
                $(this).append(' &#9660;'); // Seta para baixo
            }
        }
    });
});

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