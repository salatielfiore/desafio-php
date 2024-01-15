function atualizarPaginaComItensPorPagina() {
    const itensPorPagina = document.getElementById("itensPorPagina").value;
    const termoPesquisaElement = document.querySelector("input[name='pesquisa']");
    const dataInicioElement = document.querySelector("input[name='dataInicio']");
    const dataFimElement = document.querySelector("input[name='dataFim']");
    const termoPesquisa = termoPesquisaElement ? termoPesquisaElement.value.trim() : '';
    const dataInicio = termoPesquisaElement ? dataInicioElement.value.trim() : '';
    const dataFim = termoPesquisaElement ? dataFimElement.value.trim() : '';

    let href = `?pagina=1&itensPorPagina=${itensPorPagina}`;

    if (termoPesquisa !== '') {
        // Se o termo de pesquisa não estiver vazio, atualiza a página com o termo de pesquisa
        href += `&pesquisa=${termoPesquisa}`;
    }
    if (dataInicio !== '') {
        href += `&dataInicio=${dataInicio}`
    }

    if (dataFim !== '') {
        href += `&dataFim=${dataFim}`
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