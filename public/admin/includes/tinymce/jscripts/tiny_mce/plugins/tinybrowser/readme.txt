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


TinyBrowser 1.10 features:
==========================

- Integrates as a custom file browser within TinyMCE for image, media and 'all' file types

- Adobe Flash based file uploader, supporting multiple file selection and upload with file type and size filtering (permission based)

- Browse files with a list view or as thumbnails (images only)

- File display order customisable e.g. by name, type, size, date

- Find function to filter results by search string 

- Display detailed file information such as type, size and dimensions (images only)

- File deletion facility (permission based)

- File storage location user definable for each file type

- Optional session control

- Many user definable settings, all from central configuration file


TinyBrowser Background
======================

I created TinyBrowser as I couldn't find the right TinyMCE file browser for my needs, particularly the ablilty to select and upload multiple files in an easy way.

I found a nice Adobe Flash script (credit to Joseph Montanez - www.gorilla3d.com) that enabled easy file uploading, so I modified it a little to fit my purpose and built TinyBrowser around it.  


Version Notes
=============

   TinyBrowser 1.10 
   Adjusted layout of file upload.
   Added facility to limit permitted file upload size (separate values for each file type). 
   Amended installation instructions for clarity.
   Tested as working in Opera 9.

   TinyBrowser 1.00 
   Tested in Firefox 2 and 3, Internet Explorer 6 and 7 and Safari 3.
   Requires Adobe Flash Player 9.


Installation
============

1) Copy the tinybrowser folder and contents to your TinyMCE plugins directory.


2) Place the following javascript function where your TinyMCE init call exists (this function adds TinyBrowser as a custom file browser):

   <script type="text/javascript">
    function tinyBrowser (field_name, url, type, win) {

       /* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
          the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
          These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

       var cmsURL = "/functions/tiny_mce/plugins/tinybrowser/tinybrowser.php";    // script URL - use an absolute path!
       if (cmsURL.indexOf("?") < 0) {
           //add the type as the only query parameter
           cmsURL = cmsURL + "?type=" + type;
       }
       else {
           //add the type as an additional query parameter
           // (PHP session ID is now included if there is one at all)
           cmsURL = cmsURL + "&type=" + type;
       }

       tinyMCE.activeEditor.windowManager.open({
           file : cmsURL,
           title : 'My File Browser',
           width : 650, 
           height : 440,
           resizable : "yes",
           scrollbars : "yes",
           inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
           close_previous : "no"
       }, {
           window : win,
           input : field_name
       });
       return false;
     }
   </script>

   ***NOTE:*** Be sure to amend the 'var cmsURL = ' line to point towards your installation of the TinyBrowser tinybrowser.php file! 


3) Add this line to your TinyMCE init:

   file_browser_callback : "tinyBrowser"


4) Edit the TinyBrowser configuration file (config_tinybrowser.php) - most importantly the file paths, and make sure those paths exist in your website structure.

   ***NOTE:*** A 'thumbs' directory also needs to exist within the defined image directory, to hold the generated thumbnail images.


5) All done! Please notify me by email bryn@lunarvis.com if you notice any bugs or have ideas for new features.