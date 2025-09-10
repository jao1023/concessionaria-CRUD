<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Concessionaria</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    href="https://getbootstrap.com/docs/5.3/assets/css/docs.css"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
</head>

<body>
  <!-- Navbar principal -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img
          src="/docs/5.3/assets/brand/bootstrap-logo.svg"
          alt="Logo"
          width="30"
          height="24"
          class="mr-2" />
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto"></ul>
      </div>
      <!-- Dropdown do usuário -->
      <div class="dropdown ms-3">
        <button
          class="btn btn-dark dropdown-toggle"
          type="button"
          data-bs-toggle="dropdown"
          aria-expanded="false">
          <i class="bi bi-person-circle"></i> User name
        </button>
        <ul class="dropdown-menu">
          <li>
            <a class="dropdown-item" href="#"><i class="bi bi-gear-fill"></i> Settings</a>
          </li>
          <li>
            <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Barra de busca alinhada à direita e mais embaixo -->

  <div class="container">
    <h2>Lista de veiculos</h2>

    <!-- Search bar + botão alinhados -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <!-- Botão à esquerda -->
      <a href="create.php" class="btn btn-dark" role="button">Novo Veiculo</a>

      <form class="d-flex w-auto" role="search">
        <input
          class="form-control me-2"
          type="search"
          placeholder="Search"
          aria-label="Search" />
        <button class="btn btn-outline-success" type="submit">Search</button>
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
        require_once 'conn.php';

        $query = "SELECT id, modelo,ano, marca,placa,descricao, created_at FROM veiculos";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "

         <tr>
          <td>{$row['id']}</td>
                        <td>{$row['modelo']}</td>
                        <td>{$row['ano']}</td>
                        <td>{$row['marca']}</td>
                        <td>{$row['placa']}</td>
                        <td>{$row['descricao']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a class='btn btn-primary' href='edit.php?id={$row['id']}'>Editar</a>
                            <a class='btn btn-danger' href='delete.php?id={$row['id']}'>Deletar</a>
                        </td>
                    </tr>
                    ";
          }
        } else {
          echo "<tr><td colspan ='5'> Nenhuma tarefa encontrada!</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>

  <script
    defer
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>