<?php

declare(strict_types=1);

namespace Anvil\TCPClient\Connection\Context;

abstract class Context
{
    /** @var resource  */
    protected $context;

    /** @var string  */
    protected $wrapper = 'socket';

    public function __construct(?array $context = null)
    {
        $this->context = stream_context_create($context);
    }

    /**
     * Sets the local address and port to bind the socket.
     */
    public function bindTo(string $value = null): self
    {
        stream_context_set_option($this->context, 'socket', 'bindto', $value);
        return $this;
    }

    /**
     * Enables or disables the Nagle algorithm for more efficient data transmission.
     */
    public function tcpNodelay(bool $value = true): self
    {
        stream_context_set_option($this->context, 'socket', 'tcp_nodelay', $value);
        return $this;
    }

    /**
     * Sets the maximum number of incoming connections that can be in the queue.
     */
    public function backlog(int $value = 128): self
    {
        stream_context_set_option($this->context, 'socket', 'backlog', $value);
        return $this;
    }

    /**
     * Enables or disables TCP keep-alive packets to maintain the connection.
     */
    public function tcpKeepAlive(bool $value = true): self
    {
        stream_context_set_option($this->context, 'socket', 'tcp_keepalive', $value);
        return $this;
    }

    /**
     * Sets the buffer size for receiving data on the socket.
     */
    public function receiveBufferSize(int $value = 4096): self
    {
        stream_context_set_option($this->context, 'socket', 'SO_RCVBUF', $value);
        return $this;
    }

    /**
     * Sets the timeout duration for socket operations.
     */
    public function timeout(int $seconds = 30): self
    {
        stream_context_set_option($this->context, 'socket', 'timeout', $seconds);
        return $this;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getWrapper(): string
    {
        return $this->wrapper;
    }
}