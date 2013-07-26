<?php // page_content_overview.php (administration side) Friday, 8 April 2005
// This is the page content overview page for the admin side of the site.

// Set the page title.
$page_title = "Page Content";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 

	function page_list ($parent, $level) {
	
		global $merchant_website;
	
		$query = "
		SELECT title, DATE_FORMAT(modified_date, '%D %M, %Y') AS date, links_id, sort_order, editable, url, page_id, deletable
		FROM menu_links, menu_parent
		WHERE menu_parent.parent='". escape_data($parent) . "'
		AND menu_parent.parent_id=menu_links.parent_id
		ORDER BY sort_order ASC
		";
		
		$result = mysql_query($query);
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$indent = $level * 10;
			print "<tr>\r\n";
			print "<td style=\"background-color:skyblue;text-indent:".$indent."px;\"><b>\r\n";
			if ($level > 0) {
				print "&bull;&nbsp;";
			}
			if ($row['url'] == "index.php") {
				print "<img src=\"/admin/images/intro.png\" style=\"vertical-align:middle;\" alt=\"Home Page\" />\r\n";
			}
			print "<span style=\"vertical-align:middle;\">{$row['title']}</span></b></td>\r\n";
			print "<td style=\"background-color:skyblue;\"><a href=\"$merchant_website/{$row['url']}\" target=\"_blank\" ><b>$merchant_website/{$row['url']}</b></a></td>\r\n";
			print "<td style=\"background-color:skyblue;\"><b>{$row['date']}</b></td>\r\n"; 
			print "<td style=\"background-color:skyblue;\"><a href=\"assend.php?lid={$row['links_id']}\" ><img src=\"/admin/images/assend.png\" alt=\"Move Up\" /></a></td>\r\n";
			print "<td style=\"background-color:skyblue;\"><a href=\"desend.php?lid={$row['links_id']}\" ><img src=\"/admin/images/desend.png\" alt=\"Move Down\" /></a></td>\r\n";
			if ($row['deletable'] == "Y" && $row['editable'] == "Y") {
				print "<td style=\"background-color:skyblue;\"><a href=\"merge.php?lid={$row['links_id']}\" ><img src=\"/admin/images/merge.png\" alt=\"Move the page\" /></a></td>\r\n"; 
			} else {
				print "<td style=\"background-color:skyblue;\">&nbsp</td>\r\n";
			}
			if ($row['editable'] == "Y") {
				print "<td style=\"background-color:skyblue;\"><a href=\"title.php?lid={$row['links_id']}\" ><img src=\"/admin/images/title.gif\" alt=\"Edit Title\" /></a></td>\r\n";
			} else {
				print "<td style=\"background-color:skyblue;\">&nbsp</td>\r\n";
			}
			
			if ($row['editable'] == "Y") {
				print "<td style=\"background-color:skyblue;\"><a href=\"/admin/modules/pages/edit_page.php?pid={$row['page_id']}\"  style=\"text-decoration:none; \" ><img src=\"/admin/images/edit.png\" alt=\"edit page\" /></a></td>\r\n";
			} else {
				print "<td style=\"background-color:skyblue;\">&nbsp</td>\r\n";
			}
			print "<td style=\"background-color:skyblue;\"><a href=\"javascript:NewWindow('$merchant_website/{$row['url']}', 'View', 800, 600, 'yes')\"><img src=\"/admin/images/view2.gif\" alt=\"View page\" /></a></td>\r\n";
			if ($row['deletable'] == "Y") {
				print "<td style=\"background-color:skyblue;\"><a href=\"delete_page.php?lid={$row['links_id']}\" ><img src=\"/admin/images/delete.png\" alt=\"Delete page\" /></a></td>\r\n"; 
			} else {
				print "<td style=\"background-color:skyblue;\">&nbsp</td>\r\n";
			}
			print "</tr>\r\n";
			
			page_list ($row['title'], $level + 1);
		} // End of while statment
		
	}
	?>
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td valign="top">
				<table>
					<tr>
						<td height="25" class="Link" style="padding:0 10 0 23;" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="add_page.php" class="Link"><img src="/admin/images/invioce.gif" alt="New Page" style="vertical-align:middle;" /> <span style="vertical-align:middle;">Add New Page</span></a></td>
					</tr>
					<tr>
						<td height="25" class="Link" style="padding:0 10 0 23;" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="add_subheading.php" class="Link"><img src="/admin/images/title.gif" alt="New Sub Heading" style="vertical-align:middle;" /> <span style="vertical-align:middle;">Add New Sub Heading</span></a></td>
					</tr>
					<tr>
						<td height="25" class="Link" style="padding:0 10 0 23;" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="site_map.php" class="Link"> <span style="vertical-align:middle;">:: Update Site Map</span></a></td>
					</tr>
				</table>
			</td>
			<td>
				<!-- Open the Pages table -->
				<table border="0" cellpadding="2" cellspacing="2" style="border:1px solid black;">
					<tr>
						<td style="background-color:skyblue;"><b>Page Name</b></td>
						<td style="background-color:skyblue;"><b>Page URL</b></td>
						<td style="background-color:skyblue;"><b>Last Modified</b></td>
						<td style="background-color:skyblue;">&nbsp;</td>
						<td style="background-color:skyblue;">&nbsp;</td>
						<td style="background-color:skyblue;">&nbsp;</td>
						<td style="background-color:skyblue;">&nbsp;</td>
						<td style="background-color:skyblue;">&nbsp;</td>
						<td style="background-color:skyblue;">&nbsp;</td>
						<td style="background-color:skyblue;">&nbsp;</td>
					</tr>
					<!-- Start the list of pages -->
					<?php
					page_list ('Main', 0);
					?>
				</table> 
				<!-- Close the Pages table. -->
			</td>
		</tr>
	</table>
	<?php
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>