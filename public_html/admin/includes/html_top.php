<?php # html header
// This page begins the html header for this site.

require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/authentication.php");

require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/listmod.php"); 
 
// Check for page title value.
if (!isset($page_title)) {
	$page_title=$merchant_name;
	}

if (isset ($quirks) == 1) {
		print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">";
		print "<html>";
	} else {
		print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
		print "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
	}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php print ($page_title); ?></title>
<meta name="description" content="<?php print $merchant_name; ?>" />
<meta name="keywords" content="" />
<meta name="author" content="shaun@shaunwebapps.co.uk" />

<script type="text/javascript" src="/admin/js/mootools-compressed.js"></script>
<script type="text/javascript" src="/admin/js/java.js"></script>

<link href="/admin/css/style.css" rel="stylesheet" type="text/css">
<?php
if (isset ($custom_headtags)) {
	echo $custom_headtags;
} 
?>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="73" background="/admin/images/images/topbg.gif"><table width=100% border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="12"><img src="/admin/images/images/topleft.gif" width=12 height=73></td>
		<td width="75"><img src="/admin/images/images/logo.gif" width="75" /></td>
		<td width="100%" align="center"><h1 style="color:#545454;"><?php print $page_title; ?></h1></td>
        <td width="14"> <img src="/admin/images/images/topright.gif" width="14" height="73"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="36" background="/admin/images/images/subnavbg.gif"><table width=100% border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="12"> <img src="/admin/images/images/subnavleft.gif" width="12" height="36"></td>
        <td>&nbsp;</td>
        <td width="14"><img src="/admin/images/images/subnavright.gif" width="14" height="36"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
      <?php if (pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME) != 'login.php') { ?>
        <td width="140" valign="top"><table border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td background="/admin/images/images/navbg.gif"><?php menu (); ?></td>
          </tr>
         
          <tr>
            <td height="25"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" width="12"><img src="/admin/images/images/sidebg2.gif" width="12" height="146"></td>
                <td style="background-image:url(/admin/images/images/sidebg1.gif); background-repeat:repeat-x; padding:10px;"></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <?php } ?>
        <td valign="top" style="padding:15px 25px 15px 25px;width:100%;">
			<div id="loading">LOADING PLEASE WAIT</div>
			<script>
				var windowSize = window.getSize();
			  	$('loading').setStyles({
				  'left': ((windowSize.size.x / 2) - ($('loading').getSize().size.x / 2)) + 'px',
	  				'top': ((windowSize.size.y / 2) - ($('loading').getSize().size.y / 2)) + 'px'
				});
			</script>
<!-- content starts here -->
