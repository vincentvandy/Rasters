<?php

// header ('Content-type:image/gif');
include('GIFEncoder.class.php');

for( $i=9; $i>0;$i--)
{
	// Open the first source image and add the text.
	$image = imagecreatefrompng('tmp/test'.$i.'.png');

	// Generate GIF from the $image
	// We want to put the binary GIF data into an array to be used later,
	//  so we use the output buffer.
	
	ob_start();
	imagegif($image);
	$frames[]=ob_get_contents();
	$framed[]=40; // Delay in the animation.
	ob_end_clean();
}

// Generate the animated gif and output to screen.
$gif = new GIFEncoder($frames,$framed,0,2,0,0,0,'bin');
// echo $gif->GetAnimation();

$items=scandir('gif');
foreach ($items as $key => $value) {
	$nbr= $key;
}

$fp = fopen('gif/animegif'.$nbr.'.gif', 'w');
fwrite($fp, $gif->GetAnimation());
fclose($fp);
header("location: gif/animegif".$nbr.".gif")
?>