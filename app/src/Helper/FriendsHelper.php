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
     * @return array
     */
    public static function getChoisesForForm(array $choises):array
    {
        $result = [];
        foreach ($choises as $choise) {
            $tempName = $choise['name'].' '.$choise['surname'];
            $result['choices'][$tempName] = $choise['id'];
        }

        return $result;
    }
}
