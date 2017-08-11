<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\ServiceContainer;

use Cjm\Behat\Psr7Extension\CachingLoader;
use Interop\Container\ContainerInterface;

class HelperContainer implements ContainerInterface
{
	/**
	 * @var CachingLoader
	 */
	protected $app;

	public function __construct(CachingLoader $app)
	{
		$this->app = $app;
	}

	public function get($id)
	{
		return $id == 'cjm.behat.psr7.caching_loader' ? $this->app : null;
	}

	public function has($id)
	{
		return $id == 'cjm.behat.psr7.caching_loader';
	}
}
