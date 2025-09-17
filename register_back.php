<?php
require_once 'conn.php';
session_start(); // Iniciar sessão no topo!

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $primeiro_nome = $_POST['primeiro_nome'] ?? null;
        $ultimo_nome = $_POST['ultimo_nome'] ?? null;
        $cpf = $_POST['Cpf'] ?? null;
        $email = $_POST['Email'] ?? null;
        $password = $_POST['Password'] ?? null;
        $confirmPassword = $_POST['ConfirmPassword'] ?? null;

        if ($primeiro_nome && $ultimo_nome && $cpf && $email && $password && $confirmPassword) {

            // Verifica se CPF tem exatamente 11 dígitos numéricos
            if (!preg_match('/^\d{11}$/', $cpf)) {
                $_SESSION['message'] = "O CPF deve conter exatamente 11 dígitos numéricos.";
                $_SESSION['message_type'] = "danger";
                header("location: register.php");
                exit();
            }

            // Verifica se as senhas coincidem
            if ($password !== $confirmPassword) {
                $_SESSION['message'] = "As senhas não coincidem!";
                $_SESSION['message_type'] = "danger";
                header("location: register.php");
                exit();
            }

            if (!$conn || $conn->connect_error) {
                throw new Exception("Conexão com o banco de dados não está ativa");
            }

            // Verifica se o CPF já está registrado
            $cpf_check = $conn->prepare("SELECT id FROM vendedores WHERE cpf = ?");
            $cpf_check->bind_param("s", $cpf);
            $cpf_check->execute();
            $cpf_check->store_result();
            if ($cpf_check->num_rows > 0) {
                $_SESSION['message'] = "Este CPF já está cadastrado.";
                $_SESSION['message_type'] = "danger";
                $cpf_check->close();
                header("location: register.php");
                exit();
            }
            $cpf_check->close();

            // Verifica se o e-mail já está registrado
            $email_check = $conn->prepare("SELECT id FROM vendedores WHERE email = ?");
            $email_check->bind_param("s", $email);
            $email_check->execute();
            $email_check->store_result();
            if ($email_check->num_rows > 0) {
                $_SESSION['message'] = "Este e-mail já está cadastrado.";
                $_SESSION['message_type'] = "danger";
                $email_check->close();
                header("location: register.php");
                exit();
            }
            $email_check->close();

            // Criptografa a senha
            $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

            // Insere no banco
            $sql = "INSERT INTO vendedores (primeiro_nome, ultimo_nome, cpf, email, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssss", $primeiro_nome, $ultimo_nome, $cpf, $email, $hashedPassword);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Cadastro realizado com sucesso!";
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
