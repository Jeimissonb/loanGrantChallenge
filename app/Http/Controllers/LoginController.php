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
    protected $randomNumber;

    public function SingIn(Request $request)
    {

        $request->validate(
            [
                'email' => 'required|email',

                //outro tipo de validação, pois no html existem validações, essas são para ter uma segunda opção
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
            // retorna com redirect para a última rota, com Inputs do usuário e Mensagem de Erro
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['Credenciais não encontradas em nossas bases de dados :(']);
        }
    }

    public function SingOut()
    {

        //$request->session()->flush();
        $id = Auth::user()->id;
        User::where('id', $id)->update(['email_code' => '777777']);

        Auth::logout();

        return redirect()
            ->back();
    }

    public function SendMail(Request $request)
    {
        $emailValue = $request->input('email');

        $request->validate(
            [
                'email' => 'required|email',
            ],
            [
                'email.required' => 'Preencha o campo email para receber o código!',
            ]
        );

        //dando um select na tabela de users buscando pelo email mockado
        $verifyEmailExists = User::where('email', $emailValue)->get();

        if (!$verifyEmailExists || count($verifyEmailExists) === 0) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['Email não encontrado em nossas bases de dados :(']);
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

        return redirect()
            ->back()
            ->withInput()
            ->with('success', 'Código de confirmação enviado para: ' . '<strong>' . $emailValue . '</strong>');
    }

    public function ForgetInfo(Request $request)
    {
        $emailValue = $request->input('email');

        $request->validate(
            [
                'email' => 'required|email',
            ],
            [
                'email.required' => 'Preencha o campo email para receber os dados!',
            ]
        );

        //dando um select na tabela de users buscando pelo email mockado
        $verifyEmailExists = User::where('email', $emailValue)->get();

        if (!$verifyEmailExists || count($verifyEmailExists) === 0) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['Email não encontrado em nossas bases de dados :(']);
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

        return redirect()
            ->back()
            ->withInput()
            ->with('success', 'Informações do usuário enviadas para o email: ' . '<strong>' . $emailValue . '</strong>');
    }
}
