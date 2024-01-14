$(document).ready(function() {
    $('.telefone-mask').inputmask('(99) 99999-9999');
});

$(document).ready(function() {
    $('#telefone').inputmask('(99) 99999-9999');
});

function validarDadosContato(nome, telefone, email) {
    if (nome.trim() === '' || telefone.trim() === '' || email.trim() === '') {
        messageErro('Preencha todos os campos!');
        return false;
    }
    if (telefone.length < 11) {
        messageErro("O número de telefone é inválido!");
        return false;
    }
    if (!validarEmail(email)) {
        messageErro("O Email é inválido!");
        return false;
    }
    return true;
}

function validarEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
