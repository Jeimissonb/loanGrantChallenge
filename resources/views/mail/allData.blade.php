<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Usuários</h1>
    @foreach ($user as $user)
        <h3>Id usuário: {{ $user->id }}</h3>
        <h3>Nome usuário: {{ $user->name }}</h3>
        <h3>CPF usuário: {{ $user->cpf }}</h3>
        <h3>Email usuário: {{ $user->email }}</h3>

        <h2>------------------------------------------------------</h2> <br />
    @endforeach

    <h1>Simulações</h1>
    @foreach ($simulations as $simulations)
        <h2>Simulações</h2>
        <h3>Id do usuário: {{$simulations->id_user}}</h3>
        <h3>Valor pretendido: {{ $simulations->pretended_value }}</h3>
        <h3>Parcelas: {{ $simulations->pretended_deadline }}</h3>
        <h3>Valor total com juros: {{ $simulations->pretended_value }}</h3>
        <h2>------------------------------------------------------</h2> <br />

    @endforeach

</body>

</html>
