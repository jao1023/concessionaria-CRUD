<?php
// Inicia a sessão para acessar as variáveis de sessão.
session_start();

// Esta verificação garante que a página só pode ser acessada por usuários logados.
// Se a variável de sessão 'user_id' não estiver definida, o usuário é redirecionado para a página de login.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'conn.php';

// Inicializa a variável de busca
$search_query = '';

// Verifica se há um termo de busca na URL
if (isset($_GET['search_query'])) {
    $search_query = htmlspecialchars($_GET['search_query']);
}

// Constrói a query SQL base
$query = "SELECT id, modelo, ano, marca, placa, descricao, created_at FROM veiculos";

// Se um termo de busca foi fornecido, adiciona a cláusula WHERE
if (!empty($search_query)) {
    $query .= " WHERE modelo LIKE ? OR marca LIKE ? OR placa LIKE ? OR descricao LIKE ?";
}

// Prepara a declaração para evitar injeção de SQL
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}

// Se a busca estiver ativa, vincula os parâmetros
if (!empty($search_query)) {
    $search_param = '%' . $search_query . '%';
    $stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
}

// Executa a declaração
$stmt->execute();

// Obtém o resultado
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Concessionaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Navbar principal -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto"></ul>
            </div>
            <!-- Dropdown do usuário -->
            <div class="dropdown ms-3">
                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                    <?php echo isset($_SESSION['primeiro_nome']) ? htmlspecialchars($_SESSION['primeiro_nome']) : 'Usuário'; ?>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Lista de veiculos</h2>

        <!-- Search bar + botão alinhados -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Botão à esquerda -->
            <a href="create.php" class="btn btn-dark" role="button">Novo Veiculo</a>

            <form class="d-flex w-auto" role="search" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_query" value="<?php echo htmlspecialchars($search_query); ?>" />
                <button class="btn btn-dark" type="submit">Search</button>
            </form>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Marca</th>
                    <th>Placa</th>
                    <th>Descricao</th>
                    <th>Adicionado Em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $data_formatada = date('d/m/Y', strtotime($row['created_at']));
                        echo "
    <tr>
        <td>{$row['id']}</td>
        <td>{$row['modelo']}</td>
        <td>{$row['ano']}</td>
        <td>{$row['marca']}</td>
        <td>{$row['placa']}</td>
        <td>{$row['descricao']}</td>
        <td>{$data_formatada}</td>
        <td>
            <a class='btn btn-primary' href='edit.php?id={$row['id']}'>Editar</a>
            <a class='btn btn-danger' href='delete.php?id={$row['id']}'>Deletar</a>
        </td>
    </tr>
    ";
                    }
                } else {
                    echo "<tr><td colspan='8'>Nenhum veículo encontrado!</td></tr>";
                }
                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" xintegrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" xintegrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" xintegrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>