<?php

namespace App\Builder\ListView\List;


class ListView {

    private array $_addButton;
    private array $_checkButton;
    private array $_header;
    private array $_rows;
    private int $_paggination;

    public function setAddButton(array $addButton):void
    {
        $this->_addButton = $addButton;
    }

    public function getAddButton():array
    {
        return $this->_addButton;
    }

    public function setCheckButton(array $checkButton):void
    {
        $this->_checkButton = $checkButton;
    }

    public function getCheckButton():array
    {
        return $this->_checkButton;
    }

    public function setHeader(array $header):void
    {
        $this->_header = $header;
    }

    public function getHeader():array
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
            'addButton' => $this->getAddButton(),
            'checkButton' => $this->getCheckButton(),
            'header' => $this->getHeader(),
            'rows' => $this->getRows(),
            'paggination' => $this->getPaggination(),
        ];
    }

}
