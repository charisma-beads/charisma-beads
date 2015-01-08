<?php
/*
TinyBrowser 1.10 - A TinyMCE file browser (C) 2008  Bryn Jones
(Flash upload contains a modified version of FlexUpload by Joseph Montanez http://www.gorilla3d.com/v4/index.php/blog/entry/33)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// set script time out higher, to help with thumbnail generation
set_time_limit(240);

$tinybrowser = array();

// Default is $_SERVER['DOCUMENT_ROOT'] (suitable when using absolute paths, but can be set to '' if using relative paths)
$tinybrowser['docroot'] = $_SERVER['DOCUMENT_ROOT'];

// File upload paths
$tinybrowser['path']['image'] = '/userfiles/Image/'; // Image files location - also create a 'thumbs' directory within this path to hold the image thumbnails
$tinybrowser['path']['media'] = '/userfiles/Media/'; // Media files location
$tinybrowser['path']['file']  = '/userfiles/File/'; // Other files location

// File upload size limit (0 is unlimited)
$tinybrowser['maxsize']['image'] = 0; // Image file maximum size
$tinybrowser['maxsize']['media'] = 0; // Media file maximum size
$tinybrowser['maxsize']['file']  = 0; // Other file maximum size

// Image thumbnail size in pixels
$tinybrowser['thumbsize'] = 80;

// Image thumbnail quality, higher is better (1 to 99)
$tinybrowser['thumbquality'] = 80;

// Date format, as per php date function
$tinybrowser['dateformat'] = 'd/m/Y H:i';

// Permitted file extensions
$tinybrowser['filetype']['image'] = '*.jpg, *.jpeg, *.gif, *.png'; // Image file types
$tinybrowser['filetype']['media'] = '*.swf, *.dcr, *.mov, *.qt, *.mpg, *.mp3, *.mp4, *.mpeg, *.avi, *.wmv, *.wm, *.asf, *.asx, *.wmx, *.wvx, *.rm, *.ra, *.ram'; // Media file types
$tinybrowser['filetype']['file']  = '*.*'; // Other file types

// Prohibited file extensions
$tinybrowser['prohibited'] = array('php','php3','php5','phtml','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi', 'sh', 'py');

// Default file sort
$tinybrowser['order']['by'] = 'name'; // Possible values: name, size, type, created
$tinybrowser['order']['type'] = 'asc'; // Possible values: asc, desc

// Default image view method
$tinybrowser['view']['image'] = 'thumb'; // Possible values: thumb, detail

// TinyMCE dialog.css file location (shouldn't need changing)
$tinybrowser['tinymcecss'] = '../../../themes/advanced/skins/default/dialog.css';

// Assign Permissions for Upload and Delete
$tinybrowser['allowupload'] = true;
$tinybrowser['allowdelete'] = true;

// Session control and security check - to enable please uncomment
// session_start();
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/../data/database.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/mysql_connect.php");
$session = new Session(86400, true);
$tinybrowser['sessioncheck'] = 'authenticated_user'; //name of session variable to check
?>
