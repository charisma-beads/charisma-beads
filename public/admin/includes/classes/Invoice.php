<?php
/* 
 * Invoice.php
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

/**
 * Description of Invoice
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Invoice
{
    protected $db;
    public $display_top;
    public $display_bottom;
    
    public function __construct($dbc)
    {
        $this->db = $dbc;
        $this->error = ErrorLogging::getInstance();
    }
    private function getMerchantInfo()
    {
        include($_SERVER['DOCUMENT_ROOT'] . "/../data/merchant_data.php");
        
        $i = "<table style=\"border: 1px solid black;\" align=\"right\">\r\n";
        $i .= "<tr><td style=\"background-color:skyblue;\" align=\"left\">From</td></tr>\r\n";
        $i .= "<tr><td align=\"left\">$merchant_name</td></tr>\r\n";
        $i .= "<tr><td align=\"left\">$merchant_address1,</td></tr>\r\n";
        if ($merchant_address2) $i .= "<tr><td align=\"left\">$merchant_address2,</td></tr>\r\n";
        $i .= "<tr><td align=\"left\">$merchant_city,</td></tr>\r\n";
        $i .= "<tr><td align=\"left\">$merchant_county.</td></tr>\r\n";
        $i .= "<tr><td align=\"left\">$merchant_post_code</td></tr>\r\n";
        //$i .= "<tr><td align=\"left\">$merchant_country</td></tr>\r\n";
        $i .= "<tr><td align=\"left\">$merchant_email</td></tr>\r\n";
        $i .= "<tr><td align=\"left\">Telephone: $merchant_phone</td></tr>";
        $i .= "<tr><td align=\"left\"><!-- INVOICE --></td></tr>\r\n";
        $i .= "<tr><td align=\"left\"><!-- DATE --></td></tr>\r\n";
        $i .= "</table>\r\n";

        return $i;
    }

    private function getUserInfo()
    {
        $user_info = array();
        
        $CIA = "
            SELECT CONCAT(prefix, ' ', first_name, ' ', last_name) as name, address1, address2, address3, city, county, post_code, country, phone, email, delivery_address_id, delivery_address
            FROM customers, countries, customer_prefix
            WHERE customer_id='{$_SESSION['cid']}'
            AND customers.country_id=countries.country_id
            AND customers.prefix_id=customer_prefix.prefix_id
            LIMIT 1
        ";
        $CIA = mysql_query($CIA, $this->db) or
            $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);
        $CIA = mysql_fetch_array ($CIA, MYSQL_ASSOC);

        if ($CIA['delivery_address'] == "Y") {
            $CDA = "
                SELECT *
                FROM customer_delivery_address, countries
                WHERE customer_id='{$_SESSION['cid']}'
                AND customer_delivery_address.country_id=countries.country_id
                LIMIT 1
            ";
            $CDA = mysql_query($CDA, $this->db) or
                $this->error->sqlErrorHandler(mysql_errno($this->db), mysql_error($this->db), $query);
            $CDA = mysql_fetch_array ($CDA, MYSQL_ASSOC);
        }

        // Display Customer Address.
        
        $user_info['info'] = "<table style=\"border: 1px solid black;\">\r\n";
        $user_info['info'] .= "<tr><td style=\"background-color:skyblue;\">Address</td></tr>\r\n";
        $user_info['info'] .= "<tr><td>{$CIA['name']}</td></tr>\r\n";
        $user_info['info'] .= "<tr><td>{$CIA['address1']},</td></tr>\r\n";
        if ($CIA['address2']) $user_info['info'] .= "<tr><td>{$CIA['address2']},</td></tr>\r\n";
        if ($CIA['address3']) $user_info['info'] .= "<tr><td>{$CIA['address3']},</td></tr>\r\n";
        $user_info['info'] .= "<tr><td>{$CIA['city']},</td></tr>\r\n";
        $user_info['info'] .= "<tr><td>{$CIA['county']}.</td></tr>\r\n";
        $user_info['info'] .= "<tr><td>{$CIA['post_code']}</td></tr>\r\n";
        $user_info['info'] .= "<tr><td>{$CIA['country']}</td></tr>\r\n";
        $user_info['info'] .= "<tr><td>Tel: {$CIA['phone']}</td></tr>\r\n";
        $user_info['info'] .= "</table>\r\n";
        //$i .= "</td>\r\n";
        //$i .= "<td valign=\"top\">\r\n";
        $user_info['cda'] = "<table style=\"border:1px solid black;\">\r\n";
        $user_info['cda'] .= "<tr><td style=\"background-color:skyblue; text-align:left;\">Delivery Address</td></tr>\r\n";
        if ($CIA['delivery_address'] == "Y") {
            $user_info['cda'] .= "<tr><td>{$CIA['name']}</td></tr>\r\n";
            $user_info['cda'] .= "<tr><td>{$CDA['address1']}, {$CDA['address2']}, {$CDA['address3']}</td></tr>\r\n";
            $user_info['cda'] .= "<tr><td>{$CDA['city']}, {$CDA['county']}, {$CDA['post_code']}</td></tr>\r\n";
            $user_info['cda'] .= "<tr><td>{$CDA['country']}</td></tr>\r\n";
            $user_info['cda'] .= "<tr><td>Tel: {$CDA['phone']}</td></tr>\r\n";
        } else {
            $user_info['cda'] .= "<tr><td style=\"font-weight:bold;\">Same as Address</td></tr>\r\n";
        }
        $user_info['cda'] .= "</table>\r\n";
        
        $user_info['email'] = $CIA['email'];
        $_SESSION['customer_email'] = $user_info['email'];
        return $user_info;
    }

    public function displayInvoice($user, $cart)
    {
        $html = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/shop/html/invoice.html');
        $user_info = $this->getUserInfo();

        $params = array(
			'CART' => $cart->displayCart(),
			'USER_INFO' => $user_info['info'],
			'USER_CDA' => $user_info['cda'],
			'USER_EMAIL' => $user_info['email'],
			'MERCHANT_DETAILS' => $this->getMerchantInfo()
		);

        if ($this->display_top) $params['INVOICE_TOP'] = $this->display_top;
        if ($this->display_bottom) $params['INVOICE_BOTTOM'] = $this->display_bottom;

		$html = Utility::templateParser($html, $params, '{', '}');

		$html = preg_replace("/<th>(.*?)<\/th>/s", "", $html);

		$remove = array('delete_item', 'item_quantity_input');
		if (!$this->display_top) $remove[] = 'top';
		if (!$this->display_bottom) $remove[] = "bottom";

		foreach ($remove as $value) $html = Utility::removeSection($html, $value);

        $cart->view = true;

		return $html;
    }

    public function fixPrices($cart)
    {
        /* @var $cart ShoppingCart */
        $items = $cart->calculateCartItems();
        $cart->calculatePostage();
        $return_items = array();
        foreach ($items as $key => $value) {
            $return_items[$value['PRODUCT_ID']] = array(
                'Qty' => $value['QUANTITY'],
                'Price' => $value['PRICE'],
                'vat' => $value['TAX']
            );
        }

        return $return_items;
    }
}
?>
