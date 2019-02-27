<?php
declare(strict_types=1);

namespace Hladpe\NetteConfigFinder;

use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\InvalidStateException;
use Nette\Utils\Finder as NetteFinder;
use SplFileInfo;

class Finder
{
	private const CACHE_NAMESPACE = 'NetteConfigFinder';

	/**
	 * @var Configuration
	 */
	private $config;

	/**
	 * @var Cache
	 */
	private $cache;

	/**
	 * @param Configuration $config
	 * @param IStorage|null $storage
	 */
	public function __construct(Configuration $config, ?IStorage $storage = null)
	{
		$this->config = $config;

		if ($storage !== null) {
			$this->cache = new Cache($storage, static::CACHE_NAMESPACE);
		}
	}

	/**
	 * @return array
	 * @throws InvalidStateException
	 */
	public function find(): array
	{
		if ($this->cache === null) {
			return $this->search();
		}

		return $this->cache->load($this->getCacheKey(), function () {
			return $this->search();
		});
	}

	/**
	 * @return string
	 */
	private function getCacheKey(): string
	{
		return md5(
			serialize($this->config)
		);
	}

	/**
	 * @return array
	 * @throws InvalidStateException
	 */
	private function search(): array
	{
		$mask = $this->config->getFileMask();
		$dirs = $this->config->getPaths();

		$list = [];
		$finder = NetteFinder::findFiles($mask)->from($dirs);
		foreach ($finder as $file) {
		    /* @var SplFileInfo $file */
			$list[] = $file->getPathname();
		}
		return $list;
	}
}
