<?php

include_once('vendor/autoload.php');
include_once('src/BigNetwork/LanSoundboard/AudioFileFinder.php');

use \BigNetwork\LanSoundboard\AudioFileFinder;
use \Symfony\Component\Finder\Finder;

$audioFileFinder = new AudioFileFinder(__DIR__ . '/sounds');
$audioFiles = $audioFileFinder->getFiles();

$sounds = array();

foreach ($audioFiles as $audioFile) {
	// Get basename without file extension:
	$basename = $audioFile->getBasename('.' . $audioFile->getExtension());

	$name = '';
	if (($pos = strpos($basename, "_")) !== FALSE) {
		$name = substr($basename, $pos+1);
	}

	$sound = array(
		'number' => stristr($audioFile->getFilename(), '_', true),
		'name' => $name,
		'src' => 'sounds/' . $audioFile->getRelativePathname()
	);
	$sounds[] = $sound;
}

?>
<html>
	<head>
		<title>LanSoundboard</title>
		<meta property="og:image" content="icon.png" />
		<style type="text/css">
			html{
				font-family: Helvetica, Arial, sans-serif;
			}
			#soundboard{

			}
			.soundboard__button{
				background: #00adef;
				color: #fff;
				padding: 20px 20px;
				text-align: center;
				height: 200px;
				width: 175px;
				margin: 10px;
				border: none;
				float: left;
				font-weight: bold;
			}
			.soundboard__button__number{
				display: block;
				font-size: 96px;
			}
			.soundboard__button__name{
				font-size: 16px;
			}
			@-webkit-keyframes spaceboots {
				0% { -webkit-transform: translate(2px, 1px) rotate(0deg); }
				10% { -webkit-transform: translate(-1px, -2px) rotate(-1deg); }
				20% { -webkit-transform: translate(-3px, 0px) rotate(1deg); }
				30% { -webkit-transform: translate(0px, 2px) rotate(0deg); }
				40% { -webkit-transform: translate(1px, -1px) rotate(1deg); }
				50% { -webkit-transform: translate(-1px, 2px) rotate(-1deg); }
				60% { -webkit-transform: translate(-3px, 1px) rotate(0deg); }
				70% { -webkit-transform: translate(2px, 1px) rotate(-1deg); }
				80% { -webkit-transform: translate(-1px, -1px) rotate(1deg); }
				90% { -webkit-transform: translate(2px, 2px) rotate(0deg); }
				100% { -webkit-transform: translate(1px, -2px) rotate(-1deg); }
			}
			.shake:hover,
			.shake:focus {
				-webkit-animation-name: spaceboots;
				-webkit-animation-duration: 0.8s;
				-webkit-transform-origin:50% 50%;
				-webkit-animation-iteration-count: infinite;
				-webkit-animation-timing-function: linear;
			}
			.shake {
				display: inline-block;
				background-color: #008bc8;
			}
			#footer {
				clear: both;
				font-size: 12px;
				padding-top: 50px;
				text-align: center;
			}
		</style>
	</head>
	<body>

<div id="soundboard"></div>

<div id="footer">
Detta &auml;r ett scene-bidrag fr&aring;n MPV &amp; Sporki till lanpartyt SummerGate14. Koden finns h&auml;r: <a href="http://www.github.com/bignetwork/LanSoundboard/">github.com/bignetwork/LanSoundboard</a>.
</div>

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/react/react.min.js"></script>
<script type="application/javascript">
	var sounds = <?php echo json_encode($sounds); ?>;
	var preloadedSounds = [];
	var playingSounds = [];

	/**
	 * Preload sounds
	 */
	$(document).ready( function () {
		$(sounds).each(function(i, soundFile) {
			// Create pre-buffered sounds (buffers automatically when created)
			preloadedSounds.push(new Audio(soundFile.src));

			// Create a button for each sound:
			$("#soundboard").append(
				'<button class="soundboard__button" id="soundboard__button__' + i + '" onclick="playSound('+ i +')">' +
					'<span class="soundboard__button__number">' + soundFile.number + '</span>' +
					'<span class="soundboard__button__name">' + soundFile.name + '</span>' +
				'</button>'
			);
		});
	});

	/**
	 * Play a preloaded sound.
	 *
	 * @param index
	 */
	playSound = function (index) {
		var clonedSound = preloadedSounds[index].cloneNode();
		clonedSound.play();

		// Enable button "playing" effect (and remember how many concurrent sounds it's playing):
		$('#soundboard__button__' + index).addClass('shake');
		if (playingSounds[index] === undefined) {
			playingSounds[index] = 1;
		} else {
			playingSounds[index] = playingSounds[index] + 1;
		}

		clonedSound.onended = function() {
			$(clonedSound).remove();

			// Disable button "playing" effect when none of this sound is playing anymore:
			playingSounds[index] = playingSounds[index] - 1;
			if (playingSounds[index] == 0) {
				$('#soundboard__button__' + index).removeClass('shake');
			}
		}
	}

</script>

<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-1094632-2', 'auto');
	ga('require', 'displayfeatures');
	ga('send', 'pageview');

</script>

	</body>
</html>
