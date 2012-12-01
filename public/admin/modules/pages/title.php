<?php // page_content_overview.php (administration side) Friday, 8 April 2005

// Set the page title.
$page_title = "Page Content";

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 

	if ($_POST['submit'] == "Update Title") {
	
		$title = ucwords (strtolower (escape_data($_POST['title'])));
		$PageName = str_replace (" ", "_", strtolower (Utility::filterString(escape_data($_POST['title']))));
		$url = "pages/{$PageName}.php";

        $query = "
			SELECT page_id, title
			FROM menu_links
			WHERE links_id={$_POST['lid']}
			";
        
		$result = mysql_query ($query);
        $row = mysql_fetch_row($result, MYSQL_ASSOC);
        $page_id = $row['page_id'];

        $query = "
            SELECT parent_id
            FROM menu_parent
            WHERE parent = '".$row['title']."'
        ";
        $result = mysql_query($query);

        // update parent if need to.
        if (mysql_num_rows($result) == 1) {
            $row = mysql_fetch_row($result, MYSQL_ASSOC);
            print_r($row);
            $query = "
                UPDATE menu_parent
                SET parent='$title'
                WHERE parent_id=".$row['parent_id'];
            
            $result = mysql_query($query);
        }

        // update pages.
        if ($page_id == 0) {
            $query = "
				INSERT INTO pages (page, date_entered)
				VALUES ('$title', NOW() );
				";
			$result = mysql_query ($query);
			$page_id = mysql_insert_id();
        } else {
            $query = "
                UPDATE pages
                SET page='$title'
                WHERE page_id=$page_id
                ";
            $result = mysql_query($query);
        }

		$query = "
			UPDATE menu_links
			SET title='$title',
            page_id = $page_id,
            url = '$url'
			WHERE links_id={$_POST['lid']}
			";
		$result = mysql_query ($query);
		
		ob_end_clean ();
		header ("Location: $https/admin/modules/pages/index.php");
		exit ();
	
	} elseif (isset ($_GET['lid'])) {
	
		$query = "
			SELECT title
			FROM menu_links
			WHERE links_id={$_GET['lid']}
			";
		
		$result = mysql_query ($query);
		$title = mysql_result ($result, 0, "title");
		
		?>
		<form action="title.php" method="post">
		<table border="0" cellpadding="2" cellspacing="2">
			<tr>
				<td><b>Old Title:</b></td>
				<td><?=$title?></td>
			</tr>
			<tr>
				<td><b>New Title:</b></td>
				<td><input type="text" name="title" size="15" value="" /><input type="hidden" name="lid" value="<?=$_GET['lid']?>" /></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center"><input type="submit" name="submit" value="Update Title" /></td>
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
