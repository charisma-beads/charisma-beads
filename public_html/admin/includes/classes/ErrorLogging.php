<?php
/*
 * ErrorLogging.php
 *
 * Copyright (c) 2010 Shaun Freeman <shaun@shaunfreeman.co.uk>.
 *
 *
 * ErrorLogging.php is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ErrorLogging.php is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ErrorLogging.php.  If not, see <http ://www.gnu.org/licenses/>.
 */

/**
 * This class handles and logs the error that occurs in the project
 *
 * @author Nitesh Apte
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright 2010
 * @version 1.0
 * @access private
 * @License GPLv3
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/../data/conf.php';

class ErrorLogging
{	
	/**
     * Holds the ErrorLogging class object
     *
	 * @var object $Instance Contains the Instance of this class
     * @static
     * @access private
	 */
	private static $Instance;

    /**
     * Holds the error messages
     * 
     * @var array An array of error types
     * @access private
     */
	private $errorType = array (
		E_ERROR				=> 'ERROR',
		E_WARNING			=> 'WARNING',
		E_PARSE				=> 'PARSING ERROR',
		E_NOTICE			=> 'NOTICE',
		E_CORE_ERROR		=> 'CORE ERROR',
		E_CORE_WARNING		=> 'CORE WARNING',
		E_COMPILE_ERROR		=> 'COMPILE ERROR',
		E_COMPILE_WARNING	=> 'COMPILE WARNING',
		E_USER_ERROR		=> 'USER ERROR',
		E_USER_WARNING		=> 'USER WARNING',
		E_USER_NOTICE		=> 'USER NOTICE',
		E_STRICT			=> 'STRICT NOTICE',
		E_RECOVERABLE_ERROR	=> 'RECOVERABLE ERROR',
		E_DEPRECATED		=> 'DEPRECATED',
		E_USER_DEPRECATED	=> 'USER DEPRECATED'
	);
	
	/**
	 * Turn error reporting on, set custom error handler and register
     * the shutdown function
	 * 
	 * @param none
	 * @return none
     * @access private
	 */
	private function __construct()
	{
		error_reporting (1);
		set_error_handler(array($this,'getCustomError'));
		register_shutdown_function(array($this, 'getFatalError'));
	}
	
	/**
	 * Set so this class cannot be cloned
	 * 
	 * @param none
	 * @return none
     * @access private
	 */
	private function __clone()
	{
	}
	
	/**
	 * A new ErrorLogging object is only created if no other ErrorLogging
     * object exists else reurns the existing Errorlogging object.
     *
     * <pre>
     * For example:
     *      $error = ErrorLogging::getInstance();
     * And NOT
     *      $error = new ErrorLogging();
     * </pre>
	 * 
	 * @param none
	 * @return ErrorLogging
     * @static
     * @access public
	 */
	public static function getInstance()
	{
		if (!self::$Instance) self::$Instance = new ErrorLogging();
		
		return self::$Instance;
	}
	
	/**
	 * get private customError method
	 * 
	 * @param Int $errNo Error number
	 * @param String $errStr Error string
	 * @param String $errFile Error file
	 * @param Int $errLine Error line
	 * @return none
     * @access public
	 */
	public function getCustomError($errNo, $errStr, $errFile, $errLine, $errContext)
	{
		$this->customError($errNo, $errStr, $errFile, $errLine, $errContext);
	}
	
	/**
	 * get private fatalFrror method
	 *
	 * @param none
	 * @return none
     * @access public
	 */
	public function getFatalError()
	{
		$this->fatalError();
	}
	
	/**
	 * Custom error logging in custom format
	 * 
	 * @param Int $errNo Error number
	 * @param String $errStr Error string
	 * @param String $errFile Error file
	 * @param Int $errLine Error line
	 * @return none
     * @access private
	 */
	private function customError($errNo, $errStr, $errFile, $errLine, $errContext)
	{
		if(!error_reporting()) return;
		
		$backTrace = $this->debugBacktrace();

        if ($errStr == 'SQL') {
            $errorMessage = "\n<h1>Error SQL</h1>";
            $errorMessage .= "\n<p><b>ERROR: </b><font color='red'>".SQL_ERROR."</font></p>";
            $errorMessage .= "\n<p><b>TEXT : </b><font color='red'>".SQL_MESSAGE."</font></p>";
            $errorMessage .= "\n<p><b>QUERY : </b><font color='red'><pre>".SQL_QUERY."</pre></font></p>";
        } else {
            $errorMessage = "\n<h1>Error {$this->errorType[$errNo]}</h1>";
            $errorMessage .= "\n<p><b>ERROR NO : </b><font color='red'>{$errNo}</font></p>";
            $errorMessage .= "\n<p><b>TEXT : </b><font color='red'>{$errStr}</font></p>";
        }

        $errorMessage .= "\n<p><b>LOCATION : </b><font color='red'>{$errFile}</font>, <b>line</b> {$errLine}, at ".date("F j, Y, g:i a")."</p>";
        $errorMessage .= "\n<p><b>Showing Backtrace : </b>\n{$backTrace}</p>\n\n";
		
		if (SEND_ERROR_MAIL) {
            error_log($errorMessage, 1, ADMIN_ERROR_MAIL, "MIME-Version: 1.0\r\nFrom: ".SEND_ERROR_FROM."\r\nContent-type: text/html\r\nX-Mailer: PHP/" . phpversion());
        }
		
		if (ERROR_LOGGING) error_log($errorMessage, 3, ERROR_LOGGING_FILE);
		
		if (DEBUGGING):
			echo '<div class="error">'.$errorMessage.'</div>';
		else:
			echo SITE_GENERIC_ERROR_MSG;
		endif;
		
		if (IS_WARNING_FATAL) exit;
	}

    /**
     * Build SQL error message
     * 
     * @param int $errNo SQL error number
     * @param string $errStr SQL message string
     * @param string $query The SQL query string
     * @access public
     */
    public function sqlErrorHandler($errNo, $errStr, $query)
    {
        define('SQL_ERROR', $errNo);
        define('SQL_MESSAGE', $errStr);
        define('SQL_QUERY', $query);
        trigger_error("SQL", E_USER_ERROR);
    }
	
	/**
	 * Build backtrace message
     *
     * @todo Add auguments to backtrace.
	 * @param none
	 * @return  backtrace message
     * @access private
	 */
	private function debugBacktrace()
	{	
		$dbgMsg = '<div class="backtrace">';
		$aCallstack = debug_backtrace();
		
		$dbgMsg .= "<table><thead><tr><th>file</th><th>line</th><th>function</th>".
		"</tr></thead>";
		
		foreach($aCallstack as $aCall):
			if (!isset($aCall['file'])) $aCall['file'] = '[PHP Kernel]';
			if (!isset($aCall['line'])) $aCall['line'] = '';
			$dbgMsg .= "<tr><td>{$aCall["file"]}</td><td>{$aCall["line"]}</td>".
			"<td>{$aCall["function"]}</td></tr>";
		endforeach;
		
		$dbgMsg .= "</table></div>";
		return $dbgMsg;
	}
	
	/**
	 * Fatal error logging in custom format
	 * 
	 * @param none
	 * @return none
     * @access private
	 */
	private function fatalError()
	{
		$lastError = error_get_last();
		
		if ($lastError['type'] == E_ERROR || $lastError['type'] == E_PARSE || $lastError['type'] == E_CORE_ERROR || $lastError['type'] == E_COMPILE_ERROR || $lastError['type'] == E_USER_ERROR || $lastError['type'] == E_RECOVERABLE_ERROR):
			$this->customError($lastError['type'], $lastError['message'], $lastError['file'], $lastError['line'], null);
		endif;
	} 
	
}
?>
