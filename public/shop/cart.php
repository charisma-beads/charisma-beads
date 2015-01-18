<?php
/* 
 * cart.php
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
$page_title = "View Cart";
// Include configuration file for error management and such.
// Include functions.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');

if (isset($_GET['action'])) {
    if (isset($_GET['pid']) && is_numeric($_GET['pid'])) {
        $item = Utility::escape($_GET['pid']);
    }
    
    $action = Utility::escape($_GET['action']);

    if (isset($_POST['items']) && is_array($_POST['items'])) {
        foreach ($_POST['items'] as $key => $value) {
            if (is_numeric($key) && is_numeric($value)) {
                $items[$key] = $value;
            }
        }
    }

    // Check from where we came from.
    if (isset($_SESSION['queryString'])) {
        $referer_link = $_SESSION['queryString'];
    } else {
        $referer_link = null;
    }

} else {
    Utility::go('index.php');
}

$cart->referer = $referer_link;

$content .= Utility::returnLink($referer_link, 'Continue Shopping');

switch ($action) {
    case 'add':
        $addItem = $cart->addItem($item);
        break;

    case 'remove':
        $removeItem = $cart->removeItem($item);
        break;

    case 'update':
        $updateItems = $cart->updateItems($items);
        break;

    case 'empty':
        $emptyCart = $cart->emptyCart();
        break;
}

$content .= $cart->viewCart();

$storeCart = $cart->storeCart();

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>
