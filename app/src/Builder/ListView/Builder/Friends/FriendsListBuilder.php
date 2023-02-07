<?php

namespace App\Builder\ListView\Builder\Friends;

use App\Builder\ListView\Builder\ListBuilder;

class FriendsListBuilder extends ListBuilder {

    public function addButton(array $button = []): void
    {
        $this->listView->addButton($button);
    }

    public function addHeaderElement(array $header = []): void
    {
        $this->listView->addHeader($header);
    }

    public function setRows(array $rows = []): void
    {
        $preparedRows = $this->prepareNumber($rows);
        $this->listView->setRows($preparedRows);
    }

    private function prepareNumber(array $rows): array
    {
        if (!empty($rows)) {
            $i = 1;
            foreach ($rows as &$row) {
                $row['NUMBER'] = $i;
                $i++;
            }
        }

        return $rows;
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
