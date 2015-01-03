<?php // login.php Tuesday, 5 April 2005
// This is the log-in page for the site.

// Set the page title.
$page_title = "Log In";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');

$loginForm = new CustomerLoginForm();
$inputFilter = new CustomerLoginInputFilter();
$loginForm->setInputFilter($inputFilter);
$loginForm->init();

$loginForm->setData($request->getPost());

if ($request->isPost() && $request->getPost('submit') != 'Log-in') {
	
	if ($loginForm->isValid()) {
		$data = $loginForm->getData();
		
		$query = "
		    SELECT customer_id, first_name, country_id, password
		    FROM customers
		    WHERE email='".$data['email']."'
		    AND active = 1
		    LIMIT 1
        ";

        $result = mysql_query ($query);
        $num = mysql_num_rows($result);
        $row = mysql_fetch_array ($result, MYSQL_ASSOC);

        if (1 === $num && $row) {
        	
        	// check against md5 first then bcrypt.
        	$md5 = new Md5();
        	$bcrypt = new \Zend\Crypt\Password\Bcrypt();

        	if ($md5->verify($data['password'], $row['password'])) {
        		
        		$pass = true;
        		// update password to bcrypt.
        		$password = $bcrypt->create($data['password']);
        		
        		$query = "UPDATE customers SET password='".$password."' WHERE customer_id=" . $row['customer_id'];
        		$result = mysql_query ($query); // Run query.
        		
        	} elseif ($bcrypt->verify($data['password'], $row['password'])) {
        		$pass = true;
        	} else {
        		$pass = false;
        	}
        	
        	if (true === $pass) {
        		// Start the session, register the values & redirect.
        		$_SESSION['first_name'] = $row['first_name'];
        		$_SESSION['cid'] = $row['customer_id'];
        		$_SESSION['CountryCode'] = $row['country_id'];
        		
        		if ($data['referer_link'] != '') {
        			$referer_link = "$https".$data['referer_link'];
        		} else {
        			$referer_link = "$https/shop/users/index.php";
        		}
        		
        		header ("Location: " . $referer_link);
        	} else {
        		$loginForm->setMessages(array('security'=> array('Login failed. Please make sure that you enter the correct details and that you have activated your account.')));
        	}
        	
        } else {
        	$loginForm->setMessages(array('security'=> array('Login failed. Please make sure that you enter the correct details and that you have activated your account.')));
        }
	}
}

if (isset($_SESSION['referer_link'])) {

    $loginForm->get('referer_link')->setValue($_SESSION['referer_link']);

    if (isset($_SESSION['referer_link'])) {
        unset($_SESSION['referer_link']);
    }
}

$formRenderer = new ViewRenderer();

$content .= $formRenderer->render('login', array(
	'form' => $loginForm,
));


// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
?>