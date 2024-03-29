<?php
include("../scripts/buscar_contato_atualizar.php")
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/contato.css">
    <title>A.R. Phoenix - Editar Contato</title>
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>

<body>

<div class="container">
    <h1 class="mt-3">Editar Contato</h1>

    <div id="mensagemErro" class="alert alert-danger mt-3" role="alert" hidden="hidden"></div>
    <form method="post" id="editarContatoForm" enctype="multipart/form-data">
        <?php if (!empty($contato)) { ?>
            <div class="form-group-img text-center">
                <div class="avatar-container">
                    <input type="file" class="custom-file-input" id="fileInputEditar" name="imagem"
                           accept=".png, .jpg, .jpeg, .gif" onchange="previewImage(this);">
                    <img id="preview" src="<?php echo $urlLogo . '?t=' . time(); ?>" alt="imagem"
                         class="img-fluid rounded-circle tamanho-img">
                </div>
            </div>
            <label for="id"></label><input hidden="hidden" type="text" class="form-control" id="id" name="id"
                                           value="<?php echo $contato['id']; ?>">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $contato['nome']; ?>"
                       maxlength="50">
            </div>
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" id="telefone" name="telefone"
                       value="<?php echo $contato['telefone']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?php echo $contato['email']; ?>" maxlength="100">
            </div>
            <button type="submit" class="btn btn-primary" id="submitBtn">Salvar Alterações</button>

            <!-- Botão de Cancelar -->
            <a href="../../index.php" class="btn btn-secondary">Cancelar</a>
        <?php } ?>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script src="../../js/util/validateUtil.js"></script>
<script src="../../js/script.js"></script>
<script src="../../js/util/stringUtils.js"></script>
<script src="../../js/editarContato.js"></script>
</body>
</html>