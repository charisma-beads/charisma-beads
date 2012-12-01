<?php
require_once("../config_tinybrowser.php");

$folder_name = $tinybrowser['path'][$_GET['type']];

if ($_FILES['Filedata']['tmp_name'] && $_FILES['Filedata']['name'])
	{	
	$source_file = $_FILES['Filedata']['tmp_name'];
	$image_name = stripslashes($_FILES['Filedata']['name']);
	//-- $folder_name is the folder for image uploads
	$tmp_folder = $_REQUEST['folder'];
	if(!is_dir($tinybrowser['docroot'].$folder_name.$tmp_folder))
		{
	   //-- Create the folder to upload the images to
		mkdir($tinybrowser['docroot'].$folder_name.$tmp_folder, 0777);
		chmod($tinybrowser['docroot'].$folder_name.$tmp_folder, 0777);
		}
	copy($source_file,$tinybrowser['docroot'].$folder_name.$tmp_folder.'/'.$image_name);
	}		
?>
