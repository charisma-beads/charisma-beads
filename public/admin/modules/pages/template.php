// include the document root.
include_once ('rootpath.php');

// Set the page title.
$page_title = '#### PAGE TITLE ####';

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php'); 

$query = "
	SELECT content
	FROM pages
	WHERE page_id=#### PAGE ID ####
	";
$result = mysql_fetch_array (mysql_query ($query), MYSQL_NUM);

print $result[0]; 

$query = "
	SELECT hits
	FROM menu_links
	WHERE page_id=#### PAGE ID ####
	";
$result = mysql_fetch_array (mysql_query ($query), MYSQL_NUM);
$result = $result[0] + 1; 
$query = "
	UPDATE menu_links
	SET hits=$result
	WHERE page_id=#### PAGE ID ####
	";
$result = mysql_query ($query);
 
// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/html_bottom.php');