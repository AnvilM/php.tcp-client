<?php

declare(strict_types=1);

namespace Anvil\TCPClient;

use Anvil\TCPClient\Core\Connection;
use Anvil\TCPClient\Core\ConnectionException;

final class Client
{
    /**
     * @throws ConnectionException
     */
    public static function connect(string $host, int $port): Connection
    {
        return (new Connection($host, $port))->open();
    }
}