<?php

declare(strict_types=1);

namespace User\Model;

use Common\Model\ModelInterface;
use Common\Model\Model;
use Laminas\Math\Rand;

class UserRegistrationModel implements ModelInterface
{
    use Model,
        UserTrait;

    const REQUEST_KEY_LENGTH = 16;

    /**
     * @var int
     */
    protected $userRegistrationId;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var \DateTime
     */
    protected $requestTime;

    /**
     * @var bool
     */
    protected $responded = false;

    public function getUserRegistrationId(): ?int
    {
        return $this->userRegistrationId;
    }

    public function setUserRegistrationId(int $userRegistrationId): UserRegistrationModel
    {
        $this->userRegistrationId = $userRegistrationId;
        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): UserRegistrationModel
    {
        $this->token = $token;
        return $this;
    }

    public function generateToken(): void
    {
        $this->setToken(Rand::getString(
            self::REQUEST_KEY_LENGTH,
            'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
        ));
    }

    public function getRequestTime(): ?\DateTime
    {
        return $this->requestTime;
    }

    public function setRequestTime(?\DateTime $requestTime): UserRegistrationModel
    {
        $this->requestTime = $requestTime;
        return $this;
    }

    public function getResponded(): ?bool
    {
        return $this->responded;
    }

    public function setResponded(bool $responded): UserRegistrationModel
    {
        $this->responded = $responded;
        return $this;
    }
}
