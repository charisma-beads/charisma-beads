<?php

declare(strict_types=1);

namespace User\Service;

use User\Authentication\Adapter as AuthAdapter;
use User\Authentication\Storage;
use User\Model\UserModel as UserModel;
use User\Options\AuthOptions;
use Zend\Authentication\AuthenticationService as ZendAuthenticationService;

class Authentication extends ZendAuthenticationService
{
    /**
     * @var AuthAdapter
     */
    protected $authAdapter;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var LimitLoginService
     */
    protected $limitLoginService;

    /**
     * @var AuthOptions
     */
    protected $options;

    /**
     * @return UserService
     */
    public function getUserService(): UserService
    {
        return $this->userService;
    }

    public function setUserService(UserService $service): Authentication
    {
        $this->userService = $service;
        return $this;
    }

    public function getLimitLoginService(): LimitLoginService
    {
        return $this->limitLoginService;
    }

    public function setLimitLoginService(LimitLoginService $limitLoginService): Authentication
    {
        $this->limitLoginService = $limitLoginService;
        return $this;
    }

    public function getOptions(): AuthOptions
    {
        return $this->options;
    }

    public function setOptions(AuthOptions $options): void
    {
        $this->options = $options;
    }

    public function doAuthentication(string $identity, string $password): bool
    {
        $authMethod = $this->getOptions()->getAuthenticateMethod();
        $user = $this->getUserService()->$authMethod(
            $identity,
            null,
            false,
            true
        );

        if (!$user) {
            return false;
        }

        // hash the password and verify.
        $adapter = $this->getAuthAdapter($password, $user);
        $result = $this->authenticate($adapter);

        if (!$result->isValid()) {
            return false;
        }

        $user = $result->getIdentity();

        if (in_array('update password', $result->getMessages())) {
            $user->setPasswd($password);
            $user->setDateModified();
            $this->getUserService()->save($user);
        }

        $user->setPasswd(null);

        $this->getStorage()->write($user);

        return true;
    }

    public function checkIp()
    {

    }

    public function getAuthAdapter(string $password, UserModel $user): AuthAdapter
    {
        if (null === $this->authAdapter) {

            $authAdapter = new AuthAdapter();

            $authAdapter->setIdentity($user);
            $authAdapter->setCredential($password);
            $authAdapter->setCredentialTreatment($this->getOptions()->getCredentialTreatment());

            if ($this->getOptions()->isUseFallbackTreatment()) {
                $authAdapter->setUseFallback($this->getOptions()->isUseFallbackTreatment());
                $authAdapter->setFallbackCredentialTreatment($this->getOptions()->getFallbackCredentialTreatment());
            }

            $this->setAuthAdapter($authAdapter);
        }

        return $this->authAdapter;
    }

    public function setAuthAdapter(AuthAdapter $adapter): void
    {
        $this->authAdapter = $adapter;
    }

    public function clear(): void
    {
        $this->getStorage()->forgetMe();
        $this->clearIdentity();
    }
}
