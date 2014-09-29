<?php

namespace BigNetwork\LanSoundboard;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class AudioFileFinder {

	protected $path = __DIR__;
	protected $finder = null;

	public function __construct(Finder $finder, $folderPath = __DIR__)
	{
		$this->path = $folderPath;
		$this->finder = $finder;
	}

	/**
	 * @return SplFileInfo[]
	 */
	public function getFiles()
	{
		return $this->finder->files()->in($this->path)->name('*.*')->sort(
			// Sort files by natural file name order:
			function (\SplFileInfo $a, \SplFileInfo $b)
			{
				return strnatcmp($a->getRealpath(), $b->getRealpath());
				//     ^------- strnatcmp() instead of strcmp()
			}
		);
	}
} 