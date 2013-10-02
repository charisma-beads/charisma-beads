<?php
namespace User\Service;

use Application\Service\AbstractService;
use User\Hydrator\User as UserHydrator;
use User\Model\User as UserEntity;
use User\UserException;

class User extends AbstractService
{   
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
        $user = $this->getMapper()->getModel($post);
    	$form  = $this->getUserForm($user);
    
    	if (!$form->isValid()) {
    		return $form;
    	}
    
    	return $this->saveUser($form->getData());
    }
    
    public function editUser(UserEntity $user, $post)
    {
    	if (!isset($post['role'])) {
    		$post['role'] = $user->getRole();
    	}
    	
    	$form  = $this->getUserForm($user, $post);
        
    	$form->getInputFilter()->get('passwd')->setRequired(false);
    	$form->getInputFilter()->get('passwd')->setAllowEmpty(true);
    
    	if (!$form->isValid()) {
    		return $form;
    	}
    
    	return $this->saveUser($form->getData());
    }
    
    public function saveUser(UserEntity $user)
    {
    	$id = (int) $user->getUserId();
    	$data = $user->getArrayCopy();
    
    	if (array_key_exists('passwd', $data) && '' != $data['passwd']) {
    		$authOptions = $this->getConfig('user');
    		$hash = str_replace('(?)', '', strtolower($authOptions['auth']['credentialTreatment']));
    		$data['passwd'] = $hash($data['passwd']);
    	} else {
    		unset($data['passwd']);
    	}
    
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
     * TODO: make this a seperate service and set input filter too from service.
     * @return \User\Form\User
     */
    public function getUserForm($model=null, $data=null)
    {
    	$sl = $this->getServiceLocator();
    	$form = $sl->get('User\Form\User');
    	$form->setInputFilter($sl->get('User\InputFilter\User'));
    	$form->setHydrator(new UserHydrator());
    	
    	if ($model) {
    		$form->bind($model);
    	}
    	
    	if ($data) {
    		$form->setData($data);
    	}
    	 
    	return $form;
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
