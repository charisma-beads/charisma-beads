<?php
namespace User\Model;

use User\Model\User;
use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Db\Adapter\Adapter as DbAapter;

class Authentication extends ZendAuthenticationService
{
    /**
     * @var AuthAdapter
     */
    protected $authAdapter;
    
    /**
     * @var DbAapter
     */
    protected $dbAdapter;
    
    /**
     * @var User\Model\User
     */
    protected $userModel;
    
    /**
     * @var ZendAuthenticationService
     */
    protected $auth;
    
    /**
     * Auth options
     */
    protected $options;
    
    /**
     *  Sets the db adapter
     *  
     * @param DbAapter $dbAdapter
     * @return \User\Model\Authentication
     */
    public function setDbAdapter(DbAapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        return $this;
    }
    
    /**
     * Set the user model
     * 
     * @param User $model
     * @return \User\Model\Authentication
     */
    public function setUserModel(User $model)
    {
        $this->userModel = $model;
        return $this;
    }
    
    /**
     * Sets the auth options
     * 
     * @param array $options
     */
    public function setOptions(array $options)
    {
    	$this->options = $options;
    }
    
    /**
     * Authenticate a user
     *
     * @param  array $credentials Matched pair array containing email/passwd
     * @return boolean
     */
    public function authenticate($credentials)
    {
    	$adapter    = $this->getAuthAdapter($credentials);
    	$result     = parent::authenticate($adapter);
    
    	if (!$result->isValid()) {
    		return false;
    	}
    
    	$user = $this->userModel
    	->getUserByEmail($credentials['email']);
    
    	$this->getStorage()->write($user);
    
    	return true;
    }
    
    /**
     * Clear any authentication data
     */
    public function clear()
    {
    	$this->clearIdentity();
    }
    
    /**
     * Set the auth adpater.
     *
     * @param AuthAdapter $adapter
     */
    public function setAuthAdapter(AuthAdapter $adapter)
    {
    	$this->authAdapter = $adapter;
    }
    
    /**
     * Get and configure the auth adapter
     *
     * @param  array $value Array of user credentials
     * @return AuthAdapter
     */
    public function getAuthAdapter($values)
    {
    	if (null === $this->authAdapter) {
    
    		$authAdapter = new AuthAdapter(
    			$this->dbAdapter,
    			$this->options['dbTable'],
    			$this->options['identity'],
    			$this->options['credential']
    		);
    
    		$this->setAuthAdapter($authAdapter);
    		$this->authAdapter->setIdentity(
    			$values['email']
    		);
    
    		$this->authAdapter->setCredential(
    			$this->options['hash']($values['passwd'])
    		);
    	}
    
    	return $this->authAdapter;
    }
}