<?php
namespace Shop\Model\Advert;

use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\DateCreatedTrait;

class Hit implements ModelInterface
{
    use Model,
        DateCreatedTrait;
    
    /**
     * @var int
     */
    protected $advertHitId;
    
    /**
     * @var int
     */
    protected $advertId;
    
    /**
     * @var int
     */
    protected $userId;
 
    /**
     * @return int $advertHitId
     */
    public function getAdvertHitId()
    {
        return $this->advertHitId;
    }

    /**
     * @param int $advertHitId
     * @return $this
     */
    public function setAdvertHitId($advertHitId)
    {
        $this->advertHitId = $advertHitId;
        return $this;
    }

    /**
     * @return int $advertId
     */
    public function getAdvertId()
    {
        return $this->advertId;
    }

     /**
     * @param int $advertId
     * @return $this
     */
    public function setAdvertId($advertId)
    {
        $this->advertId = $advertId;
        return $this;
    }

    /**
     * @return int $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
}
