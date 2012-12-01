<?php
/* 
 * mini_cart.php
 * 
 * Copyright (c) 2010 Shaun Freeman <shaun@shaunfreeman.co.uk>.
 * 
 * This file is part of Charisma-Beads.
 * 
 * Charisma-Beads is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Charisma-Beads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Charisma-Beads.  If not, see <http ://www.gnu.org/licenses/>.
 */

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

} else {
    exit();
}

$cart->ajax = true;

switch ($action) {
    case 'add':
        $addItem = $cart->addItem($item);
        $itemQty = $cart->getItemQty($item);
        $json = json_encode(array(
            'type' => 'add',
            'miniCart' => $cart->__toString(),
            'stock' => $itemQty,
            'added' => true
        ));
        break;

    case 'remove':
        $removeItem = $cart->removeItem($item);
        $json = json_encode(array(
            'type' => 'remove',
            'cart' => $cart->ViewCart(),
            'miniCart' => $cart->__toString(),
            'stock' => $cart->getItemQty($item)
        ));
        break;

    case 'update':
        $updateItems = $cart->updateItems($items);
        $json = json_encode(array(
            'type' => 'update',
            'cart' => $cart->ViewCart(),
            'miniCart' => $cart->__toString(),
            'stock' => $updateItems
        ));
        break;

    case 'empty':
        $emptyCart = $cart->emptyCart();
        $json = json_encode(array(
            'type' => 'empty',
            'cart' => $cart->ViewCart(),
            'miniCart' => $cart->__toString(),
            'stock' => $emptyCart
        ));
        break;

    case 'view':
        $json = json_encode(array(
            'type' => 'view',
            'cart' => $cart->ViewCart()
        ));
        break;
}

print $json;
$storeCart = $cart->storeCart();
?>
