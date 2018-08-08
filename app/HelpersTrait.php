<?php

namespace App;

trait HelpersTrait
{

    /**
     * <b>email</b> 
     */
    public function email($email)
    {
        //regex do formato do e-mail
        $format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/ ';

        if(preg_match($format, $email))
        {
            return true;
        }

        return false;


    }

    /**
     * <b>formatDate</b> 
    */
    public function formatData($date)
    {
      
      
        $date = str_replace('/', '-', $date);
        

        return $date;
    }

    public function transformMinutos($hours)
    {
        $minutes = $hours * 60;
        return $minutes;
    }

    /**
     *<b>cpfOuCnPj</b> Realiza a validação de calculo do CPF ou CNPJ
     *
     * Regra de digito CPF:
     * Defini os multiplicadores dos digitos. 
     * De acordo com a regra, para se encontrar o 1º digito multiplica os 
     * 9 primeiros números de 10 ate 2
     * Já para se encontrar o 2º digito se multiplica os 10 primeiros números de 11 ate 2
     * 
     * Regra de digito CNPJ:
     * Defini os multiplicadores dos digitos. 
     * De acordo com a regra de validação do CNPJ, para se encontrar
     * o 1º Digito verificador multiplica-se os 12 primeiros números 
     * do CNPJ de 5 a 2 e depois continua a multiplicação de 9 a 2.
     * 
     * Já para o 2º Digito os 13 primeiros números 
     * do CNPJ de 6 a 2 e depois continua a multiplicação de 9 a 2.
    */
    public function cpfOuCnPj($value)
    {

        $size = ['cpf' => 11, 'cnpj' => 14];

        $multipliersCNPJ = [
            [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2],
            [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]
        ];
        
        $multipliersCPF = [
            [10, 9, 8, 7, 6, 5, 4, 3, 2],
            [11, 10, 9, 8, 7, 6, 5, 4, 3, 2]
        ];

        $multipliers = [];


        $value = preg_replace('/[^0-9]/', '', $value);

        $oneChar = substr($value, 0, 1);
        
        if(strlen($value) != $size['cpf'] && strlen($value) != $size['cnpj'])
        {
            return false;
        }

    
        if(str_repeat($oneChar, $size['cpf']) == $value)
        {
            return false;
        }

        if(str_repeat($oneChar, $size['cnpj']) == $value)
        {
            return false;
        }

       if(strlen($value) == 11)
       {
            $multipliers =  $multipliersCPF;
       }
       
       if(strlen($value) == 14)
       {
            $multipliers =  $multipliersCNPJ;
       }


       foreach ($multipliers as $multiplier) 
       {
            $sum = 0;
            $size = count($multiplier);
            for ($i = 0; $i < $size; $i++) {
                //Realiza a multiplicação e a soma 
                $sum += $value[$i] * $multiplier[$i];
            }
            
            $rest = $sum % 11;
            /*Valida os digitos verificadores*/
            $digit = ($rest < 2 ? 0 : 11 - $rest);
            if ($value[$size] != $digit) 
            {
                return false;
            }
        }

    return true;
      
    }

    /**
     * <b>messages</b>
     */
    public function messages($msg, $field = null)
    {

        $messages = [
            'msg_campo_obrigatorio' => "{$field} é obrigatório",
            'msg_campo_email'       => "Deve ser informado um e-mail valido",
            'msg_campo_numerico'    => "O campo {$field} é do tipo númerico",
            'msg_campo_unico'       => "Dados informados já foi cadastrado anteriormente",
            'msg_error'             => "Mensagem informada não existe!",
        ];

        if(in_array($messages[$msg]))
        {
            return $messages[$msg];
        }

        return $messages['msg_error'];
    }

   
}

