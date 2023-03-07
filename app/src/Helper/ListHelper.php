<?php

namespace App\Helper;

/**
 * ListHelper
 */
class ListHelper
{

    /**
     * getChoisesForForm
     *
     * @param  mixed $choises
     * @param  mixed $emptyValue
     * @return array
     */
    public static function getPageCount(int $rowsCount, int $perPage):int
    {
        $perPage = ($perPage > 0) ? $perPage : 13;
        $pageCount = ceil($rowsCount/$perPage);
        
        return (int) $pageCount;
    }
}
