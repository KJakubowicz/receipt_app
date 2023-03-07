<?php

namespace App\Builder\ListView\List;


class ListView {

    private array $_button = [];
    private array $_header = [];
    private array $_rows;
    private array $_paggination = [];
    private array $_perPage = [];

    public function addButton(array $button):void
    { 
        if (!empty($button)) {
            $this->_button[] = $button;
        }
    }

    public function getButtons():array
    {
        return $this->_button;
    }

    public function addHeader(array $header):void
    {
        if (!empty($header)) {
            $this->_header[] = $header;
        }
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

    public function addPaggination(array $paggination):void
    {
        if (!empty($paggination)) {
            $this->_paggination[] = $paggination;
        }
    }

    public function getPaggination():array
    {
        return $this->_paggination;
    }

    public function setPerPage(array $perPage):void
    {
        $this->_perPage = $perPage;
    }

    public function getPerPage():array
    {
        return $this->_perPage;
    }

    public function getListData():array
    {
        return [
            'buttons' => $this->getButtons(),
            'headers' => $this->getHeaders(),
            'rows' => $this->getRows(),
            'paggination' => $this->getPaggination(),
            'per_page' => $this->getPerPage(),
        ];
    }

}
