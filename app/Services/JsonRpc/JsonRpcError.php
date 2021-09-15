<?php

namespace App\Services\JsonRpc;

use JsonSerializable;

class JsonRpcError implements JsonSerializable
{

    const PARSE_ERROR = -32700;
    const INVALID_REQUEST = -32600;
    const METHOD_NOT_FOUND = -32601;
    const INVALID_PARAMS = -32602;
    const INTERNAL_ERROR = -32603;

    const MESSAGES = [
        self::PARSE_ERROR => 'Parse error',
        self::INVALID_REQUEST => 'Invalid Request',
        self::METHOD_NOT_FOUND => 'Method not found',
        self::INVALID_PARAMS => 'Invalid params',
        self::INTERNAL_ERROR => 'Internal error',
    ];

    /** @var int */
    protected $code;

    /** @var string|null */
    protected $message;

    /**
     * @var $code integer
     * @var $message null|string
     *
     * @return self
     */
    static public function create($code, $message = null)
    {
        $obj = new self();

        if (1 === func_num_args()) {
            $message = (isset(self::MESSAGES[$code])
                ? self::MESSAGES[$code]
                : self::MESSAGES[self::INTERNAL_ERROR]
            );
        }

        return $obj->setCode($code)
            ->setMessage($message);
    }

    protected function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    protected function getCode()
    {
        return $this->code;
    }

    protected function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    protected function getMessage()
    {
        return $this->message;
    }

    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
    
}
