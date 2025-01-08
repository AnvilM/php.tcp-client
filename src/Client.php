<?php

declare(strict_types=1);

namespace Anvil\TCPClient;

use Anvil\TCPClient\Connection\ConnectionException;
use Anvil\TCPClient\Connection\Context\TCPContext;
use Anvil\TCPClient\Connection\Context\TLSContext;
use Anvil\TCPClient\Connection\Context\UDPContext;
use Anvil\TCPClient\Connection\TCPConnection;
use Anvil\TCPClient\Connection\TLSConnection;
use Anvil\TCPClient\Connection\UDPConnection;

final class Client
{
    /**
     * @throws ConnectionException
     */
    public static function tls(string $host, ?TLSContext $tlsContext = null): TLSConnection
    {
        return new TLSConnection($host, $tlsContext);
    }

    /**
     * @throws ConnectionException
     */
    public static function tcp(string $host, ?TCPContext $tcpContext = null): TCPConnection
    {
        return new TCPConnection($host, $tcpContext);
    }

    /**
     * @throws ConnectionException
     */
    public static function udp(string $host, ?UDPContext $udpContext = null): UDPConnection
    {
        return new UDPConnection($host, $udpContext);
    }
}