<?php // index.php (administration side) Friday, 8 April 2005
// This is the home page for the admin side of the site.

// Set the page title.
$page_title = "Newsletter Overview";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else {
	
	if (isset($_GET['action'])) {
		
		switch($_GET['action']) {
			case 'delete_all':
				$query = "DELETE FROM mail_queue";
				$result = mysql_query($query);
				break;
			case 'delete_one':
				$query = "DELETE FROM mail_queue WHERE id={$_GET['id']}";
				$result = mysql_query($query);
				break;
		}
	}
	
	$query = "
		SELECT *
		FROM mail_queue
	";
	$result = mysql_query($query);
   
	?>
	<table>
		<tr><td valign="top">
			<table>
				<tr>
					<td height="25" class="Link" style="padding:0 10 0 23;" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="view_newsletter.php" class="Link">:: View Newsletter</a></td>
				</tr>	
		
				<tr>
					<td height="25" class="Link" style="padding:0 10 0 23;" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="view_users.php" class="Link">:: View Users</a></td>
				</tr>
				<tr>
					<td height="25" class="Link" style="padding:0 10 0 23;" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="send_newsletter.php" class="Link">:: Send Newsletter</a></td>
				</tr>
				<tr>
					<td height="25" class="Link" style="padding:0 10 0 23;" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="<?php print "/admin/modules/newsletter/edit_newsletter.php"; ?>" class="Link">:: Edit Newsletter</a></td>
				</tr>
			</table>
						
			<table class="todo_menu">
				<tr>
					<td height="25" class="Link" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="index.php?action=delete_all" class="Link">Delete All Mails From Queue</a></td></tr>
	
			</table>
		</td>
		<td>
		<?php
			
			$num = mysql_num_rows($result);
			
			if ($num > 0) {
				print "<div class=\"box\" style=\"margin-left:10px;\">";
				
				echo '<div style="text-align:center;font-weight:bold;margin:5px;">Mail Queue ('.$num.' in queue)</div>';
				
				echo '<div style="height:300px;overflow:auto;">';
				
        		echo '
					<table cellspacing="2" cellpadding="2">
					<tr bgcolor="#EEEEEE">
						<td align="center"><b>Name</b></td>
						<td align="center"><b>Email</b></td>
						<td align="center"><b>Status</b></td>
						<td align="center"></td>
					</tr>';

        		// Fetch and print all the records.
        		$bg = '#EEEEEE'; // Set the background colour.
        		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            		$bg = ($bg=='#EEEEEE' ? '#FFFFFF' : '#EEEEEE'); // Switch the background colour.
					$user_email = $row['recipient'];
				
					$user = "
						SELECT CONCAT(first_name, ' ', last_name) AS name
						FROM customers
						WHERE email = '$user_email'
						";
					
					$user_result = mysql_query($user);
				
					$user_details = mysql_fetch_array($user_result, MYSQL_ASSOC);
					
					echo '<tr bgcolor="'. $bg .'">';
					echo '<td align="left">'.$user_details['name'].'</td>';
					echo '<td align="left">'. $user_email. '</td><td>';
					
					switch($row['try_sent']) {
						case 25:
							echo '<span class="smcap fail">FAILED</span>';
							break;
						case 0:
						default:
							echo '<span class="smcap ok">SENDING</span>';
							break;
					}
					echo '</td>';
					echo '<td align="center"><a href="index.php?action=delete_one&id='.$row['id'].'" /><img src="/admin/images/delete.png" alt="delete email from queue"/></a></td>';
					echo '</tr>';
        		}
				
				echo '</table>'; // Close the table.
				echo '</div>';
				print "</div>";
			} else {
				print "<h1>There are no emails in the queue.</h1>";
			}
		?>
		</td></tr>
	</table>
	<?php
}	



// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>