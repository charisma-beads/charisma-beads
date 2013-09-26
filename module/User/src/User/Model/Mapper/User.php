<?php
namespace User\Model\Mapper;

use Application\Model\AbstractMapper;
use User\Model\Entity\User as UserEntity;
use User\Model\UserException;

class User extends AbstractMapper
{   
    /**
     * @var User\Model\DbTable\User
     */
    protected $userGateway;
    
    /**
     * @var User\Form\User
     */
    protected $userForm;
    
    public function getUserById($id)
    {
    	$id = (int) $id;
    	return $this->getUserGateway()->getById($id);
    }
    
    public function getUserByEmail($email, $ignore=null)
    {
    	$email = (string) $email;
    	return $this->getUserGateway()->getUserByEmail($email, $ignore);
    }
    
    public function fetchAllUsers($post = array())
    {
    	return $this->getUserGateway()->fetchAllUsers($post);
    }
    
    public function addUser($post)
    {
    	$form  = $this->getUserForm();
    	$user = new UserEntity();
    
    	$form->setInputFilter($user->getInputFilter());
    	$form->setData($post);
    
    	if (!$form->isValid()) {
    		return $form;
    	}
    
    	$user->exchangeArray($form->getData());
    
    	return $this->saveUser($user);
    }
    
    public function editUser(UserEntity $user, $post)
    {
    	$form  = $this->getUserForm();
    
    	$form->setInputFilter($user->getInputFilter());
    	$form->getInputFilter()->get('passwd')->setRequired(false);
    	$form->getInputFilter()->get('passwd')->setAllowEmpty(true);
    
    	if (!isset($post['role'])) {
    		$post['role'] = $user->role;
    	}
    
    	$form->bind($user);
    	$form->setData($post);
    
    	if (!$form->isValid()) {
    		return $form;
    	}
    
    	return $this->saveUser($form->getData());
    }
    
    public function saveUser(UserEntity $user)
    {
    	$id = (int) $user->userId;
    	$data = $user->getArrayCopy();
    
    	if (array_key_exists('passwd', $data) && '' != $data['passwd']) {
    		$authOptions = $this->getConfig('user');
    		$hash = str_replace('(?)', '', strtolower($authOptions['auth']['credentialTreatment']));
    		$data['passwd'] = $hash($data['passwd']);
    	} else {
    		unset($data['passwd']);
    	}
    
    	if (0 === $id) $data['dateCreated'] = $this->currentDate();
    	$data['dateModified'] = $this->currentDate();
    
    	// TODO check for existing email.
    
    	if ($id == 0) {
    		$result = $this->getUserGateway()->insert($data);
    	} else {
    		if ($this->getUserById($id)) {
    			$result = $this->getUserGateway()->update($id, $data);
    		} else {
    			throw new UserException('User id does not exist');
    		}
    	}
    
    	return $result;
    }
    
    public function deleteUser($id)
    {
    	$id = (int) $id;
    	return $this->getUserGateway()->delete($id);
    }
    
    /**
     * @return \User\Form\User
     */
    public function getUserForm()
    {
    	if (!$this->userForm){
    		$sl = $this->getServiceLocator();
    		$this->userForm = $sl->get('User\Form\User');
    	}
    	 
    	return $this->userForm;
    }
    
    /**
     * @return \User\Model\DbTable\User
     */
    protected function getUserGateway()
    {
    	if (!$this->userGateway){
    		$sl = $this->getServiceLocator();
    		$this->userGateway = $sl->get('User\Gateway\User');
    	}
    	
    	return $this->userGateway;
    }
}
