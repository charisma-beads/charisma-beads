<?php // forgot_password.php Thursday, 7 April 2005
// This page allows users to reset their password, if forgotten.

// Set the page title and include the HTML header.
$page_title = "Forgot Your Password"; 

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php'); 

if (isset($_POST['submit']) && $_POST['submit'] == "Reset My Password") { // Handle the form.
    
	$content .= "\r\n<table align=\"center\"><tr><td>\r\n";
	$content .= "<div>\r\n";
	if (preg_match ("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", stripslashes(trim($_POST['email'])))) { // Validate the username.
		$e = escape_data($_POST['email']);
        
        // Check for the existence of that username.
		$query1 = "SELECT customer_id, email FROM customers WHERE email='$e'";
		//$content .= $query1;
		$result1 = mysql_query ($query1);
		$row1 = mysql_fetch_array ($result1, MYSQL_NUM);
		if ($row1) {
			$uid = $row1[0];
			$email = $row1[1];
		} else {
			$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> The submitted email does not match those on record!</p></span>\r\n";
			$u = FALSE;
		}
       
    } else {
		
		$e = FALSE;
		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> You forgot to enter your email!</p></span>\r\n";

    }
    
    if ($e) { // If everthing is OK.

        // Create a new random password.
        $p = substr (md5(uniqid(rand(),1)), 3, 10);

        // Make the query in the users table.
		if ($row1) {
        
			$query = "UPDATE customers SET password=MD5('$p') WHERE customer_id=$uid";
        	$result = mysql_query ($query); // Run query.
		}
		//$content .= $query;
		// Make the query in the merchant_config table.
		/*
		if ($row2) {
       
        	$query = "UPDATE merchant_config SET password=MD5('$p') WHERE m_id=$uid";
       		$result = mysql_query ($query); // Run query.
		}
		*/
        if (mysql_affected_rows() == 1) { // If it ran OK.
        
            // Send Mail.
			$email_from = 'webmaster@charismabeads.co.uk';
            
        	$message = "Your password to log into $merchant_name has been temporarily changed to:\r\n\r\n $p \r\n\r\n Please log-in using this password and your username. At that time you may change your pasword to something more memorable.\r\n\r\n Thank You\r\n\r\n$merchant_name";
        	$header = "From: " . $email_from . "\r\n";
        	$header .= "Reply-To: " . $email_from . "\r\n";
        	$header .= "MIME-Version: 1.0\r\n";
        	$header .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
        	$header .= "X-Priority: 1\r\n";
        	$header .= "X-Mailer: PHP/" . phpversion();
        	mail ($email, "Login Details Changed - " . $merchant_name, $message, $header);
            $content .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" /> Your password has been changed.<br /> You will recieve a new, temporary password at the mail address with which you registered. Once you have logged in with this password, you may change it by going to 'My Account' and clicking on the \"Change Details\" link.</p></span>\r\n";
			$content .= "</div>\r\n";
			$content .= "</td></tr></table>\r\n";
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php'); // Include the footer.
			ob_end_flush();
            exit();
			
        } else { // If it did not run OK.

            // Send a message to the error log, if desired.
            $content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Your password could not be changed due to a system error.<br />We apologize for any inconvenience.</p></span>\r\n";

        }
        mysql_close(); // Close the database connection.

    } else { // Failed the validation test.
        $content .= "<span class=\"smcap\"><center><p class=\"fail\"> Please try again.</p></center></span>\r\n";
		$content .= "</div>\r\n";
		$content .= "</td></tr></table>\r\n";
        $content .= '
        <form action="'.$_SERVER['PHP_SELF'].'" method="post">

    <div>
    <input type="hidden" name="email" size="60" maxlength="60" value="';
        
        if(isset($_POST['email'])) $content .= $_POST['email'];

        $content .= '" />

    </div>

    <div class="center"><input class="submit" type="submit" name="submit" value="Try Again!" /></div>

</form><!-- End of form -->

';
    }
    
} else {// End of main Submit conditional.

$content .= '
<h3 class="center">Reset Your Password</h3>
<p class="center">Enter your email below and your password will be reset.</p>
<form action="'.$_SERVER['PHP_SELF'].'" method="post">

    <table align="center">
    
        <tr><td><b>Email:</b></td><td><input class="inputbox" type="text" name="email" size="20" value="';
    if(isset($_POST['email'])) $content .= $_POST['email'];
    $content .='" /></td></tr>

    </table>
    
    <div class="center"><input class="submit" type="submit" name="submit" value="Reset My Password" /></div>
    
</form><!-- End of form -->

';
}
// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>
