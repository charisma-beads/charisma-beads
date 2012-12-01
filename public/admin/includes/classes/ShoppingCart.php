<?php
/*
 * ShoppingCart.php
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
 * Controls the shopping cart for Charisma Bead Ltd
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @property ErrorLogging $error
 */
class ShoppingCart
{
    /**
     * Holds the database resource
     * 
     * @var resource $db
     * @access protected
     */
    protected $db;

    /**
     * Holds the cart items
     * 
     * @var array $cart_items holds all the cart items.
     * @access public
     */
	public $cart_items = array();

    /**
     * Holds all the cart totals.
     *
     * @var array $totals
     * @access public
     */
    public $totals = array(
        'subTotal'      => 0,
        'taxTotal'      => 0,
        'postWeight'    => 0,
        'noPostage'     => 0,
        'postTax'       => 0,
        'postCost'      => 0
    );

    /**
     * Holds the tax state of the cart
     * <pre>
     * Default : false
     * </pre>
     * 
     * @var bool $tax_state Whether to calculate tax or not.
     * @access private
     */
    private $tax_state = false;
    
    /**
     * Holds the customer id or session id to reference
     * cart in database.
     * 
     * @var string $cart_id
     * @access protected
     */
    protected $cart_id;

    /**
     * Holds the cart expire time for user and guuest.
     *
     * @var array Keys used 'user' and 'guest' time in seconds
     * @access private
     */
    private $cart_expires = array('user' => 86400, 'guest' => 86400);

    /**
     * Time in seconds for the cart in database to expire.
     * Defalut 30 minutes
     * 
     * @var int $expires
     * @access private
     */
    private $expires = 1800;

    /**
     * Holds the error logging object.
     *
     * @var obj $error ErrorLogging Class
     * @access protected
     */
    protected $error;

    /**
     * Holds the debug messages.
     *
     * @var array $debugMsg
     * @access protected
     */
    protected $debugMsg = array();

    /**
     * Set debugging on or off.
     *
     * @var bool $debug Defaul: false
     * @access private
     */
    private $debug = false;

    /**
     * The referer link to log where you came from.
     * 
     * @var string
     * @access public
     */
    public $referer = null;

    /**
     * Marker to set if we have displayed the cart allready.
     * 
     * @var bool
     * @access public
     */
    public $view = false;

    /**
     * Setup Cart Class, if a unique id is not in the
     * session then create one.
     * 
     * <pre>
     * Options:
     * tax_state bool
     * stock_control bool
     * cart_expires array Keys used 'user' and 'guest' time in seconds
     * for cart to expire in database.
     * </pre>
     *
     * @param array $options array containing options to set.
     * @return ShoppingCart
     * @access public
     */
	public function __construct($options)
	{   
        // Set options.
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                $this->$key = $value;
            }
        }

        $this->error = ErrorLogging::getInstance();
        $this->runGc();

        //print_r($_COOKIE);
        // Set cart id.
        if (isset($_COOKIE['CBShoppingCart'])) {
            $this->cart_id = $_COOKIE['CBShoppingCart'];
        } else {
            $this->cart_id = sha1(uniqid());
        }

        if (isset($_SESSION['cid'])) {
            $this->expires = $this->cart_expires['user'];
        } else {
            $this->expires = $this->cart_expires['guest'];
        }

        // Retrieve cart if there is one.
        $retrieveCart = $this->retrieveCart();
	}

    /**
     * Run garbage collection on database.
     *
     * @param none
     * @return none
     * @access protected
     */
    protected function runGc() {
        if (isset($_SESSION['gc'])) {
            $this->debugMsg[] = "garbage already collected this session.";
        } else {
            $gc = $this->gc();
            
            if (is_bool($gc) === false) {
                $_SESSION['gc'] = true;
                $this->debugMsg[] = "garbage collected: $gc records deleted";
            } else {
                $this->debugMsg[] = "garbage collection went wrong";
            }
        }

        if ($this->debug) {
            foreach ($this->debugMsg as $msg) {
                echo '<p>'.$msg."</p>";
            }
        }
    }

    /**
     * Stores the cart in the database
     *
     * @return bool Returns true on success
     * @access public
     */
	public function storeCart()
	{
        $exp = time() + $this->expires;
        $items = serialize($this->cart_items);
        
        setcookie('CBShoppingCart', $this->cart_id, $exp, '/');

        $query = "
            SELECT cart_id
            FROM shoppingcart
            WHERE cart_id='{$this->cart_id}'
        ";

        $result = mysql_query($query, $this->db)
            or $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);

        if ($result) {
            if (mysql_num_rows($result) == 1) {
                $query = "
                    UPDATE shoppingcart
                    SET cart='".$items."', expires='".$exp."'
                    WHERE cart_id='".$this->cart_id."'
                ";
            } else {
                 $query = "
                    INSERT INTO shoppingcart (cart_id, cart, expires, cdate)
                    VALUES ('".$this->cart_id."','".$items."','".$exp."', '".time()."')
                ";
            }

            $result = mysql_query($query, $this->db) or
                $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);
        }
	}

    /**
     * Retrieves the cart items form the database.
     *
     * @return none
     * @access public
     */
	public function retrieveCart()
	{
        $query = "
            SELECT cart
            FROM shoppingcart
            WHERE cart_id = '{$this->cart_id}'
        ";
        
        $result = mysql_query($query, $this->db) or
            $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);

        if ($result) {
             if (mysql_num_rows($result) == 1) {
                $this->cart_items = unserialize(mysql_result($result, 0, 'cart'));
             }
        }
	}

    /**
     * Deletes the cart items form the database.
     *
     * @param none
     * @return bool Reurns no of affected rows on success or
     * false on failure.
     * @access public
     */
	public function deleteCart()
	{
        $query = "
            DELETE FROM shoppingcart
            WHERE cart_id = '".$this->cart_id."'
            ";
        $result = mysql_query($query, $this->db) or
            $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);

        if ($result) {
            setcookie('CBShoppingCart','',time()-2592000);
            unset($_COOKIE['CBShoppingCart']);
            return mysql_affected_rows($this->db);
        } else {
            return false;
        }
	}

    /**
     * Returns the number of items in Shopping Cart.
     * 
     * @param none
     * @return int
     * @access public
     */
    public function getNumCartItems()
    {
        $items = 0;

        foreach ($this->cart_items as $key => $value) {
            $items += $value;
        }

        return $items;
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
        if (isset($this->cart_items[$item])) {
            $this->cart_items[$item] = $this->cart_items[$item] + 1;
        } else {
            $this->cart_items[$item] = 1;
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
        if (array_key_exists($item, $this->cart_items)) {
            unset($this->cart_items[$item]);
        }
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
        // Check for positive number.
        if ($qty < 0) {
            return;
        }
        
        if ($qty == 0) {
            $removeItem = $this->removeItem($item);
        } else {
            $this->cart_items[$item] = $qty;
        }
	}

    /**
     * Update cart with an array of items
     * 
     * @param array $items An associative with product id as keys
     * and quantities as values.
     * @return bool returns true on success else false
     */
    public function updateItems($items)
    {
        if (is_array($items)) {
            foreach ($items as $item => $qty) {
                $this->debugMsg[] = "updating item $item: {$this->cart_items[$item]} to $qty ...";
                $updateItem = $this->updateItem($item, $qty);
            }
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Empties the cart
     * 
     * @param none
     * @return none
     * @access public
     */
    public function emptyCart()
    {
        $this->cart_items = array();
    }

    /**
     * Returns a html string with all cart totals.
     *
     * @param none
     * @return string $html String containing the html formated table with totals
     * @access public
     */
	public function viewCart()
	{
        global $https;
        
        if (empty($this->cart_items)) {
            $html = '<h3>Shopping cart is empty</h3>';
        } else {
            $vc = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/shop/html/viewCart.html');
            $html = Utility::templateParser($vc, array('CART_BODY' => $this->displayCart(), 'URL' => $https, 'REFERER' => '&'.$this->referer), '{', '}');
        }

        // when we have retrieved the view set marker as we will not need to recalculate cart.
        $this->view = true;
        
        return Utility::removeSection($html, 'item_quantity');
	}

    public function displayCart()
    {
        $cb = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/shop/html/cartBody.html');
		$ci = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/shop/html/cartItems.html');

        // If tax state is off, remove the tax section from template.
        if (!$this->tax_state) {
            $ci = Utility::removeSection($ci, 'tax');
            $cb = Utility::removeSection($cb, 'tax');
        }

        // Set column spans.
		$params = array(
			'COLSPAN' => ($this->tax_state == 1) ? 3 : 2,
			'CART_ITEMS' => null
		);

		$items = $this->calculateCartItems();

		if (is_array($items)):
			foreach ($items as $item):
				$tr = Utility::templateParser($ci, $item, '{', '}');
				$params['CART_ITEMS'] .= $tr;
			endforeach;

			if (isset($_SESSION['CountryCode'])):
				$this->calculatePostage();
			else:
				$this->totals['postCost'] = 0;
				$this->totals['postTax'] = 0;
				$cb = Utility::removeSection($cb, 'postage');
			endif;

			$params = array_merge($params, $this->getCartTotals());
			$html = Utility::templateParser($cb, $params, '{', '}');
		else:
			$html = $items;
		endif;
        
        if ($this->referer) {
            $html .= '<input type="hidden" name="query_string" value="'.$this->referer.'" />';
        }
        
		return $html;
    }

    /**
     * Gets all the cart totals for the template.
     *
     * @param none
     * @return array
     * @access public
     */
	public function getCartTotals()
	{
        $cart_total['POST_COST'] = number_format($this->totals['postCost'], 2);
		$cart_total['VAT_TOTAL'] = number_format($this->totals['taxTotal'] + $this->totals['postTax'], 2);
		$cart_total['CART_TOTAL'] = number_format($this->totals['subTotal'] + $this->totals['postCost'], 2);
		return $cart_total;
	}

    /**
     * Calulates the totals of each item in the cart.
     *
     * @param none
     * @return array
     * @access public
     */
	public function calculateCartItems()
	{
        global $https;
        
        $this->totals = array(
            'subTotal'      => 0,
            'taxTotal'      => 0,
            'postWeight'    => 0,
            'noPostage'     => 0,
            'postTax'       => 0,
            'postCost'      => 0
        );
        
        // Build the query. Get all the product ids and query database in one call.
        $queryIds = null;

        foreach ($this->cart_items as $key => $value) {
            $queryIds .= $key.',';
        }

        $queryIds = substr($queryIds, 0, -1);
        
        $query = "
            SELECT category_id, image, product_id, product_name, short_description, image_status, price, vat_inc, tax_rate, postunit, postage
            FROM products AS p, tax_codes AS tc, tax_rates AS tr, product_postunit AS pu
            WHERE product_id IN ($queryIds)
            AND p.tax_code_id=tc.tax_code_id
            AND tc.tax_rate_id=tr.tax_rate_id
            AND p.postunit_id=pu.postunit_id
            ORDER BY category_id, product_name ASC
        ";
        $result = mysql_query($query, $this->db) or
            $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);

        $items = array();
        $tree = new NestedTree('product_category', NULL, 'category', $this->db);
        $product_img_dir = "/shop/images/";
        
        while ($row = mysql_fetch_object($result)) {
            
            $tax_array = $this->calculateTax($row->price, $row->tax_rate, $row->vat_inc);

            $itemTotal = ($tax_array['price'] * ($this->cart_items[$row->product_id]) + $tax_array['tax']);
			$this->totals['subTotal'] += $itemTotal;
			$this->totals['taxTotal'] += $tax_array['tax'] * $this->cart_items[$row->product_id];

            // Calculate postage.
            if ($row->postage == 1) {
                $this->totals['postWeight'] += $row->postunit * $this->cart_items[$row->product_id];
            } else {
                $this->totals['noPostage'] += $tax_array['price'] + $tax_array['tax'];
            }

            // Image check
            $img = $product_img_dir.$row->image;

            $img = Utility::getShopImage($img);

            // Get category pathway.
            $category = null;
            foreach ($tree->pathway($row->category_id) as $id => $path) {
                $category .= " - " . $path['category'];
            }

            $category = substr($category,3);

            $items[] = array(
				'PRODUCT_ID' => $row->product_id,
                'REFERER' => $this->referer,
				'QUANTITY' => $this->cart_items[$row->product_id],
				'SKU' => $row->product_name,
				'NAME' => $category . ' - ' . $row->short_description,
				'PRICE' => $tax_array['price'],
				'TAX' => $tax_array['tax'],
				'TOTAL' => number_format($itemTotal,2),
				'IMAGE' => '<img src="'.$img.'" style="border: 3px double #AFA582;" />',
				'IMAGE_STATUS' => 'image_'.$row->image_status
			);
        }

        return $items;
	}

    /**
     * Calulates the postage total of the cart.
     *
     * @param none
     * @return none
     * @access public
     */
	public function calculatePostage()
	{
        global $PostState;

        if (isset($_SESSION['CountryCode'])) {
            $CountryCode = $_SESSION['CountryCode'];
        } else {
            $CountryCode = 0;
        }

		if ($PostState == 1):
			$itemLevel = $this->totals['postWeight'];
		else:
			$itemLevel = $this->totals['subTotal'] - $this->totals['noPostage'];
		endif;

		if ($itemLevel == $this->totals['noPostage']):
			$this->totals['postTax'] = 0;
			$this->totals['postCost'] = 0;
			return;
		endif;

		$query = "
            SELECT cost, post_level, vat_inc, tax_rate
            FROM countries, post_zones, post_cost, post_level, tax_codes, tax_rates
            WHERE countries.country_id=$CountryCode
            AND countries.post_zone_id=post_zones.post_zone_id
            AND post_cost.post_level_id=post_level.post_level_id
            AND post_zones.tax_code_id=tax_codes.tax_code_id
            AND post_zones.post_zone_id=post_cost.post_zone_id
            AND tax_codes.tax_rate_id=tax_rates.tax_rate_id
            ORDER BY post_level ASC
        ";
        
         $result = mysql_query($query, $this->db) or
            $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);

        $postVatInc = 0;
		$postTaxRate = 0;
        
		while ($row = mysql_fetch_object ($result)) {
			if ($itemLevel > $row->post_level):
				$this->totals['postCost'] = $row->cost;
				$postVatInc = $row->vat_inc;
				$postTaxRate = $row->tax_rate;
			endif;
        }

		$tax_array = $this->calculateTax($this->totals['postCost'], 1, $postTaxRate, $postVatInc);

		$this->totals['postTax'] = $tax_array['tax'];
		$this->ctotals['postCost'] = $tax_array['price'] + $tax_array['tax'];
	}

    /**
     * Catulates the Tax.
     *
     * @param int $price The price to calculate
     * @param int $tax_rate the tax rate expresed by decimal eg: 17.5% = 1.175
     * @param bool $tax_inc Wether tax is included
     * @return array Returns an associative array with price and tax calucations.
     * @access private
     */
	private function calculateTax($price, $tax_rate, $tax_inc)
	{
        if ($this->tax_state && $tax_rate != 0) {
            if (!$tax_inc) {
                $pat = round(($price * $tax_rate), 2);
                $tax = $pat - $price;
            } else {
                $pbt = round(($price / $tax_rate), 2);
                $tax = $price - $pbt;
                $price = $pbt;
            }
        } else {
            $tax = 0;
        }

        return array(
            'tax' => number_format($tax, 2),
            'price' => number_format($price, 2)
        );
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
        
        $this->debugMsg[] = "Starting ShoppingCart gc ...";
        $query = "
            DELETE FROM shoppingcart
            WHERE expires < '".time()."'
            OR cdate <= '".$daysToExpire."'
            ";
        $result = mysql_query($query, $this->db) or
            $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);
        
        if ($result === true) {
            return mysql_affected_rows($this->db);
        } else {
            return false;
        }
    }
}

?>
