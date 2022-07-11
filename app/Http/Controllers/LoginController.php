<?php

namespace App\Http\Controllers;

use App\Mail\newLaravelTips;
use App\Mail\forgetInfoTips;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use stdClass;

class LoginController extends Controller

{
    public function SingIn(Request $request)
    {
        //chamando função para validações, o parametro 'all' indica a condição interna da função, nesse caso, irá validar todos os campos; há mais detalhes dentro da função, o terceiro parametro indica uma mensagem personalizada para validação apenas de email;
        $this->ValidateFields($request, 'all', null);

        $user = User::whereRaw('SUBSTRING(cpf, 1, 1) = ' . $request->cpf1)
            ->whereRaw('SUBSTRING(cpf, 2, 1) = ' . $request->cpf2)
            ->whereRaw('SUBSTRING(cpf, 3, 1) = ' . $request->cpf3)
            ->whereRaw('SUBSTRING(cpf, 4, 1) = ' . $request->cpf4)
            ->where('email_code', $request->email_code)
            ->where('email', $request->email)->first();

        if ($user) // se verdade existe um usuário com essas informações
        {
            Auth::login($user); //efetuando a operação de autenticação
            return Redirect('resultado');
        } else {
            // função para realizar redirect com mensagem de erro
            return $this->RedirectBackError('Credenciais não encontradas em nossas bases de dados :(');
        }
    }

    public function SingOut()
    {
        $id = Auth::user()->id;
        User::where('id', $id)->update(['email_code' => '777777']); //setando o código para um padrão, ao destruir a sessão;
        Auth::logout();

        return redirect()
            ->back();
    }

    public function SendMail(Request $request)
    {
        $emailValue = $request->input('email');

        //chamando função para validações, o parametro 'email' indica a condição interna da função, nesse caso, irá validar apenas o email(preenchimento obrigatório)
        $this->ValidateFields($request, 'email', 'Preencha o campo email para receber o código!');

        //dando um select na tabela de users buscando pelo email mockado
        $verifyEmailExists = User::where('email', $emailValue)->get();

        if (!$verifyEmailExists || count($verifyEmailExists) === 0) {
            return $this->RedirectBackError('Email não encontrado em nossas bases de dados :(');
        }

        $emailValidate = '';
        foreach ($verifyEmailExists as $e) {
            $emailValidate = $e['email'];
        };

        //gerando números aleatorios
        $numbers = implode('', [rand(0, 9), rand(0, 9), rand(0, 9), rand(0, 9), rand(0, 9), rand(0, 9)]);

        //array armazenando informações que serão utilizadas na view newLaravelTips
        $userMail = new stdClass();
        $userMail->name = 'Fernando';
        $userMail->email = $emailValidate;
        $userMail->numbers = $numbers;

        Mail::send(new newLaravelTips($userMail));
        User::where('email', $emailValidate)->update(['email_code' => $userMail->numbers]);

        //chamando função de redirect para quando for sucesso
        return $this->RedirectBackSuccess('Código de confirmação enviado para: ', $emailValue);
    }

    public function ForgetInfo(Request $request)
    {
        $emailValue = $request->input('email');

        //chamando função para validações, o parametro 'email' indica a condição interna da função, nesse caso, irá validar apenas o email(preenchimento obrigatório)
        $this->ValidateFields($request, 'email', 'Preencha o campo email para receber os dados esquecidos!');

        //dando um select na tabela de users buscando pelo email mockado
        $verifyEmailExists = User::where('email', $emailValue)->get();

        if (!$verifyEmailExists || count($verifyEmailExists) === 0) {
            return $this->RedirectBackError('Email não encontrado em nossas bases de dados :(');
        }

        $emailValidate = '';
        foreach ($verifyEmailExists as $e) {
            $emailValidate = $e['email'];
        };

        //informações que serão utilizadas na view
        $userMail = new stdClass();
        $userMail->name = 'Fernando';
        $userMail->email = $emailValidate; //$this->emailFixed;
        $userMail->verifyEmailExists = $verifyEmailExists;

        Mail::send(new forgetInfoTips($userMail));

        //chamando função de redirect para quando for sucesso
        return $this->RedirectBackSuccess('Informações do usuário enviadas para o email: ', $emailValue);
    }

    public function RedirectBackSuccess($message, $fieldInsideMessage)
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('success', $message . '<strong>' . $fieldInsideMessage . '</strong>');
    }

    public function RedirectBackError($message)
    {
        return redirect()
            ->back()
            ->withInput()
            ->withErrors([$message]);
    }

    public function ValidateFields($request, $field, $message)
    {

        if ($field == 'all') {
            return $request->validate(
                [
                    'email' => 'required|email',
                    //este é outro tipo de validação, pois no html existem validações de required e enfim, essas são para ter uma segunda opção de validar via Requisição(mensagens vermelhas no canto inferior)
                    'cpf1'  => 'required|digits:1',
                    'cpf2'  => 'required|digits:1',
                    'cpf3'  => 'required|digits:1',
                    'cpf4'  => 'required|digits:1',
                    'email_code' => 'required|digits:6'
                ],
                [
                    'email.required' => 'Email possui preenchimento obrigatório!',
                    'cpf1.required'  => '1º digito do CPF possui preenchimento obrigatório!',
                    'cpf2.required'  => '2º digito do CPF possui preenchimento obrigatório!',
                    'cpf3.required'  => '3º digito do CPF possui preenchimento obrigatório!',
                    'cpf4.required'  => '4º digito do CPF possui preenchimento obrigatório!',
                    'email_code.required' => 'Código enviado ao email possui preenchimento obrigatório!'
                ]
            );
        } else if ($field == 'email') {
            return $request->validate(
                [
                    'email' => 'required|email',
                ],
                [
                    'email.required' => $message,
                ]
            );
        }
    }
}
