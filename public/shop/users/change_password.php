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
	
    if (isset($_POST['submit']) && $_POST['submit'] == "Change Password") { // Handle the form.
		
		$content .= "<div class=\"box\">\r\n";
		$content .= "\r\n<table><tr><td>\r\n";
		
        // Check for a new password and match against the confired one.
        if (preg_match ('@^[[:alnum:]!£$%&/\()=?+#-.,;:_\@]{4,20}$@i', stripslashes(trim($_POST['password1'])))) {
            if ($_POST['password1'] == $_POST['password2']) {
                $p = escape_data($_POST['password1']);
            } else {
                $p = FALSE;
                $content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Your password did not match the comfirmed password!</span></p>";
            }
        } else {
            $p = FALSE;
            $content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter a valid password!</span></p>";
        }

        if ($p) { // If everything is OK.

            // Make the query.
            $query = "UPDATE customers SET password=MD5('$p') WHERE customer_id={$_SESSION['cid']}";
            $result = mysql_query ($query); // Run the query.
            if (mysql_affected_rows() == 1) { // If it ran OK.

                // Send an email, if desired.
                $content .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" /> Your password has been changed.</p></span>";
				$content .= "</td><tr></table>\r\n";

            } else { // If it did not run OK.

                // Send a message to the error log, if desired.
                $content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Your password could not be changed due to a system error. We apologize for any inconvenience.</span></p>";

            }
            mysql_close(); // Close the database connection.

        } else  { // Failed the validation tests.
            $content .= "<span class=\"smcap\"><p class=\"fail\" align=\"center\">Please try again!</p></span>";
			$content .= "</td><tr></table>\r\n";
            $content .= '
            <form action="'.$_SERVER['PHP_SELF'].'" method="post">

            <p class="center">
			<input type="submit" name="submit" value="Try Again!" class="submit"/>
			</p></div>

            </form>
            ';
        }

    } // End of main conditional.
    else { // display the form.
    $content .= '
    
    <h1>Change Password</h1>
    <form action="'.$_SERVER['PHP_SELF'].'" method="post">
    <div class="box">
    <table style="margin-right:auto; margin-left:auto;">
	<tr><td><b>New Password:</b></td> <td><input id="password1" type="password" name="password1" size="20" maxlength="20" /></td><td width="130" style="border:1px dashed black;background-color:white;font-weight:bold;text-transform:capitalize;font-size:10px"><p style="margin:0px;background-color:skyblue;text-align:center">strength meter</p><p id="passBar" style="margin:0px;height:14px;width:32px;background-image:url(/admin/images/stat_barreend.png);float:right"><img src="/admin/images/stat_barreend.png" alt=""><img id="bar" src="/admin/images/stat_barre.png" alt="" height="14" width="0"><img src="/admin/images/stat_barreend.png" alt=""></p>
	<p id="passStrength" style="margin:0px;">score: 0/30<br />verdict: </p></td></tr>
	<tr><td colspan="3"><small>Use only letters, numbers and ! &pound; $ % &amp; / \ ( ) = ? + * # - . , ; : _ <br />Must between 4 and 20 characters long with no spaces</small></td><tr>
    <tr><td><b>Confirm New Password:</b></td> <td><input type="password" name="password2" size="20" maxlength="20" /></td><td>&nbsp;</td></tr>
	<tr><td colspan="3" style="text-align:center;">
	<input type="submit" name="submit" value="Change Password" class="submit"/></td></tr>
    </table>
    </div>
    </form><!-- End of form -->
    
    ';
    }
} // End of !isset($_SESSION['first_name']) ELSE.

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>
