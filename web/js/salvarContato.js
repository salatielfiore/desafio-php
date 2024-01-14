$(document).ready(function () {
    $('#contatoForm').submit(function (event) {
        event.preventDefault();
        const nome = $('#nome').val();
        let telefone = $('#telefone').val();
        const email = $('#email').val();
        telefone = removerMascaraTelefone(telefone);
        if (validarDadosContato(nome, telefone, email)) {
            $.ajax({
                url: '../../contato/scripts/inserir_contato.php',
                type: 'POST',
                data: {
                    nome: nome,
                    telefone: telefone,
                    email: email
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.status === 200) {
                        window.location.href = '../../index.php';
                    } else {
                        messageErro(res.message);
                    }
                },
                error: function (error) {
                    messageErro(`Erro ao salvar o contato`);
                }
            });
        }
    });
});