<?php
namespace Application\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractDbTableFactory implements FactoryInterface
{
	/**
	 * Database adapter
	 *
	 * @var string
	 */
	protected $dbAdapter = 'Zend\Db\Adapter\Adapter';
	
	abstract protected function getName();
	
	public function createService(ServiceLocatorInterface $sm)
	{
		$dbAdapter = $sm->get($this->dbAdapter);
		$table = $this->getName();
	
		return new $table($dbAdapter);
	}
}
