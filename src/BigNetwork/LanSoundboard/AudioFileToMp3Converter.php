<?php

namespace BigNetwork\LanSoundboard;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class AudioFileToMp3Converter
{

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
     * Find all non-mp3 files in the given folder.
     *
     * @return SplFileInfo[]
     */
    protected function findFiles()
    {
        return $this->getFinder()->files()->in($this->path)->notName('*.mp3');
    }

    /**
     * Run the command to convert a file to MP3
     *
     * @param SplFileInfo $file
     */
    protected function convertFile($file)
    {
        $source = $this->path . '/' . $file->getRelativePathname();
        $destination = $this->path . '/' . $file->getBasename('.' . $file->getExtension()) . ".mp3";

        $command = "ffmpeg -i " . escapeshellarg($source) . " " . escapeshellarg($destination);

        echo "  $command\n";

        $output = shell_exec($command);

        echo "  $output\n";
    }

    /**
     *
     *
     * @return null
     */
    public function run()
    {
        echo "=== BIG NETWORK AUDIO FILE TO MP3 CONVERTER ===\n";

        $files = $this->findFiles();

        if (count($files) == 0) {
            echo "No matching files found in folder: " . $this->path . "\n";
            return;
        }

        echo "Starting conversion of " . count($files) . " files:\n";

        foreach ($files as $file) {
            $this->convertFile($file);
        }

        echo "Conversion ended.\n";
    }

} 