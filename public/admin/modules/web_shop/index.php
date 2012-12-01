<?php // webshop_overview.php (administration side) Friday, 8 April 2005
// This is the webshop overview page for the admin side of the site.

//  ALTER TABLE `products` ADD `image_status` INT( 1 ) NOT NULL DEFAULT 1 AFTER `image`

// ALTER TABLE `product_lines` ADD `imgae_status` INT( 1 ) NOT NULL DEFAULT '1' AFTER `line_image` ; 

// Set the page title.
$page_title = "Webshop Overview";

$custom_headtags = '
	<script type="text/javascript" src="/admin/js/mootabs.js"></script>
	<link href="/admin/css/mootabs.css" rel="stylesheet" type="text/css">
';

// Include configuration file for error management and such.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin_includes.php');

// Print a message based on authentication.
if (!$authorized) {
    echo '<p>Please enter a valid username and password! Click <a href="./index.php">here</a> to try again!<p>';
} else { 
	
    if (file_exists ('install.php')) {
        //unlink ('install.php');
        print "<p style=\"color:red\">please delete the install.php file</p>";
    }

    if (isset ($_POST['oid']) && isset ($_POST['order_status'])) {
        if ($_POST['order_status'] == 4) {
            $query = "
                SELECT *
                FROM customer_orders
                WHERE order_id={$_POST['oid']}
            ";

            $result = mysql_query($query);
            $row = mysql_fetch_array($result);

            $cart = unserialize (stripslashes($row['cart']));

            foreach ($cart as $key => $value) {
                $query = "
                    SELECT hits, quantity
                    FROM products
                    WHERE product_id = $key
                ";
                
                $result = mysql_query($query);
                $hits = mysql_result($result,0,'hits');
                $qty = mysql_result($result,0,'quantity');

                if ($qty > -1) {
                    mysql_query("
                        UPDATE products
                        SET quantity = $qty + {$value['Qty']}
                        WHERE product_id = $key
                    ");
                }

                mysql_query("
                    UPDATE products
                    SET hits = $hits - {$value['Qty']}
                    WHERE product_id = $key
                ");
            }

            mysql_query ("
                UPDATE customer_orders
                SET order_status_id = {$_POST['order_status']}, total = 0, shipping = 0, vat_total = 0
                WHERE order_id={$_POST['oid']}
            ");

        } else {
            mysql_query ("
                UPDATE customer_orders
                SET order_status_id={$_POST['order_status']}
                WHERE order_id={$_POST['oid']}
            ");
        }

        require_once ('./customers/mail_order_status.php');
    }

    ?>
    <table>
        <tr>
            <td valign="top" rowspan="2">
                <table width="150">
                    <tr>
                        <td height="25" class="Link" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="customers/view_customers.php" class="Link">:: View Customers</a></td>
                    </tr>
                    <tr>
                        <td height="25" class="Link" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="edit_webshop.php" class="Link">:: Edit Web Shop</a></td>
                    </tr>
                    <tr>
                        <td height="25" class="Link" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="products/index.php" class="Link">:: Products</a></td>
                    </tr>
                    <tr>
                        <td height="25" class="Link" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="postage/index.php" class="Link">:: Postage</a></td>
                    </tr>
                    <tr>
                        <td height="25" class="Link" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="tax/index.php" class="Link">:: Tax</a></td>
                    </tr>
                    <tr>
                        <td height="25" class="Link" onMouseOver="this.className='bodyLink'" onMouseOut="this.className='Link'"><a href="ad_referrer/index.php" class="Link">:: Adverts</a></td>
                    </tr>
                </table>
            </td>
            <td>
            <!-- Start mooTabs -->
                <div id="mooStats" style="margin-left:auto;margin-right:auto;">
                    <ul class="mootabs_title">
                        <li title="Tab1">Stats</li>
                        <li title="Tab2">Monthly Totals</li>
                        <li title="Tab3">New Orders</li>
                        <li title="Tab4">Customer Stats</li>
                        <li title="Tab5">Top Products</li>
                    </ul>

                    <div id="Tab1" class="mootabs_panel">

                    </div>
                    <div id="Tab2" class="mootabs_panel">

                    </div>
                    <div id="Tab3" class="mootabs_panel">

                    </div>
                    <div id="Tab4" class="mootabs_panel">

                    </div>
                    <div id="Tab5" class="mootabs_panel">

                    </div>
                </div>
            </td>

        </tr>
    </table>
    <script>
        window.addEvent("domready", function(){
        mooTabs1 = new mootabs("mooStats", {width:550, height:400, useAjax:true, ajaxUrl:'overview_tabs.php'});
        });
    </script>
    <?php
    $query = "
        SELECT CONCAT(prefix, ' ', first_name, ' ', last_name ) AS name, invoice, order_status, DATE_FORMAT(order_date, '%D %M %Y') AS date, order_id, customers.customer_id
        FROM customers, customer_prefix, customer_orders, customer_order_status
        WHERE customer_orders.order_status_id IN (
            SELECT order_status_id
            FROM customer_order_status
            WHERE order_status != 'Cancelled'
            AND order_status != 'Dispatched'
        )
        AND customer_orders.order_status_id = customer_order_status.order_status_id
        AND customers.customer_id = customer_orders.customer_id
        AND customers.prefix_id = customer_prefix.prefix_id
        ORDER BY order_date DESC
    ";
    $result = mysql_query ($query);
    $num_rows = mysql_num_rows($result);
    if ($num_rows > 0) {
        ?>
        <script>
            window.addEvent("domready", function(){
                mooTabs1.activate('Tab3');
            });
        </script>
        <?php
    }
}

// Include the HTML footer.
include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/html_bottom.php');

?>
