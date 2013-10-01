<?php
namespace User\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;

class User extends AbstractHydrator
{
	public function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		
		$this->addStrategy('dateCreated', $dateTime);
		$this->addStrategy('dateModified', $dateTime);
	}
	
	/**
	 * @param \User\Model\User $object
	 * @return array
	 */
	public function extract($object)
	{
		return array(
			'userId'		=> $this->getUserId(),
			'firstname'		=> $this->getFirstname(),
			'lastname'		=> $this->getLastname(),
			'email'			=> $this->getEmail(),
			'passwd'		=> $this->getPasswd(),
			'role'			=> $this->getRole(),
			'dateCreated'	=> $this->extractValue('dateCreated', $this->getDateCreated()),
			'dateModified'	=> $this->extractValue('dateModified', $this->getDateModified()),
		);
	}
}
