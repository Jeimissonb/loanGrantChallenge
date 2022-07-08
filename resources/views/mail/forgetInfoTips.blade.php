<h1>Dados esquecidos contidos no corpo deste email!</h1>

<h2>Oi, {{ $user->verifyEmailExists[0]['name'] }}, Informações solicitadas em esqueci meus dados do desafio KBR!</h2>
<br />
<h2><strong>Nome: </strong>{{ $user->verifyEmailExists[0]['name'] }} </h2> <br />
<h2><strong>CPF: </strong>{{ $user->verifyEmailExists[0]['cpf'] }} </h2><br /><br /><br /><br />


{{-- O array abaixo só tem uma posição pois a busca realizada na função só retorna 1 usuário --}}
<h4>Objeto completo para fins de aprendizado: </h4><br />
<h4>Id na base de dados: {{ $user->verifyEmailExists[0]['id'] }}</h4><br />
<h4>Nome: {{ $user->verifyEmailExists[0]['name'] }}</h4><br />
<h4>Email: {{ $user->verifyEmailExists[0]['email'] }}</h4><br />
<h4> CPF: {{ $user->verifyEmailExists[0]['cpf'] }}</h4><br />
