<?php

namespace App\Helper;

/**
 * FriendsHelper
 */
class FriendsHelper
{    
        
    /**
     * getChoisesForForm
     *
     * @param  mixed $choises
     * @param  mixed $emptyValue
     * @return array
     */
    public static function getChoisesForForm(array $choises, bool $emptyValue = true):array
    {
        $result = ($emptyValue) ? ['--Wybierz--' => ''] : [];

        foreach ($choises as $choise) {
            $tempName = $choise['name'].' '.$choise['surname'];
            $result[$tempName] = $choise['id'];
        }

        return $result;
    }
}
