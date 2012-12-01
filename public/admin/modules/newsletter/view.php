<?php // view_user.php Wednesday, 13 April 2005
// This page allows the administrator to view the current newsletter.

// Set the page title.
$page_title = "View Newsletter";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . "/../data/merchant_data.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/global_config.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php");
$template = "01"; // For testing.
$css_style = file_get_contents ("./$template/css/style.css");
$content = file_get_contents ("./$template/content.txt");
$newsletter = file_get_contents ("./$template/newsletter.txt");
$newsletter_link = $merchant_website . "/newsletter/images";

$css_style = str_replace ('#### LINK ####', $newsletter_link, $css_style);
	
$template = array ('UNSUBSCRIBE' => $merchant_website.'/newsletter/unsubscribe.php', 'LINK' => $newsletter_link, 'WEBSITE' => $merchant_website, 'STYLE' => $css_style, 'NAME' => $merchant_name, 'CONTENT' => $content);

	foreach ($template as $key => $value) {
		$template_name = '#### ' . $key . ' ####';
		$newsletter = str_replace ($template_name, $value, $newsletter);
	}
	
	echo $newsletter;	


?>