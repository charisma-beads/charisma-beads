<?php
require_once("../config_tinybrowser.php");
require_once("../fns_tinybrowser.php");

if($tinybrowser['sessioncheck'])
	{
	if(!isset($_SESSION[$tinybrowser['sessioncheck']]))
		{
		echo 'You require permission to view this page.';
		exit;
		}
	}

if(!$tinybrowser['allowupload'])
	{
	echo 'You require upload permission to view this page.';
	exit;
	}

// determine file dialog file types
switch ($_GET['type'])
	{
	case 'image':
		$filestr = 'Images';
		break;
	case 'media':
		$filestr = 'Media';
		break;
	case 'file':
		$filestr = 'All Files';
		break;
	}
$fileexts = str_replace(",",";",$tinybrowser['filetype'][$_GET['type']]);
$filelist = $filestr.' ('.$tinybrowser['filetype'][$_GET['type']].')';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Tiny Browser</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $tinybrowser['tinymcecss']; ?>" />
<link rel="stylesheet" type="text/css" media="all" href="../style_tinybrowser.css.php" />
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript">
function uploadComplete(url) {
document.location = url;
}
</script>
</head>
<body onload='
      var so = new SWFObject("FlexUpload.swf", "mymovie", "600", "350", "9", "#ffffff");
      so.addVariable("folder", "<?php echo uniqid(rand(0, 1000)); ?>");
		so.addVariable("uptype", "<?php echo $_GET['type']; ?>");
		so.addVariable("maxsize", "<?php echo $tinybrowser['maxsize'][$_GET['type']]; ?>");
      so.addVariable("redirect", "process.php");
      so.addVariable("upload", "upload.php");
      so.addVariable("filenames", "<?php echo $filelist; ?>");
      so.addVariable("extensions", "<?php echo $fileexts; ?>");
      so.addParam("allowScriptAccess", "always");
      so.addParam("type", "application/x-shockwave-flash");
      so.write("flashcontent");'>
<div class="tabs">
<ul>
<li id="browse_tab"><span><a href="../tinybrowser.php?type=<?php echo $_GET['type']; ?>">Browse</a></span></li>
<li id="upload_tab" class="current"><span><a href="flashUpload.php?type=<?php echo $_GET['type']; ?>">Upload</a></span></li>
</ul>
</div>
<div class="panel_wrapper">
<div id="general_panel" class="panel currentmod">
<fieldset>
<legend>Upload Files</legend>
    <div id="flashcontent"></div>
</fieldset></div></div>
</body>
</html>
