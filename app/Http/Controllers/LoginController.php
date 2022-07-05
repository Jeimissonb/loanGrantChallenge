<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
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
            ->where('email', $request->email)->first();
        if ($user) // se verdade existe um usuário com essas informações
        {
            Auth::login($user); //efetuando a operação de autenticação
            return Redirect('dados');
        } else {
            dd('Dados incorretos');
        }
    }

    public function SingOut()
    {
        $request = new Request();

        //$request->session()->flush();
        Auth::logout();

        return Redirect('');
    }
}
