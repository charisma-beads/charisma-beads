<?php # Log out script Tuesday, 5 April 2005
// This is the newsletter log out page.

// Set the page title.
$page_title = "Log Out";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php'); 

// If no first_name variable exists, redirect the user.
if (isset($_SESSION['cid'])) {

    // Log out the user.

    $_SESSION = array(); // Destroy the variables.
    session_destroy(); // Destroy the session itself.
    setcookie (session_name(), '', time()-300, '/', '', 0); // Destroy the cookie.
    
}  else {
	ob_end_clean();
	header ("Location: $merchant_website/index.php");	
	exit();

}
ob_end_clean();
header ("Location: $merchant_website/index.php");	
exit();

?>