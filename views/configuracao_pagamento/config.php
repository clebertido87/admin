<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>Cobranças</title>

  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />

  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/soft-ui-dashboard.css?v=1.0.6" rel="stylesheet" />
</head>

<?php
// Inicie a sessão antes de acessar $_SESSION
session_start();

// Estabeleça a conexão com o banco de dados (substitua pelos detalhes reais)
$conexao = mysqli_connect($server, $user, $pass, $db);
if (!$conexao) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o token do formulário e evita possíveis ataques de SQL Injection
    $token = mysqli_real_escape_string($conexao, $_POST['token']);

    // Use prepared statements para evitar SQL Injection
    $checkTokenQuery = mysqli_prepare($conexao, "SELECT COUNT(*) as count FROM intermediadores WHERE token = ?");
    mysqli_stmt_bind_param($checkTokenQuery, "s", $token);
    mysqli_stmt_execute($checkTokenQuery);
    mysqli_stmt_bind_result($checkTokenQuery, $count);
    mysqli_stmt_fetch($checkTokenQuery);
    mysqli_stmt_close($checkTokenQuery);

    if ($count == 0) {
        // O token não está em uso, pode ser salvo
        if (empty($_POST['id'])) {
            // Use prepared statements
            $insertQuery = mysqli_prepare($conexao, "INSERT INTO intermediadores (usuario_id, nome, token) VALUES (?, 'Mercado Pago', ?)");
            mysqli_stmt_bind_param($insertQuery, "is", $_SESSION['usuario_id'], $token);
            mysqli_stmt_execute($insertQuery);
            mysqli_stmt_close($insertQuery);
        } else {
            // Use prepared statements
            $updateQuery = mysqli_prepare($conexao, "UPDATE intermediadores SET token=? WHERE id=? AND usuario_id=?");
            mysqli_stmt_bind_param($updateQuery, "sii", $token, $_POST['id'], $_SESSION['usuario_id']);
            mysqli_stmt_execute($updateQuery);
            mysqli_stmt_close($updateQuery);
        }
    } else {
        // O token já está em uso, aqui você pode exibir uma mensagem de erro ou gerar um novo token
        echo "Erro: Este token já está em uso. Por favor, escolha outro.";
    }
}

$sql = mysqli_query($conexao, "SELECT * FROM intermediadores WHERE usuario_id = '{$_SESSION['usuario_id']}' LIMIT 1") or die(mysqli_error($conexao));
$ret = mysqli_fetch_array($sql);
?>


<body class="g-sidenav-show bg-gray-100">
  <?php include('blocos/menu.php');?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <?php include('blocos/head_menu.php');?>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-5">
          <div class="card card-plain mt-8">
            <h4>Intermediador de pagamento</h4>
            <div class="card-body">
              <form role="form" action="" method="POST">
                <input type="hidden" name="id" value="<?= @$ret['id']; ?>" />
                <label>Nome</label>
                <div class="mb-3">
                  <input type="text" name="usuario" class="form-control" value="Mercado Pago" readonly>
                </div>
                <label>Token</label>
                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="Token" name="token" value="<?= @$ret['token']; ?>" aria-label="Password" aria-describedby="password-addon">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Atualizar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php include('blocos/rodape.php');?>
    </div>
  </main>

  <!-- Core JS Files -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="assets/js/plugins/chartjs.min.js"></script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages, etc -->
  <script src="assets/js/soft-ui-dashboard.min.js?v=1.0.6"></script>
</body>

</html>
