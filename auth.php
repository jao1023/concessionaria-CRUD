<?php
// auth.php (parte relevante)

require_once 'conn.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        if ($email && $password) {
            // Adicione a coluna 'primeiro_nome' na consulta SELECT
            $sql = "SELECT id, email, password, primeiro_nome FROM vendedores WHERE email = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['email'] = $user['email'];
                        // Salve o nome do usuário na sessão
                        $_SESSION['primeiro_nome'] = $user['primeiro_nome']; 
                        $_SESSION['message'] = "Bem vindo!";
                        $_SESSION['message_type'] = "primary";
                        header("Location: index.php");
                        exit();
                    } else {
                        throw new Exception("Email ou senha invalido ");
                    }
                } else {
                    throw new Exception("Email ou senha invalido ");
                }
                $stmt->close();
            } else {
                throw new Exception("Erro ao preparar a consulta " . $conn->error);
            }
        } else {
            throw new Exception("Email ou senha são obrigatorios");
        }
    } else {
        throw new Exception("Metodo de requisição invalida");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conn->close();
}
