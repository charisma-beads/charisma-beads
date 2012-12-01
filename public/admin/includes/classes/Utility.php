<?php
/* 
 * Utility.php
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

/**
 * Group of Utility functions for Charisma Beads Ltd shop.
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Utility
{
    /**
     * Parses html template
     *
     * @static
     * @param string $template
     * @param array $params
     * @param string $key_start
     * @param string $key_end
     * @return string
     * @access public
     */
    public static function templateParser($template, $params, $key_start, $key_end)
	{
		// Loop through all the parameters and set the variables to values.
		foreach ($params as $key => $value):
			$template_name = $key_start . $key . $key_end;
			$template = str_replace ($template_name, $value, $template);
		endforeach;
		return $template;
	}
    
    /**
     * Removes a section of the template.
     * 
     * @static
     * @param string $message
     * @param string $type
     * @return string
     * @access public
     */
    public static function removeSection($message, $type)
	{
		return preg_replace("/<!--".$type."_start-->(.*?)<!--".$type."_end-->/s", "", $message);
	}

    /**
     * Returns a html return link for shopping cart
     * 
     * @param none
     * @return string
     * @access public
     */
    public static function returnLink($link, $text)
	{
		return '<a id="returnLink" class="button" href="'.$link.'">'.$text.'</a>';
	}

    /**
     *
     * @static
     * @param none
     * @return string
     * @access public
     */
    public static function getPath()
    {
        return explode('/',substr(REQUEST_URI,1));
    }

    /**
     * Function for escaping and trimming form data.
     *
     * @static
     * @param string $data String containing data to parse.
     * @return string Escaped data string.
     * @access public
     */
    public static function escape ($data)
    {
        if (ini_get('magic_quotes_gpc')) {
            $data = stripslashes($data);
        }
        return ($data);
    }

    /**
     * Goto new page.
     *
     * <pre>
     * go('index.php');
     * </pre>
     *
     * @static
     * @param string $go Location where to go relative to website document route.
     * @return none
     * @access public
     */
    public static function go($go)
    {
        if (isset ($_SERVER['HTTPS'])) {
            $http = "https://";
        } else {
            $http = "http://";
        }
        $host = $_SERVER['HTTP_HOST'];
        $uri = dirname ($_SERVER['PHP_SELF']);
        header ("Location: " . $http . $host . $uri . "/" . $go);
        ob_end_clean();
        exit;
    }

    /**
     * Print out $GLOBALS
     *
     * @static
     * @param none
     * @return none
     * @access public
     */
    public static function globals()
    {
        print "<pre>";
        print_r ($GLOBALS);
        print "</pre>";
    }

    /**
     * Returns whether module is installed or not.
     * 
     * @static
     * @param string $module module to check.
     * @return bool returns true or false.
     * @access public
     */
    public static function module_installed ($module)
    {
        $query = "
            SELECT module_id
            FROM modules
            WHERE module='$module'
            ";
        $result = mysql_query ($query);

        if (mysql_num_rows ($result) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    /**
     * Edits a configuration file.
     * 
     * @static
     * @param <type> $file
     * @return none
     * @access public
     */
    public static function edit_details($file)
    {
        $fp = fopen ($file, 'wb');

        if ($fp) {
            $data = '<?php'."\r\n";

            foreach ($_POST as $key => $value) {
                if (ini_get ('magic_quotes_gpc')) {
                    if ($key != "submit") {
                        $value = stripslashes ($value);
                        $data .= '$'.$key.'="'.$value.'";'."\r\n";
                    }
                } else {
                    if ($key != "submit") {
                        $data .= '$'.$key.'="'.$value.'";'."\r\n";
                    }
                }
            }

            $data .= '?>'."\r\n";
            fwrite ($fp, $data);
            fclose ($fp);
            print '<p>Your update to has been successful.</p>';
        } else {
            print '<p>Your update could not be stored due to a system error.</p>';
        }
    }

    /**
     * Copies file or directory.
     *
     * @static
     * @param string $source
     * @param string $dest
     * @param int $chmod
     * @return bool
     * @access public
     */
    public static function copyr($source, $dest, $chmod=0777)
    {
        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest);
            chmod($dest, $chmod);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            if ($dest !== "$source/$entry") {
                copyr("$source/$entry", "$dest/$entry");
                chmod("$dest/$entry", $chmod);
            }
        }

        // Clean up
        $dir->close();
        return true;
    }

    /**
     * Removes file or directory from file system.
     *
     * @static
     * @param string $dirname Directory to remove.
     * @return bool True or false.
     * @access public
     */
    public static function rmdirr($dirname) {
        // Sanity check
        if (!file_exists($dirname)) {
            return false;
        }

        // Simple delete for a file
        if (is_file($dirname) || is_link($dirname)) {
            return unlink($dirname);
        }

        // Loop through the folder
        $dir = dir($dirname);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Recurse
            rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
        }

        // Clean up
        $dir->close();
        return rmdir($dirname);
    }

    public function filterString($value)
    {
        $find    = array( '`', '&',   ' ', '"', "'" );
        $replace = array( '',  'and', '_', '',  '', );
        $new = str_replace( $find, $replace,$value);

        $noalpha = 'ÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÀÈÌÒÙàèìòùÄËÏÖÜäëïöüÿÃãÕõÅåÑñÇç@°ºª';
        $alpha   = 'AEIOUYaeiouyAEIOUaeiouAEIOUaeiouAEIOUaeiouyAaOoAaNnCcaooa';

        $new = substr( $new, 0, 255 );
        $new = strtr( $new, $noalpha, $alpha );

        // not permitted chars are replaced with "-"
        $new = preg_replace( '/[^a-zA-Z0-9_\+]/', '_', $new );

        //remove -----'s
        $new = preg_replace( '/(_+)/', '_', $new );

        return rtrim( $new, '_' );
    }

    public static function getShopImage($img)
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'].$img)) {
            $img_file = $img;
        } else {
            $img_file = "/shop/images/nopic.jpg";
        }

		return $img_file;

		/*
        $filename = $_SERVER['DOCUMENT_ROOT'] . '/shop/cache/' . md5($img_file);

        if(!file_exists($filename)) {
            $image = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].$img_file);

            // start buffering
            ob_start();
            imagejpeg($image, null, 100);
            $contents =  ob_get_contents();
            ob_end_clean();

            file_put_contents($filename, $contents);

            imagedestroy($image);
        }
        
        $size = getimagesize($_SERVER['DOCUMENT_ROOT'].$img_file);

        return array(
            //'src' => '',
            'decodeImage' => $img_file,
            'image' => md5($img_file),
            'size'  => array('x' => $size[0], 'y' => $size[1])
            );
		*/
    }
}
?>
