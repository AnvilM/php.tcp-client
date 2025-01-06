<?php

declare(strict_types=1);

namespace Anvil\TCPClient\Core\Socket\Options;

use Anvil\TCPClient\Core\Socket\SocketException;

final class Timeout
{
    /** @var resource $socket */
    private $socket;

    private $timeout;

    /**
     * @throws SocketException
     */
    public function __construct($socket) {
        $this->socket = $socket;
        $this->setTimeout();
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @throws SocketException
     */
    public function setTimeout(int $timeout = 0)
    {
        $this->timeout = $timeout;
        if(socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => $timeout, 'usec' => 0]) === FALSE){
            throw new SocketException(socket_strerror(socket_last_error($this->socket)));
        }
    }


}