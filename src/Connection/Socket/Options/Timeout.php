<?php

declare(strict_types=1);

namespace AnvilM\Transport\Connection\Socket\Options;

use AnvilM\Transport\Connection\Context\Context;
use AnvilM\Transport\Connection\Socket\SocketException;

final class Timeout
{
    /** @var Context */
    private $context;

    /** @var float  */
    private $timeout = 30;

    /** @var float  */
    private $oldTimeout = 30;

    public function __construct(Context $context) {
        $this->context = $context;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @throws SocketException
     */
    public function setTimeout(float $timeout)
    {
        echo $timeout;
        if(stream_context_set_option($this->context->getContext(), $this->context->getWrapper(), 'timeout', $timeout) === false){
            throw new SocketException("Error while setting timeout");
        }
        $this->oldTimeout = $this->timeout;
        $this->timeout = $timeout;
    }

    /**
     * @throws SocketException
     */
    public function resetTimeout(): void
    {
        $this->setTimeout($this->oldTimeout);
    }


}