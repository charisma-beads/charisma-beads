<?php
namespace User\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Application\Hydrator\Strategy\EmptyString;

class User extends AbstractHydrator
{
	public function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		
		$this->addStrategy('dateCreated', $dateTime);
		$this->addStrategy('dateModified', $dateTime);
		return $this;
	}
	
	public function emptyPassword()
	{
		$this->addStrategy('passwd', new EmptyString());
		return $this;
	}
	
	/**
	 * @param \User\Model\User $object
	 * @return array
	 */
	public function extract($object)
	{
		return array(
			'userId'		=> $object->getUserId(),
			'firstname'		=> $object->getFirstname(),
			'lastname'		=> $object->getLastname(),
			'email'			=> $object->getEmail(),
			'passwd'		=> $this->extractValue('passwd', $object->getPasswd()),
			'role'			=> $object->getRole(),
			'dateCreated'	=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'	=> $this->extractValue('dateModified', $object->getDateModified()),
		);
	}
}
