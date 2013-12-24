<?php /* Created on: 25/07/2005 */
// Start output buffering and initialize a session.
ob_start();
// Includes.
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/../data/merchant_data.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/global_config.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/../data/database.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/mysql_connect.php");
$session = Session::getInstance(86400, true);
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/html_top.php");

if (!$authorized && $_SERVER['REQUEST_URI'] != '/admin/login.php') {
    if (isset ($_SERVER['HTTPS'])) {
        $http = "https://";
    } else {
        $http = "http://";
    }
    $host = $_SERVER['HTTP_HOST'];
    header ("Location: " . $http . $host .  "/admin/login.php");
    ob_end_clean();
    exit;
}

?>
