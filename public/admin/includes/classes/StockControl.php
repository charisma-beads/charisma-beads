<?php
/* 
 * StockControl.php
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
 * Controls the stock levels of the ShoppingCart Class
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class StockControl extends ShoppingCart
{
    /**
     * Returns stock from carts
     * 
     * @param array $cart cart array items
     * @return bool
     * @access private
     */
    private function returnStock($cart) {
        $update_check = array();
        
        foreach ($cart as $key => $value) {

            $num = $this->checkStock($key);
            
            // if item is a stock item, put it back else
            if ($num === false) {
                $this->debugMsg[] = "Can't determine how much stock there due to database error.";
                $update_check[$key] = false;
            } elseif ($num > -1) {
                $this->debugMsg[] = "$num items avaliable. Adding $value items back ...";
                $updateStock = $this->updateStock($key, $num + $value);

                if ($updateStock) {
                    $update_check[$key] = true;
                } else {
                    $update_check[$key] = false;
                }
            } else {
                $update_check[$key] = true;
            }
        }

        $success = true;
        
        /**
         * Check everything went OK.
         * If there is one error return a failure on that one.
         *
         * @todo Keep item in cart if fails to return to stock?
         */
        foreach ($update_check as $key => $value) {
            if (!$value) {
                $success = false;
            }
        }
        
        return $success;
    }

    /**
     * Deletes the cart items form the database, but first returns all
     * unsed stock if needed.
     *
     * @param bool $return_stock Whether to return stock to database
     * or not. Default true.
     * @return bool Reurns true on success
     * @access public
     */
	public function deleteCart($return_stock = true)
	{
        if ($return_stock) {
            $returnStock = $this->returnStock($this->cart_items);
        }
        
        return parent::deleteCart();
	}
    
    /**
     * Adds a product to the cart.
     *
     * @param int $item product id
     * @return none
     * @access public
     */
	public function addItem($item)
    {
        $num = $this->checkStock($item);
        
        // If we can update the stock then add item to cart.
        if ($num > 0) {
            $update = $this->updateStock($item, $num - 1);

            if ($update) {
                $add = true;
            } else {
                $add = false;
            }
        } elseif ($num == -1) {
            $add = true;
        } else {
            $add = false;
        }
        
        if ($add) {
           $addItem = parent::addItem($item);
        }
        return $add;
    }

    /**
     * Updates quantity of product if quanity is zero then removes
     * the item from the cart.
     *
     * @param int $item product id
     * @param int $qty quantity to update
     * @return none
     * @access public
     */
	public function updateItem($item, $qty)
	{
        // Check for positive number
        if (!array_key_exists($item, $this->cart_items) || $qty < 0) {
            return;
        }

        // We have to find if we are adding or removing from cart.
        $currQty = $this->cart_items[$item];

        $num = $this->checkStock($item);
        
        if ($num == -1) {
            $updateItem = parent::updateItem($item, $qty);
        } elseif ($qty == 0) {
            $removeItem0 = $this->removeItem($item);
        } elseif ($currQty < $qty) {
            /* FIX ME */
            // remove the difference from stock.
            $diff = $qty - $currQty;

            /**
             * Now what if the customer request more items
             * than we have in stock?
             */
            if ($num < $diff) {
                $this->debugMsg[] = "can't do $qty items so will ".($num + $this->cart_items[$item])." items do?";
                $diff = $num;
                $qty = $num + $this->cart_items[$item];
            }

            $updateStock0 = $this->updateStock($item, $num - $diff);

            // if update didn't work return.
            if (!$updateStock0) {
                return;
            }

            $updateItem = parent::updateItem($item, $qty);
        } elseif ($currQty > $qty) {
            // add the difference back into stock.
            $diff = $currQty - $qty;
            $returnStock2 = $this->returnStock(array($item => $diff));

            // if update didn't work return.
            if (!$returnStock2) {
                return false;
            }

            $updateItem = parent::updateItem($item, $qty);
        } else {
            return false;
        }
	}

    /**
     * Removes a product from the cart.
     *
     * @param int $item product id
     * @return none
     * @access public
     */
	public function removeItem($item)
	{
        // Check to see if item is in cart then remove it.
        if (array_key_exists($item, $this->cart_items)) {
            $cart = array($item => $this->cart_items[$item]);
            $returnStock1 = $this->returnStock($cart);

            if (!$returnStock1) {
                return;
            }
        }

        $removeItem = parent::removeItem($item);
	}

    /**
     * Empties the cart and returns the stock.
     *
     * @param none
     * @return none
     * @access public
     */
    public function emptyCart() {

        if (!empty($this->cart_items)) {
            $returnStock3 = $this->returnStock($this->cart_items);
        } else {
            $returnStock3 = false;
        }

        if ($returnStock3) {
            $emptyCart = parent::emptyCart();
        }
    }

    /**
     * Updates the stock in the datadase
     *
     * @param int $pid product id
     * @param int $qty new quantity to set.
     * @return bool reurns true on success
     * @access public
     */
    public function updateStock($pid, $qty)
    {
        /**
         * neds fixes removes item on updating a positive.
         */
        $query = "
            UPDATE products
            SET quantity = $qty
            WHERE product_id = $pid
            ";
        $result = mysql_query($query, $this->db) or
            $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);

        if ($result === true) {
            if (mysql_affected_rows($this->db) == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Checks stock levels of product in database
     *
     * @param int product id
     * @return bool returns quantity or false if quantity = 0;
     * @access public
     */
    public function checkStock($pid)
    {
        $query = "
            SELECT quantity
            FROM products
            WHERE product_id = $pid
            ";
        $result = mysql_query($query, $this->db) or
            $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);
        
        if ($result) {
            $qty = mysql_result($result, 0, 'quantity');
            return $qty;
        } else {
            return false;
        }
    }

    /**
     * Garbage collection for shoppingcart table.
     *
     * @param none
     * @return mixed returns number of rows deleted or false if none.
     * @access protected
     */
    protected function gc()
    {
        $daysToExpire = time()-129600;
        
        $this->debugMsg[] = "Starting StockControl gc ...";
        $query = "
            SELECT cart
            FROM shoppingcart
            WHERE expires < ".time()."
            OR cdate <= '".$daysToExpire."'
        ";
        
        $result = mysql_query($query, $this->db) or
            $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);
		
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            $cart = unserialize($row[0]);
            $returnStock0 = $this->returnStock($cart);
        }
        
        return parent::gc();
    }
}
?>
