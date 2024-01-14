$(document).ready(function () {
    $('#editarContatoForm').submit(function (event) {
        event.preventDefault();
        const id = $('#id').val();
        const nome = $('#nome').val();
        let telefone = $('#telefone').val();
        const email = $('#email').val();
        telefone = removerMascaraTelefone(telefone);

        if (validarDadosContato(nome, telefone, email)) {
            $.ajax({
                url: '../../contato/scripts/editar_contato.php',
                type: 'POST',
                data: {
                    id: id,
                    nome: nome,
                    telefone: telefone,
                    email: email
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    console.log(res);
                    if (res.status === 200) {
                        window.location.href = '../../index.php';
                    } else {
                        messageErro(res.message);
                    }
                },
                error: function (error) {
                    messageErro(`Erro ao salvar as alterações`);
                }
            });
        }
    });
});
