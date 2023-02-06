<?php

namespace App\Builder\ListView\Builder;

use App\Builder\ListView\List\ListView;

abstract class ListBulder {

    public ListView $listView;

    public function __construct()
    {
        $this->listView = new ListView();
    }

    abstract public function setAddButton(): void;

    abstract public function getAddButton(): array;

    abstract public function setCheckButton(): void;

    abstract public function getCheckButton(): array;

    abstract public function setHeader(): void;

    abstract public function getHeader(): array;

    abstract public function setRows(): void;

    abstract public function getRows(): array;

    abstract public function setPaggination(): void;

    abstract public function getPaggination(): int;

    abstract public function getListData(): array;
}
