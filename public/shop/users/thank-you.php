<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/mail_options.php');

// Set the page title.
$page_title = "Thank You - Registration";

$viewRenderer = new ViewRenderer();

$content .= $viewRenderer->render('register-thank-you');

// Include html footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
?>