<?php
require_once("config_tinybrowser.php");
require_once("fns_tinybrowser.php"); 

if($tinybrowser['sessioncheck'])
	{
	if(!isset($_SESSION[$tinybrowser['sessioncheck']]))
		{
		echo 'You require permission to view this page.';
		exit;
		}
	}
$viewpath = $tinybrowser['path'][$_GET['type']];

// Assign browsing options
$sortbynow = ($_POST['sortby'] ? $_POST['sortby'] : $tinybrowser['order']['by']);
$sorttypenow = ($_POST['sorttype'] ? $_POST['sorttype'] : $tinybrowser['order']['type']);
$viewtypenow = ($_POST['viewtype'] ? $_POST['viewtype'] : $tinybrowser['view']['image']);
$findnow = ($_POST['find'] != '' ? $_POST['find'] : false);

// Delete any checked files
if(isset($_POST['delfile']))
	{
	foreach($_POST['delfile'] as $delthis => $val)
		{
		$delthisfull = $tinybrowser['docroot'].$viewpath.$delthis;
		if (file_exists($delthisfull)) unlink($delthisfull);
		$delthisthumb = $tinybrowser['docroot'].$viewpath."/thumbs/_".$delthis;
		if (file_exists($delthisthumb)) unlink($delthisthumb);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Tiny Browser</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script language="javascript" type="text/javascript" src="../../tiny_mce_popup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style_tinybrowser.css.php" />
</head>
<body>
<script type="text/javascript">
function selectURL(url)
{
	document.passform.fileurl.value = url;
	FileBrowserDialogue.mySubmit();
}
var FileBrowserDialogue = {
    init : function () {
        // Here goes your code for setting your custom things onLoad.
    },
    mySubmit : function () {
 		  var URL = document.passform.fileurl.value;
        var win = tinyMCEPopup.getWindowArg("window");

        // insert information now
        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;

        // for image browsers: update image dimensions
		  if (document.URL.indexOf('type=image') != -1)
			  {
	        if (win.ImageDialog.getImageData) win.ImageDialog.getImageData();
	        if (win.ImageDialog.showPreviewImage) win.ImageDialog.showPreviewImage(URL);
			  }

        // close popup window
        tinyMCEPopup.close();
    }
}
tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);
</script>

<div class="tabs">
<ul>
<li id="browse_tab" class="current"><span><a href="tinybrowser.php?type=<?php echo $_GET['type']; ?>">Browse</a></span></li>
<?php
if($tinybrowser['allowupload']) 
	{
	?><li id="upload_tab"><span><a href="flexupload/flashUpload.php?type=<?php echo $_GET['type']; ?>">Upload</a></span></li>
	<?php } ?>
</ul>
</div>
<div class="panel_wrapper">
<div id="general_panel" class="panel currentmod">
<fieldset>
<legend>Browse Files</legend>
<?php
form_open('browse','custom',basename($GLOBALS["SCRIPT_NAME"]),'?type='.$_GET['type']);
form_text_input('find','Find',$_POST['find'],12,40);

// Offer view type if file type is image
if($_GET['type']=='image')
	{
	$select = array(
		array("thumb","Thumbnails"),
		array("detail","Details")
	);
	form_select($select,'viewtype','View As',$viewtypenow);
	}

$select = array(
		array("name","File Name"),
		array("size","File Size"),
		array("type","File Type"),
		array("created","Date Created")
	);
form_select($select,'sortby','Arrange By',$sortbynow);

$select = array(
		array("asc","Ascending"),
		array("desc","Descending")
	);
form_select($select,'sorttype','',$sorttypenow);
form_submit_button('refresh','Refresh','');


$dh = opendir($tinybrowser['docroot'].$viewpath);
$files = array();
while (($filename = readdir($dh)) !== false)
	{
	if($filename != "." && $filename != ".." && !is_dir($tinybrowser['docroot'].$viewpath.$filename))
		{
		// search file name if search term entered
		if($findnow) $exists = stripos($filename,$findnow);

		// assign file details to array, for all files or those that match search
		if(!$findnow || ($findnow && $exists !== false))
			{
			$file['name'][] = $filename;
			$file['modified'][] = filemtime($tinybrowser['docroot'].$viewpath.$filename);
			$file['size'][] = filesize($tinybrowser['docroot'].$viewpath.$filename);

			// image specific info or general
			if($_GET['type']=='image')
				{
				$imginfo = getimagesize($tinybrowser['docroot'].$viewpath.$filename);
				$file['width'][] = $imginfo[0];
				$file['height'][] = $imginfo[1];
				$file['type'][] = $imginfo['mime'];
				}
			else 
				{
				$file['width'][] = 'N/A';
				$file['height'][] = 'N/A';
				$file['type'][] = returnMIMEType($filename);
				}
			}			
		}
	}
closedir($dh);

$sortorder = ($sorttypenow == 'asc' ? SORT_ASC : SORT_DESC);

$num_of_files = count($file['name']);

if($num_of_files>0)
	{
	// sort files by selected order
	switch($sortbynow) 
		{
		case 'name':
			array_multisort($file['name'], $sortorder, $file['type'], $sortorder, $file['modified'], $sortorder, $file['size'], $sortorder, $file['width'], $sortorder, $file['height'], $sortorder);
			break;
		case 'size':
			array_multisort($file['size'], $sortorder, $file['name'], $sortorder, $file['type'], $sortorder, $file['modified'], $sortorder, $file['width'], $sortorder, $file['height'], $sortorder);
			break;
		case 'type':
			array_multisort($file['type'], $sortorder, $file['name'], $sortorder, $file['size'], $sortorder, $file['modified'], $sortorder, $file['width'], $sortorder, $file['height'], $sortorder);
			break;
		case 'created':
			array_multisort($file['modified'], $sortorder, $file['name'], $sortorder, $file['type'], $sortorder, $file['size'], $sortorder, $file['width'], $sortorder, $file['height'], $sortorder);
			break;
		default:
			// do nothing
		}
	}

// show image thumbnails, unless detail view is selected
if($_GET['type']=='image' && $viewtypenow != 'detail')
	{
	for($i=0;$i<$num_of_files;$i++)
		{
		$fullimg = $tinybrowser['docroot'].$viewpath.$file['name'][$i];
		$thumbimg = $tinybrowser['docroot'].$viewpath."/thumbs/_".$file['name'][$i];
	
		if (!file_exists($thumbimg))
			{
			$im = convert_image($fullimg,$file['type'][$i]);
			ResizeImage($im,$tinybrowser['thumbsize'],$tinybrowser['thumbsize'],$thumbimg,$tinybrowser['thumbquality']);
			}
	
		echo '<div class="img-browser"><a href="#" onclick="selectURL(\''.$viewpath.$file['name'][$i].'\');">
				<img src="'.$viewpath."/thumbs/_".$file['name'][$i]
				.'" alt="Name: '.$file['name'][$i]
				.'&#13;&#10;Type: '.$file['type'][$i]
				.'&#13;&#10;Size: '.bytestostring($file['size'][$i],1)
				.'&#13;&#10;Created: '.date($tinybrowser['dateformat'],$file['modified'][$i])
				.'&#13;&#10;Dimensions: '.$file['width'][$i].' x '.$file['height'][$i]
				.'" /></a><div class="filename">'.$file['name'][$i].'</div></div>';
		}
	}
else
	{
	// if deletes are allowed, show delete checkboxes
	if($tinybrowser['allowdelete'])
		{
		form_open('checkdel','custom',basename($GLOBALS["SCRIPT_NAME"]),'?type='.$_GET['type']);
		$delhead = '<th>Delete?</th>';
		}
	echo '<table class="browse"><tr><th>Name</th><th>Size</th><th>Type</th><th>Date Created</th>'.$delhead.'</tr>';
	for($i=0;$i<$num_of_files;$i++)
		{
		$fullimg = $tinybrowser['docroot'].$viewpath.$file['name'][$i];
		if(IsOdd($i)) $alt = 'r1'; else $alt = 'r0';
		echo '<tr class="'.$alt.'">
				<td><a href="#" onclick="selectURL(\''.$viewpath.$file['name'][$i].'\');" title="Name: '
				.$file['name'][$i].'&#13;&#10;Dimensions: '.$file['width'][$i].' x '.$file['height'][$i].'">' .truncate_text($file['name'][$i],40).'</a></td>
				<td>'.bytestostring($file['size'][$i],1).'</td>
				<td>'.$file['type'][$i].'</td>
				<td>'.date($tinybrowser['dateformat'],$file['modified'][$i]).'</td>';
		if ($tinybrowser['allowdelete']) echo '<td><input class="del" type="checkbox" name="delfile['.$file['name'][$i].']" value="1" /></td>';
		echo '</tr>';
		}
	echo '</table>';

	if($tinybrowser['allowdelete'])
		{
		form_hidden_input('viewtype',$_POST['viewtype']);
		form_hidden_input('sortby',$_POST['sortby']);
		form_hidden_input('sorttype',$_POST['sorttype']);
		form_hidden_input('find',$_POST['find']);
		form_submit_button('deletechecked','Delete Checked?','delete');
		}
	}
?>
<form name="passform"><input name = "fileurl" type="hidden" value= "" /></form>
</fieldset></div></div>
</body>
</html>