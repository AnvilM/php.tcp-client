<?php

declare(strict_types=1);

namespace Anvil\TCPClient\Connection;

use Anvil\TCPClient\Connection\Context\TCPContext;

/**
 * @property TCPContext $context
 */
final class TCPConnection extends Connection
{
    public function __construct(string $host, ?TCPContext $context = null)
    {
        parent::__construct('tcp://' . $host, $context ?? new TCPContext());
    }
}