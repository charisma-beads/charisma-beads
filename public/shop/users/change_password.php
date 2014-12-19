<?php // login.php Tuesday, 5 April 2005
// This page allows logged-in users to change their details.

// Set the page title.
$page_title = "Change Details";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php'); 

// If no first_name variable exists, redirect the user.
if (!isset($_SESSION['cid'])) {

    header ("Location: $merchant_website/index.php");
    
} else {
	$changePasswordForm = new ChangePasswordForm();
	$inputFilter = new ChangePasswordInputFilter();
	$changePasswordForm->setInputFilter($inputFilter);
	$changePasswordForm->init();
	
    if ($request->isPost() && $request->getPost('submit', '') == "Change Password") { // Handle the form.
		
        $changePasswordForm->setData($request->getPost());

        if ($changePasswordForm->isValid()) { // If everything is OK.
        	$data = $changePasswordForm->getData();
        	
        	$bcrypt = new \Zend\Crypt\Password\Bcrypt();
        	$password = $bcrypt->create($data['password']);
        	
            // Make the query.
            $query = "UPDATE customers SET password='".$password."' WHERE customer_id=".$_SESSION['cid'];
            
            $result = mysql_query ($query); // Run the query.
            
            if (mysql_affected_rows() == 1) { // If it ran OK.
                // Send an email, if desired.
                $content .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" /> Your password has been changed.</p></span>";
                $changePasswordForm->setData(array(
                	'password' => '',
                	'password-confirm' => '',
                ));

            } else { // If it did not run OK.
                $changePasswordForm->setMessages(array('security'=> array('Your password could not be changed due to a system error. We apologize for any inconvenience. Please Try again.')));
            }
            mysql_close(); // Close the database connection.

        } else  { // Failed the validation tests.
            $changePasswordForm->setMessages(array('security'=> array('Opps, someting went wrong. Please try again.')));
        }
    } 
    
    $viewRenderer = new ViewRenderer();
    	
    $content .= $viewRenderer->render('change-password', array(
    	'form' => $changePasswordForm,
    ));

} // End of !isset($_SESSION['first_name']) ELSE.

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>
