
<?php
// Conex���o banco de dados
$server = "localhost";
$user   = "haagro_hinfo";
$pass   = "94501701@";
$db    = "haagro_hinfo";

$conexao = mysqli_connect($server, $user, $pass, $db);

// Verifica a conex���o
if (!$conexao) {
    die("Erro de conexão: " . mysqli_connect_error());
}

?>