<?php

declare(strict_types=1);

namespace Anvil\TCPClient\Connection;


use Anvil\TCPClient\Connection\Context\UDPContext;

/**
 * @property UDPContext $context
 */
final class UDPConnection extends Connection
{
    public function __construct(string $host, ?UDPContext $context = null)
    {
        parent::__construct('udp://' . $host, $context ?? new UDPContext());
    }
}