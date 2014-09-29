<?php

namespace BigNetwork\LanSoundboard;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class AudioFileFinder
 *
 * Finds and returns a number of audio files in a given folder.
 *
 * @package BigNetwork\LanSoundboard
 */
class AudioFileFinder {

	protected $path = __DIR__;

	/**
	 * Constructor
	 *
	 * @param string $folderPath Path to where the audio files can be found.
	 */
	public function __construct($folderPath = __DIR__)
	{
		$this->path = $folderPath;
	}

	/**
	 * Get a Finder
	 *
	 * @return Finder
	 */
	protected function getFinder()
	{
		return new Finder();
	}

	/**
	 * @return SplFileInfo[]
	 */
	public function getFiles()
	{
		return $this->getFinder()->files()->in($this->path)->name('*.*')->sort(
			// Sort files by natural file name order:
			function (\SplFileInfo $a, \SplFileInfo $b)
			{
				return strnatcmp($a->getRealpath(), $b->getRealpath());
				//     ^------- strnatcmp() instead of strcmp()
			}
		);
	}
} 