<?php 
// view_order.php Tuesday, 3 May 2005
// This is the add catagory page for admin.
	  
// Set the page title.
$page_title = "Edit Tax Code";
	  
// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');
	  
// Print a message based on authentication.
if (!$authorized) {
	echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 
	// Menu Links
	print "<table><tr><td valign=\"top\">";
	print "<p><a href=\"../index.php\">Back to Overview</a></p>";
						  
	require_once ('menu_links.php');
						  
	print "</td><td style=\"padding-left:100px;padding-right:100px;\" valign=\"top\">";
						  
	if (isset ($_POST['submit'])) {	
						  
		// Valadate the data.
		if ($_POST['submit'] == "Update Tax Code") {
			
			$error = NULL;
						  
			if ($_POST['tax_code']) {
				$tax_code = escape_data (strtoupper (trim ($_POST['tax_code'])));
			} else {
				$tax_code = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a tax code<span></p>";
			}
			
			if ($_POST['tax_rate']) {
				$tax_rate = escape_data (trim ($_POST['tax_rate']));
			} else {
				$tax_rate = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a tax rate<span></p>";
			}
			
			if ($_POST['description']) {
				$description = escape_data (trim ($_POST['description']));
			} else {
				$tax_rate = FALSE;
				$error .= "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> Please enter a description<span></p>";
			}
			
			// If all is well.
			if ($tax_code && $tax_rate && $description) {
				
				// Check if tax code is availiable.
				$query = "
					SELECT tax_code_id
					FROM tax_codes
					WHERE tax_code_id !={$_POST['tcid']}
					AND tax_code='$tax_code'
				";
				$result = mysql_query ($query);
								  
				if (mysql_num_rows($result) == 0) {
								  
					// Add Tax code.
					$query = "
						UPDATE tax_codes 
						SET tax_rate_id=$tax_rate, tax_code='$tax_code', description='$description'
						WHERE tax_code_id={$_POST['tcid']}
					";
					$result = mysql_query ($query);
					
                    Utility::go ('index.php');
								  
				} else {
					print "<p class=\"fail\"><img src=\"/admin/images/actionno.png\" class=\"valign\" /><span class=\"valign\"> This tax code already exists<span></p>";
				}
										  
			} else {
				?>
				<div class="box">
					<?=$error?>
				</div>
				<?php
			}
										   
		}
										   
	} else {
	
		$query = "
			SELECT tax_rate_id, tax_code, description
			FROM tax_codes
			WHERE tax_code_id={$_GET['tcid']}
		";
		$result = mysql_query ($query);
		$tax_rate_id = mysql_result ($result, 0, 'tax_rate_id');
		$tax_code = mysql_result ($result, 0, 'tax_code');
		$description = mysql_result ($result, 0, 'description');
											   
		?>
		<div class="box">
			<table cellspacing="2" cellpadding="2">
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
													  
					<tr><td align="right"><b>Tax Code</b></td><td><input type="text" name="tax_code" value="<?=$tax_code;?>" maxlength="5" size="5" /></td></tr>
				
					<tr><td align="right"><b>Tax Rate</b></td><td>
					<select name="tax_rate"><option>Select One</option>
					<?php 
					// Retrieve all the tax codes and add to the pull down menu.
					$query = "
						SELECT tax_rate_id, tax_rate 
						FROM tax_rates
					";
					$result = mysql_query ($query);
					while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
						if ($row['tax_rate'] > 0) {
							$row['tax_rate'] = substr ($row['tax_rate'], 2);
							$row['tax_rate'] = substr ($row['tax_rate'], 0, 2) . "." . substr ($row['tax_rate'], -1);
							if (substr ($row['tax_rate'], 0, 1) == 0) {
								$row['tax_rate'] = substr ($row['tax_rate'], 1);
							}
			
							$row['tax_rate'] = number_format ($row['tax_rate'], 2);
			
						} else {
							$row['tax_rate'] = number_format ($row['tax_rate'], 2);
						}
		
						print "<option value=\"{$row['tax_rate_id']}\" ";
						if ($tax_rate_id == $row['tax_rate_id']) print "selected=\"selected\"";
						print ">{$row['tax_rate']}&#037;</option>\r\n";
					}
					?>
					</select>
					</td></tr>
				
					<tr><td align="right"><b>Description</b></td><td><input type="text" name="description" value="<?=$description;?>" maxlength="30" size="20" /></td></tr>
													  
					<tr><td colspan="2" align="center">
					<input type="hidden" name="tcid" value="<?=$_GET['tcid'];?>" />
					<input type="submit" name="submit" value="Update Tax Code" />
					</td></tr>
					
				</form> 
			</table>
		</div>
		<?php
											   
	}
											   
	print "</td></tr></table>";
	mysql_close(); // Close the database connection.
								   
}
								   
// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');
								   
?>