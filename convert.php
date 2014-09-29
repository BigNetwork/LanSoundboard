<?php
/**
 * Convert a folder of .CAF audio files to .MP3
 *
 * Note: CAF decoder required. Probably only works on a Mac.
 */

include_once('vendor/autoload.php');
include_once('src/BigNetwork/LanSoundboard/AudioFileToMp3Converter.php');

$converter = new \BigNetwork\LanSoundboard\AudioFileToMp3Converter(__DIR__ . '/sounds');
$converter->run();