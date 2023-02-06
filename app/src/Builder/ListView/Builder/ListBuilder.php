<?php

namespace App\Builder\ListView\Builder;

use App\Builder\ListView\List\ListView;

abstract class ListBuilder {

    public ListView $listView;

    public function __construct()
    {
        $this->listView = new ListView();
    }

    abstract public function addButton(): void;

    abstract public function setHeader(): void;

    abstract public function setRows(): void;

    abstract public function setPaggination(): void;

    abstract public function getListData(): array;
}
