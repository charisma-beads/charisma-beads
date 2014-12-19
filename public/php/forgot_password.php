<?php // forgot_password.php Thursday, 7 April 2005
// This page allows users to reset their password, if forgotten.

// Set the page title and include the HTML header.
$page_title = "Forgot Your Password"; 

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/mail_options.php');

$resetForm = new ResetForm();
$inputFilter = new ResetInputFilter();
$resetForm->setInputFilter($inputFilter);
$resetForm->init();

if ($request->isPost()) {
	
	$resetForm->setData($request->getPost());
	
	if ($resetForm->isValid()) {
		$data = $resetForm->getData();
		
		$query = "SELECT customer_id, first_name, last_name, email FROM customers WHERE email='".$data['email']."'";
		$result = mysql_query ($query);
		$row = mysql_fetch_array ($result, MYSQL_ASSOC);
		
		if ($row) {
			$uid = (int) $row['customer_id'];
			$email = $row['email'];
			$name = join(' ', array(
				$row['first_name'],
				$row['last_name'],
			));
			
			// Create a new random password.
			$password = \Zend\Math\Rand::getString('16', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
			$bcrypt = new \Zend\Crypt\Password\Bcrypt();
			$newPassword = $bcrypt->create($password);
			
			$query = "UPDATE customers SET password='".$newPassword."' WHERE customer_id=$uid";
			$result = mysql_query ($query); // Run query.
			
			if (mysql_affected_rows() == 1) { // If it ran OK.
				
				$sendMail = new SendMail($sendMailconfig);
				
				$data = array(
					'to' => array(
						'address' => $email,
						'name' => $name,
					),
					'from' => $sendMailconfig['address_list']['default'],
					'subject' => "Login Details Changed - " . $merchant_name,
					'body' => "Your password to log into $merchant_name has been temporarily changed to:\r\n\r\n
					$password \r\n\r\n Please log-in using this password and your username. At that time you may change your password to something more memorable.\r\n\r\n Thank You\r\n\r\n$merchant_name"
				);
				
				$sendMail->sendEmail($data);
				
				$content .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" /> Your password has been changed.<br /> You will recieve a new, temporary password at the mail address with which you registered. Once you have logged in with this password, you may change it by going to 'My Account' and clicking on the \"Change Details\" link.</p></span>\r\n";
				$content .= "</div>\r\n";
				$content .= "</td></tr></table>\r\n";
				
				$resetForm->setData(array(
					'password' => '',
					'password-confirm' => '',
				));
				
				$resetForm->setData(array(
					'email' => '',
				));
					
			} else {
				$resetForm->setMessages(array('security'=> array('Sorry, we are unable to reset your password at present. Please try later or contact the Webmaster.')));
			}
		}
	}
}

$viewRenderer = new ViewRenderer();

$content .= $viewRenderer->render('reset-password', array(
	'form' => $resetForm,
));


// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>