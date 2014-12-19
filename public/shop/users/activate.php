<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/mail_options.php');

// Set the page title.
$page_title = "Account Activation";

$viewRenderer = new ViewRenderer();

if (isset($_GET['email']) && isset($_GET['hash'])) {
    $dbAdapter = Session::$mysqlDbAdaper;
    $customerTable = new \Zend\Db\TableGateway\TableGateway('customers', $dbAdapter);

    $email = escape_data($_GET['email']);
    $hash = escape_data($_GET['hash']);

    $result = $customerTable->select([
        'email' => $email,
        'hash' => $hash,
        'active' => 0
    ]);

    $customer = $result->current();

    if ($customer) {
        $message = 'Your account has been activated, you can now login.';
        $customerTable->update([
            'active' => 1,
            'hash' => null,
        ], [
            'email' => $email,
            'hash' => $hash,
            'active' => 0
        ]);
    } else {
        $message = 'The url is either invalid or you already have activated your account.';
    }
} else {
    $message = 'Invalid approach, please use the link that has been send to your email.';
}

$content .= $viewRenderer->render('activate', array(
    'message' => $message,
));

// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
?>