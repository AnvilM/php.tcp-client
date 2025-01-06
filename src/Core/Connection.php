<?php

declare(strict_types=1);

namespace Anvil\TCPClient\Core;

use Anvil\TCPClient\Core\Socket\Socket;
use Anvil\TCPClient\Core\Socket\SocketException;

final class Connection
{
    /** @var Socket */
    private $socket;

    /**
     * @throws ConnectionException
     */
    public function __construct(string $host, int $port)
    {
        try {
            $this->socket = new Socket($host, $port);
        } catch (SocketException $e) {
            throw new ConnectionException($e->getMessage());
        }
    }

    /**
     * @throws ConnectionException
     */
    public function open(): self
    {
        try {
            $this->socket->open();
        } catch (SocketException $e) {
            throw new ConnectionException($e->getMessage());
        }

        return $this;
    }

    /**
     * @throws ConnectionException
     */
    public function send(string $data, int $timeout = 5, int $length = null): self
    {
        if($this->socket->isClosed()){
            throw new ConnectionException("Send data before opening socket");
        }
        try {
            $this->socket->write($data, $timeout, $length);
        } catch (SocketException $e) {
            throw new ConnectionException($e->getMessage());
        }

        return $this;
    }

    /**
     * @throws ConnectionException
     */
    public function sendRequest(string $data, int $readLength, int $timeout = 5, int $writeLength = null, int $readMode = PHP_BINARY_READ): string
    {
        try {
            $this->send($data, $timeout, $writeLength);
            return $this->socket->read($readLength, $timeout, $readMode);
        } catch (SocketException $e) {
            throw new ConnectionException($e->getMessage());
        }
    }

    /**
     * @throws ConnectionException
     */
    public function readBinary(int $length, int $timeout = 5): string
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
    public function readString(int $length, int $timeout = 5): string
    {
        try {
            return $this->socket->read($length, $timeout, PHP_NORMAL_READ);
        } catch (SocketException $e) {
            throw new ConnectionException($e->getMessage());
        }
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

        return $this;
    }

    public function getSocket(): Socket
    {
        return $this->socket;
    }




}