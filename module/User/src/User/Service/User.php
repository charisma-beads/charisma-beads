<?php
namespace User\Service;

use Application\Service\AbstractService;
use User\Model\User as UserEntity;
use User\UserException;

class User extends AbstractService
{   
    /**
     * @var User\Form\User
     */
    protected $userForm;
    
    public function getUserById($id)
    {
    	$id = (int) $id;
    	return $this->getMapper()->getById($id);
    }
    
    public function getUserByEmail($email, $ignore=null)
    {
    	$email = (string) $email;
    	return $this->getMapper()->getUserByEmail($email, $ignore);
    }
    
    public function fetchAllUsers($post = array())
    {
    	return $this->getMapper()->fetchAllUsers($post);
    }
    
    public function addUser($post)
    {
    	$form  = $this->getUserForm();
    	$user = $this->getMapper()->getModel($post);
    
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
    		$result = $this->getMapper()->insert($data);
    	} else {
    		if ($this->getUserById($id)) {
    			$result = $this->getMapper()->update($id, $data);
    		} else {
    			throw new UserException('User id does not exist');
    		}
    	}
    
    	return $result;
    }
    
    public function deleteUser($id)
    {
    	$id = (int) $id;
    	return $this->getMapper()->delete($id);
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
	 * @return \User\Mapper\User
	 */
	public function getMapper()
	{
		if (!$this->mapper){
			$sl = $this->getServiceLocator();
			$this->mapper = $sl->get('User\Mapper\User');
		}
		 
		return $this->mapper;
	}
}
