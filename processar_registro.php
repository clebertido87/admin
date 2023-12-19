<?php
$host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
session_start();
include('config/conexao.php');

// Verifica se o formulário foi enviado
if (isset($_POST['usuario']) && isset($_POST['email']) && isset($_POST['senha'])) {

    // Recebe os dados do formulário e filtra caracteres especiais
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    // Valida o formato do email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Se o email for inválido, exibe uma mensagem de erro e encerra o script
        echo "Email inválido!";
        exit;
    }

    // Gera um hash da senha usando a função password_hash
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    // Prepara uma consulta SQL para verificar se o email ou o usuário já existem na tabela usuarios_admin
    $verifica_email_usuario = "SELECT COUNT(*) FROM usuarios_admin WHERE email = ? OR usuario = ?";
    $stmt = mysqli_prepare($conexao, $verifica_email_usuario);
    mysqli_stmt_bind_param($stmt, 'ss', $email, $usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        // Se o email ou o usuário já existirem, exibe uma mensagem de erro e redireciona para a página de registro
        $_SESSION['cadastroErro'] = "Este email ou usuário já estão em uso. Escolha outro email ou usuário.";
        header("Location: registro.php");
        exit();
    } else {
        
        //verificar quantos usuarios tem na tabela= se tiver 1 = admin, se nao tiver 0 usuario
        
        mysqli_autocommit($conexao, false);
        // Modifica a consulta SQL para inserir também o usuário na tabela usuarios_admin
        $inserir_usuario = "INSERT INTO usuarios_admin (usuario, email, senha) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $inserir_usuario);
        mysqli_stmt_bind_param($stmt, 'sss', $usuario, $email, $senha_hash);

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
