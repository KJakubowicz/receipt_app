<?php

namespace App\Builder\ListView\Builder\Paymants;

use App\Builder\ListView\Builder\ListBuilder;

class PaymansClearingListBuilder extends ListBuilder {

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
                        case 'id_owner':
                            $temp[] = [
                                'type' => 'id_owner',
                                'value' => $value,
                            ];
                            break;
                        case 'readed':
                        case 'id_user':
                        case 'id_friend':
                        case 'id':
                            $temp[] = [
                                'type' => 'data',
                                'value' => $value,
                            ];
                            break;
                        case 'status':
                            $temp[] = [
                                'type' => 'status',
                                'data' => [
                                    'type' => 'label',
                                    'value' => $value,
                                    'true' => [
                                        'label' => 'Opłacony',
                                        'class' => 'green-label'
                                    ],
                                    'false' => [
                                        'label' => 'Nieopłacony',
                                        'class' => 'red-label'
                                    ]
                                ]
                            ];
                            break;
                        case 'type':
                        case 'content':
                            $temp[] = [
                                'type' => 'column-xl',
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
                    'class' => 'options-basic',
                    'value' => [
                        [
                            'href' => '/payment/cleared/'.$row['id'],
                            'label' => 'Rozliczone',
                            'type' => 'accept green-label',
                        ],
                    ]
                ];
                $result[$i] = $temp;
                $rowNumber++;
                $i++;
            }
        }
        return $result;
    }

    public function addPaggination(array $paggination = []): void
    {
        $this->listView->addPaggination($paggination);
    }

    public function setPerPage(array $perPage = []): void
    {
        $this->listView->setPerPage($perPage);
    }

    public function getListData(): array
    {
        return $this->listView->getListData();
    }
}
