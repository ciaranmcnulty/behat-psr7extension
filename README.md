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

### Zend Expressive applications

Your configuration file will need to return your application file, bootstrapped. For example:

```php
$container = require __DIR__ . '/../config/container.php';
return $container->get('Zend\Expressive\Application');
```

### Slim applications

Your configuration file will need to return your application file, bootstrapped. For example:

```php
<?php

$app = new \Slim\App;
// .. any necessary bootstrapping
return $app;
```

### All other PSR-7 applications

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

## Injecting Your app inside your context

If for any reason your require ton inject your app inside your behat context, here is two way of doing it

### Dependency injection by configuration

You can inject some dependencies

```yaml
default:
  suites:
    default:
      # ...
      contexts:
        - YourFeatureContext:
            app: "@cjm.behat.psr7.caching_loader" # inject what's available in the container helper
      services: "@cjm.behat.psr7.helper" # load the helper
```

In your class `YourFeatureContext`, in the cosntructor you will have now a `Cjm\Behat\Psr7Extension\CachingLoader` instance. With this one
you can do `$loader->load()->getNativeApp()` to get an instance of a `callback`, `Slim\App` or `Zend\Expressive\Application`

### Using interface

You can also implements an interface `Cjm\Behat\Psr7Extension\ServiceContainer\AppAwareInterface` on your context.

```php
<?php

use Cjm\Behat\Psr7Extension\AppAwareInterface;
use Cjm\Behat\Psr7Extension\CachingLoader;
use Behat\Behat\Context\Context;

class YourFeatureContext implements AppAwareInterface, Context
{
	public function setCachingLoader(CachingLoader $loader)
	{
		$this->app = $loader->load()->getNativeApp();
		// in app you get a callback, a Slim\App, ...
	}
	
	// ...
}
```
