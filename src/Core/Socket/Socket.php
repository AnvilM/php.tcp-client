<?php

declare(strict_types=1);

namespace Anvil\TCPClient\Core\Socket;

use Anvil\TCPClient\Core\Socket\Options\ReadBuffer;
use Anvil\TCPClient\Core\Socket\Options\SendBuffer;
use Anvil\TCPClient\Core\Socket\Options\Timeout;

final class Socket
{
    /** @var string  $host*/
    private $host;

    /** @var int  $port*/
    private $port;

    /** @var resource $socket */
    private $socket;

    /** @var ReadBuffer */
    public $readBuffer;

    /** @var SendBuffer */
    public $sendBuffer;

    /** @var Timeout */
    public $timeout;

    /** @var bool  */
    private $closed = true;

    /**
     * @throws SocketException
     */
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;

        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        $this->readBuffer = new ReadBuffer($this->socket);
        $this->sendBuffer = new SendBuffer($this->socket);
        $this->timeout = new Timeout($this->socket);

    }

    /**
     * @throws SocketException
     */
    public function open(int $timeout = 5)
    {
        if(!$this->isClosed()){
            throw new SocketException("Socket already opened");
        }

        $this->timeout->setTimeout($timeout);
        if(!socket_connect($this->socket, $this->host, $this->port)){
            $this->close();
            throw new SocketException(socket_strerror(socket_last_error($this->socket)));
        }
        $this->closed = false;
        $this->timeout->setTimeout();
    }

    /**
     * @throws SocketException
     */
    public function close()
    {
        if($this->isClosed()){
            throw new SocketException("Socket is closed");
        }

        socket_close($this->socket);
        $this->closed = true;
    }

    /**
     * @throws SocketException
     */
    public function write(string $data, int $timeout = 5, int $length = null)
    {
        if($this->isClosed()){
            throw new SocketException("Socket is closed");
        }

        if($length > strlen($data)) {
            $length = strlen($data);
        }

        $this->timeout->setTimeout($timeout);
        if(socket_write($this->socket, $data, $length) === FALSE){
            $this->close();
            throw new SocketException(socket_strerror(socket_last_error($this->socket)));
        }
        $this->timeout->setTimeout();
    }

    /**
     * @throws SocketException
     */
    public function read(int $length, int $timeout = 5, int $mode = PHP_BINARY_READ): string
    {
        if($this->isClosed()){
            throw new SocketException("Socket is closed");
        }

        $this->timeout->setTimeout($timeout);
        $data = socket_read($this->socket, $length, $mode);
        if($data === FALSE){
            $this->close();
            throw new SocketException(socket_strerror(socket_last_error($this->socket)));
        }
        $this->timeout->setTimeout();

        return $data;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function isClosed(): bool
    {
        return $this->closed;
    }





}