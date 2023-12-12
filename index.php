
<?php 
session_start();
include('config/conexao.php');?>
<?php
$host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
?>


<!DOCTYPE html>
<html lang="pt-br">
<?php include('head.php');?>
<body class="">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 bg-transparent text-center">
                  <h1 class="font-weight-bolder text-info text-gradient">Login</h1>
                  <p class="mb-0">Entre com suas credenciais, ou crie sua conta clicando no botão "Criar Conta"</p>
                </div>
                <div class="card-body">
                  <form role="form" action="verificar.php" method="POST">
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="text" id="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                    </div>
                    <label>Senha</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" placeholder="Senha" id="senha" name="senha" aria-label="Password" aria-describedby="password-addon">
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-3">Entrar</button>
                      <a href="registro.php" class="btn btn-outline-info w-100">Criar Conta</a>
                    </div>

                  </form>
                </div>
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </section>
  </main>
  
  
   <script>
    function validateForm() {
      var email = document.forms[0]["email"].value;
      var senha = document.forms[0]["senha"].value;
      var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})");

      if (email === "" || senha === "") {
        alert("Por favor, preencha todos os campos.");
        return false;
      } else if (!strongRegex.test(senha)) {
        alert("A senha deve conter pelo menos 8 caracteres, incluindo pelo menos uma letra maiúscula, uma letra minúscula e um número.");
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
 

 
  
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
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
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/soft-ui-dashboard.min.js?v=1.0.6"></script>
</body>

</html>
<?php
error_reporting(0);
ini_set("display_error", 0 );
session_start(); // Inicia a session
?>