<?php
namespace User\Service;

use Zend\Form\Form;
use Application\Model\AbstractModel;
use Application\Service\AbstractService;
use User\UserException;
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
    
    public function edit(AbstractModel $model, array $post, Form $form = null)
    {
        if (!$model instanceof UserModel) {
            throw new UserException('$model must be an instance of User\Model\User, ' . get_class($model) . ' given.');
        }
        
    	if (!isset($post['role'])) {
    		$post['role'] = $model->getRole();
    	}
    	
    	$model->setDateModified();
    	
    	$form  = $this->getForm($model, $post, true, true);
    	
    	$form->getInputFilter()->get('passwd')->setRequired(false);
    	$form->getInputFilter()->get('passwd')->setAllowEmpty(true);
		
		return parent::edit($model, $post, $form);
    }
    
    public function save($data)
    {	
        if ($data instanceof UserModel) {
            $data = $this->getMapper()->extract($data);
        }
        
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
