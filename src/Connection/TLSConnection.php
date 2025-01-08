<?php

declare(strict_types=1);

namespace Anvil\TCPClient\Connection;

use Anvil\TCPClient\Connection\Context\TLSContext;

/**
 * @property TLSContext $context
 */
final class TLSConnection extends Connection
{

    public function __construct(string $host, ?TLSContext $context = null)
    {
        parent::__construct('tls://' . $host, $context ?? new TLSContext());
    }
}