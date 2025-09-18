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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $modelo = $_POST["modelo"];
  $ano = $_POST["ano"];
  $marca = $_POST["marca"];
  $placa = $_POST["placa"];
  $descricao = $_POST["descricao"];

  do {
    if (empty($modelo) || empty($ano) || empty($marca) || empty($placa) || empty($descricao)) {
      $errorMessage = "Todos os campos precisam estar preenchidos";
      break;
    }


    if (strlen($placa) !== 8) {
      $errorMessage = "A placa deve ter exatamente 7 caracteres.";
      break;
    }

    if ($ano < 1886 || $ano > date('Y')) {
      $errorMessage = "Ano inserido invalido";
      break;
    }

    $sqlCheck = "SELECT placa FROM veiculos WHERE placa = ?";
    $stmtCheck = $connection->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $placa);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
      $errorMessage = "Esta placa já está cadastrada.";
      $stmtCheck->close();
      break;
    }
    $stmtCheck->close();

    $sql = "INSERT INTO veiculos (modelo, ano, marca, placa, descricao) 
                VALUES (?, ?, ?, ?, ?)";
    $stmtInsert = $connection->prepare($sql);
    $stmtInsert->bind_param("sisss", $modelo, $ano, $marca, $placa, $descricao);

    $result = $stmtInsert->execute();

    if (!$result) {
      $errorMessage = "Erro ao inserir dados: " . $stmtInsert->error;
      $stmtInsert->close();
      break;
    }
    $stmtInsert->close();

    $modelo = "";
    $ano = "";
    $marca = "";
    $placa = "";
    $descricao = "";

    $successMessage = "Veículo adicionado com sucesso!";
    header("Location: index.php?status=success"); // <--- MUDANÇA AQUI
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

    <form method="post"> <!-- <--- FORM ABERTO AQUI -->

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
          placeholder="Motor 4.1, 48.000KM rodados etc..."
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