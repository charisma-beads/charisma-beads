<?php /* Created on: 14/05/2005  merchant_config.php*/
// Start output buffering and initialize a session.
ob_start(); //'ob_gzhandler'
date_default_timezone_set('Europe/London');
// Include functions.
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/../data/merchant_data.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/global_config.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/database.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/mysql_connect.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/webshop_config.php');

$session = Session::getInstance();

if (isset($_SESSION['cid'])) $session->lifeTime = 86400;

/* @var $cart MiniCart */
$cart = new MiniCart(array(
    'tax_state'     => $VatState,
    'db'            => $dbc,
    'debug'         => false
));

$content = null;

?>