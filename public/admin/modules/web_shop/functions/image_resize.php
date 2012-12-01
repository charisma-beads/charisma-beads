<?php
function easyResize($img_source, $save_to, $quality, $width, $str) {
	$size = GetImageSize($img_source);
   	$im_in = ImageCreateFromJPEG($img_source);
  
  	$new_height = ($width * $size[1]) / $size[0]; // Generate new height for image
   	$im_out = imagecreatetruecolor($width, $new_height);
  
   	ImageCopyResampled($im_out, $im_in, 0, 0, 0, 0, $width, $new_height, $size[0], $size[1]);
      
   	#Find X & Y for note
   	$X_var = ImageSX($im_out);
   	$X_var = $X_var - 130;
   	$Y_var = ImageSY($im_out);
   	$Y_var = $Y_var - 25;

   	#Color
   	$white = ImageColorAllocate($im_out, 0, 0, 0);
  
   	#Add note(simple: site address)
   	ImageString($im_out,2,$X_var,$Y_var,$str,$white);

   	ImageJPEG($im_out, $save_to, $quality); // Create image
   	ImageDestroy($im_in);
   	ImageDestroy($im_out);
}
?>