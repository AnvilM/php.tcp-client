<?php

declare(strict_types=1);

namespace Anvil\TCPClient\Core\Socket\Options;

use Anvil\TCPClient\Core\Socket\SocketException;

final class SendBuffer
{
    /** @var resource $socket */
    private $socket;

    private $buffer;

    /**
     * @throws SocketException
     */
    public function __construct($socket) {
        $this->socket = $socket;
        $this->setBuffer();
    }

    public function getBuffer(): int
    {
        return $this->buffer;
    }

    /**
     * @throws SocketException
     */
    public function setBuffer(int $buffer = 4096)
    {
        $this->buffer = $buffer;
        if(socket_set_option($this->socket, SOL_SOCKET, SO_SNDBUF, $buffer) === FALSE){
            throw new SocketException(socket_strerror(socket_last_error($this->socket)));
        }
    }


}