<?php // login.php Tuesday, 5 April 2005
// This page allows logged-in users to change their details.

// Set the page title.
$page_title = "My Account : Newsletter Options";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php'); 

// If no first_name variable exists, redirect the user.
if (!isset($_SESSION['cid'])) {

    header ("Location: $merchant_website/index.php");
    
} else {
	
	if (isset($_POST['submit']) && ($_POST['submit'] == 'Opt In' || $_POST['submit'] == 'Opt Out')) {
		
		$query = "
			SELECT newsletter_id
			FROM customers
			WHERE customer_id=".$_SESSION['cid']."
		";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		
		switch ($_POST['submit']) {
			case 'Opt In':
				if ($row[0] == 0) {
					$query = "
						INSERT INTO newsletter (registration_date) 
						VALUES (NOW())
					";  
					$result = mysql_query ($query); // Run the query.
					$nid = mysql_insert_id();
				} else {
					$nid = $row[0];
				}
				break;
			case 'Opt Out':
				$query = "
					DELETE FROM newsletter
					WHERE newsletter_id=".$row[0]."
				";
				
				$result = mysql_query($query);
				$nid = 0;
				break;
		}
		
		$query = "
				UPDATE customers
				SET newsletter_id=$nid
				WHERE customer_id=".$_SESSION['cid']."
				";
		$result = mysql_query($query);
		
	}
	
	$content .= "<h1>$page_title</h1>";
	
	$query = "
			SELECT newsletter_id
			FROM customers
			WHERE customer_id=".$_SESSION['cid']."
			";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	
	if ($row[0] > 0) {
		$option = 'opt in';
	} else {
		$option = 'opt out';
	}
	
	$content .= "
	<p>You have $option to recieving our newsletters</p>
	<p>Click the '";
	$content .= ($row[0] == 0) ? 'opt in' : 'opt out';
	$content .= "' button to ";
	$content .= ($row[0] == 0) ? 'receive' : 'stop receiving';
	$content .= " our newsletter.</p>
	<form action=\"change_newsletter.php\" method=\"post\">
	";
	
	if ($row[0]) {
		
		$content .= '<input type="submit" name="submit" value="Opt Out" />';
	
	} else {
		$content .= '<input type="submit" name="submit" value="Opt In" />';
	}
	$content .= '
	</form>
	';
} // End of !isset($_SESSION['first_name']) ELSE.

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>