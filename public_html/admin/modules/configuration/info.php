<?php
ob_start();
phpinfo(INFO_MODULES); 

$string = ob_get_contents();
ob_end_clean(); 

$pieces = explode("<h2", $string);

$settings = array();

foreach($pieces as $val)
{
preg_match("/<a name=\"module_([^<>]*)\">/", $val, $sub_key);

preg_match_all("/<tr[^>]*>
<td[^>]*>(.*)<\/td>
<td[^>]*>(.*)<\/td>/Ux", $val, $sub);
preg_match_all("/<tr[^>]*>
<td[^>]*>(.*)<\/td>
<td[^>]*>(.*)<\/td>
<td[^>]*>(.*)<\/td>/Ux", $val, $sub_ext);

foreach($sub[0] as $key => $val)
{
$settings[$sub_key[1]][strip_tags($sub[1][$key])] = array(strip_tags($sub[2][$key]));
}

foreach($sub_ext[0] as $key => $val)
{
$settings[$sub_key[1]][strip_tags($sub_ext[1][$key])] = array(strip_tags($sub_ext[2][$key]), strip_tags($sub_ext[3][$key]));
} 

}

echo "<pre>";
print_r ($settings);
echo "</pre>";
?>