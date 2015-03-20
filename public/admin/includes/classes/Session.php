<?php

use Zend\Db\Adapter\Adapter;
use Zend\Session\SaveHandler\DbTableGatewayOptions;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\SaveHandler\DbTableGateway;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class Session
{
	// session-lifetime
	public $lifeTime = 3600; // expires in 60 minutes 60*60
	
	public static $mysqlDbAdaper;
	
	protected $config = [
		'session' => [
			'config' => [
				'options' => [
					'name' => 'CBPHPSession',
				],
			],
			'storage' => 'Zend\Session\Storage\SessionArrayStorage',
			'validators' => [
				'Zend\Session\Validator\RemoteAddr',
				'Zend\Session\Validator\HttpUserAgent',
			],
		],
		'db' => [
			'config' => [
				'idColumn' => 'id',
				'nameColumn' => 'name',
				'modifiedColumn' => 'modified',
				'dataColumn' => 'data',
				'lifetimeColumn' => 'lifetime'
			],
			'connection' => [
				'driver'         => 'PDO_MYSQL',
				'hostname'       => DB_HOST,
				'database'       => DB_NAME,
				'username'       => DB_USER,
				'password'       => DB_PASSWORD,
			],
		],
	];

	public function __construct ($lifetime=3600, $admin=false)
	{
        $sessionName = (true === $admin) ? 'CBAdminPHPSession' : 'CBPHPSession';

		$this->config['session']['config']['options']['name'] = (true === $admin) ? 'CBAdminPHPSession' : 'CBPHPSession';
		$this->config['session']['config']['options']['cookie_lifetime'] = $lifetime;
		$this->config['session']['config']['options']['gc_maxlifetime'] = $lifetime;
		$this->config['session']['config']['options']['cookie_path'] = '/';
		$this->config['session']['config']['options']['use_cookies'] = true;
		$this->config['session']['config']['options']['remember_me_seconds'] = $lifetime;
		
		$session = $this->createSessionService();

		$session->start();

		if (isset($_SESSION['cid'])) $session->getConfig()->setCookieLifetime($lifetime);
		 
		$container = new Container();
		
		if (!isset($container->init)) {
			$session->regenerateId(true);
			$container->init = 1;
		}

		return $session;
	}
	
	public function createDbService()
	{
	
		self::$mysqlDbAdaper = new Adapter($this->config['db']['connection']);
	
		// get the session options (column names)
		$sessionOptions = new DbTableGatewayOptions($this->config['db']['config']);
	
		// crate the TableGateway object specifying the table name
		$sessionTableGateway = new TableGateway('session', self::$mysqlDbAdaper);
		// create your saveHandler object
		$saveHandler = new DbTableGateway($sessionTableGateway, $sessionOptions);
	
		return $saveHandler;
	}

	public function createSessionService()
	{
		$config = $this->config;
		
		if (isset($config['session'])) {
			$session = $config['session'];
	
			$sessionConfig = null;
			if (isset($session['config'])) {
				$class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
				$options = isset($session['config']['options']) ? $session['config']['options'] : [];
				$sessionConfig = new $class();
				$sessionConfig->setOptions($options);
			}
	
			$sessionStorage = null;
			if (isset($session['storage'])) {
				$class = $session['storage'];
				$sessionStorage = new $class();
			}
	
			$sessionSaveHandler = $this->createDbService();
	
			$sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
	
			if (isset($session['validators'])) {
				$chain = $sessionManager->getValidatorChain();
				foreach ($session['validators'] as $validator) {
					 
					$validator = new $validator();
					$chain->attach('session.validate', [$validator, 'isValid']);
				}
			}
		} else {
			$sessionManager = new SessionManager();
		}
	
		Container::setDefaultManager($sessionManager);
	
		return $sessionManager;
	}
	
}

?>
