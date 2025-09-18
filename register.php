<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .register-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="register-container">
                    <h2 class="text-center mb-4">Criar uma conta</h2>
                    <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                        </div>
                        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
                    <?php endif; ?>

                    <form method="POST" action="register_back.php">
                        <div class="mb-3">
                            <label for="primeiro_nome" class="form-label">Primeiro Nome</label>
                            <input type="text" class="form-control" id="primeiro_nome" name="primeiro_nome" aria-describedby="nameHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="ultimo_nome" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="ultimo_nome" name="ultimo_nome" aria-describedby="nameHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="Cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="Cpf" name="Cpf" aria-describedby="nameHelp" required>
                        </div>

                        <div class="mb-3">
                            <label for="Email" class="form-label">Endereço de e-mail</label>
                            <input type="email" class="form-control" id="Email" name="Email" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="Password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="Password" name="Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="ConfirmPassword" class="form-label">Confirmar senha</label>
                            <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="termsCheck" required>
                            <label class="form-check-label" for="termsCheck">Eu concordo com os <a href="termos.php">termos de serviço</a></label>
                        </div>
                        <button type="submit"  class="btn btn-primary w-100 mb-3">Cadastrar</button>
                    </form>

                    <div class="text-center mt-3">
                        Já tem uma conta? <a href="login.php">Faça login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>