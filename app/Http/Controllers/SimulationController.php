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
        // Array associativo que vai para o DB
        $data = [
            'pretended_value' => $this->getAmount($request->pretended_value),
            'pretended_deadline' => $this->getAmount($request->pretended_deadline),
            'increased_value' => $this->getAmount($this->getAmount($this->CalculateIncreasedValue($request->pretended_value, $request->pretended_deadline))),
            'id_user' => Auth::user()->id,
            'saved' => $request->saved == "sim" ? true : false,
        ];

        $this->validations($request);



        //verificando se os registros existem no array e se nenhum deles é 0, caso seja então irá cair no else, onde ocorrerá um redirect com os erros
        if ($data && $data['pretended_value'] !== 0.0 && $data['pretended_deadline'] !== 0.0) {

            Simulation::where('id_user', Auth::user()->id)->update($data);

            echo '<script type="text/javascript">alert("Simulação salva com sucesso");</script>';
            return redirect()
                ->back()
                ->with('success', '<strong>' . 'Simulação salva com sucesso! ' . '</strong>');
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

        $increasedValue6 = null;
        $increasedValue12 = null;
        $increasedValue24 = null;
        $increasedValue36 = null;

        $installmentValue6 = null;
        $installmentValue12 = null;
        $installmentValue24 = null;
        $installmentValue36 = null;

        $selectedInstallment = '?';
        $selectedTotalValue = null;
        $selectedInstallValue = null;

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

        $this->validations($request);

        return redirect()
            ->back()
            ->with('installmentValue6', number_format($installmentValue6, 2))
            ->with('increasedValue6', $increasedValue6)
            ->with('installmentValue12', number_format($installmentValue12, 2))
            ->with('increasedValue12', $increasedValue12)
            ->with('installmentValue24', number_format($installmentValue24, 2))
            ->with('increasedValue24', $increasedValue24)
            ->with('installmentValue36', number_format($installmentValue36, 2))
            ->with('increasedValue36', $increasedValue36)
            ->with('selectedInstallment', $selectedInstallment)
            ->with('selectedTotalValue', $this->getAmount($selectedTotalValue))
            ->with('selectedInstallValue', $this->getAmount($selectedInstallValue))
            ->withInput();
        // return view('resultado', ["installmentValue" => $installmentValue]);
        // acima é outra forma de fazer, mas a pagina é atualizada assim :(
    }

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

    public function getAmount($money)
    {
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

        return (float) str_replace(',', '.', $removedThousandSeparator);
    }

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
