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
    protected $emailFixed = 'fernandoallgames2@outlook.com';
    
    protected $randomNumber;


    public function SingIn(Request $request)
    {
        // if(Auth::attempt(['email' => $request->email])) {
        //     dd('Você esta logado');
        // }else{
        //     dd('Você não esta logado');
        // }
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
        User::where('email', $this->emailFixed)->update(['email_code' => null]);
        Auth::logout();


        return Redirect('');
    }

    public function SendMail()
    {
        //gerando números aleatorios
        $numbers = implode('', [rand(0, 9), rand(0, 9), rand(0, 9), rand(0, 9), rand(0, 9), rand(0, 9)]);

        //informações que serão utilizadas na view
        $userMail = new stdClass();
        $userMail->name = 'Fernando';
        $userMail->email = 'dididantas000@gmail.com';
        $userMail->numbers = $numbers;

        //email mockado (setado de maneira fixa, precisamos pegar o que está sendo digitado)

        $this->randomNumber = $numbers;

        //dando um select na tabela de users buscando pelo email mockado
        $verifyEmailExists = User::where('email', $this->emailFixed);

        //logica para enviar email e atualizar a base de dados com o novo codigo
        if ($verifyEmailExists) {
            Mail::send(new newLaravelTips($userMail));
            User::where('email', $this->emailFixed)->update(['email_code' => $userMail->numbers]);
            return view('welcome');
        } else {
            return dd('Email: ', $this->emailFixed, ' não existe em nossa base');
        }
    }
}
