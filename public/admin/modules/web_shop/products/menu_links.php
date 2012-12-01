	<?php
	if (isset ($_GET['s']) && isset ($_GET['np'])) {
		$page_num = "?s={$_GET['s']}&np={$_GET['np']}";
	} else {
		$page_num = NULL;
	}
	// Menu Links
	print "<table width=\"200\">";
	print "<tr><td height=\"25\" class=\"Link\" onMouseOver=\"this.className='bodyLink'\" onMouseOut=\"this.className='Link'\"><a href=\"index.php$page_num\" class=\"Link\">:: Products</a></td></tr>";
	print "<tr><td height=\"25\" class=\"Link\" onMouseOver=\"this.className='bodyLink'\" onMouseOut=\"this.className='Link'\"><a href=\"discontinued_list.php\" class=\"Link\">:: Discontinued Products</a></td></tr>";
	print "<tr><td height=\"25\" class=\"Link\" onMouseOver=\"this.className='bodyLink'\" onMouseOut=\"this.className='Link'\"><a href=\"categories.php\" class=\"Link\">:: Product Categories</a></td></tr>";
	print "<tr><td height=\"25\" class=\"Link\" onMouseOver=\"this.className='bodyLink'\" onMouseOut=\"this.className='Link'\"><a href=\"group_price.php\" class=\"Link\">:: Group Prices</a></td></tr>";
	print "</table>";
	?>