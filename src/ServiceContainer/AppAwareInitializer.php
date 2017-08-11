<?php

namespace Cjm\Behat\Psr7Extension\ServiceContainer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use Cjm\Behat\Psr7Extension\CachingLoader;

class AppAwareInitializer implements ContextInitializer
{
	public function __construct(CachingLoader $loader)
	{
		$this->loader = $loader;
	}

	/**
	 * Initializes provided context.
	 *
	 * @param Context $context
	 */
	public function initializeContext(Context $context)
	{
		if (!$context instanceof AppAwareInterface)
		{
			return;
		}

		$context->setCachingLoader($this->loader);
	}
}
