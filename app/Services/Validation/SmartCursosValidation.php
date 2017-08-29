<?php namespace App\Services\Validation;
/**
 * Created by PhpStorm.
 * User: adhemar
 * Date: 30/09/2015
 * Time: 12:35
 */

use Illuminate\Validation\Validator;

class SmartCursosValidation extends Validator{
    //added only for test
    public function validateCpf($attribute, $value, $parameters)
    {
        $cpf = $value;
        // Verifica se um n�mero foi informado
        if(empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $cpf = preg_replace('/\D/', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados � igual a 11
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequ�ncias invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999') {
            return false;
            // Calcula os digitos verificadores para verificar se o
            // CPF � v�lido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    public function validateDiscount($attribute, $value, $parameters)
    {
        if(!empty($value) && ($value!=0) && array_get($this->data, $parameters[0])==0) {
            return true;
        }
        if(!empty(array_get($this->data, $parameters[0])) && array_get($this->data, $parameters[0])!=0 && $value==0) {
            return true;
        }
        else{
            return false;
        }

    }
}