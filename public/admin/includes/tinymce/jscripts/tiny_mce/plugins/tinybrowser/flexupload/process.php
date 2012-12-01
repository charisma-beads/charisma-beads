<?php
require_once("../config_tinybrowser.php");

$upload_dir = $tinybrowser['path'][$_GET['type']];

  $files = array();
  $folder = $tinybrowser['docroot'].$upload_dir.$_GET['folder'].'/';
  if(!file_exists($folder)) Header('Location: ./flashUpload.php?type='.$_GET['type']);
  if ($handle = opendir($folder)) {
    while (false !== ($file = readdir($handle))) {
      if ($file != "." && $file != "..") {
        //-- File info
        $path_parts = pathinfo($file);
        $extension = $path_parts['extension']; unset($path_parts);
        
        //-- File Re/Naming
		  $filename = $file;
		  $tmp_filename = $folder.$file;
		  $img_filename = $upload_dir.$filename;
        
        //-- File Restrictions

        //-- Good mime-types (for image file types)
		  if($_GET['type']=='image')
			  {
	        $mime = getimagesize($tmp_filename);
	        $mime = $mime['mime'];
	        $types = array('image/jpeg', 'image/png', 'image/gif');
	        $mime  = validateMimeType($tmp_filename, $types);
	        if($mime === false) { unlink($tmp_filename); continue; }
			  }

        //-- Bad extensions
        if(!validateExtension($tmp_filename, $tinybrowser['prohibited'])) { unlink($tmp_filename); continue; }    
        
        //-- Copy the uploaded file to ?
        copy($tmp_filename, $tinybrowser['docroot'].$img_filename);
        //-- Remove our temp file
        unlink($tmp_filename);
      }
    }
    closedir($handle);
    //-- Remove out temp folder
    rmdir($folder);
  }
  
function validateMimeType($filename, $types) {
  $mime = getimagesize($filename);
  $mime = $mime['mime'];
  foreach($types as $type) {
    if($type == $mime) {
      return $mime;
    }
  }
  return false;
}

function validateExtension($extension, $types) {
  foreach($types as $type) {
    if($type == $extension) {
      return false;
    }
  }
  return true;
}
Header('Location: ./../tinybrowser.php?type='.$_GET['type']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Flash Upload</title>
	</head>
	<body>
		<p>Your files have been uploaded.</p>

	</body>
</html>
