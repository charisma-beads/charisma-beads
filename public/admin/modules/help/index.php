<?php // email.php Tuesday, 19 April 2005
// This is the email page for the site.

// Set the page title.
$page_title = "Email Help";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="../index.php">here</a> to try again!<p>';
} else {
	
	if (isset($_POST['submit']) && $_POST['submit'] == "Send") { // Handle the form.
	    
		
		print "<div>\r\n";
		print "\r\n<table align=\"center\"><tr><td>\r\n";
	
    	// Check for first name.
    	if (preg_match ("/^[[:alpha:],' -]{2,15}$/i", stripslashes(trim($_POST['first_name'])))) {
        	$fn = ($_POST['first_name']);
    	} else {
       		$fn = FALSE;
        	print "<span class=\"smcap\"> <p class=\"fail\" ><img src=\"/admin/images/actionno.png\" />Please enter your first name!</p></span>\r\n";
    	}

    	// Check for last name.
    	if (preg_match ("/^[[:alpha:].' -]{2,30}$/i", stripslashes(trim($_POST['last_name'])))) {
        	$ln = ($_POST['last_name']);
    	} else {
        	$ln = FALSE;
        	print "<span class=\"smcap\"> <p class=\"fail\" ><img src=\"/admin/images/actionno.png\" />  Please enter your last name!</font></p></span>\r\n";
    	}

    	// Check for an email address.
    	if (preg_match ("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", stripslashes(trim($_POST['email'])))) {
        	$e = ($_POST['email']);
    	} else {
        	$e = False;
        	print "<span class=\"smcap\"> <p class=\"fail\" ><img src=\"/admin/images/actionno.png\" />  Please enter a valid email address!</p></span>\r\n";
    	}

    	// Check for a Subject.
    	if (!empty ($_POST['subject'])) {
        	$s = (stripslashes(trim($_POST['subject'])));
    	} else {
        	$s = FALSE;
        	print "<span class=\"smcap\"> <p class=\"fail\" ><img src=\"/admin/images/actionno.png\" />  Please enter a Subject!</p></span>\r\n";
    	}

    	// Check for comments.
     	if (!empty ($_POST['comments'])) {
        	$c = (stripslashes(trim($_POST['comments'])));
    	} else {
        	$c = FALSE;
        	print "<span class=\"smcap\"> <p class=\"fail\" ><img src=\"/admin/images/actionno.png\" /> Please enter your comments!</p></span>\r\n";
    	}

    	if ($fn && $ln && $e && $s && $c) { // If everything is OK.

        	// Mail it.
        	$name = $fn . " " . $ln;
        	$message = $c . "\r\n\r\n" . $name;
        	$header = "From: " . $e . "\r\n";
        	$header .= "Reply-To: " . $e . "\r\n";
        	$header .= "MIME-Version: 1.0\r\n";
        	$header .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
        	$header .= "X-Priority: 1\r\n";
        	$header .= "X-Mailer: PHP/" . phpversion();
        	mail ('shaun@shaunfreeman.co.uk', $s, $message, $header); 
		
			print "<span class==\"smcap\"><center><p class=\"pass\"><img src=\"/admin/images/actionok.png\" /> Your comments have been sent.</p><p style=\"pass\" > We will reply as soon as we can</p><p class=\"pass\" > Thank You</p></center></span>\r\n"; 
		
			print "</td></tr></table>\r\n";
			print "</div>\r\n";

    	} else { // If one of the data test have failed.
        	print "<span class=\"smcap\"> <p class=\"fail\" >Please try again</p></center></span>\r\n";
		
			print "</td></tr></table>\r\n";
			print "</div>\r\n";
        	?>
			<div align="center">
        	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		
        	<input type="hidden" name="first_name" value="<?php if (isset($_POST['first_name'])) echo (stripslashes($_POST['first_name'])); ?>" />
        	<input type="hidden" name="last_name" value="<?php if (isset($_POST['last_name'])) echo (stripslashes($_POST['last_name'])); ?>" />
        	<input type="hidden" name="email" value="<?php if (isset($_POST['email'])) echo (stripslashes($_POST['email'])); ?>" />
        	<input type="hidden" name="subject" value="<?php if (isset($_POST['subject'])) echo (stripslashes($_POST['subject'])); ?>" />
        	<input type="hidden" name="comments" value="<?php if (isset($_POST['comments'])) echo (stripslashes($_POST['comments'])); ?>" />
			<input type="submit" name="submit" value="Try Again" />
		
			</form>
			</div>
			<?php
    	}
	} else {
		?>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

		<div>
    	<table align="center">

    	<tr><td><b>First Name:</b></td><td><?php print $merchant_first_name ?><input type="hidden" name="first_name" value="<?php if (isset($_POST['first_name'])) {echo (stripslashes($_POST['first_name']));} else {print $merchant_first_name;} ?>" /></td></tr>

    	<tr><td><b>Last Name:</b></td><td><?php print $merchant_last_name ?><input type="hidden" name="last_name" value="<?php if (isset($_POST['last_name'])) {echo (stripslashes($_POST['last_name']));} else {print $merchant_last_name;} ?>" /></td></tr>

    	<tr><td><b>Email:</b></td><td><?php print $merchant_email ?><input type="hidden" name="email" value="<?php if (isset($_POST['email'])) {echo (stripslashes($_POST['email']));} else {print $merchant_email;} ?>" /></td></tr>

    	<tr><td><b>Subjet:</b></td><td><select name="subject" size="1">	
		<option value="">Please choose a subject</option>
		<option value="Technical">Technical</option>
		<option value="Email Problem">Email Problem</option>
		<option value="Billing">Billing Enquiry</option>
		<option value="Other">Other</option>
		</select></td></tr>

    	<tr><td><b>Comments:</b></td><td><textarea name="comments" rows="10" cols="50" /><?php if (isset($_POST['comments'])) {echo (stripslashes($_POST['comments']));} ?></textarea></td></tr>

    	</table>
    	</div>

    	<div align="center" style="margin:5px; padding:5px"><input type="submit" name="submit" value="Send" /></div>
		</form>

		<?php
	}
}	

	
// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>