<?php

namespace App\Serives;

/**
 * ResponseServices
 */
class ResponseServices
{
    private int $_status;
    private string $_message;
    private array $_data;
    
    /**
     * setStatus
     *
     * @param  mixed $status
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->_status = $status;
    }
    
    /**
     * getStatus
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->_status;
    }
    
    /**
     * setMessage
     *
     * @param  mixed $message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->_message = $message;
    }
    
    /**
     * getMessage
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->_message;
    }

    /**
     * setData
     *
     * @param  mixed $data
     * @return void
     */
    public function setData(array $data): void
    {
        $this->_data = $data;
    }
    
    /**
     * getData
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->_data;
    }

    public function getResponse(): array
    {
        return [
            'status' => $this->getStatus(),
            'message' => $this->getMessage(),
            'data' => $this->getData(),
        ];
    }
}
