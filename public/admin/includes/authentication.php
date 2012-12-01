<?php # authentication.php Friday, 8 April 2005
// This script authenticates the merchant for admin purposes.

$authorized = FALSE; // Initialize a variable.

// Check for authentication submission.
if (isset($_SESSION['m_id'])) { 

    // Query the database.
	$query = "
			SELECT m_id, username, password
			FROM merchant_config
			WHERE username='{$_SESSION['username']}'
			AND password='{$_SESSION['password']}'
			AND m_id={$_SESSION['m_id']}
	";
    $result = mysql_query ($query);
    $row = mysql_fetch_array ($result, MYSQL_NUM);
    if ($row) { // If a record was returned...
       $authorized = TRUE;
	   $_SESSION['authenticated_user'] = TRUE;
    }

}

?>