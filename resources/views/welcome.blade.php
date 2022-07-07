<?php include './includes/head.php'; ?>

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
                                <label for="email"  class="form-label">Digite o seu e-mail do trabalho:</label>
                                <input type="email" value="{{ old('email') }}" name="email" id="email" class="form-control">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-info w-100"
                                    formaction="{{ route('LoginController.SendMail') }}">Enviar
                                </button>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="cpf-1" class="form-label">Digite os 4 primeiros dígitos do seu
                                    CPF:</label>
                            </div>
                            <div class="col-2 col-md">
                                <input type="text" name="cpf1" value="{{ old('cpf1') }}" id="cpf1" class="form-control"
                                    inputmode="numeric" minlength="1" maxlength="1" size="1">
                            </div>
                            <div class="col-2 col-md">
                                <input type="text" name="cpf2" value="{{ old('cpf2') }}" id="cpf2" class="form-control"
                                    inputmode="numeric" minlength="1" maxlength="1" size="1">
                            </div>
                            <div class="col-2 col-md">
                                <input type="text" name="cpf3" value="{{ old('cpf3') }}" id="cpf3" class="form-control"
                                    inputmode="numeric" minlength="1" maxlength="1" size="1">
                            </div>
                            <div class="col-2 col-md">
                                <input type="text" value="{{ old('cpf4') }}" name="cpf4" id="cpf4" class="form-control"
                                    inputmode="numeric" minlength="1" maxlength="1" size="1">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="email_code" class="form-label">Digite o código recebido pelo e-mail:</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" inputmode="numeric" minlength="6" maxlength="6" size="6"
                                    name="email_code" value="{{ old('email_code') }}" id="email_code" class="form-control">
                            </div>
                            <div class="col-12 form-info">*Código enviado para o e-mail preenchido no 1º campo</div>
                        </div>

                        <div class="form-row form-btn">
                            <div class="col-12">
                                <button type="submit" class="btn btn-green">Continuar</button>
                            </div>
                            <div class="form-row form-btn">
                            </div>
                    </form>
                    <div class="max-width mt-5">
                        <!--FORM VALIDATE-->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
