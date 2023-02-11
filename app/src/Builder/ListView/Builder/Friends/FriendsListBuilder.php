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
        $preparedRows = $this->prepareRows($rows);
        $this->listView->setRows($preparedRows);
    }

    private function prepareRows(array $rows): array
    {
        $result = [];
        
        if (!empty($rows)) {
            $i = 0;
            $rowNumber = 1;
            foreach ($rows as $row) {
                $temp = [];
                $temp[] = [
                    'type' => 'number',
                    'value' => $rowNumber
                ];
                foreach ($row as $key => $value) {
                    switch (strtolower($key)) {
                        case 'id':
                            $temp[] = [
                                'type' => 'data',
                                'value' => $value,
                            ];
                            break;
                        case 'id_owner':
                            $temp[] = [
                                'type' => 'id_owner',
                                'value' => $value,
                            ];
                            break;
                        default:
                            $temp[] = [
                                'type' => 'column',
                                'value' => $value,
                            ];
                            break;
                    }
                }
                $temp[] = [
                    'type' => 'options',
                    'class' => 'options-small',
                    'value' => [
                        [
                            'href' => '/friend/remove/'.$row['id'],
                            'icon' => 'fa-regular fa-square-minus',
                            'type' => 'remove red-label',
                        ]
                    ]
                ];
                $result[$i] = $temp;
                $rowNumber++;
                $i++;
            }
        }

        return $result;
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
