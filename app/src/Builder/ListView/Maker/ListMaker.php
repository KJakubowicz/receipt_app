<?php

namespace App\Builder\ListView\Maker;

use App\Builder\ListView\Builder\ListBuilder;

class ListMaker {

    private ListBuilder $_listBuilder;

    public function __construct(ListBuilder $builder)
    {
        $this->_listBuilder = $builder;
    }

    public function makeList():array
    {
        return $this->_listBuilder->getListData();
    }

}
