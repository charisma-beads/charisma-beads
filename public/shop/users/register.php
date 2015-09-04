<?php
/*
 * register.php
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
// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/mail_options.php');

// Set the page title.
$page_title = "Account Registration";

$countryId = $request->getPost('country_id', 1);

$viewRenderer = new ViewRenderer();

$registerForm = new CustomerRegisterFrom($countryId);
$inputFilter = new CustomerRegisterInputFilter($registerForm->getCountry());
$registerForm->setInputFilter($inputFilter);
$registerForm->init();

if ($request->isPost() && $request->getPost('submit') != 'Register') {
	$registerForm->setData($request->getPost());
	
	if ($registerForm->isValid()) {
		
		// get filtered data.
		$data = $registerForm->getData();
		
		$dbAdapter = Session::$mysqlDbAdaper;
		$date = new DateTime();
		
		// insert into newsletter.
		if ($data['newsletter'] == 'Y') {
			$newsletterTable = new \Zend\Db\TableGateway\TableGateway('newsletter', $dbAdapter);
			$result = $newsletterTable->insert(array(
				'registration_date' => $date->format('Y-m-d H:i:s'),
			));
			
			if ($result) {
				$newsletter_id = $newsletterTable->getLastInsertValue();
			} else {
				$newsletter_id = 0;
			}
		} else {
			$newsletter_id = 0;
		}
		
		$bcrypt = new \Zend\Crypt\Password\Bcrypt();
		$password = $bcrypt->create($data['password']);

        $hash = md5($data['email'] . time());
		
		$customerTable = new \Zend\Db\TableGateway\TableGateway('customers', $dbAdapter);
		$result = $customerTable->insert(array(
			'prefix_id'				=> $data['prefix_id'],
			'country_id' 			=> $data['country_id'],
			'delivery_address_id'	=> 0,
			'password'				=> $password,
			'first_name'			=> $data['first_name'],
			'last_name'				=> $data['last_name'],
			'email'					=> $data['email'],
			'address1'				=> $data['address1'],
			'address2'				=> $data['address2'],
			'address3'				=> $data['address3'],
			'city'					=> $data['city'],
			'county'				=> $data['county'],
			'post_code'				=> $data['post_code'],
			'phone'					=> $data['phone'],
			'newsletter_id'			=> $newsletter_id,
			'registration_date'		=> $date->format('Y-m-d H:i:s'),
			'delivery_address'		=> 'N',
            'active'                => 0,
            'hash'                  => $hash,
		));
		
		if ($result) {
			$cid = $customerTable->getLastInsertValue();
			
			$emailBody = $viewRenderer->render('register-email', array(
				'name' => $data['first_name'] . ' ' . $data['last_name'],
				'email' => $data['email'],
				'password' => $data['password'],
				'merchant_name' => $merchant_name,
                'hash'  => $hash,
			));
			
			$sendMail = new SendMail($sendMailconfig);
			
			$mailData = array(
				'to' => array(
					'address' => $data['email'],
					'name' => $data['first_name'] . ' ' . $data['last_name'],
				),
				'from' => $sendMailconfig['address_list']['default'],
				'subject' => "Registration details - " . $merchant_name,
				'html' => $emailBody,
			);
			
			$sendMail->sendEmail($mailData);
			
			/*$_SESSION['first_name'] = $data['first_name'];
			$_SESSION['cid'] = $cid;
			$_SESSION['CountryCode'] = $data['country_id'];*/
			
			if ($data['referer_link'] != '') {
				$referer_link = $data['referer_link'];
			} else {
				$referer_link = "/shop/users/index.php";
			}

            $_SESSION['referer_link'] = $referer_link;
			
			header ("Location: " . $https . '/shop/users/thank-you.php');
			
		} else {
			$registerForm->setMessages(array('security'=> array('Oops! Something went wrong. Please try again.')));
			$newsletterTable->delete(array(
				'newsletter_id' => $newsletter_id
			));
		}
	} else {
		$registerForm->setMessages(array('security'=> array('Please check form for errors.')));
	}
}

if ($request->getPost('submit') == 'Register') {
	$registerForm->setData(array(
		'referer_link' => $request->getPost('referer_link')
	));
}



$content .= $viewRenderer->render('register', array(
		'form' => $registerForm,
		'merchant_name' => $merchant_name,
));

// Include html footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
?>

