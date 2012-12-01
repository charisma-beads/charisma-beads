<?php
/*
 * inc_bottom.php
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

$html = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/template/template.html');

$menu = new Menu($dbc);

$content = Utility::templateParser($content, array('SITE_MAP' => $menu), '{', '}');

$params = array(
    'CONTENT' => $content,
    'MENU' => $menu,
    'PAGE_TITLE' => $page_title,
    'MERCHANT_NAME' => $merchant_name,
    'DATE' => date('Y'),
    'MINI_CART' => $cart,
    'DESCRIPTION' => file_get_contents($_SERVER['DOCUMENT_ROOT'].'/../data/description.txt'),
    'KEYWORDS' => file_get_contents($_SERVER['DOCUMENT_ROOT'].'/../data/keywords.txt')
);

if (isset($headtags)) {
    $params['CUSTOM_HEADTAGS'] = $headtags;
}

$html = Utility::templateParser($html, $params, '<!--', '-->');

unset($cart);
//$html = preg_replace('/\s{2,}/',' ', $html);
print $html;

ob_end_flush();
?>
