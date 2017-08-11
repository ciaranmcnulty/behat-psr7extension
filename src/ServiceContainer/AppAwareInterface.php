<?php

namespace Cjm\Behat\Psr7Extension\ServiceContainer;

use Cjm\Behat\Psr7Extension\CachingLoader;

interface AppAwareInterface
{
	public function setCachingLoader(CachingLoader $loader);
}
