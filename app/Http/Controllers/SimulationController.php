<?php

namespace App\Http\Controllers;

use App\Models\Simulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimulationController extends Controller
{

    public function SendCalculate(Request $request)
    {
        // dd($request->pretended_value);
        // Array associativo para ser persistido no DB
        $data = [
            'pretended_value' => $this->getAmount($request->pretended_value),
            'pretended_deadline' => $this->getAmount($request->pretended_deadline),
            'increased_value' => $this->getAmount($this->getAmount($this->CalculateIncreasedValue($request->pretended_value, $request->pretended_deadline))),
            'id_user' => Auth::user()->id,
            'saved' => $request->saved == "sim" ? true : false,
        ];

        //chamando função de validações
        $this->validations($request);

        //verificando se os registros existem no array e se nenhum deles é 0, caso seja então irá cair no else, onde ocorrerá um redirect com os erros
        if ($data && $data['pretended_value'] !== 0.0 && $data['pretended_deadline'] !== 0.0) {
            $idFromUser = Auth::user()->id;
            $verifyExists = Simulation::where('id_user', $idFromUser);

            // dd($verifyExists);

            if ($verifyExists) {
                Simulation::where('id_user', $idFromUser)->update($data);
                // Simulation::where('id_user', Auth::user()->id)->update($data);
                echo '<script type="text/javascript">alert("Simulação salva com sucesso");</script>';
                return redirect()
                    ->back()
                    ->with('success', '<strong>' . 'Simulação salva com sucesso! ' . '</strong>');
            }

            Simulation::create($data);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['Verifique se os campos estão preenchidos / selecionados corretamente']);
        }


        // Insert dos registros com o metodo create
        // Dados persistidos no Banco de Dados
    }

    public function Calculate(Request $request)
    {
        $months = $request->input('pretended_deadline');
        $value = $request->input('pretended_value');

        //conjunto de variáveis que estão em utilização na view

        //conjunto de variaveis para os valores totais já com juros
        $increasedValue6 = null;
        $increasedValue12 = null;
        $increasedValue24 = null;
        $increasedValue36 = null;

        //conjunto de variaveis para os valores de cada parcela
        $installmentValue6 = null;
        $installmentValue12 = null;
        $installmentValue24 = null;
        $installmentValue36 = null;

        //conjunto de variaveis que indica, respectivamente, parcela selecionada no checkbox, valor total com base no que está selecionado e o valor da parcela selecionada;
        $selectedInstallment = '?';
        $selectedTotalValue = null;
        $selectedInstallValue = null;

        //if necessário para popular variáveis, caso o mês esteja selecionado
        if ($months) {
            $increasedValue6 = number_format((float)$value + ((float)$value  * 0.179), 3);
            $increasedValue12 = number_format((float)$value + ((float)$value  * 0.094), 3);
            $increasedValue24 = number_format((float)$value + ((float)$value  * 0.052), 3);
            $increasedValue36 = number_format((float)$value + ((float)$value  * 0.037), 3);

            $installmentValue6 = $increasedValue6 / 6;
            $installmentValue12 = $increasedValue12 / 12;
            $installmentValue24 = $increasedValue24 / 24;
            $installmentValue36 = $increasedValue36 / 36;
        }

        //esse switch é necessário pois precisa-se identificar qual modalidade de parcelamento está selecionada, e com isso, jogamo
        switch ($months) {
            case '6':
                $selectedInstallment = '6';
                $selectedTotalValue = $this->CalculateIncreasedValue($value, $selectedInstallment);

                $selectedInstallFloatValue = $this->getAmount($selectedTotalValue);
                $selectedInstallValue = number_format($selectedInstallFloatValue / 6, 2);
                break;

            case '12':
                $selectedInstallment = '12';
                $selectedTotalValue = $this->CalculateIncreasedValue($value, $selectedInstallment);

                $selectedInstallFloatValue = $this->getAmount($selectedTotalValue);
                $selectedInstallValue = number_format($selectedInstallFloatValue / 12, 2);
                break;
            case '24':
                $selectedInstallment = '24';
                $selectedTotalValue = $this->CalculateIncreasedValue($value, $selectedInstallment);

                $selectedInstallFloatValue = $this->getAmount($selectedTotalValue);
                $selectedInstallValue = number_format($selectedInstallFloatValue / 24, 2);
                break;
            case '36':
                $selectedInstallment = '36';
                $selectedTotalValue = $this->CalculateIncreasedValue($value, $selectedInstallment);

                $selectedInstallFloatValue = $this->getAmount($selectedTotalValue);
                $selectedInstallValue = number_format($selectedInstallFloatValue / 36, 2);
                break;
            default:
                $selectedInstallment = '?';
                break;
        }

        //chamando validações
        $this->validations($request);

        //redirecionando e empacotando variáveis para utilizar no front, já com valores devidamente formatados e prontos para serem chamados!
        return redirect()
            ->back()
            ->with('installmentValue6', number_format($installmentValue6, 3) < 1000 ? ltrim(number_format($installmentValue6, 3), '0.') : number_format($installmentValue6, 3))
            ->with('increasedValue6', $increasedValue6)
            ->with('installmentValue12', number_format($installmentValue12, 3) < 1000 ? ltrim(number_format($installmentValue12, 3), '0.') : number_format($installmentValue12, 3))
            ->with('increasedValue12', $increasedValue12)
            ->with('installmentValue24', number_format($installmentValue24, 3) < 1000 ? ltrim(number_format($installmentValue24, 3), '0.') : number_format($installmentValue24, 3))
            ->with('increasedValue24', $increasedValue24)
            ->with('installmentValue36', number_format($installmentValue36, 3) < 1000 ? ltrim(number_format($installmentValue36, 3), '0.') : number_format($installmentValue36, 3))
            ->with('increasedValue36', $increasedValue36)
            ->with('selectedInstallment', $selectedInstallment)
            ->with('selectedTotalValue', $this->getAmount($selectedTotalValue))
            ->with('selectedInstallValue', $this->getAmount($selectedInstallValue))
            ->withInput();
        // return view('resultado', ["installmentValue" => $installmentValue]);
        // acima é outra forma de fazer, mas a pagina é atualizada assim :(
    }

    //função para validações, pois assim evita-se repetir o mesmo código onde precisar das mesmas validações
    public function validations(Request $request)
    {
        $request->validate(
            [
                'pretended_deadline' => ['required'],

                'pretended_value' => ['required', function ($attribute, $value, $fail) {

                    $convertedString = $this->getAmount($value);

                    if ((float)$convertedString < 5000) {
                        $fail(' O valor pretendido deve ser maior que 5.000!');
                    } else if ((float)$convertedString > 50000) {
                        $fail(' O valor pretendido deve ser menor que 50.000!');
                        // $fail($attribute . ' O valor deve ser menor que 50.000!.'); <- $attribute representa o atributo que está recebendo validação, no caso iria aparecer na mensagem do front a seguinte mensagem: pretended_value O valor deve ser menor que 50.000!.
                    }
                },]
            ],
            [
                'pretended_value.required' => 'Preencha o valor pretendido!',
                'pretended_deadline.required' => 'Selecione uma modalidade de prazos'
            ]
        );
    }

    //função para pegar o valor de uma variável, em string, e converter para float já formatado através de funções regex, e com nomes de variáveis bem subjetivos
    public function getAmount($money)
    {
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

        return (float) str_replace(',', '.', $removedThousandSeparator);
    }

    //função para calcular o valor incrementado com base nas parcelas, utilizada em várias partes do código e evita repetições;
    public function CalculateIncreasedValue($pretendedValue, $pretendedDeadline)
    {
        $pretendedValueConverted = $this->getAmount($pretendedValue);

        switch ($pretendedDeadline) {
            case '6':
                return number_format($pretendedValueConverted + ($pretendedValueConverted  * 0.179), 2);
                break;
            case '12':
                return number_format($pretendedValueConverted + ($pretendedValueConverted  * 0.094), 2);
                break;
            case '24':
                return number_format($pretendedValueConverted + ($pretendedValueConverted  * 0.052), 2);
                break;
            case '36':
                return number_format($pretendedValueConverted + ($pretendedValueConverted  * 0.037), 2);
                break;
            default:
                return 0;
                break;
        }
        return 0;
    }
}
