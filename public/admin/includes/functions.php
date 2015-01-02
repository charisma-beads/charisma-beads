<?php 
/*
 * functions.php
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

// Set include paths.
set_include_path($_SERVER['DOCUMENT_ROOT'].'/admin/includes/classes'
    .PATH_SEPARATOR.
    realpath($_SERVER['DOCUMENT_ROOT'].'/../php')
);

// Setup zf2 autoloading
$zf2Autoloader = include $_SERVER['DOCUMENT_ROOT'].'/../vendor/autoload.php';

// Auto load classes.
function CBAutoLoader ($class_name)
{
	$class_name = explode("_", $class_name);
	$class_path = null;
	foreach ($class_name as $key => $value) {
		$class_path .= '/'.$value;
	}
	$class_path = substr($class_path, 1);
	require_once($class_path . '.php');
};
spl_autoload_register('CBAutoLoader');
//$errors = ErrorLogging::getInstance();
?>
