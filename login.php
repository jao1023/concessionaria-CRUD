<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Estilização extra para o corpo da página */
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
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
                <div class="login-container">
                    <h2 class="text-center mb-4">Entrar</h2>
                    <form method="POST" action="auth.php">
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Endereço de e-mail</label>
                            <input type="email" class="form-control" id="inputEmail" name="email" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="inputPassword" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Entrar</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        Não tem uma conta? <a href="register.php">Cadastre-se</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>