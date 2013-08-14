<?php

/*
**********************************************************************************
*
*  pat_fileperm.class.php
*
*  Class initially written for Php Admin Tools (http://pat.sourceforge.net)
*
*  license      : LGPL  (http://www.gnu.org)
*  author       : Jean Philippe Giot <jpgiot@ifrance.com>
*  version      : 1.0
*  release date : 
*  
**********************************************************************************
*  TODO
*
*   - ability to set directly an alpha string permission
*
*
**********************************************************************************
*  purpose of this class is to handle file permissions
*
*  it enable to get human readding strings for example -rw-rw-rw- or 755
*            to set permissions by ugo string or and array and save them
*
*
*  methods : 
*
*  set_file()
*  read_permissions()
*  get_human_readable_string()
*  get_octal_string()
*
*  get_permission_alpha()
*  get_permission_octal()
*  get_permission_array()
*  
*  
*  set_permission_array()
*  set_permission_octal()
*
*
*  save_permissions()
*
*  print_html_form_for_permissions()
*
*  html_box_chmod()
*  permission_array_to_octal()
*
*
************************************************************************************
*  different representations of a file permission
*
*  octal
*
*       0755    
*
*
*  alpha or 'human readable'
*
*
*       -rw-rw-rw-
*
*  array. used inside class only. bits are represented
*
*       first dimension
*               second dimension
*
*       ["owner"]
*               ["read"]
*               ["write"]
*               ["execute"]
*       ["group"]
*               ["read"]
*               ["write"]
*               ["execute"]
*       ["others"]
*               ["read"]
*               ["write"]
*               ["execute"]
*       ["bits"]
*               ["user"]
*               ["group"]
*               ["sticky"] 
*
************************************************************************************
*/



class file_perm
{
    // current file on which operations are done
    var $_current_file       = '';
    
    // permissions extracted or to be written
    var $_current_permission = '';

    // form variable name for permission array
    var $form_array_name     = 'pat_fileperm';
    
    
    /*
     *  set the working file
     */
    function set_file($path)
    {
        $this->_current_file       = $path;
        $this->_current_permission = '';
    }

    /*
     *  get permission for current file
     */
    function read_permissions()
    {
        if ('' == $this->_current_file) return false;

        $this->_current_permission = fileperms($this->_current_file);

        if ('' == $this->_current_permission ) return false; else return true;
    }


    /*
     *  returns a string used to represent permission in file explorers like -rw-rw-rw-
     */
    // ALIAS FOR get_human_readable_string
    function get_permission_alpha() { return $this->get_human_readable_string(); }


    /*
     *  returns a string used to represent permission in file explorers like -rw-rw-rw-
     */
    function get_human_readable_string()
    {
        $mode = $this->_current_permission;

        // Determine le type

             if($mode & 0x1000) $type='p'; // FIFO pipe
        else if($mode & 0x2000) $type='c'; // Character special
        else if($mode & 0x4000) $type='d'; // Directory
        else if($mode & 0x6000) $type='b'; // Block special
        else if($mode & 0x8000) $type='-'; // Regular
        else if($mode & 0xA000) $type='l'; // Symbolic Link
        else if($mode & 0xC000) $type='s'; // Socket
        else $type='u'; // UNKNOWN

        // Determine les permissions par groupe

        $owner["read"]    = ($mode & 00400) ? 'r' : '-';
        $owner["write"]   = ($mode & 00200) ? 'w' : '-';
        $owner["execute"] = ($mode & 00100) ? 'x' : '-';
        $group["read"]    = ($mode & 00040) ? 'r' : '-';
        $group["write"]   = ($mode & 00020) ? 'w' : '-';
        $group["execute"] = ($mode & 00010) ? 'x' : '-';
        $others["read"]    = ($mode & 00004) ? 'r' : '-';
        $others["write"]   = ($mode & 00002) ? 'w' : '-';
        $others["execute"] = ($mode & 00001) ? 'x' : '-';

        // Adjuste pour SUID, SGID et sticky bit

        if( $mode & 0x800 ) $owner["execute"] = ($owner[execute]=='x') ? 's' : 'S';
        if( $mode & 0x400 ) $group["execute"] = ($group[execute]=='x') ? 's' : 'S';
        if( $mode & 0x200 ) $others["execute"] = ($others[execute]=='x') ? 't' : 'T';

        return "$type$owner[read]$owner[write]$owner[execute]$group[read]$group[write]$group[execute]$others[read]$others[write]$others[execute]";
    }

    /*
     *  returns the octal representation of permissions like 0755
     */
    // ALIAS for get_octal_string()
    function get_permission_octal(){ return $this->get_octal_string(); }


    /*
     *  returns the octal representation of permissions like 0755
     */
    function get_octal_string()
    {
        if ('' == $this->_current_file) return false;
        $decperms = fileperms($this->_current_file);
        $octalperms = sprintf("%o",$decperms);
        // -4 value should include ugo and strange bits for files and folders
        return substr($octalperms,-4);
    }

    /*
     *  returns an array of permissions
     */
    function get_permission_array()
    {
        $mode = $this->_current_permission;

        // Determine le type

             if($mode & 0x1000) $type='p'; // FIFO pipe
        else if($mode & 0x2000) $type='c'; // Character special
        else if($mode & 0x4000) $type='d'; // Directory
        else if($mode & 0x6000) $type='b'; // Block special
        else if($mode & 0x8000) $type='-'; // Regular
        else if($mode & 0xA000) $type='l'; // Symbolic Link
        else if($mode & 0xC000) $type='s'; // Socket
        else $type='u'; // UNKNOWN

        $return_array['type'] = $type;

        // Determine les permissions par groupe

        $return_array['owner']["read"]    = ($mode & 00400) ? true : false;
        $return_array['owner']["write"]   = ($mode & 00200) ? true : false;
        $return_array['owner']["execute"] = ($mode & 00100) ? true : false;
        $return_array['group']["read"]    = ($mode & 00040) ? true : false;
        $return_array['group']["write"]   = ($mode & 00020) ? true : false;
        $return_array['group']["execute"] = ($mode & 00010) ? true : false;
        $return_array['others']["read"]    = ($mode & 00004) ? true : false;
        $return_array['others']["write"]   = ($mode & 00002) ? true : false;
        $return_array['others']["execute"] = ($mode & 00001) ? true : false;

        // Adjuste pour SUID, SGID et sticky bit

        if( $mode & 0x800 ) $return_array['bits']['user'] = ($return_array['owner']["execute"]=='x') ? 's' : 'S';
        if( $mode & 0x400 ) $return_array['bits']['group'] = ($return_array['group']["execute"]=='x') ? 's' : 'S';
        if( $mode & 0x200 ) $return_array['bits']['sticky'] = ($return_array['others']["execute"]=='x') ? 't' : 'T';

        return $return_array;
    }


    function set_permission_octal($mode)
    {
        $this->_current_permission = $mode;
    }

    /*
     *  wrapper function to chmod.
     *
     *  saves for current file the current rights
     *
     */
    function save_permissions()
    {
        return chmod($this->_current_file,$this->_current_permission);
    }
    
    
    /*
     *  set current permission with an input array, which one could be 
     *  drawn with method html_box_chmod()
     *
     */
    function set_permission_array($input_array)
    {
        if(is_array($input_array))
        {
            $this->_current_permission = $this->permission_array_to_octal($input_array);
            return true;
        }
        else return false;
    }


    /*
     *  transform an array of permissions in it's octal equivalent
     *
     */
    function permission_array_to_octal($inarray)
    {
        // READ : 4
        // WRITE: 2
        // EXEC : 1


        // strange bits
        // set user ID (4)
        // set group ID
        // save text image (1)
        $strange  = '0';
        $strange += 4 * $inarray['SUID'];
        $strange += 2 * $inarray['SGID'];    
        $strange += 1 * $inarray['sticky'];    

        // owner
        $cent  = 0;
        $cent += 4 * $inarray['owner_read'];
        $cent += 2 * $inarray['owner_write'];    
        $cent += 1 * $inarray['owner_execute'];


        // group
        $diz  = '0';
        $diz += 4 * $inarray['group_read'];
        $diz += 2 * $inarray['group_write'];    
        $diz += 1 * $inarray['group_execute'];


        // the rest of the world
        $unit  = '0';
        $unit += 4 * $inarray['others_read'];
        $unit += 2 * $inarray['others_write'];    
        $unit += 1 * $inarray['others_execute'];

        return $strange.$cent.$diz.$unit;
    }
    
    
    
    function print_html_form_for_permissions()
    {
        return $this->html_box_chmod($this->get_permission_array(),$this->form_array_name);
    }
    
    /*
     * return a html box for accesses to file
     * has inputs for changing it
     *
     * $default_values      array       which boxes to check by default
     *
     * $form_array_name     string      name of array that will contain 
     * 
     */
    function html_box_chmod($default_values,$form_array_name)
    {
        $owner_read     = ($default_values['owner']['read'])    ? ' checked' : '';
        $owner_write    = ($default_values['owner']['write'])   ? ' checked' : '';
        $owner_execute  = ($default_values['owner']['execute']) ? ' checked' : '';

        $group_read     = ($default_values['group']['read'])    ? ' checked' : '';
        $group_write    = ($default_values['group']['write'])   ? ' checked' : '';
        $group_execute  = ($default_values['group']['execute']) ? ' checked' : '';

        $others_read     = ($default_values['others']['read'])      ? ' checked' : '';
        $others_write    = ($default_values['others']['write'])     ? ' checked' : '';
        $others_execute  = ($default_values['others']['execute'])   ? ' checked' : '';

        $suid            = ($default_values['bits']['user'])    ? ' checked' : '';
        $sgid            = ($default_values['bits']['group'])   ? ' checked' : '';
        $sticky          = ($default_values['bits']['sticky'])  ? ' checked' : '';    

        $ret  = "<table border=0 cellspacing=0 cellpadding=2>\n";
        $ret .= "<tr>\n";
        $ret .= "  <td>Type</td>\n";
        $ret .= "  <td colspan=3>\n";    
        switch ($default_values['type'])
        {
             case 'p' : $ret .= 'FIFO pipe'; break;
             case 'c' : $ret .= 'Character special'; break;
             case 'd' : $ret .= 'Directory'; break;
             case 'b' : $ret .= 'Block special'; break;
             case '-' : $ret .= 'Regular File'; break;
             case 'l' : $ret .= 'Symbolic Link'; break;
             case 's' : $ret .= 'Socket'; break;
             case 'u' :
             default  : $ret .= 'Unknown'; break;
        }
        $ret .= "  </td>\n";
        $ret .= "</tr>\n";    
        $ret .= "  <th> </th>\n";
        $ret .= "  <th>User</th>\n";
        $ret .= "  <th>Group</th>\n";
        $ret .= "  <th>others</th>\n";
        $ret .= "</tr>\n";
        $ret .= "<tr>\n";
        $ret .= "  <th>Read</th>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[owner_read]\" value=\"1\"$owner_read></td>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[group_read]\" value=\"1\"$group_read></td>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[others_read]\" value=\"1\"$others_read></td>\n";
        $ret .= "</tr>\n";
        $ret .= "  <th>Write</th>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[owner_write]\" value=\"1\"$owner_write></td>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[group_write]\" value=\"1\"$group_write></td>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[others_write]\" value=\"1\"$others_write></td>\n";
        $ret .= "</tr>\n";
        $ret .= "  <th>Execute</th>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[owner_execute]\" value=\"1\"$owner_execute></td>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[group_execute]\" value=\"1\"$group_execute></td>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[others_execute]\" value=\"1\"$others_execute></td>\n";
        $ret .= "</tr>\n";
        $ret .= "</tr>\n";    
        $ret .= "  <th> </th>\n";
        $ret .= "  <th>SUID</th>\n";
        $ret .= "  <th>SGID</th>\n";
        $ret .= "  <th>sticky</th>\n";
        $ret .= "</tr>\n";        
        $ret .= "</tr>\n";
        $ret .= "  <th>Sp. bits</th>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[SUID]\" value=\"1\"$suid></td>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[SGID]\" value=\"1\"$sgid></td>\n";
        $ret .= "  <td align=\"center\"><input type=checkbox name=\"".$form_array_name."[sticky]\" value=\"1\"$sticky></td>\n";
        $ret .= "</tr>\n";    
        $ret .= "</table>\n";
        $ret .= "<!--\n";
        $ret .= "given mode :\n";
        foreach ($default_values as $people => $p_array)
        {
            $ret .= "$people:";
            if (is_array($p_array))
            foreach ($p_array as $right => $value) $ret .= "$right$value/";
            else $ret .= "$p_array";
            $ret .= "\n";
        }
        $ret .= "-->\n";
        //SUID, SGID et sticky bit
        return $ret;
    }    

}