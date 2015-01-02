<?php

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/webshop_config.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/mail_options.php');
$headtags = '
		<script type="text/javascript"  src="/js/shopCreditCard.js"></script>
		<link href="/css/creditCard.css" rel="stylesheet" type="text/css" />';

if (isset($_POST['oid']) && isset($_SESSION['cid'])) {
    // Set the page title and include the HTML header.
    $page_title = "Credit Card Details";

    $thisStep = (string) $_POST['submit'];
    $post = $_POST;

    //get order.
    $query = "
        SELECT cart, vat_total, total, invoice, shipping, DATE_FORMAT(order_date, '%D %M %Y') AS date, order_status, vat_invoice
        FROM customer_orders, customers, customer_order_status
        WHERE customers.customer_id = customer_orders.customer_id
        AND customer_orders.order_status_id=customer_order_status.order_status_id
        AND customer_orders.order_id = {$_POST['oid']}
    ";
    $result = mysql_query ($query);
    $order = mysql_fetch_array ($result, MYSQL_ASSOC);

    // Customer Invoice Address & Delivery Address.
    $address = array();
    $addressKeys = array(
        'address1',
        'address2',
        'address3',
        'city',
        'county',
        'post_code',
        'country'
    );

    $CIA = "
        SELECT *
        FROM customers, countries, customer_prefix
        WHERE customer_id='{$_SESSION['cid']}'
        AND customers.country_id=countries.country_id
        AND customers.prefix_id=customer_prefix.prefix_id
        LIMIT 1
    ";

    $CIA = mysql_query($CIA);
    $CIA = mysql_fetch_array ($CIA, MYSQL_ASSOC);

    if ($CIA['delivery_address'] == "Y") {
        $CDA = "
            SELECT *
            FROM customer_delivery_address, countries
            WHERE customer_id='{$_SESSION['cid']}'
            AND customer_delivery_address.country_id=countries.country_id
            LIMIT 1
        ";
        $CDA = mysql_query($CDA);
        $CDA = mysql_fetch_array ($CDA, MYSQL_ASSOC);
    }

    $card = new CreditCard($dbc);

    // add params.
    $card->invoiceNumber = $order['invoice'];
    $post['total'] = $order['total'];
    
    if (!isset($post['ccName'])) {
    	$post['ccName'] = strtoupper(join(' ', array(
    			$CIA['prefix'],
    			$CIA['first_name'],
    			$CIA['last_name']
    	)));
    }
    

    foreach ($CIA as $key => $value) {
        if (in_array($key, $addressKeys)) {
            $address[] = $value;
        }
    }

    $card->addBillingAddress($address);
    $address = array();

    if (isset($CDA)) {
        foreach ($CDA as $key => $value) {
            if (in_array($key, $addressKeys)) {
                $address[0] = $value;
            }
        }
        $card->addBillingAddress($address);
    }
    
    $card->form->populate($post);

    // make cc form.
    if ("Pay with Debit/Credit Card" === $thisStep) {
        $content .= $card->toString();
    }

    if ("Submit Details" === $thisStep) {
    	if ($post['ccType'] == 'sm' || $post['ccType'] == 's') {
    		
    		$card->form->getElement('ccStartMonth')
    			->setRequired(true)
    			->setValidators(array(array('StringLength', true, array('min' => 2))));
    		$card->form->getElement('ccStartYear')
    			->setRequired(true)
    			->setValidators(array(array('StringLength', true, array('min' => 2))));;
    	}
    	
    	if ($post['billing'] == 'new') {
    		$card->form->getElement('addressLine1')->setRequired(true);
    		$card->form->getElement('city')->setRequired(true);
    		$card->form->getElement('county')->setRequired(true);
    		$card->form->getElement('postcode')->setRequired(true);
    		$card->form->getElement('country')->setRequired(true);
    	}
    	
    	$valid = $card->form->isValid($post);
        if ($valid) {
        	
        	$ccValues = $card->form->getValues();
        	
        	$ccValues['ccNumber'] = preg_replace(
        		'/^([0-9]{4})([0-9]{4})([0-9]{4})([0-9]{4})$/',
        		'$1 $2 $3 $4',
        		$ccValues['ccNumber']
        	);
        	
        	$ccType = array(
        		'0'		=> 'Select a Card',
        		'v'     => 'Visa/Delta/Electron',
        		'm'     => 'MasterCard/Eurocard',
        		//'d'     => 'Discover',
        		'sm'    => 'Switch/Maestro',
        		//'s'     => 'Solo'
        	);
        	
        	$ccValues['ccType'] = $ccType[$ccValues['ccType']];
        	
        	$customer = strtoupper(join(' ', array(
	    		$CIA['prefix'],
	    		$CIA['first_name'],
	    		$CIA['last_name']
	    	)));
	    	
	    	if ($post['billing'] == 'registered') {
	    	    $addr = ($post['registeredBillingAddresses'] == 0) ? $CIA : $CDA;
	    	    
	    	    $ccValues['addressLine1'] = $addr['address1'];
                $ccValues['addressLine2'] = $addr['address2'];
                $ccValues['addressLine3'] = $addr['address3'];
                $ccValues['city'] = $addr['city'];
                $ccValues['county'] = $addr['county'];
                $ccValues['postcode'] = $addr['post_code'];
                $ccValues['country'] = $addr['country'];
	    	}
        	
        	$card->view->assign(array(
        		'merchant'	=> $merchant_name,
        		'title'		=> 'Card details submitted to Charisma Beads Ltd.',
        		'post'		=> $ccValues,
        		'invoiceNumber' => $card->invoiceNumber,
        		'customer' => $customer
        	));

            $sendMail = new SendMail($sendMailconfig);

            $sendMail->sendEmail(array(
                'from' => $sendMailconfig['address_list']['payments'],
                'to' => array(
                    'name' => $customer,
                    'address' => $CIA['email'],
                ),
                'subject' => 'Card Details Sent To Charisma Beads Ltd [Order ' . $card->invoiceNumber .']',
                'html' => $card->view->render('email.phtml'),
            ));

            $sendMail->sendEmail(array(
                'to' => $sendMailconfig['address_list']['payments'],
                'from' => array(
                    'name' => $customer,
                    'address' => $CIA['email'],
                ),
                'subject' => 'Card Details Sent To Charisma Beads Ltd [Order ' . $card->invoiceNumber .']',
                'html' => $card->view->render('email.phtml'),
            ));
	        
	        $content .= '<h2>Thank you, we will process your order as soon as your card has cleared.</h2>';
            
        } else {
        	$content .= '<h3 class="errors">Some errors occurred, please check your entries again.</h3>';
            $content .= $card->toString();
        }
    }

    // Include the HTML footer.
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
} else {
    header ("Location: $merchant_website/index.php");
}

?>