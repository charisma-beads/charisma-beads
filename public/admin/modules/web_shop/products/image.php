<?php
ob_start('ob_gzhandler');
// The text to draw and set font.
$text = $_GET['txt'];

// Replace path by your own font path
$font = $_SERVER['DOCUMENT_ROOT'].'/admin/TTF/comicbd.ttf';
$font_size = 16;

// Set width & height.
$box = imagettfbbox ($font_size, 0, $font, $text);
$width = (abs($box[4]) - abs($box[0])) + 6;
$height = (abs($box[5]) - abs($box[1])) + 6;

// Create the image
$image = imagecreatetruecolor($width, $height);

if (isset($_GET['tc'])) {
	$tr = hexdec (substr ($_GET['tc'], 0, 2));
	$tg = hexdec (substr ($_GET['tc'], 2, 2));	
	$tb = hexdec (substr ($_GET['tc'], 4, 2));
}

// Create some colors
$br = hexdec (substr ($_GET['bg'], 0, 2));
$bg = hexdec (substr ($_GET['bg'], 2, 2));	
$bb = hexdec (substr ($_GET['bg'], 4, 2));
$background_color = imagecolorallocate($image, $br, $bg, $bb);

if (isset($_GET['tc'])) {
	$tr = hexdec (substr ($_GET['tc'], 0, 2));
	$tg = hexdec (substr ($_GET['tc'], 2, 2));	
	$tb = hexdec (substr ($_GET['tc'], 4, 2));
	$text_color = imagecolorallocate($image, $tr, $tg, $tb);
} else {
	$text_color = imagecolorallocate($image, 0x00, 0x9F, 0x3C);
}

imagefill ($image, 0, 0, $background_color);

// Set coordinates of text.
if ($text == "-") {
	$x = 1; // lower left of text
	$y = 9; // lower left of text
} else {
	$x = 2; // lower left of text
	$y = 18; // lower left of text
}

// Add the text
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $text);

// Set the content-type
header("Content-type: image/png");

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($image);
imagedestroy($image);
ob_end_flush();
?>