<?php
/*
 * index.php
 *
 * Copyright (c) 2010 Shaun Freeman <shaun@shaunfreeman.co.uk>.
 *
 * This file is part of Charisma Beads.
 *
 * Charisma Beads is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Charisma Beads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Charisma Beads.  If not, see <http ://www.gnu.org/licenses/>.
 */

// Set the page title.

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');

// route to page.
//define ('PARENT_FILE', 1);
define ('REQUEST_URI', $_SERVER['REQUEST_URI']);

$path = Utility::getPath();

switch($path[0]):
	case 'pages':
		$page = $path[1];
		break;
	case 'shop':
		$ident = $path[1];
		include_once ($_SERVER['DOCUMENT_ROOT'] . '/shop/index.php');
		exit();
		break;
	default: $page = 1;
endswitch;

// update page stats.
$where = (is_int($page)) ? 'page_id=' . $page : "ident='$page'"; 
$query = "
	SELECT page_id, page, content
	FROM pages
	WHERE $where
	";
$result = mysql_fetch_array (mysql_query ($query), MYSQL_NUM);

if (!$result) {
    $page_title = "404 ERROR";
    $content = "<p>Sorry We cannot find the page you are looking for.</p><p>404 error: The page: $page doesn't exist</p>";
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
    exit();
}

$content = $result[2];
$page_title = $result[1];

$query = "
	SELECT hits
	FROM menu_links
	WHERE page_id={$result[0]}
	";
$result = mysql_query ($query);

if (is_resource($result)) {
	$hits = mysql_fetch_array ($result, MYSQL_NUM);

	$hits = $result[0] + 1; 
	$query = "
		UPDATE menu_links
		SET hits={$result[0]}
		WHERE page_id=1
	";
	$result1 = mysql_query ($query);
}

require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
?>
