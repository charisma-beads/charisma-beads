<?php
namespace User\Model;

use Application\Model\AbstractModel;
use User\Model\Entity\UserEntity;
use User\Model\UserException;

class User extends AbstractModel
{
    protected $classMap = array(
		'gateways' => array(
			'user' => 'User\Model\DbTable\UserTable',
		),
		'entities' => array(
			'user' => 'User\Model\Entity\UserEntity',
		),
		'forms' => array(
			'user' => 'User\Form\UserForm'
		)
    );
    
    public function getUserById($id)
    {
    	$id = (int) $id;
    	return $this->getGateway('user')->getById($id);
    }
    
    public function getUserByEmail($email, $ignore=null)
    {
    	$email = (string) $email;
    	return $this->getGateway('user')->getUserByEmail($email, $ignore);
    }
    
    public function fetchAllUsers()
    {
    	return $this->getGateway('user')->fetchAll();
    }
    
    public function addUser($post)
    {
    	$form  = $this->getForm('user');
    	$user = $this->getEntity('user');
    	$user->setColumns($this->getGateway('user')->getColumns());
    
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
    	$form  = $this->getForm('user');
    
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
    		$data['passwd'] = sha1($data['passwd']);
    	} else {
    		unset($data['passwd']);
    	}
    
    	if (0 === $id) $data['dateCreated'] = $this->currentDate();
    	$data['dateModified'] = $this->currentDate();
    
    	// TODO check for existing email.
    
    	if ($id == 0) {
    		$result = $this->getGateway('user')->insert($data);
    	} else {
    		if ($this->getUserById($id)) {
    			$result = $this->getGateway('user')->update($id, $data);
    		} else {
    			throw new UserException('User id does not exist');
    		}
    	}
    
    	return $result;
    }
    
    public function deleteUser($id)
    {
    	$id = (int) $id;
    	return $this->getGateway('user')->delete($id);
    }
}
