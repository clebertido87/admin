<!DOCTYPE html>
<html lang="pt-br">
<?php include('head.php');?>

<?php session_start();?>

<body class="">
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent text-center">
                  <h1 class="font-weight-bolder text-info text-gradient"> Cadastro</h1>
                  <p class="mb-0">Preencha os campos abaixo:</p>
                </div>
                <div class="card-body">
                  <form role="form" action="processar_registro.php" method="POST" onsubmit="return validateForm()">
                    <!-- Adiciona um campo de usuário no formulário -->
                    <label>Usuário</label>
                    <div class="mb-3">
                      <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuário" aria-label="Usuário" aria-describedby="usuario-addon" required>
                    </div>
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" required>
                    </div>
                    <label>Senha</label>
                    <div class="mb-3">
                      <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha" aria-label="Senha" aria-describedby="password-addon" required>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-3">Registrar</button>
                      <a href="index.php" class="btn btn-outline-info w-100">Já tem uma conta? Entrar</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="email-error" style="color: red;">
        <?php
        if (isset($_SESSION['cadastroErro'])) {
            echo $_SESSION['cadastroErro'];
            unset($_SESSION['cadastroErro']);
        }
        ?>
      </div>
      <div id="cadastro-success" style="color: green;">
        <?php
        if (isset($_SESSION['cadastroSucesso'])) {
            echo $_SESSION['cadastroSucesso'];
            unset($_SESSION['cadastroSucesso']);
        }
        ?>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    function validateForm() {
      var email = document.getElementById('email').value;
      var senha = document.getElementById('senha').value;

      // Validar email usando uma expressão regular
      var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      if (!emailRegex.test(email)) {
        alert("Por favor, insira um endereço de e-mail válido.");
        return false;
      }

      // Validar a senha, você pode adicionar critérios aqui
      if (senha.length < 8) {
        alert("A senha deve ter pelo menos 8 caracteres.");
        return false;
      }

      return true;
    }

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
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/soft-ui-dashboard.min.js?v=1.0.6"></script>
</body>
</html>
