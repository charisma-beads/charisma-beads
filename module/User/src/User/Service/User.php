<?php
namespace User\Service;

use Application\Service\AbstractService;
use User\Model\User as UserModel;

class User extends AbstractService
{   
	protected $mapperClass = 'User\Mapper\User';
	protected $form = 'User\Form\User';
	protected $inputFilter = 'User\InputFilter\User';
    
    public function getUserByEmail($email, $ignore=null)
    {
    	$email = (string) $email;
    	return $this->getMapper()->getUserByEmail($email, $ignore);
    }
    
    public function fetchAllUsers($post = array())
    {
    	return $this->getMapper()->fetchAllUsers($post);
    }
    
    public function edit(UserModel $user, $post)
    {
    	if (!isset($post['role'])) {
    		$post['role'] = $user->getRole();
    	}
    	
    	$form  = $this->getForm($user, $post);
    	
    	$form->getInputFilter()->get('passwd')->setRequired(false);
    	$form->getInputFilter()->get('passwd')->setAllowEmpty(true);
    	
    	if (!$form->isValid()) {
			return $form;
		}
		
		return $this->save($form->getData());
    }
    
    public function save(UserModel $user)
    {
    	$user->setDateModified();
    	
    	$data = $this->getMapper()->extract($user);
    
    	if (array_key_exists('passwd', $data) && '' != $data['passwd']) {
    		$authOptions = $this->getConfig('user');
    		$hash = str_replace('(?)', '', strtolower($authOptions['auth']['credentialTreatment']));
    		$data['passwd'] = $hash($data['passwd']);
    	} else {
    		unset($data['passwd']);
    	}
    
    	// TODO check for existing email.
    
 		return parent::save($data);
    }
}
