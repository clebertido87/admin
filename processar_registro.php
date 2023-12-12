<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
session_start();
include('config/conexao.php');

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['cadastroErro'] = "Por favor, forneça um email válido.";
        header("Location: registro.php");
        exit();
    }

    // Check for password confirmation here if needed

    $verifica_email = "SELECT COUNT(*) FROM usuarios_admin WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $verifica_email);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        $_SESSION['cadastroErro'] = "Este email já está em uso. Escolha outro email.";
        header("Location: registro.php");
        exit();
    } else {
        // Verify the number of users in the table
        $count_users_query = "SELECT COUNT(*) FROM usuarios_admin";
        $count_users_result = mysqli_query($conexao, $count_users_query);
        $row = mysqli_fetch_assoc($count_users_result);
        $num_users = $row['COUNT(*)'];

        mysqli_autocommit($conexao, false);
        $inserir_usuario = "INSERT INTO usuarios_admin (email, senha) VALUES (?, ?)";
        $stmt = mysqli_prepare($conexao, $inserir_usuario);
        mysqli_stmt_bind_param($stmt, 'ss', $email, $senha);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_commit($conexao);

            $_SESSION['cadastroSucesso'] = "Cadastro realizado com sucesso. Faça o login.";
            header("Location: index.php");
            exit();
        } else {
            mysqli_rollback($conexao);

            $_SESSION['cadastroErro'] = "Erro ao cadastrar o usuário. Tente novamente.";
            header("Location: registro.php");
            exit();
        }
    }
} else {
    $_SESSION['cadastroErro'] = "Por favor, preencha todos os campos.";
    header("Location: registro.php");
    exit();
}
?>
