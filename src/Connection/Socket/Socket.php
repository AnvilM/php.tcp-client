<?php

declare(strict_types=1);

namespace Anvil\TCPClient\Connection\Socket;

use Anvil\TCPClient\Connection\Context\Context;
use Anvil\TCPClient\Connection\Socket\Options\Timeout;

final class Socket
{
    /** @var Context */
    private $context;

    /** @var string */
    private $host;

    /** @var resource */
    private $socket;

    /** @var Timeout */
    public $timeout;

    /** @var bool  */
    private $closed = true;

    /**
     * @throws SocketException
     */
    public function __construct(string $host, Context $context)
    {
        $this->host = $host;
        $this->context = $context;

        try {
            $this->timeout = new Timeout($this->context);
        } catch (SocketException $e){
            throw new SocketException("Error while creating socket");
        }


    }

    /**
     * @throws SocketException
     */
    public function open(?int $timeout = null): self
    {
        if(!$this->isClosed()){
            throw new SocketException("Socket already opened");
        }

        $socket = stream_socket_client($this->host, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $this->context->getContext());
        if($socket === false){
            throw new SocketException("Error opening socket");
        }
        $this->socket = $socket;
        $this->closed = false;

        return $this;
    }

    /**
     * @throws SocketException
     */
    public function close(): self
    {
        if($this->isClosed()){
            throw new SocketException("Socket is closed");
        }

        fclose($this->socket);
        $this->closed = true;

        return $this;
    }

    /**
     * @throws SocketException
     */
    public function write(string $data, int $timeout = 30, int $length = null): self
    {
        if($this->isClosed()){
            throw new SocketException("Socket is closed");
        }

        $this->timeout->setTimeout($timeout);
        if(fwrite($this->socket, $data, $length) === false){
            $this->close();
            throw new SocketException("Error while writing to socket");
        }
        $this->timeout->resetTimeout();

        return $this;
    }

    /**
     * @throws SocketException
     */
    public function read(int $length = 1024, int $timeout = 30): string
    {
        if($this->isClosed()){
            throw new SocketException("Socket is closed");
        }


        $this->timeout->setTimeout($timeout);
        $data = fread($this->socket, $length);
        if($data === false){
            $this->close();
            throw new SocketException("Error while reading from socket");
        }
        $this->timeout->resetTimeout();

        return $data;
    }

    /**
     * @throws SocketException
     */
    public function enableCrypto(int $method = STREAM_CRYPTO_METHOD_TLS_CLIENT): self
    {
        if($this->isClosed()){
            throw new SocketException("Socket is closed");
        }

        stream_socket_enable_crypto($this->socket, true, $method);

        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function isClosed(): bool
    {
        return $this->closed;
    }





}