function messageErro(message) {
    const classDivErro = '.alert-danger';
    // Limpar mensagens antigas
    $(classDivErro).empty();
    // Adicionar nova mensagem de erro
    $(classDivErro).append(message);
    // Remover o atributo 'hidden'
    $(classDivErro).removeAttr('hidden');
    // Exibir a div de alerta
    $(classDivErro).show();
}

function removerMascaraTelefone(telefone) {
    // Remove todos os caracteres não numéricos
    return telefone.replace(/\D/g, '');
}