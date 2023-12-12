<?php
$host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
session_start();
include('config/conexao.php');

// Verificar se o e-mail e senha foram preenchidos
if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Filtrar e-mail para evitar injeção de SQL
    $senha = str_replace(array("#", "'", ";", "*", "=", "INSERT", "insert", "delete", "DELETE", "where", "WHERE", "update", "UPDATE"), '', $_POST['senha']);

    // Buscar na tabela usuarios_admin o usuário que corresponde aos dados digitados no formulário
    $result_usuario = "SELECT * FROM usuarios_admin WHERE email = '$email'";
    $resultado_usuario = mysqli_query($conexao, $result_usuario);
    $resultado = mysqli_fetch_assoc($resultado_usuario);

    if ($resultado) {
        $passUser = $resultado['senha'];
        $passInput = $senha;

        // Verificar a senha
        if (password_verify($passInput, $passUser)) {
            $_SESSION['usuario_id'] = $resultado['usuario_id'];
            $_SESSION['usuario'] = $resultado['usuario'];
            echo "<script> window.location.href='https://" . $host . "/admin/control.php?url=1'; </script>";
        } else {
            echo "<script> window.location.href='https://" . $host . "/admin/'; </script>";
        }
    } else {
        $_SESSION['loginErro'] = "E-mail ou senha inválidos";
        echo "<script> window.location.href='https://" . $host . "/admin/'; </script>";
    }
} else {
    $_SESSION['loginErro'] = "E-mail ou senha não preenchida";
    echo "<script> window.location.href='https://" . $host . "/admin/'; </script>";
}
?>

