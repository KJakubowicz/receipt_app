<?php

namespace App\Builder\ListView\Builder\Friends;

use App\Builder\ListView\Builder\ListBuilder;

class FriendsListBuilder extends ListBuilder {

    public function addButton(array $button = []): void
    {
        $this->listView->addButton($button);
    }

    public function setHeader(array $header = []): void
    {
        $this->listView->setHeader($header);
    }

    public function setRows(array $rows = []): void
    {
        $this->listView->setRows($rows);
    }

    public function setPaggination(int $paggination = 0): void
    {
        $this->listView->setPaggination($paggination);
    }

    public function getListData(): array
    {
        return $this->listView->getListData();
    }
}
