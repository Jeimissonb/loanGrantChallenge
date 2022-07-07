<?php

namespace App\Http\Controllers;

use App\Mail\newLaravelTips;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use stdClass;

class LoginController extends Controller

{
    protected $emailFixed = 'fernando-danatas@hotmail.com' || '';

    protected $randomNumber;


    public function SingIn(Request $request)
    {

        $user = User::whereRaw('SUBSTRING(cpf, 1, 1) = ' . $request->cpf1)
            ->whereRaw('SUBSTRING(cpf, 2, 1) = ' . $request->cpf2)
            ->whereRaw('SUBSTRING(cpf, 3, 1) = ' . $request->cpf3)
            ->whereRaw('SUBSTRING(cpf, 4, 1) = ' . $request->cpf4)
            ->where('email_code', $request->email_code)
            ->where('email', $request->email)->first();

        if ($user) // se verdade existe um usuário com essas informações
        {
            Auth::login($user); //efetuando a operação de autenticação
            return Redirect('dados');
        } else {
            echo ('Dados incorretos');
        }
    }

    public function SingOut(Request $request)
    {

        //$request->session()->flush();
        $id = Auth::user()->id;
        User::where('id', $id)->update(['email_code' => '777777']);

        Auth::logout();

        return Redirect::back()->with('message', 'Operation Successful !');;
    }

    public function SendMail(Request $request)
    {
        $emailValue = $request->input('email');

        //dando um select na tabela de users buscando pelo email mockado
        $verifyEmailExists = User::where('email', $emailValue)->get();

        if (!$verifyEmailExists || count($verifyEmailExists) === 0) {
            echo "<script>
            alert('Email não encontrado no banco de dados!')
            </script>";
            return view('welcome');
        }
        $emailValidate = '';
        foreach ($verifyEmailExists as $e) {
            $emailValidate = $e['email'];
        };


        //logica para enviar email e atualizar a base de dados com o novo codigo

        //gerando números aleatorios
        $numbers = implode('', [rand(0, 9), rand(0, 9), rand(0, 9), rand(0, 9), rand(0, 9), rand(0, 9)]);

        //informações que serão utilizadas na view
        $userMail = new stdClass();
        $userMail->name = 'Fernando';
        $userMail->email = $emailValidate; //$this->emailFixed;
        $userMail->numbers = $numbers;

        //email mockado (setado de maneira fixa, precisamos pegar o que está sendo digitado)

        $this->randomNumber = $numbers;
        //passando o email fixo.
        Mail::send(new newLaravelTips($userMail));
        User::where('email', $emailValidate)->update(['email_code' => $userMail->numbers]);
        echo "<script>
            alert('Email Enviado com sucesso!')
            </script>";
        return view('welcome');
    }
}
