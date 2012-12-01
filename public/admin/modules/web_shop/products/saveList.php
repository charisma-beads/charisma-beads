<?php
ob_start();

require_once ($_SERVER['DOCUMENT_ROOT'] . "/../data/merchant_data.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/global_config.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/../data/database.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/mysql_connect.php");
$session = Session::getInstance(60*60*24);
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/authentication.php");

// Print a message based on authentication.
if (!$authorized) {

	echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';

} else {

	if (isset($_POST['el']) && isset($_POST['prev']) && $_POST['insert_type']) {

		// start tree class
		$tree = new NestedTree('product_category', NULL, 'category', $dbc);

		$parent_id = $_POST['prev'];
		$id = $_POST['el'];

		if ($parent_id == "category_list") $parent_id = 0; // top ot the list

		$tree->setId($id);

		// Get the element and it's children.
		$category_list = $tree->getDecendants();

		if ($parent_id != 0) {
			$tree->setId($parent_id);
			$parent = $tree->getDecendants();
		} else {
			$parent = array('lft' => 0, 'rgt' => 0);
		}

		$width = ($category_list[0]['rgt'] - $category_list[0]['lft']) + 1;

		// take out the left and right values of list from database.
		$query = "
			UPDATE product_category
			SET
				lft=NULL,
	 			rgt=NULL
			WHERE lft
				BETWEEN ".$category_list[0]['lft']."
				AND ".$category_list[0]['rgt']."
			";

		$result = mysql_query($query);

		// update left and right values.
		$query = "
			UPDATE product_category
			SET
				rgt = rgt - $width
			WHERE rgt > ".$category_list[0]['rgt']."
			";

		$result = mysql_query($query);

		$query = "
			UPDATE product_category
			SET
				lft = lft - $width
			WHERE lft > ".$category_list[0]['rgt']."
			";

		$result = mysql_query($query);

		// reset the parent as it has changed.
		if ($parent_id != 0) {
			$tree->setId($parent_id);
			$parent = $tree->getDecendants();
		}

		// now make room for moved category.
		if ($parent_id == 0) {
			$query = "
				UPDATE product_category
				SET
					rgt = rgt + $width
				WHERE rgt > ".($parent[0]['lft'] - 1)."
				";

			$result = mysql_query($query);

			$query = "
				UPDATE product_category
				SET
					lft = lft + $width
				WHERE lft > ".($parent[0]['lft'] - 1)."
				";

			$result = mysql_query($query);
		} else {
			switch ($_POST['insert_type']) {
				case 'after child':
					$query = "
							UPDATE product_category
							SET
							rgt = rgt + $width
							WHERE rgt > ".($parent[0]['rgt'])."
							";

					$result = mysql_query($query);

					$query = "
							UPDATE product_category
							SET
							lft = lft + $width
							WHERE lft > ".($parent[0]['rgt'])."
							";

					$result = mysql_query($query);
					break;
				case 'new child':
					$query = "
							UPDATE product_category
							SET
							rgt = rgt + $width
							WHERE rgt > ".($parent[0]['lft'])."
							";

					$result = mysql_query($query);

					$query = "
							UPDATE product_category
							SET
							lft = lft + $width
							WHERE lft > ".($parent[0]['lft'])."
							";

					$result = mysql_query($query);
					break;
			}
		}

		// now insert moved category.
		$reduce = $category_list[0]['rgt'] - $width;

		foreach ($category_list as $key => $value) {
			$value['lft'] = $value['lft'] - $reduce;
			$value['rgt'] = $value['rgt'] - $reduce;

			if ($parent_id == 0) {
				$query = "
					UPDATE product_category
					SET
						rgt = ".$value['rgt'].",
	 					lft = ".$value['lft']."
					WHERE category_id=".$value['category_id']."
					";

				$result = mysql_query($query);

			} else {
				switch ($_POST['insert_type']) {
					case 'after child':
						$query = "
							UPDATE product_category
							SET
								rgt = ".($value['rgt'] + $parent[0]['rgt']).",
								lft = ".($value['lft'] + $parent[0]['rgt'])."
							WHERE category_id=".$value['category_id']."
						";

						$result = mysql_query($query);
						break;
					case 'new child':
						$query = "
							UPDATE product_category
							SET
								rgt = ".($value['rgt'] + $parent[0]['lft']).",
								lft = ".($value['lft'] + $parent[0]['lft'])."
							WHERE category_id=".$value['category_id']."
						";

						$result = mysql_query($query);
						break;
				}

			}
		}

	}

}
// Flush the buffered output to the web browser.
ob_end_flush();
?>