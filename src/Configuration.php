<?php
declare(strict_types=1);

namespace Hladpe\NetteConfigFinder;

class Configuration
{
	/**
	 * @var string
	 */
	private $fileMask = 'config*.neon';

	/**
	 * @var array
	 */
	private $paths = [];

	/**
	 * @return string
	 */
	public function getFileMask(): string
	{
		return $this->fileMask;
	}

    /**
     * @param string $fileMask
     * @return Configuration
     */
	public function setFileMask(string $fileMask): Configuration
	{
		$this->fileMask = $fileMask;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getPaths(): array
	{
		return $this->paths;
	}

	/**
	 * @param array $paths
	 * @return Configuration
	 */
	public function setPaths(array $paths): Configuration
	{
		$this->paths = $paths;
		return $this;
	}

	/**
	 * @param string $dir
	 * @return Configuration
	 */
	public function addPath(string $dir): Configuration
	{
		$this->paths[] = $dir;
		return $this;
	}
}
