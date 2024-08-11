<?php

namespace App\Actions;

use App\Actions\Actionable;

class CurrencyCast extends Actionable
{
    public function handle(...$arguments)
    {
        $pattern = '/[^\d\,\.]/';
        $previousChar = 'R$ '; 
        $value = $arguments[0];
        $lang = $arguments[1] ?? 'pt-br';

        if($lang === 'en') {
            $pattern = '/[^\d\.]/';
            $previousChar = '$ ';
        }

        if(is_string($value)) {
            $value = preg_replace($pattern, '', $value);
        }

        $value = number_format($value, 2, ',', '.');
        

        return  $previousChar . $value;
    }
}