<?php

declare(strict_types=1);

namespace AnvilM\Transport\Connection;

use AnvilM\Transport\Connection\Context\TCPContext;

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