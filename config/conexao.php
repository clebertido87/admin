
<?php
// Conex«ªo banco de dados
$server = "localhost";
$user   = "haagro_hinfo";
$pass   = "94501701@";
$db    = "haagro_hinfo";

$conexao = mysqli_connect($server, $user, $pass, $db);

// Verifica a conex«ªo
if (!$conexao) {
    die("Erro de conexÃ£o: " . mysqli_connect_error());
}

?>