<?php

class Security_Cipher
{
	private $algo;
	private $mode;
	private $source;
	private $iv = null;
	private $key = null;

	public function __construct($algo = MCRYPT_3DES, $mode = MCRYPT_MODE_CBC, $source = MCRYPT_RAND)
	{
		$this->algo = $algo;
		$this->mode = $mode;
		$this->source = $source;
		
		if (is_null($this->algo) || (strlen($this->algo) == 0)) $this->algo = MCRYPT_3DES;
		
		if (is_null($this->mode) || (strlen($this->mode) == 0)) $this->mode = MCRYPT_MODE_CBC;
	}
	
	public function __destruct()
	{
		//shutdown mcrypt 
    	//mcrypt_generic_deinit($this->td);
		
		// close mcrypt cipher module 
		//mcrypt_module_close($this->td);
	}

	public function encrypt($data, $key=null, $iv=null)
	{
		$key = (strlen($key) == 0) ? $key = null : $key;
		
		$this->setKey($key);
		$this->setIV($iv);
		
		$out = mcrypt_encrypt($this->algo, $this->key, $data, $this->mode, $this->iv);
		return base64_encode($out);
	}

	public function decrypt($data, $key=null, $iv=null)
	{
		$key = (strlen($key) == 0) ? $key = null : $key;
		
		$this->setKey($key);
		$this->setIV($iv);
		
		$data = base64_decode($data);
		$out = mcrypt_decrypt($this->algo, $this->key, $data, $this->mode, $this->iv);
		return trim($out);
	}
	
	public function getIV()
	{
		return base64_encode($this->iv);
	}
	
	private function setIV($iv)
	{
		if (!is_null($iv)) $this->iv = base64_decode($iv);
		
		if (is_null($this->iv)):
			$iv_size = mcrypt_get_iv_size($this->algo, $this->mode);
			$this->iv = mcrypt_create_iv($iv_size, $this->source);
		endif;
	}
	
	private function setKey($key)
	{
		if (!is_null($key)):
			$key_size = mcrypt_get_key_size($this->algo, $this->mode);
			$this->key = hash("whirlpool", $key, true);
			$this->key = substr($this->key, 0, $key_size);
		endif;
		if (is_null($this->key)):
			trigger_error("You must specify a key at least once in either Cipher::encrpyt() or Cipher::decrypt().", E_USER_ERROR);
		endif;
	}
}

class Utility
{	
	private function encodeKey()
	{	
		$key = 'Death be not proud, though some have called thee Mighty and dreadful.';
		$key_length = strlen($key);
		$key = str_split($key, $key_length / 3);
		$key = $key[0] . $this->SERVER_NAME. $key[1] . $this->SERVER_ADDR . $key[2];
		return $key;
	}
	
	public function decodeString($str, $iv)
	{
		$cipher = new Security_Cipher(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CFB);
		$key = $this->encodeKey();
		return $cipher->decrypt($str, $key, $iv);
	}
	
	public function encodeString($str)
	{
		$cipher = new Security_Cipher(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CFB);
		$key = $this->encodeKey();
		$str = $cipher->encrypt($str, $key);
		$iv = $cipher->getIV();
		return array($str, $iv);
	}
}

$u = new Utility();

$u->SERVER_NAME = 'www.charismabooks.co.uk';
$u->SERVER_ADDR = '85.92.86.117';
$str = '9LG1GmMbIMFA';
$iv = '1ZEMCF6ak5zWIpX23BBQOLO97V/r0Jgm2fznDVNWUMw=';

$str = $u->decodeString($str,$iv);
print $str . "\n";
$u->SERVER_ADDR = '213.165.71.190';
print_r($u->encodeString($str));
print "\n";


?>
