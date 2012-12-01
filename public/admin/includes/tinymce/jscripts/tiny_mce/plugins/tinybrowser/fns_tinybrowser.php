<?php

// **************************RESIZE IMAGE TO GIVEN SIZE*****************************************
function ResizeImage($im,$maxwidth,$maxheight,$urlandname,$comp){
	$width = imagesx($im);
	$height = imagesy($im);
	if(($maxwidth && $width > $maxwidth) || ($maxheight && $height > $maxheight)){
		if($maxwidth && $width > $maxwidth){
			$widthratio = $maxwidth/$width;
			$RESIZEWIDTH=true;
		}
		if($maxheight && $height > $maxheight){
			$heightratio = $maxheight/$height;
			$RESIZEHEIGHT=true;
		}
		if($RESIZEWIDTH && $RESIZEHEIGHT){
			if($widthratio < $heightratio){
				$ratio = $widthratio;
			}else{
				$ratio = $heightratio;
			}
		}elseif($RESIZEWIDTH){
			$ratio = $widthratio;
		}elseif($RESIZEHEIGHT){
			$ratio = $heightratio;
		}
    	$newwidth = $width * $ratio;
        $newheight = $height * $ratio;
		if(function_exists("imagecopyresampled")){
      		$newim = imagecreatetruecolor($newwidth, $newheight);
      		imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		}else{
			$newim = imagecreate($newwidth, $newheight);
      		imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		}
        ImageJpeg ($newim,$urlandname,$comp);
		ImageDestroy ($newim);
	}else{
		ImageJpeg ($im,$urlandname,$comp);
	}
}

// **************************CHECK IMAGE TYPE AND CONVERT TO TEMP TYPE*****************************
function convert_image($imagetemp,$imagetype){

if($imagetype == "image/pjpeg" || $imagetype == "image/jpeg")
	{
	$cim1 = imagecreatefromjpeg($imagetemp);
	}
elseif($imagetype == "image/x-png" || $imagetype == "image/png")
	{
	$cim1 = imagecreatefrompng($imagetemp);
	}
elseif($imagetype == "image/gif")
	{
	$cim1 = imagecreatefromgif($imagetemp);
	}
return $cim1;
}

// **************************GENERATE FORM OPEN*****************************
function form_open($name,$class,$url,$parameters){
?><form name="<?php echo $name; ?>" class="<?php echo $class; ?>" method="post" action="<?php echo $url.$parameters; ?>">
<?php
}

// **************************GENERATE FORM SELECT ELEMENT*****************************
function form_select($options,$name,$label,$current){

?><label for="<?php echo $name; ?>"><?php echo $label; ?></label><select name="<?php echo $name; ?>">
<?php
$loopnum = count($options); 
for($i=0;$i<$loopnum;$i++)
	{
	$selected = ($options[$i][0] == $current ? ' selected' : ''); 
	echo '<option value="'.$options[$i][0].'"'.$selected.'>'.$options[$i][1].'</option>';
	}
?></select><?php
}

// **************************GENERATE FORM HIDDEN ELEMENT*****************************
function form_hidden_input($name,$value) {
?><input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
<?php
}

// **************************GENERATE FORM TEXT ELEMENT*****************************
function form_text_input($name,$label,$value,$size,$maxlength) {
?><label for="<?php echo $name; ?>"><?php echo $label; ?></label><input type="text" name="<?php echo $name; ?>" size="<?php echo $size; ?>" maxlength="<?php echo $maxlength; ?>" value="<?php echo $value; ?>" />
<?php
}

// **************************GENERATE FORM SUBMIT BUTTON*****************************
function form_submit_button($name,$label,$class) {
?><button class="<?php echo $class; ?>" type="submit" name="<?php echo $name; ?>"><?php echo $label; ?></button>
</form>
<?php
}

//********************************Returns True if Number is Odd**************************************
function IsOdd($num)
{
return (1 - ($num & 1));
}

//********************************Truncate Text to Given Length If Required***************************
function truncate_text($textstring,$length){
	if (strlen($textstring) > $length)
		{
		$textstring = substr($textstring,0,$length).'...';
		}
	return $textstring;
}

/**
 * Present a size (in bytes) as a human-readable value
 * 
 * @param int    $size        size (in bytes)
 * @param int    $precision    number of digits after the decimal point
 * @return string
 */
function bytestostring($size, $precision = 0) {
    $sizes = array('YB', 'ZB', 'EB', 'PB', 'TB', 'GB', 'MB', 'KB', 'B');
    $total = count($sizes);

    while($total-- && $size > 1024) $size /= 1024;
    return round($size, $precision).' '.$sizes[$total];
}

//********************************Return File MIME Type***************************
function returnMIMEType($filename)
    {
        preg_match("|\.([a-z0-9]{2,4})$|i", $filename, $fileSuffix);

        switch(strtolower($fileSuffix[1]))
        {
            case "js" :
                return "application/x-javascript";

            case "json" :
                return "application/json";

            case "jpg" :
            case "jpeg" :
            case "jpe" :
                return "image/jpg";

            case "png" :
            case "gif" :
            case "bmp" :
            case "tiff" :
                return "image/".strtolower($fileSuffix[1]);

            case "css" :
                return "text/css";

            case "xml" :
                return "application/xml";

            case "doc" :
            case "docx" :
                return "application/msword";

            case "xls" :
            case "xlt" :
            case "xlm" :
            case "xld" :
            case "xla" :
            case "xlc" :
            case "xlw" :
            case "xll" :
                return "application/vnd.ms-excel";

            case "ppt" :
            case "pps" :
                return "application/vnd.ms-powerpoint";

            case "rtf" :
                return "application/rtf";

            case "pdf" :
                return "application/pdf";

            case "html" :
            case "htm" :
            case "php" :
                return "text/html";

            case "txt" :
                return "text/plain";

            case "mpeg" :
            case "mpg" :
            case "mpe" :
                return "video/mpeg";

            case "mp3" :
                return "audio/mpeg3";

            case "wav" :
                return "audio/wav";

            case "aiff" :
            case "aif" :
                return "audio/aiff";

            case "avi" :
                return "video/msvideo";

            case "wmv" :
                return "video/x-ms-wmv";

            case "mov" :
                return "video/quicktime";

            case "zip" :
                return "application/zip";

            case "tar" :
                return "application/x-tar";

            case "swf" :
                return "application/x-shockwave-flash";

            default :
            if(function_exists("mime_content_type"))
            {
                $fileSuffix = mime_content_type($filename);
            }

            return "unknown/" . trim($fileSuffix[0], ".");
        }
    }

?>
