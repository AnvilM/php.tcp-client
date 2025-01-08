<?php

declare(strict_types=1);

namespace Anvil\TCPClient\Connection\Context;


final class TLSContext extends Context
{

    public function __construct(?array $context = null)
    {
        parent::__construct($context);
        $this->wrapper = 'ssl';
    }

    /**
     * Enables or disables verification of the peer's certificate.
     */
    public function verifyPeer(bool $value = false): self
    {
        stream_context_set_option($this->context, 'ssl', 'verify_peer', $value);
        return $this;
    }

    /**
     * Enables or disables verification of the peer's name in the certificate.
     */
    public function verifyPeerName(bool $value = true): self
    {
        stream_context_set_option($this->context, 'ssl', 'verify_peer_name', $value);
        return $this;
    }

    /**
     * Allows or disallows self-signed certificates.
     */
    public function allowSelfSigned(bool $value = false): self
    {
        stream_context_set_option($this->context, 'ssl', 'allow_self_signed', $value);
        return $this;
    }

    /**
     * Specifies the path to the CA file used for certificate validation.
     */
    public function cafile(string $value = null): self
    {
        stream_context_set_option($this->context, 'ssl', 'cafile', $value);
        return $this;
    }

    /**
     * Specifies the path to the directory containing CA certificates.
     */
    public function capath(string $value = null): self
    {
        stream_context_set_option($this->context, 'ssl', 'capath', $value);
        return $this;
    }

    /**
     * Sets the certificate for the local side (client or server).
     */
    public function localCert(string $value = null): self
    {
        stream_context_set_option($this->context, 'ssl', 'local_cert', $value);
        return $this;
    }

    /**
     * Specifies the path to the private key for the local side (client or server).
     */
    public function localPk(string $value = null): self
    {
        stream_context_set_option($this->context, 'ssl', 'local_pk', $value);
        return $this;
    }

    /**
     * Sets the passphrase for the private key (if the key is encrypted).
     */
    public function passphrase(string $value = null): self
    {
        stream_context_set_option($this->context, 'ssl', 'passphrase', $value);
        return $this;
    }

    /**
     * Enables or disables the use of Server Name Indication (SNI).
     */
    public function SNIEnabled(bool $value = true): self
    {
        stream_context_set_option($this->context, 'ssl', 'SNI_enabled', $value);
        return $this;
    }

    /**
     * Sets the server name for verification, used with SNI.
     */
    public function peerName(string $value = null): self
    {
        stream_context_set_option($this->context, 'ssl', 'peer_name', $value);
        return $this;
    }

    /**
     * Captures the peer's certificate for further analysis.
     */
    public function capturePeerCert(bool $value = false): self
    {
        stream_context_set_option($this->context, 'ssl', 'capture_peer_cert', $value);
        return $this;
    }

    /**
     * Captures the full certificate chain of the peer for further analysis.
     */
    public function capturePeerCertChain(bool $value = false): self
    {
        stream_context_set_option($this->context, 'ssl', 'capture_peer_cert_chain', $value);
        return $this;
    }

    /**
     * Specifies the cryptographic methods and protocols used (e.g., TLS versions).
     */
    public function cryptoMethod(int $value = 65): self
    {
        stream_context_set_option($this->context, 'ssl', 'crypto_method', $value);
        return $this;
    }



}