$(document).ready(function () {
    $('#editarContatoForm').submit(function (event) {
        event.preventDefault();
        const id = $('#id').val();
        const nome = $('#nome').val();
        let telefone = $('#telefone').val();
        const email = $('#email').val();
        telefone = removerMascaraTelefone(telefone);

        // Criar um objeto FormData
        const formData = new FormData();

        // Adicionar os dados do formulário ao objeto FormData
        formData.append('id', id)
        formData.append('nome', nome);
        formData.append('telefone', telefone);
        formData.append('email', email);

        // Adicionar a imagem ao objeto FormData
        const fileInput = $('#fileInputEditar')[0].files[0];
        formData.append('imagem', fileInput);

        if (validarDadosContato(nome, telefone, email)) {
            $.ajax({
                url: '../../contato/scripts/editar_contato.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
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
