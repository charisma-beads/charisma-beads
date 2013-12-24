<?php

class Session
{
	// session-lifetime
	public $lifeTime = 3600; // expires in 60 minutes 60*60
	// mysql-handle
	public $dbHandle;
	private static $Instance;

	private function __construct ($lifeTime, $admin)
	{
		$this->dbHandle = $GLOBALS['dbc'];

		if ($lifeTime) $this->lifeTime = $lifeTime;
        $sessionName = (true === $admin) ? 'CBAdminPHPSession' : 'CBPHPSession';

		session_set_save_handler(
			array(&$this, 'open'),
			array(&$this, 'close'),
			array(&$this, 'read'),
			array(&$this, 'write'),
			array(&$this, 'destroy'),
			array(&$this, 'gc')
		);
		register_shutdown_function('session_write_close');
		ini_set ('session.cookie_lifetime', $this->lifeTime);
		ini_set ('session.gc_maxlifetime', $this->lifeTime);
		//ini_set ('session.gc_probability', 100);

        session_set_cookie_params($this->lifeTime, '/');
        session_name($sessionName);
		session_start();
		setcookie(session_name(),session_id(),time()+$this->lifeTime, '/');
		//session_regenerate_id(true);

	}

	private function __clone()
	{}

	public static function getInstance($lifeTime=null, $admin=false)
	{
		if (!self::$Instance)
		{
			self::$Instance = new Session($lifeTime, $admin);
		}

		return self::$Instance;
	}

	public function open($savePath, $sessName)
	{
		return true;
	}

	public function close()
	{
		$this->gc($this->lifeTime);
		// close database-connection
		return mysql_close($this->dbHandle);
	}

	public function read($sessID)
	{
		// fetch session-data
		$res = mysql_query("
			SELECT session_data AS d FROM sessions
			WHERE session = '$sessID'
			AND session_expires >
		".time(),$this->dbHandle);

		// return data or an empty string at failure
		if($row = mysql_fetch_assoc($res)) return $row['d'];
		return "";
	}

	public function write($sessID,$sessData)
	{
		// new session-expire-time
		$newExp = time() + $this->lifeTime;
		// is a session with this id in the database?
		$sessData = escape_data($sessData);

		$res = mysql_query("
			SELECT * FROM sessions
			WHERE session = '$sessID'
		",$this->dbHandle);
		// if yes,
 	 	if(mysql_num_rows($res)) {
			// ...update session-data
			mysql_query("
				UPDATE sessions
				SET session_expires = '$newExp',
	 			session_data = '$sessData'
				WHERE session = '$sessID'
			",$this->dbHandle);

			// if something happened, return true
			if(mysql_affected_rows($this->dbHandle)) return true;
  		}
		// if no session-data was found,
  		else {
			// create a new row
			mysql_query("
				INSERT INTO sessions (
	 				session,
  					session_expires,
  					session_data)
				VALUES(
	 				'$sessID',
  					'$newExp',
  					'$sessData')
			",$this->dbHandle);
			// if row was created, return true
			if(mysql_affected_rows($this->dbHandle)) return true;
  		}
		// an unknown error occured
		return false;
	}

	public function destroy($sessID)
	{
		// delete session-data
		mysql_query("
			DELETE FROM sessions
			WHERE session = '$sessID'
		",$this->dbHandle);
		// if session was deleted, return true,
  		if(mysql_affected_rows($this->dbHandle)) return true;
		// ...else return false
		return false;
	}

	public function gc($sessMaxLifeTime)
	{
		// delete old sessions
		mysql_query("
			DELETE FROM sessions
			WHERE session_expires <
		".time(),$this->dbHandle);
		// return affected rows
		return mysql_affected_rows($this->dbHandle);
	}
}

?>
