<?php // page_content_overview.php (administration side) Friday, 8 April 2005

// Set the page title.
$page_title = "Page Content";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 
	if ($_POST['submit'] == "Move Page") {
	
		$query="
			SELECT MAX(sort_order) 
			FROM menu_links 
			WHERE parent_id={$_POST['parent']}
			";
		$result = mysql_query($query);
		
		$max_place = mysql_result($result,0,"max(sort_order)");
	 	$max_place = $max_place + 1;
		
		$query = "
			UPDATE menu_links
			SET parent_id={$_POST['parent']}, sort_order=$max_place,  modified_date=NOW()
			WHERE links_id={$_POST['lid']}
			";
		$result = mysql_query ($query);
		print $query . "<br />";
		$query = "
			UPDATE menu_links
			SET sort_order=sort_order-1
			WHERE parent_id={$_POST['op']}
			AND sort_order>{$_POST['so']}
			";
		$result = mysql_query ($query);
		print $query . "<br />";
		ob_end_clean ();
		header ("Location: $https/admin/modules/pages/index.php");
		exit ();
	
	} elseif (isset ($_GET['lid'])) {
	
		$query = "
			SELECT *
			FROM menu_links AS ml, menu_parent AS mp
			WHERE ml.links_id={$_GET['lid']}
			AND ml.parent_id=mp.parent_id 
			";
		$result = mysql_query ($query);
		$parent = mysql_result ($result, 0, "parent");
		$title = mysql_result ($result, 0, "title");
		$sort_order = mysql_result ($result, 0, "sort_order");
		$old_parent = mysql_result ($result, 0, "parent_id");
		
		?>
		<form action="merge.php" method="post">
		<table border="0" cellpadding="2" cellspacing="2">
			<tr>
				<td><b>Old Parent:</b></td>
				<td><?=$parent?></td>
			</tr>
			<tr>
				<td colspan="2"><b>Move the <?=$title?> page to:</b></td>
			</tr>
			<tr>
				<td colspan="2">
				<?php
				$query = "
					SELECT *
					FROM menu_parent
					";
				$result = mysql_query ($query);
				
				while ($row = mysql_fetch_array ($result, MYSQL_NUM)) {
					?>
					<input type="radio" name="parent" value="<?=$row[0]?>" /><?=$row[1]?><br />
					<?php
				}
				
				?>
				<input type="hidden" name="lid" value="<?=$_GET['lid']?>" /><input type="hidden" name="so" value="<?=$sort_order?>" /><input type="hidden" name="op" value="<?=$old_parent?>" /></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center"><input type="submit" name="submit" value="Move Page" /></td>
			</tr>
		</table>
		</form>
		
		<?php
		
	} else {
	 	ob_end_clean ();
		header ("Location: $https/admin/modules/pages/index.php");
		exit ();
	}

}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>