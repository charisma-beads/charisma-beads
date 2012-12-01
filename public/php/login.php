<?php // login.php Tuesday, 5 April 2005
// This is the log-in page for the site.

// Set the page title.
$page_title = "Log In";
$type = 'login';

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php'); 

if (isset($_POST['referer_link'])) {
	$referer_link = $_POST['referer_link'];
} else {
	$referer_link = NULL;
}

function form () {
	global $referer_link;

    $s = '<table>';
	$s .= '<tr><td><b>Email:</b></td><td><input tabindex="1" class="inputbox" type="text" name="email" size="20" value="';
	if(isset($_POST['email'])) {
		$s .= $_POST['email'];
	}
	$s .= '" /></td><td rowspan="2"><a tabindex="3" href="/php/forgot_password.php" title="Forgot Password">Forgot Password</a></td></tr>';
    if ($referer_link) {
        $s .= '<input type="hidden" name="referer_link" value="'.$referer_link.'" />';
    }
	$s .= '<tr><td><b>Password:</b></td><td><input tabindex="2" class="inputbox" type="password" name="password" size="20" /></td></tr>';
	$s .= '</table>';
    return $s;
}

	// CAPTCHA ConfigArray
	$CAPTCHA_INIT = array(
            'tempfolder'     => $_SERVER['DOCUMENT_ROOT'].'/admin/tmp/',      // string: absolute path (with trailing slash!) to a writeable tempfolder which is also accessible via HTTP!
			'TTF_folder'     => $_SERVER['DOCUMENT_ROOT'].'/admin/TTF/', // string: absolute path (with trailing slash!) to folder which contains your TrueType-Fontfiles.
                                // mixed (array or string): basename(s) of TrueType-Fontfiles
			'TTF_RANGE'      => 'auto',
            'chars'          => 6,       // integer: number of chars to use for ID
            'minsize'        => 20,      // integer: minimal size of chars
            'maxsize'        => 30,      // integer: maximal size of chars
            'maxrotation'    => 25,      // integer: define the maximal angle for char-rotation, good results are between 0 and 30
            'noise'          => false,    // boolean: TRUE = noisy chars | FALSE = grid
            'websafecolors'  => true,   // boolean
            'refreshlink'    => true,    // boolean
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

$content .= '<p id="admin_login" rel="'.$https.'"></p>';

switch($captcha->validate_submit())
{

    // was submitted and has valid keys
    case 1:
        // PUT IN ALL YOUR STUFF HERE //

        $content .= "<div class=\"box\">\r\n";
        $content .= "\r\n<table><tr><td>\r\n";

        if (preg_match ("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", stripslashes(trim($_POST['email'])))) { // Validate the username.
            $e = escape_data(strtolower($_POST['email']));

        } else {

            $e = FALSE;
            $content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />You forgot your username!</p></span>\r\n";
        }

        if (empty($_POST['password'])) { // Validate the password.
            $p = FALSE;
            $content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />You forgot to enter your password!</p></span>\r\n";
        } else {
            $p = escape_data($_POST['password']);
        }

        if ($e && $p) { // If everything's OK.
        // Query the database.
            $query1 = "SELECT customer_id, first_name, country_id FROM customers WHERE email='$e' AND password=MD5('$p')";

            $result1 = mysql_query ($query1);
            $num1 = mysql_num_rows($result1);
            $row1 = mysql_fetch_array ($result1, MYSQL_NUM);

            if ($row1) { // A match was made with a user.

                // Start the session, register the values & redirect.
                $_SESSION['first_name'] = $row1[1];
                $_SESSION['cid'] = $row1[0];
                $_SESSION['CountryCode'] = $row1[2];

                if (isset($_POST['referer_link'])) {
                    $referer_link = "$https".$_POST['referer_link'];
                } else {
                    $referer_link = "$https/shop/users/index.php";
                }

                ob_end_clean(); // Delete the buffer.
                header ("Location: " . $referer_link);
                //$content .= $referer_link;
                exit();
            } else { // No Match was made.
                $content .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/admin/images/actionno.png\" />The username and password entered do not match those on file.</p></span>\r\n";
                $content .= "</td></tr></table>\r\n";
                $content .= '<form action="' . $_SERVER['PHP_SELF']. '" method="post">';
                $content .= '<input type="hidden" name="email" size="60" maxlength="20" value="';
                if (isset($_POST['email'])) {
                    $content .= $_POST['email'];
                }
                $content .= '" />';
                 if ($referer_link) {
                    $content .= '<input type="hidden" name="referer_link" value="'.$referer_link.'" />';
                }
                
                $content .= '<br /><input class="submit" type="submit" name="Try Again!" value="Try Again!" />';
                $content .= '</form>';
                $content .= '<a href="/php/forgot_password.php" title="Forgot Password" class="center">Forgot Password</a>';
                $content .= '</div>';
            }


            mysql_close(); // Close the database.

        } else { // If everything wasn't OK.
            $content .= "<span class=\"smcap\"><p class=\"fail\"> Please try again.</p></span>\r\n";
            $content .= "</td></tr></table>\r\n";
            $content .= '<form action="' . $_SERVER['PHP_SELF']. '" method="post">';
            $content .= '<input type="hidden" name="email" size="60" maxlength="20" value="';
            if (isset($_POST['email'])) {
                $content .= $_POST['email'];
            }
            $content .= '" />';
             if ($referer_link) {
                $content .= '<input type="hidden" name="referer_link" value="'.$referer_link.'" />';
            }
            
            $content .= '<br /><input class="submit" type="submit" name="Try Again!" value="Try Again!" />';
            $content .= '</form>';
            $content .= '<a href="/php/forgot_password.php" title="Forgot Password" class="center">Forgot Password</a>';
            $content .= '</div>';
        }
        break;

    // was submitted, has bad keys and also reached the maximum try's
    case 3:
        if(!headers_sent() && isset($captcha->badguys_url)) header('location: '.$captcha->badguys_url);
        $content .= "<p><br>Reached the maximum try's of ".$captcha->maxtry." without success!";
        $content .= "<br><br><a href=\"".$_SERVER['PHP_SELF']."?download=yes&id=1234\">Try Again!</a></p>";
        break;


    // was not submitted, first entry
    // was submitted with no matching keys, but has not reached the maximum try's
    case 2:
    default:
        $form = form();

        $login_form = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/template/captcha.html');

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
        
        $content .= Utility::templateParser($login_form, $params, '{', '}');
        break;
}


// Include the HTML footer.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');

?>