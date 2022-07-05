<?php include('./includes/head.php'); ?>

  <main class="page" id="emprestimo">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-lg-7 col-xl-6">
          <div class="box">
            <h1 class="title">Informe seus dados</h1>

            <form method="POST" action="{{ route('LoginController.SingIn') }}" class="form">
                @csrf
              <div class="form-row">
                <div class="col-12 form-placeholder">
                  <label for="email" class="form-label">Digite o seu e-mail do trabalho:</label>
                  <input type="email" name="email" id="email" class="form-control" required>
                </div>
              </div>

              <div class="form-row">
                <div class="col-md-6">
                  <label for="cpf-1" class="form-label">Digite os 4 primeiros dígitos do seu CPF:</label>
                </div>
                <div class="col-2 col-md">
                    <input type="text" name="cpf1" id="cpf1" class="form-control" required>
                </div>
                <div class="col-2 col-md">
                    <input type="text" name="cpf2" id="cpf2" class="form-control" required>
                </div>
                <div class="col-2 col-md">
                    <input type="text" name="cpf3" id="cpf3" class="form-control" required>
                </div>
                <div class="col-2 col-md">
                  <input type="text" name="cpf4" id="cpf4" class="form-control" required>
                </div>
              </div>

              <div class="form-row">
                <div class="col-md-6">
                  <label for="codigo" class="form-label">Digite o código recebido pelo e-mail:</label>
                </div>
                <div class="col-md-6">
                  <input type="text" id="codigo" class="form-control">
                </div>
                <div class="col-12 form-info">*Código enviado para o e-mail preenchido no 1º campo</div>
              </div>

              <div class="form-row form-btn">
                <div class="col-12">
                  <button type="submit" class="btn btn-green">Continuar</button>
                  <button type="button" class="btn btn-green"><a href="/sendMail" >Enviar</a>
                  </button>
                </div>
                <div class="form-row form-btn">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

<?php include('includes/footer.php'); ?>
