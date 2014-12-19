<?php // listmod.php (administration side) Friday, 8 April 2005


function menu () {

	global $merchant_website, $https;

	// scan modules diretory.
	$modules = glob ($_SERVER['DOCUMENT_ROOT'] . '/admin/modules/*', GLOB_ONLYDIR);

	// Start Table.
	print "<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
    print "<tr>";
    print "<td height=\"25\" class=\"menuLink\" onMouseOver=\"this.className='navbar'\" onMouseOut=\"this.className='menuLink'\"><p><a href=\"https://github.com/charisma-beads/charisma-beads/issues\" class=\"menuLink\" target=\"_blank\">:: Report Bugs</a></p>";
    print "</td>";
    print "</tr>";
    print "<tr>";
    print "<td><img src=\"$https/admin/images/images/navspacer.gif\" width=\"140\" height=\"1\"></td>";
    print "</tr>";
	print "<tr>";
    print "<td height=\"25\" class=\"menuLink\" onMouseOver=\"this.className='navbar'\" onMouseOut=\"this.className='menuLink'\"><p><a href=\"$https/admin/index.php\" class=\"menuLink\">:: Home</a></p>";
    print "</td>";
    print "</tr>";
    print "<tr>";
    print "<td><img src=\"$https/admin/images/images/navspacer.gif\" width=\"140\" height=\"1\"></td>";
    print "</tr>";

	foreach ($modules as $module ) {

		$target ="";
		$mod = explode ('/', $module);
		$n = count ($mod) - 1;
		$mod = ucwords (str_replace ("_", " ", $mod[$n]));
		$module = str_replace($_SERVER['DOCUMENT_ROOT'], '', $module);

		print "<tr>";
        print "<td height=\"25\" class=\"menuLink\" onMouseOver=\"this.className='navbar'\" onMouseOut=\"this.className='menuLink'\"><p><a href=\"$https$module/index.php\" class=\"menuLink\" target=\"$target\" >:: $mod</a></p>";
        print "</td>";
        print "</tr>";
        print "<tr>";
        print "<td><img src=\"/admin/images/images/navspacer.gif\" width=\"140\" height=\"1\"></td>";
        print "</tr>";
	}

	// Finsh Table.

	print "<tr>";
	print "<td height=\"25\" class=\"menuLink\" onMouseOver=\"this.className='navbar'\" onMouseOut=\"this.className='menuLink'\"><p><a href=\"$https/plesk-stat/webstat/\" class=\"menuLink\" target=\"_blank\">:: Web Statistics</a></p>";
	print "</td>";
	print "</tr>";
	print "<tr>";
    print "<td><img src=\"/admin/images/images/navspacer.gif\" width=\"140\" height=\"1\"></td>";
    print "</tr>";
    print "<td height=\"25\" class=\"menuLink\" onMouseOver=\"this.className='navbar'\" onMouseOut=\"this.className='menuLink'\"><p><a href=\"$https/admin/logout.php\" class=\"menuLink\">:: Logout</a></p>";
    print "</td>";
    print "</tr>";
    print "<tr>";
    print "<td><img src=\"/admin/images/images/navspacer.gif\" width=\"140\" height=\"1\"></td>";
    print "</tr>";
	print "<tr>";
    print "<td height=\"25\" class=\"menuLink\">&nbsp;</td>";
    print "</tr>";
    print "</table>";

}
?>