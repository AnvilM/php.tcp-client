## About
This package is a client for PHP sockets and allows establishing TCP and UDP connections.

**Supported protocols:**
- TCP
- UDP
- TLS

## Installation

You can install this package using Composer:

```bash
composer require anvilm/php.transport
```

## Basic Usage

### Create a client

#### TCP Client
Create a TCP client:

```php
use AnvilM\Transport\Client

$client = Client::tcp('example.com:80');
```

#### UDP Client
Create a UDP client:

```php
use AnvilM\Transport\Client

$client = Client::upd('example.com:80');
```

#### TLS Client
Create a TLS (SSL) client:

```php
use AnvilM\Transport\Client

$client = Client::tls('example.com:80');
```

### Open connection
To open a connection, use the open method:

```php
use AnvilM\Transport\Client

$client = Client::tcp('example.com:80');

$timeout = 3; // Timeout in seconds

$client->open($timeout);
```

### Send packets
To send packets, you can use the write method:

```php
use AnvilM\Transport\Client

$client = Client::tcp('example.com:80');

$data = 'hello'; // Data to send
$timeout = 30; // Write timeout
$length = strlen($data); // Length of data to send

// Open connection and send packet
$client->open()->write(pack('V', $data), $length);
```

### Read packets
To read received data, use the read method:

```php
use AnvilM\Transport\Client

$client = Client::tcp('example.com:80');

$length = 1024; // Length of data for read
$timeout = 30; // Timeout to wait for data from server

// Open connection and read data
$data = $client->open()->read($length, $timeout);
```

### Close connection
After closing the connection, you can immediately open a similar one, as a new socket is created upon closing.
```php
use AnvilM\Transport\Client

$client = Client::tcp('example.com:80')->open()
    ->close()
    ->open();
```

### Context
ВYou can also use a context if necessary. This code creates and sets parameters for stream_context_create. Currently, all context parameters are available for TCP, UDP, and TLS (SSL) connections.

You can also modify this context, as the context resource will be changed by reference.

```php
use AnvilM\Transport\Client
use AnvilM\Transport\Connection\Context\TLSContext;

$context = (new TLSContext())->timeout(5.5)
    ->verifyPeer(true)
    ->verifyPeerName(true);
        
$client = Client::tls('example.com:443', $context);

$client->open(); // Open with timeout 5.5

$context->timeout(10); // Set new timeout

$data = $client->read(); // Read data with new timeout
```



### Socket
You can get the socket object if you need manual connection management:

```php
use AnvilM\Transport\Client
use AnvilM\Transport\Connection\Socket\Socket;

$client = Client::tcp('example.com:443');

$socket = $client->getSocket();

$socket->open()->enableCrypto();
```