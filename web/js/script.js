function atualizarPaginaComItensPorPagina() {
    const itensPorPagina = document.getElementById("itensPorPagina").value;
    const termoPesquisaElement = document.querySelector("input[name='pesquisa']");
    const termoPesquisa = termoPesquisaElement ? termoPesquisaElement.value.trim() : '';

    if (termoPesquisa !== '') {
        // Se o termo de pesquisa não estiver vazio, atualiza a página com o termo de pesquisa
        window.location.href = `?pagina=1&itensPorPagina=${itensPorPagina}&pesquisa=${termoPesquisa}`;
    } else {
        // Se o termo de pesquisa estiver vazio, atualiza a página apenas com itens por página
        window.location.href = `?pagina=1&itensPorPagina=${itensPorPagina}`;
    }
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

function handleAvatarClick(event) {
    event.stopPropagation();
    document.getElementById('fileInput').click();
}