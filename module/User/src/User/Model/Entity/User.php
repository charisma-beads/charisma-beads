<?php
namespace User\Model\Entity;

use Application\Model\Entity\AbstractEntity;

class User extends AbstractEntity
{   
	/**
	 * @var int
	 */
	protected $userId;
	
	/**
	 * @var string
	 */
	protected $firstname;
	
	/**
	 * @var string
	 */
	protected $lastname;
	
	/**
	 * @var string
	 */
	protected $email;
	
	/**
	 * @var string
	 */
	protected $passwd;
	
	/**
	 * @var string
	 */
	protected $role;
	
	/**
	 * @var string
	 */
	protected $dateCreated;
	
	/**
	 * @var string
	 */
	protected $dateModified;
	
	protected $inputFilterClass = 'User\InputFilter\User';
	
	public function exchangeArray(array $data)
	{
		$this->setUserId($data['userId'])
			->setFirstname($data['firstname'])
			->setLastname($data['lastname'])
			->setEmail($data['email'])
			->setPasswd($data['passwd'])
			->setRole($data['role'])
			->setDateCreated($data['dateCreated'])
			->setDateModified($data['dateModified']);
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array(
			'userId'		=> $this->getUserId(),
			'firstname'		=> $this->getFirstname(),
			'lastname'		=> $this->getLastname(),
			'email'			=> $this->getEmail(),
			'passwd'		=> $this->getPasswd(),
			'role'			=> $this->getRole(),
			'dateCreated'	=> $this->getDateCreated(),
			'dateModified'	=> $this->getDateModified()
		);
	}
	
    /**
	 * @return the $userId
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @param number $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @return the $firstname
	 */
	public function getFirstname()
	{
		return $this->firstname;
	}

	/**
	 * @param string $firstname
	 */
	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;
		return $this;
	}

	/**
	 * @return the $lastmane
	 */
	public function getLastname()
	{
		return $this->lastname;
	}

	/**
	 * @param string $lastmane
	 */
	public function setLastname($lastname)
	{
		$this->lastname = $lastname;
		return $this;
	}

	/**
	 * @return the $email
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return the $passwd
	 */
	public function getPasswd()
	{
		return $this->passwd;
	}

	/**
	 * @param string $passwd
	 */
	public function setPasswd($passwd)
	{
		$this->passwd = $passwd;
		return $this;
	}

	/**
	 * @return the $role
	 */
	public function getRole()
	{
		return $this->role;
	}

	/**
	 * @param string $role
	 */
	public function setRole($role)
	{
		$this->role = $role;
		return $this;
	}

	/**
	 * @return the $dateCreated
	 */
	public function getDateCreated()
	{
		return $this->dateCreated;
	}

	/**
	 * @param string $dateCreated
	 */
	public function setDateCreated($dateCreated)
	{
		$this->dateCreated = $dateCreated;
		return $this;
	}

	/**
	 * @return the $dateModified
	 */
	public function getDateModified()
	{
		return $this->dateModified;
	}

	/**
	 * @param string $dateModified
	 */
	public function setDateModified($dateModified)
	{
		$this->dateModified = $dateModified;
		return $this;
	}

	public function getFullName()
    {
    	return $this->getFirstname() . ' ' . $this->getLastname();
    }
    
    public function getLastNameFirst()
    {
    	return $this->getLastname() . ', ' . $this->getFirstname();
    }
}
