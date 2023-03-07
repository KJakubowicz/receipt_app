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

    abstract public function addHeaderElement(): void;

    abstract public function setRows(): void;

    abstract public function addPaggination(): void;

    abstract public function setPerPage(): void;

    abstract public function getListData(): array;
}
