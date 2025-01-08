<?php

declare(strict_types=1);

namespace AnvilM\Transport;

use AnvilM\Transport\Connection\ConnectionException;
use AnvilM\Transport\Connection\Context\TCPContext;
use AnvilM\Transport\Connection\Context\TLSContext;
use AnvilM\Transport\Connection\Context\UDPContext;
use AnvilM\Transport\Connection\TCPConnection;
use AnvilM\Transport\Connection\TLSConnection;
use AnvilM\Transport\Connection\UDPConnection;

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