<?php

namespace User\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

class AuthenticationService extends ZendAuthenticationService implements FactoryInterface
{
    /**
     * @var AuthAdapter
     */
    protected $authAdapter;

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
    
    public function createService(ServiceLocatorInterface $sm)
    {
        $this->dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $this->userModel = $sm->get('User\Model\User');
        return $this;
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

            $treatment = $this->options['credentialTreatment'];

            $authAdapter = new AuthAdapter(
                $this->dbAdapter,
                'user',
                'email',
                'passwd'
            );

            $this->setAuthAdapter($authAdapter);
            $this->authAdapter->setIdentity(
                $values['email']
            );

            $this->authAdapter->setCredential(
                sha1($values['passwd'])
            );
        }

        return $this->authAdapter;
    }
}
