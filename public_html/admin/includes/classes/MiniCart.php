<?php
/*
 * MiniCart.php
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

/**
 * Description of MiniCart
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class MiniCart extends StockControl
{
    public $ajax = false;
    /**
     * html string of cart contents.
     *
     * @param none
     * @method string
     * @return string
     * @access public
     */
    public function __toString()
    {
        $items = $this->getNumCartItems();

        if ($items > 0) {

            $html = "<p><span id=\"num_items\">$items</span> items</p>";
            $html .= "<p>";
            $html .= "<span>Total: &pound;<span id=\"subtotal\">";

            // Do we need to caluclate cart totals?
            if (!$this->view) {
                $this->calculateCartItems();
                $this->calculatePostage();
            }

            $html .= number_format($this->totals['subTotal'] + $this->totals['postCost'], 2);
            $html .= "</span></span><br />";

        } else {
            $html = "<p>Your Cart is currently empty.</p>";
        }
        
        return ($this->ajax) ? $html : Utility::templateParser(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/shop/html/miniCart.html'), array('CART' => $html), '<!--', '-->');
    }

    /**
     *
     * @param <type> $pid
     * @param <type> $addItem
     * @return <type>
     */
    public function getItemQty($pid)
    {
        $query = "
            SELECT product_name, quantity
            FROM products
            WHERE product_id = $pid
        ";

        $result = mysql_query($query, $this->db) or
            $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);

        $row = mysql_fetch_row($result);
        
        return array(
            'itemName' => $row[0],
            'itemPid' => $pid,
            'itemQty' => $row[1]
        );
    }

    /**
     *
     * @return <type> 
     */
    public function viewCart() {
        $html = parent::viewCart();
        if ($this->ajax) $html = Utility::removeSection($html, 'cart_buttons');
        return $html;
    }

    public function  emptyCart() {
        $items = array_keys($this->cart_items);
		$itemQty = array();
        parent::emptyCart();

        foreach ($items as $value) {
            $itemQty[] = $this->getItemQty($value);
        }
        return $itemQty;
    }

    public function  updateItems($items) {
        $cartItems = array_keys($this->cart_items);
        parent::updateItems($items);

        foreach ($cartItems as $value) {
            $itemQty[] = $this->getItemQty($value);
        }
        return $itemQty;
    }
}
?>
