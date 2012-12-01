<?php
require_once("config_tinybrowser.php");

header ("Content-type: text/css");
?>
.panel_wrapper div.currentmod {
display:block;
width:100%; 
overflow-x:hidden;
}
form {
margin: 0;
padding: 0;
}
form.custom {
text-align: right;
padding: 4px;
}
form.custom select, form.custom input {
margin: 0 5px 0 2px;
}
.del {
border: none;
width: 13px; /* for IE */ 
height: 13px; /* For IE */ 
}
body {
font-family: Tahoma, Arial, Helvetica, sans-serif;
}
button {
font-size: 11px;
background-color: #d5d5d5;
border: 1px solid #666666;
padding: 0;
}
button:hover {
background-color:#99cc33;
cursor: hand;
}
button.delete:hover {
background-color:#ff9999;
}
table.browse {
width: 100%;
border: 0;
border-collapse: collapse;
}
table.browse th, table.browse td {
text-align: left;
padding: 5px;
}
table.browse tr.r0 td {
	background-color: #FFFFFF;
}
table.browse tr.r1 td {
	background-color: #F0F0F0;
}
.img-browser {
float: left;
clear: none;
text-align: center;
height: <?php echo $tinybrowser['thumbsize']+48; ?>px;
width: <?php echo $tinybrowser['thumbsize']+35; ?>px;
font-size: <?php echo $tinybrowser['thumbsize']+13; ?>px;
}
*+html .img-browser { width: <?php echo $tinybrowser['thumbsize']+40; ?>px; } /*IE7+ */
* html .img-browser { width: <?php echo $tinybrowser['thumbsize']+40; ?>px; } /*IE6- */
.img-browser img {
background-color: #ffffff;
padding: 4px;
border: 1px solid #888888;
vertical-align: middle;
}
.img-browser a:hover img {
background-color: #ffff00;
}
.filename {
font-family: Tahoma, Arial, Helvetica, sans-serif;
font-size: 11px;
line-height: 13px;
padding-left: 13px;
text-decoration: none;
overflow: hidden;
width: <?php echo $tinybrowser['thumbsize']+10; ?>px;
}
*+html .filename { margin-top: -12px; padding-left: 5px; } /*IE7+ */
* html .filename { margin-top: -12px; padding-left: 5px; } /*IE6- */