<?php

declare(strict_types=1);

namespace User\Authentication;

use User\Model\UserModel as UserModel;
use Laminas\Authentication\Adapter\AbstractAdapter;
use Laminas\Authentication\Result as AuthenticationResult;
use Laminas\Crypt\Password\PasswordInterface;

class Adapter extends AbstractAdapter
{
    /**
     * @var UserModel
     */
    protected $identity;

    /**
     * @var string
     */
    protected $credentialTreatment;

    /**
     * @var string
     */
    protected $fallbackCredentialTreatment;

    /**
     * @var bool
     */
    protected $useFallback = false;

    /**
     * @return AuthenticationResult
     */
    public function authenticate()
    {
        $messages = [];

        if ($this->verifyPassword(false)) {
            $code = AuthenticationResult::SUCCESS;
            $messages[] = 'Authentication successful.';
        } elseif ($this->getUseFallback() && $this->verifyPassword(true)) {
            $code = AuthenticationResult::SUCCESS;
            $messages[] = 'Authentication successful.';
            $messages[] = 'update password';
        } else {
            $code = AuthenticationResult::FAILURE;
            $messages[] = 'Authentication failed.';
        }

        return new AuthenticationResult(
            $code,
            $this->getIdentity(),
            $messages
        );
    }

    public function verifyPassword(bool $useFallback): bool
    {
        /* @var $class PasswordInterface */
        if ($useFallback === false) {
            $class = new $this->credentialTreatment;
        } else {
            $class = new $this->fallbackCredentialTreatment;
        }

        try {
            $verified = $class->verify(
                $this->getCredential(),
                $this->getIdentity()->getPasswd()
            );
        } catch (\Exception $e) {
            $verified = false;
        }

        return $verified;
    }

    public function getUseFallback(): bool
    {
        return $this->useFallback;
    }

    public function setUseFallback(bool $useFallback): Adapter
    {
        $this->useFallback = $useFallback;
        return $this;
    }

    public function getCredentialTreatment(): string
    {
        return $this->credentialTreatment;
    }

    public function setCredentialTreatment(string $credentialTreatment): Adapter
    {
        $this->credentialTreatment = $credentialTreatment;
        return $this;
    }

    public function getFallbackCredentialTreatment(): string
    {
        return $this->fallbackCredentialTreatment;
    }

    public function setFallbackCredentialTreatment(string $fallbackCredentialTreatment): Adapter
    {
        $this->fallbackCredentialTreatment = $fallbackCredentialTreatment;
        return $this;
    }
}
