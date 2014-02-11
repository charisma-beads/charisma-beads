<?php
namespace User\Service;

use Zend\Form\Form;
use Application\Model\ModelInterface;
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
    	
    	$form->getInputFilter()->get('passwd')->setRequired(false);
    	$form->getInputFilter()->get('passwd')->setAllowEmpty(true);
    	$form->getInputFilter()->get('passwd-confirm')->setRequired(false);
    	$form->getInputFilter()->get('passwd-confirm')->setAllowEmpty(true);
		
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
