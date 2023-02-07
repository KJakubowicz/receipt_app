<?php

namespace App\Builder\ListView\List;


class ListView {

    private array $_button;
    private array $_header;
    private array $_rows;
    private int $_paggination;

    public function addButton(array $button):void
    {
        $this->_button[] = $button;
    }

    public function getButtons():array
    {
        return $this->_button;
    }

    public function addHeader(array $header):void
    {
        $this->_header[] = $header;
    }

    public function getHeaders():array
    {
        return $this->_header;
    }

    public function setRows(array $rows):void
    {
        $this->_rows = $rows;
    }

    public function getRows():array
    {
        return $this->_rows;
    }

    public function setPaggination(int $paggination):void
    {
        $this->_paggination = $paggination;
    }

    public function getPaggination():int
    {
        return $this->_paggination;
    }

    public function getListData():array
    {
        return [
            'buttons' => $this->getButtons(),
            'headers' => $this->getHeaders(),
            'rows' => $this->getRows(),
            'paggination' => $this->getPaggination(),
        ];
    }

}
