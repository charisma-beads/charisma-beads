<?php // index.php (administration side) Friday, 8 April 2005
// This is the Merchant Details page for the admin side of the site.

// Set the page title.
$page_title = "Change Login Details";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {
	
	print "<p><a href=\"index.php\">Back to Overview</a></p>";
	
    if (isset($_POST['submit']) && $_POST['submit'] == "Change Details") { // Handle the form.
		
		print "<div class=\"box\">\r\n"; 
		print "\r\n<table><tr><td>\r\n";
		
        // Check for a new password and match against the confired one.
			if (preg_match ("@^[[:alnum:]!£$%&/\()=?+*#-.,;:_]{4,20}$@i", stripslashes(trim($_POST['password1'])))) {
            if ($_POST['password1'] == $_POST['password2']) {
                $p = escape_data($_POST['password1']);
            } else {
                $p = FALSE;
                print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Your password did not match the comfirmed password!</span></p>";
            }
        } else {
            $p = FALSE;
            print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter a valid password!</span></p>";
        }
		
        if ($p) { // If everything is OK.

            // Make the query.
            $query = "UPDATE merchant_config SET password=MD5('$p') WHERE m_id={$_SESSION['mid']}";
			
            $result = mysql_query ($query); // Run the query.
            if (mysql_affected_rows() == 1) { // If it ran OK.

                // Send an email, if desired.
                print "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" /> Your password has been changed.</p></span>";
				print "</td><tr></table>\r\n";
				$_SESSION['password'] = MD5(stripslashes($p));
                exit();

            } else { // If it did not run OK.

                // Send a message to the error log, if desired.
                print "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Your password could not be changed due to a system error. We apologize for any inconvenience.</span></p>";

            }
            mysql_close(); // Close the database connection.

        } else  { // Failed the validation tests.
            print "<span class=\"smcap\"><p class=\"fail\" align=\"center\">Please try again!</p></span>";
			print "</td><tr></table>\r\n";
?>
            <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">

            <p class="center">
			<input type="hidden" name="submit" value="Try Again!" />
			<input type="submit" name="Try Again!" value="Try Again!" />
			</p></div>

            </form>
            <?php
			
        }

    } // End of main conditional.
    else { // display the form.	
    ?>
   	<script language="JavaScript">
		function checkpassword() {
			var pwd = $('password1').getValue()
			var intstrength = 0
			
			if (pwd.length > 3 && pwd.length < 6)
				intstrength = (intstrength + 3)
			else if (pwd.length > 5 && pwd.length < 9)
				intstrength = (intstrength + 5)
			else if (pwd.length > 7 && pwd.length < 13)
				intstrength = (intstrength + 7)
			else if (pwd.length > 12)
				intstrength = (intstrength + 8)
			
			if (pwd.match(/[a-z]/) && pwd.match(/[A-Z]/))
				intstrength = (intstrength + 8)
			
			if (pwd.match(/[0-9]/))
				intstrength = (intstrength + 4)
			
			if (pwd.match(/[\!\£\$\%\&\/\(\)\=\?\+\*\#\-\.\,\;\:\_]/))
				intstrength = (intstrength + 10)
			
			if (intstrength < 10) {
				strverdict = "poor"
				$('passStrength').setStyle('color', 'red')
			}
			else if (intstrength > 9 && intstrength < 20) {
				strverdict = "average"
				$('passStrength').setStyle('color', 'goldenrod')
			}
			else if (intstrength > 19) {
				strverdict = "tough"
				$('passStrength').setStyle('color', 'green')
			}
			
			$('passStrength').setHTML('score: ' + intstrength + '/30<br />verdict: ' + strverdict)
			
			$('bar').setStyle('width', intstrength)
		}
		window.addEvent('domready', function() {
			$('password1').addEvents({
 				'keyup': function() {
					checkpassword();
				}
			});
		});
	</script>
	<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
	<div class="box">
    <table cellpadding="2" cellspacing="2" style="background-color:skyblue;border:1px solid black">
			<tr><td><b>New Password:</b></td> <td><input id="password1" type="password" name="password1" size="20" maxlength="20" /></td><td style="border:1px dashed black;width:110px;background-color:white;font-weight:bold;text-transform:capitalize;"><p style="margin:0px;background-color:skyblue;text-align:center">strength meter</p><p id="passBar" style="margin:0px;height:14px;width:32px;background-image:url(/admin/images/stat_barreend.png);float:right"><img src="/admin/images/stat_barreend.png" alt=""><img id="bar" src="/admin/images/stat_barre.png" alt="" height="14" width="0"><img src="/admin/images/stat_barreend.png" alt=""></p>
	<p id="passStrength" style="margin:0px;">score: 0/30<br />verdict: </p></td></tr>
	<tr><td colspan="3"><small>Use only letters, numbers and ! &pound; $ % &amp; / \ ( ) = ? + * # - . , ; : _ <br />Must between 4 and 20 characters long with no spaces</small></td><tr>
    <tr><td><b>Confirm New Password:</b></td> <td><input type="password" name="password2" size="20" maxlength="20" /></td><td></td></tr>
	<tr><td colspan="3" style="text-align:center;">
	<input type="submit" name="submit" value="Change Details" /></td></tr>
    </table>
	</div>
    </form><!-- End of form -->
    
<?php
    }
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>