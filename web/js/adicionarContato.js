$(document).ready(function () {
    $('#contatoForm').submit(function (event) {
        event.preventDefault();
        const nome = $('#nome').val();
        let telefone = $('#telefone').val();
        const email = $('#email').val();
        telefone = removerMascaraTelefone(telefone);

        // Criar um objeto FormData
        const formData = new FormData();

        // Adicionar os dados do formulário ao objeto FormData
        formData.append('nome', nome);
        formData.append('telefone', telefone);
        formData.append('email', email);

        // Adicionar a imagem ao objeto FormData
        const fileInput = $('#fileInput')[0].files[0];
        formData.append('imagem', fileInput);

        if (validarDadosContato(nome, telefone, email)) {
            $.ajax({
                url: '../../contato/scripts/adicionar_contato.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
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