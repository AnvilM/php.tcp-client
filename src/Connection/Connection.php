<?php

declare(strict_types=1);

namespace AnvilM\Transport\Connection;

use AnvilM\Transport\Connection\Context\Context;
use AnvilM\Transport\Connection\Socket\Socket;
use AnvilM\Transport\Connection\Socket\SocketException;

abstract class Connection
{
    /** @var Context */
    protected $context;

    /** @var string */
    protected $host;

    /** @var Socket */
    protected $socket;

    /**
     * @throws ConnectionException
     */
    public function __construct(string $host, Context $context){
        $this->context = $context;
        $this->host = $host;

        try {
            $this->socket = new Socket($host, $context);
        } catch (SocketException $e) {
            throw new ConnectionException($e->getMessage());
        }
    }

    /**
     * @throws ConnectionException
     */
    public function open(?float $timeout = null): self
    {
        try {
            $this->socket->open($timeout);
        } catch (SocketException $e) {
            throw new ConnectionException($e->getMessage());
        }

        return $this;
    }


    /**
     * @throws ConnectionException
     */
    public function close(): self
    {
        try {
            $this->socket->close();
        } catch (SocketException $e) {
            throw new ConnectionException($e->getMessage());
        }

        try {
            $this->socket = new Socket($this->host, $this->context);
        } catch (SocketException $e) {
            throw new ConnectionException($e->getMessage());
        }

        return $this;
    }

    /**
     * @throws ConnectionException
     */
    public function read(int $length = 1024, float $timeout = 30): string
    {
        try {
            return $this->socket->read($length, $timeout);
        } catch (SocketException $e) {
            throw new ConnectionException($e->getMessage());
        }
    }

    /**
     * @throws ConnectionException
     */
    public function write(string $data, float $timeout = 30, int $length = null): self
    {
        try {
            $this->socket->write($data, $timeout, $length);
        } catch (SocketException $e) {
            throw new ConnectionException($e->getMessage());
        }

        return $this;
    }

    public function getSocket(): Socket
    {
        return $this->socket;
    }

    public function getContext(): Context
    {
        return $this->context;
    }


}