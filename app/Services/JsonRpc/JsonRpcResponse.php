<?php

namespace App\Services\JsonRpc;

use App\Services\JsonRpc\JsonRpcError;

class JsonRpcResponse
{
    /** @var string */
    const VERSION = '2.0';

    /** @var DataError|mixed */
    protected $data;

    /** @var null|integer|string */
    protected $id;

    /**
     * @var $data DataError|mixed
     * @var $id null|integer|string
     *
     * @return self
     */
    static public function create($data, $id = null)
    {
        return (new self())->setData($data)->setId($id)->jsonSerialize();
    }

    static public function createError($message)
    {
        return (new self())->create(JsonRpcError::create($message));
    }

    public function jsonSerialize()
    {
        return [
            'jsonrpc' => self::VERSION,
            ($this->isError()
                ? 'error'
                : 'result') => $this->data,
            'id' => $this->id,
        ];
    }

    protected function isError()
    {
        return $this->data instanceof JsonRpcError;
    }

    protected function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    protected function setData($data)
    {
        $this->data = $data;
        return $this;
    }

}
