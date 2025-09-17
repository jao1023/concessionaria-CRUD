<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "concessionaria";

//Criação da conexão
$connection = new mysqli($servername, $username, $password, $database);

$modelo = "";
$ano = "";
$marca = "";
$placa = "";
$descricao = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location:index.php");
        exit;
    }
    $id = intval($_GET["id"]);

    // LER A LINHA DO VEÍCULO SELECIONADO
    $sql = "SELECT * FROM veiculos WHERE id = $id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: index.php");
        exit;
    }

    $modelo = $row["modelo"];
    $ano = $row["ano"];
    $marca = $row["marca"];
    $placa = $row["placa"];
    $descricao = $row["descricao"];
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aqui precisa do id para atualizar
    if (!isset($_GET["id"])) {
        header("location:index.php");
        exit;
    }
    $id = intval($_GET["id"]);

    // Pegando valores do form
    $modelo = $_POST["modelo"];
    $ano = $_POST["ano"];
    $marca = $_POST["marca"];
    $placa = $_POST["placa"];
    $descricao = $_POST["descricao"];

    do {
        if (empty($modelo) || empty($ano) || empty($marca) || empty($placa) || empty($descricao)) {
            $errorMessage = "Todos os campos são obrigatórios";
            break;
        }

        if (strlen($placa) !== 8) {
            $errorMessage = "A placa é invalida";
            break;
        }

        if ($ano < 1886 || $ano > date('Y')) {
            $errorMessage = "Ano inserido invalido";
            break;
        }

        // Atualizar os dados na tabela veiculos
        $sql = "UPDATE veiculos SET 
                    modelo = '$modelo', 
                    ano = '$ano', 
                    marca = '$marca', 
                    placa = '$placa',   
                    descricao = '$descricao' 
                WHERE id = $id";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Erro na query: " . $connection->error;
            break;
        }

        $successMessage = "Veículo atualizado com sucesso";

        header("location: index.php");
        exit;
    } while (false);
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Adicionar Carro</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Formulário de cadastro de veículos</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?= $errorMessage ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?= $successMessage ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post" action="edit.php?id=<?= $id ?>"> <!-- <--- FORM ABERTO AQUI -->

            <div class="input-group mb-3">
                <span class="input-group-text w-25">Modelo</span>
                <input
                    type="text"
                    name="modelo"
                    value="<?= htmlspecialchars($modelo) ?>"
                    class="form-control"
                    placeholder="Omega"
                    required />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text w-25">Ano</span>
                <input
                    type="number"
                    name="ano"
                    value="<?= htmlspecialchars($ano) ?>"
                    class="form-control"
                    placeholder="1992"
                    required />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text w-25">Marca</span>
                <input
                    type="text"
                    name="marca"
                    value="<?= htmlspecialchars($marca) ?>"
                    class="form-control"
                    placeholder="Chevrolet"
                    required />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text w-25">Placa</span>
                <input
                    type="text"
                    name="placa"
                    value="<?= htmlspecialchars($placa) ?>"
                    class="form-control"
                    placeholder="MOI-1R23"
                    required />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text w-25">Descrição</span>
                <textarea
                    name="descricao"
                    class="form-control"
                    placeholder="Motor 4.1, 48.000KM rodados etc...""
                    required><?= htmlspecialchars($descricao) ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Adicionar</button>
                <a href="index.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form> <!-- <--- FORM FECHADO AQUI -->
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        defer></script>
</body>

</html>