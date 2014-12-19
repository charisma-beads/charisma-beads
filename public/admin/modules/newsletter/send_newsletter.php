<?php // view_user.php Wednesday, 13 April 2005
// This page allows the administrator to view the current newsletter.

// Set the page title.
$page_title = "Send Newsletter";
ini_set('max_execution_time', 1000);
// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Check for authorization.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="../index.php">here</a> to try again!<p>';
} else {

	print "<p><a href=\"index.php\">Back to Overview</a></p>";

	$query = "
			SELECT n.newsletter_id, CONCAT(first_name, ' ', last_name) AS name, first_name, last_name, email
			FROM newsletter AS n,customers AS c
			WHERE n.newsletter_id=c.newsletter_id
			ORDER BY last_name, first_name
			"; // Standard query
	$result = mysql_query ($query);
	$num = mysql_num_rows ($result); // How many users are there?

	if ($num > 0)  { // If it ran OK, display the records.

		if ((isset($_POST['user']) || isset($_POST['select_all'])) && $_POST['submit'] == "Send Mail") {


			require_once ($_SERVER['DOCUMENT_ROOT'].'/../data/mail_options.php');

			/* we use the db_options and mail_options here */
			$mail_queue = new Mail_Queue($db_options, $mail_options);

			$from = $merchant_email;

			$hdrs = array(
				 'From'    => $from,
				 'Subject' => $merchant_name . " Newsletter " . date('F Y'),
				 'Date' => date("r")
			 );

			/* we use Mail_mime() to construct a valid mail */
			$template = "01"; // For testing.
			$css_style = file_get_contents ("./$template/css/style.css");
			$content = file_get_contents ("./$template/content.txt");
			$newsletter = file_get_contents ("./$template/newsletter.txt");
			$newsletter_link = $merchant_website . "/newsletter/images";

			$css_style = str_replace ('#### LINK ####', $newsletter_link, $css_style);

			$template = array (
							'LINK' => $newsletter_link,
		 					'WEBSITE' => $merchant_website,
	   						'STYLE' => $css_style,
		  					'NAME' => $merchant_name,
		 					'CONTENT' => $content
						  );

			$query = "
					SELECT CONCAT(first_name, ' ', last_name) AS name, first_name, last_name, email
					FROM newsletter AS n,customers AS c
					WHERE n.newsletter_id=c.newsletter_id
					";
			
			if (!isset($_POST['select_all'])) {
				$query .= "AND n.newsletter_id IN (";
				foreach ($_POST['user'] as $key => $value) {
					$query .= $value . ',';
				}
				$query = substr ($query, 0, -1) . ") ";
			}
					
			$query .= "ORDER BY name ASC"; // Standard query

			$result = mysql_query ($query);

			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

				$template['UNSUBSCRIBE'] = $merchant_website.'/newsletter/unsubscribe.php?email='.$row['email'];

				$newsletter = file_get_contents ("./01/newsletter.txt");

				foreach ($template as $key => $value) {
					$template_name = '#### ' . $key . ' ####';
					$newsletter = str_replace ($template_name, $value, $newsletter);
				}

				$to = $row['email'];

				$hdrs['To'] = $to;

				$mime = new Mail_mime();
				$mime->setHTMLBody($newsletter);
				$body = $mime->get();
				$hdrs = $mime->headers($hdrs);

				/*
				print "<pre>";
				print_r ($mime);
				print "</pre>";
				*/
				//unset($newsletter);

				/* Put message to queue */
				$done = $mail_queue->put($from, $to, $hdrs, $body);

			}

			print "<h1>Email list is activated and will be sent later at a rate of 50 emails an hour.</h1>\r\n";

		} else {
			 // Table header.
			print "<div class=\"box\">";

			 print "<form id=\"send_newsletter\" action=\"send_newsletter.php\" method=\"post\">";

			 echo '<div style="height:300px;overflow:auto;">';

        	echo '<table cellspacing="2" cellpadding="2">
        	<tr bgcolor="#EEEEEE"><td align="center"><b>Name</b></td><td align="center"><b>Email</b></td><td></td></tr>';

        	// Fetch and print all the records.
        	$bg = '#EEEEEE'; // Set the background colour.
        	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            	$bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE'); // Switch the background colour.
           		echo '<tr bgcolor="', $bg, '">';
				echo '<td align="left">'. stripslashes($row['name']) .'</td>';
				echo '<td align="left">'. $row['email'] .'</td>';
				echo '<td><input name="user[]" type="checkbox" value="'.$row['newsletter_id'].'" /></td>';
				echo '</tr>';
        	}

        	echo '</table>'; // Close the table.

			echo '</div>';

			echo '<p style="text-align:center;"><input name="select_all" type="checkbox" value="true" />Send All</p><p><input type="submit" name="submit" value="Send Mail" /></p>';

			print "</form>";

			print "</div>";
		}

	} else {
		print "<h1>There are not any subscribers yet.</h1>\r\n";
	}

	mysql_close(); // Close the database connection.

}
// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>
