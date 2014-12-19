<?php # Log out script Tuesday, 5 April 2005
// This is the log out page.

// Set the page title.
$page_title = "Log Out"; 

require_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php'); 
//session_start();

// If no first_name variable exists, redirect the user.
if (isset($_SESSION['m_id'])) {

    // Log out the user.

    $_SESSION = array(); // Destroy the variables.
    session_destroy(); // Destroy the session itself.
    setcookie (session_name(), '', time()-300, '/', '', 0); // Destroy the cookie.
	//header ("Location: $merchant_website/index.php");
	//exit();

} else {
	
    header ("Location: $merchant_website/admin/index.php");	
	exit();

}

// Print the customized message. 

header ("Location: $merchant_website/index.php");	
exit();

?>