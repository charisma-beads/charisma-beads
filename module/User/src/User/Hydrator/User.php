<?php
namespace User\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;
use User\Model\User;

class User extends AbstractHydrator
{
	public function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		
		$this->addStrategy('dateCreated', $dateTime);
		$this->addStrategy('dateModified', $dateTime);
	}
	
	public function extract(User $object)
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
