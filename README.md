# PSR-7 Behat Driver

This is a proof of concept to show that Behat can drive a PSR-7 application without going via a webserver

It's currently built by combining:

 * The existing Mink Browserkit driver, that can test a Symfony app
 * The existing Symfony to PSR-7 bridge, to translate requests and resources back and forth

... and integrating into a behat extension

# Usage

Because there is no current standard interface for PSR-7-handling apps, you will need to create a function that can 
exercise your application.

```php
<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

// bootstrap your application
$app = new My\App();

return function (RequestInterface $request) use ($app) : ResponseInterface
{
    // exercise your application however you normally would
    return $app->handle($request);
};
```

Install via composer and configure your behat.yml, specifying the php file created in the step above:

```yaml
extensions:
  Cjm\Behat\Psr7Extension:
    app: %paths.base%/path/to/file.php
```

You can then also modify your MinkExtension configuration to use the PSR-7 driver, e.g.:

```yaml
extensions:
Behat\MinkExtension:
  base_url:  'http://localhost'
  sessions:
    default:
      psr7: ~
```
