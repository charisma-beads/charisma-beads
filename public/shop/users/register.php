<?php
/*
 * register.php
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

// Set the page title.
$page_title = "Account Registration";
$type = "registrations";

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');

if (isset($_POST['referer_link'])) {
	$referer_link = $_POST['referer_link'];
} else {
	$referer_link = NULL;
}

// Create Form.
function form () { 
	global $s;
	global $referer_link;
	global $merchant_name;
	$s .= '<table><tr>';
	$s .= '<tr><td colspan="3"><h2 style="margin-left:1em;text-align:left">Contact Information</h2></td></tr>';
	
	$s .= '<tr><td colspan="3"><span class="required">*</span> Required fields</td><tr>';
	
	$s .= '<tr><td align="right"><b>Prefix:</b></td><td align="left"><select name="prefix"><option>Select</option>';
	// Retrieve all the prefixes and add to the pull down menu.
	$query = "
		SELECT * 
		FROM customer_prefix
		";
	$result = mysql_query ($query);
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$s .= '<option ';
		
		if (isset ($_POST['prefix']) && ($_POST['prefix']) == $row['prefix_id']) {
			$s .= 'selected="selected"';
		}
			
		$s .= " value=\"{$row['prefix_id']}\">{$row['prefix']}</option>";
	}
	$s .= '</select><span class="required">*</span></td><td rowspan="13" valign="top"><div class="notes"><h3>Personal Information</h3><p>Please enter your name, address, telephone number and email address.</p><div></td></tr>';

    $s .= '<tr><td align="right"><b>First Name:</b></td> <td align="left"><input type="text" name="first_name" size="15" maxlength="15" value="';
	if (isset($_POST['first_name'])) {
		$s .= stripslashes ($_POST['first_name']);
	}
	$s .= '" /><span class="required">*</span></td></tr>';
    
    $s .= '<tr><td align="right"><b>Last Name:</b></td> <td align="left"><input type="text" name="last_name" size="30" maxlength="30" value="';
	if (isset($_POST['last_name'])) {
		$s .= stripslashes ($_POST['last_name']);
	}
	$s .= '" /><span class="required">*</span></td></tr>';

	$s .= '<tr><td align="right"><b>Address Line 1:</b></td> <td align="left"><input type="text" name="address1" size="30" maxlength="30" value="';
	if (isset($_POST['address1'])) {
		$s .= stripslashes ($_POST['address1']);
	}
	$s .= '" /><span class="required">*</span></td></tr>';

	$s .= '<tr><td align="right"><b>Address Line 2:</b></td> <td align="left"><input type="text" name="address2" size="30" maxlength="30" value="';
	if (isset($_POST['address2'])) {
		$s .= stripslashes ($_POST['address2']);
	}
	$s .= '" /><br />(optional)</td></tr>';
	
	$s .= '<tr><td align="right"><b>Address Line 3:</b></td> <td align="left"><input type="text" name="address3" size="30" maxlength="30" value="';
	if (isset($_POST['address3'])) {
		$s .= stripslashes ($_POST['address3']);
	}
	$s .= '" /><br />(optional)</td></tr>';

	$s .= '<tr><td align="right"><b>Town/City:</b></td> <td align="left"><input type="text" name="city" size="30" maxlength="30" value="';
	if (isset($_POST['city'])) {
		$s .= stripslashes ($_POST['city']);
	}
	$s .= '" /><span class="required">*</span></td></tr>';
	
	if ($_POST['country'] == 1) {
		$s .= '<tr><td align="right"><b>County:</b></td><td align="left"><select name="county">';
	
		$handle = fopen($_SERVER['DOCUMENT_ROOT']."/admin/modules/web_shop/post_validation/uk_counties.txt", "r");
		if ($handle) {
			while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
				if (isset ($_POST['county']) && ($_POST['county']) == strip_tags($data[0])) {
					$replace = '"'.$_POST['county'].'"';
					$data[0] = str_replace($replace, $replace.' selected="selected"', $data[0]);
				}
				$s .= $data[0]."\n";
			}
			fclose($handle);
		}
	
		$s .= '</select><span class="required">*</span></td></tr>';
	} else {
	
		$s .= '<tr><td align="right"><b>County:</b></td> <td align="left"><input type="text" name="county" size="30" maxlength="30" value="';
		if (isset($_POST['county'])) {
			$s .= stripslashes ($_POST['county']);
		}
		$s .= '" /><span class="required">*</span></td></tr>';
	}
	
	$s .= '<tr><td align="right"><b>Post Code:</b></td> <td align="left"><input type="text" name="post_code" size="10" maxlength="10" value="';
	if (isset($_POST['post_code'])) {
		$s .= $_POST['post_code'];
	}
	$s .= '" />';
	if ($_POST['country'] == 1) $s .= '<span class="required">*</span>';
	$s .= '</td></tr>';	
	
	$s .= '<tr><td align="right"><b>Country:</b></td><td align="left"><select name="country" disabled="disabled">';
	// Retrieve all the countries and add to the pull down menu.
	$query = "
		SELECT * 
		FROM countries
		ORDER BY country ASC
		";
	$result = mysql_query ($query);
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$s .= '<option ';
		
		if (isset ($_POST['country']) && ($_POST['country']) == $row['country_id']) {
			$s .= 'selected="selected"';
		}
			
		$s .= " value=\"{$row['country_id']}\">{$row['country']}</option>\n";
	}
	$s .= '</select><a href="/shop/users/register.php">Change Country</a><input type="hidden" name="country" value="'.$_POST['country'].'" /></td></tr>';

	$s .= '<tr><td align="right"><b>Telephone No:</b></td> <td align="left"><input type="text" name="phone" size="20" maxlength="20" value="';
	if (isset($_POST['phone'])) {
		$s .= $_POST['phone'];
	}
	$s .= '" /><span class="required">*</span></td></tr>';
    
   	$s .= '<tr><td align="right"><b>Email:</b></td> <td align="left"><input type="text" name="email" size="40" value="';
	if (isset($_POST['email'])) {
		$s .= $_POST['email'];
	}
	
	$s .= '" /><span class="required">*</span></td></tr>';
	
	$s .= '<tr><td align="right"><b>Comfirm Email:</b></td> <td align="left"><input type="text" name="email1" size="40" value="';
	if (isset($_POST['email1'])) {
		$s .= $_POST['email1'];
	}
	
	$s .= '" /><span class="required">*</span></td></tr>';
	
	$query = "
		SELECT * 
		FROM ad_referrer
		ORDER BY ad_referrer ASC
	";
	$result = mysql_query ($query);
	
	if (mysql_num_rows($result) > 0) {
		$s .= '<tr><td align="right"><b>Where did you hear about us:</b></td><td align="left"><select name="ad_referrer"><option>Select One</option>';
		// Retrieve all the countries and add to the pull down menu.
	
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			$s .= '<option ';
		
			if (isset ($_POST['ad_referrer']) && ($_POST['ad_referrer']) == $row['ad_referrer_id']) {
			$s .= 'selected="selected"';
			}
			
			$s .= " value=\"{$row['ad_referrer_id']}\">{$row['ad_referrer']}</option>\n";
		}
		$s .= '</select><span class="required">*</span></td></tr>';
	} else {
		$content .= '<input type="hidden" name="ad_referrer" value="0"/>';
	}
	 
	$s .= '<tr><td colspan="3"><hr style="border:0px;border-top:1px dashed black; width:75%;"/></td></tr>';
	
	$s .= '<tr><td colspan="3"><h2 style="margin-left:1em;text-align:left">Newsletter Sign Up</h2></td></tr>';
	
   	if (Utility::module_installed ('Newsletter') == true) {
		$s .= '<tr><td align="right"><b>Add to mailing list:</b></td> <td align="left"><select name="newsletter"><option '; 
				
		$s .= " selected=\"selected\" "; 
				 
		$s .= 'value="Y">Yes</option><option ';
		 	
				
		$s .= 'value="N">No</option></select><span class="required">*</span></td><td><div class="notes"><h3>Newsletter</h3><p>When you sign up to our newsletter we will email you from time to time with product related information. We <span style="font-weight:bold;">WILL NOT</span> give your email address to anyone else.</p><div></td></tr>';
	}
	
	$s .= '<tr><td colspan="3"><hr style="border:0px;border-top:1px dashed black; width:75%;"/></td></tr>';
	
	$s .= '<tr><td colspan="3"><h2 style="margin-left:1em;text-align:left">'.$merchant_name.' Account Login</h2></td></tr>';
			
    //$s .= '<tr><td align="right"><b>User Name:</b></td> <td align="left"><input type="text" name="username" size="20" maxlength="20" value="';
	//if (isset($_POST['username'])) {
	//	$s .= $_POST['username'];
	//}
	//$s .= '" /><span class="required">*</span></td>';
	$s .= '<tr><td colspan="2">&nbsp;</td>';
	$s .= '<td rowspan="3" valign="top"><div id="password" class="notes password"><h3>Password</h3><p>Here you must choose a password that only you will know.</p><br /><p>You will use these to log in to '.$merchant_name.'.</p><br /><p>Your password must be between 4 and 20 characters long and is case-sensitive with no spaces. You may use numbers, letters and the undersore character. Passwords may use special characters as well (see <a id="special" href="#special_characters">special characters</a> below). Please do not enter accented characters.</p><br /><p id="special_characters">password special characters are:<br />! &pound; $ % &amp; / \ ( ) = ? + * # - . , ; :</p><br /><p>The strength meter tells you how good your password is.</p><br /><h3 style="font-size:1.10em;">Password Security Information</h3><p>A password can only be considered secure when the following criteria are met:<ul><li>Contains at least 7 characters. The more characters a password contains, the more secure it is considered to be.</li><li>Change your password regularly. Every 90 days you should change your password.</li><li>Change your password immediately, if there is a chance that someone may know what it is.</li><li>Always use a combination of letters, digits, and any special characters that are allowed by the system.</li><li>Never write down your password.</li><li>Never use personal data or data concerning those you know. For example, your or loved ones birthdays, your own name or names of those close to you, etc. should not be used.</li></ul></p><div></td></tr>';
    
	$s .= '<tr><td align="right"><b>Password:</b></td><td align="left"><table><tr><td><input id="password1" type="password" name="password1" size="20" maxlength="20" /><span class="required">*</span></td><td style="text-align:left;"><div style="width:130px;border:1px dashed black;background-color:white;font-weight:bold;text-transform:capitalize;font-size:10px"><p style="margin:0px;background-color:skyblue;text-align:center">strength meter</p><p id="passBar" style="margin:0px;height:14px;width:32px;background-image:url(/admin/images/stat_barreend.png);float:right"><img src="/admin/images/stat_barreend.png" alt=""><img id="bar" src="/admin/images/stat_barre.png" alt="" height="14" width="0"><img src="/admin/images/stat_barreend.png" alt=""></p>
	<p id="passStrength" style="margin:0px;">score: 0/30<br />verdict: </p></div></td></tr></table></td>';
	
    $s .='<tr><td align="right"><b>Confirm Password:</b></td><td align="left"><input type="password" name="password2" size="20" maxlength="20" /><span class="required">*</span></td></tr>';
	
	if ($referer_link) {
        $s .= '<input type="hidden" name="referer_link" value="'.$referer_link.'" />';
    }
    
	$s .= '<tr><td colspan="3"><hr style="border:0px;border-top:1px dashed black; width:75%;"/></td></tr>';
    $s .= '</table>';
	return $s;
} 

function hidden_form () {
	global $referer_link;
	
	$content =  '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
	
	$content .=  '<input type="hidden" name="prefix" size="15" maxlength="15" value="';
	if (isset($_POST['prefix'])) {
		$content .=  $_POST['prefix'];
	}
	$content .= '" />';
	
	$content .= '<input type="hidden" name="first_name" size="15" maxlength="15" value="';
	if (isset($_POST['first_name'])) {
		$content .=  stripslashes ($_POST['first_name']);
	}
	$content .= '" />';
	
	$content .= '<input type="hidden" name="last_name" size="30" maxlength="30" value="';
	if (isset($_POST['last_name'])) {
		$content .=  stripslashes ($_POST['last_name']);
	}
	$content .= '" />';
	
	$content .= '<input type="hidden" name="address1" size="30" maxlength="30" value="';
	if (isset($_POST['address1'])) {
		$content .=  stripslashes ($_POST['address1']);
	}
	$content .= '" />';
	
	$content .= '<input type="hidden" name="address2" size="30" maxlength="30" value="';
	if (isset($_POST['address2'])) {
		$content .=  stripslashes ($_POST['address2']);
	}
	$content .= '" />';
	
	$content .= '<input type="hidden" name="address3" size="30" maxlength="30" value="';
	if (isset($_POST['address3'])) {
		$content .=  stripslashes ($_POST['address3']);
	}
	$content .= '" />';
	
	$content .= '<input type="hidden" name="city" size="30" maxlength="30" value="';
	if (isset($_POST['city'])) {
		$content .=  stripslashes ($_POST['city']);
	}
	$content .= '" />';
	
	$content .= '<input type="hidden" name="county" value="';
	if (isset($_POST['county'])) {
		$content .= stripslashes ($_POST['county']);
	}
	$content .= '" />';
	
	$content .= '<input type="hidden" name="country" value="';
	if (isset($_POST['country'])) {
		$content .= stripslashes ($_POST['country']);
	}
	$content .= '" />';
	
	$content .= '<input type="hidden" name="post_code" size="10" maxlength="10" value="';
	if (isset($_POST['post_code'])) {
		$content .=  $_POST['post_code'];
	}
	$content .= '" />';
	$content .= '<input type="hidden" name="phone" size="20" maxlength="20" value="';
	if (isset($_POST['phone'])) {
		$content .=  $_POST['phone'];
	}
	$content .= '" />';
	$content .= '<input type="hidden" name="email" size="40" value="';
	if (isset($_POST['email'])) {
		$content .=  $_POST['email'];
	}
	$content .= '" />';
	
	$content .= '<input type="hidden" name="ad_referrer" value="';
	if (isset($_POST['ad_referrer'])) {
		$content .=  $_POST['ad_referrer'];
	}
	$content .= '" />';
	
	if (Utility::module_installed ('Newsletter') == TRUE) {
		$content .= '<input type="hidden" name="newsletter" size="15" maxlength="15" value="';
		if (isset($_POST['newsletter'])) {
			$content .=  $_POST['newsletter'];
		}
		$content .= '" />';
	}
	//$content .= '<input type="hidden" name="username" size="20" maxlength="20" value="';
	//if (isset($_POST['username'])) {
	//	$content .=  $_POST['username'];
	//}
	//$content .= '" />';
	if ($referer_link) {
        $content .= '<input type="hidden" name="referer_link" value="'.$referer_link.'" />';
    }
	$content .= '<input type="submit" class="submit" name="Try Again!" value="Try Again!" />';
	$content .= '</form>';
	return $content;
}

if (isset($_POST['country']) && $_POST['country'] != "Select One") {
	// CAPTCHA ConfigArray
	$CAPTCHA_INIT = array(
            'tempfolder'     => $_SERVER['DOCUMENT_ROOT'].'/admin/tmp/',      // string: absolute path (with trailing slash!) to a writeable tempfolder which is also accessible via HTTP!
			'TTF_folder'     => $_SERVER['DOCUMENT_ROOT'].'/admin/TTF/', // string: absolute path (with trailing slash!) to folder which contains your TrueType-Fontfiles.
                                // mixed (array or string): basename(s) of TrueType-Fontfiles
			'TTF_RANGE'      => array('arial.ttf', 'comic.TTF','JUICE.TTF', 'expr.ttf'),
            'chars'          => 6,       // integer: number of chars to use for ID
            'minsize'        => 20,      // integer: minimal size of chars
            'maxsize'        => 30,      // integer: maximal size of chars
            'maxrotation'    => 25,      // integer: define the maximal angle for char-rotation, good results are between 0 and 30
			'form' 			 => 'register', // string: custom form name
            'noise'          => FALSE,    // boolean: TRUE = noisy chars | FALSE = grid
            'websafecolors'  => FALSE,   // boolean
            'refreshlink'    => TRUE,    // boolean
            'lang'           => 'en',    // string:  ['en'|'de']
            'maxtry'         => 3,       // integer: [1-9]

            'badguys_url'    => '/',     // string: URL
            'secretstring'   => 'A very, very secret string which is used to generate a md5-key!',
            'secretposition' => 15,      // integer: [1-32]

            'debug'          => FALSE, 
			
			'counter_filename'		=>  $_SERVER['DOCUMENT_ROOT'].'/admin/tmp/hn_captcha_counter.txt',              // string: absolute filename for textfile which stores current counter-value. Needs read- & write-access!
			'prefix'				=> 'hn_captcha_',   // string: prefix for the captcha-images, is needed to identify the files in shared tempfolders
			'collect_garbage_after'	=> 20,             // integer: the garbage-collector run once after this number of script-calls
			'maxlifetime'			=> 60              // integer: only imagefiles which are older than this amount of seconds will be deleted
	);
	
	
$captcha = new HnCaptchaX1($CAPTCHA_INIT);

if($captcha->garbage_collector_error)
	{
		// Error! (Counter-file or deleting lost images)
		$message = $captcha->garbage_collector_error_message . $merchant_name;
		$header = "From: " . $merchant_email . "\r\n";
		$header .= "Reply-To: " . $merchant_email . "\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
		$header .= "X-Priority: 1\r\n";
		$header .= "X-Mailer: PHP/" . phpversion();
		mail ("shaun@shaunfreeman.co.uk", "Captcha Error - " . $merchant_name, $message, $header);
	}
	
switch($captcha->validate_submit())
	{
	
		// was submitted and has valid keys
		case 1:
			// PUT IN ALL YOUR STUFF HERE //
    
			$content .= "<div class=\"box\">\r\n";
			$content .= "\r\n<table><tr><td>\r\n";
	
			// Check for name prefix.
    		if ($_POST['prefix'] > 0) {
				$prefix =(stripslashes(trim($_POST['prefix'])));
        		$prefix = escape_data($_POST['prefix']);
    		} else {
        		$prefix = FALSE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your name prefix!</p></span>";
    		}
	
    		// Check for first name.
    		if (preg_match ("/^[[:alpha:],' -]{2,15}$/i", stripslashes(trim($_POST['first_name'])))) {
        	$first_name = escape_data(ucwords (strtolower($_POST['first_name'])));
    		} else {
        		$first_name = FALSE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your first name!</p></span>";
    		}

    		// Check for last name.
    		if (preg_match ("/^[[:alpha:].' -]{2,30}$/i", stripslashes(trim($_POST['last_name'])))) {
        		$last_name = escape_data(ucwords (strtolower($_POST['last_name'])));
    		} else {
        		$last_name = FALSE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your last name!</p></span>";
    		}
	
			// Check for address1.
    		if (preg_match ("/^[[:alnum:].', -\/]{5,30}$/i", stripslashes(trim($_POST['address1'])))) {
        		$address1 = escape_data(ucwords (strtolower($_POST['address1'])));
    		} else {
        		$address1 = FALSE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter the first line of your address!</p></span>";
    		}
			
			// Check for address2.
    		if (isset ($_POST['address2'])) {
            	$address2 =	stripslashes(trim($_POST['address2']));
        		$address2 = escape_data(ucwords (strtolower($address2)));
    		} else { 
               $address2 = "";
            }
			
			// Check for address3.
    		if (isset ($_POST['address3'])) {
            	$address3 =	stripslashes(trim($_POST['address3']));
        		$address3 = escape_data(ucwords (strtolower($address3)));
    		} else { 
               $address3 = "";
            }
           
			// Check for town/city.
    		if (preg_match ("/^[[:alpha:].' -]{2,30}$/i", stripslashes(trim($_POST['city'])))) {
        		$city = escape_data(ucwords (strtolower($_POST['city'])));
    		} else {
        		$city = FALSE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your Town or City!</p></span>";
    		}
	
			// Check for county/state.
    		if (preg_match ("/^[[:alpha:].' -]{2,100}$/i", stripslashes(trim($_POST['county'])))) {
        		$county = escape_data(ucwords (strtolower($_POST['county'])));
    		} else {
        		$county = FALSE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your County or State!</p></span>";
    		}  
	
			// Check for Post/Zip code.
    		if (preg_match ("/^[[:alnum:] ]{4,10}$/i", stripslashes(trim($_POST['post_code']))) || $_POST['country'] != 1) {
        		$post_code = escape_data(strtoupper($_POST['post_code']));
    		} else {
        		$post_code = FALSE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your Post or Zip code!</p></span>";
    		} 
			
			// Check for country.
    		if ($_POST['country'] > 0) {
				$country =(stripslashes(trim($_POST['country'])));
        		$country = escape_data($_POST['country']);
    		} else {
        		$country = FALSE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your country!</p></span>";
    		}
			
			// Check for telephone No.
    		if (preg_match ("/^[[:digit:] ]{5,20}$/i", stripslashes(trim($_POST['phone'])))) {
        		$phone = escape_data($_POST['phone']);
    		} else {
        		$phone = FALSE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter your phone number!</p></span>";
    		}
			
			if (stripslashes(trim($_POST['email'])) == stripslashes(trim($_POST['email1']))) {
    	
    			// Check for an email address.
    			if (preg_match ("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", stripslashes(trim($_POST['email'])))) {
        			$email = escape_data(strtolower($_POST['email']));
    			} else {
        			$email = False;
        			$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter a valid email address!</p></span>";
    			}
			} else {
				$email = False;
				$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> the email addresses do not match!</p></span>";
			}
    
    		// Check for a username.
			/*
    		if (eregi ("^[[:alnum:]_]{4,20}$", stripslashes(trim($_POST['username'])))) {
        		$username = escape_data($_POST['username']);
    		} else {
        		$username = FALSE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"{$_SERVER['DOCUMENT_ROOT']}/admin/images/actionno.png\" /> Please enter a valid username!</p></span>";
    		}
			*/
    		// Check for a password and match against the confirmed password.
    		if (preg_match ("@^[[:alnum:]!£$%&/\\()=?+#-.,;:_\@]{4,20}$@i", stripslashes(trim($_POST['password1'])))) {
        		if ($_POST['password1'] == $_POST['password2']) {
            		$password = escape_data($_POST['password1']);
        		} else {
            		$password = FALSE;
            		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Your password did not match the confirmed password!</p></span>";
        		}
    		} else {
        		$password = FALSE;
        		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please enter a valid password!</p></span>";
    		}
			
			// Check for ad referrrer.
			if (is_numeric($_POST['ad_referrer'])) {
				$ad_referrer =(stripslashes(trim($_POST['ad_referrer'])));
				$ad_referrer = escape_data($_POST['ad_referrer']);
			} else {
				$ad_referrer = FALSE;
				$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> Please choose where you heard about us!</p></span>";
			}
    
    		if ($prefix && $first_name && $last_name && $address1 && $city && $county && $post_code && $country && $phone && $email && $password && $ad_referrer) { // If everything is OK.

    			// Make sure the username and email are available.
    			//$query1 = "SELECT customer_id FROM customers WHERE username='$username'";
    			$query2 = "SELECT customer_id FROM customers WHERE email='$email'";
    			//$result1 = mysql_query ($query1);
    			$result2 = mysql_query ($query2);

    			if (/* mysql_num_rows($result1) == 0 && */ mysql_num_rows($result2) == 0) { // Available.
                    $name = $first_name . " " . $last_name;
					// Add to newsletter.
					if (Utility::module_installed ('Newsletter') == TRUE) {
						if ($_POST['newsletter'] == "Y") {
		
							$name = $first_name . " " . $last_name;
							$query = "
							INSERT INTO newsletter (registration_date) 
							VALUES (NOW())
							";  
							$result = mysql_query ($query); // Run the query.
							$newsletter = mysql_insert_id(); // Get the newsletter ID.
						} else {
                    		$newsletter = 0;
                   		}
					} else {
                    		$newsletter = 0;
                   	}

        			// Add the user.
        			$query = "
					INSERT INTO customers (newsletter_id, prefix_id, first_name, last_name, address1, address2, address3, city, county, post_code, country_id, phone, email, password, registration_date, delivery_address_id, delivery_address) 
					VALUES ($newsletter, $prefix, '$first_name', '$last_name', '$address1', '$address2', '$address3', '$city', '$county', '$post_code', $country, '$phone', '$email', MD5('$password'), NOW(), 0, 'N' )
					";
        			$result = mysql_query ($query); // Run the query.
                    
        			if ($result) { // If run OK.
						
						$cid = mysql_insert_id();
						// add the ad_referrer.
						if ($ad_referrer > 0) {
							$sql = "
								INSERT INTO ad_referrer_hits (ad_referrer_id, customer_id)
								VALUES ($ad_referrer, $cid)
							";
							$res = mysql_query($sql);
						}

            			// Send an email, if desired.
        				$message = "Thank you " . $name . " for registering with us\r\n\r\n Your Login details are:-\r\n\r\n email: " . $email . "\r\n Password: " . $password . "\r\n Please login with these details to change your details or to unsubscribe to our newsletter.\r\n\r\n Thank You\r\n\r\n" . $merchant_name;
        				$header = "From: " . $merchant_email . "\r\n";
        				$header .= "Reply-To: " . $merchant_email . "\r\n";
        				$header .= "MIME-Version: 1.0\r\n";
        				$header .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
        				$header .= "X-Priority: 1\r\n";
        				$header .= "X-Mailer: PHP/" . phpversion();
        				mail ($email, "Registration details - " . $merchant_name, $message, $header);
			   			
						if (isset($_POST['referer_link']) && substr ($_POST['referer_link'], -12) == "checkout.php") {
							
							$_SESSION['first_name'] = $first_name;
							$_SESSION['cid'] = $cid;
							
							if (isset($_POST['referer_link'])) {
								$referer_link = "$https".$_POST['referer_link'];
							} else {
								$referer_link = "$https/shop/users/index.php";
							}
							
							ob_end_clean(); // Delete the buffer.
           					header ("Location: " . $referer_link);	
							exit();
						 
						} else {
						
            				$content .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/admin/images/actionok.png\" /> Thank you for registering with us.</h3>";
							$content .= "</td></tr></table>\r\n";
							$content .= "\r\n</div>\r\n";
            				include ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php'); // Include the html footer.
						}
			
            		} else { // If it did not run OK. 
			     		
                		// Send a message to the error log, if desired.
                		$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> You could not be registered due to a system error. We apologize for any inconvenience.</p></span>";
					   	$content .= "</td></tr></table>\r\n";
						$content .= "\r\n</div>\r\n";
						//$content .= $query;
            		}

        		} elseif (mysql_num_rows($result2) == 1) { // The username is not available.
            		
					$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" /> That email address is already taken.</p></span>";
            		$content .= "</td></tr></table>\r\n";
            		$content .= hidden_form ();
			 		$content .= '</div>';
        		} else { // The email is not available.
            		
					$content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/images/actionno.png\" /> That email address has already been taken.</p></span>";
            		$content .= "</td></tr></table>\r\n";
            		$content .= hidden_form ();
			 		$content .= '</div>';
        		}

        		mysql_close(); // Close the database connection.

    		} else { // If one of the data test have failed.
        		$content .= "<span class=\"smcap\"><p class=\"fail\">Please try again.</p></center></span>";
				$content .= "</td></tr></table>\r\n";
        		$content .= "</td></tr></table>\r\n";
            	$content .= hidden_form ();
			 	$content .= '</div>';
    		}
    		break;
	
		// was submitted, has bad keys and also reached the maximum try's
		case 3:
			if(!headers_sent() && isset($captcha->badguys_url)) header('location: '.$captcha->badguys_url);
			$content .= "<p><br>Reached the maximum try's of ".$captcha->maxtry." without success!";
			$content .= "<br><br><a href=\"".$_SERVER['PHP_SELF']."?download=yes&id=1234\">Try Again!</a></p>";
			break;
	
		// was submitted with no matching keys, but has not reached the maximum try's
		case 2:
		// was not submitted, first entry
		default:
			$content .= "<h2>Create an account: Step 2</h2>";

            $form = form();

            $captcha_form = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/template/captcha.html');

            $params = array(
                'FORM_BODY' => $form,
                'NOTVALID_MSG' => $captcha->display_form_part('text_notvalid'),
                'DISPLAY_CAPTCHA' => $captcha->display_form_part('image'),
                'INPUT' => $captcha->display_form_part('input'),
                'TEXT' => $captcha->display_form_part('text'),
                'REFRESH_TEXT' => $captcha->display_form_part('refresh_text'),
                'REFRESH_BUTTON' => $captcha->display_form_part('refresh_button'),
                'URL' => $_SERVER['PHP_SELF'],
                'MERCHANT_NAME' => $merchant_name,
                'TYPE' => $type,
                'REFERER' => ''
            );

            if ($referer_link) {
               $params['REFERER'] = '<input type="hidden" name="referer_link" value="'.$referer_link.'" />';
            }

            $content .= Utility::templateParser($captcha_form, $params, '{', '}');
			break;
	
	}
} else {
	$content .= '
	<h2>Create an account: Step 1</h2>
	<form action="'.$_SERVER['PHP_SELF'].'" method="post">
	<table>
	<tr><td align="right"><b>Choose your country or region:</b></td><td align="left"><select id="country_select" name="country"><option>Select One</option>
	';
	// Retrieve all the countries and add to the pull down menu.
	$query = "
		SELECT * 
		FROM countries
		ORDER BY country ASC
	";
	$result = mysql_query ($query);
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$content .= '<option value="'.$row['country_id'].'">'.$row['country'].'</option>';
	}
	$content .= '
	</select></td></tr>
	<noscript>
	<tr><td><input type="submit" name="submit" value="Continue to step 2" /></td></tr>
	</noscript>
	</table>
	</form>
	';
}
// Include html footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
?>
