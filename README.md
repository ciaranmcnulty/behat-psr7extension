# PSR-7 Behat Driver

This is a proof of concept to show that Behat can drive a PSR-7 application without going via a webserver

It's currently built by combining:

 * The existing Mink Browserkit driver, that can test a Symfony app
 * The existing Symfony to PSR-7 bridge, to translate requests and resources back and forth

... and integrating into a behat extension

## Usage

Install via composer and configure your behat.yml, specifying the php file that will bootstrap the app (see below):

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

Because there is no current standard interface for PSR-7-handling apps, you will need to select one of the following 
supported approaches.

## Zend Expressive applications

Your configuration file will need to return your application file, bootstrapped. For example:

```php
$container = require __DIR__ . '/../config/container.php';
return $container->get('Zend\Expressive\Application');
```

## Slim applications

Your configuration file will need to return your application file, bootstrapped. For example:

```php
<?php

$app = new \Slim\App;
// .. any necessary bootstrapping
return $app;
```

## All other PSR-7 applications

As long as you can write a function that takes a request and returns a response, you should be able to test your app. 
Your configuration file will need to return return a callable with the right signature. For example:

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

