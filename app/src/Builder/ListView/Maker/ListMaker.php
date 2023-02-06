<?php

namespace App\Builder\ListView\Maker;

use App\Builder\ListView\Builder\ListBulder;

class ListMaker {

    private ListBulder $_listBuilder;

    public function __construct(ListBulder $builder)
    {
        $this->_listBuilder = $builder;
    }

    public function makeList():array
    {
        return $this->_listBuilder->getListData();
    }

}
