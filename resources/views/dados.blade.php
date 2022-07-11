<?php include('includes/head.php'); ?>
  <main class="page" id="emprestimo">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-lg-7 col-xl-6">
          <div class="box">
            <h1 class="title">Dados</h1>

            <div class="box-dados">
              <p><strong>Simulações: </strong>{{ $totalSimulations }}</p>
              <p><strong>Valor Total: </strong>{{ $totalValueSimulations }}</p>

              <a href="/logout" title="Ir para página inicial" class="btn btn-green">Sair</a>
              <a href="/back-page" title="Voltar para página anterior" class="btn btn-info">Voltar</a>


            </div>
            <a href="/download-data" title="Baixar todos os dados em PDF" class="btn btn-danger w-100">Baixar tudo!</a>
          </div>
        </div>
      </div>
    </div>
  </main>

<?php include('includes/footer.php'); ?>
