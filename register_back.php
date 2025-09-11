<?php
require_once 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $primeiro_nome = $_POST['primeiro_nome'] ?? null;
        $ultimo_nome = $_POST['ultimo_nome'] ?? null;
        $cpf = $_POST['Cpf'] ?? null;
        $email = $_POST['Email'] ?? null;
        $password = $_POST['Password'] ?? null;
        $confirmPassword = $_POST['ConfirmPassword'] ?? null;


        if ($primeiro_nome && $ultimo_nome && $cpf && $email && $password && $confirmPassword) {
            if ($password !== $confirmPassword) {
                $_SESSION['message'] = "As senhas não coincidem!";
                $_SESSION['message_type'] = "danger";
                header("location: register.php");
                exit();
            }
            if (!$conn || $conn->connect_error) {
                throw new Exception("Conexão com o banco de dados não está ativa");
            }

            $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

            $sql = "INSERT INTO vendedores (primeiro_nome, ultimo_nome, cpf, email, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssss", $primeiro_nome, $ultimo_nome, $cpf, $email, $hashedPassword);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Cadastro realizado com sucesso! Agora você pode fazer login.";
                    $_SESSION['message_type'] = "success";
                    header("location: login.php");
                    exit();
                } else {
                    throw new Exception("Erro ao executar o cadastro: " . $stmt->error);
                }

                $stmt->close();
            } else {
                throw new Exception("Erro ao preparar a consulta: " . $conn->error);
            }
        } else {
            $_SESSION['message'] = "Por favor, preencha todos os campos obrigatórios.";
            $_SESSION['message_type'] = "danger";
            header("location: register.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Erro: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
        header("location: register.php");
        exit();
    } finally {
        if (isset($conn) && !$conn->connect_error) {
            $conn->close();
        }
    }
}
?>