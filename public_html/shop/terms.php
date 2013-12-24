<?php
$query = "
	SELECT content
	FROM pages
	WHERE page_id=24
	";
$result = mysql_fetch_array (mysql_query ($query), MYSQL_NUM);

$tax_query = "
		SELECT tax_code_id, tax_rate, tax_code, description
		FROM tax_codes, tax_rates
		WHERE tax_codes.tax_rate_id=tax_rates.tax_rate_id
		AND tax_code='S'
		";

$tax_result = mysql_query ($tax_query);
$tax = mysql_fetch_array($tax_result, MYSQL_ASSOC);

$tax_rate = substr ($tax['tax_rate'], 2);
$tax_rate = substr ($tax_rate ,0, -1) . "." . substr ($tax['tax_rate'], -1);
$tax_rate = number_format ($tax_rate, 2); 

function templateParser($template, $params, $key_start, $key_end) {
	// Loop through all the parameters and set the variables to values.
			foreach ($params as $key => $value) {
		$template_name = $key_start . $key . $key_end;
		$template = str_replace ($template_name, $value, $template);
			}
	
			return $template;
}

$content .= templateParser($result[0], array('TAX_RATE' => $tax_rate, 'MERCHANT_NAME' => $merchant_name), '{', '}');
?>