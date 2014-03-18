<?php
namespace User\Service;

use Zend\Form\Form;
use Application\Model\ModelInterface;
use Application\Service\AbstractService;
use User\UserException;
use User\Model\User as UserModel;
use Zend\Crypt\Password\PasswordInterface;

class User extends AbstractService
{   
	protected $mapperClass = 'User\Mapper\User';
	protected $form = 'User\Form\User';
	protected $inputFilter = 'User\InputFilter\User';
    
    public function getUserByEmail($email, $ignore=null, $emptyPassword = true)
    {
    	$email = (string) $email;
    	return $this->getMapper()->getUserByEmail($email, $ignore, $emptyPassword);
    }
    
    /**
	 * prepare data to be updated and saved into database.
	 * 
	 * @param UserModel $model
	 * @param array $post
	 * @param Form $form
	 * @return int results from self::save()
	 */
    public function edit(ModelInterface $model, array $post, Form $form = null)
    {
        if (!$model instanceof UserModel) {
            throw new UserException('$model must be an instance of User\Model\User, ' . get_class($model) . ' given.');
        }
        
    	if (!isset($post['role'])) {
    		$post['role'] = $model->getRole();
    	}
    	
    	$model->setDateModified();
    	
    	$form  = $this->getForm($model, $post, true, true);
    	
    	// we need to find if this email has changed,
    	// if not then exclude it from validation,
    	// if changed then revalidate it.
    	if ($model->getEmail() === $post['email']) {
    	    
    	    $validatorChain = $form->getInputFilter()
    	       ->get('email')
    	       ->getValidatorChain()
    	       ->getValidators();
    	    
    	    foreach ($validatorChain as $validator) {
    	        if ($validator['instance'] instanceof \Zend\Validator\Db\NoRecordExists) {
    	            $validator['instance']->setExclude(array(
	                    'field' => 'email',
	                    'value' => $model->getEmail(),
    	            ));
    	        }
    	    }
    	}
    	
    	$form->setValidationGroup('firstname', 'lastname', 'email', 'userId');
		
		return parent::edit($model, $post, $form);
    }
    
    /**
     * @param array $post
     * @param UserModel $user
     * @return Ambigous <object, multitype:, \User\Form\Password>
     */
    public function changePasswd(array $post, UserModel $user)
    {
        $sl = $this->getServiceLocator();
        $form = $sl->get('User\Form\Password');
        
        $form->setInputFilter($sl->get('User\InputFilter\Password'));
        $form->setData($post);
        $form->setHydrator($this->getMapper()->getHydrator());
        $form->bind($user);
        
        if (!$form->isValid()) {
            return $form;
        }
        
        /* @var $data UserModel */
        $data = $form->getData();
        $data->setDateModified();
        
        return $this->save($data);
    }
    
    public function resetPassword()
    {
        
    }
    
    public function save($data)
    {	
        if ($data instanceof UserModel) {
            $data = $this->getMapper()->extract($data);
        }
        
    	if (array_key_exists('passwd', $data) && '' != $data['passwd']) {
    		$data['passwd'] = $this->createPassword($data['passwd']);
    	} else {
    		unset($data['passwd']);
    	}
    
 		return parent::save($data);
    }
    
    public function createPassword($password)
    {
        $authOptions = $this->getConfig('user');
        
        if (!class_exists($authOptions['auth']['credentialTreatment'])) {
            throw new UserException('Credential treatment must be an class name');
        } else {
            /* @var $crypt PasswordInterface */
            $crypt = new $authOptions['auth']['credentialTreatment'];
        }
        
        if (!$crypt instanceof PasswordInterface) {
            throw new UserException('Credential treatment must be an instance of Zend\Crypt\Password\PasswordInterface');
        }
        
        $password = $crypt->create($password);
        
        return $password;
    }
}
