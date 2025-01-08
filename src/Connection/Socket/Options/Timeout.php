<?php

declare(strict_types=1);

namespace Anvil\TCPClient\Connection\Socket\Options;

use Anvil\TCPClient\Connection\Context\Context;
use Anvil\TCPClient\Connection\Socket\SocketException;

final class Timeout
{
    /** @var Context */
    private $context;

    /** @var int  */
    private $timeout = 30;

    /** @var int  */
    private $oldTimeout = 30;

    /**
     * @throws SocketException
     */
    public function __construct(Context $context) {
        $this->context = $context;
        $this->setTimeout($this->timeout);
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @throws SocketException
     */
    public function setTimeout(int $timeout)
    {
        if(stream_context_set_option($this->context->getContext(), $this->context->getWrapper(), 'timeout', $timeout) === false){
            throw new SocketException("Error while setting timeout");
        }
        $this->oldTimeout = $this->timeout;
        $this->timeout = $timeout;
    }

    public function resetTimeout(): void
    {
        $this->timeout = $this->oldTimeout;
    }


}